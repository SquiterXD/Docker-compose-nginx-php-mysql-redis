@extends('layouts.app')

@section('title', 'Ex: Vue')

@section('page-title')
    <h2>รายการเบิกเครื่องเขียน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Stationery Request</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                   
                    <b>blade test</b>

                    <test-component></test-component>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
