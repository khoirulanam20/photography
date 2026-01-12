<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'gambar',
        'master_kategori_produk_id',
        'deskripsi',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produk) {
            $produk->slug = Str::slug($produk->judul);
        });
    }

    public function master()
    {
        return $this->belongsTo(Master::class, 'master_kategori_produk');
    }

    public function kategoriProduk()
    {
        return $this->belongsTo(KategoriProduk::class, 'master_kategori_produk_id');
    }
}
