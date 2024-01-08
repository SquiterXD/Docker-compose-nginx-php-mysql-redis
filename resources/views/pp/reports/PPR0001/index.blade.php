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
    @include('pp.reports.PPR0001.header') 
    <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px; margin-top: 20px;width: 100%;">     
    <thead>
            <tr>
                <th style="border:#000 0.5px solid; text-align: center;">ประเภทบุหรี่ 7.8 ม.ม.</th>
                @foreach ($periods as $period_no => $thai_month_arr)
                    <th style="border:#000 0.5px solid; text-align: center;">{{ $thai_month_arr }}</th>
                @endforeach
                <th style="border:#000 0.5px solid; text-align: center;"> รวม </th>
            </tr>
        </thead>
        <tbody>
            @if (count($estimateYearlies) <= 0)
                <tr>
                    <td colspan="{{ count($periods)+2 }}" class="text-center">
                        <h2> ไม่พบข้อมูลประมาณการผลิตทั้งปีงบประมาณ </h2>
                    </td>
                </tr>
            @else
                @foreach ($estimateYearlies as $col_desc => $est)
                    <tr>
                        <td style="border:#000 0.5px solid; text-align: left;"> {{ $col_desc }} </td>
                        @foreach ($est as $period_no => $value)
                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($est[$period_no], 2) }} </td>
                            @if ($loop->last)
                                <td style="border:#000 0.5px solid; text-align: right;">
                                    <b>{{ number_format(array_sum($est), 2) }}</b>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endif
           
        </tbody>
    </table>
    <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px; margin-top: 20px ; width: 60%;">     
        <thead>
            @foreach ($tab22 as $t22)
                <tr>
                    <th style="border:#000 0.5px solid; text-align: center;">ประเภทบุหรี่ 7.1 ม.ม.</th>
                    <th style="border:#000 0.5px solid; text-align: left;">ประมาณการจำหน่าย (ล้านมวน) : {{$t22->forcast_qty71}}</th>
                    <th style="border:#000 0.5px solid; text-align: left;">ประมาณการผลิต (ล้านมวน) : {{$t22->planning_qty71}}</th>
                </tr>
                <tr>
                    <th style="border:#000 0.5px solid; text-align: center;">รวม</th>
                    <th style="border:#000 0.5px solid; text-align: left;">ประมาณการจำหน่าย (ล้านมวน) : {{number_format($t22->sum_forcast_qty,2)}}</th>
                    <th style="border:#000 0.5px solid; text-align: left;">ประมาณการผลิต (ล้านมวน) : {{number_format($t22->sum_planning_qty,2)}}</th>
                </tr>
            @endforeach
        </thead>
    </table>
    <div style="page-break-after: always;"> </div>
    @include('pp.reports.PPR0001.layout2')
    <div style="page-break-after: always;"> </div>
    @include('pp.reports.PPR0001.layout3')
    <div style="page-break-after: always;"> </div>
    @include('pp.reports.PPR0001.layout4')
    <div style="page-break-after: always;"> </div>
    @include('pp.reports.PPR0001.layout5')
 
</body>
</html>



