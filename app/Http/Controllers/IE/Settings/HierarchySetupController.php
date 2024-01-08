<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\IE\FNDChildListOfValues;
use App\Models\IE\HierarchyTopic;
use App\Models\IE\HierarchyType;
use App\Models\IE\HierarchyName;
use App\Models\IE\HierarchySetup;

class HierarchySetupController extends Controller
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
        $type = null;
        $department = null;
        $hierarchy = null;

        if($search){
            if( array_key_exists('type', $search) ){
                $type = strtoupper($search['type']);
            }
            if( array_key_exists('department', $search) ){
                $department = strtoupper($search['department']);
            }
            if( array_key_exists('hierarchy', $search) ){
                $hierarchy = strtoupper($search['hierarchy']);
            }
        }

        $groupDepartment = HierarchySetup::when(!!$type, function($q) use($type){
            return $q->whereRaw("hierarchy_type_id = ?", [$type]);
        })
        ->when(!!$department, function($q) use($department){
            return $q->whereRaw("upper(department_code) = ?", [$department]);
        })
        ->when(!!$hierarchy, function($q) use($hierarchy){
            return $q->whereRaw("hierarchy_name_id = ?", [$hierarchy]);
        })
        ->orderBy('department_code')
        ->get()
        ->groupBy(function ($item) {
            $department = $item->department;
            return $department ? $department->value_code.' : '.$department->description : '-';
        });

        $hierarchyTypes = HierarchyType::orderBy('hierarchy_type_id')->get();

        $nameLists = HierarchyName::orderBy('name')->get();

        $departmentLists = FNDChildListOfValues::select(\DB::raw("value_code || ' : ' || description AS full_description"),'value_code')
        ->department()
        ->parent()
        ->orderBy('value_code')
        ->pluck('full_description','value_code')
        ->all();

        return view('ie.settings.hierarchy.setup.index', compact(
            'groupDepartment',
            'search',
            'hierarchyTypes',
            'nameLists',
            'departmentLists'
        ));
    }

    public function create(Request $request)
    {
        $hierarchyTypes = HierarchyType::orderBy('hierarchy_type_id')->get();
        if(!count($hierarchyTypes)){
            return redirect()->back()->withErrors('กรุณาสร้าง Hierarchy Type');
        }

        $topicLists = HierarchyTopic::orderBy('name')->get();
        if(!count($topicLists)){
            return redirect()->back()->withErrors('กรุณาสร้าง Hierarchy Topic');
        }

        $nameLists = HierarchyName::orderBy('name')->get();
        if(!count($nameLists)){
            return redirect()->back()->withErrors('กรุณาสร้างสายอนุมัติ');
        }

        $departmentLists = FNDChildListOfValues::select(\DB::raw("value_code || ' : ' || description AS full_description"),'value_code')
            ->department()
            ->parent()
            ->orderBy('value_code')
            ->pluck('full_description','value_code')
            ->all();

        $setup = new HierarchySetup;
        $setup->active = 1;

        return view('ie.settings.hierarchy.setup.create', compact(
            'hierarchyTypes',
            'topicLists',
            'nameLists',
            'departmentLists',
            'setup',
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hierarchy_topic_id' => 'required|integer',
            'hierarchy_type_id' => 'required|integer',
            'hierarchy_name_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $type = HierarchyType::findOrFail($request->hierarchy_type_id);
            if($type->department_flag && !$request->department_code){
                return redirect()->back()->withErrors('กรุณาเลือก department code');
            }

            $setup = new HierarchySetup;
            $setup->hierarchy_topic_id = $request->hierarchy_topic_id;
            $setup->hierarchy_type_id = $request->hierarchy_type_id;
            $setup->hierarchy_name_id = $request->hierarchy_name_id;
            $setup->department_code = $request->department_code;
            $setup->created_by = getDefaultData()->user_id;
            $setup->last_updated_by = getDefaultData()->user_id;
            $setup->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-setup.index')->with('success', 'Create Hierarchy Setup Success.');
    }

    public function edit(Request $request, $setupId)
    {
        $hierarchyTypes = HierarchyType::orderBy('hierarchy_type_id')->get();
        if(!count($hierarchyTypes)){
            return redirect()->back()->withErrors('กรุณาสร้าง Hierarchy Type');
        }

        $topicLists = HierarchyTopic::orderBy('name')->get();
        if(!count($topicLists)){
            return redirect()->back()->withErrors('กรุณาสร้าง Hierarchy Topic');
        }

        $nameLists = HierarchyName::orderBy('name')->get();
        if(!count($nameLists)){
            return redirect()->back()->withErrors('กรุณาสร้างสายอนุมัติ');
        }

        $departmentLists = FNDChildListOfValues::select(\DB::raw("value_code || ' : ' || description AS full_description"),'value_code')
            ->department()
            ->parent()
            ->orderBy('value_code')
            ->pluck('full_description','value_code')
            ->all();
        $setup = HierarchySetup::findOrFail($setupId);

        return view('ie.settings.hierarchy.setup.edit', compact(
            'hierarchyTypes',
            'topicLists',
            'nameLists',
            'departmentLists',
            'setup',
        ));
    }

    public function update(Request $request, $setupId)
    {

        $validator = Validator::make($request->all(), [
            'hierarchy_topic_id' => 'required|integer',
            'hierarchy_name_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $setup = HierarchySetup::findOrFail($setupId);
            $type = $setup->type;
            if($type->department_flag && !$request->department_code){
                return redirect()->back()->withErrors('กรุณาเลือก department code');
            }

            $setup->hierarchy_topic_id = $request->hierarchy_topic_id;
            $setup->hierarchy_name_id = $request->hierarchy_name_id;
            $setup->department_code = $request->department_code;
            $setup->last_updated_by = getDefaultData()->user_id;
            $setup->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-setup.index')->with('success', 'Edit Hierarchy Success.');
    }

    public function destroy(Request $request, $setupId)
    {
        try {
            $setup = HierarchySetup::findOrFail($setupId);
            $setup->delete();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-setup.index')->with('success', 'Edit Hierarchy Success.');
    }
}
