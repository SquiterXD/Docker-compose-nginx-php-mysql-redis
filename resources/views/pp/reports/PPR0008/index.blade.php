<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	@include('pp.reports.PPR0008._style')
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
        $pageNo = 0;
        $limit = 4;
        $data = array_chunk($datas->toArray(), $limit);
        $page = count($data);
    @endphp

    @foreach ($data as $stamp)
        @php
            $pageNo++;
        @endphp
        @include('pp.reports.PPR0008.header')
        <br>
        <table class="table_data">
        <thead>
            <tr>
                <th style="border: 1px solid #000000; text-align: center; width: 25%; height: 35px;"> หน่วย </th>
                <th style="border: 1px solid #000000; text-align: center; width: 25%; height: 35px;"> จำนวน </th>
                <th style="border: 1px solid #000000; text-align: center; width: 25%; height: 35px;"> ราคาต่อหน่วย(บาท) </th>
                <th style="border: 1px solid #000000; text-align: center; width: 25%; height: 35px;"> มูลค่ารวม </th>
            </tr>
        </thead>
        @foreach ($stamp as $key => $value)
        <tbody>
            <tr>
                <td style="border: 1px solid #000000; text-align: left; height: 40px;" colspan=4>
                    <b>{{$value['0']['stamp_description']}}</b>
                </td>
            </tr>
            <tr> 
                <td style="border: 1px solid #000000; text-align: center; " > {{$value['0']['type_stamp'] == 'roll'? 'ม้วน': 'แผ่น'}} </td>
                <td style="border: 1px solid #000000; text-align: center; " > {{number_format($value['0']['qty'],2)}} </td>
                <td style="border: 1px solid #000000; text-align: center; " > {{number_format($value['0']['unit_price'],2)}} </td>
                <td style="border: 1px solid #000000; text-align: center; " > {{number_format($value['0']['sum_value'],2)}} </td>
            </tr>
            <tr> 
                <td style="border: 1px solid #000000; text-align: center; " > {{$value['1']['type_stamp'] == 'roll'? 'ม้วน': 'แผ่น'}} </td>
                <td style="border: 1px solid #000000; text-align: center; " > {{number_format($value['1']['qty'],2)}} </td>
                <td style="border: 1px solid #000000; text-align: center; " > {{number_format($value['1']['unit_price'],2)}} </td>
                <td style="border: 1px solid #000000; text-align: center; " > {{number_format($value['1']['sum_value'],2)}} </td>
            </tr>
        </tbody>
        @endforeach
    @endforeach
</table>

</body>
</html>




