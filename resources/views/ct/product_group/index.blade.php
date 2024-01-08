@extends('layouts.app')

@section('title', 'กำหนดกลุ่มผลิตภัณฑ์')

@section('page-title')
    <h2>กำหนดกลุ่มผลิตภัณฑ์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดกลุ่มผลิตภัณฑ์</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <product-group-index-component></product-group-index-component>
                </div>
            </div>
        </div>
    </div>
@endsection
