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
                    <button class="btn btn-md btn-success" type="button" disabled id="bt_create"><i class="fa fa-plus"></i> สร้าง</button>
                    @if (request() && request()->prepare_order_number)
                    <button class="btn btn-md btn-white" type="button" disabled id="bt_search"><i class="fa fa-search"></i> ค้นหา</button>
                    @else
                    <button class="btn btn-md btn-white" type="button" id="bt_search"><i class="fa fa-search"></i> ค้นหา</button>
                    @endif

                    <!--button class="btn btn-md btn-success w-en" type="button"><i class="fa fa-upload"></i> Attachment</button-->
                    {{-- <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> แนบไฟล์</span></button>

                    <button class="btn btn-md btn-warning" type="button" onclick="window.open(`{{ url('/') }}/om/order/prepare/report_order?prepare_order_number={{ $data['order']->prepare_order_number }}`, '_blank')" ><i class="fa fa-print"></i> พิมพ์ใบสั่งชื้อ</button>
                    <button class="btn btn-md btn-info" type="button" onclick="window.open(`{{ url('/') }}/om/order/prepare/report_preparation?prepare_order_number={{ $data['order']->prepare_order_number }}`, '_blank')"><i class="fa fa-print"></i> พิมพ์ใบเตรียมการขาย</button>

                    @if ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status))
                    <div class="dropdown">
                        <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" id="btn_save">บันทึก</a></li>
                            <li><a href="javascript:void(0)" id="btn_confirm">ยืนยัน</a></li>
                            <li><a href="javascript:void(0)" id="btn_cancel">ยกเลิก</a></li>
                        </ul>
                    </div>
                    @elseif ($data['order']->order_status == 'Confirm' || $data['order']->order_status == 'Reject')
                    <div class="dropdown">
                        <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" id="btn_cancel">ยกเลิก</a></li>
                        </ul>
                    </div>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-md btn-white m-0" data-toggle="dropdown" disabled type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" id="btn_save">บันทึก</a></li>
                            <li><a href="javascript:void(0)" id="btn_confirm">ยืนยัน</a></li>
                            <li><a href="javascript:void(0)" id="btn_cancel">ยกเลิก</a></li>
                        </ul>
                    </div>
                    @endif

                    @if (!is_null($data['orderLastStatus']))
                        @if($data['orderLastStatus']->order_status == 'Inprocess')
                        <button class="btn btn-md btn-primary" type="button" id="btn_approve" disabled><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button>
                        @else
                            @if (($data['order']->order_status == 'Draft' || $data['order']->order_status == 'Confirm') && $data['order']->payment_approve_flag == 'N')
                            <button class="btn btn-md btn-primary" type="button" id="btn_approve"><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button>
                            @else
                            <button class="btn btn-md btn-primary" type="button" id="btn_approve" disabled><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button>
                            @endif
                        @endif
                    @else
                    <button class="btn btn-md btn-primary" type="button" id="btn_approve" disabled><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button>
                    @endif --}}

                </div>
            </div><!--form-header-buttons-->

            <div class="hr-line-dashed"></div>
        </div><!--col-12-->
        <form id="form-order" class="container" style="padding: 0px 8px;max-width:100%;" data-action="{{ url('/') }}/om/order/prepare/update/submit">
            {{ csrf_field() }}

            <input type="hidden" name="order_status" id="order_status" value="{{ $data['order']->order_status }}"/>
            <input type="hidden" name="order_header_id" id="order_header_id" value="{{ $data['order']->order_header_id }}"/>
            <input style="display: none;" name="form_type" id="form_type" value=""/>
            <input type="hidden" name="pick_release_approve_date" id="pick_release_approve_date" value="{{ $data['order']->pick_release_approve_date }}"/>
            <button type="submit" id="btn_order" style="display: none;"></button>
            @foreach($data['Outstanding'] as $val)
                @if($val['flag'] == 'Y' )
                <input type="hidden" class="form-control text-right" readonly name="outstanding_id[{{ $val['no'] }}]" placeholder="" value="{{ $val['no'] }}">
                <input type="hidden" class="form-control text-right" readonly name="outstanding_rm[{{ $val['no'] }}]" placeholder="" value="{{ $val['no'] }}">
                <input type="hidden" class="form-control text-right" readonly name="outstanding[{{ $val['no'] }}]" placeholder="" value="{{ $val['amount'] }}">
                    @if($val['improveFines'] == 'Y')
                    <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding_id[{{ $val['no'] }}]" placeholder="" value="{{ $val['no'] }}">
                    <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding_rm[{{ $val['no'] }}]" placeholder="" value="{{ $val['no'] }}">
                    <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding[{{ $val['no'] }}]" placeholder="" value="{{ $val['amount'] }}">
                    @else
                    <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding_id[{{ $val['no'] }}]" placeholder="" value="">
                    <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding_rm[{{ $val['no'] }}]" placeholder="" value="">
                    <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding[{{ $val['no'] }}]" placeholder="" value="0">
                    @endif
                @else
                <input type="hidden" class="form-control text-right" readonly name="outstanding_id[{{ $val['no'] }}]" placeholder="" value="">
                <input type="hidden" class="form-control text-right" readonly name="outstanding_rm[{{ $val['no'] }}]" placeholder="" value="">
                <input type="hidden" class="form-control text-right" readonly name="outstanding[{{ $val['no'] }}]" placeholder="" value="0">

                <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding_id[{{ $val['no'] }}]" placeholder="" value="">
                <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding_rm[{{ $val['no'] }}]" placeholder="" value="">
                <input type="hidden" class="form-control text-right" readonly name="cancel_outstanding[{{ $val['no'] }}]" placeholder="" value="0">
                @endif
            @endforeach
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">เลขที่ใบเตรียมขาย</label>
                            <div class="input-icon">
                                <input type="text" class="form-control" readonly name="prepare_order_number" id="prepare_order_number" placeholder="" value="{{ $data['order']->prepare_order_number }}">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">เลขที่ใบสั่งซื้อ</label>
                            <div class="input-icon">
                                <input type="text" class="form-control" readonly name="order_number" id="order_number" placeholder="เลขที่ใบสั่งซื้อ" value="{{ $data['order']->order_number }}">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">เลขที่ PO ของลูกค้า</label>
                            <input type="text" class="form-control" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} name="cust_po_number" id="cust_po_number" placeholder="เลขที่ PO ของลูกค้า" value="{{ $data['order']->cust_po_number }}">
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Order Status</label>
                            <div class="row space-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" disabled name="order_status" id="order_status" placeholder="" value="{{ (is_null($data['order']->order_status)) ? 'Draft' : $data['order']->order_status }}">
                                        {{-- <i class="fa fa-search"></i> --}}
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2 mt-md-0">
                                    <div class="i-checks f13"><label><input type="checkbox" value="option_d1" name="a" {{ $data['order']->payment_approve_flag == 'Y' ? 'checked' : '' }} disabled><span class="nowrap">ยอดส่งได้รับการอนุมัติ</span></label></div>
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-xl-9">
                        <div class="form-group">
                            <label class="d-block">รหัสลูกค้า</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" name="customer_number" id="customer_number" placeholder="" readonly value="{{ $data['customersOrder']->customer_number }}" list="customer-list" onchange="custchange(this.value);">
                                        <i class="fa fa-search"></i>
                                        <datalist id="customer-list">
                                            @foreach ($data['customers'] as $item)
                                                <option value="{{ $item->customer_number }}">{{ $item->customer_name_format }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-2 mt-md-0">
                                    <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="" value="{{ $data['customersOrder']->customer_name_format }}">
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="d-block">วิธีการชำระเงิน</label>
                            <select class="custom-select select2" style="width: 100%;" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} id="payment_method" name="payment_method" data-placeholder="วิธีการชำระเงิน">
                                <option value=""></option>
                                @foreach ($data['paymentMethod'] as $item)
                                <option value="{{ $item->lookup_code }}" {{ ($item->lookup_code == $data['order']->payment_method_code) ? 'selected' : '' }}>{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group" id="payment_duedate_date" style="{{ ($data['dayAmountUse'] > 1) ? 'display:none;' : 'display:block;' }}">
                            <label class="d-block">วันครบกำหนดชำระ</label>
                            <datepicker-th
                                        style="width: 100%"
                                        class="form-control"
                                        name="payment_duedate"
                                        id="payment_duedate"
                                        placeholder="โปรดเลือกวันที่"
                                        disabled
                                         {{-- {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} --}}
                                        value="{{ $data['dayAmountActive'] }}"
                                        format="{{ trans("date.js-format") }}">
                        </div>
                        <div class="form-group" id="payment_duedate_modal" style="{{ ($data['dayAmountUse'] > 1) ? 'display:block;' : 'display:none;' }}">
                            <label class="d-block">วันครบกำหนดชำระ</label>
                            <div class="form-control" onclick="viewDayAmount()" style="background: white;text-decoration: underline;color: #2196f3;cursor: pointer;">วันครบกำหนดชำระ</div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">สั่งทาง</label>
                            <select class="custom-select select2" style="width: 100%;" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} id="sales_channel" name="sales_channel" data-placeholder="สั่งทาง">
                                <option value=""></option>
                                @foreach ($data['salesChannel'] as $item)
                                <option value="{{ $item->lookup_code }}" {{ (strtolower($item->lookup_code) == strtolower($data['order']->source_system)) ? 'selected' : '' }}>{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">หมายเหตุสั่งทาง</label>
                            <input type="text" class="form-control" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} name="remark_source_system" id="remark_source_system" placeholder="" value="{{ $data['order']->remark_source_system }}">
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group mw-100">
                            <label class="d-block">วันที่สั่ง</label>
                            <datepicker-th
                                        style="width: 100%"
                                        class="form-control"
                                        name="order_date"
                                        id="order_date"
                                        placeholder="โปรดเลือกวันที่"
                                        {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }}
                                        value="{{ dateFormatThai($data['order']->order_date) }}"
                                        format="{{ trans("date.js-format") }}">
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <!-- <div class="form-group">
                            <label class="d-block">หนี้ค้างชำระ</label>
                            <select class="custom-select select2" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} style="width: 100%;" aria-readonly="true" name="over_due" id="over_due" data-placeholder="">
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
                            <select class="custom-select select2" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} style="width: 100%;" id="shipment_by" name="shipment_by" data-placeholder="ส่งโดย">
                                <option value=""></option>
                                @foreach ($data['shipmentBy'] as $item)
                                <option value="{{ $item->lookup_code }}" {{ ($item->lookup_code == $data['order']->transport_type_code) ? 'selected' : '' }}>{{ $item->description }}</option>
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
                                        class="form-control"
                                        name="delivery_date"
                                        id="delivery_date"
                                        placeholder="โปรดเลือกวันที่"
                                        dateWasSelected="changeDate"
                                        {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }}
                                        format="{{ trans("date.js-format") }}"> -->
                            <!-- <datepicker-th
                                        style="width: 100%"
                                        class="form-control"
                                        name="delivery_date"
                                        id="delivery_date"
                                        v-model="delivery_date"
                                        placeholder="โปรดเลือกวันที่"
                                        v-on:change="changeDate($event)"
                                        {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }}
                                        value="{{ dateFormatThai($data['order']->delivery_date) }}"
                                        format="{{ trans("date.js-format") }}"> -->
                        </div>
                    </div><!--col-->


                    <div class="col-xl-3 col-md-6">
                        <div class="form-group mw-100">
                            <label class="d-block">ปีงบ/งวด</label>
                            <div class="row space-5">
                                <div class="col-8">
                                    <input type="text" class="form-control"  name="budget_year" id="budget_year" readonly placeholder="" value="{{ (!is_null($data['budgetYear'])) ? '25'.$data['budgetYear'] : '' }}">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control"  name="period_no" id="period_no" readonly placeholder="" value="{{ (!is_null($data['periodV'])) ? $data['periodV']->period_no : '' }}">
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">ประเภทการจ่ายเงิน</label>
                            <select class="custom-select select2" style="width: 100%;" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} name="payment_type" id="payment_type" data-placeholder="ประเภทการจ่ายเงิน">
                                <option value=""></option>
                                @foreach ($data['paymenType'] as $item)
                                <option value="{{ $item->lookup_code }}" {{ ($item->lookup_code == $data['order']->payment_type_code) ? 'selected' : '' }}>{{ $item->description }}</option>
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
                            <select class="custom-select select2" style="width: 100%;" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} name="order_type" id="order_type" data-placeholder="ประเภทออเดอร์">
                                <option value=""></option>
                                @foreach ($data['transactionType'] as $item)
                                <option value="{{ $item->order_type_id }}" {{ ($item->order_type_id == $data['order']->order_type_id) ? 'selected' : '' }}>{{ $item->order_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Bill To</label>
                            <div class="input-icon">
                                <input type="text" class="form-control" readonly name="bill_to_site_id" id="bill_to_site_id" placeholder="" value="{{ $data['customersOrder']->customer_name }}">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Ship To</label>
                            <select class="custom-select select2" style="width: 100%;" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} name="ship_to_site_id" id="ship_to_site_id" data-placeholder="Ship To">
                                <option value=""></option>
                                @foreach ($data['shipSite'] as $item)
                                <option value="{{ $item->ship_to_site_id }}" {{ ($item->ship_to_site_id == $data['order']->ship_to_site_id) ? 'selected' : '' }}>{{ $item->ship_to_site_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->
                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            {{-- Attribute6 --}}
                            <label class="d-block">ที่อยู่ใบแจ้งหนี้ตามสถานที่ Ship-to</label>
                            <input type="checkbox" name="attribute6" id="" {{ $data['order']->attribute6 == '1' ? 'checked' : '' }}>
                        </div>
                    </div><!--col-->
<!--
                    <div class="col-xl-3 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Salesperson</label>
                            <div class="input-icon">
                                <input type="text" class="form-control" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} name="" placeholder="" value="">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div> -->
                    <!--col-->

                    <!--//-->

                    <div class="col-xl-9">
                        <div class="form-group mw-100">
                            <label class="d-block">หมายเหตุรายการ</label>
                            <input type="text" class="form-control" {{ ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) ? '' : 'disabled' }} name="remark" id="remark" placeholder="" value="{{ $data['order']->remark }}">
                        </div>
                    </div><!--col-->

                </div><!--row-->
            </div><!--col-xl-6-->

            <div class="col-xl-12">
                <hr class="lg">
                <div class="form-header-buttons">
                    <div class="buttons multiple">
                        @if(($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) && $data['order']->product_type_code == 10 )
                        <button class="btn btn-md btn-success" type="button" onclick="addOrderLine()"><i class="fa fa-plus"></i> สร้าง</button>
                        @endif
                        {{-- <button class="btn btn-md btn-primary" type="button"><i class="fa fa-save"></i> บันทึก</button> --}}
                    </div>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>

                @if($data['order']->product_type_code == 20)
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
                                    <input type="text" class="form-control text-right" readonly name="cash_amount" id="cash_amount" placeholder="" value="{{ number_format($data['order']->cash_amount,2) }}">
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">เงินเชื่องวดนี้</label>
                                    <input type="text" class="form-control text-right" readonly name="credit_amount" id="credit_amount" placeholder="" value="{{ number_format($data['order']->credit_amount,2) }}">
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">เงินคงเหลือ</label>
                                    <input type="text" class="form-control text-right" readonly placeholder="" value="{{ number_format($data['order']->remaining_amount,2) }}">
                                    <input type="hidden" class="form-control text-right" readonly name="remaining_amount" id="remaining_amount" placeholder="" value="{{ number_format($data['orderCreditUse']['received_amount'],2) }}">
                                    @foreach($data['contractGroups'] as $val)
                                    <input type="hidden" class="form-control text-right" readonly name="use_amount[{{ $val->credit_group_code }}]" id="use_amount_{{ $val->credit_group_code }}" placeholder="" value="{{ $val->view_amount }}">
                                    <input type="hidden" class="form-control text-right use_received_amount" data-remaining="{{ $val->view_remaining_amount }}" data-group="{{ $val->credit_group_code }}" readonly name="use_received_amount[{{ $val->credit_group_code }}]" id="use_received_amount_{{ $val->credit_group_code }}" placeholder="" value="{{ $val->view_received_amount }}">
                                    <input type="hidden" class="form-control text-right" readonly name="use_remaining_amount[{{ $val->credit_group_code }}]" id="use_remaining_amount_{{ $val->credit_group_code }}" placeholder="" value="{{ $val->view_remaining_amount }}">
                                    @endforeach
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">หนี้ที่ต้องชำระและค่าปรับ</label>
                                    <input type="text" class="form-control text-right" readonly name="over_fine_amount" id="over_fine_amount" placeholder="" value="{{ number_format(($data['order']->fines_amount),2) }}">
                                    <input type="hidden" class="form-control text-right" readonly name="cancel_over_fine_amount" id="cancel_over_fine_amount" placeholder="" value="{{ number_format($data['cancel_over_fine_amount'],2) }}">
                                </div>
                            </div><!--col-md-4-->

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block black">รวมเงินที่ต้องชำระ</label>
                                    @php 
                                    if($data['customersOrder']->customer_type_id == 40):
                                        $grand_total_text = $data['order']->cash_amount;
                                    else :
                                        $grand_total_text = (($data['order']->cash_amount + $data['order']->fines_amount) - $data['order']->remaining_amount);
                                    endif; 
                                    @endphp
                                   
                                    <input type="text" class="form-control text-right" readonly name="grand_total_text" id="grand_total_text" placeholder="" value="{{ number_format(($grand_total_text > 0) ? $grand_total_text : 0,2) }}">
                                    <input type="hidden" class="form-control text-right" readonly name="grand_total" id="grand_total" placeholder="" value="{{ number_format($data['order']->grand_total,2) }}">
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
    <div class="modal modal-800 fade" id="cancelModal" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form id="formCancelPo" autocomplete="none" enctype="multipart/form-data">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="modal-header">
                        <h3>ยกเลิกใบเตรียมการขาย </h3>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <div class="attachment-box">
                            <div class="col-xl-10 m-auto">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="d-block">เหตุผลที่ยกเลิก</label> <textarea name="po_cancel_reason" required id="po_cancel_reason" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--col-xl-6-->
                        </div>
                    </div><!--modal-body-->
                    <div class="modal-footer center mt-4">
                        <button class="btn btn-danger btn-lg" type="button" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            ปิด
                        </button>
                        <button class="btn btn-primary btn-lg" type="sumnit">
                            <i class="fa fa-check"></i>
                            ยืนยัน
                        </button>
                    </div>
                </form>
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal-->

    <div class="modal modal-800 fade" id="datePaymentModal" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form autocomplete="none" enctype="multipart/form-data">
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
                                            <table class="table table-bordered text-center f13" id="tb_day_amount">
                                                <thead>
                                                    <tr class="align-middle">
                                                        <th>กลุ่มวงเงิน</th>
                                                        <th>จำนวนเงิน</th>
                                                        <th>วันครบกำหนดชำระ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data['dayAmount'] as $val)
                                                    <tr class="day_amount_{{ $val['credit_group_code'] }}" style="{{ (!$val['use']) ? 'display:none' : '' }}">
                                                        <td>{{ $val['description'] }}</td>
                                                        <td class="text-right"><span class="day_amount_amount_{{ $val['credit_group_code'] }}" data-dateth="{{ $val['date_th'] }}">{{ number_format($val['amount'],2) }}</span></td>
                                                        <td>{{ $val['date_th'] }}</td>
                                                    </tr>
                                                    @endforeach
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
                <form autocomplete="none" enctype="multipart/form-data">
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
                                            <table class="table table-bordered text-center f13">
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
                                                    @foreach($data['Outstanding'] as $val)
                                                    <tr>
                                                        <td>

                                                            <input type="checkbox"
                                                            {{-- {{ (( (($data['order']->order_status == 'Draft' || is_null($data['order']->order_status) || ($val['flag'] == 'Y')) && $val['flag'] != 'M') && $val['improveFines'] == 'N') && $val['credit_group_code'] != 0) ? '' : 'disabled' }} --}}
                                                            {{ ($val['auto_check'] == 'Y') ? 'checked' : '' }}
                                                            {{-- {{ (($data['order']->order_status == 'Draft' && $val['auto_check']) || $data['order']->order_status == 'Confirm') ? 'disabled' : '' }} --}}
                                                            id="outstanding_no_{{ $val['no'] }}"
                                                            class="outstanding_no"
                                                            data-no="{{ $val['no'] }}"
                                                            data-group="{{ $val['credit_group_code'] }}"
                                                            data-amount="{{ $val['amount'] }}"
                                                            data-penalty="{{ $val['penalty_total'] }}"
                                                            >
                                                        </td>
                                                        <td>{{ ($val['pick_release_no'] == null) ? '' : $val['pick_release_no'] }}</td>
                                                        <td>{{ $val['description'] }}</td>
                                                        <td class="text-right"><span>{{ number_format($val['amount'],2) }}</span></td>
                                                        <td class="text-right"><span>{{ number_format($val['penalty_total'],2) }}</span></td>
                                                        <td class="text-right"><span>{{ number_format($val['amount'] + $val['penalty_total'],2) }}</span></td>
                                                        <td>{{ $val['date_th'] }}</td>
                                                        <td>
                                                            <input type="checkbox"
                                                            {{ (($data['order']->order_status == 'Draft' || is_null($data['order']->order_status)) && ($val['improveFines'] == 'N')) ? '' : 'disabled' }}
                                                            {{ ($val['improveFines'] == 'Y') ? 'checked' : '' }}
                                                            id="cancel_outstanding_no_{{ $val['no'] }}"
                                                            class="cancel_outstanding_no"
                                                            data-no="{{ $val['no'] }}"
                                                            data-group="{{ $val['credit_group_code'] }}"
                                                            data-amount="{{ $val['amount'] }}"
                                                            data-penalty="{{ $val['penalty_total'] }}"
                                                            >
                                                        </td>
                                                    </tr>
                                                    @endforeach
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

                    <button class="btn btn-md btn-warning" type="button" onclick="window.open(`{{ url('/') }}/om/order/prepare/report_order?prepare_order_number={{ $data['order']->prepare_order_number }}`, '_blank')" ><i class="fa fa-print"></i> พิมพ์ใบสั่งชื้อ</button>
                    <button class="btn btn-md btn-info" type="button" onclick="window.open(`{{ url('/') }}/om/order/prepare/report_preparation?prepare_order_number={{ $data['order']->prepare_order_number }}`, '_blank')"><i class="fa fa-print"></i> พิมพ์ใบเตรียมการขาย</button>

                    @if ($data['order']->order_status == 'Draft' || is_null($data['order']->order_status))
                        <div class="dropdown" style="display: inline;">
                            <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" id="btn_save">บันทึก</a></li>
                                <li><a href="javascript:void(0)" id="btn_confirm">ยืนยัน</a></li>
                                <li><a href="javascript:void(0)" id="btn_cancel">ยกเลิก</a></li>
                            </ul>
                        </div>
                    @elseif ($data['order']->order_status == 'Confirm' || $data['order']->order_status == 'Reject')
                        <div class="dropdown" style="display: inline;">
                            <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" id="re_cal">คำนวณวงเงินใหม่</a></li>
                                <li><a href="javascript:void(0)" id="btn_cancel">ยกเลิก</a></li>
                            </ul>
                        </div>
                    @else
                        <div class="dropdown" style="display: inline;">
                            <button class="btn btn-md btn-white m-0" data-toggle="dropdown" disabled type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" id="btn_save">บันทึก</a></li>
                                <li><a href="javascript:void(0)" id="btn_confirm">ยืนยัน</a></li>
                                <li><a href="javascript:void(0)" id="btn_cancel">ยกเลิก</a></li>
                            </ul>
                        </div>
                    @endif
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
    var contractQuata = {!! json_encode($data['contractQuata']) !!}
    var orderLine = {!! json_encode($data['orderLine']) !!}

    let itemList = []
    let groupQuota = []
    let runOrderLine = "{!! $data['runOrderLine']+1 !!}"
    let runLine = "{!! $data['runOrderLine']+1 !!}"
    let totalLine = "{!! $data['runOrderLine']+1 !!}"
    let creditLimit = 0
    let remainingLimit = 0
    let useAmount = 0
    let create = false
    let selectCustomer = false
    let latest = {!! json_encode($data['latest']) !!}
    let type_save = 'update'
    let over_fine_amount = formatConvertMoney($('#over_fine_amount').val())
    let cancel_over = formatConvertMoney($('#cancel_over_fine_amount').val())
    let remaining_amount_balance = "{!! $data['order']->remaining_amount !!}";
    let isItem = true;

    setTimeout(() => {
        updateSummary()
        updateApproveSummary()
    }, 2000);

    function isCheckNumber(evt)
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

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

    function custchange(v){
        if(v != ''){
            var index = _.findIndex(customerlists, function(o) {return o['customer_number'] == v;});
            if(index != -1){
                $('#customer_name').val(customerlists[index]['customer_name']);
                Swal.showLoading()
                updateDataCustomer(customerlists[index])
            }
        }else{
            $('#customer_name').val('');
        }
    }

    function updateDataCustomer(data){
        var now = new Date();

        $('#payment_method').val(data.payment_method_id).trigger('change');
        $('#shipment_by').val(data.shipment_by_id).trigger('change');
        $('#shipment_by').val(data.shipment_by_id).trigger('change');
        $('#order_type').val(data.order_type_id).trigger('change');
        $('#payment_type').val(data.payment_type_id).trigger('change');
        $('#sales_channel').val(data.sales_channel_id).trigger('change');

        $.ajax({
            url: "{{ route('om.ajax.order.prepare.data_customer') }}",
            method: 'get',
            data: {
                'id' : data.customer_id
            },
            success: function (response) {
                $('#bill_to_site_id').val(response.data.billTo)
                $('#budget_year').val(response.data.budgetYear).prop('readonly', true);
                $('#period_no').val(response.data.periodNo).prop('readonly', true)

                console.log(response.data)

                contractQuata = response.data.contractQuata
                $('#remaining_amount').val(formatMoney(response.data.remainingLimit,2))
                latest = response.data.latest
                // console.log(latest)
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

                $('#payment_duedate').val(response.data.payment_duedate)
                $('#delivery_date').val(response.data.delivery_date)

                selectCustomer = true
                checkCreate()
                Swal.close()

            },
            error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", 'ไม่สามารถค้นหาได้', "error");
            }
        })

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

    function cancelPreparation() {

    }

    $("#bt_create").click(function(){
        Swal.showLoading()
        $.ajax({
            url: "{{ route('om.ajax.order.prepare.run_number') }}",
            method: 'get',
            success: function (response) {
                $('#prepare_order_number').val(response.data.prepareNumber)
                $('#order_number').val(response.data.orderNumber)
                $('#order_date').val(response.data.orderDate)

                create = true
                checkCreate()
                Swal.close()
                $('#bt_create').attr("disabled",true);
                $('#bt_copy').attr("disabled",true);
                $('#bt_search').attr("disabled",true);
                $('#btn_approve').attr("disabled",true);
            },
            error: function (jqXHR, textStatus, errorRhrown) {

            }
        })
    });

    $("#over_due").change(function(){
        if($(this).val() != ''){
            $('#over_fine_amount').val($(this).val())
        }else{
            $('#over_fine_amount').val(0.00)
        }
        updateCredit()
    });

    $("#bt_search").click(function(){
        if($('#order_number').val() == ''){
            swal("Warning", 'กรุณากรอกเลขที่ใบสั่งซื้อเพื่อค้นหา', "warning");
            return false
        }
        $('form#form-data').submit();
    });

    $(document).on('click', '#re_cal', function() {
        console.log('########## Action recallulator ');
        Swal.fire({
            title: 'แจ้งเตือน',
            text: "ต้องการคำนวนออเดอร์ใหม่หรือไม่?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1ab394',
            cancelButtonColor: '#e7eaec',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then(function(result) {
            if (result.isConfirmed) {
                location.href = '/pm/ajax/recalculator-remaining-amount-order/{{$data['order']->prepare_order_number}}';
            }
        })
    });

    $("#formCancelPo").submit(async function(e) {
        e.preventDefault();
        let fb = this // this
        let formData = new FormData(fb);
        formData.append('_token','{{ csrf_token() }}');
        $('#cancelModal').modal('hide')
        Swal.fire({
            title: 'แจ้งเตือน',
            text: "ต้องการยกเลิกใบเตรียมการขาย?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1ab394',
            cancelButtonColor: '#e7eaec',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading()
                $.ajax({
                    type: 'post',
                    url: "{{ url('/') }}/om/order/prepare/cancel/"+$('#order_header_id').val(),
                    data: formData,
                    enctype: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        console.log(result)
                        if(!result.status){
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด',
                                text: result.message,
                                icon: 'warning',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }else{

                            Swal.fire({
                                title: 'บันทึกข้อมูล',
                                text: "บันทึกข้อมูลสำเร็จ",
                                icon: 'success',
                                showConfirmButton: false
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 2000);

                        }

                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }else{
                Swal.close()
                $('#cancelModal').modal('show')
            }
        })
    })

    $("#btn_cancel").click(async function(){
        $('#cancelModal').modal('show')
        // const { value: text } = await Swal.fire({
        //     title: 'แจ้งเตือน',
        //     text: "ต้องการยกเลิกใบเตรียมการขาย?",
        //     input: 'textarea',
        //     inputLabel: 'ระบุเหตุผลที่ต้องการยกเลิก',
        //     inputPlaceholder: 'ระบุเหตุผลที่ต้องการยกเลิก...',
        //     inputAttributes: {
        //         'aria-label': 'ระบุเหตุผลที่ต้องการยกเลิก'
        //     },
        //     showCancelButton: true,
        //     confirmButtonColor: '#1ab394',
        //     confirmButtonText: 'ยืนยัน',
        //     cancelButtonText: 'ยกเลิก'
        // })

        // if (text) {
        //     console.log(text)
        //     return false
        //     // Swal.fire(text)
        // }else{
        //     Swal.close()
        // }
        // Swal.fire({
        //     title: 'แจ้งเตือน',
        //     text: "ต้องการยกเลิกใบเตรียมการขาย?",
        //     icon: 'question',
        //     showCancelButton: true,
        //     confirmButtonColor: '#1ab394',
        //     cancelButtonColor: '#e7eaec',
        //     confirmButtonText: 'ยืนยัน',
        //     cancelButtonText: 'ยกเลิก'
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         Swal.showLoading()
        //         $.ajax({
        //             type: 'get',
        //             url: "{{ url('/') }}/om/order/prepare/cancel/"+$('#order_number').val(),
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             success: function (result) {

        //                 if(!result.status){
        //                     Swal.fire({
        //                         title: 'เกิดข้อผิดพลาด',
        //                         text: "กรุณาตรวจสอบข้อมูลอีกครั้ง",
        //                         icon: 'warning',
        //                         showConfirmButton: false,
        //                         timer: 3000
        //                     });
        //                 }else{

        //                     Swal.fire({
        //                         title: 'บันทึกข้อมูล',
        //                         text: "บันทึกข้อมูลสำเร็จ",
        //                         icon: 'success',
        //                         showConfirmButton: false
        //                     });

        //                     setTimeout(function() {
        //                         location.reload();
        //                     }, 2000);
        //                 }

        //             },
        //             error: function (error) {
        //                 console.log(error)
        //             }
        //         });
        //     }else{
        //         Swal.close()
        //     }
        // })
    });

    $("#btn_approve").click(function(){
        console.log('asdsadsad')
        if($('#order_header_id').val() != ''){
            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ต้องการส่งข้อมูลอนุมัติตั้งหนี้ ใช่หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading()
                    $.ajax({
                        type: 'get',
                        url: "{{ url('/') }}/om/order/prepare/approve/"+$('#order_header_id').val(),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            console.log(result)

                            if(!result.status){
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    text: "กรุณาตรวจสอบข้อมูลอีกครั้ง",
                                    icon: 'warning',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }else{

                                Swal.fire({
                                    title: 'บันทึกข้อมูล',
                                    text: "บันทึกข้อมูลสำเร็จ",
                                    icon: 'success',
                                    showConfirmButton: false
                                });

                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
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
        }
    });

    $("#bt_copy").click(function(){
        if($('#order_number').val() != ''){
            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ต้องการคัดลอกเลขที่ใบสั่งซื้อ "+$('#order_number').val()+"?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#e7eaec',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading()
                    $.ajax({
                        type: 'get',
                        url: "{{ url('/') }}/om/order/prepare/copy/"+$('#order_number').val(),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            console.log(result)

                            if(!result.status){
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    text: "กรุณาตรวจสอบข้อมูลอีกครั้ง",
                                    icon: 'warning',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }else{

                                Swal.fire({
                                    title: 'บันทึกข้อมูล',
                                    text: "บันทึกข้อมูลสำเร็จ",
                                    icon: 'success',
                                    showConfirmButton: false
                                });

                                setTimeout(function() {
                                    window.location.href = "{{ url('/') }}/om/order/prepare/search?order_number="+result.order_number;
                                }, 2000);
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
        }
    });

    $(document).ready(function(){
        $('.date').datepicker();


        $('.dataTables-example').DataTable({
            pageLength: 10,
            responsive: true,
        });

    });

</script>

<script>

    var vm = new Vue();

    var delivery_date = '{!! dateFormatThai($data['order']->delivery_date) !!}';
    var dateFormat = '{{ trans('date.js-format') }}';
    var disabled = ($('#order_status').val() == 'Draft') ? false : true;

    var vm = new Vue({
        data() {
            return {
                pValue: delivery_date,
                pFormat: dateFormat,
                disabled: disabled
            }
        },
        template: `<datepicker-th
                        style="width: 100%"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        name="delivery_date"
                        id="delivery_date"
                        placeholder="โปรดเลือกวันที่"
                        :disabled="disabled"
                        @dateWasSelected='onchangeDate(...arguments)'
                        :value=pValue
                        :format=pFormat />`,
        methods: {
            async onchangeDate (date) {
                vm.pValue = date;
                var newDate = moment(date).format("DD/MM/YYYY")
                setDayAmount(newDate)
            }
        },
        watch: {
            pValue : async function (value, oldValue) {
                // console.log('xxx', value, oldValue);
            }
        },
    }).$mount('#input_delivery_date')

</script>

@if($data['order']->product_type_code == 20)
    @include('om/preparation/_script_order_line_other')
@else
    @include('om/preparation/_script_order_line')
@endif


@stop
