<?php

namespace App\Repositories\Report\Traits;

use FormatDate;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\CT\Reports\CTR007310Controller;
use App\Http\Controllers\OM\Reports\OMR0067Controller;
use App\Http\Controllers\PD\Reports\PDR0005Controller;

trait Natcha {
    public function CTR007310($programcode, $request)
    {
        if($request->output == 'excel'){
            return   (new CTR007310Controller)->CTR007310EXCEL($programcode, $request);
        }
    }

    public function OMR0067($programcode, $request)
    {
        return (new OMR0067Controller)->export($programcode, $request);
    }

    public function PDR0005($programcode, $request)
    {
        return (new PDR0005Controller)->export($programcode, $request);
    }
}
