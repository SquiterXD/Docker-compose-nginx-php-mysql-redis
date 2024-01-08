<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table{ 
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid black
        }
        .text-center{
            text-align: center;
        }
        tbody td {
            border:1px solid black;
        }
    </style>
</head>

<body>
    <table style="width:100%">
        <thead>
            <tr>
                <td>โปรแกรม : CTR0040</td>
                <td colspan="6" class="text-center" style="text-align: center">การยาสูบแห่งประเทศไทย</td>
                <td  style="text-align: right">วันที่ : {{now()->addYears(543)->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <td>สั่งพิมพ์ : 002373</td>
                <td colspan="6" class="text-center"  style="text-align: center">รายงานปันส่วนผลต่างให้กับใบยาคงคลังและใบยาที่เบิกใช้ ประจำปี  {{now()->addYears(543)->format('Y')}}</td>
                <td style="text-align: right">เวลา :  {{now()->addYears(543)->format('H:i')}}</td>
            </tr>
            @php
            $dateInYear = Carbon\Carbon::createFromFormat('Y', request()->period_year);
            @endphp
            <tr>
                <td></td>
                <td colspan="6" class="text-center"  style="text-align: center">วันที่ {{$dateInYear->clone()->startOfYear()->addYears(543)->format('d/m/Y')}} ถึงวันที่ {{$dateInYear->clone()->endOfYear()->addYears(543)->format('d/m/Y')}}</td>
                <td style="text-align: right"></td>
            </tr>
            <tr>
                <td colspan="8">&nbsp;</td>
            </tr>
            

            <tr>
                <th style="text-align: center;border:1px solid black" rowspan="3">Item</th>
                <th style="text-align: center;border:1px solid black" colspan="3">น้ำหนักที่ใช้ในการเฉลี่ย (ก.ก.)</th>
                <th style="text-align: center;border:1px solid black" colspan="3">รายการปรับปรุงผลต่าง</th>
                <th style="text-align: center;border:1px solid black" rowspan="3">ใบยาอบแล้ว (รวมทุก Org.) <br>
                    ผลิตในปีและคงเหลือ <br>
                    ณ 30 ก.ย. 65</th>
            </tr>
            <tr>
                <th style="text-align: center;border:1px solid black">น.น. ที่ผลิตได้</th>
                <th style="text-align: center;border:1px solid black">น.น. เบิกใช้</th>
                <th style="text-align: center;border:1px solid black">น.น.คงคลัง</th>
                <th style="text-align: center;border:1px solid black">ปรับปรุงราคา</th>
                <th style="text-align: center;border:1px solid black">ปรับปรุงราคา</th>
                <th style="text-align: center;border:1px solid black">รวม</th>
            </tr>
            <tr>
                <th style="text-align: center;border:1px solid black">รวม</th>
                <th style="text-align: center;border:1px solid black">ทุกกรณี</th>
                <th style="text-align: center;border:1px solid black">ณ 30 ก.ย. 65</th>
                <th style="text-align: center;border:1px solid black">ต้นทุนขาย</th>
                <th style="text-align: center;border:1px solid black">ใบยาคงคลัง</th>
                <th style="text-align: center;border:1px solid black">ผลต่าง</th>
            </tr>
            <tr>
                <td style="text-align: center;border:1px solid black"></td>
                <td style="text-align: center;border:1px solid black">ก.ก</td>
                <td style="text-align: center;border:1px solid black">ก.ก</td>
                <td style="text-align: center;border:1px solid black">ก.ก</td>
                <td style="text-align: center;border:1px solid black">บาท</td>
                <td style="text-align: center;border:1px solid black">บาท</td>
                <td style="text-align: center;border:1px solid black">บาท</td>
                <td style="text-align: center;border:1px solid black">ก.ก</td>
            </tr>
        </thead>
        <tbody>
           @foreach($data->groupBy('tobacco_type') as $labelGroupType => $groupType)
            <tr>
                <th style="border:1px solid black;text-decoration: underline; text-align: center">{{$labelGroupType}}</th>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
            </tr>
            @foreach($groupType->groupBy('product_group') as $labelProductGroup => $productGroup)
            @foreach($productGroup as $item)
            <tr>
                <td style="border:1px solid black">{{ $item->product_item_no }}</td>
                <td style="border:1px solid black">{{$item->wip_complete_qty}}</td>
                <td style="border:1px solid black">{{$item->wip_issue_qty}}</td>
                <td style="border:1px solid black">{{$item->primary_onhand_qty}}</td>
                <td style="border:1px solid black">{{$item->cost_of_selling_price}}</td>
                <td style="border:1px solid black">{{$item->stock_price}}</td>
                <td style="border:1px solid black">{{$item->total_variance}}</td>
                <td style="border:1px solid black">{{$item->primary_onhand_qty}}</td>
            </tr>
            @endforeach
            <tr>
                <th style="border:1px solid black; text-align: center">รวม{{$labelProductGroup}}</th>
                <td style="border:1px solid black">{{$productGroup->sum('wip_complete_qty')}}</td>
                <td style="border:1px solid black">{{$productGroup->sum('wip_issue_qty')}}</td>
                <td style="border:1px solid black">{{$productGroup->sum('primary_onhand_qty')}}</td>
                <td style="border:1px solid black">{{$productGroup->sum('cost_of_selling_price')}}</td>
                <td style="border:1px solid black">{{$productGroup->sum('stock_price')}}</td>
                <td style="border:1px solid black">{{$productGroup->sum('total_variance')}}</td>
                <td style="border:1px solid black">{{$productGroup->sum('primary_onhand_qty')}}</td>
            </tr>
            @endforeach
            <tr style="">
                <th style="border:1px solid black; text-align: center;">รวม{{$labelGroupType}}</th>
                <td style="border:1px solid black;">{{$groupType->sum('wip_complete_qty')}}</td>
                <td style="border:1px solid black;">{{$groupType->sum('wip_issue_qty')}}</td>
                <td style="border:1px solid black;">{{$groupType->sum('primary_onhand_qty')}}</td>
                <td style="border:1px solid black;">{{$groupType->sum('cost_of_selling_price')}}</td>
                <td style="border:1px solid black;">{{$groupType->sum('stock_price')}}</td>
                <td style="border:1px solid black;">{{$groupType->sum('total_variance')}}</td>
                <td style="border:1px solid black;">{{$groupType->sum('primary_onhand_qty')}}</td>
            </tr>
            {{-- end productGroup --}}
           @endforeach
           <tr >
            <th style="border:1px solid black; text-align: center;">รวมทั้งสิ้น</th>
            <td style="border:1px solid black;">{{$data->sum('wip_complete_qty')}}</td>
            <td style="border:1px solid black;">{{$data->sum('wip_issue_qty')}}</td>
            <td style="border:1px solid black;">{{$data->sum('primary_onhand_qty')}}</td>
            <td style="border:1px solid black;">{{$data->sum('cost_of_selling_price')}}</td>
            <td style="border:1px solid black;">{{$data->sum('stock_price')}}</td>
            <td style="border:1px solid black;">{{$data->sum('total_variance')}}</td>
            <td style="border:1px solid black;">{{$data->sum('primary_onhand_qty')}}</td>
        </tr>
           {{-- end groupType --}}
        </tbody>
    </table>
</body>

</html>
