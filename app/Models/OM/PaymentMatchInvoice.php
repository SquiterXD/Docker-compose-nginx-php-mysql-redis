<?php

namespace App\Models\OM;

use App\Models\OM\Api\Customer;
use App\Models\OM\Api\OrderHeader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PaymentMatchInvoice extends Model
{
    use HasFactory;

    protected $table = 'ptom_payment_match_invoices';
    public $primaryKey = 'payment_match_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $fillable = [
        'payment_header_id',
        'payment_detail_id',
        'invoice_id',
        'invoice_number',
        'prepare_order_number',
        'credit_group_code',
        'due_day',
        'due_date',
        'payment_amount',
        'match_flag',
        'payment_type_code',
        'currency',
        'program_code',
        'created_by',
        'last_updated_by',
        'outstanding_debt',
        'match_exchange_rate',
        'last_update_date'
    ];

    public function orders()
    {
        $payment = PaymentHeader::where('payment_header_id', $this->payment_header_id)->first();
        // $order = OrderHeaders::where('prepare_order_number',$this->prepare_order_number)->first();
        $usersamo = DB::table('ptom_customers')->select('customer_type_id', 'sales_classification_code')->where('customer_id', $payment->customer_id)->first();
        if (!empty($usersamo) && ($usersamo->customer_type_id == '30' || $usersamo->customer_type_id == '40') && $usersamo->sales_classification_code == 'Domestic') {
            if ($this->prepare_order_number == null) {
                return $this->hasOne(ConsignmentHeader::class, 'consignment_header_id', 'invoice_id');
            } else {
                return $this->hasOne(OrderHeaders::class, 'prepare_order_number', 'prepare_order_number');
            }
        } else {
            return $this->hasOne(OrderHeaders::class, 'prepare_order_number', 'prepare_order_number');
        }
    }

    public function invoices()
    {
        return $this->hasOne(InvoiceHeaders::class, 'invoice_headers_id', 'invoice_id');
    }

    public function interfaces()
    {
        return $this->hasMany('App\Models\OM\ARReceiptInterface', 'match_id', 'payment_match_id');
    }

    public static function sumHeaderByCustomer($customer_id, $credit)
    {
        return self::join('ptom_payment_headers as ph', 'ph.payment_header_id', '=', 'ptom_payment_match_invoices.payment_header_id')
            ->where('credit_group_code', $credit)->where('customer_id', $customer_id)->where('match_flag', 'Y')->groupBy('credit_group_code')->sum('total_payment_amount');
    }

    public static function sumOrderHeaderByCustomer($customer_id, $credit)
    {
        return self::join('ptom_payment_headers as ph', 'ph.payment_header_id', '=', 'ptom_payment_match_invoices.payment_header_id')
            ->join('ptom_order_headers as oh', 'oh.prepare_order_number', '=', 'ptom_payment_match_invoices.prepare_order_number')
            ->join('ptom_order_lines as ol', 'ol.order_header_id', '=', 'oh.order_header_id')
            ->where('ol.credit_group_code', $credit)->where('oh.customer_id', $customer_id)->where('ptom_payment_match_invoices.match_flag', 'Y')->groupBy('ol.credit_group_code')->sum('ol.total_amount');
    }

    public static function sumOrderFinesByCustomer($customer_id, $credit)
    {
        return self::join('ptom_payment_headers as ph', 'ph.payment_header_id', '=', 'ptom_payment_match_invoices.payment_header_id')
            ->where('credit_group_code', $credit)->where('customer_id', $customer_id)->where('match_flag', 'Y')->groupBy('credit_group_code')->sum('ph.total_fine');
    }

    public function customer()
    {
        return $this->hasOne(Customers::class, 'customer_id', 'customer_id');
    }

    public function payment(){
        return $this->hasOne('App\Models\OM\PaymentHeader', 'payment_header_id', 'payment_header_id');
    }
    
    public function detail(){
        return $this->hasOne('App\Models\OM\PaymentLines', 'payment_detail_id', 'payment_detail_id');
    }

    public function applypayment($invoice_number, $prepare_order_number, $credit_group_code, $payment_header_id)
    {
        if ($invoice_number == null) {

            if ($credit_group_code == null) {
                $h = PaymentMatchInvoice::where('prepare_order_number', $prepare_order_number)->where('payment_header_id', $payment_header_id)->first();
            } else {
                $h = PaymentMatchInvoice::where('prepare_order_number', $prepare_order_number)->where('credit_group_code', $credit_group_code)->where('payment_header_id', $payment_header_id)->first();
            }
        } else {
            if ($credit_group_code == null) {
                $h = PaymentMatchInvoice::where('invoice_number', $invoice_number)->where('payment_header_id', $payment_header_id)->first();
            } else {
                $h = PaymentMatchInvoice::where('invoice_number', $invoice_number)->where('credit_group_code', $credit_group_code)->where('payment_header_id', $payment_header_id)->first();
            }
        }
        // $pm = [];
        // foreach($h as $hh){
        //     if(!in_array($hh->payment_match_id, $pm)){
        //         array_push($pm, $hh->payment_match_id);
        //     }
        // }
        // return PaymentApply::join('ptom_invoice_headers', 'ptom_payment_apply_cndn.invoice_header_id', 'ptom_invoice_headers.invoice_headers_id', 'left')->where('ptom_invoice_headers.invoice_type', '!=', 'DN')->whereIn('ptom_payment_apply_cndn.payment_match_id', $pm)->sum('ptom_payment_apply_cndn.invoice_amount');
        return PaymentApply::where('payment_match_id', $h->payment_match_id)->where('attribute1', 'Y')->sum('invoice_amount');
    }

    public function orderHeader(){
        return $this->hasOne('App\Models\OM\Api\OrderHeader', 'prepare_order_number', 'prepare_order_number');
    }

    public function orderHeaders(){
        return $this->hasMany('App\Models\OM\Api\OrderHeader', 'prepare_order_number', 'prepare_order_number')->orderBy('prepare_order_number');
    }

    public function proformaHeaders(){
        return $this->hasMany('\App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders', 'sa_number', 'prepare_order_number')->orderBy('sa_number');
    }

    public function consignment(){
        return $this->hasOne('App\Models\OM\Consignment', 'consignment_no', 'invoice_number');
    }
}
