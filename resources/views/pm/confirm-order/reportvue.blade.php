@extends('layouts.app')

@section('title', 'User')

@section('page-title')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ใบโอนวัตถุดิบ/วัสดุเพื่อใช้ในการผลิต</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if (canEnter('/users'))
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Create
        </a>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <sample-reportvue></sample-reportvue>
        </div>
    </div>
@endsection
