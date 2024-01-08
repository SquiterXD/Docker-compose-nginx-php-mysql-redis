<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmQtmConfirmStatusV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_QTM_CONFIRM_STATUS_V';

    public function scopeGetListConfirmStatuses($query)
    {
        return $query->select('confirm_code', 'confirm_status')
        ->orderBy('confirm_code');
    }

}
