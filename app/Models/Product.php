<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table="product";
    public $timestamps = false;

    public function product_image() #一個產品對到多個照片
    {
        return $this->hasMany(Product_image::class);

    }

    
}
