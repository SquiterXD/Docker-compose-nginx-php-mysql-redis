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
    $page_no = 8;
@endphp
@foreach ($dataHeads  as $product_type_desc => $head)
    @php
        $page_no++
    @endphp
    <div style="page-break-after: always;"> </div>
    @include('pp.reports.PPR0001.header')
    <table> 
        <tr>
            <th style=" text-align: center;"><b>ประมาณการผลิตบุหรี่และก้นกรองประจำปี</b></th>
        </tr>
    </table>
    <table class="table_data" style="border: #000000 solid 0.5px;   width: 100%; padding: 1px; margin-top: 5px ;">
        <thead>
            <tr>
                <th style="border:#000 0.5px solid;vertical-align: middle;width:15%"> {{$product_type_desc}}</th>
                @foreach ($monthlists as $key => $month)
                    <th style="border:#000 0.5px solid;vertical-align: middle;width:100/{{ count($monthlists)+ 2}}%"> {{ $month }}</th>
                @endforeach
                <th style="border:#000 0.5px solid;vertical-align: middle;">
                   <div>รวม</div>
                </th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0 ; $i <= $head[0]->cnt_item ; $i++)
                @php
                    $sumItem =0;
                @endphp
                <tr>
                    <td style="border:#000 0.5px solid; text-align: left;"> {{$head[$i]->item_description}} </td>
                    @foreach ($months as $month)
                        @php
                        $sumItem += $totalEfficiency[$product_type_desc][$month->period_name.'|'.$head[$i]->item_description];
                        @endphp
                        <td style="border:#000 0.5px solid;vertical-align: middle; text-align: right;">
                            {{number_format($totalEfficiency[$product_type_desc][$month->period_name.'|'.$head[$i]->item_description], 2)}}
                        </td>
                    @endforeach
                    <td style="border:#000 0.5px solid; text-align: center;width: 8%; text-align: right;"><b>{{number_format($sumItem, 2)}}</b></td>
                </tr>
            @endfor
            <tr>
                @php
                    $sumPro =0;
                @endphp
                <td style="border:#000 0.5px solid;vertical-align: middle; text-align: center;"><b>รวมผลิต {{$product_type_desc}}</b> </td>
                @foreach ($months as $month)
                    @php
                        $sumPro += $sumByProduct[$product_type_desc][$month->period_name] ;
                    @endphp
                    <td style="border:#000 0.5px solid;vertical-align: middle; text-align: right;">
                        <b> {{number_format($sumByProduct[$product_type_desc][$month->period_name], 2)}} </b>
                    </td>
                @endforeach
                <td style="border:#000 0.5px solid;vertical-align: middle; text-align: right;">
                    <b> {{number_format($sumPro, 2)}}</b>
                </td>
            </tr>
            @if($loop->last) 
                <tr>
                    @php
                        $sumMon =0;
                    @endphp
                    <td style="border:#000 0.5px solid;vertical-align: middle; text-align: center;"><b>รวมผลิตทั้งหมด</b> </td>
                    @foreach ($months as $month)
                        @php
                            $sumMon += $sumByMonth[$month->period_name][$month->period_name];
                        @endphp
                        <td style="border:#000 0.5px solid;vertical-align: middle; text-align: right;">
                            <b> {{number_format($sumByMonth[$month->period_name][$month->period_name], 2)}}</b>
                        </td>
                    @endforeach
                    <td style="border:#000 0.5px solid;vertical-align: middle; text-align: right;"><b> {{number_format($sumMon, 2)}}</b> </td>
                </tr>
            @endif
        </tbody>
    </table>
@endforeach
</body>
</html>