<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Http\Services\CartService;
use App\Http\Services\OrderService;
use App\Http\Services\OrderProductService;
use Illuminate\Support\Facades\DB;
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;
use Illuminate\Http\Request;
use Ecpay\Sdk\Response\VerifiedArrayResponse;

// require __DIR__ . '/../../vendor/autoload.php';
class OrderController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    protected $orderService;
    protected $cartService;
    protected $orderProductService;
    protected $productService;



    public function __construct(ProductService $productService, CartService $cartService, OrderService $orderService, OrderProductService $orderProductService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->orderProductService = $orderProductService;
        $this->productService = $productService;
    }



    public function index(Request $request) 
    {
        try {
            DB::beginTransaction();
            $this->cartService->checkAll(); #檢查庫存夠不夠
            $cart = $this->cartService->index();
            $sum = $cart->sum('number');

            if ($sum > 17) {
                $ship_amount = 225;
            } else {
                $ship_amount = 160;
            }

            $total_amount = 0;
            $items = $cart->get();
            $form_info_product = '';
            foreach ($items as $item) {
                $total_amount += $item->number * $item->product->price;
                $form_info_product = $form_info_product . '#' . $item->product->name . 'x' . $item->number . ' $' . $item->number * $item->product->price;
            }
            $form_info_product = $form_info_product . '#運費 $' . $ship_amount;
            $total_amount += $ship_amount;

            $order_id = date('YmdHis') . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
          




            // 建立訂單
            $this->orderService->add($request, intval($order_id), $total_amount);
            
            // 建立訂單商品項目
            foreach ($items as $item) {
                
                $this->orderProductService->add(intval($order_id), $item->product_id, $item->product->price, $item->number);
                
                // 扣除庫存
                $this->productService->update(['product_id' => $item->product_id, 'amount' => $item->product->amount - $item->number]);
                
            }

            
            // 清空購物車
            $this->cartService->deleteAll();
           
            $this->orderService->update(intval($order_id), 1);#訂單成立
           
            //呼叫綠界
            $factory = new Factory([
                'hashKey' => '5294y06JbISpM5x9',
                'hashIv' => 'v77hoKGq4kWxNNIS',
            ]);
            $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

            $input = [
                'MerchantID' => '2000132',
                'MerchantTradeNo' =>  $order_id,
                'MerchantTradeDate' => date('Y/m/d H:i:s'),
                'PaymentType' => 'aio',
                'TotalAmount' => $total_amount,
                'TradeDesc' => UrlService::ecpayUrlEncode('mamaShop'),
                'ItemName' => $form_info_product,
                'ChoosePayment' => 'ALL',
                'EncryptType' => 1,

                // 請參考 example/Payment/GetCheckoutResponse.php 範例開發
                'ReturnURL' => ' https://f755-182-233-167-85.jp.ngrok.io/order/checkCallback',
                'ClientBackURL'  => ' https://f755-182-233-167-85.jp.ngrok.io/order/success'
            ];
            $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

            $this->orderService->update(intval($order_id), 2);#訂單成立
            
            echo $autoSubmitFormService->generate($input, $action);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // return response()->json(['message' => '建立訂單失敗', "e" => $e], 500);
        }

        // return response()->json([
        //     'status' => $form_info_product,

        // ], 200);
    }
    public function checkCallback(Request $request) #所有商品資訊及相片
    {
        $factory = new Factory([
            'hashKey' => '5294y06JbISpM5x9',
            'hashIv' => 'v77hoKGq4kWxNNIS',
        ]);
        $request = $request->all();
        
        $checkoutResponse = $factory->create(VerifiedArrayResponse::class);
        $request = $checkoutResponse->get($request);
        
        // $fp = fopen('requesttest.txt', 'w');//opens file in write-only mode  
        // fwrite($fp, implode("", $a));  
       
        // fclose($fp);  

        if ($request->RtnCode==1){
            $this->orderService->update(intval($request['MerchantTradeNo']), 3);#訂單排單製作中
       }
       echo '1|OK';
        
        
        
    }
   
}
