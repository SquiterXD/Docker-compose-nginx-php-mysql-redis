<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproverOrder extends Model
{
    use HasFactory;

    protected $table = 'ptom_approver_orders';
    public $primaryKey = 'approver_order_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
}
