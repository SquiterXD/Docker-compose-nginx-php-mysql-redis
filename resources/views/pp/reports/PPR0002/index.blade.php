<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    	@include('pp.reports.PPR0002._style')
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
            $lineLimit = 3;
            $dataP04 = array_chunk($DatasHead->toArray(), $lineLimit);
            $page = count($dataP04);
            $page_no = 0;
        @endphp
        @foreach ($dataP04 as $Heads)
            @php
                $page_no++;
            @endphp
            <div style="page-break-after: always;"> </div>
            @include('pp.reports.PPR0002.header')
            <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px; margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>ขอบเขต<Br>เครื่องจักร</th>
                        <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>รายละเอียด<Br>เครื่องจักร</th>
                        <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>ความเร็ว<Br>เครื่องจักรต่อ<Br>นาที (มวน)</th>
                        <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>ประสิทธิภาพ<Br>เครื่องจักร<br>(%)</th>
                        <th style="border:#000 0.5px solid; text-align: center;"colspan= {{count($WorkHour)}}>ชม.ทำงานจริง (ชม.)</th>
                        <th style="border:#000 0.5px solid; text-align: center;"colspan= {{count($WorkHour)}}>กำลังการผลิต (ล้านมวน)</th>
                        <th style="border:#000 0.5px solid; text-align: center;"colspan= {{count($WorkHour)}}>จำนวนวันทำงาน (วัน)</th>
                        <th style="border:#000 0.5px solid; text-align: center;"rowspan=3>สั่งผลิต<br>(ล้านมวน)</th>
                    </tr>
                    <tr>
                    @foreach($WorkHour as $wh)
                        <th style="border:#000 0.5px solid; text-align: center;" rowspan=2 > {{$wh->working_hour}} <br> ชั่วโมง</th>
                    @endforeach
                    @foreach($WorkHour as $wh)
                        <th style="border:#000 0.5px solid; text-align: center;"rowspan=2 > {{$wh->working_hour}} <br> ชั่วโมง</th>
                    @endforeach
                    @foreach($WorkHour as $wh)
                        <th style="border:#000 0.5px solid; text-align: center;"rowspan=2 > {{$wh->working_hour}} <br> ชั่วโมง</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($Heads as $Head)
                    <tr> 
                        <td style="border:#000 0.5px solid; text-align: center;" rowspan={{count($Head)}} >
                            {{ $Head[0]['machine_group_desc'] }}
                        </td>
                        @foreach ($Head as $line)
                            @php
                                $res = 0
                            @endphp
                            <td style="border:#000 0.5px solid; text-align: center;"> {{ $line['machine_description'] }} </td>
                            <td style="border:#000 0.5px solid; text-align: center;"> {{ number_format($line['machine_speed'], 2) }} </td>
                            <td style="border:#000 0.5px solid; text-align: center;"> {{ $line['machine_eamperformance']}} </td>
                            @foreach($WorkHour as $wh)
                                @php
                                    $res += $Efficiency[$line['machine_name']][$wh->working_hour] * $TotalDays[$line['machine_name']][$wh->working_hour];
                                @endphp
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{ $WorkingHour[$line['machine_name']][$wh->working_hour] }}
                                </td>
                            @endforeach
                            @foreach($WorkHour as $wh)
                                <td style="border:#000 0.5px solid; text-align: center;"> {{ $Efficiency[$line['machine_name']][$wh->working_hour] }} </td>
                            @endforeach
                            @foreach($WorkHour as $wh)
                                <td style="border:#000 0.5px solid; text-align: center;"> {{ $TotalDays[$line['machine_name']][$wh->working_hour] }} </td>
                            @endforeach
                            <td style="border:#000 0.5px solid; text-align: center;"> {{ $res }} </td>
                        </tr>
                        @endforeach
                    </tr>
                    @endforeach 
                </tbody>
            </table>
        @endforeach
    </body>
</html>