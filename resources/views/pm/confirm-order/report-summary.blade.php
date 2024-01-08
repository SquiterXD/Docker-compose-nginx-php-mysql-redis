<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test PDF</title>

    <link rel="stylesheet" href="{{ asset('css/report.css') }}">

    <style type="text/css">
        body{
            font-size: 11px;
        }
    </style>

</head>
<body>
    <div class="row">
        <div class="col-lg-12 header">
            <div class="row">
                <div class="table-responsive">
                    <table class="table" style="width: 100%">
                        <thead>
                            <tr style="text-align: center">
                                <th>ลำดับ</th>
                                <th>คำสั่งผลิตเลขที่</th>
                                <th>รห้สสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>ปริมาณ</th>
                                <th>หน่วยนับ</th>
                                <th>วันที่ผลิต</th>
                                <th>วันที่เริ่ม</th>
                                <th>วันที่เสร็จ</th>
                                {{-- <th>ผลิตเพื่อ</th> --}}
                                <th>ตามแผน</th>
                                <th>สถานะคำสั่งผลิต</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($ptpmItems as $item)
                                <tr>
                                    <td style="text-align: center">{{ ++$i }}</td>
                                    <td>{{ $item->batch_no }}</td>
                                    <td>{{ $item->item_no }}</td>
                                    <td>{{ $item->item_desc }}</td>
                                    <td style="text-align: right">{{ number_format($item->plan_qty,3) }}</td>
                                    <td>{{ $item->unit_of_measure }}</td>
                                    
                                    {{-- <td>{{ Carbon\Carbon::parse($item->gmeBatchHeader->plan_start_date)->addYear('543')->format('d/m/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($item->gmeBatchHeader->actual_start_date)->addYear('543')->format('d/m/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($item->gmeBatchHeader->plan_cmplt_date)->addYear('543')->format('d/m/Y') }}</td> --}}

                                    <td>{{ Carbon\Carbon::parse($item->actual_start_date)->addYear('543')->format('d/m/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($item->plan_start_date)->addYear('543')->format('d/m/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($item->plan_cmplt_date)->addYear('543')->format('d/m/Y') }}</td>
                                    <td>{{ $item->plan_job }}</td>
                                    <td>{{ $item->web_batch_status }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="text-align: center"></td>
                                <td></td>
                                <td></td>
                                <td><b>รวม</b>  </td>
                                <td style="text-align: right"> <b>{{ number_format($ptpmItems->sum('plan_qty'),3) }}</b></td>
                                <td> </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div align="center" class="mt-4"> <b>จบรายงาน</b></div>
            </div>
        </div>
    </div>
</body>
</html>
