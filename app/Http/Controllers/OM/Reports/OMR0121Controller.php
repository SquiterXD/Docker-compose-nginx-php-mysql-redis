<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OM\OMR0121;

/////// Models \\\\\\
use App\Models\OM\Rma\Export\PtomProformaInvoiceHeadres;
use App\Models\OM\Rma\Export\PtomProformaInvoiceLines;
use App\Models\OM\Api\Customer;
use App\Models\OM\SequenceEcoms;
use App\Models\OM\PrepareSaleOrder\UomConversionModel;
use App\Models\OM\Settings\ProductTypeExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class OMR0121Controller extends Controller
{

    public function OMR0121PDF($programcode, $request){
        $request = request();
        $date_form = (int)$request->from_year - 1;
        $date_to = $request->to_year;
        $date_form = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date_form.'-10-01 00:00:01');
        $date_to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date_to.'-09-30 23:59:59');

        //////// แปลงปี พศ ////////
        $years_fromth = $request->from_year + 543;
        $years_toth = $request->to_year + 543;
        // dd(route('pm.test-html-header.ton', ['years_fromth' => $years_fromth, 'years_toth' => $years_toth]));

        $cigarette_type = UomConversionModel::where('uom_code', $request->cigarette)->first();
        $tobacco_type = UomConversionModel::where('uom_code', $request->tobacco)->first();
        $medicinal_type = UomConversionModel::where('uom_code', $request->medicinal)->first();


        $sql = '
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
        PDTE.description,
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
        PDTE.description,
        PIL.item_id,
        pick_release_approve_date
        ORDER BY
        EXTRACT( year FROM pick_release_approve_date ),
        PDTE.description
        )
        ';


        // $data = Cache::remember('datas', 3600, function() use($sql) {return DB::select($sql);});
        $data =  DB::select($sql);

        $data = collect($data);
        $data = $data->map(function($item) use ($request, $cigarette_type, $tobacco_type, $medicinal_type) {

            $type = UomConversionModel::where('uom_code', $item->uom_code)->value('uom_class');
            if($type == "บุหรี่"){
                $calBaseUnit =  collect(DB::select("
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

                $item->total = $calBaseUnit->convert_order_carton;
                $item->uom_type = $cigarette_type;
                return $item;
            }elseif($type == "ทั่วไป"){
                $calBaseUnit =  collect(DB::select("
                    select  (apps.inv_convert.inv_um_convert (
                                    item_id           => '{$item->item_id}',
                                    organization_id   => '164',
                                    PRECISION         => NULL,
                                    from_quantity     => '{$item->total}',
                                    from_unit         => '{$item->uom_code}',
                                    to_unit           => '{$request->tobacco}',
                                    from_name         => NULL,
                                    to_name           => NULL)
                            ) convert_order_carton
                    from dual
                "))->first();

                $item->total = $calBaseUnit->convert_order_carton;
                $item->uom_type = $tobacco_type;
                return $item;
            }else {
                $calBaseUnitaa =  collect(DB::select("
                    select  (apps.inv_convert.inv_um_convert (
                                    item_id           => '{$item->item_id}',
                                    organization_id   => '164',
                                    PRECISION         => NULL,
                                    from_quantity     => '{$item->total}',
                                    from_unit         => '{$item->uom_code}',
                                    to_unit           => '{$request->medicinal}',
                                    from_name         => NULL,
                                    to_name           => NULL)
                            ) convert_order_carton
                    from dual
                "))->first();

                $item->total = $calBaseUnitaa->convert_order_carton;
                $item->uom_type = $medicinal_type;
                return $item;
            }
        });

        $group_description = collect($data)->groupBy('description');
        $group_year = collect($data)->sortBy('year_budet')->groupBy('year_budet');
        $group_item_desc = collect($data)->groupBy('ecom_item_description');
        // dd($group_year , $data);

        $user = auth()->user();
        $fileName = date('Y/m/d');
        $contentHtml = view('om.reports.omr0121.main_page',compact('data', 'user', 'cigarette_type', 'tobacco_type', 'medicinal_type', 'group_year'
        , 'group_item_desc', 'request', 'years_fromth', 'years_toth', 'group_description'))->render();
        session()->put('omr0121_page_number', 1);
        return PDF::loadHtml($contentHtml)
        ->setOrientation('landscape')
        ->setOption('margin-top', '20')
        ->setOption('header-html', view('om.reports.omr0121.header', compact('user','years_fromth', 'years_toth'))->render())
        ->setOption('margin-top', '30')
        ->stream($fileName.'.pdf');

    }
    public function _viewHeaderPDF(Request $request) {
        $user = auth()->user();
        $query = $request->all();
        $years_fromth = $request->years_fromth;
        $years_toth = $request->years_toth;
        return view('om.reports.omr0121.header', compact('user', 'query','years_fromth', 'years_toth'));
    }
    public function OMR0121EXCEL($programcode, $request)
    {
        // $apIn= PtctMfgBatchGenWipend::get();
        return Excel::download(new OMR0121, $programcode.'.xlsx');
    }
}
