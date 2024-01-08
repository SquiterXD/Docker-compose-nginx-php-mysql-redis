<?php

namespace App\Exports\CT;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithProperties;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Models\CT\PtctTtctrp97;
use App\Models\CT\PrctCtr0004;
use App\Models\CT\PtctCtr0008WithPkg;
use App\Models\CT\PtctCtr0009;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;



use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

class CTR0008 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => '#,##0.000000',
            'C' => '#,##0.000000',
            'D' => '#,##0.000000',
            'E' => '#,##0.000000000',
            'F' => '#,##0.00',
        ];
    }
    public function callPkg($request)
    {
        $db     =  DB::connection('oracle')->getPdo();
        $dateFrom    = Carbon::createFromFormat('d/m/Y', $request->date_from)->format("d-M-Y");
        $dateTo    = Carbon::createFromFormat('d/m/Y', $request->date_to)->format("d-M-Y");
        $product_from = $request->product_num_from;
        $product_to = $request->product_num_to;
        $result      = array();
        $sql = "declare
                    X_RPT_ID number;
                begin
                    ptct_report_pkg.CTR0008 (P_YEAR       => '{$request->period_year}'
                                    ,P_COST_CODE => '{$request->cost_code}'
                                    ,P_DATE_FROM => '{$dateFrom}' 
                                    ,P_DATE_TO   => '{$dateTo}'
                                    ,P_ITEM_FROM   => '{$product_from}'
                                    ,P_ITEM_TO   => '{$product_to}'
                                    ,X_RPT_ID    => :X_RPT_ID );
                commit;
                end;
                ";
       
        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();
        set_time_limit(10 * 60);
        return $result['x_rpt_id'];
    }

    public function view(): View
    {
        $request            = (object)request()->all();
        $userProfile = getDefaultData('/ct/reports');
        $cost =  costCenter($request->cost_code);
        $dateFrom = $request->date_from;
        $dateTo =  $request->date_to;
        $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $pkg = $this->callPkg($request);
        $datas = PtctCtr0008WithPkg::where('rpt_id', $pkg)->orderbyRaw("tobacco_group_code, item_number")->get();
        // $datas = PtctCtr0009::where('cost_code', $request->cost_code)
        //             ->where('period_year',  $request->period_year)
        //             ->whereRaw("trunc(transaction_date) BETWEEN  to_date('".$formDate."', 'YYYY/MM/DD')  AND to_date('". $toDate."', 'YYYY/MM/DD')")
        //             ->orderBy('tobacco_group_code')
        //             ->where('transaction_date', '!=', null)
        //             ->when(!empty($request->product_num_from) && !empty($request->product_num_to), function($q)use ($request) {
        //                 $q->whereBetween('product_item_number', [$request->product_num_from, $request->product_num_to]);
        //             })
        //             ->get();
        
        // dd($datas->pluck('product_item_number'), $request);
        // dd($datas);
        // $datas->map(function ($item, $key) {
        //     $item->total_transaction_quantity = $item->transaction_quantity * $item->inv_cost;
        //     $item->group_by_uom = $item->tobacco_group_code . '-' . $item->detail_uom;
        // });

        return view('ct.Reports.ctr0008.excel.index', compact('datas', 'dateFrom', 'dateTo' , 'cost','userProfile'));
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 90,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 25,
            'H' => 30,
            'I' => 30,
            'J' => 30,
            'K' => 25,
            'L' => 25,
            'M' => 25,
            'N' => 25,
            'O' => 25,
            'P' => 25,
        ];
    }
}
