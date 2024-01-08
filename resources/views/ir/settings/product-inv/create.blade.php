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
            <a href="{{ route('ir.settings.product-header.index') }}"><x-get-program-code url="/ir/settings/product-header" />: ข้อมูลกลุ่มสินค้าแยกตามคลังสินค้า</a>
        </li>
        <li class="breadcrumb-item">
            <strong>สร้าง</strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/ir/settings/product-header" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    {!! Form::open(['route' => ['ir.settings.product-header.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <product-inv-create-componies
                            :group-products     = "{{ json_encode($groupProducts) }}"
                            :policy-sets        = "{{ json_encode($policySets) }}"
                            :sub-inventories    = "{{ json_encode($subInventories) }}" 
                            :departments        = "{{ json_encode($departments) }}"
                            :url                = "{{ json_encode(route('ir.settings.product-header.index')) }}"
                            :old-group-code     = "{{ json_encode(request()->groupCode) }}"
                            :data               = "{{ json_encode(request()->data) }}"
                            :old-input          = "{{ json_encode(Session::getOldInput()) }}"
                            :btn-trans          = "{{ json_encode($btnTrans) }}">
                        </product-inv-create-componies>                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection