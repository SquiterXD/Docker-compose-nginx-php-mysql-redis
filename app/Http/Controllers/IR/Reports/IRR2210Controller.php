<?php
namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class IRR2210Controller extends Controller{
	public function export($programCode, $request){
        $s_year_th=$request['s_year']; // ปี
        $s_month=$request['s_month']; // เดือน
        $s_set=$request['s_set']; // ชุดที่
        $item_f=$request['item_f']; // รายการที่
        $item_t=($request['item_t']!='')?$request['item_t']:$request['item_f'];
        $company_f=$request['company_f']; // บริษัทประกัน
        $company_t=($request['company_t']!='')?$request['company_t']:$request['company_f'];
        $s_year=$s_year_th-543;
        $s_date=$s_year.'-'.$s_month.'-01';

        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;

        $sql_con="";
        $sql_con.=($company_f!="" && $company_t!="")?" and (A.COMPANY_ID between '{$company_f}' and '{$company_t}')":"";
        $sql_con.=($item_f!="" && $item_t!="")?" and (L.STOCK_LIST_DESCRIPTION between '{$item_f}' and '{$item_t}')":"";

        $tb_period="
            SELECT
                TO_CHAR(LAST_DAY(TRUNC(ADD_MONTHS('{$s_date}', -1),'MM')),'DD MON YYYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') month_pre,
                TO_CHAR(LAST_DAY(TRUNC(ADD_MONTHS('{$s_date}', 0),'MM')),' MONTH YYYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') month_cur,
                TO_CHAR(LAST_DAY(TRUNC(ADD_MONTHS('{$s_date}', 0),'MM')),'DD MON YYYY','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') month_end
            FROM DUAL
        ";
        $periods=DB::table(DB::raw("({$tb_period}) a"))->get()->first();

        $tb_set="
            SELECT POLICY_SET_DESCRIPTION set_desc
            FROM PTIR_POLICY_SET_HEADERS
            WHERE POLICY_TYPE_CODE='DCT' and POLICY_SET_HEADER_ID='{$s_set}'
        ";
        $sets=DB::table(DB::raw("({$tb_set}) a"))->get()->first();

        $tb_date="
            SELECT
                trunc(insurance_end_date) - trunc(insurance_start_date) as days_year,
                POLICY_SET_DESCRIPTION set_title,
                insurance_start_date  date_f,
                insurance_end_date  date_t
            FROM PTIR_STOCK_HEADERS
            WHERE POLICY_SET_HEADER_ID='{$s_set}' and YEAR='{$s_year}'
        ";
        $dates=DB::table(DB::raw("({$tb_date}) a"))->get();

        $date_f = date('Y-m-d',strtotime((count($dates)>0)?$dates->first()->date_f:'first of year'));
        $date_t = date('Y-m-d',strtotime((count($dates)>0)?$dates->first()->date_t:'end of year'));
        $set_title =$sets->set_desc;
        //$set_title =(count($sets)>0)?$sets->first()->set_title:'';
        //$date_t = date('Y-m-d',strtotime($sets->date_t));

        $thDate_f = parseToDateTh($date_f);
        $thDate_t = parseToDateTh($date_t);


        $tb_view="
            SELECT
                T.policy_no,
                T.cat_title,
                T.acc_no,
                SUM(T.balance_1) balance_1 ,
                SUM(T.amt_ar) amt_ar,
                SUM(T.amt_ap) amt_ap,
                SUM(T.balance_2) balance_2,
                SUM(T.pending) pending
            FROM(
                SELECT
                    policy_no,
                    cat_title,
                    acc_no,
                    balance_1,
                    amt_ar,
                    amt_ap,
                    (balance_1 + amt_ar -amt_ap) balance_2,
                    CASE WHEN (balance_1 + amt_ar -amt_ap) < 0 THEN (balance_1 + amt_ar -amt_ap) ELSE 0 END  pending
                FROM (
                    SELECT
                        policy_no,
                        cat_title,
                        acc_no,
                        CASE WHEN (SELECT EXTRACT(MONTH FROM TO_DATE('{$s_date}','DD-MM-YYYY'))  FROM DUAL) = 10 THEN 0 ELSE
                        CASE WHEN UPPER(INCLUDE_TAX_FLAG)='Y' THEN
                            ROUND((ROUND((INSURANCE_PREMIUM2 + (INSURANCE_PREMIUM2 * REVENUE_STAMP)),2) +
                            ROUND(((INSURANCE_PREMIUM2 + (INSURANCE_PREMIUM2 * REVENUE_STAMP)) * TAX),2)) * COMPANY_PERCENT * PREPAID_INSURANCE,2)
                        ELSE
                            ROUND(ROUND((INSURANCE_PREMIUM2 + (INSURANCE_PREMIUM2 * REVENUE_STAMP)),2) * COMPANY_PERCENT * PREPAID_INSURANCE,2) END
                        END balance_1,
                        CASE WHEN (SELECT  EXTRACT(MONTH FROM TO_DATE('{$s_date}','DD-MM-YYYY'))  FROM DUAL) = 10 THEN 0 ELSE
                        CASE WHEN UPPER(INCLUDE_TAX_FLAG)='Y' THEN
                            ROUND((ROUND((INSURANCE_PREMIUM + (INSURANCE_PREMIUM * REVENUE_STAMP)),2) +
                            ROUND(((INSURANCE_PREMIUM + (INSURANCE_PREMIUM * REVENUE_STAMP)) * TAX),2)) * COMPANY_PERCENT * PREPAID_INSURANCE,-2)
                        ELSE
                            ROUND(ROUND((INSURANCE_PREMIUM + (INSURANCE_PREMIUM * REVENUE_STAMP)),2) * COMPANY_PERCENT * PREPAID_INSURANCE ,2) END
                        END amt_ar,
                        amt_ap
                    FROM (
                        SELECT
                            A.USER_POLICY_NUMBER policy_no,
                            L.STOCK_LIST_DESCRIPTION cat_title,
                            SA.EXPENSE_ACCOUNT acc_no,
                            ROUND(L.COVERAGE_AMOUNT * GL.PREMIUM_RATE,2) INSURANCE_PREMIUM,
                            ROUND(L2.COVERAGE_AMOUNT * GL.PREMIUM_RATE,2) INSURANCE_PREMIUM2,
                            SH.INCLUDE_TAX_FLAG,
                            (A.COMPANY_PERCENT/100) COMPANY_PERCENT,
                            (GL.TAX/100) TAX,
                            (GL.REVENUE_STAMP/100) REVENUE_STAMP,
                            (GL.PREPAID_INSURANCE/100) PREPAID_INSURANCE,
                            ROUND(SA.NET_AMOUNT*(A.COMPANY_PERCENT/100),2) amt_ap
                        FROM PTIR_STOCK_HEADERS H
                        INNER JOIN (SELECT HEADER_ID,LINE_ID,POLICY_SET_HEADER_ID,STOCK_LIST_DESCRIPTION,COVERAGE_AMOUNT FROM PTIR_STOCK_LINES WHERE UPPER(STATUS) ='INTERFACE' AND  NVL(PERIOD_NAME,'') = TO_CHAR(ADD_MONTHS(TO_DATE('{$s_date}','DD-MM-YYYY'), 0),'MM-YYYY')) L ON H.HEADER_ID = L.HEADER_ID
                        INNER JOIN (SELECT HEADER_ID,LINE_ID,POLICY_SET_HEADER_ID,COVERAGE_AMOUNT FROM PTIR_STOCK_LINES WHERE UPPER(STATUS) ='INTERFACE' AND NVL(PERIOD_NAME,'')= TO_CHAR(ADD_MONTHS(TO_DATE('{$s_date}','DD-MM-YYYY'), -1),'MM-YYYY')) L2 ON H.HEADER_ID = L2.HEADER_ID
                        INNER JOIN PTIR_EXPENSE_STOCK_ASSETS SA ON L.LINE_ID = SA.REFERENCE_LINE_ID AND L.HEADER_ID=SA.REFERENCE_HEADER_ID
                        INNER JOIN PTIR_POLICY_SET_HEADERS SH ON L.POLICY_SET_HEADER_ID = SH.POLICY_SET_HEADER_ID
                        INNER JOIN PTIR_POLICY_GROUP_SETS GS ON SH.POLICY_SET_HEADER_ID = GS.POLICY_SET_HEADER_ID
                        INNER JOIN PTIR_POLICY_GROUP_HEADERS GH ON GS.GROUP_HEADER_ID = GH.GROUP_HEADER_ID
                        INNER JOIN PTIR_POLICY_GROUP_LINES GL ON GH.GROUP_HEADER_ID = GL.GROUP_HEADER_ID
                        INNER JOIN PTIR_POLICY_GROUP_DISTS A ON GL.GROUP_LINE_ID = A.GROUP_LINE_ID AND GL.GROUP_HEADER_ID = A.GROUP_HEADER_ID
                        WHERE UPPER(SH.POLICY_TYPE_CODE)='DCT'
                            AND H.POLICY_SET_HEADER_ID = '{$s_set}'
                            AND H.YEAR = '{$s_year}'
                            {$sql_con}
                    ) a
                ) b
            ) T
            GROUP BY ROLLUP(policy_no,cat_title,acc_no)
            ORDER BY 1,2,3
        ";

        $data = DB::table(DB::raw("({$tb_view}) a"))->get();

        $progTitle.= " ประจำเดือน ".$periods->month_cur;
        $progPara[0]="ตั้งแต่ วันที่ $thDate_f ถึงวันที่ $thDate_t";

        $headLeft[0]= "ชุดที่ ".$s_set." : ".$set_title;

        $pdf = PDF::loadView('ir.reports.irr2210.pdf.index',compact('data','headLeft','programCode','progTitle','progPara','periods'))
            ->setPaper('a4','landscape')
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',12)
            ->setOption('header-spacing',3)
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode. '.pdf');
    }
}
