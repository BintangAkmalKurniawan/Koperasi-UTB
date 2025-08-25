<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksis';

    protected $fillable = [
        'no_transaksi',
        'id_product',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'id_user',
        'saldo'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}