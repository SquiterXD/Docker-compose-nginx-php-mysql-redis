<style type="text/css">
    @font-face{
        font-family: 'SarabunSans';
        font-style: 'normal';
        src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
    }
    .page {
        overflow: hidden;
        page-break-after: always;
        position: relative;
        min-height: 729px;
    }
    .page:last-of-type {
        page-break-after: auto
    }
    body {
        font-family: 'SarabunSans';
        font-size: 12px;
    }
    .text-center {
        text-align: center;
    }
    .alTop {
        vertical-align: top;
        margin-top: 5px;
    }
    .alRight {
        text-align: right;
    }
    .d-inblock {
        display: inline-block;
    }
    .b-t {
        border-top: 1px inset black;
        border-collapse: collapse;
        border-spacing: 0;
    }
    .b-r {
        border-right: 1px solid #000;
        border-collapse: collapse;
        border-spacing: 0;
    }
    .b-l {
        border-left: 1px solid #000;
        border-collapse: collapse;
        border-spacing: 0;
    }
    .b-b {
        border-bottom: 1px solid #000;
        border-collapse: collapse;
        border-spacing: 0;
    }
    .pt {
        padding-top: 3px;
    }
    .pb {
        padding-bottom: 3px;
    }
    .pl {
        padding-left: 3px;
    }
    .table-content {
        border-collapse: collapse;
        font-size: 10px;
        page-break-inside:auto;
    }
    .table-header {
        text-align: center;
    }
    .table-content tr {
        page-break-inside:avoid;
        page-break-after:auto;
    }
    .table-main {
        border-collapse: collapse;
        font-size: 10px;
        page-break-inside:auto;
    }
    .table-main thead tr td {
        text-align: center;
    }
    .table-main tr {
        page-break-inside:avoid;
        page-break-after:auto;
    }

    .table-footer {
        text-align: center;
        margin-top: 15px;
        font-family: 'SarabunSans';
        font-size: 10px;
    }
</style>
@foreach ($requestEquip as $data)
    <div class="page">
        <div style="position: absolute; right: 0">หน้า {{$loop->index +1}}</div>
        <div class="text-center" style="padding-top: 5px;">การยาสูบแห่งประเทศไทย</div>
        <div class="text-center" style="margin-top: 5px"> ใบโอนย้ายพัสดุ</div>
        <div style="position: absolute; right: 0; top: 28px; width: 156px;">เลขที่ &nbsp;&nbsp;&nbsp; {{$data["data"]->request_equip_no}}</div>
        <div style="position: absolute; right: 0; top: 28px;">________________________________</div>
        <div style="position: absolute; right: 130px; top: 49px;">วันที่</div>
        @if(isset($data["data"]->send_date))
        <div style="position: absolute; right: 52px; top: 49px;">{{date_format(date_create($data["data"]->send_date), "j-M-Y")}}</div>
        @endif
        <div style="position: absolute; right: 0; top: 48px;">________________________________</div>
        <div style="text-align: left; margin-top: 15px;">ชื่อหน่วยงาน :&nbsp;&nbsp; {{$data["data"]->department_code}} - {{$data["data"]->department_desc}} ({{$data["data"]->to_subinventory}})</div>
        <div style="text-align: left; margin-top: 5px;">มีความประสงค์จะขอโอนพัสดุตามรายการด้านล่าง"เพื่อนำมาเก็บไว้ที่คลังของหน่วยงาน" ไว้สำหรับใช้งานภายในหน่วยงานต่อไป</div>
        <div style="text-align: left; margin-top: 5px; margin-bottom: 15px;">โปรดโอนพัสดุตามรายละเอียดดังนี้</div>

        <table class="table-content">
            <thead>
                <tr class="b-t b-r b-l b-b">
                    <td class="b-r text-center" rowspan="2" style="width: 90px;">รหัสพัสดุ</td>
                    <td class="b-r text-center" rowspan="2" style="width: 220px;">รายการ</td>
                    <td class="b-r text-center" colspan="2">โอนจาก</td>
                    <td class="b-r text-center" colspan="2">ไปยัง</td>
                    <td class="b-r text-center" rowspan="2" style="width: 50px;">หน่วยนับ<br>(UOM)</td>
                    <td class="b-r text-center" rowspan="2" style="width: 50px;">จำนวน</td>
                    <td class="text-center" rowspan="2" style="width: 190;">หมายเหตุ</td>
                </tr>
                <tr class="b-r b-l b-b">
                    <td class="b-r text-center" style="width: 100px;">คลัง<br>(Subinventory)</td>
                    <td class="b-r text-center" style="width: 100px;">สถานที่เก็บ<br>(Locator)</td>
                    <td class="b-r text-center" style="width: 100px;">คลัง</td>
                    <td class="text-center" style="width: 100px;">สถานที่เก็บ</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data["items"] as $item)
                    @if(isset($item->item_code))
                        <tr class="b-r b-l b-b">
                            <td class="text-center b-r">{{$item->item_code}}</td>
                            <td class="b-r pl">{{$item->item_description}}</td>
                            <td class="b-r text-center"></td>
                            <td class="b-r text-center"></td>
                            <td class="b-r text-center">{{$data["data"]->to_subinventory}}</td>
                            <td class="b-r text-center">{{$data["data"]->to_locator_code}}</td>
                            <td class="b-r text-center">{{$item->item_primary_uom_code}}</td>
                            <td class="b-r text-center">{{$item->required_quantity}}</td>
                            <td class="b-r pl">{{$item->remark}}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <div style="position: absolute; bottom: 0;">
            <div style="height: 36px;">หมายเหตุ : </div>
            <table class="table-content">
                <thead>
                    <tr class="text-center b-t b-r b-l b-b">
                        <td class="b-r pt pb" style="width: 300px;">1.ผู้จัดทำ</td>
                        <td class="b-r" style="width: 350px;">2.ผู้มีอำนาจอนุมัติของ"หน่วยงานที่ต้องการพัสดุ"</td>
                        <td style="width: 365px;">3.ผู้มีอำนาจอนุมัติของ"หน่วยงานเจ้าของพัสดุ"</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="b-t b-l b-b">
                        <td class="b-r">
                            <div class="pt pb text-center" style="padding-left: 10px;">เรียน..............................................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">......................................................................</div>
                            <div class="pt pb text-center">ลงชื่อ..............................................</div>
                            <div class="pt pb text-center">(..............................................) </div>
                            <div class="pt pb text-center">ตำแหน่ง......................................</div>
                            <div class="pt pb text-center">____/____/_____</div>
                        </td>
                        <td class="b-r">
                            <div class="pt pb text-center" style="padding-left: 10px;">
                                <div class="d-inblock b-t b-r b-l b-b" style="width: 10px; height: 10px; margin-right: 5px;"></div>
                                <div class="d-inblock" style="margin-right: 25px;">อนุมัติ</div>
                                <div class="d-inblock b-t b-r b-l b-b" style="width: 10px; height: 10px; margin-right: 5px;"></div>
                                <div class="d-inblock">ไม่อนุมัติ</div>
                            </div>
                            <div class="pt pb text-center" style="padding-left: 10px;">......................................................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">......................................................................</div>
                            <div class="pt pb text-center">ลงชื่อ..............................................</div>
                            <div class="pt pb text-center">(..............................................) </div>
                            <div class="pt pb text-center">ตำแหน่ง......................................</div>
                            <div class="pt pb text-center">____/____/_____</div>
                        </td>
                        <td class="b-r">
                            <div class="pt pb text-center" style="padding-left: 10px;">
                                <div class="d-inblock b-t b-r b-l b-b" style="width: 10px; height: 10px; margin-right: 5px;"></div>
                                <div class="d-inblock" style="margin-right: 25px;">อนุมัติ</div>
                                <div class="d-inblock b-t b-r b-l b-b" style="width: 10px; height: 10px; margin-right: 5px;"></div>
                                <div class="d-inblock">ไม่อนุมัติ</div>
                            </div>
                            <div class="pt pb text-center" style="padding-left: 10px;">......................................................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">......................................................................</div>
                            <div class="pt pb text-center">ลงชื่อ..............................................</div>
                            <div class="pt pb text-center">(..............................................) </div>
                            <div class="pt pb text-center">ตำแหน่ง......................................</div>
                            <div class="pt pb text-center">____/____/_____</div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table-content">
                <thead>
                    <tr class="text-center b-r b-l b-b">
                        <td class="b-r pt pb" style="width: 300px;">4.ผู้จ่ายพัสดุ</td>
                        <td class="b-r" style="width: 250px;">5.ผู้บันทึกเข้าระบบสินค้าคงคลัง</td>
                        <td class="b-r" style="width: 220px;">6.ผู้ขนส่ง</td>
                        <td class="b-r" style="width: 242px;">7.ผู้รับพัสดุ</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="b-t b-l b-b">
                        <td class="b-r">
                            <div class="pt pb text-center" style="padding-left: 10px;">เรียน..............................................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">
                                <div class="d-inblock b-t b-r b-l b-b" style="width: 10px; height: 10px; margin-right: 5px;"></div>
                                <div class="d-inblock" style="">ส่งมอบพัสดุแล้ว.....................................</div>
                            </div>
                            <div class="pt pb" style="padding-left: 15px;">
                                <div class="d-inblock b-t b-r b-l b-b" style="width: 10px; height: 10px; margin-right: 5px;"></div>
                                <div class="d-inblock" style="">บันทึก Bin Card แล้ว</div>
                            </div>
                            <div class="pt pb text-center">ลงชื่อ..............................................</div>
                            <div class="pt pb text-center">(..............................................) </div>
                            <div class="pt pb text-center">ตำแหน่ง......................................</div>
                            <div class="pt pb text-center">____/____/_____</div>
                        </td>
                        <td class="b-r">
                            <div class="pt pb text-center" style="padding-left: 10px;">เรียน.............................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">.....................................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">.....................................................</div>
                            <div class="pt pb text-center">ลงชื่อ..............................................</div>
                            <div class="pt pb text-center">(..............................................) </div>
                            <div class="pt pb text-center">ตำแหน่ง......................................</div>
                            <div class="pt pb text-center">____/____/_____</div>
                        </td>
                        <td class="b-r">
                            <div class="pt pb text-center" style="padding-left: 10px;">เรียน.............................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">.....................................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">.....................................................</div>
                            <div class="pt pb text-center">ลงชื่อ..............................................</div>
                            <div class="pt pb text-center">(..............................................) </div>
                            <div class="pt pb text-center">ตำแหน่ง......................................</div>
                            <div class="pt pb text-center">____/____/_____</div>
                        </td>
                        <td class="b-r">
                            <div class="pt pb text-center" style="padding-left: 10px;">เรียน........................................................</div>
                            <div class="pt pb text-center" style="padding-left: 10px;">
                                <div class="d-inblock b-t b-r b-l b-b" style="width: 10px; height: 10px; margin-right: 5px;"></div>
                                <div class="d-inblock" style="">ส่งมอบพัสดุแล้ว...............................</div>
                            </div>
                            <div class="pt pb" style="padding-left: 17px;">
                                <div class="d-inblock b-t b-r b-l b-b" style="width: 10px; height: 10px; margin-right: 5px;"></div>
                                <div class="d-inblock" style="">บันทึก Bin Card แล้ว</div>
                            </div>
                            <div class="pt pb text-center">ลงชื่อ..............................................</div>
                            <div class="pt pb text-center">(..............................................) </div>
                            <div class="pt pb text-center">ตำแหน่ง......................................</div>
                            <div class="pt pb text-center">____/____/_____</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endforeach
