@extends('layouts.app')

@section('title', 'ผ่านข้อมูลภาษี อบจ. ให้บัญชีเจ้าหนี้')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')

<h2>
    <x-get-program-code url="/om/transfer-province" /> ผ่านข้อมูลภาษี อบจ. ให้บัญชีเจ้าหนี้
</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>ผ่านข้อมูลภาษี อบจ. ให้บัญชีเจ้าหนี้</strong>
    </li>
</ol>
@stop
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ผ่านข้อมูลภาษี อบจ. ให้บัญชีเจ้าหนี้</h3>
        </div>
        <div class="ibox-content"> 
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-xl-6 m-auto mt-4">
                    <div class="form-group"> 
                        <div class="row">
                            <div class="col-md-6">
                                <label class="d-block">วันที่เริ่มคำนวน</label>
                                <datepicker-th
                                    class="form-control date w-100"
                                    format="DD/MM/YYYY"
                                    name="start_date">
                                </datepicker-th>
                                {{-- <div class="input-icon">
                                    <input type="text" class="form-control date" name="start_date" placeholder="" value="">
                                    <i class="fa fa-calendar"></i> 
                                </div> --}}
                            </div>
                            <div class="col-md-6 mt-4 mt-md-0">
                                <label class="d-block">ถึงวันที่</label> 
                                <datepicker-th
                                    class="form-control date w-100"
                                    format="DD/MM/YYYY"
                                    name="end_date">
                                </datepicker-th>
                                {{-- <div class="input-icon">
                                    <input type="text" class="form-control date" name="end_date" placeholder="" value="">
                                    <i class="fa fa-calendar"></i> 
                                </div> --}}
                            </div>
                        </div><!--row-->
                    </div> 
                    <div class="form-group"> 
                        <label class="d-block">รหัสธนาคาร</label> 
                        <select name="bank" class="form-control select2" placeholder="Select" style="height: 40px;">
                            <option value=""> </option>
                            @foreach ($bankLists as $bank)
                                <option value="{{$bank->vendor_code.' : '.$bank->vendor_name.' : '.$bank->vendor_site_code}}"
                                    {{$bank->vendor_code == '0107537000882' && $bank->vendor_site_id == '5649' ? 'selected' : '' }}>
                                    {{$bank->vendor_code.' : '.$bank->vendor_name.' : '.$bank->vendor_site_code}}
                                </option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-group"> 
                        <label class="d-block">AP Invoice Batch</label> 
                        <input type="text" class="form-control" disabled="" name="ap_invoice_batch" placeholder="" value="">
                    </div>

                    <div class="form-group"> 
                        <label class="d-block">หมายเหตุ</label> 
                        <input type="text" class="form-control" disabled="" name="remark" placeholder="" value="">
                    </div>
                </div><!--col-xl-6-->

                <div class="col-12">
                    <div class="form-buttons">
                        <button class="btn btn-lg btn-secondary mt-2 mt-md-0" type="button" onclick="calculate();"><i class="fa fa-exchange"></i> ส่งรายการ Interface AP</button>
                    </div>
                </div>

                 
            </div><!--row-->
        </div><!--ibox-content-->
    </div><!--ibox-->

     
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // $('.date').datepicker();
        // const d = new Date();
        // $(".date").datepicker({
        //     altFormat: "mm/dd/yy",
        //     changeMonth: true,
        //     changeYear: true
        // });

        $(".select2").select2({width: "100%"});
    });

    function calculate() {
        var start = composeDate($('input[name="start_date"]').val());
        var end = composeDate($('input[name="end_date"]').val());
        var bank = $('select[name="bank"]').val();

        $('input[name="start_date"]').removeClass('err_validate');
        $('input[name="end_date"]').removeClass('err_validate');
        $('select[name="bank"]').removeClass('err_validate');

        if(start == '' || end == '' || bank == ''){
            swal({
                title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            if(start == ''){
                $('input[name="start_date"]').addClass('err_validate');
            }
            if(end == ''){
                $('input[name="end_date"]').addClass('err_validate');
            }
            if(bank == ''){
                $('select[name="bank"]').addClass('err_validate');
            }
            return false;
        }

        $.ajax({
            url: "{{ route('om.calculate-transfer-province') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "start_date": start,
                "end_date": end,
                "bank": bank
            },
            cache: false,
            beforeSend: function() {
                swal({
                    title: 'ตรวจสอบเงื่อนไขและกำลังผ่านค่าภาษี กรุณารอสักครู่',
                    showCancelButton: false,
                    showConfirmButton: false
                });
            },
            success: function(res) {
                if(res.status == 'error'){
                    $('input[name="remark"]').val(res.data);
                    swal({
                        title: res.data,
                        type: 'error'
                    });
                } else {
                    $('input[name="ap_invoice_batch"]').val(res.data);
                    swal({
                        title: 'ดำเนินการส่งรายการอินเตอร์เฟซแล้วจำนวน '+ res.number +' รายการ',
                        type: 'success'
                    });
                }
            },
            error: function(error) {
                swal({
                    title: error.statusText,
                    type: 'error'
                });
            }
         });
    }

    function composeDate(date)
    {
        array = date.split("/");
        return array[1]+'/'+array[0]+'/'+(parseInt(array[2])-543);
    }
</script>
@endsection
