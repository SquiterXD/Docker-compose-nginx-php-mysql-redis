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
{{-- @if (canEnter('/om/settings/item-weight')) --}}
    @section('page-title-action')
        <a href="{{ route('om.settings.item-weight.create') }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i> สร้าง
        </a>
    @stop
{{-- @endif --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนด Weight / Unit</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.item-weight._table')
                </div>
            </div>
        </div>
    </div>
@endsection
