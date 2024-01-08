<?php

namespace App\Models\OM;

use App\Models\OM\Api\OrderLines;
use App\Models\OM\Api\ProductTypeExport;
use App\Models\OM\OverdueDebt\ProformaInvoiceHeaders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHeaders extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_headers';
    public $primaryKey = 'order_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';
    protected $guarded = []; 

    public function producttype()
    {
        return $this->hasOne(ProductType::class, 'lookup_code', 'product_type_code');
    }

    public function producttypes()
    {
        return $this->hasOne(ProductTypeExport::class, 'lookup_code', 'product_type_code');
    }

    public static function getLastPrepareNumber($budgetYear)
    {
        $number = self::whereNotNull('prepare_order_number')
                    ->where('prepare_order_number', 'LIKE', "%".$budgetYear."O%")
                    ->orderBy('order_header_id','desc')
                    ->first()
                    ->prepare_order_number;

        return $number;
    }

    public static function getLastOrderNumber()
    {
        $number = self::whereNotNull('order_number')
                    ->where('order_number', 'LIKE', "%POC%")
                    ->orderBy('order_header_id','desc')
                    ->first()
                    ->order_number;

        return $number;
    }

    public function orderamounts()
    {
        return $this->hasMany(OrderLines::class, 'order_header_id', 'order_header_id')->selectRaw("SUM(ptom_order_lines.total_amount) as total_amount");
    }

    public static function lovSaOrderNumber()
    {
        $result = self::whereNotNull("prepare_order_number")->where('order_status','Confirm')->whereNull("deleted_at")->orderBy('prepare_order_number','desc')->get();
        return $result;
    }

    public static function lovInvoiceOrderNumber()
    {
        $result = self::whereNotNull("pick_release_no")->whereRaw("pick_release_approve_flag = 'Y'")->orderBy('pick_release_no','desc')->get();
        return $result;
    }

    public function getSANUMBER() {
        return $this->hasOne(ProformaInvoiceHeaders::class, 'order_header_id','order_header_id');
    }

    // search with MCR 04092021
    public function lines() {
        return $this->hasMany(ProformaInvoiceHeaders::class, 'order_header_id', 'order_header_id')->orderBy('pi_number');
    }

    public function customer() {
        return $this->hasOne(Customers::class, 'customer_id','customer_id');
    }

    public function period() {
        return $this->hasOne(PeriodV::class, 'period_line_id','period_id');
    }

    public function paymentType() {
        return $this->hasOne(Payment\PaymentType::class, 'lookup_code', 'payment_type_code');
    }

    public function orderType() {
        return $this->hasOne(OrderType::class, 'order_type_id','order_type_id');
    }

    public function scopeSearch($q, $param, $type)
    {
        if ($param) {
            $delivery_start_date = $param['type'] == 'domestic'
                                ? parseFromDateTh(date('Y-m-d', strtotime($param['delivery_start_date'])))
                                : date('Y-m-d', strtotime($param['delivery_start_date']));
            $delivery_end_date = $param['type'] == 'domestic'
                                ? parseFromDateTh(date('Y-m-d', strtotime($param['delivery_end_date'])))
                                : date('Y-m-d', strtotime($param['delivery_end_date']));

            if (($param['delivery_start_date'] != '' || $param['delivery_start_date'] != null)
                && ($param['delivery_end_date'] != '' || $param['delivery_end_date'] != null)) {
                $q->whereRaw("trunc(delivery_date) BETWEEN TO_DATE('{$delivery_start_date}','YYYY-mm-dd') AND TO_DATE('{$delivery_end_date}','YYYY-mm-dd')");
            }elseif($param['delivery_start_date'] != '' || $param['delivery_start_date'] != null){
                $q->whereRaw("trunc(delivery_date) = TO_DATE('{$delivery_start_date}','YYYY-mm-dd') ");
            }else{
                $q;
            }

            // check เงื่อนไข Domestic/Export
            if ($param['type'] == 'domestic') {
            //     if ($param['prepare_so_no'] == '' || $param['prepare_so_no'] == null) {
            //         $q;
            //     }else{
            //         $q->where('prepare_order_number', $param['prepare_so_no']);
            //     }

            //     if ($param['period_id'] == '' || $param['period_id'] == null) {
            //         $q;
            //     }else{
            //         $q->where('period_id', $param['period_id']);
            //     }

                if ($param['prepare_so_status'] == '' || $param['prepare_so_status'] == null) {
                    $q;
                }else{
                    $q->where('order_status', $param['prepare_so_status']);
                }
            }else{
                $order_start_date = $param['type'] == 'domestic'
                                ? parseFromDateTh(date('Y-m-d', strtotime($param['order_start_date'])))
                                : date('Y-m-d', strtotime($param['order_start_date']));
                $order_end_date = $param['type'] == 'domestic'
                                ? parseFromDateTh(date('Y-m-d', strtotime($param['order_end_date'])))
                                : date('Y-m-d', strtotime($param['order_end_date']));

                if ($param['so_no'] == '' || $param['so_no'] == null) {
                    $q;
                }else{
                    $q->where('order_number', $param['so_no']);
                }

                if ($param['payment_type'] == '' || $param['payment_type'] == null) {
                    $q;
                }else{
                    $q->where('payment_type_code', $param['payment_type']);
                }

                if ($param['customer_id'] == '' || $param['customer_id'] == null) {
                    $q;
                }else{
                    $q->where('customer_id', $param['customer_id']);
                }

                if ($param['order_type_id'] == '' || $param['order_type_id'] == null) {
                    $q;
                }else{
                    $q->where('order_type_id', $param['order_type_id']);
                }

                if ($param['sa_no'] == '' || $param['sa_no'] == null) {
                    $q;
                }else{
                    $q->where('prepare_order_number', $param['sa_no']);
                }

                if ($param['pi_id'] == '' || $param['pi_id'] == null) {
                    $q;
                }else{
                    $q->where('order_header_id', $param['pi_id']);
                }

                if ($param['invoice_no'] == '' || $param['invoice_no'] == null) {
                    $q;
                }else{
                    $q->where('pick_release_no', $param['invoice_no']);
                }

                if (($param['order_start_date'] != '' || $param['order_start_date'] != null)
                    && ($param['order_end_date'] != '' || $param['order_end_date'] != null)) {
                    $q->whereRaw("trunc(order_date) BETWEEN TO_DATE('{$order_start_date}','YYYY-mm-dd') AND TO_DATE('{$order_end_date}','YYYY-mm-dd')");
                }elseif($param['order_start_date'] != '' || $param['order_start_date'] != null){
                    $q->whereRaw("trunc(order_date) = TO_DATE('{$order_start_date}','YYYY-mm-dd') ");
                }else{
                    $q;
                }
            }
        }
        $deliveryDate = isset($param['delivery_date'])? $param['delivery_date']: '';
        return $q->whereHas('customer', function ($query) use ($type, $deliveryDate) {
                    return $query->whereRaw("lower(sales_classification_code) = '{$type}'")
                        ->whereRaw("lower(status) = 'active'")
                        ->whereRaw("nvl(delivery_date,'-$$$') like '%{$deliveryDate}%'");
                });
        // 27112021 Add where delivery_date in customer
    }
}