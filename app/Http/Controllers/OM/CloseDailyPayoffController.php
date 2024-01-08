<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\PaymentHeader;
use App\Models\HrOperatingUnits;
use App\Models\OM\ARReceiptInterface;
use App\Models\OM\ARInterface;
use App\Models\OM\paymentMatchsInvoice;
use App\Models\OM\PtomARReceiptsV;
use App\Models\OM\ARInvoiceHeaderV;
use Carbon\Carbon;
use FormatDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OM\PaymentApply;
use App\Models\OM\ARReceiptInfReport;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\SaleConfirmation\TaxCode;
use App\Models\OM\PaymentMatchInvoice;
use App\Repositories\OM\InterfaceRepo;

class CloseDailyPayoffController extends Controller
{
    public function domestic()
    {
        (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

        $saleClass = 'domestic';

        return view('om.close_daily_payoff.index', compact(
            'saleClass'
        ));
    }

    public function export()
    {
        (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

        $saleClass = 'export';

        return view('om.close_daily_payoff.index', compact(
            'saleClass'
        ));
    }

    public function getDateLists(Request $request)
    {
        $saleClass = $request->sale_class;
        
        $documentDateLists = $this->getDocumentDate($saleClass);

        return response()->json($documentDateLists);
    }

    public function validateData(Request $request)
    {
        (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

        $close_date = $request->close_date;
        $data = [];

        $sale_class = $request->sale_class;

        $this->updateInvoiceNumber();

        $closeDateLists = $this->getDocumentDate($sale_class);

        if(array_search($close_date, array_keys($closeDateLists))){
            return [
                'status' => 'E',
                'msg' => 'กรุณาทำการปิดการรับเงินประจำวันของวันก่อนหน้านี้ก่อน',
            ];
        }

        $invoices = ARInterface::whereDate('invoice_date', $close_date)
        ->when($sale_class, function($q, $sale_class){
            $class = $sale_class == 'export' ? 'ระบบขายต่างประเทศ' : 'ระบบขายในประเทศ';
            return $q->where('batch_source_name', $class);
        })
        ->where('interface_status', 'C')
        ->get();
        $check_close = true;
        if($invoices->count()){
            foreach ($invoices as $invoice) {
                $interfaceable = $invoice->interfaceable;
                if($interfaceable){
                    if(optional($interfaceable)->close_sale_flag != 'Y'){
                        $check_close = false;
                    }
                }
            }
        }

        if(!$check_close){
            $data['status'] = 'E';
            $data['msg'] = 'กรุณาทำการปิดการขายประจำวันก่อน';
            return response()->json($data);
        }

        $data['status'] = 'S';
        $data['msg'] = '';

        return response()->json($data);
    }

    public function callReport(Request $request)
    {
        try {

            (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

            $close_date = $request->close_date;
            $sale_class = $request->sale_class;
            $program_code = strtoupper($sale_class) == strtoupper('domestic') ? 'OMP0045' : 'OMP0079';

            $old_groups = self::getOldGroupId($request);

            foreach($old_groups as $old){
                $check_receipt_interface_complete = \App\Models\OM\ARReceiptInterface::select("group_id")
                ->where('group_id', $old)
                ->where(function($q){
                    return $q->where('record_status', ['C', 'S'])
                    ->orWhere('interface_status', ['C', 'S']);
                })
                ->first();
    
                if(!$check_receipt_interface_complete){
                    $delete_report_temps = ARReceiptInfReport::where('group_id', $old)
                    ->delete();
                }
            }

            $group_id = getGroupID();
            $batch_no = $group_id.'-'.uniqid();
            $creation_date = Carbon::now();

            //// case ตั้ง receipt ////
            $this->insertDataCaseCreateReceipt($request, $program_code, $batch_no, $group_id, $creation_date, true);

            //// case cancel receipt ////
            $this->insertDataCaseCancelReceipt($request, $program_code, $batch_no, $group_id, $creation_date, true);

            ///////////////// case applies, un-applies /////////////////
            //// หาของเคส applies ที่ยังไม่ interface กรณีหยิบวันที่ปิดการขาย ////
            // $this->insertDataCaseApplyCloseDate($request, $program_code, $batch_no, $group_id, $creation_date, true);

            //// หาของเคส applies ที่ยังไม่ interface กรณีหยิบวันที่ match ////
            $this->insertDataCaseApplyMatchDate($request, $program_code, $batch_no, $group_id, $creation_date, true);
            
            //// หาวันที่ของเคส unapplies ถ้ามี match ไหนมี Y ส่ง N แต่ถ้าไม่มี ไม่ส่ง กรณีหยิบวันที่ปิดการขาย ////
            // $this->insertDataCaseUnApplyCloseDate($request, $program_code, $batch_no, $group_id, $creation_date, true);

            //// หาวันที่ของเคส unapplies ถ้ามี match ไหนมี Y ส่ง N แต่ถ้าไม่มี ไม่ส่ง กรณีหยิบวันที่ match ////
            $this->insertDataCaseUnApplyMatchDate($request, $program_code, $batch_no, $group_id, $creation_date, true);
            //// case applies, un-applies////

            $group_receipts = \App\Models\OM\ARReceiptInfReport::where('web_batch_no', $batch_no)->get()->groupBy('receipt_number');

            $count_receipts = $group_receipts->count();
            $sum_total_batch = 0;
            foreach ($group_receipts as $receipt_number => $interface_temps) {
                $sum_total_batch += optional($interface_temps->first())->receipt_amount ?? 0;
            }

            $i = 0;
            foreach ($group_receipts as $receipt_number => $interface_temps) {
                $i++;
    
                $attr2 = $interface_temps->whereNotNull('purpose_activity')
                    ->where('purpose_activity', '!=', 'ภาษีขาย')
                    ->where('amount_applied', '>', 0)
                    ->sum('amount_applied');
                $attr3 = $interface_temps->where('purpose_activity', 'ภาษีขาย')
                    ->sum('amount_applied');
    
                foreach ($interface_temps as $temp) {
                    $temp->batch_number            = $temp->batch_number.'-'.$i;
                    $temp->global_attribute2       = $temp->global_attribute2 ? round($attr2, 2) : $temp->global_attribute2;
                    $temp->global_attribute3       = $temp->global_attribute3 ? round($attr3, 2) : $temp->global_attribute3;
                    $temp->count_toal              = $count_receipts;
                    $temp->control_count           = $count_receipts;
                    $temp->control_amount          = $sum_total_batch;
                    $temp->save();
                }
            }

            $check_data_report = !!(\App\Models\OM\ARReceiptInfReport::where('web_batch_no', $batch_no)->count());

            if( $check_data_report ){
                $result = [
                    'status' => 'S',
                    'msg' => 'ประมวลผลสำเร็จ Group ID '.$group_id,
                    'group_id' => $group_id,
                ];
            }else {
                return response()->json([
                    'status' => 'E',
                    'msg' => 'ไม่มีข้อมูล interface',
                    'group_id' => '',
                ]);
            }

        }catch (\Exception $e) {

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
            return response()->json($result);
        }

        return response()->json($result);
    }

    public function interface(Request $request)
    {
        (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

        $close_date = $request->close_date;
        $sale_class = $request->sale_class;
        $program_code = strtoupper($sale_class) == strtoupper('domestic') ? 'OMP0045' : 'OMP0079';

        $group_id = self::genGroupId($request);
        $batch_no = $group_id.'-'.uniqid();
        $creation_date = Carbon::now();

        //// case ตั้ง receipt ////
        $this->insertDataCaseCreateReceipt($request, $program_code, $batch_no, $group_id, $creation_date);

        //// case cancel receipt ////
        $this->insertDataCaseCancelReceipt($request, $program_code, $batch_no, $group_id, $creation_date);

        ///////////////// case applies, un-applies /////////////////
        //// หาของเคส applies ที่ยังไม่ interface กรณีหยิบวันที่ปิดการขาย ////
        // $this->insertDataCaseApplyCloseDate($request, $program_code, $batch_no, $group_id, $creation_date);

        //// หาของเคส applies ที่ยังไม่ interface กรณีหยิบวันที่ match ////
        $this->insertDataCaseApplyMatchDate($request, $program_code, $batch_no, $group_id, $creation_date);
        
        //// หาวันที่ของเคส unapplies ถ้ามี match ไหนมี Y ส่ง N แต่ถ้าไม่มี ไม่ส่ง กรณีหยิบวันที่ปิดการขาย ////
        // $this->insertDataCaseUnApplyCloseDate($request, $program_code, $batch_no, $group_id, $creation_date);

        //// หาวันที่ของเคส unapplies ถ้ามี match ไหนมี Y ส่ง N แต่ถ้าไม่มี ไม่ส่ง กรณีหยิบวันที่ match ////
        $this->insertDataCaseUnApplyMatchDate($request, $program_code, $batch_no, $group_id, $creation_date);
        //// case applies, un-applies////

        $group_receipts = \App\Models\OM\ARReceiptInterface::where('web_batch_no', $batch_no)->get()->groupBy('receipt_number');

        $count_receipts = $group_receipts->count();
        $sum_total_batch = 0;
        foreach ($group_receipts as $receipt_number => $interface_temps) {
            $sum_total_batch += optional($interface_temps->first())->receipt_amount ?? 0;
        }

        $i = 0;
        foreach ($group_receipts as $receipt_number => $interface_temps) {
            $i++;

            $attr2 = $interface_temps->whereNotNull('purpose_activity')
                ->where('purpose_activity', '!=', 'ภาษีขาย')
                ->where('amount_applied', '>', 0)
                ->sum('amount_applied');
            $attr3 = $interface_temps->where('purpose_activity', 'ภาษีขาย')
                ->sum('amount_applied');

            foreach ($interface_temps as $temp) {
                $temp->batch_number            = $temp->batch_number.'-'.$i;
                $temp->global_attribute2       = $temp->global_attribute2 ? round($attr2, 2) : $temp->global_attribute2;
                $temp->global_attribute3       = $temp->global_attribute3 ? round($attr3, 2) : $temp->global_attribute3;
                $temp->count_toal              = $count_receipts;
                $temp->control_count           = $count_receipts;
                $temp->control_amount          = $sum_total_batch;
                $temp->save();
            }
        }

        // $this->insertDataCaseCNDN($request, $program_code, $batch_no, $group_id, $creation_date);

        // dd(\App\Models\OM\ARReceiptInterface::where('group_id', $group_id)->get());

        $check_data_interface = !!(\App\Models\OM\ARReceiptInterface::where('web_batch_no', $batch_no)->count() || \App\Models\OM\ARApplyCnInterface::where('web_batch_no', $batch_no)->count());
        // $check_data_interface = !!(\App\Models\OM\ARReceiptInterface::where('group_id', $group_id)->count());

        if( $check_data_interface ){
            // dd($batch_no);
            $result = InterfaceRepo::interfaceARReceipt($batch_no);
        }else {
            return response()->json([
                'status' => 'E',
                'msg' => 'ไม่มีข้อมูล interface',
                'group_id' => '',
            ]);
        }

        $ar_receipt_error = \App\Models\OM\ARReceiptInterface::where('web_batch_no', $batch_no)->where(function($q){
            return $q->where('record_status', '!=', 'C')
                ->orWhereNull('record_status');
        })->get();
        $apply_cns_error = \App\Models\OM\ARApplyCnInterface::where('web_batch_no', $batch_no)->where('interface_status', '!=', 'C')->get();

        $check_interface_error = $result['status'] != 'S' || !!($ar_receipt_error->count()) || !!($apply_cns_error->count());

        // $check_interface_error = $result['status'] != 'S' || !!($ar_receipt_error->count());

        if($check_interface_error){
            $error_msg = '';
            foreach ($ar_receipt_error as $key => $error) {
                $error_msg = $error_msg.' '.$error->interface_msg;
            }
            foreach ($apply_cns_error as $key => $error) {
                $error_msg = $error_msg.' '.$error->interface_msg;
            }

            $data = [
                'status' => 'E',
                'msg' => 'Interface AR Receipt Error : '.$error_msg,
                'group_id' => '',
            ];
        }else {
            $data = [
                'status' => 'S',
                'msg' => 'ดำเนินการปิดการรับเงินประจำวันเรียบร้อยแล้ว',
                'group_id' => $group_id,
            ];
        }

        return response()->json($data);
    }

    private function insertDataCaseCreateReceipt($request, $program_code, $batch_no, $group_id, $creation_date, $report = false)
    {
        try {
            (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

            $close_date = $request->close_date;
            $sale_class = $request->sale_class;

            $payments = PaymentHeader::whereRaw("upper(payment_status) = 'CONFIRM'")
            ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
            ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
            ->whereDate('payment_date', $close_date)
            ->whereRaw("
                NOT EXISTS (
                    SELECT  1
                    FROM    PTOM_AR_RECEIPTS_V      REC
                    WHERE   UPPER(PTOM_PAYMENT_HEADERS.PAYMENT_STATUS) = UPPER('CONFIRM')
                    AND     UPPER(PTOM_PAYMENT_HEADERS.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                    AND     REC.RECEIPT_NUMBER LIKE PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER||'%'
                )
            ")
            ->with([
                'details'
            ])
            ->get();

            // dd('case create', $payments);

            foreach ($payments as $payment) {
                if(!$report){
                    $payment->web_batch_no = $batch_no;
                }
                $payment->ar_invoice_group_id = $group_id;
                $payment->save();
                $details = $payment->details;
                $count = $details->count();

                foreach ($details as $detail) {

                    $receipt_number = $count > 1 ? $payment->payment_number.'-'.$detail->line_number : $payment->payment_number;
                    $receiptV = PtomARReceiptsV::where('receipt_number', $receipt_number)->first();

                    if( !$receiptV ){

                        InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, null, $detail, null, null, null, 0, $count, $creation_date, $close_date, false, $report);
                    }
                }
            }

        }catch (\Exception $e) {

            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function insertDataCaseCancelReceipt($request, $program_code, $batch_no, $group_id, $creation_date, $report = false)
    {
        try {
            (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

            $close_date = $request->close_date;
            $sale_class = $request->sale_class;

            $payments = PaymentHeader::whereRaw("upper(payment_status) = 'CANCEL'")
            ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
            ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
            ->where(function($q) use ($sale_class) {
                return $q->whereDoesntHave('interfaces')
                ->orWhereRaw("
                    NOT EXISTS (
                        SELECT  1
                        FROM    PTOM_AR_RECEIPTS_V      REC,
                            PTOM_PAYMENT_HEADERS        PH
                        WHERE   UPPER(PH.PAYMENT_STATUS) = UPPER('CANCEL')
                        AND     UPPER(PH.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                        AND     REC.RECEIPT_NUMBER LIKE PH.PAYMENT_NUMBER||'%'
                        AND     PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                    )
                ")
                ->orWhereRaw("
                    EXISTS (
                        SELECT  1
                        FROM    PTOM_AR_RECEIPTS_V      REC,
                            PTOM_PAYMENT_HEADERS        PH
                        WHERE   UPPER(PH.PAYMENT_STATUS) = UPPER('CANCEL')
                        AND     UPPER(PH.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                        AND     REC.RECEIPT_NUMBER LIKE PH.PAYMENT_NUMBER||'%'
                        AND     UPPER(REC.STATE) <> UPPER('REVERSED')
                        AND     PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                    )
                ");
            })
            ->whereDate('last_update_date', $close_date)
            ->with([
                'details'
            ])
            ->get();

            // dd('cancel', $payments);

            foreach ($payments as $payment) {
                if(!$report){
                    $payment->web_batch_no = $batch_no;
                }
                $payment->ar_invoice_group_id = $group_id;
                $payment->save();
                $details = $payment->details; // payment lines
                $count = $details->count();

                foreach ($details as $key => $detail) {

                    $receipt_number = $count > 1 ? $payment->payment_number.'-'.$detail->line_number : $payment->payment_number;

                    $receiptV = PtomARReceiptsV::where('receipt_number', $receipt_number)->get();
                    if(!$receiptV->count()){
                        InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, null, $detail, null, null, null, 0, $count, $creation_date, $close_date, false, $report);
                        InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, null, $detail, null, null, 'U', 0, $count, $creation_date, $close_date, true, $report);
                    }else {
                        foreach ($receiptV as $key => $trx) {
                            if($trx->state === 'CLEARED' && $trx->amount_trx_number != 0){

                                $invoice_number = $trx->trx_number ?: 'Receipt Write-off';
                                $attr1 = $trx->attribute1;
                                $apply_amount = (float)$trx->amount_trx_number;

                                $interfaces = \App\Models\OM\ARReceiptInterface::where('receipt_number', $receipt_number)
                                    ->where('trans_number', $invoice_number)
                                    ->where('attribute1', $attr1)
                                    ->where('apply_flag', 'Y')
                                    ->whereIn('interface_status', ['C', 'S'])
                                    ->get();
                                if(!!$interfaces->count()){
                                    foreach ($interfaces as $key => $interface) {
                                        InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, null, $detail, $invoice_number, $attr1, 'N', $interface->amount_applied, $count, $creation_date, $close_date, false, $report, ($interface->purpose_activity == 'ภาษีขาย'));
                                    }
                                }else {
                                    InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, null, $detail, $invoice_number, $attr1, 'N', $apply_amount, $count, $creation_date, $close_date, false, $report);
                                }
                            }
                        }
                        InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, null, $detail, null, null, 'U', 0, $count, $creation_date, $close_date, true, $report);
                    }
                }
            }

        }catch (\Exception $e) {

            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function insertDataCaseApplyMatchDate($request, $program_code, $batch_no, $group_id, $creation_date, $report = false)
    {
        try {
            (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

            $close_date = $request->close_date;
            $sale_class = $request->sale_class;

            $payments = PaymentHeader::whereRaw("upper(payment_status) = 'CONFIRM'")
            ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
            ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
            ->whereHas('paymentMatchs', function($q) use($close_date, $sale_class){
                return $q->where('match_flag', 'Y')
                ->whereDate('last_update_date', $close_date)
                ->where(function($t) {
                    return $t->whereDoesntHave('interfaces')
                    ->orWhereRaw("
                        NOT EXISTS (
                            SELECT  1
                            FROM    PTOM_AR_RECEIPTS_V      REC,
                                PTOM_PAYMENT_HEADERS        PH
                            WHERE   1=1
                            AND     PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                            AND     PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y'
                            AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                            AND     (
                                REC.TRX_NUMBER = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER
                                OR  (
                                    REC.AMOUNT_TRX_NUMBER > 0 
                                    AND (
                                        REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER
                                        OR
                                        REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER 
                                    )
                                )
                            )
                        )
                    ");
                });
            })
            ->with([
                'details',
                'paymentMatchs' => function ($q) use($close_date){
                    return $q->where('match_flag', 'Y')
                    ->whereDate('last_update_date', $close_date)
                    ->where(function($t) {
                        return $t->whereDoesntHave('interfaces')
                        ->orWhereRaw("
                            NOT EXISTS (
                                SELECT  1
                                FROM    PTOM_AR_RECEIPTS_V      REC,
                                    PTOM_PAYMENT_HEADERS        PH
                                WHERE   1=1
                                AND     PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                                AND     PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y'
                                AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                                AND     (
                                    REC.TRX_NUMBER = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER
                                    OR  (
                                        REC.AMOUNT_TRX_NUMBER > 0 
                                        AND (
                                            REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER
                                            OR
                                            REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER 
                                        )
                                    )
                                )
                            )
                        ");
                    });
                },
                'paymentMatchs.detail',
            ])
            ->get();

            // dd($payments);

            foreach ($payments as $payment) {
                if(!$report){
                    $payment->web_batch_no = $batch_no;
                }
                $payment->ar_invoice_group_id = $group_id;
                $payment->save();
                $count = $payment->details->count();

                $groupOrder = $payment->paymentMatchs
                ->groupBy([
                    "prepare_order_number",
                    "invoice_number",
                    "payment_detail_id",
                    function($item){
                        return $item->credit_group_code == '0' ? '0' : '1';
                    }
                ]);

                foreach($groupOrder as $prepare_no => $groupInvoice){
                    foreach($groupInvoice as $invoice_no => $groupDetails){
                        foreach($groupDetails as $detail_id => $groupCode){
                            foreach($groupCode as $group_code => $matchs){
                                $match = $matchs->first();
                                $gain_loss_amount = 0;
                                $send_line_tax = false;
                                $send_gain_loss = false;
                                $detail = $match->detail;
                                $invoice_ex_rate = 1;
                                $detail_ex_rate = $detail->conversion_rate ?: 1;

                                $receipt_number = $count > 1 ? $payment->payment_number.'-'.$detail->line_number : $payment->payment_number;

                                $apply_amount = (float)$matchs->sum("payment_amount");

                                if($match->match_flag === 'Y'){

                                    if(strtoupper($sale_class) == 'DOMESTIC'){
                                        if($group_code == '0'){
                                            $invoice_number = 'Receipt Write-off';
                                            $attr1 = $prepare_no ?: $invoice_no;
                                        }else {
                                            $invoice_number = $invoice_no;
                                            $attr1 = null;
                                        }
                                    }else {
                                        $invoice_ex_rate = optional($match->proformaHeaders()->whereRaw("upper(pick_release_status) = 'CONFIRM'")->where('pick_release_no', $match->invoice_number)->first())->pick_exchange_rate ?: 1;

                                        $gain_loss_amount = round(($apply_amount * $detail_ex_rate) - ($apply_amount * $invoice_ex_rate), 4);
                                        if(!!$invoice_no){
                                            $apply_amount = $apply_amount * $invoice_ex_rate;
                                            $invoice_number = $invoice_no;
                                            $attr1 = null;
                                        }else {
                                            $apply_amount = $apply_amount * $detail_ex_rate;
                                            $invoice_number = 'Receipt Write-off';
                                            $attr1 = $prepare_no;
                                            $send_line_tax = true;
                                        }

                                        if( $match->payment_type_code == '20' && $gain_loss_amount != 0){
                                            $send_gain_loss = true;
                                        }
                                    }

                                    $receiptV = PtomARReceiptsV::where('receipt_number', $receipt_number)
                                        ->where(function($q) use($invoice_number, $attr1){
                                            return $q->where('trx_number', $invoice_number)
                                                ->orWhere('attribute1', $attr1);
                                        })
                                        ->get();

                                    if(!$receiptV->count()){

                                        if($send_line_tax){
                                            $found = OrderHeader::where('prepare_order_number', $prepare_no)->first();

                                            if($found){
                                                $tax = TaxCode::where('tax', $found->vat_code)->where('rate_type_code', 'PERCENTAGE')->first();
                                                $percentage_rate = optional($tax)->percentage_rate ?? 0;
                                                $tax_amount = (float)$apply_amount * $percentage_rate / (100+$percentage_rate);
                                                InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, ($apply_amount - $tax_amount), $count, $creation_date, $close_date, false, $report);
                                                InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, $tax_amount, $count, $creation_date, $close_date, false, $report, $send_line_tax);
                                            }else {
                                                InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, $apply_amount, $count, $creation_date, $close_date, false, $report);
                                            }
                                        }else {
                                            InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, $apply_amount, $count, $creation_date, $close_date, false, $report);
                                        }

                                        if($send_gain_loss){
                                            InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, $gain_loss_amount, $count, $creation_date, $close_date, false, $report, false, $send_gain_loss);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }catch (\Exception $e) {

            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function insertDataCaseUnApplyMatchDate($request, $program_code, $batch_no, $group_id, $creation_date, $report = false)
    {
        try {
            (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

            $close_date = $request->close_date;
            $sale_class = $request->sale_class;

            $payments = PaymentHeader::whereHas('paymentMatchs', function($q) use($close_date){
                return $q->where('match_flag', 'N')
                ->whereDate('last_update_date', $close_date)
                ->where(function($t) {
                    return $t->whereRaw("
                        EXISTS (
                            SELECT  1
                            FROM    PTOM_AR_RECEIPTS_V      REC,
                                PTOM_PAYMENT_HEADERS        PH
                            WHERE   1=1
                            AND     PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                            AND     PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'N'
                            AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                            AND     (
                                REC.TRX_NUMBER = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER
                                OR  (
                                    REC.AMOUNT_TRX_NUMBER > 0 
                                    AND (
                                        REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER
                                        OR
                                        REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER 
                                    )
                                )
                            )
                        )
                    ");
                });
            })
            ->whereRaw("upper(payment_status) = 'CONFIRM'")
            ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
            ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
            ->with([
                'details',
                'paymentMatchs' => function ($q) use($close_date){
                    return $q->where('match_flag', 'N')
                    ->whereDate('last_update_date', $close_date)
                    ->where(function($t) {
                        return $t->whereRaw("
                            EXISTS (
                                SELECT  1
                                FROM    PTOM_AR_RECEIPTS_V      REC,
                                    PTOM_PAYMENT_HEADERS        PH
                                WHERE   1=1
                                AND     PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                                AND     PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'N'
                                AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                                AND     (
                                    REC.TRX_NUMBER = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER
                                    OR  (
                                        REC.AMOUNT_TRX_NUMBER > 0 
                                        AND (
                                            REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER
                                            OR
                                            REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER 
                                        )
                                    )
                                )
                            )
                        ");
                    });
                },
            ])
            ->get();

            foreach ($payments as $payment) {
                if(!$report){
                    $payment->web_batch_no = $batch_no;
                }
                $payment->ar_invoice_group_id = $group_id;
                $payment->save();
                $count = $payment->details->count();

                $groupOrder = $payment->paymentMatchs
                ->groupBy([
                    "prepare_order_number",
                    "invoice_number",
                    "payment_detail_id",
                    function($item){
                        return $item->credit_group_code == '0' ? '0' : '1';
                    }
                ]);

                foreach($groupOrder as $prepare_no => $groupInvoice){
                    foreach($groupInvoice as $invoice_no => $groupDetails){
                        foreach($groupDetails as $detail_id => $groupCode){
                            foreach($groupCode as $group_code => $matchs){
                                $match = $matchs->first();
                                $gain_loss_amount = 0;
                                $send_line_tax = false;
                                $send_gain_loss = false;
                                $detail = $match->detail;
                                $invoice_ex_rate = 1;
                                $detail_ex_rate = $detail->conversion_rate ?: 1;

                                $receipt_number = $count > 1 ? $payment->payment_number.'-'.$detail->line_number : $payment->payment_number;

                                $apply_amount = (float)$matchs->sum("payment_amount");

                                if($match->match_flag === 'N'){

                                    if(strtoupper($sale_class) == 'DOMESTIC'){
                                        if($group_code == '0'){
                                            $invoice_number = 'Receipt Write-off';
                                            $attr1 = $prepare_no ?: $invoice_no;
                                        }else {
                                            $invoice_number = $invoice_no;
                                            $attr1 = null;
                                        }
                                    }else {
                                        $invoice_ex_rate = optional($match->proformaHeaders()->whereRaw("upper(pick_release_status) = 'CONFIRM'")->where('pick_release_no', $match->invoice_number)->first())->pick_exchange_rate ?: 1;

                                        $gain_loss_amount = round(($apply_amount * $detail_ex_rate) - ($apply_amount * $invoice_ex_rate), 4);
                                        if(!!$invoice_no){
                                            $apply_amount = $apply_amount * $invoice_ex_rate;
                                            $invoice_number = $invoice_no;
                                            $attr1 = null;
                                        }else {
                                            $apply_amount = $apply_amount * $detail_ex_rate;
                                            $invoice_number = 'Receipt Write-off';
                                            $attr1 = $prepare_no;
                                            $send_line_tax = true;
                                        }

                                        if( $match->payment_type_code == '20' && $gain_loss_amount != 0){
                                            $send_gain_loss = true;
                                        }
                                    }
                                    
                                    $receiptV = PtomARReceiptsV::where('receipt_number', $receipt_number)
                                        ->where(function($q) use($invoice_number, $attr1){
                                            return $q->where('trx_number', $invoice_number)
                                                ->orWhere('attribute1', $attr1);
                                        })
                                        ->get();

                                    if($receiptV->count()){

                                        if($send_line_tax){
                                            $found = OrderHeader::where('prepare_order_number', $prepare_no)->first();

                                            if($found){
                                                $tax = TaxCode::where('tax', $found->vat_code)->where('rate_type_code', 'PERCENTAGE')->first();
                                                $percentage_rate = optional($tax)->percentage_rate ?? 0;
                                                $tax_amount = (float)$apply_amount * $percentage_rate / (100+$percentage_rate);
                                                InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, ($apply_amount - $tax_amount), $count, $creation_date, $close_date, false, $report);
                                                InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, $tax_amount, $count, $creation_date, $close_date, false, $report, $send_line_tax);
                                            }else {
                                                InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, $apply_amount, $count, $creation_date, $close_date, false, $report);
                                            }
                                        }else {
                                            InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, $apply_amount, $count, $creation_date, $close_date, false, $report);
                                        }

                                        if($send_gain_loss){
                                            InterfaceRepo::insertARReceipt($sale_class, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_number, $attr1, $match->match_flag, $gain_loss_amount, $count, $creation_date, $close_date, false, $report, false, $send_gain_loss);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }catch (\Exception $e) {

            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function insertDataCaseCNDN($request, $program_code, $batch_no, $group_id, $creation_date, $report = false)
    {
        try {
            (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

            $close_date = $request->close_date;
            $sale_class = $request->sale_class;

            $payments_cndn = PaymentApply::where(function($q){
                $q->whereIn('attribute1', ['Y', 'N']);
            })
            ->whereHas('invoiceHeader', function($q) use($sale_class){
                $q->whereHas('customer', function($p) use($sale_class){
                    $p->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'");
                });
            })
            ->where(function($q){
                $q->doesnthave('interfaces')
                ->orWhereHas('latestInterface', function($p){
                    $p->whereRaw("PTOM_PAYMENT_APPLY_CNDN.ATTRIBUTE1 != PTOM_AR_APPLY_CN_INTERFACE.APPLY_FLAG");
                });
            })
            ->whereDate('last_update_date', $close_date)
            ->get();
    
            $toat_org = (new InterfaceRepo)->getToatOrg();
    
            foreach ($payments_cndn as $cndn) {
                InterfaceRepo::insertCNApply($cndn, $program_code, $group_id, $batch_no, $creation_date, $toat_org);
            }

        }catch (\Exception $e) {

            throw new \Exception($e->getMessage(), 1);
        }
    }

    private static function getDocumentDate($saleClass)
    {
        (new InterfaceRepo)->setGlobalOrg(); // set global org for receiptV

        $closeDateLists = [];

        //// case ตั้ง Receipt ////
        $closeDateLists = self::getDateCaseCreateReceipt($closeDateLists, $saleClass);

        //// case cancel receipt ////
        $closeDateLists = self::getDateCaseCancelReceipt($closeDateLists, $saleClass);

        //// หาวันที่ของเคส applies ไม่มียังไม่ interface ////
        $closeDateLists = self::getDateCaseApplyReceipt($closeDateLists, $saleClass);

        //// หาวันที่ของเคส unapplies ถ้ามี match ไหนมี Y ส่ง N แต่ถ้าไม่มี ไม่ส่ง ////
        $closeDateLists = self::getDateCaseUnApplyReceipt($closeDateLists, $saleClass);

        // $closeDateLists = self::getDateCaseCNDN($closeDateLists, $saleClass);
        // dd($closeDateLists, $payments);

        ksort($closeDateLists);

        return $closeDateLists;
    }

    private static function getDateCaseCreateReceipt($array, $saleClass)
    {
        //// case ตั้ง Receipt ////
        $closeDateLists = $array;

        $payments = PaymentHeader::whereRaw("payment_status = 'Confirm'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($saleClass)."'")
        ->whereNotIn('payment_number', ['RC2108001', 'RC2001002-C'])//'RC2003002'
        ->whereRaw("
            NOT EXISTS (
                SELECT  1
                FROM    PTOM_AR_RECEIPTS_V      REC
                WHERE   PTOM_PAYMENT_HEADERS.PAYMENT_STATUS = 'Confirm'
                AND     UPPER(PTOM_PAYMENT_HEADERS.SALES_CLASSIFICATION_CODE) = '". strtoupper($saleClass) ."'
                AND     REC.RECEIPT_NUMBER LIKE PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER||'%'
            )
        ")
        // ->whereRaw("trunc(payment_date) = to_date('2023-02-03')")
        ->selectRaw('trunc(payment_date) payment_date')
        ->distinct()
        ->get('payment_date');
        // ->get();

        // dd('create', $payments);

        foreach ($payments as $payment) {
            $closeDateLists = self::insertDateInArray($closeDateLists, $payment->payment_date);
        }

        return $closeDateLists;
    }

    private static function getDateCaseCancelReceipt($array, $saleClass)
    {
        //// case cancel receipt ////
        $closeDateLists = $array;

        $payments = PaymentHeader::whereRaw("upper(payment_status) = UPPER('CANCEL')")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($saleClass)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->where(function($q) use ($saleClass) {
            return $q->whereDoesntHave('interfaces')
            ->orWhereRaw("
                NOT EXISTS (
                    SELECT  1
                    FROM    PTOM_AR_RECEIPTS_V      REC,
                        PTOM_PAYMENT_HEADERS        PH
                    WHERE   UPPER(PH.PAYMENT_STATUS) = UPPER('CANCEL')
                    AND     UPPER(PH.SALES_CLASSIFICATION_CODE) = '". strtoupper($saleClass) ."'
                    AND     REC.RECEIPT_NUMBER LIKE PH.PAYMENT_NUMBER||'%'
                    AND     PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                )
            ")
            ->orWhereRaw("
                EXISTS (
                    SELECT  1
                    FROM    PTOM_AR_RECEIPTS_V      REC,
                        PTOM_PAYMENT_HEADERS        PH
                    WHERE   UPPER(PH.PAYMENT_STATUS) = UPPER('CANCEL')
                    AND     UPPER(PH.SALES_CLASSIFICATION_CODE) = '". strtoupper($saleClass) ."'
                    AND     REC.RECEIPT_NUMBER LIKE PH.PAYMENT_NUMBER||'%'
                    AND     UPPER(REC.STATE) <> UPPER('REVERSED')
                    AND     PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                )
            ");
        })
        // ->whereRaw("trunc(payment_date) = to_date('2023-02-03')")
        ->selectRaw('trunc(last_update_date) last_update_date')
        ->distinct()
        ->get('last_update_date');
        // ->get();

        // dd('cancel', $payments);

        foreach ($payments as $payment) {

           // $date = $payment->payment_date > $payment->last_update_date ? $payment->payment_date : $payment->last_update_date;
            $closeDateLists = self::insertDateInArray($closeDateLists, $payment->last_update_date);
        }

        return $closeDateLists;
    }

    private static function getDateCaseApplyReceipt($array, $saleClass)
    {
        //// case cancel receipt ////
        $closeDateLists = $array;

        //// หาวันที่ของเคส applies ที่ยังไม่ interface ////
        // $payments = PaymentHeader::select(
        //     'PAYMENT_HEADER_ID', 
        //     'PAYMENT_STATUS', 
        //     'SALES_CLASSIFICATION_CODE', 
        //     'PAYMENT_NUMBER',
        //     'PAYMENT_DATE'
        // )
        // ->whereRaw("UPPER(PAYMENT_STATUS) = UPPER('CONFIRM')")
        // ->whereRaw("UPPER(SALES_CLASSIFICATION_CODE) = '".strtoupper($saleClass)."'")
        // ->whereHas('paymentMatchs', function($q) {
        //     return $q->where('match_flag', 'Y')
        //     ->where(function($t) {
        //         return $t->whereDoesntHave('interfaces')
        //         ->orWhereRaw("
        //             NOT EXISTS (
        //                 SELECT  1
        //                 FROM    PTOM_AR_RECEIPTS_V      REC,
        //                     PTOM_PAYMENT_HEADERS        PH,
        //                     PTOM_PAYMENT_MATCH_INVOICES MATCH
        //                 WHERE   1=1
        //                 AND     MATCH.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
        //                 AND     MATCH.MATCH_FLAG = 'Y'
        //                 AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
        //                 AND     (
        //                     REC.TRX_NUMBER = MATCH.INVOICE_NUMBER
        //                     OR  (
        //                         REC.AMOUNT_TRX_NUMBER > 0 
        //                         AND (
        //                             REC.ATTRIBUTE1 = MATCH.PREPARE_ORDER_NUMBER
        //                             OR
        //                             REC.ATTRIBUTE1 = MATCH.INVOICE_NUMBER 
        //                         )
        //                     )
        //                 )
        //             )
        //         ");
        //     });
        // })
        // ->with([
        //     'details',
        //     'paymentMatchs' => function ($q) use($saleClass){
        //         return $q->where('match_flag', 'Y')
        //         ->where(function($t) {
        //             return $t->whereDoesntHave('interfaces')
        //             ->orWhereRaw("
        //                 NOT EXISTS (
        //                     SELECT  1
        //                     FROM    PTOM_AR_RECEIPTS_V      REC,
        //                         PTOM_PAYMENT_HEADERS        PH,
        //                         PTOM_PAYMENT_MATCH_INVOICES MATCH
        //                     WHERE   1=1
        //                     AND     MATCH.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
        //                     AND     MATCH.MATCH_FLAG = 'Y'
        //                     AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
        //                     AND     (
        //                         REC.TRX_NUMBER = MATCH.INVOICE_NUMBER
        //                         OR  (
        //                             REC.AMOUNT_TRX_NUMBER > 0 
        //                             AND (
        //                                 REC.ATTRIBUTE1 = MATCH.PREPARE_ORDER_NUMBER
        //                                 OR
        //                                 REC.ATTRIBUTE1 = MATCH.INVOICE_NUMBER 
        //                             )
        //                         )
        //                     )
        //                 )
        //             ");
        //         });
        //     },
        // ])
        // ->get();


        $payments = PaymentHeader::select(
            'PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID', 
            'PTOM_PAYMENT_HEADERS.PAYMENT_STATUS', 
            'PTOM_PAYMENT_HEADERS.SALES_CLASSIFICATION_CODE', 
            'PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER',
            'PTOM_PAYMENT_HEADERS.PAYMENT_DATE'
        )
        ->join('PTOM_PAYMENT_MATCH_INVOICES', function ($join) {
            $join->on('PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID', '=', 'PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID')
            ->where('PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG', 'Y');
        })
        ->leftJoin('PTOM_AR_RECEIPT_INTERFACE', 'PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_MATCH_ID', '=', 'PTOM_AR_RECEIPT_INTERFACE.MATCH_ID')
        ->leftJoin('PTOM_AR_RECEIPTS_V', "PTOM_AR_RECEIPTS_V.RECEIPT_NUMBER", '=', DB::raw("CONCAT(PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER,'%')"))
        ->whereRaw("UPPER(PAYMENT_STATUS) = UPPER('CONFIRM')")
        ->whereRaw("UPPER(SALES_CLASSIFICATION_CODE) = '".strtoupper($saleClass)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->whereRaw("PTOM_AR_RECEIPT_INTERFACE.MATCH_ID IS NULL")
        ->whereRaw("PTOM_AR_RECEIPTS_V.RECEIPT_NUMBER IS NULL")
        ->with([
            'details',
            'paymentMatchs' => function ($q) use($saleClass){
                return $q->where('match_flag', 'Y');
            },
        ])
        ->distinct()
        ->get();

        // dd('apply', $payments);

        foreach ($payments as $payment) {
            $matchs = $payment->paymentMatchs;

            $count = $payment->details->count();

            foreach ($matchs as $match) {
                $detail = $match->detail;

                $receipt_number = $count > 1 ? $payment->payment_number.'-'.$detail->line_number : $payment->payment_number;
                
                if($match->match_flag === 'Y'){

                    if(strtoupper($saleClass) == 'DOMESTIC'){
                        if($match->credit_group_code == '0'){
                            $invoice_number = 'Receipt Write-off';
                            $attr1 = $match->prepare_order_number ?: $match->invoice_number;
                        }else {
                            $invoice_number = $match->invoice_number;
                            $attr1 = null;
                        }
                    }else {
                        if(!!$match->invoice_number){

                            $invoice_number = $match->invoice_number;
                            $attr1 = null;
                        }else {

                            $invoice_number = 'Receipt Write-off';
                            $attr1 = $match->prepare_order_number;
                        }
                    }

                    $receiptV = PtomARReceiptsV::where('receipt_number', $receipt_number)
                    ->where(function($q) use($invoice_number, $attr1){
                        return $q->where('trx_number', $invoice_number)
                            ->orWhere('attribute1', $attr1);
                    })
                    ->get();

                    if(!$receiptV->count()){

                        $date = $match->last_update_date;
                        $closeDateLists = self::insertDateInArray($closeDateLists, $date);
                    }
                }
            }
        }

        return $closeDateLists;
    }

    private static function getDateCaseUnApplyReceipt($array, $saleClass)
    {
        //// case cancel receipt ////
        $closeDateLists = $array;

        //// หาวันที่ของเคส unapplies ถ้ามี match ไหนมี Y ส่ง N แต่ถ้าไม่มี ไม่ส่ง ////
        $payments = PaymentHeader::select(
            'PAYMENT_HEADER_ID', 
            'PAYMENT_STATUS', 
            'SALES_CLASSIFICATION_CODE', 
            'PAYMENT_NUMBER',
            'PAYMENT_DATE'
        )->whereRaw("UPPER(PAYMENT_STATUS) = UPPER('CONFIRM')")
        ->whereRaw("UPPER(SALES_CLASSIFICATION_CODE) = '".strtoupper($saleClass)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->whereHas('paymentMatchs', function($q) {
            return $q->where('match_flag', 'N')
            ->where(function($t) {
                return $t->whereRaw("
                    EXISTS (
                        SELECT  1
                        FROM    PTOM_AR_RECEIPTS_V      REC,
                            PTOM_PAYMENT_HEADERS        PH,
                            PTOM_PAYMENT_MATCH_INVOICES MATCH
                        WHERE   1=1
                        AND     MATCH.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                        AND     MATCH.MATCH_FLAG = 'N'
                        AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                        AND     (
                            REC.TRX_NUMBER = MATCH.INVOICE_NUMBER
                            OR  (
                                REC.AMOUNT_TRX_NUMBER > 0 
                                AND (
                                    REC.ATTRIBUTE1 = MATCH.PREPARE_ORDER_NUMBER
                                    OR
                                    REC.ATTRIBUTE1 = MATCH.INVOICE_NUMBER 
                                )
                            )
                        )
                    )
                ");
            });
        })
        ->with([
            'details',
            'paymentMatchs' => function ($q){
                return $q->where('match_flag', 'N')
                ->where(function($t) {
                    return $t->whereRaw("
                        EXISTS (
                            SELECT  1
                            FROM    PTOM_AR_RECEIPTS_V      REC,
                                PTOM_PAYMENT_HEADERS        PH,
                                PTOM_PAYMENT_MATCH_INVOICES MATCH
                            WHERE   1=1
                            AND     MATCH.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                            AND     MATCH.MATCH_FLAG = 'N'
                            AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                            AND     (
                                REC.TRX_NUMBER = MATCH.INVOICE_NUMBER
                                OR  (
                                    REC.AMOUNT_TRX_NUMBER > 0 
                                    AND (
                                        REC.ATTRIBUTE1 = MATCH.PREPARE_ORDER_NUMBER
                                        OR
                                        REC.ATTRIBUTE1 = MATCH.INVOICE_NUMBER 
                                    )
                                )
                            )
                        )
                    ");
                });
            },
        ])
        ->get();

        // dd('un-apply', $payments);
        
        foreach ($payments as $payment) {
            $matchs = $payment->paymentMatchs;

            $count = $payment->details->count();
            foreach ($matchs as $match) {
                $detail = $match->detail;

                $receipt_number = $count > 1 ? $payment->payment_number.'-'.$detail->line_number : $payment->payment_number;

                if($match->match_flag === 'N'){

                    if(strtoupper($saleClass) == 'DOMESTIC'){
                        if($match->credit_group_code == '0'){
                            $invoice_number = 'Receipt Write-off';
                            $attr1 = $match->prepare_order_number ?: $match->invoice_number;
                        }else {
                            $invoice_number = $match->invoice_number;
                            $attr1 = null;
                        }
                    }else {
                        if(!!$match->invoice_number){

                            $invoice_number = $match->invoice_number;
                            $attr1 = null;
                        }else {

                            $invoice_number = 'Receipt Write-off';
                            $attr1 = $match->prepare_order_number;
                        }
                    }
                    
                    $receiptV = PtomARReceiptsV::where('receipt_number', $receipt_number)
                    ->where(function($q) use($invoice_number, $attr1){
                        return $q->where('trx_number', $invoice_number)
                            ->orWhere('attribute1', $attr1);
                    })
                    ->get();

                    if($receiptV->count()){

                        $date = $match->last_update_date;
                            $closeDateLists = self::insertDateInArray($closeDateLists, $date);
                    }
                }
            }
        }

        return $closeDateLists;
    }

    private static function getDateCaseCNDN($array, $saleClass)
    {
        $closeDateLists = $array;

        $payments_cndn = PaymentApply::where(function($q){
            $q->whereIn('attribute1', ['Y', 'N']);
        })
        ->whereHas('invoiceHeader', function($q) use($saleClass){
            $q->whereHas('customer', function($p) use($saleClass){
                $p->whereRaw("upper(sales_classification_code) = '".strtoupper($saleClass)."'");
            });
        })
        ->where(function($q){
            $q->doesnthave('interfaces')
            ->orWhereHas('latestInterface', function($p){
                $p->whereRaw("PTOM_PAYMENT_APPLY_CNDN.ATTRIBUTE1 != PTOM_AR_APPLY_CN_INTERFACE.APPLY_FLAG");
            });
        })
        ->get();

        foreach ($payments_cndn as $cndn) {
            $latest_inteface = $cndn->interfaces()->latest()->first();
            if(!!$latest_inteface){
                if($cndn->attribute1 != $latest_inteface->apply_flag){
                    $closeDateLists = self::insertDateInArray($closeDateLists, $cndn->last_update_date);
                }
            }else {
                $closeDateLists = self::insertDateInArray($closeDateLists, $cndn->last_update_date);
            }
        }

        return $closeDateLists;
    }

    private static function insertDateInArray($array, $date)
    {
        $key = Carbon::parse($date)->format('Y-m-d');
        $label = Carbon::parse($date)->addYears(543)->format('d-m-Y');
        if( !array_key_exists($key, $array) ){
            $array[$key] = $label;
        }
        return $array;
    }

    private static function genGroupId($request)
    {
        $group_id = collect();
        $close_date = $request->close_date;
        $sale_class = $request->sale_class;

        $case_create = PaymentHeader::whereRaw("upper(payment_status) = 'CONFIRM'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->whereDate('payment_date', $close_date)
        ->whereRaw("
            NOT EXISTS (
                SELECT  1
                FROM    PTOM_AR_RECEIPTS_V      REC
                WHERE   UPPER(PTOM_PAYMENT_HEADERS.PAYMENT_STATUS) = UPPER('CONFIRM')
                AND     UPPER(PTOM_PAYMENT_HEADERS.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                AND     REC.RECEIPT_NUMBER LIKE PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER||'%'
            )
        ")
        ->get();

        $case_cancel = PaymentHeader::whereRaw("upper(payment_status) = 'CANCEL'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->where(function($q) use ($sale_class) {
            return $q->whereDoesntHave('interfaces')
            ->orWhereRaw("
                NOT EXISTS (
                    SELECT  1
                    FROM    PTOM_AR_RECEIPTS_V      REC,
                        PTOM_PAYMENT_HEADERS        PH
                    WHERE   UPPER(PH.PAYMENT_STATUS) = UPPER('CANCEL')
                    AND     UPPER(PH.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                    AND     REC.RECEIPT_NUMBER LIKE PH.PAYMENT_NUMBER||'%'
                    AND     PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                )
            ")
            ->orWhereRaw("
                EXISTS (
                    SELECT  1
                    FROM    PTOM_AR_RECEIPTS_V      REC,
                        PTOM_PAYMENT_HEADERS        PH
                    WHERE   UPPER(PH.PAYMENT_STATUS) = UPPER('CANCEL')
                    AND     UPPER(PH.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                    AND     REC.RECEIPT_NUMBER LIKE PH.PAYMENT_NUMBER||'%'
                    AND     UPPER(REC.STATE) <> UPPER('REVERSED')
                    AND     PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                )
            ");
        })
        ->whereDate('last_update_date', $close_date)
        ->get();

        $case_apply = PaymentHeader::whereRaw("upper(payment_status) = 'CONFIRM'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->whereHas('paymentMatchs', function($q) use($close_date, $sale_class){
            return $q->where('match_flag', 'Y')
            ->whereDate('last_update_date', $close_date)
            ->where(function($t) {
                return $t->whereDoesntHave('interfaces')
                ->orWhereRaw("
                    NOT EXISTS (
                        SELECT  1
                        FROM    PTOM_AR_RECEIPTS_V      REC,
                            PTOM_PAYMENT_HEADERS        PH
                        WHERE   1=1
                        AND     PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                        AND     PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y'
                        AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                        AND     (
                            REC.TRX_NUMBER = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER
                            OR  (
                                REC.AMOUNT_TRX_NUMBER > 0 
                                AND (
                                    REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER
                                    OR
                                    REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER 
                                )
                            )
                        )
                    )
                ");
            });
        })
        ->get();

        $case_unapply = PaymentHeader::whereHas('paymentMatchs', function($q) use($close_date){
            return $q->where('match_flag', 'N')
            ->whereDate('last_update_date', $close_date)
            ->where(function($t) {
                return $t->whereRaw("
                    EXISTS (
                        SELECT  1
                        FROM    PTOM_AR_RECEIPTS_V      REC,
                            PTOM_PAYMENT_HEADERS        PH
                        WHERE   1=1
                        AND     PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                        AND     PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'N'
                        AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                        AND     (
                            REC.TRX_NUMBER = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER
                            OR  (
                                REC.AMOUNT_TRX_NUMBER > 0 
                                AND (
                                    REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER
                                    OR
                                    REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER 
                                )
                            )
                        )
                    )
                ");
            });
        })
        ->whereRaw("upper(payment_status) = 'CONFIRM'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->get();


        if($case_create->count()){
            $groups = $case_create->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($case_cancel->count()){
            $groups = $case_cancel->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($case_apply->count()){
            $groups = $case_apply->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($case_unapply->count()){
            $groups = $case_unapply->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        return $group_id->filter()->unique()->sortDesc()->first() ?? getGroupID();
    }

    private static function getOldGroupId($request)
    {
        $group_id = collect();
        $close_date = $request->close_date;
        $sale_class = $request->sale_class;
        $program_code = strtoupper($sale_class) == strtoupper('domestic') ? 'OMP0045' : 'OMP0079';

        $case_create = PaymentHeader::select("ar_invoice_group_id")
        ->whereRaw("upper(payment_status) = 'CONFIRM'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->whereDate('payment_date', $close_date)
        ->whereRaw("
            NOT EXISTS (
                SELECT  1
                FROM    PTOM_AR_RECEIPTS_V      REC
                WHERE   UPPER(PTOM_PAYMENT_HEADERS.PAYMENT_STATUS) = UPPER('CONFIRM')
                AND     UPPER(PTOM_PAYMENT_HEADERS.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                AND     REC.RECEIPT_NUMBER LIKE PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER||'%'
            )
        ")
        ->distinct()
        ->pluck("ar_invoice_group_id");

        $case_cancel = PaymentHeader::select("ar_invoice_group_id")
        ->whereRaw("upper(payment_status) = 'CANCEL'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->where(function($q) use ($sale_class) {
            return $q->whereDoesntHave('interfaces')
            ->orWhereRaw("
                NOT EXISTS (
                    SELECT  1
                    FROM    PTOM_AR_RECEIPTS_V      REC,
                        PTOM_PAYMENT_HEADERS        PH
                    WHERE   UPPER(PH.PAYMENT_STATUS) = UPPER('CANCEL')
                    AND     UPPER(PH.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                    AND     REC.RECEIPT_NUMBER LIKE PH.PAYMENT_NUMBER||'%'
                    AND     PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                )
            ")
            ->orWhereRaw("
                EXISTS (
                    SELECT  1
                    FROM    PTOM_AR_RECEIPTS_V      REC,
                        PTOM_PAYMENT_HEADERS        PH
                    WHERE   UPPER(PH.PAYMENT_STATUS) = UPPER('CANCEL')
                    AND     UPPER(PH.SALES_CLASSIFICATION_CODE) = '". strtoupper($sale_class) ."'
                    AND     REC.RECEIPT_NUMBER LIKE PH.PAYMENT_NUMBER||'%'
                    AND     UPPER(REC.STATE) <> UPPER('REVERSED')
                    AND     PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                )
            ");
        })
        ->whereDate('last_update_date', $close_date)
        ->distinct()
        ->pluck("ar_invoice_group_id");

        $case_apply = PaymentHeader::select("ar_invoice_group_id")
        ->whereRaw("upper(payment_status) = 'CONFIRM'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->whereHas('paymentMatchs', function($q) use($close_date, $sale_class){
            return $q->where('match_flag', 'Y')
            ->whereDate('last_update_date', $close_date)
            ->where(function($t) {
                return $t->whereDoesntHave('interfaces')
                ->orWhereRaw("
                    NOT EXISTS (
                        SELECT  1
                        FROM    PTOM_AR_RECEIPTS_V      REC,
                            PTOM_PAYMENT_HEADERS        PH
                        WHERE   1=1
                        AND     PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                        AND     PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y'
                        AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                        AND     (
                            REC.TRX_NUMBER = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER
                            OR  (
                                REC.AMOUNT_TRX_NUMBER > 0 
                                AND (
                                    REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER
                                    OR
                                    REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER 
                                )
                            )
                        )
                    )
                ");
            });
        })
        ->distinct()
        ->pluck("ar_invoice_group_id");

        $case_unapply = PaymentHeader::select("ar_invoice_group_id")
        ->whereHas('paymentMatchs', function($q) use($close_date){
            return $q->where('match_flag', 'N')
            ->whereDate('last_update_date', $close_date)
            ->where(function($t) {
                return $t->whereRaw("
                    EXISTS (
                        SELECT  1
                        FROM    PTOM_AR_RECEIPTS_V      REC,
                            PTOM_PAYMENT_HEADERS        PH
                        WHERE   1=1
                        AND     PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID = PH.PAYMENT_HEADER_ID
                        AND     PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'N'
                        AND     REC.RECEIPT_NUMBER      LIKE PH.PAYMENT_NUMBER||'%'
                        AND     (
                            REC.TRX_NUMBER = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER
                            OR  (
                                REC.AMOUNT_TRX_NUMBER > 0 
                                AND (
                                    REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER
                                    OR
                                    REC.ATTRIBUTE1 = PTOM_PAYMENT_MATCH_INVOICES.INVOICE_NUMBER 
                                )
                            )
                        )
                    )
                ");
            });
        })
        ->whereRaw("upper(payment_status) = 'CONFIRM'")
        ->whereRaw("upper(sales_classification_code) = '".strtoupper($sale_class)."'")
        ->whereNotIn('payment_number', ['RC2003002', 'RC2108001', 'RC2001002-C'])
        ->distinct()
        ->pluck("ar_invoice_group_id");

        if($case_create->count()){
            foreach ($case_create as $group) {
                $group_id->push($group);
            }
        }

        if($case_cancel->count()){
            foreach ($case_cancel as $group) {
                $group_id->push($group);
            }
        }

        if($case_apply->count()){
            foreach ($case_apply as $group) {
                $group_id->push($group);
            }
        }

        if($case_unapply->count()){
            foreach ($case_unapply as $group) {
                $group_id->push($group);
            }
        }

        return $group_id->unique()->sortDesc()->values();
    }

    private function updateInvoiceNumber()
    {
        $matchs = PaymentMatchInvoice::where('credit_group_code', '!=', 0)
        ->whereNull('invoice_number')
        ->get();

        foreach($matchs as $match){
            $order = OrderHeader::where('prepare_order_number', $match->prepare_order_number)->first();
            if(!!$order){
                $match->invoice_number = $order->pick_release_no;
                $match->save();
            }
        }
    }

}