@extends('layouts.app')

@section('title', 'Hierarchy')

@section('page-title')
    <h2>
        <x-get-program-code url="/ie/settings/hierarchy" /> Hierarchy <br>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item active">
            <strong>Hierarchy</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="row">
    <div class="col-md-2">
        @include('ie.settings.hierarchy._nav')
    </div>
</div>
@endsection