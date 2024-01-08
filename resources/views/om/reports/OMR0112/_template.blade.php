<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports.OMR0112._style')
    </head>
    <body>
        @foreach ($data as $page => $item)
            <div style="margin-bottom: 1rem;">
                <div class="inline-block" style="width: 22%">
                    <div >
                        โปรแกรม : OMR0112
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
                        สรุปการลงบัญชีประจำวัน {{ in_array($item['category'], ['WEB OP Sample', 'WEB OP จำนวนบุหรี่ขาย', 'WEB OP Sales Invoice']) ? 'ไปยังระบบบัญชีแยกประเภท' : 'ไปยังระบบบัญชีลูกหนี้' }}
                    </div>
                    <div>
                        วันที่ {{ dateFormatThai($date->format('d-M-Y')) }}
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
                        Category : {{ $item['category'] }}
                    </div>
                </div>
            </div>
            @foreach ($item['lines'] as $currency => $groupAccount)
                @php
                    $total_dr_amount = 0;
                    $total_cr_amount = 0;
                @endphp
                <div>
                    สกุลเงิน : {!! $currency !!}
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td class="text-center" width="46px;">
                                Line Num
                            </td>
                            <td class="text-center" width="200px;">
                                Account No.
                            </td>
                            <td class="text-center">
                                Account Name
                            </td>
                            <td class="text-center">
                                Debit
                            </td>
                            <td class="text-center">
                                Credit
                            </td>
                            <td class="text-center">
                                Description
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupAccount as $account => $groupDesc)
                            @foreach ($groupDesc as $desc => $line)
                                @php
                                    $total_dr_amount += $line['debit_amount'] ? (float)$line['debit_amount'] : 0;
                                    $total_cr_amount += $line['credit_amount'] ? (float)$line['credit_amount'] : 0;
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        {{ $line['line_num'] }}
                                    </td>
                                    <td>
                                        {{ $account }}
                                    </td>
                                    <td>
                                        {{ $line['account_name'] }}
                                    </td>
                                    <td class="text-right">
                                        {{ $line['debit_amount'] ? number_format($line['debit_amount'], 2) : '' }}
                                    </td>
                                    <td class="text-right">
                                        {{ $line['credit_amount'] ? number_format($line['credit_amount'], 2) : '' }}
                                    </td>
                                    <td>
                                        {{ $line['report_description'] }}
                                    </td>
                                </tr>
                            @endforeach
                            
                            @if($loop->last)
                                <tr style="border-top: 0.5px solid rgb(100, 100, 100);
                                    border-bottom: 0.5px solid rgb(100, 100, 100);">
                                    <td class="text-right" colspan="3">
                                        Total
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($total_dr_amount, 2) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($total_cr_amount, 2) }}
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach

            @if ($loop->last)
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

        @if ($reciept_flag)
            หมายเหตุรายการ :
            @foreach ($data_receipt as $match => $group)
                <div>
                    &ensp;
                    @if ($match == 'Y')
                        รับเงินใบเสร็จรับเงินเลขที่ :
                    @elseif ($match == 'N')
                        ยกเลิกใบเสร็จรับเงินเลขที่ :
                    @endif
                    <div>
                        @foreach ($group as $receipt_number => $amount)
                            @if ($loop->index % 30 == 0)
                                <div style="display:inline-block; vertical-align: text-top; width: 30%;">
                            @endif
                            <div>
                                &emsp; {{ $receipt_number }} {{ $match == 'Y' ? 'จำนวนเงินที่รับชำระ' : 'จำนวนเงินที่ยกเลิกชำระ' }} {{ number_format($amount, 2) }}
                            </div>
                            @if  ($loop->index % 30 == 29 || $loop->last)
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </body>
</html>