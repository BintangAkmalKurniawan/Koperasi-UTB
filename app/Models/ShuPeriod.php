<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShuPeriod extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode', 'total_shu', 'persen_jasa_modal', 'persen_jasa_usaha',
        'total_simpanan_koperasi', 'total_penjualan_koperasi', 'status'
    ];

      public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function distributions()
    {
        return $this->hasMany(ShuDistribution::class, 'shu_period_id');
    }
}
