<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            'name' => 'required',
            'supplier_id' => 'required',
            'qty' => 'required',
            'purchase_price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name Required!',
            'supplier_id.required' => 'Supplier Required!',
            'qty.required' => 'Quantity Required!',
            'purchase_price.required' => 'Purchase Price Required!',
        ];
    }
}
