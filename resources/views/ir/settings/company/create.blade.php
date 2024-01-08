@extends('layouts.app')

@section('title', 'Company')

@section('page-title')
  <h2><x-get-program-code url="/ir/settings/company" /> : ข้อมูลบริษัทประกันภัย</h2>
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
      <a href="/ir/settings/company"><x-get-program-code url="/ir/settings/company" /> : ข้อมูลบริษัทประกันภัย</a></strong>
    </li>
    <li class="breadcrumb-item">
      <strong><a>Create</a></strong>
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
        <h5>Detail / Create New</h5><br>
        <h5>ข้อมูลผู้รับประกัน</h5>
      </div>
      <div class="ibox-content">
        <company-create :btn-trans="{{ json_encode($btnTrans) }}"/>
      </div>
    </div>
  </div>
</div>
@endsection
