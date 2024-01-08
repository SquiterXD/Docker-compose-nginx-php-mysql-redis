<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
            $styleBorderLRFont14    = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 14px';
            $styleBorderLRFTont14   = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 14px';
            $styleBorderLRBTFont14  = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 14px';
            $uData = [];
        @endphp  
<table border="1">

    <thead>
        <tr>
            <th align="center" style="{{$font18}}" colspan="15"> <b>  การยาสูบแห่งประเทศไทย </b> </th>
        </tr>
        <tr>
            <th style="{{$font18}}" align="left" colspan="2">รหัสโปรแกรม : CTR0002</th>
            <th style="{{$font18}}"  align="center" colspan="9"><b>กระดาษทำการคำนวณค่าวัตถุดิบ-มาตรฐานและคิดเข้างาน ตามผลิตภัณฑ์ </b> </th>
            <th style="{{$font18}}"  align="right" colspan="4"><b>วันที่พิมพ์ : </b> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i:s') }}  </th>
        </tr>
        <tr>
            <th style="{{$font18}}" align="left" colspan="2"><b>ปีงบประมาณ : {{ (request()->period_year + 543) }} </b></th>
            <th style="{{$font18}}"  align="center" colspan="9"><b>ตั้งแต่วันที่ {{ ctDateText($dateFrom , $dateTo) }} </b> </th>
            <th style="{{$font18}}"  align="right" colspan="4"> </th>
        </tr>
        <tr>
            <th style="{{$font18}}" align="left" colspan="2"><b>หน่วยงาน : {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}</b></th>
            <th style="{{$font18}}"  align="center" colspan="9"><b> {{  'ศูนย์ต้นทุน '. $cost->cost_code. ' ' . $cost->description  }} </b> </th>
            <th style="{{$font18}}"  align="right" colspan="4"> </th>
        </tr>
      <tr>
        <th align="center" rowspan="3" style="{{ $styleFont14 }}">รหัส</th>
        <th align="center" rowspan="3" style="{{ $styleFont14 }}">รายละเอียด</th>
        {{-- <th align="center" rowspan="3" style="{{ $styleFont14 }}">ตามผลิตภัณฑ์</th> --}}
        <th align="center" rowspan="3" style="{{ $styleFont14 }}">หน่วยนับ</th>
        <th align="center" style="{{ $styleBorderLRFTont14 }}">ปริมาณ</th>
        <th align="center" colspan="2" style="{{ $styleFont14 }}">ปริมาณมาตรฐาน</th>
        <th align="center" colspan="2" style="{{ $styleFont14 }}">ค่าวัตถุดิบ-มาตรฐาน</th>
        <th align="center" colspan="2" style="{{ $styleFont14 }}">ค่าวัตถุดิบ-คิดเข้างาน</th>
        <th align="center" rowspan="3" style="{{ $styleFont14 }}">ค่าแรง</th>
        <th align="center" rowspan="3" style="{{ $styleFont14 }}">ค่าใช้จ่ายการผลิตผันแปร</th>
        <th align="center" rowspan="3" style="{{ $styleFont14 }}">ค่าใช้จ่ายการผลิตคงที่</th>
        <th align="center" style="{{ $styleBorderLRFTont14 }}">รวมต้นทุนการผลิต</th>
        <th align="center" style="{{ $styleBorderLRFTont14 }}">รวมต้นทุนการผลิต</th>
      </tr>
      <tr>
        <th align="center" style=" {{ $styleBorderLRFont14 }} ">ผลผลิต</th>
        <th align="center" style=" {{ $styleBorderLRFont14 }} ">ปริมาณ</th>
        <th align="center" style=" {{ $styleBorderLRFont14 }} ">ราคาต่อหน่วย (บาท)</th>
        <th align="center" style=" {{ $styleBorderLRFont14 }} ">ปริมาณ</th>
        <th align="center" style=" {{ $styleBorderLRFont14 }} ">ต้นทุน   (บาท)</th>
        <th align="center" style=" {{ $styleBorderLRFont14 }} ">ปริมาณ</th>
        <th align="center" style=" {{ $styleBorderLRFont14 }} ">ต้นทุน (บาท)</th>
        <th align="center" rowspan="2" style=" {{ $styleBorderLRBTFont14 }} ">มาตรฐาน</th>
        <th align="center" rowspan="2" style=" {{ $styleBorderLRBTFont14 }} ">คิดเข้างาน</th>
      </tr>
      <tr>
        <th align="center" style="{{ $styleBorderLRBTFont14 }}">(Output)</th>
        <th align="center" style="{{ $styleBorderLRBTFont14 }}">SQ.</th>
        <th align="center" style="{{ $styleBorderLRBTFont14 }}">SP.</th>
        <th align="center" style="{{ $styleBorderLRBTFont14 }}">(Output * SQ)</th>
        <th align="center" style="{{ $styleBorderLRBTFont14 }}">(Output *SQ * SP) </th>
        <th align="center" style="{{ $styleBorderLRBTFont14 }}">AQ.</th>
        <th align="center" style="{{ $styleBorderLRBTFont14 }}">AQ.* SP</th>
      </tr>
    </thead>
    <tbody>
        @php
            $sumL = 0;
            $sumM = 0;
            $sumN = 0;
            $sumO = 0;
            $sumP = 0;
            $sumAmountProd = 0;
            // dd($datas);
            
        @endphp
        @foreach ($datas->sortBy('item_number')->where('level_no', 1)->groupBy('inventory_item_id') as $batchNo => $dataByItems)
            @php
                $item_first = $dataByItems->where('level_no', 1)->first();
                $itemsList = optional($item_first)->item_list;
                if($item_first == null) {
                    continue;
                 }
                // dump($item_first);
                // dd($dataByItems->toArray());
                // $output = output($dateFrom, $dateTo, request()->cost_code, request()->period_year, $dataByItems[0]->batch_no);
                $output = $item_first->transaction_quantity;
                $sumOpSq = 0;
                $sumOpSqSP = 0;
                $sumaq = 0;
                $sumaqSp = 0;
                $sumAmountProd += $output;
            @endphp
            <tr>
                <td style="{{ $styleBorderLRFont14 }}"align="center"> <b>{{ $item_first->item_number }}</b>
                </td>
                <td style="{{ $styleBorderLRFont14 }}"><b>{{ $item_first->item_description }}</b> </td>
                {{-- <td style="{{ $styleBorderLRFont14 }} bg-red">{{ $item_first->batch_no }} </td> --}}
                <td style="{{ $styleBorderLRFont14 }}"> {{ $item_first->transaction_uom }} </td>
                <td style="{{ $styleBorderLRFont14 }}"> {{ $output }} </td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                {{-- SP. --}}
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($item_first->transaction_cost, 9) }}
                </td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                {{-- ค่าแรง --}}
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($item_first->wage_cost, 9) }} </td>
                {{-- ค่าใช้จ่ายการผลิตผันแปร --}}
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($item_first->vary_cost, 9) }}
                </td>
                {{-- ค่าใช้จ่ายการผลิตคงที่ --}}
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($item_first->fixed_cost, 9) }}
                </td>
                {{-- รวมต้นทุนการผลิตมาตรฐาน --}}
                @php
                    $pSum = $item_first->transaction_cost + $item_first->wage_cost + $item_first->vary_cost + $item_first->fixed_cost;
                @endphp
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($pSum, 9) }}</td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
            </tr>
            @foreach ($itemsList->sortBy('organization_code')->where('organization_code' , '!=' , 'FG6')->groupBy('organization_code') as $orgCode => $dataByOrg)
                <tr>
                    <td style="{{ $styleBorderLRFont14 }}" colspan="2"> <b> {{ $orgCode }} :
                            {{ $dataByOrg[0]->organization_name }}</b> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                </tr>
                @php
                    $OpSq = 0;
                    $OpSqSP = 0;
                    $aq = 0;
                    $aqSp = 0;
                    
                @endphp
                @foreach ($dataByOrg->where('level_no', 2)->sortBy('item_number')->groupBy('item_number') as $itemNo => $data)
                    @php
                        // $requireQty = $data->where('ct_group_code', 'CT_CS_STD_COST')->first() ? $data->where('ct_group_code', 'CT_CS_STD_COST')->first()->require_qty : 0;
                        
                        // $OpSq += $output * $requireQty;
                        // $OpSqSP += $output * $requireQty * $data[0]->transaction_cost;
                        // $aq += $data->where('ct_group_code', 'CT_CS_ABSORBED')->sum('transaction_quantity');
                        // $aqSp += $data->where('ct_group_code', 'CT_CS_ABSORBED')->sum('transaction_quantity') * $data[0]->transaction_cost;
                    @endphp
                    <tr>
                        <td align="center" style="{{ $styleBorderLRFont14 }}"> {{ $itemNo }} </td>
                        <td style="{{ $styleBorderLRFont14 }}"> {{ $data[0]->item_description }} </td>
                        <td align="left" style="{{ $styleBorderLRFont14 }}">
                            {{ $data[0]->transaction_uom }}</td>
                        <td style="{{ $styleBorderLRFont14 }}"> </td>
                        {{-- SQ --}}
                        <td style="{{ $styleBorderLRFont14 }}">{{ $data[0]->ingredient_std_quantity }}</td>
                        {{-- sp --}}
                        <td style="{{ $styleBorderLRFont14 }}">{{ $data[0]->ingredient_cost }}</td>
                        {{-- (Output * SQ) --}}
                        @php
                            $OpSq +=  $data[0]->ingredient_quantity;
                            $OpSqSP += $data[0]->ingredient_amount;
                            $aq += $data[0]->dm_absorption_quantity;
                            $aqSp += $data[0]->dm_absorption_amount;
                        @endphp
                        <td style="{{ $styleBorderLRFont14 }}">{{ $data[0]->ingredient_quantity }}
                        </td>
                        {{-- (Output *SQ * SP) --}}
                        <td style="{{ $styleBorderLRFont14 }}">
                            {{ $data[0]->ingredient_amount }}</td>
                        {{-- AQ --}}
                        <td style="{{ $styleBorderLRFont14 }}">{{ $data[0]->dm_absorption_quantity }} </td>
                        {{-- AQ.* SP --}}
                        <td style="{{ $styleBorderLRFont14 }}">
                            {{ $data[0]->dm_absorption_amount }} </td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                    </tr>
                    @if ($loop->last)
                        @php
                            $sumOpSq += $OpSq;
                            $sumOpSqSP += $OpSqSP;
                            $sumaq += $aq;
                            $sumaqSp += $aqSp;
                            $uData[$orgCode]['sumOpSq'][] = $OpSq ?? 0;
                            $uData[$orgCode]['sumOpSqSP'][] = $OpSqSP ?? 0;
                            $uData[$orgCode]['sumaq'][] = $aq ?? 0;
                            $uData[$orgCode]['sumaqSp'][] = $aqSp ?? 0;
                            
                            // $sumL = 0;
                            // $sumM = 0;
                            // $sumN = 0;
                            // $sumO = 0;
                            // $sumP = 0;
                            
                        @endphp
                        <tr>
                            <td style="{{ $styleFont14 }}" align="center" colspan="2"> <b> รวม
                                    {{ $orgCode }} : {{ $dataByOrg[0]->organization_name }} </b> </td>
                            <td style="{{ $styleFont14 }}" colspan="4"></td>
                            <td style="{{ $styleFont14 }}"> <b> {{ $OpSq }} </b> </td>
                            <td style="{{ $styleFont14 }}"> <b> {{ $OpSqSP }}</b> </td>
                            <td style="{{ $styleFont14 }}"> <b> {{ $aq }} </b> </td>
                            <td style="{{ $styleFont14 }}"> <b> {{ $aqSp }} </b> </td>
                            <td style="{{ $styleFont14 }}"></td>
                            <td style="{{ $styleFont14 }}"></td>
                            <td style="{{ $styleFont14 }}"></td>
                            <td style="{{ $styleFont14 }}"></td>
                            <td style="{{ $styleFont14 }}"></td>
                        </tr>
                    @endif
                @endforeach
                @php
                    // $sumL = 0;
                    // $sumM = 0;
                    // $sumN = 0;
                    // $sumO = 0;
                    // $sumP = 0;
                    
                    // $uData[$orgCode]['sumOpSq'][]       = $sumOpSq;
                    // $uData[$orgCode]['sumOpSqSP'][]     = $OpSqSP;
                    // $uData[$orgCode]['sumaq'][]         = $aq;
                    // $uData[$orgCode]['sumaqSp'][]       = $aqSp;
                @endphp

                @if ($loop->last)
                    @php
                        $tSumOpSq = 0;
                        $tSumOpSqSP = 0;
                        $tSumaq = 0;
                        $tSumaqSp = 0;
                        // ------------------------------------------
                        $sumL += $item_first->wage_amount;
                        $sumM += $item_first->vary_amount;
                        $sumN += $item_first->fixed_amount;
                        $sumO += $sumOpSqSP + $item_first->wage_amount + $item_first->vary_amount + $item_first->fixed_amount;
                        $sumP += $sumaqSp + $item_first->wage_amount + $item_first->vary_amount + $item_first->fixed_amount;
                    @endphp
                    <tr>
                        <td style="{{ $styleFont16 }}" align="center" colspan="3"> <b> รวมตามผลิตภัณฑ์  :
                                {{ $item_first->item_number }} {{$item_first->item_description}}</b> </td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"><b> {{ $sumOpSq }} </b> </td>
                        <td style="{{ $styleFont16 }}"><b> {{ $sumOpSqSP }} </b> </td>
                        <td style="{{ $styleFont16 }}"><b> {{ $sumaq }} </b> </td>
                        <td style="{{ $styleFont16 }}"><b> {{ $sumaqSp }} </b> </td>
                        <td style="{{ $styleFont16 }}"> <b> {{ $item_first->wage_amount }} </b>
                        </td>
                        <td style="{{ $styleFont16 }}"> <b> {{ $item_first->vary_amount }} </b>
                        </td>
                        <td style="{{ $styleFont16 }}"> <b> {{ $item_first->fixed_amount }} </b>
                        </td>
                        <td style="{{ $styleFont16 }}"> <b>
                                {{ $sumOpSqSP +
                                    $item_first->wage_amount +
                                    $item_first->vary_amount +
                                    $item_first->fixed_amount }}
                            </b> </td>
                        <td style="{{ $styleFont16 }}"> <b>
                                {{ $sumaqSp +
                                    $item_first->wage_amount +
                                    $item_first->vary_amount +
                                    $item_first->fixed_amount }}
                            </b>
                        </td>
                    </tr>
                @endif
            @endforeach

            @if ($loop->last)
                <tr>
                    <td colspan="15" style="{{ $styleFont16 }}">
                        <b>สรุปตาม Org.ของวัตถุดิบ</b>
                    </td>
                </tr>
                @foreach ($datas->where('organization_code' , '!=' , 'FG6')->sortBy('organization_code')->groupBy('organization_code') as $orgCode => $itemByOrg)
                    @php
                        $sumIngredientQuantity = $itemByOrg->sum('ingredient_quantity');
                        $sumIngredientAmount = $itemByOrg->sum('ingredient_amount');
                        $sumDmAbsorptionQuantity = $itemByOrg->sum('dm_absorption_quantity');
                        $sumDmAbsorptionAmount = $itemByOrg->sum('dm_absorption_amount');

                        $tSumOpSq += $sumIngredientQuantity;
                        $tSumOpSqSP += $sumIngredientAmount;
                        $tSumaq += $sumDmAbsorptionQuantity;
                        $tSumaqSp += $sumDmAbsorptionAmount;
                    @endphp
                    @if ($sumIngredientQuantity && $sumIngredientAmount && $sumDmAbsorptionQuantity && $sumDmAbsorptionAmount)
                    <tr>
                        <td style="{{ $styleFont16 }}" align="left" colspan="2">
                            <b> {{ $orgCode }} : {{ optional($itemByOrg[0])->organization_name }} </b>
                        </td>
                        <td style="{{ $styleFont16 }}"><b></b></td>
                        <td style="{{ $styleFont16 }}"><b></b></td>
                        <td style="{{ $styleFont16 }}"><b></b></td>
                        <td style="{{ $styleFont16 }}"><b></b></td>
                        <td style="{{ $styleFont16 }}">
                            <b> {{ $sumIngredientQuantity }} </b>
                        </td>
                        <td style="{{ $styleFont16 }}">
                            <b> {{ $sumIngredientAmount }} </b>
                        </td>
                        <td style="{{ $styleFont16 }}">
                            <b> {{ $sumDmAbsorptionQuantity }} </b>
                        </td>
                        <td style="{{ $styleFont16 }}">
                            <b> {{ $sumDmAbsorptionAmount }} </b>
                        </td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                    </tr>
                    @endif
                    @if ($loop->last)
                        <tr>
                            <td style="{{ $styleFont16 }}" align="center" colspan="2"> <b> รวมทั้งสิ้น </b>
                            </td>
                            <td style="{{ $styleFont16 }}"><b></b></td>
                            <td style="{{ $styleFont16 }}"><b> {{$sumAmountProd}}</b></td>
                            <td style="{{ $styleFont16 }}"><b></b></td>
                            <td style="{{ $styleFont16 }}"><b></b></td>
                            <td style="{{ $styleFont16 }}"><b> {{ $tSumOpSq }} </b> </td>
                            <td style="{{ $styleFont16 }}"><b> {{ $tSumOpSqSP }} </b> </td>
                            <td style="{{ $styleFont16 }}"><b> {{ $tSumaq }} </b> </td>
                            <td style="{{ $styleFont16 }}"><b> {{ $tSumaqSp }} </b> </td>
                            <td style="{{ $styleFont16 }}"><b>{{ $sumL }} </b> </td>
                            <td style="{{ $styleFont16 }}"><b>{{ $sumM }} </b> </td>
                            <td style="{{ $styleFont16 }}"><b>{{ $sumN }} </b> </td>
                            <td style="{{ $styleFont16 }}"><b>{{ $sumO }} </b> </td>
                            <td style="{{ $styleFont16 }}"><b>{{ $sumP }} </b> </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach
    </tbody>
    {{-- <tbody>
        @php
            // $sumOpSq        = 0;
            // $sumOpSqSP      = 0;
            // $sumaq          = 0;
            // $sumaqSp        = 0;


            $sumL = 0;
            $sumM = 0;
            $sumN = 0;
            $sumO = 0;
            $sumP = 0;

            // dd($datas);
        @endphp
        @foreach ($datas->groupBy('product_item_no')  as $productItemNo  =>  $dataByItems)
        @php
            $output = outputByProduct($dateFrom , $dateTo ,  request()->cost_code, request()->period_year , $dataByItems->unique('batch_no')->pluck('batch_no'));

            $sumOpSq        = 0;
            $sumOpSqSP      = 0;
            $sumaq          = 0;
            $sumaqSp        = 0;
        @endphp
            <tr>
                <td style="{{ $styleBorderLRFont14 }}"align="center"> {{ $dataByItems[0]->product_item_no }} </td>
                <td style="{{ $styleBorderLRFont14 }}">{{ $dataByItems[0]->product_item_desc }}  </td>
                <td style="{{ $styleBorderLRFont14 }} bg-red">{{ $productItemNo }}  </td>
                <td style="{{ $styleBorderLRFont14 }}"> {{ $dataByItems[0]->product_unit_of_measure }} </td>
                <td style="{{ $styleBorderLRFont14 }}"> {{ $output }} </td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($dataByItems[0]->cost_raw_mate, 9)  }}  </td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($dataByItems[0]->wage_cost, 9) }} </td>
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($dataByItems[0]->vary_cost , 9)}} </td>
                <td style="{{ $styleBorderLRFont14 }}">@ {{ number_format($dataByItems[0]->fixed_cost , 9) }} </td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
                <td style="{{ $styleBorderLRFont14 }}"></td>
            </tr>
            @foreach ($dataByItems->where('organization_code' , '!=' , 'FG6')->groupBy('organization_code')  as $orgCode  =>  $dataByOrg)
                <tr>
                    <td style="{{ $styleBorderLRFont14 }}" colspan="2"> <b> {{ $orgCode  }} : {{$dataByOrg[0]->organization_name }}</b> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"> </td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                    <td style="{{ $styleBorderLRFont14 }}"></td>
                </tr>
                @php
                    $OpSq    = 0;
                    $OpSqSP    = 0;
                    $aq     = 0;
                    $aqSp    = 0;

                @endphp
                @foreach ($dataByOrg->groupBy('item_number') as $itemNo => $data)
                    @php
                        $requireQty =  $data->where('ct_group_code' , 'CT_CS_STD_COST')->first() 
                                            ? $data->where('ct_group_code' , 'CT_CS_STD_COST')->first()->require_qty
                                            : 0;


                        $OpSq   +=  $output* $requireQty;
                        $OpSqSP +=  $output*$requireQty* $data[0]->transaction_cost;
                        $aq     +=  $data->where('ct_group_code' , 'CT_CS_ABSORBED')->sum('transaction_quantity') ;
                        $aqSp   +=  $data->where('ct_group_code' , 'CT_CS_ABSORBED')->sum('transaction_quantity')  * $data[0]->transaction_cost;
                    @endphp
                    <tr>
                        <td align="center" style="{{ $styleBorderLRFont14 }}"> {{ $itemNo }} </td>
                        <td style="{{ $styleBorderLRFont14 }}"> {{$data[0]->item_desc }} </td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td align="left" style="{{ $styleBorderLRFont14 }}"> {{ $data[0]->th_detail_unit_of_measure }}</td>
                        <td style="{{ $styleBorderLRFont14 }}"> </td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $requireQty }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $data[0]->transaction_cost}} </td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $output* $requireQty }}   </td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ ($output*  $requireQty)  * $data[0]->transaction_cost    }}</td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $data->where('ct_group_code' , 'CT_CS_ABSORBED')->sum('transaction_quantity') }} </td>
                        <td style="{{ $styleBorderLRFont14 }}">{{ $data->where('ct_group_code' , 'CT_CS_ABSORBED')->sum('transaction_quantity') * $data[0]->transaction_cost }}  </td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                        <td style="{{ $styleBorderLRFont14 }}"></td>
                    </tr>
                    @if ($loop->last)
                        @php
                            $sumOpSq += $OpSq;
                            $sumOpSqSP += $OpSqSP;
                            $sumaq  += $aq;
                            $sumaqSp += $aqSp;

                            $uData[$orgCode]['sumOpSq'][]       = $OpSq;
                            $uData[$orgCode]['sumOpSqSP'][]     = $OpSqSP;
                            $uData[$orgCode]['sumaq'][]         = $aq;
                            $uData[$orgCode]['sumaqSp'][]       = $aqSp;

                            // $sumL = 0;
                            // $sumM = 0;
                            // $sumN = 0;
                            // $sumO = 0;
                            // $sumP = 0;
                        @endphp
                        <tr>
                            <td style="{{  $styleFont14 }}" align="center"  colspan="2"> <b> รวม {{ $orgCode  }} : {{$dataByOrg[0]->organization_name }} </b> </td>
                            <td style="{{  $styleFont14 }}" colspan="5"></td>
                            <td style="{{  $styleFont14 }}"> <b> {{ $OpSq }} </b>  </td>
                            <td style="{{  $styleFont14 }}"> <b> {{ $OpSqSP }}</b> </td>
                            <td style="{{  $styleFont14 }}"> <b> {{ $aq }} </b> </td>
                            <td style="{{  $styleFont14 }}"> <b> {{ $aqSp }} </b> </td>
                            <td style="{{  $styleFont14 }}"></td>
                            <td style="{{  $styleFont14 }}"></td>
                            <td style="{{  $styleFont14 }}"></td>
                            <td style="{{  $styleFont14 }}"></td>
                            <td style="{{  $styleFont14 }}"></td>
                        </tr>
                    @endif

                @endforeach
                @php
                    // $sumL = 0;
                    // $sumM = 0;
                    // $sumN = 0;
                    // $sumO = 0;
                    // $sumP = 0;

                    // $uData[$orgCode]['sumOpSq'][]       = $sumOpSq;
                    // $uData[$orgCode]['sumOpSqSP'][]     = $OpSqSP;
                    // $uData[$orgCode]['sumaq'][]         = $aq;
                    // $uData[$orgCode]['sumaqSp'][]       = $aqSp;

                @endphp
                
                @if ($loop->last)
                    @php
                        $tSumOpSq = 0;
                        $tSumOpSqSP  = 0;
                        $tSumaq  = 0;
                        $tSumaqSp = 0;

                        $sumL += $output *  $dataByItems[0]->wage_cost;
                        $sumM += $output *  $dataByItems[0]->vary_cost;
                        $sumN += $output *  $dataByItems[0]->fixed_cost;
                        $sumO +=$sumOpSqSP +  
                                    $output *  $dataByItems[0]->wage_cost +
                                    $output *  $dataByItems[0]->vary_cost +
                                    $output *  $dataByItems[0]->fixed_cost;
                        $sumP += $sumaqSp  + $output *  $dataByItems[0]->wage_cost + $output *  $dataByItems[0]->vary_cost + $output *  $dataByItems[0]->fixed_cost;
                    @endphp
                        <tr>
                            <td style="{{ $styleFont16  }}" align="center" colspan="2"> <b> ตามผลิตภัณฑ์ : {{ $dataByItems[0]->product_item_no  }} </b> </td>
                            <td style="{{ $styleFont16  }}"></td>
                            <td style="{{ $styleFont16  }}"></td>
                            <td style="{{ $styleFont16  }}"></td>
                            <td style="{{ $styleFont16  }}"></td>
                            <td style="{{ $styleFont16  }}"></td>
                            <td style="{{ $styleFont16  }}"><b> {{ $sumOpSq}} </b>  </td>
                            <td style="{{ $styleFont16  }}"><b> {{ $sumOpSqSP }} </b>  </td>
                            <td style="{{ $styleFont16  }}"><b> {{ $sumaq }} </b>  </td>
                            <td style="{{ $styleFont16  }}"><b> {{ $sumaqSp }}   </b>  </td>
                            <td style="{{ $styleFont16  }}"> <b> {{ $output *  $dataByItems[0]->wage_cost  }} </b> </td>
                            <td style="{{ $styleFont16  }}"> <b> {{ $output *  $dataByItems[0]->vary_cost  }} </b> </td>
                            <td style="{{ $styleFont16  }}"> <b> {{ $output *  $dataByItems[0]->fixed_cost  }} </b></td>
                            <td style="{{ $styleFont16  }}"> <b> {{ $sumOpSqSP +  
                                    $output *  $dataByItems[0]->wage_cost +
                                    $output *  $dataByItems[0]->vary_cost +
                                    $output *  $dataByItems[0]->fixed_cost  }} </b>  </td>
                            <td style="{{ $styleFont16  }}"> <b> {{ $sumaqSp  +
                                $output *  $dataByItems[0]->wage_cost +
                                $output *  $dataByItems[0]->vary_cost +
                                $output *  $dataByItems[0]->fixed_cost }} </b> 
                            </td>
                        </tr>
                        @endif
            @endforeach
            @if ($loop->last)
                <tr>
                    <td colspan="16" style="{{ $styleFont16  }}">
                        <b>สรุปตาม Org.ของวัตถุดิบ</b> 
                    </td>
                </tr>
                @foreach ($datas->where('organization_code' , '!=' , 'FG6')->groupBy('organization_code') as $orgCode => $itemByOrg)
                @php

                    $tSumOpSq  +=   array_sum($uData[$orgCode]['sumOpSq']);
                    $tSumOpSqSP +=  array_sum($uData[$orgCode]['sumOpSqSP']);
                    $tSumaq +=  array_sum($uData[$orgCode]['sumaq']);
                    $tSumaqSp +=  array_sum($uData[$orgCode]['sumaqSp']);

                @endphp
                    <tr>
                        <td  style="{{ $styleFont16  }}" align="left" colspan="2"> <b> {{ $orgCode }} : {{$itemByOrg[0]->organization_name}} </b> </td>
                        <td style="{{ $styleFont16  }}" colspan="5"></td>
                        <td style="{{ $styleFont16  }}"><b> {{ array_sum($uData[$orgCode]['sumOpSq']) }} </b>  </td>
                        <td style="{{ $styleFont16  }}"><b> {{ array_sum($uData[$orgCode]['sumOpSqSP']) }}    </b></td>
                        <td style="{{ $styleFont16  }}"><b> {{ array_sum($uData[$orgCode]['sumaq']) }}  </b></td>
                        <td style="{{ $styleFont16  }}"><b> {{ array_sum($uData[$orgCode]['sumaqSp']) }} </b></td>
                        <td style="{{ $styleFont16  }}"></td>
                        <td style="{{ $styleFont16  }}"></td>
                        <td style="{{ $styleFont16  }}"></td>
                        <td style="{{ $styleFont16  }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                    </tr>
                    @if ($loop->last)
                        <tr>
                            <td  style="{{ $styleFont16  }}" align="center" colspan="2"> <b> รวมทั้งสิ้น </b> </td>
                            <td style="{{ $styleFont16  }}" colspan="5"></td>
                            <td style="{{ $styleFont16  }}"><b> {{$tSumOpSq }} </b>  </td>
                            <td style="{{ $styleFont16  }}"><b> {{$tSumOpSqSP}} </b>  </td>
                            <td style="{{ $styleFont16  }}"><b> {{$tSumaq }}  </b> </td>
                            <td style="{{ $styleFont16  }}"><b> {{$tSumaqSp }} </b> </td>
                            <td style="{{ $styleFont16  }}"><b>{{ $sumL }}  </b> </td>
                            <td style="{{ $styleFont16  }}"><b>{{ $sumM }}  </b> </td>
                            <td style="{{ $styleFont16  }}"><b>{{ $sumN }}  </b> </td>
                            <td style="{{ $styleFont16  }}"><b>{{ $sumO }} </b>  </td>
                            <td style="{{ $styleFont16  }}"><b>{{ $sumP }} </b>  </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach
    </tbody> --}}
    </table>
    </body>
</html>
