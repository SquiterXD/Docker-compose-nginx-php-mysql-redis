@extends('layouts.app')

@section('title', 'Role')

@section('page-title')
    <h2>
        <x-get-program-code url="/roles" />: Roles
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Roles</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if (canEnter('/roles') || true)
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Create
        </a>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Role</h5>
                </div>
                <div class="ibox-content">
                    @include('roles._table')
                </div>
            </div>
        </div>
    </div>
@endsection
