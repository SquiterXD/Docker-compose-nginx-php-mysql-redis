<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ie.commons.report.pdf.ct-vat-register._style')
    </head>
    <body>
        @php
            $now = date('Y-m-d');
        @endphp
        @foreach ($data as $document)
            <div style="width: 100%; margin-bottom: 5px">
                <div class="inline-block align-top" style="width:26%; padding:0; margin:0;">
                    <div>การยาสูบแห่งประเทศไทย</div>
                    <div style="padding-top:4px;">ผู้จัดเตรียม : {{ optional($document->preparer)->name }}</div>
                </div>
                <div class="text-center inline-block" style="vertical-align: bottom; width:46%; padding:40 0 0 0; margin:0;">
                    ทะเบียนนำส่งใบกำกับภาษี / ใบแจ้งหนี้
                </div>
                <div class="text-right inline-block" style="width:26%;">
                    <div>Report Date : {{ strtoupper(date('d-M-Y h:i:s')) }}</div>
                    <div style="padding-top:3px;">Page {{$loop->iteration}} / {{$loop->count}}</div>
                </div>
            </div>
            <div style="width: 100%; margin-bottom: 10px">
                <div class="inline-block align-top" style="width:26%; padding:0; margin:0;">
                    Currency : {{ $document->currency_id }}
                </div>
                <div class="text-center inline-block align-top" style="width:46%; padding:0; margin:0;">
                    Date Entry Person : {{ dateFormatDisplay($document->creation_date) }}
                </div>
                <div class="text-right inline-block align-top" style="width:26%; padding:0; margin:0;">
                    Document Number : {{ in_array($document_type, ['CLEARING']) ? $document->clearing_document_no : $document->document_no }}
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr style="page-break-inside:avoid;">
                        <td class="text-center" width="20px">
                            No.
                        </td>
                        <td class="text-center" width="67px">
                            Invoice Date
                        </td>
                        <td class="text-center" width="140px">
                            Invoice Number
                        </td>
                        <td class="text-center">
                            Supplier Name
                        </td>
                        <td class="text-center" width="80px">
                            Amount
                        </td>
                        <td class="text-center" colspan="2" width="112px">
                            Vat Amount
                        </td>
                        <td class="text-center" colspan="2" width="122px">
                            Original Amount
                        </td>
                        <td class="text-center" width="72px">
                            Vat
                        </td>
                        <td class="text-center" width="90px">
                            WHT Code
                        </td>
                        <td class="text-center" width="180px">
                            Description
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="page-break-inside:avoid;">
                        @php
                            $amount_before_tax = in_array($document_type, ['CASH-ADVANCE']) ? $document->amount : $document->total_receipt_amount_before_tax;
                            $tax_amount = in_array($document_type, ['CASH-ADVANCE']) ? 0 : $document->total_receipt_tax;
                            $amount = in_array($document_type, ['CASH-ADVANCE']) ? $document->amount : $document->total_receipt_amount;
                            $interface = $document->interfaces->where('request_from', $document_type)->first();
                            $line_num = 0;
                        @endphp
                        <td class="text-center">
                            {{-- No. --}}
                            {{ $line_num+1 }}
                        </td>
                        <td class="text-center">
                            {{-- Invoice Date --}}
                            {{ dateFormatDisplay((in_array($document_type, ['CLEARING']) ? $document->clearing_request_date : $document->request_date)) }}
                        </td>
                        <td class="text-center">
                            {{-- Invoice Number --}}
                            {{ in_array($document_type, ['CLEARING']) ? $document->clearing_invoice_no : $document->invoice_no }}
                        </td>
                        <td class="text-center">
                            {{-- Supplier Name --}}
                            {{ optional($document->supplierSite)->vendor_name }}
                        </td>
                        <td class="text-right">
                            {{-- Amount --}}
                            {{ numberFormatDisplay($amount_before_tax) }}
                        </td>
                        <td class="text-right" colspan="2">
                            {{-- Vat --}}
                            {{ numberFormatDisplay($tax_amount) }}
                        </td>
                        <td class="text-right" colspan="2">
                            {{-- Original Amount --}}
                            {{ numberFormatDisplay($amount) }}
                        </td>
                        <td class="text-center">
                            @php
                                $receipt_ids = $document->receipts()->processType($document_type)->pluck('receipt_id');
                                $line = \App\Models\IE\ReceiptLine::whereIn('receipt_id', $receipt_ids)->whereNotNull('vat_id')->first();
                                $taxVAT = \App\Models\IE\VAT::where('tax_rate_code', optional($line)->vat_id)->whereOrgId($document->org_id)->first();
                            @endphp
                            {{ optional($taxVAT)->tax_rate_code }}
                        </td>
                        <td class="text-center">
                            @php
                                $receipt_ids = $document->receipts()->processType($document_type)->pluck('receipt_id');
                                $line = \App\Models\IE\ReceiptLine::whereIn('receipt_id', $receipt_ids)->whereNotNull('wht_id')->first();
                                $taxWHT = \App\Models\IE\WHT::where('pay_awt_group_id', optional($line)->wht_id)->whereOrgId($document->org_id)->first();
                            @endphp
                            {{ optional($taxWHT)->wht_name }}
                        </td>
                        <td>
                            {{-- Description --}}
                            {{ in_array($document_type, ['CASH-ADVANCE']) ? $document->reason : $document->purpose }}
                        </td>
                    </tr>
                    <tr style="border: 0 !important; page-break-inside:avoid;">
                        <td style="border: 0 !important;"></td>
                        <td style="border: 0 !important;"></td>
                        <td class="text-right" style="border: 0 !important;">
                            Total for {{ $document->currency_id }} :
                        </td>
                        <td style="border: 0 !important;"></td>
                        <td class="text-right" style="border-left: 0 !important; border-right: 0 !important;">
                            {{ numberFormatDisplay($amount_before_tax) }}
                        </td>
                        <td width="3px" style="border: 0 !important;"></td>
                        <td class="text-right" style="border-left: 0 !important; border-right: 0 !important;">
                            {{ numberFormatDisplay($tax_amount) }}
                        </td>
                        <td width="3px" style="border: 0 !important;"></td>
                        <td class="text-right" style="border-left: 0 !important; border-right: 0 !important;">
                            {{ numberFormatDisplay($amount) }}
                        </td>
                        <td style="border: 0 !important;"></td>
                        <td style="border: 0 !important;"></td>
                        <td style="border: 0 !important;"></td>
                    </tr>
                </tbody>
            </table>

            @php
                $requester = optional($document)->requester;
            @endphp
            <div class="row" style="width:80%; margin-top: 10px; justify-content: flex-end;">
                <div class="text-center" style="margin-top: 25px;">
                    <div>
                        ผู้ขอเบิก ______________________
                    </div>
                    <div style="margin-top: 3px;">
                        {{ $requester ? optional($requester)->name : '______________________________' }}
                    </div>
                    <div style="margin-top: 3px;">
                        {{ optional($requester)->PersonalDeptLocation ? optional(optional($requester)->PersonalDeptLocation)->pos_name : '______________________________' }}
                    </div>
                    <div style="margin-top: 3px;">
                        วันที่ {!! $requester ? dateFormatDisplay($document->request_date) : '______/______/______' !!}
                    </div>
                </div>
                <div class="text-center" style="margin-top: 25px;">
                    <div>
                        ผู้ตรวจสอบ / ผู้อนุมัติ ______________________
                    </div>
                    <div style="margin-top: 20px;">
                        &nbsp;
                    </div>
                    <div style="margin-top: 3px;">
                        วันที่  ______/______/______
                    </div>
                </div>
            </div>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach
    </body>
</html>