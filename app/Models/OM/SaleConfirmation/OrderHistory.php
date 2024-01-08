<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'PTOM_ORDER_HISTORY';
    public $primaryKey = 'ORDER_HISTORY_ID';
    public $timestamps = false;
}
