@extends('layouts.app')

@section('title', 'กำหนดการปันส่วนแสตมป์')

@section('page-title')
    <x-get-page-title menu="" url="/ct/stamp_adj" />
    {{-- <h2>CTM0020 : กำหนดการปันส่วนแสตมป์ </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> กำหนดการปันส่วนแสตมป์ </strong>
        </li>
    </ol> --}}
@stop
@section('page-title-action')
    <a href="{{ route('ct.stamp_adj.create') }}" class="{{ trans('btn.create.class') }}">
        <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
    </a>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">        
            <stamp-adj-index-component
                :trans_btn="{{ json_encode(trans('btn')) }}"
                :stamp-adjs="{{ json_encode($stampAdjs) }}"
            />
        </div>
    </div>
@endsection
