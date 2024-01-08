@extends('layouts.app')

@section('title', 'กำหนดหน่วยงาน')

@section('page-title')
    <h2>กำหนดหน่วยงาน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดหน่วยงาน</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                  <specify-agency-component></specify-agency-component>
                </div>
            </div>
        </div>
    </div>
@endsection
