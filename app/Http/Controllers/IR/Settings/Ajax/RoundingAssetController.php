<?php

namespace App\Http\Controllers\IR\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\Settings\AssetDifferenceV;

class RoundingAssetController extends Controller
{
    public function getAsset()
    {
        $text  = request()->get('query');

        $data = AssetDifferenceV::where('policy_set_header_id', request()->policy_set_header_id)
                    ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                                $r->whereRaw("UPPER(asset_number) like '%".strtoupper($text)."%'")
                                ->orWhereRaw("UPPER(description) like '%".strtoupper($text)."%'")
                                ->orWhereRaw("UPPER(asset_id) like '%".strtoupper($text)."%'");
                           });
                     })
                     ->limit(50)
                     ->get();

        return response()->json($data);
    }
}
