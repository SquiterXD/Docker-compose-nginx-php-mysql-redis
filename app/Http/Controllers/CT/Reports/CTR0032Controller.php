<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Http\Controllers\Controller;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class CTR0032Controller extends Controller
{

    public function callPkgByBatch($request, $programcode)
    {
        $result = array();
        $db     = DB::connection('oracle')->getPdo();
        $sql    = "declare
                x_rpt_id number;
                begin
                    ptct_report_pkg.CTR0032 (P_YEAR       => '{$request->period_year}'
                                    ,P_COST_CODE => '{$request->cost_code}'
                                    ,P_PERIOD_FROM => '{$request->transaction_date_from}' 
                                    ,P_PERIOD_TO   => '". (($programcode != 'CTR0031') ? $request->transaction_date_to :  $request->transaction_date_from) ."'
                                    ,p_dept_code => ''
                                    ,P_BATCH_NO_FROM => '{$request->batch_from}'
                                    ,P_BATCH_NO_TO => '{$request->batch_to}'
                
                                    ,X_RPT_ID    => :x_rpt_id );
                                    
                    commit;
                end;";
                $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $result['x_rpt_id'];
    }
    public function callPkgByProd($request, $programcode)
    {
        $result = array();
        $db     = DB::connection('oracle')->getPdo();
        $sql    = "declare
                x_rpt_id number;
                begin
                ptct_report_pkg.CTR0032_prod (P_YEAR       => '{$request->period_year}'
                	            ,P_COST_CODE => '{$request->cost_code}'
                            ,P_PERIOD_FROM => '{$request->transaction_date_from}'
                            ,P_PERIOD_TO   => '". (($programcode != 'CTR0031') ? $request->transaction_date_to : $request->transaction_date_from) ."'
                            ,p_dept_code => ''
                            ,P_BATCH_NO_FROM => '{$request->batch_from}'
                            ,P_BATCH_NO_TO => '{$request->batch_to}'

                            ,X_RPT_ID    => :x_rpt_id );
                    commit;
                end;";
        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $result['x_rpt_id'];
    }

    public function CTR0032($programcode, Request $request)
    {
        // แยกตามคำสั่งผลิต
        if ($request->product_type == 'no') {
            $x_rpt_id = $this->callPkgByBatch($request, $programcode);
        } else {
            $x_rpt_id = $this->callPkgByProd($request, $programcode);
        }
        // dd('xxx', $x_rpt_id);
        // $x_rpt_id = 1852;

        $result = DB::table('oact.ptct_ctr0032')->where('rpt_id', $x_rpt_id)->orderByRaw('item_number, batch_no')->get();
        // $result = DB::table('oact.ptct_ctr0032')->where('rpt_id', 4495)->get();
        // return (new CTR0032($result, $request, $programcode))->view();
        return Excel::download(new CTR0032($result, $request, $programcode), $programcode.'.xlsx');
    }
}
