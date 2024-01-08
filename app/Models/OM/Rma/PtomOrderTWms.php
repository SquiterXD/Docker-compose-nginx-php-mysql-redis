<?php

namespace App\Models\OM\Rma;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomOrderTWms extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ORDER_T_WMS';
    protected $primaryKey = 'OAOM_WMS_ID';
    public $timestamps = false;
}
