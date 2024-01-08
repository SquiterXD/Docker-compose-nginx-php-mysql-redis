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
/////// Models \\\\\\
use App\Models\OM\Rma\Export\PtomProformaInvoiceHeadres;
use App\Models\OM\Rma\Export\PtomProformaInvoiceLines;
use App\Models\OM\Api\Customer;
use App\Models\OM\SequenceEcoms;
use App\Models\OM\PrepareSaleOrder\UomConversionModel;
use App\Models\OM\Settings\ProductTypeExport;
use Illuminate\Support\Facades\DB;


class OMR0121  extends DefaultValueBinder implements WithCustomValueBinder , FromView, WithColumnWidths, WithColumnFormatting
{
    public function view(): View
    {
        $request = request();

        $date_form = (int)$request->from_year - 1;
        $date_to = $request->to_year;
        $date_form = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date_form.'-10-01 00:00:01');
        $date_to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date_to.'-09-30 23:59:59');

        $data = DB::select('
        SELECT
        CASE
        WHEN
        extract( month FROM pick_release_approve_date ) > 10 THEN
        year + 1 ELSE year
        END year_budet,
        year,
        ecom_item_description,
        total,
        uom_code,
        description,
        item_id,
        pick_release_approve_date
        FROM
        (
        SELECT
        EXTRACT( year FROM pick_release_approve_date ) AS year,
        SE.ecom_item_description,
        sum( approve_quantity ) AS total,
        PIL.uom_code,
        UOM.description,
        PIL.item_id,
        pick_release_approve_date
        FROM
            '.(new PtomProformaInvoiceHeadres)->getTable().' PIH,
            '.(new PtomProformaInvoiceLines)->getTable().' PIL,
            PTOM_CUSTOMERS Cust,
            '.(new SequenceEcoms)->getTable().' SE,
            '.(new UomConversionModel)->getTable().' UOM,
            '.(new ProductTypeExport)->getTable().' PDTE
        WHERE
        PIH.customer_id = Cust.customer_id
        AND PIH.PI_HEADER_ID = PIL.PI_HEADER_ID
        AND SE.ITEM_ID ( + ) = PIL.ITEM_ID
        AND UOM.UOM_CODE = PIL.UOM_CODE
        AND PIH.product_type_code = PDTE.lookup_code
        AND pick_release_status = \'Confirm\'
        and TRUNC(pick_release_approve_date) BETWEEN  to_date(\''.$date_form->format('Y').$date_form->format('m').'\', \'YYYYMM\')
                and LAST_DAY(to_date(\''.$date_to->format('Y').$date_to->format('m').'\', \'YYYYMM\'))
        GROUP BY
        EXTRACT( year FROM pick_release_approve_date ),
        SE.ecom_item_description,
        PIL.uom_code,
        UOM.description,
        PIL.item_id,
        pick_release_approve_date
        ORDER BY
        EXTRACT( year FROM pick_release_approve_date ),
        UOM.description
        )
        '
        );

        $data = collect($data);
        $request_select_uom = UomConversionModel::whereIn('uom_code', [$request->cigarette, $request->tobacco, $request->medicinal])->get();
        $data = $data->map(function($item) use ($request, $request_select_uom) {

            $type = UomConversionModel::where('uom_code', $item->uom_code)->value('uom_class');
            if($type == "บุหรี่"){
                $calBaseUnit =  collect(DB::select("
                    select  (apps.inv_convert.inv_um_convert (
                                    item_id           => '{$item->item_id}',
                                    organization_id   => '164',
                                    PRECISION         => NULL,
                                    from_quantity     => '{$item->total}',
                                    from_unit         => '{$item->uom_code}',
                                    to_unit           => '{$request->cigarette}' ,
                                    from_name         => NULL,
                                    to_name           => NULL)
                            ) convert_order_carton
                    from dual
                "))->first();
                $item->select_uom = $request_select_uom->where('uom_code', $request->cigarette)->first()->description;
                $item->select_uom_code = $request->cigarette;
                $item->total = $calBaseUnit->convert_order_carton;
                return $item;
            }elseif($type == "ทั่วไป"){
                $calBaseUnit =  collect(DB::select("
                    select  (apps.inv_convert.inv_um_convert (
                                    item_id           => '{$item->item_id}',
                                    organization_id   => '164',
                                    PRECISION         => NULL,
                                    from_quantity     => '{$item->total}',
                                    from_unit         => '{$item->uom_code}',
                                    to_unit           => '{$request->tobacco}' ,
                                    from_name         => NULL,
                                    to_name           => NULL)
                            ) convert_order_carton
                    from dual
                "))->first();
                $item->select_uom = $request_select_uom->where('uom_code', $request->tobacco)->first()->description;
                $item->select_uom_code = $request->tobacco;
                $item->total = $calBaseUnit->convert_order_carton;
                return $item;
            }else {
                $calBaseUnitaa =  collect(DB::select("
                    select  (apps.inv_convert.inv_um_convert (
                                    item_id           => '{$item->item_id}',
                                    organization_id   => '164',
                                    PRECISION         => NULL,
                                    from_quantity     => '{$item->total}',
                                    from_unit         => '{$item->uom_code}',
                                    to_unit           => '{$request->medicinal}' ,
                                    from_name         => NULL,
                                    to_name           => NULL)
                            ) convert_order_carton
                    from dual
                "))->first();
                $item->select_uom = $request_select_uom->where('uom_code', $request->medicinal)->first()->description;
                $item->select_uom_code = $request->medicinal;
                $item->total = $calBaseUnitaa->convert_order_carton;
                return $item;
            }
        });

        return view('om.reports.omr0121.excel', compact('data'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 50,
            'C' => 15,
            'D' => 15,
            'E' => 53,

        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '#,##0.00',
        ];
    }

}

