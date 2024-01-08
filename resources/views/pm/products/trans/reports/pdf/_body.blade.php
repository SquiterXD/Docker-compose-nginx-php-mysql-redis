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
            font-size: 12px;
        }
        table {
            border-collapse: collapse !important;
        }
    </style>

</head>
@php
    $borderB = ' border-bottom: 1px solid #000; ';
    $borderTB = ' border-bottom: 1px solid #000; border-top: 1px solid #000; ';
@endphp
<body style="margin: 0px;">
    <table class="" style="width: 100%; padding-top: 5px;">
        <thead>
            <tr>
                <th style="{{ $borderTB }} width: 100px; text-align: left; " >รห้สสินค้า</th>
                <th style="text-align: left">รายละเอียด</th>
                <th style="{{ $borderTB }} width: 150px; text-align: left; ">Lot</th>
                <th style="{{ $borderTB }} width: 100px; text-align: right; ">จำนวน</th>
                <th style="{{ $borderTB }} width: 100px; text-align: center; ">หน่วย</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lines->groupBy('item_number') as $lines)
                @foreach ($lines as $key => $line)
                    <tr>
                        <td style="text-align: left;">
                            @if ($key == 0)
                                {{ $line->item_number }}
                            @endif
                        </td>
                        <td style="text-align: left">
                            @if ($key == 0)
                                {{ $line->item_desc }}
                            @endif
                        </td>
                        <td style="text-align: left;">{{ $line->lot_number }}</td>
                        <td style="text-align: right;">{{ number_format($line->transaction_qty, 2) }}</td>
                        <td style="text-align: center;">{{ $line->unit_of_measure }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td valign="top" height="25" style="padding-top: 2px; text-align: right; " colspan="1"></td>
                    <td valign="top" height="25" style="padding-top: 2px; text-align: left; " colspan="2"><b>จำนวนรวม</b></td>
                    <td valign="top" height="25" style="padding-top: 2px; text-align: right; " ><b>{{ number_format($lines->sum('transaction_qty') ?? 0, 2) }}</b></td>
                    <td valign="top" height="25" style="padding-top: 2px; text-align: center; "><b>{{ $lines->first()->unit_of_measure }}</b></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
