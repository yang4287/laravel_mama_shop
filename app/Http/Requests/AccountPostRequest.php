<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountPostRequest extends FormRequest
{
    //protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'phone' => 'required|unique:account|regex:/^(09)\d{8}$/',
            'name' => 'required|string',                  
            //'code' => 'required',//此為簡訊驗證碼
            'password' => 'required|regex:/(?=.*\d)(?=.*[a-zA-Z]).{8,}/',
            'password_confirmation' => 'required|same:password'
        ]; 
    }
    public function messages()
    {
        return [
            //'phone.required' => '請先進行手機號碼簡訊驗證!',
            'name.required' => '請輸入姓名!',
            //'phone.regex' => '手機號碼格式有誤，請輸入格式如0912345678',
            //'phone.unique' => '此手機號碼已註冊過!',            
            //'code.required' => '請輸入簡訊驗證碼!',
            'password.required' => '請輸入密碼!',
            'password.regex' => '請輸入至少8個字元!且含有至少一個數字以及至少有一個大寫或小寫英文字母!',
            'password_confirmation.required' => '請輸入確認密碼!',
            'password_confirmation.same' => '密碼不一致，請輸入相同密碼!',
            
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'phone' => '手機號碼',
            'name' => '姓名',
            'request_id' => '簡訊請求',
            'code' => '簡訊驗證碼',
            'password' =>'密碼',
            'password_confirmation'  =>'確認密碼'
        ];
    }
}
