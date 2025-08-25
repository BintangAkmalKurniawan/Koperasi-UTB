<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Simpanan;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $primaryKey = 'id_user';
    public $incrementing = false;

    protected $fillable = [
        'id_user', 'username', 'password', 'role', 'nama', 'alamat', 'no_hp', 'tanggal_gabung', 'foto'
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    protected static function booted(): void
    {
        static::created(function ($user) {
            if ($user->role === 'anggota') {
                Simpanan::create(['id_user' => $user->id_user]);
                Tabungan::create(['id_user' => $user->id_user]);
            }
        });
    }
    public function simpanan(): HasOne
    {
        return $this->hasOne(Simpanan::class, 'id_user', 'id_user');
    }

    public function riwayatSimpanan(): HasMany
    {
        return $this->hasMany(RiwayatSimpanan::class, 'id_user', 'id_user');
    }

    public function riwayatTabungan(): HasMany
    {
        return $this->hasMany(RiwayatTabungan::class, 'id_user', 'id_user');
    }
    
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_user', 'id_user');
    }
    public function detailTransaksi()
    {
        return $this->hasMany(detailTransaksi::class, 'id_user', 'id_user');
    }

    public function shu(){
        return $this->hasMany(ShuPeriod::class, 'id_user', 'id_user');
    }
    public function tabungan()
    {
        return $this->hasOne(Tabungan::class, 'id_user', 'id_user');
    }
}