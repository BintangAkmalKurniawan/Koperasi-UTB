<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShuDistribution extends Model
{
    use HasFactory;
    protected $fillable = [
        'shu_period_id', 'id_user', 'total_simpanan_anggota',
        'total_belanja_anggota', 'shu_jasa_modal', 'shu_jasa_usaha'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function shuPeriod(): BelongsTo
    {
        return $this->belongsTo(ShuPeriod::class, 'shu_period_id');
    }
}
