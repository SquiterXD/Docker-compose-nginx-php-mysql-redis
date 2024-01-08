<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class IrMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 85001 and 90000")->forceDelete();
        \App\Models\Menu::whereRaw("menu_id >= 85001 and menu_id <= 90000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 85001 and menu_id <= 90000")->delete();

        $menu1 = [
            [
                'menu_id' => 85001,
                'menu_title' => 'Insurance', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 85001
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 85002,
                'parent_id' => 85001,
                'menu_title' => 'Setting Master',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 85003,
                'parent_id' => 85001,
                'menu_title' => 'Setting Lookup',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 85004,
                'parent_id' => 85001,
                'menu_title' => 'การต่ออายุประกันภัย',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 85005,
                'parent_id' => 85001,
                'menu_title' => 'การตัดค่าใช้จ่ายเบี้ยประกัน',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 85006,
                'parent_id' => 85001,
                'menu_title' => 'ข้อมูลการเคลมประกันภัย',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 85007,
                'parent_id' => 85001,
                'menu_title' => 'การประมวลผล (Interface)',
                'program_code' => '-1',
                'url' => '#'
            ],
            // 85008-85010
        ];

        $menu3 = [
            // Setting Master
            [
                'menu_id' => 85011,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูลบริษัทประกันภัย (Company)',
                'program_code' => 'IRM0001',
                'url' => '/ir/settings/company'
            ],
            [
                'menu_id' => 85012,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูลชุดกรมธรรม์ประกันภัย (Policy)',
                'program_code' => 'IRM0002',
                'url' => '/ir/settings/policy'
            ],
            [
                'menu_id' => 85013,
                'parent_id' => 85002,
                'menu_title' => 'กลุ่มกรมธรรม์  (Policy Group)',
                'program_code' => 'IRM0003',
                'url' => '/ir/settings/policy-group'
            ],
            [
                'menu_id' => 85014,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูลกลุ่มสินค้า (Product Group)',
                'program_code' => 'IRM0004',
                'url' => '/ir/settings/product-groups'
            ],
            [
                'menu_id' => 85015,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูลกลุ่มสินค้าแยกตามคลังสินค้า (Product Group By Sub-Inventory)',
                'program_code' => 'IRM0005',
                'url' => '/ir/settings/product-header'
            ],
            [
                'menu_id' => 85016,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูลรหัสบัญชี (Account Mapping)',
                'program_code' => 'IRM0006',
                'url' => '/ir/settings/account-mapping'
            ],
            [
                'menu_id' => 85017,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูลยานพาหนะ (Vehicles)',
                'program_code' => 'IRM0007',
                'url' => '/ir/settings/vehicle'
            ],
            [
                'menu_id' => 85018,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูสถานีน้ำมัน (Gas Stations)',
                'program_code' => 'IRM0008',
                'url' => '/ir/settings/gas-station'
            ],
            [
                'menu_id' => 85019,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูลกลุ่มย่อย (Sub - Group)',
                'program_code' => 'IRM0009',
                'url' => '/ir/settings/sub-groups'
            ],
            [
                'menu_id' => 85020,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูล Email สำหรับแจ้งเคลมประกัน',
                'program_code' => 'IRM0010',
                'url' => '/ir/settings/email'
            ],
            // [
            //     'menu_id' => 85021,
            //     'parent_id' => 85002,
            //     'menu_title' => 'ข้อมูลสินค้าคงคลังไม่ทำประกัน',
            //     'program_code' => 'IRM0011',
            //     'url' => '/ir/settings/inventory-not-insurance'
            // ],
            [
                'menu_id' => 85022,
                'parent_id' => 85002,
                'menu_title' => 'ข้อมูลรหัสทรัพย์สินสำหรับการปัดเศษ',
                'program_code' => 'IRM0012',
                'url' => '/ir/settings/rounding-asset'
            ],
            // 85023-85030

            // Setting Lookup
            [
                'menu_id' => 85031,
                'parent_id' => 85003,
                'menu_title' => 'แบบของการประกัน (Policy Type)',
                'program_code' => 'IRS0001',
                'url' => '/lookup?programCode=IRS0001'
            ],
            [
                'menu_id' => 85032,
                'parent_id' => 85003,
                'menu_title' => 'ข้อมูลประเภทการต่ออายุประกันภัยรถยนต์',
                'program_code' => 'IRS0002',
                'url' => '/lookup?programCode=IRS0002'
            ],
            [
                'menu_id' => 85033,
                'parent_id' => 85003,
                'menu_title' => 'ข้อมูลประเภทการต่ออายุประกันภัยพ.ร.บ.',
                'program_code' => 'IRS0003',
                'url' => '/lookup?programCode=IRS0003'
            ],
            [
                'menu_id' => 85034,
                'parent_id' => 85003,
                'menu_title' => 'ข้อมูลประเภทการต่ออายุประกันภัยป้ายทะเบียน',
                'program_code' => 'IRS0004',
                'url' => '/lookup?programCode=IRS0004'
            ],
            [
                'menu_id' => 85035,
                'parent_id' => 85003,
                'menu_title' => 'ข้อมูล ประเภทการต่ออายุประกันภัยตรวจสภาพ',
                'program_code' => 'IRS0005',
                'url' => '/lookup?programCode=IRS0005'
            ],
            [
                'menu_id' => 85036,
                'parent_id' => 85003,
                'menu_title' => 'ประเภทกรมธรรม์ (ผู้ว่าการยาสูบ)',
                'program_code' => 'IRS0006',
                'url' => '/lookup?programCode=IRS0006'
            ],
            [
                'menu_id' => 85037,
                'parent_id' => 85003,
                'menu_title' => 'กลุ่ม (Group)',
                'program_code' => 'IRS0007',
                'url' => '/lookup?programCode=IRS0007'
            ],
            [
                'menu_id' => 85038,
                'parent_id' => 85003,
                'menu_title' => 'วันที่คุ้มครอง (Effective Date)',
                'program_code' => 'IRS0008',
                'url' => '/lookup?programCode=IRS0008'
            ],
            [
                'menu_id' => 85039,
                'parent_id' => 85003,
                'menu_title' => 'รายละเอียดข้อมูลผู้ติดต่อ Email',
                'program_code' => 'IRS0009',
                'url' => '/lookup?programCode=IRS0009'
            ],
            [
                'menu_id' => 85040,
                'parent_id' => 85003,
                'menu_title' => 'โครงสร้าง Invoice Batch Name',
                'program_code' => 'IRS0010',
                'url' => '/lookup?programCode=IRS0010'
            ],
            [
                'menu_id' => 85041,
                'parent_id' => 85003,
                'menu_title' => 'ข้อมูลเกณฑ์การปันส่วนทรัพย์สิน',
                'program_code' => 'IRS0011',
                'url' => '/lookup?programCode=IRS0011'
            ],
            [
                'menu_id' => 85042,
                'parent_id' => 85003,
                'menu_title' => 'ตรวจสอบรูปแบบ Email',
                'program_code' => 'IRS0012',
                'url' => '/lookup?programCode=IRS0012'
            ],
            [
                'menu_id' => 85043,
                'parent_id' => 85003,
                'menu_title' => 'รหัสบัญชีตัดค่าใช้จ่ายรถยนต์',
                'program_code' => 'IRS0013',
                'url' => '/lookup?programCode=IRS0013'
            ],
            // 85044-85050

            // STOCK
            [
                'menu_id' => 85051,
                'parent_id' => 85004,
                'menu_title' => 'การต่ออายุประกันภัย - ข้อมูลสินค้าประจำปี',
                'program_code' => 'IRP0001',
                'url' => '/ir/stocks/yearly'
            ],
            [
                'menu_id' => 85052,
                'parent_id' => 85004,
                'menu_title' => 'การต่ออายุประกันภัย - ทรัพย์สิน',
                'program_code' => 'IRP0003',
                'url' => '/ir/assets/asset-plan'
            ],
            [
                'menu_id' => 85053,
                'parent_id' => 85004,
                'menu_title' => 'การเพิ่ม/ลดทุนประกัน - ทรัพย์สิน',
                'program_code' => 'IRP0004',
                'url' => '/ir/assets/asset-increase'
            ],
            [
                'menu_id' => 85054,
                'parent_id' => 85004,
                'menu_title' => 'การต่ออายุประกันภัย - รถยนต์',
                'program_code' => 'IRP0005',
                'url' => '/ir/cars/car'
            ],
            [
                'menu_id' => 85055,
                'parent_id' => 85004,
                'menu_title' => 'การต่ออายุประกันภัย - สถานีน้ำมัน',
                'program_code' => 'IRP0006',
                'url' => '/ir/gas-stations/gas-station'
            ],
            [
                'menu_id' => 85056,
                'parent_id' => 85004,
                'menu_title' => 'การต่ออายุประกันภัย - ประกันผู้ว่า',
                'program_code' => 'IRP0007',
                'url' => '/ir/governors/governor'
            ],
            // 85057-85070

            // EXPENSE
            [
                'menu_id' => 85071,
                'parent_id' => 85005,
                'menu_title' => 'ข้อมูลสินค้าประจำเดือน - การดึงข้อมูลสำหรับตัดค่าใช้จ่ายรายเดือน',
                'program_code' => 'IRP0002',
                'url' => '/ir/stocks/monthly'
            ],
            [
                'menu_id' => 85072,
                'parent_id' => 85005,
                'menu_title' => 'การตัดค่าใช้จ่ายเบี้ยประกัน  สินค้า / ทรัพย์สิน',
                'program_code' => 'IRP0008',
                'url' => '/ir/expense-stock-asset'
            ],
            [
                'menu_id' => 85073,
                'parent_id' => 85005,
                'menu_title' => 'การตัดค่าใช้จ่ายเบี้ยประกัน  รถยนต์ / สถานีน้ำมัน',
                'program_code' => 'IRP0009',
                'url' => '/ir/expense-car-gas'
            ],
            // 85074-85080

            // Claim
            // [
            //     'menu_id' => 85081,
            //     'parent_id' => 85006,
            //     'menu_title' => 'แจ้งเหตุการเคลมประกันภัย',
            //     'program_code' => 'IRP0010',
            //     'url' => '#'
            // ],
            // [
            //     'menu_id' => 85082,
            //     'parent_id' => 85006,
            //     'menu_title' => 'ข้อมูลรายละเอียดการเคลมประกันภัย',
            //     'program_code' => 'IRP0011',
            //     'url' => '#'
            // ],
            [
                'menu_id' => 85081,
                'parent_id' => 85006,
                'menu_title' => 'แจ้งเหตุการเคลมประกันภัย',
                'program_code' => 'IRP0010',
                'url' => '/ir/claim-insurance'
            ],
            [
                'menu_id' => 85082,
                'parent_id' => 85006,
                'menu_title' => 'ข้อมูลรายละเอียดการเคลมประกันภัย',
                'program_code' => 'IRP0011',
                'url' => '/ir/claim-accounting'
            ],
            // 85083-85090

            // Interface
            [
                'menu_id' => 85091,
                'parent_id' => 85007,
                'menu_title' => 'Confirm เพื่อส่งข้อมูล เข้า AP-Oracle',
                'program_code' => 'IRP0012',
                'url' => '/ir/confirm-to-ap'
            ],
            [
                'menu_id' => 85092,
                'parent_id' => 85007,
                'menu_title' => 'Confirm เพื่อส่งข้อมูล เข้า AR-Oracle',
                'program_code' => 'IRP0013',
                'url' => '/ir/confirm-to-ar'
            ],
            [
                'menu_id' => 85093,
                'parent_id' => 85007,
                'menu_title' => 'Confirm เพื่อส่งข้อมูล เข้า GL-Oracle',
                'program_code' => 'IRP0014',
                'url' => '/ir/confirm-to-gl'
            ],
            [
                'menu_id' => 85094,
                'parent_id' => 85007,
                'menu_title' => 'คำนวณค่าเบี้ยประกันที่แท้จริง',
                'program_code' => 'IRP0015',
                'url' => '/ir/calculate-insurance'
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

        $this->newRole(85001);

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
                    ->whereRaw("menu_id between 85001 and 90000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            '/ir/settings/company',
            '/ir/settings/policy',
            '/ir/settings/policy-group',
            '/ir/settings/product-groups',
            '/ir/settings/product-header',
            '/ir/settings/account-mapping',
            '/ir/settings/vehicle',
            '/ir/settings/gas-station',
            '/ir/settings/sub-groups',
            '/ir/settings/email',
            // '/ir/settings/inventory-not-insurance',
            '/ir/settings/rounding-asset',

            '/lookup?programCode=IRS0001',
            '/lookup?programCode=IRS0002',
            '/lookup?programCode=IRS0003',
            '/lookup?programCode=IRS0004',
            '/lookup?programCode=IRS0005',
            '/lookup?programCode=IRS0006',
            '/lookup?programCode=IRS0007',
            '/lookup?programCode=IRS0008',
            '/lookup?programCode=IRS0009',
            '/lookup?programCode=IRS0010',
            '/lookup?programCode=IRS0011',
            '/lookup?programCode=IRS0012',
            '/lookup?programCode=IRS0013',

            '/ir/stocks/yearly',
            '/ir/assets/asset-plan',
            '/ir/assets/asset-increase',
            '/ir/cars/car',
            '/ir/gas-stations/gas-station',
            '/ir/governors/governor',

            '/ir/stocks/monthly',
            '/ir/expense-stock-asset',
            '/ir/expense-car-gas',

            '/ir/claim-insurance',
            '/ir/claim-accounting',

            '/ir/confirm-to-ap',
            '/ir/confirm-to-gl',
            '/ir/confirm-to-ar',
            '/ir/calculate-insurance',
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'Insurance', 'IR', $menus);
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
