@extends('layouts.app')

@section('title', 'โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

    <style>
        input::-webkit-calendar-picker-indicator {
              opacity: 1;
           }
    </style>
@stop

@section('page-title')
<x-get-page-title :menu="$menu" url="" />
    {{-- <h2><x-get-program-code url="/om/transfer-bi-weekly/domestic" /> โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย</h2> --}}
    {{-- <h2> OMP0055 โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย</h2> --}}
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active"> --}}
            {{-- <strong><x-get-program-code url="/om/transfer-bi-weekly/domestic" /> โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย</strong> --}}
            {{-- <strong>OMP0055 โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย</strong> --}}
            {{-- <strong><x-get-page-title :menu="$menu" url="" /></strong>
        </li>
    </ol> --}}
@stop

@section('page-title-action')

@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            {{-- <h5>โอนข้อมูลประมาณการจำหน่ายรายปักษ์เข้าระบบงานขาย</h5> --}}
        </div>
        <div class="ibox-content">
            <form id="import_form" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="row space-50 justify-content-md-center mt-4 mw-xl-1000"><!--justify-content-md-center-->

                    <div class="col-xl-6 m-auto">

                        <div class="form-group">
                            <label class="d-block">ประเภทสินค้า</label>
                            <div class="input-icon">
                                <select name="type" id="type" class="custom-select select2">
                                    <option value="DOMESTIC">ขายในประเทศ</option>
                                    <option value="EXPORT">ขายต่างประเทศ</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">ปีงบประมาณ <span class="text-danger">*</span></label>
                                    <div class="input-icon">
                                        <input type="text" maxlength="4" class="form-control" name="year" id="year" onkeyup="year_import(this.value);version_import(this.value);"  placeholder="Ex: 2563" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        {{-- <i class="fa fa-search"></i> --}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block">ครั้งที่ <span class="text-danger">*</span></label>
                                    <input type="text" list="version_list" class="form-control"  name="version" id="version"  placeholder="Ex: 1" value="" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
                                    <datalist id="version_list">
                                        <option value=""></option>
                                    </datalist>
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">ปักษ์ที่ <span class="text-danger">*</span></label>
                                    <div class="input-icon">
                                        <input type="text" list="biweek" class="form-control" name="pung_no" id="pung_no" placeholder="Ex: 1" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
                                        <datalist id="biweek" >

                                        </datalist>
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block">ถึง <span class="text-danger">*</span></label>
                                    <div class="input-icon">
                                        <input type="text" list="biweek_to" class="form-control" name="pung_to" id="pung_to" placeholder="Ex: 24" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
                                        <datalist id="biweek_to" >

                                        </datalist>
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">File Excel ที่ต้องการนำเข้า <span class="text-danger">*</span></label>
                            <div class="custom-file ">
                                <input id="file_excel" type="file" class="custom-file-input" name="biweek_excel" >
                                <label for="file_excel" class="custom-file-label has-icon-upload"></label>
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label class="d-block">Path Error file</label>
                            <div class="custom-file">
                                <input id="path_error_file" type="file" disabled class="custom-file-input" name="error_part" >
                                <label for="path_error_file" class="custom-file-label has-icon-save"></label>
                            </div>
                        </div> --}}

                        <div class="alert alert-warning alert-dismissible print-error-msg-import" id="close-btn-import" style="display: none;">
                            <button type="button" class="close" onclick="$('#close-btn-import').hide();">&times;</button>
                            <h5> Warning!</h5>
                            <ul></ul>
                        </div>

                        <div class="form-buttons no-border">
                            <button class="btn btn-lg btn-primary" type="button" onclick="downloadTemplate();" target="_blank" > พิมพ์ตัวอย่าง </button>
                            <button class="btn btn-lg btn-gray" onclick="uploadExcel();" type="button"><i class="fa fa-newspaper-o"></i> นำข้อมูลเข้า</button>
                        </div>
                    </div><!--col-xl-6-->
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>
<script>
    var type_save = 'product_type';

    $(".select2").select2();
    function uploadExcel()
    {
        loading();
        const formdata = new FormData(document.getElementById("import_form"));
        formdata.append('type_item',type_save);
        $.ajax({
            url         : '{{ url("om/ajax/transfer-bi-weekly/inportexcel") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success : function(res){
                swal.close();
                var data = res.data;
                if(data.status){
                    $("#import_form")[0].reset();
                    $(".custom-file-label").html('');
                    AlertToast('Success','Change Complete','success');
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgImport(data.data);
                    }else if(data.type == 'file'){
                        AlertToast('Waring','Someting Wrong please try again','error');
                        window.location.href = '{{ url("om/transfer-bi-weekly/domestic/files/") }}/' + data.data;
                        $("#import_form")[0].reset();
                        $(".custom-file-label").html('');
                    }else if(data.type == 'itemuom'){
                        Swal.fire({
                            title:  'Warning',
                            html:   'ไม่สามารถหา UOM ของประเภทสินค้า '+data.desc+' ได้ จะใช้ Primary UOM ของระบบ Inventory แทนหรือไม่',// add html attribute if you want or remove
                            focusConfirm: false,
                            showCancelButton: true,
                            preConfirm: () => {
                                type_save = 'item_type';
                                uploadExcel();
                            },
                            preCancel:() => {
                                $("#import_form")[0].reset();
                                $(".custom-file-label").html('');
                            }
                        });
                    }else{
                        if(data.message){
                            AlertToast('Waring',data.message,'error');
                        }else{
                            AlertToast('Waring','Someting Wrong please try again','error');
                        }
                        $("#import_form")[0].reset();
                        $(".custom-file-label").html('');
                    }
                }
            }
        });
    }

    function downloadTemplate(){
        var type = $("#type").val();
        if(type == 'DOMESTIC'){
            window.open("{{ asset('template/sales_forecast/ตัวอย่าง_ประมาณการรายปักษ์_ในประเทศ.xlsx') }}");
        }else{
            window.open("{{ asset('template/sales_forecast/ตัวอย่าง_ประมาณการรายปักษ์_ต่างประเทศ.xlsx') }}");
        }
    }

    function year_import(year){
        var type = $("#type").val();
        $.ajax({
            url         : '{{ url("om/ajax/transfer-bi-weekly/yearbiweek") }}',
            type        : 'post',
            data        : {
                year        : year,
                type        : type,
                '_token'    : '{{ csrf_token() }}',
            },
            success : function(res)
            {
                if(res.status){
                    var html = ''
                    $.each(res['data'],function(key,val){
                        html += '<option value="'+val.biweekly_no+'" ></option>'
                    });

                    $("#biweek").html(html);
                    $("#biweek_to").html(html);
                }else{
                    var html = ''

                    $("#biweek").html(html);
                    $("#biweek_to").html(html);
                }

            }
        });
    }

    function version_import(year){
        var type = $("#type").val();
        $.ajax({
            url         : '{{ url("om/ajax/transfer-bi-weekly/versionbiweek") }}',
            type        : 'post',
            data        : {
                year        : year,
                type        : type,
                '_token'    : '{{ csrf_token() }}',
            },
            success : function(res)
            {
                if(res.status){
                    var html = ''
                    $.each(res['data'],function(key,val){
                        html += '<option value="'+val.version+'" >'+val.version+'</option>'
                    });

                    $("#version_list").html(html);
                }else{
                    var html = ''
                    $("#version_list").html(html);
                }
            }
        });
    }

    function printErrorMsgImport (msg) {
        $(".print-error-msg-import").find("ul").html('');
        $(".print-error-msg-import").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg-import").find("ul").append('<li>'+value+'</li>');
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

</script>
@stop
