<?php

namespace App\Http\Controllers;


use App\Http\Services\SmsService;
use App\Http\Services\AccountService;
use App\Http\Requests\AccountPostRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AccountController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    protected $smsService;
    protected $accountService;
  


    public function __construct(SmsService $smsService, AccountService $accountService)
    {
        $this->smsService = $smsService;
        $this->accountService = $accountService;
       
    }



    public function index() #查詢所有帳戶
    {

       

        return response()->json();
    }
    public function one() #查詢該帳戶資訊
    {

       

        return response()->json();
    }

    public function register(AccountPostRequest $request) 
    {

        
        try{
            
            $this->accountService->register($request);
            Cache::flush();
            return response()->json([
                'status' => 'success',
            ], 200);
            
            

        }catch(Exception $e){



           //return redirect('/member/sign-up')->withErrors($e)->withInput();
           return response()->json(['error' => $e], 422);
        }
        
       
        
        


        
    }

}
