<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use Carbon\Carbon;
use DB;
use Request;
use Route;
use PDF;

class OMR0025Controller extends Controller{
	public function export($programCode, $request){
        $datas=$this->create($programCode, $request);
        // return view('om.reports.omr0025.pdf.index',$datas);
        $pdf = PDF::loadView('om.reports.omr0025.pdf.index',$datas)
            ->setPaper('a4','landscape')
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',13)
            ->setOption('header-spacing',3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode.'.pdf');
    }

	public function create($programCode, $request){

        $df=(isset($request['start_date']) && $request['start_date']!="")?$request['start_date']:date('Y-m-d');
        $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t =  $date_f;
        $thDate_f = parseToDateTh($df);

        $getRMA = (new OMR0060Controller)->getRMA(['start'=> $date_f, 'end' => $date_t]);
        $rmaByCusType = $getRMA->groupBy('customer.customer_type_id');
        $date_f_start = Carbon::createFromFormat('Y-m-d', $date_f)->clone()->startOfMonth()->format('Y-m-d');
        $getRMAMonth = (new OMR0060Controller)->getRMA(['start'=> $date_f_start, 'end' => $date_t]);
        $rmaMonthByCusType = $getRMA->groupBy('customer.customer_type_id');

        if( Carbon::createFromFormat('Y-m-d', $date_f)->clone()->format('m') < 10) {
            $getRMAYear = (new OMR0060Controller)->getRMA(['start'=> Carbon::createFromFormat('Y-m-d', $date_f)->subYear(1)->clone()->format('Y-m-d'), 'end' => $date_t]);
        } else {
            $getRMAYear = (new OMR0060Controller)->getRMA(['start'=> Carbon::createFromFormat('Y-m-d', $date_f)->clone()->format('Y-m-d'), 'end' => $date_t]);
        }
        $rmaRemark = '';
        if(count($getRMAYear) > 0 ) {
            $rmaRemark = 'เลขที่ใบลดหนี้ ' . $getRMAYear->pluck('credit_note_number')->join(', ');

        }
        $rmaYearByCusType = $getRMAYear->groupBy('customer.customer_type_id');
        $month_f = date('m',strtotime(str_replace('/','-',$df)));
        /* comment v1 >> ตรงปีพ.ศ. ให้เพิ่มเงื่อนไขว่า หากเป็น OCT,NOV,DEC นำ พ.ศ. ไป +1  */
        $add_month = ($month_f>9)?1:0;
        $year_f = date('Y',strtotime(str_replace('/','-',$df)));
        $year_t = date('Y',strtotime(str_replace('/','-',$df)))+$add_month;
        $year_l = date('Y',strtotime(str_replace('/','-',$df)))+$add_month-1;
        $thYear_f = $year_f+543;
        $thYear_t = $year_t+543;
        $thYear_l = $year_l+543;
        $thYear = $thYear_f;

        $remark = $request['remark'];
        $sum_1="รวม ตั้งแต่วันที่ 1/{$month_f}/{$thYear_f}";
        $sum_2="รวม ตั้งแต่วันที่ 1/10/{$thYear_l}";

        $customer_type_id = $request['customer_type_id'];
        $remark = $request['note'];

        $unit_cg="CGK";
        $unit_e="CS1";
        $units = DB::table(DB::raw("(select * from ptom_uom_conversions_v where domestic='Y' order by uom_class) a"))->get();
        foreach($units as $u){
            $unit_arr["title"][$u->uom_code]= $u->unit_of_measure;
            $unit_arr["rate"][$u->uom_code] = $u->conversion_rate;
            $unit_arr["base"][$u->uom_code] = $u->base_unit_code;
        }
        $progUnit[0] = $unit_arr["title"][$unit_cg]; // บุหรี่ พันมวน
        $progUnit[1] = $unit_arr["title"][$unit_e];  // ยาเส้น หีบ

        function getColumn($id,$name,$condition,$pro_type_id,$unit_x,$unit_rate,$date_f,$date_t){
            $col_s=array();
            $col_c=array();
            $col=array();
            $sq ="
                select
                    distinct v.{$name} b,
                    v.{$id} a
                from PTOM_TRANSACTION_TYPES_V v
                left join ptom_so_outstanding_v d on (v.product_type_premium=d.product_type_desc)
                where d.pick_release_status='Confirm'
                AND (v.START_DATE_ACTIVE <= to_date('{$date_f}','yyyy-mm-dd')
                    OR v.START_DATE_ACTIVE IS NULL)
                AND (v.END_DATE_ACTIVE >= to_date('{$date_t}','yyyy-mm-dd')
                    OR v.END_DATE_ACTIVE IS NULL)
                    and v.sales_type = 'DOMESTIC' and v.product_type_premium is not null
                    {$condition}
                    and d.product_type_code='{$pro_type_id}'
                order by v.{$name}
            ";
            $sq_10 ="
                select  v.*
                from PTOM_TRANSACTION_TYPES_V v
                left join ptom_so_outstanding_v d on (d.product_type_premium=v.product_type_desc)
                where v.sales_type = 'DOMESTIC' and v.product_type_premium is not null
            ";
            $cus = DB::table(DB::raw("({$sq}) c"))->get();
            foreach($cus as $row){
                $s="
                    SUM(
                        CASE WHEN  d.{$id}='".$row->a."'
                        THEN
                            CASE
                                WHEN d.uom_code='{$unit_x}' THEN d.approve_quantity
                                ELSE d.approve_quantity*u.conversion_rate/{$unit_rate}
                            END
                        ELSE 0 END
                    )
                ";
                array_push($col_s,$s);
                array_push($col_c,$row->b);
            }
            $col['sel']=$col_s;
            $col['col']=$col_c;
            return $col;
        }

        $sql_con =" and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))";
        $sql_con30 =" and (trunc(d.consignment_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))";

        $col7=getColumn("order_type_id","order_type_name"," and d.customer_type_id='80' ",10,$unit_cg,$unit_arr["rate"][$unit_cg],$date_f,$date_t);
        $col8=getColumn("order_type_id","order_type_name"," and d.customer_type_id='80' ",20,$unit_e,$unit_arr["rate"][$unit_e],$date_f,$date_t);

        $custype[0] = ['customer_type_id' => '10'];
        $custype[1] = ['customer_type_id' => '30,40'];
        $custype[2] = ['customer_type_id' => '50'];
        $custype[3] = ['customer_type_id' => '60'];
        $custype[4] = ['customer_type_id' => '70'];
        $custype[5] = ['customer_type_id' => '20'];
        $custype[6] = ['customer_type_id' => '10'];
        $custype[7] = ['customer_type_id' => '10'];
        $custype[8] = ['customer_type_id' => '80'];
        $custype[8] = ['customer_type_id' => '80'];
        // title ใช้ customer_type_meaning มาแสดงชื่อกลุ่มลูกค้า
        $groups["title"][0]="ยอดจำหน่าย กลุ่มร้านค้า ป.1"; //product_type_code=10 A customer_type_id=10 (กทม provence_code=10,ตจว. provence_code<>10)
        $groups["title"][1]="ยอดจำหน่าย กลุ่มร้านค้าสโมสรยาสูบ"; //product_type_code=10 C customer_type_id=30,40 (สโมสรกรุงเทพ 30 , ภูมิภาค 40 consignment_quantity)

        $groups["title"][2]="ยอดจำหน่าย กลุ่มร้านค้า ป.2"; //product_type_code=10 D customer_type_id=50
        $groups["title"][3]="ยอดจำหน่าย กลุ่มขายพนักงาน"; //product_type_code=10 E customer_type_id=60
        $groups["title"][4]="ยอดจำหน่าย กลุ่มลูกค้าขายปลีก"; //product_type_code=10 F customer_type_id=70
        // ย้ายจาก 2 มา 5
        $groups["title"][5]="ยอดจำหน่าย กลุ่ม Modern trade"; //product_type_code=10 B customer_type_id=20

        $groups["title"][6]="ยอดจำหน่าย กลุ่มร้านค้ายาเส้น"; //product_type_code=20 G  customer_type_id แยกเหมือนกับ 10
        $groups["title"][7]="ยอดจำหน่าย กลุ่มร้านค้ายาเส้น"; //product_type_code=20 G  customer_type_id แยกเหมือนกับ 10
        $groups["title"][8]="ยอดจำหน่าย กลุ่มส่งเสริมไม่คิดมูลค่า"; //product_type_code=10 H  customer_type_id=80 (แสดง order_type_name ยสท 1,2,8)
        $groups["title"][9]="ยอดจำหน่าย กลุ่มส่งเสริมไม่คิดมูลค่า"; //product_type_code=20 I  customer_type_id=80 (แสดง order_type_name ยสท 1 (ยาเส้นผลิตเอง))

        $groups["col"][0]=['เขต กทม.','เขต ตจว.','รวม']; // A
        $groups["col"][1]=['สโมสรกรุงเทพ','สโมสรภูมิภาค','รวม']; // C (สโมสรกรุงเทพ 30 approve_quantity , ภูมิภาค 40 consignment_quantity)

        $groups["col"][2]=['ร้านค้า ป.2','รวม'];// D -- ไม่มีไม่ต้องแสดง customer_type_id=50
        $groups["col"][3]=['ขายพนักงาน','รวม']; // E -- ไม่มีไม่ต้องแสดง customer_type_id=60
        $groups["col"][4]=['ลูกค้าขายปลีก','รวม']; // F -- ไม่มีไม่ต้องแสดง customer_type_id=70
        // ย้ายจาก 2 มา 5
        $groups["col"][5]=['Modern Trade','รวม','รวม (บุหรี่)',$sum_1,$sum_2]; // B customer_type_id=20

        $groups["col"][6]=['เขต กทม.','เขต ตจว.','สโมสรกรุงเทพ','สโมสรภูมิภาค','ร้านค้า ป.2','Modern Trade','รวม'];;// G
        $groups["col"][7]=['ขายพนักงาน','ลูกค้าขายปลีก','รวม','รวม (ยาเส้น)',$sum_1,$sum_2];;// G
        $groups["col"][8]=array_merge($col7["col"],['รวม','รวม (บุหรี่)',$sum_1,$sum_2]); // H customer_type_id=80 , product_type_code=10
        $groups["col"][9]=array_merge($col8["col"],['รวม','รวม (ยาเส้น)',$sum_1,$sum_2]);// I customer_type_id=80 , product_type_code=20

        // A product_type_code=10 customer_type_id=10
        $groups["select"][0]=[
            " SUM(
                CASE WHEN d.province_code=10
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.province_code<>10
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) ",
            " SUM(NVL(d.approve_quantity,0)) "
        ];
        // C product_type_code=10 customer_type_id=30,40 (สโมสรกรุงเทพ 30 , ภูมิภาค 40 consignment_quantity)
        $groups["select"][1]=[
            " SUM(
                CASE WHEN d.customer_type_id=30
                THEN
                    CASE
                        WHEN d.consignment_uom_code='{$unit_cg}' THEN nvl(d.consignment_quantity,0)
                        ELSE nvl(d.consignment_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=40
                THEN
                    CASE
                        WHEN d.consignment_uom_code='{$unit_cg}' THEN nvl(d.consignment_quantity,0)
                        ELSE nvl(d.consignment_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id in (30,40)
                THEN
                    CASE
                        WHEN d.consignment_uom_code='{$unit_cg}' THEN nvl(d.consignment_quantity,0)
                        ELSE nvl(d.consignment_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) "
        ];

        // D product_type_code=10 , customer_type_id=50 -- ไม่มีไม่ต้องแสดง
        $groups["select"][2]=[
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='50'
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='50'
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) "
        ];
        // E product_type_code=10 , customer_type_id=60 -- ไม่มีไม่ต้องแสดง
        $groups["select"][3]=[
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='60'
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) ",
            " SUM(CASE WHEN d.product_type_code='10' and d.customer_type_id='60' THEN d.approve_quantity ELSE 0 END) "
        ];
        // F product_type_code=10 , customer_type_id=70 -- ไม่มีไม่ต้องแสดง
        $groups["select"][4]=[
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='70'
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='70'
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
            ) "
        ];
        // ย้ายจาก 2 มา 5
        // B product_type_code=10  customer_type_id=20
        $groups["select"][5]=[
            " SUM(
                CASE WHEN d.customer_type_id ='20' and d.pick_release_status='Confirm'
                    and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
              )
            ",
            " SUM(
                CASE WHEN d.customer_type_id ='20' and d.pick_release_status='Confirm'
                    and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                        ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END
              )
            ",
            " SUM(
                case
                    when d.customer_type_id in (30,40) and d.consignment_status='Confirm'
                        and (trunc(d.consignment_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                    then
                        CASE
                            WHEN d.consignment_uom_code='{$unit_cg}' THEN nvl(d.consignment_quantity,0)
                            ELSE nvl(d.consignment_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                        END
                    else
                        CASE
                            WHEN d.customer_type_id not in (30,40) and d.pick_release_status='Confirm'
                                and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                            THEN
                                CASE
                                    WHEN d.uom_code='{$unit_cg}' THEN nvl(d.approve_quantity,0)
                                    ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                END
                            ELSE 0
                        END
                end
              )
            ",
                " SUM(
                    CASE WHEN d.product_type_code = '10' 
                    THEN  
                        CASE 
                            WHEN d.customer_type_id = '10'
                            THEN 
                                d.amount
                            WHEN d.customer_type_id = '20'
                            THEN 
                                d.amount
                            WHEN d.customer_type_id IN ('30', '40')
                            THEN
                                d.consignment_amount
                            WHEN d.customer_type_id = '60'
                            THEN
                                d.amount
                            WHEN d.customer_type_id = '70'
                            THEN
                                d.amount
                            ELSE 0 END
                    ELSE 0 END
                ) new_qty,
                SUM(
                    CASE WHEN (d.product_type_code = '10' AND trunc(d.pick_release_approve_date) between to_date('{$year_f}-{$month_f}-01','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                    THEN  
                        CASE 
                            WHEN d.customer_type_id = '10'
                            THEN 
                                d.amount
                            WHEN d.customer_type_id = '20'
                            THEN 
                                d.amount
                            WHEN d.customer_type_id IN ('30', '40')
                            THEN
                                d.consignment_amount
                            WHEN d.customer_type_id = '60'
                            THEN
                                d.amount
                            WHEN d.customer_type_id = '70'
                            THEN
                                d.amount
                            ELSE 0 END
                    ELSE 0 END
                ) new_qty2
                , SUM(
                    case
                        when d.customer_type_id in (30,40) and d.consignment_status='Confirm'
                            and (trunc(d.consignment_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                        then
                            CASE
                                WHEN d.consignment_uom_code='{$unit_cg}' THEN nvl(d.consignment_quantity,0)
                                ELSE nvl(d.consignment_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                            END
                        else
                            CASE
                                WHEN d.customer_type_id not in (30,40) and d.pick_release_status='Confirm'
                                    and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                                THEN
                                    CASE
                                        WHEN d.uom_code='{$unit_cg}' THEN nvl(d.approve_quantity,0)
                                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                    END
                                ELSE 0
                            END
                    end
                  )",
            " SUM(CASE WHEN
                 (trunc(d.pick_release_approve_date) between to_date('{$year_l}-10-01','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END)
            "
        ];
        // G product_type_code=20 customer_type_id=10,20,30,40,50
        $groups["select"][6]=[
            " SUM(
                CASE WHEN d.customer_type_id=10 and d.province_code=10
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=10 and d.province_code<>10
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=30
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=40
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=50
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=20
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id in (10,20,30,40,50)
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) "
        ];

        // G product_type_code=20 customer_type_id=60,70
        $groups["select"][7]=[
            " SUM(
                CASE WHEN d.customer_type_id=60
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=70
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id in (60,70)
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END
            ) ",
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                    ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                END
            ) ",
            " SUM(CASE WHEN
                 (trunc(d.pick_release_approve_date) between to_date('{$year_f}-{$month_f}-01','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END)",
            " SUM(CASE WHEN
                 (trunc(d.pick_release_approve_date) between to_date('{$year_l}-10-01','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                    END
                ELSE 0 END)
            "
        ];

        // H product_type_code=10 customer_type_id=80
        $groups["select"][8]=array_merge($col7["sel"],[
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_cg}' THEN nvl(d.approve_quantity,0)
                    ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                END
            ) ",
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_cg}' THEN nvl(d.approve_quantity,0)
                    ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                END
            ) ",
            " SUM(CASE WHEN
                 (trunc(d.pick_release_approve_date) between to_date('{$year_f}-{$month_f}-01','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END)",
            " SUM(CASE WHEN
                 (trunc(d.pick_release_approve_date) between to_date('{$year_l}-10-01','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    CASE
                        WHEN d.uom_code='{$unit_cg}' THEN nvl(d.approve_quantity,0)
                        ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                    END
                ELSE 0 END)
            "
        ]);
        // I product_type_code=20 customer_type_id=80
        $groups["select"][9]=array_merge($col8["sel"],[
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                    ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                END
            ) ",
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                    ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                END
            ) ",
            " SUM(CASE WHEN
            (trunc(d.pick_release_approve_date) between to_date('{$year_f}-{$month_f}-01','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
           THEN
               CASE
                   WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                   ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
               END
           ELSE 0 END)",
       " SUM(CASE WHEN
            (trunc(d.pick_release_approve_date) between to_date('{$year_l}-10-01','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
           THEN
               CASE
                   WHEN d.uom_code='{$unit_e}' THEN nvl(d.approve_quantity,0)
                   ELSE nvl(d.approve_quantity,0)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
               END
           ELSE 0 END)
       "
        ]);

        $groups["where"][0]="
            and d.product_type_code='10' and d.customer_type_id='10'
            and d.pick_release_status='Confirm'
            and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";
        $groups["where"][1]="
            and d.product_type_code='10' and d.customer_type_id in (30,40)
            and d.consignment_status='Confirm'
            and (trunc(d.consignment_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";

        $groups["where"][2]="
            and d.product_type_code='10' and d.customer_type_id ='50'
            and d.pick_release_status='Confirm'
            and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";
        $groups["where"][3]="
            and d.product_type_code='10' and d.customer_type_id ='60'
            and d.pick_release_status='Confirm'
            and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";
        $groups["where"][4]="
            and d.product_type_code='10' and d.customer_type_id ='70'
            and d.pick_release_status='Confirm'
            and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";
        // ย้ายจาก 2 มา 5 มีช่องรวมทั้งหมดของบุหรี่
        $groups["where"][5]="
            and d.product_type_code='10' and d.customer_type_id in (10,20,30,40,50,60,70)
            and
            (
                (
                    (nvl(consignment_date ,trunc(pick_release_approve_date)) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                )
            )
        ";

        $groups["where"][6]="
            and d.product_type_code='20' and d.customer_type_id <>'80'
            and d.pick_release_status='Confirm'
            and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";

        $groups["where"][7]="
            and d.product_type_code='20' and d.customer_type_id <>'80'
            and d.pick_release_status='Confirm'
            and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";

        $groups["where"][8]="
            and d.product_type_code='10' and d.customer_type_id ='80'
            and d.pick_release_status='Confirm'
            and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";
        $groups["where"][9]="
            and d.product_type_code='20' and d.customer_type_id ='80'
            and d.pick_release_status='Confirm'
            and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
        ";

        $groups["product_type_code"][0] = " AND h.product_type_code = '10' ";
        $groups["product_type_code"][1] = " AND h.product_type_code = '10' ";
        $groups["product_type_code"][2] = " AND h.product_type_code = '10' ";
        $groups["product_type_code"][3] = " AND h.product_type_code = '10' ";
        $groups["product_type_code"][4] = " AND h.product_type_code = '10' ";
        $groups["product_type_code"][5] = " AND h.product_type_code = '10' ";
        $groups["product_type_code"][6] = " AND h.product_type_code = '20' ";
        $groups["product_type_code"][7] = " AND h.product_type_code = '20' ";
        $groups["product_type_code"][8] = " AND h.product_type_code = '10' ";
        $groups["product_type_code"][9] = " AND h.product_type_code = '20' ";

        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;

        $j=0;
        foreach($groups["col"] as $key=>$group){

            $sql_con=($customer_type_id!='')?" and d.customer_type_id='$customer_type_id' ":"";

            if(in_array($key, [5,7,8,9])) {
                // $sql_con =" and d.customer_type_id='20' ";
                    $tb_view="
                        select
                            {sqlitem}
                            max(d.unit_price) price,
                            h.report_item_display item_title,
                            h.screen_number
                        from ptom_sequence_ecoms h
                        left join (
                            select
                                d.*
                            from ptom_so_outstanding_v d
                            where d.screen_number<>'0'
                                and d.customer_type_id='20' 
                                ".$groups["where"][$key]."
                        ) d on d.item_id=h.item_id
                        left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y')
                        where h.sale_type_code='DOMESTIC'
                        AND h.screen_number<>'0'
                        ".$groups["product_type_code"][$key] ."
                        AND (h.START_DATE <= to_date('{$date_f}', 'yyyy-mm-dd') OR h.START_DATE IS NULL)
                        AND (h.END_DATE >= to_date('{$date_t}', 'yyyy-mm-dd') OR h.END_DATE IS NULL)
                        group by h.item_id,h.product_type_code,h.screen_number,h.report_item_display
                        order by h.product_type_code,h.screen_number
                    ";
                    $sql_item="";
                    $i=0;
                    foreach($groups["col"][$key] as $item){
                        $sql_item.=$groups["select"][$key][$i]." as qty_{$i} , ";
                        $i++;
                    }
                    $dd2 = DB::table(DB::raw("(".str_replace("{sqlitem}",$sql_item,$tb_view).") aa"))->get();
                    
                $date_start_i_5 =Carbon::createFromFormat('Y-m-d', $date_f)->startOfMonth()->format('Y-m-d'); 
                if($key== 5) {
                    $product_type_code = '10';
                    $query_cust = "AND d.customer_type_id IN (10,20,30,40,50,60,70)";
                    $select_i_5 = "SUM(CASE WHEN d.product_type_code = '{$product_type_code}' 
                                    THEN
                                        CASE WHEN d.customer_type_id IN ('30', '40')
                                        THEN 
                                        d.consignment_amount
                                        WHEN d.customer_type_id IN ('10', '20', '60', '70')
                                        THEN
                                        d.amount
                                        ELSE 0 END
                                    ELSE 0 END) sum_amount,
                                    SUM(CASE WHEN d.product_type_code = '{$product_type_code}' 
                                    THEN
                                        CASE WHEN d.customer_type_id IN ('30', '40')
                                        THEN 
                                        d.consignment_quantity
                                        WHEN d.customer_type_id IN ('10', '20', '60', '70')
                                        THEN
                                        d.approve_quantity
                                        ELSE 0 END
                                    ELSE 0 END) sum_amount2,";

                } elseif($key==7) {
                    $product_type_code = '20';
                    $query_cust = "AND d.customer_type_id <> 80";
                    $select_i_5 = "SUM(CASE WHEN d.product_type_code = '{$product_type_code}' 
                                THEN
                                    CASE WHEN d.customer_type_id <> 80
                                    THEN 
                                    d.amount
                                    ELSE 0 END
                                ELSE 0 END) sum_amount,
                                SUM(CASE WHEN d.product_type_code = '{$product_type_code}' 
                                THEN
                                    CASE WHEN d.customer_type_id <>80
                                    THEN 
                                    d.approve_quantity
                                    ELSE 0 END
                                ELSE 0 END) sum_amount2,";
                    
                } elseif($key==8) {
                    $product_type_code = '10';
                    $query_cust = "AND d.customer_type_id = 80";
                    $select_i_5 = "SUM(CASE WHEN d.product_type_code = '{$product_type_code}' 
                                THEN
                                    CASE WHEN d.customer_type_id = 80
                                    THEN 
                                    d.amount
                                    ELSE 0 END
                                ELSE 0 END) sum_amount,
                                SUM(CASE WHEN d.product_type_code = '{$product_type_code}' 
                                THEN
                                    CASE WHEN d.customer_type_id = 80
                                    THEN 
                                    d.approve_quantity
                                    ELSE 0 END
                                ELSE 0 END) sum_amount2,";
                    
                }
                elseif($key==9) {
                    $product_type_code = '20';
                    $query_cust = "AND d.customer_type_id = 80";
                    $select_i_5 = "SUM(CASE WHEN d.product_type_code = '{$product_type_code}' 
                                THEN
                                    CASE WHEN (d.customer_type_id = 80 AND d.program_code = 'OMP0020')
                                    THEN 
                                    d.amount
                                    ELSE 0 END
                                ELSE 0 END) sum_amount,
                                SUM(CASE WHEN d.product_type_code = '{$product_type_code}' 
                                THEN
                                    CASE WHEN (d.customer_type_id = 80 AND d.program_code = 'OMP0020')
                                    THEN 
                                    d.approve_quantity
                                    ELSE 0 END
                                ELSE 0 END) sum_amount2,";
                    
                }
                $tb_view = "SELECT
                        {$select_i_5}
                        h.report_item_display item_title,
                        h.screen_number,
                        d.item_id
                    from ptom_sequence_ecoms h
                    
                    left join ptom_so_outstanding_v d on
                    d.item_id=h.item_id 
                    AND d.screen_number<>'0' 
                    AND d.product_type_code='{$product_type_code}' 
                    {$query_cust}
                    
                    
                    left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y')
                    
                    where h.sale_type_code='DOMESTIC'
                    AND h.screen_number<>'0'
                    AND h.product_type_code = '{$product_type_code}' 
                    AND(nvl(consignment_date ,trunc(pick_release_approve_date)) between to_date('{$date_start_i_5}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                    group by h.item_id,h.product_type_code,h.screen_number,h.report_item_display,
                    d.item_id
                    order by h.product_type_code,h.screen_number";
                  
                    $h_column_i5 = collect(DB::select($tb_view));
                    
                    $date_start_i_6 =Carbon::createFromFormat('Y-m-d', $date_f);
                    if($date_start_i_6 < $date_start_i_6->format('Y').'-10-01') {
                        $date_start_i6 = ($date_start_i_6->format('Y') - 1).'-10-01';
                        $date_end_i6 = $date_start_i_6->format('Y-m-d');
                    } else {
                        $date_start_i6 = $date_start_i_6->format('Y').'-10-01';
                        $date_end_i6 = $date_start_i_6->format('Y-m-d');
                    }
                    $tb_view = " SELECT
                        {$select_i_5}
                        h.item_description item_title,
                        h.screen_number,
                        d.item_id
                    from ptom_sequence_ecoms h
                    
                    left join ptom_so_outstanding_v d on
                    d.item_id=h.item_id 
                    AND d.screen_number<>'0' 
                    AND d.product_type_code='{$product_type_code}' 
                    {$query_cust}
                    AND(nvl(consignment_date ,trunc(pick_release_approve_date)) between to_date('{$date_start_i6}','yyyy-mm-dd') and to_date('{$date_end_i6}','yyyy-mm-dd'))
                    
                    -- left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y')
                    
                    where h.sale_type_code='DOMESTIC'
                    AND h.screen_number<>'0'
                    AND h.product_type_code = '{$product_type_code}' 
                    AND(nvl(consignment_date ,trunc(pick_release_approve_date)) between to_date('{$date_start_i6}','yyyy-mm-dd') and to_date('{$date_end_i6}','yyyy-mm-dd'))
                    group by h.item_id,h.product_type_code,h.screen_number,h.item_description,
                    d.item_id
                    order by h.product_type_code,h.screen_number";
                    $h_column_i6 = collect(DB::select($tb_view));
            }
            
            $tb_view="
                select
                    {sqlitem}
                    max(d.unit_price) price,
                    h.report_item_display item_title,
                    h.screen_number,
                    h.item_id
                from ptom_sequence_ecoms h
                left join (
                    select
                        d.*
                    from ptom_so_outstanding_v d
                    where d.screen_number<>'0'
                        {$sql_con}
                        ".$groups["where"][$key]."
                ) d on d.item_id=h.item_id
                left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y')
                where h.sale_type_code='DOMESTIC'
                AND h.screen_number<>'0'
                ".$groups["product_type_code"][$key] ."
                AND (h.START_DATE <= to_date('{$date_f}', 'yyyy-mm-dd') OR h.START_DATE IS NULL)
	            AND (h.END_DATE >= to_date('{$date_t}', 'yyyy-mm-dd') OR h.END_DATE IS NULL)
                group by h.item_id,h.product_type_code,h.screen_number,h.report_item_display, d.item_id
                order by h.product_type_code,h.screen_number
            ";
                
            $sql_item="";
            $i=0;
            foreach($groups["col"][$key] as $item){
                $sql_item.=$groups["select"][$key][$i]." as qty_{$i} , ";
                $i++;
            }
           
            $dd = DB::table(DB::raw("(".str_replace("{sqlitem}",$sql_item,$tb_view).") aa"))->get();
            
            if(in_array($key, [5,7,8,9])) {
            // dd($tb_view);
                
                $dd = $dd->map(function($i, $k) use($dd2, $h_column_i5, $h_column_i6, $key){
                    if(in_array($key, [5])) {
                        $i->price = $dd2[$k]->price;
                    }
                    $i->in_month_amount = @($h_column_i5->where('item_id', $i->item_id)->first())->sum_amount2;
                    $i->in_month_price = @($h_column_i5->where('item_id', $i->item_id)->first())->sum_amount;

                    
                    $i->in_year_amount = @($h_column_i6->where('item_id', $i->item_id)->first())->sum_amount2;
                    $i->in_year_price = @($h_column_i6->where('item_id', $i->item_id)->first())->sum_amount;
                    return $i;
                });
            }
           

            // 2,3,4 ถ้าไม่มีข้อมูลไม่ต้องแสดง ,6,7,9 = หีบ
            $notshow = array(2,3,4);
            $unitshow = array(6,7,9); // หีบ
            if(!(in_array($key,$notshow)) || ($dd->count()>0 && in_array($key,$notshow))){
                $data[$j]=$dd;
                $items[$j]=$groups["col"][$key];
                $unit[$j]=(in_array($key,$unitshow))?"หีบ":"พันมวน";
                $progPara[$key]=["ณ วันที่ $thDate_f","ปีงบประมาณ $thYear",$groups["title"][$key]];
                $j++;
            }
        }
        $datas=compact('data','items','unit','programCode','progTitle','progPara','remark', 'rmaByCusType', 'custype', 'rmaMonthByCusType', 'rmaYearByCusType', 'rmaRemark');
        return $datas;
    }
}
