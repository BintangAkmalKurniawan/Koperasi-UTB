<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckAnggota
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role == 'anggota'){
            return $next($request);
        }
        abort(403, 'AKSES DITOLAK, ANDA BUKAN ANGGOTA.');   
    }
}
