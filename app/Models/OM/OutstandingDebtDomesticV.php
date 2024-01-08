<?php

namespace App\Models\OM;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutstandingDebtDomesticV extends Model
{
    // use HasFactory;
    protected $table = "OAOM.PTOM_OUTSTANDING_DEBT_DOM_V";
    public $primaryKey = '';
    public $timestamps = false;

    public function scopeSearch($q, $customerNum, $dataSearch)
    {
        $date              = @$dataSearch->date_selected;
        $customerType      = @$dataSearch->customer_type;
        $weeklyDeliveryDay = @$dataSearch->weekly_delivery_day;
        $creditGroupCode   = @$dataSearch->credit_group_code;

        return $q->when($customerNum, function($q) use($customerNum) {
            $q->where('customer_number', $customerNum);
        })->when($date, function($q) use($date) {
            $q->where('due_date', $date);
        })->when($customerType, function($q) use($customerType) {
            $q->where('customer_type_id', $customerType);
        })->when($weeklyDeliveryDay, function($q) use($weeklyDeliveryDay) {
            $q->where('weekly_delivery_day', $weeklyDeliveryDay);
        })->when($creditGroupCode, function($q) use($creditGroupCode) {
            $q->where('credit_group_code', $creditGroupCode);
        });
    }

    public function orderHeader(){
        return $this->belongsTo(OrderHeaders::class, 'order_header_id', 'order_header_id');
    }

    public function consignmentHeader(){
        return $this->belongsTo(ConsignmentHeaders::class, 'order_header_id', 'order_header_id');
    }

    public function paymentMatchInvoices(){
        return $this->hasMany(PaymentMatchInvoices::class, 'prepare_order_number', 'prepare_order_number');
    }

    public function orderCreditGroup()
    {
        return $this->hasMany(OrderCreditGroups::class, 'order_header_id', 'order_header_id');
    }
}
