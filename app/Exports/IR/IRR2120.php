<?php

namespace App\Exports\IR;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Models\IR\PtirIrr2120T;
use Arr;

use FormatDate;
use Carbon\Carbon;
use Carbon\CarbonInterval;

use App\Models\IR\Settings\PolicySetHeader;
use DB;
use PDO;
use Illuminate\Http\Request;


class IRR2120xx implements FromView //WithStyles

{
    public function view(): View
    {   
        //dd(request()['psl_year']);
        $batch_id = date("YmdHis");
        $db = DB::connection('oracle')->getPdo();

        $webBatchNo = '';
        $search = request();
        $psl_year = Arr::get(request()->all(),'psl_year');

        $policy_set_header_id = Arr::get(request()->all(),'policy_set_header_id');
        $accountid = Arr::get(request()->all(),'account_id');
        $policyStart = $search['policy_start'];
        $policyEnd = $search['policy_end'];
        $period_name = Arr::get(request()->all(), 'period_name');
        $periodName = date('M-y', strtotime(date('m-d-Y', strtotime(request()->period_name))));

        //dd($psl_year);

        $sql  = "
           DECLARE
                V_WEB_BATCH_NO VARCHAR2(1000) ;
                V_STATUS       VARCHAR2(1000) ;
                V_MESSAGE      VARCHAR2(1000) ;
           BEGIN
               dbms_output.put_line('---------------------  S T A R T. -------------------');

               ptir_irr2120_pkg.MAIN(                  
                                         P_MONTH           => '{$periodName}'
                                        ,P_POLICY_FROM     => '{$policyStart}'
                                        ,P_POLICY_TO       => '{$policyEnd}'
                                        ,P_PREPAID         => '{$accountid}'
                                        ,P_WEB_BATCH_NO    => :V_WEB_BATCH_NO
                                        ,P_STATUS          => :V_STATUS
                                        ,P_MESSAGE         => :V_MESSAGE
                               );
              dbms_output.put_line('V_WEB_BATCH_NO = '||:V_WEB_BATCH_NO);
              dbms_output.put_line('V_STATUS  = '||:V_STATUS);
              dbms_output.put_line('V_MESSAGE = '||:V_MESSAGE);
           
              V_WEB_BATCH_NO := 1 ; 

              dbms_output.put_line('---------------------  E N D. -------------------');
           EXCEPTION WHEN others THEN 
                 dbms_output.put_line('Error '||sqlerrm);
           END;
           ";

        \Log::info($sql);

        //dd($sql);
        //$sql = preg_replace("/[\r\n]*/","",$sql);
        //$stmt = $db->prepare($sql);
        //$stmt->bindParam($result['P_STATUS'], PDO::PARAM_STR, 20);

        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':V_WEB_BATCH_NO', $result['V_WEB_BATCH_NO'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':V_STATUS', $result['V_STATUS'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':V_MESSAGE', $result['V_MESSAGE'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        $webBatchNo = $result['V_WEB_BATCH_NO'] ;
        //\Log::info('status', $result);
        //dd($webBatchNo);

        $policy_set_header_id = Arr::get(request()->all(), 'policy_set_header_id');
        $period_name = Arr::get(request()->all(), 'period_name');

        $G1s = PtirIrr2120T::selectRaw("set_polycy
            ,stock_list_description
            ,sum_debit")
            ->where('WEB_BATCH_NO',$webBatchNo)
            ->groupBy('set_polycy','stock_list_description','sum_debit')
            ->get();

        $G1 = PtirIrr2120T::selectRaw("row_number
        ,set_polycy
        ,stock_list_description
        ,expense_account
        ,expense_account_desc
        ,net_amount
        ,record_type
        ,sum_debit")
        ->where('WEB_BATCH_NO',$webBatchNo)
        ->groupBy('row_number','set_polycy','stock_list_description','expense_account','expense_account_desc','net_amount','record_type','sum_debit')
        ->orderBy('row_number')
        ->get();
        //dd($psl_year = Arr::get(request()->all(), 'psl_year'));
        //dd($G1);

        $G2s = PtirIrr2120T::selectRaw("set_polycy
        ,description
        ,sum_credit")
        ->where('WEB_BATCH_NO',$webBatchNo)
        ->groupBy('set_polycy','description','sum_credit')
        ->get();

       $G2 = PtirIrr2120T::selectRaw("description
       ,set_polycy
       ,account_code_combine
       ,account_combine_desc
       ,entered_cr
       ,record_type
       ,sum_credit")
       ->where('WEB_BATCH_NO',$webBatchNo)
       ->groupBy('description','set_polycy','account_code_combine','account_combine_desc','entered_cr','record_type','sum_credit')
       ->get();
        //dd($G2);

        $ParamMont = PeriodThai($period_name);

        // $Polycy = PolicySetHeader::select('policy_set_number','policy_set_description')
        // ->where('policy_set_header_id',$policy_set_header_id)
        // ->first();

        // $PolycyNum =$Polycy->policy_set_number;
        // $PolycyDesc =$Polycy->policy_set_description;
    
        //dd($PolycyDesc->policy_set_description);
        // return view('ct.Irr2120.index', compact('G1s','G2s','G1','G2','ParamMont','PolycyNum','PolycyDesc'));
        return view('ir.reports.Irr2120.index', compact('G1s','G2s','G1','G2','ParamMont'));
    }
}
function PeriodThai($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strMonthCut =  ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strMonthThai $strYear";
}