<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama',
        'telephone',
        'area',
        'instagram',
        'layanan_id',
        'sub_layanan_id',
        'booking_date',
        'booking_time',
        'lokasi_photo',
        'fotografer',
        'biaya',
        'status',
        'catatan',
        'payments',
    ];

    // Status constants
    const STATUS_PENDING = 'Pending';
    const STATUS_DITOLAK = 'Ditolak';
    const STATUS_DITERIMA = 'Diterima';
    const STATUS_DIPROSES = 'Diproses';
    const STATUS_SELESAI = 'Selesai';
    const STATUS_DIBATALKAN = 'Dibatalkan';

    protected $casts = [
        'booking_date' => 'date',
        'catatan' => 'array',
        'payments' => 'array',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
    ];

    protected $appends = [];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function subLayanan()
    {
        return $this->belongsTo(SubLayanan::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function progress()
    {
        return $this->hasOne(BookingProgress::class);
    }

    /**
     * Get total paid amount from payments array
     */
    public function getTotalPaidAttribute()
    {
        if (!$this->payments || empty($this->payments)) {
            return 0;
        }

        $total = 0;
        foreach ($this->payments as $payment) {
            if (($payment['status'] ?? 'Pending') === 'Terkonfirmasi') {
                $nominal = isset($payment['nominal']) ? (float) preg_replace('/[^0-9.]/', '', (string) $payment['nominal']) : 0;
                $total += $nominal;
            }
        }

        return $total;
    }

    /**
     * Get remaining payment amount
     */
    public function getRemainingPaymentAttribute()
    {
        $biayaRaw = is_string($this->biaya) ? preg_replace('/[^0-9]/', '', $this->biaya) : $this->biaya;
        $biaya = $biayaRaw ? (float) $biayaRaw : 0;
        return max(0, $biaya - $this->total_paid);
    }

    /**
     * Check if booking has any payments
     */
    public function hasPayments()
    {
        return !empty($this->payments) && count($this->payments) > 0;
    }

    /**
     * Check if payment is fully paid
     */
    public function isFullyPaid()
    {
        $biaya = $this->biaya ? (float) str_replace(',', '', $this->biaya) : 0;
        return $biaya > 0 && $this->total_paid >= $biaya;
    }
}
