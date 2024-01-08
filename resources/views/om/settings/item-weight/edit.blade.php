@extends('layouts.app')
@section('title', 'OMS0031')

@section('page-title')
    <h2>OMS0031: กำหนด Weight / Unit</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.item-weight.index') }}">กำหนด Weight / Unit</a>
        </li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนด Weight / Unit</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.item-weight.update', $itemWeight->weight_id] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    @method('PUT')
                    <item-weight-form
                        :default-value="{{ json_encode($itemWeight)}}"
                        :sequence-ecoms="{{json_encode($sequenceEcoms)}}"
                        :uoms="{{json_encode($uoms)}}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        :trans-date="{{ json_encode(trans('date')) }}"
                        >
                    </item-weight-form>
   
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('om.settings.item-weight.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a> --}}

                                <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" type="submit"> 
                                    <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                    {{ trans('btn')['save']['text'] }} 
                                </button>
                                <a href="{{ route('om.settings.item-weight.index') }}" type="button" class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
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
