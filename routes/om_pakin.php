<?php

use App\Models\OM\Rma\Domestic\PtomClaimHeaders;
use App\Models\OM\Rma\Domestic\PtomClaimLines;
use App\Models\OM\Rma\Domestic\PtomOrderHeaders;
use App\Models\OM\Rma\Domestic\PtomOrderLines;
use App\Models\OM\Rma\Domestic\PtomConsignmentHeaders;
use App\Models\OM\Rma\Domestic\PtomConsignmentLines;
use App\Models\OM\Rma\Export\PtomTransactionTypeAllV;
use App\Models\OM\Rma\PtomUomV;
use App\Models\OM\Rma\Customers;
use App\Models\OM\Rma\PtomCustomerContractGroups;
use App\Models\OM\Rma\PtomOutstandingDebtDomV;
use App\Models\OM\Rma\PtomOutstandingDebtExpV;
use App\Models\OM\Rma\PtomInvoiceHeaders;
use App\Models\OM\Rma\PtomInvoiceLines;
use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Arr;
use App\Http\Controllers\OM\RmaDomesticController;
use App\Http\Controllers\OM\Api\RmaDomesticController as ApiRmaDomesticController;
use App\Http\Controllers\OM\RmaExportController;
use App\Http\Controllers\OM\Api\RmaExportController as ApiRmaExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
    Route::prefix('rma')->name('rma.')->group(function (){

        Route::prefix('demestic')->name('domestic.')->group(function (){
            // Domestic
            Route::get('get-by-number',[ApiRmaDomesticController::class,'getByNumber'])->name('get-by-number');
            Route::get('get-by-invoice',[ApiRmaDomesticController::class,'getByInvoice'])->name('get-by-invoice');
            Route::get('get-by-customer',[ApiRmaDomesticController::class,'getByCustomer'])->name('get-by-customer');
            Route::get('get-number-list', [ApiRmaDomesticController::class, 'getNumberList'])->name('get-number-list');
            Route::get('get-invoice-list', [ApiRmaDomesticController::class, 'getInvoiceList'])->name('get-invoice-list');
            Route::get('get-number-only',[ApiRmaDomesticController::class,'getNumberOnly'])->name('get-number-only');
            Route::get('get-invoice-only',[ApiRmaDomesticController::class,'getInvoiceOnly'])->name('get-invoice-only');
            Route::get('get-customer-only',[ApiRmaDomesticController::class,'getCustomerOnly'])->name('get-customer-only');
            Route::get('get-new-number',[ApiRmaDomesticController::class,'getNewNumber'])->name('get-new-number');
            Route::get('get-lines',[ApiRmaDomesticController::class,'getLines'])->name('get-lines');
            Route::get('get-invoice-lines',[ApiRmaDomesticController::class,'getInvoiceLines'])->name('get-invoice-lines');
            Route::get('get-previous-rma',[ApiRmaDomesticController::class,'getPreviousRma'])->name('get-previous-rma');
            Route::get('convert-unit',[ApiRmaDomesticController::class,'convertUnit'])->name('convert-unit');
            Route::patch('create-rma',[ApiRmaDomesticController::class,'createRma'])->name('create-rma');
            Route::patch('update-rma',[ApiRmaDomesticController::class,'updateRma'])->name('update-rma');
            Route::patch('confirm-rma',[ApiRmaDomesticController::class,'confirmRma'])->name('confirm-rma');
            Route::get('cancel-rma',[ApiRmaDomesticController::class,'cancelRma'])->name('cancel-rma');
        });

        Route::prefix('export')->name('export.')->group(function (){
            // Export
            Route::get('get-by-number',[ApiRmaExportController::class,'getByNumber'])->name('get-by-number');
            Route::get('get-by-invoice',[ApiRmaExportController::class,'getByInvoice'])->name('get-by-invoice');
            Route::get('get-by-customer',[ApiRmaExportController::class,'getByCustomer'])->name('get-by-customer');
            Route::get('get-number-only',[ApiRmaExportController::class,'getNumberOnly'])->name('get-number-only');
            Route::get('get-invoice-only',[ApiRmaExportController::class,'getInvoiceOnly'])->name('get-invoice-only');
            Route::get('get-customer-only',[ApiRmaExportController::class,'getCustomerOnly'])->name('get-customer-only');
            Route::get('get-new-number',[ApiRmaExportController::class,'getNewNumber'])->name('get-new-number');
            Route::get('get-lines',[ApiRmaExportController::class,'getLines'])->name('get-lines');
            Route::get('get-invoice-lines',[ApiRmaExportController::class,'getInvoiceLines'])->name('get-invoice-lines');
            Route::get('get-previous-rma',[ApiRmaExportController::class,'getPreviousRma'])->name('get-previous-rma');
            Route::get('convert-unit',[ApiRmaExportController::class,'convertUnit'])->name('convert-unit');
            Route::patch('create-rma',[ApiRmaExportController::class,'createRma'])->name('create-rma');
            Route::patch('update-rma',[ApiRmaExportController::class,'updateRma'])->name('update-rma');
            Route::patch('confirm-rma',[ApiRmaExportController::class,'confirmRma'])->name('confirm-rma');
            Route::get('cancel-rma',[ApiRmaExportController::class,'cancelRma'])->name('cancel-rma');
        });
    });
});

Route::middleware(['auth'])->group(function (){
    Route::get('rma-domestic',[RmaDomesticController::class,'index'])->name('rma-domestic.index');
    Route::get('rma-export',[RmaExportController::class,'index'])->name('rma-export.index');
    Route::get('test',function(){
        $orders = \App\Models\OM\Rma\Domestic\PtomOrderHeaders::select(
            'order_header_id',
            'customer_id',
            'PICK_RELEASE_NO',
            'PICK_RELEASE_APPROVE_DATE',
            'PICK_RELEASE_STATUS')
            ->whereHas('customer',function ($q){
            $q->whereNotIn('customer_type_id',[30,40]);
        })->where('pick_release_status','Confirm')->get();

        return json_decode($orders);
    });

    Route::get('export-newNumber',function (){
        $numbers = \App\Models\OM\Rma\Export\PtomProformaInvoiceLines::from('ptom_claim_headers pch')
            ->join('ptom_customer_ship_sites pcss','pch.ship_to_site_id','pcss.ship_to_site_id')
            ->where('pch.sales_type','EXPORT')
            ->whereNotNull('pch.rma_number')
            ->orderBy('pch.rma_number','desc')
            ->get();

        return $numbers;
    });

    Route::get('domestic-newNumber',function (){
        $numbers = PtomClaimHeaders::from('ptom_claim_headers pch')
            ->join('ptom_customer_ship_sites pcss','pch.ship_to_site_id','pcss.ship_to_site_id')
            ->where('pch.sales_type','DOMESTIC')
            ->whereNotNull('pch.rma_number')
            ->orderBy('pch.rma_number','desc')
            ->get([
                'pch.claim_header_id'
                ,'pch.invoice_id'
                ,'pch.invoice_date'
                ,'pch.customer_id'
                ,'pch.source_system'
                ,'pch.remark_source_system'
                ,'pcss.ship_to_site_name'
                ,'pcss.province_name'
                ,'pch.rma_number'
                ,'pch.rma_date'
                ,'pch.status_rma'
                ,'pch.SYMPTOM_DESCRIPTION'
                ,'pch.credit_note_number'
            ]);
        return $numbers;
    });

    Route::get('join',function (){
        $invoices = PtomOrderHeaders::from('ptom_order_headers as poh')
            ->join('ptom_customers as pc','poh.customer_id','=','pc.customer_id')
            ->where('poh.pick_release_status','Confirm')
            ->first([
                'poh.customer_id',
                'pc.customer_number',
                'pc.customer_name',
                'poh.pick_release_no',
                'poh.pick_release_approve_date',
                'poh.pick_release_status'
                ]);

        return $invoices;
    });

    Route::get('getLatestHeaderID',function (){
        $lastHeader = PtomClaimHeaders::select('claim_header_id')->latest('claim_header_id')->first();
        return json_encode($lastHeader->claim_header_id);
    });

    Route::get('claim',function (){
        $numbers = PtomClaimHeaders::from('ptom_claim_headers pch')
            ->join('ptom_customer_ship_sites pcss','pch.ship_to_site_id','pcss.ship_to_site_id')
            ->where('pch.sales_type','DOMESTIC')
            ->first([
                'pch.claim_header_id',
                'pch.invoice_id',
                'pch.invoice_date',
                'pch.customer_id',
                'pch.source_system',
                'pch.remark_source_system',
                'pcss.ship_to_site_name',
                'pch.rma_number',
                'pch.rma_date',
                'pch.status_rma',
                'pch.claim_cancel_reason'
            ]);
        return response()->json([$numbers]);
    });

    Route::get('invoice',function (){
        $invoices = PtomOrderHeaders::from('PTOM_ORDER_HEADERS POH')
            ->join('PTOM_CUSTOMER_SHIP_SITES PCSS' , 'POH.SHIP_TO_SITE_ID' , 'PCSS.SHIP_TO_SITE_ID')
            ->where('POH.PICK_RELEASE_STATUS','Confirm')
            ->where('POH.CUSTOMER_ID',225)
            ->orderBy('POH.PICK_RELEASE_NO')
            ->first([
                'POH.ORDER_HEADER_ID',
                'POH.CUSTOMER_ID',
                'POH.PICK_RELEASE_NO',
                'POH.PICK_RELEASE_APPROVE_DATE',
                'POH.PICK_RELEASE_STATUS',
                'POH.SOURCE_SYSTEM',
                'POH.REMARK_SOURCE_SYSTEM',
                'PCSS.SHIP_TO_SITE_NAME'
            ]);
        return response()->json([$invoices]);
    });

    Route::get('getLines/{id}',function ($id){
        $user =  getDefaultData('/users');
        $userOrgID = $user->organization_id;
        $fromUnit = 'CGC';
        $toUnit = 'CG2';
        $lines = \App\Models\OM\Rma\Domestic\PtomClaimLines::from('PTOM_CLAIM_LINES PCL')
            ->select(
                'PCL.CLAIM_LINE_ID'
                ,'PCL.CLAIM_HEADER_ID'
                ,'PCL.RMA_LINE_NO'
                ,'PCL.ITEM_ID'
                ,'PCL.ITEM_CODE'
                ,'PCL.ITEM_DESCRIPTION'
                ,'PCL.ORDER_LINE_ID'
                ,'POL.ORDER_LINE_ID'
                ,'POL.APPROVE_CARDBOARDBOX'
                ,'POL.APPROVE_CARTON'
                ,'PCL.RMA_QUANTITY_CBB'
                ,'PCL.RMA_QUANTITY_CARTON'
                ,'PCL.RMA_QUANTITY_PACK'
                ,'PCL.RMA_QUANTITY'
                ,'PCL.RMA_UOM_CODE'
                ,'PCL.ENTER_RMA_QUANTITY'
                ,'PCL.ENTER_RMA_UOM'
            )
            ->join('PTOM_ORDER_LINES POL','PCL.ORDER_LINE_ID','POL.ORDER_LINE_ID')
            ->where('PCL.CLAIM_HEADER_ID',$id)
            ->get();

        return $lines;
    });

    Route::get('getLinesSql/{id}',function ($id){
        $user =  getDefaultData('/users');
        $userOrgID = $user->organization_id;
        $fromUnit = 'CGC';
        $toUnit = 'CG2';
        $sql = "
            SELECT PCL.CLAIM_LINE_ID
                 ,PCL.CLAIM_HEADER_ID
                 ,PCL.RMA_LINE_NO
                 ,PCL.ITEM_ID
                 ,PCL.ITEM_CODE
                 ,PCL.ITEM_DESCRIPTION
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$userOrgID},
                        PRECISION         => NULL,
                        from_quantity     => POL.APPROVE_CARDBOARDBOX,
                        from_unit         => 'CGC',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGC_CGK
                 ,POL.APPROVE_CARDBOARDBOX
                 ,POL.APPROVE_CARTON
                 ,PCL.RMA_QUANTITY_CBB
                 ,PCL.RMA_QUANTITY_CARTON
                 ,PCL.RMA_QUANTITY_PACK
                 ,PCL.RMA_QUANTITY
                 ,PCL.RMA_UOM_CODE
                 ,PCL.ENTER_RMA_QUANTITY
                 ,PCL.ENTER_RMA_UOM
            FROM PTOM_CLAIM_LINES PCL
                , PTOM_ORDER_LINES POL
            WHERE 1=1
                AND PCL.CLAIM_HEADER_ID     = {$id}
                AND PCL.ORDER_LINE_ID       = POL.ORDER_LINE_ID
            ORDER BY PCL.RMA_LINE_NO
        ";

        $data = DB::select($sql);

        return $data;
    });



    Route::get('customerNotIn',function (){
        $customers = \App\Models\OM\Rma\Customers::select(
            'customer_id',
            'customer_number',
            'customer_name',
            'pick_release_no')
            ->whereNotIn('customer_type_id',[30,40])->get();

        return $customers;

    });

    Route::get('customerAll',function (){
        $customers = \App\Models\OM\Rma\Customers::select(
            'customer_id',
            'customer_number',
            'customer_name')
            ->where('customer_id','225')
            ->first();

        return $customers;
    });

    Route::get('invoiceSmo',function (){
//        $invoices = \App\Models\OM\Rma\Domestic\PtomConsignmentHeaders::whereHas('ptomOrderHeader',function ($q){
//            $q->where('customer_id',1);
//        })
//            ->where('consignment_status','Confirm')
//            ->get();

//        $invoices = \App\Models\OM\Rma\Domestic\PtomOrderHeaders::where('pick_release_status','Confirm')
//            ->where('customer_id',1)
//            ->get();
//
//        return $invoices;
        $invoice = \App\Models\OM\Rma\Domestic\PtomOrderHeaders::where('pick_release_no','64I000230')->first();
        $customer = \App\Models\OM\Rma\Customers::where('customer_id',$invoice->customer_id)->first();
        $numbers = \App\Models\OM\Rma\Domestic\PtomClaimHeaders::where('customer_id',$invoice->customer_id)->get();


        return response()->json(['numbers'=>$numbers,'customer'=>$customer,'invoice'=>$invoice]);
    });

    Route::get('invoiceByStatus/{status}',function ($status){
       $invoice = \App\Models\OM\Rma\Domestic\PtomOrderHeaders::select('pick_release_no','pick_release_approve_date','pick_release_status')
           ->with('customer',function ($q){
                $q->select('customer_id','customer_name');
           })
           ->where('pick_release_status',$status)->get();

       return response()->json($invoice);
    });

    Route::get('callPackage-OMP0052_RMA_NUM_DOM',function (){
        $db = \DB::connection('oracle')->getPdo();
        $sql = "
                DECLARE
                  LV_DOC_SEQUENCE_NUMBER     VARCHAR2(100)   :=  NULL;
                  LV_RETURN_STATUS                      VARCHAR2(100)   :=  NULL;
                  LV_RETURN_MSG                            VARCHAR2(4000)  :=  NULL;
                BEGIN
                  PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                  (   I_DOCUMENT_CODE                       =>  'OMP0052_RMA_NUM_DOM'
                    , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                    , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                    , O_RETURN_MSG                          =>  :LV_RETURN_MSG
                  );

                END;
        ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['doc_sequence_number'], \PDO::PARAM_STR, 2000);
        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;

    });

    Route::get('callPackage-OMP0084_RMA_NUM_EXP',function (){
        $db = \DB::connection('oracle')->getPdo();
        $sql = "
                DECLARE
                  LV_DOC_SEQUENCE_NUMBER     VARCHAR2(100)   :=  NULL;
                  LV_RETURN_STATUS                      VARCHAR2(100)   :=  NULL;
                  LV_RETURN_MSG                            VARCHAR2(4000)  :=  NULL;
                BEGIN
                  PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                  (   I_DOCUMENT_CODE                       =>  'OMP0084_RMA_NUM_EXP'
                    , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                    , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                    , O_RETURN_MSG                          =>  :LV_RETURN_MSG
                  );

                END;
        ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['doc_sequence_number'], \PDO::PARAM_STR, 2000);
        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;

    });

    Route::get('callPackage-wms/{claimId}/{rmaNumber}',function ($claimId,$rmaNumber){
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_14(i_claim_header_id   => {$claimId}
                    ,i_rma_number     => '{$rmaNumber}'
                    ,o_result                   => :o_result);
                dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        echo 'claim_header_id :' . $claimId .'<br>';
        echo 'RMA_NUMBER :' . $rmaNumber . '<br>';

        dd('result', $result);

    });

    Route::get('testWMS/{claim_header_id}/{rma_number}',function ($claim_header_id,$rma_number){
        echo 'Call package :   PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_14' .'<br>';
        echo 'claim_header_id : ' . $claim_header_id . ',  rma_number : ' . $rma_number .'<br>';

        $update = PtomClaimHeaders::where('claim_header_id',$claim_header_id)->update(['status_rma' => "Confirm"]);

        if ($update){
            $dbWms = \DB::connection('oracle')->getPdo();
            $sqlWms = "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_14(i_claim_header_id   => {$claim_header_id}
                    ,i_rma_number     => '{$rma_number}'
                    ,o_result                   => :o_result);
                dbms_output.put_line(o_result);
            END;
        ";

            $sqlWms = preg_replace("/[\r\n]*/","",$sqlWms);
            $stmtWms = $dbWms->prepare($sqlWms);
            $resultWms = [];
            $stmtWms->bindParam(':o_result', $resultWms['o_result'], PDO::PARAM_STR, 4000);
            $stmtWms->execute();

            echo 'o_result : ' . $resultWms['o_result'];
        } else {
            echo 'Update not success ...' . '<br>';
        }
    });

    Route::get('update-rma-status/{claim_header_id}/{status}',function ($claim_header_id,$status){
        $update = PtomClaimHeaders::where('claim_header_id',$claim_header_id)->update(['status_rma' => $status]);
        if ($update){
            echo 'Updata rma status successfully..' . \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        } else {
            echo 'Oop!.. , rma_status not update...'. \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        }
    });

    Route::get('convert/{orgId}/{itemId}/{from}/{to}/{qty}',function ($orgId,$itemId,$from,$to,$qty){
//        $getInv = getInvOrgForOM();
//        $itemId = 49222;
//        $orgId = $getInv->organization_id;
//        $orgId = 121;
//        $qty = 80;
        $fromUnit = 'CG'; // มวน
        $toUnit = 'CGK'; // พันมวน
        $toUnit2 = 'CG2'; // ห่อ
        $toUnit3 = 'CGP'; // ซอง
        $toUnit4 = 'CGC'; // หีบ
        $sql = "
            SELECT
                apps.inv_convert.inv_um_convert (
                    item_id           => {$itemId},
                    organization_id   => {$orgId},
                    PRECISION         => NULL,
                    from_quantity     => {$qty},
                    from_unit         => '{$from}',
                    to_unit           => '{$to}',
                    from_name         => NULL,
                    to_name           => NULL) convert_qty
            from dual
        ";

        $data = collect(\DB::select($sql));

        return $data;
    });

    Route::get('user',function (){
        $data = getDefaultData('/om/rma-domestic');

        return response()->json($data);
    });

    Route::get('timestamp',function (){
        return \Carbon\Carbon::today()->format('Y-m-d');
    });

    Route::get('getInv',function (){
        $getInv = getInvOrgForOM();
        return response()->json(['organization_id' => $getInv->organization_id]);
    });

    Route::get('testResult/{id}',function ($id){
        $result = PtomClaimHeaders::where('invoice_id',$id)
            ->where('status_rma','Confirm')
            ->get();
        if (!$result->isEmpty()){
            return response()->json([
                'data' => $result,
                'message' => "Have Data...",
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => "No Data...",
                'code' => 500
            ]);
        }
    });

    Route::get('testGetTotalAmount/{id}',function ($id){
        $result = PtomClaimHeaders::where('claim_header_id',$id)->first();
        echo 'invoice_id : ' . $result->invoice_id . '<br>';

        $invoiceId = $result->invoice_id;

        $headers = PtomClaimHeaders::where('invoice_id',$invoiceId)
            ->where('status_rma','Confirm')
            ->get();

        foreach ($headers as $hKey => $header){
            echo '<br>'. '=================================='. '<br>';
            echo 'Header ID : ' . $header->claim_header_id . '<br>';
            echo 'RMA Number : ' . $header->rma_number . '<br>';
            echo 'Status RMA : ' . $header->status_rma . '<br>';
            $lines = PtomClaimLines::where('claim_header_id',$header->claim_header_id)->get();
            foreach ($lines as $lKey => $line){
                echo  $lKey .' => ' . 'Item ID : ' . $line->item_code . '  ,rma_quantity : ' . $line->rma_quantity . '  ,enter_rma_quantity : ' . $line->enter_rma_quantity .'<br>';
                $itemRma[$hKey][$lKey] = $line->rma_quantity;
            }
        }
        echo '<br>'. '=================================='. '<br>';
        $sumRma = array_shift($itemRma);
        foreach ($itemRma as $val) {
            foreach ($val as $key => $val) {
                $sumRma[$key] += $val;
                echo $key . 'sumRma: ' . $sumRma[$key] . '<br>';
            }
        }

    });

    Route::get('uomlist',function (){
        $uomlist = PtomUomV::where('DOMESTIC','Y')
            ->whereNotIn('UOM_CLASS',['บุหรี่'])
            ->orderBy('UOM_CODE')
            ->get();
        return $uomlist;
    });

    Route::get('getPreviousRma/{id}',function ($id){
        // Check previous rma_quantity
        $claimHeadersId = [];
        $rmaItemQty = [];
        $uomlist = PtomUomV::where('DOMESTIC','Y')->orderBy('UOM_CODE')->get();
        $result = PtomClaimHeaders::where('claim_header_id',$id)->first();
        $orderHeader = PtomOrderHeaders::where('pick_release_no',$result->ref_invoice_number)->first();
        $orgId = $orderHeader->org_id;
        $orderLines = PtomOrderLines::where('order_header_id',$orderHeader->order_header_id)->get();
        $iOrderLines = $orderLines->count();
        $qty = 1;

        foreach ($orderLines as $line){
            array_push($rmaItemQty,[
                'item_code'=>$line->item_code
                ,'item_description'=>$line->item_description
                ,'order_quantity'=>$line->order_quantity
                ,'uom_code'=>$line->uom_code
                ,'org_id'=>$orgId
                ,'prvRmaQty'=>0
            ]);
        }
        $claimHeaders = PtomClaimHeaders::where('invoice_id',$result->invoice_id)
            ->where('status_rma','Confirm')
            ->get();
        foreach ($claimHeaders as $header){
            array_push($claimHeadersId,$header->claim_header_id);
        }
        $claimLines = PtomClaimLines::whereIn('claim_header_id',$claimHeadersId)->get();
        foreach ($claimLines as $line) {
            for ($i=0;$i < $iOrderLines;$i++ ){
                if ($line->item_code == $rmaItemQty[$i]['item_code']){
                    $rmaItemQty[$i]['prvRmaQty'] += $line->rma_quantity;
                }
            }
        }
        return $rmaItemQty;
    });

    Route::get('itemDetails/{id}',function ($id){
        // Get OrgID
        $orderHeader = PtomOrderHeaders::where('order_header_id',$id)->first();
        $orgId = $orderHeader->org_id;
        $uomlist = PtomUomV::where('DOMESTIC','Y')->orderBy('UOM_CODE')->get();
        $factorArray =[];

        $orderLines = PtomOrderLines::where('order_header_id',$id)->get();

        foreach ($orderLines as $key => $orderLine) {
            foreach ($uomlist as $item) {
                $sql = "
                    SELECT
                            apps.inv_convert.inv_um_convert (
                                item_id           => {$orderLine->item_id},
                                organization_id   => {$orgId},
                                PRECISION         => NULL,
                                from_quantity     => 1,
                                from_unit         => '{$item->uom_code}',
                                to_unit           => '{$orderLine->uom_code}',
                                from_name         => NULL,
                                to_name           => NULL) convert_qty
                        from dual
                    ";
                $data = DB::select($sql);
                foreach ($data as $datum) {
                    $factor = $datum->convert_qty;
                }
                array_push($factorArray,[
                    'order_line'=> $key,
                    'uom_code'=> $item->uom_code,
                    'factor'=> $factor
                ]);
            }
        }
        return response()->json([$orderLines,$factorArray]);
    });

    Route::get('orderLines/{id}',function ($id){
        $orderHeader = PtomOrderHeaders::where('order_header_id',$id)->first();
        $orgId = $orderHeader->org_id;
        $uomlist = PtomUomV::where('DOMESTIC','Y')->orderBy('UOM_CODE')->get();
        $factorArray =[];
        foreach ($uomlist as $item) {
            array_push($factorArray,[
                'uomDesc' => $item->uom_code
            ]);
        }
        $sql = "SELECT POL.*
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[0]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[0]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[1]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[1]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[2]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[2]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[3]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[3]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[4]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[4]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[5]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[5]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[6]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[6]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[7]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[7]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[8]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[8]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[9]['uomDesc']}',
                        to_unit           => POL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[9]['uomDesc']}
            FROM PTOM_ORDER_LINES POL
            WHERE POL.ORDER_HEADER_ID = {$orderHeader->order_header_id}
            ORDER BY POL.LINE_NUMBER
            ";
        $lines = \DB::select($sql);
        return response()->json(['lines'=>$lines]);
    });

    Route::get('getLines/{id}',function ($id){
        // Get Order Header
        $claimHeader = PtomClaimHeaders::where('claim_header_id',$id)->first();
        $orderHeader = PtomOrderHeaders::where('pick_release_no',$claimHeader->ref_invoice_number)->first();
        $orgId = $orderHeader->org_id;
        $uomlist = PtomUomV::where('DOMESTIC','Y')->orderBy('UOM_CODE')->get();
        $factorArray =[];
        foreach ($uomlist as $item) {
            array_push($factorArray,[
                'uomDesc' => $item->uom_code
            ]);
        }
        // Get Line items
        $claim_header_id = $id;
        if ($orderHeader->product_type_code == 10){
            $sql = "
            SELECT PCL.*
                 ,PUCV.UNIT_OF_MEASURE UOM
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGC',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGC
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CG2',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CG2
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGP',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGP
                 ,POL.APPROVE_CARDBOARDBOX
                 ,POL.APPROVE_CARTON
                 ,POL.CREDIT_GROUP_CODE
            FROM PTOM_CLAIM_LINES PCL
                ,PTOM_UOM_CONVERSIONS_V PUCV
                ,PTOM_ORDER_LINES POL
            WHERE 1=1
                AND PCL.CLAIM_HEADER_ID     = {$claim_header_id}
                AND PCL.ORDER_LINE_ID       = POL.ORDER_LINE_ID
                AND PCL.UOM_CODE = PUCV.UOM_CODE
            ORDER BY PCL.RMA_LINE_NO
        ";

        } else {
            $sql = "
            SELECT PCL.*
                 ,PUCV.UNIT_OF_MEASURE UOM
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[0]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[0]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[1]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[1]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[2]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[2]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[3]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[3]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[4]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[4]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[5]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[5]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[6]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[6]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[7]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[7]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[8]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[8]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[9]['uomDesc']}',
                        to_unit           => PCL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[9]['uomDesc']}
                 ,POL.APPROVE_CARDBOARDBOX
                 ,POL.APPROVE_CARTON
                 ,POL.CREDIT_GROUP_CODE
            FROM PTOM_CLAIM_LINES PCL
                ,PTOM_UOM_CONVERSIONS_V PUCV
                ,PTOM_ORDER_LINES POL
            WHERE 1=1
                AND PCL.CLAIM_HEADER_ID     = {$claim_header_id}
                AND PCL.ORDER_LINE_ID       = POL.ORDER_LINE_ID
                AND PCL.UOM_CODE = PUCV.UOM_CODE
            ORDER BY PCL.RMA_LINE_NO
        ";

        }

        $lines = \DB::select($sql);

        return response()->json(['lines'=>$lines]);
    });

    Route::get('transac/{id}',function ($id){
        $orderTypeId = PtomTransactionTypeAllV::from('PTOM_TRANSACTION_TYPES_ALL_V AS PTTAV')
            ->join('PTOM_PROFORMA_INVOICE_HEADERS AS PPIH','PTTAV.ORDER_TYPE_ID', 'PPIH.ORDER_TYPE_ID')
            ->where('PPIH.PICK_RELEASE_NO' , $id)
//            ->where('PTTAV.ORDER_TYPE_ID' , 'PPIH.ORDER_TYPE_ID')
            ->get(['pttav.order_type_id','pttav.rma_transaction_type_id']);
//        $orderTypeId = PtomTransactionTypeAllV::all();

        return response()->json($orderTypeId);
    });

    Route::get('transacSmo/{id}',function ($id){
        $orderTypeId = PtomTransactionTypeAllV::from('PTOM_TRANSACTION_TYPES_ALL_V AS PTTAV')
            ->join('PTOM_CONSIGNMENT_HEADERS AS PCH','PTTAV.ORDER_TYPE_ID', 'PCH.ORDER_TYPE_ID')
            ->where('PCH.PICK_RELEASE_NUM' , $id)
//            ->where('PTTAV.ORDER_TYPE_ID' , 'PPIH.ORDER_TYPE_ID')
            ->get(['pttav.order_type_id','pttav.rma_transaction_type_id']);
//        $orderTypeId = PtomTransactionTypeAllV::all();

        return response()->json($orderTypeId);
    });

    Route::get('getCusType/{id}',function ($id){
        $orderHeader = PtomOrderHeaders::where('pick_release_no',$id)->first();
        $customer = Customers::where('customer_id',$orderHeader->customer_id)->first();
        return $customer->customer_type_id;
    });

    Route::get('dom-cenario-test/{invoice}',function ($invoice){
        $cenario = 0;
        $customeType = '';
        $orderHeader = PtomOrderHeaders::where('pick_release_no',$invoice)->first();
        $customer = Customers::find($orderHeader->customer_id);
        // Check data in PTOM_OUTSTANDING_DEBT_DOM_V
        if (($customer->customer_type_id == 30 || $customer->customer_type_id == 40)&& $orderHeader->product_type_code == 10){
            $invoiceHeader = PtomConsignmentHeaders::where('pick_release_num',$invoice)->first();
            $invoiceLines = PtomConsignmentLines::where('CONSIGNMENT_HEADER_ID',$invoiceHeader->consignment_header_id)->get();
            foreach ($invoiceLines as $line) {
                $result = PtomOutstandingDebtDomV::where('CONSIGNMENT_NO',$invoiceHeader->consignment_no)->get();
                if ($result->first()){
                    dd('May be 2 or 3',$result);
                } else {
                    dd('Not found in outstanding. So this is cenario 1. ลูกค้าสโมสร');
                }
            }
        } else {
            $invoiceHeader = PtomInvoiceHeaders::where('REF_INVOICE_NUMBER', $invoice)->first();
            $invoiceLines = PtomInvoiceLines::distinct()
                ->where('INVOICE_HEADERS_ID', $invoiceHeader->invoice_headers_id)
                ->get(['credit_group_code']);
            foreach ($invoiceLines as $line) {
                $result = PtomOutstandingDebtDomV::where('PICK_RELEASE_NO', $invoice)
                    ->where('CREDIT_GROUP_CODE', $line->credit_group_code)
                    ->get();
                if ($result->first()) {
                    $sumPayment = PtomInvoiceLines::where('INVOICE_HEADERS_ID', $invoiceHeader->invoice_headers_id)
                        ->where('credit_group_code', $line->credit_group_code)
                        ->sum('payment_amount');
                    $outStanding = PtomOutstandingDebtDomV::where('PICK_RELEASE_NO', $invoice)
                        ->where('credit_group_code', $line->credit_group_code)
                        ->sum('outstanding_debt');
                    if ($outStanding >= $sumPayment) {
                        dd(number_format($outStanding, 2), number_format($sumPayment, 2), 'Found in outstanding and this is cenario 2 ลูกค้าทั่วไป');
                    } else {
                        dd(number_format($outStanding, 2), number_format($sumPayment, 2), 'Found in outstanding and this is cenario 3 ลูกค้าทั่วไป');
                    }
                } else {
                    dd('Not found in outstanding. So this is cenario 1. ลูกค้าทั่วไป');
                }
            }
        }
        $orderHeader = PtomOrderHeaders::where('pick_release_no',$invoice)->first();
        $customer = Customers::find($orderHeader->customer_id);
        // Check data in PTOM_OUTSTANDING_DEBT_DOM_V
        if (($customer->customer_type_id == 30 || $customer->customer_type_id == 40)&& $orderHeader->product_type_code == 10){
            $result = PtomOutstandingDebtDomV::where('CONSIGNMENT_NO',$invoice)
                ->where('credit_group_code',$code)->first();
            if (!$result){
                $cenario = 1;
                $customeType = 'ลูกค้าสโมสร';
                $sumOutstanding = 0;
                $sumPayment = 0;
            } else {
                $consignmentHeader = PtomConsignmentHeaders::where('pick_release_num',$invoice)->first();
                $sumOutstanding = PtomOutstandingDebtDomV::where('CONSIGNMENT_NO',$invoice)
                    ->where('credit_group_code',$code)
                    ->sum('outstanding_debt');
                $invoiceHeader = PtomInvoiceHeaders::where('REF_INVOICE_NUMBER',$invoice)->first();
                $sumPayment = PtomInvoiceLines::where('INVOICE_HEADERS_ID',$invoiceHeader->invoice_headers_id)
                    ->where('credit_group_code',$code)
                    ->sum('payment_amount');
                if ($sumOutstanding >= $sumPayment) {
                    $cenario = 2;
                } else {
                    $cenario = 3;
                }
            }
        } else {
            $result = PtomOutstandingDebtDomV::where('pick_release_no',$invoice)
                ->where('credit_group_code',$code)->first();
            if (!$result){
                $cenario = 1;
                $customeType = 'ลูกค้าทั่วไป';
                $sumOutstanding = 0;
                $sumPayment = 0;
            } else {
                $sumOutstanding = PtomOutstandingDebtDomV::where('pick_release_no',$invoice)
                    ->where('credit_group_code',$code)
                    ->sum('outstanding_debt');
                $invoiceHeader = PtomInvoiceHeaders::where('REF_INVOICE_NUMBER',$invoice)->first();
                $sumPayment = PtomInvoiceLines::where('INVOICE_HEADERS_ID',$invoiceHeader->invoice_headers_id)
                    ->where('credit_group_code',$code)
                    ->sum('payment_amount');
                if ($sumOutstanding >= $sumPayment) {
                    $cenario = 2;
                } else {
                    $cenario = 3;
                }
            }
        }

        return response()->json([
            'Cenario test for' => 'Domestic'
            ,'Customer Type' => $customeType
            ,'invoice no' => $invoice
            ,'credit group code' => $code
            ,'Cenario result' => $cenario
            ,'sum Outstanding_debt'=> number_format($sumOutstanding,2)
            ,'sum Payment_amount'=> number_format($sumPayment,2)
            ,'Result in PTOM_OUTSTANDING_DEBT_DOM_V' => $result
        ]);
    });

    Route::get('exp-cenario-test/{invoice}',function ($invoice){
        $cenario = 0;
        $result = PtomOutstandingDebtExpV::where('pick_release_no',$invoice)->first();

        if (!$result){
            $cenario =1;
            $sumOutstanding = 0;
            $sumPayment = 0;
        } else {
            $sumOutstanding = PtomOutstandingDebtExpV::where('pick_release_no',$invoice)
                ->sum('outstanding_debt');
            $invoiceHeader = PtomInvoiceHeaders::where('REF_INVOICE_NUMBER',$invoice)->first();
            $sumPayment = PtomInvoiceLines::where('INVOICE_HEADERS_ID',$invoiceHeader->invoice_headers_id)
                ->sum('payment_amount');
            if ($sumOutstanding >= $sumPayment) {
                $cenario = 2;
            } else {
                $cenario = 3;
            }
        }

        return response()->json([
            'Cenario test for' => 'Export'
            ,'invoice no' => $invoice
            ,'Cenario result' => $cenario
            ,'sum Outstanding_debt'=> number_format($sumOutstanding,2)
            ,'sum Payment_amount'=> number_format($sumPayment,2)
            ,'Result in PTOM_OUTSTANDING_DEBT_EXP_V' => $result
        ]);
    });

    Route::get('testAddPayment/{number}/{id}',function ($number,$id){

        $header = PtomInvoiceHeaders::find($id);
//        dd($header);
        $result = PtomInvoiceLines::distinct()
            ->where('REF_INVOICE_NUMBER',$number)
            ->where('invoice_headers_id',$id)
            ->get(['credit_group_code']);
        foreach ($result as $value) {
            if ($value->credit_group_code != 0 && $value->credit_group_code != null){
                        echo 'CREDIT_GROUP_CODE => '.$value->credit_group_code . '<br>';
                $sumPayment = PtomInvoiceLines::where('REF_INVOICE_NUMBER',$number)
                    ->where('credit_group_code',$value->credit_group_code)
                    ->where('invoice_headers_id',$id)
                    ->sum('payment_amount');
                        echo '$sumPayment => ' . number_format($sumPayment,2). '<br>';
                $remainingAmount = PtomCustomerContractGroups::where('customer_id',$header->customer_id)
                    ->where('credit_group_code',$value->credit_group_code)
                    ->first();
                        echo '$remainingAmount => ' . number_format($remainingAmount->remaining_amount,2) . '<br>';
                $remainingAmount->remaining_amount += $sumPayment;
                        echo 'new $remainingAmount => ' . number_format($remainingAmount->remaining_amount,2) . '<br>';
                PtomCustomerContractGroups::where('customer_id',$header->customer_id)
                    ->where('credit_group_code',$value->credit_group_code)
                    ->update(['REMAINING_AMOUNT'=>$remainingAmount->remaining_amount]);
            }
        }











//        $invoiceHeader = PtomInvoiceHeaders::where('invoice_headers_id',$id)->first();
//        $invoiceLines = PtomInvoiceLines::where('invoice_headers_id',$invoiceHeader->invoice_headers_id)->first();
//        $result = PtomInvoiceLines::distinct()
//            ->where('REF_INVOICE_NUMBER',$invoiceLines->ref_invoice_number)
//            ->where('invoice_headers_id',$invoiceHeader->invoice_headers_id)
//            ->get(['credit_group_code']);
//        foreach ($result as $value) {
//            $invoiceLines = PtomInvoiceLines::where('invoice_headers_id',$invoiceHeader->invoice_headers_id)
//                ->where('credit_group_code',$value->credit_group_code)
//                ->first();
//            if ($value->credit_group_code != 0 && $value->credit_group_code != null){
//                echo 'CREDIT_GROUP_CODE => '.$value->credit_group_code . '<br>';
//                $sumPayment = PtomInvoiceLines::where('REF_INVOICE_NUMBER',$invoiceLines->ref_invoice_number)
//                    ->where('credit_group_code',$value->credit_group_code)
//                    ->where('invoice_headers_id',$invoiceHeader->invoice_headers_id)
//                    ->sum('payment_amount');
//                echo '$sumPayment => ' . number_format($sumPayment,2). '<br>';
//                $remainingAmount = PtomCustomerContractGroups::where('customer_id',$invoiceHeader->customer_id)
//                    ->where('credit_group_code',$value->credit_group_code)
//                    ->first();
//                echo '$remainingAmount => ' . number_format($remainingAmount->remaining_amount,2) . '<br>';
//                $remainingAmount->remaining_amount += $sumPayment;
//                echo 'new $remainingAmount => ' . number_format($remainingAmount->remaining_amount,2) . '<br>';
//            }
//        }
//        return $arrResult;
    });

});
