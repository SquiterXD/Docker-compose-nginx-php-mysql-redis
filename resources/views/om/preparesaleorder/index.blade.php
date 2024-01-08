@extends('layouts.app')

@section('title', 'ใบเตรียมการขาย ส่งเสริม ยสท. /บุหรี่ทดลอง/บุหรี่ตัวอย่าง')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

    <style>
        /* .disabled {
            pointer-events: none;
            cursor: default;
            background: rgb(194, 194, 194);
        } */

        .form-control:disabled, .form-control[readonly] {
            background-color: #e9ecef !important;
            opacity: 1 !important;
        }

        input[type=checkbox]{
            width: 20px;
            height: 20px;
        }
    </style>
@stop

@section('page-title')
    <h2> OMP0020 : ใบเตรียมการขาย ส่งเสริม ยสท. /บุหรี่ทดลอง/บุหรี่ตัวอย่าง</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> OMP0020 ใบเตรียมการขาย ส่งเสริม ยสท. /บุหรี่ทดลอง/บุหรี่ตัวอย่าง</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h3>ใบเตรียมการขาย ส่งเสริม ยสท. /บุหรี่ทดลอง/บุหรี่ตัวอย่าง</h3>
    </div>
    <div class="ibox-content">
        <form id="prepare_form" autocomplete="off" onsubmit="return false" enctype="multipart/form-data" >
            @csrf
        <div class="row space-50 justify-content-md-center mt-md-4">
            <div class="col-12">
                <div class="form-header-buttons">
                    <div class="d-flex">
                        <button class="btn btn-white" type="button" onclick="btnClearForm();"><i class="fa fa-repeat"></i></button>
                    </div>
                    <div class="buttons multiple">
                        {{-- <button type="button" onclick="testCallWms()" >testCallwms</button> --}}
                        <button class="btn btn-md btn-success" type="button" id="create_order" onclick="createPrepareSaleOrder();"><i class="fa fa-plus"></i> สร้าง</button>
                        {{-- <button class="btn btn-md btn-info" type="button" id="copy_order" onclick="copySaleOrder();" disabled><i class="fa fa-copy"></i> คัดลอก</button> --}}
                        <button class="btn btn-md btn-white"  type="button" id="search_order" onclick="searchSaleOrder();"><i class="fa fa-search"></i> ค้นหา</button>
                        {{-- <button class="btn btn-md btn-success" id="attfile_order" data-toggle="modal" disabled data-target="#attachmentModal" type="button"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                        <div class="dropdown">
                            <button class="btn btn-md btn-white m-0" id="command_order" data-toggle="dropdown" disabled type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="disabled" id="save_order" onclick="savePrepareOrder();">บันทึก</a></li>
                                <li><a href="#" class="disabled" id="confirm_order" onclick="saveConfirmOrder();">ยืนยัน</a></li>
                                <li><a href="#" class="disabled" id="cancel_order" onclick="CancelOrderCheck();">ยกเลิก</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-md btn-info" type="button" id="print_order" disabled onclick="PrintReport();"><i class="fa fa-print"></i> พิมพ์ใบเตรียมการขาย</button>
                        <button class="btn btn-md btn-primary" type="button" id="send_approve_order" disabled onclick="saveSendApproveOrder();"><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button> --}}
                    </div>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>
                <div class="alert alert-warning alert-dismissible print-error-msg-saleorder" id="close-btn-saleorder" style="display: none;">
                    <button type="button" class="close" onclick="$('#close-btn-saleorder').hide();">&times;</button>
                    <h5> Warning!</h5>
                    <ul></ul>
                </div>
            </div><!--col-12-->
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">เลขที่ใบเตรียมขาย</label>
                            <div class="input-icon">
                                <input type="text" list="orderlist" class="form-control" id="prepare_number" name="prepare_number" placeholder="" value="{{ $number }}">
                                <datalist id="orderlist">

                                </datalist>
                                <input type="hidden" id="prepare_number_data" name="prepare_number_data">
                                <input type="hidden" id="order_id" name="order_id">
                                <input type="hidden" id="product_type_id" name="product_type_code">
                            </div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">Order Status</label>
                            <div class="row space-5 align-items-center">
                                <div class="col-md-6">

                                    <div class="input-icon">
                                        <input type="text" class="form-control" disabled id="order_status" placeholder="" value="">
                                        <input type="hidden" name="order_status" id="order_status_hide">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2 mt-md-0">
                                    <label><input type="checkbox" value="Y" id="approve_order" disabled><span class="nowrap" style="padding-left: 10px;">ยอดส่งได้รับการอนุมัติ</span></label>
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <div class="col-12"></div>

                    <!--//-->

                    <div class="col-xl-4 col-md-4">
                        <div class="form-group">
                            <label class="d-block">รหัสลูกค้า <label class="text-danger">*</label> </label> 
                            <div class="row space-5 align-items-center">
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" list="dataCustomer" name="customer_id_show" id="customer_id_show" onchange="selectCustomer(this.value); getShipToSite(this.value);">
                                        <datalist id="dataCustomer">
                                            @foreach ($customer as $item_cus)
                                                <option value="{{ $item_cus->customer_number }}"
                                                    data-value="{{ $item_cus->customer_id }}"
                                                    data-name="{{ $item_cus->customer_name }}"
                                                    data-price="{{ $item_cus->price_list_id }}"
                                                    data-province="{{ !empty($item_cus->Province->province_thai)? $item_cus->Province->province_thai : '' }}"
                                                    data-order="{{ $item_cus->sales_channel_id }}"
                                                    data-delivary="{{ $item_cus->shipment_by_id }}"
                                                    >{{ $item_cus->customer_name }}</option>
                                            @endforeach
                                        </datalist>
                                        <input type="hidden" name="customer_id" id="customer_id" >
                                    </div>
                                </div>
                                <div class="col-md-8 mt-2 mt-md-0">
                                    <input type="text" class="form-control" disabled id="customer_name" placeholder="" value="">
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <div class="col-xl-4 col-md-4">
                        <div class="form-group">
                            <label class="d-block">ที่อยู่ <label class="text-danger">*</label></label>
                            <input type="text" class="form-control form_input_data" id="province_name"  name="province_name" disabled placeholder="" value="">
                        </div>
                    </div><!--col-->

                    <div class="col-xl-4 col-md-4">
                        <div class="form-group">
                            <label class="d-block">สถานที่จัดส่งสินค้า <label class="text-danger">*</label></label>
                            <div class="input-icon">
                                <select class="custom-select select2 form_input_data" disabled name="ship_to_site" id="ship_to_site">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-12"></div>

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">สั่งทาง <label class="text-danger">*</label></label>
                            <select class="custom-select select2 form_input_data" disabled name="order_by" id="order_by">
                                <option value=""></option>
                                @foreach ($salechannel as $item_channel)
                                    <option value="{{ $item_channel->lookup_code }}">{{ $item_channel->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">หมายเหตุสั่งทาง</label>
                           <input type="text" class="form-control form_input_data" disabled name="remark_order" id="remark_order" placeholder="" value="">
                        </div>
                    </div><!--col-->

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">ผู้ร้องขอ <label class="text-danger">*</label></label>
                            <div class="row space-5 align-items-center">
                                <div class="col-md-4">
                                    <input type="text" list="dataRequestor" class="form-control form_input_data" disabled name="request_by_show" id="request_by_show" onkeyup="selectRequest();" onchange="selectRequest();">
                                    <datalist id="dataRequestor">
                                        @foreach ($requestor as $item_requestor)
                                            <option value="{{ $item_requestor->meaning }}" data-value="{{ $item_requestor->lookup_code }}" data-name="{{ $item_requestor->description }}">{{ $item_requestor->description }}</option>
                                        @endforeach
                                    </datalist>
                                    <input type="hidden" name="request_by" id="request_by">
                                </div>
                                <div class="col-md-8 mt-2 mt-md-0">
                                    <input type="text" class="form-control" disabled  id="request_name" placeholder="" value="">
                                </div>
                            </div><!--row-->
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">ส่งโดย <label class="text-danger">*</label></label>
                            <select class="custom-select select2 form_input_data" disabled name="shipment_by" id="shipment_by">
                                <option value=""></option>
                                @foreach ($shipment as $item_shipment)
                                    <option value="{{ $item_shipment->lookup_code }}">{{ $item_shipment->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">วันที่สั่ง</label>
                            <div class="input-icon">
                                <input type="text" class="form-control" disabled  id="order_date_show" placeholder="" value="">
                                <input type="hidden" id="order_date" name="order_date" >
                                {{-- <datepicker-th
                                    disabled
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data"
                                    name="order_date"
                                    id="order_date"
                                    format="DD/MM/YYYY"
                                    placeholder="โปรดเลือกวันที่"> --}}
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">วันที่ส่ง <label class="text-danger">*</label></label>
                            {{-- <div class="input-icon"> --}}
                                {{-- <input type="text" class="form-control" disabled  id="delivary_date_show" placeholder="" value=""> --}}
                                {{-- <input type="hidden" id="delivary_date" name="delivary_date" > --}}
                                <datepicker-th
                                    :disabled="true"
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data delivary_date"
                                    name="delivary_date"
                                    id="delivary_date"
                                    format="DD/MM/YYYY"
                                    placeholder="">
                                </datepicker-th>
                                {{-- <i class="fa fa-calendar"></i> --}}
                            {{-- </div> --}}
                        </div>
                    </div><!--col-->

                    <!--//-->

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">ประเภทการขาย <label class="text-danger">*</label></label>
                            <div class="input-icon">
                                <select class="custom-select select2 form_input_data" disabled name="transaction_id_show" id="transaction_id_show" onchange="selOrderType(this.value);">
                                    <option value=""></option>
                                    @foreach ($transaction as $item_transaction)
                                        <option value="{{ $item_transaction->order_type_id }}" data-type="{{ $item_transaction->product_type_premium }}">{{ $item_transaction->order_type_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="transaction_id" name="transaction_id" >
                                <input type="hidden" id="transaction_type_premium" name="transaction_type_premium" >
                            </div>
                        </div>
                    </div><!--col-->

                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label class="d-block">ราคาขาย <label class="text-danger">*</label></label>
                            <select class="custom-select select2 form_input_data" disabled name="price_list" id="price_list" onchange="getProductList(this.value);">
                                <option value=""></option>
                                @foreach ($pricelist as $item_pricelist)
                                    <option value="{{ $item_pricelist->list_header_id }}">{{ $item_pricelist->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--col-->

                     <!--//-->

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="d-block">หมายเหตุรายการ <label class="text-danger">*</label></label>
                            <input type="text" class="form-control form_input_data" disabled  name="remark_list" id="remark_list" placeholder="" value="">
                        </div>
                    </div><!--col-->

                    <div class="col-md-4">
                        <div class="col-md-12 mt-2 mt-md-0">
                            <label class="d-block">&nbsp;</label>
                            <label><input type="checkbox" value="Y" class="form_input_data" onclick="checkNotDeli();" name="not_deli_price" id="not_deli_price"><span class="nowrap text-danger" style="padding-left: 10px;">ไม่คิดค่าขนส่ง (ของแถมประจำวัน)</span></label>
                            <p id="not_deli_price_msg" style="display:none;">ส่งข้อมูล WMS, ไม่ส่งข้อมูลจ่ายยาสูบ, ไม่คิดค่าขนส่ง</p>
                        </div>
                    </div><!--col-->

                </div><!--row-->
            </div><!--col-xl-6-->

            <div class="col-xl-12">
                <hr class="lg">

                <div class="form-header-buttons">
                    <div class="buttons multiple">
                        <button class="btn btn-md btn-success ciggaret_btn_add" id="btn_product_list" type="button" onclick="createdOrderLine();" disabled ><i class="fa fa-plus"></i> สร้าง</button>
                        <button class="btn btn-md btn-success tobacco_btn_add" style="display: none;" id="btn_product_list_tobac" type="button" onclick="createdOrderLineTobacco();" disabled ><i class="fa fa-plus"></i> สร้าง</button>
                        
                        {{-- <button class="btn btn-md btn-primary" id="btn_product_lot"  type="button" onclick="saveOrderLot();" disabled><i class="fa fa-save"></i> บันทึก</button> --}}
                    </div>
                </div><!--form-header-buttons-->

                <div class="hr-line-dashed"></div>

                <div class="table-responsive">
                    <table class="table table-bordered text-center table-hover min-1200 f13" id="sigaret">
                        <thead>
                            <tr class="align-middle">
                                <th rowspan="2" class="w-90">รายการที่</th>
                                <th rowspan="2" class="w-160">รหัสสินค้า</th>
                                <th rowspan="2" class="min-150">ชื่อผลิตภัณฑ์</th>
                                <th colspan="3">จำนวนที่สั่ง</th>
                                <th rowspan="2">ราคาขาย/<br>พันมวน</th>
                                <th rowspan="2">จำนวนเงิน</th>
                                <th rowspan="2">คงคลังทั้งหมด/หน่วยที่สั่ง</th>
                                <th rowspan="2" style="width: 55px">ลบ</th>
                            </tr>
                            <tr class="align-middle">
                                <!--จำนวนที่สั่ง-->
                                <th class="w-90"><small>หีบ</small></th>
                                <th class="w-90"><small>ห่อ</small></th>
                                <th class="w-90"><small>คิดเป็น<br>พันมวน</small></th>
                            </tr>
                        </thead>
                        <tbody>


                            <tr id="order_line">
                                <td class="text-right" colspan="3">
                                    <strong class="black">รวมเงิน</strong>
                                </td>
                                <td>
                                    <strong class="black total_box_amount">0</strong>
                                </td>
                                <td>
                                    <strong class="black total_pack_amount">0</strong>
                                </td>
                                <td>
                                    <strong class="black total_unit_amount">0</strong>
                                </td>
                                <td></td>
                                <td class="text-right">
                                    <strong class="black total_amount">0</strong>
                                    <input type="hidden" name="total_amount" id="total_amount">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered text-center table-hover min-1200 f13" style="display: none;" id="tobacco">
                        <thead>
                            <tr class="align-middle">
                                <th  class="w-90">รายการที่</th>
                                <th  class="w-160">รหัสสินค้า</th>
                                <th  class="min-150">ชื่อผลิตภัณฑ์</th>
                                <th>รหัสหน่วยนับ</th>
                                <th>หน่วยนับ</th>
                                <th>ราคา/หน่วย</th>
                                <th>จำนวนที่สั่ง</th>
                                <th>จำนวนเงิน</th>
                                <th>คงคลังทั้งหมด/หน่วยที่สั่ง</th>
                                <th  style="width: 55px">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>


                            <tr id="order_line_tobacco">
                                <td class="text-right" colspan="7">
                                    <strong class="black">รวมเงิน</strong>
                                </td>
                                <td class="text-right">
                                    <strong class="black total_amount_tobac">0</strong>
                                    <input type="hidden" name="total_amount_tobac" id="total_amount_tobac">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--table-responsive-->

            </div><!--col-xl-12-->
            </form>
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
                                <button class="btn btn-primary btn-lg" onclick="saveCancelOrder();" type="button">
                                    <i class="fa fa-check"></i>
                                    ยืนยัน
                                </button>
                            </div>
                        </form>
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal-->
            <div class="col-xl-12 mt-5">
                <div class="paper-row title mb-3 has-bg" data-toggle="collapse" data-target="#collapse_01" aria-expanded="true">
                    <span class="icon-collapse blue"><span class="icon"></span></span> <strong>บันทึกรายละเอียดสินค้า</strong>
                </div>

                <div id="collapse_01" class="collapse in show">
                    <div class="table-responsive-lg">
                    <div class="form-header-buttons">
                        <div class="buttons multiple">
                            <button class="btn btn-md btn-success btn_log_data" id="create_lot" type="button" onclick="getLotData()" ><i class="fa fa-plus"></i> สร้าง</button>
                            <button class="btn btn-md btn-primary btn_log_data" id="save_log" type="button" onclick="saveLotData()" disabled ><i class="fa fa-check"></i> บันทึก</button>
                            
                            {{-- <button class="btn btn-md btn-primary" id="btn_product_lot"  type="button" onclick="saveOrderLot();" disabled><i class="fa fa-save"></i> บันทึก</button> --}}
                        </div>
                    </div><!--form-header-buttons-->
        
                    <div class="hr-line-dashed"></div>
                    <table class="table table-bordered text-center  f13">
                        <thead>
                            <tr class="align-middle">
                                <th class="w-160">รหัสสินค้า(INV)</th>
                                <th class="w-160">ชื่อผลิตภัณฑ์(INV)</th>
                                <th class="w-160">Org</th>
                                <th class="w-160">Org Name</th>
                                <th class="w-160">Subinventtory</th>
                                <th class="w-160">Locator</th>
                                <th class="w-160">Lot</th>
                                <th class="w-160">Onhand</th>
                                <th class="w-160">Onhand (หน่วยสั่งซื้อ)</th>
                                <th class="w-160">จำนวนที่สัง</th>
                                <th class="w-160">ลบ</th>
                            </tr>
                        </thead>
                        <tbody id="lot_data_input">

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>


        {{-- ปุ่มต่างๆ --}}
        <div class="hr-line-dashed"></div>
        <div class="row">
            <div class="col-md-12">
                <div class=" text-center">
                    <div class="buttons multiple">

                        <button class="btn btn-md btn-success" id="attfile_order" data-toggle="modal" disabled data-target="#attachmentModal" type="button"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                        <div class="dropdown" style="display: inline;">
                            <button class="btn btn-md btn-white m-0" id="command_order" data-toggle="dropdown" disabled type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="disabled" id="save_order" onclick="savePrepareOrder();">บันทึก</a></li>
                                <li><a href="#" class="disabled" id="confirm_order" onclick="saveConfirmOrder();">ยืนยัน</a></li>
                                <li><a href="#" class="disabled" id="cancel_order" onclick="CancelOrderCheck();">ยกเลิก</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-md btn-info" type="button" id="print_order" disabled onclick="PrintReport();"><i class="fa fa-print"></i> พิมพ์ใบเตรียมการขาย</button>
                        <button class="btn btn-md btn-primary" type="button" id="send_approve_order" disabled onclick="saveSendApproveOrder();"><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button>
                    </div>
                </div>
            </div>
        </div>

    </div><!--ibox-content-->
</div><!--ibox-->
@endsection

@section('scripts')

@include('om/_scripts/attachment')

<script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
<script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('custom/custom.js') !!}"></script>

<script>
    var ship_to_site    = '';
    var product_item    = [];
    var uom_list        = [];
    var order_line      = 1;
    var number_list     = 1;
    var data_line       = [];
    var line_remove     = [];
    var list_lot        = [];
    var sel_lot         = [];
    var arr_lot_list    = [];
    var arr_lot_update  = [];
    var lot_line        = 0;
    var lot_sum         = 0;
    var product_type    = 10
    var status          = '';
    var number          = "{{ !empty($number)? $number : '' }}";
    var ck_line         = null;
    var total_onhand    = 0;
    var lotListData     = [];

    $(document).ready(function(){
        $(".select2").select2();
        getOrderList();
        getUomList();

        if(number != ''){
            searchSaleOrder();
        }
    });

    // function testCallWms()
    // {
    //     var  order_header_id = $("#order_id").val();
    //     var  prepare_order_number = $("#prepare_number_data").val();

    //     loading();
    //     $.ajax({
    //         url    : '{{ url("om/ajax/prepare-saleorder/test-call-wms") }}',
    //         type   : 'post',
    //         data   : {
    //             '_token'    : '{{ csrf_token() }}',
    //             order_header_id : order_header_id,
    //             prepare_order_number : prepare_order_number
    //         },
    //         success:function(rest){
    //             swal.close();
    //             var data = rest.data;
    //             console.log(data);
    //         }
    //     });
    // }

    function getOrderList(customer_id = null)
    {
        loading();
        $.ajax({
            url    : '{{ url("om/ajax/prepare-saleorder/get_orderlist") }}',
            type   : 'post',
            data   : {
                '_token'    : '{{ csrf_token() }}',
                customer_id : customer_id
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                var html = '<option value="" ></option>';
                $.each(data.data,function(key,val){
                    html += '<option value="'+val.prepare_order_number+'" >'+val.prepare_order_number+' : '+val.order_date+' : '+val.customer_name+'</option>';
                });
                $("#orderlist").html(html);
                // console.log(rest);
            }
        });
    }

    function getUomList()
    {
        loading();
        $.ajax({
            url    : '{{ url("om/ajax/prepare-saleorder/get_uomlist") }}',
            type   : 'post',
            data   : {
                '_token'    : '{{ csrf_token() }}',
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                uom_list = data.data;
            }
        });
    }

    function selOrderType(id)
    {
        var price_list = $("#price_list").val();
        $("#transaction_id").val(id);

        var type = $("#transaction_id_show option").filter(function(){
            return this.value == id;
        }).data('type');
        $("#transaction_type_premium").val(type);

        if(price_list != ''){
            getProductList(price_list);
        }
    }

    function createPrepareSaleOrder()
    {
        loading();
        $.ajax({
            url    : '{{ url("om/ajax/prepare-saleorder/genpo_number") }}',
            type   : 'post',
            data   : {
                '_token'    : '{{ csrf_token() }}',
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    // $("#prepare_number").val(data.data);
                    // $("#prepare_number_data").val(data.data);
                    $("#order_status").val('Draft');
                    $("#order_status_hide").val('Draft');
                    $("#prepare_number").prop('disabled',true);
                    $("#command_order").prop('disabled',false);
                    $("#search_order").prop('disabled',true);
                    $("#attfile_order").prop('disabled',false);
                    $("#save_order").removeClass('disabled');
                    $(".form_input_data").prop('disabled',false);
                    $("#confirm_order").removeClass('disabled');
                    $("#remark_list").prop('disabled',false);
                    $("#order_date").val(data.date);
                    $("#order_date_show").val(data.date);
                    // $("#delivary_date").val(data.date);
                }else{
                    AlertToast('แจ้งเตือน','บางอย่างผิดผลาดกรุณารองใหม่อีกครั้ง','error');
                }
            }
        });
    }

    async function savePrepareOrder()
    {
        loading();
        const formdata = new FormData(document.getElementById("prepare_form"));
        formdata.append('remove_line',line_remove);
        console.log(arr_lot_list)
        if(arr_lot_list.length > 0){
            $.each(arr_lot_list,function(key,val){
                if(key != 0){
                    $.each(arr_lot_list[key],function(key_lot,val_lot){
                        if(key_lot != 0){
                            if(val_lot.lot_id == 'undefined' || val_lot.lot_id == ''){
                                formdata.append('lot['+key+']['+key_lot+'][lot_id]','');
                            }else{
                                formdata.append('lot['+key+']['+key_lot+'][lot_id]',val_lot.lot_id);
                            }
                            formdata.append('lot['+key+']['+key_lot+'][conv_qty]',val_lot.conv_qty);
                            formdata.append('lot['+key+']['+key_lot+'][lot_number]',val_lot.lot_number);
                            formdata.append('lot['+key+']['+key_lot+'][lot_uom]',val_lot.lot_uom);
                            formdata.append('lot['+key+']['+key_lot+'][on_hand]',val_lot.on_hand);
                            formdata.append('lot['+key+']['+key_lot+'][onhand_qunty]',val_lot.onhand_qunty);
                            formdata.append('lot['+key+']['+key_lot+'][org]',val_lot.org);
                            formdata.append('lot['+key+']['+key_lot+'][org_code]',val_lot.org_code);
                            formdata.append('lot['+key+']['+key_lot+'][org_name]',val_lot.org_name);
                            formdata.append('lot['+key+']['+key_lot+'][subinventory_code]',val_lot.subinventory_code);
                            formdata.append('lot['+key+']['+key_lot+'][inventory_location_id]',val_lot.inventory_location_id);
                            formdata.append('lot['+key+']['+key_lot+'][location]',val_lot.location);
                        }
                    });
                }
            });
        }

        // console.log(...formdata);
        // return false;

        await $.each(fileChoose,async function(index, file) {
        if(typeof file !== "undefined")
            await formdata.append('attachment[]', file);
        });

        $.ajax({
            url         : '{{ url("om/ajax/prepare-saleorder/save_darft") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    AlertToast('สำเร็จ','บันทึกข้อมูลแล้ว','success');
                    $('#close-btn-saleorder').hide();
                    // location.reload();
                    $("#prepare_number").val(data.order_number);
                    $("#prepare_number_data").val(data.order_number);
                    $("#order_id").val(data.head_id);
                    if(data.line_id){
                        $.each(data.line_id,function(key_line,val_line){
                            $("#line_id_"+key_line).val(val_line);
                            try {
                                if(data.lot_id[key_line]){
                                    $.each(data.lot_id[key_line],function(key_lot,val_lot){
                                        $("#lot_id_"+key_lot).val(val_lot);
                                    });
                                }
                            } catch (error) {
                                
                            }
                            
                        });
                    }

                    if(data.status_order == 'Confirm'){
                        $("#customer_id_show").prop('disabled',true);
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',true);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',true);
                        $("#print_order").prop('disabled',false);
                        $("#send_approve_order").prop('disabled',false);
                        $("#cancel_order").removeClass('disabled');
                        $("#btn_product_lot").prop('disabled',false);
                        $("#btn_product_list").prop('disabled',true);
                        $(".form_input_data").prop('disabled',true);
                        deActiveDatePicker($("#delivary_date").val());
                    }else if(data.status_order == 'Cancelled'){
                        $("#customer_id_show").prop('disabled',true);
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',true);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',true);
                        $("#print_order").prop('disabled',true);
                        $("#send_approve_order").prop('disabled',true);
                        $("#cancel_order").removeClass('disabled');
                        $("#btn_product_lot").prop('disabled',false);
                        $("#btn_product_list").prop('disabled',true);
                        $(".form_input_data").prop('disabled',true);
                        deActiveDatePicker($("#delivary_date").val());
                    }else{
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',false);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',false);
                        $("#print_order").prop('disabled',false);
                        $("#send_approve_order").prop('disabled',false);
                        $("#save_order").removeClass('disabled');
                        $("#confirm_order").removeClass('disabled');
                        $("#cancel_order").removeClass('disabled');
                        $(".form_input_data").prop('disabled',false);
                        reActiveDatePicker($("#delivary_date").val());
                    }

                }else{
                    if(data.type == 'validate'){
                        printErrorMsgSaleOrder(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','บางอย่างผิดผลาดกรุณาลองใหม่อีกครั้ง','error');
                    }
                }
            }
        });
    }

    async function saveConfirmOrder()
    {
        loading();
        $("#order_status").val('Confirm');
        $("#order_status_hide").val('Confirm');

        const formdata = new FormData(document.getElementById("prepare_form"));
        formdata.append('remove_line',line_remove);
        if(arr_lot_list.length > 0){
            $.each(arr_lot_list,function(key,val){
                if(key != 0){
                    $.each(arr_lot_list[key],function(key_lot,val_lot){
                        if(key_lot != 0){
                            formdata.append('lot['+key+']['+key_lot+'][lot_id]',val_lot.lot_id);
                            formdata.append('lot['+key+']['+key_lot+'][conv_qty]',val_lot.conv_qty);
                            formdata.append('lot['+key+']['+key_lot+'][lot_number]',val_lot.lot_number);
                            formdata.append('lot['+key+']['+key_lot+'][lot_uom]',val_lot.lot_uom);
                            formdata.append('lot['+key+']['+key_lot+'][on_hand]',val_lot.on_hand);
                            formdata.append('lot['+key+']['+key_lot+'][onhand_qunty]',val_lot.onhand_qunty);
                            formdata.append('lot['+key+']['+key_lot+'][org]',val_lot.org);
                            formdata.append('lot['+key+']['+key_lot+'][org_code]',val_lot.org_code);
                            formdata.append('lot['+key+']['+key_lot+'][org_name]',val_lot.org_name);
                            formdata.append('lot['+key+']['+key_lot+'][subinventory_code]',val_lot.subinventory_code);
                            formdata.append('lot['+key+']['+key_lot+'][inventory_location_id]',val_lot.inventory_location_id);
                            formdata.append('lot['+key+']['+key_lot+'][location]',val_lot.location);
                        }
                    });
                }
            });
        }

        await $.each(fileChoose,async function(index, file) {
        if(typeof file !== "undefined")
            await formdata.append('attachment[]', file);
        });

        $.ajax({
            url         : '{{ url("om/ajax/prepare-saleorder/save_darft") }}',
            type        : 'post',
            data        : formdata,
            dataType    : 'json',
            cache       : false,
            processData : false,
            contentType : false,
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    AlertToast('สำเร็จ','บันทึกข้อมูลสำเร็จแล้ว','success');
                    $('#close-btn-saleorder').hide();
                    $("#prepare_number").val(data.order_number);
                    $("#prepare_number_data").val(data.order_number);
                    $("#order_id").val(data.head_id);
                    $("#save_order").hide();
                    $("#confirm_order").hide();
                    $("#cancel_order").show();
                    try {
                        if(data.line_id){
                            $.each(data.line_id,function(key_line,val_line){
                                $("#line_id_"+key_line).val(val_line);
                                try {
                                    if(data.lot_id[key_line]){
                                        $.each(data.lot_id[key_line],function(key_lot,val_lot){
                                            $("#lot_id_"+key_lot).val(val_lot);
                                        });
                                    }
                                } catch (error) {
                                    
                                }
                                
                            });
                        }
                    } catch (error) {
                        
                    }
                   

                    //-- สถานะ
                    $("#order_status").val(data.status_order);
                    $("#order_status_hide").val(data.status_order);

                    if(data.status_order == 'Confirm'){
                        $("#customer_id_show").prop('disabled',true);
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',true);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',true);
                        $("#print_order").removeAttr('disabled');
                        $("#send_approve_order").prop('disabled',false);
                        $("#cancel_order").removeClass('disabled');
                        $("#btn_product_lot").prop('disabled',false);
                        $("#btn_product_list").prop('disabled',true);
                        $(".form_input_data").prop('disabled',true);
                        deActiveDatePicker($("#delivary_date").val());
                    }else if(data.status_order == 'Cancelled'){
                        $("#customer_id_show").prop('disabled',true);
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',true);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',true);
                        $("#print_order").prop('disabled',true);
                        $("#send_approve_order").prop('disabled',true);
                        $("#cancel_order").removeClass('disabled');
                        $("#btn_product_lot").prop('disabled',false);
                        $("#btn_product_list").prop('disabled',true);
                        $(".form_input_data").prop('disabled',true);
                        deActiveDatePicker($("#delivary_date").val());
                    }else{
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',false);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',false);
                        $("#print_order").removeAttr('disabled');
                        $("#send_approve_order").prop('disabled',false);
                        $("#save_order").removeClass('disabled');
                        $("#confirm_order").removeClass('disabled');
                        $("#cancel_order").removeClass('disabled');
                        $(".form_input_data").prop('disabled',false);
                        reActiveDatePicker($("#delivary_date").val());
                    }
                }else{
                    $("#order_status").val('Draft');
                    $("#order_status_hide").val('Draft');
                    if(data.type == 'validate'){
                        printErrorMsgSaleOrder(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','บางอย่างผิดผลาดกรุณาลองใหม่อีกครั้ง','error');
                    }
                }
            }
        });
    }

    function saveSendApproveOrder()
    {
        loading();
        var order_id = $("#order_id").val();
        $.ajax({
            url         : '{{ url("om/ajax/prepare-saleorder/save_approve") }}',
            type        : 'post',
            data        : {
                '_token'    : '{{ csrf_token() }}',
                order_id : order_id
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    AlertToast('สำเร็จ','บันทึกข้อมูลสำเร็จแล้ว','success');
                    $('#close-btn-saleorder').hide();

                    //-- สถานะ
                    $("#order_status").val(data.status_order);
                    $("#order_status_hide").val(data.status_order);

                    $("#create_order").prop('disabled',true);
                    $("#command_order").prop('disabled',false);
                    $("#copy_order").prop('disabled',true);
                    $("#search_order").prop('disabled',false);
                    // $("#attfile_order").prop('disabled',true);
                    $("#print_order").prop('disabled',false);
                    $("#send_approve_order").prop('disabled',true);
                    $("#cancel_order").removeClass('disabled');
                    $("#btn_product_lot").prop('disabled',false);
                    $("#btn_product_list").prop('disabled',true);
                    $(".form_input_data").prop('disabled',true);
                    deActiveDatePicker($("#delivary_date").val());
                    // location.reload();
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgSaleOrder(data.data);
                    }else{
                        AlertToast('แจ้งเตือน','บางอย่างผิดผลาดกรุณาลองใหม่อีกครั้ง','error');
                    }
                }
            }
        });
    }

    function CancelOrderCheck()
    {
        $("#cancelModal").modal();
        // Swal.fire({
        //     title:  'Cancel Order',
        //     html:   '<input type="text" id="ordercancelinput" class="swal2-input" value="" placeholder="เหตุผลการยกเลิก">',// add html attribute if you want or remove
        //     focusConfirm: false,
        //     showCancelButton: true,
        //     preConfirm: () => {
        //         saveCancelOrder($("#ordercancelinput").val());
        //     }
        // });
    }


    function saveCancelOrder()
    {
        loading();
        var order_id = $("#order_id").val();
        var remarkcancel = $("#po_cancel_reason").val();
        var remark_list  = $("#remark_list").val();
        $("#order_status").val('Cancelled');
        $("#order_status_hide").val('Cancelled');
        $("#cancelModal").modal('hide');
        $.ajax({
            url         : '{{ url("om/ajax/prepare-saleorder/save_cancel") }}',
            type        : 'post',
            data        : {
                '_token'        : '{{ csrf_token() }}',
                order_id        : order_id,
                remarkcancel    : remarkcancel,
                remark_list     : remark_list
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                if(data.status){
                    AlertToast('สำเร็จ','บันทึกข้อมูลสำเร็จแล้ว','success');
                    $('#close-btn-saleorder').hide();
                    // location.reload();
                    $("#prepare_number").val(data.order_number);
                    $("#prepare_number_data").val(data.order_number);
                    $("#order_id").val(data.head_id);
                    if(data.line_id){
                        $.each(data.line_id,function(key_line,val_line){
                            $("#line_id_"+key_line).val(val_line);
                        });
                    }

                    //-- สถานะ
                    $("#order_status").val(data.status_order);
                    $("#order_status_hide").val(data.status_order);

                    if(data.status_order == 'Confirm'){
                        $("#customer_id_show").prop('disabled',true);
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',true);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',true);
                        $("#print_order").prop('disabled',false);
                        $("#send_approve_order").prop('disabled',true);
                        $("#cancel_order").removeClass('disabled');
                        $("#btn_product_lot").prop('disabled',false);
                        $("#btn_product_list").prop('disabled',true);
                        $(".form_input_data").prop('disabled',true);
                        deActiveDatePicker($("#delivary_date").val());
                    }else if(data.status_order == 'Cancelled'){
                        $("#customer_id_show").prop('disabled',true);
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',true);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',true);
                        $("#print_order").prop('disabled',true);
                        $("#send_approve_order").prop('disabled',true);
                        $("#cancel_order").removeClass('disabled');
                        $("#btn_product_lot").prop('disabled',false);
                        $("#btn_product_list").prop('disabled',true);
                        $(".form_input_data").prop('disabled',true);
                        deActiveDatePicker($("#delivary_date").val());
                    }else{
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',false);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',false);
                        $("#print_order").prop('disabled',false);
                        $("#send_approve_order").prop('disabled',false);
                        $("#save_order").removeClass('disabled');
                        $("#confirm_order").removeClass('disabled');
                        $("#cancel_order").removeClass('disabled');
                        $(".form_input_data").prop('disabled',false);
                        reActiveDatePicker($("#delivary_date").val());
                    }
                }else{
                    if(data.type == 'validate'){
                        printErrorMsgSaleOrder(data.data);
                    }else{
                        AlertToast('แจ้งเตือน',data.data,'error');
                    }
                }
            }
        });
    }

    function searchSaleOrder()
    {
        var prepare_number  = $("#prepare_number").val();

        if(prepare_number == ''){
            AlertToast('แจ้งเตือน','กรุณากรอกข้อมูลเพื่อค้นหา','error');
            return false;
        }

        $("#attfile_order").prop('disabled',false);

        loading();
        $.ajax({
            url    : '{{ url("om/ajax/prepare-saleorder/search_saleorder") }}',
            type   : 'post',
            data   : {
                '_token'    : '{{ csrf_token() }}',
                prepare_number  : prepare_number,
            },
            success:function(rest){
                var data = rest.data;
                if(data.status){
                    var val     = data.data.header;
                    data_line   = data.data.order_line;
                    status      = val.order_status;
                    if(val.order_status == 'Confirm'){
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',true);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',true);
                        $("#print_order").prop('disabled',false);
                        if(val.approve_flag != 'Y' && val.his == 'N'){
                            $("#send_approve_order").prop('disabled',false);
                        }else{
                            $("#send_approve_order").prop('disabled',true);
                        }
                        $("#customer_id_show").prop('disabled',true);
                        $("#cancel_order").removeClass('disabled');
                        $("#btn_product_lot").prop('disabled',false);
                        $("#btn_product_list").prop('disabled',true);
                        $(".form_input_data").prop('disabled',true);
                        
                        $("#save_order").hide();
                        $("#confirm_order").hide();
                        $("#cancel_order").show();

                    }else if(val.order_status == 'Cancelled'){
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',true);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',true);
                        $("#print_order").prop('disabled',true);
                        $("#send_approve_order").prop('disabled',true);
                        $("#customer_id_show").prop('disabled',true);
                        $("#cancel_order").removeClass('disabled');
                        $("#btn_product_lot").prop('disabled',false);
                        $("#btn_product_list").prop('disabled',true);
                        $(".form_input_data").prop('disabled',true);
                        deActiveDatePicker($("#delivary_date").val());
                        $("#save_order").hide();
                        $("#confirm_order").hide();
                        $("#cancel_order").show();
                    }else{
                        $("#create_order").prop('disabled',true);
                        $("#command_order").prop('disabled',false);
                        $("#copy_order").prop('disabled',false);
                        $("#search_order").prop('disabled',false);
                        // $("#attfile_order").prop('disabled',false);
                        $("#print_order").prop('disabled',false);
                        $("#send_approve_order").prop('disabled',false);
                        $("#save_order").removeClass('disabled');
                        $("#confirm_order").removeClass('disabled');
                        $("#cancel_order").removeClass('disabled');
                        $(".form_input_data").prop('disabled',false);
                        $("#save_order").show();
                        $("#confirm_order").show();
                        $("#cancel_order").show();
                    }

                    // swal.close();
                    $("#order_id").val(val.id);
                    //-- ประเภทบุหรี่
                    $("#product_type_id").val(val.product_type_code);
                    //-- หมายเลขใบเตรียมขาย
                    $("#prepare_number").val(val.prepare_number);
                    $("#prepare_number_data").val(val.prepare_number);
                    //-- สถานะ
                    $("#order_status").val(val.order_status);
                    $("#order_status_hide").val(val.order_status);
                    //-- ราคาขาย
                    $("#price_list").val(val.sale_price);
                    $("#price_list").trigger('change');
                    //-- ลูกค้า
                    $("#customer_id").val(val.customer_id);
                    // $("#customer_id").trigger('change');
                    $("#customer_id_show").val(val.customer_num);
                    $("#customer_id_show").trigger('change');

                    $("#remark_list").val(val.remark);
                    ship_to_site = val.ship_to_site;
                    // $("#ship_to_site").val(val.ship_to_site);
                    // $("#ship_to_site").trigger('change');
                    //-- สั้งทาง
                    $("#order_by").val(val.order_by);
                    $("#order_by").trigger('change');
                    //-- หมายเหตุสั่งซื้อ
                    $("#remark_order").val(val.order_remark);
                    //-- ผู้ร้องขอ
                    $("#request_by_show").val(val.request_meaning);
                    $("#request_by").val(val.request_id);
                    $("#request_by_show").trigger('change');
                    //-- ส่งโดย
                    $("#shipment_by").val(val.delivary_by);
                    $("#shipment_by").trigger('change');
                    //-- วันที่สั่ง
                    $("#order_date").val(val.order_date);
                    $("#order_date_show").val(val.order_date);
                    //-- วันที่ส่ง
                    $("#delivary_date").val(val.delivary_date);
                    if(val.order_status == 'Confirm'){
                        deActiveDatePicker(val.delivary_date);
                    }else{
                        reActiveDatePicker(val.delivary_date);
                    }

                    // $("#delivary_date_show").val(val.delivary_date);
                    //-- ประเภทการสั่งซื้อ
                    $("#transaction_id_show").val(val.order_type);
                    $("#transaction_id_show").trigger('change');
                    $("#transaction_id").val(val.order_type);
                    //-- ราคารวม
                    if(val.product_type_code == 20){
                        $("#total_amount_tobac").val(val.sub_total);
                        $(".total_amount_tobac").html(numberFormat(val.sub_total));
                    }else{
                        $("#total_amount").val(val.sub_total);
                        $(".total_amount").html(numberFormat(val.sub_total));
                    }
                    //--
                    if(val.approve_flag == 'Y'){
                        $("#approve_order").prop('checked',true);
                        // $("#send_approve_order").prop('disabled',true);
                    }else{
                        $("#approve_order").prop('checked',false);
                        // $("#send_approve_order").prop('disabled',false);
                    }
                    if(val.not_deli_price == 'Y'){
                        $("#not_deli_price").prop('checked',true);
                    }else{
                        $("#not_deli_price").prop('checked',false);
                    }
                    console.log(data.attachmentFile)
                    setAttachment(data.attachmentFile)
                }else{
                    swal.close();
                    AlertToast('แจ้งเตือน','ไม่พบข้อมูล','error');
                }
            }
        });
    }

    function checkNotDeli()
    {
        if($("#not_deli_price").prop('checked')){
            $("#not_deli_price_msg").show();
        }else{
            $("#not_deli_price_msg").hide();
        }
    }

    function PrintReport()
    {
        // var order = $("#order_id").val();
        // window.open('{{ url("om/prepare-saleorder/print/report?order=") }}' + order,'_blank').focus();

        var prepare_order_number = $("#prepare_number").val();
        window.open('{{ url("/om/order/prepare/report_preparation?prepare_order_number=") }}' + prepare_order_number,'_blank').focus();

    }

    function selectCustomer(value)
    {
        var number      = $("#customer_id_show").val();
        var value       = $("#dataCustomer option[value='"+number+"']").data('value');

        var name        = $("#dataCustomer option[value='"+number+"']").data('name');
        var province    = $("#dataCustomer option[value='"+number+"']").data('province');
        var price       = $("#dataCustomer option[value='"+number+"']").data('price');
        var order       = $("#dataCustomer option[value='"+number+"']").data('order');
        var delivary    = $("#dataCustomer option[value='"+number+"']").data('delivary');
        // var price_list  = $("#price_list").val();

        $("#customer_name").val(name);
        $("#province_name").val(province);
        $("#customer_id").val(value);
        // $("#price_list").val(price);
        // $("#price_list").trigger('change');
        $("#order_by").val(order).trigger('change');
        $("#shipment_by").val(delivary).trigger('change');
        var order_id  = $("#order_id").val()

        if(!order_id){
            getDelivary(value);
        }

        getOrderList(value);
    }

    function getProductList(id)
    {
        var order_type      = $("#transaction_id").val();
        var customer_id     = $("#customer_id").val();
        var header_id       = $("#order_id").val();
        var price_list      = $("#price_list").val();
        var type            = $("#transaction_type_premium").val();
        // var ptype           =  $("#product_type_id").val();
        resetOrderLine();
        if(type == 'ยาเส้นไม่ปรุง'){
            product_type = 20
        }else{
            product_type = 10
        }

        loading();
        $.ajax({
            url    : '{{ url("om/ajax/prepare-saleorder/get_uomlist_product") }}',
            type   : 'post',
            data   : {
                '_token'    : '{{ csrf_token() }}',
                customer_id : customer_id,
                product_type : product_type,
                header_id  :header_id,
                price_list : price_list
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                order_line      = 1;
                number_list     = 1;
                data_line       = [];

                product_item = data.data;

                if(data.line != false){
                    data_line = data.line;
                }
                if(data_line != false){
                    if(product_type == 20){
                        $("#sigaret").hide();
                        $("#tobacco").show();
                        $(".ciggaret_btn_add").hide();
                        $(".tobacco_btn_add").show();
                        resetOrderLine();
                        showSearchDataLineTobacco();
                    }else{
                        $("#sigaret").show();
                        $("#tobacco").hide();
                        $(".ciggaret_btn_add").show();
                        $(".tobacco_btn_add").hide();
                        resetOrderLine();
                        showSearchDataLine();
                    }
                }else{
                    if(product_type == 20){
                        $("#sigaret").hide();
                        $("#tobacco").show();
                        $(".ciggaret_btn_add").hide();
                        $(".tobacco_btn_add").show();
                        createdOrderLineTobacco();
                        $("#product_type_id").val(20);
                    }else{
                        $("#sigaret").show();
                        $("#tobacco").hide();
                        $(".ciggaret_btn_add").show();
                        $(".tobacco_btn_add").hide();
                        createdOrderLine();
                        $("#product_type_id").val(10);
                    }
                }

                if(status == 'Inprocess' || status == 'Confirm'){
                    $("#btn_product_list").prop('disabled',true);
                    $("#btn_product_list_tobac").prop('disabled',true);
                }else{
                    $("#btn_product_list").prop('disabled',false);
                    $("#btn_product_list_tobac").prop('disabled',false);
                }
            }
        });
    }

    function getShipToSite(id)
    {
        var customerid       = $("#dataCustomer option[value='"+id+"']").data('value');

        loading();
        $.ajax({
            url    : '{{ url("om/ajax/prepare-saleorder/get_shipsite") }}',
            type   : 'post',
            data   : {
                '_token'    : '{{ csrf_token() }}',
                id : customerid
            },
            success:function(rest){
                swal.close();
                var data = rest.data;
                var html = '<option value=""></option>';
                if(data.status){
                    $.each(data.data,function(key,val){
                        if(ship_to_site == val.ship_to_site_id ){
                            html += '<option value="'+ val.ship_to_site_id +'" selected >'+val.ship_to_site_name+'</option>';
                        }else{
                            if(key == 0){
                                html += '<option value="'+ val.ship_to_site_id +'" selected >'+val.ship_to_site_name+'</option>';
                            }else{
                                html += '<option value="'+ val.ship_to_site_id +'">'+val.ship_to_site_name+'</option>';
                            }
                        }
                    });
                }
                $("#ship_to_site").html(html);
            }
        });
    }

    function getDelivary(id)
    {
        var transaction_id  = $("#transaction_id").val();
        var price_list      = $("#price_list").val();
        var date            = $("#delivary_date").val();
        $.ajax({
            url    : '{{ url("om/ajax/prepare-saleorder/get_delivary") }}',
            type   : 'post',
            data   : {
                '_token'    : '{{ csrf_token() }}',
                id : id
            },
            success:function(rest){
                var data = rest.data;
                // $("#delivary_date").val(data.data.date);
                if(date != data.data.date){
                    reActiveDatePicker(data.data.date);
                }
                // $("#delivary_date_show").val(data.data.date);
                if(transaction_id != data.data.order_type){
                    if(data.data.order_type != null){
                        $("#transaction_id_show").val(data.data.order_type).trigger('change');
                        $("#transaction_id").val(data.data.order_type);
                    }
                }
                if(price_list != data.data.price_list){
                    $("#price_list").val(data.data.price_list).trigger('change');
                }
            }
        });
    }

    function copySaleOrder()
    {
        var header_id = $("#order_id").val();
        loading();
        $.ajax({
            url    : '{{ url("om/ajax/prepare-saleorder/copy_order") }}',
            type   : 'post',
            data   : {
                '_token'    : '{{ csrf_token() }}',
                header_id   : header_id
            },
            success:function(rest){
                var data = rest.data;
                if(data.status){
                    $("#prepare_number_data").val(data.data);
                    $("#prepare_number").val(data.data);
                    searchSaleOrder();
                }else{
                    swal.close();
                    AlertToast('แจ้งเตือน',data.message,'error');
                }
            }
        });
    }

    function selectRequest()
    {
        var mean    = $("#request_by_show").val();
        var name    = $("#dataRequestor option[value='"+mean+"']").data('name');
        var value   = $("#dataRequestor option[value='"+mean+"']").data('value');
        $("#request_by").val(value);
        $("#request_name").val(name);
    }

    function resetOrderLine()
    {
        $(".line_remove").remove();
        order_line = 1;
    }

    function createdOrderLine()
    {
        var html = '';
        // product_item
        html +=    '<tr class="align-middle line_remove remove_'+order_line+'">';
        html +=    '    <td><span id="number_'+order_line+'">'+number_list+'</span><input type="hidden" name="number_list['+order_line+']" data-list="'+order_line+'" id="number_list_'+order_line+'" value="'+number_list+'" ></td>';
        html +=    '    <td>';
        html +=    '        <div class="input-icon">';
        html +=    '            <input class="form-control form_input_data" data-index="'+order_line+'" list="item_product" name="product_code['+order_line+']" id="product_code_'+order_line+'" onchange="selectProductLine('+order_line+');">';
        html +=    '            <datalist id="item_product">';
        html +=    '                <option value=""></option>';
        if(product_item != ''){
            $.each(product_item,function(key,val){
                html += '                   <option value="'+val.item_code+'" data-value="'+key+'">'+ val.item_description +'</option>';
            });
        }
        html +=    '            </datalist>';
        // html +=    '            <select class="custom-select select2" name="product_code['+order_line+']" id="product_code_'+order_line+'" onchange="selectProductLine('+order_line+');">';
        // html +=    '                <option value=""></option>';
        // if(product_item != ''){
        //     $.each(product_item,function(key,val){
        //         html += '                   <option value="'+val.item_code+'">'+val.item_code +' '+ val.item_description +'</option>';
        //     });
        // }
        // html +=    '            </select>';
        html +=    '            <input type="hidden" id="line_id_'+order_line+'"            name="line_id['+order_line+']" >';
        html +=    '            <input type="hidden" id="item_id_'+order_line+'"            name="item_id['+order_line+']" >';
        html +=    '            <input type="hidden" id="item_code_'+order_line+'"          name="item_code['+order_line+']" >';
        html +=    '            <input type="hidden" id="item_description_'+order_line+'"   name="item_description['+order_line+']" >';
        html +=    '        </div>';
        html +=    '    </td>';
        html +=    '    <td class="text-left product_name_'+order_line+'" onclick="selProductLot('+order_line+')"></td>';
        // html +=    '    <td class="text-left product_name_'+order_line+'"></td>';
        html +=    '    <td><input type="text" class="form-control md text-center form_input_data" value="0" onkeyup="keyupTotal('+order_line+');" oninput="this.value = checkNumber(this.value);"    name="box['+order_line+']" id="box_'+order_line+'"></td>';
        html +=    '    <td><input type="text" class="form-control md text-center form_input_data" value="0" onkeyup="keyupTotal('+order_line+');" oninput="this.value = checkNumberDec(this.value);" name="pack['+order_line+']" id="pack_'+order_line+'"></td>';
        html +=    '    <td><span  id="total_unit_'+order_line+'" >0</span>';
        html +=    '        <input type="hidden" name="input_unit_total['+order_line+']" id="input_unit_total_'+order_line+'" >';
        html +=    '    </td>';
        html +=    '    <td class="text-right"><span  id="price_unit_'+order_line+'" >0</span> <input type="hidden" name="price_unit['+order_line+']" id="price_unit'+order_line+'" ></td>';
        html +=    '    <td class="text-right"><span  id="total_product_'+order_line+'" >0</span> <input type="hidden" name="input_price_total['+order_line+']" id="input_price_total_'+order_line+'" > </td>';
        html +=    '    <td ><label id="onhand_'+order_line+'"></label> <div id="lot_data_line_'+order_line+'"></div> </td>';
        html +=    '    <td><a class="fa fa-times red" href="javascript:removeLine('+order_line+')"></a></td>';
        html +=    '</tr>';

        $(html).insertBefore("#order_line");
        // $("#product_code_"+order_line).select2();
        order_line  += 1;
        number_list += 1;
    }

    function createdOrderLineTobacco()
    {
        var sel_uom = '';
        var html = '';
        // product_item
        html +=    '<tr class="align-middle line_remove remove_'+order_line+'">';
        html +=    '    <td><span id="number_'+order_line+'">'+number_list+'</span><input type="hidden" name="number_list['+order_line+']" data-list="'+order_line+'" id="number_list_'+order_line+'" value="'+number_list+'" ></td>';
        html +=    '    <td>';
        html +=    '        <div class="input-icon">';
        html +=    '            <input class="form-control form_input_data" data-index="'+order_line+'" list="item_product" name="product_code['+order_line+']" id="product_code_'+order_line+'" onchange="selectProductLine('+order_line+');">';
        html +=    '            <datalist id="item_product">';
        html +=    '                <option value=""></option>';
        if(product_item != ''){
            $.each(product_item,function(key,val){
                html += '                   <option value="'+val.item_code+'" data-value="'+key+'">'+ val.item_description +'</option>';
            });
        }
        html +=    '            </datalist>';
        // html +=    '            <select class="custom-select select2" name="product_code['+order_line+']" id="product_code_'+order_line+'" onchange="selectProductLine('+order_line+');">';
        // html +=    '                <option value=""></option>';
        // if(product_item != ''){
        //     $.each(product_item,function(key,val){
        //         html += '                   <option value="'+val.item_code+'">'+val.item_code +' '+ val.item_description +'</option>';
        //     });
        // }
        // html +=    '            </select>';
        html +=    '            <input type="hidden" id="line_id_'+order_line+'"            name="line_id['+order_line+']" >';
        html +=    '            <input type="hidden" id="item_id_'+order_line+'"            name="item_id['+order_line+']" >';
        html +=    '            <input type="hidden" id="item_code_'+order_line+'"          name="item_code['+order_line+']" >';
        html +=    '            <input type="hidden" id="item_description_'+order_line+'"   name="item_description['+order_line+']" >';
        html +=    '        </div>';
        html +=    '    </td>';
        html +=    '    <td class="text-left product_name_'+order_line+'" onclick="selProductLot('+order_line+')"></td>';
        // html +=    '    <td class="text-left product_name_'+order_line+'"></td>';
        html +=    '    <td class="text-left product_uom_'+order_line+'"></td>';
        html +=    '    <td class="text-left">';
        html +=    '        <select class="custom-select select2" name="uom_type['+order_line+']" id="uom_type_'+order_line+'" onchange="selUomCode('+order_line+',this.value)">';
        // if(uom_list != ''){
        //     $.each(uom_list,function(key,val){
        //         if(val.base_uom_cbb_l == 'Y'){
        //             html += '                   <option value="'+val.uom_code+'" data-value="'+val.conversion_rate+'" selected >'+ val.description +'</option>';
        //             sel_uom = val.uom_code;
        //         }else{
        //             html += '                   <option value="'+val.uom_code+'" data-value="'+val.conversion_rate+'" >'+ val.description +'</option>';
        //         }
        //     });
        // }
        html +=    '        </select>';
        html +=    '        <input type="hidden" id="conversion_uom_'+order_line+'"    name="conversion_uom['+order_line+']" >';
        html +=    '        <input type="hidden" id="uom_name_'+order_line+'"    name="uom_name['+order_line+']" >';
        html +=    '    </td>';
        html +=    '    <td class="text-right"><span  id="price_unit_'+order_line+'" >0</span> <input type="hidden" name="price_unit['+order_line+']" id="price_unit'+order_line+'" ></td>';
        html +=    '    <td>';
        html +=    '        <input type="text" class="form-control md text-center form_input_data" value="0" onkeyup="keyupTotalTobac('+order_line+');" oninput="this.value = checkNumber(this.value);"    name="totaltobac['+order_line+']" id="total_tobac_'+order_line+'">';
        html +=    '        <input type="hidden" name="input_unit_total['+order_line+']" id="input_unit_total_'+order_line+'" >';
        html +=    '    </td>';
        html +=    '    <td class="text-right"><span  id="total_product_'+order_line+'" >0</span> <input type="hidden" name="input_price_total['+order_line+']" id="input_price_total_'+order_line+'" > </td>';
        html +=    '    <td ><label id="onhand_'+order_line+'"></label> <div id="lot_data_line_'+order_line+'"></div> </td>';
        html +=    '    <td><a class="fa fa-times red" href="javascript:removeLine('+order_line+')"></a></td>';
        html +=    '</tr>';

        $(html).insertBefore("#order_line_tobacco");
        selUomCode(order_line,sel_uom);
        // $("#product_code_"+order_line).select2();
        order_line  += 1;
        number_list += 1;
    }

    function showSearchDataLine()
    {
        var html = '';
        if(status == 'Confirm' || status == 'Cancelled'){
            var dis_input   = 'disabled';
        }else{
            var dis_input   = '';
        }
        $.each(data_line,function(key_line,val_line){
            number_list = val_line.number;
            var total_box   = val_line.order_cardboardbox / 0.1;
            var total_pack  = val_line.order_carton * 0.2;
            var sum = total_box + total_pack;

            html +=    '<tr class="align-middle line_remove remove_'+order_line+'">';
            html +=    '    <td><span id="number_'+order_line+'">'+number_list+'</span><input type="hidden" name="number_list['+order_line+']" data-list="'+order_line+'" id="number_list_'+order_line+'" value="'+val_line.number+'" ></td>';
            html +=    '    <td>';
            html +=    '        <div class="input-icon">';
            html +=    '            <input class="form-control form_input_data" '+dis_input+' data-index="'+order_line+'" list="item_product" name="product_code['+order_line+']" id="product_code_'+order_line+'" value="'+val_line.product_code+'"  onchange="selectProductLine('+order_line+');">';
            html +=    '            <datalist id="item_product">';
            html +=    '                <option value=""></option>';
            if(product_item != ''){
                $.each(product_item,function(key,val){
                    if(val_line.product_code == val.item_code){
                        html += '                   <option value="'+val.item_code+'" data-value="'+key+'" selected>'+val.item_code +' '+ val.item_description +'</option>';
                    }else{
                        html += '                   <option value="'+val.item_code+'" data-value="'+key+'">'+val.item_code +' '+ val.item_description +'</option>';
                    }
                });
            }
            html +=    '            </datalist>';
            // html +=    '            <select class="custom-select select2" name="product_code['+order_line+']" id="product_code_'+order_line+'" onchange="selectProductLine('+order_line+');">';
            // html +=    '                <option value=""></option>';
            // $.each(product_item,function(key,val){
            //     if(val_line.product_code == val.item_code){
            //         html += '                   <option value="'+val.item_code+'" selected>'+val.item_code +' '+ val.item_description +'</option>';
            //     }else{
            //         html += '                   <option value="'+val.item_code+'">'+val.item_code +' '+ val.item_description +'</option>';
            //     }
            // });
            // html +=    '            </select>';
            html +=    '            <input type="hidden" id="line_id_'+order_line+'"            name="line_id['+order_line+']"              value="'+val_line.id+'">';
            html +=    '            <input type="hidden" id="item_id_'+order_line+'"            name="item_id['+order_line+']"              value="'+val_line.product_id+'">';
            html +=    '            <input type="hidden" id="item_code_'+order_line+'"          name="item_code['+order_line+']"            value="'+val_line.product_code+'">';
            html +=    '            <input type="hidden" id="item_description_'+order_line+'"   name="item_description['+order_line+']"     value="'+val_line.product_description+'">';
            html +=    '        </div>';
            html +=    '    </td>';
            html +=    '    <td class="text-left product_name_'+order_line+'" onclick="selProductLot('+order_line+')">'+val_line.product_description+'</td>';
            // html +=    '    <td class="text-left product_name_'+order_line+'" >'+val_line.product_description+'</td>';
            html +=    '    <td><input type="text" class="form-control md text-center form_input_data" '+dis_input+' onkeyup="keyupTotal('+order_line+');" oninput="this.value = checkNumber(this.value);"    name="box['+order_line+']" id="box_'+order_line+'" value="'+val_line.order_cardboardbox+'"></td>';
            html +=    '    <td><input type="text" class="form-control md text-center form_input_data" '+dis_input+' onkeyup="keyupTotal('+order_line+');" oninput="this.value = checkNumberDec(this.value);" name="pack['+order_line+']" id="pack_'+order_line+'" value="'+val_line.order_carton+'"></td>';
            html +=    '    <td ><span  id="total_unit_'+order_line+'" >'+numberFormat(sum)+'</span>';
            html +=    '        <input type="hidden" name="input_unit_total['+order_line+']" id="input_unit_total_'+order_line+'" value="'+sum+'">';
            html +=    '    </td>';
            html +=    '    <td class="text-right"><span  id="price_unit_'+order_line+'" >'+numberFormat(val_line.price_unit)+'</span> <input type="hidden" name="price_unit['+order_line+']" id="price_unit'+order_line+'" value="'+val_line.price_unit+'"></td>';
            html +=    '    <td class="text-right"><span  id="total_product_'+order_line+'" >'+numberFormat(val_line.total_price)+'</span> <input type="hidden" name="input_price_total['+order_line+']" id="input_price_total_'+order_line+'" value="'+val_line.total_price+'"> </td>';
            html +=    '    <td > <label id="onhand_'+order_line+'">'+val_line.onhand+'</label></td>';
            if(status == 'Cancelled' || status == 'Confirm'){
                html +=    '    <td></td>';
            }else{
                html +=    '    <td><a class="fa fa-times red" href="javascript:removeLine('+order_line+');removeDataLine('+val_line.id+');"></a></td>';
            }
            html +=    '</tr>';

            order_line  += 1;
        });

        number_list += 1;
        $(html).insertBefore("#order_line");
        // $("#select2").select2();
    }

    function showSearchDataLineTobacco()
    {
        var html = '';
        if(status == 'Confirm' || status == 'Cancelled'){
            var dis_input   = 'disabled';
        }else{
            var dis_input   = '';
        }
        $.each(data_line,function(key_line,val_line){
            number_list = val_line.number;
            var total_box   = val_line.order_cardboardbox / 0.1;
            var total_pack  = val_line.order_carton * 0.2;
            var sum = total_box + total_pack;

            html +=    '<tr class="align-middle line_remove remove_'+order_line+'">';
            html +=    '    <td><span id="number_'+order_line+'">'+number_list+'</span><input type="hidden" name="number_list['+order_line+']" data-list="'+order_line+'" id="number_list_'+order_line+'" value="'+val_line.number+'" ></td>';
            html +=    '    <td>';
            html +=    '        <div class="input-icon">';
            html +=    '            <input class="form-control form_input_data" '+dis_input+' data-index="'+order_line+'" list="item_product" name="product_code['+order_line+']" id="product_code_'+order_line+'" value="'+val_line.product_code+'"  onchange="selectProductLine('+order_line+');">';
            html +=    '            <datalist id="item_product">';
            html +=    '                <option value=""></option>';
            if(product_item != ''){
                $.each(product_item,function(key,val){
                    if(val_line.product_code == val.item_code){
                        html += '                   <option value="'+val.item_code+'" data-value="'+key+'" selected>'+val.item_code +' '+ val.item_description +'</option>';
                    }else{
                        html += '                   <option value="'+val.item_code+'" data-value="'+key+'">'+val.item_code +' '+ val.item_description +'</option>';
                    }
                });
            }
            html +=    '            </datalist>';
            html +=    '            <input type="hidden" id="line_id_'+order_line+'"            name="line_id['+order_line+']"              value="'+val_line.id+'">';
            html +=    '            <input type="hidden" id="item_id_'+order_line+'"            name="item_id['+order_line+']"              value="'+val_line.product_id+'">';
            html +=    '            <input type="hidden" id="item_code_'+order_line+'"          name="item_code['+order_line+']"            value="'+val_line.product_code+'">';
            html +=    '            <input type="hidden" id="item_description_'+order_line+'"   name="item_description['+order_line+']"     value="'+val_line.product_description+'">';
            html +=    '        </div>';
            html +=    '    </td>';
            html +=    '    <td class="text-left product_name_'+order_line+'" onclick="selProductLot('+order_line+')">'+val_line.product_description+'</td>';
            // html +=    '    <td class="text-left product_name_'+order_line+'" >'+val_line.product_description+'</td>';
            html +=    '    <td class="text-left product_uom_'+order_line+'">'+val_line.uom_code+'</td>';
            html +=    '    <td class="text-left">';
            html +=    '        <select class="custom-select select2" '+dis_input+' name="uom_type['+order_line+']" id="uom_type_'+order_line+'" onchange="selUomCode('+order_line+',this.value)">';
            if(uom_list != ''){
                $.each(uom_list,function(key,val){
                    if(val_line.uom_code == val.uom_code){
                        html += '                   <option value="'+val.uom_code+'" data-value="'+val.conversion_rate+'" selected >'+ val.description +'</option>';
                        sel_uom = val.uom_code;
                        selUomCode(order_line,sel_uom)
                    }else{
                        html += '                   <option value="'+val.uom_code+'" data-value="'+val.conversion_rate+'" >'+ val.description +'</option>';
                    }
                });
            }
            html +=    '        </select>';
            html +=    '        <input type="hidden" id="conversion_uom_'+order_line+'"    name="conversion_uom['+order_line+']" >';
            html +=    '        <input type="hidden" id="uom_name_'+order_line+'"    name="uom_name['+order_line+']" >';
            html +=    '    </td>';
            html +=    '    <td class="text-right"><span  id="price_unit_'+order_line+'" >'+numberFormat(val_line.price_unit)+'</span> <input type="hidden" name="price_unit['+order_line+']" id="price_unit'+order_line+'" value="'+val_line.price_unit+'"></td>';
            html +=    '    <td>';
            html +=    '        <input type="text" '+dis_input+' class="form-control md text-center form_input_data" value="'+val_line.order_total_approve+'" onkeyup="keyupTotalTobac('+order_line+');" oninput="this.value = checkNumber(this.value);"    name="totaltobac['+order_line+']" id="total_tobac_'+order_line+'">';
            html +=    '        <input type="hidden" name="input_unit_total['+order_line+']" id="input_unit_total_'+order_line+'" value="'+val_line.order_total_approve+'">';
            html +=    '    </td>';
            html +=    '    <td class="text-right"><span  id="total_product_'+order_line+'" >'+numberFormat(val_line.total_price)+'</span> <input type="hidden" name="input_price_total['+order_line+']" id="input_price_total_'+order_line+'" value="'+val_line.total_price+'"> </td>';
            html +=    '    <td > <label id="onhand_'+order_line+'">'+val_line.onhand+'</label></td>';
            if(status == 'Cancelled' || status == 'Confirm'){
                html +=    '    <td></td>';
            }else{
                html +=    '    <td><a class="fa fa-times red" href="javascript:removeLine('+order_line+');removeDataLine('+val_line.id+');"></a></td>';
            }
            html +=    '</tr>';

            order_line  += 1;
        });

        number_list += 1;
        $(html).insertBefore("#order_line_tobacco");
        // $("#select2").select2();
    }

    function selUomCode(index,value)
    {   
        $(".product_uom_"+index).html(value);
        var convertion = $("#uom_type_"+index+" option").filter(function(){
            return this.value == value;
        }).data('value');
        var price = $("#uom_type_"+index+" option").filter(function(){
            return this.value == value;
        }).data('price');
        var description = $("#uom_type_"+index+" option").filter(function(){
            return this.value == value;
        }).html();

        $("#conversion_uom_"+index).val(convertion);
        $("#uom_name_"+index).val(description);
        $("#price_unit_"+index).html(numberFormat(price))
        $("#price_unit"+index).val(price)

        var total = $("#total_tobac_"+index).val();
        if(total > 0){
            keyupTotalTobac(index);
        }
    }

    function removeDataLine(id)
    {
        line_remove.push(id);
    }

    function selectProductLine(index)
    {
        var code        = $("#product_code_"+index).val();
        var dataProduct = product_item.find(data => data.item_code === code)
        var total       = $("#input_unit_total_aprove_"+index).val();

        $(".product_name_"+index).html(dataProduct.item_description);
        $("#item_description_"+index).val(dataProduct.item_description);
        // $("#price_unit_"+index).html(numberFormat(dataProduct.price_unit));
        $("#item_id_"+index).val(dataProduct.item_id);
        $("#item_code_"+index).val(dataProduct.item_code);
        $("#onhand_"+index).html(dataProduct.onhand)
        
        if(product_type == 20){
             $("#price_unit_"+index).html(numberFormat(0));
             $("#price_unit"+index).val(0);
            var html = '<option></option>'
            $.each(dataProduct.uom_list,function(key,val){
                if(val.uom_code != 'E00'){
                    if(val.uom_code == 'CS1'){
                        html += '<option value="'+val.uom_code+'" selected data-value="'+val.conversion_rate+'" data-price="'+val.price_unit+'" >'+ val.unit_of_measure +'</option>'
                    }else{
                        html += '<option value="'+val.uom_code+'" data-value="'+val.conversion_rate+'" data-price="'+val.price_unit+'" >'+ val.unit_of_measure +'</option>'
                    }
                }
            })
            $("#uom_type_"+index).html(html)
            selUomCode(index,'CS1')
        }else{
             $("#price_unit_"+index).html(numberFormat(dataProduct.price_unit));
             $("#price_unit"+index).val(dataProduct.price_unit);

        }
    }

    function keyupTotal(index)
    {
        var code        = $("#product_code_"+index).val();
        var dataProduct = product_item.find(data => data.item_code === code)
        var box     = $("#box_"+index).val();
        var pack    = $("#pack_"+index).val();

        var total_box   = box / 0.1;
        var total_pack  = pack * 0.2;
        var sum = total_box + total_pack;
        var price = dataProduct.price_unit * sum;
        var total_box_amount = 0;
        var total_pack_amount = 0;
        var total_unit_amount = 0;

        $('[name*=box]').each(function() {
            total_box_amount +=  _.parseInt($(this).val())
        });
        
        $('[name*=pack]').each(function() {
            total_pack_amount +=  _.parseInt($(this).val())
        });
        if(!_.isNaN(total_box_amount)) {
            $(".total_box_amount").html(numberFormat(total_box_amount))
        }
        if(!_.isNaN(total_pack_amount)) {
            $(".total_pack_amount").html(numberFormat(total_pack_amount))
        }
        $("#total_unit_"+index).html(numberFormat(sum));
        $("#input_unit_total_"+index).val(sum);
        $("#total_product_"+index).html(numberFormat(price));
        $("#input_price_total_"+index).val(price);

        var total_amount = 0;
        $.each($("input[name^=input_price_total]"),function(idx,elem){
            total_amount += $(elem).val()*1;
        });

        $("#total_amount").val(total_amount);
        $(".total_amount").html(numberFormat(total_amount));
        $('[name*=input_unit_total]').each(function() {
            total_unit_amount +=  parseFloat($(this).val())
        });
        if(!_.isNaN(total_unit_amount)) {
            $(".total_unit_amount").html(numberFormat(total_unit_amount))
        }

    }

    function keyupTotalTobac(index)
    {
        var value       = $("#uom_type_"+index).val();
        var conver      = $("#conversion_uom_"+index).val();
        var order       = $("#total_tobac_"+index).val();
        var uom_price   = $("#uom_type_"+index+" option").filter(function(){
                                return this.value == value;
                            }).data('price');

        // var sum   = order * conver;
        var price = uom_price * order;

        $("#total_unit_"+index).html(numberFormat(order));
        $("#input_unit_total_"+index).val(order);
        $("#total_product_"+index).html(numberFormat(price));
        $("#input_price_total_"+index).val(price);

        var total_amount = 0;
        $.each($("input[name^=input_price_total]"),function(idx,elem){
            total_amount += $(elem).val()*1;
        });

        $("#total_amount_tobac").val(total_amount);
        $(".total_amount_tobac").html(numberFormat(total_amount));
    }

    function removeLine(index)
    {
        $(".remove_"+index).remove();
        number_list = 1;

        $.each($("input[name^=number_list]"),function(idx,elem){
            // var n_index = $(elem).val();
            // console.log('index: '+n_index);

            var n_index = $(elem).data('list');

            $(elem).val(number_list);
            $("#number_"+n_index).html(number_list);

            number_list += 1;
        });
    }

    function selProductLot(index)
    {
        if(index != ck_line){
            $(".lot_tr").remove();
            lot_line = 0
            $("#create_lot").prop('disabled',false);
            $("#save_log").prop('disabled',true);
            arr_lot_update = []
        }
        ck_line = index;
        var order_id = $("#line_id_"+index).val();
        if(order_id)
        {
            getLotData();
        }else if(arr_lot_list[index]){
            getLotData(); 
        }
    }

    function getLotData() 
    {
        var index_line = ck_line;
        if(index_line == ''){
            return false;
        }
        // if(lot_line > 0 && arr_lot_update == ''){
        //     addLotList();
        //     return false;
        // }
        var code        = $("#product_code_"+index_line).val();
        var name        = $("#item_description_"+index_line).val();
        var total       = $("#input_unit_total_"+index_line).val();
        if(total == 0){
            return false;
        }
        var code_org    = $("#org_code_"+index_line).val();
        var lot_number  = $("#lot_number_"+index_line).val();
        var line_id     = $("#line_id_"+index_line).val();

        if(arr_lot_list[index_line]){
            console.log(arr_lot_list[index_line]);
        }else{
            arr_lot_list[index_line]  = [];
        }

        if(code == ''){
            return false;
        }
        $("#lot_icode").val(code);
        $("#lot_iname").val(name);
        $("#i_total").val(total);

        loading();
        if(code != ''){
            $.ajax({
                url     : '{{ url("om/ajax/prepare-saleorder/getlotdata") }}',
                type    : 'post',
                data    : {
                    '_token'    : '{{ csrf_token() }}',
                    code        : code,
                    total       : total,
                    line_id     : line_id
                },
                success :function(rest){
                    swal.close();
                    var data = rest.data;
                    list_lot = data.data.data;
                    arr_lot_update = data.data.data_lot;
                    total_onhand = data.data.total_onhand;
                    
                    if(arr_lot_update != ''){
                        $.each(arr_lot_update,function(key,value){
                            $.each(value,function(sk,sv){
                                addLotList(key)
                            })
                        });
                    }else if(arr_lot_list[index_line] != '' ){
                        if(arr_lot_list[index_line]){
                            $.each(arr_lot_list[index_line],function(key,value){
                                if(key != 0){
                                    addLotList(null,index_line)
                                }
                            });
                        }
                    }else{
                        addLotList()
                    }
                }
            });
        }
    }

    function addLotList(key_org = '',item_index = '')
    {
        var index_line = ck_line;
        if(index_line == ''){
            return false;
        }
        var code        = $("#product_code_"+index_line).val();
        var name        = $("#item_description_"+index_line).val();

        lot_line += 1;

        if(status == 'Confirm' || status == 'Inprocess'){
            var dis_input   = 'disabled';
        }else{
            var dis_input   = '';
        }

        var lot_html = '';
        var name_org = '';
        var org_id   = '';
        var onhand   = '';
        var unit     = '';
        var lot_id   = '';

        if(status == 'Confirm' || status == 'Cancelled'){
            var dis_input   = 'disabled';
        }else{
            var dis_input   = '';
        }

        lot_html += '<tr class="align-middle lot_tr lot_tr_line_'+lot_line+'" data-index="'+lot_line+'">';
        lot_html += '    <td><input type="text" class="form-control md text-center" disabled="" id="lot_icode" value="'+code+'"></td>';
        lot_html += '    <td><input type="text" class="form-control md" disabled="" id="lot_iname" value="'+name+'">';
        lot_html += '    <input type="hidden" id="product_line_'+lot_line+'" value="'+index_line+'">'
        lot_html += '   </td>';
        lot_html += '    <td>';
        lot_html += '        <div class="input-icon">';
        lot_html += '            <select class="custom-select select2 list_org form_input_data" '+dis_input+' name="org_list['+lot_line+']" id="org_list_'+lot_line+'" onchange="selectOrg('+lot_line+');">';
        lot_html += '                <option value=""></option>';
        $.each(list_lot,function(key,val){
            lot_html += '<option value="'+key+'" data-index="'+index_line+'" data-name="'+val.name+'" >'+key+'</option>';
        });
        lot_html += '            </select>';
        lot_html += '        </div>';
        lot_html += '    </td>';
        lot_html += '    <td><input type="text" class="form-control md form_input_data" disabled="" id="name_org_'+lot_line+'" value="'+name_org+'">';
        lot_html += '       <input type="hidden" name="lot_id['+lot_line+']" id="lot_id_'+lot_line+'" value="'+lot_id+'">';
        lot_html += '    </td>';
        lot_html += '    <td>';
        lot_html += '        <div class="input-icon">';
        lot_html += '            <select class="custom-select select2 subinventory_lot form_input_data" '+dis_input+' name="subinv_list['+lot_line+']" id="subinv_list_'+lot_line+'" onchange="sellotDataList('+lot_line+');">';
        lot_html += '                <option value=""></option>';
        lot_html += '            </select>';
        lot_html += '        </div>';
        lot_html += '    </td>';
        lot_html += '    <td>';
        lot_html += '        <div class="input-icon">';
        lot_html += '            <select class="custom-select select2 locator_lot form_input_data" '+dis_input+' name="locator_list['+lot_line+']" id="locator_list_'+lot_line+'" onchange="sellotDataList('+lot_line+');">';
        lot_html += '                <option value=""></option>';
        lot_html += '            </select>';
        lot_html += '        </div>';
        lot_html += '    </td>';
        lot_html += '    <td>';
        lot_html += '        <div class="input-icon">';
        lot_html += '            <select class="custom-select select2 list_lot form_input_data" '+dis_input+' name="lot_list['+lot_line+']" id="lot_list_'+lot_line+'" onchange="sellotDataList('+lot_line+');">';
        lot_html += '                <option value=""></option>';
        lot_html += '            </select>';
        lot_html += '        </div>';
        lot_html += '    </td>';
        lot_html += '    <td><input type="text" class="form-control md" disabled="" name="on_hand['+lot_line+']" data-value="'+lot_line+'" id="on_hand_'+lot_line+'" value="'+onhand+'"></td>';
        lot_html += '    <td class="text-right" id="unit_order_'+lot_line+'" >'+total_onhand+'</td>';
        lot_html += '    <td class="text-right"><span id="order_total_'+lot_line+'"></span> <input type="hidden" data-value="'+lot_line+'" name="order_total_input['+lot_line+']" id="order_total_input_'+lot_line+'"></td>';
        lot_html += '    <td><a class="fa fa-times red" href="javascript:removeLotLine('+lot_line+');"></a></td>';
        lot_html += '</tr>';

        $("#lot_data_input").append(lot_html);
        $(".select2").select2();
        $("#create_lot").prop('disabled',true);

        if(arr_lot_update != ''){
            $("#org_list_"+lot_line).val(arr_lot_update[key_org][lot_line].inv_org_code).trigger('change');
            $("#lot_id_"+lot_line).val(arr_lot_update[key_org][lot_line].id);
        }
        if(item_index != ''){
            $("#org_list_"+lot_line).val(arr_lot_list[index_line][lot_line].org_code).trigger('change');
        }
    }

    function removeLotLine(index = ''){
        var productline                     = $("#product_line_"+index).val();
        if(arr_lot_list[productline][index]){
            arr_lot_list[productline][index] = '';
        }
        lot_line -= 1;
        if(lot_line <= 0){
            $("#create_lot").prop('disabled',false);
        }
        arr_lot_list[productline].splice(arr_lot_list[productline].indexOf(index), 1);
        $(".lot_tr_line_"+index).remove();
    }

    function selectOrg(index = '')
    {
        var org         = $("#org_list_"+index).val();
        if(org == ''){
            return false;
        }
        var index_line  = $('#org_list_'+index+' option:selected').data('index')
        var org_name    = $('#org_list_'+index+' option:selected').data('name')
        $("#name_org_"+index).val(org_name);

        var total       = $("#input_unit_total_"+index_line).val();
        var lot_number  = $("#lot_number_"+index_line).val();
       
        var active      = '';

        var index_linep = ck_line;
        var code        = $("#product_code_"+index_linep).val();

        $.ajax({
            url     : '{{ url("om/ajax/prepare-saleorder/get-org-list") }}',
            type    : 'post',
            data    : {
                '_token'    : '{{ csrf_token() }}',
                code        : code,
                org_code    : org
            },
            success :function(rest){
                var  data = rest.data; 
                lotListData = data.data;
                if(data.status){
                    var html2 = '<option value=""></option>';
                    $.each(data.data.lot_number,function(key_i,val_i){
                        html2 += '<option value="'+key_i+'" data-org="'+val_i.org_code+'" data-value="'+val_i.quantity+'" data-index="'+index_line+'">'+key_i+'</option>';
                    });
                    $("#lot_list_"+index).html(html2);

                    var html3 = '<option value=""></option>';
                    $.each(data.data.subinventory,function(key_si,val_si){
                        html3 += '<option value="'+key_si+'" data-org="'+val_si.org_code+'" data-value="'+val_si.quantity+'" data-index="'+index_line+'">'+key_si+'</option>';
                    });
                    $("#subinv_list_"+index).html(html3);

                    var html4 = '<option value=""></option>';
                    $.each(data.data.locator,function(key_l,val_l){
                        html4 += '<option value="'+key_l+'" data-org="'+val_l.org_code+'" data-value="'+val_l.quantity+'" data-index="'+index_line+'">'+key_l+'</option>';
                    });
                    $("#locator_list_"+index).html(html4);

                    if(arr_lot_update != ''){
                        $("#lot_list_"+index).val(arr_lot_update[org][index].lot_number).trigger('change');
                    }
                    if(arr_lot_update != ''){
                        $("#subinv_list_"+index).val(arr_lot_update[org][index].subinventory_code).trigger('change');
                    }
                    if(arr_lot_update != ''){
                        $("#locator_list_"+index).val(arr_lot_update[org][index].locators).trigger('change');
                    }

                    if(arr_lot_list[index_linep] != ''){
                        $("#lot_list_"+index).val(arr_lot_list[index_linep][index].lot_number).trigger('change');
                    }
                    if(arr_lot_list[index_linep] != ''){
                        $("#subinv_list_"+index).val(arr_lot_list[index_linep][index].subinventory_code).trigger('change');
                    }
                    if(arr_lot_list[index_linep] != ''){
                        $("#locator_list_"+index).val(arr_lot_list[index_linep][index].location).trigger('change');
                    }
                }
            }
        });
    }

    function sellotDataList(index)
    {
        //-- item
        var index_linep = ck_line;
        var code        = $("#product_code_"+index_linep).val();
        //-- org
        var org         = $("#org_list_"+index).val();
        var lot         = $("#lot_list_"+index).val();
        var subinv      = $("#subinv_list_"+index).val();
        var locator     = $("#locator_list_"+index).val();
        var index_line  = '';
        var order_sum   = 0;
        if(subinv){
            index_line      = $('#subinv_list_'+index+' option:selected').data('index');
        }
        if(locator){
            index_line      = $('#locator_list_'+index+' option:selected').data('index');
        }
        if(lot){
            index_line      = $('#lot_list_'+index+' option:selected').data('index');
        }
        var total       = $("#input_unit_total_"+index_line).val();
        if(index == 1){
            order_sum         = total;
        }
        $.ajax({
            url     : '{{ url("om/ajax/prepare-saleorder/get-org-onhand") }}',
            type    : 'post',
            data    : {
                '_token'    : '{{ csrf_token() }}',
                code        : code,
                org_code    : org,
                lot_number  : lot,
                subinv      : subinv,
                locator     : locator
            },
            success :function(rest){
                var  data = rest.data; 
                
                $('#on_hand_'+index).val(data.data);
                //----
                if(parseFloat(data.data) >= parseFloat(total)){
                    $("#on_hand_"+index).removeClass('text-danger');
                    $("#create_lot").prop('disabled',true);
                    $("#save_log").prop('disabled',false);
           
                    if(index == 1){
                        $("#order_total_"+index).html(numberFormat(order_sum));
                        $("#order_total_input_"+index).val(order_sum);
                        arr_lot_list[index_line] = jQuery.grep(arr_lot_list[index_line],function(value){
                            return value == index;
                        });
                        lot_line = 1;
                    }else if(index > 1){
                        $("#order_total_"+index).html(numberFormat(order_sum));
                        $("#order_total_input_"+index).val(order_sum);
                        setTimeout(function(){
                            cal_lot(index,order_sum);
                        },500)
                    }

                    $("#order_total_"+index).html(numberFormat(total));
                    $("#order_total_input_"+index).val(total);
                }else{
                    order_sum = order_sum - data.data;
                    $("#create_lot").prop('disabled',false);
                    $("#save_log").prop('disabled',true);
                    $("#on_hand_"+index).addClass('text-danger');
                    $("#order_total_"+index).html(numberFormat(data.data));
                    $("#order_total_input_"+index).val(data.data);
                    setTimeout(function(){
                        cal_lot(index,order_sum);
                    },500)
                }
            }
        });

    }

    function cal_lot(index,lot_sum)
    {
        var index_line          = $('#lot_list_'+index+' option:selected').data('index');
        var total               = $("#input_unit_total_"+index_line).val();
        var total_lot_q         = 0;
        var lot_line            = 0;
        var lot                 = []
        var cal_onhand          = 0;
        var arrlot_hand         = [];
        arrlot_hand['onhand']   = [];
        arrlot_hand['sum']      = [];
        arrlot_hand['index']    = [];

        $("input[name^=order_total_input]").map(function(idx, elem){
            var index_lot   = $(elem).data('value');
            var onhand      = $('#on_hand_'+index_lot).val();

            if(parseFloat(total) > parseFloat(onhand)){
                arrlot_hand['onhand'][index_lot]  = onhand;
                arrlot_hand['sum'][index_lot]     = parseFloat(total) - parseFloat(onhand);
                arrlot_hand['index'][index_lot]   = index_lot;
            }else{
                if(index_lot == 1){
                    arrlot_hand['onhand'][index_lot]  = onhand;
                    arrlot_hand['sum'][index_lot]     = parseFloat(total);
                    arrlot_hand['index'][index_lot]   = index_lot;
                }else{
                    arrlot_hand['onhand'][index_lot]  = onhand;
                    arrlot_hand['sum'][index_lot]     = parseFloat(total) - parseFloat(total_lot_q);
                    arrlot_hand['index'][index_lot]   = index_lot;
                }
            }
            lot[index_lot]  = $(elem).val();
            if(total_lot_q > total){
                arrlot_hand['onhand'].splice($.inArray(index_lot,arrlot_hand['onhand']),1);
                arrlot_hand['sum'].splice($.inArray(index_lot,arrlot_hand['sum']),1);
            }else{
                total_lot_q     += parseFloat($(elem).val());
            }
        });

        console.log(arrlot_hand);

        $("input[name^=order_total_input]").map(function(idx, elem){
            var index_lot   = $(elem).data('value');
            var lot_hand    = $('#on_hand_'+index_lot).val();
            var data        = $(elem).val();

            if(parseFloat(lot_hand) > parseFloat(total)){
                lot_line = index;
                $("#order_total_"+index_lot).html(numberFormat(arrlot_hand.sum[index_lot]));
                $("#order_total_input_"+index_lot).val(arrlot_hand.sum[index_lot]);
                if(index_lot > lot_line){
                    arr_lot_list[index_line].splice($.inArray(index_lot,arr_lot_list[index_line]),1);
                }
            }
        });
    }

    function saveLotData()
    {
        var index_line = ck_line;
        arr_lot_list[index_line] = [];

        $(".lot_tr").filter(function(){
            var index = $(this).data("index");
            console.log(index);

            var productline  = $("#product_line_"+index).val();
            
            var subinv_val   = $('#subinv_list_'+index).val();
            var locator_val  = $('#locator_list_'+index).val();
            var lot_val      = $('#lot_list_'+index).val();

            var on_hand      = $("#on_hand_"+index).val();
            var lot_id       = $("#lot_id_"+index).val();
            var last_lot     = 0;
            var data = []
            console.log(subinv_val);
            console.log(locator_val);
            console.log(lot_val);
            console.log('---------------')

            if(subinv_val != ''){
                data.lot_number = '';
                data.quantity   = lotListData['subinventory'][subinv_val].quantity;
                data.tran_uom   = lotListData['subinventory'][subinv_val].tran_uom;
                data.org_id     = lotListData['subinventory'][subinv_val].org_id;
                data.org_code   = lotListData['subinventory'][subinv_val].org_code;
                data.org_name   = lotListData['subinventory'][subinv_val].org_name;
                data.subinventory   = lotListData['subinventory'][subinv_val].subinventory;
                if(locator_val == ''){
                    data.locator_id   = '';
                    data.location   = '';
                }
            }
            if(locator_val != ''){
                data.lot_number = '';
                data.quantity   = lotListData['locator'][locator_val].quantity;
                data.tran_uom   = lotListData['locator'][locator_val].tran_uom;
                data.org_id     = lotListData['locator'][locator_val].org_id;
                data.org_code   = lotListData['locator'][locator_val].org_code;
                data.org_name   = lotListData['locator'][locator_val].org_name;
                if(subinv_val == ''){
                    data.subinventory   = ''
                }
                data.locator_id   = lotListData['locator'][locator_val].locator_id;
                data.location   = lotListData['locator'][locator_val].location;
            }
            if(lot_val != ''){
                data.lot_number = lotListData['lot_number'][lot_val].lot_number;
                data.quantity   = lotListData['lot_number'][lot_val].quantity;
                data.tran_uom   = lotListData['lot_number'][lot_val].tran_uom;
                data.org_id     = lotListData['lot_number'][lot_val].org_id;
                data.org_code   = lotListData['lot_number'][lot_val].org_code;
                data.org_name   = lotListData['lot_number'][lot_val].org_name;
                if(subinv_val == ''){
                    data.subinventory   = ''
                }
                if(locator_val == ''){
                    data.locator_id   = '';
                    data.location   = '';
                }
            }

            arr_lot_list[productline][index]                     = [];
            arr_lot_list[productline][index]['lot_id']           =  lot_id;
            arr_lot_list[productline][index]['lot_number']       =  data.lot_number;
            arr_lot_list[productline][index]['onhand_qunty']     =  data.quantity;
            arr_lot_list[productline][index]['lot_uom']          =  data.tran_uom;
            arr_lot_list[productline][index]['conv_qty']         =  data.quantity;
            arr_lot_list[productline][index]['on_hand']          =  on_hand;
            arr_lot_list[productline][index]['org']              =  data.org_id;
            arr_lot_list[productline][index]['org_code']         =  data.org_code;
            arr_lot_list[productline][index]['org_name']         =  data.org_name;
            arr_lot_list[productline][index]['subinventory_code']       =  data.subinventory;
            arr_lot_list[productline][index]['inventory_location_id']   =  data.locator_id;
            arr_lot_list[productline][index]['location']        =  data.location;
        });
        console.log(arr_lot_list);
        $("#save_log").prop('disabled',true)
    }

    function btnClearForm()
    {
        window.location.reload();
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

    function checkNumber(value)
    {
        var number  = value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')
        var x       = number.split('.');
        var x1      = x[0];
        var x2      = x.length > 1 ? '.' + x[1] : '';
        // var rgx     = /(\d+)(\d{3})/;
        // while (rgx.test(x1)) {
        //     x1 = x1.replace(rgx, '$1' + '$2');
        // }
        return x1;
    }

    function checkNumberDec(value)
    {
        return value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')
    }

    function loading()
    {
        Swal.fire({
            title: 'โปรดรอ !',
            html: 'กำลังโหลดข้อมูล',// add html attribute if you want or remove
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });
    }

    function reActiveDatePicker(value_date)
    {
        var vue = new Vue({
            data(){
                return {
                    value  : value_date
                }
            },
            template:`
                <datepicker-th
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data delivary_date"
                    name="delivary_date"
                    id="delivary_date"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".delivary_date");
    }

    function deActiveDatePicker(value_date)
    {
        var vue = new Vue({
            data(){
                return {
                    value  : value_date
                }
            },
            template:`
                <datepicker-th
                    :disabled="true"
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2 form_input_data delivary_date"
                    name="delivary_date"
                    id="delivary_date"
                    format="DD/MM/YYYY"
                    placeholder=""
                    :value="value"
                    >
                </datepicker-th>
                `,
            methods:{
            }
        }).$mount(".delivary_date");
    }

    function printErrorMsgSaleOrder(msg){
            $(".print-error-msg-saleorder").find("ul").html('');
            $(".print-error-msg-saleorder").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-saleorder").find("ul").append('<li>'+value+'</li>');
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
@stop
