<?php

namespace App\Exports\OM;

use App\Http\Controllers\CT\Reports\OMR0062Controller;
use App\Http\Controllers\CT\Reports\OMR0082Controller;
use App\Models\OM\ARInterface;
use App\Models\OM\ProformaInvoiceHeader;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLines;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use stdClass;

class OMR0059sheet3  extends DefaultValueBinder implements WithCustomValueBinder, FromView, WithColumnWidths, WithColumnFormatting
{
    protected $programCode;
    protected $request;
    protected $compact;
    protected $title;
    protected $arrData;
    public function __construct($programCode, $request, $compact)
    {
        $this->programCode = $programCode;
        $this->request = $request;
        $this->compact = $compact;
    }

    public function getMonthTh($month)
    {
        $months_th = ['', '01'=>"มกราคม", '02'=>"กุมภาพันธ์", '03'=>"มีนาคม", '04'=>"เมษายน", '05'=>"พฤษภาคม", '06'=>"มิถุนายน", '07'=>"กรกฎาคม", '08'=>"สิงหาคม", '09'=>"กันยายน", '10'=>"ตุลาคม", '11'=>"พฤศจิกายน", '12'=>"ธันวาคม"];
        return $months_th[$month];
    }
    
    public function view(): View
    {
        $request = $this->request;
        return view(
            'om.reports.omr0059.excel.sheet3'
            ,$this->compact
        );
    }

   

    public function columnWidths(): array
    {
        return [
            'A' => '40',
            'B' => '20',
            'C' => '20',
            'D' => '20',
            'E' => '20',
            'F' => '20',
            'G' => '20',
            'H' => '20',
            'I' => '20',

        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'B' => '#,##0.00',
        ];
    }

    // public function title(): string
    // {
    //     return $this->title;
    // }
}
