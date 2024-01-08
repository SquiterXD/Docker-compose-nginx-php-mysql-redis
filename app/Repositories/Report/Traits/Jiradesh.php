<?php

namespace App\Repositories\Report\Traits;

use App\Http\Controllers\IR\Reports\IRR1001Controller;
use App\Http\Controllers\IR\Reports\IRR9120Controller;
use FormatDate;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\IR\PtirTuReportAssetV;

trait Jiradesh {

    public function IRR1001($programCode,$request)
    {
       //dd('call IRR1001Controller');
       return (new IRR1001Controller)->export($programCode, $request);
    }
    public function IRR9120($programCode,$request)
    {
        //dd('Call function IRR9120');
        return (new IRR9120Controller)->export($programCode, $request);

    }
}
