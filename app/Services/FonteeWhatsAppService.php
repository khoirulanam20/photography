<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FonteeWhatsAppService
{
    protected $token;
    protected $baseUrl = 'https://api.fonnte.com';

    public function __construct()
    {
        $this->token = config('services.fontee.token');
    }

    /**
     * Send WhatsApp message using Fontee API
     *
     * @param string $phoneNumber Phone number with country code (e.g., 6281234567890)
     * @param string $message Message content
     * @return array
     */
    public function sendMessage($phoneNumber, $message)
    {
        try {
            $phoneNumber = $this->cleanPhoneNumber($phoneNumber);

            if (!str_starts_with($phoneNumber, '62')) {
                if (str_starts_with($phoneNumber, '0')) {
                    $phoneNumber = '62' . substr($phoneNumber, 1);
                } else {
                    $phoneNumber = '62' . $phoneNumber;
                }
            }

            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post("{$this->baseUrl}/send", [
                'target' => $phoneNumber,
                'message' => $message,
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status']) {
                Log::info('Fontee WhatsApp message sent successfully', [
                    'phone' => $phoneNumber,
                    'response' => $result
                ]);

                return [
                    'success' => true,
                    'message' => 'Pesan WhatsApp berhasil dikirim',
                    'data' => $result
                ];
            } else {
                Log::error('Fontee WhatsApp message failed', [
                    'phone' => $phoneNumber,
                    'response' => $result
                ]);

                return [
                    'success' => false,
                    'message' => 'Gagal mengirim pesan WhatsApp: ' . ($result['message'] ?? 'Unknown error'),
                    'data' => $result
                ];
            }
        } catch (\Exception $e) {
            Log::error('Fontee WhatsApp service error', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Clean phone number format
     *
     * @param string $phoneNumber
     * @return string
     */
    protected function cleanPhoneNumber($phoneNumber)
    {
        return preg_replace('/[^0-9]/', '', $phoneNumber);
    }

    /**
     * Format progress message for booking notification
     *
     * @param array $progressData
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function formatProgressMessage($progressData, $booking)
    {
        $messages = [];

        foreach ($progressData as $key => $value) {
            if ($value === true || ($value !== null && $value !== '')) {
                switch ($key) {
                    case 'jadwal_foto':
                        $messages[] = "✅ Jadwal Foto sudah terpesan";
                        break;
                    case 'file_jpg_upload':
                        $messages[] = "✅ File JPG sudah diupload";
                        if (!empty($progressData['file_jpg_link'])) {
                            $messages[] = "📎 Link: " . $progressData['file_jpg_link'];
                        }
                        break;
                    case 'selected_photos':
                        $messages[] = "✅ Selected Kode Photos sudah dipilih";
                        if (!empty($progressData['selected_photos_link'])) {
                            $messages[] = "📎 Link: " . $progressData['selected_photos_link'];
                        }
                        break;
                    // case 'file_raw_upload':
                    //     $messages[] = "✅ File RAW sudah diupload";
                    //     break;
                    case 'editing_foto':
                        $messages[] = "✅ Dalam Proses Editing";
                        break;
                    case 'foto_edited_upload':
                        $messages[] = "✅ Foto edited sudah diupload";
                        if (!empty($progressData['foto_edited_upload_link'])) {
                            $messages[] = "📎 Link: " . $progressData['foto_edited_upload_link'];
                        }
                        break;
                        // case 'file_jpg_link':
                        //     $messages[] = "📎 Link JPG diperbarui: " . $progressData['file_jpg_link'];
                        //     break;
                        // case 'foto_edited_upload_link':
                        //     $messages[] = "📎 Link Foto Edited diperbarui: " . $progressData['foto_edited_upload_link'];
                        //     break;
                        // case 'selected_photos_link':
                        //     $messages[] = "📎 Link Selected Photos diperbarui: " . $progressData['selected_photos_link'];
                        //     break;
                }
            }
        }

        if (empty($messages)) {
            return "";
        }

        $bookingDate = $booking->booking_date;
        if (is_string($bookingDate)) {
            $bookingDate = Carbon::parse($bookingDate);
        }

        $message = "🎉 *Update Alur Progress Booking*\n\n";
        $message .= "📋 Booking ID: #" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "👤 Nama: " . $booking->nama . "\n";
        $message .= "📦 Paket: " . ($booking->layanan->judul ?? '-') . "\n";
        $message .= "📅 Tanggal: " . $bookingDate->format('d F Y') . "\n";
        $message .= "📍 Lokasi: " . $booking->lokasi_photo . "\n";
        if (!empty($booking->booking_time)) {
            $message .= "🕐 Waktu: " . $booking->booking_time;
            $message .= "\n";
        }
        if (!empty($progressData) && !empty($booking->fotografer)) {
            $message .= "📸 Fotografer: " . $booking->fotografer . "\n";
        }
        if (!empty($booking->biaya)) {
            $biaya = number_format($booking->biaya, 0, ',', '.');
            $message .= "💰 Biaya: Rp " . $biaya . "\n";

            $totalPaid = isset($booking->total_paid) ? (float) $booking->total_paid : 0;
            if ($totalPaid > 0) {
                $message .= "✅ Terbayar: Rp " . number_format($totalPaid, 0, ',', '.') . "\n";

                $remaining = isset($booking->remaining_payment) ? (float) $booking->remaining_payment : 0;
                if ($remaining > 0) {
                    $message .= "⚠️ Kekurangan: Rp " . number_format($remaining, 0, ',', '.') . "\n\n";
                } else {
                    $message .= "🎉 Lunas\n\n";
                }
            }
        }
        $message .= "*Alur Progress Booking:*\n";
        $message .= implode("\n", $messages);
        $message .= "\n\n_*CV Wisesa Photography*_";

        return $message;
    }

    /**
     * Format status update message for booking notification
     *
     * @param string $status
     * @param string|null $catatan
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function formatStatusMessage($status, $catatan, $booking)
    {
        $bookingDate = $booking->booking_date;
        if (is_string($bookingDate)) {
            $bookingDate = Carbon::parse($bookingDate);
        }

        $message = "📢 *Update Status Booking*\n\n";
        $message .= "📋 Booking ID: #" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "👤 Nama: " . $booking->nama . "\n";
        $message .= "📦 Paket: " . ($booking->layanan->judul ?? '-') . "\n";
        $message .= "📅 Tanggal: " . $bookingDate->format('d F Y') . "\n";
        $message .= "📍 Lokasi: " . $booking->lokasi_photo . "\n";

        if (!empty($booking->booking_time)) {
            $message .= "🕐 Waktu: " . $booking->booking_time;
            $message .= "\n";
        }
        if (!empty($progressData) && !empty($booking->fotografer)) {
            $message .= "📸 Fotografer: " . $booking->fotografer . "\n";
        }
        if (!empty($booking->biaya)) {
            $biaya = number_format($booking->biaya, 0, ',', '.');
            $message .= "💰 Biaya: Rp " . $biaya . "\n";

            $totalPaid = isset($booking->total_paid) ? (float) $booking->total_paid : 0;
            if ($totalPaid > 0) {
                $message .= "✅ Terbayar: Rp " . number_format($totalPaid, 0, ',', '.') . "\n";

                $remaining = isset($booking->remaining_payment) ? (float) $booking->remaining_payment : 0;
                if ($remaining > 0) {
                    $message .= "⚠️ Kekurangan: Rp " . number_format($remaining, 0, ',', '.') . "\n";
                } else {
                    $message .= "🎉 Lunas\n";
                }
            }
        }

        $message .= "\n";

        $statusLabels = [
            'Pending' => '⏳ Pending - Menunggu konfirmasi',
            'Diterima' => '✅ Diterima - Booking dikonfirmasi',
            'Diproses' => '🔄 Diproses - Sedang dikerjakan',
            'Selesai' => '🎉 Selesai - Order telah selesai',
            'Ditolak' => '❌ Ditolak - Booking ditolak',
            'Dibatalkan' => '🚫 Dibatalkan - Booking dibatalkan',
            'Pembayaran Ditolak' => '❌ Pembayaran Anda Ditolak',
        ];

        $message .= "*Status:* " . ($statusLabels[$status] ?? $status) . "\n\n";

        if (!empty($catatan)) {
            $message .= "*Catatan:*\n" . $catatan . "\n\n";
        }
        if ($status === 'Diterima') {
            $message .= "_* Tolong Segera Lakukan Pembayaran Di Halaman Booking 😍 *_ \n\n";
        }
        $message .= "_*CV Wisesa Photography*_";

        return $message;
    }

    /**
     * Format selected photos message from user to admin
     *
     * @param string $selectedPhotosLink
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function formatSelectedPhotosFromUser($selectedPhotosLink, $booking)
    {
        $bookingDate = $booking->booking_date;
        if (is_string($bookingDate)) {
            $bookingDate = Carbon::parse($bookingDate);
        }

        $message = "📸 *Informasi Foto Yang Terpilih Dari Customer*\n\n";
        $message .= "📋 Booking ID: #" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "👤 Nama: " . $booking->nama . "\n";
        $message .= "📦 Paket: " . ($booking->layanan->judul ?? '-') . "\n";
        $message .= "📅 Tanggal: " . $bookingDate->format('d F Y') . "\n";
        $message .= "📍 Lokasi: " . $booking->lokasi_photo . "\n";

        if (!empty($booking->booking_time)) {
            $message .= "🕐 Waktu: " . $booking->booking_time;
            $message .= "\n";
        }
        if (!empty($progressData) && !empty($booking->fotografer)) {
            $message .= "📸 Fotografer: " . $booking->fotografer . "\n";
        }
        if (!empty($booking->biaya)) {
            $biaya = number_format($booking->biaya, 0, ',', '.');
            $message .= "💰 Biaya: Rp " . $biaya . "\n";

            $totalPaid = isset($booking->total_paid) ? (float) $booking->total_paid : 0;
            if ($totalPaid > 0) {
                $message .= "✅ Terbayar: Rp " . number_format($totalPaid, 0, ',', '.') . "\n";

                $remaining = isset($booking->remaining_payment) ? (float) $booking->remaining_payment : 0;
                if ($remaining > 0) {
                    $message .= "⚠️ Kekurangan: Rp " . number_format($remaining, 0, ',', '.') . "\n\n";
                } else {
                    $message .= "🎉 Lunas\n\n";
                }
            }
        }

        $message .= "*Selected Photos Link:*\n" . $selectedPhotosLink . "\n\n";
        $message .= "_*CV Wisesa Photography*_";

        return $message;
    }

    /**
     * Format confirmation message to user after submitting selected photos
     *
     * @param string $selectedPhotosLink
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function formatSelectedPhotosConfirmation($selectedPhotosLink, $booking)
    {
        $bookingDate = $booking->booking_date;
        if (is_string($bookingDate)) {
            $bookingDate = Carbon::parse($bookingDate);
        }

        $message = "✅ *Selected Photos Berhasil Diterima*\n\n";
        $message .= "📋 Booking ID: #" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "👤 Nama: " . $booking->nama . "\n";
        $message .= "📦 Paket: " . ($booking->layanan->judul ?? '-') . "\n";
        $message .= "📅 Tanggal: " . $bookingDate->format('d F Y') . "\n";
        $message .= "📍 Lokasi: " . $booking->lokasi_photo . "\n";

        if (!empty($booking->booking_time)) {
            $message .= "🕐 Waktu: " . $booking->booking_time;
            $message .= "\n";
        }
        if (!empty($progressData) && !empty($booking->fotografer)) {
            $message .= "📸 Fotografer: " . $booking->fotografer . "\n";
        }
        if (!empty($booking->biaya)) {
            $biaya = number_format($booking->biaya, 0, ',', '.');
            $message .= "💰 Biaya: Rp " . $biaya . "\n";

            $totalPaid = isset($booking->total_paid) ? (float) $booking->total_paid : 0;
            if ($totalPaid > 0) {
                $message .= "✅ Terbayar: Rp " . number_format($totalPaid, 0, ',', '.') . "\n";

                $remaining = isset($booking->remaining_payment) ? (float) $booking->remaining_payment : 0;
                if ($remaining > 0) {
                    $message .= "⚠️ Kekurangan: Rp " . number_format($remaining, 0, ',', '.') . "\n\n";
                } else {
                    $message .= "🎉 Lunas\n\n";
                }
            }
        }
        $message .= "Selected kode photos Anda sudah berhasil diterima. Tim kami akan memproses foto yang terpilih.\n\n";
        $message .= "*Kode foto yang dikirim:*\n" . $selectedPhotosLink . "\n\n";
        $message .= "_*CV Wisesa Photography*_";

        return $message;
    }
}
