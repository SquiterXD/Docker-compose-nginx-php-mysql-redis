@extends('layouts.app')

@section('title', 'Planning')

@section('page-title')
    {{-- <h2><x-get-program-code url=""/> {{ $title ?? '-' }}</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>{{ $title ?? '' }}</a>
        </li>
    </ol> --}}
    <x-get-page-title menu="" url="/planning/stamp-monthly" />
@stop
@section('page-title-action')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    @php
                        echo "<$vueComponent ";
                                foreach(get_defined_vars() as $prop => $value):
                                if(!str_starts_with($prop, '_')) echo ":$prop='" . str_replace("'", "&apos;", json_encode($value)) ."'\n";
                                endforeach;
                                echo "date-old='" . old("input_date") . "'";
                                echo "date-trans='" . trans("date.js-format") . "'";
                        echo "></$vueComponent>";
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
