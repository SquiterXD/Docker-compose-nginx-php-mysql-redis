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


class OMR0120  extends DefaultValueBinder implements WithCustomValueBinder , FromView, WithColumnWidths, WithColumnFormatting
{
    public function view(): View
    {
        $request = request();

        // $years = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->years);
        // $from_month = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->from_month);
        // $to_month = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->to_month);
        // $endofday = $to_month->copy()->endOfDay()->format('m-d');
        // dd($endofday);

        // $dateStart = \Carbon\Carbon::createFromFormat('Y-m-d', $years->format('Y') .'-'. $from_month->format('m').'-01' .'-'.
        //             $to_month->format('m'));

        if(in_array($request->to_month, ['10', '11', '12'])) {
            $to_year = $request->years + 1;
        } else {
            $to_year = $request->years;
        }

        $PtomProformaInvoiceHeadres = new PtomProformaInvoiceHeadres;
        $PtomProformaInvoiceLines = new PtomProformaInvoiceLines;
        $SequenceEcoms = new SequenceEcoms;
        $UomConversionModel = new UomConversionModel;
        $ProductTypeExport =new ProductTypeExport;

        $data = DB::select('select
        customer_name, ecom_item_description, sum(approve_quantity) as total
        ,PIL.uom_code, UOM.unit_of_measure, PDTE.description, PIL.item_id
        from
        '.( new PtomProformaInvoiceHeadres)->getTable().' PIH,
        '.(new PtomProformaInvoiceLines)->getTable().' PIL,
        PTOM_CUSTOMERS Cust,
        '.(new SequenceEcoms)->getTable().' SE,
        '.(new UomConversionModel)->getTable().' UOM,
        '.(new ProductTypeExport)->getTable().' PDTE
        where
        order_status in (\'Confirm\',\'Confirmed\')
        and PIH.customer_id = Cust.customer_id
        and PIH.PI_HEADER_ID = PIL.PI_HEADER_ID
        and SE.ITEM_ID(+) = PIL.ITEM_ID
        and UOM.UOM_CODE = PIL.UOM_CODE
        and PIH.product_type_code = PDTE.lookup_code
        and TRUNC(pick_release_approve_date ) BETWEEN  to_date(\''.$request->years.$request->from_month.'\', \'YYYYMM\')
        and LAST_DAY(to_date(\''.$to_year.$request->to_month.'\', \'YYYYMM\'))
        group by
        SE.product_type_code, screen_number, ecom_item_description,
        customer_name, PIL.uom_code, UOM.unit_of_measure, PDTE.description, PIL.item_id
        order by
        SE.product_type_code, screen_number, ecom_item_description,
        customer_name, PIL.uom_code, UOM.unit_of_measure, PDTE.description
        ' );
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
                $item->select_uom = $request_select_uom->where('uom_code', $request->cigarette)->first()->unit_of_measure;
                $item->total = $calBaseUnit->convert_order_carton;
                $item->select_uom_code = $request->cigarette;
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

                $item->select_uom = $request_select_uom->where('uom_code', $request->tobacco)->first()->unit_of_measure;
                $item->total = $calBaseUnit->convert_order_carton;
                $item->select_uom_code = $request->tobacco;
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

                $item->select_uom = $request_select_uom->where('uom_code', $request->medicinal)->first()->unit_of_measure;
                $item->total = $calBaseUnitaa->convert_order_carton;
                $item->select_uom_code = $request->medicinal;
                return $item;
            }

        });



        // dd($request->all(), $data);
        return view('om.reports.omr0120.excel', compact('data'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 50,
            'C' => 15,
            'D' => 10,
            'E' => 25,
            'F' => 18,

        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '#,##0.00',
        ];
    }

}

