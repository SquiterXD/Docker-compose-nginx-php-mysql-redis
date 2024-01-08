<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	@include('pp.reports.PPR0003._style')
    <style>
        .table_data{
            border-collapse: collapse;
            height: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    @php
        $lineLimit =12;
        $dataP03 = array_chunk($dataHeads->toArray(), $lineLimit);
        $page = count($dataP03)+1;
        $page_no = 0;
    @endphp
 
    @foreach ($dataP03 as $Heads)
        @php
            $page_no++;
        @endphp
        <div style="page-break-after: always;"></div>
        @include('pp.reports.PPR0003.header')
        <table style="border: #000000 solid 0.5px; padding: 5px;;width: 100%;">
            <tr>
                <th style=" border: none; text-align: center; width:10%"></th>
                @foreach($biweeklyHead as $bw)
                    @if($loop->first) 
                        <th style="text-align: right;" colspan=5> เหลือวันขาย (วัน) : {{ $bw->curr_sale_days }}  เหลือวันผลิต (วัน) : 0 </th>
                    @endif
                    @if(!$loop->first) 
                        <th style="text-align: right;" colspan=4> วันขาย (วัน) : {{ $bw->curr_sale_days }} วันผลิต (วัน) : 0 </th>
                    @endif
                @endforeach
            </tr>
        </table>
        <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px;;width: 100%;">
            <thead>
                <tr>
                    <th style="border:#000 0.5px solid; text-align: center; width:15%" rowspan = 5>ตราบุหรี่</th>
                    @foreach($biweeklyHead as $bw)
                        @if($loop->first) 
                            <th style="border:#000 0.5px solid; text-align: center;" colspan = 5>ปักษ์ {{$bw->p_biweekly}} (ปักษ์ปัจจุบัน)</th>
                        @endif
                        @if(!$loop->first) 
                            <th style="border:#000 0.5px solid; text-align: center;" colspan = 4>ปักษ์ {{$bw->p_biweekly}}</th>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    @foreach($biweeklyHead as $bwd)
                        @if($loop->first) 
                            <th style="border:#000 0.5px solid; text-align: center;" colspan = 5>{{$bwd->thai_combine_date}}</th>
                        @endif
                        @if(!$loop->first) 
                            <th style="border:#000 0.5px solid; text-align: center;" colspan = 4>{{$bwd->thai_combine_date}}</th>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    @foreach($biweeklyHead as $x)
                        @if($loop->first) 
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>คงคลังปัจจุบัน<br>(ล้านมวน)</th>
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>ประมาณการผลิต<br>(ล้านมวน)</th>
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>ประมาณการจำหน่าย<br>(ล้านมวน)</th>
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>คงคลังสิ้นปักษ์<br>(ล้านมวน)</th>
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>จำนวนวันพอจำหน่าย<br>(วัน)</th>
                        @endif
                        @if(!$loop->first) 
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>ประมาณการผลิต<br>(ล้านมวน)</th>
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>ประมาณการจำหน่าย<br>(ล้านมวน)</th>
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>คงคลังสิ้นปักษ์<br>(ล้านมวน)</th>
                            <th style="border:#000 0.5px solid; text-align: center;"rowspan=2>จำนวนวันพอจำหน่าย<br>(วัน)</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($Heads as $Head)
                    <tr>
                        <td style="border:#000 0.5px solid; text-align: left;">
                            {{ $Head[0]['item_description'] }}
                        </td>
                        @foreach($biweeklyHead as $bw)
                            @if($loop->first) 
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($CURR_ONHNAD_QTY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($PLANNING_QTY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($FORCAST_QTY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($BAL_ONHAND_QTY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($ENDING_SALE_DAY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                            @endif
                            @if(!$loop->first) 
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($PLANNING_QTY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($FORCAST_QTY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($BAL_ONHAND_QTY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                                <td style="border:#000 0.5px solid; text-align: center;">
                                    {{  number_format($ENDING_SALE_DAY[ $Head[0]['item_description']][$bw->p_biweekly],2)}}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            @if($loop->last) 
                <tr> 
                    <td style="border:#000 0.5px solid; text-align: center;">
                        <b>รวม</b>
                    </td>
                    @foreach($biweeklyHead as $bw)
                        @if($loop->first) 
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_CURR_ONHNAD_QTY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_PLANNING_QTY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_FORCAST_QTY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_BAL_ONHAND_QTY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_ENDING_SALE_DAY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                        @endif
                        @if(!$loop->first) 
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_PLANNING_QTY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_FORCAST_QTY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_BAL_ONHAND_QTY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                            <td style="border:#000 0.5px solid; text-align: center;">
                                <b>{{  number_format($SUM_ENDING_SALE_DAY[$bw->p_biweekly][$bw->p_biweekly],2)}}</b>
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endif
        </table>
    @endforeach
    <!-- --------------------------------------------------------------------------------- -->
    @php
        $page_no++;
    @endphp
    <div style="page-break-after: always;"></div>
    @include('pp.reports.PPR0003.header')
    <table class="table_data" style="border: #000000 solid 0.5px; padding: 5px; margin-top: 20px;">
        <thead>
            <tr>
                <th style="border:#000 0.5px solid; text-align: center; width:15%" rowspan = 2>กำลังผลิตที่</th>
                @foreach($biweeklyHead as $bw)
                    @if($loop->first) 
                        <th style="border:#000 0.5px solid; text-align: center;" colspan = 3>ปักษ์ {{$bw->p_biweekly}} (ปักษ์ปัจจุบัน)</th>
                    @endif
                    @if(!$loop->first) 
                        <th style="border:#000 0.5px solid; text-align: center;" colspan = 3>ปักษ์ {{$bw->p_biweekly}}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($biweeklyHead as $x)
                    <th style="border:#000 0.5px solid; text-align: center; width:5%">มีล่วงเวลากลางวัน</th>
                    <th style="border:#000 0.5px solid; text-align: center; width:5%">มีล่วงเวลากลางวัน<br>และกลางคืน</th>
                    <th style="border:#000 0.5px solid; text-align: center; width:5%">รวม</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border:#000 0.5px solid; text-align: center;">
                    <b>จำนวนวัน (วัน)</b>
                </td>
                @foreach($biweeklyHead as $bw)
                    <td style="border:#000 0.5px solid; text-align: center;">
                        {{  number_format($total_wk_overtime_d[$bw->p_biweekly][$bw->p_biweekly],2)}}
                    </td>
                    <td style="border:#000 0.5px solid; text-align: center;">
                        {{  number_format($total_wk_overtime_n[$bw->p_biweekly][$bw->p_biweekly],2)}}
                    </td>
                    <td style="border:#000 0.5px solid; text-align: center;">
                        {{ number_format($total_wk_overtime_d[$bw->p_biweekly][$bw->p_biweekly]
                            + $total_wk_overtime_n[$bw->p_biweekly][$bw->p_biweekly], 2) }}
                    </td>
                @endforeach
            </tr>
            <tr>
                <td style="border:#000 0.5px solid; text-align: center;">
                    <b>กำลังผลิตรวม (ล้านมวน)</b>
                </td>
                @foreach($biweeklyHead as $bw)
                    <td style="border:#000 0.5px solid; text-align: center;">
                        {{  number_format($efficiency_product_d[$bw->p_biweekly][$bw->p_biweekly],2)}}
                    </td>
                    <td style="border:#000 0.5px solid; text-align: center;">
                        {{  number_format($efficiency_product_n[$bw->p_biweekly][$bw->p_biweekly],2)}}
                    </td>
                    <td style="border:#000 0.5px solid; text-align: center;">
                        {{ number_format($efficiency_product_d[$bw->p_biweekly][$bw->p_biweekly]
                            + $efficiency_product_n[$bw->p_biweekly][$bw->p_biweekly], 2) }}
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</body>
</html>