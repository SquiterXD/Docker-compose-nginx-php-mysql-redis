@extends('layouts.app')

@section('title', 'User')

@section('page-title')
    <x-get-page-title menu="" url="/users" />
@stop

@section('page-title-action')
    {{-- @if (canEnter('/users'))
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Create
        </a>
    @endif --}}
    @if (canEnter('/users'))
        <a href="{{ route('users.syncHr') }}" class="btn btn-info">
            <i class="fa fa-refresh" aria-hidden="true"></i> ซิงค์ข้อมูล
        </a>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Users</h5>
                </div>
                <div class="ibox-content">
                    @include('users._search_form')
                    @include('users._table')

                    <div class="m-t-sm text-right">
                        {!! $users->appends(request()->except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
