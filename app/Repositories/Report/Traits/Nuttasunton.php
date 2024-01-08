<?php

namespace App\Repositories\Report\Traits;

use App\Http\Controllers\PD\Reports\PDR0006Controller;
use App\Http\Controllers\CT\Reports\CTR0035Controller;
use FormatDate;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PM\PMR0041;
use App\Exports\PM\PMR0180;
use App\Exports\PM\PMR1030;
use App\Exports\PM\PMR3090;

use DB;
use PDO;


trait Nuttasunton {

    public function PDR0006($programcode, $request) {
        return (new PDR0006Controller)->PDR0006($programcode, $request);
    }

    public function CTR0035($programcode, $request) {
        return (new CTR0035Controller)->CTR0035($programcode, $request);
    }

    public function PMR0041($programcode, $request) {
        if (request()->output == 'pdf') {
            return (new PMR0041)->pdf();
        }

        $programCode = request()->program_code;
        // return (new PMR0041)->view();
        return Excel::download(new PMR0041, $programCode.'.xlsx');
    }

    public function PMR0180($programcode, $request) {
        return (new PMR0180)->pdf();
    }

    public function PMR3090($programcode, $request) {
        $programCode = request()->program_code;
        // return (new PMR3090)->view();
        return Excel::download(new PMR3090, $programCode.'.xlsx');
    }

    public function PMR1030($programcode, $request) {
        $programCode = request()->program_code;
        if (request()->output == 'pdf') {
            return (new PMR1030)->pdf();
        }

        // return (new PMR1030)->view();
        return Excel::download(new PMR1030, $programCode.'.xlsx');
    }
}
