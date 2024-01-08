<?php

namespace App\Http\Requests\PM;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadPostRawMetarialImageRequest extends FormRequest
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
            'image' => 'required|mimes:jpeg,png,bmp',
            'organization_id' => 'required',
            'organization_code' => 'required',
            'item_cat_code' => 'required',

        ];
    }
}
