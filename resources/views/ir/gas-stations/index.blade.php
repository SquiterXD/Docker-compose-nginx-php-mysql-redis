@extends('layouts.app')

@section('title', 'Gas Station')

@section('page-title')
  <h2><x-get-program-code url='/ir/gas-stations/gas-station'/> : การต่ออายุประกันภัย - สถานีน้ำมัน</h2>
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
      <strong><x-get-program-code url='/ir/gas-stations/gas-station'/> : การต่ออายุประกันภัย - สถานีน้ำมัน</strong>
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
                  <h5>การต่ออายุประกันภัย - สถานีน้ำมัน</h5>
              </div>
              <div class="ibox-content">
                <gas-station :url-export="{{ json_encode(route('ir.gas-stations.gas-station.export')) }}"/>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('scripts')
  @include('ir.scripts.datepicker.locales.bootstrap-datepicker-th')
  @include('ir.scripts.datepicker.bootstrap-datepicker-thai')
@stop
