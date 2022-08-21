<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    protected $table="ship";
    protected $fillable = ['ship_id','status'];
    
    public function order() #配送屬於訂單
    {
        return $this->belongsTo(Order::class,'order_id', 'order_id');

    }

    

    
}
