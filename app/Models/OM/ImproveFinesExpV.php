<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImproveFinesExpV extends Model
{
    use HasFactory;

    protected $table = "ptom_improve_fines_exp_v";

    public function scopeSearch($q, $dataSearch)
    {  
        // dd($dataSearch);
        $orderNumber = $dataSearch->order_number;
        $saNumber = $dataSearch->sa_number;
        $piNumber = $dataSearch->pi_number;
        $dueDate = $dataSearch->due_date;
        $invoiceNo = $dataSearch->invoice_no;
        $customerID = $dataSearch->customer_id;

        // dd($dataSearch, $dueDate);
        
        return $q->when($orderNumber, function($q) use($orderNumber) {
            $q->where('order_number', $orderNumber);
        })->when($saNumber, function($q) use($saNumber) {
            $q->where('sa_number', $saNumber);
        })->when($piNumber, function($q) use($piNumber) {
            $q->where('pi_number', $piNumber);
        })->when($dueDate, function($q) use($dueDate) {
            // dd($dueDate, date("Y-m-d", strtotime($dueDate)));
            $q->where('due_date', date("Y-m-d", strtotime($dueDate)));
        })->when($invoiceNo, function($q) use($invoiceNo) {
            $q->where('pick_release_no', $invoiceNo);
        })->when($customerID, function($q) use($customerID) {
            $q->where('customer_id', $customerID);
        });
    }
}
