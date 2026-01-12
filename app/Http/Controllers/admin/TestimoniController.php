<?php

namespace App\Http\Controllers\admin;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $testimonis = Testimoni::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $testimonis = Testimoni::where('nama', 'like', '%' . $filter . '%')->paginate(10);
        }
        return view('page_admin.testimoni.index', compact('testimonis', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.testimoni.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan testimoni');
            Log::info('Request data:', $request->all());

            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nama' => 'required',
                'jabatan' => 'required',
                'testimoni' => 'required',
                'rating' => 'required|numeric|min:1|max:5',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $testimoni = new Testimoni();
            $testimoni->nama = $request->nama;
            $testimoni->jabatan = $request->jabatan;
            $testimoni->testimoni = $request->testimoni;
            $testimoni->rating = $request->rating;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/testimoni');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori upload/testimoni');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $testimoni->gambar = $gambarName;
            }

            Log::info('Mencoba menyimpan data testimoni ke database');
            if (!$testimoni->save()) {
                Log::error('Gagal menyimpan data testimoni ke database');
                throw new \Exception('Gagal menyimpan data testimoni');
            }

            Log::info('Testimoni berhasil disimpan');
            return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error in TestimoniController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimoni $testimoni)
    {
        return view('page_admin.testimoni.show', compact('testimoni'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimoni $testimoni)
    {
        return view('page_admin.testimoni.edit', compact('testimoni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimoni $testimoni)
    {
        try {
            $request->validate([
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nama' => 'required',
                'jabatan' => 'required',
                'testimoni' => 'required',
                'rating' => 'required|numeric|min:1|max:5',
            ]);

            $testimoni->nama = $request->nama;
            $testimoni->jabatan = $request->jabatan;
            $testimoni->testimoni = $request->testimoni;
            $testimoni->rating = $request->rating;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($testimoni->gambar && file_exists(public_path('upload/testimoni/' . $testimoni->gambar))) {
                    unlink(public_path('upload/testimoni/' . $testimoni->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '.webp';

                // Pastikan direktori ada
                $path = public_path('upload/testimoni');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $testimoni->gambar = $gambarName;
            }

            $testimoni->save();
            return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error in TestimoniController@update: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimoni $testimoni)
    {
        try {
            // Hapus gambar jika ada
            if ($testimoni->gambar && file_exists(public_path('upload/testimoni/' . $testimoni->gambar))) {
                unlink(public_path('upload/testimoni/' . $testimoni->gambar));
            }

            $testimoni->delete();
            return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in TestimoniController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
