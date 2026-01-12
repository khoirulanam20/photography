<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->json('payments')->nullable()->after('biaya');
        });

        $bookings = \App\Models\Booking::whereHas('payment')->with('payment')->get();

        foreach ($bookings as $booking) {
            if ($booking->payment) {
                $paymentData = [[
                    'jenis_payment' => $booking->payment->jenis_payment,
                    'nominal' => $booking->payment->nominal,
                    'bukti_transfer' => $booking->payment->bukti_transfer,
                    'status' => $booking->payment->status ?? 'Pending',
                    'created_at' => $booking->payment->created_at ? $booking->payment->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                    'updated_at' => $booking->payment->updated_at ? $booking->payment->updated_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                ]];

                $booking->update(['payments' => $paymentData]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('payments');
        });
    }
};
