@extends('layouts.app')

@section('title', 'Asset Increse')

@section('page-title')
  <h2><x-get-program-code url="/ir/assets/asset-increase" />: IR3 การเพิ่ม/ลดทุนประกัน - ทรัพย์สิน </h2>
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
      <strong><x-get-program-code url="/ir/assets/asset-increase" />: IR3 การเพิ่ม/ลดทุนประกัน - ทรัพย์สิน </strong>
    </li>
  </ol>
@stop

@section('page-title-action')
  
@stop

@section('content')
<div class="row">
  <div class="col-lg-12">
    <asset-increase />
  </div>
</div>
@endsection
