@extends('layouts.app')

@section('title', 'OMS0026')

@section('page-title')
    <h2>OMS0026: กำหนดลำดับผลิตภัณฑ์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.sequence-ecom.index') }}">กำหนดลำดับผลิตภัณฑ์</a>
        </li>
    </ol>
@stop
{{-- @if (canEnter('/om/settings/sequence-ecom')) --}}
    @section('page-title-action')
        <a href="{{ route('om.settings.sequence-ecom.create') }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i> สร้าง
        </a>
    @stop
{{-- @endif --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                {{-- <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดลำดับผลิตภัณฑ์</h5>
                </div> --}}
                <div class="ibox-content">
                    <form action="" method="GET" autocomplete="off">
                        <search-sequence-ecom  
                                    :sequence-ecoms="{{ json_encode($sequenceEcoms) }}"
                                    :sales-types="{{ json_encode($salesTypes) }}"
                                    :product-type-domestics="{{json_encode($productTypeDomestics)}}"
                                    :product-type-exports="{{json_encode($productTypeExports)}}"
                                    :search-data="{{json_encode($searchData)}}"
                                    :action-url="{{ json_encode(route('om.settings.sequence-ecom.index')) }}">
                        </search-sequence-ecom>
                    </form>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดลำดับผลิตภัณฑ์</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.sequence-ecom._table')
                </div>
            </div>
        </div>
    </div>
@endsection
