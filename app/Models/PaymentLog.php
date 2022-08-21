<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $table="payment_log";
    
    
    public function order() #付款紀錄屬於訂單
    {
        return $this->belongsTo(Order::class,'order_id', 'order_id');

    }
    public function payment() #付款紀錄屬於付款
    {
        return $this->hasMany(Payment::class,'payment_id', 'payment_id');

    }

    

    
}
