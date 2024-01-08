@extends('layouts.app')

@section('title', 'OMS0005')

@section('page-title')
  <h2>OMS0005: กำหนดเงื่อนไขการชำระเงิน (สำหรับขายต่างประเทศ)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.settings.term-export.index') }}">กำหนดเงื่อนไขการชำระเงินสำหรับขายต่างประเทศ</a>
    </li>
  </ol>
@stop
@if (canEnter('/om/settings/term-export'))
  @section('page-title-action')
      <a href="{{ route('om.settings.term-export.create') }}" class="btn btn-success btn-xs">
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
                    <h5>กำหนดเงื่อนไขการชำระเงินสำหรับขายต่างประเทศ</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.terms-export._table')
                </div>
            </div>
        </div>
    </div>
@endsection
