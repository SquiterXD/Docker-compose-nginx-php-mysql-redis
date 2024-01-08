@extends('layouts.app')

@section('title', 'INV Fuel Gas')
    
@section('page-title')
    <h2>เบิกจ่ายน้ำมันเชื้อเพลิง</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Fuel</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>เบิกจ่ายน้ำมันเชื้อเพลิง</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <disbursement-fuel-create-component
                        :web-fuel-oils="{{json_encode($webFuelOils)}}"
                    ></disbursement-fuel-create-component> 
                </div>
            </div>
        </div>
    </div>
@endsection
