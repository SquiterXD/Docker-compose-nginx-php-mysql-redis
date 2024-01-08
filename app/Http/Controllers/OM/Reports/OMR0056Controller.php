<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
//use App\Models\ProgramInfo;
use DB;
use Request;
use Route;
use PDF;

class OMR0056Controller extends Controller{
	public function export($programCode, $request){
        $datas=$this->create($programCode, $request);
        // return view('om.reports.omr0056.pdf.index',$datas);
        $pdf = PDF::loadView('om.reports.omr0056.pdf.index',$datas)
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
        $dt=(isset($request['end_date']) && $request['end_date']!="")?$request['end_date']:date('Y-m-d');
        $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t = date('Y-m-d',strtotime(str_replace('/','-',$dt)));
        $thDate_f = parseToDateTh($df);
        $thDate_t = parseToDateTh($dt);
        $getRMA = (new OMR0060Controller)->getRMA(['start'=> $date_f, 'end' => $date_t]);
        $rmaRemark = '';
        if(count($getRMA) > 0 ) {
            $rmaRemark = 'เลขที่ใบลดหนี้ ' . $getRMA->pluck('credit_note_number')->join(', ');

        }

        $rmaByCusType = $getRMA->groupBy('customer.customer_type_id');
        $month_f = date('m',strtotime(str_replace('/','-',$df)));
        $month_t = date('m',strtotime(str_replace('/','-',$dt)));
        $thMonth = getMonthTh(date('M', strtotime($date_t)));

        $add_month = ($month_t>9)?1:0;
        $year_f = date('Y',strtotime(str_replace('/','-',$df)));
        $year_t = date('Y',strtotime(str_replace('/','-',$dt)));
        $thYear_f = $year_f+543;
        $thYear_t = $year_t+543;
        $thYear = $thYear_t+$add_month;

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

        function getColumn($id,$name,$condition,$pro_type_id,$unit_x,$unit_rate){
            
            $col_s = array();
            $col_c = array();
            $col_a = array();
            $col   = array();
            $sq="
                select
                    distinct v.{$name} b,
                    v.{$id} a
                from PTOM_TRANSACTION_TYPES_V v
                left join ptom_so_outstanding_v d on (v.product_type_premium=d.product_type_desc)
                where d.pick_release_status='Confirm'
                    and v.sales_type = 'DOMESTIC' and v.product_type_premium is not null
                    {$condition}
                    and d.product_type_code='{$pro_type_id}'
                order by v.{$name}
            ";
            $sqxx="
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

                $a = "
                        SUM(
                            CASE WHEN  d.{$id}='".$row->a."'
                            THEN
                               d.amount
                            ELSE 0 END
                        )
                    ";
                array_push($col_s,$s);
                array_push($col_a,$a);
                array_push($col_c,$row->b);
            }
            $col['selprice'] = $col_a;
            $col['sel']=$col_s;
            $col['col']=$col_c;
            return $col;
        }

        $sql_con =" and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))";
        $sql_con30 =" and (trunc(d.consignment_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))";

        $col7=getColumn("order_type_id","order_type_name"," and d.customer_type_id='80' ",10,$unit_cg,$unit_arr["rate"][$unit_cg]);
        
        $col8=getColumn("order_type_id","order_type_name"," and d.customer_type_id='80' ",20,$unit_e,$unit_arr["rate"][$unit_e]);
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

        $groups["col"][2]=['ร้านค้า ป.2','รวม']; // D -- ไม่มีไม่ต้องแสดง customer_type_id=50
        $groups["col"][3]=['ขายพนักงาน','รวม']; // E -- ไม่มีไม่ต้องแสดง customer_type_id=60
        $groups["col"][4]=['ลูกค้าขายปลีก','รวม']; // F -- ไม่มีไม่ต้องแสดง customer_type_id=70
        // ย้ายจาก 2 มา 5
        $groups["col"][5]=['Modern Trade','รวม','รวม (บุหรี่)']; // B customer_type_id=20

        $groups["col"][6]=['เขต กทม.','เขต ตจว.','สโมสรกรุงเทพ','สโมสรภูมิภาค','ร้านค้า ป.2','Modern Trade','รวม'];// G
        $groups["col"][7]=['ขายพนักงาน','ลูกค้าขายปลีก','รวม','รวม (ยาเส้น)'];;// G
        $groups["col"][8]=array_merge($col7["col"],['รวม','รวม (บุหรี่)']); // H customer_type_id=80 , product_type_code=10
        $groups["col"][9]=array_merge($col8["col"],['รวม','รวม (ยาเส้น)']); // I customer_type_id=80 , product_type_code=20
        // A product_type_code=10 customer_type_id=10
        $groups["selprice"][0]= [
            " SUM(
                CASE WHEN d.province_code=10
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.province_code<>10
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(d.amount) "
        ];
        $groups["selprice"][1]= [
            " SUM(
                CASE WHEN d.customer_type_id=30
                THEN
                CASE WHEN d.product_type_code=10
                THEN
                    d.consignment_amount
                ELSE d.amount END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=40
                THEN
                CASE WHEN d.product_type_code=10
                THEN
                    d.consignment_amount
                ELSE d.amount END
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id in (30,40) 
                THEN
                    CASE WHEN d.product_type_code=10
                    THEN
                        d.consignment_amount
                    ELSE d.amount END
                ELSE 0 END
            ) "
        ];
        $groups["selprice"][2]= [
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='50'
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='50'
                THEN
                    d.amount
                ELSE 0 END
            ) "
        ];

        $groups["selprice"][3]= [
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='60'
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(CASE WHEN d.product_type_code='10' and d.customer_type_id='60' THEN d.amount ELSE 0 END) "
        ];

        $groups["selprice"][4]= [
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='70'
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.product_type_code='10' and d.customer_type_id='70'
                THEN
                    d.amount
                ELSE 0 END
            ) "
        ];
        $groups["selprice"][5]= [
            " SUM(
                CASE WHEN d.customer_type_id ='20' and d.pick_release_status='Confirm'
                    and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    d.amount
                ELSE 0 END
              )
            ",
            " SUM(
                CASE WHEN d.customer_type_id ='20' and d.pick_release_status='Confirm'
                    and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                THEN
                    d.amount
                ELSE 0 END
              )
            ",
            "SUM(
                case
                    when d.customer_type_id in (30,40) and d.consignment_status='Confirm'
                        and (trunc(d.consignment_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                    then 
                        d.amount
                    else
                        0
                end
            )
            ",
        ];
        $groups["selprice"][6]= [
            " SUM(
                CASE WHEN d.customer_type_id=10 and d.province_code=10
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=10 and d.province_code<>10
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=30
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=40
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=50
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=20
                THEN
                    d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id in (10,20,30,40,50)
                THEN
                    d.amount
                ELSE 0 END
            ) "
        ];
        $groups["selprice"][7]= [
            " SUM(
                CASE WHEN d.customer_type_id=60
                THEN
                d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id=70
                THEN
                d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE WHEN d.customer_type_id in (60,70)
                THEN
                d.amount
                ELSE 0 END
            ) ",
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_e}' THEN 
                    d.amount
                    ELSE 0
                END
            ) "
        ];
        $groups["selprice"][8]= array_merge($col7["selprice"],[
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_cg}' THEN  d.amount
                    ELSE 0
                END
            ) ",
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_cg}' THEN  d.amount
                    ELSE 0
                END
            ) "
        ]);
        $groups["selprice"][9]= array_merge($col8["selprice"],[
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_e}' THEN d.amount
                    ELSE 0
                END
            ) ",
            " SUM(
                CASE
                    WHEN d.uom_code='{$unit_e}' THEN d.amount
                    ELSE 0
                END
            ) "
        ]);


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
            " SUM(d.approve_quantity) "
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
            ) new_qty
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
            )
            ",
        ];

        // G product_type_code=20 customer_type_id=10,20,30,40
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
            ) "
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
            ) "
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
            ) "
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

        //$progReport = ProgramInfo::where('program_code',$programCode)->first();
        //$progTitle = $progReport->description;
        $progTitle = "ยอดจำหน่ายบุหรี่/ยาเส้น ประจำเดือน{$thMonth} (รต/3)";

        $j=0;
        foreach($groups["col"] as $key=>$group){
            $sql_con=($customer_type_id!='')? " and d.customer_type_id='$customer_type_id' ":"";
            if($key == 5) {
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
                   -- AND (h.START_DATE <= to_date('{$date_f}', 'yyyy-mm-dd') OR h.START_DATE IS NULL)
                   -- AND (h.END_DATE >= to_date('{$date_t}', 'yyyy-mm-dd') OR h.END_DATE IS NULL)
                    group by h.item_id,h.product_type_code,h.screen_number,h.report_item_display
                    order by h.product_type_code,h.screen_number
                ";
                $sql_item="";
                $i=0;
                foreach($groups["col"][$key] as $item){
                    $sql_item.=$groups["select"][$key][$i]." as qty_{$i} , ";
                    $i++;
                }
                $i=0;
                foreach($groups["col"][$key] as $item){
                    $sql_item.=$groups["selprice"][$key][$i]." as price_{$i} , ";
                    $i++;
                }
                $dd2 = DB::table(DB::raw("(".str_replace("{sqlitem}",$sql_item,$tb_view).") aa"))->get();
            }
            $tb_view="
                select
                    {sqlitem}
                    max(d.unit_price) price,
                    h.report_item_display item_title,
                    h.screen_number,
                    h.product_type_code
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
               -- AND (h.START_DATE <= to_date('{$date_f}', 'yyyy-mm-dd') OR h.START_DATE IS NULL)
	            -- AND (h.END_DATE >= to_date('{$date_t}', 'yyyy-mm-dd') OR h.END_DATE IS NULL)
                group by h.item_id,h.product_type_code,h.screen_number,h.report_item_display
                order by h.product_type_code,h.screen_number
            ";
           
            $sql_item="";
            $i=0;
            foreach($groups["col"][$key] as $item){
                $sql_item.=$groups["select"][$key][$i]." as qty_{$i} , ";
                $i++;
            }
            $i=0;
                foreach($groups["col"][$key] as $item){
                    $sql_item.=$groups["selprice"][$key][$i]." as price_{$i} , ";
                    $i++;
                }
            $dd = DB::table(DB::raw("(".str_replace("{sqlitem}",$sql_item,$tb_view).") aa"))->get();
            
            if($key == 5) {
                $dd = $dd->map(function($i, $k) use($dd2){
                    $i->price = @$dd2[$k]->price;
                    return $i;
                });
            }
            // 2,3,4 ถ้าไม่มีข้อมูลไม่ต้องแสดง , 7,8 = หีบ
            $notshow = array(2,3,4);
            $unitshow = array(6,8); // หีบ
            if(!(in_array($key,$notshow)) || ($dd->count()>0 && in_array($key,$notshow))){
                $data[$j]=$dd;
                $items[$j]=$groups["col"][$key];
                $unit[$j]=(optional($dd->first())->product_type_code == 10)?"พันมวน":"หีบ";// (in_array($key,$unitshow))?"หีบ":"พันมวน";
                $progPara[$j]=["ตั้งแต่วันที่ $thDate_f ถึงวันที่ $thDate_t","ปีงบประมาณ $thYear",$groups["title"][$key]];
                $j++;
            }
        }
        $datas=compact('data','items','unit','programCode','progTitle','progPara','remark', 'rmaByCusType', 'custype', 'rmaRemark');
        return $datas;
    }
}
