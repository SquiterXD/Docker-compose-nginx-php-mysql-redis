<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style type="text/css">
        @font-face{
            font-family: 'SarabunSans';
            font-style: 'normal';
            src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
        }

        body {
            font-family: 'SarabunSans';
            font-size: 12px;
            padding-bottom: 100px;
        }

        .b-r {
            border-right: 1px solid #000;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .pt {
            padding-top: 3px;
        }

        .pb {
            padding-bottom: 3px;
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

        .table-content {
            border-collapse: collapse;
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div style="position: absolute;" >
        <div style="height: 35px;">หมายเหตุ : </div>
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
</body>
</html>