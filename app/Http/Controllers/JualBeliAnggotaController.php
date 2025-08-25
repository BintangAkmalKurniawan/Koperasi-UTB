<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class JualBeliAnggotaController extends Controller
{
        public function index()
        {
            $userId = Auth::user()->id_user;

            $transaksis = Transaksi::with(['detailTransaksis.produk', 'user'])
                ->where('id_user', $userId)
                ->orWhereHas('detailTransaksis.produk', function ($query) use ($userId) {
                    $query->where('id_user', $userId); 
                })
                ->orderBy('tanggal_transaksi', 'desc')
                ->get();

            return view('layoutanggota.jualbeliAnggota.jualbeli-anggota', compact('transaksis'));
        }

}