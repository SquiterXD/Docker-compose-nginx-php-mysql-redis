<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class CtMenuSeederBackup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 150000 and  160000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 150000 and menu_id <= 160000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 150000 and menu_id <= 160000")->delete();

        $menu1 = [
            [
                'menu_id' => 150000,
                'menu_title' => 'Costing', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 150000
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 150001,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดศูนย์ต้นทุน',
                'program_code' => 'Ct-1',
                'url' => '/ct/cost_center'
            ],
            [
                'menu_id' => 150002,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดกลุ่มผลิตภัณฑ์',
                'program_code' => 'Ct-3',
                'url' => '/ct/product_group'
            ],
            [
                'menu_id' => 150003,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดประเภทบัญชี',
                'program_code' => 'Ct-4',
                'url' => '/ct/set_account_type'
            ],
            [
                'menu_id' => 150004,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดเปอร์เซ็นเทียบสำเร็จ',
                'program_code' => 'Ct-5',
                'url' => '/ct/specify_percentage'
            ],
            [
                'menu_id' => 150005,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดรหัสบัญชีเพื่อการเชื่อมโยงไประบบบัญชีแยกประเภททั่วไป',
                'program_code' => 'Ct-6',
                'url' => '/ct/account_code_ledger'
            ],
            [
                'menu_id' => 150006,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดปริมาณผลผลิตตามแผน',
                'program_code' => 'Ct-9',
                'url' => '/ct/product_plan_amount'
            ],
            [
                'menu_id' => 150007,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดหน่วยงาน',
                'program_code' => 'Ct-10',
                'url' => '/ct/specify_agency'
            ],
            [
                'menu_id' => 150008,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดรหัสเกณฑ์การปันส่วน',
                'program_code' => 'Ct-11',
                'url' => '/ct/criterion_allocate'
            ],
            [
                'menu_id' => 150009,
                'parent_id' => 150000,
                'menu_title' => 'นำเข้าข้อมูลราคาซื้อ',
                'program_code' => 'Ct-12',
                'url' => '/ct/purchase_price_info'
            ],
            [
                'menu_id' => 150010,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดรหัสภาษีใบยา',
                'program_code' => 'Ct-13',
                'url' => '/ct/tax_medicine'
            ],
            [
                'menu_id' => 150011,
                'parent_id' => 150000,
                'menu_title' => 'ต้นทุนวัตถุดิบมาตรฐาน',
                'program_code' => 'Ct-14',
                'url' => '/ct/std_raw_material_cost'
            ],
            // [
            //     'menu_id' => 150012,
            //     'parent_id' => 150000,
            //     'menu_title' => 'กำหนดเกณฑ์การปันส่วน',
            //     'program_code' => 'CTP0008',
            //     'url' => '/ct/allocate-ratios'
            // ],
            [
                'menu_id' => 150013,
                'parent_id' => 150000,
                'menu_title' => 'ประมวลผลข้อมูลคำสั่งผลิต',
                'program_code' => 'CTP0101',
                'url' => '/ct/workorders/processes'
            ],
            [
                'menu_id' => 150014,
                'parent_id' => 150000,
                'menu_title' => 'รายงาน',
                'program_code' => '',
                'url' => '/report/report-info'
            ],
            [
                'menu_id' => 150015,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดเกณฑ์การปันส่วน',
                'program_code' => 'CTM0008',
                'url' => '/ct/allocate-ratios'
            ],
            [
                'menu_id' => 150016,
                'parent_id' => 150000,
                'menu_title' => 'ต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต',
                'program_code' => 'CTM0015',
                'url' => '/ct/std-costs'
            ],

            //Lookup
            [
                'menu_id' => 150017,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดประเภทบัญชี',
                'program_code' => 'CTS0001',
                'url' => '/lookup?programCode=CTS0001'
            ],
            [
                'menu_id' => 150018,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดรหัสเกณฑ์การปันส่วน',
                'program_code' => 'CTS0002',
                'url' => '/lookup?programCode=CTS0002'
            ],
            [
                'menu_id' => 150019,
                'parent_id' => 150000,
                'menu_title' => 'กระดาษทำการต้นทุนมาตรฐาน',
                'program_code' => 'CTM0018',
                'url' => '/ct/std-cost-papers'
            ],
        ];


        foreach ($menu1 as $menu) {
            $this->createMenu($menu);
        }
        foreach ($menu2 as $menu) {
            $this->createMenu($menu);
        }

        $this->newRole(150000);

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
                    ->whereRaw("menu_id between 150000 and  160000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            '/ct/cost_center',
            '/ct/product_group',
            '/ct/set_account_type',
            '/ct/specify_percentage',
            '/ct/account_code_ledger',
            '/ct/product_plan_amount',
            '/ct/specify_agency',
            '/ct/criterion_allocate',
            '/ct/purchase_price_info',
            '/ct/tax_medicine',
            '/ct/std_raw_material_cost',
            '/ct/allocate-ratios',
            '/ct/workorders/processes',
            '/report/report-info',
            '/ct/allocate-ratios',
            '/ct/std-costs',
            '/ct/std-cost-papers',

            '/lookup?programCode=CTS0001',
            '/lookup?programCode=CTS0002',
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'Costing:ALL', 'CT', $menus);
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
