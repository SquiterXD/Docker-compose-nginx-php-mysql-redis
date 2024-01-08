<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderStatusHistory extends Model
{
    use HasFactory;
    protected $table = 'PTOM_ORDER_HISTORY';
    public $primaryKey = 'order_history_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];

}