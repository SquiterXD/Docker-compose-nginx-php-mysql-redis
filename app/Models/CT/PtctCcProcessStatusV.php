<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctCcProcessStatusV extends Model
{
    use HasFactory;
    protected $table = 'PTCT_CC_PROCESS_STATUS_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetStatuses($query)
    {
        return $query->where('enabled_flag','Y');
    }

}
