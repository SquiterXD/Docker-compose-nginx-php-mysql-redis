@extends('layouts.app')

@section('title', 'กลุ่มวัตถุดิบ')

@section('page-title')
    <h2>PMS0020 : กลุ่มวัตถุดิบ (Material Group)</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <strong><a href="{{ route('pm.settings.material-group.index') }}">กลุ่มวัตถุดิบ</a></strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('pm.settings.material-group.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center m-t-lg">
                <h1 class="tw-mt-0"></h1>
                <div class="ibox-content">
                    @include('pm.settings.material-group._table')
                </div>
            </div>
        </div>
    </div>
@endsection