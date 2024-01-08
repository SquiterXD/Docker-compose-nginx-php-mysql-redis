<?php

namespace App\Http\Requests\IE;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\IE\SubCategory;
use App\Models\IE\SubCategoryInfo;

class ReceiptLineStoreRequest extends FormRequest
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
            'sub_category_id' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'amount_inc_vat' => 'required|numeric'
        ];

        // if($this->sub_category_id){
        //     $infos = SubCategoryInfo::where('sub_category_id',$this->sub_category_id)
        //                             ->active()->get();
        //     if(count($infos)>0){
        //         foreach($infos as $info){
        //             if($info->required){
        //                 $rules['sub_category_infos'][$info->sub_category_info_id] = 'required';
        //             }
        //         }
        //     }
        // }
    
        return $rules
    }

    public function messages()
    {
        $messages = [
            // 'startdate.required' => 'Please input value start date.',
        ];
        return $messages;
    }
}
