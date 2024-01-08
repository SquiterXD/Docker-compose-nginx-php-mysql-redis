<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @include('ct.Reports.ctr0034._style')

 
    </head>
    <body>
    <table >
    @include('ct.Reports.ctr0034.header')
        <thead>
            <tr>
                <th style="border: 1px solid #000000; text-align: center; width: 200px;" rowspan=4><b>รหัส</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 200px;" rowspan=4><b>รายละเอียด</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 200px;" rowspan=4><b>ปริมาณผลผลิต</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=1 colspan =2><b>ค่าวัตถุดิบ - มาตราฐาน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=1 colspan =3><b>ค่าวัตถุดิบ - เบิกใช้จริง</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=4><b>ค่าวัตถุดิบ <br> คิดเข้างาน <br> </b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=1 colspan =4><b>ผลต่างวัตถุดิบ</b></th>
            </tr>
            <tr>
              

                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=3><b>ปริมาณ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=3><b>ต้นทุน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=3><b>ปริมาณ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=3><b>ราคาต่อหน่วย</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=3><b>ต้นทุน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" colspan=2><b>ผลต่าง - ปริมาณ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" colspan=1><b>ผลต่าง - ราคา</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=3><b>รวมผลต่าง</b></th>

            </tr>
            <tr>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;height: 50px;" rowspan=2><b>ปริมาณ</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2><b>ต้นทุน</b></th>
                <th style="border: 1px solid #000000; text-align: center; width: 100px;" rowspan=2><b>ต้นทุน</b></th>                
            </tr>
            <tr></tr>
            <tr>
                <th style=" text-align: center; " colspan=2></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>ก.ก</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>ก.ก</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>บาท(A)</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>ก.ก</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>บาท</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>บาท(B)</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>บาท(C)</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>ก.ก</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>บาท(C)-(A)</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>บาท(B)-(C)</b></th>
                <th style="border: 1px solid #000000; text-align: center; " rowspan=2 ><b>บาท(B)-(A)</b></th>             
            </tr>
           
        </thead>
        <tbody>

        @foreach ($seasons as $key => $ss)
            <tr>
                    <td style=" text-align: left; " colspan = 2><b>ฤดู {{$key}}</b></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" text-align: center; " ></td>
                    <td style=" border-right: 1px solid #000000;text-align: center; " ></td>
                    
            </tr>
            @foreach ($datas -> where('season', $key) as $da)
        
            <tr>
                    <td style="border: 1px solid #000000; text-align: left; " >{{$da->item_no}}</td>
                    <td style="border: 1px solid #000000; text-align: left; " >{{$da->item_desc}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{$da->prod_cost}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{$da->iss_std_qty == '0'? number_format(0,2): $da->iss_std_qty}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{$da->iss_std_cost == '0'? number_format(0,2): $da->iss_std_cost}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{$da->transaction_quantity == '0'? number_format(0,2): $da->transaction_quantity}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{$da->value_qty == '0'? number_format(0,2): $da->value_qty}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{$da->transaction_value == '0'? number_format(0,2): $da->transaction_value}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{$da->absorbtion_amount == '0'? number_format(0,2): $da->absorbtion_amount}}</td>
                    @if($da->transaction_quantity == 0 || $da->transaction_quantity == null)
                    <td style="border: 1px solid #000000; text-align: right; " > {{number_format(0,2)}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " > {{number_format(0,2)}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " > {{number_format(0,2)}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " > {{number_format(0,2)}}</td>
                    @else
                    <td style="border: 1px solid #000000; text-align: right; " >{{($da->iss_std_qty - $da->transaction_quantity) < 0        ? '(' . number_format(($da->iss_std_qty - $da->transaction_quantity)*-1,2) . ')' : ($da->iss_std_qty - $da->transaction_quantity)}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{($da->absorbtion_amount - $da->iss_std_cost) < 0          ? '(' . number_format(($da->absorbtion_amount - $da->iss_std_cost)*-1,2) . ')' : ($da->absorbtion_amount - $da->iss_std_cost)}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{($da->transaction_value - $da->absorbtion_amount) < 0     ? '(' . number_format(($da->transaction_value - $da->absorbtion_amount)*-1,2) . ')':($da->transaction_value - $da->absorbtion_amount)}}</td>
                    <td style="border: 1px solid #000000; text-align: right; " >{{($da->transaction_value - $da->iss_std_cost) < 0          ? '(' . number_format(($da->transaction_value - $da->iss_std_cost)*-1,2) . ')':($da->transaction_value - $da->iss_std_cost)}} </td>
                    @endif

                                                
            </tr>

            @endforeach 
         
            <tr>
                    <td style=" border: 1px solid #000000;text-align: left; " colspan = 2><b>รวม</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$ss[0]->product_qty}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$ss[0]->iss_std_qty}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$ss[0]->iss_std_cost}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$ss[0]->transaction_quantity}}</b></td>
       
                    @if($ss[0]->transaction_quantity == 0 || $ss[0]->transaction_quantity == null)
                    <td style=" border: 1px solid #000000;text-align: right; " ><b> </b></td>
                    @else
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$ss[0]->transaction_value / $ss[0]->transaction_quantity}}</b></td>
                    @endif
             
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$ss[0]->transaction_value }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$ss[0]->absorbtion_amount == '0'? number_format(0,2): $ss[0]->absorbtion_amount}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{($ss[0]->iss_std_qty - $ss[0]->transaction_quantity) < 0 ? '(' . number_format(($ss[0]->iss_std_qty - $ss[0]->transaction_quantity)*-1,6) . ')' :($ss[0]->iss_std_qty - $ss[0]->transaction_quantity) }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{($ss[0]->absorbtion_amount - $ss[0]->iss_std_cost) < 0 ? '(' . number_format(($ss[0]->absorbtion_amount - $ss[0]->iss_std_cost)*-1,2) . ')' :($ss[0]->absorbtion_amount - $ss[0]->iss_std_cost) }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{($ss[0]->transaction_value - $ss[0]->absorbtion_amount) < 0 ? '(' . number_format(($ss[0]->transaction_value - $ss[0]->absorbtion_amount)*-1,2) . ')' :($ss[0]->transaction_value - $ss[0]->absorbtion_amount) }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{($ss[0]->transaction_value - $ss[0]->iss_std_cost) < 0 ? '(' . number_format(($ss[0]->transaction_value - $ss[0]->iss_std_cost)*-1,2) . ')' :($ss[0]->transaction_value - $ss[0]->iss_std_cost) }}</b></td>
                    
            </tr>
            @if($loop->last) 
                @foreach ($sumRpt as $rpt)
                <tr>
                    <td style=" border: 1px solid #000000;text-align: left; " colspan = 2><b>รวมทั้งสิ้น</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->product_qty}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->iss_std_qty}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->iss_std_cost}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->transaction_quantity}}</b></td>
                    @if($rpt->transaction_quantity == 0 || $rpt->transaction_quantity == null)
                    <td style=" border: 1px solid #000000;text-align: right; " ><b> </b></td>
                    @else
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->transaction_value / $rpt->transaction_quantity}}</b></td>
                    @endif
                    
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->transaction_value }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{$rpt->absorbtion_amount == '0'? number_format(0,2): $rpt->absorbtion_amount}}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{($rpt->iss_std_qty - $rpt->transaction_quantity) < 0 ? '(' . number_format(($rpt->iss_std_qty - $rpt->transaction_quantity)*-1,6) . ')' :($rpt->iss_std_qty - $rpt->transaction_quantity) }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{($rpt->absorbtion_amount - $rpt->iss_std_cost) < 0 ? '(' . number_format(($rpt->absorbtion_amount - $rpt->iss_std_cost)*-1,2) . ')' :($rpt->absorbtion_amount - $rpt->iss_std_cost) }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{($rpt->transaction_value - $rpt->absorbtion_amount) < 0 ? '(' . number_format(($rpt->transaction_value - $rpt->absorbtion_amount)*-1,2) . ')' :($rpt->transaction_value - $rpt->absorbtion_amount) }}</b></td>
                    <td style=" border: 1px solid #000000;text-align: right; " ><b>{{($rpt->transaction_value - $rpt->iss_std_cost) < 0 ? '(' . number_format(($rpt->transaction_value - $rpt->iss_std_cost)*-1,2) . ')' :($rpt->transaction_value - $rpt->iss_std_cost) }}</b></td>
                </tr>
                @endforeach
            @endif
        @endforeach 

        </tbody>


  

    </table>
       
    </body>
</html>