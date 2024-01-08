<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinalLeafTypeHV extends Model
{
    use HasFactory;

    protected $table = 'PTPD_MEDICINAL_LEAF_TYPE_H_V';
    public $primaryKey = 'id_flex_structure_name';

    public $timestamps = false;
}
