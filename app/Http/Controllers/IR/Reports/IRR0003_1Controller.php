<?php
namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class IRR0003_1Controller extends Controller{
	public function export($programCode, $request){
        $programCode_Output = 'IRR0003-1'; // programCode Show Report
        $programCode_Query = 'IRR6050P'; // programCode use Query
        $s_set_f = $request['s_set_f']; // กรมธรรม์ชุดที่ ตั้งแต่ *
        $s_set_t = $request['s_set_t']; // กรมธรรม์ชุดที่ ถึง *
        $s_period = $request['s_period']; // ตั้งแต่วันที่ *
        $company_f = $request['company_f']; // บริษัทประกัน
        $company_t = ($request['company_t'] != '') ? $request['company_t'] : $request['company_f'];
        $progReport = ProgramInfo::where('program_code', $programCode_Query)->first();
        $repTitle = $progReport->description;
        $is_company = ($company_f != "" && $company_t != "");

        $query_company_f = $company_f;
        $query_company_t = $company_t;
        if ($company_f != "" && $company_t != ""){
            $company_f = 1;
            $company_t = 99;
        }

        $sql_con="";
        $sql_con.=($company_f!="" && $company_t!="")?" and (z.COMPANY_ID between '{$company_f}' and '{$company_t}')":"";

        $tb_set = "
            SELECT
                POLICY_SET_DESCRIPTION set_desc
            FROM
                PTIR_ASSET_HEADERS
            WHERE
                program_code='IRP0003'
                AND ( POLICY_SET_HEADER_ID BETWEEN '{$s_set_f}' and '{$s_set_t}')
        ";
        $sets=DB::table(DB::raw("({$tb_set}) a"))->get()->first();
        $set_title = $sets->set_desc;

        $tb_date = "
            SELECT
                trunc(insurance_end_date) - trunc(insurance_start_date) AS days_year,
                DAY_NUM AS days_left,
                POLICY_SET_DESCRIPTION AS set_title,
                insurance_start_date AS  date_f,
                insurance_end_date AS  date_t,
                to_char(insurance_start_date,'dd monYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') AS dateth_f,
                to_char(insurance_end_date,'dd monYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') AS dateth_t,
                year AS year
            FROM
                PTIR_ASSET_HEADERS
            WHERE
                program_code = 'IRP0003'
                AND YEAR = '{$s_period}'
                AND ( POLICY_SET_HEADER_ID BETWEEN '{$s_set_f}' AND '{$s_set_t}')
        ";
        $dates = DB::table(DB::raw("({$tb_date}) a"))->get();
        $date_f = (count($dates)>0) ? $dates->first()->date_f : date('Y-m-d',strtotime('first of year'));
        $date_t = (count($dates)>0) ? $dates->first()->date_t : date('Y-m-d',strtotime('end of year'));
        $days_year = (count($dates)>0) ? $dates->first()->days_year : 365;

        $date_f = date('Y-m-d',strtotime($date_f));
        $date_t = date('Y-m-d',strtotime($date_t));
        $thDate_f = parseToDateTh($date_f);
        $thDate_t = parseToDateTh($date_t);

        $tb_period = "
            SELECT
                TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR'))-(TRUNC(SYSDATE)-TRUNC(START_DATE_ACTIVE)) as days_left
            FROM
                PTIR_EFFECTIVE_DATE
            WHERE
                LOOKUP_CODE = '{$s_period}'
                AND ENABLED_FLAG = 'Y'
        ";
        $periods=DB::table(DB::raw("({$tb_period}) a"))->get()->first();
        $days_left = $periods->days_left;

        $tb_month = "
            SELECT
                mth_code AS mth_code,
                mth_days AS mth_days,
                mth_th AS mth_th,
                add_months(trunc(input_date, 'YYYY'), 12) - trunc(input_date, 'YYYY') AS days_in_year,
                mth_first_date AS mth_first_date
            FROM
            (
                SELECT
                    add_months(DATE '{$date_f}' + 1, LEVEL-1) AS input_date,
                    'm' || LEVEL AS mth_code,
                    add_months(DATE '{$date_f}' + 1, LEVEL)-add_months(DATE '{$date_f}' + 1, LEVEL-1) AS mth_days,
                    to_char(add_months(DATE '{$date_f}' + 1, LEVEL-1),
                        'monYY',
                        'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') AS mth_th,
                    to_char(add_months(DATE '{$date_f}', LEVEL-1), 'YYYYmm') || '01' AS mth_first_date
                FROM
                    dual
                CONNECT BY
                    LEVEL <= months_between(DATE '{$date_t}' + 1, DATE '{$date_f}')
            )
        ";
        $months = DB::table(DB::raw("({$tb_month}) a"))->get();

        $sql_company = ( $company_f != "" && $company_t != "" ) ? " AND (A.COMPANY_CODE BETWEEN {$company_f} AND {$company_t})" : "";
        $tb_company = "
            SELECT
                z.POLICY_SET_HEADER_ID,
                LISTAGG(COMPANY_NAME,', ') WITHIN GROUP (ORDER BY COMPANY_NAME) AS comp_name,
                LISTAGG(COMPANY_CODE,', ') WITHIN GROUP (ORDER BY COMPANY_CODE) AS comp_code
            FROM (
                SELECT
                    A.company_code,A.company_percent,
                    E.COMPANY_NAME,C.prepaid_insurance,
                    D.policy_set_header_id,C.year,E.company_id
                FROM PTIR_POLICY_GROUP_DISTS A
                    JOIN PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                    JOIN PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
                    JOIN PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
                    JOIN PTIR_POLICY_GROUP_HEADERS B ON C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
                WHERE E.ACTIVE_FLAG ='Y'
                    AND (D.POLICY_SET_HEADER_ID BETWEEN '{$s_set_f}' AND '{$s_set_t}')
                    AND C.YEAR = '{$s_period}'
                    {$sql_company}
                ORDER BY
                    D.POLICY_SET_HEADER_ID
            ) z
            GROUP BY
                Z.POLICY_SET_HEADER_ID
        ";
        $companys = DB::table(DB::raw("({$tb_company}) a"))->get()->first();

        $comp_code = ($company_f != "" && $company_t != "") ? "z.company_code" : "'{$companys->comp_code}'";
        $comp_name = ($company_f != "" && $company_t != "") ? "z.company_name" : "'{$companys->comp_name}'";
        // $group_comp_code = ($company_f != "" && $company_t != "") ? "z.company_code" : "LISTAGG(z2.company_code,', ') WITHIN GROUP (ORDER BY z2.company_code)";
        // $group_comp_name = ($company_f != "" && $company_t != "") ? "z.company_name" : "LISTAGG(z2.COMPANY_NAME,', ') WITHIN GROUP (ORDER BY z2.COMPANY_NAME)";
        $group_comp_code = ($company_f != "" && $company_t != "") ? "z.company_code" : "z2.COMPANY_CODE";
        $group_comp_name = ($company_f != "" && $company_t != "") ? "z.company_name" : "z2.COMPANY_NAME";
        $comp_percent=($company_f!="" && $company_t!="")?"z.company_percent":"'100'";
        $insur_percent=($company_f!="" && $company_t!="")?"z.prepaid_insurance":"'100'";

        $sel_mth = "";
        $amt_all_month = "";
        $end_month_arr = [];
        foreach($months as $m){
            $val=$m->mth_days/$days_year;
            $as="amt_".$m->mth_code;
            $col_name="END_MONTH_".$m->mth_days."_".$m->days_in_year;

            if($m->mth_code != "m12") {
                $sel_mth.="
                    CASE WHEN LENGTH(l.RECEIVABLE_NAME) > 0 THEN 0 ELSE ROUND(sum(l.$col_name * $comp_percent / 100), 2) END $as ,
                ";
                $amt_all_month.="
                    - ROUND(sum(l.$col_name * $comp_percent / 100), 2)
                ";
            }
            //$sel_mth.="sum(round(NVL(l.insurance_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)*$val) $as ,";
            $end_month_arr['amt_' . $m->mth_code] = strtolower("amt_$col_name");

        }
        $sel_mth .= "ROUND(sum(l.end_month_28_365 * $comp_percent/ 100), 2) amt_end_month_28_365, ";
        $sel_mth .= "ROUND(sum(l.end_month_30_365 * $comp_percent/ 100), 2) amt_end_month_30_365, ";
        $sel_mth .= "ROUND(sum(l.end_month_31_365 * $comp_percent/ 100), 2) amt_end_month_31_365, ";
        $sel_mth .= "ROUND(sum(l.end_month_29_366 * $comp_percent/ 100), 2) amt_end_month_29_366, ";
        $sel_mth .= "ROUND(sum(l.end_month_30_366 * $comp_percent/ 100), 2) amt_end_month_30_366, ";
        $sel_mth .= "ROUND(sum(l.end_month_31_366 * $comp_percent/ 100), 2) amt_end_month_31_366, ";

        $sel_mth_last = "
            CASE
                WHEN LENGTH(l.RECEIVABLE_NAME) > 0 THEN 0
                ELSE ROUND(sum (
                    CASE
			            WHEN NVL(h.include_tax_flag, '')= 'Y' THEN round(NVL(l.net_amount, 0), 2)* round(NVL($comp_percent, 0)/ 100, 2)* round(NVL(z.prepaid_insurance, 0)/ 100, 2)
			            ELSE (round(NVL(l.insurance_amount, 0), 2)+ round(NVL(l.duty_amount, 0), 2))* round(NVL($comp_percent, 0)/ 100, 2)* round(NVL(z.prepaid_insurance, 0)/ 100, 2)
		                END ) {$amt_all_month}, 2) END amt_m12 ,
        ";
        $join_company = ($company_f != "" && $company_t != "") ? "
            select
                A.company_code,
                A.company_percent,
                E.company_name,
                C.prepaid_insurance,
                C.premium_rate,
                D.policy_set_header_id,
                C.year,
                E.company_id
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
                AND (d.POLICY_SET_HEADER_ID BETWEEN '{$s_set_f}' and '{$s_set_t}')
                AND c.YEAR = '{$s_period}'
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
                AND C.YEAR = '{$s_period}'
                GROUP BY D.policy_set_header_id, A.company_code
                ORDER BY 1,2
            )
            GROUP BY policy_set_header_id
          ) z2 ON (z2.policy_set_header_id = l.policy_set_header_id)";

        $tb_view="
            SELECT
                rawtohex(sys_guid()) as FORMATTED_GUID,
                l.POLICY_SET_HEADER_ID policy_set,
                'ชุดที่ ' || l.POLICY_SET_HEADER_ID || ' : ' || max(l.POLICY_SET_DESCRIPTION) program_title,
                {$group_comp_code} group_comp_code,
                {$group_comp_name} group_comp,
                {$comp_percent} comp_percent,
                {$insur_percent} insur_percent,
                MAX(l.location_name) group_01,
                MAX(l.department_name) group_02,
                MAX(l.CATEGORY_DESCRIPTION) cat_title,
                {$sel_mth}
                {$sel_mth_last}
                max((TRUNC(NVL(l.CALCULATE_END_DATE,SYSDATE+1))-TRUNC(SYSDATE))/TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR'))) aa,
                max(NVL(z.PREMIUM_RATE,0)) rate_set,
                max(NVL(z.prepaid_insurance,0)) amt_prepaid,
                max(NVL(z.company_percent,0)) rate_comp,
                sum(round(NVL(l.COVERAGE_AMOUNT,0),2)) cover,
                sum(round(NVL(l.insurance_amount,0),2)) insur,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)*round(NVL(z.premium_rate,0),2)) amt_cover,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_insure,
                sum(round(NVL(l.COVERAGE_AMOUNT,0),2)*round(NVL({$comp_percent}, 0)/100,2)) amt_cost,
                CASE WHEN LENGTH(l.RECEIVABLE_NAME) > 0 THEN 0 ELSE sum (
                    CASE
                        WHEN NVL(h.include_tax_flag,'')='Y'
                        THEN round(NVL(l.net_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                        ELSE (round(NVL(l.insurance_amount,0),2)+round(NVL(l.duty_amount,0),2))*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                    END
                ) END amt_close,
                sum(round(NVL(l.duty_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_duty,
                sum(round(NVL(l.vat_amount,0),2)*round(NVL({$comp_percent},0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_vat,
                sum(round(NVL(l.vat_amount,0),2)) amt_vat1,
                sum(round(NVL(l.net_amount,0),2)) amt_net,
                max(ph.status) status,
                l.RECEIVABLE_NAME receivable_name
            FROM PTIR_ASSET_LINES l
            JOIN (
                $join_company
            ) z on (z.policy_set_header_id=l.policy_set_header_id and z.year=l.year)
            $join_company_aggregate
            JOIN PTIR_POLICY_SET_HEADERS h on (h.policy_set_header_id=l.policy_set_header_id)
            LEFT JOIN PTIR_ASSET_HEADERS ph ON
                (ph.policy_set_header_id = l.policy_set_header_id
                AND ph.year = l.year
                AND ph.status != 'CANCELLED'
                AND ph.program_code = l.program_code )
            WHERE l.program_code='IRP0003' and NVL(l.ASSET_STATUS,'')='Y'
                AND (l.POLICY_SET_HEADER_ID BETWEEN '{$s_set_f}' and '{$s_set_t}')
                and l.year='{$s_period}'
                {$sql_con}
                AND l.STATUS != 'CANCELLED'
            GROUP BY l.POLICY_SET_HEADER_ID, {$comp_code}, {$comp_name}, {$comp_percent}, {$insur_percent}, l.RECEIVABLE_NAME , l.LOCATION_CODE , l.DEPARTMENT_CODE , l.CATEGORY_CODE, z2.company_code, z2.COMPANY_NAME
            ORDER BY l.POLICY_SET_HEADER_ID, {$comp_code}, {$comp_name}, {$comp_percent}, {$insur_percent}, NVL(l.RECEIVABLE_NAME, ' '), l.LOCATION_CODE , l.DEPARTMENT_CODE , l.CATEGORY_CODE
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();

        // var_dump($tb_view);
        // dd();

        $data_diff_array_grand_total = [];
        if ($is_company) {
            $this->setCalcalate($data, $data_diff_array_grand_total, $s_period, $s_set_f, $s_set_t, $end_month_arr);

            $data = $data->filter(function ($item) use ($query_company_f, $query_company_t) {
                return $item->group_comp_code >= $query_company_f  && $item->group_comp_code <= $query_company_t;
            })->values();
        }

        $progTitle = "ชุดที่ ".$s_set_f." : ".$set_title;
        // $repTitle  = $repTitle." กับ ";
        $repTitle  = $repTitle;
        $progPara[0]="ตั้งแต่ วันที่ $thDate_f ถึงวันที่ $thDate_t";
        $titles=[
            'dateth_f'=>$thDate_f,
            'dateth_t'=>$thDate_t,
            'set_title'=>$set_title,
            'days_left'=>$days_left,
            'days_year'=>$days_year,
            'insur_percent'=>$insur_percent,
            'comp_percent'=>$comp_percent
        ];

        $pdf = PDF::loadView('ir.reports.irr0003_1.pdf.index',compact('data','titles','months','repTitle','programCode_Output','progTitle', 'data_diff_array_grand_total', 'progPara'))
            ->setPaper('a4','landscape')
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',3)
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode_Output. '.pdf');
    }

    public function setCalcalate(&$masterData, &$data_diff_array_grand_total, $s_period, $s_set_f, $s_set_t, $end_month_arr) {

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
                AND POLICY_SET_HEADER_ID BETWEEN '{$s_set_f}' AND '{$s_set_t}'
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
                AND D.policy_set_header_id BETWEEN '{$s_set_f}' AND '{$s_set_t}'
            GROUP BY
                D.policy_set_header_id,
                A.company_code

        ";
        $data_company_percent_list = DB::table(DB::raw("({$tb_company_percent_list}) a"))->get();

        /* GET TOTAL AMT */
        $tb_total_all_companies = "
            SELECT
                l.POLICY_SET_HEADER_ID policy_set,
                l.RECEIVABLE_NAME receivable_name,
                sum(round(NVL(l.COVERAGE_AMOUNT, 0), 2) * round(NVL('100', 0) / 100, 2)) amt_cost,
                sum(round(NVL(l.insurance_amount, 0), 2) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)) amt_insure,
                CASE WHEN LENGTH(l.RECEIVABLE_NAME) > 0 THEN 0 ELSE sum(
                    CASE WHEN NVL(h.include_tax_flag, '') = 'Y' THEN round(NVL(l.net_amount, 0), 2) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)
                        ELSE ( round(NVL(l.insurance_amount, 0), 2) + round(NVL(l.duty_amount, 0), 2) ) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)
                    END )
                END amt_close,
                sum(round(NVL(l.duty_amount, 0), 2) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)) amt_duty,
                sum(round(NVL(l.vat_amount, 0), 2) * round(NVL('100', 0) / 100, 2) * round(NVL(z.prepaid_insurance, 0) / 100, 2)) amt_vat,
                sum(round(l.END_MONTH_28_365 * '100' / 100, 2)) AS amt_END_MONTH_28_365,
                sum(round(l.END_MONTH_30_365 * '100' / 100, 2)) AS amt_END_MONTH_30_365,
                sum(round(l.END_MONTH_31_365 * '100' / 100, 2)) AS amt_END_MONTH_31_365,
                sum(round(l.END_MONTH_29_366 * '100' / 100, 2)) AS amt_END_MONTH_29_366,
                sum(round(l.END_MONTH_30_366 * '100' / 100, 2)) AS amt_END_MONTH_30_366,
                sum(round(l.END_MONTH_31_366 * '100' / 100, 2)) AS amt_END_MONTH_31_366
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
                    AND ( D.policy_set_header_id BETWEEN '{$s_set_f}' AND '{$s_set_t}' )
                    AND C.year = '{$s_period}'
                GROUP BY D.policy_set_header_id ) z ON
                ( z.policy_set_header_id = l.policy_set_header_id AND z.year = l.year )
            JOIN PTIR_POLICY_SET_HEADERS h ON  (h.policy_set_header_id = l.policy_set_header_id)
            LEFT JOIN PTIR_ASSET_HEADERS ph ON ( ph.header_id = l.header_id AND ph.year = l.year AND ph.status != 'CANCELLED' AND ph.program_code = l.program_code)
            WHERE l.program_code = 'IRP0003'
                AND NVL(l.ASSET_STATUS, '') = 'Y'
                AND l.POLICY_SET_HEADER_ID BETWEEN '{$s_set_f}' AND '{$s_set_t}'
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
                $result[$key1][$key2]['amt_end_month_28_365'] = 0;
                $result[$key1][$key2]['amt_end_month_30_365'] = 0;
                $result[$key1][$key2]['amt_end_month_31_365'] = 0;
                $result[$key1][$key2]['amt_end_month_29_366'] = 0;
                $result[$key1][$key2]['amt_end_month_30_366'] = 0;
                $result[$key1][$key2]['amt_end_month_31_366'] = 0;
            }

            $result[$key1][$key2]['amt_insure'] += $item->amt_insure;
            $result[$key1][$key2]['amt_cost'] +=  $item->amt_cost;
            $result[$key1][$key2]['amt_close'] +=  $item->amt_close;
            $result[$key1][$key2]['amt_end_month_28_365'] +=  $item->amt_end_month_28_365;
            $result[$key1][$key2]['amt_end_month_30_365'] +=  $item->amt_end_month_30_365;
            $result[$key1][$key2]['amt_end_month_31_365'] +=  $item->amt_end_month_31_365;
            $result[$key1][$key2]['amt_end_month_29_366'] +=  $item->amt_end_month_29_366;
            $result[$key1][$key2]['amt_end_month_30_366'] +=  $item->amt_end_month_30_366;
            $result[$key1][$key2]['amt_end_month_31_366'] +=  $item->amt_end_month_31_366;
        }

        /* CONVERT RESULT1 AMT TO 2 DIGIT */
        foreach ($result as $key => $section) {
            foreach ($section as $key2 => $sec_comp) {
                $result[$key][$key2]['amt_insure'] = round($result[$key][$key2]['amt_insure'], 2);
                $result[$key][$key2]['amt_cost'] =  round($result[$key][$key2]['amt_cost'], 2);
                $result[$key][$key2]['amt_close'] =  round($result[$key][$key2]['amt_close'], 2);
                $result[$key][$key2]['amt_end_month_28_365'] =  round($result[$key][$key2]['amt_end_month_28_365'], 2);
                $result[$key][$key2]['amt_end_month_30_365'] =  round($result[$key][$key2]['amt_end_month_30_365'], 2);
                $result[$key][$key2]['amt_end_month_31_365'] =  round($result[$key][$key2]['amt_end_month_31_365'], 2);
                $result[$key][$key2]['amt_end_month_29_366'] =  round($result[$key][$key2]['amt_end_month_29_366'], 2);
                $result[$key][$key2]['amt_end_month_30_366'] =  round($result[$key][$key2]['amt_end_month_30_366'], 2);
                $result[$key][$key2]['amt_end_month_31_366'] =  round($result[$key][$key2]['amt_end_month_31_366'], 2);
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
                $result3[$key1][$key2]['amt_end_month_28_365'] =  round($data_filter['amt_end_month_28_365'] * $company_percent / 100, 2);
                $result3[$key1][$key2]['amt_end_month_30_365'] =  round($data_filter['amt_end_month_30_365'] * $company_percent / 100, 2);
                $result3[$key1][$key2]['amt_end_month_31_365'] =  round($data_filter['amt_end_month_31_365'] * $company_percent / 100, 2);
                $result3[$key1][$key2]['amt_end_month_29_366'] =  round($data_filter['amt_end_month_29_366'] * $company_percent / 100, 2);
                $result3[$key1][$key2]['amt_end_month_30_366'] =  round($data_filter['amt_end_month_30_366'] * $company_percent / 100, 2);
                $result3[$key1][$key2]['amt_end_month_31_366'] =  round($data_filter['amt_end_month_31_366'] * $company_percent / 100, 2);
            }
        }

        $data_2digit = $masterData;
        /* CONVERT DATA AMT TO 2 DIGIT */
        foreach ($data_2digit as $item) {
            $item->amt_insure = round($item->amt_insure, 2);
            $item->amt_cost = round($item->amt_cost, 2);
            $item->amt_close = round($item->amt_close, 2);
            $item->amt_end_month_28_365 = round($item->amt_end_month_28_365, 2);
            $item->amt_end_month_30_365 = round($item->amt_end_month_30_365, 2);
            $item->amt_end_month_31_365 = round($item->amt_end_month_31_365, 2);
            $item->amt_end_month_29_366 = round($item->amt_end_month_29_366, 2);
            $item->amt_end_month_30_366 = round($item->amt_end_month_30_366, 2);
            $item->amt_end_month_31_366 = round($item->amt_end_month_31_366, 2);
            foreach ($end_month_arr as $em_col_name_data => $em_col_name_diff) {
                $item->{$em_col_name_data} = round($item->{$em_col_name_data}, 2);
            }
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
                $result4[$key1][$key2]['amt_end_month_28_365'] =  round(array_sum(array_column($data_2digit_filter, 'amt_end_month_28_365')), 2);
                $result4[$key1][$key2]['amt_end_month_30_365'] =  round(array_sum(array_column($data_2digit_filter, 'amt_end_month_30_365')), 2);
                $result4[$key1][$key2]['amt_end_month_31_365'] =  round(array_sum(array_column($data_2digit_filter, 'amt_end_month_31_365')), 2);
                $result4[$key1][$key2]['amt_end_month_29_366'] =  round(array_sum(array_column($data_2digit_filter, 'amt_end_month_29_366')), 2);
                $result4[$key1][$key2]['amt_end_month_30_366'] =  round(array_sum(array_column($data_2digit_filter, 'amt_end_month_30_366')), 2);
                $result4[$key1][$key2]['amt_end_month_31_366'] =  round(array_sum(array_column($data_2digit_filter, 'amt_end_month_31_366')), 2);
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

                foreach (array_slice($end_month_arr, 0, -1) as $em_col_name_data => $em_col_name_diff) {
                    $this->setDiffValueToDataForEachSection($masterData, $data_filter_not_default_company, $key1, $key2, $result, $result3, $result4,  $em_col_name_data, $em_col_name_diff);
                }
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
                $result[$key1][$key2]['amt_end_month_28_365'] = 0;
                $result[$key1][$key2]['amt_end_month_30_365'] = 0;
                $result[$key1][$key2]['amt_end_month_31_365'] = 0;
                $result[$key1][$key2]['amt_end_month_29_366'] = 0;
                $result[$key1][$key2]['amt_end_month_30_366'] = 0;
                $result[$key1][$key2]['amt_end_month_31_366'] = 0;
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
            $result[$key1][$key2]['amt_end_month_28_365'] +=  $item->amt_end_month_28_365;
            $result[$key1][$key2]['amt_end_month_30_365'] +=  $item->amt_end_month_30_365;
            $result[$key1][$key2]['amt_end_month_31_365'] +=  $item->amt_end_month_31_365;
            $result[$key1][$key2]['amt_end_month_29_366'] +=  $item->amt_end_month_29_366;
            $result[$key1][$key2]['amt_end_month_30_366'] +=  $item->amt_end_month_30_366;
            $result[$key1][$key2]['amt_end_month_31_366'] +=  $item->amt_end_month_31_366;

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
                $result[$key][$key2]['amt_end_month_28_365'] =  round($result[$key][$key2]['amt_end_month_28_365'], 2);
                $result[$key][$key2]['amt_end_month_30_365'] =  round($result[$key][$key2]['amt_end_month_30_365'], 2);
                $result[$key][$key2]['amt_end_month_31_365'] =  round($result[$key][$key2]['amt_end_month_31_365'], 2);
                $result[$key][$key2]['amt_end_month_29_366'] =  round($result[$key][$key2]['amt_end_month_29_366'], 2);
                $result[$key][$key2]['amt_end_month_30_366'] =  round($result[$key][$key2]['amt_end_month_30_366'], 2);
                $result[$key][$key2]['amt_end_month_31_366'] =  round($result[$key][$key2]['amt_end_month_31_366'], 2);
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
            $data_total_each_company[$index]['amt_end_month_28_365'] = 0;
            $data_total_each_company[$index]['amt_end_month_30_365'] = 0;
            $data_total_each_company[$index]['amt_end_month_31_365'] = 0;
            $data_total_each_company[$index]['amt_end_month_29_366'] = 0;
            $data_total_each_company[$index]['amt_end_month_30_366'] = 0;
            $data_total_each_company[$index]['amt_end_month_31_366'] = 0;
            foreach ($companies as $item) {
                $data_total_each_company[$index]['amt_insure'] += round($item['amt_insure'], 2);
                $data_total_each_company[$index]['amt_cost'] += round($item['amt_cost'], 2);
                $data_total_each_company[$index]['amt_close'] += round($item['amt_close'], 2);
                $data_total_each_company[$index]['amt_end_month_28_365'] += round($item['amt_end_month_28_365'], 2);
                $data_total_each_company[$index]['amt_end_month_30_365'] += round($item['amt_end_month_30_365'], 2);
                $data_total_each_company[$index]['amt_end_month_31_365'] += round($item['amt_end_month_31_365'], 2);
                $data_total_each_company[$index]['amt_end_month_29_366'] += round($item['amt_end_month_29_366'], 2);
                $data_total_each_company[$index]['amt_end_month_30_366'] += round($item['amt_end_month_30_366'], 2);
                $data_total_each_company[$index]['amt_end_month_31_366'] += round($item['amt_end_month_31_366'], 2);
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
            $data_diff_value['amt_end_month_28_365'] = strlen($section->receivable_name) > 0 ? 0 : round($section->amt_end_month_28_365 - $data_total_each_company[$key]['amt_end_month_28_365'], 2);
            $data_diff_value['amt_end_month_30_365'] = strlen($section->receivable_name) > 0 ? 0 : round($section->amt_end_month_30_365 - $data_total_each_company[$key]['amt_end_month_30_365'], 2);
            $data_diff_value['amt_end_month_31_365'] = strlen($section->receivable_name) > 0 ? 0 : round($section->amt_end_month_31_365 - $data_total_each_company[$key]['amt_end_month_31_365'], 2);
            $data_diff_value['amt_end_month_29_366'] = strlen($section->receivable_name) > 0 ? 0 : round($section->amt_end_month_29_366 - $data_total_each_company[$key]['amt_end_month_29_366'], 2);
            $data_diff_value['amt_end_month_30_366'] = strlen($section->receivable_name) > 0 ? 0 : round($section->amt_end_month_30_366 - $data_total_each_company[$key]['amt_end_month_30_366'], 2);
            $data_diff_value['amt_end_month_31_366'] = strlen($section->receivable_name) > 0 ? 0 : round($section->amt_end_month_31_366 - $data_total_each_company[$key]['amt_end_month_31_366'], 2);

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

                foreach (array_slice($end_month_arr, 0, -1) as $em_col_name_data => $em_col_name_diff) {
                    $this->setDiffValueToData($masterData, $data_filter_by_default_company, $item,  $em_col_name_data, $em_col_name_diff);
                }
            }
        }

        /* CALCULATE LAST END_MONTH */
        foreach ($masterData as $key => $item) {
            $sum_end_month = 0;
            foreach (array_slice($end_month_arr, 0, -1) as $em_col_name_data => $em_col_name_diff) {
                $sum_end_month += $item->$em_col_name_data;
            }

            $last_end_month_key = key(array_slice($end_month_arr, -1, 1, true));
            $item->$last_end_month_key = $item->amt_close - $sum_end_month;
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

        // if($col_name_data == 'amt_close') {
        // print_r('<pre>');
        // print_r(", index = $index, key = $key, diff = $diff_arr[$col_name_diff], ");
        // print_r($arr[$index]->$col_name_data);
        // print_r('</pre>');

        // dd();
        // }
    }

    public function setDiffValueToDataForEachSection(&$arr, $data_filter, $key1, $key2, $result, $result3, $result4, $col_name_data, $col_name_diff) {

        $key = $this->getKeyOfMaxValue($data_filter, $col_name_data);
        $index = array_search($key, array_column(json_decode(json_encode($arr)), 'formatted_guid'));
        // print_r("key = $key");
        // print_r("<pre>");
        // print_r($arr);
        // print_r("</pre>");
        // print_r("index = $index");
        // dd();

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
