<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use Carbon\Carbon;
//use App\Models\IR\Settings\PtirCompanies;
use Illuminate\Support\Facades\DB;
use PDF;

use App\Models\OM\Customers;

class OMR0044Controller extends Controller{
	public function export($programCode, $request)
    {
        // Add new Condition Customer
        $username = auth()->user()->username;
        $customer = Customers::where('attribute1', 'like', '%'.$username.'%')->first();
        $customerId = $customer->customer_id ?? $request['cs_customer'];

        // list($cus_id,$cus_name) = ($request['cs_customer']!="")?explode('|',$request['cs_customer']) : [0,''];
        $month = $request['cs_month'];
        $year = $request['cs_year'];
        $cus_id = $customerId; //$request['cs_customer'];

        $dateFrom = $request['date_from'];
        $dateTo = $request['date_to'];
        $thYear = (int)$year + 543;
        $thMonth = getMonthTh(date('M', strtotime($year."-".$month."-01")));
        $carbonDateFrom = Carbon::createFromFormat('d/m/Y', $request['date_from']);
        $carbonDateTo = Carbon::createFromFormat('d/m/Y', $request['date_to']);
        $thMonthFrom = getMonthTh($carbonDateFrom->format('M'));
        $thMonthTo = getMonthTh($carbonDateTo->format('M'));
        $remark = $request['cs_remark'];
        $mmyyyy = $month.'-'.$year;

        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;
        // $progPara[0]="ประจำเดือน $thMonth ปี $thYear";
        // $progPara[0]="ประจำเดือน $thMonth ปี $thYear";
        $progPara[0]="ตั้งแต่วันที่ {$carbonDateFrom->format('d')} {$thMonthFrom} {$carbonDateFrom->addYears(543)->format('Y')} ถึงวันที่ {$carbonDateTo->format('d')} {$thMonthTo} {$carbonDateTo->addYears(543)->format('Y')}";
        // $progPara[1]=$customer->customer_name;
        // $progPara[1]=$cus_name;

        $sql_con="";
        $sql_con.=($cus_id!='')?" and p.customer_id='$cus_id' ":"";

        // $sql_con.=($month!='')?" and TO_CHAR(h.consignment_date,'mm-YYYY')='$mmyyyy' ":"";
        $sql_con.=($dateTo!='' && $dateTo)?" and TRUNC(h.consignment_date) BETWEEN TO_DATE('{$dateFrom}', 'DD/MM/YYYY') AND TO_DATE('{$dateTo}', 'DD/MM/YYYY') ":"";
        $cs_view="
        select
                TO_CHAR(h.consignment_date, 'mm-YYYY') cs_month,
                TO_CHAR(
                    h.consignment_date,
                    'dd/mm/yyyy',
                    'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI'
                ) cs_date_th,
                (
                    case
                        when p.product_type_code = '10' then 'บุหรี่'
                        when p.product_type_code = '20' then 'ยาเส้น'
                        else 'อื่นๆ'
                    end
                ) cs_product,
                p.customer_id cs_customer,
                e.customer_name cs_customer_name,
                h.consignment_no cs_no,
                ROUND(h.total_amount, 2) cs_price2,
                sum(
                    case
                        when d.attribute1 = l.fac_unit THEN d.actual_quantity * l.fac_price
                        when d.attribute1 = l.base_unit THEN d.actual_quantity *(l.fac_price / l.base_rate)
                        ELSE 0
                    END
                ) as cs_price1,
                (
                    h.total_amount - sum(
                        case
                            when d.attribute1 = l.fac_unit THEN d.actual_quantity * l.fac_price
                            when d.attribute1 = l.base_unit THEN d.actual_quantity *(l.fac_price / l.base_rate)
                            ELSE 0
                        END
                    )
                ) as cs_diff
            from
                ptom_consignment_lines d
                LEFT JOIN ptom_consignment_headers h ON (
                    d.consignment_header_id = h.consignment_header_id
                )
                left join (
                    select
                        l.item_id,
                        l.operand fac_price,
                        l.product_uom_code fac_unit,
                        c.base_unit_code base_unit,
                        c.conversion_rate base_rate,
                        l.operand * c.conversion_rate base_price,
                        c.base_unit base_unit_title,
                        l.start_date_active,
                        l.end_date_active
                    from
                        ptom_price_list_line_v l
                        left join ptom_price_list_head_v hv on (hv.list_header_id = l.list_header_id)
                        left join ptom_uom_conversions_v c on (l.product_uom_code = c.uom_code)
                    where
                        hv.name = 'ราคาโรงงาน'
                ) l on (d.item_id = l.item_id AND l.start_date_active <= h.consignment_date AND (l.end_date_active >= h.consignment_date  or l.end_date_active is null)) 
                LEFT JOIN ptom_order_headers p ON (d.order_header_id = p.order_header_id)
                LEFT JOIN ptom_customers e ON (p.CUSTOMER_ID = e.CUSTOMER_ID)
            where
                h.consignment_status = 'Confirm' {$sql_con}
            group by
                h.consignment_header_id,
                h.consignment_date,
                h.consignment_no,
                h.total_amount,
                p.product_type_code,
                p.customer_id,
                e.customer_name
            order by
                h.consignment_header_id asc,
                h.consignment_date asc,
                h.consignment_no asc,
                e.customer_name asc
        ";
        logger($cs_view);
        $data = DB::table(DB::raw("({$cs_view}) a"))->get();
        // return view('om.reports.omr0044.pdf.index',
        // compact('data','programCode','progTitle','progPara','remark'));
        $pdf = PDF::loadView('om.reports.omr0044.pdf.index',
                    compact('data','programCode','progTitle','progPara','remark'))
                ->setPaper('a4','landscape')
                ->setOption('header-right',"\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',13)
                ->setOption('header-spacing',3)
                ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode. '.pdf');
    }
}
