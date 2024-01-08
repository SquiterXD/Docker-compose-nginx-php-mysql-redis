@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'บันทึกรายการตัดใช้จริงวัตถุดิบ (แสตมป์)')

@section('page-title')
<h2>{{ $programCode }}
    {{-- <x-get-program-code url="/pm/wip-issue" /> --}}
     บันทึกรายการตัดใช้จริงวัตถุดิบ (แสตมป์)</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item active">
        <a>บันทึกรายการตัดใช้จริงวัตถุดิบ (แสตมป์)</a>
    </li>
</ol>
@stop
@section('page-title-action')
{{-- <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button> --}}
@stop

@section('content')

    <pm-wip-issue-stamp
        {{-- :url-get-mes-review-issue-v="{{ json_encode($urlGetMesReviewIssuesV) }}" --}}
        {{-- :url-opt="{{ json_encode($urlOpt) }}" --}}
        {{-- :url-get-oprn-by-item="{{ json_encode($urlGetOprnByItem) }}" --}}
        {{-- :url-get-formulas="{{ json_encode($urlFormulas) }}" --}}
        :user-profile="{{ json_encode($userProfile) }}"
        :trans-date="{{ json_encode(trans('date')) }}"
        {{-- :url-save-data={{ json_encode($urlSaveData) }} --}}
        :token="{{ json_encode( csrf_token()) }}"
        :mes-review-issue-headers="{{ json_encode($mesReviewIssueHeaders) }}"
        class-classification-code = "03"
        :url="{{ json_encode($url) }}"
        :sys-date="{{ json_encode(now()) }}"
        :trans-btn="{{ json_encode(trans('btn')) }}"
        :program-code="{{ json_encode($programCode) }}"
        >
    </pm-wip-issue-stamp>
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
