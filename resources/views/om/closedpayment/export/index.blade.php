@extends('layouts.app')

@section('title', 'ปิดการรับเงินประจำวัน')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
<h2><x-get-program-code url="/om/closed-flag-payment/domestic" /> ปิดการรับเงินประจำวัน</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>ปิดการรับเงินประจำวัน</strong>
    </li>
</ol>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ปิดการรับเงินประจำวัน</h3>
        </div>
        <div class="ibox-content"> 
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-xl-6 m-auto mt-4">
                    <div class="form-group"> 
                        <label class="d-block">วันที่ปิดการรับเงิน</label> 
                        <div class="input-icon">
                            <input type="text" class="form-control date" name="" placeholder="" value="">
                            <i class="fa fa-calendar"></i> 
                        </div>
                    </div> 
                    
                    <div class="form-group"> 
                        <label class="d-block">Group ID</label> 
                        <input type="text" class="form-control" disabled="" name="" placeholder="" value="">
                    </div>

                    <div class="form-group"> 
                        <label class="d-block">หมายเหตุ</label> 
                        <input type="text" class="form-control" disabled="" name="" placeholder="" value="">
                    </div>
                </div><!--col-xl-6-->

                <div class="col-12">
                    <div class="form-buttons">  
                        <button class="btn btn-lg btn-secondary" type="button"><i class="fa fa-exchange"></i> ส่งรายการ Interface</button>
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
        $('.date').datepicker();
    });
</script>
@endsection