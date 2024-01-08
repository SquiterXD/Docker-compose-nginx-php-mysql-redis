@extends('layouts.app')

@section('title', 'บันทึกคลังเบิกวัตถุดิบ')

{{-- @section('page-title')
    <h2><strong><x-get-program-code url='/pm/settings/setup-transfer'/> : บันทึกคลังเบิกวัตถุดิบ</strong></h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>PM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <x-get-program-code url='/pm/settings/setup-transfer'/> : บันทึกคลังเบิกวัตถุดิบ</a>
        </li>
        <li class="breadcrumb-item">
            <strong><x-get-program-code url='/pm/settings/setup-transfer/create'/>สร้าง</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/pm/settings/setup-transfer" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-left m-t">
                <div class="ibox-title">
                    <h5>สร้าง : บันทึกคลังเบิกวัตถุดิบ</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['pm.settings.setup-transfer.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    <setup-transfer-create  :item-cats="{{ json_encode($itemCats) }}"
                                            :old-input="{{ json_encode($oldInput) ?? '' }}"
                                            :request-types="{{ json_encode($requestTypes) }}">

                    </setup-transfer-create>
                    <div class="col-12 mt-5">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="{{ $btnTrans['save']['class'] }}" type="submit">
                                    <i class="{{ $btnTrans['save']['icon'] }}"></i> {{ $btnTrans['save']['text'] }} 
                                </button>
                                <a  href="{{ route('pm.settings.setup-transfer.index') }}" 
                                    type="button" 
                                    class="{{ $btnTrans['cancel']['class'] }}">
                                    <i class="{{ $btnTrans['cancel']['icon'] }}"></i> {{ $btnTrans['cancel']['text'] }}
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