<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    @php
        $styleTh = 'border:  1px solid black; line-height: 100px';
        $styleFont16 = 'border:  1px solid black; font-size: 11px';
        $styleFont14 = 'border:  1px solid black; font-size: 11px';
        $font18 = 'font-size: 13px';
        $font16 = 'font-size: 11px';
        $font14 = 'font-size: 11px';
        $styleBorderLRFont14 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 11px';
        $styleBorderLRFTont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 11px';
        $styleBorderLRBTFont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 11px';
        $uData = [];
        $styleBorderBFont14 = 'border-bottom:  1px solid black; font-size: 11px';
        $sysdate = Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
    @endphp
    <table border="1">

        <thead>
            <tr>
                <th align="center" style="{{ $font18 }}" colspan="19"> <b> การยาสูบแห่งประเทศไทย </b> </th>
            </tr>
            <tr>
                <th style="{{ $font18 }}" align="left" colspan="2">รหัสโปรแกรม : CTR0012</th>
                <th style="{{ $font18 }}" align="center" colspan="15"><b>รายงานผลต่างวัตถุดิบ ตามผลิตภัณฑ์</b>
                </th>
                <th style="{{ $font18 }}" align="right" colspan="2"><b>วันที่พิมพ์ : </b>
                    {{ $sysdate }} </th>
            </tr>
            <tr>
                <th style="{{ $font18 }}" align="left" colspan="2"><b>หน่วยงาน : {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}</b></th>
                <th style="{{ $font18 }}" align="center" colspan="15"><b>ตั้งแต่วันที่ </b>  {{$transaction_date_from}} ถึง {{$transaction_date_to}} </th>
                <th style="{{ $font18 }}" align="right" colspan="2"> </th>
            </tr>
            <tr>
                <th align="center" rowspan="4" style="{{ $styleFont14 }}; vertical-align:middle;">รหัส</th>
                <th align="center" rowspan="4" style="{{ $styleFont14 }}; vertical-align:middle;">รายละเอียด</th>
                <th align="center" rowspan="4" style="{{ $styleFont14 }}; vertical-align:middle;">หน่วยนับ</th>
                <th align="center" colspan="8" style="{{ $styleBorderLRFTont14 }}">ค่าวัตถุดิบ - คิดเข้างาน </th>
                <th align="center" colspan="2" style="{{ $styleFont14 }}">ค่าวัตถุดิบ - เบิกใช้จริง</th>
                <th align="center" colspan="2" style="{{ $styleFont14 }}">ค่าวัตถุดิบ-มาตรฐาน</th>
                <th align="center" colspan="4" style="{{ $styleFont14 }}">ผลต่างวัตถุดิบ</th>
            </tr>
            <tr>
                <th align="center" colspan="2" style=" {{ $styleBorderLRFTont14 }}; border-bottom:1px solid #000;">สินค้ากึ่งสำเร็จรูป</th>
                <th align="center" colspan="2" style=" {{ $styleBorderLRFTont14 }}; border-bottom:1px solid #000;">บวก งานระหว่างผลิต-ปลายงวด</th>
                <th align="center" colspan="2" style=" {{ $styleBorderLRFTont14 }}; border-bottom:1px solid #000;">หัก งานระหว่างผลิต-ต้นงวด</th>
                <th align="center" colspan="2" style=" {{ $styleBorderLRFTont14 }}; border-bottom:1px solid #000;">รวมทั้งสิ้น</th>
                <th align="center" rowspan="3" style=" {{ $styleBorderLRFont14 }}; vertical-align:middle; border-bottom:1px solid #000;">ปริมาณ AQ</th>
                <th align="center" rowspan="3" style=" {{ $styleBorderLRFont14 }}; vertical-align:middle; border-bottom:1px solid #000;">บาท (AQ * AP)</th>
                <th align="center" rowspan="3" style=" {{ $styleBorderLRFont14 }}; vertical-align:middle; border-bottom:1px solid #000;">ปริมาณ SQ </th>
                <th align="center" rowspan="3" style=" {{ $styleBorderLRBTFont14 }} ">บาท (SQ * SP)
                </th>
                <th align="center" colspan="2" style=" {{ $styleBorderLRBTFont14 }} ">ผลต่าง-ปริมาณ</th>
                <th  align="center" style=" {{ $styleBorderLRBTFont14 }}">ผลต่าง-ราคา
                </th>
                <th align="center" rowspan="2" style=" {{ $styleBorderLRBTFont14 }}; border-bottom:none; ">รวมผลต่าง
                </th>
            </tr>
            <tr>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">ปริมาณ</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }}; border-bottom:none;">ต้นทุน</th>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">ปริมาณ</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }}; border-bottom:none;">ต้นทุน</th>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">ปริมาณ</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }}; border-bottom:none;">ต้นทุน</th>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">ปริมาณ(AQ)</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }}; border-bottom:none;">ต้นทุน(AQ*SP)</th>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">(AQ - SQ)</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }}; border-bottom:none;">(AQ*SP) - (SQ*SP) </th>
                <td align="center" rowspan="2" style="{{ $styleBorderLRBTFont14 }}">(AQ*AP) - (AQ*SP)<br>บาท</td>
            </tr>
            <tr>
                <td align="center" style="{{ $styleBorderLRBTFont14 }};border-top:none">บาท</td>
                <td align="center" style="{{ $styleBorderLRBTFont14 }};border-top:none">บาท</td>
                <td align="center" style="{{ $styleBorderLRBTFont14 }};border-top:none">บาท</td>
                <td align="center" style="{{ $styleBorderLRBTFont14 }};border-top:none">บาท</td>
                <td align="center" style="{{ $styleBorderLRBTFont14 }};border-top:none">บาท</td>
                <td align="center" style="{{ $styleBorderLRBTFont14 }};border-top:none"></td>
            </tr>
        </thead>
        <tbody>
            @php
                $level1 = $result->where('level_no', 1);
                $total = [];
                $ingredientQuantityLev3 = 0;
                $ingredientAmountLev3 = 0;
            @endphp
            @foreach ($level1->sortBy('item_number')->groupBy('product_item_id') as $product_item_id => $items)
            @php
                if($loop->first){
                    $is_first = true;
                } else {
                    $is_first = false;
                }
            @endphp
                @foreach ($items as $item)
                    @php 
                        $item_number = $item->item_number;
                    @endphp
                    @if ($is_first)
                        <tr style="font-weight: bold; text-align:center">
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000" align="center">
                                <b>ศูนย์ต้นทุน {{ $item->cost_code }} - {{ $item->cost_description }} </b>
                            </td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                        </tr>
                        <tr style="font-weight: bold; text-align:center">
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important;vertical-align: bottom; font-weight:bold;border-right:1px solid #000" align="left">{{ $item->item_number }}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000" align="left">
                                <b>{{ $item->item_description }}</b>
                            </td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000" align="center">{{ $item->transaction_uom }}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000">{{ $item->transaction_quantity }}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000">{{ $item->end_ing_quantity ?? 0}}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000">{{ $item->begin_ing_quantity ?? 0 }}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"> </td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000">{{ $item->transaction_quantity + $item->end_ing_quantity - $item->begin_ing_quantity }}
                            </td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                        </tr>
                    @else
                        <tr style="font-weight: bold; text-align:center">
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important;vertical-align: bottom; font-weight:bold;border-right:1px solid #000" align="left">{{ $item->item_number }}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000" align="{{$is_first ? 'center' : 'left'}}">
                                <b>{{ $item->item_description }}</b>
                            </td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000" align="center">{{ $item->transaction_uom }}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000">{{ $item->transaction_quantity }}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000">{{ $item->end_ing_quantity ?? 0}}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000">{{ $item->begin_ing_quantity ?? 0 }}</td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000">{{ $item->transaction_quantity + $item->end_ing_quantity - $item->begin_ing_quantity }}
                            </td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                            <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                        </tr>
                    @endif
                    {{-- @if($is_first)
                    <tr style="font-weight: bold; text-align:center">
                        <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000" align="left">
                            <b>{{ $item->item_description }}</b>
                        </td>
                    </tr>
                    @endif --}}
                @endforeach
                @php
                    $level2 = $result->sortBy('organization_code')->where('level_no', 2)->where('product_item_id', $product_item_id);
                    $sum = [];
                @endphp
                @foreach ($level2 as $item)
                    @php
                        $ingredientQuantity = 0;
                        $ingredientAmount = 0;
                        // change cal ingredient_quantity
                        $ingredientQuantity = $item->ingredient_quantity - $item->end_ing_quantity;
                        $ingredientAmount = $item->ingredient_amount - $item->end_ing_amount;

                        @$sum['ingredient_amount'] += $ingredientAmount;
                        @$sum['end_ing_amount'] += $item->end_ing_amount;
                        @$sum['begin_ing_amount'] += $item->begin_ing_amount;
                        @$sum['l'] += $ingredientAmount + $item->end_ing_amount - $item->begin_ing_amount;
                        @$sum['actual_amount'] += $item->actual_amount;
                        @$sum['standard_amount'] += $item->standard_amount;
                    @endphp
                    <tr>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $item->organization_code }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">
                            {{ $item->organization_name }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ !empty($ingredientQuantity) ? $ingredientQuantity : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ !empty($ingredientAmount) ? $ingredientAmount : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ !empty($item->end_ing_quantity) ? $item->end_ing_quantity : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ !empty($item->end_ing_amount) ? $item->end_ing_amount : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ !empty($item->begin_ing_quantity) ? $item->begin_ing_quantity : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $j = !empty($item->begin_ing_amount) ? $item->begin_ing_amount : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $k = $ingredientQuantity + $item->end_ing_quantity - $item->begin_ing_quantity }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $y = $ingredientAmount + $item->end_ing_amount - $item->begin_ing_amount }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $m = !empty($item->actual_quantity) ? $item->actual_quantity : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $n = !empty($item->actual_amount) ? $item->actual_amount : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $o = !empty($item->standard_quantity) ? $item->standard_quantity : 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $z = ! empty($item->standard_amount) ? $item->standard_amount : 0}}</td>
                        @php
                            $q = $m - $o
                        @endphp
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            {{ $q }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $r = $y - $z }}</td>
                        @php
                            @$sum['r'] += $r;
                        @endphp
                        <!-- $m - $k -->
                        <td style="{{ $styleBorderLRFont14 }}">{{ $s = $n - $y }}</td> 
                        @php
                            @$sum['s'] += $s;
                        @endphp
                        <!-- $t = $q - $r -->
                        <td style="{{ $styleBorderLRFont14 }}">{{ $t = $r + $n-$y }}</td>
                        @php
                            @$sum['t'] += $t;
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                    <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000; white-space: nowrap;" align="right">
                        <b style="white-space: nowrap;">รวมตามคำสั่งผลิต {{ $item_number }}</b>
                    </td>
                    <td style="{{ $styleBorderBFont14 }};border-bottom:none !important; border-right:1px solid #000"></td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;"></td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['ingredient_amount'] }}</td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;"></td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['end_ing_amount'] }}</td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;"></td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['begin_ing_amount'] }}</td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;"></td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['l'] }}</td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;"></td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['actual_amount'] }}</td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;"></td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['standard_amount'] }}</td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;"></td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['r'] }}</td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['s'] }}</td>
                    <td style="{{ $styleBorderLRFTont14 }};border-bottom:1px solid #000;">{{ @$sum['t'] }}</td>
                </tr>
                @php
                    $sum = [];
                @endphp
            @endforeach
            <tr>
                <td  style="{{ $styleBorderBFont14 }}; border-top:1px solid #000;">สรุปตาม Org.ของวัตถุดิบ</td>
                <td  style="{{ $styleBorderBFont14 }}; border-top:1px solid #000;"></td>
                <td  style="{{ $styleBorderBFont14 }}; border-top:1px solid #000;"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
                <td  style="{{ $styleBorderBFont14 }}"></td>
            </tr>
            @foreach ($result->where('level_no', 2)->sortBy('organization_code')->groupBy('organization_code') as $organization_code => $item)
                @php
                    $ingredientQuantityLev3 = $item->sum('ingredient_quantity') - $item->sum('end_ing_quantity');
                    $ingredientAmountLev3 = $item->sum('ingredient_amount') - $item->sum('end_ing_amount');

                    @$total['ingredient_amount'] += $ingredientAmountLev3;
                    @$total['end_ing_amount'] += $item->sum('end_ing_amount');
                    @$total['begin_ing_amount'] += $item->sum('begin_ing_amount');
                    @$total['l'] += $ingredientAmountLev3 + $item->sum('end_ing_amount') - $item->sum('begin_ing_amount');
                    @$total['actual_amount'] += $item->sum('actual_amount');
                    @$total['standard_amount'] += $item->sum('standard_amount');
                @endphp
                <tr>
                    <td style="{{ $styleBorderBFont14 }}">{{ $organization_code }}</td>
                    <td style="{{ $styleBorderBFont14 }}">{{ $item->first()->organization_name }}</td>
                    <td style="{{ $styleBorderBFont14 }}"></td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $ingredientQuantityLev3 }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $ingredientAmountLev3 }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $item->sum('end_ing_quantity') }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $item->sum('end_ing_amount') }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $item->sum('begin_ing_quantity') }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $j = $item->sum('begin_ing_amount') }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $k = $ingredientQuantityLev3 + $item->sum('end_ing_quantity') - $item->sum('begin_ing_quantity') }}
                    </td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $y = $ingredientAmountLev3 + $item->sum('end_ing_amount') - $item->sum('begin_ing_amount') }}
                    </td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $m = $item->sum('actual_quantity') }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $n = $item->sum('actual_amount') }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $o = $item->sum('standard_quantity') }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $z = $item->sum('standard_amount') }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $q = $m - $o }}</td>
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $r = $y - $z }}</td>
                    @php
                        @$total['r'] += $r;
                    @endphp
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ $s = $n - $y }}</td>
                    @php
                        @$total['s'] += $s;
                    @endphp
                    <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000;border-right:1px solid #000">{{ $t = $r + $n-$y }}</td>
                    @php
                        @$total['t'] += $t;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td style="{{ $styleBorderBFont14 }}"></td>
                <td style="{{ $styleBorderBFont14 }}">
                    รวมตามศูนย์ต้นทุน
                </td>
                <td style="{{ $styleBorderBFont14 }}"></td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000"></td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ @$total['ingredient_amount'] }}</td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000"></td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ @$total['end_ing_amount'] }}</td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000"></td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ @$total['begin_ing_amount'] }}</td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000"></td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ @$total['l'] }}</td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000"></td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ @$total['actual_amount'] }}</td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000"></td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ @$total['standard_amount'] }}</td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000"></td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ @$total['r'] }}</td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000">{{ @$total['s'] }}</td>
                <td style="{{ $styleBorderBFont14 }};border-left:1px solid #000;border-right:1px solid #000">{{ @$total['t'] }}</td>
            </tr>
            @php
                $total = [];
            @endphp
        <tbody>
    </table>
</body>

</html>
