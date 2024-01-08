<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmRequestLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0005_2ApiController extends Controller
{

    public function index(Request $request, int $headerId = null): JsonResponse
    {
//        $typeCode = $request->get('type_code');
//        $itemClassificationCode = $request->get('item_classification_code');
        $inventoryItemId = $request->get('inventory_item_id');

        if ($headerId) {
            $header = DB::selectOne("
                SELECT *
                FROM PTPM_REQUEST_HEADERS
                WHERE
                    REQUEST_HEADER_ID = '{$headerId}'
            ");
        } else {
            $header = (object)[];
        }

        $header->inventory_item_id = $inventoryItemId;
        $header->request_id = null;

        //Blend No. สินค้าที่จะผลิต
        $itemNumberVList = collect(DB::select("
            SELECT  BLEND_NO,    -- ลิสให้เลือก Blend No
                    ITEM_NUMBER,  -- ลิสให้เลือก สินค้าที่จะผลิต
                    ITEM_DESC,    -- รายละเอียดสินค้าที่จะผลิต ที่แสดงในหน้าจอ
                    INVENTORY_ITEM_ID  -- save ลง table PTPM_REQUEST_HEADERS
            FROM    OAPM.PTPM_ITEM_NUMBER_V
            WHERE  BLEND_NO IS NOT NULL
            AND    ORGANIZATION_CODE = 'A02'
            AND    TOBACCO_GROUP_CODE IS NOT NULL
        "));
        if (!isset($header->item_number_v)) $header->item_number_v = null;
        $header->item_number_v_list = $itemNumberVList;

        //ประเภทวัตถุดิบ
        $itemClassificationList = collect(DB::select("
            SELECT  ITEM_CLASSIFICATION_CODE,    -- save
                    ITEM_CLASSIFICATION          -- display
            FROM    OAPM.PTPM_ITEM_CLASSIFICATIONS_V
        "));
        $header->item_classification = $itemClassificationList->first();
        $header->item_classification_list = $itemClassificationList;

        //วัตถุประสงค์ในการเบิก
        $objectiveRequestList = collect(DB::select("
            SELECT  LOOKUP_CODE,          -- save
                    MEANING,              -- display ยกเลิกแล้ว เปลี่ยนไปใช้ DESCRIPTION แทน
                    DESCRIPTION    -- display
            FROM    OAPM.PTPM_OBJECTIVE_REQUEST
            WHERE   ENABLED_FLAG   =  'Y'
        "));
        $header->objective_request = $objectiveRequestList->first();
        $header->objective_request_list = $objectiveRequestList;
        $header->objective_code = $objectiveRequestList->first();

        //สถานะขอเบิก
        $requestTransferStatusList = collect(DB::select("
            SELECT  LOOKUP_CODE,    -- save
                    DESCRIPTION    -- display
            FROM    OAPM.PTPM_REQUEST_TRANSFER_STATUS
            WHERE   ENABLED_FLAG    =  'Y'
        "));
        $header->request_transfer_status = $requestTransferStatusList->first();
        $header->request_transfer_status_list = $requestTransferStatusList;
        $header->request_status = $requestTransferStatusList->first()->lookup_code;

        //add default value to header
        //$header = (array)$header;
        if (!isset($header->request_date)) $header->request_date = date('Y-m-d');
        if (!isset($header->send_date)) $header->send_date = date('Y-m-d');

        //tag
        $tagList = DB::select("
            SELECT      PTIS2.TYPE_CODE,            -- save
                        PTIS2.TYPE_DESC,            -- display
                        PTIS2.REQUEST_MAT_FLAG
            FROM        TOAT.PTPM_TOBACCO_ITEMCAT_SEG1_V PTIS1,
                        TOAT.PTPM_TOBACCO_ITEMCAT_SEG2_V PTIS2
            WHERE       PTIS1.GROUP_CODE            = PTIS2.GROUP_CODE
            AND         PTIS1.ITEM_CLASSIFICATION   = '01'
            AND         PTIS2.REQUEST_MAT_FLAG      = 'Y'
            AND         PTIS1.REQUEST_MAT_FLAG      = 'Y'
            GROUP BY    PTIS1.ITEM_CLASSIFICATION,
                        PTIS2.TYPE_CODE,
                        PTIS2.TYPE_DESC,
                        PTIS2.REQUEST_MAT_FLAG
            -- ORDER BY    PTIS2.TYPE_CODE;
        ");

        $line = $this->lines($request, $headerId)->getData();

        return response()->json([
            'header' => $header,
            'lines' => $line->lines,
            'linesSrc' => $line->linesSrc,
            'tagList' => $tagList,
        ]);
    }

    public function lines(Request $request, int $headerId = null): JsonResponse
    {
        $user = auth()->user();
        $inventoryItemId = $request->get('inventory_item_id');

        if (!$inventoryItemId && $headerId) {
            $header = DB::selectOne("
                SELECT *
                FROM PTPM_REQUEST_HEADERS
                WHERE
                    REQUEST_HEADER_ID = '{$headerId}'
            ");
            $inventoryItemId = $header ? $header->inventory_item_id : null;
        }

        //ถ้ามีการเลือก BlendNo หรือ สินค้าที่จะผลิต
        if ($inventoryItemId) {

            $sql = "
                SELECT
                        mfg.INVENTORY_ITEM_ID,        -- save
                        mfg.PRODUCT_ITEM_ID,        -- save
                        mfg.PRODUCT_ITEM_NUMBER,
                        mfg.ITEM_NUMBER,              -- display ในช่อง รหัสวัตถุดิบ
                        mfg.ITEM_DESC,                -- เอาไปแสดงในช่อง รายละเอียด
                        mfg.TOBACCO_GROUP_CODE,
                        mfg.ITEM_CLASSIFICATION_CODE,
                        mfg.TOBACCO_TYPE_CODE,
                        mfg.DEFAULT_LOT_NO,            -- เอาไปแสดงในช่อง LOT
                        mfg.ORGANIZATION_ID,

                        setup.FROM_ORGANIZATION_ID,     -- 168 *
                        setup.FROM_SUBINVENTORY,        -- FC6ROJ01 *
                        setup.FROM_LOCATOR_ID,          --2 *

                --        onhand.LOT_NUMBER,              --6061    (LOT)
                --        onhand.ONHAND_QUANTITY,         -- 50000  (ปริมาณคงคลังฝ่ายจัดหา)
                --        onhand.PRIMARY_UOM_CODE         -- KG    (หน่วยเบิก)
                1
                FROM OAPM.PTPM_MFG_FORMULA_V mfg
                        LEFT JOIN OAPM.PTPM_SETUP_MFG_DEPARTMENTS_V setup
                            ON  setup.DEPARTMENT_CODE       = '{$user->department_code}'    --> จาก CURRENT USER (กองยาเส้น)
                            AND setup.TOBACCO_GROUP_CODE    = mfg.tobacco_group_code        --> จากรหัสวัตถุดิบ  PTPM_MFG_FORMULA_V > TOBACCO_GROUP_CODE
                        --LEFT JOIN TOAT.PTINV_ONHAND_QUANTITIES_V onhand
                        --    ON  onhand.ORGANIZATION_ID      = setup.from_organization_id    --> ได้จาก  PTPM_SETUP_MFG_DEPARTMENTS_V > FROM_ORGANIZATION_ID
                        --    AND onhand.SUBINVENTORY_CODE    = setup.from_subinventory       --> ได้จาก  PTPM_SETUP_MFG_DEPARTMENTS_V > FROM_SUBINVENTORY
                        --    AND onhand.LOCATOR_ID           = setup.from_locator_id         --> ได้จาก  PTPM_SETUP_MFG_DEPARTMENTS_V > FROM_LOCATOR_ID
                        --    AND onhand.INVENTORY_ITEM_ID    = mfg.inventory_item_id         --> ได้จาก  วัตถุดิบ PTPM_MFG_FORMULA_V > INVENTORY_ITEM_ID
                        LEFT JOIN PTPM_REQUEST_LINES line
                            ON  line.inventory_item_id      = mfg.inventory_item_id
                            " . ($headerId ? "AND line.request_header_id      = '{$headerId}'" : "") . "
                WHERE 1 = 1
                --     AND ITEM_CLASSIFICATION_CODE           = ''  -- เลือกประเภทวัตถุดิบ 'ใบยา'  >> ถ้าเปลี่ยนเป็นสารปรุงสารหอม = '02'.
                --     AND TOBACCO_TYPE_CODE           = ''  -- คลิกเลือก TAB 'เวอร์ยิเนีย'
                        AND mfg.product_item_id = '{$inventoryItemId}'
            ";

//            echo "<pre>$sql</pre>";
            $rows = DB::select($sql);
            $i = 0;

//            echo "<pre>";
//            print_r($rows);
//            echo "</pre>";
            $linesSrc = $lines = collect($rows)->map(function ($row) use (&$i) {

                $onhands = collect(DB::select("
                    SELECT
                            onhand.LOT_NUMBER,              --6061    (LOT)
                            onhand.ONHAND_QUANTITY,         -- 50000  (ปริมาณคงคลังฝ่ายจัดหา)
                            onhand.PRIMARY_UOM_CODE         -- KG    (หน่วยเบิก)
                    FROM TOAT.PTINV_ONHAND_QUANTITIES_V onhand
                    WHERE   onhand.ORGANIZATION_ID      = '{$row->from_organization_id}'    --> ได้จาก  PTPM_SETUP_MFG_DEPARTMENTS_V > FROM_ORGANIZATION_ID
                        AND onhand.SUBINVENTORY_CODE    = '{$row->from_subinventory}'       --> ได้จาก  PTPM_SETUP_MFG_DEPARTMENTS_V > FROM_SUBINVENTORY
                        AND onhand.LOCATOR_ID           = '{$row->from_locator_id}'         --> ได้จาก  PTPM_SETUP_MFG_DEPARTMENTS_V > FROM_LOCATOR_ID
                        AND onhand.INVENTORY_ITEM_ID    = '{$row->inventory_item_id}'       --> ได้จาก  วัตถุดิบ PTPM_MFG_FORMULA_V > INVENTORY_ITEM_ID
                "));

                if (count($onhands) === 1) {
                    $onhand = $onhands->first();
                    $onhandQty = $onhand->onhand_quantity;
                    $primaryUom = $onhand->primary_uom_code;
                } elseif (count($onhands) > 0) {
                    $onhandQty = $onhands->sum('onhand_quantity');
                    $primaryUom = $onhands->first()->primary_uom_code;
                } else {
                    $onhandQty = null;
                    $primaryUom = null;
                }

                $itemConvUomV = collect(DB::select("
                    SELECT
                        conv.FROM_UOM_CODE,             -- หน่วยเบิก2
                        conv.TO_UOM_CODE,               -- หน่วยเบิก
                        conv.CONVERSION_RATE            -- conversion rate ที่เอาไว้แปลงค่า
                    FROM APPS.PTPM_ITEM_CONV_UOM_V conv
                    WHERE   conv.INVENTORY_ITEM_ID      = '{$row->inventory_item_id}'      --> ได้จาก PTPM_MFG_FORMULA_V
                        AND conv.ORGANIZATION_ID        = '{$row->from_organization_id}'   --> ได้จาก oapm.PTPM_SETUP_MFG_DEPARTMENTS_V > from_organization_id
                        AND conv.TO_UOM_CODE            = '{$primaryUom}'             --> ได้จาก TOAT.PTINV_ONHAND_QUANTITIES_V > PRIMARY_UOM_CODE
                "));

                return [
                    //addition
                    'end' => $i++,
                    'isSelected' => false,
                    //basic column
                    'inventoryItemId' => $row->inventory_item_id,
                    'productItemId' => $row->product_item_id,
                    'itemClassificationCode' => $row->item_classification_code,
                    'tobaccoTypeCode' => $row->tobacco_type_code,
                    'itemNumber' => $row->item_number,
                    'itemDesc' => $row->item_desc,
                    'lotNumber' => $row->default_lot_no,
                    'onhandQty' => intval($onhandQty),
                    'primaryQty' => null,
                    'primaryUom' => $primaryUom,
                    'secondaryQty' => null,
                    'secondaryUom' => $itemConvUomV->first() ? $itemConvUomV->first()->from_uom_code : null,
                    'remarkMsg' => null,
                    //data src
                    'item_conv_uom_v' => $itemConvUomV->first(),
                    'item_conv_uom_v_list' => $itemConvUomV->map(function ($conv) {
                        $conv->conversion_rate = floatval($conv->conversion_rate);
                        return $conv;
                    }),

                    'debug_onhand' => $onhands,
                ];
            });

        } else {

            $sql = "
                SELECT
                    item.item_classification_code,
                    item.tobacco_type_code,
                    item.item_number,
                    item.item_desc,
                    item.primary_uom_code,

                    item.inventory_item_id,
                    item.organization_id,
                    item.primary_uom_code
                FROM OAPM.PTPM_ITEM_NUMBER_V item
                    LEFT JOIN PTPM_REQUEST_LINES line
                        ON  line.inventory_item_id      = item.inventory_item_id
                        " . ($headerId ? "AND line.request_header_id      = '{$headerId}'" : "") . "
                WHERE 1 = 1
                    AND   ORGANIZATION_CODE in ('A04', 'A06', 'M12')    --> จากตาราง header
                --    AND  ITEM_CLASSIFICATION_CODE   = '01'    -- เลือกประเภทวัตถุดิบ ใบยา  >> ถ้าเปลี่ยนเป็นสารปรุงสารหอม = '02'
                --    AND 	TOBACCO_TYPE_CODE 	   = '0100'  -- คลิกเลือก TAB 'เวอร์ยิเนีย'   >> ถ้าเปลี่ยนเป็น TAB อื่น ต้อง = '.....'
            ";

//            echo "<pre>$sql</pre>";
            $rows = DB::select($sql);
            $i = 0;

//            echo "<pre>";
//            print_r($rows);
//            echo "</pre>";

            $lines = [];

            $linesSrc = collect($rows)->map(function ($row) use (&$i) {

                $itemConvUomV = collect(DB::select("
                    SELECT
                        conv.FROM_UOM_CODE,             -- หน่วยเบิก2
                        conv.TO_UOM_CODE,               -- หน่วยเบิก
                        conv.CONVERSION_RATE            -- conversion rate ที่เอาไว้แปลงค่า
                    FROM APPS.PTPM_ITEM_CONV_UOM_V conv
                    WHERE   conv.INVENTORY_ITEM_ID      = '{$row->inventory_item_id}'      --> ได้จาก PTPM_MFG_FORMULA_V
                        AND conv.ORGANIZATION_ID        = '{$row->organization_id}'        --> ได้จาก oapm.PTPM_SETUP_MFG_DEPARTMENTS_V > from_organization_id
                        AND conv.TO_UOM_CODE            = '{$row->primary_uom_code}'       --> ได้จาก TOAT.PTINV_ONHAND_QUANTITIES_V > PRIMARY_UOM_CODE
                "));

                return [
                    //addition
                    'rnd' => $i++,
                    'isSelected' => false,
                    //basic column
                    'inventoryItemId' => $row->inventory_item_id,
                    'productItemId' => null,
                    'itemClassificationCode' => $row->item_classification_code,
                    'tobaccoTypeCode' => $row->tobacco_type_code,
                    'itemNumber' => $row->item_number,
                    'itemDesc' => $row->item_desc,
                    'lotNumber' => null,
                    'onhandQty' => null,
                    'primaryQty' => null,
                    'primaryUom' => $row->primary_uom_code,
                    'secondaryQty' => null,
                    'secondaryUom' => $itemConvUomV->first() ? $itemConvUomV->first()->from_uom_code : null,
                    'remarkMsg' => null,
                    //data src
                    'item_conv_uom_v' => $itemConvUomV->first(),
                    'item_conv_uom_v_list' => $itemConvUomV->map(function ($conv) {
                        $conv->conversion_rate = floatval($conv->conversion_rate);
                        return $conv;
                    }),
                ];
            });
        }

        return response()->json([
            'lines' => $lines,
            'linesSrc' => $linesSrc,
        ]);
    }

    public function save(Request $request)
    {
        $headerData = $request->input('header');
        $linesData = $request->input('lines');
        $user = auth()->user();
        $web_batch_no = date('YmdHis');

        DB::beginTransaction();
        try {

            $headerId = isset($headerData['request_header_id']) ? $headerData['request_header_id'] : null;

            // MCR change objective_code to save to db,
            // use description instead of lookup code
            $objectiveRequest = collect(DB::select("
                SELECT  LOOKUP_CODE,          -- save
                        MEANING,              -- display ยกเลิกแล้ว เปลี่ยนไปใช้ DESCRIPTION แทน
                        DESCRIPTION           -- display
                FROM    OAPM.PTPM_OBJECTIVE_REQUEST
                    WHERE   lookup_code   =  '{$headerData['objective_code']}'
            "))->first();

            $headerData = [
                'department_code' => $user->department_code,
                'request_date' => $headerData['request_date'],
                'inventory_item_id' => $headerData['inventory_item_id'],
                'ingredient_group' => $headerData['ingredient_group'],
                'request_id' => $headerData['request_id'],
                'objective_code' => $objectiveRequest->description,
                'request_status' => $headerData['request_status'],
                'send_date' => $headerData['send_date'],
                //
                'program_code' => 'PM0005',
                'requester_id' => $user->user_id,
                'created_by_id' => $user->user_id,
                'updated_by_id' => $user->user_id,
                'last_updated_by' => $user->user_id,
                'last_update_date' => date('Y-m-d'),
                'web_batch_no' => $web_batch_no,
            ];

            if ($headerId) {
                $header = PtpmRequestHeader::query()->find($headerId);
                $header->update($headerData);
            } else {
                $header = PtpmRequestHeader::query()->create($headerData);
            }

            PtpmRequestLine::query()
                ->where('request_header_id', $headerId)
                ->delete();

            $lines = [];
            foreach ($linesData as $lineData) {
                $lines[] = PtpmRequestLine::query()->create([
                    'request_header_id' => $header->request_header_id,
                    //'organization_id' => $lineData[''],
                    //'subinventory_code' => $lineData[''],
                    //'locator_id' => $lineData[''],
                    'inventory_item_id' => $lineData['inventoryItemId'],
                    'lot_number' => $lineData['lotNumber'],
                    'transaction_quantity' => $lineData['primaryQty'],
                    'transaction_uom' => $lineData['primaryUom'],
                    'secondary_qty' => $lineData['secondaryQty'],
                    'secondary_uom' => $lineData['secondaryUom'],
                    'remark_msg' => $lineData['remarkMsg'],
                    //
                    'program_code' => 'PM0005',
                    'created_by_id' => $user->user_id,
                    'updated_by_id' => $user->user_id,
                    'last_updated_by' => $user->user_id,
                    'last_update_date' => date('Y-m-d'),
                    'web_batch_no' => $web_batch_no,
                ]);
            }

            DB::commit();
            return response([
                'header' => $header,
                'lines' => $lines,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'message' => $e
            ], 500);
        }
    }


    public function confirmTransfer(Request $request)
    {
        $headerData = $request->input('header');
        $linesData = $request->input('lines');
        $user = auth()->user();
        $web_batch_no = date('YmdHis');

        $header = PtpmRequestHeader::query()
            ->where('request_header_id', $headerData['request_header_id'])
            ->first();

        $header->request_status = 'เบิกเพื่อทดลอง';

        $header->save();

        return response()->json([
            'header' => $header,
            'lines' => $linesData,
        ]);
    }
}
