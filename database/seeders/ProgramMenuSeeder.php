<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class ProgramMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 90001 and 91000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 90001 and menu_id <= 91000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 90001 and menu_id <= 91000")->delete();

        $menu1 = [
            [
                'menu_id' => 90001,
                'menu_title' => 'Program', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 90001
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 90002,
                'parent_id' => 90001,
                'menu_title' => 'Prompt',
                'program_code' => '-1',
                'url' => '/set-up'
            ],
            [
                'menu_id' => 90003,
                'parent_id' => 90001,
                'menu_title' => 'Program Type',
                'program_code' => '-1',
                'url' => '/program/type'
            ],
            [
                'menu_id' => 90004,
                'parent_id' => 90001,
                'menu_title' => 'Program Info',
                'program_code' => '-1',
                'url' => '/program/info'
            ],
        ];

        foreach ($menu1 as $menu) {
            $this->createMenu($menu);
        }
        foreach ($menu2 as $menu) {
            $this->createMenu($menu);
        }

        $this->newRole(90001);

    }
    public function createMenu($menu)
    {
        $data = $menu;
        $data['sort_order'] = $menu['menu_id'];
        $data['menu_title'] = trim($menu['menu_title']);
        $data['server_id'] = 1;
        $data['last_updated_by'] = -1;
        $data['created_by'] = -1;
        $data['permission_code'] = $menu['menu_id'];
        $data['url'] = \Arr::get($menu, 'url', '');

        if ($data['url'] == '') {
            $data['url'] = '#';
        }

        $newData = \App\Models\Menu::create($data);
        $permEnter = new Permission;
        $permEnter->name = $newData->permission_code . '_ENTER';
        $permView = new Permission;
        $permView->name = $newData->permission_code . '_VIEW';
        $newData->permissions()->save($permEnter);
        $newData->permissions()->save($permView);
    }

    public function getMenus($arrUrl)
    {
        $menus = \App\Models\Menu::whereIn('url', $arrUrl)
                    ->whereRaw("menu_id between 90001 and 91000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            '/set-up',
            '/program/type',
            '/program/info'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'Program', 'PROG', $menus);
    }

    public function createRole($roleId, $roleName, $moduleName, $menus)
    {
        \DB::table('ptw_role_permission')->where('role_id', $roleId)->delete();
        $role = Role::find($roleId);
        if (!$role) {
            $role = new Role;
        }

        $role->role_id = $roleId;
        $role->module_name = $moduleName;
        $role->name = $roleName;
        $role->created_by_id = -1;
        $role->updated_by_id = -1;
        $role->save();

        foreach ($menus as $key => $menu) {
            $permissions = $menu->permissions;
            foreach ($permissions as $key => $permission) {
                $role->assignPermission($permission);
            }
        }
    }
}
