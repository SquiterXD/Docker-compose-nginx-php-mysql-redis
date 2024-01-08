
@extends('layouts.app')

@section('title', 'บันทึกผลผลิตประจำวัน')

@section('page-title')
    <h2><x-get-program-code url="/pm/wip-confirm"/> บันทึกผลผลิตประจำวัน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>บันทึกผลผลิตประจำวัน</a>
        </li>
    </ol>
@stop
@section('page-title-action')
@stop

@section('content')
<pm-wip-confirm-daily
    :profile="{{ json_encode($profile) }}"

    :p-from-date="{{ json_encode($fromDate) }}"
    :p-to-date="{{ json_encode($toDate) }}"

    p-date-start=""
    p-date-end=""

    :old-iput="{{ json_encode(count(old()) ? old() : request()->all()) }}"
    :trans-date="{{ json_encode(trans('date')) }}"
    :trans-btn="{{ json_encode(trans('btn')) }}"
    :url="{{ json_encode($url) }}"
/>
@endsection
@section('scripts')
    <script type="text/javascript">
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
    </script>
@stop