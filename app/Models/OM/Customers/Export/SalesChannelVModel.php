<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesChannelVModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_SALES_CHANNEL_V";
    public $timestamps = false;
}
