<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatTabungan extends Model
{
    use HasFactory;
    protected $table = 'riwayat_tabungan';
    protected $fillable = ['id_tabungan', 'id_user', 'jenis_transaksi', 'jumlah', 'tanggal_transaksi'];


    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function tabungan(){
        return $this->belongsTo(Tabungan::class, 'id_tabungan', 'id_tabungan');
    }
}