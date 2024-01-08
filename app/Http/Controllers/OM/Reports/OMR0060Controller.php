<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\OM\ConsignmentLines;
use App\Models\OM\OrderLines;
use App\Models\ProgramInfo;
use App\Models\Ptom\PtomClaimHeader;
use DB;
use Request;
use Route;
use PDF;

class OMR0060Controller extends Controller
{
    public function export($programCode, $request)
    {
        $datas = $this->create($programCode, $request);
        // return view('om.reports.omr0060.pdf.index',$datas);
        $pdf = PDF::loadView('om.reports.omr0060.pdf.index', $datas)
            ->setPaper('a4', 'landscape')
            ->setOption('header-right', "\n\n\n[page]/[topage] ")
            ->setOption('header-font-name', "THSarabunNew")
            ->setOption('header-font-size', 13)
            ->setOption('header-spacing', 3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode . '.pdf');
    }
    public function convertUom($item_id, $from , $to, $amout) {
        $sql = "select  (apps.inv_convert.inv_um_convert (
                            item_id           => '{$item_id}',
                            organization_id   => 164,
                            PRECISION         => NULL,
                            from_quantity     => '{$amout}',
                            from_unit         => '{$from}',
                            to_unit           => '{$to}',
                            from_name         => NULL,
                            to_name           => NULL)
                    )                                                               result
                from dual";
            try {
                return \DB::select($sql)[0]->result;
            } catch (\Throwable $th) {
                return false;
            }
    }
    public function getRMA($date)
    {
        
        $rmaSelect = ['claim_header_id', 'customer_id', 'credit_note_number', 'ref_invoice_number', 'rma_date', 'invoice_date'];
        $orderHeaderSelect = ['pick_release_no', 'order_header_id', 'product_type_code', 'tax'];
        $customerSelect = ['customer_id','customer_name', 'customer_type_id', 'province_code'];
        $rmaLineSelect = ['order_line_id', 'claim_line_id', 'claim_header_id', 'rma_quantity', 'rma_uom_code'];
        $orderLineSelect = ['ptom_order_lines.order_line_id', 'ptom_order_lines.attribute1','ptom_order_lines.unit_price', 'ptom_order_lines.credit_group_code', 
        'ptom_order_lines.item_description', 'ptom_order_lines.item_code', 'ptom_order_lines.item_id', 'ptom_order_headers.product_type_code'];
        $paymentApplyCdnSelect = ['ptom_payment_apply_cndn.invoice_amount', 'ptom_invoice_headers.invoice_amount', 'ptom_payment_apply_cndn.attribute1', 'ptom_payment_apply_cndn.credit_group_code', 'ptom_payment_apply_cndn.invoice_number'];
        $result =  PtomClaimHeader::select($rmaSelect)
                    ->where('status_rma', 'Confirm')
                    ->where('sales_type', 'DOMESTIC')
                    ->whereRaw("TRUNC(rma_date) BETWEEN to_date('{$date['start']}', 'yyyy-mm-dd') AND to_date('{$date['end']}', 'yyyy-mm-dd')")
                    ->with([
                        'paymentApply' => function($q) use($paymentApplyCdnSelect) {
                            $q->select($paymentApplyCdnSelect);
                            $q->leftjoin('ptom_invoice_headers', 'ptom_invoice_headers.invoice_headers_id', '=', 'ptom_payment_apply_cndn.invoice_header_id');
                        },
                        'orderHeader'=>function($q) use ($orderHeaderSelect) {
                            $q->select($orderHeaderSelect);
                        },
                        'customer' => function ($q) use ($customerSelect) {
                            return $q->select($customerSelect);
                        },
                        'lines' => function ($q) use ($rmaLineSelect, $orderLineSelect) {
                            return $q->select($rmaLineSelect)
                                // ->with(['orderLine' => function ($q) use ($orderLineSelect) {
                                //     $q->select($orderLineSelect);
                                //     $q->leftjoin('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id');
                                // }])
                                ;
                        }
                    ])
                    ->get();
                    
        // สำหรับลูกค้าที่ไม่ใช่ลูกค้าสโมสร (ptom_customers.customer_type_id ไม่ใช่ 30 และ 40)
        $case_1 = $result->filter(function($q) {
            return $q->customer->customer_type_id != 30 ||  $q->customer->customer_type_id != 40;
        });
        $case_1_get_lines = collect();
        foreach($case_1->pluck('lines') as $lines) {
            foreach($lines as $line) {
                $case_1_get_lines = $case_1_get_lines->push($line);
            }
        }
        $case_1_order_lines = OrderLines::select($orderLineSelect)
                            ->leftjoin('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id')
                            ->whereIn('order_line_id', $case_1_get_lines->pluck('order_line_id')->toArray())
                            ->get();
        $result->filter(function($q) {
            return $q->customer->customer_type_id != 30 ||  $q->customer->customer_type_id != 40;
        })->map(function($i) use($case_1_order_lines){
            $i->lines->map(function($l) use($case_1_order_lines){
                $l->orderLine = $case_1_order_lines->where('order_line_id', $l->order_line_id)->first() ?? collect();
                return $l;
            });
            return $i;
        });

      

        // สำหรับลูกค้าสโมสร (ptom_customers.customer_type_id เท่ากับ 30 หรือ 40)
        $case_2 = $result->filter(function($q) {
            return $q->customer->customer_type_id == 30 ||  $q->customer->customer_type_id == 40;
        });
        $case_2_get_lines = collect();
        foreach($case_2->pluck('lines') as $lines) {
            foreach($lines as $line) {
                $case_2_get_lines = $case_2_get_lines->push($line);
            }
        }
        
        $case_2_consignment_lines = ConsignmentLines::query()
        ->whereIn('consignment_line_id', $case_2_get_lines->pluck('order_line_id')->toArray())
        ->select('consignment_line_id', 'order_line_id')
        ->get();

        $case_2_order_lines = OrderLines::select($orderLineSelect)
        ->leftjoin('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id')
        ->whereIn('order_line_id', $case_2_consignment_lines->pluck('order_line_id')->toArray())
        ->get();
        $case_2_order_lines = $case_2_order_lines->map(function($i) use($case_2_consignment_lines) {
            $i->consignment_line_id = $case_2_consignment_lines->where('order_line_id', $i->order_line_id)->first()->consignment_line_id ?? '';
            return $i;
        });

        $result->filter(function($q) {
            return $q->customer->customer_type_id == 30 ||  $q->customer->customer_type_id == 40;
        })->map(function($i) use($case_2_order_lines){
            $i->lines->map(function($l) use($case_2_order_lines){
                $l->orderLine = $case_2_order_lines->where('consignment_line_id', $l->order_line_id)->first() ?? collect();
                return $l;
            });
            return $i;
        });


        $result = $result->map(function($i) {
            if($i->orderHeader->product_type_code == 10){
                $i->lines = $i->lines->map(function($item) use($i) {
                    $convert = $this->convertUom($item->orderLine->item_id, $item->rma_uom_code, 'CS1', $item->rma_quantity);
                    if($convert != '-99999') {
                        $item->rma_quantity = $convert;
                    }
                    return $item;
                });
            }
            return $i;
        });
        return $result;
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
        $remark = $request['remark'];

        $progReport = ProgramInfo::where('program_code', $programCode)->first();
        $progTitle = $progReport->description;
        $progPara[0] = "ประจำวันที่ $thDate_f ถึงวันที่ $thDate_t";
        $rma = $this->getRMA(['start' => $date_f, 'end' => $date_t]);
        $tb_view = "
            select
                c.zone_name,
                b.*
            from (
                SELECT
                    level zone_code,
                    case
                        when level=1 then '*** ยอดขายกทม. ***'
                        when level=2 then '*** ยอดขายต่างจังหวัด ***'
                        when level=3 then '*** ยอดขายฝากสโมสรยาสูบขาย ***'
                        else '*** ยอดขายบุหรี่ไม่คิดมูลค่า***'
                    end zone_name
                FROM DUAL
                CONNECT BY level < 5
            ) c
            left join (
                select
                    d.so_no,d.cus_name, d.customer_id,d.zone_code, g.amt2,g.amt3,g.amt4,
                    CASE WHEN ZONE_CODE = 3 THEN d.amt5 ELSE CASE WHEN g.amt>0 THEN g.amt ELSE d.amt5 END END amt5,
                    d.qty_10,
					d.qty_20
                from (
                    select
                        d.order_header_id, d.customer_name cus_name,d.customer_id,
                        CASE
                            WHEN d.customer_type_id in (30,40) and  d.product_type_code=10 THEN d.consignment_no
                            ELSE d.pick_release_no
                        END as so_no,
                        sum(
                            CASE
                                WHEN d.customer_type_id in (30,40) and d.product_type_code=10 AND d.consignment_status='Confirm' AND d.consignment_header_id is not null THEN d.consignment_amount
                                ELSE 0
                            END
                        ) as amt5,
                        sum(
                            CASE
                                WHEN d.customer_type_id in (30,40) and d.product_type_code=10 AND d.consignment_status='Confirm' AND d.consignment_header_id is not null THEN d.approve_quantity
                                WHEN d.product_type_code=10 THEN d.approve_quantity
                                ELSE 0
                            END
                        ) as qty_10,
                        sum(
                            CASE
                                WHEN d.product_type_code=20 THEN d.order_quantity
                                ELSE 0
                            END
                        ) as qty_20,
                        case
                            when (d.province_name='กรุงเทพมหานคร' and d.customer_type_id in (10,20,50,60,70)) or (d.customer_type_id=30 and d.product_type_code<>10) then 1
                            when (d.province_name<>'กรุงเทพมหานคร' and d.customer_type_id in (10,20,30, 50,60,70)) or (d.customer_type_id=40 and d.product_type_code<>10) then 2
                            when d.customer_type_id in (30,40) and d.product_type_code=10 then 3
                            when d.customer_type_id=80 then 4
                            else 5
                        end zone_code
                    from ptom_so_outstanding_v d
                    where d.pick_release_status='Confirm'
                    AND (NVL(CONSIGNMENT_DATE, TRUNC(PICK_RELEASE_APPROVE_DATE)) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
                    -- AND consignment_status='Confirm'
                    group by
                        CASE
                            WHEN d.customer_type_id in (30,40) and d.product_type_code=10  THEN d.consignment_no
                            ELSE d.pick_release_no
                        END,
                        d.order_header_id,
                        d.customer_name,
                        d.customer_id,
                        case
                            when (d.province_name='กรุงเทพมหานคร' and d.customer_type_id in (10,20,50,60,70)) or (d.customer_type_id=30 and d.product_type_code<>10) then 1
                            when (d.province_name<>'กรุงเทพมหานคร' and d.customer_type_id in (10,20,30, 50,60,70)) or (d.customer_type_id=40 and d.product_type_code<>10) then 2
                            when d.customer_type_id in (30,40) and d.product_type_code=10 then 3
                            when d.customer_type_id=80 then 4
                            else 5
                        end
                ) d
                LEFT JOIN (
                    SELECT
                        g.order_header_id,
                        sum(CASE WHEN g.order_line_id = 0 AND g.credit_group_code = '2' THEN g.amount ELSE 0 END) AS amt2,
                        sum(CASE WHEN g.order_line_id = 0 AND g.credit_group_code = '3' THEN g.amount ELSE 0 END) AS amt3,
                        sum(CASE WHEN g.order_line_id = 0 THEN g.received_amount ELSE 0 END) AS amt4,
                        sum(CASE WHEN g.order_line_id = 0 AND g.credit_group_code = '0' THEN g.amount ELSE 0 END) amt
                    FROM
                        ptom_order_credit_groups g
                    GROUP BY
                        g.order_header_id ) g ON d.order_header_id = g.order_header_id
            ) b ON
                (c.zone_code = b.zone_code)
            order by c.zone_code,b.so_no
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();
        $consignment = $data->pluck('so_no');
        $consignmentID = DB::table('ptom_so_outstanding_v')
            ->select('consignment_header_id')
            ->whereIn('consignment_no', $consignment->toArray())
            ->groupBy('consignment_header_id')
            ->get()
            ->pluck('consignment_header_id');

        $actual_quantity = DB::table('ptom_consignment_lines pcl')
            ->leftJoin('ptom_consignment_headers pch', 'pcl.consignment_header_id', '=', 'pch.consignment_header_id')
            ->selectRaw('sum(pcl.actual_quantity) actual_quantity , pch.consignment_no')
            ->whereIn('pcl.consignment_header_id', $consignmentID->toArray())
            ->groupBy('pch.consignment_no')
            ->get();
        $datas = compact('data', 'programCode', 'progTitle', 'progPara', 'remark', 'actual_quantity', 'rma');
        return $datas;
    }
}
