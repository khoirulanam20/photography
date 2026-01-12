<?php

namespace App\Http\Controllers\admin;

use App\Models\Artikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriArtikel;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $artikels = Artikel::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $artikels = Artikel::where('judul', 'like', '%' . $filter . '%')->paginate(10);
        }
        return view('page_admin.artikel.index', compact('artikels', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriArtikels = KategoriArtikel::all();
        return view('page_admin.artikel.create', compact('kategoriArtikels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan artikel');
            Log::info('Request data:', $request->all());

            $request->validate([
                'judul' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'penulis' => 'required',
                'kategori_artikel_id' => 'required|exists:kategori_artikels,id',
                'isi' => 'required',
                'catatan' => 'nullable',
                'status' => 'required',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $artikel = new Artikel();
            $artikel->judul = $request->judul;
            $artikel->penulis = $request->penulis;
            $artikel->kategori_artikel_id = $request->kategori_artikel_id;
            $artikel->isi = $request->isi;
            $artikel->catatan = $request->catatan;
            $artikel->status = $request->status;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/artikel');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori upload/artikel');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $artikel->gambar = $gambarName;
            }

            Log::info('Mencoba menyimpan data artikel ke database');
            if (!$artikel->save()) {
                Log::error('Gagal menyimpan data artikel ke database');
                throw new \Exception('Gagal menyimpan data artikel');
            }

            Log::info('Artikel berhasil disimpan');
            Alert::toast('Artikel berhasil ditambahkan', 'success')->position('top-end');
            return redirect()->route('artikel.index');

        } catch (\Exception $e) {
            Log::error('Error in ArtikelController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        return view('page_admin.artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        $kategoriArtikels = KategoriArtikel::all();
        return view('page_admin.artikel.edit', compact('artikel', 'kategoriArtikels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
            'penulis' => 'required',
            'kategori_artikel_id' => 'required',
            'isi' => 'required',
            'catatan' => 'nullable',
            'status' => 'required',
        ]);

        try {
            $artikel->judul = $request->judul;
            $artikel->penulis = $request->penulis;
            $artikel->kategori_artikel_id = $request->kategori_artikel_id;
            $artikel->isi = $request->isi;
            $artikel->catatan = $request->catatan;
            $artikel->status = $request->status;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($artikel->gambar && file_exists(public_path('upload/artikel/' . $artikel->gambar))) {
                    unlink(public_path('upload/artikel/' . $artikel->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/artikel');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $artikel->gambar = $gambarName;
            }

            $artikel->save();
            Alert::toast('Artikel berhasil diubah', 'success')->position('top-end');
            return redirect()->route('artikel.index');
        } catch (\Exception $e) {
            Log::error('Error in ArtikelController@update: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        // Hapus file gambar jika ada
        if ($artikel->gambar && file_exists(public_path('upload/artikel/' . $artikel->gambar))) {
            unlink(public_path('upload/artikel/' . $artikel->gambar));
        }
        
        $artikel->delete();
        Alert::toast('Artikel berhasil dihapus', 'success')->position('top-end');
        return redirect()->route('artikel.index');
    }
}
