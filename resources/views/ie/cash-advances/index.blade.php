@extends('layouts.app')

@section('title', 'Cash Advance')

@section('page-title')
    <h2>
        <div><x-get-program-code url="/ie/cash-advances" />	Cash Advance : My Request </div>
        <div><small>รายการใบยืมเงินทดรองของคุณ</small></div>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <strong>Cash Advance : My Request</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if (canEnter('/ie/cash-advances'))
        <div class="text-right m-t-lg">
            <a href="{{ route('ie.cash-advances.create') }}" class="btn btn-success">
                <i class="fa fa-plus"></i> Request Cash Advance
            </a>
        </div>
    @endif
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                @include('ie.cash-advances._search_form')
            </div>
            <div class="ibox-content">
                @include('ie.cash-advances._table')
                @if(isset($cashAdvances))
                    @if (count($cashAdvances) > 0)
                        <div class="m-t-sm text-right">
                            {!! $cashAdvances->withQueryString()->links() !!}
                        </div>
                    @endif
                @endif
                @include('ie.cash-advances._modal_list_cancel_apply')
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function() {

            $('#txt_req_date_from').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });

            $('#txt_req_date_to').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });

            var search = @json( $search );
            if(search){
                setSearch(search);
                toggleSearchForm('open');
            }

            $("[id^='btn_clear_request_']").click(function(e){
                e.preventDefault(); // Prevent the href from redirecting directly
                var linkURL = $(this).attr("href");
                swal({
                    html: true,
                    title: 'Create clearing request ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 16px">Are you sure to create clearing cash advance request ?</span></h2>',
                    // type: "info",
                    showCancelButton: true,
                    // confirmButtonColor: "#DD6B55",
                    confirmButtonText: " Yes !",
                    cancelButtonText: "cancel",
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = linkURL;
                    }
                });
            });

            $("[id^='btn_duplicate_']").click(function(e){
                e.preventDefault(); // Prevent the href from redirecting directly
                var cashAdvanceId = $(this).attr("data-id");
                swal({
                    html: true,
                    title: 'Copy this cash advance ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 16px">Are you sure to copy this cash advance request ?</span></h2>',
                    // type: "info",
                    showCancelButton: true,
                    // confirmButtonColor: "#DD6B55",
                    confirmButtonText: " Yes !",
                    cancelButtonText: "cancel",
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: "post",
                            url:  "{{ url('/') }}/ie/cash-advances/"+cashAdvanceId+"/duplicate",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            beforeSend: function() {
                                //
                            },
                            success: function (data) {
                                swal({
                                  title: "Copy completed !",
                                  text: "this page will refresh in 2 seconds.",
                                  type: "success",
                                  timer: 2000,
                                  showConfirmButton: false
                                },function(){
                                    location.reload();
                                });
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
            });

            $("[id^='btn_re_apply_']").click(function(e){
                e.preventDefault(); // Prevent the href from redirecting directly
                var cashAdvanceId = $(this).attr("data-id");

                swal({
                    html: true,
                    title: 'Reapply this cash advance ?',
                    text: "<h2 class='m-t-sm m-b-lg'><span style='font-size: 16px'>Are you sure to reapply this cash advance request ?</span></h2>",
                    // type: "info",
                    showCancelButton: true,
                    // confirmButtonColor: "#DD6B55",
                    confirmButtonText: " Yes !",
                    cancelButtonText: "cancel",
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: "post",
                            url:  "{{ url('/') }}/ie/cash-advances/"+cashAdvanceId+"/reapply",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            beforeSend: function() {
                                loadingPage(true);
                            },
                            success: function (data) {
                                loadingPage(false);
                                swal({
                                  title: "Reapply completed !",
                                  text: "this page will refresh in 2 seconds.",
                                  type: "success",
                                  timer: 2000,
                                  showConfirmButton: false
                                },function(){
                                    location.reload();
                                });
                            },
                            error: function(evt, xhr, status) {
                                loadingPage(false);
                                swal(evt.responseJSON.message, null, "error");
                            },
                            complete: function(data) {
                                  //
                            }
                        });
                    }
                });
            });

            //// OPEN SEARCH FORM
            $("[id^='btn_open_search_form']").click(function(e){
                e.preventDefault();
                toggleSearchForm('open');
            });

            //// CLOSE SEARCH FORM
            $("[id^='btn_close_search_form']").click(function(e){
                e.preventDefault();
                toggleSearchForm('close');
            });

            //// SUBMIT SEARCH FORM
            $("[id^='btn_submit_search_form']").click(function(e){
                e.preventDefault();
                $("#ca-search-form").submit();
            });

            $("input[name='search[req_date_from]']").change(function(e){
                var dateForm = $("input[name='search[req_date_from]']").val();
                var dateTo = $("input[name='search[req_date_to]']").val();

                if( dateTo == '' ){
                    $('#txt_req_date_to').datepicker('setDate', formatDate(dateForm));
                }
                if( formatDate(dateForm).getTime() > formatDate(dateTo).getTime() ){
                    $('#txt_req_date_to').datepicker('setDate', formatDate(dateForm));
                }
            });

            $("input[name='search[req_date_to]']").change(function(e){
                var dateForm = $("input[name='search[req_date_from]']").val();
                var dateTo = $("input[name='search[req_date_to]']").val();

                if( formatDate(dateForm).getTime() > formatDate(dateTo).getTime() ){
                    $('#txt_req_date_from').datepicker('setDate', formatDate(dateTo));
                }
            });

            function formatDate(date)
            {
                var dateParts = date.split("/");
                
                return new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]);
            }

            function toggleSearchForm(action)
            {
                if(action == 'open'){
                    $("#btn_open_search_form").addClass('d-none');
                    $("#div-ca-search-form").removeClass('d-none');
                }else {
                    $("#btn_open_search_form").removeClass('d-none');
                    $("#div-ca-search-form").addClass('d-none');
                }
            }

            function setSearch(search)
            {
                $("input[name='search[amount]']").val(search.amount);
                $("input[name='search[description]']").val(search.description);
                $("input[name='search[document_no]']").val(search.document_no);
                $("input[name='search[invoice_no]']").val(search.invoice_no);
                $("input[name='search[requester]']").val(search.requester);
                $("select[name='search[status]']").val(search.status);

                if( search.req_date_to ){
                    $('#txt_req_date_to').datepicker('setDate', formatDate(search.req_date_to));
                }

                if(search.req_date_from){
                    $('#txt_req_date_from').datepicker('setDate', formatDate(search.req_date_from));
                }
            }

            $("[id^='btn_select_apply_']").click(function(e){
                e.preventDefault(); // Prevent the href from redirecting directly
                var cashAdvanceId = $(this).attr("data-id");

                renderFormSelectOldApply(cashAdvanceId);
            });

            function renderFormSelectOldApply(cashAdvanceId)
            {
                let formId = "#modal-list-cancel-apply";
                $.ajax({
                    url: "{{ url('/') }}/ie/cash-advances/"+cashAdvanceId+"/list_cancel_apply",
                    type: 'GET',
                    // data: { receipt_type : receiptType,
                    //         receipt_parent_id : receiptParentId },
                    beforeSend: function( xhr ) {
                        $(formId).find("#modal_content_list_cancel_apply").html('\
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
                    $(formId).find("#modal_content_list_cancel_apply").html(result);
                });
            }

            function loadingPage(loading)
            {
                if(loading){
                    $('#page-wrapper').prepend('<div id="loading-page" style="position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999999999;overflow: hidden;background:#fff"><div class="sk-spinner sk-spinner-double-bounce text-center w-100" style="font-size: 18px; margin-top: 6.5rem;"> กำลังดำเนินการ </div><div class="sk-spinner sk-spinner-double-bounce" style="width: 100px; height: 100px;"><div class="sk-double-bounce1"></div><div class="sk-double-bounce2"></div></div></div>');
                }else {
                    $('#page-wrapper').find('#loading-page').remove();
                }
            }

        });

    </script>
@stop