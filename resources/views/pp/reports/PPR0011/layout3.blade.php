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
        $lineLimit = 20 ;
        $dataP11 = array_chunk($datas->toArray(), $lineLimit);
        $cnt = 0;
        $cnt_pro =0;
        $sum_planning_qty = 0 ; 
        $sum_def_planning_qty = 0;
        $sum_cal_def_plan = 0 ;
        $flagKK = 0;
    @endphp
    @foreach ($dataP11 as $data)
        <div style="page-break-after: always;"></div>
        @php
            $page_no++;
        @endphp
        @include('pp.reports.PPR0011.header') 
        <table style="width: 100%;"> 
            <tr>
                <th style=" text-align: left; width: 50%;"><b>แผนการปรับคำสั่งผลิต</b></th>
                <th style=" text-align: right; width: 50%;"><b>หน่วย (ล้านมวน)</b></th>
            </tr>
        </table>
        <table class="table_data" style="border: #000000 solid 0.5px; ">
            <thead>
                <tr>
                    <th style="border:#000 0.5px solid; text-align: center; width: 3%;">ลำดับที่</th>
                    <th style="border:#000 0.5px solid; text-align: center; width: 12%;">ตราบุหรี่</th>
                    <th style="border:#000 0.5px solid; text-align: center; width: 6%;">คำสั่งผลิตเดิม</th>
                    <th style="border:#000 0.5px solid; text-align: center; width: 6%;">คำสั่งผลิตที่ขอปรับ</th>
                    <th style="border:#000 0.5px solid; text-align: center; width: 6%;">คิดว่าจะได้ผลผลิต</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $da)
                    @php
                        $cnt_pro++;
                        $cnt++;
                        $cnt_line = count($data);
                    @endphp
                    <tr>
                        <td style="border:#000 0.5px solid; text-align: center; width: 10px ; ">{{$cnt}}</td>
                        <td style="border:#000 0.5px solid; text-align: left; width: 320px ; "  >{{$da['item_description']}}</td>
                        <td style="border:#000 0.5px solid; text-align: center; width: 190px; ">{{number_format($da['planning_qty'],2)}}</td>
                        <td style="border:#000 0.5px solid; text-align: center; width: 190px;">{{number_format($da['def_planning_qty'],2)}}</td>
                        <td style="border:#000 0.5px solid; text-align: center; width: 190px;">{{number_format($da['def_planning_qty'] * ($da['efficiency_product']/100),2)}}</td>
                    </tr>
                    @php
                        $sum_planning_qty = $sum_planning_qty + number_format($da['planning_qty'],2) ; 
                        $sum_def_planning_qty = $sum_def_planning_qty + number_format($da['def_planning_qty'],2);
                        $sum_cal_def_plan = $sum_cal_def_plan + number_format($da['def_planning_qty'] / ($da['efficiency_product']/100),2) ;
                    @endphp
                    @if($cnt_pro == $da['cnt_product'] ) 
                        <tr>
                            <td style="border:#000 0.5px solid; text-align: center; " colspan =2><b>รวม{{$da['product_type_desc']}}</b></td>
                            <td style="border:#000 0.5px solid; text-align: center; "><b>{{$sum_planning_qty}}</b></td>
                            <td style="border:#000 0.5px solid; text-align: center; "><b>{{$sum_def_planning_qty}}</b></td>
                            <td style="border:#000 0.5px solid; text-align: center; "><b>{{$sum_cal_def_plan}}</b></td>
                        </tr>
                        @php
                            $cnt_pro = 0;
                            $sum_planning_qty = 0 ; 
                            $sum_def_planning_qty = 0;
                            $sum_cal_def_plan = 0 ;
                        @endphp
                    @endif
                @endforeach
            </tbody>
        </table>
    @endforeach
    @if($cnt_line ?? 0 + $cntBi23 > 10 )
        <div style="page-break-after: always;"> </div> 
        @php
            $flagKK = 1;
        @endphp
    @endif
    @include('pp.reports.PPR0011.layout4')
</body>
</html>



