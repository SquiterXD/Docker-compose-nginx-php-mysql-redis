<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PM\Lookup\PMItemNumberV;
use App\Models\PD\Lookup\MtlUnitsOfMeasureVl;

class PtmpProductPlanLine extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRODUCT_PLAN_L';
    protected $primaryKey = 'plan_line_id';
    protected $appends = ['uom_ptn',  'uom_kg', 'input'];

    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function itemNumberV()
    {
        return $this->belongsTo(PMItemNumberV:: class, 'inventory_item_id', 'inventory_item_id')
                ->where('organization_id', auth()->user()->organization_id);
    }

    public function mtlUom()
    {
        return $this->belongsTo(MtlUnitsOfMeasureVl::class, 'uom', 'uom_code');
    }

    public function getUomPtnAttribute()
    {
        return MtlUnitsOfMeasureVl::where('uom_code', 'PTN')->first();
    }
    public function getUomKgAttribute()
    {
        return MtlUnitsOfMeasureVl::where('uom_code', 'KG')->first();
    }
    public function getInputAttribute()
    {
        return null;
    }
}
