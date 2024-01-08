<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutstandingDebtDomV extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_OUTSTANDING_DEBT_DOM_V';
    protected $primaryKey   = 'order_header_id';
}
