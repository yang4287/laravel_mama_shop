<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    use HasFactory;

    protected $table="product_image";
    protected $fillable = ['product_id','path','order'];
    public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
