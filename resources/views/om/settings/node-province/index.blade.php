@extends('layouts.app')

@section('title', 'OMS0042')

@section('page-title')
    <h2> OMS0042 : กำหนด Node</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.node-province.index') }}">กำหนด Node</a>
        </li>
    </ol>
@stop
{{-- @if (canEnter('/om/settings/node-province'))
    @section('page-title-action')
        <a href="{{ route('om.settings.node-province.create') }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i> สร้าง
        </a>
    @stop
@endif --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <node-province-table
                :user-profile="{{ json_encode($userProfile) }}"
                :trans-date="{{ json_encode(trans('date')) }}"
                :trans-btn="{{ json_encode(trans('btn')) }}"
                :provinces="{{ json_encode($provinces) }}"
                :sys-date="{{ json_encode(now()) }}"
                :p-node-headers="{{ json_encode($nodeHeaders) }}" 
            >
            </node-province-table>
        </div>
    </div>
@endsection
