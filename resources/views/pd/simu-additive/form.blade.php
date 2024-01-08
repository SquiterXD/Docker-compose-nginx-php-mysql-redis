@extends('layouts.app')

@section('title', 'PD')

@section('page-title')
    <h2>PD</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Simu Additive</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <simu-additive-form :data="{{ json_encode($data) }}"></simu-additive-form>
        </div>
    </div>
@endsection