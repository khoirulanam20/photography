<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingProgress;
use App\Http\Requests\UpdateBookingProgressRequest;
use Illuminate\Http\Request;
use App\Services\FonteeWhatsAppService;

class BookingProgressController extends Controller
{
    /**
     * Show progress form (untuk admin)
     */
    public function edit($bookingId)
    {
        $booking = Booking::with('progress')->findOrFail($bookingId);

        if ($booking->status !== 'Diproses') {
            return redirect()->route('admin.booking.show', $bookingId)
                ->with('error', 'Progress hanya bisa diupdate untuk booking dengan status Diproses.');
        }

        return view('admin.booking.progress', compact('booking'));
    }

    /**
     * Update progress
     */
    public function update(UpdateBookingProgressRequest $request, $bookingId)
    {
        $booking = Booking::with(['layanan', 'progress'])->findOrFail($bookingId);
        $progress = $booking->progress;

        if (!$progress) {
            return redirect()->route('admin.booking.show', $bookingId)
                ->with('error', 'Progress belum dibuat.');
        }

        $data = [];

        if ($request->has('jadwal_foto')) {
            $data['jadwal_foto'] = $request->jadwal_foto;
            if ($request->jadwal_foto) {
                $data['jadwal_foto_at'] = now();
            }
        }

        if ($request->has('file_jpg_upload')) {
            $data['file_jpg_upload'] = $request->file_jpg_upload;
            $data['file_jpg_link'] = $request->file_jpg_link;
            if ($request->file_jpg_upload) {
                $data['file_jpg_upload_at'] = now();
            }
        }

        if ($request->has('selected_photos')) {
            $data['selected_photos'] = $request->selected_photos;
            $data['selected_photos_link'] = $request->selected_photos_link;
            if ($request->selected_photos) {
                $data['selected_photos_at'] = now();
            }
        }

        if ($request->has('file_raw_upload')) {
            $data['file_raw_upload'] = $request->file_raw_upload;
            if ($request->file_raw_upload) {
                $data['file_raw_upload_at'] = now();
            }
        }

        if ($request->has('editing_foto')) {
            $data['editing_foto'] = $request->editing_foto;
            if ($request->editing_foto) {
                $data['editing_foto_at'] = now();
            }
        }

        if ($request->has('foto_edited_upload')) {
            $data['foto_edited_upload'] = $request->foto_edited_upload;
            if ($request->foto_edited_upload) {
                $data['foto_edited_upload_at'] = now();
            }
        }

        $old = $progress->toArray();
        $progress->update($data);
        $progress->refresh();

        $progressData = [];
        $changesDetected = false;
        $fields = [
            'jadwal_foto',
            'file_jpg_upload',
            'selected_photos',
            'file_raw_upload',
            'editing_foto',
            'foto_edited_upload'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $newValue = (bool) ($progress->$field ?? false);
                $oldValue = (bool) ($old[$field] ?? false);
                if ($newValue !== $oldValue) {
                    $changesDetected = true;
                    $progressData[$field] = $newValue;
                } elseif ($request->boolean($field)) {
                    $progressData[$field] = true;
                    $changesDetected = true;
                }
            }
        }

        if ($request->filled('file_jpg_link') || $request->filled('google_drive_link')) {
            $newLink = $request->input('file_jpg_link', $request->input('google_drive_link'));
            $progressData['file_jpg_link'] = $newLink;
            if (($old['file_jpg_link'] ?? null) !== $newLink) {
                $changesDetected = true;
            }
        }

        if ($request->filled('selected_photos_link')) {
            $progressData['selected_photos_link'] = $request->selected_photos_link;
            if (($old['selected_photos_link'] ?? null) !== $request->selected_photos_link) {
                $changesDetected = true;
            }
        }

        if ($request->filled('foto_edited_upload_link')) {
            $progressData['foto_edited_upload_link'] = $request->foto_edited_upload_link;
            if (($old['foto_edited_upload_link'] ?? null) !== $request->foto_edited_upload_link) {
                $changesDetected = true;
            }
        }

        if ($changesDetected) {
            try {
                $fontee = new FonteeWhatsAppService();
                $message = $fontee->formatProgressMessage($progressData, $booking);
                if (!empty($message)) {
                    $fontee->sendMessage($booking->telephone, $message);
                }
            } catch (\Exception $e) {
                logger()->error('Failed to send WhatsApp progress notification: ' . $e->getMessage());
            }
        }

        if (
            $progress->fresh()->jadwal_foto &&
            $progress->file_jpg_upload &&
            $progress->selected_photos &&
            $progress->file_raw_upload &&
            $progress->editing_foto &&
            $progress->foto_edited_upload
        ) {

            return redirect()->route('admin.booking.show', $bookingId)
                ->with('success', 'Progress berhasil diupdate! Semua tahapan selesai, Anda dapat mengubah status booking menjadi Selesai.');
        }

        return redirect()->route('admin.booking.show', $bookingId)
            ->with('success', 'Progress berhasil diupdate!');
    }

    /**
     * Quick update single progress item (untuk AJAX)
     */
    public function quickUpdate(Request $request, $bookingId)
    {
        try {
            $booking = Booking::with(['layanan', 'progress'])->findOrFail($bookingId);
            $progress = $booking->progress;

            if (!$progress) {
                $progress = BookingProgress::create(['booking_id' => $booking->id]);
                $booking->refresh();
            }

            $field = $request->field;
            $value = $request->boolean('value', false);
            $link = $request->input('link');

            $allowedFields = [
                'jadwal_foto',
                'file_jpg_upload',
                'selected_photos',
                'file_raw_upload',
                'editing_foto',
                'foto_edited_upload'
            ];

            if (!in_array($field, $allowedFields)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Field tidak valid'
                ], 400);
            }

            if ($value === true && in_array($field, ['file_jpg_upload', 'foto_edited_upload']) && (!is_string($link) || trim($link) === '')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mohon isi link Google Drive terlebih dahulu sebelum mencentang.'
                ], 422);
            }

            $oldValue = (bool) ($progress->$field ?? false);
            $oldLink = null;
            if (in_array($field, ['file_jpg_upload', 'selected_photos', 'foto_edited_upload'])) {
                $linkField = $field === 'file_jpg_upload' ? 'file_jpg_link' : ($field === 'selected_photos' ? 'selected_photos_link' : 'foto_edited_upload_link');
                $oldLink = $progress->$linkField ?? null;
            }

            $data = [$field => $value];

            if ($value) {
                $data[$field . '_at'] = now();
            }

            if ($link !== null) {
                if ($field === 'file_jpg_upload') {
                    $data['file_jpg_link'] = $link;
                } elseif ($field === 'selected_photos') {
                    $data['selected_photos_link'] = $link;
                } elseif ($field === 'foto_edited_upload') {
                    $data['foto_edited_upload_link'] = $link;
                }
            }

            $progress->update($data);
            $progress->refresh();

            $changesDetected = false;
            $progressData = [];

            if ($oldValue !== $value) {
                $changesDetected = true;
                $progressData[$field] = $value;
            }

            if ($link !== null) {
                $linkField = $field === 'file_jpg_upload' ? 'file_jpg_link' : ($field === 'selected_photos' ? 'selected_photos_link' : 'foto_edited_upload_link');
                $newLink = $link;
                if ($oldLink !== $newLink) {
                    $changesDetected = true;
                    $progressData[$linkField] = $newLink;
                }
            }

            if ($changesDetected) {
                try {
                    $fontee = new FonteeWhatsAppService();
                    $message = $fontee->formatProgressMessage($progressData, $booking);
                    if (!empty($message)) {
                        $fontee->sendMessage($booking->telephone, $message);
                    }
                } catch (\Exception $e) {
                    logger()->error('Failed to send WhatsApp progress notification (quickUpdate): ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Progress berhasil diupdate!',
                'timestamp' => $progress->{$field . '_at'} ? $progress->{$field . '_at'}->format('d M Y H:i') : null,
                'whatsapp_sent' => $changesDetected
            ]);
        } catch (\Exception $e) {
            logger()->error('Quick update progress error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
