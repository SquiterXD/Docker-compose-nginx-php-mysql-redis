@extends('layouts.app')

@section('title', 'OMS0011')
@section('page-title')
  <h2>OMS0011: กำหนดประเทศ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('om.settings.country.index') }}">กำหนดประเทศ</a>
    </li>
  </ol>
@stop
@if (canEnter('/om/settings/country'))
    @section('page-title-action')
        <a href="{{ route('om.settings.country.create') }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i> สร้าง
        </a>
    @stop
@endif
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดประเทศ</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.country._table')
                </div>
            </div>
        </div>
    </div>
@endsection
