<?php

namespace App\Http\Requests\EAM;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkRequestRequest extends FormRequest
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
            'work_request_number'  => 'max:64',
            'asset_number' => 'required|max:30',
            'asset_desc' => 'max:240',
            'work_request_owning_dept' => 'max:20',
            'owning_dept_code' => 'max:10',
            'owning_dept_desc' => 'required|max:240',
            'work_request_status_id' => 'max:20',
            'work_request_status_desc' => 'required|max:240',
            'receiving_dept_code' => 'max:20',
            'receiving_dept_desc' => 'required|max:240',
            'employee_id' => 'max:20',
            'employee_code' => 'max:30',
            'employee_desc' => 'required|max:240',
            'approver_desc' => 'max:240',
            'work_request_type_id' => 'max:20',
            'work_request_type_desc' => 'required|max:240',
            'description' => 'required|max:1000',
            'work_request_priority_id' => 'max:20',
            'work_request_priority_desc' => 'required|max:240',
            'wip_entity_id' => 'max:20',
            'work_order_number' => 'max:240',
            'jp_qty' => 'required_if:work_request_type_desc,JP|max:40',
            'wo_reference' => 'max:20',
            'approved_date' => '',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'owning_dept_desc.required' => 'ระบุหน่วยงานผู้แจ้ง',
            'receiving_dept_desc.required' => 'ระบุหน่วยงานผู้รับแจ้ง',
            'employee_desc.required' => 'ผู้แจ้งซ่อม'
        ];
    }
}
