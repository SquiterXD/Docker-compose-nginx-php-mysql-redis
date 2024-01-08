
@extends('layouts.app')

@section('title', 'รายงานผลผลิต')

@section('page-title')
    @if($reportCode == 'PDR1150')
        <h2><x-get-program-code url="/pm/wip-confirm/export-pdf-parameters/PDR1150"/>รายงานผลผลิตประจำวันแยกตามคำสั่งการผลิต</h2>
    @endif
    @if($reportCode == 'PDR1180')
        <h2><x-get-program-code url="/pm/wip-confirm/export-pdf-parameters/PDR1180"/>รายงานผลผลิตประจำวันแยกตามวันที่ผลิต</h2>
    @endif
    @if($reportCode == 'PDR2040')
        <h2><x-get-program-code url="/pm/wip-confirm/export-pdf-parameters/PDR2040"/>รายงานผลผลิตประจำวันยอดรวม</h2>
    @endif
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>รายงานผลผลิต</a>
        </li>
    </ol> --}}
@stop

@section('page-title-action')
@stop

@section('content')
    {!! Form::open(['route' => ['pm.wip-confirm.export-pdf'], 'method' => 'post'] ) !!}
    {!! Form::hidden('report_code', $reportCode) !!}
    <pm-export-parameters
        :p-from-date="{{ json_encode($fromDate) }}"
        :p-to-date="{{ json_encode($toDate) }}"
        :p-batch-no-lists="{{ json_encode($batchNoLists) }}"
        {{-- :p-wip-step-lists="{{ json_encode($wipStepLists) }}" --}}
        {{-- :p-item-number-lists="{{ json_encode($itemNumberLists) }}" --}}
        :trans-date="{{ json_encode(trans('date')) }}"
        :trans-btn="{{ json_encode(trans('btn')) }}"
        :url="{{ json_encode($url) }}"
        :p-profile="{{ json_encode($profile) }}"
        :p-report-code="{{ json_encode($reportCode) }}"
    />
    {!! Form::close()!!}
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
