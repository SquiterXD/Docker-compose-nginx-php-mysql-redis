<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานความเคลื่อนไหวบัญชีลูกหนี้ค่าบุหรี่รายตัว</title>
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
        thead{display: table-header-group;}
        tfoot {display: table-row-group;}
        tr {page-break-inside: avoid;}
        
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
            margin:0;
        }
    </style>
</head>

<body>
    @foreach ($result as $customerNumber => $items)
        <div class="page">
        </div>

            {{-- 7 columns --}}
            <table style="width:100%">
                <thead>
                    <tr>
                        <td colspan="7" style="">
                            <table style="width:100%">
                                <tr>
                                    <td style="width:20%">โปรแกรม : OMR0040</td>
                                    <td align="center">การยาสูบแห่งประเทศไทย</td>
                                    <td style="width:20%;text-align: right;">วันที่ : {{ now()->addYears('543')->format('d/m/Y') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="7" style=" ">
                            <table style="width:100%">
                                <tr>
                                    <td style="width:20%">สั่งพิมพ์ : {{ auth()->user()->username }}</td>
                                    <td align="center">ความเคลื่อนไหวบัญชีลูกหนี้ค่าบุหรี่รายตัว</td>
                                    <td style="width:20%;text-align: right;">เวลา : {{ now()->addYears('543')->format('H:i') }}</td>
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
                                    <td style="width:20%;text-align: right;">หน้า :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="7">
                            <table style="width:100%">
                                <tr>
                                    <td style="width:20%"></td>
                                    <td align="center">{{ $customerNumber }} {{ $items->first()['customer_name'] }}</td>
                                    <td style="width:20%;text-align: right;">หน่วย : บาท</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

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
                        <td class="border-tom-bottom">วันเดือนปี</td>
                        <td class="border-tom-bottom">รายการ</td>
                        <td class="border-tom-bottom">วันครบกำหนดชำระ</td>
                        <td class="border-tom-bottom" style='text-align:right;padding-right:20px'>ค่าบุหรี่</td>
                        <td class="border-tom-bottom" style='text-align:right;padding-right:20px'>เงินสด/โอนบัญชี</td>
                        <td class="border-tom-bottom" style='text-align:right;padding-right:20px'>คงเหลือ</td>
                        <td class="border-tom-bottom"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right">{{number_format($items->first()['depDomV'], 2)}}</td>
                        <td>
                            </td>
                        <td></td>
                    </tr>
                    @php 
                        $total = $items->first()['depDomV'];
                        $totalDebtAmount = 0;
                        $totalPaymentAmount = 0;
                    @endphp
                    @php 
                    $items = $items->sortBy(function($i) { return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $i['date']).$i['prepare_order_number']; })
                                ->groupBy(function($i) { return $i['desc']. $i['credit_group_code']; });
                    @endphp
                    @foreach ( $items as $i)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($i->first()['date'])->addYears(543)->format('d/m/Y') }}</td>
                            <td>{{ $i->first()['desc'] }}</td>
                            <td>{{ Carbon\Carbon::parse($i->first()['due_date'])->addYears(543)->format('d/m/Y') }}
                            </td>
                            @php 
                                
                                $totalDebtAmount += $i->sum(function($i) { return (float)$i['debt_amount']; });
                                $totalPaymentAmount += $i->sum(function($i) { return (float)$i['payment_amount']; });
                            @endphp
                            <td style="text-align: right">{{ @number_format($i->sum(function($i) { return (float)$i['debt_amount']; }), 2) }}</td>
                            <td style="text-align: right">{{ @number_format($i->sum(function($i) { return (float)$i['payment_amount']; }), 2) }}</td>
                            @php 
                                $total += $i->sum(function($i) { return (float)$i['debt_amount']; }) - $i->sum(function($i) { return (float)$i['payment_amount']; });
                            @endphp
                            <td style="text-align: right">
                                @if($total > 0)
                                    {{ @number_format($total, 2) }}
                                @elseif($total == 0)
                                    0
                                @else
                                    {{ @number_format(abs($total), 2) }}
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td  class="border-tom-bottom">รวม</td>
                        <td  class="border-tom-bottom"></td>
                        <td  class="border-tom-bottom"></td>
                        <td  class="border-tom-bottom" style="text-align: right">{{ @number_format($totalDebtAmount, 2)}}</td>
                        <td  class="border-tom-bottom" style="text-align: right">{{ @number_format($totalPaymentAmount, 2)}}</td>
                        <td  class="border-tom-bottom"></td>
                        <td  class="border-tom-bottom"></td>
                    </tr>
                </tbody>
            </table>
            <table width="100%">
                <tr>
                
                    <td width="33%"style="vertical-align: middle;text-align: CENTER;" height="100"><b></b></td>
                    <td width="33%"style="vertical-align: middle;text-align: CENTER;" height="100"><b>ผู้จัดทำ ____________________________</b> </td>
                    <td width="33%"style="vertical-align: middle;text-align: CENTER;" height="100"><b>ผู้รับรอง  ____________________________</b></td>
                </tr>
            </table>        
    @endforeach

</body>

</html>
