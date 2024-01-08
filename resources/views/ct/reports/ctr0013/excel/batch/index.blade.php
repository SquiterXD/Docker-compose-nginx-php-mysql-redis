<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ct.reports.ctr0101._style')

    </head>

    <body>
    {{-- @include('ct.reports.ctr0013.excel._header') --}}
    {{-- @include('ct.reports.ctr0013.excel._table1') --}}
    <table border="0" width="100%" style="border: 1px solid #000000; font-size: 12px;">
        <thead>
            <tr>
                <th colspan ="2"></th>
                <th colspan="12"
                    class="text-center tw-font-bold"
                    style="text-align: center; font-size: 14px;">
                    การยาสูบแห่งประเทศไทย
                </th>
                <th colspan ="2"></th>
            </tr>
            <tr>
                <th colspan ="2"
                class="text-left tw-font-bold"
                style="text-align: left; font-size: 12px;">
                รหัสโปรแกรม :  CTR0013

                </th>
                <th colspan="12"
                    class="text-center tw-font-bold"
                    style="text-align: center ; font-size: 12px;">
                    รายงานสรุปบัตรต้นทุน {{$REPORT_TYPE}}
                </th>
                <th colspan ="2" class="text-right tw-font-bold"
                    style="text-align: right; font-size: 12px;">
                    วันที่พิมพ์ : {{ $nowDateTh }}
                </th>
            </tr>
            <tr>
                <th colspan ="2"
                class="text-left tw-font-bold"
                style="text-align: left; font-size: 12px;">
                หน่วยงาน : {{ optional($datas->first())->department_code  }} {{ optional($datas->first())->department_description  }}

                </th>
                <th colspan="12"
                    class="text-center tw-font-bold"
                    style="text-align: center ; font-size: 12px;">
                    ตั้งแต่วันที่ {{$periodFromTh}} ถึงวันที่ {{$periodToTh}}
                </th>
                <th colspan ="2" class="text-right tw-font-bold"
                    style="text-align: right; font-size: 12px;">

                </th>
            </tr>
            <tr>
                <td rowspan="3"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    รหัส
                </td>
                <td rowspan="3"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    รายละเอียด
                </td>
                <td rowspan="3"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    คำสั่งผลิต
                </td>
                <td rowspan="3"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    หน่วยนับ
                </td>
                <td colspan="8"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    ค่าวัตถุดิบ - คิดเข้างาน
                </td>
                <td rowspan="3"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    ค่าแรง
                </td>
                <td rowspan="3"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    ค่าใช้จ่ายการผลิตผันแปร
                </td>
                <td rowspan="3"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    ค่าใช้จ่ายการผลิตคงที่
                </td>
                <td rowspan="3"
                    class="text-center"
                    style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                    รวมต้นทุนการผลิต
                </td>
            </tr>
            <tr>
                <td colspan='2'
                class="text-center"
                style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                สินค้ากึ่งสำเร็จรูป
                </td>
                <td colspan='2'

                style="text-align: center; border: 1px solid #000000;   ">
                บวก งานระหว่างผลิต-ปลายงวด
                </td>
                <td colspan='2'

                style="text-align: center;  border: 1px solid #000000;   ">
                หัก งานระหว่างผลิต-ต้นงวด
                </td>
                <td colspan='2'
                class="text-center"
                style="text-align: center; border: 1px solid #000000; vertical-align: middle;">
                รวมทั้งสิ้น
                </td>
            </tr>
            <tr>
                <td style="text-align: center; border: 1px solid #000000;">
                ปริมาณ

                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    ต้นทุน
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                ปริมาณ

                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    ต้นทุน
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    ปริมาณ
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                    ต้นทุน
                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                ปริมาณ(AQ)

                </td>
                <td style="text-align: center; border: 1px solid #000000;">
                ต้นทุน(AQ*SP)
                </td>
            </tr>
        </thead>
        @php
            // Add total Lev3 20221206
            $wageAmountLev3 = 0;
            $varyAmountLev3 = 0;
            $fixedAmountLev3 = 0;
            $ingredientQuantityLev3 = 0;
            $ingredientAmountLev3 = 0;
            $totalIngredientAmountLev3 = 0;
        @endphp
        @foreach ($datas->where('level_no', 1)->groupBy('batch_no') as $lev1)
        @php
            $lev1First = $lev1->first();
            $aqQty = $lev1First->transaction_quantity + $lev1First->end_ing_quantity - $lev1First->begin_ing_quantity;
            $totalAqQty = ($totalAqQty ?? 0) + $aqQty;
        @endphp
        @if ($loop->first)
            <tr style="font-weight: bold; text-align:center">
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="border-bottom:none !important; border-right:1px solid #000" align="center">
                    <b>ศูนย์ต้นทุน {{ $lev1First->cost_code }} - {{ $lev1First->cost_description }} </b>
                </td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
                <td style="text-align: center; border-right: 1px solid #000000;"></td>
            </tr>
        @endif
        <tr >
            <td style="text-align: left; font-weight: bold; border-right: 1px solid #000000; border-left: 1px solid #000000;">
                {{$lev1First->item_number}}
            </td>
            <td style="text-align: left;font-weight: bold; border-right: 1px solid #000000;">
                {{$lev1First->item_description}}
            </td>
            <td style="text-align: center; font-weight: bold;border-right: 1px solid #000000;">
                {{ $lev1First->batch_no }}
            </td>
            <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000;">
                {{$lev1First->transaction_uom}}
            </td>
            <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;">
                {{$lev1First->transaction_quantity}}
            </td>
            <td style="text-align: center; border-right: 1px solid #000000;"></td>
            <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;">
                {{$lev1First->end_ing_quantity}}
            </td>
            <td style="text-align: center; border-right: 1px solid #000000;"></td>
            <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;">
                {{$lev1First->begin_ing_quantity}}
            </td>
            <td style="text-align: center; border-right: 1px solid #000000;"></td>
            <td style="text-align: right; font-weight: bold;border-right: 1px solid #000000;">
                {{ $aqQty }}
            </td>
            <td style="text-align: center; border-right: 1px solid #000000;"></td>
            <td style="text-align: center; border-right: 1px solid #000000;"></td>
            <td style="text-align: center; border-right: 1px solid #000000;"></td>
            <td style="text-align: center; border-right: 1px solid #000000;"></td>
            <td style="text-align: center; border-right: 1px solid #000000;"></td>
        </tr>

            @php
                $dataLevel2 = $datas->where('level_no', 2)->where('batch_no', $lev1First->batch_no);
                // Add sum total Lev3 20221206
                $wageAmountLev3 += $lev1->sum('wage_amount');
                $varyAmountLev3 += $lev1->sum('vary_amount');
                $fixedAmountLev3 += $lev1->sum('fixed_amount');

                $totalAqSp2 = 0;
                $totalIngredientAmount = 0;

            @endphp
            @if (count($dataLevel2) <= 0)
                <tr >
                    <td style="text-align: left; font-weight: bold; border-right: 1px solid #000000; border-left: 1px solid #000000;"></td>
                    <td style="text-align: right;font-weight: bold; border-right: 1px solid #000000;">รวมตามผลิตภัณฑ์ {{$lev1First->item_number}}</td>
                    <td style="text-align: center; font-weight: bold;border-right: 1px solid #000000;"></td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000;"></td>
                    <td style="text-align: center; font-weight: bold; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;"> 0.00 </td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;"> 0.00 </td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">0.00 </td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;"> 0.00 </td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $lev1->sum('wage_amount') }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $lev1->sum('vary_amount') }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $lev1->sum('fixed_amount') }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $lev1->sum('wage_amount') + $lev1->sum('vary_amount') + $lev1->sum('fixed_amount') }}</td>
                </tr>
            @endif
            @foreach ($dataLevel2->groupBy('organization_code') as $lev2)
                @php
                    $lev2First = $lev2->first();
                    // set defualt value 0 20221206
                    $wageAmount = 0;
                    $varyAmount = 0;
                    $fixedAmount = 0;
                    $ingredientQuantity = 0;
                    $ingredientAmount = 0;

                    $wageAmount = ($wageAmount ?? 0) + $lev1->sum('wage_amount');
                    $varyAmount = ($varyAmount ?? 0) + $lev1->sum('vary_amount');
                    $fixedAmount = ($fixedAmount ?? 0) + $lev1->sum('fixed_amount');

                    // change cal ingredient_quantity
                    $ingredientQuantity = $lev2->sum('ingredient_quantity') - $lev2->sum('end_ing_quantity');
                    $ingredientAmount = $lev2->sum('ingredient_amount') - $lev2->sum('end_ing_amount');
                    // $ingredientQuantity = $lev2->sum('ingredient_quantity');
                    // $ingredientAmount = $lev2->sum('ingredient_amount');
                    $totalIngredientAmount += $ingredientAmount;

                    $aqQty2 = $ingredientQuantity + $lev2->sum('end_ing_quantity') - $lev2->sum('begin_ing_quantity');
                    $aqSp2 = $ingredientAmount + $lev2->sum('end_ing_amount') - $lev2->sum('begin_ing_amount');
                    $totalAqQty2  = ($totalAqQty2 ?? 0 ) + $aqQty2;
                    $totalAqSp2 = ($totalAqSp2 ?? 0 ) + $aqSp2;
                @endphp
                <tr>
                    <td style="text-align: center; border-right: 1px solid #000000; border-left: 1px solid #000000;">
                        {{ $lev2First->organization_code }}
                    </td>
                    <td style="text-align: left; border-right: 1px solid #000000; ">
                        {{ $lev2First->organization_name }}
                    </td>
                    <td style="text-align: left; border-right: 1px solid #000000; "></td>
                    <td style="text-align: left; border-right: 1px solid #000000; "></td>
                    <td style="text-align: right; border-right: 1px solid #000000;">
                        {{ $ingredientQuantity }}
                    </td>
                    <td style="text-align: right; border-right: 1px solid #000000;">
                        {{ $ingredientAmount }}
                    </td>
                    <td style="text-align: right; border-right: 1px solid #000000;">
                        {{ $lev2->sum('end_ing_quantity') }}
                    </td>
                    <td style="text-align: right; border-right: 1px solid #000000;">
                        {{ $lev2->sum('end_ing_amount') }}
                    </td>
                    <td style="text-align: right; border-right: 1px solid #000000;">
                        {{ $lev2->sum('begin_ing_quantity') }}
                    </td>
                    <td style="text-align: right; border-right: 1px solid #000000;">
                        {{ $lev2->sum('begin_ing_amount') }}
                    </td>
                    <td style="text-align: right; border-right: 1px solid #000000;">
                        {{ $aqQty2 }}
                    </td>
                    <td style="text-align: right; border-right: 1px solid #000000;">
                        {{ $aqSp2 }}
                    </td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>

                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                </tr>
                @if ($loop->last)
                <tr >
                    <td style="text-align: left; font-weight: bold; border-right: 1px solid #000000; border-left: 1px solid #000000;"></td>
                    <td style="text-align: right;font-weight: bold; border-right: 1px solid #000000;">รวมตามคำสั่งผลิต {{$lev1First->batch_no}}</td>
                    <td style="text-align: center; font-weight: bold;border-right: 1px solid #000000;"></td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000;"></td>
                    <td style="text-align: center; font-weight: bold; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{ $totalIngredientAmount }}</td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{ $dataLevel2->sum('end_ing_amount')}}</td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{ $dataLevel2->sum('begin_ing_amount')}}</td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{ $totalAqSp2}}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $wageAmount }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $varyAmount }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $fixedAmount }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $totalAqSp2 + $wageAmount + $varyAmount + $fixedAmount }}</td>
                </tr>
                @endif
            @endforeach

            @if ($loop->last)

                <tr>
                    <td style="text-align: left; font-weight: bold; border-right: 1px solid #000000; border-left: 1px solid #000000;">
                        สรุปตาม Org.ของวัตถุดิบ
                    </td>
                    <td style="text-align: left; border-right: 1px solid #000000; "></td>
                    <td style="text-align: left; border-right: 1px solid #000000; "></td>
                    <td style="text-align: left; border-right: 1px solid #000000; "></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    <td style="text-align: right; border-right: 1px solid #000000;"></td>
                </tr>
                @php
                    $dataLevel3 = $datas->where('level_no', 2);
                @endphp
                @foreach ($dataLevel3->groupBy('organization_code') as $lev3)
                @php
                    $lev3First = $lev3->first();

                    // change cal ingredient_quantity
                    $ingredientQuantityLev3 = $lev3->sum('ingredient_quantity') - $lev3->sum('end_ing_quantity');
                    $ingredientAmountLev3 = $lev3->sum('ingredient_amount') - $lev3->sum('end_ing_amount');
                    // $ingredientQuantityLev3 = $lev3->sum('ingredient_quantity');
                    // $ingredientAmountLev3 = $lev3->sum('ingredient_amount');
                    $totalIngredientAmountLev3 += $ingredientAmountLev3;

                    $aqQty3 = $ingredientQuantityLev3 + $lev3->sum('end_ing_quantity') - $lev3->sum('begin_ing_quantity');
                    $aqSp3 = $ingredientAmountLev3 + $lev3->sum('end_ing_amount') - $lev3->sum('begin_ing_amount');
                    $totalAqQty3  = ($totalAqQty3 ?? 0 ) + $aqQty3;
                    $totalAqSp3 = ($totalAqSp3 ?? 0 ) + $aqSp3;

                    // $wageAmount = ($wageAmount ?? 0) + $lev1->sum('wage_amount');
                    // $varyAmount = ($varyAmount ?? 0) + $lev1->sum('vary_amount');
                    // $fixedAmount = ($fixedAmount ?? 0) + $lev1->sum('fixed_amount');
                @endphp

                    <tr>
                        <td style="text-align: center; border-right: 1px solid #000000; border-left: 1px solid #000000;">
                            {{ $lev3First->organization_code }}
                        </td>
                        <td style="text-align: left; border-right: 1px solid #000000; ">
                            {{ $lev3First->organization_name }}
                        </td>
                        <td style="text-align: left; border-right: 1px solid #000000; "></td>
                        <td style="text-align: left; border-right: 1px solid #000000; "></td>
                        <td style="text-align: right; border-right: 1px solid #000000;">
                            {{ $ingredientQuantityLev3 }}
                        </td>
                        <td style="text-align: right; border-right: 1px solid #000000;">
                            {{ $ingredientAmountLev3 }}
                        </td>
                        <td style="text-align: right; border-right: 1px solid #000000;">
                            {{ $lev3->sum('end_ing_quantity') }}
                        </td>
                        <td style="text-align: right; border-right: 1px solid #000000;">
                            {{ $lev3->sum('end_ing_amount') }}
                        </td>
                        <td style="text-align: right; border-right: 1px solid #000000;">
                            {{ $lev3->sum('begin_ing_quantity') }}
                        </td>
                        <td style="text-align: right; border-right: 1px solid #000000;">
                            {{ $lev3->sum('begin_ing_amount') }}
                        </td>
                        <td style="text-align: right; border-right: 1px solid #000000;">
                            {{ $aqQty3 }}
                        </td>
                        <td style="text-align: right; border-right: 1px solid #000000;">
                            {{ $aqSp3 }}
                        </td>
                        <td style="text-align: right; border-right: 1px solid #000000;"></td>
                        <td style="text-align: right; border-right: 1px solid #000000;"></td>

                        <td style="text-align: right; border-right: 1px solid #000000;"></td>
                        <td style="text-align: right; border-right: 1px solid #000000;"></td>
                    </tr>
                @endforeach
                <tr >
                    <td style="text-align: left; font-weight: bold; border-right: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000;"></td>
                    <td style="text-align: right;font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000;">รวมตามศูนย์ต้นทุน</td>
                    <td style="text-align: center; font-weight: bold;border-right: 1px solid #000000; border-bottom: 1px solid #000000;"></td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid #000000; border-bottom: 1px solid #000000;"></td>
                    <td style="text-align: center; font-weight: bold; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{ $totalIngredientAmountLev3 }}</td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{ $dataLevel3->sum('end_ing_amount')}}</td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{ $dataLevel3->sum('begin_ing_amount')}}</td>
                    <td style="text-align: center; border: 1px solid #000000;"></td>
                    <td style="text-align: right; font-weight: bold;border: 1px solid #000000;">{{ $totalAqSp3 }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $wageAmountLev3 }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $varyAmountLev3 }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $fixedAmountLev3 }}</td>
                    <td style="text-align: right; border: 1px solid #000000;">{{ $totalAqSp3 + $wageAmountLev3 + $varyAmountLev3 + $fixedAmountLev3 }}</td>
                </tr>
            @endif
        @endforeach

    </table>
    </body>
</html>
