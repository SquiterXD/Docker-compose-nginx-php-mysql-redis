<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomOrderHeader extends Model
{
    use HasFactory;
    protected $table = "ptom_order_headers";
    public $primaryKey = 'order_header_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
