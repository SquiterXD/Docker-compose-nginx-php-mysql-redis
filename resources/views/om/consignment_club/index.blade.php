@extends('layouts.app')
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    .chosen-container-single .chosen-single {
        min-height: 40px !important;
        background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px !important;
        font-size: 0.9rem !important;
    }

    table.dataTable {
        font-size: 0.9rem;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

    .swal2-select {
        font-size: 0.8em !important;
        border-radius: 5px;
    }

    .swal2-container {
        z-index: 2060 !important;
    }

    .modal-1200 .modal-dialog{max-width: 1200px}

    /* DATA DATE */
    .mx-datepicker .mx-input-wrapper input {
        height: auto !important;
    }

    .mx-datepicker .mx-input-wrapper .mx-icon-calendar, .mx-datepicker .mx-input-wrapper .mx-icon-clear {
        right: -15px !important;
    }

    .mx-icon-calendar {
        margin-top: 0px !important;
        font-size: 18px !important;
    }

    .i-checks.disabled {
        opacity: 0.5;
    }
    /* END DATA DATE */

    /* SELECT 2 */

    .select2-container--default .select2-selection--single {
        border: 1px solid #e5e6e7 !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 2px !important;
    }
    /* SELECT 2 */

    #page-wrapper {
        width: calc(100% - 220px) !important;
    }

</style>

@section('title', 'รายการฝากขายสโมสรภูมิภาค')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <x-get-page-title :menu="$menu" url="" />
    {{-- <h2>
        OMP0038 รายการฝากขายสโมสรภูมิภาค
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>รายการฝากขายสโมสรภูมิภาค</strong>
        </li>
    </ol> --}}
@stop

@section('content')
    <form id="formConsignmentClub" autocomplete="none" enctype="multipart/form-data">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ !empty($menu->menu_title) ? $menu->menu_title : '' }}</h3>
            </div>
            <div class="ibox-content">
                <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                    <div class="col-12">
                        <div class="form-header-buttons">
                            <div class="d-flex">
                                {{-- <button class="btn btn-md btn-white" type="button" onclick="resetConsignmentClub()"><i class="fa fa-repeat"></i></button> --}}
                                <button class="btn btn-md btn-white" type="button" onclick="location.reload()"><i class="fa fa-repeat"></i></button>
                            </div>
                            <div class="buttons multiple">
                                <button class="btn btn-md btn-success" type="button" id="buttonCreate" onclick="createConsignment()"><i class="fa fa-plus"></i> สร้าง</button>
                                {{-- <button class="btn btn-md btn-white" data-toggle="modal" data-target="#searchModal" type="button"><i class="fa fa-search"></i> ค้นหา</button> --}}
                                <button class="btn btn-md btn-white" type="button" id="buttonSearch" onclick="searchConsignment()"  disabled><i class="fa fa-search"></i> ค้นหา</button>
                                {{-- <button class="btn btn-md btn-primary" type="button" id="buttonUpdate" onclick="saveConsignment('save')"><i class="fa fa-save"></i> บันทึก</button> --}}
                                <button class="btn btn-md btn-info" type="button" id="buttonConfirm" onclick="saveConsignment('confirm')"><i class="fa fa-check"></i> ยืนยันข้อมูล</button>
                                <button class="btn btn-md btn-success" id="buttonAttachFile" data-toggle="modal" data-target="#attachmentModal" type="button" disabled><span class="fa fa-upload"> ไฟล์แนบ</span></button>

                            </div>
                        </div><!--form-header-buttons-->

                        <div class="hr-line-dashed"></div>
                    </div><!--col-12-->

                    <div class="col-xl-10 m-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">เลขที่ใบฝากขายสโมสรภูมิภาค</label>
                                    <div class="input-icon">
                                        <input type="text" class="form-control" name="consignment_no" id="consignment_no" list="consignment-list" value="" autocomplete="off">
                                        <i class="fa fa-search"></i>
                                        <datalist id="consignment-list">

                                            <option value=""> &nbsp; </option>
                                            @foreach ($consignmentNoList as $item)
                                            @if (!empty($item->consignment_no))
                                            <option value="{{ $item->consignment_no }}"> {{ $item->consignment_no }} : {{ $item->consignment_date }} : {{ $item->pick_release_num }} : {{ $item->customer_name }} </option>
                                            @endif
                                            @endforeach

                                        </datalist>

                                        <input type="hidden" name="consignment_header_id" id="consignment_header_id" value="">
                                        <input type="hidden" name="order_header_id" id="order_header_id" value="">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">วันที่บันทึก</label>
                                    <div class="input-icon" id="html_consignment_date">
                                        {{-- <input type="text" class="form-control date" name="consignment_date" id="consignment_date" placeholder="" value="">
                                        <i class="fa fa-calendar"></i> --}}
                                        {{-- <div id="mount_consignment_date"></div> --}}
                                        <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="consignment_date"
                                            id="consignment_date"
                                            placeholder=""
                                            value=""
                                            format="{{ trans("date.js-format") }}">
                                    </div>
                                </div><!--form-group-->
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">สถานะ</label>
                                    {{-- <input type="text" class="form-control" name="consignment_status" id="consignment_status" placeholder="" value=""> --}}
                                    <select class="custom-select" name="consignment_status" id="consignment_status" disabled>
                                        <option value=""> &nbsp; </option>
                                        <option value="Draft">Draft</option>
                                        <option value="Confirm">Confirm</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div><!--form-group-->
                                <input type="hidden" name="hide_consignment_status" id="hide_consignment_status" value="">
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">เลขที่ใบขน</label>

                                    <div class="input-icon">
                                        <input type="text" class="form-control" name="pick_release_num" id="pick_release_num" list="pickrelease-list" value="" autocomplete="off">
                                        <i class="fa fa-search"></i>
                                        <datalist id="pickrelease-list">

                                            <option value=""> &nbsp; </option>
                                            @foreach ($orderHeadersList as $item)
                                            @if (!empty($item['pick_release_no']))
                                            <option value="{{ $item['pick_release_no'] }}">{{ $item['pick_release_no'] }} : {{ $item['pick_release_approve_date'] }} : {{ $item['customer_name'] }}</option>
                                            @endif
                                            @endforeach

                                        </datalist>
                                    </div>

                                </div><!--form-group-->
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">วันที่ขน</label>
                                    <div class="input-icon" id="html_pick_release_date">
                                        {{-- <input type="text" class="form-control" readonly name="pick_release_date" id="pick_release_date" placeholder="" value="">
                                        <i class="fa fa-calendar"></i> --}}
                                        {{-- <div id="mount_pick_release_date"></div> --}}
                                        <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="pick_release_date"
                                            id="pick_release_date"
                                            placeholder=""
                                            value=""
                                            readonly="readonly"
                                            disabled
                                            format="{{ trans("date.js-format") }}">

                                    </div>
                                    <input type="hidden" name="pick_release_date_input" id="pick_release_date_input" value="">
                                </div><!--form-group-->
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="d-block">รหัสลูกค้า</label>
                                    <div class="row space-5">
                                        <div class="col-md-4">
                                            {{-- <input type="text" class="form-control" name="customer_number" id="customer_number" value=""> --}}
                                            <div class="input-icon">
                                                <input type="text" class="form-control" name="customer_number" id="customer_number" list="customers-list" value="" autocomplete="off" onchange="selectCustomer()">
                                                <i class="fa fa-search"></i>
                                                <datalist id="customers-list">

                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($customerList as $item)
                                                    @if (!empty($item->customer_number))
                                                    <option value="{{ $item->customer_number }}">{{ $item->customer_name }}</option>
                                                    @endif
                                                    @endforeach

                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-2 mt-md-0">
                                            <input type="text" class="form-control" readonly name="customer_name" id="customer_name" value="">
                                            <input type="hidden" name="customer_id" id="customer_id" value="">
                                        </div>
                                    </div><!--row-->
                                </div><!--form-group-->
                            </div><!--form-group-->
                        </div><!--row-->


                    </div><!--col-xl-6-->

                    <div class="col-md-12">
                        <hr class="lg">

                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-hover min-1000 f13">
                                <thead>
                                    <tr class="align-middle">
                                        <th>ลำดับ</th>
                                        <th>รหัสผลิตภัณฑ์</th>
                                        <th>ชื่อผลิตภัณฑ์</th>
                                        <th>หน่วย</th>
                                        <th>จำนวน</th>
                                        <th class="w-160">มูลค่า</th>
                                        <th>ยอดขายได้</th>
                                        <th>คงเหลือขาย</th>
                                        <th class="w-160">บันทึกยอดขาย</th>
                                    </tr>
                                </thead>
                                <tbody id="consignmentLines">
                                    <tr class="align-middle">
                                        <td class="text-right" colspan="5"><strong>รวมมูลค่า</strong></td>
                                        <td>
                                            <input type="text" class="form-control text-right" readonly name="" placeholder="" value="0.00">
                                        </td>
                                        <td class="text-right" colspan="2"><strong>รวมยอดขายฝาก</strong></td>
                                        <td>
                                            <input type="text" class="form-control text-right" readonly name="" placeholder="" value="0.00">
                                        </td>

                                    </tr>

                                    <tr class="align-middle">
                                        <td class="text-right" colspan="8"><strong>รวมมูลค่าขายฝาก</strong></td>
                                        <td>
                                            <input type="text" class="form-control text-right" readonly name="" placeholder="" value="0.00">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--table-responsive-->

                    </div><!--col-md-12-->
                </div><!--row-->
            </div><!--ibox-content-->
        </div><!--ibox-->

        <div class="modal modal-1200 fade" id="searchModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <div class="modal-header">
                        <h3>ค้นหารายการฝากขายสโมสรภูมิภาค</h3>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <div class="attachment-box">

                                <div class="col-xl-10 m-auto">

                                    <form id="formSearchConsignment" autocomplete="none" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-block">เลขที่ใบฝากขายสโมสร</label>
                                                    <select class="custom-select" name="search_consignment_no" id="search_consignment_no">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($consignmentNoList as $item)
                                                        <option value="{{ $item->consignment_no }}">{{ $item->consignment_no }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่บันทึก</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control date" name="search_consignment_date" id="search_consignment_date" placeholder="" value="">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-block">Status</label>
                                                    <select class="custom-select" name="search_consignment_status" id="search_consignment_status">
                                                        <option value=""> &nbsp; </option>
                                                        <option value="Draft">Draft</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-block">เลขที่ใบขน</label>
                                                    <select class="custom-select" name="search_pick_release_num" id="search_pick_release_num">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($consignmentNoList as $item)
                                                        <option value="{{ $item->pick_release_num }}">{{ $item->pick_release_num }}</option>
                                                        @endforeach
                                                    </select>
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่ขน</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control date" name="search_pick_release_date" id="search_pick_release_date" placeholder="" value="">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้า</label>
                                                    <div class="row space-5">
                                                        <div class="col-md-4">
                                                            <select class="custom-select" name="search_customer_number" id="search_customer_number">
                                                                <option data-value="" value=""> &nbsp; </option>
                                                                @foreach ($customerList as $item)
                                                                <option data-value="{{ $item->customer_name }}" value="{{ $item->customer_number }}">{{ $item->customer_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8 mt-2 mt-md-0">
                                                            <input type="text" class="form-control" readonly name="search_customer_name" id="search_customer_name" placeholder="" value="">
                                                        </div>
                                                    </div><!--row-->
                                                </div><!--form-group-->
                                            </div><!--form-group-->

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button class="btn btn-md btn-white" type="button" onclick="searchConsignment()"><i class="fa fa-search"></i> ค้นหา</button>
                                                </div>
                                            </div>

                                        </div><!--row-->

                                    </form>

                                </div><!--col-xl-6-->

                                {{-- <div class="hr-line-dashed"></div> --}}

                                <div class="col-12">
                                    <div class="m-auto" style="padding:0; margin:0; align-content:center;">
                                        <div class="table-responsive">
                                            <table id="search_table" class="table table-bordered text-center table-hover min-1000 f13">
                                                <thead>
                                                    <tr class="align-middle">
                                                        <th class="w-150">เลขที่ใบฝากขาย</th>
                                                        <th class="w-150">วันที่บันทึก</th>
                                                        <th class="w-150">เลขที่ใบขน</th>
                                                        <th class="w-150">วันที่ขน</th>
                                                        <th class="w-150">รหัสลูกค้า</th>
                                                        <th>ชื่อลูกค้า</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="search_tbody">
                                                    <tr class="align-middle" id="testclick">
                                                        <td class="w-150">เลขที่ใบฝากขาย</td>
                                                        <td class="w-150">วันที่บันทึก</td>
                                                        <td class="w-150">เลขที่ใบขน</td>
                                                        <td class="w-150">วันที่ขน</td>
                                                        <td class="w-150">รหัสลูกค้า</td>
                                                        <td>ชื่อลูกค้า</td>
                                                    </tr>
                                                    <tr class="align-middle search-selected" >
                                                        <td class="w-150">เลขที่ใบฝากขาย</td>
                                                        <td class="w-150">วันที่บันทึก</td>
                                                        <td class="w-150">เลขที่ใบขน</td>
                                                        <td class="w-150">วันที่ขน</td>
                                                        <td class="w-150">รหัสลูกค้า</td>
                                                        <td>ชื่อลูกค้า</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                        </div>
                    </div><!--modal-body-->

                    <div class="modal-footer center mt-4">
                        <button class="btn btn-gray btn-lg" type="button" data-dismiss="modal">
                            ปิด
                        </button>
                        <button class="btn btn-primary btn-lg" type="button" data-dismiss="modal">
                            ยืนยัน
                        </button>
                    </div>

                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </div><!--modal-->
    </form>

@endsection



@section('scripts')

    @include('om/_scripts/attachment')

    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
    <!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){

        $('.custom-select').select2({width: "100%"});
    });


</script>

<script>
    var orderHeadersList    = @json($orderHeadersList);
    var consignmentList     = @json($consignmentNoList);
    var customerList        = @json($customerList);
    let stepEvent           = '';

    var d           = new Date();

    // if (d.getDay === 4 || d.getDay === 5) {
    //     d.setDate(d.getDate() + 4);
    // }
    // else if(d.getDay === 6){
    //     d.setDate(d.getDate() + 3);
    // }
    // else {
    //     d.setDate(d.getDate() + 2);
    // }

    var dayNow      = d.getDate();
    var monthNow    = ("0"+(d.getMonth()+1)).slice(-2);
    var yearNow     = d.getFullYear()+543;
    let dateNow = dayNow + "/" + monthNow + "/" + yearNow;

    async function createConsignment()
    {
        // swal.showLoading();
        $('#buttonCreate').attr('disabled', true);
        $('#buttonSearch').attr('disabled', true);
        $('#buttonAttachFile').attr('disabled', true);

        // const dateNow   = new Date(Date.now()).toLocaleString().split(' ')[0];

        // var d           = new Date();
        // var dayNow      = d.getDate();
        // var monthNow    = d.getMonth()+1;
        // var yearNow     = d.getFullYear()+543;

        // var dateNow = dayNow + "/" + monthNow + "/" + yearNow;
        // const dateObj   = new Date(getDate);
        // const month	    = String(dateObj.getDate()).padStart(2, '0');
        // const day 	    = String(dateObj.getMonth()).padStart(2, '0');
        // const year	    = dateObj.getFullYear();
        // const dateNow   = day + '/' + month + '/' + year;

        $('#consignment_no').val('');
        stepEvent   = 'create';

        generateConsignmentDate(dateNow);

        $('#consignment_status').val('Draft').trigger('change');
        $('#hide_consignment_status').val('Draft').trigger('change');
        $('#consignment_no').prop('readonly', true);
        $('#customer_number').prop('readonly', true);

        setSelectValue(0);

    }

    async function searchCreate()
    {
        swal.showLoading();
        const formData = new FormData(document.getElementById("formConsignmentClub"));
        formData.append('_token','{{ csrf_token() }}');

        // await $.each(fileChoose,async function(index, file) {
        // if(typeof file !== "undefined")
        //     await formData.append('attachment[]', file);
        // });

        $.ajax({
            url         : '{{ url("om/ajax/consignment-club/search-create") }}',
            type        : 'post',
            data        : formData,
            cache       : false,
            processData : false,
            contentType : false,
            success     : function(res){
                var orderHeadersData = res.data.data;
                if (res.data.status == 'success') {

                    $('#customer_id').val(orderHeadersData.customer_id);
                    $('#customer_number').val(orderHeadersData.customer_number);
                    $('#customer_name').val(orderHeadersData.customer_name);
                    $('#pick_release_date').val(orderHeadersData.pick_release_approve_date);
                    $('#pick_release_date_input').val(orderHeadersData.pick_release_approve_date);

                    // CONSIGNMENT LINES
                    var orderLinesData    = res.data.orderLinesData;
                    var num                 = 1;
                    var htmlLines           = '';

                    if (orderLinesData != '') {
                        $.each(orderLinesData, function(key,valLine){
                            htmlLines += '<tr class="align-middle">';
                            htmlLines += '    <td>'+valLine.line_number;
                            htmlLines += '      <input type="hidden" name="consignment_line[]" id="consignment_line_'+valLine.consignment_line_id+'" value="'+valLine.consignment_line_id+'">';
                            htmlLines += '        <input type="hidden" class="form-control text-right" readonly name="unit_price['+valLine.consignment_line_id+']" id="unit_price_'+valLine.consignment_line_id+'" value="'+valLine.unit_price+'">';
                            htmlLines += '      <input type="hidden" name="consignment_line_id['+valLine.consignment_line_id+']" id="consignment_line_id_'+valLine.consignment_line_id+'" value="'+valLine.consignment_line_id+'">';
                            htmlLines += '    </td>';
                            htmlLines += '    <td class="text-left">'+valLine.item_code+'<input type="hidden" name="item_code['+valLine.consignment_line_id+']" id="item_code_'+valLine.consignment_line_id+'" value="'+valLine.item_code+'"></td>';
                            htmlLines += '    <td class="text-left">'+valLine.item_description+'</td>';
                            htmlLines += '    <td>'+valLine.uom+'</td>';
                            htmlLines += '    <td class="text-right">'+numberFormat(valLine.quantity)+'</td>';
                            htmlLines += '    <td class="text-right">'+numberFormat(valLine.total_amount)+' <input type="hidden" name="main_remaining['+valLine.consignment_line_id+']" id="main_remaining_'+valLine.consignment_line_id+'" value="'+ valLine.remaining_quantity+'"></td></td>';
                            htmlLines += '    <td class="text-right"><span id="sp_previous_'+valLine.consignment_line_id+'">'+numberFormat(valLine.previous_quantity)+'</span></span><input type="hidden" name="previous_quantity['+valLine.consignment_line_id+']" id="previous_quantity_'+valLine.consignment_line_id+'" value="'+valLine.previous_quantity+'"></td>';
                            htmlLines += '    <td class="text-right"><span id="sp_remaining_'+valLine.consignment_line_id+'">'+numberFormat(valLine.remaining_quantity)+'</span><input type="hidden" name="remaining_quantity['+valLine.consignment_line_id+']" id="remaining_quantity_'+valLine.consignment_line_id+'" value="'+valLine.remaining_quantity+'" ></td>';
                            htmlLines += '    <td><input type="text" class="form-control text-right actual-quantity" name="actual_quantity['+valLine.consignment_line_id+']" id="actual_quantity_'+valLine.consignment_line_id+'" value="'+valLine.actual_quantity+'" onchange="changeCalculate('+valLine.consignment_line_id+')" onkeypress="return isNumber(this, event)" onfocus="checkZero('+valLine.consignment_line_id+')" onfocusout="inputZero('+valLine.consignment_line_id+')"></td>';
                            htmlLines += '</tr>';
                        });


                        htmlLines += '<tr class="align-middle">';
                        htmlLines += '    <td class="text-right" colspan="5"><strong>รวมมูลค่า</strong></td>';
                        htmlLines += '    <td>';
                        htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_unit_price_amount" id="total_unit_price_amount" value="'+numberFormat(orderHeadersData.total_unit_price_amount)+'">';
                        htmlLines += '    </td>';
                        htmlLines += '    <td class="text-right" colspan="2"><strong>รวมยอดขายฝาก</strong></td>';
                        htmlLines += '    <td>';
                        htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_consignment_amount" id="total_consignment_amount" value="'+numberFormat(orderHeadersData.total_consignment_amount)+'">';
                        htmlLines += '    </td>';
                        htmlLines += '</tr>';
                        htmlLines += '<tr class="align-middle">';
                        htmlLines += '    <td class="text-right" colspan="8"><strong>รวมมูลค่าขายฝาก</strong></td>';
                        htmlLines += '    <td>';
                        htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_amount" id="total_amount" value="'+numberFormat(orderHeadersData.total_amount)+'">';
                        htmlLines += '    </td>';
                        htmlLines += '</tr>';
                    }

                    $('#consignmentLines').html(htmlLines);

                    $('#buttonAttachFile').attr('disabled', false);

                    // setAttachment(res.data.attachmentFile);

                    var pickReleaseNum = $('#pick_release_num').val();
                    var DateValue = '';
                    var tagValue = 0;

                    $.ajax({
                        url : '{{ url("om/ajax/consignment-club/get-delivery-period-tag/") }}/'+pickReleaseNum+'/'+orderHeadersData.customer_number,
                        success : function(res){
                            // console.log(res.tag);
                            // DateValue = res.date;

                            if(res.date != ''){
                                var releaseDate   = new Date(res.date);

                                if (res.tag > 0) {
                                    if (releaseDate.getDay() === 5) {
                                        tagValue = parseInt(res.tag) + 2;
                                    }
                                    else if(releaseDate.getDay() === 6){
                                        tagValue = parseInt(res.tag) + 1;
                                    }else{
                                        tagValue = parseInt(res.tag)
                                    }

                                    releaseDate.setDate(releaseDate.getDate() + parseInt(tagValue));
                                }


                                var dayNew      = releaseDate.getDate();
                                var monthNew    = ("0"+(releaseDate.getMonth()+1)).slice(-2);
                                var yearNew     = releaseDate.getFullYear()+543;
                                let newDate     = dayNew + "/" + monthNew + "/" + yearNew;

                                generateConsignmentDate(newDate);
                            }else{
                                var releaseDate   = new Date();
                                if (res.tag > 0) {
                                    releaseDate.setDate(releaseDate.getDate() + parseInt(res.tag));
                                }
                                var dayNew      = releaseDate.getDate();
                                var monthNew    = ("0"+(releaseDate.getMonth()+1)).slice(-2);
                                var yearNew     = releaseDate.getFullYear()+543;
                                let newDate     = dayNew + "/" + monthNew + "/" + yearNew;

                                generateConsignmentDate(newDate);
                            }
                        }
                    });


                    Swal.close();

                }else{

                    Swal.fire({
                        title: 'ผิดพลาด',
                        text: "ไม่พบข้อมูล !",
                        icon: 'error',
                        timer: 2500
                    });
                }
            }
        });
    }

    var newOrder    = [];

    $.each(consignmentList, function(key,valOrder){
        newOrder.push({ id: valOrder.consignment_no, name: valOrder.consignment_no });
    });

    newOrder.sort(function(a, b) {
        return - ( b.id - a.id  ||  b.name.localeCompare(a.name) );
    });

    var options = [];
    $.map(newOrder,
    function(o) {
        options[o.id] = o.name;
    });

    async function searchConsignment()
    {
        var consignmentNo   = $('#consignment_no').val();
        var pickReleaseNo   = $('#pick_release_num').val();
        var customerNumber  = $('#customer_number').val();

        if(stepEvent   == 'create' && consignmentNo != ''){
            Swal.fire({
                title: 'ผิดพลาด',
                text: "กรุณาเคลียร์ข้อมูลและทำรายการใหม่ !",
                icon: 'warning',
                timer: 2500
            });
        }else if (consignmentNo == '' && stepEvent != 'create') {
            Swal.fire({
                title: 'ผิดพลาด',
                text: "กรุณาเลือกข้อมูล เลขที่ใบฝากขายสโมสร !",
                icon: 'warning',
                timer: 2500
            });
        }else{
            swal.showLoading();

            $('#buttonCreate').attr('disabled', true);
            $('#buttonSearch').attr('disabled', true);

            const formData = new FormData(document.getElementById("formConsignmentClub"));
            formData.append('_token','{{ csrf_token() }}');
            await $.each(fileChoose,async function(index, file) {
            if(typeof file !== "undefined")
                await formData.append('attachment[]', file);
            });

            $.ajax({
                url         : '{{ url("om/ajax/consignment-club/search-consignment-club") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    var dataConsignment = res.data.data;
                    if (res.data.status == 'success') {

                        // if(dataConsignment.consignment_date == '' || dataConsignment.consignment_date == null){
                        //     var date = new Date();
                        //     var month = date.getMonth()+1;
                        //     var day = date.getDate();
                        //     dataConsignment.consignment_date = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' + date.getFullYear();
                        // }

                        // $('#consignment_no').val(dataConsignment.consignment_no);
                        // $('#consignment_date').val(dataConsignment.consignment_date);
                        // $('#consignment_status').val(dataConsignment.consignment_status);
                        // $('#pick_release_num').val(dataConsignment.pick_release_num);
                        // $('#pick_release_date').val(dataConsignment.pick_release_date);
                        // $('#customer_number').val(dataConsignment.customer_number);
                        // $('#customer_name').val(dataConsignment.customer_name);

                        if (stepEvent != 'create') {

                            if (dataConsignment.consignment_status == 'Confirm' || dataConsignment.consignment_status == 'Cancelled') {
                                var disabledInput   = 'readonly';

                                // var consignmentDate = $('#consignment_date').val();
                                // generateConsignmentDate(consignmentDate);
                                $('#html_consignment_date div').addClass('disabled');
                                $('#html_consignment_date div').attr('readonly', true);
                                $('#consignment_date').prop('disabled', true);
                                $('.mx-icon-clear').remove();

                                $('#consignment_no').prop('readonly', true);
                                // $('#consignment_status').prop('disabled', true);

                                $('#pick_release_num').prop('readonly', true);
                                $('#customer_number').prop('readonly', true);

                                $('#buttonUpdate').prop('disabled', true);
                                $('#buttonConfirm').prop('disabled', true);
                            }

                        }else{
                            var disabledInput   = '';

                            // var consignmentDate = $('#consignment_date').val();
                            // generateConsignmentDate(consignmentDate, true);

                            if (stepEvent == 'create') {
                                $('#consignment_no').prop('readonly', true);
                            }else{
                                $('#consignment_no').prop('readonly', false);
                            }
                            // $('#consignment_status').prop('disabled', false);

                            $('#pick_release_num').prop('readonly', false);
                            $('#customer_number').prop('readonly', false);

                            $('#buttonUpdate').prop('disabled', false);
                            $('#buttonConfirm').prop('disabled', false);
                        }


                        // CONSIGNMENT LINES
                        var consignmentLines    = res.data.consignmentLines;
                        var num                 = 1;
                        var htmlLines           = '';

                        if (consignmentLines != '') {
                            $.each(consignmentLines, function(key,valLine){
                                var newRemaining = parseFloat(valLine.remaining_quantity) + parseFloat(valLine.actual_quantity);
                                htmlLines += '<tr class="align-middle">';
                                htmlLines += '    <td>'+valLine.line_number;
                                htmlLines += '      <input type="hidden" name="consignment_line[]" id="consignment_line_'+valLine.consignment_line_id+'" value="'+valLine.consignment_line_id+'">';
                                htmlLines += '        <input type="hidden" class="form-control text-right" readonly name="unit_price['+valLine.consignment_line_id+']" id="unit_price_'+valLine.consignment_line_id+'" value="'+valLine.unit_price+'">';
                                htmlLines += '      <input type="hidden" name="consignment_line_id['+valLine.consignment_line_id+']" id="consignment_line_id_'+valLine.consignment_line_id+'" value="'+valLine.consignment_line_id+'">';
                                htmlLines += '    </td>';
                                htmlLines += '    <td class="text-left">'+valLine.item_code+'<input type="hidden" name="item_code['+valLine.consignment_line_id+']" id="item_code_'+valLine.consignment_line_id+'" value="'+valLine.item_code+'"></td>';
                                htmlLines += '    <td class="text-left">'+valLine.item_description+'</td>';
                                htmlLines += '    <td>'+valLine.uom+'</td>';
                                htmlLines += '    <td class="text-right">'+numberFormat(valLine.quantity)+'</td>';
                                htmlLines += '    <td class="text-right">'+numberFormat(valLine.total_amount)+' <input type="hidden" name="main_remaining['+valLine.consignment_line_id+']" id="main_remaining_'+valLine.consignment_line_id+'" value="'+ newRemaining+'"></td>';
                                htmlLines += '    <td class="text-right"><span id="sp_previous_'+valLine.consignment_line_id+'">'+numberFormat(valLine.previous_quantity)+'</span></span><input type="hidden" name="previous_quantity['+valLine.consignment_line_id+']" id="previous_quantity_'+valLine.consignment_line_id+'" value="'+valLine.previous_quantity+'"></td>';
                                htmlLines += '    <td class="text-right"><span id="sp_remaining_'+valLine.consignment_line_id+'">'+numberFormat(valLine.remaining_quantity)+'</span><input type="hidden" name="remaining_quantity['+valLine.consignment_line_id+']" id="remaining_quantity_'+valLine.consignment_line_id+'" value="'+valLine.remaining_quantity+'" ></td>';
                                htmlLines += '    <td><input '+disabledInput+' type="text" class="form-control text-right actual-quantity" name="actual_quantity['+valLine.consignment_line_id+']" id="actual_quantity_'+valLine.consignment_line_id+'" value="'+numberFormat(valLine.actual_quantity)+'" onchange="changeCalculate('+valLine.consignment_line_id+')" onkeypress="return isNumber(this, event)"  onfocus="checkZero('+valLine.consignment_line_id+')" onfocusout="inputZero('+valLine.consignment_line_id+')"></td>';
                                htmlLines += '</tr>';
                            });


                            htmlLines += '<tr class="align-middle">';
                            htmlLines += '    <td class="text-right" colspan="5"><strong>รวมมูลค่า</strong></td>';
                            htmlLines += '    <td>';
                            htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_unit_price_amount" id="total_unit_price_amount" value="'+numberFormat(dataConsignment.total_unit_price_amount)+'">';
                            htmlLines += '    </td>';
                            htmlLines += '    <td class="text-right" colspan="2"><strong>รวมยอดขายฝาก</strong></td>';
                            htmlLines += '    <td>';
                            htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_consignment_amount" id="total_consignment_amount" value="'+numberFormat(dataConsignment.total_consignment_amount)+'">';
                            htmlLines += '    </td>';
                            htmlLines += '</tr>';
                            htmlLines += '<tr class="align-middle">';
                            htmlLines += '    <td class="text-right" colspan="8"><strong>รวมมูลค่าขายฝาก</strong></td>';
                            htmlLines += '    <td>';
                            htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_amount" id="total_amount" value="'+numberFormat(dataConsignment.total_amount)+'">';
                            htmlLines += '    </td>';
                            htmlLines += '</tr>';
                        }

                        $('#consignmentLines').html(htmlLines);

                        $('#buttonAttachFile').attr('disabled', false);
                        setAttachment(res.data.attachmentFile);


                        Swal.close();

                    }else{

                        Swal.fire({
                            title: 'ผิดพลาด',
                            text: "ไม่พบข้อมูลรายการฝากขายสโมสรภูมิภาคนี้ !",
                            icon: 'error',
                            timer: 2500
                        });

                        $('#buttonSearch').attr('disabled', false);
                    }
                }
            });
        }
    }

    $('#search_customer_number').change(function(){
        $('#search_customer_name').val($(this).find(':selected').data('value'));
    });

    $('#consignment_no').change(function(){
        if ($.trim($('#consignment_no').val()) == '') {
            $('#buttonSearch').attr('disabled', true);
        }else{
            $('#buttonSearch').attr('disabled', false);
        }
    });

    $('#consignment_no').change(function(){

        var consignmentNo = $('#consignment_no').val();

        var consignmentHeaderID = '';
        var pickReleaseNum      = '';
        var consignmentDate     = '';
        var consignmentStatus   = '';

        var pickReleaseDate     = '';
        var customerNumber      = '';
        var customerName        = '';
        var customerID          = '';

        if (consignmentNo != '') {
            $.each(consignmentList, function(key, val){
                if (val.consignment_no == consignmentNo) {
                    consignmentHeaderID = val.consignment_header_id;
                    pickReleaseNum      = val.pick_release_num;
                    consignmentDate     = val.consignment_date;
                    consignmentStatus   = val.consignment_status;

                    pickReleaseDate     = val.pick_release_approve_date;
                    customerNumber      = val.customer_number;
                    customerName        = val.customer_name;
                    customerID          = val.customer_id;
                }
            });


            $('#consignment_header_id').val(consignmentHeaderID);
            $('#order_header_id').val(consignmentHeaderID);
            $('#consignment_status').val(consignmentStatus).trigger('change');
            $('#hide_consignment_status').val(consignmentStatus).trigger('change');
            // $('#consignment_date').val(consignmentDate);

            generateConsignmentDate(consignmentDate);


            $('#pick_release_num').val(pickReleaseNum);
            $('#pick_release_date').val(pickReleaseDate);
            $('#pick_release_date_input').val(pickReleaseDate);
            $('#customer_number').val(customerNumber);
            $('#customer_name').val(customerName);
            $("#customer_id").val(customerID);
        }else{

            $('#consignment_header_id').val('');
            $('#order_header_id').val('');
            $('#consignment_status').val('').trigger('change');
            $('#hide_consignment_status').val('').trigger('change');
            // $('#consignment_date').val('');

            generateConsignmentDate('');

            // $('#html_pick_release_date').html('<div id="mount_pick_release_date"></div>');

            if ($("#pick_release_num").val() == '') {

                $('#pick_release_num').val('');
                $('#pick_release_date').val('');
                $('#pick_release_date_input').val('');
            }

            if ($('#customer_number').val() == '') {
                $('#customer_number').val('');
                $('#customer_name').val('');
                $("#customer_id").val('');
            }
        }

        setSelectValue(1);
    });

    $('#pick_release_num').change(function(){

        var releaseNum = $('#pick_release_num').val();

        var consignmentNo           = '';
        var consignmentDate         = '';
        var consignmentStatus       = '';

        var pickReleaseDate         = '';
        var customerNumber          = '';
        var customerName            = '';
        var customerID              = '';
        var consignmentHeadersID    = '';

        if (releaseNum != '') {

            if (stepEvent == 'create') {
                searchCreate();
            }else{
                $.each(consignmentList, function(key, val){
                    if (val.pick_release_num == releaseNum) {
                        consignmentNo           = val.consignment_no;
                        consignmentDate         = val.consignment_date;
                        consignmentStatus       = val.consignment_status;
                        consignmentHeadersID    = val.consignment_header_id;

                        pickReleaseDate         = val.pick_release_approve_date;
                        customerNumber          = val.customer_number;
                        customerName            = val.customer_name;
                        customerID              = val.customer_id;
                    }
                });

                if (pickReleaseDate == '' || pickReleaseDate == undefined) {
                    $.each(orderHeadersList, function(key, val){
                        if (val.pick_release_no == releaseNum) {
                            pickReleaseDate     = val.pick_release_approve_date;
                            customerNumber          = val.customer_number;
                            customerName            = val.customer_name;
                            customerID              = val.customer_id;
                        }
                    });
                }

                // if ($('#consignment_no').val() == '' && stepEvent != 'create') {
                //     $('#consignment_header_id').val(consignmentHeadersID);
                //     $('#consignment_no').val(consignmentNo);
                //     $('#consignment_status').val(consignmentStatus).trigger('change');
                //     $('#hide_consignment_status').val(consignmentStatus).trigger('change');

                //     // $('#consignment_date').val(consignmentDate);
                //     generateConsignmentDate(consignmentDate);
                // }

                $('#pick_release_date').val(pickReleaseDate);
                $('#pick_release_date_input').val(pickReleaseDate);

                if ($('#customer_number').val() == '') {
                    $('#customer_number').val(customerNumber);
                    $('#customer_name').val(customerName);
                    $("#customer_id").val(customerID);
                }
            }


        }else{

            if (stepEvent == 'create') {

                $("#customer_id").val('');
                $("#customer_number").val('').trigger('change');
                $("#customer_name").val('');

                $("#pick_release_date").val('');
                $('#pick_release_date_input').val('');

                var htmlLines = '';

                htmlLines += '<tr class="align-middle">';
                htmlLines += '    <td class="text-right" colspan="5"><strong>รวมมูลค่า</strong></td>';
                htmlLines += '    <td>';
                htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_unit_price_amount" id="total_unit_price_amount" value="0.00">';
                htmlLines += '    </td>';
                htmlLines += '    <td class="text-right" colspan="2"><strong>รวมยอดขายฝาก</strong></td>';
                htmlLines += '    <td>';
                htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_consignment_amount" id="total_consignment_amount" value="0.00">';
                htmlLines += '    </td>';
                htmlLines += '</tr>';
                htmlLines += '<tr class="align-middle">';
                htmlLines += '    <td class="text-right" colspan="8"><strong>รวมมูลค่าขายฝาก</strong></td>';
                htmlLines += '    <td>';
                htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_amount" id="total_amount" value="0.00">';
                htmlLines += '    </td>';
                htmlLines += '</tr>';

                $('#consignmentLines').html(htmlLines);

                $('#total_unit_price_amount').val('');
                $('#total_consignment_amount').val('');
                $('#total_amount').val('');
            }else{
                if ($("#consignment_no").val() == '' && stepEvent != 'create') {
                    $('#consignment_header_id').val('');
                    $('#order_header_id').val('');
                    $('#consignment_no').val('');
                    $('#consignment_status').val('').trigger('change');
                    $('#hide_consignment_status').val('').trigger('change');
                    // $('#consignment_date').val('');
                    generateConsignmentDate('');
                    $('#pick_release_date').val('');
                    $('#pick_release_date_input').val('');
                }

                if ($('#customer_number').val() == '') {
                    $('#customer_number').val('');
                    $("#customer_id").val('');
                    $('#customer_name').val('');
                }
            }
        }

        setSelectValue(2);
    });

    function changeCalculate(id)
    {
        var previousQuantity    = $('#previous_quantity_' + id).val();
        var actualQuantity      = $.trim($('#actual_quantity_' + id).val()) <= 0 ? 0 : $('#actual_quantity_' + id).val();
        var remainingQuantity   = $('#remaining_quantity_' + id).val();
        var mainRemaining       = $('#main_remaining_'+ id).val();
        var remainingResult     = 0;
        var arr                 = $('.actual-quantity');
        var total               = 0;
        var totalAmount         = 0;

        previousQuantity    = $.trim(previousQuantity) <= 0 ? 0 : previousQuantity.replace(/,/g, '');
        actualQuantity      = $.trim(actualQuantity) <= 0 ? 0 : actualQuantity.replace(/,/g, '');
        remainingQuantity   = $.trim(remainingQuantity) <= 0 ? 0 : remainingQuantity.replace(/,/g, '');

        if(actualQuantity < 0 || isNaN(actualQuantity) || actualQuantity == '' || !parseFloat(actualQuantity)){
            $('#actual_quantity_' + id).val('0.00');
            actualQuantity = 0;
        }else if (parseFloat(mainRemaining) < parseFloat(actualQuantity)) {
            Swal.fire({
                icon: 'warning',
                text: 'จำนวนยอดขายที่ระบุมากกว่าจำนวนคงเหลือขาย',
                showConfirmButton: true
            });
            $('#actual_quantity_' + id).val('0.00');
            actualQuantity = 0;
        }else{
            $('#actual_quantity_'+id).val(numberFormat(actualQuantity));
        }

        remainingResult = parseFloat(mainRemaining) - parseFloat(actualQuantity);

        for (let i = 0; i < arr.length; i++) {
            if ($.trim(arr[i].value) <= 0) {
                var newTotal = 0;
            }else{
                var newTotal = arr[i].value.replace(/,/g, '');
            }

            if (parseFloat(newTotal)) {
                total += parseFloat(newTotal);
            }
        }

        $('#sp_remaining_' + id).text(numberFormat(remainingResult));
        $('#remaining_quantity_' + id).val(numberFormat(remainingResult));
        $('#total_consignment_amount').val(numberFormat(total));

        $("input[name='consignment_line[]']").each(function ()
        {
            var lineID = parseFloat($(this).val());

            var actualQuantity  = $.trim($('#actual_quantity_'+lineID).val()) <= 0 ? 0 : $('#actual_quantity_'+lineID).val().replace(/,/g, '');
            var unitPrice       = $('#unit_price_'+lineID).val();
            unitPrice           = unitPrice.replace(/,/g, '');

            totalAmount         = parseFloat(totalAmount) + (parseFloat(unitPrice) * parseFloat(actualQuantity));


        });

        $('#total_amount').val(numberFormat(totalAmount));
    }

    async function saveConsignment(event)
    {
        var consignmentNo   = $('#consignment_no').val();
        var pickReleaseNum  = $('#pick_release_num').val();

        var arr = $('.actual-quantity');
        var checkTotal = false;

        for (let i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value) <= 0) {

            }else{
                checkTotal = true;
            }
        }

        if(pickReleaseNum == ''){
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเลขที่ใบขน',
                showConfirmButton: true
            });
            return false;
        }else if (checkTotal == false || $('#total_consignment_amount').val() <= 0) {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาระบุยอดฝากขาย',
                showConfirmButton: true
            });
            return false;
        }else{
            if (event == 'save') {
                var messageAlert = 'บันทึกรายการฝากขายสโมสรภูมิภาคหรือไม่?';
            }else{
                var messageAlert = 'ยืนยันรายการฝากขายสโมสรภูมิภาคหรือไม่?';
            }

            Swal.fire({
                title: 'แจ้งเตือน',
                text: messageAlert,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
            }).then(async (result) => {
                if (result.isConfirmed) {

                    if ($('#hide_consignment_status').val() == 'Cancelled') {
                        $('#consignment_status').val('Cancelled').trigger('change');
                    }else{
                        $('#consignment_status').val('Draft').trigger('change');
                    }

                    if (event == 'save') {

                        const formData = new FormData(document.getElementById("formConsignmentClub"));
                        formData.append('_token','{{ csrf_token() }}');

                        if ($('#hide_consignment_status').val() == 'Cancelled') {
                            formData.append('consignment_status', 'Cancelled');
                        }else{
                            formData.append('consignment_status', 'Draft');
                        }


                        await $.each(fileChoose,async function(index, file) {
                        if(typeof file !== "undefined")
                            await formData.append('attachment[]', file);
                        });

                        $.ajax({
                            url         : '{{ url("om/ajax/consignment-club/update-consignment-club") }}',
                            type        : 'post',
                            data        : formData,
                            cache       : false,
                            processData : false,
                            contentType : false,
                            success     : function(res){
                                var data = res.data;
                                var html = '';
                                var orderList = data.data;
                                if(data.status == 'success'){

                                    $('#consignment_no').val(data.consignmentNo);
                                    $('#consignment_header_id').val(data.consigmentHeaderID);
                                    $('#order_header_id').val(data.consigmentHeaderID);

                                    consignmentList     = data.consignmentQuery;
                                    orderHeadersList    = data.orderHeadersQuery;


                                    $('#buttonAttachFile').attr('disabled', false);


                                    if ($('#hide_consignment_status').val() == 'Cancelled') {
                                        $('.actual-quantity').prop('readonly', true);
                                    }

                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: "บันทึกรายการฝากขายสโมสรภูมิภาคเรียบร้อยแล้ว",
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 2500
                                    });
                                }else{
                                    Swal.fire({
                                        title: 'ผิดพลาด',
                                        text: "บันทึกใบรายการฝากขายสโมสรภูมิภาคไม่ได้",
                                        icon: 'error',
                                        timer: 2500
                                    });
                                }
                            }
                        });
                    }else{

                        $('#consignment_status').val('Confirm').trigger('change');

                        const formData = new FormData(document.getElementById("formConsignmentClub"));
                        formData.append('_token','{{ csrf_token() }}');
                        formData.append('consignment_status', 'Confirm');

                        await $.each(fileChoose,async function(index, file) {
                        if(typeof file !== "undefined")
                            await formData.append('attachment[]', file);
                        });

                        $.ajax({
                            url         : '{{ url("om/ajax/consignment-club/update-consignment-club") }}',
                            type        : 'post',
                            data        : formData,
                            cache       : false,
                            processData : false,
                            contentType : false,
                            success     : function(res){
                                var data = res.data;
                                var html = '';
                                var orderList = data.data;
                                if(data.status == 'success'){

                                    $('#consignment_no').val(data.consignmentNo);
                                    $('#consignment_header_id').val(data.consigmentHeaderID);
                                    $('#order_header_id').val(data.consigmentHeaderID);

                                    consignmentList     = data.consignmentQuery;
                                    orderHeadersList    = data.orderHeadersQuery;

                                    var disabledInput   = 'readonly';

                                    var consignmentDate = $('#consignment_date').val();
                                    generateConsignmentDate(consignmentDate, true);
                                    $('#html_consignment_date div').addClass('disabled');
                                    $('#html_consignment_date div').attr('readonly', true);
                                    $('#consignment_date').prop('disabled', true);
                                    $('.mx-icon-clear').remove();

                                    $('#consignment_no').prop('readonly', true);
                                    // $('#consignment_status').prop('disabled', true);

                                    $('#pick_release_num').prop('readonly', true);
                                    $('#customer_number').prop('readonly', true);

                                    $('#buttonUpdate').prop('disabled', true);
                                    $('#buttonConfirm').prop('disabled', true);

                                    $('.actual-quantity').prop('readonly', true);


                                    $('#buttonAttachFile').attr('disabled', false);


                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: "ยืนยันรายการฝากขายสโมสรภูมิภาคเรียบร้อยแล้ว",
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 2500
                                    });
                                }else{
                                    Swal.fire({
                                        title: 'ผิดพลาด',
                                        text: "ยืนยันใบรายการฝากขายสโมสรภูมิภาคไม่ได้",
                                        icon: 'error',
                                        timer: 2500
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }
    }

    function numberFormat(nStr)
    {
        nStr = $.trim(nStr) != '' ? nStr : 0;
        nStr = parseFloat(nStr).toFixed(2);
        nStr = Math.round(nStr * 1000) / 1000;
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '.00';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        x2 = x2.length == 2 ? x2.toString()+'0' : x2;
        return x1 + x2;
    }

    function numberFormatDecimal(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function selectCustomer()
    {
        var number = $("#customer_number").val();

        if(number != ''){
            var itemName = '';

            $.each(customerList, function(key,val){
                if (val.customer_number == number) {
                    itemID      = val.customer_id;
                    itemName    = val.customer_name;
                }
            });

            $("#customer_name").val(itemName);
            $("#customer_id").val(itemID);

            // var consignmentNo       = '';
            // var consignmentDate     = '';
            // var consignmentStatus   = '';
            // var pickReleaseNum      = '';
            // var pickReleaseDate     = '';

            // $.each(consignmentList, function(key, val){
            //     if (val.customer_number == number) {
            //         consignmentNo       = val.consignment_no;
            //         consignmentDate     = val.consignment_date;
            //         consignmentStatus   = val.consignment_status;
            //         pickReleaseNum      = val.pick_release_num;
            //         pickReleaseDate     = val.pick_release_date;
            //     }
            // });

            // $("#consignment_no").val(consignmentNo);
            // $("#consignment_date").val(consignmentDate);
            // $("#consignment_status").val(consignmentStatus);
            // $("#pick_release_num").val(pickReleaseNum);
            // $("#pick_release_date").val(pickReleaseDate);


        }else{
            if ($('#customer_number').val() == '') {
                $("#customer_name").val('');
                $("#customer_id").val('');
            }

            if ($("#consignment_no").val() == '' && $("#pick_release_num").val() == '') {
                $("#consignment_no").val('');
                $("#pick_release_num").val('');
                $("#pick_release_date").val('');
                $('#pick_release_date_input').val('');

                if (stepEvent != 'create') {
                    $("#consignment_date").val('');
                    $("#consignment_status").val('').trigger('change');
                    $('#hide_consignment_status').val('').trigger('change');
                }
            }
        }

        setSelectValue(3);
    }

    function resetConsignmentClub()
    {
        $("#customer_id").val('');
        $("#customer_number").val('').trigger('change');
        $("#customer_name").val('');
        $("#consignment_no").val('').trigger('change');
        $('#consignment_header_id').val('');
        $('#order_header_id').val('');
        // $("#consignment_date").val('');
        generateConsignmentDate('');
        $("#consignment_status").val('').trigger('change');
        $('#hide_consignment_status').val('').trigger('change');
        $("#pick_release_num").val('').trigger('change');
        $("#pick_release_date").val('');
        $('#pick_release_date_input').val('');

        $('#consignment_no').prop('readonly', false);

        var htmlLines = '';

        htmlLines += '<tr class="align-middle">';
        htmlLines += '    <td class="text-right" colspan="5"><strong>รวมมูลค่า</strong></td>';
        htmlLines += '    <td>';
        htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_unit_price_amount" id="total_unit_price_amount" value="0.00">';
        htmlLines += '    </td>';
        htmlLines += '    <td class="text-right" colspan="2"><strong>รวมยอดขายฝาก</strong></td>';
        htmlLines += '    <td>';
        htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_consignment_amount" id="total_consignment_amount" value="0.00">';
        htmlLines += '    </td>';
        htmlLines += '</tr>';
        htmlLines += '<tr class="align-middle">';
        htmlLines += '    <td class="text-right" colspan="8"><strong>รวมมูลค่าขายฝาก</strong></td>';
        htmlLines += '    <td>';
        htmlLines += '        <input type="text" class="form-control text-right" readonly name="total_amount" id="total_amount" value="0.00">';
        htmlLines += '    </td>';
        htmlLines += '</tr>';

        $('#consignmentLines').html(htmlLines);

        $('#total_unit_price_amount').val('0.00');
        $('#total_consignment_amount').val('0.00');
        $('#total_amount').val('0.00');

        $('#buttonCreate').attr('disabled', false);
        $('#buttonSearch').attr('disabled', false);
        stepEvent   = '';

        generateConsignmentDate('');

        // $('#consignment_status').prop('disabled', false);

        $('#pick_release_num').prop('readonly', false);
        $('#customer_number').prop('readonly', false);

        $('#buttonSearch').attr('disabled', true);
        $('#buttonUpdate').prop('disabled', false);
        $('#buttonConfirm').prop('disabled', false);
        $('#buttonAttachFile').attr('disabled', true);

        setSelectValue(0);
    }

    function setSelectValue(index)
    {
        var consignmentNo   = $('#consignment_no').val();
        var pickReleaseNum  = $("#pick_release_num").val();
        var number          = $("#customer_number").val();

        var consignmentSelect   = '';
        var pickReleaseSelect   = '';
        var customerSelect      = '';

        // if (index == 2 || index == 3) {
        // if (index == 3) {
            // CONSIGNMENT
            var htmlConList = '<option value=""> &nbsp; </option>';

            $.each(consignmentList, function(key, val){
                if($.trim(val.consignment_no) != ''){
                    if (consignmentNo == val.consignment_no) {
                        consignmentSelect   = 'selected';
                    }else{
                        consignmentSelect   = '';
                    }

                    if (pickReleaseNum == '' && number == ''){
                        htmlConList += '<option value="'+ val.consignment_no +'">'+ val.consignment_no + ' : ' + val.consignment_date + ' : ' + val.pick_release_num +'</option>';
                    }else if (val.customer_number == number && number != '' && pickReleaseNum == '') {
                        if (consignmentNo == val.consignment_no) {
                            consignmentSelect   = 'selected';
                        }else{
                            consignmentSelect   = '';
                        }

                        htmlConList += '<option '+consignmentSelect+' value="'+ val.consignment_no +'">'+ val.consignment_no + ' : ' + val.consignment_date + ' : ' + val.pick_release_num +'</option>';
                    }else if (pickReleaseNum != '' && val.pick_release_num == pickReleaseNum){
                        htmlConList += '<option '+consignmentSelect+' value="'+ val.consignment_no +'">'+ val.consignment_no + ' : ' + val.consignment_date + ' : ' + val.pick_release_num +'</option>';
                    }
                }
            });

            $('#consignment-list').html(htmlConList);
        // }


        // if (index == 1 || index == 3) {
        // if (index == 3) {
            // ORDER HEADERS
            var htmlOrderList = '<option value=""> &nbsp; </option>';

            if(stepEvent == 'create'){
                $.each(orderHeadersList, function(key, val){
                    if($.trim(val.pick_release_no) != '' && val.remaining_quantity > 0){
                        if (stepEvent == 'create') {
                            if (consignmentNo == '' && number == ''){
                                htmlOrderList += '<option value="'+ val.pick_release_no +'">'+ val.pick_release_no + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                            }else if (val.customer_number == number && number != '' && consignmentNo == '') {
                                htmlOrderList += '<option value="'+ val.pick_release_no +'">'+ val.pick_release_no + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                            }else if (number == '') {
                                htmlOrderList += '<option value="'+ val.pick_release_no +'">'+ val.pick_release_no + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                            }else if (val.consignment_no == consignmentNo && val.customer_number == number){
                                htmlOrderList += '<option value="'+ val.pick_release_no +'">'+ val.pick_release_no + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                            }
                        }
                    }
                });
            }else if (consignmentNo == '') {
                $.each(orderHeadersList, function(key, val){
                    if($.trim(val.pick_release_no) != ''){
                        if (pickReleaseNum == val.pick_release_no) {
                            pickReleaseSelect   = 'selected';
                        }else{
                            pickReleaseSelect   = '';
                        }

                        if (consignmentNo == '' && number == ''){
                            htmlOrderList += '<option value="'+ val.pick_release_no +'">'+ val.pick_release_no + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                        }else if (val.customer_number == number && number != '' && consignmentNo == '') {
                            htmlOrderList += '<option '+pickReleaseSelect+' value="'+ val.pick_release_no +'">'+ val.pick_release_no + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                        }else if (number == '') {
                            htmlOrderList += '<option '+pickReleaseSelect+' value="'+ val.pick_release_no +'">'+ val.pick_release_no + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                        }else if (val.consignment_no == consignmentNo && val.customer_number == number){
                            htmlOrderList += '<option '+pickReleaseSelect+' value="'+ val.pick_release_no +'">'+ val.pick_release_no + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                        }
                    }
                });

            }else{
                $.each(consignmentList, function(key, val){
                    if($.trim(val.pick_release_num) != ''){
                        if (pickReleaseNum == val.pick_release_num) {
                            pickReleaseSelect   = 'selected';
                        }else{
                            pickReleaseSelect   = '';
                        }

                        if (number == ''){
                            htmlOrderList += '<option value="'+ val.pick_release_num +'">'+ val.pick_release_num + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                        }else if (val.consignment_no == consignmentNo && number == '') {
                            htmlOrderList += '<option '+pickReleaseSelect+' value="'+ val.pick_release_num +'">'+ val.pick_release_num + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                        }else if (val.consignment_no == consignmentNo && val.customer_number == number){
                            htmlOrderList += '<option '+pickReleaseSelect+' value="'+ val.pick_release_num +'">'+ val.pick_release_num + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                        }else if(val.customer_number == number && consignmentNo == ''){
                            htmlOrderList += '<option '+pickReleaseSelect+' value="'+ val.pick_release_num +'">'+ val.pick_release_num + ' : ' + val.pick_release_approve_date + ' : ' + val.customer_name +'</option>';
                        }

                    }
                });

            }
            $('#pickrelease-list').html(htmlOrderList);
        // }

        // if (index == 1 || index == 2) {
            // CUSTOMERS
            var htmlCustomerList = '<option value=""> &nbsp; </option>';
            checkCustomer = '';

            if (consignmentNo == '' && pickReleaseNum == ''){
                $.each(customerList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (number == '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }else if (val.customer_number == number && number != '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }
                    }
                });
            }else{
                $.each(consignmentList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (number == val.customer_number) {
                            customerSelect   = 'selected';
                        }else{
                            customerSelect   = '';
                        }

                        if (checkCustomer == val.customer_number) {

                        }else if (pickReleaseNum == val.pick_release_num && $.trim(val.pick_release_num) != '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }else if (val.customer_number == number && number != '') {
                            htmlCustomerList += '<option '+customerSelect+' value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }else if (number == ''){
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }
                    }
                    checkCustomer = val.customer_number;
                });
            }


            $('#customers-list').html(htmlCustomerList);
        // }
    }

    function isNumber(el, evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        var number = el.value.split('.');
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        //just one dot (thanks ddlab)
        if(number.length>1 && charCode == 46){
            return false;
        }
        //get the carat position
        var caratPos = getSelectionStart(el);
        var dotPos = el.value.indexOf(".");
        if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
            return false;
        }
        return true;
    }

    function getSelectionStart(o)
    {
        if (o.createTextRange) {
            var r = document.selection.createRange().duplicate()
            r.moveEnd('character', o.value.length)
            if (r.text == '') return o.value.length
            return o.value.lastIndexOf(r.text)
        } else return o.selectionStart
    }

    function round(value, precision) {
        var multiplier = Math.pow(10, precision || 0);
        return Math.round(value * multiplier) / multiplier;
    }

    function generateConsignmentDate(date, status = false)
    {
        $('#html_consignment_date').html('<div id="mount_consignment_date"></div>');
        fieldName   = 'consignment_date';
        fieldID     = 'consignment_date';
        fieldValue  = date;
        mountID     = 'mount_consignment_date';
        disabled    = status;
        generateDatePickerTH(mountID);
    }

    function checkZero(index)
    {
        var actual = parseFloat($('#actual_quantity_'+index).val());

        if ( actual <= 0.00 ) {
            $('#actual_quantity_'+index).val('');
        }
    }

    function inputZero(index) {
        var actual = parseFloat($.trim($('#actual_quantity_'+index).val()));
        if ( actual <= 0.00 || isNaN(actual) ) {
            $('#actual_quantity_'+index).val('0.00');
        }
    }

</script>

<script>

    function generateDatePickerTH(mountID)
    {
        var dateFormat      = '{{ trans('date.js-format') }}';
        var disabled = false;

        var vm = new Vue({
            data() {
                return {
                    pName: fieldName,
                    pID: fieldID,
                    pValue: fieldValue,
                    pFormat: dateFormat,
                    pDisabled: disabled
                }
            },
            template: `<datepicker-th
                            style="width: 100%"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            :name=pName
                            :id=pID
                            placeholder=""
                            @dateWasSelected='onchangeDate(...arguments)'
                            :value=pValue
                            :format=pFormat />`,
            methods: {
                onchangeDate (date) {
                    vm.pValue = date;
                }
            },
            watch: {
                pValue : async function (fieldValue, oldValue) {

                }
            },
        }).$mount('#'+mountID)
    }

</script>
@stop
