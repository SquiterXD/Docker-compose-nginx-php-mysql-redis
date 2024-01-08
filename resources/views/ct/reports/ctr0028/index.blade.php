@php 
function convert($number)
{
    $txtnum1 = array('ศูนย์', '', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
    $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    $number = str_replace(",", "", $number);
    $number = str_replace(" ", "", $number);
    $number = str_replace("บาท", "", $number);
    $number = explode(".", $number);
    if (sizeof($number) > 2) {
        return '';
        exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == ($strlen - 1) and $n == 1) {
                $convert .= '';
            } elseif ($i == ($strlen - 2) and $n == 2) {
                $convert .= 'ยี่';
            } elseif ($i == ($strlen - 2) and $n == 1) {
                $convert .= '';
            } else {
                $convert .= $txtnum1[$n];
            }
            $convert .= $txtnum2[$strlen - $i - 1];
        }
    }
    $convert .= '';
    if (@$number[1] == '0' or @$number[1] == '00' or @$number[1] == '') {
        $convert .= '';
    } else {
        $strlen = strlen($number[1]);
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[1], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) and $n == 1) {
                    $convert .= 'เอ็ด';
                } elseif ($i == ($strlen - 2) and $n == 2) {
                    $convert .= 'ยี่';
                } elseif ($i == ($strlen - 2) and $n == 1) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert .= '';
    }
    return $convert;
}


@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
        }

        td,
        th {
            padding: 1px 5px;
        }

        .border th,
        .border td {
            border: 1px solid #000;
            /* border-top:1px solid #ccc; */
        }

        .bt {
            border-top: 1px solid #000;

        }

        .bb {
            border-bottom: 1px solid #000;

        }

        .br td {
            border-right: 1px solid #000;
        }

        .bl td {
            border-left: 1px solid #000;

        }

        .bold {
            font-weight: bold;

        }
    </style>
</head>
@php
$border = 'border:1px solid #000;';
$borderLeft = 'border-left:1px solid #000;';
$borderRight = 'border-right:1px solid #000;';
$borderTop = 'border-top:1px solid #000;';
$borderBottom = 'border-bottom:1px solid #000;';
$bold = 'font-weight: bold;';
@endphp

<body>

    <table>
        <thead>
            <tr>
                <td></td>
                <td colspan="{{$request->type_report == 'no' ? '8' : '7'}}" align="center">การยาสูบแห่งประเทศไทย</td>
            </tr>
            <tr>
                <td>รหัสโปรแกรม : CTR0028</td>
                <td colspan="{{$request->type_report == 'no' ? '8' : '7'}}" align="center">รายงานบัตรต้นทุนประจำวัน(สิ่งพิมพ์สำเร็จรูป)
                    {{ $request->type_report == 'no' ? 'แยกตามคำสั่งผลิต' : 'ตามผลิตภัณฑ์' }}
                </td>
                <td align="right" colspan="2">วันที่พิมพ์  : {{ now()->addYears('543')->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>ปีงบประมาณ : {{ $request->period_year + 543 }}</td>
                <td colspan="{{$request->type_report == 'no' ? '8' : '7'}}" align="center">ตั้งแต่วันที่ :{{ $dateFrom->addYears('543')->format('d/m/Y') }}
                    ถึงวันที่ : {{ $dateTo->addYears('543')->format('d/m/Y') }}</td>
            </tr>

            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr class="border">
                <th style="{{ $border }} {{ $bold }}" rowspan="2" align="center">รหัส </th>
                <th style="{{ $border }} {{ $bold }}" align="center" rowspan="2">รายละเอียด </th>
                @if ($request->type_report == 'no')
                    <th style="{{ $border }} {{ $bold }}" rowspan="2" align="center">คำสั่งผลิต</th>
                @endif
                <th style="{{ $border }} {{ $bold }}" rowspan="2" align="center">หน่วยนับ</th>
                <th style="{{ $border }} {{ $bold }}" rowspan="2" align="center">ปริมาณ
                    ผลผลิต
                    (Output)
                </th>
                <th align="center" style="{{ $border }} {{ $bold }}" colspan="4">ต้นทุนมาตรฐาน (บาท)
                </th>
                <th align="center" style="{{ $border }} {{ $bold }}" rowspan="2">รวม</th>
                <th align="center" style="{{ $border }} {{ $bold }}" rowspan="2">ต้นทุนต่อหน่วย</th>
            </tr>
            <tr class="border">
                <th align="center" style="{{ $border }} {{ $bold }}">ค่าวัตถุดิบ
                </th>
                <th align="center" style="{{ $border }} {{ $bold }}">ค่าแรงงาน

                </th>
                <th align="center" style="{{ $border }} {{ $bold }}">ค่าใช้จ่ายผันแปร
                </th>
                <th align="center" style="{{ $border }} {{ $bold }}">ค่าใช้จ่ายคงที่
                </th>
            </tr>

        </thead>

        <tbody class="br bl">
            <tr>
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                <td style="{{ $borderLeft }} {{ $borderRight }}; text-weight:bold; text-align:center"><b>ศูนย์ต้นทุน :
                    {{ $cost->cost_code }} - {{ $cost->description }}</b></td>
                    @if ($request->type_report == 'no')

                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                @endif
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
            </tr>
            @php
                $net = 0;
            @endphp
            @if ($request->type_report == 'no')
                @php
                    $groupByAs = 'batch_no';
                @endphp
            @else
                @php
                    $groupByAs = 'product_item_number';
                @endphp
            @endif
            @php
                $netOutput = 0;
                $netCostRawMate = 0;
                $netWageCost = 0;
                $netVaryCost = 0;
                $netFixedCost = 0;
                $totalNetSumCost = 0;
            @endphp
            @foreach ($result->groupBy('toat_description') as $ktoatDescription => $toatDescription)
                <tr>
                    <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                    <td style="{{ $borderLeft }} {{ $borderRight }};text-align:center"> {{ $ktoatDescription }}
                    </td>
                    @if ($request->type_report == 'no')
                    <td style="{{ $borderLeft }} {{ $borderRight }}">
                    </td>
                @endif
                    <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                    <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                    <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                    {{-- ค่าแรง --}}
                    @php 
                        $wag_cost = $toatDescription->first()->wage_cost;
                        $vary_cost = $toatDescription->first()->vary_cost;
                        $fixed_cost = $toatDescription->first()->fixed_cost;
                    @endphp
                    <td style="{{ $borderLeft }} {{ $borderRight }};text-align:right">&nbsp;{{ '@'.number_format($wag_cost,9) }}</td> 
                    <td style="{{ $borderLeft }} {{ $borderRight }};text-align:right">&nbsp;{{ '@'.number_format($vary_cost,9)  }}</td>
                    <td style="{{ $borderLeft }} {{ $borderRight }};text-align:right">&nbsp;{{ '@'.number_format($fixed_cost,9)  }}</td>
                    <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                    <td style="{{ $borderLeft }} {{ $borderRight }}"></td>
                </tr>
                @php
                    $sumOutput = 0;
                    $sumCostRawMate = 0;
                    $sumWageCost = 0;
                    $sumVaryCost = 0;
                    $sumFixedCost = 0;
                    $netSumCost = 0;
                    $costQuantity = 0;
                @endphp
                {{-- @foreach ($toatDescription->sortBy($groupByAs)->groupBy($groupByAs) as $kGroup => $resultGroupBy) --}}
                {{-- {{dd($toatDescription)}} --}}
                {{-- @foreach ($toatDescription->sortBy(function($i) use($request) {
                    if ($request->type_report == 'no') {
                        return $i->batch_no;
                    } else 
                    {
                        return $i->product_item_number;
                    }
                })->groupBy($groupByAs) as $kGroup => $resultGroupBy) --}}
                @foreach ($toatDescription->groupBy($groupByAs) as $kGroup => $resultGroupBy)
                @php 
                $costQuantity = $resultGroupBy->first()->cost_quantity
                @endphp
                    <tr>
                        <td style="{{ $borderLeft }} {{ $borderRight }}">
                            {{ $resultGroupBy->first()->product_item_number }} 
                        </td>
                        <td style="{{ $borderLeft }} {{ $borderRight }}">
                            {{ $resultGroupBy->first()->product_item_desc }}
                        </td>
                        @if ($request->type_report == 'no')
                            <td style="{{ $borderLeft }} {{ $borderRight }}" align="center">
                                {{ $kGroup }}
                            </td>
                        @endif
                        <td style="{{ $borderLeft }} {{ $borderRight }}" align="center">
                            {{ $resultGroupBy->first()->transaction_uom }}
                        </td>
                        <td style="{{ $borderLeft }} {{ $borderRight }}">{{ $output = $resultGroupBy->sum('transaction_quantity') }}
                            @php
                                $sumOutput += $output;
                            @endphp
                        </td>
                        <td style="{{ $borderLeft }} {{ $borderRight }}">{{ $ingredient_amount = $resultGroupBy->sum('ingredient_amount') }}
                            @php
                                $sumCostRawMate += $ingredient_amount;
                            @endphp
                        </td>
                        <td style="{{ $borderLeft }} {{ $borderRight }} text-align:right;">{{ $wage_amount = $resultGroupBy->sum('wage_amount') }}
                            @php
                                $sumWageCost += $wage_amount;
                            @endphp
                        </td>
                        <td style="{{ $borderLeft }} {{ $borderRight }}">
                            {{ $vary_amount = $resultGroupBy->sum('vary_amount') }}
                            @php
                                $sumVaryCost += $vary_amount;
                            @endphp
                        </td>
                        <td style="{{ $borderLeft }} {{ $borderRight }}">
                            {{ $fixed_amount = $resultGroupBy->sum('fixed_amount') }}
                            @php
                                $sumFixedCost += $fixed_amount;
                            @endphp
                        </td>
                        <td style="{{ $borderLeft }} {{ $borderRight }}">
                            {{ $sumCost = $ingredient_amount + $wage_amount + $vary_amount + $fixed_amount }}
                            @php
                                $netSumCost += $sumCost;
                            @endphp
                        </td>
                        <td style="{{ $borderLeft }} {{ $borderRight }}">
                            {{ $costPerUnit = $resultGroupBy->first()->transaction_cost }}
                        </td>
                    </tr>
                   
                @endforeach
                @php
                    $netOutput += $sumOutput;
                    $netCostRawMate += $sumCostRawMate;
                    $netWageCost += $sumWageCost;
                    $netVaryCost += $sumVaryCost;
                    $netFixedCost += $sumFixedCost;
                    $totalNetSumCost += $netSumCost;
                @endphp
                <tr class="">
                    <td style="{{ $borderLeft }} {{ $borderRight }}">
                    </td>
                    <td style="{{ $borderLeft }} {{ $borderRight }}; text-align:right">
                        <b>รวม</b>
                    </td>
                    @if ($request->type_report == 'no')
                        <td style="{{ $borderLeft }} {{ $borderRight }}">
                        </td>
                    @endif
                    <td style="{{ $borderLeft }} {{ $borderRight }}">
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $sumOutput }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $sumCostRawMate }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $sumWageCost }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $sumVaryCost }}
                    </td>
                    <td style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}"
                        class="bt bb">
                        {{ $sumFixedCost }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $netSumCost }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">

                    </td>
                </tr>
                <tr class="">
                    <td style="{{ $borderLeft }} {{ $borderRight }}">
                    </td>
                    <td style="{{ $borderLeft }} {{ $borderRight }}; text-align:right">
                        <b>ต้นทุนผลิตต่อหน่วย</b>
                    </td>
                    @if ($request->type_report == 'no')
                        <td style="{{ $borderLeft }} {{ $borderRight }}" align="center">
                        </td>
                    @endif
                    <td style="{{ $borderLeft }} {{ $borderRight }}" align="center">
                        {{ (convert((int)$resultGroupBy->first()->cost_quantity)) }}{{ $resultGroupBy->first()->transaction_uom }}
                    </td>
                    <td>

                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $sumCostRawMate / ($sumOutput/ $costQuantity) }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $sumWageCost / ($sumOutput/ $costQuantity) }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $sumVaryCost / ($sumOutput/ $costQuantity) }}

                    </td>
                    <td style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}"
                        class="bt bb">
                        {{ $sumFixedCost / ($sumOutput/ $costQuantity) }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">
                        {{ $netSumCost / ($sumOutput/ $costQuantity) }}
                    </td>
                    <td
                        style="{{ $borderLeft }} {{ $borderRight }} {{ $borderTop }} {{ $borderBottom }} {{ $bold }}">

                    </td>
                </tr>
            @endforeach
            {{-- end Group By resultGroupBy --}}

            <tr class="">
                <td style=" {{ $borderLeft }} {{ $borderRight }} {{ $bold }}">
                   
                </td>

                <td style="{{ $borderLeft }} {{ $borderRight }}; text-align:right">
                    <b>รวมศูนย์ต้นทุน {{ $cost->cost_code }} - {{ $cost->description }}</b>
                </td>
                @if ($request->type_report == 'no')
                    <td  style="{{ $borderLeft }} {{ $borderRight }}; text-align:right">
                    </td>
                @endif
                <td  style="{{ $borderLeft }} {{ $borderRight }}; text-align:right">

                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netOutput}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netCostRawMate}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netWageCost}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netVaryCost}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netFixedCost}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$totalNetSumCost}}
                </td>
                <td style="{{ $borderLeft }} {{ $borderRight }}; text-align:right"></td>
            </tr>
            <tr class="">
                <td style="{{ $border }} {{ $bold }}">
                  
                </td>

                <td style="{{ $border }} {{ $bold }}; text-align: right;">
                    <b>รวมทั้งสิ้น</b>
                </td>
                @if ($request->type_report == 'no')
                    <td style="{{ $border }} {{ $bold }}">
                    </td>
                @endif
                <td style="{{ $border }}{{ $bold }}">

                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netOutput}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netCostRawMate}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netWageCost}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netVaryCost}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$netFixedCost}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                    {{$totalNetSumCost}}
                </td>
                <td style="{{ $border }} {{ $bold }}">
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
