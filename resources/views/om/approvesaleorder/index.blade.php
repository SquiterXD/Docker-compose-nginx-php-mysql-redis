@extends('layouts.app')

@section('title', 'OMP0021 : อนุมัติใบเตรียมการขายเพื่อตั้งหนี้')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

    <style>
        .disabled {
            pointer-events: none;
            cursor: default;
            background: rgb(194, 194, 194);
        }
    </style>
@stop

@section('page-title')
    <h2> OMP0021 : อนุมัติใบเตรียมการขายเพื่อตั้งหนี้</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> OMP0021 : อนุมัติใบเตรียมการขายเพื่อตั้งหนี้</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>OMP0021 : อนุมัติใบเตรียมการขายเพื่อตั้งหนี้</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">

                    <form id="search_form" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">วันที่ส่ง</label>
                                    <div class="input-icon">
                                        <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2"
                                            name="delivary_date" id="delivary_date" format="DD/MM/YYYY"
                                            value="{{ $dateThai }}" placeholder="โปรดเลือกวันที่">
                                            <i class="fa fa-calendar"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block">ถึงวันที่</label>
                                    <div class="input-icon">
                                        <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2"
                                            name="delivary_date_to" id="delivary_date_to" format="DD/MM/YYYY"
                                            value="{{ $dateThai }}" placeholder="โปรดเลือกวันที่">
                                            <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <!--row-->
                        </div>
                        <!--form-group-->

                        <div class="form-group">
                            <label class="d-block">เลขที่ใบเตรียมขาย</label>
                            <div class="input-icon">
                                {{-- <input type="text" class="form-control" name="prepare_number" id="prepare_number" placeholder="" value=""> --}}
                                <select class="custom-select select2-bk" name="prepare_number" id="prepare_number">
                                    <option value="">ดูทั้งหมด</option>
                                    @foreach ($order as $order_item)
                                        <option value="{{ $order_item->prepare_order_number }}">
                                            {{ $order_item->prepare_order_number }}</option>
                                    @endforeach
                                </select>
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                        <!--form-group-->

                        <div class="form-group">
                            <label class="d-block">ลูกค้า</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" list="dataCustomer"
                                            name="customer_id_show" id="customer_id_show"
                                            onkeyup="selectCustomer(this.value);" onchange="selectCustomer(this.value);">
                                        <datalist id="dataCustomer">
                                            @foreach ($customer as $item_cus)
                                                <option value="{{ $item_cus->customer_number }}"
                                                    data-value="{{ $item_cus->customer_id }}"
                                                    data-name="{{ $item_cus->customer_name_format }}">
                                                    {{ $item_cus->customer_name_format }}</option>
                                            @endforeach
                                        </datalist>
                                        <input type="hidden" name="customer_id" id="customer_id">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" disabled id="customer_name" placeholder=""
                                        value="">
                                </div>
                            </div>
                            <!--row-->
                        </div>
                        <!--form-group-->

                        <div class="form-group">
                            <label class="d-block">สถานะการอนุมัติ</label>
                            <select class="custom-select" id="status_order" name="status_order">
                                <option value=""></option>
                                <option value="Y">อนุมัติ</option>
                                <option value="N">ยังไม่ได้อนุมัติ</option>
                            </select>
                        </div>

                        {{-- <div class="form-group">
                        <label class="d-block">สถานะการรับชำระ</label>
                        <select class="custom-select" id="payment_status" name="payment_status">
                            <option value=""></option>
                            <option value="Confirm">รับชำระเงินแล้ว</option>
                            <option value="">ยังไม่รับชำระ</option>
                        </select>
                    </div> --}}

                        <div class="form-buttons no-border">
                            <button class="btn btn-lg btn-white" type="button" onclick="searchPrepareOrder();"><i
                                    class="fa fa-search"></i> ค้นหา</button>
                        </div>
                    </form>
                </div>
                <!--col-xl-6-->

                <div class="col-md-12">
                    <hr class="lg">

                    <div class="form-header-buttons flex-md-row-reverse">
                        <div class="buttons d-flex">
                            <button class="btn btn-md btn-primary" type="button" onclick="buttonOrderDebit('approve');"><i
                                    class="fa fa-check"></i> อนุมัติ</button>
                            <button class="btn btn-md btn-danger" type="button" onclick="buttonOrderDebit('reject');"><i
                                    class="fa fa-times"></i> ยกเลิก</button>
                        </div>
                        <!--buttons-->

                        <button class="btn btn-md btn-white has-checkbox mt-2 mt-md-0" type="button">
                            <label><input type="checkbox" onclick="check_all();" id="check_all_input" value="option_0"
                                    name="a"><span> เลือกทั้งหมด</span></label>
                        </button>
                    </div>
                    <!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <form id="form_table">
                            @csrf
                            <table class="table table-bordered text-center table-hover f13" id="dataTables-approve">
                                <thead>
                                    <tr class="align-middle">
                                        <th>Select</th>
                                        <th>รายการที่</th>
                                        <th>เลขที่ใบเตรียมขาย</th>
                                        <th>วันที่ส่ง</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>เงินเชื่อ</th>
                                        <th>เงินสด</th>
                                        <th>จำนวนเงิน</th>
                                        {{-- <th>สถานะการรับ<br>ชำระเงิน</th> --}}
                                        <th>อนุมัติ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!--table-responsive-->

                    <div class="d-flex mt-4 mb-5">
                        <div class="d-flex ml-auto mr-4">สั่งซื้อปกติ <span class="box-label"
                                style="background-color: #1c84c6"></span></div>
                        <div class="d-flex">สั่งซื้อเกินโควต้า <span class="box-label"
                                style="background-color:red"></span></div>
                    </div>
                    <!--d-flex-->
                </div>
            </div>
            <!--row-->
        </div>
        <!--ibox-content-->
    </div>
    <!--ibox-->

@endsection

@section('scripts')
    <script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
    <script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
    <script src="{!! asset('custom/custom.js') !!}"></script>

    <script>
        $(document).ready(function() {
            $("#dataTables-approve").DataTable();
            $(".select2").select2();
            $("#prepare_number").select2({
                ajax: {
                    // url: 'your/ajax/endpoint',
                    dataType: 'json',
                    delay: 250, // Delay in milliseconds before sending the request
                    processResults: function(response) {
                        var mappedOptions = _.map(response,function(option) {
                            console.log(option)
                            return {
                                id: option.prepare_order_number,
                                text: option.prepare_order_number
                                // Add any additional properties as required
                            };
                        });
                        console.log(mappedOptions)
                        // Process the response from the server and format it as required by Select2
                        return {
                            results: mappedOptions // Assuming the server response has a 'data' property containing the array of options
                        };
                    },
                    cache: true // Cache the AJAX results to minimize server requests
                },
                minimumInputLength: 2 // Minimum number of characters required to trigger the AJAX request
            });
        });

        function selectCustomer() {
            var number = $("#customer_id_show").val();
            var value = $("#dataCustomer option[value='" + number + "']").data('value');
            var name = $("#dataCustomer option[value='" + number + "']").data('name');

            $("#customer_name").val(name);
            $("#customer_id").val(value);
        }

        function searchPrepareOrder() {
            const formdata = new FormData(document.getElementById("search_form"));

            loading();
            $.ajax({
                url: '{{ url('om/ajax/approve-saleorder/search_saleorder') }}',
                type: 'post',
                data: formdata,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function(rest) {
                    swal.close();
                    var data = rest.data;
                    if (data.status) {
                        $("#dataTables-approve").DataTable({
                            pageLength: 100,
                            responsive: true,
                            data: data.data,
                            destroy: true,
                            // 'order' : [[3,'desc']],
                            "columns": [{
                                    'data': 'id'
                                },
                                {
                                    'data': null,
                                    render: function(data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart + 1;
                                    }
                                },
                                {
                                    'data': 'prepare_number'
                                },
                                {
                                    'data': 'delivery_date'
                                },
                                {
                                    'data': 'customer_name',
                                    'class': 'text-left'
                                },
                                {
                                    'data': 'credit_amount',
                                    'class': 'text-righ'
                                },
                                {
                                    'data': 'cash_amount',
                                    'class': 'text-righ'
                                },
                                {
                                    'data': 'amount_total',
                                    'class': 'text-righ'
                                },
                                // { 'data' : 'payment_status' },
                                {
                                    'data': 'approve_status'
                                },
                            ],
                            rowCallback: function(row, data, index) {
                                if (data.row_status == 'order_nomal') {
                                    $(row).addClass('tr-text-blue');
                                } else if (data.row_status == 'order_limit') {
                                    $(row).addClass('tr-text-red');
                                }

                                // if(data.col_payment == 'Y'){
                                //    $(row).find('td:nth-child(9)').addClass('td-green');
                                // }else{
                                //    $(row).find('td:nth-child(9)').addClass('td-red');
                                // }
                            }
                        });
                    } else {
                        $("#dataTables-approve").DataTable({
                            pageLength: 10,
                            responsive: true,
                            data: [],
                            destroy: true,
                        });
                    }
                    // $('input').iCheck('indeterminate');
                }
            });
        }

        function buttonOrderDebit(type) {
            const formdata = new FormData(document.getElementById("form_table"));
            formdata.append('type', type);
            loading();
            $.ajax({
                url: '{{ url('om/ajax/approve-saleorder/update_status') }}',
                type: 'post',
                data: formdata,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function(rest) {
                    swal.close();
                    var data = rest.data;
                    if (data.status) {
                        searchPrepareOrder();
                        AlertToast('สำเร็จ', data.message, 'success');
                        // window.location.reload();
                    } else {
                        swal.close();
                        AlertToast('แจ้งเตือน', data.message, 'error');
                    }
                }
            });
        }

        function check_all() {
            if ($("#check_all_input").prop('checked')) {
                $(".approve").prop('checked', true);
            } else {
                $(".approve").prop('checked', false);
            }
        }

        function loading() {
            Swal.fire({
                title: 'รอสักครู่ !',
                html: 'กำลังโหลดข้อมูล', // add html attribute if you want or remove
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
        }

        function printErrorMsgSaleOrder(msg) {
            $(".print-error-msg-saleorder").find("ul").html('');
            $(".print-error-msg-saleorder").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg-saleorder").find("ul").append('<li>' + value + '</li>');
            });
        }

        function AlertToast(header, detail, type) {
            if (type == 'success') {
                toastr.success(header, detail, {
                    positionClass: "toast-top-center"
                });
            } else if (type == 'error') {
                toastr.error(header, detail, {
                    positionClass: "toast-top-center"
                });
            }
        }
    </script>
@stop
