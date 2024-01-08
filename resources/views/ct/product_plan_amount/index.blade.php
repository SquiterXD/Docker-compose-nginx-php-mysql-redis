@extends('layouts.app')

@section('title', 'กำหนดปริมาณผลผลิตตามแผน')

@section('page-title')
    <h2>กำหนดปริมาณผลผลิตตามแผน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดปริมาณผลผลิตตามแผน</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <product-plan-amount-component></product-plan-amount-component>
                </div>
            </div>
        </div>
    </div>
@endsection
