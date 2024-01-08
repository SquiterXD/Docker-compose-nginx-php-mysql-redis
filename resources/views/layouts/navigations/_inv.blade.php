<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">INV </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('inv.requisition_stationery.index') }}">1.1 ค้นหารายการเบิก</a></li>
        <li><a href="{{ route('inv.requisition_stationery.create') }}">1.2 ขอเบิกเครื่องเขียน</a></li>
        <li>
            <a href="#">1.3 รายงาน</a>
            <ul class="nav nav-third-level">
                <li><a href="{{ route('inv.requisition_stationery.summary-web-stationery-report') }}">รายงานสรุปการเบิกจ่ายเครื่องเขียน/เบ็ดเตล็ด (ตามราย item)</a></li>
                <li><a href="{{ route('inv.requisition_stationery.order-history-report') }}">รายงานประวัติสั่งซื้อย้อนหลัง</a></li>
            </ul>
        </li>
    </ul>
</li>
<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">INV2 </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('inv.disbursement_fuel.index') }}">2.1. สรุปรายการเบิกจ่ายน้ำมัน</a></li>
        <li><a href="{{ route('inv.disbursement_fuel.create') }}">2.2. เบิกจ่ายน้ำมันสำหรับองค์กร</a></li>
        <li><a href="{{ route('inv.disbursement_fuel.add_new_car') }}">2.3. ข้อมูลรถยนต์ใหม่</a></li>
        <li><a href="{{ route('inv.disbursement_fuel.show') }}">2.4. ค้นหาข้อมูลรถยนต์</a></li>
        <li>
            <a href="#">2.5. ปริ๊นรายงาน</a>
            <ul class="nav nav-third-level">
                <li><a href="{{ route('inv.disbursement_fuel.fuel-supply-report') }}">รายงานยอดจ่ายน้ำมันเชื้อเพลิง</a></li>
                <li><a href="{{ route('inv.disbursement_fuel.fuel-payment-summary-report') }}">รายงานยอดจ่ายน้ำมันเชื้อเพลิงตามค่าใช้จ่าย</a></li>
                <li><a href="#">สรุปยอดจ่ายน้ำมันตามประเภท</a></li>
                <li><a href="#">รายละเอียดน้ำมันเชื้อเพลิง</a></li>
                <li><a href="{{ route('inv.disbursement_fuel.oil-consumption-public-car-report') }}">รายงานยอดการใช้น้ำมันรถยนต์ส่วนกลาง</a></li>
            </ul>
        </li>
    </ul>
</li>
