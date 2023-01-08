<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table="order";
    
    protected $fillable = ['consignee_name','consignee_phone','consignee_address','except_date','total_amount','order_status'];
    

    public function account() #訂單屬於帳戶
    {
        return $this->belongsTo(Account::class,'account_id', 'account_id');

    }
    public function orderProduct() #一個訂單對到多個產品
    {
        return $this->hasMany(OrderProduct::class,'order_id', 'order_id');

    }
    public function payment() #一個訂單對到一個付款
    {
        return $this->hasOne(Payment::class,'order_id', 'order_id');

    }
    public function paymentLog() #一個訂單對到多筆付款紀錄
    {
        return $this->hasOne(PaymentLog::class,'order_id', 'order_id');

    }
    public function ship() #一個訂單對到一個配送資訊
    {
        return $this->hasOne(Ship::class,'order_id', 'order_id');

    }



    
}
