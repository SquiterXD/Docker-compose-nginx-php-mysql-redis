<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานราย</title>
    <style>
        table {
            border-collapse: collapse;
        }

        td {
            padding: 3px 25px;
        }
    </style>
</head>

<body>
    
    <table>
        @foreach($datas->sortBy('transaction_date')->groupBy('transaction_date') as $transaction_date => $groupTransactionDate)

        @foreach($groupTransactionDate->sortBy('item_number')->groupBy('product_item_number') as $product_item_number => $groupByProductItemNumber)
        
        @foreach($groupByProductItemNumber->groupBy('batch_no') as $batch_no => $groupByBatch)
        
        @php
            $sysdate = now()->addYears(543)->format('d/m/Y H:i');
            $firstLine = $groupByBatch->first();
        @endphp
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
        
            <td colspan="2">รหัสโปรแกรม : CTR0006
            </td>
            <td colspan="2">การยาสูบแห่งประเทศไทย
            </td>
            <td colspan="3" align="right">
                วันที่พิมพ์  :  {{now()->addYears(543)->format('d/m/Y H:i')}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                สั่งพิมพ์ :{{ (auth()->user()->username) }}
            </td>
            <td colspan="2">
                รายงานรายละเอียดวัตถุดิบใช้ไปจริง
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">หน่วยงาน : {{ $firstLine->dept_code . ' ' . $firstLine->dept_desc }}
            </td>
            @php 
            $months_th = [ '01'=>"มกราคม", '02'=>"กุมภาพันธ์",'03'=> "มีนาคม",'04'=> "เมษายน",'05'=> "พฤษภาคม",'06'=> "มิถุนายน",'07'=> "กรกฎาคม",'08'=> "สิงหาคม",'09'=> "กันยายน",'10'=> "ตุลาคม",'11'=> "พฤศจิกายน",'12'=> "ธันวาคม" ];
            $new_transaction_date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $transaction_date); //
            @endphp
            <td colspan="2"> ประจำวันที่  : {{ $new_transaction_date->format('d') }} {{ $months_th[$new_transaction_date->format('m')] }} {{ $new_transaction_date->addYears(543)->format('Y') }}</td>
        </tr>
        <tr>
            <td colspan="2">
                ศูนย์ต้นทุน : {{ $firstLine->cost_code}} {{$firstLine->cost_desc}}
            </td>
        </tr>
        <tr>
            <td colspan="2">ชื่อสินค้า : {{$product_item_number}} {{ ($groupByProductItemNumber->first()->product_item_desc) }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                เลขที่คำสั่งผลิต : {{$batch_no}}
            </td>
        </tr>
        <tr style="">
            <td rowspan="2"
                style="text-align:center; vertical-align: top;border-top:1px solid #000;border-bottom:1px solid #000">
                รหัสวัตถุดิบ</td>
            <td rowspan="2"
                style="text-align:center; vertical-align: top;border-top:1px solid #000;border-bottom:1px solid #000">
                รายละเอียด</td>
            <td rowspan="2"
                style="text-align:center; vertical-align: top;border-top:1px solid #000;border-bottom:1px solid #000">
                UOM </td>
            <td colspan="3"
                style="text-align:center; vertical-align: top;border-top:1px solid #000;border-bottom:1px solid #000">
                จริง </td>
            <td rowspan="2"
                style="text-align:center; vertical-align: top;border-top:1px solid #000;border-bottom:1px solid #000">%
                สูญเสีย </td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #000;width:150px;text-align:center;">จำนวน</td>
            <td style="border-bottom:1px solid #000;width:150px;text-align:center;">ราคา</td>
            <td style="border-bottom:1px solid #000;width:150px;text-align:center;">จำนวนเงิน</td>
        </tr>
        {{-- {{dd($groupByBatch->groupBy('oprn_class_desc'))}} --}}
        @foreach($groupByBatch->sortBy('oprn_class_desc')->groupBy('oprn_class_desc') as $wipStep => $groupByWip)
        <tr>
            <td colspan="2">
               <b> ขั้นตอน</b> :{{ $wipStep }} - {{$groupByWip->first()->oprn_desc}}
            </td>
        </tr>
        @foreach($groupByWip->sortBy('request_number')->groupBy('request_number') as $request_number => $groupRequestNumber)
        {{-- {{dump($groupRequestNumber)}} --}}
        <tr>
            <td colspan="2">
                <b>   เลขที่ใบเบิก</b> :{{$request_number}}
            </td>
            <td><b> จำนวนที่ผลิตได้</b> : </td>
            <td>&nbsp;{{number_format($groupRequestNumber->first()->opt_plan_qty, 6)}}</td>
            <td><b> UOM</b> :{{$groupRequestNumber->first()->primary_unit_of_measure}}</td>
            <td><b> ราคาต่อหน่วย </b>:</td>
            <td style="">{{$groupRequestNumber->first()->std_cost}}</td>
        </tr>
        @php 
            $transaction_amount = 0;
        @endphp
        @foreach($groupRequestNumber->sortBy('item_number') as $item) 
        @php 
            $transaction_amount += $item->transaction_amount;
        @endphp
        <tr>
            <td >
                {{$item->item_number}}
            </td>
            <td >
                {{$item->item_desc}}
            </td>
            <td>{{ $item->th_detail_unit_of_measure }}</td>
            <td>{{$item->transaction_quantity}}</td>
            <td>{{$item->transaction_cost}}</td>
            <td>{{$item->transaction_amount}}</td>
        </tr>
        @endforeach 
        {{-- end for items --}}
        <tr>
            <td colspan="4" style="border-top:1px solid #000; border-bottom:1px solid #000"></td>
            <td style="border-top:1px solid #000; border-bottom:1px solid #000"><b>  รวม</b> </td>
            <td style="border-top:1px solid #000; border-bottom:1px solid #000">{{$transaction_amount}}</td>
        </tr>

        @endforeach
        {{-- end Group By request_number --}}
        @endforeach
        {{-- end Group by Wip step --}}


        @endforeach 
        {{-- end groupBy Batch number --}}
        <tr>
            <td colspan="3" style="border-top:1px solid #000; border-bottom:1px solid #000;">สรุปการใช้วัตถุดิบ ผลิต ตามเลขที่คำสั่งผลิต  :  {{$batch_no}}</td>
            <td style="border-top:1px solid #000; border-bottom:1px solid #000">ปริมาณจริง</td>
            <td style="border-top:1px solid #000; border-bottom:1px solid #000">จำนวนเงินจริง</td>
        </tr>
        @foreach($groupByBatch->sortBy('oprn_class_desc')->groupBy('oprn_class_desc') as $wipStep => $groupByWip)
        <tr>
            <td colspan="5" style="border-top:1px solid #000; border-bottom:1px solid #000">ขั้นตอน  :  {{$wipStep}} - {{$groupByWip->first()->oprn_desc}}</td>
        </tr>
        @foreach($groupByWip->sortBy('tobacco_group_code')->groupBy('tobacco_group_code') as $tobaccoGroupCode => $groupByTobacco)
        @if($loop->last)
        <tr>
            <td colspan="3" style="border-bottom:1px solid #000">{{$groupByTobacco->first()->tobacco_group}}</td>
            <td style="border-bottom:1px solid #000">{{ $groupByTobacco->sum('transaction_quantity') }}</td>
            <td style="border-bottom:1px solid #000">{{ $groupByTobacco->sum('transaction_amount') }}</td>
        </tr>
        @else
        <tr>
            <td colspan="3">{{$groupByTobacco->first()->tobacco_group}}</td>
            <td>{{ $groupByTobacco->sum('transaction_quantity') }}</td>
            <td>{{ $groupByTobacco->sum('transaction_amount') }}</td>
        </tr>
        @endif
        @endforeach
        {{-- end group Tobacco Group --}}
        @endforeach
        {{-- endwip //2 --}}

        @endforeach 
        {{-- end groupBy product num --}}
        @endforeach
        {{-- end group by transaction date --}}
    </table>
</body>

</html>
