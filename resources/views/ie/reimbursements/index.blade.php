@extends('layouts.app')

@section('title', 'Reimbursements')

@section('page-title')
    <h2>
        <div><x-get-program-code url="/ie/reimbursements" /> Reimbursements : My Request</div>
        <div><small>รายการใบเบิกเงินสำรองจ่าย / PR - TO AP ของคุณ</small></div>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <strong>Reimbursements : My Request</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if (canEnter('/ie/reimbursements'))
        <div class="text-right m-t-lg">
            <a href="{{ route('ie.reimbursements.create') }}" class="btn btn-success">
                <i class="fa fa-plus"></i> Request Reimbursement
            </a>
        </div>
    @endif
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                @include('ie.reimbursements._search_form')
            </div>
            <div class="ibox-content">
                @include('ie.reimbursements._table')
                @if(isset($reims))
                    @if (count($reims) > 0)
                        <div class="m-t-sm text-right">
                            {!! $reims->withQueryString()->links() !!}
                        </div>
                    @endif
                @endif
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

            $("[id^='btn_duplicate_']").click(function(e){
                e.preventDefault(); // Prevent the href from redirecting directly
                var reimId = $(this).attr("data-id");
                swal({
                    html: true,
                    title: 'Copy this reimbursement ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 16px">Are you sure to copy this reimbursement request ?</span></h2>',
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
                            url:  "{{ url('/') }}/ie/reimbursements/"+reimId+"/duplicate",
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
                $("#reim-search-form").submit();
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
                    $("#div-reim-search-form").removeClass('d-none');
                }else {
                    $("#btn_open_search_form").removeClass('d-none');
                    $("#div-reim-search-form").addClass('d-none');
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

        });

    </script>
@stop