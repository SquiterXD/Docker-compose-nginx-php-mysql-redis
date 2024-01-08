<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class PM0008ApiController extends Controller
{
    public function show(Request $request)
    {
        $isCheckLotNo = $request->input('check_lot_no');
        $isCheckExpDate = $request->input('check_exp_date');
        $isCheckMinQty = $request->input('check_min_qty');

        if ((!$isCheckLotNo && !$isCheckExpDate && !$isCheckMinQty) ||
            $isCheckMinQty
        ) {

            $query = "SELECT P.ORGANIZATION_ID,
                        P.ORGANIZATION_CODE,
                        P.SUBINVENTORY_CODE,
                        --P.CONCATENATED_SEGMENTS,
                        P.SEGMENT2,
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
                        WHERE 1 = 1";

            // check min qty
            if ($request->input('check_min_qty') == true) {

                $query .= " and p.min_qty > p.transaction_quantity";
            }

            if ($request->input('segment')) {
                $query .= " and p.tobacco_group_code = '" . $request->input('segment') . "'";
            }

            if ($request->input('organization')) {
                $query .= " and p.organization_code = '" . $request->input('organization') . "'";
            }

            // คลังจัดเก็บ
            if ($request->input('sub_inventory')) {
                $query .= " and p.subinventory_code = '" . $request->input('sub_inventory') . "'";
            }

            // สถานที่จัดเก็บ
            if ($request->input('locator')) {
                $query .= " and p.locator = '" . $request->input('locator') . "'";
            }
            if ($request->input('segment2')) {
                $query .= " and p.segment2 = '" . $request->input('segment2') . "'";
            }

            if ($request->input('inventory_item')) {
                $query .= " and p.inventory_item_id = '" . $request->input('inventory_item') . "'";
            }

            $query .= " GROUP BY
                        P.ORGANIZATION_ID,
                        P.ORGANIZATION_CODE,
                        P.SUBINVENTORY_CODE,
                        P.SEGMENT2,
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
                        ORDER BY P.SUBINVENTORY_CODE,P.SEGMENT2,P.ITEM_NUMBER";
        } else {


            $query = "SELECT P.* ,
                        U.UNIT_OF_MEASURE
                        FROM APPS.PTPM_ITEM_ONHAND_V P
                        LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                        ON U.UOM_CODE = P.PRIMARY_UOM_CODE
                        WHERE 1 = 1";

            $expMonth = $request->input('exp_month');

            if ($request->input('check_exp_date')) {
                $query .= " and p.expiration_date > sysdate ";
                $query .= " and p.expiration_date < ADD_MONTHS(sysdate, {$expMonth}) ";
            }

            if ($request->input('segment')) {
                $query .= " and p.tobacco_group_code = '" . $request->input('segment') . "'";
            }

            if ($request->input('organization')) {
                $query .= " and p.organization_code = '" . $request->input('organization') . "'";
            }

            // คลังจัดเก็บ
            if ($request->input('sub_inventory')) {
                $query .= " and p.subinventory_code = '" . $request->input('sub_inventory') . "'";
            }

            // สถานที่จัดเก็บ
            if ($request->input('locator')) {
                $query .= " and p.locator = '" . $request->input('locator') . "'";
            }

            if ($request->input('segment2')) {
                $query .= " and p.segment2 = '" . $request->input('segment2') . "'";
            }

            if ($request->input('inventory_item')) {
                $query .= " and p.inventory_item_id = '" . $request->input('inventory_item') . "'";
            }

            $query .= " ORDER BY P.SUBINVENTORY_CODE,P.SEGMENT2,P.ITEM_NUMBER";
        }

        return response()->json([
            'res' => DB::select($query),
            'is_check_lot_no' => $isCheckLotNo,
            'is_check_min_qty' => $isCheckMinQty,
            'is_check_exp_date' => $isCheckExpDate,
        ]);
    }
}
