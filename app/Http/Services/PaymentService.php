<?php


namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Validation\ValidationException;
class PaymentService
{
   

    

    
  
    private $URL = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5"; #綠界測試用網址
    private $MERCHANT_ID="3002607"; #測試用特店編號
    private $PAYMENT_API_KEY;
    private $PAYMENT_API_SECRET;
    public function __construct()
    {

        $this->PAYMENT_API_KEY = config('payment.api_key');
        $this->PAYMENT_API_SECRET = config('payment.api_secret');
    }
   
    public function connect()
    {
       
        $client = new Client();
        return $client;
    }
}