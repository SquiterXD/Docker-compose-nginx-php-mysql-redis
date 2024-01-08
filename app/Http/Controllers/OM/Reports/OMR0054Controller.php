<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use Illuminate\Support\Facades\DB;
use Request;
use Route;
use PDF;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Offset;

class OMR0054Controller extends Controller
{

    public function exportview($programCode, $request)
    {
        $url = Request::getRequestUri();
        return view('om.reports.omr0054.index', compact('url'));
        /*
        $typecodeall=[10,20];
        foreach($typecodeall as $typecode){
            $datas[]=$this->create($programCode, $request, $typecode);
        }
        return view('om.reports.omr0054.view',compact('url','datas'));
        */

        /*
        $view = view('om.reports.omr0054.view',compact('url','datas'));
        return PDF::loadHTML($view->render(),'utf-8')->setPaper('a4','landscape')->stream("{$programCode}.pdf",array("Attachment" => true));
        */
    }

    public function export($programCode, $request)
    {
        if (isset($request["typecode"]) && $request["typecode"] != "") {
            $datas = $this->create($programCode, $request);
            $pdf = PDF::loadView('om.reports.omr0054.pdf.index', $datas)
                ->setPaper('a4', 'landscape')
                ->setOption('header-right', "\n\n\n[page]/[topage] ")
                ->setOption('header-font-name', "THSarabunNew")
                ->setOption('header-font-size', 13)
                ->setOption('header-spacing', 3)
                ->setOption('margin-bottom', 10);
            return $pdf->stream($programCode . '.pdf');
        } else {
            $url = Request::getRequestUri();
            return view('om.reports.omr0054.index', compact('url', 'programCode'));
        }
    }

    public function create($programCode, $request)
    {
        $typecode = $request['typecode'];
        $df = $request['date_f'];
        $dt = $request['date_t'];
        $date_f = date('Y-m-d', strtotime(str_replace('/', '-', $df)));
        $date_t = date('Y-m-d', strtotime(str_replace('/', '-', $dt)));
        $thDate_f = parseToDateTh($df);
        $thDate_t = parseToDateTh($dt);
        $add_month = (date('m', strtotime(str_replace('/', '-', $dt))) > 9) ? 1 : 0;
        $thYear = date('Y', strtotime(str_replace('/', '-', $dt))) + 543 + $add_month;
        $remark = $request['cs_remark'];

        $progReport = ProgramInfo::where('program_code', $programCode)->first();
        $progTitle = $progReport->description;
        $progPara[0] = "ประจำวันที่ $thDate_f ถึงวันที่ $thDate_t";
        $progPara[1] = "ปีงบประมาณ $thYear";

        $tcode = "t" . $typecode;

        $sql_unit = ($typecode == "10") ? " and u.UOM_CLASS='บุหรี่' " : " and u.UOM_CLASS='ทั่วไป'";
        $units = DB::table(DB::raw("(select u.* from ptom_uom_conversions_v u where u.domestic='Y' {$sql_unit} order by uom_class) a"))->get();
        foreach ($units as $unit) {
            $unit_arr["title"][$unit->uom_code] = $unit->unit_of_measure;
            $unit_arr["rate"][$unit->uom_code] = $unit->conversion_rate;
            $unit_arr["base"][$unit->uom_code] = $unit->base_unit_code;
        }
        $unit_check = ($typecode == "10") ? "CGK" : "CS1";
        $unit_rate = $unit_arr["rate"][$unit_check];

        $item_view = "
            select
                product_type_code item_type,
                report_item_display item_title,
                item_code,
                item_id,
                creation_date
            from ptom_sequence_ecoms
            where sale_type_code='DOMESTIC' and screen_number<>'0' and product_type_code='$typecode'
            AND (START_DATE <= to_date('{$date_f}', 'yyyy-mm-dd') OR START_DATE IS NULL)
	        AND (END_DATE >= to_date('{$date_t}', 'yyyy-mm-dd') OR END_DATE IS NULL)
            order by screen_number
        ";

        $so_view = "
            select
                c.zone_name,
                b.*
            from (
                SELECT
                    level zone_code,
                    case
                        when level=1 then '** กทม. **'
                        when level=2 then '** ฝากสโมสรยาสูบขาย **'
                        when level=3 then '** ต่างจังหวัด **'
                        else '** บุหรี่ไม่คิดมูลค่า **'
                    end zone_name
                FROM DUAL
                CONNECT BY level < 5
            ) c
            left join (
                select
                    d.pick_release_no so_no,
                    d.customer_name cus_name,
                    {sqlitem}
                    sum(
                        CASE
                            WHEN d.uom_code='{$unit_check}' THEN d.approve_quantity
                            ELSE d.approve_quantity*u.conversion_rate/{$unit_rate}
                        END
                    ) qty,
                    sum(d.amount) amt,
                    case
                        when d.province_name='กรุงเทพมหานคร' and d.customer_type_id not in (30,40,80) then 1
                        when d.customer_type_id in (30,40) then 2
                        when d.province_name<>'กรุงเทพมหานคร' and d.customer_type_id not in (30,40,80) then 3
                        when d.customer_type_id='80' then 4
                        else 5
                    end zone_code
                from ptom_so_outstanding_v d
                left join ptom_order_headers o on o.order_header_id=d.order_header_id
                left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y' {$sql_unit})
                where d.pick_release_status='Confirm'
                    -- and NVL(d.promo_flag,'N')<>'Y' and NVL(o.attribute5,'N')<>'Y'
                    and d.product_type_code='{$typecode}'
                    and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                    AND 1 = (CASE WHEN (d.customer_type_id = '30' AND d.consignment_header_id IS NOT NULL) THEN 0 ELSE 1 END)
                group by d.pick_release_no,d.customer_name,d.province_name,d.customer_type_id
                order by zone_code asc,d.pick_release_no asc
            ) b on (c.zone_code=b.zone_code)
            order by c.zone_code,b.so_no asc
            {sqlPagination}
        ";

        $sql_item = "";
        $items = DB::table(DB::raw("({$item_view}) a"))->get();
        foreach ($items as $item) {
            $sql_item .= "
                SUM(
                    CASE WHEN d.item_id='{$item->item_id}' THEN
                        CASE
                            WHEN d.uom_code='{$unit_check}' THEN d.approve_quantity
                            ELSE d.approve_quantity*u.conversion_rate/{$unit_rate}
                        END
                    ELSE 0 END
                ) as qty_" . strtotime($item->creation_date) . " ,
            ";
            $sql_item .= " SUM(CASE WHEN d.item_id='{$item->item_id}' THEN d.amount ELSE 0 END) as amt_" . strtotime($item->creation_date) . " , ";
        }
        $sql1 = str_replace("{sqlitem}", $sql_item, $so_view);
        $sql2 = str_replace("{sqlPagination}", "", $sql1);
        $data = DB::table(DB::raw("(" . $sql2 . ") a"))->get();
        $dataGoupZone = [];
        foreach ($data->where('zone_name', '** กทม. **')->groupBy('zone_name') as $group => $lines) {
            $dataGoupZone[0][$group] = $lines;
        }
        $sql1 = str_replace("{sqlitem}", $sql_item, $so_view);
        $sql2 = str_replace("{sqlPagination}", "", $sql1);
        $dataC = DB::table(DB::raw("(" . $sql2 . ") a"))->count();
        $limit = 15;
        $pagenum = ceil($dataC / $limit);
        if ($pagenum < 1) $pagenum = 1;

        for ($i = 0; $i < $pagenum; $i++) {
            $sql1 = str_replace("{sqlitem}", $sql_item, $so_view);
            $sql2 = str_replace("{sqlPagination}", "OFFSET " . ($i * $limit) . " ROWS FETCH NEXT " . $limit . " ROWS ONLY", $sql1);
            $data2 = DB::table(DB::raw("(" . $sql2 . ") a"))->get();
            foreach ($data2->where('zone_name', '!=', '** กทม. **')->groupBy('zone_name') as $group => $lines) {
                $dataGoupZone[($i + 1)][$group] = $lines;
            }
        }

        $datas = compact('typecode', 'items', 'data', 'programCode', 'progTitle', 'progPara', 'remark', 'dataGoupZone', 'pagenum');
        return $datas;
    }
}
