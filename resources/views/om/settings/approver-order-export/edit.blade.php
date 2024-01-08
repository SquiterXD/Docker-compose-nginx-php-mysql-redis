@extends('layouts.app')

@section('title', 'OMS0033')

@section('page-title')
    <h2>OMS0033: กำหนดผู้อนุมัติใบ Sale Confirmation</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.approver-order-export.index') }}">กำหนดผู้อนุมัติใบ Sale Confirmation</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดผู้อนุมัติใบ Sale Confirmation</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.approver-order-export.update', $approverOrder->approver_order_id] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        @method('PUT')
                        <approver-order-export-form 
                            :default-value="{{ json_encode($approverOrder)}}"
                            :autho-rity-lists="{{ json_encode($authoRityLists) }}"
                            :old="{{ json_encode(Session::getOldInput()) }}"
                            >
                        </approver-order-export-form>
    
                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                    <a href="{{ route('om.settings.approver-order-export.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a> --}}

                                    <button class="btn btn-sm {{ trans('btn')['save']['class'] }}" type="submit"> 
                                        <i class="{{ trans('btn')['save']['icon'] }}"></i> 
                                        {{ trans('btn')['save']['text'] }} 
                                    </button>
                                    <a href="{{ route('om.settings.approver-order-export.index') }}" type="button" class="btn btn-sm {{ trans('btn')['cancel']['class'] }}"> 
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
