<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0113._style')
    </head>
    <body>
        @foreach ($data as $page => $item)
            <div style="margin-bottom: 1rem;">
                <div class="inline-block" style="width: 22%">
                    <div >
                        โปรแกรม : OMR0113
                    </div>
                    <div>
                        สั่งพิมพ์ : {{ \Auth::user()->username }}
                    </div>
                </div>
                <div class="inline-block text-center" style="width: 55%">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        สรุปการผ่านข้อมูลรายการขาย ไปยังระบบบัญชีลูกหนี้ สำหรับขายต่างประเทศ
                    </div>
                    <div>
                        รายการขายประจำวันที่ {{ $date->format('d-M-Y') }}
                    </div>
                </div>
                <div class="inline-block text-right" style="width: 22%">
                    <div>
                        วันที่ {{ date('d-M-Y') }}
                    </div>
                    <div>
                        เวลา {{ strtoupper(date('H:i')) }}
                    </div>
                    <div>
                        หน้า {{ $page }}
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <div class="inline-block" style="width: 22%">
                    <div >
                        Group ID : {{ $item['group_id'] }}
                    </div>
                    <div>
                        รายการขาย : 
                    </div>
                </div>
            </div>
            @foreach ($item['lines'] as $currency => $groupDoc)
                @php
                    $amount_before_tax = 0;
                    $tax_amount = 0;
                    $amount = 0;
                    $total_amount_before_tax = 0;
                    $total_tax_amount = 0;
                    $total_amount = 0;
                @endphp
                <div>
                    สกุลเงิน : {!! $currency !!}
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td class="text-center" width="90px;">
                                เลขที่เอกสาร
                            </td>
                            <td class="text-center">
                                ชื่อลูกค้า
                            </td>
                            <td class="text-center" width="150px;">
                                จำนวนเงิน
                            </td>
                            <td class="text-center" width="150px;">
                                ภาษีขาย
                            </td>
                            <td class="text-center" width="150px;">
                                จำนวนเงินรวมภาษีขาย
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupDoc as $doc_no => $lines)
                            @php
                                $amount_before_tax = (float)$lines->whereNotNull('tax_code')->sum('amount_before_tax');
                                $tax_amount = (float)$lines->whereNull('tax_code')->where('total_amount', '>', 0)->sum('amount_before_tax');
                                $amount = $amount_before_tax + $tax_amount;
                                $total_amount_before_tax += $amount_before_tax;
                                $total_tax_amount += $tax_amount;
                                $total_amount += $amount;
                            @endphp
                            <tr>
                                <td class="text-center">
                                    {{ $doc_no }}
                                </td>
                                <td>
                                    {{ $lines->first()->customer_name }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay($amount_before_tax, 2) }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay($tax_amount, 2) }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay($amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        @if($item['end_flag'])
                            <tr>
                                <td class="text-right">
                                    ยอดสุทธิ
                                </td>
                                <td class="text-right">
                                    
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay($total_amount_before_tax, 2) }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay($total_tax_amount, 2) }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay($total_amount, 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @endforeach

            @if ($item['end_flag'])
                @php
                    $total_amount_before_tax = 0;
                    $total_tax_amount = 0;
                    $total_amount = 0;
                @endphp
                <div style="margin-top: 1rem;">
                    <div class="inline-block" style="width: 22%">
                        <div>
                        </div>
                    </div>
                    <div class="inline-block text-center" style="width: 55%">
                            *** จบรายงาน ***
                    </div>
                    <div class="inline-block text-right" style="width: 22%">
                        <div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="page-break"></div>

        @endforeach
    </body>
</html>