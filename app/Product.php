<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'stok', 'category_id', 'price', 'image', 'description'];
    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    // public function stokmasuk()
    // {
    //     return $this->hasMany('App\StokMasuk', 'id_produk');
    // }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
