<?php

namespace App\Repositories\Report\Traits;
use  App\Http\Controllers\IR\ReportsController;

use  App\Http\Controllers\OM\Reports\OMR0124Controller;

trait ReportOM {
    // public function IRR0001($programCode, $request) {
    //     return   (new ReportsController)->export($programCode, $request->all());
    // }

    public function OMR0013($programCode, $request) {
        // dd($programCode, $request->all());
    }

    public function OMR0124($programCode, $request) {
        return (new OMR0124Controller)->export($programCode, $request);
    }

}
