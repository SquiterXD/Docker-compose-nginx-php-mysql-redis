<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ใบโอนวัตถุดิบ/วัสดุเพื่อใช้ในการผลิต</title>

    <link rel="stylesheet" href="{{ asset('css/report.css') }}">

    <style type="text/css">
        body{
            font-size: 10px;
        }
    </style>

</head>
<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 30px;">ลำดับ</th>
                                <th style="width: 100px; text-align: center" >รหัสวัตถุดิบ</th>
                                <th style="text-align: left">รายการ</th>
                                <th style="width: 100px; text-align: right; ">LOT. No.</th>
                                <th style="width: 130px; text-align: right;">ปริมาณหลัก</th>
                                <th style="width: 100px; text-align: right;">หน่วยหลัก</th>
                                {{-- <th style="min-width: 10%">@</th> --}}
                                <th style="width: 100px; text-align: right;">ปริมาณที่เบิก</th>
                                <th style="width: 130px; text-align: right;">หน่วยนับ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($ptpmItems as $item)
                            <tr height="22">
                                <td style="text-align: center">{{ ++$i }}</td>
                                <td style="text-align: center">{{ $item->item_number }}</td>
                                <td>{{ $item->item_desc }}</td>
                                <td style="text-align: right">{{ $item->lot_number }}</td>
                                <td style="text-align: right">{{ number_format($item->transaction_quantity, 2) }}</td>
                                <td style="text-align: right">{{ $item->unit_of_measure1 }}</td>
                                {{-- <td style="text-align: center"></td> --}}
                                <td style="text-align: right">{{ number_format($item->secondary_qty, 2) }}</td>
                                <td style="text-align: right">{{ $item->unit_of_measure2 }}</td>
                            </tr>
                            @if ($item->remark_msg)
                                <tr>
                                    <td style="text-align: center"></td>
                                    <td style="text-align: center"></td>
                                    <td style="text-align: left" colspan="6">
                                        หมายเหตุ {{ $item->remark_msg }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row" style="margin-top: 10px">
                <div class="col-lg-12 pb-5" style="text-align: center">จบรายงาน</div>
            </div>
        </div>
    </div>
</body>
</html>
