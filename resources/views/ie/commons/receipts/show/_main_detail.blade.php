<div class="row m-t-sm m-r-md">

    <div class="col-sm-9">

        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right">
                <dt>
                    <div>Date</div>
                    <div>
                        <small>
                            วันที่ใบกำกับภาษี/ใบเสร็จ
                            @if ($receiptType == 'REIMBURSEMENT')
                                /ใบแจ้งหนี้
                            @endif
                        </small>
                    </div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $receipt->receipt_date ? $receipt->receipt_date : '-' }}</dd>
            </div>
        </dl>

        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right">
                <dt>
                    <div>Budget Account</div>
                    <div><small>หน่วยงานเจ้าของงบ</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $receipt->employee ? ($receipt->employee->employee_number.' : '.$receipt->employee->last_name) : null }}</dd>
            </div>
        </dl>

        @if($receipt->vendor_id)
            @if($receipt->vendor_id != 'other')
                <dl class="row mb-1">
                    <div class="col-md-4 text-sm-right">
                        <dt>
                            <div>Vendor</div>
                            <div><small>ผู้ให้บริการ</small></div>
                        </dt>
                    </div>
                    <div class="col-md-8 text-sm-left">
                        <dd>{{ $receipt->vendor ? $receipt->vendor->vendor_no.' : '.$receipt->vendor->vendor_name : 'None' }}</dd>
                    </div>
                </dl>
                <dl class="row mb-1">
                    <div class="col-md-4 text-sm-right">
                        <dt>
                            <div>Vendor Site</div>
                            <div><small>สถานที่ผู้ให้บริการ</small></div>
                        </dt>
                    </div>
                    <div class="col-md-8 text-sm-left">
                        <dd>{{ $receipt->vendor ? $receipt->vendor->vendor_site_code : 'None' }}</dd>
                    </div>
                </dl>
                @if($receipt->vendor_tax_id)
                    <dl class="row mb-1">
                        <div class="col-md-4 text-sm-right">
                            <dt>
                                <div>Tax ID</div>
                                <div><small>เลขประจำตัวผู้เสียภาษี</small></div>
                            </dt>
                        </div>
                        <div class="col-md-8 text-sm-left">
                            <dd>{{ $receipt->vendor_tax_id }}</dd>
                        </div>
                    </dl>
                @endif
                @if($receipt->vendor_branch_name)
                    <dl class="row mb-1">
                        <div class="col-md-4 text-sm-right">
                            <dt>
                                <div>Branch Number</div>
                                <div><small>สาขา</small></div>
                            </dt>
                        </div>
                        <div class="col-md-8 text-sm-left">
                            <dd>{{ $receipt->vendor_branch_name }}</dd>
                        </div>
                    </dl>
                @endif
                @if($receipt->vendor_tax_address)
                    <dl class="row mb-1">
                        <div class="col-md-4 text-sm-right">
                            <dt>
                                <div>Address in Tax Inv.</div>
                                <div><small>ที่อยู่ในใบกำกับภาษี</small></div>
                            </dt>
                        </div>
                        <div class="col-md-8 text-sm-left">
                            <dd>{{ $receipt->vendor_tax_address }}</dd>
                        </div>
                    </dl>
                @endif
            @else
                @if($receipt->vendor_name)
                    <dl class="row mb-1">
                        <div class="col-md-4 text-sm-right">
                            <dt>
                                <div>Vendor</div>
                                <div><small>ผู้ให้บริการ</small></div>
                            </dt>
                        </div>
                        <div class="col-md-8 text-sm-left">
                            <dd>{{ $receipt->vendor_name }}</dd>
                        </div>
                    </dl>
                @endif
                @if($receipt->vendor_tax_id)
                    <dl class="row mb-1">
                        <div class="col-md-4 text-sm-right">
                            <dt>
                                <div>Tax ID</div>
                                <div><small>เลขประจำตัวผู้เสียภาษี</small></div>
                            </dt>
                        </div>
                        <div class="col-md-8 text-sm-left">
                            <dd>{{ $receipt->vendor_tax_id }}</dd>
                        </div>
                    </dl>
                @endif
                @if($receipt->vendor_branch_name)
                    <dl class="row mb-1">
                        <div class="col-md-4 text-sm-right">
                            <dt>
                                <div>Branch Number</div>
                                <div><small>สาขา</small></div>
                            </dt>
                        </div>
                        <div class="col-md-8 text-sm-left">
                            <dd>{{ $receipt->vendor_branch_name }}</dd>
                        </div>
                    </dl>
                @endif
                @if($receipt->vendor_tax_address)
                    <dl class="row mb-1">
                        <div class="col-md-4 text-sm-right">
                            <dt>
                                <div>Address in Tax Inv.</div>
                                <div><small>ที่อยู่ในใบกำกับภาษี</small></div>
                            </dt>
                        </div>
                        <div class="col-md-8 text-sm-left">
                            <dd>{{ $receipt->vendor_tax_address }}</dd>
                        </div>
                    </dl>
                @endif
            @endif
        @else
            <dl class="row mb-1">
                <div class="col-md-4 text-sm-right">
                    <dt>
                        <div>Vendor</div>
                        <div><small>ผู้ให้บริการ</small></div>
                    </dt>
                </div>
                <div class="col-md-8 text-sm-left">
                    <dd>None</dd>
                </div>
            </dl>
        @endif

        <dl class="row mb-1">
            <div class="col-md-4 text-sm-right">
                <dt>
                    <div>Description</div>
                    <div><small>รายละเอียด</small></div>
                </dt>
            </div>
            <div class="col-md-8 text-sm-left">
                <dd>{{ $receipt->jusification ? $receipt->jusification : '-' }}</dd>
            </div>
        </dl>

        {{-- <dl class="dl-horizontal m-b-xs d-none">
            <dt style="width:200px">
                <div>Project</div>
                <div><small>โครงการ</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ array_key_exists($receipt->project, $projectLists) ? $projectLists[$receipt->project] : 'N/A' }}</dd>

            <dt style="width:200px">
                <div>Job</div>
                <div><small>งาน</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ $receipt->job }}</dd>

            <dt style="width:200px">
                <div>Recharge</div> 
                <div><small>ชาร์จบริษัท</small></div>
            </dt>
            <dd style="margin-left: 220px;">{{ array_key_exists($receipt->recharge, $rechargeLists) ? $rechargeLists[$receipt->recharge] : 'N/A' }}</dd>
        </dl> --}}

    </div>

    <div class="col-sm-3 pull-right text-right">
        <div>
            <h4>
                <div>Tax Invoice/Receipt #</div>
                <div>
                    <small>
                        เลขที่ใบกำกับภาษี/ใบเสร็จ
                        @if ($receiptType == 'REIMBURSEMENT')
                            /ใบแจ้งหนี้
                        @endif
                    </small>
                </div>
            </h4>
            <p style="font-size: 1.2em" class="text-navy">
                {{ $receipt->receipt_number ? $receipt->receipt_number : '-' }}
            </p>
        </div>
    </div>

</div>
