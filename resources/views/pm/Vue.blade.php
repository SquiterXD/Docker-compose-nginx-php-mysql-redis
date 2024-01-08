@extends('layouts.app')

@section('title', 'PM')

@section('page-title')
    @if ($menu = \App\Models\Menu::where('url', '/'.request()->path())->orderBy('menu_id', 'desc')->first())
        <x-get-page-title :menu="$menu" url="" />
    @else
        <h2>PM</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
        </ol>
    @endif
@stop

@section('page-title-action')
@stop

@section('content')
    @php
        //$component = 'request-material-page ';
            echo "<$vueComponent ";
                    foreach(get_defined_vars() as $prop => $value):
                    if(!str_starts_with($prop, '_')) echo ":$prop='" . str_replace("'", "&apos;", json_encode($value)) ."'\n";
                    endforeach;
                    echo "date-old='" . old("input_date") . "'";
                    echo "date-trans='" . trans("date.js-format") . "'";
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



