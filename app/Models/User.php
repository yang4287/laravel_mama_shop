<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
   
    use HasApiTokens, HasFactory, Notifiable;
    protected $table="users";
    protected $fillable = [
        'account_id',
        'name',
        'phone',
        'password',
        'status',
        'level',
    ];
    protected $hidden = [
        'account_id',
        'password',
        'remember_token',
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
