<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use DB;

class PtpmItemNumberV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_item_number_v';
    public $timestamps = false;

    protected $fillable = [
    ];

    public function scopeGetListItems($query, $organizationId)
    {
        return $query->select(DB::raw("ptpm_item_number_v.inventory_item_id, ptpm_item_number_v.item_number, ptpm_item_number_v.item_desc, ptpm_item_number_v.item_number || ' : ' || ptpm_item_number_v.item_desc as full_item_desc, ptpm_item_number_v.primary_uom_code"))
            ->where('item_type', 'RM')
            ->where('organization_id', $organizationId)
            ->groupBy('inventory_item_id', 'item_number','item_desc', 'primary_uom_code')
            ->orderBy('item_number');
    }

    public function uom()
    {
        return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'uom_code', 'primary_uom_code');
    }

    public function scopeForM06andMPG($q, $orgCode = false)
    {

        // and     organization_code = 'MG6'
        // and     ITEM_TYPE = 'FG'
        // and     ITEM_CAT_SEGMENT1 = '15'
        // and     ITEM_CAT_SEGMENT2 not in '99'
        // order by ITEM_NUMBER
        return $q->where('item_type', 'FG')
            ->where('item_cat_segment1', '15')
            ->where('item_cat_segment2', '!=', '99')
            ->when($orgCode, function($q) use($orgCode) {
                $q->where('organization_code', $orgCode);
            })
            ->orderBy('item_number');
    }

    public function scopeForM05($q, $orgCode = false)
    {
        // select * from PTPM_ITEM_NUMBER_V
        // where   1=1
        // and     organization_code = 'M05'
        // and     ITEM_TYPE = 'SFG'
        // and     ITEM_CAT_CODE = '1008'
        // order by ITEM_NUMBER;
        return $q->where('item_type', 'SFG')
            ->where('item_cat_code', '1008')
            ->when($orgCode, function($q) use($orgCode) {
                $q->where('organization_code', $orgCode);
            })
            ->orderBy('item_number');
    }

    public function scopeGetListLeakBrands($query)
    {
        return $query->select(DB::raw("inventory_item_id as brand_value, item_desc as brand_label, inventory_item_id, item_number, item_desc, primary_uom_code, product_type_code as category_value, product_type as category_label, product_type_code, product_type"))
            ->where('organization_code', 'A00')
            ->whereIn('product_type_code',['71', '78'])
            ->whereIn('tobacco_group_code',['1501', '1502'])
            ->groupBy('inventory_item_id', 'item_number', 'item_desc', 'primary_uom_code', 'product_type_code', 'product_type')
            ->orderBy('item_desc');
    }

    public function scopeGetListLeakBrandCategories($query)
    {
        return $query->select(DB::raw("product_type_code as category_value, product_type as category_label, product_type_code, product_type"))
            ->where('organization_code', 'A00')
            ->whereIn('product_type_code',['71', '78'])
            ->whereIn('tobacco_group_code',['1501', '1502'])
            ->groupBy('product_type_code', 'product_type')
            ->orderBy('product_type');
    }

    public function scopeGetListCigBrands($query)
    {
        return $query->select(DB::raw("inventory_item_id as brand_value, item_desc as brand_label, inventory_item_id, item_number, item_desc, primary_uom_code, product_type_code as category_value, product_type as category_label, product_type_code, product_type"))
            ->where('organization_code', 'A00')
            ->whereIn('product_type_code',['71', '78'])
            ->whereIn('tobacco_group_code',['1501', '1502'])
            ->groupBy('inventory_item_id', 'item_number', 'item_desc', 'primary_uom_code', 'product_type_code', 'product_type')
            ->orderBy('item_desc');
    }
    
    public function scopeGetListCigBrandCategories($query)
    {
        return $query->select(DB::raw("product_type_code as category_value, product_type as category_label, product_type_code, product_type"))
            ->where('organization_code', 'A00')
            ->whereIn('product_type_code',['71', '78'])
            ->whereIn('tobacco_group_code',['1501', '1502'])
            ->groupBy('product_type_code', 'product_type')
            ->orderBy('product_type');
    }

}
