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

    /* BUTTON INFO COLOR */
    .btn-info {
        background-color: #24c6c8 !important;
        border-color: #24c6c8 !important;
    }

    .input-icon .disabled{
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    #shipping_marks {
        height: 213px;
    }

    .w-400{
        width: 400px;
    }

    .min-2000{
        min-width: 2000px;
    }

    #page-wrapper {
        width: calc(100% - 220px) !important;
    }

</style>

@section('title', 'บันทึกใบ Sale-Confirmation สำหรับขายต่างประเทศ')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <x-get-page-title :menu="$menu" url="" />
    {{-- <h2>
        OMP0066 บันทึกใบ Sale Confirmation สำหรับขายต่างประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>บันทึกใบ Sale Confirmation สำหรับขายต่างประเทศ</strong>
        </li>
    </ol> --}}
@stop

@section('content')

    <form id="formSaleConfirmation"  autocomplete="off" enctype="multipart/form-data">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ !empty($menu->menu_title) ? $menu->menu_title : '' }}</h3>
            </div>
            <div class="ibox-content">
                <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                        <div class="col-12">
                            <div class="form-header-buttons">
                                <div class="d-flex">
                                    <button class="btn btn-md btn-white" type="button" onclick="newResetSaleConfirmation()"><i class="fa fa-repeat"></i></button>
                                </div>
                                <div class="buttons multiple">
                                    <button class="btn btn-md btn-success" type="button" id="buttonCreate" onclick="checkCreate()"><i class="fa fa-plus"></i> สร้าง</button>
                                    {{-- <button class="btn btn-md btn-success" type="button" onclick="createSaleConfirmation()" id="buttonCreate"><i class="fa fa-plus"></i> สร้าง</button> --}}
                                    {{-- <button class="btn btn-md btn-info" type="button" onclick="copySaleConfirmation()"><i class="fa fa-copy"></i> คัดลอก</button> --}}
                                    {{-- <button class="btn btn-md btn-white" type="button" onclick="searchSaleConfirmation()"><i class="fa fa-search"></i> ค้นหา</button> --}}
                                    <button class="btn btn-md btn-white" type="button" onclick="newSearchData()"><i class="fa fa-search"></i> ค้นหา</button>
                                    <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                                    <div class="dropdown">
                                        <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="javascript:void(0);" onclick="updateSaleConfirmation()">บันทึก</a></li>
                                            <li><a href="javascript:void(0);" onclick="confirmSaleConfirmation()">ยืนยัน</a></li>
                                            <li><a href="javascript:void(0);" onclick="checkCancel()">ยกเลิก</a></li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-md btn-info" type="button" onclick="linkToPagePrint()"><i class="fa fa-print"></i> พิมพ์ใบ Sale Confirmation</button>
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
                                                <label class="d-block"><strong>SA Status</strong></label>
                                                <input type="text" class="form-control" readonly  name="sa_status" id="sa_status" placeholder="" value="Draft" autocomplete="off">
                                                <input type="hidden"  name="order_header_id" id="order_header_id" value="">
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div>

                                <div class="col-xl-12"></div>

                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{-- <label class="d-block">เลขที่ใบ SA</label>
                                                <div class="input-icon">
                                                    <select class="custom-select check-create" name="prepare_order_number" id="prepare_order_number" onchange="selectPrepareOrderNumber()" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($saList as $item)
                                                        @if (!empty($item->prepare_order_number))
                                                            <option value="{{ $item->prepare_order_number }}">{{ $item->prepare_order_number }}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <div class="form-group">
                                                    <label class="d-block">เลขที่ใบ SA</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" name="prepare_order_number" id="prepare_order_number" list="prepare-list" value="{{ request()->prepare_order_number }}" onchange="selectPrepareOrderNumber()" autocomplete="off">
                                                        <i class="fa fa-search"></i>
                                                        <datalist id="prepare-list">

                                                            <option value=""> &nbsp; </option>
                                                            @foreach ($saList as $item)
                                                            @if (!empty($item->prepare_order_number))
                                                            <option value="{{ $item->prepare_order_number }}">{{ $item->prepare_order_number }}</option>
                                                            @endif
                                                            @endforeach

                                                        </datalist>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-6 mt-3 mt-md-0">
                                                <label class="d-block">วันที่</label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" readonly name="sa_date" id="sa_date" placeholder="" value="" autocomplete="off">
                                                    <i class="fa fa-calendar"></i>

                                                    {{-- <datepicker-th
                                                        style="width: 100%"
                                                        class="form-control md:tw-mb-0 tw-mb-2"
                                                        name="sa_date"
                                                        id="sa_date"
                                                        placeholder=""
                                                        value=""
                                                        format="{{ trans("date.js-format") }}"> --}}
                                                </div>
                                                {{-- <input type="hidden" name="sa_date" id="sa_date" value=""> --}}
                                            </div>
                                        </div><!--row-->
                                    </div><!--form-group-->
                                </div>

                                <div class="col-xl-7">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                {{-- <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                                                <div class="input-icon">
                                                    <select class="custom-select check-create" name="order_number" id="order_number" onchange="selectOrderNumber()" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($orderList as $item)
                                                        @if (!empty($item->order_number))
                                                            <option value="{{ $item->order_number }}">{{ $item->order_number }}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <div class="form-group">
                                                    <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" name="order_number" id="order_number" list="order-number-list" value="{{ request()->order_number }}" onchange="selectOrderNumber()" autocomplete="off">
                                                        <i class="fa fa-search"></i>
                                                        <datalist id="order-number-list">

                                                            <option value=""> &nbsp; </option>
                                                            @foreach ($orderList as $item)
                                                            @if (!empty($item->order_number) && !empty($item->prepare_order_number) && $item->order_status == 'Confirm')
                                                            <option value="{{ $item->order_number }}">{{ $item->order_number }}</option>
                                                            @endif
                                                            @endforeach

                                                        </datalist>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-4 mt-3 mt-md-0">
                                                <label class="d-block">วันที่สั่งซื้อ</label>
                                                <div class="input-icon" id="html_order_date">
                                                    <input type="text" class="form-control" readonly name="order_date" id="order_date" placeholder="" value="" autocomplete="off">
                                                    <i class="fa fa-calendar"></i>
                                                    {{-- <datepicker-th
                                                        style="width: 100%"
                                                        class="form-control md:tw-mb-0 tw-mb-2"
                                                        name="order_date"
                                                        id="order_date"
                                                        disabled
                                                        placeholder=""
                                                        value=""
                                                        format="{{ trans("date.js-format") }}"> --}}
                                                </div>
                                                {{-- <input type="hidden" name="order_date" id="order_date" value=""> --}}
                                            </div>
                                            <div class="col-md-4 mt-3 mt-md-0">
                                                <label class="d-block">Customer PO</label>
                                                <input type="text" class="form-control" name="cust_po_number" id="cust_po_number" placeholder="" value="" autocomplete="off">
                                            </div>
                                        </div><!--row-->
                                    </div><!--form-group-->
                                </div>

                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="d-block">ลูกค้า <span class="red">*</span></label>
                                        <div class="row space-5">
                                            <div class="col-md-4">
                                                {{-- <div class="input-icon">
                                                    @php
                                                        $checkDupNumber = '';
                                                    @endphp
                                                    <select class="custom-select" name="customer_number" id="customer_number" onchange="selectCustomer()" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($customerList as $item)
                                                        @if (!empty($item->customer_number) && $checkDupNumber != $item->customer_number)
                                                            <option value="{{ $item->customer_number }}">{{ $item->customer_number }}</option>
                                                            @php
                                                                $checkDupNumber = $item->customer_number;
                                                            @endphp
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <div class="form-group">
                                                    {{-- <label class="d-block">เลขที่ใบ SA</label> --}}
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" name="customer_number" id="customer_number" list="customers-list" value="" onchange="selectCustomer()" autocomplete="off">
                                                        <i class="fa fa-search"></i>
                                                        <datalist id="customers-list">
                                                            @php
                                                                $checkDupNumber = '';
                                                            @endphp
                                                            <option value=""> &nbsp; </option>
                                                            @foreach ($customerList as $item)
                                                            @if (!empty($item->customer_number) && $checkDupNumber != $item->customer_number)
                                                            <option value="{{ $item->customer_number }}">{{ $item->customer_name }}</option>
                                                            @php
                                                                $checkDupNumber = $item->customer_number;
                                                            @endphp
                                                            @endif
                                                            @endforeach

                                                        </datalist>

                                                        <input type="hidden" name="consignment_header_id" id="consignment_header_id" value="">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-8 mt-2 mt-md-0">
                                                <input type="hidden" name="customer_id" id="customer_id" value="">
                                                <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="" value="" autocomplete="off">
                                            </div>
                                        </div><!--row-->
                                    </div><!--form-group-->
                                </div>

                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">Order Type <span class="red">*</span></label>
                                                <div class="input-icon">
                                                    <select class="custom-select check-default" name="order_type_id" id="order_type_id" autocomplete="off">
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
                                        <textarea class="form-control" readonly name="customer_address" id="customer_address" autocomplete="off"></textarea>
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
                                                <select class="custom-select check-default" name="payment_type_code" id="payment_type_code" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($paymentType as $item)
                                                    <option value="{{ $item->lookup_code }}">{{ $item->description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="d-block">Vat Code <span class="red">*</span></label>
                                                <div class="input-icon">
                                                    <select class="custom-select check-default" name="vat_code" id="vat_code" onchange="selectVat()" autocomplete="off">
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
                                        <select class="custom-select check-default" name="payment_method_code" id="payment_method_code" autocomplete="off">
                                            <option value=""> &nbsp; </option>
                                            @foreach ($paymentMethodExport as $item)
                                            <option value="{{ $item->lookup_code }}">{{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="d-block">รายละเอียดเพิ่มเติม</label>
                                        <textarea name="remark" id="remark" class="form-control" autocomplete="off"> </textarea>
                                    </div>

                                </div><!--col-xl-4-->

                                <div class="col-xl-8 col-md-6">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label class="d-block">Bill To <span class="red">*</span></label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="bill_to_site_name" id="bill_to_site_name" placeholder="" value="" autocomplete="off">
                                                    <input type="hidden" name="bill_to_site_id" id="bill_to_site_id" value="">
                                                    {{-- <i class="fa fa-search"></i> --}}
                                                </div>
                                            </div>
                                        </div><!--col-md-6-->

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label class="d-block">Price List <span class="red">*</span></label>
                                                <select class="custom-select check-default" name="price_list_id" id="price_list_id" autocomplete="off">
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
                                                    <select class="custom-select check-default" name="ship_to_site_id" id="ship_to_site_id" autocomplete="off">
                                                        <option value=""> &nbsp; </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div><!--col-md-6-->

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label class="d-block"> {{ !empty($inCortermName) ? $inCortermName : '' }} <span class="red">*</span></label>
                                                <select class="custom-select check-default" name="incoterms_code" id="incoterms_code" autocomplete="off">
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
                                                <input type="text" class="form-control"  name="port_of_loading" id="port_of_loading" value="Tobacco Authority Of Thailand" autocomplete="off">
                                            </div>
                                        </div><!--col-md-6-->

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label class="d-block">Shipment By</label>
                                                <div class="row space-5">
                                                    <div class="col-6">
                                                        <select class="custom-select check-default" name="transport_type_code" id="transport_type_code" autocomplete="off">
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
                                                <label class="d-block">เงื่อนไขการขนส่ง</label>
                                                <input type="text" class="form-control"  name="shipment_condition" id="shipment_condition" placeholder="" value="" autocomplete="off">
                                            </div>

                                            <div class="form-group">
                                                <label class="d-block">สั่งทาง</label>
                                                <select class="custom-select check-default" name="source_system" id="source_system" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($salesChannel as $item)
                                                    <option value="{{ $item->meaning }}">{{ $item->meaning }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div><!--col-md-6-->

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label class="d-block">Shipping Marks</label>
                                                {{-- <input type="text" class="form-control"  name="shipping_marks" id="shipping_marks" placeholder="" value="" autocomplete="off"> --}}
                                                <textarea name="shipping_marks" id="shipping_marks" class="form-control" autocomplete="off"></textarea>
                                            </div>
                                        </div><!--col-md-6-->
                                    </div><!--row-->

                                </div><!--col-md-8-->

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-md-4 ml-auto">
                                    <div class="form-group">
                                        <label class="d-block">วันที่ขออนุมัติ</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" readonly name="sale_confirm_date" id="sale_confirm_date" placeholder="" value="" autocomplete="off">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mr-auto">
                                    <div class="form-group">
                                        <label class="d-block">เลขที่บันทึกขออนุมัติหลักการขาย</label>
                                        <input type="text" class="form-control" readonly name="sale_confirm_document_no" id="sale_confirm_document_no" placeholder="" value="" autocomplete="off">
                                        <input type="hidden" name="sale_confirm_by" id="sale_confirm_by" placeholder="" value="">
                                        <input type="hidden" name="sale_confirm_flag" id="sale_confirm_flag" placeholder="" value="">
                                    </div>
                                </div>
                            </div><!--row-->
                        </div><!--col-xl-12-->

                        <div class="col-xl-12">
                            <hr>
                            <div class="form-header-buttons flex-md-row-reverse">
                                <div class="buttons multiple">
                                    <button id="buttonCreateLine" disabled class="btn btn-md btn-success" type="button" onclick="addInputOrderLines()"><i class="fa fa-plus"></i> สร้าง</button>
                                    <button id="buttonCopyToPi" disabled class="btn btn-md btn-info" onclick="checkCopyToPI()" type="button"><i class="fa fa-copy"></i> Copy To PI</button>
                                </div>
                            </div><!--form-header-buttons-->

                            <div class="hr-line-dashed"></div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-hover min-2000 f13">
                                    <thead>
                                        <tr class="align-middle">
                                            {{-- <th rowspan="2">Select</th> --}}
                                            <th rowspan="2">รายการที่</th>
                                            <th rowspan="2" class="w-250">รหัสสินค้า</th>
                                            <th rowspan="2" class="w-250">ชื่อผลิตภัณฑ์</th>
                                            <th rowspan="2" class="w-250">UOM</th>
                                            <th rowspan="2">หน่วยนับ</th>
                                            <th rowspan="2" class="w-160">จำนวน<br>สั่งซื้อ</th>
                                            <th rowspan="2">จำนวนที่<br>สร้าง PI แล้ว</th>
                                            <th rowspan="2" class="w-160">ราคา/หน่วย</th>
                                            <th rowspan="2">Amount</th>
                                            <th rowspan="2" class="w-250">Vat Code</th>
                                            <th rowspan="2">Tax Amount</th>
                                            <th rowspan="2">Line Total</th>
                                            <th colspan="2">Weight/Unit</th>
                                            <th colspan="2">Line Total Weight (KG)</th>
                                            <th rowspan="2">ลบ</th>
                                        </tr>
                                        <tr class="align-middle">
                                            <!--Weight/Unit-->
                                            <th class="w-250">Net</th>
                                            <th class="w-250">Gross</th>

                                            <!--Weight/Unit-->
                                            <th class="w-160">Net</th>
                                            <th class="w-160">Gross</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderCreateLines">

                                    </tbody>
                                    <tbody id="orderLines">
                                        <tr>
                                            <td class="text-right black" colspan="14"><strong>Total Weight</strong></td>
                                            <td class="text-right black"><strong>0.00</strong></td>
                                            <td class="text-right black"><strong>0.00</strong></td>
                                            <td class="text-right black"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!--table-responsive-->

                            <div class="d-block mw-400 ml-auto mr-auto mt-4">
                                <table class="table table-bordered text-center">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>
                                                <span id="resultSubtotal">0.00</span>
                                                <input type="hidden" name="order_sub_total" id="order_sub_total" value="" autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tax</th>
                                            <td>
                                                <span id="resultTax">0.00</span>
                                                <input type="hidden" name="order_tax" id="order_tax" value="" autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td>
                                                <span id="resultTotal">0.00</span>
                                                <input type="hidden" name="order_total" id="order_total" value="" autocomplete="off">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!--col-xl-12-->
                </div><!--row-->
            </div><!--ibox-content-->
        </div><!--ibox-->

        <div class="modal modal-1200 fade" id="copyToPIModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <div class="modal-body pb-0">
                        <h3 class="mb-3 f14">ระบุจำนวนที่ต้องการ Copy To PI สำหรับรายการที่เลือก</h3>

                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-hover f13">
                                <thead>
                                    <tr class="align-middle">
                                        <th>Select</th>
                                        <th>รายการ</th>
                                        <th>รหัสสินค้า</th>
                                        <th>ชือผลิตภัณฑ์</th>
                                        <th>UOM</th>
                                        <th>หน่วยนับ</th>
                                        <th>จำนวนสั่งซื้อ</th>
                                        <th>คงเหลือ</th>
                                        <th>ระบุจำนวนสินค้าที่ต้องการใน PI</th>
                                    </tr>
                                </thead>
                                <tbody id="copyToPI">

                                </tbody>
                            </table>
                        </div><!--table-responsive-->
                    </div><!--modal-body-->

                    <div class="modal-footer center mt-4">
                        <button class="btn btn-md btn-primary mw-150" type="button" onclick="copyToProformaInvoice()"><i class="fa fa-check"></i> ยืนยัน</button>
                        <button class="btn btn-md btn-danger mw-150" type="button" data-dismiss="modal"><i class="fa fa-times"></i> ยกเลิก</button>
                    </div>

                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </div><!--modal-->

        <div class="modal modal-800 fade" id="cancelModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <div class="modal-header">
                        <h3>ยกเลิกใบ Sale Confirmation </h3>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <div class="attachment-box">

                                <div class="col-xl-10 m-auto">

                                    <form id="formSearchConsignment"  autocomplete="off" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เหตุผลที่ยกเลิก</label> <textarea name="sa_cancel_reason" id="sa_cancel_reason" class="form-control" autocomplete="off"></textarea>
                                                </div>
                                            </div>

                                        </div><!--row-->

                                    </form>

                                </div><!--col-xl-6-->


                        </div>
                    </div><!--modal-body-->

                    <div class="modal-footer center mt-4">
                        <button class="btn btn-gray btn-lg" type="button" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            ปิด
                        </button>
                        <button class="btn btn-primary btn-lg" type="button" onclick="cancelSaleConfirmation()">
                            <i class="fa fa-check-circle-o"></i>
                            ยืนยัน
                        </button>
                    </div>

                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </div><!--modal-->
    </form>

    <div class="modal modal-800 fade" id="createModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                <div class="modal-header">
                    <h3>สร้างใบ Sale Confirmation</h3>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <div class="attachment-box">

                            <div class="col-xl-10 m-auto">

                                <form id="formSearchConsignment"  autocomplete="off" enctype="multipart/form-data">
                                    <div class="row">
                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="create_order_number" id="create_order_number" list="create-order-data-list" value="" autocomplete="off">
                                                    <i class="fa fa-search"></i>
                                                    <datalist id="create-order-data-list">

                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($orderList as $item)
                                                        @if (!empty($item->order_number))
                                                        @if (empty($item->prepare_order_number))
                                                        <option value="{{ $item->order_number }}">{{ $item->order_number }}</option>
                                                        @endif
                                                        @endif
                                                        @endforeach

                                                    </datalist>
                                                    <i class="fa fa-search"></i>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">วันที่ขออนุมัติ</label>
                                                <div class="input-icon" id="html_create_sale_confirm_date">
                                                    <div id="mount_create_sale_confirm_date"></div>
                                                    {{-- <input type="text" class="form-control date" name="create_sale_confirm_date" id="create_sale_confirm_date" placeholder="" value="">
                                                    <i class="fa fa-calendar"></i> --}}
                                                    {{-- <datepicker-th
                                                        style="width: 100%"
                                                        class="form-control md:tw-mb-0 tw-mb-2"
                                                        name="create_sale_confirm_date"
                                                        id="create_sale_confirm_date"
                                                        placeholder=""
                                                        value=""
                                                        format="{{ trans("date.js-format") }}"> --}}
                                                </div>
                                            </div><!--form-group-->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">เลขที่บันทึกขออนุมัติหลักการขาย</label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="create_sale_confirm_document_no" id="create_sale_confirm_document_no" placeholder="" value="" autocomplete="off">
                                                </div>
                                            </div><!--form-group-->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">ผู้อนุมัติ</label>
                                                {{-- <div class="input-icon">
                                                    <input type="text" class="form-control" name="create_approver_name" id="create_approver_name" list="approver-data-list" value="" onchange="selectApprover()" autocomplete="off">
                                                    <i class="fa fa-search"></i>
                                                    <datalist id="approver-data-list">

                                                        <option value=""> &nbsp; </option>
                                                        @foreach ($approverList as $item)
                                                        <option value="{{ $item->approver_name }}">{{ $item->approver_name }}</option>
                                                        @endforeach

                                                    </datalist>
                                                    <i class="fa fa-search"></i>

                                                    <input type="hidden" name="create_sale_confirm_by" id="create_sale_confirm_by" placeholder="" value="" autocomplete="off">
                                                </div> --}}

                                                <select class="custom-select" name="create_approver_name" id="create_approver_name" onchange="selectApprover()" autocomplete="off">
                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($approverList as $item)
                                                    <option value="{{ $item->approver_name }}">{{ $item->approver_name }}</option>
                                                    @endforeach
                                                </select>

                                                <input type="hidden" name="create_sale_confirm_by" id="create_sale_confirm_by" placeholder="" value="" autocomplete="off">
                                            </div>
                                        </div>

                                    </div><!--row-->

                                </form>

                            </div><!--col-xl-6-->


                    </div>
                </div><!--modal-body-->

                <div class="modal-footer center mt-4">
                    <button class="btn btn-danger btn-md" type="button" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        ปิด
                    </button>
                    <button class="btn btn-md btn-success" type="button" id="buttonCreateModal" onclick="createSaleConfirmation()">
                        <i class="fa fa-plus"></i> สร้าง
                    </button>
                </div>

            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal-->

@endsection

@section('scripts')

    @include('om/_scripts/attachment')

    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
    <!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        // $('.date').datepicker();

        window.onload = setDefaultInput(1);

        $('.custom-select').select2({width: "100%"});

        // const dateNow   = new Date(Date.now()).toLocaleString().split(' ')[0];
        // const dateObj   = new Date(getDate);
        // const month	    = String(dateObj.getDate()).padStart(2, '0');
        // const day 	    = String(dateObj.getMonth()).padStart(2, '0');
        // const year	    = dateObj.getFullYear();
        // const dateNow   = day + '/' + month + '/' + year;

        var dOnload           = new Date();
        var dayNowOnload      = d.getDate();
        var monthNowOnload    = ("0"+(d.getMonth()+1)).slice(-2);
        var yearNowOnload     = d.getFullYear();
        let dateNowOnload     = dayNow + "/" + monthNow + "/" + yearNow;

        generateSaleConfirmDate(dateNowOnload);

        $searchSaNumber     = $('#prepare_order_number').val();
        $searchOrderNumber  = $('#order_number').val();

        if ($searchSaNumber != '' || $searchOrderNumber != '') {
            searchSaleConfirmation();
        }


    });

</script>

<script>

    let customerList        = {!! json_encode($customerList) !!};
    let currencyList        = {!! json_encode($currency) !!};
    let approverList        = {!! json_encode($approverList) !!};
    let saList              = {!! json_encode($saList) !!};
    let taxCode             = {!! json_encode($taxCode) !!};
    let sequenceEcoms       = {!! json_encode($sequenceEcoms) !!};
    let uomList             = {!! json_encode($uomList) !!};
    let uomConversionsList  = {!! json_encode($uomConversionsList) !!};
    let priceList           = {!! json_encode($priceList) !!};
    let priceListLine       = {!! json_encode($priceListLine) !!};
    let itemWeight          = {!! json_encode($itemWeight) !!};
    var orderList           = @json($orderList);
    var customerOrderList   = @json($customerOrderList);
    var termList            = @json($terms);
    var taxList             = [];
    var resultAmount        = 0.00;
    var countPi             = 0;
    var stepEvent           = '';
    var priceListID         = 0;
    var previous            = '';

    var d           = new Date();
    var dayNow      = ("0"+(d.getDate())).slice(-2);
    // var dayNow      = d.getDate();
    var monthNow    = ("0"+(d.getMonth()+1)).slice(-2);
    var yearNow     = d.getFullYear();
    let dateNow = dayNow + "/" + monthNow + "/" + yearNow;



    function checkCreate()
    {
        if (stepEvent == 'search') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณากดเคลียร์ข้อมูลก่อนดำเนินการ',
                showConfirmButton: true
            });
        }else{
            $('#createModal').modal('show');
        }
    }

    function createSaleConfirmation()
    {
        var saleConfirmDate         = $('#create_sale_confirm_date').val();
        var saleConfirmDocumentNo   = $('#create_sale_confirm_document_no').val();
        var saleConfirmBy           = $('#create_sale_confirm_by').val();

        if (saleConfirmDate == '' || saleConfirmDocumentNo == '' || saleConfirmBy == '') {
            Swal.fire({
                title: 'ไม่สามารถทำรายการได้',
                text: 'กรุณาระบุข้อมูลให้ครบ',
                icon: 'warning'
            });
        }else{
            stepEvent = 'create';

            // $('#sa_date').val(saleConfirmDate);
            // $('#show_sa_date').val(dateNow);
            $("#sa_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dateNow);
            // generateSaDate(dateNow, false);
            // $('#order_date').val(dateNow);
            // $('#show_order_date').val(dateNow);
            // generateOrderDate(dateNow, false);
            $("#order_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dateNow);
            $('#sale_confirm_date').val(saleConfirmDate);
            $('#sale_confirm_document_no').val(saleConfirmDocumentNo);
            $('#sale_confirm_by').val(saleConfirmBy);
            $('#sale_confirm_flag').val('Y');

            setDefaultInput(0);
            setSelectValue(0);

            $('.check-create').select2({disabled: 'disabled'});
            $('#createModal').modal('hide');

            $('#prepare_order_number').prop('readonly', true);
            $('#order_number').prop('readonly', true);

            $('#price_list_id').html('');
            previous = '';
        }
    }

    async function searchSaleConfirmation()
    {
        var saNumber        = $('#prepare_order_number').val();
        var orderNumber     = $('#order_number').val();
        var customerNumber  = $('#customer_number').val();

        if (stepEvent == 'create') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณากดเคลียร์ข้อมูลก่อนดำเนินการ',
                showConfirmButton: true
            });
        }else if(saNumber == '' && orderNumber == '' && customerNumber == ''){
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกอย่างน้อย 1 รายการ',
                showConfirmButton: true
            });
        }else{
            stepEvent = 'search';

            // swal.showLoading();

            const formData = new FormData(document.getElementById("formSaleConfirmation"));
            formData.append('_token','{{ csrf_token() }}');

            await $.each(fileChoose,async function(index, file) {
            if(typeof file !== "undefined")
                await formData.append('attachment[]', file);
            });

            $.ajax({
                url         : '{{ url("om/ajax/sale-confirmation/search") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    // console.log(res);
                    var data = res.data;
                    var html = '';
                    var orderList = data.data;
                    if(data.status == 'success'){

                        resultAmount = res.data.resultTotalAmount;

                        var shipSitesList = res.data.shipSitesList;
                        var html = '';
                        html += '<option value=""> &nbsp; </option>';
                        $.each(shipSitesList, function(key,val){
                            html += '<option  value="'+val.ship_to_site_id+'">'+val.ship_to_site_name+'</option>';
                        });
                        $('#ship_to_site_id').html(html).trigger('change');

                        if(orderList.sa_date == '' || orderList.sa_date == null){
                            // var date = new Date();
                            // var month = date.getMonth()+1;
                            // var day = date.getDate();
                            orderList.sa_date = dateNow;
                        }


                        $('#order_header_id').val(orderList.order_header_id);
                        $('#sa_status').val(orderList.sa_status);

                        if ($('#prepare_order_number').val() == '') {
                            $('#prepare_order_number').val(orderList.prepare_order_number);
                        }
                        if ($('#sa_date').val() == '') {
                            // $('#sa_date').val(orderList.sa_date);
                            // $('#show_sa_date').val(orderList.sa_date);
                            $("#sa_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", orderList.sa_date);
                            if (orderList.sa_status == 'Confirm') {
                                $('#sa_date').prop('readonly', true);
                            } else {
                                $('#sa_date').prop('readonly', false);
                            }
                        }
                        if ($('#order_number').val() == '') {
                            $('#order_number').val(orderList.order_number);
                        }
                        if ($('#order_date').val() == '') {
                            // $('#order_date').val(orderList.order_date);
                            // $('#show_order_date').val(orderList.order_date);
                            $("#order_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", orderList.order_date);
                            if (orderList.sa_status == 'Confirm') {
                                $('#order_date').prop('readonly', true);
                            } else {
                                $('#order_date').prop('readonly', false);
                            }
                        }

                        $('#cust_po_number').val(orderList.cust_po_number);

                        if ($('#customer_id').val() == '') {
                            $('#customer_id').val(orderList.customer_id);
                        }
                        if ($('#customer_number').val() == '') {
                            $('#customer_number').val(orderList.customer_number);
                        }
                        if ($('#customer_name').val() == '') {
                            $('#customer_name').val(orderList.customer_name);
                        }

                        if ($.trim(orderList.order_type_id) <= 0) {
                            $('#order_type_id').val('1024').trigger('change');
                        }else{
                            $('#order_type_id').val(orderList.order_type_id).trigger('change');
                        }

                        $('#currency_name').val(orderList.currency_name);
                        $('#currency').val(orderList.currency).trigger('change');

                        if ($('#customer_address').val() == '') {
                            $('#customer_address').val(orderList.customer_address);
                        }

                        if (orderList.source_system == 'E-COMMERCE' || orderList.source_system == 'E-commerce') {
                            orderList.source_system = 'E-Commerce';
                        }

                        $('#term_id').val(orderList.term_id);
                        $('#term_name').val(orderList.term_name).trigger('change');
                        $('#term_description').val(orderList.term_description);
                        $('#payment_type_code').val(orderList.payment_type_code).trigger('change');
                        $('#vat_code').val(orderList.vat_code).trigger('change');
                        $('#payment_method_code').val(orderList.payment_method_code).trigger('change');
                        $('#remark').val(orderList.remark);
                        $('#bill_to_site_id').val(orderList.bill_to_site_id);
                        $('#bill_to_site_name').val(orderList.bill_to_site_name);
                        $('#ship_to_site_id').val(orderList.ship_to_site_id).trigger('change');
                        $('#incoterms_code').val(orderList.incoterms_code).trigger('change');
                        $('#port_of_loading').val(orderList.port_of_loading);
                        $('#transport_type_code').val(orderList.transport_type_code).trigger('change');
                        $('#transport_detail').val(orderList.transport_detail);
                        $('#port_of_discharge').val(orderList.port_of_discharge);
                        $('#shipment_condition').val(orderList.shipment_condition);
                        $('#shipping_marks').val(orderList.shipping_marks);
                        $('#source_system').val(orderList.source_system).trigger('change');
                        $('#sale_confirm_date').val(orderList.sale_confirm_date);
                        $('#sale_confirm_document_no').val(orderList.sale_confirm_document_no);
                        $('#sale_confirm_by').val(orderList.sale_confirm_by);
                        $('#sale_confirm_flag').val(orderList.sale_confirm_flag);

                        // $('#order_number').attr("placeholder", "(ข้อมูลคัดลอก)");

                        var htmlPriceList   = '';
                        var selectPriceList = '';
                        var price_list_id   = $.trim(orderList.price_list_id) != '' ? orderList.price_list_id : orderList.customer_price_list_id;
                        previous = price_list_id;
                        htmlPriceList += '<option value=""> &nbsp; </option>';
                        $.each(priceList, function(key,val){
                            if (orderList.currency == val.currency_code) {
                                if (val.list_header_id == price_list_id) {
                                    selectPriceList = 'selected';
                                }else{
                                    selectPriceList = '';
                                }
                                htmlPriceList += '<option '+selectPriceList+' value="'+val.list_header_id+'">'+val.name+'</option>';
                            }
                        });
                        $('#price_list_id').html(htmlPriceList).trigger('change');

                        if (orderList.sa_status == 'Confirm') {
                            $('#buttonCreateLine').prop('disabled', true);
                            $('#buttonCopyToPi').prop('disabled', false);
                        }else if(orderList.sa_status == 'Cancelled'){
                            $('#buttonCreateLine').prop('disabled', true);
                            $('#buttonCopyToPi').prop('disabled', true);
                        }else{
                            $('#buttonCreateLine').prop('disabled', false);
                            $('#buttonCopyToPi').prop('disabled', true);
                        }

                        // ORDER LINES
                        var orderLine       = res.data.orderLine;
                        var htmlLine        = '';
                        var htmlCopyToPI    = '';
                        var num             = 1;
                        var checkSelectVat  = '';
                        var piBalance       = 0;
                        countPi             = 0;
                        var ckPiBalance     = '';
                        var ckPiSelect      = '';

                        numberLine = 1;

                        var saStatus = $('#sa_status').val();

                        if (saStatus == 'Draft') {
                            $.each(orderLine, function(key,val){
                                htmlLine += '<tr id="order_line_roll_'+ val.order_line_id +'" class="del_all">';
                                htmlLine += '    <td><span id="number_line_'+ val.order_line_id +'">'+ numberLine +'</span> <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+ val.order_line_id +'" value="'+ val.order_line_id +'" ></td>';

                                // SEQUENCE ECOM
                                htmlLine += '    <td>';
                                htmlLine += '        <div class="form-group">';
                                htmlLine += '            <div class="input-icon" style="width: 180px;">';
                                htmlLine += '                <input type="hidden" readonly placeholder="" name="item_id['+ val.order_line_id +']" id="item_id_'+ val.order_line_id +'" value="'+val.item_id+'">';
                                htmlLine += '               <input type="text" class="form-control" name="item_code['+ val.order_line_id +']" id="item_code_'+ val.order_line_id +'" list="sequence-list-'+ val.order_line_id +'" onchange="selectItemsLines('+ val.order_line_id +');" value="'+val.item_code+'" autocomplete="off">';
                                htmlLine += '               <i class="fa fa-search"></i>';
                                htmlLine += '               <datalist id="sequence-list-'+ val.order_line_id +'">';

                                $.each(sequenceEcoms, function(key,valSequence){
                                    if (valSequence.item_code != '' && valSequence.list_header_id == price_list_id) {
                                        htmlLine += '                   <option value="'+valSequence.item_code+'">'+valSequence.ecom_item_description+'</option>';
                                    }
                                });

                                htmlLine += '                </datalist>';
                                htmlLine += '                <i class="fa fa-search"></i>';
                                htmlLine += '            </div>';
                                htmlLine += '        </div>';
                                htmlLine += '    </td>';
                                // SEQUENCE ECOM

                                htmlLine += '    <td class="text-left"> <span id="text_description_'+ val.order_line_id +'"> '+val.item_description+' </span> <input type="hidden" name="item_description['+ val.order_line_id +']" id="item_description_'+ val.order_line_id +'" value="'+val.item_description+'"> </td>';

                                // UOM
                                htmlLine += '    <td>';
                                htmlLine += '        <div class="form-group">';
                                htmlLine += '            <div class="input-icon">';
                                htmlLine += '                <input type="hidden" readonly placeholder="" name="uom_id['+ val.order_line_id +']" id="uom_id_'+ val.order_line_id +'" value="'+val.uom_id+'">';
                                htmlLine += '               <input type="text" class="form-control" name="uom_code['+ val.order_line_id +']" id="uom_code_'+ val.order_line_id +'" list="uom-list-'+ val.order_line_id +'" onchange="selectUomLines('+ val.order_line_id +');" value="'+val.uom_code+'" autocomplete="off">';
                                htmlLine += '               <i class="fa fa-search"></i>';
                                htmlLine += '               <datalist id="uom-list-'+ val.order_line_id +'">';

                                $.each(uomList, function(key,valUom){
                                    if (valUom.uom_code != '') {
                                        htmlLine += '                   <option value="'+valUom.uom_code+'">'+valUom.description+'</option>';
                                    }
                                });

                                htmlLine += '                </datalist>';
                                htmlLine += '                <i class="fa fa-search"></i>';
                                htmlLine += '            </div>';
                                htmlLine += '        </div>';
                                htmlLine += '    </td>';
                                // UOM

                                htmlLine += '    <td> <span id="text_uom_'+ val.order_line_id +'"> '+val.uom+' </span> <input type="hidden" name="uom['+ val.order_line_id +']" id="uom_'+ val.order_line_id +'" value="'+val.uom+'"> </td>';
                                htmlLine += '    <td> <input type="text" class="form-control" name="order_quantity['+ val.order_line_id +']" id="order_quantity_'+ val.order_line_id +'" value="'+ val.order_quantity +'" onkeyup="checkInputAmount('+ val.order_line_id +')" onkeypress="return isNumber(this, event)" autocomplete="off"></td>';
                                htmlLine += '    <td> '+numberFormat(val.order_pi_quantity)+' </td>';
                                htmlLine += '    <td class="text-right"> <input type="text" class="form-control" id="text_unit_price_'+ val.order_line_id +'" value="'+numberFormat(val.unit_price)+'" onchange="changeUnitPrice('+ val.order_line_id +')" onkeypress="return isNumber(this, event)" automcomplete="off"> <input type="hidden" name="unit_price['+ val.order_line_id +']" id="unit_price_'+ val.order_line_id +'" value="'+val.unit_price+'" ></td>';
                                htmlLine += '    <td class="text-right"><span id="line_amount_'+ val.order_line_id +'"> '+numberFormat(val.amount)+' </span><input type="hidden" name="amount['+ val.order_line_id +']" id="amount_'+ val.order_line_id +'" value="'+val.amount+'" ></td>';
                                htmlLine += '    <td>';
                                htmlLine += '        <select class="custom-select" name="sub_vat['+ val.order_line_id +']" id="sub_vat_'+ val.order_line_id +'" onchange="selectLineVat('+ val.order_line_id +')">';
                                htmlLine += '            <option value=""> &nbsp; </option>';

                                $.each(taxCode, function(key,valVat){
                                    if(val.vat_code == null && valVat.tax_rate_code == orderList.vat_code){
                                        checkSelectVat = 'selected';
                                    }else if (valVat.tax_rate_code == val.vat_code) {
                                        checkSelectVat = 'selected';
                                    }else{
                                        checkSelectVat = '';
                                    }
                                    htmlLine += '            <option '+ checkSelectVat +' value="'+ valVat.tax_rate_code +'">'+ valVat.tax_rate_code +'</option>';
                                });

                                htmlLine += '        </select>';
                                htmlLine += '    </td>';
                                htmlLine += '    <td class="text-right"><span id="line_tax_amount_'+ val.order_line_id +'">'+numberFormat(val.tax_amount)+'</span><input type="hidden" name="tax_amount['+ val.order_line_id +']" id="tax_amount_'+ val.order_line_id +'" value="'+val.tax_amount+'" ></td>';
                                htmlLine += '    <td class="text-right"><span id="line_total_amount_'+ val.order_line_id +'">'+numberFormat(val.total_amount)+'</span><input type="hidden" name="total_amount['+ val.order_line_id +']" id="total_amount_'+ val.order_line_id +'" value="'+val.total_amount+'" ></td>';
                                htmlLine += '    <td class="text-right">';
                                // htmlLine += '       <span id="text_net_'+ val.order_line_id +'">'+numberFormat(val.net_weight)+' </span>';
                                htmlLine += '       <input type="text" class="form-control" name="net['+val.order_line_id+']" id="net_'+ val.order_line_id +'" value="'+$.trim(numberFormat2(val.net_weight))+'" onchange="weightChange('+val.order_line_id+')"  onkeypress="return isNumberUnlimit(this, event)">';
                                htmlLine += '       <input type="hidden" name="weight_id['+val.order_line_id+']" id="weight_id_'+val.order_line_id+'" value="'+val.weight_id+'" >';
                                htmlLine += '    </td>';
                                // htmlLine += '    <td class="text-right"><span id="text_gross_'+ val.order_line_id +'">'+numberFormat(val.net_gross)+' </span> </td>';
                                htmlLine += '    <td class="text-right"><input type="text" class="form-control" name="gross['+val.order_line_id+']" id="gross_'+ val.order_line_id +'" value="'+$.trim(numberFormat2(val.net_gross))+'" onchange="weightChange('+val.order_line_id+')"  onkeypress="return isNumberUnlimit(this, event)"> </td>';
                                htmlLine += '    <td class="text-right"><span id="text_total_net_'+ val.order_line_id +'">'+numberFormat(val.total_net_weight)+' </span> <input type="hidden" name="total_net_weight['+val.order_line_id+']" id="total_net_weight_'+val.order_line_id+'" value="'+val.total_net_weight+'"> </td>';
                                htmlLine += '    <td class="text-right"><span id="text_total_gross_'+ val.order_line_id +'">'+numberFormat(val.total_net_gross)+' </span> <input type="hidden" name="total_net_gross['+val.order_line_id+']" id="total_net_gross_'+val.order_line_id+'" value="'+val.total_net_gross+'"> </td>';
                                htmlLine += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteLines(`order_line_roll_`, '+val.order_line_id+')"></a></td>';
                                htmlLine += '</tr>';

                                numberLine += 1;
                            });

                        }else{

                            $.each(orderLine, function(key,val){
                                htmlLine += '<tr id="order_line_roll_'+ val.order_line_id +'" class="del_all">';
                                // htmlLine += '    <td>';
                                // htmlLine += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" class="check" name="select_order_line['+val.order_line_id+']"></label></div>';
                                // htmlLine += '    </td>';
                                htmlLine += '    <td>'+ num +' <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+val.order_line_id+'" value="'+val.order_line_id+'" ></td>';
                                htmlLine += '    <td>'+val.item_code+'</td>';
                                htmlLine += '    <td class="text-left">'+val.item_description+'</td>';
                                htmlLine += '    <td>'+val.uom_code+'</td>';
                                htmlLine += '    <td>'+val.uom+'</td>';
                                htmlLine += '    <td>'+numberFormat(val.order_quantity)+'<input type="hidden" name="order_quantity['+ val.order_line_id +']" id="order_quantity_'+ val.order_line_id +'" value="'+numberFormat(val.order_quantity)+'" ></td>';
                                htmlLine += '    <td>'+numberFormat(val.order_pi_quantity)+'</td>';
                                htmlLine += '    <td class="text-right">'+numberFormat(val.unit_price)+'<input type="hidden" name="unit_price['+ val.order_line_id +']" id="unit_price_'+ val.order_line_id +'" value="'+val.unit_price+'" ></td>';
                                htmlLine += '    <td class="text-right"><span id="line_amount_'+ val.order_line_id +'">'+numberFormat(val.amount)+'<input type="hidden" name="amount['+ val.order_line_id +']" id="amount_'+ val.order_line_id +'" value="'+val.amount+'" ></td>';
                                htmlLine += '    <td>';
                                htmlLine += '        <select class="custom-select vat-custom" name="sub_vat['+ val.order_line_id +']" id="sub_vat_'+ val.order_line_id +'" onchange="selectLineVat('+ val.order_line_id +')">';
                                htmlLine += '            <option value=""> &nbsp; </option>';

                                $.each(taxCode, function(key,valVat){
                                    if(val.vat_code == null && valVat.tax_rate_code == orderList.vat_code){
                                        checkSelectVat = 'selected';
                                    }else if (valVat.tax_rate_code == val.vat_code) {
                                        checkSelectVat = 'selected';
                                    }else{
                                        checkSelectVat = '';
                                    }
                                    htmlLine += '            <option '+ checkSelectVat +' value="'+ valVat.tax_rate_code +'">'+ valVat.tax_rate_code +'</option>';
                                });

                                htmlLine += '        </select>';
                                htmlLine += '    </td>';
                                htmlLine += '    <td class="text-right"><span id="line_tax_amount_'+ val.order_line_id +'">'+numberFormat(val.tax_amount)+'</span><input type="hidden" name="tax_amount['+ val.order_line_id +']" id="tax_amount_'+ val.order_line_id +'" value="'+val.tax_amount+'" ></td>';
                                htmlLine += '    <td class="text-right"><span id="line_total_amount_'+ val.order_line_id +'">'+numberFormat(val.total_amount)+'</span><input type="hidden" name="total_amount['+ val.order_line_id +']" id="total_amount_'+ val.order_line_id +'" value="'+val.total_amount+'" ></td>';
                                htmlLine += '    <td class="text-right">'+numberFormat(val.net_weight)+' <input type="hidden" name="weight_id['+val.order_line_id+']" id="weight_id_'+val.order_line_id+'" value="'+val.weight_id+'" ></td>';
                                htmlLine += '    <td class="text-right">'+numberFormat(val.net_gross)+'</td>';
                                htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_weight)+' <input type="hidden" name="total_net_weight['+val.order_line_id+']" id="total_net_weight_'+val.order_line_id+'" value="'+val.total_net_weight+'"> </td>';
                                htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_gross)+' <input type="hidden" name="total_net_gross['+val.order_line_id+']" id="total_net_gross_'+val.order_line_id+'" value="'+val.total_net_gross+'"> </td>';
                                htmlLine += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteLines(`order_line_roll_`, '+val.order_line_id+')"></a></td>';
                                htmlLine += '</tr>';

                                // COPY TO PI
                                piBalance = parseFloat(val.order_quantity) - parseFloat(val.order_pi_quantity);

                                if (piBalance <= 0) {
                                    ckPiBalance = 'readonly';
                                    ckPiSelect  = 'disabled';
                                }else{
                                    ckPiBalance = '';
                                    ckPiSelect  = '';
                                }

                                htmlCopyToPI += '<tr class="align-middle">';
                                htmlCopyToPI += '    <td>';
                                htmlCopyToPI += '        <div class="i-checks wihtout-text m-auto '+ckPiSelect+'"><label class="m-0"><input type="checkbox" class="check check-line" name="select_copy[]" value="'+val.order_line_id+'"></label></div>';
                                htmlCopyToPI += '    </td>';
                                htmlCopyToPI += '    <td>'+ num +'</td>';
                                htmlCopyToPI += '    <td>'+val.item_code+' <input type="hidden" name="item_code['+val.order_line_id+']" id="item_code_'+val.order_line_id+'" value="'+val.item_code+'" ></td>';
                                htmlCopyToPI += '    <td class="text-left">'+val.item_description+'</td>';
                                htmlCopyToPI += '    <td>'+val.uom_code+'</td>';
                                htmlCopyToPI += '    <td>'+val.uom+'</td>';
                                htmlCopyToPI += '    <td>'+numberFormat(val.order_quantity)+' <input type="hidden" id="quantity_'+val.order_line_id+'" value="'+val.order_quantity+'" > </td>';
                                htmlCopyToPI += '    <td>'+numberFormat(piBalance)+' <input type="hidden" id="pi_balance_'+val.order_line_id+'" value="'+piBalance+'" > </td>';
                                htmlCopyToPI += '    <td><input type="text" '+ckPiBalance+' class="form-control text-right f13" name="pi_amount['+val.order_line_id+']" id="pi_amount_'+val.order_line_id+'" placeholder="0" onkeyup="checkPiBalance('+val.order_line_id+')" onkeypress="return isNumber(this, event)"  autocomplete="off"></td>';
                                htmlCopyToPI += '</tr>';

                                num++;
                                countPi = countPi + val.order_pi_quantity;
                            });
                        }

                        var resultWeights = res.data.resultWeights;
                        htmlLineWeight = '';
                        htmlLineWeight += '<tr>';
                        htmlLineWeight += '    <td class="text-right black" colspan="14"><strong>Total Weight</strong></td>';
                        htmlLineWeight += '    <td class="text-right black"><strong>'+ numberFormat(resultWeights.result_net_weight) +'</strong></td>';
                        htmlLineWeight += '    <td class="text-right black"><strong>'+ numberFormat(resultWeights.result_gross_weight) +'</strong></td>';
                        htmlLineWeight += '</tr>';

                        $('#orderCreateLines').html(htmlLine);
                        $('#orderLines').html(htmlLineWeight);
                        $('#copyToPI').html(htmlCopyToPI);

                        $('#resultSubtotal').html(numberFormat(resultWeights.result_sub_total));
                        $('#resultTax').html(numberFormat(resultWeights.result_tax));
                        $('#resultTotal').html(numberFormat(resultWeights.result_total));

                        $('#order_sub_total').val(resultWeights.result_sub_total);
                        $('#order_tax').val(resultWeights.result_tax);
                        $('#order_total').val(resultWeights.result_total);

                        setAttachment(res.data.attachmentFile);

                        $('.check').iCheck({
                            checkboxClass: 'icheckbox_square-green'
                        });

                        if (saStatus == 'Draft') {
                            setDefaultInput(0);

                            $('#prepare_order_number').prop('readonly', true);
                            $('#order_number').prop('readonly', true);
                            $('#customer_number').prop('readonly', true);
                            $('#currency').prop('readonly', true);

                        }else{
                            setDefaultInput(1);
                            $('#prepare_order_number').prop('readonly', true);
                            $('#order_number').prop('readonly', true);
                            $('#customer_number').prop('readonly', true);
                            $('.vat-custom').select2({disabled: true});
                        }

                        $('.custom-select').select2({width: "100%"});

                        selectTerm();


                        // Swal.close();

                    }else{

                        resetSaleConfirmation();
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

    async function updateSaleConfirmation()
    {
        var saNumber = $('#prepare_order_number').val();

        var shipmentBy = $('#transport_type_code').val();
        var shipmentDetail = $('#transport_detail').val();

        if (saNumber == '' && stepEvent != 'create') {
            Swal.fire({
                icon: 'warning',
                text: 'ไม่พบข้อมูลสำหรับบันทึก',
                showConfirmButton: true
            });
            return false;
        }else if($('#sa_status').val() == 'Confirm'){
            Swal.fire({
                icon: 'warning',
                text: 'รายการนี้ถูกยืนยันไปแล้ว ไม่สามารถแก้ไข บันทึกได้',
                showConfirmButton: true
            });
            return false;
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
                text: 'กรุณาเลือก INCOTERMS 2010',
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
        }else if ($("input[name='order_line_manage[]']").length <= 0) {
            Swal.fire({
                icon: 'warning',
                text: 'ต้องมีรายการสินค้าอย่างน้อย 1 รายการ',
                showConfirmButton: true
            });
            return false;
        }else{
            Swal.fire({
                title: 'แจ้งเตือน',
                text: "บันทึกใบ Sale confirmation หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
            }).then( async (result) => {
                if (result.isConfirmed) {

                    const formData = new FormData(document.getElementById("formSaleConfirmation"));
                    formData.append('_token','{{ csrf_token() }}');

                    await $.each(fileChoose,async function(index, file) {
                    if(typeof file !== "undefined")
                        await formData.append('attachment[]', file);
                    });

                    $.ajax({
                        url         : '{{ url("om/ajax/sale-confirmation/update-sale-confirmation") }}',
                        type        : 'post',
                        data        : formData,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        success     : function(res){
                            // console.log(res);
                            var data = res.data;
                            var html = '';
                            var orderList = data.data;
                            if(data.status == 'success'){

                                if (stepEvent != 'create') {
                                    $('#prepare_order_number').val(res.data.saNumber);
                                    stepEvent = 'update';
                                }


                                $('#order_header_id').val(res.data.orderHeaderID);

                                setAttachment(res.data.attachmentFile);
                                $('#prepare_order_number').val(res.data.saNumber);

                                saList = res.data.newSaList;
                                var orderLine = res.data.orderLine;

                                $('#buttonCopyToPi').prop('disabled', false);

                                var htmlLine = '';
                                var htmlCopyToPI = '';
                                numberLine = 1;
                                var checkSelectVat = '';

                                var saStatus = $('#sa_status').val();

                                if (saStatus == 'Draft') {
                                    $.each(orderLine, function(key,val){
                                        htmlLine += '<tr id="order_line_roll_'+ val.order_line_id +'" class="del_all">';
                                        htmlLine += '    <td><span id="number_line_'+ val.order_line_id +'">'+ numberLine +'</span> <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+ val.order_line_id +'" value="'+ val.order_line_id +'" ></td>';

                                        // SEQUENCE ECOM
                                        htmlLine += '    <td>';
                                        htmlLine += '        <div class="form-group">';
                                        htmlLine += '            <div class="input-icon" style="width: 180px;">';
                                        htmlLine += '                <input type="hidden" readonly placeholder="" name="item_id['+ val.order_line_id +']" id="item_id_'+ val.order_line_id +'" value="'+val.item_id+'">';
                                        htmlLine += '               <input type="text" class="form-control" name="item_code['+ val.order_line_id +']" id="item_code_'+ val.order_line_id +'" list="sequence-list-'+ val.order_line_id +'" onchange="selectItemsLines('+ val.order_line_id +');" value="'+val.item_code+'" autocomplete="off">';
                                        htmlLine += '               <i class="fa fa-search"></i>';
                                        htmlLine += '               <datalist id="sequence-list-'+ val.order_line_id +'">';

                                        $.each(sequenceEcoms, function(key,valSequence){
                                            if (valSequence.item_code != '') {
                                                htmlLine += '                   <option value="'+valSequence.item_code+'">'+valSequence.ecom_item_description+'</option>';
                                            }
                                        });

                                        htmlLine += '                </datalist>';
                                        htmlLine += '                <i class="fa fa-search"></i>';
                                        htmlLine += '            </div>';
                                        htmlLine += '        </div>';
                                        htmlLine += '    </td>';
                                        // SEQUENCE ECOM

                                        htmlLine += '    <td class="text-left"> <span id="text_description_'+ val.order_line_id +'"> '+val.item_description+' </span> <input type="hidden" name="item_description['+ val.order_line_id +']" id="item_description_'+ val.order_line_id +'" value="'+val.item_description+'"> </td>';

                                        // UOM
                                        htmlLine += '    <td>';
                                        htmlLine += '        <div class="form-group">';
                                        htmlLine += '            <div class="input-icon">';
                                        htmlLine += '                <input type="hidden" readonly placeholder="" name="uom_id['+ val.order_line_id +']" id="uom_id_'+ val.order_line_id +'" value="'+val.uom_id+'">';
                                        htmlLine += '               <input type="text" class="form-control" name="uom_code['+ val.order_line_id +']" id="uom_code_'+ val.order_line_id +'" list="uom-list-'+ val.order_line_id +'" onchange="selectUomLines('+ val.order_line_id +');" value="'+val.uom_code+'" autocomplete="off">';
                                        htmlLine += '               <i class="fa fa-search"></i>';
                                        htmlLine += '               <datalist id="uom-list-'+ val.order_line_id +'">';

                                        $.each(uomList, function(key,valUom){
                                            if (valUom.uom_code != '') {
                                                htmlLine += '                   <option value="'+valUom.uom_code+'">'+valUom.description+'</option>';
                                            }
                                        });

                                        htmlLine += '                </datalist>';
                                        htmlLine += '                <i class="fa fa-search"></i>';
                                        htmlLine += '            </div>';
                                        htmlLine += '        </div>';
                                        htmlLine += '    </td>';
                                        // UOM

                                        htmlLine += '    <td> <span id="text_uom_'+ val.order_line_id +'"> '+val.uom+' </span> <input type="hidden" name="uom['+ val.order_line_id +']" id="uom_'+ val.order_line_id +'" value="'+val.uom+'"> </td>';
                                        htmlLine += '    <td> <input type="text" class="form-control" name="order_quantity['+ val.order_line_id +']" id="order_quantity_'+ val.order_line_id +'" value="'+ val.order_quantity +'" onkeyup="checkInputAmount('+ val.order_line_id +')" onkeypress="return isNumber(this, event)" autocomplete="off"></td>';
                                        htmlLine += '    <td> '+numberFormat(val.order_pi_quantity)+' </td>';
                                        htmlLine += '    <td class="text-right"> <input type="text" class="form-control" id="text_unit_price_'+ val.order_line_id +'" value="'+numberFormat(val.unit_price)+'" onchange="changeUnitPrice('+ val.order_line_id +')" onkeypress="return isNumber(this, event)" automcomplete="off"> <input type="hidden" name="unit_price['+ val.order_line_id +']" id="unit_price_'+ val.order_line_id +'" value="'+ val.unit_price +'" ></td>';
                                        htmlLine += '    <td class="text-right"><span id="line_amount_'+ val.order_line_id +'"> '+numberFormat(val.amount)+' </span><input type="hidden" name="amount['+ val.order_line_id +']" id="amount_'+ val.order_line_id +'" value="'+ val.amount+ '" ></td>';
                                        htmlLine += '    <td>';
                                        htmlLine += '        <select class="custom-select" name="sub_vat['+ val.order_line_id +']" id="sub_vat_'+ val.order_line_id +'" onchange="selectLineVat('+ val.order_line_id +')">';
                                        htmlLine += '            <option value=""> &nbsp; </option>';

                                        $.each(taxCode, function(key,valVat){
                                            if(val.vat_code == null && valVat.tax_rate_code == orderList.vat_code){
                                                checkSelectVat = 'selected';
                                            }else if (valVat.tax_rate_code == val.vat_code) {
                                                checkSelectVat = 'selected';
                                            }else{
                                                checkSelectVat = '';
                                            }
                                            htmlLine += '            <option '+ checkSelectVat +' value="'+ valVat.tax_rate_code +'">'+ valVat.tax_rate_code +'</option>';
                                        });

                                        htmlLine += '        </select>';
                                        htmlLine += '    </td>';
                                        htmlLine += '    <td class="text-right"><span id="line_tax_amount_'+ val.order_line_id +'">'+numberFormat(val.tax_amount)+'</span><input type="hidden" name="tax_amount['+ val.order_line_id +']" id="tax_amount_'+ val.order_line_id +'" value="'+val.tax_amount+'" ></td>';
                                        htmlLine += '    <td class="text-right"><span id="line_total_amount_'+ val.order_line_id +'">'+numberFormat(val.total_amount)+'</span><input type="hidden" name="total_amount['+ val.order_line_id +']" id="total_amount_'+ val.order_line_id +'" value="'+val.total_amount+'" ></td>';
                                        // htmlLine += '    <td class="text-right">'+val.net_weight+' <input type="hidden" name="weight_id['+val.order_line_id+']" id="weight_id_'+val.order_line_id+'" value="'+val.weight_id+'" ></td>';
                                        htmlLine += '    <td class="text-right">';
                                        // htmlLine += '       <span id="text_net_'+ val.order_line_id +'">'+numberFormat(val.net_weight)+' </span>';
                                        htmlLine += '       <input type="text" class="form-control" name="net['+val.order_line_id+']" id="net_'+ val.order_line_id +'" value="'+$.trim(numberFormat2(val.net_weight))+'" onchange="weightChange('+val.order_line_id+')"  onkeypress="return isNumberUnlimit(this, event)">';
                                        htmlLine += '       <input type="hidden" name="weight_id['+val.order_line_id+']" id="weight_id_'+val.order_line_id+'" value="'+val.weight_id+'" >';
                                        htmlLine += '    </td>';
                                        // htmlLine += '    <td class="text-right">'+val.net_gross+'</td>';
                                        htmlLine += '    <td class="text-right"><input type="text" class="form-control" name="gross['+val.order_line_id+']" id="gross_'+ val.order_line_id +'" value="'+$.trim(numberFormat2(val.net_gross))+'" onchange="weightChange('+val.order_line_id+')"  onkeypress="return isNumberUnlimit(this, event)"> </td>';
                                        htmlLine += '    <td class="text-right"><span id="text_total_net_'+ val.order_line_id +'">'+numberFormat(val.total_net_weight)+' </span> <input type="hidden" name="total_net_weight['+val.order_line_id+']" id="total_net_weight_'+val.order_line_id+'" value="'+val.total_net_weight+'"> </td>';
                                        htmlLine += '    <td class="text-right"><span id="text_total_gross_'+ val.order_line_id +'">'+numberFormat(val.total_net_gross)+' </span> <input type="hidden" name="total_net_gross['+val.order_line_id+']" id="total_net_gross_'+val.order_line_id+'" value="'+val.total_net_gross+'"> </td>';
                                        htmlLine += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteLines(`order_line_roll_`, '+val.order_line_id+')"></a></td>';
                                        htmlLine += '</tr>';

                                        numberLine += 1;
                                    });
                                }else{
                                    $.each(orderLine, function(key,val){
                                        htmlLine += '<tr id="order_line_roll_'+ val.order_line_id +'" class="del_all">';
                                        // htmlLine += '    <td>';
                                        // htmlLine += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" class="check" name="select_order_line['+val.order_line_id+']"></label></div>';
                                        // htmlLine += '    </td>';
                                        htmlLine += '    <td>'+ numberLine +' <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+val.order_line_id+'" value="'+val.order_line_id+'" ></td>';
                                        htmlLine += '    <td>'+val.item_code+'</td>';
                                        htmlLine += '    <td class="text-left">'+val.item_description+'</td>';
                                        htmlLine += '    <td>'+val.uom_code+'</td>';
                                        htmlLine += '    <td>'+val.uom+'</td>';
                                        htmlLine += '    <td>'+numberFormat(val.order_quantity)+'<input type="hidden" name="order_quantity['+ val.order_line_id +']" id="order_quantity_'+ val.order_line_id +'" value="'+numberFormat(val.order_quantity)+'" ></td>';
                                        htmlLine += '    <td>'+numberFormat(val.order_pi_quantity)+'</td>';
                                        htmlLine += '    <td class="text-right">'+numberFormat(val.unit_price)+'<input type="hidden" name="unit_price['+ val.order_line_id +']" id="unit_price_'+ val.order_line_id +'" value="'+numberFormat(val.unit_price)+'" ></td>';
                                        htmlLine += '    <td class="text-right"><span id="line_amount_'+ val.order_line_id +'">'+numberFormat(val.amount)+'<input type="hidden" name="amount['+ val.order_line_id +']" id="amount_'+ val.order_line_id +'" value="'+numberFormat(val.amount)+'" ></td>';
                                        htmlLine += '    <td>';
                                        htmlLine += '        <select class="custom-select vat-custom" name="sub_vat['+ val.order_line_id +']" id="sub_vat_'+ val.order_line_id +'" onchange="selectLineVat('+ val.order_line_id +')">';
                                        htmlLine += '            <option value=""> &nbsp; </option>';

                                        $.each(taxCode, function(key,valVat){
                                            if(val.vat_code == null && valVat.tax_rate_code == orderList.vat_code){
                                                checkSelectVat = 'selected';
                                            }else if (valVat.tax_rate_code == val.vat_code) {
                                                checkSelectVat = 'selected';
                                            }else{
                                                checkSelectVat = '';
                                            }
                                            htmlLine += '            <option '+ checkSelectVat +' value="'+ valVat.tax_rate_code +'">'+ valVat.tax_rate_code +'</option>';
                                        });

                                        htmlLine += '        </select>';
                                        htmlLine += '    </td>';
                                        htmlLine += '    <td class="text-right"><span id="line_tax_amount_'+ val.order_line_id +'">'+numberFormat(val.tax_amount)+'</span><input type="hidden" name="tax_amount['+ val.order_line_id +']" id="tax_amount_'+ val.order_line_id +'" value="'+numberFormat(val.tax_amount)+'" ></td>';
                                        htmlLine += '    <td class="text-right"><span id="line_total_amount_'+ val.order_line_id +'">'+numberFormat(val.total_amount)+'</span><input type="hidden" name="total_amount['+ val.order_line_id +']" id="total_amount_'+ val.order_line_id +'" value="'+numberFormat(val.total_amount)+'" ></td>';
                                        htmlLine += '    <td class="text-right">'+val.net_weight+' <input type="hidden" name="weight_id['+val.order_line_id+']" id="weight_id_'+val.order_line_id+'" value="'+val.weight_id+'" ></td>';
                                        htmlLine += '    <td class="text-right">'+val.net_gross+'</td>';
                                        htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_weight)+' <input type="hidden" name="total_net_weight['+val.order_line_id+']" id="total_net_weight_'+val.order_line_id+'" value="'+val.total_net_weight+'"> </td>';
                                        htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_gross)+' <input type="hidden" name="total_net_gross['+val.order_line_id+']" id="total_net_gross_'+val.order_line_id+'" value="'+val.total_net_gross+'"> </td>';
                                        htmlLine += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteLines(`order_line_roll_`, '+val.order_line_id+')"></a></td>';
                                        htmlLine += '</tr>';

                                        // COPY TO PI
                                        piBalance = parseFloat(val.order_quantity) - parseFloat(val.order_pi_quantity);

                                        if (piBalance <= 0) {
                                            ckPiBalance = 'readonly';
                                            ckPiSelect  = 'disabled';
                                        }else{
                                            ckPiBalance = '';
                                            ckPiSelect  = '';
                                        }

                                        htmlCopyToPI += '<tr class="align-middle">';
                                        htmlCopyToPI += '    <td>';
                                        htmlCopyToPI += '        <div class="i-checks wihtout-text m-auto '+ckPiSelect+'"><label class="m-0"><input type="checkbox" class="check check-line" name="select_copy[]" value="'+val.order_line_id+'"></label></div>';
                                        htmlCopyToPI += '    </td>';
                                        htmlCopyToPI += '    <td>'+ numberLine +'</td>';
                                        htmlCopyToPI += '    <td>'+val.item_code+' <input type="hidden" name="item_code['+val.order_line_id+']" id="item_code_'+val.order_line_id+'" value="'+val.item_code+'" ></td>';
                                        htmlCopyToPI += '    <td class="text-left">'+val.item_description+'</td>';
                                        htmlCopyToPI += '    <td>'+val.uom_code+'</td>';
                                        htmlCopyToPI += '    <td>'+val.uom+'</td>';
                                        htmlCopyToPI += '    <td>'+numberFormat(val.order_quantity)+' <input type="hidden" id="quantity_'+val.order_line_id+'" value="'+val.order_quantity+'" > </td>';
                                        htmlCopyToPI += '    <td>'+numberFormat(piBalance)+' <input type="hidden" id="pi_balance_'+val.order_line_id+'" value="'+piBalance+'" > </td>';
                                        htmlCopyToPI += '    <td><input type="text" '+ckPiBalance+' class="form-control text-right f13" name="pi_amount['+val.order_line_id+']" id="pi_amount_'+val.order_line_id+'" placeholder="0" onkeyup="checkPiBalance('+val.order_line_id+')" onkeypress="return isNumber(this, event)"  autocomplete="off"></td>';
                                        htmlCopyToPI += '</tr>';

                                        numberLine++;
                                        countPi = countPi + val.order_pi_quantity;
                                    });
                                }

                                if ($('#sa_status').val() == 'Confirm') {
                                    $('#buttonCopyToPi').prop('disabled', false);

                                    setDefaultInput(1);
                                    $('#prepare_order_number').prop('readonly', true);
                                    $('#order_number').prop('readonly', true);
                                    $('#customer_number').prop('readonly', true);
                                    $('.vat-custom').select2({disabled: true});
                                }else{
                                    $('#buttonCopyToPi').prop('disabled', true);
                                }

                                $('#orderCreateLines').html(htmlLine);
                                $('#copyToPI').html(htmlCopyToPI);

                                $('.check').iCheck({
                                    checkboxClass: 'icheckbox_square-green'
                                });

                                $('.custom-select').select2({width: "100%"});

                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "บันทึกใบ Sale confirmation เรียบร้อยแล้ว",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: "บันทึกใบ Sale confirmation ไม่ได้",
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

    async function confirmSaleConfirmation()
    {
        var saNumber = $('#prepare_order_number').val();
        var shipmentBy = $('#transport_type_code').val();
        var shipmentDetail = $('#transport_detail').val();

        if (saNumber == '' && stepEvent != 'create') {
            Swal.fire({
                icon: 'warning',
                text: 'ไม่พบข้อมูลสำหรับบันทึก',
                showConfirmButton: true
            });
            return false;
        }else if($('#sa_status').val() == 'Confirm'){
            Swal.fire({
                icon: 'warning',
                text: 'รายการนี้ถูกยืนยันไปแล้ว ไม่สามารถแก้ไข ยืนยันได้',
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
        }else if ($("input[name='order_line_manage[]']").length <= 0) {
            Swal.fire({
                icon: 'warning',
                text: 'ต้องมีรายการสินค้าอย่างน้อย 1 รายการ',
                showConfirmButton: true
            });
            return false;
        }else{
            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ยืนยันใบ Sale confirmation หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then( async (result) => {
                if (result.isConfirmed) {

                    $('#sa_status').val('Confirm');

                    const formData = new FormData(document.getElementById("formSaleConfirmation"));
                    formData.append('_token','{{ csrf_token() }}');

                    await $.each(fileChoose,async function(index, file) {
                    if(typeof file !== "undefined")
                        await formData.append('attachment[]', file);
                    });

                    $.ajax({
                        url         : '{{ url("om/ajax/sale-confirmation/confirm-sale-confirmation") }}',
                        type        : 'post',
                        data        : formData,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        success     : function(res){
                            var data = res.data;
                            if(data.status == 'success'){

                                $('#order_header_id').val(res.data.orderHeaderID);

                                setAttachment(res.data.attachmentFile);
                                $('#prepare_order_number').val(res.data.saNumber);

                                saList = res.data.newSaList;
                                var orderLine = res.data.orderLine;

                                $('#buttonCreateLine').prop('disabled', true);
                                $('#buttonCopyToPi').prop('disabled', false);

                                var htmlLine = '';
                                var htmlCopyToPI = '';
                                numberLine = 1;

                                $.each(orderLine, function(key,val){
                                    htmlLine += '<tr id="order_line_roll_'+ val.order_line_id +'" class="del_all">';
                                    // htmlLine += '    <td>';
                                    // htmlLine += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" class="check" name="select_order_line['+val.order_line_id+']"></label></div>';
                                    // htmlLine += '    </td>';
                                    htmlLine += '    <td>'+ numberLine +' <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+val.order_line_id+'" value="'+val.order_line_id+'" ></td>';
                                    htmlLine += '    <td>'+val.item_code+'</td>';
                                    htmlLine += '    <td class="text-left">'+val.item_description+'</td>';
                                    htmlLine += '    <td>'+val.uom_code+'</td>';
                                    htmlLine += '    <td>'+val.uom+'</td>';
                                    htmlLine += '    <td>'+numberFormat(val.order_quantity)+'<input type="hidden" name="order_quantity['+ val.order_line_id +']" id="order_quantity_'+ val.order_line_id +'" value="'+numberFormat(val.order_quantity)+'" ></td>';
                                    htmlLine += '    <td>'+numberFormat(val.order_pi_quantity)+'</td>';
                                    htmlLine += '    <td class="text-right">'+numberFormat(val.unit_price)+'<input type="hidden" name="unit_price['+ val.order_line_id +']" id="unit_price_'+ val.order_line_id +'" value="'+numberFormat(val.unit_price)+'" ></td>';
                                    htmlLine += '    <td class="text-right"><span id="line_amount_'+ val.order_line_id +'">'+numberFormat(val.amount)+'<input type="hidden" name="amount['+ val.order_line_id +']" id="amount_'+ val.order_line_id +'" value="'+numberFormat(val.amount)+'" ></td>';
                                    htmlLine += '    <td>';
                                    htmlLine += '        <select class="custom-select vat-custom" name="sub_vat['+ val.order_line_id +']" id="sub_vat_'+ val.order_line_id +'" onchange="selectLineVat('+ val.order_line_id +')">';
                                    htmlLine += '            <option value=""> &nbsp; </option>';

                                    $.each(taxCode, function(key,valVat){
                                        if(val.vat_code == null && valVat.tax_rate_code == orderList.vat_code){
                                            checkSelectVat = 'selected';
                                        }else if (valVat.tax_rate_code == val.vat_code) {
                                            checkSelectVat = 'selected';
                                        }else{
                                            checkSelectVat = '';
                                        }
                                        htmlLine += '            <option '+ checkSelectVat +' value="'+ valVat.tax_rate_code +'">'+ valVat.tax_rate_code +'</option>';
                                    });

                                    htmlLine += '        </select>';
                                    htmlLine += '    </td>';
                                    htmlLine += '    <td class="text-right"><span id="line_tax_amount_'+ val.order_line_id +'">'+numberFormat(val.tax_amount)+'</span><input type="hidden" name="tax_amount['+ val.order_line_id +']" id="tax_amount_'+ val.order_line_id +'" value="'+numberFormat(val.tax_amount)+'" ></td>';
                                    htmlLine += '    <td class="text-right"><span id="line_total_amount_'+ val.order_line_id +'">'+numberFormat(val.total_amount)+'</span><input type="hidden" name="total_amount['+ val.order_line_id +']" id="total_amount_'+ val.order_line_id +'" value="'+numberFormat(val.total_amount)+'" ></td>';
                                    htmlLine += '    <td class="text-right">'+val.net_weight+' <input type="hidden" name="weight_id['+val.order_line_id+']" id="weight_id_'+val.order_line_id+'" value="'+val.weight_id+'" ></td>';
                                    htmlLine += '    <td class="text-right">'+val.net_gross+'</td>';
                                    htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_weight)+' <input type="hidden" name="total_net_weight['+val.order_line_id+']" id="total_net_weight_'+val.order_line_id+'" value="'+val.total_net_weight+'"> </td>';
                                    htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_gross)+' <input type="hidden" name="total_net_gross['+val.order_line_id+']" id="total_net_gross_'+val.order_line_id+'" value="'+val.total_net_gross+'"> </td>';
                                    htmlLine += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteLines(`order_line_roll_`, '+val.order_line_id+')"></a></td>';
                                    htmlLine += '</tr>';

                                    // COPY TO PI
                                    piBalance = parseFloat(val.order_quantity) - parseFloat(val.order_pi_quantity);

                                    if (piBalance <= 0) {
                                        ckPiBalance = 'readonly';
                                        ckPiSelect  = 'disabled';
                                    }else{
                                        ckPiBalance = '';
                                        ckPiSelect  = '';
                                    }

                                    htmlCopyToPI += '<tr class="align-middle">';
                                    htmlCopyToPI += '    <td>';
                                    htmlCopyToPI += '        <div class="i-checks wihtout-text m-auto '+ckPiSelect+'"><label class="m-0"><input type="checkbox" class="check check-line" name="select_copy[]" value="'+val.order_line_id+'"></label></div>';
                                    htmlCopyToPI += '    </td>';
                                    htmlCopyToPI += '    <td>'+ numberLine +'</td>';
                                    htmlCopyToPI += '    <td>'+val.item_code+' <input type="hidden" name="item_code['+val.order_line_id+']" id="item_code_'+val.order_line_id+'" value="'+val.item_code+'" ></td>';
                                    htmlCopyToPI += '    <td class="text-left">'+val.item_description+'</td>';
                                    htmlCopyToPI += '    <td>'+val.uom_code+'</td>';
                                    htmlCopyToPI += '    <td>'+val.uom+'</td>';
                                    htmlCopyToPI += '    <td>'+numberFormat(val.order_quantity)+' <input type="hidden" id="quantity_'+val.order_line_id+'" value="'+val.order_quantity+'" > </td>';
                                    htmlCopyToPI += '    <td>'+numberFormat(piBalance)+' <input type="hidden" id="pi_balance_'+val.order_line_id+'" value="'+piBalance+'" > </td>';
                                    htmlCopyToPI += '    <td><input type="text" '+ckPiBalance+' class="form-control text-right f13" name="pi_amount['+val.order_line_id+']" id="pi_amount_'+val.order_line_id+'" placeholder="0" onkeyup="checkPiBalance('+val.order_line_id+')" onkeypress="return isNumber(this, event)"  autocomplete="off"></td>';
                                    htmlCopyToPI += '</tr>';

                                    numberLine++;
                                    countPi = countPi + val.order_pi_quantity;
                                });

                                $('#orderCreateLines').html(htmlLine);
                                $('#copyToPI').html(htmlCopyToPI);

                                $('.check').iCheck({
                                    checkboxClass: 'icheckbox_square-green'
                                });

                                setDefaultInput(1);
                                $('#prepare_order_number').prop('readonly', true);
                                $('#order_number').prop('readonly', true);
                                $('#customer_number').prop('readonly', true);
                                $('.vat-custom').select2({disabled: true});

                                $('.custom-select').select2({width: "100%"});

                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "ยืนยันใบ Sale confirmation เรียบร้อยแล้ว",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: "ยืนยันใบ Sale confirmation ไม่ได้",
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

    function copyToProformaInvoice()
    {

        saNumber = $('#prepare_order_number').val();

        if (saNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'ไม่มีข้อมูลสำหรับ Copy To PI',
                showConfirmButton: true
            });
            return false;
        }else if($('.check-line').filter(':checked').length <= 0){
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกรายการ!'
            });
            return false;
        }

        var checkedPI = [];
        $("input[name='select_copy[]']:checked").each(function ()
        {
            var piId = parseInt($(this).val());
            var inputPI = $('#pi_amount_'+piId).val();
            var orderQuantity = parseFloat($('#pi_balance_'+piId).val());

            if(inputPI == 0 || inputPI == ""){
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณาระบุจำนวน PI'
                });
                checkedPI.push(false);
                return false;
            }else if(orderQuantity < inputPI){
                Swal.fire({
                    icon: 'warning',
                    text: 'จำนวน PI ต้องน้อยกว่า จำนวนสั่งซื้อ'
                });
                checkedPI.push(false);
                return false;
            }else{
                checkedPI.push(true);
            }

        });

        if(jQuery.inArray(false, checkedPI) !== -1){
            return false;
        }else{
            // Swal.fire({
            //     icon: 'success',
            //     text: 'Copy To PI Success!'
            // });

            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ต้องการ Copy To PI หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData(document.getElementById("formSaleConfirmation"));
                    formData.append('_token','{{ csrf_token() }}');

                    $.ajax({
                        url         : '{{ url("om/ajax/sale-confirmation/copy-to-proforma-invoice") }}',
                        type        : 'post',
                        data        : formData,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        success     : function(res){
                            // console.log(res);
                            var data = res.data;
                            var html = '';
                            var orderList = data.data;
                            if(data.status == 'success'){

                                saList = res.data.newSaList;
                                var orderLine = res.data.orderLine;

                                $('#buttonCopyToPi').prop('disabled', false);

                                var htmlLine = '';
                                var htmlCopyToPI = '';
                                numberLine = 1;

                                $.each(orderLine, function(key,val){
                                    htmlLine += '<tr id="order_line_roll_'+ val.order_line_id +'" class="del_all">';
                                    // htmlLine += '    <td>';
                                    // htmlLine += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" class="check" name="select_order_line['+val.order_line_id+']"></label></div>';
                                    // htmlLine += '    </td>';
                                    htmlLine += '    <td>'+ numberLine +' <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+val.order_line_id+'" value="'+val.order_line_id+'" ></td>';
                                    htmlLine += '    <td>'+val.item_code+'</td>';
                                    htmlLine += '    <td class="text-left">'+val.item_description+'</td>';
                                    htmlLine += '    <td>'+val.uom_code+'</td>';
                                    htmlLine += '    <td>'+val.uom+'</td>';
                                    htmlLine += '    <td>'+numberFormat(val.order_quantity)+'<input type="hidden" name="order_quantity['+ val.order_line_id +']" id="order_quantity_'+ val.order_line_id +'" value="'+numberFormat(val.order_quantity)+'" ></td>';
                                    htmlLine += '    <td>'+numberFormat(val.order_pi_quantity)+'</td>';
                                    htmlLine += '    <td class="text-right">'+numberFormat(val.unit_price)+'<input type="hidden" name="unit_price['+ val.order_line_id +']" id="unit_price_'+ val.order_line_id +'" value="'+numberFormat(val.unit_price)+'" ></td>';
                                    htmlLine += '    <td class="text-right"><span id="line_amount_'+ val.order_line_id +'">'+numberFormat(val.amount)+'<input type="hidden" name="amount['+ val.order_line_id +']" id="amount_'+ val.order_line_id +'" value="'+numberFormat(val.amount)+'" ></td>';
                                    htmlLine += '    <td>';
                                    htmlLine += '        <select class="custom-select vat-custom" name="sub_vat['+ val.order_line_id +']" id="sub_vat_'+ val.order_line_id +'" onchange="selectLineVat('+ val.order_line_id +')">';
                                    htmlLine += '            <option value=""> &nbsp; </option>';

                                    $.each(taxCode, function(key,valVat){
                                        if(val.vat_code == null && valVat.tax_rate_code == orderList.vat_code){
                                            checkSelectVat = 'selected';
                                        }else if (valVat.tax_rate_code == val.vat_code) {
                                            checkSelectVat = 'selected';
                                        }else{
                                            checkSelectVat = '';
                                        }
                                        htmlLine += '            <option '+ checkSelectVat +' value="'+ valVat.tax_rate_code +'">'+ valVat.tax_rate_code +'</option>';
                                    });

                                    htmlLine += '        </select>';
                                    htmlLine += '    </td>';
                                    htmlLine += '    <td class="text-right"><span id="line_tax_amount_'+ val.order_line_id +'">'+numberFormat(val.tax_amount)+'</span><input type="hidden" name="tax_amount['+ val.order_line_id +']" id="tax_amount_'+ val.order_line_id +'" value="'+numberFormat(val.tax_amount)+'" ></td>';
                                    htmlLine += '    <td class="text-right"><span id="line_total_amount_'+ val.order_line_id +'">'+numberFormat(val.total_amount)+'</span><input type="hidden" name="total_amount['+ val.order_line_id +']" id="total_amount_'+ val.order_line_id +'" value="'+numberFormat(val.total_amount)+'" ></td>';
                                    htmlLine += '    <td class="text-right">'+numberFormat(val.net_weight)+' <input type="hidden" name="weight_id['+val.order_line_id+']" id="weight_id_'+val.order_line_id+'" value="'+val.weight_id+'" ></td>';
                                    htmlLine += '    <td class="text-right">'+numberFormat(val.net_gross)+'</td>';
                                    htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_weight)+' <input type="hidden" name="total_net_weight['+val.order_line_id+']" id="total_net_weight_'+val.order_line_id+'" value="'+val.total_net_weight+'"> </td>';
                                    htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_gross)+' <input type="hidden" name="total_net_gross['+val.order_line_id+']" id="total_net_gross_'+val.order_line_id+'" value="'+val.total_net_gross+'"> </td>';
                                    htmlLine += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteLines(`order_line_roll_`, '+val.order_line_id+')"></a></td>';
                                    htmlLine += '</tr>';

                                    // COPY TO PI
                                    piBalance = parseFloat(val.order_quantity) - parseFloat(val.order_pi_quantity);

                                    if (piBalance <= 0) {
                                        ckPiBalance = 'readonly';
                                        ckPiSelect  = 'disabled';
                                    }else{
                                        ckPiBalance = '';
                                        ckPiSelect  = '';
                                    }

                                    htmlCopyToPI += '<tr class="align-middle">';
                                    htmlCopyToPI += '    <td>';
                                    htmlCopyToPI += '        <div class="i-checks wihtout-text m-auto '+ckPiSelect+'"><label class="m-0"><input type="checkbox" class="check check-line" name="select_copy[]" value="'+val.order_line_id+'"></label></div>';
                                    htmlCopyToPI += '    </td>';
                                    htmlCopyToPI += '    <td>'+ numberLine +'</td>';
                                    htmlCopyToPI += '    <td>'+val.item_code+' <input type="hidden" name="item_code['+val.order_line_id+']" id="item_code_'+val.order_line_id+'" value="'+val.item_code+'" ></td>';
                                    htmlCopyToPI += '    <td class="text-left">'+val.item_description+'</td>';
                                    htmlCopyToPI += '    <td>'+val.uom_code+'</td>';
                                    htmlCopyToPI += '    <td>'+val.uom+'</td>';
                                    htmlCopyToPI += '    <td>'+numberFormat(val.order_quantity)+' <input type="hidden" id="quantity_'+val.order_line_id+'" value="'+val.order_quantity+'" > </td>';
                                    htmlCopyToPI += '    <td>'+numberFormat(piBalance)+' <input type="hidden" id="pi_balance_'+val.order_line_id+'" value="'+piBalance+'" > </td>';
                                    htmlCopyToPI += '    <td><input type="text" '+ckPiBalance+' class="form-control text-right f13" name="pi_amount['+val.order_line_id+']" id="pi_amount_'+val.order_line_id+'" placeholder="0" onkeyup="checkPiBalance('+val.order_line_id+')" onkeypress="return isNumber(this, event)"  autocomplete="off"></td>';
                                    htmlCopyToPI += '</tr>';

                                    numberLine++;
                                    countPi = countPi + val.order_pi_quantity;
                                });

                                $('#orderCreateLines').html(htmlLine);
                                $('#copyToPI').html(htmlCopyToPI);

                                $('.check').iCheck({
                                    checkboxClass: 'icheckbox_square-green'
                                });


                                $('.vat-custom').select2({disabled: true});

                                $('.custom-select').select2({width: "100%"});

                                $('#copyToPIModal').modal('toggle');

                                var textalert = "Copy To PI เลขที่ : "+ res.data.piNumber;

                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: textalert,
                                    icon: 'success',
                                    showConfirmButton: true
                                });
                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: "Copy To PI ไม่ได้",
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

    function numberFormat2(nStr)
    {
        nStr = $.trim(nStr) != '' ? nStr : 0;
        // nStr = parseFloat(nStr).toFixed(2);
        // nStr = Math.round(nStr * 1000) / 1000;
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

    function selectCustomer()
    {

        var number = $("#customer_number").val();
        numberLine = 1;

        if(number != ''){

            var itemID = '';
            var itemName = '';
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

            // CREATE
            var orderType           = '';
            var currency            = '';
            var currency_name       = '';
            var term_id             = '';
            var term_name           = '';
            var term_description    = '';
            var payment_type_code   = '';
            var vat_code            = '';
            var payment_method_code = '';
            var bill_to_site_id     = '';
            var bill_to_site_name   = '';
            var incoterms_code      = '';
            var shipment_condition  = '';
            var source_system       = '';
            var price_list_id       = '';
            previous                = '';


            $.each(customerList, function(key,val){
                if (val.customer_number == number) {

                    $('#order_type_id').val(val.order_type_id).trigger('change')
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

                    // CREATE
                    orderType           = val.order_type_id;
                    currency            = val.currency;
                    currency_name       = val.currency_name;
                    term_id             = val.payment_term_id;
                    term_name           = val.term_name;
                    term_description    = val.term_description;
                    payment_type_code   = val.payment_type_id;
                    vat_code            = val.vat_code;
                    payment_method_code = val.payment_method_id;
                    bill_to_site_id     = val.bill_to_site_id;
                    bill_to_site_name   = val.bill_to_site_name != null ? val.bill_to_site_name : val.customer_name;
                    incoterms_code      = val.incoterms_code;
                    shipment_condition  = val.shipment_condition;
                    source_system       = val.sales_channel;
                    price_list_id       = val.price_list_id;
                    previous            = val.price_list_id;


                    itemID = val.customer_id;
                    itemName = val.customer_name;
                    itemAddress = addressLine1 + addressLine2 + addressLine3 + alley + state + district + city + provinceName + postalCode + country_name;
                }
            });

            $("#customer_id").val(itemID).trigger('change');
            $("#customer_name").val(itemName);
            $("#customer_address").val(itemAddress);

            if (stepEvent == 'create') {

                $.ajax({
                    url : `{{ url("om/ajax/sale-confirmation/customer-shipsite") }}/`+itemID,
                    success : function(res){
                        var dataShipsite = res.data.data;
                        if (res.data.status == 'success') {

                            var html        = '';
                            var selectShip  = '';
                            html += '<option value=""> &nbsp; </option>';
                            $.each(dataShipsite, function(key,val){
                                if (key == 0) {
                                    selectShip = 'selected';
                                    $('#port_of_discharge').val(val.ship_to_site_name);
                                }else{
                                    selectShip = '';
                                }
                                html += '<option '+selectShip+' value="'+val.ship_to_site_id+'">'+val.ship_to_site_name+'</option>';
                            });
                            $('#ship_to_site_id').html(html).trigger('change');

                        }else{
                            Swal.fire({
                                title: 'แจ้งเตือน',
                                text: 'ลูกค้านี้ ไม่มีข้อมูล Ship To',
                                icon: 'error',
                                timer: 2500
                            });
                        }

                    }
                });


                $('#order_type_id').val(orderType).trigger('change');
                $('#currency_name').val(currency_name);
                $('#currency').val(currency).trigger('change');
                $('#term_id').val(term_id);
                $('#term_name').val(term_name).trigger('change');
                $('#term_description').val(term_description);
                $('#payment_type_code').val(payment_type_code).trigger('change');
                $('#vat_code').val(vat_code).trigger('change');
                $('#payment_method_code').val(payment_method_code).trigger('change');
                $('#bill_to_site_id').val(bill_to_site_id);
                $('#bill_to_site_name').val(bill_to_site_name);
                $('#incoterms_code').val(incoterms_code).trigger('change');
                $('#port_of_loading').val('Tobacco Authority Of Thailand');
                $("#transport_type_code").prop("selectedIndex", 1).trigger('change');
                // $('#transport_type_code').val(orderList.transport_type_code).trigger('change');
                $('#shipment_condition').val(shipment_condition);

                if (source_system == 'E-COMMERCE' || source_system == 'E-commerce') {
                    source_system = 'E-Commerce';
                }
                $('#source_system').val(source_system).trigger('change');

                $('#orderCreateLines').html('');
                $('#buttonCreateLine').prop('disabled', false);
            }

            var htmlPriceList   = '';
            var selectPriceList = '';
            htmlPriceList += '<option value=""> &nbsp; </option>';
            $.each(priceList, function(key,val){
                if (currency == val.currency_code) {
                    if (val.list_header_id == price_list_id) {
                        selectPriceList = 'selected';
                    }else{
                        selectPriceList = '';
                    }
                    htmlPriceList += '<option '+selectPriceList+' value="'+val.list_header_id+'">'+val.name+'</option>';
                }
            });
            $('#price_list_id').html(htmlPriceList).trigger('change');

        }else{
            $("#customer_id").val('').trigger('change');
            $("#customer_name").val('');
            $("#customer_address").val('');

            if (stepEvent == 'create') {
                $('#order_type_id').val('').trigger('change');
                $('#currency_name').val('');
                $('#currency').val('').trigger('change');
                $('#term_id').val('');
                $('#term_name').val('').trigger('change');
                $('#term_description').val('');
                $('#payment_type_code').val('').trigger('change');
                $('#vat_code').val('').trigger('change');
                $('#payment_method_code').val('').trigger('change');
                $('#bill_to_site_id').val('');
                $('#bill_to_site_name').val('');
                $('#incoterms_code').val('').trigger('change');
                $('#port_of_loading').val('Tobacco Authority Of Thailand');
                $("#transport_type_code").val('').trigger('change');
                $('#shipment_condition').val('');
                $('#source_system').val('').trigger('change');

                $('#ship_to_site_id').html('').trigger('change');
                $('#port_of_discharge').val('');

                $('#orderCreateLines').html('');
                $('#buttonCreateLine').prop('disabled', true);
            }
        }

        setSelectValue(3);
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

            var htmlPriceList   = '';
            var selectPriceList = '';
            htmlPriceList += '<option value=""> &nbsp; </option>';
            $.each(priceList, function(key,val){
                if (code == val.currency_code) {
                    if (val.list_header_id == price_list_id) {
                        selectPriceList = 'selected';
                    }else{
                        selectPriceList = '';
                    }
                    htmlPriceList += '<option '+selectPriceList+' value="'+val.list_header_id+'">'+val.name+'</option>';
                }
            });
            $('#price_list_id').html(htmlPriceList).trigger('change');



        }else{
            $("#currency_name").val('');
            $('#price_list_id').html('').trigger('change');
        }
    }

    function selectApprover()
    {
        // var code = $("#create_sale_confirm_by").val();
        var name = $("#create_approver_name").val();

        if(name != ''){

            var itemID      = '';
            var itemName    = '';
            $.each(approverList, function(key,val){
                if (val.approver_name == name) {
                    itemID      = val.approver_order_id;
                    itemName    = val.approver_name;
                }
            });

            $("#create_sale_confirm_by").val(itemID);
            // $("#create_approver_name").val(itemName);
        }else{
            $("#create_sale_confirm_by").val('');
            // $("#create_approver_name").val('');
        }
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

    function checkCancel()
    {
        var saNumber = $('#order_header_id').val();
        if(saNumber == ''){
            Swal.fire({
                title: 'ไม่สามารถทำรายการได้',
                text: 'กรุณาเลือกข้อมูลที่ต้องการยกเลิก',
                icon: 'warning'
            });
        }else if ($('#sa_status').val() == 'Cancelled' || $('#sa_status').val() == 'Cancel') {
            Swal.fire({
                title: 'ไม่สามารถทำรายการได้',
                text: 'ใบ Sale Confirmation นี้ถูกยกเลิกไปแล้ว',
                icon: 'warning'
            });
        }else if (countPi > 0) {
            Swal.fire({
                title: 'ไม่สามารถทำรายการได้',
                text: 'ต้องยกเลิก PI ทั้งหมดก่อน',
                icon: 'warning'
            });
        }else{

            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ต้องการยกเลิกใบ SA ใช่ หรือไม่",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.showLoading();

                    $.ajax({
                        url : `{{ url("om/ajax/sale-confirmation/check-cancel") }}/`+saNumber,
                        success : function(res){
                            var dataOrder = res.data.data;
                            if(res.data.status == 'retry'){
                                Swal.fire({
                                    title: 'ไม่สามารถทำรายการยกเลิกได้',
                                    text: 'เลขที่ใบ SA นี้มีการชำระเงินแล้ว',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }else if (res.data.status == 'success') {
                                Swal.close();
                                $('#cancelModal').modal('show');

                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: 'ยกเลิกใบ SA ไม่สำเร็จ',
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

    function cancelSaleConfirmation()
    {
        if ($('#sa_cancel_reason').val() == '') {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'กรุณาใส่เหตุผลที่ยกเลิก',
                icon: 'warning'
            });
            return false;
        }else{

            Swal.showLoading();

            $('#sa_status').val('Cancelled');

            const formData = new FormData(document.getElementById("formSaleConfirmation"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/sale-confirmation/cancel") }}',
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
                        $('#buttonCopyToPi').prop('disabled', true);

                        var saNumber = $('#prepare_order_number').val();

                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'ยกเลิกใบ SA : '+saNumber+' แล้ว',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2500
                        });

                    }else{
                        Swal.fire({
                            title: 'ผิดพลาด',
                            text: 'ยกเลิกใบ SA ไม่สำเร็จ',
                            icon: 'error',
                            timer: 2500
                        });
                    }
                }
            });
        }
    }

    function newResetSaleConfirmation()
    {
        window.location = '{{ url('om/sale-confirmation') }}';
    }

    function resetSaleConfirmation()
    {
        stepEvent       = '';
        taxList         = [];
        resultAmount    = 0.00;
        countPi         = 0;

        $('#sa_status').val('Draft');
        $('#prepare_order_number').val('').trigger('change');
        // $('#sa_date').val('');
        // $('#show_sa_date').val('');
        // generateSaDate('', false);
        $("#sa_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", '');
        $('#order_number').val('').trigger('change');
        // $('#order_date').val('');
        // $('#show_order_date').val('');
        // generateOrderDate('', false);
        $("#order_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", '');
        $('#cust_po_number').val('');
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
        $('#port_of_loading').val('Tobacco Authority Of Thailand');
        $('#transport_type_code').val('');
        $('#transport_detail').val('');
        $('#port_of_discharge').val('');
        $('#shipment_condition').val('');
        $('#shipping_marks').val('');
        $('#source_system').val('');
        $('#sale_confirm_date').val('');
        $('#sale_confirm_document_no').val('');

        // HIDDEN
        $('#order_header_id').val('');
        $('#customer_id').val('');
        $('#sale_confirm_by').val('');
        $('#sale_confirm_flag').val('');
        $('#bill_to_site_id').val('');

        // HTML
        $('#orderCreateLines').html('');
        $('#orderLines').html('');
        $('#copyToPI').html('');

        $('#resultSubtotal').html(numberFormat(0));
        $('#resultTax').html(numberFormat(0));
        $('#resultTotal').html(numberFormat(0));

        // INPUT ALERT
        $('#create_sale_confirm_date').val('');
        $('#create_sale_confirm_document_no').val('');
        $('#create_approver_name').val('').trigger('change');
        $('#create_sale_confirm_by').val('');

        setAttachment([]);
        setDefaultInput(1);

        $('#buttonCreateLine').prop('disabled', true);
        $('#buttonCopyToPi').prop('disabled', true);

        generateSaleConfirmDate(dateNow);

        // Another case
        $('#price_list_id').val('').trigger('change');
    }

    function setDefaultInput(inputStatus)
    {
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
            $('#port_of_discharge').prop('readonly', true);
            $('#transport_detail').prop('readonly', true);
            $('#shipment_condition').prop('readonly', true);
            $('#shipping_marks').prop('readonly', true);

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
            $('#port_of_discharge').prop('readonly', false);
            $('#transport_detail').prop('readonly', false);
            $('#shipment_condition').prop('readonly', false);
            $('#shipping_marks').prop('readonly', false);

            $('.check-default').select2({disabled: ''});

            $('.check-create').select2({disabled: ''});

            $('.date').datepicker();
        }
        $('#prepare_order_number').prop('readonly', false);
        $('#order_number').prop('readonly', false);
        $('#customer_number').prop('readonly', false);
    }

    function selectPrepareOrderNumber()
    {
        var prepareOrderNumber = $('#prepare_order_number').val();

        var saStatus    = 'Draft';
        var saDate      = '';

        if (prepareOrderNumber != '') {
            $.each(saList, function(key, val){
                if (val.prepare_order_number == prepareOrderNumber) {
                    saStatus    = val.sa_status;
                    saDate      = val.sa_date;
                }
            });
        }

        $('#sa_status').val(saStatus);
        // $('#sa_date').val(saDate);
        // $('#show_sa_date').val(saDate);
        // generateSaDate(saDate, false);
        $("#sa_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", saDate);

        setSelectValue(1);
    }

    function selectOrderNumber()
    {
        var orderNumber = $('#order_number').val();

        var orderHeaderID   = '';
        var orderDate       = '';
        var custPO          = '';

        if (orderNumber != '') {
            $.each(orderList, function(key, val){
                if (val.order_number == orderNumber) {

                    orderHeaderID   = val.order_header_id;
                    orderDate       = val.order_date;
                    custPO          = val.cust_po_number;
                }
            });
        }

        $('#order_header_id').val(orderHeaderID);
        // $('#order_date').val(orderDate);
        // $('#show_order_date').val(orderDate);
        // generateOrderDate(orderDate);
        $("#order_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", orderDate);
        $('#cust_po_number').val(custPO);

        setSelectValue(2);
    }

    function changeSelectID(inputChange)
    {
        var saNumber        = $('#prepare_order_number').val();
        var orderNumber     = $('#order_number').val();
        var customerNumber  = $('#customer_number').val();

        var checkSaSelect       = '';
        var checkOrderSelect    = '';
        var checkCustomerSelect = '';

        var keySA               = 0;
        var keyOrder            = 0;
        var keyCustomer         = 0;

        var saHTML          = '<option value=""> &nbsp; </option>';
        var orderHTML       = '<option value=""> &nbsp; </option>';
        var customerHTML    = '<option value=""> &nbsp; </option>';
        $.each(saList, function(key,val){

            // PREPARE ORDER NUMBER
            if (saNumber == val.prepare_order_number) {
                checkSaSelect = 'selected';
            }else{
                checkSaSelect = '';
            }

            if (saNumber == '' && orderNumber == '' && customerNumber == '') {
                if (val.prepare_order_number !=  null) {
                    saHTML += '<option value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }
            }else if(saNumber != '' && orderNumber == '' && customerNumber == '') {
                if (saNumber == val.prepare_order_number) {
                    saHTML += '<option '+checkSaSelect+' value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }else if(val.prepare_order_number){
                    saHTML += '<option value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }
            }else if(saNumber != '' && orderNumber != '' && customerNumber == '') {
                if (saNumber == val.prepare_order_number && orderNumber == val.order_number) {
                    saHTML += '<option '+checkSaSelect+' value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }
            }else if(saNumber != '' && orderNumber != '' && customerNumber != '') {
                if (saNumber == val.prepare_order_number && orderNumber == val.order_number && customerNumber == val.customer_number) {
                    saHTML += '<option '+checkSaSelect+' value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }
            }else if(saNumber == '' && orderNumber == '' && customerNumber != '') {
                if (customerNumber == val.customer_number && val.prepare_order_number != null) {
                    saHTML += '<option value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }
            }else if(saNumber == '' && orderNumber != '' && customerNumber != '') {
                if (orderNumber == val.order_number && customerNumber == val.customer_number) {
                    saHTML += '<option value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }
            }else if(saNumber != '' && orderNumber == '' && customerNumber != '') {
                if (saNumber == val.prepare_order_number && customerNumber == val.customer_number) {
                    saHTML += '<option '+checkSaSelect+' value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }
            }else if(saNumber == '' && orderNumber != '' && customerNumber == '') {
                if (orderNumber == val.order_number) {
                    saHTML += '<option value="'+ val.prepare_order_number +'"> '+ val.prepare_order_number +' </option>';
                }
            }
        });

        $.each(orderList, function(key, val){
            // ORDER NUMBER
            if (orderNumber == val.order_number) {
                checkOrderSelect = 'selected';
            }else{
                checkOrderSelect = '';
            }

            if (saNumber == '' && orderNumber == '' && customerNumber == '') {
                if (val.order_number != null) {
                    orderHTML += '<option value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }
            }else if(saNumber != '' && orderNumber == '' && customerNumber == '') {
                if (saNumber == val.prepare_order_number) {
                    orderHTML += '<option value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }
            }else if(saNumber != '' && orderNumber != '' && customerNumber == '') {
                if (saNumber == val.prepare_order_number && orderNumber == val.order_number) {
                    orderHTML += '<option '+checkOrderSelect+' value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }
            }else if(saNumber != '' && orderNumber != '' && customerNumber != '') {
                if (saNumber == val.prepare_order_number && orderNumber == val.order_number && customerNumber == val.customer_number) {
                    orderHTML += '<option '+checkOrderSelect+' value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }
            }else if(saNumber == '' && orderNumber == '' && customerNumber != '') {
                if (customerNumber == val.customer_number && val.order_number != null) {
                    orderHTML += '<option value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }
            }else if(saNumber == '' && orderNumber != '' && customerNumber != '') {
                if (orderNumber == val.order_number && customerNumber == val.customer_number) {
                    orderHTML += '<option '+checkOrderSelect+' value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }
            }else if(saNumber != '' && orderNumber == '' && customerNumber != '') {
                if (saNumber == val.prepare_order_number && customerNumber == val.customer_number) {
                    orderHTML += '<option '+checkOrderSelect+' value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }
            }else if(saNumber == '' && orderNumber != '' && customerNumber == '') {
                if (orderNumber == val.order_number) {
                    orderHTML += '<option '+checkOrderSelect+' value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }else{
                    orderHTML += '<option value="'+ val.order_number +'"> '+ val.order_number +' </option>';
                }
            }
        });

        // CUSTOMER NUMBER
        if(saNumber == '' && orderNumber == '' && customerNumber == ''){
            var checkNumber = '';
            $.each(customerList, function(key,val){
                if (checkNumber != val.customer_number) {
                    if (val.customer_number != null) {
                        customerHTML += '<option value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                    }
                }
            });
        }else if(saNumber == '' && orderNumber == '' && customerNumber != '') {
            $.each(customerList, function(key,val){
                if (checkNumber != val.customer_number) {
                    if (customerNumber == val.customer_number) {
                        customerHTML += '<option selected value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                    }else{
                        customerHTML += '<option value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                    }
                    checkNumber = val.customer_number;
                }
            });
        }else{
            var checkNumber = '';
            $.each(saList, function(key,val){
                if (checkNumber != val.customer_number) {
                    if (customerNumber == val.customer_number) {
                        checkCustomerSelect = 'selected';
                    }else{
                        checkCustomerSelect = '';
                    }
                    if(saNumber != '' && orderNumber == '' && customerNumber == '') {
                        if (saNumber == val.prepare_order_number) {
                            customerHTML += '<option value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                        }
                    }else if(saNumber != '' && orderNumber != '' && customerNumber == '') {
                        if (saNumber == val.prepare_order_number && orderNumber == val.order_number) {
                            customerHTML += '<option value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                        }
                    }else if(saNumber != '' && orderNumber != '' && customerNumber != '') {
                        if (saNumber == val.prepare_order_number && orderNumber == val.order_number && customerNumber == val.customer_number) {
                            customerHTML += '<option '+checkCustomerSelect+' value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                            checkNumber = val.customer_number;
                        }
                    }else if(saNumber == '' && orderNumber != '' && customerNumber != '') {
                        if (orderNumber == val.order_number && customerNumber == val.customer_number) {
                            customerHTML += '<option '+checkCustomerSelect+' value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                            checkNumber = val.customer_number;
                        }
                    }else if(saNumber != '' && orderNumber == '' && customerNumber != '') {
                        if (saNumber == val.prepare_order_number && customerNumber == val.customer_number) {
                            customerHTML += '<option '+checkCustomerSelect+' value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                            checkNumber = val.customer_number;
                        }
                    }else if(saNumber == '' && orderNumber != '' && customerNumber == '') {
                        if (orderNumber == val.order_number) {
                            customerHTML += '<option value="'+ val.customer_number +'"> '+ val.customer_number +' </option>';
                        }
                    }
                }
            });
        }

        $('#prepare_order_number').html(saHTML);
        $('#order_number').html(orderHTML);
        $('#customer_number').html(customerHTML);
    }

    function selectVat()
    {
        var vatCode     = $('#vat_code').val();
        var percenRate  = 0;

        $.each(taxCode, function(key,val){
            if (val.tax_rate_code == vatCode) {
                percenRate = val.percentage_rate;

            }
        });

        var resultSubTotal  = 0;
        var resultTax       = 0;
        var resultTotal     = 0;

        var taxAmount       = 0;
        var lineAmount      = 0;

        $("input[name='order_line_manage[]']").each(function ()
        {
            var lineID          = parseInt($(this).val());

            var orderQuantity   = $('#order_quantity_'+lineID).val() != '' ? parseFloat($('#order_quantity_'+lineID).val()) : 0;
            var unitPrice       = $('#unit_price_'+lineID).val() != '' ? parseFloat($('#unit_price_'+lineID).val()) : 0;
            var taxAmount       = $('#tax_amount_'+lineID).val() != '' ? parseFloat($('#tax_amount_'+lineID).val()) : 0;
            var amount          = $('#amount_'+lineID).val() != '' ? parseFloat($('#amount_'+lineID).val()) : 0;

            taxAmount           = (amount * percenRate) / 100;
            lineAmount          = amount + taxAmount;

            resultSubTotal      = resultSubTotal + amount;
            resultTax           = resultTax + taxAmount;
            resultTotal         = resultTotal + lineAmount;

            $('#sub_vat_'+lineID).val(vatCode).trigger('change');
            $('#tax_amount_'+lineID).val(taxAmount);
            $('#total_amount_'+lineID).val(lineAmount);

            $('#line_tax_amount_'+lineID).html(numberFormat(taxAmount));
            $('#line_total_amount_'+lineID).html(numberFormat(lineAmount));

        });

        $('#order_sub_total').val(resultSubTotal);
        $('#order_tax').val(resultTax);
        $('#order_total').val(resultTotal);

        $('#resultSubtotal').html(numberFormat(resultSubTotal));
        $('#resultTax').html(numberFormat(resultTax));
        $('#resultTotal').html(numberFormat(resultTotal));

    }

    function selectLineVat(lineID)
    {
        var vatCode     = $('#sub_vat_'+lineID).val();
        var percenRate  = 0;

        $.each(taxCode, function(key,val){
            if (val.tax_rate_code == vatCode) {
                percenRate = val.percentage_rate;

            }
        });

        var resultSubTotal  = 0;
        var resultTax       = 0;
        var resultTotal     = 0;

        var orderQuantity   = $('#order_quantity_'+lineID).val() != '' ? parseInt($('#order_quantity_'+lineID).val()) : 0;
        var unitPrice       = $('#unit_price_'+lineID).val() != '' ? parseFloat($('#unit_price_'+lineID).val(),2) : 0;
        var taxAmount       = $('#tax_amount_'+lineID).val() != '' ? parseFloat($('#tax_amount_'+lineID).val(),2) : 0;
        var amount          = $('#amount_'+lineID).val() != '' ? parseFloat($('#amount_'+lineID).val(),2) : 0;

        var taxAmount       = (amount * percenRate) / 100;
        var lineAmount      = amount + taxAmount;

        $('#tax_amount_'+lineID).val(taxAmount);
        $('#total_amount_'+lineID).val(lineAmount);

        $('#line_tax_amount_'+lineID).html(numberFormat(taxAmount));
        $('#line_total_amount_'+lineID).html(numberFormat(lineAmount));

        $("input[name='order_line_manage[]']").each(function ()
        {
            var vatLineID   = parseInt($(this).val());

            total_amount    = $('#amount_'+vatLineID).val() != '' ? parseFloat($('#amount_'+vatLineID).val()) : 0;
            total_tax       = $('#tax_amount_'+vatLineID).val() != '' ? parseFloat($('#tax_amount_'+vatLineID).val()) : 0;
            line_total      = $('#total_amount_'+vatLineID).val() != '' ? parseFloat($('#total_amount_'+vatLineID).val()) : 0;

            // console.log('total amount : '+total_amount);
            // console.log('total ta : '+total_tax);
            // console.log('total line : '+line_total);

            resultSubTotal      = resultSubTotal + total_amount;
            resultTax           = resultTax + total_tax;
            resultTotal         = resultTotal + line_total;

        });

        $('#order_sub_total').val(resultSubTotal);
        $('#order_tax').val(resultTax);
        $('#order_total').val(resultTotal);

        $('#resultSubtotal').html(numberFormat(resultSubTotal));
        $('#resultTax').html(numberFormat(resultTax));
        $('#resultTotal').html(numberFormat(resultTotal));
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

    function isNumberUnlimit(el, evt)
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
        // if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
        //     return false;
        // }
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

    function checkPiBalance(piID)
    {
        var balance = parseFloat($('#pi_balance_'+piID).val());
        var amount  = parseFloat($('#pi_amount_'+piID).val());

        if (balance <= amount) {
            $('#pi_amount_'+piID).val(balance);
        }else if(amount == 0){
            // $('#pi_amount_'+piID).val(1);
        }

    }

    let numberLine = 1;
    let keyLinesCreate = 0;
    function addInputOrderLines()
    {
        var priceList = $('#price_list_id').val();

        if ($.trim(priceList) == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือก Price List',
                showConfirmButton: true
            });
        }else{
            htmlLine = '';
            htmlLine += '<tr id="order_line_roll_'+keyLinesCreate+'" class="del_all">';
            htmlLine += '    <td><span id="number_line_'+keyLinesCreate+'">'+ numberLine +'</span> <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+keyLinesCreate+'" value="'+keyLinesCreate+'" ></td>';

            // SEQUENCE ECOM
            htmlLine += '    <td>';
            htmlLine += '        <div class="form-group">';
            htmlLine += '            <div class="input-icon" style="width: 180px;">';
         htmlLine += '                <input type="hidden" readonly placeholder="" name="item_id['+keyLinesCreate+']" id="item_id_'+keyLinesCreate+'" value="">';
            htmlLine += '               <input type="text" class="form-control" name="item_code['+keyLinesCreate+']" id="item_code_'+keyLinesCreate+'" list="sequence-list-'+keyLinesCreate+'" onchange="selectItemsLines('+keyLinesCreate+');" autocomplete="off">';
            htmlLine += '               <i class="fa fa-search"></i>';
            htmlLine += '               <datalist id="sequence-list-'+keyLinesCreate+'">';

            $.each(sequenceEcoms, function(key,val){
                if (val.item_code != '' && val.list_header_id == priceList) {
                    htmlLine += '                   <option value="'+val.item_code+'">'+val.ecom_item_description+'</option>';
                }
            });

            htmlLine += '                </datalist>';
            htmlLine += '                <i class="fa fa-search"></i>';
            htmlLine += '            </div>';
            htmlLine += '        </div>';
            htmlLine += '    </td>';
            // SEQUENCE ECOM

            htmlLine += '    <td class="text-left"> <span id="text_description_'+keyLinesCreate+'"> </span> <input type="hidden" name="item_description['+ keyLinesCreate +']" id="item_description_'+ keyLinesCreate +'" value=""> </td>';

            // UOM
            htmlLine += '    <td>';
            htmlLine += '        <div class="form-group">';
            htmlLine += '            <div class="input-icon">';
            htmlLine += '                <input type="hidden" readonly placeholder="" name="uom_id['+keyLinesCreate+']" id="uom_id_'+keyLinesCreate+'" value="">';
            htmlLine += '               <input type="text" class="form-control" name="uom_code['+keyLinesCreate+']" id="uom_code_'+keyLinesCreate+'" list="uom-list-'+keyLinesCreate+'" onchange="selectUomLines('+keyLinesCreate+');" autocomplete="off">';
            htmlLine += '               <i class="fa fa-search"></i>';
            htmlLine += '               <datalist id="uom-list-'+keyLinesCreate+'">';

            $.each(uomList, function(key,val){
                if (val.uom_code != '') {
                    htmlLine += '                   <option value="'+val.uom_code+'">'+val.description+'</option>';
                }
            });

            htmlLine += '                </datalist>';
            htmlLine += '                <i class="fa fa-search"></i>';
            htmlLine += '            </div>';
            htmlLine += '        </div>';
            htmlLine += '    </td>';
            // UOM

            htmlLine += '    <td> <span id="text_uom_'+keyLinesCreate+'"> </span> <input type="hidden" name="uom['+ keyLinesCreate +']" id="uom_'+ keyLinesCreate +'" value=""> </td>';
            htmlLine += '    <td> <input type="text" class="form-control" name="order_quantity['+keyLinesCreate+']" id="order_quantity_'+ keyLinesCreate +'" value="1" onkeyup="checkInputAmount('+keyLinesCreate+')" onkeypress="return isNumber(this, event)" autocomplete="off"></td>';
            htmlLine += '    <td> 0 </td>';
            htmlLine += '    <td class="text-right"> <input type="text" class="form-control" id="text_unit_price_'+ keyLinesCreate +'" value="0.00" onchange="changeUnitPrice('+ keyLinesCreate +')" onkeypress="return isNumber(this, event)" automcomplete="off"> <input type="hidden" name="unit_price['+ keyLinesCreate +']" id="unit_price_'+ keyLinesCreate +'" value="0" ></td>';
            htmlLine += '    <td class="text-right"><span id="line_amount_'+ keyLinesCreate +'"> 0.00 </span><input type="hidden" name="amount['+ keyLinesCreate +']" id="amount_'+ keyLinesCreate +'" value="0" ></td>';
            htmlLine += '    <td>';
            htmlLine += '        <select class="custom-select" name="sub_vat['+ keyLinesCreate +']" id="sub_vat_'+ keyLinesCreate +'" onchange="selectLineVat('+ keyLinesCreate +')">';
            htmlLine += '            <option value=""> &nbsp; </option>';

            // VAT IN LINE
            var vatCodeMain = $('#vat_code').val();

            $.each(taxCode, function(key,valVat){
                if (valVat.tax_rate_code == vatCodeMain) {
                    var checkVatLine = 'selected';
                }else{
                    var checkVatLine = '';
                }

                htmlLine += '            <option '+checkVatLine+' value="'+ valVat.tax_rate_code +'">'+ valVat.tax_rate_code +'</option>';
            });

            htmlLine += '        </select>';
            htmlLine += '    </td>';
            htmlLine += '    <td class="text-right"><span id="line_tax_amount_'+ keyLinesCreate +'"> 0.00 </span><input type="hidden" name="tax_amount['+ keyLinesCreate +']" id="tax_amount_'+ keyLinesCreate +'" value="0" ></td>';
            htmlLine += '    <td class="text-right"><span id="line_total_amount_'+ keyLinesCreate +'"> 0.00 </span><input type="hidden" name="total_amount['+ keyLinesCreate +']" id="total_amount_'+ keyLinesCreate +'" value="0" ></td>';
            // htmlLine += '    <td class="text-right"><span id="text_net_'+keyLinesCreate+'"> 0.00 </span><input type="hidden" name="weight_id['+keyLinesCreate+']" id="weight_id_'+keyLinesCreate+'" value="" ></td>';
            // htmlLine += '    <td class="text-right"><span id="text_gross_'+keyLinesCreate+'"> 0.00 </span></td>';
            htmlLine += '    <td class="text-right">';
            htmlLine += '       <input type="text" class="form-control" name="net['+keyLinesCreate+']" id="net_'+keyLinesCreate+'" value="0.00" onchange="weightChange('+keyLinesCreate+')"  onkeypress="return isNumberUnlimit(this, event)">';
            htmlLine += '       <input type="hidden" name="weight_id['+keyLinesCreate+']" id="weight_id_'+keyLinesCreate+'" value="" >';
            htmlLine += '    </td>';
            htmlLine += '    <td class="text-right"><input type="text" class="form-control" name="gross['+keyLinesCreate+']" id="gross_'+keyLinesCreate+'" value="0.00" onchange="weightChange('+keyLinesCreate+')"  onkeypress="return isNumberUnlimit(this, event)"> </td>';
            htmlLine += '    <td class="text-right"><span id="text_total_net_'+keyLinesCreate+'"> 0.00 </span> <input type="hidden" name="total_net_weight['+keyLinesCreate+']" id="total_net_weight_'+keyLinesCreate+'" value="0.00"> </td>';
            htmlLine += '    <td class="text-right"><span id="text_total_gross_'+keyLinesCreate+'"> 0.00 </span> <input type="hidden" name="total_net_gross['+keyLinesCreate+']" id="total_net_gross_'+keyLinesCreate+'" value="0.00"> </td>';
            // htmlLine += '    <td class="text-right"><span id="text_total_net_'+keyLinesCreate+'"> 0.00 </span><input type="hidden" name="total_net_weight['+keyLinesCreate+']" id="total_net_weight_'+keyLinesCreate+'" value="0"> </td>';
            // htmlLine += '    <td class="text-right"><span id="text_total_gross_'+keyLinesCreate+'"> 0.00 </span><input type="hidden" name="total_net_gross['+keyLinesCreate+']" id="total_net_gross_'+keyLinesCreate+'" value="0"> </td>';
            htmlLine += '    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteLines(`order_line_roll_`, '+keyLinesCreate+')"></a></td>';
            htmlLine += '</tr>';
            keyLinesCreate  += 1;
            numberLine      += 1;

            $('#orderCreateLines').append(htmlLine);

            $('.custom-select').select2({width: "100%"});
        }
    }

    function selectItemsLines(index)
    {
        var itemCode    = $("#item_code_"+index).val();

        filterUOMCode(itemCode , index);


        var itemCode    = $("#item_code_"+index).val();
        var unitPrice   = numberFormat(0);

        if(itemCode == '')
        {
            $("#item_id_"+index).val('');
            $("#item_description_"+index).val('');
            $('#text_description_'+index).html('');

            $('#unit_price_'+index).val(numberFormat(0));
            $('#text_unit_price_'+index).val(numberFormat(0));
        }else if(itemCode != ''){

            var itemID = '';
            var itemKey = '';
            $.each(sequenceEcoms, function(key,val){
                if (val.item_code == itemCode) {
                    itemID = val.item_id;
                    itemKey = val.ecom_item_description;
                }
            });

            if (itemID == '') {
                $("#item_code_"+index).val('');
                $("#item_id_"+index).val('');
                $("#item_description_"+index).val('');
                $('#text_description_'+index).html('');

                $('#unit_price_'+index).val('0');
                $('#text_unit_price_'+index).val(numberFormat(0));
            }else{
                $("#item_id_"+index).val(itemID);
                $("#item_description_"+index).val(itemKey);
                $('#text_description_'+index).html(itemKey);

                var customerNumber = $('#customer_number').val();
                $.each(customerList, function(key,val){
                    if (val.customer_number == customerNumber) {
                        priceListID = val.price_list_id;
                        previous    = val.price_list_id;
                    }
                });

                var uomCode      = $('#uom_code_'+index).val();

                if (itemID != '') {
                    $.each(priceListLine, function(key,val){
                        if (val.product_uom_code == uomCode && val.item_id == itemID && val.list_header_id == priceListID) {
                            unitPrice = val.operand;
                        }
                    });
                }

                $('#unit_price_'+index).val(unitPrice);
                $('#text_unit_price_'+index).val(numberFormat(unitPrice));

            }

            // ITEM WEIGHTS
            var orderQuantity   = $('#order_quantity_'+index).val() != '' ? $('#order_quantity_'+index).val() : 0;

            var weight_id   = '';
            var net_weight  = numberFormat(0);
            var net_gross   = numberFormat(0);
            var total_net   = numberFormat(0);
            var total_gross = numberFormat(0);


            $.each(itemWeight, function(key,val){
                if (val.item_code == itemCode) {
                    weight_id   = val.weight_id;
                    net_weight  = numberFormat(val.net_weight);
                    net_gross   = numberFormat(val.net_gross);
                    total_net   = parseFloat(val.net_weight) * parseFloat(orderQuantity);
                    total_gross = parseFloat(val.net_gross) * parseFloat(orderQuantity);

                }
            });

            $('#weight_id_'+index).val(weight_id);
            $('#net_'+index).val(net_weight);
            $('#gross_'+index).val(net_gross);
            $('#total_net_weight_'+index).val(total_net);
            $('#total_net_gross_'+index).val(total_gross);

            $('#text_net_'+index).html(numberFormat(net_weight));
            $('#text_gross_'+index).html(numberFormat(net_gross));
            $('#text_total_net_'+index).html(numberFormat(total_net));
            $('#text_total_gross_'+index).html(numberFormat(total_gross));


            var resultTotalNet      = 0;
            var resultTotalGross    = 0;

            $("input[name='order_line_manage[]']").each(function ()
            {
                var lineID          = parseInt($(this).val());

                total_net   = $('#total_net_weight_'+lineID).val() != '' ? parseFloat($('#total_net_weight_'+lineID).val()) : 0;
                total_gross = $('#total_net_gross_'+lineID).val() != '' ? parseFloat($('#total_net_gross_'+lineID).val()) : 0;

                resultTotalNet      = resultTotalNet + total_net;
                resultTotalGross    = resultTotalGross + total_gross;

            });

            var htmlTotalWeight = '';

            htmlTotalWeight += '<tr>';
            htmlTotalWeight += '    <td class="text-right black" colspan="14"><strong>Total Weight</strong></td>';
            htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalNet)+'</strong></td>';
            htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalGross)+'</strong></td>';
            htmlTotalWeight += '    <td class="text-right black"></td>';
            htmlTotalWeight += '</tr>';

            $('#orderLines').html(htmlTotalWeight);



        }else{
            $("#item_id_"+index).val('');
            $("#item_description_"+index).val('');
            $('#text_description_'+index).html('');

            $('#unit_price_'+index).val('0');
            $('#text_unit_price_'+index).val(numberFormat(0));
        }

        var orderQuantity   = $('#order_quantity_'+index).val();

        var amount = parseFloat(orderQuantity) * parseFloat(unitPrice);

        $('#line_amount_'+index).html(numberFormat(amount));
        $('#amount_'+index).val(amount);

        calculateOrderCreate(index);
    }

    function selectUomLines(index)
    {
        var uomCode = $("#uom_code_"+index).val();

        var priceListIDSelectbox  = $("#price_list_id").val();
        if(uomCode == '')
        {
            $("#uom_"+index).val('');
            $("#uom_id_"+index).val('');
            $("#uom_uom_"+index).val('');
            $('#text_uom_'+index).html('');

            $('#unit_price_'+index).val('0');
            $('#text_unit_price_'+index).val(numberFormat(0));

            $('#line_amount_'+index).html(numberFormat(0));
            $('#amount_'+index).val(0);

        }else if(uomCode != ''){

            var uomID = '';
            var uomKey = '';
            $.each(uomList, function(key,val){
                if (val.uom_code == uomCode) {
                    uomID = val.uom_id;
                    uomKey = val.description;
                }
            });

            if (uomID == '') {
                $("#uom_"+index).val('');
                $("#uom_id_"+index).val('');
                $("#uom_uom_"+index).val('');
                $('#text_uom_'+index).html('');

                $('#unit_price_'+index).val('0');
                $('#text_unit_price_'+index).val(numberFormat(0));

                $('#line_amount_'+index).html(numberFormat(0));
                $('#amount_'+index).val(0);
            }else{
                $("#uom_id_"+index).val(uomID);
                $("#uom_"+index).val(uomKey);
                $('#text_uom_'+index).html(uomKey);

                var customerNumber = $('#customer_number').val();
                $.each(customerList, function(key,val){
                    if (val.customer_number == customerNumber) {
                        if(priceListIDSelectbox == '') {
                            priceListID = val.price_list_id;
                        } else {
                            priceListID = priceListIDSelectbox;
                        }
                        previous    = val.price_list_id;
                    }
                });

                var itemID          = $('#item_id_'+index).val();
                var unitPrice       = 0;
                var operand         = 0;
                var productUomCode  = '';

                var conversationMain    = 0;
                var conversationSelect  = 0;

                if (itemID != '') {

                    $.each(priceListLine, function(key,val){
                        if (val.item_id == itemID && val.list_header_id == priceListID) {
                            operand = $.trim(val.operand);
                            productUomCode = $.trim(val.product_uom_code);
                        }
                    });

                    $.each(uomConversionsList, function(key,val){
                        if(val.uom_code == productUomCode){
                            conversationMain = $.trim(val.conversion_rate) != '' ? $.trim(val.conversion_rate) : 0;
                        }

                        if (val.uom_code == uomCode) {
                            conversationSelect = $.trim(val.conversion_rate) != '' ? $.trim(val.conversion_rate) : 0;
                        }
                    });
                }

                // console.log('Main : '+ conversationMain);
                // console.log('Select : '+ conversationSelect);
                // console.log('Operand : '+ operand);

                if (conversationMain <= 0) {
                    unitPrice = 0;
                }else{
                    unitPrice = (conversationSelect / conversationMain) * operand;
                }

                $('#unit_price_'+index).val(unitPrice);
                $('#text_unit_price_'+index).val(numberFormat(unitPrice));

                var orderQuantity   = $.trim($('#order_quantity_'+index).val()) != '' ? parseFloat($('#order_quantity_'+index).val()) : 0;
                var resultAmount    = orderQuantity * unitPrice;

                $('#line_amount_'+index).html(numberFormat(resultAmount));
                $('#amount_'+index).val(resultAmount);
            }
        }

        calculateOrderCreate(index);
    }

    function checkInputAmount(lineID)
    {
        var amount  = $('#order_quantity_'+lineID).val() != '' ? parseFloat($('#order_quantity_'+lineID).val()) : 0;
        var unitPrice   = $('#unit_price_'+lineID).val() != '' ? parseFloat($('#unit_price_'+lineID).val()) : 0;

        if(amount <= 0){
            $('#order_quantity_'+lineID).val('');
            amount = 0;
        }

        resultAmount    = amount * unitPrice;

        $('#line_amount_'+lineID).html(numberFormat(resultAmount));
        $('#amount_'+lineID).val(resultAmount);

        // ITEM WEIGHTS
        var itemCode = $("#item_code_"+lineID).val();

        var weight_id   = '';
        var net_weight  = $.trim($('#net_'+lineID).val());
        var net_gross   = $.trim($('#gross_'+lineID).val());
        var total_net   = parseFloat(net_weight) * parseFloat(amount);
        var total_gross = parseFloat(net_gross) * parseFloat(amount);


        $.each(itemWeight, function(key,val){
            if (val.item_code == itemCode) {
                weight_id   = val.weight_id;
                // net_weight  = parseFloat(val.net_weight);
                // net_gross   = parseFloat(val.net_gross);
                // total_net   = parseFloat(val.net_weight) * parseFloat(amount);
                // total_gross = parseFloat(val.net_gross) * parseFloat(amount);

            }
        });

        $('#weight_id_'+lineID).val(weight_id);
        $('#net_'+lineID).val(net_weight);
        $('#gross_'+lineID).val(net_gross);
        $('#total_net_weight_'+lineID).val(total_net);
        $('#total_net_gross_'+lineID).val(total_gross);

        // $('#text_net_'+lineID).html(numberFormat(net_weight));
        // $('#text_gross_'+lineID).html(numberFormat(net_gross));
        $('#text_total_net_'+lineID).html(numberFormat(total_net));
        $('#text_total_gross_'+lineID).html(numberFormat(total_gross));


        var resultTotalNet      = 0;
        var resultTotalGross    = 0;

        $("input[name='order_line_manage[]']").each(function ()
        {
            var index   = parseInt($(this).val());

            total_net   = $('#total_net_weight_'+index).val() != '' ? parseFloat($('#total_net_weight_'+index).val()) : 0;
            total_gross = $('#total_net_gross_'+index).val() != '' ? parseFloat($('#total_net_gross_'+index).val()) : 0;

            resultTotalNet      = resultTotalNet + total_net;
            resultTotalGross    = resultTotalGross + total_gross;

        });

        var htmlTotalWeight = '';

        htmlTotalWeight += '<tr>';
        htmlTotalWeight += '    <td class="text-right black" colspan="14"><strong>Total Weight</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalNet)+'</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalGross)+'</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"></td>';
        htmlTotalWeight += '</tr>';

        $('#orderLines').html(htmlTotalWeight);

        calculateOrderCreate(lineID);
    }

    function calculateOrderCreate(index)
    {
        var vatCode     = $('#sub_vat_'+index).val();
        var percenRate  = 0;

        $.each(taxCode, function(key,val){
            if (val.tax_rate_code == vatCode) {
                percenRate = parseFloat(val.percentage_rate);
            }
        });

        var orderQuantity   = $('#order_quantity_'+index).val() != '' ? parseFloat($('#order_quantity_'+index).val()) : 0;
        var unitPrice       = $('#unit_price_'+index).val() != '' ? parseFloat($('#unit_price_'+index).val()) : 0;
        var amount          = $('#amount_'+index).val() != '' ? parseFloat($('#amount_'+index).val()) : 0;

        var taxAmount       = (amount * percenRate) / 100;
        var lineAmount      = amount + taxAmount;

        $('#tax_amount_'+index).val(taxAmount);
        $('#total_amount_'+index).val(lineAmount);

        $('#line_tax_amount_'+index).html(numberFormat(taxAmount));
        $('#line_total_amount_'+index).html(numberFormat(lineAmount));

        var resultSubTotal  = 0;
        var resultTax       = 0;
        var resultTotal     = 0;

        var total_amount    = 0;
        var total_tax       = 0;
        var line_total      = 0;

        $("input[name='order_line_manage[]']").each(function ()
        {
            var lineID          = parseInt($(this).val());

            total_amount    = $('#amount_'+lineID).val() != '' ? parseFloat($('#amount_'+lineID).val()) : 0;
            total_tax       = $('#tax_amount_'+lineID).val() != '' ? parseFloat($('#tax_amount_'+lineID).val()) : 0;
            line_total      = $('#total_amount_'+lineID).val() != '' ? parseFloat($('#total_amount_'+lineID).val()) : 0;

            resultSubTotal      = resultSubTotal + total_amount;
            resultTax           = resultTax + total_tax;
            resultTotal         = resultTotal + line_total;

        });

        $('#order_sub_total').val(resultSubTotal);
        $('#order_tax').val(resultTax);
        $('#order_total').val(resultTotal);

        $('#resultSubtotal').html(numberFormat(resultSubTotal));
        $('#resultTax').html(numberFormat(resultTax));
        $('#resultTotal').html(numberFormat(resultTotal));
    }

    function deleteLines(trID, index)
    {
        $('#'+trID+''+index).remove();

        var resultSubTotal  = 0;
        var resultTax       = 0;
        var resultTotal     = 0;

        var total_amount    = 0;
        var total_tax       = 0;
        var line_total      = 0;
        var lineID          = 0;

        numberLine = 1;

        $("input[name='order_line_manage[]']").each(function ()
        {
            lineID          = parseInt($(this).val());

            total_amount    = $('#amount_'+lineID).val() != '' ? parseFloat($('#amount_'+lineID).val()) : 0;
            total_tax       = $('#tax_amount_'+lineID).val() != '' ? parseFloat($('#tax_amount_'+lineID).val()) : 0;
            line_total      = $('#total_amount_'+lineID).val() != '' ? parseFloat($('#total_amount_'+lineID).val()) : 0;

            resultSubTotal      = resultSubTotal + total_amount;
            resultTax           = resultTax + total_tax;
            resultTotal         = resultTotal + line_total;

            $('#number_line_'+lineID).html(numberLine);

            // console.log(lineID+ ' : ' + numberLine);

            numberLine += 1;

        });

        $('#order_sub_total').val(resultSubTotal);
        $('#order_tax').val(resultTax);
        $('#order_total').val(resultTotal);

        $('#resultSubtotal').html(numberFormat(resultSubTotal));
        $('#resultTax').html(numberFormat(resultTax));
        $('#resultTotal').html(numberFormat(resultTotal));

        var total_net           = 0;
        var total_gross         = 0;
        var resultTotalNet      = 0;
        var resultTotalGross    = 0;

        $("input[name='order_line_manage[]']").each(function ()
        {
            var orderIndex   = parseInt($(this).val());

            total_net   = $('#total_net_weight_'+orderIndex).val() != '' ? parseFloat($('#total_net_weight_'+orderIndex).val()) : 0;
            total_gross = $('#total_net_gross_'+orderIndex).val() != '' ? parseFloat($('#total_net_gross_'+orderIndex).val()) : 0;

            resultTotalNet      = resultTotalNet + total_net;
            resultTotalGross    = resultTotalGross + total_gross;

        });

        var htmlTotalWeight = '';

        htmlTotalWeight += '<tr>';
        htmlTotalWeight += '    <td class="text-right black" colspan="14"><strong>Total Weight</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalNet)+'</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalGross)+'</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"></td>';
        htmlTotalWeight += '</tr>';

        $('#orderLines').html(htmlTotalWeight);
    }

    function setSelectValue(index)
    {
        // console.log(index);
        var prepareOrderNumber  = $('#prepare_order_number').val();
        var orderNumber         = $("#order_number").val();
        var customerNumber      = $("#customer_number").val();

        var prepareSelect   = '';
        var orderSelect     = '';
        var customerSelect  = '';

        // if (index == 2 || index == 3) {
        // if (index == 3) {
            // PREPARE ORDER NUMBER
            var htmlPrepareList = '';

            $.each(saList, function(key, val){
                if($.trim(val.prepare_order_number) != ''){
                    if (prepareOrderNumber == val.prepare_order_number) {
                        prepareSelect   = 'selected';
                    }else{
                        prepareSelect   = '';
                    }

                    if (orderNumber == '' && customerNumber == '' && prepareOrderNumber == ''){
                        htmlPrepareList += '<option value="'+ val.prepare_order_number +'">'+ val.prepare_order_number +'</option>';
                    }

                    else if (orderNumber != '' && val.order_number == orderNumber){
                        htmlPrepareList += '<option '+prepareSelect+' value="'+ val.prepare_order_number +'">'+ val.prepare_order_number +'</option>';
                    }

                    else if (val.customer_number == customerNumber && customerNumber != '' && val.order_number != '') {
                        htmlPrepareList += '<option '+prepareSelect+' value="'+ val.prepare_order_number +'">'+ val.prepare_order_number +'</option>';
                    }
                }
            });

            $('#prepare-list').html(htmlPrepareList);
        // }


        // if (index == 1 || index == 3) {
        // if (index == 3) {
            // ORDER HEADERS
            var htmlOrderList = '';

            if (stepEvent == 'create') {
                $.each(orderList, function(key, val){
                    if($.trim(val.order_number) != '' && $.trim(val.prepare_order_number) == '' && val.order_status != 'Confirm'){
                        if (orderNumber == val.order_number) {
                            orderSelect   = 'selected';
                        }else{
                            orderSelect   = '';
                        }

                        if (prepareOrderNumber == '' && customerNumber == ''){
                            htmlOrderList += '<option value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if (val.customer_number == customerNumber && customerNumber != '' && prepareOrderNumber == '') {
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if (customerNumber == '' && val.prepare_order_number == prepareOrderNumber && prepareOrderNumber != '') {
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if (val.prepare_order_number == prepareOrderNumber && val.customer_number == customerNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }
                    }
                });

            }else if (prepareOrderNumber == '') {
                $.each(orderList, function(key, val){
                    if($.trim(val.order_number) != '' && val.order_status == 'Confirm'){
                        if (orderNumber == val.order_number) {
                            orderSelect   = 'selected';
                        }else{
                            orderSelect   = '';
                        }

                        if (prepareOrderNumber == '' && customerNumber == ''){
                            htmlOrderList += '<option value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if (val.customer_number == customerNumber && customerNumber != '' && prepareOrderNumber == '') {
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if (customerNumber == '' && val.prepare_order_number == prepareOrderNumber && prepareOrderNumber != '') {
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if (val.prepare_order_number == prepareOrderNumber && val.customer_number == customerNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }
                    }
                });

            }else{
                $.each(orderList, function(key, val){
                    if($.trim(val.order_number) != '' && val.order_status == 'Confirm'){
                        if (orderNumber == val.order_number) {
                            orderSelect   = 'selected';
                        }else{
                            orderSelect   = '';
                        }

                        if (customerNumber == '' && prepareOrderNumber == ''){
                            htmlOrderList += '<option value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if (val.prepare_order_number == prepareOrderNumber && customerNumber == '' && prepareOrderNumber != '') {
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if (val.prepare_order_number == prepareOrderNumber && val.customer_number == customerNumber){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }else if(val.customer_number == customerNumber && prepareOrderNumber == ''){
                            htmlOrderList += '<option '+orderSelect+' value="'+ val.order_number +'">'+ val.order_number +'</option>';
                        }

                    }
                });

            }
            $('#order-number-list').html(htmlOrderList);
        // }

        // console.log(prepareOrderNumber);
        // console.log(orderNumber);
        // console.log(customerNumber);

        // if (index == 1 || index == 2) {
            // CUSTOMERS
            var htmlCustomerList = '';
            checkCustomer = '';

            if (prepareOrderNumber == '' && orderNumber == ''){
                $.each(customerList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (customerNumber == '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }else if (val.customer_number == customerNumber && customerNumber != '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        }
                    }
                });
            }else if(prepareOrderNumber != ''){
                // console.log(prepareOrderNumber);
                // console.log(orderNumber);
                // console.log(customerNumber);
                $.each(saList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (customerNumber == val.customer_number) {
                            customerSelect   = 'selected';
                        }else{
                            customerSelect   = '';
                        }

                        if (checkCustomer == val.customer_number) {

                        }else if (prepareOrderNumber == val.prepare_order_number) {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
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
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                            checkCustomer = val.customer_number;
                        }
                    }
                });
            }else{
                $.each(orderList, function(key, val){
                    if($.trim(val.customer_number) != ''){
                        if (customerNumber == val.customer_number) {
                            customerSelect   = 'selected';
                        }else{
                            customerSelect   = '';
                        }

                        if (checkCustomer == val.customer_number) {

                        }else if (orderNumber == val.order_number && $.trim(val.order_number) != '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                            checkCustomer = val.customer_number;
                        }else if (prepareOrderNumber == val.prepare_order_number && $.trim(val.prepare_order_number) != '') {
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                            checkCustomer = val.customer_number;
                        }else if (val.customer_number == customerNumber && customerNumber != '') {
                            htmlCustomerList += '<option '+customerSelect+' value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                            checkCustomer = val.customer_number;
                        }else if (customerNumber == ''){
                            htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                            checkCustomer = val.customer_number;
                        }
                    }
                });
            }


            $('#customers-list').html(htmlCustomerList);
        // }
    }

    function changeUnitPrice(index)
    {
        var textUnitPrice   = $('#text_unit_price_'+index).val();

        var newText         = $.trim(textUnitPrice) <= 0 ? 0 : textUnitPrice.replace(/,/g, '');

        $('#text_unit_price_'+index).val(numberFormat(textUnitPrice));
        $('#unit_price_'+index).val(newText);

        checkInputAmount(index);
    }

    function newSearchData()
    {
        var newSearchPrepareOrderNumber = $('#prepare_order_number').val();
        var newSearchOrderNumber        = $('#order_number').val();

        if (newSearchPrepareOrderNumber == '' && newSearchOrderNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเลขที่ใบ SA หรือ เลขที่ใบสั่งซื้อ',
                showConfirmButton: true
            });
        }else{
            window.location = '{{ url('om/sale-confirmation') }}?prepare_order_number='+newSearchPrepareOrderNumber+'&order_number='+newSearchOrderNumber;
        }
    }

    function weightChange(index)
    {
        var amount  = $.trim($('#order_quantity_'+index).val()) != '' ? $.trim($('#order_quantity_'+index).val()) : 0;
        var net     = $.trim($('#net_'+index).val()) != '' ? $.trim($('#net_'+index).val()) : 0;
        var gross   = $.trim($('#gross_'+index).val()) != '' ? $.trim($('#gross_'+index).val()) : 0;

        net = net.replace(/,/g, '');
        gross = gross.replace(/,/g, '');

        console.log(net);
        console.log(gross);

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
        htmlTotalWeight += '    <td class="text-right black" colspan="14"><strong>Total Weight</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalNet)+'</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"><strong>'+numberFormat(resultTotalGross)+'</strong></td>';
        htmlTotalWeight += '    <td class="text-right black"></td>';
        htmlTotalWeight += '</tr>';

        $('#orderLines').html(htmlTotalWeight);
    }

    function ParseFloat(str,val = 2) {
        str = Math.round(str * 1000) / 1000;
        str = str.toString();
        str = str.slice(0, (str.indexOf(".")) + val + 1);
        return Number(str);
    }

    $("#price_list_id").focus(function () {
        // Store the current value on focus, before it changes
        previous = this.value;
    }).change(function() {
        // Do soomething with the previous value after the change

        if (previous != $('#price_list_id').val() && $("input[name='order_line_manage[]']").length > 0) {
            Swal.fire({
                title: 'หากเปลี่ยนแปลงข้อมูล Price list สินค้าจะหายไป',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `ยืนยัน`,
                denyButtonText: `ยกเลิก`,
            }).then((result) => {
                if (result.isConfirmed) {

                    previous = this.value;

                    var htmlLineWeight = '';
                    htmlLineWeight += '<tr>';
                    htmlLineWeight += '    <td class="text-right black" colspan="14"><strong>Total Weight</strong></td>';
                    htmlLineWeight += '    <td class="text-right black"><strong>'+ numberFormat(0) +'</strong></td>';
                    htmlLineWeight += '    <td class="text-right black"><strong>'+ numberFormat(0) +'</strong></td>';
                    htmlLineWeight += '</tr>';

                    $('#orderCreateLines').html('');
                    $('#orderLines').html(htmlLineWeight);
                    numberLine = 1;

                    Swal.fire('กรุณาสร้างรายการสินค้าและบันทึกอีกครั้งเพื่อเปลี่ยนแปลง!', '', 'success');

                } else if (result.isDenied) {
                    // Swal.fire('Changes are not saved', '', 'info');
                    $('#price_list_id').val(previous).trigger('change');
                }
            });
        }
    });

    function filterUOMCode(itemCode, index) {
        var productUomCode  = '';
        var operand         = 0;
        var baseUnitCode    = '';
        var htmlUOM         = '';

        if (itemCode != '') {
            $.each(sequenceEcoms, function(key,val){
                if (val.item_code == itemCode) {
                    productUomCode  = val.product_uom_code;
                    operand         = val.operand;
                }
            });

            $.each(uomConversionsList, function(key, val){
                if (val.uom_code == productUomCode) {
                    baseUnitCode = val.base_unit_code;
                }
            });

            $.each(uomConversionsList, function(key,val){
                if (val.uom_code != '' && val.base_unit_code == baseUnitCode) {
                    htmlUOM += '   <option value="'+val.uom_code+'">'+val.description+'</option>';
                }
            });

            $('#uom-list-'+index).html(htmlUOM);

        }else{
            $('#uom-list-'+index).html(htmlUOM);
        }
    }

    function linkToPagePrint(){
        var orderHeaderID = $('#order_header_id').val();

        if (orderHeaderID > 0) {
            var url = "{{ url('om/sale-confirmation/print') }}?order_header_id="+orderHeaderID;
            var myWindow = window.open(url, "_blank");
        }else{
            return false;
        }
    }

    function generateSaleConfirmDate(date)
    {
        $('#html_create_sale_confirm_date').html('<div id="mount_create_sale_confirm_date"></div><input type="hidden" name="create_sale_confirm_date" id="create_sale_confirm_date" />');
        fieldName   = 'create_sale_confirm_date';
        fieldID     = 'create_sale_confirm_date';
        fieldValue  = date;
        mountID     = 'mount_create_sale_confirm_date';
        generateDatePickerTH(mountID);
    }

    function checkCopyToPI(){
        // var orderHeaderID = $('#order_header_id').val();
        // var paymentTypeCode = $('#payment_type_code').val();

        // if (paymentTypeCode != 10) {
            $('#copyToPIModal').modal('show');
        // }else{
        //     Swal.fire({
        //         title:"",
        //         text:"Checking...",
        //         showConfirmButton: false,
        //         allowOutsideClick: false,
        //         //icon: "success"
        //     });
        //     $.ajax({
        //         url : `{{ url("om/ajax/sale-confirmation/check-outstanding-debt") }}/`+orderHeaderID,
        //         success : function(res){
        //             if (res.data.status == 'success') {
        //                 Swal.close();
        //                 $('#copyToPIModal').modal('show');
        //             }else{
        //                 Swal.fire({
        //                     title: '',
        //                     text: 'กรุณาทำการชำระเงิน ใบ Sale Confirmation ใบนี้ก่อน!',
        //                     icon: 'warning'
        //                 });
        //             }
        //         }

        //     });

        // }
    }

    function generateSaDate(date, status = false)
    {
        $('#html_sa_date').html('<div id="mount_sa_date"></div>');
        fieldName   = 'sa_date';
        fieldID     = 'sa_date';
        fieldValue  = date;
        mountID     = 'mount_sa_date';
        disabled    = status;
        generateDatePickerTH(mountID);
    }

    function generateOrderDate(date, status = false)
    {
        $('#html_order_date').html('<div id="mount_order_date"></div>');
        fieldName   = 'order_date';
        fieldID     = 'order_date';
        fieldValue  = date;
        mountID     = 'mount_order_date';
        disabled    = status;
        generateDatePickerTH(mountID);
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
            mounted() {
                // subDate = fieldValue.split('/');
                // this.pValue = new Date(subDate[2],subDate[1], subDate[0]);
                // console.log(  subDate)
                $('#create_sale_confirm_date').val(fieldValue)

            },
            // template: `<datepicker-th
            //                 style="width: 100%"
            //                 class="form-control md:tw-mb-0 tw-mb-2"
            //                 :name=pName
            //                 :id=pID
            //                 placeholder=""
            //                 @dateWasSelected='onchangeDate(...arguments)'
            //                 :value=pValue
            //                 :format=pFormat />`,
            template: `<><el-date-picker
                            v-model="pValue"
                            format="dd/MM/yyyy"
                            type="date"
                            @change="onchangeDate"
                            :clearable="false"
                            value-format="dd/MM/yyyy"
                            prefix-icon="-"
                            placeholder="">
                            </el-date-picker></>`,
            methods: {
                onchangeDate (date) {
                    vm.pValue = date;
                    $('#create_sale_confirm_date').val(vm.pValue)
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
