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

use FormatDate;
use Carbon\Carbon;

class CTR0003Detail implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths
{
    public function __construct($rpt_id)
    {
        $this->rpt_id = $rpt_id;
    }

    public function columnFormats(): array
    {
        return [
            'D' => '#,##0.000000',
            'E' => '#,##0.000000',
            // 'F' => '#,##0.00',
            'F' => '#,##0.000000000',
            'G' => '#,##0.00',
        ];
    }

    public function view(): View
    {
        $rpt_id = $this->rpt_id;
        $request    = (object)request()->all();
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;
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
        ->orderByRaw('item_number asc')
        ->get();

        $datas_level_2 = PtctCtr0003::where('rpt_id', $rpt_id)
        ->where('level_no', 2)
        ->orderByRaw('wip_step asc')
        ->get();

        return view('ct.Reports.ctr0003.excel.index-detail', compact('datas_level_1', 'datas_level_2', 'userProfile', 'dateFrom', 'dateTo' ,'cost'));
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
            'D' => 26,
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

