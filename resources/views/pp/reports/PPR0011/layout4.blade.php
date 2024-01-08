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
        $lineLimit = 15 ;
        $dataP11 = array_chunk($datas23Biweek->toArray() , $lineLimit);
        $cnt = 0;
    @endphp

    @foreach ($dataP11 as $data)

    @if( $flagKK == 1 )
        @php
            $page_no++;
        @endphp
        <div style="page-break-after: always;"> </div> 
        @include('pp.reports.PPR0011.header') 
    @endif

    @if($flagKK == 0 )
        @php
            $flagKK = 1 
        @endphp
    @endif
        <table style="width: 100%;"> 
            <tr>
                <th style=" text-align: right; width: 100%;"><b>หน่วย (ล้านชิ้น)</b></th>
            </tr>
        </table>
        <table class="table_data" style="border: #000000 solid 0.5px; ">
            <thead>
                <tr>
                    <th style="border:#000 0.5px solid; text-align: center; width: 3%;">ลำดับที่</th>
                    <th style="border:#000 0.5px solid; text-align: center; width: 20%;">ชนิดก้นกรอง</th>
                    <th style="border:#000 0.5px solid; text-align: center; width: 5%;">คำสั่งผลิตเดิม</th>
                    <th style="border:#000 0.5px solid; text-align: center; width: 5%;">คำสั่งผลิตที่ขอปรับ</th>
                    <th style="border:#000 0.5px solid; text-align: center; width: 5%;">คิดว่าจะได้ผลผลิต</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $da)
                    @php
                        $cnt++;
                    @endphp
                    <tr>
                        <td style="border:#000 0.5px solid; text-align: center; width:10px ; ">{{ $cnt }}</td>
                        <td style="border:#000 0.5px solid; text-align: left;width: 320px ;">{{ $da['item_description'] }}</td>
                        <td style="border:#000 0.5px solid; text-align: center;width: 190px;">
                            {{ number_format(isset($EstimateProduct[$da['item_code']][0]) ?? 0, 2) }}
                        </td>
                        <td style="border:#000 0.5px solid; text-align: center;width: 190px;">
                            {{ number_format(isset($DefEstimateProduct[$da['item_code']][0]) ?? 0, 2) }}
                        </td>
                        <td style="border:#000 0.5px solid; text-align: center;width: 190px;">
                            {{ number_format(isset($DefEstimateProduct[$da['item_code']][0]) ?? 0 * $efficiencyProduct, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>



