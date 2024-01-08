@extends('layouts.app')
@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
<style>
    #page-wrapper{
        width: calc(100% - 220px);
    }
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }
    .select2-container{
        width: 100%!important;
    }
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

    .mx-datepicker .mx-input-wrapper input{
        height: auto;
    }
</style>
<style>
    .btn-success {
        color: #fff !important;
        background-color: #1c84c6 !important;
        border-color: #1c84c6 !important;
    }
</style>
@stop

@section('title', 'OMP0019 : บันทึกใบเตรียมการขาย')

@section('page-title')
    <h2>OMP0019 : บันทึกใบเตรียมการขาย</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>OMP0019 : บันทึกใบเตรียมการขาย</strong>
        </li>
    </ol>
@stop

@section('content')

<div class="ibox-content">
    <div class="row space-50 justify-content-md-center mt-md-4">
        <div class="col-12">
            <div class="form-header-buttons">
                <div class="d-flex">
                    <a class="btn btn-white" href="{{ url('/') }}/om/order/prepare/"><i class="fa fa-repeat"></i></a>
                </div>
                <div class="buttons multiple">
                    <button class="btn btn-md btn-success" type="button" id="bt_create"><i class="fa fa-plus"></i> สร้าง</button>
                    <button class="btn btn-md btn-white" type="button" id="bt_search"><i class="fa fa-search"></i> ค้นหา</button>
                    <!--button class="btn btn-md btn-success w-en" type="button"><i class="fa fa-upload"></i> Attachment</button-->

                    {{-- <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> แนบไฟล์</span></button>
                    <button class="btn btn-md btn-warning" type="button" disabled><i class="fa fa-print"></i> พิมพ์ใบสั่งชื้อ</button>
                    <button class="btn btn-md btn-info" type="button" disabled><i class="fa fa-print"></i> พิมพ์ใบเตรียมการขาย</button>

                    <div class="dropdown">
                        <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" id="btn_save">บันทึก</a></li>
                            <li><a href="javascript:void(0)" id="btn_confirm">ยืนยัน</a></li>
                            <li><a href="javascript:void(0)">ยกเลิก</a></li>
                        </ul>
                    </div>

                    <button class="btn btn-md btn-primary" type="button" id="btn_approve"><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button> --}}
                </div>
            </div><!--form-header-buttons-->

            <div class="hr-line-dashed"></div>
        </div><!--col-12-->
        <form id="form-order" class="col-xl-12" data-action="{{ url('/') }}/om/order/prepare/create/submit">
            {{ csrf_field() }}
            <input style="display: none;" name="form_type" id="form_type" value=""/>
            <input type="hidden" name="pick_release_approve_date" id="pick_release_approve_date" value=""/>
            <button type="submit" id="btn_order" style="display: none;"></button>
            <div id="div_outstanding"></div>
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">เลขที่ใบเตรียมขาย</label>
                            <select class="custom-select select2-" style="width: 100%;" id="prepare_order_number" name="prepare_order_number" data-placeholder="เลขที่ใบเตรียมขาย">
                                <option value=""></option>
                                {{-- @foreach ($data['orderPrepare'] as $item)
                                <option value="{{ $item->prepare_order_number }}" data-number="{{ $item->order_number }}" data-customer="{{ $item->customer_id }}">{{ $item->prepare_order_number }}</option>
                                @endforeach --}}
                            </select>
                            {{-- <div class="input-icon">
                                <input type="text" class="form-control" name="prepare_order_number" id="prepare_order_number" placeholder="" value="">
                                <i class="fa fa-search"></i>
                            </div> --}}
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                            <select class="custom-select select2" style="width: 100%;" id="order_number" name="order_number" data-placeholder="เลขที่ใบสั่งซื้อ">
                                <option value=""></option>
                                {{-- @foreach ($data['orderNumber'] as $item)
                                <option value="{{ $item->order_number }}" data-prepare="{{ $item->prepare_order_number }}" data-customer="{{ $item->customer_id }}">{{ $item->order_number }}</option>
                                @endforeach --}}
                            </select>
                            {{-- <div class="input-icon">
                                <input type="text" class="form-control"  name="order_number" id="order_number" placeholder="เลขที่ใบสั่งซื้อ" value="">
                                <i class="fa fa-search"></i>
                            </div> --}}
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">เลขที่ PO ของลูกค้า</label>
                            <input type="text" class="form-control or-disabled"  name="cust_po_number" disabled id="cust_po_number" placeholder="เลขที่ PO ของลูกค้า" value="">
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Order Status</label>
                            <div class="row space-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" disabled name="order_status" id="order_status" placeholder="" value="">
                                        {{-- <i class="fa fa-search"></i> --}}
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2 mt-md-0">
                                    <div class="i-checks f13"><label><input type="checkbox" value="option_d1" name="a" disabled><span class="nowrap">ยอดส่งได้รับการอนุมัติ</span></label></div>
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <div class="col-xl-9">
                        <div class="form-group">
                            <label class="d-block">รหัสลูกค้า</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" name="customer_number" id="customer_number" placeholder="" value="{{ (request()) ? request()->customer_number : '' }}" list="customer-list" onchange="custchange(this.value);">
                                        <i class="fa fa-search"></i>
                                        <datalist id="customer-list">
                                            @foreach ($data['customers'] as $item)
                                                <option value="{{ $item->customer_number }}">{{ $item->customer_name_format }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-2 mt-md-0">
                                    <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="" value="">
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="d-block">วิธีการชำระเงิน</label>
                            <select class="custom-select select2 or-disabled" style="width: 100%;" disabled id="payment_method" name="payment_method" data-placeholder="วิธีการชำระเงิน">
                                <option value=""></option>
                                @foreach ($data['paymentMethod'] as $item)
                                <option value="{{ $item->lookup_code }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group" id="payment_duedate_date">
                            <label class="d-block">วันครบกำหนดชำระ</label>
                            <datepicker-th
                                        style="width: 100%"
                                        class="form-control or-disabled"
                                        name="payment_duedate"
                                        id="payment_duedate"
                                        placeholder="โปรดเลือกวันที่"
                                        :disabled="true"
                                        format="{{ trans("date.js-format") }}">
                        </div>
                        <div class="form-group" id="payment_duedate_modal" style="display:none;">
                            <label class="d-block">วันครบกำหนดชำระ</label>
                            <div class="form-control" onclick="viewDayAmount()">วันครบกำหนดชำระ</div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">สั่งทาง</label>
                            <select class="custom-select select2 or-disabled" style="width: 100%;" disabled id="sales_channel" name="sales_channel" data-placeholder="สั่งทาง">
                                <option value=""></option>
                                @foreach ($data['salesChannel'] as $item)
                                <option value="{{ $item->description }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">หมายเหตุสั่งทาง</label>
                            <input type="text" class="form-control or-disabled" disabled name="remark_source_system" id="remark_source_system" placeholder="" value="">
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group mw-100">
                            <label class="d-block">วันที่สั่ง</label>
                            <div id="input_order_date"></div>
                            {{-- <datepicker-th
                                        style="width: 100%"
                                        class="form-control or-disabled"
                                        name="order_date"
                                        id="order_date"
                                        placeholder="โปรดเลือกวันที่"
                                        :disabled="true"
                                        format="{{ trans("date.js-format") }}"> --}}
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <!-- <div class="form-group">
                            <label class="d-block">หนี้ค้างชำระ</label>
                            <select class="custom-select select2 or-disabled" style="width: 100%;" disabled aria-readonly="true" name="over_due" id="over_due" data-placeholder="">
                                <option value=""></option>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label class="d-block">หนี้ค้างชำระ</label>
                            <div class="form-control" onclick="viewOutstanding()" style="background: white;text-decoration: underline;color: #2196f3;cursor: pointer;">หนี้ค้างชำระ</div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">ส่งโดย</label>
                            <select class="custom-select select2 or-disabled" style="width: 100%;" id="shipment_by" name="shipment_by" required data-placeholder="ส่งโดย">
                                <option value=""></option>
                                @foreach ($data['shipmentBy'] as $item)
                                <option value="{{ $item->lookup_code }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3"></div>

                    <!--//-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">วันที่ส่ง</label>
                            <div id="input_delivery_date"></div>
                            <!-- <datepicker-th
                                        style="width: 100%"
                                        class="form-control or-disabled"
                                        name="delivery_date"
                                        id="delivery_date"
                                        placeholder="โปรดเลือกวันที่"
                                        value=""
                                        disabled
                                        format="{{ trans("date.js-format") }}"> -->
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group mw-100">
                            <label class="d-block">ปีงบ/งวด</label>
                            <div class="row space-5">
                                <div class="col-8">
                                    <input type="text" class="form-control" readonly name="budget_year" id="budget_year" placeholder="" value="">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" readonly name="period_no" id="period_no" placeholder="" value="">
                                    <input type="hidden" class="form-control" readonly name="period_line" id="period_line" placeholder="" value="">
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">ประเภทการจ่ายเงิน</label>
                            <select class="custom-select select2 or-disabled" style="width: 100%;" disabled name="payment_type" id="payment_type" data-placeholder="ประเภทการจ่ายเงิน">
                                <option value=""></option>
                                @foreach ($data['paymenType'] as $item)
                                <option value="{{ $item->lookup_code }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3">
                        <div id="test_date"></div>
                    </div>
                    {{-- <div class="col-xl-3 col-md-6">
                        <div class="form-group mw-100">
                            <label class="d-block">กลุ่มวงเงินเชื่อ</label>
                            <select class="custom-select select2" style="width: 100%;" name="credit_group" id="credit_group" data-placeholder="กลุ่มวงเงินเชื่อ">
                                <option value=""></option>
                                @foreach ($data['creditGroup'] as $item)
                                <option value="{{ $item->lookup_code }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <!--//-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Order Type</label>
                            <select class="custom-select select2 or-disabled" required style="width: 100%;" disabled name="order_type" id="order_type" data-placeholder="ประเภทออเดอร์">
                                <option value=""></option>
                                @foreach ($data['transactionType'] as $item)
                                <option value="{{ $item->order_type_id }}" {{ ($item->order_type_name == 'DOMESTIC_บุหรี่ในประเทศ') ? 'selected' : '' }}>{{ $item->order_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Bill To</label>
                            <div class="input-icon">
                                <input type="text" class="form-control" readonly name="bill_to_site_id" id="bill_to_site_id" placeholder="" value="">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Ship To</label>
                            <select class="custom-select select2 or-disabled" style="width: 100%;" disabled aria-readonly="true" name="ship_to_site_id" id="ship_to_site_id" data-placeholder="Ship To">
                                <option value=""></option>
                            </select>
                        </div>
                    </div><!--col-->
                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            {{-- Attribute6 --}}
                            <label class="d-block">ที่อยู่ใบแจ้งหนี้ตามสถานที่ Ship-to</label>
                            <input type="checkbox" class="or-disabled" name="attribute6" id="" disabled>
                        </div>
                    </div><!--col-->

                    {{-- <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Salesperson</label>
                            <div class="input-icon">
                                <input type="text" class="form-control"  name="" placeholder="" value="">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div> --}}
                    <!--col-->

                    <!--//-->

                    <div class="col-xl-9">
                        <div class="form-group mw-100">
                            <label class="d-block">หมายเหตุรายการ</label>
                            <input type="text" class="form-control or-disabled"  name="remark" disabled id="remark" placeholder="" value="">
                        </div>
                    </div><!--col-->

                </div><!--row-->
            </div><!--col-xl-6-->

            <div class="col-xl-12" id="form_item" style="display: none;">
                <hr class="lg">
                <div class="form-header-buttons">
                    <div class="buttons multiple">
                        <button class="btn btn-md btn-success order-type-10" type="button" onclick="addOrderLine()"><i class="fa fa-plus"></i> สร้าง</button>
                        {{-- <button class="btn btn-md btn-primary" type="button"><i class="fa fa-save"></i> บันทึก</button> --}}
                    </div>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>

                @if (request()->order_type == 1065)
                    @include('om/preparation/_form_order_line_other')
                @else
                    @include('om/preparation/_form_order_line')
                @endif

                <div class="panel panel-default mt-4">
                    <div class="d-block m-auto" style="max-width:1000px">
                        <div class="row p-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">เงินสด</label>
                                    <input type="text" class="form-control text-right" readonly name="cash_amount" id="cash_amount" placeholder="" value="0.00">
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">เงินเชื่องวดนี้</label>
                                    <input type="text" class="form-control text-right" readonly name="credit_amount" id="credit_amount" placeholder="" value="0.00">
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">เงินคงเหลือ</label>
                                    <input type="text" class="form-control text-right" readonly name="remaining_amount_balance" id="remaining_amount_balance" placeholder="" value="0.00">
                                    <input type="hidden" class="form-control text-right" readonly name="remaining_amount" id="remaining_amount" placeholder="" value="0.00">
                                    <div id="contractGroups"></div>
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">หนี้ที่ต้องชำระและค่าปรับ</label>
                                    <input type="text" class="form-control text-right" readonly name="over_fine_amount" id="over_fine_amount" placeholder="" value="0.00">
                                    <input type="hidden" class="form-control text-right" readonly name="cancel_over_fine_amount" id="cancel_over_fine_amount" placeholder="" value="0">
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">รวมเงินที่ต้องชำระ</label>
                                    <input type="hidden" class="form-control text-right" readonly name="grand_total" id="grand_total" placeholder="" value="0.00">
                                    <input type="text" class="form-control text-right" readonly name="grand_total_text" id="grand_total_text" placeholder="" value="0.00">
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group mt-md-4 pt-md-3">
                                    <label class="d-block red"><strong>สินค้ากลุ่มเงินเชื่อ 3 เกินโควต้า 0.00</strong></label>
                                </div>
                            </div><!--col-md-4-->
                            
                            <input type="hidden" name="attachment_id" id="attachment_id">

                        </div><!--row-->
                    </div><!--d-block-->
                </div><!--panel-->
            </div><!--col-xl-12-->
        </form>
    </div><!--row-->
    <div class="modal modal-800 fade" id="datePaymentModal" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form id="formCancelPo" autocomplete="none" enctype="multipart/form-data">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="modal-header">
                        <h3>วันครบกำหนดชำระ </h3>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <div class="attachment-box">
                            <div class="col-xl-10 m-auto">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center table-hover f13" id="tb_day_amount">
                                                <thead>
                                                    <tr class="align-middle">
                                                        <th>กลุ่มวงเงิน</th>
                                                        <th>จำนวนเงิน</th>
                                                        <th>วันครบกำหนดชำระ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- <tr class="day_amount" style="">
                                                        <td><span class="day_amount_description"></span></td>
                                                        <td class="text-right"><span class="day_amount_amount"></span></td>
                                                        <td><span class="day_amount_date_th"></span></td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--col-xl-6-->
                        </div>
                    </div><!--modal-body-->
                </form>
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal-->

    <div class="modal modal-800 fade" id="Outstanding" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form id="formCancelPo" autocomplete="none" enctype="multipart/form-data">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="modal-header">
                        <h3>หนี้ค้างชำระ </h3>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <div class="attachment-box">
                            <div class="col-xl-12 m-auto">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive" style="max-height:96vh;">
                                            <table class="table table-bordered text-center f13" id="tb_outstanding">
                                                <thead>
                                                    <tr class="align-middle">
                                                        <th>เลือก</th>
                                                        <th>เลขที่ Invoice</th>
                                                        <th>กลุ่มวงเงิน</th>
                                                        <th>จำนวนเงิน</th>
                                                        <th>ค่าปรับ</th>
                                                        <th>รวม</th>
                                                        <th>วันครบกำหนดชำระ</th>
                                                        <th>ยกเลิกค่าปรับ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--col-xl-6-->
                        </div>
                    </div><!--modal-body-->
                </form>
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal-->



    {{-- ปุ่มต่างๆ --}}
    <div class="hr-line-dashed"></div>
    <div class="row">
        <div class="col-md-12">
            <div class=" text-center">
                <div class="buttons multiple">
                    <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> แนบไฟล์</span></button>
                    <button class="btn btn-md btn-warning" type="button" disabled><i class="fa fa-print"></i> พิมพ์ใบสั่งชื้อ</button>
                    <button class="btn btn-md btn-info" type="button" disabled><i class="fa fa-print"></i> พิมพ์ใบเตรียมการขาย</button>

                    <div class="dropdown" style="display: inline;">
                        <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" id="btn_save">บันทึก</a></li>
                            <li><a href="javascript:void(0)" id="btn_confirm">ยืนยัน</a></li>
                            <li><a href="javascript:void(0)">ยกเลิก</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
        

</div><!--ibox-content-->



@endsection

@section('scripts')

@include('om/_scripts/attachment')

<script src="https://unpkg.com/moment@2.26.0/moment.js"></script>
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>

<script>
    $('.select2').select2();
</script>
<script>

    let customerlists = {!! json_encode($data['customers']) !!};
    let customer_id = 0;
    let productlists = [];
    let contractQuata = []
    let itemList = []
    let groupQuota = []
    let runOrderLine = 0
    let runLine = 1
    let totalLine = 1
    let creditLimit = 0
    let remainingLimit = 0
    let useAmount = 0
    let create = false
    let selectCustomer = false
    let latest = []
    let type_save = 'index'
    let number_order = '';
    let number_prepare = '';
    let over_fine_amount = 0
    let customer_active = '';
    let cancel_over = 0
    let remaining_amount_balance = 0;
    let delivery_date_send = '';
    let isItem = false;
    let attachment_id = '';
    let html_product_lists = "";
    let delivery_date_new = '';
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

    function isCheckNumber(evt)
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };

    autoCustomer()
    function autoCustomer() {
        var customer = getUrlParameter('customer');
        var order_type = getUrlParameter('order_type');

        if(customer != false && order_type != false){
            type_save = 'create'
            $('#customer_number').val(customer)

            $.ajax({
                url: "{{ route('om.ajax.order.prepare.run_number') }}",
                method: 'get',
                success: function (response) {
                    // $('#prepare_order_number').val(response.data.prepareNumber)
                    // $('#order_number').val(response.data.orderNumber).prop('readonly', true);
                    $('#order_number').prop('disabled', true);
                    $('#order_date').val(response.data.orderDate)
                    $('#prepare_order_number').prop('disabled', true);
                    type_save = 'create'
                    create = true
                    checkCreate()
                    Swal.close()

                    $('.or-disabled').prop('readonly', false)
                    $('.or-disabled').prop('disabled', false)

                    // $("#payment_duedate").prop('disabled', false)
                    // $("#order_date").prop('disabled', false)
                    // $("#delivery_date").prop('disabled', false)

                    $("#payment_duedate").removeAttr('disabled');
                    $("#order_date").removeAttr('disabled');
                    $("#delivery_date").removeAttr('disabled');
                    $('#order_status').val('Draft')

                    $('#bt_create').attr("disabled",true);
                    $('#bt_copy').attr("disabled",true);
                    $('#bt_search').attr("disabled",true);
                    $('#btn_approve').attr("disabled",true);

                    custchange(customer)

                },
                error: function (jqXHR, textStatus, errorRhrown) {

                }
            })
        }

    }
    function formatConvertMoney(amount) {
        return parseFloat(Number(amount.replace(/[^0-9\.]+/g,"")));
    }

    $('#order_type').on('select2:select', function(e) {
        window.location.href = "{{ url('/') }}/om/order/prepare?customer="+customer_active+"&order_type="+$(this).val();
    });
    $("#prepare_order_number").select2({
                            placeholder: 'เลขที่ใบเตรียมขาย',
                            allowClear: true,
                            language: {
                                searching: function() {
                                    return "กรุณารอสักครู่ระบบกำลังเรียกข้อมูล....!!!";
                                }
                            },
                            templateSelection: function(container) {
                               
                                    $(container.element).attr("data-number", container.number);
                                    $(container.element).attr("data-customer", container.customer);
                                    return container.text;
                           },
                            ajax: {
                                url: '',
                                dataType: 'json',
                                data: function (params) {
                                    var query = {
                                        search: params.term,
                                        type: 'prepare_order_number',
                                        customer_id: customer_id
                                    }
                                    return query;
                                },
                                cache: true,
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            return {
                                                text: item.prepare_order_number,
                                                id: item.prepare_order_number,
                                                number: item.order_number,
                                                customer: item.customer_id,
                                            }
                                        })
                                    };
                                }
                            }
                            });

                $("#order_number").select2({
                            placeholder: 'เลขที่ใบสั่งซื้อ',
                            allowClear: true,
                            language: {
                                searching: function() {
                                    return "กรุณารอสักครู่ระบบกำลังเรียกข้อมูล....!!!";
                                }
                            },
                            templateSelection: function(container) {
                                    console.log(container.number, '+++')
                                    $(container.element).attr("data-prepare", container.prepare);
                                    $(container.element).attr("data-customer", container.customer);
                                    console.log($(container.element).attr("data-number"), $(container.element).attr("data-customer"))
                                    return container.text;
                           },
                            ajax: {
                                url: '',
                                dataType: 'json',
                                data: function (params) {
                                    var query = {
                                        search: params.term,
                                        type: 'order_number',
                                        customer_id: customer_id
                                    }
                                    return query;
                                },
                                cache: true,
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            return {
                                                text: item.order_number,
                                                id: item.order_number,
                                                prepare: item.prepare_order_number,
                                                customer: item.customer_id,
                                            }
                                        })
                                    };
                                }
                            }
                            });

    $("#prepare_order_number").change(function(){
        var selected = $(this).find(":selected")
        number_order = $(this).val()
        console.log(selected.data('customer'), selected.data("number"))

        $('#order_number').append("<option selected data-number='"+ $(this).val() +"' value='"+ selected.data('number') +"'' data-customer='"+ selected.data('customer') +"'>"+ selected.data('number') +"</option>");

        updateDataHeader($(this).val(),selected.data("number"),selected.data('customer'))
    });

    $("#order_number").change(function(){
        var selected = $(this).find(":selected")
        number_prepare = $(this).val()


        $('#prepare_order_number').append("<option selected data-number='"+ $(this).val() +"' value='"+ selected.data('prepare') +"'' data-customer='"+ selected.data('customer') +"'>"+ selected.data('prepare') +"</option>");

        updateDataHeader(selected.data('prepare'),$(this).val(),selected.data('customer'))
    });

    // $("#order_date").change(function(){
    //     // console.log('asdasd')
    // });

    function updateDataHeader(prepare,number,customer) {

        $('#prepare_order_number').val(prepare).trigger('change.select2'); // Select the option with a value of '1'
        // $('#prepare_order_number').select2().trigger('change'); // Notify any JS components that the value changed

        $('#order_number').val(number).trigger('change.select2'); // Select the option with a value of '1'
        // $('#order_number').select2().trigger('change'); // Notify any JS components that the value changed
        var index = _.findIndex(customerlists, function(o) {return o['customer_id'] == customer;});
        try {
            $('#customer_number').val(customerlists[index]['customer_number'])
            $('#customer_name').val(customerlists[index]['customer_name_format'])
        } catch (error) {
            
        }
        
        // Swal.showLoading()

        // updateDataCustomer(customerlists[index])
        // $('.or-disabled').prop('readonly', false)
        // $('.or-disabled').prop('disabled', false)
        // if(type == 'prepare'){
        //     console.log($("#prepare_order_number").val());
        // }
    }

    async function custchange(v){
        if(v != ''){
            number_order = ''
            number_prepare = ''
            customer_active = v
            // console.log(customer_active)

            delivery_date_send = ''
            var index = _.findIndex(customerlists, function(o) {return o['customer_number'] == v;});
            if(index != -1){
                $('#customer_name').val(customerlists[index]['customer_name_format']);
                // $('#prepare_order_number').select2().val('').trigger('change.select2');
                // $('#order_number').select2().val('').trigger('change.select2');
                customer_id = customerlists[index]['customer_id']
                over_fine_amount = 0
                cancel_over = 0
                Swal.showLoading()
                html_product_lists = '';
                if(type_save == 'index'){
                    updateDataCustomerIndex(customerlists[index])
                }else if(type_save == 'create'){
                    $("#tbOrderLine tbody").html('').ready(function(){
                    runLine = 1;
                    updateDataCustomer(customerlists[index]);

                    });
                }

            }
        }else{
            customer_active = ''
            $('#customer_name').val('');
        }
    }
    function addHtmlTable(numberRecord =12) {
        console.log('addHtmlTable')
        var htmlOrderLine = "";
        for (var index = 0; index < numberRecord; index++) {
            htmlOrderLine += '<tr class="align-middle" id="tr_item_'+runLine+'">'+
                '<td><span class="runLine">'+runLine+'</span>'+
                    '<input type="hidden" class="form-control" readonly id="program_code_'+runLine+'" placeholder="" value="">'+
                    '<input type="hidden" id="line_number_'+runLine+'" class="form-control" readonly placeholder="" value="'+runLine+'">'+
                '</td>'+
                '<td class="d-none"><span id="date_latest_'+runLine+'">-</span></td>'+
                '<td class="d-none"><span id="amount_latest_'+runLine+'">0.00</span></td>'+
                '<td>'+
                    '<input type="text" class="form-control" data-id="'+runLine+'" name="item_id['+runLine+']" id="item_id_'+runLine+'" placeholder="" list="product-list-'+runLine+'" autocomplete="off" onchange="changeItem(this);">'+
                    '<datalist id="product-list-'+runLine+'">'+
                        html_product_lists +
                    '</datalist>'+
                    // '<select class="custom-select select2 select-item-list" onchange="changeItem(this);" data-id="'+runLine+'" aria-readonly="true" name="item_id['+runLine+']" id="item_id_'+runLine+'" data-placeholder="รหัสสินค้า">'+
                    //     '<option value=""></option>'+
                    // '</select>'+
                '</td>'+
                '<td class="text-left"><span id="item_name_'+runLine+'"></span></td>'+

                '<td><input type="text" class="form-control md text-center order_cardboardbox" id="chestAmount_'+runLine+'" '+((type_save == "update") ? "readonly" : "")+' autocomplete="off" onkeyup="chestAmount(this)" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><input type="text" class="form-control md text-center order_carton" id="wrapAmount_'+runLine+'" '+((type_save == "update") ? "readonly" : "")+' autocomplete="off" onkeyup="wrapAmount(this)" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><span id="order_quantity_text_'+runLine+'"></span><input class="order_quantity" type="hidden" id="order_quantity_'+runLine+'"/></td>'+

                '<td><input type="text" class="form-control md text-center approve_cardboardbox" id="approveChestAmount_'+runLine+'" readonly onkeyup="approveChestAmount(this)" autocomplete="off" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><input type="text" class="form-control md text-center approve_carton" id="approveWrapAmount_'+runLine+'" readonly onkeyup="approveWrapAmount(this)" autocomplete="off" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><span id="order_quantity_approve_text_'+runLine+'"></span><input class="approve_quantity" type="hidden" id="order_quantity_approve_'+runLine+'"/></td>'+

                '<td class="text-right">'+
                    '<span id="item_price_text_'+runLine+'" style="display:none;">0</span>'+
                    '<input type="text" class="form-control md text-center unit_price_text" readonly id="unit_price_text_'+runLine+'" onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"/>'+
                    '<input type="hidden" class="form-control md text-center unit_price" readonly id="unit_price_'+runLine+'" onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"/>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="sum_amount_text_'+runLine+'">0</span>'+
                    '<input type="hidden" class="sum_amount_item" id="sum_amount_'+runLine+'"/>'+
                '</td>'+
                '<td class="text-right" style="display:none;">'+
                    '<span id="item_quata_use_text_'+runLine+'"></span>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="item_quata_received_text_'+runLine+'"></span>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="item_quata_remaining_text_'+runLine+'"></span>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="item_onhand_quantity_text_'+runLine+'"></span>'+
                '</td>'+
                '<td><a class="fa fa-times red" href="javascript:void(0)" onclick="removeItem('+runLine+')"></a></td>'+
            '</tr>';
            runLine++;
        }
        
        elOrLineLast.html(htmlOrderLine)
        isItem = true
        console.log(isItem, 'isItem')
    }
    function getProductByType(type,delivery_date_send='') {
        $.ajax({
            url: "{{ route('om.ajax.order.prepare.product_by_type') }}",
            method: 'get',
            async: false,
            data: {
                'customer_number' : customer_active,
                'type' : type,
                'date_delivery' : $('#delivery_date').val()
            },
            success: function (response) {

                contractQuata = response.data.contractQuata
                itemList = []
                if(type == '1065'){
                    $.each(contractQuata, function( key, obj ) {
                        var data = {
                            'item' : obj,
                            // 'received_quota' : obj_c.received_quota,
                            // 'remaining_quota' : obj_c.remaining_quota
                        }
                        itemList.push(data)
                    });
                }else{

                    $.each(contractQuata, function( key_c, obj_c ) {
                        $.each(obj_c.quota, function( key, obj ) {
                            var data = {
                                'group' : obj_c.group,
                                'item' : obj,
                                'received_quota' : obj_c.received_quota,
                                'remaining_quota' : obj_c.remaining_quota
                            }
                            itemList.push(data)
                        });
                    });

                }
                // nuk
                // html_product_lists
                $.each(itemList, function( key, obj ) {
                    html_product_lists += "<option value='"+ obj.item.item_code +"'>" + obj.item.item_description + "</option>"
                })
                latest = response.data.latest
                addHtmlTable()

            },
            error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", 'ไม่สามารถค้นหาได้', "error");
            }
        })
    }

    function updateDataCustomerIndex(data){
        var now = new Date();

        console.log('updateDataCustomerIndex')
        $.ajax({
            url: "{{ route('om.ajax.order.prepare.data_customer') }}",
            method: 'get',
            data: {
                'id' : data.customer_id
            },
            success: function (response) {

                console.log(response.data.contractGroups)
                $('#remaining_amount_balance').val(formatMoney(response.data.remainingAmount,2))
                remaining_amount_balance = response.data.remainingAmount
                $('#prepare_order_number').val('').trigger('change')
                $('#order_number').val('').trigger('change')
                // $('#prepare_order_number')
                //     .append($('<option></option>')
                //     .val('')
                //     .html(''));
                // $.each( response.data.orderPrepare, function( key_p, obj_p ) {
                //     $('#prepare_order_number')
                //     .append($('<option></option>')
                //     .attr('data-number', obj_p.order_number)
                //     .attr('data-customer', obj_p.customer_id)
                //     .val(obj_p.prepare_order_number)
                //     .html(obj_p.prepare_order_number));
                // });

                // if(number_prepare !== ''){
                //     $('#prepare_order_number').select2().val(number_prepare).trigger('change.select2');
                // }

                // $('#order_number').empty()
                // $('#order_number')
                //     .append($('<option></option>')
                //     .val('')
                //     .html(''));
                // $.each( response.data.orderNumber, function( key_p, obj_p ) {
                //     $('#order_number')
                //     .append($('<option></option>')
                //     .attr('data-prepare', obj_p.prepare_order_number)
                //     .attr('data-customer', obj_p.customer_id)
                //     .val(obj_p.order_number)
                //     .html(obj_p.order_number));
                // });

                // if(number_order !== ''){
                //     $('#order_number').select2().val(number_order).trigger('change.select2');
                // }

                selectCustomer = true
                Swal.close()

            },
            error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", 'ไม่สามารถค้นหาได้', "error");
            }
        })

    }

    function updateDataCustomer(data){
        var now = new Date();
        // var cid = 0
        // if(date_delivery != ''){
        //     cid =
        // }
        try {
            if(window.delivery_date_new != '') {
                var date = window.delivery_date_new.split('/');
                delivery_date_send = date[2] + "-" + date[1] + "-" + date[0]
            }
        } catch (error) {
            
        }
        if(data.payment_method_id != null){
            $('#payment_method').val(data.payment_method_id).trigger('change');
        }else{
            $('#payment_method').val(10).trigger('change');
        }

        $('#shipment_by').val(data.shipment_by_id).trigger('change');
        $('#shipment_by').val(data.shipment_by_id).trigger('change');

        var order_type = getUrlParameter('order_type');

        if(order_type != ''){
            $('#order_type').val(order_type).trigger('change');
        }else{
            if(data.order_type_id != null){
                $('#order_type').val(data.order_type_id).trigger('change');
            }else{
                $('#order_type').val(1062).trigger('change');
            }

        }
       

        $('#payment_type').val(data.payment_type_id).trigger('change');
        $('#sales_channel').val(data.sales_channel_id).trigger('change');
        $.ajax({
            url: "{{ route('om.ajax.order.prepare.data_customer') }}",
            method: 'get',
            data: {
                'id' : data.customer_id,
                'date_delivery' : delivery_date_send
            },
            success: function (response) {


                $('#remaining_amount_balance').val(formatMoney(response.data.remainingAmount,2))
                remaining_amount_balance = response.data.remainingAmount
                $('#bill_to_site_id').val(response.data.billTo)
                $('#budget_year').val(response.data.budgetYear).prop('readonly', true);
                $('#period_no').val(response.data.periodNo).prop('readonly', true)
                $('#period_line').val(response.data.periodLine).prop('readonly', true)

                contractQuata = response.data.contractQuata
                // itemList = [];
                // console.log(itemList)
                // quata_remaining = [];
                // $.each(contractQuata, function(i, obj_c) {
                //     quata_remaining[obj_c.group.lookup_code] = obj_c.remaining_quota
                //     $.each(obj_c.quota, function( key, obj ) {
                //         console.log(obj.item_description)
                //         var data = {
                //             'group' : obj_c.group,
                //             'item' : obj,
                //             'received_quota' : obj_c.received_quota,
                //             'remaining_quota' : obj_c.remaining_quota
                //         }
                //         itemList.push(data)
                //     });
                //     // itemList.push(item)
                // });


                $('#remaining_amount').val(formatMoney(response.data.remainingLimit,2))
                latest = response.data.latest

                console.log('updateDataCustomer', response.data.dayAmount)
                $("#tb_day_amount > tbody").html('');
                $.each( response.data.dayAmount, function( key, v ) {
                    $("#tb_day_amount > tbody").append(
                        '<tr class="day_amount_'+v.credit_group_code+'" style="">'+
                            '<td><span class="day_amount_description">'+v.description+'</span></td>'+
                            '<td class="text-right day_amount_amount_'+v.credit_group_code+'" data-dateth="'+v.date_th+'"><span class="day_amount_amount">0.00</span></td>'+
                            '<td><span class="day_amount_date_th">'+v.date_th+'</span></td>'+
                        '</tr>'
                    );
                });

                let recontract = []
                $("#tb_outstanding > tbody").html('');
                $.each( response.data.Outstanding, function( key, v ) {
                    if(recontract[v.credit_group_code] == undefined){
                        recontract[v.credit_group_code] = 0
                    }
                    // console.log(( !== undefined)
                    $("#tb_outstanding > tbody").append(
                        '<tr>'+
                            '<td><input type="checkbox" id="outstanding_no_'+v.no+'" class="outstanding_no" data-no="'+v.no+'" data-group="'+v.credit_group_code+'" data-amount="'+v.amount+'" data-penalty="'+v.penalty_total+'"></td>'+
                            '<td>' + ((v.pick_release_no == null) ? '' : v.pick_release_no) + '</td>'+
                            '<td>'+v.description+'</td>'+
                            '<td class="text-right"><span>'+formatMoney(v.amount,2)+'</span></td>'+
                            '<td class="text-right"><span>'+formatMoney(v.penalty_total,2)+'</span></td>'+
                            '<td class="text-right"><span>'+formatMoney(parseFloat(v.amount) + parseFloat(v.penalty_total),2)+'</span></td>'+
                            '<td>'+v.date_th+'</td>'+
                            '<td><input type="checkbox" id="cancel_outstanding_no_'+v.no+'" class="cancel_outstanding_no" data-no="'+v.no+'" data-group="'+v.credit_group_code+'" data-amount="'+v.amount+'" data-penalty="'+v.penalty_total+'"></td>'+
                        '</tr>'
                    );

                    $("#div_outstanding").append(
                        '<input type="hidden" class="form-control text-right" readonly name="outstanding_id['+v.no+']" placeholder="" value="">'+
                        '<input type="hidden" class="form-control text-right" readonly name="outstanding['+v.no+']" placeholder="" value="0">'+
                        '<input type="hidden" class="form-control text-right" readonly name="cancel_outstanding_id['+v.no+']" placeholder="" value="">'+
                        '<input type="hidden" class="form-control text-right" readonly name="cancel_outstanding['+v.no+']" placeholder="" value="0">'
                    )

                    if(v.auto_check){
                        if(v.flag == 'M'){
                            // $('#outstanding_no_'+v.no).prop('disabled', true);
                        }else{
                            
                            $('#outstanding_no_'+v.no).click()
                            // $('#outstanding_no_'+v.no).prop('disabled', true);
                            recontract[v.credit_group_code] += parseFloat(v.amount)
                        }
                    }


                });


                $("#contractGroups").html('');
                $.each( response.data.contractGroups, function( key, v ) {
                    let remaining_amount = v.remaining_amount
                    if(recontract[v.credit_group_code] != undefined){
                        remaining_amount += parseFloat(recontract[v.credit_group_code])
                    }

                    $("#contractGroups").append(
                        '<input type="hidden" class="form-control text-right" readonly name="use_amount['+v.credit_group_code+']" id="use_amount_'+v.credit_group_code+'" placeholder="" value="0.00">'+
                        '<input type="hidden" class="form-control text-right use_received_amount" data-remaining="'+v.remaining_amount+'" data-group="'+v.credit_group_code+'" readonly name="use_received_amount['+v.credit_group_code+']" id="use_received_amount_'+v.credit_group_code+'" placeholder="" value="'+v.credit_amount+'">'+
                        '<input type="hidden" class="form-control text-right" readonly name="use_remaining_amount['+v.credit_group_code+']" id="use_remaining_amount_'+v.credit_group_code+'" placeholder="" value="'+remaining_amount+'">'
                    )
                });


                // $('#prepare_order_number').empty()
                // $('#prepare_order_number')
                //     .append($('<option></option>')
                //     .val('')
                //     .html(''));
                // $.each( response.data.orderPrepare, function( key_p, obj_p ) {
                //     $('#prepare_order_number')
                //     .append($('<option></option>')
                //     .attr('data-number', obj_p.order_number)
                //     .attr('data-customer', obj_p.customer_id)
                //     .val(obj_p.prepare_order_number)
                //     .html(obj_p.prepare_order_number));
                // });

                // if(number_prepare !== ''){
                //     $('#prepare_order_number').select2().val(number_prepare).trigger('change.select2');
                // }

                // $('#order_number').empty()
                // $('#order_number')
                //     .append($('<option></option>')
                //     .val('')
                //     .html(''));
                // $.each( response.data.orderNumber, function( key_p, obj_p ) {
                //     $('#order_number')
                //     .append($('<option></option>')
                //     .attr('data-prepare', obj_p.prepare_order_number)
                //     .attr('data-customer', obj_p.customer_id)
                //     .val(obj_p.order_number)
                //     .html(obj_p.order_number));
                // });

                // if(number_order !== ''){
                //     $('#order_number').select2().val(number_order).trigger('change.select2');
                // }

                // console.log(latest)

                if(order_type != ''){
                    getProductByType(order_type,delivery_date_send)
                }else{
                    getProductByType(data.order_type_id,delivery_date_send)
                }



                // $.each(contractQuata, function( key_c, obj_c ) {
                //     $.each(obj_c.quota, function( key, obj ) {
                //         var data = {
                //             'group' : obj_c.group,
                //             'item' : obj,
                //             'received_quota' : obj_c.received_quota,
                //             'remaining_quota' : obj_c.remaining_quota
                //         }
                //         itemList.push(data)
                //     });
                // });

                $('#ship_to_site_id').empty()
                $.each( response.data.shipSite, function( key, obj ) {
                    $('#ship_to_site_id')
                    .append($('<option></option>')
                    .val(obj.ship_to_site_id)
                    .html(obj.ship_to_site_name)).trigger('change');
                });


                $('#over_due').empty()
                $('#over_due').append($('<option></option>').val('')).trigger('change')
                $.each( response.data.overDue, function( key, obj ) {
                    var over_due = '';
                    var fine = '';
                    if(obj.over_due > 0){
                        over_due = ' หนี้ค้าง : '+obj.over_due
                    }

                    if(obj.fine > 0){
                        fine = ' ค่าปรับ : '+obj.fine
                    }

                    $('#over_due')
                    .append($('<option></option>')
                    .val(obj.amount)
                    .html(obj.description + over_due + fine)).trigger('change');

                });
                if(typeof window.delivery_date_new == 'undefined') {
                    var payment_duedate = moment(response.data.delivery_date, "DD/MM/YYYY").format('DD/MM/YYYY')
                } else {
                    var payment_duedate = moment(window.delivery_date_new, "DD/MM/YYYY").format('DD/MM/YYYY')
                }

                console.log(payment_duedate, response.data.terms.due_days, 'payment_duedate')
                $('#payment_duedate').val(payment_duedate)
                if(typeof window.delivery_date_new == 'undefined') 
                {
                    $('#delivery_date').val(response.data.delivery_date)
                }
                delivery_date_send = moment(response.data.delivery_date).format("YYYY-MM-DD");
                selectCustomer = true
                checkCreate()
                Swal.close()

            },
            error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", 'ไม่สามารถค้นหาได้', "error");
            }
        })

    }

    function changeOrderDate(date){
        console.log(date)
    }

    const genString = (x,budget_year) => {
        // return x;
        while (x.length < 6)
            x = '0' + x;
        return `${(parseInt(budget_year)+543)-2500}O${x}`;
        return x
    }

    function checkCreate() {
        if(create && selectCustomer){
            $('#form_item').css('display','block')
        }else{
            $('#form_item').css('display','none')
        }
    }
    $("#bt_create").click(function(){
        Swal.showLoading()
        $.ajax({
            url: "{{ route('om.ajax.order.prepare.run_number') }}",
            method: 'get',
            success: function (response) {
                // $('#prepare_order_number').val(response.data.prepareNumber)
                // $('#order_number').val(response.data.orderNumber).prop('readonly', true);
                $('#order_number').prop('disabled', true);
                $('#order_date').val(response.data.orderDate)
                $('#prepare_order_number').prop('disabled', true);
                type_save = 'create'
                create = true
                checkCreate()
                Swal.close()

                $('.or-disabled').prop('readonly', false)
                $('.or-disabled').prop('disabled', false)

                // $("#payment_duedate").prop('disabled', false)
                // $("#order_date").prop('disabled', false)
                // $("#delivery_date").prop('disabled', false)

                $("#payment_duedate").removeAttr('disabled');
                $("#order_date").removeAttr('disabled');
                $("#delivery_date").removeAttr('disabled');
                $('#order_status').val('Draft')

                $('#bt_create').attr("disabled",true);
                $('#bt_copy').attr("disabled",true);
                $('#bt_search').attr("disabled",true);
                $('#btn_approve').attr("disabled",true);
            },
            error: function (jqXHR, textStatus, errorRhrown) {

            }
        })
    });

    $("#bt_search").click(function(){
        if($('#prepare_order_number').val() != ''){
            window.location.href = "{{ url('/') }}/om/order/prepare/search?prepare_order_number="+$('#prepare_order_number').val();
        }else{
            Swal.fire({
                title: 'เกิดข้อผิดพลาด',
                text: "กรุณากรอกเลขที่ใบสั่งชื้อ",
                icon: 'warning',
                showConfirmButton: false,
                timer: 3000
            });
        }

    });

    $("#over_due").change(function(){
        if($(this).val() != ''){
            $('#over_fine_amount').val($(this).val())
        }else{
            $('#over_fine_amount').val(0.00)
        }
        updateCredit()
    });

    // $("#bt_search").click(function(){
    //     if($('#order_number').val() == ''){
    //         swal("Warning", 'กรุณากรอกเลขที่ใบสั่งซื้อเพื่อค้นหา', "warning");
    //         return false
    //     }
    //     $('form#form-data').submit();
    // });
    $(document).ready(function(){
        $('.date').datepicker();


        $('.dataTables-example').DataTable({
            pageLength: 10,
            responsive: true,
        });

    });

    var vm = new Vue();

    var delivery_date = '';
    var dateFormat = '{{ trans('date.js-format') }}';
    var disabled = false;

    var order_date = '';
    var dateOrderFormat = '{{ trans('date.js-format') }}';
    var disabledOrderDate = false;

    var vm = new Vue({
        data() {
            return {
                pValue: delivery_date,
                pFormat: dateFormat,
                disabled: disabled
            }
        },
        mounted(){
            console.log('initialize date')
        },
        template: `<datepicker-th
                        style="width: 100%"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        name="delivery_date"
                        id="delivery_date"
                        placeholder="โปรดเลือกวันที่"
                        :disabled="disabled"
                        @dateWasSelected='onchangeDate(...arguments)'
                        :value="pValue"
                        :format=pFormat />`,
        methods: {
            async onchangeDate (date) {
                vm.pValue = date;
                var newDate = moment(date).format("DD/MM/YYYY")
                window.delivery_date_new = newDate
                delivery_date_send = moment(date).format("YYYY-MM-DD")
                $.when(custchange($('#customer_number').val())).done(function(){
                    setTimeout(function(){
                        setDayAmount(newDate)
                    }, 1500);
                })
                clearOrderLine();
                // updateDataCustomer(customer_id,moment(date).format("YYYY-MM-DD"));
            }
        },
        watch: {
            pValue : async function (value, oldValue) {
                // console.log('xxx', value, oldValue);
            }
        },
    }).$mount('#input_delivery_date')

    var vm = new Vue({
        data() {
            return {
                pOrderValue: order_date,
                pFormat: dateOrderFormat,
                disabled: disabledOrderDate
            }
        },
        template: `<datepicker-th
                        style="width: 100%"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        name="order_date"
                        id="order_date"
                        placeholder="โปรดเลือกวันที่"
                        :disabled="disabled"
                        @dateWasSelected='onchangeDate(...arguments)'
                        :value=pOrderValue
                        :format=pFormat />`,
        methods: {
            async onchangeDate (date) {
                vm.pOrderValue = date;
                var newDate = moment(date).format("DD/MM/YYYY")
            }
        },
        watch: {
            pOrderValue : async function (value, oldValue) {
                // console.log('xxx', value, oldValue);
            }
        },
    }).$mount('#input_order_date')

</script>

@if (request()->order_type == 1065)
    @include('om/preparation/_script_order_line_other')
@else
    @include('om/preparation/_script_order_line')
@endif

@stop
