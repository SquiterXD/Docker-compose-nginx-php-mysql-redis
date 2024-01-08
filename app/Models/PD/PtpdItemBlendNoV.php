<?php
namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PtpdItemBlendNoV extends Model
{
    use HasFactory;

    protected $table = 'PTPD_ITEM_BLEND_NO_V';

    public function uomDetail()
    {
        // return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'uom_code', 'uom');
        return $this->hasOne(\App\Models\PM\PtInvUomV::class, 'uom_code', 'uom');
    }
}
