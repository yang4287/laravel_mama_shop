<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPostRequest extends FormRequest
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
            'product_id' => 'required|alpha_num',
            'name' => 'required|string',
            'class' => 'string',
            //'content' => 'required',
            'amount' => 'required|integer|min:0|max:999999',
            'price' => 'required|integer|min:1|max:9999999',
            'status' => 'required|string|min:1|max:1',
            'image.*.path' => 'required',
        ];
    }
}
