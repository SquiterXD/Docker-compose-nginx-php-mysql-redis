<div class="form-group row">
    <label for="name" class="col-md-2 col-form-label">
        <div>Name <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>ชื่อ</small></div>
    </label>
    <div class="col-md-9">
        {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-md-2 col-form-label">
        <div>Description <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>รายละเอียด</small></div>
    </label>
    <div class="col-md-9">
        {!! Form::text('description', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
    </div>
</div>
<div class="form-group row">
    <label for="account_code" class="col-sm-2 col-form-label">
        <div>Account Code <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>บัญชี</small></div>
    </label>
    {{-- <div class="col-sm-6">
        {!! Form::select('account_code', [''=>'-']+$accountLists ,null , ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
    </div>
    <div class="col-sm-3" id="div_ddl_sub_account_code">
        <label class="control-label show-xs-only">Sub-Account Code</label>
        {!! Form::select('sub_account_code', [''=>'-'] ,null , ["class" => 'form-control select2', "autocomplete" => "off","disabled"=>"disabled"]) !!}
    </div> --}}
    <div class="col-sm-5">
        <span id="show_combine" class="m-r-sm">{{ $defaultCombinationCode }}</span>
        <button type="button" class="btn btn-xs btn-outline-secondary text-center" data-toggle="modal" data-target="#modal-set-account" data-backdrop="static" data-keyboard="false">
            แก้ไข
        </button>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-4">
        <div class="row">
            <div class="show-xs-only show-sm-only">&nbsp;</div>
            <label for="vat_id" class="col-md-6 col-form-label">
                <div>VAT Code</div>
                <div><small>รหัสภาษี</small></div>
            </label>
            <div class="col-md-6">
                {!! Form::select('vat_id', [''=>'-']+$VATLists ,null , ["class" => 'form-control select2', "autocomplete " => "off"]) !!}
            </div>
        </div>
    </div>
    <div class="col-md-4 d-none">
        <div class="row">
            <div class="show-xs-only show-sm-only">&nbsp;</div>
            <label for="vat_id" class="col-md-5 col-form-label">
                <div>WHT Code</div>
                <div><small>รหัสภาษี</small></div>
            </label>
            <div class="col-md-6">
                {!! Form::select('wht_id', [''=>'-']+$WHTLists ,null , ["class" => 'form-control select2', "autocomplete " => "off"]) !!}
            </div>
        </div>
    </div>
</div>
{{-- <div class="form-group row">
    <label for="branch_code" class="col-md-2 col-form-label">
        <div>Branch</div>
        <div><small>สาขา</small></div>
    </label>
    <div class="col-md-5">
        {!! Form::select('branch_code', [''=>'-']+$branchLists ,null , ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
    </div>
    <label for="department_code" class="col-md-1 col-form-label">
        <div>Department</div>
        <div><small>แผนก</small></div>
    </label>
    <div class="col-md-3">
        {!! Form::select('department_code', [''=>'-']+$departmentLists ,null , ["class" => 'form-control select2', "autocomplete " => "off"]) !!}
    </div>
</div> --}}
<div class="row">
    <label for="date" class="col-md-2 col-form-label">
        <div>Date <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>วันที่ใช้งาน</small></div>
    </label>
    <div class="col-md-5">
        <div class="input-group">
        {!! Form::text('start_date', null , ["id" => "start_date","class" => 'form-control', "autocomplete" => "off"]) !!}
        <span class="input-group-addon"> to </span>
        {!! Form::text('end_date', null , ["id" => "end_date","class" => 'form-control', "autocomplete" => "off"]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="show-xs-only show-sm-only">&nbsp;</div>
            <label for="unit" class="col-md-3 col-form-label" style="padding-left: 5px">
                <div>Unit <span class="text-danger">*</span></div>
                <div class="m-r-sm"><small>หน่วย</small></div>
            </label>
            <div class="col-md-9">
                <div id="div_use_single_unit">
                    {!! Form::text('unit' ,null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    <small style="color: #999">เช่น ต่อครั้ง, ต่อคน, ต่อคืน, ต่อเที่ยวบิน</small>
                </div>
                <div id="div_use_dual_unit" class="d-none">
                    <div class="input-group">
                    {!! Form::text('unit_1' ,isset($ca_sub_category) ? $ca_sub_category->use_second_unit ? $ca_sub_category->unit : null : null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    <span class="input-group-addon"> / </span>
                    {!! Form::text('unit_2' ,isset($ca_sub_category) ? $ca_sub_category->use_second_unit ? $ca_sub_category->second_unit : null : null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    </div>
                    <small style="color: #999">เช่น ต่อคน / ต่อคืน, ต่อคน / ต่อเที่ยวบิน</small>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-4 d-none">
        <div class="row">
            <label for="ca_min_amount" 
                    class="col-md-3 col-form-label" 
                    title="Cash Advance Minimum Amount" 
                    style="font-size:11px;padding-left:0px;padding-right:0px;padding-top:9px;">
                <div>CA Min Amount</div>
                <div><small>ยอดเงินขั้นต่ำ</small></div>
            </label>
            <div class="col-md-9">
                {!! Form::text('ca_min_amount', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
            </div>
        </div>
        <div class="row m-t-xs">
            <label for="ca_max_amount" 
                    class="col-md-3 col-form-label" 
                    title="Cash Advance Maximum Amount" 
                    style="font-size:11px;padding-left:0px;padding-right:0px;padding-top:9px;">
                <div>CA Max Amount</div>
                <div><small>ยอดเงินสูงสุด</small></div>
            </label>
            <div class="col-md-9">
                {!! Form::text('ca_max_amount', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                <small style="color:#aaa"> <i class="fa fa-info-circle"></i> leave blank if not check cash advance minimum or maximum amount (ปล่อยว่างหากไม่ต้องการตรวจสอบยอดเงินขั้นต่ำหรือสูงสุด).</small>
            </div>
        </div>
    </div> --}}
</div>
<div class="row">
    <div class="col-md-offset-2 col-md-9">
        <hr class="hr-line-dashed">
    </div>
</div>
{{-- <div class="form-group row clearfix">
    <label class="col-sm-2 col-form-label">
        <div>ORG <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>บริษัทที่ใช้งาน</small></div>
    </label>
    <div class="col-sm-3 b-r">
        @foreach($operatingUnits as $ou)
        <div><label>
            {!! Form::checkbox('accessible_orgs[]', $ou->organization_id , null) !!} {{ $ou->name }}
        </label></div>
        @endforeach
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-md-12">
                <div style="padding-top: 0px;">
                    <label>
                        {!! Form::checkbox('required_attachment', true, !isset($ca_sub_category) ? false : null ) !!} Required Document Attachment (จำเป็นต้องแนบไฟล์) ?
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div style="padding-top: 0px;">
                    <label>
                        {!! Form::checkbox('active', true, !isset($ca_sub_category) ? true : null ) !!} Active (ใช้งาน) ?
                    </label>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="form-group row clearfix">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="row" >
                    <div class="col-md-3 text-right">
                        <div style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('active', true, !isset($ca_sub_category) ? true : null ) !!} Active (ใช้งาน) ?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-5 text-right">
                        <div style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('required_attachment', true, !isset($ca_sub_category) ? false : null ) !!} Required Document Attachment (จำเป็นต้องแนบไฟล์) ?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('use_second_unit', true, !isset($ca_sub_category) ? false : null ,['id'=>'check_use_second_unit']) !!} Use 2 unit (ใช้งาน 2 หน่วย) ?
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<div class="form-group row">
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary" data-disable-with="Processing...">Save</button>
        <a href="{{ route('ie.settings.ca-sub-categories.index',[$ca_category->ca_category_id]) }}" class="btn btn-danger">cancel</a>
    </div>
</div>

@section('scripts')
@parent
    <script>
        $(document).ready(function() {

            var defaultCombinationCode = "{{ $defaultCombinationCode }}";
            var tempCombinationCode = "{{ $defaultCombinationCode }}";
            var defaultUseAllCOAFlag = "{{ $defaultUseAllCOAFlag }}";
            var defaultSubAccountCode = "{{ $defaultSubAccountCode }}";
            var setSubAccount = false;

            $('#start_date,#end_date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });
            
            $(".select2").select2({width: "100%"});
            $('.chosen-select').chosen({width: "100%"});
            toggleShowUnit($("#check_use_second_unit").checked);
            getInputSubAccountCode($("select[name='account_code'] option:selected").val(), defaultSubAccountCode);

            $('#check_use_second_unit').change(function () {                
                toggleShowUnit(this.checked);
            }).change();

            function toggleShowUnit(checked)
            {
                if(checked){
                    $('#div_use_single_unit').addClass('d-none');
                    $('#div_use_dual_unit').removeClass('d-none');
                }else{
                    $('#div_use_single_unit').removeClass('d-none');
                    $('#div_use_dual_unit').addClass('d-none');
                }
            }

            $( document ).ajaxStart(function() {
                disableForm();
            });

            $( document ).ajaxStop(function() {
                enableForm();
            });

            function disableForm(){
                $('#submit_adjust_account').prop('disabled', true);
                $('#cancel_adjust_account').prop('disabled', true);
                $('#close_adjust_account').prop('disabled', true);
            }

            function enableForm(){
                $('#submit_adjust_account').prop('disabled', false);
                $('#cancel_adjust_account').prop('disabled', false);
                $('#close_adjust_account').prop('disabled', false);
            }

            $("select[name='account_code']").change(function(){
                var accountCode = $("select[name='account_code'] option:selected").val();
                getInputSubAccountCode(accountCode, setSubAccount ? defaultSubAccountCode : '');
            });

            function getInputSubAccountCode(accountCode,subAccountCode){
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/ca-categories/{{ $ca_category->ca_category_id }}/ca_sub_categories/input_sub_account_code",
                    type: 'GET',
                    data: { account_code : accountCode,
                            sub_account_code : subAccountCode }, 
                    beforeSend: function( xhr ) {
                        $("select[name='sub_account_code']").attr('disabled','disabled');
                        disableForm();
                    }
                })
                .done(function(result) {
                    $("#div_ddl_sub_account_code").html(result);
                    setSubAccount = false;
                    enableForm();
                });
            }

            $('#submit_adjust_account').click(function(e){
                e.preventDefault();
                e.stopPropagation();

                setNewDefaultCombine();
                $('#modal-set-account').modal('hide');
            });

            $('#close_adjust_account').click(function(e){
                e.preventDefault();
                setBackToDefaultCombine();
            });

            $('#cancel_adjust_account').click(function(e){
                e.preventDefault();
                setBackToDefaultCombine();
            });

            function setNewDefaultCombine(){

                var companyCode = $("select[name='company_code'] option:selected").val();
                var evmCode = $("select[name='evm_code'] option:selected").val();
                var departmentCode = $("select[name='department_code'] option:selected").val();
                var costCenterCode = $("select[name='cost_center_code'] option:selected").val();

                var budgetYearCode = $("select[name='budget_year_code'] option:selected").val();
                var budgetTypeCode = $("select[name='budget_type_code'] option:selected").val();
                var budgetDetailCode = $("select[name='budget_detail_code'] option:selected").val();
                var budgetReasonCode = $("select[name='budget_reason_code'] option:selected").val();

                var accountCode = $("select[name='account_code'] option:selected").val();
                var subAccountCode = $("select[name='sub_account_code'] option:selected").val();
                var reserve1Code = $("select[name='reserve1_code'] option:selected").val();
                var reserve2Code = $("select[name='reserve2_code'] option:selected").val();

                var combination = tempCombinationCode.split('.');

                combination[0] = companyCode;
                combination[1] = evmCode;
                combination[2] = departmentCode;
                combination[3] = costCenterCode;

                combination[4] = budgetYearCode;
                combination[5] = budgetTypeCode;
                combination[6] = budgetDetailCode;
                combination[7] = budgetReasonCode;

                combination[8] = accountCode;
                combination[9] = subAccountCode;
                combination[10] = reserve1Code;
                combination[11] = reserve2Code;

                tempCombinationCode = combination = combination.join('.');

                $('#show_combine').html(combination);
            }

            function setBackToDefaultCombine(){

                var combination = tempCombinationCode.split('.');
                $('#txt_code_combination').val(tempCombinationCode);
                $('#txt_use_all_coa_flag').val(defaultUseAllCOAFlag).trigger('change');

                setSelectOption(combination);
            }

            $('#txt_code_combination').change(function(e){
                e.preventDefault();
                var combination = $(this).val().split('.');

                if(combination.length == 12){

                    setSelectOption(combination);

                }else {
                    $(this).val(tempCombinationCode);
                    let msg = 'Code Combination ไม่อยู่ในรูปแบบที่ถูกต้อง';
                    alert(msg);
                }

            });

            function setSelectOption(combination){
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

                let company = $("#txt_company_code");
                if(company.val() != companyCode){
                    company.val(companyCode).trigger('change');
                }
                let evm = $("#txt_evm_code");
                if(evm.val() != evmCode){
                    evm.val(evmCode).trigger('change');
                }
                let department = $("#txt_department_code");
                if(department.val() != departmentCode){
                    department.val(departmentCode).trigger('change');
                }
                let cost = $("#txt_cost_center_code");
                if(cost.val() != costCenterCode){
                    cost.val(costCenterCode).trigger('change');
                }

                let bgYear = $("#txt_budget_year_code");
                if(bgYear.val() != budgetYearCode){
                    bgYear.val(budgetYearCode).trigger('change');
                }
                let bgType = $("#txt_budget_type_code");
                if(bgType.val() != budgetTypeCode){
                    bgType.val(budgetTypeCode).trigger('change');
                }
                let bgDetail = $("#txt_budget_detail_code");
                if(bgDetail.val() != budgetDetailCode){
                    bgDetail.val(budgetDetailCode).trigger('change');
                }
                let bgReason = $("#txt_budget_reason_code");
                if(bgReason.val() != budgetReasonCode){
                    bgReason.val(budgetReasonCode).trigger('change');
                }
                
                let acc = $("#txt_account_code");
                if(acc.val() != accountCode){
                    defaultSubAccountCode = subAccountCode;
                    setSubAccount = true;
                    acc.val(accountCode).trigger('change');
                }else {
                    let sub = $("#txt_sub_account_code");
                    if(sub.val() != subAccountCode){
                        sub.val(subAccountCode).trigger('change');
                    }
                }
                let reserv1 = $("#txt_reserve1_code");
                if(reserv1.val() != reserve1Code){
                    reserv1.val(reserve1Code).trigger('change');
                }
                let reserv2 = $("#txt_reserve2_code");
                if(reserv2.val() != reserve2Code){
                    reserv2.val(reserve2Code).trigger('change');
                }
            }

            $("#txt_company_code").change(function(e){
                e.preventDefault();
                setShowCombine(0, $(this).val());
            });
            $("#txt_evm_code").change(function(e){
                e.preventDefault();
                setShowCombine(1, $(this).val());
            });
            $("#txt_department_code").change(function(e){
                e.preventDefault();
                setShowCombine(2, $(this).val());
            });
            $("#txt_cost_center_code").change(function(e){
                e.preventDefault();
                setShowCombine(3, $(this).val());
            });

            $("#txt_budget_year_code").change(function(e){
                e.preventDefault();
                setShowCombine(4, $(this).val());
            });
            $("#txt_budget_type_code").change(function(e){
                e.preventDefault();
                setShowCombine(5, $(this).val());
            });
            $("#txt_budget_detail_code").change(function(e){
                e.preventDefault();
                setShowCombine(6, $(this).val());
            });
            $("#txt_budget_reason_code").change(function(e){
                e.preventDefault();
                setShowCombine(7, $(this).val());
            });
            
            $("#txt_account_code").change(function(e){
                e.preventDefault();
                setShowCombine(8, $(this).val());
                setShowCombine(9, '000');
            });
            $("#txt_sub_account_code").change(function(e){
                e.preventDefault();
                setShowCombine(9, $(this).val());
            });
            $("#txt_reserve1_code").change(function(e){
                e.preventDefault();
                setShowCombine(10, $(this).val());
            });
            $("#txt_reserve2_code").change(function(e){
                e.preventDefault();
                setShowCombine(11, $(this).val());
            });

            function setShowCombine(index, value){
                var combination = $('#txt_code_combination').val().split('.');

                combination[index] = value;
                combination = combination.join('.');
                $('#txt_code_combination').val(combination);
            }

        });
    </script>
@endsection