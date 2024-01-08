<?php

namespace App\Http\Controllers\EAM\Reports;

use App\Exports\EAM\Eam0003excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EMP0003Controller extends Controller
{

    function DateThai($strDate,$type)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strMonthFull = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        $strMonthThaiFull = $strMonthFull[$strMonth];
        $strThaidate=$strMonthThai." ".$strYear;
        if($type=="f"){
            $strThaidate=$strDay." ".$strMonthThaiFull." ".$strYear;
        }
        return $strThaidate;
    }

    public function exportexcel(Request $request)
    {

        $year = $request->year - 543;
        $owner = isset($request->owner)?" and a.department ='".$request->owner."'":"";
        $response = isset($request->response)?" and d.receiving_department_code ='".$request->response."'":"";

        $syear = $year - 1;
        $tyear = $year + 543;
        $y = $request->year;
        $s_y = $request->year - 1;
        $programCode = 'EAM';
        $progTitle = 'PM';
        $m['Week'] = 0;
        for ($i = 1; $i <= 13; $i++) {
            $m[$i]['w'] = date("W", strtotime('+ ' . ($i - 1) . ' month', strtotime($syear . '-10-01')));
            $m[$i]['wp'] = date("W", strtotime('+ ' . ($i) . ' month', strtotime($syear . '-10-01')));
            $m[$i]['d'] = $this->DateThai(date("Y-m-d", strtotime('+ ' . ($i - 1) . ' month', strtotime($syear . '-10-01'))),"");
            if ($m[$i]['wp'] < $m[$i]['w']) {
                if ($m[$i]['wp'] == '01') {
                    $m[$i]['span'] = $m[$i]['wp'] + 52 - $m[$i]['w'];
                } else {
                    $m[$i]['span'] = $m[$i]['wp'] + 0;
                }
            } else {
                $m[$i]['span'] = $m[$i]['wp'] - $m[$i]['w'];
            }
            if ($i < 13) {
                $m['Week'] = $m['Week'] + $m[$i]['span'];
            }
        }
        $m['End'] = date("W", strtotime($syear . '-12-31'));


        $sql = "SELECT h.plan_id,h.year_plan,h.status_plan,
                d.plan_line_id,d.asset_desc,to_char(d.scheduled_start_date,'IW') d_start,
                to_char(d.scheduled_completion_date,'IW') d_comp,status_desc,
                CASE
                    WHEN to_char(d.scheduled_start_date,'YYYY-MM')=to_char(d.scheduled_completion_date,'YYYY-MM')
                    THEN concat(concat(to_char(d.scheduled_start_date,'DD'),' - '),TO_CHAR(d.scheduled_completion_date, 'dd MON yy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI'))
                    WHEN to_char(d.scheduled_start_date,'YYYY')=to_char(d.scheduled_completion_date,'YYYY') and to_char(d.scheduled_start_date,'MM')!=to_char(d.scheduled_completion_date,'MM')
                    THEN concat(concat(to_char(d.scheduled_start_date,'dd MON', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI'),' - '),TO_CHAR(d.scheduled_completion_date, 'dd MON yy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI'))
                    WHEN to_char(d.scheduled_start_date,'YYYY')!=to_char(d.scheduled_completion_date,'YYYY')
                    THEN concat(concat(to_char(d.scheduled_start_date,'dd MON yy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI'),' - '),TO_CHAR(d.scheduled_completion_date, 'dd MON yy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI'))
                END plan_str,
                a.department_desc,a.asset_number,a.description desc_a
            FROM PTEAM_PM_PLAN_HEADER h
            LEFT JOIN PTEAM_PM_PLAN_LINE d on h.plan_id=d.plan_id
            LEFT JOIN PTEAM_ASSET_NUMBER_V a on d.asset_number=a.asset_number
            WHERE h.year_plan='".$tyear."'".$owner.$response."
            AND d.plan_line_id is not null
            order by a.department_desc
            ";

        $h = "select count(*) c,to_char(hol_date,'IW')+0 w from PNMGR.PN_HOLIDAY h
        where h.hol_date between to_date('" . $syear . "-10-01','YYYY-MM-DD') and to_date('" . $year . "-09-30','YYYY-MM-DD')
        GROUP BY to_char(h.hol_date,'IW')";

        $u="select name from ptw_users where user_id=".$request->user;
 
        $data = DB::table(DB::raw("({$sql}) a"))->get();
        $hol = DB::select($h);
        $user = DB::select($u);
        $date = $this->DateThai(date("Y-m-d"),"f");

        $html = view('eam.report.emp0003.index', compact('m', 'data', 'hol', 'programCode', 'progTitle', 'tyear', 'y', 'user', 'date'))->render();
        $file = "รายงานแผนงานการบำรุงรักษาเครื่องจักร_(".$date.").xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $html;

        // return view('eam.report.emp0003.index', compact('m', 'data', 'hol', 'programCode', 'progTitle', 'tyear', 'y','user','date'));
         
    }
}
