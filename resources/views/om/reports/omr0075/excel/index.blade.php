<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
@php
    $colspan = count($items);
    $colspan2=$colspan-1;
@endphp
<table class="table">
    <thead>
        <tr>
            <th style="text-align:left;">โปรแกรม : {{ $programCode }}</th>
            <th colspan={{ $colspan2 }} style="text-align:center;">การยาสูบแห่งประเทศไทย</th>
            <th colspan=2 style="text-align:left;"> วันที่ : {{ parseToDateTh(now()) }}</th>
        </tr>
        <tr>
            <th style="text-align:left;">สั่งพิมพ์ : {{ optional(auth()->user())->username }}</th>
            <th colspan={{ $colspan2 }} style="text-align:center;">{{ $progTitle }}</th>
            <th colspan=2 style="text-align:left;">เวลา : {{ date('H:i', strtotime(now())) }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan={{ $colspan2 }} style="text-align:center;">{{ $progPara }}</th>
            <th colspan=2 style="text-align:left;"> หน้า : <span class="pagenum">1</span></th>
        </tr>
        <tr>
            <th></th>
            <th colspan={{ $colspan2 }} style="text-align:center;"></th>
            <th colspan=2 style="text-align:left;"> หน่วย : {{ $progUnit[0] }} (บุหรี่) / {{ $progUnit[1] }}(ยาเส้น) </th>
        </tr>
        <tr>

            <th rowspan=2 style="width:180px;text-align:left;"> ตราสินค้า</th>
            <td colspan={{ $colspan }} style="text-align:center;">ยอดขายจริง</td>
            <th rowspan=2 style="width:100px;text-align:center;">ค่าเฉลี่ย<br>({{ $colspan }} วันขาย)</th>
        </tr>
        <tr>
            @foreach ($items as $item)
            <td style="width:100px;text-align:center;">{{ $item->date_th }}</td>
            @endforeach
        </tr>

    </thead>
    <tbody>
    @foreach ($data as $line)
        <tr>
            <td>{{ $line->item_title }}</td>
            @foreach ($items as $item)
            @php
                $a = 'qty_'.$item->date_code;
            @endphp
            <td style="text-align: right;">{{ ($line->{$a}<>0)?$line->{$a}:'' }}</td>
            @endforeach
            <td style="text-align: right;">{{ ($line->qty<>0)?$line->qty:'' }}</td>
        </tr>
    @endforeach
        <tr>
            <td style="text-align: left;">ยอดรวม</td>
            @foreach ($items as $item)
            <td style="text-align: right;"></td>
            @endforeach
            <td style="text-align: right;"></td>
        </tr>
        <tr>
            <td style="text-align: left;"></td>
            @foreach ($items as $item)
            <td style="text-align: right;"></td>
            @endforeach
            <td style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan={!! $colspan+2 !!} style="text-align: left;">หมายเหตุรายการ : {{ $remark }}</td>
        </tr>
    </tbody>

</table>
