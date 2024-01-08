@extends('layouts.app')

@section('title', 'OMP0029 : โอนข้อมูล Text File เพื่อส่งธนาคาร')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>OMP0029 : โอนข้อมูล Text File เพื่อส่งธนาคาร</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>โอนข้อมูล Text File เพื่อส่งธนาคาร</strong>
        </li>
    </ol>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>โอนข้อมูล Text File เพื่อส่งธนาคาร</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">

                    <div class="form-group">
                        <h3 class="black mb-3">ส่งข้อมูลระบบ Direct Debit</h3>

                        <label class="d-block">รหัสธนาคาร</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="" placeholder="" value="">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <input type="text" class="form-control" disabled="" name="" placeholder="" value="">
                            </div>
                        </div><!--row-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="d-block">ตั้งแต่ Due Date วันที่</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="" placeholder="" value="">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="d-block">ถึงวันที่</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="" placeholder="" value="">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div><!--row-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">ชื่อไฟล์</label>
                        <input type="text" class="form-control" disabled="" name="" placeholder="" value="C:\TTM\TTB.TXT">
                    </div><!--form-group-->


                    <div class="form-buttons d-block">
                        <div class="row space-5">
                            <div class="col-md-3 col-6 mb-2">
                                <button class="btn btn-lg btn-white m-0" type="button"><i class="fa fa-file-text-o"></i> ยืนยันข้อมูล</button>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <button class="btn btn-lg btn-primary m-0" type="button"><i class="fa fa-check-circle-o"></i> ตกลง</button>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <button class="btn btn-lg btn-danger m-0" type="button"><i class="fa fa-times"></i> ปิด</button>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <button class="btn btn-lg btn-warning m-0" type="button"><i class="fa fa-pencil-square-o"></i> จัดเตรียมข้อมูล</button>
                            </div>
                        </div><!--row-->
                    </div>
                </div><!--col-xl-6-->


            </div>
        </div><!--ibox-content-->
    </div><!--ibox-->


</div>
@endsection

@section('scripts')
<script>
</script>
@endsection
