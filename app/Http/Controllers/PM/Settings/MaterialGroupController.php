<?php

namespace App\Http\Controllers\PM\Settings;

use App\Models\Example\User;
use App\Models\PM\Settings\CoaDeptCodeV;
use App\Models\PM\Settings\ItemcatMatGroupV;
use App\Models\PM\Settings\MaterialGroup;
use App\Models\PM\Settings\RelationFeeder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialGroupController extends Controller
{
    public function index()
    {
        $materialGroups = MaterialGroup::all();       

        return view('pm.settings.material-group.index',compact('materialGroups'));
    }

    public function create()
    {
        $departments = CoaDeptCodeV::all();

        $materialGroups = ItemcatMatGroupV::where('group_code', '10')
                                                ->get();

        return view('pm.settings.material-group.create',compact('departments','materialGroups'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $userId = optional(auth()->user())->user_id ?? -1;

        $data = $request->validate([
            'dept_code' => 'required',
            'itemcat_group_code' => 'required',
        ], [
            'dept_code.required' => 'โปรดใส่รหัสแผนก',
            'itemcat_group_code.required' => 'โปรดใส่รหัส'
        ]);

        $checkDuplicateData = MaterialGroup::where('dept_code', $request->dept_code)
                                        ->where('itemcat_group_code',  $request->itemcat_group_code)
                                        ->first();

        if($checkDuplicateData){
            return redirect()->back()->with('error','มีกลุ่มวัตถุดิบใบยาอยู่แล้ว');
        }

        $data['created_by_id'] = $userId;
        $data['dept_code'] = $request->dept_code;
        $data['itemcat_group_code'] = $request->itemcat_group_code;

        MaterialGroup::create($data);

        return redirect()->route('pm.settings.material-group.index')->with('success','ทำการเพิ่มกลุ่มวัตถุดิบใบยาเรียบร้อยแล้ว');
    }

}
