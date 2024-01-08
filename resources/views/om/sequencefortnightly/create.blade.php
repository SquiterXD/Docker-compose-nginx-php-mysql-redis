@extends('layouts.app')

@section('title', 'สร้างข้อมูลลูกค้า สำหรับขายในประเทศ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop


@section('page-title')
    <h2>สร้างข้อมูลลูกค้า</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>สร้างข้อมูลลูกค้า สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')

@endsection

@section('scripts')
    <script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
@stop
