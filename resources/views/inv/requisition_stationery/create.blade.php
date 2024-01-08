@extends('layouts.app')

@section('title', 'RequisitionStationery || Create')

@section('page-title')
    <h2>รายการเบิกเครื่องเขียน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Stationery</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('inv.requisition_stationery.index') }}">Stationery Request</a>
        </li>

        <li class="breadcrumb-item active">
            <strong>Create</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <requisition-stationery-create-component 
                        :create="true"
                        :department="{{json_encode($departmentUser)}}">
                    </requisition-stationery-create-component>                   
                </div>
            </div>
        </div>
    </div>
@endsection