<?php

namespace App\Http\Controllers\admin;

use App\Models\Tim;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
class TimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tim = Tim::paginate(10);
        $filter = $request->filter;
        if ($filter) {
            $tim = Tim::where('nama', 'like', '%' . $filter . '%')->paginate(10);
        }
        return view('page_admin.tim.index', compact('tim', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_admin.tim.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:20',
            ]);

            $tim = new Tim();
            $tim->nama = $request->nama;
            $tim->alamat = $request->alamat;
            $tim->no_hp = $request->no_hp;

            $tim->save();

            Alert::toast('Tim berhasil ditambahkan', 'success')->position('top-end');
            return redirect()->route('tim.index');

        } catch (\Exception $e) {
            Log::error('Error in TimController@store: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tim $tim)
    {
        return view('page_admin.tim.show', compact('tim'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tim $tim)
    {
        return view('page_admin.tim.edit', compact('tim'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tim $tim)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:20',
            ]);

            $tim->nama = $request->nama;
            $tim->alamat = $request->alamat;
            $tim->no_hp = $request->no_hp;

            $tim->save();
            Alert::toast('Tim berhasil diubah', 'success')->position('top-end');
            return redirect()->route('tim.index');
        } catch (\Exception $e) {
            Log::error('Error in TimController@update: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tim $tim)
    {
        try {
            $tim->delete();
            Alert::toast('Tim berhasil dihapus', 'success')->position('top-end');
            return redirect()->route('tim.index');
        } catch (\Exception $e) {
            Log::error('Error in TimController@destroy: ' . $e->getMessage());
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error')->position('top-end');
            return redirect()->back();
        }
    }
}
