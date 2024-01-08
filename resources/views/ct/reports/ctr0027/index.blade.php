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
    $bold= 'font-weight: bold;';
@endphp
<body>

    <table>
        <thead>
            <tr>
                <td></td>
                <td colspan="6" align="center">การยาสูบแห่งประเทศไทย</td>
            </tr>
            <tr>
                <td>รหัสโปรแกรม : CTR0027</td>
                <td colspan="6" align="center">กระดาษทำการคำนวณค่าวัตถุดิบ-มาตรฐาน(สิ่งพิมพ์สำเร็จรูป) {{$request->type_report =='no' ? 'แยกตามคำสั่งผลิต' : 'ตามผลิตภัณฑ์'}}
                </td>
                <td colspan="2">วันที่พิมพ์ : {{ now()->addYears('543')->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>ปีงบประมาณ : {{ $request->period_year + 543 }}</td>
                <td colspan="6" align="center">ตั้งแต่วันที่ :{{ $dateFrom->addYears('543')->format('d/m/Y') }}
                    ถึงวันที่ : {{ $dateTo->addYears('543')->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>หน่วยงาน : {{ @$result->first()->dept_code }} {{ @$result->first()->dept_description }}</td>
                
                <td colspan="6" align="center">ศูนย์ต้นทุน : {{ $cost->cost_code }} - {{ $cost->description }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr class="border">
                <th style="{{$border}} {{$bold}}" rowspan="2">รหัส </th>
                <th style="{{$border}} {{$bold}}" rowspan="2">รายละเอียด </th>
                @if ($request->type_report == 'no')
                    <th style="{{$border}} {{$bold}}" rowspan="2">คำสั่งผลิต</th>
                @endif
                <th style="{{$border}} {{$bold}}" rowspan="2">หน่วยนับ</th>
                <th style="{{$border}} {{$bold}}" rowspan="2">ปริมาณ
                    ผลผลิต
                    (Output)
                </th>
                <th style="{{$border}} {{$bold}}" colspan="2">ปริมาณมาตรฐาน
                </th>
                <th style="{{$border}} {{$bold}}" colspan="2">ค่าวัตถุดิบ-มาตรฐาน </th>
            </tr>
            <tr class="border">
                <th style="{{$border}} {{$bold}}">ปริมาณ
                    SQ.
                </th>
                <th style="{{$border}} {{$bold}}">ราคาต่อหน่วย (บาท)
                    SP.
                </th>
                <th style="{{$border}} {{$bold}}">ปริมาณ
                    (Output * SQ)
                </th>
                <th style="{{$border}} {{$bold}}">ต้นทุน (บาท)
                    (Output * SQ * SP)
                </th>
            </tr>

        </thead>
        <tbody class="br bl">
            @php 
                $net = 0;
            @endphp
            @if ($request->type_report == 'no')
                @php
                    $groupByAs = 'batch_no';
                @endphp
            @else
                @php
                    $groupByAs = 'toat_description';
                @endphp
            @endif
            {{-- {{dd($result->where('transaction_quantity','>', 0)->sortBy('item_number'))}} --}}
            @foreach ($result->sortBy('batch_no')->sortByDesc('item_number')->groupBy($groupByAs) as $kGroup => $resultGroupBy)
            <tr class="bold">
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$resultGroupBy->where('transaction_quantity','>', 0)->first()->item_number}}
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$resultGroupBy->where('transaction_quantity','>', 0)->first()->toat_description}}
                    </td>
                    @if ($request->type_report == 'no')
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$kGroup}}
                    </td>
                    @endif
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$resultGroupBy->where('transaction_quantity','>', 0)->first()->transaction_uom}}
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{ $output = $resultGroupBy->where('transaction_quantity','>', 0)->first()->transaction_quantity }}

                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">

                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}} text-align:right;">
                        
                        {{"@".$resultGroupBy->where('transaction_quantity','>', 0)->first()->transaction_cost }}
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">

                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">

                    </td>
                </tr>
                @php 
                    $total = 0;
                @endphp 
                @foreach($resultGroupBy->where('transaction_quantity', null) as $item)
               
                <tr class="">
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$item->item_number}}
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$item->item_description}}
                    </td>
                    @if ($request->type_report == 'no')
                    <td style="{{$borderLeft}} {{$borderRight}}">
                    </td>
                    @endif
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$item->transaction_uom}}
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">

                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{ $sq = $item->ing_std_quantity}}
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$sp = $item->transaction_cost}}
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$iq = $item->ingredient_quantity}}
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                        {{$ia = $item->ingredient_amount}}
                        @php 
                            $total +=$ia;
                        @endphp
                    </td>
                </tr>
                @endforeach
                <tr class="">
                    <td style="{{$borderLeft}} {{$borderRight}}">
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                    </td>
                    @if ($request->type_report == 'no')
                    <td style="{{$borderLeft}} {{$borderRight}}">
                    </td>
                    @endif
                    <td style="{{$borderLeft}} {{$borderRight}}">
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}}">
                    </td>
                    <td style="{{$borderLeft}} {{$borderRight}} text-align:right;">
                        รวม
                    </td>
                    <td  style="{{$borderLeft}} {{$borderRight}} {{$borderTop}} {{$borderBottom}} {{$bold}}" class="bt bb">
                        @php 
                        $net += $total;
                        @endphp 
                        {{$total}}
                    </td>
                </tr>
            @endforeach
            {{-- end Group By resultGroupBy --}}
            
            <tr class="border">
                <td style="{{$border}} {{$bold}}">

                </td>
                
                <td style="{{$border}} {{$bold}}">
                    รวมวัตถุดิบ- มาตรฐาน
                </td>
                @if ($request->type_report == 'no')
                    <td style="{{$border}} {{$bold}}">
                    </td>
                    @endif
                <td style="{{$border}} {{$bold}}">

                </td>
                <td style="{{$border}} {{$bold}}">

                </td>
                <td style="{{$border}} {{$bold}}">
                </td>
                <td style="{{$border}} {{$bold}}">
                </td>
                <td style="{{$border}} {{$bold}}">
                </td>
                <td style="{{$border}} {{$bold}}" class="bt bb">
                    {{$net}}
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
