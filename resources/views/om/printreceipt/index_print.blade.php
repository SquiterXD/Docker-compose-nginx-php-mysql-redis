@extends('layouts.app')

@section('title', 'พิมพ์ใบเสร็จรับเงิน (กองคลังผลิตภัณฑ์)')

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
    <h2>{{-- <x-get-program-code url="/om/print-receipt/print" />  --}}OMP0027 พิมพ์ใบเสร็จรับเงิน (กองคลังผลิตภัณฑ์)</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> {{-- <x-get-program-code url="/om/print-receipt/print" /> --}}OMP0027 พิมพ์ใบเสร็จรับเงิน (กองคลังผลิตภัณฑ์)</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>พิมพ์ใบเสร็จรับเงิน (กองคลังผลิตภัณฑ์)</h3>
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
                    <label class="d-block">วันที่ใบเสร็จรับเงิน</label>
                    <div class="input-icon">
                        <datepicker-th
                            style="width: 100%"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="payment_date"
                            id="payment_date"
                            placeholder="โปรดเลือกวันที่"
                            value="{{ $dateThai }}"
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


                <div class="form-buttons">
                    <button class="btn btn-lg btn-success" type="button" onclick="ClearRecript();"> ล้างข้อมูล</button>
                    <button class="btn btn-lg btn-white" type="button" onclick="searchRecript();"><i class="fa fa-search"></i> ค้นหา</button>
                </div>
            </div><!--col-xl-6-->

            <div class="col-md-12">

                <hr class="lg">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="table-legend-info">
                            <li>แถบสี <span class="legend-item" style="background-color: #23c6c8"></span> มีการยกเลิกใบเสร็จรับเงิน</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="form-header-buttons">
                            <button class="btn btn-md btn-white has-checkbox ml-auto" type="button" >
                                <label><input type="checkbox" value="option_0" name="a" onclick="check_all();" id="check_all_input"><span> พิมพ์ทั้งหมด</span></label>
                                <button class="btn btn-md btn-primary" style="margin-left: 10px;" type="button" onclick="print_data();" ><i class="fa fa-save"></i> บันทึก</button>
                            </button>
                        </div><!--form-header-buttons-->
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="table-responsive">
                    <form id="form_table">
                        <table class="table table-bordered table-hover text-center" id="dataTables-print">
                            <thead>
                                <tr class="align-middle text-center">
                                    <th class="w-160">เลขที่ใบเสร็จรับเงิน</th>
                                    <th>วันที่ใบเสร็จรับเงิน</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>จำนวนเงิน</th>
                                    <th class="w-90">พิมพ์</th>
                                    <th class="w-90">พิมพ์แล้ว</th>
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
    var dateNow = '{{ $dateThai }}';
    $(document).ready(function(){
        $("#dataTables-print").DataTable();
        $(".select2").select2();
    });

    function ClearRecript()
    {
        $("#payment_date").val(dateNow);
        $("#receript_number").val('').trigger('change');
        $("#dataTables-print").DataTable({
            pageLength: 100,
            responsive: true,
            data : [],
            destroy : true,
        });
    }

    function searchRecript()
    {
        var payment_date    = $("#payment_date").val();
        var receript_number = $("#receript_number").val();

        loading();
        $.ajax({
            url     : '{{ url("om/ajax/print-receipt/searchreceipt") }}',
            type    : 'post',
            data    : {
                '_token'            : '{{ csrf_token() }}',
                payment_date        : payment_date,
                receript_number     : receript_number,
            },
            success:function(rest){
                swal.close();
                if(rest.data != ''){
                    $("#dataTables-print").DataTable({
                        pageLength: 50,
                        responsive: true,
                        data : rest.data.data,
                        destroy : true,
                        "columns" : [
                            { 'data' : 'recripet_number' },
                            { 'data' : 'payment_date' , className : "text-left" },
                            { 'data' : 'customer_name', className : "text-left"  },
                            { 'data' : 'total_payment_amount' , className : "text-right" },
                            { 'data' : 'unlock' },
                            { 'data' : 'reprint' },
                        ],
                        'order' : [[ 4,"desc" ]],
                        "scrollY":        "250vh",
                        "scrollCollapse": true,
                        "paging":         true,
                        rowCallback: function(row,data){
                            if(data.payment_status == 'Cancel'){
                                $(row).addClass('bg-info');
                            }
                        }
                    });
                }else{
                    $("#dataTables-print").DataTable({
                        pageLength: 100,
                        responsive: true,
                        data : [],
                        destroy : true,
                    });
                }
            }
        });
    }

    function print_data()
    {
        const formdata = new FormData(document.getElementById("form_table"));
        formdata.append('_token','{{ csrf_token() }}');
        // console.log(...formdata);
        loading();
        $.ajax({
            url         : '{{ url("om/ajax/print-receipt/print_data") }}',
            type        : 'POST',
            cache       : false,
            processData : false,
            contentType : false,
            data        : formdata,
            success     : function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    if(data.print){
                        var form = document.getElementById("form_table");
                        form.setAttribute("method", "get");
                        form.setAttribute("target", "_blank");
                        form.setAttribute("action", '{{ url("om/print-receipt/print-content") }}');
                        form.submit();
                        // window.open('{{ url("om/print-receipt/print-content") }}?' + form,'_blank');
                    }
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
            $(".print_data").prop('checked',true);
        }else{
            $(".print_data").prop('checked',false);
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
