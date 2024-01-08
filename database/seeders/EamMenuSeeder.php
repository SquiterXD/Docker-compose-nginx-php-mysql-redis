<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class EamMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 170000 and  180000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 170000 and menu_id <= 180000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 170000 and menu_id <= 180000")->delete();

        $menu1 = [
            [
                'menu_id' => 170000,
                'menu_title' => 'EAM', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 170000
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 170001,
                'parent_id' => 170000,
                'menu_title' => 'การทำรายการ (Transaction)',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 170002,
                'parent_id' => 170000,
                'menu_title' => 'สอบถามข้อมูล (Inquiry)',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 170003,
                'parent_id' => 170000,
                'menu_title' => 'รายงาน (Report)',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 170004,
                'parent_id' => 170000,
                'menu_title' => 'การตั้งค่า (Setup)',
                'program_code' => '',
                'url' => '#'
            ],
        ];

        $menu3 = [
            [
                'menu_id' => 170005,
                'parent_id' => 170001,
                'menu_title' => 'แผนซ่อมบำรุงเชิงป้องกัน',
                'program_code' => 'EMP0003',
                'url' => '/eam/transaction/preventive-maintenance-plan'
            ],
            [
                'menu_id' => 170006,
                'parent_id' => 170001,
                'menu_title' => 'สร้างรายการแจ้งซ่อม',
                'program_code' => 'EMP0004',
                'url' => '/eam/work-requests/create'
            ],
            [
                'menu_id' => 170007,
                'parent_id' => 170001,
                'menu_title' => 'รายการแจ้งซ่อมรออนุมัติ',
                'program_code' => 'EMP0005',
                'url' => '/eam/work-requests/waiting-approve'
            ],
            [
                'menu_id' => 170008,
                'parent_id' => 170001,
                'menu_title' => 'รายการแจ้งซ่อมทั้งหมด',
                'program_code' => 'EMP0006',
                'url' => '/eam/work-requests'
            ],
            [
                'menu_id' => 170009,
                'parent_id' => 170001,
                'menu_title' => 'สร้างรายการงานซ่อม',
                'program_code' => 'EMP0007',
                'url' => '/eam/work-orders/create'
            ],
            [
                'menu_id' => 170010,
                'parent_id' => 170001,
                'menu_title' => 'รายการแจ้งซ่อมรอเปิดงาน',
                'program_code' => 'EMP0008',
                'url' => '/eam/work-orders/waiting-open-work'
            ],
            [
                'menu_id' => 170011,
                'parent_id' => 170001,
                'menu_title' => 'รายการงานซ่อมรอปิดงาน',
                'program_code' => 'EMP0009',
                'url' => '/eam/work-orders/list-repair-jobs-waiting-close'
            ],
            [
                'menu_id' => 170012,
                'parent_id' => 170001,
                'menu_title' => 'รายการงานซ่อมรอยืนยัน',
                'program_code' => 'EMP0010',
                'url' => '/eam/work-orders/confirmed-list-repair-work'
            ],
            [
                'menu_id' => 170013,
                'parent_id' => 170001,
                'menu_title' => 'รายการงานซ่อมทั้งหมด',
                'program_code' => 'EMP0011',
                'url' => '/eam/work-orders/list-all-repair-jobs'
            ],
            [
                'menu_id' => 170014,
                'parent_id' => 170001,
                'menu_title' => 'สร้างรายการขอเบิกอะไหล่',
                'program_code' => 'EMP0012',
                'url' => '/eam/report/bill-materials'
            ],

            [
                'menu_id' => 170015,
                'parent_id' => 170002,
                'menu_title' => 'ตรวจสอบอะไหล่คงคลัง',
                'program_code' => 'EMP0001',
                'url' => '/eam/ask-for-information/check-spare-parts-inventory'
            ],
            [
                'menu_id' => 170016,
                'parent_id' => 170002,
                'menu_title' => 'ตรวจสอบอะไหล่ถูกโอนเข้าคลัง',
                'program_code' => 'EMP0002',
                'url' => '/eam/ask-for-information/parts-transferred-warehouse'
            ],


            [
                'menu_id' => 170017,
                'parent_id' => 170003,
                'menu_title' => 'CT ใบเบิกวัสดุ (Inventory)',
                'program_code' => 'EMR0004',
                'url' => '/eam/report/request-mat-inv'
            ],
            [
                'menu_id' => 170018,
                'parent_id' => 170003,
                'menu_title' => 'CT ใบเบิกวัสดุ (Non Stock)',
                'program_code' => 'EMR0005',
                'url' => '/eam/report/request-mat-non'
            ],
            [
                'menu_id' => 170019,
                'parent_id' => 170003,
                'menu_title' => 'CT-ข้อมูลการตัดจ่ายอะไหล่จากคลัง(Excel)',
                'program_code' => 'EMR0006',
                'url' => '/eam/report/issue-mat-excel'
            ],
            [
                'menu_id' => 170020,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานสรุปการบันทึกค่าแรงงานซ่อม',
                'program_code' => 'EMR0007',
                'url' => '/eam/report/summary-labor'
            ],
            [
                'menu_id' => 170021,
                'parent_id' => 170003,
                'menu_title' => 'CT-ข้อมูลการบันทึกค่าแรง(Excel)',
                'program_code' => 'EMR0008',
                'url' => '/eam/report/labor'
            ],
            [
                'menu_id' => 170022,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานข้อมูลระบบเจ้าหนี้เข้าระบบบำรุงรักษาเครื่องจักร',
                'program_code' => 'EMR0009',
                'url' => '/eam/report/payable'
            ],
            [
                'menu_id' => 170023,
                'parent_id' => 170003,
                'menu_title' => 'CT ใบปิดงานซ่อม',
                'program_code' => 'EMR0010',
                'url' => '/eam/report/closed-wo'
            ],
            [
                'menu_id' => 170024,
                'parent_id' => 170003,
                'menu_title' => 'CT ใบปิดงานซ่อม (โรงพิมพ์)',
                'program_code' => 'EMR0011',
                'url' => '/eam/report/closed-wo2'
            ],
            [
                'menu_id' => 170025,
                'parent_id' => 170003,
                'menu_title' => 'CT ใบปิดงานผลิตชิ้นส่วนอะไหล่อุปกรณ์',
                'program_code' => 'EMR0012',
                'url' => '/eam/report/closed-wo-jp'
            ],
            [
                'menu_id' => 170026,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานสรุปใบรับงานประจำเดือน',
                'program_code' => 'EMR0013',
                'url' => '/eam/report/summary-month'
            ],
            [
                'menu_id' => 170027,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานสรุปใบรับงานประจำเดือน(EXPORT)',
                'program_code' => 'EMR0014',
                'url' => '/eam/report/summary-month-excel'
            ],
            [
                'menu_id' => 170028,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานส่งข้อมูลอะไหล่เข้าระบบสินค้าคงคลัง',
                'program_code' => 'EMR0015',
                'url' => '/eam/report/receipt-mat'
            ],
            [
                'menu_id' => 170029,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานประวัติการซ่อมบำรุงเครื่องจักร(NEW)',
                'program_code' => 'EMR0016',
                'url' => '/eam/report/mnt-history'
            ],
            [
                'menu_id' => 170030,
                'parent_id' => 170003,
                'menu_title' => 'CT-ข้อมูลการซ่อมบำรุงเครื่องจักร(Excel)',
                'program_code' => 'EMR0017',
                'url' => '/eam/report/maintenance'
            ],
            [
                'menu_id' => 170031,
                'parent_id' => 170003,
                'menu_title' => 'CT-ข้อมูลการจัดซื้อ/จัดจ้าง(Excel)',
                'program_code' => 'EMR0018',
                'url' => '/eam/report/purchase'
            ],
            [
                'menu_id' => 170032,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานบัญชีงานระหว่างประกอบ (แยกรายละเอียด) ประเภท JOB สั่งผลิต',
                'program_code' => 'EMR0019',
                'url' => '/eam/report/job-account-del'
            ],
            [
                'menu_id' => 170033,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานบัญชีงานระหว่างประกอบ งวดเดือน ประเภท JOB สั่งผลิต',
                'program_code' => 'EMR0020',
                'url' => '/eam/report/job-account'
            ],
            [
                'menu_id' => 170034,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานสรุปค่าใช้จ่ายของใบสั่งซ่อม',
                'program_code' => 'EMR0021',
                'url' => '/eam/report/wo-cost'
            ],
            [
                'menu_id' => 170035,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานสรุปสถานะใบสั่งซ่อมที่ส่งมอบเสร็จสิ้นแต่ยังไม่ปิดค่าใช้จ่าย',
                'program_code' => 'EMR0022',
                'url' => '/eam/report/wo-com-status'
            ],
            [
                'menu_id' => 170036,
                'parent_id' => 170003,
                'menu_title' => 'CT รายงานส่งค่าแรงระหว่างประกอบเข้าบัญชีแยกประเภท',
                'program_code' => 'EMR0023',
                'url' => '/eam/report/labor-account'
            ],
            [
                'menu_id' => 170037,
                'parent_id' => 170003,
                'menu_title' => 'CTรายงานสรุปสถานะการของการจัดหาอะไหล่รวมทั้งการเบิกจ่ายอะไหล่เข้าใบสั่งซ่อม',
                'program_code' => 'EMR0024',
                'url' => '/eam/report/summary-mat-status'
            ],

            [
                'menu_id' => 170038,
                'parent_id' => 170004,
                'menu_title' => 'เครื่องจักร',
                'program_code' => 'EMS0001',
                'url' => '/eam/setup/machine'
            ],
            [
                'menu_id' => 170039,
                'parent_id' => 170004,
                'menu_title' => 'สายการอนุมัติ',
                'program_code' => 'EMS0002',
                'url' => '/lookup?programCode=EMS0002'
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

        $this->newRole(170000);

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
                    ->whereRaw("menu_id between 170000 and  180000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            '/eam/transaction/preventive-maintenance-plan',
            '/eam/work-requests/create',
            '/eam/work-requests/waiting-approve',
            '/eam/work-requests',
            '/eam/work-orders/create',
            '/eam/work-orders/waiting-open-work',
            '/eam/work-orders/list-repair-jobs-waiting-close',
            '/eam/work-orders/confirmed-list-repair-work',
            '/eam/work-orders/list-all-repair-jobs',
            '/eam/report/bill-materials',
            '/eam/ask-for-information/check-spare-parts-inventory',
            '/eam/ask-for-information/parts-transferred-warehouse',
            '/eam/report/request-mat-inv',
            '/eam/report/request-mat-non',
            '/eam/report/issue-mat-excel',
            '/eam/report/summary-labor',
            '/eam/report/labor',
            '/eam/report/payable',
            '/eam/report/closed-wo',
            '/eam/report/closed-wo2',
            '/eam/report/closed-wo-jp',
            '/eam/report/summary-month',
            '/eam/report/summary-month-excel',
            '/eam/report/receipt-mat',
            '/eam/report/mnt-history',
            '/eam/report/maintenance',
            '/eam/report/purchase',
            '/eam/report/job-account-del',
            '/eam/report/job-account',
            '/eam/report/wo-cost',
            '/eam/report/wo-com-status',
            '/eam/report/labor-account',
            '/eam/report/summary-mat-status',
            '/eam/setup/machine',
            '/lookup?programCode=EMS0001'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'EAM : ALL', 'EM', $menus);
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
