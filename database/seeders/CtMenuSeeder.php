<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class CtMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 150000 and  160000")->forceDelete();
        \App\Models\Menu::whereRaw("menu_id >= 150000 and menu_id <= 160000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 150000 and menu_id <= 160000")->delete();

        $menu1 = [
            [
                'menu_id' => 150000,
                'menu_title' => 'Setup', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 150000
            ],
            [
                'menu_id' => 150001,
                'menu_title' => 'Master', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 150001
            ],
            [
                'menu_id' => 150002,
                'menu_title' => 'Process', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 150002
            ],
            [
                'menu_id' => 150003,
                'menu_title' => 'Report ศูนย์อบ', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 150003
            ],
            [
                'menu_id' => 150004,
                'menu_title' => 'Report ศูนย์พิมพ์', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 150004
            ],
            [
                'menu_id' => 150005,
                'menu_title' => 'Report ศูนย์ยาเส้น ยาเส้นพอง ก้นกรอง มวน', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 150005
            ],
            [
                'menu_id' => 150006,
                'menu_title' => 'Report All', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 150006
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 150007,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดประเภทบัญชี',
                'program_code' => 'CTS0001',
                'url' => '/lookup?programCode=CTS0001'
            ],
            [
                'menu_id' => 150008,
                'parent_id' => 150000,
                'menu_title' => 'กำหนดรหัสเกณฑ์การปันส่วน',
                'program_code' => 'CTS0002',
                'url' => '/lookup?programCode=CTS0002'
            ],
            // 150009-150010
            



            [
                'menu_id' => 150011,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดศูนย์ต้นทุน',
                'program_code' => 'CTM0001',
                'url' => '/ct/cost_center'
            ],
            [
                'menu_id' => 150012,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดกลุ่มผลิตภัณฑ์',
                'program_code' => 'CTM0002',
                'url' => '/ct/product_group'
            ],
            [
                'menu_id' => 150013,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดบัญชีและหน่วยงาน',
                'program_code' => 'CTM0004',
                'url' => '/ct/set_account_type'
            ],
            [
                'menu_id' => 150014,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดเปอร์เซ็นต์เทียบสำเร็จ',
                'program_code' => 'CTM0005',
                'url' => '/ct/specify_percentage'
            ],
            [
                'menu_id' => 150015,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดรหัสบัญชีเพื่อเชื่อมโยงไประบบบัญชีแยกประเภททั่วไป',
                'program_code' => 'CTM0006',
                'url' => '/ct/account_code_ledger'
            ],
            [
                'menu_id' => 150016,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดเกณฑ์การปันส่วน',
                'program_code' => 'CTM0008',
                'url' => '/ct/allocate-ratios'
            ],
            [
                'menu_id' => 150017,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดปริมาณผลผลิตตามแผน',
                'program_code' => 'CTM0009',
                'url' => '/ct/product_plan_amount'
            ],
            [
                'menu_id' => 150019,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดการจัดกลุ่มบัญชีค่าใช้จ่ายตามหน่วยงาน',
                'program_code' => 'CTM0011',
                'url' => '/ct/grouping_expense'
            ],
            [
                'menu_id' => 150020,
                'parent_id' => 150001,
                'menu_title' => 'นำเข้าข้อมูลราคาซื้อ',
                'program_code' => 'CTM0012',
                'url' => '/ct/purchase_price_info'
            ],
            [
                'menu_id' => 150021,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดรหัสภาษีใบยา',
                'program_code' => 'CTM0013',
                'url' => '/ct/tax_medicine'
            ],
            [
                'menu_id' => 150022,
                'parent_id' => 150001,
                'menu_title' => 'ต้นทุนวัตถุดิบมาตรฐาน',
                'program_code' => 'CTM0014',
                'url' => '/ct/std_raw_material_cost'
            ],
            [
                'menu_id' => 150023,
                'parent_id' => 150001,
                'menu_title' => 'ต้นทุนมาตรฐานค่าแรงค่าใช้จ่ายการผลิต',
                'program_code' => 'CTM0015',
                'url' => '/ct/std-costs'
            ],
            [
                'menu_id' => 150024,
                'parent_id' => 150001,
                'menu_title' => 'ต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต',
                'program_code' => 'CTM0017',
                'url' => '/ct/oem-costs'
            ],
            [
                'menu_id' => 150025,
                'parent_id' => 150001,
                'menu_title' => 'กระดาษทำการต้นทุนมาตรฐาน',
                'program_code' => 'CTM0018',
                'url' => '/ct/std-cost-papers'
            ],
            [
                'menu_id' => 150026,
                'parent_id' => 150001,
                'menu_title' => 'สอบถามราคาต้นทุนมาตรฐาน INVENTORY',
                'program_code' => 'CTM0019',
                'url' => '/ct/std-cost-inquiries'
            ],
            [
                'menu_id' => 150027,
                'parent_id' => 150001,
                'menu_title' => 'กำหนดการปันส่วนแสตมป์',
                'program_code' => 'CTM0020',
                'url' => '/ct/stamp_adj'
            ],
            // 150028-150035

            [
                'menu_id' => 150036,
                'parent_id' => 150002,
                'menu_title' => 'ประมวลผลข้อมูลคำสั่งผลิต',
                'program_code' => 'CTP0101',
                'url' => '/ct/workorders/processes'
            ],
            [
                'menu_id' => 150038,
                'parent_id' => 150002,
                'menu_title' => 'สอบถามข้อมูลการเบิกใช้วัตถุดิบ',
                'program_code' => 'CTP0002',
                'url' => '/ct/raw_material_information'
            ],
            [
                'menu_id' => 150039,
                'parent_id' => 150002,
                'menu_title' => 'สอบถามการบันทึกผลผลิต',
                'program_code' => 'CTP0003',
                'url' => '/ct/inquire_production'
            ],
            [
                'menu_id' => 150040,
                'parent_id' => 150002,
                'menu_title' => 'ต้นทุนขายแยกแสตมป์และกองทุน',
                'program_code' => 'CTP0005',
                'url' => '/ct/stamp-adjust/process'
            ],
            // 150041-150045




            [
                'menu_id' => 150046,
                'parent_id' => 150003,
                'menu_title' => 'รายงานตรวจสอบยอดรวมการบันทึกบัญชีประจำวัน',
                'program_code' => 'CTR0001',
                'url' => '/report/report-info?program_code=CTR0001'
            ],
            [
                'menu_id' => 150047,
                'parent_id' => 150003,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริง',
                'program_code' => 'CTR0006',
                'url' => '/report/report-info?program_code=CTR0006'
            ],
            [
                'menu_id' => 150048,
                'parent_id' => 150003,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม',
                'program_code' => 'CTR0008',
                'url' => '/report/report-info?program_code=CTR0008'
            ],
            [
                'menu_id' => 150049,
                'parent_id' => 150003,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามคำสั่งผลิต',
                'program_code' => 'CTR0009',
                'url' => '/report/report-info?program_code=CTR0009'
            ],
            [
                'menu_id' => 150050,
                'parent_id' => 150003,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์',
                'program_code' => 'CTR0010',
                'url' => '/report/report-info?program_code=CTR0010'
            ],
            [
                'menu_id' => 150051,
                'parent_id' => 150003,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงาน(สรุป)',
                'program_code' => 'CTR0019',
                'url' => '/ct/ctr0019'
            ],
            [
                'menu_id' => 150052,
                'parent_id' => 150003,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงาน(ละเอียด)',
                'program_code' => 'CTR0020',
                'url' => '/ct/ctr0020'
            ],
            [
                'menu_id' => 150053,
                'parent_id' => 150003,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงานให้ศูนย์ต้นทุน',
                'program_code' => 'CTR0021',
                'url' => '/ct/ctr0021'
            ],
            [
                'menu_id' => 150054,
                'parent_id' => 150003,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของศูนย์ต้นทุนให้กลุ่มผลิตภัณฑ์',
                'program_code' => 'CTR0022',
                'url' => '/ct/ctr0022'
            ],
            [
                'menu_id' => 150055,
                'parent_id' => 150003,
                'menu_title' => 'รายงานกระดาษทำการต้นทุนวัตถุดิบมาตรฐาน',
                'program_code' => 'CTR0023',
                'url' => '/ct/ctr0023'
            ],
            [
                'menu_id' => 150056,
                'parent_id' => 150003,
                'menu_title' => 'รายงานบัตรต้นทุนมาตรฐาน',
                'program_code' => 'CTR0024',
                'url' => '/ct/ctr0024'
            ],
            [
                'menu_id' => 150057,
                'parent_id' => 150003,
                'menu_title' => 'รายงานอัตรามาตรฐานค่าแรงและค่าใช้จ่าย',
                'program_code' => 'CTR0025',
                'url' => '/report/report-info?program_code=CTR0025'
            ],
            [
                'menu_id' => 150058,
                'parent_id' => 150003,
                'menu_title' => 'รายงานอัตรามาตรฐาน',
                'program_code' => 'CTR0026',
                'url' => '/ct/ctr0026'
            ],
            [
                'menu_id' => 150059,
                'parent_id' => 150003,
                'menu_title' => 'รายงานบัตรต้นทุนแยกตามพันธุ์ใบยา',
                'program_code' => 'TTCTRP72',
                'url' => '/report/report-info?program_code=TTCTRP72'
            ],
            [
                'menu_id' => 150060,
                'parent_id' => 150003,
                'menu_title' => 'รายงานสรุปบัตรต้นทุนแยกตามพันธ์ใบยา(รวมทุกโรงอบ)',
                'program_code' => 'TTCTRP85',
                'url' => '/report/report-info?program_code=TTCTRP85'
            ],
            [
                'menu_id' => 150061,
                'parent_id' => 150003,
                'menu_title' => 'รายงานการใช้วัตถุดิบและเปรียบเทียบผลต่าง',
                'program_code' => 'CTR0034',
                'url' => '/report/report-info?program_code=CTR0034'
            ],
            [
                'menu_id' => 150062,
                'parent_id' => 150003,
                'menu_title' => 'รายงานสรุปต้นทุนการผลิต',
                'program_code' => 'CTR0035',
                'url' => '/report/report-info?program_code=CTR0035'
            ],
            [
                'menu_id' => 150063,
                'parent_id' => 150003,
                'menu_title' => 'รายงานสินค้าจำหน่ายต่างประเทศ',
                'program_code' => 'OMR0082',
                'url' => '/report/report-info?program_code=OMR0082'
            ],
            [
                'menu_id' => 150064,
                'parent_id' => 150003,
                'menu_title' => 'รายงานผลผลิต(สารปรุง,สินค้าทดลอง)',
                'program_code' => 'PMR1030',
                'url' => '/report/report-info?program_code=PMR1030'
            ],
            // 150065-150070



            // Report ศูนย์พิมพ์
            [
                'menu_id' => 150071,
                'parent_id' => 150004,
                'menu_title' => 'รายงานตรวจสอบยอดรวมการบันทึกบัญชีประจำวัน',
                'program_code' => 'CTR0001',
                'url' => '/report/report-info?program_code=CTR0001'
            ],
            [
                'menu_id' => 150072,
                'parent_id' => 150004,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริง',
                'program_code' => 'CTR0006',
                'url' => '/report/report-info?program_code=CTR0006'
            ],
            // [
            //     'menu_id' => 150073,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม',
            //     'program_code' => 'CTR0008',
            //     'url' => '/report/report-info?program_code=CTR0008'
            // ],
            // [
            //     'menu_id' => 150074,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามคำสั่งผลิต',
            //     'program_code' => 'CTR0009',
            //     'url' => '/report/report-info?program_code=CTR0009'
            // ],
            // [
            //     'menu_id' => 150075,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์',
            //     'program_code' => 'CTR0010',
            //     'url' => '/report/report-info?program_code=CTR0010'
            // ],
            // [
            //     'menu_id' => 150076,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานต้นทุนการผลิตสินค้าสำเร็จรูปต่อหน่วย',
            //     'program_code' => 'CTR0016',
            //     'url' => '/report/report-info?program_code=CTR0016'
            // ],
            // [
            //     'menu_id' => 150077,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงาน(สรุป)',
            //     'program_code' => 'CTR0019',
            //     'url' => '/ct/ctr0019'
            // ],
            // [
            //     'menu_id' => 150078,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงาน(ละเอียด)',
            //     'program_code' => 'CTR0020',
            //     'url' => '/ct/ctr0020'
            // ],
            // [
            //     'menu_id' => 150079,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงานให้ศูนย์ต้นทุน',
            //     'program_code' => 'CTR0021',
            //     'url' => '/ct/ctr0021'
            // ],
            // [
            //     'menu_id' => 150080,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานกระดาษทำการปันส่วนของศูนย์ต้นทุนให้กลุ่มผลิตภัณฑ์',
            //     'program_code' => 'CTR0022',
            //     'url' => '/ct/ctr0022'
            // ],
            // [
            //     'menu_id' => 150081,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานกระดาษทำการต้นทุนวัตถุดิบมาตรฐาน',
            //     'program_code' => 'CTR0023',
            //     'url' => '/ct/ctr0023'
            // ],
            // [
            //     'menu_id' => 150082,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานบัตรต้นทุนมาตรฐาน',
            //     'program_code' => 'CTR0024',
            //     'url' => '/ct/ctr0024'
            // ],
            // [
            //     'menu_id' => 150083,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานอัตรามาตรฐานค่าแรงและค่าใช้จ่าย',
            //     'program_code' => 'CTR0025',
            //     'url' => '/report/report-info?program_code=CTR0025'
            // ],
            // [
            //     'menu_id' => 150084,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานอัตรามาตรฐาน',
            //     'program_code' => 'CTR0026',
            //     'url' => '/ct/ctr0026'
            // ],
            [
                'menu_id' => 150085,
                'parent_id' => 150004,
                'menu_title' => 'กระดาษทำการคำนวณค่าวัตถุดิบ-มาตรฐาน(สิ่งพิมพ์สำเร็จรูป)',
                'program_code' => 'CTR0027',
                'url' => '/report/report-info?program_code=CTR0027'
            ],
            [
                'menu_id' => 150086,
                'parent_id' => 150004,
                'menu_title' => 'รายงานบัตรต้นทุนประจำวัน(สิ่งพิมพ์สำเร็จรูป)',
                'program_code' => 'CTR0028',
                'url' => '/report/report-info?program_code=CTR0028'
            ],
            [
                'menu_id' => 150087,
                'parent_id' => 150004,
                'menu_title' => 'กระดาษทำการคำนวณต้นทุนมาตราฐาน-งานระหว่างผลิต(ปลายงวด)',
                'program_code' => 'CTR0029',
                'url' => '/ct/ctr0029'
            ],
            [
                'menu_id' => 150088,
                'parent_id' => 150004,
                'menu_title' => 'รายงานสรุปสิ่งพิมพ์ระหว่างผลิตปลายงวด',
                'program_code' => 'CTR0030',
                'url' => '/ct/ctr0030'
            ],
            [
                'menu_id' => 150089,
                'parent_id' => 150004,
                'menu_title' => 'รายงานสูญเสียสิ่งพิมพ์',
                'program_code' => 'CTR1050',
                'url' => '/report/report-info?program_code=CTR1050'
            ],
            [
                'menu_id' => 150090,
                'parent_id' => 150004,
                'menu_title' => 'รายงานการพิมพ์',
                'program_code' => 'CTR1120',
                'url' => '/report/report-info?program_code=CTR1120'
            ],
            [
                'menu_id' => 150091,
                'parent_id' => 150004,
                'menu_title' => 'รายงานการตัดและบรรจุ',
                'program_code' => 'CTR1130',
                'url' => '/report/report-info?program_code=CTR1130'
            ],
            [
                'menu_id' => 150092,
                'parent_id' => 150004,
                'menu_title' => 'รายงานผลผลิตประจำวันแยกตามคำสั่งการผลิต',
                'program_code' => 'PDR1150',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR1150'
            ],
            [
                'menu_id' => 150093,
                'parent_id' => 150004,
                'menu_title' => 'รายงานผลผลิตประจำวันแยกตามวันที่ผลิต',
                'program_code' => 'PDR1180',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR1180'
            ],
            [
                'menu_id' => 150094,
                'parent_id' => 150004,
                'menu_title' => 'รายงานผลผลิตประจำวันยอดรวม',
                'program_code' => 'PDR2040',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR2040'
            ],
            [
                'menu_id' => 150095,
                'parent_id' => 150004,
                'menu_title' => 'รายงานผลต่างวัตถุดิบ-สิ่งพิมพ์สำเร็จรูป',
                'program_code' => 'CTR0031',
                'url' => '/report/report-info?program_code=CTR0031'
            ],
            [
                'menu_id' => 150096,
                'parent_id' => 150004,
                'menu_title' => 'รายงานผลต่างวัตถุดิบ-สิ่งพิมพ์สำเร็จรูป(สตง.)',
                'program_code' => 'CTR0032',
                'url' => '/report/report-info?program_code=CTR0032'
            ],
            [
                'menu_id' => 150097,
                'parent_id' => 150004,
                'menu_title' => 'รายงานสรุปต้นทุนการผลิต',
                'program_code' => 'CTR0035',
                'url' => '/report/report-info?program_code=CTR0035'
            ],
            // [
            //     'menu_id' => 150098,
            //     'parent_id' => 150004,
            //     'menu_title' => 'รายงานผลผลิต(สารปรุง,สินค้าทดลอง)',
            //     'program_code' => 'PMR1030',
            //     'url' => '/report/report-info?program_code=PMR1030'
            // ],
            // 150099-150100




            [
                'menu_id' => 150101,
                'parent_id' => 150005,
                'menu_title' => 'รายงานตรวจสอบยอดรวมการบันทึกบัญชีประจำวัน',
                'program_code' => 'CTR0001',
                'url' => '/report/report-info?program_code=CTR0001'
            ],
            [
                'menu_id' => 150102,
                'parent_id' => 150005,
                'menu_title' => 'กระดาษทำการคำนวณค่าวัตถุดิบ-มาตรฐานและคิดเข้างาน',
                'program_code' => 'CTR0002',
                'url' => '/report/report-info?program_code=CTR0002'
            ],
            [
                'menu_id' => 150103,
                'parent_id' => 150005,
                'menu_title' => 'กระดาษทำการคำนวณค่าวัตถุดิบ-คิดเข้างาน',
                'program_code' => 'CTR0003',
                'url' => '/report/report-info?program_code=CTR0003'
            ],
            [
                'menu_id' => 150104,
                'parent_id' => 150005,
                'menu_title' => 'รายงานบัตรต้นทุนประจำวัน',
                'program_code' => 'CTR0004',
                'url' => '/report/report-info?program_code=CTR0004'
            ],
            [
                'menu_id' => 150105,
                'parent_id' => 150005,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริง',
                'program_code' => 'CTR0006',
                'url' => '/report/report-info?program_code=CTR0006'
            ],
            [
                'menu_id' => 150106,
                'parent_id' => 150005,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม',
                'program_code' => 'CTR0008',
                'url' => '/report/report-info?program_code=CTR0008'
            ],
            [
                'menu_id' => 150107,
                'parent_id' => 150005,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามคำสั่งผลิต',
                'program_code' => 'CTR0009',
                'url' => '/report/report-info?program_code=CTR0009'
            ],
            [
                'menu_id' => 150108,
                'parent_id' => 150005,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์',
                'program_code' => 'CTR0010',
                'url' => '/report/report-info?program_code=CTR0010'
            ],
            [
                'menu_id' => 150109,
                'parent_id' => 150005,
                'menu_title' => 'รายงานสรุปงานระหว่างผลิตปลายงวด',
                'program_code' => 'CTR0011',
                'url' => '/report/report-info?program_code=CTR0011'
            ],
            [
                'menu_id' => 150110,
                'parent_id' => 150005,
                'menu_title' => 'รายงานผลต่างวัตถุดิบ',
                'program_code' => 'CTR0012',
                'url' => '/report/report-info?program_code=CTR0012'
            ],
            [
                'menu_id' => 150111,
                'parent_id' => 150005,
                'menu_title' => 'รายงานสรุปบัตรต้นทุน',
                'program_code' => 'CTR0013',
                'url' => '/report/report-info?program_code=CTR0013'
            ],
            [
                'menu_id' => 150112,
                'parent_id' => 150005,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงาน(สรุป)',
                'program_code' => 'CTR0019',
                'url' => '/ct/ctr0019'
            ],
            [
                'menu_id' => 150113,
                'parent_id' => 150005,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงาน(ละเอียด)',
                'program_code' => 'CTR0020',
                'url' => '/ct/ctr0020'
            ],
            [
                'menu_id' => 150114,
                'parent_id' => 150005,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงานให้ศูนย์ต้นทุน',
                'program_code' => 'CTR0021',
                'url' => '/ct/ctr0021'
            ],
            [
                'menu_id' => 150115,
                'parent_id' => 150005,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของศูนย์ต้นทุนให้กลุ่มผลิตภัณฑ์',
                'program_code' => 'CTR0022',
                'url' => '/ct/ctr0022'
            ],
            [
                'menu_id' => 150116,
                'parent_id' => 150005,
                'menu_title' => 'รายงานกระดาษทำการต้นทุนวัตถุดิบมาตรฐาน',
                'program_code' => 'CTR0023',
                'url' => '/ct/ctr0023'
            ],
            [
                'menu_id' => 150117,
                'parent_id' => 150005,
                'menu_title' => 'รายงานบัตรต้นทุนมาตรฐาน',
                'program_code' => 'CTR0024',
                'url' => '/ct/ctr0024'
            ],
            [
                'menu_id' => 150118,
                'parent_id' => 150005,
                'menu_title' => 'รายงานอัตรามาตรฐานค่าแรงและค่าใช้จ่าย',
                'program_code' => 'CTR0025',
                'url' => '/report/report-info?program_code=CTR0025'
            ],
            [
                'menu_id' => 150119,
                'parent_id' => 150005,
                'menu_title' => 'รายงานอัตรามาตรฐาน',
                'program_code' => 'CTR0026',
                'url' => '/ct/ctr0026'
            ],
            [
                'menu_id' => 150120,
                'parent_id' => 150005,
                'menu_title' => 'รายงานผลผลิตประจำวันแยกตามคำสั่งการผลิต',
                'program_code' => 'PDR1150',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR1150'
            ],
            [
                'menu_id' => 150121,
                'parent_id' => 150005,
                'menu_title' => 'รายงานผลผลิตประจำวันแยกตามวันที่ผลิต',
                'program_code' => 'PDR1180',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR1180'
            ],
            [
                'menu_id' => 150122,
                'parent_id' => 150005,
                'menu_title' => 'รายงานผลผลิตประจำวันยอดรวม',
                'program_code' => 'PDR2040',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR2040'
            ],
            [
                'menu_id' => 150123,
                'parent_id' => 150005,
                'menu_title' => 'รายงานสรุปต้นทุนการผลิต',
                'program_code' => 'CTR0035',
                'url' => '/report/report-info?program_code=CTR0035'
            ],
            [
                'menu_id' => 150124,
                'parent_id' => 150005,
                'menu_title' => 'รายงานบุหรี่ระหว่างทาง (ยอดขนแต่ยังไม่ได้ขาย)',
                'program_code' => 'CTR0037',
                'url' => '/report/report-info?program_code=CTR0037'
            ],
            [
                'menu_id' => 150125,
                'parent_id' => 150005,
                'menu_title' => 'ยอดการจำหน่ายบุหรี่ยาเส้น ประจำเดือนยอดสะสม (รต/3)',
                'program_code' => 'OMR0056',
                'url' => '/report/report-info?program_code=OMR0056'
            ],
            [
                'menu_id' => 150126,
                'parent_id' => 150005,
                'menu_title' => 'ยอดจำหน่ายบุหรี่ในประเทศ',
                'program_code' => 'OMR0062',
                'url' => '/report/report-info?program_code=OMR0062'
            ],
            [
                'menu_id' => 150127,
                'parent_id' => 150005,
                'menu_title' => 'รายงานผลผลิต(สารปรุง,สินค้าทดลอง)',
                'program_code' => 'PMR1030',
                'url' => '/report/report-info?program_code=PMR1030'
            ],
            // 150128-150130





            [
                'menu_id' => 150131,
                'parent_id' => 150006,
                'menu_title' => 'รายงานตรวจสอบยอดรวมการบันทึกบัญชีประจำวัน',
                'program_code' => 'CTR0001',
                'url' => '/report/report-info?program_code=CTR0001'
            ],
            [
                'menu_id' => 150132,
                'parent_id' => 150006,
                'menu_title' => 'กระดาษทำการคำนวณค่าวัตถุดิบ-มาตรฐานและคิดเข้างาน',
                'program_code' => 'CTR0002',
                'url' => '/report/report-info?program_code=CTR0002'
            ],
            [
                'menu_id' => 150133,
                'parent_id' => 150006,
                'menu_title' => 'กระดาษทำการคำนวณค่าวัตถุดิบ-คิดเข้างาน',
                'program_code' => 'CTR0003',
                'url' => '/report/report-info?program_code=CTR0003'
            ],
            [
                'menu_id' => 150134,
                'parent_id' => 150006,
                'menu_title' => 'รายงานบัตรต้นทุนประจำวัน',
                'program_code' => 'CTR0004',
                'url' => '/report/report-info?program_code=CTR0004'
            ],
            [
                'menu_id' => 150135,
                'parent_id' => 150006,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริง',
                'program_code' => 'CTR0006',
                'url' => '/report/report-info?program_code=CTR0006'
            ],
            [
                'menu_id' => 150136,
                'parent_id' => 150006,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม',
                'program_code' => 'CTR0008',
                'url' => '/report/report-info?program_code=CTR0008'
            ],
            [
                'menu_id' => 150137,
                'parent_id' => 150006,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามคำสั่งผลิต',
                'program_code' => 'CTR0009',
                'url' => '/report/report-info?program_code=CTR0009'
            ],
            [
                'menu_id' => 150138,
                'parent_id' => 150006,
                'menu_title' => 'รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์',
                'program_code' => 'CTR0010',
                'url' => '/report/report-info?program_code=CTR0010'
            ],
            [
                'menu_id' => 150139,
                'parent_id' => 150006,
                'menu_title' => 'รายงานสรุปงานระหว่างผลิตปลายงวด',
                'program_code' => 'CTR0011',
                'url' => '/report/report-info?program_code=CTR0011'
            ],
            [
                'menu_id' => 150140,
                'parent_id' => 150006,
                'menu_title' => 'รายงานผลต่างวัตถุดิบ',
                'program_code' => 'CTR0012',
                'url' => '/report/report-info?program_code=CTR0012'
            ],
            [
                'menu_id' => 150141,
                'parent_id' => 150006,
                'menu_title' => 'รายงานสรุปบัตรต้นทุน',
                'program_code' => 'CTR0013',
                'url' => '/report/report-info?program_code=CTR0013'
            ],
            [
                'menu_id' => 150142,
                'parent_id' => 150006,
                'menu_title' => 'รายงานต้นทุนการผลิตสินค้าสำเร็จรูปต่อหน่วย',
                'program_code' => 'CTR0016',
                'url' => '/report/report-info?program_code=CTR0016'
            ],
            [
                'menu_id' => 150143,
                'parent_id' => 150006,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงาน(สรุป)',
                'program_code' => 'CTR0019',
                'url' => '/ct/ctr0019'
            ],
            [
                'menu_id' => 150144,
                'parent_id' => 150006,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงาน(ละเอียด)',
                'program_code' => 'CTR0020',
                'url' => '/ct/ctr0020'
            ],
            [
                'menu_id' => 150145,
                'parent_id' => 150006,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของหน่วยงานให้ศูนย์ต้นทุน',
                'program_code' => 'CTR0021',
                'url' => '/ct/ctr0021'
            ],
            [
                'menu_id' => 150146,
                'parent_id' => 150006,
                'menu_title' => 'รายงานกระดาษทำการปันส่วนของศูนย์ต้นทุนให้กลุ่มผลิตภัณฑ์',
                'program_code' => 'CTR0022',
                'url' => '/ct/ctr0022'
            ],
            [
                'menu_id' => 150147,
                'parent_id' => 150006,
                'menu_title' => 'รายงานกระดาษทำการต้นทุนวัตถุดิบมาตรฐาน',
                'program_code' => 'CTR0023',
                'url' => '/ct/ctr0023'
            ],
            [
                'menu_id' => 150148,
                'parent_id' => 150006,
                'menu_title' => 'รายงานบัตรต้นทุนมาตรฐาน',
                'program_code' => 'CTR0024',
                'url' => '/ct/ctr0024'
            ],
            [
                'menu_id' => 150149,
                'parent_id' => 150006,
                'menu_title' => 'รายงานอัตรามาตรฐานค่าแรงและค่าใช้จ่าย',
                'program_code' => 'CTR0025',
                'url' => '/report/report-info?program_code=CTR0025'
            ],
            [
                'menu_id' => 150150,
                'parent_id' => 150006,
                'menu_title' => 'รายงานอัตรามาตรฐาน',
                'program_code' => 'CTR0026',
                'url' => '/ct/ctr0026'
            ],
            [
                'menu_id' => 150151,
                'parent_id' => 150006,
                'menu_title' => 'กระดาษทำการคำนวณค่าวัตถุดิบ-มาตรฐาน(สิ่งพิมพ์สำเร็จรูป)',
                'program_code' => 'CTR0027',
                'url' => '/report/report-info?program_code=CTR0027'
            ],
            [
                'menu_id' => 150152,
                'parent_id' => 150006,
                'menu_title' => 'รายงานบัตรต้นทุนประจำวัน(สิ่งพิมพ์สำเร็จรูป)',
                'program_code' => 'CTR0028',
                'url' => '/report/report-info?program_code=CTR0028'
            ],
            [
                'menu_id' => 150153,
                'parent_id' => 150006,
                'menu_title' => 'กระดาษทำการคำนวณต้นทุนมาตราฐาน-งานระหว่างผลิต(ปลายงวด)',
                'program_code' => 'CTR0029',
                'url' => '/ct/ctr0029'
            ],
            [
                'menu_id' => 150154,
                'parent_id' => 150006,
                'menu_title' => 'รายงานสรุปสิ่งพิมพ์ระหว่างผลิตปลายงวด',
                'program_code' => 'CTR0030',
                'url' => '/ct/ctr0030'
            ],
            [
                'menu_id' => 150155,
                'parent_id' => 150006,
                'menu_title' => 'รายงานสูญเสียสิ่งพิมพ์',
                'program_code' => 'CTR1050',
                'url' => '/report/report-info?program_code=CTR1050'
            ],
            [
                'menu_id' => 150156,
                'parent_id' => 150006,
                'menu_title' => 'รายงานการพิมพ์',
                'program_code' => 'CTR1120',
                'url' => '/report/report-info?program_code=CTR1120'
            ],
            [
                'menu_id' => 150157,
                'parent_id' => 150006,
                'menu_title' => 'รายงานการตัดและบรรจุ',
                'program_code' => 'CTR1130',
                'url' => '/report/report-info?program_code=CTR1130'
            ],
            [
                'menu_id' => 150158,
                'parent_id' => 150006,
                'menu_title' => 'รายงานผลผลิตประจำวันแยกตามคำสั่งการผลิต',
                'program_code' => 'PDR1150',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR1150'
            ],
            [
                'menu_id' => 150159,
                'parent_id' => 150006,
                'menu_title' => 'รายงานผลผลิตประจำวันแยกตามวันที่ผลิต',
                'program_code' => 'PDR1180',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR1180'
            ],
            [
                'menu_id' => 150160,
                'parent_id' => 150006,
                'menu_title' => 'รายงานผลผลิตประจำวันยอดรวม',
                'program_code' => 'PDR2040',
                'url' => '/pm/wip-confirm/export-pdf-parameters/PDR2040'
            ],
            [
                'menu_id' => 150161,
                'parent_id' => 150006,
                'menu_title' => 'รายงานผลต่างวัตถุดิบ-สิ่งพิมพ์สำเร็จรูป',
                'program_code' => 'CTR0031',
                'url' => '/report/report-info?program_code=CTR0031'
            ],
            [
                'menu_id' => 150162,
                'parent_id' => 150006,
                'menu_title' => 'รายงานผลต่างวัตถุดิบ-สิ่งพิมพ์สำเร็จรูป(สตง.)',
                'program_code' => 'CTR0032',
                'url' => '/report/report-info?program_code=CTR0032'
            ],
            [
                'menu_id' => 150163,
                'parent_id' => 150006,
                'menu_title' => 'รายงานบัตรต้นทุนแยกตามพันธุ์ใบยา',
                'program_code' => 'TTCTRP72',
                'url' => '/report/report-info?program_code=TTCTRP72'
            ],
            [
                'menu_id' => 150164,
                'parent_id' => 150006,
                'menu_title' => 'รายงานสรุปบัตรต้นทุนแยกตามพันธ์ใบยา(รวมทุกโรงอบ)',
                'program_code' => 'TTCTRP85',
                'url' => '/report/report-info?program_code=TTCTRP85'
            ],
            [
                'menu_id' => 150165,
                'parent_id' => 150006,
                'menu_title' => 'รายงานการใช้วัตถุดิบและเปรียบเทียบผลต่าง',
                'program_code' => 'CTR0034',
                'url' => '/report/report-info?program_code=CTR0034'
            ],
            [
                'menu_id' => 150166,
                'parent_id' => 150006,
                'menu_title' => 'รายงานสรุปต้นทุนการผลิต',
                'program_code' => 'CTR0035',
                'url' => '/report/report-info?program_code=CTR0035'
            ],
            [
                'menu_id' => 150167,
                'parent_id' => 150006,
                'menu_title' => 'รายงานบุหรี่ระหว่างทาง (ยอดขนแต่ยังไม่ได้ขาย)',
                'program_code' => 'CTR0037',
                'url' => '/report/report-info?program_code=CTR0037'
            ],
            [
                'menu_id' => 150168,
                'parent_id' => 150006,
                'menu_title' => 'ยอดการจำหน่ายบุหรี่ยาเส้น ประจำเดือนยอดสะสม (รต/3)',
                'program_code' => 'OMR0056',
                'url' => '/report/report-info?program_code=OMR0056'
            ],
            [
                'menu_id' => 150169,
                'parent_id' => 150006,
                'menu_title' => 'ยอดจำหน่ายบุหรี่ในประเทศ',
                'program_code' => 'OMR0062',
                'url' => '/report/report-info?program_code=OMR0062'
            ],
            [
                'menu_id' => 150170,
                'parent_id' => 150006,
                'menu_title' => 'รายงานสินค้าจำหน่ายต่างประเทศ',
                'program_code' => 'OMR0082',
                'url' => '/report/report-info?program_code=OMR0082'
            ],
            [
                'menu_id' => 150171,
                'parent_id' => 150006,
                'menu_title' => 'รายงานผลผลิต(สารปรุง,สินค้าทดลอง)',
                'program_code' => 'PMR1030',
                'url' => '/report/report-info?program_code=PMR1030'
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
            '/lookup?programCode=CTS0001'
            , '/lookup?programCode=CTS0002'
            , '/ct/cost_center'
            , '/ct/product_group'
            , '/ct/set_account_type'
            , '/ct/specify_percentage'
            , '/ct/account_code_ledger'
            , '/ct/tax_medicine'
            , '/ct/allocate-ratios'
            , '/ct/product_plan_amount'
            , '/ct/specify_agency'
            , '/ct/criterion_allocate'
            , '/ct/grouping_expense'
            , '/ct/purchase_price_info'
            , '/ct/std_raw_material_cost'
            , '/ct/std-costs'
            , '/ct/std-cost-papers'
            , '/ct/stamp_adj'
            , '/ct/workorders/processes'
            // , '/CTP0201'
            , '/ct/raw_material_information'
            , '/ct/inquire_production'
            , '/ct/stamp-adjust/process'
            , '/report/report-info'
            , '/ct/oem-costs'
            , '/ct/ctr0019'
            , '/ct/ctr0020'
            , '/ct/ctr0021'
            , '/ct/ctr0026'
            , '/ct/ctr0022'
            , '/ct/ctr0023'
            , '/ct/ctr0024'
            , '/ct/ctr0029'
            , '/ct/ctr0030'
            , '/ct/std-cost-inquiries'
            , '/report/report-info?program_code=CTR1050'
            , '/report/report-info?program_code=CTR1120'
            , '/report/report-info?program_code=CTR1130'
            , '/report/report-info?program_code=CTR0027'
            , '/report/report-info?program_code=CTR0028'
            , '/report/report-info?program_code=CTR0001'
            , '/report/report-info?program_code=CTR0002'
            , '/report/report-info?program_code=CTR0003'
            , '/report/report-info?program_code=CTR0004'
            , '/report/report-info?program_code=CTR0006'
            , '/report/report-info?program_code=CTR0008'
            , '/report/report-info?program_code=CTR0009'
            , '/report/report-info?program_code=CTR0010'
            , '/report/report-info?program_code=CTR0011'
            , '/report/report-info?program_code=CTR0013'
            , '/report/report-info?program_code=CTR0016'
            , '/pm/wip-confirm/export-pdf-parameters/PDR1150'
            , '/pm/wip-confirm/export-pdf-parameters/PDR1180'
            , '/pm/wip-confirm/export-pdf-parameters/PDR2040'
            , '/report/report-info?program_code=CTR0025'
            , '/report/report-info?program_code=CTR0012'
            , '/report/report-info?program_code=CTR0031'
            , '/report/report-info?program_code=CTR0032'
            , '/report/report-info?program_code=TTCTRP72'
            , '/report/report-info?program_code=TTCTRP85'
            , '/report/report-info?program_code=CTR0034'
            , '/report/report-info?program_code=CTR0035'
            , '/report/report-info?program_code=CTR0037'
            , '/report/report-info?program_code=OMR0056'
            , '/report/report-info?program_code=OMR0062'
            , '/report/report-info?program_code=OMR0082'
            , '/report/report-info?program_code=PMR1030'
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
