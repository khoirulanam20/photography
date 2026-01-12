<?php

namespace App\Http\Controllers\admin;

use App\Models\Kontak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class KontakController extends Controller
{
    
    public function index(Request $request)
    {
        $kontaks = Kontak::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $kontaks = Kontak::where('nama', 'like', '%' . $filter . '%')->paginate(10);
        }
        return view('page_admin.kontak.index', compact('kontaks', 'filter'));
    }

    
    public function create()
    {
        return view('page_admin.kontak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20',
            'pesan' => 'required|string'
        ]);

        Kontak::create($request->all());

        Alert::toast('Data kontak berhasil ditambahkan', 'success')->position('top-end');
        return redirect()->route('kontak.index')
            ->with('success', 'Data kontak berhasil ditambahkan');
    }

    
    public function show(Kontak $kontak)
    {
        return view('page_admin.kontak.show', compact('kontak'));
    }

   
    public function edit(Kontak $kontak)
    {
        return view('page_admin.kontak.edit', compact('kontak'));
    }


    public function update(Request $request, Kontak $kontak)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'pesan' => 'required',
        ]);

        $kontak->nama = $request->nama;
        $kontak->email = $request->email;
        $kontak->no_hp = $request->no_hp;
        $kontak->pesan = $request->pesan;
        $kontak->save();
        Alert::toast('Kontak berhasil diubah', 'success')->position('top-end');
        return redirect()->route('kontak.index')->with('success', 'Kontak berhasil diubah');
    }

    
    public function destroy(Kontak $kontak)
    {
        try {
            $kontak->delete();
        Alert::toast('Kontak berhasil dihapus', 'success')->position('top-end');
        return redirect()->route('kontak.index')->with('success', 'Kontak berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error in KontakController@destroy: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
