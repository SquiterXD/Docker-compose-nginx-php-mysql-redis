@extends('layouts.app')

@section('title', 'PD')

@section('page-title')
    <h2>PD</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <expanded-tobacco :data="{{ json_encode($data) }}"></expanded-tobacco>
        </div>
    </div>
@endsection