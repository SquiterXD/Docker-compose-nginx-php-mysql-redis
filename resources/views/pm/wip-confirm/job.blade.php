
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
<pm-wip-confirm-job
    :p-header="{{ json_encode($header) }}"
    :lines="{{ json_encode($lines) }}"
    :profile="{{ json_encode($profile) }}"
    {{-- :job-summary="{{ json_encode($jobSummary) }}" --}}
    :opts="{{ json_encode($opts) }}"
    :headerids="{{ json_encode($jobHeaderIds) }}"
    :p-from-date="{{ json_encode($fromDate) }}"
    :p-to-date="{{ json_encode($toDate) }}"

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