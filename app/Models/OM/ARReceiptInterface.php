<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARReceiptInterface extends Model
{
    use HasFactory;

    protected $table = 'PTOM_AR_RECEIPT_INTERFACE';
    public $primaryKey = 'ar_receipt_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    public function match()
    {
        return $this->hasOne(PaymentMatchInvoice::class, 'payment_match_id', 'match_id');
    }
}
