@extends('layouts.app')

@section('title', 'บันทึก Matching')

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

    .red {
        color: crimson;
    }
</style>
@stop

@section('page-title')
<h2>
    {{-- <x-get-program-code url="/om/export-matching" /> บันทึก Matching --}}
    <x-get-page-title menu="" url="/om/export-matching" />
</h2>
{{-- <ol class="breadcrumb"> --}}
    {{-- <li class="breadcrumb-item">
        <a href="/">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>
            <x-get-program-code url="/om/export-matching" /> บันทึก Matching
        </strong>
    </li>
</ol> --}}
@stop

@section('content')
@if (Request::old('error'))
<div class="alert alert-danger alert-block tw-border-2 tw-border-red-dark">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ Request::old('error') }}</strong>
</div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>บันทึก Matching</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-12">
                    <div class="form-header-buttons">
                        <div class="buttons multiple">
                            <button class="btn btn-md btn-white" type="button" onclick="resetpage();"><i class="fa fa-refresh"></i> ล้างข้อมูล</button>
                            <button class="btn btn-md btn-white" type="button" onclick="searchitem();"><i class="fa fa-search"></i> ค้นหา</button>
                            <button class="btn btn-md btn-primary" type="button" id="saved"><i class="fa fa-save"></i> บันทึก</button>
                            <button class="btn btn-md btn-danger" type="button" id="deleted"><i class="fa fa-times"></i> ลบ</button>
                            <button class="btn btn-md btn-success" data-toggle="modal" data-target="#UploadModalFile" type="button" id="fileupload"><span class="fa fa-upload"> ไฟล์แนบ</span></button>

                        </div>
                    </div>
                    <!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>
                </div>
                <!--col-12-->

                <form id="matchingsearch" method="get" autocomplete="off">
                    <div class="col-xl-8 m-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">เลขที่เอกสารอ้างอิง <small class="text-danger">*</small></label>
                                    <div class="input-icon">
                                        <select class="form-control select2" onchange="searchvalue(this.value);" name="number_ref" id="orderandinvoice" required>
                                            <option></option>
                                            @foreach ($orders as $order)
                                            @if(strpos($order->prepare_order_number, 'SA') !== false)
                                            <option value="{{ $order->prepare_order_number }}" @if(request()->number_ref == $order->prepare_order_number) selected @endif>{{ $order->prepare_order_number }} : {{ $order->customer_name }}</option>
                                            @endif
                                            @endforeach

                                            @foreach($invoices as $invoice)
                                            <option value="{{ $invoice['value'] }}" @if(request()->number_ref == $invoice['value']) selected @endif>{{ $invoice['text'] }}</option>
                                            @endforeach

                                            @foreach($dninvoices as $dninvoice)
                                            <option value="{{ $dninvoice['value'] }}" @if(request()->number_ref == $dninvoice['value']) selected @endif>{{ $dninvoice['text'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">วันที่</label>
                                    <div class="input-icon">
                                        <input type="text" class="form-control" readonly name="date_ref" placeholder="" @if($searchomp0068) value="{{ \Carbon\Carbon::parse($order_date_invoice)->format('d/m/Y') }}" @endif>
                                        <input type="hidden" name="date_ref1" value="{{ \Carbon\Carbon::parse($order_date_invoice)->format('Y-m-d') }}">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <!--form-group-->
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">ประเภทการขาย</label>
                                    <input type="text" class="form-control red" readonly name="type_ref" placeholder="" @if(!empty($customerinfo)) value="{{ $customerinfo->sales_classification_code == 'Domestic' ? 'ขายในประเทศ' : 'ขายต่างประเทศ' }}" @else value="{{ Request::old('type_ref1') }}" @endif>
                                    <input type="hidden" name="type_ref1" value="{{ Request::old('type_ref1') }}">
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="d-block">รหัสลูกค้า</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-icon">
                                                @if($searchomp0068)
                                                    <input type="text" class="form-control" name="customer_ref" id="customer_number" placeholder="" list="customer_numberss" onchange="custchange(this.value);" @if($searchomp0068) value="{{ $customerinfo->customer_number }}" @endif>
                                                    <i class="fa fa-search"></i>
                                                    <datalist id="customer_numberss">
                                                        @foreach ($customers as $item)
                                                        @if($item['customer_number'] != Null)
                                                        <option value="{{ $item['customer_number'] }}">
                                                            {{ $item['customer_name'] }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </datalist>
                                                @else
                                                    <input type="text" class="form-control" name="customer_ref" id="customer_number" placeholder="" list="customer_numberss" onchange="custchange(this.value);">
                                                    <i class="fa fa-search"></i>
                                                    <datalist id="customer_numberss">
                                                        @foreach ($customers as $item)
                                                        @if($item['customer_number'] != Null)
                                                        <option value="{{ $item['customer_number'] }}">
                                                            {{ $item['customer_name'] }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </datalist>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-2 mt-md-0">
                                            @if($searchomp0068)
                                                <input type="text" class="form-control" readonly name="customer_name_ref" placeholder="" @if($searchomp0068) value="{{ $customerinfo->customer_name }}" @else value="{{ Request::old('customer_name_ref1') }}" @endif>
                                                <input type="hidden" name="customer_name_ref1" @if($searchomp0068) value="{{ $customerinfo->customer_name }}" @else value="{{ Request::old('customer_name_ref1') }}" @endif>
                                            @else
                                                <input type="text" class="form-control" readonly name="customer_name_ref" placeholder="">
                                                <input type="hidden" name="customer_name_ref1">
                                            @endif
                                        </div>
                                    </div>
                                    <!--row-->
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-12"></div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="d-block">ที่อยู่</label>
                                    @if($searchomp0068)
                                    @if($customerinfo->country_code == 'TH')
                                    <textarea class="form-control" name="address_ref" readonly>{{ $customerinfo->address_line1 }} {{ $customerinfo->address_line2 }} {{ $customerinfo->address_line3 }} {{ $customerinfo->alley }} {{ $customerinfo->district }} {{ $customerinfo->city }} {{ $customerinfo->province_name }} {{ $customerinfo->postal_code }} {{ $customerinfo->country_name }}</textarea>
                                    @else
                                    <textarea class="form-control" name="address_ref" readonly>{{ $customerinfo->address_line1 }} {{ $customerinfo->address_line2 }} {{ $customerinfo->address_line3 }} {{ $customerinfo->state }} {{ $customerinfo->city }} {{ $customerinfo->postal_code }} {{ $customerinfo->country_name }}</textarea>
                                    @endif
                                    @else
                                    <textarea class="form-control" name="address_ref" readonly>{{ Request::old('address_ref') }}</textarea>
                                    @endif
                                </div>
                                <!--form-group-->
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">จำนวนเงินรวม Vat</label>
                                    @if($searchomp0068)
                                    <input type="text" class="form-control" name="amount_ref_total" placeholder="" value="{{ number_format($totalAmount,2) }}" onkeyup="numericonly1(this,this.value);" readonly>
                                    @else
                                    <input type="text" class="form-control" name="amount_ref_total" placeholder="" value="{{ Request::old('amount_ref_total') }}" onkeyup="numericonly1(this,this.value);" readonly>
                                    @endif
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="d-block">จำนวนเงินที่รับชำระแล้ว</label>
                                    @if($searchomp0068)
                                    <input type="text" class="form-control" name="amount_ref" placeholder="" value="{{ number_format($p,2) }}" onkeyup="numericonly1(this,this.value);" readonly>
                                    @else
                                    <input type="text" class="form-control" name="amount_ref" placeholder="" value="{{ Request::old('amount_ref') }}" onkeyup="numericonly1(this,this.value);" readonly>
                                    @endif
                                </div>
                                <!--form-group-->
                            </div>
                        </div>
                        <!--row-->


                    </div>
                    <!--col-xl-6-->
                </form>

                <div class="col-md-12">
                    <hr class="lg">

                    <div class="form-header-buttons">
                        <h3 class="black mb-2 mb-md-0">ข้อมูลใบลดหนี้/ใบเสร็จรับเงิน</h3>
                        <div class="buttons d-flex">
                            <button class="btn btn-md btn-success" type="button" onclick="addpayment();" id="added" @if(!$searchomp0068) disabled @endif><i class="fa fa-plus"></i> เพิ่ม</button>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <form action="{{ route('om.export-matching-matching') }}" method="POST" id="matching">
                        @csrf
                        <input type="hidden" name="numberref_save" value="">
                        <input type="hidden" name="sa_number_for" id="sa_number_for" value="">
                        <input type="hidden" name="cust_ref" id="cust_ref" value="">
                        <input type="hidden" name="files_uploadsId" id="files_uploadsId">
                        <input type="hidden" name="order_header_id" value="{{ $order_header_id }}">
                        <input type="hidden" name="data_date" id="data_date" value="">
                        <input type="hidden" name="data_date1" id="data_date1" value="">

                        <div class="table-responsive-lg">
                            <table class="table table-bordered text-center table-hover min-1000 f13" id="addpaymenttable">
                                <thead>
                                    <tr class="align-middle">
                                        <th>ลำดับที่</th>
                                        <th class="w-201">เลขที่เอกสาร</th>
                                        <th class="w-160">วันที่</th>
                                        <th>สกุลเงิน</th>
                                        <th>อัตราการแลกเปลี่ยน</th>
                                        <th class="w-201">จำนวนเงิน</th>
                                        <th style="width: 55px">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($datapayment))
                                    <?php $total = 0;
                                    $rownumber = 0; ?>
                                    @foreach ($datapayment as $data)
                                    <?php $rownumber++;
                                    $total += $data->payment_amount; ?>
                                    <tr class="align-middle">
                                        <input type="hidden" value="{{ $data->payment_header_id }}" name="payment_id[]">
                                        <input type="hidden" value="draft" name="payment_type[]">
                                        <td>{{ $rownumber }}</td>
                                        <td>
                                            <div class="input-icon">
                                                <input type="text" class="form-control md text-center" name="payment_number[]" placeholder="" value="{{ $data->payment_number }}" readonly>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($data->creation_date)->format('d/m/Y') }}<input type="hidden" name="date_matching_ref[]" value="{{ $data->creation_date }}"></td>
                                        <td class="text-center">{{ $data->currency }}</td>
                                        <td><input type="text" class="form-control md text-right" name="exchangerate[]" value="{{ number_format($data->rate->conversion_rate ?? 0,2) }}" readonly></td>
                                        <td>
                                            <input type="text" class="form-control md text-right" name="payment_amounts[]" placeholder="" value="{{ number_format($data->payment_amount,2) }}" readonly>
                                            <input type="hidden" name="payment_amount[]" value="{{ number_format($data->payment_amount,2) }}">
                                            <input type="hidden" name="type_payment_match[]" value="old">
                                        </td>
                                        <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    @if(!empty($cns))
                                    @foreach ($cns as $dat)
                                    <?php $rownumber++;$total += $dat->invoice_amount; ?>
                                    <tr class="align-middle red">
                                        <input type="hidden" value="{{ getPaymentHeaderID($dat->payment_match_id); }}" name="payment_id[]">
                                        <input type="hidden" value="invoice" name="payment_type[]">
                                        <td>{{ $rownumber }}</td>
                                        <td>
                                            <div class="input-icon">
                                                <input type="text" class="form-control md text-center" name="payment_number[]" placeholder="" value="{{ $dat->invoice_number }}" readonly>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </td>
                                        <td>{{ FormatDate::DateThaiNumericWithSplash($dat->last_update_date) }}<input type="hidden" name="date_matching_ref[]" value="{{ $dat->last_update_date }}"></td>
                                        <td class="text-center">{{ getCurrency($dat->invoice_number) }}</td>
                                        <td><input type="text" class="form-control md text-right" name="exchangerate[]" value="{{ number_format(convertRatetoomp0068($dat->invoice_number) ?? 0,2) }}" readonly></td>
                                        <td>
                                            <input type="text" class="form-control md text-right" name="payment_amounts[]" placeholder="" value="({{ number_format($dat->invoice_amount,2) }})" readonly>
                                            <input type="hidden" name="payment_amount[]" value="{{ number_format($dat->invoice_amount,2) }}">
                                            <input type="hidden" name="type_payment_match[]" value="old">
                                        </td>
                                        <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @if(count($paymentCnDn) > 0)
                                    @foreach ($paymentCnDn as $dat)
                                    <?php $rownumber++;$total += $dat->invoice_amount; ?>
                                    <tr class="align-middle">
                                        <input type="hidden" value="{{ getPaymentHeaderID($dat->payment_match_id); }}" name="payment_id[]">
                                        <input type="hidden" value="invoice" name="payment_type[]">
                                        <td>{{ $rownumber }}</td>
                                        <td>
                                            <div class="input-icon">
                                                <input type="text" class="form-control md text-center" name="payment_number[]" placeholder="" value="{{ $dat->invoice_number }}" readonly>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($dat->last_update_date)->format('d/m/Y') }}<input type="hidden" name="date_matching_ref[]" value="{{ $dat->last_update_date }}"></td>
                                        <td class="text-center">{{ getCurrency($dat->invoice_number) }}</td>
                                        <td><input type="text" class="form-control md text-right" name="exchangerate[]" value="{{ number_format(convertRatetoomp0068($dat->invoice_number) ?? 0,2) }}" readonly></td>
                                        <td>
                                            <input type="text" class="form-control md text-right" name="payment_amounts[]" placeholder="" value="{{ number_format($dat->invoice_amount,2) }}" readonly>
                                            <input type="hidden" name="payment_amount[]" value="{{ number_format($dat->invoice_amount,2) }}">
                                            <input type="hidden" name="type_payment_match[]" value="old">
                                        </td>
                                        <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    <tr class="align-middle">
                                        <td class="text-right pt-3 pb-3" colspan="5" id="ignore"><strong class="black">จำนวนเงินรวม</strong></td>
                                        <td class="text-right pt-3 pb-3" id="total"><strong class="black">{{ number_format($total ?? 0,2) }}</strong></td>
                                        <td></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!--table-responsive-->
                    </form>

                </div>
                <!--col-md-12-->

            </div>
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
                <form id="form_attachment" data-action="{{ url('/') }}/om/export-matching/uploaded">
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
                                @if(!empty($files))
                                @foreach($files as $keyfile => $item)
                                <li id="file_attachment_{{ $item->attachment_id }}">
                                    <code><a href="{{ url('/') }}/{{ $item->path_name }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $item->file_name }}</code></a>
                                    <button class="btn btn-remove" onclick="removeFileAttachment(0,{{ $item->attachment_id }},`db`)" type="button"><i class="fa fa-times"></i></button>
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


</div>
@endsection

@section('scripts')
<script src="{!! asset('js/moment.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/lodash.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/numberformat.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/aksFileUpload.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>

<script>
    let orders = {!! json_encode($orders) !!};
    let invoices = {!! json_encode($invoices) !!};
    let customers = {!! json_encode($customers) !!};
    let dninvoices = {!! json_encode($dninvoices) !!};
    var payments;
    var invoincess;
    var htmloptionends;
    let search = {!! json_encode($searchomp0068) !!};

    $(document).ready(function() {
        $('.date').datepicker();
        $('.select2').select2({
            templateSelection: function(data, container) {
                $(data.element).attr('data-custom-attribute', data.customValue);
                return data.id;
            }
        });

        $(".aks-file-upload-files").aksFileUpload({
            dragDrop: true,
            maxSize: "1 GB",
            multiple: true,
            maxFile: 50
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

        $('#saved').click(function() {
            var da = $('input[name="date_ref"]').val();
            var da1 = $('input[name="date_ref1"]').val();
            var sa = $('select[name="number_ref"] option:selected').val();
            var cus = $('select[name="customer_ref"] option:selected').val();
            if ($('input[name="number_ref"]').val() == '') {
                Swal.fire({
                    title: 'กรุณาระบุเลขที่เอกสารอ้างอิง',
                    icon: 'error'
                });
                return false;
            }
            if ($('#addpaymenttable tbody tr').length == 0) {
                Swal.fire({
                    title: 'ไม่พบข้อมูลให้บันทึก',
                    icon: 'error'
                });
                return false;
            }
            Swal.fire({
                title: 'กำลังบันทึกข้อมูล',
                showCancelButton: false,
                showConfirmButton: false
            });
            $('input[name="numberref_save"]').val($('input[name="number_ref"]').val());
            $('#sa_number_for').val(sa);
            $('#cust_ref').val(cus);
            $('#data_date').val(da);
            $('#data_date1').val(da1);
            $('#matching').submit();
        });

        $('#deleted').click(function() {
            if ($('select[name="number_ref"] option:selected').val() == '') {
                Swal.fire({
                    title: 'กรุณาระบุเลขที่เอกสารอ้างอิง',
                    icon: 'error'
                });
                return false;
            }
            if ($('#addpaymenttable tbody tr').length == 0) {
                Swal.fire({
                    title: 'ไม่พบข้อมูลให้ลบ',
                    icon: 'error'
                });
                return false;
            }
            Swal.fire({
                title: "ยืนยัน?",
                text: "ต้องการยกเลิกการ Match ทั้งหมด?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
            }).then((result) => {
                if(result.isConfirmed){
                        $.ajax({
                            url: "{{ url('/') }}/om/export-matching/unmatching",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "number_ref": $('select[name="number_ref"] option:selected').val(),
                            },
                            cache: false,
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'ระบบกำลังดำเนินการยกเลิกการ Matching ทั้งหมด',
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            },
                            success: function(res) {
                                if(res.status == 'error') {
                                    Swal.fire({
                                        title: res.data,
                                        icon: 'error'
                                    });
                                } else {
                                    Swal.fire({
                                        title: res.data,
                                        icon: 'success'
                                    }).then((result) => {
                                        $('#matchingsearch').submit();
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
                } else {
                    result.dismiss === Swal.DismissReason.cancel
                }
            });
                // function(isConfirm) {
                //     if (isConfirm) {
                //         $.ajax({
                //             url: "{{ url('/') }}/om/export-matching/unmatching",
                //             type: "POST",
                //             data: {
                //                 "_token": "{{ csrf_token() }}",
                //                 "number_ref": $('select[name="number_ref"] option:selected').val(),
                //             },
                //             cache: false,
                //             beforeSend: function() {
                //                 Swal.fire({
                //                     title: 'Unmatching in process',
                //                     showCancelButton: false,
                //                     showConfirmButton: false
                //                 });
                //             },
                //             success: function(res) {
                //                 Swal.fire({
                //                     title: 'Unmatching Success',
                //                     icon: 'success'
                //                 });
                //             },
                //             error: function(error) {
                //                 Swal.fire({
                //                     title: error.responseText,
                //                     icon: 'error'
                //                 });
                //             }
                //         });
                //     }
                // });
        });
    });


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
                console.log(result);
                if (result.status == 200) {
                    $("ul.files").empty();
                    fileChoose = [];
                    fileRunChoose = -1;
                    fileSecChoose += 1;
                    clearInputFile()
                    var html = '';
                    var files_uploadsId = [];
                    $.each(result.attachments, function(index, fileInfo) {
                        html += '<li id="file_choose_' + index + '_' + fileInfo.attachment_id + '">' +
                            '<code><a href="{{ url("/") }}/' + fileInfo.path_name + '/' + fileInfo.file_name + '" target="_blank"><i class="fa fa-file-pdf-o"></i>  ' + fileInfo.file_name + '</code></a>' +
                            '<button class="btn btn-remove" onclick="removeFileAttachment(' + index + ',' + fileInfo.attachment_id + ',`db`)" type="button"><i class="fa fa-times"></i></button>' +
                            '</li>';
                        files_uploadsId.push(fileInfo.attachment_id);
                    });
                    $("ul.files").append(html);
                    $('#files_uploadsId').val("" + files_uploadsId + "");
                    $('#UploadModalFile').modal('hide');
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
                console.log(data);
                $('#UploadModalFile').modal('hide')
            }
        });
    });

    function resetpage() {
        window.location.href = "/om/export-matching";
    }

    function clearInputFile(type = '') {
        $('#attachment').replaceWith($('#attachment').val('').clone(true));
        $('#attachment').val('');
        $("#attachment").val(null);
        $('.label-attachment').html('Choose file...')
        if (type == 'clear') {
            delete fileChoose[fileRunChoose];
            // fileRunChoose = -1;
        }
        console.log(fileChoose);
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
                url: "{{ url('/') }}/om/export-matching/upload/deleted",
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
                    console.log("error : " + data);
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
        console.log($('input[name="files_upload').val());
    };

    function filedeletefromid(id, key) {
        if (id == '' && key == '') {
            return false;
        }
    }

    function numericonly1(v, l) {
        $('input[name="amount_ref"]').val(l.replace(/[^0-9\.|\,]/g, ''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }

        var currentVal = l;
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
            currentVal = currentVal.slice(0, -1);
        }
        $('input[name="amount_ref"]').val(replaceCommas(currentVal));
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

    function numericonly2(v, l) {
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="exchangerate[]"]').val(l.replace(/[^0-9\.|\,]/g, ''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }
    }

    function numericonly3(v, l) {
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val(l.replace(/[^0-9\.|\,]/g, ''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }
    }

    function custchange(v) {
        var vtypec = $('select[name=credit_ref] option').filter(':selected').val();
        if (v == '' || v == null) {
            $('input[name="customer_name_ref"]').val('');
            $('input[name="type_ref"]').val('');
            $('input[name="amount_ref"]').val('');
            $('textarea[name="address_ref"]').val('');
        } else {
            var sa_number = $('select[name="number_ref"] option:selected').val();
            var index = _.findIndex(customers, function(o) {
                return o.customer_number == v;
            });
            if (customers[index].sales_classification_code.toLowerCase() == 'export') {
                $('input[name="type_ref"]').val('ขายต่างประเทศ');
                $('input[name="type_ref1"]').val('ขายต่างประเทศ');
            } else {
                $('input[name="type_ref"]').val('ขายในประเทศ');
                $('input[name="type_ref1"]').val('ขายในประเทศ');
            }
            $('input[name="customer_name_ref"]').val(customers[index].customer_name);
            $('input[name="customer_name_ref1"]').val(customers[index].customer_name);
            var line1;
            var line2;
            var line3;
            var alley;
            var district;
            var city;
            var province;
            if (customers[index].address_line1 == null) {
                line1 = '';
            } else {
                line1 = customers[index].address_line1;
            }
            if (customers[index].address_line2 == null) {
                line2 = '';
            } else {
                line2 = customers[index].address_line2;
            }
            if (customers[index].address_line3 == null) {
                line3 = '';
            } else {
                line3 = customers[index].address_line3;
            }
            if (customers[index].city == null) {
                city = '';
            } else {
                city = customers[index].city;
            }
            if (customers[index].district == null) {
                district = '';
            } else {
                district = customers[index].district;
            }
            if (customers[index].alley == null) {
                alley = '';
            } else {
                alley = customers[index].alley;
            }
            if (customers[index].province_name == null) {
                province = '';
            } else {
                province = customers[index].province_name;
            }

            $('textarea[name="address_ref"]').val(line1 + ' ' + line2 + ' ' + line3 + ' ' + alley + ' ' + district + ' ' + city + ' ' + province);
            $.ajax({
                url: "{{ route('om.export-matching-getinvoice') }}",
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
                    var data = res.data;
                    $('#orderandinvoice').html('');
                    $('#orderandinvoice').append(data);
                    select2auto();
                    if (sa_number != '') {
                        $('select[name="number_ref"] option:selected').val('');
                        getpayment();
                    } else {
                        swal.close();
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

    function getpayment() {
        // var sa = $('select[name="number_ref"] option:selected').val();
        // $.ajax({
        //     url: "{{ route('om.export-matching-getamount') }}",
        //     type: "POST",
        //     data: {
        //         "_token": "{{ csrf_token() }}",
        //         "sa_number": $('select[name="number_ref"] option:selected').val(),
        //         "customer_ref": $('input[name="customer_ref"]').val(),
        //         "search": search
        //     },
        //     cache: false,
        //     beforeSend: function() {
        //         Swal.fire({
        //             title: 'กรุณารอสักครู่',
        //             showCancelButton: false,
        //             showConfirmButton: false
        //         });
        //     },
        //     success: function(res) {
        //         console.log(res);
        //         var datas = res.data;
        //         var totalAmount = res.totalAmount;
        //         if (datas == 0) {
        //             var p = '0.00';
        //         } else {
        //             var p = parseFloat(datas).toFixed(2);
        //         }
        //         if (totalAmount == 0) {
        //             var p2 = '0.00';
        //         } else {
        //             var p2 = parseFloat(totalAmount).toFixed(2);
        //         }
        //         $('input[name="amount_ref"]').val(addCommas(p));
        //         $('input[name="amount_ref_total"]').val(addCommas(p2));
        //         $('input[name="order_header_id"]').val(res.header_id);
        //         $('#addpaymenttable tbody').html(res.html);
        //         swal.close();
        //     },
        //     error: function(error) {
        //         Swal.fire({
        //             title: error.responseText,
        //             icon: 'error'
        //         });
        //     }
        // });
    }

    function searchvalue(v) {
        if (v == '') {
            $('input[name="date_ref"]').val('');
            $('input[name="date_ref1"]').val('');
        } else {
            var customer_number = $('#customer_number').val();
            var indexorder = _.findIndex(orders, function(o) {
                return o.prepare_order_number == v;
            });
            if (indexorder == -1) {
                var indexdninvoice = _.findIndex(dninvoices, function(o) {
                    return o.value == v;
                });
                if(indexdninvoice == -1){
                    var indexdninvoices = _.findIndex(invoices, function(o) {
                        return o.value == v;
                    });
                    var info = invoices[indexdninvoices].date;
                    var info1 = info.split(" ");
                    var info2 = info1[0].split("-");
                    var result = info2[2] + '/' + info2[1] + '/' + info2[0];
                    var result2 = info2[0] + '-' + info2[1] + '-' + info2[2];
                    $('input[name="date_ref"]').val(result);
                    $('input[name="date_ref1"]').val(result2);
                } else {
                    var info = dninvoices[indexdninvoice].date;
                    var info1 = info.split(" ");
                    var info2 = info1[0].split("-");
                    var result = info2[2] + '/' + info2[1] + '/' + info2[0];
                    var result2 = info2[0] + '-' + info2[1] + '-' + info2[2];
                    $('input[name="date_ref"]').val(result);
                    $('input[name="date_ref1"]').val(result2);
                }
            } else {
                var info = orders[indexorder].order_date;
                var info1 = info.split(" ");
                var info2 = info1[0].split("-");
                var result = info2[2] + '/' + info2[1] + '/' + info2[0];
                var result2 = info2[0] + '-' + info2[1] + '-' + info2[2];
                $('input[name="date_ref"]').val(result);
                $('input[name="date_ref1"]').val(result2);
            }
            if (customer_number != '') {
                getpayment();
            }
        }
    }

    function searchitem() {
        if ($('select[name="number_ref"] option:selected').val() == '') {
            Swal.fire({
                title: 'กรุณาระบุเลขที่เอกสารอ้างอิง',
                icon: 'error'
            });
            return false;
        }
        Swal.fire({
            title: 'กำลังค้นหา',
            showCancelButton: false,
            showConfirmButton: false
        });
        $('#matchingsearch').submit();
    }

    function deletefile(id, index) {
        Swal.fire({
                title: "ยืนยัน?",
                text: "ต้องการลบไฟล์ที่เลือกใช่หรือไม่?",
                type: "warning",
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
                        url: "{{ url('/') }}/om/export-matching/upload/deleted",
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
                            swal.close();
                            Swal.fire({
                                title: res.data,
                                icon: 'success'
                            });
                        },
                        error: function(error) {
                            swal.close();
                            Swal.fire({
                                title: error.responseText,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
    }

    function addpayment() {
        var list_prepare_order = [];

        $('#addpaymenttable tbody tr td select[name="payment_number[]"] > option:selected').each(function(index, value) {
            if (value.value != null || value.value != '') {
                list_prepare_order.push(value.value);
            }
            console.log(value.value);
        });

        if ($('input[name="customer_ref"]').val() == '' || $('input[name="payment_id"]').val() == '') {
            Swal.fire({
                title: 'กรุณาระบุรหัสลูกค้าหรือเลขที่เอกสารอ้างอิง',
                icon: 'error'
            });
            return false;
        }

        if (list_prepare_order.length == 0) {
            var list = '';
        } else {
            var list = list_prepare_order;
        }

        $.ajax({
            url: "{{ url('/') }}/om/export-matching/getData",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "customer_ref": $('input[name="customer_ref"]').val(),
                "prepare_order_number": $('select[name="number_ref"] option:selected').val(),
                "list": list
            },
            cache: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'กำลังเตรียมข้อมูล',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res) {
                payments = res.payments;
                invoincess = res.invoicess;

                console.log(res);

                if (payments.length == 0 && invoincess.length == 0) {
                    Swal.fire({
                        title: 'ไม่พบข้อมูลที่สามารถดำเนินการบันทึก Matching ได้',
                        icon: 'warning'
                    });
                } else {
                    var htmloptionstart = '<select class="form-control select2" name="payment_number[]" required onchange=listvaluetoinput(this);><option></option>';
                        $.each(payments, function(key, value) {
                                console.log(value.payment_number);
                                if(list_prepare_order.indexOf(value.payment_number) == '-1'){
                                    var data = '<option value="'+ value.payment_number + '">' + value.payment_number + '</option>';
                                    htmloptionstart = htmloptionstart + data;
                                }
                            });

                            $.each(invoincess, function(key, value) {
                                if(list_prepare_order.indexOf(value.invoice_headers_number) == '-1'){
                                    var data = '<option value="'+ value.invoice_headers_number +'">' + value.invoice_headers_number + '</option>';
                                    htmloptionstart = htmloptionstart + data;
                                }
                            });

                    var htmloptionend = '</select>';
                    htmloptionends = htmloptionstart + htmloptionend;

                    addrowstd();
                    swal.close();
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

    function addrowstd() {
        $('#addpaymenttable tbody').find("tr:last").before('<tr class="align-middle"><input type="hidden" value="" name="payment_id[]"><input type="hidden" value="" name="payment_type[]"><td></td> <td><div class="input-icon">' + htmloptionends + '</div></td> <td><input type="hidden" name="date_matching_ref[]" value=""></td><td></td> <td></td> <td><input type="text" name="payment_amounts[]" placeholder="" value="" class="form-control md text-right" onchange="countsumpayment();numericonly3(this,this.value);(function(el){el.value=addCommas(parseFloat(el.value).toFixed(2));})(this)" onkeyup="maxvalue(this,this.value);"><input type="hidden" name="payment_amount[]"><input type="hidden" name="type_payment_match[]" value="new"></td> <td class="text-center"><a href="javascript:void(0);" class="fa fa-times red" onclick="deleteRow(this);"></a></td></tr>');
        autoRownumber();
    }

    function maxvalue(element, v) {
        var rowjQuery = $(element).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        var value = $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val();

        if (parseFloat(v.replace(/,/g, '')) > parseFloat(value.replace(/,/g, ''))) {
            Swal.fire({
                title: 'จำนวนเงินไม่สามารถมากกว่า ' + $.number(value, 2) + ' ได้',
                icon: 'warning'
            });
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val($.number(value, 2));
            countsumpayment();
            return false;
        }
    }

    function listvaluetoinput(element) {
        var exchnegtload = false;
        if (element.value == '') {
            return false;
        }
        var rowjQuery = $(element).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        var indexpayment = _.findIndex(payments, function(o) {
            return o.payment_number == element.value;
        });
        if (indexpayment == -1) {
            var indexinvoce = _.findIndex(invoincess, function(i) {
                return i.invoice_headers_number == element.value;
            });
            if (indexinvoce == -1) {
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    icon: 'error'
                });
                return false;
            }

            var vat = $('input[name="amount_ref_total"]').val();
            var amount = $('input[name="amount_ref"]').val();
            console.log(vat);
            console.log(amount);
            if ((parseFloat(invoincess[indexinvoce].invoice_amount) + parseFloat(amount.replace(/,/g, ''))) > parseFloat(vat.replace(/,/g, ''))) {
                var amount_to = parseFloat(vat.replace(/,/g, '')) - parseFloat(amount.replace(/,/g, ''));
                Swal.fire({
                    title: 'ยอดหนี้คงเหลือที่สามารถ match ได้ ' + $.number(amount_to, 2) + ' ยอดเงินของใบลดหนี้ ' + $.number(invoincess[indexinvoce].invoice_amount, 2),
                    icon: 'warning'
                });
                var date = new Date(moment(invoincess[indexinvoce].invoice_date).format("YYYY-MM-DD"));
                var year = date.getFullYear() + 543;
                var month = date.getMonth() + 1
                var day = date.getDate();
                var formatted = day + "/" + month + "/" + year;
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_id[]"]').val(invoincess[indexinvoce].invoice_headers_id);
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_type[]"]').val('invoice');
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val($.number(amount_to, 2));
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val($.number(amount_to, 2));
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').attr({
                    'min': 1,
                    'max': amount_to
                });
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').text(formatted);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').append('<input type="hidden" name="date_matching_ref[]" value="' + invoincess[indexinvoce].invoice_date + '">');
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(3)').text(invoincess[indexinvoce].currency);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(4)').text(invoincess[indexinvoce].exchange_rate);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(4)').append('<input type="text" class="form-control md text-right" name="exchangerate[]" value="" onkeyup="numericonly2(this,this.value);" readonly>');
                
                var payment_header_id = invoincess[indexinvoce].invoice_headers_id;
                var type_add = 'invoice';
                exchnegtload = true;
            } else {
                exchnegtload = true;
                var date = new Date(moment(invoincess[indexinvoce].invoice_date).format("YYYY-MM-DD"));
                var year = date.getFullYear() + 543;
                var month = date.getMonth() + 1
                var day = date.getDate();
                var formatted = day + "/" + month + "/" + year;
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_id[]"]').val(invoincess[indexinvoce].invoice_headers_id);
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_type[]"]').val('invoice');
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val($.number(invoincess[indexinvoce].invoice_amount, 2));
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val($.number(invoincess[indexinvoce].invoice_amount, 2));
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').attr({
                    'min': 1,
                    'max': invoincess[indexinvoce].invoice_amount
                });
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').text(formatted);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').append('<input type="hidden" name="date_matching_ref[]" value="' + invoincess[indexinvoce].invoice_date + '">');
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(3)').text(invoincess[indexinvoce].currency);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(4)').val(invoincess[indexinvoce].exchange_rate);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(4)').append('<input type="text" class="form-control md text-right" name="exchangerate[]" value="" onkeyup="numericonly2(this,this.value);" readonly>');

                var payment_header_id = invoincess[indexinvoce].invoice_headers_id;
                var type_add = 'invoice';
            }

        } else {
            console.log(2);
            var vat = $('input[name="amount_ref_total"]').val();
            var amount = $('input[name="amount_ref"]').val();
            console.log(vat);
            console.log(amount);
            if((parseFloat(payments[indexpayment].payment_amount) + parseFloat(amount.replace(/,/g, ''))) > parseFloat(vat.replace(/,/g, ''))){
                console.log(3);
                var sum_total_amount = 0;
                // $('#addpaymenttable tbody tr td input[name="payment_amounts[]"]').each(function(index, value) {
                //     var noCommas = value.value.replace(/,/g, '')
                //     sum_total_amount += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
                // });
                $('#addpaymenttable tbody tr').each(function(index, value) {
                    var input = $('#addpaymenttable tbody tr:eq('+index+')');
                    if(input.find('input[name="type_payment_match[]"]').val() != 'old') {
                        var noCommas = input.find('input[name="payment_amounts[]"]').val();
                        if(noCommas == 'undefined') {
                        } else if(!noCommas) {
                        } else {
                            sum_total_amount += isNaN(parseFloat(noCommas.replace(/,/g, ''))) ? 0 : parseFloat(noCommas.replace(/,/g, ''));
                        }
                    }
                });
                var amount_to = parseFloat(vat.replace(/,/g, '')) - parseFloat(amount.replace(/,/g, '')) - parseFloat(sum_total_amount);
                Swal.fire({
                        title: 'ยอดเงินที่สามารถเพิ่มได้ '+$.number(amount_to, 2)+' จากยอด '+$.number(payments[indexpayment].payment_amount, 2),
                        icon: 'warning'
                    });
            } else {
                console.log(4);
                var sum_total_amount = 0;
                $('#addpaymenttable tbody tr td input[name="payment_amounts[]"]').each(function(index, value) {
                    var noCommas = value.value.replace(/,/g, '')
                    sum_total_amount += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
                });
                if(parseFloat(sum_total_amount) + parseFloat(payments[indexpayment].payment_amount) > parseFloat(vat.replace(/,/g, ''))){
                    var n = parseFloat(vat.replace(/,/g, '')) - parseFloat(sum_total_amount);
                    var amount_to = n;
                    Swal.fire({
                        title: 'ไม่สามารถรับเงินเกินจำนวนได้',
                        icon: 'error'
                    });
                } else {
                    var amount_to = payments[indexpayment].payment_amount;
                }
            }

            if (amount_to > 0) {
                exchnegtload = true;
            }
            var date = new Date(moment(payments[indexpayment].payment_date).format("YYYY-MM-DD"));
            var year = date.getFullYear() + 543;
            var month = date.getMonth() + 1
            var day = date.getDate();
            var formatted = day + "/" + month + "/" + year;
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_id[]"]').val(payments[indexpayment].payment_header_id);
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_type[]"]').val('draft');
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val($.number(amount_to, 2));
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val($.number(amount_to, 2));
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').attr({
                'min': 1,
                'max': amount_to
            });
            $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').text(formatted);
            $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').append('<input type="hidden" name="date_matching_ref[]" value="' + payments[indexpayment].payment_date + '">');
            $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(3)').text(payments[indexpayment].currency);
            $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(4)').text('');
            $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(4)').append('<input type="text" class="form-control md text-right" name="exchangerate[]" value="" onkeyup="numericonly2(this,this.value);" readonly>');

            var payment_header_id = payments[indexpayment].payment_header_id;
            var type_add = 'draft';
        }
        countsumpayment();

        if (exchnegtload) {
            $.ajax({
                url: "{{ url('/') }}/om/export-matching/getDataexchangerate",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "payment_header_id": payment_header_id,
                    "type_add": type_add
                },
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังดึงอัตราแลกเปลี่ยน',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(res) {
                    swal.close();
                    $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(4)').find('input[name="exchangerate[]"]').val(res.data);
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

    function select2auto() {
        $('.select2').select2({
            templateSelection: function(data, container) {
                $(data.element).attr('data-custom-attribute', data.customValue);
                return data.id;
            }
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

    function deleteRow(element) {
        var rowjQuery = $(element).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#addpaymenttable tbody').find('tr:eq(' + index + ')').remove();
        autoRownumber();
        countsumpayment();
    }

    function autoRownumber() {
        $('#addpaymenttable tbody tr').each(function(a, b) {
            $(b).find('td:eq(0)').html(a + 1);
        });
        $('#ignore').html('<strong class="black">จำนวนเงินรวมที่รับชำระ</strong>');
        $('.select2').select2();
    }

    function countsumpayment() {
        var total = 0;
        $('#addpaymenttable tbody tr td input[name="payment_amount[]"]').each(function(index, value) {
            var noCommas = value.value.replace(/,/g, '')
            total += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
        });
        $('#total').html('<strong class="black">' + addCommas(total.toFixed(2)) + '</strong>');
    }
</script>
@endsection
