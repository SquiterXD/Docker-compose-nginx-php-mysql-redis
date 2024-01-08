<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TOAT - WEB_STA_ประวัติสั่งซื้อย้อนหลัง_{{$currentDate}}</title>
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
            padding: 0pt 5pt 5pt 5pt;
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
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <table class="table-borderless">
        <tr class="align-center">
            <th>รายงานประวัติสั่งซื้อย้อนหลัง</th>            
        </tr>
        <tr>
            <th>
                ตั้งแต่วันที่ 
                @if($startDate) 
                    {{ $startDate }} 
                @else 
                    - 
                @endif 
                
                ถึงวันที่ 
                @if($startDate) 
                    {{ $endDate }} 
                @else 
                    - 
                @endif 
            </th>
        </tr>
    </table>
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center">กอง/ฝ่าย</th>
            <th class="text-center">เลขที่ PO</th>
            <th class="text-center">วันที่สร้าง PO</th>
            <th class="text-center">รหัสสินค้า</th>
            <th class="text-center">คำอธิบายสินค้า</th>
            <th class="text-center">จำนวนที่ซื้อ</th>
            <th class="text-center">ราคาต่อหน่วย</th>
            <th class="text-center">ยอดเงิน</th>
        </tr>
        <tbody>
            @foreach ($poDistributionsAll as $poDistribution)
                <tr>
                    <td>{{ optional($poDistribution->perPeopleF)->full_name }}</td>
                    <td>{{ optional($poDistribution->poHeadersAll)->segment1 }}</td>
                    <td>{{ optional($poDistribution->poHeadersAll)->creation_date->format('d/m/Y') }}</td>
                    <td>{{ optional(optional($poDistribution->poLinesAll)->systemItem)->segment1 }}</td>
                    <td>{{ optional($poDistribution->poLinesAll)->item_description }}</td>
                    <td class="text-right">{{ optional($poDistribution->poLinesAll)->quantity }} {{ optional($poDistribution->poLinesAll)->unit_meas_lookup_code }}</td>
                    <td class="text-right">{{ optional($poDistribution->poLinesAll)->unit_price }}</td>
                    <td class="text-right">{{ $poDistribution->amount }} {{ optional($poDistribution->poHeadersAll)->currency_code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>