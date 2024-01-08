@extends('layouts.app')

@section('title', 'ผ่านข้อมูลค่าขนส่งให้บัญชีเจ้าหนี้')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>
        {{-- <x-get-program-code url="/om/transpot-report" /> ผ่านข้อมูลค่าขนส่งให้บัญชีเจ้าหนี้ --}}
        <x-get-page-title menu="" url="/om/transpot-report" />
    </h2>
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/transpot-report" /> ผ่านข้อมูลค่าขนส่งให้บัญชีเจ้าหนี้</strong>
        </li>
    </ol> --}}
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ผ่านข้อมูลค่าขนส่งให้บัญชีเจ้าหนี้</h3>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> กองคลังผลิตภัณฑ์ </a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2"> กองบัญชีรายได้ </a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="col-xl-6 m-auto mt-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="d-block">วันที่เริ่มคำนวน</label>
                                                    <div class="input-icon">
                                                        <!-- <input type="text" class="form-control date" name="start_date" placeholder="" value="{{ request()->old('start_date') }}" required>
                                                        <i class="fa fa-calendar"></i> -->
                                                        <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2" name="start_date" id="input_date" placeholder="" format="{{ trans("date.js-format") }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-4 mt-md-0">
                                                    <label class="d-block">ถึงวันที่</label>
                                                    <div class="input-icon">
                                                        <!-- <input type="text" class="form-control date" name="end_date" placeholder="" value="{{ request()->old('end_date') }}" required>
                                                        <i class="fa fa-calendar"></i> -->
                                                        <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2" name="end_date" id="input_date" placeholder="" format="{{ trans("date.js-format") }}" required>
                                                    </div>
                                                </div>
                                            </div><!--row-->
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">รหัสเจ้าหนี้</label>
                                            <div class="input-icon">
                                                <select class="form-control select2" name="transport_owner_code" id="transport_owner_code">
                                                    <option value="">-</option>
                                                    @foreach ($owners as $owner)
                                                        <option value="{{ $owner->vendor_code }}">{{ $owner->transport_owner_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">AP Invoice Batch</label>
                                            <textarea class="form-control" disabled="" name="group_id" id="group_id" rows="4" cols="50">
                                            </textarea>
                                            <input type="hidden" name="group_id_arr[]" id="group_id_arr">
                                        </div>

                                    </div><!--col-xl-6-->
                                    <div class="col-md-12">
                                        <div class="form-buttons">
                                            <div class="buttons d-md-flex justify-content-center w-100 text-center">
                                                <button class="btn btn-lg btn-success" type="button" onclick="draftdata();"><i class="fa fa-file-text-o"></i> จัดการเตรียมข้อมูล</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    
                                    <div class="col-xl-6 m-auto mt-4">

                                        <div class="form-group">
                                            <label class="d-block">เลือก AP Invoice Batch</label>
                                            <div class="input-icon">
                                                <select class="form-control select2" name="ap_invoice_batch" id="apinvoicebatch">
                                                    <option value="">-</option>
                                                    @foreach ($invoiceBatchs as $invoiceBatch)
                                                        <option value="{{ $invoiceBatch->invoice_batch  }}">{{ $invoiceBatch->invoice_batch }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="d-block">หมายเหตุ</label>
                                            <input type="text" class="form-control" disabled="" name="remark" placeholder="" value="">
                                        </div>
                                    </div><!--col-xl-6-->

                                    <div class="col-md-12">
                                        <div class="form-buttons">
                                            <div class="buttons d-md-flex justify-content-center w-100 text-center">
                                                <button class="btn btn-lg btn-success" type="button" onclick="callReport();"><i class="fa fa-file-text-o"></i> เรียกรายงาน</button>
                                                <button class="btn btn-lg btn-secondary mt-2 mt-md-0" type="button" onclick="senddatatoAP();"><i class="fa fa-exchange"></i> ส่งรายการ Interface AP</button>
                                                <button class="btn btn-lg btn-warning mt-2 mt-md-0" type="button" onclick="senddatatoAPwithPromotion();"><i class="fa fa-check"></i> ส่งรายการส่งเสริม Interface</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--row-->

        </div><!--ibox-content-->
    </div><!--ibox-->


</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.date').datepicker();
        $('.select2').select2({width: "100%"});
    });

    function draftdata()
    {
        if($('input[name="start_date"]').val() == '' || $('input[name="end_date"]').val() == '' || $('#transport_owner_code').find(":selected").val() == ''){
            swal('Error!','กรุณาระบุข้อมูลในครบถ้วน "วันที่เริ่มคำนวน" "ถึงวันที่" "รหัสเจ้าหนี้"','error');
            return false;
        }
        var owner = $('#transport_owner_code').find(":selected").val();
        var start = $('input[name="start_date"]').val();
        var end = $('input[name="end_date"]').val();
        // console.log(owner, start, end);
        $.ajax({
            url: "{{ route('om.transpot-report-draftData') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "owner": owner,
                "start": start,
                "end": end
            },
            beforeSend: function() {
                swal({
                    title: 'กำลังทำการตรวจสอบเงื่อนไข',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res){
                // console.log('0 ', res);
                if(res.status == 'error'){
                    swal('Error!',res.data,'error');
                } else {
                    createDataone(res.data);
                }
            },
            error: function(error){
                swal.close();
                swal('Error!',error.responseText,'error');
            }
        });
    }

    function createDataone(data){
        $.ajax({
            url: "{{ route('om.transpot-report-createDataone') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "data": data
            },
            beforeSend: function() {
                swal({
                    title: 'กำลังจัดเตรียมข้อมูล กรุณารอสักครู่ (1 ใน 3)',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res){
                // console.log('1 ', res);
                if(res.status == 'error'){
                    swal('Error!',res.data,'error');
                } else {
                    createDatatwo(res.data, res.arr_group);
                }
            },
            error: function(error){
                console.log(error.responseText);
                swal.close();
                swal('Error!',error.responseText,'error');
            }
        });
    }


    function createDatatwo(data, arr_group){
        // console.log('data2', data, arr_group);
        $.ajax({
            url: "{{ route('om.transpot-report-createDatatwo') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "data": data,
                "arr_invoice_batch": arr_group
            },
            beforeSend: function() {
                swal({
                    title: 'กำลังจัดเตรียมข้อมูล กรุณารอสักครู่ (2 ใน 3)',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res){
                // console.log('2 ', res);
                if(res.status == 'error'){
                    swal('Error!',res.data,'error');
                } else {
                    createDataThree(res);
                }
            },
            error: function(error){
                swal.close();
                swal('Error!',error.responseText,'error');
            }
        });
    }

    function createDataThree(data){
        // console.log('data3 ', data);
        $.ajax({
            url: "{{ route('om.transpot-report-createDatathree') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "data": data,
                "arr_group": data.arr_group
            },
            beforeSend: function() {
                swal({
                    title: 'กำลังจัดเตรียมข้อมูล กรุณารอสักครู่ (3 ใน 3)',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res){
                console.log('3 ', res);
                if(res.status == 'error'){
                    swal('Error!',res.data,'error');
                } else {
                    var start = $('input[name="start_date"]').val();
                    var end = $('input[name="end_date"]').val();
                    if(res.datamsg != 'เสร็จสิ้น ไม่พบรายการจัดเตรียมข้อมูลเจ้าหนี้'){
                        var arr = '';
                        var group_id_arr = [];
                        // var data_group = res.arr_group;
                        // console.log(res.arr_group);
                        for (let i = 0; i < res.arr_group.length; i++) {
                            if ($('#apinvoicebatch').find("option[value='" + res.arr_group[i] + "']").length) {
                                // $('#apinvoicebatch').val(res.arr_group[i]).trigger('change');
                            } else { 
                                var newOption = new Option(res.arr_group[i], res.arr_group[i], true, true);
                                $('#apinvoicebatch').children('option')[0].after(newOption);
                                $('#apinvoicebatch').val(res.arr_group[i]).trigger('change');
                                arr += res.arr_group[i] + '\r\n';
                                group_id_arr.push(res.arr_group[i]);
                            } 
                        }
                        $('#group_id_arr').val(group_id_arr);
                        $('#apinvoicebatch').val('').trigger('change');
                        $('#group_id').html(arr);
                    }
                    swal('Success',res.datamsg,'success');
                    if(res.datamsg != 'เสร็จสิ้น ไม่พบรายการจัดเตรียมข้อมูลเจ้าหนี้'){
                        var myWindow = window.open("{{ route('om.transpot-report-print') }}?group_id="+res.group_id+"&start="+start+"&end="+end+"&invoice_batch=", '_blank');
                        myWindow.focus();
                        // window.location.href = "{{ route('om.transpot-report-print') }}?group_id="+res.group_id+"&start="+start+"&end="+end;
                    }
                }
            },
            error: function(error){
                swal.close();
                swal('Error!',error.responseText,'error');
            }
        });
    }

    function callReport()
    {
        var apinvoicebatch = $('#apinvoicebatch').val();
        var myWindow = window.open("{{ route('om.transpot-report-print') }}?group_id=&start=&end=&invoice_batch="+apinvoicebatch, '_blank');
        myWindow.focus();
    }

    function senddatatoAP()
    {
        console.log($('#apinvoicebatch').val())
        if($('#apinvoicebatch').val() == ''){
            swal('Error!','กรุณาเลือก AP Invoice Batch','error');
            return false;
        }
        
        var group_id = $('#apinvoicebatch').val();

        $.ajax({
            url: "{{ route('om.transpot-report-createDataToAP') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "interfaceName": 'ค่าขนส่งปกติ',
                "group_id" : group_id
            },
            beforeSend: function() {
                swal({
                    title: 'กำลังดำเนินการส่งรายการ Interface',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res){
                console.log(res);
                if(res.status == 'error'){
                    swal('Error!',res.data,'error');
                } else {
                    if (res.msg != '') {
                        $('input[name="remark"]').val(res.msg);
                        swal('Error',res.msg,'error');
                    } else {
                        if (res.t == 0) {
                            $('input[name="remark"]').val(res.msg);
                            swal('Success','ไม่มีรายการส่ง Interface','success');
                        } else {
                            $('input[name="remark"]').val(res.msg);
                            swal('Success','ดำเนินการเรียบร้อยแล้ว','success');
                        }
                    }
                }
            },
            error: function(error){
                swal.close();
                swal('Error!',error.responseText,'error');
            }
        });
    }

    function senddatatoAPwithPromotion()
    {
        if($('#apinvoicebatch').val() == ''){
            swal('Error!','กรุณาเลือก AP Invoice Batch','error');
            return false;
        }
        
        var group_id = $('#apinvoicebatch').val();

        $.ajax({
            url: "{{ route('om.transpot-report-createDataToAP') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "interfaceName": 'ค่าขนส่งส่งเสริม',
                "group_id" : group_id
            },
            beforeSend: function() {
                swal({
                    title: 'กำลังดำเนินการส่งรายการ Interface',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res){
                console.log(res);
                if(res.status == 'error'){
                    swal('Error!',res.data,'error');
                } else {
                    if (res.msg != '') {
                        $('input[name="remark"]').val(res.msg);
                        swal('Error',res.msg,'error');
                    } else {
                        if (res.t == 0) {
                            $('input[name="remark"]').val(res.msg);
                            swal('Success','ไม่มีรายการส่ง Interface','success');
                        } else {
                            $('input[name="remark"]').val(res.msg);
                            swal('Success','ดำเนินการเรียบร้อยแล้ว','success');
                        }
                    }
                }
            },
            error: function(error){
                swal.close();
                swal('Error!',error.responseText,'error');
            }
        });
    }
</script>
@endsection
