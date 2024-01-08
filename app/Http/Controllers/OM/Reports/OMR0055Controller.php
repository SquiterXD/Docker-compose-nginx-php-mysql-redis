<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class OMR0055Controller extends Controller
{
    public function export($programCode, $request)
    {
        $datas = $this->create($programCode, $request);
        $pdf = PDF::loadView('om.reports.omr0055.pdf.index', $datas)
            ->setPaper('a4', 'landscape')
            ->setOption('header-right', "\n\n\n[page]/[topage] ")
            ->setOption('header-font-name', "THSarabunNew")
            ->setOption('header-font-size', 13)
            ->setOption('header-spacing', 3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode . '.pdf');
    }

    public function create($programCode, $request)
    {
        $df = $request['start_date'];
        $dt = $request['end_date'];
        $date_f = date('Y-m-d', strtotime(str_replace('/', '-', $df)));
        $date_t = date('Y-m-d', strtotime(str_replace('/', '-', $dt)));
        $thDate_f = parseToDateTh($df);
        $thDate_t = parseToDateTh($dt);
        $add_month = (date('m', strtotime(str_replace('/', '-', $dt))) > 9) ? 1 : 0;
        $thYear = date('Y', strtotime(str_replace('/', '-', $dt))) + 543 + $add_month;
        $remark = "";

        $progReport = ProgramInfo::where('program_code', $programCode)->first();
        $progTitle = $progReport->description;
        $progPara[0] = "ตั้งแต่วันที่ $thDate_f ถึงวันที่ $thDate_t";
        $progPara[1] = "ปีงบประมาณ $thYear";

        $unit_cg = "CGK";
        $unit_e = "CS1";
        $units = DB::table(DB::raw("(select * from ptom_uom_conversions_v where domestic='Y' order by uom_class) a"))->get();
        foreach ($units as $unit) {
            $unit_arr["title"][$unit->uom_code] = $unit->unit_of_measure;
            $unit_arr["rate"][$unit->uom_code] = $unit->conversion_rate;
            $unit_arr["base"][$unit->uom_code] = $unit->base_unit_code;
        }
        $progUnit[0] = $unit_arr["title"][$unit_cg]; // บุหรี่
        $progUnit[1] = $unit_arr["title"][$unit_e];  // ยาเส้น

        $item_view = "
            select
                product_type_code item_type,
                report_item_display item_title,
                item_code,
                item_id,
                creation_date
            from ptom_sequence_ecoms
            where sale_type_code='DOMESTIC' and screen_number<>0
            order by product_type_code,screen_number
        ";

        $tb_view = "
            select
                CASE
                    WHEN d.consignment_no<>'' and d.product_type_code='10' and d.consignment_status='Confirm' THEN d.consignment_no
                    ELSE d.pick_release_no
                END as so_no,
                d.customer_name cus_name,

                {sqlitem}

                sum(
                    case when d.product_type_code='10' then
                        case when d.consignment_no<>'' and d.consignment_status='Confirm' then
                            CASE
                                WHEN d.consignment_uom_code='{$unit_cg}' THEN (d.consignment_quantity)
                                ELSE (d.consignment_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                            END
                        else
                            CASE
                                WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                                ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                            END
                        end
                    else 0 end
                ) as qty1_10,
                sum(
                    case when d.product_type_code='10' then
                        CASE
                            WHEN d.uom_code='{$unit_cg}' THEN d.order_quantity
                            ELSE d.order_quantity*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                        END
                    else 0 end
                ) as qty2_10,
                sum(
                    case when d.product_type_code='20' then
                        CASE
                            WHEN d.uom_code='{$unit_e}' THEN d.approve_quantity
                            ELSE d.approve_quantity*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                        END
                    else 0 end
                ) as qty1_20,
                sum(
                    case when d.product_type_code='20' then
                        CASE
                            WHEN d.uom_code='{$unit_e}' THEN d.order_quantity
                            ELSE d.order_quantity*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                        END
                    else 0 end
                ) as qty2_20,

                sum(case when d.product_type_code='10' then d.amount else 0 end) as amt1_10,
                sum(case when d.product_type_code='10' then d.consignment_amount else 0 end) as amt2_10,
                sum(case when d.product_type_code='20' then d.amount else 0 end) as amt1_20,
                sum(case when d.product_type_code='20' then d.consignment_amount else 0 end) as amt2_20,

                sum(d.amount) amt1,
                sum(d.consignment_amount) amt2,

                case  when d.province_code='10' then 'ไม่อบจ.' else 'อบจ.' end g1,
                max('บุหรี่ไม่คิดมูลค่า') g2
            from ptom_so_outstanding_v d
            left join ptom_order_headers o on o.order_header_id=d.order_header_id
            left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y')
            where d.pick_release_status='Confirm'
                -- and NVL(d.promo_flag,'N')<>'Y' and NVL(o.attribute5,'N')<>'Y'
                and d.customer_type_id='80'
                and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
            group by
                CASE WHEN d.consignment_no<>'' and d.product_type_code='10' and d.consignment_status='Confirm' THEN d.consignment_no ELSE d.pick_release_no END,
                d.customer_name,
                case when d.province_code='10' then 'ไม่อบจ.' else 'อบจ.' end
            order by CASE WHEN d.consignment_no<>'' and d.product_type_code='10' and d.consignment_status='Confirm' THEN d.consignment_no ELSE d.pick_release_no END
        ";

        $sql_item = "";
        $items = DB::table(DB::raw("({$item_view}) a"))->get();
        foreach ($items as $item) {
            $sql_item .= "
                SUM(
                    CASE
                        WHEN d.item_id='{$item->item_id}' THEN
                            CASE
                                WHEN d.product_type_code='10' THEN
                                    case when d.consignment_no<>'' and d.consignment_status='Confirm' then
                                        CASE
                                            WHEN d.consignment_uom_code='{$unit_cg}' THEN (d.consignment_quantity)
                                            ELSE (d.consignment_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                        END
                                    else
                                        CASE
                                            WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                                            ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                        END
                                    end
                                ELSE
                                    CASE
                                        WHEN d.uom_code='{$unit_e}' THEN (d.approve_quantity)
                                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                                    END
                            END
                        ELSE 0
                    END
                ) as qty1_" . strtotime($item->creation_date) . " ,
            ";
            $sql_item .= "
                SUM(
                    CASE
                        WHEN d.item_id='{$item->item_id}' THEN
                            CASE
                                WHEN d.product_type_code='10' THEN
                                    CASE
                                        WHEN d.uom_code='{$unit_cg}' THEN d.order_quantity
                                        ELSE d.order_quantity*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                    END
                                ELSE
                                    CASE
                                        WHEN d.uom_code='{$unit_e}' THEN d.order_quantity
                                        ELSE d.order_quantity*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                                    END
                            END
                        ELSE 0
                    END
                ) as qty2_" . strtotime($item->creation_date) . " ,
            ";
        }
        $data = DB::table(DB::raw("(" . str_replace("{sqlitem}", $sql_item, $tb_view) . ") a"))->get();
        $datas = compact('items', 'data', 'programCode', 'progTitle', 'progPara', 'remark');
        return $datas;
    }
}
