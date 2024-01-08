<?php

namespace App\Http\Requests\OM;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRateRequest extends FormRequest
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
            'rate_start_date' => 'required',
            'cigarette_delivery_rates' => 'required',
            'leaf_delivery_rates' => 'required',
            'other_delivery_rates' => 'required',
            'delivery_rate_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'rate_start_date.required' => 'กรุณาเลือกวันที่อนุมัติเริ่มใช้อัตราใหม่',
            'cigarette_delivery_rates.required' => 'กรุณาระบุอัตราค่าขนส่งบุหรี่ใหม่',
            'leaf_delivery_rates.required' => 'กรุณาระบุอัตราค่าขนส่งยาเส้นใหม่',
            'other_delivery_rates.required' => 'กรุณาระบุอัตราค่าขนส่งอื่นๆใหม่',
            'delivery_rate_name.required' => 'กรุณาระบุรายการ',
        ];
    }
}
