<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IR\PtirReportIrr9120V;
use Excel;

class IRR9120Controller extends Controller
{

    public function export($programCode, $request){
        //dd('Begin IRR9120Controller ');
        // return Excel::download(new IRR9120, $programCode.'.xlsx');
   }
}
