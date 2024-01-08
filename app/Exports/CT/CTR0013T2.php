<?php

namespace App\Exports\CT;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Arr;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use DB;
use PDO;

use App\Models\CT\PtctCtr0013WebPrtT;
use App\Models\CT\PtctCostCenter;

class CTR0013T2 implements FromView, ShouldAutoSize, WithColumnFormatting
{
    public function columnFormats(): array
    {
        return [
            'D' => '#,##0.000000',
            'E' => '#,##0.00',
            'F' => '#,##0.000000',
            'G' => '#,##0.00',
            'H' => '#,##0.000000',
            'I' => '#,##0.00',
            'J' => '#,##0.000000',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00',
            'O' => '#,##0.00',
            'P' => '#,##0.00'
        ];
    }

    public function view(): View
    {

        $year = Arr::get(request()->all(), 'P_YEAR');
        $P_period_from      = Arr::get(request()->all(),'P_PERIOD_FROM');    
        $P_period_to        = Arr::get(request()->all(),'P_PERIOD_TO');    
        $P_cost_code        = Arr::get(request()->all(),'P_COST_CODE');    
        $P_dept_code        = Arr::get(request()->all(),'P_DEPT_CODE');    
        $P_batch_no_from    = Arr::get(request()->all(),'P_BATCH_NO_FROM');    
        $P_batch_no_to      = Arr::get(request()->all(),'P_BATCH_NO_TO');    
        $P_REPORT_TYPE      = Arr::get(request()->all(),'P_REPORT_TYPE');  
        $webBatchNo         = date("YmdHis");   
     
        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    DECLARE
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    v_debug                 NUMBER :=1;
                    
                    BEGIN
                    dbms_output.put_line('---------------------  S T A R T. -------------------');
                    

                    ptct_ctr0013_web_rpt_pkg.MAIN(  ERRBUF                  =>:P_RETURN_STATUS
                                                    ,P_YEAR                 =>'{$year}'
                                                    ,P_period_from          =>'{$P_period_from}'
                                                    ,P_period_to            =>'{$P_period_to}'
                                                    ,P_cost_code            =>'{$P_cost_code }'
                                                    ,P_dept_code            =>'{$P_dept_code}'
                                                    ,P_batch_no_from        =>'{$P_batch_no_from}'
                                                    ,P_batch_no_to          =>'{$P_batch_no_to}'
                                                    ,P_REPORT_TYPE          =>'{$P_REPORT_TYPE}'
                                                    ,P_WEB_BATCH_NO         =>'{$webBatchNo}'
                               ) ;                            
                    
                    dbms_output.put_line('OUTPUT :'||  :P_RETURN_STATUS 
                                        ||' MSG  :'||  :P_RETURN_MESSAGE  );
                                                
                    
                    dbms_output.put_line('---------------------  E N D. -------------------');
                    EXCEPTION WHEN others THEN 
                        dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                    END ;
                "; 
        // dd($sql);     
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $result['P_RETURN_STATUS'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['P_RETURN_MESSAGE'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info('status', $result);
        
        $nowDateTh = parseToDateTh(now());
        $nowDateTh = \Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
        $yearTh = date("Y",strtotime($year))+543;
         $dataList = PtctCtr0013WebPrtT::where('web_batch_no',$webBatchNo)->get();
         $dataListH = PtctCtr0013WebPrtT::selectRaw("product_item_number,product_item_desc
                                                        ,batch_no,product_unit_of_measure,max(qty) qty,max(ending_qty) ending_qty
                                                        ,max(beginning_qty) beginning_qty
                                                        ,sum(transaction_cost) transaction_cost
                                                        ,sum(cost_wip_end) sumCost_wip_end
                                                        ,sum(cost_wip_begin) cost_wip_begin
                                                        ,sum(wage_cost) wage_cost 
                                                        ,sum(vary_cost) vary_cost 
                                                        ,sum(fixed_cost) fixed_cost 
                                                        ")
                                        ->where('web_batch_no',$webBatchNo)
                                        ->groupBy('product_item_number','product_item_desc','batch_no','product_unit_of_measure')
                                        ->orderBy('product_item_number')
                                        ->get();
        $dataListL = PtctCtr0013WebPrtT::selectRaw("product_item_number,product_item_desc
                                        ,cost_org
                                        ,organization_name
                                        ,batch_no,product_unit_of_measure,max(qty) qty,max(ending_qty) ending_qty
                                        ,max(beginning_qty) beginning_qty
                                        ,sum(transaction_quantity) transaction_quantity
                                        ,sum(transaction_cost) transaction_cost
                                        ,sum(ct_cs_wip_end) ct_cs_wip_end
                                        ,sum(cost_wip_end) Cost_wip_end
                                        ,sum(ct_cs_wip_begin) ct_cs_wip_begin
                                        ,sum(cost_wip_begin) cost_wip_begin
                                        ,sum(wage_cost) wage_cost 
                                        ,sum(vary_cost) vary_cost 
                                        ,sum(fixed_cost) fixed_cost 
                                        ")
                        ->where('web_batch_no',$webBatchNo)
                        ->groupBy('product_item_number','product_item_desc','batch_no','product_unit_of_measure','cost_org','organization_name')
                        ->orderBy('cost_org')
                        ->get();
        $dataListOrg = PtctCtr0013WebPrtT::selectRaw("
                        cost_org
                        ,organization_name
                     
                       
                        ,sum(transaction_quantity) transaction_quantity
                        ,sum(transaction_cost) transaction_cost
                        ,sum(ct_cs_wip_end) ct_cs_wip_end
                        ,sum(cost_wip_end) Cost_wip_end
                        ,sum(ct_cs_wip_begin) ct_cs_wip_begin
                        ,sum(cost_wip_begin) cost_wip_begin
                        ,max(wage_cost) wage_cost 
                        ,max(vary_cost) vary_cost 
                        ,max(fixed_cost) fixed_cost 
                        ")
                        ->where('web_batch_no',$webBatchNo)
                        ->groupBy('cost_org','organization_name')
                        ->orderBy('cost_org')
                        ->get();
        // $dataListOrg = PtctCtr0013WebPrtT::selectRaw("
        //                 cost_org
        //                 ,organization_name
                     
                       
        //                 ,sum(transaction_quantity) transaction_quantity
        //                 ,sum(transaction_cost) transaction_cost
        //                 ,sum(ct_cs_wip_end) ct_cs_wip_end
        //                 ,sum(cost_wip_end) Cost_wip_end
        //                 ,sum(ct_cs_wip_begin) ct_cs_wip_begin
        //                 ,sum(cost_wip_begin) cost_wip_begin
        //                 ,max(wage_cost) wage_cost 
        //                 ,max(vary_cost) vary_cost 
        //                 ,max(fixed_cost) fixed_cost 
        //                 ")
        //                 ->where('web_batch_no',$webBatchNo)
        //                 ->groupBy('cost_org','organization_name')
        //                 ->orderBy('cost_org')
        //                 ->get();
        $dataListSum = PtctCtr0013WebPrtT::selectRaw("
                        
                        sum(transaction_quantity) transaction_quantity
                        ,sum(transaction_cost) transaction_cost
                        ,sum(ct_cs_wip_end) ct_cs_wip_end
                        ,sum(cost_wip_end) Cost_wip_end
                        ,sum(ct_cs_wip_begin) ct_cs_wip_begin
                        ,sum(cost_wip_begin) cost_wip_begin
                        ,max(wage_cost) wage_cost 
                        ,max(vary_cost) vary_cost 
                        ,max(fixed_cost) fixed_cost 
                        ")
                        ->where('web_batch_no',$webBatchNo)

                        ->get();
                     
        // dd($dataList);
        // $dataListHeader = CTM0015RPT::select('code_dis')
        //                                 ->where('web_batch_no',$webBatchNo)
        //                                 ->groupBy('code_dis','cost_code')
        //                                 ->orderByRaw('cost_code')
        //                                 ->get();
        $dept_code  =   PtctCostCenter::selectRaw("dept_code||' '||dept_code_desc dept_code")
                                        ->where('dept_code',$P_dept_code)
                                        ->get();
        $dept_code  =   PtctCostCenter::selectRaw("dept_code||' '||dept_code_desc dept_code")
                                        ->where('dept_code',$P_dept_code)
                                        ->get();
        $dept_code  =@$dept_code[0]->dept_code;
        $P_period_from=date("d/m/y", strtotime(substr($P_period_from,0,10)));
       $P_period_to=date("d/m/y", strtotime(substr($P_period_to,0,10)));
       if(count($dataListH)>0){
        if($P_REPORT_TYPE == 'no'){
            $REPORT_TYPE = 'ตามคำสั่งผลิต';
         
            return  view('ct.reports.ctr0013.excel.index',compact(
                                    'dataList'
                                    ,'nowDateTh'
                                    ,'yearTh'
                                    ,'P_REPORT_TYPE'
                                    ,'REPORT_TYPE'
                                    ,'P_period_from'
                                    ,'P_period_to'
                                    ,'dept_code'
                                    ,'dataListH'
                                    ,'dataListL' 
                                    ,'dataListOrg'  
                                    ,'dataListSum' 
                    ));
        }elseif($P_REPORT_TYPE=='yes'){
            $REPORT_TYPE = 'ตามผลิตภัณฑ์';
         
            return  view('ct.reports.ctr0013.excel.index2',compact(
                                        'dataList'
                                        ,'nowDateTh'
                                        ,'yearTh'
                                        ,'P_REPORT_TYPE'
                                        ,'REPORT_TYPE'
                                        ,'P_period_from'
                                        ,'P_period_to'
                                        ,'dept_code'
                                        ,'dataListH'
                                        ,'dataListL' 
                                        ,'dataListOrg'  
                                        ,'dataListSum' 
                        ));
        }
    }else{
        return view('ct.reports.ctr0013.excel.index3');
    }
 
        
    }
}
