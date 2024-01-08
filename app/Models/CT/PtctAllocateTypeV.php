<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctAllocateTypeV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_ALLOCATE_TYPE_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListAllocateTypes($query)
    {
        return $query->select(DB::raw("allocate_type as allocate_type_value, description as allocate_type_label, allocate_type || ' : ' || description as allocate_type_full_label, allocate_type, meaning, description"))
            ->where('enabled_flag', 'Y')
            // ->orderBy('seq_no')
            ->orderBy('allocate_type');

    }

}
