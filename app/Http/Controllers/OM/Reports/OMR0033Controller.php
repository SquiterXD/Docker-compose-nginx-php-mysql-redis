<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class OMR0033Controller extends Controller
{
    public function export($programCode, $request)
    {
        $datas = $this->create($programCode, $request);
        // return view('om.reports.omr0033.pdf.index', $datas);
        $pdf = PDF::loadView('om.reports.omr0033.pdf.index', $datas)
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
        $df = $request['date_f'];
        $date_f = date('m-d-Y', strtotime(str_replace('/', '-', $df)));
        // $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $thDate_f = parseToDateTh($df);
        $remark = $request['remark'];

        $progReport = ProgramInfo::where('program_code', $programCode)->first();
        $progTitle = $progReport->description;
        $progPara[0] = "วันที่ $thDate_f";


        $qPaymentHeaderNomal = "SELECT ph.payment_number,ph.payment_status,c.customer_number, (c.customer_name ||' , ' || c.market) customer_name,
        sum(
            CASE WHEN pi.credit_group_code = 0 AND oh.product_type_code = 10
            THEN 
                pi.payment_amount
            ELSE
                0
            END
        ) col1,
        sum(
            CASE WHEN pi.credit_group_code = 0 AND oh.product_type_code = 20
            THEN 
                pi.payment_amount
            ELSE
                0
            END
        ) col2,
        sum(
            CASE WHEN pi.credit_group_code = '3' 
            THEN 
                pi.payment_amount
            ELSE
                0
            END
        ) credit_group_code_3,
        sum(
            CASE WHEN pi.credit_group_code = 2 
            THEN 
                pi.payment_amount
            ELSE
                0
            END
        ) credit_group_code_2,
        (select sum(pd.payment_amount) from ptom_payment_details pd where pd.payment_header_id = ph.payment_header_id) pd_payment_amount,
        (CASE WHEN customer_type_id in ('30', '40') THEN 'cu' ELSE 'ne' END) g1
        FROM (select ohi.order_status,ohi.product_type_code, ohi.prepare_order_number FROM ptom_order_headers ohi GROUP BY ohi.order_status, ohi.prepare_order_number, ohi.product_type_code) oh, ptom_payment_headers ph
        left join ptom_customers c on ph.customer_id = c.customer_id
        left join ptom_payment_match_invoices pi on pi.payment_header_id = ph.payment_header_id
        --left join ptom_order_headers oh on pi.prepare_order_number = oh.prepare_order_number
        WHERE 1=1
        AND ph.sales_classification_code = 'Domestic'
        AND TRUNC (ph.payment_date) BETWEEN TO_DATE ('{$date_f}', 'MM-DD-YYYY') AND TO_DATE ('{$date_f}', 'MM-DD-YYYY')
        AND pi.match_flag = 'Y'
        AND pi.prepare_order_number is not null
        AND pi.prepare_order_number = oh.prepare_order_number
        --------
        --AND ph.payment_number ='66R001598'
        --AND CUSTOMER_NUMBER = 'D00007'
        AND oh.order_status='Confirm'
        -----
        GROUP BY c.customer_number,ph.payment_status, c.customer_name, ph.payment_number, ph.payment_header_id,  c.market, customer_type_id,oh.order_status 
        --ORDER BY ph.payment_number
        
        ";
        $data = collect(DB::select($qPaymentHeaderNomal));

        // get cu G1
        $sql = "SELECT ph.payment_number,c.customer_number,ph.payment_status, 
        (CASE WHEN ph.payment_status = 'Confirm'  THEN (c.customer_name  || ' , ' || c.market) ELSE 'ข้อมูลผิด' END) customer_name,
        sum(pi.payment_amount) col1,
        sum(
            0
        ) col2,
        sum(
           0
        ) credit_group_code_3,
        sum(
           0
        ) credit_group_code_2,
        (CASE WHEN ph.payment_status = 'Confirm'  THEN (select sum(pd.payment_amount) from ptom_payment_details pd where pd.payment_header_id = ph.payment_header_id) ELSE 0 END) pd_payment_amount,
        (CASE WHEN customer_type_id = '30'  THEN 'cu' ELSE 'ne' END) g1
        FROM ptom_payment_headers ph
        left join ptom_customers c on ph.customer_id = c.customer_id
        left join ptom_payment_match_invoices pi on pi.payment_header_id = ph.payment_header_id
        left join ptom_order_headers oh on pi.prepare_order_number = oh.prepare_order_number
        WHERE 1=1
        AND ph.sales_classification_code = 'Domestic'
        AND TRUNC (ph.payment_date) BETWEEN TO_DATE ('{$date_f}', 'MM-DD-YYYY') AND TO_DATE ('{$date_f}', 'MM-DD-YYYY')
        AND pi.match_flag = 'Y'
        AND pi.prepare_order_number is null
        GROUP BY c.customer_number,ph.payment_status, c.customer_name, ph.payment_number, ph.payment_header_id, ph.payment_status,c.market, customer_type_id
        ORDER BY payment_number";

        $data2 = collect(DB::select($sql));

        ## Cancel Condition
        $sql = "
        SELECT DISTINCT ph.payment_number,c.customer_number,ph.payment_status, (c.customer_name ||' , ' || c.market) customer_name,
                0 col1,
               0 col2,
                0 credit_group_code_3,
               0 credit_group_code_2,
                0 pd_payment_amount,
        (CASE WHEN customer_type_id in ('30', '40') THEN 'cu' ELSE 'ne' END) g1
                FROM (select ohi.order_status,ohi.product_type_code, ohi.prepare_order_number FROM ptom_order_headers ohi GROUP BY ohi.order_status, ohi.prepare_order_number, ohi.product_type_code) oh, ptom_payment_headers ph
                left join ptom_customers c on ph.customer_id = c.customer_id
                WHERE 1=1
                AND ph.sales_classification_code = 'Domestic'
                AND TRUNC (ph.payment_date) BETWEEN TO_DATE ('{$date_f}', 'MM-DD-YYYY') AND TO_DATE ('{$date_f}', 'MM-DD-YYYY')
                AND ph.payment_status='Cancel'
                -----
                GROUP BY c.customer_number,ph.payment_status, c.customer_name, ph.payment_number, ph.payment_header_id,  c.market, customer_type_id,oh.order_status 
                --ORDER BY ph.payment_number
                
        ";
        $data3 = collect(DB::select($sql));
        $data = $data->mergeRecursive($data2);
        $data = $data->mergeRecursive($data3);
        // dd($data->where('customer_number', 'D00007'));
        // $result = DB::select("  SELECT   payment_number, PD.customer_number, PD.customer_name,
        //  debt_amount, SUM (payment_amount) payment_amount, DD.credit_group_code,
        // DD.product_type_code , 'GE' g1
        //     FROM   ptom_debt_dom_v DD, ptom_payment_dom_v PD
        //     WHERE   DD.prepare_order_number = PD.prepare_order_number
        //             AND DD.credit_group_code = PD.credit_group_code
        //             AND TRUNC (payment_date) BETWEEN TO_DATE ('{$date_f}',
        //                                                         'MM-DD-YYYY')
        //                                                 AND	TO_DATE ('{$date_f}',
        //                                                         'MM-DD-YYYY')
        //     GROUP BY   payment_number, DD.credit_group_code, DD.product_type_code,
        //             PD.customer_number, PD.customer_name, debt_amount
        //     UNION
        //     select
        //     payment_number, PD.customer_number, PD.customer_name,
        //             debt_amount, SUM (payment_amount) payment_amount, DD.credit_group_code,
        //             DD.product_type_code, 'CLUB' g1

        //     FROM   ptom_debt_dom_v DD, ptom_payment_dom_v PD
        //     where DD.consignment_no = PD.invoice_number
        //     and PD.customer_type = '30'
        //     and trunc(payment_date) between to_date('{$date_f}','MM-DD-YYYY')
        //                                 and to_date('{$date_f}','MM-DD-YYYY')
        //     GROUP BY   payment_number, DD.credit_group_code, DD.product_type_code,
        //             PD.customer_number, PD.customer_name,debt_amount

        // ");
        // dd($result);
        // $data = collect($result);
        $datas = compact('data', 'programCode', 'progTitle', 'progPara', 'remark');
        return $datas;
    }
}
