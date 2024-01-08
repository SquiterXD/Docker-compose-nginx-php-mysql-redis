@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'บันทึกตัดใช้วัตถุดิบ')

@section('page-title')
<h2>
    {{ $programCode }} วางแผนการผลิตยาเส้นภูมิภาค/หน่วยบรรจุภูมิภาค
    {{-- <h2>
        <x-get-program-code url="/pm/wip-issue" /> บันทึกตัดใช้วัตถุดิบ
    </h2> --}}
</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item active">
        <a>วางแผนการผลิตยาเส้นภูมิภาค/หน่วยบรรจุภูมิภาค</a>
    </li>
</ol>
@stop
@section('page-title-action')
@stop

@section('content')
    <pmp-0031-index
        :user-profile="{{ json_encode($userProfile) }}"
        :trans-date="{{ json_encode(trans('date')) }}"
        :token="{{ json_encode( csrf_token()) }}"
        :url="{{ json_encode($url) }}"
        :sys-date="{{ json_encode(now()) }}"
        :trans-btn="{{ json_encode(trans('btn')) }}"
        :program-code="{{ json_encode($programCode) }}"
        >
    </pmp-0031-index>
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
