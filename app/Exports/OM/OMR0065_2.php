<?php

namespace App\Exports\OM;

use Illuminate\Contracts\View\View;
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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;


class OMR0065_2  extends DefaultValueBinder implements WithCustomValueBinder , FromView, WithColumnWidths, WithColumnFormatting, WithTitle
{
    protected $programCode;
    protected $request;
    protected $title;

    public function __construct($programCode, $request, $title){
        $this->programCode = $programCode;
        $this->request = $request;
        $this->title = $title;
    }

    public function view(): View
    {
        $request = request();
        $year = Arr::get(request()->all(), 'years');
        $from_month = Arr::get(request()->all(), 'from_month');
        $to_month = Arr::get(request()->all(), 'to_month');
        $cigarette = Arr::get(request()->all(), 'cigarette');
        $tobacco = Arr::get(request()->all(), 'tobacco');
        $medicinal = Arr::get(request()->all(), 'medicinal');
        $note = Arr::get(request()->all(), 'note');
           
        


       

        $data =collect(DB::select("select YEAR
        ,month
        ,description
        ,sum(convert) count
                
        from(
            select to_char(pick_release_approve_date,'YYYY') YEAR
             ,ecom_item_description description
             ,to_char(pick_release_approve_date,'MM') month
             ,apps.inv_convert.inv_um_convert (
                item_id           => PIL.item_id,
                organization_id   => '164',
                PRECISION         => NULL,
                from_quantity     => approve_quantity,
                from_unit         => PIL.uom_code,
                to_unit           => decode(uom_class,'บุหรี่','$cigarette'
                                            ,'ทั่วไป','$tobacco'
                                            ,'น้ำหนัก','$medicinal'),
                from_name         => NULL,
                to_name           => NULL) convert
             from
             ptom_proforma_invoice_HEADERs PIH,
             ptom_proforma_invoice_lines PIL,
             PTOM_CUSTOMERS Cust,
             OAOM.PTOM_SEQUENCE_ECOMS SE,
             OAOM.PTOM_UOM_CONVERSIONS_V UOM,
             PTOM_PRODUCT_TYPE_EXPORT PDTE
             where
             order_status in ('Confirm','Confirmed')
             and PIH.customer_id = Cust.customer_id
             and PIH.PI_HEADER_ID = PIL.PI_HEADER_ID
             and SE.ITEM_ID(+) = PIL.ITEM_ID
             and UOM.UOM_CODE = PIL.UOM_CODE
             and TRUNC(pick_release_approve_date ) BETWEEN  to_date('$year"."$from_month', 'YYYYMM')
             and LAST_DAY(to_date('$year"."$to_month', 'YYYYMM'))
             and PIH.product_type_code = PDTE.lookup_code)
        group by   YEAR
                ,month
                ,description
        order by YEAR
                ,month "));
     

        // $year +=543;
        // $nowDateTh = parseToDateTh(now());
        return view('om.reports.omr0065.excel.sheet2.index', compact('data'));
        
    }



    public function columnWidths(): array
    {
        return [
            'A' => '15',
            'B' => '15',
            'C' => '40',
            'D' => '15',
            'E' => '20',
            'F' => '20',
            'G' => '20',
            'H' => '20',
            'I' => '20',
            'J' => '20',
            'K' => '20',
            'L' => '20',
            'M' => '20',
            'N' => '20',

        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'B' => '#,##0.00',
            // 'C' => '#,##0.00',
            'D' => '#,##0.00',
            'E' => '#,##0.00',
            'F' => '#,##0.00',
            'G' => '#,##0.00',
            'H' => '#,##0.00',
            'I' => '#,##0.00',
            'J' => '#,##0.00',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00',
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

}

