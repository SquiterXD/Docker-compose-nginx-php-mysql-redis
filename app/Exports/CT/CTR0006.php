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

class CTR0006 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths
{
    public $datas;
    public function __construct($datas) {
        $this->datas = $datas;
    }
    public function columnFormats(): array
    {
        return [
            'D' => '#,##0.000000',
            // 'E' => '#,##0.000000',
            // 'F' => '#,##0.00',
            'E' => '#,##0.000000000',
            'F' => '#,##0.00',
            'G' => '#,##0.000000000',

        ];
    }


    public function view(): View
    {
        $datas = $this->datas;
        $programCode = getProgramCode('/ct/ctr0006');

        return view('ct.Reports.ctr0006.excel.index', compact('datas'));
    }

    public function styles(Worksheet $sheet)
    {
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 60,
        ];
    }
}
