@extends('layouts.app')

@section('title', 'OMP0099 : ปรับปรุงรายการภาษีขาย สโมสร กทม. (กองภาษี) สำหรับขายในประเทศ')

@section('page-title')
  <x-get-page-title menu="" url="/om/tax-adjustments-bkk" />
@stop

{{-- @section('page-title')
  <h2>OMP0099 : ปรับปรุงรายการภาษีขาย สโมสร กทม. (กองภาษี) สำหรับขายในประเทศ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">หน้าหลัก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>ปรับปรุงรายการภาษีขาย สโมสร กทม. (กองภาษี) สำหรับขายในประเทศ</strong>
    </li>
  </ol>
@stop --}}

{{-- @section('page-title-action')
    <a href="{{ route('ir.settings.product-groups.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop --}}

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <tax-adjustments-bkk-search :btn-trans = "{{ json_encode($btnTrans) }}"
                                    :format-date = "{{ json_encode($formatDate) }}"
                                    :old-input = "{{ json_encode(Session::getOldInput()) }}">

        </tax-adjustments-bkk-search>
    </div>
@endsection