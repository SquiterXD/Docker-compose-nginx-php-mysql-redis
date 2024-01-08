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
use App\Models\CT\PtctCtr0003;
use App\Exports\CT\CTR0003Detail;

use DB;

use FormatDate;
use Carbon\Carbon;

class CTR0003 implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths
{
    protected $rpt_id;

    public function __construct($rpt_id = null)
    {
        $this->rpt_id = $rpt_id;
    }

    public function excel($programCode)
    {
        $request        = (object)request()->all();
        if ($request->type_report == 'yes') {
            // แยกตามผลิตภัณฑ์
            // แยก detail
            $rpt_id = $this->callPkgProd(request());
            return \Excel::download(new CTR0003Detail($rpt_id), $programCode . '.xlsx');

        } else {
            // แยกตามคำสั่งผลิต
            // $rpt_id = 538;
            $rpt_id = $this->callPkg(request());
            $this->rpt_id = $rpt_id;
            return \Excel::download(new CTR0003($rpt_id), $programCode . '.xlsx');
        }
    }

    public function pdf($programCode)
    {
        $request = (object)request()->all();
        $dateFrom =  $request->date_from;
        $dateTo = $request->date_to;
        $userProfile = getDefaultData('/ct/reports');

        $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $cost =  costCenter($request->cost_code);
        $itemFrom = $request->product_num_from;
        $itemTo = $request->product_num_to;

        if ($request->type_report == 'yes') {
            $rpt_id = $this->callPkgProd(request());

            $datas_level_1 = PtctCtr0003::where('rpt_id', $rpt_id)
                ->where('level_no', 1)
                ->when($itemFrom, function($q) use($itemFrom){
                    return $q->where('item_number', '>=', $itemFrom);
                })
                ->when($itemTo, function($q) use($itemTo){
                    return $q->where('item_number', '<=', $itemTo);
                })
                ->orderByRaw('item_number asc')
                ->get();

            $datas_level_2 = PtctCtr0003::where('rpt_id', $rpt_id)
                ->where('level_no', 2)
                ->orderByRaw('wip_step asc')
                ->get();
            $viewName = 'ct.Reports.ctr0003.pdf.index-by-detail';

        } else {
            // แยกตามคำสั่งผลิต
            $rpt_id = $this->callPkg(request());
            $this->rpt_id = $rpt_id;
            $datas_level_1 = PtctCtr0003::where('rpt_id', $rpt_id)
                ->where('level_no', 1)
                ->when($itemFrom, function($q) use($itemFrom){
                    return $q->where('item_number', '>=', $itemFrom);
                })
                ->when($itemTo, function($q) use($itemTo){
                    return $q->where('item_number', '<=', $itemTo);
                })
                // ->orderByRaw('batch_no asc, wip_step asc')
                ->orderByRaw('item_number asc')
                ->get();

            $datas_level_2 = PtctCtr0003::where('rpt_id', $rpt_id)
                ->where('level_no', 2)
                ->orderByRaw('wip_step asc')
                ->get();

            $viewName = 'ct.Reports.ctr0003.pdf.index-by-batch';
        }

        $pdf = \PDF::loadView($viewName, compact('datas_level_1', 'datas_level_2', 'userProfile', 'dateFrom', 'dateTo', 'cost'))
            ->setPaper('a4','landscape')
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',4)
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 3);
        return $pdf->stream($programCode .'.pdf');
    }

    // แยกตามผลิตภัณฑ์
    public function callPkgProd($request)
    {
        $request        = (object)request()->all();
        $period_year    = $request->period_year;
        $dateFrom       = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('d-M-Y');
        $dateTo         = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('d-M-Y');
        $userProfile    = getDefaultData('/ct/reports');
        $cost_code      = $request->cost_code;
        $cost           = costCenter($request->cost_code);
        $batchFrom      = $request->batch_from;
        $batchTo        = $request->batch_to;

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                xx             NUMBER   :=  NULL;
            BEGIN
                PTCT_REPORT_PKG.CTR0003_PROD(
                    P_YEAR              => '$period_year'
                    ,P_COST_CODE        => '$cost_code'
                    ,P_DATE_FROM        => '$dateFrom'
                    ,P_DATE_TO          => '$dateTo'
                    ,P_DEPARTMENT       => ''
                    ,P_BATCH_NO_FROM    => '$batchFrom'
                    ,P_BATCH_NO_TO      => '$batchTo'
                    ,X_RPT_ID           => :xx
                );
                dbms_output.put_line('xx = '||xx);
            END;
        ";

        $result = [];
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':xx', $result['rpt_id'], \PDO::PARAM_INT);
        $stmt->execute();
        return $result['rpt_id'];
    }

    // แยกตามคำสั่งผลิต
    public function callPkg($request)
    {
        $request        = (object)request()->all();
        $period_year    = $request->period_year;
        $dateFrom       = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('d-M-Y');
        $dateTo         = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('d-M-Y');
        $userProfile    = getDefaultData('/ct/reports');
        $cost_code      = $request->cost_code;
        $cost           = costCenter($request->cost_code);
        $batchFrom      = $request->batch_from;
        $batchTo        = $request->batch_to;

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                xx             NUMBER   :=  NULL;
            BEGIN
                PTCT_REPORT_PKG.CTR0003(
                    P_YEAR              => '$period_year'
                    ,P_COST_CODE        => '$cost_code'
                    ,P_DATE_FROM        => '$dateFrom'
                    ,P_DATE_TO          => '$dateTo'
                    ,P_DEPARTMENT       => ''
                    ,P_BATCH_NO_FROM    => '$batchFrom'
                    ,P_BATCH_NO_TO      => '$batchTo'
                    ,X_RPT_ID           => :xx
                );
                dbms_output.put_line('xx = '||xx);
            END;
        ";

        $result = [];
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':xx', $result['rpt_id'], \PDO::PARAM_INT);
        $stmt->execute();
        return $result['rpt_id'];
    }

    public function columnFormats(): array
    {
        return [
            'E' => '#,##0.000000',
            'F' => '#,##0.000000',
            'D' => '#,##0.000000',
            'G' => '#,##0.000000000',
            'H' => '#,##0.00',
        ];
    }

    public function view(): View
    {
        $rpt_id = $this->rpt_id;
        $request = (object)request()->all();
        $dateFrom =  $request->date_from;
        $dateTo = $request->date_to;
        $userProfile = getDefaultData('/ct/reports');

        $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $cost =  costCenter($request->cost_code);
        $itemFrom = $request->product_num_from;
        $itemTo = $request->product_num_to;

        $datas_level_1 = PtctCtr0003::where('rpt_id', $rpt_id)
        ->where('level_no', 1)
        ->when($itemFrom, function($q) use($itemFrom){
            return $q->where('item_number', '>=', $itemFrom);
        })
        ->when($itemTo, function($q) use($itemTo){
            return $q->where('item_number', '<=', $itemTo);
        })
        ->orderByRaw('batch_no asc, wip_step asc')
        ->get();

        $datas_level_2 = PtctCtr0003::where('rpt_id', $rpt_id)
        ->where('level_no', 2)
        ->orderByRaw('batch_no asc, wip_step asc')
        ->get();

        return view('ct.Reports.ctr0003.excel.index', compact('datas_level_1', 'datas_level_2', 'userProfile', 'dateFrom', 'dateTo', 'cost'));

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
            'A' => 25,
            'B' => 75,
            'C' => 30,
            'D' => 18,
            'E' => 25,
            'F' => 25,
            'G' => 25,
            'H' => 30,
            'I' => 30,
            'J' => 25,
            'K' => 25,
            'L' => 25,
            'M' => 25,
            'N' => 25,
            'O' => 25,
            'P' => 25,
        ];
    }

}

