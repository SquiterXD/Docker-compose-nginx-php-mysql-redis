<div style="min-height: 640px;">

    <table border="0" width="100%" style="border: 1px solid #000000; font-size: 12px; ">
        <thead>
            <tr>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ศูนย์ต้นทุน 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    กลุ่มสินค้า 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ความกว้าง x ความยาว (ซม.) 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    จำนวนครั้งของการพิมพ์ 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    พื้นที่ของการทำงาน 
                </td>
                <td rowspan="2" 
                    class="text-center"  
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ปริมาณการผลิต 
                </td>
                <td rowspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    รวมพื้นที่พิมพ์ ตร.ซม. 
                </td>
                <td colspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ค่าแรงงาน 
                </td>
                <td colspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ค่าใช้จ่ายผันแปร 
                </td>
                <td colspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    ค่าใช้จ่ายคงที่ 
                </td>
                <td colspan="2" 
                    class="text-center" 
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;"> 
                    รวมต้นทุน 
                </td>
            </tr>
            <tr>
                <td style="text-align: center; border: 1px solid #000000;">
                    (บาท)
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    (บาท/หน่วย)
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    (บาท)
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    (บาท/หน่วย)
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    (บาท)
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    (บาท/หน่วย)
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    (บาท)
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    (บาท/หน่วย)
                </td>
            </tr>
        </thead>
        <tbody>
        @php
                $countRow = 0;
                $qty    =0;
                $qtyarea =0;
                $amount_labor=0;
                $amount_variable =0;
                $amount_fixed =0;
                $amount_cost =0;
               
            @endphp
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
            <tr>
                @if ($countRow == 1)
                    <td rowspan={{$count}} style="border: 1px solid #000000; text-align: center; vertical-align: top;">
                        {{ $data['code_dis'] }} 
                    </td>                    
                @endif
                <td style="border: 1px solid #000000; text-align: left">
                    {{ $data['group_dis'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: center">
                    {{ $data['wxl'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: center">
                    {{ $data['plan_version_no'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: center">
                    {{ $data['area'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['qty'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['qtyarea'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['amount_labor'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['qty_labor'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['amount_variable'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['qty_variable'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['amount_fixed'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['qty_fixed'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['amount_cost'] }} 
                </td>
                <td style="border: 1px solid #000000; text-align: right">
                    {{ $data['qty_cost'] }} 
                </td>
            </tr>
            @endforeach
            <tr  >
                <td style=" border-width: 1px; border-bottom: 1px double #000;"></td>
                <td colspan="4" style="border: 1px solid #000000 ; text-align: center;border-bottom: 1px double #000; "> รวม </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000; "> 
                    {{ $qty }}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{ $qtyarea }}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{ $amount_labor }}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{-- {{ $qty_labor }} --}}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{ $amount_variable }}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{-- {{ $qty_variable }} --}}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{ $amount_fixed }}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{-- {{ $qty_fixed }} --}}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{ $amount_cost }}
                </td>
                <td style="border: 1px solid #000000; text-align: right; border-bottom: 1px double #000;"> 
                    {{-- {{ $qty_cost }} --}}
                </td>
            </tr>
        </tbody>
    </table>

</div>