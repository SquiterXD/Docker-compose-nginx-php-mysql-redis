<?php

namespace App\Repositories\IRRepo;
use  App\Http\Controllers\IR\ReportsController;

class IRRepo
{
    public function mapReport($reportModule, $code, $request)
    {
        // // dd($reportModule, $code, $request);
        // // return ;

        // if($reportModule == 'IR'){
        //     return   (new ReportsController)->export($code, $request->all());
        // }

        // if($reportModule == 'PM'){
        //     return   (new ReportsController)->export($code, $request->all());
        // }

        // if($code == 'IRP0001'){
        //     return redirect()->route();
        // }
    }

}
