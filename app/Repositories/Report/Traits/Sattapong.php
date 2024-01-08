<?php

namespace App\Repositories\Report\Traits;

use FormatDate;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use  App\Http\Controllers\CT\Reports\CTR0073Controller;
use  App\Http\Controllers\CT\Reports\CTR0091Controller;
use  App\Http\Controllers\OM\Reports\OMR0120Controller;
use  App\Http\Controllers\OM\Reports\OMR0121Controller;
use  App\Http\Controllers\OM\Reports\OMR0042Controller;
use  App\Http\Controllers\OM\Reports\OMR0030Controller;

use App\Models\CT\PtCtParams;
use App\Models\CT\DailyTransT;
use DB;
use PDO;


trait Sattapong {

    public function CTR0073($programcode, $request)
    {
        if($request->output == 'excel'){
            return   (new CTR0073Controller)->CTR0073EXCEL($programcode, $request);
        }

        return   (new CTR0073Controller)->CTR0073PDF($programcode, $request);

    }

    public function CTR0091($programcode, $request){

        if($request->output == 'excel'){
            return   (new CTR0091Controller)->CTR0091EXCEL($programcode, $request);
        }

        return   (new CTR0091Controller)->CTR0091PDF($programcode, $request);

    }

    public function OMR0120($programcode, $request){

        if($request->output == 'excel'){
            return   (new OMR0120Controller)->OMR0120EXCEL($programcode, $request);
        }

        return   (new OMR0120Controller)->OMR0120PDF($programcode, $request);


    }

    public function OMR0121($programcode, $request){

        if($request->output == 'excel'){
            return   (new OMR0121Controller)->OMR0121EXCEL($programcode, $request);
        }

        return   (new OMR0121Controller)->OMR0121PDF($programcode, $request);


    }

    public function OMR0042($programcode, $request){

        if($request->output == 'excel'){
            // return   (new OMR0042Controller)->OMR0120EXCEL($programcode, $request);
            return 'excel';
        }

        return   (new OMR0042Controller)->OMR0042PDF($programcode, $request);


    }

    public function OMR0030($programcode, $request){

        return   (new OMR0030Controller)->OMR0030EXCEL($programcode, $request);

    }
}
