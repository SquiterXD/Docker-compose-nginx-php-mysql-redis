<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

</head>

<body>
    @php
        $styleTh = 'border:  1px solid black; line-height: 100px';
        $styleFont16 = 'border:  1px solid black; font-size: 16px';
        $styleFont14 = 'border:  1px solid black; font-size: 14px';
        $font18 = 'font-size: 18px';
        $font16 = 'font-size: 16px';
        $font14 = 'font-size: 14px';
        $styleBorderLRFont14 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 14px';
        $styleBorderLRFont16 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 16px';
        $styleBorderLRFTont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 16px';
        $styleBorderLRBTFont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $styleBorderTBFont16 = 'border-top:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $uData = [];
        $sysdate = Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
        // dd('xxxxxxxxxxxxxxxxxxxxxxxxx');
    @endphp

@foreach ($datas->groupBy('product_item_number') as $productItemNumber => $groupProducts)
    <table>
        <thead>
            {{-- @if ($loop->first) --}}
                <tr>
                    <td  align="left"     style="{{ $font18 }}"><b>โปรแกรม : </b>  CTR0009</td>
                    <td  align="center" colspan="5"  style="{{ $font18 }}"><b> การยาสูบแห่งประเทศไทย </b></td>
                    <td  align="center"  style="{{ $font18 }}"><b> วันที่พิมพ์ : </b> {{ $sysdate }} </td>
                </tr>
                <tr>
                    <td  align="left"     style="{{ $font18 }}"></td>
                    <td  align="center" colspan="5"  style="{{ $font18 }}"><b> รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามคำสั่งผลิต </b></td>
                    <td  align="center"  style="{{ $font18 }}"> </td>
                </tr>
                <tr>
                    <td  align="left"     style="{{ $font18 }}"><b> {{  'ศูนย์ต้นทุน '. $cost->cost_code. ' ' . $cost->description  }} </b></td>
                    <td  align="center" colspan="5"  style="{{ $font18 }}"><b> {{ ctDateText($dateFrom , $dateTo) }}  </b></td>
                    <td  align="center"  style="{{ $font18 }}"> </td>
                </tr>
                <tr>
                    <td  align="left" style="{{ $font18 }}" colspan="7"><b>หน่วยงาน : </b> {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}  </td>
                </tr>
            {{-- @endif --}}
            <tr>
                <td  align="left"   colspan="2"  style="{{ $font18 }}"><b>  กลุ่มผลิตภัณฑ์  {{ $groupProducts[0]->product_group_desc }} </b></td>
                <td  align="left" colspan="4"  style="{{ $font18 }}"><b> รหัสผลิตภัณฑ์ :   {{ $groupProducts[0]->product_item_number }} {{ $groupProducts[0]->product_item_desc }}  </b></td>
                <td  align="center"  style="{{ $font18 }}"> จำนวนที่ผลิต :  {{ number_format($groupProducts[0]->total_product_qty , 2) }} </td>
            </tr>
            <tr>
                <th align="center" style="{{ $styleBorderTBFont16 }}" rowspan="2"><b>  รหัสวัตถุดิบ </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}" rowspan="2"><b> รายละเอียด </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}" rowspan="2"><b> หน่วยนับ </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}" colspan="3"><b> จริง </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}" rowspan="2"><b> หมายเหตุ </b></th>
            </tr>
            <tr>
                <th align="center" style="{{ $styleBorderTBFont16 }}"><b> จำนวน </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}"><b> ราคา </b></th>
                <th align="center" style="{{ $styleBorderTBFont16 }}"><b> จำนวนเงิน </b></th>
            </tr>
            
        </thead>
        <tbody>
            @foreach ($groupProducts->groupBy('batch_no') as $batchNo => $groupByBatch)
                <tr>
                    <td style="{{ $styleBorderTBFont16 }}"> <b>คำสั่งผลิต :  {{ $batchNo }}   </b></td>
                    <td style="{{ $styleBorderTBFont16 }}" colspan="6"> <b> จำนวนที่ผลิต : {{ number_format($groupByBatch->first()->product_quantity, 2) }}  </b></td>
                </tr>
                @foreach ($groupByBatch->groupBy('item_number') as $itemNumber => $items)
                    <tr>
                        <td style="{{ $font16 }}" align="left"> {{ $itemNumber }} </td>
                        <td style="{{ $font16 }}"> {{ $items[0]->item_desc }} </td>
                        <td style="{{ $font16 }}" align="center"> {{ $items[0]->primary_uom_code }}</td>
                        <td style="{{ $font16 }}"> {{ $items->sum('transaction_quantity') }}</td>
                        <td style="{{ $font16 }}" > {{ $items->sum('transaction_cost') }} </td>
                        <td style="{{ $font16 }}">{{  $items->sum('transaction_amount') }} </td>
                        <td >
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td style="{{ $styleBorderTBFont16 }}" colspan="3" align="center"> <b> รวม  </b> </td>
                    <td style="{{ $styleBorderTBFont16 }}"><b> {{ $groupByBatch->sum('transaction_quantity') }} </b></td>
                    <td style="{{ $styleBorderTBFont16 }}"></td>
                    <td style="{{ $styleBorderTBFont16 }}"> <b>{{ $groupByBatch->sum('transaction_amount') }} </b></td>
                    <td style="{{ $styleBorderTBFont16 }}"></td>
                </tr>
            @endforeach
            <tr>
                {{-- <td style="border-bottom: 1px solid black; font-size: 16px " colspan="2" align="center" ><b>  สรุปการใช้วัตถุดิบ ผลิต ตามศูนย์ต้นทุน: {{$cost->cost_code. ' ' . $cost->description}}  </b></td> --}}
                <td style="border-bottom: 1px solid black; font-size: 16px " colspan="2" align="center" >
                    <b> รวม รหัสผลิตภัณฑ์ : {{ $groupProducts[0]->product_item_number }} {{ $groupProducts[0]->product_item_desc }} </b>
                </td>
                <td style="border-bottom: 1px solid black; font-size: 16px " align="center" ><b> ปริมาณจริง </b></td>
                <td style="border-bottom: 1px solid black; font-size: 16px " align="center" ><b> จำนวนเงินจริง </b></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            {{-- {{ dd($groupProducts->groupBy('tobacco_group_code')) }} --}}
            @foreach ($groupProducts->groupBy('tobacco_group_code') as $groupCode => $dataBygroup)
            
                <tr>
                    <td style="{{ $font16 }}"> <b> {{$groupCode}} </b>  </td>
                    <td style="{{ $font16 }}"> <b> {{ $dataBygroup[0]->tobacco_group }} </b></td>
                    <td style="{{ $font16 }}"> <b> {{ $dataBygroup->sum('transaction_quantity')}}</b> </td>
                    <td style="{{ $font16 }}" align="right" ><b>  {{ number_format($dataBygroup->sum('transaction_amount'), 2) }} </b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @if ($loop->last)
                <tr>
                    <td style="border-bottom: 1px solid black "></td>
                    <td style="border-bottom: 1px solid black "> </td>
                    <td style="border-bottom: 1px solid black "></td>
                    <td style="border-bottom: 1px solid black "></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
            @endforeach
        </tbody>
        @if ($loop->last && count($datas))
            <tfoot>
                <tr>
                    <td style="{{ $styleBorderTBFont16 }} border-top:  1px solid black !important; border-bottom:  1px solid black!important;" colspan="3" align="center"> <b> รวมตามศูนย์ต้นทุน : {{ $cost->cost_code }} {{ $cost->description }}</b> </td>
                    <td style="{{ $styleBorderTBFont16 }} border-top:  1px solid black !important; border-bottom:  1px solid black!important;"><b></b></td>
                    <td style="{{ $styleBorderTBFont16 }} border-top:  1px solid black !important; border-bottom:  1px solid black!important;"></td>
                    <td style="{{ $styleBorderTBFont16 }} border-top:  1px solid black !important; border-bottom:  1px solid black!important;" align="right"> <b>{{ number_format($datas->sum('transaction_amount') ?? 0, 2) }} </b></td>
                    <td style="{{ $styleBorderTBFont16 }} border-top:  1px solid black !important; border-bottom:  1px solid black!important;"></td>
                </tr>
                @foreach ($datas->groupBy('tobacco_group_code') as $groupCode => $dataBygroup)
                    <tr>
                        <td style="{{ $font16 }}"> <b> {{$groupCode}} </b>  </td>
                        <td style="{{ $font16 }}"> <b> {{ $dataBygroup[0]->tobacco_group }} </b></td>
                        <td style="{{ $font16 }}" align="right"> <b> {{ number_format($dataBygroup->sum('transaction_quantity') ?? 0, 6) }}</b> </td>
                        <td style="{{ $font16 }}" align="right" ><b>  {{ number_format($dataBygroup->sum('transaction_amount') ?? 0, 2) }} </b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td style="border-bottom: 1px solid black "></td>
                    <td style="border-bottom: 1px solid black "> </td>
                    <td style="border-bottom: 1px solid black "></td>
                    <td style="border-bottom: 1px solid black "></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>
    @endforeach
</body>

</html>
