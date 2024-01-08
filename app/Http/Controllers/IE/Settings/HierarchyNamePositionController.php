<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\IE\HierarchyName;
use App\Models\IE\HierarchyPosition;
use App\Models\IE\HierarchyNamePosition;
use App\Models\IE\CashAdvance;
use App\Models\IE\Reimbursement;

class HierarchyNamePositionController extends Controller
{
    protected $orgId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->orgId = getDefaultData()->bu_id;
            $this->orgId = 81;
            return $next($request);
        });
    }

    public function index(Request $request, $nameId)
    {
        $hierarchy = HierarchyName::findOrFail($nameId);
        $positions = HierarchyPosition::orderBy('hierarchy_position_id')->get();

        return view('ie.settings.hierarchy.name.position.index', compact(
            'hierarchy',
            'positions'
        ));
    }

    public function store(Request $request, $nameId)
    {
        $validator = Validator::make($request->all(),
        [
            'seq' => [
                'required',
                'integer',
                Rule::unique('ptw_hierarchy_name_positions')->where(function ($query) use ($nameId) {
                    return $query->where('hierarchy_name_id', $nameId);
                })
            ],
            'hierarchy_position_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $namePosition = new HierarchyNamePosition;
            $namePosition->hierarchy_name_id = $nameId;
            $namePosition->seq = $request->seq;
            $namePosition->hierarchy_position_id = $request->hierarchy_position_id;
            $namePosition->created_by = getDefaultData()->user_id;
            $namePosition->last_updated_by = getDefaultData()->user_id;
            $namePosition->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-name.position.index', $nameId)->with('success', 'Create Hierarchy Sequence Success.');
    }

    public function formEdit(Request $request, $nameId, $namePositionId)
    {
        $hierarchy = HierarchyName::findOrFail($nameId);
        $namePosition = HierarchyNamePosition::findOrFail($namePositionId);
        $positions = HierarchyPosition::orderBy('hierarchy_position_id')->get();

        return view('ie.settings.hierarchy.name.position._form_edit', compact(
            'nameId',
            'hierarchy',
            'namePosition',
            'positions',
        ));
    }

    public function update(Request $request, $nameId, $namePositionId)
    {
        $validator = Validator::make($request->all(),
        [
            'seq' => [
                'required',
                'integer',
                Rule::unique('ptw_hierarchy_name_positions')->where(function ($query) use ($nameId) {
                    return $query->where('hierarchy_name_id', $nameId);
                })->ignore($namePositionId, 'hierarchy_name_position_id')
            ],
            'hierarchy_position_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $namePosition = HierarchyNamePosition::findOrFail($namePositionId);
            $namePosition->seq = $request->seq;
            $namePosition->hierarchy_position_id = $request->hierarchy_position_id;
            $namePosition->last_updated_by = getDefaultData()->user_id;
            $namePosition->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-name.position.index', $nameId)->with('success', 'Edit Hierarchy Sequence Success.');
    }

    public function destroy(Request $request, $nameId, $namePositionId)
    {
        try {

            $checkCaUse = CashAdvance::where('hierarchy_name_id', $nameId)->where('hierarchy_name_position_id', $namePositionId)->first();
            $checkReUse = Reimbursement::where('hierarchy_name_id', $nameId)->where('hierarchy_name_position_id', $namePositionId)->first();

            if(!!$checkCaUse || !!$checkReUse){
                return redirect()->back()->withErrors('มีการใช้งานสายอนุมัตินี้อยู่');
            }

            $namePosition = HierarchyNamePosition::findOrFail($namePositionId);
            $namePosition->delete();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-name.position.index', $nameId)->with('success', 'Remove Hierarchy Sequence Success.');
    }
}
