<?php
namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class IRR0001_3Controller extends Controller{
    public function export($programCode, $request){
        $s_set=$request['s_set']; // ชุดที่
        $s_year=$request['s_period']; // ปี
        $programCode_Output = 'IRR0001-3'; // programCode Show Report

        $body_param = $request->all();
        $group_f=$request['group_f']; // กลุ่มทรัพย์สินตั้งแต่ location_code
        $group_t=($request['group_t']!='')?$request['group_t']:$request['group_f'];
        $company_f=$request['company_f']; // บริษัทประกัน
        $company_t=($request['company_t']!='')?$request['company_t']:$request['company_f'];
        $item_f=$request['item_f']; // รายการตั้งแต่
        $item_t=($request['item_t']!='')?$request['item_t']:$request['item_f'];
        $department_f=$request['department_f']; // แผนกการตั้งแต่
        $department_t=($request['department_t']!='')?$request['department_t']:$request['department_f'];

        $remark = $request['remark'];
        $status = $request['status'];
        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $is_separate_company = false;
        $progTitle = $progReport->description;
        //get date
         $tb_date = "
            SELECT
               SUBSTR(MEANING, 0, INSTR(MEANING, '-')-1) AS date_f,
               SUBSTR(MEANING, INSTR(MEANING, '-') + 2) AS date_t
            FROM
                 PTIR_EFFECTIVE_DATE
            WHERE
                ENABLED_FLAG = 'Y'
                AND LOOKUP_CODE = '{$s_year}'
        ";
        $dates = DB::table(DB::raw("({$tb_date}) a"))->get();
        //compare from and to
        if($item_f > $item_t){
            $tmp_item_f = $item_f;
            $item_f = $item_t;
            $item_t = $tmp_item_f;
        }

        if($company_f > $company_t){
            $tmp_company_f = $company_f;
            $company_f = $company_t;
            $company_t = $tmp_company_f;
        }

        if($group_f > $group_t){
            $tmp_group_f = $group_f;
            $group_f = $group_t;
            $group_t = $tmp_group_f;
        }

        if($department_f > $department_t){
            $tmp_department_f = $department_f;
            $department_f = $department_t;
            $department_t = $tmp_department_f;
        }
       

        $tb_item  = "
        SELECT LABEL FROM(SELECT ROW_NUMBER() OVER(ORDER BY T.LABEL DESC) VALUE,LABEL
        FROM (
        SELECT DISTINCT STOCK_LIST_DESCRIPTION LABEL ,ASSET_GROUP_CODE
        FROM OAIR.PTIR_STOCK_LINES
        WHERE STATUS NOT IN ('CANCELLED')  AND POLICY_SET_HEADER_ID='1' AND PROGRAM_CODE  = 'IRP0001'
        )  T  )  
        ";
        $tb_item.=($item_f!="")?" where (VALUE between '{$item_f}' and '{$item_t}')":"";
        $items = DB::table(DB::raw("({$tb_item}) t"))->get()->toArray();
        $item_array = [];
        $item_str = "'";

        if(!is_null($items)){
            $item_array = array_column($items,'label');
            $item_str ="'" . implode ( "', '", $item_array ) . "'";
        }


        //get date
         $tb_date = "
            SELECT
               SUBSTR(MEANING, 0, INSTR(MEANING, '-')-1) AS date_f,
               SUBSTR(MEANING, INSTR(MEANING, '-') + 2) AS date_t
            FROM
                 PTIR_EFFECTIVE_DATE
            WHERE
                ENABLED_FLAG = 'Y'
                AND LOOKUP_CODE = '{$s_year}'
        ";
        $dates = DB::table(DB::raw("({$tb_date}) a"))->get();
        $sql_con="";
        $sql_con.=($status!="")?" and NVL(L.STATUS,'')='$status'":" and L.STATUS NOT IN ('CANCELLED')";
        $sql_con.=($company_f!="")?" and (z.COMPANY_ID between '{$company_f}' and '{$company_t}')":"";
        $sql_con.=($group_f!="")?" and (G.MEANING between '{$group_f}' and '{$group_t}')":"";
        $sql_con.=($department_f!="")?" and (L.DEPARTMENT_CODE between '{$department_f}' and '{$department_t}')":"";
        $sql_company=($company_f != "") ? " and (A.COMPANY_ID between '{$company_f}' and '{$company_t}') " : "";
        $sql_con_row=($item_f!="")?" where a.item_title in ({$item_str})":"";

        $tb_company="
            SELECT
                z.POLICY_SET_HEADER_ID,
                LISTAGG(COMPANY_NAME,', ') WITHIN GROUP (ORDER BY COMPANY_NAME) AS comp_name,
                LISTAGG(policyno,', ') WITHIN GROUP (ORDER BY policyno) AS policy_no,
                LISTAGG(COMMENTS,', ') WITHIN GROUP (ORDER BY COMMENTS) AS comments,
                LISTAGG(company_code,', ') WITHIN GROUP (ORDER BY company_code) AS company_code
            FROM (
                select
                    E.company_name,
                    A.company_code,
                    A.company_percent,
                    C.prepaid_insurance,
                    A.user_policy_number as policyno,
                    D.policy_set_header_id,
                    C.year,E.company_id,
                    A.COMMENTS
                from PTIR_POLICY_GROUP_DISTS A
                join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                join PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
                join PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
                JOIN PTIR_POLICY_GROUP_HEADERS B ON C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
                WHERE 0=0 and C.YEAR = '{$s_year}' AND E.ACTIVE_FLAG ='Y' AND  D.POLICY_SET_HEADER_ID = {$s_set}
                    {$sql_company}
            ) z
            GROUP BY 
                Z.POLICY_SET_HEADER_ID
        ";
        $companies = DB::table(DB::raw("({$tb_company}) a"))->get()->first();
        if($company_f != ""){
            $is_separate_company = true;
            $policy_no ="T.user_policy_number";
            $policy_no_column = 'z.user_policy_number,';
            $comp_name = "T.company_name";
            $company_percent = "T.company_percent";
            $company_percent_column = "z.company_percent,";
            $comp_name_column = "z.COMPANY_NAME,";
            $comments = "T.comments";
            $comments_column = "z.comments,";
            $company_code = "T.company_code";
            $company_code_column = "z.company_code,";

        }else{
            $policy_no = "'{$companies->policy_no}'";
            $comp_name = "'{$companies->comp_name}'";
            $policy_no_column = '';
            $company_percent = "100";
            $company_percent_column = "";
            $comp_name_column = "";
            $comments = "'{$companies->comments}'";
            $comments_column = "";
            $company_code = "'{$companies->company_code}'";
            $company_code_column = "";
        }

          $tb_company_join = "";
          if($company_f!=""){
             $tb_company_join="
               JOIN (
                select
                    E.company_name,
                    A.company_code,
                    A.company_percent,
                    C.prepaid_insurance,
                    A.user_policy_number,
                    D.policy_set_header_id,
                    C.year,E.company_id,
                    A.comments
                from PTIR_POLICY_GROUP_DISTS A
                join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                join PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
                join PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
                JOIN PTIR_POLICY_GROUP_HEADERS B ON C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
                WHERE 0=0 and C.YEAR = {$s_year} AND E.ACTIVE_FLAG ='Y' AND  D.POLICY_SET_HEADER_ID = {$s_set}
                    {$sql_company}
          ) z on (z.POLICY_SET_HEADER_ID = L.POLICY_SET_HEADER_ID AND L.YEAR = z.YEAR)
            ";
          }

         $tb_view="
            SELECT
                {$comp_name} company_title,
                {$policy_no} policy_no,
                {$comments} comments,
                {$company_percent} company_percent,
                {$company_code} company_code,
                T.group_title,
                T.type_title,
                T.item_title,
                T.set_title,
                T.PREPAID_INSURANCE,
                T.PREMIUM_RATE,
                T.TAX,
                T.REVENUE_STAMP,
                T.DEPARTMENT_CODE,
                T.DEPARTMENT_DESCRIPTION,
                TO_CHAR(T.INSURANCE_START_DATE,'YYYY-MM-DD') start_date ,
                TO_CHAR(T.INSURANCE_END_DATE,'YYYY-MM-DD') end_date ,
                SUM(T.COVERAGE_AMOUNT * round(T.CALCULATE_DAYS,2)) amt_insure_all1,
                ROUND( SUM(T.COVERAGE_AMOUNT*(T.PREMIUM_RATE/100) * round(T.PREPAID_INSURANCE/100,2) * round(T.CALCULATE_DAYS,2)),2) amt_insure_all,
               ROUND(SUM(T.COVERAGE_AMOUNT*(T.PREMIUM_RATE/100) * round(T.PREPAID_INSURANCE/100,2)  * round({$company_percent}/100,2)  * round(T.CALCULATE_DAYS,2)),2) amt_insure,
                SUM(round(T.COVERAGE_AMOUNT*T.PREMIUM_RATE/100 * round(T.PREPAID_INSURANCE/100,2)  * round({$company_percent}/100,2)  * T.CALCULATE_DAYS) * round(NVL(T.REVENUE_STAMP/100,0),2) * round({$company_percent},2)) amt_duty,
                ROUND(SUM(
                    (
                    (T.COVERAGE_AMOUNT*T.PREMIUM_RATE/100 * round(T.PREPAID_INSURANCE/100,2)  * round({$company_percent}/100,2)  * T.CALCULATE_DAYS) +
                    ((T.COVERAGE_AMOUNT*T.PREMIUM_RATE/100 * round(T.PREPAID_INSURANCE/100,2)  * round({$company_percent}/100,2)  * T.CALCULATE_DAYS) * round(NVL(T.REVENUE_STAMP/100,0),2) * round({$company_percent},2)) 
                    ) * round(NVL(T.TAX/100,0),2) * round({$company_percent},2)
                    ),2) amt_tax
            FROM (
                SELECT
                    AC.DESCRIPTION type_title,
                    G.DESCRIPTION  group_title,
                    L.STOCK_LIST_DESCRIPTION item_title,
                    L.POLICY_SET_DESCRIPTION set_title,
                    {$policy_no_column}
                    {$comp_name_column}
                    {$company_percent_column}
                    {$comments_column}
                    {$company_code_column}
                    L.insurance_start_date  date_f,
                    L.insurance_end_date  date_t,
                    L.COVERAGE_AMOUNT,
                    GL.PREMIUM_RATE,
                    GL.PREPAID_INSURANCE,
                    L.DEPARTMENT_CODE,
                    L.DEPARTMENT_DESCRIPTION,
                    L.INSURANCE_START_DATE ,
                    L.INSURANCE_END_DATE,
                    CASE WHEN UPPER(L.LINE_TYPE) ='INVENTORY'
                            THEN (TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR'))/TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR')))
                            ELSE  NVL(L.CALCULATE_DAYS/TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR')),0)
                    END CALCULATE_DAYS,
                    (GL.REVENUE_STAMP/100) REVENUE_STAMP,
                     GL.TAX,
                    L.ASSET_GROUP_CODE
                FROM PTIR_STOCK_LINES L
                $tb_company_join
                INNER JOIN PTIR_POLICY_SET_HEADERS SH ON L.POLICY_SET_HEADER_ID = SH.POLICY_SET_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_SETS GS ON SH.POLICY_SET_HEADER_ID = GS.POLICY_SET_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_HEADERS GH ON GS.GROUP_HEADER_ID = GH.GROUP_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_LINES GL ON GH.GROUP_HEADER_ID = GL.GROUP_HEADER_ID AND L.YEAR = GL.YEAR
                INNER JOIN PTIR_ACCOUNTS_MAPPING AC ON SH.ACCOUNT_ID = AC.ACCOUNT_ID
                INNER JOIN PTIR_ASSET_GROUP_V G ON L.ASSET_GROUP_CODE = G.VALUE
                WHERE L.POLICY_SET_HEADER_ID='{$s_set}' AND L.PROGRAM_CODE  = 'IRP0001'
                    AND GL.YEAR = '{$s_year}' 
                    {$sql_con}
            ) T
            GROUP BY T.group_title,T.type_title,T.DEPARTMENT_CODE, T.DEPARTMENT_DESCRIPTION,T.item_title,T.set_title,{$comp_name},{$policy_no},{$comments},{$company_percent} ,{$company_code},T.PREPAID_INSURANCE,T.PREMIUM_RATE,T.TAX,T.REVENUE_STAMP,T.INSURANCE_START_DATE ,T.INSURANCE_END_DATE 
            ORDER BY T.DEPARTMENT_CODE
        ";
        $data = DB::table(DB::raw("({$tb_view}) a {$sql_con_row}"))->get();
        $row = $data->first();

        $is_diff = false;
        $diff_amount = 0;
        $all_company_insure = 0;
        $array_sum_department = [];
        if($company_f != "" && $company_t != "" && count($data) > 0){
            $this->checkDiff($is_diff,$diff_amount, $data , $s_set, $s_year, $company_percent, $row, $all_company_insure,  $sql_con, $companies ,$tb_company_join, $sql_company, $array_sum_department ,$sql_con_row);
        }
       
        $row = $data->first();
        $date_f ="";
        $date_t ="";
        $thDate_f="";
        $thDate_t="";
        if(!is_null($row)){
             $date_f = $row->start_date;
             $date_t = $row->end_date;
        }else if(!is_null($dates)) {
            $list_f = explode("/",$dates[0]->date_f);
            $list_t = explode("/",$dates[0]->date_t);

            $date_f = $list_f[2].'-'.$list_f[1].'-'.$list_f[0];
            $date_t = $list_t[2].'-'.$list_t[1].'-'.$list_t[0];
        }

        if($date_f !== "" && $date_t !== ""){
            $date_f_array = explode("-", $date_f);
            $date_t_array = explode("-", $date_t);

            list($year_f, $month_f, $date_f) = $date_f_array;
            list($year_t, $month_t, $date_t) = $date_t_array;

            $str_date_f = trim($year_f).trim($month_f).trim($date_f);
            $str_date_t = trim($year_t).trim($month_t).trim($date_t);

            $thDate_f = trim($date_f). ' ' .getMonthTh(date('M', strtotime($str_date_f))) .' '. convertYearToBBE($year_f);
            $thDate_t = trim($date_t). ' ' .getMonthTh(date('M', strtotime($str_date_t))) .' '. convertYearToBBE($year_t);      
        }

        $progTitle =  isset($row->set_title ) ? "ชุดที่ ".$s_set." : $row->set_title " : "";
        $progPara[0]= $progReport->description;
        $progPara[1]= "ตั้งแต่วันที่ $thDate_f  ถึงวันที่ $thDate_t";

        $pdf = PDF::loadView('ir.reports.irr0001_3.pdf.index',compact('data','programCode_Output','progTitle','progPara','is_separate_company','all_company_insure', 'array_sum_department'))
            ->setPaper('a4','portrait')
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',3)
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode_Output. '.pdf');
    }

    public function checkDiff(&$is_diff, &$diff_amount, $data, $s_set, $s_year, $company_percen, $row, &$all_company_insure, $sql_con, $companies,$tb_company_join, $sql_company, &$array_sum_department ,$sql_con_row){
        $premium_rate = isset($row->premium_rate) ? $row->premium_rate : 0;
        $prepait_insure = isset($row->prepait_insurance) ? $row->prepait_insurance : 0;
        $premium_rate = isset($row->premium_rate) ? $row->premium_rate : 0;


        $policy_no = "'{$companies->policy_no}'";
        $comp_name = "'{$companies->comp_name}'";
        $policy_no_column = '';
        $company_percent = "100";
        $company_percent_column = "";
        $comp_name_column = "";
        $comments = "'{$companies->comments}'";
        $comments_column = "";
        $company_code = "'{$companies->company_code}'";
        $company_code_column = "";
        $tb_company_join = "";
        $sql_con="";
        $sql_con_row="";

        //DEFAULT_DIFF_AMOUNT
          $tb_company_default_flag="
            SELECT
                z.POLICY_SET_HEADER_ID,
                z.DEFAULT_DIFF_AMOUNT,
                max(company_code) AS company_code
            FROM (
                select
                    E.company_name,
                    A.company_code,
                    A.company_percent,
                    C.prepaid_insurance,
                    A.user_policy_number as policyno,
                    D.policy_set_header_id,
                    C.year,E.company_id,
                    A.COMMENTS,
                    A.DEFAULT_DIFF_AMOUNT 
                from PTIR_POLICY_GROUP_DISTS A
                join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                join PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
                join PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
                JOIN PTIR_POLICY_GROUP_HEADERS B ON C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
                WHERE 0=0 and C.YEAR = '{$s_year}' AND A.DEFAULT_DIFF_AMOUNT = 'Y' AND E.ACTIVE_FLAG ='Y' AND  D.POLICY_SET_HEADER_ID = {$s_set}
                    {$sql_company}
            ) z
            GROUP BY 
                Z.POLICY_SET_HEADER_ID, z.DEFAULT_DIFF_AMOUNT
        ";
        $company_default_flags = DB::table(DB::raw("({$tb_company_default_flag}) a"))->get()->first();
        $company_code_default_flags = isset($company_default_flags->company_code) ? $company_default_flags->company_code :0;
        
        $tb_view="
            SELECT
                {$comp_name} company_title,
                {$policy_no} policy_no,
                {$comments} comments,
                {$company_percent} company_percent,
                {$company_code} company_code,
                T.group_title,
                T.type_title,
                T.item_title,
                T.set_title,
                T.PREPAID_INSURANCE,
                T.PREMIUM_RATE,
                T.TAX,
                T.REVENUE_STAMP,
                T.DEPARTMENT_CODE,
                SUM(T.COVERAGE_AMOUNT * round(T.CALCULATE_DAYS,2)) amt_insure_all1,
                ROUND( SUM(T.COVERAGE_AMOUNT*(T.PREMIUM_RATE/100) * round(T.PREPAID_INSURANCE/100,2) * round(T.CALCULATE_DAYS,2)),2) amt_insure_all,
                ROUND(SUM(T.COVERAGE_AMOUNT*(T.PREMIUM_RATE/100) * round(T.PREPAID_INSURANCE/100,2)  * round({$company_percent}/100,2)  * round(T.CALCULATE_DAYS,2)),2) amt_insure,
                SUM(round(T.COVERAGE_AMOUNT*T.PREMIUM_RATE/100 * round(T.PREPAID_INSURANCE/100,2)  * round({$company_percent}/100,2)  * T.CALCULATE_DAYS) * round(NVL(T.REVENUE_STAMP/100,0),2) * round({$company_percent},2)) amt_duty,
                ROUND(SUM(
                    (
                    (T.COVERAGE_AMOUNT*T.PREMIUM_RATE/100 * round(T.PREPAID_INSURANCE/100,2)  * round({$company_percent}/100,2)  * T.CALCULATE_DAYS) +
                    ((T.COVERAGE_AMOUNT*T.PREMIUM_RATE/100 * round(T.PREPAID_INSURANCE/100,2)  * round({$company_percent}/100,2)  * T.CALCULATE_DAYS) * round(NVL(T.REVENUE_STAMP/100,0),2) * round({$company_percent},2)) 
                    ) * round(NVL(T.TAX/100,0),2) * round({$company_percent},2)
                    ),2) amt_tax
            FROM (
                SELECT
                    AC.DESCRIPTION type_title,
                    G.DESCRIPTION  group_title,
                    L.STOCK_LIST_DESCRIPTION item_title,
                    L.POLICY_SET_DESCRIPTION set_title,
                    {$policy_no_column}
                    {$comp_name_column}
                    {$company_percent_column}
                    {$comments_column}
                    {$company_code_column}
                    L.insurance_start_date  date_f,
                    L.insurance_end_date  date_t,
                    L.COVERAGE_AMOUNT,
                    GL.PREMIUM_RATE,
                    GL.PREPAID_INSURANCE,
                    L.DEPARTMENT_CODE,
                    L.DEPARTMENT_DESCRIPTION,
                    CASE WHEN UPPER(L.LINE_TYPE) ='INVENTORY'
                            THEN (TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR'))/TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR')))
                            ELSE  NVL(L.CALCULATE_DAYS/TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR')),0)
                    END CALCULATE_DAYS,
                    (GL.REVENUE_STAMP/100) REVENUE_STAMP,
                    GL.TAX,
                    L.ASSET_GROUP_CODE
                FROM PTIR_STOCK_LINES L
                $tb_company_join
                INNER JOIN PTIR_POLICY_SET_HEADERS SH ON L.POLICY_SET_HEADER_ID = SH.POLICY_SET_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_SETS GS ON SH.POLICY_SET_HEADER_ID = GS.POLICY_SET_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_HEADERS GH ON GS.GROUP_HEADER_ID = GH.GROUP_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_LINES GL ON GH.GROUP_HEADER_ID = GL.GROUP_HEADER_ID AND L.YEAR = GL.YEAR
                INNER JOIN PTIR_ACCOUNTS_MAPPING AC ON SH.ACCOUNT_ID = AC.ACCOUNT_ID
                INNER JOIN PTIR_ASSET_GROUP_V G ON L.ASSET_GROUP_CODE = G.VALUE
                WHERE L.POLICY_SET_HEADER_ID='{$s_set}' AND L.PROGRAM_CODE  = 'IRP0001'
                    AND GL.YEAR = '{$s_year}' 
                    AND L.STATUS NOT IN ('CANCELLED')
                    {$sql_con}
            ) T
            GROUP BY T.group_title,T.type_title,T.DEPARTMENT_CODE,T.item_title,T.set_title,{$comp_name},{$policy_no},{$comments},{$company_percent} ,{$company_code},T.PREPAID_INSURANCE,T.PREMIUM_RATE,T.TAX,T.REVENUE_STAMP
            ORDER BY T.group_title
        ";
         $data_all_company = DB::table(DB::raw("({$tb_view}) a {$sql_con_row}"))->get();
         $all_company_insure = 0;
         $array_tax = [];
         $array_duty = [];
         
         foreach ($data_all_company->groupBy('company_title') as $company_name => $company)
         {
            $all_company_insure += $company->sum('amt_insure'); 

         }
         foreach ($data_all_company->groupBy('department_code') as  $department)
         {
            $array_sum_department[$department[0]->department_code] = $department->sum('amt_insure');
         }

         $array_diff_company = [];
          $all_diff = 0;
          $amt_tax_all = 0;
          $amt_duty_all = 0;
          $sum_company_percent = 0;
              foreach ($data->groupBy('company_code') as $company_code => $company){
                $company_insure_percent = round($all_company_insure * round($company[0]->company_percent/100,2),2);
                $company_insure_sum_detail = $company->sum('amt_insure');
                $revenu_stamp =  $company[0]->revenue_stamp;
                $amt_duty_all =  $all_company_insure * round($revenu_stamp,2);

                $amt_tax_all = round(($all_company_insure  + $amt_duty_all) * round($company[0]->tax/100,2),2);
                $tax = $company[0]->tax;
                $array_tax[$company_code] = round($amt_tax_all * $company[0]->company_percent/100,2);
                $array_duty[$company_code] = round($amt_duty_all * $company[0]->company_percent/100,2);

                $sum_company_percent+= $company[0]->company_percent;
                if($company_insure_sum_detail > $company_insure_percent){
                    $array_diff = [];
                    $array_diff["company_code"] = $company_code;
                    $array_diff["diff_amount"] =  - (round($company_insure_sum_detail-$company_insure_percent,2));
                    $array_diff_company[] = $array_diff;
                }else
               if($company_insure_percent > $company_insure_sum_detail){
                    $array_diff = [];
                    $array_diff["company_code"] = $company_code;
                    $array_diff["diff_amount"] =  -(round($company_insure_sum_detail-$company_insure_percent,2));
                    $array_diff_company[] = $array_diff;
               }

               //compare tax
               $amt_tax_company = round($amt_tax_all * $company[0]->company_percent/100,2);
               //
            }
            if($sum_company_percent == 100){
                if(count($array_diff_company) > 0){
                    $this->recalculateInsure($data, $array_diff_company);
                }
                $sum_tax_all_company = array_sum($array_tax);
                if($sum_tax_all_company > $amt_tax_all){
                     $decrease_tax = $sum_tax_all_company - $amt_tax_all;
                     $array_tax[$company_code_default_flags] = $array_tax[$company_code_default_flags] - $decrease_tax;
                     $this->recalculateTax($data, $all_company_insure, $company_code_default_flags ,$array_tax, $data_all_company, $decrease_tax);
                }
                $sum_duty_all_company = array_sum($array_duty);
                if($sum_duty_all_company > $amt_duty_all){
                     $decrease_duty = $sum_duty_all_company - $amt_duty_all;
                     $array_duty[$company_code_default_flags] = $array_duty[$company_code_default_flags] - $decrease_duty;
                     $this->recalculateDuty($data, $company_code_default_flags, $decrease_duty);
                }
            }//end if
    }


    public function recalculateTax(&$data, $all_company_insure, $company_code_default_flags, $array_tax, $data_all_company, $decrease_tax){
        \Log::debug('fnrecalculateTax');
         $company_array  = [];
         $array_data = json_decode(json_encode($data),true);
         foreach($data->where('company_code',$company_code_default_flags)->groupBy('department_code') as $department_code => $lines){
             $array_line = [];
             foreach ($lines as $line){
                $array_line[]= $line;
                if(!array_key_exists($department_code, $company_array)){
                    $company_array[$department_code]["amt_insure"] = $line->amt_insure;
                }else{
                    $company_array[$department_code]["amt_insure"]  = $company_array[$department_code]["amt_insure"] + $line->amt_insure;
                }
             }
             $company_array[$department_code]["department"] =  $array_line;
         }
        array_multisort(
                    array_column($company_array, 'amt_insure'),
                    SORT_DESC,
                    $company_array
                 );
                $department_array =json_decode(json_encode($company_array[0]["department"]),true);
                //sort amt_insure of department to get maximum value
                array_multisort(
                        array_column($department_array, 'amt_insure'),
                        SORT_DESC,
                        $department_array
        );
        $department_to_diff = $department_array[0];

        $department_code = $department_to_diff['department_code'];
        $company_code = $department_to_diff["company_code"];
        $index= null;
        
        //find index to update diff value
         array_filter($array_data, function($val, $key) use($department_code , $company_code, &$index){
              if($val['department_code'] === $department_code
                and $val['company_code'] === $company_code
                )
              {
                $index = $key;
              }
         }, ARRAY_FILTER_USE_BOTH);

           // add flag diff tax
           if($index !== null){
            $data[$index]->decrease_tax =  $decrease_tax ;
           }
    }
    public function recalculateDuty(&$data, $company_code_default_flags, $decrease_duty){
         $company_array  = [];
         $array_data = json_decode(json_encode($data),true);
         foreach($data->where('company_code',$company_code_default_flags)->groupBy('department_code') as $department_code => $lines){
             $array_line = [];
             foreach ($lines as $line){
                $array_line[]= $line;
                if(!array_key_exists($department_code, $company_array)){
                    $company_array[$department_code]["amt_insure"] = $line->amt_insure;
                }else{
                    $company_array[$department_code]["amt_insure"]  = $company_array[$department_code]["amt_insure"] + $line->amt_insure;
                }
             }
             $company_array[$department_code]["department"] =  $array_line;
         }
        array_multisort(
                    array_column($company_array, 'amt_insure'),
                    SORT_DESC,
                    $company_array
                 );
                $department_array =json_decode(json_encode($company_array[0]["department"]),true);
                //sort amt_insure of department to get maximum value
                array_multisort(
                        array_column($department_array, 'amt_insure'),
                        SORT_DESC,
                        $department_array
        );
        $department_to_diff = $department_array[0];

        $department_code = $department_to_diff['department_code'];
        $company_code = $department_to_diff["company_code"];
        $index= null;
        
        //find index to update diff value
         array_filter($array_data, function($val, $key) use($department_code , $company_code, &$index){
              if($val['department_code'] === $department_code
                and $val['company_code'] === $company_code
                )
              {
                $index = $key;
              }
         }, ARRAY_FILTER_USE_BOTH);

           // add flag diff duty
           if($index !== null){
            $data[$index]->decrease_duty =  $decrease_duty ;
           }
    }

    public function recalculateInsure(&$data, $array_diff_company)
    {
        $array_data = json_decode(json_encode($data),true);
        foreach($array_diff_company as $diff_detail){
             $company_code = $diff_detail["company_code"];
             $diff_amount = $diff_detail["diff_amount"];
              //find company from company code
              $company_array  = [];
                    foreach ($data->where('company_code',$company_code)->groupBy('department_code') as $department_code => $lines){

                        $array_line = [];

                         foreach ($lines as $line){

                             $array_line[]= $line;

                            if(!array_key_exists($department_code, $company_array)){
                                $company_array[$department_code]["amt_insure"] = $line->amt_insure;
                            }else{
                                $company_array[$department_code]["amt_insure"]  = $company_array[$department_code]["amt_insure"] + $line->amt_insure;
                            }
                         }
                         $company_array[$department_code]["department"] =  $array_line;
                }
                  array_multisort(
                    array_column($company_array, 'amt_insure'),
                    SORT_DESC,
                    $company_array
                 );
                $department_array =json_decode(json_encode($company_array[0]["department"]),true);
                //sort amt_insure of department to get maximum value
                array_multisort(
                        array_column($department_array, 'amt_insure'),
                        SORT_DESC,
                        $department_array
                );

                $department_to_diff = $department_array[0];

                //dd($department_to_diff);
                $old_amt_insure = $department_to_diff["amt_insure"];
                $new_amt_insure = $department_to_diff["amt_insure"] + $diff_amount;
                $item_title = $department_to_diff["item_title"];
                $department_code = $department_to_diff['department_code'];
                $company_code = $department_to_diff["company_code"];
                $group_title = $department_to_diff["group_title"];
                $index= null;
                
                //find index to update diff value
                 array_filter($array_data, function($val, $key) use($department_code , $old_amt_insure , $company_code , $group_title ,$item_title, &$index){
                      if($val['department_code'] === $department_code
                        and $val['company_code'] === $company_code
                        and $val['group_title'] === $group_title
                        and $val['item_title'] ===  $item_title
                        and $val['amt_insure'] ===  $old_amt_insure
                        )
                      {
                        $index = $key;
                      }
                 }, ARRAY_FILTER_USE_BOTH);

                //update new amt_insure with fixed diff value
               if($index !== null){
                $data[$index]->amt_insure = $new_amt_insure ;
                $data[$index]->diff =  $diff_amount ;
               }
        }//
       
    }
}
