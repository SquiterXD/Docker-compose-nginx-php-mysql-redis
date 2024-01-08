<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IE\HierarchyTypeStoreRequest;

use App\Models\IE\HierarchyType;
use App\Models\IE\HierarchySetup;

class HierarchyTypeController extends Controller
{

    public function index(Request $request)
    {
        $types = HierarchyType::orderBy('hierarchy_type_id')->get();

        return view('ie.settings.hierarchy.type.index', compact(
            'types'
        ));
    }

    public function store(HierarchyTypeStoreRequest $request)
    {
        try {
            $type = new HierarchyType;
            $type->name = $request->name;
            $type->department_flag = $request->department_flag ? true : false;
            $type->last_updated_by = getDefaultData()->user_id;
            $type->created_by = getDefaultData()->user_id;
            $type->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-type.index')->with('success', 'Create Hierarchy Type Success.');
    }

    public function formEdit(Request $request, $typeId)
    {
        $type = HierarchyType::findOrFail($typeId);

        return view('ie.settings.hierarchy.type._form_edit', compact(
            'type',
        ));
    }

    public function update(HierarchyTypeStoreRequest $request, $typeId)
    {
        try {

            $type = HierarchyType::findOrFail($typeId);
            $type->name = $request->name;
            $type->last_updated_by = getDefaultData()->user_id;
            $type->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-type.index')->with('success', 'Edit Hierarchy Type Success.');
    }

    public function destroy($typeId)
    {
        try {
            $type = HierarchyType::findOrFail($typeId);

            $checkUse = HierarchySetup::where('hierarchy_type_id', $typeId)->first();
            if(!!$checkUse){
                return redirect()->back()->withErrors('มีการใช้งาน Hierarchy Type นี้อยู่');
            }

            $type->delete();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-type.index')->with('success', 'Remove Hierarchy Type Success.');
    }
}
