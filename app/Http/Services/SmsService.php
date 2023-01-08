<?php


namespace App\Http\Services;



use Vonage\Client;
use Vonage\Client\Credentials\Container;
use Illuminate\Validation\ValidationException;
use Vonage\Client\Credentials\Basic;
use Vonage\Verify\Request;
use \Vonage\SMS\Message\SMS;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SmsService
{
    private $SMS_API_KEY;
    private $SMS_API_SECRET;
    public function __construct()
    {

        $this->SMS_API_KEY = config('sms.api_key');
        $this->SMS_API_SECRET = config('sms.api_secret');
    }
    public function connect()
    {
        $basic  = new Basic($this->SMS_API_KEY, $this->SMS_API_SECRET);
        $client = new Client(new Container($basic));
        return $client;
    }

    public function sendSms($client, $request)
    {
        $phone = intval('886' . substr($request->phone, 1)); //將09...轉換8869

        if (!Cache::has($phone)) {
            $code = substr(md5(rand()), 0, 4);
            $response = $client->sms()->send(
                new SMS($phone, "mama shop", '歡迎註冊MaMa好閒會員，您的驗證碼是' . $code . '，請於5分鐘內驗證完畢！')
            );
            $message = $response->current();
            $status = $message->getStatus();
            if ($status != 0){
                throw new Exception("請確認手機號碼是可接收簡訊!或系統有誤!", 1);
            }
            else{
                $expiresAt = Carbon::now()->addMinutes(5); #取得當前時間，計時五分鐘

                Cache::put($request->phone,  $code, $expiresAt);
                //Cache::put('code', $code, $expiresAt);
            
            }
             

           
        } else {
            $status = 1;
            return $status ;
            
        }
        //$phone = intval('886'.substr($request->phone,1)); //將09...轉換8869
        //$request_sms = new Request($phone, "mama shop",6);//6為僅發送一次     
        //$request_sms->setCodeLength(4);
        // $response = $client->verify()->start($request_sms); //開始驗證
        //$request_id = $response->getRequestId(); //$request_id為簡訊請求編號
        //$request_id ='test';





    }

    public function verifyCheck($client, $request)
    {

        $code = $request->code;
        $phone = $request->phone;
        if ( $code != Cache::get($phone))
            throw ValidationException::withMessages(['code' => '驗證碼錯誤!']);
        
        $expiresAt = Carbon::now()->addMinutes(5); #取得當前時間，計時五分鐘
        
        Cache::flush();

        Cache::put('checked_phone', $phone, $expiresAt);      
        
        //$request_id = session('request_id');

        //$result = $client->verify()->check($request_id, $code);
        //$checkStatus =$result->getResponseData();
        // if($checkStatus['status'] != "0"){
        //     throw ValidationException::withMessages(['code' => '驗證碼錯誤!']);
        // };

        // if ($code != "0") {
        //     throw ValidationException::withMessages(['code' => '驗證碼錯誤!']);
        // };
    }
    public function cancelSms($client, $request_id, $code)
    {
    }
}
