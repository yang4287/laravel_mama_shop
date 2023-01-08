<?php

namespace App\Http\Controllers;

use App\Http\Services\SmsService;
use App\Http\Requests\SmsPostRequest;

class SmsController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    protected $smsService;
 


    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
        
    }



    public function index(SmsPostRequest $request) #寄送簡訊
    {
        
        try{
            $client = $this->smsService->connect();
            $status = $this->smsService->sendSms( $client,$request);
            if ($status == 1){
                return response()->json([
                    'status' => 'success',
                    'message' => '已發送過驗證碼，請於時間內進行輸入!',

                ], 200);

            }
            // return response()->json(['request_id' => $request_id],200) ;
            return response()->json([
                'status' => 'success',
                'message' =>'發送成功!'
            ], 200);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e], 400);
        }
        

       
    }
    public function verify(SmsPostRequest $request) #驗證簡訊碼
    {
        
        
        
        try {

            $client = $this->smsService->connect();
            $this->smsService->verifyCheck($client,$request);
            
            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e], 422);
        }
        

       
    }

   


   
    
}
