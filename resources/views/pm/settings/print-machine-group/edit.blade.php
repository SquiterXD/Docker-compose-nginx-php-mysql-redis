@extends('layouts.app')

@section('title', 'กำหนดกลุ่มเครื่องจักรกับเครื่องจักร')

@section('page-title')
    <h2>
        <x-get-program-code url="/pm/settings/print-machine-group" /> : กำหนดกลุ่มเครื่องจักรกับเครื่องจักร
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <x-get-program-code url="/pm/settings/print-machine-group" /> : กำหนดกลุ่มเครื่องจักรกับเครื่องจักร
        </li>
        <li class="breadcrumb-item active">
            <strong>แก้ไข</strong>
        </li>
    </ol>
@stop

{{-- @section('page-title-action')

@stop --}}

@section('content')
    <div class="row">
        <machine-group-edit :data-machine-group = "{{ json_encode($dataMachineGroup) }}"
                            :print-types = "{{ json_encode($printTypes ?? []) }}"
                            :lookup-machine-group = "{{ json_encode($lookupMachineGroup) }}"
                            :asset-list = "{{ json_encode($assetList) }}">
        </machine-group-edit>
    </div>
@endsection