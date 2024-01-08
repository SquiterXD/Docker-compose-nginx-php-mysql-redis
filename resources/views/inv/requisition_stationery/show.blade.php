@extends('layouts.app')

@section('title', 'RequisitionStationery || Create')

@section('page-title')
    <h2>เบิกเครื่องเขียน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Stationery</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('inv.requisition_stationery.index') }}">RequisitionStationery</a>
        </li>

        <li class="breadcrumb-item active">
            <strong>รายละเอียด</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if ($issueHeader->issue_status == 'WAITING')
        <a href="{{ route('inv.requisition_stationery.edit', [$issueHeader->issue_header_id])}}" class="btn btn-warning">แก้ไข</a>
    @endif

    <requisition-stationery-return-component
        :default-issue-header="{{json_encode($issueHeader)}}"
        :lookup-values="{{json_encode($lookupValues)}}"
        :user="{{json_encode($user)}}">
    </requisition-stationery-return-component>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <requisition-stationery-approve-component
                    :issue-header="{{json_encode($issueHeader)}}"
                    :lookup-values="{{json_encode($lookupValues)}}"
                    :user="{{json_encode($user)}}">
                </requisition-stationery-approve-component>
            </div>
        </div>
    </div>
</div>
@endsection
