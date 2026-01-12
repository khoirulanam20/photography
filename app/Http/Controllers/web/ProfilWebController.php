<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profil;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfilWebController extends Controller
{
    public function index()
    {
        $data = User::where('id', auth()->user()->id)->first();
        $profil = Profil::first();
        return view('page_web.profil.profil', compact('data', 'profil'));
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $validator = Validator::make($request->all(), [
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|unique:users,username,' . $user->id,
            'no_wa' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Terjadi kesalahan! ' . $validator->errors()->first());
            return redirect()->back();
        }

        $data = $request->except(['password', 'foto_profile']);

        // Proses upload foto_profile ke folder public
        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $filename = 'profile_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/foto_profile'), $filename);

            // Hapus foto lama jika ada dan bukan default
            if ($user->foto_profile && file_exists(public_path('upload/foto_profile/' . $user->foto_profile))) {
                @unlink(public_path('upload/foto_profile/' . $user->foto_profile));
            }

            $data['foto_profile'] = $filename;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        Alert::success('Profil berhasil diubah!');
        return redirect()->back();
    }
}
