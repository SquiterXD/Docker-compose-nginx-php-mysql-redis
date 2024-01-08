@extends('layouts.app')

@section('title', 'AR Oracle')

@section('page-title')
  {{-- <strong><x-get-program-code url='ir/settings/policy'/><h2>IR REPORT</h2></strong> --}}
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>IR</a>
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
                <ir-report
                    :url="{{ json_encode($url) }}"
                    :trans-date="{{ json_encode(trans('date')) }}"
                    :trans-btn="{{ json_encode(trans('btn')) }}"
                    :sys-date="{{ json_encode(now()) }}">
                </ir-report>
            </div>
          </div>
      </div>
  </div>
@endsection
