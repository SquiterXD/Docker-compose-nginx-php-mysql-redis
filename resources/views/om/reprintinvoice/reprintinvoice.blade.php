@extends('layouts.app')

@section('title', 'ปลดรายการ Reprint Invoice/ใบขน')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">.

    <style>
        input[type=checkbox]{
            width: 20px;
            height: 20px;
        }
    </style>
@stop

@section('page-title')
    <h2> OMP0037 ปลดรายการ Reprint Invoice/ใบขน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> OMP0037 ปลดรายการ Reprint Invoice/ใบขน</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>ปลดรายการ Reprint Invoice/ใบขน</h3>
    </div>
    <div class="ibox-content">
        <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">

            <div class="col-xl-12">
                 <div class="form-header-buttons">
                    <div class="buttons">
                   
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
            </div>
            <div class="col-xl-6 m-auto">
            <form id="print_form" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="d-block">วันที่ส่งสินค้า</label>
                    <div class="input-icon">
                        {{-- <input type="text" class="form-control date"  name="" placeholder="" value="06/05/2498"> --}}
                        <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="input_date"
                                id="input_date"
                                placeholder="โปรดเลือกวันที่"
                                value="{{$dateThai}}"
                                format="{{ trans("date.js-format") }}">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div><!--form-group-->

                <div class="form-group">
                    <label class="d-block">เลขที่ใบเตรียมขาย</label>
                    <div class="input-icon">
                        <select class="custom-select select2" 
                                name="pre_order_number" 
                                id="pre_order_number">
                            <option value=""></option>
                            @foreach ($order_prepare as $item_order)
                                <option value="{{ $item_order->prepare_order_number }}">
                                    {{ $item_order->prepare_order_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="d-block">เลขที่ Invoice/ใบขน</label>
                    <div class="input-icon">
                        <select class="custom-select select2" 
                                name="pick_release" 
                                id="pick_release" 
                                onchange="getCreditNote(this.value);">
                            <option value=""></option>
                            @foreach ($order_release as $item_order)
                                <option value="{{ $item_order->pick_release_no }}">
                                    {{ $item_order->pick_release_no }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="d-block">Credit Note</label>
                    <div class="input-icon">
                        <select class="custom-select select2" name="invoice_number" id="invoice_number">
                            <option value=""></option>

                        </select>
                    </div>
                </div><!--form-group-->

                <div class="form-group">

                    <label class="d-block">รหัสลูกค้า</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-icon">
                                <input  type="text" 
                                        list="CustomerList" 
                                        class="form-control" 
                                        name="customer_number" 
                                        id="customer_number" 
                                        placeholder="" 
                                        value="" 
                                        onkeyup="selectCustomer();" 
                                        onchange="selectCustomer();">
                                <datalist id="CustomerList">

                                </datalist>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <input type="text" class="form-control" disabled="" id="customer_name" name="" placeholder="" value="">
                        </div>
                    </div><!--row-->
                </div>

                <div class="form-buttons">
                    <button class="btn btn-lg btn-white" type="button" onclick="searchprint();"><i class="fa fa-search"></i> ค้นหา</button>
                </div>

            </form>
            </div><!--col-xl-6-->

            <div class="col-md-12">

                <hr class="lg">
                <div class="form-header-buttons">
                    <button class="btn btn-md btn-white has-checkbox ml-auto" type="button" onclick="check_all();">
                        <label><input type="checkbox" value="ALL" name="Check_ALL" id="check_all_input"><span> ปลดรายการทั้งหมด</span></label>
                    </button>

                    <button class="btn btn-md btn-primary" type="button" onclick="save_reprint();"><i class="fa fa-save"></i> บันทึก</button>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>

                <form id="print_form_table" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="dataTables-reprint">
                        <thead>
                            <tr class="align-middle text-center">
                                <th class="w-130">เลขที่ Invoice /<br>ใบขน/Credit Note</th>
                                <th>วันที่ส่งสินค้า</th>
                                <th class="w-250">ชื่อลูกค้า</th>
                                <th>จำนวนเงิน</th>
                                <th class="w-150">ปลดรายการ</th>
                                <th class="w-150">ปลดรายการ Reprint</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div><!--table-responsive-->
                </form>
            </div><!--col-xl-12-->
        </div><!--row-->

    </div><!--ibox-content-->
</div><!--ibox-->
@endsection

@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>

<script>
    $(document).ready(function(){
        $('.select2').select2();
        $('.date').datepicker();
        $("#dataTables-reprint").DataTable();
    });
    get_customer();
    getCreditNote();
    searchprint();

    function searchprint()
    {
        loading();
        const formdata = new FormData(document.getElementById("print_form"));

        $.ajax({
            url         : '{{ url("om/ajax/reprint-invoice/searchinvoice") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success : function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    $("#dataTables-reprint").DataTable({
                        pageLength: 100,
                        responsive: true,
                        data : rest.data.data,
                        destroy : true,
                        order: [[ 0, "desc" ]],
                        "columns" : [
                            { 'data' : 'invoice' },
                            { 'data' : 'delivary_date' },
                            { 'data' : 'customer_name' },
                            { 'data' : 'total' },
                            { 'data' : 'unlock' },
                            { 'data' : 'reprint' },
                            { 'data' : 'status' },
                        ],
                        "scrollY":        "250vh",
                        "scrollCollapse": true,
                        "paging":         true
                    });
                }else{
                    $("#dataTables-reprint").DataTable({
                        pageLength: 10,
                        responsive: true,
                        data : [],
                        destroy : true,
                    })
                }
                // if(rest.data.customer != ''){
                //     $("#customer_name").val(rest.data.customer);
                // }
            }
        });
    }

    function get_customer()
    {
        $.ajax({
           url      : '{{ url("om/ajax/print-invoice/customer_list") }}',
           type     : 'post',
           data     : {
                '_token'    : '{{ csrf_token() }}',
           },
           success  : function(rest){
               var data = rest.data;
               var html = '<option value=""></option>';

               $.each(data.data,function(key,val){
                    html += '<option value="'+val.customer_number+'">'+val.customer_name+'</option>';
               });

               $("#CustomerList").html(html);
           }
        });
    }

    function selectCustomer()
    {
        var number      = $("#customer_number").val();
        var customer    = $("#CustomerList option[value='"+number+"']").html();

        $("#customer_name").val(customer);
    }

    function getCreditNote(order_id = '')
    {
        loading();
        console.log(this.value)
        $.ajax({
           url      : '{{ url("om/ajax/print-invoice/creditNoteList") }}',
           type     : 'post',
           data     : {
                '_token'    : '{{ csrf_token() }}',
                order_id    : order_id
           },
           success  : function(rest){
            Swal.close();
               var data = rest.data;
               var html = '<option value=""></option>';

               $.each(data.data,function(key,val){
                    html += '<option value="'+val.invoice_headers_number+'">'+val.invoice_headers_number+'</option>';
               });

               $("#invoice_number").html(html);
           }
        });
    }

    function check_all()
    {
        if($("#check_all_input").prop('checked')){
            $(".unlock-print").prop('checked',true);
        }else{
            $(".unlock-print").prop('checked',false);
        }
    }

    function save_reprint()
    {
        loading();
        const formdata = new FormData(document.getElementById("print_form_table"));

        $.ajax({
            url         : '{{ url("om/ajax/reprint-invoice/save_reprint") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success : function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    searchprint();
                    AlertToast('Success','Change Complete','success');
                }else{
                    AlertToast('Waring','Someting Wrong please try again','error');
                }
            }
        });
    }

    $( "#btnShowDate" ).click(function() {
        let dateData = $('#input_date').val();
        $('#input_date_value').html(dateData);
    });

    showDate();
    async function showDate() {
        var date1 = await helperDate.convertDate('25/03/2021', '{{ trans('date.js-format') }}');
        var date2 = await helperDate.parseToDateTh('25/03/2021', '{{ trans('date.js-format') }}');
        console.log('date1 ', date1.toString()); // Thu Mar 25 2021 00:00:00 GMT+0700 (เวลาอินโดจีน)
        console.log('date2 ', date2.toString()); // Sun Mar 25 2564 00:00:00 GMT+0700 (เวลาอินโดจีน)
    }

    function loading()
    {
        Swal.fire({
            title: 'Please Wait !',
            html: 'data loading',// add html attribute if you want or remove
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });
    }

    function AlertToast(header,detail,type)
    {
        if(type == 'success'){
            toastr.success(header, detail,{
                positionClass : "toast-top-center"
            });
        }else if(type == 'error'){
            toastr.error(header, detail,{
                positionClass : "toast-top-center"
            });
        }
    }

</script>
@stop
