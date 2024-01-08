<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\PtinvUomV;
use App\Models\PM\Settings\ItemGroup;

class MaxStorageController extends Controller
{
    public function getUom()
    {
        // dd(request()->all());
        $text  = request()->get('query');

        if (request()->item_cat_code) {

            $item = ItemGroup::where('enabled_flag', 'Y')->where('item_cat_code', request()->item_cat_code)->first();
            $data  = PtinvUomV::where('uom_code', $item->attribute1)->first();
            // $data = $uom->unit_of_measure;
        } else {
            $data = PtinvUomV::when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('uom_code', 'like', "%${text}%")
                        ->orWhere('unit_of_measure', 'like', "${text}%");
                });
            })
            ->limit(50)
            ->get();
        }

        return response()->json($data);
    }
}
