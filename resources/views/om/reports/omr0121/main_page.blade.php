<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> OMR0121 ยอดจำหน่ายบุหรี่ Invoice รายตรารายปี </title>
    @include('om.reports.omr0121._style')
</head>
<body>
    {{--  style="page-break-after: always;" --}}
    <div>
        @foreach ($group_description as $key_descr => $value_descr )
        @php
        $totalYears = [];
        $sum_all = 0;
        @endphp
            <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid rgb(255, 255, 255); padding: 0px; margin: 0px;">
                <thead>
                <tr><br>
                    <div align="right" class="col-md-4" style="font-size: 16px;">
                        <label style="font-weight: bold;" > หน่วย : {{ $value_descr->first()->uom_type->unit_of_measure }} </label>
                        {{-- {{ dd($value_descr->first()->uom_type->unit_of_measure) }} --}}
                    </div>
                </tr>
                <tr>
                    <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center; width:40%  " rowspan="2"> สินค้า </th>
                    <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center; width:40%"  colspan="{{ count($group_year) }}"> ปีงบประมาณ </th>
                    <th style="font-size: 16px; border: 0.5px solid #000000; text-align: center; width:20%" rowspan="2"> รวม </th>
                </tr>
                <tr>
                    @foreach ($group_year as $key_year => $value_year )
                        <th style="font-size: 14px; border: 0.5px solid #000000; text-align: center;"> {{ $key_year }} </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-size: 18px; border: 0.5px solid #000000; text-align: left; font-weight: bold;"> {{ $key_descr }} </td>
                            @foreach ($group_year as $key_year => $value_year )
                                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"></td>
                            @endforeach
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"></td>
                    </tr>
                    @foreach ( $value_descr->groupBy('ecom_item_description') as $key_item => $value_item )
                        @php
                            $summary_row = 0;

                        @endphp
                        <tr>
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;">{{ $key_item }} </td>
                                @foreach ($group_year as $key_year => $value_year )

                                    @php
                                        $sum =  $value_item->where('year_budet', $key_year)->sum('total');
                                        $summary_row += $sum;
                                        $sum_all += $sum;
                                        @$totalYears[$key_year] += $sum
                                    @endphp
                                    {{-- {{dump($value_item)}} --}}
                                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right; width:10% ">
                                        {{ !empty($sum) ? number_format($sum, 2)  : '' }}
                                    </td>
                                @endforeach
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;"> {{ number_format($summary_row, 2) }} </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left; font-weight: bold;"> รวม{{ $key_descr }} </td>
                        @foreach ($group_year as $key_year => $value_year )
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right; width:10% ">
                                {{ !empty(@$totalYears[$key_year]) ? number_format(@$totalYears[$key_year], 2) : '' }}
                            </td>
                        @endforeach
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">{{ number_format($sum_all, 2) }}</td>
                    </tr>
                </tbody>
            </table>
            <label style="font-size: 18px; text-align: right;">หมายเหตุ : {{ $request->note }} </label>
            <div style="page-break-after: always;"></div>

        @endforeach


    </div>
</body>
</html>
