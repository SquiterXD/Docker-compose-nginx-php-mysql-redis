<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CT\PtctMfgBatchGenWipend;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CT\CTR0091;

class CTR0091Controller extends Controller
{
    public function CTR0091PDF($programcode, $request){

        $apIn= PtctMfgBatchGenWipend::where('ct_product_code', $request->CT_PRODUCT_CODE)
        ->where('ct_dept_code', $request->ct_dept_code)
        ->whereNotNull('ct_dm_group')
        ->where('ct_cc_code', $request->ct_cc_code);

        if($request->startdate != 'Invalid date' && $request->enddate != 'enddate')
        $apIn->whereRaw(" to_date(ct_accounting_date, 'DD-Mon-YY') BETWEEN
        to_date('".$request->startdate."', 'DD/MM/YY')  AND to_date('".$request->enddate."', 'DD/MM/YY')");

        $apIn =  $apIn->get();
        $apIn = $apIn->map(function($item){
            // dd($item);
            $item->ct_dm_aq_inwip  = (int)str_replace(',','',$item->ct_dm_aq_inwip);
            $item->ct_dm_ap_inwip = (int)str_replace(',','',$item->ct_dm_ap_inwip);
            $item->ct_dm_aqsp_inwip = (int)str_replace(',','',$item->ct_dm_aqsp_inwip);
            $item->ct_dm_aqap_inwip = (int)str_replace(',','',$item->ct_dm_aqap_inwip);
            return $item;
        });

        $dm_group = $apIn->groupBy('ct_dm_group');
        $dm_group = $dm_group->sortKeys();
        $dm_group = $dm_group->map(function($item){

            $vh = $item->first();
            $result = new  \stdClass;
            $result->ct_dm_group = $vh->ct_dm_group;
            $result->ct_dm_group_name = $vh->ct_dm_group_name;
            $result->ct_dm_aq_inwip = $item->sum('ct_dm_aq_inwip');
            $result->ct_dm_aqap_inwip = $item->sum('ct_dm_aqap_inwip');
            return $result;

        });

        //////////////////////////////////////////////////////////////////////////////////

        $dept_code= PtctMfgBatchGenWipend::whereNotNull('ct_dm_group')
        ->where('ct_cc_code', $request->ct_cc_code);

        if($request->startdate != 'Invalid date' && $request->enddate != 'enddate')
            $dept_code->whereRaw(" to_date(ct_accounting_date, 'DD-Mon-YY') BETWEEN
            to_date('".$request->startdate."', 'DD/MM/YY')  AND to_date('".$request->enddate."', 'DD/MM/YY')");

            $dept_code =  $dept_code->get();
            $dept_code = $dept_code->map(function($item){
                // dd($item);
                $item->ct_dm_aq_inwip  = (int)str_replace(',','',$item->ct_dm_aq_inwip);
                $item->ct_dm_ap_inwip = (int)str_replace(',','',$item->ct_dm_ap_inwip);
                $item->ct_dm_aqsp_inwip = (int)str_replace(',','',$item->ct_dm_aqsp_inwip);
                $item->ct_dm_aqap_inwip = (int)str_replace(',','',$item->ct_dm_aqap_inwip);
                return $item;
            });

            $dm_group_dept = $dept_code->groupBy('ct_dm_group');
            $dm_group_dept = $dm_group_dept->sortKeys();
            $dm_group_dept = $dm_group_dept->map(function($item){

            $vh = $item->first();
            $result = new  \stdClass;
            $result->ct_dm_group = $vh->ct_dm_group;
            $result->ct_dm_group_name = $vh->ct_dm_group_name;
            $result->ct_dm_aq_inwip = $item->sum('ct_dm_aq_inwip');
            $result->ct_dm_aqap_inwip = $item->sum('ct_dm_aqap_inwip');
            // $result->ct_prd_aqsp_wipcomplete = $item->sum('ct_prd_aqsp_wipcomplete');
            return $result;

        });

        $fileName = date('Y/m/d');
        $contentHtml = view('ct.reports.ctr0091.main_page', compact('apIn','dm_group','dept_code','dm_group_dept'))->render();
        return PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream($fileName.'.pdf');

    }

    public function CTR0091EXCEL($programcode, $request)
    {
        // $apIn= PtctMfgBatchGenWipend::get();


        // return view('ct.reports.ctr0073.excel.excel', compact('apIn'));
        return Excel::download(new CTR0091, $programcode.'.xlsx');
    }
}
