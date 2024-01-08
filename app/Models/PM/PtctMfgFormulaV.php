<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\MtlSystemItemB;
use App\Models\PM\PtpmSummaryBatchV;
use App\Models\PM\PtctItemTaxV;

class PtctMfgFormulaV extends Model
{
    use HasFactory;
    protected $table = 'ptct_mfg_formula_v';
    protected $appends = [
        'group_line'
    ];


    public function uom()
    {
        return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'uom_code', 'detail_uom');
    }

    public function setupMfgDeptVLByUserOrg()
    {
        return $this->belongsTo(\App\Models\PM\PtpmSetupMfgDepartmentsV::class, 'tobacco_group_code', 'tobacco_group_code')
                    ->where('organization_id' ,auth()->user()->organization_id)
                    ->where('wip_transaction_type_name', 'WIP Issue')
                    ->where('enable_flag' , 'Y')
                    ->where('end_date' , null);
    }

    public function setupMfgDeptVLByMultiUserOrg()
    {
        return $this->hasMany(\App\Models\PM\PtpmSetupMfgDepartmentsV::class, 'tobacco_group_code', 'tobacco_group_code')
                    ->where('organization_id' ,auth()->user()->organization_id)
                    ->where('wip_transaction_type_name', 'WIP Issue');
    }

    public function invOnhands()
    {

        return $this->hasMany(\App\Models\PM\Lookup\PtinvOnhandQuantitiesV::class, 'item_number', 'item_number')
                    ->getLotNumber( $this->setupMfgDeptVLByUserOrg->from_organization_id,
                            $this->setupMfgDeptVLByUserOrg->from_locator_id,
                            $this->inventory_item_id);
    }

    public function invOnhand()
    {
        return $this->belongsTo(\App\Models\PM\Lookup\PtinvOnhandQuantitiesV::class, 'item_number', 'item_number');
    }

    public function scopeIsApproved($q)
    {
        return $q->where('recipe_status', 700);
    }

    public function scopeOnhandByInvItemId($q, $invItemId)
    {
        return $q->whereHas('setupMfgDeptVLByUserOrg', function($mfg) use ($invItemId) {
            $mfg->whereHas('invOnhand', function($onHand) use ($invItemId){
                $onHand->where('inventory_item_id', $invItemId);
            });
        });
    }

    public function getOnhand()
    {
        $profile =  getDefaultData(\Request::path());
        if (!$this->setupMfgDeptVLByUserOrg) {
            return [];
        }

        if ($profile->organization_code == 'M12' ) {
            return $this->getOnhandMultiLocator();
        }

        $onhand =   PtinvOnhandQuantitiesV::where('organization_id', $this->setupMfgDeptVLByUserOrg->from_organization_id)
                                        ->where('locator_id', $this->setupMfgDeptVLByUserOrg->from_locator_id)
                                        ->where('inventory_item_id', $this->inventory_item_id)
                                        ->where('lot_number','!=', '2021040901')
                                        ->orderBy('origination_date')
                                        ->get();

        return $onhand ;

    }

    public function getOnhandMultiLocator()
    {

        $itemType =  $this->mtlSystemItem->item_type;

        $mfg          = $this->setupMfgDeptVLByMultiUserOrg
                                ->where('inv_item_type', $itemType);
        if(!$mfg->first()){
            return [];
        }
        $onhand =   PtinvOnhandQuantitiesV::where('organization_id', $mfg->first()->from_organization_id)
                                        ->where('locator_id', $mfg->first()->from_locator_id)
                                        ->where('inventory_item_id', $this->inventory_item_id)
                                        ->where('lot_number','!=', '2021040901')
                                        ->orderBy('origination_date')
                                        ->get();

        return $onhand ;

    }


    public function itemConvUom()
    {
        $con = PtpmItemConvUomV::where('inventory_item_id', $this->inventory_item_id)
                ->where('organization_id', auth()->user()->organization_id)
                ->where('from_uom_code', $this->detail_uom)
                ->where('to_uom_code', 'KG')
                ->first();

        return $con;
    }

    public function mtlSystemItem()
    {
        return $this->belongsTo(MtlSystemItemB::class, 'item_number', 'segment1')
                ->where('organization_id', auth()->user()->organization_id);
    }

    public function summaryBatch1V()
    {
        return $this->hasMany(PtpmSummaryBatchV::class, 'formula_id' , 'formula_id');
    }

    public function taxItem()
    {
        return $this->belongsTo(PtctMfgFormulaV::class, 'reference_item_number' , 'item_number')
                ->where('recipe_id', $this->recipe_id)
                ->where('recipe_version', $this->recipe_version)
                ->where('product_item_number' , $this->product_item_number)
                ->where('organization_code', $this->organization_code)
                ->where('item_classification_code', $this->item_classification_code);
    }

    public function childTax()
    {
        return $this->hasOne(PtctMfgFormulaV::class, 'reference_item_number' , 'item_number')
                ->where('product_item_number' , $this->product_item_number)
                ->where('organization_code', $this->organization_code)
                ->where('item_classification_code', $this->item_classification_code);

    }

    public function getGroupLineAttribute()
    {
        if ($this->tobacco_ingrident_type == 'CASING') {
            // dd();
            // dd(strlen(preg_replace('/[^0-9.]+/', '',$this->casting_flavor_name)) == 2);
            if(strlen(preg_replace('/[^0-9.]+/', '',$this->casting_flavor_name)) == 2){
                $castingFlavorName =  preg_replace('/[^0-9.]+/', '',$this->casting_flavor_name);
            }else {
                $castingFlavorName =  sprintf("%02d", preg_replace('/[^0-9.]+/', '',$this->casting_flavor_name));
            }
            // $casing = 
            return $this->used_leaf_formula.'_'.$castingFlavorName.'_'.$this->item_number.'_'.$this->formulaline_id;                                   
        }

        if($this->tobacco_ingrident_type == 'FLAVOR'){
            return $this->casting_flavor_name.'_'.$this->item_number.'_'.$this->formulaline_id;
        }

        if($this->tobacco_ingrident_type == null){
            return $this->leaf_fomula;
        }

        return $this->formulaline_id;
    }
}
