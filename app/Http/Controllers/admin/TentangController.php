<?php

namespace App\Http\Controllers\admin;

use App\Models\Tentang;
use App\Models\Tim;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use RealRashid\SweetAlert\Facades\Alert;

class TentangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tentang = Tentang::all();
        $teams = Tim::latest()->get();
        $services = Layanan::latest()->get();
        return view('page_admin.tentang.index', compact('tentang', 'teams', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.tentang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan tentang');
            Log::info('Request data:', $request->all());

            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'judul' => 'required',
                'deskripsi' => 'required',
                'hitungan' => 'required|array|min:1',
                'hitungan.*' => 'required|numeric',
                'keterangan_hitungan' => 'required|array|min:1',
                'keterangan_hitungan.*' => 'required|string',
                'keterangan_memilih' => 'required',
                'gambar_nilai' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
                'keterangan_nilai' => 'required',
            ]);

            Log::info('Validasi berhasil, memproses file gambar');

            $tentang = new Tentang();
            $tentang->judul = $request->judul;
            $tentang->deskripsi = $request->deskripsi;
            $tentang->hitungan = $request->hitungan;
            $tentang->keterangan_hitungan = $request->keterangan_hitungan;
            $tentang->keterangan_memilih = $request->keterangan_memilih;
            $tentang->keterangan_nilai = $request->keterangan_nilai;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '_gambar.webp';

                // Pastikan direktori ada
                $path = public_path('upload/tentang');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori upload/tentang');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $tentang->gambar = $gambarName;
            }

            if ($request->hasFile('gambar_nilai')) {
                $gambarNilai = $request->file('gambar_nilai');
                $gambarNilaiName = time() . '_nilai.webp';

                // Pastikan direktori ada
                $path = public_path('upload/tentang');
                if (!file_exists($path)) {
                    Log::info('Membuat direktori upload/tentang');
                    mkdir($path, 0777, true);
                }

                Log::info('Memulai konversi gambar nilai ke WebP');
                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambarNilai);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarNilaiName);

                $tentang->gambar_nilai = $gambarNilaiName;
            }

            Log::info('Mencoba menyimpan data tentang ke database');
            if (!$tentang->save()) {
                Log::error('Gagal menyimpan data tentang ke database');
                throw new \Exception('Gagal menyimpan data tentang');
            }

            Log::info('Tentang berhasil disimpan');
            Alert::toast('Tentang berhasil ditambahkan', 'success')->position('top-end');
            return redirect()->route('tentang.index');

        } catch (\Exception $e) {
            Log::error('Error in TentangController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tentang $tentang)
    {
        return view('page_admin.tentang.show', compact('tentang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tentang $tentang)
    {
        return view('page_admin.tentang.edit', compact('tentang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tentang $tentang)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
            'judul' => 'required',
            'deskripsi' => 'required',
            'hitungan' => 'required|array|min:1',
            'hitungan.*' => 'required|numeric',
            'keterangan_hitungan' => 'required|array|min:1',
            'keterangan_hitungan.*' => 'required|string',
            'keterangan_memilih' => 'required',
            'gambar_nilai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:7000',
            'keterangan_nilai' => 'required',
        ]);

        try {
            $tentang->judul = $request->judul;
            $tentang->deskripsi = $request->deskripsi;
            $tentang->hitungan = $request->hitungan;
            $tentang->keterangan_hitungan = $request->keterangan_hitungan;
            $tentang->keterangan_memilih = $request->keterangan_memilih;
            $tentang->keterangan_nilai = $request->keterangan_nilai;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($tentang->gambar && file_exists(public_path('upload/tentang/' . $tentang->gambar))) {
                    unlink(public_path('upload/tentang/' . $tentang->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '_gambar.webp';

                // Pastikan direktori ada
                $path = public_path('upload/tentang');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambar);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarName);

                $tentang->gambar = $gambarName;
            }

            if ($request->hasFile('gambar_nilai')) {
                // Hapus gambar nilai lama jika ada
                if ($tentang->gambar_nilai && file_exists(public_path('upload/tentang/' . $tentang->gambar_nilai))) {
                    unlink(public_path('upload/tentang/' . $tentang->gambar_nilai));
                }

                $gambarNilai = $request->file('gambar_nilai');
                $gambarNilaiName = time() . '_nilai.webp';

                // Pastikan direktori ada
                $path = public_path('upload/tentang');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Konversi ke WebP
                $manager = new ImageManager(new Driver());
                $image = $manager->read($gambarNilai);
                $image->toWebp(80); // 80 adalah kualitas kompresi
                $image->save($path . '/' . $gambarNilaiName);

                $tentang->gambar_nilai = $gambarNilaiName;
            }

            $tentang->save();
            Alert::toast('Tentang berhasil diubah', 'success')->position('top-end');
            return redirect()->route('tentang.index');
        } catch (\Exception $e) {
            Log::error('Error in TentangController@update: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tentang $tentang)
    {
        try {
            // Hapus gambar jika ada
            if ($tentang->gambar && file_exists(public_path('upload/tentang/' . $tentang->gambar))) {
                unlink(public_path('upload/tentang/' . $tentang->gambar));
            }

            // Hapus gambar nilai jika ada
            if ($tentang->gambar_nilai && file_exists(public_path('upload/tentang/' . $tentang->gambar_nilai))) {
                unlink(public_path('upload/tentang/' . $tentang->gambar_nilai));
            }

            $tentang->delete();
            Alert::toast('Tentang berhasil dihapus', 'success')->position('top-end');
            return redirect()->route('tentang.index');
        } catch (\Exception $e) {
            Log::error('Error in TentangController@destroy: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back();
        }
    }
}
