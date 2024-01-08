<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class InvMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 110000 and  120000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 110000 and menu_id <= 120000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 110000 and menu_id <= 120000")->delete();

        $menu1 = [
            [
                'menu_id' => 110000,
                'menu_title' => 'รายการเบิกจ่ายเครื่องเขียน', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 110000
            ],
            [
                'menu_id' => 110001,
                'menu_title' => 'รายการเบิกจ่ายน้ำมัน', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 110001
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 110002,
                'parent_id' => 110000,
                'menu_title' => '1.1 ค้นหารายการเบิก',
                'program_code' => 'INP0001',
                'url' => '/inv/requisition_stationery'
            ],
            [
                'menu_id' => 110003,
                'parent_id' => 110000,
                'menu_title' => '1.2 ขอเบิกเครื่องเขียน',
                'program_code' => 'INP0002',
                'url' => '/inv/requisition_stationery/create'
            ],
            [
                'menu_id' => 110004,
                'parent_id' => 110000,
                'menu_title' => 'INP0003: 1.3 รายงาน',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 110005,
                'parent_id' => 110001,
                'menu_title' => '2.1. สรุปรายการเบิกจ่ายน้ำมัน',
                'program_code' => 'INP0004',
                'url' => '/inv/disbursement_fuel'
            ],
            [
                'menu_id' => 110006,
                'parent_id' => 110001,
                'menu_title' => '2.2. เบิกจ่ายน้ำมันสำหรับองค์กร',
                'program_code' => 'INP0004',
                'url' => '/inv/disbursement_fuel/create'
            ],
            [
                'menu_id' => 110007,
                'parent_id' => 110001,
                'menu_title' => '2.3. ข้อมูลรถยนต์ใหม่',
                'program_code' => 'INP0003',
                'url' => '/inv/disbursement_fuel/add_new_car'
            ],
            [
                'menu_id' => 110008,
                'parent_id' => 110001,
                'menu_title' => '2.4. ค้นหาข้อมูลรถยนต์',
                'program_code' => 'INP0004',
                'url' => '/inv/disbursement_fuel/show'
            ],
            [
                'menu_id' => 110015,
                'parent_id' => 110001,
                'menu_title' => 'ข้อมูลกลุ่มเครื่องจักรเบ็ดเตล็ด',
                'program_code' => 'INP0004',
                'url' => '/inv/disbursement_fuel/add_non_fa'
            ],
            [
                'menu_id' => 110009,
                'parent_id' => 110001,
                'menu_title' => '2.5. ปริ๊นรายงาน',
                'program_code' => '',
                'url' => '#'
            ],
        ];

        $menu3 = [
            [
                'menu_id' => 110010,
                'parent_id' => 110004,
                'menu_title' => 'รายงานประวัติสั่งซื้อย้อนหลัง',
                'program_code' => '',
                'url' => '/inv/requisition_stationery/order-history-report'
            ],
            [
                'menu_id' => 110011,
                'parent_id' => 110004,
                'menu_title' => 'รายงานสรุปการเบิกจ่ายเครื่องเขียน/เบ็ดเตล็ด (ตามราย item)',
                'program_code' => '',
                'url' => '/inv/requisition_stationery/summary-web-stationery-report'
            ],
            [
                'menu_id' => 110012,
                'parent_id' => 110009,
                'menu_title' => 'รายงานยอดจ่ายน้ำมันเชื่อเพลิง',
                'program_code' => 'INP0004',
                'url' => '/inv/disbursement_fuel/fuel-supply-report'
            ],

            [
                'menu_id' => 110013,
                'parent_id' => 110009,
                'menu_title' => 'รายงานยอดการใช้น้ำมันรถยนต์ส่วนกลาง',
                'program_code' => 'INP0004',
                'url' => '/inv/disbursement_fuel/oil-consumption-public-car-report'
            ],
            [
                'menu_id' => 110014,
                'parent_id' => 110009,
                'menu_title' => 'รายงานยอดจ่ายน้ำมันเชื้อเพลิงตามค่าใช้จ่าย',
                'program_code' => 'INP0004',
                'url' => '/inv/disbursement_fuel/fuel-payment-summary-report'
            ],
            [
                'menu_id' => 110016,
                'parent_id' => 110009,
                'menu_title' => 'รายงานสรุปยอดจ่ายน้ำมันตามประเภท',
                'program_code' => 'INP0004',
                'url' => '/inv/disbursement_fuel/summary-fuel-type-report'
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

        $this->newRole(110000);
        $this->newRole2(110001);
        $this->newRole3(110002);

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
                    ->whereRaw("menu_id between 110000 and  120000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            '/inv/requisition_stationery',
            '/inv/requisition_stationery/create',
            '/inv/disbursement_fuel',
            '/inv/disbursement_fuel/create',
            '/inv/disbursement_fuel/add_new_car',
            '/inv/disbursement_fuel/show',
            '/inv/disbursement_fuel/add_non_fa',
            '/inv/disbursement_fuel/print',
            '/inv/requisition_stationery/order-history-report',
            '/inv/requisition_stationery/summary-web-stationery-report',
            '/inv/disbursement_fuel/fuel-supply-report',
            '/inv/disbursement_fuel/oil-consumption-public-car-report',
            '/inv/disbursement_fuel/fuel-payment-summary-report',
            '/inv/disbursement_fuel/summary-fuel-type-report'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'INV:ALL', 'INV', $menus);
    }

    public function newRole2($roleId)
    {
        $menus = [
            '/inv/requisition_stationery',
            '/inv/requisition_stationery/create',
            '/inv/requisition_stationery/order-history-report',
            '/inv/requisition_stationery/summary-web-stationery-report',
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'INV: เบิกจ่ายเครื่องเขียน', 'INV', $menus);
    }

    public function newRole3($roleId)
    {
        $menus = [
            '/inv/disbursement_fuel',
            '/inv/disbursement_fuel/create',
            '/inv/disbursement_fuel/add_new_car',
            '/inv/disbursement_fuel/show',
            '/inv/disbursement_fuel/add_non_fa',
            '/inv/disbursement_fuel/print',
            '/inv/disbursement_fuel/fuel-supply-report',
            '/inv/disbursement_fuel/oil-consumption-public-car-report',
            '/inv/disbursement_fuel/fuel-payment-summary-report',
            '/inv/disbursement_fuel/summary-fuel-type-report'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'INV: เบิกจ่ายน้ำมัน', 'INV', $menus);
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
