<?php

namespace App\Http\Requests\QM;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreQtmMachineSampleRequest extends FormRequest
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
        $repeatFlag = Request::get('repeat_flag'); // Retrieve repeat_flag
        
        $rules = [
            'task_type'         =>  'required',
            'equipment'         =>  'required',
            'machine_name'      =>  'required',
            'brand'             =>  'required',
            'sample_date'       =>  'required',
            'sample_time'       =>  'required',
            'repeat_flag'       =>  'required',
        ];

        if ($repeatFlag == 'true') {
            $rules['repeat_time_hour']      = 'required|integer';
            $rules['repeat_time_min']       = 'required|integer';
            $rules['repeat_qty']            = 'required|integer';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'task_type.required'            =>  'กรุณากรอก ประเภทงาน',
            'equipment.required'            =>  'กรุณากรอก หมายเลขเครื่อง QTM',
            'machine_name.required'         =>  'กรุณากรอก หมายเลขเครื่อง',
            'brand.required'                =>  'กรุณากรอก บุหรี่ / ก้นกรอง ',
            'sample_date.required'          =>  'กรุณากรอก วันที่เก็บตัวอย่าง',
            'sample_time.required'          =>  'กรุณากรอก เวลาที่เก็บตัวอย่าง',
            'repeat_flag.required'          =>  'กรุณากรอก สร้างซ้ำ',
            'repeat_time_hour.required'     =>  'กรุณากรอก รอบเวลาที่สร้าง ชั่วโมง',
            'repeat_time_min.required'      =>  'กรุณากรอก รอบเวลาที่สร้าง นาที',
            'repeat_qty.required'           =>  'กรุณากรอก จำนวนเลขที่ตัวอย่าง',
        ];
    }
}
