<?php

namespace App\Exports\OM;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;


use App\Models\OM\PtomOMR0073V;

class OMR0073 implements FromView, ShouldAutoSize
 //WithStyles

{
    public function view(): View
    {

        $request = request();
        $periodName = PtomOMR0073V::selectRaw('distinct period_name ,period_num')
                    ->where('budget_year',$request->budget_year)
                    ->where('version',$request->version)
                    ->orderBy('period_num')
                    ->get();           
    
        $dataList = PtomOMR0073V::selectRaw('budget_year,period_name,item_description,quantity,amount')
                                ->where('budget_year',$request->budget_year)
                                ->where('version',$request->version)
                                ->get()
                                ->groupBy('budget_year'); 

        $ldate = date('d/m/Y');
        $time = date('H:i');
        //dd($ldate);

        return view('om.reports.OMR0073.index', compact('periodName','dataList','ldate','time'));
    }


}


