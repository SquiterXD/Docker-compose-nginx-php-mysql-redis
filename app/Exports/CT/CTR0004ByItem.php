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




use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CTR0004ByItem implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

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


    public function view(): View
    {


        $request            = (object)request()->all();
        $dateFrom   =  $request->date_from;
        $dateTo     = $request->date_to;
        $userProfile = getDefaultData('/ct/reports');
        $cost =  costCenter($request->cost_code);

        $formDate = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        // $datas = Cache::remember('PrctCtr0004', 3600, function() use($request, $formDate, $toDate) {
        //     return   PrctCtr0004::where('cost_code', $request->cost_code)
        //     ->where('period_year',  $request->period_year)
        //     ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
        //     ->when($request->product_from, function ($q) use ($request) {
        //         $q->where('product_item_number', '>=',  $request->product_from);
        //     })
        //     ->when($request->product_to, function ($q) use ($request) {
        //         $q->where('product_item_number', '>=',  $request->product_to);
        //     })
        //     ->orderBy('oprn_code')
        //     ->where('transaction_date', '!=', null)
        //     ->get();
        // });

        $datas = PrctCtr0004::where('cost_code', $request->cost_code)
            ->where('period_year',  $request->period_year)
            ->whereRaw("trunc(transaction_date) BETWEEN to_date('".$formDate."', 'YYYY-MM-DD') AND to_date('".$toDate."', 'YYYY-MM-DD')")
            ->when($request->product_from, function ($q) use ($request) {
                $q->where('product_item_number', '>=',  $request->product_from);
            })
            ->when($request->product_to, function ($q) use ($request) {
                $q->where('product_item_number', '>=',  $request->product_to);
            })
            ->orderBy('oprn_code')
            ->where('transaction_date', '!=', null)
            ->get();
        $i = 0;
        $arr = [];
        $bathId = array_keys($datas->groupBy('batch_id')->toArray());
        $setupBath = [];
        foreach($bathId as $id) {
            $setupBath[$id] = DB::table('PTPM_JOB_WIP_STEP' )->select('wip_step', 'wip_step_desc','batch_id')->where('batch_id', $id)->groupBy('wip_step','batch_id', 'wip_step_desc')->orderBy('wip_step')->get();
        }
        $firstWip = "";
        $lastLast = "";
        foreach ($datas->groupBy('oprn_code') as $wip =>  $data) {
            $i++;
            if ($i == 1) {
                $firstWip =  $i;
            }
            // $lossQty = productWipV($datas[0]->batch_id, $wip , $datas->where('transaction_date', '!=', null)->pluck('f_transaction_date', 'f_transaction_date'));
            $data->map(function ($item, $key) use ($i) {
                $item->seq_wip  = $i;
                $item->sum_raw_material = $item->transaction_quantity *  $item->transaction_cost;
                $item->f_transaction_date =  date('Y-m-d', strtotime($item->transaction_date));
            });

            $lastLast = $i;
        }

        if(count($datas->groupBy('seq_wip')->keys()) == 1){
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
            return view('ct.Reports.ctr0004.excel.index-by-item-new', compact('datas', 'userProfile', 'dateFrom', 'dateTo', 'cost', 'setupBath'));
            return view('ct.Reports.ctr0004.excel.index-by-item', compact('datas', 'userProfile', 'dateFrom', 'dateTo', 'cost'));

        }


        foreach ($datas->groupBy('seq_wip') as  $seqWip => $value) {

            if ($firstWip == $seqWip) {
                $value->map(function ($item, $key) use ($seqWip, $datas) {
                    $item->previous_wip   = "";
                    $item->previous_wip_data   = [];

                    $item->next_wip   = $datas->where('seq_wip', $seqWip + 1)->first()->oprn_code;
                    $item->next_wip_data   = $datas->where('seq_wip', $seqWip + 1);
                });
            }

            if ($lastLast == $seqWip) {
                $value->map(function ($item, $key) use ($seqWip, $datas) {
                    $item->previous_wip   = $datas->where('seq_wip', $seqWip - 1)->first()->oprn_code;
                    $item->previous_wip_data   = $datas->where('seq_wip', $seqWip - 1);

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
        return view('ct.Reports.ctr0004.excel.index-by-item-new', compact('datas', 'setupBath', 'userProfile', 'dateFrom', 'dateTo', 'cost'));

        // $request            = (object)request()->all();
        // $dateFrom   =  $request->date_from;
        // $dateTo     = $request->date_to;
        // $userProfile = getDefaultData('/ct/reports');
        //     $datas = PtctTtctrp97::
        //                 where('cost_code', $request->cost_code)
        //                 ->where('period_year',  $request->period_year)
        //                 ->whereRaw("to_date(transaction_date, 'DD/MM/YYYY') BETWEEN  to_date('".$request->date_from."', 'DD/MM/YYYY')  AND to_date('".$request->date_to."', 'DD/MM/YYYY')")
        //                 ->where('batch_no', '>=',  $request->batch_from)
        //                 ->where('batch_no', '<=',  $request->batch_to)
        //                 ->orderBy('batch_no')
        //                 ->where('ct_group_code', 'CT_CS_ABSORBED')
        //                 ->get();

        //     return view('ct.Reports.ctr0003.excel.index', compact('datas', 'userProfile', 'dateFrom', 'dateTo'));

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
