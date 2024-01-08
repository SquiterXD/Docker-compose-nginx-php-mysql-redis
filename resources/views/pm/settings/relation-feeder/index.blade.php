@extends('layouts.app')

@section('title', 'ความสัมพันธ์การจ่าย')

@section('page-title')
    <h2><x-get-program-code url="/pm/settings/relation-feeder"/> : ความสัมพันธ์การจ่าย</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>PM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <strong>
                <a href="{{ route('pm.settings.relation-feeder.index') }}">
                    <x-get-program-code url="/pm/settings/relation-feeder"/> : ความสัมพันธ์การจ่าย
                </a>
            </strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a  href="{{ route('pm.settings.relation-feeder.create') }}" 
        class="{{ $btnTrans['create']['class'] }}">
        <i class="{{ $btnTrans['create']['icon'] }}"></i> {{ $btnTrans['create']['text'] }} 
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center m-t-lg">
                <h1 class="tw-mt-0"></h1>
                <div class="ibox-content">
                    @include('pm.settings.relation-feeder._table')
                </div>
            </div>
        </div>
    </div>
@endsection