<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmStampHeader;
use App\Models\PM\PtpmStampLine;
use App\Helpers\Utils;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0033ApiController extends Controller
{
    public function getIndex(Request $request): JsonResponse
    {
        $queryString = $request->all();

        $requestDate = self::getDateOrDefault($queryString);
        if (!isset($requestDate)) {
            $requestDate = date('Y-m-d');
        }


        $stampTableName = (new PtpmStampHeader)->getTable();
        $stampLineTableName = (new PtpmStampLine)->getTable();

        $stampUsageByBrandByMachine = PtpmStampHeader::query()
            ->selectRaw("
                stamp_header_id,
                machine_group,
                description1,
                item_code2,
                description2,
                -- total_used,
                -- actual_used,
                (
                    select
                            sum(remaining)
                    from    PTPM_STAMP_LINE
                    where   1=1
                    and     $stampTableName.stamp_header_id = $stampLineTableName.stamp_header_id
                ) as total_used,
                (
                    SELECT PRODUCT_QTY
                    FROM    PTMES_PRODUCT_DISTRIBUTION PPD
                    WHERE   $stampTableName.MACHINE_GROUP = PPD.MACHINE_SET
                    AND     $stampTableName.INVENTORY_ITEM_ID1 = PPD.INVENTORY_ITEM_ID
                    AND     $stampTableName.ORGANIZATION_ID = PPD.ORGANIZATION_ID
                    AND     TRUNC($stampTableName.USED_DATE) = TRUNC(PPD.PRODUCT_DATE)
                    AND     PPD.WIP_STEP = 'WIP04'
                ) as actual_used,
                total_loss,
                return_stamp,
                repair,
                actual_loss,
                broken,
                loss,
                transaction_flag
            ")
            ->whereDate('used_date', '=', $requestDate)
            // ->where('inventory_item_id1', 17735)
            ->orderByRaw("
                item_code2,description1,machine_group
            ")
            ->get();
        $validateStampUsageByBrandByMachine = [];
        $validateValue = (object) [
            'valid' => true,
            'input_class_name' => 'form-control ',
            'err_msg' => ''
        ];

        foreach ($stampUsageByBrandByMachine as $stamp) {
            // $broken = isset($stamp['broken']) ? $stamp['broken'] : 0;
            // $loss = isset($stamp['loss']) ? $stamp['loss'] : 0;

            // // if actual_loss is null; set value as broken + loss
            // if (!isset($stamp['actual_loss'])) {
            //     $stamp['actual_loss'] = $broken + $loss;
            // }

            // $actualLoss = isset($stamp['actual_loss']) ? $stamp['actual_loss'] : 0;

            // //if total_loss is null; set value as return_stamp + repair + actual_loss
            // if ($stamp['total_loss'] === null) {
            //     $stamp['total_loss'] = $stamp['return_stamp'] + $stamp['repair'] + $actualLoss;
            // }

            // $totalUse = isset($stamp['actual_used']) ? $stamp['actual_used'] : 0;
            // $totalLoss = isset($stamp['total_loss']) ? $stamp['total_loss'] : 0;

            // //if actual_used is null; set value as total_loss + actual_loss
            // if ($stamp['actual_used'] === null) {
            //     $stamp['actual_used'] = $totalUse - $totalLoss;
            // }

            $stamp['actual_loss']   = $stamp->actual_loss ?? 0;
            $stamp['total_loss']    = $stamp->total_loss ?? 0;
            $stamp['actual_used']   = $stamp->actual_used ?? 0;

            \Arr::set($validateStampUsageByBrandByMachine,
                $stamp->stamp_header_id. '.total_used',
                $validateValue);
            \Arr::set($validateStampUsageByBrandByMachine,
                $stamp->stamp_header_id. '.return_stamp',
                $validateValue);
            \Arr::set($validateStampUsageByBrandByMachine,
                $stamp->stamp_header_id. '.repair',
                $validateValue);
            \Arr::set($validateStampUsageByBrandByMachine,
                $stamp->stamp_header_id. '.broken',
                $validateValue);
            \Arr::set($validateStampUsageByBrandByMachine,
                $stamp->stamp_header_id. '.loss',
                $validateValue);
        }

        $stampUsageByBrand = PtpmStampHeader::query()
            ->selectRaw('description1, item_code2, description2, sum(total_used) as total_used')
            ->groupBy('description1', 'item_code2', 'description2')
            ->whereDate('used_date', '=', $requestDate)
            ->get();

        $stampUsageByBrand =  collect(\DB::select("
            select  psh.description1,psh.item_code2,psh.description2,sum(psl.remaining) as total_used
            from    $stampTableName psh,
                    $stampLineTableName psl
            where  psh.stamp_header_id = psl.stamp_header_id
            and    psh.inventory_item_id1 = psl.inventory_item_id
            and     TRUNC (psh.used_date) = TRUNC(to_date('$requestDate', 'YYYY-MM-DD'))
            group by psh.description1,psh.item_code2,psh.description2
        "));


        $stampUsageByPriceGroup = PtpmStampHeader::query()
            ->selectRaw('item_code2, description2, sum(total_used) as total_used')
            ->groupBy('item_code2', 'description2')
            ->whereDate('used_date', '=', $requestDate)
            ->get();
        $stampUsageByPriceGroup =  collect(\DB::select("
            select  psh.item_code2,psh.description2,sum(psl.remaining) as total_used
            from    $stampTableName psh,
                    $stampLineTableName psl
            where  psh.stamp_header_id = psl.stamp_header_id
            and    psh.inventory_item_id1 = psl.inventory_item_id
            and     TRUNC (psh.used_date) = TRUNC(to_date('$requestDate', 'YYYY-MM-DD'))
            group by psh.item_code2,psh.description2
        "));

        return response()->json([
            'stampUsageDate' => $requestDate,
            'stampUsageByPriceGroup' => $stampUsageByPriceGroup,
            'stampUsageByBrand' => $stampUsageByBrand,
            'stampUsageByBrandByMachine' => $stampUsageByBrandByMachine,
            'validateStampUsageByBrandByMachine' => (object) $validateStampUsageByBrandByMachine,
        ]);
    }

    public function updateStampUsage(Request $request): JsonResponse
    {
        $request->validate([
            "stampUsageByBrandByMachine.total_used" => "integer",
            "stampUsageByBrandByMachine.actual_used" => "integer",
            "stampUsageByBrandByMachine.total_loss" => "integer",
            "stampUsageByBrandByMachine.return_stamp" => "integer",
            "stampUsageByBrandByMachine.repair" => "integer",
            "stampUsageByBrandByMachine.actual_loss" => "integer",
            "stampUsageByBrandByMachine.broken" => "integer",
            "stampUsageByBrandByMachine.loss" => "integer",
            "date" => "date",
        ]);

        $stampUsageByBrandByMachine = $request->get('stampUsageByBrandByMachine');
        $date = $request->get('date');

        try {
            DB::beginTransaction();

            foreach ($stampUsageByBrandByMachine as $stamp) {
                PtpmStampHeader::query()
                    ->find($stamp['stamp_header_id'])
                    ->update($stamp);
            }

            DB::commit();

            $response = self::getIndex($request)->getData();

            $response->stampUsedDate = $date;

            return response()->json($response);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function useStamp(Request $request): JsonResponse
    {
        $date = '2021-03-06';

        try {
            $stampUsageEntries = PtpmStampHeader::query()
                ->whereDate('used_date', '=', $date)
                ->get();

            DB::beginTransaction();
            $result = [];

            foreach ($stampUsageEntries as $stampUsageEntry) {
                if (isset($stampUsageEntry['transaction_flag'])) {
                    continue;
                }

                $organizationId = $stampUsageEntry['organization_id'];
                $inventoryItemId2 = $stampUsageEntry['inventory_item_id2'];
                $machineGroup = $stampUsageEntry['machine_group'];
                $usedDate = $stampUsageEntry['used_date'];

                //$organizationId = '171';
                //$inventoryItemId2 = '10937';
                //$machineGroup = '3';
                //$usedDate = '2021-03-06';

                $result[] = DB::raw("APPS.PTPM_TRANSACTION_PKG.STAMP
                (
                    $organizationId,
                    $inventoryItemId2,
                    $machineGroup,
                    $usedDate
                ) FROM dual;",
                );
            }

            DB::commit();

            return response()->json($result);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    /**
     * Validate date parameter in query string
     *
     * @param $queryString
     * @return string Date in ISO 8601 format.
     * If date not found or its format is invalid return null
     */
    public static function getDateOrDefault($queryString): ?string
    {
        $queryString = (object)$queryString;

        $requestDate = null;
        if (isset($queryString->date) && trim($queryString->date) !== '') {
            $isValidDate = Utils::isValidDate($queryString->date, 'Y-m-d');
            if ($isValidDate) {
                $requestDate = $queryString->date;
            }
        }

        return $requestDate;
    }
}
