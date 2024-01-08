<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinalLeafItemV extends Model
{
    use HasFactory;

    // protected $table = 'PTPD_MEDICINAL_LEAF_ITEM_V';
    protected $table = 'PTPD16_MEDICINAL_LEAF_H_ITEM_V';

    public $timestamps = false;
}
