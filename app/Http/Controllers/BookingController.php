<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingProgress;
use App\Models\Layanan;
use App\Models\SubLayanan;
use App\Models\Payment;
use App\Models\Profil;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingAdminRequest;
use App\Services\FonteeWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingExport;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings (untuk user)
     */
    public function index()
    {
        $bookings = Booking::with(['layanan', 'subLayanan', 'payment', 'progress'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $layanans = Layanan::all();
        $profil = Profil::first();

        return view('page_web.booking.index', compact('bookings', 'layanans', 'profil'));
    }

    /**
     * Display a listing of all bookings (untuk admin)
     */
    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'layanan', 'subLayanan', 'payment', 'progress'])
            ->latest()
            ->paginate(20);

        return view('page_admin.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create()
    {
        $user = auth()->user();
        $layanans = Layanan::all();
        $profil = Profil::first();

        return view('page_web.booking.create', compact('user', 'layanans', 'profil'));
    }

    /**
     * Store a newly created booking
     */
    public function store(StoreBookingRequest $request)
    {
        $catatanData = [[
            'tanggal' => now()->format('d/m/Y'),
            'waktu' => now()->format('H:i'),
            'status' => 'Pending',
            'isi' => $request->catatan
        ]];

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'telephone' => $request->telephone,
            'area' => $request->area,
            'instagram' => $request->instagram,
            'layanan_id' => $request->layanan_id,
            'sub_layanan_id' => $request->sub_layanan_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'lokasi_photo' => $request->lokasi_photo,
            'catatan' => $catatanData,
            'status' => 'Pending',
        ]);

        try {
            $fonteeService = new FonteeWhatsAppService();
            $booking->load('layanan');
            $message = $fonteeService->formatStatusMessage('Pending', $request->catatan, $booking);
            $fonteeService->sendMessage($booking->telephone, $message);
        } catch (\Exception $e) {
            logger()->error('Failed to send WhatsApp notification on store: ' . $e->getMessage());
        }

        return redirect()->route('booking.show', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Silakan tunggu konfirmasi admin.');
    }

    /**
     * Display the specified booking
     */
    public function show($id)
    {
        $booking = Booking::with(['layanan', 'subLayanan', 'payment', 'progress'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        $profil = Profil::first();

        return view('page_web.booking.show', compact('booking', 'profil'));
    }

    public function invoice($id)
    {
        $booking = Booking::with(['layanan', 'subLayanan', 'payment', 'progress', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        $profil = Profil::first();

        return view('page_web.booking.invoice', compact('booking', 'profil'));
    }

    /**
     * Show the form for editing booking (untuk admin)
     */
    public function edit($id)
    {
        $booking = Booking::with(['user', 'layanan', 'subLayanan'])->findOrFail($id);

        return view('page_admin.booking.edit', compact('booking'));
    }

    /**
     * Update booking (untuk admin)
     */
    public function update(UpdateBookingAdminRequest $request, $id)
    {
        $booking = Booking::with('layanan')->findOrFail($id);
        $oldStatus = $booking->status;

        $updateData = [];
        if ($request->filled('catatan_baru')) {
            $catatanData = $booking->catatan;

            if (!is_array($catatanData)) {
                $catatanData = [];
            }

            $catatanBaru = [
                'tanggal' => now()->format('d/m/Y'),
                'waktu' => now()->format('H:i'),
                'status' => $request->status,
                'isi' => $request->catatan_baru
            ];

            $catatanData[] = $catatanBaru;
            $updateData['catatan'] = $catatanData;
        }

        $booking->update($request->only([
            'nama',
            'telephone',
            'booking_date',
            'layanan_id',
            'sub_layanan_id',
            'area',
            'fotografer',
            'instagram',
            'booking_time',
            'biaya',
            'lokasi_photo',
            'status'
        ]) + $updateData);

        $newStatus = $request->status;
        if ($oldStatus !== $newStatus) {
            try {
                $fonteeService = new FonteeWhatsAppService();
                $booking->refresh();
                $booking->load(['layanan', 'subLayanan']);

                $catatanText = $request->filled('catatan_baru') ? $request->catatan_baru : null;
                $message = $fonteeService->formatStatusMessage($newStatus, $catatanText, $booking);
                $fonteeService->sendMessage($booking->telephone, $message);
            } catch (\Exception $e) {
                logger()->error('Failed to send WhatsApp notification on update: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.booking.show', $id)
            ->with('success', 'Booking berhasil diupdate!');
    }

    /**
     * Update booking status via AJAX
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:Pending,Diterima,Diproses,Selesai,Ditolak,Dibatalkan',
                'catatan' => 'nullable|string|max:1000'
            ]);

            $booking = Booking::with('layanan')->findOrFail($id);
            $oldStatus = $booking->status;

            $updateData = [
                'status' => $request->status,
                'updated_at' => now()
            ];

            if ($request->filled('catatan')) {
                $catatanData = $booking->catatan;

                if (!is_array($catatanData)) {
                    $catatanData = [];
                }

                $catatanBaru = [
                    'tanggal' => now()->format('d/m/Y'),
                    'waktu' => now()->format('H:i'),
                    'status' => $request->status,
                    'isi' => $request->catatan
                ];

                $catatanData[] = $catatanBaru;
                $updateData['catatan'] = json_encode($catatanData);
            }

            DB::table('bookings')
                ->where('id', $booking->id)
                ->update($updateData);

            if ($request->status === 'Diproses' && !$booking->progress) {
                BookingProgress::create(['booking_id' => $booking->id]);
            }

            if ($oldStatus !== $request->status) {
                try {
                    $fonteeService = new FonteeWhatsAppService();
                    $catatanText = $request->filled('catatan') ? $request->catatan : null;
                    $message = $fonteeService->formatStatusMessage($request->status, $catatanText, $booking);
                    $fonteeService->sendMessage($booking->telephone, $message);
                } catch (\Exception $e) {
                    logger()->error('Failed to send WhatsApp status notification: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Status booking berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display booking detail (untuk admin)
     */
    public function adminShow($id)
    {
        $booking = Booking::with(['user', 'layanan', 'subLayanan', 'payment', 'progress'])
            ->findOrFail($id);

        return view('page_admin.booking.show', compact('booking'));
    }

    /**
     * Get sub layanan by layanan id (untuk AJAX)
     */
    public function getSubLayanan($layananId)
    {
        $subLayanans = SubLayanan::where('layanan_id', $layananId)->get();

        return response()->json($subLayanans);
    }

    /**
     * Get booking payment data (untuk modal payment)
     */
    public function getPaymentData($id)
    {
        try {
            $booking = Booking::where('user_id', auth()->id())
                ->findOrFail($id);

            $payments = $booking->payments ?? [];
            $biayaRaw = is_string($booking->biaya) ? preg_replace('/[^0-9]/', '', $booking->biaya) : $booking->biaya;
            $biaya = $biayaRaw ? (float) $biayaRaw : 0;

            $totalDibayar = 0;
            foreach ($payments as $payment) {
                if (($payment['status'] ?? 'Pending') === 'Terkonfirmasi') {
                    $nominal = isset($payment['nominal']) ? (float) preg_replace('/[^0-9.]/', '', (string) $payment['nominal']) : 0;
                    $totalDibayar += $nominal;
                }
            }

            $sisaBayar = max(0, $biaya - $totalDibayar);

            $formattedPayments = collect($payments)->map(function ($payment, $index) {
                $buktiTransferFilename = $payment['bukti_transfer'] ?? '';

                if (str_contains($buktiTransferFilename, 'payments/')) {
                    $buktiTransferFilename = str_replace('payments/', '', $buktiTransferFilename);
                }

                return [
                    'index' => $index,
                    'jenis_payment' => $payment['jenis_payment'] ?? '',
                    'nominal' => isset($payment['nominal']) ? (float) preg_replace('/[^0-9.]/', '', (string) $payment['nominal']) : 0,
                    'bukti_transfer' => $buktiTransferFilename,
                    'status' => $payment['status'] ?? 'Pending',
                    'catatan_admin' => $payment['catatan_admin'] ?? null,
                    'created_at' => $payment['created_at'] ?? null,
                    'updated_at' => $payment['updated_at'] ?? null,
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'biaya' => $biaya,
                'total_dibayar' => $totalDibayar,
                'sisa_bayar' => $sisaBayar,
                'payments' => $formattedPayments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data booking tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Delete booking (soft delete)
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.booking.index')
            ->with('success', 'Booking berhasil dihapus!');
    }

    /**
     * Show payment form
     */
    public function payment($id)
    {
        $booking = Booking::with(['layanan', 'subLayanan'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        $profil = Profil::first();

        return view('page_web.booking.payment', compact('booking', 'profil'));
    }

    /**
     * Store payment data
     */
    public function storePayment(Request $request, $id)
    {
        try {
            $request->validate([
                'jenis_payment' => 'required|in:DP,Fullpayment',
                'nominal' => 'required|numeric|min:1',
                'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

            $buktiPath = $this->uploadBuktiTransfer($request->file('bukti_transfer'));

            $payments = $booking->payments ?? [];

            $payments[] = [
                'jenis_payment' => $request->jenis_payment,
                'nominal' => $request->nominal,
                'bukti_transfer' => $buktiPath,
                'status' => 'Pending',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ];

            $booking->update([
                'payments' => $payments
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment berhasil disimpan!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $ve->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload dan convert gambar ke webp
     */
    private function uploadBuktiTransfer($file)
    {
        $filename = 'payment_' . time() . '.webp';
        $path = 'payments/' . $filename;

        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $image = $manager->read($file)->toWebp(90);

        Storage::disk('public')->put($path, (string) $image);

        return $path;
    }

    /**
     * Cancel booking order
     */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if (in_array($booking->status, [Booking::STATUS_DIPROSES, Booking::STATUS_SELESAI])) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak dapat dibatalkan karena status sudah ' . $booking->status
            ], 400);
        }

        $catatanData = $booking->catatan;
        if (!is_array($catatanData)) {
            $catatanData = [];
        }

        $catatanData[] = [
            'tanggal' => now()->format('d/m/Y'),
            'waktu' => now()->format('H:i'),
            'status' => 'Dibatalkan',
            'isi' => 'Dibatalkan oleh user'
        ];

        $booking->update([
            'status' => Booking::STATUS_DIBATALKAN,
            'catatan' => $catatanData
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dibatalkan!'
        ]);
    }

    /**
     * Export booking data to Excel
     */
    public function export()
    {
        return Excel::download(new BookingExport, 'booking_data_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Update booking progress
     */
    public function updateProgress(Request $request, $id)
    {
        $booking = Booking::with(['layanan', 'progress'])->findOrFail($id);

        $progress = $booking->progress ?? BookingProgress::create(['booking_id' => $booking->id]);
        $oldProgress = $progress->toArray();

        $progress->update([
            'jadwal_foto' => $request->has('jadwal_foto'),
            'jadwal_foto_at' => $request->has('jadwal_foto') ? now() : null,
            'file_jpg_upload' => $request->has('file_jpg_upload'),
            'file_jpg_upload_at' => $request->has('file_jpg_upload') ? now() : null,
            'selected_photos' => $request->has('selected_photos'),
            'selected_photos_at' => $request->has('selected_photos') ? now() : null,
            'file_raw_upload' => $request->has('file_raw_upload'),
            'file_raw_upload_at' => $request->has('file_raw_upload') ? now() : null,
            'editing_foto' => $request->has('editing_foto'),
            'editing_foto_at' => $request->has('editing_foto') ? now() : null,
            'foto_edited_upload' => $request->has('foto_edited_upload'),
            'foto_edited_upload_at' => $request->has('foto_edited_upload') ? now() : null,
            'file_jpg_link' => $request->google_drive_link,
            'foto_edited_upload_link' => $request->foto_edited_upload_link,
        ]);

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
            $newValue = $progress->$field;
            $oldValue = $oldProgress[$field] ?? false;

            if ($newValue != $oldValue) {
                $changesDetected = true;
                $progressData[$field] = $newValue;
            }
        }

        if ($request->filled('google_drive_link')) {
            $progressData['file_jpg_link'] = $request->google_drive_link;
            if (($oldProgress['file_jpg_link'] ?? null) !== $request->google_drive_link) {
                $changesDetected = true;
            }
        }

        if ($request->filled('selected_photos_link')) {
            $progressData['selected_photos_link'] = $request->selected_photos_link;
            if (($oldProgress['selected_photos_link'] ?? null) !== $request->selected_photos_link) {
                $changesDetected = true;
            }
        }

        if ($request->filled('foto_edited_upload_link')) {
            $progressData['foto_edited_upload_link'] = $request->foto_edited_upload_link;
            if (($oldProgress['foto_edited_upload_link'] ?? null) !== $request->foto_edited_upload_link) {
                $changesDetected = true;
            }
        }

        if ($request->has('jadwal_foto') && (bool) $request->input('jadwal_foto')) {
            $progressData['jadwal_foto'] = true;
            if (!(($oldProgress['jadwal_foto'] ?? false) === true)) {
                $changesDetected = true;
            }
        }

        if ($changesDetected) {
            try {
                $fonteeService = new FonteeWhatsAppService();
                $message = $fonteeService->formatProgressMessage($progressData, $booking);

                if (!empty($message)) {
                    $fonteeService->sendMessage($booking->telephone, $message);
                }
            } catch (\Exception $e) {
                logger()->error('Failed to send WhatsApp notification: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.booking.show', $id)
            ->with('success', 'Progress booking berhasil diupdate!');
    }

    /**
     * Store selected photos link for user
     */
    public function storeSelectedPhotos(Request $request, $id)
    {
        $request->validate([
            'selected_photos_link' => 'required|string|max:2000'
        ]);

        try {
            $booking = Booking::with(['layanan', 'progress'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

            $progress = $booking->progress ?? BookingProgress::create(['booking_id' => $booking->id]);

            $progress->update([
                'selected_photos_link' => $request->selected_photos_link,
                'selected_photos' => true,
                'selected_photos_at' => now()
            ]);

            try {
                $fonteeService = new FonteeWhatsAppService();
                $adminMessage = $fonteeService->formatSelectedPhotosFromUser($request->selected_photos_link, $booking);
                $adminPhone = config('services.fontee.admin_phone', '6287875633258');
                $fonteeService->sendMessage($adminPhone, $adminMessage);
                $userMessage = $fonteeService->formatSelectedPhotosConfirmation($request->selected_photos_link, $booking);
                $fonteeService->sendMessage($booking->telephone, $userMessage);
            } catch (\Exception $e) {
                logger()->error('Failed to send WhatsApp notification for selected photos: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Selected kode photos berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
