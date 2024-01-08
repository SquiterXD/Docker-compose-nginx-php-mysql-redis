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
use App\Models\CT\PtctCtr0004;
use App\Models\CT\PtctCtr0004WithPkg;
use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use PDO;

class CTR0004 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        return [
            'B' => '#,##0.000000',
            'C' => '#,##0.00',
            'D' => '#,##0.00',
            'E' => '#,##0.00',
            'F' => '#,##0.00',
            'G' => '#,##0.00',
            'H' => '#,##0.00',
            
            // 'D8' => '#,##0.000000000',
            // 'E8' => '#,##0.000000000',
            // 'F8' => '#,##0.000000000',
        ];
    }
    public function callPkg($pYear, $costCode, $pDateFrom, $pDateTo, $batch_from, $batch_to, $product_from, $product_to) {
        if ($pDateFrom) {
            $pDateFrom = Carbon::createFromFormat('d-M-Y', $pDateFrom)->format('Y-m-d');
        }
        if ($pDateTo) {
            $pDateTo = Carbon::createFromFormat('d-M-Y', $pDateTo)->format('Y-m-d');
        }

        $condition = '1=1 ';
        if ($pYear) {
            $condition .= " and period_year = '$pYear'";
        }

        if ($costCode) {
            $condition .= " and cost_code = '$costCode'";
        }

        if ($pDateFrom && !$pDateTo) {
            $condition .= " and TRUNC(transaction_date) >= to_date('$pDateFrom', 'YYYY-MM-DD')";
        } else if(!$pDateFrom && $pDateTo) {
            $condition .= " and TRUNC(transaction_date) <= to_date('$pDateTo'";
        } else if($pDateFrom && $pDateTo) {
            $condition .= " and TRUNC(transaction_date) >= to_date('$pDateFrom', 'YYYY-MM-DD') and  TRUNC(transaction_date) <= to_date('$pDateTo', 'YYYY-MM-DD')";
        }

        if ($batch_from && !$batch_to) {
            $condition .= " and batch_no >= '$batch_from'";
        } else if(!$batch_from && $batch_to) {
            $condition .= " and batch_no <= '$batch_to'";
        } else if($batch_from && $batch_to) {
            $condition .= " and batch_no >= '$batch_from' and  batch_no <= '$batch_to'";
        }

        if ($product_from && !$product_to) {
            $condition .= " and item_number >= '$product_from'";
        } else if(!$product_from && $product_to) {
            $condition .= " and item_number <= '$product_to'";
        } else if($product_from && $product_to) {
            $condition .= " and item_number >= '$product_from' and  item_number <= '$product_to'";
        }

        $findData = PtctCtr0004WithPkg::selectRaw("max(rpt_id) rpt_id")->whereRaw($condition)->first();

        return optional($findData)->rpt_id ?? -1;
        $db     =  DB::connection('oracle')->getPdo();
        $result      = array();
        // set_time_limit(15 * 60);
        set_time_limit(0);
        $sql = "declare
            X_RPT_ID number;
            begin
                ptct_report_pkg.CTR0004 (P_YEAR       => '{$pYear}'
                                ,P_COST_CODE => '{$costCode}'
                                ,P_DATE_FROM => '{$pDateFrom}' 
                                ,P_DATE_TO   => '{$pDateTo}'
                                ,P_DEPARTMENT => ''
                                ,P_BATCH_NO_FROM => '{$batch_from}'
                                ,P_BATCH_NO_TO => '{$batch_to}'
                                ,P_ITEM_FROM => '{$product_from}'
                                ,P_ITEM_TO => '{$product_to}'
                                ,X_RPT_ID    => :X_RPT_ID );
            commit;             
            end;
            ";
        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':X_RPT_ID', $result['x_rpt_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $result['x_rpt_id'];
    }
    public function pdf($programcode) {
        $request     = (object)request()->all();
        $dateFrom    = $request->date_from;
        $dateTo      = $request->date_to;
        $userProfile = getDefaultData('/ct/reports');
        $formDate    = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate      = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $pDateFrom   = Carbon::createFromFormat('d/m/Y', $request->date_from)->startOfMonth()->format('d-M-Y');
        $pDateTo     = Carbon::createFromFormat('d/m/Y', $request->date_to)->endOfMonth()->format('d-M-Y');
        $cost        = costCenter($request->cost_code);
        $pYear       = $request->period_year;
        $pYear       = $request->period_year;
        $costCode    = $request->cost_code;
        $product_from = $request->product_from;
        $product_to = $request->product_to;
        $batch_from = $request->batch_from;
        $batch_to = $request->batch_to;

        // Procesed PKG function
        $result = $this->callPkg($pYear, $costCode, $pDateFrom, $pDateTo, $batch_from, $batch_to, $product_from, $product_to);
        $getBatchNo = PtctCtr0004WithPkg::selectRaw('distinct batch_no')
                                ->search($batch_from, $batch_to, $product_from, $product_to)
                                ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
                                ->where('rpt_id', $result)
                                ->get();
        $batch = $getBatchNo->pluck('batch_no')->toArray();
        // data
        $datas = PtctCtr0004WithPkg::where('rpt_id', $result)
                                ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
                                ->whereIn('batch_no', $batch)
                                ->get();

        $wipList = \DB::connection('oracle')
                    ->table('PTCT_WIP_PROCESS_V')
                    ->where('cost_code', $costCode)
                    ->orderBy('routingstep_no')
                    ->get();

        $pdf = \PDF::loadView('ct.Reports.ctr0004.pdf.index-by-batch-new', compact('datas', 'userProfile', 'dateFrom', 'dateTo', 'wipList'))
        ->setPaper('a4','landscape')
        // ->setOption('page-width', '35.5cm')
        // ->setOption('page-height', '28cm')
        ->setOption('header-right',"\n\n\n[page]/[topage] ")
        ->setOption('header-font-name',"THSarabunNew")
        ->setOption('header-font-size',12)
        ->setOption('header-spacing',5)
        ->setOption('margin-bottom', 10);
        return $pdf->stream($programcode .'.pdf');
        return view('ct.Reports.ctr0004.pdf.index-by-batch-new', compact('datas', 'userProfile', 'dateFrom', 'dateTo'));

    }

    public function view(): View
    {
        $request     = (object)request()->all();
        $dateFrom    = $request->date_from;
        $dateTo      = $request->date_to;
        $userProfile = getDefaultData('/ct/reports');
        $formDate    = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate      = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $pDateFrom   = Carbon::createFromFormat('d/m/Y', $request->date_from)->startOfMonth()->format('d-M-Y');
        $pDateTo     = Carbon::createFromFormat('d/m/Y', $request->date_to)->endOfMonth()->format('d-M-Y');
        $cost        = costCenter($request->cost_code);
        $pYear       = $request->period_year;
        $pYear       = $request->period_year;
        $costCode    = $request->cost_code;
        $product_from = $request->product_from;
        $product_to = $request->product_to;
        $batch_from = $request->batch_from;
        $batch_to = $request->batch_to;

        // Procesed PKG function
        $result = $this->callPkg($pYear, $costCode, $pDateFrom, $pDateTo, $batch_from, $batch_to, $product_from, $product_to);
        $getBatchNo = PtctCtr0004WithPkg::selectRaw('distinct batch_no')
                                ->search($batch_from, $batch_to, $product_from, $product_to)
                                ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
                                ->where('rpt_id', $result)
                                ->get();
        $batch = $getBatchNo->pluck('batch_no')->toArray();
        // data
        $datas = PtctCtr0004WithPkg::where('rpt_id', $result)
                                ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
                                ->whereIn('batch_no', $batch)
                                ->get();
        $wipList = \DB::connection('oracle')
                    ->table('PTCT_WIP_PROCESS_V')
                    ->where('cost_code', $costCode)
                    ->orderBy('routingstep_no')
                    ->get();

        return view('ct.Reports.ctr0004.excel.index-by-batch-new', compact('datas', 'userProfile', 'dateFrom', 'dateTo', 'wipList'));


        $getBatchNo = PrctCtr0004::selectRaw('distinct batch_no')
                                ->search($batch_from, $batch_to, $product_from, $product_to)
                                ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
                                ->where('rpt_id', $result)
                                ->get();
        $batch = $getBatchNo->pluck('batch_no')->toArray();
        // data
        $datas = PrctCtr0004::where('cost_code', $request->cost_code)
                            ->where('period_year',  $request->period_year)
                            ->whereIn('batch_no', $batch)
                            ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
                            ->whereNotNull('transaction_date')
                            ->orderBy('oprn_code')
                            ->get();

        // $datas = PrctCtr0004::
        //         where('cost_code', $request->cost_code)
        //         ->where('period_year',  $request->period_year)
        //         ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
        //         ->when($request->batch_from, function ($q) use ($request) {
        //             $q->where('batch_no', '>=',  $request->batch_from);
        //         })
        //         ->when($request->batch_to, function ($q) use ($request) {
        //             $q->where('batch_no', '>=',  $request->batch_from);
        //         })
        //         ->orderBy('oprn_code')
        //         ->where('transaction_date', '!=', null)
        //         ->get();

        $bathId = array_keys($datas->groupBy('batch_id')->toArray());
        $setupBath = [];
        foreach($bathId as $id) {
            $setupBath[$id] = DB::table('PTPM_JOB_WIP_STEP' )->select('wip_step', 'wip_step_desc','batch_id')->where('batch_id', $id)->groupBy('wip_step','batch_id', 'wip_step_desc')->orderBy('wip_step')->get();
        }
        $i = 0;
        $arr = [];
        $firstWip = 0;
        $lastLast = 0;
        foreach ($datas->groupBy('oprn_code') as $wip =>  $data) {
            $i++;
            if ($i == 1) {
                $firstWip =  $i;
            }
            $data->map(function ($item, $key) use ($i) {
                $item->seq_wip  = $i;
                $item->sum_raw_material = $item->transaction_quantity *  $item->transaction_cost;
                $item->f_transaction_date =  date('Y-m-d', strtotime($item->transaction_date));
            });

            $lastLast = $i;
        }

        if (count($datas->groupBy('seq_wip')->keys()) == 1) {
            foreach ($datas->groupBy('seq_wip') as  $seqWip => $value) {
                if ($firstWip == $seqWip) {
                    $value->map(function ($item, $key) use ($seqWip, $datas) {
                        $item->previous_wip   = "";
                        $item->previous_wip_data   = [];
                        $item->next_wip   = "";
                        $item->next_wip_data   = [];
                    });
                }
            }
            return view('ct.Reports.ctr0004.excel.index-by-batch-new', compact('datas', 'userProfile', 'dateFrom', 'dateTo', 'cost', 'setupBath'));
        }

        // มากกว่า 1 wip
        foreach ($datas->groupBy('seq_wip') as  $seqWip => $value) {
            if ($firstWip == $seqWip) {
                $value->map(function ($item, $key) use ($seqWip, $datas) {
                    $item->previous_wip   = "";
                    $item->previous_wip_data   = [];
                    if ($datas->where('seq_wip', $seqWip + 1)->first()) {
                        $item->next_wip   = $datas->where('seq_wip', $seqWip + 1)->first()->oprn_code;
                        $item->next_wip_data   = $datas->where('seq_wip', $seqWip + 1);
                    } else {
                        $item->next_wip   = "";
                        $item->next_wip_data   = "";
                    }
                });
            }
            if ($lastLast == $seqWip) {
                $value->map(function ($item, $key) use ($seqWip, $datas) {
                    if ($datas->where('seq_wip', $seqWip - 1)) {
                        $item->previous_wip   = $datas->where('seq_wip', $seqWip - 1)->first()->oprn_code;
                        $item->previous_wip_data   = $datas->where('seq_wip', $seqWip - 1);
                    } else {
                        $item->previous_wip   = "";
                        $item->previous_wip_data   = [];
                    }
                    $item->next_wip   = "";
                    $item->next_wip_data   = [];
                });
            }
            if ($lastLast != $seqWip && $firstWip != $seqWip) {
                $value->map(function ($item, $key) use ($seqWip, $datas) {
                    $item->previous_wip   = $datas->where('seq_wip', $seqWip - 1)->first()->oprn_code;
                    $item->previous_wip_data   = $datas->where('seq_wip', $seqWip - 1);

                    $item->next_wip   = $datas->where('seq_wip', $seqWip + 1)->first()->oprn_code;
                    $item->next_wip_data   = $datas->where('seq_wip', $seqWip + 1);
                });
            }
        }
        $bathId = array_keys($datas->groupBy('batch_id')->toArray());
        $setupBath = [];
        foreach($bathId as $id) {
            $setupBath[$id] = DB::table('PTPM_JOB_WIP_STEP' )->select('wip_step', 'wip_step_desc','batch_id')->where('batch_id', $id)->groupBy('wip_step','batch_id', 'wip_step_desc')->orderBy('wip_step')->get();
        }
        return view('ct.Reports.ctr0004.excel.index-by-batch-new', compact('datas', 'setupBath', 'userProfile', 'dateFrom', 'dateTo', 'cost'));

        

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
            'A' => 65,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
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
