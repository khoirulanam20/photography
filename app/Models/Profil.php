<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'no_telp_perusahaan',
        'logo_perusahaan',
        'alamat_perusahaan',
        'latitude',
        'longitude',
        'email_perusahaan',
        'instagram_perusahaan',
        'facebook_perusahaan',
        'tiktok_perusahaan',
        'whatsapp_perusahaan',
        'gambar',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profil) {
            $profil->slug = Str::slug($profil->nama_perusahaan);
        });
    }

    public function getInstagramPerusahaanAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            return [$value];
        }

        return [];
    }

    public function setInstagramPerusahaanAttribute($value)
    {
        $accounts = is_array($value) ? $value : (is_null($value) ? [] : [$value]);

        $normalized = collect($accounts)
            ->map(function ($item) {
                return is_string($item) ? trim($item) : '';
            })
            ->filter()
            ->values()
            ->all();

        $this->attributes['instagram_perusahaan'] = empty($normalized) ? null : json_encode($normalized);
    }
}
