<div class="row">
    <div class="col-md-9 b-r">
        <div class="mini-scroll-bar" style="max-height: 480px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
        {!! Form::model($receipt, ['route' => ['ie.receipts.update', $receipt->receipt_id],
            'class' => 'form-horizontal',
            'id' => 'form-edit-receipt',
            'method' => 'post'] ) !!}

            {!! Form::hidden('receipt_type',$receiptType) !!}
            {!! Form::hidden('receipt_parent_id',$receiptParentId) !!}
            {{-- {!! Form::hidden('base_currency_id',$baseCurrencyId) !!} --}}

            {{-- Receipt No --}}
            <div class="row m-b-sm">
                <label for="" class="col-md-2 col-form-label">
                    <div>
                        {{-- Tax Invoice / Receipt # <span class="text-danger">{{ !in_array($receiptType, ['CASH-ADVANCE', 'REIMBURSEMENT']) ? '*' :'' }}</span> --}}
                        Tax Invoice / Receipt # <span class="text-danger"> * </span>
                    </div>
                    <div>
                        <small>
                            เลขที่ใบกำกับภาษี/ใบเสร็จ
                            @if ($receiptType == 'REIMBURSEMENT')
                                /ใบแจ้งหนี้
                            @endif
                        </small>
                    </div>
                </label>
                <div class="col-md-4">
                    {!! Form::text('receipt_number', null, ['class'=>'form-control input-sm','id'=>'txt_receipt_number','autocomplete'=>'off']) !!}
                    <div class="text-danger">
                        {{-- <small>กรณีไม่มีใบเสร็จ ให้ใส่ N/A <br> In case of no document, please input N/A</small> --}}
                    </div>
                </div>
                <label for="" class="col-md-2 col-form-label">
                    <div>
                        Date 
                        {{-- <span class="text-danger">{{ !in_array($receiptType, ['CASH-ADVANCE', 'REIMBURSEMENT']) ? '*' :'' }}</span> --}}
                    </div>
                    <div>
                        <small>
                            วันที่ใบกำกับภาษี/ใบเสร็จ
                            @if ($receiptType == 'REIMBURSEMENT')
                                /ใบแจ้งหนี้
                            @endif
                        </small>
                    </div>
                </label>
                <div class="col-md-4">
                    {!! Form::text('receipt_date', null, ['class'=>'form-control input-sm','id'=>'txt_receipt_date','autocomplete'=>'off']) !!}
                </div>
            </div>

            <div class="hr-line-dashed m-t-sm m-b-sm"></div>

            <div class="row m-b-sm">
                <label for="" class="col-sm-2 control-label">
                    <div>Budget Account <span class="text-danger">*</span></div>
                    <div>หน่วยงานเจ้าของงบ</div>
                </label>
                <div class="col-sm-4">
                    {!! Form::select('employee_id', $employeeLists, null, ["class" => 'form-control select2', "id" => 'txt_employee_id', "auocomplete" => "off", "style"=>"font-size:12px;width:100%"]) !!}
                    @if (!$parent->canImportantEditData())
                        {!! Form::hidden('employee_id', null, ["id" => 'txt_employee_id']) !!}
                    @endif
                </div>

                {{-- <label for="" class="col-md-2 col-form-label">
                    <div>Location</div>
                    <div><small>พื้นที่ใช้บริการ</small></div>
                </label>
                <div class="col-md-4">
                    <span>
                        {{ $receipt->location->name }} : <small>{{ $receipt->location->description }}</small>
                    </span>
                </div> --}}
                {{-- <label for="" class="col-md-1 col-form-label" style="padding-left: 5px;padding-right: 5px;">
                    <div>Currency</div>
                    <div><small>สกุลเงิน</small></div>
                </label>
                <div class="col-md-1">
                    <span>{{ $receipt->currency_id }}</span>
                </div>
                <label for="" class="col-md-2 col-form-label" style="padding-left: 5px;padding-right: 5px;">
                    <div>Exchange Rate</div>
                    <div><small>อัตราแลกเปลี่ยน</small></div>
                </label>
                <div class="col-md-2">
                    <span>{{ $receipt->exchange_rate ? $receipt->exchange_rate : '-' }}</span>
                </div> --}}
            </div>

            {{-- USE ONLY REIMBURSEMENT & CLEARING --}}
            {{-- @if($receiptType == 'REIMBURSEMENT' || $receiptType == 'CLEARING') --}}

            <div class="hr-line-dashed m-t-sm m-b-sm"></div>

            {{-- Establishment --}}
            <div class="row m-b-sm">
                <div class="col-md-6">
                    {{-- Vendor --}}
                    <div class="row">
                        <label for="" class="col-md-4 col-form-label">
                            <div>
                                Vendor
                                <span class="text-danger {{ $receiptType == 'CASH-ADVANCE' ? 'd-none' : '' }}">*</span>
                            </div>
                            <div><small>ผู้ให้บริการ</small></div>
                        </label>
                        <div class="col-md-8">
                            {!! Form::select('vendor_id', [''=>'None','other'=>'Other'] + $vendorLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%" , 'id'=>'ddl_vendor_id']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <label for="" class="col-md-4 col-form-label">
                            <div>
                                Vendor Site
                                <span class="text-danger {{ !in_array($receipt->vendor_id, ['other','']) ? '' : 'd-none'}}" id="span_vendor_site_code_required">*</span>
                            </div>
                            <div><small>สถานที่ผู้ให้บริการ</small></div>
                        </label>
                        <div class="col-md-8" id="div_vendor_sites">
                            @if(in_array($receipt->vendor_id, ['other','']))
                                {!! Form::select('vendor_site_code', [''=>'-'] + $vendorSiteLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%",'id'=>'ddl_vendor_site_code', 'disabled'=>'disabled']) !!}
                            @else
                                {!! Form::select('vendor_site_code', [''=>'-'] + $vendorSiteLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%",'id'=>'ddl_vendor_site_code']) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-b-sm">
                <div class="col-md-12">
                    <div class="m-t-sm">
                        <div class="row m-b-sm" id="showOtherVendor" style="display: none;">
                            <label for="" class="col-md-2">
                                <div>
                                    Vendor Name
                                    <span class="text-danger">*</span>
                                </div>
                                <div><small>ชื่อผู้ให้บริการ</small></div>
                            </label>
                            <div class="col-md-10">
                                {!! Form::text('vendor_name', null, ['class'=>'form-control input-sm', 'id'=>'txt_vendor_name','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-md-2">
                                <div>
                                    Tax ID
                                    {{-- <span class="text-danger d-none" id="span_tax_id_required">*</span> --}}
                                </div>
                                <div><small>เลขประจำตัวผู้เสียภาษี</small></div>
                            </label>
                            <div class="col-md-4 m-b-sm">
                                {!! Form::text('vendor_tax_id', null, ['class'=>'form-control input-sm', 'id'=>'txt_vendor_tax_id','autocomplete'=>'off','maxlength'=>'13']) !!}
                            </div>
                            <label for="" class="col-md-2">
                                <div>
                                    Branch Number
                                    {{-- <span class="text-danger d-none" id="span_branch_required">*</span> --}}
                                </div>
                                <div><small>รหัสสาขา</small></div>
                            </label>
                            <div class="col-md-4 m-b-sm">
                                {!! Form::text('vendor_branch_name', null, ['class'=>'form-control input-sm', 'id'=>'txt_vendor_branch_name','autocomplete'=>'off','maxlength'=>'5']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-md-2">
                                <div> Address in Tax Inv.</div>
                                <div><small>ที่อยู่ในใบกำกับภาษี</small></div>
                            </label>
                            <div class="col-md-10">
                                {!! Form::text('vendor_tax_address', null, ['class'=>'form-control input-sm', 'id'=>'txt_vendor_tax_address','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div id="div_oracle_vendor_detail">

                    </div>
                </div>
            </div>

            {{-- @endif --}}

            <div class="hr-line-dashed m-t-sm m-b-sm"></div>

            {{-- Jusification --}}
            <div class="row m-b-sm">
                <label for="" class="col-md-2 col-form-label">
                {{-- Description <span class="text-danger">*</span> --}}
                    <div>
                        Description
                        {{-- <span class="text-danger">*</span> --}}
                    </div>
                    <div class="m-r-sm"><small>รายละเอียด</small></div>
                </label>
                <div class="col-md-10">
                    {!! Form::textArea('jusification', null, ['class'=>'form-control input-sm', "autocomplete" => "off", 'id'=>'txt_jusification','rows'=>'4']) !!}
                </div>
            </div>

            {{-- <div class="hr-line-dashed m-t-sm m-b-sm"></div> --}}

            {{-- Project --}}
            <div class="row d-none">
                <label for="" class="col-md-2 col-form-label">
                    {{-- Project <span class="text-danger">*</span> --}}
                    <div>Project
                        <span class="text-danger">*</span>
                    </div>
                    <div class="m-r-sm"><small>โครงการ</small></div>
                </label>
                <div class="col-md-10">
                    {{-- {!! Form::text('project', null, ['class'=>'form-control input-sm', "autocomplete" => "off", 'placeholder' => 'Project', 'id'=>'txt_project']) !!} --}}
                    {{-- {!! Form::select('project', $projectLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%", 'id'=>'ddl_project']) !!} --}}
                    <div><ul>
                        <li>
                       <small>
                        ให้เลือก project ที่ต้องการบันทึกค่าใช้จ่าย หากไม่มีให้เลือก "N/A(000)" <br>
                        Please select project name, if no please input "N/A(000)"</small>
                        </li>
                    </ul></div>
                </div>
            </div>
            <div class="row d-none">
                <label for="" class="col-md-2 col-form-label">
                    <div>Job
                        <span class="text-danger">*</span>
                    </div>
                    <div class="m-r-sm"><small>งาน</small></div>
                </label>
                <div class="col-md-10">
                    {!! Form::text('job', null, ['class'=>'form-control input-sm', "autocomplete" => "off", 'placeholder' => 'Job', 'id'=>'txt_job','autocomplete'=>'off']) !!}
                    <div><ul>
                        <li>
                        <small>
                        กรณีที่ค่าใช้จ่ายไม่ไปเรียกเก็บกับบริษัทในเครือ กรุณากรอก  "N/A"<br>
                        In case of the expense is not to be charged to Inter-Company, please put " N/A "</small>
                        </li>
                        <li>
                        <small>
                        กรณีที่ค่าใช้จ่ายไปเรียกเก็บกับบริษัทในเครือ กรุณากรอกตามฟอร์แมตดังนี้<br>(ชื่อของโปรเจค ลีดเดอร์/ ช่วงเวลา (ที่ใช้จ่าย) /ประเทศ เช่น Mr. Bill/ 1-5 Feb 17/ Singapore)<br>
                        In case of the expense is to be charged to Inter-Company, please put information as the following format<br>(Project leader name / Project date / Country), for example: Mr.Bill / 1-5 Feb 17 / Singapore)</small>
                        </li>
                    </ul></div>
                </div>
            </div>
            <div class="row d-none">
                <label for="" class="col-md-2 col-form-label">
                    {{-- Recharge <span class="text-danger">*</span> --}}
                    <div>Recharge
                        <span class="text-danger">*</span>
                    </div>
                    <div class="m-r-sm"><small>ชาร์จบริษัท</small></div>
                </label>
                <div class="col-md-10">
                    {{-- {!! Form::select('recharge', $rechargeLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%", 'id'=>'ddl_recharge']) !!} --}}
                    <div><ul>
                        <li>
                        <small>กรณีที่ค่าใช้จ่ายไม่ไปเรียกเก็บกับบริษัทในเครือ กรุณากรอก  "N/A (00)" <br> In case of the expense is not to be charged to Inter-Company, please select " N/A (00) " </small>
                        </li>
                        <li>
                        <small>กรณีที่ค่าใช้จ่ายไปเรียกเก็บกับบริษัทในเครือ กรุณากรอกชื่อบริษัทในเครือ <br> In case of the expense is to be charged to Inter-Company, please select Inter-Company name</small>
                        </li>
                    </ul></div>
                </div>
            </div>

        {!! Form::close() !!}

        </div>
    </div>

    <div class="col-md-3">
        <div class="row">
            <div class="col-sm-12">
                <label>Attachments (ไฟล์แนบ) </label>
                @if(count($receipt->attachments) > 0)
                <div class="clearfix m-t-xs m-b-sm mini-scroll-bar"
                     style="max-height: 370px;overflow: auto;">
                    @foreach($receipt->attachments as $attachment)
                        @include('ie.commons.receipts._attachments', ['canRemove'=>true])
                    @endforeach
                </div>
                @endif
                <div class="clearfix">
                    @include('ie.commons.receipts._add_attachment')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hr-line-dashed m-t-sm m-b-sm"></div>

<div class="text-right">
    <button id="btn_submit_edit_receipt" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ..." type="button" class="btn btn-primary">
        Save
    </button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">
        Close
    </button>
</div>
