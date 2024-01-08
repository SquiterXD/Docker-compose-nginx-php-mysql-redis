<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class IeMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 60000 and  70000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 60000 and menu_id <= 70000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 60000 and menu_id <= 70000")->delete();

        $menu1 = [
            [
                'menu_id' => 60000,
                'menu_title' => 'IExpense', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 60000
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 60001,
                'parent_id' => 60000,
                'menu_title' => 'Reimbursement',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 60002,
                'parent_id' => 60000,
                'menu_title' => 'Cash-Advance',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 60003,
                'parent_id' => 60000,
                'menu_title' => 'Report',
                'program_code' => '',
                'url' => '/ie/report'
            ],
            [
                'menu_id' => 60004,
                'parent_id' => 60000,
                'menu_title' => 'Setting',
                'program_code' => '-1',
                'url' => '#'
            ],
        ];

        $menu3 = [
            [
                'menu_id' => 60005,
                'parent_id' => 60001,
                'menu_title' => 'My Pending Activity',
                'program_code' => 'IEP0001',
                'url' => '/ie/reimbursements/pending'
            ],
            [
                'menu_id' => 60006,
                'parent_id' => 60001,
                'menu_title' => 'My Request',
                'program_code' => 'IEP0002',
                'url' => '/ie/reimbursements'
            ],
            [
                'menu_id' => 60007,
                'parent_id' => 60002,
                'menu_title' => 'My Pending Activity',
                'program_code' => 'IEP0003',
                'url' => '/ie/cash-advances/pending'
            ],
            [
                'menu_id' => 60008,
                'parent_id' => 60002,
                'menu_title' => 'My Request',
                'program_code' => 'IEP0004',
                'url' => '/ie/cash-advances'
            ],
            [
                'menu_id' => 60009,
                'parent_id' => 60004,
                'menu_title' => 'Category',
                'program_code' => 'IEM0001',
                'url' => '/ie/settings/categories'
            ],
            [
                'menu_id' => 60010,
                'parent_id' => 60004,
                'menu_title' => 'Locations',
                'program_code' => 'IEM0002',
                'url' => '/ie/settings/locations'
            ],
            [
                'menu_id' => 60011,
                'parent_id' => 60004,
                'menu_title' => 'Preferences',
                'program_code' => 'IEM0003',
                'url' => '/ie/settings/preferences'
            ],
            [
                'menu_id' => 60012,
                'parent_id' => 60004,
                'menu_title' => 'User Bank Accounts',
                'program_code' => 'IEM0004',
                'url' => '/ie/settings/user-accounts'
            ],
            [
                'menu_id' => 60013,
                'parent_id' => 60004,
                'menu_title' => 'Hierarchy',
                'program_code' => 'IEM0005',
                'url' => '/ie/settings/hierarchy'
            ],
        ];


        foreach ($menu1 as $menu) {
            $this->createMenu($menu);
        }
        foreach ($menu2 as $menu) {
            $this->createMenu($menu);
        }

        foreach ($menu3 as $menu) {
            $this->createMenu($menu);
        }

        $this->newRole(60000);

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
                    ->whereRaw("menu_id between 60000 and  70000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            '/ie/reimbursements/pending',
            '/ie/reimbursements',
            '/ie/cash-advances/pending',
            '/ie/cash-advances',
            '/ie/report',
            '/ie/settings/categories',
            '/ie/settings/locations',
            '/ie/settings/preferences',
            '/ie/settings/user-accounts',
            '/ie/settings/hierarchy',
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'IExpense', 'IE', $menus);
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
