<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDirectDebit extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_direct_debit';
    public $primaryKey = 'order_direct_debit_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];

    public static function joinOrderHeader()
    {
        $result = self::select(['ptom_order_direct_debit.*','ptom_payment_type.*','ptom_customers.*','ptom_order_headers.*','ptom_order_headers.delivery_date as order_delivery_date'])->join('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_direct_debit.order_header_id')
        ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
        ->join('ptom_payment_type', 'ptom_payment_type.lookup_code', '=', 'ptom_order_headers.payment_type_code');
        // ->join('ptce_bank_accounts_v', 'ptce_bank_accounts_v.bank_account_id', '=', 'ptom_order_direct_debit.direct_debit_id');
        return $result;
    }

    public static function joinOrderHeaderConfirm()
    {
        $result = self::select(['ptom_direct_debit.*','ptom_order_direct_debit.*','ptom_payment_type.*','ptom_customers.*','ptom_order_headers.*','ptom_order_headers.delivery_date as order_delivery_date'])->join('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_direct_debit.order_header_id')
        ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
        ->join('ptom_payment_type', 'ptom_payment_type.lookup_code', '=', 'ptom_order_headers.payment_type_code');
        // ->join('ptce_bank_accounts_v', 'ptce_bank_accounts_v.bank_account_id', '=', 'ptom_order_direct_debit.direct_debit_id');
        return $result;
    }
    // public static function joinCustomer()
    // {
    //     $result = self::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id');
    //     return $result;
    // }
}