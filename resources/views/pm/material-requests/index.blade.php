
@extends('layouts.app')

@section('title', 'สร้างใบเบิกวัตถุดิบ (จัดหา)')

@section('page-title')
    <h2><x-get-program-code url="/pm/material-requests"/> สร้างใบเบิกวัตถุดิบ (จัดหา)</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>สร้างใบเบิกวัตถุดิบ (จัดหา)</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    {{-- <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button> --}}
@stop

@section('content')
<pm-material-requests-index

    :p-header="{{ json_encode($header) }}"
    :lines="{{ json_encode($lines) }}"
    :data="{{ json_encode($data) }}"
    :profile="{{ json_encode($profile) }}"

    :old-iput="{{ json_encode(count(old()) ? old() : request()->all()) }}"
    :trans-date="{{ json_encode(trans('date')) }}"
    :trans-btn="{{ json_encode(trans('btn')) }}"
    :url="{{ json_encode($url) }}"
    :p-request="{{ json_encode(request()->all()) }}"
/>
@endsection
@section('scripts')

@stop