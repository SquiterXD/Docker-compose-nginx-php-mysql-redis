<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label"> การทำรายการ (Transaction) </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('eam.transaction.preventive-maintenance-plan') }}">แผนซ่อมบำรุงเชิงป้องกัน</a></li>
    </ul>
</li>
<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">แจ้งซ่อม (Work Request) </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('eam.work-requests.create') }}">ใบแจ้งซ่อม</a></li>
        <li><a href="{{ route('eam.work-requests.index') }}">รายการแจ้งซ่อมทั้งหมด</a></li>
        <li><a href="{{ route('eam.work-requests.waiting-approve') }}">รายการแจ้งซ่อมรออนุมัติ</a></li>
    </ul>
</li>
<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label"> การตั้งค่า (Setup) </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('eam.setup.machine') }}">เครื่องจักร</a></li>
    </ul>
</li>
<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">งานซ่อม (Work Orders) </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('eam.work-orders.create') }}">ใบรับงานซ่อม</a></li>
        <li><a href="{{ route('eam.work-orders.waiting-open-work') }}">รายการแจ้งซ่อมรอเปิดงาน</a></li>
        <li><a href="{{ route('eam.work-orders.list-repair-jobs-waiting-close') }}">รายการงานซ่อมรอปิดงาน</a></li>
        <li><a href="{{ route('eam.work-orders.list-all-repair-jobs') }}">รายการงานซ่อมทั้งหมด</a></li>
        <li><a href="{{ route('eam.work-orders.confirmed-list-repair-work') }}">รายการงานซ่อมรอยืนยัน</a></li>
    </ul>
</li>
<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">สอบถามข้อมูล (Inquiry) </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('eam.ask-for-information.check-spare-parts-inventory') }}">ตรวจสอบอะไหล่คงคลัง</a></li>
        <li><a href="{{ route('eam.ask-for-information.parts-transferred-warehouse') }}">อะไหล่ถูกโอนเข้าคลัง</a></li>
    </ul>
</li>
<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">รายงาน (Report) </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('eam.report.bill-materials') }}">ใบเบิกวัสดุ ร.ย.ส.1</a></li>
        <li><a href="{{ route('eam.report.request-mat-inv') }}">CT ใบเบิกวัสดุ (Inventory)</a></li>
        <li><a href="{{ route('eam.report.request-mat-non') }}">CT ใบเบิกวัสดุ (Non Stock)</a></li>
        <li><a href="{{ route('eam.report.issue-mat-excel') }}">CT ข้อมูลการตัดจ่ายอะไหล่จากคลัง (Excel)</a></li>
        <li><a href="{{ route('eam.report.summary-labor') }}">CT รายงานสรุปการบันทึกค่าแรงงานซ่อม</a></li>
        <li><a href="{{ route('eam.report.labor') }}">CT ข้อมูลการบันทึกค่าแรง (Excel)</a></li>
        <li><a href="{{ route('eam.report.payable') }}">CT รายงานข้อมูลระบบเจ้าหนี้เข้าระบบบำรุงรักษาเครื่องจักร</a></li>
        <li><a href="{{ route('eam.report.closed-wo') }}">CT ใบปิดงานซ่อม</a></li>
        <li><a href="{{ route('eam.report.closed-wo2') }}">CT ใบปิดงานซ่อม (โรงพิมพ์)</a></li>
        <li><a href="{{ route('eam.report.closed-wo-jp') }}">CT ใบปิดงานผลิตชิ้นส่วนอะไหล่อุปกรณ์</a></li>
        <li><a href="{{ route('eam.report.summary-month') }}">CT รายงานสรุปใบรับงานประจำเดือน</a></li>
        <li><a href="{{ route('eam.report.summary-month-excel') }}">CT รายงานสรุปใบรับงานประจำเดือน (EXPORT)</a></li>
        <li><a href="{{ route('eam.report.receipt-mat') }}">CT รายงานส่งข้อมูลอะไหล่เข้าระบบสินค้าคงคลัง</a></li>
        <li><a href="{{ route('eam.report.mnt-history') }}">CT รายงานประวัติการซ่อมบำรุงเครื่องจักร (NEW)</a></li>
        <li><a href="{{ route('eam.report.maintenance') }}">CT ข้อมูลการซ่อมบำรุงเครื่องจักร (Excel)</a></li>
        <li><a href="{{ route('eam.report.purchase') }}">CT ข้อมูลการจัดซื้อ/จัดจ้าง (Excel)</a></li>
        <li><a href="{{ route('eam.report.job-account-del') }}">CT รายงานบัญชีงานระหว่างประกอบ (แยกรายละเอียด) ประเภท JOB สั่งผลิต</a></li>
        <li><a href="{{ route('eam.report.job-account') }}">CT รายงานบัญชีงานระหว่างประกอบ งวดเดือน ประเภท JOB สั่งผลิต</a></li>
        <li><a href="{{ route('eam.report.wo-cost') }}">CT รายงานสรุปค่าใช้จ่ายของใบสั่งซ่อม</a></li>
        <li><a href="{{ route('eam.report.wo-com-status') }}">CT รายงานสรุปสถานะใบสั่งซ่อมที่ส่งมอบเสร็จสิ้นแต่ยังไม่ปิดค่าใช้จ่าย</a></li>
        <li><a href="{{ route('eam.report.labor-account') }}">CT รายงานส่งค่าแรงระหว่างประกอบเข้าบัญชีแยกประเภท</a></li>
        <li><a href="{{ route('eam.report.summary-mat-status') }}">CT รายงานสรุปสถานะการของการจัดหาอะไหล่รวมทั้งการเบิกจ่ายอะไหล่เข้าใบสั่งซ่อม</a></li>
    </ul>
</li>
