<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PD\PtpdEstimateMtSaleLine;

class PtpdEstimateMtSaleHeader extends Model
{
    use HasFactory;
    protected $table = 'PTPD_ESTIMATE_MT_SALE_H_T';
    protected $primaryKey = 'web_h_id';
        
    
    public function lines()
    {
        return $this->hasMany(PtpdEstimateMtSaleLine::class, 'web_h_id', 'web_h_id');
    }
}
