<?php

namespace App\Http\Requests\IE;

use Illuminate\Foundation\Http\FormRequest;

class SetDueDateRequest extends FormRequest
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
        $rules = ['due_date'  =>  'required'];
        
        if($this->payment_method_type == 'method'){
            $rules['payment_method_id'] = 'required';
        }

        return $rules;
    }
}
