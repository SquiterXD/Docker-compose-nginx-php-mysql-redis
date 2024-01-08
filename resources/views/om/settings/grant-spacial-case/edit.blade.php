@extends('layouts.app')
@section('title', 'OMS0021')

@section('page-title')
    <h2>OMS0021: กำหนดสิทธิ์สั่งซื้อพิเศษ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.grant-spacial-case.index') }}">กำหนดสิทธิ์สั่งซื้อพิเศษ</a>
        </li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดสิทธิ์สั่งซื้อพิเศษ</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.grant-spacial-case.update', $grant->grant_special_id] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    @method('PUT')
                    <grant-spacial-case-form 
                        :default-value="{{ json_encode($grant)}}"
                        :customers="{{json_encode($customers)}}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        >
                    </grant-spacial-case-form>
   
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" 
                                        type="submit"> 
                                    <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                    {{ trans('btn')['save']['text'] }} 
                                </button>
                                <a  href="{{ route('om.settings.grant-spacial-case.index') }}" 
                                    type="button" 
                                    class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
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