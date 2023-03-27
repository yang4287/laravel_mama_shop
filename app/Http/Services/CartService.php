<?php


namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Product;
use FFI\Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CartService
{
   

   


   
    public function index()#查詢該會員id購物車
    {
       
        $cart = Cart::whereRelation('product','status',1)->where('account_id', session('account_id'))->with(['product'  => function ($query) {
            $query->with(['productImage' => function ($query) {
                $query->where('order', 1)->selectRaw('product_id, path');
            }]);
               
            
        }]);
        
        return $cart;
        
    }
    public function check($product_id,$number) #檢查購物車商品數量是否少於剩餘數量
    {
        $product = Product::where('product_id',$product_id)->first();
        $product_amount = $product->amount;

        if ($number > $product_amount  ){
            throw ValidationException::withMessages([ 
               'number' => '庫存不足',
            ]);
        }

    }
    public function checkAll() #檢查購物車全部商品數量是否少於剩餘數量
    {
       
        $cart = Cart::where('account_id', session('account_id'));
        $cart =  $cart -> whereHas('product', function (Builder $query) {
            $query->where('amount', '<', 'cart.number');
        })->get();
        
        
        if (count($cart) != 0){
            throw new Exception('庫存不足');
        }

    }
 
    public function add($request)
    {
        $this->check($request->product_id,$request->number);
        $cart = new Cart([

            'product_id' => $request->product_id,
          
            'number' => $request->number,
            'account_id' => session('account_id'),
          
            ]);
        return $cart ->save();
    }

    public function update($request,$is_add=False)#$is_add指是否為原有的再加上數量
    { 
        $cart = Cart::where('account_id',session('account_id'))->where('product_id', $request->product_id)->first();
        $old_nunber = $cart->number ;

        if ($is_add == True){
            $this->check($request->product_id, $old_nunber + $request->number);
            $cart->number = $old_nunber + $request->number;
        }else{
            $this->check($request->product_id, $request->number);
            $cart->number = $request->number;
        }
       
       
    
        
        return $cart->save();



    }

    public function delete($request)
    {
        Cart::where('account_id',session('account_id'))->where('product_id', $request->product_id)->delete();
    }
    public function deleteAll()
    {
        Cart::where('account_id',session('account_id'))->delete();
    }
    
}