<?php
namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class IRR6030Controller extends Controller{
	public function export($programCode, $request){
        $s_set=$request['s_set']; // ชุดที่
        $s_period=$request['s_period']; // จาก ถึง
        $s_location=$request['s_location']; // กลุ่มของทรัพย์สิน
        $dept_f=$request['dept_f']; // สังกัด
        $dept_t=($request['dept_t']!='')?$request['dept_t']:$request['dept_f'];
        $company_f=$request['company_f']; // บริษัทประกัน
        $company_t=($request['company_t']!='')?$request['company_t']:$request['company_f'];
        $status = $request['status'];
        $remark = $request['remark'];
        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $repTitle = $progReport->description;

        $sql_con="";
        $sql_con.=($s_location!="")?" and l.location_code='$s_location'":"";
        $sql_con.=($status!="")?" and NVL(l.STATUS,'CANCELLED')='$status'":" and NVL(l.STATUS,'CANCELLED') <>'CANCELLED'";
        $sql_con.=($dept_f!="" && $dept_t!="")?" and (l.department_code between '{$dept_f}' and '{$dept_t}')":"";
        $sql_con.=($company_f!="" && $company_t!="")?" and (z.COMPANY_ID between '{$company_f}' and '{$company_t}')":"";

        $tb_set="
            SELECT POLICY_SET_DESCRIPTION set_desc
            FROM PTIR_POLICY_SET_HEADERS
            WHERE POLICY_SET_HEADER_ID='{$s_set}'
        ";
        $sets=DB::table(DB::raw("({$tb_set}) a"))->get()->first();
        $set_title = $sets->set_desc;

        $tb_date="
            SELECT
                trunc(insurance_end_date) - trunc(insurance_start_date) as days_year,
                POLICY_SET_DESCRIPTION as set_title,
                insurance_start_date as  date_f,
                insurance_end_date as  date_t,
                year as year
            FROM PTIR_ASSET_HEADERS
            WHERE  program_code='IRP0003'
                and YEAR='{$s_period}'
                and POLICY_SET_HEADER_ID='{$s_set}'
        ";
        $dates=DB::table(DB::raw("({$tb_date}) a"))->get();
        $date_f = (count($dates)>0)?$dates->first()->date_f:date('Y-m-d',strtotime('first of year'));
        $date_t = (count($dates)>0)?$dates->first()->date_t:date('Y-m-d',strtotime('end of year'));
        $days_year = (count($dates)>0)?$dates->first()->days_year:365;

        $date_f = date('Y-m-d',strtotime($date_f));
        $date_t = date('Y-m-d',strtotime($date_t));
        $thDate_f = parseToDateTh($date_f);
        $thDate_t = parseToDateTh($date_t);

        $tb_period="
            SELECT
                TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR'))-(TRUNC(SYSDATE)-TRUNC(START_DATE_ACTIVE)) as days_left
            FROM PTIR_EFFECTIVE_DATE
            WHERE LOOKUP_CODE = '{$s_period}' AND ENABLED_FLAG='Y'
        ";
        $periods=DB::table(DB::raw("({$tb_period}) a"))->get()->first();
        $days_left=$periods->days_left;

        $tb_month="
            select
                'm'|| level as mth_code,
                add_months(date'{$date_f}'+1,level)-add_months(date'{$date_f}'+1,level-1) as mth_days,
                to_char(add_months(date'{$date_f}'+1,level-1),'monYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') as mth_th
            from dual
            connect by level <= months_between(date '{$date_t}'+1,date '{$date_f}')
        ";
        $months = DB::table(DB::raw("({$tb_month}) a"))->get();

        $tb_company="
            SELECT
                LISTAGG(COMPANY_NAME,', ') WITHIN GROUP (ORDER BY COMPANY_NAME) AS comp_name,
                LISTAGG(policyno,', ') WITHIN GROUP (ORDER BY policyno) AS policy_no
            FROM (
                select
                    E.company_name,
                    A.company_code,
                    A.company_percent,
                    C.prepaid_insurance,
                    A.user_policy_number as policyno,
                    D.policy_set_header_id,
                    C.year,E.company_id
                from PTIR_POLICY_GROUP_DISTS A
                join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                join PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
                join PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
                JOIN PTIR_POLICY_GROUP_HEADERS B ON C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
                WHERE E.ACTIVE_FLAG ='Y'
            ) z
            WHERE z.YEAR = '{$s_period}' AND z.POLICY_SET_HEADER_ID = {$s_set}
            GROUP BY 1
        ";
        $companys = DB::table(DB::raw("({$tb_company}) a"))->get()->first();

        $policy_no=($company_f!="" && $company_t!="")?"z.user_policy_number":"'{$companys->policy_no}'";
        $comp_name=($company_f!="" && $company_t!="")?"z.company_name":"'{$companys->comp_name}'";
        $comp_percent=($company_f!="" && $company_t!="")?"z.company_percent":"'100'";
        $insur_percent=($company_f!="" && $company_t!="")?"z.prepaid_insurance":"'100'";

        $sel_mth="";
        foreach($months as $m){
            $val=$m->mth_days/$days_year;
            $as="amt_".$m->mth_code;
            $as2="amt2_".$m->mth_code;
            $sel_mth.="
                sum(
                    CASE
                        WHEN NVL(h.include_tax_flag,'')='Y'
                        THEN round(NVL(l.net_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)*$val
                        ELSE (round(NVL(l.insurance_amount,0),2)+round(NVL(l.duty_amount,0),2))*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)*$val
                    END
                ) $as ,
            ";
            //$sel_mth.="sum(round(NVL(l.insurance_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)*$val) $as ,";
        }

        $tb_view="
            SELECT
                {$comp_name} group_comp,
                {$comp_percent} comp_percent,
                {$insur_percent} insur_percent,
                {$policy_no} policy_no,
                l.location_name group_01,
                l.department_name group_02,
                l.CATEGORY_DESCRIPTION cat_title,

                {$sel_mth}

                max((TRUNC(NVL(l.CALCULATE_END_DATE,SYSDATE+1))-TRUNC(SYSDATE))/TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR'))) aa,
                max(NVL(z.PREMIUM_RATE,0)) rate_set,
                max(NVL(z.prepaid_insurance,0)) amt_prepaid,
                max(NVL(z.company_percent,0)) rate_comp,
                sum(round(NVL(l.COVERAGE_AMOUNT,0),2)) cover,
                sum(round(NVL(l.insurance_amount,0),2)) insur,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)*round(NVL(z.premium_rate,0),2)) amt_cover,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_insure,
                sum(round(NVL(l.COVERAGE_AMOUNT,0),2)*round(NVL(z.company_percent,0)/100,2)) amt_cost,
                sum(
                    CASE
                        WHEN NVL(h.include_tax_flag,'')='Y'
                        THEN round(NVL(l.net_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                        ELSE (round(NVL(l.insurance_amount,0),2)+round(NVL(l.duty_amount,0),2))*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                    END
                ) amt_close,
                sum(round(NVL(l.duty_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_duty,
                sum(round(NVL(l.vat_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_vat,
                sum(round(NVL(l.vat_amount,0),2)) amt_vat1,
                sum(round(NVL(l.net_amount,0),2)) amt_net

            FROM PTIR_ASSET_LINES l
            JOIN (
                select
                    A.company_code,
                    A.company_percent,
                    E.company_name,
                    C.prepaid_insurance,
                    C.premium_rate,
                    A.user_policy_number,
                    D.policy_set_header_id,C.year,E.company_id
                from PTIR_POLICY_GROUP_DISTS A
                join PTIR_COMPANIES E on E.COMPANY_NUMBER = A.COMPANY_CODE
                join PTIR_POLICY_GROUP_LINES C on (C.group_line_id=A.group_line_id)
                join PTIR_POLICY_GROUP_SETS D on (D.group_header_id=C.group_header_id)
            ) z on (z.policy_set_header_id=l.policy_set_header_id and z.year=l.year)
            JOIN PTIR_POLICY_SET_HEADERS h on (h.policy_set_header_id=l.policy_set_header_id)
            WHERE l.program_code='IRP0003' and NVL(l.ASSET_STATUS,'')='Y'
                AND l.POLICY_SET_HEADER_ID='{$s_set}'
                and l.year='{$s_period}'
                {$sql_con}
            GROUP BY {$comp_name},{$comp_percent},{$insur_percent},{$policy_no},l.department_name,l.location_name,l.CATEGORY_DESCRIPTION
            order by {$comp_name},{$comp_percent},{$insur_percent},{$policy_no},l.location_name,l.department_name,l.CATEGORY_DESCRIPTION
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();

        $progTitle = "ชุดที่ ".$s_set." : ".$set_title;
        $repTitle  = $repTitle." กับ ";
        $progPara[0]="ตั้งแต่ วันที่ $thDate_f ถึงวันที่ $thDate_t";

        $headLeft[0]= "สถานะ : ".$status;
        $titles=[
            'dateth_f'=>$thDate_f,
            'dateth_t'=>$thDate_t,
            'set_title'=>$set_title,
            'days_left'=>$days_left,
            'days_year'=>$days_year,
            'insur_percent'=>$insur_percent,
            'comp_percent'=>$comp_percent
        ];

        $pdf = PDF::loadView('ir.reports.irr6030.pdf.index',compact('data','titles','months','repTitle','programCode','progTitle','progPara','status','remark'))
            ->setPaper('a4','landscape')
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',3)
            ->setOption('header-right',"\n\n\n[page]/[topage]   ")
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode. '.pdf');
    }
}
