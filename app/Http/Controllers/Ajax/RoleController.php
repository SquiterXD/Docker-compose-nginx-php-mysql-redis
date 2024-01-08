<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getMenuByModule()
    {
        $data = (new \App\Models\Menu)->menuByModule(request()->module ?? 'OM');
        $data = (new \App\Models\Menu)->mappingChildrenMenu($data);

        return response()->json(['data' => $data]);
    }

    public function getPermission()
    {
        $roleId = request()->role_id;
        $role = \App\Models\Role::findOrFail($roleId);
        $data = optional($role)->permissions ?? [];

        return response()->json(['data' => $data]);
    }


    public function store()
    {
        $user = auth()->user();
        $role = new Role;
        $role->module_name = request()->module_name;
        $role->name = request()->role_name;
        $role->created_by_id = $user->user_id;
        $role->updated_by_id = $user->user_id;
        $role->save();

        $permissionList = array_keys(request()->permission_list ?? []);
        $permissions = Permission::whereIn('permission_id', $permissionList)->get();

        $role->refresh();
        foreach ($permissions as $key => $permission) {
            $role->assignPermission($permission);
        }

        $data = [
            'status' => 'S'
        ];

        return response()->json(['data' => $data]);
    }

    public function assignPermission(Role $role)
    {
        try {
            \DB::beginTransaction();

                $permission = Permission::find(request()->permission_id);

                if(request()->is_checked === true && !$role->hasPermission($permission)){
                    $role->assignPermission($permission);
                }elseif(request()->is_checked === false && $role->hasPermission($permission)) {
                    $role->dismissPermission($permission);
                }

            \DB::commit();
            $data = [
                'status' => 'S',
                'message' => '',
            ];
        } catch (\Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json(['data' => $data]);
    }


    public function update(Role $role)
    {
        $role->name = request()->role_name;
        $role->updated_at = now();
        $role->save();

        $data = [
            'status' => 'S'
        ];
        return response()->json(['data' => $data]);
    }
}
