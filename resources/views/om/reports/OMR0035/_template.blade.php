<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0035._style')
    </head>
    <body>
        @php
            $now = date('Y-m-d');
            $total_amount = 0;
            $total_tax_header_amount = 0;
            $total_pao_header_amount = 0;
        @endphp
        @foreach ($data as $page => $item)
            @php
                $amount = 0;
                $tax_header_amount = 0;
                $pao_header_amount = 0;
            @endphp
            <div style="margin-bottom: 1rem;">
                <div class="inline-block" style="width: 22%">
                    <div >
                        โปรแกรม : OMR0035
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
                        สรุปการผ่านข้อมูลรายการขาย ไปยังระบบบัญชีลูกหนี้ สำหรับขายในประเทศ
                    </div>
                    <div>
                        รายการขายประจำวันที่ {{ dateFormatThai($date->format('d-M-Y')) }}
                    </div>
                </div>
                <div class="inline-block text-right" style="width: 22%">
                    <div>
                        วันที่ {{ dateFormatThai(date('d-M-Y')) }}
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
                            ภาษี อบจ.
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item['lines'] as $doc_no => $lines)
                        @php
                            $sum_amount = (float)$lines->sum('amount');
                            $apply = $sum_amount >= 0 ? 1 : -1;
                            $tax_header_amount = $apply * (float)$lines->first()->tax_header_amount;
                            $pao_header_amount = $apply * (float)$lines->first()->pao_header_amount;
                            $amount = (float)$lines->sum('amount') - $tax_header_amount - $pao_header_amount;
                            $total_amount += $amount;
                            $total_tax_header_amount += $tax_header_amount;
                            $total_pao_header_amount += $pao_header_amount;
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{ $doc_no }}
                            </td>
                            <td>
                                {{ $lines->first()->customer_name }}
                            </td>
                            <td class="text-right">
                                {{ numberFormatDisplay($amount, 2) }}
                            </td>
                            <td class="text-right">
                                {{ numberFormatDisplay($tax_header_amount, 2) }}
                            </td>
                            <td class="text-right">
                                {{ numberFormatDisplay($pao_header_amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    @if($item['end_flag'])
                        <tr>
                            <td class="text-right">
                                ยอดสุทธิ
                            </td>
                            <td class="text-right">
                                {{ numberFormatDisplay($total_amount + $total_tax_header_amount + $total_pao_header_amount, 2) }}
                            </td>
                            <td class="text-right">
                                {{ numberFormatDisplay($total_amount, 2) }}
                            </td>
                            <td class="text-right">
                                {{ numberFormatDisplay($total_tax_header_amount, 2) }}
                            </td>
                            <td class="text-right">
                                {{ numberFormatDisplay($total_pao_header_amount, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if ($item['end_flag'])
                @php
                    $total_amount = 0;
                    $total_tax_header_amount = 0;
                    $total_pao_header_amount = 0;
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