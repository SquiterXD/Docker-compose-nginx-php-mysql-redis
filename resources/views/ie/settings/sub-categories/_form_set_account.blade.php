<div class="row d-none" id="div_show_error_msg">
    <div class="col-md-12">
        <ul id="list-msg" class="list-unstyled alert alert-danger alert-dismissible" role="alert">
            
        </ul>
    </div>
</div>

<div class="row mb-2">
    <label for="code_combination" class="col-sm-3 col-form-label text-right">
        <div>CODE COMBINATION<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::text('set_code_combination', $defaultCombinationCode, ["class" => 'form-control', "autocomplete"=>"off", "id"=>"txt_set_code_combination"]) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="company_code" class="col-sm-3 col-form-label text-right">
        <div>COMPANY<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('company_code', $companyLists, $defaultCompanyCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_company_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="evm_code" class="col-sm-3 col-form-label text-right">
        <div>EVM<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('evm_code', $evmLists, $defaultEVMCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_evm_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="department_code" class="col-sm-3 col-form-label text-right">
        <div>DEPARTMENT<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('department_code', $departmentLists ,$defaultDepartmentCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_department_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="cost_center_code" class="col-sm-3 col-form-label text-right">
        <div>COST CENTER<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8" id="div_ddl_cost_center_code">
        {!! Form::select('cost_center_code', $costCenterLists, $defaultCostCenterCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_cost_center_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="budget_year_code" class="col-sm-3 col-form-label text-right">
        <div>BUDGET YEAR<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('budget_year_code', $budgetYearLists, $defaultBudgetYearCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_budget_year_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="budget_type_code" class="col-sm-3 col-form-label text-right">
        <div>BUDGET TYPE<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('budget_type_code', $budgetTypeLists ,$defaultBudgetTypeCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_budget_type_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="budget_detail_code" class="col-sm-3 col-form-label text-right">
        <div>BUDGET DETAIL<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8" id="div_ddl_budget_detail_code">
        {!! Form::select('budget_detail_code', $budgetDetailLists, $defaultBudgetDetailCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_budget_detail_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="budget_reason_code" class="col-sm-3 col-form-label text-right">
        <div>BUDGET REASON<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('budget_reason_code', $budgetReasonLists, $defaultBudgetReasonCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_budget_reason_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="account_code" class="col-sm-3 col-form-label text-right">
        <div>ACCOUNT<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('account_code', $accountLists, $defaultAccountCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_account_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="sub_account_code" class="col-sm-3 col-form-label text-right">
        <div>SUB ACCOUNT<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8" id="div_ddl_sub_account_code">
        {!! Form::select('sub_account_code', $subAccountLists, $defaultSubAccountCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_sub_account_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="reserve1_code" class="col-sm-3 col-form-label text-right">
        <div>RESERVE1<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('reserve1_code', $reserve1Lists, $defaultReserve1Code, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_reserve1_code']) !!}
    </div>
</div>

<div class="row mb-2">
    <label for="reserve2_code" class="col-sm-3 col-form-label text-right">
        <div>RESERVE2<span class="text-danger">*</span></div>
    </label>
    <div class="col-sm-8">
        {!! Form::select('reserve2_code', $reserve2Lists, $defaultReserve2Code, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_reserve2_code']) !!}
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('keydown', '.select2', function(e) {
            if (e.originalEvent && e.which == 40) {
                e.preventDefault();
                $(this).siblings('select').select2('open');
            }
        });

        var defaultCombinationCode = "{{ $defaultCombinationCode }}";
        var defaultCostCenterCode = "{{ $defaultCostCenterCode }}";
        var defaultBudgetDetailCode = "{{ $defaultBudgetDetailCode }}";
        var defaultSubAccountCode = "{{ $defaultSubAccountCode }}";

        var setCostCenter = false;
        var setBudgetDetail = false;
        var setSubAccount = false;

        $("#modal-set-account").find(".select2").select2({width: "100%", selectOnClose: true});

        function getInputCostCenterCode(departmentCode,costCenterCode){
            let formId = "#modal-set-account";
            $.ajax({
                url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub_categories/input_cost_center_code",
                type: 'GET',
                data: { department_code : departmentCode,
                        cost_center_code : costCenterCode },
                beforeSend: function( xhr ) {
                    $(formId).find("#txt_cost_center_code").attr('disabled','disabled');
                    $(formId).find('#btn-confirm-set-account').prop('disabled', true);
                }
            })
            .done(function(result) {
                $(formId).find("#div_ddl_cost_center_code").html(result);
                $(formId).find('#btn-confirm-set-account').prop('disabled', false);
                setCostCenter = false;
            });
        }

        function getInputBudgetDetailCode(budgetTypeCode,budgetDetailCode){
            let formId = "#modal-set-account";
            $.ajax({
                url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub_categories/input_budget_detail_code",
                type: 'GET',
                data: { budget_type_code : budgetTypeCode,
                        budget_detail_code : budgetDetailCode },
                beforeSend: function( xhr ) {
                    $(formId).find("#txt_budget_detail_code").attr('disabled','disabled');
                    $(formId).find('#btn-confirm-set-account').prop('disabled', true);
                }
            })
            .done(function(result) {
                $(formId).find("#div_ddl_budget_detail_code").html(result);
                $(formId).find('#btn-confirm-set-account').prop('disabled', false);
                setBudgetDetail = false;
            });
        }

        function getInputSubAccountCode(accountCode,subAccountCode){
            let formId = "#modal-set-account";
            $.ajax({
                url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub_categories/input_sub_account_code",
                type: 'GET',
                data: { account_code : accountCode,
                        sub_account_code : subAccountCode },
                beforeSend: function( xhr ) {
                    $(formId).find("#txt_sub_account_code").attr('disabled','disabled');
                    $(formId).find('#btn-confirm-set-account').prop('disabled', true);
                }
            })
            .done(function(result) {
                $(formId).find("#div_ddl_sub_account_code").html(result);
                $(formId).find('#btn-confirm-set-account').prop('disabled', false);
                setSubAccount = false;
            });
        }

        $("#modal-set-account").find("#btn-confirm-set-account").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            submitAdjustAccount();
        });

        function setCombineCodeValue(){
            let combination = $("#modal-set-account").find('#txt_set_code_combination').val();

            $('#show_combine').html(combination);
            $('#txt_combination_code').val(combination);
        }

        function submitAdjustAccount()
        {
            let formId = "#modal-set-account";
            let combinationCode = $(formId).find('#txt_set_code_combination').val();
            $.ajax({
                url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub_categories/validate_combination",
                type: 'GET',
                data: { combination_code : combinationCode },
                beforeSend: function( xhr ) {
                    disableForm();
                    $(formId).find('#btn-confirm-set-account').prop('disabled', true);
                },
                error: function(thrownError){
                    enableForm();
                    $(formId).find('#txt_set_code_combination').addClass('err_validate');
                    $(formId).find('#list-msg').append('<li>'+thrownError.responseJSON.message+'</li>');
                    $(formId).find('#div_show_error_msg').removeClass('d-none');
                },
            })
            .done(function(result) {
                enableForm();
                $(formId).find('#btn-confirm-set-account').prop('disabled', false);
                if(result.status != 'P'){
                    showErrorMsg(result.error_lists);
                }else {
                    setCombineCodeValue();
                    $(formId).modal('hide');
                }
            });
        }

        $('#txt_set_code_combination').change(function(e){
            e.preventDefault();

            hideErrorMsg();
            validateCombination();
        });

        function validateCombination(combination){
            let formId = "#modal-set-account";
            let combinationCode = $(formId).find('#txt_set_code_combination').val();
            $.ajax({
                url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub_categories/validate_combination",
                type: 'GET',
                data: { combination_code : combinationCode },
                beforeSend: function( xhr ) {
                    disableForm();
                    $(formId).find('#btn-confirm-set-account').prop('disabled', true);
                },
                error: function(thrownError){
                    enableForm();
                    $(formId).find('#txt_set_code_combination').addClass('err_validate');
                    $(formId).find('#list-msg').append('<li>'+thrownError.responseJSON.message+'</li>');
                    $(formId).find('#div_show_error_msg').removeClass('d-none');
                },
            })
            .done(function(result) {
                enableForm();
                $(formId).find('#btn-confirm-set-account').prop('disabled', false);
                if(result.status != 'P'){
                    showErrorMsg(result.error_lists);
                }else {
                    var combination = $(formId).find('#txt_set_code_combination').val().split('.');
                    setSelectOption(combination);
                }
            });
        }

        function setSelectOption(combination){

            let formId = "#modal-set-account";
            var companyCode = combination[0];
            var evmCode = combination[1];
            var departmentCode = combination[2];
            var costCenterCode = combination[3];

            var budgetYearCode = combination[4];
            var budgetTypeCode = combination[5];
            var budgetDetailCode = combination[6];
            var budgetReasonCode = combination[7];

            var accountCode = combination[8];
            var subAccountCode = combination[9];
            var reserve1Code = combination[10];
            var reserve2Code = combination[11];

            let company = $(formId).find("#txt_company_code");
            if(company.val() != companyCode){
                company.val(companyCode).trigger('change');
            }
            let evm = $(formId).find("#txt_evm_code");
            if(evm.val() != evmCode){
                evm.val(evmCode).trigger('change');
            }
            let department = $(formId).find("#txt_department_code");
            if(department.val() != departmentCode){
                defaultCostCenterCode = costCenterCode;
                setCostCenter = true;
                department.val(departmentCode).trigger('change');
            }else {
                let cost = $(formId).find("#txt_cost_center_code");
                if(cost.val() != costCenterCode){
                    cost.val(costCenterCode).trigger('change');
                }
            }

            let bgYear = $(formId).find("#txt_budget_year_code");
            if(bgYear.val() != budgetYearCode){
                bgYear.val(budgetYearCode).trigger('change');
            }
            let bgType = $(formId).find("#txt_budget_type_code");
            if(bgType.val() != budgetTypeCode){
                defaultBudgetDetailCode = budgetDetailCode;
                setBudgetDetail = true;
                bgType.val(budgetTypeCode).trigger('change');
            }else {
                let bgDetail = $(formId).find("#txt_budget_detail_code");
                if(bgDetail.val() != budgetDetailCode){
                    bgDetail.val(budgetDetailCode).trigger('change');
                }
            }
            let bgReason = $(formId).find("#txt_budget_reason_code");
            if(bgReason.val() != budgetReasonCode){
                bgReason.val(budgetReasonCode).trigger('change');
            }
            
            let acc = $(formId).find("#txt_account_code");
            if(acc.val() != accountCode){
                defaultSubAccountCode = subAccountCode;
                setSubAccount = true;
                acc.val(accountCode).trigger('change');
            }else {
                let sub = $(formId).find("#txt_sub_account_code");
                if(sub.val() != subAccountCode){
                    sub.val(subAccountCode).trigger('change');
                }
            }
            let reserv1 = $(formId).find("#txt_reserve1_code");
            if(reserv1.val() != reserve1Code){
                reserv1.val(reserve1Code).trigger('change');
            }
            let reserv2 = $(formId).find("#txt_reserve2_code");
            if(reserv2.val() != reserve2Code){
                reserv2.val(reserve2Code).trigger('change');
            }
        }
        
        $("#modal-set-account").find("#txt_company_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(0, $(this).val());
        });
        $("#modal-set-account").find("#txt_evm_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(1, $(this).val());
        });
        $("#modal-set-account").find("#txt_department_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(2, $(this).val());
        });
        $("#modal-set-account").find("#txt_department_code").on('change', function(e){
            e.preventDefault();
            setShowCombine(2, $(this).val());
            setShowCombine(3, setCostCenter ? defaultCostCenterCode : '00');
            var departmentCode = $("#txt_department_code").val();
            getInputCostCenterCode(departmentCode, setCostCenter ? defaultCostCenterCode : '00');
        });
        $("#modal-set-account").find("#txt_cost_center_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(3, $(this).val());
        });

        $("#modal-set-account").find("#txt_budget_year_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(4, $(this).val());
        });
        $("#modal-set-account").find("#txt_budget_type_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(5, $(this).val());
        });
        $("#modal-set-account").find("#txt_budget_type_code").on('change', function(e){
            e.preventDefault();
            setShowCombine(5, $(this).val());
            setShowCombine(6, setBudgetDetail ? defaultBudgetDetailCode : '000000');
            var budgetTypeCode = $("#txt_budget_type_code").val();
            getInputBudgetDetailCode(budgetTypeCode, setBudgetDetail ? defaultBudgetDetailCode : '000000');
        });
        $("#modal-set-account").find("#txt_budget_detail_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(6, $(this).val());
        });
        $("#modal-set-account").find("#txt_budget_reason_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(7, $(this).val());
        });
        
        $("#modal-set-account").find("#txt_account_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(8, $(this).val());
        });
        $("#modal-set-account").find("#txt_account_code").on('change', function(e){
            e.preventDefault();
            setShowCombine(8, $(this).val());
            setShowCombine(9, setSubAccount ? defaultSubAccountCode : '000');
            var accountCode = $("#txt_account_code").val();
            getInputSubAccountCode(accountCode, setSubAccount ? defaultSubAccountCode : '000');
        });
        $("#modal-set-account").find("#txt_sub_account_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(9, $(this).val());
        });
        $("#modal-set-account").find("#txt_reserve1_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(10, $(this).val());
        });
        $("#modal-set-account").find("#txt_reserve2_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(11, $(this).val());
        });

        function setShowCombine(index, value){
            let formId = "#modal-set-account";
            let combination = $(formId).find('#txt_set_code_combination').val().split('.');
            combination[index] = value;
            combination = combination.join('.');

            $(formId).find('#txt_set_code_combination').val(combination);
            $(formId).find("#btn-confirm-set-account").prop('disabled', false);
            hideErrorMsg();
        }

        function disableForm()
        {
            let formId = "#modal-set-account";
            $(formId).find("#txt_set_code_combination").attr('disabled','disabled');
            $(formId).find("#txt_company_code").attr('disabled','disabled');
            $(formId).find("#txt_evm_code").attr('disabled','disabled');
            $(formId).find("#txt_department_code").attr('disabled','disabled');
            $(formId).find("#txt_cost_center_code").attr('disabled','disabled');
            $(formId).find("#txt_budget_year_code").attr('disabled','disabled');
            $(formId).find("#txt_budget_type_code").attr('disabled','disabled');
            $(formId).find("#txt_budget_detail_code").attr('disabled','disabled');
            $(formId).find("#txt_budget_reason_code").attr('disabled','disabled');
            $(formId).find("#txt_account_code").attr('disabled','disabled');
            $(formId).find("#txt_sub_account_code").attr('disabled','disabled');
            $(formId).find("#txt_reserve1_code").attr('disabled','disabled');
            $(formId).find("#txt_reserve2_code").attr('disabled','disabled');
        }

        function enableForm()
        {
            let formId = "#modal-set-account";
            $(formId).find("#txt_set_code_combination").removeAttr('disabled');
            $(formId).find("#txt_company_code").removeAttr('disabled');
            $(formId).find("#txt_evm_code").removeAttr('disabled');
            $(formId).find("#txt_department_code").removeAttr('disabled');
            $(formId).find("#txt_cost_center_code").removeAttr('disabled');
            $(formId).find("#txt_budget_year_code").removeAttr('disabled');
            $(formId).find("#txt_budget_type_code").removeAttr('disabled');
            $(formId).find("#txt_budget_detail_code").removeAttr('disabled');
            $(formId).find("#txt_budget_reason_code").removeAttr('disabled');
            $(formId).find("#txt_account_code").removeAttr('disabled');
            $(formId).find("#txt_sub_account_code").removeAttr('disabled');
            $(formId).find("#txt_reserve1_code").removeAttr('disabled');
            $(formId).find("#txt_reserve2_code").removeAttr('disabled');
        }

        function showErrorMsg(msgLists = [])
        {
            let formId = "#modal-set-account";
            $(formId).find('#txt_set_code_combination').addClass('err_validate');

            msgLists.forEach(msg => {
                $(formId).find('#list-msg').append('<li>'+msg+'</li>');
            });

            $(formId).find('#div_show_error_msg').removeClass('d-none');
        }

        function hideErrorMsg()
        {
            let formId = "#modal-set-account";
            $(formId).find('#list-msg').html('');
            $(formId).find('#div_show_error_msg').addClass('d-none');
            $(formId).find('#txt_set_code_combination').removeClass('err_validate');
        }

    });
</script>