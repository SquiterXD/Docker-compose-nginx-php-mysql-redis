<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;

class ARReceiptInfReport extends Model
{

    protected $table = 'PTOM_AR_RECEIPT_INF_REPORT';
    public $primaryKey = 'ar_receipt_report_id';

    public function payment()
    {
        return $this->hasOne('App\Models\OM\PaymentHeader', 'payment_header_id', 'payment_header_id');
    }
}
