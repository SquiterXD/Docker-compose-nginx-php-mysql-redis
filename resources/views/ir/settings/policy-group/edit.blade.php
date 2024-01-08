@extends('layouts.app')

@section('title', 'Policy Group')

@section('page-title')
<h2><strong><x-get-program-code url='/ir/settings/policy-group'/> : กลุ่มกรมธรรม์</strong></h2>
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
     <a href="/ir/settings/policy-group"><x-get-program-code url='/ir/settings/policy-group'/> : กลุ่มกรมธรรม์ (Policy Group)</a>
    </li>
    <li class='breadcrumb-item'>
      <strong><a>Edit</a></strong>
    </li>
  </ol>
@stop

@section('page-title-action')
  
@stop

@section('content')
  <div class="row">
      <div class="col-lg-12">
        <div class='ibox'>
          <div class='ibox-title'>
            <h5>กลุ่มกรมธรรม์ (Policy Group)</h5>
          </div>
          <div class='ibox-content'>
            <edit-policy-group :btn-trans="{{ json_encode($btnTrans) }}"/>
          </div>
        </div>
      </div>
  </div>
@endsection
