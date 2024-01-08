<?php

namespace App\Exports\CT;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Arr;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use App\Models\CT\PtctCtr0013V;

use Carbon\Carbon;
use DB;
use PDO;

use App\Models\CT\PtctCtr0013WebPrtT;
use App\Models\CT\PtctCostCenter;

class CTR0013ByBatch implements FromView, ShouldAutoSize, WithColumnFormatting
{
    public function columnFormats(): array
    {
        return [
            'E' => '#,##0.000000',
            'F' => '#,##0.00',
            'G' => '#,##0.000000',
            'H' => '#,##0.00',
            'I' => '#,##0.000000',
            'J' => '#,##0.00',
            'K' => '#,##0.000000;\(#,##0.000000\);"0.000000";_(@_)',
            'L' => '#,##0.00;\(#,##0.00\);"0.00";_(@_)',
            'M' => '#,##0.00',
            'N' => '#,##0.00',
            'O' => '#,##0.00',
            'P' => '#,##0.00',
        ];
    }

    public function view(): View
    {

        $year = Arr::get(request()->all(), 'P_YEAR');
        $P_period_from      = Arr::get(request()->all(),'P_PERIOD_FROM');
        $P_period_to        = Arr::get(request()->all(),'P_PERIOD_TO');
        $P_cost_code        = Arr::get(request()->all(),'P_COST_CODE');
        $P_dept_code        = Arr::get(request()->all(),'P_DEPT_CODE');
        $P_batch_no_from    = Arr::get(request()->all(),'P_BATCH_NO_FROM');
        $P_batch_no_to      = Arr::get(request()->all(),'P_BATCH_NO_TO');
        $P_REPORT_TYPE      = Arr::get(request()->all(),'P_REPORT_TYPE');

        $db = DB::connection('oracle')->getPdo();
        $periodFrom         = Carbon::parse($P_period_from)->format("M-y");
        $periodTo           = Carbon::parse($P_period_to)->format("M-y");
        $sql  = "
            declare
                rpt_id number;
            begin
                ptct_report_pkg.CTR0013 (P_YEAR         => '$year'
                                ,P_COST_CODE            => '$P_cost_code'
                                ,P_PERIOD_FROM          => '$P_period_from'
                                ,P_PERIOD_TO            => '$P_period_to'
                                ,p_dept_code            =>  '$P_dept_code'
                                ,P_BATCH_NO_FROM        => '$P_batch_no_from'
                                ,P_BATCH_NO_TO          => '$P_batch_no_to'
                                ,X_RPT_ID               => :rpt_id );
                DBMS_OUTPUT.PUT_LINE(rpt_id);
            end;
        ";
        # $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rpt_id', $result['rpt_id'], PDO::PARAM_STR, 20);
        $stmt->execute();

        $nowDateTh          = \Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
        $transaction_date_from = Carbon::createFromFormat('M-y', $P_period_from)->locale('th_TH')->addYears('543');
        $transaction_date_to = Carbon::createFromFormat('M-y', $P_period_to)->locale('th_TH')->addYears('543');
        $periodFromTh = "1/" . $transaction_date_from->format('m') . '/' . $transaction_date_from->format('Y');
        $periodToTh = $transaction_date_to->endOfMonth()->format('d') . "/" . $transaction_date_to->format('m') . '/' . $transaction_date_to->format('Y');
        $yearTh             = date("Y",strtotime($year))+543;
        $datas = PtctCtr0013V::where('rpt_id', $result['rpt_id'])->orderByRaw("item_number, batch_no, organization_code")->get();

        $dept_code  =   PtctCostCenter::selectRaw("dept_code||' '||dept_code_desc dept_code")
                                        ->where('dept_code',$P_dept_code)
                                        ->get();
        $dept_code  =@$dept_code[0]->dept_code;
        $P_period_from=date("d/m/y", strtotime(substr($P_period_from,0,10)));
        $P_period_to=date("d/m/y", strtotime(substr($P_period_to,0,10)));
        $REPORT_TYPE = 'ตามคำสั่งผลิต';

        if (count($datas) == 0) {
            return view('ct.Reports.ctr0013.excel.index3');
        }

        return  view('ct.Reports.ctr0013.excel.batch.index',compact(
                                    'datas'
                                    ,'nowDateTh'
                                    ,'P_REPORT_TYPE'
                                    ,'REPORT_TYPE'
                                    ,'periodFromTh'
                                    ,'periodToTh'
                    ));
    }
}
