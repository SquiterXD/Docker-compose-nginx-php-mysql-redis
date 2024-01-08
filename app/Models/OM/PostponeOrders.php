<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostponeOrders extends Model
{
    use HasFactory;
    protected $table = "PTOM_POSTPONE_ORDERS";
    public $primaryKey = 'postpone_order_id';
    public $timestamps = false;
}
