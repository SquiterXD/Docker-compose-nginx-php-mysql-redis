<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\AssetV;
use App\Models\PM\Settings\MachineRelation;

class RelationController extends Controller
{
    public function index()
    {
        // $text = request()->get('query');
        $text = strtoupper(request()->get('query'));
        $profile = getDefaultData();

        // dd('xx', $profile->organization_code);

        $data = AssetV::when($text, function ($query, $text) {
                    return $query->where(function($r) use ($text) {
                        // $r->where('asset_number', 'like', "%${text}%")
                        // ->orWhere('asset_description', 'like', "%${text}%");

                        $r->whereRaw('UPPER(asset_number) like ?', "%${text}%")
                          ->orWhereRaw('UPPER(asset_description) like ?', "%${text}%");
                    });
                })
                ->when($profile->organization_code != '', function ($query) use ($profile) {
                    return $query->where('production_organization', $profile->organization_code);
                })
                ->orderBy('asset_number', 'asc')
                ->limit(50)
                ->get();

                // $data = AssetV::selectRaw('asset_number, asset_description')
                // ->when($text, function ($query, $text) {
                //     return $query->where(function($r) use ($text) {
                //         $r->where('asset_number', 'like', "'%${text}%'")
                //             ->orWhere('asset_description', 'like', "%${text}%");
                //     });
                // })
                // ->orderBy('asset_number')
                // ->limit(50)
                // ->get();

        return response()->json($data);
    }
    public function validateAsset(Request $request)
    {
        // dd('validateAsset', request()->all());
        
        if (request()->pm_enable_flag) {
            if (request()->machine_relation_id) {
                $machineRelation = MachineRelation::where('machine_relation_id', '!=', request()->machine_relation_id)
                                                ->where('machine_name', request()->machine_name)
                                                ->where('pm_enable_flag', 'Y')
                                                ->first();
                $status = $machineRelation ? 'Y' : 'N';

                // dd($machineRelation);
            } else {
                $machineRelation = MachineRelation::where('machine_name', request()->machine_name)
                                                ->where('pm_enable_flag', 'Y')
                                                ->first();
                $status = $machineRelation ? 'Y' : 'N';
            }
            
        } else {
            $status = 'N';
        }
        // dd($machineRelation, $status);
        
        return response()->json([
            'data' => [
                'status'  => $status,
            ]
        ]);
    }
}
