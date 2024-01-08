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

@section('title', 'บันทึก Invoice, Tax Invoice')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <x-get-page-title :menu="$menu" url="" />
    {{-- <h2>
        OMP0073 บันทึก Invoice, Tax Invoice
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>บันทึก Invoice, Tax Invoice</strong>
        </li>
    </ol> --}}
@stop

@section('content')

    <form id="formTaxInvoice" autocomplete="none" enctype="multipart/form-data">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ !empty($menu->menu_title) ? $menu->menu_title : '' }}</h3>
            </div>
            <div class="ibox-content">
                <div class="row space-50 justify-content-md-center flex-column mt-md-4">
                    <div class="col-12">
                        <div class="form-header-buttons">
                            <div class="d-flex">
                                <button class="btn btn-md btn-white" type="button" onclick="newClearTaxInvoice()"><i class="fa fa-repeat"></i></button>
                                {{-- <button class="btn btn-md btn-white" type="button" onclick="clearTaxInvoice()"><i class="fa fa-repeat"></i></button> --}}
                            </div>
                            <div class="buttons multiple">
                                <button class="btn btn-md btn-success" type="button" onclick="createTaxInvoice()"><i class="fa fa-plus"></i> สร้าง</button>
                                {{-- <button class="btn btn-md btn-white" type="button" onclick="searchTaxInvoice()"><i class="fa fa-search"></i> ค้นหา</button> --}}
                                <button class="btn btn-md btn-white" type="button" onclick="newSearchTaxInvoice()"><i class="fa fa-search"></i> ค้นหา</button>
                                <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                                <div class="dropdown">
                                    <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);" onclick="manageTaxInvoice('Draft')">บันทึก</a></li>
                                        <li><a href="javascript:void(0);" onclick="manageTaxInvoice('Confirm')">ยืนยัน</a></li>
                                        <li><a href="javascript:void(0);" onclick="showCancelInvoice()">ยกเลิก</a></li>
                                        <li><a href="javascript:void(0);" onclick="linkToPagePrintInvoice()">พิมพ์ Invoice</a></li>
                                        <li><a href="javascript:void(0);" onclick="linkToPagePrintPackingList()">พิมพ์ Packing List</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-md btn-danger" type="button" onclick="closeTaxInvoice()"><i class="fa fa-times"></i> ปิดงาน</button>
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
                                            <label class="d-block"><strong>Order Status</strong></label>
                                            <input type="text" class="form-control" readonly name="pick_release_status" id="pick_release_status" value="Draft">
                                            <input type="hidden" name="pi_header_id" id="pi_header_id" value="">
                                            <input type="hidden" name="sa_number" id="sa_number" value="">
                                            <input type="hidden" name="order_header_id" id="order_header_id" value="">
                                            <input type="hidden" name="customer_id" id="customer_id" value="">
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
                                            {{-- <label class="d-block">เลขที่ Invoice</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control" readonly name="pick_release_no" id="pick_release_no" value="">
                                            </div> --}}

                                            <label class="d-block">เลขที่ใบ Invoice</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control" name="pick_release_no" id="pick_release_no" list="pick-release-list" value="{{ request()->pick_release_no }}" onchange="selectPickReleaseNo()" autocomplete="off">
                                                <i class="fa fa-search"></i>
                                                <datalist id="pick-release-list">

                                                    <option value=""> &nbsp; </option>
                                                    @foreach ($invoiceList as $item)
                                                    @if (!empty($item->pick_release_no))
                                                    <option value="{{ $item->pick_release_no }}">{{ $item->pick_release_no }}</option>
                                                    @endif
                                                    @endforeach

                                                </datalist>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="d-block">วันที่</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control date" name="pick_release_approve_date" id="pick_release_approve_date" value="" autocomplete="off">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div><!--form-group-->
                            </div>

                            <div class="col-xl-7">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="d-block">เลขที่ใบ PI</label>
                                            {{-- <input type="text" class="form-control" readonly name="pi_number" id="pi_number" value=""> --}}
                                            <div class="input-icon">
                                                <input type="text" class="form-control" name="pi_number" id="pi_number" list="proforma-list" value="{{ request()->pi_number }}" onchange="checkOutstandingDebt()" autocomplete="off">
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
                                        <div class="col-md-4 mt-3 mt-md-0">
                                            <label class="d-block">วันที่ใบ PI</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control" readonly name="pi_date" id="pi_date" value="" autocomplete="off">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3 mt-md-0">
                                            <label class="d-block">Customer PO</label>
                                            <input type="text" class="form-control" readonly name="cust_po_number" id="cust_po_number" value="" autocomplete="off">
                                        </div>
                                    </div><!--row-->
                                </div><!--form-group-->
                            </div>

                            <!--//-->
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="d-block">ชื่อลูกค้า <span class="red">*</span></label>
                                    <div class="row space-5">
                                        <div class="col-md-4">
                                            {{-- <input type="text" class="form-control" readonly  name="customer_number" id="customer_number" value=""> --}}
                                            <div class="input-icon">
                                                <input type="text" class="form-control" name="customer_number" id="customer_number" list="customers-list" value="" onchange="selectCustomer()" autocomplete="off">
                                                <i class="fa fa-search"></i>
                                                <datalist id="customers-list">

                                                    <option value=""> &nbsp; </option>
                                                    @php
                                                        $checkCustomerNumber = '';
                                                    @endphp
                                                    @foreach ($customerList as $item)
                                                    @if (!empty($item->customer_number) && $checkCustomerNumber != $item->customer_number)
                                                    <option value="{{ $item->customer_number }}">{{ $item->customer_name }}</option>
                                                    @php
                                                        $checkCustomerNumber = $item->customer_number;
                                                    @endphp
                                                    @endif
                                                    @endforeach

                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-2 mt-md-0">
                                            <input type="text" class="form-control" readonly name="customer_name" id="customer_name" value="" autocomplete="off">
                                        </div>
                                    </div><!--row-->
                                </div>
                            </div><!--col-->


                            <div class="col-xl-8">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="d-block">Order Type <span class="red">*</span></label>
                                            <input type="text" class="form-control" name="order_type_id" id="order_type_id" value="" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="d-block">สกุลเงิน <span class="red">*</span></label>
                                            <div class="row space-5">
                                                <div class="col-6">
                                                    <input type="text" class="form-control bold" readonly  name="currency" id="currency" value="" autocomplete="off">
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" readonly name="currency_name" id="currency_name" value="" autocomplete="off">
                                                </div>
                                            </div><!--row-->
                                        </div><!--form-group-->
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="d-block">Exchange Rate (Status 0409) </label>
                                            <input type="text" class="form-control" name="exchange_rate" id="exchange_rate" value="" onkeypress="return isNumber(this, event)">
                                        </div><!--form-group-->
                                    </div>
                                </div><!--row-->
                            </div><!--col-md-4-->


                            <div class="col-lg-12"></div>

                            <!--//-->

                            <div class="col-xl-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">ที่อยู่</label>
                                    <textarea class="form-control" name="customer_address" id="customer_address" readonly autocomplete="off"></textarea>
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
                                            <select class="custom-select check-default" name="vat_code" id="vat_code">
                                                <option value=""> &nbsp; </option>
                                                @foreach ($taxCode as $item)
                                                <option value="{{ $item->tax_rate_code }}">{{ $item->tax_rate_code }}</option>
                                                @endforeach
                                            </select>
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
                                    <textarea name="remark" id="remark" class="form-control" autocomplete="off"></textarea>
                                </div>

                            </div><!--col-xl-4-->

                            <div class="col-xl-8 col-md-6">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Bill To <span class="red">*</span></label>
                                            <input type="hidden" name="bill_to_site_id" id="bill_to_site_id" value="" autocomplete="off">
                                            <input type="text" class="form-control" name="bill_to_site_name" id="bill_to_site_name" value="" autocomplete="off">
                                        </div>
                                    </div><!--col-md-6-->

                                    {{-- <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Salesperson</label>
                                            <input type="text" class="form-control" readonly name="" value="ABC">
                                        </div>
                                    </div><!--col-md-6--> --}}

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Price List <span class="red">*</span></label>
                                            <input type="text" class="form-control" readonly name="price_list_id" id="price_list_id" value="" autocomplete="off">
                                            {{-- <select class="custom-select check-default" name="price_list_id" id="price_list_id" autocomplete="off">
                                                <option value=""> &nbsp; </option>
                                                @foreach ($priceList as $item)
                                                <option value="{{ $item->list_header_id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select> --}}
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Ship To <span class="red">*</span></label>
                                            <select class="custom-select check-default" name="ship_to_site_id" id="ship_to_site_id">
                                                <option value=""> &nbsp; </option>
                                            </select>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block"> {{ !empty($inCortermName) ? $inCortermName : '' }} <span class="red">*</span></label>
                                            {{-- <input type="text" class="form-control" name="incoterms_code" id="incoterms_code" value="" autocomplete="off"> --}}
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
                                            <input type="text" class="form-control" name="port_of_loading" id="port_of_loading" value="" autocomplete="off">
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
                                            <input type="text" class="form-control" name="port_of_discharge" id="port_of_discharge" value="" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">Place of Delivery by On-Carrier</label>
                                            <input type="text" class="form-control" name="place_of_delivery" id="place_of_delivery" value="" autocomplete="off">
                                        </div><!--form-group-->
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">Shipping Marks</label>
                                            {{-- <input type="text" class="form-control" readonly name="shipping_marks" id="shipping_marks" value="" autocomplete="off"> --}}
                                            <textarea name="shipping_marks" id="shipping_marks" class="form-control" autocomplete="off"></textarea>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">เงื่อนไขการขนส่ง</label>
                                            <input type="text" class="form-control" name="shipment_condition" id="shipment_condition" value="" autocomplete="off">
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">สั่งทาง</label>
                                            {{-- <input type="text" class="form-control" name="source_system" id="source_system" value="" autocomplete="off"> --}}
                                            <select class="custom-select check-default" name="source_system" id="source_system">
                                                <option value=""> &nbsp; </option>
                                                @foreach ($salesChannel as $item)
                                                <option value="{{ $item->meaning }}">{{ $item->meaning }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">วันที่ออกจาก ยสท.</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control date" name="delivery_date" id="delivery_date" value="" autocomplete="off">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block">อัตราแลกเปลี่ยน (ตามวันที่ในใบขน)</label>
                                            <input type="text" class="form-control" readonly name="pick_exchange_rate" id="pick_exchange_rate" value="" autocomplete="off">
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group mt-xl-4">
                                            <div class="i-checks" id="check_forward_flag"><label><input type="checkbox" name="forward_flag" id="forward_flag"><span>รับรองการส่งออกที่ Web Site กรมสรรพสามิตแล้ว</span></label></div>
                                        </div>
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="d-block"> วันที่ในใบขน (Status 0409) </label>
                                            <input type="text" class="form-control" readonly name="pick_exchange_date" id="pick_exchange_date" value="" autocomplete="off">
                                        </div>
                                    </div><!--col-md-6-->
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
                                        <th rowspan="2">รายการที่</th>
                                        <th rowspan="2">รหัสสินค้า</th>
                                        <th rowspan="2" class="w-250">ชื่อผลิตภัณฑ์</th>
                                        <th rowspan="2">UOM</th>
                                        <th rowspan="2">หน่วยนับ</th>
                                        <th rowspan="2">จำนวน</th>
                                        <th rowspan="2">ราคา/หน่วย</th>
                                        <th rowspan="2">Amount</th>
                                        <th rowspan="2">Vat Code</th>
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
                                            <th rowspan="2" class="w-230">Subinventory</th>
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
                                        <td id="resultSubtotal">0.00</td>
                                    </tr>
                                    <tr>
                                        <th>Tax</th>
                                        <td id="resultTax">0.00</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td id="resultTotal">0.00</td>
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
                        <h3>ยกเลิกใบ Invoice, Tax Invoice </h3>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <div class="attachment-box">

                                <div class="col-xl-10 m-auto">

                                    <form id="formSearchConsignment" autocomplete="none" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เหตุผลที่ยกเลิก</label> <textarea name="invoice_cancel_reason" id="invoice_cancel_reason" class="form-control"></textarea>
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
                        <button class="btn btn-primary btn-lg" type="button" onclick="cancelTaxInvoice()">
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
        $('.date').datepicker({ format: 'dd/mm/yyyy' });

        $('.custom-select').select2({width: "100%"});

        setDefaultInput(1);

        $searchPickReleaseNo    = $('#pick_release_no').val();
        $searchPiNumber         = $('#pi_number').val();

        if ($searchPickReleaseNo != '' || $searchPiNumber != '') {
            searchTaxInvoice();
        }
    });

</script>

<script>

    var invoiceList     = @json($invoiceList);
    var proformaList    = @json($proformaList);
    var customerList    = @json($customerList);
    let currencyList    = {!! json_encode($currency) !!};
    let priceList       = {!! json_encode($priceList) !!};
    let priceListLine   = {!! json_encode($priceListLine) !!};
    var termList        = @json($terms);
    var taxList         = [];
    var resultAmount    = 0.00;
    var dataOrgList     = [];
    var dataLotList     = [];
    var stepEvent       = '';
    var selectLineID    = '';

    // SET INVOIC DATA FOR SEARCH
    var invoiceData     = [];
    var optionsOrder    = [];

    // SET PICK RELEASE NO FOR SEARCH
    var dataList        = [];
    var options         = [];

    var html            = '';
    var roll            = 0;

    // console.log(optionsOrder);
    function createTaxInvoice()
    {
        // var invoiceNo       = $('#pick_release_no').val();
        // var piNumber        = $('#pi_number').val();
        // var customerNumber  = $('#customer_number').val();

        // if(piNumber == ''){
        //     Swal.fire({
        //         title: 'แจ้งเตือน',
        //         text: 'กรุณาเลือกเลขที่ใบ PI ที่ต้องการสร้าง',
        //         icon: 'warning'
        //     });
        // }else if (invoiceNo != '') {
        //     Swal.fire({
        //         title: 'แจ้งเตือน',
        //         text: 'ไม่สามารถสร้างรายการที่มีเลข Invoice ได้แล้ว',
        //         icon: 'warning'
        //     });
        // }else{

        var d           = new Date();
        var dayNow      = d.getDate();
        var monthNow    = ("0"+(d.getMonth()+1)).slice(-2);
        var yearNow     = d.getFullYear();
        let dateNow = dayNow + "/" + monthNow + "/" + yearNow;

        $('#pick_release_approve_date').val(dateNow);

        // $("#pick_release_approve_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dateNow);
            clearTaxInvoice()

            $('#pick_release_no').prop('readonly', true);
            stepEvent = 'create';

            setSelectValue(3);


        // }

    }

    function searchCreate()
    {
        Swal.showLoading();

        const formData = new FormData(document.getElementById("formTaxInvoice"));
        formData.append('_token','{{ csrf_token() }}');

        $.ajax({
            url         : '{{ url("om/ajax/tax-invoice-export/create") }}',
            type        : 'post',
            data        : formData,
            cache       : false,
            processData : false,
            contentType : false,
            success     : function(res){
                var dataOrder = res.data.data;
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

                    // if(dataOrder.pick_release_approve_date == '' || dataOrder.pick_release_approve_date == null){
                    //     var date = new Date();
                    //     var month = (date.getMonth()+1);
                    //     var day = date.getDate();
                    //     dataOrder.pick_release_approve_date = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + date.getFullYear();
                    // }

                    $('#order_header_id').val(dataOrder.order_header_id);
                    $('#product_type_code').val(dataOrder.product_type_code);
                    $('#pick_release_no').val(dataOrder.pick_release_no);
                    $('#pick_release_status').val(dataOrder.pick_release_status);
                    $("#pick_release_approve_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dataOrder.pick_release_approve_date);
                    // $("#pick_release_approve_date").val(dataOrder.pick_release_approve_date);
                    $('#pi_header_id').val(dataOrder.pi_header_id);
                    $('#pi_number').val(dataOrder.pi_number);
                    // $("#pi_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dataOrder.pi_date);
                    $("#pi_date").val(dataOrder.pi_date);
                    $('#sa_number').val(dataOrder.sa_number);
                    $('#sa_date').val(dataOrder.sa_date);
                    $('#customer_id').val(dataOrder.customer_id);
                    $('#cust_po_number').val(dataOrder.cust_po_number);
                    $('#customer_number').val(dataOrder.customer_number);
                    $('#customer_name').val(dataOrder.customer_name);
                    $('#order_type_id').val(dataOrder.order_type_id);
                    $('#currency').val(dataOrder.currency);
                    $('#currency_name').val(dataOrder.currency_name);
                    $('#customer_address').val(dataOrder.customer_address);
                    $('#term_id').val(dataOrder.term_id);
                    $('#term_name').val(dataOrder.term_name);
                    $('#term_description').val(dataOrder.term_description);
                    // $('#payment_type_code').val(dataOrder.payment_type_code);
                    $('#payment_type_code').val(dataOrder.payment_type_code).trigger('change');
                    // $('#vat_code').val(dataOrder.vat_code);
                    $('#vat_code').val(dataOrder.vat_code).trigger('change');
                    // $('#payment_method_code').val(dataOrder.payment_method_code);
                    $('#payment_method_code').val(dataOrder.payment_method_code).trigger('change');
                    $('#vat_code').val(dataOrder.vat_code);
                    $('#payment_method_code').val(dataOrder.payment_method_code);
                    $('#remark').val(dataOrder.remark);
                    $('#bill_to_site_id').val(dataOrder.bill_to_site_id);
                    $('#bill_to_site_name').val(dataOrder.bill_to_site_name);
                    $('#price_list_id').val(dataOrder.price_list_id);
                    $('#ship_to_site_id').val(dataOrder.ship_to_site_id);
                    $('#port_of_loading').val(dataOrder.port_of_loading);
                    $('#port_of_discharge').val(dataOrder.port_of_discharge);
                    $('#place_of_delivery').val(dataOrder.place_of_delivery);
                    // $('#incoterms_code').val(dataOrder.incoterms_code);
                    $('#incoterms_code').val(dataOrder.incoterms_code).trigger('change');
                    $('#transport_type_code').val(dataOrder.transport_type_code).trigger('change');
                    $('#transport_detail').val(dataOrder.transport_detail);
                    $('#shipment_condition').val(dataOrder.shipment_condition);
                    $('#shipping_marks').val(dataOrder.shipping_marks);
                    $('#source_system').val(dataOrder.source_system);
                    $("#delivery_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dataOrder.delivery_date);
                    $("#pick_exchange_date").val(dataOrder.pick_exchange_date);
                    $('#pick_exchange_rate').val(dataOrder.pick_exchange_rate);
                    $('#exchange_rate').val(dataOrder.exchange_rate);


                    // ORDER LINES
                    var orderLine = res.data.orderLine;
                    var htmlLine = '';
                    var htmlCopyToPI = '';
                    var num = 1;
                    var checkSelectVat = '';
                    var piBalance = 0;
                    var trActive = '';
                    var lineID  = 0;
                    $.each(orderLine, function(key,val){
                        if (key == 0) {
                            trActive = 'active';
                            lineID = val.pi_line_id;
                        }else{
                            trActive = '';
                        }

                        htmlLine += '<tr id="tr_line_'+val.pi_line_id+'" class="clickable-row '+trActive+'" onclick="selectLinesRow('+val.pi_line_id+')">';
                        // htmlLine += '    <td>';
                        // htmlLine += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" class="check" name="select_order_line['+val.pi_line_id+']"></label></div>';
                        // htmlLine += '    </td>';
                        htmlLine += '    <td>'+ num +' <input type="hidden" name="pi_line_id['+val.pi_line_id+']" id="pi_line_id_'+val.pi_line_id+'" value="'+val.pi_line_id+'"></td>';
                        htmlLine += '    <td>'+val.item_code+'</td>';
                        htmlLine += '    <td class="text-left">'+val.item_description+'</td>';
                        htmlLine += '    <td>'+val.uom_code+'</td>';
                        htmlLine += '    <td>'+val.uom+'</td>';
                        htmlLine += '    <td>'+numberFormat(val.order_quantity)+'</td>';
                        htmlLine += '    <td class="text-right">'+numberFormat(val.unit_price)+'</td>';
                        htmlLine += '    <td class="text-right">'+numberFormat(val.amount)+'</td>';
                        htmlLine += '    <td>'+val.vat_code+'</td>';
                        htmlLine += '    <td class="text-right">'+numberFormat(val.tax_amount)+'</td>';
                        htmlLine += '    <td class="text-right">'+numberFormat(val.total_amount)+'</td>';
                        htmlLine += '    <td class="text-right">'+numberFormat(val.net_weight)+' <input type="hidden" name="net_weight['+val.pi_line_id+']" value="'+val.net_weight+'" /> </td>';
                        htmlLine += '    <td class="text-right">'+numberFormat(val.net_gross)+' <input type="hidden" name="net_gross['+val.pi_line_id+']" value="'+val.net_gross+'" /> </td>';
                        htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_weight)+' <input type="hidden" name="total_net_weight['+val.pi_line_id+']" value="'+val.total_net_weight+'" /> </td>';
                        htmlLine += '    <td class="text-right">'+numberFormat(val.total_net_gross)+' <input type="hidden" name="total_net_gross['+val.pi_line_id+']" value="'+val.total_net_gross+'" /> </td>';
                        htmlLine += '</tr>';

                        num++;
                    });

                    var resultWeights = res.data.resultWeights;
                    var htmlLineTotal = '';
                    htmlLineTotal += '<tr>';
                    htmlLineTotal += '    <td class="text-right black" colspan="13"><strong>Total Weight</strong></td>';
                    htmlLineTotal += '    <td class="text-right black"><strong>'+ numberFormat(resultWeights.result_net_weight) +'</strong></td>';
                    htmlLineTotal += '    <td class="text-right black"><strong>'+ numberFormat(resultWeights.result_gross_weight) +'</strong></td>';
                    htmlLineTotal += '</tr>';

                    $('#orderLines').html(htmlLine);
                    $('#orderLinesTotal').html(htmlLineTotal);

                    // ORDER LOTS

                    selectLinesRow(lineID);

                    $('#resultSubtotal').html(numberFormat(resultWeights.result_sub_total));
                    $('#resultTax').html(numberFormat(resultWeights.result_tax));
                    $('#resultTotal').html(numberFormat(resultWeights.result_total));

                    setAttachment(res.data.attachmentFile);

                    $('.check').iCheck({
                        checkboxClass: 'icheckbox_square-green'
                    });

                    $('.custom-select').select2({width: "100%"});

                    // $('.custom-select').select2({width: "100%"});

                    setDefaultInput(0);
                    Swal.close();

                    // Swal.fire({
                    //     title: 'สำเร็จ',
                    //     text: 'สร้างใบ Invoice, Tax Invoice เรียบร้อยแล้ว',
                    //     icon: 'success',
                    //     showConfirmButton: false,
                    //     timer: 2500
                    // });

                }else if(res.data.status == 'created'){
                    Swal.fire({
                        title: 'ผิดพลาด',
                        text: 'เลขที่ใบ PI นี้ถูกสร้างเลขที่ Invoice, Tax Invoice แล้ว',
                        icon: 'error'
                    });
                }else{
                    Swal.fire({
                        title: 'ผิดพลาด',
                        text: 'ไม่สามารถสร้างใบ Invoice, Tax Invoice ได้',
                        icon: 'error'
                    });
                }
            }
        });
    }

    function newSearchTaxInvoice()
    {
        var newPickReleaseNo = $('#pick_release_no').val();
        var newPiNumber        = $('#pi_number').val();

        if (newPickReleaseNo == '' && newPiNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเลขที่ใบ Invoice หรือ เลขที่ใบ PI',
                showConfirmButton: true
            });
        }else{
            window.location = '{{ url('om/tax-invoice-export') }}?pick_release_no='+newPickReleaseNo+'&pi_number='+newPiNumber;
        }
    }

    function searchTaxInvoice()
    {
        var invoiceNo       = $('#pick_release_no').val();
        var piNumber        = $('#pi_number').val();
        var customerNumber  = $('#customer_number').val();

        if (invoiceNo == '' && piNumber == '') {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'กรุณาเลือกเลขที่ Invoice หรือ เลขที่ Pi',
                icon: 'warning'
            });
        }else{

            // swal.showLoading();

            const formData = new FormData(document.getElementById("formTaxInvoice"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/tax-invoice-export/search") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    var dataOrder = res.data.data;
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

                        // if(dataOrder.pick_release_approve_date == '' || dataOrder.pick_release_approve_date == null){
                        //     var date = new Date();
                        //     var month = (date.getMonth()+1);
                        //     var day = date.getDate();
                        //     dataOrder.pick_release_approve_date = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + date.getFullYear();
                        // }

                        $('#order_header_id').val(dataOrder.order_header_id);
                        $('#product_type_code').val(dataOrder.product_type_code);
                        $('#pick_release_no').val(dataOrder.pick_release_no);
                        $('#pick_release_status').val(dataOrder.pick_release_status);
                        $("#pick_release_approve_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dataOrder.pick_release_approve_date);

                        if (dataOrder.pick_release_status == 'Confirm') {
                            $('#pick_release_approve_date').prop('readonly', true);
                        } else {
                            $('#pick_release_approve_date').prop('readonly', false);
                        }
                        // $("#pick_release_approve_date").val(dataOrder.pick_release_approve_date);
                        $('#pi_header_id').val(dataOrder.pi_header_id);
                        $('#pi_number').val(dataOrder.pi_number);
                        // $("#pi_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dataOrder.pi_date);
                        $("#pi_date").val(dataOrder.pi_date);
                        $('#sa_number').val(dataOrder.sa_number);
                        $('#sa_date').val(dataOrder.sa_date);
                        // $('#pick_release_approve_date').val(dataOrder.pick_release_approve_date);
                        $('#customer_id').val(dataOrder.customer_id);
                        $('#cust_po_number').val(dataOrder.cust_po_number);
                        $('#customer_number').val(dataOrder.customer_number);
                        $('#customer_name').val(dataOrder.customer_name);
                        $('#order_type_id').val(dataOrder.order_type_id);
                        $('#currency').val(dataOrder.currency);
                        $('#currency_name').val(dataOrder.currency_name);
                        $('#customer_address').val(dataOrder.customer_address);
                        $('#term_id').val(dataOrder.term_id);
                        $('#term_name').val(dataOrder.term_name);
                        $('#term_description').val(dataOrder.term_description);
                        // $('#payment_type_code').val(dataOrder.payment_type_code);
                        $('#payment_type_code').val(dataOrder.payment_type_code).trigger('change');
                        // $('#vat_code').val(dataOrder.vat_code);
                        $('#vat_code').val(dataOrder.vat_code).trigger('change');
                        // $('#payment_method_code').val(dataOrder.payment_method_code);
                        $('#payment_method_code').val(dataOrder.payment_method_code).trigger('change');
                        $('#remark').val(dataOrder.remark);
                        $('#bill_to_site_id').val(dataOrder.bill_to_site_id);
                        $('#bill_to_site_name').val(dataOrder.bill_to_site_name);
                        $('#price_list_id').val(dataOrder.price_list_id);
                        $('#ship_to_site_id').val(dataOrder.ship_to_site_id);
                        $('#port_of_loading').val(dataOrder.port_of_loading);
                        $('#port_of_discharge').val(dataOrder.port_of_discharge);
                        $('#place_of_delivery').val(dataOrder.place_of_delivery);
                        // $('#incoterms_code').val(dataOrder.incoterms_code);
                        $('#incoterms_code').val(dataOrder.incoterms_code).trigger('change');
                        $('#transport_type_code').val(dataOrder.transport_type_code).trigger('change');
                        $('#transport_detail').val(dataOrder.transport_detail);
                        $('#shipment_condition').val(dataOrder.shipment_condition);
                        $('#shipping_marks').val(dataOrder.shipping_marks);
                        $('#source_system').val(dataOrder.source_system);
                        $("#delivery_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dataOrder.delivery_date);
                        $("#pick_exchange_date").val(dataOrder.pick_exchange_date);
                        $('#pick_exchange_rate').val(dataOrder.pick_exchange_rate);
                        $('#exchange_rate').val(dataOrder.exchange_rate);

                        if (dataOrder.forward_flag == 'Y') {
                            $('#check_forward_flag').iCheck('check');
                        }

                        if (dataOrder.pick_release_status == 'Confirm') {
                            setDefaultInput(1);
                        }else{
                            setDefaultInput(0);
                        }


                        // ORDER LINES
                        var orderLine = res.data.orderLine;
                        var htmlLine = '';
                        var htmlCopyToPI = '';
                        var num = 1;
                        var checkSelectVat = '';
                        var piBalance = 0;
                        var trActive = '';
                        var lineID      = 0;
                        $.each(orderLine, function(key,val){
                            if (key == 0) {
                                trActive = 'active';
                                $('#main_lot_pi_line_id').val(val.pi_line_id);
                                lineID = val.pi_line_id;
                            }else{
                                trActive = '';
                            }

                            htmlLine += '<tr id="tr_line_'+val.pi_line_id+'" class="clickable-row '+trActive+'">';
                            // htmlLine += '    <td>';
                            // htmlLine += '        <div class="i-checks wihtout-text m-auto"><label><input type="checkbox" class="check" name="select_order_line['+val.pi_line_id+']"></label></div>';
                            // htmlLine += '    </td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+ num +' <input type="hidden" name="pi_line_id['+val.pi_line_id+']" id="pi_line_id_'+val.pi_line_id+'" value="'+val.pi_line_id+'"></td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+val.item_code+' <input type="hidden" name="order_line_manage[]" id="order_line_manage_'+val.pi_line_id+'" value="'+val.pi_line_id+'" autocomplete="off" > </td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')" class="text-left">'+val.item_description+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+val.uom_code+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+val.uom+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+numberFormat(val.order_quantity)+' <input type="hidden" name="order_quantity['+val.pi_line_id+']" id="order_quantity_'+val.pi_line_id+'" value="'+val.order_quantity+'" autocomplete="off" ></td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')" class="text-right">'+numberFormat(val.unit_price)+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')" class="text-right">'+numberFormat(val.amount)+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')">'+val.vat_code+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')" class="text-right">'+numberFormat(val.tax_amount)+'</td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')" class="text-right">'+numberFormat(val.total_amount)+'</td>';
                            htmlLine += '    <td class="text-right"><input type="text" class="form-control weight-input" name="net_weight['+val.pi_line_id+']" id="net_weight_'+val.pi_line_id+'" value="'+numberFormat(val.net_weight)+'" onchange="weightChange('+val.pi_line_id+')"  onkeypress="return isNumber(this, event)" autocomplete="off"> </td>';
                            htmlLine += '    <td class="text-right"><input type="text" class="form-control weight-input" name="net_gross['+val.pi_line_id+']" id="net_gross_'+val.pi_line_id+'" value="'+(val.net_gross)+'" onchange="weightChange('+val.pi_line_id+')"  onkeypress="return isNumber(this, event)" autocomplete="off"> </td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')" class="text-right"> <span id="text_total_net_'+val.pi_line_id+'">'+numberFormat(val.total_net_weight)+'</span> <input type="hidden" name="total_net_weight['+val.pi_line_id+']" id="total_net_weight_'+val.pi_line_id+'" value="'+val.total_net_weight+'" > </td>';
                            htmlLine += '    <td onclick="selectLinesRow('+val.pi_line_id+')" class="text-right"> <span id="text_total_gross_'+val.pi_line_id+'">'+numberFormat(val.total_net_gross)+'</span> <input type="hidden" name="total_net_gross['+val.pi_line_id+']" id="total_net_gross_'+val.pi_line_id+'" value="'+val.total_net_gross+'" > </td>';
                            htmlLine += '</tr>';

                            num++;
                        });

                        var resultWeights = res.data.resultWeights;
                        var htmlLineTotal = '';
                        htmlLineTotal += '<tr>';
                        htmlLineTotal += '    <td class="text-right black" colspan="13"><strong>Total Weight</strong></td>';
                        htmlLineTotal += '    <td class="text-right black"><strong>'+ numberFormat(resultWeights.result_net_weight) +'</strong></td>';
                        htmlLineTotal += '    <td class="text-right black"><strong>'+ numberFormat(resultWeights.result_gross_weight) +'</strong></td>';
                        htmlLineTotal += '</tr>';

                        $('#orderLines').html(htmlLine);
                        $('#orderLinesTotal').html(htmlLineTotal);

                        // ORDER LOTS
                        selectLinesRow(lineID);


                        if (dataOrder.pick_release_status == 'Draft') {
                            // test
                        }else{
                            $('.weight-input').prop('readonly', true);
                        }



                        $('#resultSubtotal').html(numberFormat(resultWeights.result_sub_total));
                        $('#resultTax').html(numberFormat(resultWeights.result_tax));
                        $('#resultTotal').html(numberFormat(resultWeights.result_total));

                        setAttachment(res.data.attachmentFile);

                        $('.check').iCheck({
                            checkboxClass: 'icheckbox_square-green'
                        });

                        $('.custom-select').select2({width: "100%"});

                        $('#pick_release_no').prop('readonly', true);
                        $('#pi_number').prop('readonly', true);
                        $('#customer_number').prop('readonly', true);

                        // $('.custom-select').select2({width: "100%"});

                        // Swal.close();

                    }else{
                        clearTaxInvoice();
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

    async function manageTaxInvoice(event)
    {
        piNumber = $('#pi_number').val();

        if (piNumber == '') {
            Swal.fire({
                icon: 'warning',
                text: 'ไม่พบข้อมูลสำหรับบันทึก',
                showConfirmButton: true
            });
            return false;
        }else if($('#pick_release_status').val() == 'Cancel' || $('#pick_release_status').val() == 'Cancelled' && event == 'Confirm'){
            Swal.fire({
                icon: 'warning',
                title: 'ไม่สามารถยืนยันรายการได้',
                text: 'Invoice, Tax Invoice นี้ถูกยกเลิกไปแล้ว',
                showConfirmButton: true
            });
        }else if($('#pick_release_status').val() == 'Cancel' || $('#pick_release_status').val() == 'Cancelled' && event == 'Draft'){
            Swal.fire({
                icon: 'warning',
                title: 'ไม่สามารถยืนยันรายการได้',
                text: 'Invoice, Tax Invoice นี้ถูกยกเลิกไปแล้ว',
                showConfirmButton: true
            });
        }else{
            var alertText = '';
            var alertTextSuccess = '';
            var alertTextFail = '';
            if (event == 'Draft') {
                alertText           = 'บันทึกใบ Invoice, Tax invoice หรือไม่?';
                alertTextSuccess    = 'บันทึกใบ Invoice, Tax invoice เรียบร้อยแล้ว';
                alertTextFail       = 'บันทึกใบ Invoice, Tax invoice ไม่สำเร็จ';
            }else{
                alertText           = 'ยืนยันใบ Invoice, Tax invoice หรือไม่?';
                alertTextSuccess    = 'ยืนยันใบ Invoice, Tax invoice เรียบร้อยแล้ว';
                alertTextFail       = 'ยืนยันใบ Invoice, Tax invoice ไม่สำเร็จ';
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

                    if($('#pick_release_status').val() == 'Draft' && event == 'Confirm'){
                        $('#pick_release_status').val(event);
                    }

                    const formData = new FormData(document.getElementById("formTaxInvoice"));
                    formData.append('_token','{{ csrf_token() }}');

                    await $.each(fileChoose,async function(index, file) {
                    if(typeof file !== "undefined")
                        await formData.append('attachment[]', file);
                    });

                    $.ajax({
                        url         : '{{ url("om/ajax/tax-invoice-export/manage") }}',
                        type        : 'post',
                        data        : formData,
                        cache       : false,
                        processData : false,
                        contentType : false,
                        success     : function(res){
                            var data = res.data.data;
                            var html = '';
                            if(res.data.status == 'success'){

                                setAttachment(res.data.attachmentFile);

                                if (res.data.invoiceList != undefined) {
                                    invoiceList = res.data.invoiceList;
                                }

                                if (res.data.proformaList != undefined) {
                                    proformaList = res.data.proformaList;
                                }

                                if (data != undefined) {
                                    $('#pick_release_no').val(data.pick_release_no);
                                    // $("#pick_release_approve_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", data.pick_release_approve_date);
                                    $("#pick_release_approve_date").val(data.pick_release_approve_date);
                                }

                                if(event == 'Confirm'){
                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: 'เลขที่ใบ Invoice : ' + data.pick_release_no,
                                        icon: 'success',
                                        showConfirmButton: true,
                                    });

                                    setDefaultInput(1);
                                }else{
                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: alertTextSuccess,
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 2500
                                    });
                                }


                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: alertTextFail,
                                    icon: 'error',
                                    timer: 2500
                                });

                                setDefaultInput(0);
                            }
                        }
                    });
                }
            });
        }
    }

    function newClearTaxInvoice()
    {
        window.location = '{{ url('om/tax-invoice-export') }}';
    }

    function clearTaxInvoice()
    {

        var d           = new Date();
        var dayNow      = d.getDate();
        var monthNow    = ("0"+(d.getMonth()+1)).slice(-2);
        var yearNow     = d.getFullYear();
        let dateNow = dayNow + "/" + monthNow + "/" + yearNow;

        $('#sa_status').val('Draft');
        $('#sa_number').val('');
        $('#customer_id').val('');
        $('#order_header_id').val('');
        $('#pi_date').val('');

        // var saDate = $('#pi_date');
        // saDate.datepicker();
        // saDate.datepicker('setDate', '');

        // var pickDate = $('#pick_release_approve_date');
        // pickDate.datepicker();
        // pickDate.datepicker('setDate', '');

        $('#pick_release_no').val('');
        $('#pi_number').val('');

        $('#pi_header_id').val('');
        $('#product_type_code').val('');
        $('#order_number').val('').trigger('change');
        // $('#pick_release_approve_date').val('');
        $('#cust_po_number').val('');
        $('#customer_number').val('');
        $('#customer_name').val('');
        $('#order_type_id').val('').trigger('change');
        $('#currency').val('');
        $('#currency_name').val('');
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
        $('#price_list_id').val('');
        $('#incoterms_code').val('').trigger('change');
        $('#port_of_loading').val('');
        $('#transport_type_code').val('').trigger('change');
        $('#transport_detail').val('');
        $('#port_of_discharge').val('').trigger('change');
        $('#place_of_delivery').val('').trigger('change');
        $('#shipment_condition').val('');
        $('#shipping_marks').val('');
        $('#source_system').val('').trigger('change');
        $('#sale_confirm_date').val('');
        $('#sale_confirm_document_no').val('');
        $('#delivery_date').val('');
        $('#pick_exchange_rate').val('');
        $('#pick_exchange_date').val('');
        $('#exchange_rate').val('');

        $('#lot_pi_line_id').val('');

        $('#check_forward_flag').iCheck('uncheck');

        var orderLineHtml = '';
        orderLineHtml += '<tr>';
        orderLineHtml += '    <td class="text-right black" colspan="13"><strong>Total Weight</strong></td>';
        orderLineHtml += '    <td class="text-right black"><strong>0.00</strong></td>';
        orderLineHtml += '    <td class="text-right black"><strong>0.00</strong></td>';
        orderLineHtml += '</tr>';

        $('#orderLines').html('');
        $('#orderLinesTotal').html(orderLineHtml);
        $('#orderLots').html('');

        $('#resultSubtotal').html('0.00');
        $('#resultTax').html('0.00');
        $('#resultTotal').html('0.00');

        $('#pick_release_no').prop('readonly', false);
        $('#pi_number').prop('readonly', false);
        $('#customer_number').prop('readonly', false);

        stepEvent = '';
        setSelectValue(3);
        setDefaultInput(1);
    }

    // function setDefaultInput(index = 0)
    // {
    //     if (index == 0) {
    //         $('#exchange_rate').prop('readonly', false);
    //         $('#remark').prop('readonly', false);
    //         $('#shipping_marks').prop('readonly', false);
    //         // $('#delivery_date').prop('readonly', false);
    //     }else{
    //         $('#exchange_rate').prop('readonly', true);
    //         $('#remark').prop('readonly', true);
    //         $('#shipping_marks').prop('readonly', true);
    //         // $('#delivery_date').prop('readonly', true);
    //     }


    // }

    function setDefaultInput(index)
    {
        // index = 1 Is Confirm or Disabled or Readonly
        // index = 2 Is Draft

        if (index == 1) {
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
            // $('#delivery_date').prop('readonly', true);


            $('.check-default').select2({disabled: 'disabled'});

            $('.check-create').select2({disabled: ''});

            $('#order_type_id').prop('readonly', true);

            $('#exchange_rate').prop('readonly', false);
            $('#remark').prop('readonly', false);
            $('#shipping_marks').prop('readonly', false);
            // $('#delivery_date').prop('readonly', false);

            $('#pick_release_approve_date').prop('readonly', true);

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
            // $('#delivery_date').prop('readonly', false);

            $('.check-default').select2({disabled: ''});

            $('.check-create').select2({disabled: ''});

            $('.date').datepicker();

            $('#order_type_id').prop('readonly', false);

            $('#exchange_rate').prop('readonly', false);
            $('#remark').prop('readonly', false);
            $('#shipping_marks').prop('readonly', false);
            // $('#delivery_date').prop('readonly', true);

            $('#pick_release_approve_date').prop('readonly', false);
        }
    }

    function showCancelInvoice()
    {
        if ($('#order_header_id').val() == '') {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'กรุณาค้นหา ก่อนดำเนินการ',
                icon: 'error'
            });
            return false;
        }else if($('#pick_release_status').val() == 'Cancel' || $('#pick_release_status').val() == 'Cancelled'){
            Swal.fire({
                title: 'ไม่สามารถทำรายการได้',
                text: 'Invoice, Tax Invoice นี้ถูกยกเลิกไปแล้ว',
                icon: 'warning'
            });
        }else{

            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ต้องการยกเลิกใบ Invoice, Tax Invoice ใช่ หรือไม่",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {

                    var orderHeaderID = $('#order_header_id').val();
                    var piNumber = $('#pick_release_no').val();

                    Swal.showLoading();

                    $.ajax({
                        url : `{{ url("om/ajax/tax-invoice-export/check-cancel") }}/`+orderHeaderID+`/`+piNumber,
                        success : function(res){
                            var dataOrder = res.data.data;
                            if(res.data.status == 'closed'){
                                Swal.fire({
                                    title: 'ไม่สามารถทำรายการยกเลิกได้',
                                    text: 'รายการนี้ได้ปิดการขายประจำวันแล้ว',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }else if(res.data.status == 'wms_y'){
                                Swal.fire({
                                    title: 'ไม่สามารถทำรายการยกเลิกได้',
                                    text: 'รายการนี้อยู่ในขั้นตอนของ WMS แล้ว',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }else if(res.data.status == 'matching'){
                                Swal.fire({
                                    title: 'ไม่สามารถทำรายการยกเลิกได้',
                                    text: 'กรุณายกเลิกใบเสร็จรับเงินและดำเนินการใหม่อีกครั้ง',
                                    icon: 'error',
                                    timer: 2500
                                });
                            }else if (res.data.status == 'notmatching') {
                                Swal.close();
                                $('#cancelModal').modal('show');

                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: 'ยกเลิกใบ Invoice, Tax Invoice ไม่สำเร็จ',
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

    function cancelTaxInvoice()
    {
        if ($('#invoice_cancel_reason').val() == '') {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'กรุณาใส่เหตุผลที่ยกเลิก',
                icon: 'warning'
            });
            return false;
        }else{

            Swal.showLoading();

            $('#pick_release_status').val('Cancelled');

            const formData = new FormData(document.getElementById("formTaxInvoice"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/tax-invoice-export/cancel") }}',
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

                        var releaseNo = $('#pick_release_no').val();

                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'ยกเลิกใบ Invoice, Tax Invoice : '+releaseNo+' แล้ว',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2500
                        });

                    }else{
                        Swal.fire({
                            title: 'ผิดพลาด',
                            text: 'ยกเลิกใบ Invoice, Tax Invoice ไม่สำเร็จ',
                            icon: 'error',
                            timer: 2500
                        });
                    }
                }
            });
        }
    }

    function closeTaxInvoice()
    {
        if ($('#pick_release_no').val() == '') {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ไม่พบเลขที่ Invoice ที่ต้องการยกเลิก',
                icon: 'error'
            });
        }else{

            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ต้องการปิดงานใช่ หรือไม่",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {

                    var headerID = $('#order_header_id').val();

                    Swal.showLoading();

                    $.ajax({
                        url : `{{ url("om/ajax/tax-invoice-export/close-work") }}/`+headerID,
                        success : function(res){
                            var dataOrder = res.data.data;
                            if(res.data.status == 'success'){
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ปิดงานเรียบร้อยแล้ว',
                                    icon: 'success',
                                    timer: 2500
                                });

                            }else if (res.data.status == 'retry') {
                                Swal.fire({
                                    title: 'ไม่สามารถทำรายการได้',
                                    text: 'ใบ Invoice, Tax Invoice นี้ยังไม่ได้ปิดการขายประจำวัน',
                                    icon: 'warning',
                                    timer: 2500
                                });

                            }else if(res.data.status == 'ceritfy'){
                                Swal.fire({
                                    title: 'แจ้งเตือน',
                                    text: 'ยังไม่ได้รับรองส่งออกที่ Web site กรมสรรพสามิต',
                                    icon: 'warning'
                                });
                            }else{
                                Swal.fire({
                                    title: 'ผิดพลาด',
                                    text: 'เกิดข้อผิดพลาด !!!',
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

    function selectCustomer()
    {
        var number = $("#customer_number").val();

        var itemID = '';
        var itemName = '';

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
        var itemAddress         = '';

        if(number != ''){

            $.each(customerList, function(key,val){
                if (val.customer_number == number) {
                    itemID = val.customer_id;
                    itemName = val.customer_name;

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

                    itemAddress = addressLine1 + addressLine2 + addressLine3 + alley + state + district + city + provinceName + postalCode + country_name;
                }
            });

            $("#customer_id").val(itemID);
            $("#customer_name").val(itemName);
            $("#customer_address").val(itemAddress);
        }else{
            $("#customer_id").val('');
            $("#customer_name").val('');
            $("#customer_address").val('');
        }

        setSelectValue(3);
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
                                // html += '            <input type="hidden" name="lot_subinventory_code['+valItem.pi_lot_id+']" id="lot_subinventory_code_'+valItem.pi_lot_id+'" value="'+valItem.subinventory_code+'" autocomplete="off">';
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

    function selectPickReleaseNo()
    {
        var invoiceNo = $('#pick_release_no').val();

        var invoiceStatus   = '';
        var PickApproveDate = '';
        var piNumber        = '';
        var piDate          = '';
        var customerNumber  = '';
        var customerName    = '';
        var customerID      = '';

        if (invoiceNo != '') {
            $.each(invoiceList, function(key, val){
                if (val.pick_release_no == invoiceNo) {
                    invoiceStatus   = val.pick_release_status;
                    PickApproveDate = val.pick_release_approve_date;
                    piNumber        = val.pi_number;
                    piDate          = val.pi_date;
                    customerNumber  = val.customer_number;
                    customerName    = val.customer_name;
                    customerID      = val.customer_id;
                }
            });
        }

        $('#pick_release_status').val(invoiceStatus);
        $('#pick_release_approve_date').val(PickApproveDate);

        if ($('#pi_number').val() == '') {
            $('#pi_number').val(piNumber);
            $('#pi_date').val(piDate);
            // $("#pi_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", piDate);
        }

        if ($('#customer_number').val() == '') {
            $('#customer_number').val(customerNumber).trigger('change');
            $('#customer_name').val(customerName);
            $('#customer_id').val(customerID);

        }

        setSelectValue(1);
    }

    function checkOutstandingDebt()
    {
        var piNumber = $('#pi_number').val();

        if (piNumber != '') {
            Swal.fire({
                title:"",
                text:"Checking...",
                showConfirmButton: false,
                allowOutsideClick: false,
                //icon: "success"
            });
            $.ajax({
                url : `{{ url("om/ajax/sale-confirmation/check-outstanding-debt") }}/`+piNumber,
                success : function(res){
                    if (res.data.status == 'success') {
                        Swal.close();
                        selectProforma();
                    }else{
                        Swal.fire({
                            title: '',
                            text: 'กรุณาทำการชำระเงิน ใบ Sale Confirmation ใบนี้ก่อน!',
                            icon: 'warning'
                        });
                    }
                }

            });
        } else {
            selectProforma();
        }
    }

    function selectProforma()
    {
        var piNumber = $('#pi_number').val();

        if (stepEvent == 'create' && piNumber != '') {
            searchCreate();
        }else if (stepEvent == 'create' && piNumber == '') {

            clearTaxInvoice();

            $('#pick_release_no').prop('readonly', true);
            stepEvent = 'create';

            // var d           = new Date();
            // var dayNow      = d.getDate();
            // var monthNow    = ("0"+(d.getMonth()+1)).slice(-2);
            // var yearNow     = d.getFullYear();
            // let dateNow = dayNow + "/" + monthNow + "/" + yearNow;

            // $("#pick_release_approve_date").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", dateNow);

        }else{

            var invoiceNo       = '';
            var invoiceStatus   = '';
            var PickApproveDate = '';
            var piDate          = '';
            var customerNumber  = '';
            var customerName    = '';
            var customerID      = '';

            if (piNumber != '') {
                $.each(proformaList, function(key, val){
                    if (val.pi_number == piNumber) {
                        invoiceNo       = val.pick_release_no
                        invoiceStatus   = val.pick_release_status;
                        PickApproveDate = val.pick_release_approve_date;
                        piNumber        = val.pi_number;
                        piDate          = val.pi_date;
                        customerNumber  = val.customer_number;
                        customerName    = val.customer_name;
                        customerID      = val.customer_id;
                    }
                });
            }

            $('#pi_date').val(piDate);

            if ($('#pick_release_no').val() == '') {
                $('#pick_release_no').val(invoiceNo);
                $('#pick_release_status').val(invoiceStatus);
                $('#pick_release_approve_date').val(PickApproveDate);
            }

            if ($('#customer_number').val() == '') {
                $('#customer_number').val(customerNumber).trigger('change');
                $('#customer_name').val(customerName);
                $('#customer_id').val(customerID);
                // selectCustomer();
            }

            setSelectValue(2);
        }

    }

    function setSelectValue(index)
    {
        // console.log(index);
        var pickReleaseNo     = $('#pick_release_no').val();
        var piNumber         = $("#pi_number").val();
        var customerNumber      = $("#customer_number").val();

        var pickSelect   = '';
        var piSelect     = '';
        var customerSelect  = '';

            // PICK RELEASE NO LIST
        var htmlPickList = '';

        $.each(invoiceList, function(key, val){
            if($.trim(val.pick_release_no) != ''){
                if (pickReleaseNo == val.pick_release_no && stepEvent != 'create' ) {
                    pickSelect   = 'selected';
                }else{
                    pickSelect   = '';
                }

                if (piNumber == '' && customerNumber == ''){
                    htmlPickList += '<option value="'+ val.pick_release_no +'">'+ val.pick_release_no +'</option>';
                }

                else if (piNumber != '' && customerNumber == '' && val.pi_number == piNumber){
                    htmlPickList += '<option '+pickSelect+' value="'+ val.pick_release_no +'">'+ val.pick_release_no +'</option>';
                }

                else if(piNumber == '' && customerNumber != '' && val.customer_number == customerNumber){
                    htmlPickList += '<option '+pickSelect+' value="'+ val.pick_release_no +'">'+ val.pick_release_no +'</option>';
                }

                else if(piNumber != '' && customerNumber != '' && val.pi_number == piNumber && val.customer_number == customerNumber){
                    htmlPickList += '<option '+pickSelect+' value="'+ val.pick_release_no +'">'+ val.pick_release_no +'</option>';
                }
            }
        });

        $('#pick-release-list').html(htmlPickList);


        // PI NUMBER LIST
        var htmlPiList = '';
        var checkPiNumber = '';

        $.each(proformaList, function(key, val){
            if($.trim(val.pi_number) != '' && checkPiNumber != (val.pi_number) || pickReleaseNo == val.pick_release_no || customerNumber == val.customer_number){
                if (piNumber == val.pi_number) {
                    piSelect   = 'selected';
                }else{
                    piSelect   = '';
                }

                if (stepEvent == 'create') {

                    if ($.trim(val.pick_release_no) != '') {
                        // console.log(val.pick_release_no);
                    }

                    else if (pickReleaseNo == '' && customerNumber == ''){
                        htmlPiList += '<option '+piSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if (pickReleaseNo != '' && customerNumber == '' && val.pick_release_no == pickReleaseNo){
                        htmlPiList += '<option '+piSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(pickReleaseNo == '' && customerNumber != '' && val.customer_number == customerNumber){
                        htmlPiList += '<option '+piSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(pickReleaseNo != '' && customerNumber != '' && val.pick_release_no == pickReleaseNo && val.customer_number == customerNumber){
                        htmlPiList += '<option '+piSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                }

                else {
                    if (pickReleaseNo == '' && customerNumber == ''){
                        htmlPiList += '<option '+piSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if (pickReleaseNo != '' && customerNumber == '' && val.pick_release_no == pickReleaseNo){
                        htmlPiList += '<option '+piSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(pickReleaseNo == '' && customerNumber != '' && val.customer_number == customerNumber){
                        htmlPiList += '<option '+piSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }

                    else if(pickReleaseNo != '' && customerNumber != '' && val.pick_release_no == pickReleaseNo && val.customer_number == customerNumber){
                        htmlPiList += '<option '+piSelect+' value="'+ val.pi_number +'">'+ val.pi_number +'</option>';
                    }
                }

                checkPiNumber = val.pi_number;
            }
        });

        $('#proforma-list').html(htmlPiList);

        // CUSTOMER NUMBER LIST
        var htmlCustomerList = '';
        checkCustomer = '';

        if (pickReleaseNo == '' && piNumber == ''){
            $.each(customerList, function(key, val){
                if($.trim(val.customer_number) != ''){
                    if (customerNumber == '') {
                        htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                    }else if (val.customer_number == customerNumber && customerNumber != '') {
                        htmlCustomerList += '<option value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                    }
                }
            });
        }else if(pickReleaseNo != ''){

            $.each(invoiceList, function(key, val){
                if($.trim(val.customer_number) != ''){
                    if (customerNumber == val.customer_number) {
                        customerSelect   = 'selected';
                    }else{
                        customerSelect   = '';
                    }

                    if (checkCustomer == val.customer_number) {

                    }else if (pickReleaseNo == val.pick_release_no) {
                        htmlCustomerList += '<option '+customerSelect+' value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        checkCustomer = val.customer_number;
                    }
                }
            });
        }else if(piNumber != ''){
            $.each(proformaList, function(key, val){
                if($.trim(val.customer_number) != ''){
                    if (customerNumber == val.customer_number) {
                        customerSelect   = 'selected';
                    }else{
                        customerSelect   = '';
                    }

                    if (checkCustomer == val.customer_number) {

                    }else if (piNumber == val.pi_number) {
                        htmlCustomerList += '<option '+customerSelect+' value="'+ val.customer_number +'">'+ val.customer_name +'</option>';
                        checkCustomer = val.customer_number;
                    }
                }
            });
        }


        $('#customers-list').html(htmlCustomerList);
    }

    // LOTS MANAGEMENT
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

                                        html += '    <td style="display:none"><input type="text" class="form-control md" readonly="" name="inv_org_name['+rollLot+']" id="inv_org_name_'+rollLot+'" value="" autocomplete="off"></td>';

                                        // Subinventory
                                        html += '    <td style="display:none">';
                                        html += '        <div class="input-icon">';
                                        html += '           <input type="text" class="form-control" name="lot_subinventory_code['+rollLot+']" id="lot_subinventory_code_'+rollLot+'" list="org-subinventory-list-'+rollLot+'" onchange="selectOrgSubInventory('+rollLot+');" autocomplete="off">';
                                        html += '           <i class="fa fa-search"></i>';
                                        html += '           <datalist id="org-subinventory-list-'+rollLot+'">';
                                        html += '               <option value=""></option>';

                                        $.each(dataLotList, function(key,valLot){
                                            if (valLot.subinventory_code != '' && valLot.organization_id) {
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
                                            if (valLot.locator != '' && valLot.organization_id) {
                                            html += '               <option value="'+valLot.locator+'">'+valLot.locator+'</option>';
                                            }
                                        });

                                        html += '            </datalist>';
                                        html += '            <i class="fa fa-search" onclick="selectOrgLot('+rollLot+');"></i>';
                                        html += '        </div>';
                                        html += '    </td>';

                                        // Lot
                                        html += '    <td style="display:none">';
                                        html += '        <div class="input-icon">';
                                        html += '           <input type="text" class="form-control" name="lot_lot_number['+rollLot+']" id="lot_lot_number_'+rollLot+'" list="org-lot-list-'+rollLot+'" onchange="selectOrgLot('+rollLot+');" autocomplete="off">';
                                        html += '           <i class="fa fa-search"></i>';
                                        html += '           <datalist id="org-lot-list-'+rollLot+'">';
                                        html += '               <option value=""></option>';

                                        $.each(dataLotList, function(key,valLot){
                                            if (valLot.lot_number != '' && valLot.organization_id) {
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

                                if (parseFloat(resultQuantity).toFixed(2) < parseFloat(mainOrderQuantity).toFixed(2)) {
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
            // resultQuantity = mainOrderQuantity - orderQuantity + 1;
            // $('#lot_order_quantity_'+index).val(orderQuantity);

            $("#buttonCreateLots").attr('disabled', true);
        }

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

    function addNumberZero(numb1, numb2) {
        return new Array(numb2 + 1 - (numb1 + '').length).join('0') + numb1;
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
        }
        // else if (parseFloat(resultQuantity).toFixed(2) != parseFloat(mainOrderQuantity).toFixed(2)) {
        //     Swal.fire({
        //         icon: 'warning',
        //         text: 'โปรดระบุจำนวนที่ต้องการตัดให้ครบจำนวนสั่งซื้อ',
        //         showConfirmButton: true,
        //         timer: 2500
        //     });
        // }
        else{
            Swal.showLoading();
            const formData = new FormData(document.getElementById("formTaxInvoice"));
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

                const formData = new FormData(document.getElementById("formTaxInvoice"));
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

                    const formData = new FormData(document.getElementById("formTaxInvoice"));
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
                    $('#case_no_from_'+ LotID).val(addNumberZero(valFrom, 3));
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

    function linkToPagePrintInvoice(){
        var orderHeaderID = $('#pi_header_id').val();

        if (orderHeaderID > 0) {
            var url = "{{ url('om/tax-invoice-export/print-invoice') }}?pi_header_id="+orderHeaderID;
            var myWindow = window.open(url, "_blank");
        }else{
            return false;
        }
    }

    function linkToPagePrintPackingList(){
        var orderHeaderID = $('#pi_header_id').val();

        if (orderHeaderID > 0) {
            var url = "{{ url('om/tax-invoice-export/print-packing-list') }}?pi_header_id="+orderHeaderID+"&ref=73";
            var myWindow = window.open(url, "_blank");
        }else{
            return false;
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


</script>
@stop
