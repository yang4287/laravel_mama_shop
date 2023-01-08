<?php


namespace App\Http\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use DateTime;
class OderService
{
   
    public function index()#查詢該會員id訂單
    {
        $cart = Cart::with('product:product_id,price,name')->where('account_id', session('account_id'))->with(['product'  => function ($query) {
            $query->with(['productImage' => function ($query) {
                $query->where('order', 1)->selectRaw('product_id, path');
            }]);
        }]);
        
        return $cart;
        
    }
    public function timeOption($method) #計算哪些預計到貨日期可接單，提供顧客選擇預計到貨日，$method有宅配跟自取
    {   
        #訂單狀態，0: 訂單處理中，1:訂單成立，2:等待付款，3: 撿貨中，4: 出貨中，5:訂單完成，6:訂單取消

        #查正在進行(即尚未出貨)的訂單，該到貨日期的訂單數量
        $order =  Order::whereBetween('status',[1,3])->groupBy('except_date')->selectRaw('except_date, count(except_date) as order_date_number');
        
        #無指定到貨日期的訂單(except_date=0)，但最晚到貨日為訂單成立時間的後20天

        #一天最多三張訂單，一個禮拜不超過10張單

        #宅配最快必須當前的10天後，1單超過50顆為20天，星期日無法到貨




        #自取，6顆左右最快三天，其餘七天

        
        $product_amount = $product->amount;

        $date = new DateTime(); #取得當前日期



        

    }
 
    public function add($request)
    {
        $this->cartService->check($request->product_id,$request->number);
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
            $this->cartService->check($request->product_id, $old_nunber + $request->number);
            $cart->number = $old_nunber + $request->number;
        }else{
            $this->cartService->check($request->product_id, $request->number);
            $cart->number = $request->number;
        }
       
       
    
        
        return $cart->save();



    }

    public function delete($request)
    {
        Cart::where('account_id',session('account_id'))->where('product_id', $request->product_id)->delete();
    }
    
}