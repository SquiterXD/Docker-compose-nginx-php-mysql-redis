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

class IRR0005_2Controller extends Controller
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
        $start_date_from = "";
        $start_date_to = "";
        if (isset($request['start_date_from'])) {
            $start_date_from = Carbon::createFromFormat('Y-m-d', $request['start_date_from']."-01")->format('Y-m-d');
        }
        if (isset($request['start_date_to'])) {
            $start_date_to = Carbon::createFromFormat('Y-m-d', $request['start_date_to']."-01")->format('Y-m-d');
            $start_date_to = date('Y-m-t',strtotime($start_date_to));
        }

        $start_date_from_th = $this->getThaiString($start_date_from);
        $start_date_to_th = $this->getThaiString($start_date_to);

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
        ,CTE_DATA AS (
            SELECT
            A.GROUP_CODE GROUP_CODE,
	        A.GROUP_NAME GROUP_NAME,
            A.RENEW_TYPE_CODE RENEW_TYPE_CODE,
            A.RENEW_TYPE RENEW_TYPE,
            A.COMPANY_NAME COMPANY_NAME,
	        A.POLICY_NUMBER POLICY_NUMBER,
            A.START_DATE START_DATE,
	        A.END_DATE END_DATE,
            A.TOTAL_DAYS AS DATE_DIFFERENCE,
            A.DEPARTMENT_CODE,
            A.DEPARTMENT_NAME LABEL2,
            A.CAR_TYPE_CODE ,
            A.CAR_TYPE LABEL3,
            A.CAR_BRAND_CODE ,
            A.CAR_BRAND LABEL4,
            TO_CHAR(A.START_DATE,'dd/mm/yyyy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') || ' - '|| TO_CHAR(A.END_DATE,'dd/mm/yyyy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') LABEL5,
            A.LICENSE_PLATE LABEL6,
            A.INSURANCE_EXPENSE INSURANCE_EXPENSE,
            TRUNC(ROUND(MONTHS_BETWEEN(TRUNC(A.END_DATE-1,'mm'),TRUNC(A.START_DATE,'mm')))) + 1 AS MONTH_OF_PERIOD,
            NVL(A.NET_AMOUNT,0) NET_AMOUNT,
            A.VAT_REFUND,
            A.END_MONTH_28,
            A.END_MONTH_29,
            A.END_MONTH_30,
            A.END_MONTH_31
            FROM OAIR.PTIR_CARS A
            WHERE A.YEAR = '".$year."' AND A.receivable_name IS NULL ";

        $w = 0;

        if (!empty($start_date_from)) {
            $sql .= "AND A.START_DATE BETWEEN TO_DATE('" . $start_date_from . "', 'YYYY-MM-DD' ) AND TO_DATE('" . $start_date_to . "', 'YYYY-MM-DD' )";
            $w++;
        }

        // if (!empty($start_date_to)) {
        //     $sql .= "AND A.END_DATE <= TO_DATE('" . $start_date_to . "', 'YYYY-MM-DD' ) ";
        //     $w++;
        // }

        if (!empty($group_code)) {
            $sql .= "AND A.GROUP_CODE= '" . $group_code . "' ";
            $w++;
        }

        if (!empty($renew_type_code) && !empty($renew_type)) {
            $sql .= "AND A.RENEW_TYPE_CODE= '" . $renew_type_code . "' AND A.RENEW_TYPE= '" . $renew_type . "' ";
            $w++;
        }

        if (!empty($department_from) && !empty($department_to)) {
            $sql .= "AND A.DEPARTMENT_CODE BETWEEN '" . $department_from . "' AND '" . $department_to . "' ";
            $w++;
        } else if (!empty($department_from)) {
            $sql .= "AND A.DEPARTMENT_CODE BETWEEN '" . $department_from . "' AND '" . $department_from . "' ";
            $w++;
        } else if (!empty($department_to)) {
            $sql .= "AND A.DEPARTMENT_CODE BETWEEN '" . $department_to . "' AND '" . $department_to . "' ";
            $w++;
        }

        $sql .= "AND A.DOCUMENT_NUMBER IS NOT NULL ";
        $sql .= "AND A.STATUS != 'CANCELLED' ";

        $sql .= " )
        ,CTE_MAIN AS (
            SELECT
            GROUP_CODE,
	        GROUP_NAME,
            RENEW_TYPE,
            COMPANY_NAME,
	        POLICY_NUMBER,
            START_DATE,
	        END_DATE,
            DEPARTMENT_CODE,
            LABEL2,
            LABEL3,
            LABEL4,
            LABEL5,
            LABEL6,
            MONTH_OF_PERIOD,
            INSURANCE_EXPENSE,
            CASE
                WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN INSURANCE_EXPENSE
                WHEN MONTH_OF_PERIOD = 1 THEN INSURANCE_EXPENSE
                WHEN MONTH_OF_PERIOD > 1 THEN (CASE
                    WHEN VAT_REFUND = 'Y' THEN INSURANCE_EXPENSE * ((TRUNC(LAST_DAY(START_DATE)) - TRUNC(START_DATE))+ 1) / DATE_DIFFERENCE
                    ELSE NET_AMOUNT * ((TRUNC(LAST_DAY(START_DATE)) - TRUNC(START_DATE))+ 1)/ DATE_DIFFERENCE
                END)
                ELSE 0
	END LABEL81,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 2 THEN 0
		WHEN MONTH_OF_PERIOD > 2 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 1))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 1))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 1))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 1))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL82,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 3 THEN 0
		WHEN MONTH_OF_PERIOD > 3 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 2))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 2))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 2))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 2))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL83,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 4 THEN 0
		WHEN MONTH_OF_PERIOD > 4 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 3))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 3))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 3))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 3))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL84,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 5 THEN 0
		WHEN MONTH_OF_PERIOD > 5 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 4))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 4))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 4))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 4))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL85,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 6 THEN 0
		WHEN MONTH_OF_PERIOD > 6 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 5))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 5))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 5))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 5))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL86,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 7 THEN 0
		WHEN MONTH_OF_PERIOD > 7 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 6))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 6))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 6))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 6))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL87,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 8 THEN 0
		WHEN MONTH_OF_PERIOD > 8 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 7))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 7))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 7))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 7))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL88,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 9 THEN 0
		WHEN MONTH_OF_PERIOD > 9 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 8))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 8))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 8))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 8))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL89,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 10 THEN 0
		WHEN MONTH_OF_PERIOD > 10 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 9))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 9))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 9))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 9))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL810,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 11 THEN 0
		WHEN MONTH_OF_PERIOD > 11 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 10))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 10))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 10))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 10))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL811,
	CASE
		WHEN RENEW_TYPE = 'ค่าตรวจสภาพ' THEN 0
		WHEN MONTH_OF_PERIOD = 12 THEN 0
		WHEN MONTH_OF_PERIOD > 12 THEN (
		CASE
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 11))) = 28 THEN END_MONTH_28
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 11))) = 29 THEN END_MONTH_29
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 11))) = 30 THEN END_MONTH_30
			WHEN EXTRACT(DAY FROM LAST_DAY(ADD_MONTHS(START_DATE, 11))) = 31 THEN END_MONTH_31
			ELSE 0
		END)
		ELSE 0
	END LABEL812,
	CASE
		WHEN MONTH_OF_PERIOD >= 13 THEN 0
		ELSE 0
	END LABEL813
FROM
	CTE_DATA
         )
        SELECT
            GROUP_CODE,
            GROUP_NAME,
            RENEW_TYPE,
            COMPANY_NAME,
            POLICY_NUMBER,
            TO_CHAR(START_DATE, 'YYYY-MM') START_MONTH,
            TO_CHAR(START_DATE, 'YYYY-MM-DD') START_DATE,
            TO_CHAR(END_DATE, 'YYYY-MM-DD') END_DATE,
            DEPARTMENT_CODE,
            LABEL2,
            LABEL3,
            LABEL4,
            LABEL5,
            LABEL6,
            INSURANCE_EXPENSE,
            ROUND(LABEL81, 2)LABEL81,
            CASE WHEN MONTH_OF_PERIOD = 2 THEN INSURANCE_EXPENSE-ROUND(LABEL81, 2) ELSE ROUND(LABEL82, 2) END LABEL82,
            CASE WHEN MONTH_OF_PERIOD = 3 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)) ELSE ROUND(LABEL83, 2) END LABEL83,
            CASE WHEN MONTH_OF_PERIOD = 4 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)) ELSE ROUND(LABEL84, 2) END LABEL84,
            CASE WHEN MONTH_OF_PERIOD = 5 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)) ELSE ROUND(LABEL85, 2) END LABEL85,
            CASE WHEN MONTH_OF_PERIOD = 6 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)+ROUND(LABEL85, 2)) ELSE ROUND(LABEL86, 2) END LABEL86,
            CASE WHEN MONTH_OF_PERIOD = 7 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)+ROUND(LABEL85, 2)+ROUND(LABEL86, 2)) ELSE ROUND(LABEL87, 2) END LABEL87,
            CASE WHEN MONTH_OF_PERIOD = 8 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)+ROUND(LABEL85, 2)+ROUND(LABEL86, 2)+ROUND(LABEL87, 2)) ELSE ROUND(LABEL88, 2) END LABEL88,
            CASE WHEN MONTH_OF_PERIOD = 9 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)+ROUND(LABEL85, 2)+ROUND(LABEL86, 2)+ROUND(LABEL87, 2)+ROUND(LABEL88, 2)) ELSE ROUND(LABEL89, 2) END LABEL89,
            CASE WHEN MONTH_OF_PERIOD = 10 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)+ROUND(LABEL85, 2)+ROUND(LABEL86, 2)+ROUND(LABEL87, 2)+ROUND(LABEL88, 2)+ROUND(LABEL89, 2)) ELSE ROUND(LABEL810, 2) END LABEL810,
            CASE WHEN MONTH_OF_PERIOD = 11 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)+ROUND(LABEL85, 2)+ROUND(LABEL86, 2)+ROUND(LABEL87, 2)+ROUND(LABEL88, 2)+ROUND(LABEL89, 2)+ROUND(LABEL810, 2)) ELSE ROUND(LABEL811, 2) END LABEL811,
            CASE WHEN MONTH_OF_PERIOD = 12 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)+ROUND(LABEL85, 2)+ROUND(LABEL86, 2)+ROUND(LABEL87, 2)+ROUND(LABEL88, 2)+ROUND(LABEL89, 2)+ROUND(LABEL810, 2)+ROUND(LABEL811, 2)) ELSE ROUND(LABEL812, 2) END LABEL812,
            CASE WHEN MONTH_OF_PERIOD >= 13 THEN INSURANCE_EXPENSE-(ROUND(LABEL81, 2)+ROUND(LABEL82, 2)+ROUND(LABEL83, 2)+ROUND(LABEL84, 2)+ROUND(LABEL85, 2)+ROUND(LABEL86, 2)+ROUND(LABEL87, 2)+ROUND(LABEL88, 2)+ROUND(LABEL89, 2)+ROUND(LABEL810, 2)+ROUND(LABEL811, 2)+ROUND(LABEL812, 2)) ELSE ROUND(LABEL813, 2) END LABEL813
        FROM
            CTE_MAIN
        ORDER BY
            START_MONTH,
            GROUP_CODE,
            RENEW_TYPE,
            LABEL2,
            LABEL3,
            START_DATE";

        // print_r($sql);exit;

        $balanceQuery = DB::select(DB::raw($sql));

        $dataConllection = array();
        $dataConllection = json_decode(json_encode($getGroupCodedepartment), true);

        //CTE_FISCAL_YEAR
        // $effectiveDateData = $this->getEffectiveDate($year);
        // $start_date_from = $effectiveDateData->start_date_active;
        // $start_date_to = $effectiveDateData->end_date_active;

        //CTE DAYS
        $getcteDay = $this->getCTEDAYS();
        $days_in_year = $getcteDay->days_in_year;


        // $balanceDayFist  = $this->getBalanceDAY($start_date_from);

        $groupDatas = [];
        $month_list = [];
        $maxLine = 18;
        $page = 0;
        $lineNum = 0;

        $group_code = "";
        $department = "";
        $renew_type = "";
        $start_month = "";
        $start_month_tmp = "";
        $vehicle = "";
        $department_num = 0;
        $vehicle_num = 0;
        $car_num = 0;

        foreach ($balanceQuery as $key => $lines){
            $line = json_decode(json_encode($lines), true);
                // $start_month = Carbon::createFromFormat('Y-m-d', $line['start_date'])->format('Y-m');
                if($group_code == $line['group_code'] && $renew_type == $line['renew_type'] && $department != $line['label2'] && $start_month_tmp== $start_month){
                    $lineNum = $lineNum+2;
                    $groupDatas[$page]['line_count'] = $lineNum;
                    $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num-1]['department_end'] = 'department';
                    $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num-1]['vehicle_end'] = 'vehicle';
                }else if($group_code == $line['group_code'] && $renew_type == $line['renew_type'] && $department == $line['label2'] && $vehicle != $line['label3'] && $start_month_tmp== $start_month){
                    $lineNum++;
                    $groupDatas[$page]['line_count'] = $lineNum;
                    $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num-1]['vehicle_end'] = 'vehicle';
                }
                // if ($line['group_code'] == $group_code) {
                    if ($start_month != $line['start_month'] || $group_code != $line['group_code'] || $renew_type != $line['renew_type'] || $key == 0) {
                        if($lineNum>0){
                            $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num-1]['department_end'] = 'department';
                            $groupDatas[$page]['line_count'] = $lineNum;
                            $page++;
                        }
                        $renew_type = $line['renew_type'];
                        $group_code = $line['group_code'];
                        $group_name = $line['group_name'];
                        $start_month = $line['start_month'] ;

                        $start_date = Carbon::createFromFormat('Y-m-d', $line['start_date'])->format('Y-m-01');
                        $end_date = date('Y-m-t',strtotime($start_month.' +1 year'));

                        $month_start_th = $this->getMonthString($start_date);
                        $start_date_to_th = $this->getThaiString($start_date)." ถึง ".$this->getThaiString($end_date);

                        $month_list = $this->getMonth($line['start_date']);

                        $lineNum = 0;
                        $vehicle_num = 0;
                        $department_num = 0;
                        $car_num = 0;
                        $department = "";
                        $vehicle = "";

                        $groupDatas[$page]['group_code'] = $group_code;
                        $groupDatas[$page]['group_name'] = $group_name;
                        $groupDatas[$page]['month_list'] = $month_list;
                        $groupDatas[$page]['renew_type'] = $renew_type;
                        $groupDatas[$page]['month_start_th'] = $month_start_th;
                        $groupDatas[$page]['start_date_to_th'] = $start_date_to_th;
                        $start_month_tmp = $start_month;
                    }

                    if ($start_month_tmp!= $start_month) {
                        $groupDatas[$page]['line_count'] = $lineNum;
                        $page++;
                        $start_month_tmp = $start_month;
                        $lineNum = 0;
                        $vehicle_num = 0;
                        $department_num = 0;
                        $car_num = 0;
                        $department = "";
                        $vehicle = "";
                        $groupDatas[$page]['group_code'] = $group_code;
                        $groupDatas[$page]['group_name'] = $group_name;
                        $groupDatas[$page]['month_list'] = $month_list;
                        $groupDatas[$page]['renew_type'] = $renew_type;
                        $groupDatas[$page]['month_start_th'] = $month_start_th;
                        $groupDatas[$page]['start_date_to_th'] = $start_date_to_th;
                    }


                    if ($department != $line['label2'] || $key == 0) {
                        $checkline = $maxLine - $lineNum;
                        if ($lineNum >= $maxLine || $checkline < 3) {
                            $groupDatas[$page]['line_count'] = $lineNum;
                            $lineNum = 0;
                            $page++;
                            // $groupDatas[$page]['group_code'] = $group_code;
                            // $groupDatas[$page]['group_name'] = $group_name;
                            $groupDatas[$page]['month_list'] = $month_list;
                            // $groupDatas[$page]['renew_type'] = $renew_type;
                            $groupDatas[$page]['month_start_th'] = $month_start_th;
                            $groupDatas[$page]['start_date_to_th'] = $start_date_to_th;
                        }

                        if($department != $line['label2'] && $key > 0){
                            $department_num++;
                            $lineNum++;
                        }

                        if ($vehicle_num > 0) {
                            $vehicle_num = 0;
                            // $lineNum++;
                        } else {
                            // $lineNum++;
                        }
                        $department = $line['label2'];
                        $groupDatas[$page]['department'][$department_num]['department_name'] = $department;
                    }

                    if ($vehicle != $line['label3']) {
                        $checkline = $maxLine - $lineNum;
                        if ($lineNum >= $maxLine || $checkline < 3) {
                            $groupDatas[$page]['line_count'] = $lineNum;
                            $lineNum = 0;
                            $page++;
                            // $groupDatas[$page]['group_code'] = $group_code;
                            // $groupDatas[$page]['group_name'] = $group_name;
                            $groupDatas[$page]['month_list'] = $month_list;
                            // $groupDatas[$page]['renew_type'] = $renew_type;
                            $groupDatas[$page]['month_start_th'] = $month_start_th;
                            $groupDatas[$page]['start_date_to_th'] = $start_date_to_th;
                        }

                        if ($car_num > 0) {
                            $vehicle_num++;
                            $car_num = 0;
                            $lineNum++;
                        }
                        $lineNum++;

                        $vehicle = $line['label3'];
                        $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['vehicle_name'] = $vehicle;

                        if ($lineNum >= $maxLine) {
                            $groupDatas[$page]['line_count'] = $lineNum;
                            $lineNum = 0;
                            $page++;
                            // $groupDatas[$page]['group_code'] = $group_code;
                            // $groupDatas[$page]['group_name'] = $group_name;
                            $groupDatas[$page]['month_list'] = $month_list;
                            // $groupDatas[$page]['renew_type'] = $renew_type;
                            $groupDatas[$page]['month_start_th'] = $month_start_th;
                            $groupDatas[$page]['start_date_to_th'] = $start_date_to_th;
                        }
                        $lineNum++;
                        $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num] = $line;
                        $car_num++;
                    } else {
                        if ($lineNum >= $maxLine) {
                            $groupDatas[$page]['line_count'] = $lineNum;
                            $lineNum = 0;
                            $page++;
                            // $groupDatas[$page]['group_code'] = $group_code;
                            // $groupDatas[$page]['group_name'] = $group_name;
                            $groupDatas[$page]['month_list'] = $month_list;
                            // $groupDatas[$page]['renew_type'] = $renew_type;
                            $groupDatas[$page]['month_start_th'] = $month_start_th;
                            $groupDatas[$page]['start_date_to_th'] = $start_date_to_th;
                        }
                        $lineNum++;
                        $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num] = $line;
                        $car_num++;
                    }
                // }
                if(count($balanceQuery) == ($key+1)){
                    $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num-1]['department_end'] = 'department';
                    $groupDatas[$page]['department'][$department_num]['vehicle'][$vehicle_num]['cars'][$car_num-1]['vehicle_end'] = 'vehicle';
                }
        }
        $pageAll = $page+1;
        //  pr($groupDatas);exit;

        $pdf = PDF::loadView(
            'ir.reports.irr0005_2.main_page',
            compact(
                'year',
                'groupDatas',
                'thYear',
                'programCode',
                'user_id',
                'pageAll',
                'start_date_from_th',
                'start_date_to_th'
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

    public function getBalanceDAY($start_date_from)
    {
        $sql = "SELECT LAST_DAY(TO_DATE( '" . $start_date_from . "', 'DD/MM/YYYY' )) - TRUNC(TO_DATE( '" . $start_date_from . "', 'DD/MM/YYYY' ))+ 1 \"BalanceDay\" FROM DUAL";
        $balanceQuery = DB::select(DB::raw($sql));
        $value = $balanceQuery[0];
        $balanceDay = $value ? $value->balanceday : 0;

        return $balanceDay;
    }

    private function getThaiString($date)
    {
        $monthTH = array(
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        );
        $stringDate = explode('-', $date);
        $stDay = (int)$stringDate[2];
        $stMonth = $monthTH[(int)$stringDate[1] - 1];
        $stYear = (int)$stringDate[0] + 543;

        $result = $stDay . ' ' . $stMonth . ' ' . $stYear;

        return $result;
    }

    private function getMonthString($date)
    {
        $monthTH = array(
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        );
        $stringDate = explode('-', $date);
        $stMonth = $monthTH[(int)$stringDate[1] - 1];
        $stYear = (int)$stringDate[0] + 543;

        $result = $stMonth . ' ' . $stYear;

        return $result;
    }

    function getMonth($start_date_from)
    {
        $month_list = array();
        $strYear = date("Y",strtotime($start_date_from))+543;
        $strYearTH = substr($strYear,2);
        $strMonth= date("n",strtotime($start_date_from));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

        for($i=0; $i < 13; $i++){
            $month_num = $strMonth+$i;
            if($month_num > 12){
                $month_num = $month_num-12;
                $strYearTH = substr($strYear+1,2);
            }
            $strMonthThai=$strMonthCut[$month_num];
            $month_list[$i] = $strMonthThai." ".$strYearTH;
        }
        return $month_list;
    }
}
