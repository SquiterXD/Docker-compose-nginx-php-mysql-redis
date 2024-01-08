<div class="form-group row">
    <label for="name" class="col-md-2 col-form-label">
        <div>Name <span class="text-danger">*</span></div>
        <div class="m-r-sm"><small>ชื่อ</small></div>
    </label>
    <div class="col-md-9">
    @if(isset($sub_category))
        @if(!$sub_category->isAdvanceOver())
            {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
        @else
            {!! Form::hidden('name', $sub_category->name ) !!}
            <p class="form-control-static">{{ $sub_category->name }}</p>
        @endif
    @else
        {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
    @endif
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
        {!! Form::hidden('combination_code', $defaultCombinationCode, ["id" => 'txt_combination_code']) !!}
        <button type="button" class="btn btn-xs btn-outline-secondary text-center" 
                id="btn-modal-set-account" data-toggle="modal" data-target="#modal-set-account" 
                data-backdrop="static" data-keyboard="false">
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
    <div class="col-md-4">
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
    <div class="col-md-4">
        {!! Form::select('branch_code', [''=>'-']+$branchLists ,null , ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
    </div>
    <label for="department_code" class="col-md-1 col-form-label">
        <div>Department</div>
        <div><small>แผนก</small></div>
    </label>
    <div class="col-md-4">
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
        {!! Form::text('start_date', isset($sub_category) ? null : dateFormatDisplay(date("Y-m-d H:i:s", strtotime("2000-01-01"))), ["id" => "start_date","class" => 'form-control', "autocomplete" => "off"]) !!}
        <span class="input-group-addon"> to </span>
        {!! Form::text('end_date', null , ["id" => "end_date","class" => 'form-control', "autocomplete" => "off"]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="show-xs-only show-sm-only">&nbsp;</div>
            <label for="unit" class="col-md-3 col-form-label">
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
                    {!! Form::text('unit_1' ,isset($sub_category) ? $sub_category->use_second_unit ? $sub_category->unit : null : null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    <span class="input-group-addon"> / </span>
                    {!! Form::text('unit_2' ,isset($sub_category) ? $sub_category->use_second_unit ? $sub_category->second_unit : null : null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                    </div>
                    <small style="color: #999">เช่น ต่อคน / ต่อคืน, ต่อคน / ต่อเที่ยวบิน</small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr class="hr-line-dashed">
    </div>
</div>

<div class="form-group row clearfix">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                {!! Form::hidden('allow_exceed_policy', false ,['id'=>'check_allow_exceed_policy']) !!}
                <div class="row">
                    <div class="col-md-3">
                        <div style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('active', true, !isset($sub_category) ? true : null ) !!} Active (ใช้งาน) ?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('use_second_unit', true, !isset($sub_category) ? false : null ,['id'=>'check_use_second_unit']) !!} Use 2 unit (ใช้งาน 2 หน่วย) ?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="padding-top: 0px;">
                            <label>
                                {!! Form::checkbox('required_attachment', true, !isset($sub_category) ? false : null ) !!} Required Document Attachment (จำเป็นต้องแนบไฟล์) ?
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row clearfix">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-3">
                <div style="padding-top: 0px;">
                    <label>
                        {!! Form::checkbox('use_in_reim', true, !isset($sub_category) ? false : null ) !!} ใช้งานใน Reimbursements ?
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div style="padding-top: 0px;">
                    <label>
                        {!! Form::checkbox('use_in_ca', true, !isset($sub_category) ? false : null ) !!} ใช้งานใน Cash-Advances ?
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div style="padding-top: 0px;">
                    <label>
                        {!! Form::checkbox('use_all_segments', true, !isset($sub_category) ? false : null ) !!} ใช้งานทุก segments ?
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div style="padding-top: 0px;" id="div_update_budget" class="d-none">
                    <label>
                        {!! Form::checkbox('update_only_budget_year', true, !isset($sub_category) ? false : null ) !!} update budget year segment ?
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row clearfix">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-3">
                <div style="padding-top: 0px;">
                    <label>
                        {!! Form::checkbox('wht_flag', true, !isset($sub_category) ? false : null, ['id'=>'check_wht_flag']) !!} WHT ?
                    </label>
                </div>
            </div>
            <div class="col-md-6" id="div_org_options" class="d-none">
                <select name="org_options[]" class="form-control select2" multiple="multiple" id="ddl_org_options">
                    @foreach ($operatingUnits as $item)
                        <option value="{{$item->organization_id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="form-group row">
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary" data-disable-with="Processing...">Save</button>
        <a href="{{ route('ie.settings.sub-categories.index',[$category->category_id]) }}" class="btn btn-danger">cancel</a>
    </div>
</div>

@section('scripts')
@parent
    <script>
        $(document).ready(function() {
            var selectOrg = @json($selectOrg);

            $(".select2").select2({width: "100%"});
            $('.chosen-select').chosen({width: "100%"});
            toggleShowUnit($("#check_use_second_unit").checked);
            toggleShowOrgOptions($("#check_wht_flag").checked);
            
            $('#start_date,#end_date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });

            $('#check_use_second_unit').change(function () {
                toggleShowUnit(this.checked);
            }).change();
            
            $('#check_wht_flag').change(function () {
                toggleShowOrgOptions(this.checked);
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

            function toggleShowOrgOptions(checked)
            {
                if(checked){
                    $('#div_org_options').removeClass('d-none');
                    $('#ddl_org_options').val(selectOrg).trigger('change');
                }else{
                    $('#div_org_options').addClass('d-none');
                    $("#ddl_org_options").select2('val', '');
                }
            }

            $("input[name='use_all_segments']").change(function () {
                toggleUpdateBudgetYear(this.checked);
            }).change();

            function toggleUpdateBudgetYear(checked)
            {
                if(checked){
                    $('#div_update_budget').removeClass('d-none');
                }else{
                    $("input[name='update_only_budget_year']").prop('checked', false);
                    $('#div_update_budget').addClass('d-none');
                }
            }

            $('#btn-modal-set-account').click(function(e){
                renderFormSetAccount();
            });

            function renderFormSetAccount()
            {
                let combinationCode = $("#txt_combination_code").val();
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/categories/{{ $category->category_id }}/sub_categories/form_set_account",
                    type: 'GET',
                    data: { combination_code : combinationCode },
                    beforeSend: function( xhr ) {
                        $("#modal_content_set_account").html('\
                            <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>');
                        $("#btn-confirm-set-account").attr('disabled','');
                    }
                })
                .done(function(result) {
                    $("#modal_content_set_account").html(result);
                });
            }

        });
    </script>
@endsection