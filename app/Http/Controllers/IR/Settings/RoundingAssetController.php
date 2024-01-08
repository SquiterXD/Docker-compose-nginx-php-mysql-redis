<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\Settings\AssetDifference;
use App\Models\IR\Settings\AssetDifferenceV;
use App\Models\IR\Settings\PolicySetHeader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RoundingAssetController extends Controller
{
    public function index()
    {
        // dd(request()->all());
        $dataSearch = (object)[]; 
        $dataSearch->asset_id              = request()->asset_id;
        $dataSearch->policy_set_header_id  = request()->policy_set_header_id;

        $policy_ids = AssetDifference::get()->pluck('policy_set_header_id')->unique();
        $asset_ids  = AssetDifference::get()->pluck('asset_id')->unique();

        // dd($policy_ids->toArray(), $asset_ids->toArray());
        $policyLists = PolicySetHeader::whereIn('policy_set_header_id', $policy_ids)->orderBy('policy_set_number', 'asc')->get();
        $assetLists  = AssetDifferenceV::whereIn('asset_id', $asset_ids)->orderBy('asset_number', 'asc')->get();

        $datas = AssetDifference::search($dataSearch)->orderBy('creation_date', 'asc')->get();

        return view('ir.settings.rounding-asset.index', compact('dataSearch', 'datas', 'policyLists', 'assetLists'));
    }

    public function create()
    {
        $policy_ids = AssetDifference::get()->pluck('policy_set_header_id')->unique();
        $ids = '';

        foreach ($policy_ids as $key => $value) {
            if ($key == 0) {
                $ids = $value;
            } else {
                $ids = $ids . ',' . $value;
            }
        }
        if ($ids) {
            $text = 'and psh.policy_set_header_id not in (' . $ids . ')';
        } else {
            $text = '';
        }
        
        // dd($ids, $text);

        $sql = "
            select psh.policy_set_header_id, psh.policy_set_number,  psh.policy_set_description
            from   ptir_policy_set_headers psh, ptir_policy_type pt
            where  psh.policy_type_code = pt.lookup_code
            and    pt.meaning = 'Replacement Value'
            {$text}
            order by psh.policy_set_number asc
        ";

        $policyLists =  \DB::select($sql);


        return view('ir.settings.rounding-asset.create', compact('policyLists'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $list                       = new AssetDifference;
        $list->asset_id             = request()->form['asset_id'];
        $list->policy_set_header_id = request()->form['policy_set_header_id'];
        $list->created_by_id        = $user->user_id;
        $list->created_by           = $user->user_id;
        $list->last_updated_by      = $user->user_id;
        $list->save();

        $data['status'] = 'S';
        $data['msg'] = '';

        return response()->json($data);

    }

    public function edit($id)
    {
        $data = AssetDifference::find($id);

        $sql = "
            select psh.policy_set_header_id, psh.policy_set_number,  psh.policy_set_description
            from   ptir_policy_set_headers psh, ptir_policy_type pt
            where  psh.policy_type_code = pt.lookup_code
            and    pt.meaning = 'Replacement Value'
            order by psh.policy_set_number asc
        ";
        $policyLists =  \DB::select($sql);

        return view('ir.settings.rounding-asset.edit', compact('data', 'policyLists'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $list                       = AssetDifference::find($id);
        $list->asset_id             = request()->form['asset_id'];
        $list->policy_set_header_id = request()->form['policy_set_header_id'];
        $list->last_updated_by      = $user->user_id;
        $list->save();

        $data['status'] = 'S';
        $data['msg'] = '';

        return response()->json($data);
    }
}
