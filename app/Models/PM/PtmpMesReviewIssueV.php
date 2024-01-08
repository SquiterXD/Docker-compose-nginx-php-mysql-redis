<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtpmManufactureStep;
use App\Models\PM\MtlUnitsOfMeasureTl;
use App\Models\PM\MtlSystemItemB;



class PtmpMesReviewIssueV extends Model
{
    use HasFactory;
    protected $table = 'PTPM_MES_REVIEW_ISSUE_V';
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
        return  $q->when($profile->organization_code  == 'M02', function($q) {
            $q->where('wip_step', 'WIP01')
            ->where('wip_status', 2)
            ->where('mes_job_status', "Y");
            // ->where('issue_item_class_01_flag', null);
        })
        ->when($profile->organization_code  == 'M03', function($q) {
            $q->whereIn('wip_step', ['WIP03', 'WIP02'])
            ->where('wip_status', 2)
            ->where('mes_job_status', "Y");
            // ->where('issue_item_class_02_flag', null);
        })
        ->when($profile->organization_code  == 'MP2', function($q) {
            $q->whereRaw("(batch_no , organization_id) in (select ptp.batch_no , ptp.organization_id from ptpm_summary_batch_v ptp 
                             where ptp.batch_status_code ='2')");
        })
        ->when($programCode == 'PMP0051' || $programCode == 'PMP0049', function($q) {
            $q->where('wip_step_flag', null);
        });
    }

    public function scopeHasStampItem($q)
    {
        $q->whereRaw("
            EXISTS (
                   select  'Y'
                   from    Ptct_Mfg_Formula_V mfv
                   where   1=1
                   and     mfv.organization_id = PTPM_MES_REVIEW_ISSUE_V.organization_id
                   and     mfv.product_item_id = PTPM_MES_REVIEW_ISSUE_V.inventory_item_id
                   and     mfv.recipe_status = 700
                   and     mfv.receipe_type_code = 1
                   and     mfv.oprn_code = PTPM_MES_REVIEW_ISSUE_V.wip_step
                   and     mfv.item_cat_code = '1013' -- แสตมป์
                   /*and     recipe_version = (
                            select  max(mfv2.recipe_version)
                            from    Ptct_Mfg_Formula_V mfv2
                            where   1=1
                            and     mfv.organization_id = mfv2.organization_id
                            and     mfv.product_item_id = mfv2.product_item_id
                            and     mfv.recipe_status = mfv2.recipe_status
                            and     mfv.oprn_code = mfv2.oprn_code
                            and     mfv.item_cat_code = mfv2.item_cat_code
                            and     mfv.receipe_type_code = mfv2.receipe_type_code
                    )*/
            )
        ");
        return $q;
    }

    public function scopeNotHasStampItem($q)
    {
        $q->whereRaw("
            NOT EXISTS (
                   select  'Y'
                   from    Ptct_Mfg_Formula_V mfv
                   where   1=1
                   and     mfv.organization_id = PTPM_MES_REVIEW_ISSUE_V.organization_id
                   and     mfv.product_item_id = PTPM_MES_REVIEW_ISSUE_V.inventory_item_id
                   and     mfv.recipe_status = 700
                   and     mfv.receipe_type_code = 1
                   and     mfv.oprn_code = PTPM_MES_REVIEW_ISSUE_V.wip_step
                   and     mfv.item_cat_code = '1013' -- แสตมป์
                   /*and     recipe_version = (
                            select  max(mfv2.recipe_version)
                            from    Ptct_Mfg_Formula_V mfv2
                            where   1=1
                            and     mfv.organization_id = mfv2.organization_id
                            and     mfv.product_item_id = mfv2.product_item_id
                            and     mfv.recipe_status = mfv2.recipe_status
                            and     mfv.oprn_code = mfv2.oprn_code
                            and     mfv.item_cat_code = mfv2.item_cat_code
                            and     mfv.receipe_type_code = mfv2.receipe_type_code
                    )*/
            )
        ");
        return $q;
    }

}
