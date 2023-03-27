<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductClass extends Model
{
    use HasFactory;

    protected $table="product_class";
    
    protected $fillable = ['product_id','class'];
    protected $hidden = ['created_at','updated_at'];

    public function product() #一個分類，多個產品
    {
        return $this->hasMany(Product::class,'product_id', 'product_id');

    }

    
}
