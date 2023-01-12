<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code' => 'required',
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Code Required!',
            'name.required' => 'Name Required!',
            'qty.required' => 'Quantity Required!',
            'price.required' => 'Purchase Price Required!',
        ];
    }
}
