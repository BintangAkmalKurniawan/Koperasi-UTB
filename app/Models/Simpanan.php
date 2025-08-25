<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Simpanan extends Model
{
    use HasFactory;

    protected $table = 'simpanan'; 

    protected $fillable = [
        'id_user',
        'total_pokok',
        'total_wajib',
        'total_sukarela',
        'wajib_terbayar_sampai',
    ];

    /**
     * Definisikan relasi bahwa satu Simpanan dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}