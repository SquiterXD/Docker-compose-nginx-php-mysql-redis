<?php
namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class IRR0004_1Controller extends Controller{
    public function export($programCode, $request){

        $datas=$this->create($programCode, $request);
        $pdf = PDF::loadView('ir.reports.irr0004_1.pdf.index',$datas)
            ->setPaper('a4','landscape')
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',3)
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode.'.pdf');
    }

	public function create($programCode, $request){
        $s_set_f=$request['s_set_f']; // ชุดที่
        $s_set_t=$request['s_set_t']; // ชุดที่
        $s_period_f = '';
        $s_period_t = '';
        $s_year = '';
        if (isset($request['s_period'])){
            $s_period_arr = explode(':', $request['s_period']);
            $s_period_f = $s_period_arr[0];
            $s_period_t = count($s_period_arr) > 1 ? $s_period_arr[1] : '';
            $s_year = count($s_period_arr) > 2 ? $s_period_arr[2] : '';
        }

        $s_location=$request['s_location']; // กลุ่มของทรัพย์สิน
        $dept_f=$request['dept_f']; // สังกัด
        $dept_t=($request['dept_t']!='')?$request['dept_t']:$request['dept_f'];
        $company_f=$request['company_f']; // บริษัทประกัน
        $company_t=($request['company_t']!='')?$request['company_t']:$request['company_f'];
        $remark = $request['remark'];
        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $repTitle = $progReport->description;

        //To fix diff 0.01, it needs to query all each company.
        $query_company_f = $company_f;
        $query_company_t = $company_t;
        if ($company_f != "" && $company_t != ""){
            $company_f = 1;
            $company_t = 99;
        }

        if ($s_set_f > $s_set_t){
            $tmp_set_f = $s_set_f;
            $s_set_f = $s_set_t;
            $s_set_t = $tmp_set_f;
        }

        $sql_con="";
        $sql_con.=($s_location!="")?" and l.location_code='$s_location'":"";
        $sql_con.=($dept_f!="" && $dept_t!="")?" and (l.department_code between '{$dept_f}' and '{$dept_t}')":"";
        $sql_con.=($company_f!="" && $company_t!="")?" and (z.COMPANY_ID between '{$company_f}' and '{$company_t}')":"";

        $tb_set="
            SELECT
                trunc(max(end_calculate_date)) - trunc(min(start_calculate_date)) as days_year,
                max(DAY_NUM) as days_left,
                max(POLICY_SET_DESCRIPTION) as set_title,
                min(start_calculate_date) as  date_f,
                max(end_calculate_date) as  date_t,
                to_char(max(start_calculate_date),'dd monYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') as dateth_f,
                to_char(max(end_calculate_date),'dd monYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') as dateth_t,
                max(year) as year
            FROM PTIR_ASSET_HEADERS
            WHERE  program_code='IRP0004'
                and START_CALCULATE_DATE = DATE '{$s_period_f}' AND END_CALCULATE_DATE = DATE '{$s_period_t}'
                and POLICY_SET_HEADER_ID between '{$s_set_f}' and '{$s_set_t}'
            GROUP BY 1
        ";

        $sets_arr = DB::table(DB::raw("({$tb_set}) a"))->get();
        if (count($sets_arr) <= 0) { echo "The report cannot be generated.  There is no result from the search criteria."; exit; }

        $sets= $sets_arr->first();
        $date_f = $sets->date_f;
        $date_t = $sets->date_t;
        $dateth_f = $sets->dateth_f;
        $dateth_t = $sets->dateth_t;
        $set_title = $sets->set_title;
        $days_year = $sets->days_year;
        $days_left = $sets->days_left;

        $date_f = date('Y-m-d',strtotime($date_f));
        $date_f_first_date = date('Y-m-01',strtotime($date_f));
        $date_t = date('Y-m-d',strtotime($date_t));
        $thDate_f = parseToDateTh($date_f);
        $thDate_t = parseToDateTh($date_t);

        $tb_month="
            select
                'm'|| level as mth_code,
                to_char(LAST_DAY(add_months(date '{$date_f}',LEVEL-1)),'DD') AS mth_days,
                to_char(add_months(date '{$date_f}',level-1),'monYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') as mth_th,
                to_char(add_months(date  '{$date_f}', LEVEL-1),'YYYYmm') || '01' as mth_first_date,
                CASE WHEN
                    MOD(to_char(add_months(date '{$date_f}', LEVEL-1),'YYYY'), 400) = 0 or
                    (MOD(to_char(add_months(date '{$date_f}', LEVEL-1),'YYYY'), 4) = 0 and MOD(to_char(add_months(date '{$date_f}', LEVEL-1),'YYYY'), 100) != 0 )
                    THEN 366 ELSE 365 END AS days_in_year
            from dual
            connect by level <= months_between(date '{$date_t}'+1,DATE '{$date_f_first_date}')
        ";
        $months = DB::table(DB::raw("({$tb_month}) a"))->get();

        $tb_company="
            SELECT
                LISTAGG(COMPANY_NAME,', ') WITHIN GROUP (ORDER BY COMPANY_NAME) AS comp_name,
                LISTAGG(COMPANY_CODE,', ') WITHIN GROUP (ORDER BY COMPANY_CODE) AS comp_code
            FROM (
                SELECT
                    max(E.company_name) company_name,
                    max(A.company_code) company_code
                FROM PTIR_POLICY_GROUP_DISTS A
                JOIN PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                JOIN PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
                JOIN PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
                WHERE E.ACTIVE_FLAG ='Y'
                AND D.POLICY_SET_HEADER_ID between '{$s_set_f}' AND '{$s_set_t}'
                AND C.Year = '{$s_year}'
                GROUP BY A.company_code
            ) z
            GROUP BY 1
        ";
        $companies = DB::table(DB::raw("({$tb_company}) a"))->get()->first();

        $comp_code = ($company_f != "" && $company_t != "") ? "z.company_code" : "'{$companies->comp_code}'";
        $comp_name=($company_f!="" && $company_t!="")?"z.company_name":"'{$companies->comp_name}'";
        $group_comp_code = ($company_f != "" && $company_t != "") ? "z.company_code" : "LISTAGG(z2.company_code,', ') WITHIN GROUP (ORDER BY z2.company_code)";
        $group_comp_name = ($company_f!="" && $company_t!="")?"z.company_name": "LISTAGG(z2.COMPANY_NAME,', ') WITHIN GROUP (ORDER BY z2.COMPANY_NAME)";
        $comp_percent=($company_f!="" && $company_t!="")?"z.company_percent":"'100'";
        $insur_percent=($company_f!="" && $company_t!="")?"z.prepaid_insurance":"'100'";

        $amt_close = "CASE WHEN LENGTH(l.RECEIVABLE_NAME) > 0 THEN 0 ELSE sum(
            CASE
                WHEN NVL(h.include_tax_flag,'')='Y'
                THEN round(NVL(l.net_amount,0),2)*round(NVL($comp_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                ELSE (round(NVL(l.insurance_amount,0),2)+round(NVL(l.duty_amount,0),2))*round(NVL($comp_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
            END
        ) END";
        $sel_mth="";
        $sum_concat="";
        $months_arry = json_decode(json_encode($months));
        $end_month_arr = [];
        foreach($months_arry as $key => $m){
            $whenStm = "CASE WHEN LENGTH(l.RECEIVABLE_NAME) > 0 THEN 0 ELSE ";
            $endStm = "END";
            $val=$m->mth_days/$days_year;
            $as="amt_".$m->mth_first_date;
            $col_name="END_MONTH_".$m->mth_days."_".$m->days_in_year;

            //First month will be calculated by days left in the month i.e. amount * (days_left/days_in_month)
            if ($key == array_key_first($months_arry)){
                $tmp = "sum(round(round(l.$col_name * $comp_percent/ 100,2) * ($m->mth_days- TO_CHAR(l.CALCULATE_START_DATE, 'DD') +1)/$m->mth_days,2))";
            }
            //Last month will be calculated by amount left from amount close i.e. amt_close - (sum amount from the 1st - before last month)
            else if ($key == array_key_last($months_arry)){
                $tmp = "$amt_close - ($sum_concat 0)";
            }
            else {
                $tmp = "sum(round(l.$col_name * $comp_percent/ 100,2))";
            }
            $sel_mth.= "$whenStm $tmp $endStm $as ,";
            $sum_concat.= "$tmp + ";
            $end_month_arr['amt_' . $m->mth_first_date] = strtolower("amt_$col_name");
        }

        $sel_mth .= "sum(round(l.end_month_28_365 * $comp_percent/ 100,2)) amt_end_month_28_365, ";
        $sel_mth .= "sum(round(l.end_month_30_365 * $comp_percent/ 100,2)) amt_end_month_30_365, ";
        $sel_mth .= "sum(round(l.end_month_31_365 * $comp_percent/ 100,2)) amt_end_month_31_365, ";
        $sel_mth .= "sum(round(l.end_month_29_366 * $comp_percent/ 100,2)) amt_end_month_29_366, ";
        $sel_mth .= "sum(round(l.end_month_30_366 * $comp_percent/ 100,2)) amt_end_month_30_366, ";
        $sel_mth .= "sum(round(l.end_month_31_366 * $comp_percent/ 100,2)) amt_end_month_31_366, ";

        $is_separate_company = ($company_f != "" && $company_t != "");
        $join_company = $is_separate_company ?

        "SELECT
            A.company_code,
            A.company_percent,
            E.company_name,
            C.prepaid_insurance,
            C.premium_rate,
            D.policy_set_header_id,
            C.year,
            E.company_id
        FROM
            PTIR_POLICY_GROUP_DISTS A
            join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
            join PTIR_POLICY_GROUP_LINES C on (C.group_line_id = A.group_line_id)
            join PTIR_POLICY_GROUP_SETS D on (D.group_header_id = C.group_header_id)
        WHERE E.ACTIVE_FLAG = 'Y'
            AND C.year = {$s_year}" :
        "SELECT
            max(A.company_code) company_code,
            max(A.company_percent) company_percent,
            max(E.company_name) company_name,
            max(C.prepaid_insurance) prepaid_insurance,
            max(C.premium_rate) premium_rate,
            max(D.policy_set_header_id) policy_set_header_id,
            max(C.year) year,
            max(E.company_id) company_id
        FROM
            PTIR_POLICY_GROUP_DISTS A
            join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
            join PTIR_POLICY_GROUP_LINES C on (C.group_line_id = A.group_line_id)
            join PTIR_POLICY_GROUP_SETS D on (D.group_header_id = C.group_header_id)
            JOIN PTIR_ASSET_LINES L ON l.policy_set_header_id = D.POLICY_SET_HEADER_ID
        WHERE E.ACTIVE_FLAG = 'Y' AND
            (D.policy_set_header_id BETWEEN '{$s_set_f}' and '{$s_set_t}')
            AND C.year = '{$s_year}'
        GROUP BY D.policy_set_header_id" ;

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
                AND C.YEAR = '{$s_year}'
                GROUP BY D.policy_set_header_id, A.company_code
                ORDER BY 1,2
            )
            GROUP BY policy_set_header_id
          ) z2 ON (z2.policy_set_header_id = l.policy_set_header_id)";

        $tb_view="
            SELECT
                rawtohex(sys_guid()) as FORMATTED_GUID,
                l.POLICY_SET_HEADER_ID policy_set,
                'ชุดที่ ' || l.POLICY_SET_HEADER_ID || ' : ' || max(ph.POLICY_SET_DESCRIPTION)  program_title,
                {$group_comp_code} group_comp_code,
                {$group_comp_name} group_comp,
                concat(TO_CHAR(ph.START_ADDITION_DATE,'YYYY-MM-DD'),TO_CHAR(ph.END_ADDITION_DATE,'YYYY-MM-DD')) addition_date,
                {$comp_percent} comp_percent,
                {$insur_percent} insur_percent,
                '{$days_left}' days_left,
                max(TO_CHAR(ph.START_ADDITION_DATE,'YYYY-MM-DD')) start_addition_date,
                max(TO_CHAR(ph.END_ADDITION_DATE,'YYYY-MM-DD')) end_addition_date,
                max(TO_CHAR(l.CALCULATE_START_DATE,'YYYY-MM-DD')) cal_start_date,
                max(TO_CHAR(l.CALCULATE_END_DATE,'YYYY-MM-DD')) cal_end_date,
                max(to_char(l.CALCULATE_START_DATE,'dd monYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI')) as dateth_f,
                max(to_char(l.CALCULATE_END_DATE,'dd monYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI')) as dateth_t,
                CEIL(MONTHS_BETWEEN(max(l.CALCULATE_END_DATE),max(l.CALCULATE_START_DATE))) months,
                max(ph.status) status,
                l.RECEIVABLE_NAME receivable_name,
                l.location_code,
                max(l.LOCATION_NAME) group_01,
                l.department_code ,
                max(l.department_name) group_02,
                l.CATEGORY_CODE,
                max(l.CATEGORY_DESCRIPTION) cat_title,

                {$sel_mth}

                max((TRUNC(NVL(l.CALCULATE_END_DATE,SYSDATE+1))-TRUNC(SYSDATE))/TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR'))) aa,
                max(NVL(z.PREMIUM_RATE,0)) rate_set,
                max(NVL(z.prepaid_insurance,0)) amt_prepaid,
                max(NVL(z.company_percent,0)) rate_comp,
                sum(round(NVL(l.COVERAGE_AMOUNT,0),2)) cover,
                sum(round(NVL(l.insurance_amount,0),2)) insur,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL($comp_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)*round(NVL(z.premium_rate,0),2)) amt_cover,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL($comp_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_insure,
                sum(round(NVL(l.COVERAGE_AMOUNT,0),2)*round(NVL($comp_percent,0)/100,2)) amt_cost,
                {$amt_close}  amt_close,
                sum(round(NVL(l.duty_amount,0),2)*round(NVL($comp_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_duty,
                sum(round(NVL(l.vat_amount,0),2)*round(NVL($comp_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_vat,
                sum(round(NVL(l.vat_amount,0),2)) amt_vat1,
                sum(round(NVL(l.net_amount,0),2)) amt_net

            FROM PTIR_ASSET_LINES l
            JOIN (
                $join_company
            ) z on (z.policy_set_header_id=l.policy_set_header_id and z.year = l.year)
            $join_company_aggregate
            JOIN PTIR_POLICY_SET_HEADERS h on (h.policy_set_header_id=l.policy_set_header_id)
            JOIN PTIR_ASSET_HEADERS ph on (ph.header_id=l.header_id and ph.start_calculate_date=l.CALCULATE_START_DATE and ph.end_calculate_date=l.CALCULATE_END_DATE and ph.status != 'CANCELLED' and ph.program_code = l.program_code)
            WHERE l.program_code='IRP0004' and NVL(l.ASSET_STATUS,'')='Y'
                AND l.POLICY_SET_HEADER_ID between '{$s_set_f}' and '{$s_set_t}' and l.status != 'CANCELLED'
                {$sql_con}
            GROUP BY l.POLICY_SET_HEADER_ID,{$comp_code},{$comp_name}, concat(TO_CHAR(ph.START_ADDITION_DATE,'YYYY-MM-DD'),TO_CHAR(ph.END_ADDITION_DATE,'YYYY-MM-DD')), {$comp_percent},{$insur_percent},'{$days_left}',l.receivable_name,l.location_code,l.department_code,l.CATEGORY_code
            HAVING max(TO_CHAR(l.CALCULATE_START_DATE, 'YYYY-MM-DD')) = '{$s_period_f}' AND max(TO_CHAR(l.CALCULATE_END_DATE, 'YYYY-MM-DD')) = '{$s_period_t}'
            ORDER BY l.POLICY_SET_HEADER_ID,{$comp_code},{$comp_name}, concat(TO_CHAR(ph.START_ADDITION_DATE,'YYYY-MM-DD'),TO_CHAR(ph.END_ADDITION_DATE,'YYYY-MM-DD')), {$comp_percent},{$insur_percent},'{$days_left}',NVL(l.receivable_name,' '),l.location_code,l.department_code,l.CATEGORY_code

        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();

        $data_diff_array_grand_total = [];
        if ($is_separate_company) {
            $this->recalculate($data, $data_diff_array_grand_total, $s_year, $s_set_f, $s_set_t, $s_period_f, $s_period_t, $end_month_arr);
            //remove un-query company
            $data = $data->filter(function ($item) use ($query_company_f, $query_company_t) {
                return $item->group_comp_code >= $query_company_f  && $item->group_comp_code <= $query_company_t;
            })->values();
        }

        $progTitle = "ชุดที่ ".$s_set_f." : ".$set_title;
        $repTitle  = $repTitle;
        $titles=[
            'dateth_f'=>$thDate_f,
            'dateth_t'=>$thDate_t,
            'set_title'=>$set_title,
            'days_left'=>$days_left,
            'days_year'=>$days_year,
            'days_left'=>$days_left,
            'insur_percent'=>$insur_percent,
            'comp_percent'=>$comp_percent
        ];
        $datas = compact('data', 'titles', 'months', 'repTitle', 'programCode', 'progTitle', 'remark', 'data_diff_array_grand_total');

        return $datas;
    }

    public function getDiffAmount($company_percent_arr, $amt)
    {
        $sum = 0;
        foreach ($company_percent_arr as $key => $company) {
            $sum += round($amt * $company->company_percent / 100, 2);
        }
        return round($amt - $sum, 2);
    }



    public function getKeyOfMaxValue($arr, $column_name)
    {
        $max = max(array_column($arr, $column_name));
        // keys of max value
        $keys = array_filter(array_map(function ($arr) use ($max, $column_name) {
            return $arr[$column_name] == $max ? $arr['formatted_guid'] : null;
        }, $arr));
        return reset($keys);
    }

    public function setDiffValueToData(&$arr, $data_filter, $diff_arr, $col_name_data, $col_name_diff)
    {
        if (count($data_filter) <= 0) return;

        $key = $this->getKeyOfMaxValue($data_filter, $col_name_data);
        $index = array_search($key, array_column(json_decode(json_encode($arr)), 'formatted_guid'));

        // print_r('<pre>');
        // print_r(", index = $index, key = $key, diff = $diff_arr[$col_name_diff], ");
        // print_r($arr[$index]->$col_name_data);

        $arr[$index]->$col_name_data += $diff_arr[$col_name_diff];
        //Also update amt_end_month_mm_yyyy
        if ($col_name_data != $col_name_diff) {
            $arr[$index]->$col_name_diff = $arr[$index]->$col_name_data;
        }

        // print_r(", result = ");
        // print_r($arr[$index]->$col_name_data);
        // print_r('</pre>');
    }

    public function setDiffValueToDataForEachSection(&$arr, $data_filter, $key1, $key2, $result, $result3, $result4, $col_name_data, $col_name_diff)
    {

        $key = $this->getKeyOfMaxValue($data_filter, $col_name_data);
        $index = array_search($key, array_column(json_decode(json_encode($arr)), 'formatted_guid'));

        // print_r('<pre>');
        // print_r(", index = $index, key1 = $key1, key2 = $key2, col_name_data = $col_name_data, ");
        // print_r($arr[$index]->$col_name_data);
        // print_r('<br/>');

        $diff_result3_and_result = round($result3[$key1][$key2][$col_name_diff] - $result[$key1][$key2][$col_name_diff], 2);
        $diff_result3_and_result4 = round($result3[$key1][$key2][$col_name_diff] - $result4[$key1][$key2][$col_name_diff], 2);


        if ($diff_result3_and_result == $diff_result3_and_result4 && $diff_result3_and_result4 != 0) {
            //e.g. result = 4.92, result3 = 4.91, result4 = 4.92; find max value of the column and add/sub diff amt
            $arr[$index]->$col_name_data += $diff_result3_and_result4;
        } else if ($diff_result3_and_result != $diff_result3_and_result4 && $diff_result3_and_result == 0) {
            //e.g. result = 4.91, result3 = 4.91, result4 = 4.92; find max value and round value before add/sub diff amt
            $arr[$index]->$col_name_data = round($arr[$index]->$col_name_data, 2) + $diff_result3_and_result4;
        }

        //Also update amt_end_month_mm_yyyy
        if ($col_name_data != $col_name_diff) {
            $arr[$index]->$col_name_diff = $arr[$index]->$col_name_data;
        }
        // print_r("diff_result3_and_result = $diff_result3_and_result, diff_result3_and_result4 = $diff_result3_and_result4,");
        // print_r(", result = ");
        // print_r($arr[$index]->$col_name_data);
        // print_r('</pre>');
    }


    public function recalculate(&$data, &$data_diff_array_grand_total, $s_year, $s_set_f, $s_set_t, $s_period_f, $s_period_t, $end_month_arr)
    {
        /********* BEGIN: WORK ON DIFF 0.01 ***********************/
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
                AND POLICY_SET_HEADER_ID between '{$s_set_f}' AND '{$s_set_t}'
                AND DEFAULT_DIFF_AMOUNT = 'Y'
                AND C.YEAR = '{$s_year}'
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
                AND C.YEAR = '{$s_year}'
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
                    AND ( D.policy_set_header_id BETWEEN '{$s_set_f}' AND '{$s_set_t}' ) AND C.year = '{$s_year}'
                GROUP BY D.policy_set_header_id ) z ON
                ( z.policy_set_header_id = l.policy_set_header_id AND z.year = l.year )
            JOIN PTIR_POLICY_SET_HEADERS h ON  (h.policy_set_header_id = l.policy_set_header_id)
            JOIN PTIR_ASSET_HEADERS ph ON ( ph.header_id = l.header_id AND ph.start_calculate_date = l.CALCULATE_START_DATE AND ph.end_calculate_date = l.CALCULATE_END_DATE AND ph.status != 'CANCELLED' AND ph.program_code = l.program_code)
            WHERE l.program_code = 'IRP0004' AND NVL(l.ASSET_STATUS, '') = 'Y' AND l.POLICY_SET_HEADER_ID BETWEEN '{$s_set_f}' AND '{$s_set_t}' AND l.status != 'CANCELLED'
            GROUP BY l.POLICY_SET_HEADER_ID, concat( TO_CHAR(ph.START_ADDITION_DATE, 'YYYY-MM-DD'), TO_CHAR(ph.END_ADDITION_DATE, 'YYYY-MM-DD') ), l.receivable_name
            HAVING max(TO_CHAR(l.CALCULATE_START_DATE, 'YYYY-MM-DD')) = '{$s_period_f}' AND max(TO_CHAR(l.CALCULATE_END_DATE, 'YYYY-MM-DD')) = '{$s_period_t}'
            ORDER BY l.POLICY_SET_HEADER_ID, concat( TO_CHAR(ph.START_ADDITION_DATE, 'YYYY-MM-DD'), TO_CHAR(ph.END_ADDITION_DATE, 'YYYY-MM-DD') ), NVL(l.receivable_name, ' ')";

        $data_total_all_companies = DB::table(DB::raw("({$tb_total_all_companies}) a"))->get();

        //result => amt that shows on the report
        //result2 => grand total
        //result3 => amt that is calculated by percentage
        //result4 => amt that is calculated by 2 digit

        $result = [];  //Sum of each record
        $result2 = [];  //Grand Total

        /* GET RESULT1 AND RESULT2 FOR CALCULATION IN THE NEXT STEP */
        foreach ($data as $item) {
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

        $data_2digit = $data;
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

                $data_filter_not_default_company = array_filter(json_decode(json_encode($data), true), function ($item) use ($company_code, $policy_set_key, $receivable_name_key) {
                    return $item['group_comp_code'] == $company_code && $item['policy_set'] ==  $policy_set_key && $item['receivable_name'] ==  $receivable_name_key;
                });

                $this->setDiffValueToDataForEachSection($data, $data_filter_not_default_company, $key1, $key2, $result, $result3, $result4, 'amt_cost', 'amt_cost');
                $this->setDiffValueToDataForEachSection($data, $data_filter_not_default_company, $key1, $key2, $result, $result3, $result4, 'amt_insure', 'amt_insure');
                $this->setDiffValueToDataForEachSection($data, $data_filter_not_default_company, $key1, $key2, $result, $result3, $result4, 'amt_close', 'amt_close');

                foreach (array_slice($end_month_arr, 0, -1) as $em_col_name_data => $em_col_name_diff) {
                    $this->setDiffValueToDataForEachSection($data, $data_filter_not_default_company, $key1, $key2, $result, $result3, $result4,  $em_col_name_data, $em_col_name_diff);
                }
            }
        }

        /* RECALCULATE RESULT AND GEN RESULT2*/
        $result = [];
        foreach ($data as $item) {
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
        foreach ($data_total_all_companies as $key => $section) {

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
                $data_filter_by_default_company = array_filter(json_decode(json_encode($data), true), function ($item) use ($default_company_code, $policy_set_key, $receivable_name_key) {
                    return $item['group_comp_code'] == $default_company_code && $item['policy_set'] ==  $policy_set_key && $item['receivable_name'] ==  $receivable_name_key;
                });

                // print_r('<pre>');
                // print_r("$default_company_code, $policy_set_key, $receivable_name_key,");
                // print_r('</pre>');

                $this->setDiffValueToData($data, $data_filter_by_default_company, $item, 'amt_cost', 'amt_cost');
                $this->setDiffValueToData($data, $data_filter_by_default_company, $item, 'amt_insure', 'amt_insure');
                $this->setDiffValueToData($data, $data_filter_by_default_company, $item, 'amt_close', 'amt_close');

                foreach (array_slice($end_month_arr, 0, -1) as $em_col_name_data => $em_col_name_diff) {
                    $this->setDiffValueToData($data, $data_filter_by_default_company, $item,  $em_col_name_data, $em_col_name_diff);
                }
            }
        }

        /* CALCULATE LAST END_MONTH */
        foreach ($data as $key => $item) {
            $sum_end_month = 0;
            foreach (array_slice($end_month_arr, 0, -1) as $em_col_name_data => $em_col_name_diff) {
                $sum_end_month += $item->$em_col_name_data;
            }
            $last_end_month_key = key(array_slice($end_month_arr, -1, 1, true));
            $item->$last_end_month_key = $item->amt_close - $sum_end_month;
        }

        // print_r('<pre>');
        // // print_r($data_company_default_diff);
        // // print_r($data_company_percent_list);
        // print_r($result);
        // print_r($result3);
        // print_r($result4);
        // print_r($result2);
        // // print_r($end_month_arr);
        // print_r($data_total_all_companies);
        // print_r($data_total_each_company);
        // print_r($data_diff_array);
        // print_r($data_diff_array_grand_total);
        // print_r($data);
        // print_r('</pre>');

        // dd();
        /********* END: WORK ON DIFF 0.01 ***********************/
    }
}
