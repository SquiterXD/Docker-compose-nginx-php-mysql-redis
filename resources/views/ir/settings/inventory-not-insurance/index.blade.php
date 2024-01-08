@extends('layouts.app')

@section('title', 'IRM0011')

@section('page-title')
    <x-get-page-title menu="" url="/ir/settings/inventory-not-insurance" />
@stop
{{-- @section('page-title-action')
<div>
  <fetch-inventory-not-insurance :btn-trans="{{ json_encode(trans('btn')) }}">
  </fetch-inventory-not-insurance>
</div>
@stop --}}
{{-- @section('content')
    <index-inventory-not-insurance
        :trans_btn="{{ json_encode(trans('btn')) }}"
        :url-reset="{{ json_encode(route('ir.settings.inventory-not-insurance.index')) }}"
    />
@endsection --}}
@section('content')
  <div class="row">
    <div class="col-lg-12">
      <index-inventory-not-insurance
        :url-reset="{{ json_encode(route('ir.settings.inventory-not-insurance.index')) }}"
      />
      {{-- <div class="ibox">
        <div class="ibox-title">
          <h5>ข้อมูลสินค้าคงคลังไม่ทำประกัน</h5>
        </div>
        <div class="ibox-content">
            <index-inventory-not-insurance
                :trans_btn="{{ json_encode(trans('btn')) }}"
                :url-reset="{{ json_encode(route('ir.settings.inventory-not-insurance.index')) }}"
            />

            <div class="mb-2">
                <a href="{{ route('ir.settings.inventory-not-insurance.export') }}" class="{{ trans('btn.print.class') }}" target="_bank">
                Export
                </a>
            </div>

          @include('ir.settings.inventory-not-insurance._table');
        </div>
      </div> --}}
    </div>
  </div>
@endsection
