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

    .table.min-1600{min-width:1600px}
    .table.min-2000{min-width:2000px}
    .table.min-2430{min-width:2430px}
    .w-230{min-width: 230px;}

    #page-wrapper {
        width: calc(100% - 220px) !important;
    }

</style>

@section('title', 'บันทึกใบ Proforma Invoice สำหรับขายต่างประเทศ')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <x-get-page-title :menu="$menu" url="" />
    {{-- <h2>
        OMP0072 บันทึกใบ Proforma Invoice สำหรับขายต่างประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>บันทึกใบ Proforma Invoice สำหรับขายต่างประเทศ</strong>
        </li>
    </ol> --}}
@stop

@section('content')

    <form id="formProformaInvoice" autocomplete="none" enctype="multipart/form-data">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ !empty($menu->menu_title) ? $menu->menu_title : '' }}</h3>
            </div>
            <div class="ibox-content">
                <div class="row space-50 justify-content-md-center flex-column mt-md-4">
                    <div class="col-12">
                        <div class="form-header-buttons">
                            <div class="d-flex">
                                <button class="btn btn-md btn-white" type="button" onclick="newResetProformaInvoice()"><i class="fa fa-repeat"></i></button>
                                {{-- <button class="btn btn-md btn-white" type="button" onclick="resetProformaInvoice()"><i class="fa fa-repeat"></i></button> --}}
                            </div>
                            <div class="buttons multiple">
                                {{-- <button class="btn btn-md btn-success" type="button" onclick="createProformaInvoice()"><i class="fa fa-plus"></i> สร้าง</button> --}}
                                {{-- <button class="btn btn-md btn-info" type="button"><i class="fa fa-copy"></i> คัดลอก</button> --}}
                                <button class="btn btn-md btn-white" type="button" onclick="newSearchProformaInvoice()"><i class="fa fa-search"></i> ค้นหา</button>
                                {{-- <button class="btn btn-md btn-white" type="button" onclick="searchProformaInvoice()"><i class="fa fa-search"></i> ค้นหา</button> --}}
                                <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                                <div class="dropdown">
                                    <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);" onclick="manageProformaInvoice('Draft')">บันทึก</a></li>
                                        <li><a href="javascript:void(0);" onclick="manageProformaInvoice('Confirm')">ยืนยัน</a></li>
                                        <li><a href="javascript:void(0);" onclick="checkCancel()">ยกเลิก</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-md btn-info" type="button" onclick="linkToPagePrint()" ><i class="fa fa-print"></i> พิมพ์ใบ Proforma Invoice</button>
                                <button class="btn btn-md btn-info" type="button" onclick="linkToPagePrintInvoice()"><i class="fa fa-print"></i> พิมพ์ใบ IN</button>
                                <button class="btn btn-md btn-info" type="button" onclick="linkToPagePrintPackingList()"><i class="fa fa-print"></i> พิมพ์ Packing List</button>
                            </div>
                        </div><!--form-header-buttons-->

                        <div class="hr-line-dashed"></div>
                    </div><!--col-12-->

                    <div class="col-xl-12 m-auto">
                        <div class="row">
                            <div class="col-xl-7 ml-auto">
                                <div class="row">
                                    <div class="col-md-4 ml-auto">
                                        <div class="form-group">
                                            <label class="d-block"><strong>PI Status</strong></label>
                                            <input type="text" class="form-control" readonly  name="order_status" id="order_status" placeholder="" value="Draft" autocomplete="off">
                                            <input type="hidden" name="pi_header_id" id="pi_header_id" placeholder="" value="" autocomplete="off">
                                            <input type="hidden" name="order_header_id" id="order_header_id" placeholder="" value="" autocomplete="off">
                                            <input type="hidden" name="product_type_code" id="product_type_code" placeholder="" value="" autocomplete="off">
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div>

                            <div class="col-xl-12"></div>

                            <div class="col-xl-5">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- <label class="d-block">เลขที่ใบ PI</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control" readonly name="pi_number" id="pi_number" placeholder="" value="">
                                            </div> --}}

                                            <div class="form-group">
                                                <label class="d-block">เลขที่ใบ PI</label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="pi_number" id="pi_number" list="proforma-list" value="{{ request()->pi_number }}" onchange="selectProformaInvoice()" autocomplete="off">
                                                    <i class="fa fa-search"></i>
                                                    <datalist id="proforma-list">

                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($proformaList as $item)
                                                        @if (!empty($item->pi_number))
                                                        <option value="{{ $item->pi_number }}">{{ $item->pi_number }}</option>
                                                        @endif
                                                        @endforeach

                                                    </datalist>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="d-block">วันที่</label>
                                            <div class="input-icon" id="html_pi_date">
                                                <input type="text" class="form-control date"  name="pi_date" id="pi_date" placeholder="" value="">
                                                <i class="fa fa-calendar"></i>
                                                {{-- <datepicker-th
                                                    style="width: 100%"
                                                    class="form-control md:tw-mb-0 tw-mb-2"
                                                    name="pi_date"
                                                    id="pi_date"
                                                    disabled
                                                    placeholder=""
                                                    value=""
                                                    format="{{ trans("date.js-format") }}"> --}}
                                            </div>
                                            {{-- <input type="hidden" name="pi_date" id="pi_date" value="" autocomplete="off"> --}}
                                        </div>
                                    </div><!--row-->
                                </div><!--form-group-->
                            </div>

                            <div class="col-xl-7">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control" name="order_number" id="order_number" list="order-data-list" value="" onchange="selectOrderNumber()" autocomplete="off">
                                                <i class="fa fa-search"></i>
                                                <datalist id="order-data-list">

                                                    <option value=""> &nbsp; </option>
                                                    @php
                                                        $checkOrderNumber = '';
                                                    @endphp
                                                    @foreach ($orderList as $item)
                                                    @if (!empty($item->order_number ) && $checkOrderNumber != $item->order_number)
                                                    <option value="{{ $item->order_number }}">{{ $item->order_number }}</option>
                                                    @php
                                                        $checkOrderNumber = $item->order_number;
                                                    @endphp
                                                    @endif
                                                    @endforeach

                                                </datalist>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3 mt-md-0">
                                            <label class="d-block">วันที่สั่งซื้อ</label>
                                            <div class="input-icon">
                                                {{-- <input type="text" class="form-control date"  name="order_date" id="order_date" placeholder="" value="">
                                                <i class="fa fa-calendar"></i> --}}
                                                <datepicker-th
                                                    style="width: 100%"
                                                    class="form-control md:tw-mb-0 tw-mb-2"
                                                    name="show_order_date"
                                                    id="show_order_date"
                                                    disabled
                                                    placeholder=""
                                                    value=""
                                                    format="{{ trans("date.js-format") }}">
                                            </div>
                                            <input type="hidden" name="order_date" id="order_date" value="">
                                        </div>
                                        <div class="col-md-4 mt-3 mt-md-0">
                                            {{-- <label class="d-block">เลขที่ใบ SA</label>
                                            <input type="text" class="form-control" readonly name="sa_number" id="sa_number" placeholder="" value=""> --}}
                                            <div class="form-group">
                                                <label class="d-block">เลขที่ SA</label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="sa_number" id="sa_number" list="sale-confirm-list" value="" onchange="selectSaNumber()" autocomplete="off">
                                                    <i class="fa fa-search"></i>
                                                    <datalist id="sale-confirm-list">

                                                        <option value=""> &nbsp; </option>
                                                        @php
                                                            $checkSaNumber = '';
                                                        @endphp
                                                        @foreach ($saNumberList as $item)
                                                        @if (!empty($item->sa_number) && $checkSaNumber != $item->sa_number)
                                                        <option value="{{ $item->sa_number }}">{{ $item->sa_number }}</option>
                                                        @php
                                                            $checkSaNumber = $item->sa_number;
                                                        @endphp
                                                        @endif
                                                        @endforeach

                                                    </datalist>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div><!--form-group-->
                            </div>

                            <!--//-->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="d-block">ลูกค้า <span class="red">*</span></label>
                                    <div class="row space-5">
                                        <div class="col-md-4">
                                            <div class="input-icon">
                                                {{-- <input type="text" class="form-control" name="customer_number" id="customer_number" placeholder="" value="" autocomplete="off">
                                                <i class="fa fa-search"></i> --}}
                                                <input type="text" class="form-control" name="customer_number" id="customer_number" list="customer-list" value="" onchange="selectCustomer()" autocomplete="off">
                                                <i class="fa fa-search"></i>
                                                <datalist id="customer-list">

                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($customerList as $item)
                                                    @if (!empty($item->customer_number))
                                                    <option value="{{ $item->customer_number }}">{{ $item->customer_name }}</option>
                                                    @endif
                                                    @endforeach

                                                </datalist>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-2 mt-md-0">
                                            <input type="hidden" name="customer_id" id="customer_id" value="" autocomplete="off">
                                            <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="" value="" autocomplete="off">
                                        </div>
                                    </div><!--row-->
                                </div><!--form-group-->
                            </div><!--col-->

                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="d-block">Order Type <span class="red">*</span></label>
                                            <div class="input-icon">
                                                <select class="custom-select check-default" name="order_type_id" id="order_type_id">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($orderTypes as $item)
                                                    <option value="{{ $item->order_type_id }}">{{ $item->order_type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="d-block">สกุลเงิน <span class="red">*</span></label>
                                            <div class="row space-5">
                                                <div class="col-6">
                                                    <div class="input-icon">
                                                        {{-- <select class="custom-select" name="currency_code" id="currency_code">
                                                            <option value=""> &nbsp; </option>
                                                            @foreach ($currency as $item)
                                                            <option value="{{ $item->currency_code }}">{{ $item->currency_code }}</option>
                                                            @endforeach
                                                        </select> --}}
                                                        <input type="text" class="form-control" name="currency" id="currency" list="currency-list" value="" onchange="selectCurrency()" autocomplete="off">
                                                        <i class="fa fa-search"></i>
                                                        <datalist id="currency-list">

                                                            <option value=""> &nbsp; </option>
                                                            @foreach ($currency as $item)
                                                            <option value="{{ $item->currency_code }}">{{ $item->name }}</option>
                                                            @endforeach

                                                        </datalist>
                                                        <i class="fa fa-search"></i>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" readonly name="currency_name" id="currency_name" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div><!--row-->
                                        </div><!--form-group-->
                                    </div>
                                </div><!--row-->
                            </div><!--col-xl-7-->

                            <!--//-->

                            <div class="col-xl-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">ที่อยู่</label>
                                    <textarea class="form-control" readonly name="customer_address" id="customer_address" ></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="d-block">เงื่อนไขการชำระเงิน <span class="red">*</span></label>
                                    <div class="row space-5">
                                        <div class="col-md-4">
                                            <div class="input-icon">
                                                <input type="text" class="form-control" name="term_name" id="term_name" list="terms-list" value="" onchange="selectTerm()" autocomplete="off">
                                                <i class="fa fa-search"></i>
                                                <datalist id="terms-list">

                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($terms as $item)
                                                    <option value="{{ $item->name }}">{{ $item->description }}</option>
                                                    @endforeach

                                                </datalist>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-2 mt-md-0">
                                            <input type="text" class="form-control" readonly name="term_description" id="term_description" placeholder="" value="" autocomplete="off">
                                            <input type="hidden" readonly name="term_id" id="term_id" placeholder="" value="" autocomplete="off">
                                        </div>
                                    </div><!--row-->


                                </div><!--form-group-->

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="d-block">ประเภทการจ่ายเงิน <span class="red">*</span></label>
                                            <select class="custom-select check-default" name="payment_type_code" id="payment_type_code">
                                                <option value=""> &nbsp; </option>
                                                @foreach ($paymentType as $item)
                                                <option value="{{ $item->lookup_code }}">{{ $item->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="d-block">Vat Code <span class="red">*</span></label>
                                            <div class="input-icon">
                                                <select class="custom-select check-default" name="vat_code" id="vat_code">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($taxCode as $item)
                                                    <option value="{{ $item->tax_rate_code }}">{{ $item->tax_rate_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div><!--form-group-->

                                <div class="form-group">
                                    <label class="d-block">วิธีการชำระเงิน <span class="red">*</span></label>
                                    <select class="custom-select check-default" name="payment_method_code" id="payment_method_code">
                                        <option value=""> &nbsp; </option>
                                        @foreach ($paymentMethodExport as $item)
                                        <option value="{{ $item->lookup_code }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="d-block">รายละเอียดเพิ่มเติม</label>
                                    <textarea name="remark" id="remark" class="form-control"></textarea>
                                </div>

                            </div><!--col-xl-4-->

                            <div class="col-xl-8 col-md-6">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Bill To <span class="red">*</span></label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control" name="bill_to_site_name" id="bill_to_site_name" placeholder="" value="" autocomplete="off">
                                                <input type="hidden" name="bill_to_site_id" id="bill_to_site_id" value="" autocomplete="off">
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Price List <span class="red">*</span></label>
                                            <select class="custom-select check-price-list" name="price_list_id" id="price_list_id" autocomplete="off">
                                                <option value=""> &nbsp; </option>
                                                @foreach ($priceList as $item)
                                                <option value="{{ $item->list_header_id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Ship To <span class="red">*</span></label>
                                            <div class="input-icon">
                                                <select class="custom-select check-default" name="ship_to_site_id" id="ship_to_site_id">
                                                    <option value=""> &nbsp; </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">{{ !empty($inCortermName) ? $inCortermName : '' }} <span class="red">*</span></label>
                                            <select class="custom-select check-default" name="incoterms_code" id="incoterms_code">
                                                <option value=""> &nbsp; </option>
                                                @foreach ($incoterms as $item)
                                                <option value="{{ $item->lookup_code }}">{{ $item->meaning }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Port of Loading</label>
                                            <input type="text" class="form-control" name="port_of_loading" id="port_of_loading" placeholder="port_of_loading" value="Tobacco Authority of Thailand, Thailand" autocomplete="off">
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Shipment By</label>
                                            <div class="row space-5">
                                                <div class="col-6">
                                                    <select class="custom-select check-default" name="transport_type_code" id="transport_type_code">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($shipmentBy as $item)
                                                        <option value="{{ $item->lookup_code }}"> {{ $item->meaning }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" name="transport_detail" id="transport_detail" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div>
                                        </div><!--form-group-->
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Port of Discharge</label>
                                            <input type="text" class="form-control"  name="port_of_discharge" id="port_of_discharge" value="" autocomplete="off">
                                            {{-- <select class="custom-select check-default" name="port_of_discharge" id="port_of_discharge" autocomplete="off">
                                                <option value=""> &nbsp; </option>
                                            </select> --}}
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">Place of Delivery by On-Carrier</label>
                                            <input type="text" class="form-control"  name="place_of_delivery" id="place_of_delivery" value="" autocomplete="off">
                                            {{-- <select class="custom-select check-default" name="place_of_delivery" id="place_of_delivery">
                                                <option value=""> &nbsp; </option>
                                            </select> --}}
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Shipping Marks</label>
                                            {{-- <input type="text" class="form-control"  name="shipping_marks" id="shipping_marks" placeholder="" value="" autocomplete="off"> --}}
                                            <textarea name="shipping_marks" id="shipping_marks" class="form-control"></textarea>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">เงื่อนไขการขนส่ง</label>
                                            <input type="text" class="form-control"  name="shipment_condition" id="shipment_condition" placeholder="" value="" autocomplete="off">
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">สั่งทาง</label>
                                            <select class="custom-select check-default" name="source_system" id="source_system">
                                                <option value=""> &nbsp; </option>
                                                @foreach ($salesChannel as $item)
                                                <option value="{{ $item->meaning }}">{{ $item->meaning }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">วันที่ส่ง</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control date" name="delivery_date" id="delivery_date" value="" autocomplete="off">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div><!--col-md-6-->

                                    {{-- <div class="col-xl-6">
                                        <div class="form-group">

                                            <label class="d-block">วันที่ส่ง</label>
                                            <div class="input-icon" id="html_delivery_date">
                                                <div id="mount_delivery_date"></div>
                                            </div>
                                        </div>
                                    </div><!--col-md-6--> --}}


                                </div><!--row-->

                            </div><!--col-md-8-->

                        </div><!--row-->
                    </div><!--col-xl-12-->

                    <div class="col-xl-12">
                        <hr class="lg">

                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-hover min-1800 f13">
                                <thead>
                                    <tr class="align-middle">
                                        <!-- <th rowspan="2">Select</th> -->
                                        <th rowspan="2">รายการที่</th>
                                        <th rowspan="2">รหัสสินค้า</th>
                                        <th rowspan="2" class="w-250">ชื่อผลิตภัณฑ์</th>
                                        <th rowspan="2">UOM</th>
                                        <th rowspan="2">หน่วยนับ</th>
                                        <th rowspan="2">จำนวน</th>
                                        <th rowspan="2">ราคา/หน่วย</th>
                                        <th rowspan="2">Amount</th>
                                        <th rowspan="2" class="w-160">Vat Code</th>
                                        <th rowspan="2">Tax Amount</th>
                                        <th rowspan="2">Line Total</th>
                                        <th colspan="2">Weight/Unit</th>
                                        <th colspan="2">Line Total Weight (KG)</th>
                                    </tr>
                                    <tr class="align-middle">
                                        <!--Weight/Unit-->
                                        <th class="w-120">Net</th>
                                        <th class="w-120">Gross</th>

                                        <!--Weight/Unit-->
                                        <th class="w-120">Net</th>
                                        <th class="w-120">Gross</th>
                                    </tr>
                                </thead>
                                <tbody id="orderLines">

                                </tbody>
                                <tbody id="orderLinesTotal">
                                    <tr>
                                        <td class="text-right black" colspan="13"><strong>Total Weight</strong></td>
                                        <td class="text-right black"><strong>0.00</strong></td>
                                        <td class="text-right black"><strong>0.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--table-responsive-->

                    </div>

                    <div class="col-xl-12 mt-5">
                        <div class="paper-row title mb-3 has-bg" data-toggle="collapse" data-target="#collapse_01" aria-expanded="true">
                            <span class="icon-collapse blue"><span class="icon"></span></span> <strong>บันทึกรายละเอียดสินค้า</strong>
                        </div>

                        <div id="collapse_01" class="collapse in show">

                            <div class="col-12" id="manageDetailProduct" style="display: none">
                                <div class="form-header-buttons">
                                    <div class="buttons multiple">
                                        <button class="btn btn-md btn-success" type="button" id="buttonCreateLots" onclick="createProformaLots()"><i class="fa fa-plus"></i> สร้าง</button>
                                        <button class="btn btn-md btn-primary" type="button" id="buttonUpdateLots" onclick="updateProformaLots()"> <i class="fa fa-save"></i> บันทึก</button>
                                        {{-- <button class="btn btn-md btn-danger" type="button" id="buttonDeleteLots" onclick="deleteProformaLots()"><i class="fa fa-times"></i> ลบ</button> --}}
                                        <input type="hidden" name="main_lot_pi_line_id" id="main_lot_pi_line_id" value="">
                                    </div>
                                </div><!--form-header-buttons-->

                                <div class="hr-line-dashed"></div>
                            </div><!--col-12-->

                            <div class="table-responsive">
                                <table class="table table-bordered text-center min-1600 f13">
                                    <thead>
                                        <tr class="align-middle">
                                            <th rowspan="2" class="w-160">รหัสสินค้า(INV)</th>
                                            <th rowspan="2" class="w-230">ชื่อผลิตภัณฑ์(INV)</th>
                                            {{-- <th rowspan="2" class="w-160">Org</th>
                                            <th rowspan="2" class="w-250">Org Name</th>
                                            <th rowspan="2" class="w-200">Subinventory</th>
                                            <th rowspan="2" class="w-230">Locator</th>
                                            <th rowspan="2" class="w-230">Lot</th>
                                            <th rowspan="2" class="w-160">จำนวนสินค้าคงคลัง</th> --}}
                                            <th rowspan="2" class="w-160">จำนวนที่ <br> ต้องการตัด</th>
                                            <th colspan="2" class="w-160">Case No.</th>
                                            <th class="w-200">MMS. PER</th>
                                            <th rowspan="2" class="w-160">Quantity <br> (CBB)</th>
                                            <th colspan="2" class="w-160">Weight/Unit(KG)</th>
                                            <th colspan="2" class="w-160">Total Weight/KG</th>
                                            <th rowspan="2" class="w-90">ลบ</th>
                                        </tr>
                                        <tr class="align-middle">
                                            <!--Weight/Unit-->
                                            <th class="w-120">จาก</th>
                                            <th class="w-120">ถึง</th>

                                            <th class="w-200">BOX</th>

                                            <th class="w-120">Net</th>
                                            <th class="w-120">Gross</th>

                                            <!--Weight/Unit-->
                                            <th class="w-120">Net</th>
                                            <th class="w-120">Gross</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderLots">

                                    </tbody>
                                    <tbody id="orderLotsTotal">
                                        <tr>
                                            <td class="text-right black" colspan="2"><strong>รวม</strong></td>
                                            <td class="text-right black"><strong id="text_total_order_quantity">0.00</strong></td>
                                            <td class="text-right" style="border: 0" colspan="3"></td>
                                            <td class="text-right black"><strong id="text_total_quantity_cbb">0.00</strong></td>
                                            <td class="text-right black" colspan="2"></td>
                                            <td class="text-right black"><strong id="text_total_net_weight">0.00</strong></td>
                                            <td class="text-right black"><strong id="text_total_gross_weight">0.00</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!--collapse-->
                    </div><!--col-xl-12-->

                    <div class="col-xl-12 mt-5 mb-5">

                        <div class="d-block mw-400 ml-auto mr-auto ">
                            <table class="table table-bordered text-center">
                                <tbody>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td> <span id="resultSubtotal"> 0.00 </span> <input type="hidden" name="sub_total" id="sub_total" value="0.00" autocomplete="off"> </td>
                                    </tr>
                                    <tr>
                                        <th>Tax</th>
                                        <td> <span id="resultTax"> 0.00 </span> <input type="hidden" name="tax" id="tax" value="0.00" autocomplete="off"> </td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td> <span id="resultTotal"> 0.00 </span> <input type="hidden" name="grand_total" id="grand_total" value="0.00" autocomplete="off"> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!--col-xl-12-->

                </div><!--row-->
            </div><!--ibox-content-->
        </div><!--ibox-->

        <div class="modal modal-800 fade" id="cancelModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <div class="modal-header">
                        <h3>ยกเลิกใบ Proforma Invoice </h3>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <div class="attachment-box">

                                <div class="col-xl-10 m-auto">

                                    <form id="formSearchConsignment" autocomplete="none" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เหตุผลที่ยกเลิก</label> <textarea name="pi_cancel_reason" id="pi_cancel_reason" class="form-control"></textarea>
                                                </div>
                                            </div>

                                        </div><!--row-->

                                    </form>

                                </div><!--col-xl-6-->


                        </div>
                    </div><!--modal-body-->

                    <div class="modal-footer center mt-4">
                        <button class="btn btn-danger btn-lg" type="button" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            ปิด
                        </button>
                        <button class="btn btn-primary btn-lg" type="button" onclick="cancelProformaInvoice()">
                            <i class="fa fa-check-circle-o"></i>
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
        window.onload = setDefaultInput(1);
        $('.date').datepicker({ format: 'dd/mm/yyyy' });
        $('.custom-select').select2({width: "100%"});
        // generateDeliveryDate('', true);

        var searchPiNumber = $('#pi_number').val();

        if (searchPiNumber != '') {
            searchProformaInvoice();
        }
    });

</script>

<script>

    var taxCode         = @json($taxCode);
    var orderList       = @json($orderList);
    var proformaList    = @json($proformaList);
    var customerList    = @json($customerList);
    let currencyList    = {!! json_encode($currency) !!};
    let saList          = {!! json_encode($saNumberList) !!};
    let priceList       = {!! json_encode($priceList) !!};
    let priceListLine   = {!! json_encode($priceListLine) !!};
    var termList        = @json($terms);
    var taxList         = [];
    var resultAmount    = 0.00;
    var dataOrgList     = [];
    var dataLotList     = [];
    var html            = '';
    var roll            = 0;
    var selectLineID    = '';
    var isPdType1       = 1;
    var isPdType2       = 1;

    var d           = new Date();
    var dayNow      = d.getDate();
    var monthNow    = ("0"+(d.getMonth()+1)).slice(-2);
    var yearNow     = d.getFullYear();
    let dateNow = dayNow + "/" + monthNow + "/" + yearNow;

    var orderData = [];

    $.each(orderList, function(key,valOrder){
        if (valOrder.order_number != null) {
            orderData.push({ id: valOrder.order_number, name: valOrder.order_number });
        }
    });

    orderData.sort(function(a, b) {
        return - ( b.id - a.id  ||  b.name.localeCompare(a.name) );
    });

    var optionsOrder = [];
    $.map(orderData,
    function(o) {
        optionsOrder[o.id] = o.name;
    });

    // console.log(optionsOrder);

    var dataList = [];

    $.each(proformaList, function(key,val){
        if (val.pi_number != null) {
            dataList.push({ id: val.pi_number, name: val.pi_number });
        }
    });

    dataList.sort(function(a, b) {
        return - ( b.id - a.id  ||  b.name.localeCompare(a.name) );
    });

    var options = {};
    $.map(dataList,
    function(o) {
        options[o.id] = o.name;
    });

    function newSearchProformaInvoice()
    {
        var newPiNumber = $('#pi_number').val();

        if (newPiNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเลขที่ใบ PI',
                showConfirmButton: true
            });
        }else{
            window.location = '{{ url('om/proforma-invoice') }}?pi_number='+newPiNumber;
        }
    }

    async function searchProformaInvoice()
    {
        // console.log(optionsOrder);
        // return false;

        var piNumber        = $('#pi_number').val();
        var orderNumber     = $('#order_number').val();
        var saNumber        = $('#sa_number').val();
        var customerNumber  = $('#customer_number').val();

        if (piNumber == '' && orderNumber == '' && saNumber == '' && customerNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกอย่างน้อย 1 รายการ',
                showConfirmButton: true
            });
        }else{
            // swal.showLoading();

            var defaultOrderLine = '';
            defaultOrderLine += '<tr>';
            defaultOrderLine += '    <td class="text-right black" colspan="13"><strong>Total Weight</strong></td>';
            defaultOrderLine += '    <td class="text-right black"><strong>0.00</strong></td>';
            defaultOrderLine += '    <td class="text-right black"><strong>0.00</strong></td>';
            defaultOrderLine += '</tr>';

            $('#orderLines').html('');
            $('#orderLinesTotal').html(defaultOrderLine);
            $('#orderLots').html('');

            const formData = new FormData(document.getElementById("formProformaInvoice"));
            formData.append('_token','{{ csrf_token() }}');

            await $.each(fileChoose,async function(index, file) {
            if(typeof file !== "undefined")
                await formData.append('attachment[]', file);
            });

            $.ajax({
                url         : '{{ url("om/ajax/proforma-invoice/search") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){

                    var dataOrder = res.data.data;

                    console.log(dataOrder)
                    if (res.data.status == 'success') {

                        resultAmount = res.data.resultTotalAmount;

                        var shipSitesList = res.data.shipSitesList;
                        var html = '';
                        html += '<option value=""> &nbsp; </option>';
                        $.each(shipSitesList, function(key,val){
                            html += '<option  value="'+val.ship_to_site_id+'">'+val.ship_to_site_name+'</option>';
                        });
                        $('#ship_to_site_id').html(html).trigger('change');

                        // Port of Loading
                        var htmlPort = '';
                        htmlPort += '<option value=""> &nbsp; </option>';
                        $.each(shipSitesList, function(key,val){
                            htmlPort += '<option  value="'+val.ship_to_site_id+'">'+val.ship_to_site_name+'</option>';
                        });
                        $('#port_of_discharge').html(htmlPort).trigger('change');
                        $('#place_of_delivery').html(htmlPort).trigger('change');

                        if($.trim(dataOrder.order_date) == ''){
                            dataOrder.order_date = dateNow;
                        }

                        $('#pi_number').val(piNumber);
                        $('#order_status').val(dataOrder.order_status);
                        $('#sa_number').val(dataOrder.sa_number);

                        // $('#pi_date').val(dataOrder.pi_date);
                        // $('#show_pi_date').val(dataOrder.pi_date);
                        $("#pi_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dataOrder.pi_date);
                        if (dataOrder.order_status == 'Confirm') {
                            // generatePiDate(dataOrder.pi_date, true);
                            // $('#html_pi_date div').addClass('disabled');
                            // $('#html_pi_date div').attr('disabled', true);
                            // $('#pi_date').prop('disabled', true);
                            $('#pi_date').prop('readonly',true);

                        } else {
                            // generatePiDate(dataOrder.pi_date, false);
                            $('#pi_date').prop('readonly',false);
                        }

                        $('#pi_header_id').val(dataOrder.pi_header_id);
                        $('#order_header_id').val(dataOrder.order_header_id);
                        $('#product_type_code').val(dataOrder.product_type_code);
                        $('#order_number').val(dataOrder.order_number);
                        $('#order_date').val(dataOrder.order_date);
                        $('#show_order_date').val(dataOrder.order_date);
                        $('#cust_po_number').val(dataOrder.cust_po_number);
                        $('#customer_id').val(dataOrder.customer_id);
                        $('#customer_number').val(dataOrder.customer_number);
                        $('#customer_name').val(dataOrder.customer_name);
                        $('#order_type_id').val(dataOrder.order_type_id).trigger('change');
                        $('#currency').val(dataOrder.currency).trigger('change');
                        $('#currency_name').val(dataOrder.currency_name);
                        $('#customer_address').val(dataOrder.customer_address);
                        $('#term_id').val(dataOrder.term_id);
                        $('#term_name').val(dataOrder.term_name).trigger('change');
                        $('#term_description').val(dataOrder.term_description);
                        $('#payment_type_code').val(dataOrder.payment_type_code).trigger('change');
                        $('#vat_code').val(dataOrder.vat_code).trigger('change');
                        $('#payment_method_code').val(dataOrder.payment_method_code).trigger('change');
                        $('#remark').val(dataOrder.remark);
                        $('#bill_to_site_id').val(dataOrder.bill_to_site_id);
                        $('#bill_to_site_name').val(dataOrder.bill_to_site_name);
                        $('#ship_to_site_id').val(dataOrder.ship_to_site_id).trigger('change');
                        $('#incoterms_code').val(dataOrder.incoterms_code).trigger('change');
                        $('#port_of_loading').val(dataOrder.port_of_loading);
                        $('#transport_type_code').val(dataOrder.transport_type_code).trigger('change');
                        $('#transport_detail').val(dataOrder.transport_detail);
                        $('#port_of_discharge').val(dataOrder.port_of_discharge).trigger('change');
                        $('#shipment_condition').val(dataOrder.shipment_condition);
                        $('#shipping_marks').val(dataOrder.shipping_marks);
                        $('#source_system').val(dataOrder.source_system).trigger('change');
                        $('#sale_confirm_date').val(dataOrder.sale_confirm_date);
                        $('#sale_confirm_document_no').val(dataOrder.sale_confirm_document_no);
                        $('#place_of_delivery').val(dataOrder.place_of_delivery).trigger('change');

                        // if (dataOrder.order_status == 'Draft') {
                        //     generateDeliveryDate(dataOrder.delivery_date, false);
                        // }else{
                        //     generateDeliveryDate(dataOrder.delivery_date, true);
                        // }

                        var htmlPriceList   = '';
                        var selectPriceList = '';
                        var price_list_id   = $.trim(dataOrder.price_list_id) != '' ? dataOrder.price_list_id : dataOrder.customer_price_list_id;
                        previous = price_list_id;
                        htmlPriceList += '<option value=""> &nbsp; </option>';
                        $.each(priceList, function(key,val){
                            if (dataOrder.currency == val.currency_code) {
                                if (val.list_header_id == price_list_id) {
                                    selectPriceList = 'selected';
                                }else{
                                    selectPriceList = '';
                                }
                                htmlPriceList += '<option '+selectPriceList+' value="'+val.list_header_id+'">'+val.name+'</option>';
                            }
                        });
                        $('#price_list_id').html(htmlPriceList).trigger('change');

                        // $('#delivery_date').val(dataOrder.delivery_date);
                        $("#delivery_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dataOrder.delivery_date);

                        $('#order_number').prop('readonly', true);
                        // $('#order_number').attr("placeholder", "(ข้อมูลคัดลอก)");



                        // ORDER LINES
                        var orderLine = res.data.orderLine;
                        var htmlLine = '';
                        var htmlCopyToPI = '';
                        var num = 1;
                        var checkSelectVat = '';
                        var piBalance = 0;
                        $.each(orderLine, function(key,val){
                            htmlLine += '<tr id="tr_line_'+val.pi_line_id+'" class="clickable-row">';
                            // htmlLine += '    <td>';
                            // htmlLine += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" class="check" name="select_order_line['+val.pi_line_id+']"></label></div>';
                            // htmlLine += '    </td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+ num +' <input type="hidden" name="pi_line_id['+val.pi_line_id+']" id="pi_line_id_'+val.pi_line_id+'" value="'+val.pi_line_id+'" autocomplete="off"></td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+val.item_code+' <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+val.pi_line_id+'" value="'+val.pi_line_id+'" autocomplete="off" > </td>';
                            htmlLine += '    <td class="text-left" onclick="selectLinesRow('+val.pi_line_id+')">'+val.item_description+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+val.uom_code+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+val.uom+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+numberFormat(val.order_quantity)+' <input type="hidden" name="order_quantity['+val.pi_line_id+']" id="order_quantity_'+val.pi_line_id+'" value="'+val.order_quantity+'" autocomplete="off" > </td>';
                            htmlLine += '    <td class="text-right" onclick="selectLinesRow('+val.pi_line_id+')">'+numberFormat(val.unit_price)+' <input type="hidden" name="unit_price['+val.pi_line_id+']" id="unit_price_'+val.pi_line_id+'" value="'+val.unit_price+'" autocomplete="off" ></td>';
                            htmlLine += '    <td class="text-right" onclick="selectLinesRow('+val.pi_line_id+')">'+numberFormat(val.amount)+' <input type="hidden" name="amount['+val.pi_line_id+']" id="amount_'+val.pi_line_id+'" value="'+val.amount+'" autocomplete="off" ></td>';
                            htmlLine += '    <td>';
                            htmlLine += '        <select class="custom-select vat-custom" name="sub_vat['+ val.pi_line_id +']" id="sub_vat_'+ val.pi_line_id +'" onchange="calculateVat('+val.pi_line_id+')">';
                            htmlLine += '            <option value=""> &nbsp; </option>';

                            $.each(taxCode, function(key,valVat){
                                if (valVat.tax_rate_code == val.vat_code) {
                                    checkSelectVat = 'selected';
                                }else if(valVat.tax_rate_code == dataOrder.vat_code && val.vat_code == ''){
                                    checkSelectVat = 'selected';
                                }else{
                                    checkSelectVat = '';
                                }
                            htmlLine += '            <option '+ checkSelectVat +' value="'+ valVat.tax_rate_code +'">'+ valVat.tax_rate_code +'</option>';
                            });

                            htmlLine += '        </select>';
                            htmlLine += '    </td>';
                            htmlLine += '    <td class="text-right" onclick="selectLinesRow('+val.pi_line_id+')"> <span id="text_tax_amount_'+val.pi_line_id+'">'+numberFormat(val.tax_amount)+' </span> <input type="hidden" name="tax_amount['+val.pi_line_id+']" id="tax_amount_'+val.pi_line_id+'" value="'+val.tax_amount+'" autocomplete="off" ></td>';
                            htmlLine += '    <td class="text-right" onclick="selectLinesRow('+val.pi_line_id+')"> <span id="text_total_amount_'+val.pi_line_id+'">'+numberFormat(val.total_amount)+' </span> <input type="hidden" name="total_amount['+val.pi_line_id+']" id="total_amount_'+val.pi_line_id+'" value="'+val.total_amount+'" autocomplete="off" ></td>';
                            htmlLine += '    <td class="text-right"> <input type="text" class="form-control weight-input" name="net_weight['+val.pi_line_id+']" id="net_weight_'+val.pi_line_id+'" value="'+numberFormat(val.net_weight)+'" onchange="weightChange('+val.pi_line_id+')"  onkeypress="return isNumber(this, event)" autocomplete="off" ></td>';
                            htmlLine += '    <td class="text-right"> <input type="text" class="form-control weight-input" name="net_gross['+val.pi_line_id+']" id="net_gross_'+val.pi_line_id+'" value="'+(val.net_gross)+'" onchange="weightChange('+val.pi_line_id+')"  onkeypress="return isNumber(this, event)" autocomplete="off" ></td>';
                            htmlLine += '    <td class="text-right" onclick="selectLinesRow('+val.pi_line_id+')"> <span id="text_total_net_'+val.pi_line_id+'">'+numberFormat(val.total_net_weight)+'</span> <input type="hidden" name="total_net_weight['+val.pi_line_id+']" id="total_net_weight_'+val.pi_line_id+'" value="'+val.total_net_weight+'" autocomplete="off" ></td>';
                            htmlLine += '    <td class="text-right" onclick="selectLinesRow('+val.pi_line_id+')"> <span id="text_total_gross_'+val.pi_line_id+'">'+numberFormat(val.total_net_gross)+'</span> <input type="hidden" name="total_net_gross['+val.pi_line_id+']" id="total_net_gross_'+val.pi_line_id+'" value="'+val.total_net_gross+'" autocomplete="off" ></td>';
                            htmlLine += '</tr>';

                            num++;
                        });

                        var resultWeights = res.data.resultWeights;
                        var orderLineTotal = '';
                        orderLineTotal += '<tr>';
                        orderLineTotal += '    <td class="text-right black" colspan="13"><strong>Total Weight</strong></td>';
                        orderLineTotal += '    <td class="text-right black"><strong>'+ numberFormat(resultWeights.result_net_weight) +'</strong></td>';
                        orderLineTotal += '    <td class="text-right black"><strong>'+ numberFormat(resultWeights.result_gross_weight) +'</strong></td>';
                        orderLineTotal += '</tr>';

                        $('#orderLines').html(htmlLine);
                        $('#orderLinesTotal').html(orderLineTotal);

                        $('#resultSubtotal').html(numberFormat(resultWeights.result_sub_total));
                        $('#resultTax').html(numberFormat(resultWeights.result_tax));
                        $('#resultTotal').html(numberFormat(resultWeights.result_total));

                        $('#sub_total').val(resultWeights.result_sub_total);
                        $('#tax').val(resultWeights.result_tax);
                        $('#grand_total').val(resultWeights.result_total);

                        setAttachment(res.data.attachmentFile);

                        if (dataOrder.order_status == 'Draft') {
                            setDefaultInput(0);
                        }else{
                            setDefaultInput(1);

                            // $('#pi_number').prop('readonly', true);
                            // $('#order_number').prop('readonly', true);
                            // $('#sa_number').prop('readonly', true);
                            // $('#customer_number').prop('readonly', true);

                            $('.vat-custom').select2({disabled: true});
                            $('.weight-input').prop('readonly', true);
                        }

                        $('#pi_number').prop('readonly', true);
                        $('#order_number').prop('readonly', true);
                        $('#currency').prop('readonly', true);
                        $('#sa_number').prop('readonly', true);
                        $('#customer_number').prop('readonly', true);

                        $('.check').iCheck({
                            checkboxClass: 'icheckbox_square-green'
                        });

                        $('.custom-select').select2({width: "100%"});

                        // $('.custom-select').select2({width: "100%"});


                        // Swal.close();

                        // let timerInterval2;
                        // Swal.fire({
                        //     title: 'สำเร็จ!',
                        //     timer: 2000,
                        //     icon: 'success',
                        //     showConfirmButton: false,
                        //     willClose: () => {
                        //         clearInterval(timerInterval2)
                        //     }
                        // })

                    }else{
                        resetProformaInvoice();
                        setDefaultInput(1);

                        Swal.fire({
                            title: 'ผิดพลาด',
                            text: "ไม่พบข้อมูล",
                            icon: 'error',
                            showConfirmButton: true
                        });
                    }
                }
            });
        }
    }

    function weightChange(index)
    {
        var amount  = parseFloat( $.trim($('#order_quantity_'+index).val()) != '' ? $.trim($('#order_quantity_'+index).val()) : 0);
        var net     = parseFloat( $.trim($('#net_weight_'+index).val()) != '' ? $.trim($('#net_weight_'+index).val()) : 0);
        var gross   = parseFloat( $.trim($('#net_gross_'+index).val()) != '' ? $.trim($('#net_gross_'+index).val()) : 0);

        var total_net   = amount * net;
        var total_gross = amount * gross;

        $('#total_net_weight_'+index).val(total_net);
        $('#text_total_net_'+index).html(numberFormat(total_net));
        $('#total_net_gross_'+index).val(total_gross);
        $('#text_total_gross_'+index).html(numberFormat(total_gross));

        var resultTotalNet      = 0;
        var resultTotalGross    = 0;

        $("input[name='order_line_manage[]']").each(function ()
        {
            var lineID   = parseInt($(this).val());

            total_net   = $('#total_net_weight_'+lineID).val() != '' ? parseFloat($('#total_net_weight_'+lineID).val()) : 0;
            total_gross = $('#total_net_gross_'+lineID).val() != '' ? parseFloat($('#total_net_gross_'+lineID).val()) : 0;

            resultTotalNet      = resultTotalNet + total_net;
            resultTotalGross    = resultTotalGross + total_gross;

        });

        var htmlTotalWeight = '';

        htmlTotalWeight += '<tr>';
        htmlTotalWeight += '    <td class="text-right black" colspan="13"><strong>Total Weight</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalNet)+'</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalGross)+'</strong></td>';
        htmlTotalWeight += '</tr>';

        $('#orderLinesTotal').html(htmlTotalWeight);
    }

    async function manageProformaInvoice(event)
    {
        piNumber = $('#pi_number').val();

        var shipmentBy = $('#transport_type_code').val();
        var shipmentDetail = $('#transport_detail').val();

        if (piNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'ไม่พบข้อมูลสำหรับบันทึก',
                showConfirmButton: true
            });
            return false;
        }else if($('#order_status').val() == 'Cancelled' || $('#order_status').val() == 'Cancel'){
            Swal.fire({
                icon: 'warning',
                title: 'ไม่สามารถดำเนินการได้',
                text: 'ใบ PI นี้ถูกยกเลิกแล้ว',
                showConfirmButton: true
            });
        }else if ($('#customer_number').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกลูกค้า',
                showConfirmButton: true
            });
            return false;
        }else if ($('#order_type_id').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือก Order Type',
                showConfirmButton: true
            });
            return false;
        }else if ($('#currency').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกสกุลเงิน',
                showConfirmButton: true
            });
            return false;
        }else if ($('#term_name').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเงื่อนไขการชำระเงิน',
                showConfirmButton: true
            });
            return false;
        }else if ($('#payment_type_code').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกประเภทการจ่ายเงิน',
                showConfirmButton: true
            });
            return false;
        }else if ($('#vat_code').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือก Vat Code',
                showConfirmButton: true
            });
            return false;
        }else if ($('#payment_method_code').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกวิธีการชำระเงิน',
                showConfirmButton: true
            });
            return false;
        }else if ($('#bill_to_site_name').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือก Bill To',
                showConfirmButton: true
            });
            return false;
        }else if ($('#ship_to_site_id').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือก Ship To',
                showConfirmButton: true
            });
            return false;
        }else if ($('#price_list_id').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือก Price List',
                showConfirmButton: true
            });
            return false;
        }else if ($('#incoterms_code').val() == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือก INCOTERMS',
                showConfirmButton: true
            });
            return false;
        }else if (shipmentBy == 60 && shipmentDetail == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณากรอกรายละเอียดอื่นๆ Shipment By',
                showConfirmButton: true
            });
            return false;
        }else{

            var alertText = '';
            var alertTextSuccess = '';
            var alertTextFail = '';
            if (event == 'Draft') {
                alertText           = 'บันทึกใบ Proforma Invoice หรือไม่?';
                alertTextSuccess    = 'บันทึกใบ Proforma Invoice เรียบร้อยแล้ว';
                alertTextFail       = 'บันทึกใบ Proforma Invoice ไม่สำเร็จ';
            }else{
                $('#order_status').val(event);
                alertText           = 'ยืนยันใบ Proforma Invoice หรือไม่?';
                alertTextSuccess    = 'ยืนยันใบ Proforma Invoice เรียบร้อยแล้ว';
                alertTextFail       = 'ยืนยันใบ Proforma Invoice ไม่สำเร็จ';
            }

            Swal.fire({
                title: 'แจ้งเตือน',
                text: alertText,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
            }).then( async (result) => {
                if (result.isConfirmed) {

                    const formData = new FormData(document.getElementById("formProformaInvoice"));
                    formData.append('_token','{{ csrf_token() }}');

                    await $.each(fileChoose,async function(index, file) {
                    if(typeof file !== "undefined")
                        await formData.append('attachment[]', file);
                    });

                    $.ajax({
                        url         : '{{ url("om/ajax/proforma-invoice/manage-proforma-invoice") }}',
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

                                setAttachment(res.data.attachmentFile);

                                var deliveryDate = $('#delivery_date').val();

                                if (event == 'Draft') {
                                    setDefaultInput(0);
                                    // generateDeliveryDate(deliveryDate, false);
                                }else{
                                    setDefaultInput(1);
                                    // generateDeliveryDate(deliveryDate, true);

                                    $('.vat-custom').select2({disabled: true});

                                    $('#pi_number').prop('readonly', true);
                                    $('#order_number').prop('readonly', true);
                                    $('#sa_number').prop('readonly', true);
                                    $('#customer_number').prop('readonly', true);
                                }

                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: alertTextSuccess,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: alertTextFail,
                                    icon: 'error',
                                    timer: 2500
                                });
                            }
                        }
                    });
                }
            });

        }
    }

    function checkCancel()
    {
        if ($('#pi_number').val() == '') {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ไม่พบเลขที่ Proforma Invoice ที่ต้องการยกเลิก',
                icon: 'error'
            });
        }else if($('#order_status').val() == 'Cancel' || $('#order_status').val() == 'Cancelled'){
            Swal.fire({
                title: 'ไม่สามารถทำรายการได้',
                text: 'ใบ Proforma Invoice นี้ถูกยกเลิกไปแล้ว',
                icon: 'warning'
            });
        }else{

            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ต้องการยกเลิกใบ PI ใช่ หรือไม่",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {

                    var piNumber = $('#pi_number').val();

                    Swal.showLoading();

                    $.ajax({
                        url : `{{ url("om/ajax/proforma-invoice/check-cancel") }}/`+piNumber,
                        success : function(res){
                            var dataOrder = res.data.data;

                            if(res.data.status == 'wms_y'){
                                Swal.fire({
                                    title: 'ไม่สามารถทำรายการยกเลิกได้',
                                    text: 'รายการนี้อยู่ในขั้นตอนของ WMS แล้ว',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }else if(res.data.status == 'closed'){
                                Swal.fire({
                                    title: 'ไม่สามารถทำรายการยกเลิกได้',
                                    text: 'รายการนี้ถูกปิดการขายประจำวันไปแล้ว',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }else if(res.data.status == 'retry'){
                                Swal.fire({
                                    title: 'ไม่สามารถทำรายการยกเลิกได้',
                                    text: 'กรุณายกเลิกใบ Invoice, Tax Invoice แล้วดำเนินการอีกครั้ง',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }else if (res.data.status == 'success') {
                                Swal.close();

                                $('#cancelModal').modal('show');

                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: 'ยกเลิกใบ Proforma Invoice ไม่สำเร็จ',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }
                        }
                    });

                }
            });
        }
    }

    function cancelProformaInvoice()
    {
        if ($('#pi_cancel_reason').val() == '') {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'กรุณาใส่เหตุผลที่ยกเลิก',
                icon: 'warning'
            });
            return false;
        }else{

            Swal.showLoading();

            $('#order_status').val('Cancelled');

            const formData = new FormData(document.getElementById("formProformaInvoice"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/proforma-invoice/cancel") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    var data = res.data;
                    var html = '';
                    if(data.status == 'success'){

                        $('#cancelModal').modal('hide');

                        var piNumber = $('#pi_number').val();

                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'ยกเลิกใบ Proforma Invoice : '+piNumber+' แล้ว',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2500
                        });

                    }else{
                        Swal.fire({
                            title: 'ผิดพลาด',
                            text: 'ยกเลิกใบ Proforma Invoice ไม่สำเร็จ',
                            icon: 'error',
                            timer: 2500
                        });
                    }
                }
            });
        }
    }

    function clearProformaInvoice()
    {
        var date = new Date();
        var month = ("0"+(date.getMonth()+1)).slice(-2);
        var day = date.getDate();

        $('#sa_status').val('Draft');
        $('#sa_number').val('');
        $('#customer_id').val('');

        var saDate = $('#pi_date');
        saDate.datepicker();
        saDate.datepicker('setDate', dateNow);

        $('#pi_header_id').val('');
        $('#product_type_code').val('');
        $('#order_number').val('').trigger('change');
        $('#order_date').val('');
        $('#cust_po_number').val('');
        $('#customer_number').val('');
        $('#customer_name').val('');
        $('#order_type_id').val('').trigger('change');
        $('#currency').val('');
        $('#currency_code').val('').trigger('change');
        $('#customer_address').val('');
        $('#term_id').val('');
        $('#term_name').val('').trigger('change');
        $('#term_description').val('');
        $('#payment_type_code').val('').trigger('change');
        $('#vat_code').val('').trigger('change');
        $('#payment_method_code').val('').trigger('change');
        $('#remark').val('');
        $('#bill_to_site_id').val('');
        $('#bill_to_site_name').val('');
        $('#ship_to_site_id').val('').trigger('change');
        $('#incoterms_code').val('').trigger('change');
        $('#port_of_loading').val('Tobacco Authority of Thailand, Thailand');
        $('#transport_type_code').val('').trigger('change');
        $('#transport_detail').val('');
        $('#port_of_discharge').val('').trigger('change');
        $('#place_of_delivery').val('').trigger('change');
        $('#shipment_condition').val('');
        $('#shipping_marks').val('');
        $('#source_system').val('').trigger('change');
        $('#sale_confirm_date').val('');
        $('#sale_confirm_document_no').val('');

        $('#main_lot_pi_line_id').val('');
    }

    $('#currency_code').change(function()
    {
        var code = $('#currency_code').val();

        if (code != '') {
            swal.showLoading();
        $.ajax({
            url : `{{ url("om/ajax/sale-confirmation/get-currency-name") }}/`+ code,
            success : function(res){
                var currencyName = res.data.data;
                if (res.data.status == 'success') {
                    $('#currency').val(currencyName);

                    Swal.close();

                }else{
                    Swal.showValidationMessage(
                        `ไม่พบข้อมูลสกุลเงิน : ` + code
                    );
                }
            }
        });
        }
    });

    var rollLot = 0;

    function createProformaLots(piLineID)
    {
        var piNumber        = $('#pi_number').val();
        // var piLinesNumber   = piLineID;
        var piLinesNumber    = $('#main_lot_pi_line_id').val();

        if ($("input[name='manage_lot[]']").length <= 0) {
            rollLot     = 0;
            isPdType1   = 1;
            isPdType2   = 1;
        }else{
            $("input[name='manage_lot[]']").each(function ()
            {
                var LotID = parseInt($(this).val());
                rollLot = parseInt($('#case_no_to_'+ LotID).val());
                isPdType1   = rollLot+1;
                isPdType   = rollLot+1;

            });
        }

        if (piNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'ไม่พบเลขที่ Proforma Invoice',
                showConfirmButton: true
            });
            return false;
        }else if (piLinesNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกรายการผลิตภัณฑ์',
                showConfirmButton: true
            });
            return false;
        }else{
            // Swal.fire({
            //     title: 'แจ้งเตือน',
            //     text: "สร้างรายละเอียดสินค้าหรือไม่?",
            //     icon: 'question',
            //     showCancelButton: true,
            //     confirmButtonColor: '#1c84c6',
            //     cancelButtonColor: '#e7eaec',
            //     confirmButtonText: 'สร้าง',
            //     cancelButtonText: 'ยกเลิก'
            // }).then((result) => {
            //     if (result.isConfirmed) {

                Swal.showLoading();

                    $.ajax({
                        url : `{{ url("om/ajax/proforma-invoice/create-proforma-lot") }}/`+piLinesNumber,
                        success : function(res){
                            var dataItemList    = res.data.data;
                            dataOrgList         = res.data.orgList;
                            dataLotList         = res.data.lotList;
                            var quantity        = res.data.limitOrderQuantity;
                            var onhand          = res.data.sumOnhand;
                            var productTypeCode = $.trim($('#product_type_code').val());
                            var mmsPerBox       = res.data.mmsPerBox;
                            var resultQuantity  = 0;
                            var newQuantity     = res.data.limitOrderQuantity;
                            if (res.data.status == 'success' || res.data.status == 'over') {

                                $("input[name='manage_lot[]']").each(function ()
                                {
                                    var LotID = parseInt($(this).val());

                                    var quantityLot = $('#lot_order_quantity_'+LotID).val() != '' ? parseFloat($('#lot_order_quantity_'+LotID).val()) : 0;
                                    newQuantity      = newQuantity - quantityLot;

                                });

                                html = '';

                                // if (dataOrgList != null) {

                                    // if(quantity > 0){

                                        html += '<tr class="align-middle" id="data_lot_'+rollLot+'">';
                                        html += '    <td>';
                                        html += '        <input type="hidden" readonly placeholder="" name="manage_lot[]" id="manage_lot_'+rollLot+'" value="'+rollLot+'" autocomplete="off">';
                                        html += '        <input type="hidden" readonly placeholder="" name="lot_item_id['+rollLot+']" id="lot_item_id_'+rollLot+'" value="'+dataItemList.item_id+'" autocomplete="off">';
                                        html += '        <input type="text" class="form-control md text-center" readonly="" name="lot_item_code['+rollLot+']" id="lot_item_code_'+rollLot+'" value="'+dataItemList.item_code+'" autocomplete="off">';
                                        html += '    </td>';
                                        html += '    <td><input type="text" class="form-control md" readonly="" name="lot_item_description['+rollLot+']" id="lot_item_description_'+rollLot+'" value="'+dataItemList.item_description+'" autocomplete="off"></td>';

                                        html += '    <td style="display:none">';
                                        html += '        <div class="input-icon">';
                                        html += '            <input type="hidden" name="lot_pi_lot_id['+rollLot+']" id="lot_pi_lot_id_'+rollLot+'" value="'+dataItemList.pi_lot_id+'" autocomplete="off">';
                                        html += '            <input type="hidden" name="lot_pi_line_id['+rollLot+']" id="lot_pi_line_id_'+rollLot+'" value="'+dataItemList.pi_line_id+'" autocomplete="off">';

                                        html += '            <input type="hidden" name="lot_inv_org_id['+rollLot+']" id="lot_inv_org_id_'+rollLot+'" value="" autocomplete="off">';
                                        html += '            <input type="hidden" name="lot_serial_number['+rollLot+']" id="lot_serial_number_'+rollLot+'" value="" autocomplete="off">';
                                        html += '            <input type="hidden" name="lot_inventory_location_id['+rollLot+']" id="lot_inventory_location_id_'+rollLot+'" value="" autocomplete="off">';
                                        html += '            <input type="hidden" name="lot_inv_uom_code['+rollLot+']" id="lot_inv_uom_code_'+rollLot+'" value="" autocomplete="off">';
                                        html += '            <input type="hidden" name="lot_onhand_conv_qty['+rollLot+']" id="lot_onhand_conv_qty_'+rollLot+'" value="" autocomplete="off">';

                                        html += '           <input type="text" class="form-control" name="lot_inv_org_code['+rollLot+']" id="lot_inv_org_code_'+rollLot+'" list="org-list-'+rollLot+'" onchange="selectOrg('+rollLot+');" value="" autocomplete="off">';
                                        html += '           <i class="fa fa-search"></i>';
                                        html += '           <datalist id="org-list-'+rollLot+'">';

                                        $.each(dataOrgList, function(key,valOrg){
                                            if(key == 0){
                                                orgSelect = 'selected';
                                            }else{
                                                orgSelect = '';
                                            }

                                            if (valOrg.organization_id != '') {
                                                html += '               <option value="'+valOrg.organization_code+'">'+valOrg.organization_code+'</option>';
                                            }
                                        });

                                        html += '            </datalist>';
                                        html += '            <i class="fa fa-search" onclick="selectOrg('+rollLot+');"></i>';
                                        html += '        </div>';
                                        html += '    </td>';

                                        html += '    <td style="display:none;"><input type="text" class="form-control md" readonly="" name="inv_org_name['+rollLot+']" id="inv_org_name_'+rollLot+'" value="" autocomplete="off"></td>';

                                        // Subinventory
                                        html += '    <td style="display:none">';
                                        html += '        <div class="input-icon">';
                                        html += '           <input type="text" class="form-control" name="lot_subinventory_code['+rollLot+']" id="lot_subinventory_code_'+rollLot+'" list="org-subinventory-list-'+rollLot+'" onchange="selectOrgSubInventory('+rollLot+');" autocomplete="off">';
                                        html += '           <i class="fa fa-search"></i>';
                                        html += '           <datalist id="org-subinventory-list-'+rollLot+'">';
                                        html += '               <option value=""></option>';

                                        $.each(dataLotList, function(key,valLot){
                                            if (valLot.subinventory_code != '') {
                                            html += '               <option value="'+valLot.subinventory_code+'">'+valLot.subinventory_code+'</option>';
                                            }
                                        });

                                        html += '            </datalist>';
                                        html += '            <i class="fa fa-search" onclick="selectOrgLot('+rollLot+');"></i>';
                                        html += '        </div>';
                                        html += '    </td>';

                                        // Locator
                                        html += '    <td style="display:none">';
                                        html += '        <div class="input-icon">';
                                        html += '           <input type="text" class="form-control" name="lot_locator['+rollLot+']" id="lot_locator_'+rollLot+'" list="org-locator-list-'+rollLot+'" onchange="selectOrgLocator('+rollLot+');" autocomplete="off">';
                                        html += '           <i class="fa fa-search"></i>';
                                        html += '           <datalist id="org-locator-list-'+rollLot+'">';
                                        html += '               <option value=""></option>';

                                        $.each(dataLotList, function(key,valLot){
                                            if (valLot.locator != '') {
                                            html += '               <option value="'+valLot.locator+'">'+valLot.locator+'</option>';
                                            }
                                        });

                                        html += '            </datalist>';
                                        html += '            <i class="fa fa-search" onclick="selectOrgLot('+rollLot+');"></i>';
                                        html += '        </div>';
                                        html += '    </td>';


                                        // Lots
                                        html += '    <td style="display:none">';
                                        html += '        <div class="input-icon">';
                                        html += '           <input type="text" class="form-control" name="lot_lot_number['+rollLot+']" id="lot_lot_number_'+rollLot+'" list="org-lot-list-'+rollLot+'" onchange="selectOrgLot('+rollLot+');" autocomplete="off">';
                                        html += '           <i class="fa fa-search"></i>';
                                        html += '           <datalist id="org-lot-list-'+rollLot+'">';
                                        html += '               <option value=""></option>';

                                        $.each(dataLotList, function(key,valLot){
                                            if (valLot.lot_number != '') {
                                            html += '               <option value="'+valLot.lot_number+'">'+valLot.lot_number+'</option>';
                                            }
                                        });

                                        html += '            </datalist>';
                                        html += '            <i class="fa fa-search" onclick="selectOrgLot('+rollLot+');"></i>';
                                        html += '        </div>';
                                        html += '    </td>';

                                        html += '    <td style="display:none"><input type="text" class="form-control md text-center" readonly="" name="lot_onhand_quantity['+rollLot+']" id="lot_onhand_quantity_'+rollLot+'" value="0" autocomplete="off"></td>';
                                        html += '    <td> <input type="text" class="form-control text-right" name="lot_order_quantity['+rollLot+']" id="lot_order_quantity_'+rollLot+'" value="'+numberFormat(newQuantity)+'" onchange="editLotOrderQuantity('+rollLot+')"  onkeypress="return isNumber(this, event)" autocomplete="off"></td>';

                                        if (productTypeCode != 10) {
                                            isPdType1 = parseFloat(rollLot) + 1;
                                            html += '    <td> <input type="text" class="form-control text-center" name="case_no_from['+rollLot+']" id="case_no_from_'+rollLot+'" value="'+addNumberZero(isPdType1, 3)+'" onchange="changeCase('+rollLot+')" autocomplete="off"></td>';
                                            html += '    <td> <input type="text" class="form-control text-center" name="case_no_to['+rollLot+']" id="case_no_to_'+rollLot+'" value="'+addNumberZero(isPdType1, 3)+'" onchange="changeCase('+rollLot+')" autocomplete="off"></td>';

                                            var quantityCBB = (parseFloat(isPdType1) - parseFloat(isPdType1)) + 1;
                                            isPdType1++;
                                        }else{
                                            isPdType1 = (quantity - parseFloat(newQuantity)) + 1;
                                            isPdType2 = parseFloat(quantity);
                                            html += '    <td> <input type="text" class="form-control text-center" name="case_no_from['+rollLot+']" id="case_no_from_'+rollLot+'" value="'+addNumberZero(isPdType1, 3)+'" onchange="changeCase('+rollLot+')" autocomplete="off"></td>';
                                            html += '    <td> <input type="text" class="form-control text-center" name="case_no_to['+rollLot+']" id="case_no_to_'+rollLot+'" value="'+addNumberZero(isPdType2, 3)+'" onchange="changeCase('+rollLot+')" autocomplete="off"></td>';

                                            var quantityCBB = (parseFloat(isPdType2) - parseFloat(isPdType1)) + 1;
                                            isPdType1 = isPdType2;
                                        }

                                        html += '    <td> <input type="text" class="form-control text-center" name="mms_per_box['+rollLot+']" id="mms_per_box_'+rollLot+'" value="'+mmsPerBox+'" autocomplete="off"></td>';

                                        html += '    <td> <input type="text" class="form-control text-center" readonly name="quantity_cbb['+rollLot+']" id="quantity_cbb_'+rollLot+'" value="'+quantityCBB+'" autocomplete="off"></td>';

                                        html += '    <td> <input type="text" class="form-control text-center" name="weight_unit_net['+rollLot+']" id="weight_unit_net_'+rollLot+'" value="'+dataItemList.weight_net+'" onchange="weightLotChange('+rollLot+')" autocomplete="off"></td>';
                                        html += '    <td> <input type="text" class="form-control text-center" name="weight_unit_gross['+rollLot+']" id="weight_unit_gross_'+rollLot+'" value="'+dataItemList.weight_gross+'" onchange="weightLotChange('+rollLot+')" autocomplete="off"></td>';

                                        var totalWeightNet      = quantityCBB * dataItemList.weight_net;
                                        var totalWeightGross    = quantityCBB * dataItemList.weight_gross;

                                        html += '    <td> <span id="text_total_weight_unit_net_'+rollLot+'">'+numberFormat(totalWeightNet)+'</span> <input type="hidden" class="form-control text-right" name="total_weight_unit_net['+rollLot+']" id="total_weight_unit_net_'+rollLot+'" value="'+totalWeightNet+'" autocomplete="off"></td>';
                                        html += '    <td> <span id="text_total_weight_unit_gross_'+rollLot+'">'+numberFormat(totalWeightGross)+'</span> <input type="hidden" class="form-control text-right" name="total_weight_unit_gross['+rollLot+']" id="total_weight_unit_gross_'+rollLot+'" value="'+totalWeightGross+'" autocomplete="off"></td>';

                                        html += '   <td style="cursor: pointer; color: red; font-weight: 900;" onclick="deleteLotRows('+rollLot+')"> X </td>';
                                        html += '</tr>';

                                        changeCBB(rollLot);
                                        rollLot++;
                                    // }
                                // }

                                $('#orderLots').append(html);

                                var resultQuantity = 0;
                                var mainOrderQuantity   = $('#order_quantity_'+piLinesNumber).val();
                                $("input[name='manage_lot[]']").each(function ()
                                {
                                    var LotID = parseInt($(this).val());

                                    var quantity        = $('#lot_order_quantity_'+LotID).val() != '' ? $('#lot_order_quantity_'+LotID).val() : 0;
                                    quantity            = parseFloat(quantity.replace(/,/g, ''));
                                    resultQuantity      = resultQuantity + quantity;

                                });

                                if (parseFloat(resultQuantity).toFixed(2) < mainOrderQuantity) {
                                    $("#buttonCreateLots").attr('disabled', false);
                                }else{
                                    $("#buttonCreateLots").attr('disabled', true);
                                }

                                $("#buttonUpdateLots").attr('disabled', false);
                                $("#buttonDeleteLots").attr('disabled', false);

                                // $("#buttonCreateLots").attr('disabled', true);

                                // $('.custom-select').select2({width: "100%"});

                                // Swal.fire({
                                //     icon: 'success',
                                //     text: 'สร้างรายละเอียดสินค้าเรียบร้อยแล้ว',
                                //     showConfirmButton: false,
                                //     timer: 2500
                                // });

                                Swal.close();

                                $('#buttonUpdateLots').attr('disabled', false);

                            }
                            // else if (res.data.status == 'over') {

                            //     $("#buttonCreateLots").attr('disabled', true);
                            //     $("#buttonUpdateLots").attr('disabled', true);
                            //     $("#buttonDeleteLots").attr('disabled', true);

                            //     Swal.fire({
                            //         title: '',
                            //         text: "จำนวนสินค้าใน Onhand ไม่เพียงพอ?",
                            //         icon: 'warning',
                            //         // showCancelButton: true,
                            //         confirmButtonColor: '#1c84c6',
                            //         confirmButtonText: 'ตกลง!'
                            //     }).then((result) => {
                            //         if (result.isConfirmed) {
                            //             // Swal.fire(
                            //             // 'Deleted!',
                            //             // 'Your file has been deleted.',
                            //             // 'success'
                            //             // )
                            //         }
                            //     });

                            // }
                            else
                            {
                                Swal.fire({
                                    icon: 'warning',
                                    text: 'ไม่สามารถสร้างรายละเอียดสินค้าได้',
                                    showConfirmButton: true,
                                    timer: 2500
                                });
                            }
                            sumResultLot();
                        }
                    });
            //     }
            // });
        }
    }

    function editLotOrderQuantity(index)
    {
        var piLinesNumber       = $('#main_lot_pi_line_id').val();
        var mainOrderQuantity   = $('#order_quantity_'+piLinesNumber).val();
        var resultQuantity      = 0;
        var orderQuantity       = $('#lot_order_quantity_'+index).val();
        var productTypeCode     = $('#product_type_code').val();
        mainOrderQuantity       = mainOrderQuantity > 0 ? parseFloat(mainOrderQuantity.replace(/,/g, '')) : 0;
        orderQuantity           = orderQuantity > 0 ? parseFloat(orderQuantity.replace(/,/g, '')) : 0;


        $("input[name='manage_lot[]']").each(function ()
        {
            var LotID = parseInt($(this).val());

            var quantity        = $('#lot_order_quantity_'+LotID).val();
            quantity            = parseFloat(quantity.replace(/,/g, ''));
            resultQuantity      = resultQuantity + quantity;

        });

        if (mainOrderQuantity < resultQuantity) {
            Swal.fire({
                icon: 'warning',
                text: 'จำนวนที่ต้องการตัด ต้องน้อยกว่าจำนวนสินค้า',
                showConfirmButton: true,
                timer: 2500
            });

            orderQuantity  = (parseFloat(mainOrderQuantity) - parseFloat(resultQuantity)) + parseFloat(orderQuantity);
            // resultQuantity = mainOrderQuantity - orderQuantity;
            // $('#lot_order_quantity_'+index).val(numberFormat(orderQuantity));

            $("#buttonCreateLots").attr('disabled', true);
        }

        // var resultOrderQuantity = parseFloat(resultQuantity) + parseFloat(orderQuantity);

        if (parseFloat(mainOrderQuantity) <= parseFloat(resultQuantity)) {
            $("#buttonCreateLots").attr('disabled', true);
        }else{
            $("#buttonCreateLots").attr('disabled', false);
        }

        $('#lot_order_quantity_'+index).val(numberFormat(orderQuantity));

        var case1           = $('#case_no_from_'+index).val();

        if (productTypeCode != 10) {
            var case2           = parseFloat(case1);
            $('#case_no_to_'+index).val(addNumberZero(case2, 3));
        }else{
            var case2           = (parseFloat(orderQuantity) + parseFloat(case1)) - 1;
            $('#case_no_to_'+index).val(addNumberZero(case2, 3));
        }

        var quantityCbb     = (parseFloat(case2) - parseFloat(case1)) + 1;
        $('#quantity_cbb_'+index).val(parseFloat(quantityCbb));

        var net             = $('#weight_unit_net_'+index).val();
        var gross           = $('#weight_unit_gross_'+index).val();

        if (productTypeCode != 10) {
            orderQuantity = quantityCbb;
        }

        var totalNet        = parseFloat(orderQuantity) * parseFloat(net);
        var totalGross      = parseFloat(orderQuantity) * parseFloat(gross);

        $('#text_total_weight_unit_net_'+index).html(numberFormat(parseFloat(totalNet)));
        $('#total_weight_unit_net_'+index).val(parseFloat(totalNet));
        $('#text_total_weight_unit_gross_'+index).html(numberFormat(parseFloat(totalGross)));
        $('#total_weight_unit_gross_'+index).val(parseFloat(totalGross));

        weightLotChange(index);
        // sumResultLot();
    }

    // function editLotCaseFrom(index)
    // {
    //     var productTypeCode = $.trim($('#product_type_code').val());
    //     var orderQuantity   = $('#lot_order_quantity_'+index).val();
    //     var case1           = parseFloat($('#case_no_from_'+index).val());
    //     var case2           = parseFloat($('#case_no_to_'+index).val());

    //     if (case1 > case2) {
    //         Swal.fire({
    //             icon: 'warning',
    //             text: 'Case No. จาก ต้องน้อยกว่า Case No. ถึง',
    //             showConfirmButton: true,
    //             timer: 2500
    //         });

    //         $('#case_no_from_'+index).val('');
    //         $('#case_no_to_'+index).val('');
    //     }else{

    //     }
    // }

    // DOING
    // function editLotCaseTo(index)
    // {
    //     var productTypeCode = $.trim($('#product_type_code').val());
    //     var orderQuantity   = $('#lot_order_quantity_'+index).val();
    //     var case1           = parseFloat($('#case_no_from_'+index).val());
    //     var case2           = parseFloat($('#case_no_to_'+index).val());

    //     if (case1 > case2) {
    //         Swal.fire({
    //             icon: 'warning',
    //             text: 'Case No. จาก ต้องน้อยกว่า Case No. ถึง',
    //             showConfirmButton: true,
    //             timer: 2500
    //         });

    //         $('#case_no_from_'+index).val('');
    //         $('#case_no_to_'+index).val('');
    //     }else{
    //         if (productTypeCode != 10) {

    //         }
    //     }
    // }

    function sumResultLot()
    {
        // TOTAL
        var resultQuantity      = 0;
        var resultQuantityCbb   = 0;
        var resultTotalNet      = 0;
        var resultTotalGross    = 0;
        $("input[name='manage_lot[]']").each(function ()
        {
            var LotID = parseInt($(this).val());

            var quantity        = $('#lot_order_quantity_'+LotID).val() != '' ? $('#lot_order_quantity_'+LotID).val() : 0;
            quantity            = parseFloat(quantity.replace(/,/g, ''));
            var sumQuantityCbb  = $('#quantity_cbb_'+LotID).val() != '' ? $('#quantity_cbb_'+LotID).val() : 0;
            sumQuantityCbb      = parseFloat(sumQuantityCbb.replace(/,/g, ''));
            var total_net       = $('#total_weight_unit_net_'+LotID).val() != '' ? $('#total_weight_unit_net_'+LotID).val() : 0;
            total_net           = parseFloat(total_net.replace(/,/g, ''));
            var total_gross     = $('#total_weight_unit_gross_'+LotID).val() != '' ? $('#total_weight_unit_gross_'+LotID).val() : 0;
            total_gross         = parseFloat(total_gross.replace(/,/g, ''));

            resultQuantity      = resultQuantity + quantity;
            resultQuantityCbb   = resultQuantityCbb + sumQuantityCbb;
            resultTotalNet      = resultTotalNet + total_net;
            resultTotalGross    = resultTotalGross + total_gross;

        });

        $('#text_total_order_quantity').html(numberFormat(resultQuantity));
        $('#text_total_quantity_cbb').html(resultQuantityCbb);
        $('#text_total_net_weight').html(numberFormat(resultTotalNet));
        $('#text_total_gross_weight').html(numberFormat(resultTotalGross));
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

    function addNumberZero(numb1, numb2) {
        return new Array(numb2 + 1 - (numb1 + '').length).join('0') + numb1;
    }

    function selectLinesRow(lineID)
    {
        isPdType1 = 1;
        isPdType2 = 1;
        var piLineID = $('#pi_line_id_'+lineID).val();

        if (selectLineID != piLineID) {

            selectLineID = piLineID;

            $('#orderLines .clickable-row').removeClass('active');
            $('#tr_line_'+lineID).addClass('active');

            if (piLineID == undefined || piLineID == '') {
                return false;
            }else{

                swal.showLoading();

                $('#main_lot_pi_line_id').val(piLineID);

                $.ajax({
                    url : `{{ url("om/ajax/proforma-invoice/get-proforma-lot") }}/`+piLineID,
                    success : function(res){
                        var dataItemList    = res.data.data;
                        html = '';


                        if (dataItemList.length > 0) {
                            roll = 0;
                            rollLot = dataItemList.length;

                            $.each(dataItemList, function(key,valItem){

                                dataOrgList   = res.data.orgList[valItem.pi_lot_id];
                                dataLotList   = res.data.lotList[valItem.pi_lot_id];

                                html += '<tr class="align-middle" id="data_lot_'+valItem.pi_lot_id+'">';
                                html += '    <td>';
                                html += '        <input type="hidden" readonly placeholder="" name="manage_lot[]" id="manage_lot_'+valItem.pi_lot_id+'" value="'+valItem.pi_lot_id+'" autocomplete="off">';
                                html += '        <input type="hidden" readonly placeholder="" name="lot_item_id['+valItem.pi_lot_id+']" id="lot_item_id_'+valItem.pi_lot_id+'" value="'+valItem.item_id+'" autocomplete="off">';
                                html += '        <input type="text" class="form-control md text-center" readonly="" name="lot_item_code['+valItem.pi_lot_id+']" id="lot_item_code_'+valItem.pi_lot_id+'" value="'+valItem.item_code+'" autocomplete="off">';
                                html += '    </td>';
                                html += '    <td><input type="text" class="form-control md" readonly="" name="lot_item_description['+valItem.pi_lot_id+']" id="lot_item_description_'+valItem.pi_lot_id+'" value="'+valItem.item_description+'" autocomplete="off"></td>';

                                html += '    <td style="display:none">';
                                html += '        <div class="input-icon">';
                                html += '            <input type="hidden" name="lot_pi_lot_id['+valItem.pi_lot_id+']" id="lot_pi_lot_id_'+valItem.pi_lot_id+'" value="'+valItem.pi_lot_id+'" autocomplete="off">';
                                html += '            <input type="hidden" name="lot_pi_line_id['+valItem.pi_lot_id+']" id="lot_pi_line_id_'+valItem.pi_lot_id+'" value="'+valItem.pi_line_id+'" autocomplete="off">';

                                html += '            <input type="hidden" name="lot_inv_org_id['+valItem.pi_lot_id+']" id="lot_inv_org_id_'+valItem.pi_lot_id+'" value="'+$.trim(valItem.inv_org_id)+'" autocomplete="off">';
                                html += '            <input type="hidden" name="lot_serial_number['+valItem.pi_lot_id+']" id="lot_serial_number_'+valItem.pi_lot_id+'" value="'+$.trim(valItem.serial_number)+'" autocomplete="off">';
                                html += '            <input type="hidden" name="lot_inventory_location_id['+valItem.pi_lot_id+']" id="lot_inventory_location_id_'+valItem.pi_lot_id+'" value="'+$.trim(valItem.inventory_location_id)+'" autocomplete="off">';
                                html += '            <input type="hidden" name="lot_inv_uom_code['+valItem.pi_lot_id+']" id="lot_inv_uom_code_'+valItem.pi_lot_id+'" value="'+$.trim(valItem.inv_uom_code)+'" autocomplete="off">';
                                html += '            <input type="hidden" name="lot_onhand_conv_qty['+valItem.pi_lot_id+']" id="lot_onhand_conv_qty_'+valItem.pi_lot_id+'" value="'+$.trim(valItem.onhand_conv_qty)+'" autocomplete="off">';

                                html += '           <input type="text" class="form-control" name="lot_inv_org_code['+valItem.pi_lot_id+']" id="lot_inv_org_code_'+valItem.pi_lot_id+'" list="org-list-'+valItem.pi_lot_id+'" onchange="selectOrg('+valItem.pi_lot_id+');" value="'+$.trim(valItem.inv_org_code)+'" autocomplete="off">';
                                html += '           <i class="fa fa-search"></i>';
                                html += '           <datalist id="org-list-'+valItem.pi_lot_id+'">';

                                $.each(dataOrgList, function(key,valOrg){

                                    if (valOrg.organization_id != '') {
                                        html += '               <option value="'+valOrg.organization_code+'">'+valOrg.organization_code+'</option>';
                                    }
                                });

                                html += '            </datalist>';
                                html += '            <i class="fa fa-search"></i>';
                                html += '        </div>';
                                html += '    </td>';

                                html += '    <td style="display:none"><input type="text" class="form-control md" readonly="" name="inv_org_name['+valItem.pi_lot_id+']" id="inv_org_name_'+valItem.pi_lot_id+'" value="'+$.trim(valItem.inv_org_name)+'" autocomplete="off"></td>';

                                // Subinventory
                                html += '    <td style="display:none">';
                                html += '        <div class="input-icon">';
                                html += '           <input type="text" class="form-control" name="lot_subinventory_code['+valItem.pi_lot_id+']" id="lot_subinventory_code_'+valItem.pi_lot_id+'" list="org-subinventory-list-'+valItem.pi_lot_id+'" onchange="selectOrgSubInventory('+valItem.pi_lot_id+');" value="'+$.trim(valItem.subinventory_code)+'" autocomplete="off">';
                                html += '           <i class="fa fa-search"></i>';
                                html += '           <datalist id="org-subinventory-list-'+valItem.pi_lot_id+'">';
                                html += '               <option value=""></option>';

                                $.each(dataLotList, function(key,valLot){
                                    if (valLot.subinventory_code != '' && valLot.organization_id == valItem.inv_org_id) {
                                    html += '               <option value="'+valLot.subinventory_code+'">'+valLot.subinventory_code+'</option>';
                                    }
                                });

                                html += '            </datalist>';
                                html += '            <i class="fa fa-search"></i>';
                                html += '        </div>';
                                html += '    </td>';

                                // Locator
                                html += '    <td style="display:none">';
                                html += '        <div class="input-icon">';
                                html += '           <input type="text" class="form-control" name="lot_locator['+valItem.pi_lot_id+']" id="lot_locator_'+valItem.pi_lot_id+'" list="org-locator-list-'+valItem.pi_lot_id+'" onchange="selectOrgLocator('+valItem.pi_lot_id+');" value="'+$.trim(valItem.locator)+'" autocomplete="off">';
                                html += '           <i class="fa fa-search"></i>';
                                html += '           <datalist id="org-locator-list-'+valItem.pi_lot_id+'">';
                                html += '               <option value=""></option>';

                                $.each(dataLotList, function(key,valLot){
                                    if (valLot.locator != '' && valLot.organization_id == valItem.inv_org_id) {
                                    html += '               <option value="'+valLot.locator+'">'+valLot.locator+'</option>';
                                    }
                                });

                                html += '            </datalist>';
                                html += '            <i class="fa fa-search"></i>';
                                html += '        </div>';
                                html += '    </td>';

                                // Lot
                                html += '    <td style="display:none">';
                                html += '        <div class="input-icon">';
                                html += '           <input type="text" class="form-control" name="lot_lot_number['+valItem.pi_lot_id+']" id="lot_lot_number_'+valItem.pi_lot_id+'" list="org-lot-list-'+valItem.pi_lot_id+'" onchange="selectOrgLot('+valItem.pi_lot_id+');" value="'+$.trim(valItem.lot_number)+'" autocomplete="off">';
                                html += '           <i class="fa fa-search"></i>';
                                html += '           <datalist id="org-lot-list-'+valItem.pi_lot_id+'">';
                                html += '               <option value=""></option>';

                                $.each(dataLotList, function(key,valLot){
                                    if (valLot.lot_number != '' && valLot.organization_id == valItem.inv_org_id) {
                                    html += '               <option value="'+valLot.lot_number+'">'+valLot.lot_number+'</option>';
                                    }
                                });

                                html += '            </datalist>';
                                html += '            <i class="fa fa-search"></i>';
                                html += '        </div>';
                                html += '    </td>';



                                html += '    <td style="display:none"><input type="text" class="form-control md text-center" readonly="" name="lot_onhand_quantity['+valItem.pi_lot_id+']" id="lot_onhand_quantity_'+valItem.pi_lot_id+'" value="'+numberFormat(valItem.onhand_quantity)+'" autocomplete="off"></td>';
                                html += '    <td> <input type="text" class="form-control text-right" name="lot_order_quantity['+valItem.pi_lot_id+']" id="lot_order_quantity_'+valItem.pi_lot_id+'" value="'+numberFormat(valItem.order_quantity)+'" onchange="editLotOrderQuantity('+valItem.pi_lot_id+')" onkeypress="return isNumber(this, event)" autocomplete="off"></td>';

                                html += '    <td> <input type="text" class="form-control text-center" name="case_no_from['+valItem.pi_lot_id+']" id="case_no_from_'+valItem.pi_lot_id+'" value="'+addNumberZero($.trim(valItem.case_no_from), 3)+'" onchange="changeCase('+valItem.pi_lot_id+')" autocomplete="off"></td>';
                                html += '    <td> <input type="text" class="form-control text-center" name="case_no_to['+valItem.pi_lot_id+']" id="case_no_to_'+valItem.pi_lot_id+'" value="'+addNumberZero($.trim(valItem.case_no_to), 3)+'" onchange="changeCase('+valItem.pi_lot_id+')" autocomplete="off"></td>';

                                html += '    <td> <input type="text" class="form-control text-center" name="mms_per_box['+valItem.pi_lot_id+']" id="mms_per_box_'+valItem.pi_lot_id+'" value="'+$.trim(valItem.mms_per_box)+'" autocomplete="off"></td>';

                                html += '    <td> <input type="text" class="form-control text-center" readonly name="quantity_cbb['+valItem.pi_lot_id+']" id="quantity_cbb_'+valItem.pi_lot_id+'" value="'+$.trim(valItem.quantity_cbb)+'" autocomplete="off"></td>';

                                html += '    <td> <input type="text" class="form-control text-center" name="weight_unit_net['+valItem.pi_lot_id+']" id="weight_unit_net_'+valItem.pi_lot_id+'" value="'+numberFormat($.trim(valItem.weight_unit_net))+'" autocomplete="off" onchange="weightLotChange('+valItem.pi_lot_id+')"></td>';
                                html += '    <td> <input type="text" class="form-control text-center" name="weight_unit_gross['+valItem.pi_lot_id+']" id="weight_unit_gross_'+valItem.pi_lot_id+'" value="'+numberFormat($.trim(valItem.weight_unit_gross))+'" autocomplete="off" onchange="weightLotChange('+valItem.pi_lot_id+')"></td>';

                                html += '    <td> <span id="text_total_weight_unit_net_'+valItem.pi_lot_id+'">'+numberFormat(valItem.total_weight_unit_net)+'</span> <input type="hidden" class="form-control text-right" name="total_weight_unit_net['+valItem.pi_lot_id+']" id="total_weight_unit_net_'+valItem.pi_lot_id+'" value="'+valItem.total_weight_unit_net+'" autocomplete="off"></td>';
                                html += '    <td> <span id="text_total_weight_unit_gross_'+valItem.pi_lot_id+'">'+numberFormat(valItem.total_weight_unit_gross)+'</span> <input type="hidden" class="form-control text-right" name="total_weight_unit_gross['+valItem.pi_lot_id+']" id="total_weight_unit_gross_'+valItem.pi_lot_id+'" value="'+valItem.total_weight_unit_gross+'" autocomplete="off"></td>';

                                html += '   <td style="cursor: pointer; color: red; font-weight: 900;" onclick="deleteLotRows('+valItem.pi_lot_id+')"> X </td>';
                                html += '</tr>';

                                changeCBB(valItem.pi_lot_id);
                                roll++;

                            });

                            $("#manageDetailProduct").show();
                            $("#buttonCreateLots").attr('disabled', true);
                            // swal.close();

                        }else{
                            // createProformaLots(piLineID);
                            $("#manageDetailProduct").show();
                            $("#buttonCreateLots").attr('disabled', false);
                        }

                        swal.close();
                        $('#orderLots').html(html);

                        sumResultLot();
                    }
                });
            }
        }
    }

    function selectOrg(lotID)
    {
        // dataOrgList     = [];
        // dataLotList     = [];

        var itemCode = $("#lot_inv_org_code_"+lotID).val();

        if(itemCode != ''){

            var itemID                  = '';
            var itemSub                 = '';
            var itemSerial              = '';
            var itemInventoryLocation   = '';
            var itemUOM                 = '';
            var itemOnhandConv          = '';
            var itemName                = '';
            var itemTotalOnhand         = '';

            $.each(dataOrgList, function(key,val){
                if (val.organization_code == itemCode) {
                    itemID                  = val.organization_id;
                    itemSerial              = val.serial_number;
                    itemInventoryLocation   = val.locator_id;
                    itemUOM                 = val.transaction_uom_code;
                    itemOnhandConv          = numberFormat(val.onhand_quantity);
                    itemName                = val.organization_name;
                    itemTotalOnhand         = numberFormat(val.total_onhand_quantity);
                }
            });

            $("#lot_inv_org_id_"+lotID).val(itemID);
            $("#lot_serial_number_"+lotID).val(itemSerial);
            $("#lot_inventory_location_id_"+lotID).val(itemInventoryLocation);
            $("#lot_inv_uom_code_"+lotID).val(itemUOM);
            $("#lot_onhand_conv_qty_"+lotID).val(itemOnhandConv);
            $("#inv_org_name_"+lotID).val(itemName);
            $("#lot_onhand_quantity_"+lotID).val(itemTotalOnhand);

            // SUBINVENTORY
            var html = '';
            $.each(dataLotList, function(key,val){
                if (val.organization_code == itemCode) {
                    html += ' <option value="'+val.subinventory_code+'">'+val.subinventory_code+'</option>';
                }
            });

            $("#org-subinventory-list-"+lotID).html(html);

            // LOCATOR
            var html = '';
            $.each(dataLotList, function(key,val){
                if (val.organization_code == itemCode) {
                    html += ' <option value="'+val.locator+'">'+val.locator+'</option>';
                }
            });

            $("#org-locator-list-"+lotID).html(html);

            // LOT
            var html = '';
            $.each(dataLotList, function(key,val){
                if (val.organization_code == itemCode) {
                    html += ' <option value="'+val.lot_number+'">'+val.lot_number+'</option>';
                }
            });

            $("#org-lot-list-"+lotID).html(html);


        }else{
            $("#lot_inv_org_id_"+lotID).val('');
            $("#lot_serial_number_"+lotID).val('');
            $("#lot_inventory_location_id_"+lotID).val('');
            $("#lot_inv_uom_code_"+lotID).val('');
            $("#lot_onhand_conv_qty_"+lotID).val('');
            $("#inv_org_name_"+lotID).val('');
            $("#lot_onhand_quantity_"+lotID).val('');
            $("#lot_subinventory_code_"+lotID).val('');
            $("#lot_locator_"+lotID).val('');
            $("#lot_lot_number_"+lotID).val('');

            $("#org-subinventory-list-"+lotID).html('');
            $("#org-locator-list-"+lotID).html('');
            $("#org-lot-list-"+lotID).html('');
        }
    }

    function selectOrgSubInventory(lotID)
    {

    }

    function selectOrgLocator(lotID)
    {

    }

    function selectOrgLot(lotID)
    {
        var itemNumber = $("#lot_lot_number_"+lotID).val();
        var onhandQuantity = 0;

        if(itemNumber != ''){

            var itemSerial              = '';
            var itemInventoryLocation   = '';
            var itemTotalOnhand         = '';
            var itemOnhandConv          = '';

            $.each(dataLotList, function(key,val){
                if (val.lot_number == itemNumber) {
                    itemSerial              = val.serial_number;
                    itemInventoryLocation   = val.locator_id;
                    itemUOM                 = val.transaction_uom_code;
                    itemTotalOnhand         = numberFormat(val.onhand_quantity);
                    itemOnhandConv          = numberFormat(val.onhand_quantity);
                }
            });

            $("#lot_serial_number_"+lotID).val(itemSerial);
            $("#lot_inventory_location_id_"+lotID).val(itemInventoryLocation);
            $("#lot_inv_uom_code_"+lotID).val(itemUOM);
            $("#lot_onhand_quantity_"+lotID).val(itemTotalOnhand);
            $("#lot_onhand_conv_qty_"+lotID).val(itemOnhandConv);



        }else{
            var orgCode = $('#lot_inv_org_code_'+lotID).val();

            $.each(dataLotList, function(key,val){
                if (orgCode == val.organization_code) {
                    onhandQuantity = parseFloat(onhandQuantity) + parseFloat($.trim(val.onhand_quantity));
                }
            });

            $("#lot_onhand_quantity_"+lotID).val(numberFormat(onhandQuantity));
        }
    }

    function weightLotChange(index)
    {
        var amount  = parseFloat( $.trim($('#quantity_cbb_'+index).val()) != '' ? $.trim($('#quantity_cbb_'+index).val()) : 0);
        var net     = parseFloat( $.trim($('#weight_unit_net_'+index).val()) != '' ? $.trim($('#weight_unit_net_'+index).val()) : 0);
        var gross   = parseFloat( $.trim($('#weight_unit_gross_'+index).val()) != '' ? $.trim($('#weight_unit_gross_'+index).val()) : 0);

        var total_net   = amount * net;
        var total_gross = amount * gross;

        $('#total_weight_unit_net_'+index).val(total_net);
        $('#text_total_weight_unit_net_'+index).html(numberFormat(total_net));
        $('#total_weight_unit_gross_'+index).val(total_gross);
        $('#text_total_weight_unit_gross_'+index).html(numberFormat(total_gross));

        var resultTotalNet      = 0;
        var resultTotalGross    = 0;

        $("input[name='manage_lot[]']").each(function ()
        {
            var lineID   = parseInt($(this).val());

            total_net   = $('#total_weight_unit_net_'+lineID).val() != '' ? parseFloat($('#total_weight_unit_net_'+lineID).val()) : 0;
            total_gross = $('#total_weight_unit_gross_'+lineID).val() != '' ? parseFloat($('#total_weight_unit_gross_'+lineID).val()) : 0;

            resultTotalNet      = resultTotalNet + total_net;
            resultTotalGross    = resultTotalGross + total_gross;

        });

        sumResultLot();
    }

    function selectCurrency()
    {
        var code = $("#currency").val();

        if(code != ''){

            var itemName = '';
            $.each(currencyList, function(key,val){
                if (val.currency_code == code) {
                    itemName = val.name;
                }
            });

            $("#currency_name").val(itemName);
        }else{
            $("#currency_name").val('');
        }
    }

    function selectProformaInvoice()
    {
        var piNumber = $('#pi_number').val();

        var piStatus    = 'Draft';
        var piDate      = '';
        var orderNumber = '';
        var saNumber    = '';
        var orderDate   = '';

        if (piNumber != '') {
            $.each(proformaList, function(key, val){
                if (val.pi_number == piNumber) {
                    piStatus    = val.order_status;
                    piDate      = val.pi_date;
                    orderNumber = val.order_number;
                    saNumber    = val.sa_number;
                    orderDate    = val.order_date;
                }
            });
        }

        $('#order_status').val(piStatus);
        // $('#pi_date').val(piDate);
        // $('#show_pi_date').val(piDate);
        // generatePiDate(piDate, false);
        $("#pi_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", piDate);

        if ($('#order_number').val() == '') {
            $('#order_number').val(orderNumber);
            $('#order_date').val(orderDate);
            $('#show_order_date').val(orderDate);
        }

        if ($('#sa_number').val() == '') {
            $('#sa_number').val(saNumber);
        }

        setSelectValue(1);
    }

    function selectOrderNumber() {
        var orderNumber = $('#order_number').val();

        // var orderStatus    = 'Draft';
        var orderDate   = '';
        var piNumber    = '';
        var saNumber    = '';
        var piDate      = '';

        if (orderNumber != '') {
            $.each(orderList, function(key, val){
                if (val.order_number == orderNumber) {
                    // orderStatus    = val.order_status;
                    orderDate   = val.order_header_date;
                    piNumber    = val.pi_number;
                    saNumber    = val.sa_number;
                    piDate      = val.pi_date;
                }
            });
        }

        // $('#order_status').val(orderStatus);
        $('#order_date').val(orderDate);
        $('#show_order_date').val(orderDate);

        if ($('#pi_number').val() == '') {
            $('#pi_number').val(piNumber);
            // $('#pi_date').val(piDate);
            // $('#show_pi_date').val(piDate);
            // generatePiDate(piDate, false);
            $("#pi_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", piDate);
        }

        if ($('#sa_number').val() == '') {
            $('#sa_number').val(saNumber);
        }

        setSelectValue(1);
    }

    function selectSaNumber()
    {
        var saNumber = $('#sa_number').val();

        // var orderStatus    = 'Draft';
        var orderDate   = '';
        var piNumber    = '';
        var orderNumber = '';
        var piDate      = '';
        var orderHeaderID = '';

        if (saNumber != '') {
            $.each(saList, function(key, val){
                if (val.sa_number == saNumber) {

                    // console.log(val.sa_number+' '+ saNumber);
                    // orderStatus    = val.order_status;
                    orderDate   = val.order_date;
                    piNumber    = val.pi_number;
                    orderNumber = val.order_number;
                    piDate      = val.pi_date;
                }
            });
        }

        if ($('#pi_number').val() == '') {
            $('#pi_number').val(piNumber);
            // $('#pi_date').val(piDate);
            // $('#show_pi_date').val(piDate);
            // generatePiDate(piDate, false);
            $("#pi_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", piDate);
        }

        if ($('#order_number').val() == '') {
            $('#order_number').val(orderNumber);
            $('#order_date').val(orderDate);
            $('#show_order_date').val(orderDate);
        }

        setSelectValue(3)
    }

    function selectCustomer()
    {
        var customerNumber = $("#customer_number").val();

        if(customerNumber != ''){

            var itemID      = '';
            var itemName    = '';
            var itemAddress = '';

            var addressLine1        = '';
            var addressLine2        = '';
            var addressLine3        = '';
            var alley               = '';
            var state               = '';
            var district            = '';
            var city                = '';
            var provinceName        = '';
            var postalCode          = '';
            var country_name        = '';

            $.each(customerList, function(key,val){
                if (val.customer_number == customerNumber) {

                    addressLine1        = val.address_line1 != null ? val.address_line1+', ' : '';
                    addressLine2        = val.address_line2 != null ? val.address_line2+', ' : '';
                    addressLine3        = val.address_line3 != null ? val.address_line3+', ' : '';
                    alley               = val.alley != null ? val.alley+', ' : '';
                    state               = val.state != null ? val.state+', ' : '';
                    district            = val.district != null ? val.district+', ' : '';
                    city                = val.city != null ? val.city+', ' : '';
                    provinceName        = val.province_name != null ? val.province_name+', ' : '';
                    postalCode          = val.postal_code != null ? val.postal_code+', ' : '';
                    country_name        = val.country_name != null ? val.country_name+'.' : '';

                    itemID      = val.customer_id;
                    itemName    = val.customer_name;
                    itemAddress = addressLine1 + addressLine2 + addressLine3 + alley + state + district + city + provinceName + postalCode + country_name;
                }
            });

            $("#customer_id").val(itemID);
            $("#customer_name").val(itemName);
            $('#customer_address').val(itemAddress);
        }else{
            $("#customer_id").val('');
            $("#customer_name").val('');
            $('#customer_address').val('');
        }

        setSelectValue(4);
    }

    function setSelectValue(index)
    {
        // console.log(index);
        var proformaInvoice     = $('#pi_number').val();
        var orderNumber         = $("#order_number").val();
        var saNumber            = $('#sa_number').val();
        var customerNumber      = $("#customer_number").val();

        var prepareSelect   = '';
        var orderSelect     = '';
        var saSelect        = '';
        var customerSelect  = '';

        // if (index == 2 || index == 3) {
        // if (index == 3) {
            // PROFORMA INVOICE NUMBER
            var htmlProformaInvoiceList = '';

            $.each(proformaList, function(key, val){
                if($.trim(val.pi_number) != ''){
                    if (proformaInvoice == val.pi_number) {
                        prepareSelect   = 'selected';
                    }else{
                        prepareSelect   = '';
                    }

                    if (orderNumber == '' && saNumber == '' && customerNumber == ''){
                        htmlProformaInvoiceList += '<option value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if (orderNumber != '' && saNumber == '' && customerNumber == '' && val.order_number == orderNumber){
                        htmlProformaInvoiceList += '<option '+prepareSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(orderNumber != '' && saNumber != '' && customerNumber == '' && val.order_number == orderNumber && val.sa_number == saNumber){
                        htmlProformaInvoiceList += '<option '+prepareSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(orderNumber != '' && saNumber != '' && customerNumber != '' && val.order_number == orderNumber && val.sa_number == saNumber && val.customer_number == customerNumber){
                        htmlProformaInvoiceList += '<option '+prepareSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if (orderNumber == '' && saNumber != '' && customerNumber == '' && val.sa_number == saNumber){
                        htmlProformaInvoiceList += '<option '+prepareSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(orderNumber == '' && saNumber != '' && customerNumber != '' && val.sa_number == saNumber && val.customer_number == customerNumber){
                        htmlProformaInvoiceList += '<option '+prepareSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(orderNumber == '' && saNumber == '' && customerNumber != '' && val.customer_number == customerNumber){
                        htmlProformaInvoiceList += '<option '+prepareSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(orderNumber != '' && saNumber == '' && customerNumber != '' && val.order_number == orderNumber && val.customer_number == customerNumber){
                        htmlProformaInvoiceList += '<option '+prepareSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }
                }
            });

            $('#proforma-list').html(htmlProformaInvoiceList);
        // }


        // if (index == 1 || index == 3) {
        // if (index == 3) {
            // ORDER HEADERS
            var htmlOrderList = '';
            var checkOrderNumber = '';
            var checkDuplicateOrderNumber = '';

            $.each(orderList, function(key, val){

                if (checkDuplicateOrderNumber != val.order_number) {
                    if($.trim(val.order_number) != '' && checkOrderNumber != (val.order_number) || proformaInvoice == val.pi_number || saNumber == val.sa_number || customerNumber == val.customer_number){
                        if (orderNumber == val.order_number) {
                            orderSelect   = 'selected';
                        }else{
                            orderSelect   = '';
                        }

                        if (proformaInvoice == '' && saNumber == '' && customerNumber == ''){
                            htmlOrderList += '<option value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                        else if (proformaInvoice != '' && saNumber == '' && customerNumber == '' && val.pi_number == proformaInvoice){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                        else if(proformaInvoice != '' && saNumber != '' && customerNumber == '' && val.pi_number == proformaInvoice && val.sa_number == saNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                        else if(proformaInvoice != '' && saNumber != '' && customerNumber != '' && val.pi_number == proformaInvoice && val.sa_number == saNumber && val.customer_number == customerNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                        else if (proformaInvoice == '' && saNumber != '' && customerNumber == '' && val.sa_number == saNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                        else if(proformaInvoice == '' && saNumber != '' && customerNumber != '' && val.sa_number == saNumber && val.customer_number == customerNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                        else if(proformaInvoice == '' && saNumber == '' && customerNumber != '' && val.customer_number == customerNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                        else if(proformaInvoice != '' && saNumber == '' && customerNumber != '' && val.pi_number == proformaInvoice && val.customer_number == customerNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                        checkOrderNumber = val.order_number;
                    }

                    checkDuplicateOrderNumber = val.order_number;
                }
            });

            $('#order-data-list').html(htmlOrderList);
        // }


            // SA NUMBER
            var htmlSaList = '';
            var checkSaNumber = '';

            $.each(saList, function(key, val){
                if($.trim(val.sa_number) != '' && checkSaNumber != (val.sa_number) || proformaInvoice == val.pi_number || orderNumber == val.order_number || customerNumber == val.customer_number ){
                    if (orderNumber == val.sa_number) {
                        saSelect   = 'selected';
                    }else{
                        saSelect   = '';
                    }

                    if (proformaInvoice == '' && orderNumber == '' && customerNumber == ''){
                        htmlSaList += '<option value="'+ val.sa_number +'">'+ val.sa_number +'</option>';
                    }

                    else if (proformaInvoice != '' && orderNumber == '' && customerNumber == '' && val.pi_number == proformaInvoice){
                        htmlSaList += '<option '+saSelect+' value="'+ val.sa_number +'">'+ val.sa_number +'</option>';
                    }

                    else if(proformaInvoice != '' && orderNumber != '' && customerNumber == '' && val.pi_number == proformaInvoice && val.sa_number == orderNumber){
                        htmlSaList += '<option '+saSelect+' value="'+ val.sa_number +'">'+ val.sa_number +'</option>';
                    }

                    else if(proformaInvoice != '' && orderNumber != '' && customerNumber != '' && val.pi_number == proformaInvoice && val.sa_number == orderNumber && val.customer_number == customerNumber){
                        htmlSaList += '<option '+saSelect+' value="'+ val.sa_number +'">'+ val.sa_number +'</option>';
                    }

                    else if (proformaInvoice == '' && orderNumber != '' && customerNumber == '' && val.sa_number == orderNumber){
                        htmlSaList += '<option '+saSelect+' value="'+ val.sa_number +'">'+ val.sa_number +'</option>';
                    }

                    else if(proformaInvoice == '' && orderNumber != '' && customerNumber != '' && val.sa_number == orderNumber && val.customer_number == customerNumber){
                        htmlSaList += '<option '+saSelect+' value="'+ val.sa_number +'">'+ val.sa_number +'</option>';
                    }

                    else if(proformaInvoice == '' && orderNumber == '' && customerNumber != '' && val.customer_number == customerNumber){
                        htmlSaList += '<option '+saSelect+' value="'+ val.sa_number +'">'+ val.sa_number +'</option>';
                    }

                    else if(proformaInvoice != '' && orderNumber == '' && customerNumber != '' && val.pi_number == proformaInvoice && val.customer_number == customerNumber){
                        htmlSaList += '<option '+saSelect+' value="'+ val.sa_number +'">'+ val.sa_number +'</option>';
                    }

                    checkSaNumber = val.sa_number;
                }
            });

            $('#sale-confirm-list').html(htmlSaList);

        // if (index == 1 || index == 2) {
            // CUSTOMERS
            var htmlCustomerList = '';
            checkCustomer = '';

            if (proformaInvoice == '' && orderNumber == '' && saNumber == ''){
                $.each(customerList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (customerNumber == '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }else if (val.customer_number == customerNumber && customerNumber != '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }
                    }
                });
            }else if(proformaInvoice != ''){
                // console.log(proformaInvoice);
                // console.log(orderNumber);
                // console.log(customerNumber);
                $.each(proformaList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (customerNumber == val.customer_number) {
                            customerSelect   = 'selected';
                        }else{
                            customerSelect   = '';
                        }

                        if (checkCustomer == val.customer_number) {

                        }else if (proformaInvoice == val.pi_number) {
                            htmlCustomerList += '<option '+customerSelect+' value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                            checkCustomer = val.customer_number;
                        }
                    }
                });
            }else if(orderNumber != ''){
                $.each(orderList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (customerNumber == val.customer_number) {
                            customerSelect   = 'selected';
                        }else{
                            customerSelect   = '';
                        }

                        if (checkCustomer == val.customer_number) {

                        }else if (orderNumber == val.order_number) {
                            htmlCustomerList += '<option '+customerSelect+' value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                            checkCustomer = val.customer_number;
                        }
                    }
                });
            }else if(saNumber != ''){
                $.each(saList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (customerNumber == val.customer_number) {
                            customerSelect   = 'selected';
                        }else{
                            customerSelect   = '';
                        }

                        if (checkCustomer == val.customer_number) {

                        }else if (saNumber == val.sa_number) {
                            htmlCustomerList += '<option '+customerSelect+' value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                            checkCustomer = val.customer_number;
                        }
                    }
                });
            }


            // else{
            //     $.each(orderList, function(key, val){
            //         if($.trim(val.customer_number) != ''){
            //             if (customerNumber == val.customer_number) {
            //                 customerSelect   = 'selected';
            //             }else{
            //                 customerSelect   = '';
            //             }

            //             if (checkCustomer == val.customer_number) {

            //             }else if (orderNumber == val.order_number && $.trim(val.order_number) != '') {
            //                 htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
            //                 checkCustomer = val.customer_number;
            //             }else if (proformaInvoice == val.pi_number && $.trim(val.pi_number) != '') {
            //                 htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
            //                 checkCustomer = val.customer_number;
            //             }else if (val.customer_number == customerNumber && customerNumber != '') {
            //                 htmlCustomerList += '<option '+customerSelect+' value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
            //                 checkCustomer = val.customer_number;
            //             }else if (customerNumber == ''){
            //                 htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
            //                 checkCustomer = val.customer_number;
            //             }
            //         }
            //     });
            // }


            $('#customer-list').html(htmlCustomerList);
        // }
    }

    function newResetProformaInvoice()
    {
        window.location = '{{ url('om/proforma-invoice') }}';
    }

    function resetProformaInvoice()
    {
        $('#order_status').val('Draft');

        $('#pi_number').val('');
        // $('#pi_date').val('');
        // $('#show_pi_date').val('');
        // generatePiDate('', false);
        $("#pi_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", '');

        $('#order_number').val('');
        $('#order_date').val('');
        $('#show_order_date').val('');

        $('#sa_number').val('');

        $('#customer_number').val('').trigger('change');

        if ($('#customer_number').val() == '') {
            $('#customer_name').val('');
            $('#customer_address').val('');
        }

        $('#order_type_id').val('').trigger('change');
        $('#currency').val('');
        $('#currency_name').val('');

        $('#term_id').val('');
        $('#term_name').val('').trigger('change');
        $('#term_description').val('');

        $('#payment_type_code').val('').trigger('change');
        $('#vat_code').val('');
        $('#payment_method_code').val('').trigger('change');
        $('#remark').val('');

        $('#bill_to_site_name').val('');
        $('#ship_to_site_id').val('').trigger('change');
        $('#incoterms_code').val('');

        $('#port_of_loading').val('Tobacco Authority of Thailand, Thailand');
        $('#transport_type_code').val('');
        $('#transport_detail').val('');

        $('#port_of_discharge').val('');
        $('#place_of_delivery').val('');

        $('#shipping_marks').val('');
        $('#shipment_condition').val('');
        $('#source_system').val('');
        $('#delivery_date').val('');

        // generateDeliveryDate('', true);
        // $('#delivery_date').val('');

        // HIDDEN
        $('#order_header_id').val('');
        $('#customer_id').val('');
        $('#sale_confirm_by').val('');
        $('#sale_confirm_flag').val('');
        $('#bill_to_site_id').val('');

        // HTML
        var defaultOrderLine = '';
        defaultOrderLine += '<tr>';
        defaultOrderLine += '    <td class="text-right black" colspan="13"><strong>Total Weight</strong></td>';
        defaultOrderLine += '    <td class="text-right black"><strong>0.00</strong></td>';
        defaultOrderLine += '    <td class="text-right black"><strong>0.00</strong></td>';
        defaultOrderLine += '</tr>';

        $('#orderLines').html('');
        $('#orderLinesTotal').html(defaultOrderLine);

        $('#resultSubtotal').html(numberFormat(0.00));
        $('#resultTax').html(numberFormat(0.00));
        $('#resultTotal').html(numberFormat(0.00));

        $('#sub_total').val(0.00);
        $('#tax').val(0.00);
        $('#grand_total').val(0.00);

        setAttachment([]);
        setDefaultInput(1);

        // Another case
        $('#price_list_id').val('').trigger('change');

        // $('#buttonCreateLine').prop('disabled', true);
    }

    function setDefaultInput(inputStatus)
    {
        // inputStatus = 1 Is Confirm or Disabled or Readonly
        // inputStatus = 2 Is Draft

        if (inputStatus == 1) {
            // $('#sa_date').prop('readonly', true);
            // $('#order_date').prop('readonly', true);
            $('#cust_po_number').prop('readonly', true);
            $('#currency').prop('readonly', true);
            $('#term_name').prop('readonly', true);
            $('#payment_type_code').prop('readonly', true);
            $('#vat_code').prop('readonly', true);
            $('#payment_method_code').prop('readonly', true);
            $('#remark').prop('readonly', true);
            $('#bill_to_site_name').prop('readonly', true);
            $('#port_of_loading').prop('readonly', true);
            $('#transport_detail').prop('readonly', true);
            $('#shipment_condition').prop('readonly', true);
            $('#shipping_marks').prop('readonly', true);
            $('#port_of_discharge').prop('readonly', true);
            $('#place_of_delivery').prop('readonly', true);
            $('#delivery_date').prop('readonly', true);


            $('.check-default').select2({disabled: 'disabled'});

            $('.check-create').select2({disabled: ''});
        }else{
            // $('#sa_date').prop('readonly', false);
            // $('#order_date').prop('readonly', false);
            $('#cust_po_number').prop('readonly', false);
            $('#currency').prop('readonly', false);
            $('#term_name').prop('readonly', false);
            $('#payment_type_code').prop('readonly', false);
            $('#vat_code').prop('readonly', false);
            $('#payment_method_code').prop('readonly', false);
            $('#remark').prop('readonly', false);
            $('#bill_to_site_name').prop('readonly', false);
            $('#port_of_loading').prop('readonly', false);
            $('#transport_detail').prop('readonly', false);
            $('#shipment_condition').prop('readonly', false);
            $('#shipping_marks').prop('readonly', false);
            $('#port_of_discharge').prop('readonly', false);
            $('#place_of_delivery').prop('readonly', false);
            $('#delivery_date').prop('readonly', false);

            $('.check-default').select2({disabled: ''});

            $('.check-create').select2({disabled: ''});

            $('.date').datepicker();
        }
        $('#pi_number').prop('readonly', false);
        $('#order_number').prop('readonly', false);
        $('#sa_number').prop('readonly', false);
        $('#customer_number').prop('readonly', false);

        $('.check-price-list').select2({disabled: 'disabled'});
    }

    function selectTerm()
    {
        var name = $("#term_name").val();

        if(name != ''){
            var itemID      = '';
            var itemName    = '';
            $.each(termList, function(key,val){
                if (val.name == name) {
                    itemID      = val.term_id;
                    itemName    = val.description;
                }
            });

            $("#term_id").val(itemID);
            $("#term_description").val(itemName);
        }else{
            $("#term_id").val('');
            $("#term_description").val('');
        }
    }

    function calculateVat(piLineID)
    {
        var quantity    = $('#order_quantity_'+piLineID).val();
        var unitPrice   = $('#unit_price_'+piLineID).val();
        var amount      = $('#amount_'+piLineID).val();
        var taxAmount   = $('#tax_amount_'+piLineID).val();
        var totalAmount = $('#total_amount_'+piLineID).val();

        var subVat      = $('#sub_vat_'+piLineID).val();
        var percenRate  = 0;
        $.each(taxCode, function(key,val){
            if (val.tax_rate_code == subVat) {
                percenRate = val.percentage_rate;

            }
        });

        var resultTaxAmount     = (ParseFloat(amount) * ParseFloat(percenRate)) / 100;
        var resultTotalAmount   = ParseFloat(amount) + ParseFloat(resultTaxAmount);

        $('#text_tax_amount_'+piLineID).html(numberFormat(resultTaxAmount));
        $('#text_total_amount_'+piLineID).html(numberFormat(resultTotalAmount));

        $('#tax_amount_'+piLineID).val(resultTaxAmount);
        $('#total_amount_'+piLineID).val(resultTotalAmount);


        var resultSubTotal  = 0;
        var resultTax       = 0;
        var resultTotal     = 0;

        $("input[name='order_line_manage[]']").each(function ()
        {
            var lineID          = parseInt($(this).val());

            var orderQuantity       = $('#order_quantity_'+lineID).val() != '' ? ParseFloat($('#order_quantity_'+lineID).val()) : 0;
            var orderAmount         = $('#amount_'+lineID).val() != '' ? ParseFloat($('#amount_'+lineID).val()) : 0;
            var orderTaxAmount      = $('#tax_amount_'+lineID).val() != '' ? ParseFloat($('#tax_amount_'+lineID).val()) : 0;
            var orderTotalAmount    = $('#total_amount_'+lineID).val() != '' ? ParseFloat($('#total_amount_'+lineID).val()) : 0;

            resultSubTotal      = resultSubTotal + orderAmount;
            resultTax           = resultTax + orderTaxAmount;
            resultTotal         = resultTotal + orderTotalAmount;

        });

        $('#resultSubtotal').html(numberFormat(resultSubTotal));
        $('#resultTax').html(numberFormat(resultTax));
        $('#resultTotal').html(numberFormat(resultTotal));

        $('#sub_total').val(resultSubTotal);
        $('#tax').val(resultTax);
        $('#grand_total').val(resultTotal);

    }

    function ParseFloat(str,val = 2) {
        str = str.toString();
        str = str.slice(0, (str.indexOf(".")) + val + 1);
        return Number(str);
    }

    function updateProformaLots()
    {
        var piLinesNumber       = $('#main_lot_pi_line_id').val();
        var mainOrderQuantity   = $('#order_quantity_'+piLinesNumber).val();
        var resultQuantity      = 0;
        var productTypeCode     = $('#product_type_code').val();

        $("input[name='manage_lot[]']").each(function ()
        {
            var LotID = parseInt($(this).val());

            var quantity        = $('#lot_order_quantity_'+LotID).val() != '' ? $('#lot_order_quantity_'+LotID).val() : 0;
            quantity            = quantity.replaceAll(/,/g, '');
            resultQuantity      = parseFloat(resultQuantity) + parseFloat(quantity);

        });

        if ($("input[name='manage_lot[]']").length <= 0) {
            Swal.fire({
                icon: 'warning',
                text: 'ไม่พบรายละเอียดสินค้า',
                showConfirmButton: true
            });
        }else if (parseFloat(resultQuantity).toFixed(2) != parseFloat(mainOrderQuantity).toFixed(2)) {
            console.log(parseFloat(resultQuantity).toFixed(2));
            console.log(parseFloat(mainOrderQuantity).toFixed(2));
            Swal.fire({
                icon: 'warning',
                text: 'โปรดระบุจำนวนที่ต้องการตัดให้ครบจำนวนสั่งซื้อ',
                showConfirmButton: true,
                timer: 2500
            });
        }else{
            Swal.showLoading();
            const formData = new FormData(document.getElementById("formProformaInvoice"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/proforma-invoice/update-lot") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    var data = res.data;
                    var html = '';
                    if(data.status == 'success'){

                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'บันทึกรายละเอียดสินค้าเรียบร้อยแล้ว',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2500
                        });

                        $('#buttonUpdateLots').attr('disabled', true);
                    }else{
                        Swal.fire({
                            title: 'ผิดพลาด',
                            text: 'ไม่สามารถบันทึกรายละเอียดสินค้าได้',
                            icon: 'error',
                            timer: 2500
                        });
                    }
                }
            });
        }
    }

    function deleteLotRows(index) {

        Swal.fire({
            title: 'ลบรายละเอียดสินค้าหรือไม่?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `ลบ`,
            denyButtonText: `ยกเลิก`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                const formData = new FormData(document.getElementById("formProformaInvoice"));
                formData.append('_token','{{ csrf_token() }}');
                formData.append('delete_lot_id', index);


                $.ajax({
                    url         : '{{ url("om/ajax/proforma-invoice/delete-lot-data") }}',
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

                            // $('#orderLots').html('');
                            $("#buttonCreateLots").attr('disabled', false);

                            $('#data_lot_'+index).remove();
                            sumResultLot();

                            Swal.fire({
                                title: 'สำเร็จ',
                                text: 'ลบรายละเอียดสินค้าเรียบร้อยแล้ว',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }else{
                            Swal.fire({
                                title: 'ผิดพลาด',
                                text: 'ไม่สามารถลบรายละเอียดสินค้าได้',
                                icon: 'error',
                                timer: 2500
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                // cancel
            }
        });
    }

    function deleteProformaLots() {
        if ($("input[name='manage_lot[]']").length <= 0) {
            Swal.fire({
                icon: 'warning',
                text: 'ไม่พบรายละเอียดสินค้า',
                showConfirmButton: true
            });
        }else{

            Swal.fire({
                title: 'ลบรายละเอียดสินค้าหรือไม่?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `ลบ`,
                denyButtonText: `ยกเลิก`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    const formData = new FormData(document.getElementById("formProformaInvoice"));
                    formData.append('_token','{{ csrf_token() }}');

                    $.ajax({
                        url         : '{{ url("om/ajax/proforma-invoice/delete-all-lot") }}',
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

                                $('#orderLots').html('');
                                $("#buttonCreateLots").attr('disabled', false);

                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบรายละเอียดสินค้าเรียบร้อยแล้ว',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: 'ไม่สามารถลบรายละเอียดสินค้าได้',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }
                        }
                    });
                } else if (result.isDenied) {
                    // cancel
                }
            });
        }
    }

    function changeCase(index)
    {
        var caseFrom   = parseInt($('#case_no_from_'+ index).val());
        var caseTo     = parseInt($('#case_no_to_'+ index).val());
        var quantity   = parseInt($('#lot_order_quantity_'+ index).val());
        var productTypeCode = $.trim($('#product_type_code').val());

        $('#case_no_from_'+ index).val(addNumberZero(caseFrom, 3));
        $('#case_no_to_'+ index).val(addNumberZero(caseTo, 3));

        if (caseFrom > caseTo) {
            Swal.fire({
                title: 'ผิดพลาด',
                text: 'Case No. ไม่ถูกต้อง',
                icon: 'error',
                timer: 2500
            });
            $('#case_no_to_'+ index).val(addNumberZero(quantity, 3));
            caseTo = quantity;
        }

        var newQuantityCBB  = (caseTo - caseFrom) + 1;
        $('#quantity_cbb_'+index).val(newQuantityCBB);

        var resultQuantityCbb   = 0;
        var valFrom = 0;
        var valTo = 0;
        var beforeID = 0;

        if ($("input[name='manage_lot[]']").length > 0) {
            $("input[name='manage_lot[]']").each(function ()
            {
                var LotID = parseInt($(this).val());
                var sumQuantityCbb  = $('#quantity_cbb_'+LotID).val() != '' ? parseFloat($('#quantity_cbb_'+LotID).val()) : 0;
                resultQuantityCbb   = resultQuantityCbb + sumQuantityCbb;

                if (beforeID == 0) {
                    beforeID = LotID;
                }

                var caseFromBefore   = parseInt($('#case_no_from_'+ beforeID).val());
                var caseToBefore     = parseInt($('#case_no_to_'+ beforeID).val());
                var quantityBefore   = parseInt($('#lot_order_quantity_'+ beforeID).val());

                // if(LotID > index){
                if(beforeID > 0){
                    if (productTypeCode != 10) {
                        valFrom = caseToBefore + 1;
                        valTo = valFrom;
                    } else {
                        valFrom = caseToBefore + 1;
                        valTo = valFrom + quantityBefore;
                    }
                    if(lotID != index){
                        $('#case_no_from_'+ LotID).val(addNumberZero(valFrom, 3));
                    }

                    $('#case_no_to_'+ LotID).val(addNumberZero(valTo, 3));
                }

                beforeID = LotID;
            });
        }

        $('#text_total_quantity_cbb').text(resultQuantityCbb);

        changeCBB(index);
    }

    function changeCBB(index)
    {
        var quantityCBB = $('#quantity_cbb_'+index).val();
        var weightNet   = $('#weight_unit_net_'+index).val();
        var weightGross = $('#weight_unit_gross_'+index).val();

        var resultNet = quantityCBB * weightNet;
        var resutlGross = quantityCBB * weightGross;

        $('#text_total_weight_unit_net_'+index).html(numberFormat(parseFloat(resultNet)));
        $('#total_weight_unit_net_'+index).val(parseFloat(resultNet));
        $('#text_total_weight_unit_gross_'+index).html(numberFormat(parseFloat(resutlGross)));
        $('#total_weight_unit_gross_'+index).val(parseFloat(resutlGross));

        // RESULT TOTAL
        var totalNet = 0;
        var totalGross = 0;

        if ($("input[name='manage_lot[]']").length > 0) {
            $("input[name='manage_lot[]']").each(function ()
            {
                var LotID       = parseInt($(this).val());
                var weightNet      = $('#total_weight_unit_net_'+LotID).val();
                var weightGross    = $('#total_weight_unit_gross_'+LotID).val();

                totalNet    = totalNet + weightNet;
                totalGross  = totalGross + weightGross;

            });
        }


        $('#text_total_net_weight').html(numberFormat(totalNet));
        $('#text_total_gross_weight').html(numberFormat(totalGross));
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
        if( caratPos > dotPos && dotPos>-1 && (number[1].length > 100)){
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

    function linkToPagePrint(){
        var piHeadersID = $('#pi_header_id').val();

        if (piHeadersID > 0) {
            var url = "{{ url('om/proforma-invoice/print') }}?pi_header_id="+piHeadersID;
            var myWindow = window.open(url, "_blank");
        }else{
            return false;
        }
    }

    function linkToPagePrintInvoice(){
        var orderHeaderID = $('#pi_header_id').val();

        if (orderHeaderID > 0) {
            var url = "{{ url('om/proforma-invoice/print-in') }}?pi_header_id="+orderHeaderID;
            var myWindow = window.open(url, "_blank");
        }else{
            return false;
        }
    }

    function linkToPagePrintPackingList(){
        var orderHeaderID = $('#pi_header_id').val();

        if (orderHeaderID > 0) {
            var url = "{{ url('om/tax-invoice-export/print-packing-list') }}?pi_header_id="+orderHeaderID+"&ref=72";
            var myWindow = window.open(url, "_blank");
        }else{
            return false;
        }
    }

    function generatePiDate(date, status = false)
    {
        $('#html_pi_date').html('<div id="mount_pi_date"></div>');
        fieldName   = 'pi_date';
        fieldID     = 'pi_date';
        fieldValue  = date;
        mountID     = 'mount_pi_date';
        disabled    = status;
        generateDatePickerTH(mountID);
    }

    // function generateDeliveryDate(date, statusDis = false)
    // {
    //     $('#html_delivery_date').html('<div id="mount_delivery_date"></div>');
    //     fieldName   = 'delivery_date';
    //     fieldID     = 'delivery_date';
    //     fieldValue  = date;
    //     mountID     = 'mount_delivery_date';
    //     fieldDisabled   = statusDis;
    //     generateDatePickerTH(mountID);
    // }

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
