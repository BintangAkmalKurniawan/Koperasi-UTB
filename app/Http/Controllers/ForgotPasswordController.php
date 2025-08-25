<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class ForgotPasswordController extends Controller
{
   
    public function updatePassword(Request $request)
    {
       
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'no_hp' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

   
        $user = User::where('id_user', $request->id_user)->first();

        if (!$user) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan.'
            ], 404);
        }


        if ($request->no_hp !== $user->no_hp) {
            return response()->json([
                'success' => false, 
                'message' => 'Verifikasi nomor handphone gagal. Pastikan nomor yang dimasukkan benar.'
            ]);
        }

    
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false, 
                'message' => 'Password lama yang Anda masukkan salah.'
            ]);
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'Password berhasil diubah!'
        ]);
    }
}
