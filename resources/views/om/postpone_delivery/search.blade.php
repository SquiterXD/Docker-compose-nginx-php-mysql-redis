@extends('layouts.app')
@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }
</style>
<style>

    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--focus .select2-selection--multiple,.select2-container .select2-selection--single{
        height: 40px!important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered,.select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 40px!important;

    }
    .select2-dropdown,
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-search--dropdown .select2-search__field{
        border: 1px solid #e5e6e7!important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow,.select2-container .select2-selection--single{
        height: 40px!important;
    }

    .mx-datepicker .mx-input-wrapper input{
        height: auto;
    }

</style>
@stop

@section('title', 'OMP0009 : เลื่อนวันส่งประจำสัปดาห์ สำหรับขายในประเทศ')

@section('page-title')
    <h2><x-get-program-code url="/om/postpone-delivery" /> เลื่อนวันส่งประจำสัปดาห์ สำหรับขายในประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/postpone-delivery" /> เลื่อนวันส่งประจำสัปดาห์ สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')

<div class="ibox">
    <div class="ibox-title">
        <h3>เลื่อนวันส่งประจำสัปดาห์ สำหรับขายในประเทศ </h3>
    </div><!--ibox-title-->
    <div class="ibox-content">
        <div class="d-flex">
            <a class="btn btn-white" href="{{ url('/') }}/om/postpone-delivery"><i class="fa fa-repeat"></i></a>
        </div>
        <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4"><!--justify-content-md-center-->

            @include('om.postpone_delivery._form_search')

            <postpone-delivery  :delivery-dates = "{{ json_encode($deliveryDates) }}"
                                :budget-year = "{{ json_encode($budgetYear) }}">
            </postpone-delivery>
        </div><!--row-->
    </div><!--ibox-content-->
</div><!--ibox-->

@endsection

@section('scripts')
<script>
    $('.select2').select2();
</script>
<!-- Page-Level Scripts -->
<script>
     $(document).ready(function(){
        $('.date').datepicker();
    });

    let customerlists = {!! json_encode($customers) !!};

    function custchange(v){
        if(v != ''){
            var index = _.findIndex(customerlists, function(o) {return o['customer_number'] == v;});
            if(index != -1){
                $('#customer_name').val(customerlists[index]['customer_name']);

                if($('#installment').val() != ''){
                    updateDateDelivery($('#installment').val(),$('#customer_number').val());
                }
            }
        }else{
            $('#customer_name').val('');
            updateDateDelivery($('#installment').val(),$('#customer_number').val());
        }
    }

    function updateDateDelivery(period_no,customer_number) {
        console.log(period_no,customer_number)
        if(period_no != '' && customer_number != ''){
            console.log('asdasd')
            $.ajax({
                url: "{{ url('/') }}/om/ajax/postpone-delivery/date-by-no/"+customer_number+"/"+period_no,
                method: 'get',
                success: function (response) {
                    $('#date').val(response.data)
                },
                error: function (jqXHR, textStatus, errorRhrown) {}
            })
        }else{
            $('#date').val('')
        }

    }

    $("#year").change(function(){
        if($(this).val() != ''){
            $.ajax({
                url: "{{ url('/') }}/om/ajax/postpone-delivery/period-by-years/"+$(this).val(),
                method: 'get',
                success: function (response) {
                    $('#installment').empty()
                    $('#installment')
                        .append($('<option></option>')
                        .val('all')
                        .html('&nbsp;'));
                    $.each(response.data, function( key, obj ) {
                        console.log(obj)
                        $('#installment')
                        .append($('<option></option>')
                        .val(obj.period_line_id)
                        .html(obj.period_no));
                    });
                },
                error: function (jqXHR, textStatus, errorRhrown) {}
            })
        }else{
        }
    });

    $("#installment").change(function(){
        if($(this).val() != ''){
            updateDateDelivery($(this).val(),$('#customer_number').val())
        }else{
            $('#date').val('')
        }
    });
</script>
@stop
