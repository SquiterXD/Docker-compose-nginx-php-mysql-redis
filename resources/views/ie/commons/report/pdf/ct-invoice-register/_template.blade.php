<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ie.commons.report.pdf.ct-invoice-register._style')
    </head>
    <body>
        @php
            $now = date('Y-m-d');
        @endphp
        @foreach ($data as $document)
            <div style="width: 100%; margin-bottom: 5px">
                <div class="inline-block align-top" style="width:26%; padding:0; margin:0;">
                    การยาสูบแห่งประเทศไทย
                </div>
                <div class="text-center inline-block" style="vertical-align: bottom; width:46%; padding:40 0 0 0; margin:0;">
                    Invoice Register
                </div>
                <div class="text-right inline-block" style="width:26%;">
                    Report Date : {{ strtoupper(date('d-M-Y h:i:s')) }}<br>
                    Page {{$loop->iteration}} / {{$loop->count}}
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
                        <td class="text-center">
                            Supplier Name
                        </td>
                        <td class="text-center" width="70px">
                            Invoice Type
                        </td>
                        <td class="text-center" width="85px">
                            Invoice Number
                        </td>
                        <td class="text-center" width="80px">
                            Invoice Date
                        </td>
                        <td class="text-center" width="80px">
                            GL Date
                        </td>
                        <td class="text-center" width="102px">
                            Original Amount
                        </td>
                        <td class="text-center" width="102px">
                            Amount Remaining
                        </td>
                        <td class="text-center" width="237px">
                            Description
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="page-break-inside:avoid;">
                        @php
                            $amount = in_array($document_type, ['CASH-ADVANCE']) ? $document->amount : $document->total_receipt_amount;
                            $interface = $document->interfaces->where('request_from', $document_type)->first();
                            $remain = optional($interface)->statusPaid ? $interface->statusPaid->amount_remaining : $amount;
                            $arrVat = [];
                            $line_num = 0;
                        @endphp
                        <td class="text-center">
                            {{-- Supplier Name --}}
                            {{ optional($document->supplierSite)->vendor_name }}
                        </td>
                        <td class="text-center">
                            {{-- Invoice Type --}}
                            {{ in_array($document_type, ['CASH-ADVANCE']) ? 'PREPAYMENT' : 'STANDARD' }}
                        </td>
                        <td class="text-center">
                            {{-- Invoice Number --}}
                            {{ in_array($document_type, ['CLEARING']) ? $document->clearing_invoice_no : $document->invoice_no }}
                        </td>
                        <td class="text-center">
                            {{-- Invoice Date --}}
                            {{ dateFormatDisplay($interface ? $interface->invoice_date : (in_array($document_type, ['CLEARING']) ? $document->clearing_request_date : $document->request_date)) }}
                        </td>
                        <td class="text-center">
                            {{-- GL Date --}}
                            {{ dateFormatDisplay($interface ? $interface->gl_date : (in_array($document_type, ['CLEARING']) ? $document->clearing_gl_date : $document->gl_date)) }}
                        </td>
                        <td class="text-right">
                            {{-- Original Amount --}}
                            {{ numberFormatDisplay($amount) }}
                        </td>
                        <td class="text-right">
                            {{-- Amount Remaining --}}
                            {{ numberFormatDisplay($remain) }}
                        </td>
                        <td>
                            {{-- Description --}}
                            {{ in_array($document_type, ['CASH-ADVANCE']) ? $document->reason : $document->purpose }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div style="height: 2px;"></div>

            <div>
                @php
                    $vendor = $document->supplierSite;
                    $concatenated_segments = optional($vendor)->concatenated_segments;
                    $mainAccount = optional(optional($vendor)->mainAccount)->description;
                    $subAccount = optional(optional($vendor)->subAccount)->description;
                @endphp
                Liability Accounting Flex : {{ $concatenated_segments }} {{ $subAccount ? ($mainAccount ? '( '.$mainAccount.' - '.$subAccount.' )' : '( '.$subAccount.' )') : '' }}
            </div>

            <div style="height: 15px;"></div>

            <table class="table">
                <thead>
                    <tr style="page-break-inside:avoid;">
                        <td class="text-center" width="30px">
                            Type
                        </td>
                        <td class="text-center" width="30px">
                            Line
                        </td>
                        <td class="text-center" width="385px">
                            Expense Accounting Flex
                        </td>
                        <td class="text-center">
                            Amount
                        </td>
                        <td class="text-center" colspan="3">
                            Description
                        </td>
                        <td class="text-center" width="80px">
                            Vat
                        </td>
                        <td class="text-center" width="80px">
                            WHT Code
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @if ( !in_array($document_type, ['CASH-ADVANCE']) )
                        @foreach ($document->receipts()->processType($document_type)->get() as $receipt)
                            @foreach ($receipt->lines as $line)
                                @php
                                    if($line->vat_id){
                                        if(!array_key_exists($line->vat_id, $arrVat)){
                                            $arrVat[$line->vat_id]['vat_id'] = $line->vat_id;
                                            $arrVat[$line->vat_id]['vat_amount'] = (float)$line->vat_amount;
                                        }else{ // IF ALREADY HAVE THIS TAX (VAT ID) => SUM FOR TOTAL
                                            $arrVat[$line->vat_id]['vat_amount'] += (float)$line->vat_amount;
                                        }
                                    }
                                    $line_amount = (float)$line->total_amount_inc_vat - (float)$line->vat_amount;
                                @endphp
                                <tr style="page-break-inside:avoid;">
                                    <td class="text-center">
                                        {{-- Type --}}
                                        ITEM
                                    </td>
                                    <td class="text-center">
                                        {{-- Line --}}
                                        {{ $line_num+1 }}
                                    </td>
                                    <td>
                                        {{-- Expense --}}
                                        {{ $line->concatenated_segments }}
                                    </td>
                                    <td class="text-right">
                                        {{-- Amount --}}
                                        {{ numberFormatDisplay($line_amount) }}
                                    </td>
                                    <td colspan="3">
                                        {{-- Description --}}
                                        {{ $line->description }}
                                    </td>
                                    <td class="text-center">
                                        {{-- Vat --}}
                                        @php
                                            $taxVAT = \App\Models\IE\VAT::where('tax_rate_code', $line->vat_id)->whereOrgId($document->org_id)->first();
                                        @endphp
                                        {{ optional($taxVAT)->tax_rate_code }}
                                    </td>
                                    <td class="text-center">
                                        {{-- WHT Code --}}
                                        {{ optional($line->wht)->wht_name }}
                                    </td>
                                </tr>
                                @php
                                    $line_num++;
                                @endphp
                            @endforeach
                        @endforeach

                        @foreach ($arrVat as $vatId => $vat)
                            @php
                                $taxVAT = \App\Models\IE\VAT::where('tax_rate_code', $vatId)->whereOrgId($document->org_id)->first();
                            @endphp
                            <tr style="page-break-inside:avoid;">
                                <td class="text-center">
                                    {{-- Type --}}
                                    TAX
                                </td>
                                <td class="text-center">
                                    {{-- Line --}}
                                    {{ $line_num+1 }}
                                </td>
                                <td>
                                    {{-- Expense --}}
                                    {{ optional($taxVAT)->tax_account }}
                                </td>
                                <td class="text-right">
                                    {{-- Amount --}}
                                    {{ numberFormatDisplay( (float)$vat['vat_amount'] ) }}
                                </td>
                                <td colspan="3">
                                    {{-- Description --}}
                                    ภาษีมูลค่าเพิ่ม
                                </td>
                                <td class="text-center">
                                    {{-- Vat --}}
                                    {{ optional($taxVAT)->tax_rate_code }}
                                </td>
                                <td class="text-center">
                                    {{-- WHT Code --}}
                                </td>
                            </tr>
                            @php
                                $line_num++;
                            @endphp
                        @endforeach
                    @else
                        @php
                            $line_amount = $document->amount;
                            $vendor = $document->supplierSite;
                            $glCodeCombination = \App\Repositories\IE\InterfaceRepo::getGLCodeCombinationOfVendorBySegments($vendor);
                            $description = $document->reason;
                        @endphp
                        <tr style="page-break-inside:avoid;">
                            <td class="text-center">
                                {{-- Type --}}
                                ITEM
                            </td>
                            <td class="text-center">
                                {{-- Line --}}
                                {{ $line_num+1 }}
                            </td>
                            <td>
                                {{-- Expense --}}
                                {{ $glCodeCombination['concatenated_segments'] }}
                            </td>
                            <td class="text-right">
                                {{-- Amount --}}
                                {{ numberFormatDisplay($line_amount) }}
                            </td>
                            <td colspan="3">
                                {{-- Description --}}
                                {{ $description }}
                            </td>
                            <td class="text-center">
                                {{-- Vat --}}
                            </td>
                            <td class="text-center">
                                {{-- WHT Code --}}
                            </td>
                        </tr>
                    @endif
                    <tr style="page-break-inside:avoid; border: 0 !important;">
                        <td style="border: 0 !important;"></td>
                        <td style="border: 0 !important;"></td>
                        <td style="border: 0 !important;">
                            Total for {{ in_array($document_type, ['CLEARING']) ? $document->clearing_invoice_no : $document->invoice_no }} :
                        </td>
                        <td class="text-right" width="92px" style="border-left: 0 !important; border-right: 0 !important;">
                            {{ numberFormatDisplay($amount) }}
                        </td>
                        <td width="3px" style="border: 0 !important;"></td>
                        <td class="text-right" width="92px" style="border-left: 0 !important; border-right: 0 !important;">
                            {{ numberFormatDisplay($remain) }}
                        </td>
                        <td style="border: 0 !important;"></td>
                        <td style="border: 0 !important;"></td>
                        <td style="border: 0 !important;"></td>
                    </tr>
                </tbody>
            </table>
            {{-- <div  style="margin-top: 10px">
                <div class="inline-block" style="width: 280px">
                    Total for {{ in_array($document_type, ['CLEARING']) ? $document->clearing_invoice_no : $document->invoice_no }} :
                </div>
                <div class="inline-block text-right" style="width: 130px">
                    {{ numberFormatDisplay($amount) }}
                </div>
                <div class="inline-block text-right" style="width: 130px">
                    {{ numberFormatDisplay($remain) }}
                </div>
            </div> --}}
            
            @php
                $preparer = optional($document)->preparer;
                $checkedBy = optional($document)->checkedBy;
            @endphp
            <table class="table" style="margin-top: 30px;">
                <tr style="border: 0 !important; page-break-inside:avoid;">
                    <td style="border: 0 !important;">
                    </td>
                    <td class="text-right" width="50px" style="border: 0 !important;">
                        ผู้จัดทำ
                    </td>
                    <td class="text-center" width="185px" style="border-top: 0 !important; border-left: 0 !important; border-right: 0 !important;">
                        {{ $preparer ? $preparer->name : '' }}
                    </td>
                    <td width="80px" style="border: 0 !important;">
                    </td>
                    <td class="text-right" width="180px" style="border: 0 !important;">
                        {{-- ผู้ตรวจสอบ / ผู้อนุมัติ --}}
                        ผู้ตรวจสอบ
                    </td>
                    <td class="text-center" width="185px" style="border-top: 0 !important; border-left: 0 !important; border-right: 0 !important;">
                        {{ $checkedBy ? $checkedBy->name : '' }}
                    </td>
                    <td style="border: 0 !important;">
                    </td>
                </tr>
                <tr style="border: 0 !important; page-break-inside:avoid;">
                    <td style="border: 0 !important;">
                    </td>
                    <td class="text-right" width="50px" style="border: 0 !important;">
                        ตำแหน่ง
                    </td>
                    <td class="text-center" width="185px" style="border-top: 0 !important; border-left: 0 !important; border-right: 0 !important;">
                        {{ optional($preparer)->personalDeptLocation ? optional(optional($preparer)->PersonalDeptLocation)->pos_name : '' }}
                    </td>
                    <td width="185px" style="border: 0 !important;">
                    </td>
                    <td class="text-right" width="50px" style="border: 0 !important;">
                        ตำแหน่ง
                    </td>
                    <td class="text-center" width="185px" style="border-top: 0 !important; border-left: 0 !important; border-right: 0 !important;">
                        {{ optional($checkedBy)->personalDeptLocation ? optional(optional($checkedBy)->PersonalDeptLocation)->pos_name : '' }}
                    </td>
                    <td style="border: 0 !important;">
                    </td>
                </tr>
                <tr style="border: 0 !important; page-break-inside:avoid;">
                    <td style="border: 0 !important;">
                    </td>
                    <td class="text-right" width="50px" style="border: 0 !important;">
                        วันที่
                    </td>
                    <td class="text-center" width="185px" style="border-top: 0 !important; border-left: 0 !important; border-right: 0 !important;">
                        @if (optional($document)->request_date)
                            {{ dateFormatDisplay(in_array($document_type, ['CLEARING']) ? $document->clearing_request_date : $document->request_date) }}
                        @else
                            /<span style='display: inline-block; width: 50px;'></span>/
                        @endif
                    </td>
                    <td width="185px" style="border: 0 !important;">
                    </td>
                    <td class="text-right" width="50px" style="border: 0 !important;">
                        วันที่
                    </td>
                    <td class="text-center" width="185px" style="border-top: 0 !important; border-left: 0 !important; border-right: 0 !important;">
                        @if (optional($document)->request_date && $checkedBy)
                            {{ dateFormatDisplay(in_array($document_type, ['CLEARING']) ? $document->clearing_request_date : $document->request_date) }}
                        @else
                            /<span style='display: inline-block; width: 50px;'></span>/
                        @endif
                    </td>
                    <td style="border: 0 !important;">
                    </td>
                </tr>
            </table>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach
    </body>
</html>