<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Advance Type (ประเภทการยืม) <span class="text-danger">*</span></div>
        </label>
        <select name="advance_type" class='form-control select2' id='ddl_advance_type'>
            <option value="ในประเทศ">ในประเทศ</option>
            <option value="ต่างประเทศ">ต่างประเทศ</option>
        </select>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <input name="pay_to_emp" value="YES" type="radio" id="payToEmp" checked='checked'> 
                <label for="payToEmp" style="display: inline;">Transfer (เงินโอน)</label>
            </div>
            <div class="col-md-6">
                <input name="pay_to_emp" value="NO" type="radio" id="notPayToEmp"> 
                <label for="notPayToEmp" style="display: inline;">Cash (เงินสด)</label>
            </div>
        </div>
    </div>
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Requester (ผู้ยืม)</div>
        </label>
        {!! Form::select('username', $employeeLists, optional($requester)->username , ["class" => 'form-control select2', "id" => 'txt_username', "autocomplete" => "off"]) !!}
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <label>
                    <div>Request Date (วันที่ขอเบิก) <span class="text-danger">*</span> </div>
                </label>
                {!! Form::text('request_date', date('d/m/Y'), ['class'=>'form-control','id'=>'txt_request_date', 'autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-6">
                <label>
                    <div>GL Date (วันที่บันทึกบัญชี) <span class="text-danger">*</span> </div>
                </label>
                {!! Form::text('gl_date', date('d/m/Y'), ['class'=>'form-control','id'=>'txt_gl_date', 'autocomplete'=>'off']) !!}
            </div>
        </div>
    </div>
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6 pr-0">
                <label>
                    <div>Requester ID (รหัสผู้ยืม)</div>
                </label>
            </div>
            <div class="col-md-6 pl-0">
                <div id="p_requester_id">
                    {{ optional($requester)->username ?? '-' }}
                </div>
                {!! Form::hidden('requester_id', optional($requester)->username ?? null, ["id" => 'txt_requester_id']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pr-0">
                <label>
                    <div>Position (ตำแหน่ง)</div>
                </label>
            </div>
            <div class="col-md-6 pl-0">
                <div id="p_position_name">
                    {{ optional(optional($requester)->PersonalDeptLocation)->pos_name ?? '-' }}
                </div>
                {!! Form::hidden('position_name', optional(optional($requester)->PersonalDeptLocation)->pos_name ?? null, ["id" => 'txt_position_name']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label>
            <div>Bank Name (ธนาคาร)</div>
            <div></div>
        </label>
        {!! Form::select('bank_name', $bankLists, $defaultBank ?? null, ["class" => 'form-control select2', "id" => 'select_bank_name', "autocomplete" => "off", "disabled"=>"disabled"]) !!}
        {!! Form::hidden('bank_name', $defaultBank ?? null, ["id" => 'txt_bank_name']) !!}
    </div>
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6 pr-0">
                <label>
                    <div>Department (ชื่อแผนก)</div>
                </label>
            </div>
            <div class="col-md-6 pl-0">
                <div id="p_department_code">
                    {{ optional($requester)->PersonalDeptLocation ? $requester->PersonalDeptLocation->dept_cd_f02 .' : '.$requester->PersonalDeptLocation->department->description : '-' }}
                </div>
                {!! Form::hidden('department_code', optional(optional($requester)->PersonalDeptLocation)->dept_cd_f02 ?? null, ["id" => 'txt_department_code']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pr-0">
                <label>
                    <div>Account Name (ชื่อบัญชี)</div>
                </label>
            </div>
            <div class="col-md-6 pl-0">
                <div id="p_account_name">
                    {{ optional($requester)->name ?? '-' }}
                </div>
                {!! Form::hidden('account_name', optional($requester)->name ?? null, ["id" => 'txt_account_name']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label>
            <div>Account No. (เลขที่บัญชี)</div>
            <div></div>
        </label>
        {!! Form::select('account_no', ['' => '-'], null, ["class" => 'form-control select2', "id" => 'select_account_no', "autocomplete" => "off", "disabled"=>"disabled"]) !!}
        {!! Form::hidden('account_no', null, ["id" => 'txt_account_no']) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>
            <div>Operating Unit (สถานที่ปฏิบัติการ)</div>
            <div></div>
        </label>
        {!! Form::select('org_id', $ouLists, getDefaultData()->bu_id, ["class" => 'form-control select2', "autocomplete" => "off","disabled"=>"disabled"]) !!}
        {!! Form::hidden('org_id', getDefaultData()->bu_id, ["id" => 'txt_org_id']) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Tel (โทร) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('tel', null, ['class'=>'form-control', 'id'=>'txt_tel', 'autocomplete'=>'off', 'maxlength'=> '10']) !!}
    </div>
</div>

<div class="hr-line-dashed m-t-sm m-b-sm"></div>

{{-- <div class="row">
    <label class="col-md-2">
        <div>Category <span class="text-danger">*</span></div>
        <div class="m-r-sm">ประเภท</div>
    </label>
    <div class="col-md-4">
        @if(!isset($cashAdvance))
            {!! Form::select('ca_category_id', [''=>'-'] + $CACategoryLists, null, ['class'=>'form-control select2','id'=>'ddl_ca_category_id']) !!}
        @else
            {{ $cashAdvance->category->name }}
        @endif
    </div>
    <label class="col-md-2">
        <div>Sub-Category <span class="text-danger">*</span></div>
        <div class="m-r-sm">ประเภทย่อย</div>
    </label>
    <div class="col-md-4">
        <div id="div_ddl_ca_sub_category_id">
        @if(!isset($cashAdvance))
            {!! Form::select('ca_sub_category_id', [''=>'-'] + $CASubCategoryLists , null,  ["class" => 'form-control input-sm select2', "id"=>"ddl_ca_sub_category_id", "autocomplete" => "off","style"=>"width:100%","disabled"=>"disabled"]) !!}
        @else
            {{ $cashAdvance->subCategory->name }}
        @endif
        </div>
    </div>
</div> --}}

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Supplier (ผู้ขาย) <span class="text-danger">*</span></div>
        </label>
        <div id="div_ddl_supplier_id">
            {!! Form::select('supplier_id', [''=>'-']+$supplierLists , $defaultSupplierId, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <label>
            <div>Supplier Site (ที่อยู่ผู้ขาย)<span class="text-danger">*</span></div>
        </label>
        <div id="div_ddl_supplier_site_id">
            {!! Form::select('supplier_site_id', [''=>'-'] , null, ["class" => 'form-control select2', "autocomplete" => "off","disabled"=>"disabled"]) !!}
        </div>
    </div>
</div>

<div class="row m-b-sm" id="div_detail_supplier_bank">
    
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Payment Method (วิธีการชำระเงิน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::select('payment_method_id', [''=>'-'] + $APPaymentMethodLists, $defaultPaymentMethod,['class'=>'form-control select2','id'=>'ddl_payment_method_id','disabled'=>'disabled']) !!}
        {!! Form::hidden('payment_method_id', $defaultPaymentMethod, ["id" => 'txt_payment_method_id']) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Need by Date (วันที่ต้องการรับเงิน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('need_by_date', null, ['class'=>'form-control','id'=>'txt_need_by_date', "autocomplete" => "off"]) !!}
    </div>
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Finish Date (วันที่ครบกำหนดแล้วเสร็จ) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('finish_date', null, ['class'=>'form-control','id'=>'txt_finish_date', "autocomplete" => "off"]) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Currency (สกุลเงิน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::select('currency_id', [''=>'-'] + $currencyLists,!isset($cashAdvance->currency_id) ? $baseCurrencyId : $cashAdvance->currency_id,['class'=>'form-control select2','id'=>'ddl_currency_id']) !!}
    </div>
</div>

<div class="row m-b-sm d-none" id="div_exchange_rate">
    <div class="col-md-6">
        <label>
            <div>Exchange Rate (อัตราแลกเปลี่ยน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('exchange_rate', null, ['class'=>'form-control','id'=>'txt_exchange_rate', 'autocomplete'=>'off']) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Rate Date (วันที่แลกเปลี่ยน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('rate_date', null, ['class'=>'form-control','id'=>'txt_rate_date', 'autocomplete'=>'off']) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>
            <div>Purpose (วัตถุประสงค์) <span class="text-danger">*</span></div>
        </label>
        {!! Form::select('purpose', ['' => '-']+$purposeLists, null, ["class" => 'form-control select2', "id" => 'select_purpose', "autocomplete" => "off"]) !!}
        {{-- {!! Form::textArea('purpose', null , ["class" => 'form-control', "autocomplete" => "off", "rows" => "4", "maxlength"=>"250"]) !!} --}}
    </div>
    <div class="col-md-6">
        <label>
            <div>Reason (เหตุผลและความจำเป็น) <span class="text-danger">*</span></div>
        </label>
        {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "rows" => "2", "maxlength"=>"250"]) !!}
    </div>
</div>

<div class="hr-line-dashed m-t-md m-b-md"></div>
<h3>Report <span style="font-size: 12px; color: darkgray; font-weight: normal;">( ใช้ในการออกรายงาน Invoice Register / ใบขออนุมัติหลักการใช้งบประมาณ )</span></h3>
<div class="row">
    <div class="col-md-6">
        <label>
            <div>Checked By (ผู้ตรวจสอบ)</div>
        </label>
        {!! Form::select('checked_by', ['' => '-']+$employeeLists, null, ["class" => 'form-control select2', "id" => 'txt_checked_by', "autocomplete" => "off"]) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Approved By (ผู้อนุมัติ)</div>
        </label>
        {!! Form::select('approved_by', ['' => '-']+$employeeLists, null, ["class" => 'form-control select2', "id" => 'txt_approved_by', "autocomplete" => "off"]) !!}
    </div>
</div>

{{-- FORM INFORMATIONS --}}
<div class="row" id="div_form_informations">

    @include('ie.cash-advances._form_informations')
    
</div>