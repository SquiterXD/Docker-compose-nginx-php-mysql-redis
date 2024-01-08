<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ปริมาณการจำหน่ายบุหรี่</title>
</head>
<body>
    <table style="width:100%">
        <thead>
            {{-- <tr>
                <td colspan="{{$numberMonth + 3}}" align="center">ปี {{$dateFrom->format('Y') + 543}}</td>
            </tr> --}}
            <tr>
                <td colspan="{{$numberMonth + 3}}" align="center">ปริมาณการจำหน่ายบุหรี่ในประเทศและต่างประเทศปีงบประมาณ {{ $dateTo->format('m') >= 10 ? $dateTo->format('Y') + 544 : $dateTo->format('Y') + 543}} (มวน)</td>
            </tr>
            <tr>
                <td colspan="{{$numberMonth + 3}}" align="center">({{ @$months_th[$dateFrom->format('m')] }} {{$dateFrom->format('y') + 43}} - {{@$months_th[$dateTo->format('m')]}} {{$dateTo->format('y') + 43}})  </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                @php 
                @endphp
                @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                @php 
                    $monthNumber = $i->format('m');
                @endphp
                <td align="right">{{ @$months_th[$monthNumber] }} {{$i->format('y') + 43}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endfor
                <td align="right">สะสม &nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="">บุหรี่จำหน่ายในประเทศ (มวน)</td>
            </tr>
            @php 
            $total = [];
            $summary = [];
            @endphp
            @foreach($results['sheet1']['section1']['columns'] as $column)
            @php 
            $total_row = 0;
            @endphp
            <tr>
                <td>{{ $column }}</td>
                @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                @php 
                    $item = collect(@$results['sheet1-2']['section1'][$i->format('mY')]['data'])->where('report_item_display', $column)->first();
                    if(!empty($total[$i->format('mY')] )) {
                        $total[$i->format('mY')] += @$item->all_qty;
                    } else {
                        $total[$i->format('mY')] = @$item->all_qty;
                    }
                    
                    $total_row +=  @$item->all_qty;
                    
                @endphp
                <td align="right">
                {{ number_format(@$item->all_qty, 0) }}
                </td>
                @endfor
                <td align="right">{{ number_Format($total_row , 0) }}</td>
            </tr>
            @endforeach
            <tr>
                <td style="font-weight: bold">รวมในประเทศ (มวน)</td>
                @php 
                $total['row'] = 0;
                @endphp
                @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                @php 
                $total['row'] += $total[$i->format('mY')];
                @$summary[$i->format('mY')] += $total[$i->format('mY')];
                @endphp
                <td align="right">
                    {{ number_format($total[$i->format('mY')], 0) }}
                </td>
                @endfor

                <td align="right">
                    {{ number_format($total['row'], 0) }}
                </td>
            </tr>
            <tr>
                <td colspan="" style="font-weight: bold">บุหรี่จำหน่ายต่างประเทศ (มวน)</td>
            </tr>

            @php 
            $total = [];
            @endphp
            @foreach($results['sheet1']['section2']['columns'] as $column)
            @php 
                    $total_row = 0;
            @endphp
            <tr>
                <td>{{ $column }}</td>
                @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                @php 
                    $item = collect(@$results['sheet1-2']['section2'][$i->format('mY')]['data'])->where('item_description', $column);
                    if(!empty($total[$i->format('mY')] )) {
                        $total[$i->format('mY')] += @$item->sum('approve_quantity');
                    } else {
                        $total[$i->format('mY')] = @$item->sum('approve_quantity');
                    }
                    
                    $total_row +=  @$item->sum('approve_quantity');
                    
                @endphp
                <td align="right">
                    {{ number_format($item->sum('approve_quantity') * 1000, 0)}}
                </td>
                @endfor

                <td align="right">
                    {{ number_format($total_row * 1000, 0)}}
                </td>
            </tr>
            @endforeach
            <tr>
                <td style="font-weight: bold">รวมต่างประเทศ (มวน)</td>
                @php 
                $total['row'] = 0;
                @endphp
                @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                @php 
                $total['row'] += $total[$i->format('mY')];
                @$summary[$i->format('mY')] += $total[$i->format('mY')] *1000;

                @endphp
                <td align="right">
                    {{ number_format($total[$i->format('mY')] * 1000, 0) }}
                </td>
                @endfor

                <td align="right">
                    {{ number_format($total['row'] * 1000, 0) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold">รวมในประเทศ+ต่างประเทศ (มวน)</td>
                @php 
                $total['row'] = 0;
                @endphp
                @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                @php 
                $total['row'] += $summary[$i->format('mY')];
                @endphp
                <td align="right">
                    {{ number_format($summary[$i->format('mY')], 0) }}
                </td>
                @endfor

                <td align="right">
                    {{ number_format($total['row'], 0) }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>