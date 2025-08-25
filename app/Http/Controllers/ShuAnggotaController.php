<?php

namespace App\Http\Controllers;

use App\Models\ShuDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShuAnggotaController extends Controller
{
        public function index(){
            $user = Auth::id();
            $shu = ShuDistribution::where('id_user', $user)
            ->with('shuPeriod')
            ->latest()
            ->get();

        return view('layoutanggota.shuAnggota.shu-anggota', compact('shu'));
    }

}