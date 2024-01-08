<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Models\IR\PtirArInvoiceInterfaces;
use App\Http\Requests\IR\ConfirmToApRequest;

class ConfirmToArController extends Controller
{
    protected $userId;

    public function __construct()
    {
        $this->userId = optional(auth()->user())->user_id ?? -1;
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\ConfirmToApRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function interfaceAr(ConfirmToApRequest $request)
    {
        if ($request->interface_type_code == 'IRP0005') {
            $request->claim_header_id = null;
        }
        $interface_year = $request->interface_year - 543;
        $collection = (new PtirArInvoiceInterfaces())->interfaceAr($request->interface_type_code, $request->claim_header_id, $interface_year, $this->userId);
        if ($collection['status'] == 'E') {
            $data = [ 'status' => $collection['status']
                    ,'msg' => $collection['msg']
                ];

            $response = error($data);
            return response($response, $response['status']);
        }

        // Piyawut A. 15122021
        $programCode = 'IRR8030';
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['interface_type_code' => $request->interface_type_code, 'claim_header_id' => $request->claim_header_id, 'status' => 'S', 'program_code' => $programCode, 'function_name' => $programCode, 'interface_year' => $interface_year, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);

        $response   = success(); 
        return response($response, $response['status']);
    }

    public function cancel(ConfirmToApRequest $request)
    {
        if ($request->interface_type_code == 'IRP0005') {
            $request->claim_header_id = null;
        }
        $interface_year = $request->interface_year - 543;
        $collection = (new PtirArInvoiceInterfaces())->cancel($request->interface_type_code, $request->claim_header_id, $this->userId);
        if ($collection['status'] == 'E')
        {
            $data = ['status' => $collection['status']
                        ,'msg' => $collection['msg']
                    ];

            $response = error($data);
            return response($response, $response['status']);
        }

        $programCode = 'IRR8030';
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['interface_type_code' => $request->interface_type_code, 'claim_header_id' => $request->claim_header_id, 'status' => 'S', 'program_code' => $programCode, 'function_name' => $programCode, 'interface_year' => $interface_year, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);
    }

    public function report(ConfirmToApRequest $request)
    {
        if ($request->interface_type_code == 'IRP0005') {
            $request->claim_header_id = null;
        }
        $interface_year = $request->interface_year - 543;
        $collection = (new PtirArInvoiceInterfaces())->report($request->interface_type_code, $request->claim_header_id, $interface_year, $this->userId);
        if ($collection['status'] == 'E') {
            $data = [ 'status' => $collection['status']
                        ,'msg' => $collection['msg']
                    ];
            $response = error($data);
            return response($response, $response['status']);
        }

        // Piyawut A. 15122021
        $programCode = 'IRR8030';
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['interface_type_code' => $request->interface_type_code, 'claim_header_id' => $request->claim_header_id, 'status' => 'P', 'program_code' => $programCode, 'function_name' => $programCode, 'interface_year' => $interface_year, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);
    } 
}