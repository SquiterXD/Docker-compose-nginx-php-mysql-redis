<?php 

namespace App\Repositories\IE;

use App\Repositories\IE\ApprovalRepo;
use App\Repositories\IE\InterfaceRepo;

use App\Models\IE\CashAdvance;
use App\Models\IE\Reimbursement;
use App\Models\IE\Preference;
use App\Models\IE\SubCategory;
use App\Models\IE\InterfaceAP;
use App\Models\IE\ReceiptLine;

class RequestRepo
{
    public static function getPendingOverLimitRequest($userId)
    {
    	$result = [];

        $now = time(); // or your date as well
        $pendingDayBlocking = Preference::getPendingDayBlocking();
        $pendingNumberBlocking = Preference::getPendingNumberBlocking();

        // CASH ADVANCE PENDING
        $cashAdvances = CashAdvance::where('requester_id', $userId)
            ->onApprovedNotCleared()
            ->orderBy('creation_date')
            ->get();

        foreach($cashAdvances as $ca){

            if( !is_null($pendingDayBlocking) ){
                // GET DUE DATE AS START PENDING DAY COUNT
                $dueDate = strtotime($ca->finish_date);
                $timeDiff = $now - $dueDate;
                $dateDiff =  floor($timeDiff / (60 * 60 * 24));
                if((int)$dateDiff >= (int)$pendingDayBlocking && $cashAdvances->count() >= (int)$pendingNumberBlocking){
                    array_push($result,["type"=>"App\CashAdvance", 
                                        "id"=>$ca->cash_advance_id,
                                        "document_no"=>$ca->document_no,
                                        "record_number"=>$ca->record_number,
                                        "amount"=>$ca->amount]);
                }
            }else {
                if($cashAdvances->count() >= (int)$pendingNumberBlocking){
                    array_push($result,["type"=>"App\CashAdvance", 
                                        "id"=>$ca->cash_advance_id,
                                        "document_no"=>$ca->document_no,
                                        "record_number"=>$ca->record_number,
                                        "amount"=>$ca->amount]);
                }
            }
        }

        return $result;
    }

    public static function validateReceipt($parent, $requestType)
    {
        $result = ['valid'=>true,'err_code'=>'','err_receipt_id'=>[],'err_msg'=>[]];
        if(!$parent){ 
            $result['valid'] = false;
            $result['err_code'] = 'not-found-parent';
        }else{
            $receipts = $parent->receipts()->processType($requestType)->get();
            // validate not found receipt
            if(count($receipts) == 0){ 
                $result['valid'] = false;
                $result['err_code'] = 'not-found-receipt';
            }else{
                foreach ($receipts as $receipt) {
                    // validate not found receipt line
                    if(count($receipt->lines) == 0){
                        array_push($result['err_receipt_id'], $receipt->receipt_id);
                        array_push($result['err_msg'], 'please enter receipt line.');
                    }else{
                        $taxFlag = 'N';
                        foreach($receipt->lines as $line){
                            // validate required attachment
                            if($line->subCategory->required_attachment){
                                if(count($receipt->attachments) == 0){
                                    if(!in_array($receipt->receipt_id, $result['err_receipt_id'])){
                                        array_push($result['err_receipt_id'], $receipt->receipt_id);
                                        array_push($result['err_msg'], 'required attachment.');
                                    }
                                }
                            }
                            if($line->vat_id){
                                $taxFlag = 'Y';
                            }
                        }
                        // validate required vendor if use vat in receipt line
                        if($taxFlag == 'Y'){
                            if($receipt->receiptable_type != 'App\Invoice'){
                                if(!$receipt->vendor_id){
                                    array_push($result['err_receipt_id'], $receipt->receipt_id);
                                    array_push($result['err_msg'], 'please enter vendor information.');
                                }
                            }
                        }
                        // validate total receipt must greater than zero
                        if(in_array($requestType, ['CASH-ADVANCE', 'CLEARING'])){
                            if((float)$receipt->total_amount <= 0){
                                array_push($result['err_receipt_id'], $receipt->receipt_id);
                                array_push($result['err_msg'], 'receipt amount must be greater than zero.');
                            }
                            
                        }
                    }
                }
                if(count($result['err_receipt_id'])>0){
                    $result['valid'] = false;
                    $result['err_code'] = 'invalid-receipt';
                }
            }
        }
        
        return $result;
    }

    public static function combineReceiptGLCodeCombination($parent)
    {
        $result = ['status'=>'success','err_msg'=>'','err_receipt_line_id'=>null];
        return $result;
        // $pointerReceiptLineId = null;
        // try {
        //     if(count($parent->receipts)>0){
        //         foreach ($parent->receipts as $rcp_key => $receipt) {
        //             if(count($receipt->lines)>0){
        //                 foreach ($receipt->lines as $l_key => $line) {
        //                     $pointerReceiptLineId = $line->receipt_line_id;
        //                     ///////////////////////////
        //                     // COMBINE GL ACCOUNT CODE
        //                     $lineSubCategory = SubCategory::find($line->sub_category_id);
        //                     $lineSegmants = InterfaceRepo::composeGLCodeCombinationSegments($line->branch_code,$line->department_code,$lineSubCategory->account_code,$lineSubCategory->sub_account_code,$receipt->project,$receipt->recharge);
        //                     $glCodeCombination = InterfaceRepo::getGLCodeCombinationOfEmpBySegments($parent->user->employee,$lineSegmants);

        //                     $line->code_combination_id = $glCodeCombination['code_combination_id'];
        //                     $line->concatenated_segments = $glCodeCombination['concatenated_segments'];
        //                     $line->save();
        //                 }
        //             }
        //         }
        //     }

        // } catch (\Exception $e) {
        //     // throw new \Exception($e->getMessage(), 1);
        //     $result = [ 'status'                =>  'error',
        //                 'err_msg'               =>  $e->getMessage(),
        //                 'err_receipt_line_id'   =>  $pointerReceiptLineId];
        //     return $result;
        // }

        // return $result;
    }

    public static function validateIsNotOverBudget($parent, $type = 'REIMBURSEMENT')
    {
        $result = ['valid'=>true,'arr_err_lines'=>[]];

        $arrAccount = [];

        $receipts = $parent->receipts()->processType($type)->get();
        if( in_array($type, ['REIMBURSEMENT', 'CASH-ADVANCE']) ){
            
            // SUM TOTAL AMOUNT GROUP BY ACCOUNT (CODE COMBINATION ID)
            if(count($receipts)>0){
                foreach ($receipts as $rcp_key => $receipt) {
                    if(count($receipt->lines)>0){
                        foreach ($receipt->lines as $l_key => $line) {
                            $overBudgetResult = InterfaceAP::getBudgetByAccount($parent->org_id, $line->concatenated_segments, $line->total_primary_amount, $parent->gl_date);
                            $combination_id = $line->code_combination_id;
                            // if($line->subCategory->check_budget){
                                // IF FIRST TIME FOR THIS ACCOUNT (CODE COMBINATION ID)
                                if(!array_key_exists($combination_id, $arrAccount)){
                                    $arrAccount[$combination_id]['code_combination_id'] = $combination_id;
                                    $arrAccount[$combination_id]['concatenated_segments']  = $line->concatenated_segments;
                                    $arrAccount[$combination_id]['total_amount'] = (float)$line->total_primary_amount;
                                    // $arrAccount[$combination_id]['total_amount'] = (float)$line->total_primary_amount;
                                    $arrAccount[$combination_id]['receipt_id'] = [];
                                    $arrAccount[$combination_id]['receipt_line_id'] = [];
                                    $arrAccount[$combination_id]['sub_category_id'] = [];
                                    $arrAccount[$combination_id]['category_icon'] = [];
                                    $arrAccount[$combination_id]['sub_category_name'] = [];
                                }else{ // IF ALREADY HAVE THIS ACCOUNT (CODE COMBINATION ID) => SUM FOR TOTAL
                                    $arrAccount[$combination_id]['total_amount'] += (float)$line->total_primary_amount;
                                    // $arrAccount[$combination_id]['total_amount'] += (float)$line->total_primary_amount;
                                }
                                // IF NOT HAVE THIS RECEIPT ON THIS ACCOUNT (CODE COMBINATION ID)
                                if(!in_array($receipt->receipt_id, $arrAccount[$combination_id]['receipt_id'])){
                                    array_push($arrAccount[$combination_id]['receipt_id'], $receipt->receipt_id);
                                }
                                // IF NOT HAVE THIS RECEIPT LINE ON THIS ACCOUNT (CODE COMBINATION ID)
                                if(!in_array($line->id, $arrAccount[$combination_id]['receipt_line_id'])){
                                    array_push($arrAccount[$combination_id]['receipt_line_id'], $line->receipt_line_id);
                                }
                                // IF NOT HAVE THIS SUB CATEGORY ON THIS ACCOUNT (CODE COMBINATION ID)
                                if(!in_array($line->sub_category_id, $arrAccount[$combination_id]['sub_category_id'])){
                                    array_push($arrAccount[$combination_id]['sub_category_id'], $line->sub_category_id);
                                    array_push($arrAccount[$combination_id]['category_icon'], $line->category->icon);
                                    array_push($arrAccount[$combination_id]['sub_category_name'], $line->subCategory->name);
                                }
                            // }
                            $line->budget_amount = (float)$overBudgetResult['budget_amount'];
                            $line->encumbrance_amount = (float)$overBudgetResult['encumbrance_amount'];
                            $line->actual_amount = (float)$overBudgetResult['actual_amount'];
                            $line->fund_available = (float)$overBudgetResult['fund_available'];
                            $line->save();
                        }
                    }
                }
            }

        }elseif( $type == 'CLEARING') {

            if(count($receipts)>0){
                foreach ($receipts as $rcp_key => $receipt) {
                    if(count($receipt->lines)>0){
                        foreach ($receipt->lines as $l_key => $line) {
                            $overBudgetResult = InterfaceAP::getBudgetByAccount($parent->org_id, $line->concatenated_segments, $line->total_primary_amount, $parent->gl_date);
                            $combination_id = $overBudgetResult['template_id'] ?? $line->code_combination_id;
                            // if($line->subCategory->check_budget){
                                // IF FIRST TIME FOR THIS ACCOUNT (CODE COMBINATION ID)
                                if(!array_key_exists($combination_id, $arrAccount)){
                                    $arrAccount[$combination_id]['code_combination_id'] = $combination_id;
                                    $arrAccount[$combination_id]['concatenated_segments']  = $line->concatenated_segments;
                                    $arrAccount[$combination_id]['total_amount'] = (float)$line->total_primary_amount;
                                    // $arrAccount[$combination_id]['total_amount'] = (float)$line->total_primary_amount;
                                    $arrAccount[$combination_id]['receipt_id'] = [];
                                    $arrAccount[$combination_id]['receipt_line_id'] = [];
                                    $arrAccount[$combination_id]['sub_category_id'] = [];
                                    $arrAccount[$combination_id]['category_icon'] = [];
                                    $arrAccount[$combination_id]['sub_category_name'] = [];
                                }else{ // IF ALREADY HAVE THIS ACCOUNT (CODE COMBINATION ID) => SUM FOR TOTAL
                                    $arrAccount[$combination_id]['total_amount'] += (float)$line->total_primary_amount;
                                    // $arrAccount[$combination_id]['total_amount'] += (float)$line->total_primary_amount;
                                }
                                // IF NOT HAVE THIS RECEIPT ON THIS ACCOUNT (CODE COMBINATION ID)
                                if(!in_array($receipt->receipt_id, $arrAccount[$combination_id]['receipt_id'])){
                                    array_push($arrAccount[$combination_id]['receipt_id'], $receipt->receipt_id);
                                }
                                // IF NOT HAVE THIS RECEIPT LINE ON THIS ACCOUNT (CODE COMBINATION ID)
                                if(!in_array($line->id, $arrAccount[$combination_id]['receipt_line_id'])){
                                    array_push($arrAccount[$combination_id]['receipt_line_id'], $line->receipt_line_id);
                                }
                                // IF NOT HAVE THIS SUB CATEGORY ON THIS ACCOUNT (CODE COMBINATION ID)
                                if(!in_array($line->sub_category_id, $arrAccount[$combination_id]['sub_category_id'])){
                                    array_push($arrAccount[$combination_id]['sub_category_id'], $line->sub_category_id);
                                    array_push($arrAccount[$combination_id]['category_icon'], $line->category->icon);
                                    array_push($arrAccount[$combination_id]['sub_category_name'], $line->subCategory->name);
                                }
                            // }
                            $line->budget_amount = (float)$overBudgetResult['budget_amount'];
                            $line->encumbrance_amount = (float)$overBudgetResult['encumbrance_amount'];
                            $line->actual_amount = (float)$overBudgetResult['actual_amount'];
                            $line->fund_available = (float)$overBudgetResult['fund_available'];
                            $line->save();
                        }
                    }
                }
            }

            $caReceipts = $parent->receipts()->processType('CASH-ADVANCE')->get();

            if(count($caReceipts)>0){
                foreach ($caReceipts as $rcp_key => $receipt) {
                    if(count($receipt->lines)>0){
                        foreach ($receipt->lines as $l_key => $line) {
                            $overBudgetResult = InterfaceAP::getBudgetByAccount($parent->org_id, $line->concatenated_segments, $line->total_primary_amount, $parent->gl_date);
                            $combination_id = $overBudgetResult['template_id'] ?? $line->code_combination_id;
                            // if($line->subCategory->check_budget){
                                // CHECK DIFF FOR THIS ACCOUNT (CODE COMBINATION ID)
                                if(array_key_exists($combination_id, $arrAccount)){
                                    $arrAccount[$combination_id]['total_amount'] -= (float)$line->total_primary_amount;
                                }
                            // }
                        }
                    }
                }
            }

        }else{ // CALL PACKAGE ERROR
            throw new \Exception("Error : Type check budget not found.", 1);
        }

        // CHECK OVER BUDGET BY TOTAL AMOUNT BY ACCOUNT (CODE COMBINATION ID)
        foreach ($arrAccount as $codeCombinationId => $account) {
            // if($account['total_amount'] > 0){
                $overBudgetResult = InterfaceAP::getBudgetByAccount($parent->org_id, $account['concatenated_segments'], $account['total_amount'], $parent->gl_date);
                // if($overBudgetResult['status'] == 'E'){
                //     dd($parent->org_id, $account['concatenated_segments'], $account['total_amount'], $overBudgetResult);
                // }
                // CALL PACKAGE SUCCESS
                if($overBudgetResult['status'] != 'E'){
                    $amountAvailable = (float)$overBudgetResult['fund_available'];
                    // IF TOTAL AMOUNT > AMOUNT AVAILABLE
                    if($overBudgetResult['status'] == 'S'){
                        $status = 'S';
                        $status_msg = 'This account does not require funds check';
                    }elseif((float)$account['total_amount'] > $amountAvailable){
                        $arr_err_line['receipt_id'] = $account['receipt_id'];
                        $arr_err_line['receipt_line_id'] = $account['receipt_line_id'];
                        $arr_err_line['concatenated_segments'] = $account['concatenated_segments'];
                        $arr_err_line['category_icon'] = $account['category_icon'];
                        $arr_err_line['sub_category_name'] = $account['sub_category_name'];
                        $arr_err_line['total_amount'] = $account['total_amount'];
                        $arr_err_line['amount_available'] = $amountAvailable;
                        $arr_err_line['over_amount'] = abs((float)$account['total_amount'] - $amountAvailable);
                        $arr_err_line['err_msg'] = 'over budget';
                        array_push($result['arr_err_lines'], $arr_err_line);

                        $status = 'N';
                        $status_msg = 'Over Budget';
                    }else {
                        $status = 'P';
                        $status_msg = 'Pass';
                    }

                    $rectLines = ReceiptLine::find($account['receipt_line_id']);
                    foreach ($rectLines as $line) {
                        $line->budget_status = $status;
                        $line->budget_status_msg = $status_msg;
                        $line->save();
                    }

                }else{ // CALL PACKAGE ERROR
                    throw new \Exception("Error : call package error - ".$overBudgetResult['message'], 1);
                }
            // }
        }

        // IF FOUND ERROR LINE
        if(count($result['arr_err_lines']) > 0){
            $result['valid'] = false;
        }

        return $result;
    }

    public static function validateIsNotExceedPolicy($parent)
    {
        $result = ['valid'=>true,'arr_err_lines'=>[]];
        return $result;
        // NOT USE POLICY IN TOAT
        if(count($parent->receipts)>0){
            foreach ($parent->receipts as $rcp_key => $receipt) {
                if(count($receipt->lines)>0){
                    foreach ($receipt->lines as $l_key => $line) {
                        // IF USE POLICY
                        if($line->policy){

                            // USE POLICY EXPENSE
                            if($line->policy->typeExpense()){
                                // IF NOT UNLIMIT RATE
                                if(!$line->rate->unlimit){
                                    // COMPARE RATE WITH AMOUNT PER UNIT
                                    $policyRate = $line->rate->rate;
                                    $transactionQuantity = $line->transaction_quantity;
                                    // $totalAmount = $line->total_primary_amount;
                                    $totalAmount = $line->total_primary_amount;
                                    $amountPerUnit = (float)$totalAmount/(float)$transactionQuantity;
                                    // IF AMOUNT PER UNIT EXCEED POLICY
                                    if((float)$amountPerUnit > (float)$policyRate){
                                        $arr_err_line['receipt_id'] = $receipt->receipt_id;
                                        $arr_err_line['receipt_line_id'] = $line->id;
                                        if($line->subCategory->allow_exceed_policy){
                                            $arr_err_line['err_type'] = 'warning';
                                            $arr_err_line['err_msg'] = 'exceed policy';
                                        }else{
                                            $arr_err_line['err_type'] = 'error';
                                            $arr_err_line['err_msg'] = 'exceed policy';
                                        }
                                        array_push($result['arr_err_lines'], $arr_err_line);
                                    }
                                }

                            // USE POLICY MILEAGE
                            }elseif($line->policy->typeMileage()){
                                // IF NOT UNLIMIT RATE
                                if(!$line->rate->unlimit){
                                    // COMPARE MILEAGE RATE WITH AMOUNT PER UNIT
                                    $policyRate = $line->rate->rate;
                                    $mileageRate = (float)$line->rate->rate * (float)$line->mileage_distance;
                                    $transactionQuantity = $line->transaction_quantity; // NOW ALWAYS 1
                                    // $totalAmount = $line->total_primary_amount;
                                    $totalAmount = $line->total_primary_amount;
                                    $amountPerUnit = (float)$totalAmount/(float)$transactionQuantity;
                                    // IF AMOUNT PER UNIT EXCEED POLICY
                                    if((float)$amountPerUnit > (float)$mileageRate){
                                        $arr_err_line['receipt_id'] = $receipt->receipt_id;
                                        $arr_err_line['receipt_line_id'] = $line->receipt_line_id;
                                        if($line->subCategory->allow_exceed_policy){
                                            $arr_err_line['err_type'] = 'warning';
                                        }else{
                                            $arr_err_line['err_type'] = 'error';
                                        }
                                        $arr_err_line['err_msg'] = 'exceed policy';
                                        array_push($result['arr_err_lines'], $arr_err_line);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // IF FOUND ERROR LINE
        if(count($result['arr_err_lines']) > 0){
            $result['valid'] = false;
        }

        return $result;
    }

}
