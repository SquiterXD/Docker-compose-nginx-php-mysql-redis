<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class MtlSystemItemsB extends Model
{
    use HasFactory;

    protected $table = 'MTL_SYSTEM_ITEMS_B';
    public $timestamps = false;

    protected $fillable = [
    ];

    public static function getListPlanInventoryItems($organizationCode)
    {

        return DB::table('mtl_system_items_b')
            ->join('org_organization_definitions', 'org_organization_definitions.organization_id', '=', 'mtl_system_items_b.organization_id')
            ->select(DB::raw("mtl_system_items_b.inventory_item_id, mtl_system_items_b.segment1 as item_number, mtl_system_items_b.description as item_desc, mtl_system_items_b.segment1 || ' : ' || mtl_system_items_b.description as full_item_desc, mtl_system_items_b.primary_uom_code"))
            ->where('org_organization_definitions.organization_code', $organizationCode)
            ->groupBy('mtl_system_items_b.inventory_item_id','mtl_system_items_b.segment1','mtl_system_items_b.description','mtl_system_items_b.primary_uom_code')
            ->orderBy('mtl_system_items_b.inventory_item_id');
            
    }

    // SELECT DISTINCT msi.inventory_item_id, msi.segment1, msi.description, msi.primary_uom_code
    // FROM org_organization_definitions org, mtl_system_items_b msi
    // WHERE org.organization_id = msi.organization_id 
    // AND org.organization_code = 'M06'

}
