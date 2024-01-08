<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	@include('pp.reports.PPR0001._style')
    <style>
        .table_data{
            border: 0.5px solid rgb(200, 200, 200);
            border-collapse: collapse;
            height: 20px;
        }
    </style>
</head>
<body>
@php
    $page = 10;
    $page_no = 1;
@endphp
@foreach ($tab1Yearly as $meaning => $T1)
    @php
        $page_no++
    @endphp
    <div style="page-break-after: always;"> </div>
    @include('pp.reports.PPR0001.header')
    <table style="width: 50%;">
        <tr>
            <th style=" text-align: left;"><b>ประเภท : {{$meaning}}   สั่งผลิต : {{$T1[0]->efficiency_product}} %</b></th>
        </tr>
    </table>
    <table class="table_data" style="border: #000000 solid 0.5px;  width: 100%;">
        <thead>
            <tr>
                <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>ขอบเขต<br>เครื่องจักร</th>
                <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>รายละเอียด<br>ขอบเขตเครื่องจักร</th>
                <th style="border:#000 0.5px solid; text-align: center;"colspan= {{count($WorkHour)}}>กำลังการผลิต <br> (ล้านมวน)</th>
                <th style="border:#000 0.5px solid; text-align: center;"colspan= {{count($WorkHour)}}>สั่งผลิต <br> (ล้านมวน)</th>
                <th style="border:#000 0.5px solid; text-align: center;">ผลผลิตล่วงเวลา (ล้านมวน)</th>
                <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>ยอดผลผลิตช่วง PM<br>(ล้านมวน)</th>
                <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>ยอดผลผลิต <br> ช่วงลดกำลังผลิต <br>(ล้านมวน)</th>
                <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>รวมสั่งผลิต<br>(ล้านมวน)</th>
            </tr>
            <tr>
            @foreach($WorkHour as $wh)
                <th style="border:#000 0.5px solid; text-align: center;" rowspan=2 >{{$wh->working_hour}} ชั่วโมง</th>
            @endforeach
            @foreach($WorkHour as $wh)
                <th style="border:#000 0.5px solid; text-align: center;"rowspan=2 >{{$wh->working_hour}} ชั่วโมง</th>
            @endforeach
            @foreach($WorkHourOt as $whOT)
                <th style="border:#000 0.5px solid; text-align: center;"rowspan=2> {{$whOT->working_hour_ot}} ชั่วโมง</th>
            @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ( $T1 as $Head)
                <tr>
                    <td style="border:#000 0.5px solid; text-align: left;">{{$Head->machine_group_name}}</td>
                    <td style="border:#000 0.5px solid; text-align: left;">{{$Head->machine_group_desc}}</td>
                    @foreach($WorkHour as $wh)
                        <td style="border:#000 0.5px solid; text-align: right;">
                            {{ number_format($productionCapacity[$Head->machine_group_name][$wh->working_hour],2) }}
                        </td>
                    @endforeach
                    @foreach($WorkHour as $wh)
                        <td style="border:#000 0.5px solid; text-align: right;">
                            {{ number_format($efficiencyProduct[$Head->machine_group_name][$wh->working_hour],2) }}
                        </td>
                    @endforeach
                    @foreach($WorkHourOt as $whOT)
                        <td style="border:#000 0.5px solid; text-align: right;">
                            {{ number_format($totalOtProduct[$Head->machine_group_name][$whOT->working_hour],2) }}
                        </td>
                    @endforeach
                    <td style="border:#000 0.5px solid; text-align: right;">
                        {{ number_format($PmEfficiency[$Head->machine_group_name][$Head->machine_group_name],2) }}
                    </td>
                    <td style="border:#000 0.5px solid; text-align: right;">
                        {{ number_format($DtEfficiency[$Head->machine_group_name][$Head->machine_group_name],2) }}
                    </td>
                    <th style="border:#000 0.5px solid; text-align: right;">
                        {{ number_format($TotalEfficiencyProduct[$Head->machine_group_name][$Head->machine_group_name],2) }}
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
</body>
</html>



