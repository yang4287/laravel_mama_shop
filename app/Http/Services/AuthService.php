<?php


namespace App\Http\Services;
use App\Models\Account;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
class AuthService {
    

    public function index($request) { 
        $request->validate([
            'account' => ['required'],
            'password' => ['required'],
        ]);
        $account = Account::where('account_id', $request['account'])->first();
        
        if (is_null($account)) {
           
            throw ValidationException::withMessages(['account' => '沒有此帳號']);
       }
        if (!Hash::check( $request['password'], $account->password)) {
           
             throw ValidationException::withMessages(['password' => '密碼錯誤']);
        }
        
        $request->session()->flush();
        $request->session()->put('account', $request['account']);        
        $request->session()->put('account_level', $account->level);
       
    }

    
   
}