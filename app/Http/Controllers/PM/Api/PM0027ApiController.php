<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmDepartmentFromGl;
use App\Models\PM\PtpmSampleproduct;
use App\Models\PM\PtpmSampleProductMes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PM0027ApiController extends Controller
{

    public function index(): JsonResponse
    {
        $sampleProducts = PtpmSampleproduct::query()->get();
        $sampleProductMes = PtpmSampleProductMes::query()->get();
        return response()->json($sampleProducts);
    }
    public function getDepartment(): JsonResponse
    {
        $department = PtpmDepartmentFromGl::query();
        return response()->json($department->get());
    }
    public function show(Request $request, $date)
    {
        $profile = getDefaultData();
        $date = date('Y-m-d', strtotime($date));
        $sampleProductMes = PtpmSampleProductMes::whereDate('create_date', $date)
            ->select('item', 'uom', 'description', PtpmSampleProductMes::raw("SUM(qty) as qty"))
            ->groupBy('item', 'uom', 'description')
            ->get();

        $productDate = date('Ymd', strtotime($date));
        $sampleProductMesSql = "SELECT  PPL.INVENTORY_ITEM_ID
        ,       MSI.SEGMENT1
        ,       MSI.DESCRIPTION
        ,       SUM (PPL.EXAMPLE_QTY) EXAMPLE_QTY
        ,       PPL.UOM
        ,       PUV.UNIT_OF_MEASURE
        ,       PPL.PRODUCT_DATE
        FROM    PTMES_PRODUCT_LINE PPL
        ,       MTL_SYSTEM_ITEMS MSI
        ,       PTINV_UOM_V PUV    
        WHERE   1=1
        AND     PPL.ORGANIZATION_ID = MSI.ORGANIZATION_ID
        AND PPL.PRODUCT_DATE = TO_DATE('{$date}', 'YYYY-mm-dd')
        AND     PPL.INVENTORY_ITEM_ID = MSI.INVENTORY_ITEM_ID
        AND     PPL.UOM = PUV.UOM_CODE
        AND   MSI.SEGMENT1 LIKE '1501%'
        AND     PPL.ORGANIZATION_ID = (SELECT   MP.ORGANIZATION_ID
                                    FROM    MTL_PARAMETERS MP
                                    WHERE   MP.ORGANIZATION_ID = PPL.ORGANIZATION_ID
                                    AND     MP.ORGANIZATION_CODE = 'MG6')
        GROUP BY PPL.INVENTORY_ITEM_ID, MSI.SEGMENT1, MSI.DESCRIPTION , PPL.PRODUCT_DATE, PPL.UOM, PUV.UNIT_OF_MEASURE
        ORDER BY PPL.PRODUCT_DATE, MSI.SEGMENT1";

        
        $sampleProductMes = collect(DB::select($sampleProductMesSql));
        // $sampleProductMes = collect(DB::select("
        //                         SELECT  PPL.INVENTORY_ITEM_ID
        //                         ,       MSI.SEGMENT1
        //                         ,       MSI.SEGMENT1 as item
        //                         ,       MSI.DESCRIPTION
        //                         ,       SUM (PPL.EXAMPLE_QTY)
        //                         ,       PPL.UOM
        //                         ,       PPL.UNIT_OF_MEASURE
        //                         ,       PPL.PRODUCT_DATE
        //                         FROM    PTMES_PRODUCT_LINE PPL
        //                         ,       MTL_SYSTEM_ITEMS MSI
        //                         WHERE   1=1
        //                         AND     PPL.ORGANIZATION_ID = MSI.ORGANIZATION_ID
        //                         AND     PPL.INVENTORY_ITEM_ID = MSI.INVENTORY_ITEM_ID
        //                         AND     to_char(PPL.PRODUCT_DATE, 'YYYYMMDD') = '{$productDate}'
        //                         AND     PPL.ORGANIZATION_ID = (SELECT   MP.ORGANIZATION_ID
        //                                                     FROM    MTL_PARAMETERS MP
        //                                                     WHERE   MP.ORGANIZATION_ID = PPL.ORGANIZATION_ID
        //                                                     AND     MP.ORGANIZATION_ID = $profile->organization_id)
        //                         GROUP BY PPL.INVENTORY_ITEM_ID, MSI.SEGMENT1, MSI.DESCRIPTION , PPL.PRODUCT_DATE, PPL.UOM, PPL.UNIT_OF_MEASURE
        //                         ORDER BY PPL.PRODUCT_DATE, MSI.SEGMENT1
        //                     "));

        $sampleProduct = PtpmSampleproduct::whereDate('create_date', $date)->get();

        if (!$sampleProduct || !$sampleProductMes) return response()->json([
            'message' => 'data not found',
        ], 404);

        // data_set($sampleProduct, '*.department_code_list', []);

        return response()->json([
            'productmes' => $sampleProductMes,
            'lines' => $sampleProduct]);
    }

    public function update(Request $request, $date)
    {
        $auth = auth()->user();
        $date = date('Y-m-d', strtotime($date));
        $lines = $request->input('lines');

        DB::beginTransaction();

        try {
            PtpmSampleproduct::whereDate('create_date', $date)->delete();
            foreach ($lines as $line) {
                $mProduct = DB::table('MTL_SYSTEM_ITEMS')->where('segment1', $line['item'])->where('organization_id',  $auth->organization_id)->first();
                $sampleProduct = new PtpmSampleproduct($line);
                $sampleProduct->create_date = $date;
                $sampleProduct->creation_date = now();
                $sampleProduct->inventory_item_id = $mProduct->inventory_item_id;
                $sampleProduct->organization_id = $auth->organization_id;
                $sampleProduct->save();
            }
            DB::commit();
            $sampleProducts = PtpmSampleproduct::whereDate('create_date', $date)->get();
            return response([
                'sampleProducts' => $sampleProducts,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function delete(Request $request)
    {
        $ids = $request->input('ids');

        DB::beginTransaction();

        try {
            $res = PtpmSampleproduct::query()
                ->whereIn('id', $ids)
                ->delete();

            DB::commit();
            return response([
                'res' => $res,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }
}
