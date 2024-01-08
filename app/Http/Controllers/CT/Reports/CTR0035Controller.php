<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtctCtr0035;

use PDF;
use DB;
use Carbon\Carbon;

class CTR0035Controller extends Controller
{
	public function CTR0035($programCode, $request)
    {
        $userProfile = getDefaultData('/ct/reports');
        $periodName = request()->period_name;
        $period = collect(\DB::select("
            SELECT  PT_PERIODS_V.*, to_char(start_date, 'YYYY', 'nls_calendar=''Thai Buddha'' nls_date_language = Thai') year_thai
            FROM    PT_PERIODS_V
            WHERE   period_name = '$periodName'
        "))->first();

        $fCostCode = $request->f_cost_code;
        $fmCost = collect(\DB::select("
            SELECT description
            from PTCT_COST_CENTER_V
            where cost_code = '$fCostCode'
        "))->first();


        $rptId  = $this->callPkg(request());
        // $rptId      = 8163;
        $getData    = PtctCtr0035::where('rpt_id', $rptId)->orderbyRaw("cost_code, cost_desc, process_seq")->get();
        // $getData    = PtctCtr0035::where('rpt_id', $rptId)->orderbyRaw("cost_code, cost_desc, process_seq")->whereIn('cost_code', [12,13])->get();
        $data       = [];

        $adjProcessSeq = 18;
        $adjDrName = 'บวก งานระหว่างผลิตปลายงวด';
        $adjCrName = 'หัก งานระหว่างผลิตต้นงวด';

        // $groupByDeptCode = $getData->groupBy('dept_code');
        $group1 = $getData->sortBy('cost_code')->groupBy('cost_code');
        foreach ($group1 as $key => $dataGroup1) {
            $data[$key] = [];
            $summaryLine = (object)[];
            $summaryLine->ptd_amount = 0;
            $summaryLine->previous_ptd_amount = 0;
            $summaryLine->month_amount = 0;
            $summaryLine->month_percent = 0;
            $summaryLine->ytd_amount = 0;
            $summaryLine->previous_ytd_amount = 0;
            $summaryLine->sum_amount = 0;
            $summaryLine->sum_percent = 0;

            foreach ($dataGroup1->where('process_seq', '>', $adjProcessSeq)->sortBy('process_seq')->groupBy('process_seq') as $keySeq => $seq) {
                foreach ($seq as $keyLine => $line) {
                    // $line->cost_desc_display = "$line->segment9$line->segment10 $line->segment10_desc";
                    $line->cost_desc_display = "$line->segment9$line->segment10 $line->segment9_desc $line->dept_desc";
                    if ($keySeq > 21) {
                        $line->cost_desc_display = "$line->segment9$line->segment10 $line->segment9_desc";
                    }
                    $getColDisplay = $this->getColDisplay(collect([$line]));
                    $line = collect($line)->merge(collect($getColDisplay));
                    $data[$key][] = $line;
                }
                if ($keySeq == 21) {
                    $line = (object)[];
                    $line->cost_desc_display = "รวมค่าวัตถุดิบ - มาตรฐาน";
                    $line->style = " font-weight: bolder; text-align: center; ";
                    $getColDisplay = $this->getColDisplay($seq);
                    $line = collect($line)->merge(collect($getColDisplay));
                    $data[$key][] = $line;
                    $summaryLine = $this->setSummary($summaryLine, $line);
                }

                if ($keySeq == 24) {
                    $line = (object)[];
                    $line->cost_desc_display = "รวมค่าแรงค่าใช้จ่าย - มาตรฐาน";
                    $line->style = " font-weight: bolder; text-align: center; ";
                    $getColDisplay = $this->getColDisplay($dataGroup1->where('process_seq', '>', 21));
                    $line = collect($line)->merge(collect($getColDisplay));
                    $data[$key][] = $line;
                    $summaryLine = $this->setSummary($summaryLine, $line);
                }
            }
            if(true) {
                $lineAdj = $dataGroup1->where('process_seq', $adjProcessSeq);
                if (count($lineAdj) > 0) {
                    $lineAdj = $lineAdj->first();
                    if ( abs($lineAdj->ptd_net_dr) > 0  || abs($lineAdj->previous_ptd_net_dr) > 0 || abs($lineAdj->ytd_net_dr) > 0 || abs($lineAdj->previous_ytd_net_dr) > 0) {
                        $line = (object)[];
                        $line->cost_desc_display = $adjDrName;
                        // $line->style = " font-weight: bolder; text-align: center; ";
                        $getColDisplay = $this->getColDisplay($dataGroup1->where('process_seq', $adjProcessSeq), 'DR');
                        $line = collect($line)->merge(collect($getColDisplay));
                        $data[$key][] = $line;
                        $summaryLine = $this->setSummary($summaryLine, $line);
                    }

                    if ( abs($lineAdj->ptd_net_cr) > 0  || abs($lineAdj->previous_ptd_net_cr) > 0 || abs($lineAdj->ytd_net_cr) > 0 || abs($lineAdj->previous_ytd_net_cr) > 0) {
                        $line = (object)[];
                        $line->cost_desc_display = $adjCrName;
                        // $line->style = " font-weight: bolder; text-align: center; ";
                        $getColDisplay = $this->getColDisplay($dataGroup1->where('process_seq', $adjProcessSeq), 'CR');
                        $line = collect($line)->merge(collect($getColDisplay));
                        $data[$key][] = $line;
                        $summaryLine = $this->setSummary($summaryLine, $line, $isCr = true);
                    }
                }


                $line = (object)[];
                $line->cost_desc_display = "รวมต้นทุนการผลิต - มาตรฐาน";
                $line->style = " font-weight: bolder; text-align: center; ";
                $getColDisplay = $this->getColDisplay(collect([$summaryLine]));
                $line = collect($line)->merge(collect($getColDisplay));
                $data[$key][] = $line;
            }
        }

        // $getData   = PtctCtr0035::whereIn('rpt_id', [601, 602])->orderbyRaw("cost_code, cost_desc, process_seq")->get();
        // $groupData = $getData->groupBy('cost_code');
        $group2 = $getData->groupBy('dept_code');
        $summary = [];
        foreach ($group2 as $key => $dataGroup2) {
            $summaryLine = (object)[];
            $summaryLine->ptd_amount = 0;
            $summaryLine->previous_ptd_amount = 0;
            $summaryLine->month_amount = 0;
            $summaryLine->month_percent = 0;
            $summaryLine->ytd_amount = 0;
            $summaryLine->previous_ytd_amount = 0;
            $summaryLine->sum_amount = 0;
            $summaryLine->sum_percent = 0;

            foreach ($dataGroup2->where('process_seq', '>',$adjProcessSeq)->sortBy('process_seq')->groupBy('process_seq') as $keySeq => $seq) {
                foreach ($seq->groupBy('segment9') as $keySeg9 => $segment9) {
                    $line = $segment9->first();
                    // $line->cost_desc_display = "$line->segment9 $line->segment9_desc";
                    // $line->cost_desc_display = "$line->segment9$line->segment10 $line->segment10_desc";
                    $line->cost_desc_display = "$line->segment9 $line->segment9_desc";
                    if ($keySeq > 21) {
                        $line->cost_desc_display = "$line->segment9 $line->segment9_desc";
                    }
                    $getColDisplay = $this->getColDisplay($segment9);
                    $line = collect($line)->merge(collect($getColDisplay));
                    $summary[$key][] = $line;
                }
                if ($keySeq == 21) {
                    $line = (object)[];
                    $line->cost_desc_display = "รวมค่าวัตถุดิบ - มาตรฐาน";
                    $line->style = " font-weight: bolder; text-align: center; ";
                    $getColDisplay = $this->getColDisplay($seq);
                    $line = collect($line)->merge(collect($getColDisplay));
                    $summary[$key][] = $line;
                    $summaryLine = $this->setSummary($summaryLine, $line);
                }
                if ($keySeq == 24) {
                    $line = (object)[];
                    $line->cost_desc_display = "รวมค่าแรงค่าใช้จ่าย - มาตรฐาน";
                    $line->style = " font-weight: bolder; text-align: center; ";
                    $getColDisplay = $this->getColDisplay($dataGroup2->where('process_seq', '>', 21));
                    $line = collect($line)->merge(collect($getColDisplay));
                    $summary[$key][] = $line;
                    $summaryLine = $this->setSummary($summaryLine, $line);
                }
            }
            if(true) {
                $lineAdj = $dataGroup2->where('process_seq', $adjProcessSeq);
                if (count($lineAdj) > 0) {
                    $ptdNetDr                   = abs($lineAdj->sum('ptd_net_dr') ?? 0);
                    $previousPtdNetDr           = abs($lineAdj->sum('previous_ptd_net_dr') ?? 0);
                    $ytdNetDr                   = ($lineAdj->sum('ytd_net_dr') ?? 0);
                    $previousYtdNetDr           = ($lineAdj->sum('previous_ytd_net_dr') ?? 0);

                    $ptdNetCr                   = abs($lineAdj->sum('ptd_net_cr') ?? 0);
                    $previousPtdNetCr           = abs($lineAdj->sum('previous_ptd_net_cr') ?? 0);
                    $ytdNetCr                   = ($lineAdj->sum('ytd_net_cr') ?? 0);
                    $previousYtdNetNr           = ($lineAdj->sum('previous_ytd_net_cr') ?? 0);

                    if ( abs($ptdNetDr) > 0  || abs($previousPtdNetDr) > 0 || abs($ytdNetDr) > 0 || abs($previousYtdNetDr) > 0) {
                        $line = (object)[];
                        $line->cost_desc_display = $adjDrName;
                        // $line->style = " font-weight: bolder; text-align: center; ";
                        $getColDisplay = $this->getColDisplay($dataGroup2->where('process_seq', $adjProcessSeq), 'DR');
                        $line = collect($line)->merge(collect($getColDisplay));
                        $summary[$key][] = $line;
                        $summaryLine = $this->setSummary($summaryLine, $line);
                        // $dataGroup2->push($line);
                    }

                    if ( abs($ptdNetCr) > 0  || abs($previousPtdNetCr) > 0 || abs($ytdNetCr) > 0 || abs($previousYtdNetNr) > 0) {
                        $line = (object)[];
                        $line->cost_desc_display = $adjCrName;
                        // $line->style = " font-weight: bolder; text-align: center; ";
                        $getColDisplay = $this->getColDisplay($dataGroup2->where('process_seq', $adjProcessSeq), 'CR');
                        $line = collect($line)->merge(collect($getColDisplay));
                        $summary[$key][] = $line;
                        $summaryLine = $this->setSummary($summaryLine, $line, $isCr = true);
                        // $dataGroup2->push($line);
                    }
                }


                $line = (object)[];
                $line->cost_desc_display = "รวมต้นทุนการผลิต - มาตรฐาน";
                $line->style = " font-weight: bolder; text-align: center; ";
                // $getColDisplay = $this->getColDisplay($dataGroup2);
                $getColDisplay = $this->getColDisplay(collect([$summaryLine]));
                $line = collect($line)->merge(collect($getColDisplay));
                $summary[$key][] = $line;
            }
        }
        if (count($data)) {
            $data = (object)$data;
        }
        if (count($summary)) {
            $summary = (object)$summary;
        }

        $viewName = 'ct.Reports.ctr0035.pdf.index';
        $pdf = \PDF::loadView($viewName, compact('data', 'summary', 'userProfile', 'period'))
            ->setOption('header-html', view('ct.Reports.ctr0035.pdf.header', compact('userProfile', 'period', 'fmCost'))->render())
            ->setOption('margin-top', 25)
            ->setPaper('a4','landscape')
            // ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',11)
            ->setOption('header-spacing',3)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5);
        return $pdf->stream($programCode .'.pdf');
    }

    public function setSummary($summary, $line, $isCr = false)
    {
        if ($isCr) {
            $summary->ptd_amount                    = $summary->ptd_amount - data_get($line, 'ptd_amount', 0);
            $summary->previous_ptd_amount           = $summary->previous_ptd_amount - data_get($line, 'previous_ptd_amount', 0);
            $summary->month_amount                  = $summary->month_amount - data_get($line, 'month_amount', 0);
            $summary->month_percent                 = $summary->month_percent - data_get($line, 'month_percent', 0);
            $summary->ytd_amount                    = $summary->ytd_amount - data_get($line, 'ytd_amount', 0);
            $summary->previous_ytd_amount           = $summary->previous_ytd_amount - data_get($line, 'previous_ytd_amount', 0);
            $summary->sum_amount                    = $summary->sum_amount - data_get($line, 'sum_amount', 0);
            $summary->sum_percent                   = $summary->sum_percent - data_get($line, 'sum_percent', 0);
        } else {
            $summary->ptd_amount                    = $summary->ptd_amount + data_get($line, 'ptd_amount', 0);
            $summary->previous_ptd_amount           = $summary->previous_ptd_amount + data_get($line, 'previous_ptd_amount', 0);
            $summary->month_amount                  = $summary->month_amount + data_get($line, 'month_amount', 0);
            $summary->month_percent                 = $summary->month_percent + data_get($line, 'month_percent', 0);
            $summary->ytd_amount                    = $summary->ytd_amount + data_get($line, 'ytd_amount', 0);
            $summary->previous_ytd_amount           = $summary->previous_ytd_amount + data_get($line, 'previous_ytd_amount', 0);
            $summary->sum_amount                    = $summary->sum_amount + data_get($line, 'sum_amount', 0);
            $summary->sum_percent                   = $summary->sum_percent + data_get($line, 'sum_percent', 0);
        }

        return $summary;
    }

    public function callPkg($request)
    {

        $periodYear     = $request->period_year;
        $periodName     = $request->period_name;
        $fCostCode      = $request->f_cost_code;
        $tCostCode      = $request->t_cost_code;

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "

            declare
                rpt_id number;
            begin
                ptct_report_pkg.CTR0035 ( p_period_year     => '$periodYear',
                                            p_period_name   => '$periodName',
                                            P_f_COST_CODE   => '$fCostCode',
                                            P_t_COST_CODE   => '$tCostCode',
                                            X_RPT_ID        =>  :rpt_id);

                DBMS_OUTPUT.PUT_LINE(rpt_id);
            end;
        ";

        $result = [];
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rpt_id', $result['rpt_id'], \PDO::PARAM_INT);
        $stmt->execute();
        return $result['rpt_id'];
    }

    public function getColDisplay($lines, $showDrCr = false)
    {
        if ($showDrCr) {
            if ($showDrCr == 'DR') {
                $ptdAmount              = abs($lines->sum('ptd_net_dr') ?? 0);
                $previousPtdAmount      = abs($lines->sum('previous_ptd_net_dr') ?? 0);
                $ytdAmount              = ($lines->sum('ytd_net_dr') ?? 0);
                $previousYtdAmount      = ($lines->sum('previous_ytd_net_dr') ?? 0);
            }
            if ($showDrCr == 'CR') {
                $ptdAmount              = abs($lines->sum('ptd_net_cr') ?? 0);
                $previousPtdAmount      = abs($lines->sum('previous_ptd_net_cr') ?? 0);
                $ytdAmount              = ($lines->sum('ytd_net_cr') ?? 0);
                $previousYtdAmount      = ($lines->sum('previous_ytd_net_cr') ?? 0);
            }
        } else {
            $ptdAmount                  = abs($lines->sum('ptd_amount') ?? 0);
            $previousPtdAmount          = abs($lines->sum('previous_ptd_amount') ?? 0);
            $ytdAmount                  = $lines->sum('ytd_amount') ?? 0;
            $previousYtdAmount          = $lines->sum('previous_ytd_amount') ?? 0;
        }

        $monthAmount                = ($ptdAmount) - ($previousPtdAmount);
        $monthPercent               = $ptdAmount == 0 && $previousPtdAmount == 0? 0: ($previousPtdAmount != 0? (($monthAmount) / ($previousPtdAmount)) * 100: 100);
        $sumAmount                  = ($ytdAmount) - ($previousYtdAmount);
        $sumPercent                 = $sumAmount == 0 && ($previousYtdAmount) == 0? 0: ($previousYtdAmount != 0? (($sumAmount) / ($previousYtdAmount)) * 100: 100);
        // $monthPercent               = $previousPtdAmount > 0 ? (($monthAmount) / ($previousPtdAmount)) * 100 : 100;
        // $sumPercent                 = abs($previousYtdAmount) > 0 ? ($sumAmount / abs($previousYtdAmount)) * 100 : 100;

        // แสดงค่าบวกเสมอ
        $ytdAmount                  = abs($ytdAmount);
        $previousYtdAmount          = abs($previousYtdAmount);
        $sumAmount                  = ($ytdAmount) - ($previousYtdAmount);
        $sumPercent                 = ($sumPercent);

        $data['format'] = (object)[
            'ptd_amount'            => $ptdAmount >= 0 ? number_format($ptdAmount, 2)
                                            : "(".number_format(abs($ptdAmount), 2) . ")",
            'previous_ptd_amount'   => $previousPtdAmount >= 0 ? number_format($previousPtdAmount, 2)
                                            : "(".number_format(abs($previousPtdAmount), 2) . ")",
            'month_amount'          => $monthAmount >= 0 ? number_format($monthAmount, 2)
                                            : "(".number_format(abs($monthAmount), 2) . ")",
            'month_percent'         => $monthPercent >= 0 ? number_format($monthPercent, 2)
                                            : "(".number_format(abs($monthPercent), 2) . ")",
            'ytd_amount'            => $ytdAmount >= 0 ? number_format($ytdAmount, 2)
                                            : number_format(abs($ytdAmount), 2),
            'previous_ytd_amount'   => $previousYtdAmount >= 0 ? number_format($previousYtdAmount, 2)
                                            : number_format(abs($previousYtdAmount), 2),
            'sum_amount'            => $sumAmount >= 0 ? number_format($sumAmount, 2)
                                            : "(".number_format(abs($sumAmount), 2) . ")",
            'sum_percent'           => $sumPercent >= 0 ? number_format($sumPercent, 2)
                                            : "(".number_format(abs($sumPercent), 2) . ")",
        ];

        $data['ptd_amount']             = $ptdAmount;
        $data['previous_ptd_amount']    = $previousPtdAmount;
        $data['month_amount']           = $monthAmount;
        $data['month_percent']          = $monthPercent;
        $data['ytd_amount']             = $ytdAmount;
        $data['previous_ytd_amount']    = $previousYtdAmount;
        $data['sum_amount']             = $sumAmount;
        $data['sum_percent']            = $sumPercent;


        return (object)$data;
    }
}
