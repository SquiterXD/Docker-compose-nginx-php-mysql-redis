<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\IE\HierarchyPosition;
use App\Models\IE\HierarchyPositionUser;

class HierarchyPositionUserController extends Controller
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

    public function formCreate(Request $request, $positionId)
    {
        $users = User::get();
        $position = HierarchyPosition::findOrFail($positionId);
        $setDefault = !$position->positionUsers->count();

        return view('ie.settings.hierarchy.position.user._form_create', compact(
            'users',
            'setDefault',
            'positionId'
        ));
    }

    public function store(Request $request, $positionId)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $position = HierarchyPosition::findOrFail($positionId);
            $positionUsers = $position->positionUsers;
            if($positionUsers->count()){
                if($request->default_flag){
                    foreach ($positionUsers as $key => $positionUser) {
                        $positionUser->default_flag = false;
                        $positionUser->last_updated_by = getDefaultData()->user_id;
                        $positionUser->save();
                    }
                }
            }

            $positionUser = new HierarchyPositionUser;
            $positionUser->hierarchy_position_id = $positionId;
            $positionUser->user_id = $request->user_id;
            $positionUser->default_flag = $positionUsers->count() ? ($request->default_flag ? true : false) : true;
            $positionUser->created_by = getDefaultData()->user_id;
            $positionUser->last_updated_by = getDefaultData()->user_id;
            $positionUser->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-position.index')->with('success', 'Create User Success.');
    }

    public function setDefault(Request $request, $positionId, $positionUserId)
    {
        try {
            $position = HierarchyPosition::findOrFail($positionId);
            foreach ($position->positionUsers as $positionUser) {
                $positionUser->default_flag = false;
                $positionUser->last_updated_by = getDefaultData()->user_id;
                $positionUser->save();
            }

            $positionUser = HierarchyPositionUser::findOrFail($positionUserId);
            $positionUser->default_flag = true;
            $positionUser->last_updated_by = getDefaultData()->user_id;
            $positionUser->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-position.index')->with('success', 'Set Default Success.');
    }

    public function destroy(Request $request, $positionId, $positionUserId)
    {
        try {
            $positionUser = HierarchyPositionUser::findOrFail($positionUserId);
            $positionUser->delete();

            $position = HierarchyPosition::findOrFail($positionId);

            $found = $position->positionUsers()->where('default_flag', true)->first();
            if(!$found){
                if($position->positionUsers->count()){
                    $positionUser = $position->positionUsers()->first();
                    $positionUser->default_flag = true;
                    $positionUser->last_updated_by = getDefaultData()->user_id;
                    $positionUser->save();
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-position.index')->with('success', 'Remove User Success.');
    }
}
