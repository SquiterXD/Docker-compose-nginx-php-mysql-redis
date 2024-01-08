<?php

namespace App\Models\OM;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // use HasFactory;
    protected $table = 'ptom_order_headers';
    public $primaryKey = 'order_header_id';
    public $timestamps = false;

}