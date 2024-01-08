<?php
namespace App\Repositories\Report\Traits;
/* OM */
use App\Http\Controllers\OM\Reports\OMR0025Controller;
use App\Http\Controllers\OM\Reports\OMR0033Controller;
use App\Http\Controllers\OM\Reports\OMR0044Controller;
use App\Http\Controllers\OM\Reports\OMR0045Controller;
use App\Http\Controllers\OM\Reports\OMR0054Controller;
use App\Http\Controllers\OM\Reports\OMR0055Controller;
use App\Http\Controllers\OM\Reports\OMR0056Controller;
use App\Http\Controllers\OM\Reports\OMR0057Controller;
use App\Http\Controllers\OM\Reports\OMR0058Controller;
use App\Http\Controllers\OM\Reports\OMR0060Controller;
use App\Http\Controllers\OM\Reports\OMR0061Controller;
use App\Http\Controllers\OM\Reports\OMR0068Controller;
use App\Http\Controllers\OM\Reports\OMR0074Controller;
use App\Http\Controllers\OM\Reports\OMR0075Controller;
use App\Http\Controllers\OM\Reports\OMR0076Controller;
use App\Http\Controllers\OM\Reports\OMR0086Controller;
/* IR */
use App\Http\Controllers\IR\Reports\IRR2140Controller;
use App\Http\Controllers\IR\Reports\IRR2210Controller;
use App\Http\Controllers\IR\Reports\IRR6030Controller;

use App\Http\Controllers\IR\Reports\IRR6050PController;
use App\Http\Controllers\IR\Reports\IRR7050Controller;
use App\Http\Controllers\IR\Reports\IRR0003_1Controller;
use App\Http\Controllers\IR\Reports\IRR0003_3Controller;
use App\Http\Controllers\IR\Reports\IRR6140Controller;
use App\Http\Controllers\IR\Reports\IRR0001_3Controller;
use App\Http\Controllers\IR\Reports\IRR0004_1Controller;
use App\Http\Controllers\IR\Reports\IRR0003_1_2Controller;

trait ReportCNX_NEO {
    /* OM */
    public function OMR0025($programCode, $request) {
        return (new OMR0025Controller)->export($programCode, $request);
    }
    public function OMR0033($programCode, $request) {
        return (new OMR0033Controller)->export($programCode, $request);
    }
    public function OMR0044($programCode, $request) {
        return (new OMR0044Controller)->export($programCode, $request);
    }
    public function OMR0045($programCode, $request) {
        return (new OMR0045Controller)->export($programCode, $request);
    }
    public function OMR0054($programCode, $request) {
        return (new OMR0054Controller)->export($programCode, $request);
    }
    public function OMR0055($programCode, $request) {
        return (new OMR0055Controller)->export($programCode, $request);
    }
    public function OMR0056($programCode, $request) {
        return (new OMR0056Controller)->export($programCode, $request);
    }
    public function OMR0057($programCode, $request) {
        return (new OMR0057Controller)->export($programCode, $request);
    }
    public function OMR0058($programCode, $request) {
        return (new OMR0058Controller)->export($programCode, $request);
    }
    public function OMR0060($programCode, $request) {
        return (new OMR0060Controller)->export($programCode, $request);
    }
    public function OMR0061($programCode, $request) {
        return (new OMR0061Controller)->export($programCode, $request);
    }
    public function OMR0068($programCode, $request) {
        return (new OMR0068Controller)->export($programCode, $request);
    }
    public function OMR0074($programCode, $request) {
        return (new OMR0074Controller)->export($programCode, $request);
    }
    public function OMR0075($programCode, $request) {
        return (new OMR0075Controller)->export($programCode, $request);
    }
    public function OMR0076($programCode, $request) {
        return (new OMR0076Controller)->export($programCode, $request);
    }
    public function OMR0086($programCode, $request) {
        return (new OMR0086Controller)->export($programCode, $request);
    }

    /* IR */
    public function IRR2140($programCode, $request) {
        return (new IRR2140Controller)->export($programCode, $request);
    }

    // public function IRR2210($programCode, $request) {
    //     return (new IRR2210Controller)->export($programCode, $request);
    // }
    public function IRR6140($programCode, $request) {
        return (new IRR6140Controller)->export($programCode, $request);
    }
    public function IRR6030($programCode, $request) {
        return (new IRR6030Controller)->export($programCode, $request);
    }

    public function IRR6050P($programCode, $request) {
        return (new IRR6050PController)->export($programCode, $request);
    }
    public function IRR7050($programCode, $request) {
        return (new IRR7050Controller)->export($programCode, $request);
    }
    public function IRR0003_1($programCode, $request){
        return (new IRR0003_1Controller)->export($programCode, $request);
    }
    public function IRR0003_3($programCode, $request){
        return (new IRR0003_3Controller)->export($programCode, $request);
    }
    public function IRR0001_3($programCode, $request) {
        return (new IRR0001_3Controller)->export($programCode, $request);
    }
    public function IRR0004_1($programCode, $request){
        return (new IRR0004_1Controller)->export($programCode, $request);
    }
}
