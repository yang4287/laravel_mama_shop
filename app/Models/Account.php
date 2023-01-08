<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table="account";
    protected $fillable = [
        'account_id',
        'name',
        'phone',
        'password',
        'status',
        'level',
    ];
    
    public function cart() #一個帳戶對到一個購物車
    {
        return $this->hasOne(Cart::class,'account_id', 'account_id');

    }
    public function order() #一個帳戶對到多個訂單
    {
        return $this->hasMany(Order::class,'account_id', 'account_id');

    }

    

    
}
