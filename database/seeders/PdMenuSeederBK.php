<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class PdMenuSeederBK extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 200000 and  201000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 200000 and menu_id <= 201000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 200000 and menu_id <= 201000")->delete();

        $menu1 = [
            [
                'menu_id' => 200000,
                'menu_title' => 'PD', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 200000
            ],
            [
                'menu_id' => 200001,
                'menu_title' => 'Process', 'parent_id' => 200000, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 200001
            ],
            [
                'menu_id' => 200002,
                'menu_title' => 'Setup', 'parent_id' => 200000, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 200002
            ],
        ];

        $menu2 = [
            // [
            //     'menu_id' => 200003,
            //     'parent_id' => 200002,
            //     'menu_title' => 'ประเภทสูตร',
            //     'program_code' => 'PMS0005',
            //     'url' => '/lookup?programCode=PMS0005'
            // ],
            [
                'menu_id' => 200003,
                'parent_id' => 200002,
                'menu_title' => 'ประเภทสูตรยาเส้นปรุง',
                'program_code' => 'PDS0001',
                'url' => '/lookup?programCode=PDS0001'
            ],
            [
                'menu_id' => 200004,
                'parent_id' => 200002,
                'menu_title' => 'ประเภทวัตถุดิบจำลอง',
                'program_code' => 'PDS0003',
                'url' => '/lookup?programCode=PDS0003'
            ],
            [
                'menu_id' => 200005,
                'parent_id' => 200002,
                'menu_title' => 'กำหนดรสชาติ',
                'program_code' => 'PDS0004',
                'url' => '/lookup?programCode=PDS0004'
            ],
            [
                'menu_id' => 200006,
                'parent_id' => 200002,
                'menu_title' => 'กำหนดกลุ่มใบยา',
                'program_code' => 'PDS0005',
                'url' => '/lookup?programCode=PDS0005'
            ],
            [
                'menu_id' => 200007,
                'parent_id' => 200002,
                'menu_title' => 'กำหนดวัตถุดิบจำลอง',
                'program_code' => 'PDS0006',
                'url' => '/pd/settings/simu-raw-material'
            ],
            [
                'menu_id' => 200008,
                'parent_id' => 200002,
                'menu_title' => 'กำหนดแจ้งเตือนปริมาณวัตถุดิบ',
                'program_code' => 'PDS0007',
                'url' => '/pd/settings/ohhand-tobacco-forewarn'
            ],

            [
                'menu_id' => 200009,
                'parent_id' => 200001,
                'menu_title' => 'Casing No.',
                'program_code' => 'PDP0001',
                'url' => '/pd/casing-simu-additive'
            ],
            [
                'menu_id' => 200010,
                'parent_id' => 200001,
                'menu_title' => 'Flavor No.',
                'program_code' => 'PDP0002',
                'url' => '/pd/flavor-simu-additive'
            ],
            [
                'menu_id' => 200011,
                'parent_id' => 200001,
                'menu_title' => 'จำลองสูตร Blend No.',
                'program_code' => 'PDP0003',
                'url' => '/PDP0003'
            ],
            // [
            //     'menu_id' => 200012,
            //     'parent_id' => 200001,
            //     'menu_title' => 'หน้าจอสร้างรหัสวัตถุดิบ - ยาเส้นปรุง/ยาเส้นพอง',
            //     'program_code' => 'PDP0004',
            //     'url' => '/pd/inv-material-items'
            // ],
            // [
            //     'menu_id' => 200013,
            //     'parent_id' => 200001,
            //     'menu_title' => 'หน้าจอสร้างรหัสวัตถุดิบ - บุหรี่ทดลอง',
            //     'program_code' => 'PDP0005',
            //     'url' => '/pd/example-cigarettes'
            // ],
            [
                'menu_id' => 200014,
                'parent_id' => 200001,
                'menu_title' => 'บันทึกสูตร Blend No.',
                'program_code' => 'PDP0008',
                'url' => '/pd/exp-formulas?lookup_code=1'
            ],
            // [
            //     'menu_id' => 200015,
            //     'parent_id' => 200001,
            //     'menu_title' => 'หน้าจอบันทึกสูตร - ยาเส้นพอง',
            //     'program_code' => 'PDP0009',
            //     'url' => '/PDP0009'
            // ],
            // [
            //     'menu_id' => 200016,
            //     'parent_id' => 200001,
            //     'menu_title' => 'หน้าจอบันทึกสูตร - ยาเส้นไม่ปรุง',
            //     'program_code' => 'PDP0010',
            //     'url' => '/pd/inv-material-items'
            // ],
            [
                'menu_id' => 200017,
                'parent_id' => 200001,
                'menu_title' => 'บันทึกแทนเกรดใบยา',
                'program_code' => 'PDP0011',
                'url' => '/pd/substitute-tobaccos'
            ],
            [
                'menu_id' => 200018,
                'parent_id' => 200001,
                'menu_title' => 'คำนวณ LLD',
                'program_code' => 'PDP0012',
                'url' => '/pd/lld'
            ],
            [
                'menu_id' => 200019,
                'parent_id' => 200001,
                'menu_title' => 'ปรับเปลี่ยนประมาณการจำหน่าย',
                'program_code' => 'PDP0013',
                'url' => '/pd/adj-sal-forecasts'
            ],
            [
                'menu_id' => 200020,
                'parent_id' => 200001,
                'menu_title' => 'ประมาณการใช้วัตถุดิบตามยอดจำหน่าย',
                'program_code' => 'PDP0014',
                'url' => '/PDP0014'
            ],
            [
                'menu_id' => 200021,
                'parent_id' => 200001,
                'menu_title' => 'ประมาณการใช้วัตถุดิบในคงคลัง',
                'program_code' => 'PDP0015',
                'url' => '/PDP0015'
            ],
            [
                'menu_id' => 200022,
                'parent_id' => 200001,
                'menu_title' => 'บันทึกสูตร Blend No. New',
                'program_code' => 'PDP0008',
                'url' => '/pd/exp-fmls'
            ],
            [
                'menu_id' => 200023,
                'parent_id' => 200001,
                'menu_title' => 'บันทึกแทนเกรดใบยา',
                'program_code' => 'PDP0011',
                'url' => '/pd/substitute-tobaccos'
            ],
            [
                'menu_id' => 200024,
                'parent_id' => 200002,
                'menu_title' => 'ประเภทยาเส้น',
                'program_code' => 'PDS0008',
                'url' => '/lookup?programCode=PDS0008'
            ],
            [
                'menu_id' => 200025,
                'parent_id' => 200001,
                'menu_title' => 'ประวัติแทนเกรดใบยา',
                'program_code' => 'PDP0016',
                'url' => '/pd/history-instead-grades'
            ]
        ];

        foreach ($menu1 as $menu) {
            $this->createMenu($menu);
        }
        foreach ($menu2 as $menu) {
            $this->createMenu($menu);
        }

        $this->newRole(200000);
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
                    ->whereRaw("menu_id between 200000 and  201000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $dataRole = [
             '/PMS0001'
            // , '/lookup?programCode=PMS0005'
            , '/lookup?programCode=PDS0001'
            , '/lookup?programCode=PDS0003'
            , '/lookup?programCode=PDS0004'
            , '/lookup?programCode=PDS0005'
            , '/pd/settings/simu-raw-material'
            , '/pd/settings/ohhand-tobacco-forewarn'
            , '/pd/casing-simu-additive'
            , '/pd/flavor-simu-additive'
            , '/PDP0003'
            , '/pd/exp-formulas?lookup_code=1'
            , '/PDP0011'
            , '/pd/lld'
            , '/pd/adj-sal-forecasts'
            , '/PDP0014'
            , '/PDP0015'
            , '/pd/exp-fmls'
            , '/pd/substitute-tobaccos'
            , '/pd/history-instead-grades'
            , '/lookup?programCode=PDS0008'
        ];

        $menus = $this->getMenus($dataRole);
        $this->createRole($roleId, 'PD : ALL', 'PD', $menus);
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
