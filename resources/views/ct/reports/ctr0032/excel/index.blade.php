<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

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
                <th align="center" style="{{ $font18 }}" colspan="20"> <b> การยาสูบแห่งประเทศไทย </b> </th>
            </tr>
            <tr>
                
                <th style="{{ $font18 }}" align="left" colspan="2">
                    รหัสโปรแกรม : {{request()->program_code}}
                </th>
                <th style="{{ $font18 }}" align="center" colspan="15"><b>รายงานผลต่างวัตถุดิบ-สิ่งพิมพ์สำเร็จรูป{{$programcode =='CTR0032' ? '(สตง.)' : ''}} ตามผลิตภัณฑ์</b>
                </th>
                <th style="{{ $font18 }}" align="right" colspan="3"><b>วันที่พิมพ์ : </b>
                    {{ $sysdate }} </th>
            </tr>
            <tr>
                <th style="{{ $font18 }}" align="left" colspan="2"><b>หน่วยงาน : {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}</b></th>
                <th style="{{ $font18 }}" align="center" colspan="15"><b>ตั้งแต่วันที่ </b>  {{$transaction_date_from}} ถึง {{$transaction_date_to}} </th>
                <th style="{{ $font18 }}" align="right" colspan="3"> </th>
            </tr>
            <tr>
                <th align="center" rowspan="4" style="{{ $styleFont14 }}; vertical-align:middle;">รหัส</th>
                <th align="center" rowspan="4" style="{{ $styleFont14 }}; vertical-align:middle;">รายละเอียด</th>
                {{-- <th align="center" rowspan="4" style="{{ $styleFont14 }}; vertical-align:middle;">คำสั่งผลิต</th> --}}
                <th align="center" rowspan="4" style="{{ $styleFont14 }}; vertical-align:middle;">หน่วยนับ</th>
                <th align="center" colspan="9" style="{{ $styleBorderLRFTont14 }}">ค่าวัตถุดิบ - มาตรฐาน </th>
                <th align="center" colspan="3" style="{{ $styleFont14 }}">ค่าวัตถุดิบ - เบิกใช้จริง</th>
                <th align="center" style="{{ $styleFont14 }}">ค่าวัตถุดิบ</th>
                <th align="center" colspan="4" style="{{ $styleFont14 }}">ผลต่างวัตถุดิบ</th>
            </tr>
            <tr>
                <th align="center" colspan="2" style=" {{ $styleBorderLRFTont14 }}; border-bottom:1px solid #000">สิ่งพิมพ์สำเร็จรูป</th>
                <th align="center" colspan="2" style=" {{ $styleBorderLRFTont14 }}; border-bottom:1px solid #000">บวก งานระหว่างผลิต-ปลายงวด</th>
                <th align="center" colspan="2" style=" {{ $styleBorderLRFTont14 }}; border-bottom:1px solid #000">หัก งานระหว่างผลิต-ต้นงวด</th>
                <th align="center" colspan="2" style=" {{ $styleBorderLRFTont14 }}; border-bottom:1px solid #000">รวมทั้งสิ้น</th>
                <th align="center" rowspan="2" style=" {{ $styleBorderLRFont14 }}; vertical-align:middle; border-top:1px solid #000">ราคาต่อหน่วย SP </th>
                <th align="center" rowspan="3" style=" {{ $styleBorderLRFont14 }}; vertical-align:middle; border-bottom:1px solid #000">ปริมาณ
                    <br> AQ</th>
                <th align="center" rowspan="2" style=" {{ $styleBorderLRFont14 }}; vertical-align:middle; ">ราคาต่อหน่วย <br>
                    AP  
                    </th>
                <th align="center" rowspan="2" style="border-left:1px solid #000; border-right:1px solid #000">(AQ * AP)
                </th>
                <th align="center" rowspan="3" style=" {{ $styleBorderLRBTFont14 }} ">คิดเข้างาน <br>
                    (AQ * SP)
                    </th>
                <th align="center" colspan="2" style=" {{ $styleBorderLRBTFont14 }} ">
                    ผลต่าง-ปริมาณ	
                </th>
                <th align="center" rowspan="2" style="border-right:1px solid #000; border-left:1px solid #000; ">ผลต่าง-ราคา <br>
                    (AQ*AP) - (AQ*SP) 
                </th>
                <th  align="center" rowspan="2" style=" border-right:1px solid #000; border-left:1px solid #000; ">รวมผลต่าง</th>
            </tr>
            <tr>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">ปริมาณ</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }};border-bottom:none;">ต้นทุน</th>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">ปริมาณ</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }};border-bottom:none;">ต้นทุน</th>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">ปริมาณ</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }};border-bottom:none;">ต้นทุน</th>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">ปริมาณ(SQ)</th>
                <th align="center" style="{{ $styleBorderLRBTFont14 }};border-bottom:none;">ต้นทุน</th>
                <th rowspan="2" align="center" style="{{ $styleBorderLRBTFont14 }}">(AQ - SQ)</th>
                <th align="center" style="border-right:1px solid #000; border-left:1px solid #000;">(AQ*SP) - (SQ*SP)  </th>
            </tr>
            <tr>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">บาท</th>
                <th align="center" style="border-bottom:1px solid #000;border-right:1px solid #000">บาท</th>
            </tr>
        </thead>
        <tbody>
            @php
                $level1 = $result->where('level_no', 1);
                $sum = [];
                $total = [];
            @endphp
            @foreach ($level1->groupBy('product_item_id') as $product_item_id => $items)
            @php
                if($loop->first){
                    $is_first = true;
                } else {
                    $is_first = false;
                }
            @endphp
                    @if($is_first)
                    <tr>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }} font-weight:bold;" align="center" ><b>ศูนย์ต้นทุน {{ $items->first()->cost_code }} - {{ $items->first()->cost_description }}</b></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                </tr>
                @endif
                @foreach ($items as $item)
                    @php 

                    $check_wip_end_amount = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('wip_end_amount');
                    $check_std_quantity = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('std_quantity');
                    $check_std_amount = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('std_amount');
                    $check_wip_end_quantity = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('wip_end_quantity');
                    $check_wip_begin_quantity = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('wip_begin_quantity');
                    $check_wip_begin_amount = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('wip_begin_amount');
                    $check_std_cost = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('std_cost');
                    $check_actual_quantity = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('actual_quantity');
                    $check_actual_cost = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('actual_cost');
                    $check_actual_amount = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('actual_amount');
                    $check_absorb_amount = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sum('absorb_amount');
                    
                    if( $check_wip_end_amount == 0
                    && $check_std_quantity == 0
                    && $check_std_amount == 0
                    && $check_wip_end_quantity == 0
                    && $check_wip_begin_quantity == 0
                    && $check_wip_begin_amount == 0
                    && $check_std_cost == 0
                    && $check_actual_quantity == 0
                    && $check_actual_cost == 0
                    && $check_actual_amount == 0
                    && $check_absorb_amount == 0) {
                        continue;
                    }

                    @endphp
                    <tr>
                        <td style="{{ $styleBorderLRFont14 }}">
                            <b>{{ $item->item_number }}</b>
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}">
                            <b>{{ $item->item_description }}</b>
                        </td>
                        {{-- <td style="{{ $styleBorderLRFont14 }}">{{ $product_item_id }}</td> --}}
                        <td style="{{ $styleBorderLRFont14 }} font-weight:bold;" align="center">
                            <b>{{ $item->unit_of_measure }}</b>
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($item->std_quantity, 6) ?? 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($item->wip_end_quantity, 6) ?? 0}}</td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($item->wip_begin_quantity, 6) ?? 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            {{ absFormat($item->std_quantity + $item->wip_end_quantity - $item->wip_begin_quantity, 6) ?? 0 }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($item->actual_quantity, 6) ?? 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                    </tr>
                    @php
                    $level2 = $result->where('level_no', 2)->where('product_item_id', $product_item_id)->sortBy('item_number');
                    @endphp
                    @foreach($level2 as $lv2)
                    @php 
                        @$sum['std_amount'][$product_item_id] += $lv2->std_amount;
                        @$sum['wip_end_amount'][$product_item_id] += $lv2->wip_end_amount;
                        @$sum['wip_begin_amount'][$product_item_id] += $lv2->wip_begin_amount;
                    @endphp 
                    <tr>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $lv2->item_number }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">
                            {{ $lv2->item_description }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="center">{{ $lv2->uom_code }}</td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($lv2->std_quantity, 6) ?? 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($lv2->std_amount, 2) ?? 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($lv2->wip_end_quantity, 6) ?? 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($lv2->wip_end_amount, 2) ?? 0 }}</td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($lv2->wip_begin_quantity, 6) ?? 0 }} </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">{{ absFormat($lv2->wip_begin_amount, 2) ?? 0 }} </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            {{-- 7+8-9 --}}
                            @php $sq = $lv2->std_quantity +  $lv2->wip_end_quantity - $lv2->wip_begin_quantity; @endphp
                            {{ absFormat($sq, 6) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            {{-- 16+18-20 --}}
                            @php $sq_amount = $lv2->std_amount +  $lv2->wip_end_amount - $lv2->wip_begin_amount; @endphp
                            {{ absFormat($sq_amount, 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            @php $sp = $lv2->std_cost ?? 0; @endphp
                            {{ absFormat($sp, 9) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            @php $aq = $lv2->actual_quantity ?? 0; @endphp
                            {{ absFormat($aq, 6) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            @php $ap = $lv2->actual_cost ?? 0; @endphp
                            {{ absFormat($ap, 9) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            @php $aqAp = $lv2->actual_amount ?? 0; @endphp
                            {{ absFormat($aqAp, 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            @php $aqSp = $lv2->absorb_amount ?? 0; @endphp
                            {{ absFormat($aqSp, 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            {{-- 23 - 21 --}}
                            @php $aqlSq = $lv2->actual_quantity - $sq; @endphp
                            {{ absFormat($aqlSq, 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            {{-- 26 - 22 --}}
                            {{-- is 28 --}}
                            @php $amlSa = $lv2->absorb_amount - $sq_amount; @endphp
                            {{ absFormat($amlSa, 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            {{-- 25 - 26 --}}
                            {{-- is 29 --}}
                            @php $amlAa =  $lv2->actual_amount -  $lv2->absorb_amount; @endphp
                            {{ absFormat($amlAa, 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}" align="right">
                            {{-- 28 + 29 --}}
                            @php $sumAmlpAmlAa = $amlSa + $amlAa; @endphp
                            {{ absFormat($sumAmlpAmlAa, 2) }}
                        </td>
                        @php 
                            @$sum['sq_amount'][$product_item_id] += $sq_amount;
                            @$sum['sumAmlpAmlAa'][$product_item_id] += $sumAmlpAmlAa;
                            @$sum['amlAa'][$product_item_id] += $amlAa;
                            @$sum['amlSa'][$product_item_id] += $amlSa;
                            @$sum['aqSp'][$product_item_id] += $aqSp;
                            @$sum['aqAp'][$product_item_id] += $aqAp;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }};text-align:right; font-weight:bold">
                            รวม
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{ absFormat(@$sum['std_amount'][$product_item_id], 2) ?? 0 }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{ absFormat(@$sum['wip_end_amount'][$product_item_id], 2) ?? 0 }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{ absFormat(@$sum['wip_begin_amount'][$product_item_id], 2) ?? 0 }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{-- 7+8-9 --}}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{-- 16+18-20 --}}
                            {{ absFormat(@$sum['sq_amount'][$product_item_id], 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{ absFormat(@$sum['aqAp'][$product_item_id], 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{ absFormat(@$sum['aqSp'][$product_item_id], 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{ absFormat(@$sum['amlSa'][$product_item_id], 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{ absFormat(@$sum['amlAa'][$product_item_id], 2) }}
                        </td>
                        <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                            {{ absFormat(@$sum['sumAmlpAmlAa'][$product_item_id], 2) }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <td style="{{ $styleBorderLRFont14 }}; border-bottom:1px solid #000"></td>
                <td style="{{ $styleBorderLRFont14 }};text-align:right; font-weight:bold;; border-bottom:1px solid #000; ">
                    รวมตามศูนย์ต้นทุน
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; "></td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{ @$sum['std_amount'] ?  absFormat(array_sum(@$sum['std_amount']), 2) : 0 }}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{ @$sum['wip_end_amount'] ? absFormat(array_sum(@$sum['wip_end_amount']), 2) : 0 }}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{ @$sum['wip_begin_amount'] ? absFormat(array_sum(@$sum['wip_begin_amount']), 2) : 0 }}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{-- 7+8-9 --}}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{-- 16+18-20 --}}
                    {{ @$sum['sq_amount'] ? absFormat(array_sum(@$sum['sq_amount']), 2) : '' }}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{ @$sum['aqAp'] ? absFormat(array_sum(@$sum['aqAp']), 2) : '' }}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{ @$sum['aqSp'] ? absFormat(array_sum(@$sum['aqSp']), 2) : '' }}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;"></td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{ @$sum['amlSa'] ?absFormat(array_sum(@$sum['amlSa']), 2): '' }}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{ @$sum['amlAa'] ?absFormat(array_sum(@$sum['amlAa']), 2): '' }}
                </td>
                <td style="{{ $styleBorderLRFont14 }} ; border-bottom:1px solid #000; border-top:1px solid #000;" align="right">
                    {{ @$sum['sumAmlpAmlAa'] ?absFormat(array_sum(@$sum['sumAmlpAmlAa']), 2): '' }}
                </td>
            </tr>
        <tbody>
    </table>
</body>

</html>
