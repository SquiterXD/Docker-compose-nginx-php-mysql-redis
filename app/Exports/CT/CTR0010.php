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
use App\Models\CT\PtctCtr0009;
use App\Models\CT\PtctCtr0010WithPkg;
use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

class CTR0010 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        // return [
        //     'B' => '#,##0.000000',
        //     'C' => '#,##0.000000',
        //     'D' => '#,##0.000000',
        //     'E' => '#,##0.000000000',
        //     'F' => '#,##0.00',
        // ];

        $cell = [
            // 'B' => '#,##0.000000',
            'C' => '#,##0.000000',
            'D' => '#,##0.000000',
            'E' => '#,##0.000000000',
            'F' => '#,##0.00',
            'G' => '#,##0.00',
        ];
        $datas = $this->datas;
        if (count($datas)) {
            $fmRow = 0;
            $dataGroupProducts = $datas->sortBy('product_item_number')->groupBy('product_item_number');
            $lastGroupProducts = $dataGroupProducts->last();

            foreach ($dataGroupProducts as $productItemNumber => $groupProducts) {
                $fmRow = $fmRow + 10; // Header

                $countItem = count($groupProducts->pluck('item_number', 'item_number'));
                $countGroupCode = count($groupProducts->pluck('tobacco_group_code', 'tobacco_group_code'));

                $fmRow = $fmRow + $countItem + 1; // 1 row : รวม รหัสผลิตภัณฑ์
                $toRow = $fmRow +  (($countGroupCode > 1) ? $countGroupCode - 1 : 0);
                $cell["D$fmRow:D$toRow"] = "#,##0.00";
                $fmRow = $toRow;
            }
            $fmRow = $fmRow + 1;
            $toRow = $toRow + 100;
            $cell["D$fmRow:D$toRow"] = "#,##0.00";
        }
        return $cell;
    }

    public function callPkg($request)
    {
        $db     =  DB::connection('oracle')->getPdo();
        $dateFrom    = Carbon::createFromFormat('d/m/Y', $request->date_from)->format("d-M-Y");
        $dateTo    = Carbon::createFromFormat('d/m/Y', $request->date_to)->format("d-M-Y");
        $result      = array();
        $sql = "declare
                    X_RPT_ID number;
                begin
                    ptct_report_pkg.CTR0010 (P_YEAR       => '{$request->period_year}'
                                    ,P_COST_CODE => '{$request->cost_code}'
                                    ,P_DATE_FROM => '{$dateFrom}' 
                                    ,P_DATE_TO   => '{$dateTo}'
                                    ,P_ITEM_FROM => '{$request->product_from}'
                                    ,P_ITEM_TO => '{$request->product_to}'
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


    public function pdf($programCode)
    {
        $request            = (object)request()->all();
        $dateFrom           = $request->date_from;
        $dateTo             =  $request->date_to;
        $userProfile = getDefaultData('/ct/reports');
        $cost =  costCenter($request->cost_code);
        $pkg = $this->callPkg($request);
        // dd($pkg);
        // $pkg = 1648;
        $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $datas = PtctCtr0010WithPkg::where('rpt_id', $pkg)
                                ->orderByRaw('product_group asc, product_item_number asc, item_number asc, tobacco_group_code asc' )
                                ->get();

        $pdf = \PDF::loadView('ct.Reports.ctr0010.pdf.index', compact('datas', 'dateFrom', 'dateTo', 'cost' ,'userProfile'))
            ->setPaper('a4','landscape')
            // ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',11)
            ->setOption('header-spacing',3)
            ->setOption('margin-bottom',6);
        return $pdf->stream($programCode .'.pdf');
    }

    public function view(): View
    {
        $request            = (object)request()->all();
        $dateFrom           = $request->date_from;
        $dateTo             =  $request->date_to;
        $userProfile = getDefaultData('/ct/reports');
        $cost =  costCenter($request->cost_code);
        $pkg = $this->callPkg($request);
        // dd($pkg);
        // $pkg = 2137;
        $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $datas = PtctCtr0010WithPkg::where('rpt_id', $pkg)
                                ->orderByRaw('product_group asc, product_item_number asc, item_number asc, tobacco_group_code asc' )
                                ->get();
        $this->datas = $datas;
        // $datas = PtctCtr0010WithPkg::where('rpt_id', 5392)->get();
        // dd($datas);
        // $datas = PtctCtr0009::
        //         // selectCtr009Raw()
        //         whereRaw("trunc(transaction_date) BETWEEN  to_date('".$formDate."', 'YYYY/MM/DD')  AND to_date('". $toDate."', 'YYYY/MM/DD')")
        //         ->when($request->product_from, function($q) use($request) {
        //             $q->where('product_item_number', '>=', $request->product_from);
        //         })
        //         ->when($request->product_to, function($q) use($request) {
        //             $q->where('product_item_number', '<=', $request->product_to);
        //         })
        //         ->where('cost_code', $request->cost_code)
        //         ->where('period_year',  $request->period_year)
        //         ->orderBy('product_item_number')
        //         ->where('transaction_date', '!=', null)
        //         ->get();

        // $datas->map(function ($item, $key) {
        //     $item->total_transaction_quantity = $item->transaction_quantity * $item->inv_cost;
        //     $item->group_by_uom = $item->tobacco_group_code.'-'.$item->detail_uom;
        // }); 


        // // dd( $datas->pluck('sum_transaction_quantity') );
        return view('ct.Reports.ctr0010.excel.index', compact('datas', 'dateFrom', 'dateTo', 'cost' ,'userProfile'));
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
            'A' => 30,
            'B' => 90,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 29,
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
