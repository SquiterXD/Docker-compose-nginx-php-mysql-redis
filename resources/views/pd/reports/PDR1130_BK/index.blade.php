<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @include('pd.reports.PDR1130._style')
        <style>
           .table_data{
        border: 0.5px solid rgb(200, 200, 200);
        border-collapse: collapse;
        height: 20px;
            } 
        </style>    
    </head>

    <body>
        <!-- header report -->
        @php
            $pageNo = 0;
            $limit = 12;
            $data = array_chunk($DATAsWip02->toArray(), $limit);
            $page = count($data);
        @endphp
        @foreach ($data as $wip02)
            @php
                $pageNo++;
            @endphp
            <div style="page-break-after: always;"></div>
            @include('pd.reports.PDR1130.header')
            <table class ="table_data">
                <thead>
                    <tr >
                        <!-- wip02 -->
                        <th style="border: 1px solid #000000; text-align: center;  width: 70px;" rowspan=3 > เลขที่คำสั่งผลิต </th>
                        <th style="border: 1px solid #000000; text-align: center; " rowspan=3 > รหัสหมวด </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 70px;" rowspan=3 > รหัสสิ่งพิมพ์ </th>
                        <th style="border: 1px solid #000000; text-align: center; " rowspan=3 > ชื่อสิ่งพิมพ์ </th>
                        <th style="border: 1px solid #000000; text-align: center; " rowspan=3 > รับจากกองพิมพ์<BR>แผ่น</th>
                        <th style="border: 1px solid #000000; text-align: center; " rowspan=3 > แผ่นละตัดได้<BR>ชิ้น</th>

                        <th style="border: 1px solid #000000; text-align: center; " colspan=5> ระหว่างคัดเลือก</th>
                        <th style="border: 1px solid #000000; text-align: center; " colspan=5> สำเร็จรูป</th>
                        </tr>
                        <tr >
                        <!-- wip03 -->
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > ชิ้น </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > ยอดยกมา<BR>ชิ้น </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > รวม<BR>ชิ้น </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > เสีย<BR>ชิ้น </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > ยอดยกไป<BR>ชิ้น </th>

                        <!-- wip04 -->
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > บรรจุได้<BR>ชิ้น </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > ยอดยกมา<BR>ชิ้น </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > รวม<BR>ชิ้น </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px;" rowspan=2 > ยอดโอนออก<BR>ชิ้น </th>
                        <th style="border: 1px solid #000000; text-align: center; width: 50px; " rowspan=2 > ยอดยกไป<BR>ชิ้น </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wip02 as $key => $value)
                        <tr>
                            <td style="border: 1px solid #000000; text-align: left;">{{$value['batch_no']}}</td>
                            <td style="border: 1px solid #000000; text-align: center;">{{$value['product_group']}}</td>
                            <td style="border: 1px solid #000000; text-align: left;">{{$value['product_code']}}</td>
                            <td style="border: 1px solid #000000; text-align: left;">{{$value['product_description']}}</td>
                            <td style="border: 1px solid #000000; text-align: right;" >{{number_format($value['product_qty02setup'], 2)}}</td>
                            <td style="border: 1px solid #000000; text-align: right;" >{{number_format($value['layout_qty'], 2)}}</td>
            
                            @foreach ($DATAsWip03->where('batch_no', $value['batch_no'])
                                                ->where('product_code', $value['product_code']) 
                                                ->where('layout_qty', $value['layout_qty']) 
                                                as $Wip03)
                                
                            <td style="border: 1px solid #000000; text-align: right;" >
                                {{$Wip03->product_qty03 == '0'? number_format(0, 2): number_format($Wip03->product_qty03, 2) }}</td>
                            
                                @foreach ($rec03 ->where('batch_no', $value['batch_no'])
                                                ->where('product_code', $value['product_code']) 
                                                ->where('layout_qty', $value['layout_qty']) 
                                                ->where('product_date',$Wip03->min_date)
                                                as $r03)    
                                    <td style="border: 1px solid #000000; text-align: right;" >
                                        {{$r03->receive_wip03 == '0'? number_format(0, 2): number_format($r03->receive_wip03 , 2)}}
                                    </td>

                                    <td style="border: 1px solid #000000; text-align: right;" >
                                        {{$Wip03->product_qty03+$r03->receive_wip03 == '0'? number_format(0, 2): number_format($Wip03->product_qty03+$r03->receive_wip03 , 2)}}</td>

                                @endforeach

                                
                            <td style="border: 1px solid #000000; text-align: right;" >
                                {{$Wip03->loss_qty03 == '0'? number_format(0, 2): number_format($Wip03->loss_qty03, 2) }}</td>
                            
                                @foreach ($tran03 ->where('batch_no', $value['batch_no'])
                                                ->where('product_code', $value['product_code']) 
                                                ->where('layout_qty', $value['layout_qty']) 
                                                ->where('product_date',$Wip03->max_date)
                                                as $t03)    
                                    <td style="border: 1px solid #000000; text-align: right;" >
                                        {{$t03->transfer_wip03 == '0'? number_format(0, 2): number_format($t03->transfer_wip03, 2) }}
                                    </td>

                                @endforeach
                            
                            
                            @endforeach

                            @foreach ($DATAsWip04->where('batch_no', $value['batch_no'])
                                                ->where('product_code', $value['product_code']) 
                                                ->where('layout_qty', $value['layout_qty']) 
                                                as $Wip04)
                            
                            <td style="border: 1px solid #000000; text-align: right;" >
                                {{$Wip04->product_qty04 == '0'? number_format(0, 2): number_format($Wip04->product_qty04, 2) }}</td>
                            
                                @foreach ($rec04 ->where('batch_no', $value['batch_no'])
                                                ->where('product_code', $value['product_code']) 
                                                ->where('layout_qty', $value['layout_qty']) 
                                                ->where('product_date',$Wip04->min_date)
                                                as $r04)    
                                    <td style="border: 1px solid #000000; text-align: right;" >
                                        {{$r04->receive_wip04 == '0'? number_format(0, 2): number_format($r04->receive_wip04, 2) }}
                                    </td>

                                    <td style="border: 1px solid #000000; text-align: right;" >
                                        {{$Wip04->product_qty04+$r04->receive_wip04 == '0'? number_format(0, 2): number_format($Wip04->product_qty04+$r04->receive_wip04 , 2)}}
                                    </td>

                                @endforeach
                            
                            
                            <td style="border: 1px solid #000000; text-align: right;" >
                                {{$Wip04->transfer_qty04 == '0'? number_format(0, 2): number_format($Wip04->transfer_qty04, 2) }}</td>
                                @foreach ($tran04 ->where('batch_no', $value['batch_no'])
                                                ->where('product_code', $value['product_code']) 
                                                ->where('layout_qty', $value['layout_qty']) 
                                                ->where('product_date',$Wip04->max_date)
                                                as $t04)    
                                    <td style="border: 1px solid #000000; text-align: right;" >
                                        {{$t04->transfer_wip04 == '0'? number_format(0, 2): number_format($t04->transfer_wip04, 2) }}
                                    </td>

                                @endforeach
                            @endforeach

                        </tr>
                    
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </body>
</html>