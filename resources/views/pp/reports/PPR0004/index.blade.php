<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> รายงานคงคลังบุหรี่ที่อยู่ในโกดังขาย </title>
	@include('pp.reports.PPR0004._style')
</head>
<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="table-responsive">
                    @php
                        $page_no = 0;
                        $lineLimit = 3;
                        $page = count(array_chunk($queryDatas->toArray(), $lineLimit));
                        $dataChunk = array_chunk($queryDatas->toArray(), $lineLimit);
                    @endphp
                    @foreach ($dataChunk as $values)
                    @php
                        $previousDate = isset($values[0])? date('Y-m-d', strtotime($values[0][0]['previous_date'])): date('Y-m-d');
                        $page_no++;
                    @endphp
                    <div style="page-break-after: always;"> </div>
                    @include('pp.reports.PPR0004.header')
                        <table class="table table-bordered" style=" border: #000000 solid 0.5px; padding: 0px; margin-top: 30px;">
                            <!-- header -->
                            <thead>
                                <tr style="font-size: 14px;">
                                    <th style="border:#000 0.5px solid; text-align: center; width: 12%;"> ตราบุหรี่ </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        คงคลังบุหรี่ระบบ AS/RS <br> (ล้านมวน)
                                    </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        โอนเข้าคงคลัง<br>กองผลิตภัณฑ์ <br> {{ formatLongDateThai($previousDate) }} <br> (ล้านมวน) 
                                    </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        ยอดจำหน่าย<br>วันที่ผลิต <br> {{ formatLongDateThai($previousDate) }} <br> (ล้านมวน) 
                                    </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        เฉลี่ยต่อวันย้อนหลัง 10 วันขาย <br> (ล้านมวน)
                                    </th> 
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        คงคลังในระบบ AS/RS <br> เพียงพอจำหน่าย (วัน)
                                    </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        ผลิตได้ในวันที่ผลิต <br> {{ formatLongDateThai($previousDate) }} <br> (ล้านมวน) 
                                    </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        ค้างส่งในวันที่ผลิต <br> {{ formatLongDateThai($previousDate) }} <br> (ล้านมวน) 
                                    </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        ประมาณการจำหน่ายรายปักษ์ <br> (ล้านมวน)
                                    </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 8%;">
                                        คงคลังตามประมาณตลาด <br> (ล้านมวน)
                                    </th>
                                    <th style="border:#000 0.5px solid; text-align: center; width: 10%;">
                                        วันที่บนซองบุหรี่
                                    </th>
                                </tr>
                            </thead>
                            <!-- Line -->
                            <tbody style="font-size: 14px;">
                                @foreach ($values as $lines)
                                    <tr>
                                        <th style="border:#000 0.5px solid; text-align: left;" colspan="11"> {{ $lines[0]['stamp_code'] }} : {{ $lines[0]['stamp_description'] }} </th>
                                    </tr>
                                    @foreach ($lines as $line)
                                        <tr>
                                            <td style="border:#000 0.5px solid; text-align: left;"> {{$line['item_description']}} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['curr_onhnad_qty'], 2) }} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['prev_onhand_qty'], 2) }} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['prev_sale_qty'], 2) }} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['forcast_qty'], 2) }} </td> 
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['onhand_for_sale'], 2) }} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['prev_wip_qty'], 2)}} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['remaining_qty'], 2)}} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['average_forecast_qty'], 2) }} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($line['asrs_for_market'], 2) }} </td>
                                            <td style="border:#000 0.5px solid; text-align: center;">
                                                @if ($productType == 'all')
                                                    {{ $line['previous_date_fm'] }}
                                                @elseif(isset($dateItem[$line['item_code']]))
                                                    {{ $dateItem[$line['item_code']] }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>




