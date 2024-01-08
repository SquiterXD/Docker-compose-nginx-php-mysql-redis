<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>ใบโอนวัตถุดิบ/วัสดุเพื่อใช้ในการผลิต</title> --}}

    <link rel="stylesheet" href="{{ asset('css/report.css') }}">

    <style type="text/css">
        body{
            font-size: 10px;
        }
    </style>

</head>
<body style=" border: 0px solid #000; margin: 0px;">
    <table class="" style="width: 100%; border: 0px solid #000; padding-top: 5px;">
        <thead>
            <tr>
                <th style="width: 100px; text-align: left; border-top: 1px solid #000; border-bottom: 1px solid #000;" >รห้สสินค้า</th>
                <th style="text-align: left">รายละเอียด</th>
                <th style="width: 100px; text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000;">จำนวน</th>
                <th style="width: 100px; text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000;">หน่วย</th>
                <th style="width: 10px; text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000;"></th>
                <th style="width: 150px; text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lines as $line)
            <tr>
                <td style="text-align: left;">
                    {{ $line->item_number }}
                </td>
                <td style="text-align: left">{{ $line->item_desc }}</td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;">{{ $line->unit_of_measure }}</td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;">{{ $line->transaction_qty_format }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
