<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\ConfirmToApRequest;
use App\Models\IR\PtirApInvoiceInterfaces;
use App\Models\IR\Views\PtirApInterfaceTypeView;

class ConfirmToApController extends Controller
{
    protected $userId;

    public function __construct()
    {
       $this->userId = optional(auth()->user())->user_id ?? -1;
    }

    public function interfaceAp(ConfirmToApRequest $request)
    {
        $collection = (new PtirApInvoiceInterfaces())->interfaceAp($request->year, $request->type, $request->date, $this->userId, $request->invoice_batch);
        if ($collection['status'] == 'E') {
            $data = ['status' => $collection['status']
                    ,'msg' => $collection['msg']
                ];

            $response = error($data);
            return response($response, $response['status']);
        }

        // Piyawut A. 07102021
        $programCode = 'IRR8010';
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['year' => $request->year, 'type' => $request->type, 'date' => $request->date, 'invoice_batch' => $request->invoice_batch, 'status' => 'S', 'program_code' => $programCode, 'function_name' => $programCode, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);

        $response   = success(); 
        return response($response, $response['status']);
    }

    public function cancel(ConfirmToApRequest $request)
    {
        $collection = (new PtirApInvoiceInterfaces())->cancel($request->year, $request->type, $request->date, $this->userId, $request->group_id);
        if ($collection['status'] == 'E') {
            $response = error($collection['msg']);
            return response($response, $response['status']);
        }

        $programCode = 'IRR8010';
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['year' => $request->year, 'type' => $request->type, 'date' => $request->date, 'invoice_batch' => $request->invoice_batch, 'status' => 'S', 'program_code' => $programCode, 'function_name' => $programCode, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);
    }


    public function report(ConfirmToApRequest $request) 
    {
        $collection = (new PtirApInvoiceInterfaces())->report($request->year, $request->type, $request->date, $this->userId, $request->invoice_batch);
        if ($collection['status'] == 'E') {
            $response = error($collection['msg']);
            return response($response, $response['status']);
        }

        // Piyawut A. 07102021
        $programCode = 'IRR8010';
        $data = [
            'redirect_to_export' => route('ir.report.get-param', ['year' => $request->year, 'type' => $request->type, 'date' => $request->date, 'invoice_batch' => $request->invoice_batch, 'status' => 'P', 'program_code' => $programCode, 'function_name' => $programCode, 'batch_no' => $collection['batch_no']])
        ];

        return response()->json(['data' => $data]);
    }

    // Piyawut A. 20211112
    public function getDataGroupId(ConfirmToApRequest $request) 
    {
        $year = $request->params['interface_year']-543;
        // $dateTh = date('Y-m-d', strtotime($request->params['invoice_date']));
        $parseDate = parseFromDateTh($request->params['invoice_date']);
        $date = date('d-m-Y', strtotime($parseDate));
        $groupId = PtirApInvoiceInterfaces::selectRaw('distinct h_attribute2 group_id, from_program_code, invoice_date')
                                    ->whereNotNull('h_attribute2')
                                    ->where('interface_year', $year)
                                    ->where('from_program_code', $request->params['from_program_code'])
                                    ->whereRaw("trunc(invoice_date) = TO_DATE('{$date}','dd-mm-YYYY')")
                                    ->where('interface_status', 'S')
                                    ->get();

        $data = ['group_id' => $groupId];
        return response()->json(['data' => $data]);
    }

    // Piyawut A. 20220129
    public function getDefaultAPBatch(ConfirmToApRequest $request)
    {
        $from_program_code = $request->params['from_program_code'];
        $parseDate = parseFromDateTh($request->params['invoice_date']);
        $date = date('Y-m-d', strtotime($parseDate));
        $result = (new PtirApInvoiceInterfaces)->apBatch($from_program_code, $date);
        $data = ['invoice_batch' => $result['v_invoice_batch']
                , 'status' => $result['status']
                , 'msg' => $result['msg']
            ];
        return response()->json(['data' => $data]);
        return $result;
    }
}
