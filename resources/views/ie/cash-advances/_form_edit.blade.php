<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Advance Type (ประเภทการยืม) <span class="text-danger">*</span></div>
        </label>
        <select name="advance_type" class='form-control select2' id='ddl_advance_type' disabled>
            <option value="ในประเทศ" {{ $cashAdvance->advance_type == 'ในประเทศ' ? 'selected' : '' }}>ในประเทศ</option>
            <option value="ต่างประเทศ" {{ $cashAdvance->advance_type == 'ต่างประเทศ' ? 'selected' : '' }}>ต่างประเทศ</option>
        </select>
        {!! Form::hidden('advance_type', $cashAdvance->advance_type, ["id" => 'txt_advance_type']) !!}
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <input name="pay_to_emp" value="YES" type="radio" id="payToEmp" {{ $cashAdvance->pay_to_emp == 'YES' ? 'checked' : '' }}> 
                <label for="payToEmp" style="display: inline;">Transfer (เงินโอน)</label>
            </div>
            <div class="col-md-6">
                <input name="pay_to_emp" value="NO" type="radio" id="notPayToEmp" {{ $cashAdvance->pay_to_emp == 'NO' ? 'checked' : '' }}> 
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
        @if ($cashAdvance->canImportantEditData() && !$cashAdvance->receipts()->count())
            {!! Form::select('username', $employeeLists, optional($requester)->username, ["class" => 'form-control select2', "id" => 'txt_username', "autocomplete" => "off"]) !!}
        @else
            {!! Form::select('username', $employeeLists, optional($requester)->username, ["class" => 'form-control select2', "id" => 'txt_username', "autocomplete" => "off", "disabled"=>"disabled"]) !!}
            {!! Form::hidden('username', optional($requester)->username ?? null, ["id" => 'txt_username_hidden']) !!}
        @endif
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6" style="padding-right: 0px;">
                @if ( $receiptType === 'CLEARING' )
                    <label>
                        <div>Invoice Date (วันที่ใบแจ้งหนี้) <span class="text-danger">*</span>  </div>
                    </label>
                    {!! Form::text('clearing_request_date', $cashAdvance->clearing_request_date, ['class'=>'form-control','id'=>'txt_clearing_request_date', 'autocomplete'=>'off']) !!}
                @else 
                    <label>
                        <div>Request Date (วันที่ขอเบิก) <span class="text-danger">*</span>  </div>
                    </label>
                    {!! Form::text('request_date', $cashAdvance->request_date, ['class'=>'form-control','id'=>'txt_request_date', 'autocomplete'=>'off']) !!}
                @endif
                {{-- @if ($cashAdvance->receipts->count())
                    <div>
                        {!! $cashAdvance->request_date !!}
                        {!! Form::hidden('request_date', $cashAdvance->request_date, ['id'=>'txt_request_date']) !!}
                    </div>
                @else
                {!! Form::text('request_date', $cashAdvance->request_date, ['class'=>'form-control','id'=>'txt_request_date', 'autocomplete'=>'off']) !!}
                @endif --}}
            </div>
            <div class="col-md-6">
                @if ( $receiptType === 'CLEARING' )
                    <label>
                        <div>GL Date (วันที่บันทึกบัญชี) <span class="text-danger">*</span> </div>
                    </label>
                    {!! Form::text('clearing_gl_date', $cashAdvance->clearing_gl_date, ['class'=>'form-control','id'=>'txt_clearing_gl_date', 'autocomplete'=>'off']) !!}
                @else 
                    <label>
                        <div>GL Date (วันที่บันทึกบัญชี) <span class="text-danger">*</span> </div>
                    </label>
                    {!! Form::text('gl_date', $cashAdvance->gl_date, ['class'=>'form-control','id'=>'txt_gl_date', 'autocomplete'=>'off']) !!}
                @endif
                
                {{-- @if ($cashAdvance->receipts->count())
                    <div>
                        {!! $cashAdvance->gl_date !!}
                        {!! Form::hidden('gl_date', $cashAdvance->gl_date, ['id'=>'txt_gl_date']) !!}
                    </div>
                @else
                {!! Form::text('gl_date', $cashAdvance->gl_date, ['class'=>'form-control','id'=>'txt_gl_date', 'autocomplete'=>'off']) !!}
                @endif --}}
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
                    {{ $requester->PersonalDeptLocation ? optional(optional($requester)->PersonalDeptLocation)->dept_cd_f02 .' : '.optional(optional(optional($requester)->PersonalDeptLocation)->department)->description : '-' }}
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
        {{-- @if ($cashAdvance->receipts->count())
            {!! $ouLists[$cashAdvance->org_id] !!}
            {!! Form::hidden('org_id', $cashAdvance->org_id, ["id" => 'txt_org_id']) !!}
        @else
            {!! Form::select('org_id', $ouLists, $cashAdvance->org_id, ["class" => 'form-control select2', "id" => 'txt_org_id', "autocomplete" => "off"]) !!}
        @endif --}}
        {!! Form::select('org_id', $ouLists, $cashAdvance->org_id, ["class" => 'form-control select2', "autocomplete" => "off","disabled"=>"disabled"]) !!}
        {!! Form::hidden('org_id', $cashAdvance->org_id, ["id" => 'txt_org_id']) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Tel (โทร) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('tel', $cashAdvance->tel, ['class'=>'form-control', 'id'=>'txt_tel', 'autocomplete'=>'off', 'maxlength'=> '10']) !!}
    </div>
</div>

<div class="hr-line-dashed m-t-sm m-b-sm"></div>

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
        {!! Form::select('payment_method_id', [''=>'-'] + $APPaymentMethodLists, $cashAdvance->payment_method_id,['class'=>'form-control select2',"id" =>'ddl_payment_method_id','disabled'=>'disabled']) !!}
        {!! Form::hidden('payment_method_id', $cashAdvance->payment_method_id, ["id" => 'txt_payment_method_id']) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Need by Date (วันที่ต้องการรับเงิน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('need_by_date', $cashAdvance->need_by_date, ['class'=>'form-control','id'=>'txt_need_by_date', "autocomplete" => "off"]) !!}
    </div>
</div>

<div class="row m-b-sm">
    <div class="col-md-6">
        <label>
            <div>Finish Date (วันที่ครบกำหนดแล้วเสร็จ) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('finish_date', $cashAdvance->finish_date, ['class'=>'form-control','id'=>'txt_finish_date', "autocomplete" => "off"]) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Currency (สกุลเงิน) <span class="text-danger">*</span></div>
        </label>
        @if ($cashAdvance->receipts->count())
            <div>
                {!! $cashAdvance->currency_id!!}
                {!! Form::hidden('currency_id', $cashAdvance->currency_id, ["id" => 'ddl_currency_id']) !!}
            </div>
        @else
            {!! Form::select('currency_id', [''=>'-'] + $currencyLists, $cashAdvance->currency_id,['class'=>'form-control select2','id'=>'ddl_currency_id']) !!}
        @endif
    </div>
</div>

<div class="row m-b-sm d-none" id="div_exchange_rate">
    <div class="col-md-6">
        <label>
            <div>Exchange Rate (อัตราแลกเปลี่ยน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('exchange_rate', $cashAdvance->exchange_rate, ['class'=>'form-control','id'=>'txt_exchange_rate', 'autocomplete'=>'off']) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Rate Date (วันที่แลกเปลี่ยน) <span class="text-danger">*</span></div>
        </label>
        {!! Form::text('rate_date', $cashAdvance->rate_date, ['class'=>'form-control','id'=>'txt_rate_date', 'autocomplete'=>'off']) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>
            <div>Purpose (วัตถุประสงค์) <span class="text-danger">*</span></div>
        </label>
        {!! Form::select('purpose', ['' => '-']+$purposeLists, $cashAdvance->purpose, ["class" => 'form-control select2', "id" => 'select_purpose', "autocomplete" => "off"]) !!}
        {{-- {!! Form::textArea('purpose', $cashAdvance->purpose , ["class" => 'form-control', "autocomplete" => "off", "rows" => "4", "maxlength"=>"250"]) !!} --}}
    </div>
    <div class="col-md-6">
        <label>
            <div>Reason (เหตุผลและความจำเป็น) <span class="text-danger">*</span></div>
        </label>
        {!! Form::textArea('reason', $cashAdvance->reason , ["class" => 'form-control', "autocomplete" => "off", "rows" => "2", "maxlength"=>"250"]) !!}
    </div>
</div>

<div class="hr-line-dashed m-t-md m-b-md"></div>
<h3>Report <span style="font-size: 12px; color: darkgray; font-weight: normal;">( ใช้ในการออกรายงาน Invoice Register / ใบขออนุมัติหลักการใช้งบประมาณ )</span></h3>
<div class="row">
    <div class="col-md-6">
        <label>
            <div>Checked By (ผู้ตรวจสอบ)</div>
        </label>
        {!! Form::select('checked_by', ['' => '-']+$employeeLists, $cashAdvance->checked_by, ["class" => 'form-control select2', "id" => 'txt_checked_by', "autocomplete" => "off"]) !!}
    </div>
    <div class="col-md-6">
        <label>
            <div>Approved By (ผู้อนุมัติ)</div>
        </label>
        {!! Form::select('approved_by', ['' => '-']+$employeeLists, $cashAdvance->approved_by, ["class" => 'form-control select2', "id" => 'txt_approved_by', "autocomplete" => "off"]) !!}
    </div>
</div>

{{-- FORM INFORMATIONS --}}
<div class="row" id="div_form_informations">

    @include('ie.cash-advances._form_informations')
    
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
        var currencyId = "{{ $cashAdvance->currency_id }}";
        var create_date = "{{ $cashAdvance->creation_date }}";
        var receiptType = "{{ $receiptType }}";
        var validGL = true;

        setAccountNumberLists(defaultAccountNo);

        toggleShowExchageRate(currencyId);

        $('#form-edit-cash-advance').find(".select2").select2({width: "100%"});

        $('#form-edit-cash-advance').find('#txt_need_by_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked",
            startDate: new Date(create_date),
        }).on('changeDate', function(e) {
            // `e` here contains the extra attributes
            let finishDate = new Date(e.date);
            finishDate.setDate(e.date.getDate() + 15);
            $('#form-edit-cash-advance').find('#txt_finish_date').datepicker('setDate', finishDate);
        });
        
        $('#form-edit-cash-advance').find('#txt_request_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked",
            startDate: new Date(create_date),
        });

        $('#form-edit-cash-advance').find('#txt_gl_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        $('#form-edit-cash-advance').find('#txt_clearing_request_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked",
            startDate: new Date(create_date),
        });

        $('#form-edit-cash-advance').find('#txt_clearing_gl_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        $('#form-edit-cash-advance').find('#txt_finish_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked",
            startDate: new Date(create_date),
        });

        // $('#form-edit-cash-advance').find('#txt_due_date').datepicker({
        //     format: 'dd/mm/yyyy',
        //     todayBtn: true,
        //     multidate: false,
        //     keyboardNavigation: false,
        //     autoclose: true,
        //     todayBtn: "linked",
        //     startDate : new Date(),
        // });

        $('#form-edit-cash-advance').find('#txt_rate_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        $('#form-edit-cash-advance').find('#ddl_payment_term_id').change(function(e){
            let term_id = this.value;
            let addDay = parseInt(getTermValue(term_id));
            let dueDate = new Date();
            dueDate.setDate(dueDate.getDate() + addDay);
            $('#form-edit-cash-advance').find('#txt_due_date').datepicker('setDate', dueDate);
        });

        $('#form-edit-cash-advance').find('#select_bank_name').change(function(e){
            setAccountNumberLists();
        });

        $('#form-edit-cash-advance').find("#txt_org_id").change(function(){
            let org_id = $('#form-edit-cash-advance').find("#txt_org_id").val();
            let gl_date = $('#form-edit-cash-advance').find("#txt_gl_date").val();
            checkGlPeriod(org_id, gl_date);
        });

        $('#form-edit-cash-advance').find("#txt_gl_date").on('changeDate' , function(e) {
            let org_id = $('#form-edit-cash-advance').find("#txt_org_id").val();
            let gl_date = $('#form-edit-cash-advance').find("#txt_gl_date").val();
            checkGlPeriod(org_id, gl_date);
        });

        if(!!defaultSupplierId){
            getSupplierSites(defaultSupplierId);
        }

        $('#form-edit-cash-advance').find("#txt_org_id").change(function(){
            var formId = '#form-edit-cash-advance';
            let orgId = $(formId).find("#txt_org_id").val();
            getSuppliers(orgId);
        });

        $('#form-edit-cash-advance').find("select[name='supplier_id']").change(function(){
            var formId = '#form-edit-cash-advance';
            let supplierId = $(formId).find("select[name='supplier_id'] option:selected").val();
            getSupplierSites(supplierId);
        });

        $('#form-edit-cash-advance').find("select[name='supplier_id']").change(function(){
            var formId = '#form-edit-cash-advance';
            var supplierId = $(formId).find("select[name='supplier_id'] option:selected").val();
            getSupplierSites(supplierId);
        });

        $('#form-edit-cash-advance').find("#payToEmp").change(function(e){
            var formId = '#form-edit-cash-advance';
            let orgId = $(formId).find("#txt_org_id").val();
            getSuppliers(orgId);
        });

        /////////////////////////////
        // EDIT REIM FORM EVENT AND FUNCTION
        $('#form-edit-cash-advance').submit(function(e){
            e.preventDefault();
            e.stopPropagation();
            var form = this;
            var valid = validateBeforeSubmitCAForm();
            if(valid){
                $(this).find("button[type='submit']").button('loading');
                form.submit();
            }
        });

        function validateBeforeSubmitCAForm()
        {
            var formId = '#form-edit-cash-advance';
            // $(formId).find("input[name='amount']").parent().next("div.error_msg").remove();
            // $(formId).find("input[name='amount']").removeClass('err_validate');
            $(formId).find("input[name='need_by_date']").next("div.error_msg").remove();
            $(formId).find("input[name='need_by_date']").removeClass('err_validate');
            $(formId).find("select[name='purpose']").next("div.error_msg").remove();
            $(formId).find("select[name='purpose']").removeClass('err_validate');
            $(formId).find("textarea[name='reason']").next("div.error_msg").remove();
            $(formId).find("textarea[name='reason']").removeClass('err_validate');
            $(formId).find("select[name='supplier_id']").next("div.error_msg").remove();
            $(formId).find("select[name='supplier_id']").removeClass('err_validate');
            $(formId).find("select[name='supplier_site_id']").next("div.error_msg").remove();
            $(formId).find("select[name='supplier_site_id']").removeClass('err_validate');

            $(formId).find("#txt_tel").next("div.error_msg").remove();
            $(formId).find("#txt_tel").removeClass('err_validate');
            if(receiptType == 'CLEARING'){
                $(formId).find("#txt_clearing_request_date").next("div.error_msg").remove();
                $(formId).find("#txt_clearing_request_date").removeClass('err_validate');
                $(formId).find("#txt_clearing_gl_date").next("div.error_msg").remove();
                $(formId).find("#txt_clearing_gl_date").removeClass('err_validate');
            }else {
                $(formId).find("#txt_request_date").next("div.error_msg").remove();
                $(formId).find("#txt_request_date").removeClass('err_validate');
                $(formId).find("#txt_gl_date").next("div.error_msg").remove();
                $(formId).find("#txt_gl_date").removeClass('err_validate');
            }

            $(formId).find("#txt_org_id").next("div.error_msg").remove();
            $(formId).find("#txt_org_id").removeClass('err_validate');
            $(formId).find("#txt_finish_date").next("div.error_msg").remove();
            $(formId).find("#txt_finish_date").removeClass('err_validate');
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
            $(formId).find("#ddl_advance_type").parent().next("div.error_msg").remove();
            $(formId).find("#ddl_advance_type").removeClass('err_validate');

            var valid = true;
            // var amount = $(formId).find("input[name='amount']").val();
            var need_by_date = $(formId).find("input[name='need_by_date']").val();
            var purpose = $(formId).find("select[name='purpose']").val();
            var reason = $(formId).find("textarea[name='reason']").val();
            var supplier_id = $(formId).find("select[name='supplier_id']").val();
            var supplier_site_id = $(formId).find("select[name='supplier_site_id']").val();

            if(receiptType == 'CLEARING'){
                var clearRequestDate = $(formId).find("#txt_clearing_request_date").val();
                var clearGlDate = $(formId).find("#txt_clearing_gl_date").val();
            }else {
                
                var requestDate = $(formId).find("#txt_request_date").val();
                var glDate = $(formId).find("#txt_gl_date").val();
            }
            var tel = $(formId).find("#txt_tel").val();
            var org_id = $(formId).find("#txt_org_id").val();
            var finishDate = $('#txt_finish_date').val();
            // var dueDate = $(formId).find('#txt_due_date').val();
            var paymentMethodId = $(formId).find("#txt_payment_method_id").val();
            // var paymentTermId = $(formId).find("#ddl_payment_term_id").val();
            var currencyId= $(formId).find("#ddl_currency_id").val();
            var exchangeRate = $(formId).find("#txt_exchange_rate").val();
            var rateDate = $(formId).find("#txt_rate_date").val();
            var advanceType = $("#ddl_advance_type").val();

            // if(!$.isNumeric(amount)){
            //     valid = false;
            //     $(formId).find("input[name='amount']").addClass('err_validate');
            //     $(formId).find("input[name='amount']").parent().after('<div class="error_msg"> amount is invalid. </div>');
            // }else{
            //     if(parseFloat(amount) <= 0){
            //         valid = false;
            //         $(formId).find("input[name='amount']").addClass('err_validate');
            //         $(formId).find("input[name='amount']").parent().after('<div class="error_msg"> amount must be greater than zero. </div>');
            //     }
            // }
            if(!need_by_date){
                valid = false;
                $(formId).find("input[name='need_by_date']").addClass('err_validate');
                $(formId).find("input[name='need_by_date']").after('<div class="error_msg"> กรุณาระบุวันที่ต้องการรับเงิน</div>');
            }
            if(!purpose){
                valid = false;
                $(formId).find("select[name='purpose']").addClass('err_validate');
                $(formId).find("select[name='purpose']").after('<div class="error_msg"> กรุณาระบุวัตถุประสงค์</div>');
            }
            if(!reason){
                valid = false;
                $(formId).find("textarea[name='reason']").addClass('err_validate');
                $(formId).find("textarea[name='reason']").after('<div class="error_msg"> กรุณาระบุเหตุผลและความจำเป็น</div>');
            }

            if(!supplier_id){
                valid = false;
                $(formId).find("select[name='supplier_id']").addClass('err_validate');
                $(formId).find("select[name='supplier_id']").after('<div class="error_msg"> กรุณาระบุผู้ขาย</div>');
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

            if(receiptType == 'CLEARING'){

                if(!clearRequestDate){
                    valid = false;
                    $(formId).find("#txt_clearing_request_date").addClass('err_validate');
                    $(formId).find("#txt_clearing_request_date").after('<div class="error_msg"> วันที่ใบแจ้งหนี้</div>');
                }

                if(!clearGlDate){
                    valid = false;
                    $(formId).find("#txt_clearing_gl_date").addClass('err_validate');
                    $(formId).find("#txt_clearing_gl_date").after('<div class="error_msg"> กรุณาระบุวันที่บันทึกบัญชี</div>');
                }
            }else {
                
                if(!requestDate){
                    valid = false;
                    $(formId).find("#txt_request_date").addClass('err_validate');
                    $(formId).find("#txt_request_date").after('<div class="error_msg"> กรุณาระบุวันที่ขอเบิก</div>');
                }

                if(!glDate){
                    valid = false;
                    $(formId).find("#txt_gl_date").addClass('err_validate');
                    $(formId).find("#txt_gl_date").after('<div class="error_msg"> กรุณาระบุวันที่บันทึกบัญชี</div>');
                }
            }

            if(!finishDate){
                valid = false;
                $(formId).find("#txt_finish_date").addClass('err_validate');
                $(formId).find("#txt_finish_date").after('<div class="error_msg"> กรุณาระบุวันที่ครบกำหนดแล้วเสร็จ</div>');
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

            if(!advanceType){
                valid = false;
                $(formId).find("#ddl_advance_type").addClass('err_validate');
                $(formId).find("#ddl_advance_type").after('<div class="error_msg"> กรุณาระบุประเภทการยืม</div>');
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
        var formId = '#form-edit-cash-advance';
            $.ajax({
                url: "{{ url('/') }}/ie/cash-advances/get_suppliers",
                type: 'GET',
                data: {org_id: orgId},
                beforeSend: function( xhr ) {
                    $(formId).find("select[name='supplier_id']").prop("disabled", true);
                    $(formId).find("select[name='supplier_site_id']").prop("disabled", true);
                }
            })
            .done(function(result) {
                $(formId).find("#div_detail_supplier_bank").html('');
                $(formId).find("#div_ddl_supplier_id").html(result);
                $(formId).find("select[name='supplier_id']").select2({width: "100%"});
            })
            .then(function(){
                let supplierId = $(formId).find("select[name='supplier_id'] option:selected").val();
                getSupplierSites(supplierId);
            });
        }

        function getSupplierSites(supplierId)
        {
            var formId = '#form-edit-cash-advance';
            let orgId = $(formId).find("#txt_org_id").val();
            $.ajax({
                url: "{{ url('/') }}/ie/cash-advances/get_supplier_sites",
                type: 'GET',
                data: {supplier_id: supplierId,
                        org_id: orgId},
                beforeSend: function( xhr ) {
                    $(formId).find("#div_detail_supplier_bank").html('');
                    $(formId).find("select[name='supplier_site_id']").prop("disabled", true);
                }
            })
            .done(function(result) {
                $(formId).find("#div_ddl_supplier_site_id").html(result);
                $(formId).find("select[name='supplier_site_id']").select2({width: "100%"});
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
            var formId = '#form-edit-cash-advance';
            let orgId = $(formId).find("select[name='org_id'] option:selected").val();
            $.ajax({
                url: "{{ url('/') }}/ie/cash-advances/get_supplier_bank_detail",
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

        $('#form-edit-cash-advance').find("select[name='username']").change(function(){
            var formId = '#form-edit-cash-advance';
            var requesterId = $(formId).find("select[name='username'] option:selected").val();
            getRequesterData(requesterId);
        });

        function getRequesterData(requesterId)
        {
            var formId = '#form-edit-cash-advance';
            $.ajax({
                url: "{{ url('/') }}/ie/cash-advances/get_requester_data",
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
                $(".select2").select2({width: "100%"});
            }).then(()=>{
                $(formId).find('#txt_account_no').val(defaultBankAccount);
                $(formId).find('#select_account_no').val(defaultBankAccount).change();
            });
        }

        function setBankLists(data)
        {
            let formId = '#form-edit-cash-advance';
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
            let formId = '#form-edit-cash-advance';
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

        $('#form-edit-cash-advance').find("select[name='account_no']").change(function(){
            let formId = '#form-edit-cash-advance';
            let accountNumber = $(formId).find("select[name='account_no'] option:selected").val();
            setAccountName(accountNumber);
        });

        function setAccountName(accountNumber)
        {
            let formId = '#form-edit-cash-advance';
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
            let formId = '#form-edit-cash-advance';
            // let bankName = data.pn_master ? data.pn_master.prmf_bank_code : '-';
            // $(formId).find('#p_bank_name').html(bankName);
            // $(formId).find('#select_bank_name').val(bankName);

            let requesterId = data.username ? data.username : '-';
            $(formId).find('#p_requester_id').html(requesterId);
            $(formId).find('#txt_requester_id').val(requesterId);

            // let bankAccountNo = data.pn_master ? data.pn_master.prmf_bankacc : '-';
            // $(formId).find('#p_account_no').html(bankAccountNo);
            // $(formId).find('#select_account_no').val(bankAccountNo);

            let positionName = data.personal_dept_location ? data.personal_dept_location.pos_name : '-';
            $(formId).find('#p_position_name').html(positionName);
            $(formId).find('#txt_position_name').val(positionName);

            let accountName = data.name ? data.name : '-';
            $(formId).find('#p_account_name').html(accountName);
            $(formId).find('#txt_account_name').val(accountName);

            let departmentCode = data.personal_dept_location ? data.personal_dept_location.dept_cd_f02 : '-';
            let departmentDescription = data.personal_dept_location ? (data.personal_dept_location.department ? data.personal_dept_location.department.flex_value+' : '+data.personal_dept_location.department.description : '-') : '-';
            $(formId).find('#p_department_code').html(departmentDescription);
            $(formId).find('#txt_department_code').val(departmentCode);
        }

        function setEmployees(html)
        {
            $('#form-edit-cash-advance').find("#div_employee_id").html(html);
        }

        $('#form-edit-cash-advance').find("select[name='currency_id']").change(function(){
            var formId = '#form-edit-cash-advance';
            var currencyId = $(formId).find("select[name='currency_id'] option:selected").val();
            toggleShowExchageRate(currencyId);
        });

        function toggleShowExchageRate(val)
        {
            if(val == 'THB'){
                $('#form-edit-cash-advance').find('#div_exchange_rate').addClass('d-none');
            }else {
                $('#form-edit-cash-advance').find('#div_exchange_rate').removeClass('d-none');
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
            var formId = '#form-edit-cash-advance';
            $(formId).find("#txt_gl_date").next("div.error_msg").remove();
            $(formId).find("#txt_gl_date").removeClass('err_validate');

            $.ajax({
                url: "{{ url('/') }}/ie/cash-advances/check_gl_period",
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