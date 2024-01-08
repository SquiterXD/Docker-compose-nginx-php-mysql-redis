<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TOAT - 03 - WEB_FUEL_รายงานสรุปยอดจ่ายน้ำมันตามประเภท_{{ date('dmY') }}</title>
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
            <th>รายงานสรุปยอดการใช้<span>{{ $carFuel->first()->item_description }}</span> ตามประเภทของการใช้</th>            
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
                <th rowspan="2">รายการ</th>
                <th colspan="4">สวัสดิการพนักงาน</th>
                <th colspan="4">ใช้ในกิจการ(ขอคืนภาษีไม่ได้)</th>
                <th colspan="4">ใช้ในกิจการ</th>
                <th colspan="4">รวม</th>
            </tr>
            <tr>
                <th>จำนวน</th>
                <th>มูลค่าสินค้า</th>
                <th>ภาษี</th>
                <th>รวม</th>

                <th>จำนวน</th>
                <th>มูลค่าสินค้า</th>
                <th>ภาษี</th>
                <th>รวม</th>

                <th>จำนวน</th>
                <th>มูลค่าสินค้า</th>
                <th>ภาษี</th>
                <th>รวม</th>

                <th>จำนวน</th>
                <th>มูลค่าสินค้า</th>
                <th>ภาษี</th>
                <th>รวม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($webFuels as $webFuel)
                <tr>
                    <td>{{ $webFuel->description }}</td>

                    <td class="text-center">0.00</td>
                    <td class="text-center">0.00</td>
                    <td class="text-center">0.00</td>
                    <td class="text-center">0.00</td>

                    <td class="text-center">{{ number_format($webFuel->quantity_n, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->amount_n, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->tax_amount_n, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->total_amount_n, 2) }}</td>

                    <td class="text-center">{{ number_format($webFuel->quantity_y, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->amount_y, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->tax_amount_y, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->total_amount_y, 2) }}</td>

                    <td class="text-center">{{ number_format($webFuel->quantity_n + $webFuel->quantity_y, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->amount_n + $webFuel->amount_y, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->tax_amount_n + $webFuel->tax_amount_y, 2) }}</td>
                    <td class="text-center">{{ number_format($webFuel->total_amount_n + $webFuel->total_amount_y, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>