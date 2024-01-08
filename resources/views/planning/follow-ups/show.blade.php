@extends('layouts.app')

@section('title', 'ติดตามแผนการผลิตประจำปักษ์')

@section('page-title')
    <h2>
        <x-get-program-code url="/planning/follow-ups" />: ติดตามแผนการผลิตประจำปักษ์
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>กองวางแผนและบริหารการผลิต</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ติดตามแผนการผลิตประจำปักษ์</a>
        </li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    <planning-follow-ups-show
                        :follow-up="{{ json_encode($followUp) }}"
                        :modal-search-input="{{ json_encode($modalSearchInput) }}"
                        :p-data="{{ json_encode($data) }}"
                        :url="{{ json_encode($url) }}"
                        :btn-trans="{{ json_encode(trans('btn')) }}"
                        :token="{{ json_encode(csrf_token()) }}"
                    >
                    </planning-follow-ups-show>
                    {{-- <planning-adjust-show
                        :modal-search-input="{{ json_encode($modalSearchInput) }}"
                        :modal-create-input="{{ json_encode($modalCreateInput) }}"

                        p-date-format="{{ trans('date.js-format') }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        :adjust-data="{{ json_encode($adjustData) }}"
                        :url="{{ json_encode($url) }}"
                        :tabs="{{ json_encode($tabs) }}"
                        :p-default-input="{{ json_encode($defaultInput) }}"
                        :btn-trans="{{ json_encode(trans('btn')) }}"
                        :color-code="{{ json_encode($colorCode) }}"
                    /> --}}
                </div>
            </div>
        </div>
    </div>
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