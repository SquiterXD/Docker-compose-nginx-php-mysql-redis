@extends('layouts.app')

@section('title', 'Stock Monthly')

@section('page-title')
  <h2><x-get-program-code url="/ir/stocks/monthly" /> : ข้อมูลสินค้าประจำเดือน - การดึงข้อมูลสำหรับตัดค่าใช้จ่ายรายเดือน </h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>Insurance</a>
    </li>
    <li class="breadcrumb-item">
        <a>การต่ออายุประกันภัย</a>
    </li>
    <li class="breadcrumb-item active">
      <strong><x-get-program-code url="/ir/stocks/monthly" /> : ข้อมูลสินค้าประจำเดือน - การดึงข้อมูลสำหรับตัดค่าใช้จ่ายรายเดือน </strong>
    </li>
  </ol>
@stop

@section('page-title-action')
  
@stop

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox">
        <div class="ibox-title">
          <h5>ข้อมูลสินค้าประจำเดือน - การดึงข้อมูลสำหรับตัดค่าใช้จ่ายรายเดือน</h5>
        </div>
        <div class="ibox-content">
          <stock-monthly-index />
        </div>
      </div>
    </div>
  </div>
@endsection

{{-- @section('scripts')
  @include('ir.scripts.datepicker.locales.bootstrap-datepicker-th')
  @include('ir.scripts.datepicker.bootstrap-datepicker-thai')
@stop --}}


