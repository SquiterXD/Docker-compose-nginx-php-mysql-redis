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
use App\Models\CT\PtctLrmsSumCostProductT;
use App\Models\CT\CostCenterV;
use DB;
use PDO;

class TTCTRP85 implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
 //WithStyles

{
    public function columnFormats(): array
    {
        return [
            'A' => '#,##0.00',
            'B' => '#,##0.00',
            'C' => '#,##0.00', 
            'D' => '#,##0.00',
            'E' => '#,##0.00',
            'F' => '#,##0.00',
            'G' => '#,##0.00',
            'H' => '#,##0.00',
            'I' => '#,##0.00',
            'J' => '#,##0.000000000',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00'
            
        ];
    }
    
    public function view(): View
    {
       

        $request = request();
     

        $BatchNo = date('d/m/Y H:i:s');

        $dateFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
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

         $Sysdate = date('d/m/Y');
         $time = date('H:i');

         $db = DB::connection('oracle')->getPdo();
         $sql  = "
                     DECLARE
                     P_RETURN_STATUS         varchar2(1) := NULL;
                     P_RETURN_MESSAGE        varchar2(1000) := NULL;
                     o_cnt_trans             number ;
                     v_debug                 NUMBER :=1;
                     
                     BEGIN
                     dbms_output.put_line('---------------------  S T A R T. -------------------');
                    
                     PTCT_LRMS_SUM_COST_PRODUCT_RPT.main(
                                            ERRBUF           => :P_RETURN_MESSAGE
                                           ,RETCODE          => :P_RETURN_STATUS
                                           ,o_cnt_trans   => :o_cnt_trans
                                           ,i_type_leaf    => '{$request->type_leaf}'  
                                           ,i_cost_center_from  =>'{$request->cost_center_from}'  
                                           ,i_cost_center_to  =>'{$request->cost_center_to}'  
                                           ,i_year         => '{$request->year}'  
                                           ,i_date_from    => '{$request->date_from }'  
                                           ,i_date_to      => '{$request->date_to}'  
                                           ,i_item_from    => '{$request->item_from }'  
                                           ,i_item_to      => '{$request->item_to }'  
                                           ,i_batch        => '{$BatchNo}'  
                           );
                     
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
         $stmt->bindParam(':o_cnt_trans', $result['o_cnt_trans'], PDO::PARAM_STR, 2000);
         $stmt->execute();
 
         \Log::info('status', $result);
       

        //------------------------------------------------------------------------------------------------------------
        $TypeLeaf =  PtctLrmsSumCostProductT::selectRaw('type_product_th
        ,cost_center
        ,sum(primary_quantity)          sum_primary_quantity_tl
        ,sum(cal_sum_quantity_used)     sum_quantity_used_tl
        ,sum(cal_cost_raw_mate)         sum_cost_raw_mate_tl
        ,sum(cal_wage_cost)             sum_wage_cost_tl
        ,sum(cal_vary_cost)             sum_vary_cost_tl
        ,sum(cal_fixed_cost)            sum_fixed_cost_tl
        ,sum(round(cal_total_cost,2))            sum_total_cost_tl
        ')
        ->where('batch_no',$BatchNo)
        ->groupBy('type_product_th','cost_center')
        ->get()
        ->groupBy('type_product_th');
   
        // SUM Level Report
        $SumRpt =  PtctLrmsSumCostProductT::selectRaw('
        sum(primary_quantity)  sum_qty_rpt
        ,sum(cal_sum_quantity_used) sum_qty_use_rpt
        ,sum(cal_cost_raw_mate)  sum_cost_rawmate_rpt
        ,sum(cal_wage_cost) sum_wagecost_rpt
        ,sum(cal_vary_cost) sum_varycost_rpt
        ,sum(cal_fixed_cost) sum_fixedcost_rpt
        ,sum(round(cal_total_cost,2)) sum_totalcost_rpt
        ')
        ->where('batch_no',$BatchNo)
        ->get(); 
    

        $SumFooter =  PtctLrmsSumCostProductT::selectRaw('type_product_th
        ,cost_center
        ,product_type
        ,sum(primary_quantity)           sum_primary_quantity_ft
        ,sum(cal_sum_quantity_used)     sum_quantity_used_ft
        ,sum(cal_cost_raw_mate)         sum_cost_raw_mate_ft
        ,sum(cal_wage_cost)             sum_wage_cost_ft
        ,sum(cal_vary_cost)             sum_vary_cost_ft
        ,sum(cal_fixed_cost)            sum_fixed_cost_ft
        ,sum(round(cal_total_cost,2))            sum_total_cost_ft
        ')
        ->where('batch_no',$BatchNo)
        ->groupBy('type_product_th','cost_center','product_type')
        ->orderBy('type_product_th','desc')
        ->orderBy('product_type')
        ->get();   

        $ProductType =  PtctLrmsSumCostProductT::selectRaw('
        type_product_th
        ,cost_center
        ,product_type
        ,sum(primary_quantity)           sum_primary_quantity_type
        ,sum(cal_sum_quantity_used)     sum_quantity_used_type
        ,sum(cal_cost_raw_mate)         sum_cost_raw_mate_type
        ,sum(cal_wage_cost)             sum_wage_cost_type
        ,sum(cal_vary_cost)             sum_vary_cost_type
        ,sum(cal_fixed_cost)            sum_fixed_cost_type
        ,sum(round(cal_total_cost,2))            sum_total_cost_type
        ')
        ->where('batch_no',$BatchNo)
        ->groupBy('product_type','type_product_th','cost_center')
        ->orderBy('Product_type')
        ->get(); 
   
        $Lines =  PtctLrmsSumCostProductT::selectRaw('
        product_code
        ,product_name
        ,type_product_th
        ,cost_center
        ,crop_year
        ,product_type
        ,sum(primary_quantity)          sum_primary_quantity_line
        ,sum(cal_sum_quantity_used)     sum_quantity_used_line
        ,sum(cal_cost_raw_mate)         sum_cost_raw_mate_line
        ,sum(cal_wage_cost)             sum_wage_cost_line
        ,sum(cal_vary_cost)             sum_vary_cost_line
        ,sum(cal_fixed_cost)            sum_fixed_cost_line
        ,sum(round(cal_total_cost,2))            sum_total_cost_line
        ,sum(cal_total_cost)/sum(primary_quantity)   sum_total_cost_per_unit_line
        ')
        ->where('batch_no',$BatchNo)
        ->groupBy('product_code','product_name','type_product_th','cost_center','crop_year','product_type')
        ->orderBy('product_type')
        ->orderBy('product_code')
        ->get(); 

        
      
    
        if($result['P_RETURN_STATUS'] == 0) {

            $GetYear =  $Lines->first();
            $crop_year = $GetYear->crop_year;
            $cf = CostCenterV::selectRaw('cost_code,description ' ) -> where('cost_code',$request->cost_center_from)->get();
            $ct = CostCenterV::selectRaw('cost_code,description ' ) -> where('cost_code',$request->cost_center_to)->get();
            $cost_center_from = $cf[0]->cost_code . ' - ' . $cf[0]->description;
            $cost_center_to   = $ct[0]->cost_code . ' - ' . $ct[0]->description;
        
          
            return view('ct.Reports.TTCTRP85.index',compact('TypeLeaf','ProductType','Lines','SumFooter','SumRpt','Sysdate','time'
        ,'dateFromTH','dateToTH','cost_center_from','cost_center_to','crop_year'));

        } else {
            
       
            $crop_year = null;
            $cost_center_from =null;
            $cost_center_to   =null;

            return view('ct.Reports.TTCTRP85.index',compact('TypeLeaf','ProductType','Lines','SumFooter','SumRpt','Sysdate','time'
            ,'dateFromTH','dateToTH','cost_center_from','cost_center_to','crop_year'));
        }
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }



}


