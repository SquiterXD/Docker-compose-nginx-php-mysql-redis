@extends('layouts.app')

@section('title', 'Vehicle')

@section('page-title')
  {{-- <h2><x-get-program-code url="/ir/settings/vehicle" /> : ข้อมูลยานพาหนะ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>Insurance</a>
    </li>
    <li class="breadcrumb-item">
      <a>Setting-IR</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="/ir/settings/vehicle"><x-get-program-code url="/ir/settings/vehicle" /> : ข้อมูลยานพาหนะ</a>
    </li>
    <li class="breadcrumb-item">
      <strong><a>Edit</a></strong>
    </li>
  </ol> --}}
  <x-get-page-title menu="" url="/ir/settings/vehicle" />
@stop

@section('page-title-action')
  
@stop

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <vehicle-edit :asset-id="{{ json_encode($assetId) }}"
                    :vehicle-id="{{ $vehicleId }}"
                    :btn-trans="{{ json_encode($btnTrans) }}"
                    :default-value-set-name="{{ json_encode($defaultValueSetName) }}"
                  />
    </div>
  </div>
@endsection
