@extends('layouts.app')

@section('title', 'Asset')

@section('page-title')
  <h2>IRP0003: IR1 การต่ออายุประกันภัย - ทรัพย์สิน </h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>IR</a>
    </li>
    <li class="breadcrumb-item">
        <a>Assets</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>IRP0003: IR1 การต่ออายุประกันภัย - ทรัพย์สิน </strong>
    </li>
  </ol>
@stop

@section('page-title-action')
  
@stop

@section('content')
<div class="row">
  <div class="col-lg-12">
    <asset-index />
  </div>
</div>
@endsection

