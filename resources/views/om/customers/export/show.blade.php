@extends('layouts.app')

@section('title', 'Export Customer')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>
        {{-- <x-get-program-code url="om/customers/exports/" /> Export Customer --}}
        OMM0006 : ข้อมูลลูกค้า สำหรับขายต่างประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.customers.exports.index') }}">
                {{-- Export Customer Search และการส่งขออนุมัติการสร้างลูกค้า ระบบ E-Commerce สำหรับขายต่างประเทศ --}}
                ค้นหาลูกค้า สำหรับขายต่างประเทศ
            </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>
                {{-- <x-get-program-code url="om/customers/export/" /> 
                Export Customer Detail --}}
                OMM0006 : ข้อมูลลูกค้า สำหรับขายต่างประเทศ
            </strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>Foreign Costomer Detail</h5>
        </div>
        <div class="ibox-content">
            <div class="tabs-container tabs-primary-container">
                <ul class="nav nav-tabs nav-button-tabs responsive-md" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1">กำหนดข้อมูลลูกค้า</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2" onclick="getCustomerContactList();">ข้อมูลผู้ติดต่อ</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-3" onclick="getCustomerShippingList();">สถานที่จัดส่งสินค้า</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form id="customer_form" autocomplete="off" enctype="multipart/form-data">
                                <div class="row space-50 justify-content-md-center mt-4 mw-xl-1000"><!--justify-content-md-center-->
                                    <div class="col-xl-12 mb-md-4">

                                        <div class="form-header-buttons">
                                            <h3 class="black">กำหนดข้อมูลลูกค้า</h3>
                                            <div class="buttons">
                                                @if($customer->status == 'Draft')
                                                    <button class="btn btn-lg btn-primary w-160" onclick="checkContact();" type="button">บันทึก</button>
                                                @else
                                                    <button class="btn btn-lg btn-primary w-160" onclick="updateCustomerData();" type="button">บันทึก</button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <div class="alert alert-warning alert-dismissible print-error-msg-customer" id="close-btn-customer" style="display: none;">
                                            <button type="button" class="close" onclick="$('#close-btn-customer').hide();">&times;</button>
                                            <h5> Warning!</h5>
                                            <ul></ul>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 b-r">
                                        <div class="row space-5 ">
                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสขอสร้างลูกค้า(Request Number)</label>
                                                    <input type="text" class="form-control" disabled  value="{{ !empty($customer->request_number)? $customer->request_number : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                     <label class="d-block">รหัสลูกค้า (Customer Number)</label>
                                                    <input type="text" class="form-control" disabled value="{{ !empty($customer->customer_number)? $customer->customer_number : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                     <label class="d-block">รหัสลูกค้าเดิมในระบบ TM</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="customer_number_tm" id="customer_number_tm" value="{{ !empty($customer->customer_code_tm)? $customer->customer_code_tm : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">สกุลเงิน (Currency) <span style="color: red;" >*</span></label>
                                                    <div class="row space-5">
                                                        <div class="col-5">
                                                            <select class="custom-select select2-input" autocomplete="none" name="currency" id="currency" onchange="$('#currency_name').val($('#currency option:selected').data('value'));">
                                                                <option value=""></option>
                                                                @foreach ($currency as $cy_item)
                                                                    <option value="{{ $cy_item['currency_code'] }}" data-value="{{ $cy_item['description'] }}"  {{ $cy_item['currency_code'] == $customer->currency? 'selected' : '' }} >{{ $cy_item['currency_code'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-7">
                                                            <input type="text" class="form-control" disabled name="" id="currency_name" placeholder="" value="{{ !empty($currency[$customer->currency])? $currency[$customer->currency]['description'] : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทการขาย (Sales Classification)</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" autocomplete="none" name="sales_classification_code" id="sales_classification_code" disabled value="{{ !empty($customer->sales_classification_code)? $customer->sales_classification_code : '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทลูกค้า (Customer Type) <span style="color: red;" >*</span></label>
                                                    <div class="input-icon">
                                                        <select class="custom-select select2-input" name="customer_type_id" id="customer_type_id">
                                                            <option value=""></option>
                                                            @foreach ($type_list as $item_type)
                                                                <option value="{{ $item_type['id'] }}" {{ $item_type['id'] == $customer->customer_type_id? 'Selected':'' }}>{{ $item_type['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <i class="fa fa-search"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อลูกค้า (Customer Name) <span style="color: red;" >*</span></label>
                                                    <input type="text" class="form-control" autocomplete="none" name="customer_name" id="customer_name" value="{{ !empty($customer->customer_name)? $customer->customer_name : '' }}">

                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อย่อลูกค้า (Customer Short Name)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="customer_short_name" id="customer_short_name" value="{{ !empty($customer->customer_short_name)? $customer->customer_short_name : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ประเทศ (Country) <span style="color: red;" >*</span></label>
                                                    <select class="custom-select select2-input" name="country_code" id="country_code" onchange="$('#customer_country').val($('#country_code option:selected').data('value'));thaiOrNot(this.value,'customer');">
                                                        <option value=""></option>
                                                        @foreach ($list_country as $item_country)
                                                            <option value="{{ $item_country['id'] }}" data-value="{{ $item_country['geography_name'] }}" {{ $item_country['id'] == $customer->country_code? 'Selected':'' }}>{{ $item_country['geography_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" class="form-control" id="customer_country" name="customer_country"  value="{{ !empty($list_country[$customer->country_code])?$list_country[$customer->country_code]['geography_name'] : '' }}">
                                                </div>
                                            </div>

                                            <div class=" col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ บรรทัดที่ 1 (Address Line 1)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="address_line1" id="address_line1" value="{{ !empty($customer->address_line1)? $customer->address_line1 : '' }}">
                                                </div>
                                            </div>

                                            <div class=" col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ บรรทัดที่ 2 (Address Line 2)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="address_line2" id="address_line2" value="{{ !empty($customer->address_line2)? $customer->address_line2 : '' }}">
                                                </div>
                                            </div>

                                            <div class=" col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ บรรทัดที่ 3 (Address Line 3)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="address_line3" id="address_line3" value="{{ !empty($customer->address_line3)? $customer->address_line3 : '' }}">
                                                </div>
                                            </div>

                                            <div class=" col-xl-12 col-md-6 notthai">
                                                <div class="form-group">
                                                    <label class="d-block">รัฐ (State)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="state" id="state" value="{{ !empty($customer->state)? $customer->state : '' }}">
                                                </div>
                                            </div>

                                            {{-- <div class=" col-xl-12 col-md-6 notthai">
                                                <div class="form-group">
                                                    <label class="d-block">จังหวัด (Province)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="province_name" id="province_name" value="{{ !empty($customer->province_name)? $customer->province_name : '' }}">
                                                </div>
                                            </div> --}}

                                            <div class="col-xl-12 col-md-6 notthai">
                                                <div class="form-group">
                                                    <label class="d-block">เขต/อำเภอ/เมือง (City)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="city" id="city" value="{{ !empty($customer->city)? $customer->city : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6 notthai">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสไปรษณีย์ (Postal Code)</label>
                                                    <input type="number" min="0" class="form-control" autocomplete="none" name="postal_code_other" id="postal_code" value="{{ !empty($customer->postal_code) && $customer->country_code != 'TH' ? $customer->postal_code : '' }}">
                                                </div>
                                            </div>
                                            {{--  ------------------------------------------------- --}}
                                            <div class="col-xl-12 col-md-6 thai" style="display: none;">
                                                <div class="form-group">
                                                    <label class="d-block">จังหวัด (Province)</label>
                                                    <select name="province_code" id="province_code_th" style="width: 100%;" class="custom-select select2-input" onchange="$('#province_name').val($('#province_code_th option:selected').data('value'));$('#province_region').val($('#province_code_th option:selected').data('rname'));selectProvince(this.value,'customer');">
                                                        <option value=""></option>
                                                    </select>
                                                    <input type="hidden" class="form-control" id="province_name" name="province_name"  value="{{ !empty($customer->province_name)? $customer->province_name : '' }}">
                                                    <input type="hidden" class="form-control" id="province_region" name="province_region"  value="{{ !empty($customer->region_code)? $customer->region_code : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6 thai">
                                                <div class="form-group">
                                                    <label class="d-block">เขต/อำเภอ/เมือง (City)</label>
                                                    <input type="hidden" name="city_name" id="city_name_th" value="{{ !empty($customer->city)? $customer->city : '' }}">
                                                    <select name="city_code" id="city_code_th" class="custom-select select2-input" style="width: 100%;" onchange="selectDistrict(this.value,'customer');">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6 thai">
                                                <div class="form-group">
                                                    <label class="d-block">ตำบล (Sub District)</label>
                                                    <input type="hidden" name="district_name" id="district_name_th" value="{{ !empty($customer->district)? $customer->district : '' }}">
                                                    <select name="district_code" id="district_code_th" class="custom-select select2-input" style="width: 100%;" onchange="selectPostcode(this.value,'customer');">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6 thai">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสไปรษณีย์ (Postal Code)</label>
                                                    {{-- <input type="text" class="form-control" name="postal_code" id="postal_code_th" value="{{ !empty($customer->postal_code)? $customer->postal_code : '' }}"> --}}
                                                    <select name="postal_code" id="postal_code_th" class="custom-select select2-input" style="width: 100%;">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div><!--row-->
                                    </div><!--col-md-6-->

                                    <div class="col-xl-6">
                                        <div class="row space-5 ">
                                            <div class="col-md-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">เลขที่ทะเบียนการค้า (Commercial Registration Certificate) <span style="color: red;" >*</span></label>
                                                    <input type="text" class="form-control" autocomplete="none" name="tax_register_number" id="tax_register_number" value="{{ !empty($customer->tax_register_number)? $customer->tax_register_number : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">สาขา (Branch) </label>

                                                    <div class="row space-5">
                                                        <div class="col-xl-6">
                                                            <input type="text" class="form-control" autocomplete="none" name="branch" id="branch" value="{{ !empty($customer->branch)? $customer->branch : '' }}">
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="i-checks mt-2 mb-1 mr-auto">
                                                                <label class="m-0 pr-0 f13"><input type="checkbox" name="head_office_flag" id="head_office_flag" value="Y" {{ $customer->head_office_flag == 'Y'? 'checked' : '' }}><i></i> <span>สำนักงานใหญ่ (Head Office)</span> </label>
                                                            </div>
                                                        </div>
                                                    </div><!--row-->
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">VAT Code</label>
                                                    <select class="custom-select select2-input" name="vat_code" id="vat_code" style="width: 100%;">
                                                        <option value=""></option>
                                                        @foreach ($vatcode as $item_vatcode)
                                                            <option value="{{ $item_vatcode->tax_rate_code }}" {{ $item_vatcode->tax_rate_code == $customer->vat_code? 'Selected':'' }}>{{ $item_vatcode->tax_rate_code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">วิธีการชำระเงิน (Payment Method)</label>
                                                    <select class="custom-select select2-input" name="payment_method_id" id="payment_method_id" onchange="$('#payment_method').val($('#payment_method_id option:selected').text());">
                                                        <option value=""></option>
                                                        @foreach ($paymethod as $item_paymethod)
                                                            <option value="{{ $item_paymethod->lookup_code }}" {{ $item_paymethod->lookup_code == $customer->payment_method_id? 'Selected':'' }}>{{ $item_paymethod->description }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" id="payment_method" name="payment_method" value="{{ !empty($customer->payment_method)? $customer->payment_method : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">เงื่อนไขการชำระเงิน (Payment Terms)</label>
                                                    <div class="row space-5">
                                                        <div class="col-4">
                                                            <select name="payment_terms_id" id="payment_terms_id" style="width: 100%;" class="custom-select select2-input" onchange="$('#payment_terms').val($('#payment_terms_id option:selected').data('value'));
                                                                                                                                                                                    $('#payment_terms_name').val($('#payment_terms_id option:selected').data('value'));
                                                                                                                                                                                    changePaymentTerms();">
                                                                <option value=""></option>
                                                                @foreach ($payterms as $item_payterms)
                                                                    <option value="{{ $item_payterms->term_id }}" data-value="{{ $item_payterms->description }}" data-term="{{ $item_payterms->shipment_condition }}" {{ $item_payterms->term_id == $customer->payment_term_id? 'Selected':'' }} >{{ $item_payterms->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" id="payment_terms_name" name="payment_terms_name" value="{{ !empty($payterms_list[$customer->payment_term_id])? $payterms_list[$customer->payment_term_id]['name'] : '' }}">
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="text" class="form-control" disabled id="payment_terms" value="{{ !empty($payterms_list[$customer->payment_term_id])? $payterms_list[$customer->payment_term_id]['name'] : '' }}">
                                                        </div>
                                                    </div><!--row-->
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">เงื่อนไขการขนส่ง</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" autocomplete="none" name="shipment_condition" id="shipment_condition" value="{{ !empty($customer->shipment_condition)? $customer->shipment_condition : '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">Shipment by</label>
                                                    <select name="shipment_by_id" id="shipment_by_id" class="custom-select select2-input" style="width: 100%;" onchange="$('#shipment_by').val($('#shipment_by_id option:selected').data('value'));">
                                                        <option value=""></option>
                                                        @foreach ($shipment as $item_shipment)
                                                            <option value="{{ $item_shipment->lookup_code }}" data-value="{{ $item_shipment->meaning }}" {{ $item_shipment->lookup_code == $customer->shipment_by_id? 'Selected':'' }}>{{ $item_shipment->meaning }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="shipment_by" id="shipment_by" value="{{ !empty($customer->shipment_by)? $customer->shipment_by : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">สูตรการคำนวณกำไรขาดทุน</label>
                                                    <select name="formula_id" id="formula_id" class="custom-select select2-input" style="width: 100%;" onchange="$('#formula_name').val($('#formula_id option:selected').data('value'));">
                                                        <option value=""></option>
                                                        @foreach ($formula as $item_formula)
                                                            <option value="{{ $item_formula->lookup_code }}" data-value="{{ $item_formula->meaning }}" {{ $item_formula->lookup_code == $customer->formula_id? 'Selected':'' }}>{{ $item_formula->meaning }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="formula_name" id="formula_name" value="{{ !empty($customer->formula)? $customer->formula : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">Order Type</label>
                                                    <div class="input-icon">
                                                        <select  class="custom-select select2-input" name="order_type_id" id="order_type_id" style="width: 100%;" onchange="$('#order_type').val($('#order_type_id option:selected').data('value'));">
                                                            <option value=""></option>
                                                            @foreach ($ordertyper as $item_ordertyper)
                                                                <option value="{{ $item_ordertyper->order_type_id }}" data-value="{{ $item_ordertyper->order_type_name }}" {{ $item_ordertyper->order_type_id == $customer->order_type_id? 'Selected':'' }}>{{ $item_ordertyper->order_type_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="order_type" id="order_type" value="{{ !empty($customer->order_type)? $customer->order_type : '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">{{ $incoterms_label->attribute1 }}</label>
                                                    <select name="incoterms_code" id="incoterms_code" class="custom-select select2-input" style="width: 100%;">
                                                        <option value=""></option>
                                                        @foreach ($incoterms as $item_incoterms)
                                                            <option value="{{ $item_incoterms->lookup_code }}" {{ $item_incoterms->lookup_code == $customer->incoterms_code? 'Selected':'' }}>{{ $item_incoterms->meaning }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">Price List</label>
                                                    <select name="price_list" id="price_list" class="custom-select select2-input"  style="width: 100%;" onchange="$('#price_list_name').val($('#price_list option:selected').data('value'));">
                                                        <option value=""></option>
                                                        @foreach ($pricelist as $item_pricelist)
                                                            <option value="{{ $item_pricelist->list_header_id }}" data-value="{{ $item_pricelist->name }}" {{ $item_pricelist->list_header_id == $customer->price_list_id? 'Selected':'' }}>{{ $item_pricelist->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="price_list_name" id="price_list_name" value="{{ !empty($customer->price_list)? $customer->price_list : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">ประเภทการจ่ายเงิน</label>
                                                    <select name="payment_type_id" id="payment_type_id" class="custom-select select2-input" style="width: 100%;" onchange="$('#payment_type').val($('#payment_type_id option:selected').data('value'));">
                                                        <option value=""></option>
                                                        @foreach ($paymenttype as $item_paymenttype)
                                                            <option value="{{ $item_paymenttype->lookup_code }}" data-value="{{ $item_paymenttype->meaning }}"  {{ $item_paymenttype->lookup_code == $customer->payment_type_id? 'Selected':'' }}>{{ $item_paymenttype->meaning }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="payment_type" id="payment_type" value="{{ !empty($customer->payment_type)? $customer->payment_type : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">สั่งซื้อทาง</label>
                                                    <select name="sales_channel_id" id="sales_channel_id" class="custom-select select2-input" style="width: 100%;" onchange="$('#sales_channel').val($('#sales_channel_id option:selected').data('value'));">
                                                        <option value=""></option>
                                                        @foreach ($salechannel as $item_salechannel)
                                                            <option value="{{ $item_salechannel->lookup_code }}" data-value="{{ $item_salechannel->meaning }}" {{ $item_salechannel->lookup_code == $customer->sales_channel_id? 'Selected':'' }}>{{ $item_salechannel->meaning }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="sales_channel" id="sales_channel" value="{{ !empty($customer->sales_channel)? $customer->sales_channel : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block">Status</label>
                                                    <select class="custom-select select2-input" id="status" name="status" style="width: 100%;">
                                                        @if($customer->status == 'Draft')
                                                            <option value="Draft" {{ $customer->status == 'Draft'? 'selected' : '' }}>Draft</option>
                                                        @endif
                                                        <option value="Active" {{ $customer->status == 'Active'? 'selected' : '' }}>Active</option>
                                                        <option value="Inactive" {{ $customer->status == 'Inactive'? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div><!--row-->
                                    </div><!--col-md-6-->
                                </div><!--row-->
                            </form>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <div class="row space-50 justify-content-md-center mt-4"><!--justify-content-md-center-->
                                <div class="col-xl-12 mb-md-4">

                                    <div class="form-header-buttons">
                                        <h3 class="black">ข้อมูลผู้ติดต่อ</h3>
                                        <div class="buttons">
                                            <button class="btn btn-lg btn-default w-160" onclick="btnClearFormContact();$('#form_contact').hide();" type="button"><i class="fa fa-repeat"></i><small>เคลียร์</small></button>
                                            <button class="btn btn-lg btn-success w-160" onclick="$('#form_contact').show();contact_show = true;" type="button">สร้าง<small></small></button>
                                            <button class="btn btn-lg btn-primary w-160" onclick="SaveCustomerContact();" type="button">บันทึก<small></small></button>
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th style="width: 120px">ลำดับผู้ติดต่อ</th>
                                                    <th>ชื่อผู้ติดต่อ</th>
                                                    <th>ตำแหน่ง</th>
                                                    <th>หมายเลขโทรศัพท์</th>
                                                    <th>สถานะ</th>
                                                    <th>รายละเอียด</th>
                                                    <th>ลบ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="contact_list">
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div><!--table-responsive-md-->

                                    <hr class="lg">
                                    <div class="alert alert-warning alert-dismissible print-error-msg-contact" id="close-btn-contact" style="display: none;">
                                        <button type="button" class="close" onclick="$('#close-btn-contact').hide();">&times;</button>
                                        <h5> Warning!</h5>
                                        <ul></ul>
                                    </div>
                                </div>
                                <div class="col-xl-5" id="form_contact" style="display: none;">
                                    <form id="contact_form" autocomplete="off" enctype="multipart/form-data">
                                        <input type="hidden" id="contact_id" value="">
                                        <div class="row space-5 ">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้า (Customer Number)</label>
                                                    <input type="text" class="form-control" disabled value="{{ !empty($customer->customer_number)? $customer->customer_number : '' }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อลูกค้า (Customer Name)</label>
                                                    <input type="text" class="form-control" disabled value="{{ !empty($customer->customer_name)? $customer->customer_name : '' }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ลำดับผู้ติดต่อ <span style="color: red;" >*</span> </label>
                                                    <input type="number" class="form-control" autocomplete="none" name="contact_number" id="contact_number" value="">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">คำนำหน้า (Title)</label>
                                                    <select name="contact_prefix" id="contact_prefix" class="custom-select select2-input" style="width: 100%;">
                                                        <option value=""></option>
                                                        @foreach ($customertitle as $item_title)
                                                            <option value="{{ $item_title->title }}">{{ $item_title->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อผู้ติดต่อ (Contact First  Name) <span style="color: red;" >*</span> </label>
                                                    <input type="text" class="form-control" autocomplete="none" name="contact_first_name" id="contact_first_name" value="">
                                                </div><!--form-group-->
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">นามสกุลผู้ติดต่อ (Contact Last Name) </label>
                                                    <input type="text" class="form-control" autocomplete="none" name="contact_last_name" id="contact_last_name" value="">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">อีเมล (Contact E-mail)</label>
                                                    <input type="email" class="form-control" autocomplete="none" name="contact_email" id="contact_email" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ตำแหน่ง (Position)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="contact_position" id="contact_position" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">หมายเลขโทรศัพท์ (Contact Phone Number)</label>
                                                    <div class="row">
                                                        <input type="text" class="form-control col-sm-8" autocomplete="none" name="contact_phone" id="contact_phone" value="">
                                                        <span class="col-md-1 text-center">ต่อ</span>
                                                        <input type="text" class="form-control col-sm-3" autocomplete="none" name="contact_attribute1" id="contact_attribute1" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">เบอร์แฟกซ์ (Fax Number) </label>
                                                    <input type="text" class="form-control" autocomplete="none" name="contact_fax" id="contact_fax" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="none" name="contact_note" id="contact_note"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">Status <span style="color: red;" >*</span></label>
                                                    <select class="custom-select select2-input" name="contact_status" id="contact_status" style="width: 100%;">
                                                        <option value="Active" >Active</option>
                                                        <option value="Inactive" >Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </form>
                                </div><!--col-md-6-->

                            </div><!--row-->
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            <div class="row space-50 justify-content-md-center mt-4"><!--justify-content-md-center-->
                                <div class="col-xl-12 mb-md-4">

                                    <div class="form-header-buttons">
                                        <h3 class="black">สถานที่จัดส่งสินค้า</h3>
                                        <div class="buttons">
                                            <button class="btn btn-lg btn-default w-160" onclick="btnClearFormShipping();$('#form_shipping').hide();" type="button"><i class="fa fa-repeat"></i><small>เคลียร์</small></button>
                                            <button class="btn btn-lg btn-success w-160" onclick="$('#form_shipping').show();ship_show = true;" type="button">สร้าง<small></small></button>
                                            <button class="btn btn-lg btn-primary w-160" onclick="SaveCustomerShipping();" type="button">บันทึก<small></small></button>
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th style="width: 120px">ลำดับสถานที่ส่ง</th>
                                                    <th>ชื่อสถานที่ส่ง</th>
                                                    <th>ประเทศ</th>
                                                    <th>สถานะ</th>
                                                    <th>รายละเอียด</th>
                                                    <th>สถานที่จัดส่งหลัก</th>
                                                </tr>
                                            </thead>
                                            <tbody id="shipping_list">
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div><!--table-responsive-md-->

                                    <hr class="lg">
                                    <div class="alert alert-warning alert-dismissible print-error-msg-shipping" id="close-btn-shipping" style="display: none;">
                                        <button type="button" class="close" onclick="$('#close-btn-shipping').hide();">&times;</button>
                                        <h5> Warning!</h5>
                                        <ul></ul>
                                    </div>
                                </div>
                                <div class="col-xl-5" id="form_shipping" style="display: none;">
                                    <form id="shipping_form" autocomplete="off" enctype="multipart/form-data">
                                        <input type="hidden" id="shipping_id" value="">
                                        <div class="row space-5 ">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสลูกค้า (Customer Number)</label>
                                                    <input type="text" class="form-control" disabled value="{{ !empty($customer->customer_number)? $customer->customer_number : '' }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อลูกค้า (Customer Name)</label>
                                                    <input type="text" class="form-control" disabled value="{{ !empty($customer->customer_name)? $customer->customer_name : '' }}">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ลำดับสถานที่ส่ง <span style="color: red;" >*</span></label>
                                                    <input type="number" class="form-control" autocomplete="none" name="shipping_number" id="shipping_number" value="">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อสถานที่ส่ง <span style="color: red;" >*</span></label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_place_name" id="shipping_place_name" value="">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ชื่อผู้ติดต่อ</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_contact_name" id="shipping_contact_name" value="">
                                                </div><!--form-group-->
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ตำแหน่ง</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_position" id="shipping_position" value="">
                                                </div><!--form-group-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ประเทศ (Country) <span style="color: red;" >*</span></label>
                                                    <select name="shipping_country" id="shipping_country" style="width: 100%;" class="custom-select select2-input" onchange="$('#shipping_country_name').val($('#shipping_country option:selected').data('value'));thaiOrNot(this.value,'ship');">
                                                        <option value=""></option>
                                                        @foreach ($list_country as $item_country)
                                                            <option value="{{ $item_country['id'] }}" data-value="{{ $item_country['geography_name'] }}">{{ $item_country['geography_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" class="form-control" id="shipping_country_name" name="shipping_country_name"  value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ บรรทัดที่ 1 (Address Line 1) <span style="color: red;" >*</span></label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_addr_line_1" id="shipping_addr_line_1" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ บรรทัดที่ 2 (Address Line 2)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_addr_line_2" id="shipping_addr_line_2" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">ที่อยู่ บรรทัดที่ 3 (Address Line 3)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_addr_line_3" id="shipping_addr_line_3" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6 notthai_ship">
                                                <div class="form-group">
                                                    <label class="d-block">รัฐ (State)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_state" id="shipping_state" value="">
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-6 notthai_ship">
                                                <div class="form-group">
                                                    <label class="d-block">จังหวัด (Province)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_province" id="shipping_province" value="">
                                                </div>
                                            </div> --}}

                                            <div class="col-md-6 notthai_ship">
                                                <div class="form-group">
                                                    <label class="d-block">เขต/อำเภอ/เมือง (City)</label>
                                                    <input type="text" class="form-control" autocomplete="none" name="shipping_city" id="shipping_city" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6 notthai_ship">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสไปรษณีย์ (Postal Code)</label>
                                                    <input type="number" min="0" class="form-control" autocomplete="none" name="shipping_postal" id="shipping_postal" value="">
                                                </div>
                                            </div>
                                            {{-- ------------------------------------------------------------------------------------------------------ --}}
                                            <div class="col-md-6 thai_ship" style="display: none;">
                                                <div class="form-group">
                                                    <label class="d-block">จังหวัด (Province)</label>
                                                    <select name="shipping_province_th"
                                                            style="width: 100%;"
                                                            id="shipping_province_th"
                                                            class="custom-select select2-input"
                                                            onchange="  $('#shipping_province_name').val($('#shipping_province_th option:selected').data('value'));
                                                                        $('#shipping_province_region').val($('#shipping_province_th option:selected').data('region'));
                                                                        $('#shipping_province_region_name').val($('#shipping_province_th option:selected').data('rname'));
                                                                        selectProvince(this.value,'ship');">
                                                        <option value=""></option>
                                                    </select>
                                                    <input type="hidden" class="form-control" id="shipping_province_name" name="shipping_province_name"  value="">
                                                    <input type="hidden" class="form-control" id="shipping_province_region" name="shipping_province_region"  value="">
                                                    <input type="hidden" class="form-control" id="shipping_province_region_name" name="shipping_province_region_name"  value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6 thai_ship" style="display: none;">
                                                <div class="form-group">
                                                    <label class="d-block">เขต/อำเภอ/เมือง (City)</label>
                                                    {{-- <input type="text" class="form-control" name="shipping_city" id="shipping_city_th" value=""> --}}
                                                    <select name="shipping_city_code"
                                                            style="width: 100%;"
                                                            id="shipping_city_th"
                                                            class="custom-select select2-input"
                                                            onchange="  $('#shipping_city_name').val($('#shipping_city_th option:selected').data('name'));
                                                                        selectDistrict(this.value,'ship');">
                                                        <option value=""></option>
                                                    </select>
                                                    <input type="hidden" class="form-control" id="shipping_city_name" name="shipping_city_name"  value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6 thai_ship" style="display: none;">
                                                <div class="form-group">
                                                    <label class="d-block">ตำบล (Sub District)</label>
                                                    {{-- <input type="text" class="form-control" name="shipping_district" id="shipping_district_th" value=""> --}}
                                                    <select name="shipping_district_code"
                                                            style="width: 100%;"
                                                            id="shipping_district_th"
                                                            class="custom-select select2-input"
                                                            onchange="  $('#shipping_district_name').val($('#shipping_district_th option:selected').data('name'));
                                                                        selectPostcode(this.value,'ship');">
                                                        <option value=""></option>
                                                    </select>
                                                    <input type="hidden" class="form-control" id="shipping_district_name" name="shipping_district_name"  value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6 thai_ship" style="display: none;">
                                                <div class="form-group">
                                                    <label class="d-block">รหัสไปรษณีย์ (Postal Code)</label>
                                                    {{-- <input type="text" class="form-control" name="shipping_postal" id="shipping_postal_th" value=""> --}}
                                                    <select name="shipping_postal_th"  style="width: 100%;" id="shipping_postal_th" class="custom-select select2-input" >
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">Status <span style="color: red;" >*</span></label>
                                                    <select class="custom-select select2-input" name="shipping_status" id="shipping_status" style="width: 100%;">
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive" >Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="d-block">&nbsp;</label>
                                                    <label><input type="checkbox" value="Y" name="shipping_main_addr" id="shipping_main_addr"><span class="nowrap" style="padding-left: 10px;">สถานที่จัดส่งหลัก</span></label>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div id="confirm_modal" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">No Contact Data Active Or Email</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>ลูกค้าไม่มีรายชื่อผู้ติดต่อที่ Active อยู่ ระบบจะทำการส่ง username password ไปทาง admin ตาม Email ที่ระบุ</p>
                                <input type="email" class="form-control" placeholder="Admin Email" name="email_admin" id="email_admin">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="checkConfirmCustomerDate();" >Confirm</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
    <script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
    <script>
         $('.select2-input').select2();
        var customercontact     = [];
        var customershipping    = [];
        var customer_id         = '{{ $customer->customer_id }}';
        var list_country        = [];
        var zipcode             = [];
        var country             = '{{ !empty($customer->country_code)? $customer->country_code : "" }}';
        var province_code       = '{{ !empty($customer->province_code)? $customer->province_code : "" }}';
        var citi_code           = '{{ !empty($customer->city_code)? $customer->city_code : "" }}';
        var district_code       = '{{ !empty($customer->district_code)? $customer->district_code : "" }}';
        var postal_code         = '{{ !empty($customer->postal_code)? $customer->postal_code : "" }}';
        var contact_show        = false;
        var ship_show           = false;

        getTerritiryList();
        // getCustomerContactList();
        // getCustomerShippingList();
        thaiOrNot(country,'customer');

        function getCustomerContactList()
        {
            loading();
            $.ajax({
                url : '{{ url("om/ajax/customers/exports/customercontact_list") }}/'+customer_id,
                success : function(res){
                    swal.close();
                    customercontact = res.data;

                    var html = '';
                    $.each(customercontact,function(key,val){
                        html += '<tr>';
                        html +=     '<td>'+val.number+'</td>';
                        html +=     '<td>'+val.prefix+' '+val.first_name+' '+val.last_name+'</td>';
                        html +=     '<td>'+val.position+'</td>';
                        html +=     '<td>'+val.phone+'</td>';
                        html +=     '<td>'+val.status+'</td>';
                        html +=     '<td><a onclick="showDetailContact('+"'"+val.id+"'"+');$('+"'#form_contact'"+').show();" ><i class="fa fa-file-text-o" aria-hidden="true"></i></a></td>';
                        html +=     '<td><a class="fa fa-times red" onclick="deleteCustomerContact('+"'"+ val.id +"'"+')" ></a></td>';
                        html += '</tr>';
                    });

                    $("#contact_list").html(html);
                }
            });
        }

        function changePaymentTerms()
        {
            var Datavalue = $('#payment_terms_id option:selected').data('term')
            var val = $('#payment_terms_id').val()
            $('#shipment_condition').val(Datavalue);
            // if(val == '3002'){
            //     $('#shipment_condition').val('WITHIN 30 DAYS AFTER DATE PAYMENT RECIEVED');

            // }else if(val == '4003'){
            //     $('#shipment_condition').val('WITHIN 30 DAYS AFTER DATE PAYMENT RECIEVED');

            // }else if(val == '4006'){
            //     $('#shipment_condition').val('WITHIN 30 DAYS AFTER CONFIRMATION');

            // }else{
            //     $('#shipment_condition').val(Datavalue);
            // }
        }


        function getCustomerShippingList()
        {
            loading();
            $.ajax({
                url : '{{ url("om/ajax/customers/exports/customershipping_list") }}/'+customer_id,
                success:function(res){
                    swal.close();
                    customershipping = res.data;

                    var html = '';
                    $.each(customershipping,function(key,val){
                        html += '<tr>';
                        html +=    '<td>'+val.number+'</td>';
                        html +=    '<td>'+val.name+'</td>';
                        if(val.country == null){
                            html +=    '<td></td>';
                        }else{
                            html +=    '<td>'+val.country+'</td>';
                        }
                        html +=    '<td>'+val.status+'</td>';
                        html +=    '<td><a onclick="showDetailShipping('+"'"+val.number+"'"+');$('+"'#form_shipping'"+').show();" ><i class="fa fa-file-text-o" aria-hidden="true"></i></a></td>';
                        if(val.mainaddr == 'Y'){
                            html +=    '<td><input type="checkbox" checked disabled ></td>'
                        }else{
                            html +=    '<td><input type="checkbox" disabled></td>'
                        }
                        // html +=     '<td><a class="fa fa-times red" onclick="deleteCustomerShipping('+"'"+ val.id +"'"+')" ></a></td>';
                        html += '</tr>';
                    });

                    $("#shipping_list").html(html);

                    if(customershipping == ''){
                        // thaiOrNot(country,'ship');
                        // $('#shipping_country').val(country);
                        $('#shipping_addr_line_1').val();
                        $('#shipping_addr_line_2').val();
                        $('#shipping_addr_line_3').val();
                        $('#shipping_state').val();
                        // $('#shipping_province_th').val(province_code);
                        $("#shipping_province_name").val();
                        // selectProvince(province_code,'ship');
                        // selectDistrict(citi_code,'ship');
                        // selectPostcode(district_code,'ship');

                        $('#shipping_city_th').val();
                        $('#shipping_district_th').val();
                        $('#shipping_postal_th').val();

                    }
                }
            });
        }

        function getTerritiryList()
        {
            $.ajax({
                url : '{{ url("om/ajax/customers/exports/province") }}',
                success:function(res){
                    var data = res.data;
                    var html  = '<option value=""></option>';
                    var html2  = '<option value=""></option>';
                    $.each(data,function(key,val){
                        if(province_code == val.id){
                            html  += '<option value="'+val.id+'" data-value="'+val.name_en+'" data-region="'+val.region+'" data-rname="'+val.rg_name+'" selected>'+val.name_en+'</option>';
                        }else{
                            html  += '<option value="'+val.id+'" data-value="'+val.name_en+'" data-region="'+val.region+'" data-rname="'+val.rg_name+'">'+val.name_en+'</option>';
                        }
                        html2 += '<option value="'+val.id+'" data-value="'+val.name_en+'" data-region="'+val.region+'" data-rname="'+val.rg_name+'">'+val.name_en+'</option>';
                    });
                    $("#province_code_th").html(html);
                    $("#shipping_province_th").html(html2);

                    if(province_code != ''){
                        selectProvince(province_code,'customer');
                    }
                }
            });
        }

        function thaiOrNot(county,type)
        {
            if(type == 'customer'){
                if(county == 'TH'){
                    $(".notthai").hide();
                    $(".thai").show();
                }else{
                    $(".thai").hide();
                    $(".notthai").show();
                }
            }else{
                if(county == 'TH'){
                    $(".notthai_ship").hide();
                    $(".thai_ship").show();
                }else{
                    $(".thai_ship").hide();
                    $(".notthai_ship").show();
                }
            }

        }

        function selectProvince(province,type)
        {
            if(type == 'customer'){
                $("#city_code_th").val('');
                $("#district_code_th").val('');
                $("#postal_code_th").val('');
            }else{
                $("#shipping_city_th").val('');
                $("#shipping_district_th").val('');
                $("#shipping_postal_th").val('');
            }
            $.ajax({
                url : '{{ url("om/ajax/customers/exports/district?id=") }}'+province,
                success:function(res){
                    var data = res.data;
                    var html  = '<option value=""></option>';
                    $.each(data,function(key,val){
                        if(val.id == citi_code){
                            html  += '<option value="'+val.id+'" data-name="'+val.name_en+'" selected>'+val.name_en+'</option>'
                        }else{
                            html  += '<option value="'+val.id+'" data-name="'+val.name_en+'">'+val.name_en+'</option>'
                        }
                    });
                    if(type == 'customer'){
                        $("#city_code_th").html(html);
                    }else{
                        $("#shipping_city_th").html(html);
                    }

                    selectDistrict(citi_code,'customer');

                }
            });
        }

        function selectDistrict(district,type)
        {
            if(type == 'customer'){
                $("#district_code_th").val('');
                $("#postal_code_th").val('');
                var district_html = $("#city_code_th option").filter(function(){
                    return this.value == district;
                }).data('name');
                $("#city_name_th").val(district_html);
            }else{
                $("#shipping_district_th").val('');
                $("#shipping_postal_th").val('');
            }
            $.ajax({
                url : '{{ url("om/ajax/customers/exports/tambon?id=") }}'+district,
                success:function(res){
                    var data = res.data;
                    var html  = '<option value=""></option>';
                    $.each(data.tumbon,function(key,val){
                        if(val.id == district_code){
                            html  += '<option value="'+val.id+'" data-name="'+val.name_en+'"selected>'+val.name_en+'</option>'
                        }else{
                            html  += '<option value="'+val.id+'" data-name="'+val.name_en+'">'+val.name_en+'</option>'
                        }
                    });
                    if(type == 'customer'){
                        $("#district_code_th").html(html);
                    }else{
                        $("#shipping_district_th").html(html);
                    }
                    zipcode = data.postcode;
                    selectPostcode(district_code,'customer');
                }
            });
        }

        function selectPostcode(tumbon,type)
        {
            if(type == 'customer'){
                $("#postal_code_th").val('');
                var tumbon_html = $("#district_code_th option").filter(function(){
                    return this.value == tumbon;
                }).data('name');
                $("#district_name_th").val(tumbon_html);
            }else{
                $("#shipping_postal_th").val('');
            }

            var html  = '<option value=""></option>';
            if(tumbon != ''){
                $.each(zipcode[tumbon],function(key,val){
                    if(val == postal_code){
                        html  += '<option value="'+val+'" selected>'+val+'</option>'
                    }else{
                        if(zipcode[tumbon].length == 1){
                            html  += '<option value="'+val+'" selected>'+val+'</option>'
                        }else{
                            html  += '<option value="'+val+'">'+val+'</option>'
                        }
                    }

                });
            }
            if(type == 'customer'){
                $("#postal_code_th").html(html);
            }else{
                $("#shipping_postal_th").html(html);
            }
        }

        function getTerritiryListShip(value)
        {
            $.ajax({
                url : '{{ url("om/ajax/customers/exports/province") }}',
                success:function(res){
                    var data = res.data;
                    var html  = '<option value=""></option>';
                    $.each(data,function(key,val){
                        if(value == val.id){
                            html  += '<option value="'+val.id+'" data-value="'+val.name_en+'" data-region="'+val.region+'" data-rname="'+val.rg_name+'" selected>'+val.name_en+'</option>';
                            $("#shipping_province_name").val(val.name_en);
                            $("#shipping_province_region").val(val.region);
                            $("#shipping_province_region_name").val(val.rg_name);
                        }else{
                            html  += '<option value="'+val.id+'" data-value="'+val.name_en+'" data-region="'+val.region+'" data-rname="'+val.rg_name+'">'+val.name_en+'</option>';
                        }
                    });
                    $("#shipping_province_th").html(html);
                }
            });
        }

        function selectProvinceShip(province,value)
        {
            $("#shipping_city_th").val('');
            $("#shipping_district_th").val('');
            $("#shipping_postal_th").val('');
            $.ajax({
                url : '{{ url("om/ajax/customers/exports/district?id=") }}'+province,
                success:function(res){
                    var data = res.data;
                    var html  = '<option value=""></option>';
                    $.each(data,function(key,val){
                        if(val.id == value){
                            html  += '<option value="'+val.id+'" data-name="'+val.name_en+'" selected>'+val.name_en+'</option>'
                            $("#shipping_city_name").val(val.name_en);
                        }else{
                            html  += '<option value="'+val.id+'" data-name="'+val.name_en+'">'+val.name_en+'</option>'
                        }
                    });
                    $("#shipping_city_th").html(html);
                }
            });
        }

        function selectDistrictShip(district,value,zip)
        {
            $("#shipping_district_th").val('');
            $("#shipping_postal_th").val('');
            $.ajax({
                url : '{{ url("om/ajax/customers/exports/tambon?id=") }}'+district,
                success:function(res){
                    var data = res.data;
                    var html  = '<option value=""></option>';
                    $.each(data.tumbon,function(key,val){
                        if(val.id == value){
                            html  += '<option value="'+val.id+'" data-name="'+val.name_en+'" selected>'+val.name_en+'</option>'
                            $("#shipping_district_name").val(val.name_en);
                        }else{
                            html  += '<option value="'+val.id+'" data-name="'+val.name_en+'">'+val.name_en+'</option>'
                        }
                    });
                    $("#shipping_district_th").html(html);
                    zipcode = data.postcode;
                    selectPostcodeShip(value,zip);
                }
            });
        }

        function selectPostcodeShip(tumbon,value)
        {
            $("#shipping_postal_th").val('');

            var html  = '<option value=""></option>';
            if(tumbon != ''){
                $.each(zipcode[tumbon],function(key,val){
                    if(val == value){
                        html  += '<option value="'+val+'" selected>'+val+'</option>'
                    }else{
                        if(zipcode[tumbon].length == 1){
                            html  += '<option value="'+val+'" selected>'+val+'</option>'
                        }else{
                            html  += '<option value="'+val+'">'+val+'</option>'
                        }
                    }

                });
            }
            $("#shipping_postal_th").html(html);
        }

        function showDetailContact(id)
        {
            var contact = customercontact[id];
            contact_show = true;

            $("#contact_id").val(contact.id);
            $("#contact_number").val(contact.number);
            $("#contact_prefix").val(contact.prefix);
            $("#contact_prefix").trigger('change');
            $("#contact_first_name").val(contact.first_name);
            $("#contact_last_name").val(contact.last_name);
            $("#contact_email").val(contact.email);
            $("#contact_position").val(contact.position);
            $("#contact_phone").val(contact.phone);
            $("#contact_attribute1").val(contact.attribute1);
            $("#contact_fax").val(contact.fax);
            $("#contact_note").val(contact.note);
            $("#contact_status").val(contact.status);
            $("#contact_status").trigger('change');
        }

        function btnClearFormContact()
        {
            $("#contact_id").val('');
            $("#contact_form")[0].reset();

            contact_show = false;
        }

        function showDetailShipping(id)
        {
            var shipping = customershipping[id];
            ship_show = true;

            thaiOrNot(shipping.country_code,'ship');
            $("#shipping_id").val(shipping.id);
            $('#shipping_number').val(shipping.number);
            $('#shipping_place_name').val(shipping.name);
            $('#shipping_contact_name').val(shipping.name_contact);
            $('#shipping_position').val(shipping.position);
            $('#shipping_country').val(shipping.country_code);
            $('#shipping_country_name').val(shipping.country_name);
            $('#shipping_addr_line_1').val(shipping.address_1);
            $('#shipping_addr_line_2').val(shipping.address_2);
            $('#shipping_addr_line_3').val(shipping.address_3);
            $('#shipping_city').val(shipping.city);
            $('#shipping_state').val(shipping.state);
            $('#shipping_province').val(shipping.province);
            $('#shipping_postal').val(shipping.postal_code);
            $('#shipping_status').val(shipping.status);
            if(shipping.mainaddr == 'Y'){
                $("#shipping_main_addr").prop('checked',true);
            }else{
                $("#shipping_main_addr").prop('checked',false);
            }

            $('#shipping_country').val(shipping.country_code).trigger('change.select2');
            $('#shipping_country').trigger('change');
            $("#shipping_province_name").val(shipping.province_name);
            // $('#shipping_province_th').val(shipping.province);

            getTerritiryListShip(shipping.province);
            selectProvinceShip(shipping.province,shipping.city_code);

            selectDistrictShip(shipping.city_code,shipping.district_code,shipping.postal_code);
            // $('#shipping_city_th').val(shipping.city_code);
            // selectPostcodeShip(shipping.district_code,shipping.postal_code);
            // $('#shipping_district_th').val(shipping.district_code);
            // $('#shipping_postal_th').val(shipping.postal_code);
        }

        function btnClearFormShipping()
        {
            ship_show = false;
            $("#shipping_form")[0].reset();
            $("#shipping_id").val('');
            $('#shipping_province_th').val('');
            $('#shipping_province_th').trigger('change');
            $('#shipping_city_th').val('');
            $('#shipping_district_th').val('');
            $('#shipping_postal_th').val('');
            $('#shipping_country').val('');
            $('#shipping_country').trigger('change');
            $('#shipping_country_name').val('');
            $("#shipping_city_th").html('');
            $('#shipping_city_th').trigger('change');
            $("#shipping_district_th").html('');
            $('#shipping_district_th').trigger('change');
            $("#shipping_postal_th").html('');
            $('#shipping_postal_th').trigger('change');
            $("#shipping_province_name").val('');
            $("#shipping_province_region").val('');
            $("#shipping_province_region_name").val('');
            $("#shipping_city_name").val('');
            $("#shipping_district_name").val('');
            thaiOrNot('','ship')
        }

        function checkContact()
        {
            var status          =  $("#status").val();
            var current_status  =  '{{ $customer->status }}';

            if(status == 'Active' && current_status == 'Draft'){
                $.ajax({
                    url     : '{{ url("om/ajax/customers/exports/check_contact") }}/'+customer_id,
                    type    : 'post',
                    data    : {
                        '_token'    : '{{ csrf_token() }}'
                    },
                    success :function(rest){
                        var data = rest.data;
                        if(data.status){
                            updateCustomerData();
                        }else{
                            $("#confirm_modal").modal();
                        }
                    }
                });
            }else{
                updateCustomerData();
            }

        }

        function checkConfirmCustomerDate()
        {
            var email =  $("#email_admin").val();
            if(email == ''){
                AlertToast('แจ้งเตือน','กรุณากรอกอีเมล เพื่อส่งให้ admin','error');
                return false;
            }else{
                updateCustomerData();
            }
        }

        // function confirmCustomerDate()
        // {
        //     loading();
        //     var email =  $("#email_admin").val();
        //     $.ajax({
        //         url     : '{{ url("om/ajax/customers/exports/confirmcustomer") }}/'+customer_id,
        //         type    : 'post',
        //         data    : {
        //             '_token'    : '{{ csrf_token() }}',
        //             email       : email
        //         },
        //         success:function(res){
        //             swal.close();
        //             var data = res.data;
        //             $("#confirm_modal").modal('hide');
        //             if(data.status){
        //                 AlertToast('สำเร็จ','Confirm Complete','success');
        //                 Swal.fire({
        //                     title: '<small class="text-left">สร้าง Username และ password สำหรับลูกค้า '+data.code+' เรียบร้อยแล้ว <br><br> Username: '+data.code+' <br><br> หมายเหตุ : หากลูกค้าระบุอีเมล์จะได้รับข้อความนี้อัตโนมัติ </small>',
        //                     confirmButtonText: `ตกลง`,
        //                     allowOutsideClick: false,
        //                 }).then((result) => {
        //                     if (result.isConfirmed) {
        //                         location.reload();
        //                     }
        //                 })
        //             }else{
        //                 AlertToast('แจ้งเตือน','บางอย่างผิดพลาดโปรลองอีกครั้ง','error');
        //             }
        //         }
        //     });
        // }

        function updateCustomerData()
        {
            loading();
            var email           =  $("#email_admin").val();
            var status          =  $("#status").val();
            var current_status  =  '{{ $customer->status }}';

            const formdata = new FormData(document.getElementById("customer_form"));
            formdata.append('_token','{{ csrf_token() }}');
            formdata.append('email',email);
            formdata.append('current_status',current_status);

            $.ajax({
                url     : '{{ url("om/ajax/customers/exports/updateCustomer") }}/'+customer_id,
                type    : 'post',
                data    : formdata,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    swal.close();
                    var data = res.data;
                    if(data.status){
                        if(status == 'Active' && current_status == 'Draft'){
                            $("#confirm_modal").modal('hide');
                            AlertToast('สำเร็จ','Confirm Complete','success');
                            Swal.fire({
                                title: '<small class="text-left">สร้าง Username และ password สำหรับลูกค้า '+data.code+' เรียบร้อยแล้ว <br><br> Username: '+data.code+' <br><br> หมายเหตุ : หากลูกค้าระบุอีเมล์จะได้รับข้อความนี้อัตโนมัติ </small>',
                                confirmButtonText: `ตกลง`,
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }else{
                            AlertToast('สำเร็จ','Save Complete','success');
                            $('#close-btn-customer').hide();
                            location.reload();
                        }
                    }else{
                        if(data.type == 'validate'){
                            printErrorMsgCustomer(data.data);
                        }else{
                            AlertToast('แจ้งเตือน','บางอย่างผิดพลาดโปรลองอีกครั้ง','error');
                        }
                    }
                }
            });
        }

        function SaveCustomerContact()
        {
            var id = $("#contact_id").val();
            if(!contact_show){
                return false;
            }
            if(id == ''){
                insertCustomerContact();
            }else{
                updateCustomerContact();
            }
        }

        function insertCustomerContact()
        {
            loading();
            const formdata = new FormData(document.getElementById("contact_form"));
            formdata.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/customers/exports/insertcustomercontact") }}/'+customer_id,
                type        : 'post',
                data        : formdata,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    swal.close();
                    var data = res.data;
                    if(res.status){
                        getCustomerContactList();
                        $("#contact_form")[0].reset();
                        btnClearFormContact();$('#form_contact').hide();
                        AlertToast('สำเร็จ','เพิ่มสำเร็จ','success');
                        $('#close-btn-contact').hide();
                    }else{
                        if(res.type == 'validate'){
                            printErrorMsgContact(data);
                        }else{
                            AlertToast('แจ้งเตือน','บางอย่างผิดพลาดโปรลองอีกครั้ง','error');
                        }
                    }
                }
            });
        }

        function updateCustomerContact()
        {
            loading();
            var id = $("#contact_id").val();

            const formdata = new FormData(document.getElementById("contact_form"));
            formdata.append('_token','{{ csrf_token() }}');
            formdata.append('customer_id',customer_id);

            $.ajax({
                url         : '{{ url("om/ajax/customers/exports/updatecustomercontact") }}/'+id,
                type        : 'post',
                data        : formdata,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    swal.close();
                    var data = res.data;
                    if(res.status){
                        getCustomerContactList();
                        $("#contact_id").val('');
                        $("#contact_form")[0].reset();
                        btnClearFormContact();$('#form_contact').hide();
                        AlertToast('สำเร็จ','เปลียนแปลงแล้ว','success');
                        $('#close-btn-contact').hide();
                    }else{
                        if(res.type == 'validate'){
                            printErrorMsgContact(data);
                        }else{
                            AlertToast('แจ้งเตือน','บางอย่างผิดพลาดโปรลองอีกครั้ง','error');
                        }
                    }
                }
            });
        }

        function deleteCustomerContact(id)
        {
            $.ajax({
                url         : '{{ url("om/ajax/customers/exports/delcustomercontact") }}/'+id,
                type        : 'post',
                data : {
                    '_token'    : '{{ csrf_token() }}'
                },
                success     : function(res){
                    if(res.status){
                        getCustomerContactList();
                        AlertToast('สำเร็จ','เปลียนแปลงแล้ว','success');
                    }else{
                        AlertToast('แจ้งเตือน','บางอย่างผิดพลาดโปรลองอีกครั้ง','error');
                    }
                }
            });
        }

        function SaveCustomerShipping()
        {
            var id = $("#shipping_id").val();
            if(!ship_show){
                return false;
            }
            if(id == ''){
                insertCustomerShipping();
            }else{
                updateCustomerShipping();
            }
        }

        function insertCustomerShipping()
        {
            loading();
            const formdata = new FormData(document.getElementById("shipping_form"));
            formdata.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/customers/exports/insertcustomershipping") }}/'+customer_id,
                type        : 'post',
                data        : formdata,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    swal.close();
                    var data = res.data;
                    if(res.status){
                        getCustomerShippingList();
                        $("#shipping_form")[0].reset();
                        btnClearFormShipping();$('#form_shipping').hide();
                        AlertToast('สำเร็จ','เพิ่มสำเร็จ','success');
                        $('#close-btn-shipping').hide();
                    }else{
                        if(res.type == 'validate'){
                            printErrorMsgShipping(data);
                        }else{
                            AlertToast('แจ้งเตือน','บางอย่างผิดพลาดโปรลองอีกครั้ง','error');
                        }
                    }
                }
            });
        }

        function updateCustomerShipping()
        {
            loading();
            var id = $("#shipping_id").val();
            const formdata = new FormData(document.getElementById("shipping_form"));
            formdata.append('_token','{{ csrf_token() }}');
            formdata.append('customer_id',customer_id);

            $.ajax({
                url         : '{{ url("om/ajax/customers/exports/updatecustomershipping") }}/'+id,
                type        : 'post',
                data        : formdata,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    swal.close();
                    var data = res.data;
                    if(res.status){
                        getCustomerShippingList();
                        $("#shipping_form")[0].reset();
                        btnClearFormShipping();$('#form_shipping').hide();
                        AlertToast('สำเร็จ','เปลียนแปลงแล้ว','success');
                        $('#close-btn-shipping').hide();
                    }else{
                        if(res.type == 'validate'){
                            printErrorMsgShipping(data);
                        }else{
                            AlertToast('แจ้งเตือน','บางอย่างผิดพลาดโปรลองอีกครั้ง','error');
                        }
                    }
                }
            });
        }

        function deleteCustomerShipping(id)
        {
            $.ajax({
                url         : '{{ url("om/ajax/customers/exports/delcustomershipping") }}/'+id,
                type        : 'post',
                data : {
                    '_token'    : '{{ csrf_token() }}'
                },
                success     : function(res){
                    if(res.status){
                        getCustomerShippingList();
                        AlertToast('สำเร็จ','เปลียนแปลงแล้ว','success');
                    }else{
                        AlertToast('แจ้งเตือน','บางอย่างผิดพลาดโปรลองอีกครั้ง','error');
                    }
                }
            });
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

        function printErrorMsgContact (msg) {
            $(".print-error-msg-contact").find("ul").html('');
            $(".print-error-msg-contact").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-contact").find("ul").append('<li>'+value+'</li>');
            });
        }

        function printErrorMsgShipping (msg) {
            $(".print-error-msg-shipping").find("ul").html('');
            $(".print-error-msg-shipping").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-shipping").find("ul").append('<li>'+value+'</li>');
            });
        }

        function printErrorMsgCustomer(msg){
            $(".print-error-msg-customer").find("ul").html('');
            $(".print-error-msg-customer").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-customer").find("ul").append('<li>'+value+'</li>');
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
