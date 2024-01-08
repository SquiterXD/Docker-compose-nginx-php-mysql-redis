<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinalLeafLV extends Model
{
    use HasFactory;

    protected $table = 'PTPD_MEDICINAL_LEAF_L_V';
    public $primaryKey = false;
    public $timestamps = false;
}
