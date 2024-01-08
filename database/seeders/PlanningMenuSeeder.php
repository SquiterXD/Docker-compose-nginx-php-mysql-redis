<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class PlanningMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 70001 and 80000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 70001 and menu_id <= 80000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 70001 and menu_id <= 80000")->delete();

        $menu1 = [
            [
                'menu_id' => 70001,
                'menu_title' => 'ระบบงานวางแผน', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 70001
            ],
            [
                'menu_id' => 70004,
                'menu_title' => 'ตั้งค่าระบบงานวางแผน', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 70004
            ],
            [
                'menu_id' => 70022,
                'menu_title' => 'รายงานระบบงานวางแผน', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 70022
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 70002,
                'parent_id' => 70001,
                'menu_title' => 'ประมาณการผลิตประจำปี',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 70003,
                'parent_id' => 70001,
                'menu_title' => 'ประมาณการผลิตประจำปักษ์',
                'program_code' => '-1',
                'url' => '#'
            ],
            // SETTING
            [
                'menu_id' => 70014,
                'parent_id' => 70004,
                'menu_title' => 'กำหนด BATCH ปริมาณผลิตบุหรี่',
                'program_code' => 'PPS0001',
                'url' => '/lookup?programCode=PPS0001',
            ],
            [
                'menu_id' => 70015,
                'parent_id' => 70004,
                'menu_title' => 'กำหนดจำนวนชั่วโมงวันทำงาน',
                'program_code' => 'PPS0002',
                'url' => '/lookup?programCode=PPS0002',
            ],
            [
                'menu_id' => 70016,
                'parent_id' => 70004,
                'menu_title' => 'กำหนดสีตราบุหรี่ในตารางผลิตรายวัน',
                'program_code' => 'PPS0008',
                'url' => '/lookup?programCode=PPS0008',
            ],
            [
                'menu_id' => 70017,
                'parent_id' => 70004,
                'menu_title' => 'กำหนดแจ้งเตือนคงคลังบุหรี่',
                'program_code' => 'PPS0009',
                'url' => '/lookup?programCode=PPS0009',
            ],
            [
                'menu_id' => 70019,
                'parent_id' => 70004,
                'menu_title' => 'กำหนดแปลงหน่วยแสตมป์',
                'program_code' => 'PPS0011',
                'url' => '/planning/setup/pps0011',
            ],
            [
                'menu_id' => 70020,
                'parent_id' => 70004,
                'menu_title' => 'กำหนดสั่งซื้อแสตมป์',
                'program_code' => 'PPS0012',
                'url' => '/planning/setup/pps0012',
            ],
            // Report
            [
                'menu_id' => 70023,
                'parent_id' => 70022,
                'menu_title' => 'ประมาณการผลิตประจำปี',
                'program_code' => 'PPR0001',
                'url' => '/report/report-info?program_code=PPR0001'
            ],
            [
                'menu_id' => 70024,
                'parent_id' => 70022,
                'menu_title' => 'คำสั่งผลิตประจำปักษ์',
                'program_code' => 'PPR0002',
                'url' => '/report/report-info?program_code=PPR0002'
            ],
            [
                'menu_id' => 70025,
                'parent_id' => 70022,
                'menu_title' => 'แผนผลิตประจำเดือน',
                'program_code' => 'PPR0003',
                'url' => '/report/report-info?program_code=PPR0003',
            ],
            // [
            //     'menu_id' => 70026,
            //     'parent_id' => 70022,
            //     'menu_title' => 'รายงานคงคลังบุหรี่ประจำวัน',
            //     'program_code' => 'PPR0004',
            //     'url' => '/report/report-info?program_code=PPR0004',
            // ],
            [
                'menu_id' => 70027,
                'parent_id' => 70022,
                'menu_title' => 'ประมาณการซื้อแสตมป์รายเดือนแยกตามกลุ่มราคา',
                'program_code' => 'PPR0005',
                'url' => '/report/report-info?program_code=PPR0005',
            ],
            [
                'menu_id' => 70028,
                'parent_id' => 70022,
                'menu_title' => 'ใบแจ้งรายการสั่งซื้อแสตมป์แยกตามกลุ่มราคา',
                'program_code' => 'PPR0006',
                'url' => '/report/report-info?program_code=PPR0006',
            ],
            [
                'menu_id' => 70029,
                'parent_id' => 70022,
                'menu_title' => 'แบบงบเดือนการปิดแสตมป์ยาสูบ',
                'program_code' => 'PPR0007',
                'url' => '/report/report-info?program_code=PPR0007',
            ],
            [
                'menu_id' => 70030,
                'parent_id' => 70022,
                'menu_title' => 'มูลค่าคงคลังแสตมป์เช้า',
                'program_code' => 'PPR0008',
                'url' => '/report/report-info?program_code=PPR0008',
            ],
            [
                'menu_id' => 70031,
                'parent_id' => 70022,
                'menu_title' => 'รายงานสั่งซื้อแสตมป์แยกรายตรา',
                'program_code' => 'PPR0009',
                'url' => '/report/report-info?program_code=PPR0009',
            ],
            [
                'menu_id' => 70032,
                'parent_id' => 70022,
                'menu_title' => 'รายงานสูญเสียแสตมป์',
                'program_code' => 'PPR0010',
                'url' => '/report/report-info?program_code=PPR0010',
            ],
            [
                'menu_id' => 70033,
                'parent_id' => 70022,
                'menu_title' => 'รายงานปรับคำสั่งผลิต',
                'program_code' => 'PPR0011',
                'url' => '/report/report-info?program_code=PPR0011',
            ],
        ];

        $menu3 = [
            // YEAR
            [
                'menu_id' => 70005,
                'parent_id' => 70002,
                'menu_title' => 'ประมาณกำลังการผลิตประจำปักษ์',
                'program_code' => 'PPP0001',
                'url' => '/planning/machine-yearly'
            ],
            [
                'menu_id' => 70006,
                'parent_id' => 70002,
                'menu_title' => 'ประมาณการผลิตบุหรี่และก้นกรองประจำปี',
                'program_code' => 'PPP0002',
                'url' => '/planning/production-yearly/-1'
            ],

            //BIWEEKLY
            [
                'menu_id' => 70007,
                'parent_id' => 70003,
                'menu_title' => 'ประมาณกำลังการผลิตประจำปักษ์',
                'program_code' => 'PPP0003',
                'url' => '/planning/machine-biweekly'
            ],
            [
                'menu_id' => 70008,
                'parent_id' => 70003,
                'menu_title' => 'ประมาณการผลิตบุหรี่และก้นกรองประจำปักษ์',
                'program_code' => 'PPP0004',
                'url' => '/planning/production-biweekly/-1'
            ],
            [
                'menu_id' => 70009,
                'parent_id' => 70003,
                'menu_title' => 'ปรับแผนการผลิตประจำปักษ์',
                'program_code' => 'PPP0005',
                'url' => '/planning/adjusts/-1'
            ],
            [
                'menu_id' => 70010,
                'parent_id' => 70003,
                'menu_title' => 'ติดตามแผนการผลิตประจำปักษ์',
                'program_code' => 'PPP0006',
                'url' => '/planning/follow-ups'
            ],
            [
                'menu_id' => 70011,
                'parent_id' => 70003,
                'menu_title' => 'ประมาณการผลิตรายวัน',
                'program_code' => 'PPP0007',
                'url' => '/planning/production-daily/-1'
            ],
            [
                'menu_id' => 70012,
                'parent_id' => 70003,
                'menu_title' => 'ประมาณการจัดซื้อแสตมป์รายเดือน',
                'program_code' => 'PPP0008',
                'url' => '/planning/stamp-monthly'
            ],
            [
                'menu_id' => 70013,
                'parent_id' => 70003,
                'menu_title' => 'ติดตามการใช้แสตมป์รายวัน',
                'program_code' => 'PPP0009',
                'url' => '/planning/stamp-follow'
            ],
            [
                'menu_id' => 70021,
                'parent_id' => 70003,
                'menu_title' => 'ประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์',
                'program_code' => 'PPP0010',
                'url' => '/planning/overtimes-plan'
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

        $this->newRole(70001);

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
                    ->whereRaw("menu_id between 70001 and 80000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            '/planning/machine-yearly',
            '/planning/production-yearly/-1',
            '/planning/machine-biweekly',
            '/planning/production-biweekly/-1',
            '/planning/adjusts/-1',
            '/planning/follow-ups',
            '/planning/production-daily/-1',
            '/planning/stamp-monthly',
            '/planning/stamp-follow',
            '/planning/overtimes-plan',
            '/lookup?programCode=PPS0001',
            '/lookup?programCode=PPS0002',
            '/lookup?programCode=PPS0008',
            '/lookup?programCode=PPS0009',
            '/planning/setup/pps0011',
            '/planning/setup/pps0012',
            '/report/report-info?program_code=PPR0001',
            '/report/report-info?program_code=PPR0002',
            '/report/report-info?program_code=PPR0003',
            // '/report/report-info?program_code=PPR0004',
            '/report/report-info?program_code=PPR0005',
            '/report/report-info?program_code=PPR0006',
            '/report/report-info?program_code=PPR0007',
            '/report/report-info?program_code=PPR0008',
            '/report/report-info?program_code=PPR0009',
            '/report/report-info?program_code=PPR0010',
            '/report/report-info?program_code=PPR0011'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'Planning', 'PP', $menus);
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
