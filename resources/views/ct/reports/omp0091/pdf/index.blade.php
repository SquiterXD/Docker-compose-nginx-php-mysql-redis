<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OMR0091 ยอดจำหน่ายบุหรี่ฝากขาย และยอดหนี้ค้างชำระ </title>
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
    @foreach ($result as $items)
        @if (!$loop->first)
            <div class="page">
            </div>
        @endif
        {{-- 7 columns --}}
        <table style="width:100%">
            <thead>
                <tr>
                    <td colspan="7" style="">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">โปรแกรม : OMR0091</td>
                                <td align="center">การยาสูบแห่งประเทศไทย</td>
                                <td style="width:20%;text-align:right;">วันที่ :
                                    {{ now()->addYears('543')->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" style=" ">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">สั่งพิมพ์ : {{ auth()->user()->username }}</td>
                                <td align="center">ยอดจำหน่ายบุหรี่ฝากขาย และยอดหนี้ค้างชำระ </td>
                                <td style="width:20%;text-align:right;">เวลา :
                                    {{ now()->addYears('543')->format('H:i') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" style=" ">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%"></td>
                                <td align="center">&nbsp;</td>
                                <td style="width:20%;text-align:right;">หน้า :
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- <tr>
                        <td colspan="7">
                            <table style="width:100%">
                                <tr>
                                    <td style="width:20%"></td>
                                    <td align="center">{{ $customerNumber }} {{ $items->first()['customer_name'] }}</td>
                                    <td style="width:20%">หน่วย : บาท</td>
                                </tr>
                            </table>
                        </td>
                    </tr> --}}

                <tr>
                    <td colspan="7">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%"></td>
                                <td align="center">ตั้งแต่วันที่
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_from)->addYears('543')->format('d/m/Y') }}
                                    ถึง วันที่
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->date_to)->addYears('543')->format('d/m/Y') }}
                                </td>
                                <td style="width:20%"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2" class="border-tom-bottom">รหัสร้านค้า</td>
                    <td rowspan="2" class="border-tom-bottom">ชื่อร้านค้า</td>
                    <td colspan="2" class="border-tom-bottom" style="text-align: center">ยอดยกมา</td>
                    <td rowspan="2" class="border-tom-bottom" style="width:80px;" align="right">ยอดจำหน่าย</td>
                    <td rowspan="2" class="border-tom-bottom" style="width:80px;" align="right">ยอดชำระงิน</td>
                    <td colspan="2" class="border-tom-bottom" style="text-align: center">ยอดยกไป</td>
                </tr>
                <tr>
                    <td class="border-tom-bottom" style="text-align: right;width:80px;">ลูกหนี้</td>
                    <td class="border-tom-bottom" style="text-align: right;width:80px;">เจ้าหนี้</td>
                    <td class="border-tom-bottom" style="text-align: right;width:80px;">ลูกหนี้</td>
                    <td class="border-tom-bottom" style="text-align: right;width:80px;">เจ้าหนี้</td>
                </tr>
                @php
                    $totalSum = 0;
                    $totalOut = 0;
                    $totalPayment = 0;
                    $total = 0;
                    $total2 = 0;
                @endphp
                @foreach ($items->sortBy('customer_number')->groupBy('customer_id') as $item)
                    @php
                        
                        $payment = $paymentDomV->where('customer_id', $item->first()->customer_id);
                        $paymeny_amount = 0;
                        if (count($payment) > 0) {
                            $paymeny_amount = $payment->sum('payment_amount');
                        }
                        $columns_credit_moving = ($item->where('creditor', '>', 0)->first()->creditor ?? 0) - ($item->where('poured_over', '>', 0)->first()->poured_over ?? 0) - $item->sum('debt_amount') + $paymeny_amount;
                        $columns_credit_moving = $columns_credit_moving > 0 ? $columns_credit_moving : 0;
                        $totalSum += $item->where('poured_over', '>', 0)->first()->poured_over ?? 0;
                        $totalOut += $item->sum('debt_amount');
                        $totalPayment += $paymeny_amount;
                        $total += ($item->where('poured_over', '>', 0)->first()->poured_over ?? 0) + $item->sum('debt_amount') - $paymeny_amount;
                        $total2 += $columns_credit_moving;
                    @endphp
                    <tr>
                        <td>{{ $item->first()->customer_number }}</td>
                        <td>{{ $item->first()->customer_name }}</td>
                        <td align="right">{{ number_format($item->where('poured_over', '>', 0)->first()->poured_over ?? 0, 2) }}</td>
                        <td align="right">{{ number_format($item->where('creditor', '>', 0)->first()->creditor ?? 0, 2) }}</td>
                        <td align="right">{{ number_format($item->sum('debt_amount'), 2) }}</td>
                        <td align="right">{{ number_format($paymeny_amount, 2) }}</td>
                        <td align="right">
                            {{ number_format(($item->where('poured_over', '>', 0)->first()->poured_over ?? 0) + $item->sum('debt_amount') - $paymeny_amount, 2) }}
                        </td>
                        <td align="right">
                            {{ number_format($columns_credit_moving, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="border-tom-bottom">รวม</td>
                    <td class="border-tom-bottom"></td>
                    <td class="border-tom-bottom" align="right">{{ number_format($totalSum, 2) }}</td>
                    <td class="border-tom-bottom" align="right">0.00</td>
                    <td class="border-tom-bottom" align="right">{{ number_format($totalOut, 2) }}</td>
                    <td class="border-tom-bottom" align="right">{{ number_format($totalPayment, 2) }}</td>
                    <td class="border-tom-bottom" align="right">{{ number_format($total, 2) }}</td>
                    <td class="border-tom-bottom" align="right">{{ number_format($total2, 2) }}</td>
                </tr>
                {{-- @if($loop->last) --}}
                <tr>
                    <td colspan="8" align="center">จบรายงาน</td>
                </tr>
                <tr>
                    <td colspan="4" align="center">ผู้จัดทำ____________</td>
                    <td colspan="4" align="center">ผู้รับรอง______________</td>
                </tr>
                {{-- @endif --}}
            </tbody>
        </table>
    @endforeach

</body>

</html>
