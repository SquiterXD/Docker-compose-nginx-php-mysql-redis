@extends('layouts.app')

@section('title', $profile->program_code)

@section('page-title')
    <x-get-page-title menu="" url="/planning/setup/pps0011" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5> กำหนดแปลงหน่วยแสตมป์ </h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['planning.setup.pps0011.update', [$pps0011->inventory_item_id, $pps0011->formula_no]] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <div class="row">
                            <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-4 mt-2">
                                <div class="control-label mb-2"><strong> รหัสบุหรี่ </strong> </div>
                                <input type="hidden" name="cigarette_code" value="{{ $pps0011->cigarette_code}}">
                                <input class="form-control col-12" value="{{ $pps0011->cigarette_code.': '.$pps0011->cigarette->item_description }}" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-4 mt-2">
                                <div class="control-label mb-2"><strong> รหัสแสตมป์ </strong> </div>
                                <input type="hidden" name="item_number" value="{{ $pps0011->item_number}}">
                                <input class="form-control col-12" value="{{ $pps0011->item_number.': '.$pps0011->item_description }}" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-4 mt-2">
                                <div class="control-label mb-2"><strong> ม้วนละ (ดวง) </strong> </div>
                                <input name="stamp_per_roll" class="form-control col-12" value="{{ $pps0011->stamp_per_roll }}" placeholder="ปริมาณที่สั่งซื้อล่วงหน้าเพียงพอ" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="btn btn-md btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                    <a href="{{ route('planning.setup.pps0011.index') }}" type="button" class="btn btn-md btn-danger">
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
