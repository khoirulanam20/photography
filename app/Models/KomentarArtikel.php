<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarArtikel extends Model
{
    use HasFactory;
    protected $table = 'komentar_artikels';
    protected $fillable = [
        'artikel_id',
        'komentar',
        'nama_komentar',
        'email_komentar',
        'no_hp_komentar',
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }
}
