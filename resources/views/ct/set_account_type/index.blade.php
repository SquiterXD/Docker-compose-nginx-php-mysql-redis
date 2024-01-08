@extends('layouts.app')

@section('title', 'กำหนดบัญชีและหน่วยงาน')

@section('page-title')
    <h2>กำหนดบัญชีและหน่วยงาน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Set Account Type</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <set-account-type-list-component></set-account-type-list-component>
                </div>
            </div>
        </div>
    </div>
@endsection
