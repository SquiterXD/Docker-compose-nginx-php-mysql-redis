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
@foreach ($YearlyTab21 as $product_type_desc => $YearTab21)
@php
    $page_no++
@endphp
    <div style="page-break-after: always; width: 100%;"> </div>
    @include('pp.reports.PPR0001.header')  
    <table style="padding: 5px;"> 
        <tr>
            <th style=" text-align: center;"><b>ประมาณการผลิตบุหรี่รายตราและชั่วโมงการทำงาน ของฝ่ายโรงงานยาสูบ</b></th>
        </tr>
        <tr>
            <th style=" text-align: left;"><b>ประเภท : {{$product_type_desc}} </b></th>
        </tr>
    </table>

    <table class="table_data" style="border: #000000 solid 0.5px;   width: 100%;">
        <thead>
            <tr>
                <th style="border:#000 0.5px solid;vertical-align: middle; " colspan=2> เดือน </th>
                @foreach ($monthlists as $key => $month)
                    <th style="border:#000 0.5px solid;vertical-align: middle;width:100/{{ count($monthlists)+ 3}}%"> {{ $month }}</th>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle;"> รวม (ชั่วโมง)</th>
            </tr>
        </thead>
        @php
            $sumDay = 0;
            $normalSum = 0;
            $PmSum = 0;
            $otSum = 0;
            $sum = 0;
        @endphp
        <tbody>
            <tr>
                <td style="border:#000 0.5px solid;vertical-align: middle; text-align:center;" rowspan={{$cntWorkHour+1}} >วันผลิต</td>
            </tr>
            @foreach ($cnt_working_hour as $index => $wh)
                <tr>
                    <td style="border:#000 0.5px solid;vertical-align: middle; text-align:center;"> {{$wh->working_hour }} ชม.</td>
                    @foreach ($months as $month)
                        @php
                            $sumDay + $totalDays[$YearTab21[$index]->product_type_desc][$month->period_name.'|'.$wh->working_hour] ;
                        @endphp
                        <td style="border:#000 0.5px solid;vertical-align: middle; text-align:right;">
                            {{$totalDays[$YearTab21[$index]->product_type_desc][$month->period_name.'|'.$wh->working_hour ]}}
                        </td>
                    @endforeach
                    <th style="border:#000 0.5px solid;vertical-align: middle; text-align:right;"> {{$sumDay}} </th>
                </tr>
            @endforeach
            <tr>
                <td style="border:#000 0.5px solid;vertical-align: middle; text-align:center;" rowspan=4>ชั่วโมงการผลิต</td>
            </tr>
            <tr>
                <td style="border:#000 0.5px solid;vertical-align: middle; text-align:center;"> ปกติ</td>
                @foreach ($months as $index =>  $month)
                    @php
                        $normalSum += $totalWkhNormal[$YearTab21[$index]->product_type_desc][$month->period_name];
                    @endphp
                    <td style="border:#000 0.5px solid;vertical-align: middle; text-align:right;"> {{$totalWkhNormal[$YearTab21[$index]->product_type_desc][$month->period_name]}}</td>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle; text-align:right;">{{$normalSum}}</th>
            </tr>
            <tr>
                <td style="border:#000 0.5px solid;vertical-align: middle; text-align:center;"> พักผ่อน</td>
                @foreach ($months as $index => $month)
                    @php
                        $PmSum += $totalPm[$YearTab21[$index]->product_type_desc][$month->period_name];
                    @endphp
                    <td style="border:#000 0.5px solid;vertical-align: middle; text-align:right;"> {{$totalPm[$YearTab21[$index]->product_type_desc][$month->period_name]}}</td>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle; text-align:right;">{{$PmSum}}</th>
            </tr>
            <tr>
                <td style="border:#000 0.5px solid;vertical-align: middle; text-align:center;"> ล่วงเวลา</td>
                @foreach ($months as $index => $month)
                    @php
                        $otSum += $totalOt[$YearTab21[$index]->product_type_desc][$month->period_name];
                    @endphp
                    <td style="border:#000 0.5px solid;vertical-align: middle; text-align:right;"> {{$totalOt[$YearTab21[$index]->product_type_desc][$month->period_name]}}</td>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle; text-align:right;">{{$otSum}}</th>
            </tr>
            <tr>
                <th style="border:#000 0.5px solid;vertical-align: middle; text-align:center;" colspan=2> รวมจำนวนชั่วโมง </th>
                @foreach ($months as $index => $month)
                    @php
                        $sum += $sumWkh[$YearTab21[$index]->product_type_desc][$month->period_name];
                    @endphp
                    <th style="border:#000 0.5px solid;vertical-align: middle; text-align:right;"> {{$sumWkh[$YearTab21[$index]->product_type_desc][$month->period_name]}}</th>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle; text-align:right;"> {{$sum}} </th>
            </tr>
        </tbody>
    </table>
@endforeach
</body>
</html>