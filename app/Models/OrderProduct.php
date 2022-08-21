<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table="order_product";
    
    protected $fillable = ['product_id','number'];

   
    public function order() #訂單產品屬於訂單
    {
        return $this->belongsTo(Order::class,'order_id', 'order_id');

    }




    
}
