<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomOrderCreditGroup extends Model
{
    use HasFactory;
    protected $table = "ptom_order_credit_groups";
    public $primaryKey = 'order_group_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
