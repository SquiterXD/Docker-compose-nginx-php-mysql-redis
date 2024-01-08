<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CT\PtctItemTax;
use App\Models\CT\PtctItemTaxV;
use App\Models\CT\PtpmItemNumberV;
use Carbon\Carbon;
use \DB;

class PtctItemTaxVController extends Controller
{
    public function index()
    {
        $res = PtctItemTaxV::select('item_number', 'Item_description',
        'inventory_item_id', 'organization_id',
        'TAX_ITEM_NUMBER', 'tax_item_description',
        'tax_inventory_item_id', 'tax_organization_id')
        ->orderBy('item_number')
        ->get();

        return response()->json($res);
    }

    public function store(Request $request)
    {
        $mtrA16 = PtpmItemNumberV::where('item_number', $request->item_number)
            ->where('organization_code', 'A16')
            ->first();

        $mtrA18 = PtpmItemNumberV::where('item_number', $request->tax_item_number)
            ->where('organization_code', 'A18')
            ->first();

        DB::beginTransaction();
        try {
            PtctItemTax::insert([
                'item_number'           => $request->item_number,
                'inventory_item_id'     => $mtrA16->inventory_item_id,
                'organization_id'       => $mtrA16->organization_id,
                'tax_item_number'       => $request->tax_item_number,
                'tax_inventory_item_id' => $mtrA18->inventory_item_id,
                'tax_organization_id'   => $mtrA18->organization_id,
                'program_code'          => 'CTM0013',
                'creation_date'         => Carbon::now(),
                'last_update_date'      => Carbon::now()
            ]);
            DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function destroy($item)
    {
        DB::beginTransaction();
        try {
            PtctItemTax::where('item_number', $item)->delete();
            DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }
}
