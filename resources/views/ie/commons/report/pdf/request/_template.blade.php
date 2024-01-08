<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ie.commons.report.pdf.request._style')
    </head>
    <body>
        @php
            $count = 0;
        @endphp
        @foreach ($data as $groupData)
            @php
                $currentLine = 0;
            @endphp
            <div style="width: 100%">
                <div class="inline-block align-top" style="width:26%; padding:0; margin:0;">
                    <div>
                        Print By : {{ auth()->user()->name }}
                    </div>
                </div>
                <div class="text-center inline-block" style="width:46%; padding:0; margin:0;">
                    <h2 style="margin: 0.6rem;">
                        <div style="margin-bottom: 3px;">
                            การยาสูบแห่งประเทศไทย
                        </div>
                        <div>
                            @if ($requestType == 'CASH-ADVANCE')
                                ใบยืมเงินทดรอง
                            @elseif ($requestType == 'CLEARING')
                                ใบเคลียร์เงินยืมทดรอง
                            @else
                                ใบเบิกเงินสำรองจ่าย / PR - TO AP
                            @endif
                        </div>
                    </h2>
                </div>
                <div class="text-right inline-block align-top" style="width:26%; padding:0; margin:0; font-size: 16px;">
                    <div>
                        Report Date : {{ strtoupper(date('d-M-Y H:i:s')) }}
                    </div>
                    <div>
                        Page {{$loop->iteration}} / {{$loop->count}}
                    </div>
                </div>
            </div>
            <table width="100%"  style="margin: 0px">
                <thead>
                    <tr>
                        <td colspan="100">
                            <div>
                                @if ( in_array($requestType, ['CASH-ADVANCE', 'CLEARING']) )
                                    <div class="inline-block" style="width: 59%">
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                สถานที่ปฏิบัติการ
                                            </div>
                                            <div class="inline-block" style="width: 2px">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                {{ optional($parent->operatingUnit)->name }}
                                            </div>
                                        </div>
                                        @if ( in_array($requestType, ['CASH-ADVANCE', 'CLEARING']) )
                                            <div>
                                                <div class="inline-block" style="width: 24.5%">
                                                    วันที่ยืมเงิน
                                                </div>
                                                <div class="inline-block" style="width: 2px;">
                                                    :
                                                </div>
                                                <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                    {{ dateFormatDisplay(optional($parent)->request_date) }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ( in_array($requestType, ['CLEARING']) )
                                            <div>
                                                <div class="inline-block" style="width: 24.5%">
                                                    วันที่เคลียร์
                                                </div>
                                                <div class="inline-block" style="width: 2px;">
                                                    :
                                                </div>
                                                <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                    {{ dateFormatDisplay(optional($parent)->clearing_gl_date) }}
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                รหัสพนักงานผู้ยืมเงิน
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                {{ optional($parent)->requester_id }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                ตำแหน่ง
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%">
                                                {{ optional($parent)->position_name }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                หน่วยงาน
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                {{ optional($parent)->department_code ? optional(optional($parent)->department)->description : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inline-block" style="width: 40%">
                                        @if ( in_array($requestType, ['CASH-ADVANCE', 'CLEARING']) )
                                            <div>
                                                <div class="inline-block" style="width: 30%">
                                                    เลขที่ใบยืมเงิน
                                                </div>
                                                <div class="inline-block" style="width: 2px;">
                                                    :
                                                </div>
                                                <div class="inline-block word-wrap overflow-hidden" style="width: 64%">
                                                    {{ optional($parent)->document_no }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ( in_array($requestType, ['CLEARING']) )
                                            <div>
                                                <div class="inline-block" style="width: 30%">
                                                    เลขที่ใบเคลียร์
                                                </div>
                                                <div class="inline-block" style="width: 2px;">
                                                    :
                                                </div>
                                                <div class="inline-block word-wrap overflow-hidden" style="width: 64%">
                                                    {{ optional($parent)->clearing_document_no }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ( in_array($requestType, ['CASH-ADVANCE']) )
                                            <div>
                                                <div class="inline-block" style="width: 30%">
                                                    เลขที่ใบแจ้งหนี้
                                                </div>
                                                <div class="inline-block" style="width: 2px;">
                                                    :
                                                </div>
                                                <div class="inline-block word-wrap overflow-hidden" style="width: 64%;">
                                                    {{ optional($parent)->invoice_no }}
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="inline-block" style="width: 30%">
                                                พนักงานผู้ยืมเงิน
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 64%">
                                                {{ optional($parent->user)->name }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="inline-block" style="width: 30%">
                                                โทร
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 64%">
                                                {{ $parent->tel ?? (optional(optional(optional(optional($parent)->requester)->user)->personalDeptLocation)->office_tel ?? '-') }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="inline-block" style="width: 59%">
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                สถานที่ปฏิบัติการ
                                            </div>
                                            <div class="inline-block" style="width: 2px">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                {{ optional($parent->operatingUnit)->name }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                วันที่เบิก
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                {{ dateFormatDisplay(optional($parent)->request_date) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                รหัสพนักงานผู้ขอเบิก
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                {{ optional($parent)->requester_id }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                ตำแหน่ง
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%">
                                                {{ optional($parent)->position_name }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                หน่วยงาน
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%;">
                                                {{ optional($parent)->department_code ? optional($parent)->department_code .' : '.optional(optional($parent)->department)->description : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inline-block" style="width: 40%">
                                        <div>
                                            <div class="inline-block" style="width: 30%">
                                                เลขที่ใบเบิก
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 64%">
                                                {{ optional($parent)->document_no }}
                                            </div>
                                        </div>
                                        @if ( !!optional($parent)->invoice_no && in_array($requestType, ['REIMBURSEMENT']) )
                                            <div>
                                                <div class="inline-block" style="width: 30%">
                                                    เลขที่ใบแจ้งหนี้
                                                </div>
                                                <div class="inline-block" style="width: 2px;">
                                                    :
                                                </div>
                                                <div class="inline-block word-wrap overflow-hidden" style="width: 64%;">
                                                    {{ optional($parent)->invoice_no }}
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="inline-block" style="width: 30%">
                                                พนักงานผู้ขอเบิก
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 64%">
                                                {{ optional($parent->user)->name }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="inline-block" style="width: 30%">
                                                โทร
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 64%">
                                                {{ $parent->tel ?? (optional(optional(optional(optional($parent)->requester)->user)->personalDeptLocation)->office_tel ?? '-') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div>
                                @if ( in_array($requestType, ['CASH-ADVANCE', 'CLEARING']) )
                                    <div class="inline-block" style="width: 99%">
                                        <div>
                                            <div class="inline-block" style="width: 14.6%">
                                                สังกัด
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 81.7%">
                                                {{ optional(optional($parent)->supplierSite)->vendor_site_code ?? 'None' }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="inline-block" style="width: 59%">
                                        <div>
                                            <div class="inline-block" style="width: 24.5%">
                                                ผู้ขาย
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 72%">
                                                {{ optional($parent)->supplierSite ? optional($parent)->supplierSite->vendor_no .' : '. optional($parent)->supplierSite->vendor_name : 'None' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inline-block" style="width: 40%">
                                        <div>
                                            <div class="inline-block" style="width: 30%">
                                                ที่อยู่ผู้ขาย
                                            </div>
                                            <div class="inline-block" style="width: 2px;">
                                                :
                                            </div>
                                            <div class="inline-block word-wrap overflow-hidden" style="width: 64%">
                                                {{ optional(optional($parent)->supplierSite)->vendor_site_code ?? 'None' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="inline-block" style="width: 99%">
                                    <div>
                                        <div class="inline-block" style="width: 14.7%">
                                            วัตถุประสงค์
                                        </div>
                                        <div class="inline-block" style="width: 2px;">
                                            :
                                        </div>
                                        <div class="inline-block word-wrap" style="width: 83.4%">
                                            {{ in_array($requestType, ['CASH-ADVANCE']) ? optional($parent)->reason : optional($parent)->purpose }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="inline-block" style="width: 14.7%">
                                            จ่ายให้
                                        </div>
                                        <div class="inline-block" style="width: 2px;">
                                            :
                                        </div>
                                        <div class="inline-block word-wrap" style="width: 83.4%">
                                            {{ 
                                                $parent->pay_to_emp == 'YES' 
                                                ? optional($parent->user)->username.' : '.optional($parent->user)->name.' '.$parent->bank_name.' '.$parent->account_no
                                                : optional($parent->supplierSite)->vendor_no.' : '.optional($parent->supplierSite)->vendor_name.' '.$parent->vendor_bank_name.' '.$parent->vendor_bank_account_no
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th width="6%">
                            ลำดับ
                        </th>
                        <th>
                            รายการ
                        </th>
                        @if( !in_array($requestType, ['CASH-ADVANCE']) )
                            <th width="9.5%">
                                VAT
                            </th>
                            <th width="9.5%">
                                WHT
                            </th>
                        @endif
                        <th width="17%">
                            จำนวนเงิน {{ optional($parent)->currency_id != 'THB' ? '('.optional($parent)->currency_id.')' : '' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupData as $groupAccountBudget => $lines)
                        <tr>
                            <td class="text-center"></td>
                            <td>
                                หน่วยงานเจ้าของงบ : {{ $groupAccountBudget }}
                            </td>
                            @if( !in_array($requestType, ['CASH-ADVANCE']) )
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            @endif
                            <td class="text-right"></td>
                        </tr>
                        @php
                            $currentLine++;
                        @endphp
                        @foreach ($lines as $key => $line)
                            <tr>
                                <td class="text-center">
                                    {{ $count+1 }}
                                </td>
                                <td>
                                    {!! ($line->description ? $line->description : optional($line->subCategory)->name). '<br>' . $line->concatenated_segments !!}
                                </td>
                                @if( !in_array($requestType, ['CASH-ADVANCE']) )
                                    <td class="text-center">
                                        {!! $line->vat_id !!}
                                    </td>
                                    <td class="text-center">
                                        {!! $line->wht ? $line->wht->wht_name : '' !!}
                                    </td>
                                @endif
                                <td class="text-right">
                                    {{ numberFormatDisplay($line->total_amount) }}
                                </td>
                            </tr>
                            @php
                                if(mb_strlen($line->description) > 100){
                                    $currentLine = $currentLine+2;
                                }else{
                                    $currentLine++;
                                }
                                $count++;
                            @endphp
                        @endforeach
                    @endforeach
                    @for ($line = $currentLine; $line < $maxLine; $line++)
                        <tr>
                            <td class="text-center">
                            </td>
                            <td style="padding-left: 3rem;">
                            </td>
                            @if( !in_array($requestType, ['CASH-ADVANCE']) )
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            @endif
                            <td class="text-right"></td>
                        </tr>
                    @endfor
                    @if ($loop->last)
                        @if( !in_array($requestType, ['CASH-ADVANCE']) )
                            <tr>
                                <td colspan="4" class="text-right">
                                    Total Amount before VAT / ยอดเงินก่อนภาษี
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay( $requestType == 'CASH-ADVANCE' ? $parent->ca_total_receipt_amount_before_tax : $parent->total_receipt_amount_before_tax) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">
                                    VAT / ภาษีมูลค่าเพิ่ม 
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay( $requestType == 'CASH-ADVANCE' ? 0 : $parent->total_receipt_tax) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">
                                    Total Amount Inc. VAT / ยอดเงินรวมภาษี 
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay( $requestType == 'CASH-ADVANCE' ? $parent->ca_total_receipt_amount_inc_tax : $parent->total_receipt_amount_inc_tax) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">
                                    WHT Amount / ภาษีหัก ณ ที่จ่าย 
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay( $requestType == 'CASH-ADVANCE' ? $parent->ca_total_receipt_wht : $parent->total_receipt_wht) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">
                                    Total Amount / ยอดเงินรวมสุทธิ 
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay( $requestType == 'CASH-ADVANCE' ? $parent->ca_total_receipt_amount : $parent->total_receipt_amount) }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td></td>
                                <td class="text-center">
                                    {{ convertToReadNumber($parent->ca_total_receipt_amount, $parent->currency_id) }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatDisplay($parent->ca_total_receipt_amount) }}
                                </td>
                            </tr>
                        @endif
                    @endif
                </tbody>
                @if ($loop->last)
                    <tfoot>
                        {{-- <tr>
                            <td colspan="100">
                                <div>
                                    <div class="row">
                                        <div>
                                            {{ $parent->pay_to_emp == 'YES' 
                                                ? 'PAY TO EMPLOYEE : '.optional($parent->user)->username.' : '.optional($parent->user)->name.' '.$parent->bank_name.' '.$parent->account_no
                                                : 'PAY TO VENDOR : '.optional($parent->supplierSite)->vendor_no.' : '.optional($parent->supplierSite)->vendor_name.' '.$parent->vendor_bank_name.' '.$parent->vendor_bank_account_no
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr> --}}
                        @if ( in_array($requestType, ['CASH-ADVANCE']) )
                            <tr>
                                <td colspan="100">
                                    <div>
                                        <div style="margin-bottom: 3px;">
                                            &emsp; &emsp; &emsp; ข้าพเจ้ามีหนี้เงินยืมทดรองที่ครบกำหนดแล้ว แต่ได้รับอนุมัติขยายเวลาตามข้อ 24 (2)
                                        </div>
                                        <div class="row">
                                            <div>
                                                <div>
                                                    ใบยืมเงินทดรองที่ยังไม่ได้เคลียร์ : {{ count($pendingRequestLists) }} ใบ
                                                </div>
                                            </div>
                                            <div>
                                                จำนวนเงิน : {{ numberFormatDisplay(array_sum(array_column($pendingRequestLists, 'amount'))) }} บาท
                                            </div>
                                        </div>
                                        <div>
                                            @foreach($pendingRequestLists as $i => $pendingRequest)
                                                @if ($i % 2 == 0)
                                                    <div class="row">
                                                @endif
                                                    <div>- {{ $pendingRequest['document_no'] }} ตามบันทึก : {{ $pendingRequest['record_number'] }}</div>
                                                @if ($i % 2 == 1)
                                                    </div>
                                                @endif
                                            @endforeach
                                            
                                        </div>
                                        <div style="margin-bottom: 3px;">
                                            &emsp; &emsp; &emsp; หากข้าพเจ้ามีหนี้เงินยืมทดรองที่ครบกำหนด แต่ยังมิได้ส่งคืนให้ครบถ้วนถูกต้องตามระเบียบข้อ 24 แล้วนั้น
                                        </div>
                                        <div>
                                            ข้าพเจ้ายอมให้หักเงินส่วนที่ยังคงค้างอยู่จากเงินเดือน ค่าจ้างหรือเงินได้อื่นของข้าพเจ้าจนครบถ้วน
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="100">
                                <div>
                                    <div class="row">
                                        <div class="text-center">
                                            @php
                                                $groupsApproval = $approvals->where('process_type', $requestType)
                                                ->sortBy('hierarchy_level')
                                                ->groupBy('hierarchy_position_name');
                                                $activityType = $requestType == 'CLEARING' ? 'CLEARING_CREATE_REQUEST' : 'NEW_REQUEST';
                                                $log = $activityLogs->where('activity', $activityType)->first();
                                                $requester = optional($parent)->requester;
                                            @endphp
                                            <div>
                                                Requester / พนักงานผู้{{$requestType == 'REIMBURSEMENT' ? 'ขอเบิก' : 'ยืม'}}
                                            </div>
                                            <div>
                                                {!! $log ? optional(optional($parent)->user)->name : '' !!}
                                            </div>
                                            <div>
                                                {{ optional($requester)->PersonalDeptLocation ? optional(optional($requester)->PersonalDeptLocation)->pos_name : ($log ? '__________________________' : '') }}
                                            </div>
                                            <div>
                                                {!! $log ? dateFormatDisplay(optional($log)->creation_date) : '' !!}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            @php
                                                $log = null;
                                                if($groupsApproval->count() > 0){
                                                    $log = $groupsApproval->first()->last();
                                                }
                                                $checked_user = optional($log)->user;
                                            @endphp
                                            <div>
                                                Checked / ผู้ตรวจสอบ
                                            </div>
                                            <div>
                                                {!! $log ? optional(optional($log)->user)->name : '' !!}
                                            </div>
                                            <div>
                                                {{ optional($checked_user)->PersonalDeptLocation ? optional(optional($checked_user)->PersonalDeptLocation)->pos_name : ($log ? '__________________________' : '') }}
                                            </div>
                                            <div>
                                                {!! $log ? dateFormatDisplay(optional($log)->creation_date) : '' !!}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            @php
                                                $log = null;
                                                if($groupsApproval->count() > 1){
                                                    $keys = $groupsApproval->keys();
                                                    $log = $groupsApproval[$keys[1]]->last();
                                                }
                                                $approver_user = optional($log)->user;
                                            @endphp
                                            <div>
                                                Approver / ผู้อนุมัติ
                                            </div>
                                            <div>
                                                {!! $log ? optional(optional($log)->user)->name : '' !!}
                                            </div>
                                            <div>
                                                {{ optional($approver_user)->PersonalDeptLocation ? optional(optional($approver_user)->PersonalDeptLocation)->pos_name : ($log ? '__________________________' : '') }}
                                            </div>
                                            <div>
                                                {!! $log ? dateFormatDisplay(optional($log)->creation_date) : '' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @if ( in_array($requestType, ['CASH-ADVANCE']) )
                            <tr>
                                <td colspan="100">
                                    <div>
                                        <div class="row">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div style="flex-basis: 0 !important;">
                                                <div style="padding-top: 15px;">
                                                    ได้รับเงินแล้ว
                                                </div>
                                                <div class="text-center" style="padding-top: 5px;">
                                                    {!! optional(optional($parent)->user)->name !!} ผู้ยืม
                                                </div>
                                                <div style="padding-top: 5px;">
                                                    วันที่ ...................................... เวลา ......................... น.
                                                </div>
                                                <div class="text-center" style="padding-top: 5px; padding-bottom: 15px;">
                                                    ............................................ เจ้าหน้าที่การเงิน
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tfoot>
                @endif
            </table>
            @if ( in_array($requestType, ['CASH-ADVANCE']) )
                <div>
                    หมายเหตุ
                </div>
                <div>
                    &emsp; การยืมเงินทดรองครั้งใหม่โดยยังมิได้ส่งคืนเงินทดรองครั้งก่อนให้ยืมได้รวมแล้วต้องไม่เกิน 3 ครั้ง
                </div>
            @endif

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach

    </body>
</html