<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShuDistribution;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAnggotaController extends Controller
{
    public function index(){
        $userId = Auth::id();
        $tabungan = Tabungan::where('id_user', $userId)->latest()->get();
        $product = Product::where('id_user', $userId)->count();
        $shu = ShuDistribution::where('id_user', $userId)
            ->with('shuPeriod') 
            ->latest()
            ->first();
        return view('layoutanggota.dashboardAnggota.dashboard-anggota', compact('tabungan','shu','product'));
    }
}


