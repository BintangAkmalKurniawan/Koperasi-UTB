<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfilAnggotaController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('layoutanggota.profilAnggota.profil-anggota',compact('user'));
    }
}
