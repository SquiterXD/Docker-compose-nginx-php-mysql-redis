<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TOAT - 05 - WEB_FUEL_รายงานยอดการใช้น้ำมันรถยนต์ส่วนกลาง_{{ date('dmY') }}</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        body {
            font-family: 'THSarabunNew';
            font-weight: normal;
            font-size: 11pt;
            line-height: 0.85;
        }
        .page-break {
            page-break-after: always;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13pt;
            margin-bottom: 20pt;
        }
        table th {
            font-weight: bold;
        }

        table td {
            vertical-align: top;
        }

        table.table-borderless td,
        table.table-borderless th {
            border: 0pt;
            padding: 0pt;
        }
        
        table td,
        table th {
            border: 0.3pt solid #000000;
            padding: 0pt 5pt 3pt 5pt;
            vertical-align: top;
        }

        tr.line-item td {
            border-top: 0pt;
            border-bottom: 0pt;
        }

        tr.line-item:last-child td {
            border-bottom: 0.3pt solid #000;
        }

        tr.last-row td {
            border-top: 0.3px solid #000;
            border-bottom: 0.3pt solid #000;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .text-blue {
            color: blue;
        }
        .font-weight-bold {
            font-weight: bold;
        }
        @page { margin: 100px 25px; }
        header { position: fixed; top: -80px; left: 0px; right: 0px; height: 50px; }
        header .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <header>
        <table class="table-borderless">
            <tr>
                <td style="width: 90%;">สั่งพิมพ์ : {{$username}}</td>
                <td>วันที่ : {{parseToDateTh(date('d/m/Y'))}}</td>
            </tr>
            <tr>
                <td></td>
                <td>เวลา : {{date('H:i')}}</td>
            </tr>
            <tr>
                <td></td>
                <td class="page-number">หน้า : </td>
            </tr>
        </table>
    </header>
    

    <table class="table-borderless">
        <tr class="align-center">
            <th>การยาสูบแห่งประเทศไทย</th>            
        </tr>
        <tr class="align-center">
            <th>รายงานยอดการใช้น้ำมันรถยนต์ส่วนกลาง</th>            
        </tr>
        <tr class="align-center">
            <th>{{ $oilType->item_description }}</th>            
        </tr>
        <tr>
            <th>ประจำวันที่ 
                <span>{{ $fromDate ? parseToDateTh($fromDate) : '-'}}</span> ถึง 
                <span>{{ $toDate ? parseToDateTh($toDate) : '-'}}</span>
            </th>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>ลำดับที่</th>
                <th>ประเภทรถ</th>
                <th>ทะเบียนรถ</th>
                <th>รายการ</th>
                <th>โควต้า</th>
                <th>จำนวน(ใช้)</th>
                <th>จำนวน(คงเหลือ)</th>
                <th>เกินโควต้า</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carInfos as $key=>$carInfo)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td>{{ $carInfo->car_group_desc }}</td>
                    <td>{{ $carInfo->car_license_plate }}</td>
                    <td>{{ $carInfo->gl_alias_name }}</td>
                    <td class="text-center">{{ $carInfo->quota_per_month }}</td>
                    <td class="text-center">{{ $carInfo->sum_quantity }}</td>
                    <td class="text-center">{{ intval($carInfo->quota_per_month) - intval($carInfo->sum_quantity) }}</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                </tr>
            @endforeach
            <tr class="font-weight-bold text-center">
                <td colspan="4">*** รวมทั้งหมด ***</td>
                <td>{{ $totalCarInfo->total_quota_per_month }}</td>
                <td>{{ $totalCarInfo->total_quantity }}</td>
                <td>{{ $totalCarInfo->total_quota_per_month - $totalCarInfo->total_quantity }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table class="table-borderless">
        <tr>
            <th class="text-left" style="width: 60%; padding:10pt 0pt 10pt 100pt;">ผู้จัดทำ__________________________________</th>
            <th class="text-left" style="padding:10pt 0pt 10pt 0pt;">หัวหน้ากองขนส่ง__________________________________</th>
        </tr>
        <tr>
            <th class="text-left" style="padding:10pt 0pt 10pt 100pt;">ผู้ตรวจทาน_______________________________</th>
            <th class="text-left" style="padding:10pt 0pt 10pt 0pt;">หัวหน้ากองบัญชีประมวล____________________________</th>
        </tr>
    </table>
</body>
</html>