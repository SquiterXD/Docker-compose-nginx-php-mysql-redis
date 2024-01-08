<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Reimbursement Type (ประเภทการเบิก) <span class="text-danger">*</span></div>
        </label>
        <select name="reimbursement_type" class='form-control select2' id='ddl_reimbursement_type'>
            <option value="ในประเทศ">ในประเทศ</option>
            <option value="ต่างประเทศ">ต่างประเทศ</option>
        </select>
    </div>
    <div class="col-md-6">
        <input name="pay_to_emp" value="YES" type="radio" id="payToEmp" checked='checked'> 
        <label for="payToEmp" style="display: inline;">Pay to Employee (จ่ายเงินให้พนักงาน) </label>
    </div>
    {{-- <div class="col-md-4 m-t-sm pr-md-0">
        <input name="pay_to_emp" value="NO" type="radio" id="notPayToEmp">
        <label for="notPayToEmp" style="display: inline;">Pay to Vendor จ่ายเงินให้ร้านค้า</label>
    </div> --}}
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Requester (ผู้ขอเบิก)</div>
        </label>
        {!! Form::select('username', $employeeLists, optional($requester)->username , ["class" => 'form-control select2', "id" => 'txt_username', "autocomplete" => "off"]) !!}
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <label>
                    <div>Invoice Date (วันที่ใบแจ้งหนี้) <span class="text-danger">*</span> </div>
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
                    <div>Requester ID (รหัสผู้ขอเบิก)</div>
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
        </label>
        {{-- <p id="p_account_no">
            {{ optional(optional($requester)->pnMaster)->prmf_bankacc ?? '-' }}
        </p> --}}
        {{-- {!! Form::hidden('account_no', optional(optional($requester)->pnMaster)->prmf_bankacc ?? null, ["id" => 'txt_account_no']) !!} --}}
        {!! Form::select('account_no', ['' => '-'], null, ["class" => 'form-control select2', "id" => 'select_account_no', "autocomplete" => "off", "disabled"=>"disabled"]) !!}
        {!! Form::hidden('account_no', null, ["id" => 'txt_account_no']) !!}
    </div>
    
</div>

<div class="row">
    <div class="col-md-6">
        <label>
            <div>Operating Unit (สถานที่ปฏิบัติการ)</div>
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

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Invoice Number (เลขที่ใบแจ้งหนี้ / เลขที่บันทึก) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('invoice_no', null, ['class'=>'form-control', 'id'=>'txt_invoice_no', 'autocomplete'=>'off', 'maxlength'=> '40']) !!}
    </div>
    <div class="col-md-6">
    </div>
</div>

<div class="hr-line-dashed m-t-md m-b-md"></div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <input name="pay_to_emp" value="NO" type="radio" id="notPayToEmp">
        <label for="notPayToEmp" style="display: inline;">Pay to Supplier (จ่ายเงินให้ผู้ขาย)</label>
    </div>
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Supplier (ผู้ขาย) <span class="text-danger">*</span></div>
        </label>
        <div id="div_ddl_supplier_id">
            {!! Form::select('supplier_id', $supplierLists , $defaultSupplierId, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <label>
            <div>Supplier Site (ที่อยู่ผู้ขาย) <span class="text-danger">*</span></div>
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
        {!! Form::select('payment_method_id', [''=>'-'] + $APPaymentMethodLists, $defaultPaymentMethod,['class'=>'form-control select2',"id" => 'ddl_payment_method_id','disabled'=>'disabled']) !!}
        {!! Form::hidden('payment_method_id', $defaultPaymentMethod, ["id" => 'txt_payment_method_id']) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Currency (สกุลเงิน) <span class="text-danger">*</span></div>
        </label>
        @if (!isset($reim))
            {!! Form::select('currency_id', [''=>'-'] + $currencyLists, $baseCurrencyId,['class'=>'form-control select2','id'=>'ddl_currency_id']) !!}
        @else
            @if ($reim->receipts->count())
                <p>{!! $reim->currency_id !!}</p>
            @else
                {!! Form::select('currency_id', [''=>'-'] + $currencyLists, $reim->currency_id,['class'=>'form-control select2','id'=>'ddl_currency_id']) !!}
            @endif
        @endif
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
        {!! Form::textArea('purpose', null , ["class" => 'form-control', "autocomplete" => "off", "rows" => "4", "maxlength"=>"250"]) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Reason (เหตุผลและความจำเป็น) <span class="text-danger">*</span></div>
        </label>
        {!! Form::textArea('reason', null , ["class" => 'form-control', "autocomplete" => "off", "rows" => "4", "maxlength"=>"250"]) !!}
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