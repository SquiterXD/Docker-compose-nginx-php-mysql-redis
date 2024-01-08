@extends('layouts.app')

@section('title', 'OMS0020')

@section('page-title')
    <h2>OMS0020: ข้อมูลลูกค้า Direct Debit Export</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.direct-debit-export.index') }}">ข้อมูลลูกค้า Direct Debit Export</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('om.settings.direct-debit-export.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>ข้อมูลลูกค้า Direct Debit Export</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.direct-debit-export._table')
                </div>
            </div>
        </div>
    </div>
@endsection
