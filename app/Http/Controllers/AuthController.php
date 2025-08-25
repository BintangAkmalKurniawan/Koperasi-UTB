<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index(){
        return view('auth.login');
    }

    function login(Request $request){
       $credentials =  $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::User();

            if ($user->role === 'admin'){
                return redirect()->intended('dashboard');
            }elseif ($user->role === 'anggota'){
                return redirect()->intended('dashboard-anggota');
            }
            return redirect()->intended('/');
            
        }

        return redirect()->back()->with('error', 'Username atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function Profil(){
        $user = Auth::user();
        return view('Profil.index',compact('user'));
    }
}
