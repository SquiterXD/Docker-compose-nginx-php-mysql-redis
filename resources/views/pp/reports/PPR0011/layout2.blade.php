<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	@include('pp.reports.PPR0011._style')
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
        $lineLimit = 20;
        $dataP11 = array_chunk($datas->toArray(), $lineLimit);
        $cnt = 0;
        $V_curr_onhnad_qty = 0;
        $V_planning_qty = 0;
        $V_forcast_qty = 0 ;
        $V_bal_onhand_qty = 0;
        $V_ending_sale_day =0;
    @endphp

    @foreach ($dataP11 as $data)
        @php
            $page_no++;
        @endphp
        <div style="page-break-after: always;"></div>
        @include('pp.reports.PPR0011.header') 
            <table style="width: 100%;"> 
                <tr>
                    <th style=" text-align: left; width: 50%;"><b>แผนการผลิตหลังปรับคำสั่งผลิต</b></th>
                    <th style=" text-align: right; width: 50%;"><b>หน่วย (ล้านมวน)</b></th>
                </tr>
            </table>
            <table class="table_data" style="border: #000000 solid 0.5px; ">
                <thead>
                    <tr>
                        <th style="border:#000 0.5px solid; text-align: center; width: 3%;" rowspan=2>ลำดับที่</th>
                        <th style="border:#000 0.5px solid; text-align: center; width: 12%;" rowspan=2>ตราบุหรี่</th>
                        <th style="border:#000 0.5px solid; text-align: center; width: 6%;" rowspan=2>คงคลังบุหรี่เช้า<br>{{$dateInfo->thai_start_date}}</th>
                        <th style="border:#000 0.5px solid; text-align: center; width: 6%;" colspan=2>{{$dateInfo->thai_combine_date}}</th>
                        <th style="border:#000 0.5px solid; text-align: center; width: 6%;" rowspan=2>คงคลังบุหรี่เช้า<br>{{$dateInfo->thai_start_date_next}}</th>
                        <th style="border:#000 0.5px solid; text-align: center; width: 6%;" rowspan=2>คงคลังพอจำหน่าย<br>(วัน)</th>
                    </tr>
                    <tr>
                        <th style="border:#000 0.5px solid; text-align: center; ">ผลิต</th>
                        <th style="border:#000 0.5px solid; text-align: center; ">จำหน่าย</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data as $da)
                    @php
                        $cnt = $cnt+1;
                    @endphp
                    <tr>
                        <td style="border:#000 0.5px solid; text-align: center; ">{{$cnt}}</td>
                        <td style="border:#000 0.5px solid; text-align: left; ">{{$da['item_description']}}</td>
                        <td style="border:#000 0.5px solid; text-align: center; ">{{number_format($da['adj_curr_onhnad_qty'],2)}}</td>
                        <td style="border:#000 0.5px solid; text-align: center; ">{{number_format($da['def_planning_qty'],2)}}</td>
                        <td style="border:#000 0.5px solid; text-align: center; ">{{number_format($da['def_forcast_qty'],2)}}</td>
                        <td style="border:#000 0.5px solid; text-align: center; ">{{number_format($da['def_bal_onhand_qty'],2)}}</td>
                        <td style="border:#000 0.5px solid; text-align: center; ">{{number_format($da['def_ending_sale_day'],2)}}</td>
                    </tr>
                    @php
                        $V_curr_onhnad_qty = $V_curr_onhnad_qty + $da['adj_curr_onhnad_qty'];
                        $V_planning_qty = $V_planning_qty + $da['def_planning_qty'];
                        $V_forcast_qty = $V_forcast_qty + $da['def_forcast_qty'] ;
                        $V_bal_onhand_qty = $V_bal_onhand_qty + $da['def_bal_onhand_qty'] ;
                        $V_ending_sale_day = $V_ending_sale_day + $da['def_ending_sale_day'] ;
                    @endphp
                    @if(count($data) < $lineLimit)
                        @if($loop->last)
                        <tr>
                            <th style="border:#000 0.5px solid; text-align: center; " colspan =2 >รวม</th>
                            <th style="border:#000 0.5px solid; text-align: center; ">{{number_format($V_curr_onhnad_qty,2)}}</th>
                            <th style="border:#000 0.5px solid; text-align: center; ">{{number_format($V_planning_qty,2)}}</th>
                            <th style="border:#000 0.5px solid; text-align: center; ">{{number_format($V_forcast_qty,2) }}</th>
                            <th style="border:#000 0.5px solid; text-align: center; ">{{number_format($V_bal_onhand_qty,2)}}</th>
                            <th style="border:#000 0.5px solid; text-align: center; ">{{number_format($V_ending_sale_day,2)}}</th>
                        </tr>
                        @endif
                    @endif
                @endforeach 
            </tbody>
        </table>
    @endforeach
    <div style="page-break-after: always;"> </div>
    @include('pp.reports.PPR0011.layout3')
</body>
</html>



