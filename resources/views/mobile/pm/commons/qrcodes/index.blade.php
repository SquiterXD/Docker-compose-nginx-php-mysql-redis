@extends('mobile.layouts.app')
@section('content')
    <div>
        <a href="{{ route('mobiles.index') }}" class="btn btn-dark btn-sm mr-2 pull-left">
            หน้าจอเมนู
        </a>

        <h5 class="mb-0"> &nbsp; </h5>
    </div><br>

    @php
        echo "<$vueComponent ";
                foreach(get_defined_vars() as $prop => $value):
                if(!str_starts_with($prop, '_')) echo ":$prop='" . str_replace("'", "&apos;", json_encode($value)) ."'\n";
                endforeach;
                echo "date-old='" . old("input_date") . "'";
                echo "date-trans='" . trans("date.js-format") . "'";
        echo "></$vueComponent>";
    @endphp

@endsection


{{-- @extends('layouts.app')

@section('title', 'PM')

@section('page-title')
    <h2><x-get-program-code url=""/> {{ $title ? $title : 'รายการวัตถุดิบ ' }}</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>{{ $title ? $title : 'รายการวัตถุดิบ ' }}</a>
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
                echo "date-trans='" . trans("date.js-format") . "'";
        echo "></$vueComponent>";
    @endphp
@endsection --}}



