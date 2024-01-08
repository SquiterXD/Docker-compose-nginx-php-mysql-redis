<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OM\OMR0120;

/////// Models \\\\\\
use App\Models\OM\Rma\Export\PtomProformaInvoiceHeadres;
use App\Models\OM\Rma\Export\PtomProformaInvoiceLines;
use App\Models\OM\Api\Customer;
use App\Models\OM\SequenceEcoms;
use App\Models\OM\PrepareSaleOrder\UomConversionModel;
use App\Models\OM\Settings\ProductTypeExport;
use Illuminate\Support\Facades\DB;
use PDO;

class OMR0120Controller extends Controller
{
    public function OMR0120PDF($programcode, $request){
        $request = request();
        // $years = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->years);
        // $from_month = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->from_month);
        // $to_month = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->to_month);
        // // $endofday = $to_month->copy()->endOfDay()->format('m-d');

        // $Y = $years->format('Y');

        // dd($request->all(), $aa->convert_order_carton);

        $thai_months = [
            '01' => 'มกราคม',
            '02' => 'กุมภาพันธ์',
            '03' => 'มีนาคม',
            '04' => 'เมษายน',
            '05' => 'พฤษภาคม',
            '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม',
            '08' => 'สิงหาคม',
            '09' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม',
        ];

        $fm = $thai_months[$request->from_month];
        $tm = $thai_months[$request->to_month];


        if(in_array($request->to_month, ['10', '11', '12'])) {
            $to_year = $request->years + 1;
        } else {
            $to_year = $request->years;
        }
        //////// แปลงปี พศ ////////
        $years_th = $to_year + 543;



        $PtomProformaInvoiceHeadres = new PtomProformaInvoiceHeadres;
        $PtomProformaInvoiceLines = new PtomProformaInvoiceLines;
        $SequenceEcoms = new SequenceEcoms;
        $UomConversionModel = new UomConversionModel;
        $ProductTypeExport =new ProductTypeExport;

        $cigarette_type = UomConversionModel::where('uom_code', $request->cigarette)->first();
        $tobacco_type = UomConversionModel::where('uom_code', $request->tobacco)->first();
        $medicinal_type = UomConversionModel::where('uom_code', $request->medicinal)->first();


        $data = DB::select('select
        customer_name, ecom_item_description, sum(approve_quantity) as total
        ,PIL.uom_code, UOM.unit_of_measure, PDTE.description, PIL.item_id
        from
        '.(new PtomProformaInvoiceHeadres)->getTable().' PIH,
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
        --and UOM.UOM_CODE = PIL.UOM_CODE
        and PIH.product_type_code = PDTE.lookup_code
        and TRUNC(pick_release_approve_date ) BETWEEN  to_date(\''.$request->years.$request->from_month.'\', \'YYYYMM\')
        and LAST_DAY(to_date(\''.$to_year.$request->to_month.'\', \'YYYYMM\'))
        and PIH.product_type_code = 10
        group by
        SE.product_type_code, screen_number, ecom_item_description,
        customer_name, PIL.uom_code, UOM.unit_of_measure, PDTE.description, PIL.item_id
        order by
        SE.product_type_code, screen_number, ecom_item_description,
        customer_name, PIL.uom_code, UOM.unit_of_measure, PDTE.description
        ' );
        // dd($data, $request->all());
        $group_item_desc = collect($data)->groupBy('ecom_item_description');
        $group_cus = collect($data)->groupBy('customer_name');

        $data = collect($data);
        $data = $data->map(function($item) use ($request) {
            $calBaseUnit1 =  collect(DB::select("
                select  (apps.inv_convert.inv_um_convert (
                                item_id           => '{$item->item_id}',
                                organization_id   => '164',
                                PRECISION         => NULL,
                                from_quantity     => '{$item->total}',
                                from_unit         => '{$item->uom_code}',
                                to_unit           => '{$request->cigarette}',
                                from_name         => NULL,
                                to_name           => NULL)
                        ) convert_order_carton
                from dual
            "))->first();

            $item->total = $calBaseUnit1->convert_order_carton;
            return $item;
        });


        ////////////////////////////////////////////////////////////////////////////////////////////////

        $data_2 = DB::select('select
        customer_name, ecom_item_description, sum(approve_quantity) as total
        ,PIL.uom_code, UOM.unit_of_measure, PDTE.description, PIL.item_id,PIH.customer_id
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
        and LAST_DAY(to_date(\''.$request->years.$request->to_month.'\', \'YYYYMM\'))
        and  PIH.product_type_code <> 10
        group by
        SE.product_type_code, screen_number, ecom_item_description,
        customer_name, PIL.uom_code, UOM.unit_of_measure, PDTE.description, PIL.item_id,PIH.customer_id
        order by
        SE.product_type_code, screen_number, ecom_item_description,
        customer_name, PIL.uom_code, UOM.unit_of_measure, PDTE.description
        ' );
        $data_2 = collect($data_2);
        $data_2 = $data_2->map(function($item_1) use ($request) {

            $type = UomConversionModel::where('uom_code', $item_1->uom_code)->value('uom_class');
            if($type == "ทั่วไป"){
                $calBaseUnit =  collect(DB::select("
                    select  (apps.inv_convert.inv_um_convert (
                                    item_id           => '{$item_1->item_id}',
                                    organization_id   => '164',
                                    PRECISION         => NULL,
                                    from_quantity     => '{$item_1->total}',
                                    from_unit         => '{$item_1->uom_code}',
                                    to_unit           => '{$request->tobacco}' ,
                                    from_name         => NULL,
                                    to_name           => NULL)
                            ) convert_order_carton
                    from dual
                "))->first();

                $item_1->total = $calBaseUnit->convert_order_carton;
                return $item_1;
            }else {
                $calBaseUnitaa =  collect(DB::select("
                    select  (apps.inv_convert.inv_um_convert (
                                    item_id           => '{$item_1->item_id}',
                                    organization_id   => '164',
                                    PRECISION         => NULL,
                                    from_quantity     => '{$item_1->total}',
                                    from_unit         => '{$item_1->uom_code}',
                                    to_unit           => '{$request->medicinal}' ,
                                    from_name         => NULL,
                                    to_name           => NULL)
                            ) convert_order_carton
                    from dual
                "))->first();

                $item_1->total = $calBaseUnitaa->convert_order_carton;
                return $item_1;
            }
        });

        // dd($data_2);

        $group_cus_2 = $data_2->groupBy('customer_name');
        $group_item_desc_2 = $data_2->groupBy('ecom_item_description');
        $group_desc_2 = $data_2->groupBy('description');

        $user = auth()->user();
        $fileName = date('Y/m/d');
        $contentHtml = view('om.reports.omr0120.main_page',
            compact('programcode', 'user', 'request', 'data','group_cus', 'group_item_desc', 'years_th', 'fm','tm', 'group_cus_2', 'group_item_desc_2',
            'group_desc_2', 'cigarette_type', 'tobacco_type', 'medicinal_type', 'data_2'))->render();
        return PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream($fileName.'.pdf');

    }

    public function OMR0120EXCEL($programcode, $request)
    {
        // $apIn= PtctMfgBatchGenWipend::get();
        return Excel::download(new OMR0120, $programcode.'.xlsx');
    }
}
