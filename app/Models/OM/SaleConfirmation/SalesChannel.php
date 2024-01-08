<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesChannel extends Model
{
    use HasFactory;

    protected $table = 'PTOM_SALES_CHANNEL_V';
    public $primaryKey = 'LOOKUP_CODE';
    public $timestamps = false;


}
