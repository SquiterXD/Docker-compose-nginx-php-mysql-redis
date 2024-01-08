@extends('layouts.app')

@section('title', 'กำหนดรหัสเกณฑ์การปันส่วน')

@section('page-title')
    <h2>กำหนดรหัสเกณฑ์การปันส่วน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดรหัสเกณฑ์การปันส่วน</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <criterion-allocate-create-component></criterion-allocate-create-component>
                </div>
            </div>
        </div>
    </div>
@endsection
