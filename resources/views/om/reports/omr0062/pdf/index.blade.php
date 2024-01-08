<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $progTitle }}</title>
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    @include('om.reports._style')
</head>

<body>
    @php
        $colspan = 7;
    @endphp
    <table class="table">
        <thead>
            <tr>
                <th colspan="{{ $colspan }}">
                    <div class="row">
                        <div style="width:20%;text-align:left" class="b">
                            โปรแกรม : {{ $programCode }}<br>
                            สั่งพิมพ์ : {{ optional(auth()->user())->username }}
                        </div>
                        <div style="width:60%;text-align:center" class="b">
                            การยาสูบแห่งประเทศไทย<br>
                            {{ $progTitle }}<br>
                            {{ $month }}
                        </div>
                        <div style="width:20%;text-align:right;" class="b">
                            วันที่ : {{ parseToDateTh(now()) }}<br>
                            เวลา : &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                            หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            </span><br>

                        </div>
                    </div>
                </th>
            </tr>
            {{-- <tr>
                <th> โปรแกรม : {{ $programCode }}</th>
                <th colspan="7" align="center">การยาสูบแห่งประเทศไทย</th>
                <th align="right">วันที่ : {{ parseToDateTh(now()) }}</th>
            </tr>
            <tr>
                <th>สั่งพิมพ์ : {{ optional(auth()->user())->username }}</th>
                <th colspan="7" align="center">{{ $progTitle }}</th>
                <th align="right">เวลา : &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}</th>
            </tr>
            <tr>
                <th></th>
                <th colspan="7" align="center"> {{ $month }}</th>
                <th align="right"></th>
            </tr> --}}
            <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                <th style="text-align:center"> ตราบุหรี่</th>
                <th style="text-align:center"> ยอดจำหน่าย</th>
                <th style="text-align:center"> ราคาขาย ณ โรงงาน</th>
                <th style="text-align:center;"> ภาษีมูลค่าเพิ่ม</th>
                <th style="text-align:center"> รายได้ขายหักภาษีมูลค่าเพิ่ม</th>
                {{-- <th style="text-align:center"> รายได้ขายหักภาษีมูลค่าเพิ่มเดิม</th> --}}
                <th style="text-align:center"> ภาษีอบจ.</th>
                <th style="text-align:center"> รายได้หลังหักภาษี อบจ.</th>
            </tr>
            <tr style="">
                <th style="text-align:center"> </th>
                <th style="text-align:center"> มวน</th>
                <th style="text-align:center"> บาท</th>
                <th style="text-align:center"> บาท</th>
                <th style="text-align:center;"> บาท</th>
                <th style="text-align:center"> บาท</th>
                <th style="text-align:center"> บาท</th>
                <th style="text-align:center"> บาท</th>
            </tr>
            <tr style="height:8px;">
                <td colspan="{{ $colspan }}"></td>
            </tr>
        </thead>
        <tbody>
            @php
                $sumTotal = 0;
                $sumFac = 0;
                $sumTax = 0;
                $sumBalance = 0;
                $sumPao = 0;
                $sumPao2 = 0;
            @endphp
            @foreach ($data as $item)
                @php
                    $rma_once = $rma->where('item_code', $item->item_code) ?? collect();
                    
                    $col5 = 0;
                    $col6 = 0;
                    $col7 = 0;
                    $adjust = $arInterface->where('item_code', $item->item_code)->first();
                    $glAdjust = $gl_adjust->where('item_code', $item->item_code)->first() ?? false;
                    $apAdjust = $apInterface->where('item_code', $item->item_code)->first() ?? false;
                    if ($glAdjust) {
                        $valueAdjust = $glAdjust->dr - $glAdjust->cr;
                    } else {
                        $valueAdjust = 0;
                    }
                    if ($apAdjust) {
                        $apAdjustAmount = $apAdjust->ppt_adjust_amount;
                    } else {
                        $apAdjustAmount = $item->mt_pao_line_amount;
                    }
                    @endphp
                    <tr style="">
                        <td style="">
                            {{ $item->report_item_display }}
                        </td>
                        <td style="" align="right">
                            
                            @if ($adjust)
                                @php 
                                    $sumTotal += $adjust->sum_qty - $rma_once->sum('total_sale');
                                @endphp
                                {{ number_format($adjust->sum_qty - $rma_once->sum('total_sale'), 2) }}
                            @else
                                @php 
                                    $sumTotal += $item->all_qty - $rma_once->sum('total_sale');
                                @endphp
                                {{ number_format($item->all_qty - $rma_once->sum('total_sale'), 2) }}
                            @endif
                        </td>
                        <td style="" align="right">
                            @if ($adjust)
                                @php 
                                    $sumFac+= $adjust->sum_amount  + $rma_once->sum('price_fact');
                                @endphp
                                {{ number_format($adjust->sum_amount  + $rma_once->sum('price_fact') , 2) }}
                            @else
                                @php 
                                    $sumFac+= $item->all_amount  + $rma_once->sum('price_fact');
                                @endphp
                                {{ number_format($item->all_amount  + $rma_once->sum('price_fact'), 2) }}
                            @endif
                        </td>
            <td style="" align="right">
                @if ($adjust)
                    @php
                        $sumTax += $adjust->sum_oaom_tax_adjust + $valueAdjust;
                    @endphp
                    {{ number_format($adjust->sum_oaom_tax_adjust + $valueAdjust  + $rma_once->sum('tax'), 2) }}
                @else
                    @php
                        $sumTax += $item->tax_amount + $valueAdjust;
                    @endphp
                    {{ number_format($item->tax_amount + $valueAdjust  + $rma_once->sum('tax'), 2) }}
                @endif
            </td>

            <td style="" align="right">
                @if ($adjust)
                    @php
                        $sumBalance += $adjust->sum_amount - ($adjust->sum_oaom_tax_adjust + $valueAdjust);
                    @endphp
                    {{ number_format($adjust->sum_amount - ($adjust->sum_oaom_tax_adjust + $valueAdjust)  + $rma_once->sum('price_less_tax'), 2) }}
                @else
                    @php
                        $sumBalance += $item->all_amount - ($item->tax_amount + $valueAdjust);
                    @endphp
                    {{ number_format($item->all_amount - ($item->tax_amount + $valueAdjust)  + $rma_once->sum('price_less_tax'), 2) }}
                @endif

            </td>
            {{-- <td style="" align="right">{{ number_format($col5_bk, 2) }}</td> --}}
            <td style="" align="right">
                @if ($adjust)
                    @php
                        $sumPao += ($adjust->sum_pao_line_amount + $apAdjustAmount);
                    @endphp
                    {{ number_format(($adjust->sum_pao_line_amount + $apAdjustAmount)  + $rma_once->sum('org_tax'), 2) }}
                @else
                    @php
                        $sumPao += ($item->pao_line_amount + $apAdjustAmount);
                    @endphp
                    {{ number_format(($item->pao_line_amount + $apAdjustAmount)  + $rma_once->sum('org_tax'), 2) }}
                @endif
            </td>
            <td style="" align="right">
                @if ($adjust)
                    @php
                        $sumPao2 += $adjust->sum_amount - ($adjust->sum_oaom_tax_adjust + $valueAdjust) - ($adjust->sum_pao_line_amount + $apAdjustAmount);
                    @endphp
                    {{ number_format($adjust->sum_amount - ($adjust->sum_oaom_tax_adjust + $valueAdjust) - ($adjust->sum_pao_line_amount + $apAdjustAmount)  + $rma_once->sum('poa_tax'), 2) }}
                @else
                    @php
                        $sumPao2 += $item->all_amount - ($item->tax_amount + $valueAdjust) - ($item->pao_line_amount + $apAdjustAmount);
                    @endphp
                    {{ number_format($item->all_amount - ($item->tax_amount + $valueAdjust) - ($item->pao_line_amount + $apAdjustAmount) + $rma_once->sum('poa_tax'), 2) }}
                @endif
            </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            @php
                // $col5 = $data->sum('all_amount') - $data->sum('tax_amount');
                $col6 = $data->sum('pao_line_amount') + $data->sum('pao_line_amount2') + $data->sum('mt_pao_line_amount');
                $col7 = $sumBalance - $col6;
            @endphp
            <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                <td style="" align="right">รวม</td>
                <td style="" align="right">{{ number_format($sumTotal, 2) }}</td>
                <td style="" align="right">{{ number_format($sumFac, 2) }}</td>
                <td style="" align="right"> {{ number_format($sumTax + $rma->sum('tax'), 2) }}</td>
                <td style="" align="right">{{ number_format($sumBalance + $rma->sum('price_less_tax'), 2) }}</td>
                {{-- <td style="" align="right">  </td> --}}
                <td style="" align="right">{{ number_format($sumPao + $rma->sum('org_tax'), 2) }}</td>
                <td style="" align="right">{{ number_format($sumPao2 + $rma->sum('poa_tax'), 2) }}</td>
            </tr>
        </tfoot>
    </table>
    <div style="padding-top:10px;">หมายเหตุรายการ : {{ $remark }}</div>
    <div class="row" style="padding-top:20px;text-align:center">จบรายงาน</div>

    {{-- <div style="padding-top:2px;text-align:right">
                <div>ผู้จัดทำ ________________________________ </div><br>
                <div>ผู้ตรวจสอบ ________________________________</div><br>
        </div> --}}
</body>

</html>
