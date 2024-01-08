<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\AliasNameV;
use App\Models\INV\CarHistoryV;
use App\Models\INV\CarInfoV;
use App\Models\INV\CoaDeptCodeV;
use App\Models\INV\CstItemCost;
use Illuminate\Http\Request;

class PtinvCarInfoVController extends Controller
{
    public function index()
    {
        $carInfoVs = CarInfoV::query()
            ->where(function ($q) {
                $query = request()->text;
                if ($query) {
                    $q->where('car_license_plate', 'like', "%{$query}%");
                }
            })
            ->when(request()->organization_code, function($q) {
                return $q->where("organization_code", request()->organization_code);
            })
            ->when(request()->source_data, function($q) {
                return $q->where("source_data", request()->source_data);
            })
            ->orderBy('car_license_plate')
            ->limit(20)
            ->get();


        foreach ($carInfoVs as $carInfo) {
            if(!$carInfo->inventory_item_id) {
                continue;
            }
            $carInfo->fuel_price = CstItemCost::where("inventory_item_id", $carInfo->inventory_item_id)
                ->where('organization_id', $carInfo->organization_id)
                ->select(['inventory_item_id', 'material_cost', 'organization_id'])
                ->first();
        }

        foreach ($carInfoVs as $carInfo) {
            $carInfo->department = CoaDeptCodeV::where("department_code", $carInfo->default_dept_code)
                ->select("department_code", "description")
                ->first();
            $carInfo->quota_balance = CarHistoryV::query()
                ->where('car_license_plate', $carInfo->car_license_plate)
                ->select(\DB::raw('SUM(quantity) as total'))
                ->whereHas('webFuelOils')
                ->first();
            $carInfo->aliasName = AliasNameV::where('alias_name', $carInfo->account_code)
                ->select('alias_name', 'template')
                ->first();
        }

        return response()->json($carInfoVs);
    }
}
