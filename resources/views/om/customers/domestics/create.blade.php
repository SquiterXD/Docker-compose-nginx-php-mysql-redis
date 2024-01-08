@extends('layouts.app')

<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #e5e6e7 !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 2px !important;
    }

    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

    /* DATA DATE */
    .mx-datepicker .mx-input-wrapper input {
        height: auto !important;
    }

    .mx-datepicker .mx-input-wrapper .mx-icon-calendar, .mx-datepicker .mx-input-wrapper .mx-icon-clear {
        right: -15px !important;
    }

    .input-icon i {
        margin-top: 0px !important;
        font-size: 18px !important;
    }
</style>

@section('title', 'สร้างข้อมูลลูกค้า สำหรับขายในประเทศ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop


@section('page-title')
    <h2>
        OMM0005 สร้างข้อมูลลูกค้า สำหรับขายในประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>สร้างข้อมูลลูกค้า สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>สร้างข้อมูลลูกค้า สำหรับขายในประเทศ</h3>
        </div><!--ibox-title-->
        <div class="ibox-content">
            <div class="tabs-container tabs-primary-container">
                <ul class="nav nav-tabs nav-button-tabs responsive-md" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1">ข้อมูลลูกค้า</a></li>
                    <li disabled ><a href="javascript:void(0);">ชื่อเดิมร้าน</a></li>
                    <li disabled ><a href="javascript:void(0);">ผู้มีอำนาจลงนาม</a></li>
                    <li disabled ><a href="javascript:void(0);">สัญญาค้ำประกันและวงเงินเชื่อ</a></li>
                    <li disabled ><a href="javascript:void(0);">โควต้าสั่งซื้อ</a></li>
                    <li disabled ><a href="javascript:void(0);">สถานที่จัดส่งสินค้า</a></li>
                    <li disabled ><a href="javascript:void(0);">รหัสนายหน้า</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <form id="formCustomers" autocomplete="off" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row space-50 justify-content-md-center"><!--justify-content-md-center-->

                                    <div class="col-xl-12 mb-md-4">

                                        <div class="form-header-buttons">
                                            <h3 class="black">ข้อมูลลูกค้า</h3>
                                            <div class="buttons">
                                                {{-- <button class="btn btn-md btn-success w-160" type="button">สร้าง</button> --}}
                                                {{-- <button class="btn btn-lg btn-success w-160" type="button" id="buttonSaveCustomers" onclick="insertCustomers()"><i class="fa fa-plus"> สร้าง </i></button> --}}
                                                <button class="btn btn-lg btn-primary w-160" type="button" id="buttonSaveCustomers" onclick="insertCustomers()"><i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>

                                        <div class="alert alert-warning alert-dismissible print-error-msg-shipping" id="close-btn-customers" style="display: none;">
                                            <button type="button" class="close" onclick="$('#close-btn-customers').hide();">&times;</button>
                                            <h5> Warning!</h5>
                                            <ul></ul>
                                        </div>

                                    </div>
                                    <div class="col-xl-6  b-r">
                                        <div class="row space-5 ">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้า</label>
                                                    <input type="text" class="form-control" readonly name="customer_number" id="customer_number" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้าเดิมในระบบ TM</label>
                                                    <input type="text" class="form-control" name="customer_code_tm" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อลูกค้า <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="customer_name" id="customerName" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12 d-none">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทการขาย </label>
                                                    <input type="text" class="form-control" readonly name="sales_classification_code" placeholder="" value="Domestic" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทลูกค้า  <span class="red">*</span></label>
                                                    <select class="custom-select" name="customer_type_id" id="customer_type_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($typeDomestic as $item)
                                                        <option value="{{ $item->customer_type }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อย่อลูกค้า</label>
                                                    <input type="text" class="form-control" name="customer_short_name" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">อีเมล์</label>
                                                    <input type="text" class="form-control" name="contact_email" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">โทรศัพท์</label>
                                                    <input type="text" class="form-control" name="contact_phone" placeholder="" value="" maxlength="12" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">แฟกซ์</label>
                                                    <input type="text" class="form-control" name="fax_number" placeholder="" value="" maxlength="12" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ประเทศ <span class="red">*</span></label>
                                                    <div class="row space-5">
                                                        <div class="col-4">
                                                            <input type="text" class="form-control" readonly name="country_code" placeholder="" value="TH" autocomplete="off">
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" class="form-control" readonly name="country_name" placeholder="" value="THAILAND" autocomplete="off">
                                                        </div>
                                                    </div><!--row-->
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">จังหวัด <span class="red">*</span></label>

                                                    <select class="custom-select" name="province_code" id="province_code" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($provinceList as $item)
                                                        <option data-value="{{ $item['province_thai'] }}" value="{{ $item['province_id'] }}">{{ $item['province_thai'] }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="province_name" id="province_name" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ (ตาม ภพ.20) เลขที่ <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="address_line1" id="address_line1" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ซอย/ถนน <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="alley" id="alley" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">เขต/อำเภอ <span class="red">*</span></label>
                                                    <select class="custom-select" name="city" id="city" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                    </select>
                                                    <input type="hidden" name="city_code" id="city_code" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">แขวง/ตำบล <span class="red">*</span></label>
                                                    <select class="custom-select" name="district" id="district" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                    </select>
                                                    <input type="hidden" name="district_code" id="district_code" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ภูมิภาค <span class="red">*</span></label>

                                                    <select class="custom-select" name="region_code" id="region_code" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($regionList as $item)
                                                        <option value="{{ $item['region_thai'] }}">{{ $item['region_thai'] }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block"> ตลาด </label>
                                                    <select class="custom-select" name="market" id="customersMarket" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @if (!empty($marketList))
                                                        @foreach ($marketList as $item)
                                                        <option value="{{ $item->meaning }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสไปรษณีย์</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" name="postal_code" placeholder="" value="" maxlength="5" onkeypress="return isNumber(event)" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block"> Node </label>
                                                    <select class="custom-select" name="node_name" id="customersNode" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @if (!empty($nodeList))
                                                        @foreach ($nodeList as $item)
                                                        <option value="{{ $item->node_name }}">{{ $item->node_name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="row space-5 ">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">สถานะ</label>
                                                    <input type="text" class="form-control" readonly name="status" placeholder="" value="Draft">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เลขประจำตัวผู้เสียภาษี <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="taxpayer_id" id="taxpayer_id" placeholder="" value="" minlength="13" maxlength="13" onkeypress="return isNumber(event)" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เลขที่ทะเบียนการค้า <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="tax_register_number" id="tax_register_number" placeholder="" value="" maxlength="13" onkeypress="return isNumber(event)" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">Price List</label>
                                                    <select class="custom-select" name="price_list_id" id="price_list_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($priceList as $item)
                                                        <option data-value="{{ $item->name }}" value="{{ $item->list_header_id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="price_list" id="price_list" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วิธีการขนส่ง</label>

                                                    <select class="custom-select" name="shipment_by_id" id="shipment_by_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($shipmentBy as $item)
                                                        <option data-value="{{ $item->meaning }}" value="{{ $item->lookup_code }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="shipment_by" id="shipment_by" value="">

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทออเดอร์</label>
                                                    <select class="custom-select" name="order_type_id" id="order_type_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($transactionType as $item)
                                                        <option data-value="{{ $item->order_type_name }}" value="{{ $item->order_type_id }}">{{ $item->order_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="order_type" id="order_type" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วิธีการชำระเงิน</label>

                                                    <select class="custom-select" name="payment_method_id" id="payment_method_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($paymentMethod as $keyP => $item)
                                                        <option data-value="{{ $item->meaning }}" {{ $keyP == 0 ? 'selected' : '' }} value="{{ $item->lookup_code }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="payment_method" id="payment_method" value="">

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทการจ่ายเงิน</label>
                                                    <select class="custom-select" name="payment_type_id" id="payment_type_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($paymentType as $item)
                                                        <option data-value="{{ $item->meaning }}" value="{{ $item->lookup_code }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="payment_type" id="payment_type" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วันส่งบุหรี่</label>
                                                    <select class="custom-select" name="delivery_date" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($dayList as $item)
                                                        <option value="{{ $item->meaning }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">สั่งซื้อทาง</label>
                                                    <select class="custom-select" name="sales_channel_id" id="sales_channel_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($salesChannel as $item)
                                                        <option data-value="{{ $item->meaning }}" value="{{ $item->lookup_code }}" >{{ $item->description }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="sales_channel" id="sales_channel" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">วงเงินเชื่อ</label>
                                                    <input type="text" class="form-control" name="credit_limit" id="credit_limit" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่ทดลองการค้า</label>
                                                    <div class="input-icon">
                                                        {{-- <input type="text" class="form-control date" name="test_date" placeholder="" value="" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="test_date"
                                                            id="test_date"
                                                            placeholder=""
                                                            value=""
                                                            format="{{ trans("date.js-format") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่แต่งตั้งร้านค้า</label>
                                                    <div class="input-icon">
                                                        {{-- <input type="text" class="form-control date" name="begin_date" placeholder="" value="" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="begin_date"
                                                            id="begin_date"
                                                            placeholder=""
                                                            value=""
                                                            format="{{ trans("date.js-format") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ได้รับสิทธิ์เป็นร้านขายส่ง</label>
                                                    <div class="input-icon">
                                                        {{-- <input type="text" class="form-control date" name="accepted_date" placeholder="" value="" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="accepted_date"
                                                            id="accepted_date"
                                                            placeholder=""
                                                            value=""
                                                            format="{{ trans("date.js-format") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ตามหนังสือที่</label>
                                                    <input type="text" class="form-control" name="book_number" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">หนังสือลงวันที่</label>
                                                    <div class="input-icon">
                                                        {{-- <input type="text" class="form-control date" name="book_date" placeholder="" value="" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="book_date"
                                                            id="book_date"
                                                            placeholder=""
                                                            value=""
                                                            format="{{ trans("date.js-format") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ทุนจดทะเบียน</label>
                                                    <input type="text" class="form-control" name="capital" id="capital" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ธุรกิจอื่นๆ</label>
                                                    <input type="text" class="form-control" name="other_business" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">สาขา </label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="branch" id="branch" placeholder="" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="i-checks mt-2 mb-1 mr-auto">
                                                                <label class="m-0 pr-0 f13"><input type="checkbox" name="head_office_flag" id="head_office_flag"> <span>สำนักงานใหญ่ (Head Office)</span> </label>
                                                            </div>
                                                        </div>
                                                    </div><!--row-->

                                                </div><!--form-group-->
                                            </div>


                                        </div><!--row-->
                                    </div><!--col-md-6-->

                                </div><!--row-->
                            </div><!--panel-body-->
                        </form>
                    </div><!--tab-pane-->
                </div><!--tab-content-->
            </div>

        </div><!--ibox-content-->
    </div><!--ibox-->
@endsection

@section('scripts')
    <script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>

    <script>
        $(document).ready(function(){
            $('.date').datepicker();

            // $('.custom-select').chosen({width: "100%"});
            $('.custom-select').select2({width: "100%"});
        });
    </script>

    <script>
        $(".i-checks #head_office_flag").on('ifChanged', function (e) {
            if(e.target.checked == true){
                $('#branch').val('สำนักงานใหญ่');
            }else{
                $('#branch').val('');
            }
        });

        function insertCustomers()
        {
            if($('#customerName').val() == ""){
                AlertToast('','กรุณากรอกชื่อลูกค้า','error');
            }else if($('#customer_type_id').val() == ""){
                AlertToast('','กรุณาเลือกประเภทลูกค้า','error');
            }else if($('#province_code').val() == ""){
                AlertToast('','กรุณาเลือกประเภทลูกค้า','error');
            }else if($('#address_line1').val() == ""){
                AlertToast('','กรุณากรอกที่อยู่ (ตาม ภพ.20) เลขที่','error');
            }else if($('#alley').val() == ""){
                AlertToast('','กรุณากรอก ซอย/ถนน','error');
            }else if($('#city_code').val() == ""){
                AlertToast('','กรุณาเลือก เขต/อำเภอ','error');
            }else if($('#district_code').val() == ""){
                AlertToast('','กรุณาเลือก แขวง/ตำบล','error');
            }else if($('#region_code').val() == ""){
                AlertToast('','กรุณาเลือก ภูมิภาค','error');
            }else if($('#taxpayer_id').val() == ""){
                AlertToast('','กรุณากรอกเลขประจำตัวผู้เสียภาษี','error');
            }else if($('#tax_register_number').val() == ""){
                AlertToast('','กรุณากรอกเลขประจำตัวผู้เสียภาษี','error');
            }else{
                const formData = new FormData(document.getElementById("formCustomers"));
                formData.append('_token','{{ csrf_token() }}');

                $.ajax({
                    url         : '{{ url("om/ajax/customers/domestics/insert-customers") }}',
                    type        : 'post',
                    data        : formData,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    success     : function(res){
                        console.log(res);
                        var data = res.data;
                        if(data.status){
                            AlertToast('','สร้างข้อมูลลูกค้าเรียบร้อยแล้ว','success');
                            setTimeout(function() {
                                window.location = '{{ url('om/customers/domestics/detail') }}/'+data.customer_id;
                            }, 2000);
                        }else{
                            if(data.type == 'validate'){
                                printErrorMsgCustomers(data);
                            }else{
                                AlertToast('แจ้งเตือน','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                            }
                        }
                    }
                });
            }
        }

        $('#province_code').change(function()
        {
            $('#province_name').val($(this).find(':selected').data('value'));
            var id      = $('#province_code').val();
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;

            if (id == '') {
                $('#city').html('');
                $("select[name*='region_code']").val('');
                $('#region_name').val('');
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/city-list") }}/'+id+'/'+shipID,
                success : function(res){
                    city = res.data.data;
                    var html = '';
                    var checkSelect = '';
                    html += '<option value=""> &nbsp; </option>';
                    $.each(city, function(key,val){
                        html += '<option data-id="'+val.city_code+'" value="'+val.city_thai+'">'+val.city_thai+'</option>';
                    });
                    $('#city').html(html).trigger('chosen:updated');
                    // $("select[name*='region_code']").val(res.data.regionText).trigger("change");
                }
            });

        });

        $('#city').change(function()
        {
            var id      = $(this).find(':selected').data('id');
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;
            $('#city_code').val(id);

            if (id == '') {
                $('#district').html('');
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/district-list") }}/'+id+'/'+shipID,
                success : function(res){
                    tambon = res.data;
                    console.log(tambon);
                    var html = '';
                    html += '<option value=""> &nbsp; </option>';
                    $.each(tambon, function(key,val){
                        html += '<option data-id="'+val.tambon_id+'" value="'+val.tambon_thai+'">'+val.tambon_thai+'</option>';
                    });
                    $('#district').html(html).trigger('chosen:updated');
                }
            });

        });

        $('#district').change(function()
        {
            var id      = $(this).find(':selected').data('id');
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;
            $('#district_code').val(id);

            if (id == '') {
                $("input[name*='postal_code']").val('');
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/postcode") }}/'+id+'/'+shipID,
                success : function(res){
                    var postalCode = res.data;
                    $("input[name*='postal_code']").val(postalCode);
                }
            });

        });

        $('#price_list_id').change(function()
        {
            $('#price_list').val($(this).find(':selected').data('value'));
        });

        $('#order_type_id').change(function()
        {
            $('#order_type').val($(this).find(':selected').data('value'));
        });

        $('#sales_channel_id').change(function()
        {
            $('#sales_channel').val($(this).find(':selected').data('value'));
        });

        $('#payment_method_id').change(function()
        {
            $('#payment_method').val($(this).find(':selected').data('value'));
        });

        $('#shipment_by_id').change(function()
        {
            $('#shipment_by').val($(this).find(':selected').data('value'));
        });

        $('#payment_type_id').change(function()
        {
            $('#payment_type').val($(this).find(':selected').data('value'));
        });

        function isNumber(evt)
        {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function printErrorMsgCustomers(msg)
        {
            $(".print-error-msg-agent").find("ul").html('');
            $(".print-error-msg-agent").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-agent").find("ul").append('<li>'+value+'</li>');
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

        function numberFormat()
        {
            var nStr = $('#credit_limit').val();
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

        $("#credit_limit").on({
            keyup: function() {
            formatCurrency($(this));
            },
            blur: function() {
            formatCurrency($(this), "blur");
            }
        });

        $("#capital").on({
            keyup: function() {
            formatCurrency($(this));
            },
            blur: function() {
            formatCurrency($(this), "blur");
            }
        });

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") { return; }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

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
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }

        $('#customerName').change(function(){

            var id = 0;
            var customerName = $('#customerName').val();
            var shipNameStatus = true;

            if (customerName == '') {
                return false;
            }else{
                $.ajax({
                    url : '{{ url("om/ajax/customers/domestics/get-customer-name") }}/'+id,
                    success : function(res){
                        var customerNameData = '';

                        if (res.data.dataList != null) {
                            $.each(res.data.dataList, function(key,val){
                                if (val.customer_name == customerName) {
                                    shipNameStatus = false;
                                }
                            });
                        }

                        if (shipNameStatus == false) {
                            AlertToast('','ชื่อลูกค้านี้ถูกใช้งานแล้ว','error');
                            $("#buttonSaveCustomers").attr('disabled', true);
                        }else{
                            $("#buttonSaveCustomers").attr('disabled', false);
                        }
                    }
                });
            }

        });

    </script>

@stop
