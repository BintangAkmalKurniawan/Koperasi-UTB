<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Simpanan;
use Carbon\Carbon;

class simpananSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user yang merupakan anggota
        $anggota = User::where('role', 'anggota')->get();

        foreach ($anggota as $user) {
            Simpanan::create([
                'id_user' => $user->id_user,
                'total_pokok' => 100000, 
                'total_wajib' => 60000,  
                'total_sukarela' => 50000,
                'wajib_terbayar_sampai' => Carbon::now()->subMonth()->endOfMonth()->toDateString(),
            ]);
        }
    }
}