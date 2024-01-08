@extends('layouts.app')

@section('title', 'Gas Station')

@section('page-title')
{{-- <div class="pull-right" style="margin-top: 25px">
  <a  type="button" 
      :href="`/ir/settings/gas-station/create`"
      class="btn btn-success">
    <i class="fa fa-plus" aria-hidden="true"></i> สร้าง
  </a>
</div> --}}
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
      <strong><x-get-program-code url="/ir/settings/gas-station" /> : ข้อมูสถานีน้ำมัน</strong>
    </li>
  </ol> --}}

  <x-get-page-title menu="" url="/ir/settings/gas-station" />
@stop

@section('page-title-action')
<div>
  <a  type="button" 
      :href="`/ir/settings/gas-station/create`"
      class="{{ trans('btn.create.class') }} btn-lg tw-w-25">
    <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
  </a>
</div>
@stop

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox">
        <div class="ibox-title">
          <h5>ข้อมูลสถานีน้ำมัน (Gas Stations)</h5>
        </div>
        <div class="ibox-content">
          {{-- <gas-station-index :btn-trans="{{ json_encode($btnTrans) }}"/> --}}

          <gas-station-search :btn-trans="{{ json_encode($btnTrans) }}"
                            :data-search="{{ json_encode($dataSearch) }}"
                            >
          </gas-station-search>
          @include('ir.settings.gas-station.table')
        </div>
      </div>
    </div>
  </div>
@endsection


{{-- @section('scripts')
  @include('ir.scripts.datepicker.locales.bootstrap-datepicker-th')
  @include('ir.scripts.datepicker.bootstrap-datepicker-thai')
@stop --}}
