@extends('layouts.app')

@section('title', 'บันทึกคลังเบิกวัตถุดิบ')

{{-- @section('page-title')
    <h2><strong><x-get-program-code url='/pm/settings/setup-transfer'/> : บันทึกคลังเบิกวัตถุดิบ</strong></h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>PM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <strong><x-get-program-code url='/pm/settings/setup-transfer'/> : บันทึกคลังเบิกวัตถุดิบ</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
    <x-get-page-title menu="" url="/pm/settings/setup-transfer" />
@stop

@section('page-title-action')
    <a href="{{ route('pm.settings.setup-transfer.create') }}" class="{{ $btnTrans['create']['class'] }}">
        <i class="{{ $btnTrans['create']['icon'] }}"></i> {{ $btnTrans['create']['text'] }}
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {{-- filter --}}
            {!! Form::open(['route' => ['pm.settings.org-tranfer.index'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}
            <setup-transfer-search :filterItemCat="{{ $filterItemCat }}" :filterSetupTransferLocV="{{ $filterSetupTransferLocV }}">
            </setup-transfer-search>
            {!! Form::close() !!}
            {{-- end filter --}}

            <div class=" m-t-lg">
                <h1 class="tw-mt-0"></h1>
                <div class="ibox-title"><h5>กำหนดคลังเก็บวัตถุดิบ</h5></div>
                <div class="ibox-content ">
                    @include('pm.settings.setup-transfer._table')
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        var table;
           $(function() {
               var urlParams = new URLSearchParams(window.location.search);
               var search = {
                   tsm:urlParams.get("tsm"), 
                   ty:urlParams.get("ty"), 
               }
               table = $('#program_info_tb_datatable').dataTable({
                   ordering: false,
                   searching: false,
                   "serverSide": true,
                   "processing": true,
                   columns: [
                       {data: '_html_enable_flag'},
                       {data: 'organization_code'},
                       {data: 'request_type'},
                       {data: 'item_cat_code'},
                       {data: 'description'},
                       {data: 'to_organization_code_organization_name'},
                       {data: 'to_subinventory_code'},
                       {data: 'to_locator_segment2'},
                       {data: 'action'},
                   ],
                   "ajax": {
                       "url": "",
                       "dataType": "json",
                       "type": "GET",
                       "data": {
                           _token: "{{ csrf_token() }}",
                        //    search: search,
                       }
                   },
               })
           })
       </script>
@endsection
