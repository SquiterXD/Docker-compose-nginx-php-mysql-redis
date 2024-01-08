<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class PmMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 2010000 and  2020000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 2010000 and menu_id <= 2020000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 2010000 and menu_id <= 2020000")->delete();

        $menu1 = [
            [
                'menu_id' => 2010000,
                'menu_title' => 'กำหนดสถานะ', 'parent_id' => 0, 'sort_order' => 10, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010000
            ],
            [
                'menu_id' => 2010001,
                'menu_title' => 'กำหนดข้อมูลวางแผน', 'parent_id' => 0, 'sort_order' => 20, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010001
            ],
            [
                'menu_id' => 2010002,
                'menu_title' => 'กำหนดข้อมูลหลัก', 'parent_id' => 0, 'sort_order' => 30, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010002
            ],
            [
                'menu_id' => 2010003,
                'menu_title' => 'วางแผนผลิตสิ่งพิมพ์', 'parent_id' => 0, 'sort_order' => 40, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010003
            ],
            [
                'menu_id' => 2010004,
                'menu_title' => 'บันทึกข้อมูลประจำวัน', 'parent_id' => 0, 'sort_order' => 50, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010004
            ],
            [
                'menu_id' => 2010005,
                'menu_title' => 'เตรียมวัตถุดิบไปโซนเครื่องจักร', 'parent_id' => 0, 'sort_order' => 60, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010005
            ],
            [
                'menu_id' => 2010006,
                'menu_title' => 'ประมาณการวัตถุดิบ', 'parent_id' => 0, 'sort_order' => 70, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010006
            ],
            [
                'menu_id' => 2010007,
                'menu_title' => 'สอบถามข้อมูล', 'parent_id' => 0, 'sort_order' => 80, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010007
            ],
            [
                'menu_id' => 2010008,
                'menu_title' => 'รายงานประจำวัน', 'parent_id' => 0, 'sort_order' => 90, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010008
            ],
            [
                'menu_id' => 2010009,
                'menu_title' => 'Process', 'parent_id' => 0, 'sort_order' => 100, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 2010009
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 2010010,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดประเภทสูตร',
                'program_code' => 'PMS0005',
                'sort_order' => 10,
                'url' => '/lookup?programCode=PMS0005'
            ],
            [
                'menu_id' => 2010011,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดสถานะสูตร',
                'program_code' => 'PMS0024',
                'sort_order' => 20,
                'url' => '/lookup?programCode=PMS0024'
            ],
            [
                'menu_id' => 2010012,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดสถานะคำสั่งผลิต',
                'program_code' => 'PMS0011',
                'sort_order' => 30,
                'url' => '/lookup?programCode=PMS0011'
            ],
            [
                'menu_id' => 2010013,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดวัตถุประสงค์การขอเบิกวัตถุดิบ',
                'program_code' => 'PMS0009',
                'sort_order' => 40,
                'url' => '/lookup?programCode=PMS0009'
            ],
            [
                'menu_id' => 2010014,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดสถานะการขอเบิกวัตถุดิบ',
                'program_code' => 'PMS0003',
                'sort_order' => 50,
                'url' => '/lookup?programCode=PMS0003'
            ],
            [
                'menu_id' => 2010015,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดสถานะตัดใช้วัตถุดิบ',
                'program_code' => 'PMS0025',
                'sort_order' => 60,
                'url' => '/lookup?programCode=PMS0025'
            ],
            [
                'menu_id' => 2010016,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดสถานะการรับผลผลิตเข้าคลัง',
                'program_code' => 'PMS0041',
                'sort_order' => 70,
                'url' => '/lookup?programCode=PMS0041'
            ],
            [
                'menu_id' => 2010017,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดสถานะการส่งสินค้าสำเร็จรูป',
                'program_code' => 'PMS0026',
                'sort_order' => 80,
                'url' => '/lookup?programCode=PMS0026'
            ],
            [
                'menu_id' => 2010018,
                'parent_id' => 2010000,
                'menu_title' => 'กำหนดสถานะประมาณการวัตถุดิบ',
                'program_code' => 'PMS0008',
                'sort_order' => 90,
                'url' => '/lookup?programCode=PMS0008'
            ],
            [
                'menu_id' => 2010019,
                'parent_id' => 2010001,
                'menu_title' => 'กำหนดกลุ่มเครื่องจักร',
                'program_code' => 'PMS0047',
                'sort_order' => 10,
                'url' => '/lookup?programCode=PMS0047'
            ],
            [
                'menu_id' => 2010020,
                'parent_id' => 2010001,
                'menu_title' => 'กำหนดชุดเครื่องจักร',
                'program_code' => 'PMS0048',
                'sort_order' => 20,
                'url' => '/pm/settings/print-machine-group'
            ],
            [
                'menu_id' => 2010021,
                'parent_id' => 2010001,
                'menu_title' => 'กำหนดช่วงเวลาในการผลิต',
                'program_code' => 'PMS0040',
                'sort_order' => 30,
                'url' => '/lookup?programCode=PMS0040'
            ],
            [
                'menu_id' => 2010022,
                'parent_id' => 2010001,
                'menu_title' => 'กำหนดกำลังผลิตรายเครื่องจักร',
                'program_code' => 'PMS0038',
                'sort_order' => 40,
                'url' => '/pm/settings/machine-power-temp'
            ],
            [
                'menu_id' => 2010023,
                'parent_id' => 2010001,
                'menu_title' => 'กำหนดการแปลงหน่วยสิ่งพิมพ์',
                'program_code' => 'PMS0036',
                'sort_order' => 50,
                'url' => '/pm/settings/print-conversion'
            ],
            [
                'menu_id' => 2010024,
                'parent_id' => 2010001,
                'menu_title' => 'กำหนดสีสิ่งพิมพ์สำเร็จรูปสำหรับการวางแผนรายวัน',
                'program_code' => 'PMS0051',
                'sort_order' => 60,
                'url' => '/pm/settings/print-item-setup'
            ],
            [
                'menu_id' => 2010025,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดสูตรการผลิต',
                'program_code' => 'PMS0033',
                'sort_order' => 10,
                'url' => '/pm/settings/production-formula'
            ],
            [
                'menu_id' => 2010026,
                'parent_id' => 2010002,
                'menu_title' => 'คัดลอกสูตรการผลิต (สูตรมาตรฐาน)',
                'program_code' => 'PMS0033.1',
                'sort_order' => 20,
                'url' => '/pm/settings/copy-production-formula'
            ],
            [
                'menu_id' => 2010027,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดขั้นตอนการทำงาน',
                'program_code' => 'PMS0004',
                'sort_order' => 30,
                'url' => '/pm/settings/wip-step'
            ],
            [
                'menu_id' => 2010028,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดกลุ่มชุดเครื่องจักร (มวน)',
                'program_code' => 'PMS0013',
                'sort_order' => 40,
                'url' => '/lookup?programCode=PMS0013'
            ],
            [
                'menu_id' => 2010029,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดกลุ่มผลิตภัณฑ์ (ก้นกรอง)',
                'program_code' => 'PMS0012',
                'sort_order' => 50,
                'url' => '/lookup?programCode=PMS0012'
            ],
            [
                'menu_id' => 2010030,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดชุดเครื่องจักร',
                'program_code' => 'PMS0028',
                'sort_order' => 60,
                'url' => '/pm/settings/machine-relation'
            ],
            [
                'menu_id' => 2010031,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดการตั้งค่าหัวจ่าย',
                'program_code' => 'PMS0018',
                'sort_order' => 70,
                'url' => '/lookup?programCode=PMS0018'
            ],
            [
                'menu_id' => 2010032,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดความสัมพันธ์ของหัวจ่ายกับกลุ่มเครื่องจักร',
                'program_code' => 'PMS0021',
                'sort_order' => 80,
                'url' => '/pm/settings/relation-feeder'
            ],
            [
                'menu_id' => 2010033,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดช่วงเวลาในการผลิต',
                'program_code' => 'PMS0040',
                'sort_order' => 90,
                'url' => '/lookup?programCode=PMS0040'
            ],
            [
                'menu_id' => 2010034,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนด Layout สิ่งพิมพ์',
                'program_code' => 'PMS0023',
                'sort_order' => 100,
                'url' => '/pm/settings/save-publication-layout'
            ],
            [
                'menu_id' => 2010035,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดคลังเก็บวัตถุดิบ',
                'program_code' => 'PMS0032',
                'sort_order' => 110,
                'url' => '/pm/settings/setup-transfer'
            ],
            [
                'menu_id' => 2010036,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดคลังตัดจ่ายวัตถุดิบ/รับผลผลิต',
                'program_code' => 'PMS0022',
                'sort_order' => 120,
                'url' => '/pm/settings/org-tranfer'
            ],
            [
                'menu_id' => 2010037,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดพื้นที่วางวัตถุดิบ',
                'program_code' => 'PMS0030',
                'sort_order' => 130,
                'url' => '/pm/settings/max-storage'
            ],
            [
                'menu_id' => 2010038,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดค่าเฝ้าระวัง',
                'program_code' => 'PMS0031',
                'sort_order' => 140,
                'url' => '/pm/settings/setup-min-max-by-item'
            ],
            [
                'menu_id' => 2010039,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดวัตถุประสงค์ในการส่งสินค้าสำเร็จรูป',
                'program_code' => 'PMS0027',
                'sort_order' => 150,
                'url' => '/lookup?programCode=PMS0027'
            ],
            [
                'menu_id' => 2010040,
                'parent_id' => 2010002,
                'menu_title' => 'กำหนดรายการสูญเสีย',
                'program_code' => 'PMS0001',
                'sort_order' => 160,
                'url' => '/lookup?programCode=PMS0001'
            ],
            [
                'menu_id' => 2010041,
                'parent_id' => 2010003,
                'menu_title' => 'วางแผนผลิตสิ่งพิมพ์รายเดือน',
                'program_code' => 'PMP0033',
                'sort_order' => 10,
                'url' => '/pm/plans/monthly'
            ],
            [
                'menu_id' => 2010042,
                'parent_id' => 2010003,
                'menu_title' => 'วางแผนผลิตสิ่งพิมพ์รายปักษ์',
                'program_code' => 'PMP0011',
                'sort_order' => 20,
                'url' => '/pm/plans/biweekly'
            ],
            [
                'menu_id' => 2010043,
                'parent_id' => 2010003,
                'menu_title' => 'อนุมัติแผนการผลิตสิ่งพิมพ์รายปักษ์',
                'program_code' => 'PMP0057',
                'sort_order' => 30,
                'url' => '/pm/plans/approvals/biweekly'
            ],
            [
                'menu_id' => 2010044,
                'parent_id' => 2010003,
                'menu_title' => 'วางแผนผลิตสิ่งพิมพ์รายวัน',
                'program_code' => 'PMP0040',
                'sort_order' => 40,
                'url' => '/pm/plans/daily'
            ],
            [
                'menu_id' => 2010045,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกคำสั่งผลิต',
                'program_code' => 'PMP0001',
                'sort_order' => 10,
                'url' => '/pm/production-order'
            ],
            [
                'menu_id' => 2010046,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกเรียกใบยา',
                'program_code' => 'PMP0002',
                'sort_order' => 20,
                'url' => '/pm/jams'
            ],
            [
                'menu_id' => 2010047,
                'parent_id' => 2010004,
                'menu_title' => 'แจ้งยอดประมาณการจัดเก็บบุหรี่',
                'program_code' => 'PMP0042',
                'sort_order' => 30,
                'url' => '/pm/send-cigarettes'
            ],
            [
                'menu_id' => 2010048,
                'parent_id' => 2010004,
                'menu_title' => 'ประมาณการเบิกวัตถุดิบรายปักษ์',
                'program_code' => 'PMP0027',
                'sort_order' => 40,
                'url' => '/pm/request-raw-materials'
            ],
            [
                'menu_id' => 2010049,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกรายการเบิกวัตถุดิบฝ่ายจัดหา',
                'program_code' => 'PMP0005',
                'sort_order' => 50,
                'url' => '/pm/material-requests'
            ],
            [
                'menu_id' => 2010050,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกรายการเบิกวัตถุดิบฝ่ายจัดหา',
                'program_code' => 'PMP0005',
                'sort_order' => 60,
                'url' => '/pm/material-requests'
            ],
            [
                'menu_id' => 2010051,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกรายการเบิกวัตถุดิบกองซ่อมเข้ากองพิมพ์',
                'program_code' => 'PMP0032',
                'sort_order' => 70,
                'url' => '/pm/internal-material-requests?case=2'
            ],
            [
                'menu_id' => 2010052,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกผลผลิตประจำวัน',
                'program_code' => 'PMP0006',
                'sort_order' => 80,
                'url' => '/pm/wip-confirm'
            ],
            [
                'menu_id' => 2010053,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกผลผลิตประจำวัน',
                'program_code' => 'PMP0012',
                'sort_order' => 90,
                'url' => '/pm/confirm-order'
            ],
            [
                'menu_id' => 2010054,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกผลผลิตประจำวัน',
                'program_code' => 'PMP0031',
                'sort_order' => 100,
                'url' => '/pm/0031'
            ],
            [
                'menu_id' => 2010055,
                'parent_id' => 2010004,
                'menu_title' => 'ตัดใช้วัตถุดิบที่ใช้ผลิต (ใบยา)',
                'program_code' => 'PMP0007',
                'sort_order' => 110,
                'url' => '/pm/wip-issue'
            ],
            [
                'menu_id' => 2010056,
                'parent_id' => 2010004,
                'menu_title' => 'ตัดใช้วัตถุดิบที่ใช้ผลิต (สารปรุง/สารหอม)',
                'program_code' => 'PMP0048',
                'sort_order' => 120,
                'url' => '/pm/wip-issue/casing-flavor'
            ],
            [
                'menu_id' => 2010057,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกรายการตัดใช้จริงวัตถุดิบ',
                'program_code' => 'PMP0049',
                'sort_order' => 130,
                'url' => '/pm/wip-issue/issue'
            ],
            [
                'menu_id' => 2010058,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกรายการตัดใช้จริงวัตถุดิบ',
                'program_code' => 'PMP0051',
                'sort_order' => 140,
                'url' => '/pm/wip-issue/cut_of'
            ],
            [
                'menu_id' => 2010059,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกผลผลิตเข้าคลัง',
                'program_code' => 'PMP0044',
                'sort_order' => 150,
                'url' => '/pm/wip-requests'
            ],
            [
                'menu_id' => 2010060,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกส่งบุหรี่',
                'program_code' => 'PMP0041',
                'sort_order' => 160,
                'url' => '/pm/transfer-products'
            ],
            [
                'menu_id' => 2010061,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกส่งผลผลิต',
                'program_code' => 'PMP0052',
                'sort_order' => 170,
                'url' => '/pm/products/transfers'
            ],
            [
                'menu_id' => 2010062,
                'parent_id' => 2010004,
                'menu_title' => 'บันทึกบุหรี่แจกสูบ',
                'program_code' => 'PMP0019',
                'sort_order' => 180,
                'url' => '/pm/free-products/now'
            ],
            [
                'menu_id' => 2010063,
                'parent_id' => 2010004,
                'menu_title' => 'ตรวจสอบสถานะคำสั่งผลิต',
                'program_code' => 'PMP0035',
                'sort_order' => 190,
                'url' => '/pm/production-order-list'
            ],
            [
                'menu_id' => 2010064,
                'parent_id' => 2010005,
                'menu_title' => 'ตรวจสอบวัตถุดิบ',
                'program_code' => 'PMP0022',
                'sort_order' => 10,
                'url' => '/pm/production-order-list'
            ],
            [
                'menu_id' => 2010065,
                'parent_id' => 2010005,
                'menu_title' => 'ส่งวัตถุดิบไป Zone ก้นกรอง',
                'program_code' => 'PMP0024',
                'sort_order' => 20,
                'url' => '/pm/qrcode-rcv-transfer-mtls'
            ],
            [
                'menu_id' => 2010066,
                'parent_id' => 2010005,
                'menu_title' => 'ส่งวัตถุดิบไปหน้าเครื่องจักร',
                'program_code' => 'PMP0023',
                'sort_order' => 30,
                'url' => '/pm/qrcode-transfer-mtls'
            ],
            [
                'menu_id' => 2010067,
                'parent_id' => 2010005,
                'menu_title' => 'คืนวัตถุดิบไปกองเตรียม',
                'program_code' => 'PMP0043',
                'sort_order' => 40,
                'url' => '/pm/qrcode-return-mtls'
            ],
            [
                'menu_id' => 2010068,
                'parent_id' => 2010006,
                'menu_title' => 'ประมาณการใช้วัตถุดิบประจำปี',
                'program_code' => 'PMP0003',
                'sort_order' => 10,
                'url' => '/pm/plans/yearly'
            ],
            [
                'menu_id' => 2010069,
                'parent_id' => 2010007,
                'menu_title' => 'รายการวัตถุดิบคงคลัง',
                'program_code' => 'PMP0034',
                'sort_order' => 10,
                'url' => '/pm/inventory-list'
            ],
            [
                'menu_id' => 2010070,
                'parent_id' => 2010007,
                'menu_title' => 'สอบถามแผนการจ่ายยาเส้นรายปักษ์',
                'program_code' => 'PMP0010',
                'sort_order' => 20,
                'url' => '/pm/planning-jobs'
            ],
            [
                'menu_id' => 2010071,
                'parent_id' => 2010008,
                'menu_title' => 'รายงานคำสั่งผลิต (Master list)',
                'program_code' => 'PDR0671',
                'sort_order' => 10,
                'url' => '#PDR0671'
            ],
            [
                'menu_id' => 2010072,
                'parent_id' => 2010008,
                'menu_title' => 'ใบโอนวัตถุดิบ/วัสดุเพื่อใช้ในการผลิต',
                'program_code' => 'TTPDRP10',
                'sort_order' => 20,
                'url' => '#TTPDRP10'
            ],
            [
                'menu_id' => 2010073,
                'parent_id' => 2010008,
                'menu_title' => 'รายการจัดเตรียมวัตถุดิบประจำวัน',
                'program_code' => 'PMP0028',
                'sort_order' => 30,
                'url' => '/pm/ingredient-preparation'
            ],
            [
                'menu_id' => 2010074,
                'parent_id' => 2010008,
                'menu_title' => 'รายงานผลผลิตประจำวันแยกตามคำสั่งการผลิต',
                'program_code' => 'PDR1150',
                'sort_order' => 40,
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR1150'
            ],
            [
                'menu_id' => 2010075,
                'parent_id' => 2010008,
                'menu_title' => 'รายงานผลผลิตประจำวันแยกตามวันที่ผลิต',
                'program_code' => 'PDR1180',
                'sort_order' => 50,
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR1180'
            ],
            [
                'menu_id' => 2010076,
                'parent_id' => 2010008,
                'menu_title' => 'รายงานผลผลิตประจำวันยอดรวม',
                'program_code' => 'PDR2040',
                'sort_order' => 60,
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR2040'
            ],
            [
                'menu_id' => 2010077,
                'parent_id' => 2010008,
                'menu_title' => 'รายงานการพิมพ์',
                'program_code' => 'PDR1120',
                'sort_order' => 70,
                'url' => '#PDR1120'
            ],
            [
                'menu_id' => 2010078,
                'parent_id' => 2010008,
                'menu_title' => 'รายงานการตัดและบรรจุ',
                'program_code' => 'PDR1130',
                'sort_order' => 80,
                'url' => '#PDR1130'
            ],
            [
                'menu_id' => 2010079,
                'parent_id' => 2010008,
                'menu_title' => 'รายงานการเบิกจาก INVENTORY',
                'program_code' => 'PDR0880',
                'sort_order' => 90,
                'url' => '#PDR0880'
            ],
            [
                'menu_id' => 2010080,
                'parent_id' => 2010009,
                'menu_title' => 'บันทึกแสตมป์สูญเสีย',
                'program_code' => 'PMP0016',
                'sort_order' => 10,
                'url' => '/pm/confirm-stamp-using?date=2022-09-19'
            ],
            [
                'menu_id' => 2010081,
                'parent_id' => 2010009,
                'menu_title' => 'บันทึกร้องขอวัตถุดิบ (กองเตรียม)',
                'program_code' => 'PMP0020',
                'sort_order' => 20,
                'url' => '/pm/raw_material_list'
            ],
            [
                'menu_id' => 2010082,
                'parent_id' => 2010009,
                'menu_title' => 'รายการร้องขอวัตถุดิบ (กองเตรียม)',
                'program_code' => 'PMP0021',
                'sort_order' => 30,
                'url' => '/pm/raw_material_report'
            ],
            [
                'menu_id' => 2010083,
                'parent_id' => 2010009,
                'menu_title' => 'แจ้งเตือนปริมาณคงคลังสารปรุง',
                'program_code' => 'PMP0025',
                'sort_order' => 40,
                'url' => '#PMP0025'
            ],
            [
                'menu_id' => 2010084,
                'parent_id' => 2010009,
                'menu_title' => 'แจ้งเตือนปริมาณคงคลังวัตถุดิบ',
                'program_code' => 'PMP0026',
                'sort_order' => 50,
                'url' => '#PMP0026'
            ],
            [
                'menu_id' => 2010085,
                'parent_id' => 2010009,
                'menu_title' => 'ลงผลตรวจสอบสารปรุงหลังหมดอายุ',
                'program_code' => 'PMP0036',
                'sort_order' => 60,
                'url' => '#PMP0036'
            ],
            [
                'menu_id' => 2010086,
                'parent_id' => 2010009,
                'menu_title' => 'อนุมัติการขอเปลี่ยนแปลง',
                'program_code' => 'PMP0037',
                'sort_order' => 70,
                'url' => '#PMP0037'
            ],
            [
                'menu_id' => 2010087,
                'parent_id' => 2010009,
                'menu_title' => 'ลงผลตรวจสอบหลังผลิต',
                'program_code' => 'PMP0039',
                'sort_order' => 80,
                'url' => '#PMP0039'
            ],
            [
                'menu_id' => 2010088,
                'parent_id' => 2010009,
                'menu_title' => 'บันทึกสูญเสีย',
                'program_code' => 'PMP0047',
                'sort_order' => 90,
                'url' => '/pm/wip-loss-quantity'
            ],
            [
                'menu_id' => 2010089,
                'parent_id' => 2010009,
                'menu_title' => 'บันทึกใช้ยาเส้น ZoneC48',
                'program_code' => 'PMP0055',
                'sort_order' => 100,
                'url' => '/pm/sprinkle-tobaccos'
            ],
            [
                'menu_id' => 2010090,
                'parent_id' => 2010009,
                'menu_title' => 'บันทึกใช้แสตมป์',
                'program_code' => 'PMP0058',
                'sort_order' => 110,
                'url' => '/pm/stamp-using'
            ],
        ];

        foreach ($menu1 as $menu) {
            $this->createMenu($menu);
        }
        foreach ($menu2 as $menu) {
            $this->createMenu($menu);
        }

        $this->deptTest(2010000); // กองมวน
        $this->dept2(2010001); // กองเตรียม
        $this->dept3(2010002); // ก้นกรอง
        $this->dept4(2010003); // ยาเส้นพอง
        $this->dept5(2010004); // ยาเส้น
        $this->dept6(2010005); // ยาเส้นภูมิภาค
        $this->dept7(2010006); // บรรจุภูมิภาค
        $this->dept8(2010007); // กองพิมพ์
        $this->dept9(2010008); // กองทดลอง
        $this->dept10(2010009); // Admin ฝ่ายผลิต
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
                    ->whereRaw("menu_id between 2010000 and  2020000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function deptTest($roleId) // กองมวน
    {
        $dataRole = [
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0008',
            '/lookup?programCode=PMS0013',
            '/pm/settings/machine-relation',
            '/lookup?programCode=PMS0040',
            '/lookup?programCode=PMS0027',
            '/lookup?programCode=PMS0001',
            '/pm/send-cigarettes',
            '/pm/confirm-order',
            '/pm/transfer-products',
            '/pm/free-products/now',
            '/pm/production-order-list',
            '/pm/inventory-list',
            '#PDR0671',
            '#TTPDRP10',
            '/pm/ingredient-preparation',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR0880',
        ];

        $menus = $this->getMenus($dataRole);
        $this->createRole($roleId, 'กองมวน', 'PM', $menus);
    }

    public function dept2($roleId) // กองเตรียม
    {
        $dataRole = [
            '/pm/settings/production-formula',
            '/pm/settings/wip-step',
            '/pm/settings/setup-transfer',
            '/pm/settings/org-tranfer',
            '/pm/settings/max-storage',
            '/pm/settings/setup-min-max-by-item',
            '/pm/production-order',
            '/pm/request-raw-materials',
            '/pm/material-requests',
            '/pm/wip-issue/issue',
            '/pm/production-order-list',
            '/pm/production-order-list',
            '/pm/qrcode-transfer-mtls',
            '/pm/qrcode-return-mtls',
            '/pm/plans/yearly',
            '/pm/inventory-list',
            '#PDR0671',
            '#TTPDRP10',
            '/pm/ingredient-preparation',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR0880',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all());
        $this->createRole($roleId, 'กองเตรียม', 'PM', $menus);
    }

    public function dept3($roleId) // ก้นกรอง
    {
        $dataRole = [
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0041',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0008',
            '/pm/settings/production-formula',
            '/pm/settings/wip-step',
            '/lookup?programCode=PMS0012',
            '/pm/settings/machine-relation',
            '/lookup?programCode=PMS0040',
            '/pm/settings/setup-transfer',
            '/pm/settings/org-tranfer',
            '/pm/production-order',
            '/pm/confirm-order',
            '/pm/wip-issue/cut_of',
            '/pm/wip-requests',
            '/pm/products/transfers',
            '/pm/production-order-list',
            '/pm/production-order-list',
            '/pm/qrcode-rcv-transfer-mtls',
            '/pm/qrcode-return-mtls',
            '/pm/plans/yearly',
            '/pm/inventory-list',
            '#PDR0671',
            '#TTPDRP10',
            '/pm/ingredient-preparation',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR0880',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all());
        $this->createRole($roleId, 'ก้นกรอง', 'PM', $menus);
    }

    public function dept4($roleId) // ยาเส้นพอง
    {
        $dataRole = [
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0041',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0008',
            '/pm/settings/wip-step',
            '/pm/settings/setup-transfer',
            '/pm/settings/org-tranfer',
            '/pm/settings/setup-min-max-by-item',
            '/pm/production-order',
            '/pm/jams',
            '/pm/request-raw-materials',
            '/pm/material-requests',
            '/pm/wip-confirm',
            '/pm/wip-issue',
            '/pm/wip-requests',
            '/pm/products/transfers',
            '/pm/production-order-list',
            '#PDR0671',
            '#TTPDRP10',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR0880',

        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'ยาเส้นพอง', 'PM', $menus);
    }

    public function dept5($roleId) // ยาเส้น
    {
        $dataRole = [
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0041',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0008',
            '/pm/settings/wip-step',
            '/lookup?programCode=PMS0018',
            '/pm/settings/relation-feeder',
            '/pm/settings/setup-transfer',
            '/pm/settings/org-tranfer',
            '/pm/settings/setup-min-max-by-item',
            '/lookup?programCode=PMS0001',
            '/pm/production-order',
            '/pm/jams',
            '/pm/request-raw-materials',
            '/pm/material-requests',
            '/pm/wip-confirm',
            '/pm/wip-issue',
            '/pm/wip-issue/casing-flavor',
            '/pm/wip-requests',
            '/pm/products/transfers',
            '/pm/production-order-list',
            '/pm/plans/yearly',
            '/pm/planning-jobs',
            '#PDR0671',
            '#TTPDRP10',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR0880',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'ยาเส้น', 'PM', $menus);
    }

    public function dept6($roleId) // ยาเส้นภูมิภาค
    {
        $dataRole = [
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0041',
            '/pm/settings/wip-step',
            '/pm/settings/org-tranfer',
            '/pm/production-order',
            '/pm/0031',
            '/pm/wip-issue',
            '/pm/wip-requests',
            '/pm/production-order-list',
            '#PDR0671',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR0880',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'ยาเส้นภูมิภาค', 'PM', $menus);
    }

    public function dept7($roleId) // บรรจุภูมิภาค
    {
        $dataRole = [
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/pm/settings/production-formula',
            '/pm/settings/wip-step',
            '/pm/settings/org-tranfer',
            '/pm/production-order',
            '/pm/0031',
            '/pm/wip-issue/cut_of',
            '/pm/transfer-products',
            '/pm/products/transfers',
            '/pm/production-order-list',
            '#PDR0671',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR0880',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'บรรจุภูมิภาค', 'PM', $menus);
    }

    public function dept8($roleId) // กองพิมพ์
    {
        $dataRole = [
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0041',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0008',
            '/lookup?programCode=PMS0047',
            '/pm/settings/print-machine-group',
            '/lookup?programCode=PMS0040',
            '/pm/settings/machine-power-temp',
            '/pm/settings/print-conversion',
            '/pm/settings/print-item-setup',
            '/pm/settings/production-formula',
            '/pm/settings/copy-production-formula',
            '/pm/settings/wip-step',
            '/pm/settings/save-publication-layout',
            '/pm/settings/setup-transfer',
            '/pm/settings/org-tranfer',
            '/pm/settings/setup-min-max-by-item',
            '/pm/plans/monthly',
            '/pm/plans/biweekly',
            '/pm/plans/approvals/biweekly',
            '/pm/plans/daily',
            '/pm/production-order',
            '/pm/request-raw-materials',
            '/pm/material-requests',
            '/pm/internal-material-requests?case=2',
            '/pm/0031',
            '/pm/wip-issue/cut_of',
            '/pm/wip-requests',
            '/pm/products/transfers',
            '/pm/production-order-list',
            '/pm/plans/yearly',
            '/pm/inventory-list',
            '#PDR0671',
            '#TTPDRP10',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR1120',
            '#PDR1130',
            '#PDR0880',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'กองพิมพ์', 'PM', $menus);
    }

    public function dept9($roleId) // กองทดลอง
    {
        $dataRole = [
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0041',
            '/lookup?programCode=PMS0026',
            '/pm/settings/production-formula',
            '/pm/settings/wip-step',
            '/pm/settings/setup-transfer',
            '/pm/settings/org-tranfer',
            '/pm/settings/setup-min-max-by-item',
            '/pm/production-order',
            '/pm/material-requests',
            '/pm/0031',
            '/pm/wip-issue/cut_of',
            '/pm/wip-requests',
            '/pm/products/transfers',
            '/pm/production-order-list',
            '/pm/inventory-list',
            '#PDR0671',
            '#TTPDRP10',
            '/pm/wip-confirm/export-pdf-parameters/PDR1150',
            '/pm/wip-confirm/export-pdf-parameters/PDR1180',
            '/pm/wip-confirm/export-pdf-parameters/PDR2040',
            '#PDR0880',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'กองทดลอง', 'PM', $menus);
    }

    public function dept10($roleId) // Admin ฝ่ายผลิต
    {
        $dataRole = [
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0041',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0008',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'Admin ฝ่ายผลิต', 'PM', $menus);
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
