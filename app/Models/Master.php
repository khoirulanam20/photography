<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;

    protected $fillable = [
        'master_kategori_artikel',
        'master_kategori_galeri',
        'master_kategori_produk',
    ];

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'master_kategori_artikel_id');
    }

    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'master_kategori_galeri_id');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'master_kategori_produk_id');
    }

}
