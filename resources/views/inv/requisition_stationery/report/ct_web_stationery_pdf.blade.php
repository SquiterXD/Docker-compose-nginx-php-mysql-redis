<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TOAT - WEB_STA_CT_ใบเบิกพัสดุเครื่องเขียน(ร.ย.ส. 142) {{ date('dmY', strtotime($issueHeader->transaction_date)) }}</title>
        {{-- {{($issueHeader->transaction_date)->format('dmY')}} --}}
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
            font-size: 14pt;
            line-height: 0.85;
        }
        .page-break {
            page-break-after: always;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13pt;
            margin-bottom: 2em;
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
            text-align: left;
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
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-body">
            <table class="table-borderless">
                <tr>
                    <td>ย.ส.ท. 142</td>
                </tr>
                <tr>
                    <td>โปรดส่งไปยัง {{optional($issueHeader->coaDeptCode)->description}}</td>
                    <td></td>
                    <td class="text-right">เลขที่ </td>
                    <td>{{$issueHeader->issue_number}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right">วันที่</td>
                    <td>{{date('d-M-Y', strtotime($issueHeader->transaction_date))}}</td>
                    {{-- <td>{{($issueHeader->transaction_date)->format('d-M-Y')}}</td> --}}
                </tr>
            </table>

            <table class="table-borderless">
                <tr>
                    <th class="text-center">ลำดับ</th>
                    <th>รหัสพัสดุ</th>
                    <th>คำอธิบาย</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">หน่วยนับ</th>
                </tr>
                <tbody>
                    @foreach($issueHeader->details as $detail)
                        <tr>
                            <td class="text-center">{{$detail->line_no}}</td>
                            <td>{{optional($detail->inventoryItem)->segment1}}</td>
                            <td>{{optional($detail->inventoryItem)->description}}</td>
                            <td class="text-center">{{$detail->transaction_quantity}}</td>
                            <td class="text-center">{{optional($detail->inventoryItem)->primary_unit_of_measure}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table-borderless">
                <tr>
                    <td></td>
                    <td>ผู้บันทึก ...............................{{$user->name}}...............................</td>
                </tr>
                <tr>
                    <td>ผู้รักษาคลังวัสดุ ....................................................................................</td>
                    <td>(ลงชื่อ หัวหน้ากอง) ....................................................................................</td>
                </tr>
            </table>
            

        </div>
    </div>
</body>
</html>