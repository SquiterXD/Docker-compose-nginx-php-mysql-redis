@extends('layouts.app')

@section('title', 'OMS0004')

@section('page-title')
  <h2>OMS0004: กำหนดเงื่อนไขการชำระเงิน (สำหรับขายในประเทศ)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('om.settings.term.index') }}">กำหนดเงื่อนไขการชำระเงินสำหรับขายในประเทศ</a>
    </li>
  </ol>
@stop

@if (canEnter('/om/settings/term'))
  @section('page-title-action')
      <a href="{{ route('om.settings.term.create') }}" class="btn btn-success btn-xs">
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
                    <h5>กำหนดเงื่อนไขการชำระเงินสำหรับขายในประเทศ</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.terms-domestic._table')
                </div>
            </div>
        </div>
    </div>
@endsection
