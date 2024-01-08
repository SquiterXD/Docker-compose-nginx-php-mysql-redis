
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
@stop

@section('content')
    <pd-sml-cost-fmls-index :p-url="{{ json_encode($url) }}" :p-menu="{{ json_encode($url) }}"/>
@endsection
@section('scripts')
@stop