@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Customer Search</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">หน้าหลัก</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>ข้อมูลลูกค้า สำหรับขายต่างประเทศ</strong>
                </li>
            </ol>
        </div>
    </div>
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
                                    <option value="1" @if(!empty(request()->printStatus) == 1) selected @endif>Yes</option>
                                    <option value="0" @if(!empty(request()->printStatus) == 0) selected @endif>No</option>
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
                            <div class="form-header-buttons">
                                <div class="buttons d-flex">
                                    <button class="btn btn-md btn-white has-checkbox" type="button">
                                        <div class="i-checks"><label>
                                                <div class="icheckbox_square-green">
                                                    <input type="checkbox"  value="option_0" name="a" id="check-all" style="position: absolute; opacity: 0;">
                                                    <ins onclick="checkAll()" class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                </div>
                                                <span> พิมพ์ทั้งหมด</span></label></div>

                                    </button>
                                    <button class="btn btn-md btn-primary print-submit" type="submit"><i class="fa fa-save"></i> บันทึก
                                    </button>

                                </div><!--buttons-->
                            </div><!--form-header-buttons-->

                            <div class="hr-line-dashed"></div>

                            <div class="table-responsive">
                                @if($tests->count() > 0)
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
                                        <tbody>
                                        @foreach($tests as $key => $test)
                                            <tr @if($test->pick_release_status == 'cancel') class="tr-blue" @endif >
                                                <td>{{$key+1}}</td>
                                                <td><div class="text-overflow">{{$test->prepare_order_number ?? '-'}}</div></td>
                                                <td><div class="text-overflow">{{\Carbon\Carbon::parse($test->delivery_date)->format('d/m/Y')}}</div></td>
                                                <td class="text-left"><div class="text-overflow">{{$test->name}}</div></td>
                                                <td class="text-right"><div class="text-overflow">{{number_format($test->grand_total,2)}}</div></td>
                                                <td>
                                                    <div class="i-checks wihtout-text m-auto">
                                                        <label>
                                                            <div class="icheckbox_square-green icheckbox_square-green-{{$test->invoice_header_id}}">
                                                                <input class="check-box-{{$test->invoice_header_id}} check-box" type="checkbox"  value="{{$test->invoice_header_id}}" name="checkPrint[]" style="position: absolute; opacity: 0;">
                                                                <ins class="iCheck-helper check-box-mark" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                                {{--<ins onclick="onClickHandler({{$test->invoice_header_id}})" class="iCheck-helper check-box-mark" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                                            </div>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><div class="text-overflow">{{$test->pick_release_no}}</div></td>
                                                <td><div class="text-overflow">{{$test->pick_release_status}}</div></td>
                                            </tr>
                                        @endforeach

                                        {{--<tr class="red">--}}
                                        {{--<td>2</td>--}}
                                        {{--<td>580012597</td>--}}
                                        {{--<td>27/03/2558</td>--}}
                                        {{--<td class="text-left">บริษัท อุตรดิตถ์-น่าน จำกัด</td>--}}
                                        {{--<td class="text-right">2,070,435.00</td>--}}
                                        {{--<td>--}}
                                        {{--<div class="i-checks wihtout-text m-auto">--}}
                                        {{--<label>--}}
                                        {{--<div class="icheckbox_square-green"><input type="checkbox"--}}
                                        {{--value="option_a1"--}}
                                        {{--name="a"--}}
                                        {{--style="position: absolute; opacity: 0;">--}}
                                        {{--<ins class="iCheck-helper"--}}
                                        {{--style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                        {{--</div>--}}
                                        {{--</label>--}}
                                        {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td>5801007534</td>--}}
                                        {{--<td>Confirm</td>--}}
                                        {{--</tr>--}}

                                        {{--<tr>--}}
                                        {{--<td>3</td>--}}
                                        {{--<td>580012598</td>--}}
                                        {{--<td>27/03/2558</td>--}}
                                        {{--<td class="text-left">บริษัท อุตรดิตถ์จังหวัดพาณิชย์ จำกัด</td>--}}
                                        {{--<td class="text-right">2,158,800.00</td>--}}
                                        {{--<td>--}}
                                        {{--<div class="i-checks wihtout-text m-auto">--}}
                                        {{--<label>--}}
                                        {{--<div class="icheckbox_square-green"><input type="checkbox"--}}
                                        {{--value="option_a1"--}}
                                        {{--name="a"--}}
                                        {{--style="position: absolute; opacity: 0;">--}}
                                        {{--<ins class="iCheck-helper"--}}
                                        {{--style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                        {{--</div>--}}
                                        {{--</label>--}}
                                        {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td>5801007535</td>--}}
                                        {{--<td>Confirm</td>--}}
                                        {{--</tr>--}}

                                        {{--<tr class="tr-blue">--}}
                                        {{--<td>4</td>--}}
                                        {{--<td>580012599</td>--}}
                                        {{--<td>27/03/2558</td>--}}
                                        {{--<td class="text-left">ร้านศรีทองพาณิชย์</td>--}}
                                        {{--<td class="text-right">3,222,000.00</td>--}}
                                        {{--<td>--}}
                                        {{--<div class="i-checks wihtout-text m-auto">--}}
                                        {{--<label>--}}
                                        {{--<div class="icheckbox_square-green"><input type="checkbox"--}}
                                        {{--value="option_a1"--}}
                                        {{--name="a"--}}
                                        {{--style="position: absolute; opacity: 0;">--}}
                                        {{--<ins class="iCheck-helper"--}}
                                        {{--style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                        {{--</div>--}}
                                        {{--</label>--}}
                                        {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td>5801007535</td>--}}
                                        {{--<td>Cancel</td>--}}
                                        {{--</tr>--}}

                                        {{--<tr class="tr-green">--}}
                                        {{--<td>5</td>--}}
                                        {{--<td>580012600</td>--}}
                                        {{--<td>27/03/2558</td>--}}
                                        {{--<td class="text-left">ร้านศรีทองพาณิชย์</td>--}}
                                        {{--<td class="text-right">(3,222,000.00)</td>--}}
                                        {{--<td>--}}
                                        {{--<div class="i-checks wihtout-text m-auto">--}}
                                        {{--<label>--}}
                                        {{--<div class="icheckbox_square-green"><input type="checkbox"--}}
                                        {{--value="option_a1"--}}
                                        {{--name="a"--}}
                                        {{--style="position: absolute; opacity: 0;">--}}
                                        {{--<ins class="iCheck-helper"--}}
                                        {{--style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>--}}
                                        {{--</div>--}}
                                        {{--</label>--}}
                                        {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td>5801007535</td>--}}
                                        {{--<td>Confirm</td>--}}
                                        {{--</tr>--}}
                                        </tbody>
                                    </table>
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
    <script>
        function checkAll() {
            if($('#check-all:checkbox:checked').length == 0){
                $('input[type=checkbox].check-box').prop( "checked", true );
                $('.icheckbox_square-green').addClass( "checked" );
                console.log("check")
            }else {
                $('input[type=checkbox].check-box').prop( "checked", false );
                $('.icheckbox_square-green').removeClass( "checked" );
                console.log("un check")

            }
        }
        var dataLength = '{{$tests->count()??0}}';
        // {{--function onClickHandler(id) {--}}
        // {{--console.log(id);--}}
        // {{--// console.log($(".check-box:checked").length);--}}
        // {{--// alert($(":checkbox:checked").length);--}}
        // {{--console.log($('input[type=checkbox].check-box-'+id+':checked').length)--}}
        // {{--if($('.check-box'+id+':checkbox:checked').length == 0){--}}
        // {{--$('input[type=checkbox].check-box-'+id).prop( "checked", true );--}}
        // {{--$('.icheckbox_square-green'+id).addClass( "checked" );--}}
        // {{--console.log("check 1")--}}
        // {{--}else {--}}
        // {{--$('input[type=checkbox].check-box'+id).prop( "checked", false );--}}
        // {{--$('.icheckbox_square-green'+id).removeClass( "checked" );--}}
        // {{--console.log("un check 1")--}}
        // {{--}--}}
        // {{--}--}}

        // function updateCount() {
        //     var x = document.querySelector('.check-box:checked').length;
        //     console.log(x);
        //     return x
        // };

    </script>

    <script>
        $(document).ready(function () {
            $('.date').datepicker();
        });
    </script>

@endsection
