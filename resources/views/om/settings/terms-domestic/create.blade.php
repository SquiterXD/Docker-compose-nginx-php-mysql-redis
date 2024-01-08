@extends('layouts.app')

@section('title', 'OMS0004')

@section('page-title')
  <h2>OMS0004: กำหนดเงื่อนไขการชำระเงิน (สำหรับขายในประเทศ)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.settings.term.index') }}">กำหนดเงื่อนไขการชำระเงินสำหรับขายในประเทศ</a>
    </li>
  </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดเงื่อนไขการชำระเงินสำหรับขายในประเทศ</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.term.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        
                    {{-- @include('om.setting.term._form') --}}
                    <payment-term-form :default-value="{{json_encode([])}}"> </payment-term-form>

                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('om.settings.term.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a> --}}

                              <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" type="submit"> 
                                <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                {{ trans('btn')['save']['text'] }} 
                              </button>
                              <a href="{{ route('om.settings.term.index') }}" type="button" class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
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