<?php

namespace App\Http\Controllers\PD\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PD\PtdpSpeciesForecastV;
use App\Models\PD\PtdpTobaccoForecastV;
use App\Models\PD\PtpdEstimateMtSaleHeader;

class PDP0015Controller extends Controller
{
    public function index()
    {

        $userProfile = getDefaultData('/pd');

        $data = [];
        $data['title']          = 'PDP0015: ประมาณการใช้วัตถุดิบในคงคลัง';
        $data['description']    = 'ประมาณการใช้วัตถุดิบในคงคลัง';

        $types                  = PtdpTobaccoForecastV::when(session('organization_code') != 'M02', function($q) {
                                        $q->whereNotIn('ingredien_tobacco_type', ['1004']); // 1004 เครื่องปรุงบุหรี่
                                    })
                                    ->get();
        $species                = PtdpSpeciesForecastV::get();
        $statuses               = (object)[
                                    'INACTIVE'  => 'Inactive',
                                    'APPROVED'  => 'Approved'
                                ];
        $headers = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT fiscal_year_th")
                    ->orderBy('fiscal_year_th')
                    ->get(['fiscal_year_th']);

        $salesFiscalYearNoArr   = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT sales_fiscal_year_no")
                                                        ->whereNotNull('sales_fiscal_year_no')
                                                        ->orderBy('sales_fiscal_year_no' , 'desc')
                                                        ->get();
        return view('pd/pdp0015/index', [
            'data'                  => (object)$data,
            'userProfile'           => $userProfile,
            'types'                 => $types,
            'statuses'              => $statuses,
            'headers'               => [],
            'species'               => $species,
            'salesFiscalYearNoArr'  => $salesFiscalYearNoArr
        ]);
    }
}
