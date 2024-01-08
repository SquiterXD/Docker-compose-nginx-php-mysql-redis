<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="company_code" class="col-sm-3 col-form-label text-right">
                <div>USE ALL SEGMENTS<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('use_all_coa_flag', ['N' => 'NO', 'Y' => 'YES'] , $defaultUseAllCOAFlag, ["class" => 'form-control select2', "id" => 'txt_use_all_coa_flag', "autocomplete" => "off"]) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="company_code" class="col-sm-3 col-form-label text-right">
                <div>CODE COMBINATION<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::text('code_combination', $defaultCombinationCode, ["class" => 'form-control', "autocomplete" => "off", "id" => "txt_code_combination"]) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="company_code" class="col-sm-3 col-form-label text-right">
                <div>COMPANY<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('company_code', $companyLists, $defaultCompanyCode, ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_company_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="evm_code" class="col-sm-3 col-form-label text-right">
                <div>EVM<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('evm_code', $evmLists ,$defaultEVMCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_evm_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="department_code" class="col-sm-3 col-form-label text-right">
                <div>DEPARTMENT<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('department_code', $departmentLists ,$defaultDepartmentCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_department_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="cost_center_code" class="col-sm-3 col-form-label text-right">
                <div>COST CENTER<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('cost_center_code', $costCenterLists ,$defaultCostCenterCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_cost_center_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="budget_year_code" class="col-sm-3 col-form-label text-right">
                <div>BUDGET YEAR<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('budget_year_code', $budgetYearLists ,$defaultBudgetYearCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_budget_year_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="budget_type_code" class="col-sm-3 col-form-label text-right">
                <div>BUDGET TYPE<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('budget_type_code', $budgetTypeLists ,$defaultBudgetTypeCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_budget_type_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="budget_detail_code" class="col-sm-3 col-form-label text-right">
                <div>BUDGET DETAIL<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('budget_detail_code', $budgetDetailLists ,$defaultBudgetDetailCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_budget_detail_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="budget_reason_code" class="col-sm-3 col-form-label text-right">
                <div>BUDGET REASON<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('budget_reason_code', $budgetReasonLists ,$defaultBudgetReasonCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_budget_reason_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="account_code" class="col-sm-3 col-form-label text-right">
                <div>ACCOUNT<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('account_code', $accountLists ,$defaultAccountCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_account_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="sub_account_code" class="col-sm-3 col-form-label text-right">
                <div>SUB ACCOUNT<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8" id="div_ddl_sub_account_code">
                {!! Form::select('sub_account_code', [''=>'-'] ,$defaultSubAccountCode , ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="reserve1_code" class="col-sm-3 col-form-label text-right">
                <div>RESERVE1<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('reserve1_code', $reserve1Lists ,$defaultReserve1Code , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_reserve1_code']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <div class="row">
            <label for="reserve2_code" class="col-sm-3 col-form-label text-right">
                <div>RESERVE2<span class="text-danger">*</span></div>
            </label>
            <div class="col-sm-8">
                {!! Form::select('reserve2_code', $reserve2Lists ,$defaultReserve2Code , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_reserve2_code']) !!}
            </div>
        </div>
    </div>
</div>