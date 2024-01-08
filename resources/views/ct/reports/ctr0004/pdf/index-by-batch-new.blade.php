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

        @page {
            padding-top: 31.4px;
            padding-left: 31.4px;
            padding-right: 31.4px;
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

        tbody tr td {
            line-height: 1.23;
            vertical-align: bottom;
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

        $firstWip = $wipList->first();
        $lastWip = $wipList->last();
    @endphp

    @php
        $dataLevel1 = $datas->where('level_no', 1);
        $i = 0;
    @endphp
    @foreach ($dataLevel1->sortBy('transaction_date')->groupBy('transaction_date') as $date => $uData)
        @foreach ($uData->sortBy('item_number')->groupBy('batch_no') as $batchNo => $dataByDate)
            @php 
                $i++;
                $sysdate = Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i');
                $firstLine = $dataByDate->first();
                $costDesc = $firstLine->cost_code . " " . $firstLine->cost_description;
                $deptDesc = $firstLine->department_code . " " . $firstLine->department_description;
            @endphp
            @if($i != 1)
                <div class="page"></div>
            @endif
            <table class="table" style="table-layout: auto;" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="7">
                            <table style="width:100%; border-collapse: collapse; " >
                                <thead>
                                <tr>
                                    <td style="width:33%">
                                        <b> โปรแกรม : CTR0004 </b><br>
                                        <b> วันที่เริ่มผลิต :
                                            {{ parseToDateTh($dataByDate[0]->batch_start_date) }}
                                        </b> <br>
                                        <b>วันที่ผลิตเสร็จ :
                                            {{ parseToDateTh($dataByDate[0]->batch_end_date) }}
                                        </b> <br>
                                        <b> เลขที่คำสั่งผลิต :{{ $batchNo }} </b> <br>
                                        <b> รหัสสินค้า/ชื่อสินค้า :
                                            {{ $dataByDate[0]->item_number . ' ' . $dataByDate[0]->item_description }} </b>
                                    </td>
                                    <td align="center" style="width:33%; vertical-align: top">
                                        <b> การยาสูบแห่งประเทศไทย </b> <br>
                                        <b>รายงานบัตรต้นทุนประจำวัน
                                            ({{ $costDesc }})
                                        </b> <br>
                                        <b> ประจำวันที่ :
                                            {{ Carbon\Carbon::create($date)->addYear('543')->format('d/m/Y') }} </b><br>
                                            <br><b>หน่วยงาน: {{ $deptDesc }}</b>
                                    </td>
                                    <td style="width:33%; vertical-align: top" align="right">
                                        <b> วันที่พิมพ์ : </b> {{ $sysdate }}<br>
                                        <b>หน้าที่ :</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </td>
                    </tr>
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
                        $wipStep = $datas->where('level_no', '2')->where('batch_no', $batchNo)->where('transaction_date', $date)->sortBy('wip_step')->values();
                    @endphp
                    @foreach($wipStep as $k => $wip)
                        @php
                            $dlAbsorptionAmount = $dataByDate[0]->wage_cost * $wip->dl_absorption_rate / 100;
                            $vohAbsorbtionAmount = $dataByDate[0]->vary_cost * $wip->voh_absorption_rate / 100;
                            $fohAbsorptionAmount = $dataByDate[0]->fixed_cost * $wip->foh_absorption_rate / 100;
                        @endphp
                        <tr style="">
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
                        @if(in_array(request()->cost_code, ['11', '12', '42']) && $wip->wip_step == $firstWip->wip_step)
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
                        @if($wip->wip_step != $firstWip->wip_step)
                            <tr>
                                <td style=" {{ $styleFont16 . $styleBorderAll }}">รับมาจากขั้นตอน {{optional(@$wipStep[$k-1])->wip_step ?? 'WIP0'. (substr($wip->wip_step,4,1) - 1)}} {{optional(@$wipStep[$k-1])->wip_desc}}</td>
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
                        @if(in_array(request()->cost_code, ['11']) && $wip->wip_step == $firstWip->wip_step)
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
                        @if(!in_array(request()->cost_code, ['11', '12', '42', '40']) || $wip->wip_step != $firstWip->wip_step)
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
                                @if(in_array(request()->cost_code, [30]) && $wip->wip_step == $lastWip->wip_step)
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
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->wip_total_amount + $wip->wip_total_wage_amount + $wip->wip_total_vary_amount + $wip->wip_total_fixed_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="{{ $styleFont16 . $styleBorderAll }}">โอนไปขั้นตอน {{ optional(@$wipStep[$k+1])->wip_step}} {{ optional(@$wipStep[$k+1])->wip_desc}}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{number_format($wip->confirm_issue_qty ?? 0, 6)}}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_issue_amount ?? 0, 2) }}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_iss_wage_amount ?? 0, 2) }}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_iss_vary_amount ?? 0, 2) }}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_iss_fixed_amount ?? 0, 2) }}</td>
                            <td align="right" style="{{ $styleFont16 . $styleBorderAll }}">{{ number_format($wip->confirm_issue_amount+$wip->confirm_iss_wage_amount + $wip->confirm_iss_vary_amount+ $wip->confirm_iss_fixed_amount, 2)   }}</td>
                        </tr>
                        @if(in_array(request()->cost_code, [30]))
                            @if($wip->wip_step != $lastWip->wip_step)
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
            </table>
        @endforeach
    @endforeach
</body>

</html>
