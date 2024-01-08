@extends('layouts.app')

@section('title', 'พิมพ์ Invoice / ใบขน / Credit Note')

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
    <h2> OMP0036 : พิมพ์ Invoice / ใบขน / Credit Note</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> OMP0036 พิมพ์ Invoice / ใบขน / Credit Note</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>พิมพ์ Invoice / ใบขน / Credit Note</h3>
    </div>
    <div class="ibox-content">
        {{-- <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4"> --}}
        <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
            <div class="col-xl-12">
                <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>
                <form id="print_form" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">วันที่ส่ง</label>
                                    <div class="input-icon">
                                        <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="delivary_date"
                                        id="delivary_date"
                                        placeholder="โปรดเลือกวันที่"
                                        value="{{$dateThai}}"
                                        format="DD/MM/YYYY">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <label class="d-block">ถึงวันที่</label>
                                    <div class="input-icon">
                                        <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="delivary_to"
                                        id="delivary_to"
                                        placeholder="โปรดเลือกวันที่"
                                        value="{{$dateThai}}"
                                        format="DD/MM/YYYY">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        {{-- <div class="form-group">
                            <label class="d-block">Invoice / ใบขน</label>
                            <div class="input-icon">
                                <select class="custom-select select2" name="pick_release" id="pick_release" onchange="getCreditNote(this.value);">
                                    <option value=""></option>
                                    @foreach ($order_release as $item_order)
                                        <option value="{{ $item_order->pick_release_no }}">{{ $item_order->pick_release_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        {{-- <div class="form-group">
                            <label class="d-block">สถานะการพิมพ์</label>
                            <select class="custom-select" name="print_status">
                                <option></option>
                                <option value="N">พิมพ์แล้ว</option>
                                <option value="Y">ยังไม่ได้พิมพ์</option>
                            </select>
                        </div> --}}
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">สถานะการพิมพ์</label>
                            <select class="custom-select" name="print_status">
                                <option></option>
                                <option value="N">พิมพ์แล้ว</option>
                                <option value="Y">ยังไม่ได้พิมพ์</option>
                            </select>
                        </div>

                        {{-- <div class="form-group">
                            <label class="d-block">เลขที่ใบเตรียมขาย</label>
                            <div class="input-icon">
                                <select class="custom-select select2" name="pre_order_number" id="pre_order_number">
                                    <option value=""></option>
                                    @foreach ($order_prepare as $item_order)
                                        <option value="{{ $item_order->prepare_order_number }}">{{ $item_order->prepare_order_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
    
                        
    
                        {{-- <div class="form-group">
                            <label class="d-block">Credit Note</label>
                            <div class="input-icon">
                                <select class="custom-select select2" name="invoice_number" id="invoice_number">
                                    <option value=""></option>
    
                                </select>
                            </div>
                        </div> --}}
    
                        
    
                        {{-- <div class="form-group">
                            <label class="d-block">ลูกค้า</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <input type="text" list="CustomerList" class="form-control" name="customer_id" id="customer_id" placeholder="" value="" onkeyup="selectCustomer();" onchange="selectCustomer();">
                                        <datalist id="CustomerList">
    
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" disabled name="customer_name" id="customer_name" placeholder="" value="">
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </form>
            </div>
            <div class="col-xl-6 m-auto">
                <div class="form-buttons no-border">
                    <button class="btn btn-lg btn-success" type="button" onclick="ClearRecript();"> ล้างข้อมูล</button>
                    <button class="btn btn-lg btn-white" type="button" onclick="search_print();"><i class="fa fa-search"></i> ค้นหา</button>
                </div>
            </div><!--col-xl-6-->

            <div class="col-md-12">
                <hr class="lg">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row justify-content f14">
                            <div class="col-xl-7 mt-4 mb-4">
                                <div class="row mb-2">
                                    <div class="col-md-2 text-left-sm">
                                        <span class="d-block">ตัวอักษร</span>
                                    </div>
                                    <div class="col-md-8">
                                        <ul class="table-legend-info">
                                            <li><span class="legend-item" style="background-color: #000"></span> สั่งซื้อปกติ</li>
                                            <li><span class="legend-item" style="background-color: red"></span> มีรายการส่งเสริม</li>
                                        </ul>
                                    </div>
                                </div><!--row-->
        
                                <div class="row">
                                    <div class="col-md-2 text-left-sm">
                                        <span class="d-block">แถบสี</span>
                                    </div>
                                    <div class="col-md-8">
                                        <ul class="table-legend-info">
                                            <li><span class="legend-item" style="background-color: #1c84c6"></span> Invoice ถูกยกเลิก</li>
                                            <li><span class="legend-item" style="background-color: #1ab394"></span> Credit Note</li>
                                        </ul>
                                    </div>
                                </div><!--row-->
        
                            </div><!--col-12-->
                        </div><!--row-->
                    </div>
                    <div class="col-md-3">
                        <div class="form-header-buttons">
                            <div class="buttons d-flex">
                                <button class="btn btn-md btn-white has-checkbox" type="button" onclick="check_all();">
                                <label><input type="checkbox" value="ALL" name="Check_ALL" id="check_all_input"><span> พิมพ์ทั้งหมด</span></label>
        
                                <button class="btn btn-md btn-primary" type="button" onclick="send_print();"><i class="fa fa-save"></i> บันทึก</button>
                            </button>
                            </div><!--buttons-->
                        </div><!--form-header-buttons-->
                    </div>
                </div>



                <div class="alert alert-warning alert-dismissible print-error-msg-print" id="close-btn-print" style="display: none;">
                    <button type="button" class="close" onclick="$('#close-btn-print').hide();">&times;</button>
                    <h5> Warning!</h5>
                    <ul></ul>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="table-responsive">
                    <form id="print_form_table" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                    <table class="table table-bordered text-center table-hover f13" id="dataTables-print">
                        <thead>
                            <tr class="align-middle">
                                <th>รายการที่</th>
                                <th>เลขที่ใบเตรียมขาย</th>
                                <th>วันที่ส่ง</th>
                                <th>ชื่อลูกค้า</th>
                                <th>จำนวนเงิน</th>
                                <th>พิมพ์</th>
                                <th>เลขที่ Invoice /<br>ใบขน/Credit Note</th>
                                <th>สถานะ Invoice /<br>ใบขน/Credit Note</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    </form>
                </div><!--table-responsive-->
            </div>
        </div><!--row-->
    </div><!--ibox-content-->
</div><!--ibox-->
@endsection

@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>

<script>
    var dateNow = '{{ $dateThai }}';

    $(document).ready(function(){
        $('.select2').select2();
        // $('.date').datepicker();
        // $("#dataTables-reprint").DataTable();
    });
    get_customer();
    getCreditNote();

    function search_print()
    {
        loading();
        const formdata = new FormData(document.getElementById("print_form"));
        $.ajax({
            url         : '{{ url("om/ajax/print-invoice/searchprint") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success:function(rest){
                Swal.close();
                var data = rest.data;
                if(data.status){
                    $("#dataTables-print").DataTable({
                        pageLength: 1000,
                        responsive: true,
                        data : data.data,
                        destroy : true,
                        "columns" : [
                            { 'data' : 'number' },
                            { 'data' : 'prepare_number' },
                            { 'data' : 'delivary_date', className : "text-left" },
                            { 'data' : 'customer_name', className : "text-left" },
                            { 'data' : 'total' , className : "text-right"},
                            { 'data' : 'reprint' },
                            { 'data' : 'invoice' },
                            { 'data' : 'status' },
                        ],
                        'order' : [[ 5,"desc" ]],
                        "scrollY":        "250vh",
                        "scrollCollapse": true,
                        "paging":         true,
                        rowCallback: function(row,data){
                            if(data.product_type_code == '20'){
                                $(row).css("color", "#2ba337");
                            }else if(data.row_status == 'invoice'){
                                $(row).addClass('tr-green');
                            }else if(data.row_status == 'invoice_cancel'){
                                $(row).addClass('tr-blue');
                            }else if(data.row_status == 'promo'){
                                $(row).addClass('red');
                            }
                        }
                    });
                }else{
                    $("#dataTables-print").DataTable({
                        pageLength: 10,
                        responsive: true,
                        data : [],
                        destroy : true,
                        rowCallback: function(row,data){
                            if(data.product_type_code == '20'){
                                $(row).css("color", "#2ba337");
                            }else if(data.row_status == 'invoice'){
                                $(row).addClass('tr-green');
                            }else if(data.row_status == 'invoice_cancel'){
                                $(row).addClass('tr-blue');
                            }else if(data.row_status == 'promo'){
                                $(row).addClass('red');
                            }
                        }
                    });
                }

                // if(data.customer != ''){
                //     $("#customer_name").val(rest.data.customer);
                // }
            }
        });
    }

    function ClearRecript()
    {
        $("#delivary_date").val(dateNow);
        $("#delivary_to").val(dateNow);
        $("#pre_order_number").val('').trigger('change');
        $("#pick_release").val('').trigger('change');
        $("#invoice_number").val('').trigger('change');
        $("#print_status").val('').trigger('change');
        $("#customer_id").val('').trigger('change');

        $("#dataTables-print").DataTable({
            pageLength: 10,
            responsive: true,
            data : [],
            destroy : true,
            rowCallback: function(row,data){
                if(data.product_type_code == '20'){
                    $(row).css("color", "#2ba337");
                }else if(data.row_status == 'invoice'){
                    $(row).addClass('tr-green');
                }else if(data.row_status == 'invoice_cancel'){
                    $(row).addClass('tr-blue');
                }else if(data.row_status == 'promo'){
                    $(row).addClass('red');
                }
            }
        });
    }

    function send_print()
    {
        loading();
        const formdata = new FormData(document.getElementById("print_form_table"));

        $.ajax({
            url         : '{{ url("om/ajax/print-invoice/save_print") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success : function(rest){
                Swal.close();
                var data = rest.data;
                if(data.status){
                    var invoice = '';
                    $.each($("input[name^=print]"),function(idx,elem){
                        if($(elem).prop('disabled')==false && $(elem).prop('checked')){
                            var order_id = $(elem).data('value');
                            invoice += ','+order_id;
                        }
                    });
                    window.open('{{ url("/om/print-invoice/report") }}?invoice='+invoice, '_blank');
                    search_print();
                    AlertToast('สำเร็จ','บันทึกข้อมูลแล้ว','success');
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgImport(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','บางอย่างผิดผลาดกรุณารองอีกครั้ง','error');
                    }
                }
            }
        });
    }

    function check_all()
    {
        if($("#check_all_input").prop('checked')){
            $(".print_invoice").prop('checked',true);
        }else{
            $(".print_invoice").prop('checked',false);
        }
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

    function getCreditNote(order_id = '')
    {
        loading();

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

    function selectCustomer()
    {
        var number      = $("#customer_id").val();
        var customer    = $("#CustomerList option[value='"+number+"']").html();

        $("#customer_name").val(customer);
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

    function printErrorMsgImport (msg) {
        $(".print-error-msg-print").find("ul").html('');
        $(".print-error-msg-print").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg-print").find("ul").append('<li>'+value+'</li>');
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
