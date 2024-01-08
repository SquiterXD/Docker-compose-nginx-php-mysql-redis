@extends('layouts.app')

@section('title', 'ต้นทุนขายแยกแสตมป์และกองทุน')

@section('page-title')
    <h2>
        <x-get-program-code url="/ct/stamp-adjust/process" />: ต้นทุนขายแยกแสตมป์และกองทุน
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a>Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ต้นทุนขายแยกแสตมป์และกองทุน</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if(canEnter('/ct/stamp-adjust/process'))
        <div>
            <stamp-adjust-create :btn-trans="{{ json_encode(trans('btn')) }}"
                                :period-years="{{ json_encode($periodYears) }}">
            </stamp-adjust-create>
        </div>
    @endif
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    <stamp-adjust-process
                        :period-years="{{ json_encode($periodYears) }}"
                        :setup-stamps="{{ json_encode($setupStamps) }}"
                        :stamp-cigarets="{{ json_encode($stampCigarets) }}"
                        :percent-cigarets="{{ json_encode($percentCigarets) }}"
                        :setup-tobaccos="{{ json_encode($setupTobaccos) }}"
                        :stamp-tobaccos="{{ json_encode($stampTobaccos) }}"
                        :percent-tobaccos="{{ json_encode($percentTobaccos) }}"
                        :url="{{ json_encode($url) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :interface-gl-flag="{{ json_encode($interfaceGLFlag) }}"
                        :stamps="{{ json_encode($stamps) }}"
                        :manual-temps="{{ json_encode($manualTemps) }}"

                        period-year-value="{{ isset($searchInputs['period_year'])? $searchInputs['period_year']: '' }}"
                        period-name-value="{{ isset($searchInputs['period_name'])? $searchInputs['period_name']: '' }}"
                    >
                    </stamp-adjust-process>
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