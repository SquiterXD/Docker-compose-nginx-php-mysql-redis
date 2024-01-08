<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $programCode }}  ความเคลื่อนไหวบัญชี{{ $programCode== 'OMR0050'? 'เจ้าหนี้' : 'ลูกหนี้'}}ต่างประเทศ รายตัว</title>
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
    @foreach ($data->sortBy('customer_number')->groupBy('customer_number') as $data)
    @foreach($data->groupBy('product_type_desc') as $dataGroupProduct)
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
                                    ความเคลื่อนไหวบัญชี{{ $programCode== 'OMR0050'? 'เจ้าหนี้' : 'ลูกหนี้'}}ต่างประเทศ รายตัว <br>
                                    ประเภทสินค้า : {{$dataGroupProduct->first()->product_type_desc}}
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



                <tr>
                    <td colspan="7">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">รหัสร้านค้า : {{ $dataGroupProduct->first()->customer_number }} &nbsp;&nbsp;
                                    ชื่อร้านค้า : {{ $dataGroupProduct->first()->customer_name }}</td>

                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th class="border-tom-bottom">วันเดือนปี</th>
                    <th class="border-tom-bottom" style="width:35%">รายการ</th>
                    <th class="border-tom-bottom" style="text-align: center">ค่าบุหรี่</th>
                    <th class="border-tom-bottom" align="center">เงินสด/โอนบัญชี</th>
                    <th class="border-tom-bottom" align="center">กำไร(ขาดทุน)<br>จากอัตราแลกเปลี่ยน</th>
                    <th class="border-tom-bottom" style="text-align: center">คงเหลือ</th>
                </tr>


            </thead>
            <tbody>
                @php
                    
                @endphp
                @php
                    $sumary = 0;
                    $sumGain = 0;
                    if ($dataGroupProduct->first()->forward > 0) {
                        $sumLine = abs($dataGroupProduct->first()->forward) + optional($addCn->where('customer_number', $dataGroupProduct->first()->customer_number)->first())->invoice_amount_convert ?? 0;
                    } else {
                        $sumLine = -abs($dataGroupProduct->first()->forward) + optional($addCn->where('customer_number', $dataGroupProduct->first()->customer_number)->first())->invoice_amount_convert ?? 0;
                    }
                @endphp
                @foreach ($dataGroupProduct->sortBy(function($i) {
                    return $i->payment_date.(strpos($i->payment_number,'IV') === 0 ? 1 : 0);
                }) as $item)
                    @php
                        $gain_loss = 0;
                       
                        $set1 = $raw_gain_loss['result1']->where('prepare_order_number', $item->sa_number)->sum('conversion_amount_exclude_vat');
                        $set2 = $raw_gain_loss['result2']->where('sa_number', $item->sa_number)->sum('exchange');
                        $set3 = $raw_gain_loss['result3']->where('sa_number', $item->sa_number)->where('pick_release_no', $item->payment_number)->sum('exchange') ?? 0;
                        $check_set1 = $raw_gain_loss['result1']->where('prepare_order_number', $item->sa_number)->first();
                        $check_set4 = $raw_gain_loss['result3']->where('sa_number', $item->sa_number)->first();
                        
                        if(optional($check_set4)->pick_exchange_rate != null && $check_set1 !== null) {
                            $gain_loss = (($set1 + $set2) - $set3);
                        }
                        $sumLine += - $gain_loss;
                       
                        if(request()->program_code == 'OMR0051') {
                            if ($item->type_field == 'payment') {
                                $sumLine -= round($item->payment_amount, 2);
                            }
                            if ($item->type_field == 'outstanding') {
                                $sumLine += round($item->payment_amount, 2);
                            }
                        } else {
                            if ($item->type_field == 'payment') {
                                $sumLine += round($item->payment_amount, 2);
                            }
                            if ($item->type_field == 'outstanding') {
                                $sumLine -= round($item->payment_amount, 2);
                            }
                        }
                        $sumary += $sumLine;
                    @endphp
                    @if ($loop->first)
                        <tr>
                            <td align="left"></td>
                            <td align="left">ยอดยกมา</td>
                            <td align="right">

                            </td>
                            <td align="right">

                            </td>
                            <td></td>
                            <td align="right">
                                @php 
                                $addCnValue = ($addCn->where('customer_number', $item->customer_number)->where('product_type_code', $item->product_type_code)->sum('invoice_amount_convert')) ?? 0;
                                @endphp
                                {{ $item->forward > 0 ? number_format(abs($item->forward + $addCnValue), 2) : number_format(-abs($item->forward ) + $addCnValue, 2) }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td align="left">
                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->payment_date)->addYears(543)->format('d/m/Y') }}
                        </td>
                        <td align="left">{{ $item->payment_number }}</td>
                        <td align="right">
                            @if ($item->type_field == 'outstanding')
                                {{ number_format($item->payment_amount, 2) }}
                            @endif
                        </td>
                        <td align="right">
                            @if ($item->type_field == 'payment')
                                {{ number_format($item->payment_amount, 2) }}   
                            @endif
                        </td>
                        <td align="right">
                            @if($gain_loss < 0 ) 
                            {{  "(".number_format(str_replace('-','',$gain_loss), 2).")" }}
                            @else
                            {{ $gain_loss != 0 ? number_format($gain_loss, 2) : '' }}
                            @endif
                        </td>
                        <td align="right">{{ number_format($sumLine, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="border-tom-bottom"></td>
                    <td class="border-tom-bottom">รวม</td>
                    <td class="border-tom-bottom" align="right">
                        {{ number_format($dataGroupProduct->where('type_field', 'outstanding')->sum('payment_amount'), 2) }}
                    </td>
                    <td class="border-tom-bottom" align="right">
                        {{ number_format($dataGroupProduct->where('type_field', 'payment')->sum('payment_amount'), 2) }}
                    </td>
                    <td class="border-tom-bottom" align="right">
                        @if($sumGain < 0)
                        {{ "(".number_format(str_replace('-','',$sumGain), 2).")" }}
                        @else 
                        {{ $sumGain != 0 ? number_format($sumGain, 2) : '' }}
                        @endif
                    </td>
                    <td class="border-tom-bottom" align="right"></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table style="width:100%">
                            <tr>
                                <td align="center">ผู้จัดทำ _____________________________________</td>
                                <td align="center">ผู้รับรอง _____________________________________</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>

        </table>
    @endforeach
    @endforeach
    @foreach ($fo_data->groupBy('customer_number') as $data)
    @foreach($data->groupBy('product_type_desc') as $dataGroupProduct)

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
                                    ความเคลื่อนไหวบัญชี{{ $programCode== 'OMR0050'? 'เจ้าหนี้' : 'ลูกหนี้'}}ต่างประเทศ รายตัว <br>
                                    ประเภทสินค้า : {{$dataGroupProduct->first()->product_type_desc}}
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



                <tr>
                    <td colspan="7">
                        <table style="width:100%">
                            <tr>
                                <td style="width:20%">รหัสร้านค้า : {{ $dataGroupProduct->first()->customer_number }} &nbsp;&nbsp;
                                    ชื่อร้านค้า : {{ $dataGroupProduct->first()->customer_name }}</td>

                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th class="border-tom-bottom">วันเดือนปี</th>
                    <th class="border-tom-bottom" style="width:35%">รายการ</th>
                    <th class="border-tom-bottom" style="text-align: center">ค่าบุหรี่</th>
                    <th class="border-tom-bottom" align="center">เงินสด/โอนบัญชี</th>
                    <th class="border-tom-bottom" align="center">กำไร(ขาดทุน)<br>จากอัตราแลกเปลี่ยน</th>
                    <th class="border-tom-bottom" style="text-align: center">คงเหลือ</th>
                </tr>


            </thead>
            <tbody>
                
                        <tr>
                            <td align="left"></td>
                            <td align="left">ยอดยกมา</td>
                            <td align="right">

                            </td>
                            <td align="right">

                            </td>
                            <td></td>
                            <td align="right">
                                @php 
                                $addCnValue = ($addCn->where('customer_number', $dataGroupProduct->first()->customer_number)->where('product_type_code', $dataGroupProduct->first()->product_type_code)->sum('invoice_amount_convert')) ?? 0;
                                @endphp
                                {{ $dataGroupProduct->first()->forward > 0 ? number_format(abs($dataGroupProduct->first()->forward + $addCnValue), 2) : number_format(-abs($dataGroupProduct->first()->forward)  + $addCnValue, 2) }}
                            </td>
                        </tr>
                    
                <tr>
                    <td class="border-tom-bottom"></td>
                    <td class="border-tom-bottom">รวม</td>
                    <td class="border-tom-bottom" align="right">
0                       
                    </td>
                    <td class="border-tom-bottom" align="right">
                        0
                    </td>
                    <td class="border-tom-bottom" align="right"></td>
                    <td class="border-tom-bottom" align="right"></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table style="width:100%">
                            <tr>
                                <td align="center">ผู้จัดทำ_____________________________________</td>
                                <td align="center">ผู้รับรอง_____________________________________</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>

        </table>
    @endforeach
    @endforeach
</body>

</html>
