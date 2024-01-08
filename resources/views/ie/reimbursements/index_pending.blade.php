@extends('layouts.app')

@section('title', 'Reimbursements')

@section('page-title')
    <h2>
        <div><x-get-program-code url="/ie/reimbursements/pending" /> Reimbursements : My Pending Activities</div>
        <div><small>รายการใบเบิกเงินสำรองจ่าย / PR - TO AP ที่คุณกำลังดำเนินการ</small></div>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <strong>
                Reimbursements : My Pending Activities
            </strong>
        </li>
    </ol>
@stop

@section('page-title-action')

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
                    <div class="m-t-sm text-right">
                        {!! $reims->appends($search)->render() !!}
                    </div>
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
                var dateParts = date.split("-");
                
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