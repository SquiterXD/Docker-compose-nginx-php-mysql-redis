<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class PdMenuSeeder extends Seeder
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
            // [
            //     'menu_id' => 200000,
            //     'menu_title' => 'PD', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
            //     'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
            //     'permission_code' => 200000
            // ],
            [
                'menu_id' => 200001,
                'menu_title' => 'กำหนดข้อมูลหลัก', 'parent_id' => 0, 'sort_order' => 10, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 200001
            ],
            [
                'menu_id' => 200002,
                'menu_title' => 'บันทึกข้อมูลประจำวัน', 'parent_id' => 0, 'sort_order' => 20, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 200002
            ],
            [
                'menu_id' => 200003,
                'menu_title' => 'สอบถามข้อมูล', 'parent_id' => 0, 'sort_order' => 30, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 200003
            ],
            [
                'menu_id' => 200004,
                'menu_title' => 'รายงานประจำวัน', 'parent_id' => 0, 'sort_order' => 40, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 200004
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 200005,
                'parent_id' => 200001,
                'menu_title' => 'กำหนด LLD กก./พันมวน',
                'program_code' => 'PDP0012',
                'url' => '/pd/lld',
                'sort_order' => 10
            ],
            [
                'menu_id' => 200006,
                'parent_id' => 200001,
                'menu_title' => 'กำหนดประเภทสูตรยาเส้น',
                'program_code' => 'PDS0001',
                'url' => '/lookup?programCode=PDS0001',
                'sort_order' => 20
            ],
            [
                'menu_id' => 200007,
                'parent_id' => 200001,
                'menu_title' => 'กำหนดรสชาติบุหรี่ / ยาเส้น',
                'program_code' => 'PDS0004',
                'url' => '/lookup?programCode=PDS0004',
                'sort_order' => 30
            ],
            [
                'menu_id' => 200008,
                'parent_id' => 200001,
                'menu_title' => 'กำหนดกลุ่มใบยา (Leaf Formula)',
                'program_code' => 'PDS0005',
                'url' => '/lookup?programCode=PDS0005',
                'sort_order' => 40
            ],
            [
                'menu_id' => 200009,
                'parent_id' => 200001,
                'menu_title' => 'กำหนดประเภทยาเส้น',
                'program_code' => 'PDS0008',
                'url' => '/lookup?programCode=PDS0008',
                'sort_order' => 50
            ],
            [
                'menu_id' => 200010,
                'parent_id' => 200001,
                'menu_title' => 'กำหนดประเภทวัตถุดิบจำลอง',
                'program_code' => 'PDS0003',
                'url' => '/lookup?programCode=PDS0003',
                'sort_order' => 60
            ],
            [
                'menu_id' => 200011,
                'parent_id' => 200001,
                'menu_title' => 'กำหนดวัตถุดิบจำลอง',
                'program_code' => 'PDS0006',
                'url' => '/pd/settings/simu-raw-material',
                'sort_order' => 70
            ],
            [
                'menu_id' => 200012,
                'parent_id' => 200001,
                'menu_title' => 'กำหนดการแจ้งเตือนปริมาณวัตถุดิบ',
                'program_code' => 'PDS0007',
                'url' => '/pd/settings/ohhand-tobacco-forewarn',
                'sort_order' => 80
            ],


            [
                'menu_id' => 200013,
                'parent_id' => 200002,
                'menu_title' => 'บันทึกรายละเอียดสารปรุง (Casing)',
                'program_code' => 'PDP0001',
                'url' => '/pd/casing-simu-additive',
                'sort_order' => 10
            ],
            [
                'menu_id' => 200014,
                'parent_id' => 200002,
                'menu_title' => 'บันทึกรายละเอียดสารหอม (Flavor)',
                'program_code' => 'PDP0002',
                'url' => '/pd/flavor-simu-additive',
                'sort_order' => 20
            ],
            [
                'menu_id' => 200015,
                'parent_id' => 200002,
                'menu_title' => 'บันทึกการใช้หมายเลขวัตถุดิบ (Blend No.)',
                'program_code' => 'PDP0008',
                'url' => '/pd/exp-fmls',
                'sort_order' => 30
            ],
            [
                'menu_id' => 200016,
                'parent_id' => 200002,
                'menu_title' => 'บันทึกการแทนเกรดใบยา',
                'program_code' => 'PDP0011',
                'url' => '/pd/substitute-tobaccos',
                'sort_order' => 40
            ],
            [
                'menu_id' => 200017,
                'parent_id' => 200002,
                'menu_title' => 'ประวัติการแทนเกรดใบยา',
                'program_code' => 'PDP0016',
                'url' => '/pd/history-instead-grades',
                'sort_order' => 50
            ],
            [
                'menu_id' => 200018,
                'parent_id' => 200002,
                'menu_title' => 'บันทึกการจำลองสูตร และคำนวณต้นทุน Blend No.',
                'program_code' => 'PDP0003',
                'url' => '/pd/sml-cost-fmls',
                'sort_order' => 60
            ],


            [
                'menu_id' => 200019,
                'parent_id' => 200003,
                'menu_title' => 'สอบถามประมาณการยอดจำหน่าย',
                'program_code' => 'PDP0013',
                'url' => '/pd/adj-sal-forecasts',
                'sort_order' => 10
            ],
            [
                'menu_id' => 200020,
                'parent_id' => 200003,
                'menu_title' => 'สอบถามปริมาณวัตถุดิบตามประมาณการยอดจำหน่าย',
                'program_code' => 'PDP0014',
                'url' => '/pd/PDP0014',
                'sort_order' => 20
            ],
            [
                'menu_id' => 200021,
                'parent_id' => 200003,
                'menu_title' => 'สอบถามคงคลังใบยา',
                'program_code' => 'PDP0015',
                'url' => '/pd/PDP0015',
                'sort_order' => 30
            ],

            [
                'menu_id' => 200022,
                'parent_id' => 200004,
                'menu_title' => 'รายงานตรวจสอบข้อมูล Casing',
                'program_code' => 'PDR0001',
                'url' => '/report/report-info?program_code=PDR0001',
                'sort_order' => 10
            ],
            [
                'menu_id' => 200023,
                'parent_id' => 200004,
                'menu_title' => 'รายงานตรวจสอบข้อมูล Flavor',
                'program_code' => 'PDR0002',
                'url' => '/report/report-info?program_code=PDR0002',
                'sort_order' => 20
            ],
            [
                'menu_id' => 200024,
                'parent_id' => 200004,
                'menu_title' => 'รายงานสรุปการใช้สุตรแต่ละตราบุหรี่',
                'program_code' => 'PDR0003',
                'url' => '/report/report-info?program_code=PDR0003',
                'sort_order' => 30
            ],
            [
                'menu_id' => 200025,
                'parent_id' => 200004,
                'menu_title' => 'รายงานแสดงรายละเอียดวัตถุห่อมวนใน Blend ต่างๆ',
                'program_code' => 'PDR0004',
                'url' => '/report/report-info?program_code=PDR0004',
                'sort_order' => 40
            ],
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
            '/pd/lld',
            '/lookup?programCode=PDS0001',
            '/lookup?programCode=PDS0004',
            '/lookup?programCode=PDS0005',
            '/lookup?programCode=PDS0008',
            '/lookup?programCode=PDS0003',
            '/pd/settings/simu-raw-material',
            '/pd/settings/ohhand-tobacco-forewarn',
            '/pd/casing-simu-additive',
            '/pd/flavor-simu-additive',
            '/pd/exp-fmls',
            '/pd/substitute-tobaccos',
            '/pd/history-instead-grades',
            '/pd/sml-cost-fmls',
            '/pd/adj-sal-forecasts',
            '/pd/PDP0014',
            '/pd/PDP0015',
            '/report/report-info?program_code=PDR0001',
            '/report/report-info?program_code=PDR0002',
            '/report/report-info?program_code=PDR0003',
            '/report/report-info?program_code=PDR0004',
        ];

        $menus = $this->getMenus($dataRole);
        $this->createRole($roleId, 'ชนป.', 'PD', $menus);
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
