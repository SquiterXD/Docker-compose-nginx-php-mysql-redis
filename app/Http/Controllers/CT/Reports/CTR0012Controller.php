<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\PDR0003;
use App\Http\Controllers\Controller;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class CTR0012Controller extends Controller
{

    public function callPkgByBatch($request)
    {
        // $condition = '1=1 and batch_no is not null ';
        // if ($request->period_year) {
        //     $condition .= " and period_year = '$request->period_year'";
        // }

        // if ($request->cost_code) {
        //     $condition .= " and cost_code = '$request->cost_code'";
        // }

        // if ($request->transaction_date_from && $request->transaction_date_to) {
        //     $condition .= " and upper(period_name) between upper('$request->transaction_date_from') and upper('$request->transaction_date_to')";
        // }

        // if ($request->batch_from && !$request->batch_to) {
        //     $condition .= " and batch_no >= '$request->batch_from'";
        // } else if(!$request->batch_from && $request->batch_to) {
        //     $condition .= " and batch_no <= '$request->batch_to'";
        // } else if($request->batch_from && $request->batch_to) {
        //     $condition .= " and batch_no >= '$request->batch_from' and  batch_no <= '$request->batch_to'";
        // }

        // $findData = DB::table('oact.ptct_ctr0012')->selectRaw("max(rpt_id) rpt_id")->whereRaw($condition)->first();
        // return optional($findData)->rpt_id ?? -1;
        // -------------------------- -----------
        $result = array();
        $db     = DB::connection('oracle')->getPdo();
        $sql    = "declare
                x_rpt_id number;
                begin
                    ptct_report_pkg.CTR0012 (P_YEAR       => '{$request->period_year}'
                                    ,P_COST_CODE => '{$request->cost_code}'
                                    ,P_PERIOD_FROM => '{$request->transaction_date_from}' 
                                    ,P_PERIOD_TO   => '{$request->transaction_date_to}'
                                    ,p_dept_code => ''
                                    ,P_BATCH_NO_FROM => '{$request->batch_from}'
                                    ,P_BATCH_NO_TO => '{$request->batch_to}'
                
                                    ,X_RPT_ID    => :x_rpt_id );
                                    
                    commit;
                end;";
        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        logger($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $result['x_rpt_id'];
    }

    public function callPkgByProd($request)
    {
        // $condition = '1=1 and batch_no is null ';
        // if ($request->period_year) {
        //     $condition .= " and period_year = '$request->period_year'";
        // }

        // if ($request->cost_code) {
        //     $condition .= " and cost_code = '$request->cost_code'";
        // }

        // if ($request->transaction_date_from && $request->transaction_date_to) {
        //     $condition .= " and upper(period_name) between upper('$request->transaction_date_from') and upper('$request->transaction_date_to')";
        // }

        // $findData = DB::table('oact.ptct_ctr0012')->selectRaw("max(rpt_id) rpt_id")->whereRaw($condition)->first();
        // return optional($findData)->rpt_id ?? -1;
        // -------------------------- -----------
        $result = array();
        $db     = DB::connection('oracle')->getPdo();
        $sql    = "declare
                    v_rpt_id                varchar2(50);
                    begin
                        ptct_ctr0012_rpt.prod_main (P_YEAR => '{$request->period_year}'
                                        ,P_COST_CODE => '{$request->cost_code}'
                                        ,P_PERIOD_FROM => '{$request->transaction_date_from}' 
                                        ,P_PERIOD_TO => '{$request->transaction_date_to}' 
                                        ,p_dept_code => ''
                                        ,P_BATCH_NO_FROM => ''
                                        ,P_BATCH_NO_TO  => ''
                                        ,X_RPT_ID => :v_rpt_id);
                        dbms_output.put_line('RPT ID : ' || v_rpt_id);
                    end;";

        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        logger($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_rpt_id', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $result['x_rpt_id'];
    }

    public function CTR0012($programcode, Request $request)
    {
        // แยกตามคำสั่งผลิต
        ini_set('max_execution_time', '3000');
        logger('start call package-----+ '.date('Y-m-d H:i:s'));
        if ($request->product_type == 'no') {
            $x_rpt_id = $this->callPkgByBatch($request);
            logger('BATCH---+ '.date('Y-m-d H:i:s'));
        } else {
            $x_rpt_id = $this->callPkgByProd($request);
            logger('PROD---+ '.date('Y-m-d H:i:s'));
        }
        $result = DB::table('oact.ptct_ctr0012')->where('rpt_id', $x_rpt_id)->get();
        // $result = DB::table('oact.ptct_ctr0012')->where('rpt_id', 4133)->get();
        // return (new CTR0012($result, $request))->view();
        logger('start report-----+ '.date('Y-m-d H:i:s'));
        return Excel::download(new CTR0012($result, $request), 'ctr0012.xlsx');
    }
}
