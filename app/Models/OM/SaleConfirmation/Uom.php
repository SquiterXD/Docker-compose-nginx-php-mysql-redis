<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use HasFactory;

    protected $table = 'PTOM_UOM_V';
    public $primaryKey = 'UOM_CODE';
    public $timestamps = false;


}
