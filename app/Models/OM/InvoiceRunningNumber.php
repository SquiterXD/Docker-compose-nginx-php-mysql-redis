<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;

class InvoiceRunningNumber extends Model
{
    protected $table = 'ptom_invoice_running_number';
    public $primaryKey = 'invoice_running_number_id';
}
