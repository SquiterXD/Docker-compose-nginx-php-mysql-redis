<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

</head>

<body>
    @php
        $styleTh = 'border: 1px solid black; line-height: 100px';
        $styleFont16 = 'border: 1px solid black; font-size: 16px';
        $styleFont14 = 'border: 1px solid black; font-size: 14px';
        $font18 = 'font-size: 18px';
        $font16 = 'font-size: 16px';
        $font14 = 'font-size: 14px';
        $styleBorderLRFont14 = 'border-left: 1px solid black; border-right: 1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; font-size: 14px';
        $uData = [];
        $sysdate = Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
    @endphp
    <table>
        <thead>
            <tr>
                <td align="left" style="{{ $font18 }}"><b> โปรแกรม : CTR0003 </b></td>
                <td align="center" colspan="5" style="{{ $font18 }}"><b> การยาสูบแห่งประเทศไทย </b></td>
                <td style="{{ $font18 }}"><b>วันที่พิมพ์ : </b> {{ $sysdate }} </td>
            </tr>
            <tr>
                <td align="left" style="{{ $font18 }}"><b> พิมพ์โดย : </b> {{$userProfile->user_name }} </td>
                <td align="center" colspan="5" style="{{ $font18 }}"><b> กระดาษทำการคำนวณค่าวัตถุดิบ-คิดเข้างาน - แยกตามผลิตภัณฑ์ </b></td>
                <td style="{{ $font18 }}"></td>
            </tr>
            <tr>
                <td align="left" style="{{ $font18 }}">  </td>
                <td align="center" colspan="5" style="{{ $font18 }}"><b> {{ ctDateText($dateFrom , $dateTo) }} </b></td>
                <td style="{{ $font18 }}"></td>
            </tr>
            <tr>
                <td align="left" style="{{ $font18 }}">  </td>
                <td align="center" colspan="5" style="{{ $font18 }}"><b>{{  'ศูนย์ต้นทุน '. $cost->cost_code. ' ' . $cost->description  }} </b></td>
                <td style="{{ $font18 }}"></td>
            </tr>
            <tr>
                <td align="left" style="{{ $font18 }}" colspan="2"><b>หน่วยงาน :  {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}</b></td>
                <td align="center" colspan="5" style="{{ $font18 }}"></td>
                <td style="{{ $font18 }}"></td>
            </tr>
            <tr>
                <th style="{{ $styleFont16 }}" align="center" rowspan="3"><b> รหัส </b></th>
                <th style="{{ $styleFont16 }}" align="center" rowspan="3"><b> รายละเอียด </b></th>
                <th style="{{ $styleFont16 }}" align="center" rowspan="3"><b> หน่วยนับ </b></th>
                <th style="{{ $styleFont16 }}" align="center"><b>  ปริมาณผลผลิต </b></th>
                <th style="{{ $styleFont16 }}" align="center"  colspan="3"><b> ค่าวัตถุดิบ-คิดเข้างาน </b></th>
            </tr>
            <tr>
                <th style="{{ $styleFont16 }}" align="center" rowspan="2"><b> (Output) </b></th>
                <th style="{{ $styleFont16 }}" align="center"><b> ปริมาณ </b></th>
                <th style="{{ $styleFont16 }}" align="center"><b> ราคาต่อหน่วย(บาท) </b></th>
                <th style="{{ $styleFont16 }}" align="center"><b> ต้นทุน (บาท) </b></th>
            </tr>
            <tr>
                <th style="{{ $styleFont16 }}" align="center"><b> AQ. </b></th>
                <th style="{{ $styleFont16 }}" align="center"><b> SP. </b></th>
                <th style="{{ $styleFont16 }}" align="center"><b> AQ.*SP </b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas_level_1->groupBy('inventory_item_id') as $invId => $dataByInvIds)
                @php
                    $dataInv = $dataByInvIds->first();
                    $checkInv = $datas_level_2->where('product_item_id', $invId);
                    if( !$checkInv->count() ){
                        continue;
                    }
                @endphp
                <tr>
                    <td style="{{ $styleFont16 }}" align="left"><b> {{ optional($dataInv)->item_number }} </b></td>
                    <td style="{{ $styleFont16 }}" align="left"><b> {{ optional($dataInv)->item_description }} </b></td>
                    <td style="{{ $styleFont16 }}" align="left"><b> {{ optional($dataInv)->transaction_uom }} </b></td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}"></td>
                    <td style="{{ $styleFont16 }}"></td>
                </tr>
                @foreach ($datas_level_2->where('product_item_id', $invId)->sortBy('wip_step')->groupBy('wip_step') as $wip => $dataByWip)
                    @php 
                        $dataWip = $dataByWip->first();
                        $dataInvWip = $datas_level_1->where('inventory_item_id', $invId)->where('wip_step', $wip)->first();
                        $sumWipAQ = 0;
                        $sumWipAQSP = 0;
                    @endphp
                    <tr>
                        <td style="{{ $styleFont16 }}" align="left" colspan="2"><b> {{ $wip }} {{ optional($dataWip)->wip_desc }} </b></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}" align="right"><b> {{ optional($dataInvWip)->transaction_quantity }} </b></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                        <td style="{{ $styleFont16 }}"></td>
                    </tr>
                    @foreach ($dataByWip->sortBy('tobacco_group_code')->groupBy('tobacco_group_code') as $tobaccoGroupCode => $dataByGroupCode)
                        @php
                            $dataGroupCode = $dataByGroupCode->first();
                            $sumAQ = 0;
                            $sumAQSP = 0;
                        @endphp
                        <tr>
                            <td style="{{ $styleFont16 }}" align="left"><b> {{ $tobaccoGroupCode }} </b></td>
                            <td style="{{ $styleFont16 }}" align="left"><b> {{ optional($dataGroupCode)->tobacco_group }} </b></td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                            <td style="{{ $styleFont16 }}"></td>
                        </tr>
                        @foreach ($dataByGroupCode->sortBy('item_number') as $data)
                            @php 
                                $sumAQ += $data->ingredient_quantity;
                                $sumAQSP += $data->ingredient_amount;
                            @endphp
                            <tr>
                                <td style="{{ $styleFont14 }}" align="left"> {{ $data->item_number }} </td>
                                <td style="{{ $styleFont14 }}" align="left"> {{ $data->item_description }} </td>
                                <td style="{{ $styleFont14 }}"> {{ $data->transaction_uom }} </td>
                                <td style="{{ $styleFont14 }}"></td>
                                <td style="{{ $styleFont14 }}" align="right"> {{ $data->ingredient_quantity }} </td> {{-- AQ --}}
                                <td style="{{ $styleFont14 }}" align="right"> {{ $data->ingredient_cost }} </td> {{-- SP --}}
                                <td style="{{ $styleFont14 }}" align="right"> {{ $data->ingredient_amount }} </td> {{-- AQ*SP --}}
                            </tr>
                            @if ($loop->last)
                                @php
                                    $sumWipAQ += $sumAQ;
                                    $sumWipAQSP += $sumAQSP;
                                @endphp
                                <tr>
                                    <td colspan="2" align="center" style="{{ $styleFont16 }}"><b>รวม {{ $tobaccoGroupCode }} {{ $dataGroupCode->tobacco_group }} </b></td>
                                    <td style="{{ $styleFont16 }}"></td>
                                    <td style="{{ $styleFont16 }}"></td>
                                    <td style="{{ $styleFont16 }}" align="right"><b> {{ $sumAQ }} </b></td>
                                    <td style="{{ $styleFont16 }}"></td>
                                    <td style="{{ $styleFont16 }}" align="right"><b> {{ $sumAQSP }} </b></td>
                                </tr>
                            @endif
                        @endforeach
                        @if ($loop->last)
                            <tr>
                                <td colspan="2" align="center" style="{{ $styleFont16 }}"><b> รวมตาม {{ $wip  }} {{ optional($dataWip)->wip_desc }}</b></td>
                                <td style="{{ $styleFont16 }}"></td>
                                <td style="{{ $styleFont16 }}"></td>
                                <td style="{{ $styleFont16 }}" align="right"><b> {{ $sumWipAQ }} </b></td>
                                <td style="{{ $styleFont16 }}"></td>
                                <td style="{{ $styleFont16 }}" align="right"><b> {{ $sumWipAQSP }} </b></td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
