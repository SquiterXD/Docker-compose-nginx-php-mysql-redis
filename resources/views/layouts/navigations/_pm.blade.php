<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">PM </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('pm.production-order.index') }}">
                01: เปิดคำสั่งการผลิต</a></li>

        <li><a href="{{ route('pm.request-creation.index') }}">
                02: การเรียกใบยาและการส่งขออนุมัติการสร้างลูกค้า</a></li>

        <li><a href="{{ route('pm.annual-production-plan.index') }}">
                03: ประมาณการวัตถุดิบประจำปี</a></li>

        <li><a href="{{ route('pm.0004.index') }}">
                04: รายการขอเบิกวัตถุดิบ</a></li>

        <li><a href="{{ route('pm.request-materials.index') }}">
                05: ขอเบิกวัตถุดิบนอกแผน</a></li>

        <li><a href="{{ route('pm.report-product-in-process.index') }}">
                06: รายงานผลผลิตในกระบวนการผลิต</a></li>

        <li><a href="{{ route('pm.cut-raw-material.index', ['v' => '1']) }}">
                07.1: บันทึกตัดใช้วัตถุดิบ ใบยา</a></li>

        <li><a href="{{ route('pm.cut-raw-material.index', ['v' => '2']) }}">
                07.2: บันทึกตัดใช้วัตถุดิบ สารปรุง/สารหอม</a></li>

{{--        <li><a href="{{ route('pm.cut-raw-material.index', ['view_no' => '03']) }}">--}}
{{--                07.3: บันทึกตัดใช้วัตถุดิบ</a></li>--}}

        <li><a href="{{ route('pm.inventory-list.index') }}">
                08: รายการวัตถุดิบคงคลัง</a></li>

        <li><a href="{{ route('pm.test-raw-material.index') }}">
                09: ตัดใช้วัตถุดิบทดลอง</a></li>

        <li><a href="{{ route('pm.review-complete.index') }}">
                10: บันทึกผลผลิตเข้าคลัง</a></li>

        <li><a href="{{ route('pm.planning-job-lines.index') }}">
                11 การวางแผนผลิตยาเส้น</a></li>

        <li><a href="{{ route('pm.0012.index') }}">
                12 บันทึกสูญเสีย</a></li>

        <li><a href="{{ route('pm.record-tobacco-usage-zone-c48.index') }}">
                13: บันทึกใช้ยาเส้น Zone C48</a></li>

        <li><a href="{{ route('pm.0014.index') }}">
                14 ปิดคำสั่งการผลิต(ใบยา)</a></li>

        <li><a href="{{ route('pm.regional-tobacco-production-planning.index') }}">
                15: วางแผนการผลิตยาเส้นภูมิภาค</a></li>

        <li><a href="{{ route('pm.0016.index') }}">
                16: เบิกวัตถุดิบยาเส้นภูมิภาค</a></li>

        <li><a href="{{ route('pm.domestic-printing-production-planning.index') }}">
                17: วางแผนการผลิตสิ่งพิมพ์ภายในประเทศ</a></li>

        <li><a href="{{ route('pm.fortnightly-tobacco-production-order.index') }}">
                18: คำสั่งผลิตยาเส้นปรุงประจำปักษ์</a></li>

        <li><a href="{{ route('pm.fortnightly-raw-material-request.index') }}">
                19: ขอเบิกวัตถุดิบตามแผนรายปักษ์</a></li>

        <li><a href="{{ route('pm.machine-ingredient-requests.index') }}">
                20: ร้องขอวัตถุดิบที่หน้าเครื่องจักร</a></li>

        <li><a href="{{ route('pm.ingredient-requests.index') }}">
                21: รายการร้องขอวัตถุดิบ</a></li>

        <li><a href="{{ route('pm.ingredient-preparation-list.index') }}">
                22: รายการจัดเตรียมวัตถุดิบประจำวัน</a></li>

        <li><a href="{{ route('pm.transaction-pnk-check-material.index') }}">
                23: ตรวจสอบวัตถุดิบ</a></li>

        <li><a href="{{ route('pm.transaction-pnk-material-transfer.index') }}">
                24: รับโอนวัตถุดิบ</a></li>

        <li><a href="{{ route('pm.confirm-orders.index') }}">
                25: ยืนยันยอดผลผลิต,สูญเสีย</a></li>

        <li><a href="{{ route('pm.finished-products-storing-record.index') }}">
                26: บันทึกส่งสินค้าสำเร็จรูปเข้าคลัง</a></li>

        <li><a href="{{ route('pm.sample-cigarettes.index') }}">
                27: บันทึกบุหรี่ตัวอย่าง</a></li>

        <li><a href="{{ route('pm.free-products.index') }}">
                28: บันทึกบุหรี่แจกสูบ</a></li>

        <li><a href="{{ route('pm.ingredient-inventory.index') }}">
                29: รายการวัตถุดิบคงคลัง</a></li>

        <li><a href="{{ route('pm.confirm-production-yield-loss-for-tips.index') }}">
                30: ยืนยันยอดผลผลิต สูญเสีย (ก้นกรอง)</a></li>

        <li><a href="{{ route('pm.0031.index') }}">
                31: บันทึกผลผลิต,สูญเสีย</a></li>

        <li><a href="{{ route('pm.stamp-using.index') }}">
                32: บันทึกการใช้แสตมป์</a></li>

        <li><a href="{{ route('pm.confirm-stamp-using.index') }}">
                33: ยืนยันยอดใช้แสตมป์</a></li>

        <li><a href="{{ route('pm.planning-produce-monthly.index') }}">
                34: วางแผนผลิตสิ่งพิมพ์รายเดือน</a></li>

        <li><a href="{{ route('pm.receive-raw-material-transfer-at-temporary-storage.index') }}">
                35: รับโอนวัตถุดิบหน้าจุดพัก</a></li>

        <li><a href="{{ route('pm.close-product-order.index') }}">
                36: ปิดคำสั่งการผลิต</a></li>

        <li><a href="{{ route('pm.raw-material-preparation.index') }}">
                37: รายการจัดเตรียมวัตถุดิบ</a></li>

        <li><a href="{{ route('pm.production-order-list.index') }}">
                38: ตรวจสอบสถานะเพื่อปิดคำสั่งผลิต</a></li>

        <li><a href="{{ route('pm.additive-inventory-alert.index') }}">
                39: แจ้งเตือนปริมาณคงคลังสารปรุง</a></li>

        <li><a href="{{ route('pm.raw-material-inventory-alert.index') }}">
                40: แจ้งเตือนปริมาณคงคลังวัตถุดิบ</a></li>

        <li><a href="{{ route('pm.examine-casing-after-expiry-date.index') }}">
                41 ลงผลตรวจสอบสารปรุงหลังหมดอายุ</a></li>

        <li><a href="{{ route('pm.approval-casing-new-expiry-date.index') }}">
                42 อนุมัติการขอเปลี่ยนแปลงวันหมดอายุสารปรุง</a></li>

        <li><a href="{{ route('pm.0043.index') }}">
                43 โอนสินค้าสำเร็จรูป</a></li>

        <li><a href="{{ route('pm.0044.index') }}">
                44: วางแผนผลิตยาเส้นพองประจำปักษ์</a></li>

        <li><a href="{{ route('pm.0045.index') }}">
                45: ลงผลตรวจสอบหลังผลิต</a></li>

    </ul>
</li>

{{-- <li>
        <a href="{{ route('pm.settings.production-formula.index') }}">สูตรการผลิต</a>
</li> --}}

{{-- <li>
        <a href="{{ route('pm.settings.machine-relation.index') }}">ความสัมพันธ์ของชุดเครื่องจักร</a>
</li> --}}