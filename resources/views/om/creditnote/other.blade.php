@extends('layouts.app')

@section('title', 'Credit Note กรณีอื่นๆ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

    <style>
        select.form-control:not([size]):not([multiple]){
            height: auto;
            margin-bottom: 5px;
        }
    </style>
@stop

@section('page-title')
    <h2>OMP0033 : Credit Note กรณีอื่นๆ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>OMP0033 : Credit Note กรณีอื่นๆ</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>OMP0033 : Credit Note กรณีอื่นๆ</h3>
    </div>
    <div class="ibox-content">
        <div class="row space-50 justify-content-md-center flex-column mt-md-4">
            <div class="col-12">
                <div class="form-header-buttons">
                    <div class="d-flex">
                        <button class="btn btn-white" onclick="btnClearForm();"><i class="fa fa-repeat"></i></button>
                    </div>
                    <div class="buttons multiple">
                        <button class="btn btn-md btn-success in_create" type="button" onclick="create_invoice();" ><i class="fa fa-plus"></i> สร้าง</button>
                        <button class="btn btn-md btn-danger in_cancel" disabled type="button" onclick="popCancelInvoice();"><i class="fa fa-times"></i> ยกเลิก</button>
                        <button class="btn btn-md btn-primary in_confirm" disabled type="button" onclick="saveInvoice();" ><i class="fa fa-save"></i> บันทึก</button>
                        <button class="btn btn-md btn-white"  type="button" onclick="searchInvoice();"><i class="fa fa-search"></i> ค้นหา</button>
                    </div>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>
            </div><!--col-12-->

            <form id="form_data">
            <div class="col-xl-12 m-auto">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">เลขที่ใบลดหนี้</label>
                            <div class="input-icon">
                                <input type="text" list="ceditnote_number_list" class="form-control" id="ceditnote_number_show" name="ceditnote_number_show" placeholder="" value="">
                                <datalist id="ceditnote_number_list">

                                </datalist>
                                {{-- <select id="ceditnote_number_show" name="ceditnote_number_show" autocomplete="off" class="custom-select select2">

                                </select> --}}
                                {{-- <input type="text" class="form-control" id="ceditnote_number_show" name="ceditnote_number_show" placeholder="" value=""> --}}
                                <input type="hidden" id="ceditnote_number" name="ceditnote_number">
                                <input type="hidden" id="cedirnote_invoice_id" name="cedirnote_invoice_id">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">วันที่</label>
                            <div class="input-icon">
                                {{-- <input type="text" class="form-control" id="ceditnote_date_show"  name="ceditnote_date_show" disabled="" placeholder="" value=""> --}}
                                <input type="hidden" id="ceditnote_date" name="ceditnote_date" >
                                <datepicker-th
                                style="width: 100%"
                                :disabled="true"
                                class="form-control md:tw-mb-0 tw-mb-2 form_input_disabled ceditnote_date_show"
                                name="ceditnote_date_show"
                                id="ceditnote_date_show"
                                placeholder="โปรดเลือกวันที่"
                                value=""
                                format="DD/MM/YYYY"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">สถานะ</label>
                            <input type="text" class="form-control" disabled id="ceditnote_status" name="ceditnote_status" placeholder="" value="">
                        </div>
                    </div>

                    <!--//-->
                    <div class="col-xl-8">
                        <div class="form-group">
                            <label class="d-block">รหัสลูกค้า <label class="text-danger">*</label> </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        {{-- <select name="customer_number" id="customer_list" class="custom-select select2 form_input_disabled" onchange="searchcustomer(this.value)" >

                                        </select> --}}
                                        {{-- <select class="custom-select select2 form_input_disabled" autocomplete="off" id="customer_number"  name="customer_number" onchange="searchcustomer(this.value);getCreditNoteList(this.value);">

                                        </select> --}}
                                        <input type="text" list="customer_list" class="form-control form_input_disabled" autocomplete="off" id="customer_number"  name="customer_number" onchange="searchcustomer(this.value);getCreditNoteList(this.value);" onkeyup="searchcustomer(this.value);getCreditNoteList(this.value);">

                                        <datalist id="customer_list">

                                        </datalist>
                                        <input type="hidden" id="customer_id" name="customer_id" value="">
                                    </div>
                                </div>
                                <div class="col-md-8 mt-2 mt-md-0">
                                    <input type="text" class="form-control" disabled id="customer_name" name="customer_name" placeholder="" value="">
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->


                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">จำนวนเงินลดหนี้ <label class="text-danger">*</label></label>
                            <input type="text" class="form-control blue text-right form_input_disabled" disabled onblur="formatCurrency('price_amount','blur');" onkeyup="formatCurrency('price_amount');" id="price_amount" name="price_amount" placeholder="" value="">
                            <input type="hidden" id="price_amount_data" name="price_amount_data">
                        </div>
                    </div>

                    <!--//-->

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="d-block">จังหวัด</label>
                            <input type="text" class="form-control" disabled id="customer_provice" name="customer_provice" placeholder="" value="">
                            <input type="hidden" id="customer_provice_name" name="customer_provice_name" >
                        </div>
                    </div>

                    <div class="col-md-12"></div>
                    <!--//-->

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">เลขที่ </label>
                            <input type="text" class="form-control form_input_disabled" disabled autocomplete="off" name="number_order" id="number_order" placeholder="" value="">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">ทาง </label>
                            <select class="custom-select select2 form_input_disabled" disabled autocomplete="off" name="invoice_channel" id="channelreceiving_list" >

                            </select>
                        </div>
                    </div>

                    <div class="col-md-12"></div>

                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="d-block">เดบิต บัญชี</label>
                            <div class="row space-5">
                                <div class="col-4">
                                    <div class="input-icon">
                                        {{-- <select class="custom-select select2 form_input_disabled" disabled name="accountmapping_debit" id="accountmapping_debit" onchange="chageAccountMap()">
                                            <option value=""></option>
                                            @foreach ($account_mapping as $item_acmap)
                                                <option value="{{ $item_acmap['account_combine'] }}" data-value="{{ $item_acmap['account_code'] }}" data-des="{{ $item_acmap['account_description'] }}" data-comdes="{{ $item_acmap['combine_desc'] }}" >{{ $item_acmap['account_description'] }}</option>
                                            @endforeach
                                        </select> --}}
                                        <input type="text" list="accdebit" class="form-control form_input_disabled" autocomplete="off" disabled name="accountmapping_debit" id="accountmapping_debit" onkeyup="chageAccountMap()" onchange="chageAccountMap()" placeholder="" value="">
                                        <datalist id="accdebit">
                                            @foreach ($account_mapping as $item_acmap)
                                                <option value="{{ $item_acmap['account_combine'] }}" data-value="{{ $item_acmap['account_code'] }}" data-des="{{ $item_acmap['account_description'] }}" data-comdes="{{ $item_acmap['combine_desc'] }}" >{{ $item_acmap['account_description'] }}</option>
                                            @endforeach
                                        </datalist>
                                        <input type="hidden" name="accountmapping_id" id="accountmapping_id" value="">
                                        <i class="fa fa-search" data-toggle="modal" data-target="#myModal"></i>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" disabled id="accountmapping_code" name="accountmapping_code" placeholder="" value="">
                                    <input type="hidden" class="form-control" id="input_mapping_code" name="input_mapping_code" placeholder="" value="">
                                </div>

                                <div class="col-4">
                                    <input type="text" class="form-control" disabled id="accountmapping_name" name="accountmapping_name" placeholder="" value="">
                                    <input type="hidden" class="form-control" id="input_mapping_name" name="input_mapping_name" placeholder="" value="">
                                </div>
                            </div><!--row-->
                            <small class="text-danger" id="cd_deccombi" ></small>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="d-block">เครดิต บัญชี</label>
                            <div class="row space-5">
                                <div class="col-4">
                                    <div class="input-icon">
                                        {{-- <select class="custom-select select2 form_input_disabled" disabled name="accountmapping_cedit" id="accountmapping_cedit" onchange="chageAccountMapcredit()" >
                                            <option value=""></option>
                                            @foreach ($account_mapping as $item_acmap)
                                                <option value="{{ $item_acmap['account_combine'] }}" data-value="{{ $item_acmap['account_code'] }}" data-des="{{ $item_acmap['account_description'] }}" data-comdes="{{ $item_acmap['combine_desc'] }}" >{{ $item_acmap['account_description'] }}</option>
                                            @endforeach
                                        </select> --}}
                                        <input type="text" list="acccedit" class="form-control form_input_disabled" autocomplete="off" name="accountmapping_cedit" id="accountmapping_cedit" onkeyup="chageAccountMapcredit()" onchange="chageAccountMapcredit()" disabled placeholder="" value="">
                                        <datalist id="acccedit">
                                            @foreach ($account_mapping as $item_acmap)
                                                <option value="{{ $item_acmap['account_combine'] }}" data-value="{{ $item_acmap['account_code'] }}" data-des="{{ $item_acmap['account_description'] }}" data-comdes="{{ $item_acmap['combine_desc'] }}" >{{ $item_acmap['account_description'] }}</option>
                                            @endforeach
                                        </datalist>
                                        <input type="hidden" name="accountmapping_cid" id="accountmapping_cid" value="">
                                        <i class="fa fa-search" data-toggle="modal" data-target="#modalCreditNote"></i>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <input type="text" class="form-control" disabled id="accountmapping_ceditcode" name="accountmapping_ceditcode" placeholder="" value="">
                                    <input type="hidden" class="form-control" id="input_mapping_ceditcode" name="input_mapping_ceditcode" placeholder="" value="">
                                </div>

                                <div class="col-4">
                                    <input type="text" class="form-control" disabled  id="accountmapping_ceditname" name="accountmapping_ceditname" placeholder="" value="">
                                    <input type="hidden" class="form-control" id="input_mapping_ceditname" name="input_mapping_ceditname" placeholder="" value="">
                                </div>
                            </div><!--row-->
                            <small class="text-danger" id="cr_deccombi"></small>
                        </div>
                    </div><!--col-->
                    @include('om.creditnote._form_credit_other')
                    <!--//-->

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">ลงวันที่</label>
                            <div class="input-icon">
                                <datepicker-th
                                    style="width: 100%"
                                    :disabled="true"
                                    class="form-control md:tw-mb-0 tw-mb-2 date_at"
                                    name="date_at"
                                    id="date_at"
                                    placeholder="โปรดเลือกวันที่"
                                    value=""
                                    format="DD/MM/YYYY"
                                    >
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">วันที่อนุมัติ</label>
                            <div class="input-icon">
                                <datepicker-th
                                    style="width: 100%"
                                    :disabled="true"
                                    class="form-control md:tw-mb-0 tw-mb-2 approve_date"
                                    name="approve_date"
                                    id="approve_date"
                                    placeholder="โปรดเลือกวันที่"
                                    value=""
                                    format="DD/MM/YYYY"
                                    >
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">เลขที่อนุมัติ</label>
                            <input type="text" class="form-control form_input_disabled" autocomplete="off" disabled id="approve_document"  name="approve_document" placeholder="" value="">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="d-block">ประเภทการรับเงิน <label class="text-danger">*</label></label>
                            <div class="d-md-flex">
                                <div class="mr-3 mt-2"><label><input type="radio" class="term_radio form_input_disabled" value="28" id="term_28" name="type_payment"><span> เงินเชื่อ 28 วัน</span></label></div>
                                <div class="mr-3 mt-2"><label><input type="radio" class="term_radio form_input_disabled" value="7" id="term_7" name="type_payment"><span> เงินเชื่อ 7 วัน</span></label></div>
                                <div class="mt-2"><label>     <input type="radio" class="term_radio form_input_disabled" value="0" id="term_0" name="type_payment" checked><span> เงินสด</span></label></div>
                            </div>
                        </div>
                    </div>

                </div><!--row-->
            </div><!--col-xl-12-->

            <div class="col-xl-12">
                <div class="alert alert-warning alert-dismissible print-error-msg-creditnote" id="close-btn-creditnote" style="display: none;">
                    <button type="button" class="close" onclick="$('#close-btn-creditnote').hide();">&times;</button>
                    <h5> Warning!</h5>
                    <ul></ul>
                </div>
                <hr class="lg">
            </div>

            {{-- <div class="col-xl-12 m-auto">
                <div class="table-responsive">
                    <table class="table table-bordered text-center table-hover min-1200 f13">
                        <thead>
                            <tr class="align-middle">
                                <th class="w-201">เลขที่เอกสาร</th>
                                <th class="w-201">จำนวนเงิน</th>
                                <th>วันที่ส่ง</th>
                                <th>วันที่ครบกำหนด</th>
                                <th>กลุ่มวงเงิน</th>
                                <th>จำนวนวัน</th>
                                <th>ค่าปรับ</th>
                                <th class="w-201">จำนวนเงินที่ชำระ</th>
                                <th class="w-60">ตัด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <td>
                                    <div class="input-icon">
                                        <select class="custom-select select2" name="order_number" id="order_number_1" onchange="selectOrder(this.value);" >

                                        </select>
                                        <input type="hidden" id="order_id" name="order_id">
                                        <input type="hidden" id="order_number_data" name="order_number_data">
                                        <input type="hidden" id="order_type" name="order_type">
                                        <input type="hidden" id="product_type" name="product_type">
                                    </div>
                                </td>
                                <td class="text-right" id="amount_order_1"></td>
                                <td id="order_date_1"></td>
                                <td id="order_duedate_1"></td>
                                <td><span id="contact_1"></span> <input type="hidden" name="creadit_group[1]" id="creadit_group_1"> </td>
                                <td id="day_duedate_1"></td>
                                <td id="payover_1"></td>
                                <td class="text-right">
                                     <input type="text" class="form-control text-right" onblur="formatCurrency('payment_total_1','blur');" onkeyup="sumTotal();formatCurrency('payment_total_1');" name="payment_total[1]" id="payment_total_1" placeholder="" value="">
                                 </td>
                                <td>
                                    <div class="wihtout-text m-auto"><label><input type="checkbox" value="Y" data-index="1" onclick="checkAmount()" name="payment_status[1]" id="payment_status_1"></label></div>
                                    <input type="hidden" name="invoice_line[1]" id="invoice_line_1" >
                                </td>
                            </tr>

                            <tr class="align-middle" id="add_list_order">
                                <td class="text-right"><strong class="black">รวมเงินเชื่อและสด</strong></td>
                                <td>
                                    <input type="text" class="form-control text-right black" disabled="" id="total_amount_shop" placeholder="" value="">
                                    <input type="hidden" id="total_amount_order" name="total_amount_order">
                                </td>
                                <td class="text-right" colspan="5"><strong class="black">จำนวนเงินที่ขำระ</strong></td>
                                <td>
                                    <input type="text" class="form-control text-right blue" id="total_payment" disabled="" name="" placeholder="" value="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}
        </form>
        </div><!--row-->
    </div><!--ibox-content-->
</div><!--ibox-->
@endsection

@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>

<script>
    var customer_list_arr           = [];
    var order_list                  = [];
    var invoice_search              = [];
    var status                      = '';
    customer_list();
    channelreceiving_list();
    getCreditNoteList('');

    $(".select2").select2();

    function customer_list()
    {
        loading();
        var customer = $("#customer_number").val();
        $.ajax({
            url : '{{ url("om/ajax/credit-note-other/customer_list") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
                customer : customer
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                var html = '<option value=""></option>';

                customer_list_arr = data.data;
                $.each(data.data,function(key,val){
                    html += '<option value="'+val.number+'">'+val.number+':'+val.name+'</option>';
                });

                $("#customer_list").html(html);
            }
        });
    }

    function getCreditNoteList(customer)
    {
        if(customer != ''){
            var customer_id = customer_list_arr[customer].id
        }else{
            var customer_id = '';
        }

        $.ajax({
            url : '{{ url("om/ajax/credit-note-other/getcreditnote") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
                customer_id : customer_id
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                var html = '<option value=""></option>';

                $.each(data.data,function(key,val){
                    html += '<option value="'+val.invoice_headers_number+'">'+val.invoice_headers_number+' : '+val.invoice_date+' : '+val.customer_name+'</option>';
                });

                $("#ceditnote_number_list").html(html);
            }
        });
    }

    function searchcustomer(code)
    {
        if(code == ''){
            $("#customer_id").val('');
            $("#customer_provice").val('');
            $("#customer_provice_name").val('');
            $("#customer_name").val('');
            return false;
        }
        // var customer = $("#customer_number").val();
        if(customer_list_arr[code] != '' && customer_list_arr[code] != 'null'){
            $("#customer_id").val(customer_list_arr[code].id);
            $("#customer_provice").val(customer_list_arr[code].province);
            $("#customer_provice_name").val(customer_list_arr[code].province);
            $("#customer_name").val(customer_list_arr[code].name);
            // $("#price_amount").prop('disabled',true);
            searchOrder();
        }else{
            $("#customer_provice").val('');
            $("#customer_name").val('');
        }
    }

    function create_invoice()
    {
        $("#form_data")[0].reset();
        loading();
        $.ajax({
            url         : '{{ url("om/ajax/credit-note-other/gencreatenumber") }}',
            type        : 'post',
            data        : {
                '_token' : '{{ csrf_token() }}'
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    // $("#ceditnote_number_show").val(data.data.number);
                    $("#ceditnote_number_show").prop('disabled',true);
                    // $("#ceditnote_number").val(data.data.number);
                    $(".in_confirm").prop('disabled',false);
                    $("#ceditnote_date").val(data.data.date);
                    $("#ceditnote_date_show").val(data.data.date);
                    $("#ceditnote_status").val('Draft');
                    $(".form_input_disabled").prop('disabled',false);
                    $("#accountmapping_debit").val("{{ $account_mapping['06']['account_combine'] }}").trigger('change');
                    $("#accountmapping_cedit").val("{{ $account_mapping['13']['account_combine'] }}").trigger('change');
                    reActiveDatePicker(data.data.date,data.data.date);
                    reActiveCeditnoteDate(data.data.date)
                }else{
                    AlertToast('แจ้งเตือน','มีบางอย่างผิดผลาดกรุณาลองอีกครั้ง','error');
                }
            }
        });
    }

    function channelreceiving_list()
    {
        $.ajax({
            url : '{{ url("om/ajax/credit-note-other/channelreceiving_list") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
            },
            success:function(rest){
                var data = rest.data;
                var html = '<option value=""></option>';

                channelreceiving_list_arr = data.data;
                $.each(data.data,function(key,val){
                    html += '<option value="'+val.id+'">'+val.name+'</option>';
                });

                $("#channelreceiving_list").html(html);
            }
        });
    }

    function searchOrder()
    {
        var customer_id = $("#customer_id").val();
        var invoice_id  = $("#cedirnote_invoice_id").val();

        loading();
        $.ajax({
            url : '{{ url("om/ajax/credit-note-other/get_order") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
                customer_id      : customer_id,
                invoice_id       : invoice_id
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                order_list = data.data;

                var html = '<option value=""></option>';
                $.each(data.data,function(key,val){
                    html += '<option value="'+key+'" data-type="'+val.type+'" >'+key+'</option>';
                });

                $("#order_number_1").html(html);

                if(invoice_search.item_line){
                    $("#order_number_1").val(invoice_search.item_line).trigger('change');
                }
                // $("#order_id").val(data.data.id);
                // $("#amount_order").html(data.data.amount);
                // $("#order_date").html(data.data.order_date);
                // $("#order_duedate").html(data.data.payment_duedate);
                // $("#contact").html(data.data.contact);
            }
        });
    }

    function selectOrder(number)
    {
        var invoice_id  = $("#cedirnote_invoice_id").val();
        $(".tr_line").remove();
        if(number == ''){
            $("#order_id").val('');
            $("#order_number_data").val('');
            $("#order_type").val('');
            $("#product_type").val('');
            $("#amount_order_1").html(numberFormat(0));
            $("#order_date_1").html('');
            $("#order_duedate_1").html('');
            $("#contact_1").html('');
            $("#day_duedate_1").html(0);
            $("#payover_1").html(0);
            $("#creadit_group_1").val('');
            $("#payment_total_1").val(numberFormat(0));
            $("#payment_status_1").prop('checked',false);
            $("#invoice_line_1").val('');
            $("#total_amount_shop").val(numberFormat(0));
            $("#total_amount_order").val(0);
            $("#total_payment").val(numberFormat(0));

            $("#accountmapping_debit").prop('disabled',false);
            $("#accountmapping_cedit").prop('disabled',false);

            $("#accountmapping_debit").val("{{ $account_mapping['06']['account_combine'] }}").trigger('change');
            $("#accountmapping_cedit").val("{{ $account_mapping['13']['account_combine'] }}").trigger('change');
            return false;
        }
        var data = order_list[number];
        $("#accountmapping_debit").val('').trigger('change');
        $("#accountmapping_cedit").val('').trigger('change');

        $("#accountmapping_debit").prop('disabled',true);
        $("#accountmapping_cedit").prop('disabled',true);

        if(Object.keys(order_list[number]).length > 1){
            var key         = Object.keys(order_list[number]);
            var i           = 1;
            var html        = '';
            var total       = 0;
            var alltotal    = 0;
            if(status == 'Confirm'){
                var dis_input   = 'disabled';
            }else{
                var dis_input   = '';
            }
            $.each(data,function(key,val){
                if(i == 1){
                    $("#order_id").val(val.id);
                    $("#order_number_data").val(val.number);
                    $("#order_type").val(val.type);
                    $("#product_type").val(val.product_type);
                    $("#amount_order_1").html(numberFormat(val.total_group));
                    $("#order_date_1").html(val.order_date);
                    $("#order_duedate_1").html(val.payment_duedate);
                    $("#contact_1").html(val.contact);
                    $("#day_duedate_1").html(val.day);
                    $("#payover_1").html(val.payover);
                    $("#creadit_group_1").val(key);
                    if(invoice_id != ''){
                        if(val.check == 'Yes'){
                            $("#payment_total_1").val(numberFormat(val.amount));
                        }else{
                            $("#payment_total_1").val(numberFormat(0));
                        }
                    }else{
                        $("#payment_total_1").val(numberFormat(val.total_group));
                    }
                    if(val.check == 'Yes'){
                        $("#payment_status_1").prop('checked',true);
                    }else{
                        $("#payment_status_1").prop('checked',false);
                    }
                    $("#invoice_line_1").val(val.line_id);
                    if(status == 'Confirm'){
                        $("#order_number_1").prop('disabled',true);
                        $("#payment_total_1").prop('disabled',true);
                        $("#payment_status_1").prop('disabled',true);
                    }
                }else{
                    html += '<tr class="align-middle tr_line">';
                    html += '    <td>';
                    html += '    </td>';
                    html += '    <td class="text-right" id="amount_order_'+i+'">'+numberFormat(val.total_group)+'</td>';
                    html += '    <td id="order_date_'+i+'">'+val.order_date+'</td>';
                    html += '    <td id="order_duedate_'+i+'">'+val.payment_duedate+'</td>';
                    html += '    <td id="contact_'+i+'">'+val.contact+' <input type="hidden" name="creadit_group['+i+']" id="creadit_group_'+i+'" value="'+key+'" > </td>';
                    html += '    <td id="day_duedate_'+i+'">'+val.day+'</td>';
                    html += '    <td id="payover_'+i+'">'+val.payover+'</td>';
                    html += '    <td class="text-right">';
                    if(invoice_id != ''){
                        if(val.check == 'Yes'){
                            if(val.amount_invoice != ''){
                                html += '         <input type="text" class="form-control text-right" '+dis_input+' onblur="formatCurrency('+"'payment_total_"+i+"'"+','+"'blur'"+"'"+')" onkeyup="sumTotal();formatCurrency('+"'payment_total_"+i+"'"+');" name="payment_total['+i+']" id="payment_total_'+i+'" placeholder="" value="'+numberFormat(val.amount_invoice)+'">';
                            }else{
                                html += '         <input type="text" class="form-control text-right" '+dis_input+' onblur="formatCurrency('+"'payment_total_"+i+"'"+','+"'blur'"+"'"+')" onkeyup="sumTotal();formatCurrency('+"'payment_total_"+i+"'"+');" name="payment_total['+i+']" id="payment_total_'+i+'" placeholder="" value="'+numberFormat(val.amount)+'">';
                            }
                        }else{
                            html += '         <input type="text" class="form-control text-right" '+dis_input+' onblur="formatCurrency('+"'payment_total_"+i+"'"+','+"'blur'"+"'"+')" onkeyup="sumTotal();formatCurrency('+"'payment_total_"+i+"'"+');" name="payment_total['+i+']" id="payment_total_'+i+'" placeholder="" value="'+numberFormat(0)+'">';                      
                        }
                    }else{
                        html += '         <input type="text" class="form-control text-right" '+dis_input+' onblur="formatCurrency('+"'payment_total_"+i+"'"+','+"'blur'"+"'"+')" onkeyup="sumTotal();formatCurrency('+"'payment_total_"+i+"'"+');" name="payment_total['+i+']" id="payment_total_'+i+'" placeholder="" value="'+numberFormat(val.total_group)+'">';
                    }
                    html += '     </td>';
                    html += '    <td>';
                        if(val.check == 'Yes'){
                            html += '        <div class="wihtout-text m-auto"><label><input type="checkbox" '+dis_input+' checked="" value="Y" data-index="'+i+'" onclick="checkAmount()" name="payment_status['+i+']" id="payment_status_'+i+'"></label></div>';
                        }else{
                            html += '        <div class="wihtout-text m-auto"><label><input type="checkbox" '+dis_input+' value="Y" data-index="'+i+'" onclick="checkAmount()" name="payment_status['+i+']" id="payment_status_'+i+'"></label></div>';
                        }
                    html += '        <input type="hidden" id="line_id_'+i+'" name="invoice_line['+i+']" value="'+val.line_id+'" >'
                    html += '    </td>';
                    html += '</tr>';
                }
                i += 1;
                total += val.total_group*1;
                if(val.check == 'Yes'){
                    if(val.amount_invoice != ''){
                        alltotal += val.amount_invoice*1;
                    }else{
                        alltotal += val.amount*1;
                    }
                }
            });

            $(html).insertBefore($("#add_list_order"));
            $("#total_amount_shop").val(numberFormat(total));
            $("#total_amount_order").val(total);
            $("#total_payment").val(numberFormat(alltotal));
        }else{
            var key = Object.keys(order_list[number]);
            $("#order_id").val(data[key[0]].id);
            $("#order_number_data").val(data[key[0]].number);
            $("#order_type").val(data[key[0]].type);
            $("#product_type").val(data[key[0]].product_type);
            $("#amount_order_1").html(numberFormat(data[key[0]].amount));
            $("#order_date_1").html(data[key[0]].order_date);
            $("#order_duedate_1").html(data[key[0]].payment_duedate);
            $("#contact_1").html(data[key[0]].contact);
            $("#creadit_group_1").val(data[key[0]].contact_id);
            $("#day_duedate_1").html(data[key[0]].day);
            $("#payover_1").html(data[key[0]].payover);
            $("#total_amount_shop").val(numberFormat(data[key[0]].amount));
            $("#total_amount_order").val(data[key[0]].amount);
            if(data[key[0]].amount_invoice != ''){
                $("#payment_total_1").val(numberFormat(data[key[0]].amount_invoice));
            }else{
                $("#payment_total_1").val(numberFormat(data[key[0]].amount));
            }
            if(data[key[0]].amount_invoice != ''){
                $("#total_payment").val(numberFormat(data[key[0]].amount_invoice));
            }else{
                $("#total_payment").val(numberFormat(data[key[0]].amount));
            }
            if(data[key[0]].check == 'Yes'){
                $("#payment_status_1").prop('checked',true);
            }else{
                $("#payment_status_1").prop('checked',false);
            }
            $("#invoice_line_1").val(data[key[0]].line_id);
            if(status == 'Confirm'){
                $("#order_number_1").prop('disabled',true);
                $("#payment_total_1").prop('disabled',true);
                $("#payment_status_1").prop('disabled',true);
            }
        }
    }

    function checkAmount()
    {
        var new_amount = 0;
        $.each($("input[name^=payment_status]"),function(key,value){
            if($(value).prop('checked')){
                var id = $(value).data('index');
                var value = $("input[name='payment_total["+id+"]']").val().toString().replace(/,/g, '');
                new_amount += parseFloat(value);
            }
        });

        $("#total_payment").val(numberFormat(new_amount));
        $("#price_amount").val(numberFormat(new_amount));
        $("#price_amount_data").val(numberFormat(new_amount));
    }

    function saveInvoice()
    {
        const formdata = new FormData(document.getElementById("form_data"));
        formdata.append('_token','{{ csrf_token() }}');
        loading();
        $.ajax({
            url         : '{{ url("om/ajax/credit-note-other/save_invoice") }}',
            type        : 'post',
            data        : formdata,
            cache       : false,
            processData : false,
            contentType : false,
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    $("#cedirnote_invoice_id").val(data.header);
                    $("#ceditnote_status").val(data.header_status);
                    $("#ceditnote_number").val(data.header_number);
                    $("#ceditnote_number_show").val(data.header_number);

                    searchInvoice();
                    // if(data.line_id){
                    //     $.each(data.line_id,function(key_line,val_line){
                    //         $("#line_id_"+key_line).val(val_line);
                    //     });
                    // }
                    // $(".in_cancel").prop('disabled',false);
                    // $(".in_confirm").prop('disabled',true);
                    // $(".in_create").prop('disabled',true);
                    // $(".form_input_disable").prop('disabled',true);
                    // status = 'confirm';
                    // window.location.reload();
                    // $("#form_data")[0].reset();
                    AlertToast('สำเร็จ','เพิ่มสำเร็จ','success');
                    $('#close-btn-contact').hide();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgContact(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','มีบางอย่างผิดผลาดกรุณาลองอีกครั้ง','error');
                    }
                }
            }
        });
    }

    function chageAccountMap()
    {
        var val = $("#accountmapping_debit").val();
        var dec = $("#accdebit option").filter(function(){
            return this.value == val;
        }).data('des');
        var id = $("#accdebit option").filter(function(){
            return this.value == val;
        }).data('value');

        var comdes = $("#accdebit option").filter(function(){
            return this.value == val;
        }).data('comdes');

        if(dec){
            $("#accountmapping_id").val(id);
            $("#accountmapping_code").val(val);
            $("#accountmapping_name").val(dec);
            $("#input_mapping_code").val(val);
            $("#input_mapping_name").val(dec);
            $("#cd_deccombi").html(comdes);

            var arr_val = val.split(".");
            var arr_id  = ['company_code','evm','department_code','cost_center','budget_year','budget_type','budget_detail','budget_reason','main_account','sub_account','reserved1','reserved2'];

            $.each(arr_id,function(key,val){
                $("#"+val).val(arr_val[key]).trigger('change');
            });
        }else{
            if(val){
                $("#accountmapping_id").val('');
                $("#accountmapping_code").val('');
                $("#accountmapping_name").val('');
                $("#input_mapping_code").val('');
                $("#input_mapping_name").val('');
                $("#cd_deccombi").html(comdes);

                var arr_val = val.split(".");
                var arr_id  = ['company_code','evm','department_code','cost_center','budget_year','budget_type','budget_detail','budget_reason','main_account','sub_account','reserved1','reserved2'];

                $.each(arr_id,function(key,val){
                    $("#"+val).val(arr_val[key]).trigger('change');
                });
            }else{
                $("#accountmapping_id").val('');
                $("#accountmapping_code").val('');
                $("#accountmapping_name").val('');
                $("#input_mapping_code").val('');
                $("#input_mapping_name").val('');
                $("#cd_deccombi").html('');
            }
        }

    }

    function chageAccountMapcredit()
    {
        var val = $("#accountmapping_cedit").val();
        var dec = $("#acccedit option").filter(function(){
            return this.value == val;
        }).data('des');
        var id = $("#acccedit option").filter(function(){
            return this.value == val;
        }).data('value');
        var comdes = $("#acccedit option").filter(function(){
            return this.value == val;
        }).data('comdes');
        
        if(dec){
            $("#accountmapping_cid").val(id);
            $("#accountmapping_ceditcode").val(val);
            $("#accountmapping_ceditname").val(dec);
            $("#input_mapping_ceditcode").val(val);
            $("#input_mapping_ceditname").val(dec);
            $("#cr_deccombi").html(comdes);

            var arr_val = val.split(".");
            var arr_id  = ['cr_company_code','cr_evm','cr_department_code','cr_cost_center','cr_budget_year','cr_budget_type','cr_budget_detail','cr_budget_reason','cr_main_account','cr_sub_account','cr_reserved1','cr_reserved2'];
            
            $.each(arr_id,function(key,val){
                $("#"+val).val(arr_val[key]).trigger('change');
            });
        }else{
            if(val){
                $("#accountmapping_cid").val('');
                $("#accountmapping_ceditcode").val('');
                $("#accountmapping_ceditname").val('');
                $("#input_mapping_ceditcode").val('');
                $("#input_mapping_ceditname").val('');
                $("#cr_deccombi").html(comdes);

                var arr_val = val.split(".");
                var arr_id  = ['cr_company_code','cr_evm','cr_department_code','cr_cost_center','cr_budget_year','cr_budget_type','cr_budget_detail','cr_budget_reason','cr_main_account','cr_sub_account','cr_reserved1','cr_reserved2'];
                
                $.each(arr_id,function(key,val){
                    $("#"+val).val(arr_val[key]).trigger('change');
                });
            }else{
                $("#accountmapping_cid").val('');
                $("#accountmapping_ceditcode").val('');
                $("#accountmapping_ceditname").val('');
                $("#input_mapping_ceditcode").val('');
                $("#input_mapping_ceditname").val('');
                $("#cr_deccombi").html('');
            }
        }
    }

    function sumTotal()
    {
        var new_amount = 0;
        
        $.each($("input[name^=payment_status]"),function(key,value){
            if($(value).prop('checked')){
                var id = $(value).data('index');
                var value = $("input[name='payment_total["+id+"]']").val().toString().replace(/,/g, '');
                new_amount += parseFloat(value);
            }
        });

        $("#total_payment").val(numberFormat(new_amount));
        $("#price_amount").val(numberFormat(new_amount));
        $("#price_amount_data").val(numberFormat(new_amount));
    }

    function searchInvoice()
    {
        var number = $("#ceditnote_number_show").val();
        if(number == ''){
            AlertToast('แจ้งเตือน','เลขที่ใบลดหนี้','error');
            return false;
        }
        loading();
        $.ajax({
            url     : '{{ url("om/ajax/credit-note-other/search_invoice") }}',
            type    : 'post',
            data    : {
                '_token'    : '{{ csrf_token() }}',
                number      : number,
            },
            success:function(rest){
                swal.close();
                var data = rest.data.data;
                invoice_search = data;

                status = data.invoice_status;
                $("#ceditnote_number_show").prop('disabled',true);
                $("#cedirnote_invoice_id").val(data.invoice_headers_id);
                if(data.invoice_status == 'Cancelled'){
                    $(".in_confirm").prop('disabled',true);
                    $(".in_create").prop('disabled',true);
                    $(".form_input_disabled").prop('disabled',true);
                    reActiveDatePicker(data.document_date,data.approve_date);
                    reActiveCeditnoteDate(data.date_invoice)
                }else if(data.invoice_status == 'Draft'){
                    $(".in_cancel").prop('disabled',false);
                    $(".in_confirm").prop('disabled',false);
                    $(".in_create").prop('disabled',true);
                    $(".form_input_disabled").prop('disabled',false);
                    reActiveDatePicker(data.document_date,data.approve_date);
                    reActiveCeditnoteDate(data.date_invoice)
                }else if(data.invoice_status == 'Confirm'){
                    $(".in_cancel").prop('disabled',false);
                    $(".in_confirm").prop('disabled',true);
                    $(".in_create").prop('disabled',true);
                    $(".form_input_disabled").prop('disabled',true);
                    deActiveDatePicker(data.document_date,data.approve_date);
                    deActiveCeditnoteDate(data.date_invoice)
                }else{
                    $(".in_confirm").prop('disabled',false);
                    $(".in_cancel").prop('disabled',false);
                    $(".form_input_disabled").prop('disabled',false);
                    reActiveDatePicker(data.document_date,data.approve_date);
                    reActiveCeditnoteDate(data.date_invoice)
                }
                $("#ceditnote_id").val(data.invoice_headers_id);
                $("#ceditnote_number").val(data.invoice_headers_number);
                $("#ceditnote_status").val(data.invoice_status);
                $("#customer_number").val(data.customer_number).trigger('change');
                $("#price_amount").val(numberFormat(data.invoice_amount));
                $("#price_amount_data").val(data.invoice_amount);
                $("#number_order").val(data.document_number);
                $("#channelreceiving_list").val(data.channel_receiving_code).trigger('change');
                // $("#date_at").val(data.document_date);
                // $("#approve_date").val(data.approve_date);
                $("#approve_document").val(data.approve_document);
                // $("#ceditnote_date_show").val(data.date_invoice);
                $("#ceditnote_date").val(data.date_invoice);
                $(".term_radio").prop('checked',false);
                if(data.term_data == '0'){
                    $("#term_0").prop('checked',true);
                }else if(data.term_data == '7'){
                    $("#term_7").prop('checked',true);
                }else if(data.term_data == '28'){
                    $("#term_28").prop('checked',true);
                }

                if(data.acc_code){
                    $("#accountmapping_debit").val(data.acc_code).trigger('change');
                }else{
                    if(data.dr_segment1){
                        var combi_segment = data.dr_segment1+'.'+data.dr_segment2+'.'+data.dr_segment3+'.'+data.dr_segment4+'.'+data.dr_segment5+'.'+data.dr_segment6;
                        combi_segment += '.'+data.dr_segment7+'.'+data.dr_segment8+'.'+data.dr_segment9+'.'+data.dr_segment10+'.'+data.dr_segment11+'.'+data.dr_segment12;
                        $("#accountmapping_debit").val(combi_segment).trigger('change');
                    }
                }

                $("#company_code").val(data.dr_segment1).trigger('change');
                $("#evm").val(data.dr_segment2).trigger('change');
                $("#department_code").val(data.dr_segment3).trigger('change');
                $("#budget_year").val(data.dr_segment5).trigger('change');
                $("#budget_type").val(data.dr_segment6).trigger('change');
                $("#budget_reason").val(data.dr_segment8).trigger('change');
                $("#main_account").val(data.dr_segment9).trigger('change');
                $("#reserved1").val(data.dr_segment11).trigger('change');
                $("#reserved2").val(data.dr_segment12).trigger('change');

                //-------------------------------------------------------------
                if(data.cr_account_code){
                    $("#accountmapping_cedit").val(data.accr_code).trigger('change');
                }else{
                    if(data.cr_segment1){
                        var combi_segment = data.cr_segment1+'.'+data.cr_segment2+'.'+data.cr_segment3+'.'+data.cr_segment4+'.'+data.cr_segment5+'.'+data.cr_segment6;
                        combi_segment += '.'+data.cr_segment7+'.'+data.cr_segment8+'.'+data.cr_segment9+'.'+data.cr_segment10+'.'+data.cr_segment11+'.'+data.cr_segment12;
                        $("#accountmapping_cedit").val(combi_segment).trigger('change');
                    }
                }

                $("#cr_company_code").val(data.cr_segment1).trigger('change');
                $("#cr_evm").val(data.cr_segment2).trigger('change');
                $("#cr_department_code").val(data.cr_segment3).trigger('change');
                $("#cr_cost_center").val(data.cr_segment4).trigger('change');
                $("#cr_budget_year").val(data.cr_segment5).trigger('change');
                $("#cr_budget_type").val(data.cr_segment6).trigger('change');
                $("#cr_budget_detail").val(data.cr_segment7).trigger('change');
                $("#cr_budget_reason").val(data.cr_segment8).trigger('change');
                $("#cr_main_account").val(data.cr_segment9).trigger('change');
                $("#cr_sub_account").val(data.cr_segment10).trigger('change');
                $("#cr_reserved1").val(data.cr_segment11).trigger('change');
                $("#cr_reserved2").val(data.cr_segment12).trigger('change');

                // $("input[name=type_payment]").val(data.account_debit_type_code);
            }
        });
    }

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }

    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        // get input value
        var input_val = $("#"+input).val();
        // don't validate empty input
        if (input_val === "") { return; }
        // original length
        var original_len = input_val.length;
        // initial caret position
        var caret_pos = $("#"+input).prop("selectionStart");
        // check for decimal
        if (input_val.indexOf(".") >= 0) {
            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");
            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            // add commas to left side of number
            left_side = formatNumber(left_side);
            // validate right side
            right_side = formatNumber(right_side);
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);
            // join number by .
            input_val = "" + left_side + "." + right_side;
        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = "" + input_val;
            // final formatting
            if (blur === "blur") {
            input_val += ".00";
            }
        }
        // send updated string to input
        $("#"+input).val(input_val);
        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        $("#"+input)[0].setSelectionRange(caret_pos, caret_pos);
    }

    function numberFormat(number)
    {
        number  = parseFloat(number).toFixed(2);
        number  += '';
        x       = number.split('.');
        x1      = x[0];
        x2      = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function popCancelInvoice()
    {
        Swal.fire({
            title:  'แจ้งเตือน',
            html:   'ต้องการยกเลิก ใบลดหนี้ ใช่หรือไม่',// add html attribute if you want or remove
            focusConfirm: false,
            showCancelButton: true,
            preConfirm: () => {
                cancel_invoice();
            }
        });
    }

    function cancel_invoice()
    {
        var cedirnote_invoice_id = $("#cedirnote_invoice_id").val();
        loading();
        $.ajax({
           url : '{{ url("om/ajax/credit-note-other/cancel_invoice") }}',
           type : 'post',
           data : {
                '_token'    : '{{ csrf_token() }}',
                cedirnote_invoice_id : cedirnote_invoice_id
           },
           success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    // window.location.reload();
                    AlertToast('สำเร็จ','ยกเลิกสำเร็จ','success');
                    $('#close-btn-contact').hide();
                    searchInvoice();
                }else{
                    AlertToast('แจ้งเตือน','มีบางอย่างผิดผลาดกรุณาลองอีกครั้ง','error');
                }
           }
        });
    }

    function printErrorMsgContact (msg) {
            $(".print-error-msg-creditnote").find("ul").html('');
            $(".print-error-msg-creditnote").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-creditnote").find("ul").append('<li>'+value+'</li>');
            });
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

    function btnClearForm()
    {
        window.location.reload();
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

    function reActiveDatePicker(value_date,value_date2)
    {
        var vue = new Vue({
            data(){
                return {
                    value  : value_date
                }
            },
            template:`
                <datepicker-th
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data date_at"
                    name="date_at"
                    id="date_at"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".date_at");

        var vue2 = new Vue({
            data(){
                return {
                    value  : value_date2
                }
            },
            template:`
                <datepicker-th
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data approve_date"
                    name="approve_date"
                    id="approve_date"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".approve_date");
    }

    function deActiveDatePicker(value_date,value_date2)
    {
        var vue = new Vue({
            data(){
                return {
                    value  : value_date
                }
            },
            template:`
                <datepicker-th
                    :disabled="true"
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data date_at"
                    name="date_at"
                    id="date_at"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".date_at");

        var vue2 = new Vue({
            data(){
                return {
                    value  : value_date2
                }
            },
            template:`
                <datepicker-th
                    :disabled="true"
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data approve_date"
                    name="approve_date"
                    id="approve_date"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".approve_date");
    }

    function reActiveCeditnoteDate(value)
    {
        var vue = new Vue({
            data(){
                return {
                    value  : value
                }
            },
            template:`
                <datepicker-th
                    style="width: 100%"
                    @change="handleChangeCreditnote"
                    @dateWasSelected="handleChangeCreditnote"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data"
                    name="ceditnote_date_show"
                    id="ceditnote_date_show"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
                handleChangeCreditnote(e) {
                    var day = String(e.getDate()).padStart(2, '0');
                    var month = String(e.getMonth() + 1).padStart(2, '0');
                    var yearBE = e.getFullYear(); 

                    var thaiDateString = `${day}/${month}/${yearBE}`;
                    $("#ceditnote_date").val(thaiDateString)
                }
            }
        }).$mount(".ceditnote_date_show");
    }

    function deActiveCeditnoteDate(value)
    {
        var vue = new Vue({
            data(){
                return {
                    value  : value
                }
            },
            template:`
                <datepicker-th
                    :disabled="true"
                    style="width: 100%"
                    @change="handleChangeCreditnote"
                    @dateWasSelected="handleChangeCreditnote"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data"
                    name="ceditnote_date_show"
                    id="ceditnote_date_show"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            },
            methods: {
                handleChangeCreditnote(e) {
                    var day = String(e.getDate()).padStart(2, '0');
                    var month = String(e.getMonth() + 1).padStart(2, '0');
                    var yearBE = e.getFullYear(); 

                    var thaiDateString = `${day}/${month}/${yearBE}`;
                    $("#ceditnote_date").val(thaiDateString)
                }
            },
        }).$mount(".ceditnote_date_show");
    }

</script>
@include('om.creditnote._script_credit_other')
@stop
