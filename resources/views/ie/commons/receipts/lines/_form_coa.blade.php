@php
    $canEdit = $receipt->isNotLock() && $parent->canImportantEditData();
@endphp
@if ($canEdit)
{!! Form::open(['route' => ['ie.receipts.lines.update_coa', $receipt->receipt_id, $receiptLine->receipt_line_id], 'class' => 'form-horizontal', 'method' => 'patch', "id" => 'form-adjust-coa-receipt-line'] ) !!}
@endif
    @if ($canEdit)
        <div class="row d-none" id="div_show_error_msg">
            <div class="col-md-12">
                <ul id="list-msg" class="list-unstyled alert alert-danger alert-dismissible" role="alert">
                    
                </ul>
            </div>
        </div>
    @endif
    <div class="row mb-2">
        <label for="code_combination" class="col-sm-3 col-form-label text-right">
            <div>
                CODE COMBINATION
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::text('set_code_combination', $defaultCombinationCode, ["class"=>'form-control',"autocomplete"=>"off","id"=>"txt_set_code_combination"]) !!}
            @else
                {!! Form::text('set_code_combination', $defaultCombinationCode, ["class"=>'form-control',"autocomplete"=>"off","id"=>"txt_set_code_combination","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="company_code" class="col-sm-3 col-form-label text-right">
            <div>
                COMPANY
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('company_code', $companyLists ,$companyCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_company_code"]) !!}
            @else
                {!! Form::select('company_code', $companyLists ,$companyCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_company_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="evm_code" class="col-sm-3 col-form-label text-right">
            <div>
                EVM
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('evm_code', $evmLists ,$evmCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_evm_code"]) !!}
            @else
                {!! Form::select('evm_code', $evmLists ,$evmCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_evm_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="department_code" class="col-sm-3 col-form-label text-right">
            <div>
                DEPARTMENT
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('department_code', $departmentLists ,$departmentCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_department_code"]) !!}
            @else
                {!! Form::select('department_code', $departmentLists ,$departmentCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_department_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="cost_center_code" class="col-sm-3 col-form-label text-right">
            <div>
                COST CENTER
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8" id="div_ddl_cost_center_code">
            @if ($canEdit)
                {!! Form::select('cost_center_code', $costCenterLists ,$costCenterCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_cost_center_code"]) !!}
            @else
                {!! Form::select('cost_center_code', $costCenterLists ,$costCenterCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_cost_center_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="budget_year_code" class="col-sm-3 col-form-label text-right">
            <div>
                BUDGET YEAR
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('budget_year_code', $budgetYearLists ,$budgetYearCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_budget_year_code"]) !!}
            @else
                {!! Form::select('budget_year_code', $budgetYearLists ,$budgetYearCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_budget_year_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="budget_type_code" class="col-sm-3 col-form-label text-right">
            <div>
                BUDGET TYPE
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('budget_type_code', $budgetTypeLists ,$budgetTypeCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_budget_type_code"]) !!}
            @else
                {!! Form::select('budget_type_code', $budgetTypeLists ,$budgetTypeCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_budget_type_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="budget_detail_code" class="col-sm-3 col-form-label text-right">
            <div>
                BUDGET DETAIL
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8" id="div_ddl_budget_detail_code">
            @if ($canEdit)
                {!! Form::select('budget_detail_code', $budgetDetailLists ,$budgetDetailCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_budget_detail_code"]) !!}
            @else
                {!! Form::select('budget_detail_code', $budgetDetailLists ,$budgetDetailCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_budget_detail_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="budget_reason_code" class="col-sm-3 col-form-label text-right">
            <div>
                BUDGET REASON
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('budget_reason_code', $budgetReasonLists ,$budgetReasonCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_budget_reason_code"]) !!}
            @else
                {!! Form::select('budget_reason_code', $budgetReasonLists ,$budgetReasonCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_budget_reason_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="account_code" class="col-sm-3 col-form-label text-right">
            <div>
                ACCOUNT
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('account_code', $accountLists ,$accountCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_account_code"]) !!}
            @else
                {!! Form::select('account_code', $accountLists ,$accountCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_account_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="sub_account_code" class="col-sm-3 col-form-label text-right">
            <div>
                SUB ACCOUNT
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8" id="div_ddl_sub_account_code">
            @if ($canEdit)
                {!! Form::select('sub_account_code', $subAccountLists ,$subAccountCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_sub_account_code"]) !!}
            @else
                {!! Form::select('sub_account_code', $subAccountLists ,$subAccountCode , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_sub_account_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="reserve1_code" class="col-sm-3 col-form-label text-right">
            <div>
                RESERVE1
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('reserve1_code', $reserve1Lists ,$reserve1Code , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_reserve1_code"]) !!}
            @else
                {!! Form::select('reserve1_code', $reserve1Lists ,$reserve1Code , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_reserve1_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <label for="reserve2_code" class="col-sm-3 col-form-label text-right">
            <div>
                RESERVE2
                @if ($canEdit)
                    <span class="text-danger">*</span>
                @endif
            </div>
        </label>
        <div class="col-sm-8">
            @if ($canEdit)
                {!! Form::select('reserve2_code', $reserve2Lists ,$reserve2Code , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_reserve2_code"]) !!}
            @else
                {!! Form::select('reserve2_code', $reserve2Lists ,$reserve2Code , ["class"=>'form-control select2',"autocomplete"=>"off","id"=>"txt_reserve2_code","disabled"=>"disabled"]) !!}
            @endif
        </div>
    </div>

    @if ($canEdit)
        <hr class="m-t-sm m-b-sm">
        <div class="row clearfix">
            <div class="col-sm-12 text-right">
                <button type="button" class="btn btn-primary" id="submit_adjust_account" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ...">
                    Save
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    @endif

@if ($canEdit)
{!! Form::close()!!}
@endif
