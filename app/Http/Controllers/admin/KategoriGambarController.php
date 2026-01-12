<?php

namespace App\Http\Controllers\admin;

use App\Models\KategoriGambar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
class KategoriGambarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriGambars = KategoriGambar::paginate(10);
        return view('page_admin.kategoriGambar.index', compact('kategoriGambars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.kategoriGambar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_gambar' => 'required|unique:kategori_gambar',
            'deskripsi' => 'nullable',
        ]);

        KategoriGambar::create($request->all());
        Alert::toast('Kategori gambar berhasil ditambahkan', 'success')->position('top-end');
        return redirect()->route('kategoriGambar.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriGambar $kategoriGambar)
    {
        return view('page_admin.kategoriGambar.show', compact('kategoriGambar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriGambar $kategoriGambar)
    {
        return view('page_admin.kategoriGambar.edit', compact('kategoriGambar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriGambar $kategoriGambar)
    {
        $request->validate([
            'kategori_gambar' => 'required|unique:kategori_gambar,kategori_gambar,' . $kategoriGambar->id,
            'deskripsi' => 'nullable',
        ]);

        $kategoriGambar->update($request->all());
        Alert::toast('Kategori gambar berhasil diubah', 'success')->position('top-end');
        return redirect()->route('kategoriGambar.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriGambar $kategoriGambar)
    {
        $kategoriGambar->delete();
        Alert::toast('Kategori gambar berhasil dihapus', 'success')->position('top-end');
        return redirect()->route('kategoriGambar.index');
    }
}
