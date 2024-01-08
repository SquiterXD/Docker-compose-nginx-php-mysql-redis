@extends('layouts.app')

@section('title', 'ผ่านข้อมูลค่านายหน้าให้บัญชีเจ้าหนี้')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')

<h2>
    {{-- <x-get-program-code url="/om/transfer-commission" /> ผ่านข้อมูลค่านายหน้าให้บัญชีเจ้าหนี้ --}}
    <x-get-page-title menu="" url="/om/transfer-commission" />
</h2>
{{-- <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>ผ่านข้อมูลค่านายหน้าให้บัญชีเจ้าหนี้</strong>
    </li>
</ol> --}}
@stop
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ผ่านข้อมูลค่านายหน้าให้บัญชีเจ้าหนี้</h3>
        </div>
        <div class="ibox-content"> 
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-xl-6 m-auto mt-4">
                    <div class="form-group"> 
                        <div class="row">
                            <div class="col-md-6">
                                <label class="d-block">วันที่เริ่มคำนวน</label> 
                                <div class="input-icon">
                                    <!-- <input type="text" class="form-control date" name="start_date" placeholder="" value="">
                                    <i class="fa fa-calendar"></i>  -->
                                    <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2" name="start_date" id="input_date" placeholder="" format="{{ trans("date.js-format") }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4 mt-md-0">
                                <label class="d-block">ถึงวันที่</label> 
                                <div class="input-icon">
                                    <!-- <input type="text" class="form-control date" name="end_date" placeholder="" value="">
                                    <i class="fa fa-calendar"></i>  -->
                                    <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2" name="end_date" id="input_date" placeholder="" format="{{ trans("date.js-format") }}" required>
                                </div>
                            </div>
                        </div><!--row-->
                    </div> 

                    <div class="form-group"> 
                        <label class="d-block">AP Invoice Batch</label> 
                        <input type="text" class="form-control" disabled="" name="group_id" placeholder="" value="">
                    </div>

                    <div class="form-group"> 
                        <label class="d-block">หมายเหตุ</label> 
                        <input type="text" class="form-control" disabled="" name="remark" placeholder="" value="">
                    </div>
                </div><!--col-xl-6-->

                <div class="col-12">
                    <div class="form-buttons">
                        <div class="d-md-flex w-100 text-center justify-content-center">
                            <button class="btn btn-lg btn-secondary mb-2 h-auto" type="button" onclick="sendAP('BKK');">ส่งรายการค่านายหน้าสโมสร<br>กรุงเทพฯ Interface AP</button>

                            <button class="btn btn-lg btn-secondary mb-2 h-auto" type="button" onclick="sendAP('NonBKK');">ส่งรายการค่านายหน้าสโมสร<br>ภูมิภาค Interface AP</button>
                        </div>
                    </div>
                </div>

                 
            </div><!--row-->
        </div><!--ibox-content-->
    </div><!--ibox-->

     
</div>
@endsection

@section('scripts')
<script src="{!! asset('js/moment.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/lodash.js') !!}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $('.date').datepicker();
    });

    function sendAP(locate){
        $.ajax({
                    url: "{{ route('om.sendap-transfer-commission') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "locate": locate,
                        "start": $('input[name="start_date"]').val(),
                        "end": $('input[name="end_date"]').val()
                    },
                    cache: false,
                    beforeSend: function() {
                        swal({
                            title: 'กำลังดำเนินการตรวจสอบเงื่อนไขและส่งรายการอินเตอร์เฟซ',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(res) {
                        console.log(res);
                        // swal.close();
                        if(res.status == 'error'){
                            swal({
                                title: res.data,
                                type: 'error'
                            });
                        } else {
                            $('input[name="group_id"]').val(res.group_id);
                            $('input[name="remark"]').val(res.msg);
                            // swal({
                            //     title: res.data,
                            //     type: 'success'
                            // });
                            setTimeout(() => {
                                updateConsignemnt(res.wbn);
                            }, 5000);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        swal({
                            title: error.responseText,
                            type: 'error'
                        });
                    }
                });
    }

    function updateConsignemnt(wbn) {
            $.ajax({
                url: "{{ route('om.update-consignment-commission') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "web_batch_no": wbn
                },
                cache: false,
                success: function(res) {
                    console.log(res);
                    // swal.close();
                    swal({
                            title: wbn,
                            type: 'success'
                        });
                },
                error: function(error) {
                    console.log(error);
                    swal({
                        title: error.responseText,
                        type: 'error'
                    });
                }
            });
    }
</script>
@endsection