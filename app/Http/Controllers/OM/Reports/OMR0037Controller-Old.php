<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OMR0037Controller extends Controller
{

    public function export($programCode, $request)
    {
        // dd($programCode,$request);
            $start_date = $request['start_date']; //"start_date" => "01/12/2021"
            $end_date = $request['end_date']; //"end_date" => "31/01/2022"
            $remark = $request['remark']; //"remark" => "หมายเหตุ"
            $program_code = $request['program_code']; //"program_code" => "OMR0037"
            $function_name = $request['function_name']; //"function_name" => "OMR0037"
            $user = Auth::user()->user_id;  // user id
            // dd($user);
            $nowDateTH = parseToDateTh(date('Y-m-d H:i:s'));
        //------------SQL-----------------------------------------------
        DB::enableQueryLog();
        $sql ="SELECT ITEM_ID,ITEM_DESCRIPTION,PRODUCT_TYPE_CODE,SUM(YX11) AS YX11,SUM(YX12) AS YX12,SUM(YX13) AS YX13,
        -- RATEDATE,
        -- SUM(YX14) AS YxX14X,
        SUM(YX14*RATEX) AS YxX14,
        -- RATEX,
        SUM(NX11) AS NX11,SUM(NX12) AS NX12,SUM(NX13) AS NX13,SUM(NX14*RATEX) AS NXX14 FROM (
        SELECT ORDER_HEADER_ID,ITEM_ID,ITEM_DESCRIPTION,PRODUCT_TYPE_CODE,PROMO,CASE WHEN PRODUCT_TYPE_CODE=10 THEN CIGARETTE_DELIVERY_RATES WHEN PRODUCT_TYPE_CODE=20 THEN LEAF_DELIVERY_RATES ELSE 0 END AS RATEX,CASE WHEN PROMO='Y' THEN X11 ELSE 0 END YX11,CASE WHEN PROMO='Y' THEN X12 ELSE 0 END YX12,CASE WHEN PROMO='Y' THEN X13 ELSE 0 END YX13,CASE WHEN PROMO='Y' THEN X14 ELSE 0 END YX14,CASE WHEN PROMO='N' THEN X11 ELSE 0 END NX11,CASE WHEN PROMO='N' THEN X12 ELSE 0 END NX12,CASE WHEN PROMO='N' THEN X13 ELSE 0 END NX13,CASE WHEN PROMO='N' THEN X14 ELSE 0 END NX14,CIGARETTE_DELIVERY_RATES,LEAF_DELIVERY_RATES,RATEDATE FROM (
        SELECT ORDER_HEADER_ID,ITEM_ID,ITEM_DESCRIPTION,PRODUCT_TYPE_CODE,CONSIGNMENT_QUANTITY,PROMO,CASE WHEN (ORDER_HEADER_ID IS NOT NULL AND CONSIGNMENT_QUANTITY IS NOT NULL) THEN CONSIGNMENT_QUANTITY ELSE APPROVE_QUANTITY END AS X11,CASE WHEN (ORDER_HEADER_ID IS NOT NULL AND CONSIGNMENT_QUANTITY IS NOT NULL) THEN FLOOR(CONSIGNMENT_QUANTITY/10) ELSE APPROVE_CARDBOARDBOX END AS X12,CASE WHEN (ORDER_HEADER_ID IS NOT NULL AND CONSIGNMENT_QUANTITY IS NOT NULL) THEN MOD(CONSIGNMENT_QUANTITY,10)*5 ELSE CASE WHEN APPROVE_CARTON IS NOT NULL THEN APPROVE_CARTON ELSE 0 END END AS X13,CASE WHEN ORDER_HEADER_ID IS NOT NULL AND CONSIGNMENT_QUANTITY IS NOT NULL THEN CONSIGNMENT_QUANTITY/10 ELSE approve_quantity/10 END AS X14,APPROVE_CARDBOARDBOX,APPROVE_CARTON,ratedate,(
        SELECT PTOM_DELIVERY_RATES.CIGARETTE_DELIVERY_RATES FROM PTOM_DELIVERY_RATES WHERE 1=1 AND ratedate BETWEEN PTOM_DELIVERY_RATES.RATE_START_DATE AND PTOM_DELIVERY_RATES.RATE_END_DATE OR PTOM_DELIVERY_RATES.RATE_END_DATE IS NULL ORDER BY PTOM_DELIVERY_RATES.RATE_START_DATE ASC FETCH FIRST 1 ROWS ONLY) AS CIGARETTE_DELIVERY_RATES,(
        SELECT PTOM_DELIVERY_RATES.LEAF_DELIVERY_RATES FROM PTOM_DELIVERY_RATES WHERE 1=1 AND ratedate BETWEEN PTOM_DELIVERY_RATES.RATE_START_DATE AND PTOM_DELIVERY_RATES.RATE_END_DATE OR PTOM_DELIVERY_RATES.RATE_END_DATE IS NULL ORDER BY PTOM_DELIVERY_RATES.RATE_START_DATE ASC FETCH FIRST 1 ROWS ONLY) AS LEAF_DELIVERY_RATES FROM (
        SELECT PTOM_SO_OUTSTANDING_V.ORDER_HEADER_ID,PTOM_SO_OUTSTANDING_V.ITEM_ID,PTOM_SO_OUTSTANDING_V.ITEM_DESCRIPTION,PTOM_SO_OUTSTANDING_V.PRODUCT_TYPE_CODE,PTOM_SO_OUTSTANDING_V.APPROVE_QUANTITY,PTOM_SO_OUTSTANDING_V.CONSIGNMENT_QUANTITY,PTOM_SO_OUTSTANDING_V.APPROVE_CARDBOARDBOX,PTOM_SO_OUTSTANDING_V.APPROVE_CARTON,CASE WHEN PTOM_SO_OUTSTANDING_V.PROMO_FLAG='Y' AND PTOM_SO_OUTSTANDING_V.CON_PROMO_FLAG='Y' THEN 'Y' ELSE 'N' END AS PROMO,
        -- PTOM_SO_OUTSTANDING_V.PROMO_FLAG,
        -- PTOM_SO_OUTSTANDING_V.ATTRIBUTE2
        CASE WHEN PTOM_SO_OUTSTANDING_V.CONSIGNMENT_DATE IS NOT NULL THEN PTOM_SO_OUTSTANDING_V.CONSIGNMENT_DATE ELSE PTOM_SO_OUTSTANDING_V.PICK_RELEASE_APPROVE_DATE END AS ratedate FROM PTOM_SO_OUTSTANDING_V)))
        WHERE 1 = 1
            AND RATEDATE BETWEEN TO_DATE(?,'DD/MM/YYYY') AND TO_DATE(?,'DD/MM/YYYY')
            -- AND PRODUCT_TYPE_CODE = 10
            -- AND  PRODUCT_TYPE_CODE = 20
        GROUP BY ITEM_ID,ITEM_DESCRIPTION,PRODUCT_TYPE_CODE
        -- ,RATEX
        -- ,RATEDATE
        ORDER BY PRODUCT_TYPE_CODE ASC,ITEM_ID ASC";
        $datas = DB::select($sql,[$start_date,$end_date]);
        // $datas = DB::select($sql,[]);
        // dd($datas,DB::getQueryLog());
        if(count($datas) == 0 ){
            echo 'NO DATA';
            exit();
        }
        $data = compact(
            'start_date',
            'end_date',
            'remark',
            'program_code',
            'function_name',
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
                __DIR__ . '/fonts',
            ]),
            'fontdata' => $fontData + [
                'cordia' => [
                    'R' => 'CORDIA.ttf',
                    'I' => 'cordiai.ttf',
                    'B' => 'Cordia New Bold.ttf',
                ],
            ],
            'default_font' => 'cordia',
            'tempDir' => __DIR__ .'/tmp',
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