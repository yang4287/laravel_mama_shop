<?php


namespace App\Http\Services;
use App\Models\Account;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
class AuthService {
    

    public function index($request) { 
        $request->validate([
            'phone' => ['required'],
            'password' => ['required'],
        ]);
        $account = Account::where('phone', $request['phone'])->first();
        
        if (is_null($account)) {
           
            throw ValidationException::withMessages(['phone' => '此手機尚未註冊']);
       }
        if (!Hash::check( $request['password'], $account->password)) {
           
             throw ValidationException::withMessages(['password' => '密碼錯誤']);
        }
        
        $request->session()->flush();
        $request->session()->put('name', $request['name']);        
        $request->session()->put('account_level', $account->level);
       
    }

    
   
}