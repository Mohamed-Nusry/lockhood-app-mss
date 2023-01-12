<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'product_ids' => 'required',
            'customer_name' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'amount' => 'required',
            'total' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_ids.required' => 'Products Required!',
            'customer_name.required' => 'Customer Name Required!',
            'address.required' => 'Address Required!',
            'mobile.required' => 'Mobile Required!',
            'amount.required' => 'Amount Required!',
            'total.required' => 'Total Required!',
        ];
    }
}
