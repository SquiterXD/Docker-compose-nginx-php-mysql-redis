<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\MtlSystemItemB;
use App\Models\PM\PtpmSummaryBatchV;

use DB;

class PtpmMfgFormulaV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_MFG_FORMULA_V';
    public $timestamps = false;

    protected $fillable = [
    ];

    public static function getListPlanInventoryItems()
    {
        // return DB::table('PTPM_MFG_FORMULA_V')
            // ->select(DB::raw("inventory_item_id,item_number,item_desc,detail_uom,item_cat_segment1 || '-' || item_cat_segment2 as item_cat"))
            // ->whereRaw('inventory_item_id not in (select product_item_id from PTPM_MFG_FORMULA_V)')
            // ->groupBy('inventory_item_id','item_number','item_desc','detail_uom','item_cat_segment1','item_cat_segment2')
            // ->orderBy('inventory_item_id');

        return DB::table('ptpm_mfg_formula_v')
            ->join('mtl_system_items_b', 'ptpm_mfg_formula_v.inventory_item_id', '=', 'mtl_system_items_b.inventory_item_id')
            ->select(DB::raw("ptpm_mfg_formula_v.inventory_item_id,ptpm_mfg_formula_v.item_number,ptpm_mfg_formula_v.item_desc, mtl_system_items_b.primary_uom_code"))
            ->whereRaw('ptpm_mfg_formula_v.inventory_item_id not in (select product_item_id from ptpm_mfg_formula_v)')
            ->groupBy('ptpm_mfg_formula_v.inventory_item_id','ptpm_mfg_formula_v.item_number','ptpm_mfg_formula_v.item_desc','mtl_system_items_b.primary_uom_code')
            ->orderBy('ptpm_mfg_formula_v.inventory_item_id');
    }

    // SELECT DISTINCT f.inventory_item_id, f.item_number, f.item_desc, msi.PRIMARY_UOM_CODE
    // FROM PTPM_MFG_FORMULA_V F, mtl_system_items_b msi
    // WHERE F.inventory_item_id NOT IN (SELECT  product_item_id FROM PTPM_MFG_FORMULA_V)
    // and F.inventory_item_id = msi.inventory_item_id

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

    public function scopeJoinSetupMfgDept($q, $departmentCode, $case = 1)
    {
        // case 1 = แจม, 2 ของแบงค์
        $columns = "
            inventory_item_id || '-' || default_lot_no || '-' || tobacco_ingrident_type group_key,
            inventory_item_id,
            product_item_id,
            product_item_number,
            item_number,
            item_desc,
            detail_uom,
            tobacco_group_code,
            item_classification_code,
            tobacco_type_code,
            default_lot_no,
            organization_id,
            sum(require_qty) as require_qty,
            sum(ratio_require_per_unit) as ratio_require_per_unit,
            product_detail_uom,
            tobacco_ingrident_type,
            oprn_no as work_step,
            '' as from_organization_id,
            '' as from_subinventory,
            '' as from_locator_id,
            recipe_version
        ";
        $groupBy = "
            inventory_item_id || '-' || default_lot_no || '-' || tobacco_ingrident_type,
            inventory_item_id,
            product_item_id,
            product_item_number,
            item_number,
            item_desc,
            detail_uom,
            tobacco_group_code,
            item_classification_code,
            tobacco_type_code,
            default_lot_no,
            organization_id,
            --require_qty,
            --ratio_require_per_unit,
            product_detail_uom,
            tobacco_ingrident_type,
            oprn_no,
            recipe_version
        ";

        if ($case == 2) {
            $columns = "
                inventory_item_id  group_key,
                inventory_item_id,
                product_item_id,
                product_item_number,
                item_number,
                item_desc,
                detail_uom,
                tobacco_group_code,
                item_classification_code,
                tobacco_type_code,
                '' default_lot_no,
                --default_lot_no,
                organization_id,
                max(require_qty) as require_qty,
                max(ratio_require_per_unit) as ratio_require_per_unit,
                product_detail_uom,
                tobacco_ingrident_type,
                oprn_no as work_step,
                '' as from_organization_id,
                '' as from_subinventory,
                '' as from_locator_id,
                recipe_version
            ";

            $groupBy = "
                inventory_item_id,
                inventory_item_id,
                product_item_id,
                product_item_number,
                item_number,
                item_desc,
                detail_uom,
                tobacco_group_code,
                item_classification_code,
                tobacco_type_code,
                --default_lot_no,
                organization_id,
                --require_qty,
                --ratio_require_per_unit,
                product_detail_uom,
                tobacco_ingrident_type,
                oprn_no,
                recipe_version
            ";
        }

        return $q->selectRaw($columns)->groupByRaw($groupBy)->orderBy('item_number');

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

    public function scopeGetListIngredientGroups($query, $organizationId)
    {
        return $query->select(DB::raw("item_classification_code as value, item_classification as description, item_classification_code, item_classification, organization_id, organization_code"))
            ->where('organization_id', $organizationId)
            ->whereNotNull('item_classification_code')
            ->groupBy('item_classification_code', 'item_classification','organization_id', 'organization_code')
            ->orderBy('item_classification');
    }

    public function summaryBatch1V()
    {
        return $this->hasMany(PtpmSummaryBatchV::class, 'formula_id' , 'formula_id');
    }

}
