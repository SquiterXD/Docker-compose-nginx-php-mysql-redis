@extends('layouts.app')
@section('title', 'PMS0028')
@section('page-title')
    <h2>PMS0028: กำหนดชุดเครื่องจักร</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>PM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('pm.settings.machine-relation.index') }}">กำหนดชุดเครื่องจักร</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    <a href="{{ route('pm.settings.machine-relation.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop


@section('content')
    <div class="row">
        <div class="col-lg-12">

            <machine-relation-search>
            </machine-relation-search>

            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดชุดเครื่องจักร</h5>
                </div>
                <div class="ibox-content">
                    @include('pm.settings.machine-relation._table')
                </div>
            </div>
        </div>
    </div>


    <script type="application/javascript">
        var table;
        $(function() {
            $.fn.dataTable.ext.errMode = 'none';
            var urlParams = new URLSearchParams(window.location.search);
            var search = {
                machineGroup: urlParams.get("machineGroup"),
                LineMf: urlParams.get("LineMf"),
                work: urlParams.get("work"),
                machine: urlParams.get("machine"),
            }
            table = $('#machine-relation-datatable').dataTable({
                ordering: false,
                searching: false,
                "serverSide": true,
                "processing": true,
                columns: [{
                        data: '_html_enable_flag'
                    },
                    {
                        data: 'machine_group_desc'
                    },
                    {
                        data: 'machine_set'
                    },
                    {
                        data: 'machine_description'
                    },
                    {
                        data: '_html_machineType'
                    },
                    {
                        data: 'step_description'
                    },
                    {
                        data: 'machine_speed'
                    },
                    {
                        data: 'speed_unit_desc'
                    },
                    {
                        data: 'machine_eamperformance'
                    },
                    {
                        data: 'action'
                    },
                ],
                "ajax": {
                    "url": "",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        search: search,
                    }
                },
            })
        })
    </script>
@endsection
