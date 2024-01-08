@extends('layouts.app')

@section('title', 'OMS0013')

@section('page-title')
  <h2>OMS0013: Price List (สำหรับขายต่างประเทศ)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.settings.price-list-export.index') }}">กำหนด Price List</a>
    </li>
  </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนด Price List (สำหรับขายต่างประเทศ)</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.price-list.export._header')

                    @include('om.settings.price-list.export._line')

                    <hr>
                    <div class="text-right">
                      <a href="{{ route('om.settings.price-list-export.index') }}" class="btn btn-warning btn-xs">
                        ย้อนกลับ
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection