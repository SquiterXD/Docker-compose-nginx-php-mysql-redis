<?php

namespace App\Repositories\Report\Traits;

use App\Http\Controllers\IR\Reports\IRR2140Controller;
use App\Http\Controllers\IR\Reports\IRR0005_1Controller;
use App\Http\Controllers\OM\Reports\OMR0024Controller;
use App\Http\Controllers\OM\Reports\OMR0032Controller;
use App\Http\Controllers\OM\Reports\OMR0072Controller;
use App\Http\Controllers\OM\Reports\OMR0037Controller;
use App\Http\Controllers\IR\Reports\IRR0005_2Controller;



use App\Http\Controllers\OM\Reports\OMR0028Controller;
use  App\Http\Controllers\OM\Reports\OMR0034Controller;
use App\Http\Controllers\OM\Reports\OMR0058Controller;
use App\Http\Controllers\OM\Reports\OMR0055Controller;
use App\Http\Controllers\OM\Reports\OMR0056Controller;
use App\Http\Controllers\IR\Reports\IRR90101Controller;

trait ReportCNX {

  public function IRR0005($programCode, $request)
  {
    // return (new ReportsController)->export($programCode, $request->all());
  }

  //--------------------------- TLEN --------------------------------------start
  //------------- IRR ----------------
  public function IRR90101($programCode, $request)
  {
    return (new IRR90101Controller)->export($programCode, $request->all());
  }

  public function IRR9020($programCode, $request)
  {
    return (new IRR9020Controller)->export($programCode, $request->all());
  }

    //--------------------------- TLEN --------------------------------------start
        //------------- IRR ----------------
            public function IRR0005_1($programCode, $request)
            {
            return (new IRR0005_1Controller)->export($programCode, $request->all());
            }
            public function IRR0005_2($programCode, $request) {
                return (new IRR0005_2Controller)->export($programCode, $request->all());
            }

        //------------- OMR ----------------
            public function OMR0037($programCode, $request) {
                return (new OMR0037Controller)->export($programCode, $request->all());
            }
            public function OMR0032($programCode, $request) {
                return (new OMR0032Controller)->export($programCode, $request->all());
            }
            public function OMR0072($programCode, $request) {
                return (new OMR0072Controller)->export($programCode, $request->all());
            }
            public function OMR0024($programCode, $request) {
                switch ($variable = $request->layout) {
                    case '1':
                        return (new OMR0024Controller)->layout1($programCode, $request->all());
                        break;
                    case '2':
                        return (new OMR0024Controller)->layout2($programCode, $request->all());
                        break;
                    case '3':
                        return (new OMR0024Controller)->layout3($programCode, $request->all());
                        break;
                    case '4':
                        return (new OMR0024Controller)->layout4($programCode, $request->all());
                        break;
                    case '5':
                        return (new OMR0024Controller)->layout5($programCode, $request->all());
                        break;
                    default:
                        return (new OMR0024Controller)->export($programCode, $request->all());
                        break;
                }
            }
    //--------------------------- TLEN ----------------------------------------end

    public function OMR0034($programCode, $request) {
        return   (new OMR0034Controller)->export($programCode, $request);
        // return (new ReportsController)->export($programCode, $request->all());
    }

    // public function OMR0058($programCode, $request) {
    //     return   (new OMR0058Controller())->export($programCode, $request);
    //     // return (new ReportsController)->export($programCode, $request->all());
    // }

    public function OMR0028($programCode, $request) {
        return   (new OMR0028Controller)->export($programCode, $request);
        // return (new ReportsController)->export($programCode, $request->all());
    }

    // public function OMR0055($programCode, $request) {
    //     return   (new OMR0055Controller)->export($programCode, $request);
    //     // return (new ReportsController)->export($programCode, $request->all());
    // }

    // public function OMR0056($programCode, $request) {
    //     return (new OMR0056Controller)->export($programCode, $request);
    //     // return (new ReportsController)->export($programCode, $request->all());
    // }

    // public function IRR2140($programCode, $request)
    // {
    //   return (new IRR2140Controller)->export($programCode, $request);
    // return (new ReportsController)->export($programCode, $request->all());
    // }
}
