<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TOAT - WEB_STA_สรุปเบิกจ่าย_{{$currentDate}}</title>
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
            page-break-after:auto
        }
        td    { 
            page-break-inside:avoid; 
            page-break-after:auto;
        }
        thead { 
            display:table-header-group;
        }
        tr {
            page-break-inside:avoid;
            page-break-after:auto;
        }
        table th,
        .text-bold {
            font-weight: bold;
        }

        table td {
            vertical-align: middle;
        }

        table.table-borderless td,
        table.table-borderless th {
            border: 0pt;
            padding: 0pt 5pt 5pt 5pt;
        }

        table td,
        table th {
            border: 0.3pt solid #000000;
            padding: 0pt 5pt 5pt 5pt;
            vertical-align: middle;
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
        @page { margin: 100px 25px; }
        header { position: fixed; top: -80px; left: 0px; right: 0px; height: 50px; }
        header .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <header>
        <div class="text-right">
            <span class="page-number">หน้า </span>
        </div>

        <table class="table-borderless">
            <tr class="align-center">
                <th>รายงาน สรุปการเบิกจ่ายเครื่องเขียน/เบ็ดเตล็ด (ตามราย Item)</th>            
            </tr>
            <tr>
                <th>ตั้งแต่วันที่ {{ $startDate }} ถึงวันที่ {{ $endDate }}</th>
            </tr>
        </table>
    </header>
    
    <table>
        <thead>
            <tr>
                <th class="th-header text-center">วันที่เบิก</th>
                <th class="th-header text-center">รหัสสินค้า</th>
                <th class="th-header text-center">คำอธิบายสินค้า</th>
                <th class="th-header text-center">จำนวนที่เบิก</th>
                <th class="th-header text-center">ราคาต่อหน่วย</th>
                <th class="th-header text-center">ยอดเงิน</th>
                <th class="th-header text-center">กอง/ฝ่าย</th>
            </tr>
        </thead>
        
        <tbody>
            @php
                $currentItemId = $issueHeaders->isNotEmpty() ? $issueHeaders->first()->segment1 : null;
                $currentUnitOfMeasure = $issueHeaders->isNotEmpty() ? $issueHeaders->first()->primary_unit_of_measure : null;
                $sumQuantity = 0;
                $sumTotalCost = 0;
            @endphp

            @foreach ($issueHeaders as $issueHeader)
                @if ($currentItemId == $issueHeader->segment1)
                    <tr>
                        <td>{{ $issueHeader->transaction_date }}</td>
                        <td>{{ $issueHeader->segment1 }}</td>
                        <td>{{ $issueHeader->item_description }}</td>
                        <td class="text-right">
                            @if ($issueHeader->issue_status == 'APPROVED')
                                {{ $issueHeader->transaction_quantity }} {{ $issueHeader->primary_unit_of_measure }}
                            @endif
                            @if ($issueHeader->issue_status == 'RETURN')
                                - {{ $issueHeader->transaction_quantity }} {{ $issueHeader->primary_unit_of_measure }}
                            @endif
                            
                        </td>
                        <td class="text-right">{{ number_format($issueHeader->transaction_cost, 2) }}</td>
                        <td class="text-right">
                            @if ($issueHeader->issue_status == 'APPROVED')
                                {{ number_format(($issueHeader->transaction_cost * $issueHeader->transaction_quantity), 2) }}
                            @endif
                            @if ($issueHeader->issue_status == 'RETURN')
                                - {{ number_format(($issueHeader->transaction_cost * $issueHeader->transaction_quantity), 2) }}
                            @endif
                        </td>
                        <td>{{ $issueHeader->department_code }} - {{ $issueHeader->description }}</td>
                    </tr>
                @endif

                @if ($currentItemId != $issueHeader->segment1)
                    <tr class="text-bold">
                        <td></td>
                        <td></td>
                        <td class="text-right">ยอดรวมทั้งสิ้น</td>
                        <td class="text-right">{{ $sumQuantity }} {{ $currentUnitOfMeasure }}</td>
                        <td></td>
                        <td class="text-right">{{ number_format($sumTotalCost, 2) }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>{{ $issueHeader->transaction_date }}</td>
                        <td>{{ $issueHeader->segment1 }}</td>
                        <td>{{ $issueHeader->item_description }}</td>
                        <td class="text-right">
                            @if ($issueHeader->issue_status == 'APPROVED')
                                {{ $issueHeader->transaction_quantity }} {{ $issueHeader->primary_unit_of_measure }}
                            @endif
                            @if ($issueHeader->issue_status == 'RETURN')
                                - {{ $issueHeader->transaction_quantity }} {{ $issueHeader->primary_unit_of_measure }}
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($issueHeader->transaction_cost, 2) }}</td>
                        <td class="text-right">
                            @if ($issueHeader->issue_status == 'APPROVED')
                                {{ number_format(($issueHeader->transaction_cost * $issueHeader->transaction_quantity), 2) }}
                            @endif
                            @if ($issueHeader->issue_status == 'RETURN')
                                - {{ number_format(($issueHeader->transaction_cost * $issueHeader->transaction_quantity), 2) }}
                            @endif
                        </td>
                        <td>{{ $issueHeader->department_code }} - {{ $issueHeader->description }}</td>
                    </tr>
                    
                    @php
                        $currentItemId = $issueHeader->segment1;
                        $currentUnitOfMeasure = $issueHeader->primary_unit_of_measure;
                        $sumQuantity = 0;
                        $sumTotalCost = 0;
                    @endphp
                @endif

                @php
                    if ($issueHeader->issue_status == 'APPROVED') {
                        $sumQuantity = $sumQuantity + ($issueHeader->transaction_quantity);
                        $sumTotalCost = $sumTotalCost + (($issueHeader->transaction_cost)*($issueHeader->transaction_quantity));
                    }
                    if ($issueHeader->issue_status == 'RETURN') {
                        $sumQuantity = $sumQuantity - ($issueHeader->transaction_quantity);
                        $sumTotalCost = $sumTotalCost - (($issueHeader->transaction_cost)*($issueHeader->transaction_quantity));
                    }
                    
                @endphp

                @if ($loop->last)
                    <tr class="text-bold">
                        <td></td>
                        <td></td>
                        <td class="text-right">ยอดรวมทั้งสิ้น</td>
                        <td class="text-right">{{ $sumQuantity }} {{ $currentUnitOfMeasure }}</td>
                        <td></td>
                        <td class="text-right">{{ number_format($sumTotalCost, 2) }}</td>
                        <td></td>
                    </tr>
                @endif

            @endforeach
        </tbody>
    </table>
</body>
</html>