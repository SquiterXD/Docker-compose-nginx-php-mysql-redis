@extends('layouts.app')

@section('title', 'OMS0016')

@section('page-title')
  <h2>OMS0016: กำหนดสายการอนุมัติสำหรับอนุมัติสร้างลูกค้าใหม่ (ต่างประเทศ)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>OM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('om.settings.customer.index') }}">กำหนดผูัอนุมัติการสร้างลูกค้า</a>
    </li>
  </ol>
@stop

@section('page-title-action')
    <a href="{{ route('om.settings.customer.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดผูัอนุมัติการสร้างลูกค้า</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.customer._table')
                </div>
            </div>
        </div>
    </div>
@endsection
