<div class="row hidden-xs mb-3">
    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Requester</div>
                    <div><small>(ผู้ยืม)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ optional($cashAdvance->requester)->name ?? '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Requester ID</div>
                    <div><small>(รหัสผู้ยืม)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $cashAdvance->requester_id ??'-' }}</dd>
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
                <dd>{{ $cashAdvance->position_name ?? '-' }}</dd>
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
                <dd>{{ $cashAdvance->department_code ? $cashAdvance->department_code .' : '. optional($cashAdvance->department)->description : '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Operating Unit</div>
                    <div><small>(สถานที่ปฏิบัติการ)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{!! $ouLists[$cashAdvance->org_id] !!}</dd>
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
                <dd>{{ $cashAdvance->tel }}</dd>
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
                <dd>{{ $cashAdvance->pay_to_emp }}</dd>
            </div>
        </dl> --}}
    </div>

    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Request Date</div>
                    <div><small>(วันที่ขอเบิก)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                {{-- <dd>Bank of Ayudhya Public Company Limited</dd> --}}
                <dd>{{ $cashAdvance->request_date ?? '-' }}</dd>
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
                <dd>{{ $cashAdvance->gl_date ?? '-' }}</dd>
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
                <dd>{{ $cashAdvance->bank_name ?? '-' }}</dd>
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
                <dd>{{ $cashAdvance->account_no }}</dd>
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
                <dd>{{ $cashAdvance->account_name }}</dd>
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
                <dd>{{ $cashAdvance->invoice_no }}</dd>
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
                    <div><small>(ผู้จัดหา)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>
                    {{ $cashAdvance->supplierSite ? $cashAdvance->supplierSite->vendor_no .' : '. $cashAdvance->supplierSite->vendor_name : 'None' }}
                </dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Supplier Bank</div>
                    <div><small>(ธนาคารผู้จัดหา)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>
                    {{ $cashAdvance->vendor_bank_name ? $cashAdvance->vendor_bank_name : '-' }}
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
                <dd>{{ optional($cashAdvance->paymentMethod)->payment_method_code ?? '-' }}</dd>
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
                {{-- <dd>{{ $cashAdvance->due_date }}</dd> --}}
                <dd>{{ $cashAdvance->gl_date }}</dd>
            </div>
        </dl>
        @if ( $cashAdvance->currency_id != 'THB' )
            <dl class="row mb-1">
                <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                    <dt>
                        <div>Exchange Rate</div>
                        <div><small>(อัตราแลกเปลี่ยน)</small></div>
                    </dt>
                </div>
                <div class="col-md-8 text-sm-left">
                    <dd>{{ $cashAdvance->exchange_rate }}</dd>
                </div>
            </dl>
        @endif
    </div>

    <div class="col-md-6">
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Supplier Site</div>
                    <div><small>(ที่อยู่ผู้จัดหา)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>
                    {{ optional($cashAdvance->supplierSite)->vendor_site_code ?? 'None' }}
                </dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Supplier Account No</div>
                    <div><small>(เลขที่บัญชีผู้จัดหา)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>
                    {{ $cashAdvance->vendor_bank_account_no ? $cashAdvance->vendor_bank_account_no : '-' }}
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
                <dd>{{ optional($cashAdvance->paymentTerm)->payment_term_name ?? '-' }}</dd>
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
                <dd>{{ $cashAdvance->currency_id }}</dd>
            </div>
        </dl>
        @if ( $cashAdvance->currency_id != 'THB' )
            <dl class="row mb-1">
                <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                    <dt>
                        <div>Rate Date</div>
                        <div><small>(วันที่แลกเปลี่ยน)</small></div>
                    </dt>
                </div>
                <div class="col-md-8 text-sm-left">
                    <dd>{{ $cashAdvance->rate_date }}</dd>
                </div>
            </dl>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {{-- <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Category</div>
                    <div><small>(ประเภท)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ optional($cashAdvance->category)->name ?? '-' }}</dd>
            </div>
        </dl>
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Sub-Category</div>
                    <div><small>(ประเภทย่อย)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ optional($cashAdvance->subCategory)->name ?? '-' }}</dd>
            </div>
        </dl> --}}
        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                <dt>
                    <div>Purpose</div>
                    <div><small>(วัตถุประสงค์)</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd class="mini-scroll-bar" style="max-height: 200px;overflow: auto;">
                    {!! $cashAdvance->purpose ? nl2br($cashAdvance->purpose) : '-' !!}
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
                    {!! $cashAdvance->reason ? nl2br($cashAdvance->reason) : '-' !!}
                </dd>
            </div>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <dl class="row mb-1">
            @if($cashAdvanceInfos)
                @foreach($cashAdvanceInfos as $info)
                    <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                        <dt>
                            <dt>{{ optional($info->subCategoryInfo)->attribute_name }}</dt>
                        </dt>
                    </div>
                    <div class="col-md-8 text-sm-left">
                        <dd>
                            {{ $info->description_for_show }}
                        </dd>
                    </div>
                @endforeach
            @endif
        </dl>
    </div>
</div>
<hr class="m-t-sm m-b-sm">
