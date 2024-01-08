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
            <strong><x-get-program-code url="/pm/settings/print-machine-group" /> : กำหนดกลุ่มเครื่องจักรกับเครื่องจักร</strong>
        </li>
    </ol>
@stop

{{-- @section('page-title-action')

@stop --}}

@section('content')
    <div class="row">
        <machine-group-table-lookup :lookup-machine-group = "{{ json_encode($lookupMachineGroup) }}"
                                    :print-types = "{{ json_encode($printTypes ?? []) }}"
                                    :asset-list = "{{ json_encode($assetList) }}"
                                    :btn-trans = "{{ json_encode($btnTrans) }}">
        </machine-group-table-lookup>
        {{-- <machine-group-table-setup  :print-machine-group = "{{ json_encode($printMachineGroup) }}"
                                    :lookup-machine-group = "{{ json_encode($lookupMachineGroup) }}"
                                    :asset-list = "{{ json_encode($assetList) }}">
            
        </machine-group-table-setup> --}}
    </div>
@endsection