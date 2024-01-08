<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IE\HierarchyTypeStoreRequest;

use App\Models\IE\HierarchyPosition;
use App\Models\IE\HierarchyNamePosition;

class HierarchyPositionController extends Controller
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
        $positions = HierarchyPosition::when(!!$search, function($q) use($search){
            return $q->whereRaw("upper(name) like upper(?)", ["%{$search}%"]);
        })->orderBy('hierarchy_position_id')->get();

        return view('ie.settings.hierarchy.position.index', compact(
            'positions'
        ));
    }

    public function store(HierarchyTypeStoreRequest $request)
    {
        try {

            $position = new HierarchyPosition;
            $position->name = $request->name;
            $position->created_by = getDefaultData()->user_id;
            $position->last_updated_by = getDefaultData()->user_id;
            $position->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-position.index')->with('success', 'Create Hierarchy Position Success.');
    }

    public function formEdit(Request $request, $positionId)
    {
        $position = HierarchyPosition::findOrFail($positionId);

        return view('ie.settings.hierarchy.position._form_edit', compact(
            'position'
        ));
    }

    public function update(HierarchyTypeStoreRequest $request, $positionId)
    {
        try {

            $position = HierarchyPosition::findOrFail($positionId);
            $position->name = $request->name;
            $position->last_updated_by = getDefaultData()->user_id;
            $position->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-position.index')->with('success', 'Edit Hierarchy Position Success.');
    }

    public function destroy(Request $request, $positionId)
    {
        try {

            $position = HierarchyPosition::findOrFail($positionId);

            $checkUse = HierarchyNamePosition::where('hierarchy_position_id', $positionId)->first();
            if(!!$checkUse){
                return redirect()->back()->withErrors('มีการใช้งาน Hierarchy Position นี้อยู่');
            }

            $positionUsers = $position->positionUsers;
            if(count($positionUsers)){
                foreach ($positionUsers as $key => $positionUser) {
                    $positionUser->delete();
                }
            }
            $position->delete();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-position.index')->with('success', 'Remove Hierarchy Position Success.');
    }
}
