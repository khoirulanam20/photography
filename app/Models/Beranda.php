<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    use HasFactory;
    protected $fillable = [
    'judul_utama', 
    'gambar_utama', 
    'slogan', 
    'gambar_sekunder', 
    'judul_sekunder', 
    'keterangan',
    ];
}
