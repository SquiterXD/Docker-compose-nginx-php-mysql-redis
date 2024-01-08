@extends('layouts.app')

@section('title', 'บันทึกข้อมูลการชำระเงิน')

@section('custom_css')
<link rel="stylesheet" href="{!! asset('css/aksFileUpload.min.css') !!}" />
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

<style>
    div.dataTables_wrapper div.dataTables_length select {
        width: 75px !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered,
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;

    }

    .select2-dropdown,
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #e5e6e7 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow,
    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .swal2-container {
        z-index: 9999 !important;
    }

    .disabledInput {
        color: black !important;
    }
    #page-wrapper {
        width: calc(100% - 220px) !important;
    }

    .tb-matchpayment{
        overflow-y: auto;
        max-height: 575px;
    }

    .tb-matchpayment thead {
        top: 0;
        position: sticky;
        z-index: 999;
    }

</style>
@stop

@section('page-title')

<h2>
    <x-get-page-title menu="" url="/om/payment-method/form" />
</h2>
@stop
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="ibox">
        <div class="ibox-title">
            <h3>บันทึกข้อมูลการชำระเงิน สำหรับขายในประเทศ</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center">

                <div class="col-12">
                    <div class="form-header-buttons">
                        <div class="buttons multiple">
                            <button class="btn btn-md btn-white" 
                                    type="button" 
                                    onclick="resetpage();">
                                <i class="fa fa-refresh"></i> ล้างข้อมูล
                            </button>
                            <button class="btn btn-md btn-success" 
                                    type="button" 
                                    onclick="createFunc();" 
                                    id="createbtn" 
                                    @if(Request::old('callback_search')) @if($infodata->payment_status == 'Confirm'  || $infodata->payment_status == 'Cancel') disabled @endif @endif>
                                <i class="fa fa-plus"></i> สร้าง
                            </button>
                            <button class="btn btn-md btn-white" 
                                    type="button" 
                                    id="searchbtn">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                            <a  class="btn btn-md btn-warning"
                                type="button"
                                id="printbtn" @if(Request::old('callback_search')) href="{{ route('om.payment-method-print',['type' => 'print', 'id' => Request::old('payment_number')]) }}" 
                                target="_blank" @else href="" @endif>
                                <i class="fa fa-print" style="padding-top: 10px;"></i> พิมพ์ใบเสร็จรับเงิน
                            </a>
                            @if(@$infodata->payment_status == "Cancel" || @$infodata->payment_status == "Confirm")
                            <button  class="btn btn-md btn-success"
                                    type="button"
                                    id="savebtn" >
                                    <i class="fa fa-save" style="padding-top: 10px;"></i> บันทึก
                            </button>
                            @endif
                        </div>
                    </div>
                    <!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>
                </div>
                <!--col-12-->

                <div class="col-xl-12 m-auto">
                    <form method="get" autocomplete="off" id="searchnumber">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">เลขที่ใบเสร็จรับเงิน</label>
                                    <input autocomplete="off" type="text" class="form-control" name="payment_number" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('number_payment_invoice') }}" @else value="{{ Request::old('payment_number') }}" @endif @if(Request::old('callback_save') || Request::old('callback_search')) readonly @endif list="payment_number_ref">
                                    <datalist id="payment_number_ref">
                                        @foreach ($paymenynumberref as $ref)
                                        <option value="{{ $ref->payment_number }}">
                                            {{ FormatDate::DateThai($ref->payment_date) }}:{{ $ref->customer_name }} {{ $ref->attribute2? ' ('.$ref->attribute2.')': '' }}
                                        </option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">วันที่รับชำระ</label>
                                    <div class="input-icon">
                                        @if(Request::old('callback_search'))
                                            <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2" name="payment_date" id="input_date" not-after-date="{{ date('d') }}/{{ date('m') }}/{{ date('Y')+543 }}" placeholder="" format="{{ trans("date.js-format") }}" @if(Request::old('callback_save')) value="{{ Request::old('number_payment_date') }}" @else @if(Request::old('callback_search')) value="{{ FormatDate::DateThaiNumericWithSplash($infodata->payment_date) }}" @else value="" @endif @endif @if(Request::old('callback_save') || Request::old('callback_search')) readonly @endif>
                                        @else
                                            <div id="input_delivery_date"></div>
                                        @endif
                                    </div>
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">สถานะ</label>
                                    <input autocomplete="off" 
                                            type="text" 
                                            class="form-control disabledInput" 
                                            name="status" 
                                            placeholder="" 
                                            @if(Request::old('callback_save')) 
                                                value="{{ Request::old('number_payment_status') }}" 
                                            @else 
                                                @if(Request::old('callback_search')) 
                                                    value="{{ $infodata->payment_status }}" 
                                                @else 
                                                    value="" 
                                                @endif 
                                            @endif 
                                                list="status" 
                                            @if(Request::old('callback_save') || Request::old('callback_search')) 
                                                readonly 
                                            @endif>
                                    <datalist id="status">
                                        <option>Confirm</option>
                                        <option>Cancel</option>
                                    </datalist>
                                </div>
                                <!--form-group-->
                            </div>

                            {{-- <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">ประเภทการขาย</label> --}}
                                    <input autocomplete="off" type="hidden" class="form-control red disabledInput" name="type" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('number_payment_type') }}" @else @if(Request::old('callback_search')) @if(strtoupper($infodata->sales_classification_code) == 'DOMESTIC')
                                    value="ขายในประเทศ"
                                    @else value="ขายต่างประเทศ"
                                    @endif
                                    @endif
                                    @endif list="type"
                                    @if(Request::old('callback_save') || Request::old('callback_search')) readonly
                                    @endif>
                                    {{-- <datalist id="type">
                                        <option>Domestic</option>
                                        <option>Export</option>
                                    </datalist>
                                </div>
                                <!--form-group-->
                            </div> --}}

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="d-block">รหัสลูกค้า</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-icon">
                                                <input autocomplete="off" type="text" class="form-control" name="customer_number" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('number_payment_customer') }}" @else @if(Request::old('callback_search')) value="{{ $infodata->customer->customer_number }}" @else value="" @endif @endif list="customer_number" onchange="custchange(this.value,'tableaddpayment');" @if(Request::old('callback_search')) @if($infodata->payment_status == 'Confirm'  || $infodata->payment_status == 'Cancel') readonly @endif @endif>
                                                <i class="fa fa-search"></i>
                                                <datalist id="customer_number">
                                                    @foreach ($customers as $customer)
                                                    <option value="{{ $customer->customer_number }}">                                                        
                                                        {{ $customer->customer_name_format }}
                                                    </option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-2 mt-md-0">
                                            <input type="text" autocomplete="off" class="form-control disabledInput" disabled="" name="customer_name" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('number_payment_customer_name') }}" @else @if(Request::old('callback_search')) value="{{ $infodata->customer->customer_name_format }}" @else value="" @endif @endif>
                                        </div>
                                    </div>
                                    <!--row-->
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-12"></div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="d-block">ที่อยู่</label>
                                    <textarea style="height: 42px;" autocomplete="off" class="form-control disabledInput" name="address">{{ $infodata->customer->address_line1 ?? ''}} {{ $infodata->customer->alley ?? '' }} {{ $infodata->customer->district ?? '' }} {{ $infodata->customer->city ?? '' }} {{ $infodata->customer->province_name ?? '' }} {{ $infodata->customer->postal_code ?? '' }}</textarea>
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="d-block">หมายเหตุ</label>
                                    <input autocomplete="off" type="text" class="form-control" name="remark" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('number_payment_remart') }}" @else @if(Request::old('callback_search')) value="{{ $infodata->remark }}" @else value="" @endif @endif>
                                </div>
                                <!--form-group-->
                            </div>

                            {{-- <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="d-block">รหัสธนาคาร</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                                <select class="form-control" name="number_payment_bank" onchange="bankchange(this.value);">
                                                    <option></option>
                                                    @foreach($banks as $key => $bank)
                                                    <option value="{{ $bank->bank_number }},{{ $key }}" @if(Request::old('callback_save'))
                            @if(Request::old('number_payment_bank') == $bank->bank_number) selected @endif
                            @else
                            @if(Request::old('callback_search'))
                            @if($infodata->bank_id == $bank->bank_number) selected @endif
                            @endif
                            @endif>
                            {{ $bank->bank_number }} {{ $bank->bank_branch_name }}
                            </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 mt-2 mt-md-0">
                            <input type="text" class="form-control" disabled="" name="bank_desc" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('number_payment_bank_desc') }}" @else @if(Request::old('callback_search')) value="{{ $infodata->bank_name }}" @else value="" @endif @endif>
                        </div>
                </div>
                <!--row-->
            </div>
            <!--form-group-->
        </div> --}}
    </div>
    <!--row-->
    </form>

</div>
<!--col-xl-6-->
</div>

@if(Request::old('callback_search'))
    <form action="{{ route('om.payment-method-matchsave') }}" method="POST" id="submitform" enctype="multipart/form-data">
@else
    <form action="{{ route('om.payment-method-payment') }}" method="POST" id="submitform" enctype="multipart/form-data">
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="number_status" id="numberstatus" value="" />
    <input type="hidden" name="number_payment_status" id="numberpaymentstatus" value="" />
    <input type="hidden" name="number_payment_invoice" id="numberpaymentinvoice" value="" />
    <input type="hidden" name="number_payment_customer" id="numberpaymentcustomer" value="" />
    <input type="hidden" name="number_payment_date" id="numberpaymentdate" value="" />
    <input type="hidden" name="number_payment_remart" id="numberpaymentremart" value="" />
    <input type="hidden" name="number_payment_bank" id="numberpaymentbank" value="" />
    <input type="hidden" name="number_payment_bank_desc" id="numberpaymentbankdesc" value="" />
    <input type="hidden" name="number_payment_address" id="numberpaymentbaddress" value="" />
    <input type="hidden" name="payment_number" id="paymentnumber" value="" />
    <div class="row space-50 justify-content-md-center">

        <!--col-md-12-->
        <hr class="lg">

        <div class="col-xl-12">
            <div class="form-header-buttons">
                <div class="buttons d-flex">
                    <button class="btn btn-md btn-white" type="button" id="search" onclick="searchDPayment();"><i class="fa fa-search"></i> ค้นหา
                    </button>
                    <button class="btn btn-md btn-success" type="button" id="savematch"><i class="fa fa-save"></i> บันทึก
                    </button>
                    <button class="btn btn-md btn-danger" type="button" id="unmatch" onclick="unmatchall();"><i class="fa fa-times"></i> Unmatch
                    </button>
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="table-responsive tb-matchpayment">
                <table class="table text-center table-hover min-1400 f13" id="matchpayment">
                    <thead>
                        <tr class="align-middle" style="background-color: #92CDDC;color:black;">
                            <th>เลขที่เอกสาร</th>
                            <th>เลขที่ใบ<br>Invoice/ใบฝากขาย</th>
                            <th>ประเภท</th>
                            <th>จำนวนเงิน</th>
                            <th>วันที่ส่ง</th>
                            <th>วันครบกำหนดชำระ</th>
                            <th>กลุ่มวงเงิน</th>
                            <th>จำนวนวันเชื่อ</th>
                            <th>ค่าปรับ</th>
                            <th  style='display:none'>Match ลดหนี้</th>
                            <th>จำนวนเงินคงเหลือ</th>
                            <th>จำนวนเงินที่ชำระ</th>
                            <th>Match</th>
                            <!-- <th style="width: 55px">ลบ</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        @if(Request::old('callback_search'))
                        @foreach ($paymentsmethod as $key => $paymentMatch)
                        <?php
                        $totelsumpayemnt = $paymentMatch->outstanding_debt;
                        ?>
                        <tr class="align-middle" id="{{ $key }}">
                            <td>
                                <div class="input-icon">
                                    @if($infodata->customer->customer_type_id == '30' || $infodata->customer->customer_type_id == '40')
                                        @if($paymentMatch->prepare_order_number == null && strpos($paymentMatch->invoice_number, 'F') !== false)
                                            <input type="text" class="form-control text-center f13" placeholder="" value="" readonly autocomplete="off">
                                            <input type="hidden" class="form-control text-center f13" name="doc_id[]" placeholder="" value="" readonly autocomplete="off">
                                        @else
                                            @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                                <input type="text" class="form-control text-center f13" name="doc_id[]" placeholder="" value="{{ $paymentMatch->invoice_number }}" readonly autocomplete="off">
                                            @else
                                                @if($infodata->customer->customer_type_id == '40')
                                                    <input type="text" class="form-control text-center f13" placeholder="" value="{{ $paymentMatch->prepare_order_number }}" readonly autocomplete="off">
                                                    <input type="hidden" class="form-control text-center f13" name="doc_id[]" placeholder="" value="{{ $paymentMatch->prepare_order_number }}" readonly autocomplete="off">
                                                @else
                                                    @if($paymentMatch->orders->producttype->lookup_code == '20')
                                                        <input type="text" class="form-control text-center f13" placeholder="" value="{{ $paymentMatch->prepare_order_number }}" readonly autocomplete="off">
                                                        <input type="hidden" class="form-control text-center f13" name="doc_id[]" placeholder="" value="{{ $paymentMatch->prepare_order_number }}" readonly autocomplete="off">
                                                    @else
                                                        <input type="text" class="form-control text-center f13" placeholder="" readonly autocomplete="off">
                                                        <input type="hidden" class="form-control text-center f13" name="doc_id[]" placeholder="" value="{{ $paymentMatch->prepare_order_number }}" readonly autocomplete="off">
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                            <input type="text" class="form-control text-center f13" name="doc_id[]" placeholder="" value="{{ $paymentMatch->invoice_number }}" readonly autocomplete="off">
                                        @else
                                            <input type="text" class="form-control text-center f13" name="doc_id[]" placeholder="" value="{{ $paymentMatch->prepare_order_number }}" readonly autocomplete="off">
                                        @endif
                                    @endif
                                    <i class="fa fa-search"></i>
                                </div>
                            </td>
                            @if($infodata->customer->customer_type_id == '30' || $infodata->customer->customer_type_id == '40')
                                <td>{{ $paymentMatch->invoice_number ?? '' }}<input type="hidden" name="pick_no[]" value="{{ $paymentMatch->invoice_number }}"></td>
                            @else
                                @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                    <td><input type="hidden" name="pick_no[]" value="{{ $paymentMatch->invoice_number }}"></td>
                                @else
                                    <td>{{ $paymentMatch->invoice_number }}<input type="hidden" name="pick_no[]" value="{{ $paymentMatch->invoice_number }}"></td>
                                @endif
                            @endif

                            @if($infodata->customer->customer_type_id == '30' || $infodata->customer->customer_type_id == '40')
                                @if($infodata->customer->customer_type_id == '30')
                                    @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                        <td><input type="hidden" name="type_product[]" value=""></td>
                                    @else
                                        <td>{{ meaningproducttype($paymentMatch->invoice_number, $paymentMatch->prepare_order_number) }}<input type="hidden" name="type_product[]" value="{{ meaningproducttype($paymentMatch->invoice_number, $paymentMatch->prepare_order_number) }}"></td>
                                    @endif
                                @else
                                    @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                        <td><input type="hidden" name="type_product[]" value=""></td>
                                    @else
                                        @if($paymentMatch->prepare_order_number == null)
                                            <td>{{ $paymentMatch->orders->producttype->producttype->meaning ?? '' }}<input type="hidden" name="type_product[]" value="{{ $paymentMatch->orders->producttype->producttype->meaning ?? '' }}"></td>
                                        @else
                                            <td>{{ $paymentMatch->orders->producttype->meaning ?? '' }}<input type="hidden" name="type_product[]" value="{{ $paymentMatch->orders->producttype->meaning ?? '' }}"></td>
                                        @endif
                                    @endif
                                @endif
                            @else
                                @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                    <td><input type="hidden" name="type_product[]" value=""></td>
                                @else
                                    <td>{{ $paymentMatch->orders->producttype->meaning ?? '' }}<input type="hidden" name="type_product[]" value="{{ $paymentMatch->orders->producttype->meaning ?? '' }}"></td>
                                @endif
                            @endif


                            <td class="text-right">{{ number_format($totelsumpayemnt,2) }}<input type="hidden" name="amount_vat[]" value="{{ number_format($totelsumpayemnt,2) }}"></td>

                            @if($infodata->customer->customer_type_id == '30' || $infodata->customer->customer_type_id == '40')
                                @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                    <td>{{ FormatDate::DateThaiNumericWithSplash(datedn($paymentMatch->invoice_number)) }}<input type="hidden" name="invoice_date[]" value="{{ datedn($paymentMatch->invoice_number) }}"></td>
                                @else
                                    @if($paymentMatch->prepare_order_number == null)
                                        <td>{{ FormatDate::DateThaiNumericWithSplash($paymentMatch->orders->consignment_date) }}<input type="hidden" name="invoice_date[]" value="{{ $paymentMatch->orders->consignment_date }}"></td>
                                    @else
                                        <td>{{ FormatDate::DateThaiNumericWithSplash($paymentMatch->orders->delivery_date) }}<input type="hidden" name="invoice_date[]" value="{{ $paymentMatch->orders->delivery_date }}"></td>
                                    @endif
                                @endif
                            @else
                                @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                    <td>{{ FormatDate::DateThaiNumericWithSplash(datedn($paymentMatch->invoice_number)) }}<input type="hidden" name="invoice_date[]" value="{{ datedn($paymentMatch->invoice_number) }}"></td>
                                @else
                                    <td>{{ FormatDate::DateThaiNumericWithSplash($paymentMatch->orders->delivery_date) }}<input type="hidden" name="invoice_date[]" value="{{ $paymentMatch->orders->delivery_date }}"></td>
                                @endif
                            @endif

                            @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                <td><input type="hidden" name="invoice_duedate[]" value=""></td>
                                <td><input type="hidden" name="credit_group[]" value=""></td>
                                <td><input type="hidden" name="credit_day[]" value=""></td>
                                <td class="text-right"><input type="hidden" name="amount_fines[]" value=""></td>
                                <td class="d-none">
                                    <div class="input-icon">
                                        <input type="text" class="form-control red text-center f13" name="paymatch[]" placeholder="" value="{{ number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}" onchange="summatchnew();" readonly>
                                        <i class="fa fa-search" data-toggle="modal" data-target="#matchCreditModal" data-whatever="{{ $key }}"></i>
                                    </div>
                                    <input type="hidden" name="amount_match[]" value="{{ number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}">
                                </td>
                                <td class="text-right">@if(number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) == '0.00') {{ number_format($totelsumpayemnt,2) }} <input type="hidden" name="amount_balance[]" value="{{ number_format($totelsumpayemnt,2) }}"> @else {{ number_format($totelsumpayemnt - $paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }} <input type="hidden" name="amount_balance[]" value="{{ number_format($totelsumpayemnt - $paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}"> @endif</td>
                                <td><input type="text" class="form-control text-right f13" name="balancetotal[]" placeholder="" value="{{ number_format($paymentMatch->payment_amount,2) }}" readonly><input type="hidden" name="amount_balancetotal[]" value="{{ number_format($paymentMatch->payment_amount,2) }}"></td>
                                <td><input type="checkbox" value="{{ $paymentMatch->invoice_id }}:INVOICE:{{ $key }}" name="match_check[]" onclick="summatch();" @if($paymentMatch->match_flag == 'Y') checked @endif @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') disabled @endif></td>
                            @else
                                <td>{{ FormatDate::DateThaiNumericWithSplash($paymentMatch->due_date) }}<input type="hidden" name="invoice_duedate[]" value="{{ $paymentMatch->due_date }}"></td>
                                <td>@if($paymentMatch->credit_group_code == 0) เงินสด @else {{ $paymentMatch->credit_group_code }} @endif <input type="hidden" name="credit_group[]" value="{{ $paymentMatch->credit_group_code }}"></td>
                                <td>{{ $paymentMatch->due_day }}<input type="hidden" name="credit_day[]" value="{{ $paymentMatch->due_day }}"></td>
                                <td class="text-right">@if($paymentMatch->credit_group_code == 0) 0.00 @else {{ payfine($totelsumpayemnt,$paymentMatch->due_date,$payment_date_invoice->payment_date,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->invoice_number, 'D') }}@endif<input type="hidden" name="amount_fines[]" value="@if($paymentMatch->credit_group_code == 0) 0.00 @else {{ payfine($totelsumpayemnt,$paymentMatch->due_date,$payment_date_invoice->payment_date,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->invoice_number, 'D') }}@endif"></td>
                                <td style="display:none">
                                    <div class="input-icon">
                                        <input type="text" class="form-control red text-center f13" name="paymatch[]" placeholder="" value="{{ number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}" onchange="summatchnew();" readonly>
                                        <i class="fa fa-search" data-toggle="modal" data-target="#matchCreditModal" data-whatever="{{ $key }}"></i>
                                    </div>
                                    <input type="hidden" name="amount_match[]" value="{{ number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}">
                                </td>
                                <td class="text-right">@if(number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) == '0.00') {{ number_format($totelsumpayemnt,2) }} <input type="hidden" name="amount_balance[]" value="{{ number_format($totelsumpayemnt,2) }}"> @else {{ number_format($totelsumpayemnt - $paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }} <input type="hidden" name="amount_balance[]" value="{{ number_format($totelsumpayemnt - $paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}"> @endif</td>
                                <td><input type="text" class="form-control text-right f13" name="balancetotal[]" placeholder="" value="{{ number_format($paymentMatch->payment_amount,2) }}" readonly><input type="hidden" name="amount_balancetotal[]" value="{{ $paymentMatch->payment_amount }}"></td>
                                <td><input type="checkbox" value="{{ $paymentMatch->orders->order_header_id }}:DRAFT:{{ $key }}" name="match_check[]" onclick="summatch();" @if($paymentMatch->match_flag == 'Y') checked @endif @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') disabled @endif></td>
                            @endif
                            <!-- <td class="text-center">
                            @if($infodata->payment_status == 'Draft')<a class="fa fa-times red" href="javascript:void(0);"></a>@endif
                            </td> -->
                            <input type="hidden" name="matchid[]" value="">
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!--table-responsive-->

            <div class="col-md-12">
                <hr class="lg">

                <div class="form-header-buttons">
                    <h3 class="black mb-2 mb-md-0">ข้อมูลการชำระเงิน</h3>
                    <div class="buttons d-flex">
                        <button class="btn btn-md btn-success" 
                                type="button" 
                                id="addpayment" 
                                @if(Request::old('callback_search')) 
                                    @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') 
                                        disabled 
                                    @endif 
                                @endif>
                            <i class="fa fa-plus"></i> เพิ่ม
                        </button>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="table-responsive">
                    <table class="table text-center table-hover min-1000 f13" id="tableaddpayment">
                        <thead>
                            <tr class="align-middle" style="background-color: #92CDDC;color:black;">
                                <th style="width: 55px">ลำดับที่</th>
                                <th class="w-201">วิธีการชำระเงิน</th>
                                <th class="text-center">ธนาคาร</th>
                                <th class="w-201">จำนวนเงิน<br>รับชำระ</th>
                                <th style="width: 55px">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(Request::old('callback_save'))
                            @if(Request::old('payment_method'))
                            @foreach (Request::old('payment_method') as $key => $pm)
                            <tr class="align-middle">                                
                                <td>
                                    {{ $key+1 }}
                                    <input type="hidden" name="number_payment[]" value="{{ Request::old('number_payment')[$key] }}">
                                    <input type="hidden" name="bank_code[]" value="{{ Request::old('bank_code')[$key] }}">
                                </td>
                                <td>
                                    <select class="form-control disabledInput" name="payment_method[]" id="payment_desc_number_bank-{{$key}}" @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') disabled @endif>
                                        @foreach($methods as $method)
                                            <option value="{{ $method->lookup_code }},{{ $method->meaning }}" @if($pm->payment_method_code == $method->lookup_code) selected @endif>{{ $method->description }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control disabledInput" name="payment_desc_number_bank[]" id="payment_desc_number_bank-{{$key}}-2" @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') disabled @endif>
                                        @foreach ($bankdesc as $desc)
                                            <option value="{{ $desc->bank_account_name }}" 
                                                    @if($desc->bank_account_name == $pm->bank_desc) 
                                                        selected 
                                                    @endif>{{ $desc->bank_account_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" placeholder="" name="payment_amount[]" value="{{ number_format(Request::old('total_payment_amount')[$key],2) }}" class="form-control md text-right" autocomplete="off" onchange="(function(el){el.value=addCommas(parseFloat(el.value).toFixed(2));})(this)" onkeypress="countsumpayment();" onkeydown="countsumpayment();"><input type="hidden" name="total_payment_amount[]" value="{{ number_format(Request::old('total_payment_amount')[$key],2) }}"></td>
                                <td class="text-center">@if($infodata->payment_status == 'Draft')<a href="javascript:void(0)" class="fa fa-times red" onclick="deleteRow(this,'tableaddpayment');"></a>@endif</td>
                            </tr>
                            @endforeach
                            @endif
                            @endif

                            @if(Request::old('callback_search'))
                            <?php $t = 0; ?>
                            @if($infodata->paymentMethod)
                            @foreach ($infodata->paymentMethod as $key => $pm)
                            <?php $t += $pm->payment_amount; ?>
                            <tr class="align-middle">
                                <td>{{ $key+1 }}
                                    <input type="hidden" name="number_payment[]" value="{{ $pm->payment_no }}">
                                    <input type="hidden" name="bank_code[]" value="{{ $pm->bank_number }}">
                                    <input type="hidden" name="payment_detail_id[]" value="{{ $pm->payment_detail_id }}">
                                </td>
                                <td>
                                    <select class="form-control disabledInput" name="payment_method[]" id="payment_desc_number_bank-{{$key}}" @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') disabled @endif>
                                        @foreach($methods as $method)
                                        <option value="{{ $method->lookup_code }},{{ $method->meaning }}" @if($pm->payment_method_code == $method->lookup_code) selected @endif>{{ $method->description }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control disabledInput select2-payment_desc_number_bank" 
                                            name="payment_desc_number_bank[]" 
                                            id="payment_desc_number_bank-{{$key}}-2" 
                                            @if(($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') || count($arReceiptsV) == 0) 
                                                disabled 
                                            @endif>
                                        @foreach ($bankdesc as $desc)
                                            <option data-bank_account_number="{{$desc->bank_account_number}}" 
                                                    data-bank_number="{{ $desc->lookup_code }}" 
                                                    value="{{ $desc->bank_account_name }}" 
                                                    @if($desc->bank_account_name == $pm->bank_desc) 
                                                        selected 
                                                    @endif>
                                                {{ $desc->bank_account_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" placeholder="" name="payment_amount[]" value="{{ number_format($pm->payment_amount,2) }}" class="form-control md text-right" autocomplete="off" onchange="(function(el){el.value=addCommas(parseFloat(el.value).toFixed(2));})(this)" onkeypress="countsumpayment();" onkeydown="countsumpayment();" readonly><input type="hidden" name="total_payment_amount[]" value="{{ number_format($pm->payment_amount,2) }}"></td>
                                <td class="text-center">@if($infodata->payment_status == 'Draft')<a href="javascript:void(0)" class="fa fa-times red"></a>@endif</td>
                            </tr>
                            @endforeach
                            @endif
                            @endif
                            <tr class="align-middle">
                                <td class="text-right pt-3 pb-3" colspan="3" id="ignore"><strong class="black">จำนวนเงินรวมที่รับชำระ</strong>
                                </td>
                                <td class="text-right pt-3 pb-3" id="total"><strong class="black">@if(Request::old('callback_save')) {{ number_format(Request::old('total_amounts') + Request::old('balance_amounts'),2) }} @else @if(Request::old('callback_search')) {{ number_format($t,2) }} @else 0.00 @endif @endif</strong>
                                </td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!--table-responsive-->

            </div>

            <div class="panel panel-default mt-4">
                <div class="d-block m-auto">
                    <div class="row justify-content-between p-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="d-block black">จำนวนเงินรวม Vat</label>
                                <input type="text" class="form-control text-right disabledInput" disabled="" name="totalvat" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('totalval') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_amount_with_vat,2) }}" @else value="" @endif @endif>
                                <input type="hidden" name="totalvat_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('totalvat_amounts') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_amount_with_vat,2) }}" @else value="" @endif @endif>
                            </div>
                        </div>
                        <!--col-md-3-->

                        <div class="col-lg-3 col-md-6 d-none">
                            <div class="form-group">
                                <label class="d-block black">จำนวนเงินใบลดหนี้ที่ Match</label>
                                <input type="text" class="form-control text-right disabledInput" disabled="" name="match_count" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('match_count') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_amount_match,2) }}" @else value="" @endif @endif>
                                <input type="hidden" name="match_count_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('match_count_amounts') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_amount_match,2) }}" @else value="" @endif @endif>
                            </div>
                        </div>
                        <!--col-md-3-->

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="d-block black">ค่าปรับ</label>
                                <input type="text" class="form-control text-right disabledInput" disabled="" name="paycount" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('paycount') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_fine,2) }}" @else value="" @endif @endif>
                                <input type="hidden" name="paycount_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('paycount_amounts') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_fine,2) }}" @else value="" @endif @endif>
                            </div>
                        </div>
                        <!--col-md-3-->

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="d-block black">รวมเงินชำระ</label>
                                <input type="text" class="form-control text-right disabledInput" disabled="" name="total" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('total') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_payment_amount,2) }}" @else value="" @endif @endif>
                                <input type="hidden" name="total_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('total_amounts') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_payment_amount,2) }}" @else value="" @endif @endif>
                            </div>
                        </div>
                        <!--col-md-3-->


                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="d-block black">เงินคงเหลือในบัญชีครั้งก่อน</label>
                                <input type="text" class="form-control text-right disabledInput" disabled="" name="bbalance" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('bbalance') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_previous_remain_amount,2) }}" @else value="" @endif @endif>
                                <input type="hidden" name="bbalance_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('bbalance_amounts') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_previous_remain_amount,2) }}" @else value="" @endif @endif>
                            </div>
                        </div>
                        <!--col-md-3-->

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="d-block black">จำนวนเงินใบเพิ่มหนี้</label>
                                <input type="text" class="form-control text-right disabledInput" disabled="" name="matchamount" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('matchamount') }}" @else @if(Request::old('callback_search')) value="" @else value="" @endif @endif>
                                <input type="hidden" name="matchamount_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('matchamount_amounts') }}" @else @if(Request::old('callback_search')) value="" @else value="" @endif @endif>
                            </div>
                        </div>
                        <!--col-md-3-->


                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="d-block black">เงินคงเหลือในบัญชีครั้งนี้</label>
                                <input type="text" class="form-control text-right disabledInput" disabled="" name="balance" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('balance') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_remain_amount,2) }}" @else value="" @endif @endif>
                                <input type="hidden" name="balance_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('balance_amounts') }}" @else @if(Request::old('callback_search')) value="{{ number_format($infodata->total_remain_amount,2) }}" @else value="" @endif @endif>
                            </div>
                        </div>
                        <!--col-md-3-->

                    </div>
                    <!--row-->
                </div>
                <!--d-block-->
            </div>
            <!--panel-->

            <div class="hr-line-dashed"></div>
            <div class="text-center">
                <div class="buttons multiple">
                    @if ($infodata && $infodata->payment_status == 'Cancel')
                        
                    @else
                        <button class="btn btn-md btn-success" data-toggle="modal" data-target="#UploadModalFile" 
                                type="button" id="fileattachment">
                                <span class="fa fa-upload"> ไฟล์แนบ</span>
                        </button>
                    @endif
                    
                    @if ($infodata && $infodata->payment_status == 'Confirm')
                        <button class="btn btn-md btn-danger" 
                                type="button" 
                                id="cancelbtn" 
                                onclick="savepayment('Cancel');">
                            <i class="fa fa-times"></i> ยกเลิก
                        </button>
                    @else
                        @if ($infodata && $infodata->payment_status == 'Cancel')
                            
                        @else
                            <button class="btn btn-md btn-info" 
                                    type="button" 
                                    id="confirmbtn" 
                                    onclick="savepayment('Confirm');">
                                <i class="fa fa-check"></i> ยืนยันข้อมูล
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <!--col-xl-12-->
    </div>
    <input type="hidden" name="files_uploadsId" id="files_uploadsId">
</form>
<!--row-->
</div>
<!--ibox-content-->
</div>
<!--ibox-->

<div class="modal modal-600 fade" id="UploadModalFile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <div class="modal-header">
                <h3>Upload File</h3>
            </div>
            <form id="form_attachment" data-action="{{ url('/') }}/om/payment-method/payment/upload">
                {{ csrf_field() }}
                <div class="modal-body pt-4 pb-0">
                    <div class="attachment-box">
                        <div class="form-group d-flex mb-1">
                            <div class="custom-file">
                                <input id="attachment" type="file" class="custom-file-input" name="attachment" value="" accept=".jpeg, .jpg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .csv">
                                <label for="attachment" class="custom-file-label label-attachment">Choose file...</label>
                            </div>
                            <div class="button">
                                <button class="btn btn-success" type="button" onclick="submitChooseFile()">Submit</button>
                                <button class="btn btn-warning" type="button" id="btn_clear" onclick="clearInputFile('clear')">Clear</button>
                            </div>
                        </div>
                        <p><small>Allow type : jpeg, jpg, bmp, png, pdf, doc, docx, xls, xlsx, rar, zip, csv and size < 2mb</small>
                        </p>
                        <ul class="nav files">
                        @if(!empty($infodata->files))
                                @foreach($infodata->files as $keyfile => $item)
                                    <li id="file_attachment_{{ $item->attachment_id }}">
                            <code><a href="{{ route('om.payment-method-download',$item->attachment_id) }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $item->file_name }}</code></a>
                            <button class="btn btn-remove" onclick="removeFileAttachment(0,{{ $item->attachment_id }},`db`)" type="button">@if(Request::old('callback_search')) @if($infodata->payment_status == 'Draft')<i class="fa fa-times"></i>@endif @endif</button>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <!--modal-body-->
                <div class="modal-footer center mt-4">
                    <button class="btn btn-gray" type="button" data-dismiss="modal">
                        ปิด<small>Close</small>
                    </button>
                    <button class="btn btn-primary" type="submit">
                        ยืนยัน<small>Confirm</small>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!--modal-content-->
</div>

<!--modal-dialog-->
<div class="modal modal-600 fade" id="matchCreditModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

            <div class="modal-header">
                <h3>รายการ</h3>
            </div>
            <div class="modal-body pt-4 pb-0">
                <table class="table table-bordered text-center table-hover f13" id="cn">
                    <thead>
                        <tr class="align-middle">
                            <th>เลือก</th>
                            <th>เลขที่ใบลดหนี้/เพิ่มหนี้</th>
                            <th>จำนวนเงิน</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!--modal-body-->
            <input type="hidden" id="recipientid" value="" />

            <div class="modal-footer center mt-4">
                <button class="btn btn-lg btn-primary" type="button" onclick="confirmcn();" @if(Request::old('callback_search')) @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') disabled @endif @endif>ยืนยัน</button>
                <button class="btn btn-lg btn-danger" type="button" data-dismiss="modal" @if(Request::old('callback_search')) @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') disabled @endif @endif><i class="fa fa-times"></i>
                    ยกเลิก
                </button>
            </div>

        </div>
        <!--modal-content-->
    </div>
    <!--modal-dialog-->
</div>
</div>

@endsection

@section('scripts')
<script src="{!! asset('js/moment.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/lodash.js') !!}" type="text/javascript"></script>
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
<script src="{!! asset('js/number.js') !!}"></script>

<script>
    let banklists       = {!! json_encode($banks) !!};
    let customerlists   = {!! json_encode($customers) !!};
    let idorders        = [];
    let idinvoices      = [];
    let addfines        = [];
    var datacn          = [];
    var datadn          = [];
    let created         = false;

    $(document).ready(function() {
        $(document).on('click', '#savebtn', function() {
            $.ajax({
                url: ''
                ,method:'get'
                ,data:{action_note:'_ADD_NOTE', 'NOTE': $('[name="remark"]').val()}
            }).done(function(){
                Swal.fire({
                    title: 'ทำรายการบันทึกหมายเหตุ เรียบร้อยแล้ว',
                    icon: 'success'
                });
            })
        });

        @if(Request::old('callback_search'))
            if($('#matchpayment tbody tr').length == 0) {
                $('#unmatch').attr('disabled', true);
                @if(count($arReceiptsV) == 0)
                $('[name="payment_desc_number_bank[]"]').removeAttr('disabled')
                @endif
            } else {
                $('#savematch').attr('disabled', true);
            }
            @if($infodata->payment_status == 'Confirm')
                $('#cancelbtn').attr('disabled', false);
                $('#confirmbtn').attr('disabled', true);
                if($('#matchpayment tbody tr').length == 0) {
                    $('#printbtn').addClass('disabled');
                } else {
                    $('#printbtn').removeClass('disabled');
                }
                $('#search').attr('disabled', false);
            @elseif($infodata->payment_status == 'Cancel')
                 $('#cancelbtn').attr('disabled', true);
                $('#confirmbtn').attr('disabled', false);
                 $('#printbtn').removeClass('disabled');
            @else
                $('#cancelbtn').attr('disabled', true);
                $('#confirmbtn').attr('disabled', false);
                $('#printbtn').addClass('disabled', true);
            @endif
        @else
            $('#unmatch').attr('disabled', true);
            @if(count($arReceiptsV) == 0)
            $('[name="payment_desc_number_bank[]"]').removeAttr('disabled')
            @endif
            $('#savematch').attr('disabled', true);
            $('#cancelbtn').attr('disabled', true);
            $('#confirmbtn').attr('disabled', false);
            $('#printbtn').addClass('disabled', true);
            $('#search').attr('disabled', true);
        @endif

        $('#input_date').on('change', function() {
            changeDate()
        });

        $('.date').datepicker();
        $('.select2').select2();
        disableBtn();

        $('#addpayment').on('click', function() {
            addpayment('tableaddpayment');
        });

        $('#add').on('click', function() {
            addpayment('matchpayment');
        });

        $('.files-clear').on('click', function() {
            $("#file-logo").val('');
        });

        $('#matchCreditModal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var bookId = $(e.relatedTarget).data('whatever');
            var headerId = $(e.relatedTarget).data('headers');
            if(headerId != 'F'){
                $('#cn tbody').each(function(k,v){
                    var id = $('#cn tbody tr:eq('+k+')').find("input[type='checkbox']").val();
                    if(headerId == id){
                        $('#cn tbody tr:eq('+k+')').find("input[type='checkbox']").attr('checked',true);
                        cnmatch($('#cn tbody tr:eq('+k+')'));
                    }
                });
            } else {
                $('#cn tbody').each(function(k,v){
                    var id = $('#cn tbody tr:eq('+k+')').find("input[type='checkbox']").val();
                    $('#cn tbody tr:eq('+k+')').find("input[type='checkbox']").attr('checked',false);
                    cnmatch($('#cn tbody tr:eq('+k+')'));
                });
            }
            //populate the textbox
            $(e.currentTarget).find('#recipientid').val(bookId);
        });

        $('.files-submit').on('click', function() {
            if ($("#file-logo").get(0).files.length == 0) {
                return false;
            } else {
                $('input[name="files_upload"]').prop("files", $('#file-logo')[0].files);
                $('#files-lists').append('<code><a href="#"><i class="fa fa-file-pdf-o"></i>  ' + $('#file-logo')[0].files[0].name + '</a></code><button class="btn btn-remove" onclick="deletefilefrominput(\'' + $('#file-logo')[0].files[0].name + '\');"><i class="fa fa-times"></i></button>');
                $("#file-logo").val('');
            }
        });
        $('#searchbtn').click(function() {
            if ($('input[name="payment_number"]').val() == '') {
                Swal.fire({
                    title: 'กรุณาระบุเลขที่ใบเสร็จรับเงิน',
                    icon: 'error'
                });
                return false;
            }
            Swal.fire({
                title: 'กำลังค้นหาใบเสร็จเลขที่ ' + $('input[name="payment_number"]').val(),
                showCancelButton: false,
                showConfirmButton: false
            });
            $('#searchnumber').submit();
        });

        $('#uploadfilestart').click(function() {
            if ($('input[name="aksfileupload[]"]').val() == '') {
                Swal.fire({
                    title: 'กรุณาเลือกไฟล์',
                    icon: 'error'
                });
                return false;
            }
            Swal.fire({
                title: 'กำลังอัปโหลด กรุณารอสักครู่',
                showCancelButton: false,
                showConfirmButton: false
            });
            $('#uploadfilestartform').submit();
        });

        $('#savematch').on('click', function() {
            var number_payment = $('input[name="payment_number"]').val();

            if($('#matchpayment tbody tr').length == 0) {
                Swal.fire({
                    title: 'ไม่พบข้อมูลที่ต้องการบันทึก',
                    icon: 'error'
                });
                return false;
            }
            $('input[name="_token"]').val('{{ csrf_token() }}');
            $('input[name="payment_number"]').val(number_payment);

            Swal.fire({
                title: 'กำลังดำเนินการบันทึกกรุณารอสักครู่',
                showCancelButton: false,
                showConfirmButton: false
            });
            $('#submitform').submit();
        })
    });


    var delivery_date = '';
    var dateFormat = '{{ trans('date.js-format') }}';
    var disabled = false;

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
                        name="payment_date"
                        id="input_date"
                        :disabled="disabled"
                        not-after-date="{{ date('d') }}/{{ date('m') }}/{{ date('Y')+543 }}"
                        @dateWasSelected='onchangeDate(...arguments)'
                        :value=pValue
                        :format=pFormat />`,
        methods: {
            async onchangeDate (date) {
                vm.pValue = date;
                var newDate = moment(date).format("DD/MM/YYYY")
                $('input[name="payment_date"]').val(newDate);
                if(created && $('input[name="customer_number"]').val() != '') {
                    searchDPayment();
                }
            }
        },
        watch: {
            pValue : async function (value, oldValue) {

            }
        },
    }).$mount('#input_delivery_date')


    function unmatchall() {
        var number_payment = $('input[name="payment_number"]').val();

        if($('#matchpayment tbody tr').length == 0) {
            Swal.fire({
                title: 'ไม่พบข้อมูลที่ต้องการยกเลิก',
                icon: 'error'
            });
            return false;
        }

        Swal.fire({
            title: 'ต้องการ unmatch รายการใช่หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: ' ตกลง ',
            cancelButtonText: ' ยกเลิก ',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('om.payment-method-unmatchall') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'number_payment': number_payment
                    },
                    cache: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'กำลังดำเนินการ',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(data) {
                        if(data.status == 'error') {
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด',
                                text: data.message,
                                icon: 'error'
                            });
                        } else {
                            $('#matchpayment tbody').empty();
                            summatch();
                            Swal.fire({
                                title: 'unmatch สำเร็จ',
                                icon: 'success'
                            }).then(function() {
                                searchDPayment();
                            });
                            $('#savematch').attr('disabled', false);
                            $('#search').attr('disabled', false);
                            $('#unmatch').attr('disabled', true);
                            @if(count($arReceiptsV) == 0)
                                $('[name="payment_desc_number_bank[]"]').removeAttr('disabled')
                            @endif
                        }
                    },
                    error: function(data) {
                        Swal.fire({
                            title: 'เกิดข้อผิดพลาด',
                            icon: 'error'
                        });
                    }
                });
            }
        })
    }

    function select2auto() {
        $('.select2').select2();
    }

    function resetpage() {
        window.location.href = "/om/payment-method/form";
    }

    var fileChoose = [];
    var fileSecChoose = 1;
    var fileRunChoose = -1;
    $('#attachment').change(function() {
        var input = this;
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        fileChoose.push(input.files[0]);
        fileRunChoose += 1;
    });

    function submitChooseFile() {
        let html = '<li id="file_choose_' + fileSecChoose + '_' + fileRunChoose + '">' +
            '<code><a href="#"><i class="fa fa-file-pdf-o"></i>  ' + fileChoose[fileRunChoose].name + '</code></a>' +
            '<button class="btn btn-remove" onclick="removeFileAttachment(' + fileSecChoose + ',' + fileRunChoose + ')" type="button"><i class="fa fa-times"></i></button>' +
            '</li>';
        $("ul.files").append(html);
        clearInputFile();
    }

    var html = '';
    var files_uploadsId = [];
    $("#form_attachment").submit(async function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        await $.each(fileChoose, async function(index, file) {
            if (typeof file !== "undefined")
                await formData.append('attachment[]', file);
        });
        Swal.fire({
            title: 'กำลังอัปโหลด กรุณารอสักครู่',
            showCancelButton: false,
            showConfirmButton: false
        });
        $.ajax({
            type: 'post',
            url: $(this).data('action'),
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.status == 200) {
                    $("ul.files").empty();
                    fileChoose = [];
                    fileRunChoose = -1;
                    fileSecChoose += 1;
                    clearInputFile()
                    // var files_uploadsId = $('#files_uploadsId').val();
                    $.each(result.attachments, function(index, fileInfo) {
                        html += '<li id="file_choose_' + index + '_' + fileInfo.attachment_id + '">' +
                            '<code><a href="{{ url("/") }}/' + fileInfo.path_name + '/' + fileInfo.file_name + '" target="_blank"><i class="fa fa-file-pdf-o"></i>  ' + fileInfo.file_name + '</code></a>' +
                            '<button class="btn btn-remove" onclick="removeFileAttachment(' + index + ',' + fileInfo.attachment_id + ',`db`)" type="button"><i class="fa fa-times"></i></button>' +
                            '</li>';
                        // files_uploadsId += fileInfo.attachment_id;
                        // if (result.attachments != "" || result.attachments != null) {
                        //     files_uploadsId += ",";
                        // }
                        files_uploadsId.push(fileInfo.attachment_id);
                    });
                    $("ul.files").append(html);
                    $('#files_uploadsId').val("" + files_uploadsId + "");
                    $('#UploadModalFile').modal('hide')
                    Swal.fire({
                        title: result.message,
                        icon: 'success'
                    });
                }
                if (result.status == 422 || result.status == 403) {
                    Swal.fire({
                        title: result.message,
                        icon: 'error'
                    });
                }
            },
            error: function(data) {
                $('#UploadModalFile').modal('hide')
            }
        });
    });

    function clearInputFile(type = '') {
        $('#attachment').replaceWith($('#attachment').val('').clone(true));
        $('#attachment').val('');
        $("#attachment").val(null);
        $('.label-attachment').html('Choose file...')
        if (type == 'clear') {
            delete fileChoose[fileRunChoose];
            // fileRunChoose = -1;
        }
    }

    async function setAttachment(attachment) {
        let html = ''
        let url = "{{ url('/') }}"
        $("ul.files").empty();
        await $.each('input[name=attachment]', async function(index, item) {
            html += '<li id="file_attachment_' + item.attachment_id + '">'
            html += '<code><a href="' + url + '/' + item.path_name + '" target="_blank"><i class="fa fa-file-pdf-o"></i>  ' + item.file_name + '</code></a>'
            html += '<button class="btn btn-remove" onclick="removeFileAttachment(0,' + item.attachment_id + ',`db`)" type="button"><i class="fa fa-times"></i></button>'
            html += '</li>';
        });
        $("ul.files").append(html);
    }

    function removeFileAttachment(section, index, type = 'local') {
        if (type != 'local') {
            let formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('attachment_id', index);
            $.ajax({
                type: 'post',
                url: "{{ url('/') }}/om/payment-method/payment/files/delete",
                cache: false,
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังลบไฟล์',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(result) {
                    Swal.fire({
                        title: result.data,
                        icon: 'success'
                    });
                    $('#file_choose_' + section + '_' + index).remove();
                },
                error: function(data) {

                }
            });
        } else {
            delete fileChoose[index];
            $('#file_choose_' + section + '_' + index).remove()
        }
    }

    function deletefilefrominput(name) {
        if (name == '') {
            return false;
        }
    };

    function filedeletefromid(id, key) {
        if (id == '' && key == '') {
            return false;
        }
    }

    function getlistdetailbank(params) {
        var rowjQuery = $(params).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;

        if(params.value){
            $.ajax({
                url: "{{ route('om.payment-method-getlistbank') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "params": params.value,
                },
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กรุณารอสักครู่',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(res) {
                    var data = res.data;
                    $('#tableaddpayment tbody tr:eq(' + index + ')').find('select[name="payment_desc_number_bank[]"]').html('');
                    $('#tableaddpayment tbody tr:eq(' + index + ')').find('select[name="payment_desc_number_bank[]"]').append('<option value=""></option>');
                    $.each(data, function(key, value) {
                        $('#tableaddpayment tbody tr:eq(' + index + ')').find('select[name="payment_desc_number_bank[]"]').append('<option data-bank_number="'+ value.lookup_code +'" value="' + value.bank_account_name + '">' + value.bank_account_name + '</option>');
                        // if (value.primary == 'Y') {
                        //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('select[name="payment_desc_number_bank[]"]').append('<option data-bank_number="'+ value.lookup_code +'" value="' + value.bank_account_name + '" selected>' + value.bank_account_name + '</option>');
                        //     changeBankdesc(params);
                        // } else {
                        //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('select[name="payment_desc_number_bank[]"]').append('<option data-bank_number="'+ value.lookup_code +'" value="' + value.bank_account_name + '">' + value.bank_account_name + '</option>');
                        // }
                    });
                    swal.close();
                    // changeBankdesc(params);
                },
                error: function(error) {
                    Swal.fire({
                        title: error.responseText,
                        icon: 'error'
                    });
                }
            });
        }
    }

    function changeBankdesc(v) {
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        var vv = $('#tableaddpayment tbody tr:eq(' + index + ')').find('select[name="payment_desc_number_bank[]"]').children("option:selected").val();
        $.ajax({
            url: "{{ route('om.payment-method-getvaluebank') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "valuebank": vv,
            },
            cache: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'กรุณารอสักครู่',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res) {
                var data = res.data;
                if ($('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="bank_code[]"]').length == 0) {
                    $('#tableaddpayment tbody tr:eq(' + index + ')').append('<input type="hidden" name="bank_code[]" value="' + data.bank_number + '">');
                } else {
                    $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="bank_code[]"]').val(data.bank_number);
                }
                if ($('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="number_payment[]"]').length == 0) {
                    $('#tableaddpayment tbody tr:eq(' + index + ')').append('<input type="hidden" name="number_payment[]" value="' + data.bank_account_number + '">');
                } else {
                    $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="number_payment[]"]').val(data.bank_account_number);
                }
                swal.close();
            },
            error: function(error) {
                Swal.fire({
                    title: error.responseText,
                    icon: 'error'
                });
            }
        });
    }

    function deletefile(id, index) {
        Swal.fire({
                title: "ยืนยัน?",
                text: "ต้องการลบไฟล์ที่เลือกใช่หรือไม่?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ยืนยันการลบ",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ request()->getSchemeAndHttpHost() }}/om/payment-method/payment/files/delete",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "attachment_id": id,
                        },
                        cache: false,
                        beforeSend: function() {
                            Swal.fire({
                                title: 'กำลังลบไฟล์',
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        },
                        success: function(res) {
                            Swal.fire({
                                title: res.data,
                                icon: 'success'
                            });
                        },
                        error: function(error) {
                            Swal.fire({
                                title: error.responseText,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
    }

    function savepayment(status) {
        var rows = document.getElementById('tableaddpayment').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
        if(document.getElementById('tableaddpayment').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length <= 1){
            Swal.fire({
                title: 'กรุณาระบุข้อมูลการชำระเงิน',
                icon: 'error'
            });
        } else {
            try {
                $('#tableaddpayment tbody tr').each(function(index, value){
                    if (index === (rows - 1)){
                        return false;
                    }

                    var row = $(this);
                    if(row.find("td").eq(1).find('select[name="payment_method[]"] option:selected').val() == ''){
                        throw 'กรุณาระบุวิธีการชำระเงิน';
                        return false;
                    }

                    if( row.find("td").eq(2).find('select[name="payment_desc_number_bank[]"] option:selected').val() == ''){
                        throw 'กรุณาระบุธนาคาร';
                        return false;
                    }

                    if(row.find("td").eq(3).find('input[name="payment_amount[]"]').val() == ''){
                        throw 'กรุณาระบุจำนวนเงิน';
                        return false;
                    }
                });
            }catch (ex) {
                Swal.fire({
                    title: ex,
                    icon: 'error'
                });
                return false;
            }

            var number_customer;
            var number_invoice;
            var number_date;
            var number_remark;
            var number_bank;
            var number_bank_desc;
            var number_address;
            var number_status;

            number_date = $('input[name="payment_date"]').val();
            number_invoice = $('input[name="payment_number"]').val();

            number_customer = $('input[name="customer_number"]').val();
            number_remark = $('input[name="remark"]').val();
            number_address = $('input[name="address"]').val();
            number_status = $('input[name="status"]').val();

            $('#numberpaymentinvoice').val(number_invoice);
            $('#numberpaymentdate').val(number_date);
            $('#numberpaymentcustomer').val(number_customer);
            $('#numberpaymentstatus').val(status);
            $('#numberpaymentremart').val(number_remark);
            $('#numberpaymentbaddress').val(number_address);
            $('#numberstatus').val(number_status);

            $('input[name="_token"]').val('{{ csrf_token() }}');

            if(status == 'Cancel') {
                var count = 0;
                $('#matchpayment tbody tr').each(function(index, value){
                    count += 1;
                });
                if(count == 0) {
                    Swal.fire({
                        title: 'ยืนยันการยกเลิกหรือไม่?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: ' ใช่ ',
                        cancelButtonText: ' ไม่ ',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            savepaymentfunction();
                        }
                    })
                } else {
                    Swal.fire({
                        title: 'ข้อมูลการชำระเงินนี้มีรายการ Matching ต้องการดำเนินการต่อหรือไม่?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: ' ใช่ ',
                        cancelButtonText: ' ไม่ ',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            savepaymentfunction();
                        }
                    })
                }
            } else {
                var count = 0;
                var payment = 0;
                $('#matchpayment tbody tr').each(function(index, value){
                    count += $(this).find(':checkbox:checked').length;
                });
                $('#tableaddpayment tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
                    var noCommas = value.value.replace(/,/g, '');
                    payment += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
                });

                if(count == 0) {
                    Swal.fire({
                        title: '<span style="font-size: 25px;"> ไม่สามารถ Matching รายการ </span>',
                        html: '<span style="font-size: 18px;"> จำนวนเงินที่ชำระไม่พอดีกับรายการ&nbsp;ระบบจะไม่ทำการ Matching ให้ รบกวนผู้ใช้งานทำการตรวจสอบ</span><br><span style="font-size: 18px;">และ Matching รายการใหม่อีกครั้ง</span>',
                        icon: 'error'
                    });
                } else if(count != 0 && $('input[name="balance_amounts"]').val() > 0 ) {
                    Swal.fire({
                        title: '<span style="font-size: 25px;"> ยืนยันข้อมูลการชำระเงิน </span>',
                        html: '<span style="font-size: 18px;"> จำนวนเงินที่ชำระไม่พอดีกับรายการที่ทำการ maching </span><br><span style="font-size: 18px; margin-top: 10px;">ต้องการทำการยืนยันข้อมูลการชำระเงินหรือไม่ ?</span>',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: ' ใช่ ',
                        cancelButtonText: ' ไม่ ',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            summatch();
                            savepaymentfunction();
                        }
                    })
                }else{
                    savepaymentfunction();
                }
            }
        }
    }

    function savepaymentfunction() {
        var form = $('#submitform').serialize();
        $.ajax({
                url: "{{ route('om.payment-method-paymentverify') }}",
                type: "POST",
                data: form,
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: '<span style="font-weight: bold; font-size: 27px;"> กำลังดำเนินการบันทึก&nbsp;กรุณารอสักครู่ </span>',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(res) {
                    if (res.errors == '') {
                        $('#submitform').submit();
                    } else {
                        if(res.errors == 'มีข้อมูลที่ match Invoice อยู่แล้ว') {
                            Swal.fire({
                                title: res.errors,
                                icon: 'error'
                            });

                            setTimeout(function() {
                                location.href="/om/payment-method/form"
                            }, 1000);
                        }
                        Swal.fire({
                            title: res.errors,
                            icon: 'error'
                        });
                    }
                },
                error: function(error) {
                    Swal.showLoading()
                    if(error.responseText == 'มีข้อมูลที่ match Invoice อยู่แล้ว') {
                        
                        Swal.fire({
                            title: error.responseText,
                            icon: 'error'
                        });

                        setTimeout(function() {
                            location.href="/om/payment-method/form"
                        }, 1000);
                    }
                    Swal.fire({
                        title: error.responseText,
                        icon: 'error'
                    });
                }
            });
    }

    function bankchange(v) {
        var index = v.split(',');
        $('input[name="bank_desc"]').val(banklists[index[1]].bank_branch_name);
    }

    function custchange(v, tableid) {
        $('#matchpayment tbody').html('');
        var invoice_number = $('select[name="invoice_number"] option:selected').val();
        var draft_number = $('select[name="draft_number"] option:selected').val();
        var date_invoice = $('input[name="payment_date"]').val();

        if(date_invoice == '' || date_invoice == null) {
            Swal.fire('แจ้งเตือน','กรุณาเลือกข้อมูลวันที่รับชำระ','warning')
            return false;
        }
        if (v == '' || v == null) {
            $('input[name="type"]').val('');
            $('input[name="customer_name"]').val('');
            $('textarea[name="address"]').val('');
            $('input[name="customer_numbers"]').val('');
            $('input[name="customer_number"]').val('');
            $('input[name="customer_names"]').val('');
        } else {
            var index = _.findIndex(customerlists, function(o) {
                return o.customer_number == v;
            });
            if (tableid == 'tableaddpayment') {
                $('input[name="customer_numbers"]').val(v);
            } else {
                $('input[name="customer_number"]').val(v);
            }
            if (customerlists[index].sales_classification_code.toLowerCase() == 'export') {
                $('input[name="type"]').val('ขายต่างประเทศ');
            } else {
                $('input[name="type"]').val('ขายในประเทศ');
            }
            $('input[name="customer_name"]').val(customerlists[index].customer_name);
            $('input[name="customer_names"]').val(customerlists[index].customer_name);
            var line1;
            var line2;
            var line3;
            var alley;
            var district;
            var city;
            var province;
            var post;

            if (customerlists[index].address_line1 == null) {
                line1 = '';
            } else {
                line1 = customerlists[index].address_line1;
            }
            if (customerlists[index].address_line2 == null) {
                line2 = '';
            } else {
                line2 = customerlists[index].address_line2;
            }
            if (customerlists[index].address_line3 == null) {
                line3 = '';
            } else {
                line3 = customerlists[index].address_line3;
            }
            if (customerlists[index].city == null) {
                city = '';
            } else {
                city = customerlists[index].city;
            }
            if (customerlists[index].district == null) {
                district = '';
            } else {
                district = customerlists[index].district;
            }
            if (customerlists[index].alley == null) {
                alley = '';
            } else {
                alley = customerlists[index].alley;
            }
            if (customerlists[index].province_name == null) {
                province = '';
            } else {
                province = customerlists[index].province_name;
            }
            if (customerlists[index].postal_code == null) {
                post = '';
            } else {
                post = customerlists[index].postal_code;
            }

            $('textarea[name="address"]').val(line1 + ' ' + line2 + ' ' + line3 + ' ' + alley + ' ' + district + ' ' + city + ' ' + province + ' ' + post);

            if (!created) {
                $.ajax({
                    url: "{{ route('om.payment-method-getpaymentnumber') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "valuecustomer": v,
                    },
                    cache: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'กรุณารอสักครู่',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(res) {
                        swal.close();
                        $('#payment_number_ref').html('');
                        var data = res.data;
                        datadn = res.dataordernumbers;
                        datacn = res.defineCN;
                        $.each(data, function(k, v) {
                            $('#payment_number_ref').append('<option>' + v.payment_number + '</option>');
                        });
                        select2auto();
                        if (created) {
                            $('#search').click();
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: error.responseText,
                            icon: 'error'
                        });
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('om.payment-method-getinfofordraft') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "customer_number": v,
                    },
                    cache: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'กรุณารอสักครู่',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(res) {
                        $('input[name="bbalance"]').val(res.amount_before);
                        $('input[name="bbalance_amounts"]').val(res.amount_before);
                        swal.close();
                        // ------------------------------------------------------------
                        // Add default data payment: โอนเงิน 20230213 Piyawut A.
                        $('#tableaddpayment tbody tr').html('');
                        addpayment('tableaddpayment');
                        $("select[name='payment_method[]'] option[value='60,โอนเงิน']").attr("selected", "selected");
                        var e = document.getElementsByName("payment_method[]");
                        getlistdetailbank(e[0]);
                        // ------------------------------------------------------------
                        if (created) {
                            $('#search').click();
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: error.responseText,
                            icon: 'error'
                        });
                    }
                });
            }
        }
    }

    function disableBtn() {
        $('textarea[name="address"]').prop('disabled', true);
        $('input[name="status"]').prop('disabled', true);
        $('input[name="type"]').prop('disabled', true);
        $('input[name="payment_date"]').prop('disabled', true);
    }

    function createFunc() {
        const now = new Date();
        // const result = date.toLocaleDateString('th-Th', {
        //     year: 'numeric',
        //     month: 'numeric',
        //     day: 'numeric'
        // });
        const result = ('0' + (now.getDate())).slice(-2) + "/" + ('0' + (now.getMonth()+1)).slice(-2) + "/" + parseInt(now.getFullYear() + 543);
        $("input").each(function() {
            $(this).val('');
        });
        $('textarea[name="address"]').val('');
        created = true;
        $('#search').attr('disabled', false);

        $('input[name="payment_number"]').prop('disabled', true);
        $('input[name="status"]').val('Draft');
        $('input[name="payment_date"]').prop('disabled', false);
        $('input[name="payment_date"]').val(result);
        // $('input[name="payment_date"]').val(moment().format('L'));
    }

    function autoRownumber(tableid) {
        if (tableid == 'tableaddpayment') {
            $('#' + tableid + ' tbody tr').each(function(a, b) {
                $(b).find('td:eq(0)').html(a + 1);
            });
            $('#ignore').html('<strong class="black">จำนวนเงินรวมที่รับชำระ</strong>');
        } else {
            $('#' + tableid + ' tbody tr').each(function(a, b) {
                $(b).attr('id', a);
                var valuetr = $(b).find('input[name="match_check[]"]').val();
                var result = valuetr.split(":");
                var trueresult = result[0] + ":" + result[1] + ":" + a;
                $(b).find('input[name="match_check[]"]').val(trueresult);
                $('#matchpayment tbody tr:eq(' + a + ') .fa-search').attr('data-whatever', a);
                $('#matchpayment tbody tr:eq(' + a + ') i.modeladd').attr('data-whatever', a);
            });
        }
    }

    function addpayment(tableid) {
        if (tableid == 'matchpayment') {
            $('#matchpayment tbody tr.jsonloopnotfound').each(function(index, value) {
                this.remove();
            });
            var htmloptionstart = '<datalist id="datadn">';
            $.each(datadn, function(key, value) {
                var data = '<option>' + value + '</option>';
                htmloptionstart = htmloptionstart + data;
            });
            var htmloptionend = '</datalist>';
            var htmloptionends = htmloptionstart + htmloptionend;

            $('#' + tableid + ' tbody').append(
                '<tr class="align-middle"><td><div class="input-icon"><input type="text" class="form-control text-center f13" name="doc_id[]" placeholder="" value="" list="datadn" onchange="dnmatch(this,this.value);" autocomplete="off"><i class="fa fa-search"></i>' +
                htmloptionends +
                '</div></td><td><input type="hidden" name="pick_no[]" value=""></td><td><input type="hidden" name="type_product[]" value=""></td><td class="text-right"><input type="hidden" name="amount_vat[]" value=""></td><td><input type="hidden" name="invoice_date[]" value=""></td><td><input type="hidden" name="invoice_duedate[]" value=""></td><td><input type="hidden" name="credit_group[]" value=""></td><td><input type="hidden" name="credit_day[]" value=""></td><td class="text-right"><input type="hidden" name="amount_fines[]" value=""></td><td><div class="input-icon"><input type="text" class="form-control red text-center f13" name="paymatch[]" placeholder="" value="" onchange="summatchnew();" onkeypress="return false;" readonly><i class="fa fa-search modeladd" data-toggle="modal" data-target="#matchCreditModal" data-whatever=""></i></div><input type="hidden" name="amount_match[]" value=""></td><td class="text-right"><input type="hidden" name="amount_balance[]" value=""></td><td><input type="text" class="form-control text-right f13" name="balancetotal[]" placeholder="" value="" onchange="inputbyseft(this,this.value);" onkeyup="countsumpayment();numericonlys(this,this.value);" onkeypress="autoMatchInvoice();"><input type="hidden" name="amount_balancetotal[]" value=""></td><td><input type="checkbox" value="" name="match_check[]" onclick="summatch();"></td><td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this,\'matchpayment\');"></a></td><input type="hidden" name="matchid[]" value=""></tr>'
            );
            autoRownumber(tableid);
        } else {
            var idbank = $('input[name="bank_number"]').val();
            var bankname = $('input[name="bank_desc"]').val();
            // ------------------------------------------------------------
            // Add default data payment: โอนเงิน 20230214 Piyawut A.
            setTimeout(function(){
                // $("select[name='payment_method[]']").append('<option value="60,โอนเงิน" selected></option>').trigger('change');
                // $("select[name='payment_method[]']").last().append('<option value="60,โอนเงิน" selected>โอนเงิน</option>').trigger('change');
                $("select[name='payment_method[]'] option[value='60,โอนเงิน']").last().attr("selected", "selected").trigger('change');

            }, 200);

            // ------------------------------------------------------------
            $('#' + tableid + ' tbody').find("tr:last").before(
                '<tr class="align-middle"><td></td> <td><select onchange="getlistdetailbank(this);" class="form-control" name="payment_method[]" required oninvalid="this.setCustomValidity(\'กรุณาเลือกวิธีการชำระเงิน\')" oninput="setCustomValidity(\'\')"><option value=""></option>@foreach($methods as $method)<option value="{{ $method->lookup_code }},{{ $method->meaning }}">{{ $method->description }}</option>@endforeach</select></td><td><select class="form-control select2-payment_desc_number_bank" name="payment_desc_number_bank[]" onchange="changeBankdesc(this);" onload="changeBankdesc(this);"></select></td><td><input type="text" placeholder="" name="payment_amount[]" value="" class="form-control md text-right" autocomplete="off" onchange="tofixed2(this,this.value);" onkeyup="countsumpayment();numericonly(this,this.value);" onkeypress="autoMatchInvoice();"><input type="hidden" name="total_payment_amount[]" value=""></td> <td class="text-center"><a href="javascript:void(0)" class="fa fa-times red" onclick="deleteRow(this,\'' +
                tableid + '\');"></a></td></tr>');
            autoRownumber(tableid);
        }
        $('.select2-payment_desc_number_bank').select2({
            matcher: function(parm, data) {
                try {
                    if(typeof parm.term == "undefined") {
                        return data
                    }

                    if ($.trim(parm.term) === data.element.attributes['data-bank_number'].value) {
                        return data;
                    }
                    return null
                } catch (error) {
                    return data
                    
                }
               
            }
        });
    }

    function autoMatchInvoice() {
        var total = 0;
        var totals = 0;
        var myTimeout;
        $('#tableaddpayment tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
            var noCommas = value.value.replace(/,/g, '')
            totals = total += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
            $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="total_payment_amount[]"]').val(
                noCommas);
        });
        $('#matchpayment tbody tr').each(function(index, value) {
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="match_check[]"]').prop('checked', false);
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').prop('disabled', false);
            summatch();
        });

        if (total > 0) {
            // Check total is not equal 0
            $('#matchpayment tbody tr').each(function(index, value) {
                if (totals > 0) {
                    var noCommas = $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balance[]"]').val().replace(/,/g, '');
                    if (parseFloat(total) && parseFloat(noCommas) > 0) {
                        totals -= parseFloat(noCommas);
                    }
                }
            });
            if (totals == 0) {
                let date1 = new Date({{ date('Y-m-d') }}).getTime();
                // clearTimeout(myTimeout);
                // myTimeout = setTimeout(() => {
                    $('#matchpayment tbody tr').each(function(index, value) {
                        if (date1 <= new Date($('#matchpayment tbody tr:eq(' + index + ')').find('input[name="invoice_duedate[]"]').val()).getTime()) {
                            if (total > 0) {
                                var noCommas = $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balance[]"]').val().replace(/,/g, '');
                                if (parseFloat(total) && parseFloat(noCommas) > 0) {
                                    $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="match_check[]"]').prop('checked', true);
                                    total -= parseFloat(noCommas);
                                } else {
                                    $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="match_check[]"]').prop('checked', false);
                                }
                            }
                        }
                    });
                    summatch();
                // }, 5000);
            }
        } else {
            summatch();
        }
    }

    function inputbyseft(k,v){
        setTimeout(function() {
            var rowjQuery = $(k).closest("tr");
            var index = rowjQuery[0].rowIndex - 1;

            var r = $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val().replace(/,/g, '');


            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balancetotal[]"]').val($.number(v,2));
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val($.number(v,2));
        },1000);
    }

    function addCommas(nStr) {
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

    function tofixed2(k,v) {
        setTimeout(function() {
            var rowjQuery = $(k).closest("tr");
            var index = rowjQuery[0].rowIndex - 1;

            var r = $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val().replace(/,/g, '');


            $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val($.number(v,2));
        },1000);
    }

    function numericonly(v, l) {
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val(l.replace(/[^0-9\.|\,]/g, ''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }

        var currentVal = l;
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
            currentVal = currentVal.slice(0, -1);
        }
        $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val(replaceCommas(currentVal));
    }

    function testDecimals(currentVal) {
        var count;
        currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
        return count;
    }

    function replaceCommas(yourNumber) {
        var components = yourNumber.toString().split(".");
        if (components.length === 1)
            components[0] = yourNumber;
        components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if (components.length === 2)
            components[1] = components[1].replace(/\D/g, "");
        return components.join(".");
    }

    function numericonlys(v, l) {
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val(l.replace(/[^0-9\.|\,]/g, ''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }
    }

    function deleteRow(element, tableid) {
        var rowjQuery = $(element).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#' + tableid + ' tbody').find('tr:eq(' + index + ')').remove();
        if (tableid == 'tableaddpayment') {
            countsumpayment();
            autoMatchInvoice();
        } else {
            summatch();
        }
        autoRownumber(tableid);
    }

    function countsumpayment() {
        var total = 0;
        $('#tableaddpayment tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
            var noCommas = value.value.replace(/,/g, '')
            total += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
            $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="total_payment_amount[]"]').val(
                noCommas);
        });
        $('#total').html('<strong class="black">' + addCommas(total.toFixed(2)) + '</strong>');
    }

    function summatchnew() {
        $('#matchpayment tbody tr').each(function(index, value) {
            // cnmatch
            // var noCammastotal = $('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').text();
            var noCammastotal = $('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').find('input[name="amount_vat[]"]').val();
            var noCammastotalpay = $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="paymatch[]"]').val();
            var number1 = isNaN(parseFloat(noCammastotalpay.replace(/,/g, ''))) ? 0 : parseFloat(noCammastotalpay.replace(/,/g, ''));
            var number2 = isNaN(parseFloat(noCammastotal.replace(/,/g, ''))) ? 0 : parseFloat(noCammastotal.replace(/,/g, ''));
            var sum = number2 - number1;
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val(addCommas(sum.toFixed(2)));
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balancetotal[]"]').val(sum.toFixed(2));
            $('#matchpayment tbody tr:eq(' + index + ') td:eq(10)').text(addCommas(sum.toFixed(2)));
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balance[]"]').val(sum.toFixed(2));
        });
    }

    function summatch() {
        var total = 0;
        var payamount = 0;
        var match_amount = 0;
        var paymentvat = 0;
        var indexcheck = 0;
        var payment = 0;
        var finesamount = 0;
        $('input[name="balance"]').val('0.00');
        $('input[name="balance_amounts"]').val('0.00');
        // $('input[name="bbalance"]').val('0.00');
        // $('input[name="bbalance_amounts"]').val('0.00');

        $('#tableaddpayment tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
            var noCommas = value.value.replace(/,/g, '');
            payment += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
            // if (total != 0) {
            //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').prop(
            //         'disabled', true);
            // } else {
            //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').prop(
            //         'disabled', false);
            // }
        });


        $('#matchpayment tbody tr td input[name="match_check[]"]').each(function(index, value) {
            var splitStr = value.value.split(':');
            if (this.checked) {
                var noCammasPayamount = $('#matchpayment tbody tr:eq(' + index + ') td:eq(8)').find('input[name="amount_fines[]"]').val();
                var noCammasmatch_amount = $('#matchpayment tbody tr:eq(' + index + ')').find(
                    'input[name="paymatch[]"]').val();
                // var nopaymentvat = $('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').text().replace(/,/g,
                //     '');
                var nopaymentvat = $('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').find('input[name="amount_vat[]"]').val().replace(/,/g,'');
                var npCommastotal = $('#matchpayment tbody tr:eq(' + index + ')').find(
                    'input[name="balancetotal[]"]').val().replace(/,/g, '');
                paymentvat += isNaN(parseFloat(nopaymentvat)) ? 0 : parseFloat(nopaymentvat);
                total += isNaN(parseFloat(npCommastotal)) ? 0 : parseFloat(npCommastotal);
                payamount += isNaN(parseFloat(noCammasPayamount.replace(/,/g, ''))) ? 0 : parseFloat(
                    noCammasPayamount.replace(/,/g, ''));
                match_amount += isNaN(parseFloat(noCammasmatch_amount.replace(/,/g, ''))) ? 0 : parseFloat(
                    noCammasmatch_amount.replace(/,/g, ''));
                indexcheck = index;
                if (splitStr[1] == "DRAFT") {
                    if (idorders.indexOf(splitStr[0]) == -1) {
                        idorders.push(splitStr[0]);
                    } else {
                        // paymentvat -= isNaN(parseFloat(nopaymentvat)) ? 0 : parseFloat(nopaymentvat);
                    }
                } else {
                    if (addfines.indexOf(splitStr[0]) == -1) {
                        addfines.push(splitStr[0]);
                    }
                }

                if (splitStr[1] == "INVOICE") {
                    var nocommasfines = $('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').find('input[name="amount_vat[]"]').val().replace(
                        /,/g, '');
                    finesamount += isNaN(parseFloat(nocommasfines)) ? 0 : parseFloat(nocommasfines);
                    if (idinvoices.indexOf(splitStr[0]) == -1) {
                        idinvoices.push(splitStr[0]);
                    } else {
                        // paymentvat -= isNaN(parseFloat(nopaymentvat)) ? 0 : parseFloat(nopaymentvat);
                    }
                } else {
                    if (idinvoices.indexOf(splitStr[0]) == -1) {
                        idinvoices.push(splitStr[0]);
                    }
                }
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="paymatch[]"]').prop('disabled',
                    true);
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').prop(
                    'disabled', true);

                if (total > payment && (payment - total) < 0) {
                    var d = total - payment;
                    var T = npCommastotal - d;
                    if (T < 0) {
                        var dT = 0;
                    } else {
                        var dT = T;
                    }
                    $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val(addCommas(dT.toFixed(2)));
                    $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balancetotal[]"]').val(addCommas(dT.toFixed(2)));
                    // $('#matchpayment tbody tr td input[name="match_check[]"]').each(function(index2, value2) {
                    //     if (!this.checked) {
                    //         $('#matchpayment tbody tr:eq(' + index2 + ')').find(
                    //             'input[name="match_check[]"]').prop('disabled', true);
                    //     }
                    // });
                    var totals = total - d;
                    var aftercount = payment - totals;

                    Swal.fire({
                        title: 'จำนวนเงินที่ชำระถูกปรับให้เท่ายอดเงินคงเหลือที่สามารถชำระได้',
                        icon: 'warning'
                    });
                } else {
                    var totals = total;
                    var aftercount = payment - totals;

                }

                $('input[name="totalvat"]').val(addCommas(paymentvat.toFixed(2)));
                $('input[name="totalvat_amounts"]').val(paymentvat.toFixed(2));
                $('input[name="paycount"]').val(addCommas(payamount.toFixed(2)));
                $('input[name="paycount_amounts"]').val(payamount.toFixed(2));
                $('input[name="match_count"]').val(addCommas(match_amount.toFixed(2)));
                $('input[name="match_count_amounts"]').val(match_amount.toFixed(2));
                $('input[name="total"]').val(addCommas(totals.toFixed(2)));
                $('input[name="total_amounts"]').val(totals.toFixed(2));
                $('input[name="balance"]').val(addCommas(aftercount.toFixed(2)));
                $('input[name="balance_amounts"]').val(aftercount.toFixed(2));
                $('input[name="matchamount"]').val(addCommas(finesamount.toFixed(2)));
                $('input[name="matchamount_amounts"]').val(finesamount.toFixed(2));
            } else {
                if (splitStr[1] == "DRAFT") {
                    var idindex = idorders.indexOf(splitStr[0]);
                    idorders.splice(idindex, 1);
                } else {
                    var idindexx = addfines.indexOf(splitStr[0]);
                    addfines.splice(idindexx, 1);
                }

                if (splitStr[1] == "INVOICE") {
                    var idindex = idinvoices.indexOf(splitStr[0]);
                    idinvoices.splice(idindex, 1);
                } else {
                    var idindexx = idinvoices.indexOf(splitStr[0]);
                    idinvoices.splice(idindexx, 1);
                }
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="paymatch[]"]').prop('disabled',
                    false);
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').prop(
                    'disabled', false);
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val($(
                    '#matchpayment tbody tr:eq(' + index + ') td:eq(10)').text());
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balancetotal[]"]').val($(
                    '#matchpayment tbody tr:eq(' + index + ') td:eq(10)').text());
            }
        });

        if ($('#matchpayment tbody tr td input[name="match_check[]"]:checked').length > 0) {
            $('#tableaddpayment tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
                // if (total != 0) {
                //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]')
                //         .prop('disabled', true);
                // } else {
                //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]')
                //         .prop('disabled', false);
                // }
            });
        } else {
            var b = $('#total .black').text().replace(/,/g,'');
            $('input[name="totalvat"]').val('0.00');
            $('input[name="totalvat_amounts"]').val('0.00');
            $('input[name="match_count"]').val('0.00');
            $('input[name="match_count_amounts"]').val('0.00');
            $('input[name="paycount"]').val('0.00');
            $('input[name="paycount_amounts"]').val('0.00');
            $('input[name="total"]').val('0.00');
            $('input[name="total_amounts"]').val('0.00');
            $('input[name="matchamount"]').val('0.00');
            $('input[name="matchamount_amounts"]').val('0.00');
            $('input[name="balance"]').val(addCommas(parseFloat(b).toFixed(2)));
            $('input[name="balance_amounts"]').val(parseFloat(b).toFixed(2));
        }
    }

    $('#matchCreditModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('whatever');
        $('#recipientid').val(recipient);
    });

    function cnmatch(element) {
        var total = 0;
        var rowjQuery = $(element).closest("tr");
        var indextr = rowjQuery[0].rowIndex - 1;
        $('#cn tbody tr').find('input[name="cnmatch[]"]').each(function(index, value) {
            if(this.checked){
                var nocom = $('#cn tbody tr:eq(' + index + ') td:eq(2)').text().replace(/,/g, '');
                total += isNaN(parseFloat(nocom)) ? 0 : parseFloat(nocom);
            }
        });
        $('#recipientidsum').html('<strong class="black">' + addCommas(total.toFixed(2)) + '</strong>');
    }

    function confirmcn() {
        var idcnmatch = [];
        var total = 0;
        $('#cn tbody tr').find('input[name="cnmatch[]"]').each(function(index, value) {
            if(this.checked){
                var nocom = $('#cn tbody tr:eq(' + index + ') td:eq(2)').text().replace(/,/g, '');
                total += isNaN(parseFloat(nocom)) ? 0 : parseFloat(nocom);
                idcnmatch.push(value.value);
            }
        });
        var idreindex = $('#recipientid').val();
        $('#matchpayment tbody tr:eq(' + idreindex + ')').find('input[name="paymatch[]"]').val(addCommas(total.toFixed(
            2)));
        $('#matchpayment tbody tr:eq(' + idreindex + ')').find('input[name="amount_match[]"]').val(total.toFixed(2));
        $('#matchpayment tbody tr:eq(' + idreindex + ')').find('input[name="matchid[]"]').val(idcnmatch);
        summatchnew();
        $("#matchCreditModal").modal("hide");
    }

    function dnmatchfromcredit(element, v, c) {
        if (v == null || v == '' || c == null || c == '') {
            return;
        } else {
            var customer_number = $('input[name="customer_numbers"]').val();
            $.ajax({
                url: "{{ route('om.payment-method-getvaluefromnumber') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "number": v,
                    "customer_number": customer_number,
                    "credit_code": c
                },
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กรุณารอสักครู่',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(res) {
                    if (res.status == 'success') {
                        var datas = res.data;
                        var rowjQuery = $(element).closest("tr");
                        var indextr = rowjQuery[0].rowIndex - 1;
                        var invoice_amount = parseFloat(datas.total_amount);

                        $('input[name="bbalance"]').val(datas.beforeamount);
                        $('input[name="bbalance_amounts"]').val(datas.beforeamount);

                        if(checkinputvalue(element,datas)){
                            Swal.fire({
                                title: 'รายการดังกล่าวได้แสดงในตารางรายการแล้ว',
                                icon: 'error'
                            });
                        } else {
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(1)').text(datas.pick_release_no);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(1)').append(
                                '<input type="hidden" name="pick_no[]" value="' + datas.pick_release_no + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(2)').text(datas.description);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(2)').append(
                                '<input type="hidden" name="type_product[]" value="' + datas.description + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(3)').text(addCommas(invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(3)').append(
                                '<input type="hidden" name="amount_vat[]" value="' + invoice_amount.toFixed(2) + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(4)').text(datas.order_date2);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(4)').append(
                                '<input type="hidden" name="invoice_date[]" value="' + datas.order_date1 + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(5)').text(datas.payment_duedate2);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(5)').append(
                                '<input type="hidden" name="invoice_duedate[]" value="' + datas.payment_duedate1 + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(6)').text(datas.credit_group2);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(6)').append(
                                '<input type="hidden" name="credit_group[]" value="' + datas.credit_group1 + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(7)').text(datas.due_days);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(7)').append(
                                '<input type="hidden" name="credit_day[]" value="' + datas.due_days + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(8)').text(datas.amount_fines);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(8)').append(
                                '<input type="hidden" name="amount_fines[]" value="' + datas.amount_fines + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="paymatch[]"]').val('');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="amount_match[]"]').val('0.00');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(10)').text(addCommas(invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(10)').append(
                                '<input type="hidden" name="amount_balance[]" value="' + invoice_amount.toFixed(2) + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="balancetotal[]"]').val(addCommas(
                                invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="amount_balancetotal[]"]').val(invoice_amount
                                .toFixed(2));
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="match_check[]"]').val(datas
                                .order_header_id + ':DRAFT:' + indextr);
                            $('#matchpayment tbody tr:eq(' + indextr + ') i.modeladd').attr('data-whatever', indextr);
                            swal.close();
                        }
                    }
                },
                error: function(error) {
                    Swal.fire({
                        title: error.responseText,
                        icon: 'error'
                    });
                }
            });
        }
    }

    function dnmatch(element, v) {
        if (v == null || v == '') {
            return;
        } else {
            var customer_number = $('input[name="customer_numbers"]').val();
            $.ajax({
                url: "{{ route('om.payment-method-getvaluefromnumber') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "number": v,
                    "customer_number": customer_number
                },
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กรุณารอสักครู่',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(res) {
                    if (res.status == 'choose') {
                        var darares = res.data;
                        var myArrayOfThings = darares;

                        var options = {};
                        $.map(myArrayOfThings,
                            function(o) {
                                if (o.credit_group_code == 0) {
                                    options[o.credit_group_code] = 'เงินสด';
                                } else {
                                    options[o.credit_group_code] = o.credit_group_code;
                                }
                            });
                        Swal.fire({
                            title: 'เลือกกลุ่มวงเงินเอกสารเลขที่ ' + v,
                            input: 'select',
                            inputOptions: options,
                            inputPlaceholder: 'กรุณาเลือกกลุ่มวงเงิน',
                            showCancelButton: true,
                            inputValidator: function(value) {
                                return new Promise(function(resolve, reject) {
                                    if (value !== '') {
                                        resolve();
                                    } else {
                                        resolve('กรุณาเลือกกลุ่มวงเงิน');
                                    }
                                });
                            }
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                dnmatchfromcredit(element, v, result.value);
                            }
                        });
                    } else {
                        var datas = res.data;
                        var rowjQuery = $(element).closest("tr");
                        var indextr = rowjQuery[0].rowIndex - 1;
                        var invoice_amount = parseFloat(datas.total_amount);

                        $('input[name="bbalance"]').val(datas.beforeamount);
                        $('input[name="bbalance_amounts"]').val(datas.beforeamount);

                        if(checkinputvalue(element,datas)){
                            Swal.fire({
                                title: 'รายการดังกล่าวได้แสดงในตารางรายการแล้ว',
                                icon: 'error'
                            });
                        } else {
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(1)').text(datas.pick_release_no);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(1)').append(
                                '<input type="hidden" name="pick_no[]" value="' + datas.pick_release_no + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(2)').text(datas.description);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(2)').append(
                                '<input type="hidden" name="type_product[]" value="' + datas.description + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(3)').text(addCommas(invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(3)').append(
                                '<input type="hidden" name="amount_vat[]" value="' + invoice_amount.toFixed(2) + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(4)').text(datas.order_date2);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(4)').append(
                                '<input type="hidden" name="invoice_date[]" value="' + datas.order_date1 + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(5)').text(datas.payment_duedate2);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(5)').append(
                                '<input type="hidden" name="invoice_duedate[]" value="' + datas.payment_duedate1 + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(6)').text(datas.credit_group2);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(6)').append(
                                '<input type="hidden" name="credit_group[]" value="' + datas.credit_group1 + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(7)').text(datas.due_days);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(7)').append(
                                '<input type="hidden" name="credit_day[]" value="' + datas.due_days + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(8)').text(datas.amount_fines);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(8)').append(
                                '<input type="hidden" name="amount_fines[]" value="' + datas.amount_fines + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="paymatch[]"]').val('');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="amount_match[]"]').val('0.00');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(10)').text(addCommas(invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(10)').append(
                                '<input type="hidden" name="amount_balance[]" value="' + invoice_amount.toFixed(2) + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="balancetotal[]"]').val(addCommas(
                                invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="amount_balancetotal[]"]').val(invoice_amount
                                .toFixed(2));
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="match_check[]"]').val(datas
                                .order_header_id + ':DRAFT:' + indextr);
                            $('#matchpayment tbody tr:eq(' + indextr + ') i.modeladd').attr('data-whatever', indextr);
                            swal.close();
                        }
                    }
                },
                error: function(error) {
                    Swal.fire({
                        title: error.responseText,
                        icon: 'error'
                    });
                }
            });
        }
    }

    function checkinputvalue(element,datas) {
        var status;
        var rowjQuery = $(element).closest("tr");
        var indextr = rowjQuery[0].rowIndex - 1;
        $('#matchpayment tbody tr').find('input[name="doc_id[]"]').not(':last').each(function(indexcheck,valuecheck){
            var creditg = $('#matchpayment tbody tr:eq(' + indexcheck + ') td:eq(6)').find('input[name="credit_group[]"]').val();
            var docid = $('#matchpayment tbody tr:eq(' + indexcheck + ') td:eq(0)').find('input[name="doc_id[]"]').val();
            if((docid == datas.prepare_order_number) && (creditg == datas.credit_group1)){
                $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(0)').find('input[name="doc_id[]"]').val('');
                status = 'NOT';
            }
        });
        if(status == null || status == ''){
            status = 'OK';
        }
        if(status == 'NOT'){
            return true;
        } else {
            return false;
        }
    }

    function changeDate() {
        if(created && $('input[name="customer_number"]').val() != '') {
            searchDPayment();
        }
    }

    function searchDPayment() {
        try {
            $('.select2-payment_desc_number_bank').select2('destroy')
        } catch (error) {
            
        }

        $('#add').prop('disabled', true);
        var customer_number = $('input[name="customer_number"]').val();
        // var invoice_number = $('select[name="invoice_number"] option:selected').val();
        // var draft_number = $('select[name="draft_number"] option:selected').val();
        // var invoice_date = $('input[name="invoice_date_number"]').val();
        var sum_amont_total = $('#total .black').text();
        var payment_date = $('#input_date').val();
        $('#matchpayment tbody tr.jsonloop').each(function(index, value) {
            this.remove();
        });
        summatch();
        $.ajax({
            url: "{{ request()->getSchemeAndHttpHost() }}/om/payment-method/draftpayment",
            type: "POST",
            crossDomain: true,
            data: {
                "_token": "{{ csrf_token() }}",
                "customer_number": customer_number,
                "total_amount": sum_amont_total,
                "payment_date": payment_date,
                // "invoice_number": invoice_number,
                // "draft_number": draft_number,
                // "invoice_date": invoice_date
            },
            cache: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'กำลังดำเนินการรวบรวมข้อมูล',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res) {
                if (res.status == 'error') {
                    Swal.fire({
                        title: res.msg,
                        icon: 'error'
                    });
                } else {
                    $('#add').prop('disabled', false);
                    @if(Request::old('callback_search'))
                        if (res.data != '<tr class=\"align-middle jsonloopnotfound\"><td colspan=\"14\" class=\"text-danger text-center\">ไม่พบข้อมูลหนี้ค้างชำระ</td></tr>') {
                            $("#matchpayment tbody").append(res.data);
                        }
                    @else
                        $("#matchpayment tbody").html(res.data);
                    @endif
                    // $('input[name="bbalance"]').val(res.amount_before);
                    // $('input[name="bbalance_amounts"]').val(res.amount_before);
                    $('#cn tbody').html('');
                    datacn = res.cn;
                    // datadn = res.dn;
                    var preparenumber = res.dataordernumbers;
                    var invoicenumber = res.datainvoices;
                    $.each(datacn, function(key, value) {
                        $('#cn tbody').append('<tr><td><input type="checkbox" value="' + value
                            .invoice_headers_id +
                            '" name="cnmatch[]" onchange="cnmatch(this);"></td><td>' + value
                            .invoice_headers_number +
                            '</td><td class="text-right">' + addCommas(parseFloat(value
                                .invoice_amount).toFixed(2)) + '</td></tr>');
                    });
                    $('#cn tbody').append(
                        '<tr id="totalinvoicesumamount"><td colspan="2"><strong class="black">รวม</strong></td><td class="text-right" id="recipientidsum"><strong class="black">0.00</strong></td></tr>'
                    );

                    if(res.popup){
                        Swal.fire({
                            title: res.popupmsg,
                            icon: 'error'
                        });
                    } else {
                        swal.close();
                    }
                    // summatchnew();
                    select2auto();
                    summatch();
                    setTimeout(function(){
                        $('.select2-payment_desc_number_bank').select2({
                            matcher: function(parm, data) {
                                try {
                                    if(typeof parm.term == "undefined") {
                                        return data
                                    }

                                    if ($.trim(parm.term) === data.element.attributes['data-bank_number'].value) {
                                        return data;
                                    }
                                    return null
                                } catch (error) {
                                    return data
                                    
                                }
                            
                            }
                        });
                    }, 500);
                    
                }
            },
            error: function(error) {
                Swal.fire({
                    title: error.responseText,
                    icon: 'error'
                });
            }
        });
        
    }
</script>
<script>
    $(function() {
        $(document).on('change', '[name="payment_desc_number_bank[]"]', function(e) {
            var el = $(this);
            el.parents('tr').find('[name="number_payment[]"]').val(el.find('option:selected').attr('data-bank_account_number'));
            el.parents('tr').find('[name="bank_code[]"]').val(el.find('option:selected').attr('data-bank_number'));
        })
        
            $('.select2-payment_desc_number_bank').select2({
                matcher: function(parm, data) {
                    if(typeof parm.term == "undefined") {
                        return data
                    }

                    if ($.trim(parm.term) === data.element.attributes['data-bank_number'].value) {
                        return data;
                    }
                    return null
                }
            });
        
    })
</script>
@endsection
