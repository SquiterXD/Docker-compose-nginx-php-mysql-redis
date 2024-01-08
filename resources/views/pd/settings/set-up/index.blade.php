@extends('layouts.app')

{{-- @section('title', 'Ex: User')

@section('page-title')
    <h2>Example: Users</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Example</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Users</strong>
        </li>
    </ol>
@stop --}}

{{-- @section('page-title-action')
    <a href="{{ route('pd.settings.job-type.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create
    </a>
@stop --}}

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>ตั้งค่า</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        @include('pd.settings.set-up._table_program_name')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
