<?php

namespace App\Models\OM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    use HasFactory;

    protected $table = "ptom_consignment_headers";
    public $primaryKey = 'consignment_header_id';
    public $timestamps = false;

    public function lines()
    {
        return $this->hasMany('App\Models\OM\ConsignmentLines', 'consignment_header_id', 'consignment_header_id')->orderBy('consignment_line_id');
    }

    public function orderHeader()
    {
        return $this->hasOne('App\Models\OM\Api\OrderHeader', 'order_header_id', 'order_header_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function scopeConfirm($q)
    {
        return $q->whereRaw("upper(consignment_status) = 'CONFIRM'");
    }

    public function getTotalActualQty()
    {
        $lines = $this->lines()->get();
        return $lines ? $lines->sum('actual_quantity') : 0;
    }
    
    public function scopeSuccess($q)
    {
        return $q->where('interface_status', 'S');
    }

    public function attach()
    {
        return $this->hasMany('App\Models\OM\AttachFiles', 'header_id', 'consignment_header_id')->where('attachment_program_code', 'OMP0038')->whereNull('deleted_at');
    }

    public function adjustment()
    {
        return $this->hasOne('App\Models\OM\TaxAdjustModel', 'document_number', 'consignment_no');
    }

    public function adjustmentBkk()
    {
        return $this->hasOne('App\Models\OM\TaxAdjustmentsBKK', 'tax_adjustment_no', 'consignment_no');
    }
}
