<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ยอดจำหน่ายยาเส้นไม่ปรุง</title>
</head>
<body>
    <table style="width:100%">
        <tr>
            <td colspan="{{($numberMonth +2) *2}}" align="center">ปีงบประมาณ  {{ $dateTo->format('m') >= 10 ? $dateTo->format('Y') + 544 : $dateTo->format('Y') + 543}}</td>
        </tr>
        <tr>
            <td colspan="{{($numberMonth +2) *2}}" align="center">ยอดจำหน่ายยาเส้นไม่ปรุง</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>ปริมาณ (หีบ)</td>
            @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                @php 
                    $monthNumber = $i->format('m');
                @endphp
                <td>ปริมาณ {{ @$months_th[$monthNumber] }}{{$i->format('y')+43}}</td>
                <td>มูลค่า {{ @$months_th[$monthNumber] }}{{$i->format('y')+43}}</td>
            @endfor

            <td>รวมปริมาณ</td>
            <td>รวมมูลค่า</td>

        </tr>
        <tr>
            <td>ยาเส้นไม่ปรุง (บาท)</td>
            @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                <td></td>
                <td></td>
            @endfor

            <td></td>
            <td></td>

        </tr>
        @php 
            $total = [];
        @endphp
        @foreach($results['sheet3']['columns'] as $column) 
        @php
            $total_line = [];
        @endphp
        <tr>
            <td>{{ $column }}</td>
            @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
                @php 
                    $item = $results['sheet3_data'][$i->format('mY')]->where('item_description', $column)->first();
                    @$total_line['qty'] +=optional($item)->qty;
                    @$total_line['retail_amount'] +=optional($item)->retail_amount;
                    @$total[$i->format('mY')]['qty'] += optional($item)->qty;
                    @$total[$i->format('mY')]['retail_amount'] += optional($item)->retail_amount;
                @endphp
                <td>{{ number_format(optional($item)->qty, 2)}}</td>
                <td>{{ number_format(optional($item)->retail_amount, 2)}}</td>
            @endfor

            <td>{{ number_format(@$total_line['qty'], 2)}}</td>
            <td>{{ number_format( @$total_line['retail_amount'], 2)}}</td>
        </tr>
        @endforeach
        @php
            $total_line = [];
        @endphp
        <tr>
            <td>รวมรับ</td>
            @for($i = $dateFrom->copy() ; $dateTo >= $i ; $i->addMonth(1))
            @php 
                @$total_line['qty'] +=@$total[$i->format('mY')]['qty'];
                @$total_line['retail_amount'] +=@$total[$i->format('mY')]['retail_amount'];
            @endphp
            <td>{{ number_format(@$total[$i->format('mY')]['qty'], 2)}}</td>
            <td>{{ number_format( @$total[$i->format('mY')]['retail_amount'], 2)}}</td>
            @endfor
            <td>{{ number_format(@$total_line['qty'], 2)}}</td>
            <td>{{ number_format( @$total_line['retail_amount'], 2)}}</td>
        </tr>
    </table>
</body>
</html> 