<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctCtm0018G32V extends Model
{
    use HasFactory;
    protected $table = 'PTCT_CTM0018_G32_V';
    public $timestamps = false;

    protected $guarded = [];

    public static function getCtr0026ReportItems($periodYear, $planVersionNo, $versionNo, $costCodeFrom, $costCodeTo) {

        $results = DB::select("
            SELECT G32.PERIOD_YEAR,						
            G32.PLAN_VERSION_NO,						
            G32.VERSION_NO,
            G32.CT14_VERSION_NO,						
            G32.COST_CODE,						
            G32.COST_DESC,						
            G32.PRODUCT_GROUP,						
            G32.PRODUCT_GROUP_DESC,						
                                    
            DECODE (CC.COST_GROUP_CODE,						
            'B', G32.COST_QUANTITY /G32.COST_QUANTITY ,						
            G32.COST_QUANTITY) COST_QUANTITY,
            
            G32.UOM_DESC,						
            G32.PRODUCT_ITEM_NUMBER,						
            G32.PRODUCT_ITEM_DESC,						
            G32.APPROVED_STATUS,
            CC.COST_GROUP_CODE, 
            
            DECODE (CC.COST_GROUP_CODE,						
            'B', G32.COST_RAW_MATE /G32.COST_QUANTITY ,						
            G32.COST_RAW_MATE ) COST_RAW_MATE, 
            
            DECODE (CC.COST_GROUP_CODE,						
            'B', G32.WAGE_COST /G32.COST_QUANTITY ,						
            G32.WAGE_COST ) WAGE_COST,
            
            DECODE (CC.COST_GROUP_CODE,						
            'B', G32.VARY_COST /G32.COST_QUANTITY ,						
            G32.VARY_COST ) VARY_COST,
            
            DECODE (CC.COST_GROUP_CODE,						
            'B', G32.FIXED_COST /G32.COST_QUANTITY ,						
            G32.FIXED_COST ) FIXED_COST,
            
            DECODE (CC.COST_GROUP_CODE,						
            'B', G32.TOTAL_COST /G32.COST_QUANTITY ,						
            G32.TOTAL_COST ) TOTAL_COST
            
            -- G32.TOTAL_COST_PER_UNIT						
            ,DECODE (G32.cost_code,'13', G32.total_cost ,round(G32.total_cost_per_unit,9) ) TOTAL_COST_PER_UNIT

            FROM PTCT_CTM0018_G32_V G32, 
            PTCT_COST_CENTER_V  CC						
            WHERE 1=1						
            AND G32.COST_CODE  =  CC.COST_CODE
            AND G32.PERIOD_YEAR             = '" . $periodYear . "'
            AND G32.PLAN_VERSION_NO         = '" . $planVersionNo . "'
            AND G32.CT14_VERSION_NO         = '" . $versionNo . "'	
            AND G32.COST_CODE               >= '" . $costCodeFrom . "'
            AND G32.COST_CODE               <= '" . $costCodeTo . "'

            ORDER BY G32.COST_CODE ,G32.PRODUCT_GROUP ,G32.PRODUCT_ITEM_NUMBER

        ");

        return $results;

    }

}
