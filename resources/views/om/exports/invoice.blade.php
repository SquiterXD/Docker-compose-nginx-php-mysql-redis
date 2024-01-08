@extends('layouts.app')

@section('title', 'Main page')

@section('header')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <style>
        .text-overflow {
            overflow: hidden;
            text-overflow: ellipsis;
            -webkit-box-orient: vertical;
            max-width: 20ch;
        }

        .btn-primary {
            color: #fff;
            background-color: #1ab394 !important;
            border-color: #1ab394 !important;
        }
    </style>
@endsection

@section('page-title')
    <h2>OMP0036 : พิมพ์ Invoice/ใบขน/Credit Note</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ข้อมูลลูกค้า สำหรับขายต่างประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h3>พิมพ์ Invoice / ใบขน / Credit Note</h3>
            </div>
            <div class="ibox-content">
                <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                    <div class="col-xl-6 m-auto">
                        <form action="{{route('om.get-invoice-header')}}">
                            <div class="form-group">
                                <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="d-block">วันที่ส่ง</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control date" name="sendDate" placeholder=""
                                                   @if(!empty(request()->sendDate)) value="{{request()->sendDate}}" @endif>
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="d-block">ถึงวันที่</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control date" name="arrivalDate"
                                                   placeholder=""
                                                   @if(!empty(request()->arrivalDate)) value="{{request()->arrivalDate}}" @endif>
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--form-group-->

                            <div class="form-group">
                                <label class="d-block">เลขที่ใบเตรียมขาย</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="orderNo" placeholder=""
                                           @if(!empty(request()->orderNo)) value="{{request()->orderNo}}" @endif>
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!--form-group-->

                            <div class="form-group">
                                <label class="d-block">Invoice / ใบขน / Credit Note</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="invoiceNo" placeholder=""
                                           @if(!empty(request()->invoiceNo)) value="{{request()->invoiceNo}}" @endif>
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!--form-group-->

                            <div class="form-group">
                                <label class="d-block">สถานะการพิมพ์</label>
                                <select class="custom-select" name="printStatus">
                                    <option value="Y" @if(!empty(request()->printStatus) == "Y") selected @endif>Yes
                                    </option>
                                    <option value="N" @if(!empty(request()->printStatus) == "N") selected @endif>No
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="d-block">ลูกค้า</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="customerName" placeholder=""
                                                   @if(!empty(request()->customerName)) value="{{request()->customerName}}" @endif>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" disabled="" name="" placeholder=""
                                               value="">
                                    </div>
                                </div><!--row-->
                            </div><!--form-group-->

                            <div class="form-buttons no-border">
                                <button class="btn btn-lg btn-white" type="submit"><i class="fa fa-search"></i> ค้นหา
                                </button>
                            </div>
                        </form>
                    </div><!--col-xl-6-->

                    <form action="{{route('om.get-invoice-header-save')}}">
                        <div class="col-md-12">
                            <hr class="lg">
                            @if($invoices->count() > 0)
                                <div class="form-header-buttons">
                                    <div class="buttons d-flex">
                                        <button class="btn btn-md btn-white has-checkbox mt-2 mt-md-0" type="button">
                                            <div class="i-checks">
                                                <label>
                                                    <input type="checkbox" id="check-all">
                                                    <span> พิมพ์ทั้งหมด</span>
                                                </label>
                                            </div>
                                        </button>
                                        <button class="btn btn-md btn-primary print-submit" type="submit"><i
                                                    class="fa fa-save"></i> บันทึก
                                        </button>

                                    </div><!--buttons-->
                                </div><!--form-header-buttons-->
                            @endif
                            <div class="hr-line-dashed"></div>

                            <div class="table-responsive">
                                @if($invoices->count() > 0)
                                    <table class="table table-bordered text-center table-hover f13" width="100%">
                                        <thead>
                                        <tr class="align-middle">
                                            <th>รายการที่</th>
                                            <th>เลขที่ใบเตรียมขาย</th>
                                            <th>วันที่ส่ง</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>จำนวนเงิน</th>
                                            <th>พิมพ์</th>
                                            <th>เลขที่ Invoice /<br>ใบขน/Credit Note</th>
                                            <th>สถานะ Invoice /<br>ใบขน/Credit Note</th>
                                        </tr>
                                        </thead>
                                        <tbody id="showCheckboxInvoice">
                                        @foreach($invoices as $key => $invoice)
                                            <tr class=" @if($invoice->pick_release_status == 'cancel') tr-blue @endif @if(!empty($invoice->customer_promo)) red @endif ">
                                                <td>{{$key+1}}</td>
                                                <td>
                                                    <div class="text-overflow">{{$invoice->invoice_headers_number ?? '-'}}</div>
                                                </td>
                                                <td>
                                                    <div class="text-overflow">{{parseToDateTh(\Carbon\Carbon::parse($invoice->delivery_date)->format('d/m/Y'))}}</div>
                                                </td>
                                                <td class="text-left">
                                                    <div class="text-overflow">{{$invoice->customer_name}}</div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="text-overflow">{{number_format($invoice->grand_total,2)}}</div>
                                                </td>
                                                <td>
                                                    <div class="i-checks wihtout-text m-auto">
                                                        <label>
                                                            <input type="checkbox"
                                                                   class="check-box-{{$invoice->invoice_header_id}} check-item"
                                                                   value="{{ $invoice->invoice_header_id}}"
                                                                   name="checkPrint[]">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-overflow">{{$invoice->pick_release_no}}</div>
                                                </td>
                                                <td>
                                                    <div class="text-overflow">{{$invoice->pick_release_status}}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div style="text-align: center">ไม่พบข้อมูล</div>
                                @endif
                            </div><!--table-responsive-->
                            <div class="row justify-content-end f14">
                                <div class="col-xl-7 mt-4 mb-4">

                                    <div class="row mb-2">
                                        <div class="col-md-4 text-right-sm">
                                            <span class="d-block pr-3">ตัวอักษร</span>
                                        </div>
                                        <div class="col-md-8">
                                            <ul class="table-legend-info">
                                                <li><span class="legend-item" style="background-color: #000"></span>
                                                    สั่งซื้อปกติ
                                                </li>
                                                <li><span class="legend-item" style="background-color: red"></span>
                                                    มีรายการส่งเสริม
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!--row-->

                                    <div class="row">
                                        <div class="col-md-4 text-right-sm">
                                            <span class="d-block pr-3">แถบสี</span>
                                        </div>
                                        <div class="col-md-8">
                                            <ul class="table-legend-info">
                                                <li><span class="legend-item" style="background-color: #1c84c6"></span>
                                                    Invoice ถูกยกเลิก
                                                </li>
                                                <li><span class="legend-item" style="background-color: #1ab394"></span>
                                                    Credit Note
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!--row-->

                                </div><!--col-12-->
                            </div><!--row-->
                        </div>
                    </form>
                </div><!--row-->
            </div><!--ibox-content-->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('custom/custom.js') !!}"></script>
    <script>
        $('#check-all').on('ifChecked', function (event) {
            $('.check-item').iCheck('check');
        });

        $('#check-all').on('ifUnchecked', function (event) {
            $('.check-item').iCheck('uncheck');
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.date').datepicker();
        });

        try {
            $("input").each(function () {
                $(this).attr("autocomplete", "off");
            });
        }
        catch (e) {
        }
    </script>
@endsection