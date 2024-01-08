@extends('layouts.app')

@section('title', 'ยกเลิกใบลดหนี้')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>OMP0035 : ยกเลิกใบลดหนี้ สำหรับขายในประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>OMP0035 ยกเลิกใบลดหนี้ สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>ยกเลิกใบลดหนี้ สำหรับขายในประเทศ</h3>
    </div>
    <div class="ibox-content">
        <div class="row space-50 justify-content-md-center flex-column mt-md-4">

            <div class="col-xl-12">
                <div class="form-header-buttons">
                    <div class="buttons">
                        <button class="btn btn-md btn-white" type="button" onclick="search_invoce();"><i class="fa fa-search"></i> ค้นหา</button>
                        <button class="btn btn-md btn-primary" type="button" onclick="save_invoice();"><i class="fa fa-save"></i> บันทึก</button>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
            </div>

            <div class="col-xl-6 m-auto">
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">วันที่ชำระ</label>
                            <div class="input-icon">
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="pay_invoice"
                                    id="pay_invoice"
                                    placeholder="โปรดเลือกวันที่"
                                    value=""
                                    format="DD/MM/YYYY"
                                    >
                                {{-- <input type="text" class="form-control date" id="pay_invoice" name="pay_invoice" placeholder="" value=""> --}}
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div><!--form-group-->
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">ใบลดหนี้เลขที่</label>
                            <div class="input-icon">
                                <select class="custom-select select2" style="width: 100%;" id="invoice" name="invoice">
                                    <option value=""></option>
                                    @foreach ($list as $item)
                                        <option value="{{ $item->invoice_headers_number }}">{{ $item->invoice_headers_number }}</option>
                                    @endforeach
                                </select>
                                {{-- <i class="fa fa-search"></i> --}}
                            </div>
                        </div><!--form-group-->
                    </div>
                </div><!--row-->

            </div><!--col-xl-6-->

            <div class="col-xl-12">
                <div class="alert alert-warning alert-dismissible print-error-msg-invoice" id="close-btn-invoice" style="display: none;">
                    <button type="button" class="close" onclick="$('#close-btn-invoice').hide();">&times;</button>
                    <h5> Warning!</h5>
                    <ul></ul>
                </div>
                <div class="table-responsive">
                    <form id="form_table">
                        <table class="table table-bordered table-hover text-center" id="dataTables-invoice">
                            <thead>
                                <tr class="align-middle text-center">
                                    <th>ใบลดหนี้เลขที่</th>
                                    <th>วันที่ชำระ</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>รวมทั้งสิ้น</th>
                                    <th class="w-130">ยกเลิก</th>
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
        $("#dataTables-invoice").DataTable();
        $(".select2").select2();
    });
    // search_invoce();
    function search_invoce()
    {
        var pay_invioce = $("#pay_invoice").val();
        var invoice = $("#invoice").val();
        loading();
        $.ajax({
           url : '{{ url("om/ajax/invoice_cancel/list") }}',
           type : 'post',
           data : {
                '_token'    : '{{ csrf_token() }}',
                pay_invoice : pay_invioce,
                invoice     : invoice
           },
           success:function(rest){
               swal.close();
                if(rest.data != ''){
                    $("#dataTables-invoice").DataTable({
                        pageLength: 10,
                        responsive: true,
                        data : rest.data,
                        destroy : true,
                        "columns" : [
                            { 'data' : 'invoice_number' },
                            { 'data' : 'invoice_date' },
                            { 'data' : 'invoice_customer' },
                            { 'data' : 'invoice_amount' },
                            { 'data' : 'invoice_cancel' },
                        ]
                    });
                }else{
                    $("#dataTables-invoice").DataTable({
                        pageLength: 10,
                        responsive: true,
                        data : [],
                        destroy : true,
                    });
                }
           }
        });
    }

    function save_invoice()
    {
        const formdata = new FormData(document.getElementById("form_table"));
        formdata.append('_token','{{ csrf_token() }}');

        loading();
        $.ajax({
            url         : '{{ url("om/ajax/invoice_cancel/save") }}',
            type        : 'POST',
            cache       : false,
            processData : false,
            contentType : false,
            data        : formdata,
            success     : function(rest){
                swal.close();
                $(".print-error-msg-invoice").hide();
                var data = rest.data;
                if(data.status){
                    search_invoce();
                    AlertToast('สำเร็จ','บันทึกเรียบร้อย','success');
                    window.location.reload();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgInvoice(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','บางอย่างผิดผลาดกรุณาลองใหม่อีกครั้ง','error');
                    }
                }
            }
        });
    }

    function printErrorMsgInvoice (msg) {
        $(".print-error-msg-invoice").find("ul").html('');
        $(".print-error-msg-invoice").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg-invoice").find("ul").append('<li>'+value+'</li>');
        });
    }

    function loading()
    {
        Swal.fire({
            title: 'โปรดรอ !',
            html: 'กำลังโหลดข้อมูล',// add html attribute if you want or remove
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
