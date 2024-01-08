<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesChannelV extends Model
{
    use HasFactory;
    protected $table = "ptom_sales_channel_v";
    public $primaryKey = 'sales_channel_id';
    public $timestamps = false;
}