@extends('layouts.app')

@section('title', 'Cash Advance Categories')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm"> 
        <div><x-get-program-code url="/ie/settings/ca-categories" /> Create New CA Category </div>
        <div><small>สร้างประเภทการเบิกเงินทดรองใหม่</small></div>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.ca-categories.index') }}"> All Categories </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Create New CA Category </strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        Create New CA Category <br>
        <small>สร้างประเภทการเบิกเงินทดรองใหม่</small>
    </h3>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                {!! Form::open(['route' => ['ie.settings.ca-categories.store'], 'class' => 'form-horizontal']) !!}
                @include('ie.settings.ca-categories._form')
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection
