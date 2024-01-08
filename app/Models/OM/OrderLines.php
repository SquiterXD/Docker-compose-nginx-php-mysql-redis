<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLines extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_ORDER_LINES';
    protected $primaryKey   = 'order_line_id';
}
