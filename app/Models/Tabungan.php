<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tabungan extends Model
{
    use HasFactory;
    protected $table = 'tabungan';
    protected $primaryKey = 'id_tabungan';

    protected $fillable = [
        'id_user',
        'total_tabungan'
    ];

        public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
        public function riwayat(): HasMany
    {
        return $this->hasMany(RiwayatTabungan::class, 'id_tabungan', 'id_tabungan');
    }
}
