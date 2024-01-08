<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\OM\reports\PtomLabelPackingV;
use Illuminate\Http\Request;
use PDF;

class OMR0116Controller extends Controller
{

    public function OMR0166PDF($programe_code, $request) {




        $model = PtomLabelPackingV::query();
        $model->when($request['date'], function($q)  use($request) {
            $q->whereRaw("TRUNC(delivery_date) = TO_DATE('{$request['date']}',  'DD/MM/YYYY')");
        });
        $model->when($request->prn, function($q) use($request){
            $q->where('pick_release_no', $request->prn);

        });
        
        $model->when($request->cn, function($q)  use($request) {
            $q->where('customer_number', $request->cn);
        });

        $results = $model->get();
        $fileName = "OMR0116-". now()->format('Y/m/d');
        $pdf = PDF::loadView('om.reports.omr0116.index', compact('fileName','results'));
        return $pdf
        ->setOption('page-width', '384')
        ->setOption('page-height', '192')
        ->setOption('header-font-name',"THSarabunNew")
        ->stream($fileName.'.pdf');
    }
   

}
