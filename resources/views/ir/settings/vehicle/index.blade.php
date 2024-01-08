@extends('layouts.app')

@section('title', 'Vehicle')

@section('page-title')
{{-- <div class="pull-right" style="margin-top: 25px">
  <a  type="button" 
      :href="`/ir/settings/vehicle/create`"
      class="btn btn-success">
    <i class="fa fa-plus" aria-hidden="true"></i> สร้าง
   </a>
</div> --}}
  {{-- <h2><x-get-program-code url="/ir/settings/vehicle" /> : ข้อมูลยานพาหนะ</h2>
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
      <strong><x-get-program-code url="/ir/settings/vehicle" /> : ข้อมูลยานพาหนะ</strong>
    </li>
  </ol> --}}
  <x-get-page-title menu="" url="/ir/settings/vehicle" />
@stop

@section('page-title-action')
<div>
  {{-- <a type="button" 
    :href="`/ir/settings/vehicle/create`"
    class="{{ trans('btn.create.class') }} btn-lg tw-w-25"
    style="color: #FFF;">
    <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
  </a> --}}
  {{-- <a id="pull_btn" type="button" 
    :href="`/ir/settings/vehicle/get_fa_location`"
    class="btn btn-success btn-lg tw-w-25">
    <i class="{{ trans('btn.pull.icon') }}"></i> {{ trans('btn.pull.text') }}
  </a> --}}
  <vehicle-fetch :btn-trans="{{ json_encode($btnTrans) }}"
                  :url-create="{{ json_encode('/ir/settings/vehicle/create') }}">
  </vehicle-fetch>
</div>
@stop

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox">
        <div class="ibox-title">
          <h5>ข้อมูลยานพาหนะ (Vehicles)</h5>
        </div>
        <div class="ibox-content">
          {{-- <vehicle-index :btn-trans="{{ json_encode($btnTrans) }}"/> --}}
          <vehicle-search :btn-trans="{{ json_encode($btnTrans) }}"
                          :data-search="{{ json_encode($dataSearch) }}"
                          >
          </vehicle-search>

          <div class="mb-2">
            <a href="{{ route('ir.settings.vehicle.export') }}" class="{{ trans('btn.print.class') }}" target="_bank">
              Export
            </a>
          </div>

          @include('ir.settings.vehicle._table');
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @include('ir.settings.vehicle._script')
@stop