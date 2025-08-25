<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $searchanggota = $request->input('search');

        $anggota = User::where('role', 'anggota')
                ->when($searchanggota, function ($query, $search){
                    return $query->where('nama', 'like', '%'.$search. '%');
                })->get();
        return view('User.list-anggota', compact('anggota'));
    }

    public function create()
    {
        return view('User.tambah-anggota');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_user'   => 'required|digits:16|unique:users,id_user',
            'username'  => 'required|string|max:50|unique:users,username',
            'password'  => 'required|string|min:8|confirmed',
            'nama'      => 'required|string|max:100',
            'alamat'    => 'required|string',
            'no_hp'     => 'required|numeric',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null;
        if($request->hasFile('foto')){
            $path = $request->file('foto')->store('foto_profil', 'public');
        }

        try {
            User::create([
                'id_user'        => $validatedData['id_user'],
                'username'       => $validatedData['username'],
                'password'       => $validatedData['password'],
                'role'           => 'anggota',
                'nama'           => $validatedData['nama'],
                'alamat'         => $validatedData['alamat'],
                'no_hp'          => $validatedData['no_hp'],
                'tanggal_gabung' => now(),
                'foto'           => $path
            ]);

            return redirect()->route('daftar-anggota')->with('success', 'Anggota baru berhasil ditambahkan!');

        } catch (Throwable $e) {
            Log::error('Gagal membuat anggota baru: ' . $e->getMessage());
            return redirect()->back()
                         ->withInput()
                         ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function show(string $id)
    {
        $item = User::with('riwayatSimpanan')->findOrFail($id);
        return view('User.detail-anggota', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $anggota = User::findOrFail($id);

        $validatedData = $request->validate([
            'username'  => ['required', 'string', 'max:50', Rule::unique('users')->ignore($anggota->id_user, 'id_user')],
            'nama'      => 'required|string|max:100',
            'alamat'    => 'required|string',
            'no_hp'     => 'required|numeric',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('foto_profil', 'public');
        }

        try {
            $anggota->update($validatedData);
            return back()->with('success', 'Profil anggota berhasil diperbarui!');
        } catch (Throwable $e) {
            Log::error('Gagal update anggota: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $anggota = User::findOrFail($id);
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            $anggota->delete();
            return redirect()->route('daftar-anggota')->with('success', 'Anggota berhasil dihapus.');

        } catch (Throwable $e) {
            Log::error('Gagal menghapus anggota: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
    
    public function search($id_user)
    {
        $anggota = User::where('id_user', $id_user)->first();
        if ($anggota) {
            return response()->json($anggota);
        }
        return response()->json(['message' => 'Data tidak ditemukan'], 404);

    }
}