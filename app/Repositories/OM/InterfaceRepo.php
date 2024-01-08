<?php

namespace App\Repositories\OM;

class InterfaceRepo
{
    public static function interfaceAP($batch)
    {
    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "

                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN
                        
                            PTOM_WEB_UTILITIES_PKG.CREATE_AP_INTERFACE(
                                P_BATCH_NO        =>  :batch
                                ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG     =>  :LV_RETURN_MSG 
                            );
                            
                        END;

                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceARReport($batch)
    {
        try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "
                        DECLARE
                            LV_RETURN_STATUS        VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG           VARCHAR2(4000)  :=  NULL;
                            V_ORGANIZATION_ID       NUMBER          :=  NULL;

                        BEGIN
                            BEGIN 
                                SELECT  ORGANIZATION_ID
                                INTO    V_ORGANIZATION_ID
                                FROM    HR_OPERATING_UNITS
                                WHERE   SHORT_CODE = 'TOAT';
                            END;
                             
                            mo_global.set_policy_context('S', V_ORGANIZATION_ID);

                            PTOM_WEB_UTILITIES_PKG.CREATE_AR_INVOICE_REPORT(
                                P_BATCH_NO          =>  :batch
                                ,O_RETURN_STATUS    =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG       =>  :LV_RETURN_MSG 
                            );
                        
                        END;

                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceAR($batch)
    {
    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "
                        DECLARE
                            LV_RETURN_STATUS        VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG           VARCHAR2(4000)  :=  NULL;
                            V_ORGANIZATION_ID       NUMBER          :=  NULL;

                        BEGIN
                            
                            BEGIN 
                                SELECT  ORGANIZATION_ID
                                INTO    V_ORGANIZATION_ID
                                FROM    HR_OPERATING_UNITS
                                WHERE   SHORT_CODE = 'TOAT';
                            END;
                             
                            mo_global.set_policy_context('S', V_ORGANIZATION_ID);

                            FND_GLOBAL.APPS_INITIALIZE(
                                USER_ID        => 0,
                                RESP_ID      => 20678,
                                RESP_APPL_ID => 222
                            );
                            
                            PTOM_WEB_UTILITIES_PKG.CREATE_AR_INVOICE(
                                P_BATCH_NO          =>  :batch
                                ,O_RETURN_STATUS    =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG       =>  :LV_RETURN_MSG 
                            );
                        
                        END;

                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceGL($batch)
    {
    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "
                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN


                            PTOM_WEB_UTILITIES_PKG.CREATE_GL_INTERFACE(
                                P_BATCH_NO          =>  :batch
                                ,O_RETURN_STATUS    =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG       =>  :LV_RETURN_MSG 
                            );

                        END;
                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceGainLoss($batch)
    {
        try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "
                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN


                            PTOM_WEB_UTILITIES_PKG.CREATE_GL_GAIN_LOSS(
                                P_BATCH_NO          =>  :batch
                                ,O_RETURN_STATUS    =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG       =>  :LV_RETURN_MSG 
                            );

                        END;
                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceSaleOrder($batch)
    {
    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "

                        DECLARE
                            LV_RETURN_STATUS        VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG           VARCHAR2(4000)  :=  NULL;
                        BEGIN

                            PTOM_WEB_UTILITIES_PKG.CREATE_SALE_ORDER(
                                P_BATCH_NO        =>  :batch
                                ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG     =>  :LV_RETURN_MSG
                            );

                        END;

                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceSaleOrderRMA($batch)
    {
    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "

                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN

                            PTOM_WEB_UTILITIES_PKG.CREATE_SALE_ORDER_RMA(
                                P_BATCH_NO        =>  :batch
                                ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG     =>  :LV_RETURN_MSG
                            );

                        END;

                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceSaleOrderConsignment($batch)
    {
    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "

                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN

                            PTOM_WEB_UTILITIES_PKG.CREATE_SALE_ORDER_CONSIGNMENT(
                                P_BATCH_NO        =>  :batch
                                ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG     =>  :LV_RETURN_MSG
                            );

                        END;

                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceARReceipt($batch)
    {
    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "

                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN

                            PTOM_WEB_UTILITIES_PKG.CREATE_AR_RECEIPT(
                                P_BATCH_NO        =>  :batch
                                ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG     =>  :LV_RETURN_MSG 
                            );
                        
                        END;

                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfacePickShip($source_name)
    {
        try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "

                        DECLARE
                            o_request_id          VARCHAR2(100)   :=  NULL;
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                            v_user_id             NUMBER          :=  NULL;
                            v_org_id              NUMBER          :=  NULL;
                            v_return_status       VARCHAR2(100)   :=  NULL;
                            
                        BEGIN

                            SELECT user_id
                            INTO v_user_id
                            FROM fnd_user
                            WHERE user_name = 'SYSADMIN';
                            
                            select organization_id
                            into v_org_id
                            from hr_operating_units
                            where short_code = 'TOAT';
                            
                            :v_return_status := PTOM_INTERFACE_PICK_SHIP_PKG.CALL_SUBMIT_PROGRAM(
                                i_org_id            =>  v_org_id
                                ,i_user_id          =>  v_user_id
                                ,i_source_name      =>  :i_source_name
                                ,o_return_status    =>  :LV_RETURN_STATUS   
                                ,o_return_msg       =>  :LV_RETURN_MSG
                                ,o_request_id       =>  :o_request_id
                            );
                        
                        END;
                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':i_source_name', $source_name, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':o_request_id', $result['request_id'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':v_return_status', $result['v_return_status'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function interfaceRMA($source_name)
    {
        try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "

                        DECLARE
                            o_request_id          VARCHAR2(100)   :=  NULL;
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                            v_user_id             NUMBER          :=  NULL;
                            v_org_id              NUMBER          :=  NULL;
                            v_return_status       VARCHAR2(100)   :=  NULL;
                            
                        BEGIN

                            SELECT user_id
                            INTO v_user_id
                            FROM fnd_user
                            WHERE user_name = 'SYSADMIN';
                            
                            select organization_id
                            into v_org_id
                            from hr_operating_units
                            where short_code = 'TOAT';
                            
                            :v_return_status := PTOM_INTERFACE_RMA_PKG.CALL_SUBMIT_PROGRAM(
                                i_org_id            =>  v_org_id
                                ,i_user_id          =>  v_user_id
                                ,i_source_name      =>  :i_source_name
                                ,o_return_status    =>  :LV_RETURN_STATUS   
                                ,o_return_msg       =>  :LV_RETURN_MSG
                                ,o_request_id       =>  :o_request_id
                            );
                        
                        END;
                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':i_source_name', $source_name, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':o_request_id', $result['request_id'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':v_return_status', $result['v_return_status'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function insertARReceipt($type, $program_code, $group_id, $batch_no, $payment, $match, $detail, $invoice_no, $attr1, $apply_flag, $apply_amount, $count, $creation_date, $close_date, $reverse = false, $report = false, $line_tax = false, $gain_loss = false)
    {
        $user_id = getDefaultData('/users')->user_id;

        $interface = $report ? new \App\Models\OM\ARReceiptInfReport : new \App\Models\OM\ARReceiptInterface;

        $interface->group_id                = $group_id;
        $interface->organization_name       = 'การยาสูบแห่งประเทศไทย';
        $interface->batch_type              = 'MANUAL-REGULAR';
        $interface->batch_source            = 'WEB-ระบบขาย';
        $interface->batch_number            = $group_id; //$payment->web_batch_no;
        $interface->batch_date              = $creation_date;
        $interface->batch_gl_date           = $payment->payment_date;
        $interface->batch_currency          = 'THB'; // $detail->currency;

        $interface->exchange_rate           = 1; // $detail->conversion_rate;
        $interface->exchange_rate_type      = 'User';
        $interface->receipt_class           = $type == 'domestic' ? 'ระบบขายในประเทศ' : 'ระบบขายต่างประเทศ';
        $interface->receipt_type            = 'Standard';

        if($type == 'domestic'){
            $method = \App\Models\OM\Customers\Domestics\PaymentMethod::where('lookup_code', $detail->payment_method_code)->first();
        }else {
            $method = \App\Models\OM\Customers\Export\PaymentMethodExport::where('lookup_code', $detail->payment_method_code)->first();
        }

        $interface->receipt_method_name     = $method->description;

        $interface->currency_code           = 'THB'; // $detail->currency;
        $interface->exchange_rate_date      = $payment->payment_date;

        $receipt_amount = $detail->conversion_amount ?? $detail->payment_amount;// $payment->program_code == 'OMP0024' ? ($count > 1 ? $detail->payment_amount : $payment->total_payment_amount) : $detail->conversion_amount;
        $interface->receipt_amount          = (in_array($apply_flag, ['N']) ? -1 : 1) * abs($receipt_amount);

        $interface->receipt_number          = $count > 1 ? $payment->payment_number.'-'.$detail->line_number : $payment->payment_number;
        $interface->receipt_date            = $payment->payment_date;
        $interface->gl_date                 = $payment->payment_date; // $close_date;
        $interface->maturity_date           = $payment->payment_date;

        $customer = $payment->customer;

        $interface->customer_name           = $customer->customer_name;
        $interface->customer_number         = $customer->customer_number;
        $interface->deposit_date            = $payment->payment_date;
        $qry_acc = $qry_desc = [];

        $purpose = '';

        if($gain_loss){

            $purpose = $apply_amount > 0 ? 'กำไรจากอัตราแลกเปลี่ยน' : 'ขาดทุนจากอัตราแลกเปลี่ยน';
            $qry_acc = \DB::select("
                SELECT CONCATENATED_SEGMENTS 
                FROM PTOM_RECEIPT_WRITE_OFF_V 
                WHERE NAME = '". $purpose ."'
            ");

        }elseif($invoice_no == 'Receipt Write-off'){
            $interface->attribute1      = $attr1;

            $qry_desc = \DB::select("
                SELECT DESCRIPTION 
                FROM PTOM_ORDER_TYPE_RECEIPT_WO_V 
                WHERE LOOKUP_CODE IN (
                    SELECT DISTINCT ORDER_TYPE_ID
                    FROM PTOM_ORDER_HEADERS OH
                    WHERE OH.PREPARE_ORDER_NUMBER = '". (optional($match)->prepare_order_number ?? $attr1) ."'
                )
            ");

            if($line_tax){
                $purpose = 'ภาษีขาย';
            }else {
                $purpose = count($qry_desc) ? $qry_desc[0]->description : ($type == 'domestic' ? 'บุหรี่ในประเทศ - ขายในประเทศ' : 'บุหรี่ต่างประเทศ - ขายต่างประเทศ');
            }

            $qry_acc = \DB::select("
                SELECT CONCATENATED_SEGMENTS 
                FROM PTOM_RECEIPT_WRITE_OFF_V 
                WHERE NAME = '". $purpose ."'
            ");
        }

        // $interface->attribute11             = ; // ใส่ค่า PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_HEADER_ID
        // $interface->attribute12             = ; // ใส่ค่า PTOM_PAYMENT_MATCH_INVOICES.PAYMENT_DETAIL_ID

        $interface->purpose_activity        = $purpose;
        $interface->comments                = $payment->remark;

        $interface->trans_number            = $gain_loss ? 'Receipt Write-off' : $invoice_no;
        $interface->apply_flag              = $apply_flag;
        $interface->amount_applied          = round((float)$apply_amount, 2); // invoice->amount FIFO หยิบเลข prepare หรือ invoice น้อยกว่าก่อน
        $interface->apply_date              = $close_date; // applies date
        $interface->apply_gl_date           = $close_date;

        $interface->reversal_date           = in_array($apply_flag, ['N']) ? $close_date : null; // case reverse
        $interface->reversal_gl_date        = in_array($apply_flag, ['N']) ? $close_date : null; // case reverse un-applies
        $interface->reversal_category       = $reverse ? 'Reverse Payment' : null;
        $interface->reversal_reason         = $reverse ? 'Payment Reversal' : null;

        $interface->program_code            = $program_code;
        $interface->created_by              = $user_id;
        $interface->last_updated_by         = $user_id;
        $interface->creation_date           = $creation_date;

        $interface->web_batch_no            = $batch_no;
        $interface->payment_header_id       = $detail->payment_header_id;
        $interface->payment_detail_id       = $detail->payment_detail_id;
        $interface->match_id                = optional($match)->payment_match_id;
        $interface->bank_account            = $detail->payment_no;
        $interface->operating_unit          = optional(\App\Models\HrOperatingUnits::where('short_code', 'TOAT')->first())->name ?? 'การยาสูบแห่งประเทศไทย';
        $interface->receipt_status          = !$reverse ? 'CLEARED' : 'REVERSED';
        $interface->cancel_date             = $reverse ? $close_date : null;

        $payment_exp = optional(\DB::table('ptom_payment_exp_v')
            ->where('payment_number', $payment->payment_number)
            ->first());

        if(!!$payment_exp){
            if($payment_exp->payment_type_code == '10' && $payment_exp->vat_rate != 0){
                $interface->global_attribute_category = 'WEB-ระบบขาย';
                $interface->global_attribute1 = $payment_exp->product_type_code == 10 ? 16 : 19;
                $interface->global_attribute2 = $payment_exp->conversion_amount_exclude_vat;
                $interface->global_attribute3 = $payment_exp->vat * $payment_exp->conversion_rate;
                $interface->global_attribute4 = $payment_exp->vat_code;
                $interface->global_attribute5 = $payment_exp->vat_rate;
            }
        }

        $receipt_bank_acc = optional(\DB::table('ptom_receipt_bank_acc_v')
        ->where('class_name', $interface->receipt_class)
        ->where('method_name', $interface->receipt_method_name)
        ->where('bank_account_number', $interface->bank_account)
        ->select('cash', 'unapplied_receipts')->first());

        $invoice_rec_acc = optional(\DB::table('ptom_ar_interfaces')
        ->where('invoice_number', $invoice_no)
        ->select('rec_account_combine')->first())->rec_account_combine;

        if($match){
            if(!!$invoice_no && $match->invoice_number){

                if(is_null($invoice_rec_acc)){
                    $account_code = $type == 'domestic' ? 'TRX-DOM-Sales Invoice-01' : 'TRX-EXP-Sales Invoice-01'; // $type == 'club_cig' ? 'TRX-DOM-Sales Invoice-01' : ( $type == 'club_not_cig' ? 'TRX-DOM-Sales Invoice-02' : ( $header->payment_type_code == 10 ? 'TRX-DOM-Sales Invoice-02' : 'TRX-DOM-Sales Invoice-01' ) );
                    $rec = \App\Models\OM\CreditNote\MappingAccountModel::where('account_code', $account_code)->first();

                    $rec_segment1 = $rec->segment1;
                    $rec_segment2 = $rec->segment2;
                    $rec_segment3 = $rec->segment3;
                    $rec_segment4 = $rec->segment4;
                    $rec_segment5 = $rec->segment5;
                    $rec_segment6 = $rec->segment6;
                    $rec_segment7 = $rec->segment7;
                    $rec_segment8 = $rec->segment8;

                    $receivables_transaction_type = '';

                    $consignment = $match->consignment;
                    $order_headers = $match->orderHeaders()->whereRaw("upper(pick_release_status) = 'CONFIRM'")->get();
                    $proforma_headers = $match->proformaHeaders()->whereRaw("upper(pick_release_status) = 'CONFIRM'")->get();

                    if($consignment){
                        $receivables_transaction_type = optional(optional(optional(optional(optional($consignment)->lines)->first())->orderHeader)->transactionType)->receivables_transaction_type;
                    }elseif($order_headers->count()){
                        $receivables_transaction_type = optional(optional($order_headers->where('pick_release_no', $match->invoice_number)->first())->transactionType)->receivables_transaction_type;
                    }elseif($proforma_headers->count()){
                        $receivables_transaction_type = optional(optional($proforma_headers->where('pick_release_no', $match->invoice_number)->first())->transactionType)->receivables_transaction_type;
                    }

                    $tran_type = \App\Models\OM\ARTranTypesV::where('name', $receivables_transaction_type)->first();

                    $rec_segment9 = optional($tran_type)->receivable_account_segment9;
                    $rec_segment10 = optional($tran_type)->receivable_account_segment10;
                    $rec_segment11 = $rec->segment11;
                    $rec_segment12 = $rec->segment12;
                    $invoice_rec_acc = $rec_segment1.'.'.$rec_segment2.'.'.$rec_segment3.'.'.$rec_segment4.'.'
                        .$rec_segment5.'.'.$rec_segment6.'.'.$rec_segment7.'.'.$rec_segment8.'.'
                        .$rec_segment9.'.'.$rec_segment10.'.'.$rec_segment11.'.'.$rec_segment12;
                }
            }
        }

        $dr_acc_combination = null;
        $cr_acc_combination = null;

        if( is_null($invoice_no) && is_null($apply_flag) ){

            $dr_acc_combination = $receipt_bank_acc->cash;
            $cr_acc_combination = $receipt_bank_acc->unapplied_receipts;

        }elseif( $gain_loss && in_array($apply_flag, ['Y'])){

            $dr_acc_combination = $receipt_bank_acc->unapplied_receipts;
            $cr_acc_combination = count($qry_acc) ? $qry_acc[0]->concatenated_segments : '';

        }elseif( $gain_loss && in_array($apply_flag, ['N'])){

            $old = $report 
                ? \App\Models\OM\ARReceiptInfReport::where('receipt_number', $interface->receipt_number)
                    ->where('purpose_activity', $purpose)->where('apply_flag', 'Y')->latest()->first() 
                : \App\Models\OM\ARReceiptInterface::where('receipt_number', $interface->receipt_number)
                    ->where('purpose_activity', $purpose)->where('apply_flag', 'Y')->where('interface_status', 'C')->latest()->first();
            $dr_acc_combination = optional($old)->cr_account_combination;
            $cr_acc_combination = optional($old)->dr_account_combination;

        }elseif( !!$invoice_no && in_array($apply_flag, ['Y']) ){

            $dr_acc_combination = $receipt_bank_acc->unapplied_receipts;
            $cr_acc_combination = $invoice_no == 'Receipt Write-off' ? (count($qry_acc) ? $qry_acc[0]->concatenated_segments : '') : $invoice_rec_acc;

        }elseif( !!$invoice_no && in_array($apply_flag, ['N']) ){

            $dr_acc_combination = $invoice_no == 'Receipt Write-off' ? (count($qry_acc) ? $qry_acc[0]->concatenated_segments : '') : $invoice_rec_acc;
            $cr_acc_combination = $receipt_bank_acc->unapplied_receipts;

        }elseif( in_array($apply_flag, ['U']) ) {

            $dr_acc_combination = $receipt_bank_acc->unapplied_receipts;
            $cr_acc_combination = $receipt_bank_acc->cash;

        }

        $interface->dr_account_combination  = $dr_acc_combination;
        $interface->cr_account_combination  = $cr_acc_combination;

        if($report){
            $desc = optional(\App\Models\OM\PtomRcDailyAccRptDescV::where('meaning', $interface->receipt_class)->first());
            $interface->report_description = $desc->description;
        }

        $interface->save();
    }

    public static function insertCNApply($item, $program_code, $group_id, $batch_no, $creation_date, $org)
    {
        $invoiceHeader = $item->invoiceHeader;
        $customer = optional($invoiceHeader)->customer;
        $user_id = getDefaultData('/users')->user_id;

        $interface = new \App\Models\OM\ARApplyCnInterface;
        $interface->group_id            = $group_id;
        $interface->interface_module    = 'AR';
        $interface->customer_number     = $customer->customer_number;
        $interface->customer_name       = $customer->customer_name;
        $interface->sales_type          = $customer->sales_classification_code;
        $interface->org_id              = $org->organization_id;
        $interface->operating_unit      = $org->name;
        $interface->invoice_number      = $item->pick_release_no;
        $interface->credit_note_number  = $item->invoice_number;
        $interface->apply_flag          = $item->attribute1;
        $interface->apply_date          = $item->last_update_date;
        $interface->apply_gl_date       = $item->last_update_date;
        $interface->program_code        = $program_code;
        $interface->created_by          = $user_id;
        $interface->creation_date       = $creation_date;
        $interface->last_updated_by     = $user_id;
        $interface->last_update_date    = $creation_date;
        $interface->created_by_id       = $user_id;
        $interface->updated_by_id       = $user_id;
        $interface->web_batch_no        = $batch_no;
        $interface->amount              = $item->invoice_amount;
        $interface->payment_apply_id    = $item->payment_apply_id;
        $interface->save();
    }

    public static function getToatOrg()
    {
        $org = \DB::table('PTOM_OPERATING_UNITS_V')
            ->where('SHORT_CODE', 'TOAT')
            ->first();

        return $org;
    }

    public function setGlobalOrg()
    {
        $db     =   \DB::connection('oracle')->getPdo();

        $sql    =   "
                    DECLARE
                        V_ORGANIZATION_ID       NUMBER          :=  NULL;

                    BEGIN
                        BEGIN 
                            SELECT  ORGANIZATION_ID
                            INTO    V_ORGANIZATION_ID
                            FROM    HR_OPERATING_UNITS
                            WHERE   SHORT_CODE = 'TOAT';
                        END;
                            
                        mo_global.set_policy_context('S', V_ORGANIZATION_ID);
                    
                    END;

                    ";

        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

}