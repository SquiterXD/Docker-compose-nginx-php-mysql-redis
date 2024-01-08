<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomOrderQuotaHistory extends Model
{
    use HasFactory;
    protected $table = "OAOM.PTOM_ORDER_QUOTA_HISTORIES";
    public $primaryKey = 'order_quota_history_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
