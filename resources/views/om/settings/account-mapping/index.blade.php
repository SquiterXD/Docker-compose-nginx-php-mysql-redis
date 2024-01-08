@extends('layouts.app')

@section('title', 'OMS0017')

@section('page-title')
    <h2>OMS0017: กำหนด Account Aliases</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>OM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('om.settings.account-mapping.index') }}">OMS0017: กำหนด Account Aliases</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('om.settings.account-mapping.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                       <form action="" method="GET" autocomplete="off">
                            <om-search-account :accounts="{{ json_encode($accounts) }}"
                                            :action-url="{{ json_encode(route('om.settings.account-mapping.index')) }}">
                            </om-search-account>
                        </form>                    
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="m-t-lg">
                    <div class="ibox-title">
                        <div class="ibox-tools"></div>
                        <h5>กำหนด Account Aliases</h5>
                    </div>
                    <div class="ibox-content">
                        @include('om.settings.account-mapping._table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

