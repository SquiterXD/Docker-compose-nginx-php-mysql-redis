@extends('layouts.app')

@section('title', 'Preferences')

@section('page-title')
    <h2> 
        <x-get-program-code url="/ie/settings/preferences" /> Preferences <br/>
        <small>การตั้งค่าพื้นฐาน</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="active">
            <strong>Preferences</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <span id="ajax_spinner" class="pull-right m-t-md">
        @include('layouts._progress_bar',['size'=>20])
    </span>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="form-group row">
                    <div class="col-md-2">
                        <h4>
                            <div>Base Currency</div>
                            <div><small>สกุลเงินหลัก</small></div>
                        </h4>
                    </div>
                    <div class="col-md-2">
                        <p class="form-control-static">{{ $currency }}</p>
                    </div>
                </div>
                <hr>
                {{-- <div class="form-group row">
                    <div class="col-md-2">
                        <h4>
                            <div>Base Mileage Unit</div>
                            <div><small>หน่วยวัดระยะทางหลัก</small></div>
                        </h4>
                    </div>
                    <div class="col-md-2">
                        <p class="form-control-static">{{ $mileageUnitLists[$mileageUnit] }}</p> 
                    </div>
                </div>
                <hr> --}}
                <div class="form-group row">
                    <div class="col-md-5">
                        <h4>
                            <div>Cash advance unclear pending(s) for blocking next request</div>
                            <div><small>จำนวนใบเบิกที่ยังไม่เคลียร์ก่อนถูกบล็อคคำขอเบิกถัดไป</small></div>
                        </h4>
                    </div>
                    <div class="col-md-1">
                        {!! Form::text('pending_number_blocking', $pendingNumberBlocking, ['class'=>'form-control input-sm']) !!}
                    </div>
                    <div class="col-md-1" style="padding-left: 0px">
                        <a type="button" id="btn_save_pending_number_blocking" class="btn btn-sm btn-success text-white d-none" style="margin-bottom: 0px;">
                            <i class="fa fa-save"></i> Save
                        </a>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-5">
                        <h4>
                            <div>Cash advance unclear pending day(s) for blocking next request</div>
                            <div><small>จำนวนวันดำเนินการเคลียร์ก่อนถูกบล็อคคำขอเบิกถัดไป</small></div>
                            <div><small style="color: red;">(ค่าว่าง = ไม่เช็ควัน)</small></div>
                        </h4>
                    </div>
                    <div class="col-md-1">
                        {!! Form::text('pending_day_blocking', $pendingDayBlocking, ['class'=>'form-control input-sm']) !!}
                    </div>
                    <div class="col-md-1" style="padding-left: 0px">
                        <a type="button" id="btn_save_pending_day_blocking" class="btn btn-sm btn-success text-white d-none" style="margin-bottom: 0px;">
                            <i class="fa fa-save"></i> Save
                        </a>
                    </div>
                </div>
                <hr>
                {{-- <div class="form-group row">
                    <div class="col-md-5">
                        <h4>
                            <div>Over Budget Approver Job Level</div>
                            <div><small>ระดับของผู้อนุมัติรายการเบิกเกินงบประมาน</small></div>
                        </h4>
                    </div>
                    <div class="col-md-2">
                        {!! Form::select('over_budget_approver_job',$jobLists, $overBudgetApproverJob, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <hr> --}}
                <div class="form-group row">
                    <div class="col-md-8">
                        <h4>
                            <div>UnBlocking Responsible Users</div>
                            <div><small>ผู้มีสิทธิ์ปลดบล็อค</small></div>
                            <span class="pull-right">
                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" href="#modal-edit-unblock-users">
                                    <i class="fa fa-edit"></i> Edit 
                                </button>
                            </span>
                        </h4>
                        <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                            @include('ie.settings.preferences._table_unblock_users')
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8">
                        <h4>
                            <div>Change Approve Responsible Users</div>
                            <div><small>ผู้มีสิทธิ์เปลี่ยนผู้อนุมัติ</small></div>
                            <span class="pull-right">
                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" href="#modal-edit-change-approve-users">
                                    <i class="fa fa-edit"></i> Edit 
                                </button>
                            </span>
                        </h4>
                        <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                            @include('ie.settings.preferences._table_change_approve')
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8">
                        <h4>
                            <div>Accountant Users</div>
                            <div><small>ผู้มีสิทธิ์บัญชี</small></div>
                            <span class="pull-right">
                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" href="#modal-edit-accountant-users">
                                    <i class="fa fa-edit"></i> Edit 
                                </button>
                            </span>
                        </h4>
                        <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                            @include('ie.settings.preferences._table_accountant')
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8">
                        <h4>
                            <div>Show All Users</div>
                            <div><small>ผู้มีสิทธิ์ดูข้อมูลทั้งหมด</small></div>
                            <span class="pull-right">
                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" href="#modal-edit-show-all-users">
                                    <i class="fa fa-edit"></i> Edit 
                                </button>
                            </span>
                        </h4>
                        <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                            @include('ie.settings.preferences._table_show_all')
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8">
                        <h4>
                            <div>Mapping Invoice Number Prefix</div>
                            <div><small>ตั้งค่าเลขใบแจ้งหนี้</small></div>
                            <span class="pull-right">
                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" href="#modal-edit-mapping-ous">
                                    <i class="fa fa-edit"></i> Edit 
                                </button>
                            </span>
                        </h4>
                        <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                            @include('ie.settings.preferences._table_mapping_ou')
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8">
                        <h4>
                            <div>Purpose Setup</div>
                            <div><small>ตั้งค่าวัตถุประสงค์</small></div>
                            <span class="pull-right">
                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" href="#modal-edit-purpose">
                                    <i class="fa fa-edit"></i> Edit 
                                </button>
                            </span>
                        </h4>
                        <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                            @include('ie.settings.preferences._table_purpose')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @include('ie.settings.preferences._modal_edit_unblock_users')
    @include('ie.settings.preferences._modal_edit_mapping_ous')
    @include('ie.settings.preferences._modal_edit_change_approve_users')
    @include('ie.settings.preferences._modal_edit_accountant_users')
    @include('ie.settings.preferences._modal_edit_show_all')
    @include('ie.settings.preferences._modal_edit_purpose')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $("#ajax_spinner").hide();
            var default_purpose = @json($purpose);
            var array_purpose = @json($purpose);
            renderPurpose();

            // // ===== CURRENCY =====
            // $("select[name='currency']").change(function(){
            //     var currency = $("select[name='currency'] option:selected").val();
            //     ajaxUpdatePreference('currency',currency);
            // });

            // // ===== MILEAGE UNIT =====
            // $("select[name='mileage_unit']").change(function(){
            //     var mileage_unit = $("select[name='mileage_unit'] option:selected").val();
            //     ajaxUpdatePreference('mileage_unit',mileage_unit);
            // });

            $("#txt_accountant").select2({width: "100%"});
            $("#txt_show_all").select2({width: "100%"});
            $("#txt_unblock_users").select2({width: "100%"});
            $("#txt_change_approver").select2({width: "100%"});
            
            // ===== PENDING DAY BLOCK NEXT REQUEST =====
            $("input[name='pending_day_blocking']").change(function(){
                $("#btn_save_pending_day_blocking").removeClass("d-none");
            });

            $("input[name='pending_number_blocking']").keypress(function(){
                $("#btn_save_pending_number_blocking").removeClass("d-none");
            });

            // ===== OVER BUDGET APPROVER JOB =====
            // $("select[name='over_budget_approver_job']").change(function(){
            //     var over_budget_approver_job = $("select[name='over_budget_approver_job'] option:selected").val();
            //     ajaxUpdatePreference('over_budget_approver_job',over_budget_approver_job);
            // });

            $("#btn_save_pending_day_blocking").click(function(){
                var day = $("input[name='pending_day_blocking']").val();
                if( ($.isNumeric(day) && parseInt(day) >= 0) || day == '') {
                    ajaxUpdatePreference('pending_day_blocking', day == '' ? null : parseInt(day), true);
                }else{
                    $("input[name='pending_day_blocking']").addClass('err_validate');
                }
            })

            $("#btn_save_pending_number_blocking").click(function(){
                var number = $("input[name='pending_number_blocking']").val();
                if(number != '' && $.isNumeric(number) && parseInt(number) >= 0 ) {
                    ajaxUpdatePreference('pending_number_blocking', parseInt(number),true);
                }else{
                    $("input[name='pending_number_blocking']").addClass('err_validate');
                }
            })

            //  ====== UNBLOCKING USER ======
            $("#btn_save_edit_unblock_users").click(function(event){
                event.preventDefault();
                var unblock_users = $("select[name='unblock_users[]'] option:selected").map(function(){
                    return $(this).val();
                }).get();
                ajaxUpdatePreference('unblock_users',unblock_users,true);
                $("#modal-edit-unblock-users").modal('hide');
            });

            // REMOVE UNBLOCKER EVENT
            $("[id^='btn_remove_unblocker_']").click(function(event){
                event.preventDefault();
                let userId = $(this).attr('data-value');
                ajaxSliceJsonData('unblock_users', userId, true);
            });

            //  ====== CHANGE APPROVE USER ======
            $("#btn_save_edit_change_approve_users").click(function(event){
                event.preventDefault();
                var change_approvers = $("select[name='change_approver[]'] option:selected").map(function(){
                    return $(this).val();
                }).get();
                ajaxUpdatePreference('change_approvers',change_approvers,true);
                $("#modal-edit-change-approve-users").modal('hide');
            });

            // REMOVE UNBLOCKER EVENT
            $("[id^='btn_remove_change_approver_']").click(function(event){
                event.preventDefault();
                let userId = $(this).attr('data-value');
                ajaxSliceJsonData('change_approvers', userId, true);
            });

            //  ====== CHANGE APPROVE USER ======
            $("#btn_save_edit_accountant_users").click(function(event){
                event.preventDefault();
                var accountant = $("select[name='accountant[]'] option:selected").map(function(){
                    return $(this).val();
                }).get();
                ajaxUpdatePreference('accountant_users',accountant,true);
                $("#modal-edit-accountant-users").modal('hide');
            });

            // REMOVE UNBLOCKER EVENT
            $("[id^='btn_remove_accountant_']").click(function(event){
                event.preventDefault();
                let userId = $(this).attr('data-value');
                ajaxSliceJsonData('accountant_users', userId, true);
            });

            //  ====== SHOW ALL USER ======
            $("#btn_save_edit_show_all_users").click(function(event){
                event.preventDefault();
                var show_all = $("select[name='show_all[]'] option:selected").map(function(){
                    return $(this).val();
                }).get();
                ajaxUpdatePreference('show_all_users',show_all,true);
                $("#modal-edit-show-all-users").modal('hide');
            });
            
            // REMOVE SHOW ALL USER EVENT
            $("[id^='btn_remove_show_all_']").click(function(event){
                event.preventDefault();
                let userId = $(this).attr('data-value');
                ajaxSliceJsonData('show_all_users', userId, true);
            });

            $("#btn_add_purpose").click(function(event){
                event.preventDefault();
                array_purpose.push({
                    'purpose': '',
                    'seq': '' 
                });
                renderPurpose();
            });
            
            $('#btn_close_change_purpose, #btn_cancel_change_purpose').click(function(event){
                array_purpose = default_purpose.filter((item) => {return true});
                renderPurpose();
            });

            function bindEventPurpose()
            {
                $("[id^='input_purpose_']").change(function(event){
                    event.preventDefault();
                    let index = $(this).attr('index-value');
                    array_purpose[index] = $(this).val();
                });

                $("[id^='input_seq_']").change(function(event){
                    event.preventDefault();
                    let index = $(this).attr('index-value');
                    array_purpose[index] = $(this).val();
                });

                $("[id^='btn_remove_purpose_']").click(function(event){
                    event.preventDefault();
                    let index = $(this).attr('index-value');
                    array_purpose.splice(index, 1);
                    renderPurpose();
                });
            }

            function renderPurpose()
            {
                $('#form-purpose').html('');
                array_purpose.forEach((item, index) => {
                    $('#form-purpose').append(`
                        <div class='row mb-2'>
                            <div class='col-md-9'>
                                <input id="input_purpose_${index}" index-value="${index}" 
                                    name='purpose[${index}]' value="${item.purpose || ''}" class='form-control' 
                                    maxlength='255' autocomplete='off' />
                            </div>
                            <div class='col-md-2'>
                                <input id="input_seq_${index}" index-value="${index}" 
                                    name='seq[${index}]' value="${item.seq || ''}" class='form-control' 
                                    maxlength='10' autocomplete='off' />
                            </div>
                            <div class='col-md-1'>
                                <a href="#" id="btn_remove_purpose_${index}" index-value="${index}" 
                                    class="btn btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> 
                                </a>
                            </div>
                        </div>
                    `);
                });

                bindEventPurpose();
            }

            // ====== AJAX UPDATE FUNCTION ==== 
            function ajaxUpdatePreference(code, data_value, refresh)
            {
                // DEFAULT DATA
                refresh = typeof refresh !== 'undefined' ? refresh : false;

                $.ajax({
                    url: "{{ url('/') }}/ie/settings/preferences/update",
                    type: 'POST',
                    data: { _token: "{{ csrf_token() }}", 
                            code: code, 
                            data_value: data_value },
                    beforeSend: function() {
                        //
                    },
                    success: function (data) {
                        if(refresh){
                            swal({
                              title: "Preferences was edited !",
                              text: "this page will refresh in 2 seconds.",
                              type: "success", 
                              timer: 2000,
                              showConfirmButton: false
                            },function(){
                                location.reload();
                            });
                        }else{
                            toastr.options = {
                                "timeOut": "1000",
                            }
                            toastr.success('Preferences was edited !');
                        }
                    },
                    error: function(evt, xhr, status) {
                        swal(evt.responseJSON.message, null, "error");
                    },
                    complete: function(data) {
                        //
                    }
                });
            }

            function disableForm(){
                $("#btn_save_edit_unblock_users").attr("disabled","disabled");
                $("#btn_save_pending_day_blocking").attr("disabled","disabled");
                $("select[name='currency']").attr("disabled","disabled");
                $("select[name='mileage_unit']").attr("disabled","disabled");
            }

            function enabledForm(){
                $("#btn_save_edit_unblock_users").removeAttr("disabled");
                $("#btn_save_pending_day_blocking").removeAttr("disabled");
                $("select[name='currency']").removeAttr("disabled");
                $("select[name='mileage_unit']").removeAttr("disabled");
            }

            $( document ).ajaxStart(function() {
                disableForm();
                $("#ajax_spinner").show();
            });

            $( document ).ajaxStop(function() {
                enabledForm();
                $("#ajax_spinner").hide();
            });

            function ajaxSliceJsonData(code, data_value, refresh)
            {
                // DEFAULT DATA
                refresh = typeof refresh !== 'undefined' ? refresh : false;

                swal({   
                    title: "Are you sure?",    
                    type: "warning",   
                    showCancelButton: true,    
                    confirmButtonText: "Yes, remove it!",   
                    cancelButtonText: "cancel",
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, 
                function(isConfirm){   
                    if (isConfirm) {    
                        $.ajax({
                          type: "post",
                          url: "{{ url('/') }}/ie/settings/preferences/slice_json",
                          data: { _token: "{{ csrf_token() }}", 
                            code: code, 
                            data_value: data_value },
                          beforeSend: function() {
                            //
                          },
                          success: function (data) {
                            if(refresh){
                                swal({
                                  title: "Preferences was edited !",
                                  text: "this page will refresh in 2 seconds.",
                                  type: "success", 
                                  timer: 2000,
                                  showConfirmButton: false
                                },function(){
                                    location.reload();
                                });
                            }else{
                                toastr.options = {
                                    "timeOut": "1000",
                                }
                                toastr.success('Preferences was edited !');
                            }
                          },
                          error: function(evt, xhr, status) {
                              swal(evt.responseJSON.message, null, "error");
                          },
                          complete: function(data) {
                              //
                          }
                      });    
                    } 
                });
            }
        })
    </script>
@stop