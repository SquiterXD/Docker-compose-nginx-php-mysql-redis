<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Arr;

class OmMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::whereRaw("role_id between 40000 and  50000")->delete();
        \App\Models\Menu::whereRaw("menu_id >= 40000 and menu_id <= 50000")->delete();
        \App\Models\Permission::whereRaw("menu_id >= 40000 and menu_id <= 50000")->delete();

        $menu1 = [
            [
                'menu_id' => 40000,
                'menu_title' => 'OM: ระบบงานขาย', 'parent_id' => 0, 'sort_order' => 0, 'url' => '#',
                'server_id' => 1, 'program_code' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 40000
            ],
        ];

        $menu2 = [
            [
                'menu_id' => 40001,
                'parent_id' => 40000,
                'menu_title' => 'การตั้งค่ากองคลังผลิตภัณฑ์',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40002,
                'parent_id' => 40000,
                'menu_title' => 'กองคลังผลิตภัณฑ์',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40003,
                'parent_id' => 40000,
                'menu_title' => 'การตั้งค่าขายในประเทศ',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40004,
                'parent_id' => 40000,
                'menu_title' => 'ระบบงานขายในประเทศ',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40005,
                'parent_id' => 40000,
                'menu_title' => 'การตั้งค่าขายต่างประเทศ',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40006,
                'parent_id' => 40000,
                'menu_title' => 'ระบบงานขายต่างประเทศ',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40007,
                'parent_id' => 40000,
                'menu_title' => 'การตั้งค่ากองรับและจ่ายเงิน',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40008,
                'parent_id' => 40000,
                'menu_title' => 'กองรับและจ่ายเงิน',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40009,
                'parent_id' => 40000,
                'menu_title' => 'การตั้งค่ากองบัญชีรายได้',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40010,
                'parent_id' => 40000,
                'menu_title' => 'กองบัญชีรายได้',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40011,
                'parent_id' => 40000,
                'menu_title' => 'การตั้งค่ากองช่องทางการจำหน่าย',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40012,
                'parent_id' => 40000,
                'menu_title' => 'กองช่องทางการจำหน่าย',
                'program_code' => '-1',
                'url' => '#'
            ],
            [
                'menu_id' => 40013,
                'parent_id' => 40000,
                'menu_title' => 'ประมาณการจำหน่าย',
                'program_code' => '-1',
                'url' => '#'
            ],
        ];
        // 40014-40023

        $menu3 = [
            // TAB 1 
            [
                'menu_id' => 40024,
                'parent_id' => 40001,
                'menu_title' => 'บันทึกข้อมูลเจ้าของรถขนส่ง',
                'program_code' => 'OMS0027',
                'url' => '/om/settings/transport-owner'
            ],
            [
                'menu_id' => 40025,
                'parent_id' => 40001,
                'menu_title' => 'กำหนดช่วงเวลามาตรฐานการส่งมอบ(สำหรับขายในประเทศ)',
                'program_code' => 'OMS0028',
                'url' => '/om/settings/transportation-route'
            ],
            //20026-20030
            // TAB 2
            [
                'menu_id' => 40031,
                'parent_id' => 40002,
                'menu_title' => 'พิมพ์ใบเสร็จรับเงิน (กองคลังผลิตภัณฑ์)',
                'program_code' => 'OMP0027',
                'url' => '/om/print-receipt/print'
            ],
            [
                'menu_id' => 40032,
                'parent_id' => 40002,
                'menu_title' => 'พิมพ์ Invoice / ใบขน / Credit Note',
                'program_code' => 'OMP0036',
                'url' => '/om/print-invoice'
            ],
            [
                'menu_id' => 40033,
                'parent_id' => 40002,
                'menu_title' => 'สร้างใบจ่ายยาสูบจากใบเตรียมขาย',
                'program_code' => 'OMP0040',
                'url' => '/om/draft-payout'
            ],
            [
                'menu_id' => 40034,
                'parent_id' => 40002,
                'menu_title' => 'อนุมัติใบเคลมในประเทศ',
                'program_code' => 'OMP0050',
                'url' => '/om/approval-claim'
            ],
            [
                'menu_id' => 40035,
                'parent_id' => 40002,
                'menu_title' => 'บันทึกใบคืนสินค้า (RMA) สำหรับขายในประเทศ',
                'program_code' => 'OMP0052',
                'url' => '/om/rma-domestic'
            ],
            [
                'menu_id' => 40036,
                'parent_id' => 40002,
                'menu_title' => 'อนุมัติใบเคลมต่างประเทศ',
                'program_code' => 'OMP0082',
                'url' => '/om/claim/claim-approve'
            ],
            [
                'menu_id' => 40037,
                'parent_id' => 40002,
                'menu_title' => 'สร้างใบคืนสินค้า (RMA) ต่างประเทศ',
                'program_code' => 'OMP0084',
                'url' => '/om/rma-export'
            ],
            // 40038-40040
            // TAB 3
            [
                'menu_id' => 40041,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดงวดการสั่งซื้อ',
                'program_code' => 'OMS0002',
                'url' => '/om/settings/order-period'
            ],
            [
                'menu_id' => 40042,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดเงื่อนไขการชำระเงิน(ในประเทศ)',
                'program_code' => 'OMS0004',
                'url' => '/om/settings/term'
            ],
            [
                'menu_id' => 40043,
                'parent_id' => 40003,
                'menu_title' => 'ประเภทลูกค้าสำหรับขายในประเทศ',
                'program_code' => 'OMS0006',
                'url' => '/lookup?programCode=OMS0006'
            ],
            [
                'menu_id' => 40044,
                'parent_id' => 40003,
                'menu_title' => 'กลุ่มประเภทสินค้าสำหรับขายในประเทศ',
                'program_code' => 'OMS0009',
                'url' => '/lookup?programCode=OMS0009'
            ],
            [
                'menu_id' => 40045,
                'parent_id' => 40003,
                'menu_title' => 'PriceList(สำหรับขายในประเทศ)',
                'program_code' => 'OMS0012',
                'url' => '/om/settings/price-list'
            ],
            [
                'menu_id' => 40046,
                'parent_id' => 40003,
                'menu_title' => 'วิธีการชำระเงินสำหรับขายในประเทศ',
                'program_code' => 'OMS0014',
                'url' => '/lookup?programCode=OMS0014'
            ],
            [
                'menu_id' => 40047,
                'parent_id' => 40003,
                'menu_title' => 'สร้างข้อมูลลูกค้า DirectDebit-ขายในประเทศ',
                'program_code' => 'OMS0019',
                'url' => '/om/settings/direct-debit-domestic'
            ],
            [
                'menu_id' => 40048,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดสิทธิ์สั่งซื้อพิเศษ',
                'program_code' => 'OMS0021',
                'url' => '/om/settings/grant-spacial-case'
            ],
            [
                'menu_id' => 40049,
                'parent_id' => 40003,
                'menu_title' => 'กลุ่มโควต้า',
                'program_code' => 'OMS0022',
                'url' => '/lookup?programCode=OMS0022'
            ],
            [
                'menu_id' => 40050,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดข้อมูลกลุ่มโควต้าและกลุ่มวงเงินเชื่อรายผลิตภัณฑ์',
                'program_code' => 'OMS0023',
                'url' => '/om/settings/quota-credit-group'
            ],
            [
                'menu_id' => 40051,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดผู้มีอำนาจ',
                'program_code' => 'OMS0024',
                'url' => '/om/settings/authority-list'
            ],
            [
                'menu_id' => 40052,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า',
                'program_code' => 'OMS0025',
                'url' => '/om/settings/over-quota-approval'
            ],
            [
                'menu_id' => 40053,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดลำดับผลิตภัณฑ์',
                'program_code' => 'OMS0026',
                'url' => '/om/settings/sequence-ecom'
            ],
            [
                'menu_id' => 40054,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดผู้อนุมัติใบเตรียมการขาย/ใบสั่งซื้อ',
                'program_code' => 'OMS0030',
                'url' => '/om/settings/approver-order'
            ],
            [
                'menu_id' => 40055,
                'parent_id' => 40003,
                'menu_title' => 'ผู้ร้องขอ(สำหรับขายในประเทศ)',
                'program_code' => 'OMS0032',
                'url' => '/lookup?programCode=OMS0032'
            ],
            [
                'menu_id' => 40056,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดตำแหน่งปฏิบัติการแทน',
                'program_code' => 'OMS0034',
                'url' => '/lookup?programCode=OMS0034'
            ],
            [
                'menu_id' => 40057,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดผู้มีอำนาจอนุมัติออก Invoice กรณีพิเศษ',
                'program_code' => 'OMS0035',
                'url' => '/lookup?programCode=OMS0035'
            ],
            [
                'menu_id' => 40058,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดระยะเวลาขนส่งสโมสรภูมิภาค(ระยะเวลาฝากขาย) สำหรับขายในประเทศ',
                'program_code' => 'OMS0037',
                'url' => '/lookup?programCode=OMS0037'
            ],
            [
                'menu_id' => 40059,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดรายชื่อกลุ่มตลาด',
                'program_code' => 'OMS0041',
                'url' => '/lookup?programCode=OMS0041'
            ],
            [
                'menu_id' => 40060,
                'parent_id' => 40003,
                'menu_title' => 'กำหนดกลุ่มวงเงินเชื่อ',
                'program_code' => 'OMS0043',
                'url' => '/lookup?programCode=OMS0043'
            ],
            //หมดแล้ว
            // TAB 4
            [
                'menu_id' => 40061,
                'parent_id' => 40004,
                'menu_title' => 'คืนวงเงินเชื่อ',
                'program_code' => 'OMP0004',
                'url' => '/om/release-credit'
            ],
            [
                'menu_id' => 40062,
                'parent_id' => 40004,
                'menu_title' => 'หนี้ค้างชำระ สำหรับขายในประเทศ',
                'program_code' => 'OMP0006',
                'url' => '/om/outstanding'
            ],
            [
                'menu_id' => 40063,
                'parent_id' => 40004,
                'menu_title' => 'หน้าจอเลื่อนวันส่งประจำสัปดาห์',
                'program_code' => 'OMP0009',
                'url' => '/om/postpone-delivery'
            ],
            [
                'menu_id' => 40064,
                'parent_id' => 40004,
                'menu_title' => 'การอนุมัติใบคำร้องขอเพิ่มเพดาน',
                'program_code' => 'OMP0015',
                'url' => '/om/addition-quota'
            ],
            [
                'menu_id' => 40065,
                'parent_id' => 40004,
                'menu_title' => 'บันทึกใบเตรียมการขาย',
                'program_code' => 'OMP0019',
                'url' => '/om/order/prepare'
            ],
            [
                'menu_id' => 40066,
                'parent_id' => 40004,
                'menu_title' => 'ใบเตรียมการขาย ส่งเสริม ยสท. /บุหรี่ทดลอง/บุหรี่ตัวอย่าง',
                'program_code' => 'OMP0020',
                'url' => '/om/prepare-saleorder'
            ],
            [
                'menu_id' => 40067,
                'parent_id' => 40004,
                'menu_title' => 'อนุมัติใบเตรียมการขายเพื่อตั้งหนี้',
                'program_code' => 'OMP0021',
                'url' => '/om/approve-saleorder'
            ],
            [
                'menu_id' => 40068,
                'parent_id' => 40004,
                'menu_title' => 'การรับเงินแบบ Direct Debit ในประเทศ',
                'program_code' => 'OMP0028',
                'url' => '/om/order-direct-debit/domestic'
            ],
            [
                'menu_id' => 40069,
                'parent_id' => 40004,
                'menu_title' => 'โอนข้อมูล Text File เพื่อส่งธนาคาร',
                'program_code' => 'OMP0029',
                'url' => '/om/order-direct-debit/domestic/file-tranfer'
            ],
            [
                'menu_id' => 40070,
                'parent_id' => 40004,
                'menu_title' => 'อนุมัติใบเตรียมการขาย/ใบสั่งซื้อ',
                'program_code' => 'OMP0030',
                'url' => '/om/approve-prepare'
            ],
            [
                'menu_id' => 40071,
                'parent_id' => 40004,
                'menu_title' => 'ยกเลิก Invoice/ใบขน',
                'program_code' => 'OMP0031',
                'url' => '/om/invoice/cancel'
            ],
            [
                'menu_id' => 40072,
                'parent_id' => 40004,
                'menu_title' => 'ปลดรายการ Reprint Invoice/ใบขน',
                'program_code' => 'OMP0037',
                'url' => '/om/reprint-invoice'
            ],
            [
                'menu_id' => 40073,
                'parent_id' => 40004,
                'menu_title' => 'รายการฝากขายสโมสรภูมิภาค',
                'program_code' => 'OMP0038',
                'url' => '/om/consignment-club'
            ],
            [
                'menu_id' => 40074,
                'parent_id' => 40004,
                'menu_title' => 'รายการฝากขายสโมสรกรุงเทพ',
                'program_code' => 'OMP0038',
                'url' => '/om/consignment-bkk'
            ],
            [
                'menu_id' => 40075,
                'parent_id' => 40004,
                'menu_title' => 'ยกเลิกฝากขาย',
                'program_code' => 'OMP0039',
                'url' => '/om/consignment/cancel'
            ],
            [
                'menu_id' => 40076,
                'parent_id' => 40004,
                'menu_title' => 'ปิดการขายประจำวัน สำหรับขายในประเทศ',
                'program_code' => 'OMP0044',
                'url' => '/om/close-daily-sale'
            ],
            [
                'menu_id' => 40077,
                'parent_id' => 40004,
                'menu_title' => 'ค้นหาใบเตรียมการขาย สำหรับขายในประเทศ',
                'program_code' => 'OMP0093',
                'url' => '/om/prepare-sale-orders/search?type=domestic'
            ],
            // 40078-40080
            // TAB 5
            [
                'menu_id' => 40081,
                'parent_id' => 40005,
                'menu_title' => 'กำหนดเงื่อนไขการชำระเงิน(ต่างประเทศ)',
                'program_code' => 'OMS0005',
                'url' => '/om/settings/term-export'
            ],
            [
                'menu_id' => 40082,
                'parent_id' => 40005,
                'menu_title' => 'ประเภทลูกค้าสำหรับขายต่างประเทศ',
                'program_code' => 'OMS0007',
                'url' => '/lookup?programCode=OMS0007'
            ],
            [
                'menu_id' => 40083,
                'parent_id' => 40005,
                'menu_title' => 'กำหนดIncoterms',
                'program_code' => 'OMS0008',
                'url' => '/lookup?programCode=OMS0008'
            ],
            [
                'menu_id' => 40084,
                'parent_id' => 40005,
                'menu_title' => 'กลุ่มประเภทสินค้าสำหรับขายต่างประเทศ',
                'program_code' => 'OMS0010',
                'url' => '/lookup?programCode=OMS0010'
            ],
            [
                'menu_id' => 40085,
                'parent_id' => 40005,
                'menu_title' => 'กำหนดประเทศ',
                'program_code' => 'OMS0011',
                'url' => '/om/settings/country'
            ],
            [
                'menu_id' => 40086,
                'parent_id' => 40005,
                'menu_title' => 'PriceList(สำหรับขายต่างประเทศ)',
                'program_code' => 'OMS0013',
                'url' => '/om/settings/price-list-export'
            ],
            [
                'menu_id' => 40087,
                'parent_id' => 40005,
                'menu_title' => 'วิธีการชำระเงินสำหรับขายต่างประเทศ',
                'program_code' => 'OMS0015',
                'url' => '/lookup?programCode=OMS0015'
            ],
            [
                'menu_id' => 40088,
                'parent_id' => 40005,
                'menu_title' => 'กำหนดสายการอนุมัติสำหรับอนุมัติสร้างลูกค้าใหม่(ต่างประเทศ)',
                'program_code' => 'OMS0016',
                'url' => '/om/settings/customer'
            ],
            [
                'menu_id' => 40089,
                'parent_id' => 40005,
                'menu_title' => 'สร้างข้อมูลลูกค้า Direct Debit-ขายต่างประเทศ',
                'program_code' => 'OMS0020',
                'url' => '/om/settings/direct-debit-export'
            ],
            [
                'menu_id' => 40090,
                'parent_id' => 40005,
                'menu_title' => 'กำหนด Weight/Unit',
                'program_code' => 'OMS0031',
                'url' => '/om/settings/item-weight'
            ],
            [
                'menu_id' => 40091,
                'parent_id' => 40005,
                'menu_title' => 'กำหนดผู้อนุมัติใบ Sale Confirmation',
                'program_code' => 'OMS0033',
                'url' => '/om/settings/approver-order-export'
            ],
            [
                'menu_id' => 40092,
                'parent_id' => 40005,
                'menu_title' => 'กำหนดผู้อนุมัติสำหรับรายงาน',
                'program_code' => 'OMS0038',
                'url' => '/lookup?programCode=OMS0038'
            ],
            [
                'menu_id' => 40093,
                'parent_id' => 40005,
                'menu_title' => 'กำหนดรายละเอียด Packing',
                'program_code' => 'OMS0039',
                'url' => '/lookup?programCode=OMS0039'
            ],
            [
                'menu_id' => 40094,
                'parent_id' => 40005,
                'menu_title' => 'กำหนดรายละเอียด Payment',
                'program_code' => 'OMS0040',
                'url' => '/lookup?programCode=OMS0040'
            ],
            // 40095-40100
            // TAB 6
            [
                'menu_id' => 40101,
                'parent_id' => 40006,
                'menu_title' => 'อนุมัติการสร้างลูกค้าสำหรับขายต่างประเทศ',
                'program_code' => 'OMM0003',
                'url' => '/om/customers/approves'
            ],
            [
                'menu_id' => 40102,
                'parent_id' => 40006,
                'menu_title' => 'ข้อมูลลูกค้าขายต่างประเทศ',
                'program_code' => 'OMM0004',
                'url' => '/om/customers/exports'
            ],
            [
                'menu_id' => 40103,
                'parent_id' => 40006,
                'menu_title' => 'กำหนดลำดับผลิตภัณฑ์ในการประมาณการจำหน่ายรายปักษ์',
                'program_code' => 'OMP0053',
                'url' => '/om/sequence-fortnightly'
            ],
            [
                'menu_id' => 40104,
                'parent_id' => 40006,
                'menu_title' => 'โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย',
                'program_code' => 'OMP0055',
                'url' => '/om/transfer-bi-weekly/domestic'
            ],
            [
                'menu_id' => 40105,
                'parent_id' => 40006,
                'menu_title' => 'โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย',
                'program_code' => 'OMP0057',
                'url' => '/om/monthly-distribute/domestic'
            ],
            [
                'menu_id' => 40106,
                'parent_id' => 40006,
                'menu_title' => 'โอนข้อมูลประมาณการจำหน่ายรายปีเข้าระบบงานขาย',
                'program_code' => 'OMP0059',
                'url' => '/om/year-distribute/domestic'
            ],
            [
                'menu_id' => 40107,
                'parent_id' => 40006,
                'menu_title' => 'หนี้ค้างชำระ',
                'program_code' => 'OMP0065',
                'url' => '/om/overdue-debt'
            ],
            [
                'menu_id' => 40108,
                'parent_id' => 40006,
                'menu_title' => 'บันทึกใบ Sale-Confirmation สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0066',
                'url' => '/om/sale-confirmation'
            ],
            [
                'menu_id' => 40109,
                'parent_id' => 40006,
                'menu_title' => 'การรับเงินแบบ Direct Debit ต่างประเทศ',
                'program_code' => 'OMP0069',
                'url' => '/om/order-direct-debit/export'
            ],
            [
                'menu_id' => 40110,
                'parent_id' => 40006,
                'menu_title' => 'โอนข้อมูล Text File เพื่อส่งธนาคาร สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0070',
                'url' => '/om/order-direct-debit/export/file-tranfer'
            ],
            [
                'menu_id' => 40111,
                'parent_id' => 40006,
                'menu_title' => 'ปรับปรุงค่าปรับยาสูบ สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0071',
                'url' => '/om/improve-fine-exp'
            ],
            [
                'menu_id' => 40112,
                'parent_id' => 40006,
                'menu_title' => 'บันทึกใบ Proforma Invoice',
                'program_code' => 'OMP0072',
                'url' => '/om/proforma-invoice'
            ],
            [
                'menu_id' => 40113,
                'parent_id' => 40006,
                'menu_title' => 'บันทึก Invoice, Tax Invoice',
                'program_code' => 'OMP0073',
                'url' => '/om/tax-invoice-export'
            ],
            [
                'menu_id' => 40114,
                'parent_id' => 40006,
                'menu_title' => 'บันทึกอัตราแลกเปลี่ยนตามวันที่ในใบขน',
                'program_code' => 'OMP0075',
                'url' => '/om/exchange-export'
            ],
            [
                'menu_id' => 40115,
                'parent_id' => 40006,
                'menu_title' => 'Debit Note สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0076',
                'url' => '/om/debit-note-export'
            ],
            [
                'menu_id' => 40116,
                'parent_id' => 40006,
                'menu_title' => 'Credit Note กรณีอื่นๆ',
                'program_code' => 'OMP0077',
                'url' => '/om/credit-note-other-export'
            ],
            [
                'menu_id' => 40117,
                'parent_id' => 40006,
                'menu_title' => 'ปิดการขายประจำวัน สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0078',
                'url' => '/om/close-flag/export'
            ],
            [
                'menu_id' => 40118,
                'parent_id' => 40006,
                'menu_title' => 'ค้นหา Sale Order สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0095',
                'url' => '/om/prepare-sale-orders/search?type=export'
            ],
            [
                'menu_id' => 40119,
                'parent_id' => 40006,
                'menu_title' => 'บันทึกประมาณการจำหน่ายรายปักษ์ สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0096',
                'url' => '/om/transfer-bi-weekly-export'
            ],
            [
                'menu_id' => 40120,
                'parent_id' => 40006,
                'menu_title' => 'บันทึกประมาณการจำหน่ายรายเดือน สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0097',
                'url' => '/om/monthly-distribute-export'
            ],
            [
                'menu_id' => 40121,
                'parent_id' => 40006,
                'menu_title' => 'บันทึกประมาณการจำหน่ายรายปี สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0098',
                'url' => '/om/year-distribute-export'
            ],
            [
                'menu_id' => 40122,
                'parent_id' => 40006,
                'menu_title' => 'ตัด Stock Inventory สำหรับ Sale Order',
                'program_code' => 'OMP0100',
                'url' => '/om/cut-stock-inventory'
            ],
            // 40123-40125
            // TAB 7
            [
                'menu_id' => 40126,
                'parent_id' => 40007,
                'menu_title' => 'ร้านค้าที่ไม่ต้องการให้ปลดรายการพิมพ์ใบเสร็จรับเงินอัตโนมัติ',
                'program_code' => 'OMS0029',
                'url' => '/om/settings/not-auto-release'
            ],
            [
                'menu_id' => 40127,
                'parent_id' => 40007,
                'menu_title' => 'กำหนดรหัสนายหน้า',
                'program_code' => 'OMM0008',
                'url' => '/om/customers/domestics/broker'
            ],
            // 40128-40130
            // TAB 8
            [
                'menu_id' => 40131,
                'parent_id' => 40008,
                'menu_title' => 'คืนวงเงินเชื่อ',
                'program_code' => 'OMP0004',
                'url' => '/om/release-credit'
            ],
            [
                'menu_id' => 40132,
                'parent_id' => 40008,
                'menu_title' => 'หนี้ค้างชำระ สำหรับขายในประเทศ',
                'program_code' => 'OMP0006',
                'url' => '/om/outstanding'
            ],
            [
                'menu_id' => 40133,
                'parent_id' => 40008,
                'menu_title' => 'ปรับปรุงค่าปรับยาสูบ สำหรับขายในประเทศ',
                'program_code' => 'OMP0023',
                'url' => '/om/improve-fine'
            ],
            [
                'menu_id' => 40134,
                'parent_id' => 40008,
                'menu_title' => 'บันทึกข้อมูลการชำระเงิน',
                'program_code' => 'OMP0024',
                'url' => '/om/payment-method/form'
            ],
            [
                'menu_id' => 40135,
                'parent_id' => 40008,
                'menu_title' => 'บันทึก Matching',
                'program_code' => 'OMP0025',
                'url' => '/om/domestic-matching'
            ],
            [
                'menu_id' => 40136,
                'parent_id' => 40008,
                'menu_title' => 'ปลดรายการพิมพ์ใบเสร็จรับเงิน',
                'program_code' => 'OMP0026',
                'url' => '/om/print-receipt/reprint'
            ],
            [
                'menu_id' => 40137,
                'parent_id' => 40008,
                'menu_title' => 'Credit Note เงินโอนไร่',
                'program_code' => 'OMP0034',
                'url' => '/om/credit-note-ranch-transfer'
            ],
            [
                'menu_id' => 40138,
                'parent_id' => 40008,
                'menu_title' => 'ปิดการรับเงินประจำวัน สำหรับขายในประเทศ',
                'program_code' => 'OMP0045',
                'url' => '/om/close-daily-payoff/domestic'
            ],
            [
                'menu_id' => 40139,
                'parent_id' => 40008,
                'menu_title' => 'ปิดการรับเงินประจำวัน สำหรับขายต่างประเทศ',
                'program_code' => 'OMP0079',
                'url' => '/om/close-daily-payoff/export'
            ],
            // 40140-40145
            // TAB 9
            [
                'menu_id' => 40146,
                'parent_id' => 40009,
                'menu_title' => 'กำหนดรหัสนายหน้า',
                'program_code' => 'OMM0008',
                'url' => '/om/customers/domestics/broker'
            ],
            [
                'menu_id' => 40147,
                'parent_id' => 40009,
                'menu_title' => 'กำหนดรหัสบัญชีขาย (Account Aliases)',
                'program_code' => 'OMS0017',
                'url' => '/om/settings/account-mapping'
            ],
            [
                'menu_id' => 40148,
                'parent_id' => 40009,
                'menu_title' => 'กำหนดชื่อบัญชีองค์การบริหารส่วนจังหวัด',
                'program_code' => 'OMS0036',
                'url' => '/lookup?programCode=OMS0036'
            ],
            // 40149-40150
            // TAB 10
            [
                'menu_id' => 40151,
                'parent_id' => 40010,
                'menu_title' => 'คืนวงเงินเชื่อ',
                'program_code' => 'OMP0004',
                'url' => '/om/release-credit'
            ],
            [
                'menu_id' => 40152,
                'parent_id' => 40010,
                'menu_title' => 'หนี้ค้างชำระ สำหรับขายในประเทศ',
                'program_code' => 'OMP0006',
                'url' => '/om/outstanding'
            ],
            [
                'menu_id' => 40153,
                'parent_id' => 40010,
                'menu_title' => 'Debit Note',
                'program_code' => 'OMP0032',
                'url' => '/om/debit-note'
            ],
            [
                'menu_id' => 40154,
                'parent_id' => 40010,
                'menu_title' => 'Credit Note กรณีอื่นๆ',
                'program_code' => 'OMP0033',
                'url' => '/om/credit-note-other'
            ],
            [
                'menu_id' => 40155,
                'parent_id' => 40010,
                'menu_title' => 'ยกเลิกใบลดหนี้',
                'program_code' => 'OMP0035',
                'url' => '/om/cancel-invoice'
            ],
            [
                'menu_id' => 40156,
                'parent_id' => 40010,
                'menu_title' => 'ปรับอัตราค่าขนส่ง',
                'program_code' => 'OMP0041',
                'url' => '/om/delivery-rate'
            ],
            [
                'menu_id' => 40157,
                'parent_id' => 40010,
                'menu_title' => 'ผ่านข้อมูลค่าขนส่งให้บัญชีเจ้าหนี้',
                'program_code' => 'OMP0042',
                'url' => '/om/transpot-report'
            ],
            [
                'menu_id' => 40158,
                'parent_id' => 40010,
                'menu_title' => 'ปรับปรุงรายการภาษีขาย และผ่านข้อมูลให้บัญชีแยกประเภท',
                'program_code' => 'OMP0043',
                'url' => '/om/tax-adjust'
            ],
            [
                'menu_id' => 40159,
                'parent_id' => 40010,
                'menu_title' => 'ผ่านข้อมูลค่านายหน้าให้บัญชีเจ้าหนี้ สำหรับขายในประเทศ',
                'program_code' => 'OMP0047',
                'url' => '/om/transfer-commission'
            ],
            [
                'menu_id' => 40160,
                'parent_id' => 40010,
                'menu_title' => 'ผ่านข้อมูลภาษี อบจ. ให้บัญชีเจ้าหนี้',
                'program_code' => 'OMP0048',
                'url' => '/om/transfer-province'
            ],
            [
                'menu_id' => 40161,
                'parent_id' => 40010,
                'menu_title' => 'บันทึกข้อมูลการชำระเงิน',
                'program_code' => 'OMP0067',
                'url' => '/om/export-payout'
            ],
            [
                'menu_id' => 40162,
                'parent_id' => 40010,
                'menu_title' => 'บันทึก Matching',
                'program_code' => 'OMP0068',
                'url' => '/om/export-matching'
            ],
            [
                'menu_id' => 40163,
                'parent_id' => 40010,
                'menu_title' => 'ผ่านข้อมูลภาษี อบจ. สำหรับ Modern Trade ให้บัญชีเจ้าหนี้',
                'program_code' => 'OMP0089',
                'url' => '/om/pao-tax-mt'
            ],
            [
                'menu_id' => 40164,
                'parent_id' => 40010,
                'menu_title' => 'โอนข้อมูล และ Generate Text file ภาษี อบจ. เพื่อนำส่งธนาคาร',
                'program_code' => 'OMP0094',
                'url' => '/om/transfer-txt-to-bank'
            ],
            [
                'menu_id' => 40165,
                'parent_id' => 40010,
                'menu_title' => 'ปรับปรุงรายการภาษีขาย สโมสร กทม. (กองภาษี) สำหรับขายในประเทศ',
                'program_code' => 'OMP0099',
                'url' => '/om/tax-adjustments-bkk'
            ],
            // 40166-40170
            // TAB 11
            [
                'menu_id' => 40171,
                'parent_id' => 40011,
                'menu_title' => 'ข้อมูลอำเภอ/เขต,จังหวัด,ภาค,รหัสไปรษณีย์ของประเทศไทย',
                'program_code' => 'OMS0018',
                'url' => '/om/settings/thailand-territory'
            ],
            // 40172-40175
            // TAB 12
            [
                'menu_id' => 40176,
                'parent_id' => 40012,
                'menu_title' => 'ข้อมูลลูกค้าขายในประเทศ',
                'program_code' => 'OMM0005',
                'url' => '/om/customers/domestics'
            ],
            // 40177-40180
            // TAB 13
            [
                'menu_id' => 40181,
                'parent_id' => 40013,
                'menu_title' => 'ข้อมูล Promotion ส่งเสริมการขาย',
                'program_code' => 'OMS0003',
                'url' => '/om/promotions'
            ],
            [
                'menu_id' => 40182,
                'parent_id' => 40013,
                'menu_title' => 'กำหนดลำดับผลิตภัณฑ์ในการประมาณการจำหน่ายรายปักษ์',
                'program_code' => 'OMP0053',
                'url' => '/om/sequence-fortnightly'
            ],
            [
                'menu_id' => 40183,
                'parent_id' => 40013,
                'menu_title' => 'กำหนดงวดการทำงานของการประมาณการจำหน่ายรายปักษ์',
                'program_code' => 'OMP0054',
                'url' => '/om/biweekly-periods'
            ],
            [
                'menu_id' => 40184,
                'parent_id' => 40013,
                'menu_title' => 'โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย',
                'program_code' => 'OMP0055',
                'url' => '/om/transfer-bi-weekly/domestic'
            ],
            [
                'menu_id' => 40185,
                'parent_id' => 40013,
                'menu_title' => 'บันทึกประมาณการจำหน่ายรายปักษ์',
                'program_code' => 'OMP0056',
                'url' => '/om/transfer-bi-weekly/domestic/approved'
            ],
            [
                'menu_id' => 40186,
                'parent_id' => 40013,
                'menu_title' => 'โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย',
                'program_code' => 'OMP0057',
                'url' => '/om/monthly-distribute/domestic'
            ],
            [
                'menu_id' => 40187,
                'parent_id' => 40013,
                'menu_title' => 'บันทึกประมาณการจำหน่ายรายเดือน',
                'program_code' => 'OMP0058',
                'url' => '/om/monthly-distribute/domestic/approved'
            ],
            [
                'menu_id' => 40188,
                'parent_id' => 40013,
                'menu_title' => 'โอนข้อมูลประมาณการจำหน่ายรายปีเข้าระบบงานขาย',
                'program_code' => 'OMP0059',
                'url' => '/om/year-distribute/domestic'
            ],
            [
                'menu_id' => 40189,
                'parent_id' => 40013,
                'menu_title' => 'บันทึกประมาณการจำหน่ายรายปี',
                'program_code' => 'OMP0060',
                'url' => '/om/year-distribute/domestic/approved'
            ],
            [
                'menu_id' => 40190,
                'parent_id' => 40013,
                'menu_title' => 'โอนข้อมูลเพดานการจำหน่ายประจำเดือนเข้าระบบงานขาย',
                'program_code' => 'OMP0061',
                'url' => '/om/transfer-monthly/domestic'
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

        $this->newRole(40000);
        $this->newRoleTab1(40001);
        $this->newRoleTab2(40002);
        $this->newRoleTab3(40003);
        $this->newRoleTab4(40004);
        $this->newRoleTab5(40005);
        $this->newRoleTab6(40006);
        $this->newRoleTab7(40007);
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
                    ->whereRaw("menu_id between 40000 and  50000")
                    ->orderBy('url')
                    ->get();
        return $menus;
    }

    public function newRole($roleId)
    {
        $menus = [
            // TAB 1,
            '/om/settings/transport-owner',
            '/om/settings/transportation-route',
            // TAB 2,
            '/om/print-receipt/print',
            '/om/print-invoice',
            '/om/draft-payout',
            '/om/approval-claim',
            '/om/rma-domestic',
            '/om/claim/claim-approve',
            '/om/rma-export',
            // TAB 3,
            '/om/settings/order-period',
            '/om/settings/term',
            '/lookup?programCode=OMS0006',
            '/lookup?programCode=OMS0009',
            '/om/settings/price-list',
            '/lookup?programCode=OMS0014',
            '/om/settings/direct-debit-domestic',
            '/om/settings/grant-spacial-case',
            '/lookup?programCode=OMS0022',
            '/om/settings/quota-credit-group',
            '/om/settings/authority-list',
            '/om/settings/over-quota-approval',
            '/om/settings/sequence-ecom',
            '/om/settings/approver-order',
            '/lookup?programCode=OMS0032',
            '/lookup?programCode=OMS0034',
            '/lookup?programCode=OMS0035',
            '/lookup?programCode=OMS0037',
            '/lookup?programCode=OMS0038',
            '/lookup?programCode=OMS0039',
            '/lookup?programCode=OMS0040',
            '/lookup?programCode=OMS0041',
            '/lookup?programCode=OMS0043',
            // TAB 4,
            '/om/release-credit',
            '/om/outstanding',
            '/om/postpone-delivery',
            '/om/addition-quota',
            '/om/order/prepare',
            '/om/prepare-saleorder',
            '/om/approve-saleorder',
            '/om/order-direct-debit/domestic',
            '/om/order-direct-debit/domestic/file-tranfer',
            '/om/approve-prepare',
            '/om/invoice/cancel',
            '/om/reprint-invoice',
            '/om/consignment-club',
            '/om/consignment-bkk',
            '/om/consignment/cancel',
            '/om/close-flag/domestic',
            '/om/prepare-sale-orders/search?type=domestic',
            '/om/close-daily-sale',
            // TAB 5,
            '/om/settings/term-export',
            '/lookup?programCode=OMS0007',
            '/lookup?programCode=OMS0008',
            '/lookup?programCode=OMS0010',
            '/om/settings/country',
            '/om/settings/price-list-export',
            '/lookup?programCode=OMS0015',
            '/om/settings/customer',
            '/om/settings/direct-debit-export',
            '/om/settings/item-weight',
            '/om/settings/approver-order-export',
            // TAB 6,
            '/om/customers/approves',
            '/om/customers/exports',
            '/om/sequence-fortnightly',
            '/om/transfer-bi-weekly/domestic',
            '/om/monthly-distribute/domestic',
            '/om/year-distribute/domestic',
            '/om/overdue-debt',
            '/om/sale-confirmation',
            '/om/order-direct-debit/export',
            '/om/order-direct-debit/export/file-tranfer',
            '/om/improve-fine-exp',
            '/om/proforma-invoice',
            '/om/tax-invoice-export',
            '/om/exchange-export',
            '/om/debit-note-export',
            '/om/credit-note-other-export',
            '/om/close-flag/export',
            '/om/prepare-sale-orders/search?type=export',
            '/om/transfer-bi-weekly-export',
            '/om/monthly-distribute-export',
            '/om/year-distribute-export',
            '/om/cut-stock-inventory',
            // TAB 7,
            '/om/settings/not-auto-release',
            '/om/customers/domestics/broker',
            // TAB 8,
            '/om/release-credit',
            '/om/outstanding',
            '/om/improve-fine',
            '/om/payment-method/form',
            '/om/domestic-matching',
            '/om/print-receipt/reprint',
            '/om/credit-note-ranch-transfer',
            '/om/close-daily-payoff/domestic',
            '/om/close-daily-payoff/export',
            // TAB 9,
            '/om/customers/domestics/broker',
            '/om/settings/account-mapping',
            '/lookup?programCode=OMS0036',
            // TAB 10,
            '/om/release-credit',
            '/om/outstanding',
            '/om/debit-note',
            '/om/credit-note-other',
            '/om/cancel-invoice',
            '/om/delivery-rate',
            '/om/transpot-report',
            '/om/tax-adjust',
            '/om/transfer-commission',
            '/om/transfer-province',
            '/om/export-payout',
            '/om/export-matching',
            '/om/pao-tax-mt',
            '/om/transfer-txt-to-bank',
            '/om/tax-adjustments-bkk',
            // TAB 11,
            '/om/settings/thailand-territory',
            // TAB 12,
            '/om/customers/domestics',
            // TAB 13,
            '/om/promotions',
            '/om/sequence-fortnightly',
            '/om/biweekly-periods',
            '/om/transfer-bi-weekly/domestic',
            '/om/transfer-bi-weekly/domestic/approved',
            '/om/monthly-distribute/domestic',
            '/om/monthly-distribute/domestic/approved',
            '/om/year-distribute/domestic',
            '/om/year-distribute/domestic/approved',
            '/om/transfer-monthly/domestic'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'OM: ระบบงานขาย', 'OM', $menus);
    }

    public function newRoleTab1($roleId)
    {
        $menus = [
            // TAB 1,
            '/om/settings/transport-owner',
            '/om/settings/transportation-route',
            // TAB 2,
            '/om/print-receipt/print',
            '/om/print-invoice',
            '/om/draft-payout',
            '/om/approval-claim',
            '/om/rma-domestic',
            '/om/claim/claim-approve',
            '/om/rma-export'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'OM: กองคลังผลิตภัณฑ์', 'OM', $menus);
    }

    public function newRoleTab2($roleId)
    {
        $menus = [
            // TAB 3,
            '/om/settings/order-period',
            '/om/settings/term',
            '/lookup?programCode=OMS0006',
            '/lookup?programCode=OMS0009',
            '/om/settings/price-list',
            '/lookup?programCode=OMS0014',
            '/om/settings/direct-debit-domestic',
            '/om/settings/grant-spacial-case',
            '/lookup?programCode=OMS0022',
            '/om/settings/quota-credit-group',
            '/om/settings/authority-list',
            '/om/settings/over-quota-approval',
            '/om/settings/sequence-ecom',
            '/om/settings/approver-order',
            '/lookup?programCode=OMS0032',
            '/lookup?programCode=OMS0034',
            '/lookup?programCode=OMS0035',
            '/lookup?programCode=OMS0037',
            // TAB 4,
            '/om/release-credit',
            '/om/outstanding',
            '/om/postpone-delivery',
            '/om/addition-quota',
            '/om/order/prepare',
            '/om/prepare-saleorder',
            '/om/approve-saleorder',
            '/om/order-direct-debit/domestic',
            '/om/order-direct-debit/domestic/file-tranfer',
            '/om/approve-prepare',
            '/om/invoice/cancel',
            '/om/reprint-invoice',
            '/om/consignment-club',
            '/om/consignment-bkk',
            '/om/consignment/cancel',
            '/om/close-flag/domestic',
            '/om/prepare-sale-orders/search?type=domestic',
            '/om/close-daily-sale'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'OM: ระบบงานขายในประเทศ', 'OM', $menus);
    }


    public function newRoleTab3($roleId)
    {
        $menus = [
            // TAB 5,
            '/om/settings/term-export',
            '/lookup?programCode=OMS0007',
            '/lookup?programCode=OMS0008',
            '/lookup?programCode=OMS0010',
            '/om/settings/country',
            '/om/settings/price-list-export',
            '/lookup?programCode=OMS0015',
            '/om/settings/customer',
            '/om/settings/direct-debit-export',
            '/om/settings/item-weight',
            '/om/settings/approver-order-export',
            // TAB 6,
            '/om/customers/approves',
            '/om/customers/exports',
            '/om/sequence-fortnightly',
            '/om/transfer-bi-weekly/domestic',
            '/om/monthly-distribute/domestic',
            '/om/year-distribute/domestic',
            '/om/overdue-debt',
            '/om/sale-confirmation',
            '/om/order-direct-debit/export',
            '/om/order-direct-debit/export/file-tranfer',
            '/om/improve-fine-exp',
            '/om/proforma-invoice',
            '/om/tax-invoice-export',
            '/om/exchange-export',
            '/om/debit-note-export',
            '/om/credit-note-other-export',
            '/om/close-flag/export',
            '/om/prepare-sale-orders/search?type=export',
            '/om/transfer-bi-weekly-export',
            '/om/monthly-distribute-export',
            '/om/year-distribute-export',
            '/om/cut-stock-inventory'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'OM: ระบบงานขายต่างประเทศ', 'OM', $menus);
    }

    public function newRoleTab4($roleId)
    {
        $menus = [
            // TAB 7,
            '/om/settings/not-auto-release',
            '/om/customers/domestics/broker',
            // TAB 8,
            '/om/release-credit',
            '/om/outstanding',
            '/om/improve-fine',
            '/om/payment-method/form',
            '/om/domestic-matching',
            '/om/print-receipt/reprint',
            '/om/credit-note-ranch-transfer',
            '/om/close-daily-payoff/domestic',
            '/om/close-daily-payoff/export',
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'OM: กองรับและจ่ายเงิน', 'OM', $menus);
    }

    public function newRoleTab5($roleId)
    {
        $menus = [
            // TAB 9,
            '/om/customers/domestics/broker',
            '/om/settings/account-mapping',
            '/lookup?programCode=OMS0036',
            // TAB 10,
            '/om/release-credit',
            '/om/outstanding',
            '/om/debit-note',
            '/om/credit-note-other',
            '/om/cancel-invoice',
            '/om/delivery-rate',
            '/om/transpot-report',
            '/om/tax-adjust',
            '/om/transfer-commission',
            '/om/transfer-province',
            '/om/export-payout',
            '/om/export-matching',
            '/om/pao-tax-mt',
            '/om/transfer-txt-to-bank',
            '/om/tax-adjustments-bkk'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'OM: กองบัญชีรายได้', 'OM', $menus);
    }

    public function newRoleTab6($roleId)
    {
        $menus = [
            // TAB 11,
            '/om/settings/thailand-territory',
            // TAB 12,
            '/om/customers/domestics'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'OM: กองช่องทางการจำหน่าย', 'OM', $menus);
    }

    public function newRoleTab7($roleId)
    {
        $menus = [
            // TAB 13,
            '/om/promotions',
            '/om/sequence-fortnightly',
            '/om/biweekly-periods',
            '/om/transfer-bi-weekly/domestic',
            '/om/transfer-bi-weekly/domestic/approved',
            '/om/monthly-distribute/domestic',
            '/om/monthly-distribute/domestic/approved',
            '/om/year-distribute/domestic',
            '/om/year-distribute/domestic/approved',
            '/om/transfer-monthly/domestic'
        ];

        $menus = $this->getMenus($menus);
        $this->createRole($roleId, 'OM: ประมาณการจำหน่าย', 'OM', $menus);
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