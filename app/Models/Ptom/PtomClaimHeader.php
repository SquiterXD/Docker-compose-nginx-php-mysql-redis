<?php

namespace App\Models\Ptom;

use App\Models\OM\AttachFiles;
use App\Models\OM\Customers;
use App\Models\OM\DomesticMatching\PaymentApply;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomClaimHeader extends Model
{
    use HasFactory;
    protected $table = "ptom_claim_headers";
    public $primaryKey = 'claim_header_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at'];

    public function statusClaim() 
    {
        return $this->belongsTo(PtomClaimStatusV::class, 'status_claim_code', 'lookup_code');
    }

    public function paymentApply() {
        return $this->belongsTo(PaymentApply::class, 'credit_note_number', 'invoice_number');
    }

    public function orderHeader(){
        return $this->belongsTo(PtomOrderHeader::class, 'ref_invoice_number', 'pick_release_no');
    }
  
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'customer_id');
    }

    public function lines() 
    {
        return $this->hasMany(PtomClaimLine::class, 'claim_header_id', 'claim_header_id');
    }
}
