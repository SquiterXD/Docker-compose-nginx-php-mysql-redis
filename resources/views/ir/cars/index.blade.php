@extends('layouts.app')

@section('title', 'Cars')

@section('page-title')
  <h2><x-get-program-code url='/ir/cars/car'/> : การต่ออายุประกันภัย - รถยนต์</h2>
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
      <strong><x-get-program-code url='/ir/cars/car'/> : การต่ออายุประกันภัย - รถยนต์</strong>
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
                  <h5>การต่ออายุประกันภัย - รถยนต์</h5>
              </div>
              <div class="ibox-content">
                <cars :default-value-set-name="{{ json_encode($defaultValueSetName) }}"
                :policy-car-types="{{ json_encode($policyCarTypes) }}" 
                :url-export="{{ json_encode(route('ir.cars.car.export')) }}"/>
              </div>
          </div>
      </div>
  </div>
@endsection
