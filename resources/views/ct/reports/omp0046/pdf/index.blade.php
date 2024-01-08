<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OMR0046 ยอดจำหน่ายบุหรี่เงินเชื่อและยอดหนี้ค้างชำระ </title>
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
    <div class="page">
    </div>

    {{-- 7 columns --}}
    <table style="width:100%">
        <thead>
            <tr>
                <td colspan="7" style="">
                    <table style="width:100%">
                        <tr>
                            <td style="width:20%">โปรแกรม : OMR0046</td>
                            <td align="center">การยาสูบแห่งประเทศไทย</td>
                            <td style="width:20%;text-align:right;">วันที่ : {{ now()->addYears('543')->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="7" style=" ">
                    <table style="width:100%">
                        <tr>
                            <td style="width:20%">สั่งพิมพ์ : {{ auth()->user()->username }}</td>
                            <td align="center">ยอดจำหน่ายบุหรี่เงินเชื่อ และยอดหนี้ค้างชำระ</td>
                            <td style="width:20%;text-align:right;">เวลา : {{ now()->addYears('543')->format('H:i') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="7" style=" ">
                    <table style="width:100%">
                        <tr>
                            <td style="width:20%"></td>
                            <td align="center">{{ $creditGroup->description }}</td>
                            <td style="width:20%;text-align:right;">หน้า : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
            <tr>
                <td rowspan="2" class="border-tom-bottom">รหัสร้านค้า</td>
                <td rowspan="2" class="border-tom-bottom">ชื่อร้านค้า</td>
                <td colspan="2" class="border-tom-bottom" style="text-align: center">ยอดยกมา</td>
                <td rowspan="2" class="border-tom-bottom" style="width:70px" align="right">ยอดจำหน่าย</td>
                <td rowspan="2" class="border-tom-bottom" style="width:70px" align="right">ยอดชำระงิน</td>
                <td colspan="2" class="border-tom-bottom" style="text-align: center">ยอดยกไป</td>
            </tr>
            <tr>
                <td class="border-tom-bottom" style="text-align: right;width:70px">ลูกหนี้</td>
                <td class="border-tom-bottom" style="text-align: right;width:70px">เจ้าหนี้</td>
                <td class="border-tom-bottom" style="text-align: right;width:70px">ลูกหนี้</td>
                <td class="border-tom-bottom" style="text-align: right;width:70px">เจ้าหนี้</td>
            </tr>
        </thead>

        <tbody>

            @php
                $totalSum = 0;
                $totalOut = 0;
                $totalPayment = 0;
                $total = 0;
            @endphp
            @foreach ($result as $item)
                @php
                    $payment = $paymentDomV->where('customer_id', $item->first()->customer_id);
                    $paymeny_amount = 0;
                    if(count($payment) > 0) {
                        $paymeny_amount = $payment->sum('payment_amount');
                    }
                    // if($item->first()->customer_number == 'D00160') {
                    //     dd($payment);
                    // }
                    $totalSum += $item->first()->sum;
                    $totalOut += $item->where('data_ty', '!=', 'othor')->sum('debt_amount');
                    $totalPayment += $paymeny_amount;
                    $total += ($item->first()->sum + $item->where('data_ty', '!=', 'othor')->sum('debt_amount')) - $paymeny_amount;

                @endphp
                <tr>
                    <td>{{ $item->first()->customer_number }}</td>
                    <td>{{ $item->first()->customer_name }} {{$item->first()->customer_id}}</td>
                    <td align="right">{{ number_format($item->first()->sum, 2) }}</td>
                    <td align="right">0.00</td>
                    <td align="right">{{ number_format($item->where('data_ty', '!=', 'othor')->sum('debt_amount'), 2) }}</td>
                    <td align="right">{{ number_format($paymeny_amount, 2) }}</td>
                    <td align="right">
                        {{ number_format(($item->first()->sum + $item->where('data_ty', '!=', 'othor')->sum('debt_amount')) - $paymeny_amount, 2) }}</td>
                    <td align="right">0.00</td>
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
                <td class="border-tom-bottom" align="right">0.00</td>
            </tr>
            <tr>
                <td colspan="8" align="center">จบรายงาน</td>
            </tr>
            <tr>
                <td colspan="4" align="center">ผู้จัดทำ____________</td>
                <td colspan="4" align="center">ผู้รับรอง______________</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
