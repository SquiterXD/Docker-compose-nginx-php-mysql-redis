@extends('layouts.app')
<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }

    .chosen-container-single .chosen-single {
        min-height: 40px !important;
        background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px !important;
        font-size: 0.9rem !important;
    }

    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    table.dataTable {
        font-size: 0.9rem;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

    .table-responsive{
        overflow-y: auto;
        height: 575px;
    }

</style>

@section('title', 'กำหนดลำดับผลิตภัณฑ์ในการประมาณการจำหน่ายรายปักษ์')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <x-get-page-title :menu="$menu" url="" />
    {{-- <h2>
        OMP0053 กำหนดลำดับผลิตภัณฑ์ในการประมาณการจำหน่ายรายปักษ์
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดลำดับผลิตภัณฑ์ในการประมาณการจำหน่ายรายปักษ์</strong>
        </li>
    </ol> --}}
@stop

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            {{-- <h3>{{ !empty($menu->menu_title) ? $menu->menu_title : '' }}</h3> --}}
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <form id="formSequenceEcome" autocomplete="off" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <div class="form-header-buttons flex-md-row-reverse">
                            <div class="buttons d-flex">
                                {{-- <button class="btn btn-md btn-success" type="button" onclick="createSequenceEcoms();"><i class="fa fa-plus"></i> สร้าง</button> --}}
                                {{-- <button class="btn btn-md btn-danger" type="button" onclick="deleteSequenceEcoms();" id="buttonDelete"><i class="fa fa-times"></i> ลบ</button> --}}
                                <div class="dropdown w-150">
                                    <select class="custom-select" name="sale_type_code" id="sale_type_code" onchange="filterData()">
                                        <option selected value="1" > ขายในประเทศ </option>
                                        <option  value="2" > ขายต่างประเทศ </option>
                                        <option  value="3" > ทั้งหมด </option>
                                    </select>
                                </div>
                                <button class="btn btn-md btn-primary" type="button" onclick="updateSequenceEcoms();" id="buttonUpdate"><i class="fa fa-save"></i> บันทึก</button>
                            </div>

                            <button class="btn btn-md btn-white has-checkbox mt-2 mt-md-0" type="button" style="display:none;">
                                <div class="i-checks" id="checkAll">
                                    <label>
                                        <input type="checkbox" name="sequenceAll" id="sequenceAll">
                                        <span> เลือกทั้งหมด</span>
                                    </label>
                                </div>
                            </button>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="alert alert-warning alert-dismissible print-error-msg-shipping" id="close-btn-sequence" style="display: none;">
                            <button type="button" class="close" onclick="$('#close-btn-sequence').hide();">&times;</button>
                            <h5> Warning!</h5>
                            <ul></ul>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center">
                                <tbody>
                                    <tr class="align-middle text-center">
                                        {{-- <th class="w-90">เลือก<br>รายการ</th> --}}
                                        <th class="w-160">รหัสผลิตภัณฑ์</th>
                                        <th>ชื่อตราผลิตภัณฑ์</th>
                                        <th class="w-90">ลำดับหน้าจอ</th>
                                        <th class="w-201">ตราหลัก/ตรารอง/อื่นๆ</th>
                                        <th class="w-201">ประเภท</th>
                                        <th class="w-201">รสชาติ</th>
                                    </tr>
                                </tbody>
                                <tbody id="showSequenceEcom">
                                    @if (!$sequenceEcoms->isEmpty())
                                    @foreach ($sequenceEcoms as $key => $item)
                                    <tr class="align-middle">
                                        {{-- <td>
                                            <div class="i-checks wihtout-text m-auto checkMark">
                                                <label>
                                                    <input type="checkbox" class="check" name="select_sequence[{{ $item->sequence_ecom_id }}]">
                                                    <input type="hidden" name="sequence_ecom_id[{{ $item->sequence_ecom_id }}]" value="{{ $item->sequence_ecom_id }}">
                                                </label>
                                            </div>
                                        </td> --}}
                                        <td>{{ $item->item_code }} <input type="hidden" name="sequence_ecom_id[{{ $item->sequence_ecom_id }}]" value="{{ $item->sequence_ecom_id }}"></td>
                                        <td class="text-left">{{ $item->item_description }}</td>
                                        <td><input type="text" class="form-control text-center" name="forecast_screen_no[{{ $item->sequence_ecom_id }}]" value="{{ $item->forecast_screen_no }}" onkeypress="return isNumber(event)" autocomplete="none" ></td>
                                        <td>
                                            <select class="custom-select" name="forecast_stamp[{{ $item->sequence_ecom_id }}]">
                                                @foreach ($productCategoryCode as $value)
                                                <option {{ $item->forecast_stamp == $value->lookup_code ? 'selected' : '' }} value="{{ $value->lookup_code }}" >{{ $value->description }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-left">{{ $item->filter_flag }}</td>
                                        <td>{{ $item->description }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div><!--table-responsive-->
                    </div><!--col-xl-12-->
                </form>
            </div><!--row-->

        </div><!--ibox-content-->
    </div><!--ibox-->

@endsection

@section('scripts')
    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
    <script src="{!! asset('custom/custom.js') !!}"></script>

    <script>
        $(document).ready(function(){

            // $('.custom-select').chosen({width: "100%"});

        });

    </script>

    <script>

        var sequenceEcom = [];
        var productCategory = @json($productCategoryCode);
        var checkStamp = '';

        function createSequenceEcoms()
        {
            Swal.fire({
                icon: 'warning',
                text: 'Coming soon...',
                showConfirmButton: true
            });
        }

        function updateSequenceEcoms()
        {
            $('#buttonUpdate').attr('disabled', true);

            Swal.fire({
                text: 'ต้องการบันทึกข้อมูลหรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ใช่, บันทึกข้อมูล',
                cancelButtonText: 'ยกเลิก',
                onClose: enableButton
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#buttonUpdate').attr('disabled', true);
                    const formData = new FormData(document.getElementById("formSequenceEcome"));
                    formData.append('_token','{{ csrf_token() }}');

                    $.ajax({
                        url         : '{{ url("om/ajax/fortnightly/update-sequence-ecom") }}',
                        type        : 'post',
                        data        : formData,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        success     : function(res){
                            console.log(res);
                            var sequenceEcom = res.data.dataList;
                            swal.close();
                            if(res.data.status){
                                html = '';
                                $.each(sequenceEcom, function(key,val)
                                {
                                    html += '<tr class="align-middle">';
                                    html += '    <td>'+val.item_code+' <input type="hidden" name="sequence_ecom_id['+val.sequence_ecom_id+']" value="'+val.sequence_ecom_id+'"></td>';
                                    html += '    <td class="text-left">'+val.item_description+'</td>';
                                    html += '    <td><input type="text" class="form-control text-center" name="forecast_screen_no['+val.sequence_ecom_id+']" value="'+val.forecast_screen_no+'" onkeypress="return isNumber(event)" autocomplete="none"></td>';
                                    html += '    <td>';
                                    html += '        <select class="custom-select" name="forecast_stamp['+val.sequence_ecom_id+']">';

                                    $.each(productCategory, function(key,valCategory){
                                        if (val.forecast_stamp == valCategory.lookup_code ) {
                                            checkStamp = 'selected';
                                        } else {
                                            checkStamp = '';
                                        }
                                    html += '            <option '+checkStamp+' value="'+ valCategory.lookup_code +'">'+ valCategory.description +'</option>';
                                    });

                                    html += '        </select>';
                                    html += '    </td>';
                                    html += '    <td class="text-left">'+val.filter_flag+'</td>';
                                    html += '    <td>'+val.description+'</td>';
                                    html += '</tr>';

                                });
                                $('#showSequenceEcom').html(html);
                                $('#buttonUpdate').attr('disabled', false);

                                $('.check').iCheck({
                                    checkboxClass: 'icheckbox_square-green'
                                });

                                Swal.fire({
                                    icon: 'success',
                                    text: 'อัพเดทข้อมูลเรียบร้อยแล้ว',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }else{
                                if(data.type == 'validate'){
                                    Swal.fire({
                                        icon: 'error',
                                        text: data,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }else{
                                    Swal.fire({
                                            icon: 'error',
                                            text: 'เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                }
                                $('#buttonUpdate').attr('disabled', false);
                            }
                        }
                    });
                }
            });
        }

        function deleteSequenceEcoms()
        {
            if($('.check').filter(':checked').length <= 0){
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณาเลือกผลิตภัณฑ์อย่างน้อย 1 รายการ!'
                });
                return false;
            }

            Swal.fire({
                text: 'ต้องการลบข้อมูลที่เลือกหรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ED5565',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ใช่, ลบข้อมูล',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#buttonDelete').attr('disabled', true);
                    const formData = new FormData(document.getElementById("formSequenceEcome"));
                    formData.append('_token','{{ csrf_token() }}');

                    $.ajax({
                        url         : '{{ url("om/ajax/fortnightly/delete-sequence-ecom") }}',
                        type        : 'post',
                        data        : formData,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        success     : function(res){
                            console.log(res);
                            var sequenceEcom = res.data.dataList;
                            if(res.data.status){
                                html = '';
                                $.each(sequenceEcom, function(key,val)
                                {
                                    checkStampMain = val.forecast_stamp == 10 ? 'selected' : '';
                                    checkStampSecondary = val.forecast_stamp == 20 ? 'selected' : '';
                                    checkOther = val.forecast_stamp == 30 ? 'selected' : '';

                                    html += '<tr class="align-middle">';
                                    html += '    <td>'+val.item_code+' <input type="hidden" name="sequence_ecom_id['+val.sequence_ecom_id+']" value="'+val.sequence_ecom_id+'"></td>';
                                    html += '    <td class="text-left">'+val.item_description+'</td>';
                                    html += '    <td><input type="text" class="form-control text-center" name="forecast_screen_no['+val.sequence_ecom_id+']" value="'+val.forecast_screen_no+'" onkeypress="return isNumber(event)" autocomplete="none"></td>';
                                    html += '    <td>';
                                    html += '        <select class="custom-select" name="forecast_stamp['+val.sequence_ecom_id+']">';
                                    html += '            <option '+checkStampMain+' value="10">ตราหลัก</option>';
                                    html += '            <option '+checkStampSecondary+' value="20">ตรารอง</option>';
                                    html += '            <option '+checkOther+' value="30">อื่นๆ</option>';
                                    html += '        </select>';
                                    html += '    </td>';
                                    html += '    <td class="text-left">'+val.filter_flag+'</td>';
                                    html += '    <td>'+val.description+'</td>';
                                    html += '</tr>';

                                });
                                $('#showSequenceEcom').html(html);
                                $('#buttonDelete').attr('disabled', false);

                                $('.check').iCheck({
                                    checkboxClass: 'icheckbox_square-green'
                                });

                                Swal.fire({
                                    icon: 'success',
                                    text: 'ลบข้อมูลผลิตภัณฑ์ที่เลือกเรียบร้อยแล้ว',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }else{
                                $('#buttonDelete').attr('disabled', false);
                                Swal.fire({
                                    icon: 'error',
                                    text: 'ดำเนินการไม่สำเร็จ กรุณาลองใหม่',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        }
                    });
                }
            });
        }

        function isNumber(evt)
        {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function enableButton()
        {
            $('#buttonUpdate').attr('disabled', false);
        }



        var triggeredByChild = false;

        $('#checkAll').on('ifChecked', function (event) {
            $('.check').iCheck('check');
            triggeredByChild = false;
        });

        $('#checkAll').on('ifUnchecked', function (event) {
            if (!triggeredByChild) {
                $('.check').iCheck('uncheck');
            }
            triggeredByChild = false;
        });

        // Removed the checked state from "All" if any checkbox is unchecked
        $('.checkMark').on('ifUnchecked', function (event) {
            triggeredByChild = true;
            $('#checkAll').iCheck('uncheck');
        });

        $('.checkMark').on('ifChecked', function (event) {
            if ($('.check').filter(':checked').length == $('.check').length) {
                $('#checkAll').iCheck('check');
            }
        });

        function filterData()
        {
            swal.showLoading();

            const formData = new FormData(document.getElementById("formSequenceEcome"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/fortnightly/filter-sequence-ecom") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    console.log(res);
                    var sequenceEcom = res.data.dataList;
                    if(res.data.status){
                        html = '';
                        $.each(sequenceEcom, function(key,val)
                        {
                            html += '<tr class="align-middle">';
                            html += '    <td>'+val.item_code+' <input type="hidden" name="sequence_ecom_id['+val.sequence_ecom_id+']" value="'+val.sequence_ecom_id+'"></td>';
                            html += '    <td class="text-left">'+val.item_description+'</td>';
                            html += '    <td><input type="text" class="form-control text-center" name="forecast_screen_no['+val.sequence_ecom_id+']" value="'+val.forecast_screen_no+'" onkeypress="return isNumber(event)" autocomplete="none"></td>';
                            html += '    <td>';
                            html += '        <select class="custom-select" name="forecast_stamp['+val.sequence_ecom_id+']">';

                            $.each(productCategory, function(key,valCategory){
                                if (val.forecast_stamp == valCategory.lookup_code ) {
                                    checkStamp = 'selected';
                                } else {
                                    checkStamp = '';
                                }
                            html += '            <option '+checkStamp+' value="'+ valCategory.lookup_code +'">'+ valCategory.description +'</option>';
                            });

                            html += '        </select>';
                            html += '    </td>';
                            html += '    <td class="text-left">'+val.filter_flag+'</td>';
                            html += '    <td>'+val.description+'</td>';
                            html += '</tr>';

                        });
                        $('#showSequenceEcom').html(html);
                        $('#buttonDelete').attr('disabled', false);

                    }else{
                        $('#buttonDelete').attr('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            text: 'ดำเนินการไม่สำเร็จ กรุณาลองใหม่',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }

                    swal.close();
                }
            });
        }


    </script>
@stop
