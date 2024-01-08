@extends('layouts.app')

@section('title', 'Company')

@section('page-title')
{{-- <div class="pull-right" style="margin-top: 25px ">
  <a  type="button" 
      :href="`/ir/settings/company/create`"
      class="btn btn-success">
    <i class="fa fa-plus" aria-hidden="true"></i> สร้าง
  </a>
</div> --}}
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
      <strong><x-get-program-code url="/ir/settings/company" /> : ข้อมูลบริษัทประกันภัย</strong>
    </li>
  </ol>
@stop

@section('page-title-action')
<div>
  <a  type="button" 
      :href="`/ir/settings/company/create`"
      class="{{ trans('btn.create.class') }} btn-lg tw-w-25">
      <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
  </a>
</div>
@stop

@section('content')
  <div class="col-lg-12">
    <div class="ibox">
      <div class="ibox-title">
        <h5>ข้อมูลบริษัทประกันภัย (Company)</h5>
      </div>
      <div class="ibox-content">
        {{-- <company-index :btn-trans="{{ json_encode($btnTrans) }}"/> --}}

        <company-search-test :btn-trans="{{ json_encode($btnTrans) }}"
                        :data-search="{{ json_encode($dataSearch) }}"
                        >
        </company-search-test>

        @include('ir.settings.company.table')
      </div>
    </div>
  </div>
@endsection
