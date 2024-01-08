<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ORDER_LINES';
    public $primaryKey = 'ORDER_LINE_ID';
    public $timestamps = false;

    protected $fillable = ['order_header_id'];


}
