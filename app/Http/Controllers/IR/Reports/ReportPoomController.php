<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use FormatDate;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ProgramInfo;

use App\Models\IR\PtirIrr6120T;
use App\Models\IR\PtirIrr2210T;
use App\Models\IR\PtirIrr2120T;

use DB;
use PDO;

use Arr;

use App\Models\IR\Views\GlPeriodYearView;
use App\Models\IR\StockBalanceReport;
use App\Models\Lookup\ValueSetup;

class ReportPoomController extends Controller
{
    public function IRR0082_2PDF($programCode, $request)
    {
        // dd($programCode, $request->all());
        $program = ProgramInfo::where('program_code', $programCode)->first();
        $batch_id = date("YmdHis");
        $db = DB::connection('oracle')->getPdo();
        $webBatchNo = '';
        $search = request();
        $policy_set_header_id = Arr::get(request()->all(), 'policy_set_header_id');
        $year = $search['psl_year'];
        $policyStart = $search['policy_start'];
        $policyEnd = $search['policy_end'];
        $period_name = Arr::get(request()->all(), 'period_name');
        $periodName = date('M-y', strtotime(date('m-d-Y', strtotime($request->period_name))));
        //dd(request()->all());
        //dd($year,$policy_set_header_id,$period_name, $periodName, request()->all());

        $sql  = "
            DECLARE
                V_WEB_BATCH_NO VARCHAR2(1000) ;
                V_STATUS       VARCHAR2(1000) ;
                V_MESSAGE      VARCHAR2(1000) ;
            BEGIN
            dbms_output.put_line('---------------------  S T A R T. -------------------');

                PTIR_IRR6120_PKG.MAIN(
                     P_MONTH           => '{$periodName}'
                    ,P_POLICY_FROM     => '{$policyStart}'
                    ,P_POLICY_TO       => '{$policyEnd}'
                    ,P_WEB_BATCH_NO    => :V_WEB_BATCH_NO
                    ,P_STATUS          => :V_STATUS
                    ,P_MESSAGE         => :V_MESSAGE
                    );
                    
                dbms_output.put_line('V_WEB_BATCH_NO = '||:V_WEB_BATCH_NO);        
                dbms_output.put_line('V_STATUS       = '||:V_STATUS);
                dbms_output.put_line('V_MESSAGE      = '||:V_MESSAGE);

            dbms_output.put_line('---------------------  E N D. -------------------');
            EXCEPTION WHEN others THEN 
                 dbms_output.put_line('Error '||sqlerrm);
            END;
        ";
        \Log::info($sql);

        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':V_WEB_BATCH_NO', $result['V_WEB_BATCH_NO'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':V_STATUS', $result['V_STATUS'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':V_MESSAGE', $result['V_MESSAGE'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        $webBatchNo = $result['V_WEB_BATCH_NO'] ;
        $xxxx = $result['V_STATUS'] ;

        \Log::info($webBatchNo); 
        \Log::info($xxxx); 
        \Log::info($result['V_MESSAGE']);  

        ### Debit ###
        $G1_DATAH = PtirIrr6120T::selectRaw("policy_set_header_id
                                            ,policy_set_description
                                            ,location_name
                                            ,department_name
                                            ,category_desc
                                            ,expense_account
                                            ,expense_account_desc
                                            ,net_amt
                                            ,sum_amt
                                            ,credit_desc
                                            ,prepaid_account
                                            ,prepaid_account_desc")
            ->where('WEB_BATCH_NO',$webBatchNo)
            // ->groupBy('policy_set_header_id', 'policy_set_description', 'location_name', 'department_name', 'category_desc', 'expense_account', 'expense_account_desc', 'net_amt', 'sum_amt', 'credit_desc', 'prepaid_account', 'prepaid_account_desc')
            ->get();

        $ParamMont = PeriodThai($period_name);

        $pdf = PDF::loadView('ir.reports.irr0082_2.index', compact('G1_DATAH', 'program', 'ParamMont'))
            // ->setOption('header-html', view('ir.reports.irr6120.header-html', compact('G1_DATA', 'ParamMont')))
            ->setOption('margin-top', '5')
            ->setOption('margin-bottom', '5')

            // ->setOption('encoding', 'TIS-620')
            ->setOption('header-spacing',4)
            ->setOption('header-font-size', 13)
            ->setOption('header-right', "\n\n\n\n[page]/[topage]\t\t\t")
            ->setOption('header-font-name', "THSarabunNew")
            // ->setOption('lowquality', false)
            // ->setOption('disable-javascript', true)
            // ->setOption('disable-smart-shrinking', false)
            // ->setOption('print-media-type', true)
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', "Landscape")
            ->setPaper('a4');
            //dd($G1_DATAH);
        return $pdf->stream();
    }

    public function IRR6210PDF($programCode, $request)
    {
        $pdf = PDF::loadView('ir.reports.irr6210.index')
            ->setOption('header-html', view('ir.reports.irr6210.header-html'))
            ->setOption('margin-top', '30')
            ->setOption('margin-bottom', '25')
            ->setOption('encoding', 'UTF-8')
            // ->setOption('lowquality', false)
            // ->setOption('disable-javascript', true)
            // ->setOption('disable-smart-shrinking', false)
            // ->setOption('print-media-type', true)
            ->setOption('orientation', "Landscape")
            ->setPaper('a4');
        return $pdf->stream();
    }

    public function IRR2210PDF($programCode, $request)
    {
        $batch_id = date("YmdHis");
        $db = DB::connection('oracle')->getPdo();
        $webBatchNo = '';
        $search = request();
        $year = $search['psl_year'];
        $policyStart = $search['policy_start'];
        $policyEnd = $search['policy_end'];
        $period_name = Arr::get(request()->all(), 'period_name');
        $periodName = date('M-y', strtotime(date('m-d-Y', strtotime($request->period_name))));
        // dd($year,$policy_set_header_id,$period_name, $periodName, request()->all());

        $sql  = "
            DECLARE
                V_WEB_BATCH_NO VARCHAR2(1000) ;
                V_STATUS       VARCHAR2(1000) ;
                V_MESSAGE      VARCHAR2(1000) ;
            BEGIN
            dbms_output.put_line('---------------------  S T A R T. -------------------');

                PTIR_IRR2210_PKG.MAIN(
                     P_YEAR            => '{$year}'
                    ,P_MONTH           => '{$periodName}'
                    ,P_POLICY_FROM     => '{$policyStart}'
                    ,P_POLICY_TO       => '{$policyEnd}'
                    ,P_WEB_BATCH_NO    => :V_WEB_BATCH_NO
                    ,P_STATUS          => :V_STATUS
                    ,P_MESSAGE         => :V_MESSAGE
                    );
                    
                dbms_output.put_line('V_WEB_BATCH_NO = '||:V_WEB_BATCH_NO);        
                dbms_output.put_line('V_STATUS       = '||:V_STATUS);
                dbms_output.put_line('V_MESSAGE      = '||:V_MESSAGE);

            dbms_output.put_line('---------------------  E N D. -------------------');
            EXCEPTION WHEN others THEN 
                 dbms_output.put_line('Error '||sqlerrm);
            END;
        ";
        \Log::info($sql);

        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':V_WEB_BATCH_NO', $result['V_WEB_BATCH_NO'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':V_STATUS', $result['V_STATUS'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':V_MESSAGE', $result['V_MESSAGE'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        $webBatchNo = $result['V_WEB_BATCH_NO'] ;
        $xxxx = $result['V_STATUS'] ;

        \Log::info($webBatchNo); 
        \Log::info($xxxx); 
        \Log::info($result['V_MESSAGE']);  
              
        $G1_DATA = PtirIrr2210T::selectRaw("distinct period_name
                                            ,policy_set_header_id
                                            ,policy_set_desc
                                            ,polycy_form
                                            ,description
                                            ,account_code
                                            ,amount
                                            ,amount_receivable
                                            ,amount_payable
                                            ,amount_take
                                            ,amount_outstanding")
                ->whereBetween('policy_set_header_id', [$request->policy_start, $request->policy_end])
                ->where('period_name', $periodName)
                ->where('WEB_BATCH_NO', $webBatchNo)
                ->orderBy('polycy_form')
                ->get()
                ->groupBy('polycy_form');

        $G2_DATA = PtirIrr2210T::selectRaw("distinct period_name
                                            ,policy_set_header_id
                                            ,policy_set_desc
                                            ,polycy_form
                                            ,description
                                            ,account_code
                                            ,amount
                                            ,amount_receivable
                                            ,amount_payable
                                            ,amount_take
                                            ,amount_outstanding")
                ->whereBetween('policy_set_header_id', [$request->policy_start, $request->policy_end])
                // ->where('description', 'Test 18/1/2022')
                ->where('period_name', $periodName)
                ->where('WEB_BATCH_NO',$webBatchNo)
                ->orderBy('polycy_form')
                ->get()
                ->groupBy('policy_set_header_id');
                // dd($G2_DATA);
                $ParamMont = PeriodThai($period_name);
        
        $contentHtml = view('ir.reports.irr2210.index', compact('G1_DATA', 'G2_DATA', 'ParamMont'))->render();
        return \PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream('$fileName'.'.pdf');
    }

    // เปลี่ยน package ใหม่ 
    // public function IRR2120PDF($programCode, $request)
    // {
    //     //dd(request()['psl_year']);
    //     $program = ProgramInfo::where('program_code', $programCode)->first();
    //     $batch_id = date("YmdHis");
    //     $db = DB::connection('oracle')->getPdo();

    //     $webBatchNo = '';
    //     $search = request();
    //     $psl_year = Arr::get(request()->all(),'psl_year');

    //     $policy_set_header_id = Arr::get(request()->all(),'policy_set_header_id');
    //     $accountid = Arr::get(request()->all(),'account_id');
    //     $policyStart = $search['policy_start'];
    //     $policyEnd = $search['policy_end'];
    //     $period_name = Arr::get(request()->all(), 'period_name');
    //     $periodName = date('M-y', strtotime(date('m-d-Y', strtotime(request()->period_name))));

    //     $sql  = "
    //        DECLARE
    //             V_WEB_BATCH_NO VARCHAR2(1000) ;
    //             V_STATUS       VARCHAR2(1000) ;
    //             V_MESSAGE      VARCHAR2(1000) ;
    //        BEGIN
    //            dbms_output.put_line('---------------------  S T A R T. -------------------');

    //            ptir_irr2120_pkg.MAIN(                  
    //                                      P_MONTH           => '{$periodName}'
    //                                     ,P_POLICY_FROM     => '{$policyStart}'
    //                                     ,P_POLICY_TO       => '{$policyEnd}'
    //                                     ,P_PREPAID         => '{$accountid}'
    //                                     ,P_WEB_BATCH_NO    => :V_WEB_BATCH_NO
    //                                     ,P_STATUS          => :V_STATUS
    //                                     ,P_MESSAGE         => :V_MESSAGE
    //                            );
    //           dbms_output.put_line('V_WEB_BATCH_NO = '||:V_WEB_BATCH_NO);
    //           dbms_output.put_line('V_STATUS  = '||:V_STATUS);
    //           dbms_output.put_line('V_MESSAGE = '||:V_MESSAGE);
           
    //           V_WEB_BATCH_NO := 1 ; 

    //           dbms_output.put_line('---------------------  E N D. -------------------');
    //        EXCEPTION WHEN others THEN 
    //              dbms_output.put_line('Error '||sqlerrm);
    //        END;
    //        ";

    //     \Log::info($sql);

    //     //dd($sql);
    //     //$sql = preg_replace("/[\r\n]*/","",$sql);
    //     //$stmt = $db->prepare($sql);
    //     //$stmt->bindParam($result['P_STATUS'], PDO::PARAM_STR, 20);

    //     $result = [];
    //     $sql = preg_replace("/[\r\n]*/", "", $sql);
    //     $stmt = $db->prepare($sql);
        
    //     $stmt->bindParam(':V_WEB_BATCH_NO', $result['V_WEB_BATCH_NO'], \PDO::PARAM_STR, 100);
    //     $stmt->bindParam(':V_STATUS', $result['V_STATUS'], PDO::PARAM_STR, 20);
    //     $stmt->bindParam(':V_MESSAGE', $result['V_MESSAGE'], PDO::PARAM_STR, 2000);
    //     $stmt->execute();

    //     $webBatchNo = $result['V_WEB_BATCH_NO'] ;
    //     //\Log::info('status', $result);
    //     //dd($webBatchNo);

    //     $policy_set_header_id = Arr::get(request()->all(), 'policy_set_header_id');
    //     $period_name = Arr::get(request()->all(), 'period_name');
    //     //dd(request()->all());

    //     $G1s = PtirIrr2120T::selectRaw("polycy_set
    //         ,polycy_desc_set
    //         ,stock_list_description
    //         ,sum_debit")
    //         ->where('WEB_BATCH_NO',$webBatchNo)
    //         ->groupBy('polycy_set','polycy_desc_set','stock_list_description','sum_debit')
    //         ->get();

    //     $G1 = PtirIrr2120T::selectRaw("polycy_set
    //     ,polycy_desc_set
    //     ,stock_list_description
    //     ,expense_account
    //     ,expense_account_desc
    //     ,net_amount
    //     ,record_type
    //     ,sum_debit")
    //     ->where('WEB_BATCH_NO',$webBatchNo)
    //     ->groupBy('polycy_set','polycy_desc_set','stock_list_description','expense_account','expense_account_desc','net_amount','record_type','sum_debit')
    //     ->orderBy('polycy_set')
    //     ->get();
    //     //dd($psl_year = Arr::get(request()->all(), 'psl_year'));
    //     //dd($G1);

    //     $G2s = PtirIrr2120T::selectRaw("polycy_set
    //     ,polycy_desc_set
    //     ,account_description
    //     ,sum_credit")
    //     ->where('WEB_BATCH_NO',$webBatchNo)
    //     ->groupBy('polycy_set','polycy_desc_set','account_description','sum_credit')
    //     ->get();

    //    $G2 = PtirIrr2120T::selectRaw("account_description
    //    ,polycy_set
    //    ,polycy_desc_set
    //    ,account_code_combine
    //    ,account_combine_desc
    //    ,entered_cr
    //    ,record_type
    //    ,sum_credit")
    //    ->where('WEB_BATCH_NO',$webBatchNo)
    //    ->groupBy('account_description','polycy_set','polycy_desc_set','account_code_combine','account_combine_desc','entered_cr','record_type','sum_credit')
    //    ->get();
    //     //dd($G2);

    //     $ParamMont = PeriodThai($period_name);

    //     // $Polycy = PolicySetHeader::select('policy_set_number','policy_set_description')
    //     // ->where('policy_set_header_id',$policy_set_header_id)
    //     // ->first();

    //     // $PolycyNum =$Polycy->policy_set_number;
    //     // $PolycyDesc =$Polycy->policy_set_description;
    
    //     //dd($PolycyDesc->policy_set_description);
    //     // return view('ct.Irr2120.index', compact('G1s','G2s','G1','G2','ParamMont','PolycyNum','PolycyDesc'));
    //     $pdf = PDF::loadView('ir.reports.irr2120.index', compact('G1s', 'G1', 'G2s', 'G2', 'ParamMont', 'program'))
    //         // ->setOption('header-html', view('ir.reports.irr6120.header-html', compact('G1_DATA', 'ParamMont')))
    //         ->setOption('margin-top', '5')
    //         ->setOption('margin-bottom', '5')

    //         // ->setOption('encoding', 'TIS-620')
    //         ->setOption('header-spacing',5.3)
    //         ->setOption('header-font-size', 13)
    //         ->setOption('header-right', "\n\n\n\n[page]/[topage]\t\t\t")
    //         ->setOption('header-font-name', "THSarabunNew")
    //         // ->setOption('lowquality', false)
    //         // ->setOption('disable-javascript', true)
    //         // ->setOption('disable-smart-shrinking', false)
    //         // ->setOption('print-media-type', true)
    //         ->setOption('encoding', 'UTF-8')
    //         ->setOption('orientation', "Landscape")
    //         ->setPaper('a4');
    //         //dd($G1_DATAH);

    //     return $pdf->stream();

    // }

    public function IRR0081_2PDF($programCode, $request)
    {
        $program    = ProgramInfo::where('program_code', $programCode)->first();
        // $month      = date('m', strtotime(date('m-d-Y', strtotime($request->period_name))));
        $monthText  = date('M-y', strtotime(date('m-d-Y', strtotime($request->period_name))));
        $month      = request()->month_value;
        // dd($month, $monthText);
        // $policy_start = $request->policy_start;
        // $policy_end   = $request->policy_end;
        $periodYear = (new GlPeriodYearView())->getYear($monthText);
        $year       = $periodYear ? $periodYear->period_year : '';

        $result     = $this->callPackage(request(), $year);

        $dataDebit = StockBalanceReport::where('web_batch_no', $result['web_batch_no'])
                    ->whereNotNull('document_header_id')
                    ->with(['policyType', 'stocklines'])
                    ->orderBy('policy_set_header_id', 'asc')
                    ->orderBy('department_name', 'asc')
                    ->get()
                    ->groupBy(['policy_set_header_id']);
                    
        logger($result['web_batch_no']);

        // $dataCredit = [];
        // $dataCredit = StockBalanceReport::selectRaw('distinct prepaid_account, prepaid_account_desc')
        //             ->where('web_batch_no', $result['web_batch_no'])
        //             ->whereNotNull('document_header_id')
        //             ->get();

        $dataCredit = StockBalanceReport::where('web_batch_no', $result['web_batch_no'])
                    ->whereNotNull('document_header_id')
                    ->with(['policyType', 'stocklines'])
                    ->orderBy('policy_set_header_id', 'asc')
                    ->orderBy('department_name', 'asc')
                    ->get()
                    ->groupBy(['prepaid_account']);

        $accrued = ValueSetup::where('lookup_type' , 'PTIR_GL_INTERFACE')
                            ->where('lookup_code' , 'ACCRUAL_ACCOUNT')
                            ->first();
        // dd($accrued);
        // dd($programCode, $request->all(), $periodYear, $year, $result, $dataDebit, $dataCredit);
        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        $fileName = date('Ymdhms');

        // $pdf = \PDF::loadView('ir.reports.irr0081-2.main_page',compact('dataDebit', 'dataCredit', 'programCode', 'thaimonths', 'month', 'monthText'))
        //         ->setOption('header-html',view('ir.reports.irr0081-2.header',compact('request', 'programCode', 'thaimonths', 'month', 'monthText')))
        //         ->setOption('margin-top','40')
        //         ->setOption('margin-bottom','25')
        //         ->setOption('encoding','UTF-8')
        //         ->setOption('lowquality', false)
        //         ->setOption('disable-javascript', true)
        //         ->setOption('disable-smart-shrinking', false)
        //         ->setOption('print-media-type', true)
        //         ->setPaper('a4','landscape')
        //         ->setOption('header-font-name',"THSarabunNew");

        // return $pdf->stream();

        $pdf = \PDF::loadView('ir.reports.irr0081-2.index', compact('dataDebit', 'programCode', 'thaimonths', 'month', 'monthText', 'year', 'program', 'dataCredit', 'accrued'))
            ->setOption('margin-top', '5')
            ->setOption('margin-bottom', '5')
            ->setOption('header-spacing',5.3)
            ->setOption('header-font-size', 13)
            ->setOption('header-right', "\n\n\n\n[page]/[topage]\t\t\t")
            ->setOption('header-font-name', "THSarabunNew")
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', "Landscape")
            ->setPaper('a4');

        return $pdf->stream();
    }

    public function callPackage($request, $year)
    {
        $userId                = auth()->user()->fnd_user_id;
        $policySetHaderIdFrom  = request()->policy_start;
        $policySetHaderIdTo    = request()->policy_end;
        $monthText             = date('M-y', strtotime(date('m-d-Y', strtotime($request->period_name))));
        // dd('callPackage', $request->all(), $monthText, $policySetHaderIdFrom, $policySetHaderIdTo, $year);

        $db = \DB::connection('oracle')->getPdo();
        $sql = "
            declare

                V_WEB_BATCH_NO     VARCHAR2(250) ;  
                V_RETURN_STATUS    VARCHAR2(1) ; 
                V_RETURN_MSG       VARCHAR2(4000) ; 

            begin 
                
                dbms_output.put_line('PTIR_ASSET_BALANCE_RPT.BUILD_DATA ');
                
                PTIR_STOCK_BALANCE_RPT.BUILD_DATA(P_YEAR => '{$year}'
                                                , P_PERIOD_NAME => '{$monthText}'
                                                , P_POLICY_SET_H_FROM_ID =>  '{$policySetHaderIdFrom}'
                                                , P_POLICY_SET_H_TO_ID   => '{$policySetHaderIdTo}' 
                                                , P_USER_ID => '{$userId}' 
                                                
                                                , O_WEB_BATCH_NO  => :v_web_batch_no
                                                , O_RETURN_STATUS => :v_return_status
                                                , O_RETURN_MSG    => :v_return_msg
                );
                                            
                dbms_output.put_line(' V_WEB_BATCH_NO  = '||V_WEB_BATCH_NO );  
                dbms_output.put_line(' V_RETURN_STATUS = '||V_RETURN_STATUS);
                dbms_output.put_line(' V_RETURN_MSG    = '||V_RETURN_MSG);                 
            end;
        ";
        \Log::info(' --- IRR0081-2 --- ');
        \Log::info($sql);
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_web_batch_no', $result['web_batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':v_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info($result);

        return $result;
    }
}

function PeriodThai($strDate)
{
    //dd($strDate);
    $strYear = date("Y", strtotime($strDate)) + 543;
 
    $strMonth = date("n", strtotime($strDate));

    $strDay = date("j", strtotime($strDate));

    // dd($strDay);
    //dd($strYear,$strMonth,$strDay);
    $strMonthCut =  ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $strMonthThai = $strMonthCut[$strDay-1];
    return "$strMonthThai $strYear";
}
