<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ie.commons.report.pdf.ct-budget._style')
    </head>
    <body>

        @php
            $report_date = strtoupper(date('d-M-Y'));
            $report_time = strtoupper(date('H:i:s'));
        @endphp
        @foreach ($data as $page => $array)
            @php
                $total = 0;
            @endphp
            <div style="width: 100%; margin-bottom: 5px">
                <div class="inline-block align-top" style="width:26%; padding:0; margin:0;">
                    การยาสูบแห่งประเทศไทย
                </div>
                <div class="text-center inline-block" style="vertical-align: bottom; width:46%; padding:40 0 0 0; margin:0;">
                    ใบขออนุมัติหลักการใช้งบประมาณ
                </div>
                <div class="text-right inline-block" style="width:26%;">
                    พิมพ์วันที่ : {{ $report_date }} เวลา {{ $report_time }} <br>
                    หน้า {{$loop->iteration}} / {{$loop->count}}
                </div>
            </div>
            <div style="padding-bottom: 5px">
                <div>
                    หน่วยงานที่ขอใช้ ชื่อฝ่าย/สำนัก : {{ $array['document']->department_code .' : '. optional($array['document']->department)->description  }}
                </div>
                <div>
                    เรื่อง : {{ $array['document']->purpose }}
                </div>
                <div>
                    เหตุผลและความจำเป็น : {{ $array['document']->reason }}
                </div>
                <div>
                    ประเภทเอกสาร : {{ in_array( $docType, ['REIMBURSEMENT']) ? 'ใบเบิกเงินสำรองจ่าย / PR - TO AP' : ( in_array( $docType, ['CASH-ADVANCE']) ? 'ใบยืมเงินทดรอง' : 'ใบเคลียร์ยืมเงินทดรอง' )  }}
                </div>
                <div class="row">
                    <div>
                        เลขที่เอกสาร : {{ in_array( $docType, ['CLEARING']) ? $array['document']->clearing_document_no : $array['document']->document_no }}
                    </div>
                    @if ( in_array( $docType, ['CASH-ADVANCE', 'CLEARING']) )
                        <div class="text-right">
                            วันที่ต้องการรับเงิน : {{ dateFormatDisplay($array['document']->need_by_date) }}
                        </div>
                    @endif
                </div>
            </div>
            @if (count($array['lines']))
                <table width="100%">
                    <thead>
                        <tr>
                            {{-- <td class="text-center">
                                Tax Invoice / Receipt
                            </td> --}}
                            <td width="{{ count($array['accounts']) ? '5%' : '35px' }}" class="text-center">
                                ลำดับ
                            </td>
                            <td class="text-center">
                                รายการ
                            </td>
                            <td width="{{ count($array['accounts']) ? '8%' : '60px' }}" class="text-center">
                                จำนวน
                            </td>
                            <td width="10%" class="text-center">
                                ยอดเงินไม่รวมภาษี
                            </td>
                            {{-- <td class="text-center">
                                ภาษีมูลค่าเพิ่ม
                            </td>
                            <td class="text-center">
                                ยอดเงินรวมภาษี
                            </td> --}}
                            <td width="{{ count($array['accounts']) ? '10%' : '90px' }}" class="text-center">
                                อัตราแลกเปลี่ยน
                            </td>
                            <td width="{{ count($array['accounts']) ? '10%' : '90px' }}" class="text-center">
                                จำนวนเงิน (บาท)
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($array['lines'] as $index => $line)
                            <tr>
                                {{-- <td class="text-center">
                                    {{ $loop->first ? (optional($line->header)->receipt_number ?? '-') : '' }}
                                </td> --}}
                                <td class="text-center">
                                    {{-- ลำดับ --}}
                                    {{ $index+1 }}
                                </td>
                                <td>
                                    {{-- รายการ --}}
                                    {{-- {{ optional($line->subCategory)->name }}  --}}
                                    {{ $line->description }} 
                                </td>
                                <td class="text-center">
                                    {{-- จำนวน --}}
                                    {{ $line->quantity }} {{ optional($line)->uom }}
                                    @if(optional($line->subCategory)->use_second_unit)
                                        {{ $line->second_quantity ?? '-' }}
                                        <span>{{ optional($line)->second_uom }}</span>
                                    @endif
                                </td>
                                {{-- <td class="text-right">
                                    {{ $line->total_amount ? numberFormatDisplay($line->total_amount,2) : '0.00' }}
                                </td>
                                <td class="text-center">
                                    {{ $line->vat_amount ? numberFormatDisplay($line->vat_amount,2) : '0.00' }}
                                </td> --}}
                                <td class="text-right">
                                    {{-- ยอดเงินรวมภาษี --}}
                                    {{ $line->total_amount ? numberFormatDisplay($line->total_amount,2) : '0.00' }}
                                </td>
                                <td class="text-center">
                                    {{-- อัตราแลกเปลี่ยน --}}
                                    {{ $array['document']->exchange_rate }}
                                </td>
                                <td class="text-right">
                                    {{-- จำนวนเงิน (บาท) --}}
                                    @php
                                        $total += (int)$line->total_primary_amount;
                                    @endphp
                                    {{ $line->total_primary_amount ? numberFormatDisplay($line->total_primary_amount,2) : '0.00' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right" style="padding: 5px">
                    <b>ยอดเงินรวม</b> &emsp; {{ numberFormatDisplay( $docType == 'CASH-ADVANCE' ? $array['document']->ca_total_primary_amount_before_tax : $array['document']->total_primary_amount_before_tax) }}
                </div>
            @endif

            @if (count($array['accounts']))

                <table width="100%">
                    <thead>
                        <tr>
                            <td width="7%" class="text-center">
                                ปีงบประมาณ
                            </td>
                            <td width="20%" class="text-center">
                                รหัสงบประมาณ
                            </td>
                            <td class="text-center">
                                งบประมาณ
                            </td>
                            <td width="10%" class="text-center">
                                งบประมาณที่ตั้งไว้
                            </td>
                            <td width="10%" class="text-center">
                                ขออนุมัติแล้ว
                            </td>
                            <td width="10%" class="text-center">
                                จ่ายจริง
                            </td>
                            <td width="10%" class="text-center">
                                งบประมาณคงเหลือ
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($array['accounts'] as $account)
                            <tr>
                                <td class="text-center">
                                    {{-- ปีงบประมาณ --}}
                                    {{ $account['budget_year'] }}
                                </td>
                                <td class="text-center">
                                    {{-- รหัสงบประมาณ --}}
                                    {{ $account['budget_code'] }}
                                </td>
                                <td class="" style="font-size: 16px">
                                    {{-- งบประมาณ --}}
                                    {{ $account['budget_description'] }}
                                </td>
                                <td class="text-right">
                                    {{-- งบประมาณที่ตั้งไว้ --}}
                                    {{ numberFormatDisplay($account['budget_amount']) }}
                                </td>
                                <td class="text-right">
                                    {{-- ขออนุมัติแล้ว --}}
                                    {{ numberFormatDisplay($account['encumbrance_amount']) }}
                                </td>
                                <td class="text-right">
                                    {{-- จ่ายจริง --}}
                                    {{ numberFormatDisplay($account['actual_amount']) }}
                                </td>
                                <td class="text-right">
                                    {{-- งบประมาณคงเหลือ --}}
                                    {{ numberFormatDisplay($account['fund_available']) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <div class="row" style="margin-left: auto; width:70%; margin-top: 10px; justify-content: flex-end;"> --}}
                <div class="row" style="width:70%; margin-top: 5px; justify-content: flex-end; page-break-inside:avoid;">
                    <div class="text-center" style="margin-top: 25px;">
                        @php
                            $requestLog = $array['document']->activityLogs()->where('activity', 'NEW_REQUEST')->first();
                            $requestUser = optional($array['document']->requester)->user;
                            $lastApproval = $array['document']->approvals()->where('process_type', $docType)->where('last_approval', true)->first();
                        @endphp
                        <div>
                            ผู้ขอใช้งบประมาณ __________________
                        </div>
                        <div style="margin-top: 3px;">
                            {{ $requestUser ? optional($requestUser)->name : '__________________________' }}
                        </div>
                        <div style="margin-top: 3px;">
                            {{ optional($requestUser)->PersonalDeptLocation ? optional(optional($requestUser)->PersonalDeptLocation)->pos_name : '__________________________' }}
                        </div>
                        <div style="margin-top: 3px;">
                            วันที่ {!! $requestLog ? dateFormatDisplay($array['document']->request_date) : '______/______/______' !!}
                        </div>
                    </div>
                    <div class="text-center" style="margin-top: 25px;">
                        @php
                            $log = null;
                            // $log = $array['document']->approvals()->where('process_type', $docType)->where('hierarchy_level', 1)->first();
                            $userLog = $array['document']->checkedBy;
                            // if(optional($lastApproval)->approval_id != optional($log)->approval_id){
                            //     $userLog = optional($log)->user;
                            // }else {
                            //     $log = null;
                            // }
                        @endphp
                        <div>
                            ผู้ตรวจสอบ __________________
                        </div>
                        <div style="margin-top: 3px;">
                            {{ $userLog ? optional($userLog)->name : '__________________________' }}
                        </div>
                        <div style="margin-top: 3px;">
                            {{ optional($userLog)->PersonalDeptLocation ? optional(optional($userLog)->PersonalDeptLocation)->pos_name : '__________________________' }}
                        </div>
                        <div style="margin-top: 3px;">
                            วันที่ {!! $log ? dateFormatDisplay(optional($log)->creation_date) : '______/______/______' !!}
                        </div>
                    </div>
                    <div class="text-center" style="margin-top: 25px;">
                        @php
                            $log = null;
                            // if( in_array( $docType, ['REIMBURSEMENT']) ){
                            //     $log = $lastApproval;
                            // }else if( in_array( $docType, ['CASH-ADVANCE', 'CLEARING']) ){
                            //     $log = $lastApproval ? $array['document']->approvals()->where('process_type', $docType)
                            //     ->where('hierarchy_level', '<', $lastApproval->hierarchy_level)->orderBy('creation_date', 'desc')->first() : null;
                            // }
                            $userLog = $array['document']->approvedBy;
                        @endphp
                        <div>
                            ผู้อนุมัติ __________________
                        </div>
                        <div style="margin-top: 3px;">
                            {{ $userLog ? optional($userLog)->name: '__________________________' }}
                        </div>
                        <div style="margin-top: 3px;">
                            {{ optional($userLog)->PersonalDeptLocation ? optional(optional($userLog)->PersonalDeptLocation)->pos_name : '__________________________' }}
                        </div>
                        <div style="margin-top: 3px;">
                            วันที่ {!! $log ? dateFormatDisplay(optional($log)->creation_date) : '______/______/______' !!}
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:40px; width: 60%; page-break-inside:avoid;">
                    <div>
                        <div>
                            ส่วนที่ 2 หน่วยงานงบประมาณ (กรณีงบประมาณที่ต้องผ่านการตรวจสอบและยืนยันจากหน่วยงานงบประมาณ)
                        </div>
                        <div>
                            ผลการตรวจสอบและยืนยันงบประมาณ <span style="padding-left: 50px;">ผ่าน</span> <span style="padding-left: 50px;">ไม่ผ่าน</span>
                        </div>
                        <div class="row">
                            <div>
                                ความเห็น ____________________________________
                            </div>
                            <div style="margin-top: 20px;">
                                <div class="text-center">
                                    ผู้ตรวจสอบ ________________________
                                </div>
                                <div class="text-center" style="margin-top: 3px;">
                                    (_______________________________)
                                </div>
                                <div class="text-center" style="margin-top: 3px;">
                                    ตำแหน่ง __________________
                                </div>
                                <div class="text-center" style="margin-top: 3px;">
                                    วันที่ ______/______/______
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="page-break-inside:avoid;">
                    <div style="margin-top: 5px;">
                        หมายเหตุ
                    </div>
                </div>
            @endif

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach
    </body>
</html>