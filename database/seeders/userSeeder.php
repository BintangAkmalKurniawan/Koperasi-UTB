<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class userSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            // User untuk Admin
            [
                'id_user' => '1234567890123455', // ID unik untuk admin
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'nama' => 'Jin Kamal',
                'alamat' => 'Jl. Cagak No.3, Subang',
                'no_hp' => '0823456976546',
                'tanggal_gabung' => Carbon::now()->toDateString(),
                'foto' => 'foto_profil/el.JPG'
            ],
        ]);
    }
}