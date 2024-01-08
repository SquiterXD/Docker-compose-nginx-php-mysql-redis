<?php

namespace App\Repositories\OM;

use App\Models\OM\Api\Customer;
use App\Models\OM\PaymentHeader;
use App\Models\OM\PaymentLines;
use App\Models\OM\PaymentMatchInvoice;

class PaymentRepo
{
    public static function getAmountBalance($customer_number)
    {
        $customer = Customer::where('customer_number', $customer_number)->first();
        $paymentHeader = PaymentHeader::where('payment_status', '!=', 'Cancel')->where('customer_id', $customer->customer_id)->select('payment_header_id');
        if (!empty($paymentHeader)) {
            $detail = PaymentLines::whereIn('payment_header_id', $paymentHeader)->sum('payment_amount');
            $sum = PaymentMatchInvoice::whereIn('payment_header_id', $paymentHeader)->where('match_flag', 'Y')->sum('payment_amount');

            return number_format($detail - $sum,2);
        } else {
            return '0.00';
        }
    }
}
