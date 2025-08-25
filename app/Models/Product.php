<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'id_product',
        'name', 
        'description',
        'price',
        'stock',
        'category',
        'image',
        'id_user',
    ];

    protected $dates = ['deleted_at'];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_product', 'id_product');
    }

    public function thumbnail()
    {
        return $this->belongsTo(ProductImage::class, 'thumbnail_id');
    }
}