<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TOAT - 02 - WEB_FUEL_ยอดจ่ายน้ำมันเชื้อเพลิงตามค่าใช้จ่าย_{{ date('dmY') }}</title>
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
        .table__detail {
            font-size: 16px;
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
        .font-bold {
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
            <th>รายงานสรุปยอดการใช้น้ำมันเชื้อเพลิงตามค่าใช้จ่าย</th>            
        </tr>
        <tr>
            <th>ประจำวันที่ {{ $fromDate ? parseToDateTh($fromDate) : '-'}} ถึง {{ $toDate ? parseToDateTh($toDate) : '-'}}</th>
        </tr>
    </table>
    @php
    @endphp

    <table class="table table-sm table__detail">
        <thead>
            <tr>
                <th rowspan="2" colspan="2" style="width: 5%;">รายงาน</th>
                <th rowspan="2">Lot Number</th>
                <th colspan="4">เบนซิน 95</th>
                <th colspan="4">น้ำมันดีเซลหมุนเร็ว</th>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($webFuelOils as $webFuelOil)
                <tr>
                    <td style="max-width: 100px; word-wrap: break-word;">{{$webFuelOil->account_code}}</td>
                    <td style="max-width: 80px; word-wrap: break-word;">{{$webFuelOil->description}}</td>
                    <td style="max-width: 100px; word-wrap: break-word;">{{$webFuelOil->lot_number}}</td>

                    <!-- น้ำมันเบนซิน -->
                    <td class="text-center">
                        {{ $webFuelOil->gasoline_quantity ? number_format($webFuelOil->gasoline_quantity, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->gasoline_amount ? number_format($webFuelOil->gasoline_amount, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->gasoline_tax_amount ? number_format($webFuelOil->gasoline_tax_amount, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->gasoline_total ? number_format($webFuelOil->gasoline_total, 2) : number_format(0, 2) }}
                    </td>

                    <!-- น้ำมันดีเซล -->
                    <td class="text-center">
                        {{ $webFuelOil->diesel_quantity ? number_format($webFuelOil->diesel_quantity, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->diesel_amount ? number_format($webFuelOil->diesel_amount, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->diesel_tax_amount ? number_format($webFuelOil->diesel_tax_amount, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->diesel_total ? number_format($webFuelOil->diesel_total, 2) : number_format(0, 2) }}
                    </td>

                    <!-- รวม -->
                    <td class="text-center">
                        {{ $webFuelOil->total_quantity ? number_format($webFuelOil->total_quantity, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->total_amount ? number_format($webFuelOil->total_amount, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->total_tax_amount ? number_format($webFuelOil->total_tax_amount, 2) : number_format(0, 2) }}
                    </td>
                    <td class="text-center">
                        {{ $webFuelOil->total ? number_format($webFuelOil->total, 2) : number_format(0, 2) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-center font-bold">*** รวม ***</td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_gasoline_quantity ? number_format($totalWebFuelOils->total_gasoline_quantity, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_gasoline_amount ? number_format($totalWebFuelOils->total_gasoline_amount, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_gasoline_tax_amount ? number_format($totalWebFuelOils->total_gasoline_tax_amount, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_gasoline ? number_format($totalWebFuelOils->total_gasoline, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_diesel_quantity ? number_format($totalWebFuelOils->total_diesel_quantity, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_diesel_amount ? number_format($totalWebFuelOils->total_diesel_amount, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_diesel_tax_amount ? number_format($totalWebFuelOils->total_diesel_tax_amount, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_diesel ? number_format($totalWebFuelOils->total_diesel, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_quantity ? number_format($totalWebFuelOils->total_quantity, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_amount ? number_format($totalWebFuelOils->total_amount, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total_tax_amount ? number_format($totalWebFuelOils->total_tax_amount, 2) : number_format(0, 2) }}
                </td>
                <td class="text-center font-bold">
                        {{ $totalWebFuelOils->total ? number_format($totalWebFuelOils->total, 2) : number_format(0, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>