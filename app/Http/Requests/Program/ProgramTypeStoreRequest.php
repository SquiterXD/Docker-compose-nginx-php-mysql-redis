<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;

class ProgramTypeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|unique:pt_program_types,program_type_name',
            'program_type'  => 'required',
            'user_type'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The program type name field is required.',
            'name.unique' => 'The program type name is already in the system.'
        ];
    }
}
