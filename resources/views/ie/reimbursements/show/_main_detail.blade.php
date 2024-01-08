{{-- SHOW ONLY ON PC SCREEN --}}
<div class="row hidden-xs mb-3">
    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Requester</div>
                    <div><small>(ผู้ขอเบิก)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ optional($reim->requester)->name ?? '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Requester ID</div>
                    <div><small>(รหัสผู้ขอเบิก)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $reim->requester_id ??'-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Position</div>
                    <div><small>(ตำแหน่ง)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>ผู้อำนวยการฝ่าย</dd> --}}
                <dd>{{ $reim->position_name ?? '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Department</div>
                    <div><small>(ชื่อแผนก)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>24000600</dd> --}}
                <dd>{{ $reim->department_code ? $reim->department_code .' : '. optional($reim->department)->description : '-' }}</dd>
            </div>
        </dl>
        {{-- <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Pay To Employee</div>
                    <div><small>(พนักงานผู้รับโอน)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $reim->pay_to_emp }}</dd>
            </div>
        </dl> --}}
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Operating Unit</div>
                    <div><small>(สถานที่ปฏิบัติการ)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{!! $ouLists[$reim->org_id] !!}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Tel</div>
                    <div><small>(โทร)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $reim->tel }}</dd>
            </div>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Invoice Date</div>
                    <div><small>(วันที่ใบแจ้งหนี้)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>Bank of Ayudhya Public Company Limited</dd> --}}
                <dd>{{ $reim->request_date ?? '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>GL Date</div>
                    <div><small>(วันที่บันทึกบัญชี)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>Bank of Ayudhya Public Company Limited</dd> --}}
                <dd>{{ $reim->gl_date ?? '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Bank Name</div>
                    <div><small>(ธนาคาร)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>Bank of Ayudhya Public Company Limited</dd> --}}
                <dd>{{ $reim->bank_name ?? '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Account No.</div>
                    <div><small>(เลขที่บัญชี)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>4844002052</dd> --}}
                <dd>{{ $reim->account_no }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Account Name</div>
                    <div><small>(ชื่อบัญชี)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>นายพิทวัส ทองดี</dd> --}}
                <dd>{{ $reim->account_name }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Invoice Number</div>
                    <div><small>(เลขที่ใบแจ้งหนี้ / เลขที่บันทึก)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>นายพิทวัส ทองดี</dd> --}}
                <dd>{{ $reim->invoice_no }}</dd>
            </div>
        </dl>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Supplier</div>
                    <div><small>(ผู้ขาย)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>
                    {{ $reim->supplierSite ? $reim->supplierSite->vendor_no .' : '. $reim->supplierSite->vendor_name : 'None' }}
                </dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Supplier Bank</div>
                    <div><small>(ธนาคารผู้ขาย)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>
                    {{ $reim->vendor_bank_name ? $reim->vendor_bank_name : '-' }}
                </dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Payment Method</div>
                    <div><small>(วิธีการชำระเงิน)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $reim->paymentMethod ? $reim->paymentMethod->payment_method_code : '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Due Date</div>
                    <div><small>(วันที่กำหนดจ่าย)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $reim->due_date }}</dd>
            </div>
        </dl>
        @if ( $reim->currency_id != 'THB' )
            <dl class="row mb-1">
                <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                    <dt>
                        <div>Exchange Rate</div>
                        <div><small>(อัตราแลกเปลี่ยน)</small></div>
                    </dt>
                </div>
                <div class="col-md-8 text-sm-left">
                    <dd>{{ $reim->exchange_rate }}</dd>
                </div>
            </dl>
        @endif
    </div>

    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Supplier Site</div>
                    <div><small>(ที่อยู่ผู้ขาย)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>
                    {{ $reim->supplierSite ? $reim->supplierSite->vendor_site_code : 'None' }}
                </dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Supplier Account No</div>
                    <div><small>(เลขที่บัญชีผู้ขาย)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>
                    {{ $reim->vendor_bank_account_no ? $reim->vendor_bank_account_no : '-' }}
                </dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Payment Term</div>
                    <div><small>(เงื่อนไขการชำระเงิน)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ optional($reim->paymentTerm)->payment_term_name ?? '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Currency </div>
                    <div><small>(สกุลเงิน)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $reim->currency_id }}</dd>
            </div>
        </dl>
        @if ( $reim->currency_id != 'THB' )
            <dl class="row mb-1">
                <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                    <dt>
                        <div>Rate Date</div>
                        <div><small>(วันที่แลกเปลี่ยน)</small></div>
                    </dt>
                </div>
                <div class="col-md-8 text-sm-left">
                    <dd>{{ $reim->rate_date }}</dd>
                </div>
            </dl>
        @endif
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    @if ($reim->pay_to_emp === 'YES')
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-square-o" aria-hidden="true"></i>
                    @endif
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>Pay to Employee (จ่ายเงินให้พนักงาน)</dd>
            </div>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    @if ($reim->pay_to_emp === 'NO')
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-square-o" aria-hidden="true"></i>
                    @endif
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>Pay to Supplier (จ่ายเงินให้ผู้ขาย)</dd>
            </div>
        </dl>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Purpose</div>
                    <div><small>(วัตถุประสงค์)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd class="mini-scroll-bar" style="max-height: 200px;overflow: auto;">
                    {!! $reim->purpose ? nl2br($reim->purpose) : '-' !!}
                </dd>
            </div>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Reason</div>
                    <div><small>(เหตุผลและความจำเป็น)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd class="mini-scroll-bar" style="max-height: 200px;overflow: auto;">
                    {!! $reim->reason ? nl2br($reim->reason) : '-' !!}
                </dd>
            </div>
        </dl>
    </div>
</div>
<hr class="m-t-sm m-b-sm">
