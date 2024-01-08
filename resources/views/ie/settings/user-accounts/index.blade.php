@extends('layouts.app')

@section('title', 'User Accounts')

@section('page-title')
    <h2> 
        <x-get-program-code url="/ie/settings/user-accounts" /> User Bank Accounts <br/>
        <small>การตั้งค่าบัญชีธนาคารผู้ใช้</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="active">
            <strong>User Accounts</strong>
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
                <div class="row">
                    <div class="col-md-10">
                        <form action="/ie/settings/user-accounts" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="employee_number" value="{{ $request->employee_number }}" placeholder="Number" autocomplete="off" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="employee_name" value="{{ $request->employee_name }}" placeholder="Name" autocomplete="off" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2 text-right">
                        <button class="btn btn-default" id="btn_sync_data">
                            <i class="fa fa-refresh"></i> Sync
                        </button>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableUserAccounts">
                        <thead>
                            <tr>
                                <th width="50px">
                                    #
                                </th>
                                <th width="20%">
                                    Employee Number
                                </th>
                                <th width="20%">
                                    Employee Name
                                </th>
                                <th>
                                    Accounts
                                </th>
                                <th width="100px">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employeeLists as $emp)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $emp->username }}
                                    </td>
                                    <td>
                                        {{ optional($emp->user)->name }}
                                    </td>
                                    <td>
                                        @if( count( $accounts = $emp->userAccounts ) )
                                            @foreach ( $accounts as $account)
                                                <div class="row mb-1">
                                                    <span class="mr-1">
                                                        @if ($account->default_flag)
                                                            <i class="fa fa-check-circle" style="color: green"></i>
                                                        @endif
                                                        @if ($account->account_type == 'MANUAL')
                                                            <i class="fa fa-plus-circle"></i>&nbsp;
                                                        @else
                                                            <i class="fa fa-refresh"></i>&nbsp;
                                                        @endif
                                                        ( {{ $account->bank_name }} ) - {{ $account->account_number }}
                                                    </span>
                                                    @if (!$account->default_flag)
                                                        <a id="btn_set_default_{{ $account->user_account_id }}"
                                                            data-account-id="{{ $account->user_account_id }}"
                                                            class="mb-0 mr-1"
                                                            title="Set Default">
                                                            <i class="fa fa-check" style="color: green"></i>
                                                        </a>
                                                    @endif
                                                    @if ( $account->account_type == 'MANUAL' )
                                                        <a id="btn_edit_account_{{ $account->user_account_id }}" 
                                                            data-account-id="{{ $account->user_account_id }}"
                                                            class="mb-0 mr-1 text-warning" 
                                                            title="Edit">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </a>
                                                        <a id="btn_delete_account_{{ $account->user_account_id }}" 
                                                            data-account-id="{{ $account->user_account_id }}" 
                                                            class="mb-0 mr-1 text-danger" 
                                                            title="Delete">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a type="button" id="btn_add_account_{{ $emp->username }}" 
                                            data-employee-number="{{ $emp->username }}" class="btn btn-xs btn-success text-white" title="Add">
                                            <i class="fa fa-plus"></i>&nbsp; Add
                                        </a>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(isset($employeeLists))
                    @if (count($employeeLists) > 0)
                        <div class="m-t-sm text-right">
                            {!! $employeeLists->appends('')->render() !!}
                        </div>
                    @endif
                @endif
                @include('ie.settings.user-accounts._modal_create')
                @include('ie.settings.user-accounts._modal_edit')
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $("#ajax_spinner").hide();

            $("[id^='btn_sync_data']").click(function(event){
                event.preventDefault();
                syncData();
            });

            $("[id^='btn_add_account_']").click(function(){
                var employee_number = $(this).attr('data-employee-number');
                renderFormCreateAccount(employee_number);
                $("#modal-create-account").modal('show');
            });

            $("[id^='btn_edit_account_']").click(function(){
                var accountId = $(this).attr('data-account-id');
                renderFormEditAccount(accountId);
                $("#modal-edit-account").modal('show');
                
            });

            $("[id^='btn_delete_account_']").click(function(){
                var accountId = $(this).attr('data-account-id');
                deleteData(accountId);
            });

            $("[id^='btn_set_default_']").click(function(){
                var accountId = $(this).attr('data-account-id');
                setDefault(accountId);
            });

            ////////////////////////////////
            //// RENDER FORM CREATE ACCOUNT
            function renderFormCreateAccount(employeeNumber){

                $.ajax({
                    url: "{{ url('/') }}/ie/settings/user-accounts/form_create",
                    data: {
                        employee_number: employeeNumber,
                    },
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal_content_create_account").html('\
                            <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>');
                    }
                })
                .done(function(result) {
                    $("#modal_content_create_account").html(result);
                });

            }

            ////////////////////////////////
            //// RENDER FORM EDIT ACCOUNT
            function renderFormEditAccount(accountId){

                $.ajax({
                    url: "{{ url('/') }}/ie/settings/user-accounts/"+accountId+"/form_edit",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal_content_edit_account").html('\
                            <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>');
                    }
                })
                .done(function(result) {
                    $("#modal_content_edit_account").html(result);
                });

            }

            function setDefault(accountId)
            {
                swal({
                    html: true,
                    title: 'Set Default Account ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to set default this account ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, set it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {    
                        $.ajax({
                            type: "post",
                            url: "{{ url('/') }}/ie/settings/user-accounts/"+accountId+"/set_default",
                            data: { 
                                _token: "{{ csrf_token() }}",
                            },
                            beforeSend: function() {
                                //
                            },
                            success: function (data) {
                                if((data.status).toUpperCase() == 'S'){
                                    swal({
                                        title: "Set default success !",
                                        text: "this page will refresh in 2 seconds.",
                                        type: "success", 
                                        timer: 2000,
                                        showConfirmButton: false
                                    },function(){
                                        location.reload();
                                    });
                                }else{
                                    swal({
                                        title: "Set default error !",
                                        text: "this page will refresh in 2 seconds.",
                                        type: "error", 
                                        timer: 2000,
                                        showConfirmButton: false
                                    },function(){
                                        location.reload();
                                    });
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

            function deleteData(accountId)
            {
                swal({
                    title: "Are you sure?",    
                    type: "warning",   
                    showCancelButton: true,    
                    confirmButtonText: "Yes, delete it!",   
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
                            url: "{{ url('/') }}/ie/settings/user-accounts/"+accountId,
                            data: { 
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE" 
                            },
                            beforeSend: function() {
                                //
                            },
                            success: function (data) {
                                if((data.status).toUpperCase() == 'S'){
                                    swal({
                                        title: "Delete success !",
                                        text: "this page will refresh in 2 seconds.",
                                        type: "success", 
                                        timer: 2000,
                                        showConfirmButton: false
                                    },function(){
                                        location.reload();
                                    });
                                }else{
                                    swal({
                                        title: "Delete error !",
                                        text: "this page will refresh in 2 seconds.",
                                        type: "error", 
                                        timer: 2000,
                                        showConfirmButton: false
                                    },function(){
                                        location.reload();
                                    });
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

            function syncData()
            {
                swal({
                    title: "Are you sure?",    
                    type: "warning",   
                    showCancelButton: true,    
                    confirmButtonText: "Yes, sync it!",   
                    cancelButtonText: "cancel",
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, 
                function(isConfirm){   
                    if (isConfirm) {    
                        $.ajax({
                            type: "post",
                            url: "{{ url('/') }}/ie/settings/user-accounts/sync",
                            data: { _token: "{{ csrf_token() }}" },
                            beforeSend: function() {
                                //
                            },
                            success: function (data) {
                                if((data.status).toUpperCase() == 'S'){
                                    swal({
                                        title: "Sync success !",
                                        text: "this page will refresh in 2 seconds.",
                                        type: "success", 
                                        timer: 2000,
                                        showConfirmButton: false
                                    },function(){
                                        location.reload();
                                    });
                                }else{
                                    swal({
                                        title: "Sync error !",
                                        text: "this page will refresh in 2 seconds.",
                                        type: "error", 
                                        timer: 2000,
                                        showConfirmButton: false
                                    },function(){
                                        location.reload();
                                    });
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