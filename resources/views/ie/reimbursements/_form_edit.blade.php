<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Reimbursement Type (ประเภทการเบิก) <span class="text-danger">*</span></div>
        </label>
        <select name="reimbursement_type" class='form-control select2' id='ddl_reimbursement_type' disabled>
            <option value="ในประเทศ" {{ $reim->reimbursement_type == 'ในประเทศ' ? 'selected' : '' }}>ในประเทศ</option>
            <option value="ต่างประเทศ" {{ $reim->reimbursement_type == 'ต่างประเทศ' ? 'selected' : '' }}>ต่างประเทศ</option>
        </select>
        {!! Form::hidden('reimbursement_type', $reim->reimbursement_type, ["id" => 'txt_reimbursement_type']) !!}
    </div>
    <div class="col-md-6">
        <input name="pay_to_emp" value="YES" type="radio" id="payToEmp" {{ $reim->pay_to_emp == 'YES' ? 'checked' : '' }}> 
        <label for="payToEmp" style="display: inline;">Pay to Employee (จ่ายเงินให้พนักงาน) </label>
    </div>
    {{-- <div class="col-md-4 m-t-sm pr-md-0">
        <input name="pay_to_emp" value="NO" type="radio" id="notPayToEmp" {{ $reim->pay_to_emp == 'NO' ? 'checked' : '' }}> 
        <label for="notPayToEmp" style="display: inline;">Pay to Vendor จ่ายเงินให้ร้านค้า</label>
    </div> --}}
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Requester (ผู้ขอเบิก)</div>
        </label>
        @if ($reim->canImportantEditData() && !$reim->receipts()->count())
            {!! Form::select('username', $employeeLists, optional($requester)->username, ["class" => 'form-control select2', "id" => 'txt_username', "autocomplete" => "off"]) !!}
        @else
            {!! Form::select('username', $employeeLists, optional($requester)->username, ["class" => 'form-control select2', "id" => 'txt_username', "autocomplete" => "off", "disabled"=>"disabled"]) !!}
            {!! Form::hidden('username', optional($requester)->username ?? null, ["id" => 'txt_username_hidden']) !!}
        @endif
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <label>
                    <div>Invoice Date (วันที่ใบแจ้งหนี้) <span class="text-danger">*</span></div>
                </label>
                {!! Form::text('request_date', $reim->request_date, ['class'=>'form-control','id'=>'txt_request_date', 'autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-6">
                <label>
                    <div>GL Date (วันที่บันทึกบัญชี) <span class="text-danger">*</span></div>
                </label>
                {!! Form::text('gl_date', $reim->gl_date, ['class'=>'form-control','id'=>'txt_gl_date', 'autocomplete'=>'off']) !!}
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
        {!! Form::select('bank_name', $bankLists, $defaultBank, ["class" => 'form-control select2', "id" => 'select_bank_name', "autocomplete" => "off", "disabled"=>"disabled"]) !!}
        {!! Form::hidden('bank_name', $defaultBank, ["id" => 'txt_bank_name']) !!}
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
                    {{ $requester->PersonalDeptLocation ? $requester->PersonalDeptLocation->dept_cd_f02 .' : '.optional(optional($requester->PersonalDeptLocation)->department)->description : '-' }}
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
        {!! Form::select('account_no', ['' => '-'], null, ["class" => 'form-control select2', "id" => 'select_account_no', "autocomplete" => "off", "disabled"=>"disabled"]) !!}
        {!! Form::hidden('account_no', null, ["id" => 'txt_account_no']) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>
            <div>Operating Unit (สถานที่ปฏิบัติการ)</div>
        </label>
        {{-- @if ($reim->receipts->count())
            {!! $ouLists[$reim->org_id] !!}
            {!! Form::hidden('org_id', $reim->org_id, ["id" => 'txt_org_id']) !!}
        @else
            {!! Form::select('org_id', $ouLists, $reim->org_id, ["class" => 'form-control select2', "id" => 'txt_org_id', "autocomplete" => "off"]) !!}
        @endif --}}
        {!! Form::select('org_id', $ouLists, $reim->org_id, ["class" => 'form-control select2', "autocomplete" => "off","disabled"=>"disabled"]) !!}
        {!! Form::hidden('org_id', $reim->org_id, ["id" => 'txt_org_id']) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Tel (โทร) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('tel', $reim->tel, ['class'=>'form-control', 'id'=>'txt_tel', 'autocomplete'=>'off', 'maxlength'=> '10']) !!}
    </div>
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Invoice Number (เลขที่ใบแจ้งหนี้ / เลขที่บันทึก) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('invoice_no', $reim->invoice_no, ['class'=>'form-control', 'id'=>'txt_invoice_no', 'autocomplete'=>'off', 'maxlength'=> '40']) !!}
    </div>
    <div class="col-md-6">
    </div>
</div>

<div class="hr-line-dashed m-t-sm m-b-sm"></div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <input name="pay_to_emp" value="NO" type="radio" id="notPayToEmp" {{ $reim->pay_to_emp == 'NO' ? 'checked' : '' }}> 
        <label for="notPayToEmp" style="display: inline;">Pay to Vendor (จ่ายเงินให้ผู้ขาย)</label>
    </div>
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Supplier (ผู้จัดขาย) <span class="text-danger">*</span></div>
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
        {!! Form::select('payment_method_id', [''=>'-'] + $APPaymentMethodLists, $reim->payment_method_id,['class'=>'form-control select2',"id" => 'ddl_payment_method_id','disabled'=>'disabled']) !!}
        {!! Form::hidden('payment_method_id', $reim->payment_method_id, ["id" => 'txt_payment_method_id']) !!}
    </div>
    <div class="col-md-6">
        <label style="padding-right: 0px;">
            <div>Currency (สกุลเงิน) <span class="text-danger">*</span></div>
        </label>
        @if ($reim->receipts->count())
            <div>
                {!! $reim->currency_id !!}
                {!! Form::hidden('currency_id', $reim->currency_id, ["id" => 'ddl_currency_id']) !!}
            </div>
        @else
            {!! Form::select('currency_id', [''=>'-'] + $currencyLists, $reim->currency_id,['class'=>'form-control select2','id'=>'ddl_currency_id']) !!}
        @endif
    </div>
</div>

<div class="row m-b-sm d-none" id="div_exchange_rate">
    <div class="col-md-6">
        <label>
            <div>Exchange Rate (อัตราแลกเปลี่ยน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('exchange_rate', $reim->exchange_rate, ['class'=>'form-control','id'=>'txt_exchange_rate', 'autocomplete'=>'off']) !!}
    </div>
    <div class="col-md-6">
        <label style="padding-right: 0px;">
            <div>Rate Date (วันที่แลกเปลี่ยน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('rate_date', $reim->rate_date, ['class'=>'form-control','id'=>'txt_rate_date', 'autocomplete'=>'off']) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>
            <div>Purpose (วัตถุประสงค์) <span class="text-danger">*</span></div>
        </label>
        {!! Form::textArea('purpose', $reim->purpose , ["class" => 'form-control', "autocomplete" => "off", "rows" => "4", "maxlength"=>"250"]) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Reason (เหตุผลและความจำเป็น) <span class="text-danger">*</span></div>
        </label>
        {!! Form::textArea('reason', $reim->reason , ["class" => 'form-control', "autocomplete" => "off", "rows" => "4", "maxlength"=>"250"]) !!}
    </div>
</div>

<div class="hr-line-dashed m-t-md m-b-md"></div>
<h3>Report <span style="font-size: 12px; color: darkgray; font-weight: normal;">( ใช้ในการออกรายงาน Invoice Register / ใบขออนุมัติหลักการใช้งบประมาณ )</span></h3>
<div class="row">
    <div class="col-md-6">
        <label>
            <div>Checked By (ผู้ตรวจสอบ)</div>
        </label>
        {!! Form::select('checked_by', ['' => '-']+$employeeLists, $reim->checked_by, ["class" => 'form-control select2', "id" => 'txt_checked_by', "autocomplete" => "off"]) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Approved By (ผู้อนุมัติ)</div>
        </label>
        {!! Form::select('approved_by', ['' => '-']+$employeeLists, $reim->approved_by, ["class" => 'form-control select2', "id" => 'txt_approved_by', "autocomplete" => "off"]) !!}
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        
        var defaultBank = null;
        var defaultBankAccount = null;
        var APPaymentTerms = jQuery.parseJSON(JSON.stringify({!! $APPaymentTerms->toJson() !!}));
        var accountLists = jQuery.parseJSON(JSON.stringify({!! $accountLists->toJson() !!}));

        var defaultSupplierId = "{{ $defaultSupplierId }}";
        var defaultSupplierSiteId = "{{ $defaultSupplierSiteId }}";
        var defaultAccountNo = "{{ $defaultAccountNo }}";
        var currencyId = "{{ $reim->currency_id }}";
        var validGL = true;
        var defaultPaymentMethod = "{!! $defaultPaymentMethod !!}";

        setAccountNumberLists(defaultAccountNo);

        toggleShowExchageRate(currencyId);

        $("#form-edit-reimbursement").find(".select2").select2({width: "100%"});

        // $("#form-edit-reimbursement").find('#txt_due_date').datepicker({
        //     format: 'dd/mm/yyyy',
        //     todayBtn: true,
        //     multidate: false,
        //     keyboardNavigation: false,
        //     autoclose: true,
        //     todayBtn: "linked",
        //     startDate : new Date(),
        // });

        $("#form-edit-reimbursement").find('#txt_request_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        $("#form-edit-reimbursement").find('#txt_gl_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        $("#form-edit-reimbursement").find('#txt_rate_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        $("#form-edit-reimbursement").find('#ddl_payment_term_id').change(function(e){
            let term_id = this.value;
            let addDay = parseInt(getTermValue(term_id));
            let dueDate = new Date();
            dueDate.setDate(dueDate.getDate() + addDay);
            $('#txt_due_date').datepicker('setDate', dueDate);
        });

        $("#form-edit-reimbursement").find('#select_bank_name').change(function(e){
            setAccountNumberLists();
        });

        $("#form-edit-reimbursement").find("#txt_org_id").change(function(){
            let org_id = $("#form-edit-reimbursement").find("#txt_org_id").val();
            let gl_date = $("#form-edit-reimbursement").find("#txt_gl_date").val();
            checkGlPeriod(org_id, gl_date);
        });

        $("#form-edit-reimbursement").find("#txt_gl_date").on('changeDate' , function(e) {
            let org_id = $("#form-edit-reimbursement").find("#txt_org_id").val();
            let gl_date = $("#form-edit-reimbursement").find("#txt_gl_date").val();
            checkGlPeriod(org_id, gl_date);
        });

        if(!!defaultSupplierId){
            getSupplierSites(defaultSupplierId);
        }

        $('#form-edit-reimbursement').find("txt_org_id").change(function(){
            var formId = '#form-edit-reimbursement';
            let orgId = $(formId).find("#txt_org_id").val();
            getSuppliers(orgId);
        });

        $('#form-edit-reimbursement').find("select[name='supplier_id']").change(function(){
            var formId = '#form-edit-reimbursement';
            let supplierId = $(formId).find("select[name='supplier_id'] option:selected").val();
            getSupplierSites(supplierId);
        });

        $('#form-edit-reimbursement').find("#payToEmp").change(function(e){
            let orgId = $('#form-edit-reimbursement').find("select[name='org_id'] option:selected").val();
            getSuppliers(orgId);
            if(this.checked) {
                $('#ddl_payment_method_id').val(defaultPaymentMethod).change();
                $("#txt_payment_method_id").val(defaultPaymentMethod);
            }
        });

        $('#form-edit-reimbursement').find("#notPayToEmp").change(function() {
            if(this.checked) {
                $('#ddl_payment_method_id').val('CHECK').change();
                $("#txt_payment_method_id").val('CHECK');
            }
        });

        /////////////////////////////
        // EDIT REIM FORM EVENT AND FUNCTION
        $("#form-edit-reimbursement").submit(function(e){
            e.preventDefault();
            e.stopPropagation();
            var form = this;
            var valid = validateBeforeSubmitREIMForm();
            if(valid){
                $(this).find("button[type='submit']").button('loading');
                form.submit();
            }
        });

        function validateBeforeSubmitREIMForm()
        {
            var formId = '#form-edit-reimbursement';

            $(formId).find("#txt_invoice_no").next("div.error_msg").remove();
            $(formId).find("#txt_invoice_no").removeClass('err_validate');
            $(formId).find("textarea[name='purpose']").next("div.error_msg").remove();
            $(formId).find("textarea[name='purpose']").removeClass('err_validate');
            $(formId).find("textarea[name='reason']").next("div.error_msg").remove();
            $(formId).find("textarea[name='reason']").removeClass('err_validate');
            $(formId).find("select[name='supplier_id']").next("div.error_msg").remove();
            $(formId).find("select[name='supplier_id']").removeClass('err_validate');
            $(formId).find("select[name='supplier_site_id']").next("div.error_msg").remove();
            $(formId).find("select[name='supplier_site_id']").removeClass('err_validate');

            $(formId).find("#txt_tel").next("div.error_msg").remove();
            $(formId).find("#txt_tel").removeClass('err_validate');
            $(formId).find("#txt_request_date").next("div.error_msg").remove();
            $(formId).find("#txt_request_date").removeClass('err_validate');
            $(formId).find("#txt_gl_date").next("div.error_msg").remove();
            $(formId).find("#txt_gl_date").removeClass('err_validate');

            $(formId).find("#txt_org_id").next("div.error_msg").remove();
            $(formId).find("#txt_org_id").removeClass('err_validate');
            // $(formId).find("#txt_due_date").next("div.error_msg").remove();
            // $(formId).find("#txt_due_date").removeClass('err_validate');
            $(formId).find("#txt_rate_date").next("div.error_msg").remove();
            $(formId).find("#txt_rate_date").removeClass('err_validate');
            $(formId).find("#txt_payment_method_id").next("div.error_msg").remove();
            $(formId).find("#txt_payment_method_id").removeClass('err_validate');
            // $(formId).find("#ddl_payment_term_id").next("div.error_msg").remove();
            // $(formId).find("#ddl_payment_term_id").removeClass('err_validate');
            $(formId).find("#txt_exchange_rate").next("div.error_msg").remove();
            $(formId).find("#txt_exchange_rate").removeClass('err_validate');
            $(formId).find("#ddl_reimbursement_type").parent().next("div.error_msg").remove();
            $(formId).find("#ddl_reimbursement_type").removeClass('err_validate');

            var valid = true;
            var invoice_no = $(formId).find("#txt_invoice_no").val();
            var purpose = $(formId).find("textarea[name='purpose']").val();
            var reason = $(formId).find("textarea[name='reason']").val();
            var supplier_id = $(formId).find("select[name='supplier_id']").val();
            var supplier_site_id = $(formId).find("select[name='supplier_site_id']").val();

            var requestDate = $(formId).find("#txt_request_date").val();
            var glDate = $(formId).find("#txt_gl_date").val();
            var tel = $(formId).find("#txt_tel").val();
            var org_id = $(formId).find("#txt_org_id").val();
            // var dueDate = $(formId).find('#txt_due_date').val();
            var paymentMethodId = $(formId).find("#txt_payment_method_id").val();
            // var paymentTermId = $(formId).find("#ddl_payment_term_id").val();
            var currencyId= $(formId).find("#ddl_currency_id").val();
            var exchangeRate = $(formId).find("#txt_exchange_rate").val();
            var rateDate = $(formId).find("#txt_rate_date").val();
            var reimbursementType = $("#ddl_reimbursement_type").val();

            if(!invoice_no){
                valid = false;
                $(formId).find("#txt_invoice_no").addClass('err_validate');
                $(formId).find("#txt_invoice_no").after('<div class="error_msg"> กรุณาระบุเลขที่ใบแจ้งหนี้</div>');
            }

            if(!purpose){
                valid = false;
                $(formId).find("textarea[name='purpose']").addClass('err_validate');
                $(formId).find("textarea[name='purpose']").after('<div class="error_msg"> กรุณาระบุวัตถุประสงค์</div>');
            }

            if(!reason){
                valid = false;
                $(formId).find("textarea[name='reason']").addClass('err_validate');
                $(formId).find("textarea[name='reason']").after('<div class="error_msg"> กรุณาระบุเหตุผลและความจำเป็น</div>');
            }

            if(!supplier_id){
                valid = false;
                $(formId).find("select[name='supplier_id']").addClass('err_validate');
                $(formId).find("select[name='supplier_id']").after('<div class="error_msg"> กรุณาระบุผู้จัดขาย</div>');
            }

            if(!supplier_site_id){
                valid = false;
                $(formId).find("select[name='supplier_site_id']").addClass('err_validate');
                $(formId).find("select[name='supplier_site_id']").after('<div class="error_msg"> กรุณาระบุสาขาผู้ขาย</div>');
            }

            if(!org_id){
                valid = false;
                $(formId).find("#txt_org_id").addClass('err_validate');
                $(formId).find("#txt_org_id").after('<div class="error_msg"> กรุณาระบุสถานที่ปฏิบัติการ</div>');
            }

            if(!requestDate){
                valid = false;
                $(formId).find("#txt_request_date").addClass('err_validate');
                $(formId).find("#txt_request_date").after('<div class="error_msg"> กรุณาระบุวันที่ใบแจ้งหนี้</div>');
            }

            if(!glDate){
                valid = false;
                $(formId).find("#txt_gl_date").addClass('err_validate');
                $(formId).find("#txt_gl_date").after('<div class="error_msg"> กรุณาระบุวันที่บันทึกบัญชี</div>');
            }

            if(!tel){
                valid = false;
                $(formId).find("#txt_tel").addClass('err_validate');
                $(formId).find("#txt_tel").after('<div class="error_msg"> กรุณาระบุเบอร์โทร</div>');
            }else {
                if(!$.isNumeric(tel)){
                    valid = false;
                    $(formId).find("#txt_tel").addClass('err_validate');
                    $(formId).find("#txt_tel").after('<div class="error_msg"> กรุณาระบุเบอร์โทรเป็นหมายเลข</div>');
                }
            }

            // if(!dueDate){
            //     valid = false;
            //     $(formId).find("#txt_due_date").addClass('err_validate');
            //     $(formId).find("#txt_due_date").after('<div class="error_msg"> due date is required.</div>');
            // }

            if(!paymentMethodId){
                valid = false;
                $(formId).find("#txt_payment_method_id").addClass('err_validate');
                $(formId).find("#txt_payment_method_id").after('<div class="error_msg"> กรุณาระบุวิธีการชำระเงิน</div>');
            }

            if(!reimbursementType){
                valid = false;
                $(formId).find("#ddl_reimbursement_type").addClass('err_validate');
                $(formId).find("#ddl_reimbursement_type").after('<div class="error_msg"> กรุณาระบุประเภทการเบิก</div>');
            }

            // if(!paymentTermId){
            //     valid = false;
            //     $(formId).find("#ddl_payment_term_id").addClass('err_validate');
            //     $(formId).find("#ddl_payment_term_id").after('<div class="error_msg"> payment term is required.</div>');
            // }

            if(currencyId != 'THB'){
                if(!exchangeRate){
                    valid = false;
                    $(formId).find("#txt_exchange_rate").addClass('err_validate');
                    $(formId).find("#txt_exchange_rate").after('<div class="error_msg"> กรุณาระบุอัตราแลกเปลี่ยน</div>');
                }
                if(!rateDate){
                    valid = false;
                    $(formId).find("#txt_rate_date").addClass('err_validate');
                    $(formId).find("#txt_rate_date").after('<div class="error_msg"> กรุณาระบุวันที่แลกเปลี่ยน</div>');
                }
            }

            if(!validGL){
                valid = false;
                
                $(formId).find("#txt_gl_date").addClass('err_validate');
                $(formId).find("#txt_gl_date").after('<div class="error_msg"> GL & AP Period Status Is Closing, please contact administrator to solve this issue. </div>');
            }

            return valid;
        }

        function getSuppliers(orgId)
        {
            var formId = '#form-edit-reimbursement';
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/get_suppliers",
                type: 'GET',
                data: {org_id: orgId},
                beforeSend: function( xhr ) {
                    $(formId).find("select[name='supplier_id']").prop("disabled", true);
                    $(formId).find("select[name='supplier_site_id']").prop("disabled", true);
                    $(formId).find("#btn-submit-edit-reim").attr('disabled','');
                }
            })
            .done(function(result) {
                $(formId).find("#div_detail_supplier_bank").html('');
                $(formId).find("#div_ddl_supplier_id").html(result);
                $(formId).find("select[name='supplier_id']").select2({width: "100%"});
                $(formId).find("#btn-submit-edit-reim").removeAttr('disabled');
            })
            .then(function(){
                let supplierId = $(formId).find("select[name='supplier_id'] option:selected").val();
                getSupplierSites(supplierId);
            });
        }

        function getSupplierSites(supplierId)
        {
            var formId = '#form-edit-reimbursement';
            let orgId = $(formId).find("#txt_org_id").val();
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/get_supplier_sites",
                type: 'GET',
                data: {supplier_id: supplierId,
                        org_id: orgId},
                beforeSend: function( xhr ) {
                    $(formId).find("#div_detail_supplier_bank").html('');
                    $(formId).find("select[name='supplier_site_id']").prop("disabled", true);
                    $(formId).find("#btn-submit-edit-reim").attr('disabled','');
                }
            })
            .done(function(result) {
                $(formId).find("#div_ddl_supplier_site_id").html(result);
                $(formId).find("select[name='supplier_site_id']").select2({width: "100%"});
                $(formId).find("#btn-submit-edit-reim").removeAttr('disabled');
            })
            .then(() => {
                if(defaultSupplierSiteId){
                    $(formId).find("select[name='supplier_site_id']").val(defaultSupplierSiteId).trigger('change');
                    defaultSupplierSiteId = null;
                }
            })
            .then(() => {
                let supplierSiteId = $(formId).find("select[name='supplier_site_id'] option:selected").val();
                if(supplierSiteId){
                    getSupplierBankDetail(supplierId, supplierSiteId);
                }
            });
        }
        
        function getSupplierBankDetail(supplierId, supplierSiteId)
        {
            var formId = '#form-edit-reimbursement';
            let orgId = $(formId).find("select[name='org_id'] option:selected").val();
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/get_supplier_bank_detail",
                type: 'GET',
                data: {supplier_id: supplierId,
                        supplier_site_id: supplierSiteId,
                        org_id: orgId},
                beforeSend: function( xhr ) {
                    $(formId).find("#div_detail_supplier_bank").html('');
                    $(formId).find("select[name='supplier_id']").prop("disabled", true);
                    $(formId).find("select[name='supplier_site_id']").prop("disabled", true);
                }
            })
            .done(function(result) {
                $(formId).find("#div_detail_supplier_bank").html(result);
                $(formId).find("select[name='supplier_id']").prop("disabled", false);
                $(formId).find("select[name='supplier_site_id']").prop("disabled", false);
            });
        }

        $('#form-edit-reimbursement').find("select[name='username']").change(function(){
            var formId = '#form-edit-reimbursement';
            var requesterId = $(formId).find("select[name='username'] option:selected").val();
            getRequesterData(requesterId);
        });

        function getRequesterData(requesterId)
        {
            var formId = '#form-edit-reimbursement';
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/get_requester_data",
                type: 'GET',
                data: {requester_id: requesterId},
                beforeSend: function( xhr ) {
                    $(formId).find("select[name='username']").prop("disabled", true);
                }
            })
            .done(function(result) {
                $(formId).find("select[name='username']").prop("disabled", false);
                setBankLists(result.requester);
                setDataRequester(result.requester);
                // setEmployees(result.employees);
            }).then(()=>{
                setAccountNumberLists();
            }).then(()=>{
                $(formId).find(".select2").select2({width: "100%"});
            }).then(()=>{
                $(formId).find('#txt_account_no').val(defaultBankAccount);
                $(formId).find('#select_account_no').val(defaultBankAccount).change();
            });
        }

        function setBankLists(data)
        {
            let formId = "#form-edit-reimbursement";
            accountLists = data.user_accounts;
            let dataSet = [];
            if(accountLists.length){
                accountLists.forEach(element => {
                    if(element.default_flag == '1' || accountLists.length == 1){
                        defaultBank = element.bank_name;
                        defaultBankAccount = element.account_number;
                    }
                    dataSet.push({
                        id : element.bank_name,
                        text : element.bank_name
                    });
                });

                const result = [];
                const map = new Map();
                for (const item of dataSet) {
                    if(!map.has(item.id)){
                        map.set(item.id, true);    // set any value to Map
                        result.push({
                            id: item.id,
                            text: item.text
                        });
                    }
                }

                $(formId).find('#select_bank_name').html('').select2({data: result});
                $(formId).find('#txt_bank_name').val(defaultBank);
                $(formId).find('#select_bank_name').val(defaultBank).change();
                $(formId).find('#select_account_no').html('').select2({data: [{id: '', text: '-'}]});
            }else {
                $(formId).find('#select_bank_name').html('').select2({data: [{id: '', text: '-'}]});
                $(formId).find('#select_account_no').html('').select2({data: [{id: '', text: '-'}]});
            }
        }

        function setAccountNumberLists(value = false)
        {
            let formId = "#form-edit-reimbursement";
            let selectedBank = $(formId).find('#select_bank_name').val();
            let dataSet = [];
            accountLists.forEach(element => {
                if(selectedBank == element.bank_name ){
                    dataSet.push({
                        id : element.account_number,
                        text : element.account_number
                    });
                }
            });
            if(dataSet.length){
                $(formId).find('#select_account_no').html('').select2({data: dataSet});
            }else {
                $(formId).find('#select_account_no').html('').select2({data: [{id: '', text: '-'}]});
            }
            if(value){
                $(formId).find('#txt_account_no').val(value);
                $(formId).find('#select_account_no').val(value).trigger('change');
            }else {
                let accountNumber = $(formId).find("select[name='account_no'] option:selected").val();
                setAccountName(accountNumber);
            }
        }

        $("#form-edit-reimbursement").find("select[name='account_no']").change(function(){
            let formId = "#form-edit-reimbursement";
            let accountNumber = $(formId).find("select[name='account_no'] option:selected").val();
            setAccountName(accountNumber);
        });

        function setAccountName(accountNumber)
        {
            let formId = "#form-edit-reimbursement";
            let accountName = null;
            if(accountLists.length){
                const found = accountLists.find(element => element.account_number == accountNumber);
                accountName = found ? found.account_name : null;
            }
            $(formId).find('#p_account_name').html(accountName);
            $(formId).find('#txt_account_name').val(accountName);
        }

        function setDataRequester(data)
        {
            let formId = "#form-edit-reimbursement";
            // let bankName = data.pn_master ? data.pn_master.prmf_bank_code : '-';
            // $('#p_bank_name').html(bankName);
            // $('#select_bank_name').val(bankName);

            let requesterId = data.username ? data.username : '-';
            $(formId).find('#p_requester_id').html(requesterId);
            $(formId).find('#txt_requester_id').val(requesterId);

            // let bankAccountNo = data.pn_master ? data.pn_master.prmf_bankacc : '-';
            // $(formId).find('#p_account_no').html(bankAccountNo);
            // $(formId).find('#select_account_no').val(bankAccountNo);

            let positionName = data.personal_dept_location ? data.personal_dept_location.pos_name : '-';
            $(formId).find('#p_position_name').html(positionName);
            $(formId).find('#txt_position_name').val(positionName);

            let departmentCode = data.personal_dept_location ? data.personal_dept_location.dept_cd_f02 : '-';
            let departmentDescription = data.personal_dept_location ? (data.personal_dept_location.department ? data.personal_dept_location.department.flex_value+' : '+data.personal_dept_location.department.description : '-') : '-';
            $(formId).find('#p_department_code').html(departmentDescription);
            $(formId).find('#txt_department_code').val(departmentCode);
        }

        function setEmployees(html)
        {
            $('#form-edit-reimbursement').find("#div_employee_id").html(html);
        }

        $('#form-edit-reimbursement').find("select[name='currency_id']").change(function(){
            var formId = '#form-edit-reimbursement';
            var currencyId = $(formId).find("select[name='currency_id'] option:selected").val();
            toggleShowExchageRate(currencyId);
        });

        function toggleShowExchageRate(val)
        {
            let formId = "#form-edit-reimbursement";
            if(val == 'THB'){
                $(formId).find('#div_exchange_rate').addClass('d-none');
            }else {
                $(formId).find('#div_exchange_rate').removeClass('d-none');
            }
        }

        function getTermValue(term_id) 
        {
            var array = APPaymentTerms;
            if(term_id != ''){
                for(i in array) {
                    if(array[i].payment_term_id == term_id) {
                        return array[i].due_days;
                    }
                }
            }
            return 0;
        };

        function checkGlPeriod(org_id, date)
        {
            var formId = '#form-edit-reimbursement'
            $(formId).find("#txt_gl_date").next("div.error_msg").remove();
            $(formId).find("#txt_gl_date").removeClass('err_validate');

            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/check_gl_period",
                type: 'GET',
                data: {
                    org_id: org_id,
                    date: date
                },
                beforeSend: function( xhr ) {
                }
            })
            .done(function(result) {
                if(result.status == 'E'){
                    validGL = false;
                    $(formId).find("#txt_gl_date").addClass('err_validate');
                    $(formId).find("#txt_gl_date").after('<div class="error_msg">' +result.msg+'</div>');
                }else {
                    validGL = true;
                }
            }).then(()=>{

            });
        }

    });

</script>