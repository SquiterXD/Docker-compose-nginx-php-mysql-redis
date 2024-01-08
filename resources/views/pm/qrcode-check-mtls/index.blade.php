
@extends('layouts.app')

@section('title', 'การขอเบิกวัตถุดิบนอกแผน')

@section('page-title')
    {{-- <h2><x-get-program-code url="/pm/material-requests"/> การขอเบิกวัตถุดิบนอกแผน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>การขอเบิกวัตถุดิบนอกแผน</a>
        </li>
    </ol> --}}
@stop
@section('page-title-action')
    {{-- <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button> --}}
@stop

@section('content')
        <qrcode-check-mtls-index
            :data="{{ json_encode($data) }}"
            :old-iput="{{ json_encode(count(old()) ? old() : request()->all()) }}"
            :trans-date="{{ json_encode(trans('date')) }}"
            :trans-btn="{{ json_encode(trans('btn')) }}"
            :url="{{ json_encode($url) }}"
            :p-request="{{ json_encode(request()->all()) }}"
        />
@endsection
@section('scripts')
    {{-- <script type="text/javascript">
        setTimeout( function() {
            var body = $('body');
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            }
        },500)
    </script> --}}
@stop