<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IE\HierarchyNameStoreRequest;
use App\Models\IE\CashAdvance;
use App\Models\IE\HierarchyName;
use App\Models\IE\Reimbursement;

class HierarchyNameController extends Controller
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

    public function index(Request $request)
    {
        $search = $request->search;
        $hierarchies = HierarchyName::when(!!$search, function($q) use($search){
            return $q->whereRaw("upper(name) like upper(?)", ["%{$search}%"]);
        })->orderBy('hierarchy_name_id')->get();

        return view('ie.settings.hierarchy.name.index', compact(
            'hierarchies'
        ));
    }

    public function store(HierarchyNameStoreRequest $request)
    {
        try {

            $hierarchy = new HierarchyName;
            $hierarchy->name = $request->name;
            $hierarchy->created_by = getDefaultData()->user_id;
            $hierarchy->last_updated_by = getDefaultData()->user_id;
            $hierarchy->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-name.index')->with('success', 'Create Hierarchy Success.');
    }

    public function formEdit(Request $request, $nameId)
    {
        $hierarchy = HierarchyName::findOrFail($nameId);

        return view('ie.settings.hierarchy.name._form_edit', compact(
            'nameId',
            'hierarchy'
        ));
    }

    public function update(HierarchyNameStoreRequest $request, $nameId)
    {
        try {

            $hierarchy = HierarchyName::findOrFail($nameId);
            $hierarchy->name = $request->name;
            $hierarchy->last_updated_by = getDefaultData()->user_id;
            $hierarchy->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-name.index')->with('success', 'Edit Hierarchy Success.');
    }

    public function destroy(Request $request, $nameId)
    {
        try {

            $hierarchy = HierarchyName::findOrFail($nameId);

            $checkCaUse = CashAdvance::where('hierarchy_name_id', $nameId)->first();
            $checkReUse = Reimbursement::where('hierarchy_name_id', $nameId)->first();

            if(!!$checkCaUse || !!$checkReUse){
                return redirect()->back()->withErrors('มีการใช้งานสายอนุมัตินี้อยู่');
            }

            $namePositions = $hierarchy->namePositions;
            if(count($namePositions)){
                foreach ($namePositions as $key => $namePosition) {
                    $namePosition->delete();
                }
            }
            $hierarchy->delete();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-name.index')->with('success', 'Remove Hierarchy Success.');
    }
}
