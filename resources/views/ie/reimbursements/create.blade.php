@extends('layouts.app')

@section('title', 'Reimbursements')

@section('page-title')
    <h2>
        <div><x-get-program-code url="/ie/reimbursements" /> Reimbursement : New Request</div>
        <div><small>สร้างใบเบิกเงินสำรองจ่าย / PR - TO AP ใหม่</small></div>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.reimbursements.index') }}">
                Reimbursement
            </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>
               New Request
            </strong>
        </li>
    </ol>
@stop

@section('content')
@include('layouts._warning_create_request')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        <strong>Request Form</strong>
                        <span class="pull-right">
                            <p>Request Date : {{ date(trans('date.format')) }}</p>
                        </span>
                    </div>
                </div>
                <hr class="m-t-sm mm-b-sm">
                {{-- FORM REIMBURSEMENT --}}
                {!! Form::open(['route' => ['ie.reimbursements.store'], 'id' => 'form-reimbursement','class' => 'form-horizontal']) !!}
                <div class="row">
                    <div class="col-md-9 b-r">

                        {{-- FORM REIMBURSEMENT HTML --}}
                        @include('ie.reimbursements._form')

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Attachments (ไฟล์แนบ)</label>
                                <div class="text-center dropzone m-t-xs m-b-xs" id="dropzoneFileUpload">
                                    <div class="dz-message p-sm" style="font-size: 12px;">
                                        <div>
                                            <i class="fa fa-file-text-o fa-3x"></i>
                                        </div>
                                        <div class="m-t-sm">Drop files or Click</div>
                                    </div>
                                </div>
                                <small style="color:#aaa"> Allow: jpeg, png, pdf, doc, docx, xls, xlsx, rar, zip and size < 5mb </small><br>
                                <small style="color:#aaa"> Max files : 2</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @include('ie.commons._unclear_alert_message')
                            </div>
                        </div>
                        @include('layouts._dropzone_template')
                    </div>
                </div>
                <hr class="m-t-xs m-b-sm">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                {{-- @if(\Auth::user()->isAllowCreateRequest()) --}}
                                @if(canEnter('/ie/reimbursements'))
                                    <button id="btn_submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Creating ..." type="button" class="btn btn-primary">
                                        Create
                                    </button>
                                @endif
                                <a href="{{ route('ie.reimbursements.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close()!!}
                {{-- FORM --}}
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function() {

            var defaultBank = null;
            var defaultBankAccount = null;
            var APPaymentTerms = jQuery.parseJSON(JSON.stringify({!! $APPaymentTerms->toJson() !!}));
            var accountLists = [];
            var validGL = true;
            var defaultPaymentMethod = "{!! $defaultPaymentMethod !!}";

            var formId = "#form-reimbursement";
            var requesterId = $(formId).find("select[name='username'] option:selected").val();
            getRequesterData(requesterId);

            $(formId).find(".select2").select2({width: "100%"});
            setAccountNumberLists();

            let orgId = $(formId).find("select[name='org_id'] option:selected").val();
            getSuppliers(orgId);

            $(formId).find("select[name='org_id']").change(function(){
                let orgId = $(formId).find("select[name='org_id'] option:selected").val();
                getSuppliers(orgId);
            });

            $(formId).find("select[name='supplier_id']").change(function(){
                let supplierId = $(formId).find("select[name='supplier_id'] option:selected").val();
                getSupplierSites(supplierId);
            });

            $("#btn_submit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmit();
                if(valid){
                    $(this).attr('disabled','disabled');
                    $(this).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Loading...`);
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                    } else {
                        $("#form-reimbursement").submit();
                    }
                }
            });
            
            // $('#txt_due_date').datepicker({
            //     format: 'dd/mm/yyyy',
            //     todayBtn: true,
            //     multidate: false,
            //     keyboardNavigation: false,
            //     autoclose: true,
            //     todayBtn: "linked",
            //     startDate : new Date(),
            // });

            $('#txt_request_date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });

            $('#txt_gl_date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });

            $('#txt_rate_date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });

            $('#ddl_payment_term_id').change(function(e){
                let term_id = this.value;
                let addDay = parseInt(getTermValue(term_id));
                let dueDate = new Date();
                dueDate.setDate(dueDate.getDate() + addDay);
                $('#txt_due_date').datepicker('setDate', dueDate);
            });

            $('#select_bank_name').change(function(e){
                setAccountNumberLists();
            });

            $(formId).find("#payToEmp").change(function(e){
                let orgId = $(formId).find("select[name='org_id'] option:selected").val();
                getSuppliers(orgId);
                if(this.checked) {
                    $('#ddl_payment_method_id').val(defaultPaymentMethod).change();
                    $("#txt_payment_method_id").val(defaultPaymentMethod);
                }
            });

            $(formId).find("#notPayToEmp").change(function() {
                if(this.checked) {
                    $('#ddl_payment_method_id').val('CHECK').change();
                    $("#txt_payment_method_id").val('CHECK');
                }
            });

            $(formId).find("#txt_org_id").change(function(){
                let org_id = $(formId).find("#txt_org_id").val();
                let gl_date = $(formId).find("#txt_gl_date").val();
                checkGlPeriod(org_id, gl_date);
            });

            $(formId).find("#txt_gl_date").on('changeDate' , function(e) {
                let org_id = $(formId).find("#txt_org_id").val();
                let gl_date = $(formId).find("#txt_gl_date").val();
                checkGlPeriod(org_id, gl_date);
            });

            // ==== DROPZONE ====
            var token = "{{ csrf_token() }}";
            var myDropzone = new Dropzone("div#dropzoneFileUpload", {
                previewTemplate: $('#template-container').html(),
                url: "/ie/reimbursements/store",
                params: {
                   _token: token
                },
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFiles: 2,
                maxFilesize: 5, // MB
                acceptedFiles: '.jpg, .jpeg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .7z, .txt',
                // Dropzone settings
                init: function() {
                    var myDropzone = this;
                    this.on("maxfilesexceeded", function(file) {
                        toastr.options = {
                            "timeOut": "3000",
                        }
                        toastr.error(file.name + ' upload failed.');
                    });
                    this.on('error', function(file, response) {
                        if(file){ this.removeFile(file); }
                        toastr.options = {
                            "timeOut": "3000",
                        }
                        toastr.error(response);
                    });
                    this.on('queuecomplete', function(){
                        $("#btn_submit").button('reset');
                    });
                }
            });
            myDropzone.on('sending', function(file, xhr, formData){

                formData.append('invoice_no', $("input[name='invoice_no']").val());
                formData.append('username', $("select[name='username']").val());
                formData.append('request_date', $("input[name='request_date']").val());
                formData.append('gl_date', $("input[name='gl_date']").val());
                formData.append('requester_id', $("input[name='requester_id']").val());
                formData.append('org_id', $("#txt_org_id").val());
                formData.append('bank_name', $("#txt_bank_name").val());
                formData.append('account_no', $("#txt_account_no").val());
                formData.append('account_name', $("input[name='account_name']").val());
                formData.append('position_name', $("input[name='position_name']").val());
                formData.append('department_code', $("input[name='department_code']").val());
                formData.append('employee_id', $("select[name='employee_id']").val());
                formData.append('pay_to_emp', $("input[name='pay_to_emp']:checked").val());
                formData.append('reimbursement_type', $('#ddl_reimbursement_type').val());
                formData.append('tel', $("input[name='tel']").val());

                formData.append('purpose', $("textarea[name='purpose']").val());
                formData.append('reason', $("textarea[name='reason']").val());
                formData.append('supplier_id', $("select[name='supplier_id']").val());
                formData.append('supplier_site_id', $("select[name='supplier_site_id']").val());
                formData.append('due_date', $('#txt_due_date').val());
                formData.append('payment_method_id', $("#txt_payment_method_id").val());
                formData.append('payment_term_id', $("#ddl_payment_term_id").val());
                formData.append('currency_id', $("select[name='currency_id']").val());
                formData.append('exchange_rate', $("input[name='exchange_rate']").val());
                formData.append('rate_date', $('#txt_rate_date').val());

                formData.append('checked_by', $('#txt_checked_by').val());
                formData.append('approved_by', $('#txt_approved_by').val());

            });
            myDropzone.on("success", function(file, result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    swal({
                      title: "Error !",
                      text: result.err_msg,
                      type: "error",
                      timer: 2000,
                      showConfirmButton: false
                    },function(){
                        // location.reload();
                    });
                }else{
                    $("#btn_submit").attr('disabled','disabled');
                    setTimeout(function(){
                        window.location.href = ("/ie/reimbursements/"+result.reimId);
                    }, 1000);
                }
            });

            function validateBeforeSubmit()
            {
                $("#txt_invoice_no").next("div.error_msg").remove();
                $("#txt_invoice_no").removeClass('err_validate');
                $("textarea[name='purpose']").next("div.error_msg").remove();
                $("textarea[name='purpose']").removeClass('err_validate');
                $("textarea[name='reason']").next("div.error_msg").remove();
                $("textarea[name='reason']").removeClass('err_validate');
                $("select[name='supplier_id']").next("div.error_msg").remove();
                $("select[name='supplier_id']").removeClass('err_validate');
                $("select[name='supplier_site_id']").next("div.error_msg").remove();
                $("select[name='supplier_site_id']").removeClass('err_validate');

                $("#txt_tel").next("div.error_msg").remove();
                $("#txt_tel").removeClass('err_validate');
                $("#txt_request_date").next("div.error_msg").remove();
                $("#txt_request_date").removeClass('err_validate');
                $("#txt_gl_date").next("div.error_msg").remove();
                $("#txt_gl_date").removeClass('err_validate');
                $("#txt_org_id").next("div.error_msg").remove();
                $("#txt_org_id").removeClass('err_validate');
                // $("#txt_due_date").next("div.error_msg").remove();
                // $("#txt_due_date").removeClass('err_validate');
                $("#txt_rate_date").next("div.error_msg").remove();
                $("#txt_rate_date").removeClass('err_validate');

                $("#txt_payment_method_id").next("div.error_msg").remove();
                $("#txt_payment_method_id").removeClass('err_validate');
                // $("#ddl_payment_term_id").next("div.error_msg").remove();
                // $("#ddl_payment_term_id").removeClass('err_validate');
                $("#txt_exchange_rate").next("div.error_msg").remove();
                $("#txt_exchange_rate").removeClass('err_validate');
                $("#ddl_reimbursement_type").parent().next("div.error_msg").remove();
                $("#ddl_reimbursement_type").removeClass('err_validate');

                var valid = true;
                var invoice_no = $("#txt_invoice_no").val();
                var org_id = $("select[name='org_id']").val();
                var supplier_id = $("select[name='supplier_id']").val();
                var supplier_site_id = $("select[name='supplier_site_id']").val();
                var purpose = $("textarea[name='purpose']").val();
                var reason = $("textarea[name='reason']").val();
                var requestDate = $("#txt_request_date").val();
                var glDate = $("#txt_gl_date").val();
                var tel = $("#txt_tel").val();
                // var dueDate = $('#txt_due_date').val();
                var paymentMethodId = $("#txt_payment_method_id").val();
                // var paymentTermId = $("#ddl_payment_term_id").val();
                var currencyId= $("#ddl_currency_id").val();
                var exchangeRate = $("#txt_exchange_rate").val();
                var rateDate = $("#txt_rate_date").val();
                var reimbursementType = $("#ddl_reimbursement_type").val();

                if(!invoice_no){
                    valid = false;
                    $("#txt_invoice_no").addClass('err_validate');
                    $("#txt_invoice_no").after('<div class="error_msg"> กรุณาระบุเลขที่ใบแจ้งหนี้</div>');
                }

                if(!org_id){
                    valid = false;
                    $("select[name='org_id']").addClass('err_validate');
                    $("select[name='org_id']").after('<div class="error_msg"> กรุณาระบุสถานที่ปฏิบัติการ</div>');
                }

                if(!purpose){
                    valid = false;
                    $("textarea[name='purpose']").addClass('err_validate');
                    $("textarea[name='purpose']").after('<div class="error_msg"> กรุณาระบุวัตถุประสงค์</div>');
                }

                if(!reason){
                    valid = false;
                    $("textarea[name='reason']").addClass('err_validate');
                    $("textarea[name='reason']").after('<div class="error_msg"> กรุณาระบุเหตุผลและความจำเป็น</div>');
                }

                if(!supplier_id){
                    valid = false;
                    $("select[name='supplier_id']").addClass('err_validate');
                    $("select[name='supplier_id']").after('<div class="error_msg"> กรุณาระบุผู้ขาย</div>');
                }

                if(!supplier_site_id){
                    valid = false;
                    $("select[name='supplier_site_id']").addClass('err_validate');
                    $("select[name='supplier_site_id']").after('<div class="error_msg"> กรุณาระบุสาขาผู้ขาย</div>');
                }

                if(!requestDate){
                    valid = false;
                    $("#txt_request_date").addClass('err_validate');
                    $("#txt_request_date").after('<div class="error_msg"> กรุณาระบุวันที่ใบแจ้งหนี้</div>');
                }

                if(!glDate){
                    valid = false;
                    $("#txt_gl_date").addClass('err_validate');
                    $("#txt_gl_date").after('<div class="error_msg"> กรุณาระบุวันที่บันทึกบัญชี</div>');
                }

                if(!tel){
                    valid = false;
                    $("#txt_tel").addClass('err_validate');
                    $("#txt_tel").after('<div class="error_msg"> กรุณาระบุเบอร์โทร</div>');
                }else {
                    if(!$.isNumeric(tel)){
                        valid = false;
                        $("#txt_tel").addClass('err_validate');
                        $("#txt_tel").after('<div class="error_msg"> กรุณาระบุเบอร์โทรเป็นหมายเลข</div>');
                    }
                }

                // if(!dueDate){
                //     valid = false;
                //     $("#txt_due_date").addClass('err_validate');
                //     $("#txt_due_date").after('<div class="error_msg"> due date is required.</div>');
                // }

                if(!paymentMethodId){
                    valid = false;
                    $("#txt_payment_method_id").addClass('err_validate');
                    $("#txt_payment_method_id").after('<div class="error_msg"> กรุณาระบุวิธีการชำระเงิน</div>');
                }

                if(!reimbursementType){
                    valid = false;
                    $("#ddl_reimbursement_type").addClass('err_validate');
                    $("#ddl_reimbursement_type").after('<div class="error_msg"> กรุณาระบุประเภทการเบิก</div>');
                }

                // if(!paymentTermId){
                //     valid = false;
                //     $("#ddl_payment_term_id").addClass('err_validate');
                //     $("#ddl_payment_term_id").after('<div class="error_msg"> payment term is required.</div>');
                // }

                if(currencyId != 'THB'){
                    if(!exchangeRate){
                        valid = false;
                        $("#txt_exchange_rate").addClass('err_validate');
                        $("#txt_exchange_rate").after('<div class="error_msg"> กรุณาระบุอัตราแลกเปลี่ยน</div>');
                    }
                    if(!rateDate){
                        valid = false;
                        $("#txt_rate_date").addClass('err_validate');
                        $("#txt_rate_date").after('<div class="error_msg"> กรุณาระบุวันที่แลกเปลี่ยน</div>');
                    }
                }

                if(!validGL){
                    valid = false;
                    
                    $("#txt_gl_date").addClass('err_validate');
                    $("#txt_gl_date").after('<div class="error_msg"> GL & AP Period Status Is Closing, please contact administrator to solve this issue. </div>');
                }

                return valid;
            }

            function getSuppliers(orgId)
            {
                $.ajax({
                    url: "{{ url('/') }}/ie/reimbursements/get_suppliers",
                    type: 'GET',
                    data: {org_id: orgId},
                    beforeSend: function( xhr ) {
                        $(formId).find("#div_detail_supplier_bank").html('');
                        $(formId).find("select[name='supplier_id']").prop("disabled", true);
                        $(formId).find("select[name='supplier_site_id']").prop("disabled", true);
                    }
                })
                .done(function(result) {
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
                let orgId = $(formId).find("select[name='org_id'] option:selected").val();
                $.ajax({
                    url: "{{ url('/') }}/ie/reimbursements/get_supplier_sites",
                    type: 'GET',
                    data: {supplier_id: supplierId,
                            org_id: orgId},
                    beforeSend: function( xhr ) {
                        $(formId).find("#div_detail_supplier_bank").html('');
                        $(formId).find("select[name='supplier_id']").prop("disabled", true);
                        $(formId).find("select[name='supplier_site_id']").prop("disabled", true);
                    }
                })
                .done(function(result) {
                    $(formId).find("#div_ddl_supplier_site_id").html(result);
                    $(formId).find("select[name='supplier_site_id']").select2({width: "100%"});
                    $(formId).find("select[name='supplier_id']").prop("disabled", false);
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

            $(formId).find("select[name='username']").change(function(){
                var requesterId = $(formId).find("select[name='username'] option:selected").val();
                getRequesterData(requesterId);
            });

            function getRequesterData(requesterId)
            {
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
                    $(".select2").select2({width: "100%"});
                }).then(()=>{
                    $('#txt_account_no').val(defaultBankAccount);
                    $('#select_account_no').val(defaultBankAccount).change();
                });
            }

            function setBankLists(data)
            {
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

                    $('#select_bank_name').html('').select2({data: result});
                    $('#txt_bank_name').val(defaultBank);
                    $('#select_bank_name').val(defaultBank).change();
                    $('#select_account_no').html('').select2({data: [{id: '', text: '-'}]});
                }else {
                    $('#select_bank_name').html('').select2({data: [{id: '', text: '-'}]});
                    $('#select_account_no').html('').select2({data: [{id: '', text: '-'}]});
                }
            }

            function setAccountNumberLists()
            {
                let selectedBank = $('#select_bank_name').val();
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
                    $('#select_account_no').html('').select2({data: dataSet});
                }else {
                    $('#select_account_no').html('').select2({data: [{id: '', text: '-'}]});
                }
                let accountNumber = $(formId).find("select[name='account_no'] option:selected").val();
                setAccountName(accountNumber);
            }

            $(formId).find("select[name='account_no']").change(function(){
                let accountNumber = $(formId).find("select[name='account_no'] option:selected").val();
                setAccountName(accountNumber);
            });

            function setAccountName(accountNumber)
            {
                let accountName = null;
                if(accountLists.length){
                    const found = accountLists.find(element => element.account_number == accountNumber);
                    accountName = found ? found.account_name : null;
                }
                $('#p_account_name').html(accountName);
                $('#txt_account_name').val(accountName);
            }

            function setDataRequester(data)
            {
                // let bankName = data.pn_master ? data.pn_master.prmf_bank_code : '-';
                // $('#p_bank_name').html(bankName);
                // $('#select_bank_name').val(bankName);

                let requesterId = data.username ? data.username : '-';
                $('#p_requester_id').html(requesterId);
                $('#txt_requester_id').val(requesterId);

                // let bankAccountNo = data.pn_master ? data.pn_master.prmf_bankacc : '-';
                // $('#p_account_no').html(bankAccountNo);
                // $('#select_account_no').val(bankAccountNo);

                let positionName = data.personal_dept_location ? data.personal_dept_location.pos_name : '-';
                $('#p_position_name').html(positionName);
                $('#txt_position_name').val(positionName);

                let departmentCode = data.personal_dept_location ? data.personal_dept_location.dept_cd_f02 : '-';
                let departmentDescription = data.personal_dept_location ? (data.personal_dept_location.department ? data.personal_dept_location.department.flex_value+' : '+data.personal_dept_location.department.description : '-') : '-';
                $('#p_department_code').html(departmentDescription);
                $('#txt_department_code').val(departmentCode);
            }

            function setEmployees(html)
            {
                $("#div_employee_id").html(html);
            }

            $(formId).find("select[name='currency_id']").change(function(){
                var currencyId = $(formId).find("select[name='currency_id'] option:selected").val();
                toggleShowExchageRate(currencyId);
            });

            function toggleShowExchageRate(val)
            {
                if(val == 'THB'){
                    $('#div_exchange_rate').addClass('d-none');
                }else {
                    $('#div_exchange_rate').removeClass('d-none');
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
                $("#txt_gl_date").next("div.error_msg").remove();
                $("#txt_gl_date").removeClass('err_validate');

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
                        $("#txt_gl_date").addClass('err_validate');
                        $("#txt_gl_date").after('<div class="error_msg">' +result.msg+'</div>');
                    }else {
                        validGL = true;
                    }
                }).then(()=>{

                });
            }

        });
    </script>
@stop