<?php


namespace App\Http\Services;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
class AuthService {
   
    public function index($request) { 
        $request->validate([
            'phone' => ['required'],
            'password' => ['required'],
        ]);
        $account = User::where('phone', $request['phone'])->first();
        
        if (is_null($account)) {
           
            throw ValidationException::withMessages(['phone' => '此手機尚未註冊']);
       }
        if (!Hash::check( $request['password'], $account->password)) {
           
             throw ValidationException::withMessages(['password' => '密碼錯誤']);
        }
        
        $request->session()->flush();
        $request->session()->put('name', $account->name);        
        $request->session()->put('account_level', $account->level);
        $request->session()->put('account_id', $account->account_id);
        $user = $account;
        $token = $user->createToken('Token');
        $token->token->save();
       
        
   
       
    }
    public function logout($request) { 
        
        $account = User::where('account_id', session('account_id'))->where('status' , 1)->first();
        $user = $account;
        
        //$user->revoke();
       
        
        $request->session()->flush();
        
        
   
       
    }
    

    
   
}