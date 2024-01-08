<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ie.commons.report.pdf.ct-wht-register._style')
    </head>
    <body>
        @php
            $line_no = 0;
            $total = $total_tax = 0;
        @endphp
        @foreach ($data as $page => $groupDocument)
            @php
                $total_page = $loop->count;
            @endphp
            @foreach ($groupDocument as $document_no => $items)
                @php
                    $show_type = optional(optional(collect($items['lines'])->first())->ref)->distribution_income_type;
                @endphp
                <div style="margin-bottom: 1rem;">
                    <div class="inline-block" style="width: 33%;">
                        <div>

                        </div>
                    </div>
                    <div class="inline-block text-center" style="width: 33%;">
                        <div>
                            การยาสูบแห่งประเทศไทย
                        </div>
                        <div>
                            ทะเบียนคุมภาษีเงินได้หัก ณ ที่จ่าย 
                            @if ($show_type == 'ภงด.3')
                                บุคคลธรรมดา
                            @elseif($show_type == 'ภงด.53')
                                นิติบุคคล 
                            @endif
                        </div>
                        <div>
                            สำหรับวันที่ {{ strtoupper( $startDate ) }} ถึงวันที่ {{ strtoupper( $endDate ) }}
                        </div>
                    </div>
                    <div class="inline-block text-right" style="width: 33%;">
                        <div>
                            วันที่จัดพิมพ์ {{ strtoupper(date('d-M-y H:i:s')) }}
                        </div>
                        <div>
                            Page {{ $page+1 }} / {{ $total_page }}
                        </div>
                        <div>
                            {{ $document_no }}
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td class="text-center" width="30px;">
                                ลำดับที่
                            </td>
                            <td class="text-center" width="60px;">
                                วันที่จ่ายเงิน
                            </td>
                            <td class="text-center" width="100px;">
                                เลขที่หนังสือรับรอง
                            </td>
                            <td class="text-center" width="200px;">
                                ชื่อร้านค้า
                            </td>
                            <td class="text-center" width="85px;">
                                เลขประจำตัว <br> ผู้เสียภาษี
                            </td>
                            <td class="text-center">
                                ที่อยู่
                            </td>
                            <td class="text-center" width="75px;">
                                จำนวนเงิน
                            </td>
                            <td class="text-center" width="60px;">
                                ภาษีหัก <br> ณ ที่จ่าย
                            </td>
                            <td class="text-center" width="100px;">
                                ใบแจ้งหนี้
                            </td>
                            <td class="text-center" width="60px;">
                                วันที่ <br> GL Date
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (collect($items['lines'])->groupBy('dff_wht_ref_number') as $ref_number => $group)
                            @foreach ($group as $item)
                                @php
                                    $ref = $item->ref;
                                    $header = optional($ref->header)->parent;
                                    $ref_amt = (float)$item->total_primary_amount; 
                                    $line_amt = $group->count() > 1 ? -(((float)$item->total_amount_inc_vat - (float)$item->vat_amount) / 100) : ((float)$ref->total_amount_inc_vat - (float)$ref->vat_amount);
                                    $total += $ref_amt;
                                    $total_tax += (float)$line_amt;
                                    $line_no++;
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        {{-- ลำดับที่ --}}
                                        {{ $line_no }}
                                    </td>
                                    <td class="text-center">
                                        {{-- วันที่จ่ายเงิน distribution --}}
                                        {{ date('d-M-y', strtotime($ref->distribution_wht_date)) }}
                                    </td>
                                    <td class="text-center">
                                        {{-- เลขที่หนังสือรับรอง --}}
                                        {{ $ref->distribution_cert_number }}
                                    </td>
                                    <td>
                                        {{-- ชื่อร้านค้า --}}
                                        {{ $item->dff_pay_for ?? $header->dff_pay_for }}
                                    </td>
                                    <td>
                                        {{-- เลขประจำตัวผู้เสียภาษี --}}
                                        {{ $item->dff_tax_id ?? $header->dff_tax_id }}
                                    </td>
                                    <td>
                                        {{-- ที่อยู่ --}}
                                        {{ $item->dff_address ?? $header->dff_address }}
                                    </td>
                                    <td class="text-right">
                                        {{-- จำนวนเงิน --}}
                                        {{ numberFormatDisplay($ref_amt) }}
                                    </td>
                                    <td class="text-right">
                                        {{-- ภาษี --}}
                                        {{ numberFormatDisplay($line_amt) }}
                                    </td>
                                    <td>
                                        {{-- ใบแจ้งหนี้ --}}
                                        {{-- {{ $item->dff_tax_invoice_number }} --}}
                                        {{ in_array($document_type, ['CLEARING']) ? optional($header)->clearing_invoice_no : optional($header)->invoice_no }}
                                    </td>
                                    <td class="text-center">
                                        {{-- วันที่ invoice --}} 
                                        {{ in_array($document_type, ['CLEARING']) ? date('d-M-y', strtotime(optional($header)->clearing_gl_date)) : date('d-M-y', strtotime(optional($header)->gl_date)) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        @if ($items['end_flag'])
                            <tr style="border: 0 !important;">
                                <td colspan="6" class="text-right" style="border: 0 !important;">
                                    รวม
                                </td>
                                <td class="text-right" style="border: 0 !important;">
                                    {{ numberFormatDisplay($total) }}
                                </td>
                                <td class="text-right" style="border: 0 !important;">
                                    {{ numberFormatDisplay($total_tax) }}
                                </td>
                                <td style="border: 0 !important;">

                                </td>
                                <td style="border: 0 !important;">

                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{-- <div class="row text-right" style="width: 80%; margin-top: 10px">
                    <div>
                        รวม
                    </div>
                    <div>
                        {{ numberFormatDisplay($total) }}
                    </div>
                    <div>
                        {{ numberFormatDisplay(abs($total_tax)) }}
                    </div>
                </div> --}}

                @if ($items['end_flag'])
                    @php
                        $line_no = 0;
                        $total = $total_tax = 0;
                    @endphp

                    <div class="row" style="margin-top: 10px; page-break-inside:avoid;">
                        <div>
                            &nbsp;
                        </div>
                        <div>
                            &nbsp;
                        </div>
                        <div class="text-center">
                            <div>
                                ผู้จัดทำ _________________________
                            </div>
                            <div style="margin-top: 10px">
                                วันที่ _______/_______/_______
                            </div>
                        </div>
                        <div class="text-center">
                            <div>
                                ผู้ตรวจสอบ _________________________
                            </div>
                            <div style="margin-top: 10px">
                                วันที่ _______/_______/_______
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </body>
</html>