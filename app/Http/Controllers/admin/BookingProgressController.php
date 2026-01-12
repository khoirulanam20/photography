<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingProgress;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\FonteeWhatsAppService;

class BookingProgressController extends Controller
{
    /**
     * Show the form for editing booking progress
     */
    public function edit($id)
    {
        $booking = Booking::with(['user', 'layanan', 'subLayanan', 'progress'])->findOrFail($id);

        return view('page_admin.booking.progress', compact('booking'));
    }

    /**
     * Update booking progress
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Diproses,Selesai,Ditolak',
            'catatan' => 'nullable|string|max:1000',
            'fotografer' => 'nullable|string|max:255',
            'biaya' => 'nullable|numeric|min:0',
        ]);

        $booking = Booking::with(['layanan', 'progress'])->findOrFail($id);

        $booking->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'fotografer' => $request->fotografer,
            'biaya' => $request->biaya,
        ]);

        $progress = $booking->progress ?? new BookingProgress(['booking_id' => $booking->id]);
        $old = $progress->exists ? $progress->toArray() : [];
        $progress->fill([
            'jadwal_foto' => $request->has('jadwal_foto'),
            'jadwal_foto_at' => $request->has('jadwal_foto') ? now() : ($progress->jadwal_foto_at ?? null),
            'file_jpg_upload' => $request->has('file_jpg_upload'),
            'file_jpg_upload_at' => $request->has('file_jpg_upload') ? now() : ($progress->file_jpg_upload_at ?? null),
            'selected_photos' => $request->has('selected_photos'),
            'selected_photos_at' => $request->has('selected_photos') ? now() : ($progress->selected_photos_at ?? null),
            'file_raw_upload' => $request->has('file_raw_upload'),
            'file_raw_upload_at' => $request->has('file_raw_upload') ? now() : ($progress->file_raw_upload_at ?? null),
            'editing_foto' => $request->has('editing_foto'),
            'editing_foto_at' => $request->has('editing_foto') ? now() : ($progress->editing_foto_at ?? null),
            'foto_edited_upload' => $request->has('foto_edited_upload'),
            'foto_edited_upload_at' => $request->has('foto_edited_upload') ? now() : ($progress->foto_edited_upload_at ?? null),
            'file_jpg_link' => $request->input('google_drive_link', $progress->file_jpg_link),
            'foto_edited_upload_link' => $request->input('foto_edited_upload_link', $progress->foto_edited_upload_link),
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);
        $progress->booking_id = $booking->id;
        $progress->save();

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
            $newValue = (bool) ($progress->$field ?? false);
            $oldValue = (bool) ($old[$field] ?? false);
            if ($newValue !== $oldValue) {
                $changesDetected = true;
                $progressData[$field] = $newValue;
            } elseif ($request->has($field) && $request->boolean($field)) {
                $progressData[$field] = true;
                $changesDetected = true;
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
                logger()->error('Failed to send WhatsApp progress notification (admin controller): ' . $e->getMessage());
            }
        }

        Alert::success('Berhasil', 'Progress booking berhasil diupdate!');
        return redirect()->route('admin.booking.show', $id);
    }

    /**
     * Quick update single progress item (untuk AJAX)
     */
    public function quickUpdate(Request $request, $id)
    {
        try {
            $booking = Booking::with(['layanan', 'progress'])->findOrFail($id);
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
