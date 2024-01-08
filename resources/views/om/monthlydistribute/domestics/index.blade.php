@extends('layouts.app')

@section('title', 'โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
<x-get-page-title :menu="$menu" url="" />

    {{-- <h2> <x-get-program-code url="/om/monthly-distribute/domestic" /> โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย</h2> --}}
    {{-- <h2> OMP0057 โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>	OMP0057 โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย</strong> --}}
            {{-- <strong>	<x-get-program-code url="/om/monthly-distribute/domestic" /> โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย</strong>
        </li>
    </ol> --}}
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        {{-- <h3>โอนข้อมูลประมาณการจำหน่ายรายเดือนเข้าระบบงานขาย</h3> --}}
    </div>
    <div class="ibox-content">
        <form id="import_form" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">

                <div class="col-xl-6 m-auto">

                    <div class="form-group">
                        <label class="d-block">ประเภทสินค้า</label>
                        <div class="input-icon">
                            <select name="type" id="type" class="custom-select">
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
                                    <input type="text" class="form-control"  name="year" id="year" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');version_import(this.value);" placeholder="" value="">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="d-block">ครั้งที่ <span class="text-danger">*</span></label>
                                <input type="text" list="version_list" class="form-control"  name="version" id="version" placeholder="" value="" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
                                <datalist id="version_list">

                                </datalist>
                            </div>
                        </div><!--row-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">File Excel ที่ต้องการนำเข้า</label>
                        <div class="custom-file ">
                            <input id="file_excel" type="file" class="custom-file-input" name="import_excel">
                            <label for="file_excel" class="custom-file-label has-icon-upload"></label>
                        </div>
                    </div>
                    {{--
                    <div class="form-group">
                        <label class="d-block">Path Error file</label>
                        <div class="custom-file">
                            <input id="path_error_file" type="file" class="custom-file-input">
                            <label for="path_error_file" class="custom-file-label has-icon-save">:C/Error_</label>
                        </div>
                    </div> --}}

                    <div class="alert alert-warning alert-dismissible print-error-msg-import" id="close-btn-import" style="display: none;">
                        <button type="button" class="close" onclick="$('#close-btn-import').hide();">&times;</button>
                        <h5> Warning!</h5>
                        <ul></ul>
                    </div>

                    <div class="form-buttons no-border">
                        <button class="btn btn-lg btn-primary" type="button" onclick="downloadTemplate();" target="_blank" > พิมพ์ตัวอย่าง </button>
                        <button class="btn btn-lg btn-gray" type="button" onclick="importExcel();" ><i class="fa fa-newspaper-o"></i> นำข้อมูลเข้า</button>
                    </div>
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
    var type_save = 'product_type';
    function importExcel()
    {
        loading();
        const formdata = new FormData(document.getElementById("import_form"));
         formdata.append('type_item',type_save);

        $.ajax({
            url         : '{{ url("om/ajax/monthly-distribute/inportexcel") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success:function(rest){
                swal.close();
                // console.log(rest);
                var data = rest.data;
                if(data.status){
                    // window.location.reload();
                    $("#import_form")[0].reset();
                    $(".custom-file-label").html('');
                    AlertToast('Success','Change Complete','success');
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgImport(data.data);
                    }else if(data.type == 'file'){
                        AlertToast('Waring','Someting Wrong please try again','error');
                        window.location.href = '{{ url("om/monthly-distribute/domestic/files/") }}/' + data.data;
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
                                importExcel();
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
            },
            // complete : function(){
            //     swal.close();
            // },
            error : function(){
                swal.close();
                AlertToast('Waring','Someting Wrong please try again','error');
            }
        });
    }

    function downloadTemplate(){
        var type = $("#type").val();
        if(type == 'DOMESTIC'){
            window.open("{{ asset('template/sales_forecast/ตัวอย่าง_ประมาณการรายเดือน_ในประเทศ.xlsx') }}");
        }else{
            window.open("{{ asset('template/sales_forecast/ตัวอย่าง_ประมาณการรายเดือน_ต่างประเทศ.xlsx') }}");
        }
    }

    function version_import(year){
        var type = $("#type").val();
        $.ajax({
            url         : '{{ url("om/ajax/monthly-distribute/versionmonthly") }}',
            type        : 'post',
            data        : {
                year        : year,
                type        : type,
                '_token'    : '{{ csrf_token() }}',
            },
            success : function(res)
            {
                var html = ''
                $.each(res['data'],function(key,val){
                    html += '<option value="'+val.version+'" >'+val.version+'</option>'
                });

                $("#version_list").html(html);
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
