@extends('layouts.app')

@section('title', 'INV Fuel Gas')
    
@section('page-title')
    <h2>เรียกเอกสาร</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Fuel</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>เรียกเอกสาร</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <disbursement-fuel-report-component></disbursement-fuel-report-component> 
                </div>
            </div>
        </div>
    </div>
@endsection
