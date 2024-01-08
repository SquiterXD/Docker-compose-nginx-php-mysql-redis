<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderQuotaHistory extends Model
{
    use HasFactory;

    protected $table = 'oaom.ptom_order_quota_histories';
    public $primaryKey = 'order_quota_history_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
}
