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
use App\Models\CT\PtctLrmsCostProductT;
use DB;
use PDO;

class TTCTRP72 implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
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
   
              

         $db = DB::connection('oracle')->getPdo();
         $sql  = "
                     DECLARE
                     P_RETURN_STATUS         varchar2(1) := NULL;
                     P_RETURN_MESSAGE        varchar2(1000) := NULL;
                     v_debug                 NUMBER :=1;
                     
                     BEGIN
                     dbms_output.put_line('---------------------  S T A R T. -------------------');
                    
                     PTCT_LRMS_COST_PRODUCT_RPT.main(
                                            ERRBUF           => :P_RETURN_MESSAGE
                                           ,RETCODE          => :P_RETURN_STATUS
                                           ,i_type_leaf    => '{$request->type_leaf}'  
                                           ,i_cost_center  => '{$request->cost_center}'  
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
         $stmt->execute();
 
         \Log::info('status', $result);

         
 //------------------------------------------------------------------------------------------------------------
 // SUM Level Report All Organization
            $QueryLevelRpt =  PtctLrmsCostProductT::selectRaw('sum(primary_quantity)  sum_qty_rpt
            ,sum(cal_sum_quantity_used) sum_qty_use_rpt
            ,sum(cal_cost_raw_mate)  sum_cost_rawmate_rpt
            ,sum(cal_wage_cost) sum_wagecost_rpt
            ,sum(cal_vary_cost) sum_varycost_rpt
            ,sum(cal_fixed_cost) sum_fixedcost_rpt
            ,sum(round(cal_total_cost,2))  sum_totalcost_rpt
            ,sum(total_cost_per_unit) sum_costunit_rpt
            ')
            ->where('batch_no',$BatchNo)
            ->get(); 

            $QueryLevelRptByType =  PtctLrmsCostProductT::selectRaw('product_type
            ,type_product_th
            ,sum(primary_quantity)  sum_qty_rpt
            ,sum(cal_sum_quantity_used) sum_qty_use_rpt
            ,sum(cal_cost_raw_mate)  sum_cost_rawmate_rpt
            ,sum(cal_wage_cost) sum_wagecost_rpt
            ,sum(cal_vary_cost) sum_varycost_rpt
            ,sum(cal_fixed_cost) sum_fixedcost_rpt
            ,sum(round(cal_total_cost,2)) sum_totalcost_rpt
            ,sum(total_cost_per_unit) sum_costunit_rpt
            ')
            ->where('batch_no',$BatchNo)
            ->groupBy('product_type','type_product_th')
            ->get(); 


       
 //------------------------------------------------------------------------------------------------------------
 // ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG ORG 
            $QueryLevelOrg =  PtctLrmsCostProductT::selectRaw('organization_code
            ,machine_name
            ,type_product_th
            ,sum(primary_quantity)  sum_qty_org
            ,sum(cal_sum_quantity_used) sum_qty_use_org
            ,sum(cal_cost_raw_mate)  sum_cost_rawmate_org
            ,sum(cal_wage_cost) sum_wagecost_org
            ,sum(cal_vary_cost) sum_varycost_org
            ,sum(cal_fixed_cost) sum_fixedcost_org
            ,sum(round(cal_total_cost,2)) sum_totalcost_org
            ,sum(total_cost_per_unit) sum_costunit_org
            ')
            ->where('batch_no',$BatchNo)
            ->groupBy('organization_code','type_product_th','machine_name')
            ->orderBy('organization_code')
            ->get(); 

            $QueryLevelOrgLeaf =  PtctLrmsCostProductT::selectRaw('organization_code
            ,type_product_th
            ,Product_type
            ,sum(primary_quantity)  sum_qty_org
            ,sum(cal_sum_quantity_used) sum_qty_use_org
            ,sum(cal_cost_raw_mate)  sum_cost_rawmate_org
            ,sum(cal_wage_cost) sum_wagecost_org
            ,sum(cal_vary_cost) sum_varycost_org
            ,sum(cal_fixed_cost) sum_fixedcost_org
            ,sum(round(cal_total_cost,2)) sum_totalcost_org
            ,sum(total_cost_per_unit) sum_costunit_org
            ')
            ->where('batch_no',$BatchNo)
            ->groupBy('organization_code','type_product_th','Product_type')
            ->orderBy('organization_code')
            ->orderBy('Product_type')
            ->get(); 

//------------------------------------------------------------------------------------------------------------  
//Machine Machine Machine Machine Machine Machine Machine Machine Machine Machine Machine Machine Machine Machine 
            $QueryLevelMachine =  PtctLrmsCostProductT::selectRaw('organization_code
            ,machine_line,crop_year
            ,sum(primary_quantity)  sum_qty_Machine
            ,sum(cal_sum_quantity_used) sum_qty_use_Machine
            ,sum(cal_cost_raw_mate)  sum_cost_rawmate_Machine
            ,sum(cal_wage_cost) sum_wagecost_Machine
            ,sum(cal_vary_cost) sum_varycost_Machine
            ,sum(cal_fixed_cost) sum_fixedcost_Machine
            ,sum(round(cal_total_cost,2)) sum_totalcost_Machine
            ,sum(total_cost_per_unit) sum_costunit_Machine
            ')
            ->where('batch_no',$BatchNo)
            ->groupBy('organization_code','machine_line','crop_year')
            ->orderBy('machine_line')
            ->get();   
//------------------------------------------------------------------------------------------------------------  
//ProductType ProductType ProductType ProductType ProductType ProductType ProductType ProductType ProductType 
   
            $QueryLevelProductType =  PtctLrmsCostProductT::selectRaw('organization_code
            ,machine_line
            ,Product_type
            ,sum(primary_quantity)  sum_qty_ProductType
            ,sum(cal_sum_quantity_used) sum_qty_use_ProductType
            ,sum(cal_cost_raw_mate)  sum_cost_rawmate_ProductType
            ,sum(cal_wage_cost) sum_wagecost_ProductType
            ,sum(cal_vary_cost) sum_varycost_ProductType
            ,sum(cal_fixed_cost) sum_fixedcost_ProductType
            ,sum(round(cal_total_cost,2)) sum_totalcost_ProductType
            ,sum(total_cost_per_unit) sum_costunit_ProductType            
            ')
            ->where('batch_no',$BatchNo)
            ->groupBy('organization_code','machine_line','Product_type')
            ->orderBy('Product_type')
            ->get(); 
            
         

//------------------------------------------------------------------------------------------------------------  
//ItemHead ItemHead ItemHead ItemHead ItemHead ItemHead ItemHead ItemHead ItemHead ItemHead ItemHead ItemHead 
            $QueryLevelItemHead =  PtctLrmsCostProductT::selectRaw('product_code
            ,product_name
            ,machine_line
            ,Product_type
            ,organization_code
            ,sum(primary_quantity)  sum_qty_item
            ,sum(cal_sum_quantity_used) sum_qty_use_item
            ,sum(cal_cost_raw_mate)  sum_cost_rawmate_item
            ,sum(cal_wage_cost) sum_wagecost_item
            ,sum(cal_vary_cost) sum_varycost_item
            ,sum(cal_fixed_cost) sum_fixedcost_item
            ,sum(round(cal_total_cost,2)) sum_totalcost_item
            ,sum(total_cost_per_unit) sum_costunit_item
            ')
            ->where('batch_no',$BatchNo)
            ->groupBy('product_code','product_name','machine_line','Product_type','organization_code')
            ->orderBy('product_type')
			->orderBy('machine_line')
			->orderBy('product_code')
            ->get();  
//------------------------------------------------------------------------------------------------------------              
//ItemLine ItemLine ItemLine ItemLine ItemLine ItemLine ItemLine ItemLine ItemLine ItemLine ItemLine ItemLine            
            $QueryLevelItemLine =  PtctLrmsCostProductT::selectRaw('transaction_dateth 
            ,product_code
            ,product_name
            ,machine_line
            ,Product_type
            ,transaction_date
            ,organization_code
            ,sum(primary_quantity)  sum_qty_Line
            ,sum(cal_sum_quantity_used) sum_qty_use_Line
            ,sum(cal_cost_raw_mate)  sum_cost_rawmate_Line
            ,sum(cal_wage_cost) sum_wagecost_Line
            ,sum(cal_vary_cost) sum_varycost_Line
            ,sum(cal_fixed_cost) sum_fixedcost_Line
            ,sum(round(cal_total_cost,2)) sum_totalcost_Line
            ,sum(total_cost_per_unit) sum_costunit_Line
            ')
            ->where('batch_no',$BatchNo)
            ->groupBy('product_code','product_name','machine_line','Product_type','transaction_date','transaction_dateth','organization_code')
            ->orderBy('product_type')
            ->orderBy('machine_line')
            ->orderBy('transaction_date')
            ->orderBy('product_code')
            ->get();  

       


      
               //---------------- For Header Report--------------------
               $QueryHeadRpt =  PtctLrmsCostProductT::selectRaw('type_product_th
               ,cost_center
               ,crop_year'
               )
               ->where('batch_no',$BatchNo)
               ->groupBy('type_product_th','cost_center','crop_year')
               ->get();  
     
           
            if($request->layout == 1) {
   
               
                return view('ct.Reports.TTCTRP72.TTCTRP72_lay1.index',compact('QueryLevelRpt','QueryLevelRptByType'
                                                                                ,'QueryLevelOrg','QueryLevelMachine'
                                                                                ,'QueryLevelItemHead'
                                                                                ,'QueryLevelItemLine'
                                                                                ,'QueryLevelProductType'
                                                                                ,'QueryLevelOrgLeaf'
                                                                                ,'request','QueryHeadRpt'
                                                                                ,'dateFromTH','dateToTH','Sysdate','time'
                                                                            ));
            } else {
       
                return view('ct.Reports.TTCTRP72.TTCTRP72_lay2.index',compact('QueryLevelRpt','QueryLevelRptByType'
                                                                             ,'QueryLevelOrg','QueryLevelMachine'
                                                                             ,'QueryLevelItemHead'
                                                                             ,'QueryLevelItemLine'
                                                                             ,'QueryLevelProductType'
                                                                             ,'QueryLevelOrgLeaf'
                                                                             ,'request','QueryHeadRpt'
                                                                             ,'dateFromTH','dateToTH','Sysdate','time'
                                                                            ));
            }

    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }



}


