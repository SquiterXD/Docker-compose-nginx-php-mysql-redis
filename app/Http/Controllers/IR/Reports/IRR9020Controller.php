<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use App\Models\IR\PtirExpenseCarGas;
use App\Models\IR\PtirCars;
use App\Models\IR\Views\PtirEffectiveDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use PDF;
use Carbon\Carbon;

class IRR9020Controller extends Controller
{
    public function export($programCode, $request)
    {
        $year = "";
        if (empty($request['year'])) {
            $request['year'] = date("Y");
        }

        $group_code = "";
        $renew_type_code = "";
        $renew_type = "";
        if (isset($request['insurance_type_code'])) {
            if (!empty($request['insurance_type_code'])) {
                $insurance_type = explode('-', $request['insurance_type_code']);
                $renew_type_code = $insurance_type[0];
                $renew_type = $insurance_type[1];
            }
        }

        $thYear = (int)$request['year'] + 543;
        $year = $request['year'];
        $department_from = $request['department_from'];
        $department_to = $request['department_to'];
        $user_id = Auth::user()->user_id;

        //Group Code
        $sqlGroup = "SELECT DISTINCT GROUP_CODE ,GROUP_NAME FROM OAIR.PTIR_CARS";
        if (isset($request['group_code'])) {
            $group_code = $request['group_code'];
            $sqlGroup .= " WHERE GROUP_CODE = '" . $group_code . "'";
        }
        $getGroupCodedepartment = DB::select(DB::raw($sqlGroup));

        $sql = "WITH CTE_DAYS  AS
        (
          SELECT TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR')) DAYS_IN_YEAR FROM DUAL
        )
        ,CTE_FISCAL_YEAR AS (
        SELECT   TO_DATE(SUBSTR(DESCRIPTION, 1, Instr(DESCRIPTION, '-', -1, 1) -1),'DD/MM/YYYY')  START_DATE,
          TO_DATE(SUBSTR(DESCRIPTION, Instr(DESCRIPTION, '-', -1, 1) +1),'DD/MM/YYYY') END_DATE
        FROM PTIR_EFFECTIVE_DATE WHERE LOOKUP_CODE = " . $year . " AND ENABLED_FLAG='Y'
        )
        ,CTE_DATA AS (
            SELECT
            A.GROUP_CODE GROUP_CODE,
	        A.GROUP_NAME GROUP_NAME,
            A.DEPARTMENT_CODE,
            A.DEPARTMENT_NAME LABEL2,
            B.VEHICLE_TYPE_CODE  ,
            B.VEHICLE_TYPE_NAME LABEL3,
            B.VEHICLE_BRAND_CODE   ,
            B.VEHICLE_BRAND_NAME LABEL4,
            TO_CHAR(A.START_DATE,'DD/MM/YYYY') || ' - '|| TO_CHAR(A.END_DATE,'DD/MM/YYYY') LABEL5,
            A.LICENSE_PLATE LABEL6,
            ROUND(NVL(A.INSURANCE_AMOUNT,0) - NVL(A.DISCOUNT,0) + NVL(A.DUTY_AMOUNT,0),2) INSURANCE_AMOUNT,
            NVL(A.NET_AMOUNT,0) NET_AMOUNT,
            A.VAT_REFUND
            FROM OAIR.PTIR_CARS A
            INNER JOIN OAIR.PTIR_FA_VEHICLES_V B ON A.LICENSE_PLATE=B.LICENSE_PLATE ";

        $w = 0;
        if (!empty($department_from) && !empty($department_to)) {
            $sql .= "WHERE A.DEPARTMENT_CODE BETWEEN '" . $department_from . "' AND '" . $department_to . "' ";
            $w++;
        } else if (!empty($department_from)) {
            $sql .= "WHERE A.DEPARTMENT_CODE BETWEEN '" . $department_from . "' AND '" . $department_from . "' ";
            $w++;
        } else if (!empty($department_to)) {
            $sql .= "WHERE A.DEPARTMENT_CODE BETWEEN '" . $department_to . "' AND '" . $department_to . "' ";
            $w++;
        }

        if ($w == 0 && !empty($vehicle_brand_code)) {
            $sql .= "WHERE B.VEHICLE_BRAND_CODE = '" . $vehicle_brand_code . "' ";
            $w++;
        } else if (!empty($vehicle_brand_code)) {
            $sql .= "AND B.VEHICLE_BRAND_CODE = '" . $vehicle_brand_code . "' ";
            $w++;
        }

        if ($w == 0 && !empty($group_code)) {
            $sql .= "WHERE A.GROUP_CODE= '" . $group_code . "' ";
            $w++;
        } else if (!empty($group_code)) {
            $sql .= "AND A.GROUP_CODE= '" . $group_code . "' ";
            $w++;
        }

        if ($w == 0 && !empty($renew_type_code) && !empty($renew_type)) {
            $sql .= "WHERE A.RENEW_TYPE_CODE= '" . $renew_type_code . "' AND A.RENEW_TYPE= '" . $renew_type . "' ";
            $w++;
        } else if (!empty($renew_type_code) && !empty($renew_type)) {
            $sql .= "AND A.RENEW_TYPE_CODE= '" . $renew_type_code . "' AND A.RENEW_TYPE= '" . $renew_type . "' ";
            $w++;
        }

        $sql .= " )
        ,CTE_MAIN AS (
            SELECT
            GROUP_CODE,
	        GROUP_NAME,
            LABEL2,
            LABEL3,
            LABEL4,
            LABEL5,
            LABEL6,
            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT ((TRUNC(LAST_DAY(START_DATE)) - TRUNC(START_DATE))+1) FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT ((TRUNC(LAST_DAY(START_DATE)) - TRUNC(START_DATE))+1) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL81,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,1)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,1))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL82,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,2)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,2))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL83,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,3)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,3))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL84,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,4)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,4))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL85,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,5)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,5))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL86,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,6)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,6))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL87,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,7)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,7))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL88,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,8)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,8))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL89,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,9)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,9))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL810,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,10)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,10))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL811,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT  EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,11)))  FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE,11))) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL812,

            CASE WHEN VAT_REFUND = 'Y' THEN INSURANCE_AMOUNT*(SELECT (TRUNC(END_DATE) - TRUNC(END_DATE, 'MM')) FROM CTE_FISCAL_YEAR) / (SELECT DAYS_IN_YEAR FROM CTE_DAYS)
            ELSE NET_AMOUNT*(SELECT (TRUNC(END_DATE) - TRUNC(END_DATE, 'MM')) FROM CTE_FISCAL_YEAR)/ (SELECT DAYS_IN_YEAR FROM CTE_DAYS) END LABEL813

            FROM CTE_DATA
         )
         SELECT
         GROUP_CODE,
	     GROUP_NAME,
         LABEL2,
         LABEL3,
         LABEL4,
         LABEL5,
         LABEL6,
         ROUND(LABEL81, 2)+ ROUND(LABEL82, 2)+ ROUND(LABEL83, 2)+ ROUND(LABEL84, 2)+ ROUND(LABEL85, 2)+ ROUND(LABEL86, 2)+ ROUND(LABEL87, 2)
     + ROUND(LABEL88, 2)+ ROUND(LABEL89, 2)+ ROUND(LABEL810, 2)+ ROUND(LABEL811, 2)+ ROUND(LABEL812, 2)+ ROUND(LABEL813, 2) LABEL7,
         ROUND(LABEL81, 2)LABEL81,
         ROUND(LABEL82, 2)LABEL82,
         ROUND(LABEL83, 2)LABEL83,
         ROUND(LABEL84, 2)LABEL84,
         ROUND(LABEL85, 2)LABEL85,
         ROUND(LABEL86, 2)LABEL86,
         ROUND(LABEL87, 2)LABEL87,
         ROUND(LABEL88, 2)LABEL88,
         ROUND(LABEL89, 2)LABEL89,
         ROUND(LABEL810, 2)LABEL810,
         ROUND(LABEL811, 2)LABEL811,
         ROUND(LABEL812, 2)LABEL812,
         ROUND(LABEL813, 2)LABEL813
     FROM
         CTE_MAIN
     ORDER BY
        GROUP_CODE,
         LABEL2,
         LABEL3";

        //print_r($sql);exit;

        $balanceQuery = DB::select(DB::raw($sql));

        $dataConllection = array();
        $dataConllection = json_decode(json_encode($getGroupCodedepartment), true);

        //CTE_FISCAL_YEAR
        $effectiveDateData = $this->getEffectiveDate($year);
        $start_date = $effectiveDateData->start_date_active;
        $end_date = $effectiveDateData->end_date_active;

        //CTE DAYS
        $getcteDay = $this->getCTEDAYS();
        $days_in_year = $getcteDay->days_in_year;


        $balanceDayFist  = $this->getBalanceDAY($start_date);

        $groupDatas = [];
        $maxLine = 20;
        $page = 0;
        $lineNum = 0;

        foreach ($dataConllection as $assetGroup => $groupDescriptions) {
            $group_code = "";
            $department = "";
            $vehicle = "";
            $department_num = 0;
            $vehicle_num = 0;
            $car_num = 0;

            $grouplist = json_decode(json_encode($groupDescriptions), true);

            if ($group_code != $grouplist['group_code']) {
                $lineNum = 0;
                $page++;
                $group_code = $groupDatas[$page][$assetGroup] = json_decode(json_encode($groupDescriptions), true);
            }

            foreach ($balanceQuery as $key => $lines) {

                $line = json_decode(json_encode($lines), true);
                if ($line['group_code'] == $grouplist['group_code']) {
                    if ($department != $line['label2'] || $key == 0) {
                        // if ($department != "") {
                        //     $lineNum = $lineNum + 2;
                        // }
                        $checkline = $maxLine - $lineNum;
                        if ($lineNum >= $maxLine || $checkline < 3) {
                            $lineNum = 0;
                            $page++;
                        }

                        if ($vehicle_num > 0) {
                            $department_num++;
                            $vehicle_num = 0;
                            $lineNum++;
                        } else {
                            $lineNum++;
                        }
                        $department = $line['label2'];
                        $groupDatas[$page][$assetGroup]['department'][$department_num]['department_name'] = $department;
                    }

                    if ($vehicle != $line['label3']) {
                        $checkline = $maxLine - $lineNum;
                        if ($lineNum >= $maxLine || $checkline < 3) {
                            $lineNum = 0;
                            $page++;
                        }

                        if ($car_num > 0) {
                            $vehicle_num++;
                            $car_num = 0;
                            $lineNum++;
                        }
                        $lineNum++;

                        $vehicle = $line['label3'];
                        $groupDatas[$page][$assetGroup]['department'][$department_num]['vehicle'][$vehicle_num]['vehicle_name'] = $vehicle;

                        if ($lineNum >= $maxLine) {
                            $lineNum = 0;
                            $page++;
                        }
                        $lineNum++;
                        $groupDatas[$page][$assetGroup]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num] = $line;
                        $car_num++;
                    } else {
                        if ($lineNum >= $maxLine) {
                            $lineNum = 0;
                            $page++;
                        }
                        $lineNum++;
                        $groupDatas[$page][$assetGroup]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num] = $line;
                        $car_num++;
                    }
                }
            }
        }
        // dd($groupDatas);
        $pageAll = $page;

        $pdf = PDF::loadView(
            'ir.reports.irr9020.main_page',
            compact(
                'year',
                'groupDatas',
                'thYear',
                'programCode',
                'user_id',
                'pageAll'
            )
        )
            ->setPaper('a4', 'landscape')
            ->setOption('margin-bottom', 0);

        return $pdf->stream($programCode . '.pdf');
    }

    public function getEffectiveDate($year)
    {
        $collection = PtirEffectiveDate::select(
            'lookup_code',
            'meaning',
            'description',
            DB::raw("to_char(start_date_active, 'dd/mm/yyyy') start_date_active,
                     to_char(add_months(start_date_active, 12), 'dd/mm/yyyy') end_date_active")
        )->where('lookup_code', $year)
            ->first();

        return $collection;
    }

    public function getCTEDAYS()
    {
        $collection = DB::table("DUAL")
            ->select(DB::raw("TO_NUMBER(ADD_MONTHS(TRUNC(SYSDATE,'YEAR'),12)-TRUNC(SYSDATE,'YEAR')) DAYS_IN_YEAR"))
            ->first();

        return $collection;
    }

    public function getBalanceDAY($start_date)
    {
        $sql = "SELECT LAST_DAY(TO_DATE( '" . $start_date . "', 'DD/MM/YYYY' )) - TRUNC(TO_DATE( '" . $start_date . "', 'DD/MM/YYYY' ))+ 1 \"BalanceDay\" FROM DUAL";
        $balanceQuery = DB::select(DB::raw($sql));
        $value = $balanceQuery[0];
        $balanceDay = $value ? $value->balanceday : 0;

        return $balanceDay;
    }

    public function getDateOfMonth($start_date, $month_number)
    {
        $date = Carbon::createFromFormat('d/m/Y', $start_date);
        $DateOfMonth = $date->month($month_number)->daysInMonth;

        return $DateOfMonth;
    }

    public function getBalanceEndDate($end_date)
    {
        $sql = "SELECT (TRUNC(TO_DATE('" . $end_date . "', 'DD/MM/YYYY'  )) - TRUNC(TO_DATE( '" . $end_date . "', 'DD/MM/YYYY' ), 'MM')) \"BalanceEndDate\" FROM DUAL";
        $BalanceEndDateQuery = DB::select(DB::raw($sql));
        $value = $BalanceEndDateQuery[0];
        $balanceDayEnd = $value ? $value->balanceenddate : 0;

        $date = Carbon::createFromFormat('d/m/Y', $end_date);

        $num = $date - $date;

        return $balanceDayEnd;
    }
}
