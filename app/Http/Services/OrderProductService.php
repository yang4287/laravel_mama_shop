<?php


namespace App\Http\Services;

use App\Models\OrderProduct;

use DateTime;
class OrderProductService
{
   
    public function index()#查詢該會員id訂單
    {
       
        
    }
   
    public function add($order_id,$product_id,$price,$amount)
    {
        
        $orderProduct = new OrderProduct([

            'order_id' => $order_id,
            'product_id' => $product_id,
            'price' => $price ,
            'amount' => $amount 
            
          
            ]);
        return $orderProduct ->save();
    }

    public function update($request,$is_add=False)#$is_add指是否為原有的再加上數量
    { 
        // $cart = Cart::where('account_id',session('account_id'))->where('product_id', $request->product_id)->first();
        // $old_nunber = $cart->number ;

        // if ($is_add == True){
        //     $this->cartService->check($request->product_id, $old_nunber + $request->number);
        //     $cart->number = $old_nunber + $request->number;
        // }else{
        //     $this->cartService->check($request->product_id, $request->number);
        //     $cart->number = $request->number;
        // }
       
       
    
        
        // return $cart->save();



    }

    public function delete($request)
    {
        // Cart::where('account_id',session('account_id'))->where('product_id', $request->product_id)->delete();
    }
    
}