<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinalItemLotV extends Model
{
    use HasFactory;

    protected $table = 'PTPD_MEDICINAL_ITEM_LOT_V';
    public $primaryKey = 'item_id';

    public $timestamps = false;
}
