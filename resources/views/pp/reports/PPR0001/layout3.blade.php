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
    $page_no = 5;
@endphp
@include('pp.reports.PPR0001.header')
@foreach ($machineYearly as $product_type_name => $MY)
    <table style="margin-top: 15px;">
        <tr>
            <th style="text-align: left;"><b>ประเภท : {{$product_type_name}} </b></th>
        </tr>
    </table>
    <table class="table_data" style="border: #000000 solid 0.5px;   width: 100%;">
        <thead>
            <tr>
                <th colspan="{{ count($monthlists)+ 2}}" > แผนการซ่อมบำรุงและลดกำลังการผลิต </th>
            </tr>
            <tr>
                <th style="border:#000 0.5px solid;vertical-align: middle;width:100/{{ count($monthlists)+ 2}}%;"> </th>
                @foreach ($monthlists as $key => $month)
                    <th style="border:#000 0.5px solid;vertical-align: middle;width:100/{{ count($monthlists)+ 2}}%;"> {{ $month }}</th>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle;">
                   <div> รวม </div>
                </th>
            </tr>
        </thead>
        @php
            $sumPm = 0;
            $sumDt = 0;
        @endphp
        <tbody>
            <tr>
                <td style="border:#000 0.5px solid; text-align: left;">กำหนดการหยุดซ่อมบำรุงประจำปี (ล้านมวน)</td>
                @foreach ($monthlists as $periodName => $m)
                    @php
                        $sumPm += $machinePm[$product_type_name][$periodName];
                    @endphp
                    <td style="border:#000 0.5px solid;vertical-align: middle;width:100/{{ count($monthlists)+ 2}}%; text-align: right;">
                        {{$machinePm[$product_type_name][$periodName]}}
                    </td>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle;width:100/{{ count($monthlists)+ 2}}%; text-align: right;">{{$sumPm}}</th>
            </tr>
            <tr>
                <td style="border:#000 0.5px solid; text-align: left;">ลดกำลังผลิต (ล้านมวน)</td>
                @foreach ($monthlists as $index => $m)
                    @php
                        $sumDt += $machineDt[$product_type_name][$periodName];
                    @endphp
                    <td style="border:#000 0.5px solid;vertical-align: middle;width:100/{{ count($monthlists)+ 2}}%; text-align: right;">
                        {{$machineDt[$product_type_name][$periodName]}}
                    </td>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle;width:100/{{ count($monthlists)+ 2}}%; text-align: right;">{{$sumDt}}</th>
            </tr>
        </tbody>
    </table>
@endforeach
</body>
</html>