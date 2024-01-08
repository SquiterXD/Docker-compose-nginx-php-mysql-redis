@extends('layouts.app')

@section('title', 'กำหนดหน่วยการทดสอบ')

{{-- @section('page-title')
    <h2><x-get-program-code url="/qm/settings/test-unit"/>: กำหนดหน่วยการทดสอบ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Settings</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/qm/settings/test-unit"/>: กำหนดหน่วยการทดสอบ</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/qm/settings/test-unit" />
@stop

@section('page-title-action')
    <a  href="{{ route('qm.settings.test-unit.create') }}" 
        class="{{ $btnTrans['create']['class'] }}">
        <i class="{{ $btnTrans['create']['icon'] }}"></i> {{ $btnTrans['create']['text'] }}
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><x-get-program-code url="/qm/settings/test-unit"/>: กำหนดจุดตรวจสอบด้านใบยา</h5>
                </div>
                <div class="ibox-content">
                    @include('qm.settings.test-units._table')
                </div>
            </div>
        </div>
    </div>
@endsection