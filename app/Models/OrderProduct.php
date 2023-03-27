<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table="order_product";
    
    protected $fillable = ['order_id','product_id','price','amount'];
    protected $hidden = ['created_at','updated_at'];
    protected $with = ['order'];

    public function order() #訂單產品屬於訂單
    {
        return $this->belongsTo(Order::class,'order_id', 'order_id');

    }
    public function product() #訂單產品屬於產品
    {
        return $this->belongsTo(OrderProduct::class,'product_id', 'product_id');

    }




    
}
