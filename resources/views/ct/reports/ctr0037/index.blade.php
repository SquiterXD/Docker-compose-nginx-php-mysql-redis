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
            $lineLimit = 25;
            $page_no = 0;
            $datas = array_chunk($header->toArray(), $lineLimit);
            $page = count($datas);
            // sum
            $total = 0;
            $total30 = 0;
            $total40 = 0;
        @endphp
        @foreach($datas as $headers)
            @php
                $page_no++;
            @endphp
            @include('ct.Reports.ctr0037.header')
            <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px; margin-top: 20px;">
                <thead> 
                    <tr style="font-size: 16px;">
                        <th class="text-center"
                            style="text-align: center; vertical-align: middle; border: 0.5px solid #000000; height: 30px; width: 5%;"> 
                            รหัสตราบุหรี่
                        </th>
                        <th class="text-center"
                            style="text-align: center; vertical-align: middle; border: 0.5px solid #000000; height: 30px; width: 15%;"> 
                            ชื่อตราบุหรี่
                        </th>
                        <th class="text-center"
                            style="text-align: center; vertical-align: middle; border: 0.5px solid #000000; height: 30px; width: 8%;"> 
                            ยอดขนสโมสร กทมฯ
                        </th>
                        <th class="text-center"
                            style="text-align: center; vertical-align: middle; border: 0.5px solid #000000; height: 30px; width: 8%;"> 
                            ยอดขนสโมสร ตจว.
                        </th>
                        <th class="text-center"
                            style="text-align: center; vertical-align: middle; border: 0.5px solid #000000; height: 30px; width: 8%;"> 
                            รวม
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($headers as $header)
                        @php
                            $cigaret30 = isset($cigarettes[$header->item_code][30])? $cigarettes[$header->item_code][30]: 0;
                            $cigaret40 = isset($cigarettes[$header->item_code][40])? $cigarettes[$header->item_code][40]: 0;
                            $totalByCigrat = 0;
                            $totalByCigrat = $cigaret30 + $cigaret40;
                            $total += $totalByCigrat;
                            $total30 += $cigaret30;
                            $total40 += $cigaret40;
                        @endphp
                        <tr style="font-size: 15px;">
                            <td style="border: 0.5px solid #000000; text-align: center;"> {{ $header->item_code }}</td>
                            <td style="border: 0.5px solid #000000; text-align: left; width:130px"> {{ $header->ecom_item_description }}</td>
                            <td style="border: 0.5px solid #000000; text-align: right; ">
                                {{ number_format($cigaret30, 2) }}
                            </td>
                            <td style="border: 0.5px solid #000000; text-align: right; ">
                                {{ number_format($cigaret40, 2) }}
                            </td>
                            <td style="border: 0.5px solid #000000; text-align: right; width:100px">
                                {{ number_format($totalByCigrat, 2) }}
                            </td>
                        </tr>
                         @if($loop->last)
                            <tr style="font-size: 15px;">
                                <td colspan=2 style=" border: 0.5px solid #000000;text-align: right; "> <b> รวม </b> </td>
                                <td style=" border: 0.5px solid #000000;text-align: right;">
                                    <b>{{ number_format($total30, 2) }} </b>
                                </td>
                                <td style=" border: 0.5px solid #000000;text-align: right;">
                                    <b>{{ number_format($total40, 2) }} </b>
                                </td>
                                <td style="border: 0.5px solid #000000;text-align: right;">
                                    <b>{{ number_format($total, 2) }} </b>
                                </td>
                            </tr>
                        @endif
                    @endforeach 
                </tbody>
            </table>
            <div style="page-break-after: always;"> </div>
        @endforeach
    </body>
</html>