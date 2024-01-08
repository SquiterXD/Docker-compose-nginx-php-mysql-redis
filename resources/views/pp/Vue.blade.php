@extends('layouts.app')

@section('title', 'PP')

@section('page-title')
    <h2>PP</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
    @php
        //$component = 'request-material-page ';
            echo "<$vueComponent ";
                    foreach(get_defined_vars() as $prop => $value):
                    if(!str_starts_with($prop, '_')) echo ":$prop='" . json_encode($value) ."'\n";
                    endforeach;
            echo "></$vueComponent>";
    @endphp

    <link rel="stylesheet" href="/css/ct.css" />

@endsection



