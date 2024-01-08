@extends('layouts.app')

@section('title', 'บันทึกข้อมูลการชำระเงิน สำหรับขายต่างประเทศ')

@section('custom_css')
    <link rel="stylesheet" href="{!! asset('css/aksFileUpload.min.css') !!}" />
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('jquery-ui.css') !!}" rel="stylesheet">
    <style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
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

    .swal2-container {
        z-index: 9999 !important;
    }
    #page-wrapper {
        width: calc(100% - 220px) !important;
    }
</style>
@stop

@section('page-title')
    <h2>
        {{-- <x-get-program-code url="/om/export-payout" /> บันทึกข้อมูลการชำระเงิน สำหรับขายต่างประเทศ --}}
        <x-get-page-title menu="" url="/om/export-payout" />
    </h2>
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/export-payout" /> บันทึกข้อมูลการชำระเงิน สำหรับขายต่างประเทศ</strong>
        </li>
    </ol> --}}
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>บันทึกข้อมูลการชำระเงิน สำหรับขายต่างประเทศ</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-12">
                    <div class="form-header-buttons">
                        <div class="buttons multiple">
                            <button class="btn btn-md btn-white" type="button" onclick="resetpage();"><i class="fa fa-refresh"></i> ล้างข้อมูล</button>
                            <button class="btn btn-md btn-success" type="button" onclick="createFunc();" id="createbtn" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') disabled @endif @endif><i class="fa fa-plus"></i> สร้าง</button>
                            <button class="btn btn-md btn-white" type="button" id="searchbtn"><i class="fa fa-search"></i> ค้นหา</button>
                            <button class="btn btn-md btn-success" data-toggle="modal" data-target="#UploadModalFile" type="button" id="fileattachment"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                            <button class="btn btn-md btn-danger" type="button" id="cancelbtn" onclick="savepayment('Cancel');"><i class="fa fa-times"></i> ยกเลิก
                            </button>
                            <button class="btn btn-md btn-info" type="button" id="confirmbtn" onclick="savepayment('Confirm');"><i class="fa fa-check"></i> ยืนยันข้อมูล
                            </button>
                            <a class="btn btn-md btn-warning" type="button" id="printbtn" @if(Request::old('callback_search_omp67')) href="{{ route('om.export-method-print',['type' => 'print', 'id' => Request::old('payment_number')]) }}" target="_blank" @else href="" @endif><i class="fa fa-print" style="padding-top: 10px;"></i> พิมพ์ใบเสร็จรับเงิน
                            </a>
                            @if(optional($infodata)->payment_status == 'Cancel' || optional($infodata)->payment_status == 'Confirm') 
                                <button class="btn btn-md btn-info" type="button" id="confirmbtn" onclick="savepayment('SaveMemo');"><i class="fa fa-check"></i> บันทึกหมายเหตุ
                                </button>
                            @endif
                            {{-- <div class="dropdown">
                                <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button" id="command">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                                <ul class="dropdown-menu">
                                    <!-- <li><a href="javascript:void(0);" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') @else onclick="savepayment1('Draft');" @endif @else onclick="savepayment('Draft');" @endif>บันทึก</a></li> -->
                                    <li><a href="javascript:void(0);" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm' || $infodata->payment_status == 'Cancel') @else onclick="savepayment('Confirm');" @endif @else onclick="savepayment('Confirm');" @endif>ยืนยันข้อมูล</a></li>
                                    <li><a href="javascript:void(0);" onclick="savepayment('Cancel');">ยกเลิก</a></li>
                                    <li><a @if(Request::old('callback_search_omp67')) href="{{ route('om.export-method-print',['id' => Request::old('payment_number')]) }}" @else href="#" @endif target="_blank">พิมพ์ใบเสร็จรับเงิน</a></li>
                                </ul>
                            </div> --}}

                        </div>
                    </div><!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>
                </div><!--col-12-->

                <div class="col-xl-12 m-auto">
                    <form method="get" autocomplete="off" id="searchnumber">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="d-block">เลขที่ใบเสร็จรับเงิน</label>
                                <input type="text" class="form-control" name="payment_number" placeholder=""
                                @if(Request::old('callback_save'))
                                value="{{ Request::old('number_payment_invoice') }}"
                                @else
                                value="{{ Request::old('payment_number') }}"
                                @endif
                                @if(Request::old('callback_save') || Request::old('callback_search_omp67')) readonly
                                @endif list="payment_number_ref">
                                <datalist id="payment_number_ref">
                                    @foreach ($paymenynumberref as $ref)
                                        <option value="{{ $ref->payment_number }}">{{ FormatDate::DateThai($ref->payment_date) }}:{{ $ref->customer_name }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="d-block">วันที่รับชำระ</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="payment_date" placeholder="" @if(Request::old('callback_save'))
                                    value="{{ Request::old('number_payment_date') }}"
                                    @else
                                    @if(Request::old('callback_search_omp67'))
                                    value="{{ \Carbon\Carbon::parse($infodata->payment_date)->format('d/m/Y') }}"
                                    @else value=""
                                    @endif
                                    @endif
                                    @if(Request::old('callback_save') ||
                                    Request::old('callback_search_omp67')) readonly @endif>
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div><!--form-group-->
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="d-block">Status</label>
                                <input type="text" class="form-control" name="status" placeholder="" @if(Request::old('callback_save'))
                                value="{{ Request::old('number_payment_status') }}"
                                @else
                                @if(Request::old('callback_search_omp67')) value="{{ $infodata->payment_status }}"
                                @else value=""
                                @endif
                                @endif
                                @if(Request::old('callback_save') ||
                                Request::old('callback_search_omp67')) readonly @endif>
                            </div><!--form-group-->
                        </div>

                        {{-- <div class="col-lg-3 col-md-6">
                            <div class="form-group"> --}}
                                {{-- <label class="d-block">ประเภทการขาย</label> --}}
                                <input type="hidden" class="form-control red" name="type" placeholder="" @if(Request::old('callback_save'))
                                value="{{ Request::old('number_payment_type') }}"
                                @else
                                @if(Request::old('callback_search_omp67'))
                                @if(strtoupper($infodata->sales_classification_code) == 'DOMESTIC')
                                    value="ขายในประเทศ"
                                    @else value="ขายต่างประเทศ"
                                    @endif
                                    @endif
                                    @endif
                                    @if(Request::old('callback_save') || Request::old('callback_search_omp67')) readonly
                                    @endif>
                            {{-- </div><!--form-group-->
                        </div> --}}

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="d-block">รหัสลูกค้า</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="customer_number" placeholder="" @if(Request::old('callback_save'))
                                            value="{{ Request::old('number_payment_customer') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67'))
                                            value="{{ $infodata->customer->customer_number }}"
                                            @else value=""
                                            @endif
                                            @endif list="customer_number"
                                            onchange="custchange(this.value,'tableaddpayment');">
                                            <i class="fa fa-search"></i>
                                            <datalist id="customer_number">
                                                @foreach ($customers as $customer)
                                                <option value="{{ $customer->customer_number }}">
                                                    {{ $customer->customer_name }}
                                                </option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mt-2 mt-md-0">
                                        <input type="text" class="form-control" disabled name="customer_name" placeholder="" @if(Request::old('callback_save'))
                                        value="{{ Request::old('number_payment_customer_name') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67'))
                                        value="{{ $infodata->customer->customer_name }}"
                                        @else value=""
                                        @endif
                                        @endif>
                                    </div>
                                </div><!--row-->
                            </div><!--form-group-->
                        </div>

                        <div class="col-12"></div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="d-block">ที่อยู่</label>
                                @if(Request::old('callback_search_omp67'))
                                    @if($infodata->customer->country_code == 'TH')
                                        <textarea class="form-control" name="address" readonly>{{ $infodata->customer->address_line1 }} {{ $infodata->customer->alley }} {{ $infodata->customer->district }} {{ $infodata->customer->city }} {{ $infodata->customer->province_name }} {{ $infodata->customer->postal_code }} {{ $infodata->customer->country_name }}</textarea>
                                    @else
                                        <textarea class="form-control" name="address" readonly>{{ $infodata->customer->address_line1 }} {{ $infodata->customer->address_line2 }} {{ $infodata->customer->address_line3 }} {{ $infodata->customer->state }} {{ $infodata->customer->city }} {{ $infodata->customer->postal_code }} {{ $infodata->customer->country_name }}</textarea>
                                    @endif
                                @else
                                    <textarea class="form-control" name="address" readonly>@if(Request::old('callback_save')) {{ Request::old('number_payment_address') }} @else @if(Request::old('callback_search_omp67')) {{ $infodata->customer->address_line1 ?? '' }} {{ $infodata->customer->address_line2 ?? '' }} {{ $infodata->customer->address_line3 ?? '' }} {{ $infodata->customer->province_name ?? '' }} @endif @endif</textarea>
                                @endif
                            </div><!--form-group-->
                        </div>

                        <input type="hidden" name="currency" value="">

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="d-block">หมายเหตุ</label>
                                <input type="text" class="form-control" name="remark" placeholder="" @if(Request::old('callback_save'))
                                value="{{ Request::old('number_payment_remart') }}"
                                @else
                                @if(Request::old('callback_search_omp67')) value="{{ $infodata->remark }}"
                                @else
                                value=""
                                @endif
                                @endif>
                            </div><!--form-group-->
                        </div>

                        {{-- <div class="col-lg-8">
                            <div class="form-group">
                                <label class="d-block">ค่าธรรมเนียมธนาคาร</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" name="fines" onkeyup="numericonly(this,this.value);" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('number_payment_fines') }}"
                                    @else
                                    @if(Request::old('callback_search_omp67'))
                                    value="{{ number_format($infodata->paymentMethod[0]->rate_fee ?? 0,2) }}"
                                    @else value=""
                                    @endif
                                    @endif>
                                    <span class="d-block pl-3">บาท</span>
                                </div> --}}
                            {{-- </div><!--form-group--> --}}
                        {{-- </div> --}}
                    </div><!--row-->
                </form>

                </div><!--col-xl-6-->
            </div>

            @if(Request::old('callback_search_omp67'))
            <form action="{{ route('om.export-method-matchsave') }}" method="POST" id="submitform" enctype="multipart/form-data">
            @else
            <form action="{{ route('om.export-method-payment') }}" method="POST" id="submitform" enctype="multipart/form-data">
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
                    <input type="hidden" name="number_payment_fines" id="numberpaymentfines" value="" />
                    <input type="hidden" name="payment_number" id="paymentnumber" value="" />


                <div class="col-md-12">
                    <hr class="lg">

                    <!-- <div class="row"> -->
                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                <label class="d-block">รหัสลูกค้า</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-icon">
                                            <input type="text" class="form-control md text-center" name="customer_numbers" placeholder="" @if(Request::old('callback_save'))
                                            value="{{ Request::old('customer_numbers') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67'))
                                            value="{{ $infodata->customer->customer_number }}"
                                            @else value=""
                                            @endif
                                            @endif list="customer_numbers" onchange="custchange(this.value,'');">
                                            <i class="fa fa-search"></i>
                                            <datalist id="customer_numbers">
                                                @foreach ($customers as $customer)
                                                <option value="{{ $customer->customer_number }}">
                                                    {{ $customer->customer_name }}
                                                </option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" disabled="" name="customer_names" placeholder="" @if(Request::old('callback_save'))
                                        value="{{ Request::old('number_payment_customer_name') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67'))
                                        value="{{ $infodata->customer->customer_name }}"
                                        @else value=""
                                        @endif
                                        @endif>
                                    </div>
                                </div><--row-->
                            <!-- </div>
                        </div>col -->

                        <!-- <div class="col-12"></div> -->

                        <!-- <div class="col-lg-3">
                            <div class="form-group">
                                <label class="d-block">เลขที่ใบ Sale Confirmation</label>
                                <div class="input-icon" id="draft_number_info">
                                @if(Request::old('callback_search_omp67'))
                                    <select class="form-control select2" name="invoice_number_sa" style="height: 40px!important;" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') disabled @endif @endif>
                                        <option></option>
                                        @foreach($dataordernumber as $dataordernumbe)
                                            <option value="{{ $dataordernumbe->prepare_order_number }}">{{ $dataordernumbe->prepare_order_number }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" class="form-control text-center" name="invoice_number_sa" placeholder="" value="{{ Request::old('invoice_number_sa') }}">
                                    <i class="fa fa-search"></i>
                                @endif
                                </div>
                            </div>
                        </div>col -->

                        <!-- <div class="col-lg-3">
                            <div class="form-group">
                                <label class="d-block">เลขที่ Invoice</label>
                                <div class="input-icon" id="invoice_number_info">
                                    <-- <input type="text" class="form-control text-center" name="invoice_number" placeholder="" value="{{ Request::old('invoice_number') }}">
                                    <i class="fa fa-search"></i> -->
                                    <!-- @if (Request::old('callback_search_omp67'))
                                    <select class="form-control select2" name="invoice_number" style="height: 40px!important;" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') disabled @endif @endif>
                                        <option value=""></option>
                                        @foreach ($datainvoices as $datainvoice)
                                        <option value="{{ $datainvoice }}">{{ $datainvoice }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                        <input type="text" class="form-control text-center" name="invoice_number" placeholder="" value="{{ Request::old('invoice_number') }}">
                                        <i class="fa fa-search"></i>
                                    @endif -->
                                <!-- </div>
                            </div>
                        </div>col -->

                        <!-- <div class="col-lg-3">
                            <div class="form-group">
                                <label class="d-block">วันที่สั่งซื้อ</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="invoice_date_number" placeholder="" value="{{ Request::old('invoice_date_number') }}" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') readonly @endif @endif>
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div> -->
                        <!-- </div>col -->

                        <!-- <div class="col-12"></div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="d-block">เลขที่ Debit Note</label>
                                <div class="input-icon" id="invoice_number_debit">
                                    <input type="text" class="form-control" name="invoice_number_debit" placeholder="" value="{{ Request::old('invoice_number_debit') }}" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') readonly @endif @endif>
                                    <i class="fa fa-search"></i>
                                </div>
                            </div> -->
                        <!-- </div>col -->


                    <!-- </div>row -->
                </div><!--col-md-12-->

                <div class="col-xl-12">
                    <div class="form-header-buttons">
                        <div class="buttons d-flex">
                            <button class="btn btn-md btn-white" type="button" id="search" onclick="searchDPayment();"><i class="fa fa-search"></i> ค้นหา</button>
                            <button class="btn btn-md btn-success" type="button" id="savematch"><i class="fa fa-save"></i> บันทึก
                            </button>
                            <button class="btn btn-md btn-danger" type="button" id="unmatch" onclick="unmatchall();"><i class="fa fa-times"></i> Unmatch
                            </button>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-hover min-1400 f13" id="matchpayment">
                            <thead>
                                <tr class="align-middle">
                                    <th class="w-201">เลขที่ใบ <br>Sale Confirmation / Debit Note</th>
                                    <th>เลขที่ Invoice</th>
                                    <th>ประเภท</th>
                                    <th>จำนวนเงิน</th>
                                    <th>วันที่สั่งซื้อ</th>
                                    <th>วันครบกำหนดชำระ</th>
                                    <th>ประเภทการจ่ายเงิน</th>
                                    <th>จำนวนวันเชื่อ</th>
                                    <th>สกุลเงิน</th>
                                    <th>ค่าปรับ</th>
                                    <th class="w-160">Match ลดหนี้</th>
                                    <th>จำนวนเงิน<br>คงเหลือตามสกุลเงิน</th>
                                    <th>จำนวนเงิน<br>ที่ชำระตามสกุลเงิน</th>
                                    <th>อัตราแลกเปลี่ยน</th>
                                    <th>Match</th>
                                    {{-- <th style="width: 55px">ลบ</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if(Request::old('callback_search_omp67'))
                                    @foreach ($paymentsmethod as $key => $paymentMatch)
                                    <?php
                                    $totelsumpayemnt = $paymentMatch->outstanding_debt;
                                    ?>
                                    <tr class="align-middle" id="{{ $key }}">
                                        <td>
                                            @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                                <div class="input-icon">
                                                    <input type="text" class="form-control text-center f13" name="doc_id[]" placeholder="" value="{{ $paymentMatch->invoice_number }}" @if($infodata->payment_status == 'Confirm') disabled @endif>
                                                    <i class="fa fa-search"></i>
                                                </div>
                                            @else
                                                <div class="input-icon">
                                                    <input type="text" class="form-control text-center f13" name="doc_id[]" placeholder="" value="{{ $paymentMatch->prepare_order_number }}" @if($infodata->payment_status == 'Confirm') disabled @endif>
                                                    <i class="fa fa-search"></i>
                                                </div>
                                            @endif
                                        </td>

                                        @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                            <td><input type="hidden" name="pick_no[]" value=""></td>
                                        @else
                                            <td>{{ $paymentMatch->invoice_number }}<input type="hidden" name="pick_no[]" value="{{ $paymentMatch->invoice_number }}"></td>
                                        @endif

                                        @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                            <td><input type="hidden" name="type_product[]" value=""></td>
                                        @else
                                            <td>{{ $paymentMatch->orders->producttypes->description ?? '' }}<input type="hidden" name="type_product[]" value="{{ $paymentMatch->orders->producttypes->description ?? '' }}"></td>
                                            {{-- <td>{{ meaningproducttypeexport($paymentMatch->invoice_number, $paymentMatch->prepare_order_number) }}<input type="hidden" name="type_product[]" value="{{ meaningproducttypeexport($paymentMatch->invoice_number, $paymentMatch->prepare_order_number) }}"></td> --}}
                                        @endif

                                        <td class="text-right">{{ number_format($totelsumpayemnt,2) }}<input type="hidden" name="amount_vat[]" value="{{ number_format($totelsumpayemnt,2) }}"></td>

                                        @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                            <td>{{ FormatDate::DateThaiNumericWithSplash(datedn($paymentMatch->invoice_number)) }}<input type="hidden" name="invoice_date[]" value="{{ datedn($paymentMatch->invoice_number) }}"></td>
                                        @else
                                            <td>{{ FormatDate::DateThaiNumericWithSplash($paymentMatch->orders->order_date ?? '') ?? '' }}<input type="hidden" name="invoice_date[]" value="{{ $paymentMatch->orders->order_date ?? '' }}" disabled></td>
                                        @endif

                                        <td>{{ FormatDate::DateThaiNumericWithSplash($paymentMatch->due_date) }}<input type="hidden" name="invoice_duedate[]" value="{{ $paymentMatch->due_date }}" disabled></td>

                                        @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                            <td><input type="hidden" name="credit_group[]" value=""></td>
                                        @else
                                            <td>{{ meaningtypepayment($paymentMatch->payment_type_code) }} <input type="hidden" name="credit_group[]" value="{{ $paymentMatch->payment_type_code }}"></td>
                                        @endif

                                        <td>{{ $paymentMatch->due_day }}<input type="hidden" name="credit_day[]" value="{{ $paymentMatch->due_day }}"></td>
                                        <td>{{ $paymentMatch->currency }}<input type="hidden" name="currency[]" value="{{ $paymentMatch->currency }}"></td>
                                        <td class="text-right">@if($paymentMatch->payment_type_code == 10) 0.00 @else {{ payfine($totelsumpayemnt,$paymentMatch->due_date,$paymentMatch->creation_date,$paymentMatch->prepare_order_number,$paymentMatch->payment_type_code,$paymentMatch->invoice_number, 'E') }}@endif<input type="hidden" name="amount_fines[]" value="@if($paymentMatch->payment_type_code == 10) 0.00 @else {{ payfine($totelsumpayemnt,$paymentMatch->due_date,$paymentMatch->creation_date,$paymentMatch->prepare_order_number,$paymentMatch->payment_type_code,$paymentMatch->invoice_number, 'E') }}@endif"></td>


                                        <td>
                                            <div class="input-icon">
                                                <input type="text" class="form-control red text-center f13" name="paymatch[]" placeholder="" value="{{ number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}" onchange="summatchnew();" disabled>
                                                <i class="fa fa-search" data-toggle="modal" data-target="#matchCreditModal" data-whatever="{{ $key }}"></i>
                                            </div>
                                            <input type="hidden" name="amount_match[]" value="{{ number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}">
                                        </td>

                                        @if(number_format($paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) == '0.00')
                                            <td class="text-center">{{ number_format($totelsumpayemnt,2) }}<input type="hidden" name="amount_balance[]" value="{{ number_format($totelsumpayemnt,2) }}"></td>
                                        @else
                                            <td class="text-center">{{ number_format($totelsumpayemnt - $paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}<input type="hidden" name="amount_balance[]" value="{{ number_format($totelsumpayemnt - $paymentMatch->applypayment($paymentMatch->invoice_number,$paymentMatch->prepare_order_number,$paymentMatch->credit_group_code,$paymentMatch->payment_header_id),2) }}"></td>
                                        @endif
                                        <td><input type="text" class="form-control text-right f13" name="balancetotal[]" placeholder="" value="{{ number_format($paymentMatch->payment_amount,2) }}" @if($infodata->payment_status == 'Confirm') disabled @endif><input type="hidden" name="amount_balancetotal[]" value="{{ $paymentMatch->payment_amount }}"></td>
                                        <td><input type="text"  class="form-control text-right f13" name="exchang_rate[]" placeholder="" value="{{$paymentMatch->match_exchange_rate}}"></td>
                                        @if(strpos($paymentMatch->invoice_number, 'DN') !== false)
                                            <td><input type="checkbox" value="{{ $paymentMatch->invoice_id }}:INVOICE:{{ $key }}" name="match_check[]" onclick="summatch();" @if($paymentMatch->match_flag == 'Y') checked @endif @if($infodata->payment_status == 'Confirm') disabled @endif></td>
                                        @else
                                            <td><input type="checkbox" value="{{ $paymentMatch->orders->order_header_id ?? '' }}:DRAFT:{{ $key }}" name="match_check[]" onclick="summatch();" @if($paymentMatch->match_flag == 'Y') checked @if($infodata->payment_status == 'Confirm') disabled @endif @endif></td>
                                        @endif


                                        {{-- <td class="text-center">
                                            @if($infodata->payment_status == 'Draft')<a class="fa fa-times red" href="javascript:void(0);"></a>@endif
                                        </td> --}}
                                        <input type="hidden" name="matchid[]" value="">
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div><!--table-responsive-->


                    <div class="col-md-12">
                        <hr class="lg">
    
                        <div class="form-header-buttons">
                            <h3 class="black mb-2 mb-md-0">ข้อมูลการชำระเงิน</h3>
                            <div class="buttons d-flex">
                                {{-- <a class="btn btn-md btn-success" type="button" id="addpayment" onclick="addpayment('tableaddpayment');"><i class="fa fa-plus"></i> เพิ่ม</a> --}}
                                <button class="btn btn-md btn-success" type="button" id="addpayment" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') disabled @endif @endif><i class="fa fa-plus"></i> เพิ่ม
                                    </button>
                            </div>
                        </div>
    
                        <div class="hr-line-dashed"></div>
    
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-hover min-1200 f13" id="tableaddpayment">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-90">ลำดับที่</th>
                                        <th class="w-201">วิธีการชำระเงิน</th>
                                        <th>ธนาคาร</th>
                                        <th class="w-90">สกุลเงิน</th>
                                        <th class="w-90">อัตรา<br>แลกเปลี่ยน</th>
                                        <th class="w-201">จำนวนเงินรับชำระ<br>ตามสกุลเงิน</th>
                                        <th class="w-201">จำนวนเงิน<br>รับชำระ (บาท)</th>
                                        <th style="width: 55px">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(Request::old('callback_save'))
                                            @if(Request::old('payment_method'))
                                                @foreach (Request::old('payment_method') as $key => $pm)
                                                <input type="hidden" name="number_payment[]" value="{{ Request::old('number_payment')[$key] }}">
                                                <input type="hidden" name="bank_code[]" value="{{ Request::old('bank_code')[$key] }}">
                                                <tr class="align-middle">
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                         <select class="form-control" name="payment_method[]" id="payment_desc_number_bank">
                                                            @foreach($methods as $method)
                                                                <option value="{{ $method->lookup_code }},{{ $method->meaning }}" @if($pm->payment_method_code == $method->lookup_code) selected @endif>{{ $method->description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="payment_desc_number_bank[]" id="payment_desc_number_bank">
                                                            @foreach ($bankdesc as $desc)
                                                                <option value="{{ $desc->bank_account_name }}" @if($desc->bank_account_name == $pm->bank_desc) selected @endif>{{ $desc->bank_account_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>{{ Request::old('currencys')[$key] }}<input type="hidden" name="currencys[]" value="{{ Request::old('currencys')[$key] }}"></td>
                                                    <td class="text-right"><input type="text" class="form-control md text-right" name="exchangerates[]" value="{{ number_format(Request::old('exchangerates')[$key],2) }}" onchange="(function(el){el.value=addCommas(parseFloat(el.value).toFixed(2));})(this)" onkeyup="countsumpayment();" onkeydown="countsumpayment();" onkeypress="countsumpayment();"></td>
                                                    <td><input type="text" placeholder="" name="payment_amount[]" value="{{ number_format(Request::old('payment_amount')[$key],2) }}" class="form-control md text-right" autocomplete="off" onchange="(function(el){el.value=addCommas(parseFloat(el.value).toFixed(2));})(this)" onkeyup="countsumpayment();" onkeydown="countsumpayment();" onkeypress="countsumpayment();"></td>
                                                    <td>{{ number_format(Request::old('payment_amount')[$key] * Request::old('exchangerates')[$key],2) }}<input type="hidden" name="total_payment_amount[]" value="{{ Request::old('payment_amount')[$key] * Request::old('exchangerates')[$key] }}"></td>
                                                    <td class="text-center"><a href="javascript:void(0)" class="fa fa-times red" onclick="deleteRow(this,'tableaddpayment');"></a></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        @endif
    
                                        @if(Request::old('callback_search_omp67'))
                                        <?php $t = 0; ?>
                                            @if($infodata->paymentMethod)
                                                @foreach ($infodata->paymentMethod as $key => $pm)
                                                <?php $t += $pm->conversion_amount; ?>
                                                <input type="hidden" name="payment_detail_id[]" value="{{ $pm->payment_detail_id }}">
                                                <input type="hidden" name="number_payment[]" value="{{ $pm->payment_no }}">
                                                <input type="hidden" name="bank_code[]" value="{{ $pm->bank_number }}">
                                                <input type="hidden" name="payment_method[]" value="{{ $pm->payment_method_code }}">
                                                <input type="hidden" name="payment_desc_number_bank[]" value="{{ $pm->bank_desc }}">
                                                <tr class="align-middle">
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        <select class="form-control" id="payment_desc_number_bank" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') disabled @endif @endif>
                                                            @foreach($methods as $method)
                                                                <option value="{{ $method->lookup_code }},{{ $method->meaning }}" @if($pm->payment_method_code == $method->lookup_code) selected @endif>{{ $method->description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="payment_desc_number_bank" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') disabled @endif @endif>
                                                            @foreach ($bankdesc as $desc)
                                                                <option value="{{ $desc->bank_account_name }}" @if($desc->bank_account_name == $pm->bank_desc) selected @endif>{{ $desc->bank_account_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>{{ $pm->currency }}<input type="hidden" name="currencys[]" value="{{ $pm->currency }}"></td>
                                                    <td class="text-right"><input type="text" class="form-control md text-right" name="exchangerates[]" value="{{ number_format($pm->conversion_rate,10) }}" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') readonly @endif @endif></td>
                                                    <td><input type="text" placeholder="" name="payment_amount[]" value="{{ number_format($pm->payment_amount,2) }}" class="form-control md text-right" autocomplete="off" @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') readonly @endif @endif></td>
                                                    <td>{{ number_format($pm->conversion_amount,2) }}<input type="hidden" name="total_payment_amount[]" value="{{ $pm->conversion_amount }}" onkeyup="countsumpayment2();" onkeydown="countsumpayment2();" onkeypress="countsumpayment2();"></td>
                                                    <td class="text-center">@if($infodata->payment_status == 'Draft')<a href="javascript:void(0)" class="fa fa-times red"></a>@endif</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        @endif
    
                                    <tr class="align-middle">
                                        <td class="text-right pt-3 pb-3" colspan="6" id="ignore"><strong
                                                class="black">จำนวนเงินรวมที่รับชำระ</strong></td>
                                        <td class="text-right pt-3 pb-3" id="total"><strong
                                                class="black">@if(Request::old('callback_save')) {{ number_format(Request::old('total_amounts') + Request::old('balance_amounts'),2) }} @else @if(Request::old('callback_search_omp67')) {{ number_format($t,2) }} @else 0 @endif @endif</strong></td>
                                        <td></td>
                                    </tr>
    
                                </tbody>
                            </table>
                        </div><!--table-responsive-->
    
                    </div><!--col-md-12-->

                    <div class="panel panel-default mt-4">
                        <div class="d-block m-auto">
                            <div class="row justify-content-between p-4">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">จำนวนเงินรวม Vat</label>
                                        <input type="text" class="form-control text-right" disabled="" name="totalvat" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('totalval') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_amount_with_vat,2) }}"
                                        @else value=""
                                        @endif
                                        @endif>
                                            <input type="hidden" name="totalvat_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('totalvat_amounts') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_amount_with_vat,2) }}"
                                            @else value=""
                                            @endif
                                            @endif>
                                    </div>
                                </div>
                                <!--col-md-3-->

                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">จำนวนเงินใบลดหนี้ที่ Match</label>
                                        <input type="text" class="form-control text-right" disabled="" name="match_count" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('match_count') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_amount_match,2) }}"
                                        @else value=""
                                        @endif
                                        @endif>
                                            <input type="hidden" name="match_count_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('match_count_amounts') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_amount_match,2) }}"
                                            @else value=""
                                            @endif
                                            @endif>
                                    </div>
                                </div>
                                <!--col-md-3-->

                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">ค่าปรับ</label>
                                        <input type="text" class="form-control text-right" disabled="" name="paycount" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('paycount') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_fine,2) }}"
                                        @else value=""
                                        @endif
                                        @endif>
                                            <input type="hidden" name="paycount_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('paycount_amounts') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_fine,2) }}"
                                            @else value=""
                                            @endif
                                            @endif>
                                    </div>
                                </div>
                                <!--col-md-3-->

                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">รวมเงินชำระ</label>
                                        <input type="text" class="form-control text-right" disabled="" name="total" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('total') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_payment_amount,2) }}"
                                        @else value=""
                                        @endif
                                        @endif>
                                            <input type="hidden" name="total_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('total_amounts') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_payment_amount,2) }}"
                                            @else value=""
                                            @endif
                                            @endif>
                                    </div>
                                </div>
                                <!--col-md-3-->


                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">เงินคงเหลือในบัญชีครั้งก่อน</label>
                                        <input type="text" class="form-control text-right" disabled="" name="bbalance" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('bbalance') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_previous_remain_amount,2) }}"
                                        @else value=""
                                        @endif
                                        @endif>
                                            <input type="hidden" name="bbalance_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('bbalance_amounts') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_previous_remain_amount,2) }}"
                                            @else value=""
                                            @endif
                                            @endif>
                                    </div>
                                </div>
                                <!--col-md-3-->

                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">จำนวนเงินใบเพิ่มหนี้</label>
                                        <input type="text" class="form-control text-right" disabled="" name="matchamount" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('matchamount') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67')) value=""
                                        @else value=""
                                        @endif
                                        @endif>
                                            <input type="hidden" name="matchamount_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('matchamount_amounts') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67')) value=""
                                            @else value=""
                                            @endif
                                            @endif>
                                    </div>
                                </div>
                                <!--col-md-3-->


                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block black">เงินคงเหลือในบัญชีครั้งนี้</label>
                                        <input type="text" class="form-control text-right" disabled="" name="balance" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('balance') }}"
                                        @else
                                        @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_remain_amount,2) }}"
                                        @else value=""
                                        @endif
                                        @endif>
                                            <input type="hidden" name="balance_amounts" placeholder="" @if(Request::old('callback_save')) value="{{ Request::old('balance_amounts') }}"
                                            @else
                                            @if(Request::old('callback_search_omp67')) value="{{ number_format($infodata->total_remain_amount,2) }}"
                                            @else value=""
                                            @endif
                                            @endif>
                                    </div>
                                </div>
                                <!--col-md-3-->

                            </div>
                            <!--row-->
                        </div>
                        <!--d-block-->
                    </div><!--panel-->
                </div><!--col-xl-12-->
                <input type="hidden" name="files_uploadsId" id="files_uploadsId">
            </form>

        </div><!--ibox-content-->
    </div><!--ibox-->

    <div class="modal modal-600 fade" id="UploadModalFile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <div class="modal-header">
                    <h3>Upload File</h3>
                </div>
                <form id="form_attachment" data-action="{{ url('/') }}/om/export-payout/payment/upload">
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
                            <p><small>Allow type : jpeg, jpg, bmp, png, pdf, doc, docx, xls, xlsx, rar, zip, csv and size < 2mb</small></p>
                            <ul class="nav files">
                                @if(!empty($infodata->files))
                                    @foreach($infodata->files as $keyfile => $item)
                                    <li id="file_attachment_{{ $item->attachment_id }}">
                                        <code><a href="{{ url('/') }}/{{ $item->path_name }}" target="_blank"><i class="fa fa-file-pdf-o"></i>  {{ $item->file_name }}</code></a>
                                        <button class="btn btn-remove" onclick="removeFileAttachment(0,{{ $item->attachment_id }},`db`)" type="button">@if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Draft')<i class="fa fa-times"></i>@endif @endif</button>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!--modal-body-->
                    <div class="modal-footer center mt-4">
                        <button class="btn btn-gray" type="button"  data-dismiss="modal">
                            ปิด<small>Close</small>
                        </button>
                        <button class="btn btn-primary" type="submit">
                            ยืนยัน<small>Confirm</small>
                        </button>
                    </div>
                </form>
            </div>
        </div><!--modal-content-->
    </div><!--modal-dialog-->


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
                    <button class="btn btn-lg btn-primary" type="button" onclick="confirmcn();"  @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') disabled @endif @endif>ยืนยัน</button>
                    <button class="btn btn-lg btn-danger" type="button" data-dismiss="modal"  @if(Request::old('callback_search_omp67')) @if($infodata->payment_status == 'Confirm') disabled @endif @endif><i class="fa fa-times"></i>
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
<script src="{!! asset('js/aksFileUpload.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
<script src="{!! asset('js/number.js') !!}"></script>
<script src="{!! asset('jquery-ui.js') !!}"></script>

<script>
    let banklists = {!! json_encode($banks) !!};
    let customerlists = {!! json_encode($customers) !!};
    let idorders = [];
    let idinvoices = [];
    let addfines = [];
    let datacn;
    let datadn;
    let created = false;

    $(document).ready(function(){
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.date').datepicker({
            dateFormat: 'dd/mm/yy',
            maxDate: today
        });
        @if(Request::old('callback_search_omp67'))
            if($('#matchpayment tbody tr').length == 0) {
                $('#unmatch').attr('disabled', true);
            } else {
                $('#savematch').attr('disabled', true);
            }
            @if($infodata->payment_status == 'Confirm')
                $('#cancelbtn').attr('disabled', false);
                $('#confirmbtn').attr('disabled', true);
                if($('#matchpayment tbody tr').length == 0) {
                    // $('#printbtn').addClass('disabled');
                    $('#printbtn').removeClass('disabled');
                } else {
                    $('#printbtn').removeClass('disabled');
                }
                $('#search').attr('disabled', false);
            @else
                $('#cancelbtn').attr('disabled', true);
                $('#confirmbtn').attr('disabled', false);
                // $('#printbtn').addClass('disabled', true);
            @endif
        @else
            $('#unmatch').attr('disabled', true);
            $('#savematch').attr('disabled', true);
            $('#cancelbtn').attr('disabled', true);
            $('#confirmbtn').attr('disabled', false);
            $('#printbtn').addClass('disabled', true);
            $('#search').attr('disabled', true);
        @endif
        select2auto();
        disableBtn();
        $('#addpayment').on('click', function() {
            addpayment('tableaddpayment');
        });
        $('#add').on('click', function() {
            addpayment('matchpayment');
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

        $(".aks-file-upload-files").aksFileUpload({
            dragDrop: true,
            maxSize: "1 GB",
            multiple: true,
            maxFile: 50
        });

        // $('#matchCreditModal').on('show.bs.modal', function(e) {
        //     //get data-id attribute of the clicked element
        //     var bookId = $(e.relatedTarget).data('whatever');
        //     //populate the textbox
        //     $(e.currentTarget).find('#recipientid').val(bookId);
        // });

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

        try {
            $("input").each(function() {
                $(this).attr("autocomplete", "off");
            });
        } catch (e) {};

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
    });

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
                    url: "{{ route('om.export-method-unmatchall') }}",
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
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire({
                            title: 'เกิดข้อผิดพลาด',
                            icon: 'error'
                        });
                    }
                });
            }
        })
    }

    var fileChoose = [];
    var fileSecChoose = 1;
    var fileRunChoose = -1;
    $('#attachment').change(function(){
        var input = this;
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        fileChoose.push(input.files[0]);
        fileRunChoose += 1;
    });
    function submitChooseFile(){
        let html = '<li id="file_choose_'+fileSecChoose+'_'+fileRunChoose+'">'+
                '<code><a href="#"><i class="fa fa-file-pdf-o"></i>  '+fileChoose[fileRunChoose].name+'</code></a>'+
                '<button class="btn btn-remove" onclick="removeFileAttachment('+fileSecChoose+','+fileRunChoose+')" type="button"><i class="fa fa-times"></i></button>'+
            '</li>';
        $("ul.files").append(html);
        clearInputFile();
    }

    function select2auto() {
        $('.select2').select2();
    }

    function resetpage() {
        window.location.href = "/om/export-payout";
    }

    function inputbyseft(k,v){
        setTimeout(function() {
            var rowjQuery = $(k).closest("tr");
            var index = rowjQuery[0].rowIndex - 1;

            var r = $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val().replace(/,/g, '');


            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balance[]"]').val($.number(v,2));
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balancetotal[]"]').val($.number(v,2));
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val($.number(v,2));
        },1000);
    }

    var html = '';
    var files_uploadsId = [];
    $("#form_attachment").submit(async function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        await $.each(fileChoose,async function(index, file) {
            if(typeof file !== "undefined")
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
            success:function (result) {
                console.log(result);
                if(result.status == 200){
                    $("ul.files").empty();
                    fileChoose = [];
                    fileRunChoose = -1;
                    fileSecChoose += 1;
                    clearInputFile()
                    $.each(result.attachments,function(index, fileInfo) {
                        html += '<li id="file_choose_'+index+'_'+fileInfo.attachment_id+'">'+
                            '<code><a href="{{ url("/") }}/'+fileInfo.path_name+'/'+fileInfo.file_name+'" target="_blank"><i class="fa fa-file-pdf-o"></i>  '+fileInfo.file_name+'</code></a>'+
                            '<button class="btn btn-remove" onclick="removeFileAttachment('+index+','+fileInfo.attachment_id+',`db`)" type="button"><i class="fa fa-times"></i></button>'+
                        '</li>';
                        files_uploadsId.push(fileInfo.attachment_id);
                    });
                    $("ul.files").append(html);
                    $('#files_uploadsId').val(""+files_uploadsId+"");
                    $('#UploadModalFile').modal('hide');
                    Swal.fire({
                        title: result.message,
                        icon: 'success'
                    });
                }
                if(result.status == 422 || result.status == 403){
                    Swal.fire({
                        title: result.message,
                        icon: 'error'
                    });
                }
            },
            error: function (data) {
                console.log(data);
                $('#UploadModalFile').modal('hide')
            }
        });
    });

    function clearInputFile(type=''){
        $('#attachment').replaceWith($('#attachment').val('').clone(true));
        $('#attachment').val('');
        $("#attachment").val(null);
        $('.label-attachment').html('Choose file...')
        if(type == 'clear'){
            delete fileChoose[fileRunChoose];
            // fileRunChoose = -1;
        }
    }

    async function setAttachment(attachment){
        let html = ''
        let url ="{{ url('/') }}"
        $("ul.files").empty();
        await $.each('input[name=attachment]',async function(index, item) {
            html += '<li id="file_attachment_'+item.attachment_id+'">'
                html += '<code><a href="'+url+'/'+item.path_name+'" target="_blank"><i class="fa fa-file-pdf-o"></i>  '+item.file_name +'</code></a>'
                html += '<button class="btn btn-remove" onclick="removeFileAttachment(0,'+item.attachment_id+',`db`)" type="button"><i class="fa fa-times"></i></button>'
            html += '</li>';
        });
        $("ul.files").append(html);
    }

    function removeFileAttachment(section,index,type='local'){
        if(type != 'local'){
            let formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('attachment_id', index);
            $.ajax({
                type: 'post',
                url: "{{ url('/') }}/om/export-payout/payment/files/delete",
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
                success: function (result) {
                    Swal.fire({
                        title: result.data,
                        icon: 'success'
                    });
                    $('#file_choose_'+section+'_'+index).remove();
                },
                error: function (data) {
                    console.log("error : " + data);
                }
            });
        }else{
            delete fileChoose[index];
            $('#file_choose_'+section+'_'+index).remove()
        }
    }

    function deletefilefrominput(name) {
        if(name == '') {
            return false;
        }
        console.log($('input[name="files_upload').val());
    };

    function filedeletefromid(id, key) {
        if(id == '' && key == '') {
            return false;
        }
    }

    function numericonly(v,l){
        $('input[name="fines"]').val(l.replace(/[^0-9\.|\,]/g,''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }

        var currentVal = l;
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
            currentVal = currentVal.slice(0, -1);
        }
        $('input[name="fines"]').val(replaceCommas(currentVal));
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

    function savepayment(status) {
        var rows = document.getElementById('tableaddpayment').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
        if(status == 'SaveMemo') {
            $.ajax({
                url: "",
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "remark": $('input[name="remark"]').val(),
                    "action": "type_memo"
                },
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังดำเนินการบันทึกกรุณารอสักครู่',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(res) {
                    Swal.fire({
                        title: 'ทำรายการเรียบร้อย',
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

            return false;
        }

        if(document.getElementById('tableaddpayment').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length <= 1){
            Swal.fire({
                title: 'กรุณาระบุข้อมูลการชำระเงิน',
                icon: 'error'
            });
        } else {
            $('#tableaddpayment tbody tr').each(function(index, value){
                if (index === (rows - 1)){
                    return;
                 }

                 var row = $(this);
                 if(row.find("td").eq(1).find('select[name="payment_method[]"] option:selected').val() == ''){
                    Swal.fire({
                        title: 'กรุณาระบุวิธีการชำระเงิน',
                        icon: 'error'
                    });
                    return;
                 }

                 if(row.find("td").eq(2).find('select[name="payment_desc_number_bank[]"] option:selected').val() == ''){
                    Swal.fire({
                        title: 'กรุณาระบุธนาคาร',
                        icon: 'error'
                    });
                    return;
                 }

                 if(row.find("td").eq(4).find('input[name="exchangerates[]"]').val() == ''){
                    Swal.fire({
                        title: 'กรุณาระบุอัตราแลกเปลี่ยน',
                        icon: 'error'
                    });
                    return;
                 }

                 if(row.find("td").eq(5).find('input[name="payment_amount[]"]').val() == ''){
                    Swal.fire({
                        title: 'กรุณาระบุจำนวนเงิน',
                        icon: 'error'
                    });
                    return;
                 }
            });

            var number_customer;
            var number_invoice;
            var number_date;
            var number_remark;
            var number_bank;
            var number_bank_desc;
            var number_address;
            var number_status;
            var number_fines;

            number_date = $('input[name="payment_date"]').val();
            number_invoice = $('input[name="payment_number"]').val();

            number_customer = $('input[name="customer_number"]').val();
            number_remark = $('input[name="remark"]').val();
            number_address = $('input[name="address"]').val();
            number_status = $('input[name="status"]').val();
            number_fines = $('input[name="fines"]').val();

            $('#numberpaymentinvoice').val(number_invoice);
            $('#numberpaymentdate').val(number_date);
            $('#numberpaymentcustomer').val(number_customer);
            $('#numberpaymentstatus').val(status);
            $('#numberpaymentremart').val(number_remark);
            $('#numberpaymentbaddress').val(number_address);
            $('#numberstatus').val(number_status);
            $('#numberpaymentfines').val(number_fines);
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
                $('#matchpayment tbody tr').each(function(index, value){
                    count += $(this).find(':checkbox:checked').length;
                });

                if(count == 0) {
                    Swal.fire({
                        title: 'คุณยังไม่ได้ทำการ Match ยอดเงิน แน่ใจหรือไม่?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: ' ใช่ ',
                        cancelButtonText: ' ไม่ ',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            summatch();
                            savepaymentfunction();
                        } else {   
                            if($('#matchpayment tbody tr').length == 0) {                  
                                Swal.fire(
                                    'กรุณาค้นหาข้อมูลการ Match ก่อนดำเนินการ',
                                    '',
                                    'error'
                                )
                            } else {
                                Swal.fire({
                                    title: 'กำลังปรับยอด Match กรุณารอสักครู่',
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                                var payment_amount_all = $('#total .black').text().replace(/,/g, '');
                                $('#matchpayment tbody tr').each(function(index, value) {
                                    if(payment_amount_all > 0) {
                                        var amount = $(this).find('input[name="balancetotal[]"]').val().replace(/,/g, '');
                                        if(parseFloat(amount) > parseFloat(payment_amount_all)){
                                            $(this).find('input[name="match_check[]"]').attr('checked', true);
                                            $(this).find('input[name="balancetotal[]"]').val(addCommas(parseFloat(payment_amount_all).toFixed(2)));
                                            $(this).find('input[name="amount_balancetotal[]"]').val(addCommas(parseFloat(payment_amount_all).toFixed(2)));
                                            payment_amount_all -= payment_amount_all;
                                        } else {
                                            $(this).find('input[name="match_check[]"]').attr('checked', true);
                                            $(this).find('input[name="balancetotal[]"]').val(addCommas(parseFloat(amount).toFixed(2)));
                                            $(this).find('input[name="amount_balancetotal[]"]').val(addCommas(parseFloat(amount).toFixed(2)));
                                            payment_amount_all -= amount;
                                        }
                                    }
                                });
                                summatch();
                                swal.close();
                                // savepaymentfunction();
                            }
                        }
                    })
                } else {
                    savepaymentfunction();
                }
            }
        }
    }

    function savepaymentfunction() {
        $.ajax({
                url: "{{ route('om.payment-method-paymentverify') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "payment_method[]": $('input[name="payment_method[]"]').val(),
                    "number_payment[]": $('input[name="number_payment[]"]').val(),
                    "bank_code[]": $('input[name="bank_code[]"]').val(),
                    "total_payment_amount[]": $('input[name="total_payment_amount[]"]').val(),
                    "number_payment_customer": $('input[name="number_payment_customer"]').val(),
                    "number_payment_status": $('input[name="number_payment_status"]').val(),
                },
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังดำเนินการบันทึกกรุณารอสักครู่',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(res) {
                    console.log(res);
                    if (res.errors == '') {
                        $('#submitform').submit();
                    } else {
                        Swal.fire({
                            title: res.errors,
                            icon: 'error'
                        });
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

    function deletefile(id,index){
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
            function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ request()->getSchemeAndHttpHost() }}/om/export-payout/payment/files/delete",
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

    function disableBtn() {
        $('textarea[name="address"]').prop('disabled', true);
        $('input[name="status"]').prop('disabled', true);
        $('input[name="type"]').prop('disabled', true);
        // $('input[name="payment_date"]').prop('disabled', true);
    }

    function bankchange(v) {
        var index = _.findIndex(banklists, function(o) {
            return o.bank_number == v;
        });
        $('input[name="bank_desc"]').val(banklists[index].bank_branch_name);
    }

    function createFunc() {
        $('#search').attr('disabled', false);
        const d = new Date();
        var dd = ("0" + d.getDate()).slice(-2)
        var mm = ("0" + (d.getMonth() + 1)).slice(-2);
        var yy = d.getFullYear();
        var result = dd+'/'+mm+'/'+yy;
        $("input").each(function() {
            $(this).val('');
        });
        created = true;
        $('input[name="payment_number"]').prop('disabled', true);
        $('input[name="status"]').val('Draft');
        $('input[name="payment_date"]').prop('disabled', false);
        $('input[name="payment_date"]').val(result);
    }

    function custchange(v, tableid) {
        var invoice_number = $('select[name="invoice_number"] option:selected').val();
        var draft_number = $('select[name="invoice_number_sa"] option:selected').val();
        var invoice_debit = $('select[name="invoice_number_debit"] option:selected').val();
        if (v == '' || v == null) {
            $('input[name="type"]').val('');
            $('input[name="customer_name"]').val('');
            $('textarea[name="address"]').val('');
            $('input[name="customer_numbers"]').val('');
            $('input[name="customer_number"]').val('');
            $('input[name="customer_names"]').val('');
            $('input[name="currency"]').val('');
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
            $('input[name="currency"]').val(customerlists[index].currency);

            if(customerlists[index].country_code == 'TH'){
                var line1;
                var line2;
                var line3;
                var alley;
                var district;
                var city;
                var province;
                var countryname;
                var postcode;

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
                if (customerlists[index].country_name == null) {
                    countryname = '';
                } else {
                    countryname = customerlists[index].country_name;
                }
                if (customerlists[index].postal_code == null) {
                    postcode = '';
                } else {
                    postcode = customerlists[index].postal_code;
                }

                $('textarea[name="address"]').val(line1 + ' ' + line2 + ' ' + line3 + ' ' + alley + ' ' + district + ' ' + city + ' ' + province + ' ' + postcode + ' '  + countryname);
            } else {
                var line1;
                var line2;
                var line3;
                var state;
                var city;
                var postcode;
                var countryname;

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
                if (customerlists[index].state == null) {
                    state = '';
                } else {
                    state = customerlists[index].state;
                }
                if (customerlists[index].city == null) {
                    city = '';
                } else {
                    city = customerlists[index].city;
                }
                if (customerlists[index].country_name == null) {
                    countryname = '';
                } else {
                    countryname = customerlists[index].country_name;
                }
                if (customerlists[index].postal_code == null) {
                    postcode = '';
                } else {
                    postcode = customerlists[index].postal_code;
                }

                $('textarea[name="address"]').val(line1 + ' ' + line2 + ' ' + line3 + ' ' + state + ' ' + city + ' ' + postcode + ' '  + countryname);
            }


            if(!created){
                console.log(1);
                $.ajax({
                    url: "{{ route('om.export-payout-getpaymentnumber') }}",
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
                        $.each(data,function(k,v){
                            $('#payment_number_ref').append('<option>'+v.payment_number+'</option>');
                        });
                        if (created) {
                            $('#search').click();
                        }
                        select2auto();
                    },
                    error: function(error) {
                        Swal.fire({
                            title: error.responseText,
                            icon: 'error'
                        });
                    }
                });
            } else {
                if (created) {
                    $('#search').click();
                }
            //     console.log(2);
            //     $.ajax({
            //         url: "{{ route('om.export-method-getinfofordraft') }}",
            //         type: "POST",
            //         data: {
            //             "_token": "{{ csrf_token() }}",
            //             "customer_number": v,
            //         },
            //         cache: false,
            //         beforeSend: function() {
            //             Swal.fire({
            //                 title: 'กรุณารอสักครู่',
            //                 showCancelButton: false,
            //                 showConfirmButton: false
            //             });
            //         },
            //         success: function(res) {
            //             var dataordernumbers = res.dataordernumbers;
            //             var datainvoices = res.datainvoices;
            //             var datadebits = res.datadebits;

            //             var htmlstart = '<select class="form-control select2" name="invoice_number_sa" style="height: 40px!important;"><option value=""></option>';
            //             if(draft_number == '' || draft_number == 'undefined'){
            //                 var cdraft_number = '';
            //             } else {
            //                 var cdraft_number = draft_number
            //             }
            //             $.each(dataordernumbers, function(key, value){
            //                 if(cdraft_number  == value){
            //                     var data = '<option value="'+value+'" selected>'+value+'</option>';
            //                 } else {
            //                     var data = '<option value="'+value+'">'+value+'</option>';
            //                 }
            //                 htmlstart = htmlstart+data;
            //             });
            //             var endhaml = htmlstart + '</select>';
            //             $('#draft_number_info').html(endhaml);


            //             var htmlstartinvoicenumber = '<select class="form-control select2" name="invoice_number" style="height: 40px!important;"><option value=""></option>';
            //             if(invoice_number == '' || invoice_number == 'undefined'){
            //                 var cinvoice_number = '';
            //             } else {
            //                 var cinvoice_number = invoice_number
            //             }
            //             $.each(datainvoices, function(key, value){
            //                 if(cinvoice_number == value){
            //                     var data = '<option value="'+value+'" selected>'+value+'</option>';
            //                 } else {
            //                     var data = '<option value="'+value+'">'+value+'</option>';
            //                 }
            //                 htmlstartinvoicenumber = htmlstartinvoicenumber+data;
            //             });
            //             var endhamlinvoicenumber = htmlstartinvoicenumber + '</select>';
            //             $('#invoice_number_info').html(endhamlinvoicenumber);


            //             var htmlstartdebit = '<select class="form-control select2" name="invoice_number_debit" style="height: 40px!important;"><option value=""></option>';
            //             if(invoice_debit == '' || invoice_debit == 'undefined'){
            //                 var cdebit = '';
            //             } else {
            //                 var cdebit = invoice_debit
            //             }
            //             $.each(datadebits, function(key, value){
            //                 if(cdebit == value){
            //                     var data = '<option value="'+value+'" selected>'+value+'</option>';
            //                 } else {
            //                     var data = '<option value="'+value+'">'+value+'</option>';
            //                 }
            //                 htmlstartdebit = htmlstartdebit+data;
            //             });
            //             var endhamldebit = htmlstartdebit + '</select>';
            //             $('#invoice_number_debit').html(endhamldebit);

            //             datadn = res.dataordernumbers;
            //             datacn = res.defineCN;
            //             console.log(res);
            //             swal.close();
            //             select2auto();
            //         },
            //         error: function(error) {
            //             Swal.fire({
            //                 title: error.responseText,
            //                 icon: 'error'
            //             });
            //         }
            //     });
            }
        }
    }

    function numericonlysftpayment(v,l){
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="exchangerates[]"]').val(l.replace(/[^0-9\.|\,]/g,''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }
    }

    function numericonlys(v,l){
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val(l.replace(/[^0-9\.|\,]/g,''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }
    }

    function numericonlyss(v,l){
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val(l.replace(/[^0-9\.|\,]/g,''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }
    }

    function settonumber(k,v){
        setTimeout(function() {
            var rowjQuery = $(k).closest("tr");
            var index = rowjQuery[0].rowIndex - 1;

            var r = $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="total_payment_amount[]"]').val().replace(/,/g, '');


            $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val($.number(v,2));

            $('#tableaddpayment tbody tr:eq(' + index + ') td:eq(6)').text($.number(r,2));
            $('#tableaddpayment tbody tr:eq(' + index + ') td:eq(6)').append('<input type="hidden" name="total_payment_amount[]" value="'+r+'">');
        },1000);
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
            console.log(htmloptionends);
            $('#' + tableid + ' tbody').append(
                '<tr class="align-middle"><td><div class="input-icon"><input type="text" class="form-control text-center f13" name="doc_id[]" placeholder="" value="" list="datadn" onchange="dnmatch(this,this.value);" autocomplete="off"><i class="fa fa-search"></i>' +
                htmloptionends +
                '</div></td><td><input type="hidden" name="pick_no[]" value=""></td><td><input type="hidden" name="type_product[]" value=""></td><td class="text-right"><input type="hidden" name="amount_vat[]" value=""></td><td><input type="hidden" name="invoice_date[]" value=""></td><td><input type="hidden" name="invoice_duedate[]" value=""></td><td><input type="hidden" name="credit_group[]" value=""></td><td><input type="hidden" name="credit_day[]" value=""></td><td><input type="hidden" name="currency[]" value=""></td><td class="text-right"><input type="hidden" name="amount_fines[]" value=""></td><td><div class="input-icon"><input type="text" class="form-control red text-center f13" name="paymatch[]" placeholder="" value="" onchange="summatchnew();" readonly><i class="fa fa-search modeladd" data-toggle="modal" data-target="#matchCreditModal" data-whatever=""></i></div><input type="hidden" name="amount_match[]" value=""></td><td></td><td><input type="text" class="form-control text-right f13" name="balancetotal[]" placeholder="" value="" onkeyup="numericonlysftpayment(this,this.value);" onchange="inputbyseft(this,this.value);"><input type="hidden" name="amount_balance[]" value=""><input type="hidden" name="amount_balancetotal[]" value=""></td><td></td><td><input type="checkbox" value="" name="match_check[]" onclick="summatch();"></td><td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this,\'matchpayment\');"></a></td><input type="hidden" name="matchid[]" value=""></tr>'
            );
            autoRownumber(tableid);
        } else {
            var idbank = $('input[name="bank_number"]').val();
            var bankname = $('input[name="bank_desc"]').val();
            var currency = $('input[name="currency"]').val();
            if(currency == 'THB'){
                $('#' + tableid + ' tbody').find("tr:last").before(
                '<tr class="align-middle"><td></td> <td><select onchange="getlistdetailbank(this);" class="form-control" name="payment_method[]"><option></option>@foreach($methods as $method)<option value="{{ $method->lookup_code }},{{ $method->meaning }}">{{ $method->description }}</option>@endforeach</select></td> <td><select class="form-control" name="payment_desc_number_bank[]" id="payment_desc_number_bank" onchange="changeBankdesc(this);" onload="changeBankdesc(this);"></select></td> <td>'+currency+'<input type="hidden" name="currencys[]" value="'+currency+'"></td><td class="text-right"><input type="text" class="form-control md text-right" name="exchangerates[]" autocomplete="off" value="1.00" onkeyup="countsumpayment();numericonlys(this,this.value);" onkeydown="countsumpayment();" onkeypress="countsumpayment();"></td> <td><input type="hidden" placeholder="" name="payment_amounts[]" value=""><input type="text" placeholder="" name="payment_amount[]" value="" class="form-control md text-right" autocomplete="off" onkeyup="countsumpayment();numericonlyss(this,this.value);autoMatchInvoice();" onkeydown="countsumpayment();" onkeypress="countsumpayment();" onchange="settonumber(this,this.value);"></td><td></td> <td class="text-center"><a href="javascript:void(0)" class="fa fa-times red" onclick="deleteRow(this,\'' +
                tableid + '\');"></a></td></tr>');
            } else {
                $('#' + tableid + ' tbody').find("tr:last").before(
                '<tr class="align-middle"><td></td> <td><select onchange="getlistdetailbank(this);" class="form-control" name="payment_method[]"><option></option>@foreach($methods as $method)<option value="{{ $method->lookup_code }},{{ $method->meaning }}">{{ $method->description }}</option>@endforeach</select></td> <td><select class="form-control" name="payment_desc_number_bank[]" id="payment_desc_number_bank" onchange="changeBankdesc(this);" onload="changeBankdesc(this);"></select></td> <td>'+currency+'<input type="hidden" name="currencys[]" value="'+currency+'"></td><td class="text-right"><input type="text" class="form-control md text-right" name="exchangerates[]" autocomplete="off" value="" onkeyup="countsumpayment();numericonlys(this,this.value);" onkeydown="countsumpayment();" onkeypress="countsumpayment();"></td> <td><input type="hidden" placeholder="" name="payment_amounts[]" value=""><input type="text" placeholder="" name="payment_amount[]" value="" class="form-control md text-right" autocomplete="off" onkeyup="countsumpayment();numericonlyss(this,this.value);autoMatchInvoice();" onkeydown="countsumpayment();" onkeypress="countsumpayment();" onchange="settonumber(this,this.value);"></td><td></td> <td class="text-center"><a href="javascript:void(0)" class="fa fa-times red" onclick="deleteRow(this,\'' +
                tableid + '\');"></a></td></tr>');
            }
            autoRownumber(tableid);
        }
    }

    function autoMatchInvoice() {
        var total = 0;
        var myTimeout;
        $('#tableaddpayment tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
            var noCommas = value.value.replace(/,/g, '')
            var changeRate = $('#tableaddpayment tbody tr:eq(' + index + ') td input[name="exchangerates[]"]').val();
            total += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
            console.log([noCommas, changeRate, (parseFloat(noCommas) * parseFloat(changeRate)).toFixed(5)])
            $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="total_payment_amount[]"]').val(
                (parseFloat(noCommas) * parseFloat(changeRate)).toFixed(5));
        });
        $('#matchpayment tbody tr').each(function(index, value) {
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="match_check[]"]').prop('checked', false);
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').prop('disabled', false);
            summatch();
        });
        if (total > 0) {
            let date1 = new Date({{ date('Y-m-d') }}).getTime();
            clearTimeout(myTimeout);
            myTimeout = setTimeout(() => {
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
            }, 9000);
        } else {
            summatch();
        }
    }

    function getlistdetailbank(params) {
        var rowjQuery = $(params).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $.ajax({
                    url: "{{ route('om.export-payout-getlistbank') }}",
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
                        $('#tableaddpayment tbody tr:eq('+index+')').find('select[name="payment_desc_number_bank[]"]').html('');
                        $('#tableaddpayment tbody tr:eq('+index+')').find('select[name="payment_desc_number_bank[]"]').append('<option value=""></option>');
                        $.each(data, function(key, value) {
                            if (value.primary == 'Y') {
                                $('#tableaddpayment tbody tr:eq('+index+')').find('select[name="payment_desc_number_bank[]"]').append('<option value="'+value.bank_account_name+'" selected>'+value.bank_account_name+'</option>');
                                changeBankdesc(params);
                            } else {
                                $('#tableaddpayment tbody tr:eq('+index+')').find('select[name="payment_desc_number_bank[]"]').append('<option value="'+value.bank_account_name+'">'+value.bank_account_name+'</option>');
                            }
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

    function changeBankdesc(v){
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        var vv = $('#tableaddpayment tbody tr:eq('+index+')').find('select[name="payment_desc_number_bank[]"]').children("option:selected").val();
        $.ajax({
                    url: "{{ route('om.export-payout-getvaluebank') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "valuebank": vv,
                    },
                    cache: false,
                    success: function(res) {
                        console.log(res);
                        var data = res.data;
                        if($('#tableaddpayment tbody tr:eq('+index+')').find('input[name="bank_code[]"]').length == 0){
                            $('#tableaddpayment tbody tr:eq('+index+')').append('<input type="hidden" name="bank_code[]" value="'+data.bank_number+'">');
                        }else{
                            $('#tableaddpayment tbody tr:eq('+index+')').find('input[name="bank_code[]"]').val(data.bank_number);
                        }
                        if($('#tableaddpayment tbody tr:eq('+index+')').find('input[name="number_payment[]"]').length == 0){
                            $('#tableaddpayment tbody tr:eq('+index+')').append('<input type="hidden" name="number_payment[]" value="'+data.bank_account_number+'">');
                        }else {
                            $('#tableaddpayment tbody tr:eq('+index+')').find('input[name="number_payment[]"]').val(data.bank_account_number);
                        }
                    },
                    error: function(error) {
                        console.log(error.responseText);
                    }
                });
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

    function deleteRow(element, tableid) {
        var rowjQuery = $(element).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#' + tableid + ' tbody').find('tr:eq(' + index + ')').remove();
        if (tableid == 'tableaddpayment') {
            countsumpayment();
        } else {
            summatch();
        }
        autoRownumber(tableid);
    }

    function countsumpayment() {
        var total = 0;
        $('#tableaddpayment tbody tr').each(function(index, value) {
            var pay = 0;
            var noCommasrate;
            var noCommasamounts;
            var rates = $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="exchangerates[]"]').val();
            var amounts = $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val();
            if(rates == '' || rates == null){
                noCommasrate = 0;
            } else {
                noCommasrate = rates.replace(/,/g, '');
            }

            if(amounts == '' || amounts == null){
                noCommasamounts = 0;
            } else {
                noCommasamounts = amounts.replace(/,/g, '');
            }

            if(isNaN(parseFloat(noCommasrate))){
                total += 0;
            } else {
                if(isNaN(parseFloat(noCommasamounts))){
                    total += 0;
                } else {
                    total += parseFloat(noCommasrate) * parseFloat(noCommasamounts);
                }
            }

            if(isNaN(parseFloat(noCommasrate))){
                pay = 0;
            } else {
                if(isNaN(parseFloat(noCommasamounts))){
                    pay = 0;
                } else {
                    pay = parseFloat(noCommasrate) * parseFloat(noCommasamounts);
                }
            }

            $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val(noCommasamounts);
            $('#tableaddpayment tbody tr:eq(' + index + ') td:eq(6)').text($.number(pay,2));
            $('#tableaddpayment tbody tr:eq(' + index + ') td:eq(6)').append('<input type="hidden" name="total_payment_amount[]" value="'+ ($.number(pay,2)) +'">');
        });
        $('#total').html('<strong class="black">' + $.number(total,2) + '</strong>');
    }


    function countsumpayment2() {
        console.log('countsumpayment2');
        var total = 0;
        $('#tableaddpayment tbody tr').each(function(index, value) {
            var amounts = $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="total_payment_amount[]"]').val();

            if(amounts == '' || amounts == null){
                noCommasamounts = 0;
            } else {
                noCommasamounts = amounts.replace(/,/g, '');
            }

            if(isNaN(parseFloat(noCommasamounts))){
                total += 0;
            } else {
                total += parseFloat(noCommasamounts);
            }
        });
        $('#total').html('<strong class="black">' + $.number(total,2) + '</strong>');
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

        $('#tableaddpayment tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
            var noCommas = value.value.replace(/,/g, '');
            payment += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
            // if (total != 0) {
            //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').prop(
            //         'disabled', true);
            //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="exchangerates[]"]').prop(
            //         'disabled', true);
            // } else {
            //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').prop(
            //         'disabled', false);
            //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="exchangerates[]"]').prop(
            //         'disabled', false);
            // }
        });


        $('#matchpayment tbody tr td input[name="match_check[]"]').each(function(index, value) {
            var splitStr = value.value.split(':');
            if (this.checked) {
                var noCammasPayamount = $('#matchpayment tbody tr:eq(' + index + ') td:eq(9)').find('input[name="amount_fines[]"]').val();
                var noCammasmatch_amount = $('#matchpayment tbody tr:eq(' + index + ')').find(
                    'input[name="paymatch[]"]').val();
                var nopaymentvat = $('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').find('input[name="amount_vat[]"]').val().replace(/,/g,'');
                var npCommastotal = $('#matchpayment tbody tr:eq(' + index + ') td:eq(12)').find('input[name="balancetotal[]"]').val().replace(/,/g,'');
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
                    var nocommasfines = $('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').find('input[name="amount_vat[]"]').val().replace(/,/g,'');
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

                    $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val($.number(dT,2));
                    $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balance[]"]').val($.number(dT,2));
                    $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balancetotal[]"]').val($.number(dT,2));
                    console.log(d);
                    console.log(dT);
                    console.log($('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val());
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
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="paymatch[]"]').prop('disabled',false);
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').prop('disabled', false);
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val($('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').text());
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balancetotal[]"]').val($('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').text());
                $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balance[]"]').val($('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').text());
            }
        });

        if ($('#matchpayment tbody tr td input[name="match_check[]"]:checked').length > 0) {
            $('#tableaddpayment tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
                // if (total != 0) {
                //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').prop('disabled', true);
                // } else {
                //     $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').prop('disabled', false);
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
        // summatchnew();
    }

    function summatchnew() {
        console.log('summatchnew()');
        $('#matchpayment tbody tr').each(function(index, value) {
            var noCammastotal = $('#matchpayment tbody tr:eq(' + index + ') td:eq(3)').text();
            var noCammastotalpay = $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="paymatch[]"]').val();
            var number1 = isNaN(parseFloat(noCammastotalpay.replace(/,/g, ''))) ? 0 : parseFloat(noCammastotalpay.replace(/,/g, ''));
            var number2 = isNaN(parseFloat(noCammastotal.replace(/,/g, ''))) ? 0 : parseFloat(noCammastotal.replace(/,/g, ''));
            var sum = number2 - number1;
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val(addCommas(sum.toFixed(2)));
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balancetotal[]"]').val(sum.toFixed(2));
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="paymatch[]"]').val(addCommas(number1.toFixed(2)));
            $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="amount_balance[]"]').val(sum.toFixed(2));
        });
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

    function dnmatch(element, v) {
        if(v == null || v == ''){
            return;
        } else {
            var customer_number = $('input[name="customer_numbers"]').val();
            $.ajax({
                    url: "{{ route('om.export-method-getvaluefromnumber') }}",
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
                        console.log(res);
                        if(res.status == 'choose'){
                            var darares = res.data;
                            var myArrayOfThings = darares;

                            var options = {};
                            $.map(myArrayOfThings,
                                function(o) {
                                    if(o.credit_group_code == 0){
                                        options[o.credit_group_code] = 'เงินสด';
                                    } else {
                                        options[o.credit_group_code] = o.credit_group_code;
                                    }
                            });
                            Swal.fire({
                                title: 'เลือกกลุ่มวงเงินเอกสารเลขที่ '+v,
                                input: 'select',
                                inputOptions: options,
                                inputPlaceholder: 'กรุณาเลือกกลุ่มวงเงิน',
                                showCancelButton: true,
                                inputValidator: function (value) {
                                    return new Promise(function (resolve, reject) {
                                    if (value !== '') {
                                        resolve();
                                    } else {
                                        resolve('กรุณาเลือกกลุ่มวงเงิน');
                                    }
                                    });
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    dnmatchfromcredit(element,v,result.value);
                                }
                            });
                        } else {
                            var datas = res.data;
                            console.log(datas);
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
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(8)').text(datas.curren);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(8)').append(
                                '<input type="hidden" name="currency[]" value="'+datas.curren+'">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(9)').text(datas.amount_fines);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(9)').append(
                                '<input type="hidden" name="amount_fines[]" value="'+datas.amount_fines+'">');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="paymatch[]"]').val('');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="amount_match[]"]').val('0.00');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(11)').text(addCommas(invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(11)').append(
                                '<input type="hidden" name="amount_balance[]" value="' + invoice_amount.toFixed(2) + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="balancetotal[]"]').val(addCommas(invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="amount_balancetotal[]"]').val(invoice_amount.toFixed(2));
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="match_check[]"]').val(datas
                                .order_header_id + ':DRAFT:'+indextr);
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

    function dnmatchfromcredit(element, v, c){
        if(v == null || v == '' || c == null || c == ''){
            return;
        } else {
            var customer_number = $('input[name="customer_numbers"]').val();
            $.ajax({
                    url: "{{ route('om.export-method-getvaluefromnumber') }}",
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
                        console.log(res);
                        if(res.status == 'success'){
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
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(8)').text(datas.currency);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(8)').append(
                                '<input type="hidden" name="currency[]" value="'+datas.currency+'">');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(9)').text(datas.amount_fines);
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(9)').append(
                                '<input type="hidden" name="amount_fines[]" value="'+datas.amount_fines+'">');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="paymatch[]"]').val('');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="amount_match[]"]').val('0.00');
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(11)').text(addCommas(invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ') td:eq(11)').append(
                                '<input type="hidden" name="amount_balance[]" value="' + invoice_amount.toFixed(2) + '">');
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="balancetotal[]"]').val(addCommas(invoice_amount.toFixed(2)));
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="amount_balancetotal[]"]').val(invoice_amount.toFixed(2));
                            $('#matchpayment tbody tr:eq(' + indextr + ')').find('input[name="match_check[]"]').val(datas
                                .order_header_id + ':DRAFT:'+indextr);
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

    function searchDPayment() {
        $('#add').prop('disabled', true);
        var customer_number = $('input[name="customer_number"]').val();
        // var invoice_number = $('select[name="invoice_number"] option:selected').val();
        // var invoice_number_sa = $('select[name="invoice_number_sa"] option:selected').val();
        // var invoice_number_debit = $('select[name="invoice_number_debit"] option:selected').val();
        // var invoice_date_number = $('input[name="invoice_date_number"]').val();
        // var sum_amont_total = 0;
        // $('#tableaddpayment tbody tr').each(function(index, value) {
        //     var tddd = $('#tableaddpayment tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val();
        //     sum_amont_total += isNaN(parseFloat(tddd)) ? 0 : parseFloat(tddd);
        // });
        var sum_amont_total = $('#total .black').text();
        console.log(sum_amont_total);
        // if ((customer_number == '') && (invoice_number == '') && (invoice_number_sa == '') && (invoice_date_number == '') && (invoice_number_debit == '')) {
        //     Swal.fire({
        //         title: 'กรุณาระบุรายละเอียดที่ต้องการค้นหา',
        //         icon: 'error'
        //     });
        //     return false;
        // }
        // if(customer_number == '' && customer_number != $('input[name="customer_number"]').val()){
        //     Swal.fire({
        //         title: 'กรุณาระบุรหัสลูกค้าหรือรหัสลูกค้าไม่สัมพันธ์กับข้อมูลข้างต้น',
        //         icon: 'error'
        //     });
        //     return false;
        // }
        $('#matchpayment tbody tr.jsonloop').each(function(index, value) {
            this.remove();
        });
        summatch();
        $.ajax({
            url: "{{ request()->getSchemeAndHttpHost() }}/om/export-payout/draftpayment",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "customer_number": customer_number,
                "total_amount": sum_amont_total,
                // "invoice_number": invoice_number,
                // "invoice_number_sa": invoice_number_sa,
                // "invoice_date_number": invoice_date_number,
                // "invoice_number_debit": invoice_number_debit
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
                console.log(res);
                if (res.status == 'error') {
                    Swal.fire({
                        title: res.msg,
                        icon: 'error'
                    });
                } else {
                    swal.close();
                    $('#add').prop('disabled', false);
                    @if(Request::old('callback_search_omp67'))
                        if (res.data != '<tr class=\"align-middle jsonloopnotfound\"><td colspan=\"15\" class=\"text-danger text-center\">ไม่พบข้อมูลหนี้ค้างชำระ</td></tr>') {
                            $("#matchpayment tbody").append(res.data);
                        }
                    @else
                        $("#matchpayment tbody").html(res.data);
                    @endif
                    $('input[name="bbalance"]').val(res.amount_before);
                    $('input[name="bbalance_amounts"]').val(res.amount_before);
                    $('#cn tbody').html('');

                    $('#savematch').attr('disabled', false);
                    var preparenumber = res.dataordernumbers;
                    var invoicenumber = res.datainvoices;
                    var datadebits = res.datadebits;
                    datacn = res.cn;

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


                    //invoice_number_sa
                    // var htmlstart = '<select class="form-control select2" name="invoice_number_sa" style="height: 40px!important;"><option value=""></option>';

                    //     if(invoice_number_sa == '' || invoice_number_sa == 'undefined'){
                    //         var cdraft_number = '';
                    //     } else {
                    //         var cdraft_number = invoice_number_sa
                    //     }
                    //     $.each(preparenumber, function(key, value){
                    //         if(cdraft_number  == value){
                    //             var data = '<option value="'+value+'" selected>'+value+'</option>';
                    //         } else {
                    //             var data = '<option value="'+value+'">'+value+'</option>';
                    //         }
                    //         htmlstart = htmlstart+data;
                    //     });
                    //     var endhaml = htmlstart + '</select>';
                    //     $('#draft_number_info').html(endhaml);

                        //invoice_number
                        // var htmlstartinvoicenumber = '<select class="form-control select2" name="invoice_number" style="height: 40px!important;"><option value=""></option>';
                        // if(invoice_number == '' || invoice_number == 'undefined'){
                        //     var cinvoice_number = '';
                        // } else {
                        //     var cinvoice_number = invoice_number
                        // }
                        // $.each(invoicenumber, function(key, value){
                        //     if(cinvoice_number == value){
                        //         var data = '<option value="'+value+'" selected>'+value+'</option>';
                        //     } else {
                        //         var data = '<option value="'+value+'">'+value+'</option>';
                        //     }
                        //     htmlstartinvoicenumber = htmlstartinvoicenumber+data;
                        // });
                        // var endhamlinvoicenumber = htmlstartinvoicenumber + '</select>';
                        // $('#invoice_number_info').html(endhamlinvoicenumber);

                        // var htmlstartdebit = '<select class="form-control select2" name="invoice_number_debit" style="height: 40px!important;"><option value=""></option>';
                        // if(invoice_number_debit == '' || invoice_number_debit == 'undefined'){
                        //     var cdebit = '';
                        // } else {
                        //     var cdebit = invoice_number_debit
                        // }
                        // $.each(datadebits, function(key, value){
                        //     if(cdebit == value){
                        //         var data = '<option value="'+value+'" selected>'+value+'</option>';
                        //     } else {
                        //         var data = '<option value="'+value+'">'+value+'</option>';
                        //     }
                        //     htmlstartdebit = htmlstartdebit+data;
                        // });
                        // var endhamldebit = htmlstartdebit + '</select>';
                        // $('#invoice_number_debit').html(endhamldebit);
                        if(res.popup){
                            Swal.fire({
                                title: res.popupmsg,
                                icon: 'error'
                            });
                        } else {
                            swal.close();
                        }
                        select2auto();
                        summatch();
                }
            },
            error: function(error) {
                console.log(error.responseText);
                Swal.fire({
                    title: error.responseText,
                    icon: 'error'
                });
            }
        });
    }
</script>
@endsection
