<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> OMR0120 ยอดจำหน่ายบุหรี่ Invoice รายตรารายบริษัท </title>
    @include('om.reports.omr0120._style')
</head>
<body>
    <div style="page-break-after: always;">
        @include('om.reports.omr0120.header')
        <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid rgb(255, 253, 253); padding: 0px; margin: 0px;">
            <thead>
            <tr>
                <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center;" rowspan="2"> บริษัท </th>
                <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"  colspan="{{ count($group_item_desc) }}"> ตราบุหรี๋ </th>
                <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center;" rowspan="2"> รวม </th>
            </tr>
            <tr>
                @foreach($group_item_desc as $k => $item)
                <th style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">{{ $k }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
                @php
                    $summary_columns = [];
                    foreach($group_item_desc as $k => $i) {
                        $summary_columns[$k] = 0;
                    }
                    $summary = 0;

                @endphp
                @foreach ($group_cus as $key => $value)
                    @php
                    $summary_row = 0;
                    @endphp
                    <tr>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"> {{ $key }} </td>
                        @foreach($group_item_desc as $k => $none)
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right; width: 45px">
                            @php
                                $item = $value->where('ecom_item_description', $k)->first();
                                $summary_row += optional($item)->total;
                                $summary_columns[$k] += optional($item)->total;

                            @endphp

                            {{ !empty(optional($item)->total) ? number_format(optional($item)->total ,2 ) : '' }}
                        </td>
                        @endforeach
                        @php
                            $summary += $summary_row;
                        @endphp
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">   {{ number_format($summary_row, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"> รวมทั้งหมด </td>
                    @foreach($group_item_desc as $k => $none)
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">{{ number_format($summary_columns[$k], 2) }}</td>
                    @endforeach

                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">{{ number_format($summary , 2) }}</td>
                </tr>

            </tbody>
        </table>
        <label style="font-size: 18px; text-align: right;">หมายเหตุ : {{ $request->note }} </label>
    </div>
    {{------------------------------------------------------------------ layout 2--------------------------------------------------------------------------------------------}}
    @include('om.reports.omr0120.header_2')
    <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid rgb(255, 253, 253); padding: 0px; margin: 0px;">
        <thead>
            <tr>
                <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center; width: 50px" rowspan="2"> บริษัท </th>
                @foreach ($group_desc_2 as $key_des2 => $v_desc2 )
                {{-- {{dump($v_desc2->groupBy('ecom_item_description')->count())}} --}}
                    <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"
                    colspan="{{ $v_desc2->groupBy('ecom_item_description')->count() }}">{{$key_des2}}</th>
                @endforeach
                @foreach ($group_desc_2 as $key_des2 => $v_desc2 )
                    <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center; width: 30px" rowspan="2">รวม{{$key_des2}}</th>
                @endforeach
                {{-- {{dd(1)}} --}}
                {{-- <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center;" rowspan="2"> รวม</th> --}}
            </tr>
            <tr>
                @php
                    $summary_row2 = 0;
                    $summary_columns2 = [];
                    foreach($group_desc_2 as $k => $v_desc2) {
                        foreach ($v_desc2->groupBy('ecom_item_description') as $key => $value) {
                            $summary_columns2[$k.$key] = 0;
                        }
                    }

                    $summary_columns3 = [];
                    foreach($group_desc_2 as $kk => $i) {
                        $summary_columns3[$kk] = 0;
                    }

                    $summary2 = 0;

                @endphp

                @foreach ($group_desc_2 as $key => $value)
                    @foreach($value->groupBy('ecom_item_description') as $k => $item)
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left; width: 30px"> {{ $k }} </td>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($group_cus_2 as $key => $value)
                <tr>
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"> {{ $key }} </td>
                    @foreach($group_desc_2 as $k => $v_desc2)
                        @foreach($v_desc2->groupBy('ecom_item_description') as $kk => $v_desc22)
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">
                                @php
                                    $item = $value->where('ecom_item_description', $kk)->first();
                                    $sum_r = $data_2->where('description', $k)->where('ecom_item_description', $kk)->where('customer_id', $value->first()->customer_id)->sum('total');
                                    $summary_row2 += optional($item)->total;
                                    $summary_columns2[$k.$kk] += $sum_r;
                                @endphp
                                {{ !empty($sum_r) ? number_format($sum_r ,2 ) : '' }}
                            </td>
                        @endforeach
                    @endforeach
                    @php
                        $summary2 += $summary_row2;
                    @endphp
                    @foreach ($group_desc_2 as $key_des2 => $v_desc2 )
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;" >
                            @php
                                $summary_columns3[$key_des2] += ($value->where('description', $key_des2)->sum('total'));
                            @endphp
                            {{ !empty($value->where('description', $key_des2)->sum('total')) ?
                            number_format(($value->where('description', $key_des2)->sum('total')), 2) : ''}}
                        </td>
                    @endforeach
                    {{-- <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;"> {{ number_format($summary_row2, 2) }}</td> --}}
                </tr>
            @endforeach
            <tr>
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"> รวมทั้งหมด </td>
                @foreach($group_desc_2 as $k => $v_desc2)
                    @foreach($v_desc2->groupBy('ecom_item_description') as $kk => $v_desc22)
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">{{ number_format($summary_columns2[$k.$kk], 2) }}</td>
                    @endforeach
                @endforeach
                {{-- @foreach($group_item_desc_2 as $k => $none)
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">{{ number_format($summary_columns2[$k], 2) }}</td>
                @endforeach --}}
                @foreach ($group_desc_2 as $key_des2 => $v_desc2)
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;"> {{ number_format($summary_columns3[$key_des2] , 2)}} </td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <label style="font-size: 18px; text-align: right;">หมายเหตุ : {{ $request->note }} </label>
</body>
</html>
