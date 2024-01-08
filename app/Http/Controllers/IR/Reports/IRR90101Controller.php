<?php

namespace  App\Http\Controllers\IR\Reports;

//----------------------------------------------
//FILE NAME:  IRR90101Controller.php gen for Servit Framework Service
//Created by: Tlen<limweb@hotmail.com>
//DATE: 2022-02-05(Sat)  23:33:00
//----------------------------------------------
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IRR90101Controller
{

    public function export($programCode, $request)
    {
        // dd('IRR90101ControllerService',$programCode, $request);
        DB::enableQueryLog();
        $start_date                         = isset($request['start_date']) ? $request['start_date'] : null; //เดือน ตั้งแต่ start_date   "start_date" => "01/01/2022 00:00:00"
        $end_date                           = isset($request['end_date']) ? $request['end_date'] : null; //เดือน ถึง end_date   "end_date" => "01/01/2022 00:00:00"
        $groupname = '';
        $companyname = '';
        $varrefundtype = '';
        $smonth = '';
        $syear = '';
        $emonth = '';
        $eyear = '';
        $thaishortmonths = ['01' => 'ม.ค.', '02' => 'ก.พ.', '03' => 'มี.ค.', '04' => 'เม.ย.', '05' => 'พ.ค.', '06' => 'มิ.ย.', '07' => 'ก.ค.', '08' => 'ส.ค.', '09' => 'ก.ย.', '10' => 'ต.ค.', '11' => 'พ.ย.', '12' => 'ธ.ค.',];
        $vt = ['Y' => 'ภาษีขอคืนได้', 'N' => 'ภาษีขอคืนไม่ได้'];
        $renewtype = '';
        $displayRenewType = '';
        $monthtitle = '';
        $refundType = 'ภาษีขอคืนได้';
        if ($start_date && $end_date) {
            list($_, $smonth, $syear)             = explode('/', explode(' ', $start_date)[0]);
            list($_, $emonth, $eyear)             = explode('/', explode(' ', $end_date)[0]);
            $START_DATE_FROM                    = $smonth;
            $START_YEAR_FROM                    = $syear;
            $START_DATE_TO                      = $emonth;
            $START_YEAR_TO                      = $eyear;

            $monthtitle =  $thaishortmonths[$smonth] . ' ' . ($syear + 543) . ' ถึงเดือน ' . $thaishortmonths[$emonth] . ' ' . ($eyear + 543);
        }

        $GROUP_CODE                         = isset($request['group_code'])             ? $request['group_code']            : null; //กลุ่ม Group_code   "group_code" => "a"
        $DEPARTMENT_FROM                    = isset($request['department_code_start'])  ? $request['department_code_start'] : null; //หน่วยงานตั้งแต่ department_code   "department_code_start" => "b"
        $DEPARTMENT_TO                      = isset($request['department_code_end'])    ? $request['department_code_end']   : null; //หน่วยงานถึง department_code   "department_code_end" => "c"
        $COMPANY_ID                         = isset($request['company_id'])             ? $request['company_id']            : null; //บริษัทประกันภัย company_id   "company_id" => "d"
        $VAT_REFUND                         = isset($request['vat_refund'])             ? $request['vat_refund']            : null; //ประเภทภาษี ภาษีขอคืนได้/ภาษีขอคืนไม่  "vat_refund" => "e"
        $CAR_BRAND_CODE                     = isset($request['car_brand_code'])         ? $request['car_brand_code']        : null; //ยี่ห้อ car_brand_code   "car_brand_code" => "f"
        $CAR_TYPE_CODE                      = isset($request['car_type_code'])          ? $request['car_type_code']         : null; //ประเภทรถ car_type_code   "car_type_code" => "g"
        $LICENSE_PLATE                      = isset($request['license_plate'])          ? $request['license_plate']         : null; //เลขทะเบียน license_plate   "license_plate" => "i"
        $POLICY_NUMBER                      = isset($request['policy_number'])          ? $request['policy_number']         : null; //หมายเลขกรมธรรม์ POLICY_NUMBER   "policy_number" => "j"
        $RENEW_TYPE                         = isset($request['RENEW_TYPE'])             ? $request['RENEW_TYPE']            : null; //"RENEW_TYPE" => "ประกันชั้น 1"
        $PROGRAM_CODE                       = isset($request['program_code'])           ? $request['program_code']          : null; //"program_code" => "IR90101"
        // เดือน ตัวย่อ ไทย
        $thaimonth = [
            '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
        ];
        $user = Auth::user()->user_id;  // user id
        $nowDateTH = parseToDateTh(date('Y-m-d H:i:s'));
        // $sql="WITH CTE_DATA AS (
        //     SELECT DEPARTMENT_CODE,DEPARTMENT_NAME,GROUP_CODE,GROUP_NAME,COMPANY_ID,COMPANY_NAME,VAT_REFUND,CAR_TYPE_CODE,CAR_TYPE,LICENSE_PLATE,(
        //     SELECT PTIR_VEHICLES.TANK_NUMBER FROM PTIR_VEHICLES WHERE PTIR_VEHICLES.LICENSE_PLATE=PTIR_CARS.LICENSE_PLATE FETCH FIRST 1 ROWS ONLY) AS TANK_NUMBER,POLICY_NUMBER,TO_CHAR(START_DATE,'DD-MM-YYYY') || '-' || TO_CHAR(END_DATE,'DD-MM-YYYY') PERIOD_DATE,CAR_BRAND_CODE,CAR_BRAND,NVL(NET_AMOUNT,0) NET_AMOUNT,NVL(INSURANCE_AMOUNT,0) INSURANCE_AMOUNT,NVL(DUTY_AMOUNT,0) DUTY_AMOUNT,NVL(VAT_AMOUNT,0) VAT_AMOUNT,CASE WHEN VAT_REFUND='N' THEN NVL(INSURANCE_AMOUNT,0)+NVL(DUTY_AMOUNT,0)+NVL(VAT_AMOUNT,0) ELSE NVL(INSURANCE_AMOUNT,0)+NVL(DUTY_AMOUNT,0) END TOTAL15,NVL(DISCOUNT,0) DISCOUNT,CASE WHEN VAT_REFUND='N' THEN NVL(INSURANCE_AMOUNT,0)-NVL(DISCOUNT,0)+NVL(DUTY_AMOUNT,0)+NVL(VAT_AMOUNT,0) ELSE NVL(INSURANCE_AMOUNT,0)-NVL(DISCOUNT,0)+NVL(DUTY_AMOUNT,0) END TOTAL17 FROM PTIR_CARS
        // WHERE 1=1 and car_type_code > 1 ";
        $sql = "";
        $sql = "
            SELECT ROW_NUMBER () OVER (ORDER BY  GROUP_CODE ASC,
            COMPANY_ID ASC,
            VAT_REFUND ASC) AS ROW_NUM, DEPARTMENT_CODE,DEPARTMENT_NAME,GROUP_CODE,GROUP_NAME,COMPANY_ID,COMPANY_NAME,VAT_REFUND,CAR_TYPE_CODE,CAR_TYPE,LICENSE_PLATE,(
            SELECT PTIR_VEHICLES.TANK_NUMBER FROM PTIR_VEHICLES WHERE PTIR_VEHICLES.LICENSE_PLATE=PTIR_CARS.LICENSE_PLATE FETCH FIRST 1 ROWS ONLY) AS TANK_NUMBER,POLICY_NUMBER,TO_CHAR(START_DATE,'DD-MM-YYYY') || '-' || TO_CHAR(END_DATE,'DD-MM-YYYY') PERIOD_DATE,CAR_BRAND_CODE,CAR_BRAND,NVL(NET_AMOUNT,0) NET_AMOUNT,NVL(INSURANCE_AMOUNT,0) INSURANCE_AMOUNT,NVL(DUTY_AMOUNT,0) DUTY_AMOUNT,NVL(VAT_AMOUNT,0) VAT_AMOUNT,CASE WHEN VAT_REFUND='N' THEN NVL(INSURANCE_AMOUNT,0)+NVL(DUTY_AMOUNT,0)+NVL(VAT_AMOUNT,0) ELSE NVL(INSURANCE_AMOUNT,0)+NVL(DUTY_AMOUNT,0) END TOTAL15,NVL(DISCOUNT,0) DISCOUNT,CASE WHEN VAT_REFUND='N' THEN NVL(INSURANCE_AMOUNT,0)-NVL(DISCOUNT,0)+NVL(DUTY_AMOUNT,0)+NVL(VAT_AMOUNT,0) ELSE NVL(INSURANCE_AMOUNT,0)-NVL(DISCOUNT,0)+NVL(DUTY_AMOUNT,0) END TOTAL17 FROM PTIR_CARS
        WHERE 1=1 and car_type_code > 1 AND START_DATE IS NOT NULL";

        $params = [];
        if ($DEPARTMENT_FROM && $DEPARTMENT_TO) {
            // $sql .= '  AND DEPARTMENT_CODE = \'33000600\' ';
            // $sql .= '  AND DEPARTMENT_CODE = :DEPARTMENT_CODE ';
            $sql .= ' AND DEPARTMENT_CODE BETWEEN  :DEPARTMENT_FROM AND :DEPARTMENT_TO ';
            $params['DEPARTMENT_FROM'] = $DEPARTMENT_FROM;
            $params['DEPARTMENT_TO']   = $DEPARTMENT_TO;
        } elseif ($DEPARTMENT_FROM) {
            $sql .= '  AND DEPARTMENT_CODE = :DEPARTMENT_CODE ';
            $params['DEPARTMENT_CODE'] = $DEPARTMENT_FROM;
        } elseif ($DEPARTMENT_TO) {
            $sql .= '  AND DEPARTMENT_CODE = :DEPARTMENT_CODE ';
            $params['DEPARTMENT_CODE']   = $DEPARTMENT_TO;
        }

        if ($start_date && $end_date) {
            $sql .= '  AND EXTRACT(MONTH FROM START_DATE) BETWEEN :START_DATE_FROM AND :START_DATE_TO ';
            $sql .= '  AND EXTRACT(YEAR FROM START_DATE) BETWEEN  :START_YEAR_FROM AND :START_YEAR_TO ';
            $params['START_DATE_FROM'] = $START_DATE_FROM;
            $params['START_YEAR_FROM'] = $START_YEAR_FROM;
            $params['START_DATE_TO']   = $START_DATE_TO;
            $params['START_YEAR_TO']   = $START_YEAR_TO;
        }
        if ($GROUP_CODE) {
            $sql .= ' AND GROUP_CODE     = :GROUP_CODE ';
            $params['GROUP_CODE']      = $GROUP_CODE;
            $gc = DB::select('SELECT PTIR_CARS.GROUP_CODE,PTIR_CARS.GROUP_NAME FROM PTIR_CARS WHERE PTIR_CARS.GROUP_CODE=  ? GROUP BY PTIR_CARS.GROUP_CODE,PTIR_CARS.GROUP_NAME', [$GROUP_CODE]);
            $groupname = $gc[0]->group_name;
        }
        if($COMPANY_ID) {
            $cc= DB::SELECT('SELECT DISTINCT company_number value,company_name label FROM ptir_companies WHERE company_number= ? ', [$COMPANY_ID]);
            $companyname = $cc[0]->label;
        }
        if ($VAT_REFUND) {
            $sql .= ' AND VAT_REFUND     = :VAT_REFUND ';
            $params['VAT_REFUND']      = $VAT_REFUND;
            $varrefundtype = $vt[$VAT_REFUND];
            //   $varrefundtype=false;
        }
        if ($CAR_BRAND_CODE) {
            $sql .= ' AND CAR_BRAND_CODE = :CAR_BRAND_CODE ';
            $params['CAR_BRAND_CODE']  = $CAR_BRAND_CODE;
        }
        if ($CAR_TYPE_CODE) {
            $sql .= ' AND CAR_TYPE_CODE  = :CAR_TYPE_CODE ';
            $params['CAR_TYPE_CODE']   = $CAR_TYPE_CODE;
        }
        if ($LICENSE_PLATE) {
            $sql .= ' AND LICENSE_PLATE  = :LICENSE_PLATE ';
            $params['LICENSE_PLATE']   = $LICENSE_PLATE;
        }
        if ($POLICY_NUMBER) {
            $sql .= ' AND POLICY_NUMBER  = :POLICY_NUMBER ';
            $params['POLICY_NUMBER']   = $POLICY_NUMBER;
        }

        if ($RENEW_TYPE) {
            $sql .= ' AND RENEW_TYPE     = :RENEW_TYPE ';
            $params['RENEW_TYPE']      = $RENEW_TYPE;

            // $renewtype   = '('.$RENEW_TYPE.')';
            $displayRenewType = $RENEW_TYPE;
        }




        // $sql1 = $sql . " ),CTE_MAIN AS (
        //     SELECT ROW_NUMBER () OVER (ORDER BY GROUP_CODE ASC) AS ROW_NUM,DEPARTMENT_CODE,DEPARTMENT_NAME,GROUP_CODE,GROUP_NAME,COMPANY_ID,COMPANY_NAME,VAT_REFUND,CAR_TYPE_CODE,CAR_TYPE,TANK_NUMBER,LICENSE_PLATE,POLICY_NUMBER,PERIOD_DATE,CAR_BRAND_CODE,CAR_BRAND,SUM(NET_AMOUNT) NET_AMOUNT,SUM(INSURANCE_AMOUNT) INSURANCE_AMOUNT,SUM(DUTY_AMOUNT) DUTY_AMOUNT,SUM(VAT_AMOUNT) VAT_AMOUNT,SUM(TOTAL15) TOTAL15,SUM(DISCOUNT) DISCOUNT,SUM(TOTAL17) TOTAL17 FROM CTE_DATA GROUP BY GROUPING SETS ((),(DEPARTMENT_CODE,DEPARTMENT_NAME,GROUP_CODE,GROUP_NAME,COMPANY_ID,COMPANY_NAME,VAT_REFUND,CAR_TYPE_CODE,CAR_TYPE,TANK_NUMBER,LICENSE_PLATE,POLICY_NUMBER,PERIOD_DATE,CAR_BRAND_CODE,CAR_BRAND)) ORDER BY GROUPING (DEPARTMENT_CODE),DEPARTMENT_CODE,DEPARTMENT_NAME,GROUP_CODE,GROUP_NAME,COMPANY_ID,COMPANY_NAME,VAT_REFUND,CAR_TYPE_CODE,CAR_TYPE,LICENSE_PLATE,POLICY_NUMBER,PERIOD_DATE,CAR_BRAND_CODE,CAR_BRAND)
        //     SELECT*FROM CTE_MAIN ORDER BY GROUP_CODE ASC,COMPANY_ID ASC,VAT_REFUND ASC,ROW_NUM ";

        // $sql1 = $sql . " ),  SELECT*FROM CTE_MAIN ORDER BY GROUP_CODE ASC,COMPANY_ID ASC,VAT_REFUND ASC,ROW_NUM ";

        $datas = DB::select($sql, $params);
        $sql2 = "";
        $sql2 =  " WITH CTE_DATA AS (" . $sql . ")
        SELECT
                COUNT(*) AS COUNT,
                CAR_TYPE_CODE    ,
                CAR_TYPE
        FROM
                CTE_DATA
        GROUP BY
                CAR_TYPE_CODE,
                CAR_TYPE
        ORDER BY
                CAR_TYPE_CODE";
        $xx = DB::select($sql2, $params);
        // dd($datas,$xx);
        $ss = '';
        foreach ($xx as $row) {
            $ss .= 'กลุ่ม ' . $row->car_type_code . ': ' . ($row->car_type ?: 'ไม่ทราบประเภท') . ' ' . $row->count . 'คัน ';
        }
        // dd($datas,$xx,$ss);
        // $sql = DB::getQueryLog();
        // dd($sql,$datas);
        $data = compact(
            'datas',
            'user',
            'nowDateTH',
            'thaimonth',
            'thaishortmonths',
            'programCode',
            'ss',
            'vt',
            'groupname',
            'companyname',
            'varrefundtype',
            'monthtitle',
            'renewtype',
            'displayRenewType',
            'refundType'

        );
        $html = view('ir.reports.irr90101.irr90101', $data)->render();

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                __DIR__ . '/fonts',
            ]),
            'fontdata' => $fontData + [
                'thsarabun' => [
                    'R' => 'Sarabun-Regular.ttf',
                    // 'I' => 'Sarabun-Italic.ttf',
                    // 'B' => 'Sarabun-Bold.ttf',
                    // 'useOTL' => 0xFF,
                    // 'useKashida' => 75,
                ],
                // 'thsarabun' => [
                //     'R' => 'THSarabunNew.ttf',
                //     'I' => 'THSarabunNew Italic.ttf',
                //     'B' => 'THSarabunNew Bold.ttf',
                //     'useOTL' => 0xFF,
                //     'useKashida' => 75,
                // ],
                'cordia' => [
                    'R' => 'CORDIA.ttf',
                    'I' => 'cordiai.ttf',
                    'B' => 'Cordia New Bold.ttf',
                    // 'useOTL' => 0xFF,
                    // 'useKashida' => 75,
                ],
            ],
            'default_font' => 'thsarabun',
            'tempDir' => __DIR__ . '/tmp',
            'margin_left' => 10,
            'margin_right' => 15,
            'margin_top' => 30,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'format'            => 'A4-L',
            'mode'              => 'utf-8',
            'margin_footer' => 5
        ]);

        $mpdf->useDictionaryLBR = false;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($programCode . '.pdf', \Mpdf\Output\Destination::INLINE);
        exit();
    }
}
