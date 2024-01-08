<?php

namespace App\Http\Controllers\Planning\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\Setup\PPS0011V;

// New Reuirement 22072022
class PPS0011Controller extends Controller
{
    public function index()
    {
        $profile = getDefaultData('/planning/setup/pps0011');
        $pps0011 = PPS0011V::orderByRaw('item_number, cigarette_code')->get();

        return view('planning.setup.pps0011.index', compact('profile', 'pps0011'));
    }

    public function show($item_id, $formula_no)
    {
        $profile = getDefaultData('/planning/setup/pps0011');
        $pps0011 = PPS0011V::where('inventory_item_id', $item_id)->where('formula_no', $formula_no)->first();

        return view('planning.setup.pps0011.show', compact('profile', 'pps0011'));
    }

    public function update(Request $request, $item_id, $formula_no)
    {
        $data = $request;
        $pps0011 = PPS0011V::where('inventory_item_id', $item_id)->where('formula_no', $formula_no)->first();
        $result = (new PPS0011V)->callPackageUpdatePPS0011($data, $pps0011, $item_id);

        if ( $result['status'] == 'C') {
            return redirect()->route('planning.setup.pps0011.index')->with('success', 'ทำการอัพเดตม้วนแสตมป์เรียบร้อยแล้ว');
        }
        return redirect()->back()->withInput()->with('error', $result['msg']);
    }
}
