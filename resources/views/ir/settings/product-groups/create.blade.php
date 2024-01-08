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
    <li class="breadcrumb-item">
        <a><x-get-program-code url="/ir/settings/product-groups" />: ข้อมูลกลุ่มสินค้าคงคลัง</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>สร้าง</strong>
      </li>
  </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/ir/settings/product-groups" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>เพิ่มข้อมูลกลุ่มสินค้าคงคลัง</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['ir.settings.product-groups.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}

                    <group-products-create-componies    :policy-set-headers = "{{ json_encode($policySetHeaders) }}"
                                                        :accounts-mappings = "{{ json_encode($accountsMappings) }}"
                                                        :asset-groups = "{{ json_encode($assetGroups) }}"
                                                        :old-input="{{ json_encode(Session::getOldInput()) }}">
                    </group-products-create-componies>

                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="{{ $btnTrans['save']['class'] }}" 
                                        type="submit"> 
                                    <i class="{{ $btnTrans['save']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['save']['text'] }} 
                                </button>
                                <a  type="button" href="{{ route('ir.settings.product-groups.index') }}" 
                                    class="{{ $btnTrans['cancel']['class'] }}"> 
                                    <i class="{{ $btnTrans['cancel']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['cancel']['text'] }} 
                                </a>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
