<?php

namespace App\Exports\PD;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\PM\PtpmPDR1130wip02V;
use App\Models\PM\PtpmPDR1130wip03V;
use App\Models\PM\PtpmPDR1130wip04V;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PDR1130 implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
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
            'N' => '#,##0.00',
            'O' => '#,##0.00',
            'P' => '#,##0.00'
            
        ];
    }
    
    public function view(): View
    {

        $request = request();
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
        // ----------------------------------------------------------------------
       

        $DATAsWip02  =  PtpmPDR1130wip02V::selectRaw(' batch_no    
                        ,product_group                 
                        ,product_code                       
                        ,product_description                                 
                        ,sum(product_qty02setup)   product_qty02setup                       
                        ,sum(product_qty02)   product_qty02  
                        ,layout_qty  
                        ')
                ->whereBetween('product_date', [$dateFrom, $dateTo])
                ->groupBy('batch_no','product_code','product_description','product_group','layout_qty')
                ->get();

         // ----------------------------------------------------------------------
        $DATAsWip03  =  PtpmPDR1130wip03V::selectRaw('batch_no
                        ,product_code
                        ,layout_qty
                        ,sum(product_qty03)   product_qty03
                        ,min(product_date) min_date
                        ,max(product_date) max_date
                        ,sum(product_qty03+receive_wip03)   sum_qty03
                        ,sum(loss_qty03)   loss_qty03
                        ,sum(transfer_wip03)   transfer_wip03
                        ')
        ->whereBetween('product_date', [$dateFrom, $dateTo])
        ->groupBy('batch_no','product_code','layout_qty')
        ->get();   
      
         $rec03 =  PtpmPDR1130wip03V::selectRaw('batch_no
                                                ,product_code
                                                ,layout_qty
                                                ,receive_wip03
                                                ,product_date
                                                     ')
                                ->whereBetween('product_date', [$dateFrom, $dateTo])
                                ->groupBy('batch_no'
                                ,'product_code'
                                ,'layout_qty'
                                ,'receive_wip03'
                                ,'product_date')
                                ->get();   

        $tran03 =  PtpmPDR1130wip03V::selectRaw('batch_no
                                ,product_code
                                ,layout_qty
                                ,transfer_wip03
                                ,product_date
                                ')
                                ->whereBetween('product_date', [$dateFrom, $dateTo])
                                ->groupBy('batch_no'
                                ,'product_code'
                                ,'layout_qty'
                                ,'transfer_wip03'
                                ,'product_date')
                                ->get();   
                      

   
      // ----------------------------------------------------------------------
        $DATAsWip04  =  PtpmPDR1130wip04V::selectRaw('batch_no
                        ,product_code
                        ,layout_qty
                        ,sum(product_qty04)   product_qty04
                        ,min(product_date) min_date
                        ,max(product_date) max_date
                        ,sum(transfer_qty04)   transfer_qty04
                        ,sum(transfer_wip04)   transfer_wip04
                        ')
        ->whereBetween('product_date', [$dateFrom, $dateTo])
        ->groupBy('batch_no','product_code','layout_qty')
        ->get();   

        $rec04 =  PtpmPDR1130wip04V::selectRaw('batch_no
                                                ,product_code
                                                ,layout_qty
                                                ,receive_wip04
                                                ,product_date
                                                     ')
                                ->whereBetween('product_date', [$dateFrom, $dateTo])
                                ->groupBy('batch_no'
                                ,'product_code'
                                ,'layout_qty'
                                ,'receive_wip04'
                                ,'product_date')
                                ->get();   

        $tran04 =  PtpmPDR1130wip04V::selectRaw('batch_no
                                ,product_code
                                ,layout_qty
                                ,transfer_wip04
                                ,product_date
                                ')
                                ->whereBetween('product_date', [$dateFrom, $dateTo])
                                ->groupBy('batch_no'
                                ,'product_code'
                                ,'layout_qty'
                                ,'transfer_wip04'
                                ,'product_date')
                                ->get();   
        

          return view('pd.reports.PDR1130.index', compact('DATAsWip02','DATAsWip03'
                                                        ,'DATAsWip04','Sysdate','time'
                                                        ,'dateFromTH','dateToTH',
                                                        'rec03','tran03',
                                                        'rec04','tran04'));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }


}


