
@extends('layouts.app')

@section('title', 'โอนสินค้าสำเร็จรูป')

{{-- @section('page-title')
    <h2><x-get-program-code url="/pm/transfer-products"/> โอนสินค้าสำเร็จรูป</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>โอนสินค้าสำเร็จรูป</a>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/pm/transfer-products" />
@stop

@section('page-title-action')
    {{-- <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button> --}}
@stop

@section('content')
    <pm-transfer-products-index :p-url="{{ json_encode($url) }}" :ptpm-ex-cig-department="{{ $ptpmExCigDepartment }}" week-of-year="{{now()->weekOfYear}}" />
@endsection
@section('scripts')
    {{-- <script type="text/javascript">
        setTimeout( function() {
            var body = $('body');
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            }
        },500)
    </script> --}}
@stop