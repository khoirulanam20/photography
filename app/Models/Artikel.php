<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'gambar',
        'penulis',
        'kategori_artikel_id',
        'isi',
        'catatan',
        'slug',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->judul);
        });
    }

    public function kategoriArtikel()
    {
        return $this->belongsTo(KategoriArtikel::class, 'kategori_artikel_id');
    }

    public function komentarArtikel()
    {
        return $this->hasMany(KomentarArtikel::class, 'artikel_id');
    }
}
