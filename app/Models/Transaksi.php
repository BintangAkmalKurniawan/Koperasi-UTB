<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'no_transaksi';

    protected $fillable = [
        'id_user',
        'tanggal_transaksi',
        'total_harga',
    ];

    /**
     * Relasi: Transaksi ini dimiliki oleh seorang User.
     * Nama relasi dibuat singular: user()
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: Transaksi ini memiliki banyak DetailTransaksi.
     */
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'no_transaksi', 'no_transaksi');
    }
}
