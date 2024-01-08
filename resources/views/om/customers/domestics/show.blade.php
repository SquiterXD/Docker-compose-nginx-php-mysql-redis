@extends('layouts.app')

<style>
    .custom-sweetalert{
        width: 800px !important;
        font-size: 24px;
    }
    .custom-sweetalert .lead{
        text-align: left !important;
        margin-left: 60px;
        margin-right: 60px;
        font-size: 16px !important;
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

    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

    .day-amount {
        max-width: 100% !important;
        text-align: center !important;
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

    .btn-success {
        color: #fff !important;
        background-color: #1c84c6 !important;
        border-color: #1c84c6 !important;
    }
    .table-quotaheaders{
        overflow-y: auto;
        max-height: 625px;
    }
</style>

@section('title', 'ข้อมูลลูกค้า สำหรับขายในประเทศ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop


@section('page-title')
    <h2>
        OMM0007 ข้อมูลลูกค้า สำหรับขายในประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าหลัก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ข้อมูลลูกค้า สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>ข้อมูลลูกค้า สำหรับขายในประเทศ</h3>
        </div><!--ibox-title-->
        <div class="ibox-content">
            <div class="tabs-container tabs-primary-container">
                <ul class="nav nav-tabs nav-button-tabs responsive-md" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1">ข้อมูลลูกค้า</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">ชื่อเดิมร้าน</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-3">ผู้มีอำนาจลงนาม</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-4">สัญญาค้ำประกันและวงเงินเชื่อ</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-5">โควต้าสั่งซื้อ</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-6">สถานที่จัดส่งสินค้า</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-7">รหัสนายหน้า</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <form id="formCustomers" autocomplete="off" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row space-50 justify-content-md-center mt-4"><!--justify-content-md-center-->

                                    <div class="col-xl-12 mb-md-4">

                                        <div class="form-header-buttons">
                                            <h3 class="black">ข้อมูลลูกค้า</h3>
                                            <div class="buttons">
                                                {{-- <button class="btn btn-md btn-success w-160" type="button">สร้าง</button> --}}
                                                <button class="btn btn-lg btn-primary w-160" type="button" id="buttonSaveCustomers" onclick="confirmCustomers({{ $customers->customer_id }})"> <i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>

                                        <div class="alert alert-warning alert-dismissible print-error-msg-shipping" id="close-btn-shipping" style="display: none;">
                                            <button type="button" class="close" onclick="$('#close-btn-shipping').hide();">&times;</button>
                                            <h5> Warning!</h5>
                                            <ul></ul>
                                        </div>

                                    </div>
                                    <div class="col-xl-6  b-r">
                                        <div class="row space-5 ">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้า (Customer Number)</label>
                                                    <input type="text" class="form-control" readonly name="customer_number" id="customer_number" placeholder="" value="{{ $customers->customer_number }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้าเดิมในระบบ TM</label>
                                                    <input type="text" class="form-control" name="customer_code_tm" placeholder="" value="{{ $customers->customer_code_tm }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อลูกค้า <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="customer_name" id="customerName" placeholder="" value="{{ $customers->customer_name }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อย่อลูกค้า</label>
                                                    <input type="text" class="form-control" name="customer_short_name" placeholder="" value="{{ $customers->customer_short_name }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12 d-none">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทการขาย (Sales Classification)</label>
                                                    <input type="text" class="form-control" readonly name="sales_classification_code" placeholder="" value="{{ $customers->sales_classification_code }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทลูกค้า <span class="red">*</span></label>
                                                    <select class="custom-select" name="customer_type_id" id="customer_type_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($typeDomestic as $item)
                                                        <option {{ $customers->customer_type_id == $item->customer_type ? 'selected' : '' }} value="{{ $item->customer_type }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">อีเมล</label>
                                                    <input type="text" class="form-control" name="contact_email" placeholder="" value="{{ $customers->contact_email }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">โทรศัพท์</label>
                                                    <input type="text" class="form-control" name="contact_phone" placeholder="" value="{{ $customers->contact_phone }}" maxlength="12" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">แฟกซ์</label>
                                                    <input type="text" class="form-control" name="fax_number" placeholder="" value="{{ $customers->fax_number }}" maxlength="12" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ประเทศ <span class="red">*</span></label>
                                                    <div class="row space-5">
                                                        <div class="col-4">
                                                            <input type="text" class="form-control" readonly name="country_code" placeholder="" value="{{ $customers->country_code }}" autocomplete="off">
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" class="form-control" readonly name="country_name" placeholder="" value="Thailand" autocomplete="off">
                                                        </div>
                                                    </div><!--row-->
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">จังหวัด <span class="red">*</span></label>

                                                    <select class="custom-select" name="province_code" id="customersProvince" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($provinceList as $item)
                                                        <option {{ $customers->porivnce_code == $item['province_id'] ? 'selected' : '' }} data-value="{{ $item['province_thai'] }}" value="{{ $item['province_id'] }}">{{ $item['province_thai'] }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="province_name" id="customersProvinceName" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ (ตาม ภพ.20) เลขที่ <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="address_line1" id="address_line1" placeholder="" value="{{ $customers->address_line1 }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ซอย/ถนน <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="alley" id="alley" placeholder="" value="{{ $customers->alley }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">เขต/อำเภอ <span class="red">*</span></label>
                                                    <select class="custom-select" name="city" id="customersCity" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                    </select>
                                                    <input type="hidden" name="city_code" id="customersCityCode" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">แขวง/ตำบล <span class="red">*</span></label>
                                                    <select class="custom-select" name="district" id="customersDistrict" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                    </select>
                                                    <input type="hidden" name="district_code" id="customersDistrictCode" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ภูมิภาค <span class="red">*</span></label>

                                                    <select class="custom-select" name="region_code" id="customersRegion" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($regionList as $item)
                                                        <option {{ $customers->region_code == $item['region_thai'] || $customers->region_code == $item['region_id'] ? 'selected' : '' }} value="{{ $item['region_thai'] }}">{{ $item['region_thai'] }}</option>
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
                                                        <option {{ $customers->market == $item->meaning ? 'selected' : '' }} value="{{ $item->meaning }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสไปรษณีย์ <span class="red">*</span></label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" name="postal_code" id="customersPostalCode" placeholder="" value="" maxlength="5" onkeypress="return isNumber(event)" autocomplete="off">
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
                                                        <option {{ $customers->node_name == $item->node_name ? 'selected' : '' }} value="{{ $item->node_name }}">{{ $item->node_name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block"> อบจ. </label>
                                                   <input type="text" name="attribute2" class="form-control" value="{{ $customers->attribute2 }}">
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="row space-5 ">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">สถานะ</label>
                                                    <select class="custom-select" name="status" id="customerStatus" autocomplete="off">
                                                        @if ($customers->status != 'Active')
                                                        <option {{ $customers->status == 'Draft' ? 'selected' : '' }} value="Draft">Draft</option>
                                                        @endif
                                                        <option {{ $customers->status == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                                        <option {{ $customers->status == 'Inactive' ? 'selected' : '' }} value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เลขประจำตัวผู้เสียภาษี <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="taxpayer_id" id="taxpayer_id" placeholder="" value="{{ $customers->taxpayer_id }}" onkeypress="return isNumber(event)" maxlength="13" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เลขที่ทะเบียนการค้า <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="tax_register_number" id="tax_register_number" placeholder="" value="{{ $customers->tax_register_number }}" maxlength="13" onkeypress="return isNumber(event)" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">Price List</label>
                                                    <select class="custom-select" name="price_list_id" id="price_list_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($priceList as $item)
                                                        <option {{ $customers->price_list_id == $item->list_header_id ? 'selected' : '' }} data-value="{{ $item->name}}" value="{{ $item->list_header_id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="price_list" id="price_list" value="{{ $customers->price_list }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วิธีการขนส่ง</label>

                                                    <select class="custom-select" name="shipment_by_id" id="shipment_by_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($shipmentBy as $item)
                                                        <option data-value="{{ $item->meaning }}" {{ $customers->shipment_by_id == $item->lookup_code ? 'selected' : '' }} value="{{ $item->lookup_code }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="shipment_by" id="shipment_by" value="{{ $customers->shipment_by }}">

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทออเดอร์</label>
                                                    <select class="custom-select" name="order_type_id" id="order_type_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($transactionType as $item)
                                                        <option {{ $customers->order_type_id == $item->order_type_id ? 'selected' : '' }} data-value="{{ $item->order_type_name }}" value="{{ $item->order_type_id }}">{{ $item->order_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="order_type" id="order_type" value="{{ $customers->order_type }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วิธีการชำระเงิน</label>

                                                    <select class="custom-select" name="payment_method_id" id="payment_method_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($paymentMethod as $item)
                                                        <option data-value="{{ $item->meaning }}" {{ $customers->payment_method_id == $item->lookup_code ? 'selected' : '' }} value="{{ $item->lookup_code }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="payment_method" id="payment_method" value="{{ $customers->payment_method }}">

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทการจ่ายเงิน</label>
                                                    <select class="custom-select" name="payment_type_id" id="payment_type_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($paymentType as $item)
                                                        <option data-value="{{ $item->meaning }}" {{ $item->lookup_code == $customers->payment_type_id ? 'selected' : '' }} value="{{ $item->lookup_code }}">{{ $item->meaning }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="payment_type" id="payment_type" value="{{ $customers->payment_type }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วันส่งบุหรี่</label>
                                                    <select class="custom-select" name="delivery_date" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($dayList as $item)
                                                        <option {{ $customers->delivery_date == $item->meaning ? 'selected' : '' }} value="{{ $item->meaning }}">{{ $item->meaning }}</option>
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
                                                        <option {{ $customers->sales_channel_id == $item->lookup_code ? 'selected' : '' }} data-value="{{ $item->meaning }}" value="{{ $item->lookup_code }}" >{{ $item->description }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="sales_channel" id="sales_channel" value="{{ $customers->sales_channel }}">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">วงเงินเชื่อ</label>
                                                    <input type="text" class="form-control" name="credit_limit" id="credit_limit" placeholder="" value="{{ $customers->credit_limit }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่ทดลองการค้า</label>
                                                    <div class="input-icon">
                                                        {{-- <input type="text" class="form-control date" name="test_date" placeholder="" value="{{ $customers->test_date }}" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="test_date"
                                                            id="test_date"
                                                            placeholder=""
                                                            value="{{ $customers->test_date }}"
                                                            format="{{ trans("date.js-format") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่แต่งตั้งร้านค้า</label>
                                                    <div class="input-icon">
                                                        {{-- <input type="text" class="form-control date" name="begin_date" placeholder="" value="{{ $customers->begin_date }}" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="begin_date"
                                                            id="begin_date"
                                                            placeholder=""
                                                            value="{{ $customers->begin_date }}"
                                                            format="{{ trans("date.js-format") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ได้รับสิทธิ์เป็นร้านขายส่ง</label>
                                                    <div class="input-icon">
                                                        {{-- <input type="text" class="form-control date" name="accepted_date" placeholder="" value="{{ $customers->accepted_date}}" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="accepted_date"
                                                            id="accepted_date"
                                                            placeholder=""
                                                            value="{{ $customers->accepted_date }}"
                                                            format="{{ trans("date.js-format") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ตามหนังสือที่</label>
                                                    <input type="text" class="form-control" name="book_number" placeholder="" value="{{ $customers->book_number }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">หนังสือลงวันที่</label>
                                                    <div class="input-icon">
                                                        {{-- <input type="text" class="form-control date" name="book_date" placeholder="" value="{{ $customers->book_date }}" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="book_date"
                                                            id="book_date"
                                                            placeholder=""
                                                            value="{{ $customers->book_date }}"
                                                            format="{{ trans("date.js-format") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ทุนจดทะเบียน</label>
                                                    <input type="text" class="form-control" name="capital" id="capital" placeholder="" value="{{ $customers->capital }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ธุรกิจอื่นๆ</label>
                                                    <input type="text" class="form-control" name="other_business" placeholder="" value="{{ $customers->other_business }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">สาขา (Branch) </label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="branch" placeholder="" value="{{ $customers->branch }}" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="i-checks mt-2 mb-1 mr-auto">
                                                                <label class="m-0 pr-0 f13"><input type="checkbox" name="head_office_flag" {{ $customers->head_office_flag == 'Y' ? 'checked' : '' }}  autocomplete="off" ><i></i> <span>สำนักงานใหญ่ (Head Office)</span> </label>
                                                            </div>
                                                        </div>
                                                    </div><!--row-->

                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่ยกเลิกร้านค้า</label>
                                                    <div class="input-icon" id="customers_cancelled_date">
                                                        <div id="mount_customers_cancelled_date">
                                                            <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="cancelled_date"
                                                            id="cancelled_date"
                                                            placeholder=""
                                                            value="{{ $customers->cancelled_date }}"
                                                            format="{{ trans("date.js-format") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div><!--row-->
                                    </div><!--col-md-6-->

                                </div><!--row-->
                            </div><!--panel-body-->
                        </form>
                    </div><!--tab-pane-->

                    <!--================[End]ข้อมูลลูกค้า================-->

                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <form id="formCustomersPrevious" autocomplete="off" enctype="multipart/form-data">
                            <div class="panel-body">

                                <div class="row space-50 justify-content-md-center mt-4"><!--justify-content-md-center-->
                                    <div class="col-xl-12 mb-md-4">

                                        <div class="form-header-buttons">
                                            <h3 class="black">ชื่อเดิมร้าน</h3>
                                            <div class="buttons">
                                                <button class="btn btn-lg btn-default w-160" type="button" onclick="hideCustomersPrevious()"><i class="fa fa-repeat"></i><small>เคลียร์</small></button>
                                                <button class="btn btn-lg btn-success w-160" type="button" onclick="showCustomersPrevious()"> <i class="fa fa-plus"></i> สร้าง</button>
                                                <button class="btn btn-lg btn-primary w-160" type="button" onclick="updateCustomersPrevious()"> <i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="table-responsive-md">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 120px">ลำดับ</th>
                                                        <th>ชื่อเดิมร้านค้า</th>
                                                        <th>วันที่ยกเลิก</th>
                                                        <th>รายละเอียด</th>
                                                        <th>ลบ</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="previousList">
                                                    @foreach ($customersPrevious as $item)
                                                    <tr>
                                                        <td> {{ $item->previous_no }} </td>
                                                        <td class="text-left"> {{ $item->previous_name }} </td>
                                                        <td> {{ $item->cancel_date }} </td>
                                                        <td><a onclick="showPrevious({{$item->previous_id}})" ><i class="fa fa-newspaper-o"></i></td>
                                                            <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deletePrevious({{ $item->previous_id }}, {{ $item->customer_id }})"></a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div><!--table-responsive-md-->

                                        <hr class="lg">
                                    </div>

                                    <div class="col-xl-6 formPrevious" style="display: none;">
                                        <div class="row space-5">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="d-block">ลำดับที่</label>
                                                    <input type="text" class="form-control" readonly name="previous_no" placeholder="" value="" >
                                                    <input type="hidden" class="form-control" name="previous_id" id="previous_id" placeholder="" value="">
                                                    <input type="hidden" class="form-control" name="customer_id" placeholder="" value="{{ $customers->customer_id }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อเดิมของร้าน <span class="red">*</span></label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" name="previous_name" placeholder="" value="" autocomplete="off">
                                                    </div>
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่เริ่มเปลี่ยนแปลง</label>
                                                    <div class="input-icon" id="previous_start_change">
                                                        {{-- <input type="text" class="form-control date"  name="start_change_date" placeholder="" value="" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <div id="mount_previous_start_change_date"></div>
                                                        {{-- <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="start_change_date"
                                                            id="start_change_date"
                                                            placeholder=""
                                                            value=""
                                                            format="{{ trans("date.js-format") }}"> --}}
                                                    </div>
                                                    <div id="div_id" style="display: none;"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่สุดท้ายเปลี่ยนแปลง</label>
                                                    <div class="input-icon" id="previous_end_change">
                                                        {{-- <input type="text" class="form-control date"  name="end_change_date" placeholder="" value="" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <div id="mount_previous_end_change_date"></div>
                                                        {{-- <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="end_change_date"
                                                            id="end_change_date"
                                                            placeholder=""
                                                            value=""
                                                            format="{{ trans("date.js-format") }}"> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ประเทศ <span class="red">*</span></label>
                                                    <div class="row space-5">
                                                        <div class="col-4">
                                                            <input type="text" class="form-control" readonly name="country_code" id="previousCountry" placeholder="" value="TH" autocomplete="off">
                                                            {{-- <select class="custom-select" readonly name="country_code" id="previousCountry" autocomplete="off">
                                                                <option selected data-value="Thailand" value="TH">TH</option>
                                                            </select> --}}
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" class="form-control" readonly name="country_name" id="previousCountryName" placeholder="" value="Thailand" autocomplete="off">
                                                        </div>
                                                    </div><!--row-->
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">จังหวัด <span class="red">*</span></label>

                                                    <select class="custom-select" name="province_id" id="previousProvince" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($provinceList as $item)
                                                        <option {{ $item['province_id'] == $customers->province_code ? 'selected' : '' }} value="{{ $item['province_id'] }}">{{ $item['province_thai'] }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ (ตาม ภพ.20) เลขที่ <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="address" placeholder="" value="{{ $customers->address_line1 }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ซอย/ถนน <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="alley" placeholder="" value="{{ $customers->alley }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เขต/อำเภอ <span class="red">*</span></label>
                                                    <select class="custom-select" name="city" id="previousCity" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">แขวง/ตำบล <span class="red">*</span></label>
                                                    <select class="custom-select" name="district" id="previousTambon" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ภูมิภาค <span class="red">*</span></label>

                                                    <select class="custom-select" name="region_id" id="previousRegion" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($regionList as $item)
                                                        <option value="{{ $item['region_id'] }}">{{ $item['region_thai'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสไปรษณีย์ <span class="red">*</span></label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" name="postal_code" placeholder="" value="" onkeypress="return isNumber(event)" maxlength="5" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">สาเหตุการยกเลิก </label>
                                                    <input type="text" class="form-control" name="cancel_reason" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">วันที่ยกเลิก</label>
                                                    <div class="input-icon" id="previous_cancel_date">
                                                        {{-- <input type="text" class="form-control date"  name="cancel_date" placeholder="" value="" autocomplete="off">
                                                        <i class="fa fa-calendar"></i> --}}
                                                        <div id="mount_previous_cancel_date"></div>
                                                        {{-- <datepicker-th
                                                            style="width: 100%"
                                                            class="form-control md:tw-mb-0 tw-mb-2"
                                                            name="cancel_date"
                                                            id="cancel_date"
                                                            placeholder=""
                                                            value=""
                                                            format="{{ trans("date.js-format") }}"> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </div><!--col-xl-5-->
                                </div><!--row-->
                            </div><!--panel-body-->
                        </form>
                    </div><!--tab-pane-->

                    <!--================[End]ชื่อเดิมของร้าน================-->

                    <div role="tabpanel" id="tab-3" class="tab-pane">
                        <form id="formCustomersOwner" autocomplete="off" enctype="multipart/form-data">
                            <div class="panel-body">

                                <div class="row space-50 justify-content-md-center mt-4"><!--justify-content-md-center-->
                                    <div class="col-xl-12 mb-md-4">
                                        <div class="form-header-buttons">
                                            <h3 class="black">ผู้มีอำนาจลงนาม</h3>
                                            <div class="buttons">
                                                <button class="btn btn-lg btn-default w-160" type="button" onclick="hideCustomersOwner()"><i class="fa fa-repeat"></i><small>เคลียร์</small></button>
                                                <button class="btn btn-lg btn-success w-160" type="button" onclick="showCustomersOwner()"> <i class="fa fa-plus"></i> สร้าง</button>
                                                <button class="btn btn-lg btn-primary w-160" type="button" onclick="updateCustomersOwner()"> <i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="table-responsive-md">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 120px">ลำดับ</th>
                                                        <th>ผู้ทรงสิทธิ์</th>
                                                        <th>โทรศัพท์</th>
                                                        <th>สถานะ</th>
                                                        <th>รายละเอียด</th>
                                                        <th>ลบ</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="ownerList">
                                                    @foreach ($customersOwners as $item)
                                                    <tr>
                                                        <td> {{ $item->owner_no }} </td>
                                                        <td class="text-left"> {{ $item->prefix != null ? $item->prefix : '' }} {{ $item->owner_first_name }} {{ $item->owner_last_name }} </td>
                                                        <td>{{ $item->phone }}</td>
                                                        <td>{{ $item->status }}</td>
                                                        <td><a onclick="showOwner({{$item->customer_owner_id}})" ><i class="fa fa-newspaper-o"></i></td>
                                                        <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteOwner({{ $item->customer_owner_id }}, {{ $item->customer_id }})"></a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div><!--table-responsive-md-->

                                        <hr class="lg">
                                    </div>

                                    <div class="col-xl-12 formOwner" style="display: none;">
                                        <div class="row">

                                            <div class="col-xl-6 pr-5">
                                                <div class="row space-5">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="d-block">ลำดับที่</label>
                                                            <input type="text" class="form-control" readonly name="owner_no" placeholder="" value="">
                                                            <input type="hidden" class="form-control" name="customer_owner_id" id="OwnerID" placeholder="" value="">
                                                            <input type="hidden" class="form-control" name="customer_id" placeholder="" value="{{ $customers->customer_id }}">
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">คำนำหน้า</label>
                                                            <select class="custom-select" name="prefix" autocomplete="off">
                                                                <option value=""> &nbsp; </option>
                                                                @if (!$titlePrefix->isEmpty())
                                                                @foreach ($titlePrefix as $item)
                                                                <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">ชื่อผู้ทรงสิทธิ์ <span class="red">*</span></label>
                                                            <input type="text" class="form-control" name="owner_first_name" placeholder="" value="" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">นามสกุลผู้ทรงสิทธิ์ <span class="red">*</span></label>
                                                            <input type="text" class="form-control" name="owner_last_name" placeholder="" value="" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">วัน-เดือน-ปี เกิด</label>
                                                            <div class="input-icon" id="owner_birth_date">
                                                                {{-- <input type="text" class="form-control date"  name="birth_date" placeholder="" value="" autocomplete="off">
                                                                <i class="fa fa-calendar"></i> --}}
                                                                <div id="mount_owner_birth_date"></div>
                                                                {{-- <datepicker-th
                                                                    style="width: 100%"
                                                                    class="form-control md:tw-mb-0 tw-mb-2"
                                                                    name="birth_date"
                                                                    id="birth_date"
                                                                    placeholder=""
                                                                    value=""
                                                                    format="{{ trans("date.js-format") }}"> --}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">สถานภาพ</label>
                                                            <input type="text" class="form-control" name="owner_status" placeholder="" value="" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="d-block">เลขที่บัตรประชาชน <span class="red">*</span></label>
                                                            <input type="text" class="form-control" name="card_id" placeholder="" value="" minlength="13" maxlength="13" onkeypress="return isNumber(event)" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="d-block">เลขประจำตัวผู้เสียภาษี <span class="red">*</span></label>
                                                            <input type="text" class="form-control" name="taxpayer_id" placeholder="" value="" minlength="13" maxlength="13" onkeypress="return isNumber(event)" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 pl-5">
                                                <div class="row space-5">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="d-block">สถานะ</label>
                                                            <select class="custom-select" name="status" required autocomplete="off">
                                                                <option value=""> &nbsp; </option>
                                                                <option value="Active">Active</option>
                                                                <option value="Inactive">Inactive</option>
                                                            </select>
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">โทรศัพท์</label>
                                                            <input type="text" class="form-control" name="phone" placeholder="" value="" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">แฟกซ์</label>
                                                            <input type="text" class="form-control" name="fax_number" placeholder="" value="" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">มือถือ</label>
                                                            <input type="text" class="form-control" name="mobile_number" placeholder="" value="" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">อีเมล</label>
                                                            <input type="email" class="form-control" name="owner_email" placeholder="" value="" autocomplete="off">
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="d-block">ประเภทธุรกิจ <span class="red">*</span></label>

                                                            <div class="d-md-flex">
                                                                <div class="i-checks">
                                                                    <label><input type="radio" value="บุคคลธรรมดา" name="owner_type"><span>บุคคลธรรมดา</span></label>
                                                                </div>
                                                                <div class="i-checks">
                                                                    <label><input type="radio" value="นิติบุคคล" name="owner_type"><span>นิติบุคคล</span></label>
                                                                </div>
                                                                <div class="i-checks">
                                                                    <label><input type="radio" value="สโมสร" name="owner_type"><span>สโมสร</span></label>
                                                                </div>
                                                                <div class="i-checks">
                                                                    <label><input type="radio" value="สหกรณ์" name="owner_type"><span>สหกรณ์</span></label>
                                                                </div>
                                                            </div>
                                                        </div><!--form-group-->
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="d-block">วันที่เปลี่ยนแปลงสถานภาพ</label>
                                                            <div class="input-icon" id="owner_change_date">
                                                                {{-- <input type="text" class="form-control date"  name="owner_change_date" placeholder="" value="" autocomplete="off">
                                                                <i class="fa fa-calendar"></i> --}}
                                                                <div id="mount_owner_owner_change_date"></div>
                                                                {{-- <datepicker-th
                                                                    style="width: 100%"
                                                                    class="form-control md:tw-mb-0 tw-mb-2"
                                                                    name="owner_change_date"
                                                                    id="owner_change_date"
                                                                    placeholder=""
                                                                    value=""
                                                                    format="{{ trans("date.js-format") }}"> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div><!--row-->
                                    </div><!--col-xl-5-->
                                </div><!--row-->
                            </div><!--panel-body-->
                        </form>
                    </div><!--tab-pane-->

                    <!--================[End] ผู้มีอำนาจลงนาม ================-->

                    <div role="tabpanel" id="tab-4" class="tab-pane">
                        <div class="panel-body">

                            <div class="row space-50 justify-content-md-center mt-4"><!--justify-content-md-center-->
                                <div class="col-10">
                                    <div class="col-xl-12 m-auto">
                                        <div class="form-header-buttons">
                                            <h3 class="black">สัญญาค้ำประกันและวงเงินเชื่อ</h3>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                    </div>

                                    <div class="col-xl-12 m-auto">
                                        <div class="row space-5">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้า</label>
                                                    <input type="text" class="form-control" readonly name="" id="customer_number_contract" placeholder="" value="{{ !empty($customers->customer_number) ? $customers->customer_number : '' }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-8s">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อลูกค้า</label>
                                                    <input type="text" class="form-control" disabled name="" placeholder="" value="{{ $customers->customer_name }}">
                                                </div><!--form-group-->
                                            </div>
                                        </div><!--row-->

                                        <hr class="lg">
                                    </div><!--col-xl-12-->

                                    <div class="col-xl-12 m-auto">
                                        <div class="form-header-buttons">
                                            <h3 class="black">สัญญาเงินเชื่อ</h3>
                                            <div class="buttons">
                                                <button class="btn btn-md btn-success w-160" type="button" onclick="addInputContract()"> <i class="fa fa-plus"></i> สร้าง</button>
                                                <button class="btn btn-md btn-primary w-160" type="button" onclick="insertContracts()" id="btn_update_contracts"> <i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                    </div>

                                    <div class="col-xl-12 m-auto">
                                        <form id="formContract" autocomplete="off" enctype="multipart/form-data">
                                            <div class="table-responsive-md">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>สัญญาเงินเชื่อ</th>
                                                            <th>วันเริ่ม</th>
                                                            <th>วันสิ้นสุด</th>
                                                            <th>จำนวนวงเงินสัญญา</th>
                                                            <th style="width: 45px">ลบ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="formContract" id="tbContract">
                                                        @foreach ($customerContracts as $item)
                                                        <tr id="contract_roll_c{{ $item->contract_id }}" class="contract_del_all {{ $item->color_button }}">
                                                            <td>
                                                                <input type="hidden"  name="contract_id[c{{ $item->contract_id }}]" value="{{ $item->contract_id }}">
                                                                <input type="hidden"  name="customer_id" value="{{ $customers->customer_id }}">
                                                                <input type="hidden"  name="manage_customer_contracts[]" id="manage_customer_contracts_{{ $item->contract_id }}" value="{{ $item->contract_id }}">
                                                                <input type="text" class="form-control no-line" placeholder="ระบุเลขที่สัญญา..." name="contract_number[c{{ $item->contract_id }}]" value="{{ $item->contract_number }}" autocomplete="off">
                                                            </td>
                                                            <td>
                                                                <div class="input-icon">
                                                                    {{-- <input type="text" class="form-control no-line mw-120 date" name="start_date[c{{ $item->contract_id }}]" placeholder="ระบุวันที่..." value="{{ $item->start_date }}" autocomplete="off">
                                                                    <i class="fa fa-calendar"></i> --}}
                                                                    <datepicker-th
                                                                        style="width: 100%"
                                                                        class="form-control md:tw-mb-0 tw-mb-2"
                                                                        name="start_date[c{{ $item->contract_id }}]"
                                                                        id="contract_start_date_c{{ $item->contract_id }}"
                                                                        placeholder="ระบุวันที่..."
                                                                        value="{{ $item->start_date }}"
                                                                        format="{{ trans("date.js-format") }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-icon">
                                                                    {{-- <input type="text" class="form-control no-line mw-120 date" name="end_date[c{{ $item->contract_id }}]" placeholder="ระบุวันที่..." value="{{ $item->end_date }}" autocomplete="off">
                                                                    <i class="fa fa-calendar"></i> --}}
                                                                    <datepicker-th
                                                                        style="width: 100%"
                                                                        class="form-control md:tw-mb-0 tw-mb-2"
                                                                        name="end_date[c{{ $item->contract_id }}]"
                                                                        id="contract_end_date_c{{ $item->contract_id }}"
                                                                        placeholder="ระบุวันที่..."
                                                                        value="{{ $item->end_date }}"
                                                                        format="{{ trans("date.js-format") }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control no-line mw-150 pr-0 text-right ml-auto" name="guarantee_amount[c{{ $item->contract_id }}]" id="guarantee_amount_{{ $item->contract_id }}" placeholder="ระบุวงเงิน.." value="{{ $item->guarantee_amount }}" onkeypress="return isNumber(event)" onkeyup="convertGuarantee({{ $item->contract_id }})" autocomplete="off">
                                                            </td>
                                                            <td class="text-center"><a class="fa fa-times red" onclick="deleteContract({{ $item->contract_id }}, {{ $item->customer_id }})" href="javascript:(0);"></a></td>
                                                        </tr>

                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div><!--table-responsive-md-->
                                        </form>

                                        <hr class="lg">
                                    </div><!--col-xl-12-->

                                    <div class="col-xl-12 m-auto">
                                        <div class="form-header-buttons">
                                            <h3 class="black">หนังสือค้ำประกัน</h3>
                                            <div class="buttons">
                                                <button class="btn btn-md btn-success w-160" type="button" onclick="addInputContractBook()"> <i class="fa fa-plus"></i> สร้าง</button>
                                                <button class="btn btn-md btn-primary w-160" type="button" onclick="insertContractBooks()" id="button_update_contrac_books"> <i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                    </div>

                                    <div class="col-xl-12 m-auto">
                                        <form id="formContractBook" autocomplete="off" enctype="multipart/form-data">
                                            {{-- <h3 class="mb-2">เลขที่สัญญาค้ำประกัน</h3> --}}
                                            <div class="table-responsive-md">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>เลขที่หนังสือค้ำประกัน</th>
                                                            <th>วันเริ่ม</th>
                                                            <th>วันสิ้นสุด</th>
                                                            <th>วงเงินค้ำประกันธนาคาร</th>
                                                            <th style="width: 45px">ลบ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="formContractBook" id="tbContractBook">
                                                        @foreach ($customerContractBooks as $item)
                                                        <tr id="contract_book_roll_b{{ $item->contract_book_id }}" class="contract_book_del_all {{ $item->color_button }}">
                                                            <td>
                                                                <input type="hidden"  name="contract_book_id[b{{ $item->contract_book_id }}]" value="{{ $item->contract_book_id }}">
                                                                <input type="hidden" name="customer_id" value="{{ $customers->customer_id }}">
                                                                <input type="text" class="form-control no-line" placeholder="ระบุเลขที่สัญญา..." name="book_number[b{{ $item->contract_book_id }}]" id="book_number_{{ $item->contract_book_id }}" value="{{ $item->book_number }}" autocomplete="off">
                                                            </td>
                                                            <td>
                                                                <div class="input-icon">
                                                                    {{-- <input type="text" class="form-control no-line mw-120 date" name="book_start_date[b{{ $item->contract_book_id }}]" id="book_start_date_{{ $item->contract_book_id }}" placeholder="ระบุวันที่..." value="{{ $item->book_start_date }}" autocomplete="off">
                                                                    <i class="fa fa-calendar"></i> --}}
                                                                    <datepicker-th
                                                                        style="width: 100%"
                                                                        class="form-control md:tw-mb-0 tw-mb-2 {{ $item->color_button }}"
                                                                        name="book_start_date[b{{ $item->contract_book_id }}]"
                                                                        id="book_start_date_b{{ $item->contract_book_id }}"
                                                                        placeholder="ระบุวันที่..."
                                                                        value="{{ $item->book_start_date }}"
                                                                        format="{{ trans("date.js-format") }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-icon">
                                                                    {{-- <input type="text" class="form-control no-line mw-120 date" name="book_end_date[b{{ $item->contract_book_id }}]" id="book_end_date_{{ $item->contract_book_id }}" placeholder="ระบุวันที่..." value="{{ $item->book_end_date }}" autocomplete="off">
                                                                    <i class="fa fa-calendar"></i> --}}
                                                                    <datepicker-th
                                                                        style="width: 100%"
                                                                        class="form-control md:tw-mb-0 tw-mb-2 {{ $item->color_button }}"
                                                                        name="book_end_date[b{{ $item->contract_book_id }}]"
                                                                        id="book_end_date_b{{ $item->contract_book_id }}"
                                                                        placeholder="ระบุวันที่..."
                                                                        value="{{ $item->book_end_date }}"
                                                                        format="{{ trans("date.js-format") }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control no-line mw-150 pr-0 text-right ml-auto" name="credit_limit[b{{ $item->contract_book_id }}]" id="book_credit_limit_{{ $item->contract_book_id }}" placeholder="ระบุวงเงินค้ำประกัน..." value="{{ $item->credit_limit }}" onkeypress="return isNumber(event)" onkeyup="convertCreditLimit({{ $item->contract_book_id }})" autocomplete="off">
                                                            </td>
                                                            <td class="text-center"><a class="fa fa-times  red" onclick="deleteContractBook({{ $item->contract_book_id }}, {{ $item->customer_id }})" href="javascript:(0);"></a></td>
                                                        </tr>

                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div><!--table-responsive-md-->

                                            <hr class="lg">
                                        </form>
                                    </div><!--col-xl-12-->

                                    <div class="col-xl-12 m-auto">
                                        <div class="form-header-buttons">
                                            <h3 class="black">กลุ่มวงเงินเชื่อ</h3>
                                            <div class="buttons">
                                                <button class="btn btn-md btn-success w-160" type="button" id="buttonAddInputContractGroup" onclick="addInputContractGroup()"> <i class="fa fa-plus"></i> สร้าง</button>
                                                <button class="btn btn-md btn-primary w-160" type="button" onclick="insertContractGroups()" id="btn_update_contract_groups"> <i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                    </div>

                                    <div class="col-xl-12 m-auto">
                                        <form id="formContractGroup" autocomplete="off" enctype="multipart/form-data">
                                            <div class="table-responsive-md">
                                                <table class="table table-bordered text-center" id="tableContractGroup">
                                                    <thead>
                                                        <tr>
                                                            <th>กลุ่มวงเงินเชื่อ</th>
                                                            <th>% เงินเชื่อ</th>
                                                            <th>จำนวนวงเงิน</th>
                                                            <th>จำนวนวันที่เชื่อ</th>
                                                            <th style="width: 45px">ลบ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="formContractGroup" id="tbContractGroup">
                                                        @foreach ($customerContractGroups as $item)
                                                        <tr id="contract_group_roll_g{{ $item->contract_group_id }}" class="contract_group_del_all">
                                                            <td>
                                                                <input type="hidden"  name="contract_group_id[g{{ $item->contract_group_id }}]" value="{{ $item->contract_group_id }}">
                                                                <input type="hidden" name="customer_id" value="{{ $customers->customer_id }}">
                                                                <select class="custom-select no-line mw-120 select-group-code" name="select_credit_group_code[g{{ $item->contract_group_id }}]" id="select_credit_group_code_{{ $item->contract_group_id }}" onchange="selectCreditGroupCode({{ $item->contract_group_id }})">
                                                                    <option value=""> &nbsp; </option>

                                                        @foreach ($creditGroup as $itemGroup)
                                                            @if ($customers->customer_type_id == 20)
                                                                @if ($itemGroup->lookup_code == 3)
                                                                    <option {{ $itemGroup->lookup_code == $item->credit_group_code ? 'selected' : '' }} data-day="{{ $itemGroup->tag }}" value="{{ $itemGroup->lookup_code }}">{{ $itemGroup->lookup_code }}</option>
                                                                @endif
                                                            @else
                                                                <option {{ $itemGroup->lookup_code == $item->credit_group_code ? 'selected' : '' }} data-day="{{ $itemGroup->tag }}" value="{{ $itemGroup->lookup_code }}">{{ $itemGroup->lookup_code }}</option>
                                                            @endif
                                                        @endforeach

                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="credit_group_code[g{{ $item->contract_group_id }}]" id="credit_group_code_{{ $item->contract_group_id }}" value="{{ $item->credit_group_code }}">
                                                                <input type="text" class="form-control no-line" name="credit_percentage[g{{ $item->contract_group_id }}]" id="credit_percentage_{{ $item->contract_group_id }}" placeholder="% เงินเชื่อ" required onkeypress="return isNumber(event)" autocomplete="off" maxlength="3" value="{{ $item->credit_percentage }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control no-line" name="credit_amount[g{{ $item->contract_group_id }}]" id="credit_amount_{{ $item->contract_group_id }}" placeholder="จำนวนวงเงิน" required onkeypress="return isNumber(event)" onkeyup="convertGroupCreditAmount({{ $item->contract_group_id }})" autocomplete="off" value="{{ $item->credit_amount }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control no-line mw-120 day-amount" readonly name="day_amount[g{{ $item->contract_group_id }}]" id="day_amount_{{ $item->contract_group_id }}" placeholder="จำนวนวันที่เชื่อ" autocomplete="off" value="{{ $item->day_amount }}">
                                                            </td>
                                                            <td class="text-center"><a class="fa fa-times red" onclick="deleteContractGroup({{ $item->contract_group_id }},{{ $item->customer_id }});" href="javascript:(0);"></a></td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>รวมวงเงินเชื่อ</strong>
                                                            </td>
                                                            <td class="text-right"><strong id="resultCredit">{{ $contractGroupCount }}</strong></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div><!--table-responsive-md-->
                                        </form>
                                    </div><!--col-xl-12-->
                                </div>
                            </div><!--row-->
                        </div><!--panel-body-->
                    </div><!--tab-pane-->

                    <!--================[End]สัญญาค้ำประกันและวงเงินเชื่อ================-->

                    <div role="tabpanel" id="tab-5" class="tab-pane">
                        <div class="panel-body">
                            <form id="formCustomersQuota" autocomplete="off" enctype="multipart/form-data">
                                <div class="row space-50 justify-content-md-center flex-column mt-4"><!--justify-content-md-center-->
                                    <div class="col-xl-10 m-auto">
                                        <div class="form-header-buttons">
                                            <h3 class="m-0 black">โควต้าสั่งซื้อ</h3>
                                            <div class="buttons">
                                                <button class="btn btn-md btn-default w-160" type="button" onclick="hideCustomersQuota()"><i class="fa fa-repeat"></i><small>เคลียร์</small></button>
                                                <button class="btn btn-md btn-success w-160" type="button" onclick="showCustomersQuota()"> <i class="fa fa-plus"></i> สร้าง</button>
                                                <button class="btn btn-md btn-primary w-160" type="button" id="buttonSaveQuota" onclick="updateCustomersQuota()"> <i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                    </div>
                                    <div class="col-xl-10 m-auto">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้า</label>
                                                    <input type="hidden" class="form-control" readonly name="" placeholder="" value="{{ $customers->customer_id }}">
                                                    <input type="text" class="form-control" readonly name="" id="customer_number_quota" value="{{ !empty($customers->customer_number) ? $customers->customer_number : '' }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อลูกค้า</label>
                                                    <input type="text" class="form-control" disabled name="" placeholder="" value="{{ $customers->customer_name }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="table-responsive-md mt-2 mb-2 table-quotaheaders">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>ลำดับ</th>
                                                                <th>วันเริ่ม</th>
                                                                <th>วันสิ้นสุด</th>
                                                                <th>สถานะ</th>
                                                                <th>รายละเอียด</th>
                                                                <th style="width: 45px">ลบ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="quotaList">
                                                            @foreach ($customerQuotaHeaders as $key => $item)
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $item->start_date }}</td>
                                                                <td>{{ $item->end_date }}</td>
                                                                <td>{{ $item->status }}</td>
                                                                <td><a onclick="showQuotaHeaders({{ $item->quota_header_id }})" ><i class="fa fa-newspaper-o"></i></td>
                                                                <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteQuota({{ $item->quota_header_id }}, {{ $item->customer_id }});"></a></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div><!--table-responsive-md-->
                                            </div>

                                            <div class="col-md-6 formQuota pr-3" style="display: none;">

                                                <div class="form-group">

                                                    <div class="row align-items-center space-5">
                                                        <div class="col-md-5">
                                                            <label class="d-block">วันที่ใช้งาน</label>
                                                            <div class="input-icon" id="qouta_start_date">
                                                                {{-- <input type="text" class="form-control date" name="start_date" id="quotaStart" placeholder="" value="" onchange="checkQuotaDate()" autocomplete="off"> --}}
                                                                {{-- <i class="fa fa-calendar"></i> --}}
                                                                <div id="mount_quota_start_date"></div>
                                                                {{-- <datepicker-th
                                                                    style="width: 100%"
                                                                    class="form-control md:tw-mb-0 tw-mb-2"
                                                                    name="start_date"
                                                                    id="quotaStart"
                                                                    placeholder=""
                                                                    value=""
                                                                    format="{{ trans("date.js-format") }}"> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 text-center">ถึง</div>

                                                        <div class="col-md-5">
                                                            <label class="d-block">วันที่สิ้นสุด</label>
                                                            <div class="input-icon" id="qouta_end_date">
                                                                {{-- <input type="text" class="form-control date" name="end_date" id="quotaEnd" placeholder="" value="" onchange="checkQuotaDate()" autocomplete="off"> --}}
                                                                {{-- <i class="fa fa-calendar"></i> --}}
                                                                <div id="mount_quota_end_date"></div>
                                                                {{-- <datepicker-th
                                                                    style="width: 100%"
                                                                    class="form-control md:tw-mb-0 tw-mb-2"
                                                                    name="end_date"
                                                                    id="quotaEnd"
                                                                    placeholder=""
                                                                    value=""
                                                                    format="{{ trans("date.js-format") }}"> --}}
                                                            </div>
                                                        </div>

                                                    </div><!--row-->

                                                </div><!--form-group-->

                                            </div>

                                            <div class="col-md-6 formStatusQuota pl-3" style="display: none;">
                                                <div class="form-group">
                                                    <label class="d-block">สถานะ</label>
                                                    <select class="custom-select" name="status" id="quotar-status" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                    <input type="hidden" name="quota_header_id" id="QuotaID" value="">
                                                    <input type="hidden" class="form-control" name="customer_id" id="quotaCustomerID" value="{{ $customers->customer_id }}">
                                                </div><!--form-group-->
                                            </div>

                                        </div><!--row-->
                                    </div><!--col-xl-6-->

                                    <div class="col-xl-12 m-auto formTablesQuota" style="display: none;">
                                        <hr class="lg">
                                        <div class="form-header-buttons">
                                            <div class="buttons">
                                                <button class="btn btn-md btn-success w-160" type="button" onclick="addInputLinesItems()"> <i class="fa fa-plus"></i> สร้าง</button>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="table-responsive-md">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">รหัสผลิตภัณฑ์</th>
                                                        <th class="align-middle w-250">ชื่อผลิตภัณฑ์</th>
                                                        <th>โควต้าที่ได้รับ<br><small>บุหรี่ หน่วย พันมวน/ยาเส้น หน่วย ซอง</small></th>
                                                        <th>ยอดสั่งซื้อขั้นต่ำ<br><small>บุหรี่ หน่วย พันมวน/ยาเส้น หน่วย ซอง</small></th>
                                                        <th>โควต้าคงเหลือ<br><small>บุหรี่ หน่วย พันมวน/ยาเส้น หน่วย ซอง</small></th>
                                                        <th class="align-middle">ลบ</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="quotaLines">
                                                </tbody>
                                                <tbody id="quotaLinesLists">
                                                </tbody>
                                            </table>
                                        </div><!--table-responsive-md-->
                                    </div><!--col-xl-12-->
                                </div><!--row-->
                            </form>
                        </div><!--panel-body-->
                    </div><!--tab-pane-->

                    <!--================[End]โควต้าสั่งซื้อ================-->

                    <div role="tabpanel" id="tab-6" class="tab-pane">
                        <form id="formCustomersShipSites" autocomplete="off" enctype="multipart/form-data">
                            <div class="panel-body">

                                <div class="row space-50 justify-content-md-center flex-column mt-4"><!--justify-content-md-center-->
                                    <div class="col-xl-10 m-auto">
                                        <div class="form-header-buttons">
                                            <h3 class="m-0 black">สถานที่จัดส่งสินค้า</h3>
                                            <div class="buttons">
                                                <button class="btn btn-md btn-default w-160" type="button" onclick="hideCustomersShipSites()"><i class="fa fa-repeat"></i><small>เคลียร์</small></button>
                                                <button class="btn btn-md btn-success w-160" type="button" onclick="showCustomersShipSites()"> <i class="fa fa-plus"></i> สร้าง</button>
                                                <button class="btn btn-md btn-primary w-160" type="button" id="btnUpdateShipsite" onclick="updateCustomersShipSites()"> <i class="fa fa-save"></i> บันทึก</button>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                    </div>
                                    <div class="col-xl-10 m-auto">
                                        {{-- <h3 class="mb-3 black">สถานที่จัดส่งสินค้า</h3> --}}
                                        <div class="row space-5">
                                            <div class="col-md-12 d-none">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้า</label>
                                                    <input type="text" class="form-control" readonly name="customer_number" id="ship_site_customer_number" value="{{ !empty($customers->customer_number) ? $customers->customer_number : '' }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12 d-none">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อลูกค้า</label>
                                                    <input type="text" class="form-control" disabled name="customer_name" value="{{ $customers->customer_name }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="table-responsive-md mt-2 mb-2">
                                                    <input type="hidden" class="form-control" readonly name="customer_id" id="ship_site_customer_id" value="{{ $customers->customer_id }}">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>ลำดับ</th>
                                                                <th>ชื่อสถานที่ส่ง</th>
                                                                <th>สถานะ</th>
                                                                <th>รายละเอียด</th>
                                                                <th>สถานที่จัดส่งหลัก</th>
                                                                {{-- <th style="width: 45px">ลบ</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody id="shipSiteList">
                                                            @foreach ($customerShipSites as $item)
                                                            <tr>
                                                                <td> {{ $item->site_no }} </td>
                                                                <td> {{ $item->ship_to_site_name }} </td>
                                                                <td> {{ $item->status }}</td>
                                                                <td><a onclick="showShipSites({{$item->ship_to_site_id}})" ><i class="fa fa-newspaper-o"></i></td>
                                                                <td class="text-center">
                                                                    <div class="i-checks mt-2 mb-1 mr-auto">
                                                                        <input type="checkbox"  class="checksite" name="shipattribute1" {{ $item->attribute1 == 'Y' ? 'checked' : '' }}  autocomplete="off" disabled>
                                                                    </div>
                                                                </td>
                                                                {{-- <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteShipSite({{ $item->ship_to_site_id }}, {{ $item->customer_id }});"></a></td> --}}
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div><!--table-responsive-md-->
                                            </div>

                                            <div class="col-12">
                                                <hr>
                                            </div>
                                            <div class="col-12 formShipSite" style="display: none;">

                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="form-group mx-3">
                                                            <div class="row space-5">
                                                                <div class="col-5">
                                                                    <div class="form-group">
                                                                        <label class="d-block">ลำดับสถานที่ส่ง</label>
                                                                        <input type="text" class="form-control" readonly name="site_no" placeholder="" value="" autocomplete="off">
                                                                        <input type="hidden" class="form-control" name="ship_to_site_id" id="shipSitesID" placeholder="" value="0">
                                                                    </div><!--form-group-->
                                                                </div>

                                                                <div class="col-7">
                                                                    <div class="form-group">
                                                                        <label class="d-block">ชื่อสถานที่ส่ง <span class="red">*</span></label>
                                                                        <input type="text" class="form-control" name="ship_to_site_name" id="ship_to_site_name" placeholder="" value="{{ $customers->customer_name }}" autocomplete="off">
                                                                    </div><!--form-group-->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="d-block">ชื่อผู้ติดต่อ</label>
                                                                <input type="text" class="form-control" name="ship_contact_name" placeholder="" value="" autocomplete="off">
                                                            </div><!--form-group-->
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="d-block">ตำแหน่ง</label>
                                                                <input type="text" class="form-control" name="ship_contact_position" placeholder="" value="" autocomplete="off">
                                                            </div><!--form-group-->
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="d-block">ประเทศ (Country) <span class="red">*</span></label>
                                                                <div class="row space-5">
                                                                    <div class="col-4">
                                                                        {{-- <select class="custom-select" name="country_code" id="shipSitesCountry" autocomplete="off">
                                                                            <option selected="selected" readonly data-value="Thailand" value="TH">TH</option>
                                                                        </select> --}}
                                                                        <input type="text" class="form-control" readonly name="country_code" id="shipSitesCountry" readonly value="TH" autocomplete="off">
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <input type="text" class="form-control" readonly name="country_name" id="shipSitesCountryName" placeholder="" value="Thailand" autocomplete="off">
                                                                    </div>
                                                                </div><!--row-->
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="d-block">จังหวัด (Province) <span class="red">*</span></label>

                                                                <select class="custom-select" name="province_id" id="shipSitesProvince" autocomplete="off">
                                                                    <option value=""> &nbsp; </option>
                                                                    @foreach ($provinceList as $item)
                                                                    <option {{ $item['province_id'] == $customers->province_code ? 'selected' : '' }} data-value="{{ $item['province_thai'] }}" value="{{ $item['province_id'] }}">{{ $item['province_thai'] }}</option>
                                                                    @endforeach
                                                                </select>

                                                                <input type="hidden" name="province_name" id="shipsitesProvinceName" value="">

                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="d-block">ที่อยู่ (ตาม ภพ.20) เลขที่ <span class="red">*</span></label>
                                                                <input type="text" class="form-control" name="address_line1" placeholder="" value="{{ $customers->address_line1 }}" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="d-block">ซอย/ถนน <span class="red">*</span></label>
                                                                <input type="text" class="form-control" name="alley" placeholder="" value="{{ $customers->alley }}" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mx-3">
                                                            <div class="row space-5">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="d-block">เขต/อำเภอ <span class="red">*</span></label>
                                                                        <select class="custom-select" name="city" id="shipSitesCity" autocomplete="off">
                                                                            <option value=""> &nbsp; </option>
                                                                        </select>
                                                                        <input type="hidden" name="city_code" id="shipsitesCityCode" value="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="d-block">แขวง/ตำบล <span class="red">*</span></label>
                                                                        <select class="custom-select" name="district" id="shipSitesDistrict" autocomplete="off">
                                                                            <option value=""> &nbsp; </option>
                                                                        </select>
                                                                        <input type="hidden" name="district_code" id="shipsitesDistrictCode" value="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="d-block">ภูมิภาค <span class="red">*</span></label>

                                                                        <select class="custom-select" name="region_code" id="shipSitesRegion" autocomplete="off">
                                                                            <option value=""> &nbsp; </option>
                                                                            @foreach ($regionList as $item)
                                                                            <option data-value="{{ $item['region_thai'] }}" data-id="{{ $item['region_id'] }}" value="{{ $item['region_thai'] }}">{{ $item['region_thai'] }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                        <input type="hidden" name="region_id" id="shipsitesRegionID" value="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="d-block">รหัสไปรษณีย์ <span class="red">*</span></label>
                                                                        <div class="input-icon">
                                                                            <input type="text" class="form-control" name="postal_code" placeholder="" value="" onkeypress="return isNumber(event)" maxlength="5" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-5">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="d-block">สถานะ</label>
                                                                <select class="custom-select" name="status" autocomplete="off">
                                                                    <option value=""> &nbsp; </option>
                                                                    <option selected value="Active">Active</option>
                                                                    <option value="Inactive">Inactive</option>
                                                                </select>
                                                            </div><!--form-group-->
                                                        </div>

                                                        <div class="col-md-12 mt-5">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="i-checks ml-3">
                                                                        <label class="m-0 pr-0 f13"><input type="checkbox" name="attribute1" autocomplete="off" ><i></i> <span class="text-danger">สถานที่จัดส่งหลัก</span> </label>
                                                                    </div>
                                                                </div><!--row-->

                                                            </div><!--form-group-->
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div><!--row-->
                                    </div><!--col-xl-6-->
                                </div><!--row-->
                            </div><!--panel-body-->
                        </form>
                    </div><!--tab-pane-->

                    <!--================[End]สถานที่จัดส่งสินค้า================-->

                    <div role="tabpanel" id="tab-7" class="tab-pane">
                        <div class="panel-body">

                            <div class="row space-50 justify-content-md-center mt-4"><!--justify-content-md-center-->
                                <div class="col-xl-6">
                                    <h3 class="mb-3 black">รหัสนายหน้า </h3>
                                    <div class="row space-5">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block">รหัสลูกค้า</label>
                                                <input type="hidden" class="form-control" disabled name="customer_id" placeholder="" value="{{ $customers->customer_id }}" autocomplete="off">
                                                <input type="text" class="form-control" readonly name="" id="customer_number_agent" placeholder="" value="{{ !empty($customers->customer_number) ? $customers->customer_number : '' }}" autocomplete="off">
                                            </div><!--form-group-->
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block">ชื่อลูกค้า</label>
                                                <input type="text" class="form-control" disabled name="customer_name" placeholder="" value="{{ $customers->customer_name }}" autocomplete="off">
                                            </div><!--form-group-->
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block">รหัสนายหน้า</label>
                                                <input type="text" class="form-control" disabled name="" placeholder="" value="{{ !empty($agentVendor->vendor_code) ? $agentVendor->vendor_code : '' }} {{ !empty($agentVendor->vendor_name) ? $agentVendor->vendor_name : '' }}" autocomplete="off">
                                            </div><!--form-group-->
                                        </div>

                                        @if (!empty($accountMapping))
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block">GL Code</label>
                                                <div class="row space-5">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" disabled name="account_code" placeholder="" value="{{ $accountMapping->account_code }}">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" disabled name="account_combine" placeholder="" value="{{ $accountMapping->account_combine }}">
                                                    </div>
                                                </div>
                                            </div><!--form-group-->
                                        </div>
                                        @else
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="d-block">GL Code</label>
                                                <div class="row space-5">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" disabled name="account_code" placeholder="" value="">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" disabled name="account_combine" placeholder="" value="">
                                                    </div>
                                                </div>
                                            </div><!--form-group-->
                                        </div>
                                        @endif

                                    </div><!--row-->
                                </div><!--col-xl-6-->
                            </div><!--row-->
                        </div><!--panel-body-->
                    </div><!--tab-pane-->

                    <!--================[End]สถานที่จัดส่งสินค้า================-->

                </div><!--tab-content-->
            </div><!--tabs-primary-container-->
        </div><!--ibox-content-->
    </div><!--ibox-->
@endsection

@section('scripts')
    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
    <script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>

    <script>
        $(document).ready(function(){
            $('.date').datepicker();
            window.onload = showCustomers();
            window.onload = $('#credit_limit').trigger("keyup");
            window.onload = $('#capital').trigger("keyup");

            $('.custom-select').select2({width: "100%"});
        });
    </script>

    <script>
        var customerPrevious    = [];
        var customers           = '{{ $customers }}';
        var shipSites           = [];
        var customer_id         = '{{ $customers->customer_id }}';
        var roll                = 1;
        var rollContract        = 1;
        var rollContractBook    = 1;
        var rollContractGroup   = 1;
        let sequenceEcomsList   = {!! json_encode($sequenceEcoms) !!};
        var creditGroup         = @json($creditGroup);

        // DATE PICKER TH SET DAFAULT CONFIG
        var contractsName       = '';
        var contractsID         = '';
        var contractsValue      = '';
        var mountID             = '';
        var shipSiteMnage       = 'clear';

        function confirmCustomers(id)
        {
            if(id <= 0){
                AlertToast('','ไม่มีข้อมูลสำหรับการอัพเดท','error');
                return false;
            }

            if($('#customerName').val() == ""){
                AlertToast('','กรุณากรอกชื่อลูกค้า','error');
            }else if($('#customer_type_id').val() == ""){
                AlertToast('','กรุณาเลือกประเภทลูกค้า','error');
            }else if($('#customersProvince').val() == ""){
                AlertToast('','กรุณาเลือกประเภทลูกค้า','error');
            }else if($('#address_line1').val() == ""){
                AlertToast('','กรุณากรอกที่อยู่ (ตาม ภพ.20) เลขที่','error');
            }else if($('#alley').val() == ""){
                AlertToast('','กรุณากรอก ซอย/ถนน','error');
            }else if($('#customersCityCode').val() == ""){
                AlertToast('','กรุณาเลือก เขต/อำเภอ','error');
            }else if($('#customersDistrictCode').val() == ""){
                AlertToast('','กรุณาเลือก แขวง/ตำบล','error');
            }else if($('#customersRegion').val() == ""){
                AlertToast('','กรุณาเลือก ภูมิภาค','error');
            }else if($('#taxpayer_id').val() == ""){
                AlertToast('','กรุณากรอกเลขประจำตัวผู้เสียภาษี','error');
            }else if($('#tax_register_number').val() == ""){
                AlertToast('','กรุณากรอกเลขประจำตัวผู้เสียภาษี','error');
            }else{

                var customerNumber = $('#customer_number').val();
                var status = $("#tab-1 select[name*='status']").val();

                if (status == 'Active') {

                    Swal.fire({
                        title: 'ยืนยันการเปลี่ยนแปลงข้อมูล?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1ab394',
                        cancelButtonColor: '#ed4859',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            updateCustomers(id);
                            Swal.close();
                        }else{
                            Swal.close();
                        }
                    });


                }else{
                    updateCustomers(id);
                }
            }
        }

        function updateCustomers(id)
        {

            var email = $("#tab-1 input[name*='contact_email']").val();
            if(validateEmail(email) == false && email != ''){
                AlertToast('','รูปแบบอีเมล์ ไม่ถูกต้อง','error');
                $("#tab-1 input[name*='contact_email']").focus();
                return false;
            }else{
                // Start update
                const formData = new FormData(document.getElementById("formCustomers"));
                formData.append('_token','{{ csrf_token() }}');

                $.ajax({
                    url         : '{{ url("om/ajax/customers/domestics/update-customers") }}/'+id,
                    type        : 'post',
                    data        : formData,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    success     : function(res){
                        console.log(res);
                        var data = res.data;
                        if(data.status)
                        {
                            $('#customer_number').val(data.customerNumber);
                            $('#customer_number_contract').val(data.customerNumber);
                            $('#customer_number_quota').val(data.customerNumber);
                            $('#ship_site_customer_number').val(data.customerNumber);
                            $('#customer_number_agent').val(data.customerNumber);

                            if($.trim(data.password) != '')
                            {
                                // RESPONSE SHOW PASSWORD --- Doing ---
                                Swal.fire({
                                    title: "สร้าง username และ password สำหรับลูกค้า "+data.customerNumber+" เรียบร้อยแล้ว",
                                    text: "Username: "+data.customerNumber+" \n Password: "+data.password+" \n\n หมายเหตุ : หากลูกค้าระบุอีเมลจะได้รับข้อความนี้อัตโนมัติ หรือ โปรดทำการแจ้งรหัสผู้ใช้งานที่ลูกค้าจะเข้าใช้งาน Ecommerce",
                                    customClass: 'custom-sweetalert',
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                            else{
                                AlertToast('','อัพเดทข้อมูลเรียบร้อยแล้ว','success');
                            }

                            $('#customers_cancelled_date').html('<div id="mount_customers_cancelled_date"></div>');
                            // BIRTH DATE
                            contractsName   = 'cancelled_date';
                            contractsID     = 'cancelled_date';
                            contractsValue  = data.cancelledDate;
                            mountID     = 'mount_customers_cancelled_date';
                            generateDatePickerTH(mountID);
                        }
                        else{
                            if(data.type == 'validate'){
                                printErrorMsgContact(data);
                            }else{
                                AlertToast('แจ้งเตือน','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                            }
                        }
                    }
                });
                // End update
            }
        }

        function showOwner(id)
        {
            clearOwner();
            $('.formOwner').show();
            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/owner") }}/'+id,
                success : function(res){
                    customerOwner = res.data;

                    console.log(customerOwner);

                    $("#tab-3 input[name*='customer_owner_id']").val(customerOwner.customer_owner_id);
                    $("#tab-3 input[name*='customer_id']").val(customerOwner.customer_id);
                    $("#tab-3 input[name*='owner_no']").val(customerOwner.owner_no);
                    $("#tab-3 select[name*='prefix']").val(customerOwner.prefix).trigger('change');
                    $("#tab-3 input[name*='owner_first_name']").val(customerOwner.owner_first_name);
                    $("#tab-3 input[name*='owner_last_name']").val(customerOwner.owner_last_name);
                    // $("#tab-3 input[name*='birth_date']").val(customerOwner.birth_date);
                    $("#tab-3 input[name*='owner_status']").val(customerOwner.owner_status);
                    $("#tab-3 input[name*='card_id']").val(customerOwner.card_id);
                    $("#tab-3 input[name*='taxpayer_id']").val(customerOwner.taxpayer_id);
                    $("#tab-3 input[name*='phone']").val(customerOwner.phone);
                    $("#tab-3 input[name*='fax_number']").val(customerOwner.fax_number);
                    $("#tab-3 input[name*='mobile_number']").val(customerOwner.mobile_number);
                    $("#tab-3 input[name*='owner_email']").val(customerOwner.owner_email);
                    // $("#tab-3 input[name*='owner_type'][value="+customerOwner.owner_type+"]").attr('checked', true);
                    $('#tab-3 input:radio[name*="owner_type"]').filter('[value="'+customerOwner.owner_type+'"]').iCheck('check');
                    // $("#tab-3 input[name*='owner_change_date']").val(customerOwner.owner_change_date);
                    $("#tab-3 select[name*='status']").val(customerOwner.status).trigger('change');

                    // BIRTH DATE
                    contractsName   = 'birth_date';
                    contractsID     = 'birth_date';
                    contractsValue  = customerOwner.birth_date;
                    mountID     = 'mount_owner_birth_date';
                    generateDatePickerTH(mountID,);

                    // OWNER CHANGE DATE
                    contractsName   = 'owner_change_date';
                    contractsID     = 'owner_change_date';
                    contractsValue  = customerOwner.owner_change_date;
                    mountID     = 'mount_owner_owner_change_date';
                    generateDatePickerTH(mountID);
                }
            });
        }

        var quotaStartDate = '';
        var quotaEndDate = '';
        var quotaStatus = '';

        function showQuotaHeaders(id)
        {
            $('#qouta_start_date').html('<div id="mount_quota_start_date"></div>');
            $('#qouta_end_date').html('<div id="mount_quota_end_date"></div>');

            $(".del_all").remove();
            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/quota-headers") }}/'+id,
                success : function(res){
                    customerQuotaHeaders = res.data;
                    var checkQuotaLinesIsUse = '';
                    var dateDisabled = '';

                    if (res.haveDataInline == 'Y') {
                        checkQuotaLinesIsUse = 'readonly';
                        dateDisabled = 'disabled';
                        $('#quotar-status').attr('disabled', true);
                    } else {
                        checkQuotaLinesIsUse = '';
                        dateDisabled = '';
                        $('#quotar-status').attr('disabled', false);
                    }

                    quotaStartDate = customerQuotaHeaders.start_date;
                    quotaEndDate = customerQuotaHeaders.end_date;
                    quotaStatus = customerQuotaHeaders.status;

                    $("#tab-5 input[name*='quota_header_id']").val(customerQuotaHeaders.quota_header_id);
                    $("#tab-5 input[name*='customer_id']").val(customerQuotaHeaders.customer_id);
                    // $("#tab-5 input[name*='start_date']").val(customerQuotaHeaders.start_date);
                    // $("#tab-5 input[name*='end_date']").val(customerQuotaHeaders.end_date);
                    $("#tab-5 select[name*='status']").val(customerQuotaHeaders.status).trigger('change');

                    // START DATE
                    contractsName   = 'start_date';
                    contractsID     = 'quotaStart';
                    contractsValue  = customerQuotaHeaders.start_date;
                    mountID     = 'mount_quota_start_date';
                    generateDatePickerTH(mountID, dateDisabled);

                    // START DATE
                    contractsName   = 'end_date';
                    contractsID     = 'quotaEnd';
                    contractsValue  = customerQuotaHeaders.end_date;
                    mountID     = 'mount_quota_end_date';
                    generateDatePickerTH(mountID, dateDisabled);

                    var html = '';
                    var selectSequence = '';
                    var customerQuotaLines = res.dataList;
                    $.each(customerQuotaLines, function(key,val){
                        html += '<tr id="quota_line_roll_'+roll+'" class="del_all">';
                        html += '    <td class="text-left">';
                        html += '        <div class="form-group">';
                        html += '            <div class="input-icon">';
                        html += '                <input type="hidden" name="quota_line_id['+roll+']" id="quota_line_id_'+roll+'" value="'+val.quota_line_id+'">';
                        html += '                <input type="hidden" readonly placeholder="" name="item_id['+roll+']" id="item_id_'+roll+'" value="'+val.item_id+'">';

                        html += '               <input type="text" class="form-control sequence-qouta" name="item_code['+roll+']" id="item_code_'+roll+'" list="sequence-list-'+roll+'" onchange="selectQuotaLines('+roll+');" value="'+val.item_code+'" autocomplete="off" '+checkQuotaLinesIsUse+'>';
                        html += '               <i class="fa fa-search"></i>';
                        html += '               <datalist id="sequence-list-'+roll+'">';

                        $.each(sequenceEcomsList, function(keySequence, valSequence){
                        if (val.item_code != '') {
                        html += '                   <option '+selectSequence+' data-id="'+valSequence.item_id+'" value="'+valSequence.item_code+'">'+valSequence.ecom_item_description+'</option>';
                        }
                        });
                        html += '                </datalist>';
                        html += '                <i class="fa fa-search" onclick="selectQuotaLines('+roll+');"></i>';
                        html += '            </div>';
                        html += '        </div>';
                        html += '    </td>';
                        html += '    <td class="text-left">';
                        html += '        <input type="text" class="form-control text-center mw-250 m-auto" readonly placeholder="" name="item_description['+roll+']" id="item_description_'+roll+'" value="'+val.item_description+'">';
                        html += '    </td>';
                        html += '    <td>';
                        html += '        <input type="text" class="form-control text-center mw-120 m-auto" placeholder="" name="received_quota['+roll+']" id="received_quota_'+roll+'" value="'+formatNumber(val.received_quota)+'" required onchange="calculateQuota('+roll+')" onkeyup="convertReceived('+roll+')" onkeypress="return isNumber(event)" '+checkQuotaLinesIsUse+'>';
                        html += '    </td>';
                        html += '    <td>';
                        html += '        <input type="text" class="form-control text-center mw-120 m-auto" placeholder="" name="minimum_quota['+roll+']" id="minimum_quota_'+roll+'" value="'+formatNumber(val.minimum_quota)+'"  required onchange="calculateQuota('+roll+')" onkeyup="convertMinimum('+roll+')" onkeypress="return isNumber(event)" '+checkQuotaLinesIsUse+'>';
                        html += '    </td>';
                        html += '    <td>';
                        html += '        <input type="text" class="form-control text-center mw-120 m-auto" readonly placeholder="" name="remaining_quota['+roll+']" id="remaining_quota_'+roll+'" value="'+formatNumber(val.remaining_quota)+'">';
                        html += '     </td>';
                        if (res.haveDataInline == 'Y') {
                            html += '     <td class="text-center"><a class="fa fa-times red" href="javascript:(0);"></a></td>';
                        } else {
                            html += '     <td class="text-center"><a class="fa fa-times red" onclick="deleteDataProduct(`quota_line_roll_`, '+roll+');" href="javascript:(0);"></a></td>';
                        }
                        html += '</tr>';
                        roll += 1;
                    });
                    $("#quotaLines").html(html);
                    $('.formQuota').show();
                    $('.formStatusQuota').show();
                    $('.formTablesQuota').show();
                }
            });
        }

        function hideCustomersShipSites()
        {
            shipSiteMnage = 'clear';
            clearShipSites();
            $('.formShipSite').hide();
        }

        function showCustomersShipSites()
        {
            shipSiteMnage = 'create';
            clearShipSites();
            $('.formShipSite').show();

            $("#tab-6 input[name*='address_line1']").val('{{ $customers->address_line1 }}');
            $("#tab-6 input[name*='alley']").val('{{ $customers->alley }}');

            $("#tab-6 input[name='attribute1']").iCheck('uncheck');
        }

        function showShipSites(id)
        {
            $('.formShipSite').show();
            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/ship-sites") }}/'+id,
                success : function(res){
                    clearShipSites();
                    shipSites = res.data;
                    selectDistrict = shipSites.city;
                    $("#tab-6 input[name*='ship_to_site_id']").val(shipSites.ship_to_site_id);
                    $("#tab-6 input[name*='site_no']").val(shipSites.site_no);
                    $("#tab-6 input[name*='ship_to_site_code']").val(shipSites.ship_to_site_code);
                    $("#tab-6 input[name*='ship_to_site_name']").val(shipSites.ship_to_site_name);
                    $("#tab-6 input[name*='ship_contact_name']").val(shipSites.ship_contact_name);
                    $("#tab-6 input[name*='ship_contact_position']").val(shipSites.ship_contact_position);
                    $("#tab-6 select[name*='country_code']").val(shipSites.country_code);
                    $("#tab-6 select[name*='region_code']").val(shipSites.region_code).trigger('change');
                    $("#tab-6 input[name*='country_name']").val('Thailand');
                    $("#tab-6 input[name*='address_line1']").val(shipSites.address_line1);
                    $("#tab-6 select[name*='province_id']").val(shipSites.province_id).trigger('change');
                    $("#tab-6 input[name*='alley']").val(shipSites.alley);
                    setTimeout(function() {
                        // $("#tab-6 select[name*='city']").val(shipSites.city).trigger('change');
                        // $("#tab-6 select[name*='district']").val(shipSites.district).trigger('change');
                    },500);
                    $("#tab-6 input[name*='city_code']").val(shipSites.city_code);
                    $("#tab-6 input[name*='state']").val(shipSites.state);
                    $("#tab-6 input[name*='district_code']").val(shipSites.district_code);
                    $("#tab-6 input[name*='postal_code']").val(shipSites.postal_code);
                    $("#tab-6 select[name*='status']").val(shipSites.status);

                    if (shipSites.attribute1 == 'Y') {
                        $("#tab-6 input[name='attribute1']").iCheck('check');
                    }else{
                        $("#tab-6 input[name='attribute1']").iCheck('uncheck');
                    }

                    $("#shipsitesProvinceName").val(shipSites.province_name);

                    // $('#shipSitesCountryName').val($('#shipSitesCountry').find(':selected').data('value'));
                    $('#shipSitesProvinceName').val($('#shipSitesProvince').find(':selected').data('value'));
                    $('#shipSitesRegionName').val($('#shipSitesRegion').find(':selected').data('value'));
                }
            });

            shipSiteMnage = 'update';
        }

        function printErrorMsgShipping (msg)
        {
            $(".print-error-msg-shipping").find("ul").html('');
            $(".print-error-msg-shipping").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-shipping").find("ul").append('<li>'+value+'</li>');
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

        function showPrevious(id)
        {
            clearPrevious();
            $('.formPrevious').show();
            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/previous") }}/'+id,
                success : function(res){
                    customerPrevious = res.data;

                    console.log(customerPrevious);

                    $("#tab-2 input[name*='customer_id']").val(customerPrevious.customer_id);
                    $("#tab-2 input[name*='previous_id']").val(customerPrevious.previous_id);
                    $("#tab-2 input[name*='previous_no']").val(customerPrevious.previous_no);
                    $("#tab-2 input[name*='previous_name']").val(customerPrevious.previous_name);
                    $("#tab-2 select[name*='country_code']").val(customerPrevious.country_code);
                    $("#tab-2 input[name*='country_name']").val(customerPrevious.country_name);
                    $("#tab-2 select[name*='province_id']").val(customerPrevious.province_id).trigger('change');
                    $("#tab-2 input[name*='address']").val(customerPrevious.address);
                    $("#tab-2 input[name*='alley']").val(customerPrevious.alley);
                    $("#tab-2 select[name*='city']").val(customerPrevious.city).trigger('change');
                    $("#tab-2 select[name*='district']").val(customerPrevious.district).trigger('change');
                    $("#tab-2 select[name*='region_id']").val(customerPrevious.region_id);
                    $("#tab-2 input[name*='region_code']").val(customerPrevious.region_code);
                    $("#tab-2 input[name*='postal_code']").val(customerPrevious.postal_code);
                    $("#tab-2 input[name*='cancel_reason']").val(customerPrevious.cancel_reason);

                    $('#previousProvinceName').val($('#previousProvince').find(':selected').data('value'));
                    $('#previousRegionName').val($('#previousRegion').find(':selected').data('value'));

                    // START DATE
                    contractsName   = 'start_change_date';
                    contractsID     = 'start_change_date';
                    contractsValue  = customerPrevious.start_change_date;
                    mountID     = 'mount_previous_start_change_date';
                    generateDatePickerTH(mountID);

                    // END DATE
                    contractsName   = 'end_change_date';
                    contractsID     = 'end_change_date';
                    contractsValue  = customerPrevious.end_change_date;
                    mountID     = 'mount_previous_end_change_date';
                    generateDatePickerTH(mountID);

                    // CANCEL DATE
                    contractsName   = 'cancel_date';
                    contractsID     = 'cancel_date';
                    contractsValue  = customerPrevious.cancel_date;
                    mountID     = 'mount_previous_cancel_date';
                    generateDatePickerTH(mountID);
                }
            });
        }


        // PREVIOUS
        // $('#previousCountry').change(function(){
        //     $('#previousCountryName').val($(this).find(':selected').data('value'));
        // });

        $('#previousProvince').change(function(){

            var id      = $('#previousProvince').val();
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/city-list") }}/'+id+'/'+shipID,
                success : function(res){
                    city            = res.data.data;
                    cusShipSites    = res.data.cusShipSites;
                    var html        = '';
                    var checkSelect = '';
                    html += '<option value=""> &nbsp; </option>';
                    $.each(city, function(key,val){
                        if (val.city_thai == customerPrevious.city) {
                            checkSelect = 'selected';
                        }
                        else if(val.city_thai == '{{ $customers->city }}')
                        {
                            if(shipID !== 0 && val.city_thai === cusShipSites.city){
                                checkSelect = 'selected';
                            }else{
                                checkSelect = 'selected';
                            }
                        }
                        else{
                            checkSelect = '';
                        }
                        html += '<option '+checkSelect+' data-id="'+val.city_code+'" value="'+val.city_thai+'">'+val.city_thai+'</option>';
                    });
                    $('#previousCity').html(html).trigger('chosen:updated');
                    $('#previousCity').trigger('change');
                    $("#tab-2 select[name*='region_id']").val(res.data.regionID).trigger('change');
                    $("#tab-2 select[name*='city']").trigger('chosen:updated');
                }
            });

        });

        $('#previousCity').change(function(){

            var id      = $(this).find(':selected').data('id');
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/district-list") }}/'+id+'/'+shipID,
                success : function(res){
                    tambon          = res.data;
                    var checkSelect = '';
                    var html        = '';

                    html += '<option value=""> &nbsp; </option>';
                    $.each(tambon, function(key,val){
                        if (val.tambon_thai == customerPrevious.district) {
                            checkSelect = 'selected';
                        }
                        else if(val.tambon_thai == '{{ $customers->district }}')
                        {
                            checkSelect = 'selected';
                        }
                        else{
                            checkSelect = '';
                        }

                        html += '<option '+checkSelect+' data-id="'+val.tambon_id+'" value="'+val.tambon_thai+'">'+val.tambon_thai+'</option>';
                    });
                    $('#previousTambon').html(html).trigger('chosen:updated');
                    $('#previousTambon').trigger('change');
                    $("#tab-2 select[name*='district']").trigger('chosen:updated');
                    $("#tab-2 select[name*='district']").trigger('change');
                }
            });

        });

        $('#previousTambon').change(function(){

            var id      = $(this).find(':selected').data('id');
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/postcode") }}/'+id+'/'+shipID,
                success : function(res){
                    var postalCode = res.data;
                    $("#tab-2 input[name*='postal_code']").val(postalCode);
                }
            });

        });

        $('#previousRegion').change(function(){
            $('#previousRegionName').val($(this).find(':selected').data('value'));
        });

        $('#previousProvinceName').val($('#previousProvince').find(':selected').data('value'));
        $('#previousRegionName').val($('#previousRegion').find(':selected').data('value'));

        $('#shipSitesProvince').change(function(){
            $('#shipsitesProvinceName').val($(this).find(':selected').data('value'));

            var id      = $('#shipSitesProvince').val();
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/city-list") }}/'+id+'/'+shipID,
                async: false,
                success : function(res){
                    city            = res.data.data;
                    cusShipSites    = res.data.cusShipSites;
                    var html        = '';
                    var checkSelect = '';
                    var cityCode    = '';
                    html += '<option value=""> &nbsp; </option>';
                    $.each(city, function(key,val){
                        // if (val.city_thai == shipSites.city) {
                        //     console.log(val.city_thai, shipSites.city )
                        //     checkSelect = 'selected';
                        //     cityCode    = val.city_code;
                        // }else if(val.city_thai == '{{ $customers->city }}'){
                        //     checkSelect = 'selected';
                        //     cityCode    = val.city_code;
                        // }else if(Number(shipID) != 0){
                        //     if(val.city_thai == cusShipSites.city){
                        //         checkSelect = 'selected';
                        //         cityCode    = val.city_code;
                        //     }
                        // }else{
                        //     checkSelect = '';
                        // }
                        // if(checkSelect == 'selected') {
                        //     console.log(checkSelect, val)
                        // }
                        // html += '<option '+checkSelect+' data-id="'+val.city_code+'" value="'+val.city_thai+'">'+val.city_thai+'</option>';
                        html += '<option  data-id="'+val.city_code+'" value="'+val.city_thai+'">'+val.city_thai+'</option>';
                    });
                    $('#shipSitesCity').html(html).trigger('chosen:updated');
                    if(typeof shipSites.city != 'undefined') {
                        $('#shipSitesCity option[value="'+ shipSites.city +'"]').prop('selected', true);

                    }

                    $('#shipSitesCity').trigger('change');
                    $("#tab-6 select[name*='region_code']").val(res.data.regionText).trigger('change');

                    $("#tab-6 select[name*='city']").trigger('chosen:updated');
                }
            });

        });

        var selectDistrict = '{{ $customers->district }}'
        $('#shipSitesCity').change(function(){

            var id      = $(this).find(':selected').data('id');
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;
            $('#shipsitesCityCode').val(id);

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/district-list") }}/'+id+'/'+shipID,
                async:false,
                success : function(res){
                    tambon = res.data;
                    var checkSelect     = '';
                    var html            = '';
                    var districtCode    = '';

                    html += '<option value=""> &nbsp; </option>';
                    $.each(tambon, function(key,val){
                        // if (val.tambon_thai == shipSites.district) {
                        //     checkSelect = 'selected';
                        //     districtCode = val.tambon_id;
                        // }
                        // else if(val.tambon_thai == selectDistrict)
                        // {
                        //     checkSelect = 'selected';
                        //     districtCode = val.tambon_id;g
                        // }else{
                        //     checkSelect = '';
                        // }
                        
                      

                        html += '<option '+checkSelect+' data-id="'+val.tambon_id+'" value="'+val.tambon_thai+'">'+val.tambon_thai+'</option>';
                    });
                    $('#shipSitesDistrict').html(html).trigger('chosen:updated');

                    if(typeof shipSites.district != 'undefined') {
                        console.log(shipSites.district, 'test')
                        $('#shipSitesDistrict option[value="'+ shipSites.district +'"]').prop('selected', true);
                    }
                    $('#shipSitesDistrict').trigger('change');
                    $("#tab-6 select[name*='district_code']").val(districtCode).trigger('chosen:updated');
                    $("#tab-6 select[name*='district_code']").val(districtCode).trigger('change');
                }
            });
        });

        $('#shipSitesRegion').change(function(){
            $('#shipSitesRegionName').val($(this).find(':selected').data('value'));
            $('#shipsitesRegionID').val($(this).find(':selected').data('id'));
        });

        $('#shipSitesDistrict').change(function(){

            var id      = $(this).find(':selected').data('id');
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;

            $('#shipsitesDistrictCode').val(id);

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/postcode") }}/'+id+'/'+shipID,
                async:false,
                success : function(res){
                    var postalCode = res.data;
                    $("#tab-6 input[name*='postal_code']").val(postalCode);
                }
            });

        });

        function clearPrevious()
        {
            $("#tab-2 select[name*='province_id']").val('{{ $customers->province_code }}').trigger('change');
            $("#tab-2 input[name*='province_name']").val('');
            $("#tab-2 input[name*='address']").val('');
            $("#tab-2 input[name*='alley']").val('');
            $("#tab-2 select[name*='city']").val('').trigger('change');
            $("#tab-2 select[name*='district']").val('').trigger('change');
            $("#tab-2 select[name*='region_id']").val('').trigger('change');
            $("#tab-2 input[name*='region_code']").val('');
            $("#tab-2 input[name*='postal_code']").val('');


            $("#tab-2 input[name*='previous_id']").val('');
            $("#tab-2 input[name*='previous_no']").val('');
            $("#tab-2 input[name*='previous_name']").val('');
            $("#tab-2 input[name*='cancel_reason']").val('');

            $('#previous_start_change').html('<div id="mount_previous_start_change_date"></div>');
            $('#previous_end_change').html('<div id="mount_previous_end_change_date"></div>');
            $('#previous_cancel_date').html('<div id="mount_previous_cancel_date"></div>');

            $('#previousProvinceName').val($('#previousProvince').find(':selected').data('value'));
            $('#previousRegionName').val($('#previousRegion').find(':selected').data('value'));
        }

        function insertCustomersPrevious()
        {
            const formData = new FormData(document.getElementById("formCustomersPrevious"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/customers/domestics/insert-customers-previous") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    console.log(res);
                    var data = res.data;
                    if(data.data){
                        AlertToast('','สร้างข้อมูลเรียบร้อยแล้ว','success');
                        clearPrevious();
                        html = '';
                        $.each(data.dataList, function( key, val ) {
                            html += '<tr>';
                            html += '    <td> '+val.previous_no+' </td>';
                            html += '    <td class="text-left"> '+val.previous_name+' </td>';
                            html += '    <td> '+val.cancel_date+'</td>';
                            html += '    <td><a onclick="showPrevious('+val.previous_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                            html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deletePrevious('+val.previous_id+', '+val.customer_id+')"></a></td>';
                            html += '</tr>';
                        });
                        $("#previousList").html(html);
                        $('.formPrevious').hide();
                    }else{
                        if(data.type == 'validate'){
                            printErrorMsgContact(data);
                        }else{
                            AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                        }
                    }
                }
            });
        }

        function updateCustomersPrevious()
        {
            var id = $("#previous_id").val();

            if(id <= 0){
                insertCustomersPrevious();
                return false;
            }

            const formData = new FormData(document.getElementById("formCustomersPrevious"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/customers/domestics/update-customers-previous") }}/'+id,
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    console.log(res);
                    var data = res.data;
                    if(data.data){
                        AlertToast('','อัพเดทข้อมูลเรียบร้อยแล้ว','success');
                        html = '';
                        $.each(data.dataList, function( key, val ) {
                            html += '<tr>';
                            html += '    <td> '+val.previous_no+' </td>';
                            html += '    <td class="text-left"> '+val.previous_name+' </td>';
                            html += '    <td> '+val.cancel_date+'</td>';
                            html += '    <td><a onclick="showPrevious('+val.previous_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                            html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deletePrevious('+val.previous_id+', '+val.customer_id+')"></a></td>';
                            html += '</tr>';
                        });
                        $("#previousList").html(html);
                        $('.formPrevious').hide();
                    }else{
                        if(data.type == 'validate'){
                            printErrorMsgContact(data);
                        }else{
                            AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                        }
                    }
                }
            });
        }

        function hideCustomersPrevious()
        {
            clearPrevious();
            $('.formPrevious').hide();

            // START CHANGE
            contractsName   = 'start_change_date';
            contractsID     = 'start_change_date';
            contractsValue  = '';
            mountID     = 'mount_previous_start_change_date';
            generateDatePickerTH(mountID);

            // END CHANGE
            contractsName   = 'end_change_date';
            contractsID     = 'end_change_date';
            contractsValue  = '';
            mountID     = 'mount_previous_end_change_date';
            generateDatePickerTH(mountID);

            // CANCEL CHANGE
            contractsName   = 'cancel_date';
            contractsID     = 'cancel_date';
            contractsValue  = '';
            mountID     = 'mount_previous_cancel_date';
            generateDatePickerTH(mountID);
        }

        function showCustomersPrevious()
        {
            clearPrevious();

            $("#tab-2 input[name*='address']").val('{{ $customers->address_line1 }}');
            $("#tab-2 input[name*='alley']").val('{{ $customers->alley }}');

            $('.formPrevious').show();

            // START CHANGE
            contractsName   = 'start_change_date';
            contractsID     = 'start_change_date';
            contractsValue  = '';
            mountID     = 'mount_previous_start_change_date';
            generateDatePickerTH(mountID);

            // END CHANGE
            contractsName   = 'end_change_date';
            contractsID     = 'end_change_date';
            contractsValue  = '';
            mountID     = 'mount_previous_end_change_date';
            generateDatePickerTH(mountID);

            // CANCEL CHANGE
            contractsName   = 'cancel_date';
            contractsID     = 'cancel_date';
            contractsValue  = '';
            mountID     = 'mount_previous_cancel_date';
            generateDatePickerTH(mountID);
        }

        function hideCustomersOwner()
        {
            clearOwner();
            $('.formOwner').hide();

            // BIRTH DATE
            contractsName   = 'birth_date';
            contractsID     = 'birth_date';
            contractsValue  = '';
            mountID     = 'mount_owner_birth_date';
            generateDatePickerTH(mountID);

            // DATE CHANGE
            contractsName   = 'owner_change_date';
            contractsID     = 'owner_change_date';
            contractsValue  = '';
            mountID     = 'mount_owner_owner_change_date';
            generateDatePickerTH(mountID);
        }

        function showCustomersOwner()
        {
            clearOwner();
            $('.formOwner').show();

            // BIRTH DATE
            contractsName   = 'birth_date';
            contractsID     = 'birth_date';
            contractsValue  = '';
            mountID     = 'mount_owner_birth_date';
            generateDatePickerTH(mountID);

            // DATE CHANGE
            contractsName   = 'owner_change_date';
            contractsID     = 'owner_change_date';
            contractsValue  = '';
            mountID     = 'mount_owner_owner_change_date';
            generateDatePickerTH(mountID);
        }

        function showContract()
        {
            clearContracts();
            $('.formContract').show();
        }

        function insertCustomersOwner()
        {
            var email = $("#tab-3 input[name*='owner_email']").val();

            if( $.trim($("#tab-3 input[name*='owner_first_name']").val()) == '' ){
                AlertToast('','กรุณากรอกชื่อผู้ทรงสิทธิ์','error');
                return false;
            }else if( $.trim($("#tab-3 input[name*='owner_last_name']").val()) == '' ){
                AlertToast('','กรุณากรอกนามสกุลผู้ทรงสิทธิ์','error');
                return false;
            }else if( $.trim($("#tab-3 input[name*='card_id']").val()) == '' ){
                AlertToast('','กรุณากรอกเลขที่บัตรประชาชน','error');
                return false;
            }else if( $.trim($("#tab-3 input[name*='taxpayer_id']").val()) == '' ){
                AlertToast('','กรุณากรอกเลขประจำตัวผู้เสียภาษี','error');
                return false;
            }else if(validateEmail(email) == false && email != ''){
                AlertToast('','รูปแบบอีเมล์ ไม่ถูกต้อง','error');
                $("#tab-3 input[name*='owner_email']").focus();
                return false;
            }else if( $.trim($(".checked input[name=owner_type]").val()) == '' ){
                AlertToast('','กรุณาเลือกประเภทธุรกิจ','error');
                return false;
            }else{
                const formData = new FormData(document.getElementById("formCustomersOwner"));
                formData.append('_token','{{ csrf_token() }}');

                $.ajax({
                    url         : '{{ url("om/ajax/customers/domestics/insert-customers-owner") }}',
                    type        : 'post',
                    data        : formData,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    success     : function(res){
                        console.log(res);
                        var data = res.data;
                        if(data.data){
                            AlertToast('','สร้างข้อมูลเรียบร้อยแล้ว','success');
                            clearPrevious();
                            html = '';
                            $.each(data.dataList, function( key, val ) {
                                html += '<tr>';
                                html += '    <td> '+val.owner_no+' </td>';
                                html += '    <td class="text-left"> '+$.trim(val.prefix)+' '+ $.trim(val.owner_first_name) +' '+ $.trim(val.owner_last_name) +' </td>';
                                html += '    <td> '+$.trim(val.phone)+'</td>';
                                html += '    <td> '+val.status+'</td>';
                                html += '    <td><a onclick="showOwner('+val.customer_owner_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                                html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteOwner('+val.customer_owner_id+', '+val.customer_id+')"></a></td>';
                                html += '</tr>';
                            });
                            $("#ownerList").html(html);
                            $('.formOwner').hide();
                        }else{
                            if(data.type == 'validate'){
                                printErrorMsgContact(data);
                            }else{
                                AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                            }
                        }
                    }
                });
            }
        }

        function clearOwner()
        {
            $("#tab-3 input[name*='customer_owner_id']").val('');
            $("#tab-3 input[name*='owner_no']").val('');
            $("#tab-3 select[name*='prefix']").val('');
            $("#tab-3 input[name*='owner_first_name']").val('');
            $("#tab-3 input[name*='owner_last_name']").val('');
            $("#tab-3 input[name*='owner_status']").val('');
            $("#tab-3 input[name*='card_id']").val('');
            $("#tab-3 input[name*='taxpayer_id']").val('');
            $("#tab-3 select[name*='taxpayer_id']").val('');
            $("#tab-3 input[name*='phone']").val('');
            $("#tab-3 input[name*='fax_number']").val('');
            $("#tab-3 input[name*='mobile_number']").val('');
            $("#tab-3 input[name*='owner_email']").val('');
            $("#tab-3 input[name*='owner_type']").attr('checked', false);
            $("#tab-3 select[name*='status']").val('Active').trigger('change');

            $('#owner_birth_date').html('<div id="mount_owner_birth_date"></div>');
            $('#owner_change_date').html('<div id="mount_owner_owner_change_date"></div>');
        }

        function updateCustomersOwner()
        {
            var id = $("#OwnerID").val();

            if(id <= 0){
                insertCustomersOwner();
                return false;
            }else if( $.trim($("#tab-3 input[name*='owner_first_name']").val()) == '' ){
                AlertToast('','กรุณากรอกชื่อผู้ทรงสิทธิ์','error');
                return false;
            }else if( $.trim($("#tab-3 input[name*='owner_last_name']").val()) == '' ){
                AlertToast('','กรุณากรอกนามสกุลผู้ทรงสิทธิ์','error');
                return false;
            }else if( $.trim($("#tab-3 input[name*='card_id']").val()) == '' ){
                AlertToast('','กรุณากรอกเลขที่บัตรประชาชน','error');
                return false;
            }else if( $.trim($("#tab-3 input[name*='taxpayer_id']").val()) == '' ){
                AlertToast('','กรุณากรอกเลขประจำตัวผู้เสียภาษี','error');
                return false;
            }else if( $.trim($(".checked input[name=owner_type]").val()) == '' ){
                AlertToast('','กรุณาเลือกประเภทธุรกิจ','error');
                return false;
            }else{
                const formData = new FormData(document.getElementById("formCustomersOwner"));
                formData.append('_token','{{ csrf_token() }}');

                $.ajax({
                    url         : '{{ url("om/ajax/customers/domestics/update-customers-owner") }}/'+id,
                    type        : 'post',
                    data        : formData,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    success     : function(res){
                        console.log(res);
                        var data = res.data;
                        if(data.status){
                            AlertToast('','อัพเดทข้อมูลเรียบร้อยแล้ว','success');
                            html        = '';
                            var prefix  = '';
                            var phone   = '';
                            $.each(data.dataList, function( key, val ) {


                                html += '<tr>';
                                html += '    <td> '+val.owner_no+' </td>';
                                html += '    <td class="text-left"> '+$.trim(val.prefix)+' '+ $.trim(val.owner_first_name) +' '+ $.trim(val.owner_last_name) +' </td>';
                                html += '    <td> '+$.trim(val.phone)+'</td>';
                                html += '    <td> '+val.status+'</td>';
                                html += '    <td><a onclick="showOwner('+val.customer_owner_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                                html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteOwner('+val.customer_owner_id+', '+val.customer_id+')"></a></td>';
                                html += '</tr>';
                            });
                            $("#ownerList").html(html);
                            $('.formOwner').hide();
                        }else{
                            if(data.type == 'validate'){
                                printErrorMsgContact(data);
                            }else{
                                AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                            }
                        }
                    }
                });
            }
        }

        function clearShipSites()
        {
            $("#tab-6 select[name*='province_id']").val('{{ $customers->province_code }}').trigger('change');
            $("#tab-6 select[name*='country_code']").val('TH');
            $("#tab-6 select[name*='region_code']").val('').trigger('change');
            $("#tab-6 input[name*='country_name']").val('Thailand');
            $("#tab-6 input[name*='address_line1']").val('');
            $("#tab-6 input[name*='province_code']").val('');
            $("#tab-6 input[name*='alley']").val('');
            $("#tab-6 select[name*='city']").val('').trigger('change');
            $("#tab-6 input[name*='city_code']").val('');
            $("#tab-6 input[name*='state']").val('');
            $("#tab-6 select[name*='district']").val('').trigger('change');
            $("#tab-6 input[name*='district_code']").val('');
            $("#tab-6 input[name*='postal_code']").val('');

            $("#tab-6 input[name*='ship_to_site_id']").val('0');
            $("#tab-6 input[name*='site_no']").val('');
            $("#tab-6 input[name*='ship_to_site_code']").val('');
            $("#tab-6 input[name*='ship_to_site_name']").val('{{ $customers->customer_name }}');
            $("#tab-6 input[name*='ship_contact_name']").val('');
            $("#tab-6 input[name*='ship_contact_position']").val('');
            $("#tab-6 select[name*='status']").val('Active');
            $("#tab-6 input[name*='head_office_flag']").iCheck('uncheck');

            // $('#shipSitesCountryName').val($('#shipSitesCountry').find(':selected').data('value'));
            $('#shipSitesProvinceName').val($('#shipSitesProvince').find(':selected').data('value'));
            $('#shipSitesRegionName').val($('#shipSitesRegion').find(':selected').data('value'));
            $('#shipsitesRegionID').val($(this).find(':selected').data('id'));
        }

        function insertCustomersShipSites()
        {

            const formData = new FormData(document.getElementById("formCustomersShipSites"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/customers/domestics/insert-customers-shipsites") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    console.log(res);
                    var data = res.data;
                    if(data.data){
                        AlertToast('','สร้างข้อมูลเรียบร้อยแล้ว','success');
                        clearShipSites();

                        html = '';
                        $.each(data.dataList, function( key, val ) {

                            var mainShipsiteStatus = val.attribute1 == 'Y' ? 'checked' : '';

                            html += '<tr>';
                            html += '    <td> '+val.site_no+' </td>';
                            html += '    <td> '+val.ship_to_site_name+' </td>';
                            html += '    <td> '+val.status+'</td>';
                            html += '    <td><a onclick="showShipSites('+val.ship_to_site_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                            html += '    <td class="text-center">';
                            html += '       <div class="i-checks mt-2 mb-1 mr-auto">';
                            html += '           <input type="checkbox" class="checksite" name="shipattribute1" '+mainShipsiteStatus+' autocomplete="off" disabled>';
                            html += '       </div>';
                            html += '    </td>';
                            html += '</tr>';
                        });
                        $("#shipSiteList").html(html);
                        $('.formShipSite').hide();

                        $('.checksite').iCheck({
                            checkboxClass: 'icheckbox_square-green'
                        });
                    }else{
                        if(data.type == 'validate'){
                            printErrorMsgContact(data);
                        }else{
                            AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                        }
                    }
                }
            });
        }

        function updateCustomersShipSites()
        {
            var cusId = $("#ship_site_customer_id").val();
            var id = $("#shipSitesID").val();
            var shipSiteName = $('#ship_to_site_name').val();
            var shipNameStatus = true;

            $.ajax({
                    url : '{{ url("om/ajax/customers/domestics/get-ship-site-name") }}/'+cusId+'/'+id,
                    success : function(res){
                        var shipSiteNameData = '';

                        if (res.data.dataList != null) {
                            $.each(res.data.dataList, function(key,val){
                                if (val.ship_to_site_name == shipSiteName) {
                                    shipNameStatus = false;
                                }
                            });
                        }

                        if (shipNameStatus == false) {
                            AlertToast('','ชื่อสถานที่จัดส่งนี้ถูกใช้งานแล้ว','error');
                            $("#btnUpdateShipsite").attr('disabled', true);
                        }else{
                            if(shipSiteMnage == 'clear'){

                            }else if(id <= 0){
                                insertCustomersShipSites();
                                return false;
                            }else{
                                const formData = new FormData(document.getElementById("formCustomersShipSites"));
                                formData.append('_token','{{ csrf_token() }}');

                                $.ajax({
                                    url         : '{{ url("om/ajax/customers/domestics/update-customers-shipsites") }}/'+id,
                                    type        : 'post',
                                    data        : formData,
                                    cache       : false,
                                    processData : false,
                                    contentType : false,
                                    success     : function(res){
                                        console.log(res);
                                        var data = res.data;
                                        if(data.data){
                                            AlertToast('','อัพเดทข้อมูลเรียบร้อยแล้ว','success');
                                            html = '';
                                            $.each(data.dataList, function( key, val ) {

                                                var mainShipsiteStatus = val.attribute1 == 'Y' ? 'checked' : '';

                                                html += '<tr>';
                                                html += '    <td> '+val.site_no+' </td>';
                                                html += '    <td> '+val.ship_to_site_name+' </td>';
                                                html += '    <td> '+val.status+'</td>';
                                                html += '    <td><a onclick="showShipSites('+val.ship_to_site_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                                                html += '    <td class="text-center">';
                                                html += '       <div class="i-checks mt-2 mb-1 mr-auto">';
                                                html += '           <input type="checkbox" class="checksite" name="shipattribute1" '+mainShipsiteStatus+' autocomplete="off" disabled>';
                                                html += '       </div>';
                                                html += '    </td>';
                                                // html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteShipSite('+val.ship_to_site_id+', '+val.customer_id+')"></a></td>';
                                                html += '</tr>';
                                            });
                                            $("#shipSiteList").html(html);
                                            $('.formShipSite').hide();

                                            $('.checksite').iCheck({
                                                checkboxClass: 'icheckbox_square-green'
                                            });
                                        }else{
                                            if(data.type == 'validate'){
                                                printErrorMsgContact(data);
                                            }else{
                                                AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    }
                });
        }

        function deleteShipSite(shipID, customerID)
        {
            clearShipSites();
            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/delete-customers-shipsites") }}/'+shipID+'/'+customerID,
                success : function(res){
                    console.log(res);
                    var data = res.data;
                    if(data.data){
                        AlertToast('','ลบข้อมูลเรียบร้อยแล้ว','success');
                        html = '';
                        $.each(data.dataList, function( key, val ) {
                            html += '<tr>';
                            html += '    <td> '+val.site_no+' </td>';
                            html += '    <td> '+val.ship_to_site_name+' </td>';
                            html += '    <td> '+val.status+'</td>';
                            html += '    <td><a onclick="showShipSites('+val.ship_to_site_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                            // html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteShipSite('+val.ship_to_site_id+', '+val.customer_id+')"></a></td>';
                            html += '</tr>';
                        });
                        $("#shipSiteList").html(html);
                        $('.formShipSite').hide();
                    }else{
                        if(data.type == 'validate'){
                            printErrorMsgContact(data);
                        }else{
                            AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                        }
                    }
                    clearShipSites();
                }
            });
        }

        function deletePrevious(previousID, customerID)
        {
            clearPrevious();
            $('.formPrevious').hide();
            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/delete-customers-previous") }}/'+previousID+'/'+customerID,
                success : function(res){
                    console.log(res);
                    var data = res.data;
                    if(data.data){
                        AlertToast('','ลบข้อมูลเรียบร้อยแล้ว','success');
                        html = '';
                        $.each(data.dataList, function( key, val ) {
                            html += '<tr>';
                            html += '    <td> '+val.previous_no+' </td>';
                            html += '    <td class="text-left"> '+val.previous_name+' </td>';
                            html += '    <td> '+$.trim(val.cancel_date)+'</td>';
                            html += '    <td><a onclick="showPrevious('+val.previous_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                            html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deletePrevious('+val.previous_id+', '+val.customer_id+')"></a></td>';
                            html += '</tr>';
                        });
                        $("#previousList").html(html);
                    }else{
                        if(data.type == 'validate'){
                            printErrorMsgContact(data);
                        }else{
                            AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                        }
                    }
                    clearShipSites();
                }
            });
        }

        function deleteOwner(ownerID, customerID)
        {
            Swal.fire({
                title: '',
                text: "คุณต้องการลบรายการนี้หรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#ed4859',
                confirmButtonText: 'ลบรายการ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    clearOwner();
                    $('.formOwner').hide();
                    $.ajax({
                        url : '{{ url("om/ajax/customers/domestics/delete-customers-owner") }}/'+ownerID+'/'+customerID,
                        success : function(res){
                            console.log(res);
                            var data = res.data;
                            if(data.data){
                                AlertToast('','ลบข้อมูลเรียบร้อยแล้ว','success');
                                html = '';
                                $.each(data.dataList, function( key, val ) {
                                    html += '<tr>';
                                    html += '    <td> '+val.owner_no+' </td>';
                                    html += '    <td class="text-left"> '+$.trim(val.prefix)+' '+ $.trim(val.owner_first_name) +' '+ $.trim(val.owner_last_name) +' </td>';
                                    html += '    <td> '+$.trim(val.phone)+'</td>';
                                    html += '    <td> '+val.status+'</td>';
                                    html += '    <td><a onclick="showOwner('+val.customer_owner_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                                    html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteOwner('+val.customer_owner_id+', '+val.customer_id+')"></a></td>';
                                    html += '</tr>';
                                });
                                $("#ownerList").html(html);
                            }else{
                                if(data.type == 'validate'){
                                    printErrorMsgContact(data);
                                }else{
                                    AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                                }
                            }
                        }
                    });
                }
            });
        }

        function insertContracts()
        {
            var overlap = '';

            // $("input[name='manage_customer_contracts[]']").each(function ()
            // {
            //     var contractMainID  = parseInt($(this).val());

            //     var mainStartDate   = $("input[name='book_start_date["+ contractMainID+"]']").val();
            //     var mainEnddate     = $("input[name='book_end_date["+ contractMainID+"]']").val();

            //     $("input[name='manage_customer_contracts[]']").each(function (key, value){

            //         var contractSubID  = parseInt($("#manage_customer_contracts_"+ contractSubID).val());;

            //         if (contractMainID != contractSubID) {

            //             var subStartDate    = $("input[name='book_start_date["+ contractSubID+"]']").val();
            //             var subEndDate      =  $("input[name='book_end_date["+ contractSubID+"]']").val();

            //             var checkOverlap = dateRangeOverlaps(mainStartDate, mainEnddate, subStartDate, subEndDate);

            //             if (checkOverlap == 'overlap') {
            //                 overlap = 'overlap';
            //             }

            //         }

            //     });

            // });

            if (overlap == 'overlap') {
                AlertToast('','ข้อมูลวันที่สัญญาเงินเชื่อ overlap กัน','error');
            }else{
                $('#btn_update_contracts').attr('disabled', true);
                const formData = new FormData(document.getElementById("formContract"));
                formData.append('_token','{{ csrf_token() }}');

                $.ajax({
                    url         : '{{ url("om/ajax/customers/domestics/insert-customers-contracts") }}',
                    type        : 'post',
                    data        : formData,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    success     : function(res){
                        console.log(res);
                        var data = res.data;
                        if(data.data){
                            AlertToast('','บันทึกข้อมูลเรียบร้อยแล้ว','success');
                            clearContracts();
                            html = '';
                            $("#tbContract").html('');
                            $.each(data.dataList, function( key, val ) {

                                html += '<tr id="contract_roll_c'+val.contract_id+'" class="contract_del_all '+val.color_button+'">';
                                html += '    <td>';
                                html += '       <input type="hidden"  name="contract_id[c'+val.contract_id+']" value="'+val.contract_id+' ">';
                                html += '       <input type="hidden"  name="customer_id" value="'+customer_id+'">';
                                html += '       <input type="hidden"  name="manage_customer_contracts[]" id="manage_customer_contracts_'+val.contract_id+'" value="'+val.contract_id+'">';
                                html += '       <input type="text" class="form-control no-line" placeholder="ระบุเลขที่สัญญา..." name="contract_number[c'+val.contract_id+']" value="'+val.contract_number+'" autocomplete="off">';
                                html += '    </td>';
                                html += '    <td>';
                                html += '        <div class="input-icon">';
                                html += '           <div id="mount_contract_start_date_c'+val.contract_id+'"></div>';
                                // html += '            <input type="text" class="form-control no-line mw-120 date" name="start_date[c'+val.contract_id+']" placeholder="ระบุวันที่..." value="'+val.start_date+'" autocomplete="off">';
                                // html += '            <i class="fa fa-calendar"></i>';
                                html += '        </div>';
                                html += '    </td>';
                                html += '    <td>';
                                html += '        <div class="input-icon">';
                                html += '           <div id="mount_contract_end_date_c'+val.contract_id+'"></div>';
                                // html += '            <input type="text" class="form-control no-line mw-120 date" name="end_date[c'+val.contract_id+']" placeholder="ระบุวันที่..." value="'+val.end_date+'" autocomplete="off">';
                                // html += '            <i class="fa fa-calendar"></i>';
                                html += '        </div>';
                                html += '    </td>';
                                html += '    <td>';
                                html += '        <input type="text" class="form-control no-line mw-150 pr-0 text-right ml-auto" name="guarantee_amount[c'+val.contract_id+']" id="guarantee_amount_'+val.contract_id+'" placeholder="ระบุวงเงิน.." value="'+$.trim(val.guarantee_amount)+'"  onkeypress="return isNumber(event)" onkeyup="convertGuarantee('+val.contract_id+')" autocomplete="off">';
                                html += '    </td>';
                                html += '    <td class="text-center"><a class="fa fa-times red" onclick="deleteContract('+val.contract_id+', '+val.customer_id+')" href="javascript:(0);"></a></td>';
                                html += '</tr>';
                            });

                            $("#tbContract").html(html);

                            $.each(data.dataList, function( key, val ) {
                                // START DATE
                                contractsName   = 'start_date[c'+val.contract_id+']';
                                contractsID     = 'contract_start_date_c'+val.contract_id;
                                contractsValue  = val.start_date;
                                mountID     = 'mount_contract_start_date_c'+val.contract_id;
                                generateDatePickerTH(mountID);

                                // END DATE
                                contractsName   = 'end_date[c'+val.contract_id+']';
                                contractsID     = 'contract_end_date_c'+val.contract_id;
                                contractsValue  = val.end_date;
                                mountID     = 'mount_contract_end_date_c'+val.contract_id;
                                generateDatePickerTH(mountID);

                                if ($.trim(val.color_button) != '') {
                                    $('#contract_start_date_c'+val.contract_id).addClass('text-danger');
                                    $('#contract_end_date_c'+val.contract_id).addClass('text-danger');
                                }
                            });

                        }else{
                            if(data.type == 'validate'){
                                printErrorMsgContact(data);
                            }else{
                                AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                            }
                        }

                        $('#btn_update_contracts').attr('disabled', false);
                    }
                });
            }

        }

        function deleteContract(contractID, customerID)
        {
            Swal.fire({
                title: '',
                text: "คุณต้องการลบรายการนี้หรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#ed4859',
                confirmButtonText: 'ลบรายการ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : '{{ url("om/ajax/customers/domestics/delete-customers-contracts") }}/'+contractID+'/'+customerID,
                        success : function(res){
                            clearContracts();
                            var data = res.data;
                            if(data.data){
                                AlertToast('','ลบข้อมูลเรียบร้อยแล้ว','success');
                                html = '';
                                $.each(data.dataList, function( key, val ) {

                                    html += '<tr id="contract_roll_c'+val.contract_id+'" class="contract_del_all '+val.color_button+'">';
                                    html += '    <td>';
                                    html += '        <input type="hidden"  name="contract_id[c'+val.contract_id+']" value="'+val.contract_id+' ">';
                                    html += '        <input type="hidden"  name="customer_id" value="'+customer_id+'">';
                                    html += '        <input type="text" class="form-control no-line" placeholder="ระบุเลขที่สัญญา..." name="contract_number[c'+val.contract_id+']" value="'+val.contract_number+'" autocomplete="off">';
                                    html += '    </td>';
                                    html += '    <td>';
                                    html += '        <div class="input-icon">';
                                    html += '           <div id="mount_contract_start_date_c'+val.contract_id+'"></div>';
                                    // html += '            <input type="text" class="form-control no-line mw-120 date" name="start_date[c'+val.contract_id+']" placeholder="ระบุวันที่..." value="'+val.start_date+'" autocomplete="off">';
                                    // html += '            <i class="fa fa-calendar"></i>';
                                    html += '        </div>';
                                    html += '    </td>';
                                    html += '    <td>';
                                    html += '        <div class="input-icon">';
                                    html += '           <div id="mount_contract_end_date_c'+val.contract_id+'"></div>';
                                    // html += '            <input type="text" class="form-control no-line mw-120 date" name="end_date[c'+val.contract_id+']" placeholder="ระบุวันที่..." value="'+val.end_date+'" autocomplete="off">';
                                    // html += '            <i class="fa fa-calendar"></i>';
                                    html += '        </div>';
                                    html += '    </td>';
                                    html += '    <td>';
                                    html += '        <input type="text" class="form-control no-line mw-150 pr-0 text-right ml-auto" name="guarantee_amount[c'+val.contract_id+']" id="guarantee_amount_'+val.contract_id+'" placeholder="ระบุวงเงิน.." value="'+$.trim(val.guarantee_amount)+'"  onkeypress="return isNumber(event)" onkeyup="convertGuarantee('+val.contract_id+')" autocomplete="off">';
                                    html += '    </td>';
                                    html += '    <td class="text-center"><a class="fa fa-times red" onclick="deleteContract('+val.contract_id+', '+val.customer_id+')" href="javascript:(0);"></a></td>';
                                    html += '</tr>';
                                });
                                $("#tbContract").html(html);

                                $.each(data.dataList, function( key, val ) {
                                    // START DATE
                                    contractsName   = 'start_date[c'+val.contract_id+']';
                                    contractsID     = 'contract_start_date_c'+val.contract_id;
                                    contractsValue  = val.start_date;
                                    mountID     = 'mount_contract_start_date_c'+val.contract_id;
                                    generateDatePickerTH(mountID);

                                    // END DATE
                                    contractsName   = 'end_date[c'+val.contract_id+']';
                                    contractsID     = 'contract_end_date_c'+val.contract_id;
                                    contractsValue  = val.end_date;
                                    mountID     = 'mount_contract_end_date_c'+val.contract_id;
                                    generateDatePickerTH(mountID);

                                    if ($.trim(val.color_button) != '') {
                                        $('#contract_start_date_c'+val.contract_id).addClass('text-danger');
                                        $('#contract_end_date_c'+val.contract_id).addClass('text-danger');
                                    }
                                });

                            }else{
                                if(data.type == 'validate'){
                                    printErrorMsgContact(data);
                                }else{
                                    AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                                }
                            }
                        }
                    });
                }
            });

        }

        function clearContracts()
        {
            $("#formContract input[name*='contract_number']").val('');
            $("#formContract input[name*='start_date']").val('');
            $("#formContract input[name*='end_date']").val('');
        }

        function insertContractBooks()
        {
            $('#button_update_contrac_books').attr('disabled', true);

            const formData = new FormData(document.getElementById("formContractBook"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/customers/domestics/insert-customers-contractbooks") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    console.log(res);
                    var data = res.data;
                    if(data.data){
                        AlertToast('','บันทึกข้อมูลเรียบร้อยแล้ว','success');
                        clearContractsBook();
                        html = '';
                        $.each(data.dataList, function( key, val ) {

                            html += '<tr id="contract_book_roll_b'+val.contract_book_id+'" class="contract_book_del_all '+val.color_button+'">';
                            html += '    <td>';
                            html += '        <input type="hidden"  name="contract_book_id[b'+val.contract_book_id+']" value="'+val.contract_book_id+'">';
                            html += '        <input type="hidden" name="customer_id" value="'+customer_id+'">';
                            html += '        <input type="text" class="form-control no-line" placeholder="ระบุเลขที่สัญญา..." name="book_number[b'+val.contract_book_id+']" id="book_number_'+val.contract_book_id+'" value="'+val.book_number+'" autocomplete="off">';
                            html += '    </td>';
                            html += '    <td>';
                            html += '        <div class="input-icon">';
                            html += '           <div id="mount_book_start_date_b'+val.contract_book_id+'"></div>';
                            // html += '            <input type="text" class="form-control no-line mw-120 date" name="book_start_date[b'+val.contract_book_id+']" id="book_start_date_'+val.contract_book_id+'" placeholder="ระบุวันที่..." value="'+val.book_start_date+'" autocomplete="off">';
                            // html += '            <i class="fa fa-calendar"></i>';
                            html += '        </div>';
                            html += '    </td>';
                            html += '    <td>';
                            html += '        <div class="input-icon">';
                            html += '           <div id="mount_book_end_date_b'+val.contract_book_id+'"></div>';
                            // html += '            <input type="text" class="form-control no-line mw-120 date" name="book_end_date[b'+val.contract_book_id+']" id="book_end_date_'+val.contract_book_id+'" placeholder="ระบุวันที่..." value="'+val.book_end_date+'" autocomplete="off">';
                            // html += '            <i class="fa fa-calendar"></i>';
                            html += '        </div>';
                            html += '    </td>';
                            html += '    <td>';
                            html += '        <input type="text" class="form-control no-line mw-150 pr-0 text-right ml-auto" name="credit_limit[b'+val.contract_book_id+']" id="book_credit_limit_'+val.contract_book_id+'" placeholder="ระบุวงเงินค้ำประกัน..." value="'+val.credit_limit+'" onkeypress="return isNumber(event)" onkeyup="convertCreditLimit('+val.contract_book_id+')" autocomplete="off">';
                            html += '    </td>';
                            html += '    <td class="text-center"><a class="fa fa-times red" onclick="deleteContractBook('+val.contract_book_id+', '+customer_id+')" href="javascript:(0);"></a></td>';
                            html += '</tr>';
                        });
                        $("#tbContractBook").html(html);

                        $.each(data.dataList, function( key, val ) {
                            // START DATE
                            contractsName   = 'book_start_date[b'+val.contract_book_id+']';
                            contractsID     = 'book_start_date_b'+val.contract_book_id;
                            contractsValue  = val.book_start_date;
                            mountID     = 'mount_book_start_date_b'+val.contract_book_id;
                            generateDatePickerTH(mountID);

                            // END DATE
                            contractsName   = 'book_end_date[b'+val.contract_book_id+']';
                            contractsID     = 'book_end_date_b'+val.contract_book_id;
                            contractsValue  = val.book_end_date;
                            mountID     = 'mount_book_end_date_b'+val.contract_book_id;
                            generateDatePickerTH(mountID);

                            if ($.trim(val.color_button) != '') {
                                $('#book_start_date_b'+val.contract_book_id).addClass('text-danger');
                                $('#book_end_date_b'+val.contract_book_id).addClass('text-danger');
                            }
                        });


                    }else{
                        if(data.type == 'validate'){
                            printErrorMsgContact(data);
                        }else{
                            AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                        }
                    }

                    $('#button_update_contrac_books').attr('disabled', false);
                }
            });
        }

        function deleteContractBook(contractbookID, customerID)
        {
            Swal.fire({
                title: '',
                text: "คุณต้องการลบรายการนี้หรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#ed4859',
                confirmButtonText: 'ลบรายการ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : '{{ url("om/ajax/customers/domestics/delete-customers-contractbooks") }}/'+contractbookID+'/'+customerID,
                        success : function(res){
                            console.log(res);
                            var data = res.data;
                            if(data.data){
                                AlertToast('','ลบข้อมูลเรียบร้อยแล้ว','success');
                                clearContractsBook();
                                html = '';
                                $.each(data.dataList, function( key, val ) {

                                    html += '<tr id="contract_book_roll_b'+val.contract_book_id+'" class="contract_book_del_all '+val.color_button+'">';
                                    html += '    <td>';
                                    html += '        <input type="hidden"  name="contract_book_id[b'+val.contract_book_id+']" value="'+val.contract_book_id+'">';
                                    html += '        <input type="hidden" name="customer_id" value="'+customer_id+'">';
                                    html += '        <input type="text" class="form-control no-line" placeholder="ระบุเลขที่สัญญา..." name="book_number[b'+val.contract_book_id+']" id="book_number_'+val.contract_book_id+'" value="'+val.book_number+'" autocomplete="off">';
                                    html += '    </td>';
                                    html += '    <td>';
                                    html += '        <div class="input-icon">';
                                    html += '           <div id="mount_book_start_date_b'+val.contract_book_id+'"></div>';
                                    // html += '            <input type="text" class="form-control no-line mw-120 date" name="book_start_date[b'+val.contract_book_id+']" id="book_start_date_'+val.contract_book_id+'" placeholder="ระบุวันที่..." value="'+val.book_start_date+'" autocomplete="off">';
                                    // html += '            <i class="fa fa-calendar"></i>';
                                    html += '        </div>';
                                    html += '    </td>';
                                    html += '    <td>';
                                    html += '        <div class="input-icon">';
                                    html += '           <div id="mount_book_end_date_b'+val.contract_book_id+'"></div>';
                                    // html += '            <input type="text" class="form-control no-line mw-120 date" name="book_end_date[b'+val.contract_book_id+']" id="book_end_date_'+val.contract_book_id+'" placeholder="ระบุวันที่..." value="'+val.book_end_date+'" autocomplete="off">';
                                    // html += '            <i class="fa fa-calendar"></i>';
                                    html += '        </div>';
                                    html += '    </td>';
                                    html += '    <td>';
                                    html += '        <input type="text" class="form-control no-line mw-150 pr-0 text-right ml-auto" name="credit_limit[b'+val.contract_book_id+']" id="book_credit_limit_'+val.contract_book_id+'" placeholder="ระบุวงเงินค้ำประกัน..." value="'+val.credit_limit+'" onkeypress="return isNumber(event)" onkeyup="convertCreditLimit('+val.contract_book_id+')" autocomplete="off">';
                                    html += '    </td>';
                                    html += '    <td class="text-center"><a class="fa fa-times red" onclick="deleteContractBook('+val.contract_book_id+', '+customer_id+')" href="javascript:(0);"></a></td>';
                                    html += '</tr>';
                                });
                                $("#tbContractBook").html(html);

                                $.each(data.dataList, function( key, val ) {
                                    // START DATE
                                    contractsName   = 'book_start_date[b'+val.contract_book_id+']';
                                    contractsID     = 'book_start_date_b'+val.contract_book_id;
                                    contractsValue  = val.book_start_date;
                                    mountID     = 'mount_book_start_date_b'+val.contract_book_id;
                                    generateDatePickerTH(mountID);

                                    // END DATE
                                    contractsName   = 'book_end_date[b'+val.contract_book_id+']';
                                    contractsID     = 'book_end_date_b'+val.contract_book_id;
                                    contractsValue  = val.book_end_date;
                                    mountID     = 'mount_book_end_date_b'+val.contract_book_id;
                                    generateDatePickerTH(mountID);

                                    if ($.trim(val.color_button) != '') {
                                        $('#book_start_date_b'+val.contract_book_id).addClass('text-danger');
                                        $('#book_end_date_b'+val.contract_book_id).addClass('text-danger');
                                    }
                                });

                            }else{
                                if(data.type == 'validate'){
                                    printErrorMsgContact(data);
                                }else{
                                    AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                                }
                            }
                        }
                    });
                }
            });
        }

        function clearContractsBook()
        {
            $("#formContractBook input[name*='book_number']").val('');
            $("#formContractBook input[name*='book_start_date']").val('');
            $("#formContractBook input[name*='book_end_date']").val('');
            $("#formContractBook input[name*='credit_limit']").val('');
        }

        function showContractBooks()
        {
            clearContractsBook();
            $('.formContractBook').show();
        }

        function numberFormat(nStr)
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

        function insertContractGroups()
        {
            $('#btn_update_contract_groups').attr('disabled', true);
            const formData = new FormData(document.getElementById("formContractGroup"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/customers/domestics/insert-customers-contractgroup") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    console.log(res);
                    var data = res.data;
                    if(data.status == true){
                        AlertToast('','บันทึกข้อมูลเรียบร้อยแล้ว','success');
                        var html = '';
                        var checkSelect = '';
                        $.each(data.dataList, function( key, val ) {

                            html    += '<tr id="contract_group_roll_'+val.contract_group_id+'" class="contract_group_del_all">';
                            html    += '    <td>';
                            html    += '        <input type="hidden"  name="contract_group_id[g'+val.contract_group_id+']" value="'+val.contract_group_id+'">';
                            html    += '        <input type="hidden" name="customer_id" value="'+customer_id+'">';
                            html    += '        <select class="custom-select no-line mw-120 select-group-code" name="select_credit_group_code[g'+val.contract_group_id+']" id="select_credit_group_code_'+val.contract_group_id+'" onchange="selectCreditGroupCode('+val.contract_group_id+')">';
                            html    += '            <option value=""> &nbsp; </option>';

                            $.each(creditGroup, function(key,valGroup){

                                if (val.credit_group_code == valGroup.lookup_code) {
                                    checkSelect = 'selected';
                                }else{
                                    checkSelect = '';
                                }

                                if (customers.customer_type_id == 20) {
                                    if (valGroup.lookup_code == 3) {
                            html    += '                    <option '+checkSelect+' data-day="'+valGroup.tag+'" value="'+valGroup.lookup_code+'">'+valGroup.lookup_code+'</option>';
                                    }
                                }else{
                            html    += '            <option '+checkSelect+' data-day="'+valGroup.tag+'" value="'+valGroup.lookup_code+'">'+valGroup.lookup_code+'</option>';
                                }
                            });

                            html    += '        </select>';
                            html    += '    </td>';
                            html    += '    <td>';
                            html    += '        <input type="hidden" name="credit_group_code[g'+val.contract_group_id+']" id="credit_group_code_'+val.contract_group_id+'" value="'+val.credit_group_code+'">';
                            html    += '        <input type="text" class="form-control no-line" name="credit_percentage[g'+val.contract_group_id+']" id="credit_percentage_'+val.contract_group_id+'" placeholder="% เงินเชื่อ" required onkeypress="return isNumber(event)" autocomplete="off" maxlength="3" value="'+val.credit_percentage+'">';
                            html    += '    </td>';
                            html    += '    <td>';
                            html    += '        <input type="text" class="form-control no-line" name="credit_amount[g'+val.contract_group_id+']" id="credit_amount_'+val.contract_group_id+'" placeholder="จำนวนวงเงิน" required onkeypress="return isNumber(event)" onkeyup="convertGroupCreditAmount('+val.contract_group_id+')" autocomplete="off" value="'+val.credit_amount+'">';
                            html    += '    </td>';
                            html    += '    <td>';
                            html    += '        <input type="text" class="form-control no-line mw-120 day-amount" readonly name="day_amount[g'+val.contract_group_id+']" id="day_amount_'+val.contract_group_id+'" placeholder="จำนวนวันที่เชื่อ" autocomplete="off" value="'+val.day_amount+'">';
                            html    += '    </td>';
                            html    += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteContractGroup('+val.contract_group_id+', '+val.customer_id+')"></a></td>';
                            html    += '</tr>';
                        });
                        $("#tbContractGroup").html(html);
                        $("#resultCredit").html(data.count);

                        $('.date').datepicker();
                    }else{
                        if(data.data == 'Over'){
                            AlertToast('','ผลรวมจำนวนวงเกิน ต้องน้อยกว่า วงเงินค้ำประกันธนาคาร','error');
                        }else{
                            AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                        }
                    }
                    $('#btn_update_contract_groups').attr('disabled', false);
                }
            });
        }

        function deleteContractGroup(contractgroupID, customerID)
        {
            Swal.fire({
                title: '',
                text: "คุณต้องการลบรายการนี้หรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#ed4859',
                confirmButtonText: 'ลบรายการ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : '{{ url("om/ajax/customers/domestics/delete-customers-contractgroups") }}/'+contractgroupID+'/'+customerID,
                        success : function(res){
                            console.log(res);
                            var data = res.data;
                            if(data.data){
                                AlertToast('','ลบข้อมูลเรียบร้อยแล้ว','success');
                                var html = '';
                                var checkSelect = '';
                                $.each(data.dataList, function( key, val ) {

                                    html    += '<tr id="contract_group_roll_g'+val.contract_group_id+'" class="contract_group_del_all">';
                                    html    += '    <td>';
                                    html    += '        <input type="hidden"  name="contract_group_id[g'+val.contract_group_id+']" value="'+val.contract_group_id+'">';
                                    html    += '        <input type="hidden" name="customer_id" value="'+customer_id+'">';
                                    html    += '        <select class="custom-select no-line mw-120 select-group-code" name="select_credit_group_code[g'+val.contract_group_id+']" id="select_credit_group_code_'+val.contract_group_id+'" onchange="selectCreditGroupCode('+val.contract_group_id+')">';
                                    html    += '            <option value=""> &nbsp; </option>';

                                    $.each(creditGroup, function(key,valGroup){

                                        if (val.credit_group_code == valGroup.lookup_code) {
                                            checkSelect = 'selected';
                                        }else{
                                            checkSelect = '';
                                        }

                                        if (customers.customer_type_id == 20) {
                                            if (valGroup.lookup_code == 3) {
                                    html    += '                    <option '+checkSelect+' data-day="'+valGroup.tag+'" value="'+valGroup.lookup_code+'">'+valGroup.lookup_code+'</option>';
                                            }
                                        }else{
                                    html    += '            <option '+checkSelect+' data-day="'+valGroup.tag+'" value="'+valGroup.lookup_code+'">'+valGroup.lookup_code+'</option>';
                                        }
                                    });

                                    html    += '        </select>';
                                    html    += '    </td>';
                                    html    += '    <td>';
                                    html    += '        <input type="hidden" name="credit_group_code[g'+val.contract_group_id+']" id="credit_group_code_'+val.contract_group_id+'" value="'+val.credit_group_code+'">';
                                    html    += '        <input type="text" class="form-control no-line" name="credit_percentage[g'+val.contract_group_id+']" id="credit_percentage_'+val.contract_group_id+'" placeholder="% เงินเชื่อ" required onkeypress="return isNumber(event)" autocomplete="off" maxlength="3" value="'+val.credit_percentage+'">';
                                    html    += '    </td>';
                                    html    += '    <td>';
                                    html    += '        <input type="text" class="form-control no-line" name="credit_amount[g'+val.contract_group_id+']" id="credit_amount_'+val.contract_group_id+'" placeholder="จำนวนวงเงิน" required onkeypress="return isNumber(event)" onkeyup="convertGroupCreditAmount('+val.contract_group_id+')" autocomplete="off" value="'+val.credit_amount+'">';
                                    html    += '    </td>';
                                    html    += '    <td>';
                                    html    += '        <input type="text" class="form-control no-line mw-120 day-amount" readonly name="day_amount[g'+val.contract_group_id+']" id="day_amount_'+val.contract_group_id+'" placeholder="จำนวนวันที่เชื่อ" autocomplete="off" value="'+val.day_amount+'">';
                                    html    += '    </td>';
                                    html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteContractGroup('+val.contract_group_id+', '+val.customer_id+')"></a></td>';
                                    html    += '</tr>';
                                });
                                $("#tbContractGroup").html(html);
                                $("#resultCredit").html(data.count);
                                $("#buttonAddInputContractGroup").attr('disabled', false);

                                $('.date').datepicker();
                            }else{
                                if(data.type == 'validate'){
                                    printErrorMsgContact(data);
                                }else{
                                    AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                                }
                            }
                        }
                    });
                }
            });
        }

        function showContractGroups()
        {
            clearContractsGroup();
            $('.formContractGroup').show();
        }

        function clearContractsGroup()
        {
            $("#formContractGroup select[name*='credit_group_code']").val('');
            $("#formContractGroup input[name*='credit_percentage']").val('100');
            $("#formContractGroup input[name*='credit_amount']").val('');
            $("#formContractGroup input[name*='day_amount']").val('');
        }

        function hideCustomersQuota()
        {
            $("#tab-5 input[name*='quota_header_id']").val('');
            $("#tab-5 input[name*='start_date']").val('');
            $("#tab-5 input[name*='end_date']").val('');
            $("#tab-5 select[name*='status']").val('Active').trigger('change');

            $(".del_all").remove();
            $('.formQuota').hide();
            $('.formStatusQuota').hide();
            $('.formTablesQuota').hide();

            $('#qouta_start_date').html('<div id="mount_quota_start_date"></div>');
            $('#qouta_end_date').html('<div id="mount_quota_end_date"></div>');

            contractsName   = 'start_date';
            contractsID     = 'quotaStart';
            contractsValue  = '';
            mountID     = 'mount_quota_start_date';
            generateDatePickerTH(mountID);

            contractsName   = 'end_date';
            contractsID     = 'quotaEnd';
            contractsValue  = '';
            mountID     = 'mount_quota_end_date';
            generateDatePickerTH(mountID);
        }

        function showCustomersQuota()
        {
            $("#tab-5 input[name*='quota_header_id']").val('');
            $("#tab-5 input[name*='start_date']").val('');
            $("#tab-5 input[name*='end_date']").val('');
            $("#tab-5 select[name*='status']").val('Active').trigger('change');

            $(".del_all").remove();
            $('.formQuota').show();
            $('.formStatusQuota').show();
            $('.formTablesQuota').show();

            $('#qouta_start_date').html('<div id="mount_quota_start_date"></div>');
            $('#qouta_end_date').html('<div id="mount_quota_end_date"></div>');

            contractsName   = 'start_date';
            contractsID     = 'quotaStart';
            contractsValue  = '';
            mountID     = 'mount_quota_start_date';
            generateDatePickerTH(mountID);

            contractsName   = 'end_date';
            contractsID     = 'quotaEnd';
            contractsValue  = '';
            mountID     = 'mount_quota_end_date';
            generateDatePickerTH(mountID);
        }

        function insertCustomersQuota()
        {

            if ($.trim($('#quotaStart').val()) == '' || $.trim($('#quotaEnd').val()) == '') {
                AlertToast('','กรุณาระบุ วันที่ใช้งาน ให้ครบ','error');
            }else{
                const formData = new FormData(document.getElementById("formCustomersQuota"));
                formData.append('_token','{{ csrf_token() }}');

                $.ajax({
                    url         : '{{ url("om/ajax/customers/domestics/insert-customers-quota") }}',
                    type        : 'post',
                    data        : formData,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    success     : function(res){
                        console.log(res);
                        var data = res.data;
                        if(data.status == 'success'){
                            AlertToast('','สร้างข้อมูลเรียบร้อยแล้ว','success');
                            html = '';
                            var quotaNum = 1;
                            $.each(data.dataList, function( key, val ) {
                                html += '<tr>';
                                html += '    <td>'+quotaNum+'</td>';
                                html += '    <td>'+val.start_date+'</td>';
                                html += '    <td>'+val.end_date+'</td>';
                                html += '    <td>'+val.status+'</td>';
                                html += '    <td><a onclick="showQuotaHeaders('+val.quota_header_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                                    html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteQuota('+val.quota_header_id+', '+val.customer_id+')"></a></td>';
                                html += '</tr>';
                                quotaNum++;
                            });
                            $("#quotaList").html(html);
                            $('.formQuota').hide();
                            $('.formStatusQuota').hide();
                            $('.formTablesQuota').hide();

                            $('#qouta_start_date').html('<div id="mount_quota_start_date"></div>');
                            $('#qouta_end_date').html('<div id="mount_quota_end_date"></div>');

                            contractsName   = 'start_date';
                            contractsID     = 'quotaStart';
                            contractsValue  = '';
                            mountID     = 'mount_quota_start_date';
                            generateDatePickerTH(mountID);

                            contractsName   = 'end_date';
                            contractsID     = 'quotaEnd';
                            contractsValue  = '';
                            mountID     = 'mount_quota_end_date';
                            generateDatePickerTH(mountID);

                        }else if(data.status == 'overlap'){
                            AlertToast('','วันที่ใช้งานต้องไม่ Overlap กับข้อมูลอื่น','error');
                        }else{
                            if(data.type == 'validate'){
                                printErrorMsgContact(data);
                            }else{
                                AlertToast('','กรุณากรอกข้อมูลให้ครบ','error');
                            }
                        }
                    }
                });
            }
        }

        function updateCustomersQuota()
        {
            var id = $("#QuotaID").val();

            if(id <= 0){
                insertCustomersQuota();
            }else{
                const formData = new FormData(document.getElementById("formCustomersQuota"));
                formData.append('_token','{{ csrf_token() }}');
                formData.append('dis_quota_start_date', quotaStartDate);
                formData.append('dis_quota_end_date', quotaEndDate);
                formData.append('dis_quota_status', quotaStatus);

                $.ajax({
                    url         : '{{ url("om/ajax/customers/domestics/update-customers-quota") }}/'+id,
                    type        : 'post',
                    data        : formData,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    success     : function(res){
                        console.log(res);
                        var data = res.data;
                        if(data.status == 'success'){
                            AlertToast('','อัพเดทข้อมูลเรียบร้อยแล้ว','success');
                            html = '';
                            var quotaNum = 1;
                            $.each(data.dataList, function( key, val ) {
                                html += '<tr>';
                                html += '    <td>'+quotaNum+'</td>';
                                html += '    <td>'+val.start_date+'</td>';
                                html += '    <td>'+val.end_date+'</td>';
                                html += '    <td>'+val.status+'</td>';
                                html += '    <td><a onclick="showQuotaHeaders('+val.quota_header_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                                    html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteQuota('+val.quota_header_id+', '+val.customer_id+')"></a></td>';
                                html += '</tr>';
                                quotaNum++;
                            });
                            $("#quotaList").html(html);
                            $('.formQuota').hide();
                            $('.formStatusQuota').hide();
                            $('.formTablesQuota').hide();

                            $('#qouta_start_date').html('<div id="mount_quota_start_date"></div>');
                            $('#qouta_end_date').html('<div id="mount_quota_end_date"></div>');

                            contractsName   = 'start_date';
                            contractsID     = 'quotaStart';
                            contractsValue  = '';
                            mountID     = 'mount_quota_start_date';
                            generateDatePickerTH(mountID);

                            contractsName   = 'end_date';
                            contractsID     = 'quotaEnd';
                            contractsValue  = '';
                            mountID     = 'mount_quota_end_date';
                            generateDatePickerTH(mountID);

                        }else if(data.status == 'overlap'){
                            AlertToast('','วันที่ใช้งานต้องไม่ Overlap กับข้อมูลอื่น','error');
                        }else{
                            if(data.type == 'validate'){
                                printErrorMsgContact(data);
                            }else{
                                AlertToast('','กรุณากรอกข้อมูลให้ครบ','error');
                            }
                        }
                    }
                });
            }
        }

        function addInputLinesItems()
        {
            var html = '';
            html += '<tr id="quota_line_roll_'+roll+'" class="del_all">';
            html += '    <td class="text-left">';
            html += '        <div class="form-group">';
            html += '            <div class="input-icon">';
            html += '                <input type="hidden" name="quota_line_id['+roll+']" id="quota_line_id_'+roll+'" value="">';
            html += '                <input type="hidden" readonly placeholder="" name="item_id['+roll+']" id="item_id_'+roll+'" value="">';
            html += '               <input type="text" class="form-control sequence-qouta" name="item_code['+roll+']" id="item_code_'+roll+'" list="sequence-list-'+roll+'" onchange="selectQuotaLines('+roll+');" autocomplete="off">';
            html += '               <i class="fa fa-search"></i>';
            html += '               <datalist id="sequence-list-'+roll+'">';

            $.each(sequenceEcomsList, function(key,val){
            if (val.item_code != '') {
            html += '                   <option value="'+val.item_code+'">'+val.ecom_item_description+'</option>';
            }
            });
            html += '                </datalist>';
            html += '                <i class="fa fa-search" onclick="selectQuotaLines('+roll+');"></i>';
            html += '            </div>';
            html += '        </div>';
            html += '    </td>';
            html += '    <td class="text-left">';
            html += '        <input type="text" class="form-control text-center mw-250 m-auto" readonly placeholder="" name="item_description['+roll+']" id="item_description_'+roll+'" value="" autocomplete="off">';
            html += '    </td>';
            html += '    <td>';
            html += '        <input type="text" class="form-control text-center mw-120 m-auto" placeholder="" name="received_quota['+roll+']" id="received_quota_'+roll+'" value="" required onchange="calculateQuota('+roll+')" onkeypress="return isNumber(event)" onkeyup="convertReceived('+roll+')" autocomplete="off">';
            html += '    </td>';
            html += '    <td>';
            html += '        <input type="text" class="form-control text-center mw-120 m-auto" placeholder="" name="minimum_quota['+roll+']" id="minimum_quota_'+roll+'" value="1" required onchange="calculateQuota('+roll+')" onkeypress="return isNumber(event)" onkeyup="convertMinimum('+roll+')" autocomplete="off">';
            html += '    </td>';
            html += '    <td>';
            html += '        <input type="text" class="form-control text-center mw-120 m-auto" readonly placeholder="" name="remaining_quota['+roll+']" id="remaining_quota_'+roll+'" value="" autocomplete="off">';
            html += '     </td>';
            html += '     <td class="text-center"><a class="fa fa-times red" onclick="deleteProduct(`quota_line_roll_`,'+roll+');" href="javascript:(0);"></a></td>';
            html += '</tr>';

            $("#quotaLinesLists").append(html);
            roll +=1;

            checkQuotarLineDuplicate('');
        }

        function checkQuotarLineDuplicate(index)
        {
            var arr = [];
            $('.sequence-qouta').each(function () {
                arr.push($(this).val());
            });

            var recipientsArray = arr.sort();
            var reportRecipientsDuplicate = [];
            for (var i = 0; i < recipientsArray.length - 1; i++) {
                if (recipientsArray[i + 1] == recipientsArray[i]) {
                    reportRecipientsDuplicate.push(recipientsArray[i]);
                }
            }

            if (reportRecipientsDuplicate.length > 0) {
                $('#buttonSaveQuota').prop('disabled', true);
                $('#item_code_'+index).val('');

                // AlertToast('', 'รหัสผลิตภัณฑ์นี้ ถูกใช้แล้ว','error');

            }else{
                var selectID = '';
                $('.sequence-qouta').each(function (){
                    selectID = $(this).attr('id');
                    selectList = $(this).attr('list');

                    $('#'+selectList+' option').prop('disabled', false);

                    $.each(arr, function(key,val){
                        if ($('#'+selectID).val() != val) {
                            $('#'+selectList+' option[value="'+val+'"]').prop('disabled', true);
                        }else{
                            $('#'+selectList+' option[value="'+val+'"]').prop('disabled', false);
                        }
                    });
                });

                $('#buttonSaveQuota').prop('disabled', false);
            }
        }

        // function selectItemsSequence(v){
        // if(v != ''){
        //     var index = _.findIndex(sequenceEcomsList, function(o) {return o['item_code'] == v;});
        //     if(index != -1){
        //         $('#item_description').val(sequenceEcomsList[index]['item_description']);
        //     }
        // }else{
        //     $('#item_description').val('');
        // }

        function selectQuotaLines(index)
        {
            checkQuotarLineDuplicate(index);

            var itemCode = $("#item_code_"+index).val();

            if(itemCode == '')
            {
                $("#item_description_"+index).val('');
            }else if(itemCode != ''){

                var itemID = '';
                var itemKey = '';
                $.each(sequenceEcomsList, function(key,val){
                    if (val.item_code == itemCode) {
                        itemID = val.item_id;
                        itemKey = val.ecom_item_description;
                    }
                });

                $("#item_id_"+index).val(itemID);
                $("#item_description_"+index).val(itemKey);

            }else{
                $("#item_id_"+index).val('');
                $("#item_description_"+index).val('');
            }
        }

        function deleteProduct(trID, index)
        {
            $('#'+trID+''+index).remove();
        }

        function deleteDataProduct(trID, index)
        {
            var quotaLineID = $('#quota_line_id_'+index).val();

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/delete-customers-quota-line") }}/'+quotaLineID,
                success : function(res){
                    var data = res.data;
                    if(data.status == 'success'){
                        $('#'+trID+''+index).remove();
                        AlertToast('','ลบข้อมูลเรียบร้อยแล้ว','success');
                    }else{
                        AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                    }
                }
            });
        }

        function calculateQuota(index)
        {
            var getFirstNumber = $('#received_quota_'+index).val();
            var getSecondNumber = $('#minimum_quota_'+index).val();
            var result = 0;

            var firstNumber = Number(getFirstNumber.replace(/[^0-9.-]+/g,""));
            var secondNumber = Number(getSecondNumber.replace(/[^0-9.-]+/g,""));


            if(firstNumber > 0){
                result = getFirstNumber;
            }

            if(firstNumber < secondNumber){
                AlertToast('','ยอดสั่งซื้อขั้นต่ำ ต้องน้อยกว่า โควต้าที่ได้รับ','error');
                $('#minimum_quota_'+index).val(1);
            }

            if(secondNumber <= 0){
                AlertToast('','ยอดสั่งซื้อขั้นต่ำ ต้องมากกว่า 0','error');
                $('#minimum_quota_'+index).val(1);
            }

            $('#remaining_quota_'+index).val(result);
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

        function deleteQuota(quotaID, customerID)
        {
            Swal.fire({
                    title: 'คุณต้องการลบรายการนี้หรือไม่?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1ab394',
                    cancelButtonColor: '#ed4859',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        clearContractsGroup();
                        $.ajax({
                            url : '{{ url("om/ajax/customers/domestics/delete-customers-quota") }}/'+quotaID+'/'+customerID,
                            success : function(res){
                                console.log(res);
                                var data = res.data;
                                if(data.data){
                                    AlertToast('','ลบข้อมูลเรียบร้อยแล้ว','success');
                                    html = '';
                                    var quotaNum = 1;
                                    $.each(data.dataList, function( key, val ) {
                                        html += '<tr>';
                                        html += '    <td>'+quotaNum+'</td>';
                                        html += '    <td>'+val.start_date+'</td>';
                                        html += '    <td>'+val.end_date+'</td>';
                                        html += '    <td>'+val.status+'</td>';
                                        html += '    <td><a onclick="showQuotaHeaders('+val.quota_header_id+')" ><i class="fa fa-newspaper-o"></i></td>';
                                        html += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteQuota('+val.quota_header_id+', '+val.customer_id+')"></a></td>';
                                        html += '</tr>';
                                        quotaNum++;
                                    });
                                    $("#quotaList").html(html);
                                    $('.formQuota').hide();
                                    $('.formStatusQuota').hide();
                                    $('.formTablesQuota').hide();
                                }else{
                                    if(data.type == 'validate'){
                                        printErrorMsgContact(data);
                                    }else{
                                        AlertToast('','เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง','error');
                                    }
                                }
                            }
                        });
                        Swal.close();
                    }else{
                        Swal.close();
                    }
                });
        }

        function showCustomers()
        {
            $('#customersProvince').val('{{ $customers->province_code }}').trigger('change');
        }

        // THAILAND TERRITORY CUSTOMERS

        $('#customersProvince').change(function(){
            $('#customersProvinceName').val($(this).find(':selected').data('value'));

            var id      = $('#customersProvince').val();
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/city-list") }}/'+id+'/'+shipID,
                success : function(res){
                    city            = res.data.data;
                    cusShipSites    = res.data.cusShipSites;
                    var html        = '';
                    var checkSelect = '';
                    html += '<option value=""> &nbsp; </option>';
                    $.each(city, function(key,val){
                        if (val.city_thai == customers.city) {
                            checkSelect = 'selected';
                        }
                        else if(val.city_thai == '{{ $customers->city }}')
                        {
                            if(shipID !== 0 && val.city_thai === cusShipSites.city){
                                checkSelect = 'selected';
                            }else{
                                checkSelect = 'selected';
                            }
                        }
                        else{
                            checkSelect = '';
                        }
                        html += '<option '+checkSelect+' data-id="'+val.city_code+'" value="'+val.city_thai+'">'+val.city_thai+'</option>';
                    });
                    $('#customersCity').html(html).trigger('chosen:updated');
                    $('#customersCity').html(html).trigger('change');
                    $("#tab-1 select[name*='region_code']").val(res.data.regionText).trigger("chosen:updated");
                    $("#tab-1 select[name*='city']").trigger('chosen:updated');
                }
            });

        });

        $('#customersCity').change(function(){

            var id      = $(this).find(':selected').data('id');
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;
            $('#customersCityCode').val(id);

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/district-list") }}/'+id+'/'+shipID,
                success : function(res){
                    tambon          = res.data;
                    var checkSelect = '';
                    var html        = '';
                    console.log(tambon, 'customersCity');
                    html += '<option value=""> &nbsp; </option>';
                    $.each(tambon, function(key,val){
                        if (val.tambon_thai == customers.district) {
                            checkSelect = 'selected';
                        }
                        else if(val.tambon_thai == '{{ $customers->district }}')
                        {
                            checkSelect = 'selected';
                        }
                        else{
                            checkSelect = '';
                        }

                        html += '<option '+checkSelect+' data-id="'+val.tambon_id+'" value="'+val.tambon_thai+'">'+val.tambon_thai+'</option>';
                    });
                    $('#customersDistrict').html(html).trigger('chosen:updated');
                    $('#customersDistrict').html(html).trigger('change');
                    $("#tab-1 select[name*='district']").trigger('change');
                }
            });

        });

        $('#customersDistrict').change(function(){

            var id      = $(this).find(':selected').data('id');
            var shipID  = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;
            $('#customersDistrictCode').val(id);

            if (id == undefined) {
                return false;
            }

            $.ajax({
                url : '{{ url("om/ajax/customers/domestics/postcode") }}/'+id+'/'+shipID,
                success : function(res){
                    var postalCode = res.data;
                    $("#tab-1 input[name*='postal_code']").val(postalCode).trigger('chosen:updated');
                }
            });

        });

        $('#customersRegion').change(function(){
            $('#customersRegionName').val($(this).find(':selected').data('value'));
        });

        function validateEmail(email) {
            const isEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return isEmail.test(String(email).toLowerCase());
        }

        $('#ship_to_site_name').change(function(){

            var id              = $("#ship_site_customer_id").val();
            var shipID          = $("#shipSitesID").val() ? $("#shipSitesID").val() : 0;
            var shipSiteName    = $('#ship_to_site_name').val();
            var shipNameStatus  = true;

            if (shipSiteName == '') {
                return false;
            }else{
                $.ajax({
                    url : '{{ url("om/ajax/customers/domestics/get-ship-site-name") }}/'+id+'/'+shipID,
                    success : function(res){
                        var shipSiteNameData = '';

                        if (res.data.dataList != null) {
                            $.each(res.data.dataList, function(key,val){
                                if (val.ship_to_site_name == shipSiteName) {
                                    shipNameStatus = false;
                                }
                            });
                        }

                        if (shipNameStatus == false) {
                            AlertToast('','ชื่อสถานที่จัดส่งนี้ถูกใช้งานแล้ว','error');
                            $("#btnUpdateShipsite").attr('disabled', true);
                        }else{
                            $("#btnUpdateShipsite").attr('disabled', false);
                        }
                    }
                });
            }

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
            x2 = x.length > 1 ? '.' + x[1] : '.00';
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

        function convertReceived(index)
        {
            var received        = $('#received_quota_'+index);
            formatCurrency(received, '');
        }

        function convertMinimum(index)
        {
            var minimum     = $('#minimum_quota_'+index);
            formatCurrency(minimum, '');
        }

        function addInputContract()
        {
            var html = '';
            html += '<tr id="contract_roll_'+rollContract+'" class="contract_del_all">';
            html += '    <td>';
            html += '       <input type="hidden"  name="customer_id" value="'+customer_id+'">';
            html += '       <input type="hidden"  name="manage_customer_contracts[]" id="manage_customer_contracts_'+rollContract+'" value="'+rollContract+'">';
            html += '       <input type="text" class="form-control no-line" placeholder="ระบุเลขที่สัญญา..." name="contract_number['+rollContract+']" autocomplete="off">';
            html += '    </td>';
            html += '    <td>';
            html += '        <div class="input-icon">';
            html += '           <div id="mount_contract_start_date_'+rollContract+'"></div>';
            // html += '            <input type="text" class="form-control no-line mw-120 date" name="start_date['+rollContract+']" placeholder="ระบุวันที่..." value="" autocomplete="off">';
            // html += '            <i class="fa fa-calendar"></i>';
            html += '        </div>';
            html += '    </td>';
            html += '    <td>';
            html += '        <div class="input-icon">';
                html += '           <div id="mount_contract_end_date_'+rollContract+'"></div>';
            // html += '            <input type="text" class="form-control no-line mw-120 date" name="end_date['+rollContract+']" placeholder="ระบุวันที่..." value="" autocomplete="off">';
            // html += '            <i class="fa fa-calendar"></i>';
            html += '        </div>';
            html += '    </td>';
            html += '    <td>';
            html += '        <input type="text" class="form-control no-line mw-150 pr-0 text-right ml-auto" name="guarantee_amount['+rollContract+']" id="guarantee_amount_'+rollContract+'" placeholder="ระบุวงเงิน.." value=""  onkeypress="return isNumber(event)" onkeyup="convertGuarantee('+rollContract+')" autocomplete="off">';
            html += '    </td>';
            html += '    <td class="text-center"><a class="fa fa-times red" onclick="deleteProduct(`contract_roll_`,'+rollContract+');" href="javascript:(0);"></a></td>';
            html += '</tr>';
            $("#tbContract").append(html);

            // START DATE
            contractsName   = 'start_date['+rollContract+']';
            contractsID     = 'contract_start_date_'+rollContract;
            contractsValue  = '';
            mountID     = 'mount_contract_start_date_'+rollContract;
            generateDatePickerTH(mountID);

            // END DATE
            contractsName   = 'end_date['+rollContract+']';
            contractsID     = 'contract_end_date_'+rollContract;
            contractsValue  = '';
            mountID     = 'mount_contract_end_date_'+rollContract;
            generateDatePickerTH(mountID);

            rollContract +=1;
        }

        function addInputContractBook()
        {
            var html = '';
            html    += '<tr id="contract_book_roll_'+rollContractBook+'" class="contract_book_del_all">';
            html += '    <td>';
            html += '        <input type="hidden" name="customer_id" value="'+customer_id+'">';
            html += '        <input type="text" class="form-control no-line" placeholder="ระบุเลขที่สัญญา..." name="book_number['+rollContractBook+']" id="book_number_'+rollContractBook+'" autocomplete="off">';
            html += '    </td>';
            html += '    <td>';
            html += '        <div class="input-icon">';
            html += '           <div id="mount_book_start_date_'+rollContractBook+'"></div>';
            // html += '            <input type="text" class="form-control no-line mw-120 date" name="book_start_date['+rollContractBook+']" id="book_start_date_'+rollContractBook+'" placeholder="ระบุวันที่..." value="" autocomplete="off">';
            // html += '            <i class="fa fa-calendar"></i>';
            html += '        </div>';
            html += '    </td>';
            html += '    <td>';
            html += '        <div class="input-icon">';
            html += '           <div id="mount_book_end_date_'+rollContractBook+'"></div>';
            // html += '            <input type="text" class="form-control no-line mw-120 date" name="book_end_date['+rollContractBook+']" id="book_end_date_'+rollContractBook+'" placeholder="ระบุวันที่..." value="" autocomplete="off">';
            // html += '            <i class="fa fa-calendar"></i>';
            // html += '        </div>';
            html += '    </td>';
            html += '    <td>';
            html += '        <input type="text" class="form-control no-line mw-150 pr-0 text-right ml-auto" name="credit_limit['+rollContractBook+']" id="book_credit_limit_'+rollContractBook+'" placeholder="ระบุวงเงินค้ำประกัน..." onkeypress="return isNumber(event)" onkeyup="convertCreditLimit('+rollContractBook+')" autocomplete="off">';
            html += '    </td>';
            html += '    <td class="text-center"><a class="fa fa-times red" onclick="deleteProduct(`contract_book_roll_`,'+rollContractBook+');" href="javascript:(0);"></a></td>';
            html += '</tr>';
            $("#tbContractBook").append(html);

            // START DATE
            contractsName   = 'book_start_date['+rollContractBook+']';
            contractsID     = 'book_start_date_'+rollContractBook;
            contractsValue  = '';
            mountID     = 'mount_book_start_date_'+rollContractBook;
            generateDatePickerTH(mountID);

            // END DATE
            contractsName   = 'book_end_date['+rollContractBook+']';
            contractsID     = 'book_end_date_'+rollContractBook;
            contractsValue  = '';
            mountID     = 'mount_book_end_date_'+rollContractBook;
            generateDatePickerTH(mountID);

            rollContractBook +=1;
        }

        function convertCreditLimit(index)
        {
            var contractBook = $('#book_credit_limit_'+index);
            formatCurrency(contractBook, '');
        }

        function convertGuarantee(index)
        {
            var guaranteeAmount = $('#guarantee_amount_'+index);
            formatCurrency(guaranteeAmount, '');
        }

        var contractGroupRowCount = $('#tbContractGroup tr').length;

        if(contractGroupRowCount >= creditGroup.length){
            $("#buttonAddInputContractGroup").attr('disabled', true);
        }else{
            $("#buttonAddInputContractGroup").attr('disabled', false);
        }

        function addInputContractGroup()
        {
            contractGroupRowCount++;
            var html = '';
            html    += '<tr id="contract_group_roll_'+rollContractGroup+'" class="contract_group_del_all">';
            html    += '    <td>';
            html    += '        <input type="hidden" name="customer_id" value="'+customer_id+'">';
            html    += '        <select class="custom-select no-line mw-120 select-group-code" name="select_credit_group_code['+rollContractGroup+']" id="select_credit_group_code_'+rollContractGroup+'" onchange="selectCreditGroupCode('+rollContractGroup+')">';
            html    += '            <option value=""> &nbsp; </option>';

            $.each(creditGroup, function(key,val){
                if (customers.customer_type_id == 20) {
                    if (val.lookup_code == 3) {
                        html    += '                    <option data-day="'+val.tag+'" value="'+val.lookup_code+'">'+val.lookup_code+'</option>';
                    }
                }else{
                    html    += '            <option data-day="'+val.tag+'" value="'+val.lookup_code+'">'+val.lookup_code+'</option>';
                }
            });

            html    += '        </select>';
            html    += '    </td>';
            html    += '    <td>';
            html    += '        <input type="hidden" name="credit_group_code['+rollContractGroup+']" id="credit_group_code_'+rollContractGroup+'" value="">';
            html    += '        <input type="text" class="form-control no-line" name="credit_percentage['+rollContractGroup+']" id="credit_percentage_'+rollContractGroup+'" placeholder="% เงินเชื่อ" required onkeypress="return isNumber(event)" autocomplete="off" maxlength="3" value="100">';
            html    += '    </td>';
            html    += '    <td>';
            html    += '        <input type="text" class="form-control no-line" name="credit_amount['+rollContractGroup+']" id="credit_amount_'+rollContractGroup+'" placeholder="จำนวนวงเงิน" required onkeypress="return isNumber(event)" onkeyup="convertGroupCreditAmount('+rollContractGroup+')" autocomplete="off">';
            html    += '    </td>';
            html    += '    <td>';
            html    += '        <input type="text" class="form-control no-line mw-120 day-amount" readonly name="day_amount['+rollContractGroup+']" id="day_amount_'+rollContractGroup+'" placeholder="จำนวนวันที่เชื่อ" autocomplete="off">';
            html    += '    </td>';
            html    += '    <td class="text-center"><a class="fa fa-times red" onclick="deleteContractGroups(`contract_group_roll_`,'+rollContractGroup+');" href="javascript:(0);"></a></td>';
            html    += '</tr>';
            rollContractGroup +=1;
            $("#tbContractGroup").append(html);
            $('.custom-select').select2({width: "100%"});

            if(contractGroupRowCount >= creditGroup.length){
                $("#buttonAddInputContractGroup").attr('disabled', true);
            }else{
                $("#buttonAddInputContractGroup").attr('disabled', false);
            }
        }

        function selectCreditGroupCode(index)
        {
            $('#day_amount_'+index).val($('#select_credit_group_code_'+index).find(':selected').data('day'));

            var valueDisabled = $('#select_credit_group_code_'+index).val();

            $('#credit_group_code_'+index).val(valueDisabled);

            if (valueDisabled != '') {
                $('.select-group-code option[value="'+valueDisabled+'"]').attr('disabled', 'disabled').siblings().removeAttr('disabled');
            }else{
                $('.select-group-code option:selected').attr('disabled', 'disabled').siblings().removeAttr('disabled');
            }
        }

        function deleteContractGroups(trID, index)
        {
            $('#'+trID+''+index).remove();
            $("#buttonAddInputContractGroup").attr('disabled', false);

            contractGroupRowCount--;

            if(contractGroupRowCount >= creditGroup.length){
                $("#buttonAddInputContractGroup").attr('disabled', true);
            }else{
                $("#buttonAddInputContractGroup").attr('disabled', false);
            }
        }

        function convertGroupCreditAmount(index)
        {
            var contractGroup = $('#credit_amount_'+index);
            formatCurrency(contractGroup, '');
        }

        $('#customerName').change(function(){

            var id = customer_id;
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

        $('#customerStatus').change(function() {
            var customerStatus = $('#customerStatus').val();

            if (customerStatus == 'Inactive') {
                var d           = new Date();
                var dayNow      = d.getDate();
                var monthNow    = ("0"+(d.getMonth()+1)).slice(-2);
                var yearNow     = d.getFullYear()+543;
                var dateNow = dayNow + "/" + monthNow + "/" + yearNow;
            }else{
                var dateNow = '';
            }

            $('#customers_cancelled_date').html('<div id="mount_customers_cancelled_date"></div>');
            // BIRTH DATE
            contractsName   = 'cancelled_date';
            contractsID     = 'cancelled_date';
            contractsValue  = dateNow;
            mountID     = 'mount_customers_cancelled_date';
            generateDatePickerTH(mountID);
        });

        $('#sales_channel_id').change(function(){
            $('#sales_channel').val($(this).find(':selected').data('value'));
        });

        $('#price_list_id').change(function()
        {
            $('#price_list').val($(this).find(':selected').data('value'));
        });

        $('#order_type_id').change(function()
        {
            $('#order_type').val($(this).find(':selected').data('value'));
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

        // Example format Date 'dd/mm/yyyy'
        function dateRangeOverlaps(startDateA, endDateA, startDateB, endDateB)
        {
            var result = '';

            if ((endDateA < startDateB) || (startDateA > endDateB)) {
                result = 'pass';
            }else{
                // var obj = {};
                // obj.startDate = startDateA <= startDateB ? startDateB : startDateA;
                // obj.endDate = endDateA <= endDateB ? endDateA : endDateB;

                result = 'overlap';
            }

            return result;
        }

        checkContractAndBookOnload();

        function checkContractAndBookOnload() {
            var customerContracts       = {!! json_encode($customerContracts) !!};
            var customerContractBooks   = {!! json_encode($customerContractBooks) !!};


            $.each(customerContracts, function(key,val){
                if (val.color_button != '') {
                    $('#contract_start_date_c'+val.contract_id).addClass('text-danger');
                    $('#contract_end_date_c'+val.contract_id).addClass('text-danger');
                }
            });

            $.each(customerContractBooks, function(key,val){
                if (val.color_button != '') {
                    $('#book_start_date_b'+val.contract_book_id).addClass('text-danger');
                    $('#book_end_date_b'+val.contract_book_id).addClass('text-danger');
                }
            });
        }

    </script>


    <script>

        // var contractsName   = '';
        // var contractsID     = '';
        // var contractsValue  = '';
        // // var contractsValue  = '27/04/2564';
        // var dateFormat      = '{{ trans('date.js-format') }}';

        // var vm = new Vue({
        //     data() {
        //         return {
        //             pName: contractsName,
        //             pID: contractsID,
        //             pValue: contractsValue,
        //             pFormat: dateFormat,
        //         }
        //     },
        //     template: `<datepicker-th
        //                     style="width: 100%"
        //                     class="form-control md:tw-mb-0 tw-mb-2"
        //                     name=pName
        //                     id=pID
        //                     placeholder="โปรดเลือกวันที่"
        //                     @dateWasSelected='onchangeDate(...arguments)'
        //                     :value=pValue
        //                     :format=pFormat />`,
        //     methods: {
        //         onchangeDate (date) {
        //             vm.pValue = date;
        //         }
        //     },
        //     watch: {
        //         pValue : async function (contractsValue, oldValue) {
        //             console.log('xxx', contractsValue, oldValue);
        //         }
        //     },
        // }).$mount('#'+mountID)

        function generateDatePickerTH(mountID, disabled='')
        {
            var dateFormat      = '{{ trans('date.js-format') }}';

            var vm = new Vue({
                data() {
                    return {
                        pName: contractsName,
                        pID: contractsID,
                        pValue: contractsValue,
                        pFormat: dateFormat,
                        pdisabled: disabled == 'disabled' ? disabled : false,
                    }
                },
                template: `<datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                :name=pName
                                :id=pID
                                placeholder="ระบุวันที่..."
                                @dateWasSelected='onchangeDate(...arguments)'
                                :value=pValue
                                :disabled=pdisabled
                                :format=pFormat />`,
                methods: {
                    onchangeDate (date) {
                        vm.pValue = date;
                    }
                },
                watch: {
                    pValue : async function (contractsValue, oldValue) {
                        console.log('xxx', contractsValue, oldValue);
                    }
                },
            }).$mount('#'+mountID)
        }

    </script>
@stop
