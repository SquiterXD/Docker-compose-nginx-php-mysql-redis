@extends('layouts.app')

@section('title', 'PM')

@section('page-title')
    <h2>PM</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>{{$title}}</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
    @php
    $component = 'request-material-view';
    echo "<$component ";
    foreach (get_defined_vars() as $prop => $value):
        if (!str_starts_with($prop, '_')) {
            echo ":$prop='" . json_encode($value) . "'\n";
        }
    endforeach;
    echo "></$component>";
    @endphp
    {{-- <request-material-view :lookups="@json($lookups)"></request-material-view> --}}
@endsection
