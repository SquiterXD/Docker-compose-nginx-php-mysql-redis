@extends('layouts.app')

@section('title', 'กำหนดเปอร์เซ็นเทียบสำเร็จ')

@section('page-title')
    <h2>กำหนดเปอร์เซ็นเทียบสำเร็จ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดเปอร์เซ็นเทียบสำเร็จ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <specify-percentage-create-component></specify-percentage-create-component>
                </div>
            </div>
        </div>
    </div>
@endsection
