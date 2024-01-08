@extends('layouts.app')

@section('title', 'Asset Plan')

@section('page-title')
  <h2><x-get-program-code url="/ir/assets/asset-plan" /> : การต่ออายุประกันภัย - ทรัพย์สิน </h2>
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
      <strong><x-get-program-code url="/ir/assets/asset-plan" /> : การต่ออายุประกันภัย - ทรัพย์สิน </strong>
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
          <h5>การต่ออายุประกันภัย - ทรัพย์สิน</h5>
        </div>
        <div class="ibox-content">
          <asset-plan-index />
        </div>
      </div>
    </div>
  </div>
@endsection

{{-- @section('scripts')
  @include('ir.scripts.datepicker.locales.bootstrap-datepicker-th')
  @include('ir.scripts.datepicker.bootstrap-datepicker-thai')
@stop --}}

