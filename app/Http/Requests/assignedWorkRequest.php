<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignedWorkRequest extends FormRequest
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
            'tasks' => 'required',
            'employee_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name Required!',
            'tasks.required' => 'Tasks Required!',
            'employee_id.required' => 'Employee Required!',
        ];
    }
}
