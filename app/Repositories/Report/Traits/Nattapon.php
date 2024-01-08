<?php

namespace App\Repositories\Report\Traits;

use FormatDate;
use Date;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;
use App\Models\CT\PtCtParams;
use App\Models\CT\DailyTransT;
use App\Models\IR\ptir7010;
use App\Models\IR\Settings\PtirCompanies;
use App\Models\OM\ptomCredirNoteV;
use App\Models\OM\ptOmDebitNoteV;
use App\Models\OM\ptOmDebtDomV;
use App\Models\OM\ptOmOmr0083CustV;
use App\Models\OM\ptOmOmr0085rptT;

use App\Models\OM\ptOmOmr00832CustV;
use App\Models\OM\ptOmOmr0084CustV;
use App\Models\OM\Settings\CreditGroup;
use App\Models\OM\ptomOm0084_2v;
use App\Models\OM\ptomOm0047RptV;
use DB;
use PDO;
use App\Models\User;
use App\Exports\OM\OMR0065;
use App\Exports\OM\OMR0065EXCEL;


use App\Http\Controllers\CT\Reports\CTM0015Controller;
use App\Http\Controllers\CT\Reports\CTR0013Controller;
use App\Http\Controllers\IR\Reports\IRR7010Controller;
use App\Http\Controllers\OM\Reports\OMR0060Controller;
use App\Models\OM\Customers;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
trait Nattapon {

    public function CTR01012e($programCode,$request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $genId = collect(DB::select("
                                        select PTCT_PARAMS_T_S.nextval as param_id from dual
                                    "))->first();
        \DB::beginTransaction();
        try {

            $paramsT                         =  new PtCtParams();		
            $paramsT->param_id        		 =	$genId->param_id;                             
            $paramsT->start_date        	 =	Carbon::createFromFormat('d/m/Y H:i:s',$request->start_date)->format('Y-m-d');       
            $paramsT->end_date          	 =	Carbon::createFromFormat('d/m/Y H:i:s',$request->end_date)->format('Y-m-d');
            $paramsT->cc_code           	 =	$request->cc_code;           
            $paramsT->dept_code_from    	 =	$request->dept_code_from;    
            $paramsT->dept_code_to      	 =	$request->dept_code_to;       
            $paramsT->program_code      	 =	$programCode;      
            $paramsT->created_at        	 =	now();        
            $paramsT->updated_at        	 =	$request->updated_at;        
            $paramsT->created_by_id     	 =	$userId;     
            $paramsT->updated_by_id     	 =	$userId;     
            $paramsT->created_by        	 =	$userId;        
            $paramsT->creation_date     	 =	now();     
            $paramsT->last_update_date  	 =	now();  
            $paramsT->last_updated_by   	 =	$userId;   


            $paramsT->save();

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }  
        }

        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    DECLARE
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    v_debug                 NUMBER :=1;
                    
                    BEGIN
                    dbms_output.put_line('---------------------  S T A R T. -------------------');
                    
                    PTCT_BUILD_RPT.MAIN( P_PARAM_ID                 => '{$genId->param_id}'
                                        , P_REPORT_CODE             => '{$programCode}'    
                                        , P_RETURN_STATUS           => :P_RETURN_STATUS  
                                        , P_RETURN_MESSAGE          => :P_RETURN_MESSAGE ) ;
                    
                    dbms_output.put_line('OUTPUT :'|| :P_RETURN_STATUS 
                                        ||' MSG :'||  :P_RETURN_MESSAGE  );
                                                
                    
                    dbms_output.put_line('---------------------  E N D. -------------------');
                    EXCEPTION WHEN others THEN 
                        dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                    END ;
                ";
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $result['P_RETURN_STATUS'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['P_RETURN_MESSAGE'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info('status', $result);

        // dd($result['P_RETURN_MESSAGE']);

        $vbb = $programCode;
        $paramId = $genId->param_id;
        // dd($paramId,$result['P_RETURN_STATUS']);
        $ListData_Hs = DailyTransT::select('cc_code','dept_code')
                        ->where('param_id', $paramId)
                        ->with('PtglCoaDeptCodeV')
                        ->groupBy('dept_code','cc_code')
                        ->get();
    
        $ListData_Ls = DailyTransT::selectRaw(" sum(mmt_qty) as mmt_qty,
                                                sum(mmt_amount) as mmt_amount,
                                                cat_segment1,
                                                dept_code,
                                                nvl(substr(cat_name,0,INSTR(cat_name,'.')-1),cat_name) cat_name")
                                ->where('param_id', $paramId)
                                ->groupByRaw("  cat_segment1,
                                                dept_code,
                                                nvl(substr(cat_name,0,INSTR(cat_name,'.')-1),
                                                cat_name)")
                                ->get();
                                        
        $ListData_Ds = DailyTransT::selectRaw(" cat_segment1,item_no, 
                                                sum(mmt_qty) as mmt_qty,
                                                item_description,
                                                sum(mmt_unit_price) as mmt_unit_price,
                                                sum(mmt_amount) as mmt_amount           ")
                                ->where('param_id', $paramId)
                                ->groupByRaw("item_no,cat_segment1,item_description")
                                ->get();

        $request->cc_code =str_replace(':','',$request->cc_code );
    
        $pdf = PDF::loadView('ct.report.CTR01012.index',
                            compact(
                                'ListData_Hs','request','ListData_Ls','ListData_Ds'
                            ))
                        ->setPaper('a4')
                        ->setOrientation('landscape')
                        ->setOption('margin-bottom', 10)
                        ->setOption('footer-center', 'Page [page] of [toPage]');

            return $pdf->stream($vbb. '.pdf');

    }

    public function CTM0015($programCode,$request)
    {
        return (new CTM0015Controller)->export($programCode, $request);
    }

    public function IRR7010($programCode,$request)
    {
        $user = optional(auth()->user())->username ;
         
        $output = Arr::get($request->all(), 'output');
         $output = 'excel';
        if($output == 'excel'){
            return (new IRR7010Controller)->export($programCode, $request);
        }elseif ($output == 'pdf') {

            $policy_set_header_from = Arr::get(request()->all(), 'policy_set_header_from');
            $policy_set_header_to = Arr::get(request()->all(), 'policy_set_header_to');
            $calculate_date = Arr::get(request()->all(), 'calculate_date');
            $company_from = Arr::get(request()->all(), 'company_from');
            $company_to = Arr::get(request()->all(), 'company_to');
            $location_code_from = Arr::get(request()->all(), 'location_code_from');
            $location_code_to = Arr::get(request()->all(), 'location_code_to');
            $status = Arr::get(request()->all(), 'status');
            $webBatchNo = date("YmdHis");

            $db = DB::connection('oracle')->getPdo();
            $sql  = "
                        DECLARE
                        P_RETURN_STATUS         varchar2(1) := NULL;
                        P_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_debug                 NUMBER :=1;
                        
                        BEGIN
                        dbms_output.put_line('---------------------  S T A R T. -------------------');
                        
                        ptir_irr7010_rpt_pkg.MAIN(  ERRBUF                      => :P_RETURN_STATUS
                                                    ,ERRMSG                     => :P_RETURN_MESSAGE
                                                    ,P_POLICY_from              => '{$policy_set_header_from}' 
                                                    ,P_POLICY_TO                =>  '{$policy_set_header_to}' 
                                                    ,P_calculate_date           =>  '{$calculate_date}' 
                                                    ,P_COMPANIES_CODE_FROM      =>  '{$company_from}' 
                                                    ,P_COMPANIES_CODE_TO        =>  '{$company_to}' 
                                                    ,P_LOCATION_CODE_FROM       =>  '{$location_code_from}' 
                                                    ,P_LOCATION_CODE_TO         =>  '{$location_code_to}' 
                                                    ,P_STATUS                   =>  '{$status}' 
                                                    ,P_WEB_BATCH_NO             =>  '{$webBatchNo}' 
                                                      ) ;

                        dbms_output.put_line('---------------------  E N D. -------------------');
                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";
            \Log::info($sql);
            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':P_RETURN_STATUS', $result['P_RETURN_STATUS'], PDO::PARAM_STR, 20);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['P_RETURN_MESSAGE'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            \Log::info('status', $result);
            
            //dd($result);
            $dataLists = ptir7010::where('web_batch_no',$webBatchNo)->get();
            
            // dd($dataList);
            $firstData = ptir7010::where('web_batch_no',$webBatchNo)->first();

          
            // dd($company,$dataLists,$request);
        
            $startDate=FormatDate::DateThai(substr($calculate_date,0,10));
            $endDate=FormatDate::DateThai(substr($calculate_date,22,10));
           
            // $pdf = app('dompdf.wrapper');
            // $pdf->getDomPDF()->set_option("enable_php", true);
            // $data = ['title' => 'Testing Page Number In Body'];
            // $pdf->loadView('welcomeView', $data);
            // $pdf->getDomPDF()->set_option("enable_php", true);
        
            
        $pdf = \PDF::loadView('ir.reports.irr7010.index',compact('dataLists','firstData','company','startDate','endDate','user'))
        //    ->setOption('header-html',view('ir.reports.IRR7010.header',compact('dataLists','firstData','company','startDate','endDate')))
        ->setPaper('a4')
        ->setOrientation('landscape')
        // ->setOption('margin-bottom', 10)
        ->setOption('header-font-size',8)
        ->setOption('header-spacing',0)
        ->setOption('header-right',"\n\n\n\n\n[page] / [topage]  ")
        ;
        // ->setOption('footer-center', 'Page [page] of [toPage]')

        
        
        $vbb =  $programCode;       
        return $pdf->stream($vbb. '.pdf');
        }
         
    }


    public function CTR0013($programCode,$request)
    {
       
        return (new CTR0013Controller)->export($programCode, $request);
    }

    public function OMR0039($programCode,$request)
    {
        
        $START_DATE = Arr::get(request()->all(), 'START_DATE');
        $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $TEXT = Arr::get(request()->all(), 'TEXT');
        $dataLists = ptomCredirNoteV::query()
        ->selectRaw("cn_number,TO_CHAR(cn_date,'DD/MM/YYYY') cn_date,
        customer_name,
        customer_number,
        dr_account_code,
        cn_amount,
        pick_release_no,
        product_type_code,
        pick_release_amount,
        ref_invoice_number,
        amount_cg_0, 
        amount_l_0,
        amount_cg_2,
        amount_cg_3,
        due_days")
        ->whereRaw("TRUNC(cn_date)  BETWEEN nvl(to_DATE('$START_DATE','DD/MM/YYYY'),cn_date) and nvl(to_DATE('$END_DATE','DD/MM/YYYY'),cn_date) AND cn_type='CN_OTHER'")
        ->whereNotNull('ref_invoice_number')
        ->get();
        $user = optional(auth()->user())->username ;
        $DATE = parseTODateTH(now());
        $time =date("H:i:s");

        $dataListsBOTTOM = ptomCredirNoteV::selectRaw("sum(cn_amount) SUM_AMOUNT,dr_account_code")
                                        ->groupBy('dr_account_code')
                                        ->whereRaw("TRUNC( cn_date) BETWEEN NVL (TO_DATE ('$START_DATE', 'DD/MM/YYYY'), cn_date) AND NVL (TO_DATE ('$END_DATE', 'DD/MM/YYYY'),cn_date)AND cn_type = 'CN_OTHER'")
                                        ->get();
        $START_DATE = parseTODateTH($START_DATE);
        $END_DATE   = parseTODateTH($END_DATE);

        $pdf = \PDF::loadView('om.reports.omr0039.index',compact('dataLists','START_DATE','END_DATE','user','DATE','time','dataListsBOTTOM','TEXT'))
                    ->setPaper('a4')
                    ->setOrientation('landscape');
        return $pdf->stream($programCode. '.pdf');

    }

    public function OMR0038($programCode,$request)
    {   
        $START_DATE = Arr::get(request()->all(), 'START_DATE');
        $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $TEXT = Arr::get(request()->all(), 'TEXT');
        $dataLists = ptOmDebitNoteV::selectRaw("cn_number,TO_CHAR(cn_date,'DD/MM/YYYY') cn_date,customer_name,customer_number,dr_account_code,dn_amount,pick_release_no,product_type_code,pick_release_amount,due_days")->
        whereRaw("cn_date  BETWEEN nvl(to_DATE('$START_DATE','DD/MM/YYYY'),cn_date) and nvl(to_DATE('$END_DATE','DD/MM/YYYY'),cn_date) ")->get();
        $user = optional(auth()->user())->username ;
        $DATE = parseTODateTH(now());
        $time =date("H:i:s");

        $dataListsBOTTOM = ptOmDebitNoteV::selectRaw("sum(dn_amount) SUM_AMOUNT,dr_account_code")
                            ->groupBy('dr_account_code')
                            ->whereRaw("cn_date  BETWEEN nvl(to_DATE('$START_DATE','DD/MM/YYYY'),cn_date) and nvl(to_DATE('$END_DATE','DD/MM/YYYY'),cn_date) ")
                            // ->whereRaw("dr_account_code is not null")
                            ->get();
        $START_DATE =parseTODateTH($START_DATE);
        $END_DATE =parseTODateTH($END_DATE);
        $pdf = \PDF::loadView('om.reports.omr0038.index',compact('dataLists','START_DATE','END_DATE','user','DATE','time','dataListsBOTTOM','TEXT'))
        ->setPaper('a4')
        ->setOrientation('landscape');
        return $pdf->stream($programCode. '.pdf');

    }

    public function OMR0092($programCode,$request)
    {   
        $DATE = Arr::get(request()->all(), 'DATE');
        // $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $TEXT = Arr::get(request()->all(), 'TEXT');
        $dataLists =ptOmDebtDomV::selectRaw("due_days,customer_number,customer_name,to_char(due_date,'DD/MM/YYYY') due_date,nvl(consignment_no,pick_release_no)pick_release_no,consignment_no,debt_amount")
                                ->whereRaw("outstanding_debt <> '0' AND due_date<=to_DATE('$DATE','DD/MM/YYYY')")
                                ->get();
        // $dataLists = ptOmDebitNoteV::selectRaw("cn_number,TO_CHAR(cn_date,'DD/MM/YYYY') cn_date,customer_name,customer_number,dr_account_code,dn_amount,pick_release_no,product_type_code,pick_release_amount,due_days")->
        // whereRaw("cn_date  BETWEEN nvl(to_DATE('$START_DATE','DD/MM/YYYY'),cn_date) and nvl(to_DATE('$END_DATE','DD/MM/YYYY'),cn_date) ")->get();
        $START_DATE =parseTODateTH($DATE);
        $user = optional(auth()->user())->username ;
        $DATE = parseTODateTH(now());
        $time =date("H:i:s");

    
        
        // $END_DATE =parseTODateTH($END_DATE);
        $pdf = \PDF::loadView('om.reports.omr0092.index',compact('dataLists','START_DATE','user','DATE','time','TEXT'))
        ->setPaper('a4')
        ->setOption('margin-top','25')
            ->setOption('margin-bottom','22')
        ->setOrientation('landscape')
        ->setOption('header-html',view('om.reports.omr0092.header-requests',compact('START_DATE','user','DATE','time')))
;
        return $pdf->stream($programCode. '.pdf');

    }

public function OMR0083($programCode,$request)
    {   
        $START_DATE = Arr::get(request()->all(), 'START_DATE');
        $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $TEXT = Arr::get(request()->all(), 'TEXT');
        $openwindow = '<script>';
        $openwindow .= " window.open('/ir/reports/get-param?START_DATE=".$START_DATE."&END_DATE=".$END_DATE."&TEXT=".$TEXT."&program_code=OMR0083&function_name=OMR0083_1&output=pdf'); ";
        $openwindow .= " window.open('/ir/reports/get-param?START_DATE=".$START_DATE."&END_DATE=".$END_DATE."&TEXT=".$TEXT."&program_code=OMR0083&function_name=OMR0083_2&output=pdf'); ";
        // $openwindow .="window.close();";
        $openwindow .= '</script>';
        echo $openwindow;
        
        echo "<script>window.close();</script>";
        exit();
        

    }   
    
    public function OMR0083_1($programCode,$request)
    {   
        $START_DATE = Arr::get(request()->all(), 'START_DATE');
        $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $TEXT = Arr::get(request()->all(), 'TEXT');
        // $webBatchNo = date("YmdHis");

        // $db = DB::connection('oracle')->getPdo();
        // $sql  = "
        //             DECLARE
        //             P_RETURN_STATUS         varchar2(1) := NULL;
        //             P_RETURN_MESSAGE        varchar2(1000) := NULL;
        //             v_debug                 NUMBER :=1;
                    
        //             BEGIN
        //             dbms_output.put_line('---------------------  S T A R T. -------------------');
                    
          

        //             ptom_omr0083_rpt_pkg.MAIN(  ERRBUF                  =>:P_RETURN_STATUS
        //                                         ,P_START_DATE           =>'{$START_DATE}'
        //                                         ,P_END_DATE             =>'{$END_DATE}'
        //                                         ,P_type                 =>'1'
        //                                         ,P_WEB_BATCH_NO         =>'{$webBatchNo}'
        //                                        ) ;
                    
        //             dbms_output.put_line('OUTPUT :'||  :P_RETURN_STATUS 
        //                                 ||' MSG  :'||  :P_RETURN_MESSAGE  );
                                                
                    
        //             dbms_output.put_line('---------------------  E N D. -------------------');
        //             EXCEPTION WHEN others THEN 
        //                 dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
        //             END ;
        //         ";

        // \Log::info($sql);
        // $sql = preg_replace("/[\r\n]*/","",$sql);
        // $stmt = $db->prepare($sql);
      
        // $stmt->bindParam(':P_RETURN_STATUS', $result['P_RETURN_STATUS'], PDO::PARAM_STR, 20);
        // $stmt->bindParam(':P_RETURN_MESSAGE', $result['P_RETURN_MESSAGE'], PDO::PARAM_STR, 2000);
        // $stmt->execute();

        // \Log::info('status', $result);
        // DD($sql);
        $dataLists =ptOmOmr0083CustV::selectRaw("customer_number,customer_name")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY')
                                        
                                        ")
                                        ->groupBy('customer_number','customer_name')
                                        ->orderBy('customer_number')
                                        ->get();

        $dataListLs =ptOmOmr0083CustV::selectRaw("type_num,type,customer_number,to_char(para_date,'DD/MM/YYYY') para_date,inumber,sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY')
                                        
                                        ")
                                        ->groupBy('type_num','type','customer_number','para_date','inumber')
                                        ->orderByRaw("para_date asc, type_num asc")
                                        ->get();

        $debt =ptOmOmr0083CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบกำกับสินค้า'
                                        
                                        ")
                                        ->get();
        $debt =$debt[0]->amount;
        $cre =ptOmOmr0083CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบลดหนี้'
                                        
                                        ")
                                        ->get();
        $cre =$cre[0]->amount;
        $payment =ptOmOmr0083CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบเสร็จรับเงิน'
                                        
                                        ")
                                        ->get();
        $payment =$payment[0]->amount;
        $debit =ptOmOmr0083CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบเพิ่มหนี้'
                                        
                                        ")
                                        ->get();
        $debit =$debit[0]->amount;
        $DebtDomV = ptOmDebtDomV::selectRaw("sum(outstanding_debt) outstanding_debt ,max(pick_release_approve_date) APPROVE_DATE,customer_number")
                                ->whereRaw("pick_release_approve_date < to_DATE('$START_DATE','DD/MM/YYYY')
                                AND credit_group_code = '0'
                                and customer_type_id not in ('30','40')
                                AND product_type_code = '10' 
                                and pick_release_approve_date is not null")
                                ->groupBy('customer_number')
                                ->get();

        $START_DATE =parseTODateTH($START_DATE);
        $user = optional(auth()->user())->username ;
        $DATE = parseTODateTH(now());
        $time =date("H:i:s");
        $END_DATE   =parseTODateTH($END_DATE);
        ini_set('max_execution_time', 300);
        $pdf = \PDF::loadView('om.reports.omr0083.index',compact('dataLists','START_DATE','user','DATE','time','TEXT','DebtDomV','dataListLs','debit','payment','cre','debt'))
        ->setPaper('a4')
        ->setOption('margin-top','35')
            ->setOption('margin-bottom','10')
        ->setOrientation('landscape')
        ->setOption('header-html',view('om.reports.omr0083.header-requests',compact('START_DATE','user','DATE','time','END_DATE')))
;
        return $pdf->stream($programCode. '.pdf');
    }
    public function OMR0083_2($programCode,$request)
    {   
        $START_DATE = Arr::get(request()->all(), 'START_DATE');
        $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $TEXT = Arr::get(request()->all(), 'TEXT');

        $dataLists =ptOmOmr00832CustV::selectRaw("customer_number,customer_name")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY')
                                        ")
                                        ->groupBy('customer_number','customer_name')
                                        ->orderBy('customer_number')
                                        ->get();
  
        $dataListLs =ptOmOmr00832CustV::selectRaw("type_num,type,customer_number,to_char(para_date,'DD/MM/YYYY') para_date,inumber,sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY')")
                                        ->groupBy('type_num','type','customer_number','para_date','inumber')
                                        ->orderByRaw("para_date asc, type_num asc")
                                        ->get();


        $debt =ptOmOmr00832CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบกำกับสินค้า'")
                                        ->get();
        $debt =$debt[0]->amount;
        $cre =ptOmOmr00832CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบลดหนี้'")
                                        ->get();
        $cre =$cre[0]->amount;
        $payment =ptOmOmr00832CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบเสร็จรับเงิน'")
                                        ->get();
        $payment =$payment[0]->amount;
        $debit =ptOmOmr00832CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบเพิ่มหนี้'")
                                        ->get();
        $debit =$debit[0]->amount;
        $DebtDomV = ptOmDebtDomV::selectRaw("sum(outstanding_debt) outstanding_debt ,max(pick_release_approve_date) APPROVE_DATE,customer_number")
                                ->whereRaw("pick_release_approve_date < to_DATE('$START_DATE','DD/MM/YYYY')
                                AND credit_group_code = '0'
                                and customer_type_id ='20'
                                and pick_release_approve_date is not null")
                                ->groupBy('customer_number')
                                ->get();

        $START_DATE =parseTODateTH($START_DATE);
        $user = optional(auth()->user())->username ;
        $DATE = parseTODateTH(now());
        $time =date("H:i:s");
        $END_DATE   =parseTODateTH($END_DATE);

        ini_set('max_execution_time', 300);

        $pdf = \PDF::loadView('om.reports.omr00832.index',compact('dataLists','START_DATE','user','DATE','time','TEXT','DebtDomV','dataListLs','debit','payment','cre','debt'))
        ->setPaper('a4')
        ->setOption('margin-top','40')
            ->setOption('margin-bottom','10')
        ->setOrientation('landscape')
        ->setOption('header-html',view('om.reports.omr00832.header-requests',compact('START_DATE','user','DATE','time','END_DATE')));
        return $pdf->stream($programCode. '.pdf');
    }

    public function OMR0084($programCode,$request)
    {   
        $START_DATE = Arr::get(request()->all(), 'START_DATE');
        $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $TEXT = Arr::get(request()->all(), 'TEXT');

        $dataLists =ptomOm0084_2v::selectRaw("customer_number,customer_name")
                                        ->whereRaw("Para_date <= to_DATE('$END_DATE','DD/MM/YYYY')")
                                        ->groupBy('customer_number','customer_name')
                                        ->orderByRaw('customer_number')
                                        ->get();
        // dd($dataLists);
        $dataListLs =ptOmOmr0084CustV::selectRaw("type,customer_number,to_char(para_date,'DD/MM/YYYY') para_date,inumber,sum(amount) amount,type_num")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY')")
                                        ->groupBy('type','customer_number','para_date','inumber','type_num')
                                        ->orderByRaw("para_date asc, type_num asc")
                                        ->get();


        $debt =ptOmOmr0084CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ยอดขายสโมสร'")
                                        ->get();
        $debt =$debt[0]->amount;

        $cre =ptOmOmr0084CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบลดหนี้'")
                                        ->get();
        $cre =$cre[0]->amount;
        $payment =ptOmOmr0084CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบเสร็จรับเงิน'")
                                        ->get();
        $payment =$payment[0]->amount;
        $debit =ptOmOmr0084CustV::selectRaw("sum(amount) amount")
                                        ->whereRaw("Para_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY') AND type ='ใบเพิ่มหนี้'")
                                        ->get();
        $debit =$debit[0]->amount;
        // $DebtDomV = ptomOm0084_2v::selectRaw("sum(amount) outstanding_debt ,max(para_date ) APPROVE_DATE,customer_number")
        //                         ->whereRaw("para_date  < to_DATE('$START_DATE','DD/MM/YYYY')
        //                         ")
        //                         ->groupBy('customer_number')
        //                         ->get();
        $DebtDomV = ptOmOmr0084CustV::selectRaw("sum(amount) outstanding_debt ,max(para_date ) APPROVE_DATE,customer_number")
                                ->whereRaw("para_date  < to_DATE('$START_DATE','DD/MM/YYYY')
                                ")
                                ->groupBy('customer_number')
                                ->get();
        $recal = ptOmOmr0084CustV::selectRaw("type ,sum(amount) outstanding_debt ,max(para_date ) APPROVE_DATE,customer_number")
                                ->whereRaw("para_date  < to_DATE('$START_DATE','DD/MM/YYYY')
                                ")
                                ->groupBy('customer_number', 'type')
                                ->get();
        $DebtDomV = $DebtDomV->map(function($i) use($recal){
            $type1 = $recal->where('customer_number', $i->customer_number)->where('type', 'ใบลดหนี้')->first();
                            $type2 = $recal->where('customer_number', $i->customer_number)->where('type', 'ยอดขายสโมสร')->first();
                            
                            $type1 = !empty($type1) ? $type1->outstanding_debt : 0;
                            $type2 = !empty($type2) ? $type2->outstanding_debt : 0;
                            $i->outstanding_debt= $type2 - $type1;
            return $i;
        });
        $START_DATE =parseTODateTH($START_DATE);
        $END_DATE   =parseTODateTH($END_DATE);
        $user = optional(auth()->user())->username ;
        $DATE = parseTODateTH(now());
        $time =date("H:i:s");

        // ini_set('max_execution_time', '300'); 
        $pdf = \PDF::loadView('om.reports.omr0084.index',compact('dataLists','START_DATE','user','DATE','time','TEXT','DebtDomV','dataListLs','debit','payment','cre','debt'))
        ->setPaper('a4')
        ->setOption('margin-top','35')
        ->setOption('margin-bottom','10')
        ->setOrientation('landscape')
        ->setOption('header-html',view('om.reports.omr0084.header-requests',compact('START_DATE','user','DATE','time','END_DATE')))
;
        return $pdf->stream($programCode. '.pdf');
    }


    public function OMR0085($programCode,$request)
    {   
        $START_DATE = Arr::get(request()->all(), 'START_DATE');
        $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $GROUP = Arr::get(request()->all(), 'GROUP_CODE');
        $webBatchNo = date("YmdHis");
        // dd($START_DATE,$END_DATE,$GROUP );
            $db = DB::connection('oracle')->getPdo();
            $sql  = "
                        DECLARE
                        P_RETURN_STATUS         varchar2(1) := NULL;
                        P_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_debug                 NUMBER :=1;
                        
                        BEGIN
                        dbms_output.put_line('---------------------  S T A R T. -------------------');
                        
              

                        ptom_omr0085_rpt_pkg.MAIN(  ERRBUF                  =>:P_RETURN_STATUS
                                                    ,P_START_DATE           =>'{$START_DATE}'
                                                    ,P_END_DATE             =>'{$END_DATE}'
                                                    ,P_GROUP_CODE           =>'{$GROUP}'
                                                    ,P_WEB_BATCH_NO         =>'{$webBatchNo}'
                                                   ) ;
                        
                        dbms_output.put_line('OUTPUT :'||  :P_RETURN_STATUS 
                                            ||' MSG  :'||  :P_RETURN_MESSAGE  );
                                                    
                        
                        dbms_output.put_line('---------------------  E N D. -------------------');
                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";

            \Log::info($sql);
            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
          
            $stmt->bindParam(':P_RETURN_STATUS', $result['P_RETURN_STATUS'], PDO::PARAM_STR, 20);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['P_RETURN_MESSAGE'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            \Log::info('status', $result);

        $dataLists =ptOmOmr0085rptT::selectRaw("customer_number,customer_name")
                                        ->whereRaw("web_batch_no = '$webBatchNo'")
                                        ->groupBy('customer_number','customer_name')
                                        ->get();
    //   dd($dataLists);
        $dataListLs =ptOmOmr0085rptT::selectRaw("type,customer_number,to_char(para_date,'DD/MM/YYYY') para_date,inumber,sum(amount) amount")
                                        ->whereRaw("web_batch_no = '$webBatchNo'")
                                        ->orderByRaw("para_date asc, type asc, inumber asc")
                                        ->groupBy('type','customer_number','para_date','inumber')
                                        ->get();

        $debt =ptOmOmr0085rptT::selectRaw("sum(amount) amount")
                                        ->whereRaw("web_batch_no = '$webBatchNo' AND type ='ใบกำกับสินค้า'")
                                        ->get();
        $debt =$debt[0]->amount;
        $cre =ptOmOmr0085rptT::selectRaw("sum(amount) amount")
                                        ->whereRaw("web_batch_no = '$webBatchNo' AND type ='ใบลดหนี้'")
                                        ->get();
        $cre =$cre[0]->amount;
        $payment =ptOmOmr0085rptT::selectRaw("sum(amount) amount")
                                        ->whereRaw("web_batch_no = '$webBatchNo' AND type ='ใบเสร็จรับเงิน'")
                                        ->get();
        $payment =$payment[0]->amount;
        $debit =ptOmOmr0085rptT::selectRaw("sum(amount) amount")
                                        ->whereRaw("web_batch_no = '$webBatchNo' AND type ='ใบเพิ่มหนี้'")
                                        ->get();
        $debit =$debit[0]->amount;
        $DebtDomV = ptOmDebtDomV::selectRaw("sum(debt_amount) outstanding_debt ,max(pick_release_approve_date) APPROVE_DATE,customer_number")
        ->whereRaw("TRUNC(pick_release_approve_date) < to_DATE('$START_DATE','DD/MM/YYYY')
        and pick_release_approve_date is not null
        AND credit_group_code = $GROUP
        ")
        ->groupBy('customer_number')
        ->get();

        $DebtDomV = $DebtDomV->map(function($i) use( $GROUP, $START_DATE) {
            $outstanding_debt =  $depDomV = DebtDomV::where('customer_number', $i->customer_number)->where('credit_group_code', $GROUP)->whereRaw("TRUNC(pick_release_approve_date) < to_date('{$START_DATE}', 'DD/MM/YYYY')")
            ->sum('debt_amount');
            ;
            $sum_payment = $paymentDomV = PaymentDomV::where('ptom_payment_dom_v.credit_group_code', $GROUP)
            ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) < to_date('{$START_DATE}', 'DD/MM/YYYY')")
            ->where("ptom_payment_dom_v.customer_number", $i->customer_number)
            ->join('ptom_debt_dom_v', function ($q) use ($GROUP) {
            $q->on('ptom_debt_dom_v.prepare_order_number', '=', 'ptom_payment_dom_v.prepare_order_number');
            $q->where('ptom_debt_dom_v.credit_group_code', '=', $GROUP);
            })
            ->sum('payment_amount');


            $i->recalculate = $outstanding_debt - $sum_payment;
            return $i;
        })->where('recalculate', '>', 0);
        
        $customerData = Customers::whereIn('customer_number', $DebtDomV->pluck('customer_number'))->get();
        
        $DebtDomV = $DebtDomV->map(function($i) use($customerData){
            $i->customer = $customerData->where('customer_number', $i->customer_number)->first();
            return $i;
        });
        
        $CreditGroup =CreditGroup::where('lookup_code',$GROUP)->get();
        $CreditGroup=$CreditGroup[0]->tag;

        $tdate =  collect(DB::select("
                    select  to_char(to_date('$START_DATE','DD/MM/YYYY')+$CreditGroup,'MM/DD/YYYY') tdate
                    from dual
                "))->first();
                $tdate = $tdate->tdate;

        
       
        $tdate=FormatDate::DateThai(substr($tdate,0,10));
        $START_DATE =parseTODateTH($START_DATE);
        $END_DATE   =parseTODateTH($END_DATE);
        $user = optional(auth()->user())->username ;
        $DATE = parseTODateTH(now());
        $time =date("H:i:s");

  
        $pdf = \PDF::loadView('om.reports.omr0085.index',compact('dataLists','START_DATE','user','DATE','time','DebtDomV','dataListLs','debit','payment','cre','debt'))
        ->setPaper('a4')
        ->setOption('margin-top','45')
            ->setOption('margin-bottom','10')
        ->setOrientation('landscape')
        ->setOption('header-html',view('om.reports.omr0085.header-requests',compact('START_DATE','user','DATE','time','END_DATE','CreditGroup','tdate')))
;
        return $pdf->stream($programCode. '.pdf');
    }

    public function OMR0122($programCode,$request)
    {   
        $Pdate = Arr::get(request()->all(), 'date');
        $BANK = Arr::get(request()->all(), 'BANK');
        $dataLists =  collect(DB::select("
        select payment_number,total_amount_with_vat
        from ptom_payment_headers
        where customer_id = '78'
        AND trunc(payment_date) =to_date('$Pdate','DD/MM/YYYY') 
                "));

        $day =  collect(DB::select("
        select to_char(to_date('03/10/2022','DD/MM/YYYY'),'DAY', 'nls_date_language=thai') DAY
        from dual
                        "))->first();
        $customer =  collect(DB::select("
                    select customer_number||' '||customer_name customer
                    from ptom_customers
                    where customer_id = '78'
                        "))->first();
        $customer=$customer->customer;
        $day=$day->day;                
        $Pdate =parseTODateTH($Pdate);
        $user = optional(auth()->user())->username ;
        $DATE = parseTODateTH(now());
        $time =date("H:i:s");

        $pdf = \PDF:: 
        loadView('om.reports.omr0122.index',compact('dataLists','Pdate','user','DATE','time','customer'))
        ->setPaper('a4')
        ->setOption('margin-top','50')
            ->setOption('margin-bottom','10')
        ->setOrientation('landscape')
        ->setOption('header-html',view('om.reports.omr0122.header-requests',compact('Pdate','user','DATE','time','BANK','day')))
;
        return $pdf->stream($programCode. '.pdf');
    }

    public function OMR0047($programCode,$request)
    {   
        $START_DATE = Arr::get(request()->all(), 'START_DATE');
        $END_DATE = Arr::get(request()->all(), 'END_DATE');
        $TEXT = Arr::get(request()->all(), 'TEXT');

        $dataListCash = ptomOm0047RptV:: selectRaw("trunc(payment_date) payment_date,sum(payment_amount) payment_amount, currency, conversion_rate, payment_number, customer_id")
                                        ->whereRaw("payment_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY')
                                                    AND payment_type_code ='10'")
                                        ->groupByRaw('payment_date, payment_amount, currency, conversion_rate, payment_number, customer_id')
                                        ->get();
                                        
        $dataListCredit = ptomOm0047RptV:: selectRaw("trunc(payment_date) payment_date, sum(payment_amount) payment_amount, currency, conversion_rate, payment_number, customer_id")
                                        ->whereRaw("payment_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY')
                                                    AND payment_type_code ='20'")
                                        ->groupByRaw('payment_date, payment_amount, currency, conversion_rate, payment_number, customer_id')
                                        ->get();
        
        $dataListDate = ptomOm0047RptV::selectRaw("trunc(PTOM_OMR0047_RPT_V.payment_date) payment_date, PTOM_OMR0047_RPT_V.payment_number, c.customer_name, c.customer_id")
                                        ->whereRaw("payment_date between to_DATE('$START_DATE','DD/MM/YYYY') AND to_DATE('$END_DATE','DD/MM/YYYY')")
                                        ->leftJoin('ptom_customers c', 'c.customer_id', 'PTOM_OMR0047_RPT_V.customer_id')
                                        ->groupByRaw("trunc(PTOM_OMR0047_RPT_V.payment_date), PTOM_OMR0047_RPT_V.payment_number,customer_name, c.customer_id")
                                        ->get();
        

        $START_DATE = parseTODateTH($START_DATE);
        $END_DATE   = parseTODateTH($END_DATE);
        $user       = optional(auth()->user())->username ;
        $DATE       = parseTODateTH(now());
        $time       = date("H:i:s");

        // return view('om.reports.omr0047.index',compact('dataListCash','dataListDate','START_DATE','user','DATE','time','TEXT','dataListCredit'));
        $pdf = \PDF::loadView('om.reports.omr0047.index',compact('dataListCash','dataListDate','START_DATE','user','DATE','time','TEXT','dataListCredit'))
                    ->setPaper('a4')
                    ->setOption('margin-top','45')
                        ->setOption('margin-bottom','10')
                    ->setOrientation('landscape')
                    ->setOption('header-html',view('om.reports.omr0047.header-requests',compact('START_DATE','user','DATE','time','END_DATE')))
;
        return $pdf->stream($programCode. '.pdf');
    }

    public function OMR0065($programCode, $request)
    {

            return Excel::download(new OMR0065EXCEL($programCode, $request), $programCode.'.xlsx');

    }

    public function OMR0031($programCode,$request)
    {  
        $Pdate = Arr::get(request()->all(), 'DATE');
        $dataLists1 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity1
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='10'
            AND province_code ='10'
            AND product_type_code ='10'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='10'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists2 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity1
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='10'
            AND province_code <>'10'
            AND product_type_code ='10'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='10'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists3 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity1
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='20'
            AND product_type_code ='10'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='10'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists4 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(consignment_quantity),0),2) quantity1
        ,round(nvl(sum(consignment_amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='30'
            AND product_type_code ='10'
            AND to_char(consignment_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='10'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY')) 
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));
            
        $dataLists5 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(consignment_quantity),0),2) quantity1
        ,round(nvl(sum(consignment_amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='40'
            AND product_type_code ='10'
            AND to_char(consignment_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='10'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY')) 
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));
        

        $dataLists6 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity1
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='60'
            AND product_type_code ='10'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='10'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists7 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity1
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='50'
            AND product_type_code ='10'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='10'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists8 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='10'
            AND province_code ='10'
            AND product_type_code ='20'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='20'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists9 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='10'
            AND province_code <>'10'
            AND product_type_code ='20'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='20'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists10 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='20'
            AND product_type_code ='20'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='20'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists11 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='30'
            AND product_type_code ='20'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='20'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists12 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='40'
            AND product_type_code ='20'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='20'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists13 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='50'
            AND product_type_code ='20'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='20'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));


        $dataLists14 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='60'
            AND product_type_code ='20'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='20'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        order by PEE.screen_number"));

        $dataLists15 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,POSD.order_type_name
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity1
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        ,PEE.screen_number
        from (select * from ptom_so_outstanding_v
            where customer_type_id='80'
            AND product_type_code ='10'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='10'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        ,POSD.order_type_name
        order by PEE.screen_number"));

  
        $dataLists16 =  collect(DB::select("
        select customer_type_id
        ,customer_type_meaning
        ,POSD.order_type_name
        ,PEE.ecom_item_description item_description
        ,round(nvl(sum(approve_quantity),0),2) quantity
        ,round(nvl(sum(amount),0),2) amount
        ,round(nvl(sum(base_vat),0),2) base_vat
        ,round(nvl(sum(tax_amount),0),2) tax_amount
        ,round(nvl(sum(retail_amount),0),2) retail_amount
        from (select * from ptom_so_outstanding_v
            where customer_type_id='80'
            AND product_type_code ='20'
            AND to_char(pick_release_approve_date,'MM/YYYY') = substr('$Pdate',4,7)
            ) POSD
        ,ptom_sequence_ecoms PEE
        where 1=1
        AND PEE.product_type_code ='20'
        AND PEE.item_id = POSD.item_id(+)
        AND PEE.sale_type_code = 'DOMESTIC'
        AND PEE.screen_number <> '0'
        AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
        group by customer_type_id
        ,customer_type_meaning
        ,PEE.screen_number
        ,PEE.ecom_item_description
        ,POSD.order_type_name
        order by PEE.screen_number"));

        $dataLists17 =  collect(DB::select("
                select PEE.screen_number
                ,null customer_type_id
                ,null customer_type_meaning
                ,null order_type_name
                ,PEE.report_item_display item_description
                ,round(0,2) quantity1
                ,round(0,2) amount
                ,round(0,2) base_vat
                ,round(0,2) tax_amount
                ,round(0,2) retail_amount
                from ptom_sequence_ecoms PEE
                where 1=1
                AND PEE.product_type_code ='10'
                --AND PEE.item_id(+) = POSD.item_id
                AND PEE.sale_type_code = 'DOMESTIC'
                AND PEE.screen_number <> '0'
                AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
                order by PEE.screen_number"));

                $dataLists18 =  collect(DB::select("
                select PEE.screen_number
                ,null customer_type_id
                ,null customer_type_meaning
                ,null order_type_name
                ,PEE.report_item_display item_description
                ,round(0,2) quantity1
                ,round(0,2) amount
                ,round(0,2) base_vat
                ,round(0,2) tax_amount
                ,round(0,2) retail_amount
                from ptom_sequence_ecoms PEE
                where 1=1
                AND PEE.product_type_code ='20'
                --AND PEE.item_id(+) = POSD.item_id
                AND PEE.sale_type_code = 'DOMESTIC'
                AND PEE.screen_number <> '0'
                AND to_date(substr('$Pdate',4,7),'MM/YYYY') between PEE.start_date AND nvl(PEE.end_date,to_date(substr('$Pdate',4,7),'MM/YYYY'))
                order by PEE.screen_number"));
      
        $user = optional(auth()->user())->username ;
        $cloneDate = Carbon::createFromFormat('d/m/Y H:i:s', $Pdate);
        $getRMA = (new OMR0060Controller)->getRMA(['start'=> $cloneDate->clone()->startOfMonth()->format('Y-m-d'), 'end' => $cloneDate->clone()->endOfMonth()->format('Y-m-d')]);
        $time =date("H:i:s");
        // $Pdate =parseTODateTH($Pdate);
        $DATE = parseTODateTH(now());
        // dd($dataLists15->groupBy('order_type_name'));
        //  dd($Pdate,substr($Pdate,3,2),FormatDate::dateFormatThaiString(10));
        $Monthonly=FormatDate::dateFormatThaiString(substr($Pdate,3,2));
        $Year = substr($Pdate,6,4)+543;
        $pYear=substr($Pdate,3,2);
        if($pYear=='10'OR $pYear=='11' OR $pYear=='12'){
            $Year+=1;  
        }
$pdf = \PDF::loadView('om.reports.omr0031.index',compact('dataLists1'
                                                        ,'dataLists2'
                                                        ,'dataLists3'
                                                        ,'dataLists4'
                                                        ,'dataLists5'
                                                        ,'dataLists6'
                                                        ,'dataLists7'
                                                        ,'dataLists8'
                                                        ,'dataLists9'
                                                        ,'dataLists10'
                                                        ,'dataLists11'
                                                        ,'dataLists12'
                                                        ,'dataLists13'
                                                        ,'dataLists14'
                                                        ,'dataLists15'
                                                        ,'dataLists16'
                                                        ,'dataLists17'
                                                        ,'dataLists18'
                                                        ,'getRMA'
                                                        ,'Year'))
        ->setPaper('a4')
        ->setOption('margin-top','28')
        ->setOption('margin-bottom','10')
        ->setOrientation('landscape')
        ->setOption('header-html',view('om.reports.omr0031.header-requests',compact('DATE','user','time','Monthonly','Year')))
;
        return $pdf->stream($programCode. '.pdf');
    }
}
