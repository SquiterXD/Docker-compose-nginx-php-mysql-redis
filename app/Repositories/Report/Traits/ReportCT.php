<?php

namespace App\Repositories\Report\Traits;
use  App\Http\Controllers\CT\Reports\CTR0101Controller;

trait ReportCT {

    // public function IRR0001($programCode, $request) {
    //     return (new ReportsController)->export($programCode, $request->all());
    // }

    public function CTR0101($programCode, $request) {
        return (new CTR0101Controller)->export($programCode, (object)$request->all());
    }

}
