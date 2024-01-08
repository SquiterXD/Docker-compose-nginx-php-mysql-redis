<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0008ApiController;
use Illuminate\Support\Facades\DB;

class PM0008Controller extends BaseController
{
    public function __construct(PM0008ApiController $api)
    {
        $this->api = $api;
    }

    /** @noinspection DuplicatedCode */
    public function index()
    {
        $profile = getDefaultData();
        $checkOrgSql = "
            SELECT  from_organization_id
            from    PTPM_SETUP_MFG_DEPARTMENTS_V
            where   1=1
            and     organization_id = {$profile->organization_id}
            and     from_organization_id is not null
            and     nvl(enable_flag, 'N') = 'Y'
        ";
        $checkItemCateSql = "
            SELECT  tobacco_group_code
            from    PTPM_SETUP_MFG_DEPARTMENTS_V
            where   1=1
            and     organization_id = {$profile->organization_id}
            and     tobacco_group_code is not null
            and     nvl(enable_flag, 'N') = 'Y'
        ";

        $query = "SELECT P.ORGANIZATION_ID,
                    P.ORGANIZATION_CODE,
                    P.SUBINVENTORY_CODE,
                    P.CONCATENATED_SEGMENTS,
                    P.LOCATOR,
                    P.INVENTORY_ITEM_ID,
                    P.ITEM_DESC,
                    P.ITEM_NUMBER,
                    SUM(P.TRANSACTION_QUANTITY) TRANSACTION_QUANTITY,
                    U.UNIT_OF_MEASURE,
                    P.MIN_QTY,
                    P.MAX_QTY,
                    P.HOLD_DATE,
                    P.TOBACCO_GROUP_CODE,
                    P.TOBACCO_GROUP
                    FROM APPS.PTPM_ITEM_ONHAND_V P
                    LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                    ON U.UOM_CODE = P.PRIMARY_UOM_CODE
                    where   1=1
                    -- and     P.ORGANIZATION_ID = {$profile->organization_id}
                    and     P.ORGANIZATION_ID in ($checkOrgSql)
                    and     P.TOBACCO_GROUP_CODE in ($checkItemCateSql)
                    GROUP BY
                    P.ORGANIZATION_ID,
                    P.ORGANIZATION_CODE,
                    P.SUBINVENTORY_CODE,
                    P.CONCATENATED_SEGMENTS,
                    P.LOCATOR,
                    P.INVENTORY_ITEM_ID,
                    P.ITEM_DESC,
                    P.ITEM_NUMBER,
                    U.UNIT_OF_MEASURE,
                    P.MIN_QTY,
                    P.MAX_QTY,
                    P.HOLD_DATE,
                    P.TOBACCO_GROUP_CODE,
                    P.TOBACCO_GROUP
                    ORDER BY P.ORGANIZATION_CODE,P.SUBINVENTORY_CODE,P.CONCATENATED_SEGMENTS,P.ITEM_NUMBER";

        $lov_segment = DB::select("SELECT DISTINCT
                                        TOBACCO_GROUP_CODE,
                                        TOBACCO_GROUP
                                        FROM APPS.PTPM_ITEM_ONHAND_V
                                        where   1=1
                                        --and     ORGANIZATION_ID = {$profile->organization_id}
                                        and     ORGANIZATION_ID in ($checkOrgSql)
                                        and     TOBACCO_GROUP_CODE in ($checkItemCateSql)
                                        ORDER BY TOBACCO_GROUP_CODE");

        $lov_organization = DB::select("SELECT DISTINCT
                                            ORGANIZATION_CODE,
                                            ORGANIZATION_NAME,
                                            TOBACCO_GROUP_CODE
                                            FROM APPS.PTPM_ITEM_ONHAND_V
                                            where   1=1
                                            --and     ORGANIZATION_ID = {$profile->organization_id}
                                            and     ORGANIZATION_ID in ($checkOrgSql)
                                            ORDER BY ORGANIZATION_CODE");

        $lov_sub_inventory = DB::select("SELECT DISTINCT
                                            ORGANIZATION_CODE,SUBINVENTORY_CODE
                                            FROM APPS.PTPM_ITEM_ONHAND_V
                                            where   1=1
                                            --and     ORGANIZATION_ID = {$profile->organization_id}
                                            and     ORGANIZATION_ID in ($checkOrgSql)
                                            and     TOBACCO_GROUP_CODE in ($checkItemCateSql)
                                            ORDER BY SUBINVENTORY_CODE");

        $lov_locator_inventory = DB::select("SELECT DISTINCT
                                            ORGANIZATION_CODE, SEGMENT2, SUBINVENTORY_CODE ,LOCATOR
                                            FROM APPS.PTPM_ITEM_ONHAND_V
                                            where   1=1
                                            --and     ORGANIZATION_ID = {$profile->organization_id}
                                            and     ORGANIZATION_ID in ($checkOrgSql)
                                            and     TOBACCO_GROUP_CODE in ($checkItemCateSql)
                                            ORDER BY SEGMENT2");

        $lov_inventory_item = DB::select("SELECT DISTINCT
                                            TOBACCO_GROUP_CODE,
                                            INVENTORY_ITEM_ID,
                                            ITEM_NUMBER,
                                            ITEM_DESC,
                                            ORGANIZATION_CODE
                                            FROM APPS.PTPM_ITEM_ONHAND_V
                                            where   1=1
                                            --and     ORGANIZATION_ID = {$profile->organization_id}
                                            and     ORGANIZATION_ID in ($checkOrgSql)
                                            and     TOBACCO_GROUP_CODE in ($checkItemCateSql)
                                            ORDER BY ITEM_NUMBER");

        $exp_month = DB::select("SELECT MEANING
                                        FROM APPS.PTPM_SETUP_BEFORE_NOTICE");

        return $this->vue('pm0008', [
            'btn_trans' => trans('btn'),
            'data' => DB::select($query),
            'lov_segment' => $lov_segment,
            'lov_organization' => $lov_organization,
            'lov_sub_inventory' => $lov_sub_inventory,
            'lov_locator_inventory' => $lov_locator_inventory,
            'lov_inventory_item' => $lov_inventory_item,
            'exp_month' => $exp_month[0]->meaning,
            'is_check_lot_no' => true,
        ]);
    }
}
