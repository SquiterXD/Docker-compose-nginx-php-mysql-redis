@extends('layouts.app')

@section('title', 'OMS0030')

@section('page-title')
    <h2>OMS0030: กำหนดผู้อนุมัติใบเตรียมการขาย / ใบสั่งซื้อ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.approver-order.index') }}">กำหนดผู้อนุมัติใบเตรียมการขาย / ใบสั่งซื้อ</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดผู้อนุมัติใบเตรียมการขาย / ใบสั่งซื้อ</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.approver-order.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    
                    <approver-order-form 
                        :autho-rity-lists="{{ json_encode($authoRityLists) }}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        >
                    </approver-order-form>
   
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button> --}}
                                {{-- <a href="{{ route('om.settings.approver-order.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a> --}}
                                <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" type="submit"> 
                                    <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                    {{ trans('btn')['save']['text'] }} 
                                </button>
                                <a href="{{ route('om.settings.approver-order.index') }}" type="button" class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
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
