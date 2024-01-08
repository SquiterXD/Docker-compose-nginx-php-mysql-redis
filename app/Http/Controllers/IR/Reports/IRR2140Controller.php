<?php
namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class IRR2140Controller extends Controller{
	public function export($programCode, $request){
        $s_set=$request['s_set']; // ชุดที่
        $s_year=$request['s_period']; // ปี

        $group_f=$request['group_f']; // กลุ่มทรัพย์สินตั้งแต่ location_code
        $group_t=($request['group_t']!='')?$request['group_t']:$request['group_f'];
        $company_f=$request['company_f']; // บริษัทประกัน
        $company_t=($request['company_t']!='')?$request['company_t']:$request['company_f'];
        $item_f=$request['item_f']; // รายการตั้งแต่
        $item_t=($request['item_t']!='')?$request['item_t']:$request['item_f'];

        $remark = $request['remark'];
        $status = $request['status'];
        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;

        $sql_con="";
        $sql_con.=($status!="")?" and NVL(L.STATUS,'')='$status'":" and L.STATUS NOT IN ('CANCELLED')";
        $sql_con.=($company_f!="")?" and (A.COMPANY_ID between '{$company_f}' and '{$company_t}')":"";
        $sql_con.=($group_f!="")?" and (G.DESCRIPTION between '{$group_f}' and '{$group_t}')":"";
        $sql_con.=($item_f!="")?" and (L.STOCK_LIST_DESCRIPTION between '{$item_f}' and '{$item_t}')":"";
        $sql_company=($company_f!="")?" and (A.COMPANY_ID between '{$company_f}' and '{$company_t}') ":"and C.YEAR = '{$s_year}' AND E.ACTIVE_FLAG ='Y' AND D.POLICY_SET_HEADER_ID = {$s_set}";

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
        $policy_no=($company_f!="")?"T.user_policy_number":"'{$companies->policy_no}'";
        $comp_name=($company_f!="")?"T.company_name":"'{$companies->comp_name}'";

        $tb_view="
            SELECT
                {$comp_name} company_title,
                {$policy_no} policy_no,
                T.group_title,
                T.type_title,
                T.item_title,
                T.set_title,
                to_char(T.date_f,'DD MONTHYYYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') as date_f,
                to_char(T.date_t,'DD MONTHYYYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE = THAI') as date_t,
                SUM(T.COVERAGE_AMOUNT * T.PREMIUM_RATE * T.PREPAID_INSURANCE  * T.COMPANY_PERCENT  * T.CALCULATE_DAYS) amt_insure
            FROM (
                SELECT
                    AC.DESCRIPTION type_title,
                    G.DESCRIPTION  group_title,
                    L.STOCK_LIST_DESCRIPTION item_title,
                    L.POLICY_SET_DESCRIPTION set_title,
                    A.user_policy_number,
                    C.COMPANY_NAME,
                    L.insurance_start_date  date_f,
                    L.insurance_end_date  date_t,
                    L.COVERAGE_AMOUNT,
                    GL.PREMIUM_RATE,
                    GL.PREPAID_INSURANCE,
                    (A.COMPANY_PERCENT/100) COMPANY_PERCENT,
                    CASE WHEN UPPER(L.LINE_TYPE) ='INVENTORY'
                            THEN trunc(L.insurance_end_date)-trunc(L.insurance_start_date)
                            ELSE  NVL(L.CALCULATE_DAYS,0)
                    END CALCULATE_DAYS
                FROM PTIR_STOCK_LINES L
                INNER JOIN PTIR_POLICY_SET_HEADERS SH ON L.POLICY_SET_HEADER_ID = SH.POLICY_SET_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_SETS GS ON SH.POLICY_SET_HEADER_ID = GS.POLICY_SET_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_HEADERS GH ON GS.GROUP_HEADER_ID = GH.GROUP_HEADER_ID
                INNER JOIN PTIR_POLICY_GROUP_LINES GL ON GH.GROUP_HEADER_ID = GL.GROUP_HEADER_ID AND L.YEAR = GL.YEAR
                INNER JOIN PTIR_POLICY_GROUP_DISTS A ON GL.GROUP_LINE_ID = A.GROUP_LINE_ID AND GL.GROUP_HEADER_ID = A.GROUP_HEADER_ID
                INNER JOIN PTIR_COMPANIES C ON A.COMPANY_ID = C.COMPANY_ID
                INNER JOIN PTIR_ACCOUNTS_MAPPING AC ON SH.ACCOUNT_ID = AC.ACCOUNT_ID
                INNER JOIN PTIR_ASSET_GROUP_V G ON L.ASSET_GROUP_CODE = G.VALUE
                WHERE L.POLICY_SET_HEADER_ID='{$s_set}'
                    AND GL.YEAR = '{$s_year}'
                    {$sql_con}
            ) T
            GROUP BY T.group_title,T.type_title,T.item_title,T.set_title,T.date_f,T.date_t,{$comp_name},{$policy_no}
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();
        $row=$data->first();

        $progTitle = "ชุดที่ ".$s_set." : $row->set_title ";
        $progPara[0]= "ข้อมูลรายการค่าเบี้ยประกันภัยจ่ายล่วงหน้า ตั้งแต่วันที่ $row->date_f  ถึงวันที่ $row->date_t ";

        $headLeft[0] = "ผู้รับประกันภัย : $row->company_title";
        $total_title=$headLeft[1] = "ประเภท : ".(count($data)>0?$row->type_title:"");

        $headRight[0] = "เลขที่กรมธรรม์ : $row->policy_no";

        $pdf = PDF::loadView('ir.reports.irr2140.pdf.index',compact('data','headLeft','headRight','programCode','progTitle','progPara','status','total_title'))
            ->setPaper('a4','landscape')
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',3)
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode. '.pdf');
    }
}
