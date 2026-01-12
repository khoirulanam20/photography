<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriGambar extends Model
{
    use HasFactory;

    protected $table = 'kategori_gambar';

    protected $fillable = [
        'kategori_gambar',
        'slug',
        'deskripsi'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategoriGambar) {
            $kategoriGambar->slug = Str::slug($kategoriGambar->kategori_gambar);
        });
    }

    public function gambar()
    {
        return $this->hasMany(Galeri::class);
    }
}
