<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PD\PtpdEstimateMtSaleHeader;

class PtpdEstimateMtSaleLine extends Model
{
    use HasFactory;
    protected $table = 'PTPD_ESTIMATE_MT_SALE_L_T';
    protected $primaryKey = 'web_l_id';

    public function header()
    {
        return $this->belongsTo(PtpdEstimateMtSaleHeader::class, 'web_l_id', 'web_h_id');
    }
}
