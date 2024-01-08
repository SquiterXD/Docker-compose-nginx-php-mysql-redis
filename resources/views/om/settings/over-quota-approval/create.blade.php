@extends('layouts.app')

@section('title', 'OMS0025')

@section('page-title')
    <h2>OMS0025: กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.over-quota-approval.index') }}">กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.over-quota-approval.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    
                    <over-quota-approval-form 
                        :autho-rity-lists="{{json_encode($authoRityLists)}}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        >
                    </over-quota-approval-form>
   
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" type="submit"> 
                                    <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                    {{ trans('btn')['save']['text'] }} 
                                </button>
                                <a href="{{ route('om.settings.over-quota-approval.index') }}" type="button" class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
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
