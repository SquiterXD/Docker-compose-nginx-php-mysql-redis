@extends('layouts.app')

@section('title', 'ปลดรายการพิมพ์ใบเสร็จรับเงิน')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <style>
        input[type=checkbox]{
            width: 20px;
            height: 20px;
        }
    </style>
@stop

@section('page-title')
    <h2>{{--  <x-get-program-code url="/om/print-receipt/reprint" /> --}} OMP0026 ปลดรายการพิมพ์ใบเสร็จรับเงิน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> {{-- <x-get-program-code url="/om/print-receipt/reprint" /> --}} OMP0026 ปลดรายการพิมพ์ใบเสร็จรับเงิน</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>ปลดรายการพิมพ์ใบเสร็จรับเงิน</h3>
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

                <div class="form-group">
                    <label class="d-block">วันที่รับเงิน</label>
                    <div class="input-icon">
                        <datepicker-th
                            style="width: 100%"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="payment_date"
                            id="payment_date"
                            placeholder="โปรดเลือกวันที่"
                            value=""
                            format="DD/MM/YYYY"
                            >
                        <i class="fa fa-calendar"></i>
                    </div>
                </div><!--form-group-->

                <div class="form-group">
                    <label class="d-block">เลขที่ใบเสร็จรับเงิน</label>
                    <div class="input-icon">
                        {{-- <input type="text" class="form-control" id="receript_number"  name="receript_number" placeholder="" value=""> --}}
                        <select class="custom-select select2" id="receript_number" name="receript_number">
                            <option value=""></option>
                            @foreach ($list as $list_item)
                                <option value="{{ $list_item->payment_number }}">{{ $list_item->payment_number }}</option>
                            @endforeach  
                        </select>
                        {{-- <i class="fa fa-search"></i> --}}
                    </div>
                </div>

                <div class="form-group">

                    <label class="d-block">รหัสลูกค้า</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-icon">
                                <input type="text" list="customer_list" class="form-control" id="customer_id" name="customer_id" placeholder="" value="" onkeyup="selectCustomer();" onchange="selectCustomer();">
                                <datalist id="customer_list">
                                    @foreach ($customer as $item_cus)
                                        <option value="{{ $item_cus->customer_number }}"
                                            data-id="{{ $item_cus->customer_id }}"
                                            >{{ $item_cus->customer_name }}</option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" id="customer_number" value="">
                                {{-- <select class="custom-select select2" id="customer_number" name="customer_number" onchange="selectCustomer()">
                                   
                                </select> --}}
                            </div>
                        </div>

                        <div class="col-md-8">
                            <input type="text" class="form-control" disabled="" id="customer_name" placeholder="" value="">
                        </div>
                    </div><!--row-->
                </div>

                <div class="form-buttons">
                    <button class="btn btn-lg btn-white" type="button" onclick="searchRecript();"><i class="fa fa-search"></i> ค้นหา</button>
                </div>
            </div><!--col-xl-6-->

            <div class="col-md-12">

                <hr class="lg">
                <div class="form-header-buttons">
                    <button class="btn btn-md btn-white has-checkbox ml-auto" type="button">
                        <label><input type="checkbox" id="check_all_input" onclick="check_all();" value="option_0" name="a"><span> ปลดรายการทั้งหมด</span></label>
                    </button>
                    <button class="btn btn-md btn-primary" type="button" onclick="reprint_data();"><i class="fa fa-save"></i> บันทึก</button>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>

                <div class="table-responsive">
                    <form id="form_table">
                        <table class="table table-bordered table-hover" id="dataTables-reprint">
                            <thead>
                                <tr class="align-middle text-center">
                                    <th class="w-130">เลขที่ใบเสร็จรับเงิน</th>
                                    <th>วันที่รับเงิน</th>
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
                    </form>
                </div><!--table-responsive-->
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
        $("#dataTables-reprint").DataTable();
        $(".select2").select2();
    });

    function selectCustomer()
    {
        var number      = $("#customer_id").val();
        var customer    = $("#customer_list option[value='"+number+"']").html();
        var id          = $("#customer_list option[value='"+number+"']").data('id');
        $("#customer_name").val(customer);
        $("#customer_number").val(id);
    }

    function searchRecript()
    {
        var payment_date    = $("#payment_date").val();
        var receript_number = $("#receript_number").val();
        var customer_number = $("#customer_number").val();

        // if( payment_date == '' && receript_number == '' && customer_number == ''){
        //     AlertToast('Waring','กรุณาเลือกวันที่รับเงิน หรือ กรอกข้อมูล เพื่อค้นหา','error');
        //     return false;
        // }
        loading();
        $.ajax({
            url     : '{{ url("om/ajax/reprint-receipt/searchreceipt") }}',
            type    : 'post',
            data    : {
                '_token'            : '{{ csrf_token() }}',
                payment_date        : payment_date,
                receript_number     : receript_number,
                customer_number     : customer_number,
            },
            success:function(rest){
                swal.close();
                if(rest.data != ''){
                    $("#dataTables-reprint").DataTable({
                        pageLength: 50,
                        responsive: true,
                        data : rest.data.data,
                        destroy : true,
                        "order": [[ 0, "desc" ]],
                        "columns" : [
                            { 'data' : 'recripet_number',className : "text-center" },
                            { 'data' : 'payment_date',className : "text-center" },
                            { 'data' : 'customer_name' },
                            { 'data' : 'total_payment_amount' },
                            { 'data' : 'unlock',className : "text-center" },
                            { 'data' : 'reprint',className : "text-center" },
                            { 'data' : 'status',className : "text-center" },
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
                    });
                }

                if(rest.data.customer != ''){
                    $("#customer_name").val(rest.data.customer);
                }else{
                    $("#customer_name").val('');
                }
            }
        });
    }

    function reprint_data()
    {
        const formdata = new FormData(document.getElementById("form_table"));
        formdata.append('_token','{{ csrf_token() }}');
        // console.log(...formdata);
        loading();
        $.ajax({
            url         : '{{ url("om/ajax/reprint-receipt/reprint_data") }}',
            type        : 'POST',
            cache       : false,
            processData : false,
            contentType : false,
            data        : formdata,
            success     : function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    searchRecript();
                    AlertToast('Success','Complete','success');
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgImport(data.data);
                    }else if(data.type == 'file'){
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }
                }
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
