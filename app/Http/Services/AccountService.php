<?php


namespace App\Http\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
class AccountService
{


    public function index() //查詢所有帳號
    {

        return User::all();
    }
    public function memberInfomation() //查詢該帳號資訊
    {
        $account_id = session('account_id') ;
        $account = User::where('account_id', $account_id)->where('level',1)->where('status' , 1);
        return $account;
    }
    public function register($request) //註冊會員
    {
        $last_id = User::orderBy('id', 'desc')->limit(1)->value('account_id');
        $account = new User([
            'account_id' => $last_id+1,
            'password' => Hash::make($request->password),
            'phone' => Cache::get('checked_phone'),
            'name' => $request->name,
            'level' => 1,
            'status' => 1,
            ]);
        return $account->save();
    }

    public function resetPassword($request)
    {
       ;
        $account = User::where('phone', $request['phone'])->where('level',1)->where('status' , 1);
       
        $account->password = Hash::make($request['password']);
    
        
        return $account->save();
    } 

    public function resetInfomation($request) 
    {
       
       
        $account = User::wherewhere('phone', $request['phone'])->where('level',1)->where('status' , 1);
       
        $account->name = $request['name'];
    
        
        return $account->save();


        
    }
   
}
