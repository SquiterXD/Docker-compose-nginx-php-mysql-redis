@extends('layouts.app')

@section('title', 'Role')

@section('page-title')
    <h2><x-get-program-code url="/roles" /> Role: Create</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('roles.index') }}">roles</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>create</strong>
        </li>
    </ol>
@stop


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Roles</h5>
                </div>
                <div class="ibox-content">
                    <role-component
                        :p-module-list="{{ json_encode($moduleList) }}"
                        p-role-route="{{ route('roles.index') }}"
                        p-role-store-route="{{ route('ajax.roles.store') }}"
                        p-menu-by-module-route="{{ route('ajax.roles.get-menu-by-module') }}"
                        p-permission-route="{{ route('ajax.roles.get-permission') }}"
                    ></role-component>
                </div>
            </div>
        </div>
    </div>
@endsection
