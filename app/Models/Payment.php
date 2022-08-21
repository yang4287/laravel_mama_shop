<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table="payment";
    protected $fillable = ['payment_id','amount','method','status','paid_at'];
    
    public function order() #付款屬於訂單
    {
        return $this->belongsTo(Order::class,'order_id', 'order_id');

    }
    public function paymentLog() #一個付款對到多個付款紀錄
    {
        return $this->hasMany(PaymentLog::class,'order_id', 'order_id');

    }

    

    
}
