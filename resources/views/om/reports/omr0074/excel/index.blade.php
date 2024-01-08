<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
@php
    $colspan = count($items)-1;
@endphp
<table class="table">
    <thead>
        <tr>
            <th style="text-align:left;">โปรแกรม : {{ $programCode }}</th>
            <th colspan={{ $colspan }} style="text-align:center;">การยาสูบแห่งประเทศไทย</th>
            <th style="text-align:left;"> วันที่ : {{ parseToDateTh(now()) }}</th>
        </tr>
        <tr>
            <th style="text-align:left;">สั่งพิมพ์ : {{ optional(auth()->user())->username }}</th>
            <th colspan={{ $colspan }} style="text-align:center;">{{ $progTitle }}</th>
            <th style="text-align:left;">เวลา : {{ date('H:i', strtotime(now())) }}</th>
        </tr>
        <tr>
            <th></th>
            <th colspan={{ $colspan }} style="text-align:center;">{{ $progPara }}</th>
            <th style="text-align:left;"> หน้า : <span class="pagenum">1</span></th>
        </tr>
        <tr>
            <th></th>
            <th colspan={{ $colspan }} style="text-align:center;"></th>
            <th style="text-align:left;"> หน่วย : {{ $progUnit }} </th>
        </tr>
        <tr>
            <th style="min-width:150px;text-align:left;"> ตราสินค้า</th>
            @foreach ($items as $item)
            <td style="@php if($loop->last){ echo 'width:200px';}else{ echo 'width:140px';} @endphp ;text-align:center;">ปีงบฯ {!! $item+543 !!}</td>
            @endforeach
        </tr>

    </thead>
    <tbody>
    @foreach ($data as $line)
            @php
                $approve_date = $line->approve_date;
            @endphp
        <tr>
            <td>{{ $line->item_title }}</td>
            @foreach ($items as $item)
            @php
                $a = $listby.'_'.$item;
            @endphp
            <td style="text-align: right;">{{ ($line->{$a}<>0)?$line->{$a}:'' }}</td>
            @endforeach
        </tr>
    @endforeach
        <tr>
            <td style="text-align: left;">รวมทุกตรา</td>
            @foreach ($items as $item)
            <td style="text-align: right;"></td>
            @endforeach
        </tr>
        <tr>
            <td style="text-align: left;"></td>
            <td colspan={{ $colspan }} style="text-align: left;"></td>
            <td style="text-align: left;"></td>
        </tr>
        <tr>
            <td style="text-align: left;">วันที่อนุมัติ : </td>
            <td colspan={{ $colspan }} style="text-align: left;">{{ $approve_date }}</td>
            <td style="text-align: left;"></td>
        </tr>
        <tr>
            <td style="text-align: left;">หมายเหตุรายการ : </td>
            <td colspan={{ $colspan }} style="text-align: left;">{{ $remark }}</td>
            <td style="text-align: left;"></td>
        </tr>
    </tbody>

</table>
