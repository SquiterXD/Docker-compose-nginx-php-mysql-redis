<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\SummaryCtp0003V;
use App\Models\CT\Ctp0003DetailsV;

class InquireProductionController extends Controller
{
    public function getPeriodName()
    {
        $period        = request()->period;

        $data = collect(\DB::select("
            select distinct period_name, biweekly_id
            from pt_biweekly_v
            where period_year_th = '{$period}'
            order by biweekly_id asc
        "))->unique('period_name');

        return response()->json($data);
    }

    public function index()
    {
        $period_year = request()->period_year_th-543;
        $period_name = request()->period_name;
        $cost_code   = request()->cost_code;

        // $data = SummaryCtp0003V::where('period_year', $period_year)
        //                             ->where('period_name', $period_name)
        //                             ->where('cost_code', $cost_code)
        //                             ->orderBy('period_num')
        //                             ->orderBy('biweekly')
        //                             ->get();

        $data = collect(\DB::select("
            select *
            from    oact.ptct_summary_ctp0003_v psc
            where   (select pp.start_date
                    from    pt_periods_v pp
                    where   pp.period_name = '{$period_name}') 
            between (select  pp.start_date
                    from    pt_periods_v pp
                    where   pp.period_name = psc.from_period_name) 
            and  (select  pp.end_date
                from    pt_periods_v pp
                where   pp.period_name = nvl(psc.to_period_name,'{$period_name}'))
            and from_period_year = '{$period_year}'
            and cost_code = '{$cost_code}'
            and from_period_name = '{$period_name}'
            order by last_transaction_date desc, batch_no asc, item_number asc
        "));
        
        return response()->json($data);
    }

    public function getLines()
    {
        $period_name = request()->period_name;
        $cost_code   = request()->cost_code;
        $batch_no    = request()->batch_no;

        // $data = Ctp0003DetailsV::where('period_name', $period_name)
        //                             ->where('cost_code', $cost_code)
        //                             ->where('batch_no', $batch_no)
        //                             ->orderBy('transaction_date', 'desc')
        //                             ->get();

        $data = collect(\DB::select("
            select *
            from  oact.ptct_ctp0003_details_v psc, 
                pt_periods_v pp
            where pp.period_name = '{$period_name}'
            and psc.batch_no = '{$batch_no}'
            and psc.cost_code = '{$cost_code}'
            and psc.transaction_date between pp.start_date and pp.end_date
            order by transaction_date desc
        "));

        // dd($period_name, $cost_code, $batch_no, $data);

        return response()->json($data);
    }
}
