<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
//use App\Models\ProgramInfo;
use DB;
use PDF;

class OMR0076Controller extends Controller{
	public function export($programCode, $request){
        list($cus_id,$cus_name) = ($request['cs_customer']!="")?explode('|',$request['cs_customer']) : [0,''];
        $df=$request['date_f'];
        $dt=$request['date_t'];
        $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t = date('Y-m-d',strtotime(str_replace('/','-',$dt)));
        $thDate_f = ($df!="")?parseToDateTh($df):"-";
        $thDate_t = ($dt!="")?parseToDateTh($dt):"-";
        $remark = $request['cs_remark'];

        // $sql_cus_id = ($cus_id != "" && $cus_id > 0) ? ", ( SELECT customer_number FROM ptom_customers WHERE CUSTOMER_TYPE_ID IN (30, 40) AND CUSTOMER_ID = '$cus_id') ptc " : ", ( SELECT customer_number FROM ptom_customers WHERE CUSTOMER_TYPE_ID IN (30, 40) ) ptc ";
        $sql_equal_cus_id = ($cus_id != "" && $cus_id > 0) ? " AND pcust.customer_number = ptc.customer_number " : "";
        $sql_date_between = ($df != "" && $dt != "") ? " AND (trunc(pch.CONSIGNMENT_DATE) BETWEEN to_date('{$date_f}', 'yyyy-mm-dd') AND to_date('{$date_t}', 'yyyy-mm-dd')) " : "";
        // $sql_order_by = ($cus_id != "" && $cus_id > 0) ? "ps.screen_number ASC" : "customer_number, ps.screen_number ASC";

        // $tb_view = "
        //     SELECT
        //         DISTINCT ps.item_description ,
        //         amt1 AS amt1 ,
        //         amt2 AS amt2 ,
        //         diff_amt AS diff_amt ,
        //         amount AS QTY ,
        //         price1 AS price1 ,
        //         price2 AS price2 ,
        //         item_type AS item_type ,
        //         ps.screen_number AS SCREEN_NUMBER ,
        //         customer_number
        //     FROM
        //         ptom_sequence_ecoms ps ,
        //         (
        //         SELECT
        //             pse.item_description ,
        //             pse.item_id ,
        //             pcust.customer_name ,
        //             sum(nvl(pcl.actual_quantity, 0)) AS amount,
        //             pch.CONSIGNMENT_DATE AS dd ,
        //             pse.SCREEN_NUMBER AS sn ,
        //             pol.unit_price AS price2 ,
        //             SUM(NVL(pll.operand, 0)) AS price1 ,
        //             (pol.unit_price * nvl(pcl.actual_quantity, 0)) AS amt2,
        //             NVL(pll.operand, 0)* nvl(pcl.actual_quantity, 0) AS amt1,
        //             (pol.unit_price * nvl(pcl.actual_quantity, 0))-(NVL(pll.operand, 0)* nvl(pcl.actual_quantity, 0)) diff_amt,
        //             CASE
        //                 WHEN poh.product_type_code = '10' THEN 'บุหรี่'
        //                 WHEN poh.product_type_code = '20' THEN 'ยาเส้น'
        //                 ELSE 'อื่นๆ'
        //             END item_type,
        //             ptc.customer_number
        //         FROM
        //             ptom_sequence_ecoms pse ,
        //             ptom_consignment_lines pcl ,
        //             ptom_consignment_headers pch ,
        //             ptom_customers pcust ,
        //             ptom_price_list_head_v plh ,
        //             ptom_price_list_line_v pll ,
        //             ptom_order_headers poh ,
        //             ptom_order_lines pol
        //             {$sql_cus_id}
        //         WHERE
        //             1 = 1
        //             AND pse.item_id = pcl.item_id
        //             AND pch.consignment_header_id = pcl.consignment_header_id
        //             AND pch.consignment_status = 'Confirm'
        //             AND pch.customer_id = pcust.customer_id
        //             AND pll.item_id = pcl.item_id
        //             AND plh.list_header_id = pll.list_header_id
        //             AND poh.order_header_id = pol.order_header_id
        //             AND pch.order_header_id = poh.order_header_id
        //             AND pcl.order_header_id = poh.order_header_id
        //             AND pol.item_id = pll.item_id
        //             AND pol.item_id = pcl.item_id
        //             AND plh.name = 'ราคาโรงงาน'
        //             {$sql_equal_cus_id}
        //             {$sql_date_between}
        //         GROUP BY
        //             pse.item_description ,
        //             pse.item_id ,
        //             pcust.customer_name ,
        //             pch.CONSIGNMENT_DATE ,
        //             pse.SCREEN_NUMBER ,
        //             pol.unit_price ,
        //             pcl.actual_quantity ,
        //             pll.operand ,
        //             poh.product_type_code ,
        //             ptc.customer_number ) SEQ
        //     WHERE
        //         ps.sale_type_code = 'DOMESTIC'
        //         AND ps.product_type_code = '10'
        //         AND ps.screen_number <> '0'
        //         AND ps.item_id = SEQ.item_id(+)
        //         AND (trunc(nvl(ps.start_date, sysdate)) <= TRUNC(SYSDATE)
	    //         AND trunc(nvl(ps.end_date, sysdate)) >= TRUNC(SYSDATE))
        //     ORDER BY
        //         {$sql_order_by}
        //     ";

        // $data = DB::table(DB::raw("({$tb_view}) a"))->get();

        $sql_where_cus_id = ($cus_id != "" && $cus_id > 0) ? " AND CUSTOMER_ID = '$cus_id' " : "";
         $tb_group = "
            SELECT
                customer_id || '|' || customer_name value,
                customer_number || ' ' || customer_name label,
                customer_name,
                customer_id
            FROM
                ptom_customers
            WHERE
                customer_type_id IN (30, 40)
                AND sales_classification_code = 'Domestic' {$sql_where_cus_id}
            ORDER BY
                customer_id
            ";
        $groups = DB::table(DB::raw("({$tb_group}) a"))->get();

        foreach($groups as $key => $group){
            $pt_cus_id[$key] = $groups[$key]->customer_id;

            $tb_view="
                SELECT
                    DISTINCT ps.item_description ,
                    (price1 * actual_quantity) AS amt1 ,
                    (price2 * actual_quantity) AS amt2 ,
                    ((price2 * actual_quantity) - (price1 * actual_quantity)) AS diff_amt ,
                    actual_quantity AS qty ,
                    price1 AS price1 ,
                    price2 AS price2 ,
                    item_type AS item_type ,
                    ps.screen_number AS SCREEN_NUMBER ,
                    customer_number
                FROM
                    ptom_sequence_ecoms ps ,
                    (
                    SELECT
                        pse.item_description ,
                        pse.item_id ,
                        pcust.customer_name ,
                        sum(pcl.actual_quantity) AS actual_quantity,
                        pse.SCREEN_NUMBER AS sn ,
                        pol.unit_price AS price2 ,
                        pll.operand AS price1 ,
                        CASE
                            WHEN poh.product_type_code = '10' THEN 'บุหรี่'
                            WHEN poh.product_type_code = '20' THEN 'ยาเส้น'
                            ELSE 'อื่นๆ'
                        END item_type,
                        ptc.customer_number
                    FROM
                        ptom_sequence_ecoms pse ,
                        ptom_consignment_lines pcl ,
                        ptom_consignment_headers pch ,
                        ptom_customers pcust ,
                        ptom_price_list_head_v plh ,
                        ptom_price_list_line_v pll ,
                        ptom_order_headers poh ,
                        ptom_order_lines pol ,
                        ( SELECT customer_number FROM ptom_customers WHERE CUSTOMER_TYPE_ID IN (30, 40) AND CUSTOMER_ID = '$pt_cus_id[$key]') ptc
                    WHERE
                        1 = 1
                        AND pse.item_id = pcl.item_id
                        AND pch.consignment_header_id = pcl.consignment_header_id
                        AND pch.consignment_status = 'Confirm'
                        AND pch.customer_id = pcust.customer_id
                        AND pll.item_id = pcl.item_id
                        AND plh.list_header_id = pll.list_header_id
                        AND poh.order_header_id = pol.order_header_id
                        --AND pch.order_header_id = poh.order_header_id
                        AND pcl.order_header_id = poh.order_header_id
                        AND pol.item_id = pll.item_id
                        AND pol.item_id = pcl.item_id
                        AND plh.name = 'ราคาโรงงาน'
                        AND pcust.customer_number = ptc.customer_number
                        {$sql_date_between}
                    GROUP BY
                        pse.item_description ,
                        pse.item_id ,
                        pcust.customer_name ,
                        pse.SCREEN_NUMBER ,
                        pol.unit_price ,
                        pll.operand ,
                        poh.product_type_code ,
                        ptc.customer_number ) SEQ
                WHERE
                    ps.sale_type_code = 'DOMESTIC'
                    AND ps.product_type_code = '10'
                    AND ps.screen_number <> '0'
                    AND ps.item_id = SEQ.item_id(+)
                    AND (trunc(nvl(ps.start_date, sysdate)) <= TRUNC(SYSDATE)
                    AND trunc(nvl(ps.end_date, sysdate)) >= TRUNC(SYSDATE))
                ORDER BY
                    ps.screen_number ASC
                ";
            $sql_item="";
            $sql[$key] = str_replace("{sqlitem}", $sql_item, $tb_view);
            $data[$key] = DB::table(DB::raw("(".$sql[$key].") a"))->get();
            // dd($sql, $data);
        }

        $progTitle = "สรุปรายการค่าตอบแทนแยกตราบุหรี่ยาเส้น";
        $progPara[0]="ประจำเดือน วันที่ $thDate_f ถึงวันที่ $thDate_t";
        // $progPara[1]="{$cus_name}";

        $pdf = PDF::loadView('om.reports.omr0076.pdf.index',compact('data','programCode','progTitle','progPara','remark', 'groups'))
            ->setPaper('a4','landscape')
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',13)
            ->setOption('header-spacing',3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode. '.pdf');
    }

}
