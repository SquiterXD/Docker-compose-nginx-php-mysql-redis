
    <table  width="100%" style="font-size: 12px; ">
        <thead >
            <tr style="border-bottom: 0.5px solid #000; border-top: 0.5px solid #000;">
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    ศูนย์ต้นทุน 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    กลุ่มสินค้า 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    ความกว้าง x ความยาว (ซม.) 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    จำนวนครั้งของการพิมพ์ 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    พื้นที่ของการทำงาน 
                </td>
                <td rowspan="2" 
                    class="text-center"  
                    style="text-align: center; vertical-align: middle;"> 
                    ปริมาณการผลิต 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    รวมพื้นที่พิมพ์ ตร.ซม. 
                </td>
                <td colspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    ค่าแรงงาน 
                </td>
                <td colspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    ค่าใช้จ่ายผันแปร 
                </td>
                <td colspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    ค่าใช้จ่ายคงที่ 
                </td>
                <td colspan="2" 
                    class="text-center" 
                    style="text-align: center; vertical-align: middle;"> 
                    รวมต้นทุน 
                </td>
            </tr>
            <tr style="border-bottom: 0.5px solid #000; border-top: 0.5px solid #000;">
                <td style="text-align: center;">
                    (บาท)
                </td>
                <td style="text-align: center;">
                    (บาท/หน่วย)
                </td>
                <td style="text-align: center;">
                    (บาท)
                </td>
                <td style="text-align: center;">
                    (บาท/หน่วย)
                </td>
                <td style="text-align: center;">
                    (บาท)
                </td>
                <td style="text-align: center;">
                    (บาท/หน่วย)
                </td>
                <td style="text-align: center;">
                    (บาท)
                </td>
                <td style="text-align: center;">
                    (บาท/หน่วย)
                </td>
            </tr>
        </thead>
        @php
                $countRow = 0;
                $qty    =0;
                $qtyarea =0;
                $amount_labor=0;
                $amount_variable =0;
                $amount_fixed =0;
                $amount_cost =0;
           
              // dd($dataList->where('code_dis','พิมพ์ Offset'));
            @endphp

        <tbody>

            
            @foreach($dataList->where('code_dis',$dataListH->code_dis) as $index => $data)
            @php
                $countRow =$countRow+1;
                $qty    =$data['qty']+$qty;
                $qtyarea =$data['qtyarea']+$qtyarea;
                $amount_labor=$data['amount_labor']+$amount_labor;
                $amount_variable =$data['amount_variable']+$amount_variable;
                $amount_fixed =$data['amount_fixed']+$amount_fixed;
                $amount_cost =$data['amount_cost']+$amount_cost;
                $count = count($dataList->where('code_dis',$dataListH->code_dis));
            @endphp
            

            <tr style="border-bottom: 0.5px  solid #000;">
            
                @if ($countRow == 1)
                    <td rowspan={{$count}} 
                        style="height: 30px; text-align: center ;  vertical-align: text-top;">
                        {{ $data['code_dis'] }} 
                    </td>                    
                @endif
                <td style="height: 30px; text-align: left; padding-left: 3px;">
                    {{ $data['group_dis'] }}
                </td>
                <td style="height: 30px; text-align: center; ">
                      {{ $data['wxl'] }} 
                </td>
                <td style="height: 30px; text-align: center;">
                    {{ number_format($data['plan_version_no'],2,".",",") }} 
                </td>
                <td style="height: 30px; text-align: center;">
                    {{ number_format($data['area'],2,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['qty'],3,".",",") }}
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['qtyarea'],3,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['amount_labor'],2,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['qty_labor'],9,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['amount_variable'],2,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['qty_variable'],9,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['amount_fixed'],2,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['qty_fixed'],9,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['amount_cost'],2,".",",") }} 
                </td>
                <td style="height: 30px; text-align: right;">
                    {{ number_format($data['qty_cost'],9,".",",") }} 
                </td>
            </tr>
            @endforeach
            <tr  style="border-bottom: 0.5px  solid #000 ; border-bottom-style: double;border-width: 3px;">
                <td>
                </td>
                <td colspan="4" 
                    style=" height: 30px;  
                            text-align: center;"> 
                    รวม 
                </td>
                <td style="height: 30px; text-align: right; "> 
                    {{ number_format($qty,3,".",",") }}
                </td>
                <td style="height: 30px; text-align: right; "> 
                    {{ number_format($qtyarea,3,".",",") }}
                </td>
                <td style="height: 30px; text-align: right; "> 
                    {{ number_format($amount_labor,2,".",",") }}
                </td>
                <td> 

                </td>
                <td style="height: 30px; text-align: right; "> 
                    {{ number_format($amount_variable,2,".",",") }}
                </td>
                <td> 

                </td>
                <td style="height: 30px; text-align: right; "> 
                    {{ number_format($amount_fixed,2,".",",") }}
                </td>
                <td> 

                </td>
                <td style="height: 30px; text-align: right;"> 
                    {{ number_format($amount_cost,2,".",",") }}
                </td>
                <td> 
                </td>
            </tr>
        </tbody>
    </table>

