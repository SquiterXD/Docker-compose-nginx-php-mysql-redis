@extends('layouts.app')

@section('title', 'การรับเงินแบบ Direct Debit ในประเทศ')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <style>
        /* #page-wrapper{
            width: calc(100% - 220px);
        } */
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
        /* .mx-datepicker .mx-input-wrapper input{
            height: auto;
        } */
        .select2-container{
            width: 100%!important;
            text-align: left;
        }
        .form-control[readonly] {
            background-color: #f5f7fa;
            border-color: #e4e7ed;
            color: #c0c4cc;
            opacity: 1;
        }
    </style>
@stop

@section('page-title')
    <h2><x-get-program-code url="/om/order-direct-debit/domestic" /> การรับเงินแบบ Direct Debit ในประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/order-direct-debit/domestic" /> การรับเงินแบบ Direct Debit ในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h3>การรับเงินแบบ Direct Debit ในประเทศ</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">
                    <form action="" method="get">
                        <input type="hidden" name="search_flag" value="true">
                        <div class="form-group">
                            <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>

                            <label class="d-block">รหัสธนาคาร</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon mr-md-2 mr-0">
                                        <input type="text" class="form-control" autocomplete="off" name="bank_id" id="bank_id" placeholder="" value="{{ (request()) ? request()->bank_id : '' }}" list="bank-list" onchange="bankchange(this.value);">
                                        <i class="fa fa-search"></i>
                                        <datalist id="bank-list">
                                            @foreach ($bankAccountSearch as $item)
                                                <option data-value="{{ $item->bank_number }}">{{ $item->bank_number }} : {{ $item->bank_name }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    {{-- <div class="input-icon">
                                        <input type="text" class="form-control" name="bank_account_id" placeholder="" value="">
                                        <i class="fa fa-search"></i>
                                    </div> --}}
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" readonly name="bank_name" id="bank_name" placeholder="" value="{{ (request()) ? request()->bank_name : '' }}">
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
                                    value="{{ $search_flag ? request()->from_date : dateFormatThai(date('m/d/Y')) }}"
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
                                    value="{{ $search_flag ? request()->to_date : dateFormatThai(date('m/d/Y')) }}"
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
                            <label class="d-block">เลขที่ใบเตรียมขาย</label>
                            <select class="custom-select select2" style="width: 100%;" id="prepare_order_number" name="prepare_order_number" data-placeholder="เลขที่ใบเตรียมขาย">
                                <option value="">&nbsp;</option>
                                @foreach ($orderSa as $item)
                                <option value="{{ $item->prepare_order_number }}" data-customer="{{ $item->customer_number }}" {{ (request() && $item->prepare_order_number == request()->prepare_order_number) ? 'selected' : '' }}>{{ $item->prepare_order_number }}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">ลูกค้า</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon mr-md-2 mr-0">
                                        <input type="text" class="form-control" name="customer_number" autocomplete="off" id="customer_number" placeholder="" value="{{ (request()) ? request()->customer_number : '' }}" list="customer-list" onchange="custchange(this.value);">
                                        <i class="fa fa-search"></i>
                                        <datalist id="customer-list">
                                            @foreach ($customers as $item)
                                                @if ($item['customer_number'] != '')
                                                <option value="{{ $item['customer_number'] }}">{{ $item['customer_name'] }}</option>
                                                @endif
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="customer_name" name="customer_name" readonly class="form-control" value="{{ (request()) ? request()->customer_name : '' }}">
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">สถานะการอนุมัติ</label>
                            <select class="custom-select select2" style="width: 100%;" name="status">
                                <option value="">&nbsp;</option>
                                <option value="y" {{ (request() && request()->status == 'y') ? 'selected' : '' }}>อนุมัติ</option>
                                <option value="w" {{ (request() && request()->status == 'w') ? 'selected' : '' }}>ยังไม่ได้อนุมัติ</option>
                                <option value="n" {{ (request() && request()->status == 'n') ? 'selected' : '' }}>ยกเลิก</option>
                            </select>
                        </div>

                        <div class="form-buttons no-border">
                            <button class="btn btn-lg btn-white" type="button" onclick="window.location = '{{ url('/') }}/om/order-direct-debit/domestic';"><i class="fa fa-repeat"></i> ล้างข้อมูล</button>
                            <button class="btn btn-lg btn-white" type="submit"><i class="fa fa-search"></i> ค้นหา</button>
                        </div>
                    </form>
                </div><!--col-xl-6-->

                @if (request()->has('customer_number'))
                <div class="col-md-12">
                    <hr class="lg">
                    <form id="form-save" method="post" data-action="{{ url('/') }}/om/order-direct-debit/domestic/save/">
                        {{ csrf_field() }}

                        @if(count($orderDirectDebit) > 0)
                        <div class="form-header-buttons flex-md-row-reverse">
                            <div class="buttons d-flex">
                                <button class="btn btn-md btn-white has-checkbox mt-2 mt-md-0" type="button">
                                    <label><input type="checkbox" name="check_send_all" class="check_send_all"><span> อนุมัติทั้งหมด</span></label>
                                </button>

                                <button class="btn btn-md btn-primary" type="submit"><i class="fa fa-save"></i> บันทึก</button>
                            </div><!--buttons-->
                        </div><!--form-header-buttons-->

                        <div class="hr-line-dashed"></div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-hover f13" id="tableOMP0028">
                                <thead>
                                    <tr class="align-middle" class="first">
                                        <th class="sticky-col-1">รายการที่</th>
                                        <th class="sticky-col-2">อนุมัติ</th>
                                        <th class="sticky-col-3">ยกเลิก</th>
                                        <th class="sticky-col-4">เลขที่ใบเตรียมขาย</th>
                                        <th class="sticky-col-5">วันที่ส่ง</th>
                                        <th class="sticky-col-6">ชื่อลูกค้า</th>
                                        <th>กลุ่มวงเงิน</th>
                                        <th>จำนวนเงิน</th>
                                        <th>วันครบกำหนดชำระเงิน</th>
                                        <th>ธนาคารของลูกค้า</th>
                                        <th>ธนาคารของการยาสูบ</th>
                                        <th>จำนวนเงินตัด Direct Debit</th>
                                        <th>วันที่อนุมัติ</th>
                                        <th>Batch Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderDirectDebit as $key => $item)
                                    <tr class="align-middle {{ ($item['additionQuota']) ? 'tr-text-red' : 'tr-text-blue' }}">
                                        <td>{{ $key += 1 }}</td>
                                        <td>
                                            <div class="i-checks">
                                                <input type="radio" value="Y" {{ ($item['direct_debit_flag'] == 'Y') ? 'checked' : '' }} {{ (!is_null($item['direct_debit_flag'])) ? 'disabled' : '' }} class="direct_debit_flag flag_y" name="direct_debit_flag[{{ $item['order_direct_debit_id'] }}]" id="direct_debit_flag_{{ $item['order_direct_debit_id'] }}_y">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="i-checks">
                                                <input type="radio" value="N" {{ ($item['direct_debit_flag'] == 'N') ? 'checked' : '' }} {{ (!is_null($item['direct_debit_flag'])) ? 'disabled' : '' }} class="direct_debit_flag" name="direct_debit_flag[{{ $item['order_direct_debit_id'] }}]" id="direct_debit_flag_{{ $item['order_direct_debit_id'] }}_n">
                                            </div>
                                        </td>
                                        <td>{{ $item['prepare_order_number'] }}</td>
                                        <td>{{ dateFormatDMY($item['order_delivery_date'],'/') }}</td>
                                        <td class="text-left">{{ $item['customer_name'] }}</td>
                                        <td>{{ ($item['credit_group_code'] == 0) ? 'สด' : $item['credit_group_code'] }}</td>
                                        <td class="text-right">{{ number_format($item['direct_debit_amount'],2) }}</td>
                                        <td>{{ $item['dayAmount'] }}</td>
                                        <td>

                                            <select class="custom-select select2" 
                                                    style="width: max-content!important;" 
                                                    {{ (!is_null($item['direct_debit_flag'])) ? 'disabled' : '' }} 
                                                    id="bank-account-{{ $item['order_direct_debit_id'] }}" 
                                                    name="customer_direct_debit_id[{{ $item['order_direct_debit_id'] }}]">
                                                @foreach ($bankCustomer[$item['order_direct_debit_id']] as $key => $bo)
                                                    <option value="{{ $bo['direct_debit_id'] }}" {{ $bo['selected'] ? 'selected' : '' }}>{{ $bo['bank_account_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="custom-select select2" 
                                                    style="width: max-content!important;" 
                                                    {{ (!is_null($item['direct_debit_flag'])) ? 'disabled' : '' }} 
                                                    id="bank-toat-{{ $item['order_direct_debit_id'] }}" 
                                                    name="toat_direct_debit_id[{{ $item['order_direct_debit_id'] }}]">
                                                @foreach ($bankToatLov as $key => $bo)
                                                    <option value="{{ $bo->bank_id }}_{{ $bo->branch_id }}" {{ $bo->short_bank_name == $item['bank_default'] ? 'selected' : ''}}>{{ $bo->bank_account_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control text-right md direct_debit_amount" {{ (!is_null($item['direct_debit_flag'])) ? 'disabled' : '' }} onkeypress="return isCheckNumber(event)" name="direct_debit_amount[{{ $item['order_direct_debit_id'] }}]" placeholder="" value="{{ number_format($item['direct_debit_amount'],2) }}">
                                        </td>
                                        <td>
                                            {{ (!is_null($item['approve_date'])) ? dateFormatThai($item['approve_date']) : '' }}
                                        </td>
                                        <td>
                                            {{ $item['web_batch_no'] }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!--table-responsive-->

                        <div class="d-flex mt-4 mb-5">
                            <div class="d-flex ml-auto mr-4">สั่งซื้อปกติ <span class="box-label" style="background-color: #1c84c6"></span></div>
                            <div class="d-flex">สั่งซื้อเกินโควต้า <span class="box-label" style="background-color:red"></span></div>
                        </div>
                    </form>

                </div>
                @endif

            </div><!--row-->
        </div><!--ibox-content-->
    </div><!--ibox-->

@endsection

@section('scripts')
<script src="https://unpkg.com/moment@2.26.0/moment.js"></script>
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
<script>

    var change_customer = false
    var prepare_order_number = ''
    $(".select2").select2();
    checked = false
    let customerlists = {!! json_encode($customers) !!};
    let banklists = {!! json_encode($bankAccountSearch) !!};

    $(document).on("focusout",".direct_debit_amount",function(){
        $(this).val(formatMoney(formatConvertMoney($(this).val()),2))
    });

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

    function formatConvertMoney(amount) {
        return parseFloat(Number(amount.replace(/[^0-9\.]+/g,"")));
    }

    function isCheckNumber(evt)
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function custchange(v){
        if(v != ''){
            var index = _.findIndex(customerlists, function(o) {return o['customer_number'] == v;});
            if(index != -1){
                $('#customer_name').val(customerlists[index]['customer_name']);
                change_customer = true
                if(change_customer){
                    $.ajax({
                        url : "/om/order-direct-debit/sa-by-customer/"+v,
                        success:function(res){
                            $('#prepare_order_number').empty()
                            $('#prepare_order_number')
                                .append($('<option></option>')
                                .val('')).trigger('change');
                            $.each( res.data, function( key, obj ) {
                                if(obj.prepare_order_number == prepare_order_number){
                                    $('#prepare_order_number')
                                    .append($('<option selected></option>')
                                    .val(obj.prepare_order_number)
                                    .data('customer',obj.customer_number)
                                    .html(obj.prepare_order_number)).trigger('change');
                                }else{
                                    $('#prepare_order_number')
                                    .append($('<option></option>')
                                    .val(obj.prepare_order_number)
                                    .data('customer',obj.customer_number)
                                    .html(obj.prepare_order_number)).trigger('change');
                                }
                            });
                        }
                    });
                }

            }
        }else{
            $('#customer_name').val('');
        }
    }

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

    $('#prepare_order_number').on('select2:select', function(e) {
        let customer = $('#prepare_order_number option:selected').data('customer')
        $("#customer_number").val(customer)
        prepare_order_number = $(this).val()
        console.log(prepare_order_number)
        if(change_customer == false){
            custchange(customer);
        }
    });


    $(".bank-account").change(function(e){
        var id = $(this).data('id')
        $.ajax({
            url : "/om/ajax/bank/by-short-name/"+$(this).val(),
            success:function(res){
                $("#bank-account-"+id).empty()
                $("#bank-account-"+id).append(
                    $('<option>', {
                        value: '',
                        text : 'เลือก (Select)'
                    })
                );
                $.each(res.data, function (i, item) {
                    $("#bank-account-"+id).append(
                        $('<option>', {
                            value: item.bank_account_id,
                            text : item.bank_account_name
                        })
                    );
                });
            }
        });
    });

    $('.direct_debit_flag').on('change', function() {
        checked = true
    });

    $('.check_send_all').on('change', function() {
        if($(this).is(":checked")){
            checked = true
            $('.flag_y').prop('checked',true);
        }else{
            checked = false
            $('.flag_y').prop('checked',false);
        }
    });

    $("#form-save").submit(async function(e) {

        e.preventDefault();
        let fb = this // this

        // if(checked == true){
            let formData = new FormData(fb);

            Swal.fire({
                title: 'ต้องการอนุมัติตัด Direct Debit หรือไม่',
                text: '',
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
                        url: $(fb).data('action'),
                        data: formData,
                        enctype: 'multipart/form-data',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if(result.status){
                                location.reload();
                            }else{
                                swal('Something went wrong')
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
        // }else{
        //     swal('กรุณาแก้ไขอย่างน้อย 1 รายการ')
        // }

    })

</script>

<style scope>
    #tableOMP0028 {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    #tableOMP0028 tbody > tr > td:first-child {
        background: #fff;
        position: sticky;
        left: 0px;
        width: min-content;
        padding: 2px 5px 5px 5px;
        z-index: 1;
        overflow-x: auto
    }

    #tableOMP0028 tbody > tr > td:nth-child(2) {
        background: #fff;
        position: -webkit-sticky;
        position: sticky;
        left: 68px;
        width: min-content;
        padding: 2px 5px 5px 5px;
        z-index: 1;
        overflow-x: auto;
    }

    #tableOMP0028 tbody > tr > td:nth-child(3) {
        background: #fff;
        position: -webkit-sticky;
        position: sticky;
        left: 119px;
        width: min-content;
        padding: 2px 5px 5px 5px;
        z-index: 1;
        overflow-x: auto;
    }

    #tableOMP0028 tbody > tr > td:nth-child(4) {
        background: #fff;
        position: -webkit-sticky;
        position: sticky;
        left: 172px;
        width: min-content;
        padding: 2px 5px 5px 5px;
        z-index: 1;
        overflow-x: auto;
    }

    #tableOMP0028 tbody > tr > td:nth-child(5) {
        background: #fff;
        position: -webkit-sticky;
        position: sticky;
        left: 290px;
        width: min-content;
        padding: 2px 5px 5px 5px;
        z-index: 1;
        overflow-x: auto;
    }

    #tableOMP0028 tbody > tr > td:nth-child(6) {
        background: #fff;
        position: -webkit-sticky;
        position: sticky;
        left: 370px;
        width: min-content;
        padding: 2px 5px 5px 5px;
        z-index: 1;
        overflow-x: auto;
    }

    #tableOMP0028 thead {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 2;
        background: #fff;
    }

    .sticky-col-1 {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        background: white;
        padding: 2px 5px 5px 5px;
        z-index: 2;
    }

    .sticky-col-2 {
        position: -webkit-sticky;
        position: sticky;
        left: 68px;
        background: white;
        padding: 2px 5px 5px 5px;
        z-index: 2;
    }

    .sticky-col-3 {
        position: -webkit-sticky;
        position: sticky;
        left: 119px;
        background: white;
        padding: 2px 5px 5px 5px;
        z-index: 2;
    }

    .sticky-col-4 {
        position: -webkit-sticky;
        position: sticky;
        left: 172px;
        background: white;
        padding: 2px 5px 5px 5px;
        z-index: 2;
    }

    .sticky-col-5 {
        position: -webkit-sticky;
        position: sticky;
        left: 290px;
        background: white;
        padding: 2px 5px 5px 5px;
        z-index: 2;
    }

    .sticky-col-6 {
        position: -webkit-sticky;
        position: sticky;
        left: 370px;
        background: white;
        padding: 2px 5px 5px 5px;
        z-index: 2;
    }
</style>
@stop
