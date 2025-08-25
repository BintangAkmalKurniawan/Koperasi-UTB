<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaksi;
use App\Models\User;

class Dashboard extends Controller
{
    function index(){
        $anggota = User::where('role','anggota')->count();
        $transaksi = Transaksi::count();
        $produk = Product::count();
        return view('Dashboard.dashboard', compact('anggota', 'transaksi', 'produk'));
    }
}
