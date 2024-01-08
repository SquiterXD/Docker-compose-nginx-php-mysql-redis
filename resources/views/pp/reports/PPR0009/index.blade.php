<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	@include('pp.reports.PPR0009._style')
    <style>
       .table_data{
            border: 0.5px solid rgb(200, 200, 200);
            border-collapse: collapse;
            height: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
        @php
            $lineLimit = 16;
            $dataP09 = array_chunk($dataHeads->toArray(), $lineLimit);
            $page = count($dataP09);
            $page_no = 0;
        @endphp

        @foreach ($dataP09 as $Heads)
            @php
                $page_no++;
            @endphp
            <div style="page-break-after: always;"></div>
            @include('pp.reports.PPR0009.header')
            <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px; margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="border:#000 0.5px solid; text-align: center; width: 10%"> วันที่/ตราบุหรี่ </th>
                        @foreach($cigarettes as $c)
                            <th style="border:#000 0.5px solid; text-align: center; width: 10%"> {{ $c->cigarettes_description }}</th>
                        @endforeach
                        <th style="border:#000 0.5px solid; text-align: center; width: 10%"> รวม </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Heads as $Head)
                        <tr>
                            <td style="border:#000 0.5px solid; text-align: center; width:{{$cnt_cig}}%">
                                {{ $Head[0]['plan_date_text'] }}
                            </td>
                            @foreach($cigarettes as $cica)
                                <td style="border:#000 0.5px solid; text-align: right; width:{{$cnt_cig}}%">
                                    {{  number_format($stampQty[ $Head[0]['plan_date_text']][$cica->cigarettes_description],2)}}
                                </td>
                            @endforeach
                            <td style="border:#000 0.5px solid; text-align: right; width:{{$cnt_cig}}%">
                                <b>{{ number_format($Head[0]['sum_qty_lv_date'],2) }} </b>
                            </td>
                        </tr>
                    @endforeach

                    @if($loop->last) 
                        <tr> 
                            <td style="border:#000 0.5px solid; text-align: center; width:{{$cnt_cig}}%">
                                <b>รวมเดือน {{ $Head[0]['short_format_thai'] }}</b>
                            </td>
                            @foreach($cigarettes as $cica)
                                    <td style="border:#000 0.5px solid; text-align: right; width:{{$cnt_cig}}%">
                                    <b> {{  number_format($sumQtyLvCiga[$cica->cigarettes_description][$cica->cigarettes_description],2)}}</b>
                                    </td>
                            @endforeach
                            <td style="border:#000 0.5px solid; text-align: right; width:{{$cnt_cig}}%">
                                <b>{{ number_format($Head[0]['sum_rpt'],2) }}</b>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach
</body>
</html>



