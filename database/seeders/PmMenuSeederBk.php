<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class PmMenuSeederBk extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 10000 and  20000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 10000 and menu_id <= 20000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 10000 and menu_id <= 20000")->delete();

        $menu1 = [
            [
                'menu_id' => 10000,
                'menu_title' => 'DEV2: PM', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 10000
            ],
            [
                'menu_id' => 10001,
                'menu_title' => 'Process', 'parent_id' => 10000, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 10001
            ],
            [
                'menu_id' => 10002,
                'menu_title' => 'Setup', 'parent_id' => 10000, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 10002
            ],
        ];

        $menu2 = [

            ['menu_id' => 10100,

            'parent_id' => 10001,
            'menu_title' => '   ประมาณการใช้วัตถุดิบประจำปี   ',
            'program_code' => 'PMP0003',
            ],

            [
            'menu_id' => 10101,
            'parent_id' => 10001,
            'menu_title' => '   เปิดคำสั่งการผลิต     ',
            'program_code' => 'PMP0001',
            'url' => '/pm/production-order'
            ],

            [
            'menu_id' => 10102,
            'parent_id' => 10001,
            'menu_title' => '   แจ้งยอดประมาณการจัดเก็บบุหรี่     ',
            'program_code' => 'PMP0042',
            'url' => '/pm/send-cigarettes'
            ],

            [
            'menu_id' => 10103,
            'parent_id' => 10001,
            'menu_title' => '   รายการขอเบิกวัตถุดิบ (จัดหา)      ',
            'program_code' => 'PMP0004',
            'url' => '/pm/0004'
            ],

            [
            'menu_id' => 10104,
            'parent_id' => 10001,
            'menu_title' => 'ประมาณการวัตถุดิบรายปักษ์',
            'program_code' => 'PMP0027',
            'url' => '/pm/request-raw-materials'
            ],

            [
            'menu_id' => 10105,
            'parent_id' => 10001,
            'menu_title' => '   สร้างใบเบิกวัตถุดิบ (จัดหา)   ',
            'program_code' => 'PMP0005',
            'url' => '/pm/material-requests?case=2'
            ],

            [
            'menu_id' => 10106,
            'parent_id' => 10001,
            'menu_title' => '   รายการจัดเตรียมวัตถุดิบประจำวัน   ',
            'program_code' => 'PMP0028',
            'url' => '/pm/ingredient-preparation'
            ],

            [
            'menu_id' => 10107,
            'parent_id' => 10001,
            'menu_title' => '   ตรวจสอบวัตถุดิบ   ',
            'program_code' => 'PMP0022',
            'url' => '/pm/qrcode-check-mtls'
            ],

            [
            'menu_id' => 10108,
            'parent_id' => 10001,
            'menu_title' => '   รับวัตถุดิบหน้าเครื่องจักร    ',
            'program_code' => 'PMP0023',
            'url' => '/pm/qrcode-transfer-mtls'
            ],

            [
            'menu_id' => 10109,
            'parent_id' => 10001,
            'menu_title' => '   คืนวัตถุดิบไปกองเตรียม    ',
            'program_code' => 'PMP0043',
            'url' => '/pm/qrcode-return-mtls'
            ],

            [
            'menu_id' => 10110,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกร้องขอวัตถุดิบ (กองเตรียม)      ',
            'program_code' => 'PMP0020',
            'url' => '/pm/raw_material_list'
            ],

            [
            'menu_id' => 10111,
            'parent_id' => 10001,
            'menu_title' => '   รายการร้องขอวัตถุดิบ (กองเตรียม)      ',
            'program_code' => 'PMP0021',
            'url' => '/pm/raw_material_report'
            ],

            [
            'menu_id' => 10112,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกผลผลิตประจำวัน      ',
            'program_code' => 'PMP0012',
            'url' => '/pm/confirm-order'
            ],

            [
            'menu_id' => 10113,
            'parent_id' => 10001,
            'menu_title' => '   ตัดใช้วัตถุดิบ    ',
            'program_code' => 'PMP0049',
            'url' => '/pm/wip-issue/issue'
            ],

            [
            'menu_id' => 10114,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกส่งบุหรี่   ',
            'program_code' => 'PMP0041',
            'url' => '/pm/transfer-products'
            ],

            [
            'menu_id' => 10115,
            'parent_id' => 10001,
            'menu_title' => '   รายการคำสั่งการผลิต   ',
            'program_code' => 'PMP0035',
            'url' => '/pm/production-order-list'
            ],

            [
            'menu_id' => 10116,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกแสตมป์สูญเสีย   ',
            'program_code' => 'PMP0016',
            'url' => '/pm/confirm-stamp-using?date=2021-07-15'
            ],

            [
            'menu_id' => 10117,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกบุหรี่ตัวอย่าง      ',
            'program_code' => 'PMP0018',
            'url' => '/pm/sample-cigarettes/2021-07-15'
            ],

            [
            'menu_id' => 10118,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกบุหรี่แจกสูบ    ',
            'program_code' => 'PMP0019',
            'url' => '/pm/free-products/2021-07-15'
            ],

            [
            'menu_id' => 10119,
            'parent_id' => 10001,
            'menu_title' => '   รายการวัตถุดิบคงคลัง      ',
            'program_code' => 'PMP0034',
            'url' => '/pm/inventory-list'
            ],

            [
            'menu_id' => 10120,
            'parent_id' => 10001,
            'menu_title' => '   หน้าจอเรียกใบยา   ',
            'program_code' => 'PMP0002',
            'url' => '/pm/jams'
            ],

            [
            'menu_id' => 10121,
            'parent_id' => 10001,
            'menu_title' => '   สร้างใบเบิกวัตถุดิบ (จัดหา)   ',
            'program_code' => 'PMP0005',
            'url' => '/pm/material-requests'
            ],

            [
            'menu_id' => 10122,
            'parent_id' => 10001,
            'menu_title' => '   รายงานผลผลิตในกระบวนการผลิต(WIP)      ',
            'program_code' => 'PMP0006',
            'url' => '/pm/wip-confirm'
            ],

            [
            'menu_id' => 10123,
            'parent_id' => 10001,
            'menu_title' => '   ตัดใช้วัตถุดิบที่ใช้ผลิต(ใบยา)    ',
            'program_code' => 'PMP0007',
            'url' => '/pm/wip-issue'
            ],

            [
            'menu_id' => 10124,
            'parent_id' => 10001,
            'menu_title' => '   ตัดใช้วัตถุดิบที่ใช้ผลิต(สารปรุง/สารหอม)      ',
            'program_code' => 'PMP0048',
            'url' => '/pm/wip-issue/casing-flavor'
            ],

            [
            'menu_id' => 10125,
            'parent_id' => 10001,
            'menu_title' => 'แผนการจ่ายยาเส้นรายปักษ์',
            'program_code' => 'PMP0011',
            'url' => '/pm/planning-jobs'
            ],

            [
            'menu_id' => 10126,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกส่งสินค้าเข้าคลัง   ',
            'program_code' => 'PMP0044',
            'url' => '/pm/wip-requests'
            ],

            [
            'menu_id' => 10127,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกสูญเสีย     ',
            'program_code' => 'PMP0047',
            'url' => '/pm/wip-loss-quantity'
            ],

            [
            'menu_id' => 10128,
            'parent_id' => 10001,
            'menu_title' => '   รับวัตถุดิบหน้าจุดพัก     ',
            'program_code' => 'PMP0024',
            'url' => '/pm/qrcode-rcv-transfer-mtls'
            ],

            [
            'menu_id' => 10129,
            'parent_id' => 10001,
            'menu_title' => '   โอนสินค้าสำเร็จรูป',
            'program_code' => 'ยังไม่มี Program Code',
            'url' => ''
            ],

            // Duplicate
            // [
            // 'menu_id' => 10130,
            // 'parent_id' => 10001,
            // 'menu_title' => '   รายการขอเบิกวัตถุดิบ      ',
            // 'program_code' => 'PMP0004',
            // 'url' => '/pm/0004'
            // ],

            [
            'menu_id' => 10131,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกผลผลิต,สูญเสีย      ',
            'program_code' => 'PMP0031',
            'url' => '/pm/0031'
            ],

            [
            'menu_id' => 10132,
            'parent_id' => 10001,
            'menu_title' => '   ลงผลตรวจสอบหลังผลิต   ',
            'program_code' => 'PMP0039',
            'url' => '/pm/0045'
            ],

            [
            'menu_id' => 10133,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกตัดใช้วัตถุดิบการผลิต   ',
            'program_code' => 'PMP0051',
            'url' => '/pm/wip-issue/cut_of'
            ],

            [
            'menu_id' => 10134,
            'parent_id' => 10001,
            'menu_title' => '   โอนสินค้าสำเร็จรูป    ',
            'program_code' => 'PMP0038',
            'url' => '/pm/0043'
            ],

            [
            'menu_id' => 10135,
            'parent_id' => 10001,
            'menu_title' => '   แจ้งเตือนปริมาณคงคลังสารปรุง      ',
            'program_code' => 'PMP0025',
            'url' => '/pm/additive_inventory_alert'
            ],

            [
            'menu_id' => 10136,
            'parent_id' => 10001,
            'menu_title' => '   แจ้งเตือนปริมาณคงคลังวัตถุดิบ     ',
            'program_code' => 'PMP0026',
            'url' => '/pm/raw_material_inventory_alert'
            ],

            [
            'menu_id' => 10137,
            'parent_id' => 10001,
            'menu_title' => '   ลงผลตรวจสอบสารปรุงหลังหมดอายุ     ',
            'program_code' => 'PMP0036',
            'url' => '/pm/examine-casing-after-expiry-date'
            ],

            [
            'menu_id' => 10138,
            'parent_id' => 10001,
            'menu_title' => '   อนุมัติการขอเปลี่ยนแปลง   ',
            'program_code' => 'PMP0037',
            'url' => '/pm/approval-casing-new-expiry-date'
            ],

            // Duplicate
            // [
            // 'menu_id' => 10139,
            // 'parent_id' => 10001,
            // 'menu_title' => '   ตัดใช้วัตถุดิบที่ใช้ผลิต      ',
            // 'program_code' => 'PMP0051',
            // 'url' => '/pm/wip-issue/cut_of'
            // ],

            [
            'menu_id' => 10140,
            'parent_id' => 10001,
            'menu_title' => '   วางแผนยาเส้นภูมิภาค   ',
            'program_code' => 'PMP00053',
            ],


            [
            'menu_id' => 10141,
            'parent_id' => 10001,
            'menu_title' => '   วางแผนหน่วยบรรจุภูมิภาค   ',
            'program_code' => 'PMP0044',
            ],



            [
            'menu_id' => 10142,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกสิ่งพิมพ์เข้าคลัง   ',
            'program_code' => 'PMP0035',
            ],


            [
            'menu_id' => 10143,
            'parent_id' => 10001,
            'menu_title' => '   วางแผนผลิตสิ่งพิมพ์รายเดือน   ',
            'program_code' => 'PMP0033',
            'url' => '/pm/plans/monthly'
            ],

            [
            'menu_id' => 10144,
            'parent_id' => 10001,
            'menu_title' => '   วางแผนการผลิตสิ่งพิมพ์รายปักษ์    ',
            'program_code' => 'PMP0011',
            'url' => '/pm/plans/biweekly'
            ],

            [
            'menu_id' => 10145,
            'parent_id' => 10001,
            'menu_title' => '   อนุมัติแผนการผลิตสิ่งพิมพ์รายปักษ์',
            'program_code' => '',
            'url' => ''
            ],

            [
            'menu_id' => 10146,
            'parent_id' => 10001,
            'menu_title' => '   วางแผนผลิตสิ่งพิมพ์รายวัน     ',
            'program_code' => 'PMP0040',
            'url' => '/pm/plans/daily'
            ],

            [
            'menu_id' => 10147,
            'parent_id' => 10001,
            'menu_title' => '   ขอเบิกวัตถุดิบตามแผนรายปักษ์',
            'program_code' => '',
            'url' => ''
            ],


            [
            'menu_id' => 10148,
            'parent_id' => 10001,
            'menu_title' => '   เบิกวัตถุดิบเข้าหน้าเครื่องจักร   ',
            'program_code' => 'PMP0032',
            'url' => '/pm/products/machine-requests'
            ],

            [
            'menu_id' => 10149,
            'parent_id' => 10001,
            'menu_title' => '   ประมาณการใช้วัตถุดิบประจำปี   ',
            'program_code' => 'PMP0003',
            'url' => '/pm/plans/yearly'
            ],

            [
            'menu_id' => 10150,
            'parent_id' => 10001,
            'menu_title' => '   รายการขอเบิกวัตถุดิบ (จัดหา)      ',
            'program_code' => 'PMP0004',
            'program_code' => '',
            'url' => ''
            ],



            [
            'menu_id' => 10151,
            'parent_id' => 10001,
            'menu_title' => '   ตัดใช้วัตถุดิบที่ใช้ผลิต**    ',
            'program_code' => 'PMP0007',
            'url' => ''
            ],


            [
            'menu_id' => 10152,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกส่งสินค้าเข้าคลัง   ',
            'program_code' => 'PMP0044',
            'url' => '/pm/review-complete'
            ],

            [
            'menu_id' => 10153,
            'parent_id' => 10001,
            'menu_title' => '   บันทึกส่งสินค้าไปจัดหา    ',
            'program_code' => 'PMP0052',
            'url' => '/pm/products/wip-requests'
            ],



            [
            'menu_id' => 10154,
            'parent_id' => 10002,
            'menu_title' => '      สถานะสูตร       ',
            'program_code' => 'PMS0024',
            'url' => '/lookup?programCode=PMS0024'
            ],


            [
            'menu_id' => 10155,
            'parent_id' => 10002,
            'menu_title' => '      สถานะคำสั่งผลิต     ',
            'program_code' => 'PMS0011',
            'url' => '/lookup?programCode=PMS0011'
            ],


            [
            'menu_id' => 10156,
            'parent_id' => 10002,
            'menu_title' => '      สถานะประมาณการจัดเก็บบุหรี่     ',
            'program_code' => 'PMS0034',
            'url' => '/lookup?programCode=PMS0034'
            ],


            [
            'menu_id' => 10157,
            'parent_id' => 10002,
            'menu_title' => '      สถานะประมาณการวัตถุดิบ      ',
            'program_code' => 'PMS0008',
            'url' => '/lookup?programCode=PMS0008'
            ],


            [
            'menu_id' => 10158,
            'parent_id' => 10002,
            'menu_title' => '      สถานะการขอเบิก      ',
            'program_code' => 'PMS0003',
            'url' => '/lookup?programCode=PMS0003'
            ],


            [
            'menu_id' => 10159,
            'parent_id' => 10002,
            'menu_title' => '      สถานะตัดใช้วัตถุดิบ     ',
            'program_code' => 'PMS0025',
            'url' => '/lookup?programCode=PMS0025'
            ],


            [
            'menu_id' => 10160,
            'parent_id' => 10002,
            'menu_title' => '      สถานะการส่งสินค้าสำเร็จรูป      ',
            'program_code' => 'PMS0026',
            'url' => '/lookup?programCode=PMS0026'
            ],


            [
            'menu_id' => 10161,
            'parent_id' => 10002,
            'menu_title' => '      ประเภทสูตร      ',
            'program_code' => 'PMS0005',
            'url' => '/lookup?programCode=PMS0005'
            ],


            [
            'menu_id' => 10162,
            'parent_id' => 10002,
            'menu_title' => '      วัตถุประสงค์ในการเบิกวัตถุดิบ       ',
            'program_code' => 'PMS0009',
            'url' => '/lookup?programCode=PMS0009'
            ],


            [
            'menu_id' => 10163,
            'parent_id' => 10002,
            'menu_title' => '      ช่วงเวลาในการผลิต       ',
            'program_code' => 'PMS0040     ยังไม่มีหน้าจอ',
            ],



            [
            'menu_id' => 10164,
            'parent_id' => 10002,
            'menu_title' => '      รายการสูญเสีย       ',
            'program_code' => 'PMS0001',
            'url' => '/lookup?programCode=PMS0001'
            ],


            [
            'menu_id' => 10165,
            'parent_id' => 10002,
            'menu_title' => '      วัตถุประสงค์ในการส่งสินค้าสำเร็จรูป     ',
            'program_code' => 'PMS0027',
            'url' => '/lookup?programCode=PMS0027'
            ],


            [
            'menu_id' => 10166,
            'parent_id' => 10002,
            'menu_title' => '      บันทึกคลัง (ตัดใช้วัตถุดิบและรับผลผลิต)     ',
            'program_code' => 'PMS0022',
            'url' => '/pm/settings/org-tranfer'
            ],


            [
            'menu_id' => 10167,
            'parent_id' => 10002,
            'menu_title' => '      บันทึกคลัง (เบิกจัดหา)      ',
            'program_code' => 'PMS0032',
            'url' => '/pm/settings/setup-transfer'
            ],


            [
            'menu_id' => 10168,
            'parent_id' => 10002,
            'menu_title' => '      กลุ่มชุดเครื่องจักร (มวน)       ',
            'program_code' => 'PMS0013',
            'url' => '/lookup?programCode=PMS0013'
            ],


            [
            'menu_id' => 10169,
            'parent_id' => 10002,
            'menu_title' => '      ความสัมพันธ์ของชุดเครื่องจักร       ',
            'program_code' => 'PMS0028',
            'url' => '/pm/settings/machine-relation'
            ],


            [
            'menu_id' => 10170,
            'parent_id' => 10002,
            'menu_title' => '      กำหนดพื้นที่วางของ      ',
            'program_code' => 'PMS0030     ยังไม่มีหน้าจอ',
            ],



            [
            'menu_id' => 10171,
            'parent_id' => 10002,
            'menu_title' => '      กำหนดค่าเฝ้าระวัง       ',
            'program_code' => 'PMS0031',
            'url' => '/pm/settings/setup-min-max-by-item'
            ],


            [
            'menu_id' => 10172,
            'parent_id' => 10002,
            'menu_title' => '      ขั้นตอนการทำงาน     ',
            'program_code' => 'PMS0004',
            'url' => '/pm/settings/wip-step'
            ],


            [
            'menu_id' => 10173,
            'parent_id' => 10002,
            'menu_title' => '      สูตรการผลิต     ',
            'program_code' => 'PMS0033',
            'url' => '/pm/settings/production-formula'
            ],


            [
            'menu_id' => 10174,
            'parent_id' => 10002,
            'menu_title' => '      ตั้งค่าหัวจ่าย      ',
            'program_code' => 'PMS0018',
            'url' => '/lookup?programCode=PMS0018'
            ],


            [
            'menu_id' => 10175,
            'parent_id' => 10002,
            'menu_title' => '      ความสัมพันธ์การจ่าย     ',
            'program_code' => 'PMS0021',
            'url' => '/pm/settings/relation-feeder'
            ],


            [
            'menu_id' => 10176,
            'parent_id' => 10002,
            'menu_title' => '      สถานะการรับผลผลิตเข้าคลัง       ',
            'program_code' => 'PMS0041     ยังไม่มีหน้าจอ',
            ],



            [
            'menu_id' => 10177,
            'parent_id' => 10002,
            'menu_title' => '      กลุ่มชุดเครื่องจักร (ก้นกรอง)       ',
            'program_code' => 'PMS0012',
            'url' => '/lookup?programCode=PMS0012'
            ],

            // Duplicate
            // [
            // 'menu_id' => 10178,
            // 'parent_id' => 10002,
            // 'menu_title' => '      วัตถุประสงค์ในการส่งสินค้าสำเร็จรูป     ',
            // 'program_code' => 'PMS0026',
            // 'url' => '/lookup?programCode=PMS0026'
            // ],


            [
            'menu_id' => 10179,
            'parent_id' => 10002,
            'menu_title' => '      ตั้งค่าการแจ้งเตือนก่อนวันหมดอายุ',
            'program_code' => 'ยังไม่มี Program Code',
            'url' => ''
            ],



            [
            'menu_id' => 10180,
            'parent_id' => 10002,
            'menu_title' => '      สถานะตรวจสอบหลังผลิต',
            'program_code' => 'ยังไม่มี Program Code',
            'url' => ''
            ],




            [
            'menu_id' => 10181,
            'parent_id' => 10002,
            'menu_title' => '      สถานะตรวจสอบสารปรุง',
            'program_code' => 'ยังไม่มี Program Code',
            'url' => ''
            ],



            [
            'menu_id' => 10182,
            'parent_id' => 10002,
            'menu_title' => '      สถานะอนุมัติวันหมดอายุใหม่',
            'program_code' => 'ยังไม่มี Program Code',
            'url' => ''
            ],



            // Duplicate
            // [
            // 'menu_id' => 10183,
            // 'parent_id' => 10002,
            // 'menu_title' => '      บันทึกคลังสินค้าในการรับ-ส่งข้อมูล      ',
            // 'program_code' => 'PMS0022',
            // 'url' => '/pm/settings/org-tranfer'
            // ],


            [
            'menu_id' => 10184,
            'parent_id' => 10002,
            'menu_title' => '      อนุมัติสูตรการผลิต',
            'program_code' => 'ยังไม่มี Program Code',
            'url' => ''
            ],


            [
            'menu_id' => 10185,
            'parent_id' => 10002,
            'menu_title' => '      บันทึก Layout สิ่งพิมพ์     ',
            'program_code' => 'PMS0023',
            'url' => '/pm/settings/save-publication-layout'
            ],


            [
            'menu_id' => 10186,
            'parent_id' => 10002,
            'menu_title' => '      บันทึกการแปลงหน่วยสิ่งพิมพ์     ',
            'program_code' => 'PMS0036',
            'url' => '/pm/settings/print-conversion'
            ],


            [
            'menu_id' => 10187,
            'parent_id' => 10002,
            'menu_title' => '      ระบุกำลังผลิตรายเครื่อง     ',
            'program_code' => 'PMS0038',
            ],



            [
            'menu_id' => 10188,
            'parent_id' => 10002,
            'menu_title' => '      กำหนด Product ประเภทสิ่งพิมพ์       ',
            'program_code' => 'PMS0039',
            'url' => '/pm/settings/print-product-type'
            ],
        ];

        foreach ($menu1 as $menu) {
            $this->createMenu($menu);
        }
        foreach ($menu2 as $menu) {
            $this->createMenu($menu);
        }

        $this->deptTest(10000);
        $this->dept2(10002);
        $this->dept3(10003);
        $this->dept4(10004);
        $this->dept5(10005);
        $this->dept6(10006);
        $this->dept7(10007);
        $this->dept8(10008);
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
                    ->whereRaw("menu_id between 10000 and  20000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function deptTest($roleId)
    {
        $dataRole = [
            '/pm/material-requests?case=2',
            '/pm/0004',
            '/pm/production-order',
            '/pm/0031',
            '/pm/0045',
            '/pm/production-order-list',
            '/pm/wip-issue/cut_of',
            '/pm/wip-requests',
            '/pm/0043',
            '/pm/inventory-list',
            '/pm/additive_inventory_alert',
            '/pm/raw_material_inventory_alert',
            '/pm/examine-casing-after-expiry-date',
            '/pm/approval-casing-new-expiry-date',
            '/lookup?programCode=PMS0003',
            '/pm/settings/wip-step',
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0011',
            '/pm/settings/org-tranfer',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/pm/settings/setup-min-max-by-item',
            '/pm/settings/setup-transfer',
            '/pm/settings/production-formula',
        ];

        $menus = $this->getMenus($dataRole);
        $this->createRole($roleId, 'DEV2: กองทดลอง', 'PM', $menus);
    }

    public function dept2($roleId)
    {
        $dataRole = [
            '/pm/production-order',
            '/pm/0004',
            '/pm/request-raw-materials',
            '/pm/material-requests?case=2',
            '/pm/ingredient-preparation',
            '/pm/qrcode-check-mtls',
            '/pm/qrcode-rcv-transfer-mtls',
            '/pm/qrcode-return-mtls',
            '/pm/confirm-order',
            '/pm/wip-issue/issue',
            '/pm/wip-requests',
            '/pm/production-order-list',
            '/pm/inventory-list',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0008',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0009',
            '/pm/settings/org-tranfer',
            '/pm/settings/setup-transfer',
            '/lookup?programCode=PMS0012',
            '/pm/settings/machine-relation',
            '/pm/settings/setup-min-max-by-item',
            '/pm/settings/wip-step',
            '/pm/settings/production-formula',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all());
        $this->createRole($roleId, 'DEV2: กองผลิตก้นกรอง', 'PM', $menus);
    }

    public function dept3($roleId)
    {
        $dataRole = [
            '/pm/production-order',
            '/pm/jams',
            '/pm/material-requests',
            '/pm/wip-confirm',
            '/pm/wip-issue',
            '/pm/wip-issue/casing-flavor',
            '/pm/planning-jobs',
            '/pm/wip-requests',
            '/pm/wip-loss-quantity',
            '/pm/inventory-list',
            '/lookup?programCode=PMS0003',
            '/pm/settings/wip-step',
            '/lookup?programCode=PMS0008',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0011',
            '/pm/settings/org-tranfer',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/pm/settings/setup-min-max-by-item',
            '/pm/settings/setup-transfer',
            '/lookup?programCode=PMS0001',
            '/lookup?programCode=PMS0018',
            '/pm/settings/relation-feeder',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all());
        $this->createRole($roleId, 'DEV2: กองผลิตยาเส้น', 'PM', $menus);
    }

    public function dept4($roleId)
    {
        $dataRole = [
            '/pm/production-order',
            '/pm/jams',
            '/pm/material-requests',
            '/pm/wip-confirm',
            '/pm/wip-issue',
            '/pm/wip-requests',
            '/pm/inventory-list',
            '/lookup?programCode=PMS0003',
            '/pm/settings/wip-step',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0011',
            '/pm/settings/org-tranfer',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/pm/settings/setup-min-max-by-item',
            '/lookup?programCode=PMS0026',
            '/pm/settings/setup-transfer',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'DEV2: กองผลิตยาเส้นพอง', 'PM', $menus);
    }

    public function dept5($roleId)
    {
        $dataRole = [
            '/pm/plans/monthly',
            '/pm/plans/biweekly',
            '/pm/plans/daily',
            '/pm/products/machine-requests',
            '/pm/production-order',
            '/pm/plans/yearly',
            '/pm/material-requests',
            '/pm/0031',
            '/pm/review-complete',
            '/pm/inventory-list',
            '/pm/production-order-list',
            '/pm/products/wip-requests',
            '/lookup?programCode=PMS0003',
            '/pm/settings/wip-step',
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0008',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0011',
            '/pm/settings/org-tranfer',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0027',
            '/pm/settings/setup-min-max-by-item',
            '/pm/settings/setup-transfer',
            '/pm/settings/production-formula',
            '/pm/settings/save-publication-layout',
            '/pm/settings/print-conversion',
            '/pm/settings/print-product-type',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'DEV2: กองพิมพ์', 'PM', $menus);
    }

    public function dept6($roleId)
    {
        $dataRole = [
            '/pm/production-order',
            '/pm/send-cigarettes',
            '/pm/0004',
            '/pm/request-raw-materials',
            '/pm/material-requests?case=2',
            '/pm/ingredient-preparation',
            '/pm/qrcode-check-mtls',
            '/pm/qrcode-transfer-mtls',
            '/pm/qrcode-return-mtls',
            '/pm/raw_material_list',
            '/pm/raw_material_report',
            '/pm/confirm-order',
            '/pm/wip-issue/issue',
            '/pm/transfer-products',
            '/pm/production-order-list',
            '/pm/confirm-stamp-using?date=2021-07-15',
            '/pm/sample-cigarettes/2021-07-15',
            '/pm/free-products/2021-07-15',
            '/pm/inventory-list',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0011',
            '/lookup?programCode=PMS0034',
            '/lookup?programCode=PMS0008',
            '/lookup?programCode=PMS0003',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0009',
            '/lookup?programCode=PMS0001',
            '/lookup?programCode=PMS0027',
            '/pm/settings/org-tranfer',
            '/pm/settings/setup-transfer',
            '/lookup?programCode=PMS0013',
            '/pm/settings/machine-relation',
            '/pm/settings/setup-min-max-by-item',
            '/pm/settings/wip-step',
            '/pm/settings/production-formula',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'DEV2: กองมวนและบรรจุ', 'PM', $menus);
    }

    public function dept7($roleId)
    {
        $dataRole = [
            '/pm/production-order',
            '/pm/wip-issue/cut_of',
            '/pm/0031',
            '/pm/production-order-list',
            '/pm/settings/wip-step',
            '/lookup?programCode=PMS0005',
            '/lookup?programCode=PMS0011',
            '/pm/settings/org-tranfer',
            '/lookup?programCode=PMS0024',
            '/lookup?programCode=PMS0025',
            '/lookup?programCode=PMS0026',
            '/pm/settings/production-formula',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'DEV2: โรงอบใบยาเด่นชัย(หน่วยบรรจุภูมิภาค)', 'PM', $menus);
    }

    public function dept8($roleId)
    {
        $dataRole = [
            '/pm/production-order',
            '/pm/wip-issue/cut_of',
            '/pm/0031',
            '/pm/wip-requests',
            '/pm/production-order-list',
            '/pm/settings/wip-step',
            '/lookup?programCode=PMS0011',
            '/pm/settings/org-tranfer',
            '/lookup?programCode=PMS0025',
        ];

        $menus = $this->getMenus($dataRole);
        // dd('z', $dataRole, $menus->pluck('url')->all(), array_diff($menus->pluck('url')->all(), $dataRole));
        $this->createRole($roleId, 'DEV2: โรงอบใบยาเด่นชัย(หน่วยยาเส้นภูมิภาค)', 'PM', $menus);
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
