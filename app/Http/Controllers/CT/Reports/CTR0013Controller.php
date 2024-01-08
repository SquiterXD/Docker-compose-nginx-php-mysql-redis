<?php

namespace App\Http\Controllers\ct\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Exports\CT\CTR0013;
use App\Exports\CT\CTR0013T2;
use App\Exports\CT\CTR0013ByBatch;
use App\Exports\CT\CTR0013ByProd;

use Maatwebsite\Excel\Facades\Excel;

class CTR0013Controller extends Controller
{
    //
    public function export($programCode, $request)
    {
        
        $output = Arr::get($request->all(), 'output');
        // if($output <> 'pdf'){
            $TYPE = Arr::get($request->all(), 'P_REPORT_TYPE');
            if($TYPE=='no'){
                // return (new CTR0013ByBatch)->view();
                return Excel::download(new CTR0013ByBatch, $programCode.'.xlsx');
                return Excel::download(new CTR0013, $programCode.'.xlsx');
            }elseif($TYPE=='yes'){
                // return (new CTR0013ByProd)->view();
                return Excel::download(new CTR0013ByProd, $programCode.'.xlsx');
                return Excel::download(new CTR0013T2, $programCode.'.xlsx');

            }
        // }
    }
}
