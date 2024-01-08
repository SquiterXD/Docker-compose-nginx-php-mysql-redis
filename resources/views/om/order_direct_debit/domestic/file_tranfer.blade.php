@extends('layouts.app')

@section('title', 'โอนข้อมูล Text File เพื่อส่งธนาคาร')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <style>
        #page-wrapper{
            width: calc(100% - 220px);
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
        #table_direct_debit{
            display: none;
        }
    </style>
    <style>
        .btn-success {
            color: #fff !important;
            background-color: #1c84c6 !important;
            border-color: #1c84c6 !important;
        }
    </style>
@stop

@section('page-title')
    <h2><x-get-program-code url="/om/order-direct-debit/domestic/file-tranfer" /> โอนข้อมูล Text File เพื่อส่งธนาคาร</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/order-direct-debit/domestic/file-tranfer" /> โอนข้อมูล Text File เพื่อส่งธนาคาร</strong>
        </li>
    </ol>
@stop

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h3>โอนข้อมูล Text File เพื่อส่งธนาคาร</h3>
            <div class="pull-right">
                <a class="btn btn-white" href="{{ url('/') }}/om/order-direct-debit/domestic/file-tranfer/"><i class="fa fa-repeat"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">

                    <form id="form-data" data-action="{{ url('/') }}/om/order-direct-debit/domestic/prepare-file-tranfer" data-actionconfirm="{{ url('/') }}/om/order-direct-debit/domestic/prepare-file-tranfer">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <h3 class="black mb-3">ส่งข้อมูลระบบ Direct Debit</h3>

                            <label class="d-block">รหัสธนาคาร</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon mr-md-2 mr-0">
                                        <input type="text" class="form-control" autocomplete="off" required name="bank_id" id="bank_id" placeholder="" list="bank-list" onchange="bankchange(this.value);">
                                        <i class="fa fa-search"></i>
                                        <datalist id="bank-list">
                                            @foreach ($bankAccountSearch as $item)
                                                <option data-value="{{ $item->bank_number }}">{{ $item->bank_number }} : {{ $item->bank_name }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" readonly name="bank_name" id="bank_name" placeholder="" value="">
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">วันที่ส่ง</label>
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control"
                                        name="from_date"
                                        id="from_date"
                                        placeholder="โปรดเลือกวันที่"
                                        value="{{ dateFormatThai(date('m/d/Y')) }}"
                                        format="{{ trans("date.js-format") }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block">ถึงวันที่</label>
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control"
                                        name="to_date"
                                        id="to_date"
                                        placeholder="โปรดเลือกวันที่"
                                        value="{{ dateFormatThai(date('m/d/Y')) }}"
                                        format="{{ trans("date.js-format") }}">
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">วันครบกำหนดชำระเงิน</label>
                            <datepicker-th
                                style="width: 100%"
                                class="form-control"
                                name="due_date"
                                id="due_date"
                                placeholder="โปรดเลือกวันที่"
                                value="{{ (request()) ? request()->due_date : '' }}"
                                format="{{ trans("date.js-format") }}">
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">ชื่อไฟล์</label>
                            <input type="text" class="form-control" disabled="" name="file_path" id="file_path" placeholder="" value="">
                        </div><!--form-group-->


                        <div class="container form-group form-buttons d-block">
                            <div class="row space-5">
                                <div class="col-md-4 col-4 mb-2">
                                    <button class="btn btn-lg btn-white m-0 w-100" style="max-width: 100%;" type="button" onclick="search()"><i class="fa fa-search"></i> ค้นหา</button>
                                </div>

                                <div class="col-md-4 col-4 mb-2">
                                    <button class="btn btn-lg btn-warning m-0 w-100" style="max-width: 100%;" type="button" id="prepare_order" onclick="genfile()"><i class="fa fa-pencil-square-o"></i> จัดเตรียมข้อมูล</button>
                                </div>

                                <div class="col-md-4 col-4 mb-2">
                                    <button class="btn btn-lg btn-success m-0 w-100" style="max-width: 100%;" disabled type="button" id="confirm_download" onclick="download_file()"><i class="fa fa-file-text-o"></i> ยืนยันข้อมูล</button>
                                </div>
                            </div><!--row-->
                        </div>
                        <button type="submit" style="display:none;" id="bt_submit"></button>
                    </form>
                </div><!--col-xl-6-->
            </div>
            @include('om/order_direct_debit/domestic/_table')
        </div><!--ibox-content-->
    </div><!--ibox-->

@endsection

@section('scripts')
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
<script>

    $(".select2").select2();
    let banklists = {!! json_encode($bankAccountSearch) !!};
    let actions_url = '';
    let actions_type = '';
    let file_name = ''
    let batch_no = '';
    let alert_text = '';
    let count_download = 0;
    // Action Direct debit
    $('#prepare_order').prop("disabled", true);
    $('#confirm_download').prop("disabled", true);
    $('#direct_debit_all').on('ifChecked', function (event) {
        $('.direct_debit_flag').prop( "checked", true );
    });
    $('#direct_debit_all').on('ifUnchecked', function (event) {
        $('.direct_debit_flag').prop( "checked", false );
    });

    function bankchange(v){
        var number = v.split(" : ")[0];
        $('#bank_id').val(number)
        if(v != ''){
            var index = _.findIndex(banklists, function(o) {return o['bank_number'] == number;});
            if(index != -1){
                $('#bank_name').val(banklists[index]['bank_name']);
            }
        }else{
            $('#bank_name').val('');
        }
    }

    function search() {
        actions_type = 'search'
        actions_url = "{{ url('/') }}/om/order-direct-debit/domestic/search"
        $('#bt_submit').click();
    }

    function genfile() {
        actions_type = 'gen'
        alert_text = 'คุณต้องการจัดเตรียมข้อมูล ใช่หรือไม่?'
        actions_url = "{{ url('/') }}/om/order-direct-debit/domestic/prepare-file-tranfer"
        $('#bt_submit').click();
    }

    function download_file() {
        actions_type = 'download'
        alert_text = 'คุณต้องการยืนยันข้อมูล ใช่หรือไม่?'
        actions_url = "{{ url('/') }}/om/order-direct-debit/domestic/confirm-file/"+batch_no+"?count_download="+count_download
        $('#bt_submit').click();
    }

    function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
        try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
            console.log(e)
        }
    };

    $("#form-data").submit(async function(e) {
        e.preventDefault();
        let fb = this // this
        let formData = new FormData(fb);

        if (actions_type == 'search') {
            Swal.fire({
                title: 'กำลังประมวณผล',
                showConfirmButton: false,
            });
            $('#prepare_order').prop("disabled", true);
            $('#confirm_download').prop("disabled", true);
            $('#direct_debit_all').iCheck('uncheck');
            $.ajax({
                type: 'post',
                url: actions_url,
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if(result.data.length > 0){
                        var elTb = $("#table_direct_debit > tbody")
                        elTb = $("#table_direct_debit > tbody").html('')
                        var htmlTb = '';
                        $('#table_direct_debit').css('display','none')

                        $.each(result.data, function( key, obj ) {
                            var order_date = obj.order_delivery_date
                            if(obj.order_delivery_date != null){
                                order_date = order_date.split(' ');
                                order_date = order_date[0].split('-');
                                order_date = (order_date[2])+'/'+(order_date[1])+'/'+(parseInt(order_date[0])+543)
                            }else{
                                order_date = ''
                            }

                            var approve_date = obj.approve_date
                            if(obj.approve_date != null){
                                approve_date = approve_date.split(' ');
                                approve_date = approve_date[0].split('-');
                                approve_date = (approve_date[2])+'/'+(approve_date[1])+'/'+(parseInt(approve_date[0])+543)
                            }else{
                                approve_date = ''
                            }

                            htmlTb += '<tr class="align-middle">';
                                htmlTb += '<td><div class="i-checks"> <input type="checkbox" value="'+obj.prepare_order_number+'" class="direct_debit_flag" name="direct_debit_flag_'+obj.prepare_order_number+'" id="direct_debit_flag_'+obj.prepare_order_number+'"></div></td>';
                                htmlTb += '<td>'+(key+1)+'</td>';
                                htmlTb += '<td>'+obj.prepare_order_number+'</td>';
                                htmlTb += '<td>'+order_date+'</td>';
                                htmlTb += '<td>'+obj.customer_name+'</td>';
                                htmlTb += '<td>'+obj.dayAmount+'</td>';
                                htmlTb += '<td class="text-left">'+obj.bank_account_name+'</td>';
                                htmlTb += '<td>'+obj.toat_bank_account_name+'</td>';
                                htmlTb += '<td class="text-right">'+formatMoney(obj.direct_debit_amount, 2)+'</td>';
                                htmlTb += '<td>'+approve_date+'</td>';
                            htmlTb += '</tr>';
                        });

                        elTb.append(htmlTb);

                        $('#table_direct_debit').css('display','table')
                        file_name = '';
                        batch_no = '';
                        $('#file_path').val('');
                        $('#prepare_order').prop("disabled", false);
                        Swal.close()
                    }else{
                        Swal.fire({
                            title: 'แจ้งเตือน',
                            text: "ไม่พบข้อมูล",
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }else{
            // Add lines for choose list export
            $.each($('.direct_debit_flag:checked'), function(k, i){
                formData.append('lines[]', $(i).val());
            })

            Swal.fire({
                title: 'แจ้งเตือน',
                text: alert_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: actions_url,
                        data: formData,
                        enctype: 'multipart/form-data',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if(actions_type == 'gen'){
                                if(result.data.length > 0){
                                    // ------------------------------------------------------------------------
                                    file_name = result.fileTran.file_name
                                    batch_no = result.fileTran.batch_no
                                    // $('#file_path').val(result.fileTran.file_path+'/'+result.fileTran.file_name)
                                    $('#file_path').val('');
                                    $('#confirm_download').prop("disabled", false);
                                    // ------------------------------------------------------------------------
                                    // add url download file pdf
                                    window.open(result.redirect_report, '_blank');
                                    Swal.close()
                                }else{
                                    $('#confirm_download').prop("disabled", true);
                                    Swal.fire({
                                        title: 'แจ้งเตือน',
                                        text: "ไม่พบข้อมูล กรุณาเลือกรายการที่ต้องการโอนข้อมูล",
                                        icon: 'warning',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            }else{
                                count_download += 1
                                if(result.fileTran.file_name != undefined){
                                    $('#file_path').val(result.fileTran.file_path+'/'+result.fileTran.file_name)
                                    window.location.href = "{{ url('/') }}/om/order-direct-debit/domestic/download_files/"+result.fileTran.file_name;
                                }else{
                                    window.location.href = "{{ url('/') }}/om/order-direct-debit/domestic/download_files/"+file_name;
                                }
                                Swal.close()
                            }
                        },
                        error: function (error) {
                            console.log(error)
                        }
                    });
                }else{
                    Swal.close()
                }
            })
        }
    })
</script>

@stop
