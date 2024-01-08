<?php

namespace App\Repositories\OM;

use App\Http\Controllers\OM\Api\OrderEcomController;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Api\OrderQuotaHistory;
use App\Models\OM\Api\OrderCreditGroup;
use App\Models\OM\ReleaseCredit;
use Carbon\Carbon;

class CreditAndQuotaRepo
{
    public static function updateCustomerContractRefund($contractGroups,$orderHeader,$orderCredit)
    {
        $customerContractGroups = CustomerContractGroups::where('credit_group_code',$contractGroups->credit_group_code)->where('customer_id',$orderHeader->customer_id)->whereNull('deleted_at')->first();

        $remaining_amount = $customerContractGroups->remaining_amount + $orderCredit->amount;

        DB::table('ptom_customer_contract_groups')
        ->where('credit_group_code',$contractGroups->credit_group_code)
        ->where('customer_id',$orderHeader->customer_id)
        ->whereNull('deleted_at')
        ->update(array(
            // 'remaining_amount'=>($orderCredit->remaining_amount - $orderCredit->amount),
            'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
        ));

    }

    public static function updateCustomerContractDeduct($contractGroups,$orderHeader,$orderCredit,$creditAmount)
    {
        $customerContractGroups = CustomerContractGroups::where('credit_group_code',$contractGroups->credit_group_code)->where('customer_id',$orderHeader->customer_id)->whereNull('deleted_at')->first();
        
       
        
        // -------------------------------------- New Recal ---------------------------------------------
        try {
            $invDue = [];
            if(!empty(request()->outstanding_id)) {
                foreach(request()->outstanding_id as $key => $item) {
                        $invDue[] = explode('_',$key)[0];
                }
            }
            $releaseCredit = ReleaseCredit::where('customer_id',$customerContractGroups->customer_id)
            ->whereIn('invoice_num',$invDue)
            ->where('credit_group_code',$contractGroups->credit_group_code)
            ->get();
            if(strlen($orderHeader->delivery_date) == '19') {
                $odelivery_date = Carbon::createFromFormat('Y-m-d H:i:s',$orderHeader->delivery_date)->format('d/m/Y');
            } else {
                $odelivery_date = Carbon::createFromFormat('Y-m-d',$orderHeader->delivery_date)->format('d/m/Y');
            }
            // dump( $releaseCredit->pluck('invoice_num')->toArray(), $contractGroups->credit_group_code);
            $c = (new OrderEcomController)->reCalculateRemainingAmountV2($customerContractGroups->customer_id, $odelivery_date, $orderHeader->period_id, $releaseCredit->pluck('invoice_num')->toArray());
        } catch (\Throwable $th) {
            $invDue = [];
            if(!empty(request()->outstanding_id)) {
                foreach(request()->outstanding_id as $key => $item) {
                        $invDue[] = explode('_',$item)[0];
                }
            }

            $c = (new OrderEcomController)->reCalculateRemainingAmountV2($customerContractGroups->customer_id, Carbon::parse($orderHeader->delivery_date)->format('d/m/Y'), $orderHeader->period_id, $invDue);
        }
        $remaining_base = $c['cusContractGroup']->where('credit_group_code', $contractGroups->credit_group_code)->first();
        $remaining_base =  $remaining_base->credit_amount * ($remaining_base->credit_percentage / 100);
        $ptOmDebtDomV = $c['ptOmDebtDomV']->where('credit_group_code', $contractGroups->credit_group_code)->sum('outstanding_debt');
        $debtDomV = $c['debtDomV']->where('credit_group_code', $contractGroups->credit_group_code)->sum('outstanding_debt');
        $orderHeaders = $c['orderHeaders']->where('credit_group_code', $contractGroups->credit_group_code)->where('prepare_order_number', '!=', $orderHeader->prepare_order_number)->sum('amount');
        $new_remaining_amount = $remaining_base - $ptOmDebtDomV - $orderHeaders + $debtDomV;
        // -----------------------------------------------------------------------------------
        

        // OLD :: $customerContractGroups->remaining_amount
        // NEW :: $new_remaining_amount
        if($new_remaining_amount > $creditAmount[$contractGroups->credit_group_code]){
            $amount = $creditAmount[$contractGroups->credit_group_code];
            $remaining_amount = $new_remaining_amount - $creditAmount[$contractGroups->credit_group_code];
        }else{
            $amount = $new_remaining_amount;
            $remaining_amount = 0;
        }
        // $sumCredit = ($creditAmount[$contractGroups->credit_group_code] >= $orderCredit->remaining_amount) ? $orderCredit->remaining_amount : $creditAmount[$contractGroups->credit_group_code];

        DB::table('ptom_customer_contract_groups')
        ->where('credit_group_code',$contractGroups->credit_group_code)
        ->where('customer_id',$orderHeader->customer_id)
        ->whereNull('deleted_at')
        ->update(array(
            'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
        ));
        DB::table('ptom_order_credit_groups')
        ->where('order_header_id',$orderHeader->order_header_id)
        ->where('credit_group_code',$contractGroups->credit_group_code)
        ->where('order_line_id',0)
        ->update(array(
            'amount'=>(($amount < 0) ? 0 : $amount),
            'remaining_amount' => $remaining_amount,
        ));



        DB::table('oaom.ptom_order_remaining')->where('order_header_id',$orderHeader->order_header_id)->update([
            "group{$contractGroups->credit_group_code}_amount" => (($new_remaining_amount < 0) ? 0 : $new_remaining_amount)
            ,"group{$contractGroups->credit_group_code}_remaining" => $remaining_amount,
        ]);

        return $amount;

    }

    public static function setCustomerQuota($orderHeader,$group)
    {
        $orderQuota = OrderQuotaHistory::where('order_header_id',$orderHeader->order_header_id)->where('quota_group_code',$group['group']->lookup_code)->first();

        if(is_null($orderQuota)){
            $orderQuota = new OrderQuotaHistory();
            $orderQuota->order_header_id = $orderHeader->order_header_id;
            $orderQuota->quota_group_code = $group['group']->lookup_code;
            $orderQuota->received_quota = $group['received_quota'];
            $orderQuota->remaining_quota = $group['remaining_quota'];
            $orderQuota->spending_quota = 0;
            $orderQuota->program_code = 'OMP00019';
            $orderQuota->created_by = 1;
            $orderQuota->creation_date = now();
            $orderQuota->last_updated_by = 1;
            $orderQuota->last_update_date = now();
        }else{

            // $orderQuota->received_quota = $orderQuota->received_quota;
            // $orderQuota->remaining_quota = $orderQuota->remaining_quota;
            $orderQuota->spending_quota = 0;
        }

        $orderQuota->save();
    }

    public static function updateCustomerQuotaSpending($orderHeader,$group,$spending)
    {
        $orderQuota = OrderQuotaHistory::where('order_header_id',$orderHeader->order_header_id)->where('quota_group_code',$group->lookup_code)->first();
        $orderQuota->spending_quota = $spending;
        $orderQuota->save();
    }

    public static function getCustomerQuotaSpending($orderHeader,$group)
    {
        return OrderQuotaHistory::where('order_header_id',$orderHeader->order_header_id)->where('quota_group_code',$group->lookup_code)->first();
    }

    public static function updateCustomerQuotaRefund($quota,$remaining)
    {
        DB::table('ptom_customer_quota_lines')
        ->where('quota_header_id',$quota->quota_header_id)
        ->where('quota_line_id',$quota->quota_line_id)
        ->where('item_id',$quota->item_id)
        ->whereNull('deleted_at')
        ->update(array(
            'remaining_quota'=>$remaining,
        ));

    }

    public static function setOrderCredit($orderCredit,$orderHeader,$contractGroups,$program_code,$amountRelease=0)
    {

        // $amountRelease = ReleaseCredit::where('customer_id',$orderHeader->customer_id)->where('invoice_id',$orderHeader->order_header_id)->where('credit_group_code',$contractGroups->credit_group_code)->sum('amount');

        $remaining_amount = $contractGroups->remaining_amount + $amountRelease;
        if($remaining_amount > $contractGroups->credit_amount){
            $remaining_amount = $contractGroups->credit_amount;
        }

        if(is_null($orderCredit)){
            DB::table('ptom_order_credit_groups')->insert([
                'order_header_id'=>$orderHeader->order_header_id,
                'order_line_id'=> 0,
                'credit_group_code' => $contractGroups->credit_group_code,
                'amount' => 0,
                'period_id' => $orderHeader->period_id,
                'received_amount' => $contractGroups->credit_amount,
                'remaining_amount' => (($remaining_amount < 0) ? 0 : $remaining_amount),
                'program_code' => $program_code,
                'created_by' => 1,
                'last_updated_by' => 1
            ]);
        }else{
            DB::table('ptom_order_credit_groups')
            ->where('order_header_id',$orderHeader->order_header_id)
            ->where('credit_group_code',$contractGroups->credit_group_code)
            ->update(array(
                'amount'=>0,
                'received_amount' => $contractGroups->credit_amount,
                'remaining_amount' => (($remaining_amount < 0) ? 0 : $remaining_amount),
                'period_id' => $orderHeader->period_id,
            ));
        }

    }

    public static function setOrderCash($orderCredit,$orderHeader,$amount,$program_code)
    {
        if(is_null($orderCredit)){
            DB::table('ptom_order_credit_groups')->insert([
                'order_header_id'=>$orderHeader->order_header_id,
                'order_line_id'=> 0,
                'credit_group_code' => 0,
                'period_id' => $orderHeader->period_id,
                'amount' => (($amount < 0) ? 0 : $amount),
                'received_amount' => 0,
                'remaining_amount' => 0,
                'program_code' => $program_code,
                'created_by' => 1,
                'last_updated_by' => 1
            ]);
        }else{
            DB::table('ptom_order_credit_groups')
            ->where('order_header_id',$orderHeader->order_header_id)
            ->where('order_line_id',0)
            ->where('credit_group_code',0)
            ->update(array(
                'amount'=>(($amount < 0) ? 0 : $amount),
                'period_id' => $orderHeader->period_id,
            ));
        }
    }

}
