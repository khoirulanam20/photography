<?php

namespace App\Http\Controllers\admin;

use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
class KategoriArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriArtikels = KategoriArtikel::latest()->get();
        return view('page_admin.kategoriArtikel.index', compact('kategoriArtikels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.kategoriArtikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_artikel' => 'required|string|max:255',
        ]);

        KategoriArtikel::create($request->all());

        Alert::toast('Kategori Artikel berhasil ditambahkan', 'success')->position('top-end');
        return redirect()->route('kategoriArtikel.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriArtikel $kategoriArtikel)
    {
        return view('page_admin.kategoriArtikel.show', compact('kategoriArtikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriArtikel $kategoriArtikel)
    {
        return view('page_admin.kategoriArtikel.edit', compact('kategoriArtikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriArtikel $kategoriArtikel)
    {
        $request->validate([
            'kategori_artikel' => 'required|string|max:255',
        ]);

        $kategoriArtikel->update($request->all());

        Alert::toast('Kategori Artikel berhasil diubah', 'success')->position('top-end');
        return redirect()->route('kategoriArtikel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriArtikel $kategoriArtikel)
    {
        $kategoriArtikel->delete();

        Alert::toast('Kategori Artikel berhasil dihapus', 'success')->position('top-end');
        return redirect()->route('kategoriArtikel.index');
    }
}
