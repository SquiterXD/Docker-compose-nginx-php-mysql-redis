<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;

class ProgramInfoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'name'          => 'required|unique:pt_programs_info,program_code',
            'program_type'  => 'required',
            'module'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'The program code field is required.',
            // 'name.unique' => 'The program code is already in the system.'
        ];
    }
}
