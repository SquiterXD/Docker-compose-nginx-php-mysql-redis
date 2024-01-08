<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OMR0072Controller extends Controller
{

    public function export($programCode, $request)
    {
        $view = $request['view']; //   "view" => "10"
        $year = $request['year']; //   "year" => "2022"
        $version = $request['version']; //   "version" => "1"
        $biweekly_start = $request['biweekly_start']; //   "biweekly_start" => "1"
        $biweekly_end = $request['biweekly_end']; //   "biweekly_end" => "2"
        $remark = $request['remark']; //   "remark" => "xxxx"
        $program_code = $request['program_code']; //   "program_code" => "OMR0072"
        $function_name = $request['function_name']; //   "function_name" => "OMR0072"
        $user = Auth::user()->user_id;  // user id
        $writer = new \XLSXWriter();
        switch ($view) {
            case '10':
                $this->genexcel($writer, 10, $year, $version, $biweekly_start, $biweekly_end, $remark, $program_code, $function_name, $user);
                break;
            case '20':
                $this->genexcel($writer, 20, $year, $version, $biweekly_start, $biweekly_end, $remark, $program_code, $function_name, $user);
                break;
            case '30':
                $this->genexcel($writer, 10, $year, $version, $biweekly_start, $biweekly_end, $remark, $program_code, $function_name, $user);
                $this->genexcel($writer, 20, $year, $version, $biweekly_start, $biweekly_end, $remark, $program_code, $function_name, $user);
                break;
            default:
                break;
        }
        $filename = $programCode . ".xlsx";
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->writeToStdOut();
        exit();
    }

    private function  genexcel(&$writer, $view, $year, $version, $biweekly_start, $biweekly_end, $remark, $program_code, $function_name, $user)
    {

        $sheetheader = ['@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@',];
        $nowDateTH = parseToDateTh(date('Y-m-d H:i:s'));
        $views = [10 => 'รายตราหลัก', 20 => 'รายตรารอง'];
        $sheet = $views[$view];
        $writer->writeSheetHeader($sheet, $sheetheader, $col_options = ['suppress_row' => true, 'widths' => [15, 15, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30,]]);
        //------------------------SQL ----------------------------
        DB::enableQueryLog();
        $sql1 = "SELECT
                    PTOM_SALES_FORECAST.BUDGET_YEAR,
                    PTOM_SALES_FORECAST.VERSION,
                    PTOM_SALES_FORECAST.BIWEEKLY_NO,
                    PTOM_BIWEEKLY_PERIODS.DAY_FOR_SALE,
                    PTOM_SEQUENCE_ECOMS.STAMP,
                    -- PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER,
                    TO_CHAR(PTOM_BIWEEKLY_PERIODS.START_DATE_PERIOD,'dd/mm/yyyy') DATE_START,
                    TO_CHAR(PTOM_BIWEEKLY_PERIODS.END_DATE_PERIOD,'dd/mm/yyyy') DATE_END
                FROM
                    PTOM_SALES_FORECAST
                    INNER JOIN
                    PTOM_BIWEEKLY_PERIODS
                    ON
                        PTOM_SALES_FORECAST.BIWEEKLY_ID = PTOM_BIWEEKLY_PERIODS.BIWEEKLY_ID
                    INNER JOIN
                    PTOM_SEQUENCE_ECOMS
                    ON
                        PTOM_SALES_FORECAST.ITEM_ID = PTOM_SEQUENCE_ECOMS.ITEM_ID
                        AND PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER <> 0
                        AND PTOM_SEQUENCE_ECOMS.SALE_TYPE_CODE = 'DOMESTIC'

                WHERE
                    1 = 1 AND
                    PTOM_SALES_FORECAST.SALES_CLASS_TYPE = 'DOMESTIC' AND
                    PTOM_SALES_FORECAST.BUDGET_YEAR = ? AND
                    PTOM_SALES_FORECAST.VERSION = ? AND
                    PTOM_SEQUENCE_ECOMS.STAMP = ? AND
                    PTOM_BIWEEKLY_PERIODS.BIWEEKLY_NO BETWEEN ? AND ?
                GROUP BY
                    PTOM_SALES_FORECAST.BIWEEKLY_NO,
                    PTOM_BIWEEKLY_PERIODS.DAY_FOR_SALE,
                    PTOM_SALES_FORECAST.BUDGET_YEAR,
                    PTOM_SEQUENCE_ECOMS.STAMP,
                    PTOM_SALES_FORECAST.VERSION,
                    PTOM_BIWEEKLY_PERIODS.START_DATE_PERIOD,
                    -- PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER,
                    PTOM_BIWEEKLY_PERIODS.END_DATE_PERIOD
                ORDER BY
                    -- PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER ASC,
                    PTOM_SALES_FORECAST.BUDGET_YEAR ASC,
                    PTOM_SALES_FORECAST.BIWEEKLY_NO ASC";
        $biweeklys = DB::select($sql1, [$year, $version, $view, $biweekly_start, $biweekly_end]);
        $chunk = count($biweeklys);
        if ($chunk == 0) {
            echo 'ไม่มีข้อมูล';
            exit();
        }
        $sdate = $biweeklys[0]->date_start;
        $edate = $biweeklys[$chunk - 1]->date_end;
        $sdate = parseToDateTh($sdate);
        $edate = parseToDateTh($edate);
        $sql2 = "SELECT
                    PTOM_SALES_FORECAST.ITEM_ID,
                    PTOM_SALES_FORECAST.ITEM_DESCRIPTION,
                -- 		PTOM_SALES_FORECAST.SALES_CLASS_TYPE,
                    PTOM_SEQUENCE_ECOMS.STAMP,
                -- 	PTOM_SALES_FORECAST.SALES_FORECAST_ID,
                -- 	PTOM_SALES_FORECAST.ORG_ID,
                    PTOM_SALES_FORECAST.BUDGET_YEAR,
                    PTOM_SALES_FORECAST.VERSION,
                    PTOM_BIWEEKLY_PERIODS.BIWEEKLY_NO,
                    PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER,
                -- 	PTOM_BIWEEKLY_PERIODS.DAY_FOR_SALE,
                -- 	PTOM_BIWEEKLY_PERIODS.START_DATE_PERIOD,
                -- 	PTOM_BIWEEKLY_PERIODS.END_DATE_PERIOD,
                -- 	PTOM_SALES_FORECAST.APPROVE_DATE,
                sum(PTOM_SALES_FORECAST.QUANTITY) SUM

                FROM
                    PTOM_SALES_FORECAST
                    INNER JOIN PTOM_BIWEEKLY_PERIODS ON PTOM_SALES_FORECAST.BIWEEKLY_ID = PTOM_BIWEEKLY_PERIODS.BIWEEKLY_ID
                    INNER JOIN PTOM_SEQUENCE_ECOMS ON
                        PTOM_SALES_FORECAST.ITEM_ID = PTOM_SEQUENCE_ECOMS.ITEM_ID
                        AND PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER <> 0
                        AND PTOM_SEQUENCE_ECOMS.SALE_TYPE_CODE = 'DOMESTIC'
                WHERE 1=1
                and PTOM_SALES_FORECAST.SALES_CLASS_TYPE = 'DOMESTIC'
                and PTOM_SEQUENCE_ECOMS.STAMP = ?
                and PTOM_SALES_FORECAST.BUDGET_YEAR = ?
                and PTOM_SALES_FORECAST.VERSION = ?
                and PTOM_BIWEEKLY_PERIODS.BIWEEKLY_NO BETWEEN  ? and  ?

                GROUP BY
                    PTOM_SALES_FORECAST.ITEM_DESCRIPTION,
                -- 	PTOM_SALES_FORECAST.SALES_CLASS_TYPE,
                    PTOM_SEQUENCE_ECOMS.STAMP,
                -- 	PTOM_SALES_FORECAST.SALES_FORECAST_ID,
                -- 	PTOM_SALES_FORECAST.ORG_ID,
                    PTOM_SALES_FORECAST.BUDGET_YEAR,
                    PTOM_SALES_FORECAST.VERSION,
                    PTOM_BIWEEKLY_PERIODS.BIWEEKLY_NO,
                    PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER,
                -- 	PTOM_BIWEEKLY_PERIODS.DAY_FOR_SALE,
                -- 	PTOM_BIWEEKLY_PERIODS.START_DATE_PERIOD,
                -- 	PTOM_BIWEEKLY_PERIODS.END_DATE_PERIOD,
                -- 	PTOM_SALES_FORECAST.APPROVE_DATE
                    PTOM_SALES_FORECAST.ITEM_ID

                ORDER BY
                PTOM_SEQUENCE_ECOMS.SCREEN_NUMBER ASC,
                PTOM_SALES_FORECAST.ITEM_ID asc ,
                PTOM_BIWEEKLY_PERIODS.BIWEEKLY_NO asc";
        $aa = DB::select($sql2, [$view, $year, $version, $biweekly_start, $biweekly_end]);
        $collection = collect($aa);
        $chunks = $collection->chunk($chunk);
        $datas  = $chunks->all();
        $sql3 = "SELECT
                    PTOM_SALES_FORECAST.APPROVE_DATE
                FROM
                    PTOM_SALES_FORECAST
                WHERE
                    1 = 1 AND
                    PTOM_SALES_FORECAST.APPROVE_FLAG = 'Y' and
                    PTOM_SALES_FORECAST.VERSION = ?
                GROUP BY
                    PTOM_SALES_FORECAST.APPROVE_DATE
                ORDER BY
                    PTOM_SALES_FORECAST.APPROVE_DATE DESC
                FETCH FIRST 1 ROWS ONLY";
        $appdate = DB::select($sql3, [$version]);
        $sql = DB::getQueryLog();
        // dd($biweeklys, $aa, $appdate, $sql);
        $date = '';
        $tdate = '';
        if (count($appdate) > 0) {
            $date = $appdate[0]->approve_date;
            $tdate = parseToDateTh($date);
        }
        //------------------------HEADER -------------------------
        $headers = array(
            [],
            [],
            ['', 'โปรแกรม :OMR0072', '', 'การยาสูบแห่งประเทศไทย', '', 'วันที่  :' . $nowDateTH],
            ['', 'สั่งพิมพ์  :' . $user, '', 'รายงานประมาณการจำหน่ายรายปักษ์ (' . $sheet . ')', '', 'เวลา  :' . date("H:i")],
            ['', '', '', 'ปักษ์ที่ : ' . $biweekly_start . ' - ' . $biweekly_end . ' (' . $sdate . ' - ' . $edate . ') ปีงบประมาณ ' . ($year + 543) . ' ครั้งที่ ' . $version, '',  'หน้า   : 1'],
            ['', '', '', '', '', 'หน่วย :' . 'บุหรี่(พันมวน)/ยาเส้น(หีบ)'],
            [],
        );

        $styles = array([], ['halign' => 'left'], ['halign' => 'left', 'valign' => 'center'], ['halign' => 'center', 'valign' => 'center'], ['halign' => 'right'], ['halign' => 'right'], ['halign' => 'right'], ['halign' => 'right'], ['halign' => 'right'], ['halign' => 'right'], ['halign' => 'right'], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], []);
        foreach ($headers as $header) {
            $writer->writeSheetRow($sheet, $header, $styles);
        }

        //------------------------HEADER TABLE -------------------
        $h1 = ['', '', ''];
        $h2 = ['', 'ลำดับ', 'ตรา'];
        $h3 = ['', '', ''];
        $sth1 = [
            [],
            ['halign' => 'center', 'valign' => 'center', 'height' => 20, 'border-style' => 'thin', 'border' => 'left,right,top', 'border-color' => '#000', 'fill' => '#fff',],
            ['halign' => 'center', 'valign' => 'center', 'height' => 20, 'border-style' => 'thin', 'border' => 'left,right,top', 'border-color' => '#000', 'fill' => '#fff',]
        ];
        $sth2 = [
            [],
            ['halign' => 'center', 'valign' => 'center', 'height' => 20, 'border-style' => 'thin', 'border' => 'left,right', 'border-color' => '#000', 'fill' => '#fff',],
            ['halign' => 'center', 'valign' => 'center', 'height' => 20, 'border-style' => 'thin', 'border' => 'left,right', 'border-color' => '#000', 'fill' => '#fff',]
        ];
        $sth3 = [
            [],
            ['halign' => 'center', 'valign' => 'center', 'height' => 20, 'border-style' => 'thin', 'border' => 'left,right,bottom', 'border-color' => '#000', 'fill' => '#fff',],
            ['halign' => 'center', 'valign' => 'center', 'height' => 20, 'border-style' => 'thin', 'border' => 'left,right,bottom', 'border-color' => '#000', 'fill' => '#fff',]
        ];
        foreach ($biweeklys as $key => $row) {
            $h1[] =  'ปักษ์ ' . $row->biweekly_no;
            $h2[] =  $row->day_for_sale . ' วัน';
            $h3[] =  '(' . parseToDateTh($row->date_start) . '-' . parseToDateTh($row->date_end) . ')';
            $sth1[] = ['halign' => 'center', 'border-style' => 'thin', 'border' => 'left,right,top', 'border-color' => '#000', 'fill' => '#fff'];
            $sth2[] = ['halign' => 'center', 'border-style' => 'thin', 'border' => 'left,right', 'border-color' => '#000', 'fill' => '#fff'];
            $sth3[] = ['halign' => 'center', 'border-style' => 'thin', 'border' => 'left,right,bottom', 'border-color' => '#000', 'fill' => '#fff'];
        }

        $h1[] = '';
        $h2[] = 'รวมประมาณการจำหน่าย';
        $h3[] = '';
        $sth1[] = ['halign' => 'center', 'valign' => 'center', 'border-style' => 'thin', 'border' => 'left,right,top', 'border-color' => '#000', 'fill' => '#fff'];
        $sth2[] = ['halign' => 'center', 'valign' => 'center', 'border-style' => 'thin', 'border' => 'left,right', 'border-color' => '#000', 'fill' => '#fff'];
        $sth3[] = ['halign' => 'center', 'valign' => 'center', 'border-style' => 'thin', 'border' => 'left,right,bottom', 'border-color' => '#000', 'fill' => '#fff'];
        $writer->writeSheetRow($sheet, []);
        $writer->writeSheetRow($sheet, $h1, $sth1);
        $writer->writeSheetRow($sheet, $h2, $sth2);
        $writer->writeSheetRow($sheet, $h3, $sth3);

        //-----------------  -----DATA ---------------------------
        $sumbiweeklys = [];
        $total = 0;
        // dd($datas);
        $rowsum = [];
        foreach ($datas as $key => $datarows) {  //row
            $cols = ['', $key + 1];
            $stcol = ['', ['halign' => 'left', 'border-style' => 'thin', 'border' => 'left,right', 'border-color' => '#000', 'fill' => '#fff'], ''];
            $colsum = 0;
            $chk = true;
            $j = 0;
            foreach ($datarows as $key1 => $datarow) { //col
                $j++;
                if ($chk) {
                    $cols[] = $datarow->item_description;
                }
                if (isset($rowsum[$j])) {
                    $rowsum[$j] += $datarow->sum;
                } else {
                    $rowsum[$j] = 0;
                    $rowsum[$j] += $datarow->sum;
                }
                $stcol[] = ['halign' => 'right', 'height' => 40, 'border' => 'left,right', 'border-color' => '#000', 'fill' => '#fff'];
                $chk = false;
                $cols[] = number_format($datarow->sum, 2);
                // $cols[] = $datarow->sum;
                $colsum += $datarow->sum;
            }
            $cols[] = number_format($colsum, 2);
            $stcol[] = ['halign' => 'right', 'border' => 'left,right', 'border-color' => '#000', 'fill' => '#fff'];
            $total += $colsum;
            // dump($cols);
            $writer->writeSheetRow($sheet, $cols, $stcol);
        }
        // exit();
        //----------------------- TOTAL --------------------------
        $sttotal = [[], ['halign' => 'center', 'border' => 'left,top,bottom', 'border-color' => '#000', 'fill' => '#fff'], ['halign' => 'center', 'border' => 'right,top,bottom', 'border-color' => '#000', 'fill' => '#fff']];
        foreach ($rowsum as &$rsum) {
            $rsum = number_format($rsum, 2);
            $sttotal[] = ['halign' => 'right', 'border' => 'left,right,top,bottom', 'border-color' => '#000', 'fill' => '#fff'];
        }
        $sttotal[] = ['halign' => 'right', 'border' => 'left,right,top,bottom', 'border-color' => '#000', 'fill' => '#fff'];
        $totalrow = array_merge(['', '', 'รวมยอด'], $rowsum, [number_format($total, 2)]);
        $writer->writeSheetRow($sheet, $totalrow, $sttotal);

        //---------------------------- Merge Cell -------------------------------------------------------
        // row จากหน้า excel ต้อง -1
        // col ต้องนับ จาก  0
        // $writer->markMergedCell($sheet, $start_row = 8, $start_col = 1, $end_row = 10, $end_col = 1);
        // $writer->markMergedCell($sheet, $start_row = 8, $start_col = 2, $end_row = 10, $end_col = 2);

        //----------------------- FOOTER -------------------------
        $writer->writeSheetRow($sheet, []);
        $writer->writeSheetRow($sheet, ['', 'วันที่อนุมัติ :', $tdate, []]);
        $writer->writeSheetRow($sheet, ['', 'หมายเหตุ :', $remark, []]);
    }
}
