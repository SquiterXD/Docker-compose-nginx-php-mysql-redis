@extends('layouts.app')

@section('title', 'Product Group By Sub-Inventory')

{{-- @section('page-title')
    <h2><x-get-program-code url="/ir/settings/product-header" />: ข้อมูลกลุ่มสินค้าแยกตามคลังสินค้า</h2>
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
        <li class="breadcrumb-item">
            <strong><a href="{{ route('ir.settings.product-header.index') }}"><x-get-program-code url="/ir/settings/product-header" />: ข้อมูลกลุ่มสินค้าแยกตามคลังสินค้า</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/ir/settings/product-header" />
@stop

@section('page-title-action')
    <a href="{{ route('ir.settings.product-header.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('page-title')
  <h2><x-get-program-code url="/ir/settings/product-header" />: ข้อมูลกลุ่มสินค้าแยกตามคลังสินค้า</h2>
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
        <strong><x-get-program-code url="/ir/settings/product-header" />: ข้อมูลกลุ่มสินค้าแยกตามคลังสินค้า</strong>
    </li>
  </ol>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-left">
                    <div class="ibox-content">
                        {!! Form::open(['route' => ['ir.settings.product-header.index'] , "method" => "get" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                            <product-inv-search-componies       :policy-set-headers = "{{ json_encode($policySetHeaders) }}"
                                                                :asset-groups = "{{ json_encode($assetGroups) }}"
                                                                :departments = "{{ json_encode($departments) }}"
                                                                :sub-inventories = "{{ json_encode($subInventories) }}"
                                                                :sub-groups = "{{ json_encode($subGroups) }}"
                                                                :group-products = "{{ json_encode($groupProducts) }}"
                                                                :search = "{{ json_encode($search) }}">
                            </product-inv-search-componies>
                            <div class="text-right" style="padding-top: 15px;">
                                <button class="btn btn-light" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                                </button>
                                <a type="button" href="{{ route('ir.settings.product-header.index') }}" class="btn btn-warning">
                                    <i class="fa fa-undo"></i> รีเซ็ต
                                </a>
                            </div>                            
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="text-center m-t-lg">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        <product-inv-table-componies    :headers = "{{ json_encode($headers) }}">
                            
                        </product-inv-table-componies>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



