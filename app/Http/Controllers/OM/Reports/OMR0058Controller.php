<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
//use App\Models\ProgramInfo;
use DB;
use Request;
use Route;
use PDF;

class OMR0058Controller extends Controller{

    public function exportview($programCode, $request){
        $url = Request::getRequestUri();
        return view('om.reports.omr0058.index',compact('url'));
    }

	public function export($programCode, $request){
        if(isset($request["product_type"]) && $request["product_type"]!=""){
            $typecode=$request['product_type'];
        }else if(isset($request["typecode"]) && $request["typecode"]!=""){
            $typecode=$request['typecode'];
        }else{
            $typecode='';
        }
        if($typecode!=""){
            $datas=$this->create($programCode, $request);
            $pdf = PDF::loadView('om.reports.omr0058.pdf.index',$datas)
                ->setPaper('a4','landscape')
                ->setOption('header-right',"\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',13)
                ->setOption('header-spacing',3)
                ->setOption('margin-bottom', 10);
            return $pdf->stream($programCode.'.pdf');
        }else{
            $url = Request::getRequestUri();
            return view('om.reports.omr0058.index',compact('url','programCode'));
        }
    }

	public function create($programCode, $request){
        if(isset($request["product_type"]) && $request["product_type"]!=""){
            $typecode=$request['product_type'];
        }else if(isset($request["typecode"]) && $request["typecode"]!=""){
            $typecode=$request['typecode'];
        }else{
            $typecode='';
        }
        $df=$request['start_date'];
        $dt=$request['end_date'];
        $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t = date('Y-m-d',strtotime(str_replace('/','-',$dt)));
        $thDate_f = parseToDateTh($df);
        $thDate_t = parseToDateTh($dt);
        $thMonth = getMonthTh(date('M', strtotime($date_t)));

        $add_month = (date('m',strtotime(str_replace('/','-',$dt)))>9)?1:0;
        $thYear = date('Y',strtotime(str_replace('/','-',$dt)))+543+$add_month;
        $product_type=$request['product_type'];
        $remark = $request['remark'];

        //$progReport = ProgramInfo::where('program_code',$programCode)->first();
        //$progTitle = $progReport->description;
        $progTitle = "ยอดจำหน่ายบุหรี่/ยาเส้น ยสท. ประจำเดือน{$thMonth} (รต/3)";
        $progPara[0]="ปีงบประมาณ $thYear";
        $progPara[1]="ตั้งแต่วันที่ $thDate_f ถึงวันที่ $thDate_t";
        $tcode="t".$typecode;

        $sql_unit=($typecode=="10")?"  and u.UOM_CLASS='บุหรี่' ":"  and u.UOM_CLASS='ทั่วไป'";
        $units = DB::table(DB::raw("(select u.* from ptom_uom_conversions_v u where u.domestic='Y' {$sql_unit} order by uom_class) a"))->get();
        foreach($units as $unit){
            $unit_arr["title"][$unit->uom_code] = $unit->unit_of_measure;
            $unit_arr["rate"][$unit->uom_code] = $unit->conversion_rate;
            $unit_arr["base"][$unit->uom_code] = $unit->base_unit_code;
        }
        $unit_check=($typecode=="10")?"CGK":"CS1";
        $unit_check_rate = $unit_arr["rate"][$unit_check];

        // แสดงทุก ยสท.
        $item_view="select
                    distinct v.order_type_name cus_name,
                    v.order_type_id cus_id
                from PTOM_TRANSACTION_TYPES_V v
                left join ptom_so_outstanding_v d on (v.product_type_premium=d.product_type_desc)
                where d.pick_release_status='Confirm'
                    and v.sales_type = 'DOMESTIC' and v.product_type_premium is not null
                    AND start_date_active <= TO_DATE('{$date_f}', 'YYYY/MM/DD')
	            AND (end_date_active >= TO_DATE('{$date_t}', 'YYYY/MM/DD') OR end_date_active IS NULL ) ";
                    if($typecode != ''){
                        $item_view.="AND d.product_type_code = '{$typecode}' ";
                    }
                    $item_view.="order by v.order_type_name";
                //แสดงตรา ทุก ตรา
        $tb_view="
            select
                i.report_item_display item_title,
                d.promo_flag,
                i.screen_number,
                i.product_type_code,
                {sqlitem}
                sum(d.approve_quantity) qty2,
                sum(
                    CASE
                        WHEN d.uom_code='{$unit_check}' THEN d.approve_quantity
                        ELSE d.approve_quantity*u.conversion_rate/{$unit_check_rate}
                    END
                ) qty,
                sum(d.amount) amt
            from ptom_sequence_ecoms i
            left join (
                SELECT
                    d.*, pol.total_amount
                FROM
                    ptom_so_outstanding_v d
                    left join ptom_order_lines pol on pol.order_line_id = d.order_line_id
                WHERE
                    d.screen_number <> '0' ";
            if($typecode != ''){
                $tb_view.="AND d.product_type_code = '{$typecode}' ";
            }
            $tb_view.=" AND d.customer_type_id = '80'
                    AND d.pick_release_status = 'Confirm'
                    AND (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd')) ) d ON
                d.item_id = i.item_id
            left join ptom_order_headers o on o.order_header_id=d.order_header_id
            left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y' {$sql_unit})
            where i.sale_type_code = 'DOMESTIC'
            AND i.screen_number <> '0' ";
            if($typecode != ''){
                $tb_view.="AND i.product_type_code = '{$typecode}' ";
            }
            $tb_view.="AND (i.START_DATE <= to_date('{$date_f}', 'yyyy-mm-dd') OR i.START_DATE <= to_date('{$date_t}', 'yyyy-mm-dd'))
	         AND (i.END_DATE >= to_date('{$date_t}', 'yyyy-mm-dd') OR i.END_DATE IS NULL)
            group by i.report_item_display, i.product_type_code,i.screen_number,d.promo_flag
            order by i.product_type_code ,i.screen_number ASC
        ";

        $sql_item="";
        $items= DB::table(DB::raw("({$item_view}) a"))->get();
        foreach($items as $item){
            $sql_item.="
                SUM(
                    CASE WHEN d.order_type_id='{$item->cus_id}' THEN
                        CASE
                            WHEN d.uom_code='{$unit_check}' THEN d.approve_quantity
                            ELSE d.approve_quantity*u.conversion_rate/{$unit_check_rate}
                        END
                    ELSE 0 END
                ) as qty_{$item->cus_id} , ";
            if($item->cus_id == '1025') {
                $sql_item.=" SUM(CASE WHEN d.order_type_id='{$item->cus_id}' THEN d.total_amount ELSE 0 END) as amt_{$item->cus_id} , ";
            }else {
                $sql_item.=" SUM(CASE WHEN d.order_type_id='{$item->cus_id}' THEN d.amount ELSE 0 END) as amt_{$item->cus_id} , ";
            }
        }

        $data = DB::table(DB::raw("(".str_replace("{sqlitem}",$sql_item,$tb_view).") a"))->get();
        // dd($data);
        $datas=compact('typecode','items','data','programCode','progTitle','progPara','remark');
        return $datas;
    }
}
