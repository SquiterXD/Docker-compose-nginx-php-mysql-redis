<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\ConfirmToGlRequest;
use App\Models\IR\PtirGlInterfaces;

class ConfirmToGlController extends Controller
{
    protected $userId;
    public function __construct()
    {
        $this->userId = optional(auth()->user())->user_id ?? -1;
    }

    public function interfaceGl(ConfirmToGlRequest $request)
    {
        $collection = (new PtirGlInterfaces())->interfaceGl($request->period_name, $request->type, $request->group_code, $this->userId);
        if ($collection['status'] == 'E') {
            $data = ['status' => $collection['status']
                    ,'msg' => $collection['msg']
                ];
            $response = error($data);
            return response($response, $response['status']);
        }

        // Piyawut A.
        $programCode = 'IRR8020';
        $period = date('d-m-Y', strtotime('01/'.$request->period_name));
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['period_name' => $period, 'insurance_type' => $request->type, 'expense_type' => $request->group_code, 'status' => 'S', 'program_code' => $programCode, 'function_name' => $programCode, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);
    } 

    public function cancel(ConfirmToGlRequest $request)
    {
        $collection = (new PtirGlInterfaces())->cancel($request->period_name, $request->type, $request->group_code, $this->userId);
        if ($collection['status'] == 'E') {
            $data = ['status' => $collection['status']
                    ,'msg'    => $collection['msg']
                ];

            $response = error($data);
            return response($response, $response['status']);
        }

        $programCode = 'IRR8020';
        $period = date('d-m-Y', strtotime('01/'.$request->period_name));
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['period_name' => $period, 'insurance_type' => $request->type, 'expense_type' => $request->group_code, 'status' => 'S', 'program_code' => $programCode, 'function_name' => $programCode, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);
    }

    public function report(ConfirmToGlRequest $request)
    {
        $collection = (new PtirGlInterfaces())->report($request->period_name, $request->type, $request->group_code, $this->userId);
        if ($collection['status'] == 'E') {
            $data = [
                      'status' => $collection['status']
                        ,'msg' => $collection['msg']
                    ];

            $response = error($data);
            return response($response, $response['status']);
        }

        // Piyawut A.
        $programCode = 'IRR8020';
        $period = date('d-m-Y', strtotime('01/'.$request->period_name));
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['period_name' => $period, 'insurance_type' => $request->type, 'expense_type' => $request->group_code, 'status' => 'P', 'program_code' => $programCode, 'function_name' => $programCode, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);
    }
}
