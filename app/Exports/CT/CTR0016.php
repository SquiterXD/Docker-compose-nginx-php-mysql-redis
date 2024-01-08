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
use App\Models\CT\PtctCTR0016V;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CTR0016 implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
 //WithStyles

{
    public function columnFormats(): array
    {
        return [
            'D' => '#,##0.00',
            'E' => '#,##0.00',
            'F' => '#,##0.00',
            'G' => '#,##0.00',
            'H' => '#,##0.00',
            'I' => '#,##0.00',
            'J' => '#,##0.00',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00'
            
        ];
    }
    
    public function view(): View
    {

         $request = request();
        //dd($request->all() );


       $date1 = \Carbon\Carbon::createFromFormat('d/m/Y', $request->Date_from)->format('Y-m-d');
       $date2 = \Carbon\Carbon::createFromFormat('d/m/Y', $request->Date_to)->format('Y-m-d');
 
    //    $xx = date('Y-m-d', )
       
        $DATAs  =  PtctCTR0016V::selectRaw('   sum(ingredient_amount)  sum_amount
                        ,sum(wage_amount) sum_wage_amount
                        ,sum(vary_amount) sum_vary_amount
                        ,sum(fixed_amount)  sum_fixed_amount
                        ,sum(transaction_quantity)  sum_QTY
                        ,dept_code
                        ,dept_code_desc
                        ,TRANSACTION_UOM
                        ,cost_desc
                        ')
                ->where('period_year',$request->period_year )
                ->where('period_name',$request->period_name )
                ->where('cost_code',$request->cost_code)
                // ->whereRaw("trunc(transaction_date) between TO_DATE('{$accidentStartDate}','YYYY-mm-dd')
                //                                 and nvl(TO_DATE('{$accidentEndDate}','YYYY-mm-dd'), TO_DATE(sysdate,'YYYY-mm-dd'))");
               // ->whereBetween('transaction_date', [$date1, $date2])
                ->groupBy('dept_code','dept_code_desc','TRANSACTION_UOM','cost_desc')
                // ->orderBy('transaction_date')
                ->get();   
             
         
        $DATAsLine  =  PtctCTR0016V::selectRaw(' dept_code              
                    ,item_number         
                    ,item_desc           
                    ,transaction_uom         
                    ,sum(ingredient_amount)    ingredient_amount        
                    ,sum(wage_amount)        wage_amount 
                    ,sum(vary_amount)       vary_amount  
                    ,sum(fixed_amount)     fixed_amount       
                    ,sum(transaction_quantity)   transaction_quantity          
                    ,sum(ingredient_amount+wage_amount+vary_amount+fixed_amount)     sum_cost     
                    ,sum(ct_ing_amount)          ct_ing_amount 
                    ,sum(ct_wage_amount)          ct_wage_amount
                    ,sum(ct_vary_amount)          ct_vary_amount
                    ,sum(ct_fixed_amount)           ct_fixed_amount
                ')
        ->where('period_year',$request->period_year )
        ->where('period_name',$request->period_name )
        ->where('cost_code',$request->cost_code)   
       //  ->whereBetween('transaction_date', [$date1, $date2])
        ->groupBy('item_number','item_desc','transaction_uom','dept_code')
        ->orderBy('item_desc')
        ->get();
        
    
        $ldate = date('d/m/Y');
        $time = date('H:i');
        $v_cost_code = $request->cost_code;
        $DatefromTH = $this->PeriodThai($date1); 
        $DatetoTH = $this->PeriodThai($date2); 
        
        return view('ct.Reports.ctr0016.index', compact('DATAs','DATAsLine','ldate','time','v_cost_code','DatefromTH','DatetoTH'));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }

    function PeriodThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));

        $strMonthCut =  ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        $strMonthThai=$strMonthCut[$strMonth-1];

        return "$strDay $strMonthThai $strYear";
    }

}


