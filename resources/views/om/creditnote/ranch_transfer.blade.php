@extends('layouts.app')

@section('title', 'OMP0034 : Credit Note เงินโอนไร่')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

    <style>
        /* .disabled {
            pointer-events: none;
            cursor: default;
            background: rgb(194, 194, 194);
        } */

        a .disabled {
            background-color: #e9ecef !important;
            opacity: 1 !important;
            pointer-events: none;
            cursor: default;
           
        }

        .form-control[disabled] {
            background-color: #f5f7fa;
            border-color: #e4e7ed;
            color: #000000 !important; 
            opacity: 1;
        }

        select.form-control:not([size]):not([multiple]){
            height: auto;
            margin-bottom: 5px;
        }

    </style>
@stop

@section('page-title')
    <h2>OMP0034 : Credit Note เงินโอนไร่</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>OMP0034 : Credit Note เงินโอนไร่</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>OMP0034 : Credit Note เงินโอนไร่</h3>
    </div>
    <form id="form_data">
    <div class="ibox-content">
        <div class="row space-50 justify-content-md-center flex-column mt-md-4">
            <div class="col-12">
                <div class="form-header-buttons">
                    <div class="d-flex">
                        <button class="btn btn-white" onclick="btnClearForm();"><i class="fa fa-repeat"></i></button>
                    </div>
                    <div class="buttons multiple">
                        <button class="btn btn-md btn-primary in_create" type="button" onclick="create_invoice();" ><i class="fa fa-plus"></i> สร้าง</button>
                        {{-- <button class="btn btn-md btn-danger in_cancel" disabled type="button" onclick="cancel_invoice();"><i class="fa fa-times"></i> ยกเลิก</button>
                        <button class="btn btn-md btn-primary in_confirm" disabled type="button" onclick="update_invoice();" ><i class="fa fa-save"></i> บันทึก</button> --}}
                        <button class="btn btn-md btn-white"  type="button" onclick="search_invoice();"><i class="fa fa-search"></i> ค้นหา</button>
                        <div class="dropdown">
                            <button class="btn btn-md btn-white m-0" id="command_order" data-toggle="dropdown" disabled type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" class="btn btn-link" id="save_order"    onclick="update_invoice('save');">บันทึก </button> </li>
                                <li><button type="button" class="btn btn-link" id="confirm_order" onclick="update_invoice('confirm');">ยืนยัน </button></li>
                                <li><button type="button" class="btn btn-link" id="cancel_order"  onclick="cancel_invoice();">ยกเลิก </button></li>
                            </ul>
                        </div>
                    </div>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>
            </div><!--col-12-->

            
            <div class="col-xl-12 m-auto">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">เลขที่ใบลดหนี้ </label>
                            <div class="input-icon">
                                <input type="text" list="ceditnote_number_list" autocomplete="off" class="form-control" id="ceditnote_number_show" name="ceditnote_number_show" placeholder="" value="">
                                <datalist id="ceditnote_number_list">
                                    {{-- <option value=""></option>
                                    @foreach ($list as $item_list)
                                        <option value="{{ $item_list->invoice_headers_number }}">{{ $item_list->invoice_headers_number }}</option>
                                    @endforeach --}}
                                </datalist>
                                {{-- <select id="ceditnote_number_show" name="ceditnote_number_show" autocomplete="off" class="custom-select select2">

                                </select> --}}
                                {{-- <input type="text" class="form-control form_input_disabled" id="ceditnote_number_show" name="ceditnote_number_show" placeholder="" value=""> --}}
                                <input type="hidden" id="ceditnote_number" name="ceditnote_number">
                                <input type="hidden" id="cedirnote_invoice_id" name="cedirnote_invoice_id">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">วันที่ <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                {{-- <input type="text" class="form-control form_input_disabled" id="ceditnote_date_show" name="ceditnote_date_show" placeholder="" disabled value=""> --}}
                                <input type="hidden" id="ceditnote_date" name="ceditnote_date">
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
                                <i class="fa fa-calendar"></i>
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
                            <label class="d-block">รหัสลูกค้า <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        {{-- <select name="customer_number" id="customer_list" class="custom-select select2 form_input_disabled" onchange="searchcustomer(this.value)" >

                                        </select> --}}
                                        <input type="text" list="customer_list" class="form-control form_input_disabled" autocomplete="off" id="customer_number" disabled  name="customer_number" onchange="searchcustomer(this.value);getCraditNoteList(this.value);" onkeyup="searchcustomer(this.value);getCraditNoteList(this.value);">
                                        {{-- <i class="fa fa-search" onclick="searchcustomer();"></i> --}}
                                        <datalist id="customer_list">

                                        </datalist>

                                        {{-- <select name="customer_number" id="customer_number" class="custom-select select2" onchange="searchcustomer(this.value);getCraditNoteList(this.value);" >

                                        </select> --}}
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
                            <label class="d-block">จำนวนเงิน</label>
                            <input type="text" class="form-control blue text-right" disabled  onblur="formatCurrency('price_amount_show','blur');" onkeyup="formatCurrency('price_amount_show');" id="price_amount_show" name="price_amount_show" placeholder="" value="0.00">
                            <input type="hidden" id="price_amount" name="price_amount" placeholder="" >
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

                    <div class="col-xl-8">
                        <div class="form-group">
                            <label class="d-block">ชำระผ่านสำนักงานยาสูบ <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <select name="clubassocia_list" id="clubassocia_list" disabled class="custom-select select2 form_input_disabled" onchange="sel_clubassocia(this.value)" >

                                        </select>
                                        <input type="hidden" id="clubassocia_id" name="clubassocia_id"  value="">
                                    </div>
                                </div>
                                <div class="col-md-8 mt-2 mt-md-0">
                                    <input type="text" class="form-control" disabled id="clubassociation_name" name="clubassociation_name" placeholder="" value="">
                                </div>
                            </div><!--row-->
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="d-block">เดบิต บัญชี <span class="text-danger">*</span></label>
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
                            <label class="d-block">เครดิต บัญชี <span class="text-danger">*</span></label>
                            <div class="row space-5">
                                <div class="col-4">
                                    <div class="input-icon">
                                        {{-- <select class="custom-select select2 form_input_disabled" disabled name="accountmapping_cedit" id="accountmapping_cedit" onchange="chageAccountMapcredit()" >
                                            <option value=""></option>
                                            @foreach ($account_mapping as $item_acmap)
                                                <option value="{{ $item_acmap['account_combine'] }}" data-value="{{ $item_acmap['account_code'] }}" data-des="{{ $item_acmap['account_description'] }}" data-comdes="{{ $item_acmap['combine_desc'] }}" >{{ $item_acmap['account_description'] }}</option>
                                            @endforeach
                                        </select> --}}
                                        <input type="text" list="acccedit" class="form-control form_input_disabled" autocomplete="off" disabled name="accountmapping_cedit" id="accountmapping_cedit" onkeyup="chageAccountMapcredit()" onchange="chageAccountMapcredit()" placeholder="" value="">
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
                                    <input type="text" class="form-control" disabled id="accountmapping_ceditname" name="accountmapping_ceditname" placeholder="" value="">
                                    <input type="hidden" class="form-control" id="input_mapping_ceditname" name="input_mapping_ceditname" placeholder="" value="">
                                </div>
                            </div><!--row-->
                            <small class="text-danger" id="cr_deccombi"></small>
                            @include('om.creditnote._form_credit')
                        </div>
                    </div><!--col-->


                    <div class="col-md-12"></div>

                    <!--//-->

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">เลขที่</label>
                            <input type="text" class="form-control form_input_disabled" autocomplete="off" disabled id="invoice_on" name="invoice_on" placeholder="" value="">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">ทาง</label>
                            <select class="custom-select select2 form_input_disabled" disabled name="invoice_channel" id="channelreceiving_list" >

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">ลงวันที่</label>
                            <div class="input-icon">
                                <datepicker-th
                                    style="width: 100%"
                                    :disabled="true"
                                    class="form-control md:tw-mb-0 tw-mb-2 form_input_disabled date_at"
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

                    <div class="col-md-12"></div>
                    <!--//-->

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">เลขที่ใบเสร็จรับเงิน</label>
                            <input type="text" class="form-control form_input_disabled" autocomplete="off" disabled id="invoice_number"  name="invoice_number" placeholder="" value="">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">วันที่ใบเสร็จรับเงิน</label>
                            <div class="input-icon">
                                <datepicker-th
                                    style="width: 100%"
                                    :disabled="true"
                                    class="form-control md:tw-mb-0 tw-mb-2 form_input_disabled invoice_date"
                                    name="invoice_date"
                                    id="invoice_date"
                                    placeholder="โปรดเลือกวันที่"
                                    value=""
                                    format="DD/MM/YYYY"
                                    >
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12"></div>




                    {{-- <div class="col-md-12">
                        <div class="form-group">
                            <label class="d-block">ประเภทการรับเงิน <span class="text-danger">*</span></label>
                            <div class="d-md-flex">
                                <div class="mr-3 mt-2"><label>  <input type="radio" class="term_radio" value="28" id="term_28"  name="type_payment"><span>เงินเชื่อ 28 วัน</span></label></div>
                                <div class="mr-3 mt-2"><label>  <input type="radio" class="term_radio" value="7" id="term_7"  name="type_payment"><span>เงินเชื่อ 7 วัน</span></label></div>
                                <div class="mt-2"><label>       <input type="radio" class="term_radio" value="0" id="term_0"  checked name="type_payment"><span>เงินสด</span></label></div>
                            </div>
                        </div>
                    </div> --}}

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

            <div class="col-xl-12 m-auto">
                <div class="table-responsive">
                    <table class="table table-bordered text-center table-hover min-1200 f13">
                        <thead>
                            <tr class="align-middle">
                                <th>งวด</th>
                                <th class="w-201">เลขที่เอกสาร</th>
                                <th class="w-201">จำนวนเงิน</th>
                                <th>วันที่ขน</th>
                                <th>วันที่ครบกำหนด</th>
                                <th>กลุ่มวงเงิน</th>
                                <th>จำนวนวัน</th>
                                <th>ค่าปรับ</th>
                                <th class="w-201">จำนวนเงินที่ชำระ</th>
                                <th class="w-60">ตัด</th>
                            </tr>
                        </thead>
                        <tbody id="data_list">

                        </tbody>
                    </table>
                </div><!--table-responsive-->
            </div><!--col-xl-12-->
        </div><!--row-->
    </div><!--ibox-content-->
</form>
</div><!--ibox-->
@endsection

@section('scripts')
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>

<script>
    var customer_list_arr           = [];
    var clubassocia_list_arr        = [];
    var channelreceiving_list_arr   = [];
    var accountmapping_list_arr     = [];
    var status                      = '';
    var chk_amount                  = 0;
    $(".select2").select2();
    $(".select2-tags").select2({
        tags: true
    });

    customer_list();
    getCraditNoteList('');
    clubassocia_list();
    channelreceiving_list();
    accountmapping_list();

    function customer_list()
    {
        var customer = $("#customer_number").val();
        $.ajax({
            url : '{{ url("om/ajax/creditnote_ranchtran/customer_list") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
                customer : customer
            },
            success:function(rest){
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

    function getCraditNoteList(customer)
    {
        if(customer != ''){
            var customer_id = customer_list_arr[customer].id
        }else{
            var customer_id = '';
        }

        $.ajax({
            url : '{{ url("om/ajax/creditnote_ranchtran/getcreditnote") }}',
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
            consignment_list(customer_list_arr[code].id);
        }else{
            $("#customer_provice").val('');
            $("#customer_name").val('');
        }
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
        console.log(val);
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

    function search_invoice()
    {
        var number = $("#ceditnote_number_show").val();
        if(number == ''){
            return false;
        }
        loading();
        $.ajax({
            url     : '{{ url("om/ajax/creditnote_ranchtran/search_invoice") }}',
            type    : 'post',
            data    : {
                '_token'    : '{{ csrf_token() }}',
                number      : number,
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                status = data.invoice_status;
                if(data.invoice_status == 'Cancelled' || data.invoice_status == 'Cancel'){
                    $("#confirm_order").prop('disabled',true);
                    $("#save_order").prop('disabled',true);
                    $("#cancel_order").prop('disabled',false);
                    $(".in_create").prop('disabled',true);
                    $("#command_order").prop('disabled',false);
                    $(".form_input_disabled").prop('disabled',true);
                    deActiveDatePicker(data.document_date,data.receipt_ref_date);
                    deActiveCeditnoteDate(data.date_invoice)
                }else if(data.invoice_status == 'Draft'){
                    // $(".in_cancel").prop('disabled',false);
                    $("#confirm_order").prop('disabled',false);
                    $("#save_order").prop('disabled',false);
                    $("#cancel_order").prop('disabled',false);
                    $(".in_create").prop('disabled',true);
                    $("#command_order").prop('disabled',false);
                    $(".form_input_disabled").prop('disabled',false);
                    reActiveDatePicker(data.document_date,data.receipt_ref_date);
                    reActiveCeditnoteDate(data.date_invoice)
                }else if(data.invoice_status == 'Confirm'){
                    // $(".in_cancel").prop('disabled',false);
                    // $(".in_confirm").prop('disabled',true);
                    $("#confirm_order").prop('disabled',true);
                    $("#save_order").prop('disabled',true);
                    $("#cancel_order").prop('disabled',false);
                    $(".in_create").prop('disabled',true);
                    $("#command_order").prop('disabled',false);
                    $(".form_input_disabled").prop('disabled',true);
                    deActiveDatePicker(data.document_date,data.receipt_ref_date);
                    deActiveCeditnoteDate(data.date_invoice)
                }else{
                    $(".in_create").prop('disabled',true);
                    $("#confirm_order").prop('disabled',false);
                    $("#save_order").prop('disabled',false);
                    $("#cancel_order").prop('disabled',false);
                    // $(".in_confirm").prop('disabled',false);
                    // $(".in_cancel").prop('disabled',false);
                    $("#command_order").prop('disabled',false);
                    reActiveDatePicker(data.document_date,data.receipt_ref_date);
                    reActiveCeditnoteDate(data.date_invoice)
                }
                $("#cedirnote_invoice_id").val(data.invoice_headers_id);
                $("#ceditnote_status").val(data.invoice_status);
                $("#ceditnote_date_show").val(data.receipt_ref_date);
                $("#customer_number").val(data.customer_number).trigger('change');
                // consignment_list(data.customer_id);
                chk_amount = data.invoice_amount;
                $("#price_amount_show").val(numberFormat(data.invoice_amount));
                $("#price_amount").val(data.invoice_amount);
                $("#clubassocia_list").val(data.company_code).trigger('change');
                sel_clubassocia(data.company_code);
                $("#invoice_on").val(data.document_number);
                $("#channelreceiving_list").val(data.channel_receiving_code).trigger('change');
                // $("#date_at").val(data.document_date);
                // $("#invoice_date").val(data.receipt_ref_date);
                $("#invoice_number").val(data.receipt_ref_num);
                // $("#ceditnote_date_show").val(data.date_invoice);
                $("#ceditnote_number_show").prop('disabled',true);
                $("#ceditnote_date").val(data.date_invoice);
                if(data.accd_code){
                    $("#accountmapping_debit").val(data.accd_code).trigger('change');
                }else{
                    var combi_segment = data.dr_segment1+'.'+data.dr_segment2+'.'+data.dr_segment3+'.'+data.dr_segment4+'.'+data.dr_segment5+'.'+data.dr_segment6;
                    combi_segment += '.'+data.dr_segment7+'.'+data.dr_segment8+'.'+data.dr_segment9+'.'+data.dr_segment10+'.'+data.dr_segment11+'.'+data.dr_segment12;
                    $("#accountmapping_debit").val(combi_segment).trigger('change');
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
                if(data.accr_code){
                    $("#accountmapping_cedit").val(data.accr_code).trigger('change');
                }else{
                    var combi_segment = data.cr_segment1+'.'+data.cr_segment2+'.'+data.cr_segment3+'.'+data.cr_segment4+'.'+data.cr_segment5+'.'+data.cr_segment6;
                    combi_segment += '.'+data.cr_segment7+'.'+data.cr_segment8+'.'+data.cr_segment9+'.'+data.cr_segment10+'.'+data.cr_segment11+'.'+data.cr_segment12;
                    $("#accountmapping_cedit").val(combi_segment).trigger('change');
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

                $(".term_radio").prop('checked',false);
                if(data.term_data == '0'){
                    $("#term_0").prop('checked',true);
                }else if(data.term_data == '7'){
                    $("#term_7").prop('checked',true);
                }else if(data.term_data == '28'){
                    $("#term_28").prop('checked',true);
                }
            }
        });
    }

    function consignment_list(id)
    {
        var invoice_id = $("#cedirnote_invoice_id").val();
        loading();
        $.ajax({
            url : '{{ url("om/ajax/creditnote_ranchtran/consignment_list") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
                customer_id : id,
                invoice_id  : invoice_id
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                var html = '';

                if(status == 'Confirm' || status == 'Cancelled' || status == 'Cancel'){
                    var dis_input   = 'disabled';
                }else{
                    var dis_input   = '';
                }

                $.each(data.data,function(key_m,val_m){
                    $.each(val_m,function(key,val){
                        if(val.amount > 0){
                        html += '<tr class="align-middle">';
                        html += '    <td>'+val.prerot+'</td>';
                        html += '    <td>'+val.number+' <input type="hidden" id="pick_consing_'+val.id+'" name="pick_consing['+val.id+']" value="'+val.number+'" ></td>';
                        html += '    <td class="text-right">'+numberFormat(val.amount);
                        html += '    <input type="hidden" id="amount_total_'+val.id+'" value="'+val.amount+'" > ';
                        html += '    <input type="hidden" id="product_type_'+val.id+'" name="product_type['+val.id+']" value="'+val.product_type+'" > ';
                        html += '    <input type="hidden" id="group_'+val.id+'" name="groupcode['+val.id+']" value="'+val.group_code+'" > </td>';
                        html += '    <td>'+val.order_date+'</td>';
                        html += '    <td>'+val.final_date+'</td>';
                        html += '    <td>'+val.pay_group+'</td>';
                        html += '    <td>'+val.day_total+'</td>';
                        html += '    <td>'+val.payover+'</td>';
                        html += '    <td class="text-right"> ';
                        html += '         <input type="text" class="form-control text-right" id="amount_line_'+val.id+'" onblur="formatCurrency('+"'amount_line_"+val.id+"'"+','+"'blur'"+');" onkeyup="formatCurrency('+"'amount_line_"+val.id+"'"+');chage_amount();checkAmountOver('+val.id+');" '+dis_input+' name="amount_pay['+val.id+']" placeholder="" value="'+numberFormat(val.amount_pay)+'">';
                        html += '    </td>';
                        html += '    <td>';
                            if(val.check == 'Yes'){
                                html += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" '+dis_input+' onclick="checkAmount('+val.id+');" checked value="'+val.id+'" name="key['+val.id+']"></label></div>';
                            }else{
                                html += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" '+dis_input+' onclick="checkAmount('+val.id+');" value="'+val.id+'" name="key['+val.id+']"></label></div>';
                            }
                        html += '        <input type="hidden" name="delivery_date['+val.id+']" value="'+val.delivery_date+'" >'
                        html += '        <input type="hidden" name="invoice_line['+val.id+']" value="'+val.line_id+'" >'
                        html += '    </td>';
                        html += '</tr>';
                        }
                    });
                });

                html += '<tr class="align-middle">';
                html +=     '<td colspan="2" class="text-right"><strong class="black">รวมเงินเชื่อและสด</strong></td>';
                html +=     '<td>';
                html +=         '<input type="text" class="form-control text-right black" disabled="" name="" placeholder="" value="'+numberFormat(Math.abs(data.total))+'">';
                html +=     '</td>';
                html +=     '<td class="text-right" colspan="5"><strong class="black">จำนวนเงินที่ขำระ</strong></td>';
                html +=     '<td>';
                html +=        '<input type="text" class="form-control text-right blue" disabled="" id="total_payamount" name="" placeholder="" value="'+numberFormat(chk_amount)+'">';
                html +=     '</td>';
                html += '</tr>';

                $("#data_list").html(html);
            }
        });
    }

    function checkAmountOver(index)
    {
        var total = $("#amount_total_"+index).val();
        total = parseFloat(total);
        var val   = $("#amount_line_"+index).val().toString().replace(/,/g, '');
        val = parseFloat(val);
        if(val > total){
            $("#amount_line_"+index).val(numberFormat(total));
        }
    }

    function chage_amount()
    {
        // var new_amount = 0;
        // $.each($("input[name^=amount_pay]"),function(key,value){
        //     var value  = $(value).val().toString().replace(/,/g, '');
        //     new_amount += parseFloat(value);
        // });

        // $("#total_payamount").val(numberFormat(new_amount));

        var new_amount = 0;
        $.each($("input[name^=key]"),function(key,value){
            if($(value).prop('checked')){
                var id = $(value).val();
                var value = $("input[name='amount_pay["+id+"]']").val().toString().replace(/,/g, '');
                new_amount += parseFloat(value);
            }
        });

        $("#total_payamount").val(numberFormat(new_amount));
        $("#price_amount").val(new_amount);
        $("#price_amount_show").val(numberFormat(new_amount));

    }

    function checkAmount()
    {
        var new_amount = 0;
        $.each($("input[name^=key]"),function(key,value){
            if($(value).prop('checked')){
                var id = $(value).val();
                var value = $("input[name='amount_pay["+id+"]']").val().toString().replace(/,/g, '');
                new_amount += parseFloat(value);
            }
        });

        $("#total_payamount").val(numberFormat(new_amount));
        $("#price_amount").val(new_amount);
        $("#price_amount_show").val(numberFormat(new_amount));

    }

    function clubassocia_list()
    {
        $.ajax({
            url : '{{ url("om/ajax/creditnote_ranchtran/clubassocia_list") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
            },
            success:function(rest){
                var data = rest.data;
                var html = '<option value=""></option>';

                clubassocia_list_arr = data.data;
                $.each(data.data,function(key,val){
                    html += '<option value="'+val.id+'">'+val.name+'</option>';
                });

                $("#clubassocia_list").html(html);
            }
        });
    }

    function sel_clubassocia(code)
    {
        if(clubassocia_list_arr[code]){
            $("#clubassocia_id").val(clubassocia_list_arr[code].id);
            $("#clubassociation_name").val(clubassocia_list_arr[code].name);
        } else{
            $("#clubassocia_id").val('');
            $("#clubassociation_name").val('');
        }
    }

    function channelreceiving_list()
    {
        $.ajax({
            url : '{{ url("om/ajax/creditnote_ranchtran/channelreceiving_list") }}',
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

    function accountmapping_list()
    {
        $.ajax({
            url : '{{ url("om/ajax/creditnote_ranchtran/accountmapping_list") }}',
            type : 'post',
            data : {
                '_token'    : '{{ csrf_token() }}',
            },
            success:function(rest){
                var data = rest.data;
                var html = '<option value=""></option>';

                accountmapping_list_arr = data.data;
                $.each(data.data,function(key,val){
                    html += '<option value="'+val.id+'">'+val.name+'</option>';
                });

                $("#accountmapping_list").html(html);
            }
        });
    }
    function sel_accmapping(code)
    {
        if(accountmapping_list_arr[code]){
            $("#accountmapping_code").val(accountmapping_list_arr[code].code);
            $("#accountmapping_name").val(accountmapping_list_arr[code].name);
        } else{
            $("#accountmapping_code").val('');
            $("#accountmapping_name").val('');
        }
    }

    function create_invoice()
    {
        $("#form_data")[0].reset();
        loading();
        $.ajax({
            url         : '{{ url("om/ajax/creditnote_ranchtran/gencreatenumber") }}',
            type        : 'post',
            data        : {
                '_token' : '{{ csrf_token() }}'
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    $("#ceditnote_number_show").val(data.data.number);
                    $("#ceditnote_number_show").prop('disabled',true);
                    $("#ceditnote_number").val(data.data.number);
                    $(".in_confirm").prop('disabled',false);
                    $(".in_create").prop('disabled',true);
                    $("#ceditnote_date").val(data.data.date);
                    $("#ceditnote_date_show").val(data.data.date);
                    $("#ceditnote_status").val('Draft');
                    $("#command_order").prop('disabled',false);
                    reActiveDatePicker(data.data.date,data.data.date);
                    reActiveCeditnoteDate(data.data.date)
                    $(".form_input_disabled").prop('disabled',false);

                    $("#accountmapping_debit").val("{{ $account_mapping['10']['account_combine'] }}").trigger('change');
                    $("#accountmapping_cedit").val("{{ $account_mapping['13']['account_combine'] }}").trigger('change');

                    $("#reserved1").val('{{ $accont_gl->segment11 }}').trigger('change');
                    $("#reserved2").val('{{ $accont_gl->segment12 }}').trigger('change');
                    $('#cost_center').val('{{ $accont_gl->segment4 }}').trigger('change');
                    $('#budget_detail').val('{{ $accont_gl->segment7 }}').trigger('change');
                    $('#sub_account').val('{{ $accont_gl->segment10 }}').trigger('change');

                    $("#cr_reserved1").val('{{ $accont_cr_gl->segment11 }}').trigger('change');
                    $("#cr_reserved2").val('{{ $accont_cr_gl->segment12 }}').trigger('change');
                    $('#cr_cost_center').val('{{ $accont_cr_gl->segment4 }}').trigger('change');
                    $('#cr_budget_detail').val('{{ $accont_cr_gl->segment7 }}').trigger('change');
                    $('#cr_sub_account').val('{{ $accont_cr_gl->segment10 }}').trigger('change');
                }else{
                    AlertToast('แจ้งเตือน','มีบางอย่างผิดพลาดกรุณาลองอีกครั้ง','error');

                }
            }
        });
    }

    function update_invoice(type = 'save')
    {
        $('#ceditnote_date').val($('#ceditnote_date_show').val())
        
        const formdata = new FormData(document.getElementById("form_data"));
        formdata.append('_token','{{ csrf_token() }}');
        formdata.append('type_save',type);
        loading();
        $.ajax({
            url         : '{{ url("om/ajax/creditnote_ranchtran/edit_invoice") }}',
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
                    search_invoice();
                    // $("#form_data")[0].reset();
                    // window.location.reload();
                    AlertToast('สำเร็จ','เพิ่มแล้ว','success');
                    $('#close-btn-contact').hide();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgContact(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','มีบางอย่างผิดพลาดกรุณาลองอีกครั้ง','error');

                    }
                }
            }
        });
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
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data"
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
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data"
                    name="invoice_date"
                    id="invoice_date"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".invoice_date");
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
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data"
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
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data"
                    name="invoice_date"
                    id="invoice_date"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".invoice_date");
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
            }
        }).$mount(".ceditnote_date_show");
    }

    function cancel_invoice()
    {
        var cedirnote_invoice_id = $("#cedirnote_invoice_id").val();
        loading();
        $.ajax({
           url : '{{ url("om/ajax/creditnote_ranchtran/cancel_invoice") }}',
           type : 'post',
           data : {
                '_token'    : '{{ csrf_token() }}',
                cedirnote_invoice_id : cedirnote_invoice_id
           },
           success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    search_invoice();
                    // window.location.reload();
                    AlertToast('สำเร็จ','ยกเลิกแล้ว','success');
                    $('#close-btn-contact').hide();
                }else{
                    AlertToast('แจ้งเตือน','มีบางอย่างผิดพลาดกรุณาลองอีกครั้ง','error');

                }
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


    // function printErrorMsgContact (msg) {
    //     $(".print-error-msg-creditnote").find("ul").html('');
    //     $(".print-error-msg-creditnote").css('display','block');
    //     $.each( msg, function( key, value ) {
    //         $(".print-error-msg-creditnote").find("ul").append('<li>'+value+'</li>');
    //     });
    // }

    function printErrorMsgContact (msg) {
        var ahtml = '';
        $.each( msg, function( key, value ) {
            ahtml += '<li>'+value+'</li>';
        });

        Swal.fire({
            title: 'Warning',
            html: ahtml,// add html attribute if you want or remove
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: true,
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

    function btnClearForm()
    {
        window.location.reload();
    }

</script>

@include('om.creditnote._script_credit')
@stop
