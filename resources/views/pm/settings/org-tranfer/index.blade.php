@extends('layouts.app')

@section('title', 'กำหนดคลังตัดจ่ายวัตถุดิบ/รับผลผลิต')

{{-- @section('page-title')
    <h2>
        <x-get-program-code url="/pm/settings/org-tranfer" /> : บันทึกคลังสินค้าในการรับ-ส่งข้อมูล
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Settings</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><a href="{{ route('pm.settings.org-tranfer.index') }}">บันทึกคลังสินค้าในการรับ-ส่งข้อมูล</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
    <x-get-page-title menu="" url="/pm/settings/org-tranfer" />
@stop

@section('page-title-action')
    <a href="{{ route('pm.settings.org-tranfer.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(['route' => ['pm.settings.org-tranfer.index'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}
            <org-tranfer-search :wip-transaction="{{ json_encode($wipTransaction) }}"
                :transaction-types="{{ json_encode($transactionTypes) }}"
                :tobacco-itemcats="{{ json_encode($tobaccoItemcats) }}" :search="{{ json_encode($search) }}">

            </org-tranfer-search>
            {!! Form::close() !!}
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดคลังตัดจ่ายวัตถุดิบ/รับผลผลิต</h5>
                </div>
                <div class="ibox-content">
                    @include('pm.settings.org-tranfer._table')
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end md:tw-my-0 tw-my-2 lg:tw-px-0 tw-px-2">
        {{-- {!! $setupMfgDeprtments->appends(Request::all())->links('shared._pagination') !!} --}}
    </div>
    <script type="application/javascript">
     var table;
        $(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var search = {
                wipTransaction:urlParams.get("search[wipTransaction]"), 
                itemcat:urlParams.get("search[itemcat]"), 
                transaction:urlParams.get("search[transaction]"), 
            }
            table = $('#program_info_tb_datatable').dataTable({
                ordering: false,
                searching: false,
                "serverSide": true,
                "processing": true,
                columnDefs: [
                    {target:0, className: 'tw-text-center'}
                ],
                columns: [
                    {data: '_html_enable_flag'},
                    {data: 'wip_transaction_type_name2'},
                    {data: 'tobacco_group'},
                    {data: 'from_organization_code'},
                    {data: 'from_subinventory'},
                    {data: 'from_location_code'},
                    {data: 'to_organization_code'},
                    {data: 'to_subinventory'},
                    {data: 'to_locator_code'},
                    {data: 'transaction_type_name'},
                    {data: '_html_action'},
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
