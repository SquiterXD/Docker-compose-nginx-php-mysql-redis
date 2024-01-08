<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\Ctp0002HeadersV;
use App\Models\CT\Ctp0002LinesV;

class RawMaterialInformationController extends Controller
{
    public function index()
    {
        $data = Ctp0002HeadersV::where('cost_code', request()->cost_code)
                                    // ->where('dept_code', request()->dept_code)
                                    ->where('transaction_date', date('Y-m-d', strtotime(request()->transaction_date)))
                                    ->orderByRaw('item_no asc, batch_no asc, wip_step asc')
                                    ->get();

        return response()->json($data);
    }

    public function getLines()
    {
        // dd('getLines', request()->all());
        $cost_code        = request()->cost_code;
        // $dept_code        = request()->dept_code;
        $batch_no         = request()->batch_no;
        $request_number   = request()->request_number;
        $transaction_date = request()->transaction_date ? date('Y-m-d', strtotime(request()->transaction_date)) : '';

        // AND H.DEPT_CODE = '{$dept_code}'

        $data = collect(\DB::select("
            SELECT L.*
            FROM PTCT_CTP0002_HEADERS_V  H  ,PTCT_CTP0002_LINES_V L
            WHERE 1=1
            AND H.COST_CODE  =  '{$cost_code}'
            AND H.BATCH_NO  = '{$batch_no}'
            AND H.REQUEST_NUMBER  = '{$request_number}'
            AND H.TRANSACTION_DATE  = '{$transaction_date}'
            AND H.BATCH_ID  = L.BATCH_ID
            AND H.REQUEST_NUMBER  = L.REQUEST_NUMBER
            
            ORDER BY L.item_no ASC
        "));

        return response()->json($data);
    }
}
