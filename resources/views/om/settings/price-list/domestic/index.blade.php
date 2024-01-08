@extends('layouts.app')

@section('title', 'OMS0012')

@section('page-title')
  <h2>OMS0012: Price List (สำหรับขายในประเทศ)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.settings.price-list.index') }}">กำหนด Price List</a>
    </li>
  </ol>
@stop

@section('page-title-action')
    <a href="{{ route('om.settings.price-list.create') }}" class="btn btn-success btn-xs">
      <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนด Price List</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.price-list.domestic._table')
                </div>
            </div>
        </div>
    </div>
@endsection
