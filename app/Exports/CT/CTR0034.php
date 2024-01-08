<?php

namespace App\Exports\CT;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use App\Models\CT\PtctSummaryCTR0034T;
use App\Models\CT\PtctCTR0034T;
use DB;
use PDO;


class CTR0034 implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
 //WithStyles

{
    public function columnFormats(): array
    {
        if(request()->type_rpt == 'no'){
            return [

                'C' => '#,##0.00',
                'D' => '#,##0.000000',
                'E' => '#,##0.00',
                'F' => '#,##0.000000',
                'G' => '#,##0.000000000',
                'H' => '#,##0.00',
                'I' => '#,##0.00',
                'J' => '#,##0.000000',
                'K' => '#,##0.00',
                'L' => '#,##0.00',
                'M' => '#,##0.00',
                'N' => '#,##0.00',
                'O' => '#,##0.00',
            ];
        } else {
            return [
        
                'D' => '#,##0.000000',
                'E' => '#,##0.000000000',
                'F' => '#,##0.000000',
                'G' => '#,##0.00',
                'H' => '#,##0.000000',
                'I' => '#,##0.000000000',
                'J' => '#,##0.00',
                'K' => '#,##0.00',
                'L' => '#,##0.000000',
                'M' => '#,##0.00',
                'N' => '#,##0.00',
                'O' => '#,##0.00',
            ];
        }
        
    }
    
    public function view(): View
    {
 
         $request = request();
        
        
         $BatchNo = date('d/m/Y H:i:s');
      
               $dateFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
               $dateTo = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
   
               $Sysdate = date('d/m/Y');
               $time = date('H:i');

        
   
               //get format Thai date parameter date----------------------------------
               $strMonthFull=  ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
               $strDateThai =date("j",strtotime($dateFrom )) ;
               $strMonthThai=$strMonthFull[date( date("n",strtotime($dateFrom)))-1];
               $strYearThai =date("Y",strtotime($dateFrom))+543;
               $dateFromTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;
   
               $strDateThai =date("j",strtotime($dateTo )) ;
               $strMonthThai=$strMonthFull[date( date("n",strtotime($dateTo)))-1];
               $strYearThai =date("Y",strtotime($dateTo))+543;
               $dateToTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;
               
               $Batch_no =  date('d/m/Y H:i:s');
              
               $TypeProd = collect(\DB::select("
                SELECT FV.FLEX_VALUE_MEANING   FLEX_VALUE_MEANING
                ,DECODE(FV.FLEX_VALUE_MEANING,'00','ยาเส้น RYO'
                ,'4S',FV.DESCRIPTION
                ,'ใบยา'||FV.DESCRIPTION)        DESCRIPTION
                FROM PTMGR.FND_FLEX_VALUE_SETS  FS
                ,FND_FLEX_VALUES_VL FV
                WHERE FS.FLEX_VALUE_SET_NAME = 'TOAT_PD_LEAF_SPECIES'
                AND FS.FLEX_VALUE_SET_ID = FV.FLEX_VALUE_SET_ID
                AND FV.FLEX_VALUE_MEANING not in ('5E','4S')
                and FV.FLEX_VALUE_MEANING = '{$request->type_leaf}'
                                ")); $TypeProd = $TypeProd[0]->description;
                    
               //------------------------------Month-----------------------------
               if($request->type_rpt == 'no') {
                    $db = DB::connection('oracle')->getPdo();
                    $sql  = "
                                DECLARE
                
                                P_RETURN_ID        varchar2(1000) := NULL;
                                v_debug                 NUMBER :=1;
                                
                                BEGIN
                                dbms_output.put_line('---------------------  S T A R T. -------------------');
                            

                                ptct_report_pkg.CTR0034_sum ( p_date_from       => '{$request->date_from}',             
                                                            p_date_to           => '{$request->date_to}',             
                                                            P_COST_CODE          => '{$request->cost_code}',  
                                                            p_dept_code         => '',              
                                                            p_tobacco           => '{$request->type_leaf}',         
                                                            p_batch             => '{$Batch_no}',
                                                            X_RPT_ID            => :P_RETURN_ID );             

                                
                                dbms_output.put_line('Report ID :'|| :P_RETURN_ID );
                                                            
                                
                                dbms_output.put_line('---------------------  E N D. -------------------');
                                EXCEPTION WHEN others THEN 
                                    dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                                END ;
                            ";
                    \Log::info($sql);
                    $sql = preg_replace("/[\r\n]*/","",$sql);
                    $stmt = $db->prepare($sql);

                    $stmt->bindParam(':P_RETURN_ID', $result['P_RETURN_ID'], PDO::PARAM_STR, 20);
                    $stmt->execute();

                    \Log::info('status', $result);
                    
                        $sumRpt  =  PtctSummaryCTR0034T::selectRaw('
                         nvl(sum(product_qty*cost_qty),0)  product_qty
                        ,nvl(sum(distinct iss_std_qty),0)  iss_std_qty
                        ,nvl(sum(distinct iss_std_cost),0)  iss_std_cost
                        ,nvl(sum(transaction_quantity),0)  transaction_quantity
                        ,nvl(sum(transaction_value),0)   transaction_value
                        ,nvl(sum(absorbtion_amount),0)   absorbtion_amount
                        ')
                        ->where('web_batch_no', $Batch_no)
                        ->get()
                    
                        ;

                        $seasons  =  PtctSummaryCTR0034T::selectRaw('season
                        ,nvl(sum(product_qty*cost_qty),0)  product_qty
                        ,nvl(sum(distinct iss_std_qty),0)  iss_std_qty
                        ,nvl(sum(distinct iss_std_cost),0)  iss_std_cost
                        ,nvl(sum(transaction_quantity),0)  transaction_quantity
                        ,nvl(sum(transaction_value),0)   transaction_value
                        ,nvl(sum(absorbtion_amount),0)   absorbtion_amount
                        ')
                        ->where('web_batch_no', $Batch_no)
                        ->groupBy('season')
                        ->get()
                        ->groupBy('season')
                        ;


                        $datas = PtctSummaryCTR0034T::selectRaw('item_no
                        ,item_desc
                        ,season
                        ,cost_code,cost_desc,dept_code,dept_desc
                        ,nvl(sum(product_qty*cost_qty),0)                      prod_cost
                        ,nvl(max(iss_std_qty),0)                               iss_std_qty
                        ,nvl(max(iss_std_cost),0)                              iss_std_cost
                        ,nvl(sum(transaction_quantity),0)                      transaction_quantity
                        ,nvl(max(transaction_value/transaction_quantity),0)    value_qty
                        ,nvl(sum(transaction_value),0)                         transaction_value
                        ,nvl(sum(absorbtion_amount),0)                         absorbtion_amount
                        ,nvl(sum(iss_std_qty-transaction_quantity),0)          issstdqty_tranqty
                        ,nvl(sum(absorbtion_amount-iss_std_cost),0)            absorb_issstdcost
                        ,nvl(sum(transaction_value-absorbtion_amount),0)       value_absorb
                        ,nvl(sum(transaction_value-iss_std_cost),0)            value_issstdcost
                        ')->where('web_batch_no', $Batch_no)
                        ->groupBy('item_no','item_desc','season','cost_code','cost_desc','dept_code','dept_desc')
                        ->orderBy('item_no')
                        ->get()
                        ;

                       
                        $header = $datas->first();
                    
                return view('ct.Reports.ctr0034.index',compact('datas','seasons','sumRpt','header'
                ,'time','Sysdate','dateFromTH','dateToTH','TypeProd'));   
                       
                
                }else {
                
                    //------------------------------ Day ----------------------------
                        $db = DB::connection('oracle')->getPdo();
                        $sql  = "
                                    DECLARE
                    
                                    P_RETURN_ID        varchar2(1000) := NULL;
                                    v_debug                 NUMBER :=1;
                                    
                                    BEGIN
                                    dbms_output.put_line('---------------------  S T A R T. -------------------');
                                
                                    
                                    ptct_report_pkg.CTR0034 ( p_date_from => '{$request->date_from}', 
                                                                p_date_to => '{$request->date_to}', 
                                                                P_COST_CODE => '{$request->cost_code}',  
                                                                p_dept_code => '',
                                                                p_tobacco => '{$request->type_leaf}',
                                                                X_RPT_ID    => :P_RETURN_ID );   

                                    
                                    dbms_output.put_line('Report ID :'|| :P_RETURN_ID );
                                                                
                                    
                                    dbms_output.put_line('---------------------  E N D. -------------------');
                                    EXCEPTION WHEN others THEN 
                                        dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                                    END ;
                                ";
                        \Log::info($sql);
                        $sql = preg_replace("/[\r\n]*/","",$sql);
                        $stmt = $db->prepare($sql);

                        $stmt->bindParam(':P_RETURN_ID', $result['P_RETURN_ID'], PDO::PARAM_STR, 20);
                        $stmt->execute();

                        \Log::info('status', $result);
                    
                        
                    $headerDatas  =  PtctCTR0034T::selectRaw("cost_code
                    ,cost_desc
                    ,dept_code
                    ,dept_desc
                    ,period_year
                    ,period_name
                    ,batch_no
                    ,substr(batch_no,1,4)   season
                    ,product_item_no
                    ,product_item_desc
                    ,product_qty
                    ,product_uom
                    ,transaction_date
                    ,to_char(transaction_date,'dd-mm-yyyy')  tran_date
                    ,sum(iss_std_qty)  iss_std_qty
                    ,sum(iss_std_cost)  iss_std_cost
                    ,sum(transaction_quantity)   transaction_quantity  
                    ,round(sum(transaction_value/(decode(transaction_quantity,0,1,transaction_quantity))),9)      value_quantity
                    ,sum(transaction_value)    transaction_value 
                    ,sum(absorbtion_amount)  absorbtion_amount
                    ,sum(std_qty_used)   std_qty_used
                    ,sum(std_cost_rate)   std_cost_rate
                    ")
                    ->where('rpt_id',$result['P_RETURN_ID'])
                    ->groupBy('cost_code','cost_desc','dept_code','dept_desc',
                    'period_year','period_name','batch_no','product_item_no','product_item_desc',
                    'product_qty','product_uom','transaction_date')
                    ->orderBy('transaction_date')
                    ->orderBy('batch_no')
                    ->get();
                    


                    $datas  =  PtctCTR0034T::where('rpt_id', $result['P_RETURN_ID'])->orderBy('item_no')->get() ; 
                    $header = $datas->first();

                  
                    $sumRpt  =  PtctCTR0034T::selectRaw('
                    sum(iss_std_qty)  iss_std_qty
                    ,sum(iss_std_cost)  iss_std_cost
                    ,sum(transaction_quantity)   transaction_quantity  
                    ,round(sum(transaction_value/(decode(transaction_quantity,0,1,transaction_quantity))),9)      value_quantity
                    ,sum(transaction_value)    transaction_value 
                    ,sum(absorbtion_amount)  absorbtion_amount
                    ,sum(std_qty_used)   std_qty_used
                    ,sum(std_cost_rate)   std_cost_rate
                    ')
                    ->where('rpt_id',$result['P_RETURN_ID'])
                    ->get()
                
                    ;
                    
 
                    return view('ct.Reports.ctr0034.days',compact('sumRpt','header','headerDatas','datas','time','Sysdate','dateFromTH','dateToTH','TypeProd'));   
            
            
                }

               


    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }



}


