<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name'        => 'Laptop Gaming',
                'description' => 'Laptop dengan spesifikasi tinggi untuk gaming.',
                'price'       => 15000000.00,
                'stock'       => 5,
                'thumbnail_id'=> null, // kosong dulu
                'id_user'     => 'USR001', // pastikan ada di tabel users
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Mouse Wireless',
                'description' => 'Mouse tanpa kabel dengan desain ergonomis.',
                'price'       => 250000.00,
                'stock'       => 20,
                'thumbnail_id'=> null,
                'id_user'     => 'USR001', // user yang sama, bisa juga beda
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
