<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OMR0037Controller extends Controller
{

    public function export($programCode, $request)
    {
        $progReport = ProgramInfo::where('program_code', $programCode)->first();
        $progTitle = $progReport->description;

        // dd($programCode,$request);
        $start_date = $request['start_date']; //"start_date" => "01/12/2021"
        $end_date = $request['end_date']; //"end_date" => "31/01/2022"
        $remark = $request['remark']; //"remark" => "หมายเหตุ"
        $function_name = $request['function_name']; //"function_name" => "OMR0037"
        $user = Auth::user()->user_id;  // user id
        // dd($user);
        $nowDateTH = parseToDateTh(date('Y-m-d H:i:s'));
        //------------SQL-----------------------------------------------
        DB::enableQueryLog();
        $sql = "SELECT
                    Product.ITEM_ID,
                    Product.ITEM_DESCRIPTION,
                    Product.PRODUCT_TYPE_CODE,
                    MainTable.YX11,
                    MainTable.YX12,
                    MainTable.YX13,
                    MainTable.YXX14,
                    MainTable.NX11,
                    MainTable.NX12,
                    MainTable.NX13,
                    MainTable.NXX14
                FROM
                    PTOM_SEQUENCE_ECOMS Product
                LEFT JOIN
                (
                    SELECT
                        ITEM_ID,
                        ITEM_DESCRIPTION,
                        ITEM_CODE,
                        PRODUCT_TYPE_CODE,
                        SUM(YX11) AS YX11,
                        SUM(YX12) AS YX12,
                        SUM(YX13) AS YX13,
                        ROUND(SUM(YX14), 2) AS YXX14,
                        SUM(NX11) AS NX11,
                        SUM(NX12) AS NX12,
                        SUM(NX13) AS NX13,
                        ROUND(SUM(NX14), 10) AS NXX14
                    FROM
                        (
                        SELECT
                            ORDER_HEADER_ID,
                            ITEM_ID,
                            ITEM_CODE,
                            ITEM_DESCRIPTION,
                            PRODUCT_TYPE_CODE,
                            PROMO,
                            PROGRAM_CODE,   
                            CASE
                                WHEN (PROMO = 'Y' OR PROGRAM_CODE = 'OMP0020') THEN X11
                                ELSE 0
                            END YX11,
                            CASE
                                WHEN (PROMO = 'Y' OR PROGRAM_CODE = 'OMP0020') THEN X12
                                ELSE 0
                            END YX12,
                            CASE
                                WHEN (PROMO = 'Y' OR PROGRAM_CODE = 'OMP0020') THEN X13
                                ELSE 0
                            END YX13,
                            CASE
                                WHEN (PROMO = 'Y' OR PROGRAM_CODE = 'OMP0020')
                                AND PRODUCT_TYPE_CODE = 10 THEN (X14 * CIGARETTE_DELIVERY_RATES)/ 10
                                WHEN (PROMO = 'Y' OR PROGRAM_CODE = 'OMP0020')
                                AND PRODUCT_TYPE_CODE = 20 THEN
                                    CASE
                                    WHEN UOM_CODE = 'CS1'
                                    OR UOM_CODE = 'PTN' THEN X14 * LEAF_DELIVERY_RATES
                                    WHEN UOM_CODE = 'CL1' THEN (X14 * LEAF_DELIVERY_RATES)/ 10
                                    ELSE 0
                                END
                                ELSE 0
                            END YX14,
                            CASE
                                WHEN (PROMO = 'N' AND (PROGRAM_CODE = 'OMP0003' OR PROGRAM_CODE = 'OMP0019')) THEN X11
                                ELSE 0
                            END NX11,
                            CASE
                                WHEN (PROMO = 'N' AND (PROGRAM_CODE = 'OMP0003' OR PROGRAM_CODE = 'OMP0019')) THEN X12
                                ELSE 0
                            END NX12,
                            CASE
                                WHEN (PROMO = 'N' AND (PROGRAM_CODE = 'OMP0003' OR PROGRAM_CODE = 'OMP0019')) THEN X13
                                ELSE 0
                            END NX13,
                            CASE
                                WHEN (PROMO = 'N' AND (PROGRAM_CODE = 'OMP0003' OR PROGRAM_CODE = 'OMP0019'))
                                AND PRODUCT_TYPE_CODE = 10 THEN (X14 * CIGARETTE_DELIVERY_RATES)/ 10
                                WHEN (PROMO = 'N' AND (PROGRAM_CODE = 'OMP0003' OR PROGRAM_CODE = 'OMP0019'))
                                AND PRODUCT_TYPE_CODE = 20 THEN
                                    CASE
                                    WHEN UOM_CODE = 'CS1'
                                    OR UOM_CODE = 'PTN' THEN X14 * LEAF_DELIVERY_RATES
                                    WHEN UOM_CODE = 'CL1' THEN (X14 * LEAF_DELIVERY_RATES)/ 10
                                    ELSE 0
                                END
                                ELSE 0
                            END NX14,
                            CIGARETTE_DELIVERY_RATES,
                            LEAF_DELIVERY_RATES,
                            RATEDATE
                        FROM
                            (
                            SELECT
                                ORDER_HEADER_ID,
                                ITEM_ID,
                                ITEM_CODE,
                                ITEM_DESCRIPTION,
                                PRODUCT_TYPE_CODE,
                                PROMO,
                                PROGRAM_CODE,
                                CASE
                                    WHEN PRODUCT_TYPE_CODE = 10 THEN ROUND(APPROVE_QUANTITY,2)
                                    WHEN PRODUCT_TYPE_CODE = 20 THEN 0
                                    ELSE 0
                                END AS X11,
                                CASE
                                    WHEN PRODUCT_TYPE_CODE = 10 THEN ROUND(APPROVE_CARDBOARDBOX,2)
                                    WHEN PRODUCT_TYPE_CODE = 20 THEN 
                                        CASE
                                        WHEN UOM_CODE = 'CS1' THEN ROUND(APPROVE_QUANTITY,2)
                                        WHEN UOM_CODE = 'PTN' THEN ROUND(APPROVE_QUANTITY / (
                                        SELECT
                                            CONVERSION_RATE
                                        FROM
                                            PTOM_UOM_CONVERSIONS_V
                                        WHERE
                                            UOM_CODE = 'CS1'),2)
                                        ELSE 0
                                    END
                                    ELSE 0
                                END AS X12,
                                CASE
                                    WHEN PRODUCT_TYPE_CODE = 10 THEN ROUND(APPROVE_CARTON,2)
                                    WHEN PRODUCT_TYPE_CODE = 20 THEN 
                                        CASE
                                        WHEN UOM_CODE = 'CL1' THEN ROUND(APPROVE_QUANTITY,2)
                                        ELSE 0
                                    END
                                    ELSE 0
                                END AS X13,
                                CASE
                                    WHEN PRODUCT_TYPE_CODE = 10 THEN ROUND(APPROVE_QUANTITY,2)
                                    WHEN PRODUCT_TYPE_CODE = 20 THEN
                                        CASE
                                        WHEN UOM_CODE = 'CS1' THEN ROUND(APPROVE_QUANTITY,2)
                                        WHEN UOM_CODE = 'PTN' THEN ROUND(APPROVE_QUANTITY / (
                                        SELECT
                                            CONVERSION_RATE
                                        FROM
                                            PTOM_UOM_CONVERSIONS_V
                                        WHERE
                                            UOM_CODE = 'CS1'),2)
                                        WHEN UOM_CODE = 'CL1' THEN ROUND(APPROVE_QUANTITY,2)
                                        ELSE 0
                                    END
                                    ELSE 0
                                END AS X14,
                                APPROVE_CARDBOARDBOX,
                                APPROVE_CARTON,
                                ratedate,
                                UOM_CODE,
                                (
                                SELECT
                                    PTOM_DELIVERY_RATES.CIGARETTE_DELIVERY_RATES
                                FROM
                                    PTOM_DELIVERY_RATES
                                WHERE
                                    1 = 1
                                    AND TRUNC(ratedate) BETWEEN PTOM_DELIVERY_RATES.RATE_START_DATE AND PTOM_DELIVERY_RATES.RATE_END_DATE
                                    OR PTOM_DELIVERY_RATES.RATE_END_DATE IS NULL
                                ORDER BY
                                    PTOM_DELIVERY_RATES.RATE_START_DATE ASC FETCH FIRST 1 ROWS ONLY) AS CIGARETTE_DELIVERY_RATES,
                                (
                                SELECT
                                    PTOM_DELIVERY_RATES.LEAF_DELIVERY_RATES
                                FROM
                                    PTOM_DELIVERY_RATES
                                WHERE
                                    1 = 1
                                    AND TRUNC(ratedate) BETWEEN PTOM_DELIVERY_RATES.RATE_START_DATE AND PTOM_DELIVERY_RATES.RATE_END_DATE
                                    OR PTOM_DELIVERY_RATES.RATE_END_DATE IS NULL
                                ORDER BY
                                    PTOM_DELIVERY_RATES.RATE_START_DATE ASC FETCH FIRST 1 ROWS ONLY) AS LEAF_DELIVERY_RATES
                            FROM
                                (
                                SELECT
                                    PH.ORDER_HEADER_ID,
                                    PO.ITEM_ID,
                                    PSE.ITEM_DESCRIPTION,
                                    PO.ITEM_CODE,
                                    PO.PROGRAM_CODE,
                                    PH.PRODUCT_TYPE_CODE,
                                    PO.APPROVE_QUANTITY,
                                    PO.APPROVE_CARDBOARDBOX,
                                    PO.APPROVE_CARTON,
                                    CASE
                                        WHEN PO.PROMO_FLAG = 'Y' THEN 'Y'
                                        ELSE 'N'
                                    END AS PROMO,
                                    PH.PICK_RELEASE_APPROVE_DATE AS ratedate,
                                    PO.UOM_CODE
                                FROM
                                    PTOM_ORDER_HEADERS PH
                                JOIN 
                                    PTOM_ORDER_LINES PO
                                ON
                                    PH.ORDER_HEADER_ID = PO.ORDER_HEADER_ID
                                JOIN
                                    PTOM_SEQUENCE_ECOMS PSE
                                ON
                                    PO.ITEM_ID = PSE.ITEM_ID
                                WHERE
                                    PH.PICK_RELEASE_STATUS = 'Confirm'
                                    AND PH.TRANSPORT_TYPE_CODE = '20'
                                    AND trunc(PH.PICK_RELEASE_APPROVE_DATE) BETWEEN TO_DATE('$start_date', 'DD/MM/YYYY') AND TO_DATE('$end_date', 'DD/MM/YYYY')
                                    AND (PH.ATTRIBUTE2 IS NULL OR PH.ATTRIBUTE2 = 'N'))))
                    WHERE
                        1 = 1
                    GROUP BY
                        ITEM_ID,
                        ITEM_CODE,
                        ITEM_DESCRIPTION,
                        PRODUCT_TYPE_CODE
                    ORDER BY
                        PRODUCT_TYPE_CODE ASC,
                        ITEM_ID ASC) MainTable
                ON
                    Product.ITEM_CODE = MainTable.ITEM_CODE
                WHERE
                    TO_DATE('$start_date', 'DD/MM/YYYY') >= START_DATE
                    AND ((TO_DATE('$end_date', 'DD/MM/YYYY') <= END_DATE) OR (END_DATE IS NULL))
                    AND SCREEN_NUMBER <> 0
                    AND SALE_TYPE_CODE = 'DOMESTIC'
                ORDER BY
                    Product.SUB_ACCOUNT_CODE ASC,
                    Product.SCREEN_NUMBER ASC";
        //print_r($sql);
        //exit;
        $datas = DB::select($sql);
        // dump($datas);
        // $datas = DB::select($sql,[]);
        // dd($datas,DB::getQueryLog());
        if (count($datas) == 0) {
            echo 'NO DATA';
            exit();
        }
        $data = compact(
            'start_date',
            'end_date',
            'remark',
            'programCode',
            'progTitle',
            'user',
            'nowDateTH',
            'datas'
        );
        $html = view('om.reports.omr0037.index', $data)->render();
        // echo $html; exit();
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'),
            ]),
            'fontdata' => $fontData + [
                'thsarabun' => [
                    'R' => 'THSarabunNew.ttf',
                ]
            ],
            'default_font' => 'thsarabun',
            'tempDir' => __DIR__ . '/tmp',
            'margin_left' => 10,
            'margin_right' => 15,
            'margin_top' => 40,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'format'            => 'A4-L',
            'mode'              => 'utf-8',
            'margin_footer' => 10
        ]);
        $mpdf->useDictionaryLBR = false;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($programCode.'.pdf', \Mpdf\Output\Destination::INLINE);
        exit();
    }
}