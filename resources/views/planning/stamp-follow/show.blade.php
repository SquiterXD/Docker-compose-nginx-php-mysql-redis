@extends('layouts.app')

@section('title', 'ติดตามการใช้แสตมป์รายวัน')

@section('page-title')
    <h2>
        <x-get-program-code url="/planning/stamp-follow" />: ติดตามการใช้แสตมป์รายวัน
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>กองวางแผนและบริหารการผลิต</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ติดตามการใช้แสตมป์รายวัน</a>
        </li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    <planning-stamp-follow
                        :header="{{ json_encode($header) }}"
                        :create-input="{{ json_encode($createInput) }}"
                        :search-input="{{ json_encode($searchInput) }}"
                        :profile="{{ json_encode($profile) }}"
                        :default-search="{{ json_encode($defaultSearch) }}"
                        date-format="{{ json_encode($dateFormat) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :url="{{ json_encode($url) }}"
                        :users="{{ json_encode($users) }}"
                        :interface-temps="{{ json_encode($interfaceTemps) }}"
                        :po-lists="{{ json_encode($poLists) }}"
                        :last-date="{{ json_encode($lastDateOfMonth) }}"
                    >
                    </planning-stamp-follow>
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