@extends('layouts.app')
@section('title', 'OMS0027')

@section('page-title')
    <h2>OMS0027: บันทึกข้อมูลเจ้าของรถขนส่ง</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <a>บันทึกข้อมูลเจ้าของรถขนส่ง</a>
        </li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>บันทึกข้อมูลเจ้าของรถขนส่ง</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.transport-owner.update', $tranSportOwner->transport_owner_id] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        @method('PUT')
                        <transport-owner-form
                            :po-vendors="{{ json_encode($poVendors) }}"
                            :old="{{ json_encode(Session::getOldInput()) }}"
                            {{-- :url="{{ json_encode(route('om.settings.transport-owner.store')) }}"
                            :url-update="{{ json_encode(route('om.settings.transport-owner.update', $tranSportOwner->transport_owner_id)) }}"
                            :url-return="{{ json_encode(route('om.settings.transport-owner.index')) }}" --}}
                            :default-value="{{ json_encode($tranSportOwner) }}"
                            :vendor-selected="{{  json_encode($tranSportOwner->vendor) }}"
                            >
                        </transport-owner-form>

                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                    <a href="{{ route('om.settings.transport-owner.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a> --}}

                                    <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" type="submit"> 
                                        <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                        {{ trans('btn')['save']['text'] }} 
                                    </button>
                                    <a href="{{ route('om.settings.transport-owner.index') }}" type="button" class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
                                        <i class="{{ trans('btn')['cancel']['icon'] }}"></i> 
                                        {{ trans('btn')['cancel']['text'] }} 
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
