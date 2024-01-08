<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ORDER_HEADERS';
    public $primaryKey = 'ORDER_HEADER_ID';
    public $timestamps = false;

    protected $fillable = ['prepare_order_number', 'order_number'];

    public function Customer()
    {
        return $this->hasOne('App\Models\OM\Customers\Domestics\Customer','customer_id','customer_id');
    }

    public function scopeSearchReport($q, $dataSearch)
    {  
        // dd($dataSearch->all());
        $delivery_start_date       = $dataSearch->delivery_start_date ? parseFromDateTh($dataSearch->delivery_start_date) : '';
        $delivery_end_date         = $dataSearch->delivery_end_date   ? parseFromDateTh($dataSearch->delivery_end_date)   : '';
        $prepare_order_number      = $dataSearch->prepare_order_number;
        $customer_id               = $dataSearch->customer_id;
        $pick_release_approve_flag = $dataSearch->pick_release_approve_flag;
        $pick_release_no           = $dataSearch->pick_release_no;
        $pick_release_status       = $dataSearch->pick_release_status;
        $pick_release_print_flag   = $dataSearch->pick_release_print_flag;

        // dd($dataSearch->delivery_start_date, $delivery_start_date);

        if ($delivery_start_date && $delivery_end_date) {
            $q->whereRaw("ptom_order_headers.delivery_date BETWEEN '{$delivery_start_date}' AND '{$delivery_end_date}'");
        // }elseif ($delivery_start_date) {
        //     $q->where('ptom_order_headers.delivery_date', $delivery_start_date);
        // }elseif ($delivery_end_date) {
        //     $q->where('ptom_order_headers.delivery_date', $delivery_end_date);
        } else {
            $q;
        }

        if ($prepare_order_number) {
            $q->where('ptom_order_headers.prepare_order_number', $prepare_order_number);
        }else {
            $q;
        }

        if ($customer_id) {
            $q->where('ptom_order_headers.customer_id', $customer_id);
        }else {
            $q;
        }

        if ($pick_release_approve_flag) {
            $q->where('ptom_order_headers.pick_release_approve_flag', $pick_release_approve_flag);
        }else {
            $q;
        }

        if ($pick_release_no) {
            $q->where('ptom_order_headers.pick_release_no', $pick_release_no);
        }else {
            $q;
        }

        if ($pick_release_status) {
            $q->where('ptom_order_headers.pick_release_status', $pick_release_status);
        }else {
            $q;
        }

        if ($pick_release_print_flag) {
            $q->where('ptom_order_headers.pick_release_print_flag', $pick_release_print_flag);
        }else {
            $q;
        }

        return $q;
    }

}
