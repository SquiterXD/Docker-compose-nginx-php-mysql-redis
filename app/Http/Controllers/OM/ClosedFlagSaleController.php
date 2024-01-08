<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\ARInterface;
use App\Models\OM\ConsignmentHeader;
use App\Models\OM\ConsignmentLines;
use App\Models\OM\CreditNote\MappingAccountModel;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\GLInterfaceModel;
use App\Models\OM\InvoiceHeaders;
use App\Models\OM\OrderHeaders;
use App\Models\OM\PaymentMatchInvoice;
use App\Models\OM\PtomInvoiceHeader;
use App\Models\OM\RMAModel;
use App\Models\OM\SaleConfirmation\InvoiceLines;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Budget\GLCombinationKFV;
use App\Models\OM\ARInvoiceReportTemp;
use App\Models\OM\PtomArDailyAccRptDescV;
use App\Models\OM\ARInterfacesReport;
use App\Models\HrOperatingUnits;
use App\Models\OM\TransactionTypeAllV;
use App\Models\OM\ARTranTypesV;
use App\Models\OM\GLInterfacesReport;

class ClosedFlagSaleController extends Controller
{
    protected $orgId;
    protected $orgName;
    protected $groupId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index($type)
    {
        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $dataDates = [];

        $case1_1 = DB::select("
            SELECT TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') PICK_EXCHANGE_DATE 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE PICK_RELEASE_APPROVE_DATE IS NOT NULL 
            AND CURRENCY = 'THB' 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM'
            AND (
                CLOSE_SALE_FLAG <> 'Y' 
                OR CLOSE_SALE_FLAG IS NULL
            ) 
            AND PICK_EXCHANGE_DATE IS NOT NULL 
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
            GROUP BY TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD')
        ");

        $case1_2 = DB::select("
            SELECT TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') PICK_EXCHANGE_DATE 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE PICK_RELEASE_APPROVE_DATE IS NOT NULL 
            AND CURRENCY <> 'THB' 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND (
                CLOSE_SALE_FLAG <> 'Y' 
                OR CLOSE_SALE_FLAG IS NULL
            ) 
            AND PICK_EXCHANGE_DATE IS NOT NULL
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
            GROUP BY TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD')
        ");

        // $case2 = DB::select("SELECT TO_CHAR(PTOM_CLAIM_HEADERS.RMA_DATE, 'YYYY-MM-DD') RMA_DATE FROM PTOM_CLAIM_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_CLAIM_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_CLAIM_HEADERS.RMA_DATE IS NOT NULL AND UPPER(PTOM_CLAIM_HEADERS.STATUS_RMA) = 'CONFIRM' AND (PTOM_CLAIM_HEADERS.CLOSE_SALE_FLAG <> 'Y' OR PTOM_CLAIM_HEADERS.CLOSE_SALE_FLAG IS NULL) AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' GROUP BY TO_CHAR(PTOM_CLAIM_HEADERS.RMA_DATE, 'YYYY-MM-DD')");

        $case3 = DB::select("
            SELECT TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') INVOICE_DATE 
            FROM PTOM_INVOICE_HEADERS 
            LEFT JOIN PTOM_CUSTOMERS 
            ON PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
            WHERE PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'CN_OTHER' 
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
            GROUP BY TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD')
        ");

        $case4 = DB::select("
            SELECT TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') INVOICE_DATE 
            FROM PTOM_INVOICE_HEADERS LEFT JOIN PTOM_CUSTOMERS 
            ON PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
            WHERE PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            )
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'DN'
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
            GROUP BY TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD')
        ");

        foreach ($case1_1 as $c11) {
            if (!in_array($c11->pick_exchange_date, $dataDates)) array_push($dataDates, $c11->pick_exchange_date);
        }

        foreach ($case1_2 as $c12) {
            if (!in_array($c12->pick_exchange_date, $dataDates)) array_push($dataDates, $c12->pick_exchange_date);
        }

        // foreach ($case2 as $c2) {
        //     if (!in_array($c2->rma_date, $dataDates)) array_push($dataDates, $c2->rma_date);
        // }

        foreach ($case3 as $c3) {
            if (!in_array($c3->invoice_date, $dataDates)) array_push($dataDates, $c3->invoice_date);
        }

        foreach ($case4 as $c4) {
            if (!in_array($c4->invoice_date, $dataDates)) array_push($dataDates, $c4->invoice_date);
        }

        if (!empty($dataDates)) sort($dataDates);

        return view('om.closedflag.export.index', compact('dataDates', 'type'));
    }

    public function release(Request $request)
    {
        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $date = explode('/', $request->date);
        $d = $date[0];
        $m = $date[1];
        $y = $date[2];
        $ymd = $y . '-' . $m . '-' . $d;

        $dataNumbers = [];

        $case1_1 = DB::select("
            SELECT PICK_RELEASE_NO 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE PICK_RELEASE_APPROVE_DATE IS NOT NULL 
            AND CURRENCY = 'THB' 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND (
                CLOSE_SALE_FLAG <> 'Y'
                OR CLOSE_SALE_FLAG IS NULL
            ) 
            AND TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd'
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
            GROUP BY PICK_RELEASE_NO
        ");

        $case1_2 = DB::select("
            SELECT PICK_RELEASE_NO 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE PICK_RELEASE_APPROVE_DATE IS NOT NULL 
            AND CURRENCY <> 'THB' 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND (
                CLOSE_SALE_FLAG <> 'Y'
                OR CLOSE_SALE_FLAG IS NULL
            ) 
            AND PICK_EXCHANGE_RATE IS NOT NULL 
            AND TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd'
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
            GROUP BY PICK_RELEASE_NO
        ");

        // $case2 = DB::select("SELECT CREDIT_NOTE_NUMBER FROM PTOM_CLAIM_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_CLAIM_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID WHERE PTOM_CLAIM_HEADERS.RMA_DATE IS NOT NULL AND UPPER(PTOM_CLAIM_HEADERS.STATUS_RMA) = 'CONFIRM' AND (PTOM_CLAIM_HEADERS.CLOSE_SALE_FLAG <> 'Y' OR PTOM_CLAIM_HEADERS.CLOSE_SALE_FLAG IS NULL) AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' AND TO_CHAR(PTOM_CLAIM_HEADERS.RMA_DATE, 'YYYY-MM-DD') = '$ymd' GROUP BY PTOM_CLAIM_HEADERS.CREDIT_NOTE_NUMBER");

        $case3 = DB::select("
            SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER 
            FROM PTOM_INVOICE_HEADERS 
            LEFT JOIN PTOM_CUSTOMERS 
            ON PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
            WHERE PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'CN_OTHER' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd'
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
            GROUP BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
        ");

        $case4 = DB::select("
            SELECT PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER 
            FROM PTOM_INVOICE_HEADERS 
            LEFT JOIN PTOM_CUSTOMERS 
            ON PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
            WHERE PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'DN' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd'
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            ) 
            GROUP BY PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
        ");

        foreach ($case1_1 as $case11) {
            if (!in_array($case11->pick_release_no, $dataNumbers)) array_push($dataNumbers, $case11->pick_release_no);
        }

        foreach ($case1_2 as $case12) {
            if (!in_array($case12->pick_release_no, $dataNumbers)) array_push($dataNumbers, $case12->pick_release_no);
        }

        // foreach ($case2 as $c2){
        //     if (!in_array($c2->credit_note_number, $dataNumbers)) array_push($dataNumbers, $c2->credit_note_number);
        // }

        foreach ($case3 as $case3) {
            if (!in_array($case3->invoice_headers_number, $dataNumbers)) array_push($dataNumbers, $case3->invoice_headers_number);
        }

        foreach ($case4 as $case4) {
            if (!in_array($case4->invoice_headers_number, $dataNumbers)) array_push($dataNumbers, $case4->invoice_headers_number);
        }

        if (!empty($dataNumbers)) sort($dataNumbers);

        return response()->json(['status' => 'success', 'dataNumbers' => json_decode(json_encode($dataNumbers))]);
    }

    public function reportExport(Request $request)
    {
        set_time_limit(0);

        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $date = explode('/', $request->date);
        $d = $date[0];
        $m = $date[1];
        $y = $date[2];
        $ymd = $y . '-' . $m . '-' . $d;
        $n = $request->number;

        // queryReportInvoiceExport
        $ProformaInvoiceHeaders = DB::select("
            SELECT * 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND (
                PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                AND CURRENCY = 'THB' 
                AND (
                    CLOSE_SALE_FLAG <> 'Y' 
                    OR CLOSE_SALE_FLAG IS NULL
                ) 
                OR (
                    PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                    AND CURRENCY <> 'THB' 
                    AND (
                        CLOSE_SALE_FLAG <> 'Y' 
                        OR CLOSE_SALE_FLAG IS NULL
                    ) 
                    AND PICK_EXCHANGE_RATE IS NOT NULL
                )
            ) 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND PICK_RELEASE_NO = nvl('$n', PICK_RELEASE_NO)
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // queryReportCreditNoteExport
        $CreditNote = DB::select("
            SELECT PTOM_INVOICE_HEADERS.* 
            FROM PTOM_INVOICE_HEADERS,
            PTOM_CUSTOMERS
            WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            AND PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'CN_OTHER' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = nvl('$n', PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER)
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // queryReportDebitNoteExport
        $DebitNote = DB::select("
            SELECT PTOM_INVOICE_HEADERS.* 
            FROM PTOM_INVOICE_HEADERS,
            PTOM_CUSTOMERS
            WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            AND PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y'
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'DN' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = nvl('$n', PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER)
            AND NOT EXISTS( SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // $glData = DB::select("
        //     SELECT 
        //         PROF.* 
        //     FROM 
        //         PTOM_PROFORMA_INVOICE_HEADERS PROF
        //     WHERE 1=1
        //     AND PROF.CURRENCY <> 'THB'
        //     AND PROF.PAYMENT_TYPE_CODE = '10'
        //     AND UPPER(PROF.PICK_RELEASE_STATUS) = 'CONFIRM' 
        //     AND TO_CHAR(PROF.PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd'
        //     AND PROF.PICK_RELEASE_NO = nvl('$n', PROF.PICK_RELEASE_NO)
        // ");

        $old_groups = self::getOldGroupId($ProformaInvoiceHeaders, $CreditNote, $DebitNote);

        foreach($old_groups as $old){

            $check_ar_interface_complete = \App\Models\OM\ARInterface::where('group_id', $old)
            ->where('interface_status', ['C', 'S'])
            ->first();

            if(!$check_ar_interface_complete){

                $delete_ar_report = ARInterfacesReport::where('group_id', $old)
                ->delete();

                $delete_report_temps = ARInvoiceReportTemp::where('group_id', $old)
                ->delete();

                $delete_gl_temps = GLInterfacesReport::where('group_id', $old)
                ->delete();
            }
        }

        $genIDG = self::genGroupId(collect(), collect(), collect());
        $webbatchno = $genIDG.'-'.uniqid();

        foreach ($ProformaInvoiceHeaders as $row => $header) {
            $this->updateARGroupId('PROFORMA', $header, $genIDG);
            $insertData = $this->CloseFlagInvoicesExport($genIDG, $header, $webbatchno, true);
            if ($insertData['status'] == 'error') {
                return response()->json([
                    'status' => 'error',
                    'msg' => $insertData['message']
                ]);
            }
        }
        
        foreach ($CreditNote as $row => $header) {
            $this->updateARGroupId('INVOICE', $header, $genIDG);
            $insertData = $this->CloseFlagCreditNoteExport($genIDG, $header, $webbatchno, true);
            if ($insertData['status'] == 'error') {
                return response()->json([
                    'status' => 'error',
                    'msg' => $insertData['message']
                ]);
            }
        }
        
        foreach ($DebitNote as $row => $header) {
            $this->updateARGroupId('INVOICE', $header, $genIDG);
            $insertData = $this->CloseFlagDebitNoteExport($genIDG, $header, $webbatchno, true);
            if ($insertData['status'] == 'error') {
                return response()->json([
                    'status' => 'error',
                    'msg' => $insertData['message']
                ]);
            }
        }

        \App\Repositories\OM\InterfaceRepo::interfaceARReport($webbatchno);

        // foreach ($glData as $row => $header) {
        //     $this->updateARGroupId('GL', $header, $genIDG);
        //     $insertData = $this->insertGLExport($genIDG, $header, $webbatchno, true);
        //     if ($insertData['status'] == 'error') {
        //         return response()->json([
        //             'status' => 'error',
        //             'msg' => $insertData['message']
        //         ]);
        //     }
        // }

        return response()->json([
            'status' => 'success',
            'msg' => '',
            'groupid' => $genIDG
        ]);
    }

    public function processSOExport(Request $request)
    {
        set_time_limit(0);

        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $date = explode('/', $request->date);
        $d = $date[0];
        $m = $date[1];
        $y = $date[2];
        $ymd = $y . '-' . $m . '-' . $d;
        $n = $request->number;

        // queryReportInvoiceExport
        $ProformaInvoiceHeaders = DB::select("
            SELECT * 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND (PICK_RELEASE_APPROVE_DATE IS NOT NULL AND CURRENCY = 'THB' 
            AND (
                    CLOSE_SALE_FLAG <> 'Y' 
                    OR CLOSE_SALE_FLAG IS NULL
                )
                OR (
                    PICK_RELEASE_APPROVE_DATE IS NOT NULL AND CURRENCY <> 'THB' 
                    AND (
                        CLOSE_SALE_FLAG <> 'Y' 
                        OR CLOSE_SALE_FLAG IS NULL
                    ) 
                    AND PICK_EXCHANGE_RATE IS NOT NULL
                )
            ) 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND PICK_RELEASE_NO = nvl('$n', PICK_RELEASE_NO)
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // queryReportCreditNoteExport
        $CreditNote = DB::select("
            SELECT PTOM_INVOICE_HEADERS.* 
            FROM PTOM_INVOICE_HEADERS,
            PTOM_CUSTOMERS
            WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            AND PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'CN_OTHER' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = nvl('$n', PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER)
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // queryReportDebitNoteExport
        $DebitNote = DB::select("
            SELECT PTOM_INVOICE_HEADERS.* 
            FROM PTOM_INVOICE_HEADERS,
            PTOM_CUSTOMERS
            WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            AND PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'DN' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = nvl('$n', PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER)
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        $genIDG = self::genGroupId($ProformaInvoiceHeaders, $CreditNote, $DebitNote);

        //case 1 PI and Invoice
        $webbatchno = $genIDG.'-'.uniqid();
        $SOExp = $this->querySOExport($genIDG, $request, $webbatchno);

        if ($SOExp['status'] == 'error') {
            return response()->json(['status' => 'error', 'groupid' => $genIDG, 'msg' => $SOExp['message'], 'program' => 'PI SO']);
        }

        return response()->json(['status' => 'success', 'groupid' => $genIDG, 'msg' => '', 'program' => 'PI SO']);
    }

    public function processRMAExport(Request $request)
    {
        set_time_limit(0);

        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $date = explode('/', $request->date);
        $d = $date[0];
        $m = $date[1];
        $y = $date[2];
        $ymd = $y . '-' . $m . '-' . $d;
        $n = $request->number;

        // queryReportInvoiceExport
        $ProformaInvoiceHeaders = DB::select("
            SELECT * 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND (PICK_RELEASE_APPROVE_DATE IS NOT NULL AND CURRENCY = 'THB' 
            AND (
                    CLOSE_SALE_FLAG <> 'Y' 
                    OR CLOSE_SALE_FLAG IS NULL
                )
                OR (
                    PICK_RELEASE_APPROVE_DATE IS NOT NULL AND CURRENCY <> 'THB' 
                    AND (
                        CLOSE_SALE_FLAG <> 'Y' 
                        OR CLOSE_SALE_FLAG IS NULL
                    ) 
                    AND PICK_EXCHANGE_RATE IS NOT NULL
                )
            ) 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND PICK_RELEASE_NO = nvl('$n', PICK_RELEASE_NO)
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // queryReportCreditNoteExport
        $CreditNote = DB::select("
            SELECT PTOM_INVOICE_HEADERS.* 
            FROM PTOM_INVOICE_HEADERS,
            PTOM_CUSTOMERS
            WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            AND PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'CN_OTHER' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = nvl('$n', PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER)
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // queryReportDebitNoteExport
        $DebitNote = DB::select("
            SELECT PTOM_INVOICE_HEADERS.* 
            FROM PTOM_INVOICE_HEADERS,
            PTOM_CUSTOMERS
            WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            AND PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'DN' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = nvl('$n', PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER)
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        $genIDG = self::genGroupId($ProformaInvoiceHeaders, $CreditNote, $DebitNote);

        //case 1 PI and Invoice
        $webbatchno = $genIDG.'-'.uniqid();
        $rmaExp = $this->queryRMAExport($genIDG, $request, $webbatchno);

        if ($rmaExp['status'] == 'error') {
            return response()->json(['status' => 'error', 'groupid' => $genIDG, 'msg' => $rmaExp['message'], 'program' => 'RMA']);
        }
        return response()->json(['status' => 'success', 'groupid' => $genIDG, 'msg' => '', 'program' => 'RMA']);
    }

    public function processInvoiceExport(Request $request)
    {
        set_time_limit(0);

        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $date = explode('/', $request->date);
        $d = $date[0];
        $m = $date[1];
        $y = $date[2];
        $ymd = $y . '-' . $m . '-' . $d;
        $n = $request->number;

        // queryReportInvoiceExport
        $ProformaInvoiceHeaders = DB::select("
            SELECT * 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND (
                PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                AND CURRENCY = 'THB' 
                AND (
                    CLOSE_SALE_FLAG <> 'Y' 
                    OR CLOSE_SALE_FLAG IS NULL
                )
                OR (
                    PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                    AND CURRENCY <> 'THB' 
                    AND (
                        CLOSE_SALE_FLAG <> 'Y' 
                        OR CLOSE_SALE_FLAG IS NULL
                    ) 
                    AND PICK_EXCHANGE_RATE IS NOT NULL
                )
            ) 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND PICK_RELEASE_NO = nvl('$n', PICK_RELEASE_NO)
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // queryReportCreditNoteExport
        $CreditNote = DB::select("
            SELECT PTOM_INVOICE_HEADERS.* 
            FROM PTOM_INVOICE_HEADERS,
            PTOM_CUSTOMERS
            WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            AND PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'CN_OTHER' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = nvl('$n', PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER)
            AND NOT EXISTS(
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        // queryReportDebitNoteExport
        $DebitNote = DB::select("
            SELECT PTOM_INVOICE_HEADERS.* 
            FROM PTOM_INVOICE_HEADERS,
            PTOM_CUSTOMERS
            WHERE PTOM_INVOICE_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
            AND PTOM_INVOICE_HEADERS.INVOICE_DATE IS NOT NULL 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_STATUS) = 'CONFIRM' 
            AND (
                PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_INVOICE_HEADERS.CLOSE_SALE_FLAG IS NULL
            ) 
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND UPPER(PTOM_INVOICE_HEADERS.INVOICE_TYPE) = 'DN' 
            AND TO_CHAR(PTOM_INVOICE_HEADERS.INVOICE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = nvl('$n', PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER)
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        $genIDG = self::genGroupId($ProformaInvoiceHeaders, $CreditNote, $DebitNote);

        //case 1 PI and Invoice
        $webbatchno = $genIDG.'-'.uniqid();

        foreach ($ProformaInvoiceHeaders as $row => $header) {
            $insertData = $this->CloseFlagInvoicesExport($genIDG, $header, $webbatchno);
            if ($insertData['status'] == 'error') {
                return response()->json([
                    'status' => 'error',
                    'msg' => $insertData['message']
                ]);
            }
        }
        
        foreach ($CreditNote as $row => $header) {
            $insertData = $this->CloseFlagCreditNoteExport($genIDG, $header, $webbatchno);
            if ($insertData['status'] == 'error') {
                return response()->json([
                    'status' => 'error',
                    'msg' => $insertData['message']
                ]);
            }
        }
        
        foreach ($DebitNote as $row => $header) {
            $insertData = $this->CloseFlagDebitNoteExport($genIDG, $header, $webbatchno);
            if ($insertData['status'] == 'error') {
                return response()->json([
                    'status' => 'error',
                    'msg' => $insertData['message']
                ]);
            }
        }

        $result = ARInterfaceNo8($webbatchno);

        $checkInvoiceErr = DB::table('PTOM_AR_INTERFACES')
        ->where('WEB_BATCH_NO', '=', $webbatchno)
        ->where('INTERFACE_STATUS', '=', 'E')
        ->get('INTERFACED_MSG');

        if (!!($checkInvoiceErr->count())) {
            return response()->json([
                'status' => 'error',
                'msg' => $checkInvoiceErr[0]->interfaced_msg,
            ]);
        }

        $checkInvoiceStatusNull = DB::table('PTOM_AR_INTERFACES')
        ->where('WEB_BATCH_NO', '=', $webbatchno)
        ->whereNull('INTERFACE_STATUS')
        ->count();

        if (!!($checkInvoiceStatusNull)) {
            return response()->json([
                'status' => 'error',
                'msg' => 'โปรแกรมขัดข้องกรุณาติดต่อผู้ดูแลระบบ',
            ]);
        }

        // $glData = DB::table('PTOM_PROFORMA_INVOICE_HEADERS AS PROF')
        // ->where('PROF.CURRENCY', '<>', 'THB')
        // ->where('PROF.PAYMENT_TYPE_CODE', '=', '10')
        // ->whereRaw("UPPER(PROF.PICK_RELEASE_STATUS) = 'CONFIRM'")
        // ->whereRaw("
        //     PICK_RELEASE_APPROVE_DATE IS NOT NULL 
        //     AND (
        //         CLOSE_SALE_FLAG <> 'Y' 
        //         OR CLOSE_SALE_FLAG IS NULL
        //     ) 
        //     AND PICK_EXCHANGE_RATE IS NOT NULL
        // ")
        // ->whereRaw("TO_CHAR(PROF.PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = ?", [$ymd])
        // ->when($n, function($query) use ($n) {
        //     return $query->where('PROF.PICK_RELEASE_NO', '=', $n);
        // })
        // ->get();

        // foreach ($glData as $row => $header) {
        //     $this->updateARGroupId('GL', $header, $genIDG);
        //     $insertData = $this->insertGLExport($genIDG, $header, $webbatchno);
        //     if ($insertData['status'] == 'error') {
        //         return response()->json([
        //             'status' => 'error',
        //             'msg' => $insertData['message']
        //         ]);
        //     }
        // }

        // if(!!($glData->count())){
        //     //// call package
        //     $result = \App\Repositories\OM\InterfaceRepo::interfaceGainLoss($webbatchno);

        //     $checkGainLoss = DB::table('PTOM_GL_INTERFACES')
        //     ->where('WEB_BATCH_NO', '=', $webbatchno)
        //     ->where('INTERFACE_STATUS', '=', 'E')
        //     ->get('INTERFACED_MSG');

        //     if (!!($checkGainLoss->count())) {
        //         return response()->json([
        //             'status' => 'error',
        //             'msg' => $checkGainLoss[0]->interfaced_msg,
        //         ]);
        //     }
        // }

        // update close_sale_flag Y and close_sale_status = S
        RMAModel::where('ar_invoice_group_id', $genIDG)->update(['close_sale_flag' => 'Y', 'close_sale_status' => 'S']);
        ProformaInvoiceHeaders::where('ar_invoice_group_id', $genIDG)->update(['close_sale_flag' => 'Y', 'close_sale_status' => 'S']);
        InvoiceHeaders::where('ar_invoice_group_id', $genIDG)->update(['close_sale_flag' => 'Y', 'close_sale_status' => 'S']);

        return response()->json(['status' => 'success', 'groupid' => $genIDG, 'msg' => 'ดำเนินการปิดการขายประจำวันเรียบร้อยแล้ว']);
    }

    private static function genGroupId($ProformaInvoiceHeaders, $CreditNote, $DebitNote)
    {
        $group_id = collect();

        if(count($ProformaInvoiceHeaders)){
            foreach ($ProformaInvoiceHeaders as $item) {
                $group_id->push($item->ar_invoice_group_id);
            }
        }

        if(count($CreditNote)){
            foreach ($CreditNote as $item) {
                $group_id->push($item->ar_invoice_group_id);
            }
        }

        if(count($DebitNote)){
            foreach ($DebitNote as $item) {
                $group_id->push($item->ar_invoice_group_id);
            }
        }

        return $group_id->filter()->unique()->sortDesc()->first() ?? getGroupID();
    }

    private static function getOldGroupId($ProformaInvoiceHeaders, $CreditNote, $DebitNote)
    {
        $group_id = collect();

        if(count($ProformaInvoiceHeaders)){
            foreach ($ProformaInvoiceHeaders as $item) {
                $group_id->push($item->ar_invoice_group_id);
            }
        }

        if(count($CreditNote)){
            foreach ($CreditNote as $item) {
                $group_id->push($item->ar_invoice_group_id);
            }
        }

        if(count($DebitNote)){
            foreach ($DebitNote as $item) {
                $group_id->push($item->ar_invoice_group_id);
            }
        }

        return $group_id->filter()->unique()->sortDesc()->values();
    }

    private function CloseFlagDebitNoteExport($genIDG, $header, $webbatchno, $report = false)
    {
        $ebs = InvoiceHeaders::find($header->invoice_headers_id);
        $customer = Customers::leftJoin('ptom_customer_type_export', 'ptom_customers.customer_type_id', 'ptom_customer_type_export.customer_type')
            ->where('ptom_customers.customer_id', $header->customer_id)
            ->first(['ptom_customers.customer_number', 'ptom_customers.customer_name', 'ptom_customers.bill_to_site_name', 'ptom_customer_type_export.meaning']);

        $org_id = DB::select("SELECT APPS.HR_ORGANIZATION_UNITS_V.ORGANIZATION_ID FROM APPS.HR_ORGANIZATION_UNITS_V WHERE APPS.HR_ORGANIZATION_UNITS_V.NAME = 'การยาสูบแห่งประเทศไทย'");

        $rawcount = 1;
        $data = InvoiceLines::where('invoice_headers_id', $header->invoice_headers_id)->orderBy('invoice_line_id', 'ASC')->get();
        foreach ($data as $line) {
            $ProformaInvoice = ProformaInvoiceHeaders::select('pi_header_id', 'ship_to_site_id', 'vat_code', 'pi_number', 'pi_date', 'tax', 'term_id')->where('pick_release_no', $line->ref_invoice_number)->first();
            $insertAR = array();
            $insertAR['group_id'] = $genIDG;
            $insertAR['interface_module'] = "AR";
            $insertAR['from_program_code'] = 'OMP0078';
            $insertAR['interface_type'] = 'Debit Memo';
            $insertAR['order_header_id'] = $header->invoice_headers_id;
            $insertAR['org_id'] = $org_id[0]->organization_id ?? '';
            $insertAR['operating_unit'] = 'การยาสูบแห่งประเทศไทย';
            $insertAR['batch_source_name'] = 'ระบบขายต่างประเทศ';
            $insertAR['document_id'] = $line->document_id;
            // if ($line->document_id != null || $line->document_id != '') {
            //     $sql_invoice_type = DB::select("SELECT PTOM_AR_TRAN_TYPES_V.CREDIT_MEMO_TYPE FROM PTOM_PROFORMA_INVOICE_HEADERS LEFT JOIN PTOM_TRANSACTION_TYPES_V ON PTOM_PROFORMA_INVOICE_HEADERS.ORDER_TYPE_ID = PTOM_TRANSACTION_TYPES_V.ORDER_TYPE_ID LEFT JOIN PTOM_AR_TRAN_TYPES_V ON PTOM_TRANSACTION_TYPES_V.RECEIVABLES_TRANSACTION_TYPE = PTOM_AR_TRAN_TYPES_V.NAME WHERE PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO = '" . $line->ref_invoice_number . "'");
            //     $invoice_type = $sql_invoice_type[0]->credit_memo_type ?? '';
            // } else {
            //     $invoice_type = 'เพิ่มหนี้-เบ็ดเตล็ด';
            // }
            $invoice_type = 'เพิ่มหนี้-เบ็ดเตล็ด';
            $insertAR['invoice_type'] = $invoice_type;

            $insertAR['invoice_number'] =  $header->invoice_headers_number;
            $insertAR['invoice_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
            $insertAR['gl_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
            $insertAR['customer_number'] =  $customer->customer_number;
            $insertAR['customer_name'] =  $customer->customer_name;
            $insertAR['bill_to_location'] =  $customer->bill_to_site_name ?? "";
            if (!empty($ProformaInvoice)) {
                $ship_to_location = DB::select("SELECT SHIP_TO_SITE_NAME FROM PTOM_CUSTOMER_SHIP_SITES WHERE SHIP_TO_SITE_ID = '" . $ProformaInvoice->ship_to_site_id . "'");
                $ship_to_location_name = $ship_to_location[0]->ship_to_site_name ?? "";
            } else {
                $ship_to_location_name = "";
            }
            $insertAR['ship_to_location'] =  $ship_to_location_name;
            $term_name =  DB::select("SELECT PTOM_TERMS_V.NAME FROM PTOM_TERMS_V WHERE TERM_ID = '" . $ProformaInvoice->term_id . "'") ?? "";
            $insertAR['term_name'] = $line->ref_invoice_number ? $term_name[0]->name : 'IMMEDIATE';
            $insertAR['due_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
            $insertAR['currency_code'] =  $header->currency;
            $insertAR['conversion_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
            $insertAR['conversion_type'] =  'User';
            $insertAR['conversion_rate'] =  $line->conversion_rate ?? "";

            // $insertAR['reference'] =  $reference[0]->pick_release_no ?? "";
            $insertAR['reference'] = $line->ref_invoice_number;
            $insertAR['invoice_total_with_vat'] =  $header->invoice_amount;
            $insertAR['order_line_id'] =  $line->invoice_line_id;
            $insertAR['line_number'] =  $rawcount;
            $insertAR['item_code'] =  $line->item_code;

            if ($header->dr_segment9 == '219640') {
                $description = 'บันทึกลดยอดเจ้าหนี้ค่าบุหรี่';
            } else {
                if ($line->item_description == null || $line->item_description == "") {
                    $description = 'บันทึกเพิ่มหนี้';
                } else {
                    $description = $line->item_description ?? null;
                }
            }
            $insertAR['description'] =  $description;

            $insertAR['uom_name'] = $line->uom_code;
            $insertAR['quantity'] = 1; // $line->quantity;
            $insertAR['unit_selling_price'] =  $line->diff_amount;

            $amount = ($insertAR['quantity'] * $insertAR['unit_selling_price']) ?? 0;
            $insertAR['amount'] = $amount;

            $insertAR['tax_code'] = $line->ref_invoice_number ? $ProformaInvoice->vat_code : '';
            $percentage_rateQuery = DB::select("SELECT PTOM_TAX_CODE_V.PERCENTAGE_RATE FROM PTOM_TAX_CODE_V WHERE TAX_RATE_CODE = '" . $ProformaInvoice->vat_code . "'");
            $percentage_rate = $percentage_rateQuery[0]->percentage_rate;
            $insertAR['tax_amount'] = ($amount * $percentage_rate) / 100;
            $insertAR['line_amount'] = $amount + $insertAR['tax_amount'] ?? 0;

            $rec_account_combine = [];
            $rec_account_combine['rec_segment1'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 1, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment2'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 2, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment3'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 3, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment4'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 4, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment5'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 5, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment6'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 6, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment7'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 7, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment8'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 8, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment9'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 9, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment10'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 10, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment11'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 11, $line->ref_invoice_number, $line->item_code);
            $rec_account_combine['rec_segment12'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 12, $line->ref_invoice_number, $line->item_code);
            if (implode(".", array_values($rec_account_combine)) == '...........') {
                $insertAR['rec_account_combine'] = '';
            } else {
                $insertAR['rec_account_combine'] = implode(".", array_values($rec_account_combine));
            }
            $insertAR['rec_segment1'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 1, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment2'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 2, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment3'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 3, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment4'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 4, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment5'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 5, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment6'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 6, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment7'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 7, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment8'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 8, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment9'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 9, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment10'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 10, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment11'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 11, $line->ref_invoice_number, $line->item_code);
            $insertAR['rec_segment12'] = $this->getSegmentInvoiceHeaderAndLineDebitNote($header, 12, $line->ref_invoice_number, $line->item_code);

            $rev_account_combine = [];
            $rev_account_combine['rev_segment1'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 1, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment2'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 2, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment3'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 3, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment4'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 4, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment5'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 5, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment6'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 6, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment7'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 7, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment8'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 8, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment9'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 9, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment10'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 10, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment11'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 11, $line->ref_invoice_number, $line->item_code);
            $rev_account_combine['rev_segment12'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 12, $line->ref_invoice_number, $line->item_code);
            if (implode(".", array_values($rev_account_combine)) == '...........') {
                $insertAR['rev_account_combine'] = '';
            } else {
                $insertAR['rev_account_combine'] = implode(".", array_values($rev_account_combine));
            }
            $insertAR['rev_segment1'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 1, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment2'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 2, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment3'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 3, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment4'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 4, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment5'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 5, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment6'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 6, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment7'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 7, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment8'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 8, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment9'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 9, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment10'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 10, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment11'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 11, $line->ref_invoice_number, $line->item_code);
            $insertAR['rev_segment12'] = $this->getSegmentInvoiceHeaderRevDebitNote($header, 12, $line->ref_invoice_number, $line->item_code);


            $tax_account_combine = [];
            $tax_account_combine['taxc_segment1'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 1);
            $tax_account_combine['taxc_segment2'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 2);
            $tax_account_combine['taxc_segment3'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 3);
            $tax_account_combine['taxc_segment4'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 4);
            $tax_account_combine['taxc_segment5'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 5);
            $tax_account_combine['taxc_segment6'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 6);
            $tax_account_combine['taxc_segment7'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 7);
            $tax_account_combine['taxc_segment8'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 8);
            $tax_account_combine['taxc_segment9'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 9);
            $tax_account_combine['taxc_segment10'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 10);
            $tax_account_combine['taxc_segment11'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 11);
            $tax_account_combine['taxc_segment12'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 12);
            if (implode(".", array_values($tax_account_combine)) == '...........') {
                $insertAR['tax_account_combine'] = '';
            } else {
                $insertAR['tax_account_combine'] = implode(".", array_values($tax_account_combine));
            }
            $insertAR['taxc_segment1'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 1);
            $insertAR['taxc_segment2'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 2);
            $insertAR['taxc_segment3'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 3);
            $insertAR['taxc_segment4'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 4);
            $insertAR['taxc_segment5'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 5);
            $insertAR['taxc_segment6'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 6);
            $insertAR['taxc_segment7'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 7);
            $insertAR['taxc_segment8'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 8);
            $insertAR['taxc_segment9'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 9);
            $insertAR['taxc_segment10'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 10);
            $insertAR['taxc_segment11'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 11);
            $insertAR['taxc_segment12'] = $this->getSegmentInvoiceHeaderTaxDebitNote($line->ref_invoice_number, 12);

            if ($line->program_code == 'OMP0077') {
                $interface_line_attribute1 = $ProformaInvoice->pi_number;
                $interface_line_attribute2 = '';
                $interface_line_attribute3 = Carbon::parse($ProformaInvoice->pi_date)->format('Y-m-d');
            } elseif ($line->programe_code == 'OMP0050') {
                $order_cliam = OrderHeader::find($line->document_id);
                if (empty($order_cliam)) {
                    $interface_line_attribute1 = '';
                    $interface_line_attribute3 = '';
                } else {
                    $interface_line_attribute1 = $order_cliam->prepare_order_number;
                    $interface_line_attribute3 = $order_cliam->order_date;
                }
                $interface_line_attribute2 = '';
            } elseif ($line->programe_code == 'OMP0082') {
                $interface_line_attribute1 = $ProformaInvoice->pi_number;
                $interface_line_attribute2 = $ProformaInvoice->pi_number;
                $interface_line_attribute3 = Carbon::parse($ProformaInvoice->pi_date)->format('Y-m-d');
            } else {
                $ram = RMAModel::where('claim_header_id', $line->document_id)->first();
                if (empty($ram)) {
                    $interface_line_attribute1 = '';
                    $interface_line_attribute2 = '';
                    $interface_line_attribute3 = '';
                } else {
                    $interface_line_attribute1 = $ram->rma_number;
                    $interface_line_attribute2 = $ram->rma_number;
                    $interface_line_attribute3 = Carbon::parse($ram->rma_date)->format('Y-m-d');
                }
            }
            $insertAR['interface_line_attribute1'] = $interface_line_attribute1;
            $insertAR['interface_line_attribute2'] = $interface_line_attribute2;
            $insertAR['interface_line_attribute3'] = $interface_line_attribute3;

            $insertAR['percent'] = '100';
            $insertAR['amount_dis'] = $insertAR['line_amount'] ?? null;
            $insertAR['program_code'] = 'OMP0078';
            $insertAR['created_by'] =  getDefaultData('/users')->user_id;
            $insertAR['last_updated_by'] =  getDefaultData('/users')->user_id;
            $insertAR['web_batch_no'] =  $webbatchno;
            // $insertAR['interface_status'] = 'S';
            $type_code_p = DB::select("SELECT PRODUCT_TYPE_CODE FROM PTOM_SEQUENCE_ECOMS WHERE ITEM_ID = '$line->item_id'");
            $insertAR['product_type_code'] = empty($type_code_p) ? '' : $type_code_p[0]->product_type_code;

            $insertAR['ebs_order_number'] = $ebs->ebs_order_number;
            $insertAR['tax_header_amount'] = $ProformaInvoice->tax;
            $insertAR['tax_rate'] = $percentage_rate;

            if ($insertAR['tax_account_combine'] != '') {
                if (GLCombinationKFV::where('concatenated_segments', $insertAR['tax_account_combine'])->count() == 0) {
                    $data = [
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['tax_account_combine'] . ' นี้ในระบบ',
                    ];
                    return $data;
                }
            }
            if ($insertAR['rev_account_combine'] != '') {
                if (GLCombinationKFV::where('concatenated_segments', $insertAR['rev_account_combine'])->count() == 0) {
                    $data = [
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['rev_account_combine'] . ' นี้ในระบบ',
                    ];
                    return $data;
                }
            }
            if ($insertAR['rec_account_combine'] != '') {
                if (GLCombinationKFV::where('concatenated_segments', $insertAR['rec_account_combine'])->count() == 0) {
                    $data = [
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['rec_account_combine'] . ' นี้ในระบบ',
                    ];
                    return $data;
                }
            }
            
            if($report){

                $desc = optional(PtomArDailyAccRptDescV::where('meaning', $insertAR['from_program_code'])->first());
                $insertAR['report_description'] = $desc->description;
            }

            $report ? ARInterfacesReport::create($insertAR) : ARInterface::create($insertAR);
            $rawcount++;
        }

        $data = [
            'status' => 'success'
        ];
        return $data;
    }

    private function insertGLExport($genIDG, $header, $webbatchno, $report = false)
    {
        $now = Carbon::now();
        $user_id = getDefaultData('/users')->user_id;
        $program_code = 'OMP0078';
        $tran_type = TransactionTypeAllV::where('order_type_id', $header->order_type_id)->first();
        $ar_trantype = ARTranTypesV::where('name', $tran_type->receivables_transaction_type)->first();
        $desc = optional(PtomArDailyAccRptDescV::where('meaning', $program_code)->first());

        $pick_exchange_date = Carbon::parse($header->pick_exchange_date);
        $accounting_date = $pick_exchange_date->format('Y-m-d');
        $period = strtoupper($pick_exchange_date->format('M-y'));

        $getGainLoss = DB::select("
            SELECT  
                ROUND(PAYMENT_AMOUNT*P.CONVERSION_RATE ,2) - ROUND(GRAND_TOTAL*PICK_EXCHANGE_RATE,2) AS GAIN_LOSS
            FROM 
                PTOM_PROFORMA_INVOICE_HEADERS H
                ,PTOM_PAYMENT_EXP_V P
            WHERE 1 = 1
            AND H.SA_NUMBER = P.PREPARE_ORDER_NUMBER
            AND PICK_RELEASE_NO = '$header->pick_release_no'
        ");
        
        $amount = empty($getGainLoss) ? 0 : $getGainLoss[0]->gain_loss;

        if($amount == 0){
            return;
        }

        $interface = $report ? new GLInterfacesReport : new GLInterfaceModel;
        $interface->group_id = $genIDG;
        $interface->interface_module = 'GL';
        $interface->org_id = $this->orgId;
        $interface->ledger_name = $this->orgName;
        $interface->accounting_date = $accounting_date;
        $interface->period_name = $period;
        $interface->currency_code = 'THB';
        $interface->actual_flag = 'A';
        $interface->user_je_category_name = 'WEB OP Sales Invoice';
        $interface->user_je_source_name = 'WEB ระบบขาย';
        $interface->batch_name = 'กำไรขาดทุนจากอัตราแลกเปลี่ยน';
        $interface->journal_name = 'กำไรขาดทุนจากอัตราแลกเปลี่ยน '.optional($header)->pick_release_no;
        $interface->journal_description_head = 'กำไรขาดทุนจากอัตราแลกเปลี่ยน '.optional($header)->pick_release_no;

        $interface->je_line_num = '1';
        $interface->segment1 = optional($ar_trantype)->clearing_account_segment1;
        $interface->segment2 = optional($ar_trantype)->clearing_account_segment2;
        $interface->segment3 = optional($ar_trantype)->clearing_account_segment3;
        $interface->segment4 = optional($ar_trantype)->clearing_account_segment4;
        $interface->segment5 = optional($ar_trantype)->clearing_account_segment5;
        $interface->segment6 = optional($ar_trantype)->clearing_account_segment6;
        $interface->segment7 = optional($ar_trantype)->clearing_account_segment7;
        $interface->segment8 = optional($ar_trantype)->clearing_account_segment8;
        $interface->segment9 = optional($ar_trantype)->clearing_account_segment9;
        $interface->segment10 = optional($ar_trantype)->clearing_account_segment10;
        $interface->segment11 = optional($ar_trantype)->clearing_account_segment11;
        $interface->segment12 = optional($ar_trantype)->clearing_account_segment12;

        $interface->entered_dr = $amount > 0 ? $amount : '';
        $interface->entered_cr = $amount < 0 ? $amount : '';
        $interface->accounted_dr = $interface->entered_dr;
        $interface->accounted_cr = $interface->entered_cr;
        $interface->journal_description_line = 'Journal Import Created';

        $interface->program_code = $program_code;
        $interface->web_batch_no = $webbatchno;
        $interface->created_by = $user_id;
        $interface->last_updated_by = $user_id;
        $interface->creation_date = $now;
        $interface->save();


        $gainLoss = $report ? new GLInterfacesReport : new GLInterfaceModel;
        $gainLoss->group_id = $genIDG;
        $gainLoss->interface_module = 'GL';
        $gainLoss->org_id = $this->orgId;
        $gainLoss->ledger_name = $this->orgName;
        $gainLoss->accounting_date = $accounting_date;
        $gainLoss->period_name = $period;
        $gainLoss->currency_code = 'THB';
        $gainLoss->actual_flag = 'A';
        $gainLoss->user_je_category_name = 'WEB OP Sales Invoice';
        $gainLoss->user_je_source_name = 'WEB ระบบขาย';
        $gainLoss->batch_name = 'กำไรขาดทุนจากอัตราแลกเปลี่ยน';
        $gainLoss->journal_name = 'กำไรขาดทุนจากอัตราแลกเปลี่ยน '.optional($header)->pick_release_no;
        $gainLoss->journal_description_head = 'กำไรขาดทุนจากอัตราแลกเปลี่ยน '.optional($header)->pick_release_no;

        $account = $amount > 0 ? 'TRX-EXP-Gain' : 'TRX-EXP-Loss';
        $map = MappingAccountModel::where('account_code', $account)->first();
        $gainLoss->je_line_num = '2';
        $gainLoss->segment1 = optional($map)->segment1;
        $gainLoss->segment2 = optional($map)->segment2;
        $gainLoss->segment3 = optional($map)->segment3;
        $gainLoss->segment4 = optional($map)->segment4;
        $gainLoss->segment5 = optional($map)->segment5 ?? '00';
        $gainLoss->segment6 = optional($map)->segment6;
        $gainLoss->segment7 = optional($map)->segment7;
        $gainLoss->segment8 = optional($map)->segment8;
        $gainLoss->segment9 = optional($map)->segment9;
        $gainLoss->segment10 = optional($map)->segment10;
        $gainLoss->segment11 = optional($map)->segment11;
        $gainLoss->segment12 = optional($map)->segment12;

        $gainLoss->entered_dr = $amount < 0 ? $amount : '';
        $gainLoss->entered_cr = $amount > 0 ? $amount : '';
        $gainLoss->accounted_dr = $gainLoss->entered_dr;
        $gainLoss->accounted_cr = $gainLoss->entered_cr;
        $gainLoss->journal_description_line = 'Journal Import Created';

        $gainLoss->program_code = $program_code;
        $gainLoss->web_batch_no = $webbatchno;
        $gainLoss->created_by = $user_id;
        $gainLoss->last_updated_by = $user_id;
        $gainLoss->creation_date = $now;
        $gainLoss->save();

        $data = [
            'status' => 'success'
        ];
        return $data;
    }

    private function getSegmentInvoiceHeaderTaxDebitNote($ref, $segmentNumber)
    {
        if ($ref == null || $ref == '') {
            return '';
        } else {
            return MappingAccountModel::select("segment{$segmentNumber}")->where('account_code', 'TRX-EXP-Sales Invoice-04')->first()->toArray()["segment{$segmentNumber}"];
        }
    }

    private function getSegmentInvoiceHeaderRevDebitNote($header, $segmentNumber, $ref, $item)
    {
        if ($segmentNumber == 1) {
            if ($header->cr_segment1 == null || $header->cr_segment1 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment1;
                }
            } else {
                return $header->cr_segment1;
            }
        } elseif ($segmentNumber == 2) {
            if ($header->cr_segment2 == null || $header->cr_segment2 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment2;
                }
            } else {
                return $header->cr_segment2;
            }
        } elseif ($segmentNumber == 3) {
            if ($header->cr_segment3 == null || $header->cr_segment3 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment3;
                }
            } else {
                return $header->cr_segment3;
            }
        } elseif ($segmentNumber == 4) {
            if ($header->cr_segment4 == null || $header->cr_segment4 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment4;
                }
            } else {
                return $header->cr_segment4;
            }
        } elseif ($segmentNumber == 5) {
            if ($header->cr_segment5 == null || $header->cr_segment5 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment5;
                }
            } else {
                return $header->cr_segment5;
            }
        } elseif ($segmentNumber == 6) {
            if ($header->cr_segment6 == null || $header->cr_segment6 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment6;
                }
            } else {
                return $header->cr_segment6;
            }
        } elseif ($segmentNumber == 7) {
            if ($header->cr_segment7 == null || $header->cr_segment7 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment7;
                }
            } else {
                return $header->cr_segment7;
            }
        } elseif ($segmentNumber == 8) {
            if ($header->cr_segment8 == null || $header->cr_segment8 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment8;
                }
            } else {
                return $header->cr_segment8;
            }
        } elseif ($segmentNumber == 9) {
            if ($header->cr_segment9 == null || $header->cr_segment9 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment9;
                }
            } else {
                return $header->cr_segment9;
            }
        } elseif ($segmentNumber == 10) {
            if ($header->cr_segment10 == null || $header->cr_segment10 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment10;
                }
            } else {
                return $header->cr_segment10;
            }
        } elseif ($segmentNumber == 11) {
            if ($header->cr_segment11 == null || $header->cr_segment11 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment11;
                }
            } else {
                return $header->cr_segment11;
            }
        } else {
            if ($header->cr_segment12 == null || $header->cr_segment12 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment12;
                }
            } else {
                return $header->cr_segment12;
            }
        }
    }

    private function getSegmentInvoiceHeaderAndLineDebitNote($header, $segmentNumber, $ref, $item)
    {
        if ($segmentNumber == 1) {
            if ($header->dr_segment1 == null || $header->dr_segment1 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment1;
                }
            } else {
                return $header->dr_segment1;
            }
        } elseif ($segmentNumber == 2) {
            if ($header->dr_segment2 == null || $header->dr_segment2 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment2;
                }
            } else {
                return $header->dr_segment2;
            }
        } elseif ($segmentNumber == 3) {
            if ($header->dr_segment3 == null || $header->dr_segment3 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment3;
                }
            } else {
                return $header->dr_segment3;
            }
        } elseif ($segmentNumber == 4) {
            if ($header->dr_segment4 == null || $header->dr_segment4 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment4;
                }
            } else {
                return $header->dr_segment4;
            }
        } elseif ($segmentNumber == 5) {
            if ($header->dr_segment5 == null || $header->dr_segment5 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment5;
                }
            } else {
                return $header->dr_segment5;
            }
        } elseif ($segmentNumber == 6) {
            if ($header->dr_segment6 == null || $header->dr_segment6 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment6;
                }
            } else {
                return $header->dr_segment6;
            }
        } elseif ($segmentNumber == 7) {
            if ($header->dr_segment7 == null || $header->dr_segment7 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment7;
                }
            } else {
                return $header->dr_segment7;
            }
        } elseif ($segmentNumber == 8) {
            if ($header->dr_segment8 == null || $header->dr_segment8 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment8;
                }
            } else {
                return $header->dr_segment8;
            }
        } elseif ($segmentNumber == 9) {
            if ($header->dr_segment9 == null || $header->dr_segment9 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment9;
                }
            } else {
                return $header->dr_segment9;
            }
        } elseif ($segmentNumber == 10) {
            if ($header->dr_segment10 == null || $header->dr_segment10 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment10;
                }
            } else {
                return $header->dr_segment10;
            }
        } elseif ($segmentNumber == 11) {
            if ($header->dr_segment11 == null || $header->dr_segment11 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment11;
                }
            } else {
                return $header->dr_segment11;
            }
        } else {
            if ($header->dr_segment12 == null || $header->dr_segment12 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rec_segment12;
                }
            } else {
                return $header->dr_segment12;
            }
        }
    }

    private function CloseFlagCreditNoteExport($genIDG, $header, $webbatchno, $report = false)
    {
        // $ebs = InvoiceHeaders::find($header->invoice_headers_id);
        $ebs = RMAModel::where('credit_note_number', $header->invoice_headers_number)->first();
        $customer = Customers::leftJoin('ptom_customer_type_export', 'ptom_customers.customer_type_id', 'ptom_customer_type_export.customer_type')
            ->where('ptom_customers.customer_id', $header->customer_id)
            ->first(['ptom_customers.customer_number', 'ptom_customers.customer_name', 'ptom_customers.bill_to_site_name', 'ptom_customer_type_export.meaning', 'ptom_customers.sales_classification_code', 'ptom_customers.customer_type_id']);
        $org_id = DB::select("SELECT APPS.HR_ORGANIZATION_UNITS_V.ORGANIZATION_ID FROM APPS.HR_ORGANIZATION_UNITS_V WHERE APPS.HR_ORGANIZATION_UNITS_V.NAME = 'การยาสูบแห่งประเทศไทย'");

        $lineNumber = 1;
        $rawcount = 1;
        $data = InvoiceLines::where('invoice_headers_id', $header->invoice_headers_id)->orderBy('invoice_line_id', 'ASC');
        if ($data->count() == 0) {
            $insertAR = array();
            $insertAR['group_id'] = $genIDG;
            $insertAR['interface_module'] = "AR";
            $insertAR['from_program_code'] = $header->program_code;
            $insertAR['interface_type'] = 'Credit Memo';
            $insertAR['order_header_id'] = $header->invoice_headers_id;
            $insertAR['org_id'] = $org_id[0]->organization_id ?? '';
            $insertAR['operating_unit'] = 'การยาสูบแห่งประเทศไทย';
            $insertAR['batch_source_name'] = 'ระบบขายต่างประเทศ';
            $insertAR['invoice_type'] = 'Credit Memo';
            $insertAR['invoice_number'] =  $header->invoice_headers_number;
            $insertAR['invoice_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
            $insertAR['gl_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
            $insertAR['customer_number'] =  $customer->customer_number;
            $insertAR['customer_name'] =  $customer->customer_name;

            $stln = DB::select("SELECT * FROM PTOM_CUSTOMER_SHIP_SITES WHERE CUSTOMER_ID = $header->customer_id AND STATUS = 'Active' AND ATTRIBUTE1 = 'Y'");
            if (empty($stln)) {
                $stln2 = DB::select("SELECT * FROM PTOM_CUSTOMER_SHIP_SITES WHERE CUSTOMER_ID = $header->customer_id AND STATUS = 'Active' AND ROWNUM = 1 ORDER BY SITE_NO ASC");
                $ship_to_location_name = $stln2[0]->ship_to_site_name;
            } else {
                $ship_to_location_name = $stln[0]->ship_to_site_name;
            }
            $bill_to_site_name = $customer->bill_to_site_name;

            if ($header->program_code == "OMP0077") {
                $quantity = "-1";
                $unit_selling_price = $header->invoice_amount;
            } else {
                $quantity = "";
                $unit_selling_price = "";
            }

            $insertAR['ship_to_location'] =  $ship_to_location_name;
            $insertAR['bill_to_location'] =  $bill_to_site_name;
            $insertAR['due_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
            $insertAR['currency_code'] = 'THB';//$header->currency;
            $insertAR['conversion_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
            $insertAR['conversion_type'] =  'User';
            $insertAR['conversion_rate'] = 1;// $header->currency == 'THB' ? 1 : $header->exchange_rate;
            $insertAR['reference'] = ""; //ติดต่อผู้ดูแลระบบ
            $insertAR['invoice_total_with_vat'] =  round((float)$header->invoice_amount * (float)$header->exchange_rate, 2);
            $insertAR['order_line_id'] =  ""; //ติดต่อผู้ดูแลระบบ
            $insertAR['line_number'] =  $lineNumber;
            $insertAR['item_code'] = ""; //ติดต่อผู้ดูแลระบบ
            $insertAR['description'] =  "บันทึกลดหนี้";
            $insertAR['uom_name'] = ""; //ติดต่อผู้ดูแลระบบ
            $insertAR['quantity'] =  $quantity; 
            $insertAR['unit_selling_price'] = round((float)$unit_selling_price * (float)$header->exchange_rate, 7); //ติดต่อผู้ดูแลระบบ
            $insertAR['amount'] = ((float)$insertAR['quantity'] * (float)$insertAR['unit_selling_price']) ?? 0;

            $ProformaInvoice = ProformaInvoiceHeaders::select('pi_header_id', 'ship_to_site_id', 'vat_code', 'pi_number', 'pi_date', 'tax')->where('pick_release_no', $header->ref_invoice_number)->first();
            if (empty($ProformaInvoice)) {
                $pvatper = '';
            } else {
                $v = DB::select("SELECT PTOM_TAX_CODE_V.PERCENTAGE_RATE FROM PTOM_TAX_CODE_V WHERE TAX_RATE_CODE = '" . $ProformaInvoice->vat_code . "'");
                $pvatper = $v[0]->percentage_rate ?? 0;
            }

            $insertAR['tax_code'] = $header->program_code == "OMP0077" ? '' : $ProformaInvoice->vat_code; //ติดต่อผู้ดูแลระบบ
            $percentage_rate = $pvatper; //ติดต่อผู้ดูแลระบบ
            $insertAR['tax_amount'] = $header->program_code == "OMP0077" ? '' : ((float)$insertAR['amount'] * (float)$percentage_rate) / 100;
            $insertAR['line_amount'] = ((float)$insertAR['amount'] + (float)$insertAR['tax_amount']) ?? 0;
            $rec_account_combine = [];
            $rec_account_combine['rec_segment1'] = $header->cr_segment1;
            $rec_account_combine['rec_segment2'] = $header->cr_segment2;
            $rec_account_combine['rec_segment3'] = $header->cr_segment3;
            $rec_account_combine['rec_segment4'] = $header->cr_segment4;
            $rec_account_combine['rec_segment5'] = $header->cr_segment5;
            $rec_account_combine['rec_segment6'] = $header->cr_segment6;
            $rec_account_combine['rec_segment7'] = $header->cr_segment7;
            $rec_account_combine['rec_segment8'] = $header->cr_segment8;
            $rec_account_combine['rec_segment9'] = $header->cr_segment9;
            $rec_account_combine['rec_segment10'] = $header->cr_segment10;
            $rec_account_combine['rec_segment11'] = $header->cr_segment11;
            $rec_account_combine['rec_segment12'] = $header->cr_segment12;
            if (implode(".", array_values($rec_account_combine)) == '...........') {
                $insertAR['rec_account_combine'] = '';
            } else {
                $insertAR['rec_account_combine'] = implode(".", array_values($rec_account_combine));
            }
            $insertAR['rec_segment1'] = $header->cr_segment1;
            $insertAR['rec_segment2'] = $header->cr_segment2;
            $insertAR['rec_segment3'] = $header->cr_segment3;
            $insertAR['rec_segment4'] = $header->cr_segment4;
            $insertAR['rec_segment5'] = $header->cr_segment5;
            $insertAR['rec_segment6'] = $header->cr_segment6;
            $insertAR['rec_segment7'] = $header->cr_segment7;
            $insertAR['rec_segment8'] = $header->cr_segment8;
            $insertAR['rec_segment9'] = $header->cr_segment9;
            $insertAR['rec_segment10'] = $header->cr_segment10;
            $insertAR['rec_segment11'] = $header->cr_segment11;
            $insertAR['rec_segment12'] = $header->cr_segment12;

            $rev_account_combine = [];
            $rev_account_combine['rev_segment1'] = $header->dr_segment1;
            $rev_account_combine['rev_segment2'] = $header->dr_segment2;
            $rev_account_combine['rev_segment3'] = $header->dr_segment3;
            $rev_account_combine['rev_segment4'] = $header->dr_segment4;
            $rev_account_combine['rev_segment5'] = $header->dr_segment5;
            $rev_account_combine['rev_segment6'] = $header->dr_segment6;
            $rev_account_combine['rev_segment7'] = $header->dr_segment7;
            $rev_account_combine['rev_segment8'] = $header->dr_segment8;
            $rev_account_combine['rev_segment9'] = $header->dr_segment9;
            $rev_account_combine['rev_segment10'] = $header->dr_segment10;
            $rev_account_combine['rev_segment11'] = $header->dr_segment11;
            $rev_account_combine['rev_segment12'] = $header->dr_segment12;
            if (implode(".", array_values($rev_account_combine)) == '...........') {
                $insertAR['rev_account_combine'] = '';
            } else {
                $insertAR['rev_account_combine'] = implode(".", array_values($rev_account_combine));
            }
            $insertAR['rev_segment1'] = $header->dr_segment1;
            $insertAR['rev_segment2'] = $header->dr_segment2;
            $insertAR['rev_segment3'] = $header->dr_segment3;
            $insertAR['rev_segment4'] = $header->dr_segment4;
            $insertAR['rev_segment5'] = $header->dr_segment5;
            $insertAR['rev_segment6'] = $header->dr_segment6;
            $insertAR['rev_segment7'] = $header->dr_segment7;
            $insertAR['rev_segment8'] = $header->dr_segment8;
            $insertAR['rev_segment9'] = $header->dr_segment9;
            $insertAR['rev_segment10'] = $header->dr_segment10;
            $insertAR['rev_segment11'] = $header->dr_segment11;
            $insertAR['rev_segment12'] = $header->dr_segment12;

            $insertAR['interface_line_attribute1'] = ""; //ติดต่อผู้ดูแลระบบ
            $insertAR['interface_line_attribute2'] = ""; //ติดต่อผู้ดูแลระบบ
            $insertAR['interface_line_attribute3'] = ""; //ติดต่อผู้ดูแลระบบ
            $insertAR['percent'] = '100';
            $insertAR['amount_dis'] = $insertAR['line_amount'] ?? null;
            $insertAR['program_code'] = 'OMP0078';
            $insertAR['created_by'] =  getDefaultData('/users')->user_id;
            $insertAR['last_updated_by'] =  getDefaultData('/users')->user_id;
            $insertAR['web_batch_no'] =  $webbatchno;
            // $insertAR['interface_status'] = 'S';
            $insertAR['product_type_code'] = empty($type_code_p) ? '' : $type_code_p[0]->product_type_code;
            $insertAR['ebs_order_number'] = optional($ebs)->ebs_order_number;
            $insertAR['tax_header_amount'] = $header->total_vat_amount;
            $insertAR['pao_header_amount'] = $header->pao_amount;
            $insertAR['tax_rate'] = $percentage_rate;

            if ($insertAR['rev_account_combine'] != '') {
                if (GLCombinationKFV::where('concatenated_segments', $insertAR['rev_account_combine'])->count() == 0) {
                    $data = [
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['rev_account_combine'] . ' นี้ในระบบ',
                    ];
                    return $data;
                }
            }
            if ($insertAR['rec_account_combine'] != '') {
                if (GLCombinationKFV::where('concatenated_segments', $insertAR['rec_account_combine'])->count() == 0) {
                    $data = [
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['rec_account_combine'] . ' นี้ในระบบ',
                    ];
                    return $data;
                }
            }
            
            if($report){

                $desc = optional(PtomArDailyAccRptDescV::where('meaning', $insertAR['from_program_code'])->first());
                $insertAR['report_description'] = $desc->description;
            }

            $report ? ARInterfacesReport::create($insertAR) : ARInterface::create($insertAR);
            $rawcount++;
        } else {
            foreach ($data->get() as $line) {
                $ProformaInvoice = ProformaInvoiceHeaders::select('pi_header_id', 'ship_to_site_id', 'vat_code', 'pi_number', 'pi_date', 'tax')->where('pick_release_no', $line->ref_invoice_number)->first();
                $type_code_p = DB::select("SELECT PRODUCT_TYPE_CODE FROM PTOM_SEQUENCE_ECOMS WHERE ITEM_ID = '$line->item_id'");
                $insertAR = array();
                $insertAR['group_id'] = $genIDG;
                $insertAR['interface_module'] = "AR";
                $insertAR['from_program_code'] = $header->program_code;
                $insertAR['interface_type'] = 'Credit Memo';
                $insertAR['order_header_id'] = $header->invoice_headers_id;
                $insertAR['org_id'] = $org_id[0]->organization_id ?? '';
                $insertAR['operating_unit'] = 'การยาสูบแห่งประเทศไทย';
                $insertAR['batch_source_name'] = 'ระบบขายต่างประเทศ';

                if ($line->document_id != null || $line->document_id != '') {
                    $sql_invoice_type = DB::select("SELECT PTOM_AR_TRAN_TYPES_V.CREDIT_MEMO_TYPE FROM PTOM_PROFORMA_INVOICE_HEADERS LEFT JOIN PTOM_TRANSACTION_TYPES_V ON PTOM_PROFORMA_INVOICE_HEADERS.ORDER_TYPE_ID = PTOM_TRANSACTION_TYPES_V.ORDER_TYPE_ID LEFT JOIN PTOM_AR_TRAN_TYPES_V ON PTOM_TRANSACTION_TYPES_V.RECEIVABLES_TRANSACTION_TYPE = PTOM_AR_TRAN_TYPES_V.NAME WHERE PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO = '" . $line->ref_invoice_number . "'");
                    $invoice_type = $sql_invoice_type[0]->credit_memo_type ?? '';
                } else {
                    $invoice_type = 'Credit Memo';
                }
                $insertAR['invoice_type'] = $invoice_type;

                $insertAR['invoice_number'] =  $header->invoice_headers_number;
                $insertAR['invoice_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
                $insertAR['gl_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
                $insertAR['customer_number'] =  $customer->customer_number;
                $insertAR['customer_name'] =  $customer->customer_name;

                if (strtoupper($customer->sales_classification_code) == 'DOMESTIC') {
                    if ($customer->customer_type_id == '30' || $customer->customer_type_id == '40') {
                        if (empty($type_code_p[0])) {
                            $ship_to_location_name = "";
                        } else {
                            if ($type_code_p[0]->product_type_code == '10') {
                                $ship = CustomerShipSites::join('ptom_order_headers', 'ptom_customer_ship_sites.ship_to_site_id', 'ptom_order_headers.ship_to_site_id', 'left')->join('ptom_consignment_headers', 'ptom_order_headers.order_header_id', 'ptom_consignment_headers.order_header_id', 'left')->where('ptom_consignment_headers.consignment_no', $line->ref_invoice_number)->first();
                                if (empty($ship)) {
                                    $ship_to_location_name = "";
                                } else {
                                    $ship_to_location_name = $ship->ship_to_site_name ?? "";
                                }

                                $bill = Customer::join('ptom_order_headers', 'ptom_customers.bill_to_site_id', 'ptom_order_headers.bill_to_site_id', 'left')->join('ptom_consignment_headers', 'ptom_order_headers.order_header_id', 'ptom_consignment_headers.order_header_id', 'left')->where('ptom_consignment_headers.consignment_no', $line->ref_invoice_number)->first();
                                if (empty($bill)) {
                                    $bill_to_site_name = "";
                                } else {
                                    $bill_to_site_name = $bill->bill_to_site_name ?? "";
                                }
                            } else {
                                if ($line->ref_invoice_number == null || $line->ref_invoice_number == '') {
                                    $ship_to_location_name = "";
                                    $bill_to_site_name = "";
                                } else {
                                    $ship = CustomerShipSites::join('ptom_order_headers', 'ptom_customer_ship_sites.ship_to_site_id', 'ptom_order_headers.ship_to_site_id', 'left')->where('ptom_order_headers.pick_release_no', $line->ref_invoice_number)->first();
                                    if (empty($ship)) {
                                        $ship_to_location_name = "";
                                    } else {
                                        $ship_to_location_name = $ship->ship_to_site_name ?? "";
                                    }

                                    $bill = Customer::join('ptom_order_headers', 'ptom_customers.bill_to_site_id', 'ptom_order_headers.bill_to_site_id', 'left')->where('ptom_order_headers.pick_release_no', $line->ref_invoice_number)->first();
                                    if (empty($bill)) {
                                        $bill_to_site_name = "";
                                    } else {
                                        $bill_to_site_name = $bill->bill_to_site_name ?? "";
                                    }
                                }
                            }
                        }
                    } else {
                        $ship = CustomerShipSites::join('ptom_order_headers', 'ptom_customer_ship_sites.ship_to_site_id', 'ptom_order_headers.ship_to_site_id', 'left')->where('ptom_order_headers.pick_release_no', $line->ref_invoice_number)->first();
                        if (empty($ship)) {
                            $ship_to_location_name = "";
                        } else {
                            $ship_to_location_name = $ship->ship_to_site_name ?? "";
                        }

                        $bill = Customer::join('ptom_order_headers', 'ptom_customers.bill_to_site_id', 'ptom_order_headers.bill_to_site_id', 'left')->where('ptom_order_headers.pick_release_no', $line->ref_invoice_number)->first();
                        if (empty($bill)) {
                            $bill_to_site_name = "";
                        } else {
                            $bill_to_site_name = $bill->bill_to_site_name ?? "";
                        }
                    }
                } else {
                    if ($line->ref_invoice_number == null || $line->ref_invoice_number == '') {
                        $ship_to_location_name = "";
                        $bill_to_site_name = "";
                    } else {
                        $ship = CustomerShipSites::join('ptom_proforma_invoice_headers', 'ptom_customer_ship_sites.ship_to_site_id', 'ptom_proforma_invoice_headers.ship_to_site_id', 'left')->where('ptom_proforma_invoice_headers.pick_release_no', $line->ref_invoice_number)->first();
                        if (empty($ship)) {
                            $ship_to_location_name = "";
                        } else {
                            $ship_to_location_name = $ship->ship_to_site_name ?? "";
                        }

                        $bill = DB::select("SELECT * FROM PTOM_CUSTOMERS INNER JOIN PTOM_PROFORMA_INVOICE_HEADERS ON PTOM_CUSTOMERS.BILL_TO_SITE_ID = PTOM_PROFORMA_INVOICE_HEADERS.BILL_TO_SITE_ID WHERE PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO = '" . $line->ref_invoice_number . "'");
                        if (empty($bill)) {
                            $bill_to_site_name = "";
                        } else {
                            $bill_to_site_name = $bill[0]->bill_to_site_name ?? "";
                        }
                    }
                }

                if ($bill_to_site_name == "") {
                    $bill_to_site_name = $customer->bill_to_site_name;
                }

                if ($ship_to_location_name == "") {
                    $stln = DB::select("SELECT * FROM PTOM_CUSTOMER_SHIP_SITES WHERE CUSTOMER_ID = $header->customer_id AND STATUS = 'Active' AND ATTRIBUTE1 = 'Y'");
                    if (empty($stln)) {
                        $stln2 = DB::select("SELECT * FROM PTOM_CUSTOMER_SHIP_SITES WHERE CUSTOMER_ID = $header->customer_id AND STATUS = 'Active' AND ROWNUM = 1 ORDER BY SITE_NO ASC");
                        $ship_to_location_name = $stln2[0]->ship_to_site_name;
                    } else {
                        $ship_to_location_name = $stln[0]->ship_to_site_name;
                    }
                }

                $insertAR['ship_to_location'] =  $ship_to_location_name;
                $insertAR['bill_to_location'] =  $bill_to_site_name;

                $insertAR['due_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
                $insertAR['currency_code'] =  'THB'; // $header->currency;
                $insertAR['conversion_date'] =  Carbon::parse($header->invoice_date)->format('Y-m-d');
                $insertAR['conversion_type'] =  'User';
                $insertAR['conversion_rate'] =  1; /// $line->conversion_rate ?? "";

                $insertAR['reference'] = $line->ref_invoice_number;

                $insertAR['invoice_total_with_vat'] = round((float)$header->invoice_amount * (float)$line->conversion_rate, 2);
                $insertAR['order_line_id'] =  $line->invoice_line_id;
                $insertAR['line_number'] =  $lineNumber;
                $insertAR['item_code'] =  $line->item_code;

                if ($line->item_code == null || $line->item_code == "") {
                    $description = 'บันทึกลดหนี้';
                } else {
                    $description = $line->item_description ?? null;
                }
                $insertAR['description'] =  $description;

                $insertAR['uom_name'] = $line->uom_code;

                $ProformaInvoiceLine = ProformaInvoiceLines::select('pi_line_id', 'pi_header_id', 'unit_price', 'vat_code', 'item_code')->where('pi_header_id', $ProformaInvoice->pi_header_id)->where('item_code', $line->item_code)->first();
                if (in_array($header->program_code, ['OMP0033', 'OMP0077'])) {
                    $quantity = -1;
                    $unit_selling_price = round((float)$header->invoice_amount * (float)$line->conversion_rate, 7);
                } else {
                    $quantity = (-1) * (float)$line->quantity;
                    $unit_selling_price = optional($ProformaInvoiceLine)->unit_price ?? "";
                }
                $insertAR['quantity'] =  $quantity;
                $insertAR['unit_selling_price'] =  $unit_selling_price;

                $amount = round((float)$insertAR['quantity'] * (float)$insertAR['unit_selling_price'], 2) ?? 0;
                $insertAR['amount'] = $amount;
                $insertAR['tax_code'] = in_array($header->program_code, ['OMP0033', 'OMP0077']) ? null : optional($ProformaInvoiceLine)->vat_code;

                if (empty($ProformaInvoiceLine)) {
                    $pvatper = '';
                } else {
                    $v = DB::select("SELECT PTOM_TAX_CODE_V.PERCENTAGE_RATE FROM PTOM_TAX_CODE_V WHERE TAX_RATE_CODE = '" . $ProformaInvoiceLine->vat_code . "'");
                    $pvatper = $v[0]->percentage_rate ?? 0;
                }
                $percentage_rate = $pvatper;
                //$insertAR['tax_amount'] = ((float)$amount * (float)$percentage_rate) / 100;
                $insertAR['tax_amount'] = in_array($header->program_code, ['OMP0033', 'OMP0077']) ? null : round((float)$line->line_tax_amount * (float)$line->conversion_rate, 2);

                $insertAR['line_amount'] = round((float)$amount + (float)$insertAR['tax_amount'], 2) ?? 0;

                $rec_account_combine = [];
                $rec_account_combine['rec_segment1'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 1, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment2'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 2, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment3'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 3, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment4'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 4, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment5'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 5, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment6'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 6, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment7'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 7, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment8'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 8, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment9'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 9, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment10'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 10, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment11'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 11, $line->ref_invoice_number, $line->item_code);
                $rec_account_combine['rec_segment12'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 12, $line->ref_invoice_number, $line->item_code);
                if (implode(".", array_values($rec_account_combine)) == '...........') {
                    $insertAR['rec_account_combine'] = '';
                } else {
                    $insertAR['rec_account_combine'] = implode(".", array_values($rec_account_combine));
                }
                $insertAR['rec_segment1'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 1, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment2'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 2, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment3'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 3, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment4'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 4, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment5'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 5, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment6'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 6, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment7'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 7, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment8'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 8, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment9'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 9, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment10'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 10, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment11'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 11, $line->ref_invoice_number, $line->item_code);
                $insertAR['rec_segment12'] = $this->getSegmentInvoiceHeaderAndLineCreditNote($header, 12, $line->ref_invoice_number, $line->item_code);

                $rev_account_combine = [];
                $rev_account_combine['rev_segment1'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 1, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment2'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 2, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment3'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 3, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment4'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 4, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment5'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 5, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment6'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 6, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment7'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 7, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment8'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 8, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment9'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 9, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment10'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 10, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment11'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 11, $line->ref_invoice_number, $line->item_code);
                $rev_account_combine['rev_segment12'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 12, $line->ref_invoice_number, $line->item_code);
                if (implode(".", array_values($rev_account_combine)) == '...........') {
                    $insertAR['rev_account_combine'] = '';
                } else {
                    $insertAR['rev_account_combine'] = implode(".", array_values($rev_account_combine));
                }
                $insertAR['rev_segment1'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 1, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment2'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 2, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment3'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 3, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment4'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 4, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment5'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 5, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment6'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 6, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment7'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 7, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment8'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 8, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment9'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 9, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment10'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 10, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment11'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 11, $line->ref_invoice_number, $line->item_code);
                $insertAR['rev_segment12'] = $this->getSegmentInvoiceHeaderRevCreditNote($header, 12, $line->ref_invoice_number, $line->item_code);

                $tax_account_combine = [];
                $tax_account_combine['taxc_segment1'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 1);
                $tax_account_combine['taxc_segment2'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 2);
                $tax_account_combine['taxc_segment3'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 3);
                $tax_account_combine['taxc_segment4'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 4);
                $tax_account_combine['taxc_segment5'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 5);
                $tax_account_combine['taxc_segment6'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 6);
                $tax_account_combine['taxc_segment7'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 7);
                $tax_account_combine['taxc_segment8'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 8);
                $tax_account_combine['taxc_segment9'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 9);
                $tax_account_combine['taxc_segment10'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 10);
                $tax_account_combine['taxc_segment11'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 11);
                $tax_account_combine['taxc_segment12'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 12);
                if (implode(".", array_values($tax_account_combine)) == '...........') {
                    $insertAR['tax_account_combine'] = '';
                } else {
                    $insertAR['tax_account_combine'] = implode(".", array_values($tax_account_combine));
                }
                $insertAR['taxc_segment1'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 1);
                $insertAR['taxc_segment2'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 2);
                $insertAR['taxc_segment3'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 3);
                $insertAR['taxc_segment4'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 4);
                $insertAR['taxc_segment5'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 5);
                $insertAR['taxc_segment6'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 6);
                $insertAR['taxc_segment7'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 7);
                $insertAR['taxc_segment8'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 8);
                $insertAR['taxc_segment9'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 9);
                $insertAR['taxc_segment10'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 10);
                $insertAR['taxc_segment11'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 11);
                $insertAR['taxc_segment12'] = $this->getSegmentInvoiceHeaderTaxCreditNote($line->ref_invoice_number, 12);

                if ($line->program_code == 'OMP0077') {
                    $interface_line_attribute1 = $ProformaInvoice->pi_number;
                    $interface_line_attribute2 = '';
                    $interface_line_attribute3 = Carbon::parse($ProformaInvoice->pi_date)->format('Y-m-d');
                } elseif ($line->programe_code == 'OMP0050') {
                    $order_cliam = OrderHeader::find($line->document_id);
                    if (empty($order_cliam)) {
                        $interface_line_attribute1 = '';
                        $interface_line_attribute3 = '';
                    } else {
                        $interface_line_attribute1 = $order_cliam->prepare_order_number;
                        $interface_line_attribute3 = $order_cliam->order_date;
                    }
                    $interface_line_attribute2 = '';
                } elseif ($line->programe_code == 'OMP0082') {
                    $interface_line_attribute1 = $ProformaInvoice->pi_number;
                    $interface_line_attribute2 = $ProformaInvoice->pi_number;
                    $interface_line_attribute3 = Carbon::parse($ProformaInvoice->pi_date)->format('Y-m-d');
                } else {
                    $ram = RMAModel::where('claim_header_id', $line->document_id)->first();
                    if (empty($ram)) {
                        $interface_line_attribute1 = '';
                        $interface_line_attribute2 = '';
                        $interface_line_attribute3 = '';
                    } else {
                        $interface_line_attribute1 = $ram->rma_number;
                        $interface_line_attribute2 = $line->document_line_id;
                        $interface_line_attribute3 = Carbon::parse($ram->rma_date)->format('Y-m-d');
                    }
                }
                $insertAR['interface_line_attribute1'] = $interface_line_attribute1;
                $insertAR['interface_line_attribute2'] = $interface_line_attribute2;
                $insertAR['interface_line_attribute3'] = $interface_line_attribute3;

                $insertAR['percent'] = '100';
                $insertAR['amount_dis'] = $insertAR['line_amount'] ?? null;
                $insertAR['program_code'] = 'OMP0078';
                $insertAR['created_by'] =  getDefaultData('/users')->user_id;
                $insertAR['last_updated_by'] =  getDefaultData('/users')->user_id;
                $insertAR['web_batch_no'] =  $webbatchno;
                // $insertAR['interface_status'] = 'S';
                $insertAR['product_type_code'] = empty($type_code_p) ? '' : $type_code_p[0]->product_type_code;
                $insertAR['ebs_order_number'] = optional($ebs)->ebs_order_number;
                $insertAR['tax_header_amount'] = $header->total_vat_amount;
                $insertAR['pao_header_amount'] = $header->pao_amount;
                $insertAR['pao_line_amount'] = $line->pao_line_amount;
                $insertAR['tax_rate'] = $percentage_rate;

                if ($insertAR['tax_account_combine'] != '') {
                    if (GLCombinationKFV::where('concatenated_segments', $insertAR['tax_account_combine'])->count() == 0) {
                        $data = [
                            'status' => 'error',
                            'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['tax_account_combine'] . ' นี้ในระบบ',
                        ];
                        return $data;
                    }
                }
                if ($insertAR['rev_account_combine'] != '') {
                    if (GLCombinationKFV::where('concatenated_segments', $insertAR['rev_account_combine'])->count() == 0) {
                        $data = [
                            'status' => 'error',
                            'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['rev_account_combine'] . ' นี้ในระบบ',
                        ];
                        return $data;
                    }
                }
                if ($insertAR['rec_account_combine'] != '') {
                    if (GLCombinationKFV::where('concatenated_segments', $insertAR['rec_account_combine'])->count() == 0) {
                        $data = [
                            'status' => 'error',
                            'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['rec_account_combine'] . ' นี้ในระบบ',
                        ];
                        return $data;
                    }
                }

                if($report){

                    $desc = optional(PtomArDailyAccRptDescV::where('meaning', $insertAR['from_program_code'])->first());
                    $insertAR['report_description'] = $desc->description;
                }

                $report ? ARInterfacesReport::create($insertAR) : ARInterface::create($insertAR);
                $rawcount++;
            }
        }

        $data = [
            'status' => 'success'
        ];

        return $data;
    }

    private function getSegmentInvoiceHeaderTaxCreditNote($ref, $segmentNumber)
    {
        if ($ref == null || $ref == '') {
            return '';
        } else {
            return MappingAccountModel::select("segment{$segmentNumber}")->where('account_code', 'TRX-EXP-Sales Invoice-04')->first()->toArray()["segment{$segmentNumber}"];
        }
    }

    private function getSegmentInvoiceHeaderRevCreditNote($header, $segmentNumber, $ref, $item)
    {
        if ($segmentNumber == 1) {
            if ($header->dr_segment1 == null || $header->dr_segment1 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment1;
                }
            } else {
                return $header->dr_segment1;
            }
        } elseif ($segmentNumber == 2) {
            if ($header->dr_segment2 == null || $header->dr_segment2 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment2;
                }
            } else {
                return $header->dr_segment2;
            }
        } elseif ($segmentNumber == 3) {
            if ($header->dr_segment3 == null || $header->dr_segment3 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment3;
                }
            } else {
                return $header->dr_segment3;
            }
        } elseif ($segmentNumber == 4) {
            if ($header->dr_segment4 == null || $header->dr_segment4 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment4;
                }
            } else {
                return $header->dr_segment4;
            }
        } elseif ($segmentNumber == 5) {
            if ($header->dr_segment5 == null || $header->dr_segment5 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment5;
                }
            } else {
                return $header->dr_segment5;
            }
        } elseif ($segmentNumber == 6) {
            if ($header->dr_segment6 == null || $header->dr_segment6 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment6;
                }
            } else {
                return $header->dr_segment6;
            }
        } elseif ($segmentNumber == 7) {
            if ($header->dr_segment7 == null || $header->dr_segment7 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment7;
                }
            } else {
                return $header->dr_segment7;
            }
        } elseif ($segmentNumber == 8) {
            if ($header->dr_segment8 == null || $header->dr_segment8 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment8;
                }
            } else {
                return $header->dr_segment8;
            }
        } elseif ($segmentNumber == 9) {
            if ($header->dr_segment9 == null || $header->dr_segment9 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment9;
                }
            } else {
                return $header->dr_segment9;
            }
        } elseif ($segmentNumber == 10) {
            if ($header->dr_segment10 == null || $header->dr_segment10 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment10;
                }
            } else {
                return $header->dr_segment10;
            }
        } elseif ($segmentNumber == 11) {
            if ($header->dr_segment11 == null || $header->dr_segment11 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment11;
                }
            } else {
                return $header->dr_segment11;
            }
        } else {
            if ($header->dr_segment12 == null || $header->dr_segment12 == '') {
                $ar = ARInterface::where('invoice_number', $ref)->where('item_code', $item)->first();
                if (empty($ar)) {
                    return '';
                } else {
                    return $ar->rev_segment12;
                }
            } else {
                return $header->dr_segment12;
            }
        }
    }

    private function getSegmentInvoiceHeaderAndLineCreditNote($header, $segmentNumber, $ref, $item)
    {
        $ar = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = '07'");
        if ($segmentNumber == 1) {
            if ($header->cr_segment1 == null || $header->cr_segment1 == '') {
                return $ar[0]->segment1;
            } else {
                return $header->cr_segment1;
            }
        } elseif ($segmentNumber == 2) {
            if ($header->cr_segment2 == null || $header->cr_segment2 == '') {
                return $ar[0]->segment2;
            } else {
                return $header->cr_segment2;
            }
        } elseif ($segmentNumber == 3) {
            if ($header->cr_segment3 == null || $header->cr_segment3 == '') {
                return $ar[0]->segment3;
            } else {
                return $header->cr_segment3;
            }
        } elseif ($segmentNumber == 4) {
            if ($header->cr_segment4 == null || $header->cr_segment4 == '') {
                return $ar[0]->segment4;
            } else {
                return $header->cr_segment4;
            }
        } elseif ($segmentNumber == 5) {
            if ($header->cr_segment5 == null || $header->cr_segment5 == '') {
                return $ar[0]->segment5;
            } else {
                return $header->cr_segment5;
            }
        } elseif ($segmentNumber == 6) {
            if ($header->cr_segment6 == null || $header->cr_segment6 == '') {
                return $ar[0]->segment6;
            } else {
                return $header->cr_segment6;
            }
        } elseif ($segmentNumber == 7) {
            if ($header->cr_segment7 == null || $header->cr_segment7 == '') {
                return $ar[0]->segment7;
            } else {
                return $header->cr_segment7;
            }
        } elseif ($segmentNumber == 8) {
            if ($header->cr_segment8 == null || $header->cr_segment8 == '') {
                return $ar[0]->segment8;
            } else {
                return $header->cr_segment8;
            }
        } elseif ($segmentNumber == 9) {
            if ($header->cr_segment9 == null || $header->cr_segment9 == '') {
                return $ar[0]->segment9;
            } else {
                return $header->cr_segment9;
            }
        } elseif ($segmentNumber == 10) {
            if ($header->cr_segment10 == null || $header->cr_segment10 == '') {
                return $ar[0]->segment10;
            } else {
                return $header->cr_segment10;
            }
        } elseif ($segmentNumber == 11) {
            if ($header->cr_segment11 == null || $header->cr_segment11 == '') {
                return $ar[0]->segment11;
            } else {
                return $header->cr_segment11;
            }
        } else {
            if ($header->cr_segment12 == null || $header->cr_segment12 == '') {
                return $ar[0]->segment12;
            } else {
                return $header->cr_segment12;
            }
        }
    }

    private function queryRMAExport($genIDG, $request, $webbatchno)
    {
        $date = explode('/', $request->date);
        $d = $date[0];
        $m = $date[1];
        $y = $date[2];
        $ymd = $y . '-' . $m . '-' . $d;
        $n = $request->number;

        $RMA = DB::select("
            SELECT * 
            FROM PTOM_CLAIM_HEADERS 
            LEFT JOIN PTOM_CUSTOMERS 
            ON PTOM_CLAIM_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
            WHERE PTOM_CLAIM_HEADERS.RMA_DATE IS NOT NULL 
            AND UPPER(PTOM_CLAIM_HEADERS.STATUS_RMA) = 'CONFIRM' 
            AND (
                PTOM_CLAIM_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_CLAIM_HEADERS.CLOSE_SALE_FLAG IS NULL
            )
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND TO_CHAR(PTOM_CLAIM_HEADERS.RMA_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_CLAIM_HEADERS.CREDIT_NOTE_NUMBER = nvl('$n', PTOM_CLAIM_HEADERS.CREDIT_NOTE_NUMBER)
        ");

        foreach ($RMA as $rma) {
            RMAModel::where('claim_header_id', $rma->claim_header_id)->update(['web_batch_no' => $webbatchno, 'ar_invoice_group_id' => $genIDG]);
        }

        $RMA12 = DB::select("
            SELECT * 
            FROM PTOM_CLAIM_HEADERS 
            LEFT JOIN PTOM_CUSTOMERS 
            ON PTOM_CLAIM_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
            WHERE PTOM_CLAIM_HEADERS.RMA_DATE IS NOT NULL 
            AND UPPER(PTOM_CLAIM_HEADERS.STATUS_RMA) = 'CONFIRM' 
            AND (
                PTOM_CLAIM_HEADERS.CLOSE_SALE_FLAG <> 'Y' 
                OR PTOM_CLAIM_HEADERS.CLOSE_SALE_FLAG IS NULL
            )
            AND UPPER(PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE) = 'EXPORT' 
            AND TO_CHAR(PTOM_CLAIM_HEADERS.RMA_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND PTOM_CLAIM_HEADERS.CREDIT_NOTE_NUMBER = nvl('$n', PTOM_CLAIM_HEADERS.CREDIT_NOTE_NUMBER)
            AND EBS_ORDER_NUMBER IS NULL
        ");

        if (count($RMA12) > 0) {
            $SOInterfaceNo12 = SOInterfaceNo12($webbatchno);
        } else {
            $SOInterfaceNo12['status'] = 'C';
            $SOInterfaceNo12['message'] = '';
        }

        $checkErrNo12 = DB::select("
            SELECT INTERFACE_MSG 
            FROM PTOM_SO_T 
            WHERE WEB_BATCH_NO = '$webbatchno' 
            AND RECORD_STATUS = 'E'
        ");

        if (!empty($checkErrNo12)) {
            $data = [
                'status' => 'error',
                'message' => $checkErrNo12[0]->interface_msg,
            ];

            return $data;
        } else {
            $data = [
                'status' => 'success',
                'message' => '',
            ];
            return $data;
        }
    }

    private function querySOExport($genIDG, $request, $webbatchno)
    {
        $date = explode('/', $request->date);
        $d = $date[0];
        $m = $date[1];
        $y = $date[2];
        $ymd = $y . '-' . $m . '-' . $d;
        $n = $request->number;

        $ProformaInvoiceHeaders = DB::select("
            SELECT * 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd' 
            AND (
                PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                AND CURRENCY = 'THB' 
                AND (
                    CLOSE_SALE_FLAG <> 'Y' 
                    OR CLOSE_SALE_FLAG IS NULL
                ) 
                OR (
                    PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                    AND CURRENCY <> 'THB' 
                    AND (
                        CLOSE_SALE_FLAG <> 'Y' 
                        OR CLOSE_SALE_FLAG IS NULL
                    ) 
                    AND PICK_EXCHANGE_RATE IS NOT NULL
                )
            ) 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND PICK_RELEASE_NO = nvl('$n', PICK_RELEASE_NO)
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        foreach ($ProformaInvoiceHeaders as $p) {
            ProformaInvoiceHeaders::where('pi_header_id', $p->pi_header_id)->update(['web_batch_no' => $webbatchno]);
        }

        $ProformaInvoiceHeaders13 = DB::select("
            SELECT * 
            FROM PTOM_PROFORMA_INVOICE_HEADERS 
            WHERE TO_CHAR(PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = '$ymd' 
            and (
                PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                AND CURRENCY = 'THB' 
                AND (
                    CLOSE_SALE_FLAG <> 'Y'  
                    OR CLOSE_SALE_FLAG IS NULL
                ) 
                or (
                    PICK_RELEASE_APPROVE_DATE IS NOT NULL 
                    AND CURRENCY <> 'THB' 
                    AND (
                        CLOSE_SALE_FLAG <> 'Y'  
                        OR CLOSE_SALE_FLAG IS NULL
                    ) 
                    AND PICK_EXCHANGE_RATE IS NOT NULL)
                ) 
            AND UPPER(PICK_RELEASE_STATUS) = 'CONFIRM' 
            AND PICK_RELEASE_NO = nvl('$n', PICK_RELEASE_NO)
            AND EBS_ORDER_NUMBER IS NULL
            AND NOT EXISTS( 
                SELECT *
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายต่างประเทศ'
            )
        ");

        if (count($ProformaInvoiceHeaders13) > 0) {
            $callNo13 = SOInterfaceNo13($webbatchno);
        } else {
            $callNo13['status'] = 'C';
            $callNo13['message'] = '';
        }

        $checkErrNo13 = DB::select("
            SELECT INTERFACE_MSG
            FROM PTOM_SO_T 
            WHERE WEB_BATCH_NO = '$webbatchno' 
            AND RECORD_STATUS = 'E'
        ");

        if (!empty($checkErrNo13)) {
            $data = [
                'status' => 'error',
                'message' => $checkErrNo13[0]->interface_msg,
            ];

            return $data;
        } else {
            $data = [
                'status' => 'success',
                'message' => '',
            ];
            return $data;
        }
    }

    private function CloseFlagInvoicesExport($genIDG, $header, $webbatchno, $report = false)
    {
        $ebs = ProformaInvoiceHeaders::find($header->pi_header_id);
        $customer = Customers::leftJoin('ptom_customer_type_export', 'ptom_customers.customer_type_id', 'ptom_customer_type_export.customer_type')
            ->where('ptom_customers.customer_id', $header->customer_id)
            ->first(['ptom_customers.customer_number', 'ptom_customers.customer_name', 'ptom_customers.bill_to_site_name', 'ptom_customer_type_export.meaning']);

        $org_id = DB::select("
            SELECT APPS.HR_ORGANIZATION_UNITS_V.ORGANIZATION_ID 
            FROM APPS.HR_ORGANIZATION_UNITS_V 
            WHERE APPS.HR_ORGANIZATION_UNITS_V.NAME = 'การยาสูบแห่งประเทศไทย'
        ");

        $data = ProformaInvoiceLines::where('pi_header_id', $header->pi_header_id)->orderBy('pi_line_id', 'ASC')->get();
        $rawcount = 1;
        foreach ($data as $line) {
            $insertAR = array();
            $insertAR['group_id'] = $genIDG;
            $insertAR['interface_module'] = "AR";
            $insertAR['from_program_code'] = 'OMP0072';
            $insertAR['interface_type'] = 'Invoice';
            $insertAR['order_header_id'] = $header->pi_header_id;
            $insertAR['org_id'] = $org_id[0]->organization_id ?? '';
            $insertAR['operating_unit'] = 'การยาสูบแห่งประเทศไทย';
            $insertAR['batch_source_name'] = 'ระบบขายต่างประเทศ';

            $invoice_type = DB::select("SELECT RECEIVABLES_TRANSACTION_TYPE FROM PTOM_TRANSACTION_TYPES_V WHERE ORDER_TYPE_ID = '" . $header->order_type_id . "'");

            $insertAR['invoice_type'] = ($invoice_type) ? $invoice_type[0]->receivables_transaction_type : "";
            $insertAR['invoice_number'] =  $header->pick_release_no;
            $insertAR['invoice_date'] =  Carbon::parse($header->pick_release_approve_date)->format('Y-m-d');
            $insertAR['gl_date'] =  Carbon::parse($header->pick_exchange_date)->format('Y-m-d');
            $insertAR['customer_number'] =  $customer->customer_number;
            $insertAR['customer_name'] =  $customer->customer_name;
            $insertAR['bill_to_location'] =  $customer->bill_to_site_name ?? "";

            if ($header->ship_to_site_id == null || $header->ship_to_site_id == '') {
                $stl = '';
            } else {
                $ship_to_location =  DB::select("SELECT SHIP_TO_SITE_NAME FROM PTOM_CUSTOMER_SHIP_SITES WHERE SHIP_TO_SITE_ID = '" . $header->ship_to_site_id . "'");
                $stl = $ship_to_location[0]->ship_to_site_name ?? "";
            }
            $insertAR['ship_to_location'] =  $stl;

            $term_name =  DB::select("SELECT PTOM_TERMS_V.NAME FROM PTOM_TERMS_V WHERE TERM_ID = '" . $header->term_id . "'") ?? "";
            $insertAR['term_name'] =  (is_array($term_name)) ? $term_name[0]->name : "";

            $insertAR['due_date'] =  Carbon::parse($header->payment_duedate)->format('Y-m-d');
            $insertAR['currency_code'] =  'THB'; // $header->currency;
            $insertAR['conversion_date'] =  Carbon::parse($header->pick_exchange_date)->format('Y-m-d');
            $insertAR['conversion_type'] =  'User';
            $insertAR['conversion_rate'] =  1; // $header->pick_exchange_rate ?? "";

            if ($line->promotion_id != null || $line->promotion_id != '') {
                $insertAR['comments'] =  'Promotion';
            } else {
                $insertAR['comments'] =  '';
            }

            $insertAR['invoice_total_with_vat'] =  round((float)$header->grand_total * (float)$header->pick_exchange_rate, 2);
            $insertAR['order_line_id'] =  $line->pi_line_id;
            $insertAR['line_number'] =  $rawcount;
            $insertAR['item_code'] =  $line->item_code;
            $insertAR['description'] =  $line->item_description;
            $insertAR['uom_name'] = $line->uom_code;
            $insertAR['quantity'] =  $line->approve_quantity;
            $insertAR['unit_selling_price'] =  round((float)$line->unit_price * (float)$header->pick_exchange_rate, 7); // $line->unit_price;

            $amount = $insertAR['quantity'] * $insertAR['unit_selling_price'] ?? 0;
            $insertAR['amount'] = $amount;

            if (empty($ebs)) {
                $pvatper = '';
            } else {
                $v = DB::select("
                    SELECT PTOM_TAX_CODE_V.PERCENTAGE_RATE 
                    FROM PTOM_TAX_CODE_V 
                    WHERE TAX_RATE_CODE = '" . $ebs->vat_code . "'
                ");
                $pvatper = $v[0]->percentage_rate ?? 0;
            }
            $percentage_rate = $pvatper;

            $insertAR['tax_code'] = $line->vat_code ?? "";
            $insertAR['tax_amount'] = round((float)$line->tax_amount * (float)$header->pick_exchange_rate, 2); // $line->tax_amount;
            $insertAR['line_amount'] = $insertAR['amount'] + $insertAR['tax_amount'] ?? 0;

            $rec_segment = [];
            $rec_segment['rec_segment1'] = $this->getSegmentInvoiceHeaderAndLine($header, 1);
            $rec_segment['rec_segment2'] = $this->getSegmentInvoiceHeaderAndLine($header, 2);
            $rec_segment['rec_segment3'] = $this->getSegmentInvoiceHeaderAndLine($header, 3);
            $rec_segment['rec_segment4'] = $this->getSegmentInvoiceHeaderAndLine($header, 4);
            $rec_segment['rec_segment5'] = $this->getSegmentInvoiceHeaderAndLine($header, 5);
            $rec_segment['rec_segment6'] = $this->getSegmentInvoiceHeaderAndLine($header, 6);
            $rec_segment['rec_segment7'] = $this->getSegmentInvoiceHeaderAndLine($header, 7);
            $rec_segment['rec_segment8'] = $this->getSegmentInvoiceHeaderAndLine($header, 8);
            $rec_segment['rec_segment9'] = $this->getSegmentInvoiceHeaderAndLine($header, 9);
            $rec_segment['rec_segment10'] = $this->getSegmentInvoiceHeaderAndLine($header, 10);
            $rec_segment['rec_segment11'] = $this->getSegmentInvoiceHeaderAndLine($header, 11);
            $rec_segment['rec_segment12'] = $this->getSegmentInvoiceHeaderAndLine($header, 12);
            if (implode(".", array_values($rec_segment)) == '...........') {
                $insertAR['rec_account_combine'] = '';
            } else {
                $insertAR['rec_account_combine'] = implode(".", array_values($rec_segment));
            }
            $insertAR['rec_segment1'] = $this->getSegmentInvoiceHeaderAndLine($header, 1);
            $insertAR['rec_segment2'] = $this->getSegmentInvoiceHeaderAndLine($header, 2);
            $insertAR['rec_segment3'] = $this->getSegmentInvoiceHeaderAndLine($header, 3);
            $insertAR['rec_segment4'] = $this->getSegmentInvoiceHeaderAndLine($header, 4);
            $insertAR['rec_segment5'] = $this->getSegmentInvoiceHeaderAndLine($header, 5);
            $insertAR['rec_segment6'] = $this->getSegmentInvoiceHeaderAndLine($header, 6);
            $insertAR['rec_segment7'] = $this->getSegmentInvoiceHeaderAndLine($header, 7);
            $insertAR['rec_segment8'] = $this->getSegmentInvoiceHeaderAndLine($header, 8);
            $insertAR['rec_segment9'] = $this->getSegmentInvoiceHeaderAndLine($header, 9);
            $insertAR['rec_segment10'] = $this->getSegmentInvoiceHeaderAndLine($header, 10);
            $insertAR['rec_segment11'] = $this->getSegmentInvoiceHeaderAndLine($header, 11);
            $insertAR['rec_segment12'] = $this->getSegmentInvoiceHeaderAndLine($header, 12);

            $rev_segment = [];
            $rev_segment['rev_segment1'] = $this->getSegmentInvoiceHeaderRev($header, 1, $line->item_id);
            $rev_segment['rev_segment2'] = $this->getSegmentInvoiceHeaderRev($header, 2, $line->item_id);
            $rev_segment['rev_segment3'] = $this->getSegmentInvoiceHeaderRev($header, 3, $line->item_id);
            $rev_segment['rev_segment4'] = $this->getSegmentInvoiceHeaderRev($header, 4, $line->item_id);
            $rev_segment['rev_segment5'] = $this->getSegmentInvoiceHeaderRev($header, 5, $line->item_id);
            $rev_segment['rev_segment6'] = $this->getSegmentInvoiceHeaderRev($header, 6, $line->item_id);
            $rev_segment['rev_segment7'] = $this->getSegmentInvoiceHeaderRev($header, 7, $line->item_id);
            $rev_segment['rev_segment8'] = $this->getSegmentInvoiceHeaderRev($header, 8, $line->item_id);
            $rev_segment['rev_segment9'] = $this->getSegmentInvoiceHeaderRev($header, 9, $line->item_id);
            $rev_segment['rev_segment10'] = $this->getSegmentInvoiceHeaderRev($header, 10, $line->item_id);
            $rev_segment['rev_segment11'] = $this->getSegmentInvoiceHeaderRev($header, 11, $line->item_id);
            $rev_segment['rev_segment12'] = $this->getSegmentInvoiceHeaderRev($header, 12, $line->item_id);
            if (implode(".", array_values($rev_segment)) == '...........') {
                $insertAR['rev_account_combine'] = '';
            } else {
                $insertAR['rev_account_combine'] = implode(".", array_values($rev_segment));
            }
            $insertAR['rev_segment1'] = $this->getSegmentInvoiceHeaderRev($header, 1, $line->item_id);
            $insertAR['rev_segment2'] = $this->getSegmentInvoiceHeaderRev($header, 2, $line->item_id);
            $insertAR['rev_segment3'] = $this->getSegmentInvoiceHeaderRev($header, 3, $line->item_id);
            $insertAR['rev_segment4'] = $this->getSegmentInvoiceHeaderRev($header, 4, $line->item_id);
            $insertAR['rev_segment5'] = $this->getSegmentInvoiceHeaderRev($header, 5, $line->item_id);
            $insertAR['rev_segment6'] = $this->getSegmentInvoiceHeaderRev($header, 6, $line->item_id);
            $insertAR['rev_segment7'] = $this->getSegmentInvoiceHeaderRev($header, 7, $line->item_id);
            $insertAR['rev_segment8'] = $this->getSegmentInvoiceHeaderRev($header, 8, $line->item_id);
            $insertAR['rev_segment9'] = $this->getSegmentInvoiceHeaderRev($header, 9, $line->item_id);
            $insertAR['rev_segment10'] = $this->getSegmentInvoiceHeaderRev($header, 10, $line->item_id);
            $insertAR['rev_segment11'] = $this->getSegmentInvoiceHeaderRev($header, 11, $line->item_id);
            $insertAR['rev_segment12'] = $this->getSegmentInvoiceHeaderRev($header, 12, $line->item_id);

            $taxc_segment = [];
            $taxc_segment['taxc_segment1'] = $this->getSegmentInvoiceHeaderTax(1); //0
            $taxc_segment['taxc_segment2'] = $this->getSegmentInvoiceHeaderTax(2); //1
            $taxc_segment['taxc_segment3'] = $this->getSegmentInvoiceHeaderTax(3); //2
            $taxc_segment['taxc_segment4'] = $this->getSegmentInvoiceHeaderTax(4); //3
            $taxc_segment['taxc_segment5'] = $this->getSegmentInvoiceHeaderTax(5); //4
            $taxc_segment['taxc_segment6'] = $this->getSegmentInvoiceHeaderTax(6); //5
            $taxc_segment['taxc_segment7'] = $this->getSegmentInvoiceHeaderTax(7); //6
            $taxc_segment['taxc_segment8'] = $this->getSegmentInvoiceHeaderTax(8); //7
            $taxc_segment['taxc_segment9'] = $this->getSegmentInvoiceHeaderTax(9); //8
            $taxc_segment['taxc_segment10'] = $this->getSegmentInvoiceHeaderTax(10); //9
            $taxc_segment['taxc_segment11'] = $this->getSegmentInvoiceHeaderTax(11); //10
            $taxc_segment['taxc_segment12'] = $this->getSegmentInvoiceHeaderTax(12); //11
            if (implode(".", array_values($taxc_segment)) == '...........') {
                $insertAR['tax_account_combine'] = '';
            } else {
                $insertAR['tax_account_combine'] = implode(".", array_values($taxc_segment));
            }
            $insertAR['taxc_segment1'] = $taxc_segment['taxc_segment1'];
            $insertAR['taxc_segment2'] = $taxc_segment['taxc_segment2'];
            $insertAR['taxc_segment3'] = $taxc_segment['taxc_segment3'];
            $insertAR['taxc_segment4'] = $taxc_segment['taxc_segment4'];
            $insertAR['taxc_segment5'] = $taxc_segment['taxc_segment5'];
            $insertAR['taxc_segment6'] = $taxc_segment['taxc_segment6'];
            $insertAR['taxc_segment7'] = $taxc_segment['taxc_segment7'];
            $insertAR['taxc_segment8'] = $taxc_segment['taxc_segment8'];
            $insertAR['taxc_segment9'] = $taxc_segment['taxc_segment9'];
            $insertAR['taxc_segment10'] = $taxc_segment['taxc_segment10'];
            $insertAR['taxc_segment11'] = $taxc_segment['taxc_segment11'];
            $insertAR['taxc_segment12'] = $taxc_segment['taxc_segment12'];

            $insertAR['interface_line_attribute1'] = $header->pi_number;
            $insertAR['interface_line_attribute2'] = $line->line_number;
            $insertAR['interface_line_attribute3'] = Carbon::parse($header->pi_date)->format('Y-m-d');
            $insertAR['interface_line_attribute4'] = $header->pick_exchange_rate;
            $insertAR['interface_line_attribute5'] = Carbon::parse($header->pick_exchange_date)->format('Y-m-d');
            $insertAR['percent'] = '100';
            $insertAR['amount_dis'] = $insertAR['line_amount'] ?? null;
            $insertAR['program_code'] = 'OMP0078';
            $insertAR['created_by'] =  getDefaultData('/users')->user_id;
            $insertAR['last_updated_by'] =  getDefaultData('/users')->user_id;
            $insertAR['web_batch_no'] =  $webbatchno;
            $insertAR['tax_header_amount'] = $ebs->tax;
            $insertAR['tax_rate'] = $percentage_rate;
            $insertAR['payment_type_code'] = $ebs->payment_type_code;
            // $insertAR['interface_status'] = 'S';

            $type_code_p = DB::select("
                SELECT PRODUCT_TYPE_CODE 
                FROM PTOM_SEQUENCE_ECOMS
                WHERE ITEM_ID = '$line->item_id'
            ");
            $insertAR['product_type_code'] = empty($type_code_p) ? '' : $type_code_p[0]->product_type_code;

            $insertAR['ebs_order_number'] = $ebs->ebs_order_number;

            if ($insertAR['tax_account_combine'] != '') {
                if (GLCombinationKFV::where('concatenated_segments', $insertAR['tax_account_combine'])->count() == 0) {
                    $data = [
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['tax_account_combine'] . ' นี้ในระบบ',
                    ];
                    return $data;
                }
            }
            if ($insertAR['rev_account_combine'] != '') {
                if (GLCombinationKFV::where('concatenated_segments', $insertAR['rev_account_combine'])->count() == 0) {
                    $data = [
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['rev_account_combine'] . ' นี้ในระบบ',
                    ];
                    return $data;
                }
            }
            if ($insertAR['rec_account_combine'] != '') {
                if (GLCombinationKFV::where('concatenated_segments', $insertAR['rec_account_combine'])->count() == 0) {
                    $data = [
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูล CCID ' . $insertAR['rec_account_combine'] . ' นี้ในระบบ',
                    ];
                    return $data;
                }
            }

            if($report){

                $desc = optional(PtomArDailyAccRptDescV::where('meaning', $insertAR['from_program_code'])->first());
                $insertAR['report_description'] = $desc->description;
            }

            $report ? ARInterfacesReport::create($insertAR) : ARInterface::create($insertAR);
            $rawcount++;
        }
        $data = [
            'status' => 'success'
        ];

        return $data;
    }

    private function getSegmentInvoiceHeaderAndLine($header, $segmentNumber)
    {
        if ($segmentNumber == 1 || $segmentNumber == 2 || $segmentNumber == 3 || $segmentNumber == 4 || $segmentNumber == 5 || $segmentNumber == 6 || $segmentNumber == 7 || $segmentNumber == 8 || $segmentNumber == 11 || $segmentNumber == 12) {
            // if ($header->payment_type_code == 10) {
            //     return MappingAccountModel::select("segment{$segmentNumber}")->where('account_code', 'TRX-EXP-Sales Invoice-02')->first()->toArray()["segment{$segmentNumber}"];
            // } else {
                return MappingAccountModel::select("segment{$segmentNumber}")->where('account_code', 'TRX-EXP-Sales Invoice-01')->first()->toArray()["segment{$segmentNumber}"];
            // }
        } else {
            if ($header->order_type_id == null || $header->order_type_id == '') {
                return '';
            } else {
                // if ($header->payment_type_code == 10) {
                //     $d = DB::select("SELECT RECEIVABLES_TRANSACTION_TYPE FROM PTOM_TRANSACTION_TYPES_V WHERE ORDER_TYPE_ID = '$header->order_type_id'");
                //     if (!empty($d)) {
                //         if ($segmentNumber == 9) {
                //             $dd = DB::select("SELECT CLEARING_ACCOUNT_SEGMENT9 FROM PTOM_AR_TRAN_TYPES_V WHERE NAME = '" . $d[0]->receivables_transaction_type . "'");
                //             if (empty($dd)) {
                //                 return '';
                //             } else {
                //                 return $dd[0]->clearing_account_segment9;
                //             }
                //         } else {
                //             $dd = DB::select("SELECT CLEARING_ACCOUNT_SEGMENT10 FROM PTOM_AR_TRAN_TYPES_V WHERE NAME = '" . $d[0]->receivables_transaction_type . "'");
                //             if (empty($dd)) {
                //                 return '';
                //             } else {
                //                 return $dd[0]->clearing_account_segment10;
                //             }
                //         }
                //     } else {
                //         return '';
                //     }
                // } else {
                    $d = DB::select("SELECT RECEIVABLES_TRANSACTION_TYPE FROM PTOM_TRANSACTION_TYPES_V WHERE ORDER_TYPE_ID = '$header->order_type_id'");
                    if (!empty($d)) {
                        if ($segmentNumber == 9) {
                            $dd = DB::select("SELECT RECEIVABLE_ACCOUNT_SEGMENT9 FROM PTOM_AR_TRAN_TYPES_V WHERE NAME = '" . $d[0]->receivables_transaction_type . "'");
                            if (empty($dd)) {
                                return '';
                            } else {
                                return $dd[0]->receivable_account_segment9;
                            }
                        } else {
                            $dd = DB::select("SELECT RECEIVABLE_ACCOUNT_SEGMENT10 FROM PTOM_AR_TRAN_TYPES_V WHERE NAME = '" . $d[0]->receivables_transaction_type . "'");
                            if (empty($dd)) {
                                return '';
                            } else {
                                return $dd[0]->receivable_account_segment10;
                            }
                        }
                    } else {
                        return '';
                    }
                // }
            }
        }
    }
    private function getSegmentInvoiceHeaderRev($header, $segmentNumber, $item)
    {
        if ($segmentNumber == 1 || $segmentNumber == 2 || $segmentNumber == 3 || $segmentNumber == 4 || $segmentNumber == 8 || $segmentNumber == 11 || $segmentNumber == 12) {
            return MappingAccountModel::select("segment{$segmentNumber}")->where('account_code', 'TRX-EXP-Sales Invoice-03')->first()->toArray()["segment{$segmentNumber}"];
        } elseif ($segmentNumber == 5) {
            $m = Carbon::parse($header->pick_exchange_date)->format('m');
            $y = Carbon::parse($header->pick_exchange_date)->format('Y');
            $yy = substr($y + 543, 2);
            if ($m == 10 || $m == 11 || $m == 12) {
                $yyy = $yy + 1;
            } else {
                $yyy = $yy;
            }
            return $yyy;
        } elseif ($segmentNumber == 6 || $segmentNumber == 7 || $segmentNumber == 9) {
            $d = DB::select("SELECT RECEIVABLES_TRANSACTION_TYPE FROM PTOM_TRANSACTION_TYPES_V WHERE ORDER_TYPE_ID = '$header->order_type_id'");
            if (empty($d)) {
                return '';
            } else {
                if ($segmentNumber == 9) {
                    $dd = DB::select("SELECT REVENUE_ACCOUNT_SEGMENT9 FROM PTOM_AR_TRAN_TYPES_V WHERE NAME = '" . $d[0]->receivables_transaction_type . "'");
                    if (empty($dd)) {
                        return '';
                    } else {
                        return $dd[0]->revenue_account_segment9;
                    }
                } else if ($segmentNumber == 7) {
                    $dd = DB::select("SELECT REVENUE_ACCOUNT_SEGMENT7 FROM PTOM_AR_TRAN_TYPES_V WHERE NAME = '" . $d[0]->receivables_transaction_type . "'");
                    if (empty($dd)) {
                        return '';
                    } else {
                        return $dd[0]->revenue_account_segment7;
                    }
                } else {
                    $dd = DB::select("SELECT REVENUE_ACCOUNT_SEGMENT6 FROM PTOM_AR_TRAN_TYPES_V WHERE NAME = '" . $d[0]->receivables_transaction_type . "'");
                    if (empty($dd)) {
                        return '';
                    } else {
                        return $dd[0]->revenue_account_segment6;
                    }
                }
            }
        } else {
            $i = DB::select("SELECT SUB_ACCOUNT_CODE FROM PTOM_SEQUENCE_ECOMS WHERE ITEM_ID = '$item'");
            if (empty($i)) {
                return '';
            } else {
                return $i[0]->sub_account_code;
            }
        }
    }

    private function getSegmentInvoiceHeaderTax($segmentNumber)
    {
        return MappingAccountModel::select("segment{$segmentNumber}")->where('account_code', 'TRX-EXP-Sales Invoice-04')->first()->toArray()["segment{$segmentNumber}"];
    }

    private function updateARGroupId($type, $item, $group_id)
    {
        if($type == 'PROFORMA'){
            ProformaInvoiceHeaders::where('pi_header_id', $item->pi_header_id)->update(['ar_invoice_group_id' => $group_id]);
        }elseif($type == 'GL'){
            ProformaInvoiceHeaders::where('pi_header_id', $item->pi_header_id)->update(['gl_group_id' => $group_id]);
        } else {
            InvoiceHeaders::where('invoice_headers_id', $item->invoice_headers_id)->update(['ar_invoice_group_id' => $group_id]);
        }
    }

    private function callTestGL()
    {
        dd('test');
        $d = '26';
        $m = '11';
        $y = '2022';
        $ymd = $y . '-' . $m . '-' . $d;
        $n = 'IV2211009';

        $glData = DB::table('PTOM_PROFORMA_INVOICE_HEADERS AS PROF')
        ->where('PROF.CURRENCY', '<>', 'THB')
        ->where('PROF.PAYMENT_TYPE_CODE', '=', '10')
        ->whereRaw("UPPER(PROF.PICK_RELEASE_STATUS) = 'CONFIRM'")
        ->whereRaw("
            PICK_RELEASE_APPROVE_DATE IS NOT NULL 
            AND (
                CLOSE_SALE_FLAG <> 'Y' 
                OR CLOSE_SALE_FLAG IS NULL
            ) 
            AND PICK_EXCHANGE_RATE IS NOT NULL
        ")
        ->whereRaw("TO_CHAR(PROF.PICK_EXCHANGE_DATE, 'YYYY-MM-DD') = ?", [$ymd])
        ->when($n, function($query) use ($n) {
            return $query->where('PROF.PICK_RELEASE_NO', '=', $n);
        })
        ->get();

        $genIDG = $glData->count() ? $glData[0]->ar_invoice_group_id : getGroupID();
        $webbatchno = $genIDG.'-'.uniqid(); // '20221214112801-639fefb76971b';

        foreach ($glData as $row => $header) {
            $this->updateARGroupId('GL', $header, $genIDG);
            $insertData = $this->insertGLExport($genIDG, $header, $webbatchno);
            if ($insertData['status'] == 'error') {
                return response()->json([
                    'status' => 'error',
                    'msg' => $insertData['message']
                ]);
            }
        }

        // dd($glData, $genIDG, $webbatchno);

        if(!!($glData->count())){
            //// call package
            $result = \App\Repositories\OM\InterfaceRepo::interfaceGainLoss($webbatchno);

            $checkGainLoss = DB::table('PTOM_GL_INTERFACES')
            ->where('WEB_BATCH_NO', '=', $webbatchno)
            ->where('INTERFACE_STATUS', '=', 'E')
            ->get('INTERFACED_MSG');

            if (!!($checkGainLoss->count())) {
                return response()->json([
                    'status' => 'error',
                    'msg' => $checkGainLoss[0]->interfaced_msg,
                ]);
            }
        }
 
        ProformaInvoiceHeaders::where('ar_invoice_group_id', $genIDG)->update(['close_sale_flag' => 'Y', 'close_sale_status' => 'S']);

        $test = ProformaInvoiceHeaders::where('ar_invoice_group_id', $genIDG)->get();

        dd($glData, $genIDG, $webbatchno, $test);
    }
}
