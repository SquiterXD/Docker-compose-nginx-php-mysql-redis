<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OMR0049 ยอดจำหน่ายบุหรี่ฝากขาย และยอดหนี้ค้างชำระ </title>
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

        body {
            font-family: 'THSarabunNew'
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-row-group;
        }

        tr {
            page-break-inside: avoid;
        }

        .border-tom-bottom {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        table {
            border-collapse: collapse;
        }

        td,
        th {
            padding: 3px;
        }

        div.page {
            page-break-after: always;
            page-break-inside: avoid;
        }

        thead table * {
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    {{-- 7 columns --}}
    {{-- @foreach ($data->groupBy('customer_number') as $data) --}}
        {{-- @if (!$loop->first)
            <div class="page"></div>
        @endif --}}
    @foreach($data->groupBy('product_type_desc') as $product_type_desc => $data)
     <div class="page"></div>
     <table style="width:100%">
            <thead>
                <tr>
                    <td colspan="7" style="">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">
                                    โปรแกรม : {{ $programCode }} <br>
                                    สั่งพิมพ์ : {{ auth()->user()->username }} <br>
                                </td>
                                <td align="center">
                                    การยาสูบแห่งประเทศไทย <br>
                                    ยอดจำหน่าย{{$payment_type->meaning}}/รับเงิน เรียงตามรหัสร้านค้า <br>
                                    ประเภทสินค้า : {{$product_type_desc}}
                                    <br>
                                    ตั้งแต่วันที่
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_start)->addYears('543')->format('d/m/Y') }}
                                    ถึง วันที่
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_end)->addYears('543')->format('d/m/Y') }}
                                </td>
                                <td style="width:20%;text-align:right;">วันที่ :
                                    {{ now()->addYears('543')->format('d/m/Y') }} <br>
                                    เวลา :
                                    {{ now()->addYears('543')->format('H:i') }} <br>
                                    หน้า :
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>



                {{-- <tr>
                    <td colspan="7">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">รหัสร้านค้า : {{ $data->first()->customer_number }} &nbsp;&nbsp;
                                    ชื่อร้านค้า : {{ $data->first()->customer_name }}</td>

                            </tr>
                        </table>
                    </td>
                </tr> --}}

                <tr>
                    <th class="border-tom-bottom">รหัสร้านค้า</th>
                    <th class="border-tom-bottom" style="width:32%;vertical-align: top;">ชื่อร้านค้า</th>
                    <th class="border-tom-bottom" style="text-align: center; vertical-align: top;">ยอดคงเหลือยกมา</th>
                    <th class="border-tom-bottom" align="center" style="vertical-align: top;">ยอดจำหน่าย</th>
                    <th class="border-tom-bottom" align="center" style="vertical-align: top;">ยอดรับเงิน
                    <th class="border-tom-bottom" style="text-align: center;vertical-align: top;">กำไร(ขาดทุน)<br>จากอัตราแลกเปลี่ยน</th>
                    <th class="border-tom-bottom" style="text-align: center;vertical-align: top;" data-test="1111">ยอดคงเหลือยกไป</th>
                </tr>


            </thead>
            <tbody>
                @php
                    $date_from = Carbon\Carbon::createFromFormat('d/m/Y', request()->date_start)->format('Y-m-d');
                    $date_to = Carbon\Carbon::createFromFormat('d/m/Y', request()->date_end)->format('Y-m-d');
                    $sumary = 0;
                    if (optional($data->first())->forward > 0) {
                        $sumLine = abs(optional($data->first())->forward);
                    } else {
                        $sumLine = -abs(optional($data->first())->forward);
                    }
                    $sum = 0;
                    $sum_gain_loss = 0;
                    $total_gain_loss = 0;
                    $total = 0;
                @endphp
                @foreach ($data->sortBy('customer_number')->groupBy('customer_number') as $customer_number => $item)
                    @php
                        $gain_loss = $item->sum('gain_loss');
                        $sum_gain_loss += @$gain_loss;
                        $outstanding = round($item->where('type_field', 'outstanding')->sum('payment_amount'), 2);
                        $payment = round($item->where('type_field', 'payment')->sum('payment_amount'), 2);
                        if ($item->first()->forward > 0)
                            $base = abs($item->first()->forward) + ($addCn->where('customer_number', $customer_number)->where('product_type_code', optional($item->first())->product_type_code)->sum('invoice_amount_convert')) ?? 0;
                        else{
                            $base = -abs($item->first()->forward) + ($addCn->where('customer_number', $customer_number)->where('product_type_code', optional($item->first())->product_type_code)->sum('invoice_amount_convert')) ?? 0;
                        }
                        
                        $sum_gain_loss = (round($item->sum('gain_loss_for'),3) * 100) /100;
                        $total_gain_loss += @$gain_loss; 
                        $base = explode( '.', number_format($base, 3, '.', ''));
                        $base = $base[0]. '.'. substr($base[1], 0, 2);
                        $base = $base;
                        $base = round($base - $sum_gain_loss,2);
                        $sum += $base;
                        if($payment_type_code == '20') {
                            $subtotal = $base + $outstanding - $payment - ($gain_loss);
                            $total += $subtotal;
                
                        } elseif($payment_type_code == '10') {
                            $subtotal = $base - $outstanding + $payment - ($gain_loss);
                            $total += $subtotal;

                        }else {
                            $subtotal = $base + $outstanding - $payment - $gain_loss;
                            $total += $subtotal;

                        }
                    @endphp
                    <tr>
                        <td align="left">
                            {{ $item->first()->customer_number }}
                        </td>
                        <td align="left">{{ $item->first()->customer_name }}</td>
                        <td align="right">
                            {{ number_format(($base), 2) }}
                        </td>
                        <td align="right">
                            {{ number_format($outstanding, 2) }}
                        </td>
                        <td align="right">
                            {{ number_format($payment, 2) }}
                        </td>
                        <td align="right">
                            @if($gain_loss < 0)
                            ({{ number_format(abs($gain_loss), 2) }})
                            @else 
                            {{ number_format($gain_loss, 2) }}
                            @endif
                        </td>
                        <td align="right">
                            {{ number_format($subtotal, 2) }}

                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="border-tom-bottom"></td>
                    <td class="border-tom-bottom">รวม</td>
                    <td class="border-tom-bottom" align="right">
                        {{number_format($sum, 2)}}
                    </td>
                    <td class="border-tom-bottom" align="right">
                        {{ number_format($data->where('type_field', 'outstanding')->sum('payment_amount'), 2) }}
                    </td>
                    <td class="border-tom-bottom" align="right">
                        {{ number_format($data->where('type_field', 'payment')->sum('payment_amount'), 2) }}
                    </td>
                    <td class="border-tom-bottom" align="right">
                            @if($total_gain_loss < 0)
                            ({{ number_format(abs($total_gain_loss), 2) }})
                            @else 
                            {{ number_format($total_gain_loss, 2) }}
                            @endif
                    </td>
                    <td class="border-tom-bottom" align="right">
                        {{ number_format($total, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
        @endforeach
    {{-- @endforeach --}}
</body>

</html>
