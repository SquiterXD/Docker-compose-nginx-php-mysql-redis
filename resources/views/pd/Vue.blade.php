@extends('layouts.app')

@section('title', 'PD')

@section('page-title')
    <h2>{{ empty($profile) ? "" : $profile->title }} </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">{{ empty($profile) ? "" : $profile->description }}</a>
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
    {{--    <script>--}}
    {{--        setTimeout(() => {--}}
    {{--            let node = document.createElement("style");--}}
    {{--            node.innerHTML = `--}}
    {{--                .el-select-dropdown {--}}
    {{--                    z-index: 2050 !important;--}}
    {{--                }--}}
    {{--            `--}}
    {{--            document.getElementById("app").appendChild(node);--}}
    {{--        }, 1000)--}}
    {{--    </script>--}}

    <link rel="stylesheet" href="/css/ct.css" />

@endsection



