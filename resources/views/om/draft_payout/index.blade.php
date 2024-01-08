@extends('layouts.app')

@section('title', 'จ่ายยาสูบจากใบเตรียมการขาย')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
<style>
    #list_product_free td, #list_product_free input {
        color:red
    }
</style>
@stop

@section('page-title')
<h2>
    {{-- <x-get-program-code url="/om/draft-payout" /> จ่ายยาสูบจากใบเตรียมการขาย --}}
    <x-get-page-title menu="" url="/om/draft-payout" />
</h2>
{{-- <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong><x-get-program-code url="/om/draft-payout" /> จ่ายยาสูบจากใบเตรียมการขาย</strong>
    </li>
</ol> --}}
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>จ่ายยาสูบจากใบเตรียมการขาย</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-xl-12">
                    <div class="form-header-buttons">
                        <div class="buttons">
                        <button class="btn btn-md btn-white" type="button" onclick="resetpage();"><i class="fa fa-refresh"></i> ล้างข้อมูล</button>
                            <button class="btn btn-md btn-white" type="button" onclick="search_form();"><i
                                    class="fa fa-search"></i> ค้นหา</button>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                </div>

                <div class="col-xl-10 m-auto">
                    <form id="search_form" autocomplete="">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">วันที่ส่งสินค้า</label>
                                    <div class="input-icon">
                                        <!-- <input type="text" class="form-control date" name="delivery_date" placeholder=""
                                            value="{{ request()->delivery_date or '' }}">
                                        <i class="fa fa-calendar"></i> -->
                                        <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="delivery_date"
                                            id="input_date"
                                            placeholder=""
                                            @if(request()->delivery_date != '') value="{{ request()->delivery_date }}" @else value="{{ FormatDate::DateThaiNumericWithSplash(date('Y-m-d')) }}" @endif
                                            format="{{ trans("date.js-format") }}">
                                    </div>
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">ช่วงเวลา</label>
                                    <select class="custom-select" name="time_select">
                                        <option value="เช้า" @if(request()->time_select == 'เช้า')
                                            selected @endif>เช้า</option>
                                        <option value="บ่าย" @if(request()->time_select == 'บ่าย')
                                            selected @endif>บ่าย</option>
                                        <option value="*" @if(request()->time_select == null || request()->time_select == '*') selected @endif>
                                            ทั้งเช้าและบ่าย</option>
                                    </select>
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">ประเภทร้านค้า</label>
                                    <select class="custom-select" name="type_customer">
                                        <option value="ร้านขายส่งยาสูบ" @if(request()->type_customer ==
                                            'ร้านขายส่งยาสูบ') selected @endif>ร้านขายส่งยาสูบ</option>
                                        <option value="Modern Trade" @if(request()->type_customer == 'Modern Trade')
                                            selected @endif>Modern Trade</option>
                                            <option value="*" @if(request()->type_customer == '*')
                                                selected @endif>ทุกร้านค้า</option>
                                    </select>
                                </div>
                                <!--form-group-->
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="icheckbox_square-green checked" value="" name="" onclick="checkedall();" @if(empty($draftOrders)) disabled @endif>
                                    <span class="nowrap">เบิกทั้งหมด</span>
                                </div>
                            </div>
                        </div>
                        <!--row-->
                    </form>
                </div>
                <!--col-xl-6-->

                <div class="col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="draft_item">
                            <thead>
                                <tr class="align-middle text-center">
                                    <th>ใบเตรียมขาย</th>
                                    <th>ใบ Invoice/ใบฝากขาย</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>บุหรี่(พันมวน)/ยาเส้น(หีบ)</th>
                                    <th class="w-130">เบิก</th>
                                    <th class="w-130">เตรียมเบิกแล้ว</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--ตัวหนังสือสีแดง class="tr-text-red" // ตัวหนังสือสีเขียว class="tr-text-green"-->
                                @foreach ($draftOrders as $item)
                                <tr class="@if($item->order_status == 'Cancel' || $item->order_status == 'Cancelled') tr-yellow @endif @if(Promotionlists($item->orderlines)) tr-text-red @else @if($item->product_type_code == '20') tr-text-green @else tr-text-black @endif @endif">
                                    <td>{{ $item->prepare_order_number }}</td>
                                    <td>@if($item->pick_release_status == 'Confirm') {{ $item->pick_release_no }} @endif</td>
                                    <td class="text-left">{{ $item->customers->customer_name }} {{ $item->customers->attribute2 ? ' (' . $item->customers->attribute2 . ') ' : ''}} </td>
                                    <td>{{ ConvertSum($item->orderlines) }}</td>
                                    <td style="text-align: center;vertical-align: middle;">
                                        @if($item->order_status == 'Cancelled' || $item->order_status == 'Cancel')
                                        <input type="checkbox" class="icheckbox_square-green checked" value="{{ $item->order_header_id }}"
                                            name="order_header_id_confirm[]" disabled
                                        class="form-control" onclick="array_id(this.value);" style="margin: 0
                                        auto;display: black;">
                                        @else
                                        <input type="checkbox" class="icheckbox_square-green checked" value="{{ $item->order_header_id }}"
                                            name="order_header_id_confirm[]" @if($item->issue_flag !=
                                        null && $item->issue_flag == 'Y') disabled @endif
                                        class="form-control" onclick="array_id(this.value);" style="margin: 0
                                        auto;display: black;">
                                        @endif
                                    </td>
                                    <td style="text-align: center;vertical-align: middle;">
                                        <input type="checkbox" class="icheckbox_square-green checked" value="{{ $item->order_header_id }}"
                                            name="order_header_id_confirmed[]" @if($item->ready_for_issue_flag !=
                                        null && $item->ready_for_issue_flag
                                        == 'Y') checked @endif disabled class="form-control" style="margin: 0
                                        auto;display: black;">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--table-responsive-->

                    <div class="row  mt-4 mb-4 f14">
                        <div class="col-xl-6">
                            <ul class="table-legend-info">
                                <li class="w-auto pr-2">ตัวอักษร</li>
                                <li class="w-auto pr-2"><span class="legend-item" style="background-color: #000"></span>
                                    สั่งซื้อปกติ</li>
                                <li class="w-auto pr-2"><span class="legend-item" style="background-color: red"></span>
                                    มีรายการส่งเสริมฯ</li>
                                <li class="w-auto pr-2"><span class="legend-item"
                                        style="background-color: #00b050"></span> ยาเส้น</li>
                            </ul>
                        </div>
                        <!--col-8-->

                        <div class="col-xl-6 mt-3 mt-xl-0">
                            <ul class="table-legend-info justify-content-xl-end">
                                <li class="w-auto pr-2">แถบสี</li>
                                <li class="w-auto pr-2"><span class="legend-item"
                                        style="background-color: #ffffff"></span> ปกติ</li>
                                <li class="w-auto pr-2"><span class="legend-item"
                                        style="background-color: #f7d517"></span> มีการยกเลิกใบเตรียมขาย</li>
                            </ul>
                        </div>
                        <!--col-8-->
                    </div>
                    <!--row-->
                </div>
                <!--col-xl-12-->

                <div class="col-xl-12" id="details_draft">
                    <hr>
                    <div class="form-header-buttons align-items-md-end mt-5">
                        <div class="buttons">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4 mb-md-0">
                                        <label class="d-block">เลขที่ใบจ่ายยาสูบ</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="issue_number" placeholder=""
                                                value="" list="listIssue">
                                            <i class="fa fa-search"></i>
                                            <datalist id="listIssue">
                                                @foreach($listIssue as $list)
                                                <option value="{{ $list->issue_number }}">{{ FormatDate::DateThaiwithTime($list->issue_date) }}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                </div>
                                <!--col-md-6-->

                                <div class="col-md-6">
                                    <div class="form-group mb-4 mb-md-0">
                                        <label class="d-block">วันที่จ่ายยาสูบ</label>
                                        <input type="text" class="form-control" disabled="" name="issue_date" placeholder=""
                                            value="">
                                    </div>
                                </div>
                                <!--col-md-6-->
                            </div>
                            <!--row-->
                        </div>
                    </div>

                    <div class="form-header-buttons align-items-md-end mt-5">
                        <div class="buttons">
                        <button class="btn btn-md btn-info" type="button" onclick="printdraft();"><i class="fa fa-print"></i> พิมพ์ใบจ่ายยาสูบ</button>
                            <button class="btn btn-md btn-white" type="button" onclick="search_form_number();"><i
                                class="fa fa-search"></i> ค้นหา</button>
                            <button class="btn btn-md btn-primary" type="button" disabled id="save_draft" onclick="save_flag()"><i class="fa fa-save"></i>
                                บันทึก</button>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="list_product">
                            <thead>
                                <tr class="align-middle">
                                    <th class="w-160">รหัสผลิตภัณฑ์</th>
                                    <th>ชื่อผลิตภัณฑ์</th>
                                    <th class="w-250">ปริมาณ(หีบ)</th>
                                    <th class="w-250">ปริมาณ(ห่อ)</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="list_product_free" style="display:none">
                            <thead>
                                <tr>
                                    <th colspan="4">รายการส่งเสริมการตลาด</th>
                                </tr>
                                <tr class="align-middle">
                                    <th class="w-160">รหัสผลิตภัณฑ์</th>
                                    <th>ชื่อผลิตภัณฑ์</th>
                                    <th class="w-250">ปริมาณ(หีบ)</th>
                                    <th class="w-250">ปริมาณ(ห่อ)</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <p id="process_text" class="text-danger text-center" style="display: none;">กำลังดำเนินการดึงรายการ
                    </p>
                    <!--table-responsive-->
                </div>
                <!--col-xl-12-->

            </div>
            <!--row-->

        </div>
        <!--ibox-content-->
    </div>
    <!--ibox-->


</div>
@endsection

@section('scripts')
<script>
    let id_draft = [];

    $(document).ready(function () {
        $('.date').datepicker()
    });

    function search_form() {
        $('#search_form').submit();
    }

    function resetpage() {
        window.location.href = "/om/draft-payout";
    }

    function printdraft() {
        console.log('print');
        let id_for_prints = [];
        var r = $('input[name="issue_number"]').val();
        if(r == '' || r == null){
            $('#draft_item tbody tr td input[name="order_header_id_confirmed[]"]').each(function(index, value){
                if (this.checked) {
                    if (id_for_prints.indexOf(value.value) == -1) {
                        id_for_prints.push(value.value);
                    }
                }
            });

            $('#draft_item tbody tr td input[name="order_header_id_confirm[]"]').each(function(index, value){
                if (this.checked) {
                    if (id_for_prints.indexOf(value.value) == -1) {
                        id_for_prints.push(value.value);
                    }
                }
            });

            if(id_for_prints.length == 0){
                swal({
                        title: 'กรุณาระบุเลขที่ใบจ่ายยาสูบ หรือ เลือกรายการที่ต้องการพิมพ์',
                        type: 'error'
                    });
                return false;
            } else {
                var win = window.open("/om/draft-payout/print/with/"+id_for_prints, '_blank');
                if (win) {
                    win.focus();
                } else {
                    //Browser has blocked it
                    swal({
                        title: 'กรุณาอนุญาตการเปิดป๊อบอัพสำหรับเว็บไซต์นี้',
                        type: 'warning'
                    });
                }
            }
        } else {
            var win = window.open("/om/draft-payout/print/"+r, '_blank');
            if (win) {
                win.focus();
            } else {
                //Browser has blocked it
                swal({
                    title: 'กรุณาอนุญาตการเปิดป๊อบอัพสำหรับเว็บไซต์นี้',
                    type: 'warning'
                });
            }
        }
    }

    function search_form_number() {
        var issue_number = $('input[name="issue_number"]').val();
        if(issue_number == null || issue_number == undefined || issue_number == ''){
            return false;
        }
        $('input[name="issue_date"]').val('');
        if ($('#process_text').css('display') == 'none') {
            $('#process_text').css('display', 'block');
        }
        $('#list_product tbody').html('');
        $.ajax({
            url: "{{ route('om.draft-payout-listproduct') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "number_id":issue_number
            },
            success: function(response){
                if ($('#process_text').css('display') == 'block') {
                    $('#process_text').css('display', 'none');
                }
                $('#list_product tbody').html(response.html);
                $('input[name="issue_date"]').val(response.time);
            },
            error: function(error){
                if ($('#process_text').css('display') == 'block') {
                    $('#process_text').css('display', 'none');
                }
                swal('Error!',error,'error');
            }
        });
    }

    function checkedall(){
        $('#draft_item tbody tr td input[name="order_header_id_confirm[]"]').each(function(index, value) {
            console.log(this.disabled);
            if(!this.checked && !this.disabled){
                this.checked=true;
                id_draft.push(value.value);
            } else {
                if(this.checked && !this.disabled) {
                    this.checked=false;
                    if (id_draft.indexOf(value.value) != -1) {
                        var index = id_draft.indexOf(value.value);
                        id_draft.splice(index, 1);
                    }
                }
            }
        });
        if (id_draft.length !== 0) {
            if ($('#process_text').css('display') == 'none') {
                $('#list_product tbody').html('');
                $('#process_text').css('display', 'block');
            }
            calllistProducts();
        } else {
            $('#list_product tbody').html('');
            $('#save_draft').prop('disabled',false);
        }
    }

    function array_id(id) {
        if (id_draft.indexOf(id) == -1) {
            id_draft.push(id);
        } else {
            var index = id_draft.indexOf(id);
            id_draft.splice(index, 1);
        }
        if (id_draft.length !== 0) {
            if ($('#process_text').css('display') == 'none') {
                $('#list_product tbody').html('');
                $('#process_text').css('display', 'block');
            }
        } else {
            if ($('#process_text').css('display') == 'block') {
                $('#list_product tbody').html('');
                $('#process_text').css('display', 'none');
            }
        }
        $('input[name="issue_number"]').val('');
        $('input[name="issue_date"]').val('');
        if (id_draft.length !== 0) {
            calllistProducts();
        } else {
            $('#list_product tbody').html('');
            $('#save_draft').prop('disabled',false);
        }

    }

    function calllistProducts() {
        $.ajax({
            url: "{{ route('om.draft-payout-listproduct') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "array_id": id_draft
            },
            success: function(response){
                if ($('#process_text').css('display') == 'block') {
                    $('#process_text').css('display', 'none');
                }
                console.log(response.html_free)
                if(response.has_free) {
                    $("#list_product_free tbody").html(response.html_free)
                    $("#list_product_free").show();
                } else {
                    $("#list_product_free tbody").html('')
                    $("#list_product_free").hide();
                }
                $('#list_product tbody').html(response.html);
                $('#save_draft').prop('disabled',false);
            },
            error: function(error){
                if ($('#process_text').css('display') == 'block') {
                    $('#process_text').css('display', 'none');
                }
                swal('Error!',error,'error');
            }
        });
    }

    function save_flag(){
        if(id_draft.length == 0){
            return false;
        }
        $('input[name="issue_number"]').val('');
        $('input[name="issue_date"]').val('');
        $.ajax({
            url: "{{ route('om.draft-payout-storeDraft') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "array_id": id_draft
            },
            beforeSend:function() {
                $('#save_draft').prop('disabled',true);
                $('#save_draft').text('กำลังบันทึก...');
            },
            success: function(response){
                $('#save_draft').text('บันทึก');
                if(response.status == 'fails'){
                    swal('Error!',response.msg,'error');
                } else {
                    swal('บันทึกข้อมูลสำเร็จ','','success');
                    $('#save_draft').prop('disabled',true);
                    $('input[name="issue_number"]').val(response.issue_number);
                    $('input[name="issue_date"]').val(response.time);
                    $('#draft_item tbody tr td input[name="order_header_id_confirmed[]"]').each(function(index, value) {
                        if(!this.checked){
                            if(id_draft.indexOf(value.value) != -1){
                                this.checked=true;
                            }
                        }
                    });
                    $('#draft_item tbody tr td input[name="order_header_id_confirm[]"]').each(function(index, value) {
                        if(this.checked){
                            if(id_draft.indexOf(value.value) != -1){
                                this.disabled=true;
                            }
                        }
                    });
                    $('#listIssue').append('<option>'+response.issue_number+'</option>');
                    id_draft = [];
                    id_draft.length = 0;
                }
            },
            error: function(error){
                $('#save_draft').text('บันทึก');
                swal('Error!',error.msg,'error');
            }
        });
    }

</script>
@endsection
