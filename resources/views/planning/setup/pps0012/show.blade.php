@extends('layouts.app')

@section('title', $profile->program_code)

@section('page-title')
    <x-get-page-title menu="" url="/planning/setup/pps0012" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5> กำหนดสั่งซื้อแสตมป์ </h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['planning.setup.pps0012.update', $pps0012->day_code] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <div class="row">
                            <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-4 mt-2">
                                <div class="control-label mb-2"><strong> วันที่สั่งซื้อในสัปดาห์ </strong> </div>
                                <input  name="day_code" class="form-control col-12" value="{{ $pps0012->description }}" placeholder="วันที่สั่งซื้อในสัปดาห์" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-4 mt-2">
                                <div class="control-label mb-2"><strong> ปริมาณที่สั่งซื้อล่วงหน้าเพียงพอ (วัน) </strong> </div>
                                <input name="past_days" class="form-control col-12" value="{{ $pps0012->past_days }}" placeholder="ปริมาณที่สั่งซื้อล่วงหน้าเพียงพอ" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="btn btn-md btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                    <a href="{{ route('planning.setup.pps0012.index') }}" type="button" class="btn btn-md btn-danger">
                                        <i class="fa fa-times"></i> ยกเลิก
                                    </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
