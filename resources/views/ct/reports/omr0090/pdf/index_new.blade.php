<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานความเคลื่อนไหวบัญชีเจ้าหนี้ค่าบุหรี่รายตัว</title>
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
    @foreach ($results->sortBy(function($i, $k) {
        if($i->customer_number == 'D00018')
        {
            return -1;
        } else {
            return $k;
        }
            return $i->customer_number;
        })->groupby('customer_number') as $customerNumber => $items)
        @php 
            $quotedItem     = $quoted->where('customer_number', $customerNumber)->first();
            $follow_base    = $follow->where('customer_id', $items->first()->customer_id)->first();
            if($follow_base) {
                $base = $follow_base->total_moving;
            } else {
                $base = 0;
            }
        @endphp
        <div class="page"></div>
        <table style="width:100%">
            <thead>
                <tr>
                    <td colspan="7" style="">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">โปรแกรม : OMR0090</td>
                                <td align="center">การยาสูบแห่งประเทศไทย</td>
                                <td style="width:20%">วันที่ : {{ now()->addYears('543')->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" style=" ">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">สั่งพิมพ์ : {{ auth()->user()->username }}</td>
                                <td align="center">ความเคลื่อนไหวบัญชีเจ้าหนี้ค่าบุหรี่สโมสร(เงินสด) รายตัว</td>
                                <td style="width:20%">เวลา : {{ now()->addYears('543')->format('H:i') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" style=" ">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td style="width:20%">หน้า : </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="7">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%"></td>
                                <td align="center">{{ $customerNumber }} {{ $items->first()->customer_name }}</td>
                                <td style="width:20%">หน่วย : บาท</td>
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
                    <td class="border-tom-bottom" align="right">ค่าบุหรี่&nbsp;&nbsp;&nbsp;</td>
                    <td class="border-tom-bottom" align="right">เงินสด/โอนบัญชี&nbsp;&nbsp;&nbsp;</td>
                    <td class="border-tom-bottom" align="right">คงเหลือ&nbsp;&nbsp;&nbsp;</td>
                    <td class="border-tom-bottom"></td>
                </tr>
                @php 
                    $total = 0;
                    $totalDebtAmount = 0;
                    $totalPaymentAmount = 0;
                @endphp
                <tr>
                    <td></td>
                    <td></td>
                    </td>
                    <td></td>
                    <td></td>
                    <td align="right">

                        {{ number_format($base, 2) }}
                    </td>
                    <td></td>
                </tr>
                @php 
                @endphp
                @foreach ( $items->sortBy(function($i) { 
                    $sorting = $i->sorting;
                    if($i->customer_id == '18') {
                        $sorting = $i->total_payment_amount > 0 ? 1 : 2;
                    }
                    return Carbon\Carbon::parse($i->at_date)->format('Y-m-d'). $sorting; 
                    }) as $i)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($i->at_date)->format('d/m/Y') }}</td>
                        <td>{{ $i->consignment_no}}</td>
                        </td>
                        <td align="right">{{ $i->debt_amount > 0 ? number_format($i->debt_amount, 2) : ''}}</td>
                        <td align="right">{{ $i->total_payment_amount > 0 ? number_format($i->total_payment_amount, 2) : '' }}</td>
                        <td align="right">
                            @php 
                                $base = $base - $i->total_payment_amount + $i->debt_amount;
                            @endphp
                            @if($base < 0) 
                            ({{ number_format(abs($base), 2) }})
                            @else 
                            {{ number_format($base, 2) }}
                            @endif
                        </td>
                        
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td  class="border-tom-bottom">รวม</td>
                    <td  class="border-tom-bottom"></td>
                    <td  class="border-tom-bottom" align="right">{{ number_format($items->sum('debt_amount'), 2) }}</td>
                    @if($customerNumber=='D00018')
                    <td  class="border-tom-bottom" align="right">{{ number_format($items->where('typsis', 'GENARAL_FALSE')->sum('total_payment_amount'), 2) }}</td>
                    @else
                    <td  class="border-tom-bottom" align="right">{{ number_format($items->where('typsis', 'GENARAL')->sum('total_payment_amount'), 2) }}</td>
                    @endif
                    <td  class="border-tom-bottom"></td>
                    <td  class="border-tom-bottom"></td>
                    <td  class="border-tom-bottom"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <div>
            <div style="padding-top:1px;text-align:center">จบรายงาน</div>
            <div style="padding-top:1px;text-align:right">
                <div>ผู้จัดทำ _____________________________ ผู้รับรอง _____________________________ <br><br>
        </div>
    @endforeach
    @foreach ($quoted->whereNotIn('customer_id', $results->pluck('customer_id')->toArray()) as $item)
        <div class="page"></div>
        <table style="width:100%">
            <thead>
                <tr>
                    <td colspan="7" style="">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">โปรแกรม : OMR0090</td>
                                <td align="center">การยาสูบแห่งประเทศไทย</td>
                                <td style="width:20%">วันที่ : {{ now()->addYears('543')->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" style=" ">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">สั่งพิมพ์ : {{ auth()->user()->username }}</td>
                                <td align="center">ความเคลื่อนไหวบัญชีลูกหนี้ค่าบุหรี่สโมสร(เงินสด) รายตัว</td>
                                <td style="width:20%">เวลา : {{ now()->addYears('543')->format('H:i') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" style=" ">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td style="width:20%">หน้า : </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="7">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%"></td>
                                <td align="center">{{ $item->customer_number }} {{ $item->customer_name }}</td>
                                <td style="width:20%">หน่วย : บาท</td>
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
                    <td class="border-tom-bottom" align="right">ค่าบุหรี่&nbsp;&nbsp;&nbsp;</td>
                    <td class="border-tom-bottom" align="right">เงินสด/โอนบัญชี&nbsp;&nbsp;&nbsp;</td>
                    <td class="border-tom-bottom" align="right">คงเหลือ&nbsp;&nbsp;&nbsp;</td>
                    <td class="border-tom-bottom"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    </td>
                    <td></td>
                    <td></td>
                    <td align="right">
                        {{ number_format($item->total_amount, 2) }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td  class="border-tom-bottom">รวม</td>
                    <td  class="border-tom-bottom"></td>
                    <td  class="border-tom-bottom" align="right"></td>
                    <td  class="border-tom-bottom" align="right"></td>
                    <td  class="border-tom-bottom"></td>
                    <td  class="border-tom-bottom"></td>
                    <td  class="border-tom-bottom"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <div>
            <div style="padding-top:1px;text-align:center">จบรายงาน</div>
            <div style="padding-top:1px;text-align:right">
                <div>ผู้จัดทำ _____________________________ ผู้รับรอง _____________________________ <br><br>
        </div>
    @endforeach
</body>

</html>
