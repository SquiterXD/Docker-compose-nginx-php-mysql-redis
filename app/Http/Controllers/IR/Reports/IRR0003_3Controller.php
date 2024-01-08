<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class IRR0003_3Controller extends Controller
{
    public function export($programCode, $request)
    {
        $s_set_f = $request['s_set_f']; // กรมธรรม์ชุดที่ ตั้งแต่ *
        $s_set_t = ($request['s_set_t'] != '') ? $request['s_set_t'] : $request['s_set_f']; // กรมธรรม์ชุดที่ ถึง *

        $s_period = $request['s_period']; // วันที่คุ้มครอง
        $s_company_f = $request['s_company_f']; // บริษัทประกัน
        $s_company_t = ($request['s_company_t'] != '') ? $request['s_company_t'] : $request['s_company_f']; // บริษัทประกัน ถึง *
        $remark = $request['remark'];
        $status = $request['status'];
        $progReport = ProgramInfo::where('program_code', $programCode)->first();
        $progTitle = $progReport->description;

        $tb_set = "
            SELECT
                trunc(insurance_end_date) - trunc(insurance_start_date) as days_period,
                POLICY_SET_DESCRIPTION set_title,
                POLICY_SET_HEADER_ID s_set,
                insurance_start_date  date_f,
                insurance_end_date  date_t
            FROM PTIR_ASSET_HEADERS
            WHERE PROGRAM_CODE='IRP0003' AND ( POLICY_SET_HEADER_ID BETWEEN {$s_set_f} and {$s_set_t}) and YEAR='{$s_period}'
            GROUP BY POLICY_SET_DESCRIPTION,POLICY_SET_HEADER_ID,insurance_start_date,insurance_end_date
            ORDER BY POLICY_SET_HEADER_ID
        ";
        $sets = DB::table(DB::raw("({$tb_set}) a"))->get();
        $GroupSet = [];
        if (!empty($s_company_f)) {
            $sql_comlist = "SELECT DISTINCT COMPANY_ID ,COMPANY_NUMBER,COMPANY_NAME
            FROM PTIR_COMPANIES_V
            WHERE COMPANY_ID BETWEEN $s_company_f AND $s_company_t
            ORDER BY COMPANY_ID";
            $i = 0;
            $company_list = DB::table(DB::raw("({$sql_comlist}) a"))->get();
            $GroupSet = [];
            foreach($company_list as $s_company){
                foreach ($sets as $key => $set) {
                    $date_f = date('Y-m-d', strtotime($set->date_f));
                    $date_t = date('Y-m-d', strtotime($set->date_t));
                    $thDate_f = parseToDateTh($date_f);
                    $thDate_t = parseToDateTh($date_t);
                    $s_set = $set->s_set;
                    $GroupSet[$i] = $this->getData($date_f, $date_t, $s_company->company_number, $thDate_f, $thDate_t, $s_period, $s_set_f, $s_set_t, $set, $progReport);
                    $GroupSet[$i]['programCode'] = $programCode;
                    $GroupSet[$i]['remark'] = $remark;
                    $i++;
                }
                $i++;
            }
        }else{
            foreach ($sets as $key => $set) {
                $date_f = date('Y-m-d', strtotime($set->date_f));
                $date_t = date('Y-m-d', strtotime($set->date_t));
                $thDate_f = parseToDateTh($date_f);
                $thDate_t = parseToDateTh($date_t);
                $s_set = $set->s_set;
                $GroupSet[$key] = $this->getData($date_f, $date_t, "", $thDate_f, $thDate_t, $s_period, $s_set_f, $s_set_t, $set, $progReport);
                $GroupSet[$key]['programCode'] = $programCode;
                $GroupSet[$key]['remark'] = $remark;
            }
        }
        //  dd($GroupSet);
        $pdf = PDF::loadView('ir.reports.irr0003_3.pdf.index', compact('GroupSet', 'progTitle', 'programCode'))
            ->setPaper('a4', 'portrait')
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',3)
            ->setOption('header-right',"\n\n\n\n[page]/[topage] ")
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode . '.pdf');
    }

    function getData($date_f, $date_t, $s_company, $thDate_f, $thDate_t, $s_period, $s_set_f, $s_set_t, $sets, $progReport)
    {
        $compact = [];

        $date_f = date('Y-m-d', strtotime($sets->date_f));
        $date_t = date('Y-m-d', strtotime($sets->date_t));
        $thDate_f = parseToDateTh($date_f);
        $thDate_t = parseToDateTh($date_t);

        $company_f = $s_company; // บริษัทประกัน
        $company_t = $s_company;
        $is_company = ($company_f != "" && $company_t != "");

        $query_company_f = $company_f;
        $query_company_t = $company_t;

        $sql_con = "";
        // $sql_con .= ($s_company != "") ? " and z.COMPANY_ID =  $s_company" : "";

        $sql_con2 = "";
        $sql_con2 .= ($s_company != "") ? " and A.COMPANY_CODE =  $s_company" : "";

        $sql_company = "AND C.YEAR = {$s_period} AND E.ACTIVE_FLAG ='Y' AND D.POLICY_SET_HEADER_ID BETWEEN {$s_set_f} and {$s_set_t} ";
        $sql_company .= ($s_company != "") ? " AND A.COMPANY_CODE =  $s_company " : ""; // บริษัทประกัน

        $sql_s = "";

        $tb_company = "
        SELECT * FROM
        (SELECT
            LISTAGG(COMPANY_CODE, ', ') WITHIN GROUP (
                ORDER BY COMPANY_CODE) AS comp_code,
                LISTAGG(COMPANY_NAME, ', ') WITHIN GROUP (
                ORDER BY COMPANY_NAME) AS comp_name,
                LISTAGG(default_diff_amount, ', ') WITHIN GROUP (
                    ORDER BY
                        default_diff_amount) AS default_diff_amount
        FROM
            (
            SELECT
                DISTINCT E.company_name,
                A.company_code,
                A.default_diff_amount
            FROM
                PTIR_POLICY_GROUP_DISTS A
            JOIN PTIR_COMPANIES E ON
                E.COMPANY_NUMBER = A.COMPANY_CODE
            JOIN PTIR_POLICY_GROUP_LINES C ON
                (C.group_line_id = A.group_line_id)
            JOIN PTIR_POLICY_GROUP_SETS D ON
                (D.group_header_id = C.group_header_id)
            JOIN PTIR_POLICY_GROUP_HEADERS B ON
                C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
            WHERE
                0 = 0
                {$sql_company}
            GROUP BY E.company_name, A.company_code, A.default_diff_amount
            ) z)
            ,
        (SELECT
            LISTAGG(policyno, ', ') WITHIN GROUP (
            ORDER BY policyno) AS policy_no
        FROM
            (
            SELECT
                DISTINCT A.user_policy_number as policyno
            FROM
                PTIR_POLICY_GROUP_DISTS A
            JOIN PTIR_COMPANIES E ON
                E.COMPANY_NUMBER = A.COMPANY_CODE
            JOIN PTIR_POLICY_GROUP_LINES C ON
                (C.group_line_id = A.group_line_id)
            JOIN PTIR_POLICY_GROUP_SETS D ON
                (D.group_header_id = C.group_header_id)
            JOIN PTIR_POLICY_GROUP_HEADERS B ON
                C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
            WHERE
                0 = 0
                {$sql_company}
            GROUP BY A.user_policy_number
            ) z)
        ,
        (SELECT
            LISTAGG(company_percent, ', ') WITHIN GROUP (ORDER BY company_percent) AS company_percent
        FROM
            (
            SELECT
                DISTINCT A.company_percent
            FROM
                PTIR_POLICY_GROUP_DISTS A
            JOIN PTIR_COMPANIES E ON
                E.COMPANY_NUMBER = A.COMPANY_CODE
            JOIN PTIR_POLICY_GROUP_LINES C ON
                (C.group_line_id = A.group_line_id)
            JOIN PTIR_POLICY_GROUP_SETS D ON
                (D.group_header_id = C.group_header_id)
            JOIN PTIR_POLICY_GROUP_HEADERS B ON
                C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
            WHERE
                0 = 0
                {$sql_company}
            GROUP BY A.company_percent
            ) z)
        ,
        (SELECT
            LISTAGG(comments, ', ') WITHIN GROUP (ORDER BY comments) AS comments
        FROM
            (
            SELECT
                DISTINCT A.comments
            FROM
                PTIR_POLICY_GROUP_DISTS A
            JOIN PTIR_COMPANIES E ON
                E.COMPANY_NUMBER = A.COMPANY_CODE
            JOIN PTIR_POLICY_GROUP_LINES C ON
                (C.group_line_id = A.group_line_id)
            JOIN PTIR_POLICY_GROUP_SETS D ON
                (D.group_header_id = C.group_header_id)
            JOIN PTIR_POLICY_GROUP_HEADERS B ON
                C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
            WHERE
                0 = 0
                {$sql_company}
            GROUP BY A.comments,A.default_diff_amount
            ) z)
        ";

        $companies = DB::table(DB::raw("({$tb_company}) a"))->get()->first();

        if (!empty($companies)) {
            $comp_name = "'{$companies->comp_name}'";
            $insur_percent = "'100'";

            $comp_code = ($s_company != "") ? "z.company_code" : "{$companies->comp_code}";
            $comp_name = ($s_company != "") ? "z.company_name" : "'{$companies->comp_name}'";
            $group_comp_code = ($s_company != "") ? "z.company_code" : "LISTAGG(z2.company_code,', ') WITHIN GROUP (ORDER BY z2.company_code)";
            $group_comp_name = ($s_company != "") ? "z.company_name" : "LISTAGG(z2.COMPANY_NAME,', ') WITHIN GROUP (ORDER BY z2.COMPANY_NAME)";
            $comp_percent = ($s_company != "") ? "z.company_percent" : "'100'";
            $insur_percent = ($s_company != "") ? "z.prepaid_insurance" : "'100'";

            $tb_expense = "
            SELECT
                b.description as exp_title
            FROM PTIR_POLICY_SET_HEADERS a
            left join PTIR_ACCOUNTS_MAPPING_V b on a.ACCOUNT_ID = b.ACCOUNT_ID
            WHERE /*a.PROGRAM_CODE='IRP0003' and*/ a.POLICY_SET_HEADER_ID = {$sets->s_set}
        ";
            $expense = DB::table(DB::raw("({$tb_expense}) a"))->get()->first();
            $diff_value = ($s_company != "" && $companies->default_diff_amount == 'Y') ? 'Y' : 'N';
            $comp_percent_Y = ($s_company != "" && $companies->default_diff_amount == 'Y') ? $companies->company_percent : 0;
            $comp_percent_N = ($s_company != "") ? (100-(float)$comp_percent_Y) : 100;
            $join_company = ($s_company != "") ? "
            select
                A.company_code,
                A.company_percent,
                E.company_name,
                C.prepaid_insurance,
                C.premium_rate,
                D.policy_set_header_id,
                C.year,
                E.company_id,
                A.default_diff_amount
            from
                PTIR_POLICY_GROUP_DISTS A
                join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                join PTIR_POLICY_GROUP_LINES C on (C.group_line_id = A.group_line_id)
                join PTIR_POLICY_GROUP_SETS D on (D.group_header_id = C.group_header_id)
            WHERE E.ACTIVE_FLAG = 'Y'" : "
            select
                max(A.company_code) company_code,
                max(A.company_percent) company_percent,
                max(E.company_name) company_name,
                max(C.prepaid_insurance) prepaid_insurance,
                max(C.premium_rate) premium_rate,
                max(D.policy_set_header_id) policy_set_header_id,
                max(C.year) year,
                max(E.company_id) company_id
            from
                PTIR_POLICY_GROUP_DISTS A
                join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                join PTIR_POLICY_GROUP_LINES C on (C.group_line_id = A.group_line_id)
                join PTIR_POLICY_GROUP_SETS D on (D.group_header_id = C.group_header_id)
            WHERE
                E.ACTIVE_FLAG = 'Y'
                AND (d.POLICY_SET_HEADER_ID = {$sets->s_set})
                AND c.YEAR = {$s_period}
            GROUP BY
                D.policy_set_header_id";

            $join_company_aggregate =
                "
        JOIN (
            SELECT
                policy_set_header_id,
                LISTAGG(COMPANY_NAME,', ') WITHIN GROUP (ORDER BY COMPANY_NAME) AS company_name,
                LISTAGG(COMPANY_CODE,', ') WITHIN GROUP (ORDER BY COMPANY_CODE) AS company_code
            FROM (
                  SELECT
                      D.policy_set_header_id,
                    max(E.company_name) company_name,
                    max(A.company_code) company_code
                FROM PTIR_POLICY_GROUP_DISTS A
                JOIN PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                JOIN PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
                JOIN PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
                WHERE E.ACTIVE_FLAG ='Y'
                AND C.YEAR = {$s_period}
                GROUP BY D.policy_set_header_id, A.company_code
                ORDER BY 1,2
            )
            GROUP BY policy_set_header_id
          ) z2 ON (z2.policy_set_header_id = l.policy_set_header_id)";

            $tb_view = "
            WITH CTE_DATA AS(SELECT
                rawtohex(sys_guid()) as FORMATTED_GUID,
                l.POLICY_SET_HEADER_ID policy_set,
                'ชุดที่ ' || l.POLICY_SET_HEADER_ID || ' : ' || max(l.POLICY_SET_DESCRIPTION) program_title,
                {$comp_code} group_comp_code,
                {$comp_name} group_comp,
                {$comp_percent} comp_percent,
                {$insur_percent} insur_percent,
                MAX(l.location_name) group_01,
                MAX(l.department_name) group_02,
                MAX(l.CATEGORY_DESCRIPTION) cat_title,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_insure_100,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_insure,
                sum(round(NVL(l.COVERAGE_AMOUNT,0),2)*round(NVL({$comp_percent}, 0)/100,2)) amt_cost,
                CASE WHEN LENGTH(l.RECEIVABLE_NAME) > 0 THEN 0 ELSE sum (
                    CASE
                        WHEN NVL(h.include_tax_flag,'')='Y'
                        THEN round(NVL(l.net_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                        ELSE (round(NVL(l.insurance_amount,0),2)+round(NVL(l.duty_amount,0),2))*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                    END
                ) END amt_close,
                sum(round(NVL(l.duty_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2))amt_duty,
                sum(round(NVL(l.vat_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_vat,
                sum(round(NVL(l.vat_amount,0),2)) amt_vat1,
                sum(round(NVL(l.net_amount,0),2)) amt_net,
                max(l.status) status,
                'ค่าเบี้ยประกันภัยจ่ายล่วงหน้า - ' || NVL(l.RECEIVABLE_NAME,'ส่วนกลาง') receivable_name
                 FROM PTIR_ASSET_LINES l
            JOIN (
                $join_company
            ) z on (z.policy_set_header_id=l.policy_set_header_id and z.year=l.year)
            $join_company_aggregate
            JOIN PTIR_POLICY_SET_HEADERS h on (h.policy_set_header_id=l.policy_set_header_id)
            LEFT JOIN PTIR_ASSET_HEADERS ph ON
                (ph.policy_set_header_id = l.policy_set_header_id
                AND ph.start_calculate_date = l.CALCULATE_START_DATE
                AND ph.end_calculate_date = l.CALCULATE_END_DATE)
            WHERE l.program_code='IRP0003' and NVL(l.ASSET_STATUS,'')='Y'
                AND (l.POLICY_SET_HEADER_ID = {$sets->s_set})
                and l.year={$s_period}
                {$sql_con}
                AND l.STATUS != 'CANCELLED'
            GROUP BY l.POLICY_SET_HEADER_ID,
                z.company_code,
                z.company_name,
                z.company_percent,
                z.prepaid_insurance,
                l.RECEIVABLE_NAME ,
                l.LOCATION_CODE ,
                l.DEPARTMENT_CODE ,
                l.CATEGORY_CODE
            ORDER BY l.POLICY_SET_HEADER_ID,
                z.company_code,
                z.company_name,
                z.company_percent,
                z.prepaid_insurance,
                NVL(l.RECEIVABLE_NAME, ' '),
                l.LOCATION_CODE ,
                l.DEPARTMENT_CODE ,
                l.CATEGORY_CODE)
            SELECT
            Y.FORMATTED_GUID,
            Y.policy_set,
            Y.program_title,
            Y.group_comp_code,
            Y.group_comp,
            Y.comp_percent,
            Y.insur_percent,
            Y.group_01,
            Y.group_02,
            Y.cat_title,
            Y.amt_insure,
            Y.amt_cost,
            Y.amt_close,
            Y.amt_duty,
            Y.amt_vat,
            Y.amt_vat1,
            Y.amt_net,
            Y.status,
            Y.receivable_name FROM CTE_DATA Y
        ";
//  var_dump($tb_view);
//         dd();
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();
            $sql_duty_vat = "
            WITH CTE_DATA AS(
                SELECT
                    NVL(receivable_name, 'ส่วนกลาง') receivable_name,
                    T.POLICY_SET_HEADER_ID,
                    SUM(T.duty_amount) duty_amount,
                    SUM(T.vat_amount) vat_amount
                FROM
                    (
                    SELECT
                        l.POLICY_SET_HEADER_ID ,
                        l.receivable_name,
                        A.company_code,
                        A.company_percent, ";
            $sql_duty_vat .= ($s_company != "") ? "round(round(sum(round(NVL(l.duty_amount, 0), 2)), 2)* round(NVL(A.company_percent, 0)/ 100, 2), 2) duty_amount,
                        round(round(sum(round(NVL(l.vat_amount, 0), 2)), 2)* round(NVL(A.company_percent, 0)/ 100, 2), 2) vat_amount,
                        round(sum(round(NVL(l.vat_amount, 0), 2)), 2) t_vat_amount,
                        A.default_diff_amount " : "round(sum(round(NVL(l.duty_amount, 0), 2)), 2) duty_amount,
                        round(sum(round(NVL(l.vat_amount, 0), 2)), 2) vat_amount,
                        round(sum(round(NVL(l.vat_amount, 0), 2)), 2) t_vat_amount " ;
            $sql_duty_vat .= " FROM
                        PTIR_POLICY_GROUP_DISTS A
                    JOIN PTIR_COMPANIES E ON
                        E.COMPANY_NUMBER = A.COMPANY_CODE
                    JOIN PTIR_POLICY_GROUP_LINES C ON
                        (C.group_line_id = A.group_line_id)
                    JOIN PTIR_POLICY_GROUP_SETS D ON
                        (D.group_header_id = A.group_header_id)
                    JOIN (
                        SELECT
                            policy_set_header_id,
                            receivable_name,
                            round(sum(round(NVL(l.duty_amount, 0), 2)), 2) duty_amount,
                            round(sum(round(NVL(l.vat_amount, 0), 2)), 2) vat_amount
                        FROM
                            ptir_asset_lines l
                        WHERE
                            l.program_code = 'IRP0003'
                            AND l.YEAR = {$s_period}
                            AND l.status != 'CANCELLED'
                            AND l.policy_set_header_id = {$sets->s_set}
                        GROUP BY
                            policy_set_header_id,
                            receivable_name
            ) l ON
                        l.policy_set_header_id = d.POLICY_SET_HEADER_ID
                    WHERE
                        E.ACTIVE_FLAG = 'Y'
                        AND (d.POLICY_SET_HEADER_ID = {$sets->s_set})
                            AND c.YEAR = {$s_period}
                            AND DEFAULT_DIFF_AMOUNT = 'N'
                        GROUP BY
                            l.POLICY_SET_HEADER_ID,
                            l.receivable_name,
                            A.company_code,
                            A.company_percent,
                            A.default_diff_amount ) T
                GROUP BY
                    T.POLICY_SET_HEADER_ID,
                    T.t_vat_amount,
                    receivable_name

            )
            SELECT
                l.policy_set_header_id,
                company_code,
	            company_percent,
                {$comp_percent} comp_percent,
                NVL(l.receivable_name, 'ส่วนกลาง') receivable_name, ";
                $sql_duty_vat .= ($s_company != "") ? "CASE
                    WHEN z.default_diff_amount = 'Y'
                    THEN round(round(sum(round(NVL(l.vat_amount, 0), 2)), 2) - NVL((SELECT VAT_AMOUNT FROM CTE_DATA WHERE receivable_name = NVL(l.receivable_name, 'ส่วนกลาง')), 0) , 2)
                    ELSE round(round(sum(round(NVL(l.vat_amount, 0), 2)), 2)* round(NVL({$comp_percent}, 0)/ 100, 2), 2)
                END vat_amount,
                CASE
                    WHEN z.default_diff_amount = 'Y'
                    THEN round(round(sum(round(NVL(l.duty_amount, 0), 2)), 2) - NVL((SELECT DUTY_AMOUNT FROM CTE_DATA WHERE receivable_name = NVL(l.receivable_name, 'ส่วนกลาง')), 0) , 2)
                    ELSE round(round(sum(round(NVL(l.duty_amount, 0), 2)), 2)* round(NVL({$comp_percent}, 0)/ 100, 2), 2)
                END duty_amount " : "round(round(sum(round(NVL(l.vat_amount, 0), 2)), 2)* round(NVL('100', 0)/ 100, 2), 2) vat_amount,
                round(round(sum(round(NVL(l.duty_amount, 0), 2)), 2)* round(NVL('100', 0)/ 100, 2), 2) duty_amount " ;
                $sql_duty_vat .= "FROM
                ptir_asset_lines l
            LEFT JOIN (
                SELECT
                    max(A.company_code) company_code,
                    max(A.company_percent) company_percent,
                    max(E.company_name) company_name,
                    max(C.prepaid_insurance) prepaid_insurance,
                    max(C.premium_rate) premium_rate,
                    max(D.policy_set_header_id) policy_set_header_id,
                    max(C.year) YEAR,
                    max(E.company_id) company_id ";
             $sql_duty_vat .= ($s_company != "") ? ",A.default_diff_amount " : "";
             $sql_duty_vat .= " FROM
                    PTIR_POLICY_GROUP_DISTS A
                JOIN PTIR_COMPANIES E ON
                    E.COMPANY_NUMBER = A.COMPANY_CODE
                JOIN PTIR_POLICY_GROUP_LINES C ON
                    (C.group_line_id = A.group_line_id)
                JOIN PTIR_POLICY_GROUP_SETS D ON
                    (D.group_header_id = C.group_header_id)
                WHERE
                    E.ACTIVE_FLAG = 'Y'
                    AND (d.POLICY_SET_HEADER_ID = {$sets->s_set})
                    {$sql_con2}
                    AND c.YEAR = {$s_period}
                GROUP BY
                    D.policy_set_header_id
                    ";
                    $sql_duty_vat .= ($s_company != "") ? ",A.default_diff_amount " : "";
                    $sql_duty_vat .= "
                    ) z ON
                (z.policy_set_header_id = l.policy_set_header_id
                    AND z.year = l.year)
            WHERE
            l.program_code = 'IRP0003'
                AND l.YEAR = {$s_period}
                AND l.status != 'CANCELLED'
                and l.policy_set_header_id = {$sets->s_set}
            GROUP BY
                l.policy_set_header_id,
                l.receivable_name,
                company_code,
	            company_percent";
                $sql_duty_vat .= ($s_company != "") ? ",z.default_diff_amount " : "";
                $sql_duty_vat .= "
            ORDER BY
                l.policy_set_header_id,
                NVL(l.RECEIVABLE_NAME, ' ')";
            $compact['data_duty_vat'] = DB::table(DB::raw("({$sql_duty_vat}) b"))->get();

            $data_diff_array_grand_total = [];
            if ($is_company) {
                $this->setCalcalate($data, $data_diff_array_grand_total, $s_period, $sets->s_set);

                $data = $data->filter(function ($item) use ($query_company_f, $query_company_t) {
                    return $item->group_comp_code >= $query_company_f  && $item->group_comp_code <= $query_company_t;
                })->values();
            }

            $compact['progTitle'] = "ชุดที่ " . $sets->s_set . " : " . $sets->set_title;
            $progPara[0] = "<span style='font-size: 16px;'  class='b'>" . $progReport->description . "</span>";
            $progPara[1] = "<span style='font-size: 16px;'  class='b'>ตั้งแต่วันที่</span><span style='font-size: 18px;font-weight: normal;'> $thDate_f </span><span style='font-size: 16px;'  class='b'>ถึง</span><span style='font-size: 16px;font-weight: normal;'> $thDate_t </span>";
            $headLeft[0] = "<span class='b'>ผู้รับประกันภัย : </span>" . $companies->comp_name;
            $headLeft[1] = "<span class='b'>เลขที่กรมธรรม์ : </span>" . $companies->policy_no;
            $headLeft[2] = "<span class='b'>เลขที่สลักหลัง : </span>" . $companies->comments;
            $compact['progType'] = $expense->exp_title;
            $headRight[0] = "";

            $compact['data'] = $data;
            $compact['diff_value'] = $diff_value;
            $compact['expense'] = $expense;
            $compact['progPara'] = $progPara;
            $compact['headLeft'] = $headLeft;
            $compact['headLeft'] = $headLeft;
            //$compact['comp_percent'] = array_sum(explode(', ', $companies->company_percent));
            // $headRight[0] = "เลขที่กรมธรรม์ : ".$companies->policy_no;
        } else {
            $compact['diff_value'] = 'N';
            $compact['data'] = '';
            $compact['expense'] = '';
            $compact['progPara'] = '';
            $compact['headLeft'] = '';
            $compact['headLeft'] = '';
            $compact[''] = 0;
        }
        return $compact;
    }

    public function setCalcalate(&$masterData, &$data_diff_array_grand_total, $s_period, $s_set) {

        /* GET COMPANY FOR DEFAULT DIFF */
        $tb_company_default_diff = "
            SELECT
                D.policy_set_header_id,
                max(A.COMPANY_CODE) comp_code,
                max(E.company_name) as comp_name,
                max(A.DEFAULT_DIFF_AMOUNT) as default_diff_amt
            FROM PTIR_POLICY_GROUP_DISTS A
            JOIN PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
            JOIN PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
            JOIN PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
            WHERE E.ACTIVE_FLAG ='Y'
                AND POLICY_SET_HEADER_ID = '{$s_set}'
                AND DEFAULT_DIFF_AMOUNT = 'Y'
                AND C.YEAR = '{$s_period}'
            GROUP BY D.policy_set_header_id, A.company_code
            ORDER BY 1,2
        ";
        $data_company_default_diff = DB::table(DB::raw("({$tb_company_default_diff}) a"))->first();
        $default_company_code = $data_company_default_diff->comp_code;

        /* GET COMPANY PERCENT */
        $tb_company_percent_list = "
            SELECT
                D.policy_set_header_id,
                max(E.company_name) company_name,
                max(A.company_code) company_code,
                max(A.COMPANY_PERCENT) company_percent
            FROM
                PTIR_POLICY_GROUP_DISTS A
                JOIN PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                JOIN PTIR_POLICY_GROUP_LINES C on (C.group_line_id = A.group_line_id)
                JOIN PTIR_POLICY_GROUP_SETS D on (D.group_header_id = C.group_header_id)
            WHERE
                E.ACTIVE_FLAG = 'Y'
                AND C.YEAR = '{$s_period}'
                AND D.policy_set_header_id = '{$s_set}'
            GROUP BY
                D.policy_set_header_id,
                A.company_code

        ";
        $data_company_percent_list = DB::table(DB::raw("({$tb_company_percent_list}) a"))->get();

        /* GET TOTAL AMT */
        $tb_total_all_companies = "
            SELECT
                l.POLICY_SET_HEADER_ID policy_set,
                'ค่าเบี้ยประกันภัยจ่ายล่วงหน้า - ' || NVL(l.RECEIVABLE_NAME,'ส่วนกลาง') receivable_name,
                sum(round(NVL(l.COVERAGE_AMOUNT, 0), 2) * round(NVL('100', 0) / 100, 2)) amt_cost,
                sum(round(NVL(l.insurance_amount, 0), 2) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)) amt_insure,
                CASE WHEN LENGTH(l.RECEIVABLE_NAME) > 0 THEN 0 ELSE sum(
                    CASE WHEN NVL(h.include_tax_flag, '') = 'Y' THEN round(NVL(l.net_amount, 0), 2) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)
                        ELSE ( round(NVL(l.insurance_amount, 0), 2) + round(NVL(l.duty_amount, 0), 2) ) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)
                    END )
                END amt_close,
                sum(round(NVL(l.duty_amount, 0), 2) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)) amt_duty,
                sum(round(NVL(l.vat_amount, 0), 2) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)) amt_vat
            FROM
                PTIR_ASSET_LINES l
            JOIN (
                SELECT
                    max(A.company_code) company_code,
                    max(A.company_percent) company_percent,
                    max(E.company_name) company_name,
                    max(C.prepaid_insurance) prepaid_insurance,
                    max(C.premium_rate) premium_rate,
                    max(D.policy_set_header_id) policy_set_header_id,
                    max(C.year) YEAR,
                    max(E.company_id) company_id
                FROM PTIR_POLICY_GROUP_DISTS A
                JOIN PTIR_COMPANIES E ON E.COMPANY_NUMBER = A.COMPANY_CODE
                JOIN PTIR_POLICY_GROUP_LINES C ON (C.group_line_id = A.group_line_id)
                JOIN PTIR_POLICY_GROUP_SETS D ON (D.group_header_id = C.group_header_id)
                JOIN PTIR_ASSET_LINES L ON l.policy_set_header_id = D.POLICY_SET_HEADER_ID
                WHERE E.ACTIVE_FLAG = 'Y'
                    AND ( D.policy_set_header_id = '{$s_set}' )
                    AND C.year = '{$s_period}'
                GROUP BY D.policy_set_header_id ) z ON
                ( z.policy_set_header_id = l.policy_set_header_id AND z.year = l.year )
            JOIN PTIR_POLICY_SET_HEADERS h ON  (h.policy_set_header_id = l.policy_set_header_id)
            LEFT JOIN PTIR_ASSET_HEADERS ph ON ( ph.header_id = l.header_id AND ph.year = l.year AND ph.status != 'CANCELLED' AND ph.program_code = l.program_code)
            WHERE l.program_code = 'IRP0003'
                AND NVL(l.ASSET_STATUS, '') = 'Y'
                AND l.POLICY_SET_HEADER_ID = '{$s_set}'
                AND l.status != 'CANCELLED'
            GROUP BY l.POLICY_SET_HEADER_ID, l.receivable_name
            ORDER BY l.POLICY_SET_HEADER_ID, NVL(l.receivable_name, ' ')";

        $data_total_all_companies = DB::table(DB::raw("({$tb_total_all_companies}) a"))->get();

        //result => amt that shows on the report
        //result2 => grand total
        //result3 => amt that is calculated by percentage
        //result4 => amt that is calculated by 2 digit

        $result = [];  //Sum of each record
        $result2 = [];  //Grand Total

        foreach ($masterData as $item) {
            $key1 = $item->policy_set . '_' . $item->receivable_name;
            $key2 = $item->group_comp_code;
            $key3 = $item->policy_set;
            if (!array_key_exists($key1, $result)) {
                $result[$key1] = [];
            }

            if (!array_key_exists($key2, $result[$key1])) {
                $result[$key1][$key2]['amt_insure'] = 0;
                $result[$key1][$key2]['amt_cost'] = 0;
                $result[$key1][$key2]['amt_close'] = 0;

            }

            $result[$key1][$key2]['amt_insure'] += $item->amt_insure;
            $result[$key1][$key2]['amt_cost'] +=  $item->amt_cost;
            $result[$key1][$key2]['amt_close'] +=  $item->amt_close;

        }

        /* CONVERT RESULT1 AMT TO 2 DIGIT */
        foreach ($result as $key => $section) {
            foreach ($section as $key2 => $sec_comp) {
                $result[$key][$key2]['amt_insure'] = round($result[$key][$key2]['amt_insure'], 2);
                $result[$key][$key2]['amt_cost'] =  round($result[$key][$key2]['amt_cost'], 2);
                $result[$key][$key2]['amt_close'] =  round($result[$key][$key2]['amt_close'], 2);

            }
        }

        /* FIND AMT BY PERCENTAGE */
        $result3 = $result;
        foreach ($result3 as $key1 => $section) {
            $policy_set_receivable_name = explode('_', $key1);
            $policy_set_key = $policy_set_receivable_name[0];
            $receivable_name_key = $policy_set_receivable_name[1];

            foreach ($section as $key2 => $sec_comp) {
                $company_code = $key2;
                $company_percent_filter = current(array_filter(json_decode(json_encode($data_company_percent_list), true), function ($item) use ($company_code, $policy_set_key) {
                    return $item['company_code'] == $company_code && $item['policy_set_header_id'] ==  $policy_set_key;
                }));
                $company_percent = count($company_percent_filter) > 0 ? $company_percent_filter['company_percent'] : 100;
                $data_filter = current(array_filter(json_decode(json_encode($data_total_all_companies), true), function ($item) use ($policy_set_key, $receivable_name_key) {
                    return $item['policy_set'] ==  $policy_set_key && $item['receivable_name'] ==  $receivable_name_key;
                }));

                $result3[$key1][$key2]['amt_insure'] = round($data_filter['amt_insure'] * $company_percent / 100, 2);
                $result3[$key1][$key2]['amt_cost'] =  round($data_filter['amt_cost'] * $company_percent / 100, 2);
                $result3[$key1][$key2]['amt_close'] =  round($data_filter['amt_close'] * $company_percent / 100, 2);

            }
        }

        $data_2digit = $masterData;
        /* CONVERT DATA AMT TO 2 DIGIT */
        foreach ($data_2digit as $item) {
            $item->amt_insure = round($item->amt_insure, 2);
            $item->amt_cost = round($item->amt_cost, 2);
            $item->amt_close = round($item->amt_close, 2);

        }

        /* FIND AMT FROM SUM DETAIL */
        $result4 = $result;
        foreach ($result4 as $key1 => $section) {
            $policy_set_receivable_name = explode('_', $key1);
            $policy_set_key = $policy_set_receivable_name[0];
            $receivable_name_key = $policy_set_receivable_name[1];

            foreach ($section as $key2 => $sec_comp) {
                $company_code = $key2;
                $data_2digit_filter = array_filter(json_decode(json_encode($data_2digit), true), function ($item) use ($company_code, $policy_set_key, $receivable_name_key) {
                    return $item['group_comp_code'] == $company_code && $item['policy_set'] ==  $policy_set_key && $item['receivable_name'] ==  $receivable_name_key;
                });
                $result4[$key1][$key2]['amt_insure'] = round(array_sum(array_column($data_2digit_filter, 'amt_insure')), 2);
                $result4[$key1][$key2]['amt_cost'] =  round(array_sum(array_column($data_2digit_filter, 'amt_cost')), 2);
                $result4[$key1][$key2]['amt_close'] =  round(array_sum(array_column($data_2digit_filter, 'amt_close')), 2);

            }
        }

        /* CALCULATE DIFF FOR EACH SECT */
        $data_diff_each_sect_array = $result;
        foreach ($data_diff_each_sect_array as $key1 => $section) {
            $policy_set_receivable_name = explode('_', $key1);
            $policy_set_key = $policy_set_receivable_name[0];
            $receivable_name_key = $policy_set_receivable_name[1];

            foreach ($section as $key2 => $sec_comp) {
                $company_code = $key2;
                // if ($company_code == $default_company_code) continue;

                $data_filter_not_default_company = array_filter(json_decode(json_encode($masterData), true), function ($item) use ($company_code, $policy_set_key, $receivable_name_key) {
                    return $item['group_comp_code'] == $company_code && $item['policy_set'] ==  $policy_set_key && $item['receivable_name'] ==  $receivable_name_key;
                });

                $this->setDiffValueToDataForEachSection($masterData, $data_filter_not_default_company, $key1, $key2, $result, $result3, $result4, 'amt_cost', 'amt_cost');
                $this->setDiffValueToDataForEachSection($masterData, $data_filter_not_default_company, $key1, $key2, $result, $result3, $result4, 'amt_insure', 'amt_insure');
                $this->setDiffValueToDataForEachSection($masterData, $data_filter_not_default_company, $key1, $key2, $result, $result3, $result4, 'amt_close', 'amt_close');

            }
        }


        /* RECALCULATE RESULT AND GEN RESULT2*/
        $result = [];
        foreach ($masterData as $item) {
            $key1 = $item->policy_set . '_' . $item->receivable_name;
            $key2 = $item->group_comp_code;
            $key3 = $item->policy_set;
            if (!array_key_exists($key1, $result)) {
                $result[$key1] = [];
            }

            if (!array_key_exists($key2, $result[$key1])) {
                $result[$key1][$key2]['amt_insure'] = 0;
                $result[$key1][$key2]['amt_cost'] = 0;
                $result[$key1][$key2]['amt_close'] = 0;

            }

            //This is for amt in the data detail
            /* RESULT1 - EXAMPLE
            [
                {policy_set_receivable_name1} => [ {comp_code1} => {amt_insure, amt_cost, amt_close, amt_end_month...}, {comp_code2} => {amt_insure, amt_cost, amt_close, amt_end_month...}, {comp_code3} => {amt_insure, amt_cost, amt_close, amt_end_month...}],
                {policy_set_receivable_name2} => [ {comp_code1} => {amt_insure, amt_cost, amt_close, amt_end_month...}, {comp_code2} => {amt_insure, amt_cost, amt_close, amt_end_month...}, {comp_code3} => {amt_insure, amt_cost, amt_close, amt_end_month...}],
                ....
            ]
            */
            $result[$key1][$key2]['amt_insure'] += $item->amt_insure;
            $result[$key1][$key2]['amt_cost'] +=  $item->amt_cost;
            $result[$key1][$key2]['amt_close'] +=  $item->amt_close;


            //This is for amt_insure, amt_duty and amt_vat
            /* RESULT2 - EXAMPLE
            [
                {policy_set1} => [ {comp_code1} => {amt_insure, amt_duty, amt_vat}, {comp_code2} => {amt_insure, amt_duty, amt_vat}, {comp_code3} => {amt_insure, amt_duty, amt_vat}],
                {policy_set2} => [ {comp_code1} => {amt_insure, amt_duty, amt_vat}, {comp_code2} => {amt_insure, amt_duty, amt_vat}, {comp_code3} => {amt_insure, amt_duty, amt_vat}],
                ....
            ]
            */
            if (!array_key_exists($key3, $result2)) {
                $result2[$key3] = [];
            }
            if (!array_key_exists($key2, $result2[$key3])) {
                $result2[$key3][$key2] = [];
                $result2[$key3][$key2]['amt_insure'] = 0;
                $result2[$key3][$key2]['amt_duty'] = 0;
                $result2[$key3][$key2]['amt_vat'] = 0;
            }

            $result2[$key3][$key2]['amt_insure'] += $item->amt_insure;
            $result2[$key3][$key2]['amt_duty'] += $item->amt_duty;
            $result2[$key3][$key2]['amt_vat'] += $item->amt_vat;
        }


        /* CONVERT RESULT1 AMT TO 2 DIGIT */
        foreach ($result as $key => $section) {
            foreach ($section as $key2 => $sec_comp) {
                $result[$key][$key2]['amt_insure'] = round($result[$key][$key2]['amt_insure'], 2);
                $result[$key][$key2]['amt_cost'] =  round($result[$key][$key2]['amt_cost'], 2);
                $result[$key][$key2]['amt_close'] =  round($result[$key][$key2]['amt_close'], 2);

            }
        }

        /* CONVERT RESULT2 AMT TO 2 DIGIT */
        foreach ($result2 as $key => $section) {
            foreach ($section as $key2 => $sec_comp) {
                $result2[$key][$key2]['amt_insure'] = round($result2[$key][$key2]['amt_insure'], 2);
                $result2[$key][$key2]['amt_duty'] =  round($result2[$key][$key2]['amt_duty'], 2);
                $result2[$key][$key2]['amt_vat'] =  round($result2[$key][$key2]['amt_vat'], 2);
            }
        }

        /* GET TOTAL AMT WHEN RUN IN EACH COMPANY */
        $data_total_each_company = [];
        foreach ($result as $index => $companies) {
            $data_total_each_company[$index] = [];
            $data_total_each_company[$index]['amt_insure'] = 0;
            $data_total_each_company[$index]['amt_cost'] = 0;
            $data_total_each_company[$index]['amt_close'] = 0;

            foreach ($companies as $item) {
                $data_total_each_company[$index]['amt_insure'] += round($item['amt_insure'], 2);
                $data_total_each_company[$index]['amt_cost'] += round($item['amt_cost'], 2);
                $data_total_each_company[$index]['amt_close'] += round($item['amt_close'], 2);

            }
        }

        /* GET DIFF FOR DETAIL */
        /* EXAMPLE
           [
             {policy_set1} => [ {recievable_name1, amt_cost ...} , {recievable_name2, amt_cost ...}, {recievable_name3, amt_cost ...}],
             {policy_set2} => [ {recievable_name1, amt_cost ...} , {recievable_name2, amt_cost ...}, {recievable_name3, amt_cost ...}],
             ....
           ]
        */
        $data_diff_array = [];
        foreach ($data_total_all_companies as $key => $section) { // $data_total_all_companies == masterData

            $policy_key = $section->policy_set;
            if (!array_key_exists($policy_key, $data_diff_array)) {
                $data_diff_array[$policy_key] = [];
            }

            $receivable_name_key = $section->receivable_name;
            $data_diff_value = [];
            $key = $section->policy_set . '_' . $section->receivable_name;

            $data_diff_value['amt_cost'] = round($section->amt_cost - $data_total_each_company[$key]['amt_cost'], 2);
            $data_diff_value['amt_insure'] = round($section->amt_insure - $data_total_each_company[$key]['amt_insure'], 2);
            $data_diff_value['amt_close'] = round($section->amt_close - $data_total_each_company[$key]['amt_close'], 2);

            $data_diff_array[$policy_key][$receivable_name_key] = $data_diff_value;
        }


        /* GET DIFF FOR GRAND TOTAL */
        foreach ($result2 as $key => $section) {
            $policy_key = $key;
            if (!array_key_exists($policy_key, $data_diff_array_grand_total)) {
                $data_diff_array_grand_total[$policy_key] = [];
            }

            $data_total_all_companies_filter_by_policy_set = array_filter(json_decode(json_encode($data_total_all_companies), true), function ($item) use ($policy_key) {
                return $item['policy_set'] == $policy_key;
            });
            // $data_diff_array_filter_by_policy_set = $data_diff_array[$policy_key];

            // $amt_insure_diff = round(array_sum(array_column(json_decode(json_encode($data_diff_array_filter_by_policy_set), true), 'amt_insure')), 2);
            $data_diff_array_grand_total[$policy_key]['default_company'] = $default_company_code;
            // $data_diff_array_grand_total[$policy_key]['amt_insure_diff'] = $amt_insure_diff;
            // $data_diff_array_grand_total[$policy_key]['amt_insure_origin'] = round(array_sum(array_column(json_decode(json_encode($data_total_all_companies_filter_by_policy_set), true), 'amt_insure')), 2) - round(array_sum(array_column($section, 'amt_insure')), 2);
            // $data_diff_array_grand_total[$policy_key]['amt_insure'] = $data_diff_array_grand_total[$policy_key]['amt_insure_origin'] + ($data_diff_array_grand_total[$policy_key]['amt_insure_diff'] * -1);
            $data_diff_array_grand_total[$policy_key]['amt_duty'] = round(round(array_sum(array_column(json_decode(json_encode($data_total_all_companies_filter_by_policy_set), true), 'amt_duty')), 2) - round(array_sum(array_column($section, 'amt_duty')), 2), 2);
            $data_diff_array_grand_total[$policy_key]['amt_vat'] = round(round(array_sum(array_column(json_decode(json_encode($data_total_all_companies_filter_by_policy_set), true), 'amt_vat')), 2) - round(array_sum(array_column($section, 'amt_vat')), 2), 2);
        }

        /* CALCULATE DIFF FOR DEFAULT COMPANY */
        foreach ($data_diff_array as $key => $section) {
            $policy_set_key = $key;
            foreach ($section as $key2 => $item) {
                $receivable_name_key = $key2;
                $data_filter_by_default_company = array_filter(json_decode(json_encode($masterData), true), function ($item) use ($default_company_code, $policy_set_key, $receivable_name_key) {
                    return $item['group_comp_code'] == $default_company_code && $item['policy_set'] ==  $policy_set_key && $item['receivable_name'] ==  $receivable_name_key;
                });

                $this->setDiffValueToData($masterData, $data_filter_by_default_company, $item, 'amt_cost', 'amt_cost');
                $this->setDiffValueToData($masterData, $data_filter_by_default_company, $item, 'amt_insure', 'amt_insure');
                $this->setDiffValueToData($masterData, $data_filter_by_default_company, $item, 'amt_close', 'amt_close');

            }
        }

    }

    public function setDiffValueToData(&$arr, $data_filter, $diff_arr, $col_name_data, $col_name_diff) {
        if (count($data_filter) <= 0) return;

        $key = $this->getKeyOfMaxValue($data_filter, $col_name_data);
        $index = array_search($key, array_column(json_decode(json_encode($arr)), 'formatted_guid'));

        $arr[$index]->$col_name_data += $diff_arr[$col_name_diff];
        //Also update amt_end_month_mm_yyyy
        if ($col_name_data != $col_name_diff) {
            $arr[$index]->$col_name_diff = $arr[$index]->$col_name_data;
        }

    }

    public function setDiffValueToDataForEachSection(&$arr, $data_filter, $key1, $key2, $result, $result3, $result4, $col_name_data, $col_name_diff) {

        $key = $this->getKeyOfMaxValue($data_filter, $col_name_data);
        $index = array_search($key, array_column(json_decode(json_encode($arr)), 'formatted_guid'));

        $diff_result3_and_result = round($result3[$key1][$key2][$col_name_diff] - $result[$key1][$key2][$col_name_diff], 2);
        $diff_result3_and_result4 = round($result3[$key1][$key2][$col_name_diff] - $result4[$key1][$key2][$col_name_diff], 2);

        if ($diff_result3_and_result == $diff_result3_and_result4 && $diff_result3_and_result4 != 0) {
            //e.g. result = 4.92, result3 = 4.91, result4 = 4.92; find max value of the column and add/sub diff amt
            $arr[$index]->$col_name_data += $diff_result3_and_result4;
        } else if (($diff_result3_and_result != $diff_result3_and_result4) && $diff_result3_and_result == 0) {
            //e.g. result = 4.91, result3 = 4.91, result4 = 4.92; find max value and round value before add/sub diff amt
            $arr[$index]->$col_name_data = round($arr[$index]->$col_name_data, 2) + $diff_result3_and_result4;
        }

        //Also update amt_end_month_mm_yyyy
        if ($col_name_data != $col_name_diff) {
            $arr[$index]->$col_name_diff = $arr[$index]->$col_name_data;
        }

    }

    public function getKeyOfMaxValue($arr, $column_name) {
        $max = max(array_column($arr, $column_name));
        // keys of max value
        $keys = array_filter(array_map(function ($arr) use ($max, $column_name) {
            return $arr[$column_name] == $max ? $arr['formatted_guid'] : null;
        }, $arr));
        return reset($keys);
    }
}
