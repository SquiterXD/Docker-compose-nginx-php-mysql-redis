<?php
namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class IRR6140Controller extends Controller{
	public function export($programCode, $request){
        $s_set=$request['s_set']; // ชุดที่
        $s_year=$request['s_year']; // ปี

        $month_f=$request['month_f']; // ตั้งแต่เดือน
        $month_t=$request['month_t']; // ถึงเดือน

        $s_location=$request['s_location']; // กลุ่มของทรัพย์สิน
        $s_company=$request['s_company']; // บริษัทประกัน
        $s_policyno=$request['s_policyno']; // เลขที่กรมธรรม์
        $dept_f=$request['dept_f']; // สังกัด
        $dept_t=($request['dept_t']!='')?$request['dept_t']:$request['dept_f'];
        $remark = $request['remark'];
        $status = $request['status'];
        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;

        $sql_con="";
        $sql_con.=($s_company!="")?" and z.COMPANY_ID='$s_company'":"";
        $sql_con.=($s_location!="")?" and l.location_code='$s_location'":"";
        $sql_con.=($dept_f!="" && $dept_t!="")?" and (l.department_code between '{$dept_f}' and '{$dept_t}')":"";
        $sql_con.=($s_policyno!="")?" and A.user_policy_number like '{$s_policyno}%' ":"";

        $sql_company=($s_company!="")?" and A.COMPANY_ID='{$s_company}' ":"and C.YEAR = '{$s_year}' AND E.ACTIVE_FLAG ='Y' AND D.POLICY_SET_HEADER_ID = {$s_set}"; // บริษัทประกัน

        $tb_set="
            SELECT
                trunc(insurance_end_date) - trunc(insurance_start_date) as days_year,
                POLICY_SET_DESCRIPTION set_title,
                insurance_start_date  date_f,
                insurance_end_date  date_t
            FROM PTIR_ASSET_HEADERS
            WHERE PROGRAM_CODE='IRP0003' and POLICY_SET_HEADER_ID='{$s_set}' and YEAR='{$s_year}'
        ";
        $sets=DB::table(DB::raw("({$tb_set}) a"))->get()->first();
        $date_f = date('Y-m-d',strtotime($sets->date_f));
        $date_t = date('Y-m-d',strtotime($sets->date_t));
        $thDate_f = parseToDateTh($date_f);
        $thDate_t = parseToDateTh($date_t);

        $sql_s="";

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
                WHERE 0=0
                    {$sql_company}
            ) z
            WHERE z.YEAR = '{$s_year}' AND z.POLICY_SET_HEADER_ID = {$s_set}
            GROUP BY 1
        ";
        $companies = DB::table(DB::raw("({$tb_company}) a"))->get()->first();
        $policy_no=($s_company!="")?"z.user_policy_number":"'{$companies->policy_no}'";
        $comp_name=($s_company!="")?"z.company_name":"'{$companies->comp_name}'";
        $comp_percent=($s_company!="")?"z.company_percent":"'100'";
        $insur_percent=($s_company!="")?"z.prepaid_insurance":"'100'";

        $tb_expense="
            SELECT
                b.description as exp_title
            FROM PTIR_POLICY_SET_HEADERS a
            left join PTIR_ACCOUNTS_MAPPING_V b on a.ACCOUNT_ID = b.ACCOUNT_ID
            WHERE /*a.PROGRAM_CODE='IRP0003' and*/ a.POLICY_SET_HEADER_ID='{$s_set}'
        ";
        $expense=DB::table(DB::raw("({$tb_expense}) a"))->get()->first();

        $tb_view="
            SELECT
                l.location_name group_01,
                l.department_name group_02,
                l.CATEGORY_DESCRIPTION cat_title,
                {$comp_name} as comp_name,
                {$comp_percent} as comp_percent,
                sum(
                    CASE
                        WHEN NVL(h.include_tax_flag,'')='Y'
                        THEN round(NVL(l.net_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                        ELSE (round(NVL(l.insurance_amount,0),2)+round(NVL(l.duty_amount,0),2))*round(NVL(z.company_percent,0)/100,2)
                    END
                ) amt_insure0,
                sum(
                    CASE
                        WHEN NVL(h.include_tax_flag,'')='Y'
                        THEN round(NVL(l.net_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)
                        ELSE (round(NVL(l.insurance_amount,0),2)+round(NVL(l.duty_amount,0),2))*round(NVL(z.company_percent,0)/100,2)
                    END
                ) amt_insure,
                sum(round(NVL(l.insurance_amount,0),2)*round(NVL(z.company_percent,0)/100,2)*round(NVL(z.prepaid_insurance,0)/100,2)) amt_insure1
            FROM PTIR_ASSET_LINES l
            JOIN PTIR_POLICY_SET_HEADERS h on (h.policy_set_header_id=l.policy_set_header_id)
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
                JOIN PTIR_POLICY_GROUP_HEADERS B ON C.GROUP_HEADER_ID = B.GROUP_HEADER_ID
                WHERE 0=0
                    {$sql_company}
            ) z on (z.policy_set_header_id=l.policy_set_header_id and z.year=l.year)
            WHERE l.PROGRAM_CODE='IRP0003' and NVL(l.ASSET_STATUS,'')='Y'
                AND l.POLICY_SET_HEADER_ID={$s_set}
                and l.year='{$s_year}'
                {$sql_con}
            GROUP BY l.department_name,l.location_name,l.CATEGORY_DESCRIPTION,{$comp_name},{$comp_percent}
            order by l.location_name,l.department_name,l.CATEGORY_DESCRIPTION,{$comp_name},{$comp_percent}
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();

        $progTitle = "ชุดที่ ".$s_set." : ".$sets->set_title;
        $progPara[0]= "ข้อมูลรายการค่าเบี้ยประกันภัยจ่ายล่วงหน้า ตั้งแต่วันที่ $thDate_f ถึงวันที่ $thDate_t";
        $headLeft[0] = "ผู้รับประกันภัย : ".$companies->comp_name;
        $headLeft[1] = "ประเภท : ".$expense->exp_title;

        $headRight[0] = "";
        // $headRight[0] = "เลขที่กรมธรรม์ : ".$companies->policy_no;

        $pdf = PDF::loadView('ir.reports.irr6140.pdf.index',compact('data','headLeft','headRight','programCode','progTitle','progPara','remark'))
            ->setPaper('a4','landscape')
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',3)
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode. '.pdf');
    }
}
