<?php

namespace App\Models\Ptom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomOrderLot extends Model
{
    use HasFactory;
    protected $table = "ptom_order_lots";
    public $primaryKey = 'order_lot_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
