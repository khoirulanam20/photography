<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Beranda;
use App\Models\Tentang;
use App\Models\Layanan;
use App\Models\Profil;
use App\Models\Tim;

class AboutController extends Controller
{
    public function index()
    {
        $beranda = Beranda::first();
        $tentang = Tentang::first();
        $profil = Profil::first();
        $teams = Tim::latest()->get();

        // Ambil layanan ID 1-4 dengan semua galerinya
        $layanans = Layanan::with('galeris')
            ->whereIn('id', [1, 2, 3, 4])
            ->orderBy('id', 'asc')
            ->get();

        return view('page_web.tentang.index', compact('beranda', 'tentang', 'layanans', 'profil', 'teams'));
    }
}
