@extends('layouts.app')

@section('title', 'Confirm to GL')

@section('page-title') 
  <h2><x-get-program-code url='/ir/confirm-to-gl'/> : Confirm เพื่อส่งข้อมูล เข้า GL-Oracle</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>Insurance</a>
    </li>
    <li class="breadcrumb-item active">
      <strong><x-get-program-code url='/ir/confirm-to-gl'/> : Confirm เพื่อส่งข้อมูล เข้า GL-Oracle</strong>
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
          <h5>Confirm เพื่อส่งข้อมูล เข้า GL-Oracle</h5>
        </div>
        <div class="ibox-content">
          <confirm-to-gl-index />
        </div>
      </div>
    </div>
  </div>
@endsection
