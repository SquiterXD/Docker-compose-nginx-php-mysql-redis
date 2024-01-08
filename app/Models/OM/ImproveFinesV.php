<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImproveFinesV extends Model
{
    use HasFactory;

    protected $table = "ptom_improve_fines_v";

    public function scopeSearch($q, $customerID, $dueDate, $invoiceNo, $invoiceDate)
    {  
        return $q->when($customerID, function($q) use($customerID) {
            $q->where('customer_id', $customerID);
        })->when($dueDate, function($q) use($dueDate) {
            $q->where('due_date', $dueDate);
        })->when($invoiceNo, function($q) use($invoiceNo) {
            $q->where('pick_release_no', $invoiceNo)
              ->orWhere('consignment_no', $invoiceNo);
        })->when($invoiceDate, function($q) use($invoiceDate) {
            $q->whereRaw(" trunc(pick_release_approve_date) = '{$invoiceDate}' ")
                    ->orWhereRaw(" trunc(consignment_date) = '{$invoiceDate}' ");
;
            // $q->where('pick_release_approve_date', $invoiceDate)
            //   ->orWhere('consignment_date', $invoiceDate);
        });
    }
}
