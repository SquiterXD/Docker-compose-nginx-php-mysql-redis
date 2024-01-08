@extends('layouts.app')

@section('title', 'ข้อมูลลูกค้า สำหรับขายในประเทศ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop


@section('page-title')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Customer Search</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">หน้าหลัก</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>ข้อมูลลูกค้า สำหรับขายในประเทศ</strong>
                </li>
            </ol>
        </div>
    </div><!--page-heading-->
@stop

@section('content')

@endsection


