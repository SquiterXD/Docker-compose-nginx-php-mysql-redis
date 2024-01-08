<?php

namespace App\Exports\CT;

use App\Models\CT\PtctCtr0002;
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



use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

class CTR0002ByBatch implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        return [
            'C' => '#,##0.00',
            'D' => '#,##0.00',
            'E' => '#,##0.000000',
            'F' => '#,##0.000000',
            'G' => '#,##0.000000000',
            'H' => '#,##0.000000',
            'I' => '#,##0.00',
            'J' => '#,##0.000000',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00',
            'O' => '#,##0.00',
            'P' => '#,##0.00',
        ];
    }


    public function view(): View
    {
        // initialize variables
        $request   = (object)request()->all();
        $result    = array();
        $pDateFrom = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('d-M-Y');
        $pDateTo   = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('d-M-Y');
        $pYear     = $request->period_year;
        $pYear     = $request->period_year;
        $costCode  = $request->cost_code;

        // Procesed PKG function
        $db     =  DB::connection('oracle')->getPdo();
        $sql = "declare
                    X_RPT_ID number;
                    begin
                        ptct_report_pkg.CTR0002 (P_YEAR  => '{$pYear}'
                                        ,P_COST_CODE => '{$costCode}'
                                        ,P_DATE_FROM => '{$pDateFrom}' 
                                        ,P_DATE_TO   => '{$pDateTo}'
                                        ,P_BATCH_NO  => ''
                                        ,X_RPT_ID    => :X_RPT_ID );
                    commit;
                    end;
                    ";
                
        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();
        // dd($result['x_rpt_id']);
        // End proccessed PKG function

        // Get date from id Callback PKG
        // $datas = PtctCtr0002::where('rpt_id', 1802)
        $datas = PtctCtr0002::where('rpt_id', $result['x_rpt_id'])
        ->when($request->batch_no_from, function ($q) use ($request) {
            $q->where('batch_no', '>=', $request->batch_no_from);
        })
        ->when($request->batch_no_to, function ($q) use ($request) {
            $q->where('batch_no', '<=', $request->batch_no_to);
        })
        ->when($request->product_from, function ($q) use ($request) {
            $q->where('item_number', '>=',  $request->product_from);
        })
        ->when($request->product_to, function ($q) use ($request) {
            $q->where('item_number', '<=',  $request->product_to);
        })
        ->get();
        // End get date from id Callback PKG
        $cost =  costCenter($request->cost_code);
        $transactions = [];
        $userProfile = getDefaultData('/ct/reports');

        $dateFrom           = $request->date_from;
        $dateTo             = $request->date_to;

        return view('ct.Reports.ctr0002.excel.index', compact('datas', 'userProfile', 'dateFrom', 'dateTo', 'cost'));

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
