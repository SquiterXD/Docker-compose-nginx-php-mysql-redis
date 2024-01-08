<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @include('ct.Reports.ctr0036._style')
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
            $datas20 = array_chunk($items20->toArray(), $lineLimit);
            $page_no++;
            // sum
            $totalCarton = 0;
            $totalQuentity = 0;
            $totalAll = 0;
        @endphp
        @foreach($datas20 as $data)
            @php
                $page_no++;
                $productType = $data[0]['product_type_desc'] ;
            @endphp
            @include('ct.Reports.ctr0036.header')
            <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px; margin-top: 20px;">
                <thead>
                    <tr style="font-size: 15px;">
                        <th rowspan=2 style="border: 1px solid #000000; text-align: center; background-color:powderblue; width:8%;">
                            รหัสยาเส้น </th>
                        <th rowspan=2 style="border: 1px solid #000000; text-align: center; background-color:powderblue; width:20%">
                            ยาเส้น
                        </th>
                        <th rowspan=2 style="border: 1px solid #000000; text-align: center; background-color:powderblue; width:8%">
                            ปริมาณจำหน่าย <br> (หีบ)
                        </th>
                        <th rowspan=2 style="border: 1px solid #000000; text-align: center; background-color:powderblue; width:8%;">
                            ปริมาณแสตมป์ <br> (ดวง)
                        </th>
                        <th rowspan=2 style="border: 1px solid #000000; text-align: center; background-color:powderblue; width:8%;"> @ </th> 
                        @foreach($fundLoca20 as $fd)
                            <th rowspan=2 style="border: 1px solid #000000; text-align: center; background-color:powderblue; width:7"> 
                                {{ $fd->percent }}% <br> {{ $fd->fund_location == 'total'? 'แสตมป์รวมกองทุน' : $fd->fund_location }}
                            </th>
                        @endforeach
                        <th rowspan=2 style="border: 1px solid #000000; text-align: center; background-color:powderblue; width:7%;"> รวมกองทุน </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $itm)
                        @php
                            $totalCarton += $QuantityCarton[$itm['item']][0];
                            $totalQuentity += $StampQuantity[$itm['item']][0];
                            $totalAll += $qtySum[$itm['item']][0];
                        @endphp
                        <tr style="font-size: 14px;">
                            <td style="border: 1px solid #000000; text-align: center;"> {{ $itm['item_code'] }}</td>
                            <td style="border: 1px solid #000000; text-align: left; width:130px"> {{ $itm['item_description'] }}</td>
                            <td style="border: 1px solid #000000; text-align: right; ">
                                {{ number_format($QuantityCarton[$itm['item']][0], 2) }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right; ">
                                {{ number_format($StampQuantity[$itm['item']][0]) }}
                            </td>
                            <td style="border: 1px solid #000000; text-align: right; ">
                                {{ number_format($UnitPrice[$itm['item']][0], 7) }}
                            </td>
                            @foreach($fundLoca20 as $fd)
                                <td style="border: 1px solid #000000; text-align: right;">
                                    {{ number_format($QtysAmount[$itm['item']][$fd->percent], 2) }}
                                </td>
                            @endforeach
                            <td style="border: 1px solid #000000; text-align: right; width:100px"> {{ number_format($qtySum[$itm['item']][0], 2) }} </td>
                        </tr>
                        @if($loop->last)
                            <tr style="font-size: 14px;">
                                <td colspan=2 style=" border: 1px solid #000000;text-align: right; "> <b>รวม</b> </td>
                                <td style=" border: 1px solid #000000;text-align: right;"> <b>{{ number_format($totalCarton, 2) }}</b> </td>
                                <td style=" border: 1px solid #000000;text-align: right;"> <b>{{ number_format($totalQuentity) }}</b> </td>
                                <td style=" border: 1px solid #000000;text-align: center;"> <b> - </b> </td>
                                @foreach($fundLoca20 as $fd)
                                    <td style="border: 1px solid #000000; text-align: right;">
                                        <b> {{ number_format($SumQtysPercent[$itm['product_type']][$fd->percent], 2) }} </b>
                                    </td>
                                @endforeach
                                <td style="border: 1px solid #000000;text-align: right;"> <b>{{ number_format($totalAll,2) }}</b> </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div style="page-break-after: always;"> </div>
        @endforeach
        @include('ct.Reports.ctr0036.cr_dr20')
    </body>
</html>