<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\CT\PtpmItemNumberV;
use App\Models\CT\ProductGroupDetail;
use App\Models\CT\ProductGroupLot;
use App\Models\CT\FndLookupValuesVl;

class ProductGroupDetailController extends Controller
{
    public function lot()
    {
        $lot = FndLookupValuesVl::where('lookup_type', 'TOAT_INV_CROP_LEAF')
        ->select('lookup_type', 'lookup_code', 'meaning', 'description')
        ->orderBy('lookup_code')
        ->get();

        return response()->json($lot, 200);
    }

    public function update(Request $request)
    {
        $user = getDefaultData('/users');
        $post_data = $request->input('data');

        DB::beginTransaction();
        try {
            foreach ($post_data as $key => $value) {
                // Delete Old data 
                ProductGroupDetail::where('product_group_id', $value['product_group_id'])->delete();
                ProductGroupLot::where('product_group_id', $value['product_group_id'])->delete();
                
                // Find code, name from view table
                $ptpmItemNumberVs = PtpmItemNumberV::query()
                    ->select('item_number', 'item_desc')
                    ->whereIn('item_number', $value['value_pg_details'])
                    ->where('organization_code', $user->organization_code)
                    ->where('organization_id', $user->organization_id)
                    ->get();

                // Create Data Product Group Detail
                foreach ($ptpmItemNumberVs as $key => $ptpmItemNumberV) {
                    ProductGroupDetail::create([
                        'product_group_id' => $value['product_group_id'], 
                        'code' => $ptpmItemNumberV->item_number, 
                        'name' => $ptpmItemNumberV->item_desc
                    ]);
                }

                // Create Data Product Group Lot
                foreach ($value['value_pg_lots'] as $key => $value_pg_lots) {
                    ProductGroupLot::create([
                        'product_group_id' => $value['product_group_id'],
                        'lot' => $value_pg_lots
                    ]);
                }
            }

            DB::commit();
            return response()->json(['msg' => "success"], 200);
        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function findWithProductGroup($product_group_id)
    {
        $productGroupDetails = ProductGroupDetail::where('product_group_id', $product_group_id)->get();
        return response()->json($productGroupDetails);
    }
}
