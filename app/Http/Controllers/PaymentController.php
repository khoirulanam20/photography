<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PaymentController extends Controller
{
    /**
     * Show payment form
     */
    public function create($bookingId)
    {
        $booking = Booking::where('user_id', auth()->id())
            ->where('status', 'Diterima')
            ->findOrFail($bookingId);

        if ($booking->payment) {
            return redirect()->route('booking.show', $bookingId)
                ->with('info', 'Pembayaran sudah dilakukan sebelumnya.');
        }

        return view('booking.payment', compact('booking'));
    }

    /**
     * Store payment
     */
    public function store(Request $request, $bookingId)
    {
        $booking = Booking::where('user_id', auth()->id())
            ->where('status', 'Diterima')
            ->findOrFail($bookingId);

        if ($booking->payment) {
            return redirect()->route('booking.show', $bookingId)
                ->with('info', 'Pembayaran sudah dilakukan sebelumnya.');
        }

        $buktiPath = $this->uploadBuktiTransfer($request->file('bukti_transfer'));

        Payment::create([
            'booking_id' => $bookingId,
            'jenis_payment' => $request->jenis_payment,
            'nominal' => $request->nominal,
            'bukti_transfer' => $buktiPath,
            'status' => 'Pending',
        ]);

        return redirect()->route('booking.show', $bookingId)
            ->with('success', 'Pembayaran berhasil dikirim! Menunggu verifikasi admin.');
    }

    /**
     * Upload dan convert gambar ke webp
     */
    private function uploadBuktiTransfer($file)
    {
        $filename = 'payment_' . time() . '.webp';
        $path = 'payments/' . $filename;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file)->toWebp(90);

        Storage::disk('public')->put($path, (string) $image);

        return $path;
    }

    /**
     * Display payment detail (untuk admin)
     */
    public function show($id)
    {
        $payment = Payment::with(['booking.user'])->findOrFail($id);

        return view('admin.payment.show', compact('payment'));
    }

    /**
     * Get payment data in JSON format (untuk modal)
     */
    public function showJson($id)
    {
        try {
            $booking = Booking::with(['layanan'])->findOrFail($id);

            if (!$booking->payments || empty($booking->payments)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pembayaran tidak ditemukan'
                ], 404);
            }

            $payments = collect($booking->payments)->map(function ($payment) {
                $buktiTransferFilename = $payment['bukti_transfer'] ?? '';

                if (str_contains($buktiTransferFilename, 'payments/')) {
                    $buktiTransferFilename = str_replace('payments/', '', $buktiTransferFilename);
                }

                $buktiTransferUrl = route('admin.payment.image', ['filename' => $buktiTransferFilename]);

                return [
                    'jenis_payment' => $payment['jenis_payment'] ?? '',
                    'nominal' => $payment['nominal'] ?? '',
                    'bukti_transfer' => $buktiTransferFilename,
                    'bukti_transfer_url' => $buktiTransferUrl,
                    'status' => $payment['status'] ?? 'Pending',
                    'catatan_admin' => $payment['catatan_admin'] ?? null,
                    'created_at' => $payment['created_at'] ?? null,
                    'updated_at' => $payment['updated_at'] ?? null,
                ];
            });

            return response()->json([
                'success' => true,
                'payments' => $payments->toArray(),
                'biaya' => $booking->biaya
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data pembayaran tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Verifikasi payment dan ubah status booking menjadi "Diproses"
     */
    public function verifikasi($id)
    {
        try {
            $request = request();
            $paymentIndex = $request->input('payment_index', 0);

            $booking = Booking::with(['layanan'])->findOrFail($id);

            if (!$booking->payments || empty($booking->payments)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pembayaran tidak ditemukan'
                ], 404);
            }

            if (!in_array($booking->status, ['Diterima', 'Diproses', 'Selesai'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya booking dengan status "Diterima", "Diproses", "Selesai" yang dapat diverifikasi'
                ], 400);
            }

            $payments = $booking->payments;

            if (!isset($payments[$paymentIndex])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Index pembayaran tidak ditemukan'
                ], 404);
            }

            if (($payments[$paymentIndex]['status'] ?? 'Pending') === 'Terkonfirmasi') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran sudah diverifikasi sebelumnya'
                ], 400);
            }

            $payments[$paymentIndex]['status'] = 'Terkonfirmasi';
            if ($request->filled('catatan')) {
                $payments[$paymentIndex]['catatan_admin'] = $request->input('catatan');
            }
            $payments[$paymentIndex]['updated_at'] = now()->format('Y-m-d H:i:s');

            $updateData = ['payments' => $payments];
            if ($booking->status === 'Diterima') {
                $updateData['status'] = 'Diproses';
            }
            $booking->update($updateData);

            if (!$booking->progress) {
                \App\Models\BookingProgress::create([
                    'booking_id' => $booking->id
                ]);
            }

            try {
                $fonteeService = new \App\Services\FonteeWhatsAppService();
                $catatanText = 'Pembayaran Anda telah diverifikasi dan booking sedang diproses.';
                if ($request->filled('catatan')) {
                    $catatanText .= "\nCatatan Admin: " . $request->input('catatan');
                }
                $message = $fonteeService->formatStatusMessage('Diproses', $catatanText, $booking);
                $fonteeService->sendMessage($booking->telephone, $message);
            } catch (\Exception $e) {
                logger()->error('Failed to send WhatsApp notification: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => $booking->status === 'Diterima'
                    ? 'Pembayaran berhasil diverifikasi! Status booking berubah menjadi "Diproses".'
                    : 'Pembayaran berhasil diverifikasi.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tolak payment tertentu (dengan catatan)
     */
    public function tolak($id)
    {
        try {
            $request = request();
            $paymentIndex = (int) $request->input('payment_index');
            $catatan = (string) $request->input('catatan', '');

            $booking = Booking::findOrFail($id);

            if (!$booking->payments || empty($booking->payments)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pembayaran tidak ditemukan'
                ], 404);
            }

            $payments = $booking->payments;

            if (!isset($payments[$paymentIndex])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Index pembayaran tidak ditemukan'
                ], 404);
            }

            if (($payments[$paymentIndex]['status'] ?? 'Pending') === 'Terkonfirmasi') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran sudah terkonfirmasi, tidak dapat ditolak'
                ], 400);
            }

            $payments[$paymentIndex]['status'] = 'Ditolak';
            if (!empty($catatan)) {
                $payments[$paymentIndex]['catatan_admin'] = $catatan;
            }
            $payments[$paymentIndex]['updated_at'] = now()->format('Y-m-d H:i:s');

            $booking->update([
                'payments' => $payments
            ]);

            try {
                $fonteeService = new \App\Services\FonteeWhatsAppService();
                $catatanText = 'Pembayaran Anda ditolak.';
                if (!empty($catatan)) {
                    $catatanText .= "\nCatatan Admin: " . $catatan;
                }
                $message = $fonteeService->formatStatusMessage('Pembayaran Ditolak', $catatanText, $booking);
                $fonteeService->sendMessage($booking->telephone, $message);
            } catch (\Exception $e) {
                logger()->error('Failed to send WhatsApp notification: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil ditolak.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Serve payment image
     */
    public function serveImage($filename)
    {
        $filePath = null;
        $booking = null;

        $payment = Payment::where('bukti_transfer', $filename)
            ->orWhere('bukti_transfer', 'payments/' . $filename)
            ->first();

        if ($payment) {
            $filePath = $payment->bukti_transfer;
            $booking = $payment->booking;
        } else {
            $query = Booking::whereNotNull('payments');

            if (auth()->check() && auth()->user()->role !== 'superadmin') {
                $query->where('user_id', auth()->id());
            }

            $bookings = $query->get();
            foreach ($bookings as $bookingItem) {
                if ($bookingItem->payments) {
                    foreach ($bookingItem->payments as $paymentData) {
                        $buktiTransfer = $paymentData['bukti_transfer'] ?? '';
                        if ($buktiTransfer === $filename || $buktiTransfer === 'payments/' . $filename) {
                            $filePath = $buktiTransfer;
                            $booking = $bookingItem;
                            break 2;
                        }
                    }
                }
            }
        }

        if (auth()->check() && auth()->user()->role !== 'superadmin') {
            if (!$booking || $booking->user_id !== auth()->id()) {
                abort(403, 'Unauthorized access to payment image');
            }
        }

        if (!$filePath) {
            abort(404);
        }

        if (!str_contains($filePath, 'payments/')) {
            $filePath = 'payments/' . $filePath;
        }

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        $fileContent = Storage::disk('public')->get($filePath);

        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp'
        ];
        $mimeType = $mimeTypes[$fileExtension] ?? 'application/octet-stream';

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . basename($filePath) . '"');
    }

    /**
     * Delete payment
     */
    public function destroy($bookingId)
    {
        $payment = Payment::where('booking_id', $bookingId)->firstOrFail();

        if (Storage::disk('public')->exists($payment->bukti_transfer)) {
            Storage::disk('public')->delete($payment->bukti_transfer);
        }

        $payment->delete();

        return redirect()->back()
            ->with('success', 'Payment berhasil dihapus!');
    }
}
