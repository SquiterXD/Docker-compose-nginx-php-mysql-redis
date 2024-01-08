<?php

namespace App\Http\Requests\IE;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
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
            'name' => 'required|unique:ptw_locations,name,'.$this->location->location_id.",location_id",
            // 'description' => 'required',
            // 'accessible_orgs' => 'required',
            'org_id' => 'required',
        ];
    }
}
