@extends('layouts.app')

@section('title', 'Policy')

@section('page-title')
<h2><strong><x-get-program-code url='/ir/settings/policy'/> : ข้อมูลชุดกรมธรรม์ประกันภัย</strong></h2>
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
      <a href="/ir/settings/policy"><x-get-program-code url='/ir/settings/policy'/> : ข้อมูลชุดกรมธรรม์ประกันภัย (Policy)</a>
    </li>
    <li class='breadcrumb-item'>
      <strong><a>Create</a></strong>
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
            <h5>ข้อมูลชุดกรมธรรม์ประกันภัย (Policy)</h5>
          </div>
          <div class='ibox-content'>
            <create-policy :btn-trans="{{ json_encode($btnTrans) }}"
                           :running-no="{{ json_encode($runningNo) }}"/>
          </div>
        </div>
      </div>
  </div>
@endsection
