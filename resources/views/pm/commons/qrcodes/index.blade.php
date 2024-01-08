@extends('layouts.app')

@section('title', 'บันทึกใช้ยาเส้น ZoneC48')

@section('page-title')
  <x-get-page-title menu="" url="/pm/sprinkle-tobaccos" />
@stop

{{-- @section('page-title')
    <h2><x-get-program-code url=""/> {{ $title ? $title : 'รายการวัตถุดิบ ' }}</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>{{ $title ? $title : 'รายการวัตถุดิบ ' }}</a>
        </li>
    </ol>
@stop --}}

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
@endsection



