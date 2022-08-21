<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table="product";
    
    protected $fillable = ['product_id','name','content','amount','price','status'];
    protected $with = ['productClass'];

    public function productImage() #一個產品對到多個照片
    {
        return $this->hasMany(ProductImage::class,'product_id', 'product_id');

    }
    public function productClass() #產品屬於分類
    {
        return $this->belongsTo(ProductClass::class,'product_id', 'product_id');

    }

    
}
