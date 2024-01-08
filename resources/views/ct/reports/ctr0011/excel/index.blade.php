<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

</head>

<body>
    @php
        $styleTh = 'border:  1px solid black; line-height: 100px';
        $styleFont16 = 'border:  1px solid black; font-size: 16px';
        $styleFont14 = 'border:  1px solid black; font-size: 14px';
        $font18 = 'font-size: 18px';
        $font16 = 'font-size: 16px';
        $font14 = 'font-size: 14px';
        $styleBorderLRFont14 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 14px';
        $styleBorderLRFont16 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 16px';
        $styleBorderLRFTont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 16px';
        $styleBorderLRBTFont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $styleBorderTBFont16 = 'border-top:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $uData = [];
        // dd('xxxxxxxxxxxxxxxxxxxxxxxxx');
    @endphp

    <table>
        <thead>
            <tr>
                <th rowspan="2">หน่วยงาน</th>
                <th rowspan="2">ผลิตภัณฑ์</th>
                <th rowspan="2">รายละเอียด</th>
                <th rowspan="2">เลขที่คำสั่งผลิต</th>
                <th rowspan="2">ขั้นตอน</th>
                <th rowspan="2">Org.</th>
                <th colspan="6">ใบยาระหว่างผลิต</th>
                <th rowspan="2">รวม</th>
                <th rowspan="2">เฉลี่ยต่อหน่วย</th>
            </tr>
            <tr>
                <th>ผลผลิตที่ได้</th>
                <th>ปริมาณวัตถุดิบ</th>
                <th>วัตถุดิบ</th>
                <th>ค่าแรง</th>
                <th>ค่าใช้จ่ายผันแปร</th>
                <th>ค่าใช้จ่ายคงที่</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
