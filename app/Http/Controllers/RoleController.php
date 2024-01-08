<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ProgramInfo;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $search = request()->search ?? [];
        $roles = Role::orderBy('module_name')->orderBy('name')->get();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $role = new Role;
        $moduleList = $this->getModuleList();
        return view('roles.create', compact('role', 'moduleList'));
    }

    public function edit(Role $role)
    {
        $moduleList = $this->getModuleList();
        return view('roles.edit', compact('role', 'moduleList'));
    }

    public function getModuleList()
    {
        $moduleList = ProgramInfo::selectRaw("distinct module_name")->get()
                        ->pluck('module_name', 'module_name')
                        ->all();
        return $moduleList;
    }
}
