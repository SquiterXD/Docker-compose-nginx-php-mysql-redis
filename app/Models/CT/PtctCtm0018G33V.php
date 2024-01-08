<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctCtm0018G33V extends Model
{
    use HasFactory;
    protected $table = 'PTCT_CTM0018_G33_V';
    public $timestamps = false;

    protected $guarded = [];

    public static function getCtr0023ReportItems($periodYear, $planVersionNo, $versionNo, $costCode, $productItemNumberFrom, $productItemNumberTo) {

        $results = DB::select(
			"SELECT G32.PERIOD_YEAR					
            ,G32.PLAN_VERSION_NO					
            ,G32.VERSION_NO					
            ,G32.COST_CODE					
            ,G32.COST_DESC					
            ,G32.COST_QUANTITY					
            ,G32.UOM_DESC					
            ,G32.PRODUCT_GROUP					
            ,G32.PRODUCT_GROUP_DESC					
            ,G32.PRODUCT_ITEM_NUMBER					
            ,G32.PRODUCT_ITEM_DESC					                    
            ,G33.ITEM_NUMBER
            ,G33.ITEM_DESC
            ,G33.UOM_CODE
            ,G33.INVENTORY_ITEM_ID
            ,G33.ORGANIZATION_ID
            ,G33.WIP_STEP
            ,G33.PRDGRP_YEAR_ID
            ,G33.PRDGRP_YEAR_ID
            ,G33.YEAR_MAIN_ID				
            ,SUM(G33.QUANTITY_USED) AS QUANTITY_USED					
            ,G33.STD_COST_RATE					
            ,SUM(G33.STD_COST_AMOUNT) AS STD_COST_AMOUNT					
            ,ROUND(SUM(G33.STD_COST_AMOUNT / G32.COST_QUANTITY), 9) AS STD_COST_AMOUNT_PER_UNIT					
                                            
            , (SELECT DISTINCT VALUE_CATEGORY					
            FROM PTCT_ITEM_CATEGORY_CTR0023_V					
            WHERE INVENTORY_ITEM_ID (+) = G33.INVENTORY_ITEM_ID					
            ) ITEM_CATEGORY_NUMBER					
                                
            , (SELECT DISTINCT DESCRIPTION_CATE					
            FROM PTCT_ITEM_CATEGORY_CTR0023_V					
            WHERE INVENTORY_ITEM_ID (+) = G33.INVENTORY_ITEM_ID					
            ) ITEM_CATEGORY_DESC												
                                            
            FROM    PTCT_CTM0018_G32_V  G32, PTCT_CTM0018_G33_V  G33					
            WHERE   1=1					
                                
            AND G32.PERIOD_YEAR =   G33.PERIOD_YEAR					
            AND G32.PLAN_VERSION_NO =   G33.PLAN_VERSION_NO					
            AND G32.COST_CODE   =   G33.COST_CODE					
            AND G32.PRODUCT_ITEM_NUMBER =   G33.PRODUCT_ITEM_NUMBER					
            AND G32.PRDGRP_YEAR_ID  =   G33.PRDGRP_YEAR_ID					
            AND G32.YEAR_MAIN_ID    =   G33.YEAR_MAIN_ID					
                                
            AND G32.PERIOD_YEAR             = '" . $periodYear . "'
            AND G32.PLAN_VERSION_NO         = '" . $planVersionNo . "'
            AND G32.VERSION_NO              = '" . $versionNo . "'
            AND	G32.COST_CODE	            = '" . $costCode . "'	
            AND G32.PRODUCT_ITEM_NUMBER     BETWEEN '" . $productItemNumberFrom . "' AND '" . $productItemNumberTo . "'	
                                
            GROUP BY G32.PERIOD_YEAR					
            ,G32.PLAN_VERSION_NO					
            ,G32.VERSION_NO					
            ,G32.COST_CODE					
            ,G32.COST_DESC					
            ,G32.COST_QUANTITY					
            ,G32.UOM_DESC					
            ,G32.PRODUCT_GROUP					
            ,G32.PRODUCT_GROUP_DESC					
            ,G32.PRODUCT_ITEM_NUMBER					
            ,G32.PRODUCT_ITEM_DESC					
            ,G33.ITEM_NUMBER					
            ,G33.ITEM_DESC					
            ,G33.UOM_CODE					
            ,G33.STD_COST_RATE					
            ,G33.INVENTORY_ITEM_ID					
            ,G33.ORGANIZATION_ID					
            ,G33.WIP_STEP					
            ,G33.PRDGRP_YEAR_ID					
            ,G33.PRDGRP_YEAR_ID					
            ,G33.YEAR_MAIN_ID					
            ,G33.COST_CODE					
            ,G33.PLAN_VERSION_NO	

            ORDER BY G32.COST_CODE, G32.PRODUCT_GROUP, G32.PRODUCT_ITEM_NUMBER, G33.ITEM_NUMBER, ITEM_CATEGORY_NUMBER, G33.WIP_STEP
        ");

        return $results;

    }

}
