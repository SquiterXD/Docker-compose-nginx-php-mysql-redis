<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OM\reports\PtomOrderHeader;
use App\Models\OM\reports\PtomOrderLine;
use App\Models\OM\reports\PtomCustomerShipSite;
use App\Models\OM\reports\PtomCustomer;

use PDF;

class OMR0099Controller extends Controller
{
    public function getMonthTh($month) {
        $toInt = (int)($month);
        $months_th = ['' ,"มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return $months_th[$toInt];
    }
    public function export($programCode, $request)
    {

        DB::enableQueryLog();
        $remark = $request['remark']; // "remark" => "cccc"
        $data = [];
        $data['taxRate'] = DB::table('PTOM_ALL_TAX_RATE_V')->where('enabled_flag', 'Y')->first();
        $month = Carbon::createFromFormat('d/m/Y H:i:s', $request['month']);
        $data['monthTh'] = $this->getMonthTh($month->format('m'));
        $query = DB::select("
            select 
                C.customer_id,
                C.address_line1, 
                C.alley, 
                C.district, 
                C.city,
                C.postal_code,
                C.customer_number,
                C.region_code,
                C.customer_name,
                S.order_header_id,
                P.province_code,
                C.attribute2 province_name, 
                tax_pao_percent,
                item_code,
                item_description,
                approve_quantity,
                approve_quantity as P_Qty
            from ptom_pao_percent_inv P
                ,ptom_so_outstanding_v S
                ,ptom_customers C
            where S.order_header_id = P.order_header_id
            and C.customer_id = S.customer_id
            and C.attribute2 = P.province_name
            and C.attribute2 <> C.province_name
            and S.\"CUSTOMER_TYPE_ID\" != 20 
            and S.\"PROVINCE_CODE\" != 10 
            and S.\"PRODUCT_TYPE_CODE\" = 10 
            and approve_quantity <= 10
            and TO_CHAR(NVL(S.consignment_date,S.pick_release_approve_date), 'MM-YYYY') = '{$month->format('m-Y')}'
            union 
            select 
                C.customer_id,
                C.address_line1, 
                C.alley, 
                C.district, 
                C.city,
                C.postal_code,
                C.customer_number,
                C.region_code,
                C.customer_name, 
                S.order_header_id ,
                P.province_code,
                C.province_name province_name,
                tax_pao_percent,
                item_code,
                item_description,
                approve_quantity,
                CASE 
                    WHEN round(approve_quantity * TAX_PAO_PERCENT / 100,-1) > approve_quantity THEN approve_quantity 
                    ELSE round(approve_quantity * TAX_PAO_PERCENT / 100,-1) 
                END as P_Qty
            from ptom_pao_percent_inv P
                ,ptom_so_outstanding_v S
                ,ptom_customers C
            where S.order_header_id = P.order_header_id
            and C.customer_id = S.customer_id
            and C.province_name = P.province_name
            and S.\"CUSTOMER_TYPE_ID\" != 20 
            and S.\"PROVINCE_CODE\" != 10 
            and S.\"PRODUCT_TYPE_CODE\" = 10 
            and approve_quantity > 10
            and TO_CHAR(NVL(S.consignment_date,S.pick_release_approve_date), 'MM-YYYY') = '{$month->format('m-Y')}'
            union
            select 
                C.customer_id,
                C.address_line1, 
                C.alley, 
                C.district, 
                C.city,
                C.postal_code,
                C.customer_number,
                C.region_code,
                C.customer_name, 
                S.order_header_id ,
                P.province_code,
                P.province_name, 
                tax_pao_percent,
                item_code,
                item_description,
                approve_quantity,
                CASE  
                    WHEN approve_quantity - round(approve_quantity *(100 - TAX_PAO_PERCENT) / 100, -1) < 0  THEN 0 
                    ELSE approve_quantity - round(approve_quantity *(100 - TAX_PAO_PERCENT) / 100, -1) 
                END as P_Qty
            from ptom_pao_percent_inv P
                ,ptom_so_outstanding_v  S
                ,ptom_customers C
            where S.order_header_id = P.order_header_id
            and C.customer_id = S.customer_id
            and C.province_name <> P.province_name
            and S.\"CUSTOMER_TYPE_ID\" != 20 
            and S.\"PROVINCE_CODE\" != 10 
            and S.\"PRODUCT_TYPE_CODE\" = 10 
            and approve_quantity > 10
            and TO_CHAR(NVL(S.consignment_date,S.pick_release_approve_date), 'MM-YYYY') = '{$month->format('m-Y')}'
            union
            select 
                C.customer_id,
                C.address_line1, 
                C.alley, 
                C.district, 
                C.city,
                C.postal_code,
                C.customer_number,
                C.region_code,
                C.customer_name,
                S.order_header_id,
                0 AS Province_code,
                C.attribute2 province_name,
                100 as tax_pao_percent,
                item_code,
                item_description,
                approve_quantity,
                approve_quantity as P_Qty
            from ptom_so_outstanding_v  S
                ,ptom_customers C
            where C.customer_id = S.customer_id
            and S.\"CUSTOMER_TYPE_ID\" != 20 
            and S.\"PROVINCE_CODE\" != 10 
            and S.\"PRODUCT_TYPE_CODE\" = 10 
            and TO_CHAR(NVL(S.consignment_date,S.pick_release_approve_date), 'MM-YYYY') = '{$month->format('m-Y')}'
            and order_header_id not in (select distinct order_header_id from ptom_pao_percent_inv)
            union
            select
                C.customer_id,
                C.address_line1, 
                C.alley, 
                C.district, 
                C.city,
                C.postal_code,
                C.customer_number,
                C.region_code,
                C.customer_name,
                S.order_header_id,
                P.province_code,
                C.province_name province_name,
                tax_pao_percent,
                item_code,
                item_description,
                approve_quantity,
                approve_quantity as P_Qty
            from ptom_pao_percent_inv P
                ,ptom_so_outstanding_v S
                ,ptom_customers C
            where
            S.order_header_id = P.order_header_id
            and C.customer_id = S.customer_id
            AND C.attribute2 = C.province_name
            and C.attribute2 = P.province_name
            and S.\"CUSTOMER_TYPE_ID\" != 20
            and S.\"PROVINCE_CODE\" != 10
            and S.\"PRODUCT_TYPE_CODE\" = 10
            and approve_quantity <= 10
            and TO_CHAR(NVL(S.consignment_date,S.pick_release_approve_date), 'MM-YYYY') = '{$month->format('m-Y')}'
        ");
       
        $data['data'] = collect($query)->where('p_qty','>', '0');
        // return view('om.reports.omr0099.index',
        // $data);
        $pdf = PDF::loadView(
            'om.reports.omr0099.index',
            $data
        )
        ->setPaper('a4','landscape')
        ->setOption('header-font-name',"THSarabunNew")
        ->setOption('header-font-size',13)
        ->setOption('header-right',"\n\n\n[page]/[topage] ")
        ->setOption('header-spacing',3)
        ->setOption('margin-bottom', 5);
        return $pdf->stream($programCode . '.pdf');
    }

}
