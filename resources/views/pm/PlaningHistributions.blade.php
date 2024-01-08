@extends('layouts.app')

@section('title', 'PD')

@section('page-title')
    <h2>การวางแผนผลิตยาเส้น</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>การวางแผนผลิตยาเส้น</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
        @php
            $component = 'planing-histributions ';
                echo "<$component";
                        foreach(get_defined_vars() as $prop => $value):
                        if(!str_starts_with($prop, '_')) echo ":$prop='" . json_encode($value) ."'\n";
                        endforeach;
                echo "></$component>";
        @endphp
@endsection



