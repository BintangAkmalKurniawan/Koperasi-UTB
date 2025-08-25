<?php

namespace App\Http\Controllers;

use App\Models\RiwayatSimpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpananAnggotaController extends Controller
{
    public function index()
    {
        // 1. Dapatkan ID pengguna yang sedang login
        $userId = Auth::id();

        // 2. Ambil semua riwayat simpanan untuk pengguna tersebut
        $riwayatSimpanan = RiwayatSimpanan::where('id_user', $userId)
                            ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
                            ->get()
                            ->groupBy(function($date) {
                                // 3. Kelompokkan riwayat berdasarkan bulan dan tahun
                                return \Carbon\Carbon::parse($date->tanggal)->format('F Y'); 
                            });

        // 4. Kirim data yang sudah dikelompokkan ke view
        return view('layoutanggota.simpananAnggota.simpanan-anggota', [
            'simpananPerBulan' => $riwayatSimpanan
        ]);
    }
}