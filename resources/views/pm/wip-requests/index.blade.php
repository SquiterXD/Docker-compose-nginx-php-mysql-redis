
@extends('layouts.app')

@section('title', 'บันทึกส่งสินค้าเข้าคลัง')

@section('page-title')
    <h2><x-get-program-code url="/pm/wip-requests"/> บันทึกผลผลิตเข้าคลัง</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>บันทึกส่งสินค้าเข้าคลัง</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    {{-- <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button> --}}
@stop

@section('content')
    <pm-wip-requests-index :p-url="{{ json_encode($url) }}"/>
@endsection
@section('scripts')
@stop