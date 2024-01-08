<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproveOrder extends Model
{
    use HasFactory;

    protected $table = 'PTOM_APPROVER_ORDERS';
    public $primaryKey = 'APPROVER_ORDER_ID';
    public $timestamps = false;


}
