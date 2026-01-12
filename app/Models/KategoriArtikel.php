<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriArtikel extends Model
{
    use HasFactory;
    protected $table = 'kategori_artikels';
    protected $fillable = [
        'kategori_artikel',
        'slug',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($kategoriArtikel) {
            $kategoriArtikel->slug = Str::slug($kategoriArtikel->kategori_artikel);
        });
    }

    public function artikel()
    {
        return $this->hasMany(Artikel::class);
    }
}
