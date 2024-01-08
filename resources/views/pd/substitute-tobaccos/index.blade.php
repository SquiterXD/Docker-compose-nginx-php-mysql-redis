
@extends('layouts.app')

@section('title', $menu->menu_title)

@section('page-title')
    <h2>{!! $getProgramCode !!} {{ $menu->menu_title }}</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item ">
            <a>บันทึกสูตรผลิตภัณฑ์</a>
        </li>
        <li class="breadcrumb-item active">
            <a>{{ $menu->menu_title }}</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    {{-- <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button> --}}
@stop

@section('content')
    <substitute-tobaccos-index :p-url="{{ json_encode($url) }}"/>
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