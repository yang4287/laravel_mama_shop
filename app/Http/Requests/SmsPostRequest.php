<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmsPostRequest extends FormRequest
{
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
            'phone' => 'required|unique:account|regex:/^(09)\d{8}$/ '  //^為開頭，$為結尾
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.required' => '手機號碼為必填!',
            'phone.regex' => '手機號碼格式有誤，請輸入格式如0912345678',
            'phone.unique' => '此手機號碼已註冊過!',
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
        ];
    }
}
