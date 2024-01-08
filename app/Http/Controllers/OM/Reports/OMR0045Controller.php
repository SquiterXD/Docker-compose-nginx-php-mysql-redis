<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use Request;
use Route;
use PDF;

class OMR0045Controller extends Controller{
	public function export($programCode, $request){
        if(isset($request["typecode"]) && $request["typecode"]!=""){
            $datas=$this->create($programCode, $request);
            // return view('om.reports.omr0045.pdf.index',$datas);
            $pdf = PDF::loadView('om.reports.omr0045.pdf.index',$datas)
                ->setPaper('a4','landscape')
                ->setOption('header-right',"\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',13)
                ->setOption('header-spacing',3)
                ->setOption('margin-bottom', 10);
            return $pdf->stream($programCode.'.pdf');
        }else{
            $url = Request::getRequestUri();
            return view('om.reports.omr0045.index',compact('url','programCode'));
        }
    }

	public function create($programCode, $request){
        $typecode=$request['typecode'];
        $tcode="t".$typecode;

        $df=(isset($request['date_f']) && $request['date_f']!="")?$request['date_f']:date('Y-m-d');
        $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $thDate_f = parseToDateTh($df);
        $add_month = (date('m',strtotime(str_replace('/','-',$df)))>9)?1:0;
        $thYear = date('Y',strtotime(str_replace('/','-',$df)))+543+$add_month;
        $remark = $request['cs_remark'];
        $getRMA = (new OMR0060Controller)->getRMA(['start'=> $date_f, 'end' => $date_f]);
        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;
        $progPara[0]="ประจำวันที่ $thDate_f";
        $progPara[1]="ปีงบประมาณ $thYear";

        $sql_unit=($typecode=="10")?" ":" and u.UOM_CLASS='ทั่วไป'";
        $units = DB::table(DB::raw("(select u.* from ptom_uom_conversions_v u where u.domestic='Y' {$sql_unit} order by uom_class) a"))->get();
        foreach($units as $unit){
            $unit_arr["title"][$unit->uom_code] = $unit->unit_of_measure;
            $unit_arr["rate"][$unit->uom_code] = $unit->conversion_rate;
            $unit_arr["base"][$unit->uom_code] = $unit->base_unit_code;
        }
        $unit_check=($typecode=="10")?"CGK":"CS1";
        $unit_rate=$unit_arr["rate"][$unit_check];

        $progUnit=['t10'=>'จำนวนพันมวน<br>(บุหรี่)','t20'=>'จำนวนหีบ<br>(ยาเส้น)'];
        $sql_t["t10"]="
            SELECT
                level zone_code,
                case
                    when level=1 then 'ยอดขาย(ฝากสโมสรขาย)'
                    when level=2 then 'ยอดขายบุหรี่'
                    when level=3 then 'ยอดขาย(บุหรี่ไม่คิดมูลค่า)'
                    else '-'
                end zone_name
            FROM DUAL
            CONNECT BY level < 4
        ";

        $sql_t["t20"]="
            SELECT
                level zone_code,
                case
                    when level=1 then 'ยอดขายยาเส้น'
                    when level=2 then 'ยอดขายยาเส้นไม่คิดมูลค่า'
                else '-'
            end zone_name
            FROM DUAL
            CONNECT BY level < 3
        ";

        $sql_add=$sql_t[$tcode];
        $tb_view="
            select
                c.zone_name,
                b.*
                ,poh.tax tax_order_header
                ,poh.order_status
                ,poh.attribute6
                ,css.ship_to_site_name
            from (
                {$sql_t[$tcode]}
            ) c
            left join (
                select
                    cd.so_no,
                    cd.svat_group_code,
                    cd.pick_release_no,
                    cd.orderid,
                    sum(cd.tax_amount) tax_amount,
                    cd.cus_name,
                    cd.customer_number,
                    cd.tax_no,
                    sum(qty) qty,
                    sum(amt) amt,
                    cd.branch,
                    sum(cd.retail_amount) sale_amt,

                     --sum(qty*(
                    --   case
                    --        when cd.unit_code=l.sale_unit THEN l.sale_price
                    --        when cd.unit_code=l.base_unit THEN (l.sale_price/l.base_rate)
                    --        ELSE 0
                    --    end
                    -- )) sale_amt,

                    cd.zone_code
                from (
                    select
                        d.item_id,
                        d.tax_amount,
                        d.svat_group_code,
                        d.retail_amount,
                        d.pick_release_no,
                        d.customer_number,
                        d.customer_name cus_name,
                        case
                            when d.consignment_header_id is not null then d.consignment_no
                            else d.pick_release_no
                        end so_no,
                        case
                            when d.consignment_header_id is not null then d.consignment_header_id
                            else d.order_header_id
                        end orderid,
                         -- c.customer_name cus_name,
                        c.taxpayer_id tax_no,
                        case
                            when d.product_type_code='10' and d.consignment_header_id is not null then d.consignment_quantity
                            when d.product_type_code='10' and d.consignment_header_id is null  then d.approve_quantity
                            when d.product_type_code='20' then
                                CASE
                                    WHEN d.uom_code='{$unit_check}' THEN d.approve_quantity
                                    ELSE d.approve_quantity*u.conversion_rate/{$unit_rate}
                                END
                            else 0
                        end qty,
                        case
                            when d.product_type_code='10' and d.consignment_header_id is not null then d.consignment_uom_code
                            else d.uom_code
                        end unit_code,
                        case
                            when d.product_type_code='10' and d.consignment_header_id is not null then d.consignment_amount
                            else d.amount
                        end amt,
                        case
                            when c.head_office_flag='y' then 'สำนักงานใหญ่'
                            else c.branch
                        end branch,
                        case
                            when d.customer_type_id in (30,40) and d.product_type_code='10' AND consignment_header_id is not null then 1
                            when d.customer_type_id not in (30,40,80) and d.product_type_code='10' then 2
                            when d.customer_type_id='80' and d.product_type_code='10' then 3
                            when d.customer_type_id<>'80' and d.product_type_code='20' then 1
                            when d.customer_type_id='80' and d.product_type_code='20' then 2
                            else 0
                        end zone_code,
                        consignment_date,
                        NVL(consignment_date,trunc(d.pick_release_approve_date)) c_date
                    from ptom_so_outstanding_v d
                    left join ptom_customers c on (c.customer_id=d.customer_id)
                    left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y' {$sql_unit})
                    where 1=1
                        and d.product_type_code='{$typecode}'
                        and NVL(consignment_date,trunc(d.pick_release_approve_date))=to_date('{$date_f}','yyyy-mm-dd')
                ) cd
                left join (
                    select
                        l.item_id,l.operand sale_price,l.product_uom_code sale_unit,
                        c.base_unit_code base_unit,
                        c.conversion_rate base_rate,
                        l.operand*c.conversion_rate base_price,
                        c.base_unit base_unit_title,
                        l.start_date_active,
                        l.end_date_active
                    from ptom_price_list_line_v l
                    left join ptom_price_list_head_v h on (h.list_header_id=l.list_header_id)
                    left join ptom_uom_conversions_v c on (l.product_uom_code=c.uom_code)
                    where h.name='ราคาขายปลีก'
                ) l on (cd.item_id=l.item_id and l.sale_unit=cd.unit_code AND l.start_date_active <= cd.c_date AND (l.end_date_active >= cd.c_date))
                group by so_no,orderid,cus_name,tax_no,branch,zone_code,consignment_date, svat_group_code, pick_release_no, cd.customer_number
                order by zone_code asc
            ) b on (c.zone_code=b.zone_code)
            left join ptom_order_headers poh on b.pick_release_no = poh.pick_release_no 
            left join PTOM_CUSTOMER_SHIP_SITES css on css.ship_to_site_id = poh.ship_to_site_id
            WHERE poh.order_status != 'Cancelled'
            order by c.zone_code,b.so_no
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();
        
        $datas=compact('typecode','data','programCode','progUnit','progTitle','progPara','remark', 'getRMA');
        return $datas;
    }
}
