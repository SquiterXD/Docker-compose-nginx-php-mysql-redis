@extends('layouts.app')

@section('title', 'บันทึก Matching')

@section('custom_css')
<link rel="stylesheet" href="{!! asset('css/aksFileUpload.min.css') !!}" />
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">

<style>
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
    {{-- <x-get-program-code url="/om/domestic-matching" /> บันทึก Matching --}}
    <x-get-page-title menu="" url="/om/domestic-matching" />
</h2>
{{-- <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/om/home">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong><x-get-program-code url="/om/domestic-matching" /> บันทึก Matching</strong>
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
                            <button class="btn btn-md btn-success" data-toggle="modal" data-target="#UploadModalFile" type="button" id="fileupload"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                            <button class="btn btn-md btn-primary" type="button" id="saved"><i class="fa fa-save"></i> บันทึก</button>
                            <button class="btn btn-md btn-danger" type="button" id="deleted"><i class="fa fa-times"></i> ลบ</button>
                        </div>
                    </div>
                    <!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>
                </div>
                <!--col-12-->

                <form id="matchingsearch" method="get" autocomplete="off">
                    <div class="col-xl-12 m-auto">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">เลขที่เอกสารอ้างอิง</label>
                                    <select class="form-control select2" onchange="searchvalue(this.value);" name="number_ref" id="orderandinvoice">
                                        <option></option>
                                        {{-- @foreach ($orders as $order)
                                            @if(strpos($order->prepare_order_number, 'SA') !== false)
                                            @else
                                                @if($order->customer_type_id == '30' && $order->product_type_code == '10')
                                                @else
                                                    <option @if($order->pick_release_no != null) value="{{ $order->pick_release_no }}" @if(request()->number_ref == $order->pick_release_no) selected @endif @else value="{{ $order->prepare_order_number }}" @if(request()->number_ref == $order->prepare_order_number) selected @endif @endif>{{ $order->prepare_order_number }} @if($order->prepare_order_number != null):@endif {{ $order->pick_release_no }} : {{ $order->customer_name }}</option>
                                                @endif
                                            @endif
                                        @endforeach --}}

                                        {{-- @foreach($consignments as $consignment)
                                            <option value="{{ $consignment['value'] }}" @if(request()->number_ref == $consignment['value']) selected @endif>{{ $consignment['text'] }}</option>
                                        @endforeach --}}

                                        @foreach($number_refs as $number_ref)
                                            <option value="{{ $number_ref['value'] }}" @if(request()->number_ref == $number_ref['value']) selected @endif>{{ $number_ref['text'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">วันที่</label>
                                    @if($searchomp0025)
                                        @if(strpos(request()->number_ref, 'F') !== false)
                                            <input type="text" class="form-control" readonly name="date_ref" placeholder="" value="{{ FormatDate::DateThaiNumericWithSplash($odr->consignment_date) }}">
                                            <input type="hidden" name="date_ref1" value="{{ \Carbon\Carbon::parse($odr->consignment_date)->format('Y-m-d') }}">
                                        @else
                                            <input type="text" class="form-control" readonly name="date_ref" placeholder="" value="{{ FormatDate::DateThaiNumericWithSplash($odr->order_date) }}">
                                            <input type="hidden" name="date_ref1" value="{{ \Carbon\Carbon::parse($odr->order_date)->format('Y-m-d') }}">
                                        @endif
                                    @else
                                        <input type="text" class="form-control" readonly name="date_ref" placeholder="" value="">
                                        <input type="hidden" name="date_ref1" value="">
                                    @endif
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">กลุ่มวงเงิน</label>
                                    <select class="custom-select" name="credit_ref" id="credit_ref" onchange="getpayment(this.value);">
                                        <option value="*" @if(Request::old('credit_ref')=='*' ) selected @endif>ทุกกลุ่มวงเงิน</option>
                                        <option value="0" @if(Request::old('credit_ref')=='0' ) selected @endif>เงินสด</option>
                                        @if(!empty($credits))
                                        @foreach ($credits as $credit)
                                        <option value="{{ $credit->lookup_code }}" @if(Request::old('credit_ref')==$credit->lookup_code) selected @endif>{{ $credit->description }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="d-block">ประเภทการขาย</label>
                                    <input type="text" class="form-control red" readonly name="type_ref" placeholder="" @if(!empty($customerinfo)) value="{{ $customerinfo->sales_classification_code == 'Domestic' ? 'ขายในประเทศ' : 'ขายต่างประเทศ' }}" @else value="{{ Request::old('type_ref1') }}" @endif>
                                    <input type="hidden" name="type_ref1" value="{{ Request::old('type_ref1') }}">
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label class="d-block">รหัสลูกค้า</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-icon">
                                                @if($searchomp0025)
                                                <input type="text" class="form-control" name="customer_ref" placeholder="" @if(!empty($customerinfo)) value="{{ $customerinfo->customer_number }}" @else value="{{ Request::old('customer_ref') }}" @endif list="customerlists" onchange="custchange(this.value);">
                                                <i class="fa fa-search"></i>
                                                <datalist id="customerlists">
                                                    @foreach ($customers as $customer)
                                                    <option value="{{ $customer->customer_number }}">
                                                        {{ $customer->customer_name }}
                                                    </option>
                                                    @endforeach
                                                </datalist>
                                                @else
                                                <input type="text" class="form-control" name="customer_ref" placeholder="" list="customerlists" onchange="custchange(this.value);">
                                                <i class="fa fa-search"></i>
                                                <datalist id="customerlists">
                                                    @foreach ($customers as $customer)
                                                    <option value="{{ $customer->customer_number }}">
                                                        {{ $customer->customer_name }}
                                                    </option>
                                                    @endforeach
                                                </datalist>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-2 mt-md-0">
                                            @if($searchomp0025)
                                            <input type="text" class="form-control" readonly name="customer_name_ref" placeholder="" @if(!empty($customerinfo)) value="{{ $customerinfo->customer_name }}" @else value="{{ Request::old('customer_name_ref1') }}" @endif>
                                            <input type="hidden" name="customer_name_ref1" @if(!empty($customerinfo)) value="{{ $customerinfo->customer_name }}" @else value="{{ Request::old('customer_name_ref1') }}" @endif>
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

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="d-block">จำนวนเงินรวม Vat</label>
                                    @if($searchomp0025)
                                    <input type="text" class="form-control" readonly name="amount_ref_total" placeholder="" value="{{ number_format($totalAmount,2) }}">
                                    @else
                                    <input type="text" class="form-control" readonly name="amount_ref_total" placeholder="" value="{{ Request::old('amount_ref_total') }}">
                                    @endif
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label class="d-block">ที่อยู่</label>
                                    <textarea class="form-control" readonly name="address_ref">@if(!empty($customerinfo)) {{ $customerinfo->address_line1 }} {{ $customerinfo->address_line2 }} {{ $customerinfo->address_line3 }} {{ $customerinfo->alley }} {{ $customerinfo->district }} {{ $customerinfo->city }} {{ $customerinfo->province_name }} {{ $customerinfo->postal_code }} @endif</textarea>
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="d-block">จำนวนเงินที่รับชำระแล้ว</label>
                                    @if($searchomp0025)
                                    <input type="text" class="form-control" readonly name="amount_ref" placeholder="" value="{{ number_format($p,2) }}">
                                    @else
                                    <input type="text" class="form-control" readonly name="amount_ref" placeholder="" value="{{ Request::old('amount_ref') }}">
                                    @endif
                                </div>
                                <!--form-group-->
                            </div>


                        </div>
                        <!--row-->

                </form>
            </div>
            <!--col-xl-6-->

            <div class="col-md-12">
                <hr class="lg">

                <div class="form-header-buttons">
                    <h3 class="black mb-2 mb-md-0">ข้อมูลใบลดหนี้/ใบเสร็จรับเงิน</h3>
                    <div class="buttons d-flex">
                        <button class="btn btn-md btn-success" type="button" onclick="addpayment();" id="added" @if(!$searchomp0025) disabled @endif><i class="fa fa-plus"></i> เพิ่ม</button>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <form action="{{ route('om.domestic-matching-matching') }}" method="POST" id="matching">
                    @csrf
                    <input type="hidden" name="numberref_save" value="">
                    <input type="hidden" name="credit_save" value="">
                    <input type="hidden" name="order_header_id" value="{{ $order_header_id }}">
                    <input type="hidden" name="files_uploadsId" id="files_uploadsId">
                    <input type="hidden" name="sa_number_for" id="sa_number_for" value="">
                    <input type="hidden" name="cust_ref" id="cust_ref" value="">
                    <input type="hidden" name="data_date" id="data_date" value="">
                    <input type="hidden" name="data_date1" id="data_date1" value="">
                    <div class="table-responsive-lg">
                        <table class="table table-bordered text-center table-hover min-650 f13" id="addpaymenttable">
                            <thead>
                                <tr class="align-middle">
                                    <th class="w-90">ลำดับที่</th>
                                    <th class="w-250">เลขที่เอกสาร</th>
                                    <th>วันที่</th>
                                    <th>จำนวนเงิน</th>
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
                                    <input type="hidden" value="draft" name="payment_type[]">
                                    <td>{{ $rownumber }}</td>
                                    <td>
                                        <div class="input-icon">
                                            <input type="text" readonly class="form-control md text-center" name="payment_number[]" placeholder="" value="{{ $data->payment_number }}">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </td>
                                    <td>{{ FormatDate::DateThaiNumericWithSplash($data->creation_date) }}<input type="hidden" name="date_matching_ref[]" value="{{ $data->creation_date }}"></td>

                                    <td>
                                        <input type="text" readonly class="form-control md text-right" name="payment_amounts[]" placeholder="" value="{{ number_format($data->payment_amount,2) }}">
                                        <input type="hidden" name="payment_amount[]" value="{{ number_format($data->payment_amount,2) }}">
                                        <input type="hidden" name="type_payment_match[]" value="old">
                                    </td>
                                    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td>
                                </tr>
                                @endforeach
                                @endif

                                @if(!empty($cns))
                                @foreach ($cns as $dat)
                                <?php $rownumber++;$total += $dat->invoice_amount;?>
                                <tr class="align-middle red">
                                    <input type="hidden" value="invoice" name="payment_type[]">
                                    <td>{{ $rownumber }}</td>
                                    <td>
                                        <div class="input-icon">
                                            <input type="text" readonly class="form-control md text-center" name="payment_number[]" placeholder="" value="{{ $dat->invoice_number }}">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </td>
                                    <td>{{ FormatDate::DateThaiNumericWithSplash($dat->last_update_date) }}<input type="hidden" name="date_matching_ref[]" value="{{ $dat->last_update_date }}"></td>

                                    <td>
                                        <input type="text" readonly class="form-control md text-right" name="payment_amounts[]" placeholder="" value="({{ number_format($dat->invoice_amount,2) }})">
                                        <input type="hidden" name="payment_amount[]" value="{{ number_format($dat->invoice_amount,2) }}">
                                        <input type="hidden" name="type_payment_match[]" value="old">
                                    </td>
                                    <td class="text-center"><a class="fa fa-times red" href="javascript:void(0);" onclick="deleteRow(this);"></a></td>
                                </tr>
                                @endforeach
                                @endif

                                <tr class="align-middle">
                                    <td class="text-right pt-3 pb-3" colspan="3" id="ignore"><strong class="black">จำนวนเงินรวม</strong></td>
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
            <form id="form_attachment" data-action="{{ url('/') }}/om/domestic-matching/upload">
                {{ csrf_field() }}
                <input type="hidden" name="number_ref" value="{{ Request::old('number_ref') }}">
                <div class="modal-body pt-4 pb-0">
                    <div class="attachment-box">
                        <div class="form-group d-flex mb-1">
                            <div class="custom-file">
                                <input id="attachment" type="file" class="custom-file-input" name="attachment" value="" accept=".jpeg, .jpg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .csv">
                                <label for="attachment" class="custom-file-label label-attachment">Choose file...</label>
                            </div>
                            <div class="button">
                                <button class="btn btn-success" type="button" onclick="submitChooseFile()">Submit</button>
                                <button class="btn btn-warning" type="button" id="btn_clear" onclick="clearInputFile()">Clear</button>
                            </div>
                        </div>
                        <p><small>Allow type : jpeg, jpg, bmp, png, pdf, doc, docx, xls, xlsx, rar, zip, csv and size < 2mb</small></p>
                        <ul class="nav files">
                        @if(!empty($files))
                                @foreach($files as $keyfile => $item)
                                    <li id="file_attachment_{{ $item->attachment_id }}">
                            <code><a href="{{ route('om.domestic-matching-download',$item->attachment_id) }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $item->file_name }}</code></a>
                            <button class="btn btn-remove" onclick="removeFileAttachment(0,{{ $item->attachment_id }},`db`)" type="button"><i class="fa fa-times"></i></button>
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
    var payments;
    var invoincess;
    var htmloptionends;
    let search = {!! json_encode($searchomp0025) !!};

    $(document).ready(function() {
        moment.locale('th');
        $(".aks-file-upload-files").aksFileUpload({
            dragDrop: true,
            maxSize: "1 GB",
            multiple: true,
            maxFile: 50
        });

        $('.select2').select2({
            templateSelection: function (data, container) {
                $(data.element).attr('data-custom-attribute', data.customValue);
                return data.id;
            }
        });


        // @if(request()->all())
        // payments = {!! json_encode($payments) !!};
        // invoincess = {!! json_encode($invoicess) !!};
        // @endif

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
            var credit = $('select[name="credit_ref"] option:selected').val();
            if (sa == '') {
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
            $('#sa_number_for').val(sa);
            $('#cust_ref').val(cus);
            $('#data_date').val(da);
            $('#data_date1').val(da1);
            $('input[name="numberref_save"]').val($('select[name="number_ref"] option:selected').val());
            $('input[name="credit_save"]').val(credit);
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
                            url: "{{ url('/') }}/om/domestic-matching/unmatching",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "number_ref": $('select[name="number_ref"] option:selected').val(),
                                "credit": $('input[name="credit_ref"]').val(),
                            },
                            cache: false,
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'ระบบกำลังดำเนินการยกเลิก Matching ทั้งหมด',
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
                //             url: "{{ url('/') }}/om/domestic-matching/unmatching",
                //             type: "POST",
                //             data: {
                //                 "_token": "{{ csrf_token() }}",
                //                 "number_ref": $('select[name="number_ref"] option:selected').val(),
                //                 "credit": $('input[name="credit_ref"]').val(),
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

    function resetpage() {
        window.location.href = "/om/domestic-matching";
    }

    function getpayment(v) {
        // if ($('input[name="customer_ref"]').val() == null || $('input[name="customer_ref"]').val() == '' || $('select[name="number_ref"] option:selected').val() == '' || $('select[name="number_ref"] option:selected').val() == null) {
        //     return;
        // } else {
        //     if (v == '' || v == null) {
        //         return;
        //     }
        //     $('#addpaymenttable tbody').html('');
        //     $.ajax({
        //         url: "{{ route('om.domestic-matching-getamount') }}",
        //         type: "POST",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "credit": v,
        //             "customer_ref": $('input[name="customer_ref"]').val(),
        //             "number_ref": $('select[name="number_ref"] option:selected').val(),
        //             "search": search
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
        //             var datas = res.data;
        //             var totalAmount = res.totalAmount;
        //             console.log(res);
        //             if (datas == 0) {
        //                 var p = '0.00';
        //             } else {
        //                 var p = parseFloat(datas).toFixed(2);
        //             }
        //             if(totalAmount == 0){
        //                 var p2 = '0.00';
        //             } else {
        //                 var p2 = parseFloat(totalAmount).toFixed(2);
        //             }
        //             $('input[name="amount_ref"]').val(addCommas(p));
        //             $('input[name="amount_ref_total"]').val(addCommas(p2));
        //             $('input[name="order_header_id"]').val(res.header_id);
        //             $('#addpaymenttable tbody').html(res.html);
        //             swal.close();
        //         },
        //         error: function(error) {
        //             Swal.fire({
        //                 title: error.responseText,
        //                 icon: 'error'
        //             });
        //         }
        //     });
        // }
    }

    function custchange(v) {
        var vtypec = $('select[name=credit_ref] option').filter(':selected').val();
        if (v == '' || v == null) {
            $('input[name="type_ref"]').val('');
            $('input[name="customer_name_ref"]').val('');
            $('input[name="amount_ref"]').val('');
            $('textarea[name="address_ref"]').val('');
        } else {
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
            var post;

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
            if (customers[index].postal_code == null) {
                post = '';
            } else {
                post = customers[index].postal_code;
            }

            $('textarea[name="address_ref"]').val(line1 + ' ' + line2 + ' ' + line3 + ' ' + alley + ' ' + district + ' ' + city + ' ' + province + ' ' + post);
            $.ajax({
                url: "{{ route('om.domestic-matching-getinvoice') }}",
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
                    console.log(data);
                    $('select[name="number_ref"] option:selected').val('');
                    $('#orderandinvoice').html('');
                    // $.each(data, function(k, v) {
                    //     if(v.search("SA") == -1) {
                    //         $('#orderandinvoice').append(v);
                    //     }
                    // });
                    $('#orderandinvoice').append(data);
                    select2auto();
                    swal.close();
                },
                error: function(error) {
                    Swal.fire({
                        title: error.responseText,
                        icon: 'error'
                    });
                }
            });
            if(vtypec != ''){
                getpayment(vtypec);
            }
        }
    }

    function select2auto() {
        $('.select2').select2({
            templateSelection: function (data, container) {
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

    function searchvalue(v) {
        if (v == '') {
            $('input[name="date_ref"]').val('');
            $('input[name="type_ref"]').val('');
            $('input[name="date_ref1"]').val('');
            $('input[name="type_ref1"]').val('');
            $('input[name="customer_ref"]').val('');
            $('input[name="customer_name_ref"]').val('');
            $('input[name="customer_name_ref1"]').val('');
            $('input[name="amount_ref"]').val('');
            $('textarea[name="address_ref"]').val('');
        } else {
            var vtypec = $('select[name=credit_ref] option').filter(':selected').val();
            var indexorder = _.findIndex(orders, function(o) {
                return o.prepare_order_number == v;
            });
            if (indexorder == -1) {
                var indexinvoce = _.findIndex(orders, function(i) {
                    return i.pick_release_no == v;
                });

                // var info = orders[indexinvoce].order_date;
                // var info1 = info.split(" ");
                // var info2 = info1[0].split("-");
                // if(info2[1].length == 2){
                //     var m = info2[1];
                // } else {
                //     var m = '0' + info2[1];
                // }
                // var yes =  parseInt(info2[0]) + 543;
                // var result = info2[2] + '/' + m + '/' + yes;
                // var result2 = info2[0] + '-' + info2[1] + '-' + info2[2];
                // $('input[name="date_ref"]').val(result);
                // $('input[name="date_ref1"]').val(result2);
                if(vtypec != ''){
                    getpayment(vtypec);
                }
            } else {

                // var info = orders[indexorder].order_date;
                // var info1 = info.split(" ");
                // var info2 = info1[0].split("-");
                // if(info2[1].length == 2){
                //     var m = info2[1];
                // } else {
                //     var m = '0' + info2[1];
                // }
                // var yes =  parseInt(info2[0]) + 543;
                // var result = info2[2] + '/' + m + '/' + yes;
                // var result2 = info2[0] + '-' + info2[1] + '-' + info2[2];

                // $('input[name="date_ref"]').val(result);

                // $('input[name="date_ref1"]').val(result2);

                if(vtypec != ''){
                    getpayment(vtypec);
                }
            }
        }
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
                        url: "{{ url('/') }}/om/domestic-matching/upload/deleted",
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
                if(value.value != null || value.value != ''){
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

            if(list_prepare_order.length == 0){
                var list = '';
            } else {
                var list = list_prepare_order;
            }
            console.log(list);

            var vat = $('input[name="amount_ref_total"]').val();
            var amount = $('input[name="amount_ref"]').val();
            var sum_total_amount = 0;
            $('#addpaymenttable tbody tr td input[name="payment_amounts[]"]').each(function(index, value) {
                var noCommas = value.value.replace(/,/g, '')
                sum_total_amount += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
            });
            var amount_to = parseFloat(amount.replace(/,/g, '')) + parseFloat(sum_total_amount);
            if(amount_to == vat.replace(/,/g, '')){
                Swal.fire({
                            title: 'ไม่สามารถรับเงินเกินจำนวนได้',
                            icon: 'error'
                        });
                        return false;
            } else {
                $.ajax({
                    url: "{{ url('/') }}/om/domestic-matching/getData",
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
                            title: 'กำลังตรวจสอบรายการ',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(res) {
                        payments = res.payments;
                        invoincess = res.invoicess;

                        console.log(res);

                        if(payments.length == 0 && invoincess.length == 0){
                            Swal.fire({
                                title: 'ไม่พบข้อมูลที่สามารถดำเนินการบันทึก Matching ได้',
                                icon: 'warning'
                            });
                        } else {
                            // htmloptionends = '';
                            // var htmloptionstart = '<datalist id="paymentsandinvoice">';
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

    }

    function addrowstd() {
        $('#addpaymenttable tbody').find("tr:last").before('<tr class="align-middle"><input type="hidden" value="" name="payment_id[]"><input type="hidden" value="" name="payment_type[]"><td></td> <td><div class="input-icon">' + htmloptionends + '</div></td> <td><input type="hidden" name="date_matching_ref[]" value=""></td> <td><input type="text" name="payment_amounts[]" placeholder="" value="" class="form-control md text-right" onchange="countsumpayment();(function(el){el.value=addCommas(parseFloat(el.value).toFixed(2));})(this)" onkeyup="maxvalue(this,this.value);" max="0"><input type="hidden" name="payment_amount[]"><input type="hidden" name="type_payment_match[]" value="new"></td> <td class="text-center"><a href="javascript:void(0);" class="fa fa-times red" onclick="deleteRow(this);"></a></td></tr>');
        autoRownumber();
    }

    function maxvalue(element,v){
        var rowjQuery = $(element).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        var value = $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val();

        if(parseFloat(v.replace(/,/g, '')) > parseFloat(value.replace(/,/g, ''))){
            Swal.fire({
                    title: 'จำนวนเงินไม่สามารถมากกว่า '+$.number(value,2)+' ได้',
                    icon: 'warning'
                });
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val($.number(value,2));
                countsumpayment();
                return false;
        }  
    }

    function listvaluetoinput(element) {
        if (element.value == '') {
            return false;
        }
        var rowjQuery = $(element).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        var indexpayment = _.findIndex(payments, function(o) {
            return o.payment_number == element.value;
        });
        if (indexpayment == -1) {
            console.log(1);
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
            if((parseFloat(invoincess[indexinvoce].invoice_amount) + parseFloat(amount.replace(/,/g, ''))) > parseFloat(vat.replace(/,/g, ''))){
                var amount_to = parseFloat(vat.replace(/,/g, '')) - parseFloat(amount.replace(/,/g, ''));
                Swal.fire({
                    title: 'ยอดหนี้คงเหลือที่สามารถ match ได้ '+$.number(amount_to, 2)+' ยอดเงินของใบลดหนี้ '+$.number(invoincess[indexinvoce].invoice_amount, 2),
                    icon: 'warning'
                    });
                var date = new Date(moment(invoincess[indexinvoce].invoice_date).format("YYYY-MM-DD"));
                var result = ('0' + (date.getDate())).slice(-2) + "/" + ('0' + (date.getMonth()+1)).slice(-2) + "/" + parseInt(date.getFullYear() + 543);
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_id[]"]').val(invoincess[indexinvoce].invoice_headers_id);
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_type[]"]').val('invoice');
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val($.number(amount_to, 2));
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val($.number(amount_to, 2));
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').attr({'min': 1,'max': amount_to});
                // $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').attr('readonly',true);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').text(result);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').append('<input type="hidden" name="date_matching_ref[]" value="' + invoincess[indexinvoce].invoice_date + '">');
            } else {
                var date = new Date(moment(invoincess[indexinvoce].invoice_date).format("YYYY-MM-DD"));
                var result = ('0' + (date.getDate())).slice(-2) + "/" + ('0' + (date.getMonth()+1)).slice(-2) + "/" + parseInt(date.getFullYear() + 543);
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_id[]"]').val(invoincess[indexinvoce].invoice_headers_id);
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_type[]"]').val('invoice');
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val($.number(invoincess[indexinvoce].invoice_amount, 2));
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val($.number(invoincess[indexinvoce].invoice_amount, 2));
                $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').attr({'min': 1,'max':invoincess[indexinvoce].invoice_amount});
                // $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').attr('readonly',true);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').text(result);
                $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').append('<input type="hidden" name="date_matching_ref[]" value="' + invoincess[indexinvoce].invoice_date + '">');
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

            var date = new Date(moment(payments[indexpayment].payment_date).format("YYYY-MM-DD"));
            var result = ('0' + (date.getDate())).slice(-2) + "/" + ('0' + (date.getMonth()+1)).slice(-2) + "/" + parseInt(date.getFullYear() + 543);
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_id[]"]').val(payments[indexpayment].payment_match_id);
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_type[]"]').val('draft');
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val($.number(amount_to, 2));
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').val($.number(amount_to, 2));
            $('#addpaymenttable tbody tr:eq(' + index + ')').find('input[name="payment_amounts[]"]').attr({'min': 1,'max': amount_to});
            $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').text(result);
            $('#addpaymenttable tbody tr:eq(' + index + ') td:eq(2)').append('<input type="hidden" name="date_matching_ref[]" value="' + payments[indexpayment].payment_date + '">');
        }
        countsumpayment();
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
        $('#addpaymenttable tbody tr td input[name="payment_amounts[]"]').each(function(index, value) {
            var noCommas = value.value.replace(/,/g, '')
            total += isNaN(parseFloat(noCommas)) ? 0 : parseFloat(noCommas);
        });
        $('#total').html('<strong class="black">' + addCommas(total.toFixed(2)) + '</strong>');
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
                    $('#UploadModalFile').modal('hide')
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
            fileRunChoose = -1;
        }
    }

    function removeFileAttachment(section,index,type='local'){
        if(type != 'local'){
            let formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('attachment_id', index);
            $.ajax({
                type: 'post',
                url: "{{ url('/') }}/om/domestic-matching/files/delete",
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
</script>
@endsection
