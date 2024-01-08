<?php

namespace App\Http\Requests\IE;

use Illuminate\Foundation\Http\FormRequest;

class CASubCategoriesStoreRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'account_code' => 'required',
            'sub_account_code' => 'required',
            // 'branch_code' => 'required',
            // 'department_code' => 'required',
            // 'accessible_orgs' => 'required',
        ];

        if($this->end_date){
            $rules['start_date'] = 'required|before:end_date';
        }else{
            $rules['start_date'] = 'required';
        }

        return $rules;
    }
}
