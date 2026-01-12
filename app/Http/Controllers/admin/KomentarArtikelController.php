<?php

namespace App\Http\Controllers\admin;

use App\Models\KomentarArtikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KomentarArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $komentarArtikels = KomentarArtikel::all();
        return view('page_admin.komentarArtikel.index', compact('komentarArtikels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.komentarArtikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'komentar' => 'required',
            'nama_komentar' => 'required',
            'email_komentar' => 'required',
            'no_hp_komentar' => 'nullable',
        ]);
        
        $komentarArtikel = KomentarArtikel::create($request->all());
        return redirect()->route('komentarArtikel.index')->with('success', 'Komentar Artikel berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KomentarArtikel $komentarArtikel)
    {
        return view('page_admin.komentarArtikel.show', compact('komentarArtikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomentarArtikel $komentarArtikel)
    {
        return view('page_admin.komentarArtikel.edit', compact('komentarArtikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KomentarArtikel $komentarArtikel)
    {
        $request->validate([
            'komentar' => 'required',
            'nama_komentar' => 'required',
            'email_komentar' => 'required',
            'no_hp_komentar' => 'nullable',
        ]);
        
        $komentarArtikel->update($request->all());
        return redirect()->route('komentarArtikel.index')->with('success', 'Komentar Artikel berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KomentarArtikel $komentarArtikel)
    {
        $komentarArtikel->delete();
        return redirect()->route('komentarArtikel.index')->with('success', 'Komentar Artikel berhasil dihapus');
    }
}
