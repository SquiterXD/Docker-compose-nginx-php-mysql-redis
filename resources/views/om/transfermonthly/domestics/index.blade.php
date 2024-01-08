@extends('layouts.app')

@section('title', 'โอนข้อมูลเพดานการจำหน่ายประจำเดือนเข้าระบบงานขาย')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
<x-get-page-title :menu="$menu" url="" />

    {{-- <h2>OMP0061 โอนข้อมูลเพดานการจำหน่ายประจำเดือนเข้าระบบงานขาย</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>	OMP0061 โอนข้อมูลเพดานการจำหน่ายประจำเดือนเข้าระบบงานขาย</strong>
        </li>
    </ol> --}}
@stop

@section('page-title-action')
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            {{-- <h3>โอนข้อมูลเพดานการจำหน่ายประจำเดือนเข้าระบบงานขาย</h3> --}}
        </div>
        <div class="ibox-content">
            <form id="import_form" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">

                    <div class="col-xl-6 m-auto">

                        <div class="form-group">
                            <label class="d-block">ปีงบประมาณ</label>
                            <div class="input-icon">
                                <input type="text" class="form-control"  name="year" placeholder="" value="" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="d-block">เดือน</label>
                            <div class="input-icon">
                                <select name="month" id="month" class="form-control select2">
                                    <option value=""></option>
                                    <option value="มกราคม">มกราคม</option>
                                    <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                    <option value="มีนาคม">มีนาคม</option>
                                    <option value="เมษายน">เมษายน</option>
                                    <option value="พฤษภาคม">พฤษภาคม</option>
                                    <option value="มิถุนายน">มิถุนายน</option>
                                    <option value="กรกฎาคม">กรกฎาคม</option>
                                    <option value="สิงหาคม">สิงหาคม</option>
                                    <option value="กันยายน">กันยายน</option>
                                    <option value="ตุลาคม">ตุลาคม</option>
                                    <option value="พฤศจิกายน">พฤศจิกายน</option>
                                    <option value="ธันวาคม">ธันวาคม</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label class="d-block">ครั้งที่</label>
                            <div class="input-icon">
                                <input type="number" class="form-control"  name="version" placeholder="" value="">
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <label class="d-block">File Excel ที่ต้องการนำเข้า</label>
                            <div class="custom-file ">
                                <input id="file_excel" type="file" name="excel_import" class="custom-file-input">
                                <label for="file_excel" class="custom-file-label has-icon-upload"></label>
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label class="d-block">Path Error Long file</label>
                            <div class="custom-file">
                                <input id="path_error_file" type="file" class="custom-file-input">
                                <label for="path_error_file" class="custom-file-label has-icon-save">:C/Error_Year</label>
                            </div>
                        </div> --}}

                        <div class="alert alert-warning alert-dismissible print-error-msg-import" id="close-btn-import" style="display: none;">
                            <button type="button" class="close" onclick="$('#close-btn-import').hide();">&times;</button>
                            <h5> Warning!</h5>
                            <ul></ul>
                        </div>

                        <div class="form-buttons no-border">
                            <button class="btn btn-lg btn-primary" type="button" onclick="downloadTemplate();" target="_blank" > พิมพ์ตัวอย่าง </button>
                            <button class="btn btn-lg btn-white" id="upload_excel" type="button" onclick="import_btn();$(this).prop('disabled',true);"  ><i class="fa fa-newspaper-o"></i> นำข้อมูลเข้า</button>
                        </div>
                        Status : {{ Cache::has('uploadFileQuata') ? Cache::get('uploadFileQuata') : 'ยังไม่มีการอัพโหลดไฟล์เข้าสู่ระบบ' }}
                        <br>
                        <br>
                        <p class="text-danger">1. กดพิมพ์ตัวอย่าง เพื่อทำการเตรียมข้อมูลผ่าน Excel</p>
                        <p class="text-danger">2. กรณีที่ ตราสินค้าใด ซื้อไม่มีเพดานจำหน่าย และต้องการให้สั่งซื้อได้ ให้ระบุจำนวน เช่น 9999 พันมวน</p>
                        <p class="text-danger">3. หากนำเข้าข้อมูล ไม่สำเร็จ ระบบจะแจ้งเตือน ข้อความ ให้แก้ไขไฟล์</p>
                    </div><!--col-xl-6-->


                </div><!--row-->
            </form>
        </div><!--ibox-content-->
    </div><!--ibox-->
@endsection

@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>
<script>
    $(".select2").select2();
    function import_btn()
    {
        loading();
        const formdata = new FormData(document.getElementById("import_form"));

        $.ajax({
            url         : '{{ url("om/ajax/transfer-monthly/inportexcel") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success : function(res){
                $('#upload_excel').prop('disabled',false);
                swal.close();
                var data = res.data;
                if(data.status){
                    // location.reload();
                    AlertToast('Success','Change Complete','success');
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgImport(data.data);
                    }else if(data.type == 'file'){
                        AlertToast('Waring','Someting Wrong please try again','error');
                        window.location.href = '{{ url("om/transfer-bi-weekly/domestic/files/") }}/' + data.data;
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }
                }
            }
        });
    }

    function downloadTemplate(){
        window.open('{{ url("om/ajax/transfer-monthly/export-example")  }}');
        // window.open("{{ asset('template/sales_forecast/ตัวอย่าง_เพดานการจำหน่าย.xlsx') }}");
    }

    function loading()
    {
        Swal.fire({
            title: 'Please Wait !',
            html: 'data uploading',// add html attribute if you want or remove
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
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
</script>
@stop
