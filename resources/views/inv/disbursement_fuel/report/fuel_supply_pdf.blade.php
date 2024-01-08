<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TOAT - 01 - WEB_FUEL_ยอดจ่ายน้ำมันเชื้อเพลิง_{{$currentDate}}</title>
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
    </style>
</head>
<body>
    <header>
        <table class="table-borderless">
            <tr class="align-center">
                <th>รายงาน ยอดจ่ายน้ำมันเชื้อเพลิง</th>            
            </tr>
            <tr>
                <th>ประจำวันที่ 
                    <span>{{ $startDate ? parseToDateTh($startDate) : '-'}}</span> ถึง 
                    <span>{{ $endDate ? parseToDateTh($endDate) : '-'}}</span>
                </th>
            </tr>
        </table>
    </header>

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">ชนิดน้ำมัน</th>
                <th colspan="2">น้ำมันเบนซิน 95</th>
                <th colspan="2">น้ำมันดีเซลหมุนเร็ว</th>
            </tr>
            <tr>
                <th>จำนวนลิตร</th>
                <th>จำนวนใบเบิก</th>
                <th>จำนวนลิตร</th>
                <th>จำนวนใบเบิก</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1. น้ำมันส่วนกลาง</td>
                <td class="text-center">{{$webFuelOil->sum_gasoline_quantity ? $webFuelOil->sum_gasoline_quantity : "-"}}</td>
                <td class="text-center">{{$webFuelOil->count_gasoline_transaction != 0 ? $webFuelOil->count_gasoline_transaction : "-"}}</td>
                <td class="text-center">{{$webFuelOil->sum_diesel_quantity ? $webFuelOil->sum_diesel_quantity : "-"}}</td>
                <td class="text-center">{{$webFuelOil->count_diesel_transaction != 0 ? $webFuelOil->count_diesel_transaction : "-"}}</td>
            </tr>
            <tr>
                <td>2. น้ำมันส่วนกลาง (+ VAT)</td>
                <td class="text-center">{{$webFuelOil->sum_gasoline_vat_quantity ? $webFuelOil->sum_gasoline_vat_quantity : "-"}}</td>
                <td class="text-center">{{$webFuelOil->count_gasoline_vat_transaction != 0 ? $webFuelOil->count_gasoline_vat_transaction : "-"}}</td>
                <td class="text-center">{{$webFuelOil->sum_diesel_vat_quantity ? $webFuelOil->sum_diesel_vat_quantity : "-"}}</td>
                <td class="text-center">{{$webFuelOil->count_diesel_vat_transaction != 0 ? $webFuelOil->count_diesel_vat_transaction : "-"}}</td>
            </tr>
            <tr>
                <td>3. น้ำมันสวัสดิการพนักงาน</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
            </tr>
            <tr>
                <td class="text-center"><b>รวม</b></td>
                <td class="text-center">{{$webFuelOil->total_gasoline_quantity}}</td>
                <td class="text-center">{{$webFuelOil->total_gasoline_transaction}}</td>
                <td class="text-center">{{$webFuelOil->total_diesel_quantity}}</td>
                <td class="text-center">{{$webFuelOil->total_diesel_transaction}}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>