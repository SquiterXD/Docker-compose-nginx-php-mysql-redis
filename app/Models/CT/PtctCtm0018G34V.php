<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctCtm0018G34V extends Model
{
    use HasFactory;
    protected $table = 'PTCT_CTM0018_G34_V';
    public $timestamps = false;

    protected $guarded = [];

    public static function getCtr0024ReportItems($periodYear, $planVersionNo, $versionNo, $costCodeFrom, $costCodeTo) {

        $results = DB::select(
			"SELECT G34.PERIOD_YEAR,
            G34.PLAN_VERSION_NO,
            G34.CT14_VERSION_NO,
            G34.COST_CODE,
            G34.COST_DESC,
            G34.COST_QUANTITY,
            G34.UOM_DESC,
            G34.PRODUCT_GROUP,
            G34.PRODUCT_GROUP_DESC,
            G34.PRODUCT_ITEM_NUMBER,
            G34.PRODUCT_ITEM_DESC,
            SUM (ROUND(G34.QUANTITY_USED,9))     SUM_QUANTITY_USED,
            SUM (ROUND(G34.STD_COST_RATE,9))     SUM_STD_COST_RATE,
            SUM (ROUND(G34.STD_COST_AMOUNT,9))   SUM_STD_COST_AMOUNT,
            G34.VALUE_CATEGORY AS ITEM_CATEGORY_NUMBER,
            G34.DESCRIPTION_CATE AS ITEM_CATEGORY_DESC,
            G34.START_DATE_THAI,
            G34.END_DATE_THAI,
            G32.WAGE_COST,
            G32.VARY_COST,
            G32.FIXED_COST,
            G32.TOTAL_COST
                        
            FROM PTCT_CTM0018_G34_V    G34, PTCT_CTM0018_G32_V  G32
            WHERE 1=1
            AND G34.PERIOD_YEAR         = '" . $periodYear . "'
            AND G34.PLAN_VERSION_NO     = '" . $planVersionNo . "'
            AND G34.CT14_VERSION_NO     = '" . $versionNo . "'
            AND G34.COST_CODE           >= '" . $costCodeFrom . "'
            AND G34.COST_CODE           <= '" . $costCodeTo . "'
            AND G34.PERIOD_YEAR         = G32.PERIOD_YEAR
            AND G34.PLAN_VERSION_NO     = G32.PLAN_VERSION_NO
            AND G34.CT14_VERSION_NO          = G32.CT14_VERSION_NO
            AND G34.COST_CODE           = G32.COST_CODE
            AND G34.PRODUCT_GROUP       = G32.PRODUCT_GROUP
            AND G34.PRODUCT_ITEM_NUMBER = G32.PRODUCT_ITEM_NUMBER
                             
            GROUP BY G34.PERIOD_YEAR, 
                G34.PLAN_VERSION_NO, 
                G34.CT14_VERSION_NO,
                G34.COST_CODE, 
                G34.COST_DESC, 
                G34.COST_QUANTITY, 
                G34.UOM_DESC, 
                G34.PRODUCT_GROUP, 
                G34.PRODUCT_GROUP_DESC, 
                G34.PRODUCT_ITEM_NUMBER, 
                G34.PRODUCT_ITEM_DESC, 
                G34.VALUE_CATEGORY,
                G34.DESCRIPTION_CATE, 
                G34.START_DATE_THAI, 
                G34.END_DATE_THAI, 
                G32.WAGE_COST, 
                G32.VARY_COST, 
                G32.FIXED_COST, 
                G32.TOTAL_COST 
            ORDER BY G34.COST_CODE,G34.PRODUCT_GROUP,G34.PRODUCT_ITEM_NUMBER,G34.VALUE_CATEGORY"
        );

        return $results;

    }

}
