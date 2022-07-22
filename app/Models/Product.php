<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table="product";
    public $timestamps = false;
    protected $fillable = ['id','class','name','content','number','price','status'];

    public function productImage() #一個產品對到多個照片
    {
        return $this->hasMany(ProductImage::class);

    }

    
}
