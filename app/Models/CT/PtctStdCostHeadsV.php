<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctStdCostHeadsV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_STD_COST_HEADS_V';
    public $timestamps = false;

    protected $guarded = [];

    public static function getCtr0023ReportItems($periodYear, $planVersionNo, $versionNo, $costCode, $productItemNumberFrom, $productItemNumberTo) {
      
        $results = DB::select(
            	" SELECT CTHH.PERIOD_YEAR
                ,CTHH.PLAN_VERSION_NO
                ,CTHH.VERSION_NO
                ,CTHH.COST_CODE
                ,CTHH.COST_DESCRIPTION   COST_DESC
                ,CTHH.QUANTITY   COST_QUANTITY_CAL
                , CASE when pcc.cost_group_code ='B'  then to_char(CTHH.QUANTITY )
                else to_char(PL1.quantity_prd)
                end   COST_QUANTITY
                , CASE when pcc.cost_group_code ='B'  then CTHH.UOM_CODE||' '||(SELECT UNIT_OF_MEASURE
                FROM INV.MTL_UNITS_OF_MEASURE_TL UOM
                WHERE 1 = 1 AND PL1.uom_code_prd  = UOM.UOM_CODE)

                else PL1.uom_code_prd || ' ' ||
                (SELECT UNIT_OF_MEASURE
                FROM INV.MTL_UNITS_OF_MEASURE_TL UOM
                WHERE 1 = 1 AND PL1.uom_code_prd  = UOM.UOM_CODE) end  UOM_Desc
                                    
                ,CTH.PRODUCT_GROUP
                ,CTH.PRODUCT_GROUP_NAME      PRODUCT_GROUP_DESC
                ,CTH.PRODUCT_ITEM_NUMBER
                ,CTH.PRODUCT_ITEM_DESC
                ,CTL.ITEM_NUMBER
                ,CTL.ITEM_DESC
                ,CTL.UOM_CODE    || ' ' ||                       
                    (SELECT UNIT_OF_MEASURE                         
                    FROM INV.MTL_UNITS_OF_MEASURE_TL UOM                            
                    WHERE 1 = 1 AND CTL.UOM_CODE  = UOM.UOM_CODE) UOM_CODE    
                                    
                ,round ((sum(CTL.QUANTITY_USED )*   NVL( PL1.ratio ,1) / CASE WHEN CTHH.QUANTITY = PL1.quantity_prd   THEN '1' ELSE   CTHH.QUANTITY   END  ),9)
                    * (case when pcc.cost_group_code='B' then to_number(CTHH.QUANTITY)
                    else 1
                    end )  QUANTITY_USED
                ,CTL.unit_std_cost           STD_COST_RATE
                ,round ((sum(CTL.cost_raw_mate)*   NVL( PL1.ratio ,1) / CASE WHEN CTHH.QUANTITY = PL1.quantity_prd   THEN '1' ELSE   CTHH.QUANTITY   END  ),9)	
* (case when pcc.cost_group_code='B' then to_number(CTHH.QUANTITY)	
else 1	
end ) STD_COST_AMOUNT	
,ROUND ( sum(CTL.cost_raw_mate * NVL( PL1.ratio ,1) /  CASE WHEN CTHH.QUANTITY = PL1.quantity_prd   THEN '1' ELSE   CTHH.QUANTITY   END     ),9)	
* (case when pcc.cost_group_code='B' then to_number(CTHH.QUANTITY)	
else 1	
end ) STD_COST_AMOUNT_PER_UNIT	
                ,pl1.quantity_prd
                ,pl1.uom_code_prd   || ' ' || (SELECT UNIT_OF_MEASURE
                                                FROM INV.MTL_UNITS_OF_MEASURE_TL UOM
                                                WHERE 1 = 1 AND pl1.uom_code_prd  = UOM.UOM_CODE) UOM_PRD
                ,round ((sum(CTL.cost_raw_mate )*   NVL( PL1.ratio ,1) )* CASE WHEN CTHH.QUANTITY <> PL1.quantity_prd   THEN '1'
ELSE   CTHH.QUANTITY   END ,9) / (CASE WHEN  PL1.quantity_prd <> '1'  THEN CTHH.QUANTITY    ELSE  '1' end  ) STD_COST_AMOUNT_PRD            
                ------------------------
                                    
                , (SELECT DISTINCT VALUE_CATEGORY
                FROM PTCT_ITEM_CATEGORY_CTR0023_V
                WHERE INVENTORY_ITEM_ID (+) = CTL.INVENTORY_ITEM_ID
                ) ITEM_CATEGORY_NUMBER
                                    
                , (SELECT DISTINCT DESCRIPTION_CATE
                FROM PTCT_ITEM_CATEGORY_CTR0023_V
                WHERE INVENTORY_ITEM_ID (+) = CTL.INVENTORY_ITEM_ID
                ) ITEM_CATEGORY_DESC
            
                , ( SELECT DISTINCT OPRN_NO
                FROM    PTPM_OPM_ROUTING_V  RT                          
                WHERE   RT.OPRN_NO  (+) = CTL.WIP_STEP_DESC)   WIP_STEP
                                    
                ,CTHH.START_DATE_THAI
                ,CTHH.END_DATE_THAI
                ,DECODE (CTH.APPROVED_FLAG     ,'Y' ,'อนุมัติ'   ,'N'   ,'รออนุมัติ' )    APPROVED_DESC			
                                    
                                    
                FROM    PTCT_STD_COST_HEADS_V   CTHH
                ,PTCT_STD_COST_PRDS_V  CTH
                ,PTCT_STD_COST_ITEMS_V   CTL
                ,PTCT_PRDGRP_PLAN_ITEMS_V pl1
                ,ptct_cost_center_v pcc
                                    
                WHERE 1=1		
                and pcc.cost_code = CTHH.cost_code			
                AND pl1.period_year = CTHH.PERIOD_YEAR (+)
                AND pl1.cost_code = CTHH.COST_CODE(+)
                AND pl1.prdgrp_year_id  = CTH.PRDGRP_YEAR_ID(+)
                AND pl1.plan_version_no  = CTHH.PLAN_VERSION_NO(+)
                AND pl1.product_group  = CTH.PRODUCT_GROUP(+)
                AND pl1.product_item_number  = CTH.product_item_number(+)

                AND CTH.ALLOCATE_YEAR_ID    =   CTL.ALLOCATE_YEAR_ID    (+)			
                AND CTHH.ALLOCATE_YEAR_ID   =   CTH.ALLOCATE_YEAR_ID			
                AND CTH.PRODUCT_GROUP       =   CTL.PRODUCT_GROUP       (+)			
                AND CTH.PRODUCT_ITEM_NUMBER  =  CTL.PRODUCT_ITEM_NUMBER (+)				
                			
                AND CTHH.PERIOD_YEAR            = '" . $periodYear . "'
                AND CTHH.PLAN_VERSION_NO        = '" . $planVersionNo . "'
                AND CTHH.VERSION_NO             = '" . $versionNo . "'
                AND	CTHH.COST_CODE	            = '" . $costCode . "'	
                AND CTH.PRODUCT_ITEM_NUMBER     BETWEEN '" . $productItemNumberFrom . "' AND '" . $productItemNumberTo . "'	

                AND CTL.WIP_STEP_DESC IS NOT NULL
                                    
                GROUP BY					
                CTHH.PERIOD_YEAR	
                ,pl1.ratio
                ,pcc.cost_group_code
                ,pl1.quantity_prd
                ,pl1.uom_code_prd				
                ,CTHH.PLAN_VERSION_NO					
                ,CTHH.VERSION_NO					
                ,CTHH.COST_CODE					
                ,CTHH.COST_DESCRIPTION					
                ,CTHH.QUANTITY					
                ,CTHH.UOM_CODE					
                ,CTH.PRODUCT_GROUP					
                ,CTH.PRODUCT_GROUP_NAME					
                ,CTH.PRODUCT_ITEM_NUMBER					
                ,CTH.PRODUCT_ITEM_DESC					
                ,CTL.ITEM_NUMBER					
                ,CTL.ITEM_DESC					
                ,CTL.UOM_CODE					
                ,CTL.INVENTORY_ITEM_ID					
                ,CTL.ORGANIZATION_ID					
                ,CTL.WIP_STEP_DESC					
                ,CTH.PRDGRP_YEAR_ID					
                ,CTL.UNIT_STD_COST					
                ,CTHH.START_DATE_THAI					
                ,CTHH.END_DATE_THAI					
                ,CTH.APPROVED_FLAG	
    
                ORDER BY CTHH.COST_CODE, CTH.PRODUCT_GROUP, CTH.PRODUCT_ITEM_NUMBER, CTL.ITEM_NUMBER, ITEM_CATEGORY_NUMBER, CTL.WIP_STEP_DESC
            ");
            
        return $results;

    }

}
