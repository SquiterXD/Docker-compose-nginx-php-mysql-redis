@extends('layouts.app')
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #e5e6e7 !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 2px !important;
    }

    table.dataTable {
        font-size: 0.9rem;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

    .swal2-select {
        font-size: 1em !important;
        border-radius: 5px;
    }

    .swal2-container {
        z-index: 2060 !important;
    }

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

    #orderLines .active {
        color: #212529;
        background-color: rgba(200, 231, 234, 0.5);
    }

    .input-icon .disabled{
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    /* BUTTON INFO COLOR */
    .btn-info {
        background-color: #24c6c8 !important;
        border-color: #24c6c8 !important;
    }

</style>

@section('title', 'บันทึกอัตราแลกเปลี่ยนตามวันที่ในใบขน')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>
        OMP0075 บันทึกอัตราแลกเปลี่ยนตามวันที่ในใบขน
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>บันทึกอัตราแลกเปลี่ยนตามวันที่ในใบขน</strong>
        </li>
    </ol>
@stop

@section('content')

    <form id="formExchangeExport" autocomplete="none" enctype="multipart/form-data">
        <div class="ibox">
            <div class="ibox-title">
                <h3>บันทึกอัตราแลกเปลี่ยนตามวันที่ในใบขน</h3>
            </div>
            <div class="ibox-content">
                <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">

                    <div class="col-xl-12">
                        <div class="form-header-buttons">
                            <div class="buttons">
                                <button class="btn btn-md btn-white" id="buttonSearch" type="button" onclick="clearInvoice()"><i class="fa fa-repeat"></i> ล้างข้อมูล</button>
                                {{-- <button class="btn btn-md btn-success" id="buttonCreate" type="button" onclick="checkEventInvoice('create')"><i class="fa fa-plus"></i> สร้าง</button> --}}
                                <button class="btn btn-md btn-white" id="buttonSearch" type="button" onclick="searchShortInvoice()"><i class="fa fa-search"></i> ค้นหา</button>
                                {{-- <button class="btn btn-md btn-white" id="buttonSearch" type="button" onclick="searchInvoice()"><i class="fa fa-search"></i> ค้นหา</button> --}}
                                <button class="btn btn-md btn-primary" id="buttonSave" type="button" onclick="updateInvoice()"><i class="fa fa-save"></i> บันทึก</button>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                    </div>

                    <div class="col-xl-6 m-auto">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">เลขที่ Invoice</label>
                                    {{-- <div class="input-icon">
                                        <input type="text" class="form-control"  name="pick_release_no" id="pick_release_no" placeholder="" value="" autocomplete="off">
                                        <i class="fa fa-search"></i>
                                    </div> --}}
                                    <div class="input-icon">
                                        <input type="text" class="form-control" name="pick_release_no" id="pick_release_no" list="pick-release-list" value="" onchange="selectPickReleaseNo()" autocomplete="off">
                                        <i class="fa fa-search"></i>
                                        <datalist id="pick-release-list">

                                            <option value=""> &nbsp; </option>
                                            @foreach ($pickReleaseNoList as $item)
                                            @if (!empty($item->pick_release_no))
                                            <option value="{{ $item->pick_release_no }}">{{ $item->pick_release_no }}</option>
                                            @endif
                                            @endforeach

                                        </datalist>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block">วันที่ Invoice</label>
                                    <div class="input-icon" id="html_pick_release_date">
                                        {{-- <div id="mount_pick_release_date" ></div> --}}
                                        <input type="text" class="form-control date" readonly name="pick_release_approve_date" id="pick_release_approve_date" placeholder="" value="" autocomplete="off">
                                        <i class="fa fa-calendar"></i>
                                        {{-- <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="pick_release_approve_date"
                                            id="pick_release_approve_date"
                                            disabled
                                            placeholder=""
                                            value=""
                                            format="{{ trans("date.js-format") }}"> --}}
                                    </div>
                                    <input type="hidden" name="pi_header_id" id="pi_header_id" value="" autocomplete="off">
                                    {{-- <input type="hidden" name="show_pick_release_approve_date" id="show_pick_release_approve_date" value="" autocomplete="off"> --}}
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">ชื่อลูกค้า</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="customer_id" id="customer_id" value="" autocomplete="off">
                                    <input type="text" class="form-control" readonly name="customer_number" id="customer_number" placeholder="" value="" autocomplete="off">
                                </div>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="" value="" autocomplete="off">
                                </div>
                            </div><!--row-->
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">อัตราแลกเปลี่ยน (Invoice)</label>
                                    <input type="text" class="form-control" readonly name="exchange_rate" id="exchange_rate" placeholder="" value="" autocomplete="off">
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block">สกุลเงิน</label>
                                    <input type="text" class="form-control" readonly name="currency" id="currency" placeholder="" value="" autocomplete="off">
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="d-block">อัตราแลกเปลี่ยน (ตามวันที่ในใบขน)</label>
                                    <input type="text" class="form-control"  name="pick_exchange_rate" id="pick_exchange_rate" placeholder="" value="" onkeypress="return isNumber(event)" autocomplete="off">
                                </div>

                                <div class="col-md-6">
                                    <label class="d-block">วันที่ในใบขน</label>
                                    <div class="input-icon" id="html_pick_exchange_date">
                                        {{-- <div id="mount_pick_exchange_date" ></div> --}}
                                        <input type="text" class="form-control date" name="pick_exchange_date" id="pick_exchange_date" placeholder="" value="" autocomplete="off">
                                        <i class="fa fa-calendar"></i>
                                        {{-- <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="pick_exchange_date"
                                            id="pick_exchange_date"
                                            placeholder=""
                                            value=""
                                            format="{{ trans("date.js-format") }}"> --}}
                                    </div>
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                    </div><!--col-xl-6-->
                </div><!--row-->

            </div><!--ibox-content-->
        </div><!--ibox-->


    </form>

@endsection

@section('scripts')

    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
    <!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){


        $('.date').datepicker({ format: 'dd/mm/yyyy' });
        // EVENT ONLOAD
    });

</script>

<script>

    var pickReleaseNoList    = @json($pickReleaseNoList);
    var arCloseInterface    = '';
    var checkExchange       = '';
    var stepEvent           = '';

    function selectPickReleaseNo() {
        var pickReleaseNo = $('#pick_release_no').val();
        var HeaderID        = '';
        var pickApproveDate = '';

        if (pickReleaseNo != '') {
            $.each(pickReleaseNoList, function(key, val){
                if (val.pick_release_no == pickReleaseNo) {
                    HeaderID        = val.pi_header_id;
                    pickApproveDate = val.pick_release_approve_date;
                }
            });
        }

        $('#pi_header_id').val(HeaderID);
        // $('#pick_release_approve_date').val(pickApproveDate);
        // $('#show_pick_release_approve_date').val(pickApproveDate);
        $("#pick_release_approve_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", '');

        $('#customer_id').val('');
        $('#customer_number').val('');
        $('#customer_name').val('');
        $('#exchange_rate').val('');
        $('#currency').val('');
        $('#pick_exchange_rate').val('');
        $("#pick_exchange_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", '');
        // generatePickExchangeDate('');
    }

    function clearInvoice(){
        $('#pi_header_id').val('');
        $('#pick_release_no').val('');
        $('#pick_release_approve_date').val('');
        $('#show_pick_release_approve_date').val('');
        $('#customer_id').val('');
        $('#customer_number').val('');
        $('#customer_name').val('');
        $('#exchange_rate').val('');
        $('#currency').val('');
        $('#pick_exchange_rate').val('');
        $("#pick_exchange_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", '');

        $('#pick_exchange_rate').prop('readonly', false);
        $('#pick_exchange_date').prop('readonly', false);
        // generatePickExchangeDate('');
        checkExchange   = '';
        stepEvent       = '';

        checkEventInvoice(stepEvent);
    }

    function checkEventInvoice(params)
    {

        if (params == 'create') {
            stepEvent = 'create';
            Swal.showLoading();
        }

        var pickNo      = $('#pick_release_no').val();
        var checkPick   = '';
        var htmlPickNo  = '<option value=""> &nbsp; </option>';

        $.each(pickReleaseNoList, function(key, val){

            if ($.trim(val.pick_release_no) == pickNo) {
                checkPick = 'selected';
            }else{
                checkPick = '';
            }

            if (params == 'create') {
                if ($.trim(val.pick_exchange_rate) <= 0 || $.trim(val.pick_exchange_date) == '') {
                    htmlPickNo += '<option value="'+val.pick_release_no+'"> '+val.pick_release_no+' </option>';
                }
            }else{
                htmlPickNo += '<option '+checkPick+' value="'+val.pick_release_no+'"> '+val.pick_release_no+' </option>';
            }
        });

        $('#pick-release-list').html(htmlPickNo);

        if (params == 'create') {
            setInterval(function(){ Swal.close(); }, 3000);
        }
    }

    function searchShortInvoice()
    {
        var pickReleaseNo = $('#pick_release_no').val();

        if (pickReleaseNo == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเลขที่ Invoice',
                showConfirmButton: true
            });
        }else{
            var HeaderID            = '';
            var pickApproveDate     = '';
            var customerID          = '';
            var customerNumber      = '';
            var customerName        = '';
            var exchangeRate        = '';
            var currency            = '';
            var pickExchangeRate    = '';
            var pickExchangeDate    = '';

            if (pickReleaseNo != '') {
                $.each(pickReleaseNoList, function(key, val){
                    if (val.pick_release_no == pickReleaseNo) {
                        HeaderID            = val.pi_header_id;
                        pickApproveDate     = val.pick_release_approve_date;
                        customerID          = val.customer_id;
                        customerNumber      = val.customer_number;
                        customerName        = val.customer_name;
                        exchangeRate        = val.exchange_rate;
                        currency            = val.currency;
                        pickExchangeRate    = val.pick_exchange_rate;
                        pickExchangeDate    = val.pick_exchange_date;
                        arCloseInterface         = val.ar_close_interface_status;
                    }
                });
            }else{
                arCloseInterface = '';
            }

            console.log(arCloseInterface);

            $('#pi_header_id').val(HeaderID);
            $('#pick_release_approve_date').val(pickApproveDate);
            $('#show_pick_release_approve_date').val(pickApproveDate);
            $('#customer_id').val(customerID);
            $('#customer_number').val(customerNumber);
            $('#customer_name').val(customerName);
            $('#exchange_rate').val(exchangeRate);
            $('#currency').val(currency);
            $('#pick_exchange_rate').val(pickExchangeRate);
            // $('#pick_exchange_date').val(pickExchangeDate);

            $("#pick_exchange_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", pickExchangeDate);
            // generatePickExchangeDate(pickExchangeDate);

            if (arCloseInterface == 'S') {
                $('#pick_exchange_rate').prop('readonly', true);
                $('#pick_exchange_date').prop('readonly', true);
            }

        }
    }

    function searchInvoice()
    {
        if ($('#pick_release_no').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเลขที่ Invoice',
                showConfirmButton: true
            });
        }else{
            swal.showLoading();

            const formData = new FormData(document.getElementById("formExchangeExport"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/exchange-export/search") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){

                    if (res.data.status == 'success') {

                        pickReleaseNoList = res.data.data;
                        Swal.close();

                    }else{
                        Swal.fire({
                            icon: 'warning',
                            text: 'ไม่พบข้อมูลที่ค้นหา',
                            showConfirmButton: true
                        });
                    }
                }
            });
        }
    }

    function updateInvoice(){
        if ($('#pick_release_no').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเลขที่ Invoice',
                showConfirmButton: true
            });
        }else if ($('#pick_exchange_rate').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาระบุอัตราแลกเปลี่ยน (ตามวันที่ในใบขน',
                showConfirmButton: true
            });
        }else if (arCloseInterface == 'S') {
            Swal.fire({
                icon: 'warning',
                text: 'เลขที่ Invoice นี้ถูกปิดการขายประจำวันแล้ว',
                showConfirmButton: true
            });
        }else{
            swal.showLoading();

            const formData = new FormData(document.getElementById("formExchangeExport"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/exchange-export/update") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){

                    if (res.data.status == 'success') {

                        pickReleaseNoList = res.data.data;

                        checkEventInvoice(stepEvent);

                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'บันทึกอัตราแลกเปลี่ยนตามวันที่ในใบขน เรียบร้อยแล้ว',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2500
                        });

                    }else{
                        Swal.fire({
                            icon: 'warning',
                            text: 'ไม่สามารถบันทึกข้อมูลนี้ได้ !!',
                            showConfirmButton: true
                        });
                    }
                }
            });
        }
    }

    function isNumber(evt)
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function generatePickExchangeDate(date, statusDis = false)
    {
        $('#html_pick_exchange_date').html('<div id="mount_pick_exchange_date"></div>');
        fieldName   = 'pick_exchange_date';
        fieldID     = 'pick_exchange_date';
        fieldValue  = date;
        mountID     = 'mount_pick_exchange_date';
        fieldDisabled   = statusDis;
        generateDatePickerTH(mountID);
    }

</script>

{{-- VUE DATE THAI --}}
<script>

    function generateDatePickerTH(mountID)
    {
        var dateFormat      = '{{ trans('date.js-format') }}';
        var vm = new Vue({
            data() {
                return {
                    pName: fieldName,
                    pID: fieldID,
                    pValue: fieldValue,
                    pFormat: dateFormat,
                    pDisabled: fieldDisabled
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
                            :disabled=pDisabled
                            :format=pFormat />`,
            methods: {
                onchangeDate (date) {
                    vm.pValue = date;
                }
            },
            watch: {
                pValue : async function (fieldValue, oldValue) {
                    // console.log('xxx', fieldValue, oldValue);
                }
            },
        }).$mount('#'+mountID)
    }

</script>
@stop
