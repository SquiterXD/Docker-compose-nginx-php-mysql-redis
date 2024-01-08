<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCreditGroup extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_credit_groups';
    public $primaryKey = 'order_credit_group_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
}