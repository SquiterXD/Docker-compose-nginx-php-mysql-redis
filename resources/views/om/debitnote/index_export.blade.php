@extends('layouts.app')

@section('title', 'OMP0076 : Debit Note สำหรับขายต่างประเทศ')

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
    <h2>OMP0076 : Debit Note สำหรับขายต่างประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>OMP0076 : Debit Note สำหรับขายต่างประเทศ</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>OMP0076 : Debit Note สำหรับขายต่างประเทศ</h3>
    </div>
    <div class="ibox-content">
        <div class="row space-50 justify-content-md-center flex-column mt-md-4">
            <div class="col-12">
                <div class="form-header-buttons">
                    <div class="d-flex">
                        <a class="btn btn-white" href="{{ url('/') }}/om/debit-note-export"><i class="fa fa-repeat"></i></a>
                    </div>
                    <div class="buttons multiple">
                        <button class="btn btn-md btn-success in_create" type="button" onclick="create_invoice();" ><i class="fa fa-plus"></i> สร้าง</button>
                        <button class="btn btn-md btn-danger in_cancel" disabled type="button" onclick="popCancelInvoice();"><i class="fa fa-times"></i> ยกเลิก</button>
                        <button class="btn btn-md btn-primary in_confirm" disabled type="button" onclick="update_invoice();" ><i class="fa fa-save"></i> บันทึก</button>
                        <button class="btn btn-md btn-white"  type="button" onclick="search_invoice();"><i class="fa fa-search"></i> ค้นหา</button>
                        <button class="btn btn-md btn-info" type="button" id="print_order" disabled onclick="PrintReport();"><i class="fa fa-print"></i> พิมพ์ใบเพิ่มหนี้</button>
                    </div>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>
            </div><!--col-12-->

            <form id="form_data">
                <div class="col-xl-12 m-auto">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">เลขที่ใบเพิ่มหนี้</label>
                                <div class="input-icon">
                                    <input type="text" list="debitnote_list" class="form-control" autocomplete="off" id="debitnote_number" name="debitnote_number" placeholder="" value="">
                                    <datalist id="debitnote_list">

                                    </datalist>
                                    {{-- <input type="text" list="debitnote_list" class="form-control" autocomplete="off"  id="debitnote_number" name="debitnote_number" placeholder="" value="">
                                    <datalist id="debitnote_list">
                                        <option value=""></option>
                                        @foreach ($list as $item_list)
                                            <option value="{{ $item_list->invoice_headers_number }}">{{ $item_list->invoice_headers_number }}</option>
                                        @endforeach
                                    </datalist> --}}
                                    <input type="hidden" id="debitnote_number_input" name="debitnote_number_input">
                                    <input type="hidden" id="invoice_id" name="invoice_id">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">วันที่</label>
                                <div class="input-icon">
                                    {{-- <input type="text" class="form-control" id="debitnote_date_show" name="debitnote_date_show" placeholder="" disabled value=""> --}}
                                    <input type="hidden" id="debitnote_date" name="debitnote_date">
                                    <datepicker-th
                                    style="width: 100%"
                                    :disabled="true"
                                    class="form-control md:tw-mb-0 tw-mb-2 form_input_disabled debitnote_date_show"
                                    name="debitnote_date_show"
                                    id="debitnote_date_show"
                                    placeholder="โปรดเลือกวันที่"
                                    value=""
                                    format="DD/MM/YYYY"
                                    >
                                    {{-- <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="debitnote_date"
                                        id="debitnote_date"
                                        placeholder="โปรดเลือกวันที่"
                                        format="DD/MM/YYYY"
                                        > --}}
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">Status</label>
                                <input type="text" class="form-control" disabled id="debitnote_status" name="debitnote_status" placeholder="" value="">
                                <input type="hidden" id="debitnote_status_data" name="debitnote_status_data">
                                <input type="hidden" id="save_type" name="save_type" value="Draft">
                            </div>
                        </div>

                        <!--//-->
                        <div class="col-xl-8">
                            <div class="form-group">
                                <label class="d-block">รหัสลูกค้า</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-icon">
                                            {{-- <select name="customer_number" id="customer_list" class="custom-select select2" onchange="searchcustomer(this.value);getOrderList(this.value);" >

                                            </select> --}}
                                            <input type="text" list="customer_list"  autocomplete="off" class="form-control form_input_disable" id="customer_number"  name="customer_number" onchange="searchcustomer(this.value);getDebitNoteList(this.value);getOrderList(this.value);" onkeyup="searchcustomer(this.value);getDebitNoteList(this.value);getOrderList(this.value);">
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
                                <label class="d-block">จำนวนเงิน</label>
                                <input type="text" class="form-control blue text-right form_input_disable" onblur="formatCurrency('amount','blur');" onkeyup="formatCurrency('amount');" id="amount" disabled name="amount" placeholder="" value="">
                            </div>
                        </div>

                        <!--//-->

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="d-block">ประเทศ</label>
                                <select class="custom-select" disabled id="county" name="county" onchange="changeCountry();">
                                    <option value="" data-value="" ></option>
                                    @foreach ($county as $county_item)
                                        <option value="{{ $county_item->country_code }}" data-value="{{ $county_item->country_name }}" >{{ $county_item->country_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="county_code" name="county_code" >
                                <input type="hidden" id="county_name" name="county_name" >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">สกุลเงิน</label>
                                <div class="row space-5">
                                    <div class="col-md-4">
                                        <div class="input-icon">
                                            <select class="custom-select" disabled id="currency" name="currency" onchange="changeCurrency();">
                                                <option value="" data-value="" ></option>
                                                @foreach ($currency as $currency_item)
                                                    <option value="{{ $currency_item->currency_code }}" data-value="{{ $currency_item->description }}" >{{ $currency_item->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mt-2 mt-md-0">
                                        <input type="text" class="form-control" disabled id="currency_name" name="currency_name" placeholder="" value="">
                                        <input type="hidden" id="currency_code" name="currency_code" placeholder="" value="">
                                    </div>
                                </div><!--row-->
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        <!--//-->

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">อ้างอิงใบกำกับสินค้าเลขที่</label>
                                <div class="input-icon">
                                    <select class="custom-select select2 form_input_disable" disabled name="order_number" id="order_number" onchange="searchOrder(this.value);" >
                                    </select>
                                    <input type="hidden" id="order_number_data" name="order_number_data">
                                    {{-- <i class="fa fa-search" onclick="searchOrder();"></i> --}}
                                    <input type="hidden" id="order_id" name="order_id">
                                    <input type="hidden" id="cus_type">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">ลงวันที่</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" disabled id="document_date" name="document_date" placeholder="" value="">
                                    <input type="hidden" id="document_date_data" name="document_date_data">
                                    {{-- <i class="fa fa-calendar"></i> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">อัตราแลกเปลี่ยน</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control form_input_disable" disabled id="exchange_rate" name="exchange_rate" onblur="formatCurrency('exchange_rate','blur');" onkeyup="formatCurrency('exchange_rate');" placeholder="" value="">
                                </div>
                            </div>
                        </div>

                        <!--//-->

                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="d-block">เดบิต บัญชี</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-icon">
                                            <input type="text" list="accdebit" autocomplete="off" class="form-control form_input_disable" disabled name="accountmapping_debit" id="accountmapping_debit" onkeyup="chageAccountMapdebit()" onchange="chageAccountMapdebit()" placeholder="" value="">
                                            {{-- {{ $account_mapping['27']['account_combine'] }} --}}
                                            <datalist id="accdebit">
                                                @foreach ($account_mapping as $item_acmap)
                                                    <option value="{{ $item_acmap['account_combine'] }}" data-value="{{ $item_acmap['account_code'] }}" data-des="{{ $item_acmap['account_description'] }}" data-comdes="{{ $item_acmap['combine_desc'] }}" >{{ $item_acmap['account_description'] }}</option>
                                                @endforeach
                                            </datalist>
                                            <input type="hidden" name="accountmapping_id" id="accountmapping_id" value="{{ $account_mapping['27']['account_code'] }}">
                                            <i class="fa fa-search" data-toggle="modal" data-target="#myModal"></i>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <input type="text" class="form-control" disabled id="accountmapping_code" name="accountmapping_code" placeholder="" value="">
                                        {{-- {{ $account_mapping['27']['account_combine'] }} --}}
                                        <input type="hidden" class="form-control" id="input_mapping_code" name="input_mapping_code" placeholder="" value="">
                                        {{-- {{ $account_mapping['27']['account_combine'] }}{{ $account_mapping['27']['account_combine'] }} --}}
                                    </div>
                                    
                                    <div class="col-4">
                                        <input type="text" class="form-control" disabled id="accountmapping_name" name="accountmapping_name" placeholder="" value="">
                                        {{-- {{ $account_mapping['27']['account_description'] }} --}}
                                        <input type="hidden" class="form-control" id="input_mapping_name" name="input_mapping_name" placeholder="" value="">
                                        {{-- {{ $account_mapping['27']['account_description'] }} --}}
                                    </div>

                                </div><!--row-->
                                <small class="text-danger" id="cd_deccombi" ></small>
                                {{-- {{ $account_mapping['10']['combine_desc'] }} --}}
                            </div>
                        </div><!--col-->

                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="d-block">เครดิต บัญชี</label>
                                <div class="row space-5">
                                    <div class="col-4">
                                        <div class="input-icon">
                                            <input type="text" list="acccedit" autocomplete="off" class="form-control form_input_disable" name="accountmapping_cedit" id="accountmapping_cedit" onkeyup="chageAccountMapcredit()" onchange="chageAccountMapcredit()" disabled placeholder="" value="">
                                            {{-- {{ $account_mapping['06']['account_combine'] }} --}}
                                            <datalist id="acccedit">
                                                @foreach ($account_mapping as $item_acmap)
                                                    <option value="{{ $item_acmap['account_combine'] }}" data-value="{{ $item_acmap['account_code'] }}" data-des="{{ $item_acmap['account_description'] }}" data-comdes="{{ $item_acmap['combine_desc'] }}">{{ $item_acmap['account_description'] }}</option>
                                                @endforeach
                                            </datalist>
                                            <input type="hidden" name="accountmapping_cid" id="accountmapping_cid" value="">
                                            {{-- {{ $account_mapping['06']['account_code'] }} --}}
                                            <i class="fa fa-search" data-toggle="modal" data-target="#modalCreditNote"></i>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" disabled id="accountmapping_ceditcode" name="accountmapping_ceditcode" placeholder="" value="">
                                        {{-- {{ $account_mapping['06']['account_combine'] }} --}}
                                        <input type="hidden" class="form-control" id="input_mapping_ceditcode" name="input_mapping_ceditcode" placeholder="" value="">
                                        {{-- {{ $account_mapping['06']['account_combine'] }} --}}
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" disabled  id="accountmapping_ceditname" name="accountmapping_ceditname" placeholder="" value="">
                                        {{-- {{ $account_mapping['06']['account_description'] }} --}}
                                        <input type="hidden" class="form-control" id="input_mapping_ceditname" name="input_mapping_ceditname" placeholder="" value="">
                                        {{-- {{ $account_mapping['06']['account_description'] }} --}}
                                    </div>
                                    
                                </div><!--row-->
                                <small class="text-danger" id="cr_deccombi" ></small>
                                {{-- {{ $account_mapping['06']['combine_desc'] }} --}}
                            </div>
                        </div><!--col-->
                        @include('om.debitnote._form_credit')
                        <!--//-->

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="d-block">เดบิตบัญชีตามรายการ</label>
                                <input type="text" class="form-control form_input_disable" disabled id="accountmapping_name" name="accountmapping_name" placeholder="" value="{{ $account_mapping['27']['account_description'] }}">
                                <input type="hidden" class="form-control" id="input_mapping_name" name="input_mapping_name" placeholder="" value="{{ $account_mapping['27']['account_description'] }}">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="d-block">ประเภทเดบิต</label>
                                <select class="custom-select select2 form_input_disable" disabled name="debit_type" id="debit_type">
                                    <option value=""></option>
                                    @foreach ($debittype as $item_typedebit)
                                        <option value="{{ $item_typedebit->lookup_code }}">{{ $item_typedebit->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div><!--row-->
                </div><!--col-xl-12-->
                <div class="col-xl-12">
                    <hr class="lg">
                </div>

                <div class="col-xl-10 m-auto">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-hover min-650 f13">
                            <thead>
                                <tr class="align-middle">
                                    <th rowspan="2" class="w-250">ตรา</th>
                                    <th colspan="3">จำนวนที่ชื้อ</th>
                                    <th rowspan="2">ผลต่างราคา (ตามสกุลเงิน)</th>
                                </tr>
                                <tr class="align-middle">
                                    <!--จำนวนที่ตั้ง-->
                                    <th class="w-130">UOM Code</th>
                                    <th class="w-130">หน่วยนับ</th>
                                    <th class="w-130">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr class="align-middle">
                                    <td>TIGEReye <input type="hidden" id="product_1" name="product[1]"></td>
                                    <td></td>
                                    <td>2</td>
                                    <td>0.400</td>
                                    <td class="text-right">
                                        <input type="text" class="form-control md text-right" id="product_value_1" name="product_value[1]" value="500.00">
                                    </td>
                                </tr> --}}

                                <tr class="align-middle" id="invoice_line">
                                    <td class="text-right" colspan="4"><strong class="black"></strong></td>
                                    <td class="text-right">
                                        <input type="text" class="form-control md text-right" disabled="" id="total_line_value" value="">
                                    </td>
                                </tr>
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
<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>

<script>
    var customer_list_arr           = [];
    var invoice_line_arr            = [];
    var head_doc_id                 = '';
    var status                      = '';

    $(".select2").select2();

    customer_list();
    getDebitNoteList('');


    function customer_list()
    {
        var customer = $("#customer_number").val();
        $.ajax({
            url : '{{ url("om/ajax/debitnote_ranchtran_export/customer_list") }}',
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
                    html += '<option value="'+val.number+'">'+val.number+'/'+val.name+'</option>';
                });

                $("#customer_list").html(html);
            }
        });
    }

    function getDebitNoteList(customer)
    {
        if(customer != ''){
            var customer_id = customer_list_arr[customer].id
        }else{
            var customer_id = '';
        }

        $.ajax({
            url : '{{ url("om/ajax/debitnote_ranchtran_export/getdebitnote") }}',
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

                $("#debitnote_list").html(html);
            }
        });
    }

    function create_invoice()
    {
        $(".tr_line").remove();
        $("#amount").val('');
        $("#form_data")[0].reset();
        loading();
        $.ajax({
            url         : '{{ url("om/ajax/debitnote_ranchtran_export/gencreatenumber") }}',
            type        : 'post',
            data        : {
                '_token' : '{{ csrf_token() }}'
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    $("#debitnote_number").val(data.data.number);
                    $("#debitnote_number_input").val(data.data.number);
                    $("#debitnote_number").prop('disabled',true);
                    $(".in_confirm").prop('disabled',false);
                    $("#debitnote_date_show").val(data.data.date);
                    $("#debitnote_date").val(data.data.date);
                    reActiveDebitnoteDate(data.data.date)
                    // $("#document_date_show").val(data.data.date);
                    // $("#document_date").val(data.data.date);
                    $("#debitnote_status").val('Draft');
                    $("#debitnote_status_data").val('Draft');
                    $(".form_input_disable").prop('disabled',false);

                    $("#accountmapping_debit").val("{{ $account_mapping['27']['account_combine'] }}").trigger('change');
                    $("#accountmapping_cedit").val("{{ $account_mapping['06']['account_combine'] }}").trigger('change');

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
                    AlertToast('Waring','Someting Wrong please try again','error');
                }
            }
        });
    }

    function PrintReport()
    {
        var debitnote_number = $("#debitnote_number").val();
        window.open('{{ url("om/debit-note-export/report?number=") }}' + debitnote_number,'_blank').focus();
    }

    function searchcustomer(code)
    {
        console.log(code)
        // var customer = $("#customer_number").val();
        if(customer_list_arr[code] != '' && customer_list_arr[code] != 'null' && code != ''){

            $("#customer_id").val(customer_list_arr[code].id);
            $("#customer_provice").val(customer_list_arr[code].province);
            $("#customer_provice_name").val(customer_list_arr[code].province);
            $("#customer_name").val(customer_list_arr[code].name);
            $("#county").val(customer_list_arr[code].county).trigger('change');
            $("#currency").val(customer_list_arr[code].currency).trigger('change');
            // product_list(customer_list_arr[code].id);
        }else{
            $("#county").val('').trigger('change');
            $("#currency").val('').trigger('change');
            $("#customer_name").val('');
            $("#document_date").val('');
        }
    }

    function changeCountry()
    {
        var val = $("#county").val();
        var dec = $("#county option").filter(function(){
            return this.value == val;
        }).data('value');

        $("#county_code").val(val);
        $("#county_name").val(dec);

    }

    function changeCurrency()
    {
        var val = $("#currency").val();
        var dec = $("#currency option").filter(function(){
            return this.value == val;
        }).data('value');

        $("#currency_code").val(val);
        $("#currency_name").val(dec);
    }

    function chageAccountMapdebit()
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
        var comdes = $("#accdebit option").filter(function(){
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

    function getOrderList(code)
    {
        $("#order_id").val('');
        $("#document_date").val('');
        $("#document_date_data").val('');
        $("#order_number").val('');
        $("#order_number_data").val('');

        if(customer_list_arr[code] != '' && customer_list_arr[code] != 'null'){
            loading();
            $.ajax({
                url     : '{{ url("om/ajax/debitnote_ranchtran_export/getorderlist") }}',
                type    : 'post',
                data    : {
                    '_token'    : '{{ csrf_token() }}',
                    customer_id : customer_list_arr[code].id,
                },
                success:function(rest){
                    swal.close();
                    var data = rest.data;
                    var html = '<option value=""></option>';
                    if(data.status){
                        $.each(data.data,function(key,val){
                            html += '<option value="'+val.id+'">'+val.number+'</option>';
                        });
                    }
                    $("#order_number").html(html);
                    $("#cus_type").val(data.type);

                    if(head_doc_id){
                        $("#order_number").val(head_doc_id).trigger('change');
                    }
                }
            });
        }
    }

    function search_invoice()
    {
        var number = $("#debitnote_number").val();
        var date   = $("#debitnote_date").val();
        loading();
        $.ajax({
            url     : '{{ url("om/ajax/debitnote_ranchtran_export/search_invoice") }}',
            type    : 'post',
            data    : {
                '_token'    : '{{ csrf_token() }}',
                number      : number,
                date        : date
            },
            success:function(rest){
                swal.close();

                if(rest.data.status){
                    $(".in_create").prop('disabled',true);
                    var data = rest.data.data;
                    var data_h = rest.data.header;
                    var data_l = rest.data.invoice_line;
                    if(data.invoice_status == 'Cancel'){
                        $(".in_confirm").prop('disabled',true);
                        $(".in_create").prop('disabled',true);
                        $(".form_input_disable").prop('disabled',true);
                        deActiveDebitnoteDate(data.date_invoice);
                    }else if(data.invoice_status == 'Draft'){
                        $(".in_cancel").prop('disabled',false);
                        $(".in_confirm").prop('disabled',false);
                        $(".in_create").prop('disabled',true);
                        $(".form_input_disable").prop('disabled',false);
                        reActiveDebitnoteDate(data.date_invoice);
                    }else if(data.invoice_status == 'Confirm'){
                        $(".in_cancel").prop('disabled',false);
                        $(".in_confirm").prop('disabled',true);
                        $(".in_create").prop('disabled',true);
                        $(".form_input_disable").prop('disabled',true);
                        deActiveDebitnoteDate(data.date_invoice);
                    }else{
                        $(".in_confirm").prop('disabled',false);
                        $(".in_cancel").prop('disabled',false);
                        reActiveDebitnoteDate(data.date_invoice);
                    }
                    status = data.invoice_status;
                    $("#debitnote_status").val(data.invoice_status);
                    $("#debitnote_status_data").val(data.invoice_status);
                    head_doc_id = data.document_id;
                    $("#customer_number").val(data.customer_number).trigger('change');
                    // searchcustomer(data.customer_number);
                    $("#amount").val(numberFormat(data.invoice_amount));
                    // $("#debitnote_date_show").val(data.date_invoice);
                    $("#debitnote_date").val(data.date_invoice);
                    $("#debitnote_number").val(data.invoice_headers_number);
                    $("#debitnote_number_input").val(data.invoice_headers_number);
                    $("#exchange_rate").val(data.exchange_rate);
                    $("#invoice_id").val(data.invoice_headers_id);
                    $("#debit_type").val(data.account_debit_type_code).trigger('change');
                    $("#debit_detail").val(data.cr_account_desc);
                    if(data.dr_account_code){
                        $("#accountmapping_debit").val(data.accd_code).trigger('change');
                    }else{
                        if(data.dr_segment1 == null && data.dr_segment2 == null){
                            $("#accountmapping_debit").val('').trigger('change');
                        }else{
                            var combi_segment = data.dr_segment1+'.'+data.dr_segment2+'.'+data.dr_segment3+'.'+data.dr_segment4+'.'+data.dr_segment5+'.'+data.dr_segment6;
                            combi_segment += '.'+data.dr_segment7+'.'+data.dr_segment8+'.'+data.dr_segment9+'.'+data.dr_segment10+'.'+data.dr_segment11+'.'+data.dr_segment12;
                            $("#accountmapping_debit").val(combi_segment).trigger('change');
                        }
                    }

                    $("#company_code").val(data.dr_segment1).trigger('change');
                    $("#evm").val(data.dr_segment2).trigger('change');
                    $("#department_code").val(data.dr_segment3).trigger('change');
                    $("#cost_center").val(data.dr_segment4).trigger('change');
                    $("#budget_year").val(data.dr_segment5).trigger('change');
                    $("#budget_type").val(data.dr_segment6).trigger('change');
                    $("#budget_detail").val(data.dr_segment7).trigger('change');
                    $("#budget_reason").val(data.dr_segment8).trigger('change');
                    $("#main_account").val(data.dr_segment9).trigger('change');
                    $("#sub_account").val(data.dr_segment10).trigger('change');
                    $("#reserved1").val(data.dr_segment11).trigger('change');
                    $("#reserved2").val(data.dr_segment12).trigger('change');

                    //-------------------------------------------------------------
                    if(data.cr_account_code){
                        $("#accountmapping_cedit").val(data.accr_code).trigger('change');
                    }else{
                        if(data.cr_segment1 == null && data.cr_segment2 == null){
                            $("#accountmapping_cedit").val('').trigger('change');
                        }else{
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

                    if(data.document_id != ''){
                        $("#order_number").val(data_h.number);
                        invoice_line_arr = data_l;
                        searchOrder();
                    }else{
                        $("#order_number").val(data.document_id);
                    }
                    $("#save_type").val('Complete');
                    // $("#order_number").val(data.document_id);
                    // $("#document_data_date").val(data.document_date);
                }else{
                    AlertToast('Waring','No Invoice Found','error');
                }
            }
        });
    }

    function searchOrder()
    {
        var customer_id     = $("#customer_id").val();
        var ordernumber     = $("#order_number").val();
        var cus_type        = $("#cus_type").val();
        var order_type      = $("#order_number option[value='"+ordernumber+"']").data('type');

        loading();
        $.ajax({
            url     : '{{ url("om/ajax/debitnote_ranchtran_export/searchOrder") }}',
            type    : 'post',
            data    : {
                '_token'        : '{{ csrf_token() }}',
                customer_id     : customer_id,
                ordernumber     : ordernumber,
                cus_type        : cus_type,
                order_type      : order_type
            },
            success : function(rest){
                swal.close();
                $(".tr_line").remove();
                var val     = rest.data;
                var data    = val.data;

                if(val.status){
                    $("#order_id").val(data.header.id);
                    $("#document_date").val(data.header.date);
                    $("#document_date_data").val(data.header.date);
                    $("#order_number").val(data.header.number);
                    $("#order_number_data").val(data.header.number);

                    $("#accountmapping_debit").prop('disabled',true);
                    $("#accountmapping_cedit").prop('disabled',true);

                    $("#accountmapping_debit").val('').trigger('change');
                    $("#accountmapping_cedit").val('').trigger('change');
                }else{
                    $("#order_id").val('');
                    $("#document_date").val('');
                    $("#document_date_data").val('');
                    $("#order_number").val('');
                    $("#order_number_data").val('');
                    $("#accountmapping_debit").prop('disabled',false);
                    $("#accountmapping_cedit").prop('disabled',false);

                    $("#accountmapping_debit").val("{{ $account_mapping['27']['account_combine'] }}").trigger('change');
                    $("#accountmapping_cedit").val("{{ $account_mapping['06']['account_combine'] }}").trigger('change');
                    return false;
                }
                var html = '';

                if(status == 'Confirm' || status == 'Cancel'){
                    var edit_status = 'disabled';
                }else{
                    var edit_status = '';
                }

                $.each(data.line,function(key,val){
                    html += '<tr class="align-middle tr_line">';
                    html += '    <td>'+val.description+' <input type="hidden" id="product_'+val.id+'" name="product['+val.id+']" value="'+val.id+'">';
                    html += '       <input type="hidden" id="product_id_'+val.id+'" name="product_id['+val.id+']" value="'+val.item_id+'">';
                    html += '       <input type="hidden" id="product_code_'+val.id+'" name="product_code['+val.id+']" value="'+val.item_code+'">';
                    html += '       <input type="hidden" id="product_desc_'+val.id+'" name="product_desc['+val.id+']" value="'+val.description+'">';
                    html += '       <input type="hidden" id="product_uom_'+val.id+'" name="product_uom['+val.id+']" value="'+val.uom_code+'">';
                    html += '       <input type="hidden" id="ceditgroup_'+val.id+'" name="ceditgroup['+val.id+']" value="'+val.credit_group_code+'">';
                    if(invoice_line_arr != ''){
                        html += '       <input type="hidden" id="invoice_line_'+val.id+'" name="invoice_line['+val.id+']" value="'+invoice_line_arr.line[val.id].id+'">';
                    }else{
                        html += '       <input type="hidden" id="invoice_line_'+val.id+'" name="invoice_line['+val.id+']" value="">';
                    }
                    html += '    </td>';
                    html += '    <td>'+val.uom_code+'</td>';
                    html += '    <td>'+val.uom+'</td>';
                    // html += '    <td>'+val.approve_cardboardbox+'</td>';
                    // html += '    <td>'+val.approve_carton+'</td>';
                    html += '    <td>'+val.approve_total+' <input type="hidden" id="line_total_'+val.id+'" name="line_total['+val.id+']" value="'+val.approve_total+'"></td>';
                    html += '    <td class="text-right">';
                    if(invoice_line_arr != ''){
                        html += '        <input type="text" '+edit_status+' class="form-control md text-right input_line" onblur="formatCurrency('+"'product_value_"+val.id+"'"+', '+"'"+blur+"'"+')" onkeyup="sumTotalLine();formatCurrency('+"'product_value_"+val.id+"'"+');" id="product_value_'+val.id+'" name="product_value['+val.id+']" value="'+numberFormat(invoice_line_arr.line[val.id].diff)+'">';
                    }else{
                        html += '        <input type="text" '+edit_status+' class="form-control md text-right input_line" onblur="formatCurrency('+"'product_value_"+val.id+"'"+', '+"'"+blur+"'"+')" onkeyup="sumTotalLine();formatCurrency('+"'product_value_"+val.id+"'"+');" id="product_value_'+val.id+'" name="product_value['+val.id+']" value="'+numberFormat(0)+'">';
                    }
                    html += '    </td>';
                    html += '</tr>';
                });
                $("#total_line_value").val(numberFormat((isNaN(invoice_line_arr.total)) ? 0 : invoice_line_arr.total));
                $(html).insertBefore('#invoice_line');
            }
        });
    }

    function sumTotalLine()
    {
        var total = 0;
        $('input[name^=product_value]').map(function(idx, elem) {
            var value = $(elem).val().toString().replace(/,/g, '');
            total += parseFloat(value);
        });


        $("#total_line_value").val(numberFormat(total));
        $("#amount").val(numberFormat(total));

    }

    function chage_amount()
    {
        var new_amount = 0;
        $.each($("input[name^=amount_pay]"),function(key,value){
            new_amount += $(value).val() * 1;
        });

        $("#total_payamount").val(new_amount);
    }

    function update_invoice()
    {
        const formdata = new FormData(document.getElementById("form_data"));
        formdata.append('_token','{{ csrf_token() }}');
        loading();
        $.ajax({
            url         : '{{ url("om/ajax/debitnote_ranchtran_export/save_invoice") }}',
            type        : 'post',
            data        : formdata,
            cache       : false,
            processData : false,
            contentType : false,
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    $("#debitnote_status").val(data.header_status);
                    $("#debitnote_status_data").val(data.header_status);
                    $("#debitnote_number").val(data.header_number);
                    $("#debitnote_number_input").val(data.header_number);

                    search_invoice();
                    // location.reload();
                    // $("#form_data")[0].reset();
                    AlertToast('Success','Add Complete','success');
                    $('#close-btn-contact').hide();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgContact(data.data);
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error');
                    }
                }
            }
        });
    }

    function popCancelInvoice()
    {
        Swal.fire({
            title:  'แจ้งเตือน',
            html:   'ต้องการยกเลิก ใบเพิ่มหนี้ ใช่หรือไม่',// add html attribute if you want or remove
            focusConfirm: false,
            showCancelButton: true,
            preConfirm: () => {
                cancel_invoice();
            }
        });
    }

    function cancel_invoice()
    {
        var invoice_id = $("#invoice_id").val();
        loading();
        $.ajax({
           url : '{{ url("om/ajax/debitnote_ranchtran_export/cancel_invoice") }}',
           type : 'post',
           data : {
                '_token'    : '{{ csrf_token() }}',
                invoice_id : invoice_id
           },
           success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){

                    search_invoice();
                    // location.reload();
                    // $("#form_data")[0].reset();
                    AlertToast('Success','Cancel Complete','success');
                    $('#close-btn-contact').hide();
                }else{
                    if(data.data == 'Close'){
                        AlertToast('Waring','ไม่สามารถทำการยกเลิกใบเพิ่มหนี้ได้ เนื่องจากทำการปิดการขายประจำวันเรียบร้อยแล้ว','error');
                    }else{
                        AlertToast('Waring','Someting Wrong please try again','error'); 
                    }
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

    function reActiveDebitnoteDate(value)
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
                    name="debitnote_date_show"
                    id="debitnote_date_show"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".debitnote_date_show");
    }

    function deActiveDebitnoteDate(value)
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
                    name="debitnote_date_show"
                    id="debitnote_date_show"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".debitnote_date_show");
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

@include('om.debitnote._script_credit')
@stop
