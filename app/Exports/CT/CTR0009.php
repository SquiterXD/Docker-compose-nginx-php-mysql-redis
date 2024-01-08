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
use App\Models\CT\PtctCtr0009WithPkg;
use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

class CTR0009 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        return [
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
        $result      = array();
        // $sql = "declare
        //     X_RPT_ID number;
        //     begin
        //         ptct_report_pkg.CTR0004 (P_YEAR       => '{$pYear}'
        //                         ,P_COST_CODE => '{$costCode}'
        //                         ,P_DATE_FROM => '{$pDateFrom}' 
        //                         ,P_DATE_TO   => '{$pDateTo}'
        //                         ,P_DEPARTMENT => ''
        //                         ,P_BATCH_NO_FROM => '{$batch_from}'
        //                         ,P_BATCH_NO_TO => '{$batch_to}'
        //                         ,P_ITEM_FROM => '{$product_from}'
        //                         ,P_ITEM_TO => '{$product_to}'
        //                         ,X_RPT_ID    => :X_RPT_ID );
        //     commit;             
        //     end;
        //     ";
        $sql = "declare
                    X_RPT_ID number;
                begin
                    ptct_report_pkg.CTR0009 (P_YEAR       => '{$request->period_year}'
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

    public function view(): View
    {
        $request            = (object)request()->all();
        $dateFrom           = $request->date_from;
        $dateTo             = $request->date_to;
        $userProfile = getDefaultData('/ct/reports');
        $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $pkg = $this->callPkg($request);
        $cost =  costCenter($request->cost_code);
        $datas = PtctCtr0009WithPkg::where('rpt_id', $pkg)
                                ->orderByRaw('product_group asc, product_item_number asc, item_number asc, tobacco_group_code asc' )
                                ->get();
        // $datas = PtctCtr0009WithPkg::where('rpt_id', 5373)->get();
        // $datas = PtctCtr0009::
        //     // selectCtr009Raw()
        //     whereRaw("trunc(transaction_date) BETWEEN  to_date('" . $formDate . "', 'YYYY/MM/DD')  AND to_date('" . $toDate . "', 'YYYY/MM/DD')")
        //     // ->whereDate('transaction_date', '>=', date('Y-d-m', strtotime($request->date_from)))
        //     // ->whereDate('transaction_date', '<=',  date('Y-d-m', strtotime($request->date_to)))
        //     ->when($request->product_from, function ($q) use ($request) {
        //         $q->where('product_item_number', '>=', $request->product_from);
        //     })
        //     ->when($request->product_to, function ($q) use ($request) {
        //         $q->where('product_item_number', '<=', $request->product_to);
        //     })
        //     ->where('cost_code', $request->cost_code)
        //     ->where('period_year',  $request->period_year)
        //     ->orderBy('product_item_number')
        //     ->where('transaction_date', '!=', null)
        //     // ->limit(4)
        //     ->get();

        // $datas->map(function ($item, $key) {
        //     $item->total_transaction_quantity = $item->transaction_quantity * $item->inv_cost;
        //     $item->group_by_uom = $item->tobacco_group_code . '-' . $item->detail_uom;
        // });


        // // dd( $datas->pluck('sum_transaction_quantity') );
        return view('ct.Reports.ctr0009.excel.index', compact('datas', 'dateFrom', 'dateTo', 'cost', 'userProfile'));
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
            'B' => 85,
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
