<?php

namespace App\Http\Controllers\PD\Web;

use App\Http\Controllers\Controller;
use App\Models\PD\PtdpSpeciesForecastV;
use App\Models\PD\PtdpTobaccoForecastV;
use App\Models\PD\PtpdEstimateMtSaleHeader;
use App\Models\PD\PtpdSalesFiscalYearV;
use App\Models\PD\PtpdLLDYearV;

class PD0014Controller extends  Controller
{
    public function index()
    {
        $userProfile = getDefaultData('/pd');

        $data = [];
        $data['title']              = 'PDP0014 : ประมาณการใช้วัตถุดิบตามยอดจำหน่าย';
        $data['description']        = 'ประมาณการใช้วัตถุดิบตามยอดจำหน่าย';
        $types                      = PtdpTobaccoForecastV::get();
        $statuses                   = (object)[
                                        'INACTIVE'  => 'Inactive',
                                        'APPROVED'  => 'Approved'
                                    ];
        $salesFiscalYearNoCreateArr = PtpdSalesFiscalYearV::selectRaw("DISTINCT sales_fiscal_year_no , org_id")
                                                            ->get();
        $headers                    = [];
        $hYears                     = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT fiscal_year_th , fiscal_year_eng")
                                                            ->get();

        $salesFiscalYearNoArr       = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT sales_fiscal_year_no")
                                                                ->whereNotNull('sales_fiscal_year_no')
                                                                ->orderBy('sales_fiscal_year_no' , 'desc')
                                                                ->get();
                                                
        $LLDYearList                = PtpdLLDYearV::orderBy('lld_year' , 'desc')
                                                ->get();

        return view('pd/pdp0014/index', [
            'data'                          =>  (object)$data,
            'userProfile'                   =>  $userProfile,
            'types'                         =>  $types,
            'statuses'                      =>  $statuses,
            'headers'                       =>  $headers,
            'hYears'                        =>  $hYears,
            'salesFiscalYearNoCreateArr'    =>  $salesFiscalYearNoCreateArr,
            'salesFiscalYearNoArr'          =>  $salesFiscalYearNoArr,
            'LLDYearList'                   =>  $LLDYearList
        ]);
    }
}
