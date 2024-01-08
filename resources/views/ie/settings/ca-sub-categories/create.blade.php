@extends('layouts.app')

@section('title', 'Cash Advance Sub-Categories')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm"> 
        <x-get-program-code url="/ie/settings/ca-categories" /> {{ $ca_category->name }} : Create New CA Sub-Category <br>
        <small>สร้างประเภทการเบิกเงินทดรองย่อยใหม่</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.ca-categories.index') }}"> All Cash Advane Categories </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.ca-sub-categories.index',[$ca_category->ca_category_id]) }}"> {{ $ca_category->name }} : CA Sub-Categories</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Create New CA Sub-Category</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        <strong>Create New CA Sub-Category</strong> <br>
        <small>สร้างประเภทการเบิกเงินทดรองย่อยใหม่</small>
    </h3>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                {!! Form::open(['route' => ['ie.settings.ca-sub-categories.store',$ca_category->ca_category_id], 'class' => 'form-horizontal']) !!}
                    @include('ie.settings.ca-sub-categories._form')
                    @include('ie.settings.ca-sub-categories._modal_set_account')
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection
