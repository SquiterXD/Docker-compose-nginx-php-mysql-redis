<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class QmMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 130000 and  140000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 130000 and menu_id <= 140000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 130000 and menu_id <= 140000")->delete();

        $menu1 = [
            [
                'menu_id' => 130000,
                'menu_title' => 'ระบบบริหารงานคุณภาพ : Primary Process', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 130000
            ],
            [
                'menu_id' => 130001,
                'menu_title' => 'ระบบบริหารงานคุณภาพ : Secondary Process', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 130001
            ],
            [
                'menu_id' => 130002,
                'menu_title' => 'การตั้งค่าระบบบริหารงานคุณภาพ', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 130002
            ],
            [
                'menu_id' => 130003,
                'menu_title' => 'รายงานระบบบริหารงานคุณภาพ', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 130003
            ],
        ];


        $menu2 = [
            [
                'menu_id' => 130004,
                'parent_id' => 130000,
                'menu_title' => 'กลุ่มผลิตด้านใบยา',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130005,
                'parent_id' => 130000,
                'menu_title' => 'การระบาดของมอดยาสูบ',
                'program_code' => '',
                'url' => '#'
            ],

            [
                'menu_id' => 130006,
                'parent_id' => 130001,
                'menu_title' => 'กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130007,
                'parent_id' => 130001,
                'menu_title' => 'การตรวจคุณภาพด้วยเครื่อง QTM',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130008,
                'parent_id' => 130001,
                'menu_title' => 'การตรวจอัตราลมรั่ว ของซองบุหรี่',
                'program_code' => '',
                'url' => '#'
            ],

            [
                'menu_id' => 130009,
                'parent_id' => 130002,
                'menu_title' => 'การตั้งค่าทั่วไป',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130010,
                'parent_id' => 130002,
                'menu_title' => 'กลุ่มผลิตด้านใบยา',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130011,
                'parent_id' => 130002,
                'menu_title' => 'กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130012,
                'parent_id' => 130002,
                'menu_title' => 'การตรวจคุณภาพด้วยเครื่อง QTM',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130013,
                'parent_id' => 130002,
                'menu_title' => 'การตรวจอัตราลมรั่ว ของซองบุหรี่',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130014,
                'parent_id' => 130002,
                'menu_title' => 'การระบาดของมอดยาสูบ',
                'program_code' => '',
                'url' => '#'
            ],

            [
                'menu_id' => 130015,
                'parent_id' => 130003,
                'menu_title' => 'กลุ่มผลิตด้านใบยา',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130016,
                'parent_id' => 130003,
                'menu_title' => 'กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130017,
                'parent_id' => 130003,
                'menu_title' => 'การตรวจคุณภาพด้วยเครื่อง QTM',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130018,
                'parent_id' => 130003,
                'menu_title' => 'การตรวจอัตราลมรั่ว ของซองบุหรี่',
                'program_code' => '',
                'url' => '#'
            ],
            [
                'menu_id' => 130070,
                'parent_id' => 130003,
                'menu_title' => 'การระบาดของมอดยาสูบ',
                'program_code' => '',
                'url' => '#'
            ],   
        ];

        $menu3 = [
            [
                'menu_id' => 130019,
                'parent_id' => 130004,
                'menu_title' => 'สร้างตัวอย่างการตรวจสอบ : กลุ่มผลิตด้านใบยา',
                'program_code' => 'QMP0001',
                'url' => '/qm/tobaccos/create'
            ],
            [
                'menu_id' => 130020,
                'parent_id' => 130004,
                'menu_title' => 'ลงผลการตรวจสอบคุณภาพ : กลุ่มผลิตด้านใบยา',
                'program_code' => 'QMP0006',
                'url' => '/qm/tobaccos/result'
            ],

            [
                'menu_id' => 130021,
                'parent_id' => 130005,
                'menu_title' => 'สร้างตัวอย่างการตรวจสอบ : การระบาดของมอด',
                'program_code' => 'QMP0005',
                'url' => '/qm/moth-outbreaks/create'
            ],
            [
                'menu_id' => 130022,
                'parent_id' => 130005,
                'menu_title' => 'ลงผลการตรวจสอบ : การระบาดของมอดยาสูบ',
                'program_code' => 'QMP0010',
                'url' => '/qm/moth-outbreaks/result'
            ],
            [
                'menu_id' => 130023,
                'parent_id' => 130005,
                'menu_title' => 'การติดตามผลการตรวจสอบการระบาดของมอดยาสูบ',
                'program_code' => 'QMQ0006',
                'url' => '/qm/moth-outbreaks/track'
            ],

            [
                'menu_id' => 130024,
                'parent_id' => 130006,
                'menu_title' => 'สร้างตัวอย่างการตรวจสอบ : กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => 'QMP0002',
                'url' => '/qm/finished-products/create'
            ],
            [
                'menu_id' => 130025,
                'parent_id' => 130006,
                'menu_title' => 'ลงผลการตรวจสอบคุณภาพ : กลุ่มผลิตภัณฑ์',
                'program_code' => 'QMP0007',
                'url' => '/qm/finished-products/result'
            ],
            [
                'menu_id' => 130026,
                'parent_id' => 130006,
                'menu_title' => 'การติดตามผลการตรวจสอบ : กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => 'QMQ0003',
                'url' => '/qm/finished-products/track'
            ],

            [
                'menu_id' => 130027,
                'parent_id' => 130007,
                'menu_title' => 'สร้างตัวอย่างการตรวจสอบด้วยเครื่อง QTM',
                'program_code' => 'QMP0003',
                'url' => '/qm/qtm-machines/create'
            ],
            [
                'menu_id' => 130028,
                'parent_id' => 130007,
                'menu_title' => 'ลงผลการตรวจสอบด้วยเครื่อง QTM',
                'program_code' => 'QMP0008',
                'url' => '/qm/qtm-machines/result'
            ],
            [
                'menu_id' => 130029,
                'parent_id' => 130007,
                'menu_title' => 'การติดตามผลการตรวจสอบด้วยเครื่อง QTM',
                'program_code' => 'QMQ0004',
                'url' => '/qm/qtm-machines/track'
            ],

            [
                'menu_id' => 130030,
                'parent_id' => 130008,
                'menu_title' => 'สร้างตัวอย่างการตรวจอัตราลมรั่ว ของซองบุหรี่',
                'program_code' => 'QMP0004',
                'url' => '/qm/packet-air-leaks/create'
            ],
            [
                'menu_id' => 130031,
                'parent_id' => 130008,
                'menu_title' => 'ลงผลการตรวจอัตราลมรั่ว ของซองบุหรี่',
                'program_code' => 'QMP0009',
                'url' => '/qm/packet-air-leaks/result'
            ],
            [
                'menu_id' => 130032,
                'parent_id' => 130008,
                'menu_title' => 'การติดตามผลการตรวจสอบอัตราลมรั่ว ของซองบุหรี่',
                'program_code' => 'QMQ0005',
                'url' => '/qm/packet-air-leaks/track'
            ],

            [
                'menu_id' => 130033,
                'parent_id' => 130009,
                'menu_title' => 'กำหนดประเภทการทดสอบ',
                'program_code' => 'QMS0001',
                'url' => '/lookup?programCode=QMS0001'
            ],
            [
                'menu_id' => 130034,
                'parent_id' => 130009,
                'menu_title' => 'กำหนดระดับความรุนแรง',
                'program_code' => 'QMS0002',
                'url' => '/lookup?programCode=QMS0002'
            ],
            [
                'menu_id' => 130035,
                'parent_id' => 130009,
                'menu_title' => 'กำหนดหน่วยการทดสอบ',
                'program_code' => 'QMS0006',
                'url' => '/qm/settings/test-unit'
            ],
            [
                'menu_id' => 130075,
                'parent_id' => 130009,
                'menu_title' => 'กำหนดความสัมพันธ์เครื่องจักร',
                'program_code' => 'QMS0021',
                'url' => '/lookup?programCode=QMS0021'
            ],
            [
                'menu_id' => 130076,
                'parent_id' => 130009,
                'menu_title' => 'กำหนดขั้นตอนคุณภาพ',
                'program_code' => 'QMS0022',
                'url' => '/lookup?programCode=QMS0022'
            ],
            [
                'menu_id' => 130077,
                'parent_id' => 130009,
                'menu_title' => 'งานขั้นตอนคุณภาพ',
                'program_code' => 'QMS0023',
                'url' => '/lookup?programCode=QMS0023'
            ],

            [
                'menu_id' => 130036,
                'parent_id' => 130010,
                'menu_title' => 'กำหนดหัวข้อการทดสอบ : กลุ่มผลิตด้านใบยา',
                'program_code' => 'QMS0007',
                'url' => '/qm/settings/define-tests-tobacco-leaf'
            ],
            [
                'menu_id' => 130037,
                'parent_id' => 130010,
                'menu_title' => 'กำหนดจุดตรวจสอบ: กลุ่มผลิตด้านใบยา',
                'program_code' => 'QMS0018',
                'url' => '/qm/settings/check-points-tobacco-leaf'
            ],
            [
                'menu_id' => 130038,
                'parent_id' => 130010,
                'menu_title' => 'กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ : กลุ่มผลิตด้านใบยา',
                'program_code' => 'QMS0013',
                'url' => '/qm/settings/specifications?test_type=1'
            ],


            [
                'menu_id' => 130039,
                'parent_id' => 130011,
                'menu_title' => 'กำหนดกระบวนการตรวจคุณภาพบุหรี่',
                'program_code' => 'QMS0003',
                'url' => '/lookup?programCode=QMS0003'
            ],
            [
                'menu_id' => 130040,
                'parent_id' => 130011,
                'menu_title' => 'กำหนดรายการตรวจสอบคุณภาพบุหรี่',
                'program_code' => 'QMS0004',
                'url' => '/lookup?programCode=QMS0004'
            ],
            [
                'menu_id' => 130041,
                'parent_id' => 130011,
                'menu_title' => 'กำหนดปัญหา/ข้อบกพร่อง : กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => 'QMS0009',
                'url' => '/qm/settings/define-tests-finished-products'
            ],
            [
                'menu_id' => 130042,
                'parent_id' => 130011,
                'menu_title' => 'กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ : กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => 'QMS0014',
                'url' => '/qm/settings/specifications?test_type=2'
            ],
            [
                'menu_id' => 130043,
                'parent_id' => 130011,
                'menu_title' => 'เขคการตรวจคุณภาพ',
                'program_code' => 'QMS0008',
                'url' => '/qm/settings/qc-area'
            ],
            [
                'menu_id' => 130079,
                'parent_id' => 130011,
                'menu_title' => 'กำหนดเขตการตรวจคุณภาพ : กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => 'QMS0025',
                'url' => '/lookup?programCode=QMS0025'
            ],

            [
                'menu_id' => 130044,
                'parent_id' => 130012,
                'menu_title' => 'กำหนดหัวข้อการทดสอบ : การตรวจคุณภาพด้วยเครื่อง QTM',
                'program_code' => 'QMS0010',
                'url' => '/qm/settings/define-tests-qtm-machines'
            ],
            [
                'menu_id' => 130045,
                'parent_id' => 130012,
                'menu_title' => 'กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ : การตรวจคุณภาพด้วยเครื่อง QTM',
                'program_code' => 'QMS0015',
                'url' => '/qm/settings/specifications?test_type=3'
            ],
            [
                'menu_id' => 130080,
                'parent_id' => 130012,
                'menu_title' => 'กำหนด QTM Maker',
                'program_code' => 'QMS0026',
                'url' => '/lookup?programCode=QMS0026'
            ],

            [
                'menu_id' => 130046,
                'parent_id' => 130013,
                'menu_title' => 'กำหนดหัวข้อการทดสอบ : การตรวจอัตราลมรั่ว',
                'program_code' => 'QMS0012',
                'url' => '/qm/settings/define-tests-packet-air-leaks'
            ],
            [
                'menu_id' => 130047,
                'parent_id' => 130013,
                'menu_title' => 'กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ : การตรวจอัตราลมรั่ว ของซองบุหรี่',
                'program_code' => 'QMS0016',
                'url' => '/qm/settings/specifications?test_type=5'
            ],

            [
                'menu_id' => 130048,
                'parent_id' => 130014,
                'menu_title' => 'กำหนดจุดตรวจสอบ : การระบาดของมอดยาสูบ',
                'program_code' => 'QMS0005',
                'url' => '/qm/settings/check-points-tobacco-beetle'
            ],
            [
                'menu_id' => 130049,
                'parent_id' => 130014,
                'menu_title' => 'กำหนดหัวข้อการทดสอบ : การระบาดของมอดยาสูบ',
                'program_code' => 'QMS0011',
                'url' => '/qm/settings/define-tests-tobacco-beetle'
            ],
            [
                'menu_id' => 130050,
                'parent_id' => 130014,
                'menu_title' => 'กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ : การระบาดของมอดยาสูบ',
                'program_code' => 'QMS0017',
                'url' => '/qm/settings/specifications?test_type=4'
            ],
            [
                'menu_id' => 130078,
                'parent_id' => 130014,
                'menu_title' => 'กำหนดเขตการตรวจคุณภาพ : การตรวจอัตราลมรั่ว',
                'program_code' => 'QMS0024',
                'url' => '/lookup?programCode=QMS0024'
            ],


            [
                'menu_id' => 130051,
                'parent_id' => 130015,
                'menu_title' => 'รายงานสรุปผลการตรวจสอบ',
                'program_code' => 'QMR0001',
                'url' => '/qm/tobaccos/report-summary'
            ],

            [
                'menu_id' => 130052,
                'parent_id' => 130016,
                'menu_title' => 'รายงานสรุปผลการตรวจสอบ : กลุ่มผลิตภัณฑ์',
                'program_code' => 'QMR0002',
                'url' => '/qm/finished-products/report-summary'
            ],

            [
                'menu_id' => 130053,
                'parent_id' => 130017,
                'menu_title' => 'สรุปผลการตรวจวัดคุณภาพของผลิตภัณฑ์บุหรี่ โดยเครื่อง QTM',
                'program_code' => 'QMR0008',
                'url' => '/qm/qtm-machines/report-product-quality'
            ],
            [
                'menu_id' => 130054,
                'parent_id' => 130017,
                'menu_title' => 'สรุปรายงานค่าทางฟิสิกส์ ของบุหรี่',
                'program_code' => 'QMR0009',
                'url' => '/qm/qtm-machines/report-physical-value'
            ],
            [
                'menu_id' => 130055,
                'parent_id' => 130017,
                'menu_title' => 'การติดตามผลการตรวจสอบคุณภาพที่ไม่ผ่านค่ามาตรฐาน',
                'program_code' => 'QMR0007',
                'url' => '/qm/qtm-machines/report-under-average'
            ],
            [
                'menu_id' => 130056,
                'parent_id' => 130017,
                'menu_title' => 'รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM',
                'program_code' => 'QMR0003',
                'url' => '/qm/qtm-machines/report-summary'
            ],
            
            [
                'menu_id' => 130057,
                'parent_id' => 130018,
                'menu_title' => 'รายงานบันทึกผลอัตรารั่ว',
                'program_code' => 'QMR0010',
                'url' => '/qm/packet-air-leaks/report-leak-rate'
            ],
            [
                'menu_id' => 130058,
                'parent_id' => 130018,
                'menu_title' => 'รายงานสรุปผลการตรวจสอบ',
                'program_code' => 'QMR0004',
                'url' => '/qm/packet-air-leaks/report-summary'
            ],
            [
                'menu_id' => 130059,
                'parent_id' => 130010,
                'menu_title' => 'กำหนดกลุ่มงาน การตรวจสอบผลิตภัณฑ์ด้านใบยา',
                'program_code' => 'QMS0019',
                'url' => '/lookup?programCode=QMS0019'
            ],
            [
                'menu_id' => 130060,
                'parent_id' => 130014,
                'menu_title' => 'กำหนดวิธีการป้องกันและกำจัดมอดยาสูบ',
                'program_code' => 'QMS0020',
                'url' => '/qm/settings/result-severity'
            ],
            [
                'menu_id' => 130061,
                'parent_id' => 130004,
                'menu_title' => 'การติดตามผลการตรวจสอบคุณภาพ : กลุ่มผลิตด้านใบยา',
                'program_code' => 'QMP0006',
                'url' => '/qm/tobaccos/track'
            ],

            // Add New 07122021
            [
                'menu_id' => 130062,
                'parent_id' => 130004,
                'menu_title' => 'อนุมัติผลการตรวจสอบคุณภาพ : กลุ่มผลิตด้านใบยา',
                'program_code' => 'QMP0011',
                'url' => '/qm/tobaccos/approval'
            ],
            [
                'menu_id' => 130063,
                'parent_id' => 130005,
                'menu_title' => 'อนุมัติผลการตรวจสอบการระบาดของมอดยาสูบ',
                'program_code' => 'QMP0012',
                'url' => '/qm/moth-outbreaks/approval'
            ],
            [
                'menu_id' => 130064,
                'parent_id' => 130006,
                'menu_title' => 'อนุมัติผลการตรวจสอบคุณภาพ : กลุ่มผลิตภัณฑ์สำเร็จรูป',
                'program_code' => 'QMP0013',
                'url' => '/qm/finished-products/approval'
            ],
            [
                'menu_id' => 130065,
                'parent_id' => 130007,
                'menu_title' => 'อนุมัติผลการตรวจสอบด้วยเครื่อง QTM',
                'program_code' => 'QMP0014',
                'url' => '/qm/qtm-machines/approval'
            ],
            [
                'menu_id' => 130066,
                'parent_id' => 130008,
                'menu_title' => 'อนุมัติผลการตรวจอัตราลมรั่ว ของซองบุหรี',
                'program_code' => 'QMP0015',
                'url' => '/qm/packet-air-leaks/approval'
            ],
            [
                'menu_id' => 130067,
                'parent_id' => 130006,
                'menu_title' => 'บันทึกสาเหตุความผิดปกติทางคุณภาพของบุหรี่',
                'program_code' => '-',
                'url' => '/qm/finished-products/defect'
            ],
            [
                'menu_id' => 130068,
                'parent_id' => 130007,
                'menu_title' => 'บันทึกสาเหตุความผิดปกติทางคุณภาพ QTM',
                'program_code' => '-',
                'url' => '/qm/qtm-machines/defect'
            ],
            [
                'menu_id' => 130069,
                'parent_id' => 130008,
                'menu_title' => 'บันทึกสาเหตุความผิดปกติทางคุณภาพ อัตราลมรั่วของซองบุหรี่',
                'program_code' => '-',
                'url' => '/qm/packet-air-leaks/defect'
            ],

            [
                'menu_id' => 130071,
                'parent_id' => 130070,
                'menu_title' => 'รายงานผลการตรวจสอบการระบาดของมอดยาสูบ',
                'program_code' => 'QMQ0000',
                'url' => '/qm/moth-outbreaks/report-summary'
            ],

            [
                'menu_id' => 130072,
                'parent_id' => 130070,
                'menu_title' => 'รายงานผลการตรวจสอบการระบาดของมอดยาสูบ - สรุปผลการตรวจสอบ',
                'program_code' => 'QMR0011',
                'url' => '/qm/moth-outbreaks/report-locator-summary'
            ],

            [
                'menu_id' => 130073,
                'parent_id' => 130018,
                'menu_title' => 'รายงานแสดงรายการผลการตรวจสอบอัตราลมรั่ว ของซองบุหรี่',
                'program_code' => 'QMR0012',
                'url' => '/qm/packet-air-leaks/report'
            ],

            [
                'menu_id' => 130074,
                'parent_id' => 130017,
                'menu_title' => 'รายงานการตรวจสอบมวนบุหรี่/ก้นกรอง โดยเครื่อง Quantum Neo, QTM ที่ไม่เป็นไปตามข้อกำหนด',
                'program_code' => 'QMR0013',
                'url' => '/qm/qtm-machines/report-quantum-neo'
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

        $this->newRole(130000);

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
                    ->whereRaw("menu_id between 130000 and  140000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            '/qm/tobaccos/create'
            , '/qm/tobaccos/result'
            , '/qm/moth-outbreaks/create'
            , '/qm/moth-outbreaks/result'
            , '/qm/moth-outbreaks/track'
            , '/qm/finished-products/create'
            , '/qm/finished-products/result'
            , '/qm/finished-products/track'
            , '/qm/qtm-machines/create'
            , '/qm/qtm-machines/result'
            , '/qm/qtm-machines/track'
            , '/qm/packet-air-leaks/create'
            , '/qm/packet-air-leaks/result'
            , '/qm/packet-air-leaks/track'
            , '/lookup?programCode=QMS0001'
            , '/lookup?programCode=QMS0002'
            , '/qm/settings/test-unit'
            , '/qm/settings/define-tests-tobacco-leaf'
            , '/qm/settings/check-points-tobacco-leaf'
            , '/qm/settings/specifications?test_type=1'
            , '/lookup?programCode=QMS0003'
            , '/lookup?programCode=QMS0004'
            , '/qm/settings/define-tests-finished-products'
            , '/qm/settings/specifications?test_type=2'
            , '/qm/settings/qc-area'
            , '/qm/settings/define-tests-qtm-machines'
            , '/qm/settings/specifications?test_type=3'
            , '/qm/settings/define-tests-packet-air-leaks'
            , '/qm/settings/specifications?test_type=5'
            , '/qm/settings/check-points-tobacco-beetle'
            , '/qm/settings/define-tests-tobacco-beetle'
            , '/qm/settings/specifications?test_type=4'
            , '/qm/tobaccos/report-summary'
            , '/qm/finished-products/report-summary'
            , '/qm/qtm-machines/report-product-quality'
            , '/qm/qtm-machines/report-physical-value'
            , '/qm/qtm-machines/report-under-average'
            , '/qm/qtm-machines/report-summary'
            , '/qm/packet-air-leaks/report-leak-rate'
            , '/qm/packet-air-leaks/report-summary'
            , '/lookup?programCode=QMS0019'
            , '/qm/settings/result-severity'
            , '/qm/tobaccos/track'
            , '/qm/tobaccos/approval'
            , '/qm/moth-outbreaks/approval'
            , '/qm/finished-products/approval'
            , '/qm/qtm-machines/approval'
            , '/qm/packet-air-leaks/approval'
            , '/qm/finished-products/defect'
            , '/qm/qtm-machines/defect'
            , '/qm/packet-air-leaks/defect'
            , '/qm/moth-outbreaks/report-summary'
            , '/qm/moth-outbreaks/report-locator-summary'
            , '/qm/packet-air-leaks/report'
            , '/qm/qtm-machines/report-quantum-neo'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'QM:ALL', 'QM', $menus);
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
