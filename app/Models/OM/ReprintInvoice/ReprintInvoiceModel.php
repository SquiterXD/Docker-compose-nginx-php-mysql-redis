<?php

namespace App\Models\OM\ReprintInvoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReprintInvoiceModel extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_lines';
}
