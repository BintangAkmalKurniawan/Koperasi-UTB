<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSimpanan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_simpanans';

    protected $fillable = [
        'no_transaksi',
        'id_user',
        'jenis_simpanan',
        'jumlah',
        'tanggal_transaksi',
        'keterangan',
    ];
}