<?php

namespace App\Repositories\Report;
use  App\Http\Controllers\IR\ReportsController;
use  App\Http\Controllers\IR\Reports\IRR9110Controller;
use  App\Http\Controllers\IR\Reports\IRR9040Controller;
use  App\Http\Controllers\IR\Reports\IRR8020Controller;
class IRRepo
{
    public function mapReport($code, $request)
    {
        // // dd($reportModule, $code, $request);
        // // return ;

        // if($reportModule == 'IR'){
        //     return   (new ReportsController)->export($code, $request->all());
        // }

        // if($reportModule == 'PM'){
        //     return   (new ReportsController)->export($code, $request->all());
        // }

        if($code == 'IRR0001' || $code == 'IRR0003'){

            // dd($request->all());
            return   (new ReportsController)->export($code, $request);
        }

        if($code == 'IRR9040'){
            return (new IRR9040Controller)->export($code, $request);
        }

        if($code == 'IRR9110'){
            return (new IRR9110Controller)->export($code, $request);
        }
    }

}
