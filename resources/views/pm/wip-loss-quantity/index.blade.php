
@extends('layouts.app')

@section('title', 'บันทึกสูญเสีย')

@section('page-title')
    <h2><x-get-program-code url="/pm/wip-loss-quantity"/> บันทึกสูญเสีย </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>บันทึกสูญเสีย</a>
        </li>
    </ol>
@stop
@section('page-title-action')
@stop

@section('content')
<pm-wip-loss-quantity
    :p-headers="{{ json_encode($headers) }}"
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