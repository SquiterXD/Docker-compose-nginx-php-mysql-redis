<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'  => 'required|max:80',
            'username'  => 'required|max:80',
            'department_code'  => 'required',
            'fnd_user_id'  => 'required',
            'email' => 'nullable',
            'password' => 'nullable',
            'role_options' => 'nullable',
            'department_options' => 'nullable',
        ];

        return $rules;
    }
}
