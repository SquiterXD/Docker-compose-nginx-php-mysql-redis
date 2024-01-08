@extends('layouts.app')

@section('title', 'Report')

@section('page-title')
  {{-- <strong><x-get-program-code url='ir/settings/policy'/><h2>IR REPORT</h2></strong> --}}
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
        <a>Report</a>
    </li>
    <li class="breadcrumb-item active">
      {{-- <strong><x-get-program-code url='ir/settings/policy'/>Interface to AR Oracle</strong> --}}
    </li>
  </ol>
@stop

@section('page-title-action')

@stop

@section('content')
  <div class="row">
      <div class="col-lg-12">
          <div class="ibox">
            <div class="ibox-content">
              {{-- {{ dd(route('report.report-info.index', ['program_code' => 'program-code'])) }} --}}
                <report-info
                    :trans-date="{{ json_encode(trans('date')) }}"
                    :trans-btn="{{ json_encode(trans('btn')) }}"
                    :sys-date="{{ json_encode(now()) }}"
                    :url="{{ json_encode($url) }}"
                    :url-ger-param="{{ json_encode(route('report.ajax.get-report-programs')) }}"
                    :url-sub-query="{{ json_encode(route('report.ajax.report-get-sub-query')) }}"
                    :module="{{ json_encode(null) }}"
                    :default-program-code="{{ json_encode(request()->program_code) }}"
                    >
                </report-info>
            </div>
          </div>
      </div>
  </div>
@endsection
