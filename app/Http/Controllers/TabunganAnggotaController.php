<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTabungan;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabunganAnggotaController extends Controller
{
   public function index(){
    $user = Auth::id();
    $tabungan = Tabungan::where('id_user', $user)->with('riwayat')->latest()->get();
        return view('layoutanggota.tabunganAnggota.tabungan-anggota',compact('tabungan'));
    }
}