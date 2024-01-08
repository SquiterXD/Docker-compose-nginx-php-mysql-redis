<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    <style>
        <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }
        
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
        }

        thead{display: table-header-group;}
        tfoot {display: table-row-group;}
        tr {page-break-inside: avoid;}
        
        body {
            font-family: "THSarabunNew" !important;
        }
        table {
            width:100%;
            border-collapse: collapse;
        }
        td {
            border:none !important;
        }
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
        .border {
            border-top:1px solid #000 !important;
            border-bottom:1px solid #000 !important;
        }

    </style>
</head>

<body>
    @php
        $styleTh = ' line-height: 100px';
        $styleFont18 = ' font-size: 18px !important; ';
        $styleFont16 = ' font-size: 16px';
        $styleFont14 = ' font-size: 14px';
        $font18 = 'font-size: 18px';
        $font16 = 'font-size: 16px';
        $font14 = 'font-size: 14px';
        $styleBorderLRFont14 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 14px';
        $styleBorderLRFTont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 14px';
        $styleBorderLRBTFont14 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 14px';
        $styleBorderLRFont16 = 'border-left:  1px solid black; border-right:  1px solid black; font-size: 16px';
        $styleBorderLRFTont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-top:  1px solid black;  font-size: 16px';
        $styleBorderLRBTFont16 = 'border-left:  1px solid black; border-right:  1px solid black; border-bottom:  1px solid black; font-size: 16px';
        $styleBorderAll = 'border-top:1px solid #000 !important; border-bottom:1px solid #000 !important; border-right:1px solid #000 !important; border-left:1px solid #000 !important;';
        $uData = [];
    @endphp

    @php 
    $dataLevel1 = $datas->where('level_no', 1);
    $i = 0;
    @endphp
    @foreach ($dataLevel1->sortBy('transaction_date')->groupBy('transaction_date') as $date => $uData)
    
    @foreach ($uData->sortBy('batch_no')->groupBy('batch_no') as $batchNo => $dataByDate)
    @php 
    $i++;
    @endphp
    @if($i != 1)
    <div class="page"></div>
    @endif
    <table class="table" style="table-layout: auto;">
                <thead>
                    <tr>
                        <td colspan="7">
                            <table style="width:100%; border-collapse: collapse">
                                <tr>
                                    <td style="width:33%">
                                        <b> โปรแกรม : CTR0004 </b>  <br> <br> <br>
                                        <b> วันที่เริ่มผลิต :
                                            {{ Carbon\Carbon::create($datas[0]->plan_start_date)->addYear('543')->format('d/m/Y') }}
                                        </b> <br>
                                        <b>วันที่ผลิตเสร็จ :
                                            {{ Carbon\Carbon::create($datas[0]->plan_cmplt_date)->addYear('543')->format('d/m/Y') }}
                                        </b> <br>
                                        <b> เลขที่คำสั่งผลิต :{{ $batchNo }} </b> <br>
                                        <b> รหัสสินค้า/ชื่อสินค้า :
                                            {{ $dataByDate[0]->item_number . ' ' . $dataByDate[0]->item_description }} </b>
                                        
                                    </td>
                                    <td align="center" style="width:33%; vertical-align: top">
                                        <b> การยาสูบแห่งประเทศไทย </b> <br>
                                        <b>รายงานบัตรต้นทุนประจำวัน
                                            {{-- ({{ $cost->cost_code . ' ' . $cost->description }}) --}}
                                        </b> <br>
                                        <b> ประจำวันที่ :
                                            {{ Carbon\Carbon::create($date)->addYear('543')->format('d/m/Y') }} </b>
                                    </td>
                                    <td style="width:33%; vertical-align: top" align="right"><b>หน้าที่ :</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">&nbsp;</td>
                    </tr>
                        {{-- <tr>
                            <td style="{{ $font18 }}"> <b> โปรแกรม : CTR0004 </b> </td>
                            <td style="{{ $font18 }}" colspan="5" align="center"> <b> การยาสูบแห่งประเทศไทย </b>
                            </td>
                            <td style="{{ $font18 }}"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="{{ $font18 }}" colspan="5" align="center"> <b>รายงานบัตรต้นทุนประจำวัน
                                </b></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td  style="{{ $font18 }}"  colspan="5" align="center"><b> ประจำวันที่ :
                                {{ Carbon\Carbon::create($date)->addYear('543')->format('d/m/Y') }} </b></td>
                        </tr>
                    <tr>
                        <td style="{{ $font18 }}"><b> วันที่เริ่มผลิต :
                                {{ Carbon\Carbon::create($datas[0]->plan_start_date)->addYear('543')->format('d/m/Y') }}
                            </b></td>
                        <td style="{{ $font18 }}" colspan="5"></td>
                        <td style="{{ $font18 }}"> </td>
                    </tr>
                    <tr>
                        <td style="{{ $font18 }}"> <b>วันที่ผลิตเสร็จ :
                                {{ Carbon\Carbon::create($datas[0]->plan_cmplt_date)->addYear('543')->format('d/m/Y') }}
                            </b></td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="{{ $font18 }}"><b> เลขที่คำสั่งผลิต :{{ $batchNo }} </b></td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="{{ $font18 }}"> <b> รหัสสินค้า/ชื่อสินค้า :
                                {{ $dataByDate[0]->item_number . ' ' . $dataByDate[0]->item_description }} </b> </td>
                        <td colspan="5"></td>
                        <td></td>
                    </tr> --}}
                    
                    <tr>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}" rowspan="2"><b> รายการ </b> </td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}" colspan="2"><b> ต้นทุนคิดเข้างาน </b> </td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}"><b>
                                <span style="color:#fff">&nbsp;</span> {{ number_format($dataByDate[0]->wage_cost, 9) }} </b> </td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}"><b>
                            <span style="color:#fff">&nbsp;</span> {{ number_format($dataByDate[0]->vary_cost, 9) }} </b> </td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}"><b>
                            <span style="color:#fff">&nbsp;</span> {{ number_format($dataByDate[0]->fixed_cost, 9) }} </b> </td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }} width:100px !important; " rowspan="2"><b> รวมต้นทุนคิดเข้างาน </b>
                        </td>
                    </tr>
                    <tr class="border">
                        {{-- <td align="center" style="{{ $styleBorderLRBTFont16 }}" ></td> --}}
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}"><b> ปริมาณ {{number_format($dataByDate[0]->cost_quantity, 2)}} {{$dataByDate[0]->cost_uom}} </b></td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}"><b> วัตถุดิบ </b></td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}"><b> ค่าแรง </b></td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}"><b> ค่าใช้จ่ายผันแปร </b></td>
                        <td class="border" align="center" style="{{ $styleFont16 . $styleBorderAll }}"><b> ค่าใช้จ่ายคงที่ </b></td>
                    </tr>
                </thead>

                <tbody>
                    @php 
                        $totalWage = 0;
                        $totalFixed = 0;
                        $totalVary = 0;
                        $wipStep = $datas->where('level_no', '2')->where('batch_no',$batchNo)->where('transaction_date', $date)->sortBy('wip_step');
                    @endphp
                    @foreach($wipStep as $k => $wip)
                    @php 
                
                        $dlAbsorptionAmount = $dataByDate[0]->wage_cost * $wip->dl_absorption_rate / 100;
                        $vohAbsorbtionAmount = $dataByDate[0]->vary_cost * $wip->voh_absorption_rate / 100;
                        $fohAbsorptionAmount = $dataByDate[0]->fixed_cost * $wip->foh_absorption_rate / 100;
                    @endphp
                    <tr>
                        <td style="{{ $styleFont18 . $styleBorderAll }} ">
                           <b>ขั้นตอน  <u>{{$wip->wip_step}} {{$wip->wip_desc}}</b></u>
                        </td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{$wip->dl_absorption_rate}}% ({{ number_format($dlAbsorptionAmount, 9) }})</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{$wip->voh_absorption_rate}}% ({{ number_format($vohAbsorbtionAmount, 9) }})</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{$wip->foh_absorption_rate}}% ({{ number_format($fohAbsorptionAmount, 9) }})</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                    </tr>
                    @if(in_array(request()->cost_code, ['10', '20', '21']) && $wip->wip_step == 'WIP01')
                    {{-- @if(in_array(request()->cost_code, ['10', '20', '21']) && $loop->first) --}}
                        <tr>
                            <td style="{{ $styleFont16 . $styleBorderAll }}">ยอดยกมาต้นงวด</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->beginning_qty ?? 0, 6)}}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->beginning_amount ?? 0, 2) }}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->begin_wage_amount, 2) }}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->begin_vary_amount, 2) }}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->begin_fixed_amount, 2) }}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->beginning_amount + $wip->begin_wage_amount + $wip->begin_vary_amount + $wip->begin_fixed_amount, 2) }}</td>
                        </tr>
                    @endif
                   
                    @if($wip->wip_step != 'WIP01')
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">รับมาจากขั้นตอน {{optional(@$wipStep[$k-1])->wip_step ?? 'WIP0'. (substr($wip->wip_step,4,1) - 1)}} {{optional(@$wipStep[$k-1])->wip_desc}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->receive_qty ?? 0, 6)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->receive_amount ?? 0, 2)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format(optional(@$wipStep[$k-1])->confirm_iss_wage_amount ?? 0, 2)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format(optional(@$wipStep[$k-1])->confirm_iss_vary_amount ?? 0, 2)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format(optional(@$wipStep[$k-1])->confirm_iss_fixed_amount ?? 0, 2)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{  number_format($wip->receive_amount+ optional(@$wipStep[$k-1])->confirm_iss_wage_amount +  optional(@$wipStep[$k-1])->confirm_iss_vary_amount + optional(@$wipStep[$k-1])->confirm_iss_fixed_amount , 2)}}</td>

                    </tr>
                    @endif
                     <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">วัตถุดิบใช้ไประหว่างงวด</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>

                    </tr>
                    @php 
                        $itemWip = $datas->where('level_no', '3')->where('batch_no', $batchNo)->where('transaction_date', $date)->where('wip_step', $wip->wip_step)->sortBy('tobacco_group_code');
                    @endphp
                    @foreach ($itemWip as $item)
                    <tr>
                        <td  style="{{ $styleFont16 . $styleBorderAll }}">{{ $item->tobacco_group_code }} {{ $item->tobacco_group }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{number_format($item->ingredient_quantity ?? 0, 6)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($item->ingredient_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>

                    </tr>
                    @endforeach
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">รวมต้นทุนวัตถุดิบใช้ไปในงวด</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{number_format($wip->ingredient_quantity ?? 0, 6)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ingredient_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>

                    </tr>
                    @if(in_array(request()->cost_code, ['10']) && $wip->wip_step == "WIP01")
                        <tr>
                            <td style="{{ $styleFont16 . $styleBorderAll }}">สารหอม</td>
                            <td style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ingredient_quantity - $wip->confirm_qty, 6) }}</td>
                            <td style="{{ $styleFont16 . $styleBorderAll }}"> </td>
                            <td style="{{ $styleFont16 . $styleBorderAll }}"> </td>
                            <td style="{{ $styleFont16 . $styleBorderAll }}"> </td>
                            <td style="{{ $styleFont16 . $styleBorderAll }}"> </td>
                            <td style="{{ $styleFont16 . $styleBorderAll }}"> </td>
                        </tr>
                    @endif
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">สูญเสีย</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->loss_qty ?? 0, 6) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->loss_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                    </tr>
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">ยอดผลิตได้ระหว่างงวด</td>
                        @php 
                            $totalWage += $wip->confirm_wage_amount;
                            $totalVary += $wip->confirm_vary_amount;
                            $totalFixed += $wip->confirm_fixed_amount;
                        @endphp 
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{number_format($wip->confirm_qty, 6) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_wage_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_vary_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_fixed_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_amount + $wip->confirm_wage_amount + $wip->confirm_vary_amount + $wip->confirm_fixed_amount, 2) }}</td>
                    </tr>
                    @if(!in_array(request()->cost_code, ['10', '20', '21', '40']) || $wip->wip_step != 'WIP01')
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">คงคลังเช้า</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{number_format($wip->beginning_qty ?? 0, 6) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->beginning_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->begin_wage_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->begin_vary_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->begin_fixed_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->beginning_amount + $wip->begin_wage_amount  + $wip->begin_vary_amount + $wip->begin_fixed_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">
                            @if(in_array(request()->cost_code, [30]) && $wip->wip_step == 'WIP06')
                            ต้นทุนสินค้าสำเร็จรูป
                            @else
                            รวมต้นทุนทั้งสิ้น
                            @endif
                        </td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{number_format($wip->wip_total_qty ?? 0, 6)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->wip_total_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->wip_total_wage_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->wip_total_vary_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->wip_total_fixed_amount ?? 0, 2) }}</td>
                        {{-- <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ $totalWage }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ $totalVary }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ $totalFixed }}</td> --}}
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->wip_total_amount + $wip->wip_total_wage_amount + $wip->wip_total_vary_amount + $wip->wip_total_fixed_amount, 2) }}</td>
                    </tr>
                    {{-- <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">รวมต้นทุนทั้งสิ้น</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{$wip->confirm_issue_qty}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ $wip->confirm_issue_amount }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ $wip->confirm_iss_wage_amount }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ $wip->confirm_iss_vary_amount }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ $wip->confirm_iss_fixed_amount }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}"></td>
                    </tr> --}}
                    {{-- @if(!$loop->last) --}}
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">โอนไปขั้นตอน {{ optional(@$wipStep[$k+1])->wip_step}} {{ optional(@$wipStep[$k+1])->wip_desc}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{number_format($wip->confirm_issue_qty ?? 0, 6)}}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_issue_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_iss_wage_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_iss_vary_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_iss_fixed_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_issue_amount+$wip->confirm_iss_wage_amount + $wip->confirm_iss_vary_amount+ $wip->confirm_iss_fixed_amount, 2)   }}</td>
                    </tr>
                    {{-- @endif --}}
                    @if(in_array(request()->cost_code, [30]))
                    @if($wip->wip_step != "WIP06")
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">ยอดปลายงวด (ตามสูตร)</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_qty ?? 6, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_wage_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_vary_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_fixed_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_amount + $wip->ending_wage_amount + $wip->ending_vary_amount  + $wip->ending_fixed_amount, 2)  }}</td>
                    </tr>
                    @endif
                    @else 
                    <tr>
                        <td style="{{ $styleFont16 . $styleBorderAll }}">ยอดปลายงวด (ตามสูตร)</td>
                        
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_qty ?? 0, 6) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_wage_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_vary_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_fixed_amount ?? 0, 2) }}</td>
                        <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->ending_amount + $wip->ending_wage_amount + $wip->ending_vary_amount  + $wip->ending_fixed_amount, 2)  }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>


                {{-- <tbody>
                    @php
                        $afterWipText = '';
                        $afterWipCode = '';
                        $dataByOprnCode = $dataByDate->groupBy('oprn_code');
                        $tranferData = [];
                        $masterHumanCost = [];
                        $masterAfCost = [];
                        $masterFixedCost = [];
                    @endphp
                    @foreach ($setupBath[$uData[0]->batch_id] as $k => $bathMaster)
                        @php
                            $productWipV = productWipV($dataByDate[0]->batch_id, $bathMaster->wip_step, $date);
                            if(!$loop->first) {
                                $afterStepWip = (int)str_replace('WIP','',$bathMaster->wip_step) - 1;
                                $afterStepWip = "WIP". sprintf('%02d', $afterStepWip);
                                $productAfterWipV = productWipV($dataByDate[0]->batch_id, $afterStepWip, $date);
                                $confirmIssueQtyAfter = $productAfterWipV->sum('confirm_issue_qty');
                            }
                            $tranferWip = $productWipV->sum('ending_qty') / $dataByDate[0]->cost_quantity;
                            $confirmQty = $productWipV->sum('confirm_qty') / $dataByDate[0]->cost_quantity;
                            // $confirmQty = $productWipV->sum('confirm_qty');
                            $lossQty = $productWipV->sum('loss_qty');
                            $begining = $productWipV->sum('beginning_qty');

                            $masterCostWip = DB::select("select dl_absorption_rate,voh_absorption_rate,foh_absorption_rate 
                                                from PTCT_WIP_PROCESS_V
                                                where cost_code = '{$cost->cost_code}'
                                                    and wip_step = '{$bathMaster->wip_step}'");
                            $varyCostAmount = $dataByDate[0]->vary_cost * (optional(@optional($dataByTobaccoGroup)->first()[0])->dl_absorption_rate * 0.01);
                            if ($confirmQty > 0 && optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity > 0) {
                                $tranferQty = $confirmQty / optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity;
                            }
                            $tranferQty = productWipV($dataByDate[0]->batch_id, $bathMaster->wip_step, $date)->sum('confirm_issue_qty') / (optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity ?? 1);
                            $dataByTobaccoGroup = optional(optional(@$dataByOprnCode[$bathMaster->wip_step])->sortBy('item_cat_code'))->groupBy('tobacco_group_code') ?? [];
                            $wageCostAmount = $dataByDate[0]->wage_cost * optional($masterCostWip[0])->dl_absorption_rate * 0.01;
                            $varyCostAmount = $dataByDate[0]->vary_cost * optional($masterCostWip[0])->voh_absorption_rate * 0.01;
                            $fixedCost = $dataByDate[0]->fixed_cost * optional($masterCostWip[0])->foh_absorption_rate * 0.01;
                            if ($begining > 0 && optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity > 0) {
                                $receiveWip = $begining / optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity;
                            } else {
                                $receiveWip = 0;
                            }
                            
                            $c = $confirmQty * $receiveWip == 0 ? 0 : ($confirmQty * $receiveWip) / optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material');
                            
                            $g = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + $confirmQty * $wageCostAmount + $confirmQty * $varyCostAmount + $confirmQty * $fixedCost;
                            
                            $sumMaterial = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material');
                            
                            if (!$loop->first) {
                                $sumMaterial = optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + $c + @$tranferData[optional(@$dataByOprnCode[$bathMaster->wip_step][0])->previous_wip]['tranfer_raw_mat'];
                            }
                            // dd(optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material'));
                            if (optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') > 0) {
                                // $sumTranfer = ((optional(@$dataByOprnCode[$bathMaster->wip_step])->sum('sum_raw_material') + $c) * $tranferQty) / ($confirmQty + $receiveWip) + ($tranferQty * $wageCostAmount) + ($tranferQty * $varyCostAmount) + ($tranferQty * $fixedCost);
                            }
                            if (optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity > 0) {
                                // $tranferWip = $confirmQty / optional(@$dataByOprnCode[$bathMaster->wip_step][0])->cost_quantity;
                            }

                        @endphp
                        <tr>
                            <td colspan="3" style="{{ $styleFont16 }}"> <b> ขั้นตอน
                                    {{ $bathMaster->wip_step }} {{ $bathMaster->wip_step_desc }} </b> </td>
                            <td style="{{ $styleFont16 }}; font-wegiht: bold">
                                @if ($loop->first)
                                @php 
                                    
                                @endphp
                                    <b>{{ $masterHumanCost['percent'] = optional(@$masterCostWip[0])->dl_absorption_rate }}
                                        %
                                        ({{ $masterHumanCost['value'] = $wageCostAmount }})
                                    </b>
                                @else
                                <span style="color:#fff">&nbsp;</span>{{ number_format($dataByDate[0]->wage_cost, 9) }} 
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}; font-wegiht: bold">
                                @if ($loop->first)
                                    <b>{{ $masterAfCost['percent'] =optional(@$masterCostWip[0])->voh_absorption_rate }}
                                        %
                                        ({{ $masterAfCost['value'] = $varyCostAmount }}) </b>
                                @else
                                <span style="color:#fff">&nbsp;</span>{{ number_format($dataByDate[0]->vary_cost, 9) }}
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}; font-wegiht: bold">
                                @if ($loop->first)
                                    <b>{{ $masterFixedCost['percent'] = optional(@$masterCostWip[0])->foh_absorption_rate }}
                                        %
                                        ({{ $masterFixedCost['value'] = $fixedCost }})</b>
                                @else
                                    <span style="color:#fff">&nbsp;</span> {{ number_format($dataByDate[0]->fixed_cost, 9) }}
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}"></td>
                        </tr>
                        @php 
                             $masterHumanCost['value'] = $wageCostAmount;
                             $masterAfCost['value'] = $varyCostAmount;
                             $masterFixedCost['value'] = $fixedCost;
                             $tcw = transferCWip($bathMaster->wip_step, $bathMaster->batch_id, \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y'));
                            if(!empty($tcw)) {
                                $c = $tcw[0]->amount * ($receiveWip / ($tcw[0]->qty / $datas[0]->cost_quantity));
                            } else {
                                $c = 0;
                            }
                        @endphp
                        @if(in_array($cost->cost_code, ['10', '20', '21']) && $loop->first)
                        <tr>
                            <td style="{{ $styleFont16 }}">ยอดยกมาต้นงวด</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $receiveWip }}
                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $c }}
                            </td>
                            <td style="{{ $styleFont16 }}">{{ $receiveWip * $masterHumanCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $receiveWip * $masterAfCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $receiveWip *  $masterFixedCost['value']  }}</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $c + ( $receiveWip * $masterHumanCost['value']) + ($receiveWip * $masterAfCost['value']) + ( $receiveWip *  $masterFixedCost['value'])  }}
                            </td>
                        </tr>
                        @endif
                        @if (!$loop->first)
                        <tr>
                            <td style="{{ $styleFont16 }}"> 
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}; font-weight: bold">
                                <b>{{ $masterHumanCost['percent'] = optional(@$masterCostWip[0])->dl_absorption_rate }}
                                    %
                                    ({{ $masterHumanCost['value']  }})
                                </b>
                            </td>
                            <td style="{{ $styleFont16 }}; font-weight: bold">
                                <b>{{ $masterAfCost['percent'] =optional(@$masterCostWip[0])->voh_absorption_rate }}
                                    %
                                    ({{ $masterAfCost['value']  }}) </b>
                            </td>
                            <td style="{{ $styleFont16 }}; font-weight: bold">
                                <b>{{ $masterFixedCost['percent'] =optional(@$masterCostWip[0])->foh_absorption_rate }}
                                    %
                                    ({{ $masterFixedCost['value'] }}) </b>
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                        </tr>
                            <tr>
                                <td style="{{ $styleFont16 }}"> รับมาจากขั้นตอน {{ $afterWipText }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{@$confirmIssueQtyAfter}}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ $excel['c27'] = @$excel['c23'][$afterWipCode] }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ @$excel['d23'][$afterWipCode] }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ @$excel['e23'][$afterWipCode] }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ @$excel['f23'][$afterWipCode] }}
                                </td>
                                <td style="{{ $styleFont16 }}">
                                    {{ @$excel['g23'][$afterWipCode] }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td style="{{ $styleBorderLRFont16 }}">วัตถุดิบใช้ไประหว่างงวด</td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                            <td style="{{ $styleFont16 }}">
                            </td>
                        </tr>
                        @php
                            $sumRawMaterial = 0;
                            $sumRawQty = 0;
                        @endphp
                        
                        @foreach ($dataByTobaccoGroup as $group => $dataByGroup)
                            @php
                                $sumRawMaterial += $dataByGroup->sum('sum_raw_material');
                                $sumRawQty += $dataByGroup->filter(function($i) { return $i->tobacco_group_code != '1080';})->sum('transaction_quantity');
                            @endphp
                            <tr>
                                <td style="{{ $styleFont16 }}"> {{ $group }}
                                    {{ $dataByGroup[0]->tobacco_group }} </td>
                                <td style="{{ $styleFont16 }}"> 
                                    @if($group == '1080')
                                        0
                                    @else
                                        {{ $dataByGroup->sum('transaction_quantity') }}
                                    @endif
                                </td>
                                <td style="{{ $styleFont16 }}"> {{ $dataByGroup->sum('sum_raw_material') }} </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                                <td style="{{ $styleFont16 }}"> </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td style="{{ $styleFont16 }}">รวมต้นทุนวัตถุดิบใช้ไปในงวด</td>
                            <td style="{{ $styleFont16 }}">{{ $sumRawQty }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $sumRawMaterial }} </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                        @if(in_array($cost->cost_code, ['10']) && $bathMaster->wip_step == "WIP01")
                        <tr>
                            <td style="{{ $styleFont16 }}">สารหอม</td>
                            <td style="{{ $styleFont16 }}">{{ $sumRawQty - $confirmQty }}</td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                        @endif
                        <tr>
                            <td style="{{ $styleFont16 }}"> สูญเสีย </td>
                            <td style="{{ $styleFont16 }}"> {{ $lossQty }}
                            </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                            <td style="{{ $styleFont16 }}"> </td>
                        </tr>
                        <tr>
                            <td style="{{ $styleFont16 }}">ยอดผลิตได้ระหว่างงวด</td>
                            <td style="{{ $styleFont16 }}"> {{ $confirmQty }}</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $excel['c20'] = $sumRawMaterial }}
                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $excel['d20'] = $confirmQty * $masterHumanCost['value']  }}
                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $excel['e20'] = $confirmQty * $masterAfCost['value'] }}
                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $excel['f20'] = $confirmQty * $masterFixedCost['value'] }}

                            </td>
                            <td style="{{ $styleFont16 }}">
                                {{ $sumTotalWip = $sumRawMaterial + $excel['d20'] + $excel['e20'] + $excel['f20']  }}
                            </td>
                        </tr>
                        @if(!in_array($cost->cost_code, ['10', '20', '21', '40']) || !$loop->first)
                        <tr>
                            <td style="{{ $styleFont16 }}">คงคลังเช้า</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $receiveWip }}
                            </td>
                            <td style="{{ $styleFont16 }}">{{ $c }}</td>
                            <td style="{{ $styleFont16 }}">{{ $receiveWip * $masterHumanCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $receiveWip * $masterAfCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $receiveWip *  $masterFixedCost['value']  }}</td>
                            <td style="{{ $styleFont16 }}">
                                {{ $c + ( $receiveWip * $masterHumanCost['value']) + ($receiveWip * $masterAfCost['value']) + ( $receiveWip *  $masterFixedCost['value'])  }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td style="{{ $styleFont16 }}">รวมต้นทุนทั้งสิ้น </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b22'] = $confirmQty + $receiveWip }} </td>
                            <td style="{{ $styleFont16 }}"> 
                                @php 
                                $excel['c22'] = $sumRawMaterial + $c;
                                @endphp 
                                @if(!$loop->first)
                                {{ $excel['c22'] = $excel['c27'] + $excel['c20'] }} 
                                @else 
                                {{ $excel['c22'] }} 
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                
                                    {{ @$excel['d23'][$afterWipCode] + $excel['d20'] }}
                                @else
                                    {{ $confirmQty * $wageCostAmount + $receiveWip * $wageCostAmount }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['e23'][$afterWipCode] + $excel['e20'] }}
                                @else
                                    {{ $confirmQty * $varyCostAmount + $receiveWip * $varyCostAmount }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['f23'][$afterWipCode] + $excel['f20'] }}
                                @else
                                    {{ $confirmQty * $fixedCost + $receiveWip * $fixedCost }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['g23'][$afterWipCode] + $sumTotalWip }}
                                @else
                                    {{ $g + $c + $receiveWip * $wageCostAmount + $receiveWip * $varyCostAmount + $receiveWip * $fixedCost }}
                                @endif

                            </td>
                        </tr>

                        @php
                            $berforeWipText = @$setupBath[$uData[0]->batch_id][$k + 1];
                        @endphp
                        <tr>
                            <td style="{{ $styleFont16 }}"> โอนไปขั้นตอน
                                {{ optional($berforeWipText)->wip_step }}
                                {{ optional($berforeWipText)->wip_step_desc }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b23'] = $tranferQty }} </td>
                            <td style="{{ $styleFont16 }}">
                                @if(@$excel['c22'] > 0 && @$excel['b23'] > 0 && @$excel['b22'] > 0)
                                    {{ $excel['c23'][$bathMaster->wip_step] = $excel['c22'] * $excel['b23'] / @$excel['b22']}}
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['d23'][$bathMaster->wip_step]  = $tranferQty * $masterHumanCost['value'] }}</td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['e23'][$bathMaster->wip_step]  = $tranferQty * $masterAfCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['f23'][$bathMaster->wip_step]  = $tranferQty * $masterFixedCost['value'] }}</td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['g23'][$bathMaster->wip_step] = @$excel['c23'][$bathMaster->wip_step] + ( $tranferQty * $wageCostAmount) + ($tranferQty * $varyCostAmount) + ( $tranferQty * $fixedCost) }} </td>
                        </tr>
                        <tr>
                            <td style="{{ $styleFont16 }}"> ยอดปลายงวด (ตามสูตร) </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b24'] = $tranferWip }} </td>
                            <td style="{{ $styleFont16 }}">
                                @if (@$excel['b24'] > 0 && $excel['c22'] > 0 && $excel['b22'] > 0)
                                    {{ $excel['c24'][$bathMaster->wip_step] = $excel['c22']* $excel['b24'] / $excel['b22'] }}
                                    
                                @else
                                    0
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}">{{ $excel['b24'] * $masterHumanCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b24'] * $masterAfCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}">{{ $excel['b24'] * $masterFixedCost['value'] }} </td>
                            <td style="{{ $styleFont16 }}">
                               {{ @$excel['c24'][$bathMaster->wip_step] + ($excel['b24'] *$masterHumanCost['value'] ) + ( $excel['b24'] * $masterAfCost['value']) + ($excel['b24'] * $masterFixedCost['value'])}}
                            </td>
                        </tr>
                        @if($loop->last)
                        <tr>
                            <td style="{{ $styleFont16 }}"> ต้นทุนสินค้าสำเร็จรูป </td>
                            <td style="{{ $styleFont16 }}"> {{ $excel['b22'] = $confirmQty + $receiveWip }} </td>
                            <td style="{{ $styleFont16 }}"> 
                                @php 
                                $excel['c22'] = $sumRawMaterial + $c;
                                @endphp 
                                @if(!$loop->first)
                                {{ $excel['c22'] = $excel['c27'] + $excel['c20'] }} 
                                @else 
                                {{ $excel['c22'] }} 
                                @endif
                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                
                                    {{ @$excel['d23'][$afterWipCode] + $excel['d20'] }}
                                @else
                                    {{ $confirmQty * $wageCostAmount + $receiveWip * $wageCostAmount }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['e23'][$afterWipCode] + $excel['e20'] }}
                                @else
                                    {{ $confirmQty * $varyCostAmount + $receiveWip * $varyCostAmount }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['f23'][$afterWipCode] + $excel['f20'] }}
                                @else
                                    {{ $confirmQty * $fixedCost + $receiveWip * $fixedCost }}
                                @endif

                            </td>
                            <td style="{{ $styleFont16 }}">
                                @if (!$loop->first)
                                    {{ @$excel['g23'][$afterWipCode] + $sumTotalWip }}
                                @else
                                    {{ $g + $c + $receiveWip * $wageCostAmount + $receiveWip * $varyCostAmount + $receiveWip * $fixedCost }}
                                @endif

                            </td>
                        </tr>
                        @endif
                        @php
                            $afterWipText = $bathMaster->wip_step . $bathMaster->wip_step_desc;
                            $afterWipCode = $bathMaster->wip_step;
                        @endphp
                        @endforeach
                </tbody> --}}
                {{-- @if ($loop->parent->first && $loop->first)
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                    <tr>
                        <td colspan="7"> </td>
                    </tr>
                @endif --}}

            </table>
        @endforeach
    @endforeach
</body>

</html>
