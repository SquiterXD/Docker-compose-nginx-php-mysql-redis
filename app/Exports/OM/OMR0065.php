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


class OMR0065  extends DefaultValueBinder implements WithCustomValueBinder , FromView, WithColumnWidths, WithColumnFormatting, WithTitle
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
           
        


        $data = collect(DB::select("select  
        uom_class
        ,PDTE.description

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
        and PIH.product_type_code = PDTE.lookup_code
        and TRUNC(pick_release_approve_date ) BETWEEN  to_date('$year"."$from_month', 'YYYYMM')
        and LAST_DAY(to_date('$year"."$to_month', 'YYYYMM'))
        group by
        SE.product_type_code
        , PDTE.description
        ,uom_class
        order by
        SE.product_type_code
        "));
        // dd($data);

        $dataL =collect(DB::select("select description,ecom_item_description
        ,sum(decode(month,'01',convert)) m01
        ,sum(decode(month,'02',convert)) m02
        ,sum(decode(month,'03',convert)) m03
        ,sum(decode(month,'04',convert)) m04
        ,sum(decode(month,'05',convert)) m05
        ,sum(decode(month,'06',convert)) m06
        ,sum(decode(month,'07',convert)) m07
        ,sum(decode(month,'08',convert)) m08 
        ,sum(decode(month,'09',convert)) m09
        ,sum(decode(month,'10',convert)) m10
        ,sum(decode(month,'11',convert)) m11
        ,sum(decode(month,'12',convert)) m12
        ,sum(convert) sum
        
        from(select  customer_name
                ,ecom_item_description
                , sum(approve_quantity) as total
                ,PIL.uom_code
                ,UOM.unit_of_measure
                ,uom_class
                ,PDTE.description
                ,PIL.item_id
                ,PIH.product_type_code
                ,to_char(pick_release_approve_date,'MM') month
                ,apps.inv_convert.inv_um_convert (
                                            item_id           => PIL.item_id,
                                            organization_id   => '164',
                                            PRECISION         => NULL,
                                            from_quantity     => sum(approve_quantity),
                                            from_unit         => PIL.uom_code,
                                            to_unit           => decode(uom_class,'บุหรี่','$cigarette'
                                                                        ,'ทั่วไป','$tobacco'
                                                                        ,'น้ำหนัก','$medicinal'),
                                            from_name         => NULL,
                                            to_name           => NULL) convert,max(pick_release_approve_date)
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
                and PIH.product_type_code = PDTE.lookup_code
                and TRUNC(pick_release_approve_date ) BETWEEN  to_date('$year"."$from_month', 'YYYYMM')
                and LAST_DAY(to_date('$year"."$to_month', 'YYYYMM'))
                group by
                SE.product_type_code
                , screen_number
                , ecom_item_description
                , customer_name
                , PIL.uom_code
                , UOM.unit_of_measure
                , PDTE.description
                , PIL.item_id
                , PIH.product_type_code
                , to_char(pick_release_approve_date,'MM')
                ,uom_class
                order by
                SE.product_type_code, screen_number, ecom_item_description,
                customer_name, PIL.uom_code, UOM.unit_of_measure, PDTE.description)
                group by ecom_item_description,description "));
        // dd($dataL);
        if($to_month=='10'or $to_month=='11'or $to_month=='12'){
            $year +=1;
        } 
        $tobacco =  collect(DB::select(" select unit_of_measure 
        from ptom_uom_conversions_v
        where export = 'Y' and uom_class = 'ทั่วไป'
        AND uom_code='$tobacco'"))->first();
        $tobacco =$tobacco->unit_of_measure;
        // dd($medicinal);
        $medicinal =  collect(DB::select(" select unit_of_measure 
        from ptom_uom_conversions_v
        where export = 'Y' 
        AND uom_code='$medicinal'"))->first();
        $medicinal =$medicinal->unit_of_measure;

        $cigarette =  collect(DB::select(" select unit_of_measure 
        from ptom_uom_conversions_v
        where export = 'Y' 
        AND uom_code='$cigarette'"))->first();
        $cigarette =$cigarette->unit_of_measure;
        $from_month =(monthFormatThaiString(number_format($from_month)));
        $to_month =(monthFormatThaiString(number_format($to_month)));
        $timeNow = date("h:i:s");
        $year +=543;
        $nowDateTh = parseToDateTh(now());
        // dd($nowDateTh);
        return view('om.reports.omr0065.excel.index', compact('nowDateTh','timeNow','year','from_month','to_month','tobacco','data','dataL','note','cigarette','medicinal'));
        
    }



    public function columnWidths(): array
    {
        return [
            'A' => '30',
            'B' => '20',
            'C' => '20',
            'D' => '20',
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
            'B' => '#,##0.00',
            'C' => '#,##0.00',
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

