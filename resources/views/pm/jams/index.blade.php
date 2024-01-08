
@extends('layouts.app')

@section('title', 'หน้าจอเรียกใบยาและการส่งขออนุมัติการสร้างลูกค้า')

@section('page-title')
    <h2><x-get-program-code url="/pm/jams"/> หน้าจอเรียกใบยา</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>หน้าจอเรียกใบยา</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    {{-- <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button> --}}
@stop

@section('content')
    <pm-jams-index :p-url="{{ json_encode($url) }}"/>
@endsection
@section('scripts')

@stop