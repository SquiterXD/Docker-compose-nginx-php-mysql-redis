@extends('layouts.app')

@section('title', 'ข้อมูลกลุ่มสินค้าคงคลัง')

{{-- @section('page-title')
  <h2><x-get-program-code url="/ir/settings/product-groups" />: ข้อมูลกลุ่มสินค้าคงคลัง</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>IR</a>
    </li>
    <li class="breadcrumb-item">
        <a>Settings</a>
    </li>
    <li class="breadcrumb-item active">
        <strong><x-get-program-code url="/ir/settings/product-groups" />: ข้อมูลกลุ่มสินค้าคงคลัง</strong>
    </li>
  </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/ir/settings/product-groups" />
@stop

@section('page-title-action')
    <a  href="{{ route('ir.settings.product-groups.create') }}" 
        class="{{ $btnTrans['create']['class'] }}">
        <i class="{{ $btnTrans['create']['icon'] }}"></i> 
        {{ $btnTrans['create']['text'] }}
    </a>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        @include('ir.settings.product-groups.search')
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="text-center m-t-lg">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        {{-- @include('ir.settings.product-groups._table') --}}
                        <group-products-table-componies :group-products = "{{ json_encode($groupProducts) }}"
                                                        :btn-trans = "{{ json_encode($btnTrans) }}">

                        </group-products-table-componies>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection