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

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนด Price List (สำหรับขายในประเทศ)</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.price-list.domestic._header')

                    @include('om.settings.price-list.domestic._line')

                    <hr>
                    <div class="text-right">
                      <a href="{{ route('om.settings.price-list.index') }}" class="btn btn-warning btn-xs">
                        ย้อนกลับ
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection