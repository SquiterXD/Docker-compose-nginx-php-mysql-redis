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



use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CTR0040 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths
{
    public $datas;
    public function __construct($datas) {
        $this->datas = $datas;
    }
    public function columnFormats(): array
    {
        return [
            'B' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'C' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'D' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'E' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'F' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'H' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'G' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'I' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'J' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'K' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'L' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'M' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
            'N' => '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)',
        ];
    }


    public function view(): View
    {
        $data = $this->datas;
        $programCode = getProgramCode('/ct/ctr0040');

        return view('ct.reports.ctr0040.excel.index', compact('data'));
    }

    public function styles(Worksheet $sheet)
    {
    }

    public function columnWidths(): array
    {
        return [];
        // return [
        //     'A' => 20,
        //     'B' => 60,
        // ];
    }
}
