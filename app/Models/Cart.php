<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table="cart";
    
    protected $fillable = ['product_id','number','account_id'];
    protected $hidden = ['created_at','updated_at'];

    public function account() #一個購物車對到一個帳戶
    {
        return $this->belongsTo(User::class,'account_id', 'account_id');

    }
    public function product() #購物車產品屬於產品
    {
        return $this->belongsTo(Product::class,'product_id', 'product_id');

    }



    
}
