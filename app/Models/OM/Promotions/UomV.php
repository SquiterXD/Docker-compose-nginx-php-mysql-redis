<?php

namespace App\Models\OM\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UomV extends Model
{
    use HasFactory;
    protected $table = "PTOM_UOM_V";
    public $primaryKey = 'uom_id';
    public $timestamps = false;
}
