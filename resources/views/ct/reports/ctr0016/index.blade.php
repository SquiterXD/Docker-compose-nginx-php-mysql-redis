<!DOCTYPE html>
<html>
    <head>
    <style>
        table {
  border-collapse: collapse;
}
    </style>
    </head>

    <body>
        <!-- header report -->
        @foreach ($DATAs as $key => $value)
        <table>
            <tr>
                <td style="text-align: center; " colspan=14></td>
            </tr>
            <tr>
                <td style="text-align: left; " colspan=2 ></td>
                <td style="text-align: center; " colspan=10 ><b>การยาสูบแห่งประเทศไทย</b></td>
                <td style="text-align: left; " colspan=2 ></td>
            </tr>
            <tr>
                <td style="text-align: left; " colspan=2 ><b>รหัสโปรแกรม</b> : CTR0016</td>
                <td style="text-align: center; " colspan=10 ><b>รายงานต้นทุนการผลิตสินค้าสำเร็จรูปต่อหน่วย</b></td>
                <td style="text-align: right; " colspan=2 ><b>วันที่พิมพ์</b> : {{$ldate}} {{$time}}</td>
            </tr>
            <tr>
                <td style="text-align: left; " colspan=2><b>ศูนย์ต้นทุน</b> : {{$v_cost_code}} {{$value->cost_desc}}</td>
                <td style="text-align: center; " colspan=10 ><b>ตั้งแต่วันที่ {{$DatefromTH}} ถึงวันที่ {{$DatetoTH}} </b></td>
                <td style="text-align: right; " colspan=2 ></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="border: 1px solid #000000; text-align: center; " rowspan=3 ><b>รหัส</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 300px;" rowspan=3 ><b>รายละเอียด</b></td>
                <td style="border: 1px solid #000000; text-align: center; " rowspan=3 ><b>หน่วยนับ</b></td>
                <td style="border: 1px solid #000000; text-align: center; " colspan=6 ><b>สินค้าสำเร็จรูป</b></td>
                <td style="border: 1px solid #000000; text-align: center; " colspan=5 ><b>ต้นทุนผลิตสินค้าสำเร็จรูปต่อหน่วย</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ค่าวัตถุดิบ<BR>บาท</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ค่าแรง<BR>บาท</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ค่าใช้จ่ายการผลิตผันแปร<BR>บาท</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ค่าใช้จ่ายการผลิตคงที่<BR>บาท</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ปริมาณผลผลิต</b></td>  
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>รวมเป็นเงิน<BR>บาท</b></td>

                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ค่าวัตถุดิบ<BR>บาท</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ค่าแรง<BR>บาท</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ค่าใช้จ่ายการผลิตผันแปร<BR>บาท</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>ค่าใช้จ่ายการผลิตคงที่<BR>บาท</b></td>
                <td style="border: 1px solid #000000; text-align: center; width: 150px;" rowspan=2><b>รวมเป็นเงิน<BR>บาท</b></td>
            </tr>
            </table>

            
            <table>
           
            <!-- <tr>
                <td style="border: 1px solid #000000; text-align: center; " colspan=14 ></td>
            </tr> -->
            <tr>
                <td style="border: 1px solid #000000; text-align: center; " colspan=2><b>{{ $value->dept_code}}  {{ $value->dept_code_desc}}</b></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
            </tr>

                    @foreach ($DATAsLine->where('dept_code', $value->dept_code) as   $Line)
                    <tr>
                        <td style="border: 1px solid #000000; text-align: left; ">{{$Line->item_number}}</td>
                        <td style="border: 1px solid #000000; text-align: left; ">{{$Line->item_desc}}</td>
                        <td style="border: 1px solid #000000; text-align: center; ">{{$Line->transaction_uom}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->ingredient_amount}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->wage_amount}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->vary_amount}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->fixed_amount}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->transaction_quantity}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->ingredient_amount+$Line->fixed_amount}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->ingredient_amount/$Line->transaction_quantity}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->wage_amount/$Line->transaction_quantity}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->vary_amount/$Line->transaction_quantity}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{$Line->fixed_amount/$Line->transaction_quantity}}</td>
                        <td style="border: 1px solid #000000; text-align: right; ">{{($Line->ingredient_amount+$Line->fixed_amount)/$Line->transaction_quantity}}</td>
                    </tr>
                    @endforeach
            <tr>
                <td style="border: 1px solid #000000; text-align: center; " colspan=2><b>รวมตามหน่วยงาน {{ $value->dept_code}}  {{ $value->dept_code_desc}}</b></td>
                <td style="border: 1px solid #000000; text-align: center; "></td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_amount}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_wage_amount}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_vary_amount}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_fixed_amount}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_qty}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_amount+$value->sum_fixed_amount}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_amount/$value->sum_qty}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_wage_amount/$value->sum_qty}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_vary_amount/$value->sum_qty}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{$value->sum_fixed_amount/$value->sum_qty}}</td>
                <td style="border: 1px solid #000000; text-align: right; ">{{($value->sum_amount+$value->sum_fixed_amount)/$value->sum_qty}}</td>
            
            </tr>
            
            </table>
            @endforeach
    </body>
</html>