<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PmFreeProductRequestHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0028ApiController extends Controller
{
    public function getProductByDate(Request $request, $date)
    {

        $date = date('Y-m-d', strtotime($date));
        $sampleProduct = PmFreeProductRequestHeader::whereDate('create_date', $date)->get();

        if (!$sampleProduct) return response()->json([
            'message' => 'data not found',
        ], 404);

        return response()->json(
            $sampleProduct);
    }

    public function update(Request $request, $date)
    {
        $auth = auth()->user();
        $date = date('Y-m-d', strtotime($date));
        $details = $request->input('lines');
        DB::beginTransaction();
        try {
            PmFreeProductRequestHeader::whereDate('create_date', $date)->delete();
            foreach ($details as $detail) {
                $detail['qty'] = str_replace(',', '', $detail['qty']);
                $mProduct = DB::table('PTMES_PLAN_PROCESS_DETAILS')->where('item_number', $detail['item'])->where('organization_id',  $auth->organization_id)->first();
                $sampleProduct = new PmFreeProductRequestHeader($detail);
                $sampleProduct->creation_date = now();
                $sampleProduct->inventory_item_id = $mProduct->inventory_item_id;
                $sampleProduct->organization_id = $auth->organization_id;
                $sampleProduct->create_date = $date;
                $sampleProduct->uom = 'มวน';
                $sampleProduct->save();
            }
            DB::commit();
            $sampleProducts = PmFreeProductRequestHeader::whereDate('create_date', $date)->get();
            return response([
                'sampleProducts' => $sampleProducts,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteLine(Request $request)
    {
        $ids = $request->get('ids');

        DB::beginTransaction();

        try {
            $res = PmFreeProductRequestHeader::query()
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
