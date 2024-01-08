<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmpPmp00070And048V extends Model
{
    use HasFactory;
    protected $table = 'PTPM_PMP0007_0048_V';
    protected $appends = ['item_description'];

    public function formulaByInvItem()
    {
        return $this->belongsTo(PtpmMfgFormulaV::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function wipSteps()
    {
        return $this->hasMany(PtpmManufactureStep::class, 'wip_step', 'wip_step')
                ->where('owner_organization', auth()->user()->organization_id);
    }

    public function uom()
    {
        return $this->belongsTo(MtlUnitsOfMeasureTl::class, 'transaction_uom', 'uom_code');
    }

    public function mtlSystemItemB()
    {
        return $this->belongsTo(MtlSystemItemB::class, 'item_number', 'segment1')->where('organization_id', auth()->user()->organization_id);
    }

    public function getItemDescriptionAttribute()
    {
        if (!$this->mtlSystemItemB) {
            return "";
        }
        return $this->mtlSystemItemB->description;
    }

    public function scopeGetBlend($q, $profile, $programCode)
    {
        return  $q->when($profile->organization_code  == 'M02' && false, function($q) {
            $q->where('wip_step', 'WIP01')
            ->where('wip_status', 2)
            ->where('mes_job_status', "Y");
            // ->where('issue_item_class_01_flag', null);
        })
        ->when($profile->organization_code  == 'M03' && false, function($q) {
            $q->whereIn('wip_step', ['WIP03', 'WIP02'])
            ->where('wip_status', 2)
            ->where('mes_job_status', "Y");
            // ->where('issue_item_class_02_flag', null);
        })
        ->when($programCode == 'PMP0051' || $programCode == 'PMP0049', function($q) {
            $q->where('wip_step_flag', null);
        });
    }

}
