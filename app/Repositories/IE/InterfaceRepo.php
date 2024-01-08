<?php

namespace App\Repositories\IE;

// use App\InterfaceAP;
use App\Models\IE\InterfaceEncumbrance;
use App\Models\IE\InterfaceAPHeader;
use App\Models\IE\InterfaceAPLine;

use App\Models\IE\GLCodeCombination;
use App\Models\IE\AccountInfo;
use App\Models\IE\Currency;
use App\Models\IE\VAT;
use App\Models\User;
use App\Models\IE\Vendor;
use App\Models\IE\CACategory;
use App\Models\IE\SubCategory;
use App\Models\IE\CASubCategory;
use App\Models\IE\InterfaceAP;

use App\Models\IE\GLPeriodStatus;
use App\APInvoice;
use Carbon\Carbon;

class InterfaceRepo
{
    // PRE-PAYMENT
	public static function prePayment($parent,$processType)
    {
        \DB::beginTransaction();
        try {

            // CASH-ADVANCE (PRE-PAYMENT)

            $now = Carbon::parse($parent->gl_date)->format('Y-m-d');

        	// INSERT HEAD
            $interfaceHeader = new InterfaceAPHeader();
            $interfaceHeader->invoice_number = $parent->invoice_no;
            $interfaceHeader->apply_invoice_number = null;
            $interfaceHeader->request_type = 'I-EXPENSE';
            $interfaceHeader->request_from = $processType;
            $interfaceHeader->request_id = $parent->cash_advance_id;
            $interfaceHeader->documentable_id = $parent->cash_advance_id;
            $interfaceHeader->documentable_type = 'App\Models\IE\CashAdvance';
            $interfaceHeader->org_id = $parent->org_id;
            $interfaceHeader->description = self::concatDescription('ยืมเงินทดรอง', $parent->reason, $parent->currency_id);
            $interfaceHeader->due_date = $parent->gl_date ?? $now;
            $interfaceHeader->invoice_date = $parent->request_date ?? $now;
			$interfaceHeader->gl_date = $parent->gl_date ?? $now;
            $interfaceHeader->prepay_apply_date = $parent->prepay_apply_date ?? $now;
            $interfaceHeader->vendor_id = $parent->vendor_id;
			$interfaceHeader->vendor_site_id = $parent->vendor_site_id;
            $interfaceHeader->currency = $parent->currency_id;
            $interfaceHeader->invoice_type = 'PREPAYMENT';
            $interfaceHeader->payment_method_code = $parent->payment_method_id;
            $interfaceHeader->term_id = $parent->payment_term_id;
            $interfaceHeader->invoice_amount = $parent->amount;
            $interfaceHeader->exchange_rate = $parent->exchange_rate;
            $interfaceHeader->rate_date = $parent->rate_date;
            $interfaceHeader->accts_pay_code_combination_id = $parent->user->employee->accts_pay_code_combination_id ?? null;
            
            $interfaceHeader->invoice_batch = $parent->preparer->username."/CA/".$parent->document_no.'/'.strtoupper(date('d-M-Y'));
            $interfaceHeader->document_category = 'IEXPENSE';

            $interfaceHeader->tax_flag = 'N';
            $interfaceHeader->interface_status = 'P';
            $interfaceHeader->interface_message = null;

            // DFF HEADER //
            $interfaceHeader->attribute_category = 'เงินทดรอง/เงินสดย่อย';
            $interfaceHeader->attribute1 = $parent->dff_pay_for ?? ($parent->pay_to_emp == 'YES' ? $parent->dff_pay_for : optional($parent->supplierSite)->vendor_name);
            $interfaceHeader->attribute13 = $parent->dff_group_tax_code;

            if($parent->pay_to_emp == 'YES'){
                $interfaceHeader->global_attribute_category = 'JA.TH.APXIISIM.INVOICES_INTF';
                $account = \App\Models\IE\UserAccount::where('account_number', $parent->account_no)->first();
                if($account->account_type == 'SYNC'){
                    $interfaceHeader->global_attribute10 = $parent->requester_id;
                }else {
                    $interfaceHeader->global_attribute12 = $account->code;
                }
            }

            // BY USER //
            $interfaceHeader->last_updated_by = \Auth::user()->user_id;
            $interfaceHeader->created_by = \Auth::user()->user_id;

            // VALIDATE BEFORE INSERT TO INTERFACE TABLE
            self::validatePeriodIsOpen($interfaceHeader->org_id, $parent->gl_date ? Carbon::parse($parent->gl_date)->format('Y-m-d') : $now);
            self::validateDuplicateInvoiceNumber($interfaceHeader->org_id, $interfaceHeader->invoice_number);

            $interfaceHeader->save();

            // INSERT LINE
            $interfaceLine = new InterfaceAPLine();
            $interfaceLine->interface_ap_header_id = $interfaceHeader->interface_ap_header_id;
            $interfaceLine->request_receipt_id = null;
            $interfaceLine->request_receipt_line_id = null;
            $interfaceLine->org_id = $parent->org_id;
            $interfaceLine->line_group_number = null;
            $interfaceLine->line_number = '1';
            // receipt_number | sub_category_name | justification
            $interfaceLine->description = self::concatDescription('ยืมเงินทดรอง', $parent->purpose, $parent->currency_id);

            // PRE-PAYMENT COMBINE GL ACCOUNT WHEN INTERFACE
            $vendor = $parent->supplierSite;

            $glCodeCombination = self::getGLCodeCombinationOfVendorBySegments($vendor);

            $concatenatedSegments = $glCodeCombination['concatenated_segments'];
            $lineDistAcctId = $glCodeCombination['code_combination_id'];
            $interfaceLine->concatenated_segments = $concatenatedSegments;
            $interfaceLine->dist_acct_id = $lineDistAcctId;

            $interfaceLine->invoice_number = $interfaceHeader->invoice_number;
            $interfaceLine->accounting_date = $now;
            $interfaceLine->quantity_invoiced = 1;
            $interfaceLine->unit_price = $parent->amount;
            $interfaceLine->line_amt = $parent->amount;
            $interfaceLine->inventory_item_id = null;
            $interfaceLine->unit_of_meas_lookup_code = null;
            $interfaceLine->wht_amt = null;
            $interfaceLine->pay_awt_group_id = null;
            $interfaceLine->tax_amt = null;
            $interfaceLine->tax_rate_code = null;
            $interfaceLine->tax_classification_code = null;
            $interfaceLine->tax_regime_code = null;
            $interfaceLine->tax = null;
            $interfaceLine->tax_status_code = null;
            $interfaceLine->actual_vendor_name = null;
            $interfaceLine->actual_vendor_tax_id = null;
            $interfaceLine->actual_vendor_branch_name = null;
            $interfaceLine->establishment_id = null;
            $interfaceLine->establishment_name = null;

            $interfaceLine->interface_status = 'P';
            $interfaceLine->interface_message = null;

            $interfaceLine->last_updated_by = \Auth::user()->user_id;
            $interfaceLine->created_by = \Auth::user()->user_id;
            $interfaceLine->save();

        } catch (\Exception $e) {
            \DB::rollBack();
        	throw new \Exception($e->getMessage(), 1);
        }
        \DB::commit();

        return $interfaceHeader->interface_ap_header_id;
    }

    // INTERFACE INVOICE & APPLY PRE-PAYMENT
    public static function invoice($parent,$processType)
    {
    	// processType = 'REIMBURSEMENT' (INVOICE) || 'CLEARING' (APPLY PRE-PAYMENT)
        \DB::beginTransaction();
        try {
            $gl_date = in_array($processType, ['CLEARING']) ? $parent->clearing_gl_date: $parent->gl_date;

            $now = Carbon::parse($gl_date)->format('Y-m-d');
            $whtFlag = false;
            $line_context = 'JA.TH.APXIISIM.INVOICES_INTF';

        	// INSERT HEAD
        	$interfaceHeader = new InterfaceAPHeader();
            if($processType == 'REIMBURSEMENT'){
                // INVOICE
                $interfaceHeader->invoice_number = $parent->invoice_no;
                $interfaceHeader->apply_invoice_number = null;
                $interfaceHeader->request_id = $parent->reimbursement_id;
                $interfaceHeader->documentable_id = $parent->reimbursement_id;
                $interfaceHeader->documentable_type = 'App\Models\IE\Reimbursement';
                $interfaceHeader->description = self::concatDescription('เบิกเงินสำรองจ่าย', $parent->purpose, $parent->currency_id);
            }elseif($processType == 'CLEARING'){
                // APPLY PRE-PAYMENT
                // CHECK CASH ADVANCE STATUS BEFORE CLEARING
                // $cashAdvanceInvoiceStatus = InterfaceAP::getInvoiceApprovalStatus($parent->org_id,$parent->document_no);
                // if(!$cashAdvanceInvoiceStatus){
                //     throw new \Exception("Error : Not found cash advance # \"".$parent->document_no."\" in oracle erp system, please contact administrator to resolve this issue.", 1);
                // }else{
                //     if(strtoupper($cashAdvanceInvoiceStatus[0]->status) != 'AVAILABLE'){
                //         throw new \Exception("Error : Cash advance # \"".$parent->document_no."\" invoice status is not available (now = ".$cashAdvanceInvoiceStatus[0]->status." ), please contact administrator to resolve this issue.", 1);
                //     }
                // }
                $interfaceHeader->invoice_number = $parent->clearing_invoice_no;
                $interfaceHeader->apply_invoice_number = $parent->invoice_no;
                $interfaceHeader->request_id = $parent->cash_advance_id;
                $interfaceHeader->documentable_id = $parent->cash_advance_id;
                $interfaceHeader->documentable_type = 'App\Models\IE\CashAdvance';
                $interfaceHeader->description = self::concatDescription('เคลียร์เงินยืมทดรอง', $parent->reason, $parent->currency_id);
                $interfaceHeader->prepay_apply_date = $parent->prepay_apply_date;
            }
        	$interfaceHeader->request_type = 'I-EXPENSE'; //$processType;
            $interfaceHeader->request_from = $processType;
			$interfaceHeader->org_id = $parent->org_id;
            $interfaceHeader->due_date =  $gl_date ?? $now;
			$interfaceHeader->invoice_date = (in_array($processType, ['CLEARING']) ? $parent->clearing_request_date : $parent->request_date) ?? $now;
			$interfaceHeader->gl_date = $gl_date ?? $now;
			$interfaceHeader->vendor_id = $parent->vendor_id;
			$interfaceHeader->vendor_site_id = $parent->vendor_site_id;
			$interfaceHeader->currency = $parent->currency_id;
			$interfaceHeader->invoice_type = 'STANDARD';
            $interfaceHeader->payment_method_code = $parent->payment_method_id;
			$interfaceHeader->term_id = $parent->payment_term_id;
			$interfaceHeader->invoice_amount = $parent->total_receipt_amount;
            $interfaceHeader->exchange_rate = $parent->exchange_rate;
            $interfaceHeader->rate_date = $parent->rate_date;
            $interfaceHeader->accts_pay_code_combination_id = $parent->user->employee->accts_pay_code_combination_id ?? null;
            
            $interfaceHeader->invoice_batch = $parent->preparer->username.($processType == 'REIMBURSEMENT' ? "/RE/".$parent->document_no : "/CL/".$parent->clearing_document_no).'/'.strtoupper(date('d-M-Y'));
            $interfaceHeader->document_category = 'IEXPENSE';
            
            $interfaceHeader->tax_flag = 'N';
			$interfaceHeader->interface_status = 'P';
            $interfaceHeader->interface_message = null;

            // DFF HEADER //
            $interfaceHeader->attribute_category = $parent->clearing_dff_type ? ( 'เงินทดรอง/เงินสดย่อย' ) : ($parent->dff_type == 'cash_advance' ? 'เงินทดรอง/เงินสดย่อย' : 'ใบแจ้งหนี้');
            $interfaceHeader->attribute1 = $parent->clearing_dff_pay_for 
                ? ($parent->clearing_dff_pay_for ?? ($parent->clearing_pay_to_emp == 'YES' ? $parent->clearing_dff_pay_for : optional($parent->supplierSite)->vendor_name)) 
                : ($parent->dff_pay_for ?? ($parent->pay_to_emp == 'YES' ? $parent->dff_pay_for : optional($parent->supplierSite)->vendor_name));

            $interfaceHeader->attribute3 = $parent->dff_address;
            $interfaceHeader->attribute4 = $parent->dff_branch_number;

            $interfaceHeader->attribute6 = $parent->dff_tax_id;
            $interfaceHeader->attribute7 = $parent->dff_type == 'cash_advance' ? null : $parent->dff_po_ref_number; // 'ใบแจ้งหนี้'

            $interfaceHeader->attribute12 = $parent->dff_type == 'cash_advance' ? null : $parent->dff_paid_number; // 'ใบแจ้งหนี้'
            $interfaceHeader->attribute13 = $parent->clearing_dff_group_tax_code ? $parent->clearing_dff_group_tax_code : $parent->dff_group_tax_code;
            $interfaceHeader->attribute14 = $parent->dff_tax_invoice_date;
            $interfaceHeader->attribute15 = $parent->dff_tax_invoice_number;

            if( ($processType == 'REIMBURSEMENT' && $parent->pay_to_emp == 'YES') || ($processType == 'CLEARING' && $parent->clearing_pay_to_emp == 'YES')){
                $interfaceHeader->global_attribute_category = 'JA.TH.APXIISIM.INVOICES_INTF';
                $account = \App\Models\IE\UserAccount::where('account_number', $parent->account_no)->first();
                if($account->account_type == 'SYNC'){
                    $interfaceHeader->global_attribute10 = $parent->requester_id;
                }else {
                    $interfaceHeader->global_attribute12 = $account->code;
                }
            }

            // CREATE BY //
            $interfaceHeader->last_updated_by = \Auth::user()->user_id;
            $interfaceHeader->created_by = \Auth::user()->user_id;

            // VALIDATE BEFORE INSERT TO INTERFACE TABLE
            self::validatePeriodIsOpen($interfaceHeader->org_id, $gl_date ? Carbon::parse($gl_date)->format('Y-m-d') : $now);
            self::validateDuplicateInvoiceNumber($interfaceHeader->org_id, $interfaceHeader->invoice_number);

			$interfaceHeader->save();

            $arrVat = [];

			// INSERT LINES
            $receipts = $parent->receipts()->processType($processType)->get();
			if( count($receipts) > 0 ){
                $taxFlag = 'N';
				$interfaceLineNumber = 0;

				foreach ($receipts as $key => $receipt) {

                    $receiptType = $receipt->receipt_type;
                    
					if( count($receipt->lines) > 0) {

						foreach ($receipt->lines as $key => $line) {
                            
							$interfaceLineNumber++;

							$interfaceLine = new InterfaceAPLine();
                            $interfaceLine->interface_ap_header_id = $interfaceHeader->interface_ap_header_id;
                            $interfaceLine->request_receipt_id = $receipt->receipt_id;
                            $interfaceLine->request_receipt_line_id = $line->receipt_line_id;
                            $interfaceLine->org_id = $parent->org_id;
                            $interfaceLine->line_group_number = null;
                            $interfaceLine->line_number = $interfaceLineNumber;

                            $interfaceLine->description = self::concatDescription(null, $line->description ?? optional($line->subCategory)->name, null);

                            // INVOICE & APPLY PRE-PAYMENT COMBINE GL ACCOUNT WHEN SEND REQUEST
                            $interfaceLine->concatenated_segments = $line->concatenated_segments;
                            $interfaceLine->dist_acct_id = $line->code_combination_id;
                            $interfaceLine->invoice_number = $interfaceHeader->invoice_number;
                            $interfaceLine->accounting_date = $now;
                            $interfaceLine->quantity_invoiced = 1;
                            $totalPrimaryAmount = (float)$line->total_amount_inc_vat - (float)$line->vat_amount;
                            $interfaceLine->unit_price = $totalPrimaryAmount;
                            $interfaceLine->line_amt = $totalPrimaryAmount;
                            $interfaceLine->inventory_item_id = null;
                            $interfaceLine->unit_of_meas_lookup_code = null;
                            $interfaceLine->wht_amt = null;
                            $interfaceLine->pay_awt_group_id = $line->wht_id;
                            $interfaceLine->tax_amt = $line->vat_amount;
                            $interfaceLine->tax_rate_code = $line->vat_id;
                            $interfaceLine->tax_classification_code = $line->vat_id;

                            if($line->vat_id){

                                if(!array_key_exists($line->vat_id, $arrVat)){
                                    $arrVat[$line->vat_id]['vat_id'] = $line->vat_id;
                                    $arrVat[$line->vat_id]['vat_amount'] = (float)$line->vat_amount;
                                }else{ // IF ALREADY HAVE THIS TAX (VAT ID) => SUM FOR TOTAL
                                    $arrVat[$line->vat_id]['vat_amount'] += (float)$line->vat_amount;
                                }

                                $taxFlag = 'Y';
                                $taxVAT = VAT::where('tax_rate_code',$line->vat_id)->whereOrgId($parent->org_id)->first();
                                $interfaceLine->tax_regime_code = $taxVAT->tax_regime_code;
                                $interfaceLine->tax = $taxVAT->tax;
                                $interfaceLine->tax_status_code = $taxVAT->tax_status_code;
                            }

                            if($receipt->vendor_id){
                                if($receipt->vendor_id == 'other'){
                                    $interfaceLine->actual_vendor_name = $receipt->vendor_name;
                                    $interfaceLine->actual_vendor_tax_id = $receipt->vendor_tax_id;
                                    $interfaceLine->actual_vendor_branch_name = $receipt->vendor_branch_name;
                                }else{
                                    $vendor = Vendor::whereOrgId($parent->org_id)->where('vendor_id',$receipt->vendor_id)->first();
                                    if($vendor){
                                        $interfaceLine->actual_vendor_name = $vendor->vendor_name;
                                        $interfaceLine->actual_vendor_tax_id = $vendor->tax_id;
                                        $interfaceLine->actual_vendor_branch_name = $vendor->branch_number;
                                    }
                                }
                            }

                            $interfaceLine->establishment_id = $receipt->establishment_id;
                            $interfaceLine->establishment_name = $receipt->establishment_name;

                            $interfaceLine->interface_status = 'P';
                            $interfaceLine->interface_message = null;

                            // DFF LINE //
                            $interfaceLine->attribute_category = 'ใบแจ้งหนี้/ใบกำกับภาษี';

                            $interfaceLine->attribute4 = $line->dff_pay_for;
                            $interfaceLine->attribute5 = $line->dff_group_tax_code;
                            $interfaceLine->attribute6 = $line->dff_tax_invoice_number;
                            $interfaceLine->attribute7 = $line->dff_tax_invoice_date;
                            $interfaceLine->attribute8 = $line->dff_address;
                            $interfaceLine->attribute9 = $line->dff_branch_number;

                            $interfaceLine->attribute11 = $line->dff_tax_id;
                            $interfaceLine->attribute12 = $line->dff_product_value;
                            $interfaceLine->attribute13 = $line->dff_wht_flag == 'Y' ? 'ใช่' : 'ไม่ใช่';
                            $interfaceLine->attribute14 = $line->dff_wht_ref_number;

                            // DFF DISTRIBUTION // 
                            if(!!$line->distribution_type){
                                $whtFlag = true;
                                $interfaceLine->global_attribute_category = $line_context;
                
                                if($line->distribution_type == 'ภาษีเงินได้หัก ณ ที่จ่าย'){
                                    $interfaceLine->global_attribute1 = $line->distribution_wht_date;
                                    $interfaceLine->global_attribute2 = $line->distribution_cert_number;
                                    $interfaceLine->global_attribute3 = $line->distribution_income_type;
                                    $interfaceLine->global_attribute4 = $line->distribution_income_name;
                                }
                
                                if($line->distribution_type == 'สินค้าต่างประเทศ'){
                                    $interfaceLine->global_attribute5 = $line->distribution_import_type;
                                    $interfaceLine->global_attribute6 = $line->distribution_po_number;
                                    $interfaceLine->global_attribute7 = $line->distribution_ref_number;
                                    $interfaceLine->global_attribute8 = $line->distribution_expense_type;
                                    $interfaceLine->global_attribute9 = $line->distribution_shipment;
                                }
                
                                if($line->distribution_type == 'ใบเสร็จรับเงิน'){
                                    $interfaceLine->global_attribute10 = $line->distribution_receipt_number;
                                    $interfaceLine->global_attribute11 = $line->distribution_receipt_date;
                                }

                                $interfaceLine->global_attribute12 = $line->distribution_type;
                            }

                            // CREATE BY //
                            $interfaceLine->last_updated_by = \Auth::user()->user_id;
                            $interfaceLine->created_by = \Auth::user()->user_id;
                            $interfaceLine->save();
						}
					}
				}

                // LINE VAT
                foreach ($arrVat as $vatId => $vat) {
                    if($vat['vat_amount'] > 0){

                        $taxVAT = VAT::where('tax_rate_code', $vatId)->whereOrgId($parent->org_id)->first();
                        $interfaceLineNumber++;

                        $interfaceLine = new InterfaceAPLine();
                        $interfaceLine->line_type = 'TAX';

                        $interfaceLine->interface_ap_header_id = $interfaceHeader->interface_ap_header_id;
                        $interfaceLine->org_id = $parent->org_id;
                        $interfaceLine->line_group_number = null;
                        $interfaceLine->line_number = $interfaceLineNumber;

                        $interfaceLine->description = 'ภาษีมูลค่าเพิ่ม';

                        // INVOICE & APPLY PRE-PAYMENT COMBINE GL ACCOUNT WHEN SEND REQUEST
                        $interfaceLine->concatenated_segments = $taxVAT->tax_account;
                        $interfaceLine->dist_acct_id = $taxVAT->tax_account_ccid;
                        $interfaceLine->invoice_number = $interfaceHeader->invoice_number;
                        $interfaceLine->accounting_date = $now;
                        $interfaceLine->quantity_invoiced = 1;
                        $totalVatAmount = (float)$vat['vat_amount'];
                        $interfaceLine->unit_price = $totalVatAmount;
                        $interfaceLine->line_amt = $totalVatAmount;
                        $interfaceLine->inventory_item_id = null;
                        $interfaceLine->unit_of_meas_lookup_code = null;
                        $interfaceLine->tax_amt = $totalVatAmount;
                        $interfaceLine->tax_rate_code = $vatId;
                        $interfaceLine->tax_classification_code = $vatId;

                        $interfaceLine->tax_regime_code = $taxVAT->tax_regime_code;
                        $interfaceLine->tax = $taxVAT->tax;
                        $interfaceLine->tax_status_code = $taxVAT->tax_status_code;

                        $interfaceLine->interface_status = 'P';
                        $interfaceLine->interface_message = null;

                        // DFF DISTRIBUTION
                        if($whtFlag){
                            $interfaceLine->global_attribute_category = $line_context;
                        }

                        // CREATE BY //
                        $interfaceLine->last_updated_by = \Auth::user()->user_id;
                        $interfaceLine->created_by = \Auth::user()->user_id;
                        $interfaceLine->save();
                    }
                }
			}
            // UPDATE HEAD TAX FLAG
            $interfaceHeader->tax_flag = $taxFlag;
            $interfaceHeader->save();

        } catch (\Exception $e) {
            \DB::rollBack();
        	throw new \Exception($e->getMessage(), 1);
        }
        \DB::commit();

        return $interfaceHeader->interface_ap_header_id;
    }

    private static function concatDescription($prefix,$description,$currency)
    {
        
        $arrConcat = [];
        $concatenatedDescription = '';
        if($prefix){
            array_push($arrConcat, $prefix);
        }
        if($description){
            array_push($arrConcat, mb_substr($description , 0, 200));
        }
        if($currency){
            array_push($arrConcat, $currency);
        }
        if( count($arrConcat) > 0 ){
            $concatenatedDescription = implode(" ",$arrConcat);
        }

        return $concatenatedDescription;
    }

    public static function composeGLCodeCombinationSegments($company = null, $evm = null, $department = null, $costCenter = null, $budgetYear = null, $budgetType = null, $budgetDetail = null, $budgetReason = null, $account = null, $subAccount = null, $reserved1 = null, $reserved2 = null)
    {
        $codeCombinationId = null;
        $segments = [];
        $year = getBudgetYear();

        // SEGMENT1 COMPANY
        $segments[1] = $company;

        // SEGMENT2
        $segments[2] = $evm;

        // SEGMENT3
        $segments[3] = $department;

        // SEGMENT4
        $segments[4] = $costCenter;

        // SEGMENT5
        $segments[5] = $budgetYear ?? $year;

        // SEGMENT6
        $segments[6] = null;
        if($budgetType != null){
            $segments[6] = $budgetType;
        }else {
            throw new \Exception("Error : Sub Category don't set budget type, please contact administrator to resolve this issue.", 1);
        }

        // SEGMENT7
        $segments[7] = null;
        if($budgetDetail != null){
            $segments[7] = $budgetDetail;
        }else {
            throw new \Exception("Error : Sub Category don't set budget detail, please contact administrator to resolve this issue.", 1);
        }

        // SEGMENT8
        $segments[8] = null;
        if($budgetReason != null){
            $segments[8] = $budgetReason;
        }else {
            throw new \Exception("Error : Sub Category don't set budget reason, please contact administrator to resolve this issue.", 1);
        }

        // SEGMENT9
        $segments[9] = $account;

        // SEGMENT10
        $segments[10] = null;
        if($subAccount != null){
            $segments[10] = $subAccount;
        }else {
            throw new \Exception("Error : Sub Category don't set sub account, please contact administrator to resolve this issue.", 1);
        }

        // SEGMENT11
        $segments[11] = null;
        if($reserved1 != null){
            $segments[11] = $reserved1;
        }else {
            throw new \Exception("Error : Sub Category don't set reserve1, please contact administrator to resolve this issue.", 1);
        }
    
        // SEGMENT12
        $segments[12] = null;
        if($reserved2 != null){
            $segments[12] = $reserved2;
        }else {
            throw new \Exception("Error : Sub Category don't set reserve2, please contact administrator to resolve this issue.", 1);
        }

        return $segments;

    }

    public static function composeGLCodeCombinationSegmentsBySubCategory($subCategory)
    {
        if(!$subCategory){
            throw new \Exception("Error : Not found Sub Category, please contact administrator to resolve this issue.", 1);
        }

        $segments = [];
        $year = getBudgetYear();

        // SEGMENT1
        $segments[1] = $subCategory->company_code;

        // SEGMENT2
        $segments[2] = $subCategory->evm_code;

        // SEGMENT3
        $segments[3] = $subCategory->department_code;

        // SEGMENT4
        $segments[4] = $subCategory->cost_center_code;

        // SEGMENT5
        $segments[5] = $subCategory->update_only_budget_year ? $year : $subCategory->budget_year_code;

        // SEGMENT6
        $segments[6] = $subCategory->budget_type_code;

        // SEGMENT7
        $segments[7] = $subCategory->budget_detail_code;

        // SEGMENT8
        $segments[8] = $subCategory->budget_reason_code;

        // SEGMENT9
        $segments[9] = $subCategory->account_code;

        // SEGMENT10
        $segments[10] = $subCategory->sub_account_code;

        // SEGMENT11
        $segments[11] = $subCategory->reserve1_code;
    
        // SEGMENT12
        $segments[12] = $subCategory->reserve2_code;

        return $segments;

    }

    public static function getGLCodeCombinationOfEmpBySegments($employee, $segments, $date = null)
    {
    	// DEFAULT CONCATENATED SEGMENTS
        $year = getBudgetYear($date);
        if($employee){
            // $concatenatedSegments = $employee->concatenated_segments;
            $concatenatedSegments = $employee->expense_account ?? $employee->concatenated_segments;
            $employee_segments = explode('.', $concatenatedSegments);

            // company
            if(!$employee->segment1){
                $employee->segment1 = $employee_segments[0];
            }

            // evm
            if(!$employee->segment2){
                $employee->segment2 = $employee_segments[1];
            }

            // department
            if(!$employee->segment3){
                $employee->segment3 = $employee_segments[2];
            }

            // cost center
            if(!$employee->segment4){
                $employee->segment4 = $employee_segments[3];
            }

            // budget year
            $employee->segment5 = $year;

            // budget type
            if(!$employee->segment6){
                $employee->segment6 = $employee_segments[5];
            }

            // budget detail
            if(!$employee->segment7){
                $employee->segment7 = $employee_segments[6];
            }

            // budget reason
            if(!$employee->segment8){
                $employee->segment8 = $employee_segments[7];
            }

            // account
            if(!$employee->segment9){
                $employee->segment9 = $employee_segments[8];
            }

            // sub account
            if(!$employee->segment10){
                $employee->segment10 = $employee_segments[9];
            }

            // reserve1
            if(!$employee->segment11){
                $employee->segment11 = $employee_segments[10];
            }

            // reserve2
            if(!$employee->segment12){
                $employee->segment12 = $employee_segments[11];
            }

        }else{
            throw new \Exception("Error : Requester don’t have employee, please contact administrator to resolve this issue.", 1);
        }

        $result = ['concatenated_segments'  =>  '',
                   'code_combination_id'    =>  ''];

    	if(count($segments) == 12) {
    		if(is_null($segments[1])){
    			$segments[1] = $employee->segment1;
    		}
    		if(is_null($segments[2])){
    			$segments[2] = $employee->segment2;
    		}
    		if(is_null($segments[3])){
    			$segments[3] = $employee->segment3;
    		}
    		if(is_null($segments[4])){
    			$segments[4] = $employee->segment4;
    		}
    		if(is_null($segments[5])){
    			$segments[5] = $employee->segment5;
    		}
    		if(is_null($segments[6])){
    			$segments[6] = $employee->segment6;
    		}
    		if(is_null($segments[7])){
    			$segments[7] = $employee->segment7;
    		}
    		if(is_null($segments[8])){
    			$segments[8] = $employee->segment8;
    		}
    		if(is_null($segments[9])){
    			$segments[9] = $employee->segment9;
    		}
    		if(is_null($segments[10])){
    			$segments[10] = $employee->segment10;
    		}
    		if(is_null($segments[11])){
    			$segments[11] = $employee->segment11;
    		}
    		if(is_null($segments[12])){
    			$segments[12] = $employee->segment12;
    		}

            // CONCAT SEGMENTS
    		$concatenatedSegments = $segments[1].'.'.$segments[2].'.'.$segments[3].'.'.$segments[4].'.'.$segments[5].'.'.$segments[6].'.'.$segments[7].'.'.$segments[8].'.'.$segments[9].'.'.$segments[10].'.'.$segments[11].'.'.$segments[12];


            // THIS ACCOUNT SEGMENT ALREADY COMBINED IN ORACLE ERP ?
        	// $glCodeCombination = GLCodeCombination::select('code_combination_id')->where('chart_of_accounts_id',$employee->chart_of_accounts_id)->where('concatenated_segments',$concatenatedSegments)->first();
            
            $glCodeCombination = GLCodeCombination::select('code_combination_id')->where('chart_of_accounts_id', 101)->where('concatenated_segments', $concatenatedSegments)->first();
            
            if(!$glCodeCombination){
                $result = GLCodeCombination::autoCombine($concatenatedSegments, $employee->org_id);
                if($result['status'] == 'C'){
                    $codeCombinationId = $result['combination_id'];
                }else {
                    throw new \Exception("Error : Can not combine account $concatenatedSegments, please contact administrator to resolve this issue.", 1);
                }
            }else {
                $codeCombinationId = $glCodeCombination->code_combination_id;
                if(!$codeCombinationId) {
                    throw new \Exception("Error : Not found gl combination $concatenatedSegments, please contact administrator to resolve this issue.", 1);
                }
            }

            $result = [ 'concatenated_segments'  =>  $concatenatedSegments,
                        'code_combination_id'    =>  $codeCombinationId];

        }

    	return $result;
    }

    public static function getGLCodeCombinationOfVendorBySegments($vendor)
    {
        $year = getBudgetYear();
    	// DEFAULT CONCATENATED SEGMENTS

        $result = ['concatenated_segments'  =>  '',
                   'code_combination_id'    =>  ''];

        if($vendor){
            $concatenatedSegments = $vendor->site_pre_acc_concatenated;
            if(!$concatenatedSegments){
                throw new \Exception("Error : Vendor not set combine, please contact administrator to resolve this issue.", 1);
            }
        }else {
            throw new \Exception("Error : Vendor not found, please contact administrator to resolve this issue.", 1);
        }

        // THIS ACCOUNT SEGMENT ALREADY COMBINED IN ORACLE ERP ?
        // $glCodeCombination = GLCodeCombination::select('code_combination_id')->where('chart_of_accounts_id',$employee->chart_of_accounts_id)->where('concatenated_segments',$concatenatedSegments)->first();
        
        $glCodeCombination = GLCodeCombination::select('code_combination_id')->where('chart_of_accounts_id', 101)->where('concatenated_segments', $concatenatedSegments)->first();

        $codeCombinationId = $glCodeCombination->code_combination_id ?? null;

        $result = [ 'concatenated_segments'  =>  $concatenatedSegments,
                    'code_combination_id'    =>  $codeCombinationId];

    	return $result;
    }

    private static function composeDataForCheckGLValidationRule($orgId,$concatenatedSegments,$segments)
    {
        $data = ['org_id'               =>  $orgId,
                'concatenated_segments' =>  $concatenatedSegments,
                'segment1'              =>  $segments[1],
                'segment2'              =>  $segments[2],
                'segment3'              =>  $segments[3],
                'segment4'              =>  $segments[4],
                'segment5'              =>  $segments[5],
                'segment6'              =>  $segments[6],
                'segment7'              =>  $segments[7],
                'segment8'              =>  $segments[8],
                'segment9'              =>  $segments[9],
                'segment10'             =>  $segments[10],
                'segment11'             =>  $segments[11],
                'segment12'             =>  $segments[12]];

        return $data;
    }

    public static function validatePeriodIsOpen($orgId, $date)
    {
        $GLPeriodOpened = GLPeriodStatus::getGLPeriodStatusOpenByDate($orgId, $date)->first();
        $APPeriodOpened = GLPeriodStatus::getAPPeriodStatusOpenByDate($orgId, $date)->first();

        // $GLPeriodOpened = GLPeriodStatus::getGLPeriodStatusOpenByDate($orgId,date('Y-m-d'));
        // $APPeriodOpened = GLPeriodStatus::getAPPeriodStatusOpenByDate($orgId,date('Y-m-d'));

        // $GLPeriodOpened = GLPeriodStatus::getGLPeriodStatusOpenByDate($orgId,date("Y-m-d", strtotime("+1 month", strtotime(date('Y-m-d')))));
        // $APPeriodOpened = GLPeriodStatus::getAPPeriodStatusOpenByDate($orgId,date("Y-m-d", strtotime("+1 month", strtotime(date('Y-m-d')))));

        if(!$GLPeriodOpened && !$APPeriodOpened){
            throw new \Exception('GL & AP Period Status Is Closing, please contact administrator to solve this issue.', 1);
        }else if(!$GLPeriodOpened){
            throw new \Exception('GL Period Status Is Closing, please contact administrator to solve this issue.', 1);
        }else if(!$APPeriodOpened){
            throw new \Exception('AP Period Status Is Closing, please contact administrator to solve this issue.', 1);
        }
    }

    public static function validateDuplicateInvoiceNumber($orgId, $invoiceNumber)
    {
        // $apInvoice = APInvoice::where('invoice_num',$invoiceNumber)
        //                     ->where('org_id',$orgId)
        //                     ->first();
        // if($apInvoice){
        //     throw new \Exception('Invoice # '.$invoiceNumber.' : is already used, please contact administrator to solve this issue.', 1);
        // }
    }

    public static function submitInterface($interface_ap_header_id)
    {
        // dd($batchno, '123');
        $db     =   \DB::connection('oracle')->getPdo();
        // $db  = \DB::reconnect('oracle')->getPdo();

        $sql    =   "
                DECLARE
                    v_debug             NUMBER :=0;
                    v_return_status     varchar2(10) := NULL;
                    v_message           varchar2(4000) := NULL;
                    BEGIN
                    dbms_output.put_line('------  S T A R T ------');

                        PTIE_WEB_INF_APINVOICE_PKG.UPLOAD_AP  
                        ( 
                            P_BATCH_NO            =>  to_char(SYSDATE,'DDMMYYYYHH24MI')
                            , P_WEB_HEADER_ID     =>  :interface_ap_header_id
                            , P_RETURN_STATUS     =>  :v_return_status
                            , P_RETURN_MESSAGE    =>  :v_message
                        );

                    dbms_output.put_line('------  E N D ------');
                    commit;

                    END;
                    ";

        // $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':interface_ap_header_id', $interface_ap_header_id);
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_message', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        $db = null;

        // \DB::purge('oracle');
        // \DB::disconnect('oracle');

        return $result;
    }

    public static function encumbrance($parent, $processType, $type)
    {
        $gl_date = in_array($processType, ['CLEARING']) || !!$parent->clearing_gl_date ? $parent->clearing_gl_date: $parent->gl_date;
        $now = Carbon::parse($gl_date)->format('Y-m-d');
        $batchNo = time() . '-' . uniqid();
        $receipts = $parent->receipts()->processType($processType)->get();

        $name = in_array($processType, ['CLEARING']) ? $parent->clearing_document_no : $parent->document_no;
        $period = strtoupper(Carbon::parse($gl_date)->format('M-y'));
        $currentLine = 1;
            foreach ($receipts as $receipt){
                foreach ($receipt->lines as $line) {
                    if($line->subCategory->check_budget){

                        $interfaceEnc                                   = new InterfaceEncumbrance();
                        $interfaceEnc->operating_unit                   = null; //'TOAT_LEDGER';
                        $interfaceEnc->org_id                           = $parent->org_id;
                        $interfaceEnc->interface_name                   = 'PTWEB_UPLOAD_ENCUMBRANCE';
                        $interfaceEnc->interface_status                 = null; // 'I';

                        $interfaceEnc->period_name                      = $period;
                        $interfaceEnc->accounting_date                  = $now;
                        $interfaceEnc->currency_code                    = 'THB';
                        $interfaceEnc->batch_no                         = $batchNo;
                        $interfaceEnc->batch_name                       = 'JV_ENCUMBRANCE ' . 'EXP_' . $name;
                        $interfaceEnc->journal_name                     = 'JV_ENCUMBRANCE ' . 'EXP_' . $name;
                        $interfaceEnc->je_line_num                      = $currentLine;
                        // ACCOUNT SEGMENTS
                        $account_segments = explode( '.', $line->concatenated_segments );
                        $interfaceEnc->account_number                   = $line->concatenated_segments;
                        $interfaceEnc->segment1                         = $account_segments[0]; //segment1
                        $interfaceEnc->segment2                         = $account_segments[1]; //segment2
                        $interfaceEnc->segment3                         = $account_segments[2]; //segment3
                        $interfaceEnc->segment4                         = $account_segments[3]; //segment4
                        $interfaceEnc->segment5                         = $account_segments[4]; //segment5
                        $interfaceEnc->segment6                         = $account_segments[5]; //segment6
                        $interfaceEnc->segment7                         = $account_segments[6]; //segment7
                        $interfaceEnc->segment8                         = $account_segments[7]; //segment8
                        $interfaceEnc->segment9                         = $account_segments[8]; //segment9
                        $interfaceEnc->segment10                        = $account_segments[9]; //segment10
                        $interfaceEnc->segment11                        = $account_segments[10]; //segment11
                        $interfaceEnc->segment12                        = $account_segments[11]; //segment12
                        // AMOUNT
                        $interfaceEnc->accounted_dr                     = $type == 'reserve' ? $line->total_primary_amount : null;
                        $interfaceEnc->accounted_cr                     = $type == 'return' ?  $line->total_primary_amount : null;
                        // EXCHANGE RATE
                        $interfaceEnc->user_currency_conversion_type    = 'User';
                        $interfaceEnc->currency_conversion_rate         = 1;
                        $interfaceEnc->currency_conversion_date         = $now;

                        $interfaceEnc->journal_description_head         = 'JV_ENCUMBRANCE ' . 'EXP_' . $name;
                        $interfaceEnc->journal_description_line         = self::concatDescription(null, $parent->purpose, null); // Journal Import Created
                        $interfaceEnc->created_by_id                    = 1110;
                        $interfaceEnc->enc_tran_type                    = in_array($processType, ['CLEARING']) ? 'INV' : 'EXP';
                        $interfaceEnc->attribute1                       = null;
                        $interfaceEnc->attribute2                       = null;
                        $interfaceEnc->attribute3                       = null;
                        $interfaceEnc->attribute4                       = null;
                        $interfaceEnc->attribute5                       = null;
                        $interfaceEnc->attribute6                       = null;
                        $interfaceEnc->attribute7                       = null;
                        $interfaceEnc->attribute8                       = null;
                        $interfaceEnc->attribute9                       = null;
                        $interfaceEnc->attribute10                      = null;
                        $interfaceEnc->encumbrancable_id                = in_array($processType, ['CASH-ADVANCE', 'CLEARING']) ? $parent->cash_advance_id : $parent->reimbursement_id;
                        $interfaceEnc->encumbrancable_type              = in_array($processType, ['CASH-ADVANCE', 'CLEARING']) ? 'App\Models\IE\CashAdvance' : 'App\Models\IE\Reimbursement';
                        $interfaceEnc->encumbrance_type                 = 'Commitment';
                        $interfaceEnc->interface_type                   = $type;

                        $interfaceEnc->created_by                       = \Auth::user()->user_id;
                        $interfaceEnc->last_updated_by                  = \Auth::user()->user_id;
                        $interfaceEnc->save();
                        $currentLine++;
                    }
                }
            }
        // }

        return $batchNo;
    }

    public static function submitEncumbrance($batchNo)
    {
        $db     =   \DB::connection('oracle')->getPdo();

        $sql    =   "
                    DECLARE
                        lv_RETURN_STATUS      varchar2(10)    :=  NULL;
                        lv_RETURN_MESSAGE     varchar2(4000)  :=  NULL;
                    BEGIN
                    
                        PTIE_WEB_INF_APINVOICE_PKG.UPLOAD_GL(
                            P_BATCH_NO              =>  :batch_no
                            , P_RETURN_STATUS       =>  :lv_RETURN_STATUS
                            , P_RETURN_MESSAGE      =>  :lv_RETURN_MESSAGE
                        );

                    END;
                    ";

        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':batch_no', $batchNo, \PDO::PARAM_STR);
        $stmt->bindParam(':lv_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':lv_RETURN_MESSAGE', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        $db = null;

        return $result;
    }

}