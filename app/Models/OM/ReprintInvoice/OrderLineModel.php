<?php

namespace App\Models\OM\ReprintInvoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLineModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_ORDER_LINES";
}
