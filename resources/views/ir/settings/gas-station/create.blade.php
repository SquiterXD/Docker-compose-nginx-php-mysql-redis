@extends('layouts.app')

@section('title', 'Gas Station')

@section('page-title')
  {{-- <h2><x-get-program-code url="/ir/settings/gas-station" /> : ข้อมูสถานีน้ำมัน</h2>
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
      <a href="/ir/settings/gas-station"><x-get-program-code url="/ir/settings/gas-station" /> : ข้อมูสถานีน้ำมัน </a>
    </li>
    <li class="breadcrumb-item">
      <strong><a>Create</a></strong>
    </li>
  </ol> --}}
  <x-get-page-title menu="" url="/ir/settings/gas-station" />
@stop

@section('page-title-action')
  
@stop

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <gas-station-create :btn-trans="{{ json_encode($btnTrans) }}"/>
    </div>
  </div>
@endsection

