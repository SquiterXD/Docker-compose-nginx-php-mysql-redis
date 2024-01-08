<?php

namespace App\Repositories\Report;

use  App\Http\Controllers\IR\ReportsController;
use App\Repositories\Report\IRRepo;
use App\Repositories\Report\PMRepo;
use App\Repositories\Report\OMRepo;
use App\Repositories\Report\Traits\ReportMcr;
use App\Repositories\Report\Traits\ReportCT;
use App\Repositories\Report\Traits\ReportOM;
use App\Repositories\Report\Traits\ReportCNX;
use App\Repositories\Report\Traits\Orawan;
use App\Repositories\Report\Traits\Jakapong;
use App\Repositories\Report\Traits\Chaiyapot;
use App\Repositories\Report\Traits\Jiradesh;
use App\Repositories\Report\Traits\Komsupanat;
use App\Repositories\Report\Traits\Montakan;
use App\Repositories\Report\Traits\Nattapon;
use App\Repositories\Report\Traits\Thanachot;
use App\Repositories\Report\Traits\Yokmanee;
use App\Repositories\Report\Traits\Sattapong;
use App\Repositories\Report\Traits\Korapat;
use App\Repositories\Report\Traits\Natcha;
use App\Repositories\Report\Traits\ReportCNX_NEO;
use App\Repositories\Report\Traits\Chanchai;
use App\Repositories\Report\Traits\Nuttasunton;

class ReportRepo
{
    use ReportMcr;
    use ReportCT;
    use ReportOM;
    use ReportCNX;
    use Korapat;
    use ReportCNX_NEO;
    use Orawan,Jakapong,Chaiyapot,Jiradesh,Komsupanat,Montakan,Nattapon,Thanachot,Yokmanee;
    use Sattapong;
    use Natcha;
    use Chanchai;
    use Nuttasunton;

    public function mapReport($reportModule, $code, $request)
    {
        if ($request->function_name) {
            return $this->{$request->function_name}($code, $request);
        }

        if($reportModule == 'OM'){
             //return   (new OMRepo)->mapReport($code, $request->all());
        }

        if ($reportModule == 'PM') {
            // return   (new PMRepo)->export($code, $request->all());
        }

        if ($reportModule == 'IR') {
            return (new IRRepo)->mapReport($code, $request->all());
            // return   (new ReportsController)->export($code, $request->all());
        }
    }
}
