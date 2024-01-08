@extends('layouts.app')

@section('title', 'Cash Advance Sub-Categories')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm"> 
        <x-get-program-code url="/ie/settings/ca-categories" /> {{ $ca_category->name }} : CA Sub-Categories <br>
        <small>แก้ไขข้อมูลประเภทการเบิกเงินทดรองย่อย</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.ca-categories.index') }}"> All Cash Advance Categories </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.ca-sub-categories.index',[$ca_category->ca_category_id]) }}"> {{ $ca_category->name }} : CA Sub-Categories</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Edit CA Sub-Category : {{ $ca_sub_category->name }}</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        <strong>Edit CA Sub-Category : {{ $ca_sub_category->name }}</strong> <br>
        <small>แก้ไขข้อมูลประเภทการเบิกเงินทดรองย่อย</small>
    </h3>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                {!! Form::model($ca_sub_category, ['route' => ['ie.settings.ca-sub-categories.update', $ca_category->ca_category_id, $ca_sub_category->ca_sub_category_id], 'class' => 'form-horizontal', 'method' => 'patch'] ) !!}
                    @include('ie.settings.ca-sub-categories._form')
                    @include('ie.settings.ca-sub-categories._modal_set_account')
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection

