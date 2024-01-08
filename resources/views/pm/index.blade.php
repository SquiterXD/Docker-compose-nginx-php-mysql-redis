@extends('layouts.app')

@section('title', 'PM')

@section('page-title')
    <h2><x-get-program-code url=""/> {{ $title }}</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>{{ $title }}</a>
        </li>
    </ol>
@stop
@section('page-title-action')
@stop

@section('content')
    @php
        echo "<$vueComponent ";
                foreach(get_defined_vars() as $prop => $value):
                if(!str_starts_with($prop, '_')) echo ":$prop='" . str_replace("'", "&apos;", json_encode($value)) ."'\n";
                endforeach;
                echo "date-old='" . old("input_date") . "'";
        echo "></$vueComponent>";
    @endphp
@endsection



