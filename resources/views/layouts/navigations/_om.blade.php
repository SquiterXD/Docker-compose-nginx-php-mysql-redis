<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">OM </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ url('om/customers/approves/') }}">OMM0003 : อนุมัติการสร้างลูกค้าสำหรับขายต่างประเทศ</a></li>
        <li><a href="{{ url('om/customers/exports') }}">OMM0004 : ข้อมูลลูกค้าขายต่างประเทศ</a></li>
        <li><a href="{{ url('om/customers/domestics') }}">OMM0005 : ข้อมูลลูกค้าขายในประเทศ</a></li>
        <li><a href="{{ url('om/customers/domestics/broker') }}">OMM0008 : กำหนดรหัสนายหน้า</a></li>
        <li><a href="{{ url('om/release-credit') }}">OMP0004 : คืนวงเงินเชื่อ</a></li>
        <li><a href="{{ url('om/postpone-delivery') }}">OMP0009 : หน้าจอเลื่อนวันส่งประจำสัปดาห์</a></li>
        {{-- <li><a href="{{ url('om/form-order') }}">OMP0013 : อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ</a></li> --}}
        <li><a href="{{ url('om/addition-quota') }}">OMP0015 : การอนุมัติใบคำร้องขอเพิ่มเพดาน</a></li>

        <li><a href="{{ url('om/order/prepare') }}">OMP0019 บันทึกใบเตรียมการขาย</a></li>
        <li><a href="{{ url('om/prepare-saleorder') }}">OMP0020 ใบเตรียมการขาย ส่งเสริม ยสท. /บุหรี่ทดลอง/บุหรี่ตัวอย่าง</a></li>
        <li><a href="{{ url('om/approve-saleorder') }}">OMP0021 อนุมัติใบเตรียมการขายเพื่อตั้งหนี้</a></li>

        <li><a href="{{ url('om/improve-fine') }}">OMP0023 : ปรับปรุงค่าปรับยาสูบ สำหรับขายในประเทศ</a></li>

        <li><a href="{{ url('om/payment-method/form') }}">OMP0024 : บันทึกข้อมูลการชำระเงิน</a></li>
        <li><a href="{{ url('om/domestic-matching') }}">OMP0025 : บันทึก Matching</a></li>

        <li><a href="{{ url('om/print-receipt/reprint') }}">OMP0026 : ปลดรายการพิมพ์ใบเสร็จรับเงิน</a></li>
        <li><a href="{{ url('om/print-receipt/print') }}">OMP0027 : พิมพ์ใบเสร็จรับเงิน (กองคลังผลิตภัณฑ์)</a></li>

        <li><a href="{{ url('om/order-direct-debit/domestic') }}">OMP0028 : การรับเงินแบบ Direct Debit ในประเทศ</a></li>

        <li><a href="{{ url('om/order-direct-debit/domestic/file-tranfer/') }}">OMP0029 : โอนข้อมูล Text File เพื่อส่งธนาคาร</a></li>

        <li><a href="{{ url('om/approve-prepare') }}">OMP0030 อนุมัติใบเตรียมการขาย/ใบสั่งซื้อ</a></li>
        <li><a href="{{ url('om/invoice/cancel') }}">OMP0031 ยกเลิก Invoice/ใบขน</a></li>
        <li><a href="{{ url('om/debit-note') }}">OMP0032 Debit Note</a></li>
        <li><a href="{{ url('om/credit-note-other') }}">OMP0033 Credit Note กรณีอื่นๆ</a></li>
        <li><a href="{{ url('om/credit-note-ranch-transfer') }}">OMP0034 Credit Note เงินโอนไร่</a></li>
        <li><a href="{{ url('om/cancel-invoice') }}">OMP0035 ยกเลิกใบลดหนี้</a></li>
        <li><a href="{{ url('om/print-invoice') }}">OMP0036 พิมพ์ Invoice / ใบขน / Credit Note</a></li>

        <li><a href="{{ url('om/reprint-invoice') }}">OMP0037 ปลดรายการ Reprint Invoice/ใบขน</a></li>
        <li><a href="{{ url('om/consignment-club') }}">OMP0038 : รายการฝากขายสโมสรภูมิภาค</a></li>
        <li><a href="{{ url('om/consignment/cancel') }}">OMP0039 : ยกเลิกฝากขาย</a></li>
        <li><a href="{{ url('om/draft-payout') }}">OMP0040 : สร้างใบจ่ายยาสูบจากใบเตรียมขาย</a></li>
        <li><a href="{{ url('om/delivery-rate') }}">OMP0041 : ปรับอัตราค่าขนส่ง</a></li>
        <li><a href="{{ url('om/transpot-report') }}">OMP0042 : ผ่านข้อมูลค่าขนส่งให้บัญชีเจ้าหนี้</a></li>
        <li><a href="{{ url('om/tax-adjust') }}">OMP0043 ปรับปรุงรายการภาษีขาย และผ่านข้อมูลให้บัญชีแยกประเภท</a></li>
        <li><a href="{{ url('om/transfer-commission') }}">OMP0047 ผ่านข้อมูลค่านายหน้าให้บัญชีเจ้าหนี้ สำหรับขายในประเทศ</a></li>
        <li><a href="{{ url('om/close-flag/domestic') }}">OMPclose-flag0044 ปิดการขายประจำวัน สำหรับขายในประเทศ</a></li>
        <li><a href="{{ url('om/transfer-province') }}">OMP0048 ผ่านข้อมูลภาษี อบจ. ให้บัญชีเจ้าหนี้</a></li>

        <li><a href="{{ url('om/sequence-fortnightly') }}">OMP0053 : กำหนดลำดับผลิตภัณฑ์ในการประมาณการจำหน่ายรายปักษ์</a></li>
        <li><a href="{{ url('om/biweekly-periods') }}">OMP0054 : กำหนดงวดการทำงานของการประมาณการจำหน่ายรายปักษ์</a></li>

        <li><a href="{{ url('om/transfer-bi-weekly/domestic') }}">OMP0055 : โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย</a></li>
        <li><a href="{{ url('om/transfer-bi-weekly/domestic/approved') }}">OMP0056 : บันทึกประมาณการจำหน่ายรายปักษ์</a></li>
        <li><a href="{{ url('om/monthly-distribute/domestic') }}">OMP0057 : โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย</a></li>
        <li><a href="{{ url('om/monthly-distribute/domestic/approved') }}">OMP0058 : บันทึกประมาณการจำหน่ายรายเดือน</a></li>
        <li><a href="{{ url('om/year-distribute/domestic') }}">OMP0059 : โอนข้อมูลประมาณการจำหน่ายรายปีเข้าระบบงานขาย</a></li>
        <li><a href="{{ url('om/year-distribute/domestic/approved') }}">OMP0060 : บันทึกประมาณการจำหน่ายรายปี</a></li>
        <li><a href="{{ url('om/transfer-monthly/domestic') }}">OMP0061 : โอนข้อมูลเพดานการจำหน่ายประจำเดือนเข้าระบบงานขาย</a></li>
        <li><a href="{{ url('om/overdue-debt') }}">OMP0065 : หนี้ค้างชำระ</a></li>
        <li><a href="{{ url('om/sale-confirmation') }}">OMP0066 : บันทึกใบ Sale-Confirmation สำหรับขายต่างประเทศ</a></li>

        <li><a href="{{ url('om/export-payout') }}">OMP0067 บันทึกข้อมูลการชำระเงิน</a></li>
        <li><a href="{{ url('om/export-matching') }}">OMP0068 บันทึก Matching</a></li>
        <li><a href="{{ url('om/order-direct-debit/export') }}">OMP0069 : การรับเงินแบบ Direct Debit ต่างประเทศ</a></li>
        <li><a href="{{ url('om/order-direct-debit/export/file-tranfer') }}">OMP0070 : โอนข้อมูล Text File เพื่อส่งธนาคาร ต่างประเทศ</a></li>
        <li><a href="{{ url('om/proforma-invoice') }}">OMP0072 : บันทึกใบ Proforma Invoice</a></li>
        <li><a href="{{ url('om/tax-invoice-export') }}">OMP0073 : บันทึก Invoice, Tax Invoice</a></li>
        <li><a href="{{ url('om/exchange-export') }}">OMP0075 : บันทึกอัตราแลกเปลี่ยนตามวันที่ในใบขน</a></li>
        <li><a href="{{ url('om/debit-note-export') }}">OMP0076 Debit Note สำหรับขายต่างประเทศ</a></li>
        <li><a href="{{ url('om/credit-note-other-export') }}">OMP0077 Credit Note กรณีอื่นๆ</a></li>
        <li><a href="{{ url('om/close-flag/export') }}">OMP0078 ปิดการขายประจำวัน สำหรับขายต่างประเทศ</a></li>
        <li><a href="{{ url('om/rma-export') }}">OMP0084 : สร้างใบคืนสินค้า (RMA) ต่างประเทศ</a></li>
        <li><a href="{{ url('om/promotions') }}">OMS0003 : ข้อมูล Promotion ส่งเสริมการขาย</a></li>
        <li><a href="{{ url('om/transfer-bi-weekly-export') }}">OMP0096 บันทึกประมาณการจำหน่ายรายปักษ์ สำหรับขายต่างประเทศ</a></li>
        <li><a href="{{ url('om/monthly-distribute-export') }}">OMP0097 บันทึกประมาณการจำหน่ายรายเดือน สำหรับขายต่างประเทศ</a></li>
        <li><a href="{{ url('om/year-distribute-export') }}">OMP0098 บันทึกประมาณการจำหน่ายรายปี สำหรับขายต่างประเทศ</a></li>
    </ul>
</li>


{{-- <li>
    <a href="{{ route('om.settings.sequence-ecom.index') }}">กำหนดลำดับผลิตภัณฑ์</a>
</li>
<li>
    <a href="{{ route('om.settings.quota-credit-group.index') }}">กำหนดข้อมูลกลุ่มโควต้าและกลุ่มวงเงินเชื่อรายผลิตภัณฑ์</a>
</li>
<li>
    <a href="{{ route('om.settings.grant-spacial-case.index') }}">กำหนดสิทธิ์สั่งซื้อพิเศษ</a>
</li>
<li>
    <a href="{{ route('om.settings.authority-list.index') }}">กำหนดผู้มีอำนาจ</a>
</li> --}}



{{-- <li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label"> กำหนด Price List </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('om.settings.price-list.index') }}"> กำหนด Price List (สำหรับขายในประเทศ) </a></li>
        <li><a href="{{ route('om.settings.price-list-export.index') }}"> กำหนด Price List (สำหรับขายต่างประเทศ) </a></li>
    </ul>
</li>


<li>
    <a href="{{ route('om.settings.over-quota-approval.index') }}"><i class="fa fa-sitemap"></i> <span class="nav-label">กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า </span></a>
</li> --}}

{{-- <li>
    <a href="{{ route('om.settings.item-weight.index') }}">กำหนด Weight / Unit</a>
</li> --}}

{{-- <li>
    <a href="{{ route('om.settings.direct-debit-domestic.index') }}">สร้างข้อมูลลูกค้า Direct Debit - ขายในประเทศ</a>
</li>

<li>
    <a href="{{ route('om.settings.direct-debit-export.index') }}">สร้างข้อมูลลูกค้า Direct Debit - ขายต่างประเทศ</a>
</li>

<li>
    <a href="{{ route('om.settings.account-mapping.index') }}">กำหนด Mapping Account Code GL</a>
</li> --}}

{{-- <li>
    <a href="{{ route('om.settings.not-auto-release.index') }}">ร้านค้าที่ไม่ต้องการให้ปลดรายการพิมพ์ใบเสร็จรับเงินอัตโนมัติ</a>
</li>

<li>
    <a href="{{ route('om.settings.approver-order.index') }}">กำหนดผู้อนุมัติใบเตรียมการขาย / ใบสั่งซื้อ</a>
</li> --}}

<li>
    <a href="{{ route('om.settings.thailand-territory.index') }}"><i class="fa fa-sitemap"></i> <span class="nav-label">Upload ข้อมูลอำเภอ/เขต,จังหวัด,ภาค ของประเทศไทย</span></a>
</li>
    {{-- <li>
    <a href="{{ route('om.settings.thailand-territory.index') }}">Upload ข้อมูลอำเภอ/เขต,จังหวัด,ภาค ของประเทศไทย</a>
</li>
<li>
    <a href="{{ route('om.settings.transport-owner.index') }}">บันทึกข้อมูลเจ้าของรถขนส่ง (สำหรับขายในประเทศ)</a>
</li>
<li>
    <a href="{{ route('om.settings.transportation-route.index') }}">กำหนดช่วงเวลามาตราฐานการส่งมอบ (สำหรับขายในประเทศ)</a>
</li> --}}
<li>
    <a href="{{ route('om.settings.order-period.index') }}">กำหนดงวดการสั่งซื้อ</a>
</li>

