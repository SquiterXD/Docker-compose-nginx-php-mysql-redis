<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ยอดจำหน่ายบุหรี่เงินสด และยอดคงเหลือ</title>
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
                            <td style="width:20%">โปรแกรม : OMR0042</td>
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
                            <td align="center">ยอดจำหน่ายบุหรี่เงินสด และยอดคงเหลือ</td>
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
                            <td align="center">ตั้งแต่วันที่
                                {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->from_date)->addYears('543')->format('d/m/Y') }}
                                ถึง วันที่
                                {{ Carbon\Carbon::createFromFormat('d/m/Y', request()->to_date)->addYears('543')->format('d/m/Y') }}
                            </td>
                            <td style="width:20%;text-align:right;">หน้า : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- <tr>
                        <td colspan="7">
                            <table style="width:100%">
                                <tr>
                                    <td style="width:20%"></td>
                                    <td align="center"></td>
                                    <td style="width:20%">หน่วย : บาท</td>
                                </tr>
                            </table>
                        </td>
                    </tr> -->

            <tr>
                <td colspan="7">
                    <table style="width:100%">
                        <tr>
                            <td style="width:20%">&nbsp;</td>
                            <td align="center">
                            </td>
                            <td style="width:20%"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="border-tom-bottom" align="center" rowspan="2">รหัสร้านค้า</td>
                <td class="border-tom-bottom" align="center" rowspan="2">ชื่อร้านค้า</td>
                <td class="border-tom-bottom" align="center" colspan="2">ยอดยกมา</td>
                <td class="border-tom-bottom" align="center" rowspan="2">ยอดจำหน่าย</td>
                <td class="border-tom-bottom" align="center" rowspan="2">ยอดชำระงิน</td>
                <td class="border-tom-bottom" align="center" colspan="2">ยอดยกไป</td>
            </tr>
            <tr>
                <td class="border-tom-bottom" align="center">ลูกหนี้</td>
                <td class="border-tom-bottom" align="center">เจ้าหนี้</td>
                <td class="border-tom-bottom" align="center">ลูกหนี้</td>
                <td class="border-tom-bottom" align="center">เจ้าหนี้</td>
            </tr>
        </thead>

        <tbody>
            @php 
                $totalOutstandingDeb = 0;
                $totalOutstandingDebRang = 0;
                $totalPaymentAmountRang = 0;
                $totalDebtSum = 0;
            @endphp
            @foreach($result as $item)
            
            @php 
            $payment = $paymentDomV->where('customer_id', $item->first()->customer_id);
                    $paymeny_amount = 0;
                    if(count($payment) > 0) {
                        $paymeny_amount = $payment->sum('payment_amount');
                    }
            $outstandingDeb = $item->first()->sum;
            $outstandingDebRang = $item->sum('debt_amount');
            $paymentAmountRang = $paymeny_amount;
            $debtSum =  $outstandingDebRang - $paymentAmountRang;
            $totalOutstandingDeb += $outstandingDeb;
            $totalOutstandingDebRang += $outstandingDebRang;
            $totalPaymentAmountRang += $paymentAmountRang;
            $totalDebtSum += $debtSum;
            @endphp
            <tr>
                <td>{{ $item->first()->customer_number }}</td>
                <td>{{ $item->first()->customer_name }}</td>
                <td align="right">{{ number_format($outstandingDeb, 2) }}</td>
                <td align="right">0.00</td>
                <td align="right">{{ number_format($outstandingDebRang, 2) }}</td>
                <td align="right">{{ number_format($paymentAmountRang, 2) }}</td>
                <td align="right">{{ number_format($debtSum, 2) }}</td>
                <td align="right">0.00</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="border-tom-bottom"></td>
                <td class="border-tom-bottom">รวม</td>
                <td class="border-tom-bottom" align="right">{{ number_format($totalOutstandingDeb, 2) }}</td>
                <td class="border-tom-bottom" align="right">0.00</td>
                <td class="border-tom-bottom" align="right">{{ number_format($totalOutstandingDebRang, 2) }}</td>
                <td class="border-tom-bottom" align="right">{{ number_format($totalPaymentAmountRang, 2) }}</td>
                <td class="border-tom-bottom" align="right">{{ number_format($totalDebtSum, 2) }}</td>
                <td class="border-tom-bottom" align="right">0.00</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table style="width:100%">
        <tr>
            <td align="center">ผู้จัดทำ________________________</td>
            <td align="center">ผู้รับรอง________________________</td>
        </tr>
    </table>
</body>

</html>