<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtctCostCenterV;
// use App\Models\CT\SummaryCtp0003V;
// use App\Models\CT\Ctp0003DetailsV;

class InquireProductionController extends Controller
{
    public function index()
    {
        $periods = collect(\DB::select("
            select distinct period_year_th 
            from pt_biweekly_v
            order by period_year_th asc
        "));

        $costs = PtctCostCenterV::selectRaw("distinct cost_code, description")
                            ->orderBy('cost_code')
                            ->get();

        return view('ct.inquire_production.index', [
            'periods'  => $periods,
            'costs'    => $costs,
        ]);
    }
}
