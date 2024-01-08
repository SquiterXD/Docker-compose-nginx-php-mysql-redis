<?php

namespace App\Repositories\Report\Traits;

use App\Http\Controllers\CT\Reports\CTR0006Controller;
use App\Http\Controllers\CT\Reports\CTR0012Controller;
use App\Http\Controllers\CT\Reports\CTR0027Controller;
use App\Http\Controllers\CT\Reports\CTR0028Controller;
use App\Http\Controllers\CT\Reports\CTR0032Controller;
use App\Http\Controllers\CT\Reports\CTR0039Controller;
use App\Http\Controllers\CT\Reports\CTR0040Controller;
use App\Http\Controllers\CT\Reports\CTR1050Controller;
use App\Http\Controllers\CT\Reports\OMP0040Controller;
use App\Http\Controllers\CT\Reports\OMP0041Controller;
use App\Http\Controllers\CT\Reports\OMP0046Controller;
use App\Http\Controllers\CT\Reports\OMR0004Controller;
use App\Http\Controllers\CT\Reports\OMR0020Controller;
use App\Http\Controllers\CT\Reports\OMR0036Controller;
use App\Http\Controllers\CT\Reports\OMR0048Controller;
use App\Http\Controllers\CT\Reports\OMR0049Controller;
use App\Http\Controllers\CT\Reports\OMR0050Controller;
use App\Http\Controllers\CT\Reports\OMR0051Controller;
use App\Http\Controllers\CT\Reports\OMR0059Controller;
use App\Http\Controllers\CT\Reports\OMR0062Controller;
use App\Http\Controllers\CT\Reports\OMR0066Controller;
use App\Http\Controllers\CT\Reports\OMR0071Controller;
use App\Http\Controllers\CT\Reports\OMR0082Controller;
use App\Http\Controllers\CT\Reports\OMR0089Controller;
use App\Http\Controllers\CT\Reports\OMR0090Controller;
use App\Http\Controllers\CT\Reports\OMR0091Controller;
use App\Http\Controllers\CT\Reports\OMR0123Controller;
use App\Http\Controllers\CT\Reports\PDR0003Controller;
use App\Http\Controllers\CT\Reports\PDR0004Controller;
use App\Http\Controllers\CT\Reports\PDR0007Controller;
use App\Http\Controllers\CT\Reports\PDR0008Controller;
use App\Http\Controllers\CT\Reports\PDR0280Controller;
use App\Http\Controllers\CT\Reports\PMR0280Controller;
use App\Http\Controllers\OM\Reports\OMR0099Controller;
use App\Http\Controllers\OM\Reports\OMR0101Controller;
use App\Http\Controllers\OM\Reports\OMR0116Controller;
use FormatDate;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use PDO;


trait Korapat {
    public function CTR0039($programcode, $request) {
        return (new CTR0039Controller)->CTR0039EXCEL($programcode, $request);
    }
    public function CTR0040($programcode, $request) {
        return (new CTR0040Controller)->CTR0040EXCEL($programcode, $request);
    }
    
    
    public function OMR0116($programcode, $request)
    {
        return (new OMR0116Controller)->OMR0166PDF($programcode, $request);
    }

    public function CTR0006($programcode, $request) {
        return (new CTR0006Controller)->CTR0006EXCEL($programcode, $request);
    }

    public function CTR0027($programcode, $request) {
        return (new CTR0027Controller)->CTR0027EXCEL($programcode, $request);
    }
    public function CTR0028($programcode, $request) {
        return (new CTR0028Controller)->CTR0028EXCEL($programcode, $request);
    }
    public function PDR0007($programcode, $request) {
        return (new PDR0007Controller)->PDR0007EXCEL($programcode, $request);
    }
    public function PDR0008($programcode, $request) {
        return (new PDR0008Controller)->PDR0008EXCEL($programcode, $request);
    }
    public function PDR0003($programcode, $request) {
        return (new PDR0003Controller)->PDR0003($programcode, $request);
    }
    public function PDR0004($programcode, $request) {
        return (new PDR0004Controller)->PDR0004($programcode, $request);
    }
    public function PDR0280($programcode, $request) {
        return (new PDR0280Controller)->PDR0280($programcode, $request);
    }
    
    
    public function CTR0012($programcode, $request) {
        return (new CTR0012Controller)->CTR0012($programcode, $request);
    }

    public function CTR0032($programcode, $request) {
        return (new CTR0032Controller)->CTR0032($programcode, $request);
    }

    public function OMP0040($programcode, $request) {
        return (new OMP0040Controller)->OMP0040($programcode, $request);
    }
    
    public function OMR0041($programcode, $request) {
        return (new OMP0041Controller)->OMP0041($programcode, $request);
    }

    public function OMR0046($programcode, $request) {
        return (new OMP0046Controller)->OMP0046($programcode, $request);
    }

    public function OMR0059($programcode, $request) {
        return (new OMR0059Controller)->OMR0059($programcode, $request);

    }
    public function OMR0091($programcode, $request) {
        return (new OMR0091Controller)->OMR0091($programcode, $request);
    }
    public function OMR0090($programcode, $request) {
        return (new OMR0090Controller)->OMR0090($programcode, $request);
    }

    public function OMR0066($programcode, $request) {
        return (new OMR0066Controller)->OMR0066($programcode, $request);
    }

    public function OMR0020($programcode, $request) {
        return (new OMR0020Controller)->OMR0020($programcode, $request);
    }
    public function OMR0036($programcode, $request) {
        return (new OMR0036Controller)->OMR0036($programcode, $request);
    }
    public function OMR0071($programcode, $request) {
        return (new OMR0071Controller)->OMR0071($programcode, $request);
    }
    public function OMR0082($programcode, $request) {
        return (new OMR0082Controller)->OMR0082($programcode, $request);
    }

    public function OMR0089($programcode, $request) {
        return (new OMR0089Controller)->OMR0089($programcode, $request);
    }

    public function PMR0280($programcode, $request) {
        return (new PMR0280Controller)->PDR0280($programcode, $request);
    }
    public function OMR0004($programcode, $request) {
        return (new OMR0004Controller)->OMR0004($programcode, $request);
    }
    public function OMR0062($programcode, $request) {
        return (new OMR0062Controller)->OMR0062($programcode, $request);
    }
    public function OMR0048($programcode, $request) {
        return (new OMR0048Controller)->OMR0048($programcode, $request);
    }

    public function OMR0050($programcode, $request) {
        if($request->program_code == "OMR0050") {
            return (new OMR0050Controller)->OMR0050($programcode, $request);
        } else {
            return (new OMR0051Controller)->OMR0051($programcode, $request);
        }
    }
    
    public function OMR0049($programcode, $request) {
        return (new OMR0049Controller)->OMR0049($programcode, $request);
    }
    public function OMR0099($programcode, $request) {
        return (new OMR0099Controller)->export($programcode, $request);
    }
    public function OMR0123($programcode, $request) {
        return (new OMR0123Controller)->OMR0123($programcode, $request);
    }
    
    public function OMR0101($programcode, $request) {
        return (new OMR0101Controller)->OMR0101($programcode, $request);
    }
    
}
