<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class MtlItemCategory extends Model
{
    use HasFactory;

    protected $table = 'MTL_ITEM_CATEGORIES';
    public $timestamps = false;

    protected $guarded = [];

    public static function getListItemCategories($organizationIds, $inventoryItemIds) {

        $results = DB::select(
			"SELECT	DISTINCT MIC.ORGANIZATION_ID, MIC.INVENTORY_ITEM_ID, FFV.FLEX_VALUE_MEANING AS ITEM_CATEGORY_NUMBER, FFV.DESCRIPTION AS ITEM_CATEGORY_DESC
            FROM	APPS.MTL_ITEM_CATEGORIES	MIC	,			
            APPS.MTL_CATEGORY_SETS_VL	MCS,					
            APPS.MTL_CATEGORIES	MC,					
            APPS.FND_FLEX_VALUE_SETS	FFVS,					
            APPS.FND_FLEX_VALUES_VL	FFV					
            WHERE	1=1					
            AND	MIC.CATEGORY_SET_ID	=	MCS.CATEGORY_SET_ID			
            AND	MIC.CATEGORY_ID	=	MC.CATEGORY_ID			
            AND	FFVS.FLEX_VALUE_SET_NAME	IN	('TOAT_INV_ITEM_CATEGORIES_TOAT4-SEGMENT1','TOAT_INV_ITEM_CATEGORIES_TOAT2-SEGMENT1')			
            AND	FFVS.FLEX_VALUE_SET_ID	=	FFV.FLEX_VALUE_SET_ID			
            AND	FFV.FLEX_VALUE	=	MC.SEGMENT1			
            AND	FFV.ENABLED_FLAG	=	'Y'
            AND MIC.ORGANIZATION_ID IN (". implode(",", $organizationIds) . ")
            AND MIC.INVENTORY_ITEM_ID IN (". implode(",", $inventoryItemIds). ")
            ORDER BY MIC.ORGANIZATION_ID, MIC.INVENTORY_ITEM_ID"
		);

        return $results;

    }

}