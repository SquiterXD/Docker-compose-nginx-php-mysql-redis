@extends('layouts.app')
@section('title', 'PMS0033')
@section('page-title')
    <x-get-page-title menu="" url="{{ $url }}" />
@stop
@section('page-title-action')
    <a href="{{ route('pm.settings.production-formula.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i>  สร้าง
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-9">
                            <h3 class="no-margins"> สูตรการผลิต </h3>
                        </div>
                        <div class="col-3">
                            {{-- <button class="btn btn-md btn-white" data-toggle="modal" data-target="#modal-search-formula">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                            @include('pm.settings.production-formula._search_modal')
                            <a href="{{ route('pm.settings.production-formula.create') }}" class="btn btn-success">
                                <i class="fa fa-plus"></i>  สร้าง
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="ibox-content" style="border-bottom: 0px;">
                    <pm-settings-production-formula-search
                        :search_data="{{ json_encode($searchData) }}"
                        :trans_btn="{{ json_encode(trans('btn')) }}"
                        :organization_code="{{ json_encode($organizationCode) }}"
                    />
                </div>
                <div class="ibox-content">
                    @include('pm.settings.production-formula._table')
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
            table = $('#production-formula-datatable').dataTable({
                ordering: false,
                searching: false,
                "serverSide": true,
                "processing": true,
                columns: [{
                        data: '_item_number'
                    },
                    {
                        data: '_item_desc'
                    },
                    {
                        data: '_f_description'
                    },
                    {
                        data: '_routing_desc'
                    },
                    {
                        data: 'version'
                    },
                    {
                        data: '_label_status'
                    },
                    {
                        data: '_oprn_desc'
                    },
                    {
                        data: '_machineGroupF'
                    },
                    {
                        data: 'period_year'
                    },
                    {
                        data: '_start_date'
                    },
                    {
                        data: '_end_date'
                    },
                    {
                        data: '_action'
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
