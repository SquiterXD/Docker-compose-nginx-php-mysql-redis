@extends('layouts.app')

@section('title', 'Policy')

@section('page-title')
{{-- <div class="pull-right" style="margin-top: 25px ">
  <a  type="button" 
      :href="`/ir/settings/policy/create`"
      class="btn btn-success">
    <i class="fa fa-plus" aria-hidden="true"></i> สร้าง
  </a>
</div> --}}
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
      <strong><x-get-program-code url='/ir/settings/policy'/> : ข้อมูลชุดกรมธรรม์ประกันภัย (Policy)</strong>
    </li>
  </ol>
@stop

@section('page-title-action')
<div>
  <a  type="button" 
      :href="`/ir/settings/policy/create`"
      class="{{ trans('btn.create.class') }} btn-lg tw-w-25">
      <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
  </a>
</div>
@stop

@section('content')
  <div class="row">
      <div class="col-lg-12">
        <div class='ibox'>
          <div class='ibox-title'>
            <h5>ข้อมูลชุดกรมธรรม์ประกันภัย (Policy)</h5>
          </div>
          <div class='ibox-content'>
            {{-- <index-policy :btn-trans="{{ json_encode($btnTrans) }}"/> --}}
            <search-policy :btn-trans="{{ json_encode($btnTrans) }}"
                            :data-search="{{ json_encode($dataSearch) }}"
                            >
            </search-policy>
            @include('ir.settings.policy.table')
          </div>
        </div>
      </div>
  </div>
@endsection
